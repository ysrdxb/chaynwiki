<div class="relative max-w-2xl mb-8 group z-20" x-data="{ focused: false }">
    <!-- Glow Effect -->
    <div class="absolute inset-0 bg-blue-500/10 blur-[80px] group-hover:bg-blue-500/20 transition-all rounded-full duration-1000"></div>
    
    <!-- Search Input -->
    <div class="relative flex items-center bg-white/5 border border-white/5 backdrop-blur-xl rounded-full p-2 pr-2 shadow-2xl transition-all duration-500 hover:border-blue-500/20 hover:bg-white/10 focus-within:border-blue-500/30 focus-within:bg-[#0A0A14]/90">
        <input 
            type="text" 
            wire:model.live.debounce.300ms="query"
            @focus="focused = true"
            @blur="setTimeout(() => focused = false, 200)"
            placeholder="Search for artist, songs, or genres..." 
            class="flex-1 bg-transparent border-none text-white placeholder-white/10 focus:ring-0 px-8 text-lg h-14 selection:bg-blue-500/30 font-black uppercase tracking-tighter italic"
        >
        <button type="submit" class="bg-blue-600 text-white rounded-full px-10 py-4 text-[10px] font-black uppercase tracking-[0.2em] flex items-center gap-3 hover:scale-105 hover:bg-blue-500 hover:shadow-2xl hover:shadow-blue-500/20 transition-all duration-300">
            SEARCH <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
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
            class="absolute top-full left-4 right-4 mt-3 bg-[#0A0A14]/95 border border-white/5 backdrop-blur-3xl rounded-2xl shadow-2xl overflow-hidden z-50 divide-y divide-white/5"
        >
            <div class="px-5 py-3 text-[9px] font-black text-white/10 uppercase tracking-[0.3em] bg-white/5 italic">
                Distributed Record Index
            </div>
            
            @foreach($results as $result)
                <a href="{{ route('wiki.show', $result->slug) }}" wire:navigate class="flex items-center gap-5 p-5 hover:bg-white/5 transition-all duration-500 group">
                    @if($result->featured_image)
                        <img src="{{ Storage::url($result->featured_image) }}" class="w-14 h-14 rounded-xl object-cover border border-white/5 group-hover:border-blue-500/50 transition-all">
                    @else
                        <div class="w-14 h-14 rounded-xl bg-white/5 border border-white/5 flex items-center justify-center text-white/5 group-hover:text-blue-500 group-hover:border-blue-500/50 transition-all">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                        </div>
                    @endif
                    
                    <div class="flex-1">
                        <h4 class="text-white font-black text-base leading-none mb-1 group-hover:text-blue-500 transition-colors uppercase italic tracking-tighter">{{ $result->title }}</h4>
                        <span class="text-[9px] text-white/10 font-black uppercase tracking-[0.2em] italic">{{ $result->category }} Registry</span>
                    </div>
                    
                    <div class="text-white/5 group-hover:text-blue-500 transition-all duration-500">
                        <svg class="w-5 h-5 translate-x-px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </div>
                </a>
            @endforeach
            
            <a href="{{ route('search', ['q' => $query]) }}" wire:navigate class="block p-4 text-center text-[10px] font-black uppercase tracking-[0.2em] text-blue-500 hover:text-white hover:bg-blue-600 transition-all duration-500 italic">
                View all results for "{{ $query }}"
            </a>
        </div>
    @elseif(strlen($query) >= 2 && count($results) === 0)
        <div x-show="focused" class="absolute top-full left-4 right-4 mt-3 bg-[#0A0A14]/95 border border-white/5 backdrop-blur-3xl rounded-2xl shadow-2xl p-8 text-center z-50">
            <p class="text-[10px] font-black text-white/10 uppercase tracking-[0.2em] italic mb-4">No archive matches for "<span class="text-white">{{ $query }}</span>"</p>
            <a href="{{ route('wiki.create') }}" wire:navigate class="inline-block px-8 py-3 bg-blue-500/5 border border-blue-500/20 text-[9px] font-black text-blue-500 uppercase tracking-[0.2em] rounded-xl hover:bg-blue-600 hover:text-white transition-all italic">Create this node +</a>
        </div>
    @endif
</div>
