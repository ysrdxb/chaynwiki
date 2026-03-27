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
    // Dynamic Data Fetching
    $genre = $article->genre; // Assuming the relationship exists

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

    // Top Artists (derived from songs in this genre)
    // We limit to 4 artists
    $topArtists = collect();
    if ($genre) {
        $topArtists = $genre->songs()
            ->with(['artist.article'])
            ->latest() // or popular
            ->take(50) // look at last 50 songs to find unique artists
            ->get()
            ->pluck('artist')
            ->unique('id')
            ->take(4);
    }

    // Essential Tracks
    $essentialTracks = collect();
    if ($genre) {
        $essentialTracks = $genre->songs()
            ->with(['article', 'artist'])
            ->latest('created_at')
            ->take(4)
            ->get();
    }

    // Subgenres
    $subgenres = $genre ? $genre->children : collect();
    $parentGenre = $genre ? $genre->parent : null;

    $featured_image = $article->featured_image;
    if ($featured_image && !Str::startsWith($featured_image, ['http://', 'https://'])) {
        $featured_image = Storage::url($featured_image);
    }
    $featured_image = $featured_image ?: 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&q=80&w=1200';

    // Discogs-Style Analytics
    $topLabels = collect();
    $topProducers = collect();
    $yearlyDistribution = collect();
    $maxCount = 1;
    $yearsActive = ['start' => 'N/A', 'end' => 'N/A'];
    
    if ($genre) {
        $topLabels = \App\Models\Song::where('genre_id', $genre->id)
            ->whereNotNull('record_label')
            ->where('record_label', '!=', '')
            ->select('record_label', \DB::raw('count(*) as total'))
            ->groupBy('record_label')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $topProducers = \App\Models\Song::where('genre_id', $genre->id)
            ->whereNotNull('producer')
            ->where('producer', '!=', '')
            ->select('producer', \DB::raw('count(*) as total'))
            ->groupBy('producer')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $minYear = \App\Models\Song::where('genre_id', $genre->id)->min('release_date');
        $maxYear = \App\Models\Song::where('genre_id', $genre->id)->max('release_date');
        
        if ($minYear) $yearsActive['start'] = \Carbon\Carbon::parse($minYear)->format('Y');
        if ($maxYear) $yearsActive['end'] = \Carbon\Carbon::parse($maxYear)->format('Y');

        // Yearly Distribution Graph
        $yearlyDistribution = \App\Models\Song::where('genre_id', $genre->id)
            ->whereNotNull('release_date')
            ->selectRaw('YEAR(release_date) as year, count(*) as count')
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();
            
        $maxCount = $yearlyDistribution->max('count') ?? 1;
    }
@endphp

<div class="min-h-screen bg-[#0d1117] flex justify-center">
    <div class="max-w-[1400px] w-full px-8 flex items-start gap-12 pt-16 pb-16">
        
        <!-- Sidebar Navigation (Consistent with Artist Page) -->
        @include('wiki._sidebar')

        <!-- Main Content -->
        <main class="flex-1 min-w-0">
             <!-- Top Action Row -->
             <div class="flex justify-between items-center mb-16">
                 <!-- Breadcrumbs -->
                 <nav class="flex items-center gap-2 text-[10px] font-bold text-white/30 tracking-[0.2em]">
                    <a href="{{ route('wiki.index', ['category' => 'genre']) }}" class="hover:text-blue-400 transition-colors uppercase">All Genres</a>
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
                         <span>Parent Genre: <span class="text-white">{{ $genre?->parent?->name ?? 'None' }}</span></span>
                         <span class="w-1 h-1 rounded-full bg-white/20"></span>
                         <span>Subgenres: <span class="text-white">{{ $genre?->children()->count() ?? 0 }}</span></span>
                         <span class="w-1 h-1 rounded-full bg-white/20"></span>
                         <span>Tracks: <span class="text-white">{{ $genre?->songs()->count() ?? 0 }}</span></span>
                     </div>

                     <!-- Bio Excerpt -->
                     <div class="max-w-4xl text-lg text-white/70 leading-relaxed mb-10 font-medium font-sans">
                          {{ Str::limit(strip_tags((string) $article->content), 350, '...') }}
                          <a href="#details" class="text-white underline decoration-white/30 hover:decoration-white transition-all cursor-pointer ml-2">Read Full Overview</a>
                     </div>

                     <div class="flex flex-wrap gap-4 mb-10">
                        <a href="{{ route('wiki.index', ['category' => 'song', 'q' => $article->title]) }}" class="px-8 py-3 bg-blue-600 hover:bg-blue-500 text-white text-[11px] font-black uppercase tracking-widest rounded-full transition-all shadow-lg shadow-blue-600/20 flex items-center gap-3 group">
                            <span>Explore {{ $article->title }} Tracks</span>
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        <a href="{{ route('wiki.index', ['category' => 'artist', 'q' => $article->title]) }}" class="px-8 py-3 bg-white/5 hover:bg-white/10 text-white text-[11px] font-black uppercase tracking-widest rounded-full transition-all border border-white/10 group">
                            <span>View Artists</span>
                        </a>
                     </div>

                     <!-- Author & Actions Row -->
                     <div class="flex flex-wrap items-center gap-6 border-b border-white/5 pb-10 mb-8">
                          <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-full px-2 py-2 pr-6 backdrop-blur-md">
                             @if($article->user)
                                 <img src="{{ $article->user->avatar ?? 'https://ui-avatars.com/api/?name='.$article->user->name }}" class="w-8 h-8 rounded-full border border-blue-500/50">
                                 <span class="text-[11px] font-black text-white uppercase tracking-widest pl-2">Added by {{ $article->user->name }}</span>
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

                         @if($article->user)
                         <a href="{{ route('profile', $article->user->username ?? 'admin') }}" class="flex items-center gap-2 px-6 py-2.5 rounded-full border border-white/20 hover:border-white hover:bg-white hover:text-[#0d1117] text-[10px] font-black text-white uppercase tracking-widest transition-all">
                             <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                             <span>View Author Profile</span>
                         </a>
                         @endif
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

                <!-- Genre Analytics (Discogs Style) -->
                <section>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
                        <!-- Years Active -->
                        <div class="bg-[#161b22]/60 border border-white/5 p-8 rounded-[2rem] flex flex-col justify-center group hover:bg-[#1c2128] transition-colors">
                            <h3 class="text-[11px] font-bold text-white/40 tracking-widest uppercase mb-4 group-hover:text-blue-400 transition-colors">Active Era</h3>
                            <div class="text-4xl font-black text-white tracking-tighter">
                                {{ $yearsActive['start'] }} <span class="text-white/20">—</span> {{ $yearsActive['end'] }}
                            </div>
                        </div>

                        <!-- Top Labels -->
                        <div class="bg-[#161b22]/60 border border-white/5 p-8 rounded-[2rem] xl:col-span-2 group hover:bg-[#1c2128] transition-colors">
                            <h3 class="text-[11px] font-bold text-white/40 tracking-widest uppercase mb-4 group-hover:text-blue-400 transition-colors">Key Labels</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($topLabels as $label)
                                    <a href="{{ route('wiki.index', ['q' => $label->record_label]) }}" class="px-4 py-1.5 bg-white/5 border border-white/10 rounded-full text-[12px] font-bold text-white hover:bg-white hover:text-black hover:border-white transition-all">
                                        {{ $label->record_label }} <span class="text-white/30 ml-1 group-hover:text-black/30">({{ $label->total }})</span>
                                    </a>
                                @endforeach
                                @if($topLabels->isEmpty()) <span class="text-white/20 text-xs font-bold uppercase tracking-widest">No label data available</span> @endif
                            </div>
                        </div>

                        <!-- Producers -->
                        <div class="bg-[#161b22]/60 border border-white/5 p-8 rounded-[2rem] group hover:bg-[#1c2128] transition-colors">
                            <h3 class="text-[11px] font-bold text-white/40 tracking-widest uppercase mb-4 group-hover:text-blue-400 transition-colors">Top Producers</h3>
                             <div class="space-y-3">
                                @foreach($topProducers->take(3) as $prod)
                                    <a href="{{ route('wiki.index', ['q' => $prod->producer]) }}" class="flex justify-between items-center text-[13px] font-bold group/prod hover:bg-white/5 p-2 rounded-lg -mx-2 transition-colors">
                                        <span class="text-white group-hover/prod:text-blue-400 transition-colors">{{ $prod->producer }}</span>
                                        <span class="text-white/30 text-[10px] bg-white/5 px-2 py-0.5 rounded">{{ $prod->total }}</span>
                                    </a>
                                @endforeach
                                @if($topProducers->isEmpty()) <span class="text-white/20 text-xs font-bold uppercase tracking-widest">No producer data</span> @endif
                            </div>
                        </div>
                    </div>
                    
                    @if($yearlyDistribution->isNotEmpty())
                    <!-- Yearly Trend Graph -->
                    <div class="bg-[#161b22]/60 border border-white/5 rounded-[2rem] p-8">
                        <h3 class="text-[11px] font-bold text-white/40 tracking-widest uppercase mb-6 flex items-center justify-between">
                            <span>Release History</span>
                            <span class="bg-white/5 px-2 py-1 rounded text-white/30 ml-2">Total Released Tracks: {{ $genre->songs()->whereNotNull('release_date')->count() }}</span>
                        </h3>
                        <div class="flex items-end gap-1 h-[120px] w-full overflow-x-auto pb-2 scrollbar-hide select-none relative">
                             @foreach($yearlyDistribution as $data)
                                @php 
                                    $heightPercent = ($data->count / $maxCount) * 100;
                                    $heightPercent = max($heightPercent, 10); // Minimum visibility 
                                @endphp
                                <div class="flex-1 min-w-[30px] group relative flex flex-col justify-end items-center h-full">
                                    <div class="w-full mx-0.5 bg-blue-500/20 group-hover:bg-blue-500 rounded-t-sm transition-all relative" style="height: {{ $heightPercent }}%;"></div>
                                    <span class="text-[9px] font-black text-white/20 group-hover:text-white mt-2 absolute -bottom-4 transition-colors">{{ $data->year }}</span>
                                    
                                    <!-- Tooltip -->
                                    <div class="absolute bottom-full mb-2 bg-[#0d1117] border border-white/10 px-3 py-1.5 rounded-lg text-xs font-bold text-white shadow-xl opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-20 pointer-events-none">
                                        {{ $data->year }}: {{ $data->count }} Tracks
                                    </div>
                                </div>
                             @endforeach
                        </div>
                    </div>
                    @endif
                </section>
                <section>
                    <div class="flex items-center justify-between mb-12">
                         <div>
                             <h2 class="text-soundbook-heading text-6xl text-white uppercase tracking-tighter mb-2">HISTORY</h2>
                             <p class="text-[13px] font-bold text-white/40 tracking-widest uppercase">Genre Evolution</p>
                         </div>
                    </div>
                    <livewire:wiki.⚡timeline :entity="$genre" />
                </section>

                <!-- Full Biography / Details -->
                <section id="details">
                    <div class="flex items-center border-b border-white/5 pb-8 mb-12">
                       <div class="w-1.5 h-16 bg-blue-500 rounded-full mr-8 shadow-[0_0_20px_rgba(59,130,246,0.5)]"></div>
                       <h2 class="text-5xl lg:text-7xl font-black text-white tracking-tighter uppercase leading-[0.9]">Overview</h2>
                   </div>
                   <article class="prose prose-invert prose-lg max-w-none">
                       <div class="article-content text-white/70 text-base leading-relaxed">
                           {!! Str::markdown($article->content ?? 'No content available.') !!}
                       </div>
                   </article>
                </section>

                <!-- Featured Artists -->
                <section>
                    <div class="flex items-center justify-between mb-12">
                         <div>
                             <h2 class="text-soundbook-heading text-6xl text-white uppercase tracking-tighter mb-2">ARTISTS</h2>
                             <p class="text-[13px] font-bold text-white/40 tracking-widest uppercase">Key Figures in {{ $article->title }}</p>
                         </div>
                    </div>

                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                        @foreach($topArtists as $artist)
                            @if($artist->article)
                             <a href="{{ route('wiki.show', $artist->article) }}" class="card-premium-unified group block !p-4 border border-white/5 hover:border-emerald-500/30 transition-all shadow-2xl">
                                <div class="aspect-square rounded-2xl overflow-hidden bg-black/40 mb-5 relative">
                                    <img src="{{ $artist->article->featured_image }}" class="w-full h-full object-cover transition duration-1000 group-hover:scale-110">
                                    <div class="absolute inset-0 bg-emerald-500/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                         <div class="w-12 h-12 rounded-full bg-white text-navy-900 flex items-center justify-center scale-90 opacity-0 group-hover:scale-100 group-hover:opacity-100 transition-all duration-500 shadow-2xl">
                                             <svg class="w-5 h-5 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                         </div>
                                    </div>
                                </div>
                                <h4 class="text-white font-black text-sm truncate tracking-tight group-hover:text-emerald-400 transition-colors uppercase leading-tight mb-2">{{ $artist->name }}</h4>
                                <p class="text-[10px] font-black text-white/20 tracking-[0.2em]">{{ $artist->songs_count ?? $artist->songs()->count() }} Tracks</p>
                             </a>
                            @endif
                        @endforeach
                        @if($topArtists->isEmpty())
                            <div class="col-span-full py-12 text-center text-white/30 text-sm font-bold tracking-widest uppercase">
                                No artists linked to this genre found.
                            </div>
                        @endif
                    </div>
                </section>

                <!-- Essential Tracks -->
                <section>
                    <div class="flex items-center justify-between mb-12">
                         <div>
                             <h2 class="text-soundbook-heading text-6xl text-white uppercase tracking-tighter mb-2">TRACKS</h2>
                             <p class="text-[13px] font-bold text-white/40 tracking-widest uppercase">Essential {{ $article->title }} Songs</p>
                         </div>
                    </div>

                     <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                         @foreach($essentialTracks as $song)
                             <a href="{{ $song->article ? route('wiki.show', $song->article) : '#' }}" class="group relative aspect-[4/5] rounded-[2.5rem] overflow-hidden border border-white/5 bg-[#161b22] shadow-2xl transition-all duration-500 hover:border-blue-500/20 hover:-translate-y-2 cursor-pointer block">
                                 <!-- Background Image -->
                                 <img src="{{ $song->article->featured_image ?? $placeholder ?? '' }}" class="absolute inset-0 w-full h-full object-cover grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-700">
                                 <div class="absolute inset-0 bg-gradient-to-t from-[#0d1117] via-[#0d1117]/40 to-transparent opacity-90 group-hover:opacity-80 transition-opacity"></div>
                                 
                                 <!-- Content -->
                                 <div class="absolute inset-0 p-8 flex flex-col justify-between z-10">
                                     <!-- Badge -->
                                     <div class="self-start">
                                         @if($song->artist)
                                         <span class="px-3 py-1.5 bg-blue-600 text-white rounded-full text-[10px] font-black tracking-widest shadow-lg uppercase">
                                             {{ $song->artist->name }}
                                         </span>
                                         @endif
                                     </div>

                                     <div class="space-y-1">
                                         <h3 class="text-2xl font-black text-white leading-tight tracking-tight mb-1">{{ $song->title }}</h3>
                                         <p class="text-[11px] font-bold text-white/30 uppercase tracking-widest mb-6">Release: {{ $song->release_date ? $song->release_date->format('Y') : 'Unknown' }}</p>
                                         
                                         <div class="flex items-center justify-between border-t border-white/10 pt-6 group-hover:border-white/30 transition-colors">
                                             <span class="text-[11px] font-black text-white/60 group-hover:text-white transition-colors uppercase tracking-widest flex items-center gap-2">
                                                 View Details
                                             </span>
                                             <div class="w-8 h-8 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-500 group-hover:bg-blue-500 group-hover:text-white transition-all shadow-lg">
                                                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </a>
                         @endforeach
                         @if($essentialTracks->isEmpty())
                            <div class="col-span-full py-12 text-center text-white/30 text-sm font-bold tracking-widest uppercase">
                                No songs linked to this genre found.
                            </div>
                         @endif
                     </div>
                </section>

                <!-- Subgenres & Related -->
                <section class="border-t border-white/5 pt-16">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                         <!-- Actions -->
                         <div class="card-premium-unified !bg-[#161b22]/40 !p-10 space-y-8">
                            <h3 class="text-[11px] font-bold text-white/40 tracking-widest uppercase">Actions</h3>
                            <div class="space-y-6 pt-6 border-t border-white/5">
                                <livewire:article.play-button :articleId="$article->id" label="Play Genre Mix" class="btn-figma-primary !w-full !py-4" />
                                <div class="flex gap-4">
                                    <div class="flex-1"><livewire:article.add-to-collection :article="$article" /></div>
                                    <div class="flex-1"><livewire:article.bookmark-button :article="$article" /></div>
                                </div>
                            </div>
                         </div>

                         <!-- Subgenres List -->
                         <div class="card-premium-unified !bg-[#161b22]/60 !p-10">
                            <h3 class="text-[11px] font-bold text-white/40 tracking-widest uppercase mb-8">Related Styles</h3>
                            <div class="flex flex-wrap gap-4">
                                @foreach($genre?->children ?? collect() as $sub)
                                    <a href="#" class="px-4 py-2 rounded-full border border-white/10 bg-white/5 text-[11px] font-bold text-white hover:bg-white hover:text-black transition-all uppercase tracking-wider">
                                        {{ $sub->name }}
                                    </a>
                                @endforeach
                                @if(!($genre?->children()->exists()))
                                    <span class="text-white/30 text-sm italic">No subgenres defined.</span>
                                @endif
                            </div>
                         </div>
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
                
                <!-- Related Content -->
                 <section>
                    <div class="flex items-center border-b border-white/5 pb-6 mb-10">
                        <div class="w-1.5 h-10 bg-purple-500 rounded-full mr-6 shadow-[0_0_15px_rgba(168,85,247,0.5)]"></div>
                        <h2 class="text-3xl font-black text-white tracking-tighter">Network</h2>
                    </div>
                    <div class="h-[500px] rounded-[3rem] overflow-hidden border border-white/5 bg-black/20 backdrop-blur-xl relative">
                        <x-neural-map-visualization :articleId="$article->id" />
                    </div>
                </section>

            </div>
        </main>
    </div>
</div>
@endsection
