<div>
    {{-- Background Blobs --}}
    {{-- Background Blobs --}}
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        {{-- Clean background for premium feel --}}
    </div>

    {{-- Main Content --}}
    <div class="relative min-h-screen pt-32 pb-24" style="z-index: 1;">
        <div class="max-w-[1400px] mx-auto px-8 py-8">
            
            {{-- SEARCH HEADER --}}
            <div class="text-center mb-16">
                @if(!empty($query))
                    {{-- Results Header --}}
                    <h1 class="text-[64px] md:text-[80px] font-black text-white uppercase leading-none tracking-tighter mb-4" style="font-family: 'Inter', sans-serif;">
                        {{ $query }}
                    </h1>
                    <p class="text-[14px] font-bold text-white/40 uppercase tracking-widest">
                        Total Results: 0{{ $results ? $results->total() : 0 }}
                    </p>
                @else
                    {{-- Welcome State --}}
                    <h1 class="text-[64px] font-black text-white uppercase leading-none tracking-tighter mb-4">
                        Search <span class="text-blue-500">Wiki</span>
                    </h1>
                    <p class="text-white/40 text-[14px] font-bold uppercase tracking-widest">
                        Explore the global music encyclopedia
                    </p>
                @endif
            </div>

            {{-- SEARCH INPUT & FILTERS --}}
            <div class="max-w-4xl mx-auto mb-20 relative" x-data="{ focused: false }">
                {{-- Glowing Backdrop Removed --}}

                {{-- Search Bar --}}
                <div class="relative flex items-center bg-[#161b22] border border-white/10 rounded-full p-2 shadow-2xl transition-all duration-300"
                     :class="{ 'ring-2 ring-blue-500/50 border-blue-500/50': focused }">
                    
                    <div class="pl-6 pr-4">
                        <svg class="w-6 h-6 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>

                    <input type="text" 
                        wire:model.live.debounce.300ms="query"
                        @focus="focused = true"
                        @blur="setTimeout(() => focused = false, 200)"
                        placeholder="Search for artists, songs, or genres..." 
                        class="flex-1 bg-transparent text-white text-[18px] font-bold placeholder-white/20 border-none outline-none focus:ring-0 p-2 w-full"
                    >
                    
                    @if($query)
                        <button wire:click="clearSearch" class="p-2 mr-2 text-white/30 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    @endif

                    <button wire:click="search" class="px-8 py-3 bg-white text-black rounded-full font-black uppercase tracking-widest text-[12px] hover:bg-gray-200 transition-colors">
                        Search
                    </button>
                </div>

                {{-- DROPDOWN REMOVED AS REQUESTED (Redundant on main search page) --}}


            {{-- SEARCH RESULTS / EMPTY STATES --}}
            
            @if(empty($query))
                {{-- Trending & Quick Access Section --}}
                <div class="max-w-5xl mx-auto">
                    @if(!empty($trending))
                        <div class="mb-20">
                            <h3 class="text-white/20 text-[11px] font-black uppercase tracking-widest text-center mb-8 flex items-center justify-center gap-4">
                                <span class="w-8 h-px bg-white/10"></span>
                                Trending Searches
                                <span class="w-8 h-px bg-white/10"></span>
                            </h3>
                            <div class="flex flex-wrap justify-center gap-3">
                                @foreach($trending as $term)
                                    <button wire:click="selectSuggestion('{{ addslashes($term) }}')" 
                                        class="px-6 py-2.5 rounded-xl bg-white/5 border border-white/10 text-[13px] font-bold text-white hover:bg-blue-600 hover:border-blue-500 hover:shadow-[0_0_20px_rgba(59,130,246,0.4)] transition-all duration-300 flex items-center gap-2 group">
                                        <svg class="w-3.5 h-3.5 text-white/40 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                        {{ $term }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <a href="{{ route('wiki.create') }}" class="group p-10 bg-[#161b22]/40 border border-white/5 rounded-[40px] hover:border-blue-500/30 transition-all duration-500 text-center">
                            <div class="w-16 h-16 bg-blue-600/10 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                            </div>
                            <h3 class="text-[20px] font-black text-white uppercase tracking-tighter mb-2">Create Entry</h3>
                            <p class="text-[14px] text-white/40 font-medium">Contribute to the encyclopedia</p>
                        </a>

                        <a href="{{ route('wiki.index') }}" class="group p-10 bg-[#161b22]/40 border border-white/5 rounded-[40px] hover:border-blue-500/30 transition-all duration-500 text-center">
                            <div class="w-16 h-16 bg-blue-600/10 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            </div>
                            <h3 class="text-[20px] font-black text-white uppercase tracking-tighter mb-2">Browse All</h3>
                            <p class="text-[14px] text-white/40 font-medium">Explore full music archive</p>
                        </a>

                        <a href="{{ route('wiki.artists') }}" class="group p-10 bg-[#161b22]/40 border border-white/5 rounded-[40px] hover:border-blue-500/30 transition-all duration-500 text-center">
                            <div class="w-16 h-16 bg-blue-600/10 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            </div>
                            <h3 class="text-[20px] font-black text-white uppercase tracking-tighter mb-2">Artist Directory</h3>
                            <p class="text-[14px] text-white/40 font-medium">Verified musician profiles</p>
                        </a>
                    </div>
                </div>
                
            @elseif($results && $results->count() > 0)
                @php
                    $songs = $results->where('category', 'song');
                    $artists = $results->where('category', 'artist');
                    $genres = $results->where('category', 'genre');
                    $others = $results->whereNotIn('category', ['song', 'artist', 'genre']);
                @endphp

                {{-- Songs Section --}}
                @if($songs->count() > 0)
                    <section class="mb-20">
                        <div class="flex items-center justify-between mb-8">
                            <h2 class="text-[28px] md:text-[34px] font-black text-white uppercase tracking-tighter flex items-center gap-4">
                                <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2L14.4 9L22 9L15.8 13.5L18.2 20.5L12 16L5.8 20.5L8.2 13.5L2 9L9.6 9L12 2Z" />
                                </svg>
                                Songs Matching "{{ $query }}"
                            </h2>
                            <div class="flex items-center gap-2">
                                <button class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-white/30 hover:text-white hover:border-white/20 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                                </button>
                                <button class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-white/30 hover:text-white hover:border-white/20 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($songs->take(6) as $article)
                                <div class="card-premium-unified group relative block p-4 !bg-[#161b22]/60 hover:!bg-[#161b22] border border-white/5 hover:border-blue-500/50 transition-all duration-500 hover:-translate-y-1 hover:shadow-[0_0_30px_rgba(59,130,246,0.15)] rounded-[32px]">
                                    <a href="{{ route('wiki.show', $article) }}" class="block">
                                        {{-- Image --}}
                                        <div class="relative aspect-[4/3] rounded-[24px] overflow-hidden mb-6 border border-white/5 group-hover:border-white/10 transition-colors">
                                            <img src="{{ $article->featured_image }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000" alt="{{ $article->title }}">
                                            {{-- Badges --}}
                                            <div class="absolute top-4 left-4 flex flex-col gap-2">
                                                @if($loop->iteration <= 3)
                                                <span class="px-3 py-1 rounded-full bg-blue-600/80 backdrop-blur-md text-white text-[10px] font-black uppercase tracking-widest shadow-lg">Top Result</span>
                                                @endif
                                            </div>
                                            
                                            {{-- Play Button Overlay --}}
                                            <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors flex items-center justify-center opacity-0 group-hover:opacity-100 duration-300">
                                                <div class="w-14 h-14 rounded-full bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center shadow-2xl transform scale-90 group-hover:scale-100 transition-all">
                                                    <svg class="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Content --}}
                                        <div class="px-2 pb-2">
                                            <div class="flex items-center gap-2 mb-3">
                                                <span class="px-2 py-0.5 rounded bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[10px] font-black uppercase tracking-widest">Song</span>
                                                <span class="w-1 h-1 rounded-full bg-white/20"></span>
                                                <span class="text-white/40 text-[11px] font-bold uppercase tracking-widest">{{ optional($article->created_at)->year }}</span>
                                            </div>
                                            
                                            <h3 class="text-[24px] font-black text-white uppercase tracking-tighter mb-2 line-clamp-1 group-hover:text-blue-400 transition-colors leading-none">
                                                {{ $article->title }}
                                            </h3>
                                            <p class="text-white/40 text-[13px] font-bold uppercase tracking-widest mb-6 truncate flex items-center gap-2">
                                                <span class="w-4 h-px bg-white/20"></span>
                                                {{ $article->song->artist->name ?? 'Unknown Artist' }}
                                            </p>
                                            
                                            <div class="flex items-center justify-between mt-auto">
                                                <div class="flex items-center gap-2 group/btn">
                                                    <span class="text-white/40 text-[11px] font-black uppercase tracking-widest group-hover:text-white transition-colors">Listen Now</span>
                                                    <svg class="w-4 h-4 text-blue-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                                </div>
                                                <div class="flex items-center gap-1.5 text-white/30 text-[11px] font-black">
                                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
                                                    {{ number_format($article->view_count ?? 0) }}
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                {{-- Artists Section --}}
                @if($artists->count() > 0)
                    <section class="mb-20">
                        <div class="flex items-center justify-between mb-8">
                            <h2 class="text-[28px] md:text-[34px] font-black text-white uppercase tracking-tighter flex items-center gap-4">
                                <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2L14.4 9L22 9L15.8 13.5L18.2 20.5L12 16L5.8 20.5L8.2 13.5L2 9L9.6 9L12 2Z" />
                                </svg>
                                Artists Matching "{{ $query }}"
                            </h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($artists->take(6) as $article)
                                <div class="card-premium-unified group relative block p-4 !bg-[#161b22]/60 hover:!bg-[#161b22] border border-white/5 hover:border-blue-500/50 transition-all duration-500 hover:-translate-y-1 hover:shadow-[0_0_30px_rgba(59,130,246,0.15)] rounded-[32px]">
                                    <a href="{{ route('wiki.show', $article) }}" class="block">
                                        {{-- Image --}}
                                        <div class="relative aspect-video rounded-[24px] overflow-hidden mb-6 border border-white/5 group-hover:border-white/10 transition-colors">
                                            <img src="{{ $article->featured_image }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000" alt="{{ $article->title }}">
                                            {{-- Badges --}}
                                            <div class="absolute bottom-4 left-4">
                                                <span class="px-3 py-1 rounded bg-black/60 backdrop-blur-md border border-white/10 text-white text-[10px] font-black uppercase tracking-widest flex items-center gap-2 shadow-lg">
                                                    <svg class="w-3 h-3 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                                    Verified Artist
                                                </span>
                                            </div>
                                        </div>

                                        {{-- Content --}}
                                        <div class="px-2 pb-2">
                                            <div class="flex items-center gap-2 mb-3">
                                                <span class="px-2 py-0.5 rounded bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[10px] font-black uppercase tracking-widest">Artist</span>
                                                <span class="w-1 h-1 rounded-full bg-white/20"></span>
                                                <span class="text-white/40 text-[11px] font-bold uppercase tracking-widest">{{ number_format($article->view_count ?? 0) }} Views</span>
                                            </div>
                                            
                                            <h3 class="text-[32px] font-black text-white uppercase tracking-tighter mb-4 leading-[0.9] group-hover:text-blue-500 transition-colors">
                                                {{ $article->title }}
                                            </h3>
                                            
                                            <div class="flex items-center justify-between mt-auto">
                                                <div class="flex items-center gap-2 group/btn">
                                                    <span class="text-white/40 text-[11px] font-black uppercase tracking-widest group-hover:text-white transition-colors">View Profile</span>
                                                    <div class="w-6 h-6 rounded-full bg-white/5 border border-white/10 flex items-center justify-center group-hover:bg-blue-600 group-hover:border-blue-500 transition-all">
                                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7-7 7m7-7H3"/></svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                {{-- Genres Section --}}
                @if($genres->count() > 0)
                    <section class="mb-20">
                        <div class="flex items-center justify-between mb-8">
                            <h2 class="text-[28px] md:text-[34px] font-black text-white uppercase tracking-tighter flex items-center gap-4">
                                <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2L14.4 9L22 9L15.8 13.5L18.2 20.5L12 16L5.8 20.5L8.2 13.5L2 9L9.6 9L12 2Z" />
                                </svg>
                                Genres Related to "{{ $query }}"
                            </h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach($genres->take(8) as $article)
                                <a href="{{ route('wiki.show', $article) }}" class="card-premium-unified group block p-8 !bg-[#161b22]/60 hover:!bg-[#161b22] border border-white/5 hover:border-blue-500/50 transition-all duration-500 hover:-translate-y-1 hover:shadow-[0_0_30px_rgba(59,130,246,0.15)]">
                                    <div class="flex items-center justify-between mb-6">
                                        <span class="px-2 py-1 rounded bg-white/5 border border-white/10 text-[10px] font-bold text-white/40 uppercase tracking-widest group-hover:bg-blue-500/10 group-hover:text-blue-400 group-hover:border-blue-500/20 transition-all">
                                            {{ optional($article->created_at)->year }}s
                                        </span>
                                        <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 transform scale-75 group-hover:scale-100">
                                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7-7 7"/></svg>
                                        </div>
                                    </div>
                                    
                                    <h3 class="text-[28px] font-black text-white uppercase tracking-tighter mb-4 leading-[0.9] group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-white group-hover:to-white/60 transition-all">
                                        {{ $article->title }}
                                    </h3>
                                    
                                    <p class="text-white/40 text-[13px] font-medium leading-relaxed mb-8 line-clamp-3 group-hover:text-white/60 transition-colors">
                                        {{ Str::limit(strip_tags($article->content), 90) }}
                                    </p>
                                    
                                    <div class="flex items-center gap-3 mt-auto">
                                        <span class="text-blue-500 text-[10px] font-black uppercase tracking-[0.2em] group-hover:translate-x-1 transition-transform duration-300">View Genre</span>
                                        <div class="w-1.5 h-1.5 rounded-full bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.8)] animate-pulse"></div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif

            @else
                {{-- No Results --}}
                <div class="text-center py-20">
                    <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-blue-600/10 to-purple-600/10 rounded-full flex items-center justify-center border border-white/5 shadow-[0_0_30px_rgba(59,130,246,0.05)]">
                        <svg class="w-8 h-8 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    
                    <h3 class="text-[32px] font-black text-white uppercase tracking-tighter mb-4">No Matches Found</h3>
                    <p class="text-white/40 text-[16px] font-bold uppercase tracking-widest mb-12 max-w-md mx-auto leading-relaxed">
                        We couldn't find any results for "{{ $query }}".<br>Try a different keyword or category.
                    </p>
                    
                    <div class="flex flex-col md:flex-row items-center justify-center gap-6">
                        <button wire:click="clearSearch" class="px-8 py-3 rounded-full border border-white/10 text-[14px] font-bold text-white hover:bg-white/5 hover:border-white/30 transition-all">
                            Clear Search
                        </button>
                        
                        <div class="flex items-center gap-4">
                            <button wire:click="requestArchivalEntry('{{ addslashes($query) }}', 'general')" 
                                class="px-8 py-3 bg-emerald-600 hover:bg-emerald-500 rounded-full text-[14px] text-white font-black uppercase tracking-widest transition-all shadow-[0_0_20px_rgba(16,185,129,0.3)] hover:scale-105 active:scale-95 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                Request as Archival Target
                            </button>
                            
                            <a href="{{ route('wiki.create') }}" class="px-8 py-3 bg-white hover:bg-gray-100 rounded-full text-[14px] text-black font-black uppercase tracking-widest transition-all shadow-[0_0_20px_rgba(255,255,255,0.3)] hover:shadow-[0_0_30px_rgba(255,255,255,0.5)]">
                                Manual Entry
                            </a>
                        </div>
                    </div>

                    @if (session()->has('message'))
                        <div class="mt-8 text-emerald-400 text-[14px] font-black uppercase tracking-widest animate-bounce">
                            {{ session('message') }}
                        </div>
                    @endif
                </div>
            @endif

        </div>
    </div>
</div>
