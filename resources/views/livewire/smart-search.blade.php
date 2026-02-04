<div>
    {{-- Clean Background --}}
    <div class="fixed inset-0 bg-gradient-to-b from-[#0a0e14] via-[#0f1419] to-[#0a0e14]" style="z-index: 0;"></div>
    
    {{-- Subtle accent glow --}}
    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-[#38bdf8]/5 rounded-full blur-[150px] pointer-events-none" style="z-index: 0;"></div>

    {{-- Main Content --}}
    <div class="relative min-h-screen pt-28" style="z-index: 1;">
        <div class="max-w-5xl mx-auto px-6 sm:px-8 lg:px-10 py-8">
            
            {{-- SEARCH HEADER --}}
            <div class="text-center mb-10">
                
                @if(!empty($query))
                    {{-- Results Header --}}
                    <h1 class="text-2xl sm:text-3xl font-bold text-white mb-4">
                        Results for "<span class="text-[#38bdf8]">{{ $query }}</span>"
                    </h1>
                    <p class="text-sm text-white/40">
                        Found <span class="text-white font-medium">{{ $results ? $results->total() : 0 }}</span> entries
                    </p>
                @else
                    {{-- Welcome State --}}
                    <h1 class="text-3xl sm:text-4xl font-bold text-white mb-3">
                        Search <span class="text-[#38bdf8]">ChaynWiki</span>
                    </h1>
                    <p class="text-base text-white/40 max-w-xl mx-auto">
                        Find songs, artists, genres, and music knowledge
                    </p>
                @endif
            </div>

            {{-- ═══════════════════════════════════════════════════════════ --}}
            {{-- SEARCH INPUT --}}
            <div class="max-w-2xl mx-auto mb-10" x-data="{ open: @entangle('showSuggestions'), focused: false }">
                <form wire:submit="search" class="relative">
                    {{-- Input Container --}}
                    <div class="relative bg-[#151c24] border border-white/10 rounded-xl overflow-hidden focus-within:border-[#38bdf8]/40 transition-colors">
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="query"
                            placeholder="Search songs, artists, genres..."
                            @focus="focused = true; open = true"
                            @blur="setTimeout(() => { focused = false }, 200)"
                            class="w-full bg-transparent px-5 py-4 pl-12 pr-28 text-base text-white placeholder-white/30 focus:outline-none focus:ring-0 border-0"
                            autocomplete="off"
                        >
                        
                        {{-- Search Icon --}}
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        
                        {{-- Search Button --}}
                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 px-4 py-2 bg-[#38bdf8] hover:bg-[#7dd3fc] text-[#0a0e14] font-semibold text-sm rounded-lg transition-colors">
                            Search
                        </button>
                    </div>
                    
                    {{-- Live Suggestions Dropdown --}}
                    @if(!empty($suggestions))
                        <div
                            x-show="open && focused"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1"
                            class="absolute top-full left-0 right-0 mt-2 bg-[#151c24] border border-white/10 rounded-xl shadow-xl overflow-hidden z-50"
                            style="display: none;"
                        >
                            @foreach($suggestions as $suggestion)
                                <button
                                    type="button"
                                    wire:click="selectSuggestion('{{ addslashes($suggestion) }}')"
                                    @click="open = false"
                                    class="w-full px-4 py-3 text-left hover:bg-white/5 transition-colors flex items-center gap-3 text-white/70 hover:text-white"
                                >
                                    <svg class="w-4 h-4 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    {{ $suggestion }}
                                </button>
                            @endforeach
                        </div>
                    @endif
                </form>
            </div>

            {{-- FILTER BAR --}}
            <div class="flex flex-wrap items-center justify-center gap-3 mb-10">
                {{-- Category Filter Pills --}}
                <div class="flex items-center gap-1 p-1 bg-white/5 border border-white/5 rounded-lg">
                    <button wire:click="$set('category', 'all')" class="px-4 py-2 rounded-md text-sm transition-colors {{ $category === 'all' ? 'bg-[#38bdf8] text-[#0a0e14] font-medium' : 'text-white/60 hover:text-white' }}">All</button>
                    <button wire:click="$set('category', 'song')" class="px-4 py-2 rounded-md text-sm transition-colors {{ $category === 'song' ? 'bg-[#38bdf8] text-[#0a0e14] font-medium' : 'text-white/60 hover:text-white' }}">Songs</button>
                    <button wire:click="$set('category', 'artist')" class="px-4 py-2 rounded-md text-sm transition-colors {{ $category === 'artist' ? 'bg-[#38bdf8] text-[#0a0e14] font-medium' : 'text-white/60 hover:text-white' }}">Artists</button>
                    <button wire:click="$set('category', 'genre')" class="px-4 py-2 rounded-md text-sm transition-colors {{ $category === 'genre' ? 'bg-[#38bdf8] text-[#0a0e14] font-medium' : 'text-white/60 hover:text-white' }}">Genres</button>
                </div>
                
                {{-- Sort Dropdown --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-2 px-4 py-2 bg-white/5 border border-white/5 rounded-lg text-sm text-white/60 hover:text-white transition-colors">
                        <span>{{ $sortBy === 'relevance' ? 'Trending' : ($sortBy === 'newest' ? 'Newest' : 'Most Viewed') }}</span>
                        <svg class="w-4 h-4" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    
                    <div x-show="open" @click.away="open = false" x-transition class="absolute top-full right-0 mt-2 w-40 bg-[#151c24] border border-white/10 rounded-lg shadow-xl overflow-hidden z-50" style="display: none;">
                        <button wire:click="$set('sortBy', 'relevance')" @click="open = false" class="w-full px-4 py-2.5 text-left text-sm hover:bg-white/5 {{ $sortBy === 'relevance' ? 'text-[#38bdf8]' : 'text-white/70' }}">Trending</button>
                        <button wire:click="$set('sortBy', 'newest')" @click="open = false" class="w-full px-4 py-2.5 text-left text-sm hover:bg-white/5 {{ $sortBy === 'newest' ? 'text-[#38bdf8]' : 'text-white/70' }}">Newest</button>
                        <button wire:click="$set('sortBy', 'views')" @click="open = false" class="w-full px-4 py-2.5 text-left text-sm hover:bg-white/5 {{ $sortBy === 'views' ? 'text-[#38bdf8]' : 'text-white/70' }}">Most Viewed</button>
                    </div>
                </div>
            </div>

            {{-- SEARCH RESULTS / EMPTY STATES --}}
            
            @if(empty($query))
                {{-- Trending Section --}}
                @if(!empty($trending))
                    <div class="mb-12">
                        <h3 class="text-sm font-medium text-white/50 mb-4 text-center">Trending searches</h3>
                        <div class="flex flex-wrap justify-center gap-2">
                            @foreach($trending as $term)
                                <button wire:click="selectSuggestion('{{ addslashes($term) }}')" class="px-4 py-2 bg-white/5 hover:bg-[#38bdf8] border border-white/10 hover:border-[#38bdf8] rounded-lg text-sm text-white/60 hover:text-[#0a0e14] transition-colors">
                                    {{ $term }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                {{-- Quick Access --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-3xl mx-auto">
                    <a href="{{ route('wiki.create') }}" class="group p-6 bg-white/5 border border-white/5 rounded-xl hover:border-[#38bdf8]/30 transition-colors text-center">
                        <svg class="w-8 h-8 text-[#38bdf8] mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <h3 class="font-medium text-white mb-1">Create</h3>
                        <p class="text-xs text-white/40">Add new content</p>
                    </a>
                    <a href="{{ route('wiki.index') }}" class="group p-6 bg-white/5 border border-white/5 rounded-xl hover:border-[#a78bfa]/30 transition-colors text-center">
                        <svg class="w-8 h-8 text-[#a78bfa] mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        <h3 class="font-medium text-white mb-1">Browse</h3>
                        <p class="text-xs text-white/40">Explore archive</p>
                    </a>
                    <a href="{{ route('wiki.artists') }}" class="group p-6 bg-white/5 border border-white/5 rounded-xl hover:border-[#2dd4bf]/30 transition-colors text-center">
                        <svg class="w-8 h-8 text-[#2dd4bf] mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <h3 class="font-medium text-white mb-1">Artists</h3>
                        <p class="text-xs text-white/40">View profiles</p>
                    </a>
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
                    <section class="mb-10">
                        <h2 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 bg-[#38bdf8] rounded-full"></span>
                            Songs <span class="text-white/40 font-normal">({{ $songs->count() }})</span>
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($songs->take(6) as $article)
                                <a href="{{ route('wiki.show', $article) }}" wire:navigate class="group flex gap-4 p-4 bg-white/5 border border-white/5 rounded-xl hover:border-[#38bdf8]/30 transition-colors">
                                    <div class="w-16 h-16 flex-shrink-0 bg-[#38bdf8]/10 rounded-lg flex items-center justify-center overflow-hidden">
                                        @if($article->featured_image)
                                            <img src="{{ $article->featured_image }}" alt="{{ $article->title }}" class="w-full h-full object-cover" onerror="this.parentElement.innerHTML='<svg class=\'w-6 h-6 text-[#38bdf8]/50\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3\'/></svg>'">
                                        @else
                                            <svg class="w-6 h-6 text-[#38bdf8]/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-medium text-white group-hover:text-[#38bdf8] transition-colors truncate">{{ $article->title }}</h3>
                                        <p class="text-sm text-white/40 truncate">{{ $article->song->artist->name ?? 'Unknown Artist' }}</p>
                                        <span class="text-xs text-white/20">{{ number_format($article->view_count ?? 0) }} views</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif

                {{-- Artists Section --}}
                @if($artists->count() > 0)
                    <section class="mb-10">
                        <h2 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 bg-[#a78bfa] rounded-full"></span>
                            Artists <span class="text-white/40 font-normal">({{ $artists->count() }})</span>
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($artists->take(6) as $article)
                                <a href="{{ route('wiki.show', $article) }}" wire:navigate class="group flex gap-4 p-4 bg-white/5 border border-white/5 rounded-xl hover:border-[#a78bfa]/30 transition-colors">
                                    <div class="w-16 h-16 flex-shrink-0 bg-[#a78bfa]/10 rounded-lg flex items-center justify-center overflow-hidden">
                                        @if($article->featured_image)
                                            <img src="{{ $article->featured_image }}" alt="{{ $article->title }}" class="w-full h-full object-cover" onerror="this.parentElement.innerHTML='<svg class=\'w-6 h-6 text-[#a78bfa]/50\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z\'/></svg>'">
                                        @else
                                            <svg class="w-6 h-6 text-[#a78bfa]/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-medium text-white group-hover:text-[#a78bfa] transition-colors truncate">{{ $article->title }}</h3>
                                        <p class="text-sm text-white/40 truncate">{{ Str::limit($article->excerpt, 50) ?? 'View profile' }}</p>
                                        <span class="text-xs text-white/20">{{ number_format($article->view_count ?? 0) }} views</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif

                {{-- Genres Section --}}
                @if($genres->count() > 0)
                    <section class="mb-10">
                        <h2 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 bg-[#2dd4bf] rounded-full"></span>
                            Genres <span class="text-white/40 font-normal">({{ $genres->count() }})</span>
                        </h2>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            @foreach($genres->take(8) as $article)
                                <a href="{{ route('wiki.show', $article) }}" wire:navigate class="group p-4 bg-white/5 border border-white/5 rounded-xl hover:border-[#2dd4bf]/30 transition-colors">
                                    <h3 class="font-medium text-white group-hover:text-[#2dd4bf] transition-colors truncate">{{ $article->title }}</h3>
                                    <p class="text-xs text-white/30 truncate mt-1">{{ Str::limit(strip_tags($article->content), 40) }}</p>
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif

                {{-- Other Results --}}
                @if($others->count() > 0)
                    <section class="mb-10">
                        <h2 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 bg-white/40 rounded-full"></span>
                            Other <span class="text-white/40 font-normal">({{ $others->count() }})</span>
                        </h2>
                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach($others as $article)
                                <a href="{{ route('wiki.show', $article) }}" wire:navigate class="group flex items-center gap-3 p-3 bg-white/5 border border-white/5 rounded-lg hover:border-white/10 transition-colors">
                                    <span class="px-2 py-0.5 bg-white/5 text-white/40 text-xs rounded">{{ $article->category }}</span>
                                    <h3 class="text-sm text-white group-hover:text-[#38bdf8] transition-colors truncate flex-1">{{ $article->title }}</h3>
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $results->links() }}
                </div>
                
            @elseif($results && $results->count() === 0)
                {{-- No Results --}}
                <div class="text-center py-16">
                    <div class="w-20 h-20 mx-auto mb-6 bg-white/5 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    
                    <h3 class="text-xl font-semibold text-white mb-2">No results found</h3>
                    <p class="text-white/40 mb-8 max-w-md mx-auto">
                        We couldn't find anything matching "<span class="text-[#38bdf8]">{{ $query }}</span>"
                    </p>
                    
                    <div class="flex items-center justify-center gap-3">
                        <button wire:click="clearSearch" class="px-5 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 text-white text-sm rounded-lg transition-colors">
                            Clear search
                        </button>
                        <a href="{{ route('wiki.create') }}" class="px-5 py-2.5 bg-[#38bdf8] hover:bg-[#7dd3fc] text-[#0a0e14] text-sm font-medium rounded-lg transition-colors">
                            Create entry
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
