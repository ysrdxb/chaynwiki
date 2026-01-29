@extends('layouts.wiki')

@section('title', request('q') ? 'Search: ' . request('q') : 'Browse ' . ucfirst(request('category', 'Articles')))

@section('content')
<div class="relative min-h-screen bg-[#030308]">
    <!-- Premium Background -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-[#0a0a1a] via-[#030308] to-[#030308]"></div>
        <div class="absolute top-0 right-1/4 w-[600px] h-[600px] bg-brand-600/10 rounded-full blur-[150px] animate-pulse" style="animation-duration: 4s;"></div>
        <div class="absolute bottom-1/4 left-0 w-[500px] h-[500px] bg-purple-600/10 rounded-full blur-[150px] animate-pulse" style="animation-duration: 6s;"></div>
        <div class="absolute inset-0 opacity-[0.02]" style="background-image: linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 50px 50px;"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-28">
        <!-- Header Section -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 mb-6">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-500"></span>
                </span>
                <span class="text-xs font-mono text-gray-400 uppercase tracking-widest">
                    {{ isset($results) ? 'Search Results' : 'Wiki Browser' }}
                </span>
            </div>
            
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-display font-black text-white mb-6 tracking-tight">
                @if(isset($search) && $search)
                    <span class="text-gradient">{{ $search }}</span>
                @else
                    <span class="text-white">Browse</span>
                    <span class="text-gradient">{{ ucfirst(request('category', 'All')) }}</span>
                @endif
            </h1>
            
            <p class="text-gray-500 font-mono text-sm uppercase tracking-[0.2em]">
                {{ isset($results) ? sprintf('%d', $results['total_count']) : (isset($articles) ? sprintf('%d', $articles->total()) : '0') }} Results Found
            </p>
        </div>

        <!-- Filter Pills -->
        <div class="flex flex-wrap justify-center gap-3 mb-16">
            <a href="{{ route('wiki.index', ['q' => $search ?? null]) }}" wire:navigate 
                class="group relative px-6 py-3 rounded-full font-semibold text-sm transition-all duration-300 {{ !request('category') ? 'text-white' : 'text-gray-400 hover:text-white' }}">
                @if(!request('category'))
                    <div class="absolute inset-0 bg-gradient-to-r from-brand-600 to-brand-500 rounded-full"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-brand-600 to-brand-500 rounded-full blur-lg opacity-50"></div>
                @else
                    <div class="absolute inset-0 bg-white/5 border border-white/10 rounded-full group-hover:bg-white/10 group-hover:border-white/20 transition-all"></div>
                @endif
                <span class="relative">All</span>
            </a>
            
            @php
                $categories = [
                    'artist' => ['label' => 'Artists', 'icon' => '🎤', 'color' => 'pink'],
                    'song' => ['label' => 'Songs', 'icon' => '🎵', 'color' => 'blue'],
                    'genre' => ['label' => 'Genres', 'icon' => '🎸', 'color' => 'purple'],
                    'playlist' => ['label' => 'Playlists', 'icon' => '📀', 'color' => 'green'],
                ];
            @endphp
            
            @foreach($categories as $key => $cat)
                <a href="{{ route('wiki.index', ['q' => $search ?? null, 'category' => $key]) }}" wire:navigate 
                    class="group relative px-6 py-3 rounded-full font-semibold text-sm transition-all duration-300 {{ request('category') == $key ? 'text-white' : 'text-gray-400 hover:text-white' }}">
                    @if(request('category') == $key)
                        <div class="absolute inset-0 bg-gradient-to-r from-brand-600 to-purple-600 rounded-full"></div>
                        <div class="absolute inset-0 bg-gradient-to-r from-brand-600 to-purple-600 rounded-full blur-lg opacity-50"></div>
                    @else
                        <div class="absolute inset-0 bg-white/5 border border-white/10 rounded-full group-hover:bg-white/10 group-hover:border-white/20 transition-all"></div>
                    @endif
                    <span class="relative flex items-center gap-2">
                        <span>{{ $cat['icon'] }}</span>
                        {{ $cat['label'] }}
                    </span>
                </a>
            @endforeach
        </div>

        @if(isset($results))
            <!-- Grouped Results View -->
            <div class="space-y-24">
                @foreach(['song' => 'Songs', 'artist' => 'Artists', 'genre' => 'Genres'] as $key => $label)
                    @if($results[$key.'s']->count() > 0)
                        <section>
                            <div class="flex items-center justify-between mb-8 pb-4 border-b border-white/10">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-500/20 to-purple-500/20 flex items-center justify-center text-2xl">
                                        {{ $key == 'song' ? '🎵' : ($key == 'artist' ? '🎤' : '🎸') }}
                                    </div>
                                    <h2 class="text-2xl md:text-3xl font-display font-bold text-white">{{ $label }}</h2>
                                    <span class="px-3 py-1 rounded-full bg-white/10 text-xs font-mono text-gray-400">{{ $results[$key.'s']->count() }}</span>
                                </div>
                                <a href="{{ route('wiki.index', ['q' => $search, 'category' => $key]) }}" wire:navigate class="text-sm text-brand-400 hover:text-brand-300 transition-colors flex items-center gap-2">
                                    View All
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                            </div>

                            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($results[$key.'s'] as $topic)
                                    @include('wiki._article-card', ['article' => $topic])
                                @endforeach
                            </div>
                        </section>
                    @endif
                @endforeach
            </div>
        @else
            <!-- Grid View -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
                @forelse($articles as $article)
                    @include('wiki._article-card', ['article' => $article])
                @empty
                    <div class="col-span-full">
                        <div class="relative py-24 text-center">
                            <div class="absolute inset-0 bg-gradient-to-r from-brand-500/5 via-purple-500/5 to-pink-500/5 rounded-3xl"></div>
                            <div class="absolute inset-0 border border-dashed border-white/10 rounded-3xl"></div>
                            <div class="relative">
                                <div class="text-6xl mb-6">🔍</div>
                                <h3 class="text-2xl font-display font-bold text-white mb-4">No Articles Found</h3>
                                <p class="text-gray-500 max-w-md mx-auto mb-8">The topic you're searching for hasn't been documented yet. Be the first to create it!</p>
                                <a href="{{ route('wiki.create') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-brand-600 to-brand-500 rounded-xl text-white font-bold hover:shadow-xl hover:shadow-brand-500/25 transition-all hover:-translate-y-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                    Create Article
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($articles->hasPages())
                <div class="flex justify-center">
                    {{ $articles->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

<style>
    .text-gradient {
        background: linear-gradient(135deg, #fff 0%, #60a5fa 50%, #a78bfa 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
</style>
@endsection
