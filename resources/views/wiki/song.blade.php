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
        'label' => ['label' => 'Labels', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>'],
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
                <span class="text-white/20 text-[11px] font-bold text-blue-400 tracking-widest uppercase">Navigation</span>
            </div>
            
            <a href="{{ route('home') }}" class="group flex items-center gap-4 px-4 py-4 rounded-2xl text-[14px] font-bold text-white/50 hover:text-white hover:bg-white/5 transition-all">
                <div class="w-9 h-9 rounded-full bg-blue-500/10 border border-white/10 flex items-center justify-center group-hover:bg-blue-500 group-hover:scale-110 transition-all shadow-lg shadow-blue-500/10">
                    <svg class="w-4 h-4 text-blue-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </div>
                Home
            </a>

            <div class="h-px bg-white/5 mx-4 my-6"></div>
            
            @foreach($categories as $key => $cat)
                <a href="{{ route('wiki.index', ['category' => $key]) }}" class="group flex items-center gap-4 px-4 py-4 rounded-2xl text-[14px] font-bold transition-all {{ $key === 'song' ? 'bg-blue-500/10 text-white border border-blue-500/20 shadow-lg' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
                    <div class="w-9 h-9 rounded-full {{ $key === 'song' ? 'bg-blue-500 shadow-lg shadow-blue-500/20' : 'bg-white/5' }} flex items-center justify-center transition-all group-hover:scale-110">
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
                 <nav class="flex items-center gap-2 text-[11px] font-bold text-white/30 tracking-widest">
                    <a href="{{ route('wiki.index', ['category' => 'song']) }}" class="hover:text-blue-400 transition-colors">Songs</a>
                    <span>/</span>
                    <span class="text-white">{{ Str::limit($article->title, 30) }}</span>
                </nav>

                <div class="flex items-center gap-6">
                    <a href="{{ route('wiki.edit', $article) }}" class="flex items-center gap-2 text-[11px] font-bold text-white/40 hover:text-white tracking-widest transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        Edit Topic
                    </a>
                </div>
            </div>

            <!-- Hero Area -->
            <div class="relative w-full rounded-[32px] overflow-hidden mb-12 border border-white/10 group bg-[#0d1117] shadow-3xl">
                 {{-- Immersive Background --}}
                 <div class="absolute inset-0 z-0">
                     <img src="{{ $featured_image }}" class="w-full h-full object-cover grayscale opacity-10 blur-3xl scale-125 transition-all duration-1000 group-hover:scale-110 group-hover:opacity-20" onerror="this.src='{{ asset('images/hero_background.png') }}'; this.onerror=null;">
                     <div class="absolute inset-0 bg-gradient-to-t from-[#0d1117] via-[#0d1117]/80 to-transparent"></div>
                     <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-blue-500/5 rounded-full blur-[160px] -mr-40 -mt-40"></div>
                 </div>
                 
                 <div class="relative z-10 p-6 md:p-12 lg:p-16 flex flex-col lg:flex-row gap-8 lg:gap-12 items-end">
                     <!-- Cover Art -->
                     <div class="shrink-0 relative group/cover cursor-pointer">
                         <div class="w-48 h-48 md:w-72 md:h-72 rounded-[32px] overflow-hidden border border-white/10 shadow-[0_0_100px_rgba(0,0,0,0.8)] relative z-10 transition-all duration-700 group-hover:border-blue-500/30">
                             <img src="{{ $featured_image }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" onerror="this.src='{{ asset('images/hero_background.png') }}'; this.onerror=null;">
                             <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover/cover:opacity-100 transition-all duration-300">
                                 <div class="w-16 h-16 rounded-full bg-blue-500 text-white flex items-center justify-center shadow-2xl transform scale-90 group-hover/cover:scale-100 transition-all duration-500">
                                     <svg class="w-7 h-7 ml-1.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                 </div>
                             </div>
                         </div>
                         {{-- Glow Accent --}}
                         <div class="absolute -inset-8 bg-blue-500/20 blur-[60px] rounded-full opacity-30 group-hover:opacity-60 transition-all duration-1000"></div>
                     </div>
                     
                     <div class="flex-1 min-w-0 pb-4 text-center lg:text-left">
                        <div class="flex items-center justify-center lg:justify-start gap-3 mb-6 md:mb-8">
                            <span class="px-3 py-1.5 bg-blue-500 text-[#0d1117] rounded-lg text-[10px] font-black tracking-widest shadow-lg shadow-blue-500/20">Track file</span>
                            @if($article->is_master)
                                <span class="px-3 py-1.5 bg-amber-500/20 border border-amber-500/30 text-amber-500 rounded-lg text-[10px] font-black tracking-widest flex items-center gap-1.5 backdrop-blur-md">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    Canonical
                                </span>
                            @endif
                            <div class="px-3 py-1.5 bg-emerald-500/10 border border-emerald-500/20 rounded-lg text-[10px] font-black tracking-widest text-emerald-400 flex items-center gap-2 backdrop-blur-md">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                {{ $article->data_quality }}% Archive
                            </div>
                            @if($article->song->label)
                                <span class="px-3 py-1.5 bg-white/5 border border-white/10 text-white/50 rounded-lg text-[10px] font-bold tracking-widest shadow-lg">{{ $article->song->label }}</span>
                            @endif
                        </div>
                        
                        <h1 class="text-soundbook-heading text-5xl sm:text-7xl md:text-8xl lg:text-[100px] text-white mb-6">
                            {{ strtoupper($article->title) }}
                        </h1>
                        
                        <!-- Contributor Info -->
                        <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 mb-10">
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
                            <button class="bg-blue-600 hover:bg-blue-500 text-white rounded-full px-6 py-2.5 text-[10px] font-black uppercase tracking-widest transition-all">
                                View Author Profile
                            </button>
                        </div>

                        <!-- Song Meta Bar -->
                        <div class="flex flex-wrap items-center justify-center lg:justify-start gap-6 text-[12px] font-bold text-white/40 tracking-wider">
                            <div class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                <span>Key: <span class="text-white">C Minor</span></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                <span>BPM: <span class="text-white">124</span></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                                <span>Mood: <span class="text-white">Energetic</span></span>
                            </div>
                        </div>
                    </div>
                 </div>
            </div>


            {{-- Main Flow Container --}}
            <div class="space-y-24">
                
                {{-- Released As Part Of --}}
                <section>
                    <div class="card-premium-unified !bg-[#161b22]/40 !p-12 lg:p-16 overflow-hidden">
                        <span class="text-[11px] font-black text-white/30 uppercase tracking-[0.3em] mb-4 block">Archive Record</span>
                        <h2 class="text-soundbook-heading text-4xl lg:text-5xl text-white mb-8">Part of the {{ $article->song->album ?? 'Project' }} Collection</h2>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                            <div class="text-white/60 text-lg leading-relaxed font-medium">
                                {{ Str::limit(strip_tags((string) $article->content), 400) }}
                            </div>
                            <div class="relative group">
                                <div class="aspect-video rounded-[2.5rem] overflow-hidden border border-white/10 shadow-3xl">
                                    <img src="{{ $featured_image }}" class="w-full h-full object-cover">
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Analysis & Characteristics --}}
                <section>
                    <div class="flex items-center border-b border-white/5 pb-6 mb-10">
                        <div class="w-1.5 h-10 bg-blue-500 rounded-full mr-6 shadow-[0_0_15px_rgba(59,130,246,0.5)]"></div>
                        <h2 class="text-3xl font-black text-white tracking-tighter uppercase">Musical Analysis</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-16">
                        @php
                            $characteristics = [
                                ['label' => 'Energy', 'value' => 84, 'icon' => '⚡', 'color' => 'bg-blue-500', 'glow' => 'shadow-blue-500/20'],
                                ['label' => 'Danceability', 'value' => 92, 'icon' => '🕺', 'color' => 'bg-emerald-500', 'glow' => 'shadow-emerald-500/20'],
                                ['label' => 'Atmosphere', 'value' => 65, 'icon' => '✨', 'color' => 'bg-purple-500', 'glow' => 'shadow-purple-500/20'],
                                ['label' => 'Mood', 'value' => 42, 'icon' => '🌙', 'color' => 'bg-amber-500', 'glow' => 'shadow-amber-500/20'],
                                ['label' => 'Production Quality', 'value' => 98, 'icon' => '🎚️', 'color' => 'bg-pink-500', 'glow' => 'shadow-pink-500/20'],
                                ['label' => 'Vocal Focus', 'value' => 78, 'icon' => '🎙️', 'color' => 'bg-indigo-500', 'glow' => 'shadow-indigo-500/20'],
                            ];
                        @endphp
                        @foreach($characteristics as $metric)
                            <div class="space-y-4">
                                <div class="flex items-center justify-between text-[11px] font-black uppercase tracking-widest text-white/40">
                                    <div class="flex items-center gap-3">
                                        <span class="w-6 h-6 rounded bg-white/5 border border-white/10 flex items-center justify-center text-[10px]">{{ $metric['icon'] }}</span>
                                        <span>{{ $metric['label'] }}</span>
                                    </div>
                                    <span class="text-white">{{ $metric['value'] }}%</span>
                                </div>
                                <div class="h-1.5 w-full bg-white/5 rounded-full overflow-hidden border border-white/5 p-[1px]">
                                    <div class="{{ $metric['color'] }} h-full rounded-full transition-all duration-1000 shadow-lg {{ $metric['glow'] }}" style="width: {{ $metric['value'] }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <article class="prose prose-invert prose-lg max-w-none">
                        <div class="article-content text-white/70 text-base leading-relaxed">
                            {!! Str::markdown($article->content ?? 'No detailed analysis available.') !!}
                        </div>
                    </article>
                </section>

                {{-- Lyrics --}}
                <section>
                    <div class="flex items-center border-b border-white/5 pb-6 mb-10">
                        <div class="w-1.5 h-10 bg-blue-500 rounded-full mr-6 shadow-[0_0_15px_rgba(59,130,246,0.5)]"></div>
                        <h2 class="text-3xl font-black text-white tracking-tighter uppercase">Lyrics</h2>
                    </div>
                    <div class="card-premium-unified !bg-[#161b22]/20 !p-12 lg:p-20 text-center">
                         <div class="max-w-2xl mx-auto space-y-8">
                             @foreach(explode("\n", $article->song->lyrics ?? "Lyrics coming soon...") as $line)
                                 <p class="text-xl md:text-2xl font-bold text-white/70 hover:text-white transition-colors cursor-default">{{ $line }}</p>
                             @endforeach
                         </div>
                    </div>
                </section>

                {{-- Family Tree (Neural Map) --}}
                <section>
                    <div class="flex items-center border-b border-white/5 pb-6 mb-10">
                        <div class="w-1.5 h-10 bg-purple-500 rounded-full mr-6 shadow-[0_0_15px_rgba(168,85,247,0.5)]"></div>
                        <h2 class="text-3xl font-black text-white tracking-tighter uppercase">Related Tracks</h2>
                    </div>
                    <div class="h-[500px] rounded-[32px] overflow-hidden border border-white/10 bg-black/20 relative shadow-2xl">
                         <livewire:wiki.⚡genetic-tree :song="$article->song" />
                    </div>
                </section>

                {{-- Metadata Consolidated Section --}}
                <section class="border-t border-white/5 pt-16">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Actions & Technical --}}
                        <div class="card-premium-unified !bg-[#161b22]/40 !p-10 space-y-8">
                            <h3 class="text-[11px] font-bold text-white/40 tracking-widest uppercase">Information</h3>
                            <div class="grid grid-cols-2 gap-6">
                                <div class="space-y-1">
                                    <span class="text-[10px] text-white/30 uppercase font-bold tracking-widest">Key</span>
                                    <p class="text-xl font-black text-white uppercase">{{ $article->song->key ?? '--' }}</p>
                                </div>
                                <div class="space-y-1">
                                    <span class="text-[10px] text-white/30 uppercase font-bold tracking-widest">BPM</span>
                                    <p class="text-xl font-black text-blue-500">{{ $article->song->bpm ?? '--' }}</p>
                                </div>
                                <div class="space-y-1">
                                    <span class="text-[10px] text-white/30 uppercase font-bold tracking-widest">Genre</span>
                                    <p class="text-xl font-black text-white truncate">{{ $article->genre->name ?? 'Mixed' }}</p>
                                </div>
                                <div class="space-y-1">
                                    <span class="text-[10px] text-white/30 uppercase font-bold tracking-widest">Plays</span>
                                    <p class="text-xl font-black text-white">{{ number_format($article->song->stream_count ?? 0) }}</p>
                                </div>
                            </div>
                            
                            <div class="flex flex-col gap-4 pt-6 border-t border-white/5">
                                <livewire:article.play-button :articleId="$article->id" label="Play track" class="btn-figma-primary !w-full !py-4" />
                                <div class="flex gap-4">
                                    <div class="flex-1"><livewire:article.add-to-collection :article="$article" /></div>
                                    <div class="flex-1"><livewire:article.bookmark-button :article="$article" /></div>
                                </div>
                            </div>
                        </div>

                        {{-- Artist Summary --}}
                        @if($article->song->artist && $article->song->artist->article)
                        <div class="card-premium-unified !bg-[#161b22]/60 !p-10 flex flex-col justify-between">
                             <div class="flex items-center gap-6 mb-8">
                                <div class="w-20 h-20 rounded-2xl overflow-hidden border border-white/10 shrink-0">
                                    <img src="{{ $article->song->artist->article->featured_image }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h3 class="text-[11px] font-bold text-white/40 tracking-widest uppercase">Artist</h3>
                                    <p class="text-2xl font-black text-white uppercase tracking-tighter">{{ $article->song->artist->name }}</p>
                                </div>
                             </div>
                             <p class="text-sm text-white/50 leading-relaxed line-clamp-3 mb-8">
                                {{ Str::limit(strip_tags((string) $article->song->artist->article->content), 200) }}
                             </p>
                             <a href="{{ route('wiki.show', $article->song->artist->article) }}" class="inline-flex items-center gap-2 text-[11px] font-black text-blue-400 uppercase tracking-widest hover:text-white transition-colors">
                                View Artist Profile
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                             </a>
                        </div>
                        @endif
                    </div>
                </section>

                {{-- Discussion --}}
                <section>
                    <div class="flex items-center border-b border-white/5 pb-6 mb-10">
                        <div class="w-1.5 h-10 bg-blue-500 rounded-full mr-6 shadow-[0_0_15px_rgba(59,130,246,0.5)]"></div>
                        <h2 class="text-3xl font-black text-white tracking-tighter uppercase">Discussion</h2>
                    </div>
                    <div class="card-premium-unified !bg-[#161b22]/20 !p-12">
                        <livewire:article.comments :article="$article" />
                    </div>
                </section>
            </div>
        </main>
    </div>
</div>
@endsection


