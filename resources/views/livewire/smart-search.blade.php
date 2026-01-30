    <!-- Background Glow Effects -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute top-20 left-1/4 w-[600px] h-[600px] bg-blue-500/5 blur-[150px]"></div>
        <div class="absolute bottom-20 right-1/4 w-[400px] h-[400px] bg-purple-500/5 blur-[120px]"></div>
    </div>

    <!-- Header with Search Query -->
    <div class="relative z-10 max-w-7xl mx-auto px-6 py-8">
        <!-- Query & Results Count - Premium Header -->
        <div class="text-center mb-16">
            @if($query)
                <span class="inline-block px-4 py-1.5 bg-blue-500/5 border border-blue-500/10 rounded-full text-blue-500 text-[9px] font-black uppercase tracking-[0.2em] mb-4">
                    Registry Results
                </span>
                <h1 class="text-4xl md:text-6xl font-black text-white italic uppercase tracking-tighter mb-4 leading-none">
                    "{{ $query }}"
                </h1>
            @else
                <h1 class="text-4xl md:text-6xl font-black text-white italic uppercase tracking-tighter mb-4 leading-none">
                    EXPLORE THE <span class="text-blue-500">ARCHIVE</span>
                </h1>
            @endif
            @if($results && $results->count() > 0)
                <p class="text-[10px] font-black text-white/20 uppercase tracking-[0.2em]">
                    Found <span class="text-blue-500">{{ $results->total() }}</span> distributed records
                </p>
            @elseif($query)
                <p class="text-[10px] font-black text-red-500/40 uppercase tracking-[0.2em]">Zero matches detected</p>
            @else
                <p class="text-[10px] font-black text-white/20 uppercase tracking-[0.2em]">Access the global music knowledge protocol</p>
            @endif
        </div>

        <!-- Search Input - Premium Style -->
        <div class="max-w-2xl mx-auto mb-12" x-data="{ open: @entangle('showSuggestions'), focused: false }">
            <form wire:submit="search" class="relative px-4 sm:px-0">
                <div class="relative group">
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="query"
                        placeholder="Search artists, songs, genres..."
                        @focus="focused = true"
                        @blur="focused = false"
                        class="w-full bg-secondary border border-white/5 rounded-xl px-6 py-4.5 pl-14 text-lg text-white placeholder-white/10 focus:border-blue-500/20 focus:ring-0 focus:bg-white/[0.04] transition-all shadow-2xl"
                        autocomplete="off"
                    >
                    <svg class="absolute left-6 top-1/2 -translate-y-1/2 w-4 h-4 text-white/10 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <!-- Loading Indicator -->
                    <div wire:loading wire:target="query" class="absolute right-5 top-1/2 -translate-y-1/2">
                        <div class="w-5 h-5 border-2 border-blue-500/30 border-t-blue-500 rounded-full animate-spin"></div>
                    </div>
                    @if($query)
                        <button wire:loading.remove wire:target="query" type="button" wire:click="clearSearch" class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-500 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    @endif
                </div>
            </form>

            <div
                x-show="open && $wire.suggestions.length > 0"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                @click.away="open = false"
                class="absolute z-50 w-full max-w-2xl mt-3 bg-secondary border border-white/5 rounded-2xl shadow-2xl overflow-hidden"
            >
                @foreach($suggestions as $suggestion)
                    <button
                        wire:click="selectSuggestion('{{ addslashes($suggestion) }}')"
                        class="w-full px-6 py-4 text-left text-[11px] font-black uppercase tracking-widest text-white/30 hover:bg-white/5 hover:text-white transition-colors flex items-center gap-3 border-b border-white/5 last:border-0"
                    >
                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <span class="font-medium">{{ $suggestion }}</span>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Filters Row - Custom Dropdowns -->
        <div class="flex items-center justify-center gap-4 mb-12">
            <!-- Category Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button 
                    @click="open = !open" 
                    @click.away="open = false"
                    class="flex items-center gap-3 bg-secondary border border-white/5 hover:border-white/10 rounded-xl px-5 py-3 transition-all"
                >
                    <span class="text-white/20 text-[9px] font-black uppercase tracking-widest italic">Category</span>
                    <span class="text-white text-[10px] font-black uppercase tracking-widest">
                        @switch($category)
                            @case('all') All @break
                            @case('song') Songs @break
                            @case('artist') Artists @break
                            @case('genre') Genres @break
                            @case('playlist') Playlists @break
                        @endswitch
                    </span>
                    <svg class="w-3 h-3 text-white/20 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div 
                    x-show="open" 
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-2"
                    class="absolute top-full left-0 mt-2 w-48 bg-secondary border border-white/5 rounded-xl shadow-2xl overflow-hidden z-50"
                    style="display: none;"
                >
                    <button wire:click="$set('category', 'all')" @click="open = false" class="w-full px-5 py-3 text-left text-[9px] font-black uppercase tracking-widest hover:bg-white/5 transition-colors {{ $category === 'all' ? 'text-blue-500 bg-white/5' : 'text-white/30' }}">All</button>
                    <button wire:click="$set('category', 'song')" @click="open = false" class="w-full px-5 py-3 text-left text-[9px] font-black uppercase tracking-widest hover:bg-white/5 transition-colors {{ $category === 'song' ? 'text-blue-500 bg-white/5' : 'text-white/30' }}">Songs</button>
                    <button wire:click="$set('category', 'artist')" @click="open = false" class="w-full px-5 py-3 text-left text-[9px] font-black uppercase tracking-widest hover:bg-white/5 transition-colors {{ $category === 'artist' ? 'text-blue-500 bg-white/5' : 'text-white/30' }}">Artists</button>
                    <button wire:click="$set('category', 'genre')" @click="open = false" class="w-full px-5 py-3 text-left text-[9px] font-black uppercase tracking-widest hover:bg-white/5 transition-colors {{ $category === 'genre' ? 'text-blue-500 bg-white/5' : 'text-white/30' }}">Genres</button>
                    <button wire:click="$set('category', 'playlist')" @click="open = false" class="w-full px-5 py-3 text-left text-[9px] font-black uppercase tracking-widest hover:bg-white/5 transition-colors {{ $category === 'playlist' ? 'text-blue-500 bg-white/5' : 'text-white/30' }}">Playlists</button>
                </div>
            </div>

            <!-- Sort Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button 
                    @click="open = !open" 
                    @click.away="open = false"
                    class="flex items-center gap-3 bg-secondary border border-white/5 hover:border-white/10 rounded-xl px-5 py-3 transition-all"
                >
                    <span class="text-white/20 text-[9px] font-black uppercase tracking-widest italic">Sort</span>
                    <span class="text-white text-[10px] font-black uppercase tracking-widest">
                        @switch($sortBy)
                            @case('relevance') Trending @break
                            @case('newest') Newest @break
                            @case('views') Most Viewed @break
                        @endswitch
                    </span>
                    <svg class="w-3 h-3 text-white/20 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div 
                    x-show="open" 
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute top-full left-0 mt-2 w-48 bg-[#0A0A14] border border-white/10 rounded-2xl shadow-2xl overflow-hidden z-50"
                    style="display: none;"
                >
                    <button wire:click="$set('sortBy', 'relevance')" @click="open = false" class="w-full px-5 py-3 text-left text-sm hover:bg-blue-500/10 transition-colors {{ $sortBy === 'relevance' ? 'text-blue-400 bg-blue-500/5' : 'text-gray-300' }}">Trending</button>
                    <button wire:click="$set('sortBy', 'newest')" @click="open = false" class="w-full px-5 py-3 text-left text-sm hover:bg-blue-500/10 transition-colors {{ $sortBy === 'newest' ? 'text-blue-400 bg-blue-500/5' : 'text-gray-300' }}">Newest</button>
                    <button wire:click="$set('sortBy', 'views')" @click="open = false" class="w-full px-5 py-3 text-left text-sm hover:bg-blue-500/10 transition-colors {{ $sortBy === 'views' ? 'text-blue-400 bg-blue-500/5' : 'text-gray-300' }}">Most Viewed</button>
                </div>
            </div>
        </div>

        @if(empty($query))
            <!-- Trending Searches (when no query) -->
            @if(!empty($trending))
                <div class="text-center py-12">
                    <h2 class="text-[9px] font-black uppercase tracking-[0.3em] text-white/10 mb-6 italic">Hot Protocols</h2>
                    <div class="flex flex-wrap justify-center gap-3">
                        @foreach($trending as $term)
                            <button
                                wire:click="selectSuggestion('{{ addslashes($term) }}')"
                                class="px-5 py-2.5 bg-secondary hover:bg-blue-600 border border-white/5 hover:border-blue-500/20 rounded-xl text-white/30 hover:text-white text-[10px] font-black uppercase tracking-widest transition-all"
                            >
                                {{ $term }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif
        @elseif($results && $results->count() > 0)
            @php
                $songs = $results->where('category', 'song');
                $artists = $results->where('category', 'artist');
                $genres = $results->where('category', 'genre');
                $others = $results->whereNotIn('category', ['song', 'artist', 'genre']);
            @endphp

            <!-- Songs Matching Section -->
            @if($songs->count() > 0)
                <section class="mb-20">
                    <div class="flex items-center justify-between mb-8 px-2">
                        <h2 class="text-xl font-black text-white italic uppercase tracking-tighter">
                            Songs Matching: <span class="text-blue-500">"{{ $query }}"</span>
                        </h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($songs->take(3) as $article)
                            <a href="{{ route('wiki.show', $article) }}" wire:navigate class="group bg-secondary border border-white/5 rounded-2xl overflow-hidden hover:border-blue-500/20 transition-all shadow-xl">
                                <div class="aspect-video bg-white/5 relative overflow-hidden">
                                    <!-- Fallback Icon (always present) -->
                                    <div class="w-full h-full flex items-center justify-center absolute inset-0 z-0" id="search-fallback-{{ $article->id }}">
                                        <svg class="w-12 h-12 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                    </div>
                                    @if($article->featured_image)
                                        <img 
                                            src="{{ $article->featured_image }}" 
                                            alt="{{ $article->title }}" 
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 relative z-10"
                                            onerror="this.style.display='none'"
                                            onload="document.getElementById('search-fallback-{{ $article->id }}')?.classList.add('hidden')"
                                        >
                                    @endif
                                    <div class="absolute top-3 left-3">
                                        <span class="px-2 py-1 bg-blue-500/80 text-white text-xs font-bold rounded-full">{{ $article->category }}</span>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <h3 class="font-black text-white group-hover:text-blue-500 transition-colors mb-1 uppercase tracking-tight">{{ $article->title }}</h3>
                                    <p class="text-[9px] font-black text-white/20 uppercase tracking-widest mb-4 italic">{{ $article->song->artist->name ?? 'Unknown Identity' }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-blue-400 text-sm font-medium">View Details</span>
                                        <span class="text-xs text-gray-600 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            {{ number_format($article->view_count ?? 0) }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- Artists Matching Section -->
            @if($artists->count() > 0)
                <section class="mb-20">
                    <div class="flex items-center justify-between mb-8 px-2">
                        <h2 class="text-xl font-black text-white italic uppercase tracking-tighter">
                            Artists Matching: <span class="text-blue-500">"{{ $query }}"</span>
                        </h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($artists->take(3) as $article)
                            <a href="{{ route('wiki.show', $article) }}" wire:navigate class="group bg-secondary border border-white/5 rounded-2xl overflow-hidden hover:border-blue-500/20 transition-all shadow-xl">
                                <div class="aspect-video bg-white/5 relative overflow-hidden">
                                    <!-- Fallback Icon (always present) -->
                                    <div class="w-full h-full flex items-center justify-center absolute inset-0 z-0" id="artist-fallback-{{ $article->id }}">
                                        <svg class="w-12 h-12 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    </div>
                                    @if($article->featured_image)
                                        <img 
                                            src="{{ $article->featured_image }}" 
                                            alt="{{ $article->title }}" 
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 relative z-10"
                                            onerror="this.style.display='none'"
                                            onload="document.getElementById('artist-fallback-{{ $article->id }}')?.classList.add('hidden')"
                                        >
                                    @endif
                                    <div class="absolute top-3 left-3">
                                        <span class="px-2 py-1 bg-purple-500/80 text-white text-xs font-bold rounded-full">Artist</span>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <h3 class="font-black text-white group-hover:text-blue-500 transition-colors mb-1 uppercase tracking-tight">{{ $article->title }}</h3>
                                    <p class="text-[9px] font-black text-white/20 uppercase tracking-widest mb-4 italic leading-loose">{{ Str::limit($article->excerpt, 60) ?? 'View authorized profile' }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-blue-400 text-sm font-medium">View Artist Profile</span>
                                        <span class="text-xs text-gray-600 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            {{ number_format($article->view_count ?? 0) }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- Genres Related Section -->
            @if($genres->count() > 0)
                <section class="mb-16">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-bold text-white flex items-center gap-2">
                            <span class="text-gray-500">+</span>
                            Genres Related to "{{ $query }}"
                        </h2>
                        <span class="text-2xl text-gray-700">+</span>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($genres->take(4) as $article)
                            <a href="{{ route('wiki.show', $article) }}" wire:navigate class="group bg-[#0A0A14] border border-white/10 rounded-2xl p-5 hover:border-blue-500/50 transition-all">
                                <span class="text-xs text-gray-600 mb-1 block">{{ $article->subcategory ?? 'genre' }}</span>
                                <h3 class="font-bold text-white group-hover:text-blue-400 transition-colors mb-2">{{ $article->title }}</h3>
                                <p class="text-xs text-gray-500 line-clamp-2 mb-3">{{ Str::limit(strip_tags($article->content), 60) }}</p>
                                <div class="flex items-center gap-2 text-xs text-gray-600">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13"/></svg>
                                    {{ rand(10, 50) }} Artists • {{ rand(100, 999) }} Songs
                                </div>
                                <span class="text-blue-400 text-sm font-medium mt-3 block">View Article</span>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- Other Results -->
            @if($others->count() > 0)
                <section class="mb-16">
                    <h2 class="text-lg font-bold text-white mb-6">Other Results</h2>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($others as $article)
                            <a href="{{ route('wiki.show', $article) }}" wire:navigate class="group bg-[#0A0A14] border border-white/10 rounded-2xl p-6 hover:border-blue-500/50 transition-all">
                                <span class="px-2 py-1 bg-white/10 text-gray-400 text-xs font-bold rounded mb-3 inline-block">{{ $article->category }}</span>
                                <h3 class="font-bold text-white group-hover:text-blue-400 transition-colors">{{ $article->title }}</h3>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- Pagination -->
            <div class="mt-12">
                {{ $results->links() }}
            </div>
        @elseif($results && $results->count() === 0)
            <!-- No Results - Premium Empty State -->
            <div class="text-center py-24">
                <!-- Animated Icon -->
                <div class="relative w-32 h-32 mx-auto mb-8">
                    <div class="absolute inset-0 bg-blue-500/10 rounded-full animate-pulse"></div>
                    <div class="absolute inset-4 bg-[#0A0A14] rounded-full flex items-center justify-center border border-white/10">
                        <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
                
                <h3 class="text-3xl font-display font-black text-white uppercase tracking-tight mb-3">No Results Found</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">
                    We couldn't find anything matching "<span class="text-blue-400 font-medium">{{ $query }}</span>" in our database yet.
                </p>
                
                <div class="flex flex-col sm:flex-row items-center justify-center gap-6 mb-12">
                    <button wire:click="clearSearch" class="px-8 py-4 bg-white/5 hover:bg-white/10 border border-white/5 text-white font-black text-[10px] uppercase tracking-widest rounded-xl transition-all flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Initialize New Protocol
                    </button>
                    <a href="{{ route('wiki.create') }}" class="px-8 py-4 bg-blue-600 hover:bg-blue-500 text-white font-black text-[10px] uppercase tracking-[0.3em] rounded-xl transition-all flex items-center gap-3 shadow-xl shadow-blue-500/10 active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Create Dataset: "{{ $query }}"
                    </a>
                </div>

                <!-- Suggested Actions Card -->
                <div class="max-w-lg mx-auto bg-[#0A0A14] border border-white/10 rounded-3xl p-8 text-left">
                    <h4 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Suggestions</h4>
                    <ul class="space-y-3 text-gray-500 text-sm">
                        <li class="flex items-center gap-3">
                            <span class="w-6 h-6 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-400 text-xs">1</span>
                            Check your spelling or try different keywords
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-6 h-6 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-400 text-xs">2</span>
                            Try searching with fewer or more general terms
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-6 h-6 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-400 text-xs">3</span>
                            Be the first to contribute this topic to ChaynWiki!
                        </li>
                    </ul>
                </div>
            </div>
        @endif
    </div>
</div>
