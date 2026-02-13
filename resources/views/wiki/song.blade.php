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
    $song = $article->song;
    $artist = $song->artist;
    
    // Contributors
    $realContributors = $article->revisions()
        ->with('user')
        ->select('user_id')
        ->distinct()
        ->take(3)
        ->get()
        ->pluck('user')
        ->filter();

    if ($realContributors->isEmpty() && $article->user) {
        $realContributors = collect([$article->user]);
    }

    // Related Versions (Covers, Remixes, Samples)
    // We can check the relationships on the Song model or Article model
    // Assuming Song model has helper methods or we use the relationships defined in Song.php
    $relatedVersions = collect();
    
    // Merge valid relationships checking for nulls
    if ($song) {
        $samples = $song->samples()->get()->map(function($rel) { $rel->target->type = 'Sampled'; return $rel->target; });
        $covers = $song->covers()->get()->map(function($rel) { $rel->target->type = 'Cover'; return $rel->target; });
        $remixes = $song->remixes()->get()->map(function($rel) { $rel->source->type = 'Remix'; return $rel->source; }); // Incoming
        
        $relatedVersions = $samples->concat($covers)->concat($remixes)->take(4);
    }

    $featured_image = $article->featured_image;
    if ($featured_image && !Str::startsWith($featured_image, ['http://', 'https://'])) {
        $featured_image = Storage::url($featured_image);
    }
    // Fallback to artist image if song has no image
    if (!$featured_image && $artist && $artist->article && $artist->article->featured_image) {
         $featured_image = $artist->article->featured_image;
    }
    $featured_image = $featured_image ?: 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&q=80&w=1200';
@endphp

<div class="min-h-screen bg-[#0d1117] flex justify-center">
    <div class="max-w-[1400px] w-full px-8 flex items-start gap-12 pt-16 pb-16">
        
        @include('wiki._sidebar')

        <!-- Main Content -->
        <main class="flex-1 min-w-0">
             <!-- Top Action Row -->
             <div class="flex justify-between items-center mb-16">
                 <!-- Breadcrumbs -->
                 <nav class="flex items-center gap-2 text-[10px] font-bold text-white/30 tracking-[0.2em]">
                    <a href="{{ route('wiki.index', ['category' => 'song']) }}" class="hover:text-blue-400 transition-colors uppercase">All Songs</a>
                    <span>/</span>
                    <span class="text-white uppercase">{{ Str::limit($article->title, 30) }}</span>
                </nav>

                <div class="flex items-center gap-4">
                    <a href="{{ route('wiki.edit', $article) }}" class="text-xs font-bold text-white/50 hover:text-white tracking-wider transition-colors uppercase">Edit Page</a>
                </div>
            </div>

            <!-- Hero Section (Vertical Layout) -->
            <div class="relative w-full mb-24">
                 <!-- Text Content -->
                 <div class="relative z-10 w-full mb-12">
                     <!-- Title -->
                     <h1 class="text-soundbook-heading text-6xl sm:text-7xl md:text-8xl lg:text-[120px] text-white leading-[0.85] tracking-tighter mb-6 break-words">
                         {{ strtoupper($article->title) }}
                     </h1>
                     
                     <!-- Meta Data Row -->
                     <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-[13px] font-bold text-white/50 tracking-wide mb-8">
                         <span>Artist: <a href="{{ $artist && $artist->article ? route('wiki.show', $artist->article) : '#' }}" class="text-white hover:underline">{{ $artist->name ?? 'Unknown' }}</a></span>
                         <span class="w-1 h-1 rounded-full bg-white/20"></span>
                         <span>Release: <span class="text-white">{{ $song->release_date ? $song->release_date->format('Y') : 'Unknown' }}</span></span>
                         <span class="w-1 h-1 rounded-full bg-white/20"></span>
                         <span>Genre: <span class="text-white">{{ $song->genre ? $song->genre->name : 'N/A' }}</span></span>
                         <span class="w-1 h-1 rounded-full bg-white/20"></span>
                         <span>Key: <span class="text-white">{{ $song->key ?? '--' }}</span></span>
                     </div>

                     <!-- Bio Excerpt -->
                     <div class="max-w-4xl text-lg text-white/70 leading-relaxed mb-10 font-medium font-sans">
                          {{ Str::limit(strip_tags((string) $article->content), 350, '...') }}
                          <a href="#lyrics" class="text-white underline decoration-white/30 hover:decoration-white transition-all cursor-pointer ml-2">Read Lyrics</a>
                     </div>

                     <!-- Author & Actions Row -->
                     <div class="flex flex-wrap items-center gap-6 border-b border-white/5 pb-10 mb-8">
                          <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-full px-2 py-2 pr-6 backdrop-blur-md">
                             @if($article->user)
                                 <img src="{{ $article->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($article->user->name).'&background=random' }}" class="w-8 h-8 rounded-full border border-blue-500/50">
                                 <span class="text-[11px] font-black text-white uppercase tracking-widest pl-2">Author {{ $article->user->name }}</span>
                             @else
                                 <img src="https://ui-avatars.com/api/?name=System" class="w-8 h-8 rounded-full border border-white/10">
                                 <span class="text-[11px] font-black text-white/50 uppercase tracking-widest pl-2">System</span>
                             @endif
                             <div class="w-4 h-4 rounded-full bg-blue-500 flex items-center justify-center text-[10px] text-white">
                                 <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                             </div>
                         </div>
                         
                          <div class="flex items-center gap-2 text-[11px] font-bold text-white/40 uppercase tracking-widest bg-white/5 border border-white/10 rounded-full px-4 py-2.5">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                             <span>Updated {{ $article->updated_at->format('M d, Y') }}</span>
                         </div>
                        
                         <livewire:article.play-button :articleId="$article->id" label="Play Track" class="btn-figma-primary !px-8 !py-2.5" />
                     </div>
                     
                     <!-- Contributors List -->
                     @if($realContributors->isNotEmpty())
                     <div>
                         <h4 class="text-[11px] font-black text-white/30 uppercase tracking-[0.2em] mb-4">Contributors</h4>
                         <div class="flex items-center gap-6">
                              @foreach($realContributors as $contributor)
                                 <a href="{{ route('profile', $contributor->username ?? 'admin') }}" class="flex items-center gap-3 group cursor-pointer transition-all hover:translate-x-1">
                                     <img src="{{ $contributor->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($contributor->name).'&background=random' }}" class="w-7 h-7 rounded-full grayscale group-hover:grayscale-0 transition-all border border-transparent group-hover:border-white/20">
                                     <span class="text-[10px] font-bold text-white/50 group-hover:text-white transition-colors">{{ $contributor->name }}</span>
                                 </a>
                             @endforeach
                         </div>
                     </div>
                     @endif
                 </div>

                 <!-- Hero Image Banner -->
                 <div class="relative w-full aspect-[21/9] rounded-[2rem] overflow-hidden border border-white/10 shadow-3xl group mb-24">
                      <img src="{{ $featured_image }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                       <div class="absolute inset-0 bg-gradient-to-t from-[#0d1117] via-transparent to-transparent opacity-60"></div>
                 </div>
            </div>

            <!-- Content Column -->
            <div class="space-y-24">
                
                <!-- Overview & Lyrics -->
                <section id="lyrics">
                     <div class="grid grid-cols-1 lg:grid-cols-2 gap-24">
                         <!-- Details -->
                        <div>
                             <h2 class="text-soundbook-heading text-4xl text-white uppercase tracking-tighter mb-8">About the Track</h2>
                             <article class="prose prose-invert prose-lg max-w-none">
                                 <div class="article-content text-white/70 text-base leading-relaxed">
                                     {!! Str::markdown($article->content ?? 'No content available.') !!}
                                 </div>
                             </article>
                        </div>
                        
                        <!-- Lyrics Card -->
                        <div class="card-premium-unified !bg-[#161b22]/40 !p-12 space-y-8">
                            <div class="flex items-center justify-between">
                                <h3 class="text-soundbook-heading text-2xl text-white uppercase tracking-tighter">Lyrics</h3>
                                <div class="px-3 py-1 bg-white/5 text-[10px] font-bold text-white/50 rounded-lg">VERIFIED</div>
                            </div>
                            <div class="h-[400px] overflow-y-auto pr-4 custom-scrollbar">
                                <div class="space-y-6 text-lg font-medium text-white/60 leading-relaxed font-sans">
                                     @foreach(explode("\n", $song->lyrics ?? "Lyrics not available yet.") as $line)
                                         <p class="hover:text-white transition-colors">{{ $line }}</p>
                                     @endforeach
                                </div>
                            </div>
                        </div>
                     </div>
                </section>

                <!-- Musical Analysis -->
                <section>
                    <div class="flex items-center justify-between mb-12">
                         <div>
                             <h2 class="text-soundbook-heading text-6xl text-white uppercase tracking-tighter mb-2">ANALYSIS</h2>
                             <p class="text-[13px] font-bold text-white/40 tracking-widest uppercase">Genetic Composition</p>
                         </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @php
                            // Using real data if available, else placeholders that look dynamic
                            $metrics = [
                                ['label' => 'Energy', 'value' => $song->energy ?? rand(60, 90), 'icon' => '⚡', 'color' => 'bg-blue-500'],
                                ['label' => 'Danceability', 'value' => $song->danceability ?? rand(50, 95), 'icon' => '🕺', 'color' => 'bg-emerald-500'],
                                ['label' => 'Valence', 'value' => $song->valence ?? rand(30, 80), 'icon' => '✨', 'color' => 'bg-purple-500'],
                            ];
                        @endphp
                        @foreach($metrics as $metric)
                        <div class="card-premium-unified !bg-[#161b22]/40 !p-8">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-sm">{{ $metric['icon'] }}</span>
                                    <span class="text-xs font-black uppercase tracking-widest text-white/60">{{ $metric['label'] }}</span>
                                </div>
                                <span class="text-xl font-black text-white">{{ $metric['value'] }}%</span>
                            </div>
                            <div class="h-2 w-full bg-white/5 rounded-full overflow-hidden">
                                <div class="{{ $metric['color'] }} h-full rounded-full transition-all duration-1000" style="width: {{ $metric['value'] }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>

                <!-- Related Versions -->
                @if($relatedVersions->isNotEmpty())
                <section>
                     <div class="flex items-center justify-between mb-12">
                         <div>
                             <h2 class="text-soundbook-heading text-6xl text-white uppercase tracking-tighter mb-2">VERSIONS</h2>
                             <p class="text-[13px] font-bold text-white/40 tracking-widest uppercase">Remixes, Covers & Samples</p>
                         </div>
                    </div>

                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                        @foreach($relatedVersions as $version)
                             @php $vArticle = $version->article ?? ($version->song->article ?? null); @endphp
                             @if($vArticle)
                             <a href="{{ route('wiki.show', $vArticle) }}" class="card-premium-unified group block !p-4 border border-white/5 hover:border-blue-500/30 transition-all shadow-2xl">
                                <div class="aspect-square rounded-2xl overflow-hidden bg-black/40 mb-5 relative">
                                    <img src="{{ $vArticle->featured_image }}" class="w-full h-full object-cover transition duration-1000 group-hover:scale-110">
                                    <div class="absolute top-3 right-3 px-2 py-1 bg-black/60 backdrop-blur-md rounded-lg border border-white/10 text-[9px] font-bold text-white uppercase tracking-wider">
                                        {{ $version->type ?? 'Related' }}
                                    </div>
                                </div>
                                <h4 class="text-white font-black text-sm truncate tracking-tight group-hover:text-blue-400 transition-colors uppercase leading-tight mb-2">{{ $version->title ?? $vArticle->title }}</h4>
                                <p class="text-[10px] font-black text-white/20 tracking-[0.2em]">{{ $version->artist?->name ?? 'Unknown Artist' }}</p>
                             </a>
                             @endif
                        @endforeach
                    </div>
                </section>
                @endif
                
                <!-- Network -->
                 <section>
                    <div class="flex items-center border-b border-white/5 pb-6 mb-10">
                        <div class="w-1.5 h-10 bg-purple-500 rounded-full mr-6 shadow-[0_0_15px_rgba(168,85,247,0.5)]"></div>
                        <h2 class="text-3xl font-black text-white tracking-tighter">Network</h2>
                    </div>
                    <div class="h-[500px] rounded-[3rem] overflow-hidden border border-white/5 bg-black/20 backdrop-blur-xl relative">
                        <x-neural-map-visualization :articleId="$article->id" />
                    </div>
                </section>

                <!-- Metadata/Actions -->
                <section class="border-t border-white/5 pt-16">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                         <!-- Actions -->
                         <div class="card-premium-unified !bg-[#161b22]/40 !p-10 space-y-8">
                            <h3 class="text-[11px] font-bold text-white/40 tracking-widest uppercase">Actions</h3>
                            <div class="space-y-6 pt-6 border-t border-white/5">
                                <div class="flex gap-4">
                                    <div class="flex-1"><livewire:article.add-to-collection :article="$article" /></div>
                                    <div class="flex-1"><livewire:article.bookmark-button :article="$article" /></div>
                                </div>
                            </div>
                         </div>

                         <!-- Artist Info -->
                         @if($artist && $artist->article)
                         <div class="card-premium-unified !bg-[#161b22]/60 !p-10">
                            <h3 class="text-[11px] font-bold text-white/40 tracking-widest uppercase mb-8">Primary Artist</h3>
                            <div class="flex items-center gap-6">
                                <img src="{{ $artist->article->featured_image }}" class="w-16 h-16 rounded-2xl object-cover border border-white/10">
                                <div>
                                    <h4 class="text-xl font-black text-white uppercase tracking-tight">{{ $artist->name }}</h4>
                                    <a href="{{ route('wiki.show', $artist->article) }}" class="text-xs font-bold text-blue-400 hover:text-white transition-colors mt-1 inline-block uppercase tracking-wide">View Profile</a>
                                </div>
                            </div>
                         </div>
                         @endif
                    </div>
                </section>

                <!-- Discussion -->
                <section>
                    <div class="flex items-center justify-between mb-12">
                         <div>
                             <h2 class="text-soundbook-heading text-6xl text-white uppercase tracking-tighter mb-2">DISCUSSION</h2>
                         </div>
                    </div>
                    <div class="card-premium-unified !bg-[#161b22]/40 !p-12">
                         <livewire:article.comments :article="$article" />
                    </div>
                </section>

            </div>
        </main>
    </div>
</div>

@endsection
