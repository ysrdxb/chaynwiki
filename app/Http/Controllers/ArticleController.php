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
                    'playlists' => (clone $baseQuery)->where('category', 'playlist')->limit(4)->get(),
                    'terms' => (clone $baseQuery)->where('category', 'term')->limit(4)->get(),
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
        $article->load(['song.artist', 'artist', 'artist.songs.article', 'genre', 'playlist', 'term', 'user', 'analysis'])
            ->loadCount('revisions');
        
        // Ensure Ambient Signature exists (Elite Phase 1)
        if (!$article->analysis || !$article->analysis->ambient_signature) {
            $this->ensureAmbientSignature($article);
        }

        // Apply Smart Linking
        $article->content = $linker->injectLinks($article->content, $article->id);
        
        // Use TrendingService to log view (includes IP tracking and interaction logging)
        app(\App\Services\TrendingService::class)->logView($article->id, auth()->id());
        
        // Related terms lookup (terms only)
        $relatedTermArticles = collect();
        if ($article->category === 'term' && $article->term) {
            $relatedNames = collect($article->term->related_terms ?? [])
                ->filter()
                ->unique()
                ->values();

            if ($relatedNames->isNotEmpty()) {
                $relatedTermArticles = \App\Models\Article::where('status', 'published')
                    ->where('category', 'term')
                    ->whereIn('title', $relatedNames)
                    ->get()
                    ->keyBy('title');
            }
        }

        $summary = $article->excerpt
            ?: \Illuminate\Support\Str::limit(strip_tags((string) $article->content), 200);

        $artistStats = null;
        $artistGallery = collect();
        $artistDiscography = collect();
        $artistMeta = [];
        $relatedSongs = collect();

        if ($article->category === 'artist' && $article->artist) {
            $songs = $article->artist->songs ?? collect();
            $totalStreams = $songs->sum('stream_count');
            $songCount = $songs->count();

            $artistStats = [
                'views' => (int) ($article->view_count ?? 0),
                'songs' => $songCount,
                'streams' => (int) $totalStreams,
                'impact' => (float) ($article->trending_score ?? 0),
            ];

            $artistRank = \App\Models\Article::where('category', 'artist')
                ->where('status', 'published')
                ->where('view_count', '>', (int) ($article->view_count ?? 0))
                ->count() + 1;
            $artistStats['rank'] = $artistRank;

            $artistGallery = $songs
                ->filter(fn($song) => $song->article)
                ->map(function ($song) {
                    $raw = $song->article->getRawOriginal('featured_image');
                    if (!$raw) {
                        return null;
                    }
                    $image = \Illuminate\Support\Str::startsWith($raw, ['http://', 'https://'])
                        ? $raw
                        : \Illuminate\Support\Facades\Storage::url($raw);
                    return [
                        'title' => $song->title,
                        'image' => $image,
                    ];
                })
                ->filter()
                ->take(6)
                ->values();

            $artistDiscography = $songs
                ->filter(fn($song) => $song->article)
                ->sortByDesc('release_date')
                ->take(8)
                ->map(function ($song) {
                    $article = $song->article;
                    return [
                        'title' => $article->title,
                        'year' => $song->release_date?->format('Y'),
                        'url' => route('wiki.show', $article->slug),
                        'image' => $article->featured_image,
                    ];
                })
                ->values();

            $relatedSongs = $songs->filter(fn($song) => $song->article)->take(6)->values();

            $artistMeta = [
                'origin' => $article->artist->origin_location,
                'active_from' => $article->artist->active_from?->format('Y'),
                'active_to' => $article->artist->active_to?->format('Y'),
                'website' => $article->artist->website,
                'social' => $article->artist->social_links ?? [],
                'spotify_id' => $article->artist->spotify_id,
            ];
        }

        // Determine view based on category
        $view = match ($article->category) {
            'song' => 'wiki.song',
            'artist' => 'wiki.artist',
            'genre' => 'wiki.genre',
            'playlist' => 'wiki.playlist',
            'term' => 'wiki.term',
            default => 'wiki.show',
        };

        return view($view, compact(
            'article',
            'relatedTermArticles',
            'summary',
            'artistStats',
            'artistGallery',
            'artistDiscography',
            'artistMeta',
            'relatedSongs'
        ));
    }

    private function ensureAmbientSignature(\App\Models\Article $article)
    {
        $ollama = app(\App\Services\OllamaService::class);
        if (!$ollama->isAvailable()) return;

        $signature = $ollama->generateAmbientSignature($article->content);
        
        $article->analysis()->updateOrCreate(
            ['article_id' => $article->id],
            [
                'ambient_signature' => $signature,
                'mood' => $signature['emotion'] ?? 'Dramatic',
                'mood_score' => $signature['energy'] ?? 7,
                'analyzed_at' => now(),
            ]
        );
    }
}
