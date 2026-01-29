<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Genre;
use App\Models\GenreRelationship;
use App\Models\Article;
use Illuminate\Support\Facades\DB;

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
        // Get top artists (articles with category 'artist')
        $artists = Article::where('category', 'artist')
            ->where('status', 'published')
            ->orderByDesc('view_count')
            ->limit($limit)
            ->get();

        $collaborations = DB::table('artist_collaborations')
            ->whereIn('artist1_id', $artists->pluck('id'))
            ->orWhereIn('artist2_id', $artists->pluck('id'))
            ->get();

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
