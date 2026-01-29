<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;

/**
 * CacheService - Centralized caching for performance
 */
class CacheService
{
    // Cache TTL in seconds
    const TTL_SHORT = 300;     // 5 minutes
    const TTL_MEDIUM = 1800;   // 30 minutes
    const TTL_LONG = 3600;     // 1 hour
    const TTL_DAY = 86400;     // 1 day

    /**
     * Get cached popular articles
     */
    public function getPopularArticles(int $limit = 10): Collection
    {
        return Cache::remember(
            "articles:popular:{$limit}",
            self::TTL_MEDIUM,
            fn() => Article::where('status', 'published')
                ->orderByDesc('view_count')
                ->limit($limit)
                ->get()
        );
    }

    /**
     * Get cached recent articles
     */
    public function getRecentArticles(int $limit = 10): Collection
    {
        return Cache::remember(
            "articles:recent:{$limit}",
            self::TTL_SHORT,
            fn() => Article::where('status', 'published')
                ->orderByDesc('created_at')
                ->limit($limit)
                ->get()
        );
    }

    /**
     * Get cached articles by category
     */
    public function getArticlesByCategory(string $category, int $limit = 20): Collection
    {
        return Cache::remember(
            "articles:category:{$category}:{$limit}",
            self::TTL_MEDIUM,
            fn() => Article::where('status', 'published')
                ->where('category', $category)
                ->orderByDesc('created_at')
                ->limit($limit)
                ->get()
        );
    }

    /**
     * Get cached article count
     */
    public function getArticleCount(): int
    {
        return Cache::remember(
            'articles:count',
            self::TTL_MEDIUM,
            fn() => Article::where('status', 'published')->count()
        );
    }

    /**
     * Get cached category stats
     */
    public function getCategoryStats(): array
    {
        return Cache::remember(
            'articles:category_stats',
            self::TTL_LONG,
            fn() => Article::where('status', 'published')
                ->selectRaw('category, COUNT(*) as count')
                ->groupBy('category')
                ->pluck('count', 'category')
                ->toArray()
        );
    }

    /**
     * Get cached trending searches
     */
    public function getTrendingSearches(int $limit = 10): array
    {
        return Cache::remember(
            "searches:trending:{$limit}",
            self::TTL_SHORT,
            fn() => \App\Models\SearchLog::select('query')
                ->whereNotNull('query')
                ->where('created_at', '>=', now()->subDays(7))
                ->groupBy('query')
                ->orderByRaw('COUNT(*) DESC')
                ->limit($limit)
                ->pluck('query')
                ->toArray()
        );
    }

    /**
     * Clear article-related caches
     */
    public function clearArticleCache(?int $articleId = null): void
    {
        // Clear general caches
        Cache::forget('articles:count');
        Cache::forget('articles:category_stats');
        
        // Clear list caches for different limits
        foreach ([5, 10, 20] as $limit) {
            Cache::forget("articles:popular:{$limit}");
            Cache::forget("articles:recent:{$limit}");
        }

        // Clear category caches
        $categories = ['artist', 'song', 'genre', 'album', 'general'];
        foreach ($categories as $cat) {
            foreach ([10, 20, 50] as $limit) {
                Cache::forget("articles:category:{$cat}:{$limit}");
            }
        }
    }

    /**
     * Clear search-related caches
     */
    public function clearSearchCache(): void
    {
        foreach ([5, 10, 20] as $limit) {
            Cache::forget("searches:trending:{$limit}");
        }
    }

    /**
     * Remember with automatic tags
     */
    public function remember(string $key, int $ttl, callable $callback)
    {
        return Cache::remember($key, $ttl, $callback);
    }
}
