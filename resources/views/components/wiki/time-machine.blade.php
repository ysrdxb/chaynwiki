@props(['revisions'])

<div x-data="{
    index: 0,
    revisions: @js($revisions),
    current: { id: 0, date: '', user: '', content: '', hash: '' },
    
    init() {
        if (this.revisions.length > 0) {
            this.index = this.revisions.length - 1;
            this.update();
        }
    },
    
    update() {
        this.current = this.revisions[this.index];
    },
    
    get diffPercentage() {
        if (this.revisions.length <= 1) return 100;
        return (this.index / (this.revisions.length - 1)) * 100;
    }
}" class="w-full">
    
    <div class="flex items-center justify-between mb-8">
        <div>
            <h3 class="text-white text-lg font-black uppercase tracking-tight">Time Machine</h3>
            <p class="text-xs text-white/40">Drag to view historical versions</p>
        </div>
        <div class="text-right">
             <p class="text-[10px] text-blue-400 font-bold uppercase tracking-widest mb-1" x-text="current.date"></p>
             <p class="text-sm font-bold text-white" x-text="'Rev #' + current.id + ' by ' + current.user"></p>
        </div>
    </div>

    {{-- Slider Track --}}
    <div class="relative h-2 bg-white/10 rounded-full mb-8 cursor-pointer group">
        <div class="absolute inset-y-0 left-0 bg-blue-500 rounded-full transition-all duration-75" :style="'width: ' + diffPercentage + '%'"></div>
        <input type="range" min="0" :max="revisions.length - 1" x-model="index" @input="update()" class="absolute inset-0 w-full opacity-0 cursor-pointer z-10">
        
        {{-- Knob --}}
        <div class="absolute top-1/2 -mt-2 -ml-2 w-4 h-4 bg-white rounded-full shadow-[0_0_10px_rgba(59,130,246,0.8)] pointer-events-none transition-all duration-75" :style="'left: ' + diffPercentage + '%'"></div>
    </div>
    
    {{-- Content Preview (Diff) --}}
    <div class="bg-[#0d1117] border border-white/10 rounded-xl p-8 min-h-[200px] relative overflow-hidden">
        {{-- Scanline Effect --}}
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-10 pointer-events-none"></div>
        
        <div class="prose prose-invert prose-sm max-w-none transition-opacity duration-200" x-html="current.content"></div>
        
        <div class="absolute bottom-4 right-4 text-[10px] text-white/20 font-mono">
            HASH: <span x-text="current.hash"></span>
        </div>
    </div>
</div>
