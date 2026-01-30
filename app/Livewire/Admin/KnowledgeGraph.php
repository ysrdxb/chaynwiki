<?php

namespace App\Livewire\Admin;

use App\Models\Article;
use Livewire\Component;

class KnowledgeGraph extends Component
{
    public function render()
    {
        // Get sample of nodes and their connections (for visualization)
        $articles = Article::where('status', 'published')->limit(50)->get();
        
        $graphData = [
            'nodes' => [],
            'links' => []
        ];

        foreach ($articles as $article) {
            $graphData['nodes'][] = [
                'id' => $article->id,
                'label' => $article->title,
                'category' => $article->category
            ];
            
            // Auto-link logic based on category (mock for graph viz)
            if ($article->category === 'song' && $article->song && $article->song->artist_id) {
                $graphData['links'][] = [
                    'source' => $article->id,
                    'target' => $article->song->artist_id,
                    'type' => 'artist'
                ];
            }
        }

        return view('livewire.admin.knowledge-graph', [
            'graphData' => $graphData
        ])->layout('layouts.admin');
    }
}
