@extends('layouts.wiki')

@section('title', $article->title . ' - Music Terminology - ChaynWiki')

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
@endphp

<div class="min-h-screen bg-[#0d1117] flex justify-center">
    <div class="max-w-[1400px] w-full px-8 flex items-start gap-12 pt-16 pb-16">
        
        <!-- Sidebar Navigation -->
@include('wiki._sidebar')

        <!-- Main Content -->
        <main class="flex-1 min-w-0">
             <!-- Top Action Row -->
             <div class="flex justify-between items-center mb-16">
                 <!-- Breadcrumbs -->
                 <nav class="flex items-center gap-2 text-[10px] font-bold text-white/30 tracking-[0.2em]">
                    <a href="{{ route('wiki.index', ['category' => 'term']) }}" class="hover:text-blue-400 transition-colors uppercase">Glossary</a>
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
                         <span>Status: <span class="text-white">Verified</span></span>
                         <span class="w-1 h-1 rounded-full bg-white/20"></span>
                         <span>ID: <span class="text-white">TRM-{{ strtoupper(substr($article->title, 0, 3)) }}-{{ $article->id }}</span></span>
                         <span class="w-1 h-1 rounded-full bg-white/20"></span>
                         <span>Category: <span class="text-white">Musical Theory</span></span>
                     </div>
                     
                     <!-- Bio Excerpt -->
                     <div class="max-w-4xl text-lg text-white/70 leading-relaxed mb-10 font-medium font-sans">
                          {{ Str::limit(strip_tags((string) $article->content), 350, '...') }}
                          <a href="#definition" class="text-white underline decoration-white/30 hover:decoration-white transition-all cursor-pointer ml-2">Read Definition</a>
                     </div>

                     <!-- Author & Actions Row -->
                     <div class="flex flex-wrap items-center gap-6 border-b border-white/5 pb-10 mb-8">
                          <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-full px-2 py-2 pr-6 backdrop-blur-md">
                             @if($article->user)
                                 <img src="{{ $article->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($article->user->name).'&background=random' }}" class="w-8 h-8 rounded-full border border-blue-500/50">
                                 <span class="text-[11px] font-black text-white uppercase tracking-widest pl-2">Researcher {{ $article->user->name }}</span>
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
                     </div>
                 </div>

                 <!-- Hero Image Banner -->
                 @if($featured_image)
                 <div class="relative w-full aspect-[21/9] rounded-[2rem] overflow-hidden border border-white/10 shadow-3xl group mb-24">
                      <img src="{{ $featured_image }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                       <div class="absolute inset-0 bg-gradient-to-t from-[#0d1117] via-transparent to-transparent opacity-60"></div>
                 </div>
                 @endif
            </div>

            <div class="space-y-24">
                {{-- Definition Section --}}
                <section id="definition">
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
                             <h3 class="text-[11px] font-bold text-white/40 tracking-widest uppercase mb-8">Archival Controls</h3>
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
                                    <img src="{{ $article->user->avatar ?? 'https://ui-avatars.com/api/?name='.$article->user->name }}" class="w-10 h-10 rounded-full border border-blue-500/30">
                                    <div>
                                        <p class="text-sm font-bold text-white">{{ $article->user->name }}</p>
                                        <p class="text-[10px] text-white/30 uppercase tracking-widest">Lead Investigator</p>
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
        </main>
    </div>
</div>
@endsection
