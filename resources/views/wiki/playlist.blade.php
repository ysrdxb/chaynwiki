@extends('layouts.wiki')

@section('title', $article->title . ' - Curated Playlist - ChaynWiki')

@section('content')
    @php
        $featured_image = $article->featured_image ?: 'https://images.unsplash.com/photo-1493225255756-d9584f8606e9?auto=format&fit=crop&q=80&w=1200';
    @endphp

    <div x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 500)">
        <!-- Actual Content -->
        <div x-show="loaded" x-transition:enter="transition duration-500">
            <!-- HERO SECTION -->
            <div class="relative pt-24 pb-20 bg-primary section-divider overflow-hidden">
                <div class="absolute inset-0 z-0">
                    <img src="{{ $featured_image }}" class="w-full h-full object-cover grayscale opacity-10 blur-2xl scale-125">
                    <div class="absolute inset-0 bg-gradient-to-t from-primary via-primary/60 to-transparent"></div>
                </div>
                
                <div class="relative z-10 max-w-[1200px] mx-auto px-8">
                    <div class="flex flex-col lg:flex-row gap-12 items-center">
                        <div class="lg:w-80 flex-shrink-0">
                            <div class="aspect-square rounded-3xl overflow-hidden border border-white/10 shadow-3xl relative group">
                                <img src="{{ $featured_image }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-1000">
                                <div class="absolute inset-0 bg-blue-500/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            </div>
                        </div>

                        <div class="flex-1 text-center lg:text-left">
                            <nav class="flex items-center justify-center lg:justify-start gap-2 text-[9px] font-black text-white/20 uppercase tracking-[0.2em] mb-8">
                                <a href="{{ route('home') }}" class="hover:text-blue-400">Home</a>
                                <span>/</span>
                                <a href="{{ route('wiki.index', ['category' => 'playlist']) }}" class="hover:text-blue-400">Playlists</a>
                                <span>/</span>
                                <span class="text-blue-500">Curated Archive</span>
                            </nav>

                            <h1 class="text-5xl lg:text-8xl font-black text-white italic uppercase tracking-tighter mb-8 leading-none">
                                {{ $article->title }}
                            </h1>

                            <div class="flex flex-wrap items-center justify-center lg:justify-start gap-8">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-white/20 uppercase tracking-widest mb-1">Track Count</span>
                                    <span class="text-2xl font-black text-white italic">{{ $article->playlist->track_count ?? '0' }} SONGS</span>
                                </div>
                                <div class="w-px h-10 bg-white/5"></div>
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-white/20 uppercase tracking-widest mb-1">Total Impact</span>
                                    <span class="text-2xl font-black text-white italic">{{ number_format($article->view_count ?? 0) }} STREAMED</span>
                                </div>
                                <div class="w-px h-10 bg-white/5"></div>
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-white/20 uppercase tracking-widest mb-1">Last Updated</span>
                                    <span class="text-2xl font-black text-white italic uppercase">{{ $article->updated_at->format('M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CONTENT AREA -->
            <div class="max-w-[1200px] mx-auto px-8 py-16">
                <div class="grid lg:grid-cols-3 gap-16">
                    <!-- Sidebar: Curator Info -->
                    <div class="space-y-12">
                        <section>
                            <h3 class="text-[10px] font-black text-blue-500 uppercase tracking-[0.3em] mb-6">Curator Note</h3>
                            <div class="p-8 bg-secondary border border-white/5 rounded-3xl relative overflow-hidden group">
                                <svg class="w-12 h-12 text-white/5 absolute -top-2 -left-2 rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017V14H17.017C15.9124 14 15.017 13.1046 15.017 12V9C15.017 7.89543 15.9124 7 17.017 7H20.017V10H18.017V12H20.017C21.1216 12 22.017 12.8954 22.017 14V21H14.017ZM3 21V18C3 16.8954 3.89543 16 5 16H8V14H6C4.89543 14 4 13.1046 4 12V9C4 7.89543 4.89543 7 6 7H9V10H7V12H9C10.1046 12 11 12.8954 11 14V21H3Z"/></svg>
                                <p class="text-white/60 leading-relaxed italic relative z-10">
                                    "{{ $article->playlist->curator_note ?: 'This collection represents a specific moment in music history, curated for the ChaynWiki archive.' }}"
                                </p>
                            </div>
                        </section>

                        <section class="space-y-4">
                            <h3 class="text-[10px] font-black text-white/10 uppercase tracking-[0.3em]">Engagement</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <livewire:article.vote-button :model="$article" wire:key="vote-article-{{ $article->id }}" />
                                <livewire:article.bookmark-button :article="$article" />
                            </div>
                        </section>
                    </div>

                    <!-- Main: Article Content & Playlist Embed -->
                    <div class="lg:col-span-2 space-y-16">
                        <article class="prose prose-invert prose-lg max-w-none">
                            <div class="article-content text-white/40 leading-relaxed">
                                {!! $article->content !!}
                            </div>
                        </article>

                        @if($article->playlist->spotify_id)
                            <section>
                                <h3 class="text-xl font-black text-white italic uppercase tracking-tighter mb-8 flex items-center gap-4">
                                    <span class="w-10 h-px bg-green-500"></span>
                                    Spotify Synchronized
                                </h3>
                                <div class="rounded-3xl overflow-hidden border border-white/5 shadow-2xl bg-black">
                                    @php
                                        $spotify_id = $article->playlist->spotify_id;
                                        if (Str::contains($spotify_id, 'playlist/')) {
                                            $parts = explode('playlist/', $spotify_id);
                                            $spotify_id = explode('?', $parts[1])[0];
                                        }
                                    @endphp
                                    <iframe src="https://open.spotify.com/embed/playlist/{{ $spotify_id }}" width="100%" height="450" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
                                </div>
                            </section>
                        @endif

                        <section class="pt-16 border-t border-white/5">
                            <livewire:article.comments :article="$article" />
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
