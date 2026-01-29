<div class="relative max-w-2xl mb-8 group z-20" x-data="{ focused: false }">
    <!-- Glow Effect -->
    <div class="absolute inset-0 bg-brand-500/20 blur-2xl group-hover:bg-brand-500/30 transition-all rounded-full duration-500"></div>
    
    <!-- Search Input -->
    <div class="relative flex items-center bg-white/5 border border-white/10 backdrop-blur-xl rounded-full p-2 pr-2 shadow-2xl transition-all duration-300 hover:border-white/20 hover:bg-white/10 focus-within:border-brand-500/50 focus-within:bg-[#0A0A14]/90">
        <input 
            type="text" 
            wire:model.live.debounce.300ms="query"
            @focus="focused = true"
            @blur="setTimeout(() => focused = false, 200)"
            placeholder="Search for artist, songs, or genres..." 
            class="flex-1 bg-transparent border-none text-white placeholder-gray-400 focus:ring-0 px-6 text-lg h-14 selection:bg-brand-500/30"
        >
        <button type="submit" class="bg-white text-black rounded-full px-8 py-3.5 font-bold flex items-center gap-2 hover:scale-105 hover:shadow-lg hover:shadow-brand-500/20 transition-all duration-300">
            Search <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </button>
    </div>

    <!-- Live Results Dropdown -->
    @if(strlen($query) >= 2 && count($results) > 0)
        <div 
            x-show="focused" 
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-2"
            class="absolute top-full left-4 right-4 mt-2 bg-[#0A0A14]/95 border border-white/10 backdrop-blur-3xl rounded-2xl shadow-2xl overflow-hidden z-50 divide-y divide-white/5"
        >
            <div class="px-4 py-2 text-xs font-mono text-gray-500 uppercase tracking-widest bg-white/5">
                Top Matches
            </div>
            
            @foreach($results as $result)
                <a href="{{ route('wiki.show', $result->slug) }}" wire:navigate class="flex items-center gap-4 p-4 hover:bg-white/5 transition-colors group">
                    @if($result->featured_image)
                        <img src="{{ Storage::url($result->featured_image) }}" class="w-12 h-12 rounded-lg object-cover border border-white/10 group-hover:border-brand-500/50 transition-colors">
                    @else
                        <div class="w-12 h-12 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-gray-500 group-hover:text-white group-hover:border-brand-500/50 transition-all">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                        </div>
                    @endif
                    
                    <div>
                        <h4 class="text-white font-bold text-lg leading-none mb-1 group-hover:text-brand-400 transition-colors">{{ $result->title }}</h4>
                        <span class="text-xs text-gray-500 font-mono uppercase">{{ $result->category }}</span>
                    </div>
                    
                    <div class="ml-auto text-gray-600 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </div>
                </a>
            @endforeach
            
            <a href="{{ route('search', ['q' => $query]) }}" wire:navigate class="block p-3 text-center text-sm font-bold text-brand-400 hover:text-white hover:bg-brand-600/20 transition-colors">
                View all results for "{{ $query }}"
            </a>
        </div>
    @elseif(strlen($query) >= 2 && count($results) === 0)
        <div x-show="focused" class="absolute top-full left-4 right-4 mt-2 bg-[#0A0A14]/95 border border-white/10 backdrop-blur-3xl rounded-2xl shadow-2xl p-6 text-center z-50">
            <p class="text-gray-400">No matches found for "<span class="text-white">{{ $query }}</span>"</p>
            <a href="{{ route('wiki.create') }}" wire:navigate class="inline-block mt-4 text-xs font-bold text-brand-400 uppercase tracking-widest border-b border-brand-500/30 hover:text-white hover:border-white transition-all">Create this page +</a>
        </div>
    @endif
</div>
