@props(['items'])

<div 
    x-data="{
        currentIndex: 0,
        total: {{ count($items) }},
        
        next() {
            if (this.currentIndex < this.total - 1) this.currentIndex++;
        },
        prev() {
            if (this.currentIndex > 0) this.currentIndex--;
        },
        
        getStyle(index) {
            let diff = index - this.currentIndex;
            
            // Central Item
            if (diff === 0) {
                return 'z-20 transform scale-100 opacity-100 translate-x-0 rotate-y-0';
            }
            
            // Items behind (stacking)
            if (diff > 0) {
                let scale = 1 - (diff * 0.05);
                let xOffset = diff * 40; // Stack tightly to the right/center
                let zOffset = -diff * 50;
                return `z-${20 - diff} transform scale-${Math.max(0, parseInt(scale * 100))} opacity-100 translate-x-[${xOffset}px] translate-z-[${zOffset}px] rotate-y-[-10deg] brightness-[${1 - diff * 0.1}]`;
            }
            
            // Items passed (flipped left)
            if (diff < 0) {
                return 'z-0 transform scale-90 opacity-0 -translate-x-[200px] rotate-y-[40deg] pointer-events-none';
            }
        }
    }"
    @keydown.right.window="next()"
    @keydown.left.window="prev()"
    class="relative w-full h-[500px] flex items-center justify-center perspective-[1000px] overflow-hidden"
>
    <!-- Shelf / Crate Visualization -->
    <div class="absolute bottom-0 w-full h-1/2 bg-gradient-to-t from-black/50 to-transparent pointer-events-none"></div>

    <div class="relative w-[300px] h-[300px] flex items-center justify-center preserve-3d">
        @foreach($items as $index => $item)
            <div 
                x-show="Math.abs(currentIndex - {{ $index }}) < 5"
                x-transition:enter="transition ease-out duration-500"
                x-transition:leave="transition ease-in duration-300"
                class="absolute inset-0 bg-black rounded shadow-2xl border border-white/10 transition-all duration-500 ease-out origin-bottom"
                :class="{
                    'z-20 scale-100 opacity-100 translate-x-0 rotate-0': currentIndex === {{ $index }},
                    'z-10 scale-95 opacity-60 translate-x-[60px] -translate-y-[20px] -rotate-6 brightness-50': {{ $index }} === currentIndex + 1,
                    'z-0 scale-90 opacity-40 translate-x-[110px] -translate-y-[40px] -rotate-12 brightness-25': {{ $index }} === currentIndex + 2,
                    '-z-10 opacity-0 translate-x-[200px]': {{ $index }} > currentIndex + 2,
                    'z-30 -translate-x-[400px] rotate-[-30deg] opacity-0': {{ $index }} < currentIndex
                }"
                style="width: 300px; height: 300px;"
            >
                <!-- Vinyl Sleeve -->
                <div class="relative w-full h-full p-1 bg-[#1a1a1a]">
                    <img src="{{ $item->featured_image ?? 'https://via.placeholder.com/300' }}" class="w-full h-full object-cover shadow-inner">
                    
                    <!-- Vinyl Record peeking out -->
                    <div class="absolute top-2 -right-4 w-[280px] h-[280px] rounded-full bg-black border-[8px] border-[#111] shadow-2xl -z-10 flex items-center justify-center"
                         :class="currentIndex === {{ $index }} ? 'translate-x-[50px] transition-transform duration-700 delay-300' : 'translate-x-0'">
                         <div class="w-1/3 h-1/3 bg-red-500 rounded-full flex items-center justify-center">
                             <div class="w-2 h-2 bg-black rounded-full"></div>
                         </div>
                    </div>
                </div>
                
                <!-- Info Label (Only visible current) -->
                <div x-show="currentIndex === {{ $index }}" class="absolute -bottom-24 left-1/2 -translate-x-1/2 w-[400px] text-center" x-transition>
                    <h3 class="text-2xl font-black text-white uppercase tracking-tight">{{ $item->title }}</h3>
                    <p class="text-white/50 text-sm font-bold uppercase tracking-widest">{{ $item->artist_name ?? 'Unknown Artist' }}</p>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Controls -->
    <div class="absolute bottom-10 flex gap-4">
        <button @click="prev()" class="w-12 h-12 rounded-full bg-white/10 hover:bg-white text-white hover:text-black flex items-center justify-center transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button @click="next()" class="w-12 h-12 rounded-full bg-white/10 hover:bg-white text-white hover:text-black flex items-center justify-center transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>
    </div>
</div>
