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
                <a href="{{ route('wiki.index', ['category' => $key]) }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-bold transition-all {{ $key === 'song' ? 'bg-white/5 text-white' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
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
                    <a href="{{ route('wiki.index', ['category' => 'song']) }}" class="hover:text-blue-400 transition-colors">Songs</a>
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
                     <!-- Cover Art -->
                     <div class="shrink-0 relative group/cover cursor-pointer">
                         <div class="w-48 h-48 md:w-56 md:h-56 rounded-2xl overflow-hidden border border-white/10 shadow-2xl relative z-10">
                             <img src="{{ $featured_image }}" class="w-full h-full object-cover">
                             <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover/cover:opacity-100 transition-all duration-300">
                                 <div class="w-12 h-12 rounded-full bg-blue-400 text-white flex items-center justify-center shadow-lg transform scale-90 group-hover/cover:scale-100 transition-all">
                                     <svg class="w-5 h-5 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                 </div>
                             </div>
                         </div>
                     </div>
                     
                     <div class="flex-1 min-w-0 pb-2">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="px-2.5 py-1 bg-blue-400 text-[#0d1117] rounded-lg text-[9px] font-black uppercase tracking-widest">Song</span>
                            @if($article->song->label)
                                <span class="px-2.5 py-1 bg-white/10 border border-white/10 text-white/70 rounded-lg text-[9px] font-bold uppercase tracking-widest">{{ $article->song->label }}</span>
                            @endif
                        </div>
                        
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white uppercase tracking-tighter mb-2 leading-none">
                            {{ $article->title }}
                        </h1>
                        
                        <div class="flex items-center gap-2 text-xl md:text-2xl font-bold text-white/60 mb-6">
                            @if($article->song && $article->song->artist)
                                <a href="{{ route('wiki.show', $article->song->artist->article) }}" class="text-white hover:text-blue-400 transition-colors border-b-2 border-transparent hover:border-blue-400">
                                    {{ $article->song->artist->name }}
                                </a>
                            @endif
                        </div>

                        <div class="flex items-center gap-6 text-xs font-bold text-white/50 uppercase tracking-wider">
                             <span>Released: <span class="text-white">{{ $article->song->release_date ?? 'Unknown' }}</span></span>
                             <span>Views: <span class="text-white">{{ number_format($article->view_count ?? 0) }}</span></span>
                        </div>
                     </div>
                 </div>
            </div>
            
            <!-- Rapid Fire Section -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
                <div class="bg-[#161b22]/40 border border-white/5 rounded-xl p-4">
                    <p class="text-[9px] font-bold text-white/30 uppercase tracking-widest mb-1">Key</p>
                    <p class="text-lg font-black text-white">{{ $article->song->key ?? '--' }}</p>
                </div>
                 <div class="bg-[#161b22]/40 border border-white/5 rounded-xl p-4">
                    <p class="text-[9px] font-bold text-white/30 uppercase tracking-widest mb-1">BPM</p>
                    <p class="text-lg font-black text-blue-400">{{ $article->song->bpm ?? '--' }}</p>
                </div>
                 <div class="bg-[#161b22]/40 border border-white/5 rounded-xl p-4">
                    <p class="text-[9px] font-bold text-white/30 uppercase tracking-widest mb-1">Genre</p>
                    <p class="text-lg font-black text-white truncate">{{ $article->genre ? $article->genre->name : '--' }}</p>
                </div>
                 <div class="bg-[#161b22]/40 border border-white/5 rounded-xl p-4">
                    <p class="text-[9px] font-bold text-white/30 uppercase tracking-widest mb-1">Duration</p>
                    <p class="text-lg font-black text-white">{{ $article->song->duration ?? '--' }}</p>
                </div>
            </div>

            <div class="flex flex-col xl:flex-row gap-12">
                <!-- Article Content -->
                <div class="flex-1 min-w-0 space-y-12">
                     <article class="prose prose-invert prose-lg max-w-none">
                        @if($summary)
                            <div class="mb-8 p-6 bg-[#161b22]/60 border border-white/5 rounded-2xl">
                                <h3 class="text-white text-lg font-bold mb-2 uppercase tracking-tight">{{ strtoupper($article->song->album ?? 'About this Track') }}</h3>
                                <p class="text-white/70 text-base leading-relaxed m-0">{{ $summary }}</p>
                            </div>
                        @endif
                        
                        <div class="article-content text-white/70 text-base leading-relaxed">
                             {!! Str::markdown($article->content) !!}
                        </div>
                    </article>

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
                            label="Play Track"
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
