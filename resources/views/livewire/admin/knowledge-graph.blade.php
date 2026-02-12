<div class="h-[calc(100vh-120px)] w-full flex flex-col" x-data="{ fullScreen: false }">
    <div class="flex-1 bg-[#161b22] border border-white/5 rounded-2xl overflow-hidden relative shadow-2xl transition-all duration-300" :class="fullScreen ? 'fixed inset-0 z-[100] h-screen rounded-none border-0' : ''">
        
        {{-- Header Overlay --}}
        <div class="absolute top-0 inset-x-0 p-8 z-10 bg-gradient-to-b from-[#0d1117]/90 to-transparent pointer-events-none">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-3xl font-black uppercase tracking-tighter text-white">Neural Knowledge Graph</h2>
                    <p class="text-white/40 text-xs mt-1 uppercase tracking-widest font-bold">Mapping {{ count($graphData['nodes'] ?? []) }} nodes & {{ count($graphData['links'] ?? []) }} connections</p>
                </div>
                
                <div class="flex items-start gap-4 pointer-events-auto">
                    {{-- Legend --}}
                    <div class="bg-[#0d1117]/80 backdrop-blur-md border border-white/10 rounded-xl px-4 py-2 flex items-center gap-6 shadow-lg">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.5)]"></div>
                            <span class="text-[10px] font-bold text-white/60 uppercase tracking-wide">Song</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-purple-500 shadow-[0_0_8px_rgba(139,92,246,0.5)]"></div>
                            <span class="text-[10px] font-bold text-white/60 uppercase tracking-wide">Artist</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></div>
                            <span class="text-[10px] font-bold text-white/60 uppercase tracking-wide">Genre</span>
                        </div>
                    </div>

                    {{-- Fullscreen Toggle --}}
                    <button @click="fullScreen = !fullScreen" class="p-3 bg-[#0d1117]/80 backdrop-blur-md border border-white/10 rounded-xl hover:bg-white/10 text-white/60 hover:text-white transition-all shadow-lg">
                        <svg x-show="!fullScreen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                        <svg x-show="fullScreen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Graph Container --}}
        <div id="graph-container" class="flex-1 w-full bg-[#0d1117] relative"></div>

        {{-- Footer Info --}}
        <div class="absolute bottom-8 left-8 pointer-events-none">
            <div class="max-w-xs bg-[#0d1117]/80 backdrop-blur-md border border-white/10 rounded-2xl p-5 pointer-events-auto shadow-2xl">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-1.5 h-1.5 rounded-full bg-brand-400 animate-pulse"></div>
                    <div class="text-[10px] font-black text-brand-400 uppercase tracking-widest">Live Intelligence</div>
                </div>
                <p class="text-[11px] text-white/50 leading-relaxed font-medium">Interactive visualization of semantic relationships. Drag nodes to restructure clusters. Scroll to zoom.</p>
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
            .linkColor(() => 'rgba(255, 255, 255, 0.08)')
            .linkWidth(1.5)
            .linkDirectionalArrowLength(3.5)
            .linkDirectionalArrowRelPos(1)
            .backgroundColor('#0d1117') // Matching premium dark theme
            .onNodeClick(node => {
                Graph.centerAt(node.x, node.y, 1000);
                Graph.zoom(4, 1000);
            })
            .nodeCanvasObject((node, ctx, globalScale) => {
                const label = node.name;
                const fontSize = 12/globalScale;
                ctx.font = `${fontSize}px Inter, "Plus Jakarta Sans", sans-serif`;
                
                // Glow effect based on category color
                const color = colors[node.category] || colors.default;

                // Draw Node
                ctx.fillStyle = color;
                ctx.beginPath();
                ctx.arc(node.x, node.y, 4, 0, 2 * Math.PI, false);
                ctx.fill();

                // Add outer glow/ring
                ctx.shadowBlur = 10;
                ctx.shadowColor = color;
                ctx.strokeStyle = 'rgba(255,255,255,0.2)';
                ctx.lineWidth = 0.5 / globalScale;
                ctx.stroke();
                
                // Draw Label only when zoomed in or hovered (simulated here by scale)
                if (globalScale > 1.5) {
                    ctx.shadowBlur = 0; // Reset shadow for text
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'top';
                    ctx.fillStyle = 'rgba(255, 255, 255, 0.9)';
                    ctx.fillText(label, node.x, node.y + 6);
                }
            });

        // Resize observer
        const resizeObserver = new ResizeObserver(() => {
            if(container) {
                Graph.width(container.offsetWidth);
                Graph.height(container.offsetHeight);
            }
        });
        resizeObserver.observe(container);
    });
</script>
@endpush
