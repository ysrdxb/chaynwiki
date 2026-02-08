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
        $featured_image = $article->featured_image;
        if ($featured_image && !Str::startsWith($featured_image, ['http://', 'https://'])) {
            $featured_image = Storage::url($featured_image);
        }
        $featured_image = $featured_image ?: 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&q=80&w=1200';
    @endphp

    <!-- HERO SECTION -->
    <div class="relative min-h-[60vh] flex items-end pt-32 pb-20 overflow-hidden bg-[#0d1117] border-b border-white/5">
        <!-- Background Layer -->
        <div class="absolute inset-0 z-0">
            <img src="{{ $featured_image }}" class="w-full h-full object-cover grayscale opacity-20 blur-md scale-110">
            <div class="absolute inset-0 bg-gradient-to-t from-[#0d1117] via-[#0d1117]/80 to-transparent"></div>
        </div>

        <div class="relative z-10 max-w-[1400px] mx-auto px-8 w-full">
            <div class="flex flex-col lg:flex-row items-end gap-12">
                <!-- Song Cover Node -->
                <div class="relative group">
                    <div class="absolute -inset-4 bg-blue-400/20 blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
                    <div class="w-64 h-64 lg:w-80 lg:h-80 rounded-[2.5rem] overflow-hidden border border-white/10 glass shadow-2xl relative z-10">
                         <img src="{{ $featured_image }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-1000" alt="{{ $article->title }}">
                             <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                             <div class="w-16 h-16 rounded-full bg-blue-400 text-white flex items-center justify-center hover:scale-110 transition shadow-2xl">
                                 <svg class="w-8 h-8 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                             </div>
                         </div>
                    </div>
                </div>

                <!-- Song Info -->
                <div class="flex-1 pb-4">
                    <div class="flex items-center gap-4 mb-6">
                        <span class="px-3 py-1 bg-blue-400/10 border border-blue-400/20 rounded-lg text-[10px] text-blue-400 font-black uppercase tracking-widest">Master Recording</span>
                    </div>
                    
                    <h1 class="text-6xl lg:text-8xl font-black text-white italic uppercase tracking-tighter mb-8 leading-none">
                        {{ $article->title }}
                    </h1>
                    
                    <div class="flex flex-wrap items-center gap-6 text-white/40 font-bold mb-10">
                        @if($article->song && $article->song->artist)
                             <a href="{{ route('wiki.show', $article->song->artist->article) }}" class="hover:text-white transition flex items-center gap-3">
                                 <span class="text-lg text-white underline underline-offset-8 decoration-blue-400/30">{{ $article->song->artist->name }}</span>
                             </a>
                        @endif
                        <span class="w-1.5 h-1.5 rounded-full bg-white/10"></span>
                        <span class="text-lg">{{ $article->song->release_date ?? 'Unknown Release' }}</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-white/10"></span>
                        <div class="flex items-center gap-2">
                             <livewire:article.vote-button :model="$article" wire:key="vote-article-{{ $article->id }}" />
                             <span class="text-[10px] font-black uppercase tracking-[0.2em] text-white/20">Archive Utility</span>
                        </div>
                    </div>

                    <!-- Statistics Strip -->
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 py-8 border-t border-white/5 max-w-4xl">
                        <div class="flex flex-col">
                            <span class="text-white text-3xl font-black italic tracking-tight">#{{ rand(1, 100) }}</span>
                            <span class="text-[9px] text-white/20 font-black uppercase tracking-widest mt-1">Trending Rank</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-white text-3xl font-black italic tracking-tight">{{ number_format($article->song->stream_count ?? rand(100, 999)) }}M</span>
                            <span class="text-[9px] text-white/20 font-black uppercase tracking-widest mt-1">Total Plays</span>
                        </div>
                         <div class="flex flex-col">
                            <span class="text-blue-400 text-3xl font-black italic tracking-tight">{{ $article->song->bpm ?? '--' }}</span>
                            <span class="text-[9px] text-white/20 font-black uppercase tracking-widest mt-1">Tempo (BPM)</span>
                        </div>
                         <div class="flex flex-col">
                            <span class="text-white text-3xl font-black italic tracking-tight">{{ $article->song->key ?? '--' }}</span>
                            <span class="text-[9px] text-white/20 font-black uppercase tracking-widest mt-1">Musical Key</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RAPID-FIRE SECTION -->
    <section class="bg-[#0d1117] section-unified py-16 border-t border-white/5 relative z-10">
        <div class="max-w-[1400px] mx-auto px-8">
            <h2 class="section-title mb-8">Rapid-Fire</h2>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <div class="bg-[#161b22]/40 border border-white/5 rounded-[20px] p-6 hover:border-white/10 transition-all">
                    <div class="mb-2">
                        <div class="w-10 h-10 rounded-full bg-blue-400/10 flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/></svg>
                        </div>
                    </div>
                    <p class="text-[10px] font-bold text-white/30 uppercase tracking-widest mb-1">Label</p>
                    <p class="text-white text-sm font-bold">{{ $article->song->label ?? 'Independent' }}</p>
                </div>

                <div class="bg-[#161b22]/40 border border-white/5 rounded-[20px] p-6 hover:border-white/10 transition-all">
                    <div class="mb-2">
                        <div class="w-10 h-10 rounded-full bg-blue-400/10 flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/></svg>
                        </div>
                    </div>
                    <p class="text-[10px] font-bold text-white/30 uppercase tracking-widest mb-1">Genre</p>
                    <p class="text-white text-sm font-bold">{{ $article->genre ? $article->genre->name : 'General' }}</p>
                </div>

                <div class="bg-[#161b22]/40 border border-white/5 rounded-[20px] p-6 hover:border-white/10 transition-all">
                    <div class="mb-2">
                        <div class="w-10 h-10 rounded-full bg-blue-400/10 flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <p class="text-[10px] font-bold text-white/30 uppercase tracking-widest mb-1">Duration</p>
                    <p class="text-white text-sm font-bold">{{ $article->song->duration ?? '3:45' }}</p>
                </div>

                <div class="bg-[#161b22]/40 border border-white/5 rounded-[20px] p-6 hover:border-white/10 transition-all">
                    <div class="mb-2">
                        <div class="w-10 h-10 rounded-full bg-blue-400/10 flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    </div>
                    <p class="text-[10px] font-bold text-white/30 uppercase tracking-widest mb-1">Released</p>
                    <p class="text-white text-sm font-bold">{{ $article->song->release_date ? $article->song->release_date->format('M d, Y') : 'N/A' }}</p>
                </div>

                <div class="bg-[#161b22]/40 border border-white/5 rounded-[20px] p-6 hover:border-white/10 transition-all">
                    <div class="mb-2">
                        <div class="w-10 h-10 rounded-full bg-blue-400/10 flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/></svg>
                        </div>
                    </div>
                    <p class="text-[10px] font-bold text-white/30 uppercase tracking-widest mb-1">Producer</p>
                    <p class="text-white text-sm font-bold">{{ $article->song->producer ?? 'Various' }}</p>
                </div>

                <div class="bg-[#161b22]/40 border border-white/5 rounded-[20px] p-6 hover:border-white/10 transition-all">
                    <div class="mb-2">
                        <div class="w-10 h-10 rounded-full bg-blue-400/10 flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                    </div>
                    <p class="text-[10px] font-bold text-white/30 uppercase tracking-widest mb-1">Tempo</p>
                    <p class="text-white text-sm font-bold">{{ $article->song->bpm ?? '--' }} BPM</p>
                </div>
            </div>
        </div>
    </section>

    <!-- MAIN CONTENT GRID -->
    <div class="max-w-[1400px] mx-auto px-8 py-16 relative z-20">
        <div class="flex flex-col lg:flex-row gap-16">
            
            <!-- Left Column -->
            <div class="flex-1 space-y-24">
                
                <!-- About the Track -->
                <section>
                    <div class="flex items-center gap-6 mb-10">
                        <h2 class="section-title">Overview</h2>
                        <div class="flex-1 h-px bg-white/5"></div>
                    </div>
                    
                    <!-- Intro Highlight -->
                    <div class="bg-[#161b22]/40 border border-white/5 rounded-[20px] p-8 mb-8">
                        <h3 class="text-white text-lg font-black uppercase tracking-tighter mb-4">{{ strtoupper($article->song->album ?? 'Featured Release') }}</h3>
                        <p class="text-white/70 text-base leading-relaxed">
                            {!! nl2br(e(Str::limit($summary, 300))) !!}
                        </p>
                    </div>
                    
                    <div class="article-content prose prose-invert prose-lg max-w-none">
                        <div class="text-white/60 text-sm leading-relaxed">
                            {!! Str::markdown($article->content) !!}
                        </div>
                    </div>
                </section>

                <!-- Lyrics Section -->
                @if($article->song && $article->song->lyrics)
                <section>
                    <div class="flex items-center justify-between mb-10">
                        <h2 class="section-title">Lyrics</h2>
                        <button class="text-xs font-semibold text-white/50 uppercase tracking-widest hover:text-white transition-colors">Copy to Clipboard</button>
                    </div>
                    <div class="bg-[#161b22]/40 border border-white/5 rounded-[20px] p-12 lg:p-16 font-mono text-base leading-loose text-white/80 shadow-xl relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-10 opacity-5 group-hover:opacity-10 transition-opacity">
                            <svg class="w-32 h-32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                        </div>
                        <div class="relative z-10 selection:bg-[#38bdf8]/30">
                            {!! nl2br(e($article->song->lyrics)) !!}
                        </div>
                    </div>
                </section>
                @endif
                
                <!-- Discussion -->
                 <section class="pt-16 border-t border-white/5">
                    <livewire:article.comments :article="$article" />
                </section>
            </div>

            <!-- Right Column Sidebar -->
            <div class="w-full lg:w-80 space-y-10">
                
                <!-- Metadata Card -->
                <div class="bg-[#161b22]/40 border border-white/5 p-8 rounded-[20px] hover:border-white/10 transition-all">
                    <h3 class="text-lg font-black text-white uppercase tracking-tighter mb-6">Metadata</h3>
                    
                    <dl class="space-y-6">
                        <div class="flex justify-between items-end pb-3 border-b border-white/5">
                            <dt class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Album</dt>
                            <dd class="text-xs text-white font-bold text-right">{{ $article->song->album ?? 'Single' }}</dd>
                        </div>
                        <div class="flex justify-between items-end pb-3 border-b border-white/5">
                            <dt class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Released</dt>
                            <dd class="text-xs text-white font-bold">{{ $article->song->release_date ?? 'N/A' }}</dd>
                        </div>
                         <div class="flex justify-between items-end pb-3 border-b border-white/5">
                            <dt class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Genre</dt>
                            <dd class="text-xs text-blue-400 font-bold uppercase tracking-widest">{{ $article->genre ? $article->genre->name : 'General' }}</dd>
                        </div>
                    </dl>

                    <div class="mt-12 space-y-3">
                        <livewire:article.play-button 
                            :articleId="$article->id" 
                            label="Play Sonic Pulse"
                            class="w-full btn-figma-primary"
                        />
                        
                        <x-article.⚡add-to-crate :article="$article" />

                        <div class="flex items-center justify-between p-4 bg-white/[0.02] border border-white/5 rounded-2xl">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Protocol Score</span>
                             <livewire:article.vote-button :model="$article" wire:key="sidebar-vote-article-{{ $article->id }}" />
                        </div>
                        <a href="{{ route('wiki.edit', $article->slug) }}" class="btn-figma-secondary w-full flex items-center justify-center gap-2">
                            Modify Archive
                        </a>
                    </div>
                </div>

                <!-- Contributor / Author -->
                <div class="bg-[#161b22]/40 border border-white/5 rounded-[20px] p-6 hover:border-white/10 transition-all">
                    <h3 class="text-xs font-semibold text-white/50 uppercase tracking-[0.2em] mb-4">Created By</h3>
                    
                    <a href="{{ route('profile', $article->user->username) }}" class="flex items-center gap-4 group">
                        <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-white/10 group-hover:border-blue-400/50 transition-colors">
                            @if($article->user->avatar)
                                <img src="{{ $article->user->avatar }}" alt="{{ $article->user->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-blue-400/10 flex items-center justify-center text-blue-400 font-black text-sm">
                                    {{ strtoupper(substr($article->user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="text-white font-bold group-hover:text-blue-400 transition-colors">{{ $article->user->name }}</p>
                            <p class="text-white/30 text-xs">{{ '@' . $article->user->username }}</p>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center group-hover:bg-blue-400 group-hover:text-white transition-all text-white/30">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </a>

                    <div class="mt-4 pt-4 border-t border-white/5 flex items-center justify-between text-[10px] text-white/30">
                        <span>Contributor Since {{ $article->user->created_at->format('M Y') }}</span>
                        <span class="text-blue-400">{{ $article->user->reputation_score ?? 0 }} pts</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
