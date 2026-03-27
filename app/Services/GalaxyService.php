<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Collection;

class GalaxyService
{
    /**
     * Map relationships for the central article to create a graph network.
     */
    public function getConstellation(Article $article): array
    {
        $nodes = collect();
        $links = collect();

        // Central Node
        $nodes->push([
            'id' => $article->id,
            'name' => $article->title,
            'type' => $article->category,
            'image' => $article->featured_image,
            'radius' => 45, // Main node size
            'color' => $this->getColor($article->category),
            'x' => 500, // Center X (assuming 1000x800 canvas)
            'y' => 400  // Center Y
        ]);

        // 1. Fetch direct children/parents (Artist <-> Songs)
        if ($article->category === 'artist') {
            $songs = Article::where('category', 'song')
                ->where('meta->artist_name', $article->title)
                ->limit(5)
                ->get();
            
            $this->addNodes($nodes, $links, $article->id, $songs, 'song', 250);
        } elseif ($article->category === 'song') {
            // Find Artist
            $artistName = $article->meta['artist_name'] ?? null;
            if ($artistName) {
                $artist = Article::where('category', 'artist')
                    ->where('title', $artistName)
                    ->first();
                
                if ($artist) {
                    $this->addSingleNode($nodes, $links, $article->id, $artist, 'artist', 200);
                }
            }
        }

        // 2. Fetch Genre Peers (Same Genre)
        $genre = $article->meta['genre'] ?? null;
        if ($genre) {
            $peers = Article::where('category', $article->category)
                ->where('id', '!=', $article->id)
                ->where('meta->genre', 'like', "%{$genre}%")
                ->inRandomOrder()
                ->limit(4)
                ->get();
                
            $this->addNodes($nodes, $links, $article->id, $peers, 'peer', 350);
        }

        // 3. Fetch Curator Connection (Same User)
        // Only if substantial enough
        if ($article->user_id) {
            $curated = Article::where('user_id', $article->user_id)
                ->where('id', '!=', $article->id)
                ->where('category', '!=', $article->category) // different types prefered
                ->inRandomOrder()
                ->limit(2)
                ->get();

             $this->addNodes($nodes, $links, $article->id, $curated, 'curator', 450);
        }

        return [
            'nodes' => $nodes->unique('id')->values()->all(),
            'links' => $links->values()->all()
        ];
    }

    private function addNodes(Collection $nodes, Collection $links, int $sourceId, $targets, string $type, int $distance)
    {
        foreach ($targets as $i => $target) {
            // Calculate position in circle
            $angle = ($i / $targets->count()) * 2 * M_PI; // Radians
            // Add some randomness
             $angle += rand(-10, 10) / 100;

            $x = 500 + cos($angle) * $distance;
            $y = 400 + sin($angle) * $distance;

            $nodes->push([
                'id' => $target->id,
                'name' => $target->title,
                'type' => $target->category,
                'image' => $target->featured_image,
                'radius' => ($type === 'artist' ? 35 : 25),
                'color' => $this->getColor($target->category),
                'x' => $x,
                'y' => $y,
                'url' => route('wiki.show', $target)
            ]);

            $links->push([
                'source' => $sourceId,
                'target' => $target->id,
                'type' => $type
            ]);
        }
    }

    private function addSingleNode(Collection $nodes, Collection $links, int $sourceId, $target, string $type, int $distance)
    {
         $nodes->push([
            'id' => $target->id,
            'name' => $target->title,
            'type' => $target->category,
            'image' => $target->featured_image,
            'radius' => 40,
            'color' => $this->getColor($type),
            'x' => 500, // Will be adjusted by force layout if using JS, but static here needs manual offset
            'y' => 200, 
            'url' => route('wiki.show', $target)
        ]);
        
        $links->push([
            'source' => $sourceId,
            'target' => $target->id,
            'type' => $type
        ]);
    }

    private function getColor($category)
    {
        return match ($category) {
            'song' => '#3b82f6', // Mobile Blue
            'artist' => '#ec4899', // Pink
            'genre' => '#a855f7', // Purple
            'playlist' => '#10b981', // Emerald
            default => '#ffffff'
        };
    }
}
