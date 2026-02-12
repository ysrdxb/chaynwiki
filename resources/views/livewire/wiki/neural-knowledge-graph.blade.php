<?php

use Livewire\Volt\Component;

new class extends Component
{
    public $articleId = null;
    public $isGlobal = false;
    public $height = 600;

    public function mount($articleId = null, $isGlobal = false, $height = 600)
    {
        $this->articleId = $articleId;
        $this->isGlobal = $isGlobal;
        $this->height = $height;
    }
};
?>

<div class="relative w-full @if(!$isGlobal) rounded-[3rem] overflow-hidden border border-white/5 bg-black/20 backdrop-blur-md @endif" 
     style="height: {{ $height }}px;"
     x-data="knowledgeGraph({
        articleId: '{{ $articleId }}',
        isGlobal: {{ $isGlobal ? 'true' : 'false' }},
        apiUrl: '{{ $isGlobal ? route('api.graph.global') : route('api.graph.show', ['id' => $articleId]) }}'
     })"
     x-init="$nextTick(() => initGraph())">
    
    <div x-ref="canvas" class="w-full h-full cursor-grab active:cursor-grabbing"></div>

    <div class="absolute top-6 left-6 flex flex-col gap-2 pointer-events-none">
        <h3 class="text-[10px] font-black text-white/40 tracking-[0.3em]">Music Connection Map</h3>
        <div class="flex items-center gap-4">
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

    <div class="absolute bottom-6 right-6 flex items-center gap-2">
        <button @click="resetView()" class="p-3 rounded-xl bg-white/5 border border-white/5 text-white/40 hover:text-white hover:bg-white/10 transition-all backdrop-blur-sm shadow-2xl">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
        </button>
    </div>

    @push('scripts')
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <script>
        (function() {
            const registerKnowledgeGraph = () => {
                Alpine.data('knowledgeGraph', (config) => ({
                    config,
                    svg: null,
                    simulation: null,
                    data: null,
                    zoom: null,

                    async initGraph() {
                        try {
                            const response = await fetch(this.config.apiUrl);
                            if (!response.ok) throw new Error('Network response was not ok');
                            this.data = await response.json();
                            this.render();
                        } catch (e) {
                            console.error('Failed to load graph data:', e);
                        }
                    },

                    render() {
                        const container = this.$refs.canvas;
                        // Use fallback values if dimensions are not yet available
                        let width = container.clientWidth;
                        let height = container.clientHeight;

                        if (width === 0 || height === 0) {
                            // Attempt to get dimensions from parent or defaults
                            width = container.parentElement.clientWidth || window.innerWidth;
                            height = container.parentElement.clientHeight || 800;
                        }

                        // Clear previous to avoid duplication on re-render
                        d3.select(container).selectAll('*').remove();

                        const svg = d3.select(container)
                            .append('svg')
                            .attr('width', '100%')
                            .attr('height', '100%')
                            .attr('viewBox', [0, 0, width, height]);

                        const g = svg.append('g');

                        const zoom = d3.zoom()
                            .scaleExtent([0.1, 4])
                            .on('zoom', (event) => g.attr('transform', event.transform));

                        svg.call(zoom);

                        const simulation = d3.forceSimulation(this.data.nodes)
                            .force('link', d3.forceLink(this.data.links).id(d => d.id).distance(120))
                            .force('charge', d3.forceManyBody().strength(-400))
                            .force('center', d3.forceCenter(width / 2, height / 2))
                            .force('collision', d3.forceCollide().radius(50));

                        const link = g.append('g')
                            .attr('stroke', 'rgba(255,255,255,0.08)')
                            .attr('stroke-width', 1)
                            .selectAll('line')
                            .data(this.data.links)
                            .join('line');

                        const node = g.append('g')
                            .selectAll('g')
                            .data(this.data.nodes)
                            .join('g')
                            .attr('class', 'node-group')
                            .call(this.drag(simulation))
                            .on('click', (event, d) => {
                                if (event.defaultPrevented) return;
                                window.location.href = d.url;
                            });

                        // Modern glow
                        const defs = svg.append('defs');
                        const glowFilter = defs.append('filter')
                            .attr('id', 'neural-glow')
                            .attr('x', '-50%')
                            .attr('y', '-50%')
                            .attr('width', '200%')
                            .attr('height', '200%');
                        
                        glowFilter.append('feGaussianBlur')
                            .attr('stdDeviation', '3')
                            .attr('result', 'blur');
                        
                        glowFilter.append('feComposite')
                            .attr('in', 'SourceGraphic')
                            .attr('in2', 'blur')
                            .attr('operator', 'over');

                        node.append('circle')
                            .attr('r', d => d.val * 10 + 6)
                            .attr('fill', d => {
                                if (d.category === 'artist') return '#3b82f6';
                                if (d.category === 'song') return '#22c55e';
                                if (d.category === 'genre') return '#a855f7';
                                return '#64748b';
                            })
                            .attr('stroke', 'rgba(255,255,255,0.2)')
                            .attr('stroke-width', 2)
                            .style('filter', 'url(#neural-glow)');

                        node.append('text')
                            .text(d => d.name)
                            .attr('x', 0)
                            .attr('y', d => d.val * 10 + 22)
                            .attr('text-anchor', 'middle')
                            .attr('fill', 'rgba(255,255,255,0.5)')
                            .attr('font-size', '9px')
                            .attr('font-weight', '900')
                            .attr('class', 'tracking-tighter pointer-events-none');

                        simulation.on('tick', () => {
                            link
                                .attr('x1', d => d.source.x)
                                .attr('y1', d => d.source.y)
                                .attr('x2', d => d.target.x)
                                .attr('y2', d => d.target.y);

                            node.attr('transform', d => `translate(${d.x},${d.y})`);
                        });

                        this.svg = svg;
                        this.simulation = simulation;
                        this.zoom = zoom;
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

                    resetView() {
                        const container = this.$refs.canvas;
                        this.svg.transition().duration(750).call(
                            this.zoom.transform,
                            d3.zoomIdentity
                        );
                    }
                }));
            };

            if (window.Alpine) {
                registerKnowledgeGraph();
            } else {
                document.addEventListener('alpine:init', registerKnowledgeGraph);
            }
        })();
    </script>
    @endpush

    <style>
        .node-group { cursor: pointer; }
        .node-group circle { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .node-group:hover circle { r: 24; stroke: #fff; stroke-width: 3px; }
        .node-group:hover text { fill: #fff; font-size: 11px; }
    </style>
</div>
