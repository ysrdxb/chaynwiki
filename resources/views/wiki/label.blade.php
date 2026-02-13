@extends('layouts.wiki')

@section('title', $article->title . ' - Record Label Archive')

@section('content')
@php
    $categories = [
        'artist' => ['label' => 'Artists', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>'],
        'song' => ['label' => 'Songs', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>'],
        'genre' => ['label' => 'Genres', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>'],
        'playlist' => ['label' => 'Playlists', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>'],
        'term' => ['label' => 'Terminology', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>'],
    ];
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
                <a href="{{ route('wiki.index', ['category' => $key]) }}" class="group flex items-center gap-4 px-4 py-4 rounded-2xl text-[14px] font-bold transition-all {{ $key === 'label' ? 'bg-emerald-500/10 text-white border border-emerald-500/20 shadow-lg' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
                    <div class="w-9 h-9 rounded-full {{ $key === 'label' ? 'bg-emerald-500 shadow-lg shadow-emerald-500/20' : 'bg-white/5' }} flex items-center justify-center transition-all group-hover:scale-110">
                        <svg class="w-4 h-4 {{ $key === 'label' ? 'text-white' : 'text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $cat['icon'] !!}</svg>
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
                    <a href="{{ route('wiki.index', ['category' => 'playlist']) }}" class="hover:text-blue-400 transition-colors">Labels</a>
                    <span>/</span>
                    <span class="text-white">{{ Str::limit($article->title, 30) }}</span>
                </nav>

                <div class="flex items-center gap-4">
                    <a href="{{ route('wiki.edit', $article) }}" class="text-xs font-bold text-white/50 hover:text-white tracking-wider transition-colors">Edit</a>
                </div>
            </div>

            {{-- Hero Section --}}
            <div class="relative pb-20 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-b from-emerald-500/10 via-transparent to-transparent opacity-50"></div>
                
                <div class="relative z-10">
                    <div class="flex flex-col md:flex-row items-end gap-12">
                        {{-- Label Logo/Image --}}
                        <div class="w-64 h-64 rounded-[2.5rem] overflow-hidden border border-white/10 shadow-3xl group relative shrink-0">
                            <img src="{{ $article->featured_image }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute bottom-6 left-6">
                                <span class="px-3 py-1 bg-emerald-500/20 border border-emerald-500/30 rounded-lg text-[10px] font-black uppercase tracking-widest text-emerald-400 backdrop-blur-md">Record Label</span>
                            </div>
                        </div>

                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-500/10 border border-emerald-500/20 rounded-full text-[10px] font-black uppercase tracking-widest text-emerald-400 shadow-[0_0_15px_rgba(16,185,129,0.3)]">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                    Label / Studio
                                </div>
                                @if($article->is_master)
                                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-amber-500/10 border border-amber-500/20 rounded-full text-[10px] font-black uppercase tracking-widest text-amber-500 shadow-[0_0_15px_rgba(245,158,11,0.3)]">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        Primary Record
                                    </div>
                                @endif
                            </div>
                            <h1 class="text-4xl sm:text-6xl md:text-8xl font-black text-white uppercase tracking-tighter leading-none mb-8">
                                {{ $article->title }}
                            </h1>
                            <div class="grid grid-cols-2 lg:flex lg:flex-wrap items-center gap-6 lg:gap-10">
                                 <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-white/30 uppercase tracking-[0.2em] mb-1">Verification</span>
                                    <div class="flex items-center gap-2">
                                        <div class="w-20 h-1.5 bg-white/5 rounded-full overflow-hidden">
                                             <div class="h-full bg-emerald-500" style="width: {{ $article->data_quality }}%"></div>
                                        </div>
                                        <span class="text-xs font-bold text-white uppercase tracking-widest">{{ $article->data_quality }}% Accuracy</span>
                                    </div>
                                </div>
                                <div class="h-10 w-px bg-white/10 hidden md:block"></div>
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-white/30 uppercase tracking-[0.2em] mb-1">Artists</span>
                                    <span class="text-2xl font-black text-white uppercase tracking-tighter">{{ count($roster) }} <span class="text-white/20">Signings</span></span>
                                </div>
                                <div class="h-10 w-px bg-white/10 hidden md:block"></div>
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-white/30 uppercase tracking-[0.2em] mb-1">Catalog Size</span>
                                    <span class="text-2xl font-black text-white uppercase tracking-tighter">{{ count($catalog) }} <span class="text-white/20">Releases</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="space-y-24">
                
                {{-- Vision/Biography --}}
                <section>
                    <div class="flex items-center border-b border-white/5 pb-6 mb-10">
                        <div class="w-1.5 h-10 bg-emerald-500 rounded-full mr-6 shadow-[0_0_15px_rgba(16,185,129,0.5)]"></div>
                        <h2 class="text-3xl font-black text-white tracking-tighter uppercase">Mission & Vision</h2>
                    </div>
                    <article class="prose prose-invert prose-lg max-w-none">
                        <div class="article-content text-white/70 text-base leading-relaxed">
                            {!! Str::markdown($article->content ?? 'No detailed history available.') !!}
                        </div>
                    </article>
                </section>

                {{-- Catalog & Roster Combined --}}
                <section>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                        {{-- Signed Artists --}}
                        <div class="space-y-8">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-xl font-bold text-white uppercase tracking-tighter">Verified Roster</h3>
                                <span class="text-[10px] font-black text-white/30 uppercase tracking-widest">{{ count($roster) }} Artists</span>
                            </div>
                            <div class="card-premium-unified !bg-[#161b22]/40 !p-8 space-y-6">
                                @forelse($roster as $artist)
                                    <a href="{{ route('wiki.show', $artist->slug) }}" class="flex items-center gap-4 group/artist">
                                        <div class="w-12 h-12 rounded-2xl overflow-hidden border border-white/10 group-hover/artist:border-emerald-500/50 transition-all">
                                            <img src="{{ $artist->featured_image }}" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-[14px] font-black text-white group-hover/artist:text-emerald-400 transition-colors uppercase tracking-tight">{{ $artist->title }}</span>
                                            <span class="text-[9px] font-black text-white/20 uppercase tracking-widest mt-0.5">Active Signing</span>
                                        </div>
                                    </a>
                                @empty
                                    <p class="text-white/20 text-xs font-bold uppercase tracking-widest py-4 text-center">Empty Roster</p>
                                @endforelse
                            </div>
                        </div>

                        {{-- Recent Catalog --}}
                        <div class="space-y-8">
                             <div class="flex items-center justify-between mb-2">
                                <h3 class="text-xl font-bold text-white uppercase tracking-tighter">Archival Catalog</h3>
                                <span class="text-[10px] font-black text-white/30 uppercase tracking-widest">{{ count($catalog) }} Releases</span>
                            </div>
                            <div class="card-premium-unified !bg-[#161b22]/60 !p-8 space-y-4">
                                @forelse(array_slice($catalog, 0, 6) as $item)
                                     <a href="{{ route('wiki.show', $item->slug) }}" class="group/item flex items-center gap-4 p-3 rounded-2xl hover:bg-white/5 transition-all">
                                        <div class="w-10 h-10 rounded-lg overflow-hidden border border-white/10 shrink-0">
                                            <img src="{{ $item->featured_image }}" class="w-full h-full object-cover">
                                        </div>
                                        <div class="min-w-0">
                                            <h4 class="text-sm font-bold text-white group-hover/item:text-blue-400 transition-colors truncate uppercase">{{ $item->title }}</h4>
                                            <p class="text-[9px] font-black text-white/20 uppercase tracking-widest">Catalog Entry</p>
                                        </div>
                                    </a>
                                @empty
                                    <p class="text-white/20 text-xs font-bold uppercase tracking-widest py-4 text-center">No catalog entries</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Industrial Context (Neural Map) --}}
                <section>
                    <div class="flex items-center border-b border-white/5 pb-6 mb-10">
                        <div class="w-1.5 h-10 bg-purple-500 rounded-full mr-6 shadow-[0_0_15px_rgba(168,85,247,0.5)]"></div>
                        <h2 class="text-3xl font-black text-white tracking-tighter uppercase">Industry Mapping</h2>
                    </div>
                    <div class="h-[500px] rounded-[32px] overflow-hidden border border-white/10 bg-black/20 backdrop-blur-xl relative group shadow-2xl">
                        <x-neural-map-visualization :articleId="$article->id" :height="500" />
                    </div>
                </section>

                {{-- Metadata Consolidated Section --}}
                <section class="border-t border-white/5 pt-16">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Action Card --}}
                        <div class="card-premium-unified !bg-[#161b22]/40 !p-10 space-y-8">
                             <div class="flex items-center gap-6">
                                <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-emerald-400">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-[11px] font-bold text-white/40 tracking-widest uppercase">Verified Entity</h3>
                                    <p class="text-sm text-white/70 leading-relaxed mt-1">
                                        This record label is a verified architectural entity in the ChaynWiki archivation project.
                                    </p>
                                </div>
                             </div>

                             <div class="space-y-6 pt-6 border-t border-white/5">
                                <div class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/5 hover:border-emerald-500/20 transition-all">
                                    <span class="text-[11px] font-bold text-white/30 tracking-widest uppercase">Reputation</span>
                                    <livewire:article.vote-button :model="$article" wire:key="label-vote-{{ $article->id }}" />
                                </div>
                                <div class="group"><livewire:article.bookmark-button :article="$article" /></div>
                             </div>
                        </div>

                        {{-- Metadata & Contributor --}}
                        <div class="card-premium-unified !bg-[#161b22]/60 !p-10 flex flex-col justify-between">
                            <div class="space-y-6">
                                <h3 class="text-[11px] font-bold text-white/40 tracking-widest uppercase">Data Summary</h3>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between py-2 border-b border-white/5">
                                        <span class="text-sm text-white/50">Status</span>
                                        <span class="text-xs font-black text-emerald-400 uppercase tracking-widest">Active Record</span>
                                    </div>
                                    <div class="flex items-center justify-between py-2 border-b border-white/5">
                                        <span class="text-sm text-white/50">Data Proof</span>
                                        <div class="flex items-center gap-2">
                                            <span class="text-[10px] font-mono text-white/30">{{ substr(hash('sha256', $article->id), 0, 12) }}</span>
                                        </div>
                                    </div>
                                </div>
                                @if($article->user)
                                <div class="flex items-center gap-4 pt-4">
                                    <img src="{{ $article->user->avatar ?? 'https://ui-avatars.com/api/?name='.$article->user->name }}" class="w-10 h-10 rounded-full border border-emerald-500/30">
                                    <div>
                                        <p class="text-sm font-bold text-white">{{ $article->user->name }}</p>
                                        <p class="text-[10px] text-white/30 uppercase tracking-widest">Lead Archivist</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </section>
        </main>
    </div>
</div>
@endsection
