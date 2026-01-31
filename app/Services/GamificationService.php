<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Achievement;
use App\Models\User;
use App\Models\UserAchievement;
use App\Models\UserStreak;
use App\Models\Article;
use App\Models\AiGeneration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

/**
 * GamificationService - Points, Achievements, Streaks, Leaderboards
 */
class GamificationService
{
    /**
     * Award points for an action
     */
    public function awardPoints(User $user, string $action, int $amount = null): int
    {
        $pointValues = [
            'article_created' => 10,
            'article_edited' => 2,
            'article_viewed' => 1,
            'ai_generation' => 5,
            'daily_login' => 1,
        ];

        $points = $amount ?? ($pointValues[$action] ?? 0);
        
        $user->increment('reputation_score', $points);
        
        // Check for achievements after awarding points
        $this->checkAchievements($user);
        
        return $points;
    }

    /**
     * Update user's streak
     */
    public function updateStreak(User $user): void
    {
        $streak = UserStreak::firstOrCreate(
            ['user_id' => $user->id, 'type' => 'daily'],
            ['current_streak' => 0, 'longest_streak' => 0]
        );

        $today = now()->toDateString();
        $lastActivity = $streak->last_activity_date?->toDateString();

        if ($lastActivity === $today) {
            // Already active today
            return;
        }

        if ($lastActivity === now()->subDay()->toDateString()) {
            // Continuing streak
            $streak->current_streak++;
        } else {
            // Streak broken, start new one
            $streak->current_streak = 1;
        }

        // Update longest streak if current is higher
        if ($streak->current_streak > $streak->longest_streak) {
            $streak->longest_streak = $streak->current_streak;
        }

        $streak->last_activity_date = $today;
        $streak->save();

        // Check streak achievements
        $this->checkStreakAchievements($user, $streak->current_streak);
    }

    /**
     * Check and award achievements
     */
    public function checkAchievements(User $user): array
    {
        $awarded = [];
        $achievements = Achievement::where('is_active', true)->get();

        foreach ($achievements as $achievement) {
            if ($this->hasAchievement($user, $achievement)) {
                continue;
            }

            if ($this->meetsRequirements($user, $achievement)) {
                $this->awardAchievement($user, $achievement);
                $awarded[] = $achievement;
            }
        }

        return $awarded;
    }

    /**
     * Check if user has an achievement
     */
    public function hasAchievement(User $user, Achievement $achievement): bool
    {
        return UserAchievement::where('user_id', $user->id)
            ->where('achievement_id', $achievement->id)
            ->whereNotNull('earned_at')
            ->exists();
    }

    /**
     * Check if user meets achievement requirements
     */
    private function meetsRequirements(User $user, Achievement $achievement): bool
    {
        $requirements = $achievement->requirements ?? [];

        foreach ($requirements as $key => $value) {
            switch ($key) {
                case 'articles_created':
                    if (Article::where('user_id', $user->id)->count() < $value) {
                        return false;
                    }
                    break;

                case 'edits_made':
                    // Assuming we track edits somewhere
                    if (($user->edits_count ?? 0) < $value) {
                        return false;
                    }
                    break;

                case 'streak_days':
                    $streak = UserStreak::where('user_id', $user->id)->where('type', 'daily')->first();
                    if (!$streak || $streak->current_streak < $value) {
                        return false;
                    }
                    break;

                case 'total_views':
                    $totalViews = Article::where('user_id', $user->id)->sum('view_count');
                    if ($totalViews < $value) {
                        return false;
                    }
                    break;

                case 'ai_generations':
                    if (AiGeneration::where('user_id', $user->id)->count() < $value) {
                        return false;
                    }
                    break;

                case 'joined_before':
                    if ($user->created_at > $value) {
                        return false;
                    }
                    break;
            }
        }

        return true;
    }

    /**
     * Award an achievement to a user
     */
    private function awardAchievement(User $user, Achievement $achievement): void
    {
        UserAchievement::updateOrCreate(
            ['user_id' => $user->id, 'achievement_id' => $achievement->id],
            ['earned_at' => now(), 'progress' => 100]
        );

        // Award achievement points
        $user->increment('reputation_score', $achievement->points);
    }

    /**
     * Check streak-specific achievements
     */
    private function checkStreakAchievements(User $user, int $streak): void
    {
        $achievements = Achievement::where('category', 'streak')
            ->where('is_active', true)
            ->get();

        foreach ($achievements as $achievement) {
            $required = $achievement->requirements['streak_days'] ?? 0;
            if ($streak >= $required && !$this->hasAchievement($user, $achievement)) {
                $this->awardAchievement($user, $achievement);
            }
        }
    }

    /**
     * Get user's achievements
     */
    public function getUserAchievements(User $user): array
    {
        return UserAchievement::where('user_id', $user->id)
            ->whereNotNull('earned_at')
            ->with('achievement')
            ->orderByDesc('earned_at')
            ->get()
            ->toArray();
    }

    /**
     * Get user's stats
     */
    public function getUserStats(User $user): array
    {
        $streak = UserStreak::where('user_id', $user->id)->where('type', 'daily')->first();
        
        return [
            'points' => $user->reputation_score ?? 0,
            'articles_count' => Article::where('user_id', $user->id)->count(),
            'achievements_count' => UserAchievement::where('user_id', $user->id)->whereNotNull('earned_at')->count(),
            'current_streak' => $streak->current_streak ?? 0,
            'longest_streak' => $streak->longest_streak ?? 0,
            'rank' => $this->getUserRank($user),
        ];
    }

    /**
     * Get user's rank
     */
    public function getUserRank(User $user): int
    {
        return User::where('reputation_score', '>', $user->reputation_score ?? 0)->count() + 1;
    }

    /**
     * Get leaderboard (Elite Contributors)
     */
    public function getLeaderboard(int $limit = 10, string $period = 'all'): array
    {
        $query = User::query()
            ->select('users.*')
            ->addSelect(DB::raw('(SELECT COUNT(*) FROM articles WHERE articles.user_id = users.id) as articles_count'))
            ->addSelect(DB::raw('(SELECT COUNT(*) FROM user_achievements WHERE user_achievements.user_id = users.id AND earned_at IS NOT NULL) as achievements_count'));

        if ($period !== 'all') {
            $date = match($period) {
                'weekly' => now()->subWeek(),
                'monthly' => now()->subMonth(),
                default => now()->subYear(),
            };
            
            // For periodic leadership, we focus on RECENT activity (edits/creations)
            // Simplified: Order by recently updated articles count for now, 
            // since we don't have a dedicated points_log table yet.
             $query->addSelect(DB::raw("(SELECT COUNT(*) FROM revisions WHERE revisions.user_id = users.id AND revisions.created_at >= '{$date}') as recent_edits"))
                   ->orderByDesc('recent_edits');
        } else {
            $query->orderByDesc('reputation_score');
        }

        return $query->limit($limit)->get()->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'avatar' => $user->profile_photo_url,
                'level' => floor(($user->reputation_score ?? 0) / 100) + 1,
                'reputation_score' => $user->reputation_score ?? 0,
                'articles_count' => $user->articles_count,
            ];
        })->toArray();
    }

    /**
     * Get Top Nodes (Rankings Table)
     */
    public function getTopNodes(string $category = 'all', string $sort = 'impact', int $limit = 20): array
    {
        $query = Article::with('user')->where('status', 'published');

        // Apply Category Filter
        if ($category !== 'all') {
            $catMap = [
                'recordings' => 'song',
                'artist profiles' => 'artist',
                'classifications' => 'genre'
            ];
            if (isset($catMap[strtolower($category)])) {
                $query->where('category', $catMap[strtolower($category)]);
            } else {
                $query->where('category', $category);
            }
        }

        // Apply Sorting
        switch (strtolower($sort)) {
            case 'metadata growth': // Newest or most revisions
                $query->orderByDesc('updated_at');
                break;
            case 'total connections': // Total Views or Links (using views for now)
                $query->orderByDesc('view_count');
                break;
            case 'impact score':
            default:
                // Impact = Views + (Revisions * 10)
                // We'll approximate this with views for now to keep query simple, 
                // or use a raw sort if needed.
                $query->orderByDesc('view_count');
                break;
        }

        return $query->limit($limit)->get()->map(function($article) {
            // Mock growth/impact data for UI if not strictly tracking it
            $growth = rand(1, 30); 
            $impact = min(100, floor(($article->view_count / 100) * 10) + 50); 
            
            return [
                'id' => $article->id,
                'title' => $article->title,
                'slug' => $article->slug,
                'cat' => ucfirst($article->category),
                'reach' => $this->formatNumber($article->view_count),
                'growth' => "+{$growth}%", // Placeholder for now
                'impact' => $impact,
                'user' => $article->user->name ?? 'System',
                'created_at' => $article->created_at->format('M d, Y'),
            ];
        })->toArray();
    }

    private function formatNumber(int $num): string
    {
        if ($num > 1000000) return round($num / 1000000, 1) . 'M';
        if ($num > 1000) return round($num / 1000, 1) . 'K';
        return (string)$num;
    }
}
