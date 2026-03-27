@props(['releases'])

<div x-data="{
    releases: @js($releases),
    activeYear: null,
    scrollPosition: 0,
    
    init() {
        if(this.releases.length > 0) {
            this.activeYear = this.releases[0].year;
        }
    },
    
    scroll(direction) {
        const container = this.$refs.timeline;
        const scrollAmount = 300;
        if (direction === 'left') {
            container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        } else {
            container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        }
    }
}" class="w-full relative py-8 group">

    {{-- Controls --}}
    <button @click="scroll('left')" class="absolute left-0 top-1/2 -mt-4 z-10 w-8 h-8 rounded-full bg-[#161b22] border border-white/10 flex items-center justify-center text-white/50 hover:text-white hover:bg-white/10 transition-all opacity-0 group-hover:opacity-100">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </button>
    <button @click="scroll('right')" class="absolute right-0 top-1/2 -mt-4 z-10 w-8 h-8 rounded-full bg-[#161b22] border border-white/10 flex items-center justify-center text-white/50 hover:text-white hover:bg-white/10 transition-all opacity-0 group-hover:opacity-100">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </button>

    {{-- Timeline --}}
    <div x-ref="timeline" class="flex items-center gap-16 overflow-x-auto no-scrollbar px-12 py-20 relative">
        <div class="h-0.5 bg-white/10 absolute left-0 right-0 top-1/2 -z-10 w-[200%]"></div>
        
        <template x-for="release in releases" :key="release.id">
            <div class="relative group/node flex-shrink-0">
                {{-- Year Label --}}
                <div class="absolute -top-12 left-1/2 -translate-x-1/2 text-[10px] font-black font-mono text-white/30 group-hover/node:text-blue-400 transition-colors" x-text="release.year"></div>
                
                {{-- Node --}}
                <a :href="release.url" 
                   class="relative w-4 h-4 bg-[#0d1117] border-2 border-white/20 rounded-full flex items-center justify-center transition-all duration-300 group-hover/node:scale-150 group-hover/node:border-blue-500 z-10 cursor-pointer shadow-[0_0_15px_rgba(0,0,0,0.5)]">
                    <div class="w-1.5 h-1.5 bg-white/50 rounded-full group-hover/node:bg-blue-400"></div>
                </a>
                
                {{-- Card Preview (Bottom) --}}
                <div class="absolute top-8 left-1/2 -translate-x-1/2 w-48 opacity-0 group-hover/node:opacity-100 transition-all duration-300 transform group-hover/node:-translate-y-2 pointer-events-none z-20">
                    <div class="bg-[#161b22] border border-white/10 p-3 rounded-xl shadow-2xl relative">
                        {{-- Arrow --}}
                        <div class="absolute -top-1.5 left-1/2 -translate-x-1/2 w-3 h-3 bg-[#161b22] border-t border-l border-white/10 transform rotate-45"></div>
                        
                        <div class="aspect-square rounded-lg overflow-hidden bg-black/20 mb-3 border border-white/5">
                            <img :src="release.image" class="w-full h-full object-cover">
                        </div>
                        <h4 class="text-[12px] font-black text-white uppercase tracking-tighter truncate leading-none mb-1" x-text="release.title"></h4>
                        <p class="text-[9px] font-bold text-white/40 uppercase tracking-widest" x-text="release.type"></p>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    .mask-linear-fade { mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent); }
</style>
