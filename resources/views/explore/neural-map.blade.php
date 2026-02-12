<x-app-layout>
    <x-slot name="title">Neural Discovery Map - ChaynWiki</x-slot>

    <div class="min-h-screen bg-[#0d1117] pt-24 overflow-hidden flex flex-col">
        {{-- Fullscreen Header --}}
        <div class="px-8 py-6 border-b border-white/5 bg-[#0d1117]/80 backdrop-blur-xl relative z-20">
            <div class="max-w-[1400px] mx-auto flex items-center justify-between">
                <div class="flex items-center gap-6">
                    <div class="w-12 h-12 rounded-2xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400 shadow-lg shadow-purple-500/5">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-black text-white tracking-tighter" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            Neural <span class="text-purple-500">Discovery</span> Map
                        </h1>
                        <p class="text-[10px] font-black text-white/30 tracking-widest leading-none">Global Music Knowledge Network</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" class="px-6 py-2.5 rounded-full border border-white/10 text-[11px] font-bold text-white/50 hover:text-white hover:bg-white/5 transition-all tracking-widest">
                        Exit Map
                    </a>
                </div>
            </div>
        </div>

        {{-- Main Graph Canvas --}}
        <div class="flex-1 relative" 
             x-data="neuralmap()" 
             x-init="init()"
             wire:ignore>
            
            <div x-ref="container" class="w-full h-full cursor-grab active:cursor-grabbing bg-[#0d1117]"></div>
            
            {{-- Loading State --}}
            <div x-show="loading" class="absolute inset-0 flex items-center justify-center bg-[#0d1117]/80 backdrop-blur-sm z-50 transition-opacity duration-500">
                <div class="flex flex-col items-center gap-4">
                    <div class="w-12 h-12 rounded-full border-2 border-white/10 border-t-blue-500 animate-spin"></div>
                    <p class="text-[10px] font-bold text-white/50 tracking-widest uppercase animate-pulse">Initializing Neural Core...</p>
                </div>
            </div>

            {{-- Floating Controls Overlay --}}
            <div class="absolute top-8 right-8 z-30 flex flex-col gap-4 pointer-events-none">
                <div class="card-premium-unified pointer-events-auto !bg-[#0d1117]/60 !p-6 backdrop-blur-2xl shadow-3xl border border-white/5">
                    <h3 class="text-[10px] font-black text-white/20 uppercase tracking-[0.2em] mb-4">Navigation Guide</h3>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <kbd class="px-2 py-1 rounded bg-white/10 text-[9px] text-white/60 border border-white/10 shadow-inner">DRAG</kbd>
                            <span class="text-[10px] font-bold text-white/40">Pan Orbit</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <kbd class="px-2 py-1 rounded bg-white/10 text-[9px] text-white/60 border border-white/10 shadow-inner">SCROLL</kbd>
                            <span class="text-[10px] font-bold text-white/40">Zoom Space</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <kbd class="px-2 py-1 rounded bg-white/10 text-[9px] text-white/60 border border-white/10 shadow-inner">CLICK</kbd>
                            <span class="text-[10px] font-bold text-white/40">Enter Node</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Legend --}}
            <div class="absolute bottom-12 left-1/2 -translate-x-1/2 z-30 pointer-events-none">
                <div class="pointer-events-auto px-8 py-4 rounded-full bg-[#0d1117]/60 border border-white/10 backdrop-blur-2xl flex items-center gap-8 shadow-3xl">
                    <div class="flex items-center gap-2.5">
                        <div class="w-3 h-3 rounded-full bg-blue-500 shadow-[0_0_15px_rgba(59,130,246,0.6)] animate-pulse"></div>
                        <span class="text-[10px] font-black text-white/50 tracking-widest">Artists</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <div class="w-3 h-3 rounded-full bg-green-500 shadow-[0_0_15px_rgba(34,197,94,0.6)] animate-pulse"></div>
                        <span class="text-[10px] font-black text-white/50 tracking-widest">Songs</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <div class="w-3 h-3 rounded-full bg-purple-500 shadow-[0_0_15px_rgba(168,85,247,0.6)] animate-pulse"></div>
                        <span class="text-[10px] font-black text-white/50 tracking-widest">Genres</span>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-6 right-6 flex items-center gap-2 z-30">
                <button @click="resetView()" class="p-3 rounded-xl bg-white/5 border border-white/5 text-white/40 hover:text-white hover:bg-white/10 transition-all backdrop-blur-sm shadow-2xl">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('neuralmap', () => ({
                width: 0,
                height: 0,
                loading: true,
                simulation: null,
                svg: null,
                zoom: null,
                data: null,

                init() {
                    console.log('Neural Map: Initializing specific standalone component...');
                    // Add window resize listener
                    window.addEventListener('resize', () => this.handleResize());
                    
                    // Initial load
                    this.$nextTick(() => {
                        this.fetchData();
                    });
                },

                handleResize() {
                    if (!this.svg) return;
                    
                    const container = this.$refs.container;
                    this.width = container.clientWidth || window.innerWidth;
                    this.height = container.clientHeight || window.innerHeight;

                    this.svg
                        .attr('width', this.width)
                        .attr('height', this.height)
                        .attr('viewBox', [0, 0, this.width, this.height]);

                    if (this.simulation) {
                        this.simulation.force('center', d3.forceCenter(this.width / 2, this.height / 2));
                        this.simulation.alpha(0.3).restart();
                    }
                },

                async fetchData() {
                    try {
                        // Use absolute URL to avoid any relative path confusion in subdirectories
                        // We construct it using the current origin + root path
                        const baseUrl = window.location.origin + '/chaynwiki/public'; // Adjust if needed
                        const url = `${baseUrl}/api/graph/global`;
                        
                        console.log('Neural Map: Fetching from', url);

                        const response = await fetch(url, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                        
                        this.data = await response.json();
                        console.log('Neural Map: Data received', this.data.nodes?.length);
                        
                        this.renderGraph();
                        this.loading = false;
                    } catch (error) {
                        console.error('Neural Map: Fetch failed', error);
                        this.loading = false;
                    }
                },

                renderGraph() {
                    if (!this.data || !this.data.nodes) return;

                    const container = this.$refs.container;
                    this.width = container.clientWidth || window.innerWidth;
                    this.height = container.clientHeight || window.innerHeight;

                    // Clean
                    d3.select(container).selectAll('*').remove();

                    // SVG
                    this.svg = d3.select(container)
                        .append('svg')
                        .attr('width', '100%')
                        .attr('height', '100%')
                        .attr('viewBox', [0, 0, this.width, this.height])
                        .style('background', '#0d1117');

                    // Defs (Glows)
                    const defs = this.svg.append('defs');
                    const glow = defs.append('filter')
                        .attr('id', 'glow')
                        .attr('x', '-50%').attr('y', '-50%').attr('width', '200%').attr('height', '200%');
                    glow.append('feGaussianBlur').attr('stdDeviation', '2.5').attr('result', 'coloredBlur');
                    const feMerge = glow.append('feMerge');
                    feMerge.append('feMergeNode').attr('in', 'coloredBlur');
                    feMerge.append('feMergeNode').attr('in', 'SourceGraphic');

                    const g = this.svg.append('g');

                    // Zoom
                    this.zoom = d3.zoom()
                        .scaleExtent([0.1, 4])
                        .on('zoom', (event) => g.attr('transform', event.transform));
                    
                    this.svg.call(this.zoom)
                        .on('dblclick.zoom', null); // Disable double click zoom

                    // Simulation
                    this.simulation = d3.forceSimulation(this.data.nodes)
                        .force('link', d3.forceLink(this.data.links).id(d => d.id).distance(120))
                        .force('charge', d3.forceManyBody().strength(-300))
                        .force('center', d3.forceCenter(this.width / 2, this.height / 2))
                        .force('collision', d3.forceCollide().radius(40));

                    // Links
                    const link = g.append('g')
                        .attr('stroke', 'rgba(255,255,255,0.05)')
                        .selectAll('line')
                        .data(this.data.links)
                        .join('line')
                        .attr('stroke-width', 1);

                    // Nodes
                    const node = g.append('g')
                        .selectAll('.node')
                        .data(this.data.nodes)
                        .join('g')
                        .attr('class', 'node')
                        .call(this.drag(this.simulation))
                        .on('click', (e, d) => {
                            if(d.url) window.location.href = d.url;
                        });

                    node.append('circle')
                        .attr('r', d => d.val * 8 + 4)
                        .attr('fill', d => this.getNodeColor(d.category))
                        .attr('stroke', '#fff')
                        .attr('stroke-width', 1.5)
                        .attr('stroke-opacity', 0.2)
                        .style('filter', 'url(#glow)')
                        .style('cursor', 'pointer');

                    // Labels
                    node.append('text')
                        .text(d => d.name)
                        .attr('x', 0)
                        .attr('y', d => d.val * 8 + 20)
                        .attr('text-anchor', 'middle')
                        .attr('fill', 'rgba(255,255,255,0.6)')
                        .attr('font-size', '10px')
                        .attr('font-weight', '700')
                        .attr('font-family', 'Plus Jakarta Sans')
                        .style('pointer-events', 'none')
                        .style('text-shadow', '0 2px 4px rgba(0,0,0,0.8)');

                    // Tick
                    this.simulation.on('tick', () => {
                        link
                            .attr('x1', d => d.source.x)
                            .attr('y1', d => d.source.y)
                            .attr('x2', d => d.target.x)
                            .attr('y2', d => d.target.y);

                        node.attr('transform', d => `translate(${d.x},${d.y})`);
                    });
                },

                drag(simulation) {
                    return d3.drag()
                        .on('start', (event) => {
                            if (!event.active) simulation.alphaTarget(0.3).restart();
                            event.subject.fx = event.subject.x;
                            event.subject.fy = event.subject.y;
                        })
                        .on('drag', (event) => {
                            event.subject.fx = event.x;
                            event.subject.fy = event.y;
                        })
                        .on('end', (event) => {
                            if (!event.active) simulation.alphaTarget(0);
                            event.subject.fx = null;
                            event.subject.fy = null;
                        });
                },

                getNodeColor(category) {
                    switch(category) {
                        case 'artist': return '#3b82f6'; // Blue-500
                        case 'song': return '#22c55e'; // Green-500
                        case 'genre': return '#a855f7'; // Purple-500
                        default: return '#64748b';
                    }
                },

                resetView() {
                    this.svg.transition().duration(750).call(
                        this.zoom.transform,
                        d3.zoomIdentity
                    );
                }
            }));
        });
    </script>
    @endpush

    <style>
        /* Hide scrollbars during map exploration */
        body { overflow: hidden !important; }
    </style>
</x-app-layout>
