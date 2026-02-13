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

    $featured_image = $article->featured_image;
    if ($featured_image && !Str::startsWith($featured_image, ['http://', 'https://'])) {
        $featured_image = Storage::url($featured_image);
    }
    // No specific placeholder for genre usually, maybe a pattern
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
                <a href="{{ route('wiki.index', ['category' => $key]) }}" class="group flex items-center gap-4 px-4 py-4 rounded-2xl text-[14px] font-bold transition-all {{ $key === 'genre' ? 'bg-blue-500/10 text-white border border-blue-500/20 shadow-lg' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
                    <div class="w-9 h-9 rounded-full {{ $key === 'genre' ? 'bg-blue-500 shadow-lg shadow-blue-500/20' : 'bg-white/5' }} flex items-center justify-center transition-all group-hover:scale-110">
                        <svg class="w-4 h-4 {{ $key === 'genre' ? 'text-white' : 'text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $cat['icon'] !!}</svg>
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
                    <a href="{{ route('wiki.index', ['category' => 'genre']) }}" class="hover:text-blue-400 transition-colors">Genres</a>
                    <span>/</span>
                    <span class="text-white">{{ Str::limit($article->title, 30) }}</span>
                </nav>

                <div class="flex items-center gap-4">
                    <a href="{{ route('wiki.edit', $article) }}" class="text-xs font-bold text-white/50 hover:text-white tracking-wider transition-colors">Edit</a>
                </div>
            </div>

            <!-- Hero Area -->
            <div class="relative w-full rounded-[2.5rem] overflow-hidden mb-16 border border-white/5 group bg-[#0d1117] min-h-[400px] flex items-end shadow-3xl">
                 {{-- Immersive Background --}}
                 <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10"></div>
                 <div class="absolute inset-0 bg-gradient-to-br from-[#0d1117] via-[#161b22] to-blue-900/20"></div>
                 <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-blue-500/10 rounded-full blur-[160px] -mr-40 -mt-40"></div>
                 
                 <div class="relative z-10 p-6 md:p-12 lg:p-16 w-full">
                     <span class="px-3 py-1.5 bg-blue-500/10 border border-blue-500/20 text-blue-400 rounded-lg text-[10px] font-bold tracking-widest inline-block mb-8 shadow-lg">
                        Genre info
                    </span>
                    
                        <h1 class="text-soundbook-heading text-5xl sm:text-7xl md:text-8xl lg:text-[110px] text-white mb-6">
                            {{ strtoupper($article->title) }}
                        </h1>
                        
                        <!-- Contributor Bar (SoundBook Style) -->
                        <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 mb-12">
                            <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-full px-5 py-2.5 backdrop-blur-md">
                                @if($article->user)
                                    <img src="{{ $article->user->avatar ?? 'https://ui-avatars.com/api/?name='.$article->user->name }}" class="w-6 h-6 rounded-full border border-blue-500/50">
                                    <span class="text-[11px] font-black text-white uppercase tracking-widest">Contributor: {{ $article->user->name }}</span>
                                @else
                                    <img src="https://ui-avatars.com/api/?name=Archivist" class="w-6 h-6 rounded-full border border-white/10">
                                    <span class="text-[11px] font-black text-white/50 uppercase tracking-widest">Contributor: Community</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-2 text-[11px] font-bold text-white/30 uppercase tracking-widest px-4 border-l border-white/10">
                                <span>Updated: {{ $article->updated_at->format('M d, Y') }}</span>
                            </div>
                            <button class="bg-blue-600 hover:bg-blue-500 text-white rounded-full px-6 py-2.5 text-[10px] font-black uppercase tracking-widest transition-all shadow-lg shadow-blue-500/20">
                                View Portfolio
                            </button>
                        </div>
                    </div>
                 </div>


            {{-- Main Column --}}
            <div class="space-y-20">
                
                {{-- Origin & History --}}
                <section>
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h2 class="text-soundbook-heading text-3xl lg:text-4xl text-white uppercase tracking-tighter">History</h2>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                        <div class="card-premium-unified !bg-[#161b22]/40 group !p-8">
                            <span class="text-[10px] font-black text-white/20 uppercase tracking-[0.3em] mb-4 block">Origin</span>
                            <div class="text-white text-xl font-black tracking-tighter group-hover:text-blue-400 transition-colors">Toronto & Chicago</div>
                        </div>
                        <div class="card-premium-unified !bg-[#161b22]/40 group !p-8">
                            <span class="text-[10px] font-black text-white/20 uppercase tracking-[0.3em] mb-4 block">Date</span>
                            <div class="text-white text-xl font-black tracking-tighter group-hover:text-emerald-400 transition-colors">Late 2000s - Early 2010s</div>
                        </div>
                        <div class="card-premium-unified !bg-[#161b22]/40 group !p-8">
                            <span class="text-[10px] font-black text-white/20 uppercase tracking-[0.3em] mb-4 block">Initial Signings</span>
                            <div class="text-white text-xl font-black tracking-tighter group-hover:text-purple-400 transition-colors">D-Box</div>
                        </div>
                    </div>

                    <div class="flex items-center border-b border-white/5 pb-6 mb-10">
                        <div class="w-1.5 h-10 bg-emerald-500 rounded-full mr-6 shadow-[0_0_15px_rgba(16,185,129,0.5)]"></div>
                        <h2 class="text-3xl font-black text-white tracking-tighter uppercase">Timeline</h2>
                    </div>
                    <livewire:wiki.⚡timeline :entity="$genre" />
                </section>

            <!-- Pioneer Artists Section (Image 3 Style) -->
            <section class="mb-20">
                <div class="flex items-center justify-between mb-10">
                    <div>
                        <h2 class="text-soundbook-heading text-4xl lg:text-5xl text-white">FEATURED ARTISTS</h2>
                    </div>
                    <div class="flex gap-4">
                        <button class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center text-white/40 hover:text-white hover:bg-white/5 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center text-white/40 hover:text-white hover:bg-white/5 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @php
                        $pioneerArtists = \App\Models\Artist::take(3)->get();
                    @endphp
                    @foreach($pioneerArtists as $artist)
                        @if($artist->article)
                        <a href="{{ route('wiki.show', $artist->article) }}" class="group">
                            <div class="aspect-[4/5] rounded-[2.5rem] overflow-hidden border border-white/5 bg-[#161b22] relative mb-6 shadow-2xl transition-all duration-500 group-hover:border-blue-500/20 group-hover:-translate-y-2">
                                <img src="{{ $artist->article->featured_image }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent"></div>
                                <div class="absolute bottom-8 left-8">
                                    <h3 class="text-2xl font-black text-white tracking-tighter">{{ $artist->name }}</h3>
                                    <p class="text-[11px] font-bold text-white/40 mt-1 uppercase">Pioneer • {{ $artist->songs->count() }} Tracks</p>
                                </div>
                            </div>
                        </a>
                        @endif
                    @endforeach
                </div>
            </section>

            <!-- Subgenres Section (Image 3 Style) -->
            <section class="mb-20">
                <div class="flex items-center justify-between mb-10">
                    <div>
                        <h2 class="text-soundbook-heading text-4xl lg:text-5xl text-white uppercase tracking-tighter">Related Styles</h2>
                    </div>
                </div>
                <div class="flex flex-wrap gap-4">
                    @php
                        $subgenres = ['Afrobeat', 'Amapiano', 'Afro-fusion', 'Highlife', 'Fante', 'Makossa'];
                        $colors = ['bg-blue-500', 'bg-emerald-500', 'bg-purple-500', 'bg-amber-500', 'bg-pink-500', 'bg-indigo-500'];
                    @endphp
                    @foreach($subgenres as $index => $sub)
                        <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-full px-6 py-3 cursor-pointer hover:bg-white/10 transition-all group">
                            <span class="w-2 h-2 rounded-full {{ $colors[$index % count($colors)] }} shadow-[0_0_10px_currentColor]"></span>
                            <span class="text-sm font-black text-white uppercase tracking-widest">{{ $sub }}</span>
                        </div>
                    @endforeach
                </div>
            </section>

                {{-- Featured Tracks --}}
                <section>
                    <div class="flex items-center justify-between mb-10">
                        <div class="flex items-center">
                            <div class="w-1.5 h-10 bg-blue-500 rounded-full mr-6 shadow-[0_0_15px_rgba(59,130,246,0.5)]"></div>
                            <h2 class="text-3xl font-black text-white tracking-tighter uppercase font-soundbook-heading">Essential Tracks</h2>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @php
                            $essentialTracks = \App\Models\Song::take(3)->get();
                        @endphp
                        @foreach($essentialTracks as $song)
                            @if($song->article)
                            <div class="group cursor-pointer">
                                <div class="aspect-video rounded-[2.5rem] overflow-hidden border border-white/5 bg-[#161b22] relative mb-6 shadow-2xl transition-all duration-500 group-hover:border-blue-500/20 group-hover:-translate-y-2">
                                    <img src="{{ $song->article->featured_image }}" class="w-full h-full object-cover grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-700">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent"></div>
                                    <div class="absolute bottom-6 left-6">
                                        <h3 class="text-xl font-black text-white tracking-tighter">{{ $song->title }}</h3>
                                        <p class="text-[11px] font-bold text-white/40 uppercase tracking-widest">{{ $song->artist->name ?? 'Unknown Artist' }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </section>

                {{-- Discussion --}}
                <section>
                    <div class="flex items-center justify-between mb-10">
                        <div>
                            <h2 class="text-soundbook-heading text-4xl lg:text-5xl text-white">DISCUSSION</h2>
                        </div>
                    </div>
                    <div class="card-premium-unified !bg-[#161b22]/40 !p-12">
                         <livewire:article.comments :article="$article" />
                    </div>
                </section>

                {{-- Related content --}}
                <section>
                    <div class="flex items-center border-b border-white/5 pb-6 mb-10">
                        <div class="w-1.5 h-10 bg-purple-500 rounded-full mr-6 shadow-[0_0_15px_rgba(168,85,247,0.5)]"></div>
                        <h2 class="text-3xl font-black text-white tracking-tighter">Related Content</h2>
                    </div>
                    <div class="h-[500px] rounded-[3rem] overflow-hidden border border-white/5 bg-black/20 backdrop-blur-xl relative">
                        <x-neural-map-visualization :articleId="$article->id" />
                    </div>
                </section>

                {{-- Metadata Consolidated Section --}}
                <section class="border-t border-white/5 pt-16">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Actions & Info --}}
                        <div class="card-premium-unified !bg-[#161b22]/40 !p-10 space-y-8">
                            <h3 class="text-[11px] font-bold text-white/40 tracking-widest uppercase">Information</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between py-2 border-b border-white/5">
                                    <span class="text-sm text-white/50 font-medium">Status</span>
                                    <span class="text-sm text-white font-bold">Active</span>
                                </div>
                                <div class="flex items-center justify-between py-2 border-b border-white/5">
                                    <span class="text-sm text-white/50 font-medium">Synced</span>
                                    <span class="text-sm text-white font-bold">{{ optional($article->updated_at)->diffForHumans() }}</span>
                                </div>
                                <div class="flex items-center justify-between py-2">
                                    <span class="text-sm text-white/50 font-medium">Views</span>
                                    <span class="text-sm text-white font-bold">{{ number_format($article->view_count) }}</span>
                                </div>
                            </div>
                            
                            <div class="flex flex-col gap-4 pt-6">
                                <livewire:article.play-button :articleId="$article->id" label="Play genre" class="btn-figma-primary !w-full !py-4" />
                                <div class="flex gap-4">
                                    <div class="flex-1"><livewire:article.add-to-collection :article="$article" /></div>
                                    <div class="flex-1"><livewire:article.bookmark-button :article="$article" /></div>
                                </div>
                            </div>
                        </div>

                        {{-- Contributor --}}
                        <div class="card-premium-unified !bg-[#161b22]/60 !p-10">
                             <h3 class="text-[11px] font-bold text-white/40 tracking-widest mb-8 uppercase">Contributor</h3>
                             @if($article->user)
                             <div class="flex items-center gap-6">
                                <div class="w-16 h-16 rounded-full p-1 bg-gradient-to-br from-blue-500/20 to-transparent">
                                    <div class="w-full h-full rounded-full overflow-hidden border border-white/10 bg-[#0d1117] flex items-center justify-center">
                                        @if($article->user->avatar)
                                            <img src="{{ $article->user->avatar }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-xl text-white font-bold">{{ ucfirst(substr($article->user->name, 0, 1)) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <p class="text-xl font-bold text-white">{{ $article->user->name }}</p>
                                    <p class="text-xs text-white/30 font-medium tracking-widest uppercase mt-1">Contributor</p>
                                </div>
                             </div>
                             @endif
                             <div class="mt-8 p-5 rounded-2xl bg-white/5 border border-white/5">
                                <p class="text-xs text-white/40 italic leading-relaxed">"This record represents a specific moment in music history, curated for the archive."</p>
                             </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>
</div>
@endsection
