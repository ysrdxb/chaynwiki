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
                    $totalViews = Article::where('user_id', $user->id)->sum('views');
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
     * Get leaderboard
     */
    public function getLeaderboard(int $limit = 10, string $period = 'all'): array
    {
        $query = User::query()
            ->select('users.*')
            ->addSelect(DB::raw('(SELECT COUNT(*) FROM articles WHERE articles.user_id = users.id) as articles_count'))
            ->addSelect(DB::raw('(SELECT COUNT(*) FROM user_achievements WHERE user_achievements.user_id = users.id AND earned_at IS NOT NULL) as achievements_count'))
            ->orderByDesc('reputation_score')
            ->limit($limit);

        return $query->get()->toArray();
    }
}
