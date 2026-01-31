<div class="space-y-8" x-data="{ fullScreen: false }">
    <div class="glass-card overflow-hidden h-[800px] flex flex-col relative" :class="fullScreen ? 'fixed inset-0 z-[100] h-screen' : ''">
        {{-- Header overlay --}}
        <div class="absolute top-0 inset-x-0 p-8 z-10 bg-gradient-to-b from-dark/80 to-transparent pointer-events-none">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-2xl font-black italic uppercase tracking-tighter text-white">Neural Knowledge Graph</h2>
                    <p class="text-slate-400 text-xs mt-1 uppercase tracking-widest opacity-60">Autonomous mapping of music node clusters and relational bridges</p>
                </div>
                <div class="flex gap-4 pointer-events-auto">
                    <button @click="fullScreen = !fullScreen" class="p-3 bg-white/5 border border-white/10 rounded-xl hover:bg-white/10 transition-all">
                        <svg x-show="!fullScreen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                        <svg x-show="fullScreen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                    <div class="bg-white/5 border border-white/10 rounded-xl px-4 py-2 flex items-center gap-6">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-[#3b82f6]"></div>
                            <span class="text-[10px] font-bold text-white/60">SONG</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-[#8b5cf6]"></div>
                            <span class="text-[10px] font-bold text-white/60">ARTIST</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-[#10b981]"></div>
                            <span class="text-[10px] font-bold text-white/60">GENRE</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Graph Container --}}
        <div id="graph-container" class="flex-1 w-full bg-[#030308]/50"></div>

        {{-- Legend/Info Footer --}}
        <div class="absolute bottom-8 left-8 right-8 pointer-events-none">
            <div class="max-w-xs bg-black/40 backdrop-blur-xl border border-white/5 rounded-2xl p-4 pointer-events-auto shadow-2xl">
                <div class="text-[10px] font-black text-brand-400 uppercase tracking-widest mb-2">Cluster Intelligence</div>
                <p class="text-[11px] text-slate-400 leading-relaxed italic">Drag nodes to stabilize clusters. Scroll to zoom deep into metadata hierarchies. Click a node to focus signal.</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="//unpkg.com/force-graph"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const data = @json($graphData);
        const container = document.getElementById('graph-container');
        
        const colors = {
            song: '#3b82f6',
            artist: '#8b5cf6',
            genre: '#10b981',
            playlist: '#f59e0b',
            term: '#06b6d4',
            default: '#64748b'
        };

        const Graph = ForceGraph()(container)
            .graphData(data)
            .nodeId('id')
            .nodeLabel('name')
            .nodeVal('val')
            .nodeColor(node => colors[node.category] || colors.default)
            .linkColor(() => 'rgba(255, 255, 255, 0.05)')
            .linkWidth(1)
            .linkDirectionalArrowLength(3)
            .linkDirectionalArrowRelPos(1)
            .backgroundColor('#030308')
            .onNodeClick(node => {
                // Focus on node
                Graph.centerAt(node.x, node.y, 1000);
                Graph.zoom(4, 1000);
            })
            .nodeCanvasObject((node, ctx, globalScale) => {
                const label = node.name;
                const fontSize = 12/globalScale;
                ctx.font = `${fontSize}px Inter, "Plus Jakarta Sans", sans-serif`;
                const textWidth = ctx.measureText(label).width;
                const bckgDimensions = [textWidth, fontSize].map(n => n + fontSize * 0.2); 

                // Shape
                ctx.fillStyle = colors[node.category] || colors.default;
                ctx.beginPath();
                ctx.arc(node.x, node.y, 4, 0, 2 * Math.PI, false);
                ctx.fill();

                // Glow
                ctx.shadowBlur = 15;
                ctx.shadowColor = colors[node.category] || colors.default;

                // Label
                if (globalScale > 2) {
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.fillStyle = 'rgba(255, 255, 255, 0.8)';
                    ctx.fillText(label, node.x, node.y + 10);
                }
            });

        // Resize observer for the container
        const resizeObserver = new ResizeObserver(() => {
            Graph.width(container.offsetWidth);
            Graph.height(container.offsetHeight);
        });
        resizeObserver.observe(container);
    });
</script>
@endpush

<style>
    .text-gradient {
        background: linear-gradient(to right, #fff, #3b82f6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>
