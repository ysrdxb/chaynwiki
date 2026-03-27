<?php

namespace App\Livewire\Wiki;

use App\Models\Article;
use Livewire\Component;

class SonicTree extends Component
{
    public int $articleId;
    public $treeData = [];
    public $sources = [];

    public function mount(int $articleId)
    {
        $this->articleId = $articleId;
        $this->buildTree();
    }

    public function buildTree()
    {
        $article = Article::with([
            'song', 
            'outgoingRelationships.target.song', // For samples (We sample X)
            'outgoingRelationships.target.artist',
            'incomingRelationships.source.song', // For sampledBy (X samples us)
            'incomingRelationships.source.artist' 
        ])->find($this->articleId);
        
        if (!$article) {
            $this->treeData = [];
            return;
        }

        // Central Node
        $this->treeData = [
            'name' => $article->title,
            'image' => $article->featured_image,
            'children' => []
        ];

        // 1. Derivatives (Right Side) - Who sampled us? Who covered us?
        // Incoming Relationships (Target = Us)
        foreach ($article->incomingRelationships as $rel) {
            $sourceArticle = $rel->source;
            if (!$sourceArticle) continue;

            $typeLabel = match($rel->type) {
                'samples' => 'Sampled By',
                'covers' => 'Covered By',
                'remix_of' => 'Remixed By',
                default => ucfirst(str_replace('_', ' ', $rel->type))
            };

            // Only include relevant music types if needed, or all?
            $this->treeData['children'][] = [
                'name' => $sourceArticle->title,
                'type' => $typeLabel,
                'image' => $sourceArticle->featured_image,
                'children' => [] 
            ];
        }

        // 2. Sources (Left Side) - Who did we sample? Who did we cover?
        // Outgoing Relationships (Source = Us)
        foreach ($article->outgoingRelationships as $rel) {
            $targetArticle = $rel->target;
            if (!$targetArticle) continue;

            $typeLabel = match($rel->type) {
                'samples' => 'Sampled',
                'covers' => 'Cover of',
                'remix_of' => 'Remix of',
                default => ucfirst(str_replace('_', ' ', $rel->type))
            };
            
            // Allow generic relationships or specific ones?
            // Let's filter slightly for relevancy if needed, but for now show all "Sources"
            $this->sources[] = [
                'name' => $targetArticle->title,
                'type' => $typeLabel,
                'image' => $targetArticle->featured_image,
            ];
        }
    }

    public function render()
    {
        return view('livewire.wiki.sonic-tree');
    }
}
