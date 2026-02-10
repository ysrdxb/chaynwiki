<div class="relative w-full" x-data="{ focused: false }">
    <div class="relative group flex items-center bg-[#161b22] border border-white/10 rounded-full overflow-hidden focus-within:border-white/20 transition-all">
        <input 
            type="text" 
            wire:model.live.debounce.300ms="query"
            wire:keydown.enter="goToSearch"
            @focus="focused = true"
            @blur="setTimeout(() => focused = false, 200)"
            placeholder="Search" 
            class="flex-1 bg-transparent border-none focus:ring-0 text-[14px] text-white placeholder-white/30 px-5 py-2"
        >
        <button wire:click="goToSearch" class="w-8 h-8 m-1 bg-[#3b82f6] rounded-full flex items-center justify-center hover:bg-[#2563eb] transition-colors">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
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
            class="absolute top-full left-0 right-0 mt-2 bg-[#0f1419] border border-white/10 rounded-xl shadow-xl overflow-hidden z-50"
        >
            @foreach($results as $result)
                <a href="{{ route('wiki.show', $result->slug) }}" wire:navigate class="flex items-center gap-3 px-4 py-3 hover:bg-white/5 transition-colors group">
                    <div class="w-8 h-8 flex-shrink-0 bg-[#38bdf8]/10 rounded-lg flex items-center justify-center overflow-hidden">
                        @if($result->featured_image)
                            <img src="{{ Storage::url($result->featured_image) }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-4 h-4 text-[#38bdf8]/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13"/></svg>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm text-white group-hover:text-[#38bdf8] transition-colors truncate">{{ $result->title }}</h4>
                        <span class="text-xs text-white/30">{{ $result->category }}</span>
                    </div>
                </a>
            @endforeach
            
            <a href="{{ route('search', ['q' => $query]) }}" wire:navigate class="block px-4 py-2.5 text-center text-xs text-[#38bdf8] hover:bg-white/5 border-t border-white/5 transition-colors">
                View all results
            </a>
        </div>
    @elseif(strlen($query) >= 2 && count($results) === 0)
        <div x-show="focused" class="absolute top-full left-0 right-0 mt-2 bg-[#0f1419] border border-white/10 rounded-xl shadow-xl p-4 text-center z-50">
            <p class="text-white/40 text-xs">No results found</p>
        </div>
    @endif
</div>
