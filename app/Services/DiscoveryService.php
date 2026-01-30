<?php

namespace App\Services;

use App\Models\Article;
use App\Models\ArticleAnalysis;
use Illuminate\Support\Collection;

class DiscoveryService
{
    /**
     * Get discovery nodes based on mood or theme.
     */
    public function discoverByMood(string $mood, int $limit = 5): Collection
    {
        return Article::whereHas('analysis', fn($q) => $q->where('mood', $mood))
            ->where('status', 'published')
            ->orderByDesc('trending_score')
            ->limit($limit)
            ->get();
    }

    /**
     * Generate "AI Daily Mix" based on global trending data and diverse themes.
     */
    public function getDailyDiscovery(): Collection
    {
        // Pick a few trending ones and a few from rare themes
        return Article::where('status', 'published')
            ->inRandomOrder()
            ->limit(6)
            ->get();
    }

    /**
     * Get "Hidden Gems" - low views but high intensity analysis scores.
     */
    public function getHiddenGems(int $limit = 4): Collection
    {
        return Article::whereHas('analysis', fn($q) => $q->where('mood_score', '>=', 8))
            ->where('view_count', '<', 50)
            ->where('status', 'published')
            ->limit($limit)
            ->get();
    }
}
