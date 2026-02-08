<div>
    {{-- Background Blobs match homepage --}}
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-[#3b82f6]/10 blur-[120px] rounded-full"></div>
        <div class="absolute bottom-[10%] right-[-10%] w-[30%] h-[30%] bg-purple-600/10 blur-[120px] rounded-full"></div>
        <div class="absolute top-[40%] right-[10%] w-[20%] h-[20%] bg-[#3b82f6]/5 blur-[100px] rounded-full"></div>
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
            <div class="max-w-4xl mx-auto mb-20">
                {{-- Filters & Sort Bar --}}
                <div class="flex flex-wrap items-center justify-center gap-4 mb-8">
                    <span class="text-white/20 text-[11px] font-black uppercase tracking-widest mr-2">Filters</span>
                    
                    <button wire:click="$set('category', 'all')" 
                        class="px-6 py-2 rounded-full border text-[13px] font-bold transition-all {{ $category === 'all' ? 'bg-white text-black border-white' : 'border-white/10 text-white/50 hover:border-white/20' }}">
                        All
                    </button>
                    
                    <button wire:click="$set('category', 'song')" 
                        class="px-6 py-2 rounded-full border text-[13px] font-bold transition-all {{ $category === 'song' ? 'bg-white text-black border-white' : 'border-white/10 text-white/50 hover:border-white/20' }}">
                        Songs
                    </button>
                    
                    <button wire:click="$set('category', 'artist')" 
                        class="px-6 py-2 rounded-full border text-[13px] font-bold transition-all {{ $category === 'artist' ? 'bg-white text-black border-white' : 'border-white/10 text-white/50 hover:border-white/20' }}">
                        Artists
                    </button>

                    <div class="w-px h-4 bg-white/10 mx-2"></div>

                    <span class="text-white/20 text-[11px] font-black uppercase tracking-widest mr-2">Sort By</span>
                    
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" 
                            class="flex items-center gap-3 px-6 py-2 bg-transparent border border-white/10 rounded-full text-[13px] font-bold text-white hover:border-white/20 transition-all">
                            <span>{{ $sortBy === 'relevance' ? 'Trending Now' : ($sortBy === 'newest' ? 'Newest Added' : 'Most Viewed') }}</span>
                            <svg class="w-4 h-4 text-white/30" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" x-transition 
                            class="absolute top-full right-0 mt-3 w-48 bg-[#161b22] border border-white/10 rounded-2xl shadow-2xl overflow-hidden z-50 py-2" style="display: none;">
                            <button wire:click="$set('sortBy', 'relevance')" @click="open = false" class="w-full px-5 py-2.5 text-left text-[13px] font-bold hover:bg-white/5 {{ $sortBy === 'relevance' ? 'text-blue-500' : 'text-white/60' }}">Trending Now</button>
                            <button wire:click="$set('sortBy', 'newest')" @click="open = false" class="w-full px-5 py-2.5 text-left text-[13px] font-bold hover:bg-white/5 {{ $sortBy === 'newest' ? 'text-blue-500' : 'text-white/60' }}">Most Recent</button>
                            <button wire:click="$set('sortBy', 'views')" @click="open = false" class="w-full px-5 py-2.5 text-left text-[13px] font-bold hover:bg-white/5 {{ $sortBy === 'views' ? 'text-blue-500' : 'text-white/60' }}">Most Popular</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SEARCH RESULTS / EMPTY STATES --}}
            
            @if(empty($query))
                {{-- Trending & Quick Access Section --}}
                <div class="max-w-5xl mx-auto">
                    @if(!empty($trending))
                        <div class="mb-20">
                            <h3 class="text-white/20 text-[11px] font-black uppercase tracking-widest text-center mb-8">Trending Searches</h3>
                            <div class="flex flex-wrap justify-center gap-4">
                                @foreach($trending as $term)
                                    <button wire:click="selectSuggestion('{{ addslashes($term) }}')" 
                                        class="px-8 py-3 rounded-full border border-white/10 text-[14px] font-bold text-white hover:bg-white hover:text-black hover:border-white transition-all duration-300">
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
                                <div class="group relative bg-[#161b22]/40 rounded-[32px] border border-white/5 p-4 hover:border-blue-500/30 transition-all duration-500">
                                    <a href="{{ route('wiki.show', $article) }}" class="block">
                                        {{-- Image --}}
                                        <div class="relative aspect-[4/3] rounded-[24px] overflow-hidden mb-6">
                                            <img src="{{ $article->featured_image }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $article->title }}">
                                            {{-- Badges --}}
                                            <div class="absolute top-4 left-4 flex flex-col gap-2">
                                                <span class="px-3 py-1 rounded-full bg-blue-600/80 backdrop-blur-md text-white text-[10px] font-black uppercase tracking-widest">Trending</span>
                                            </div>
                                        </div>

                                        {{-- Content --}}
                                        <div class="px-2">
                                            <div class="flex items-center gap-2 mb-2">
                                                <span class="text-blue-500 text-[11px] font-black uppercase tracking-widest">Song</span>
                                                <span class="w-1 h-1 rounded-full bg-white/20"></span>
                                                <span class="text-white/40 text-[11px] font-bold uppercase tracking-widest">{{ optional($article->created_at)->year }}</span>
                                            </div>
                                            <h3 class="text-[24px] font-black text-white uppercase tracking-tighter mb-1 line-clamp-1 group-hover:text-blue-500 transition-colors">
                                                {{ $article->title }}
                                            </h3>
                                            <p class="text-white/40 text-[14px] font-bold uppercase tracking-widest mb-6 truncate">{{ $article->song->artist->name ?? 'Unknown Artist' }}</p>
                                            
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-3 bg-white hover:bg-gray-100 px-5 py-2.5 rounded-full transition-all group/btn">
                                                    <span class="text-[#0d1117] text-[12px] font-black uppercase tracking-widest">View Details</span>
                                                    <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center group-hover/btn:scale-110 transition-transform">
                                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-2 text-white/30 text-[12px] font-black">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
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
                                <div class="group relative bg-[#161b22]/40 rounded-[32px] border border-white/5 p-4 hover:border-blue-500/30 transition-all duration-500">
                                    <a href="{{ route('wiki.show', $article) }}" class="block">
                                        {{-- Image --}}
                                        <div class="relative aspect-video rounded-[24px] overflow-hidden mb-6">
                                            <img src="{{ $article->featured_image }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $article->title }}">
                                            {{-- Badges --}}
                                            <div class="absolute bottom-4 left-4">
                                                <span class="px-3 py-1 rounded bg-blue-600/90 backdrop-blur-md text-white text-[10px] font-black uppercase tracking-widest flex items-center gap-2">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                                    Verified Artist
                                                </span>
                                            </div>
                                        </div>

                                        {{-- Content --}}
                                        <div class="px-2">
                                            <div class="flex items-center gap-2 mb-2">
                                                <span class="text-blue-500 text-[11px] font-black uppercase tracking-widest">Artist</span>
                                                <span class="w-1 h-1 rounded-full bg-white/20"></span>
                                                <span class="text-white/40 text-[11px] font-bold uppercase tracking-widest">{{ $article->category }}</span>
                                            </div>
                                            <h3 class="text-[32px] font-black text-white uppercase tracking-tighter mb-4 group-hover:text-blue-500 transition-colors">
                                                {{ $article->title }}
                                            </h3>
                                            
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-3 bg-white hover:bg-gray-100 px-5 py-2.5 rounded-full transition-all group/btn">
                                                    <span class="text-[#0d1117] text-[12px] font-black uppercase tracking-widest">View Artist Profile</span>
                                                    <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center group-hover/btn:scale-110 transition-transform">
                                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-2 text-white/30 text-[12px] font-black">
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

                {{-- Genres Section --}}
                @if($genres->count() > 0)
                    <section class="mb-20">
                        <h2 class="text-[28px] md:text-[34px] font-black text-white uppercase tracking-tighter flex items-center gap-4 mb-8">
                            <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2L14.4 9L22 9L15.8 13.5L18.2 20.5L12 16L5.8 20.5L8.2 13.5L2 9L9.6 9L12 2Z" />
                            </svg>
                            Genres Related to "{{ $query }}"
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach($genres->take(8) as $article)
                                <a href="{{ route('wiki.show', $article) }}" class="group block p-8 bg-[#161b22]/40 rounded-[32px] border border-white/5 hover:border-blue-500/30 transition-all duration-500">
                                    <div class="text-white/20 text-[12px] font-black uppercase tracking-widest mb-2">{{ optional($article->created_at)->format('19y\s') }}</div>
                                    <h3 class="text-[24px] font-black text-white uppercase tracking-tighter mb-4 group-hover:text-blue-500 transition-colors">{{ $article->title }}</h3>
                                    <p class="text-white/40 text-[13px] font-medium leading-relaxed mb-6 line-clamp-2">
                                        {{ Str::limit(strip_tags($article->content), 80) }}
                                    </p>
                                    <div class="flex items-center gap-3">
                                        <span class="text-blue-500 text-[11px] font-black uppercase tracking-widest">View Genre</span>
                                        <div class="w-5 h-5 bg-blue-600 rounded-full flex items-center justify-center">
                                            <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif


                
            @elseif($results && $results->count() === 0)
                {{-- No Results --}}
                <div class="text-center py-32">
                    <div class="w-24 h-24 mx-auto mb-8 bg-blue-600/10 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    
                    <h3 class="text-[32px] font-black text-white uppercase tracking-tighter mb-4">No Matches Found</h3>
                    <p class="text-white/40 text-[16px] font-bold uppercase tracking-widest mb-12 max-w-md mx-auto leading-relaxed">
                        We couldn't find any results for "{{ $query }}".<br>Try a different keyword or category.
                    </p>
                    
                    <div class="flex items-center justify-center gap-6">
                        <button wire:click="clearSearch" class="px-8 py-3 rounded-full border border-white/10 text-[14px] font-bold text-white hover:border-white/30 transition-all">
                            Clear Search
                        </button>
                        <a href="{{ route('wiki.create') }}" class="px-8 py-3 bg-white hover:bg-gray-100 rounded-full text-[14px] text-black font-black uppercase tracking-widest transition-all">
                            Create Entry
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
