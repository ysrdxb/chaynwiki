@extends('layouts.wiki')

@section('title', $article->title)

@section('content')
    @php
        $featured_image = $article->featured_image;
        if ($featured_image && !Str::startsWith($featured_image, ['http://', 'https://'])) {
            $featured_image = Storage::url($featured_image);
        }
        $featured_image = $featured_image ?: 'https://images.unsplash.com/photo-1514525253344-f856717429fb?auto=format&fit=crop&q=80&w=1200';
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
                <!-- Artist Portrait -->
                <div class="relative group">
                    <div class="absolute -inset-4 bg-blue-500/20 blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
                    <div class="w-64 h-64 lg:w-80 lg:h-80 rounded-[2.5rem] overflow-hidden border border-white/10 glass shadow-2xl relative z-10">
                         <img src="{{ $featured_image }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-1000" alt="{{ $article->title }}">
                    </div>
                </div>

                <!-- Artist Info -->
                <div class="flex-1 pb-4">
                    <div class="flex items-center gap-4 mb-6">
                        <span class="px-3 py-1 bg-blue-500/10 border border-blue-500/20 rounded-lg text-[10px] text-blue-400 font-black uppercase tracking-widest">Verified Artist</span>
                    </div>
                    
                    <h1 class="text-6xl lg:text-8xl font-black text-white italic uppercase tracking-tighter mb-8">
                        {{ $article->title }}
                    </h1>
                    
                    <div class="flex flex-wrap items-center gap-6 mb-10">
                        <button class="btn-primary-v2 px-8 py-4">
                            Listen Now
                            <span class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></span>
                        </button>
                        <div class="flex items-center gap-3 px-6 py-2 bg-white/5 border border-white/10 rounded-2xl">
                             <livewire:article.vote-button :model="$article" wire:key="vote-article-{{ $article->id }}" />
                             <span class="text-[10px] font-black uppercase tracking-[0.2em] text-white/20">Protocol Influence</span>
                        </div>
                    </div>

                    <!-- Statistics Strip -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 py-8 border-t border-white/5">
                        <div class="flex flex-col">
                            <span class="text-white text-3xl font-black italic tracking-tight">{{ number_format(rand(10, 50)) }}M</span>
                            <span class="text-[9px] text-white/30 font-black uppercase tracking-widest mt-1">Monthly Reach</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-white text-3xl font-black italic tracking-tight">{{ number_format(rand(100, 999)) }}M</span>
                            <span class="text-[9px] text-white/30 font-black uppercase tracking-widest mt-1">Total Streams</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-blue-400 text-3xl font-black italic tracking-tight">9.8</span>
                            <span class="text-[9px] text-white/30 font-black uppercase tracking-widest mt-1">Impact Score</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-white text-3xl font-black italic tracking-tight">#{{ rand(1, 50) }}</span>
                            <span class="text-[9px] text-white/30 font-black uppercase tracking-widest mt-1">Global Rank</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT GRID -->
    <div class="max-w-[1200px] mx-auto px-8 py-20 relative z-20">
        <div class="flex flex-col lg:flex-row gap-16">
            
            <!-- Left Column: Primary Content -->
            <div class="flex-1 space-y-24">
                
                <!-- Artist Biography -->
                <section>
                    <div class="flex items-center gap-6 mb-12">
                        <h2 class="text-3xl font-black text-white italic uppercase tracking-tighter">Artist Biography</h2>
                        <div class="flex-1 h-px bg-white/5"></div>
                    </div>
                    <div class="article-content prose prose-invert prose-lg max-w-none">
                        <div class="text-white/60 leading-relaxed font-medium">
                            {!! $article->content !!}
                        </div>
                    </div>
                </section>

                <!-- Photo Gallery -->
                <section>
                    <div class="flex items-center justify-between mb-12">
                        <h2 class="text-3xl font-black text-white italic uppercase tracking-tighter">Visual Archive</h2>
                        <div class="flex items-center gap-3">
                             <button class="nav-btn"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></button>
                             <button class="nav-btn"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></button>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @php
                            $gallery = [
                                'Studio Sessions' => 'https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?auto=format&fit=crop&q=80&w=800',
                                'Live Performance' => 'https://images.unsplash.com/photo-1501386761578-eac5c94b800a?auto=format&fit=crop&q=80&w=800',
                                'Behind the Scenes' => 'https://images.unsplash.com/photo-1493225255756-d9584f8606e9?auto=format&fit=crop&q=80&w=800'
                            ];
                        @endphp
                        @foreach($gallery as $name => $url)
                            <div class="relative aspect-[4/5] rounded-3xl overflow-hidden glass border border-white/10 group cursor-pointer shadow-xl">
                                <img src="{{ $url }}" class="w-full h-full object-cover grayscale transition-all duration-700 group-hover:grayscale-0 group-hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-t from-primary/90 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <div class="absolute inset-x-0 bottom-0 p-6 transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
                                    <span class="text-white font-black text-[10px] uppercase tracking-widest">{{ $name }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                <!-- Discography -->
                <section>
                    <div class="flex items-center justify-between mb-12">
                        <h2 class="text-3xl font-black text-white italic uppercase tracking-tighter">Discography</h2>
                        <a href="#" class="text-[11px] font-black text-blue-400 uppercase tracking-widest hover:text-blue-300 transition-colors">See Complete History →</a>
                    </div>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                        @for($i = 2024; $i >= 2021; $i--)
                             <div class="group cursor-pointer">
                                <div class="aspect-square rounded-2xl overflow-hidden bg-white/5 border border-white/10 mb-5 relative group">
                                    <div class="absolute inset-0 bg-blue-500/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    <div class="absolute inset-0 flex items-center justify-center opacity-10 group-hover:opacity-100 transition-all duration-500">
                                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                    </div>
                                </div>
                                <h4 class="text-white font-bold truncate group-hover:text-blue-400 transition-colors uppercase tracking-tight text-sm">Collection Phase {{ $i }}</h4>
                                <p class="text-[10px] font-black text-white/20 uppercase tracking-widest">Master Release // {{ $i }}</p>
                             </div>
                        @endfor
                    </div>
                </section>

                <!-- Community Discussion -->
                <section class="pt-16 border-t border-white/5">
                    <livewire:article.comments :article="$article" />
                </section>
            </div>

            <!-- Right Column: Sidebar -->
            <div class="w-full lg:w-80 space-y-10">
                 <!-- Artist Metadata -->
                <div class="glass p-8 rounded-3xl border border-white/10 group bg-secondary">
                    <h3 class="text-xl font-black text-white italic uppercase tracking-tighter mb-8">Metadata</h3>
                     <dl class="space-y-6">
                        <div class="flex justify-between items-end pb-3 border-b border-white/5">
                            <dt class="text-[10px] font-black text-white/30 uppercase tracking-widest">Origin</dt>
                            <dd class="text-xs text-white font-bold">International</dd>
                        </div>
                        <div class="flex justify-between items-end pb-3 border-b border-white/5">
                            <dt class="text-[10px] font-black text-white/30 uppercase tracking-widest">Active From</dt>
                            <dd class="text-xs text-white font-bold">Archive POS</dd>
                        </div>
                         <div class="flex justify-between items-end pb-3 border-b border-white/5">
                            <dt class="text-[10px] font-black text-white/30 uppercase tracking-widest">Status</dt>
                            <dd class="text-xs text-blue-400 font-bold uppercase tracking-widest">Active Node</dd>
                        </div>
                    </dl>
                    
                    <div class="mt-12 space-y-4">
                        <div class="flex items-center justify-between p-4 bg-white/[0.02] border border-white/5 rounded-2xl">
                            <span class="text-[9px] font-black text-white/20 uppercase tracking-widest">Archive Utility</span>
                             <livewire:article.vote-button :model="$article" wire:key="sidebar-vote-article-{{ $article->id }}" />
                        </div>
                        <a href="{{ route('wiki.edit', $article->slug) }}" class="w-full py-4 bg-white text-black rounded-2xl text-[10px] font-black uppercase tracking-widest hover:scale-[1.02] transition-all flex items-center justify-center gap-3 relative overflow-hidden group">
                            <span class="relative z-10">Suggest Edit</span>
                            <div class="w-4 h-4 rounded-full bg-blue-500/20 flex items-center justify-center relative z-10">
                                <div class="w-1.5 h-1.5 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.8)]"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Related Connectivity -->
                <div class="space-y-8">
                    <h3 class="text-[10px] font-black text-white/20 uppercase tracking-[0.2em]">Network Proximity</h3>
                    <div class="space-y-6">
                        @foreach($article->artist->songs->take(4) as $song)
                            <a href="{{ route('wiki.show', $song->article) }}" class="flex items-center gap-4 group">
                                <div class="w-14 h-14 rounded-xl bg-white/5 border border-white/5 flex items-center justify-center text-white/20 group-hover:text-blue-500 group-hover:border-blue-500/30 transition-all overflow-hidden">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-sm font-bold text-white group-hover:text-blue-400 transition-colors truncate uppercase tracking-tight">{{ $song->title }}</div>
                                    <div class="text-[9px] font-black text-white/20 uppercase tracking-widest mt-1">Record Node</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
