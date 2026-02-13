@extends('layouts.wiki')

@section('title', $article->title . ' - Music Terminology - ChaynWiki')

@php
    $seoDescription = $summary ?? Str::limit(strip_tags((string) $article->content), 160);
    $seoImage = $article->featured_image;
    if ($seoImage && !Str::startsWith($seoImage, ['http://', 'https://'])) {
        $seoImage = Storage::url($seoImage);
    }
    // Use a default image for SEO if none exists, but we'll handle the UI fallback differently
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
    // We do NOT set a placeholder here anymore, we check existence in the view
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
                <a href="{{ route('wiki.index', ['category' => $key]) }}" class="group flex items-center gap-4 px-4 py-4 rounded-2xl text-[14px] font-bold transition-all {{ $key === 'term' ? 'bg-blue-500/10 text-white border border-blue-500/20 shadow-lg' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
                    <div class="w-9 h-9 rounded-full {{ $key === 'term' ? 'bg-blue-500 shadow-lg shadow-blue-500/20' : 'bg-white/5' }} flex items-center justify-center transition-all group-hover:scale-110">
                        <svg class="w-4 h-4 {{ $key === 'term' ? 'text-white' : 'text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $cat['icon'] !!}</svg>
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
                 <nav class="flex items-center gap-2 text-[10px] font-bold text-white/30 tracking-[0.2em]">
                    <a href="{{ route('wiki.index', ['category' => 'term']) }}" class="hover:text-blue-400 transition-colors">Glossary</a>
                    <span>/</span>
                    <span class="text-white">{{ Str::limit($article->title, 30) }}</span>
                </nav>

                <div class="flex items-center gap-4">
                    <a href="{{ route('wiki.edit', $article) }}" class="text-xs font-bold text-white/50 hover:text-white tracking-wider transition-colors">Edit</a>
                </div>
            </div>

            <!-- Hero Area -->
            <div class="relative w-full aspect-[21/9] rounded-[2rem] overflow-hidden mb-10 border border-white/5 group">
                 @if($featured_image)
                    <img src="{{ $featured_image }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-1000">
                 @endif
            </div>

            {{-- Hero Section Text --}}
            <div class="relative pb-24 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-b from-blue-500/10 via-transparent to-transparent opacity-50"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-blue-500/10 border border-blue-500/20 rounded-full text-[10px] font-black uppercase tracking-widest text-blue-400 shadow-[0_0_15px_rgba(59,130,246,0.3)]">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            Wiki Dictionary
                        </div>
                    </div>
                    
                    <h1 class="text-4xl sm:text-7xl md:text-9xl font-black text-white uppercase tracking-tighter leading-none mb-12">
                         {{ $article->title }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-8">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black text-white/30 uppercase tracking-[0.2em] mb-1">Status</span>
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.5)]"></span>
                                <span class="text-sm font-black text-white uppercase tracking-widest">Verified Entry</span>
                            </div>
                        </div>
                        <div class="h-10 w-px bg-white/10 shrink-0"></div>
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black text-white/30 uppercase tracking-[0.2em] mb-1">Reference ID</span>
                            <span class="text-sm font-mono text-white/60 tracking-tighter">TRM-{{ strtoupper(substr($article->title, 0, 3)) }}-{{ $article->id }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="space-y-24">
                {{-- Definition Section --}}
                <section>
                    <div class="flex items-center border-b border-white/5 pb-6 mb-10">
                        <div class="w-1.5 h-10 bg-blue-500 rounded-full mr-6 shadow-[0_0_15px_rgba(59,130,246,0.5)]"></div>
                        <h2 class="text-3xl font-black text-white tracking-tighter uppercase">Definition</h2>
                    </div>
                    <article class="prose prose-invert prose-lg max-w-none">
                        <div class="article-content text-white/70 text-base leading-relaxed">
                            {!! Str::markdown($article->content ?? 'No definition available.') !!}
                        </div>
                    </article>
                </section>

                {{-- Usage Section --}}
                <section>
                    <div class="flex items-center border-b border-white/5 pb-6 mb-10">
                        <div class="w-1.5 h-10 bg-emerald-500 rounded-full mr-6 shadow-[0_0_15px_rgba(16,185,129,0.5)]"></div>
                        <h2 class="text-3xl font-black text-white tracking-tighter uppercase">Standard Usage</h2>
                    </div>
                    <div class="bg-emerald-500/[0.03] border border-white/5 rounded-[2.5rem] p-12 relative overflow-hidden group">
                         <div class="absolute top-0 right-0 p-10">
                             <svg class="w-16 h-16 text-emerald-500/5" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H16.017C14.9124 8 14.017 7.10457 14.017 6V4C14.017 3.44772 14.4647 3 15.017 3H21.017C21.5693 3 22.017 3.44772 22.017 4V15C22.017 18.3137 19.3307 21 16.017 21H14.017ZM3 21L3 18C3 16.8954 3.89543 16 5 16H8C8.55228 16 9 15.5523 9 15V9C9 8.44772 8.55228 8 8 8H5C3.89543 8 3 7.10457 3 6V4C3 3.44772 3.44772 3 4 3H10C10.5523 3 11 3.44772 11 4V15C11 18.3137 8.31371 21 5 21H3Z"/></svg>
                         </div>
                         <p class="text-2xl text-white font-bold italic leading-relaxed relative z-10 max-w-3xl">
                             "The implementation of this concept is vital for the archivation of the sonic landscape within the wiki."
                         </p>
                         <div class="mt-8 flex items-center gap-4 relative z-10">
                             <div class="w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-500">
                                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                             </div>
                             <span class="text-[10px] font-black text-emerald-400 uppercase tracking-[0.2em]">Contextual Example</span>
                         </div>
                    </div>
                </section>

                {{-- Action & Info Composite --}}
                <section class="border-t border-white/5 pt-20">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        {{-- Controls --}}
                        <div class="card-premium-unified !bg-[#161b22]/40 !p-10 space-y-8">
                             <div class="flex items-center gap-6">
                                <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-blue-400">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-[11px] font-bold text-white/40 tracking-widest uppercase">Archival Controls</h3>
                                    <p class="text-sm text-white/70 leading-relaxed mt-1">Bookmark this terminology or add it to your research collection.</p>
                                </div>
                             </div>
                             <div class="space-y-6 pt-6 border-t border-white/5">
                                <div class="flex gap-4">
                                    <div class="flex-1"><livewire:article.add-to-collection :article="$article" /></div>
                                    <div class="flex-1"><livewire:article.bookmark-button :article="$article" /></div>
                                </div>
                             </div>
                        </div>

                        {{-- Metadata --}}
                        <div class="card-premium-unified !bg-[#161b22]/60 !p-10">
                            <h3 class="text-[11px] font-bold text-white/40 tracking-widest uppercase mb-8">Archival Summary</h3>
                            <div class="space-y-6">
                                <div class="flex items-center justify-between py-2 border-b border-white/5">
                                    <span class="text-sm text-white/50">Status</span>
                                    <span class="text-xs font-black text-blue-400 uppercase tracking-widest">Verified Entry</span>
                                </div>
                                @if($article->user)
                                <div class="flex items-center gap-4 pt-4">
                                    <div class="w-10 h-10 rounded-full bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400 font-bold text-sm">
                                        {{ substr($article->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-white">{{ $article->user->name }}</p>
                                        <p class="text-[9px] text-white/30 uppercase tracking-widest">Lead Investigator</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Discussion --}}
                <section>
                    <div class="flex items-center border-b border-white/5 pb-6 mb-10">
                        <div class="w-1.5 h-10 bg-purple-500 rounded-full mr-6 shadow-[0_0_15px_rgba(168,85,247,0.5)]"></div>
                        <h2 class="text-3xl font-black text-white tracking-tighter uppercase">Peer Review</h2>
                    </div>
                    <div class="card-premium-unified !bg-[#161b22]/20 !p-12">
                        <livewire:article.comments :article="$article" />
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
