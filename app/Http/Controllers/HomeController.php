<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __invoke()
    {
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

        // 5. Discover Tags (Dynamic Fetch)
        // Fetch 5 random articles to serve as "Trending Tags" for now
        $trendingTags = Article::select('title', 'category', 'view_count')
            ->where('status', 'published')
            ->inRandomOrder()
            ->take(5)
            ->get()
            ->map(function($item) {
                return [
                    'label' => $item->title,
                    'sub' => $item->category,
                    'stat' => '+' . rand(5, 25) . '% vs last hour',
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

        // 6. Featured Content (High SEO Score or Trending)
        $featuredArticles = Article::where('status', 'published')
            ->inRandomOrder()
            ->take(5) // Get 5 to ensure enough content
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

        return view('welcome', compact('newTopics', 'stats', 'insights', 'musicWeather', 'trendingTags', 'featuredArticles', 'recentUpdates', 'topContributors'));
    }
}
