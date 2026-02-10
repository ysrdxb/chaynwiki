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
            <aside class="hidden lg:block w-72 sticky top-32 shrink-0 space-y-2 pr-8 border-r border-white/5">
                <div class="mb-10 px-4">
                    <span class="text-white/20 text-[10px] font-black uppercase tracking-[0.4em]">Navigator</span>
                </div>
                
                <a href="{{ route('home') }}" class="group flex items-center gap-4 px-4 py-4 rounded-2xl text-[13px] font-black uppercase tracking-widest text-white/50 hover:text-white hover:bg-white/5 transition-all">
                    <div class="w-8 h-8 rounded-lg bg-blue-500/10 border border-white/5 flex items-center justify-center group-hover:bg-blue-500 group-hover:scale-110 transition-all">
                        <svg class="w-4 h-4 text-blue-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </div>
                    Home
                </a>

                <a href="{{ route('wiki.index') }}" class="group flex items-center gap-4 px-4 py-4 rounded-2xl text-[13px] font-black uppercase tracking-widest transition-all {{ !$currentCategory ? 'bg-blue-500/10 text-white border border-blue-500/20 shadow-lg' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
                    <div class="w-8 h-8 rounded-lg {{ !$currentCategory ? 'bg-blue-500' : 'bg-white/5' }} flex items-center justify-center transition-all group-hover:scale-110">
                        <svg class="w-4 h-4 {{ !$currentCategory ? 'text-white' : 'text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    </div>
                    Library
                </a>

                <div class="h-px bg-white/5 mx-4 my-6"></div>
                
                @foreach($categories as $key => $cat)
                    <a href="{{ route('wiki.index', ['category' => $key]) }}" class="group flex items-center gap-4 px-4 py-4 rounded-2xl text-[13px] font-black uppercase tracking-widest transition-all {{ $currentCategory == $key ? 'bg-blue-500/10 text-white border border-blue-500/20 shadow-lg' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
                        <div class="w-8 h-8 rounded-lg {{ $currentCategory == $key ? 'bg-blue-500' : 'bg-white/5' }} flex items-center justify-center transition-all group-hover:scale-110">
                            <svg class="w-4 h-4 {{ $currentCategory == $key ? 'text-white' : 'text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $cat['icon'] !!}</svg>
                        </div>
                        {{ $cat['label'] }}
                    </a>
                @endforeach
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
                <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-12 mb-16">
                    <div>
                         <span class="px-3 py-1.5 bg-blue-500/10 border border-blue-500/20 text-blue-400 rounded-lg text-[10px] font-black uppercase tracking-[0.3em] inline-block mb-8 shadow-lg">
                            Archive Index
                        </span>
                        
                        <h1 class="text-[56px] lg:text-[80px] font-black text-white uppercase tracking-tightest mb-4 leading-[0.9] -ml-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            {{ $currentCategory ? ($categories[$currentCategory]['label'] ?? ucfirst($currentCategory)) : 'Global Archive' }}
                        </h1>
                        
                        <p class="text-white/20 text-[11px] font-black uppercase tracking-[0.4em] mt-6 flex items-center gap-3">
                             <span class="w-8 h-px bg-white/10"></span>
                             {{ number_format(isset($results) ? $results['total_count'] : (isset($articles) ? $articles->total() : 0)) }} records indexed
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-6">
                        <!-- Premium Search Bar -->
                        <form action="{{ route('wiki.index') }}" method="GET" class="relative group min-w-[300px]">
                            @if($currentCategory)
                                <input type="hidden" name="category" value="{{ $currentCategory }}">
                            @endif
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search transmissions..." 
                                class="w-full px-8 py-4 bg-white/5 border border-white/10 rounded-2xl text-white text-[13px] font-black uppercase tracking-widest placeholder-white/20 focus:border-blue-500/50 focus:bg-white/10 focus:outline-none focus:ring-4 focus:ring-blue-500/10 transition-all shadow-2xl">
                            <button type="submit" class="absolute right-6 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-blue-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </button>
                        </form>

                        <!-- Add Topic Button -->
                        <a href="{{ route('wiki.create') }}" class="btn-figma-primary shadow-2xl shadow-blue-500/20 !px-8 !py-4 shrink-0">
                            <span>Register Node</span>
                            <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
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
                                    <div class="flex items-center justify-between gap-8 mb-10">
                                        <h2 class="text-[20px] font-black text-white uppercase tracking-widest flex items-center gap-4" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                            <div class="w-8 h-1 bg-blue-500 rounded-full"></div>
                                            {{ $label }}
                                        </h2>
                                        <div class="flex-1 h-px bg-white/5"></div>
                                        <span class="text-[10px] font-black text-white/20 bg-white/5 border border-white/5 px-3 py-1.5 rounded-lg uppercase tracking-widest">{{ $results[$key.'s']->count() }} indexed</span>
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
                            <div class="col-span-full py-32 text-center rounded-[2.5rem] bg-[#161b22]/40 border border-white/5 shadow-2xl backdrop-blur-sm">
                                <div class="w-24 h-24 rounded-full bg-blue-500/10 border border-blue-500/20 flex items-center justify-center mx-auto mb-10 shadow-3xl">
                                    <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                </div>
                                <h3 class="text-3xl font-black text-white mb-4 uppercase tracking-tightest" style="font-family: 'Plus Jakarta Sans', sans-serif;">No Signal Detected</h3>
                                <p class="text-white/20 text-[12px] font-black uppercase tracking-[0.2em] max-w-md mx-auto mb-12">The archive does not contain any entries matching your query. Transmission ended.</p>
                                <a href="{{ route('wiki.create') }}" class="btn-figma-secondary !px-10 !py-4 shadow-xl">
                                    Register First Node →
                                </a>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                        <div class="mt-20 flex justify-center">
                            <div class="flex items-center gap-6 p-2 bg-white/5 border border-white/10 rounded-2xl shadow-3xl backdrop-blur-md">
                                @if($articles->onFirstPage())
                                    <span class="w-12 h-12 rounded-xl bg-white/5 border border-white/5 flex items-center justify-center text-white/10 cursor-not-allowed">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                                    </span>
                                @else
                                    <a href="{{ $articles->previousPageUrl() }}" class="w-12 h-12 rounded-xl bg-blue-500/10 border border-white/5 flex items-center justify-center text-blue-400 hover:bg-blue-500 hover:text-white transition-all shadow-lg group">
                                        <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                                    </a>
                                @endif

                                <div class="flex flex-col items-center">
                                    <span class="text-[9px] font-black text-white/20 uppercase tracking-[0.4em] mb-1">Index Page</span>
                                    <span class="text-[14px] font-black text-white uppercase tracking-tightest">
                                        {{ $articles->currentPage() }} <span class="text-white/20 mx-1">/</span> {{ $articles->lastPage() }}
                                    </span>
                                </div>

                                @if($articles->hasMorePages())
                                    <a href="{{ $articles->nextPageUrl() }}" class="w-12 h-12 rounded-xl bg-blue-500/10 border border-white/5 flex items-center justify-center text-blue-400 hover:bg-blue-500 hover:text-white transition-all shadow-lg group">
                                        <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                @else
                                    <span class="w-12 h-12 rounded-xl bg-white/5 border border-white/5 flex items-center justify-center text-white/10 cursor-not-allowed">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                                    </span>
                                @endif
                            </div>
                        </div>
                @endif
            </main>
        </div>
    </div>
</div>
@endsection
