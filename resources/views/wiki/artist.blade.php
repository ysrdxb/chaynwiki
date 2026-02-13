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
        'label' => ['label' => 'Labels', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>'],
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
@include('wiki._sidebar')

        <!-- Main Content -->
        <main class="flex-1 min-w-0">
             <!-- Top Action Row -->
             <div class="flex justify-between items-center mb-8">
                 <!-- Breadcrumbs -->
                 <nav class="flex items-center gap-2 text-[10px] font-bold text-white/30 tracking-[0.2em]">
                    <a href="{{ route('wiki.index', ['category' => 'artist']) }}" class="hover:text-blue-400 transition-colors">Artists</a>
                    <span>/</span>
                    <span class="text-white">{{ Str::limit($article->title, 30) }}</span>
                </nav>

                <div class="flex items-center gap-4">
                    <a href="{{ route('wiki.edit', $article) }}" class="text-xs font-bold text-white/50 hover:text-white tracking-wider transition-colors">Edit</a>
                </div>
            </div>

            @php
                // Dynamic Data Fetching
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

                $realDiscography = $article->artist ? $article->artist->songs()
                    ->with('article')
                    ->latest('release_date')
                    ->take(8)
                    ->get() : collect();

                $origin = $article->artist->origin ?? 'Unknown Origin';
                $activeSince = $article->artist->active_from ? $article->artist->active_from->format('Y') : 'Unknown';
                $born = $article->artist->born ?? 'Unknown'; 
                $genres = $article->artist->genres ?? ['Music']; // Assuming cast to array or simple string
                if (is_string($genres)) $genres = explode(',', $genres);
            @endphp

            <div class="relative w-full mb-16">
                 <!-- Text Content -->
                 <div class="relative z-10 w-full mb-12">
                     <!-- Title -->
                     <h1 class="text-soundbook-heading text-6xl sm:text-7xl md:text-8xl lg:text-[120px] text-white leading-[0.85] tracking-tighter mb-6 break-words">
                         {{ strtoupper($article->title) }}
                     </h1>
                     
                     <!-- Meta Data Row -->
                     <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-[13px] font-bold text-white/50 tracking-wide mb-8">
                         <span>Origin: <span class="text-white">{{ $origin }}</span></span>
                         <span class="w-1 h-1 rounded-full bg-white/20"></span>
                         <span>Active Since: <span class="text-white">{{ $activeSince }}</span></span>
                         <span class="w-1 h-1 rounded-full bg-white/20"></span>
                          <span>Genres: 
                            <span class="text-white">
                                @foreach(collect($genres)->take(3) as $g)
                                    {{ $g }}@if(!$loop->last) • @endif
                                @endforeach
                            </span>
                          </span>
                     </div>

                     <!-- Bio Excerpt -->
                     <div class="max-w-4xl text-lg text-white/70 leading-relaxed mb-10 font-medium font-sans">
                          {{ Str::limit(strip_tags((string) $article->content), 350, '...') }}
                          <a href="#biography" class="text-white underline decoration-white/30 hover:decoration-white transition-all cursor-pointer ml-2">Read Full Bio</a>
                     </div>

                     <!-- Author & Actions Row -->
                     <div class="flex flex-wrap items-center gap-6 border-b border-white/5 pb-10 mb-8">
                          <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-full px-2 py-2 pr-6 backdrop-blur-md">
                             @if($article->user)
                                 <img src="{{ $article->user->avatar ?? 'https://ui-avatars.com/api/?name='.$article->user->name }}" class="w-8 h-8 rounded-full border border-blue-500/50">
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

                         @if($article->user)
                         <a href="{{ route('profile', $article->user->username ?? 'admin') }}" class="flex items-center gap-2 px-6 py-2.5 rounded-full border border-white/20 hover:border-white hover:bg-white hover:text-[#0d1117] text-[10px] font-black text-white uppercase tracking-widest transition-all">
                             <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                             <span>View Author Profile</span>
                         </a>
                         @endif
                          <a href="#history" class="flex items-center gap-2 px-6 py-2.5 rounded-full border border-white/20 hover:border-white hover:bg-white hover:text-[#0d1117] text-[10px] font-black text-white uppercase tracking-widest transition-all">
                             <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                             <span>View Edit History</span>
                         </a>
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

            <!-- Artist History -->
            <div id="history" class="mb-16">
                <h2 class="text-[11px] font-black text-white/30 uppercase tracking-[0.3em] mb-8">Release History</h2>
                <livewire:wiki.⚡timeline :entity="$artist" />


            <div class="space-y-24">
                {{-- Content Column --}}
                <div class="space-y-24">
                     <section id="biography">
                         <div class="flex items-center border-b border-white/5 pb-8 mb-12">
                            <div class="w-1.5 h-16 bg-blue-500 rounded-full mr-8 shadow-[0_0_20px_rgba(59,130,246,0.5)]"></div>
                            <h2 class="text-5xl lg:text-7xl font-black text-white tracking-tighter uppercase leading-[0.9]">Biography</h2>
                        </div>
                        <article class="prose prose-invert prose-lg max-w-none">
                            <div class="article-content text-white/70 text-base leading-relaxed">
                                {!! Str::markdown($article->content ?? 'No biography available.') !!}
                            </div>
                        </article>
                     </section>

                     {{-- Actions & Meta --}}
                     <section class="border-t border-white/5 pt-16">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                             <div class="card-premium-unified !bg-[#161b22]/40 !p-10 space-y-8">
                                <div class="flex items-center gap-6">
                                    <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-blue-400">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-[11px] font-bold text-white/40 tracking-widest uppercase">Actions</h3>
                                        <p class="text-sm text-white/70 leading-relaxed mt-1">Listen to top tracks or manage this artist in your personal archive.</p>
                                    </div>
                                </div>
                                <div class="space-y-6 pt-6 border-t border-white/5">
                                    <livewire:article.play-button :articleId="$article->id" label="Play tracks" class="btn-figma-primary !w-full !py-4" />
                                    <div class="flex gap-4">
                                        <div class="flex-1"><livewire:article.add-to-collection :article="$article" /></div>
                                        <div class="flex-1"><livewire:article.bookmark-button :article="$article" /></div>
                                    </div>
                                </div>
                             </div>

                             <div class="card-premium-unified !bg-[#161b22]/60 !p-10">
                                <h3 class="text-[11px] font-bold text-white/40 tracking-widest uppercase mb-8">Artist Details</h3>
                                <div class="space-y-6">
                                     <div class="flex items-center justify-between py-3 border-b border-white/5">
                                         <span class="text-sm text-white/50">Origin</span>
                                         <span class="text-sm text-white font-bold">{{ $origin }}</span>
                                     </div>
                                     <div class="flex items-center justify-between py-3 border-b border-white/5">
                                         <span class="text-sm text-white/50">Active Since</span>
                                         <span class="text-sm text-white font-bold">{{ $activeSince }}</span>
                                     </div>
                                    <div class="pt-4">
                                        <div class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/5">
                                            <span class="text-[11px] font-bold text-white/30 tracking-widest uppercase">Popularity</span>
                                            <livewire:article.vote-button :model="$article" wire:key="artist-vote-{{ $article->id }}" />
                                        </div>
                                    </div>
                                </div>
                             </div>
                        </div>
                     </section>

                     <section>
                        <div class="flex items-center justify-between mb-12">
                             <div>
                                 <h2 class="text-soundbook-heading text-6xl text-white uppercase tracking-tighter mb-2">ALBUMS</h2>
                                 <p class="text-[13px] font-bold text-white/40 tracking-widest uppercase">All Releases</p>
                             </div>
                             
                             <div class="flex items-center gap-4">
                                 <a href="{{ route('wiki.index', ['category' => 'song', 'q' => $article->title]) }}" class="text-[11px] font-bold text-white/60 hover:text-white transition-colors uppercase tracking-widest mr-4 hidden md:block">View All</a>
                             </div>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                            @foreach($realDiscography as $song)
                                 <a href="{{ route('wiki.show', $song->article) }}" class="card-premium-unified group block !p-4 border border-white/5 hover:border-emerald-500/30 transition-all shadow-2xl">
                                    <div class="aspect-square rounded-2xl overflow-hidden bg-black/40 mb-5 relative">
                                        <img src="{{ $song->article->featured_image ?? $placeholder }}" class="w-full h-full object-cover transition duration-1000 group-hover:scale-110">
                                        <div class="absolute inset-0 bg-emerald-500/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                             <div class="w-12 h-12 rounded-full bg-white text-navy-900 flex items-center justify-center scale-90 opacity-0 group-hover:scale-100 group-hover:opacity-100 transition-all duration-500 shadow-2xl">
                                                 <svg class="w-5 h-5 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                             </div>
                                        </div>
                                    </div>
                                    <h4 class="text-white font-black text-sm truncate tracking-tight group-hover:text-emerald-400 transition-colors uppercase leading-tight mb-2">{{ $song->title }}</h4>
                                    <p class="text-[10px] font-black text-white/20 tracking-[0.2em]">{{ $song->release_date ? $song->release_date->format('Y') : 'Unknown' }}</p>
                                 </a>
                            @endforeach
                            @if($realDiscography->isEmpty())
                                <div class="col-span-full py-12 text-center text-white/30 text-sm font-bold tracking-widest uppercase">
                                    No releases found in database.
                                </div>
                            @endif
                        </div>
                     </section>
                </div>

                <section>
                     <div class="mb-12">
                         <h2 class="text-soundbook-heading text-6xl text-white uppercase tracking-tighter mb-2">TOP SONGS</h2>
                         <p class="text-[13px] font-bold text-white/40 tracking-widest uppercase">Popular Songs by {{ $article->title }}</p>
                     </div>

                     <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                         @foreach($article->artist->songs->take(3) as $song)
                             <a href="{{ $song->article ? route('wiki.show', $song->article) : '#' }}" class="group relative aspect-[4/5] rounded-[2.5rem] overflow-hidden border border-white/5 bg-[#161b22] shadow-2xl transition-all duration-500 hover:border-blue-500/20 hover:-translate-y-2 cursor-pointer block">
                                 <!-- Background Image -->
                                 <img src="{{ $song->article->featured_image ?? $placeholder }}" class="absolute inset-0 w-full h-full object-cover grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-700">
                                 <div class="absolute inset-0 bg-gradient-to-t from-[#0d1117] via-[#0d1117]/40 to-transparent opacity-90 group-hover:opacity-80 transition-opacity"></div>
                                 
                                 <!-- Content -->
                                 <div class="absolute inset-0 p-8 flex flex-col justify-between z-10">
                                     <!-- Badge -->
                                     <div class="self-start">
                                         @if($song->genre)
                                         <span class="px-3 py-1.5 bg-blue-600 text-white rounded-full text-[10px] font-black tracking-widest shadow-lg uppercase">
                                             {{ $song->genre->name }}
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
                         @if($article->artist->songs->isEmpty())
                            <div class="col-span-full py-12 text-center text-white/30 text-sm font-bold tracking-widest uppercase">
                                No songs linked to this artist yet.
                            </div>
                         @endif
                     </div>
                </section>


                 <section class="border-t border-white/5 pt-16">
                    <div class="flex items-center border-b border-white/5 pb-6 mb-10">
                        <div class="w-1.5 h-10 bg-purple-500 rounded-full mr-6 shadow-[0_0_15px_rgba(168,85,247,0.5)]"></div>
                        <h2 class="text-3xl font-black text-white tracking-tighter">Related Content</h2>
                    </div>
                    <x-neural-map-visualization :articleId="$article->id" />
                </section>

                 <section class="border-t border-white/5 pt-16">
                    <div class="flex items-center border-b border-white/5 pb-6 mb-10">
                        <div class="w-1.5 h-10 bg-blue-500 rounded-full mr-6 shadow-[0_0_15px_rgba(59,130,246,0.5)]"></div>
                        <h2 class="text-3xl font-black text-white tracking-tighter">Discussion</h2>
                    </div>
                    <livewire:article.comments :article="$article" />
                </section>
            </div>

        </main>
    </div>
</div>
@endsection
