@extends('layouts.wiki')

@section('title', $article->title)

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

    $placeholder = 'https://images.unsplash.com/photo-1514525253344-f856717429fb?auto=format&fit=crop&q=80&w=1200';
    $featured_image = $article->featured_image;
    if ($featured_image && !Str::startsWith($featured_image, ['http://', 'https://'])) {
        $featured_image = Storage::url($featured_image);
    }
    $featured_image = $featured_image ?: $placeholder;
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
                <a href="{{ route('wiki.index', ['category' => $key]) }}" class="group flex items-center gap-4 px-4 py-4 rounded-2xl text-[14px] font-bold transition-all {{ $key === 'artist' ? 'bg-blue-500/10 text-white border border-blue-500/20 shadow-lg' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
                    <div class="w-9 h-9 rounded-full {{ $key === 'artist' ? 'bg-blue-500 shadow-lg shadow-blue-500/20' : 'bg-white/5' }} flex items-center justify-center transition-all group-hover:scale-110">
                        <svg class="w-4 h-4 {{ $key === 'artist' ? 'text-white' : 'text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $cat['icon'] !!}</svg>
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
                    <a href="{{ route('wiki.index', ['category' => 'artist']) }}" class="hover:text-blue-400 transition-colors">Artists</a>
                    <span>/</span>
                    <span class="text-white">{{ Str::limit($article->title, 30) }}</span>
                </nav>

                <div class="flex items-center gap-4">
                    <a href="{{ route('wiki.edit', $article) }}" class="text-xs font-bold text-white/50 hover:text-white tracking-wider transition-colors">Edit</a>
                </div>
            </div>

            <!-- Hero Area -->
            <div class="relative w-full rounded-[2.5rem] overflow-hidden mb-16 border border-white/5 group bg-[#0d1117] shadow-3xl">
                 {{-- Immersive Background --}}
                 <div class="absolute inset-0 z-0">
                     <img src="{{ $featured_image }}" class="w-full h-full object-cover grayscale opacity-10 blur-3xl scale-125 transition-all duration-1000 group-hover:scale-110 group-hover:opacity-20">
                     <div class="absolute inset-0 bg-gradient-to-t from-[#0d1117] via-[#0d1117]/80 to-transparent"></div>
                     <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-blue-500/5 rounded-full blur-[160px] -mr-40 -mt-40"></div>
                 </div>
                 
                 <div class="relative z-10 p-6 md:p-12 lg:p-16 flex flex-col lg:flex-row gap-8 lg:gap-12 items-end">
                     <!-- Artist Portrait -->
                     <div class="shrink-0 relative">
                         <div class="w-48 h-48 md:w-72 md:h-72 rounded-full overflow-hidden border-4 md:border-8 border-white/5 shadow-[0_0_100px_rgba(0,0,0,0.8)] relative z-10 bg-[#161b22] group-hover:border-blue-500/20 transition-all duration-700">
                             <img src="{{ $featured_image }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000 grayscale-[0.2] group-hover:grayscale-0">
                         </div>
                         {{-- Premium Glow --}}
                         <div class="absolute -inset-8 bg-blue-500/20 blur-[60px] rounded-full opacity-30 group-hover:opacity-60 transition-all duration-1000"></div>
                     </div>
                     
                     <div class="flex-1 min-w-0 pb-4 text-center lg:text-left">
                        <div class="flex items-center justify-center lg:justify-start gap-3 mb-6 md:mb-8">
                             @if(!empty($artistMeta['spotify_id']) || !empty($artistMeta['website']))
                                <span class="px-3 py-1.5 bg-blue-500/10 border border-blue-500/20 text-blue-400 rounded-lg text-[10px] font-black tracking-[0.2em] flex items-center gap-2 shadow-lg">
                                    <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span> Verified Artist
                                </span>
                            @else
                                <span class="px-3 py-1.5 bg-white/5 border border-white/10 text-white/50 rounded-lg text-[10px] font-bold tracking-widest shadow-lg">Artist profile</span>
                            @endif
                        </div>
                        
                        <h1 class="text-[42px] md:text-[64px] lg:text-[90px] font-black text-white tracking-tighter mb-8 leading-[0.9] -ml-1">
                            {{ $article->title }}
                        </h1>
                        
                        <!-- Stats Mini Grid -->
                        <div class="flex flex-wrap gap-10">
                             <div class="flex flex-col">
                                <span class="text-white text-3xl font-black tracking-tighter mb-1">{{ number_format($artistStats['views'] ?? 0) }}</span>
                                <span class="text-[11px] text-white/30 font-bold tracking-widest">Global views</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-white text-3xl font-black tracking-tighter mb-1">{{ number_format($artistStats['streams'] ?? 0) }}</span>
                                <span class="text-[11px] text-white/30 font-bold tracking-widest">Streams</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-blue-500 text-3xl font-black tracking-tighter mb-1">{{ number_format($artistStats['impact'] ?? 0, 1) }}</span>
                                <span class="text-[11px] text-white/30 font-bold tracking-widest">Impact radius</span>
                            </div>
                             <div class="flex flex-col">
                                <span class="text-white text-3xl font-black tracking-tighter mb-1">#{{ number_format($artistStats['rank'] ?? 0) }}</span>
                                <span class="text-[11px] text-white/30 font-bold tracking-widest">World rank</span>
                            </div>
                        </div>
                     </div>
                 </div>
            </div>

            <div class="flex flex-col xl:flex-row gap-12">
                <!-- Article Content -->
                <div class="flex-1 min-w-0 space-y-16">
                     <section>
                         <div class="flex items-center border-b border-white/5 pb-6 mb-10">
                            <div class="w-1.5 h-10 bg-blue-500 rounded-full mr-6 shadow-[0_0_15px_rgba(59,130,246,0.5)]"></div>
                            <h2 class="text-3xl font-black text-white tracking-tighter">Biography</h2>
                        </div>
                        <article class="prose prose-invert prose-lg max-w-none">
                            <div class="article-content text-white/70 text-base leading-relaxed">
                                @if(!empty($article->content))
                                    {!! Str::markdown($article->content) !!}
                                @else
                                    <p class="text-white/30 italic">No biography available.</p>
                                @endif
                            </div>
                        </article>
                     </section>

                     <section>
                        <div class="flex items-center justify-between border-b border-white/5 pb-6 mb-10">
                             <div class="flex items-center">
                                <div class="w-1.5 h-10 bg-blue-500 rounded-full mr-6 shadow-[0_0_15px_rgba(59,130,246,0.5)]"></div>
                                <h2 class="text-3xl font-black text-white tracking-tighter">Discography</h2>
                             </div>
                             <a href="{{ route('wiki.index', ['category' => 'song', 'q' => $article->title]) }}" class="group flex items-center gap-2 text-[11px] font-bold text-white/30 tracking-widest hover:text-blue-400 transition-all">
                                <span>Browse all tracks</span>
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                             </a>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach($artistDiscography as $item)
                                 <a href="{{ $item['url'] }}" class="card-premium-unified group block !p-4 border border-white/5 hover:border-blue-500/30 transition-all">
                                    <div class="aspect-square rounded-2xl overflow-hidden bg-black/40 mb-5 relative group-hover:shadow-[0_0_50px_rgba(59,130,246,0.1)] transition-all">
                                        <img src="{{ $item['image'] }}" onerror="this.onerror=null;this.src='{{ $placeholder }}';" class="w-full h-full object-cover transition duration-1000 group-hover:scale-110">
                                        <div class="absolute inset-0 bg-blue-500/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                             <div class="w-12 h-12 rounded-full bg-white text-navy-900 flex items-center justify-center scale-90 opacity-0 group-hover:scale-100 group-hover:opacity-100 transition-all duration-500 shadow-2xl">
                                                 <svg class="w-5 h-5 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                             </div>
                                        </div>
                                    </div>
                                    <h4 class="text-white font-black text-sm truncate tracking-tight group-hover:text-blue-400 transition-colors leading-tight mb-2">{{ $item['title'] }}</h4>
                                    <p class="text-[10px] font-black text-white/20 tracking-[0.2em]">@if(isset($item['year'])){{ $item['year'] }}@else Unknown @endif</p>
                                 </a>
                            @endforeach
                        </div>
                     </section>

                     <section>
                        <div class="flex items-center border-b border-white/5 pb-6 mb-10">
                            <div class="w-1.5 h-10 bg-blue-500 rounded-full mr-6 shadow-[0_0_15px_rgba(59,130,246,0.5)]"></div>
                            <h2 class="text-3xl font-black text-white tracking-tighter">Gallery</h2>
                        </div>
                        <div class="grid grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($artistGallery as $item)
                                <div class="relative aspect-[3/4] rounded-2xl overflow-hidden border border-white/5 group hover:border-blue-500/30 transition-all shadow-2xl">
                                    <img src="{{ $item['image'] }}" onerror="this.onerror=null;this.src='{{ $placeholder }}';" class="w-full h-full object-cover group-hover:scale-110 transition duration-1000 grayscale-[0.3] group-hover:grayscale-0">
                                    <div class="absolute inset-0 bg-gradient-to-t from-[#0d1117] via-transparent to-transparent opacity-80 group-hover:opacity-40 transition-opacity"></div>
                                    <div class="absolute bottom-6 left-6 right-6">
                                        <p class="text-[10px] font-black text-white tracking-[0.3em] truncate">{{ $item['title'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                     </section>

                     <section class="border-t border-white/5 pt-16">
                        <div class="flex items-center border-b border-white/5 pb-6 mb-10">
                            <div class="w-1.5 h-10 bg-purple-500 rounded-full mr-6 shadow-[0_0_15px_rgba(168,85,247,0.5)]"></div>
                            <h2 class="text-3xl font-black text-white tracking-tighter">Neural Discovery</h2>
                        </div>
                        <x-neural-map-visualization :articleId="$article->id" />
                    </section>

                     <section class="border-t border-white/5 pt-16">
                        <div class="flex items-center border-b border-white/5 pb-6 mb-10">
                            <div class="w-1.5 h-10 bg-blue-500 rounded-full mr-6 shadow-[0_0_15px_rgba(59,130,246,0.5)]"></div>
                            <h2 class="text-3xl font-black text-white tracking-tighter">Discussion</h2>
                        </div>
                        <livewire:article.comments :article="$article" />
                    </section>
                </div>

                <!-- Right Sidebar (Relevant Data) -->
                <aside class="w-full xl:w-80 space-y-6 shrink-0">
                    
                    <!-- Actions -->
                    <div class="card-premium-unified !bg-[#161b22]/40 !p-8 flex flex-col gap-6 shadow-3xl">
                        <livewire:article.play-button 
                            :articleId="$article->id" 
                            label="Play profile"
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

                    <!-- Metadata List -->
                    @if(!empty(array_filter($artistMeta ?? [])))
                    <div class="card-premium-unified !bg-[#161b22]/60 !p-8 shadow-3xl">
                        <h3 class="text-[11px] font-bold text-white/40 tracking-widest mb-8">Artist info</h3>
                        <div class="space-y-6">
                            @if(!empty($artistMeta['origin']))
                            <div class="flex items-center justify-between py-3 border-b border-white/5">
                                <span class="text-[13px] text-white/40 font-bold">Origin</span>
                                <span class="text-[13px] text-white font-black tracking-tight">{{ $artistMeta['origin'] }}</span>
                            </div>
                            @endif
                            @if(!empty($artistMeta['active_from']))
                            <div class="flex items-center justify-between py-3 border-b border-white/5">
                                <span class="text-[13px] text-white/40 font-bold">Active from</span>
                                <span class="text-[13px] text-white font-black tracking-tight">{{ $artistMeta['active_from'] }}</span>
                            </div>
                            @endif
                            @if(!empty($artistMeta['website']))
                            <div class="flex items-center justify-between py-3">
                                <span class="text-[13px] text-white/40 font-bold">Website</span>
                                <a href="{{ $artistMeta['website'] }}" target="_blank" class="flex items-center gap-2 text-[11px] font-bold text-blue-400 tracking-widest hover:text-white transition-colors">Link ↗</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Related topics -->
                     @if(!$relatedSongs->isEmpty())
                     <div class="card-premium-unified !bg-[#161b22]/60 !p-8 shadow-3xl">
                        <h3 class="text-[11px] font-bold text-white/40 tracking-widest mb-8">Related artists</h3>
                        <div class="space-y-6">
                            @foreach($relatedSongs as $song)
                                @if($song->article)
                                <a href="{{ route('wiki.show', $song->article->slug) }}" class="flex items-center gap-5 group">
                                    <div class="w-12 h-12 rounded-xl bg-blue-500/10 border border-white/5 overflow-hidden shrink-0 flex items-center justify-center text-blue-400 group-hover:bg-blue-500 group-hover:text-white transition-all shadow-lg">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-[13px] font-bold text-white tracking-tight truncate group-hover:text-blue-400 transition-colors">{{ $song->title }}</p>
                                        <p class="text-[9px] text-white/30 font-bold tracking-widest">Topic</p>
                                    </div>
                                </a>
                                @endif
                            @endforeach
                        </div>
                     </div>
                     @endif

                </aside>
            </div>

        </main>
    </div>
</div>
@endsection
