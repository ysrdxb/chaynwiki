<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleRelationship;
use Illuminate\Http\Request;

class KnowledgeGraphController extends Controller
{
    public function show($id)
    {
        $article = Article::findOrFail($id);
        
        // Fetch direct relationships (outgoing and incoming)
        $relOut = $article->outgoingRelationships()->with('target')->get();
        $relIn = $article->incomingRelationships()->with('source')->get();

        $nodes = [];
        $links = [];
        $seen = [];

        // Primary node
        $nodes[] = $this->formatNode($article, true);
        $seen[$article->id] = true;

        foreach ($relOut as $rel) {
            if ($rel->target && !isset($seen[$rel->target_id])) {
                $nodes[] = $this->formatNode($rel->target);
                $seen[$rel->target_id] = true;
            }
            $links[] = $this->formatLink($rel->source_id, $rel->target_id, $rel->type, $rel->strength);
        }

        foreach ($relIn as $rel) {
            if ($rel->source && !isset($seen[$rel->source_id])) {
                $nodes[] = $this->formatNode($rel->source);
                $seen[$rel->source_id] = true;
            }
            $links[] = $this->formatLink($rel->source_id, $rel->target_id, $rel->type, $rel->strength);
        }

        return response()->json([
            'nodes' => $nodes,
            'links' => $links
        ]);
    }

    public function global()
    {
        $articles = Article::where('status', 'published')->limit(200)->get();
        $relationships = ArticleRelationship::whereIn('source_id', $articles->pluck('id'))
                         ->orWhereIn('target_id', $articles->pluck('id'))
                         ->limit(500)
                         ->get();

        $nodes = [];
        $links = [];
        $seen = [];

        foreach ($articles as $article) {
            $nodes[] = $this->formatNode($article);
            $seen[$article->id] = true;
        }

        foreach ($relationships as $rel) {
            if (isset($seen[$rel->source_id]) && isset($seen[$rel->target_id])) {
                $links[] = $this->formatLink($rel->source_id, $rel->target_id, $rel->type, $rel->strength);
            }
        }

        return response()->json([
            'nodes' => $nodes,
            'links' => $links
        ]);
    }

    private function formatNode($article, $isPrimary = false)
    {
        return [
            'id' => (string) $article->id,
            'name' => $article->title,
            'category' => $article->category,
            'slug' => $article->slug,
            'url' => route('wiki.show', $article->slug),
            'val' => $isPrimary ? 2 : 1
        ];
    }

    private function formatLink($source, $target, $type, $strength)
    {
        return [
            'source' => (string) $source,
            'target' => (string) $target,
            'type' => $type,
            'strength' => $strength
        ];
    }
}
