@props(['nodes', 'links'])

<div x-data="{
    nodes: @js($nodes),
    links: @js($links),
    activeNode: null,
    
    init() {
        // Simple static layout handled by backend for now to avoid d3.js dependency overhead
        // but adding simple interactivity
    }
}" class="relative w-full aspect-video bg-[#0d1117] rounded-[32px] overflow-hidden border border-white/5 shadow-2xl group">
    
    {{-- Background Grid --}}
    <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.03)_1px,transparent_1px)] bg-[size:40px_40px]"></div>
    
    <svg class="w-full h-full" viewBox="0 0 1000 800" preserveAspectRatio="xMidYMid meet">
        <defs>
            <clipPath id="circleView">
                <circle cx="0" cy="0" r="1" />
            </clipPath>
        </defs>

        <!-- Links -->
        <g stroke-opacity="0.2">
            <template x-for="link in links">
                <line 
                    :x1="nodes.find(n => n.id === link.source).x" 
                    :y1="nodes.find(n => n.id === link.source).y" 
                    :x2="nodes.find(n => n.id === link.target).x" 
                    :y2="nodes.find(n => n.id === link.target).y" 
                    stroke="white" 
                    stroke-width="1.5"
                />
            </template>
        </g>

        <!-- Nodes -->
        <template x-for="node in nodes">
            <g class="cursor-pointer transition-opacity duration-300 pointer-events-auto"
               :class="{ 'opacity-100': (!activeNode || activeNode === node.id), 'opacity-20': (activeNode && activeNode !== node.id) }"
               @mouseenter="activeNode = node.id" 
               @mouseleave="activeNode = null"
               @click="window.location.href = node.url">
               
               <!-- Node Circle (Halo) -->
               <circle :cx="node.x" :cy="node.y" :r="node.radius + 6" :fill="node.color" opacity="0.2" class="animate-pulse" />
               <circle :cx="node.x" :cy="node.y" :r="node.radius" :stroke="node.color" stroke-width="3" fill="#161b22" />
               
               <!-- Image -->
               <template x-if="node.image">
                   <image :href="node.image" :x="node.x - node.radius" :y="node.y - node.radius" :height="node.radius * 2" :width="node.radius * 2" style="clip-path: circle(50% at 50% 50%)" preserveAspectRatio="xMidYMid slice" />
               </template>
               
               <!-- Label -->
               <text :x="node.x" :y="node.y + node.radius + 20" text-anchor="middle" fill="white" font-size="14" font-weight="900" class="uppercase tracking-widest pointer-events-none drop-shadow-md" style="font-family: 'Inter', sans-serif" x-text="node.name"></text>
               <text :x="node.x" :y="node.y + node.radius + 35" text-anchor="middle" :fill="node.color" font-size="10" font-weight="bold" class="uppercase tracking-widest pointer-events-none" x-text="node.type"></text>
            </g>
        </template>
    </svg>
    
    <div class="absolute top-6 left-6 pointer-events-none">
        <h3 class="text-white font-black text-2xl uppercase tracking-tighter drop-shadow-lg">Galaxy View</h3>
        <p class="text-white/40 text-xs font-bold uppercase tracking-widest">Network Connections</p>
    </div>
</div>
