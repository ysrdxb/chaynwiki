@extends('layouts.wiki')

@section('title', 'Browse Archive - ChaynWiki')

@section('content')
@php
    $categories = [
        'artist' => ['label' => 'Artists', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>'],
        'song' => ['label' => 'Songs', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>'],
        'genre' => ['label' => 'Genres', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>'],
        'playlist' => ['label' => 'Playlists', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>'],
        'term' => ['label' => 'Terminology', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>'],
    ];
    $currentCategory = request('category');
@endphp

<!-- Wrapper -->
<div class="relative min-h-screen bg-[#0d1117]">
    
    <div class="max-w-[1400px] mx-auto px-8 w-full">
        <!-- Flex Container -->
        <div class="flex items-start gap-12 pt-32 pb-16">
            
            <!-- Sidebar Navigation (Desktop) -->
            <aside class="hidden lg:block w-64 sticky top-32 shrink-0">
                <nav class="space-y-2">
                    <!-- Home Link -->
                    <a href="{{ route('home') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-bold text-white/50 hover:text-white hover:bg-white/5 transition-all">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span>Home</span>
                    </a>

                    <div class="h-px bg-white/5 mx-4 my-2"></div>

                    <!-- All Records -->
                    <a href="{{ route('wiki.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-bold transition-all {{ !$currentCategory ? 'bg-white/5 text-white' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        <span>All Records</span>
                    </a>
                    
                    <!-- Categories -->
                    @foreach($categories as $key => $cat)
                        <a href="{{ route('wiki.index', ['category' => $key]) }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-bold transition-all {{ $currentCategory == $key ? 'bg-white/5 text-white' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $cat['icon'] !!}</svg>
                            <span>{{ $cat['label'] }}</span>
                        </a>
                    @endforeach
                </nav>
            </aside>

            <!-- Main Content Area -->
            <main class="flex-1 min-w-0">
                <!-- Mobile Horizontal Nav -->
                <div class="lg:hidden mb-10 overflow-x-auto pb-4 scrollbar-hide">
                    <div class="flex items-center gap-3 w-max px-1">
                         <a href="{{ route('wiki.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-widest transition-all {{ !$currentCategory ? 'bg-blue-400 text-white' : 'bg-white/5 text-white/60' }}">
                            All
                        </a>
                        @foreach($categories as $key => $cat)
                            <a href="{{ route('wiki.index', ['category' => $key]) }}" class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-widest transition-all {{ $currentCategory == $key ? 'bg-blue-400 text-white' : 'bg-white/5 text-white/60' }}">
                                {{ $cat['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Page Header -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
                    <div>
                        <h1 class="text-4xl md:text-5xl font-bold text-white tracking-tight">
                            {{ $currentCategory ? ucfirst($currentCategory) : 'Browse Archive' }}
                        </h1>
                        <p class="text-white/40 text-sm font-medium mt-2">
                            {{ isset($results) ? $results['total_count'] : (isset($articles) ? $articles->total() : '0') }} records found
                        </p>
                    </div>

                    <div class="flex items-center gap-4">
                        <!-- Search Bar -->
                        <form action="{{ route('wiki.index') }}" method="GET" class="relative group">
                            @if($currentCategory)
                                <input type="hidden" name="category" value="{{ $currentCategory }}">
                            @endif
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search..." 
                                class="w-full md:w-64 px-4 py-2.5 bg-[#161b22] border border-white/10 rounded-full text-white text-sm placeholder-white/30 focus:border-blue-400/50 focus:outline-none focus:ring-1 focus:ring-blue-400/50 transition-all">
                            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-white/30 group-focus-within:text-blue-400 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </button>
                        </form>

                        <!-- Add Topic Button -->
                        <a href="{{ route('wiki.create') }}" class="bg-white text-black px-5 py-2.5 rounded-full text-sm font-bold hover:bg-gray-100 transition-colors flex items-center gap-2 shadow-lg shadow-white/5 shrink-0">
                            Add Topic
                            <div class="w-5 h-5 rounded-full bg-blue-500 text-white flex items-center justify-center">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Content Grid -->
                @if(isset($results))
                    <!-- Search Results Mode -->
                    <div class="space-y-16">
                        @foreach(['song' => 'Songs', 'artist' => 'Artists', 'genre' => 'Genres', 'playlist' => 'Playlists', 'term' => 'Terminology'] as $key => $label)
                            @if($results[$key.'s']->count() > 0)
                                <section>
                                    <div class="flex items-center gap-4 mb-6">
                                        <h2 class="text-xl font-bold text-white">{{ $label }}</h2>
                                        <div class="flex-1 h-px bg-white/5"></div>
                                        <span class="text-xs font-bold text-white/30 bg-white/5 px-2 py-1 rounded">{{ $results[$key.'s']->count() }}</span>
                                    </div>

                                    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                                        @foreach($results[$key.'s'] as $topic)
                                            @include('wiki._article-card', ['article' => $topic])
                                        @endforeach
                                    </div>
                                </section>
                            @endif
                        @endforeach
                    </div>
                @else
                    <!-- Grid Mode -->
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @forelse($articles as $article)
                            @include('wiki._article-card', ['article' => $article])
                        @empty
                            <div class="col-span-full py-24 text-center rounded-[20px] bg-[#161b22]/40 border border-white/5">
                                <div class="w-20 h-20 rounded-full bg-blue-400/10 flex items-center justify-center mx-auto mb-6">
                                    <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                </div>
                                <h3 class="text-2xl font-bold text-white mb-3">No Records Found</h3>
                                <p class="text-white/40 text-sm max-w-md mx-auto mb-8">The archive doesn't have any entries matching your criteria yet.</p>
                                <a href="{{ route('wiki.create') }}" class="inline-flex items-center gap-2 text-blue-400 font-bold hover:text-blue-300">
                                    Create First Record →
                                </a>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if(isset($articles) && $articles->hasPages())
                        <div class="mt-16 flex justify-center">
                            <div class="flex items-center gap-2">
                                @if($articles->onFirstPage())
                                    <span class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-white/20 cursor-not-allowed">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                    </span>
                                @else
                                    <a href="{{ $articles->previousPageUrl() }}" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-white/60 hover:bg-blue-400 hover:text-white transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                    </a>
                                @endif

                                <span class="px-4 py-2 text-sm font-bold text-white/60">
                                    Page {{ $articles->currentPage() }} of {{ $articles->lastPage() }}
                                </span>

                                @if($articles->hasMorePages())
                                    <a href="{{ $articles->nextPageUrl() }}" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-white/60 hover:bg-blue-400 hover:text-white transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                @else
                                    <span class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-white/20 cursor-not-allowed">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                @endif
            </main>
        </div>
    </div>
</div>
@endsection
