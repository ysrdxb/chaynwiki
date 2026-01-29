<div class="min-h-screen bg-[#050511] pt-32">
    {{-- Search Header --}}
    <div class="bg-gradient-to-b from-brand-900/20 to-transparent py-16 border-b border-white/10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl md:text-4xl font-display font-black text-white uppercase tracking-tight text-center mb-8">
                Search ChaynWiki
            </h1>

            {{-- Search Input with Autocomplete --}}
            <div class="relative" x-data="{ open: @entangle('showSuggestions') }">
                <form wire:submit="search" class="relative">
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="query"
                        placeholder="Search artists, songs, genres..."
                        class="w-full bg-[#0A0A14] border border-white/10 rounded-2xl px-6 py-4 pl-14 text-white text-lg placeholder-gray-500 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all"
                        autocomplete="off"
                    />
                    <div class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    @if($query)
                        <button type="button" wire:click="clearSearch" class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-500 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    @endif
                </form>

                {{-- Suggestions Dropdown --}}
                <div
                    x-show="open && $wire.suggestions.length > 0"
                    x-transition
                    @click.away="open = false"
                    class="absolute z-50 w-full mt-2 bg-[#0A0A14] border border-white/10 rounded-xl shadow-2xl overflow-hidden"
                >
                    @foreach($suggestions as $suggestion)
                        <button
                            wire:click="selectSuggestion('{{ addslashes($suggestion) }}')"
                            class="w-full px-5 py-3 text-left text-gray-300 hover:bg-white/5 hover:text-white transition-colors flex items-center gap-3"
                        >
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            {{ $suggestion }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Filters --}}
            <div class="flex flex-wrap items-center justify-center gap-4 mt-6">
                {{-- Category Filter --}}
                <select
                    wire:model.live="category"
                    class="bg-white/5 border border-white/10 rounded-xl px-4 py-2 text-white text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500"
                >
                    <option value="all">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat['category'] }}">{{ ucfirst($cat['category']) }} ({{ $cat['count'] }})</option>
                    @endforeach
                </select>

                {{-- Sort Filter --}}
                <select
                    wire:model.live="sortBy"
                    class="bg-white/5 border border-white/10 rounded-xl px-4 py-2 text-white text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500"
                >
                    <option value="relevance">Most Relevant</option>
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                    <option value="views">Most Viewed</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Results Area --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if(empty($query))
            {{-- Trending Searches --}}
            @if(!empty($trending))
                <div class="text-center">
                    <h2 class="text-xs font-mono uppercase tracking-widest text-gray-500 mb-6">Trending Searches</h2>
                    <div class="flex flex-wrap justify-center gap-3">
                        @foreach($trending as $term)
                            <button
                                wire:click="selectSuggestion('{{ addslashes($term) }}')"
                                class="px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-full text-gray-300 hover:text-white transition-all"
                            >
                                {{ $term }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif
        @elseif($results && $results->count() > 0)
            {{-- Results Header --}}
            <div class="flex items-center justify-between mb-8">
                <div class="text-gray-400">
                    Found <span class="text-white font-bold">{{ $results->total() }}</span> results for "<span class="text-brand-400">{{ $query }}</span>"
                </div>
            </div>

            {{-- Results Grid --}}
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($results as $article)
                    <a href="{{ route('wiki.show', $article) }}" wire:navigate class="group bg-[#0A0A14] border border-white/10 rounded-2xl p-6 hover:border-brand-500/50 hover:bg-brand-500/5 transition-all">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="px-2 py-0.5 bg-brand-500/20 text-brand-400 rounded text-xs font-mono uppercase">
                                {{ $article->category ?? 'General' }}
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-white group-hover:text-brand-400 transition-colors mb-2">
                            {{ $article->title }}
                        </h3>
                        <p class="text-gray-400 text-sm line-clamp-2">
                            {{ \Illuminate\Support\Str::limit(strip_tags($article->content), 120) }}
                        </p>
                        <div class="flex items-center gap-4 mt-4 text-xs text-gray-500">
                            <span>{{ $article->created_at->diffForHumans() }}</span>
                            @if($article->views)
                                <span>{{ number_format($article->views) }} views</span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-12">
                {{ $results->links() }}
            </div>
        @elseif($results && $results->count() === 0)
            {{-- No Results --}}
            <div class="text-center py-16">
                <div class="w-20 h-20 rounded-full bg-white/5 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">No Results Found</h3>
                <p class="text-gray-400 mb-6">We couldn't find anything matching "{{ $query }}"</p>
                <button wire:click="clearSearch" class="px-6 py-2 bg-brand-600 hover:bg-brand-500 text-white rounded-xl transition-all">
                    Clear Search
                </button>
            </div>
        @endif
    </div>
</div>
