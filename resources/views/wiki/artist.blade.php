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
        'label' => ['label' => 'Labels', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>'],
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
            <div class="mb-8 px-4">
                <span class="text-white/20 text-[10px] font-black tracking-[0.2em] uppercase">Wiki Explorer</span>
            </div>
            
            <a href="{{ route('home') }}" class="group flex items-center gap-4 px-4 py-3 rounded-full text-[13px] font-bold text-white/50 hover:text-white transition-all border border-transparent hover:border-white/5 hover:bg-white/5">
                <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center group-hover:bg-blue-500 group-hover:text-white transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </div>
                Home
            </a>

            <div class="h-px bg-white/5 mx-4 my-6"></div>
            
            @foreach($categories as $key => $cat)
                <a href="{{ route('wiki.index', ['category' => $key]) }}" class="group flex items-center gap-4 px-4 py-3 rounded-full text-[13px] font-bold transition-all border border-transparent {{ $key === 'artist' ? 'bg-blue-500/10 text-white border-blue-500/20 shadow-[0_0_15px_rgba(59,130,246,0.2)]' : 'text-white/50 hover:text-white hover:bg-white/5 hover:border-white/5' }}">
                    <div class="w-8 h-8 rounded-full {{ $key === 'artist' ? 'bg-blue-500 shadow-lg text-white' : 'bg-white/5 group-hover:bg-white/10' }} flex items-center justify-center transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $cat['icon'] !!}</svg>
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
                 
                 <div class="relative z-10 p-6 md:p-12 lg:p-16 flex flex-col lg:flex-row gap-8 lg:gap-12 items-center">
                     <!-- Artist Portrait -->
                     <div class="shrink-0 relative">
                         <div class="w-48 h-48 md:w-72 md:h-72 rounded-full overflow-hidden border-4 md:border-8 border-white/5 shadow-[0_0_100px_rgba(0,0,0,0.8)] relative z-10 bg-[#161b22] group-hover:border-blue-500/20 transition-all duration-700">
                             <img src="{{ $featured_image }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000 grayscale-[0.2] group-hover:grayscale-0">
                         </div>
                         {{-- Premium Glow --}}
                         <div class="absolute -inset-8 bg-blue-500/20 blur-[60px] rounded-full opacity-30 group-hover:opacity-60 transition-all duration-1000"></div>
                     </div>
                     
                        <div class="flex-1 min-w-0 pb-4 text-center lg:text-left w-full">
                            <h1 class="text-soundbook-heading text-5xl sm:text-6xl md:text-7xl lg:text-8xl text-white mb-6 leading-[0.9] tracking-tighter">
                                {{ strtoupper($article->title) }}
                            </h1>
                            
                            <!-- Premium Meta Bar (SoundBook Style) -->
                            <div class="flex flex-wrap items-center justify-center lg:justify-start gap-6 mb-10 text-[12px] font-bold text-white/40 tracking-wider">
                                <div class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    <span>Born: <span class="text-white">Oct 24, 1986</span></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    <span>Active: <span class="text-white">2006 — Present</span></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                                    <span>Genres: <span class="text-white">{{ $article->genre->name ?? 'Mixed' }}</span></span>
                                </div>
                            </div>

                            <!-- Artist Statistics -->
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 xl:gap-12 mt-16 pt-12 border-t border-white/5 max-w-5xl">
                                 <div class="flex flex-col">
                                    <span class="text-white text-3xl font-black tracking-tighter mb-1">84 M</span>
                                    <span class="text-[11px] text-white/30 font-bold tracking-widest uppercase">Monthly Listeners</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-white text-3xl font-black tracking-tighter mb-1">75+ B</span>
                                    <span class="text-[11px] text-white/30 font-bold tracking-widest uppercase">Total Streams</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-blue-500 text-3xl font-black tracking-tighter mb-1">96/100</span>
                                    <span class="text-[11px] text-white/30 font-bold tracking-widest uppercase">Trending Score</span>
                                </div>
                                 <div class="flex flex-col">
                                    <span class="text-white text-3xl font-black tracking-tighter mb-1">#2</span>
                                    <span class="text-[11px] text-white/30 font-bold tracking-widest uppercase">Global Ranking</span>
                                </div>
                            </div>
                        </div>
                     </div>
                </div>

                <!-- Artist History -->
                <div class="mb-16">
                    <h2 class="text-[11px] font-black text-white/30 uppercase tracking-[0.3em] mb-8">Release History</h2>
                    <livewire:wiki.⚡timeline :entity="$artist" />
                </div>


            <div class="space-y-24">
                {{-- Content Column --}}
                <div class="space-y-24">
                     <section>
                         <div class="flex items-center border-b border-white/5 pb-8 mb-12">
                            <div class="w-1.5 h-16 bg-blue-500 rounded-full mr-8 shadow-[0_0_20px_rgba(59,130,246,0.5)]"></div>
                            <h2 class="text-5xl lg:text-7xl font-black text-white tracking-tighter uppercase leading-[0.9]">Biography</h2>
                        </div>
                        <article class="prose prose-invert prose-lg max-w-none">
                            <div class="article-content text-white/70 text-base leading-relaxed">
                                {!! Str::markdown($article->content ?? 'No biography available.') !!}
                            </div>
                        </article>
                     </section>

                     {{-- Actions & Meta --}}
                     <section class="border-t border-white/5 pt-16">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                             <div class="card-premium-unified !bg-[#161b22]/40 !p-10 space-y-8">
                                <div class="flex items-center gap-6">
                                    <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-blue-400">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-[11px] font-bold text-white/40 tracking-widest uppercase">Artist Control</h3>
                                        <p class="text-sm text-white/70 leading-relaxed mt-1">Listen to top tracks or manage this artist in your personal archive.</p>
                                    </div>
                                </div>
                                <div class="space-y-6 pt-6 border-t border-white/5">
                                    <livewire:article.play-button :articleId="$article->id" label="Play tracks" class="btn-figma-primary !w-full !py-4" />
                                    <div class="flex gap-4">
                                        <div class="flex-1"><livewire:article.add-to-collection :article="$article" /></div>
                                        <div class="flex-1"><livewire:article.bookmark-button :article="$article" /></div>
                                    </div>
                                </div>
                             </div>

                             <div class="card-premium-unified !bg-[#161b22]/60 !p-10">
                                <h3 class="text-[11px] font-bold text-white/40 tracking-widest uppercase mb-8">Metadata</h3>
                                <div class="space-y-6">
                                    @foreach(['origin' => 'Origin', 'active_from' => 'Active From'] as $key => $lbl)
                                        @if(!empty($artistMeta[$key]))
                                            <div class="flex items-center justify-between py-3 border-b border-white/5">
                                                <span class="text-sm text-white/50">{{ $lbl }}</span>
                                                <span class="text-sm text-white font-bold">{{ $artistMeta[$key] }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                    <div class="pt-4">
                                        <div class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/5">
                                            <span class="text-[11px] font-bold text-white/30 tracking-widest uppercase">Popularity</span>
                                            <livewire:article.vote-button :model="$article" wire:key="artist-vote-{{ $article->id }}" />
                                        </div>
                                    </div>
                                </div>
                             </div>
                        </div>
                     </section>

                     <section>
                        <div class="flex items-center justify-between border-b border-white/5 pb-6 mb-10">
                             <div class="flex items-center">
                                <div class="w-1.5 h-10 bg-emerald-500 rounded-full mr-6 shadow-[0_0_15px_rgba(16,185,129,0.5)]"></div>
                                <h2 class="text-3xl font-black text-white tracking-tighter uppercase">Discography</h2>
                             </div>
                             <a href="{{ route('wiki.index', ['category' => 'song', 'q' => $article->title]) }}" class="group flex items-center gap-2 text-[11px] font-bold text-white/30 tracking-widest hover:text-blue-400 transition-all uppercase">
                                <span>Complete Catalog</span>
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                             </a>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                            @foreach($artistDiscography as $item)
                                 <a href="{{ $item['url'] }}" class="card-premium-unified group block !p-4 border border-white/5 hover:border-emerald-500/30 transition-all shadow-2xl">
                                    <div class="aspect-square rounded-2xl overflow-hidden bg-black/40 mb-5 relative">
                                        <img src="{{ $item['image'] }}" onerror="this.onerror=null;this.src='{{ $placeholder }}';" class="w-full h-full object-cover transition duration-1000 group-hover:scale-110">
                                        <div class="absolute inset-0 bg-emerald-500/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                             <div class="w-12 h-12 rounded-full bg-white text-navy-900 flex items-center justify-center scale-90 opacity-0 group-hover:scale-100 group-hover:opacity-100 transition-all duration-500 shadow-2xl">
                                                 <svg class="w-5 h-5 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                             </div>
                                        </div>
                                    </div>
                                    <h4 class="text-white font-black text-sm truncate tracking-tight group-hover:text-emerald-400 transition-colors uppercase leading-tight mb-2">{{ $item['title'] }}</h4>
                                    <p class="text-[10px] font-black text-white/20 tracking-[0.2em]">{{ $item['year'] ?? 'Unknown' }}</p>
                                 </a>
                            @endforeach
                        </div>
                     </section>
                </div>

                <section>
                    <div class="flex items-center justify-between mb-10">
                        <div class="flex items-center">
                            <div class="w-1.5 h-10 bg-emerald-500 rounded-full mr-6 shadow-[0_0_15px_rgba(16,185,129,0.5)]"></div>
                            <h2 class="text-3xl font-black text-white tracking-tighter uppercase">Top Songs</h2>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach($article->artist->songs->take(3) as $song)
                            <div class="group cursor-pointer">
                                <div class="aspect-square rounded-[2.5rem] overflow-hidden border border-white/5 bg-[#161b22] relative mb-6 shadow-2xl transition-all duration-500 group-hover:border-blue-500/20 group-hover:-translate-y-2">
                                    @if($song->article)
                                    <img src="{{ $song->article->featured_image }}" class="w-full h-full object-cover grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-700">
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent"></div>
                                    <div class="absolute bottom-8 left-8 right-8">
                                        <h3 class="text-xl font-black text-white tracking-tighter">{{ $song->title }}</h3>
                                        <p class="text-[11px] font-bold text-white/40 mt-1 uppercase">{{ $song->genre->name ?? 'Mixed' }} • {{ $song->release_date ? $song->release_date->format('Y') : '2024' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between px-4">
                                    @if($song->article)
                                    <a href="{{ route('wiki.show', $song->article) }}" class="text-[11px] font-black text-blue-400 group-hover:text-blue-300 uppercase tracking-widest flex items-center gap-2">
                                        View Details
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/></svg>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                 <section class="border-t border-white/5 pt-16">
                    <div class="flex items-center border-b border-white/5 pb-6 mb-10">
                        <div class="w-1.5 h-10 bg-purple-500 rounded-full mr-6 shadow-[0_0_15px_rgba(168,85,247,0.5)]"></div>
                        <h2 class="text-3xl font-black text-white tracking-tighter">Related Content</h2>
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

        </main>
    </div>
</div>
@endsection
