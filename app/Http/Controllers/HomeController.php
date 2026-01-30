<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __invoke(\App\Services\DiscoveryService $discovery)
    {
        $discoveryMix = $discovery->getDailyDiscovery();
        $hiddenGems = $discovery->getHiddenGems();
        // 1. New Topics (Latest Articles)
        $newTopics = Article::with(['user', 'song.artist', 'genre'])
            ->where('status', 'published')
            ->latest()
            ->take(3)
            ->get();

        // 2. Statistics for "Browse Categories"
        $stats = [
            'songs' => Article::where('category', 'song')->where('status', 'published')->count(),
            'artists' => Article::where('category', 'artist')->where('status', 'published')->count(),
            'genres' => Article::where('category', 'genre')->where('status', 'published')->count(),
        ];

        // 3. Community Insights
        $insights = [
            'total_edits' => 100 + Article::sum('view_count'),
            'new_wikis_today' => Article::whereDate('created_at', today())->count(),
            'total_articles' => Article::where('status', 'published')->count(),
            'total_users' => User::count(),
        ];

        // 4. Music Weather (Mocked Data Layer - simulating real-time analytics)
        $musicWeather = [
            'rising_genres' => [
                'count' => rand(12, 45),
                'top' => Article::where('category', 'genre')->inRandomOrder()->take(2)->pluck('title')->toArray() ?: ['Hyperpop', 'Phonk'],
            ],
            'viral_artists' => [
                'region' => 'South East Asia',
                'name' => Article::where('category', 'artist')->inRandomOrder()->value('title') ?: 'Unknown Artist',
            ],
            'trending_songs' => [
                'platform' => 'TikTok',
                'count' => rand(800, 5000),
            ]
        ];

        // 5. Discover Tags (Dynamic Fetch using Trending Score)
        $trendingTags = Article::select('title', 'category', 'view_count', 'trending_score')
            ->where('status', 'published')
            ->orderByDesc('trending_score')
            ->take(5)
            ->get()
            ->map(function($item) {
                return [
                    'label' => $item->title,
                    'sub' => $item->category,
                    'stat' => $item->trending_score > 5 ? '+' . round($item->trending_score * 0.5, 1) . '% activity' : 'Stable',
                    'style' => match($item->category) {
                        'genre' => 'blue',
                        'artist' => 'purple',
                        'song' => 'teal',
                        default => 'gray'
                    }
                ];
            });
        
        if ($trendingTags->isEmpty()) {
            $trendingTags = collect([
                ['label' => 'Hyperpop', 'sub' => 'Genre', 'stat' => '+15%', 'style' => 'blue'],
                ['label' => 'The Weeknd', 'sub' => 'Artist', 'stat' => 'Trending', 'style' => 'purple'],
                ['label' => 'Afrofusion', 'sub' => 'Genre', 'stat' => 'New', 'style' => 'teal'],
            ]);
        }
 
        // 6. Featured Content (The Beat of the Moment - High Trending Score)
        $trendingArticles = Article::where('status', 'published')
            ->with(['song.artist', 'genre'])
            ->orderByDesc('trending_score')
            ->take(6)
            ->get();

        // 7. Recent Updates (Revisions)
        $recentUpdates = \App\Models\Revision::with(['article', 'user'])
            ->latest()
            ->take(5)
            ->get();

        // 8. Top Contributors
        $topContributors = User::orderByDesc('reputation_score')
            ->take(5)
            ->get();

        return view('welcome', compact(
            'newTopics', 
            'stats', 
            'insights', 
            'musicWeather', 
            'trendingTags', 
            'trendingArticles', 
            'recentUpdates', 
            'topContributors',
            'discoveryMix',
            'hiddenGems'
        ));
    }
}
