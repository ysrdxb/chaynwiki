@extends('layouts.wiki')

@section('title', (request('q') ? 'Search: ' . request('q') : 'Archive Browser') . ' - ChaynWiki')

@section('content')
<div class="relative bg-primary min-h-screen" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 500)">
    
    <!-- HERO SECTION -->
    <div class="relative pt-24 pb-12 bg-primary">
        <div class="max-w-[1200px] mx-auto px-8 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <nav class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8 px-1">
                        <a href="{{ route('home') }}" class="hover:text-blue-500 transition-colors">Home</a>
                        <span>/</span>
                        <span class="text-blue-500/50">Archive Browser</span>
                    </nav>

                    <h1 class="text-4xl lg:text-7xl font-black text-white italic uppercase tracking-tighter mb-4 leading-none">
                        @if(isset($search) && $search)
                            RESULTS FOR: <span class="text-blue-500">{{ $search }}</span>
                        @else
                            {{ strtoupper(request('category', 'GLOBAL')) }} <span class="text-blue-500">ARCHIVE</span>
                        @endif
                    </h1>

                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] px-1">
                        {{ isset($results) ? $results['total_count'] : (isset($articles) ? $articles->total() : '0') }} DISTRIBUTED RECORDS INDEXED
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-[1200px] mx-auto px-8 py-12">
        <!-- Filter Bar -->
        <div class="flex flex-wrap items-center gap-3 mb-16 px-1">
            <a href="{{ route('wiki.index', ['q' => $search ?? null]) }}" 
                class="px-6 py-2.5 rounded-xl text-[9px] font-black uppercase tracking-[0.2em] transition-all {{ !request('category') ? 'bg-blue-600 text-white shadow-xl shadow-blue-500/10' : 'bg-white/5 text-white/20 border border-white/5 hover:border-white/10 hover:text-white' }}">
                All Records
            </a>
            
            @php
                $categories = [
                    'artist' => 'Artists',
                    'song' => 'Songs',
                    'genre' => 'Genres',
                    'playlist' => 'Playlists',
                    'term' => 'Terminology',
                ];
            @endphp
            
            @foreach($categories as $key => $label)
                <a href="{{ route('wiki.index', ['q' => $search ?? null, 'category' => $key]) }}" 
                    class="px-6 py-2.5 rounded-xl text-[9px] font-black uppercase tracking-[0.2em] transition-all {{ request('category') == $key ? 'bg-blue-600 text-white shadow-xl shadow-blue-500/10' : 'bg-white/5 text-white/20 border border-white/5 hover:border-white/10 hover:text-white' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        @if(isset($results))
            <!-- Search Results Mode -->
            <div class="space-y-16">
                @foreach(['song' => 'Recordings', 'artist' => 'Artist Profiles', 'genre' => 'Classifications', 'playlist' => 'Curated Lists', 'term' => 'Glossary'] as $key => $label)
                    @if($results[$key.'s']->count() > 0)
                        <section>
                            <div class="flex items-center gap-4 mb-8">
                                <h2 class="text-xl font-black text-white italic uppercase tracking-tighter">{{ $label }}</h2>
                                <div class="flex-1 h-px bg-white/5"></div>
                                <a href="{{ route('wiki.index', ['q' => $search, 'category' => $key]) }}" class="text-[8px] font-black text-slate-400 uppercase tracking-widest hover:text-blue-400 transition-colors">View All</a>
                            </div>

                            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                                @foreach($results[$key.'s'] as $topic)
                                    @include('wiki._article-card', ['article' => $topic])
                                @endforeach
                            </div>
                        </section>
                    @endif
                @endforeach
            </div>
        @else
            <!-- Grid Mode (Skeleton) -->
            <div x-show="!loaded" class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
                @for($i = 0; $i < 8; $i++)
                <div class="skeleton-v2 aspect-[16/10] w-full rounded-2xl h-64"></div>
                @endfor
            </div>

            <!-- Grid Mode (Actual) -->
            <div x-show="loaded" x-transition:enter="transition duration-500" class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-16" style="display: none;">
                @forelse($articles as $article)
                    @include('wiki._article-card', ['article' => $article])
                @empty
                    <div class="col-span-full py-24 text-center rounded-2xl border border-white/5 bg-white/[0.01]">
                        <div class="text-4xl mb-6">📂</div>
                        <h3 class="text-xl font-black text-white italic uppercase tracking-tighter mb-4">No Entries Found</h3>
                        <p class="text-slate-400 text-xs max-w-sm mx-auto mb-8">The specific node you're looking for hasn't been established in our archive yet.</p>
                        <a href="{{ route('wiki.create') }}" class="btn-primary-v2 pr-10 pl-8">Create Record</a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if(isset($articles) && $articles->hasPages())
                <div class="pagination-v2 mt-16 flex justify-center">
                    {{ $articles->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
