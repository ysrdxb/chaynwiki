<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Article;
use App\Models\SearchLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * SmartSearchService - Advanced Search with Full-Text and Analytics
 * 
 * MySQL Full-Text search with autocomplete, trending, and facets.
 */
class SmartSearchService
{
    /**
     * Perform smart search with full-text matching
     */
    public function search(
        string $query,
        ?string $category = null,
        ?string $sortBy = 'relevance',
        int $perPage = 12,
        ?int $userId = null
    ): LengthAwarePaginator {
        $query = trim($query);
        
        if (empty($query)) {
            return new LengthAwarePaginator([], 0, $perPage);
        }

        // Log the search
        $this->logSearch($query, $category, $userId);

        // Build search query - use LIKE as fallback (FULLTEXT may not be available)
        $searchQuery = Article::query()
            ->where('status', 'published')
            ->where(function ($q) use ($query) {
                // Use LIKE for reliable matching across all MySQL setups
                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('content', 'LIKE', "%{$query}%");
            });

        // Apply category filter
        if ($category && $category !== 'all') {
            $searchQuery->where('category', $category);
        }

        // Apply sorting
        switch ($sortBy) {
            case 'newest':
                $searchQuery->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $searchQuery->orderBy('created_at', 'asc');
                break;
            case 'views':
                $searchQuery->orderBy('views', 'desc');
                break;
            case 'relevance':
            default:
                // Order by title match first (exact matches score higher), then by views
                $searchQuery->orderByRaw(
                    "CASE 
                        WHEN title LIKE ? THEN 0 
                        WHEN title LIKE ? THEN 1 
                        ELSE 2 
                    END, views DESC",
                    ["{$query}%", "%{$query}%"]
                );
                break;
        }

        return $searchQuery->paginate($perPage);
    }

    /**
     * Get autocomplete suggestions
     */
    public function autocomplete(string $query, int $limit = 5): array
    {
        $query = trim($query);
        
        if (strlen($query) < 2) {
            return [];
        }

        // Search titles that start with or contain the query
        $articles = Article::query()
            ->where('status', 'published')
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "{$query}%")
                    ->orWhere('title', 'LIKE', "%{$query}%");
            })
            ->select('id', 'title', 'slug', 'category')
            ->orderByRaw("CASE WHEN title LIKE ? THEN 0 ELSE 1 END", ["{$query}%"])
            ->limit($limit)
            ->get();

        return $articles->map(fn($a) => [
            'id' => $a->id,
            'title' => $a->title,
            'slug' => $a->slug,
            'category' => $a->category,
            'url' => route('wiki.show', $a),
        ])->toArray();
    }

    /**
     * Get trending searches
     */
    public function getTrendingSearches(int $limit = 10, int $days = 7): array
    {
        return SearchLog::query()
            ->where('created_at', '>=', now()->subDays($days))
            ->select('query', DB::raw('COUNT(*) as count'))
            ->groupBy('query')
            ->orderByDesc('count')
            ->limit($limit)
            ->pluck('query')
            ->toArray();
    }

    /**
     * Get recent searches for a user
     */
    public function getRecentSearches(?int $userId, int $limit = 5): array
    {
        if (!$userId) {
            return [];
        }

        return SearchLog::query()
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->limit($limit)
            ->pluck('query')
            ->unique()
            ->values()
            ->toArray();
    }

    /**
     * Get search suggestions based on popular/trending
     */
    public function getSuggestions(string $query, int $limit = 5): array
    {
        if (strlen($query) < 2) {
            return $this->getTrendingSearches($limit);
        }

        // Get suggestions from past searches
        $pastSearches = SearchLog::query()
            ->where('query', 'LIKE', "{$query}%")
            ->select('query', DB::raw('COUNT(*) as count'))
            ->groupBy('query')
            ->orderByDesc('count')
            ->limit($limit)
            ->pluck('query')
            ->toArray();

        // Fill with autocomplete if not enough
        if (count($pastSearches) < $limit) {
            $autoItems = $this->autocomplete($query, $limit - count($pastSearches));
            $pastSearches = array_merge($pastSearches, array_column($autoItems, 'title'));
        }

        return array_unique(array_slice($pastSearches, 0, $limit));
    }

    /**
     * Get available categories with counts
     */
    public function getCategoryFacets(): array
    {
        return Article::query()
            ->where('status', 'published')
            ->select('category', DB::raw('COUNT(*) as count'))
            ->groupBy('category')
            ->orderByDesc('count')
            ->get()
            ->toArray();
    }

    /**
     * Log a search for analytics
     */
    private function logSearch(string $query, ?string $category, ?int $userId): void
    {
        SearchLog::create([
            'user_id' => $userId,
            'query' => $query,
            'category' => $category,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Update click-through for a search result
     */
    public function logClick(int $searchLogId, int $articleId): void
    {
        SearchLog::where('id', $searchLogId)
            ->update([
                'clicked_article_id' => $articleId,
                'results_count' => DB::raw('results_count + 1'),
            ]);
    }
}
