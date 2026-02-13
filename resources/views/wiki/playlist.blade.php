@extends('layouts.wiki')

@section('title', $article->title . ' - Curated Playlist - ChaynWiki')

@section('content')
@php
    $categories = [
        'artist' => ['label' => 'Artists', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>'],
        'song' => ['label' => 'Songs', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>'],
        'genre' => ['label' => 'Genres', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>'],
        'playlist' => ['label' => 'Playlists', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>'],
        'term' => ['label' => 'Terminology', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>'],
        'label' => ['label' => 'Labels', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>'],
    ];

    $featured_image = $article->featured_image;
    if ($featured_image && !Str::startsWith($featured_image, ['http://', 'https://'])) {
        $featured_image = Storage::url($featured_image);
    }
    $featured_image = $featured_image ?: 'https://images.unsplash.com/photo-1493225255756-d9584f8606e9?auto=format&fit=crop&q=80&w=1200';

    $playlist = $article->playlist;
    $spotify_id = null;
    if ($playlist?->spotify_id) {
        $spotify_id = $playlist->spotify_id;
    } elseif (!empty($playlist?->platform_link) && Str::contains($playlist->platform_link, 'spotify.com')) {
        $parts = explode('playlist/', $playlist->platform_link);
        if (count($parts) > 1) {
            $spotify_id = explode('?', $parts[1])[0];
        }
    }
@endphp

<div class="min-h-screen bg-[#0d1117] flex justify-center">
    <div class="max-w-[1400px] w-full px-8 flex items-start gap-12 pt-16 pb-16">
        
        <!-- Sidebar Navigation -->
@include('wiki._sidebar')

        <!-- Main Content -->
        <main class="flex-1 min-w-0">
             <!-- Top Action Row -->
             <div class="flex justify-between items-center mb-16">
                 <!-- Breadcrumbs -->
                 <nav class="flex items-center gap-2 text-[10px] font-bold text-white/30 tracking-[0.2em]">
                    <a href="{{ route('wiki.index', ['category' => 'playlist']) }}" class="hover:text-blue-400 transition-colors uppercase">All Playlists</a>
                    <span>/</span>
                    <span class="text-white uppercase">{{ Str::limit($article->title, 30) }}</span>
                </nav>

                <div class="flex items-center gap-4">
                    <a href="{{ route('wiki.edit', $article) }}" class="text-xs font-bold text-white/50 hover:text-white tracking-wider transition-colors uppercase">Edit Page</a>
                </div>
            </div>

            <!-- Hero Section (Vertical Layout) -->
            <div class="relative w-full mb-24">
                 <!-- Text Content -->
                 <div class="relative z-10 w-full mb-12">
                     <!-- Title -->
                     <h1 class="text-soundbook-heading text-6xl sm:text-7xl md:text-8xl lg:text-[120px] text-white leading-[0.85] tracking-tighter mb-6 break-words">
                         {{ strtoupper($article->title) }}
                     </h1>
                     
                     <!-- Meta Data Row -->
                     <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-[13px] font-bold text-white/50 tracking-wide mb-8">
                         <span>Items: <span class="text-white">{{ $playlist->track_count ?? '0' }} Songs</span></span>
                         <span class="w-1 h-1 rounded-full bg-white/20"></span>
                         <span>Views: <span class="text-white">{{ number_format($article->view_count ?? 0) }}</span></span>
                         <span class="w-1 h-1 rounded-full bg-white/20"></span>
                         <span>Type: <span class="text-white">Curated Collection</span></span>
                     </div>
                     
                     <!-- Bio Excerpt -->
                     <div class="max-w-4xl text-lg text-white/70 leading-relaxed mb-10 font-medium font-sans">
                          {{ Str::limit(strip_tags((string) $article->content), 350, '...') }}
                          <a href="#about" class="text-white underline decoration-white/30 hover:decoration-white transition-all cursor-pointer ml-2">Read Description</a>
                     </div>

                     <!-- Author & Actions Row -->
                     <div class="flex flex-wrap items-center gap-6 border-b border-white/5 pb-10 mb-8">
                          <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-full px-2 py-2 pr-6 backdrop-blur-md">
                             @if($article->user)
                                 <img src="{{ $article->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($article->user->name).'&background=random' }}" class="w-8 h-8 rounded-full border border-blue-500/50">
                                 <span class="text-[11px] font-black text-white uppercase tracking-widest pl-2">Added by {{ $article->user->name }}</span>
                             @else
                                 <img src="https://ui-avatars.com/api/?name=System" class="w-8 h-8 rounded-full border border-white/10">
                                 <span class="text-[11px] font-black text-white/50 uppercase tracking-widest pl-2">System</span>
                             @endif
                             <div class="w-4 h-4 rounded-full bg-blue-500 flex items-center justify-center text-[10px] text-white">
                                 <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                             </div>
                         </div>
                         
                          <div class="flex items-center gap-2 text-[11px] font-bold text-white/40 uppercase tracking-widest bg-white/5 border border-white/10 rounded-full px-4 py-2.5">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                             <span>Updated {{ $article->updated_at->format('M d, Y') }}</span>
                         </div>
                        
                         <livewire:article.play-button :articleId="$article->id" label="Play Playlist" class="btn-figma-primary !px-8 !py-2.5" />
                     </div>
                 </div>

                 <!-- Hero Image Banner -->
                 <div class="relative w-full aspect-[21/9] rounded-[2rem] overflow-hidden border border-white/10 shadow-3xl group mb-24">
                      <img src="{{ $featured_image }}" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1493225255756-d9584f8606e9?auto=format&fit=crop&q=80&w=1200';" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                       <div class="absolute inset-0 bg-gradient-to-t from-[#0d1117] via-transparent to-transparent opacity-60"></div>
                 </div>
            </div>

            <div class="space-y-24">
                {{-- About section --}}
                <section id="about">
                    <div class="flex items-center border-b border-white/5 pb-6 mb-10">
                        <div class="w-1.5 h-10 bg-blue-500 rounded-full mr-6 shadow-[0_0_15px_rgba(59,130,246,0.5)]"></div>
                        <h2 class="text-3xl font-black text-white tracking-tighter uppercase">Curator Description</h2>
                    </div>
                    <article class="prose prose-invert prose-lg max-w-none">
                        <div class="article-content text-white/70 text-base leading-relaxed">
                            {!! Str::markdown($article->content ?? 'No playlist description available.') !!}
                        </div>
                    </article>
                </section>

                {{-- Player section --}}
                <section>
                    <div class="flex items-center border-b border-white/5 pb-6 mb-10">
                        <div class="w-1.5 h-10 bg-emerald-500 rounded-full mr-6 shadow-[0_0_15px_rgba(16,185,129,0.5)]"></div>
                        <h2 class="text-3xl font-black text-white tracking-tighter uppercase">Playlist Archive</h2>
                    </div>
                    @if($spotify_id)
                        <div class="rounded-[2.5rem] overflow-hidden border border-white/10 shadow-2xl bg-black/50">
                            <iframe src="https://open.spotify.com/embed/playlist/{{ $spotify_id }}" width="100%" height="520" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
                        </div>
                    @else
                        <div class="rounded-[2.5rem] border border-white/5 bg-[#161b22]/40 p-12 text-center">
                            <p class="text-white/50 text-sm mb-6">No active streaming link synchronized.</p>
                            @if(!empty($playlist?->platform_link))
                                <a href="{{ $playlist->platform_link }}" target="_blank" rel="noopener" class="px-8 py-3 bg-blue-600 text-white text-xs font-black tracking-widest rounded-xl hover:bg-blue-500 transition-all inline-block uppercase">Open in platform</a>
                            @endif
                        </div>
                    @endif
                </section>

                {{-- Info & Actions --}}
                <section class="border-t border-white/5 pt-16">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Curator Note --}}
                        <div class="card-premium-unified !bg-[#161b22]/40 !p-10 space-y-8">
                             <div class="flex items-center gap-6">
                                <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-blue-400">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-[11px] font-bold text-white/40 tracking-widest uppercase">Curator Note</h3>
                                    <p class="text-base text-white/70 italic leading-relaxed mt-2 font-serif">
                                        "{{ $playlist?->curator_note ?: 'This collection represents a specific moment in music history.' }}"
                                    </p>
                                </div>
                             </div>

                             <div class="space-y-6 pt-6 border-t border-white/5">
                                <div class="flex gap-4">
                                     <div class="flex-1"><livewire:article.add-to-collection :article="$article" /></div>
                                     <div class="flex-1"><livewire:article.bookmark-button :article="$article" /></div>
                                </div>
                             </div>
                        </div>

                        {{-- Metadata & Contributor --}}
                        <div class="card-premium-unified !bg-[#161b22]/60 !p-10 flex flex-col justify-between">
                            <div class="space-y-6">
                                <h3 class="text-[11px] font-bold text-white/40 tracking-widest uppercase">Archive Information</h3>
                                <div class="flex items-center justify-between py-2 border-b border-white/5">
                                    <span class="text-sm text-white/50">Status</span>
                                    <span class="text-xs font-black text-emerald-400 uppercase tracking-widest">Verified</span>
                                </div>
                                @if($article->user)
                                <div class="flex items-center gap-4 pt-4">
                                    <img src="{{ $article->user->avatar ?? 'https://ui-avatars.com/api/?name='.$article->user->name }}" class="w-10 h-10 rounded-full border border-blue-500/30">
                                    <div>
                                        <p class="text-sm font-bold text-white">{{ $article->user->name }}</p>
                                        <p class="text-[10px] text-white/30 uppercase tracking-widest">Primary Archivist</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="pt-6">
                                <div class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/5 group hover:border-blue-500/20 transition-all">
                                    <span class="text-[11px] font-bold text-white/30 tracking-widest uppercase">Community Rating</span>
                                    <livewire:article.vote-button :model="$article" wire:key="playlist-vote-{{ $article->id }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Discussion --}}
                <section>
                    <div class="flex items-center justify-between mb-12">
                         <div>
                             <h2 class="text-soundbook-heading text-6xl text-white uppercase tracking-tighter mb-2">DISCUSSION</h2>
                         </div>
                    </div>
                    <div class="card-premium-unified !bg-[#161b22]/40 !p-12">
                         <livewire:article.comments :article="$article" />
                    </div>
                </section>
            </div>

        </main>
    </div>
</div>
@endsection
