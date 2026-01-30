<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * TrendingService - The Intelligence behind "The Beat of the Moment"
 * 
 * Implements the trending algorithm defined in prompt.md:
 * trending_score = ((recent_views * 0.4) + (edit_frequency * 0.2) + (comment_activity * 0.2) + 
 *                   (bookmark_rate * 0.1) + (external_traffic * 0.1)) * recency_multiplier
 */
class TrendingService
{
    /**
     * Calculate and update trending scores for all published articles
     */
    public function updateAllScores(): int
    {
        $articles = Article::where('status', 'published')->get();
        $updatedCount = 0;

        foreach ($articles as $article) {
            $score = $this->calculateScore($article);
            $article->update(['trending_score' => $score]);
            $updatedCount++;
        }

        return $updatedCount;
    }

    /**
     * Calculate trending score for a single article
     */
    public function calculateScore(Article $article): float
    {
        // 1. Recent Views (40%)
        $recentViews = DB::table('views')
            ->where('article_id', $article->id)
            ->where('created_at', '>=', now()->subHours(48))
            ->count();
            
        // 2. Edit Frequency (20%)
        $recentEdits = DB::table('revisions')
            ->where('article_id', $article->id)
            ->where('created_at', '>=', now()->subDays(7))
            ->count();
            
        // 3. Comment Activity (20%)
        $recentComments = DB::table('comments')
            ->where('article_id', $article->id)
            ->where('created_at', '>=', now()->subDays(7))
            ->count();
            
        // 4. Bookmark Rate (10%)
        $bookmarks = DB::table('bookmarks')
            ->where('article_id', $article->id)
            ->count();
            
        // 5. External Traffic Placeholder (10%) - Simulated
        $externalTraffic = rand(0, 50);

        // Raw Score calculation
        $rawScore = (
            ($recentViews * 0.4) +
            ($recentEdits * 2.0 * 0.2) + // Heavily weight edits
            ($recentComments * 1.5 * 0.2) + 
            ($bookmarks * 0.1) +
            ($externalTraffic * 0.1)
        );

        // Recency Multiplier (Newer articles get a boost)
        $daysOld = $article->created_at->diffInDays(now());
        $recencyMultiplier = max(0.5, 1.5 - ($daysOld / 30));

        return round($rawScore * $recencyMultiplier, 4);
    }

    /**
     * Record a view for an article
     */
    public function logView(int $articleId, ?int $userId = null): void
    {
        try {
            DB::table('views')->insert([
                'article_id' => $articleId,
                'user_id' => $userId,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Increment simple counter for fast access
            Article::where('id', $articleId)->increment('view_count');
            
            // Trigger a score update for this article specifically so it reflects in real-time
            $article = Article::find($articleId);
            if ($article) {
                $score = $this->calculateScore($article);
                $article->update(['trending_score' => $score]);
            }
        } catch (\Exception $e) {
            Log::warning('Failed to log article view', ['error' => $e->getMessage()]);
        }
    }
}
