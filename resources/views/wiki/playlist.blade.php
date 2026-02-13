@extends('layouts.wiki')

@section('title', $article->title . ' - Curated Playlist - ChaynWiki')

@php
    $seoDescription = $summary ?? Str::limit(strip_tags((string) $article->content), 160);
    $seoImage = $article->featured_image;
    if ($seoImage && !Str::startsWith($seoImage, ['http://', 'https://'])) {
        $seoImage = Storage::url($seoImage);
    }
    $seoImage = $seoImage ?: asset('images/hero_background.png');
@endphp

@section('meta_description', $seoDescription)
@section('meta_image', $seoImage)
@section('canonical', route('wiki.show', $article->slug))
@section('og_type', 'article')

@section('content')
@php
    $categories = [
        'artist' => ['label' => 'Artists', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>'],
        'song' => ['label' => 'Songs', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>'],
        'genre' => ['label' => 'Genres', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>'],
        'playlist' => ['label' => 'Playlists', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>'],
        'term' => ['label' => 'Terminology', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>'],
    ];

    $placeholder = 'https://images.unsplash.com/photo-1493225255756-d9584f8606e9?auto=format&fit=crop&q=80&w=1200';
    $featured_image = $article->featured_image;
    if ($featured_image && !Str::startsWith($featured_image, ['http://', 'https://'])) {
        $featured_image = Storage::url($featured_image);
    }
    $featured_image = $featured_image ?: $placeholder;

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
    <div class="max-w-[1400px] w-full px-8 flex items-start gap-12 pt-32 pb-16">
        
        <!-- Sidebar Navigation -->
        <aside class="hidden lg:block w-72 sticky top-32 shrink-0 space-y-2 pr-8 border-r border-white/5">
            <div class="mb-10 px-4">
                <span class="text-white/20 text-[11px] font-bold text-blue-400 tracking-widest uppercase">Navigation</span>
            </div>
            
            <a href="{{ route('home') }}" class="group flex items-center gap-4 px-4 py-4 rounded-2xl text-[14px] font-bold text-white/50 hover:text-white hover:bg-white/5 transition-all">
                <div class="w-9 h-9 rounded-full bg-blue-500/10 border border-white/10 flex items-center justify-center group-hover:bg-blue-500 group-hover:scale-110 transition-all shadow-lg shadow-blue-500/10">
                    <svg class="w-4 h-4 text-blue-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </div>
                Home
            </a>

            <div class="h-px bg-white/5 mx-4 my-6"></div>
            
            @foreach($categories as $key => $cat)
                <a href="{{ route('wiki.index', ['category' => $key]) }}" class="group flex items-center gap-4 px-4 py-4 rounded-2xl text-[14px] font-bold transition-all {{ $key === 'playlist' ? 'bg-blue-500/10 text-white border border-blue-500/20 shadow-lg' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
                    <div class="w-9 h-9 rounded-full {{ $key === 'playlist' ? 'bg-blue-500 shadow-lg shadow-blue-500/20' : 'bg-white/5' }} flex items-center justify-center transition-all group-hover:scale-110">
                        <svg class="w-4 h-4 {{ $key === 'playlist' ? 'text-white' : 'text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $cat['icon'] !!}</svg>
                    </div>
                    {{ $cat['label'] }}
                </a>
            @endforeach
        </aside>

        <!-- Main Content -->
        <main class="flex-1 min-w-0">
             <!-- Top Action Row -->
             <div class="flex justify-between items-center mb-8">
                 <!-- Breadcrumbs -->
                 <nav class="flex items-center gap-2 text-[10px] font-bold text-white/30 tracking-[0.2em]">
                    <a href="{{ route('wiki.index', ['category' => 'playlist']) }}" class="hover:text-blue-400 transition-colors">Playlists</a>
                    <span>/</span>
                    <span class="text-white">{{ Str::limit($article->title, 30) }}</span>
                </nav>

                <div class="flex items-center gap-4">
                    <a href="{{ route('wiki.edit', $article) }}" class="text-xs font-bold text-white/50 hover:text-white tracking-wider transition-colors">Edit</a>
                </div>
            </div>

            <!-- Hero Area -->
            <div class="relative w-full rounded-[2rem] overflow-hidden mb-10 border border-white/5 group bg-[#161b22]">
                 <div class="absolute inset-0 z-0">
                     <img src="{{ $featured_image }}" onerror="this.onerror=null;this.src='{{ $placeholder }}';" class="w-full h-full object-cover grayscale opacity-20 blur-xl scale-125">
                     <div class="absolute inset-0 bg-gradient-to-t from-[#0d1117] to-transparent"></div>
                 </div>
                 
                 <div class="relative z-10 p-8 md:p-10 flex flex-col md:flex-row gap-8 items-center md:items-end">
                     <!-- Playlist Cover -->
                     <div class="shrink-0 relative group/cover cursor-pointer">
                         <div class="w-48 h-48 md:w-64 md:h-64 rounded-xl overflow-hidden border-2 border-white/10 shadow-2xl relative z-10 bg-[#0d1117]">
                             <img src="{{ $featured_image }}" onerror="this.onerror=null;this.src='{{ $placeholder }}';" class="w-full h-full object-cover group-hover:scale-110 transition duration-1000">
                         </div>
                         <div class="absolute -inset-4 bg-blue-400/20 blur-2xl rounded-xl opacity-30 group-hover/cover:opacity-80 transition-all duration-700"></div>
                     </div>
                     
                     <div class="flex-1 min-w-0 pb-2 text-center md:text-left">
                        <span class="px-3 py-1.5 bg-blue-500/10 border border-blue-500/20 text-blue-400 rounded-lg text-[10px] font-bold tracking-widest inline-block mb-4 shadow-lg">
                            Playlist
                        </span>
                        
                        <h1 class="text-3xl sm:text-4xl lg:text-7xl font-black text-white tracking-tighter mb-4 leading-none" style="font-family: 'Moderniz', sans-serif;">
                            {{ $article->title }}
                        </h1>
                        
                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-8">
                             <div class="flex flex-col">
                                <span class="text-[11px] font-bold text-white/30 tracking-widest mb-1">Songs</span>
                                <span class="text-2xl font-black text-white px-1 tracking-tighter">{{ $playlist->track_count ?? '0' }}</span>
                            </div>
                            <div class="w-px h-8 bg-white/10 hidden md:block"></div>
                            <div class="flex flex-col">
                                <span class="text-[11px] font-bold text-white/30 tracking-widest mb-1">Views</span>
                                <span class="text-2xl font-black text-blue-500 px-1 tracking-tighter">{{ number_format($article->view_count ?? 0) }}</span>
                            </div>
                             <div class="w-px h-8 bg-white/10 hidden md:block"></div>
                            <div class="flex flex-col">
                                <span class="text-[11px] font-bold text-white/30 tracking-widest mb-1">Updated</span>
                                <span class="text-2xl font-black text-white px-1 tracking-tighter">{{ optional($article->updated_at)->format('M d, Y') ?? 'Unknown' }}</span>
                            </div>
                        </div>
                     </div>
                 </div>
            </div>

            <div class="space-y-24">
                {{-- About section --}}
                <section>
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
                        <div class="rounded-3xl overflow-hidden border border-white/10 shadow-2xl bg-black/50">
                            <iframe src="https://open.spotify.com/embed/playlist/{{ $spotify_id }}" width="100%" height="520" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
                        </div>
                    @else
                        <div class="rounded-3xl border border-white/5 bg-[#161b22]/40 p-12 text-center">
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
                        {{-- Curator & Data --}}
                        <div class="card-premium-unified !bg-[#161b22]/40 !p-10 space-y-8">
                             <div class="flex items-center gap-6">
                                <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-blue-400">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-[11px] font-bold text-white/40 tracking-widest uppercase">Curator Note</h3>
                                    <p class="text-sm text-white/70 italic leading-relaxed mt-1">
                                        "{{ $playlist?->curator_note ?: 'This collection represents a specific moment in music history.' }}"
                                    </p>
                                </div>
                             </div>

                             <div class="space-y-6 pt-6 border-t border-white/5">
                                <livewire:article.play-button :articleId="$article->id" label="Play playlist" class="btn-figma-primary !w-full !py-4" />
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
                    <div class="flex items-center border-b border-white/5 pb-6 mb-10">
                        <div class="w-1.5 h-10 bg-blue-500 rounded-full mr-6 shadow-[0_0_15px_rgba(59,130,246,0.5)]"></div>
                        <h2 class="text-3xl font-black text-white tracking-tighter uppercase">Discussion</h2>
                    </div>
                    <div class="card-premium-unified !bg-[#161b22]/20 !p-12">
                        <livewire:article.comments :article="$article" />
                    </div>
                </section>
            </div>

        </main>
    </div>
</div>
@endsection
