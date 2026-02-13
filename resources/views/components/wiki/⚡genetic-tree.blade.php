<?php

use Livewire\Volt\Component;
use App\Models\ArticleRelationship;
use Illuminate\Database\Eloquent\Model;

new class extends Component
{
    public $song;
    public $selectedNode = null;

    public function with()
    {
        $nodes = [];
        $edges = [];

        // Center Node (Current Song)
        $nodes[] = [
            'id' => $this->song->article->id,
            'label' => $this->song->title,
            'group' => 'current',
            'title' => 'Current Track',
            'shape' => 'diamond',
            'size' => 25,
            'color' => '#3b82f6'
        ];

        // Ancestors (Samples/Covers)
        $ancestors = $this->song->article->outgoingRelationships()
            ->whereIn('relationship_type', ['samples', 'covers'])
            ->with(['target.song', 'target.artist'])
            ->get();

        foreach ($ancestors as $rel) {
            if (!$rel->target) continue;
            
            $nodes[] = [
                'id' => $rel->target->id,
                'label' => $rel->target->song->title ?? $rel->target->title,
                'group' => $rel->relationship_type,
                'title' => ($rel->relationship_type === 'samples' ? 'Sampled: ' : 'Cover of: ') . $rel->target->title,
                'url' => route('wiki.show', $rel->target->slug)
            ];

            $edges[] = [
                'from' => $rel->target->id,
                'to' => $this->song->article->id,
                'label' => $rel->relationship_type,
                'arrows' => 'to',
                'color' => '#10b981',
                'dashes' => $rel->relationship_type === 'covers'
            ];
        }

        // Descendants (Sampled by/Remixes)
        $descendants = $this->song->article->incomingRelationships()
            ->whereIn('relationship_type', ['samples', 'remix_of'])
            ->with(['source.song', 'source.artist'])
            ->get();

        foreach ($descendants as $rel) {
            if (!$rel->source) continue;

            $nodes[] = [
                'id' => $rel->source->id,
                'label' => $rel->source->song->title ?? $rel->source->title,
                'group' => $rel->relationship_type === 'remix_of' ? 'remix' : 'descendant',
                'title' => ($rel->relationship_type === 'remix_of' ? 'Remix: ' : 'Sampled by: ') . $rel->source->title,
                'url' => route('wiki.show', $rel->source->slug)
            ];

            $edges[] = [
                'from' => $this->song->article->id,
                'to' => $rel->source->id,
                'label' => $rel->relationship_type === 'remix_of' ? 'remix' : 'sampled by',
                'arrows' => 'to',
                'color' => '#a78bfa'
            ];
        }

        return [
            'graphData' => [
                'nodes' => $nodes,
                'edges' => $edges
            ]
        ];
    }
};
?>

@push('scripts')
<script src="https://unpkg.com/vis-network/standalone/umd/vis-network.min.js"></script>
@endpush

<div class="card-premium-unified !bg-[#161b22]/40 !p-8 lg:p-12 overflow-hidden shadow-3xl relative" x-data="{
    initTree() {
        const container = this.$refs.treeContainer;
        const data = @js($graphData);
        
        const options = {
            nodes: {
                font: { color: '#ffffff', size: 12, face: 'Plus Jakarta Sans', bold: true },
                borderWidth: 2,
                shadow: true
            },
            edges: {
                font: { color: '#ffffff', size: 10, align: 'middle', background: 'rgba(13, 17, 23, 0.8)' },
                width: 2,
                shadow: true,
                smooth: { type: 'cubicBezier', forceDirection: 'vertical', roundness: 0.5 }
            },
            groups: {
                current: { color: { background: '#3b82f6', border: '#2563eb' } },
                samples: { color: { background: '#10b981', border: '#059669' } },
                covers: { color: { background: '#f59e0b', border: '#d97706' } },
                descendant: { color: { background: '#a78bfa', border: '#8b5cf6' } },
                remix: { color: { background: '#ec4899', border: '#db2777' } }
            },
            layout: {
                hierarchical: {
                    enabled: true,
                    direction: 'UD',
                    sortMethod: 'directed',
                    levelSeparation: 150,
                    nodeSpacing: 200
                }
            },
            interaction: { hover: true, zoomView: true }
        };

        const network = new vis.Network(container, data, options);
        
        network.on('click', function(params) {
            if (params.nodes.length > 0) {
                const nodeId = params.nodes[0];
                const node = data.nodes.find(n => n.id === nodeId);
                if (node && node.url) {
                    window.location.href = node.url;
                }
            }
        });
    }
}" x-init="initTree()">
    
    <div class="flex items-center justify-between mb-8">
        <div>
            <h3 class="text-2xl font-black text-white uppercase tracking-tighter">Genetic Mapping</h3>
            <p class="text-[11px] font-black text-white/20 uppercase tracking-[0.3em]">Ancestry of sound & sampling lineages</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-[#10b981]"></span>
                <span class="text-[9px] font-black text-white/40 uppercase tracking-widest">Ancestors</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-[#a78bfa]"></span>
                <span class="text-[9px] font-black text-white/40 uppercase tracking-widest">Legacy</span>
            </div>
        </div>
    </div>

    <div wire:ignore class="h-[400px] w-full" x-ref="treeContainer"></div>

    <div class="mt-8 pt-6 border-t border-white/5 text-center">
        <p class="text-[10px] font-black text-white/20 uppercase tracking-[0.2em]">Click nodes to navigate the genetic timeline</p>
    </div>
</div>