<div class="space-y-8">
    <div class="glass-card p-8 min-h-[600px]">
        <h2 class="text-2xl font-bold mb-2">Knowledge Graph Visualization</h2>
        <p class="text-slate-400 mb-8">Autonomous map of all interconnected nodes and metadata bridge points.</p>

        <div class="bg-black/40 rounded-3xl p-8 border border-white/5 relative overflow-hidden">
            <div class="flex justify-center">
                <div class="mermaid">
                    graph LR
                    @foreach($graphData['nodes'] as $node)
                        N{{ $node['id'] }}["{{ $node['label'] }}"]
                        style N{{ $node['id'] }} fill:{{ $node['category'] === 'artist' ? '#8b5cf6' : '#3b82f6' }},stroke:rgba(255,255,255,0.1),color:#fff
                    @endforeach

                    @foreach($graphData['links'] as $link)
                        N{{ $link['source'] }} --> N{{ $link['target'] }}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="module">
    import mermaid from 'https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.esm.min.mjs';
    mermaid.initialize({ 
        startOnLoad: true,
        theme: 'dark',
        securityLevel: 'loose',
        flowchart: {
            useMaxWidth: true,
            htmlLabels: true,
            curve: 'basis'
        }
    });
</script>
@endpush
