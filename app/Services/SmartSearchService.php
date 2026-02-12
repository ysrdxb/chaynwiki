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
                $searchQuery->orderBy('view_count', 'desc');
                break;
            case 'relevance':
            default:
                // Order by title match first (exact matches score higher), then by views
                $searchQuery->orderByRaw(
                    "CASE 
                        WHEN title LIKE ? THEN 0 
                        WHEN title LIKE ? THEN 1 
                        ELSE 2 
                    END, view_count DESC",
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
            ->select('id', 'title', 'slug', 'category', 'featured_image')
            ->orderByRaw("CASE WHEN title LIKE ? THEN 0 ELSE 1 END", ["{$query}%"])
            ->limit($limit)
            ->get();

        return $articles->map(fn($a) => [
            'id' => $a->id,
            'title' => $a->title,
            'slug' => $a->slug,
            'category' => $a->category,
            'image' => $a->featured_image ? (str_starts_with($a->featured_image, 'http') ? $a->featured_image : \Illuminate\Support\Facades\Storage::url($a->featured_image)) : null,
            'url' => route('wiki.show', $a),
            'type' => 'direct', // Indicates a direct database match
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
        $suggestions = [];

        // 1. Get direct database matches (Rich Objects)
        $autoItems = $this->autocomplete($query, $limit);
        foreach ($autoItems as $item) {
            $suggestions[] = $item;
        }

        // 2. If we need more, check past search logs
        if (count($suggestions) < $limit) {
            $remaining = $limit - count($suggestions);
            $pastSearches = SearchLog::query()
                ->where('query', 'LIKE', "{$query}%")
                ->select('query', DB::raw('COUNT(*) as count'))
                ->groupBy('query')
                ->orderByDesc('count')
                ->limit($remaining)
                ->pluck('query')
                ->toArray();

            foreach ($pastSearches as $term) {
                // Ensure we don't add duplicates if a log matches a title
                $exists = false;
                foreach ($suggestions as $s) {
                    if (strcasecmp($s['title'], $term) === 0) {
                        $exists = true;
                        break;
                    }
                }

                if (!$exists) {
                    $suggestions[] = [
                        'title' => $term,
                        'type' => 'history', // Indicates a historical search term
                        'url' => null, // Clicking this just fills the search box
                        'image' => null,
                        'category' => 'search'
                    ];
                }
            }
        }

        // 3. Neural Suggestions (Graph-based)
        if (count($suggestions) < $limit) {
            $remaining = $limit - count($suggestions);
            
            // Find nodes connected to the current best match or trending nodes similar to query
            $neuralMatches = DB::table('knowledge_graph_links')
                ->join('articles as source', 'knowledge_graph_links.source_id', '=', 'source.id')
                ->join('articles as target', 'knowledge_graph_links.target_id', '=', 'target.id')
                ->where('source.title', 'LIKE', "%{$query}%")
                ->orWhere('target.title', 'LIKE', "%{$query}%")
                ->select(
                    'target.id', 'target.title', 'target.slug', 'target.category', 'target.featured_image',
                    DB::raw('"neural" as type')
                )
                ->distinct()
                ->limit($remaining)
                ->get();

            foreach ($neuralMatches as $match) {
                // Deduplicate
                $exists = false;
                foreach ($suggestions as $s) {
                    if (isset($s['id']) && $s['id'] == $match->id) { 
                        $exists = true; 
                        break; 
                    }
                }

                if (!$exists) {
                    $suggestions[] = [
                        'id' => $match->id,
                        'title' => $match->title,
                        'slug' => $match->slug,
                        'category' => $match->category,
                        'image' => $match->featured_image ? (str_starts_with($match->featured_image, 'http') ? $match->featured_image : \Illuminate\Support\Facades\Storage::url($match->featured_image)) : null,
                        'url' => route('wiki.show', ['article' => $match->slug]),
                        'type' => 'neural', // Indicates a graph-based recommendation
                    ];
                }
            }
        }

        return array_slice($suggestions, 0, $limit);
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
    /**
     * Get trending nodes from the knowledge graph
     */
    public function getNeuralTrending(int $limit = 6): array
    {
        // Find nodes with the most connections (Source or Target)
        // This is a simplified "PageRank-lite" approach
        $popularNodes = DB::table('knowledge_graph_links')
            ->select('target_id as id', DB::raw('count(*) as connections'))
            ->groupBy('target_id')
            ->orderByDesc('connections')
            ->limit($limit)
            ->get();
            
        $ids = $popularNodes->pluck('id')->toArray();
        
        return Article::whereIn('id', $ids)
            ->select('id', 'title', 'slug', 'category', 'featured_image')
            ->get()
            ->map(fn($a) => [
                'id' => $a->id,
                'title' => $a->title,
                'slug' => $a->slug,
                'category' => $a->category,
                'image' => $a->featured_image ? (str_starts_with($a->featured_image, 'http') ? $a->featured_image : \Illuminate\Support\Facades\Storage::url($a->featured_image)) : null,
                'url' => route('wiki.show', $a),
                'type' => 'neural_trend'
            ])
            ->toArray();
    }
}
