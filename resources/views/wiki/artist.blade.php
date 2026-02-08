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
        <aside class="hidden lg:block w-64 sticky top-32 shrink-0 space-y-2">
            <a href="{{ route('home') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-bold text-white/50 hover:text-white hover:bg-white/5 transition-all">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Home
            </a>

            <div class="h-px bg-white/5 mx-4 my-2"></div>

            <a href="{{ route('wiki.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-bold transition-all text-white/50 hover:text-white hover:bg-white/5">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                All Records
            </a>
            
            @foreach($categories as $key => $cat)
                <a href="{{ route('wiki.index', ['category' => $key]) }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-bold transition-all {{ $key === 'artist' ? 'bg-white/5 text-white' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $cat['icon'] !!}</svg>
                    {{ $cat['label'] }}
                </a>
            @endforeach
        </aside>

        <!-- Main Content -->
        <main class="flex-1 min-w-0">
             <!-- Top Action Row -->
             <div class="flex justify-between items-center mb-8">
                 <!-- Breadcrumbs -->
                 <nav class="flex items-center gap-2 text-[10px] font-bold text-white/30 uppercase tracking-[0.2em]">
                    <a href="{{ route('wiki.index', ['category' => 'artist']) }}" class="hover:text-blue-400 transition-colors">Artists</a>
                    <span>/</span>
                    <span class="text-white">{{ Str::limit($article->title, 30) }}</span>
                </nav>

                <div class="flex items-center gap-4">
                    <a href="{{ route('wiki.edit', $article) }}" class="text-xs font-bold text-white/50 hover:text-white uppercase tracking-wider transition-colors">Edit</a>
                </div>
            </div>

            <!-- Hero Area -->
            <div class="relative w-full rounded-[2rem] overflow-hidden mb-10 border border-white/5 group bg-[#161b22]">
                 <div class="absolute inset-0 z-0">
                     <img src="{{ $featured_image }}" class="w-full h-full object-cover grayscale opacity-20 blur-xl scale-110">
                     <div class="absolute inset-0 bg-gradient-to-t from-[#0d1117] to-transparent"></div>
                 </div>
                 
                 <div class="relative z-10 p-8 md:p-10 flex flex-col md:flex-row gap-8 items-end">
                     <!-- Artist Portrait -->
                     <div class="shrink-0 relative group/cover cursor-pointer">
                         <div class="w-48 h-48 md:w-64 md:h-64 rounded-full overflow-hidden border-4 border-white/10 shadow-2xl relative z-10 bg-[#0d1117]">
                             <img src="{{ $featured_image }}" class="w-full h-full object-cover">
                         </div>
                         <div class="absolute -inset-4 bg-blue-400/20 blur-2xl rounded-full opacity-50 group-hover/cover:opacity-100 transition-all duration-700"></div>
                     </div>
                     
                     <div class="flex-1 min-w-0 pb-2">
                        <div class="flex items-center gap-3 mb-4">
                             @if(!empty($artistMeta['spotify_id']) || !empty($artistMeta['website']))
                                <span class="px-2.5 py-1 bg-blue-400/10 border border-blue-400/20 text-blue-400 rounded-lg text-[9px] font-black uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span> Verified Artist
                                </span>
                            @else
                                <span class="px-2.5 py-1 bg-white/10 border border-white/10 text-white/70 rounded-lg text-[9px] font-bold uppercase tracking-widest">Artist Profile</span>
                            @endif
                        </div>
                        
                        <h1 class="text-5xl lg:text-7xl font-black text-white uppercase tracking-tighter mb-4 leading-none">
                            {{ $article->title }}
                        </h1>
                        
                        <!-- Stats Grid -->
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 text-white/60">
                             <div class="flex flex-col">
                                <span class="text-white text-xl font-black italic tracking-tight">{{ number_format($artistStats['views'] ?? 0) }}</span>
                                <span class="text-[9px] text-white/30 font-bold uppercase tracking-widest">Views</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-white text-xl font-black italic tracking-tight">{{ number_format($artistStats['streams'] ?? 0) }}</span>
                                <span class="text-[9px] text-white/30 font-bold uppercase tracking-widest">Streams</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-blue-400 text-xl font-black italic tracking-tight">{{ number_format($artistStats['impact'] ?? 0, 1) }}</span>
                                <span class="text-[9px] text-white/30 font-bold uppercase tracking-widest">Impact Core</span>
                            </div>
                             <div class="flex flex-col">
                                <span class="text-white text-xl font-black italic tracking-tight">#{{ number_format($artistStats['rank'] ?? 0) }}</span>
                                <span class="text-[9px] text-white/30 font-bold uppercase tracking-widest">Global Rank</span>
                            </div>
                        </div>
                     </div>
                 </div>
            </div>

            <div class="flex flex-col xl:flex-row gap-12">
                <!-- Article Content -->
                <div class="flex-1 min-w-0 space-y-16">
                     <!-- Bio -->
                     <section>
                         <h2 class="text-2xl font-black text-white italic uppercase tracking-tighter mb-8 flex items-center gap-3">
                            <span class="w-8 h-px bg-white/20"></span>
                            Biography
                        </h2>
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

                     <!-- Discography -->
                     @if(!$artistDiscography->isEmpty())
                     <section>
                        <div class="flex items-center justify-between mb-8">
                             <h2 class="text-2xl font-black text-white italic uppercase tracking-tighter">Discography</h2>
                             <a href="{{ route('wiki.index', ['category' => 'song', 'q' => $article->title]) }}" class="text-xs font-bold text-blue-400 uppercase tracking-widest hover:underline">View All</a>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($artistDiscography as $item)
                                 <a href="{{ $item['url'] }}" class="group block bg-[#161b22]/40 border border-white/5 rounded-2xl p-4 hover:bg-[#161b22] hover:border-white/10 transition-all">
                                    <div class="aspect-square rounded-xl overflow-hidden bg-black/20 mb-4 relative">
                                        <img src="{{ $item['image'] }}" onerror="this.onerror=null;this.src='{{ $placeholder }}';" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                                        <div class="absolute inset-0 bg-blue-400/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    </div>
                                    <h4 class="text-white font-bold text-sm truncate group-hover:text-blue-400 transition-colors">{{ $item['title'] }}</h4>
                                    <p class="text-[10px] font-bold text-white/30 uppercase tracking-widest mt-1">{{ $item['year'] ?? 'Unknown' }}</p>
                                 </a>
                            @endforeach
                        </div>
                     </section>
                     @endif

                     <!-- Gallery -->
                     @if(!$artistGallery->isEmpty())
                     <section>
                        <h2 class="text-2xl font-black text-white italic uppercase tracking-tighter mb-8">Visual Archive</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($artistGallery as $item)
                                <div class="relative aspect-[3/4] rounded-2xl overflow-hidden border border-white/5 group hover:border-blue-400/30 transition-all">
                                    <img src="{{ $item['image'] }}" onerror="this.onerror=null;this.src='{{ $placeholder }}';" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                                    <div class="absolute inset-0 bg-gradient-to-t from-[#0d1117] via-transparent to-transparent opacity-60"></div>
                                    <div class="absolute bottom-4 left-4 right-4">
                                        <p class="text-[10px] font-bold text-white uppercase tracking-widest truncate">{{ $item['title'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                     </section>
                     @endif
                    
                    <section class="border-t border-white/5 pt-10">
                        <h3 class="text-xl font-bold text-white mb-6">Discussion</h3>
                        <livewire:article.comments :article="$article" />
                    </section>
                </div>

                <!-- Right Sidebar (Relevant Data) -->
                <aside class="w-full xl:w-80 space-y-6 shrink-0">
                    
                    <!-- Actions -->
                    <div class="bg-[#161b22]/60 border border-white/5 rounded-[20px] p-6 flex flex-col gap-4">
                        <livewire:article.play-button 
                            :articleId="$article->id" 
                            label="Play All Tracks"
                            class="w-full py-3 bg-white text-black rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-gray-200 transition-all flex items-center justify-center gap-2"
                        />
                        
                        <div><x-article.⚡add-to-crate :article="$article" /></div>

                        <div class="flex items-center justify-between p-3 bg-white/5 rounded-xl border border-white/5">
                            <span class="text-[9px] font-bold text-white/40 uppercase tracking-widest">Protocol Score</span>
                             <livewire:article.vote-button :model="$article" wire:key="sidebar-vote-article-{{ $article->id }}" />
                        </div>
                        
                        <div><livewire:article.bookmark-button :article="$article" /></div>
                    </div>

                    <!-- Metadata List -->
                    @if(!empty(array_filter($artistMeta ?? [])))
                    <div class="bg-[#161b22]/60 border border-white/5 rounded-[20px] p-6">
                        <h3 class="text-xs font-bold text-white/40 uppercase tracking-widest mb-6">Artist Info</h3>
                        <div class="space-y-4">
                            @if(!empty($artistMeta['origin']))
                            <div class="flex items-center justify-between py-2 border-b border-white/5">
                                <span class="text-sm text-white/50 font-medium">Origin</span>
                                <span class="text-sm text-white font-bold">{{ $artistMeta['origin'] }}</span>
                            </div>
                            @endif
                            @if(!empty($artistMeta['active_from']))
                            <div class="flex items-center justify-between py-2 border-b border-white/5">
                                <span class="text-sm text-white/50 font-medium">Active From</span>
                                <span class="text-sm text-white font-bold">{{ $artistMeta['active_from'] }}</span>
                            </div>
                            @endif
                            @if(!empty($artistMeta['website']))
                            <div class="flex items-center justify-between py-2 border-b border-white/5">
                                <span class="text-sm text-white/50 font-medium">Website</span>
                                <a href="{{ $artistMeta['website'] }}" target="_blank" class="text-sm text-blue-400 font-bold hover:underline">Link ↗</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Network Proximity / Related -->
                     @if(!$relatedSongs->isEmpty())
                     <div class="bg-[#161b22]/60 border border-white/5 rounded-[20px] p-6">
                        <h3 class="text-xs font-bold text-white/40 uppercase tracking-widest mb-4">Network Proximity</h3>
                        <div class="space-y-4">
                            @foreach($relatedSongs as $song)
                                @if($song->article)
                                <a href="{{ route('wiki.show', $song->article->slug) }}" class="flex items-center gap-3 group">
                                    <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 overflow-hidden shrink-0">
                                         <!-- Placeholder for song art if needed or just icon -->
                                         <div class="w-full h-full flex items-center justify-center text-white/20 group-hover:text-blue-400 transition-colors">
                                             <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/></svg>
                                         </div>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold text-white truncate group-hover:text-blue-400 transition-colors">{{ $song->title }}</p>
                                        <p class="text-[10px] text-white/40 uppercase tracking-widest">Song Record</p>
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
