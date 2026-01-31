<?php

namespace App\Livewire\Admin;

use App\Models\Article;
use Livewire\Component;

class KnowledgeGraph extends Component
{
    public function render()
    {
        // Get sample of nodes and their connections (for visualization)
        $articles = Article::where('status', 'published')
            ->with(['song.artist.article', 'song.genre.article', 'artist.songs.article', 'playlist.songs.article'])
            ->limit(100)
            ->get();
        
        $nodes = [];
        $links = [];
        $articleMap = [];

        foreach ($articles as $article) {
            $nodes[] = [
                'id' => (string) $article->id,
                'name' => $article->title,
                'category' => $article->category,
                'val' => 1 // Size / value
            ];
            $articleMap[$article->id] = true;
        }

        foreach ($articles as $article) {
            // Song -> Artist Link
            if ($article->category === 'song' && $article->song && $article->song->artist) {
                $artistArticle = $article->song->artist->article;
                if ($artistArticle && isset($articleMap[$artistArticle->id])) {
                    $links[] = [
                        'source' => (string) $article->id,
                        'target' => (string) $artistArticle->id,
                        'label' => 'Performed By'
                    ];
                }
            }

            // Song -> Genre Link
            if ($article->category === 'song' && $article->song && $article->song->genre) {
                $genreArticle = $article->song->genre->article;
                if ($genreArticle && isset($articleMap[$genreArticle->id])) {
                    $links[] = [
                        'source' => (string) $article->id,
                        'target' => (string) $genreArticle->id,
                        'label' => 'Genre'
                    ];
                }
            }

            // Playlist -> Song Link
            if ($article->category === 'playlist' && $article->playlist) {
                foreach ($article->playlist->songs as $song) {
                    if ($song->article && isset($articleMap[$song->article->id])) {
                        $links[] = [
                            'source' => (string) $article->id,
                            'target' => (string) $song->article->id,
                            'label' => 'Contains'
                        ];
                    }
                }
            }

            // Genre -> Parent Genre Link
            if ($article->category === 'genre' && $article->genre && $article->genre->parent) {
                $parentArticle = $article->genre->parent->article;
                if ($parentArticle && isset($articleMap[$parentArticle->id])) {
                    $links[] = [
                        'source' => (string) $article->id,
                        'target' => (string) $parentArticle->id,
                        'label' => 'Subgenre Of'
                    ];
                }
            }
        }

        return view('livewire.admin.knowledge-graph', [
            'graphData' => [
                'nodes' => $nodes,
                'links' => $links
            ]
        ])->layout('layouts.admin');
    }
}
