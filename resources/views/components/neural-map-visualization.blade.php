@props(['articleId' => null, 'isGlobal' => false, 'height' => 600])

<div class="relative w-full @if(!$isGlobal) rounded-[3rem] overflow-hidden border border-white/5 bg-black/20 backdrop-blur-md @endif" 
     style="height: {{ $height }}px; touch-action: none;"
     x-data="neuralmap_{{ $articleId ?: 'global' }}()"
     x-init="init()"
     wire:ignore>
    
    <div x-ref="container" class="w-full h-full cursor-grab active:cursor-grabbing @if($isGlobal) bg-[#0d1117] @endif"></div>
    
    {{-- Loading State --}}
    <div x-show="loading" class="absolute inset-0 flex items-center justify-center bg-[#0d1117]/80 backdrop-blur-sm z-50 transition-opacity duration-500">
        <div class="flex flex-col items-center gap-4">
            <div class="w-12 h-12 rounded-full border-2 border-white/10 border-t-blue-500 animate-spin"></div>
            <p class="text-[10px] font-bold text-white/50 tracking-widest uppercase animate-pulse">Initializing Neural Core...</p>
        </div>
    </div>

    {{-- Legend Overlay (Simplified for Widget) --}}
    @if(!$isGlobal)
    <div class="absolute top-6 left-6 flex flex-col gap-2 pointer-events-none z-10">
        <h3 class="text-[10px] font-black text-white/40 tracking-[0.3em]">NEURAL MAP</h3>
        <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-4">
            <div class="flex items-center gap-1.5">
                <div class="w-1.5 h-1.5 rounded-full bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.5)]"></div>
                <span class="text-[8px] font-black text-white/20 tracking-widest">Artist</span>
            </div>
            <div class="flex items-center gap-1.5">
                <div class="w-1.5 h-1.5 rounded-full bg-green-500 shadow-[0_0_10px_rgba(34,197,94,0.5)]"></div>
                <span class="text-[8px] font-black text-white/20 tracking-widest">Song</span>
            </div>
             <div class="flex items-center gap-1.5">
                <div class="w-1.5 h-1.5 rounded-full bg-purple-500 shadow-[0_0_10px_rgba(168,85,247,0.5)]"></div>
                <span class="text-[8px] font-black text-white/20 tracking-widest">Genre</span>
            </div>
        </div>
    </div>
    @endif

    <div class="absolute bottom-6 right-6 flex items-center gap-2 z-30">
        <button @click="resetView()" class="p-3 md:p-3 rounded-xl bg-white/5 border border-white/5 text-white/40 hover:text-white hover:bg-white/10 transition-all backdrop-blur-sm shadow-2xl active:scale-95">
            <svg class="w-5 h-5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
        </button>
    </div>
</div>

@pushonce('scripts')
<script src="https://d3js.org/d3.v7.min.js"></script>
@endpushonce

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('neuralmap_{{ $articleId ?: 'global' }}', () => ({
            width: 0,
            height: 0,
            loading: true,
            simulation: null,
            svg: null,
            zoom: null,
            data: null,
            articleId: '{{ $articleId }}',
            isGlobal: {{ $isGlobal ? 'true' : 'false' }},

            init() {
                console.log('Neural Map (Component): Initializing...');
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
                    const baseUrl = window.location.origin + '/chaynwiki/public'; // Adjust for subdirectory
                    let url = '';
                    
                    if (this.isGlobal) {
                         url = `${baseUrl}/api/graph/global`;
                    } else {
                         url = `${baseUrl}/api/graph/${this.articleId}`;
                    }
                    
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
                // Force recalculate dimensions
                this.width = container.clientWidth;
                this.height = container.clientHeight;

                // Clean
                d3.select(container).selectAll('*').remove();

                // SVG
                this.svg = d3.select(container)
                    .append('svg')
                    .attr('width', '100%')
                    .attr('height', '100%')
                    .attr('viewBox', [0, 0, this.width, this.height]);

                // Defs (Glows)
                const defs = this.svg.append('defs');
                const glow = defs.append('filter')
                    .attr('id', 'glow_{{ $articleId ?: "global" }}')
                    .attr('x', '-50%').attr('y', '-50%').attr('width', '200%').attr('height', '200%');
                glow.append('feGaussianBlur').attr('stdDeviation', '2.5').attr('result', 'coloredBlur');
                const feMerge = glow.append('feMerge');
                feMerge.append('feMergeNode').attr('in', 'coloredBlur');
                feMerge.append('feMergeNode').attr('in', 'SourceGraphic');

                const g = this.svg.append('g');

                // Zoom logic
                this.zoom = d3.zoom()
                    .scaleExtent([0.1, 4])
                    .on('zoom', (event) => g.attr('transform', event.transform));
                
                this.svg.call(this.zoom)
                    .on('dblclick.zoom', null); 

                // Simulation
                this.simulation = d3.forceSimulation(this.data.nodes)
                    .force('link', d3.forceLink(this.data.links).id(d => d.id).distance(80)) // Tighter for widget
                    .force('charge', d3.forceManyBody().strength(-200))
                    .force('center', d3.forceCenter(this.width / 2, this.height / 2))
                    .force('collision', d3.forceCollide().radius(30));

                // Links
                const link = g.append('g')
                    .selectAll('line')
                    .data(this.data.links)
                    .join('line')
                    .attr('stroke', d => this.getLinkColor(d.type))
                    .attr('stroke-opacity', 0.4)
                    .attr('stroke-width', d => d.strength / 40);

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
                    .attr('r', d => d.val * 6 + 4)
                    .attr('fill', d => this.getNodeColor(d.category))
                    .attr('stroke', '#fff')
                    .attr('stroke-width', 1)
                    .attr('stroke-opacity', 0.3)
                    .style('filter', 'url(#glow_{{ $articleId ?: "global" }})')
                    .style('cursor', 'pointer');

                // Labels
                node.append('text')
                    .text(d => d.name)
                    .attr('x', 0)
                    .attr('y', d => d.val * 6 + 18)
                    .attr('text-anchor', 'middle')
                    .attr('fill', 'rgba(255,255,255,0.7)')
                    .attr('font-size', '8px') // Smaller for widget
                    .attr('font-weight', '700')
                    .attr('font-family', 'Plus Jakarta Sans')
                    .style('pointer-events', 'none');

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
                    case 'artist': return '#3b82f6'; 
                    case 'song': return '#22c55e'; 
                    case 'genre': return '#a855f7'; 
                    case 'label': return '#10b981'; // Emerald for Labels/Studios
                    default: return '#64748b';
                }
            },

            getLinkColor(type) {
                switch(type) {
                    case 'produced_by': return '#22d3ee'; // Cyan
                    case 'released_on': return '#10b981'; // Emerald
                    case 'remixed_by': return '#f472b6'; // Pink
                    case 'mastered_by': return '#fbbf24'; // Amber
                    case 'composed_by': return '#818cf8'; // Indigo
                    case 'written_by': return '#f87171'; // Red
                    case 'similar_to': return 'rgba(255,255,255,0.2)';
                    default: return 'rgba(255,255,255,0.1)';
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
