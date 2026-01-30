<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('q');
        $category = $request->get('category');
        
        $baseQuery = \App\Models\Article::query()
            ->with(['user', 'song.artist'])
            ->where('status', 'published');

        if ($search) {
            $baseQuery->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });

            // For search results, we want grouped data if no category is selected
            if (!$category) {
                $results = [
                    'songs' => (clone $baseQuery)->where('category', 'song')->limit(4)->get(),
                    'artists' => (clone $baseQuery)->where('category', 'artist')->limit(4)->get(),
                    'genres' => (clone $baseQuery)->where('category', 'genre')->limit(4)->get(),
                    'total_count' => $baseQuery->count()
                ];
                return view('wiki.index', compact('results', 'search'));
            }
        }

        if ($category) {
            $baseQuery->where('category', $category);
        }

        $baseQuery->latest('view_count');
        $articles = $baseQuery->paginate(12);
        
        return view('wiki.index', compact('articles', 'search', 'category'));
    }

    public function show(\App\Models\Article $article, \App\Services\SmartLinkerService $linker)
    {
        $article->load(['song.artist', 'artist', 'genre', 'playlist', 'user']);
        
        // Apply Smart Linking
        $article->content = $linker->injectLinks($article->content, $article->id);
        
        // Use TrendingService to log view (includes IP tracking and interaction logging)
        app(\App\Services\TrendingService::class)->logView($article->id, auth()->id());
        
        // Determine view based on category
        $view = match ($article->category) {
            'song' => 'wiki.song',
            'artist' => 'wiki.artist',
            'genre' => 'wiki.genre',
            default => 'wiki.show',
        };

        return view($view, compact('article'));
    }
}
