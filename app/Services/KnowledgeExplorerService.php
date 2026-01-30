<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Genre;
use App\Models\GenreRelationship;
use App\Models\Article;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * KnowledgeExplorerService - Data for Visual Knowledge Graphs
 * 
 * Provides data for genre trees, artist networks, and timelines.
 */
class KnowledgeExplorerService
{
    /**
     * Get genre tree data for visualization
     */
    public function getGenreTree(): array
    {
        $genres = Genre::with(['children', 'parent'])->get();
        
        return $genres->map(fn($g) => [
            'id' => $g->id,
            'name' => $g->name,
            'slug' => $g->slug,
            'color' => $g->color,
            'parent_id' => $g->parent_genre_id,
            'era' => $g->era_start ? "{$g->era_start}s" : null,
            'popularity' => $g->popularity_score,
            'children_count' => $g->children->count(),
        ])->toArray();
    }

    /**
     * Get genre network data for Vis.js
     */
    public function getGenreNetwork(): array
    {
        $genres = Genre::all();
        $relationships = GenreRelationship::all();

        $nodes = $genres->map(fn($g) => [
            'id' => $g->id,
            'label' => $g->name,
            'color' => $g->color,
            'size' => 10 + ($g->popularity_score / 5),
            'title' => $g->description ?? $g->name,
        ])->toArray();

        $edges = $relationships->map(fn($r) => [
            'from' => $r->source_genre_id,
            'to' => $r->target_genre_id,
            'label' => $this->formatRelationType($r->relationship_type),
            'width' => $r->strength / 25,
            'arrows' => $r->relationship_type === 'derived_from' ? 'to' : 'to,from',
            'color' => $this->getRelationColor($r->relationship_type),
        ])->toArray();

        return [
            'nodes' => $nodes,
            'edges' => $edges,
        ];
    }

    /**
     * Get artist collaboration network
     */
    public function getArtistNetwork(int $limit = 50): array
    {
        try {
            // Get top artists (articles with category 'artist')
            $artists = Article::where('category', 'artist')
                ->where('status', 'published')
                ->orderByDesc('view_count')
                ->limit($limit)
                ->get();

            // Check if artist_collaborations table exists
            if (!Schema::hasTable('artist_collaborations')) {
                return $this->getDemoArtistNetwork();
            }

            $collaborations = DB::table('artist_collaborations')
                ->whereIn('artist1_id', $artists->pluck('id'))
                ->orWhereIn('artist2_id', $artists->pluck('id'))
                ->get();

            // If no data, return demo
            if ($artists->isEmpty() || $collaborations->isEmpty()) {
                return $this->getDemoArtistNetwork();
            }

            $nodes = $artists->map(fn($a) => [
                'id' => $a->id,
                'label' => $a->title,
                'color' => '#3B82F6',
                'size' => 15 + min($a->view_count / 100, 30),
                'title' => $a->title,
                'url' => route('wiki.show', $a),
            ])->toArray();

            $edges = $collaborations->map(fn($c) => [
                'from' => $c->artist1_id,
                'to' => $c->artist2_id,
                'label' => $c->collaboration_type,
                'title' => $c->work_title ?? 'Collaboration',
            ])->toArray();

            return [
                'nodes' => $nodes,
                'edges' => $edges,
            ];
        } catch (\Exception $e) {
            return $this->getDemoArtistNetwork();
        }
    }

    /**
     * Get demo artist network for visualization
     */
    private function getDemoArtistNetwork(): array
    {
        $artists = [
            ['id' => 1, 'name' => 'The Beatles', 'influence' => 100],
            ['id' => 2, 'name' => 'Led Zeppelin', 'influence' => 95],
            ['id' => 3, 'name' => 'Pink Floyd', 'influence' => 90],
            ['id' => 4, 'name' => 'Queen', 'influence' => 92],
            ['id' => 5, 'name' => 'David Bowie', 'influence' => 88],
            ['id' => 6, 'name' => 'The Rolling Stones', 'influence' => 94],
            ['id' => 7, 'name' => 'Jimi Hendrix', 'influence' => 96],
            ['id' => 8, 'name' => 'Bob Dylan', 'influence' => 89],
        ];

        $collaborations = [
            ['from' => 1, 'to' => 6, 'type' => 'Influenced'],
            ['from' => 7, 'to' => 2, 'type' => 'Influenced'],
            ['from' => 1, 'to' => 5, 'type' => 'Collaborated'],
            ['from' => 4, 'to' => 5, 'type' => 'Collaborated'],
            ['from' => 8, 'to' => 1, 'type' => 'Influenced'],
            ['from' => 3, 'to' => 5, 'type' => 'Similar Style'],
        ];

        $nodes = array_map(fn($a) => [
            'id' => $a['id'],
            'label' => $a['name'],
            'color' => '#3B82F6',
            'size' => 15 + ($a['influence'] / 5),
            'title' => $a['name'],
        ], $artists);

        $edges = array_map(fn($c) => [
            'from' => $c['from'],
            'to' => $c['to'],
            'label' => $c['type'],
            'color' => ['color' => '#6B7280'],
        ], $collaborations);

        return [
            'nodes' => $nodes,
            'edges' => $edges,
        ];
    }

    /**
     * Get timeline data for music history
     */
    public function getTimeline(): array
    {
        $genres = Genre::whereNotNull('era_start')
            ->orderBy('era_start')
            ->get();

        return $genres->map(fn($g) => [
            'id' => $g->id,
            'content' => $g->name,
            'start' => "{$g->era_start}-01-01",
            'end' => $g->era_end ? "{$g->era_end}-12-31" : null,
            'style' => "background-color: {$g->color}",
            'title' => $g->description ?? $g->name,
        ])->toArray();
    }

    /**
     * Get genre details with relationships
     */
    public function getGenreDetails(int $genreId): ?array
    {
        $genre = Genre::with(['parent', 'children'])->find($genreId);
        
        if (!$genre) {
            return null;
        }

        $influences = GenreRelationship::where('target_genre_id', $genreId)
            ->where('relationship_type', 'influences')
            ->with('sourceGenre')
            ->get();

        $influenced = GenreRelationship::where('source_genre_id', $genreId)
            ->where('relationship_type', 'influences')
            ->with('targetGenre')
            ->get();

        return [
            'genre' => $genre->toArray(),
            'influenced_by' => $influences->map(fn($r) => $r->sourceGenre)->toArray(),
            'influences' => $influenced->map(fn($r) => $r->targetGenre)->toArray(),
            'articles' => Article::where('category', $genre->slug)
                ->where('status', 'published')
                ->limit(10)
                ->get()
                ->toArray(),
        ];
    }

    /**
     * Format relationship type for display
     */
    private function formatRelationType(string $type): string
    {
        return match ($type) {
            'influences' => 'influenced',
            'derived_from' => 'derived from',
            'fusion_of' => 'fusion',
            'similar_to' => 'similar',
            default => $type,
        };
    }

    /**
     * Get color for relationship type
     */
    private function getRelationColor(string $type): string
    {
        return match ($type) {
            'influences' => '#10B981',
            'derived_from' => '#F59E0B',
            'fusion_of' => '#8B5CF6',
            'similar_to' => '#6B7280',
            default => '#3B82F6',
        };
    }
}
