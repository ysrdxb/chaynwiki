@extends('layouts.wiki')

@section('title', $article->title . ' — ' . ($article->song->artist->name ?? 'Artist'))

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
    $featured_image = $featured_image ?: 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&q=80&w=1200';
@endphp

<div class="min-h-screen bg-[#0d1117] flex justify-center">
    <div class="max-w-[1400px] w-full px-8 flex items-start gap-12 pt-32 pb-16">
        
        <!-- Sidebar Navigation -->
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

            <a href="{{ route('wiki.index') }}" class="group flex items-center gap-4 px-4 py-4 rounded-2xl text-[13px] font-black uppercase tracking-widest text-white/50 hover:text-white hover:bg-white/5 transition-all">
                <div class="w-8 h-8 rounded-lg bg-blue-500/10 border border-white/5 flex items-center justify-center group-hover:bg-blue-500 group-hover:scale-110 transition-all">
                    <svg class="w-4 h-4 text-blue-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                </div>
                Library
            </a>

            <div class="h-px bg-white/5 mx-4 my-6"></div>
            
            @foreach($categories as $key => $cat)
                <a href="{{ route('wiki.index', ['category' => $key]) }}" class="group flex items-center gap-4 px-4 py-4 rounded-2xl text-[13px] font-black uppercase tracking-widest transition-all {{ $key === 'song' ? 'bg-blue-500/10 text-white border border-blue-500/20 shadow-lg' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
                    <div class="w-8 h-8 rounded-lg {{ $key === 'song' ? 'bg-blue-500' : 'bg-white/5' }} flex items-center justify-center transition-all group-hover:scale-110">
                        <svg class="w-4 h-4 {{ $key === 'song' ? 'text-white' : 'text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $cat['icon'] !!}</svg>
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
                 <nav class="flex items-center gap-2 text-[10px] font-bold text-white/30 uppercase tracking-[0.2em]">
                    <a href="{{ route('wiki.index', ['category' => 'song']) }}" class="hover:text-blue-400 transition-colors">Songs</a>
                    <span>/</span>
                    <span class="text-white">{{ Str::limit($article->title, 30) }}</span>
                </nav>

                <div class="flex items-center gap-4">
                    <a href="{{ route('wiki.edit', $article) }}" class="text-xs font-bold text-white/50 hover:text-white uppercase tracking-wider transition-colors">Edit</a>
                </div>
            </div>

            <!-- Hero Area -->
            <div class="relative w-full rounded-[2.5rem] overflow-hidden mb-12 border border-white/5 group bg-[#0d1117] shadow-3xl">
                 {{-- Immersive Background --}}
                 <div class="absolute inset-0 z-0">
                     <img src="{{ $featured_image }}" class="w-full h-full object-cover grayscale opacity-10 blur-3xl scale-125 transition-all duration-1000 group-hover:scale-110 group-hover:opacity-20">
                     <div class="absolute inset-0 bg-gradient-to-t from-[#0d1117] via-[#0d1117]/80 to-transparent"></div>
                     <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-blue-500/5 rounded-full blur-[160px] -mr-40 -mt-40"></div>
                 </div>
                 
                 <div class="relative z-10 p-12 lg:p-16 flex flex-col lg:flex-row gap-12 items-end">
                     <!-- Cover Art -->
                     <div class="shrink-0 relative group/cover cursor-pointer">
                         <div class="w-56 h-56 md:w-72 md:h-72 rounded-[2.5rem] overflow-hidden border border-white/10 shadow-[0_0_100px_rgba(0,0,0,0.8)] relative z-10 transition-all duration-700 group-hover:border-blue-500/30">
                             <img src="{{ $featured_image }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                             <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover/cover:opacity-100 transition-all duration-300">
                                 <div class="w-16 h-16 rounded-full bg-blue-500 text-white flex items-center justify-center shadow-2xl transform scale-90 group-hover/cover:scale-100 transition-all duration-500">
                                     <svg class="w-7 h-7 ml-1.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                 </div>
                             </div>
                         </div>
                         {{-- Glow Accent --}}
                         <div class="absolute -inset-8 bg-blue-500/20 blur-[60px] rounded-full opacity-30 group-hover:opacity-60 transition-all duration-1000"></div>
                     </div>
                     
                     <div class="flex-1 min-w-0 pb-4">
                        <div class="flex items-center gap-3 mb-8">
                            <span class="px-3 py-1.5 bg-blue-500 text-[#0d1117] rounded-lg text-[10px] font-black uppercase tracking-[0.3em] shadow-lg">Record File</span>
                            @if($article->song->label)
                                <span class="px-3 py-1.5 bg-white/5 border border-white/10 text-white/50 rounded-lg text-[10px] font-black uppercase tracking-[0.3em] shadow-lg">{{ $article->song->label }}</span>
                            @endif
                        </div>
                        
                        <h1 class="text-[52px] lg:text-[80px] font-black text-white uppercase tracking-tightest mb-4 leading-[0.9] -ml-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            {{ $article->title }}
                        </h1>
                        
                        <div class="flex items-center gap-3 text-2xl lg:text-3xl font-black text-white/60 mb-10 tracking-tightest">
                            @if($article->song && $article->song->artist)
                                <span class="text-white/20 uppercase text-[12px] not-italic tracking-[0.3em] mr-2">By</span>
                                <a href="{{ route('wiki.show', $article->song->artist->article) }}" class="text-blue-500 hover:text-white transition-colors border-b-2 border-transparent hover:border-blue-500">
                                    {{ $article->song->artist->name }}
                                </a>
                            @endif
                        </div>

                        <div class="flex flex-wrap gap-10">
                             <div class="flex flex-col">
                                <span class="text-white text-3xl font-black tracking-tightest mb-1">{{ $article->song->release_date ?? 'Unknown' }}</span>
                                <span class="text-[10px] text-white/20 font-black uppercase tracking-[0.3em]">Release Date</span>
                             </div>
                             <div class="flex flex-col">
                                <span class="text-blue-500 text-3xl font-black tracking-tightest mb-1">{{ number_format($article->view_count ?? 0) }}</span>
                                <span class="text-[10px] text-white/20 font-black uppercase tracking-[0.3em]">Total Plays</span>
                             </div>
                        </div>
                     </div>
                 </div>
            </div>
            
            <!-- Rapid Fire Section -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
                <div class="card-premium-unified bg-[#161b22]/40 border border-white/5 !p-8 group hover:border-blue-500/30 transition-all">
                    <p class="text-[10px] font-black text-white/20 uppercase tracking-[0.3em] mb-4">Tone Key</p>
                    <p class="text-3xl font-black text-white tracking-tightest group-hover:text-blue-500 transition-colors uppercase">{{ $article->song->key ?? '--' }}</p>
                </div>
                 <div class="card-premium-unified bg-[#161b22]/40 border border-white/5 !p-8 group hover:border-blue-500/30 transition-all">
                    <p class="text-[10px] font-black text-white/20 uppercase tracking-[0.3em] mb-4">Tempo (BPM)</p>
                    <p class="text-3xl font-black text-blue-500 tracking-tightest transition-colors uppercase">{{ $article->song->bpm ?? '--' }}</p>
                </div>
                 <div class="card-premium-unified bg-[#161b22]/40 border border-white/5 !p-8 group hover:border-blue-500/30 transition-all">
                    <p class="text-[10px] font-black text-white/20 uppercase tracking-[0.3em] mb-4">Genre Class</p>
                    <p class="text-3xl font-black text-white tracking-tightest group-hover:text-blue-500 transition-colors uppercase truncate">{{ $article->genre ? $article->genre->name : 'Experimental' }}</p>
                </div>
                 <div class="card-premium-unified bg-[#161b22]/40 border border-white/5 !p-8 group hover:border-blue-500/30 transition-all">
                    <p class="text-[10px] font-black text-white/20 uppercase tracking-[0.3em] mb-4">Time Span</p>
                    <p class="text-3xl font-black text-white tracking-tightest group-hover:text-blue-500 transition-colors uppercase">{{ $article->song->duration ?? '--' }}</p>
                </div>
            </div>

            <div class="flex flex-col xl:flex-row gap-12">
                <!-- Article Content -->
                <div class="flex-1 min-w-0 space-y-12">
                    <section>
                        <h2 class="text-[32px] font-black text-white uppercase tracking-tightest mb-10 flex items-center gap-4" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            <div class="w-12 h-1.5 bg-blue-500 rounded-full"></div>
                            Analysis
                        </h2>
                        <article class="prose prose-invert prose-lg max-w-none">
                            @if($summary)
                                <div class="mb-8 p-6 bg-[#161b22]/60 border border-white/5 rounded-2xl">
                                    <h3 class="text-white text-lg font-bold mb-2 uppercase tracking-tight">{{ strtoupper($article->song->album ?? 'About this Track') }}</h3>
                                    <p class="text-white/70 text-sm leading-relaxed relative z-10">
{{ $summary }}</p>
                                </div>
                            @endif
                            <div class="article-content text-white/70 text-base leading-relaxed">
                                @if(!empty($article->content))
                                    {!! Str::markdown($article->content) !!}
                                @else
                                    <p class="text-white/30 uppercase tracking-[0.2em] text-[12px]">No classification data available for this node.</p>
                                @endif
                            </div>
                        </article>
                    </section>

                    <!-- Lyrics -->
                    @if($article->song && $article->song->lyrics)
                    <section>
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-white">Lyrics</h3>
                            <!-- Copy button placeholder -->
                        </div>
                        <div class="bg-[#161b22]/40 border border-white/5 rounded-2xl p-8 font-mono text-sm leading-loose text-white/80 whitespace-pre-line">
                            {{ $article->song->lyrics }}
                        </div>
                    </section>
                    @endif
                    
                     <section class="border-t border-white/5 pt-16">
                        <h2 class="text-[32px] font-black text-white uppercase tracking-tightest mb-10 flex items-center gap-4" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            <div class="w-12 h-1.5 bg-blue-500 rounded-full"></div>
                            Discussion
                        </h2>
                        <livewire:article.comments :article="$article" />
                    </section>
                </div>

                <!-- Right Sidebar (Relevant Data) -->
                <aside class="w-full xl:w-80 space-y-6 shrink-0">
                    
                    <!-- Actions -->
                    <div class="card-premium-unified bg-[#161b22]/40 border border-white/5 rounded-[2.5rem] p-8 flex flex-col gap-6">
                        <livewire:article.play-button 
                            :articleId="$article->id" 
                            label="Initiate Play"
                            class="btn-figma-primary !w-full !py-4"
                        />
                        
                        <div class="group"><x-article.⚡add-to-crate :article="$article" /></div>

                        <div class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/5 group hover:border-blue-500/20 transition-all">
                            <span class="text-[10px] font-black text-white/30 uppercase tracking-[0.3em]">Network Rating</span>
                             <livewire:article.vote-button :model="$article" wire:key="sidebar-vote-article-{{ $article->id }}" />
                        </div>
                        
                        <div class="group"><livewire:article.bookmark-button :article="$article" /></div>
                    </div>

                    <!-- Metadata List -->
                    <div class="bg-[#161b22]/60 border border-white/5 rounded-[20px] p-6">
                        <h3 class="text-xs font-bold text-white/40 uppercase tracking-widest mb-6">Track Info</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between py-2 border-b border-white/5">
                                <span class="text-sm text-white/50 font-medium">Producer</span>
                                <span class="text-sm text-white font-bold">{{ $article->song->producer ?? 'Unknown' }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-white/5">
                                <span class="text-sm text-white/50 font-medium">Album</span>
                                <span class="text-sm text-white font-bold">{{ $article->song->album ?? 'Single' }}</span>
                            </div>
                             <div class="flex items-center justify-between py-2 border-b border-white/5">
                                <span class="text-sm text-white/50 font-medium">Plays</span>
                                <span class="text-sm text-white font-bold">{{ number_format($article->song->stream_count ?? 0) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Contributor -->
                    @if($article->user)
                    <div class="bg-[#161b22]/60 border border-white/5 rounded-[20px] p-6">
                        <h3 class="text-xs font-bold text-white/40 uppercase tracking-widest mb-4">Added By</h3>
                        <a href="{{ route('profile', $article->user->username) }}" class="flex items-center gap-4 group">
                            <div class="w-10 h-10 rounded-full overflow-hidden border border-white/10">
                                @if($article->user->avatar)
                                    <img src="{{ $article->user->avatar }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-blue-400/20 flex items-center justify-center text-blue-400 font-bold">
                                        {{ strtoupper(substr($article->user->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-bold text-white group-hover:text-blue-400 transition-colors">{{ $article->user->name }}</p>
                                <p class="text-xs text-white/30">{{ optional($article->created_at)->format('M d, Y') }}</p>
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
