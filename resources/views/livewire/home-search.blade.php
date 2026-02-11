<div class="relative max-w-[640px] mb-12 z-20" x-data="{ focused: false }">
    {{-- Search Input --}}
    <div class="flex items-center bg-[#161b22]/80 backdrop-blur-sm border border-white/5 rounded-full p-1.5 focus-within:border-white/10 transition-all">
        <input 
            type="text" 
            wire:model.live.debounce.300ms="query"
            wire:keydown.enter="goToSearch"
            @focus="focused = true"
            @blur="setTimeout(() => focused = false, 200)"
            placeholder="Search for a song, artist, or genre..." 
            class="flex-1 bg-transparent border-none focus:ring-0 text-white placeholder-white/20 text-[16px] px-6 font-medium tracking-tight"
        >
        <button wire:click="goToSearch" class="flex items-center gap-3 px-6 py-2.5 bg-white text-[#0d1117] rounded-full hover:bg-gray-100 transition-all group">
            <span class="text-[14px] font-black uppercase tracking-tight">Search</span>
            <div class="w-6 h-6 bg-[#3b82f6] rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </div>
        </button>
    </div>

    {{-- Live Results Dropdown --}}
    @if(strlen($query) >= 2 && count($results) > 0)
        <div 
            x-show="focused" 
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-100"
            class="absolute top-full left-0 right-0 mt-2 bg-[#151c24] border border-white/10 rounded-xl shadow-xl overflow-hidden z-50 text-left"
        >
            @foreach($results as $result)
                <a href="{{ route('wiki.show', $result->slug) }}" wire:navigate class="flex items-center gap-4 p-4 hover:bg-white/5 transition-colors group border-b border-white/5 last:border-0 text-left">
                    <div class="w-10 h-10 flex-shrink-0 bg-[#3b82f6]/10 rounded-lg flex items-center justify-center overflow-hidden">
                        @if($result->featured_image)
                            <img src="{{ $result->featured_image }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-5 h-5 text-[#3b82f6]/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13"/></svg>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-white group-hover:text-[#3b82f6] transition-colors truncate text-[15px] font-bold">{{ $result->title }}</h4>
                        <span class="text-xs text-white/40">{{ ucfirst($result->category) }}</span>
                    </div>
                </a>
            @endforeach
            
            <a href="{{ route('search', ['q' => $query]) }}" wire:navigate class="block p-3 text-center text-sm text-[#3b82f6] hover:bg-white/5 border-t border-white/5 transition-colors font-bold">
                View all results
            </a>
        </div>
    @elseif(strlen($query) >= 2 && count($results) === 0)
        <div x-show="focused" class="absolute top-full left-0 right-0 mt-2 bg-[#151c24] border border-white/10 rounded-xl shadow-xl p-6 text-center z-50">
            <p class="text-white/40 text-sm mb-3">No results for "<span class="text-white">{{ $query }}</span>"</p>
            <a href="{{ route('wiki.create') }}" wire:navigate class="inline-block px-4 py-2 bg-[#3b82f6]/10 text-[#3b82f6] text-sm rounded-lg hover:bg-[#3b82f6]/20 transition-colors">Create entry</a>
        </div>
    @endif
</div>
