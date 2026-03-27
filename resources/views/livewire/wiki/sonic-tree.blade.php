<div class="w-full h-[600px] bg-[#0d1117] flex items-center justify-center overflow-hidden relative" x-data="sonicTree">
    
    <!-- SVG Layer for connections -->
    <svg class="absolute inset-0 w-full h-full pointer-events-none z-0">
        <template x-for="path in paths">
            <path :d="path.d" fill="none" class="stroke-white/20" stroke-width="2" stroke-dasharray="0" />
        </template>
    </svg>

    <!-- Container -->
    <div class="flex items-center gap-32 relative z-10 w-full max-w-6xl justify-center px-12">
        
        <!-- Sources (Left) -->
        <div class="flex flex-col gap-6 items-end" x-ref="sourcesCol">
            @foreach($sources as $index => $source)
            <div class="tree-node source-node relative group flex items-center gap-4" data-id="source-{{ $index }}">
                <div class="text-right hidden md:block">
                    <div class="text-white font-bold text-sm">{{ $source['name'] }}</div>
                    <div class="text-white/40 text-[10px] uppercase tracking-wider">Sampled Logic</div>
                </div>
                <div class="w-16 h-16 rounded-full border-2 border-white/20 overflow-hidden relative transition-transform hover:scale-110 cursor-pointer">
                    <img src="{{ $source['image'] }}" class="w-full h-full object-cover">
                </div>
                <!-- Connection Point Right -->
                <div class="absolute right-0 top-1/2 w-2 h-2 -mr-1 hidden"></div> 
            </div>
            @endforeach
            @if(empty($sources))
                <div class="text-white/20 text-sm italic">Original Composition</div>
            @endif
        </div>

        <!-- Current (Center) -->
        <div class="relative transform scale-125" x-ref="centerNode">
            <div class="w-32 h-32 rounded-full border-4 border-blue-500 shadow-[0_0_30px_rgba(59,130,246,0.5)] overflow-hidden relative z-20 group cursor-default">
                <img src="{{ $treeData['image'] }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                    <span class="text-white font-black text-xs uppercase tracking-widest">Current</span>
                </div>
            </div>
        </div>

        <!-- Derivatives (Right) -->
        <div class="flex flex-col gap-6 items-start" x-ref="targetsCol">
            @if(!empty($treeData['children']))
                @foreach($treeData['children'] as $index => $child)
                <div class="tree-node target-node relative group flex items-center gap-4" data-id="target-{{ $index }}">
                    <div class="w-16 h-16 rounded-full border-2 border-white/20 overflow-hidden relative transition-transform hover:scale-110 cursor-pointer">
                        <img src="{{ $child['image'] }}" class="w-full h-full object-cover">
                    </div>
                    <div class="text-left hidden md:block">
                        <div class="text-white font-bold text-sm">{{ $child['name'] }}</div>
                        <div class="text-white/40 text-[10px] uppercase tracking-wider">{{ $child['type'] ?? 'Sampled By' }}</div>
                    </div>
                </div>
                @endforeach
            @else
                 <div class="text-white/20 text-sm italic">No known samples/covers</div>
            @endif
        </div>
    </div>

    <!-- Alpine Script for drawing lines -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('sonicTree', () => ({
                paths: [],

                init() {
                    this.$nextTick(() => {
                        this.drawConnections();
                        window.addEventListener('resize', () => this.drawConnections());
                    });
                },

                drawConnections() {
                    const center = this.$refs.centerNode.getBoundingClientRect();
                    const container = this.$el.getBoundingClientRect();
                    const centerX = center.left + center.width / 2 - container.left;
                    const centerY = center.top + center.height / 2 - container.top;
                    
                    this.paths = [];

                    // Draw to Sources (Left)
                    const sources = this.$refs.sourcesCol.querySelectorAll('.tree-node');
                    sources.forEach(node => {
                        const rect = node.getBoundingClientRect();
                        const startX = rect.right - container.left;
                        const startY = rect.top + rect.height / 2 - container.top;
                        
                        this.paths.push({
                            d: this.createBezier(startX, startY, centerX - (center.width/2), centerY)
                        });
                    });

                    // Draw to Targets (Right)
                    const targets = this.$refs.targetsCol.querySelectorAll('.tree-node');
                    targets.forEach(node => {
                        const rect = node.getBoundingClientRect();
                        const endX = rect.left - container.left;
                        const endY = rect.top + rect.height / 2 - container.top;

                        this.paths.push({
                            d: this.createBezier(centerX + (center.width/2), centerY, endX, endY)
                        });
                    });
                },

                createBezier(x1, y1, x2, y2) {
                    const cp1x = x1 + (x2 - x1) / 2;
                    const cp2x = x2 - (x2 - x1) / 2;
                    return `M ${x1} ${y1} C ${cp1x} ${y1}, ${cp2x} ${y2}, ${x2} ${y2}`;
                }
            }))
        })
    </script>
</div>
