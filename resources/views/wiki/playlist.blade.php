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
                <span class="text-white/20 text-[11px] font-bold text-blue-400 tracking-widest">Explore all</span>
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
                        
                        <h1 class="text-4xl lg:text-7xl font-black text-white tracking-tighter mb-4 leading-none" style="font-family: 'Moderniz', sans-serif;">
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

            <div class="flex flex-col xl:flex-row gap-12">
                <!-- Article Content -->
                <div class="flex-1 min-w-0 space-y-12">
                     <article class="prose prose-invert prose-lg max-w-none">
                        <div class="article-content text-white/70 text-base leading-relaxed">
                            @if(!empty($article->content))
                                {!! Str::markdown($article->content) !!}
                            @else
                                <p class="text-white/30">No playlist description available.</p>
                            @endif
                        </div>
                    </article>

                    <section>
                        <div class="flex items-center border-b border-white/5 pb-6 mb-10">
                            <div class="w-1.5 h-10 bg-blue-500 rounded-full mr-6 shadow-[0_0_15px_rgba(59,130,246,0.5)]"></div>
                            <h2 class="text-3xl font-black text-white tracking-tighter" style="font-family: 'Moderniz', sans-serif;">Listen</h2>
                        </div>
                        @if($spotify_id)
                            <div class="rounded-3xl overflow-hidden border border-white/10 shadow-2xl bg-black/50">
                                <iframe src="https://open.spotify.com/embed/playlist/{{ $spotify_id }}" width="100%" height="450" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
                            </div>
                        @else
                            <div class="rounded-3xl border border-white/5 bg-[#161b22]/40 p-10 text-center">
                                <p class="text-white/50 text-sm">No Spotify connection detected.</p>
                                @if(!empty($playlist?->platform_link))
                                    <a href="{{ $playlist->platform_link }}" target="_blank" rel="noopener" class="mt-4 px-6 py-2 bg-white text-black text-xs font-bold tracking-widest rounded-lg hover:bg-gray-200 inline-block">Open External Link</a>
                                @endif
                            </div>
                        @endif
                    </section>
                    
                     <section class="border-t border-white/5 pt-16">
                        <div class="flex items-center border-b border-white/5 pb-6 mb-10">
                            <div class="w-1.5 h-10 bg-blue-500 rounded-full mr-6 shadow-[0_0_15px_rgba(59,130,246,0.5)]"></div>
                            <h2 class="text-3xl font-black text-white tracking-tighter" style="font-family: 'Moderniz', sans-serif;">Discussion</h2>
                        </div>
                        <livewire:article.comments :article="$article" />
                    </section>
                </div>

                <!-- Right Sidebar (Relevant Data) -->
                <aside class="w-full xl:w-80 space-y-6 shrink-0">
                    
                    <!-- Curator Note -->
                    <div class="bg-[#161b22]/60 border border-white/5 rounded-[20px] p-6 relative overflow-hidden">
                        <div class="absolute -top-4 -right-4 text-white/5 rotate-12">
                            <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017V14H17.017C15.9124 14 15.017 13.1046 15.017 12V9C15.017 7.89543 15.9124 7 17.017 7H20.017V10H18.017V12H20.017C21.1216 12 22.017 12.8954 22.017 14V21H14.017ZM3 21V18C3 16.8954 3.89543 16 5 16H8V14H6C4.89543 14 4 13.1046 4 12V9C4 7.89543 4.89543 7 6 7H9V10H7V12H9C10.1046 12 11 12.8954 11 14V21H3Z"/></svg>
                        </div>
                         <h3 class="text-xs font-bold text-[#38bdf8] tracking-widest mb-4 relative z-10">Curator Note</h3>
                         <p class="text-white/70 text-sm leading-relaxed relative z-10">
                            "{{ $playlist?->curator_note ?: 'This collection represents a specific moment in music history, curated for the ChaynWiki archive.' }}"
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="card-premium-unified !bg-[#161b22]/40 !p-8 flex flex-col gap-6 shadow-3xl">
                        <livewire:article.play-button 
                            :articleId="$article->id" 
                            label="Play playlist"
                            class="btn-figma-primary !w-full !py-4"
                        />
                        
                        <div class="group">
                             <livewire:article.add-to-collection :article="$article" />
                        </div>

                        <div class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/5 group hover:border-blue-500/20 transition-all">
                            <span class="text-[11px] font-bold text-white/30 tracking-widest">Global rating</span>
                             <livewire:article.vote-button :model="$article" wire:key="sidebar-vote-article-{{ $article->id }}" />
                        </div>
                        
                        <div class="group"><livewire:article.bookmark-button :article="$article" /></div>
                    </div>

                    <!-- Contributor -->
                    @if($article->user)
                    <div class="card-premium-unified !bg-[#161b22]/60 !p-8 shadow-3xl">
                        <h3 class="text-[11px] font-bold text-white/40 tracking-widest mb-6">Added by</h3>
                        <a href="{{ route('profile', $article->user->username) }}" class="flex items-center gap-4 group">
                            <div class="w-12 h-12 rounded-full p-0.5 bg-gradient-to-br from-white/10 to-transparent group-hover:from-blue-500/50 transition-all duration-500">
                                <div class="w-full h-full rounded-full overflow-hidden border border-white/10 bg-[#0d1117] flex items-center justify-center">
                                    @if($article->user->avatar)
                                        <img src="{{ $article->user->avatar }}" class="w-full h-full object-cover transition-transform group-hover:scale-110" onerror="this.src='{{ asset('images/hero_background.png') }}'; this.onerror=null;">
                                    @else
                                        <span class="text-sm text-white font-bold">{{ strtoupper(substr($article->user->name, 0, 1)) }}</span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <p class="text-[15px] font-bold text-white group-hover:text-blue-400 transition-colors">{{ $article->user->name }}</p>
                                <p class="text-[11px] text-white/30 font-medium tracking-widest">Contributor</p>
                            </div>
                        </a>
                    </div>
                    @endif

                </aside>
            </div>

        </main>
    </div>
</div>
@endsection
