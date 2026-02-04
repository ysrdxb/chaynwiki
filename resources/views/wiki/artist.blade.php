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
        $placeholder = 'https://images.unsplash.com/photo-1514525253344-f856717429fb?auto=format&fit=crop&q=80&w=1200';
        $featured_image = $article->featured_image;
        if ($featured_image && !Str::startsWith($featured_image, ['http://', 'https://'])) {
            $featured_image = Storage::url($featured_image);
        }
        $featured_image = $featured_image ?: $placeholder;
    @endphp

    <!-- HERO SECTION -->
    <div class="relative min-h-[60vh] flex items-end pt-32 pb-20 overflow-hidden bg-primary section-divider">
        <!-- Background Layer -->
        <div class="absolute inset-0 z-0">
            <img src="{{ $featured_image }}" onerror="this.onerror=null;this.src='{{ $placeholder }}';" class="w-full h-full object-cover grayscale opacity-10 blur-md scale-110">
            <div class="absolute inset-0 bg-primary/90"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-primary via-primary/90 to-transparent"></div>
        </div>

        <div class="relative z-10 max-w-[1200px] mx-auto px-8 w-full">
            <div class="flex flex-col lg:flex-row items-end gap-12">
                <!-- Artist Portrait -->
                <div class="relative group">
                    <div class="absolute -inset-4 bg-[#38bdf8]/20 blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
                    <div class="w-64 h-64 lg:w-80 lg:h-80 rounded-[2.5rem] overflow-hidden border border-white/10 glass shadow-2xl relative z-10">
                        <img src="{{ $featured_image }}" onerror="this.onerror=null;this.src='{{ $placeholder }}';" class="w-full h-full object-cover group-hover:scale-110 transition duration-1000" alt="{{ $article->title }}">
                    </div>
                </div>

                <!-- Artist Info -->
                <div class="flex-1 pb-4">
                    <div class="flex items-center gap-4 mb-6">
                        @if(!empty($artistMeta['spotify_id']) || !empty($artistMeta['website']))
                            <span class="px-3 py-1 bg-[#38bdf8]/10 border border-[#38bdf8]/20 rounded-lg text-[10px] text-[#38bdf8] font-black uppercase tracking-widest">Verified Artist</span>
                        @else
                            <span class="px-3 py-1 bg-white/5 border border-white/10 rounded-lg text-[10px] text-white/40 font-black uppercase tracking-widest">Artist Profile</span>
                        @endif
                    </div>
                    
                    <h1 class="text-6xl lg:text-8xl font-black text-white italic uppercase tracking-tighter mb-8">
                        {{ $article->title }}
                    </h1>
                    
                    <div class="flex flex-wrap items-center gap-4 mb-10">
                        <livewire:article.play-button 
                            :articleId="$article->id" 
                            label="Listen Now"
                            class="btn-primary-v2 px-7 py-3.5 flex items-center justify-center gap-3 min-h-[48px]"
                        />
                        <div class="flex items-center gap-3 px-5 py-3 bg-white/5 border border-white/10 rounded-2xl min-h-[48px]">
                             <livewire:article.vote-button :model="$article" wire:key="vote-article-{{ $article->id }}" />
                             <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Protocol Influence</span>
                        </div>
                    </div>

                    <!-- Statistics Strip -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 py-8 border-t border-white/5">
                        <div class="flex flex-col">
                            <span class="text-white text-3xl font-black italic tracking-tight">{{ number_format($artistStats['views'] ?? 0) }}</span>
                            <span class="text-[9px] text-slate-400 font-black uppercase tracking-widest mt-1">Article Views</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-white text-3xl font-black italic tracking-tight">{{ number_format($artistStats['streams'] ?? 0) }}</span>
                            <span class="text-[9px] text-white/30 font-black uppercase tracking-widest mt-1">Total Streams</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-blue-400 text-3xl font-black italic tracking-tight">{{ number_format($artistStats['impact'] ?? 0, 1) }}</span>
                            <span class="text-[9px] text-white/30 font-black uppercase tracking-widest mt-1">Impact Score</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-white text-3xl font-black italic tracking-tight">#{{ number_format($artistStats['rank'] ?? 0) }}</span>
                            <span class="text-[9px] text-white/30 font-black uppercase tracking-widest mt-1">Global Rank</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT GRID -->
    <section class="bg-primary section-divider">
        <div class="max-w-[1200px] mx-auto px-8 py-24 relative z-20">
            <div class="flex flex-col lg:flex-row gap-20">
            
            <!-- Left Column: Primary Content -->
            <div class="flex-1 space-y-28">
                
                <!-- Artist Biography -->
                <section>
                    <div class="flex items-center gap-6 mb-10">
                        <h2 class="text-2xl font-black text-white italic uppercase tracking-tighter">Artist Biography</h2>
                        <div class="flex-1 h-px bg-white/5"></div>
                    </div>
                    <div class="article-content prose prose-invert prose-lg max-w-none">
                        <div class="text-slate-300 leading-relaxed font-medium">
                            @if(!empty($article->content))
                                {!! Str::markdown($article->content) !!}
                            @else
                                <p class="text-white/50 text-sm">This artist profile is still being built. Add a biography to complete the record.</p>
                            @endif
                        </div>
                    </div>
                </section>

                <!-- Photo Gallery -->
                <section>
                    <div class="flex items-center justify-between mb-10">
                        <h2 class="text-2xl font-black text-white italic uppercase tracking-tighter">Visual Archive</h2>
                        <div class="text-xs font-semibold text-white/40 uppercase tracking-widest">From published records</div>
                    </div>
                    
                    @if($artistGallery->isEmpty())
                        <div class="text-white/40 text-sm">No gallery images yet. Add featured images to related songs to populate this archive.</div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach($artistGallery as $item)
                                <div class="relative aspect-[4/5] rounded-3xl overflow-hidden glass border border-white/10 group cursor-pointer shadow-xl">
                                    <img src="{{ $item['image'] }}" onerror="this.onerror=null;this.src='{{ $placeholder }}';" class="w-full h-full object-cover grayscale transition-all duration-700 group-hover:grayscale-0 group-hover:scale-105">
                                    <div class="absolute inset-0 bg-gradient-to-t from-primary/90 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                    <div class="absolute inset-x-0 bottom-0 p-6 transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
                                        <span class="text-white font-black text-[10px] uppercase tracking-widest">{{ $item['title'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </section>

                <!-- Discography -->
                <section>
                    <div class="flex items-center justify-between mb-10">
                        <h2 class="text-2xl font-black text-white italic uppercase tracking-tighter">Discography</h2>
                        <a href="{{ route('wiki.index', ['category' => 'song', 'q' => $article->title]) }}" class="text-xs font-semibold text-[#38bdf8] uppercase tracking-widest hover:text-[#7dd3fc] transition-colors">Browse Songs →</a>
                    </div>
                    @if($artistDiscography->isEmpty())
                        <div class="text-white/40 text-sm">No discography entries yet. Add songs to this artist to populate the archive.</div>
                    @else
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach($artistDiscography as $item)
                                 <a href="{{ $item['url'] }}" class="group">
                                    <div class="aspect-square rounded-2xl overflow-hidden bg-white/5 border border-white/10 mb-5 relative group">
                                        <img src="{{ $item['image'] }}" onerror="this.onerror=null;this.src='{{ $placeholder }}';" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                                        <div class="absolute inset-0 bg-[#38bdf8]/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    </div>
                                    <h4 class="text-white font-bold truncate group-hover:text-[#38bdf8] transition-colors uppercase tracking-tight text-sm">{{ $item['title'] }}</h4>
                                    <p class="text-xs font-semibold text-white/40 uppercase tracking-widest">{{ $item['year'] ?? 'Unknown' }}</p>
                                 </a>
                            @endforeach
                        </div>
                    @endif
                </section>

                <!-- Community Discussion -->
                <section class="pt-16 border-t border-white/5">
                    <livewire:article.comments :article="$article" />
                </section>
            </div>

            <!-- Right Column: Sidebar -->
            <div class="w-full lg:w-80 space-y-12">
                <!-- Artist Metadata -->
                <div class="bg-secondary border border-white/5 p-10 rounded-3xl group">
                    <h3 class="text-lg font-black text-white italic uppercase tracking-tighter mb-6">Metadata</h3>
                     @if(empty(array_filter($artistMeta ?? [])))
                        <div class="text-white/40 text-sm">No metadata available yet.</div>
                     @else
                        <dl class="space-y-6">
                            @if(!empty($artistMeta['origin']))
                                <div class="flex justify-between items-end pb-3 border-b border-white/5">
                                    <dt class="text-xs font-semibold text-white/50 uppercase tracking-widest">Origin</dt>
                                    <dd class="text-xs text-white font-bold">{{ $artistMeta['origin'] }}</dd>
                                </div>
                            @endif
                            @if(!empty($artistMeta['active_from']))
                                <div class="flex justify-between items-end pb-3 border-b border-white/5">
                                    <dt class="text-xs font-semibold text-white/50 uppercase tracking-widest">Active From</dt>
                                    <dd class="text-xs text-white font-bold">{{ $artistMeta['active_from'] }}</dd>
                                </div>
                            @endif
                            @if(!empty($artistMeta['active_to']))
                                <div class="flex justify-between items-end pb-3 border-b border-white/5">
                                    <dt class="text-xs font-semibold text-white/50 uppercase tracking-widest">Active To</dt>
                                    <dd class="text-xs text-white font-bold">{{ $artistMeta['active_to'] }}</dd>
                                </div>
                            @endif
                            @if(!empty($artistMeta['website']))
                                <div class="flex justify-between items-end pb-3 border-b border-white/5">
                                    <dt class="text-xs font-semibold text-white/50 uppercase tracking-widest">Website</dt>
                                    <dd class="text-xs text-[#38bdf8] font-bold">
                                        <a href="{{ $artistMeta['website'] }}" target="_blank" rel="noopener">Visit</a>
                                    </dd>
                                </div>
                            @endif
                        </dl>
                     @endif
                    
                    <div class="mt-14 space-y-4">
                        <livewire:article.play-button 
                            :articleId="$article->id" 
                            label="Sync Sonic DNA"
                            class="w-full py-3.5 bg-[#38bdf8] text-[#0a0e14] rounded-2xl text-[11px] font-semibold uppercase tracking-[0.2em] hover:scale-[1.02] transition-all flex items-center justify-center gap-3 relative overflow-hidden group shadow-xl shadow-[#38bdf8]/20"
                        />

                        <x-article.⚡add-to-crate :article="$article" />

                        <div class="flex items-center justify-between p-4 bg-white/[0.02] border border-white/5 rounded-2xl">
                            <span class="text-[10px] font-semibold text-white/40 uppercase tracking-widest">Archive Utility</span>
                             <livewire:article.vote-button :model="$article" wire:key="sidebar-vote-article-{{ $article->id }}" />
                        </div>
                        @auth
                            <a href="{{ route('wiki.edit', $article->slug) }}" class="w-full py-3.5 border border-white/10 text-white/60 rounded-xl text-[10px] font-semibold uppercase tracking-widest hover:text-white hover:border-white/20 transition-all flex items-center justify-center gap-2">
                                Suggest Revision
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Related Connectivity -->
                <div class="space-y-8">
                    <h3 class="text-xs font-semibold text-white/50 uppercase tracking-[0.2em]">Network Proximity</h3>
                    <div class="space-y-6">
                        @forelse($relatedSongs as $song)
                            @if($song->article)
                                <a href="{{ route('wiki.show', $song->article->slug) }}" class="flex items-center gap-4 group">
                                    <div class="w-14 h-14 rounded-xl bg-white/5 border border-white/5 flex items-center justify-center text-white/20 group-hover:text-[#38bdf8] group-hover:border-[#38bdf8]/30 transition-all overflow-hidden">
                                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-sm font-bold text-white group-hover:text-[#38bdf8] transition-colors truncate uppercase tracking-tight">{{ $song->title }}</div>
                                        <div class="text-xs font-semibold text-white/40 uppercase tracking-widest mt-1">Record Node</div>
                                    </div>
                                </a>
                            @endif
                        @empty
                            <div class="text-white/40 text-sm">No related songs yet.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
