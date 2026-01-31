@extends('layouts.wiki')

@section('title', $article->title . ' — ' . ($article->song->artist->name ?? 'Artist'))

@section('content')
    @php
        $featured_image = $article->featured_image;
        if ($featured_image && !Str::startsWith($featured_image, ['http://', 'https://'])) {
            $featured_image = Storage::url($featured_image);
        }
        $featured_image = $featured_image ?: 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&q=80&w=1200';
    @endphp

    <!-- HERO SECTION -->
    <div class="relative min-h-[60vh] flex items-end pt-32 pb-20 overflow-hidden bg-primary section-divider">
        <!-- Background Layer -->
        <div class="absolute inset-0 z-0">
            <img src="{{ $featured_image }}" class="w-full h-full object-cover grayscale opacity-20 blur-md scale-110">
            <div class="absolute inset-0 bg-gradient-to-t from-primary via-primary/80 to-transparent"></div>
        </div>

        <div class="relative z-10 max-w-[1200px] mx-auto px-8 w-full">
            <div class="flex flex-col lg:flex-row items-end gap-12">
                <!-- Song Cover Node -->
                <div class="relative group">
                    <div class="absolute -inset-4 bg-blue-500/20 blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
                    <div class="w-64 h-64 lg:w-80 lg:h-80 rounded-[2.5rem] overflow-hidden border border-white/10 glass shadow-2xl relative z-10">
                         <img src="{{ $featured_image }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-1000" alt="{{ $article->title }}">
                         <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-500">
                             <div class="w-16 h-16 rounded-full bg-blue-500 text-white flex items-center justify-center hover:scale-110 transition shadow-2xl">
                                 <svg class="w-8 h-8 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                             </div>
                         </div>
                    </div>
                </div>

                <!-- Song Info -->
                <div class="flex-1 pb-4">
                    <div class="flex items-center gap-4 mb-6">
                        <span class="px-3 py-1 bg-blue-500/10 border border-blue-500/20 rounded-lg text-[10px] text-blue-400 font-black uppercase tracking-widest">Master Recording</span>
                    </div>
                    
                    <h1 class="text-6xl lg:text-8xl font-black text-white italic uppercase tracking-tighter mb-8 leading-none">
                        {{ $article->title }}
                    </h1>
                    
                    <div class="flex flex-wrap items-center gap-6 text-white/40 font-bold mb-10">
                        @if($article->song && $article->song->artist)
                             <a href="{{ route('wiki.show', $article->song->artist->article) }}" class="hover:text-white transition flex items-center gap-3">
                                 <span class="text-lg text-white underline underline-offset-8 decoration-blue-500/30">{{ $article->song->artist->name }}</span>
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

    <!-- MAIN CONTENT GRID -->
    <div class="max-w-[1200px] mx-auto px-8 py-20 relative z-20">
        <div class="flex flex-col lg:flex-row gap-16">
            
            <!-- Left Column -->
            <div class="flex-1 space-y-24">
                
                <!-- About the Track -->
                <section>
                    <div class="flex items-center gap-6 mb-12">
                        <h2 class="text-3xl font-black text-white italic uppercase tracking-tighter">About the Track</h2>
                        <div class="flex-1 h-px bg-white/5"></div>
                    </div>
                    <div class="article-content prose prose-invert prose-lg max-w-none">
                        <div class="text-white/60 leading-relaxed font-medium">
                            {!! $article->content !!}
                        </div>
                    </div>
                </section>

                <!-- Lyrics Section -->
                @if($article->song && $article->song->lyrics)
                <section>
                    <div class="flex items-center justify-between mb-12">
                        <h2 class="text-3xl font-black text-white italic uppercase tracking-tighter">Lyrical Content</h2>
                        <button class="text-[10px] font-black text-white/20 uppercase tracking-widest hover:text-white transition-colors">Copy to Clipboard</button>
                    </div>
                    <div class="bg-secondary border border-white/5 rounded-3xl p-12 lg:p-20 font-mono text-xl leading-relaxed text-white/80 shadow-2xl relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-10 opacity-5 group-hover:opacity-10 transition-opacity">
                            <svg class="w-32 h-32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                        </div>
                        <div class="relative z-10 selection:bg-blue-500/30">
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
                <div class="glass p-8 rounded-3xl border border-white/10 bg-secondary">
                    <h3 class="text-xl font-black text-white italic uppercase tracking-tighter mb-8">Metadata</h3>
                    
                    <dl class="space-y-6">
                        <div class="flex justify-between items-end pb-3 border-b border-white/5">
                            <dt class="text-[10px] font-black text-white/30 uppercase tracking-widest">Album</dt>
                            <dd class="text-xs text-white font-bold text-right">{{ $article->song->album ?? 'Single' }}</dd>
                        </div>
                        <div class="flex justify-between items-end pb-3 border-b border-white/5">
                            <dt class="text-[10px] font-black text-white/30 uppercase tracking-widest">Released</dt>
                            <dd class="text-xs text-white font-bold">{{ $article->song->release_date ?? 'N/A' }}</dd>
                        </div>
                         <div class="flex justify-between items-end pb-3 border-b border-white/5">
                            <dt class="text-[10px] font-black text-white/30 uppercase tracking-widest">Genre</dt>
                            <dd class="text-xs text-blue-400 font-bold uppercase tracking-widest">{{ $article->genre ? $article->genre->name : 'General' }}</dd>
                        </div>
                    </dl>

                    <div class="mt-12 space-y-4">
                        <div class="flex items-center justify-between p-4 bg-white/[0.02] border border-white/5 rounded-2xl">
                            <span class="text-[9px] font-black text-white/20 uppercase tracking-widest">Protocol Score</span>
                             <livewire:article.vote-button :model="$article" wire:key="sidebar-vote-article-{{ $article->id }}" />
                        </div>
                        <a href="{{ route('wiki.edit', $article->slug) }}" class="w-full py-4 bg-white text-black rounded-2xl text-[10px] font-black uppercase tracking-widest hover:scale-[1.02] transition-all flex items-center justify-center gap-3 relative overflow-hidden group">
                            <span class="relative z-10">Edit Entry</span>
                            <div class="w-4 h-4 rounded-full bg-blue-500/20 flex items-center justify-center relative z-10">
                                <div class="w-1.5 h-1.5 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.8)]"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Contributors -->
                <div class="space-y-6">
                    <h3 class="text-[10px] font-black text-white/20 uppercase tracking-[0.2em]">Contributors</h3>
                    <div class="flex -space-x-3 overflow-hidden">
                        @for($i = 0; $i < 4; $i++)
                            <div class="inline-block h-10 w-10 rounded-xl ring-4 ring-primary bg-secondary border border-white/10 flex items-center justify-center text-[10px] font-black text-blue-500">
                                {{ chr(65 + $i) }}
                            </div>
                        @endfor
                        <div class="h-10 w-10 rounded-xl ring-4 ring-primary bg-blue-500 flex items-center justify-center text-[8px] font-black text-white">+8</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
