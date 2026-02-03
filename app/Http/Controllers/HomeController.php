<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Revision;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function __invoke(\App\Services\DiscoveryService $discovery)
    {
        $discoveryMix = $discovery->getDailyDiscovery();
        $hiddenGems = $discovery->getHiddenGems();
        // 1. New Topics (Latest Articles)
        $newTopics = Article::with(['user'])
            ->withCount('revisions')
            ->where('status', 'published')
            ->latest()
            ->take(6)
            ->get();

        $newTopicCards = $newTopics->map(function (Article $article) {
            $rawImage = $article->getRawOriginal('featured_image');

            return [
                'title' => $article->title,
                'category' => ucfirst($article->category),
                'desc' => Str::limit($article->meta_description, 140),
                'image' => $rawImage ? $article->featured_image : null,
                'user' => $article->user?->name ?? 'Community',
                'date' => optional($article->created_at)->format('M d, Y'),
                'views' => $article->view_count,
                'edits' => $article->revisions_count,
                'url' => route('wiki.show', $article->slug),
            ];
        });

        // 2. Statistics for hero counters
        $heroStats = [
            'articles' => Article::where('status', 'published')->count(),
            'contributors' => User::count(),
            'genres' => Article::where('category', 'genre')->where('status', 'published')->count(),
        ];

        // 3. Category tabs for Browse section
        $categoryCounts = Article::where('status', 'published')
            ->select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        $categoryIcons = [
            'artist' => '🎤',
            'song' => '🎵',
            'genre' => '🎸',
            'playlist' => '📀',
            'term' => '🧠',
        ];

        $categoryTabs = [
            'All' => $categoryCounts->map(function ($row) use ($categoryIcons) {
                return [
                    'name' => ucfirst($row->category),
                    'count' => number_format($row->total) . ' articles',
                    'icon' => $categoryIcons[$row->category] ?? '📚',
                    'url' => route('wiki.index', ['category' => $row->category]),
                ];
            })->values(),
        ];

        foreach ($categoryCounts->take(6) as $row) {
            $articles = Article::where('status', 'published')
                ->where('category', $row->category)
                ->orderByDesc('view_count')
                ->take(4)
                ->get();

            $categoryTabs[ucfirst($row->category)] = $articles->map(function (Article $article) use ($categoryIcons, $row) {
                return [
                    'name' => $article->title,
                    'count' => number_format($article->view_count) . ' views',
                    'icon' => $categoryIcons[$row->category] ?? '📚',
                    'url' => route('wiki.show', $article->slug),
                ];
            })->values();
        }

        // 4. Music pulse (real metrics)
        $editsWeek = Revision::where('created_at', '>=', now()->subDays(7))->count();
        $editsToday = Revision::whereDate('created_at', today())->count();
        $newArticlesWeek = Article::where('status', 'published')
            ->where('created_at', '>=', now()->subDays(7))
            ->count();
        $activeContributorsWeek = Revision::where('created_at', '>=', now()->subDays(7))
            ->distinct('user_id')
            ->count('user_id');

        $musicPulse = [
            'edits_week' => $editsWeek,
            'edits_today' => $editsToday,
            'new_articles_week' => $newArticlesWeek,
            'active_contributors_week' => $activeContributorsWeek,
            'live_flow' => $editsWeek > 0 ? min(100, (int) round(($editsToday / $editsWeek) * 100)) : 0,
        ];

        // 5. Featured Content (The Beat of the Moment - High Trending Score)
        $trendingArticles = Article::where('status', 'published')
            ->with(['user'])
            ->orderByDesc('trending_score')
            ->take(6)
            ->get();

        // 6. Recent Updates (Revisions)
        $recentUpdates = Revision::with(['article', 'user'])
            ->latest()
            ->take(5)
            ->get();

        // 7. Top Contributors
        $topContributors = User::orderByDesc('reputation_score')
            ->take(5)
            ->get();

        // 8. Ranked Items
        $rankedArticles = Article::with('user')
            ->where('status', 'published')
            ->orderByDesc(DB::raw('(COALESCE(trending_score, 0) * 100) + view_count'))
            ->take(6)
            ->get();

        // 9. Community Insights
        $topEdited = Revision::select('article_id', DB::raw('count(*) as edits'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('article_id')
            ->orderByDesc('edits')
            ->first();

        $topEditedArticle = $topEdited
            ? Article::where('id', $topEdited->article_id)->first()
            : null;

        $topContributor = User::withCount(['revisions' => function ($q) {
            $q->where('created_at', '>=', now()->subDays(30));
        }])->orderByDesc('revisions_count')->first();

        $featuredDiscovery = Article::where('status', 'published')
            ->orderByDesc('trending_score')
            ->first();

        $insightCards = collect();

        if ($topEditedArticle) {
            $insightCards->push([
                'label' => 'Most Edited (30d)',
                'value' => $topEditedArticle->title,
                'meta' => number_format($topEdited->edits) . ' edits',
                'gradient' => 'grad-purple',
                'icon' => '✍️',
                'color' => '#a78bfa', // Soft Purple (Ocean Depth)
                'premium' => true,
                'url' => route('wiki.show', $topEditedArticle->slug),
            ]);
        }

        if ($topContributor) {
            $insightCards->push([
                'label' => 'Top Contributor (30d)',
                'value' => '@' . $topContributor->username,
                'meta' => number_format($topContributor->revisions_count) . ' edits',
                'gradient' => 'grad-blue',
                'icon' => '🏆',
                'color' => '#38bdf8', // Ocean Blue (Ocean Depth)
                'premium' => false,
                'url' => route('profile', $topContributor->username),
            ]);
        }

        if ($featuredDiscovery) {
            $insightCards->push([
                'label' => 'Featured Discovery',
                'value' => $featuredDiscovery->title,
                'meta' => number_format($featuredDiscovery->view_count) . ' views',
                'gradient' => 'grad-pink',
                'icon' => '⭐',
                'color' => '#f472b6', // Coral Pink (Ocean Depth)
                'premium' => false,
                'url' => route('wiki.show', $featuredDiscovery->slug),
            ]);
        }

        return view('welcome', compact(
            'newTopicCards',
            'heroStats',
            'categoryTabs',
            'musicPulse',
            'trendingArticles',
            'recentUpdates',
            'topContributors',
            'rankedArticles',
            'insightCards',
            'discoveryMix',
            'hiddenGems'
        ));
    }
}
