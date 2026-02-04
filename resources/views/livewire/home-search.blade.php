<div class="relative max-w-xl mb-8 z-20" x-data="{ focused: false }">
    {{-- Search Input --}}
    <div class="relative">
        <input 
            type="text" 
            wire:model.live.debounce.300ms="query"
            @focus="focused = true"
            @blur="setTimeout(() => focused = false, 200)"
            placeholder="Search songs, artists, genres..." 
            class="w-full bg-[#151c24] border border-white/10 rounded-xl px-5 py-4 pl-12 pr-24 text-base text-white placeholder-white/30 focus:border-[#38bdf8]/40 focus:outline-none transition-colors"
        >
        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <a href="{{ route('search') }}" class="absolute right-2 top-1/2 -translate-y-1/2 px-4 py-2 bg-[#38bdf8] hover:bg-[#7dd3fc] text-[#0a0e14] font-medium text-sm rounded-lg transition-colors">
            Search
        </a>
    </div>

    {{-- Live Results Dropdown --}}
    @if(strlen($query) >= 2 && count($results) > 0)
        <div 
            x-show="focused" 
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-100"
            class="absolute top-full left-0 right-0 mt-2 bg-[#151c24] border border-white/10 rounded-xl shadow-xl overflow-hidden z-50"
        >
            @foreach($results as $result)
                <a href="{{ route('wiki.show', $result->slug) }}" wire:navigate class="flex items-center gap-4 p-4 hover:bg-white/5 transition-colors group">
                    <div class="w-10 h-10 flex-shrink-0 bg-[#38bdf8]/10 rounded-lg flex items-center justify-center overflow-hidden">
                        @if($result->featured_image)
                            <img src="{{ Storage::url($result->featured_image) }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-5 h-5 text-[#38bdf8]/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-white group-hover:text-[#38bdf8] transition-colors truncate">{{ $result->title }}</h4>
                        <span class="text-xs text-white/40">{{ $result->category }}</span>
                    </div>
                </a>
            @endforeach
            
            <a href="{{ route('search', ['q' => $query]) }}" wire:navigate class="block p-3 text-center text-sm text-[#38bdf8] hover:bg-white/5 border-t border-white/5 transition-colors">
                View all results
            </a>
        </div>
    @elseif(strlen($query) >= 2 && count($results) === 0)
        <div x-show="focused" class="absolute top-full left-0 right-0 mt-2 bg-[#151c24] border border-white/10 rounded-xl shadow-xl p-6 text-center z-50">
            <p class="text-white/40 text-sm mb-3">No results for "<span class="text-white">{{ $query }}</span>"</p>
            <a href="{{ route('wiki.create') }}" wire:navigate class="inline-block px-4 py-2 bg-[#38bdf8]/10 text-[#38bdf8] text-sm rounded-lg hover:bg-[#38bdf8]/20 transition-colors">Create entry</a>
        </div>
    @endif
</div>
