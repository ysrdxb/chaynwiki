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
                <span class="text-white/20 text-[11px] font-bold text-blue-400 tracking-widest">Explore all</span>
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
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0d1117] via-[#0d1117]/80 to-transparent"></div>
                 @else
                    <!-- Professional Fallback Gradient -->
                    <div class="absolute inset-0 bg-gradient-to-br from-[#161b22] via-[#0d1117] to-black"></div>
                    <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 brightness-100 contrast-150"></div>
                    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-500/10 rounded-full blur-[120px] -mr-32 -mt-32"></div>
                    <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-purple-500/5 rounded-full blur-[120px] -ml-32 -mb-32"></div>
                 @endif
                 
                 <div class="absolute bottom-0 left-0 p-10 lg:p-16 w-full z-10">
                     @if($article->term?->category_type)
                     <span class="px-3 py-1.5 bg-blue-500/10 border border-blue-500/20 text-blue-400 rounded-lg text-[10px] font-bold tracking-widest inline-block mb-8 shadow-lg">
                        {{ ucfirst($article->term->category_type) }}
                    </span>
                    @endif
                    
                    <h1 class="text-3xl sm:text-5xl lg:text-9xl font-black text-white tracking-tighter mb-8 leading-[0.85] -ml-1" style="font-family: 'Moderniz', sans-serif;">
                        {{ $article->title }}
                    </h1>
                    
                    @if($article->term->phonetic)
                        <p class="text-blue-400 font-mono text-2xl mb-8 tracking-tighter">{{ $article->term->phonetic }}</p>
                    @endif

                    <div class="grid grid-cols-2 sm:flex sm:items-center gap-6 sm:gap-10">
                         @if($article->term?->origin_language)
                         <div class="flex flex-col">
                            <span class="text-[11px] font-bold text-white/30 tracking-widest mb-1">Origin</span>
                            <span class="text-2xl font-black text-white px-1 tracking-tighter">{{ $article->term->origin_language }}</span>
                         </div>
                         @endif
                         <div class="flex flex-col">
                            <span class="text-[11px] font-bold text-white/30 tracking-widest mb-1">Views</span>
                            <span class="text-2xl font-black text-blue-500 px-1 tracking-tighter">{{ number_format($article->view_count ?? 0) }}</span>
                         </div>
                    </div>
                 </div>
            </div>

            <div class="flex flex-col xl:flex-row gap-12">
                <!-- Article Content -->
                <div class="flex-1 min-w-0 space-y-12">
                     <article class="prose prose-invert prose-lg max-w-none">
                        @if($summary)
                            <div class="mb-12 p-10 bg-blue-500/5 border border-white/5 rounded-[2.5rem] relative overflow-hidden group hover:border-blue-500/20 transition-all shadow-3xl">
                                <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500/10 rounded-full blur-[100px] -mr-32 -mt-32"></div>
                                <div class="relative z-10">
                                    <div class="text-[11px] font-bold text-blue-400 tracking-widest mb-6 border-b border-blue-400/20 pb-4 inline-block">Summary</div>
                                    <p class="text-white text-2xl leading-relaxed m-0 font-medium tracking-tight">{{ $summary }}</p>
                                </div>
                            </div>
                        @endif
                        
                        <div class="article-content text-white/70 text-base leading-relaxed">
                             {!! Str::markdown($article->content) !!}
                        </div>
                    </article>
                    
                     <section class="border-t border-white/5 pt-16">
                        <div class="flex items-center border-b border-white/5 pb-6 mb-10">
                            <div class="w-1.5 h-10 bg-blue-500 rounded-full mr-6 shadow-[0_0_15px_rgba(59,130,246,0.5)]"></div>
                            <h2 class="text-3xl font-black text-white tracking-tighter" style="font-family: 'Moderniz', sans-serif;">Discussion</h2>
                        </div>
                        <livewire:article.comments :article="$article" />
                    </section>
                </div>

                <!-- Right Sidebar (Relevant Data) -->
                <aside class="w-full xl:w-80 space-y-6 shrink-0">
                    <!-- Terminology Info -->
                    <div class="card-premium-unified !bg-[#161b22]/60 !p-8 shadow-3xl">
                        <h3 class="text-[11px] font-bold text-white/40 tracking-widest mb-6">Terminology info</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between py-2 border-b border-white/5">
                                <span class="text-sm text-white/50 font-medium">Type</span>
                                <span class="text-sm text-white font-bold">{{ $article->term->category_type ?? 'Term' }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-white/5">
                                <span class="text-sm text-white/50 font-medium">Published</span>
                                <span class="text-sm text-white font-bold">{{ optional($article->created_at)->format('M d, Y') }}</span>
                            </div>
                             <div class="flex items-center justify-between py-2">
                                <span class="text-sm text-white/50 font-medium">Views</span>
                                <span class="text-sm text-white font-bold">{{ number_format($article->view_count) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Related Terms -->
                    @if(!empty($article->term->related_terms))
                    <div class="card-premium-unified !bg-[#161b22]/60 !p-8 shadow-3xl">
                        <h3 class="text-[11px] font-bold text-white/40 tracking-widest mb-6">Related terms</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($article->term->related_terms as $related)
                                <span class="px-3 py-1.5 bg-white/5 border border-white/10 rounded-lg text-xs font-bold text-white/70 hover:text-blue-400 hover:border-blue-400/30 transition-all cursor-pointer shadow-sm">
                                    {{ $related }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Actions -->
                    <div class="card-premium-unified !bg-[#161b22]/40 !p-8 shadow-3xl space-y-4">
                        <livewire:article.add-to-collection :article="$article" />
                        <livewire:article.bookmark-button :article="$article" />
                    </div>

                    <!-- Contributor -->
                    @if($article->user)
                    <div class="card-premium-unified !bg-[#161b22]/60 !p-8 shadow-3xl">
                        <h3 class="text-[11px] font-bold text-white/40 tracking-widest mb-6">Added by</h3>
                        <a href="{{ route('profile', $article->user->username) }}" class="flex items-center gap-4 group">
                            <div class="w-12 h-12 rounded-full p-0.5 bg-gradient-to-br from-white/10 to-transparent group-hover:from-blue-500/50 transition-all duration-500">
                                <div class="w-full h-full rounded-full overflow-hidden border border-white/10 bg-[#0d1117] flex items-center justify-center">
                                    @if($article->user->avatar)
                                        <img src="{{ $article->user->avatar }}" class="w-full h-full object-cover transition-transform group-hover:scale-110" onerror="this.src='{{ asset('images/hero_background.png') }}'; this.onerror=null;">
                                    @else
                                        <span class="text-sm text-white font-bold">{{ strtoupper(substr($article->user->name, 0, 1)) }}</span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <p class="text-[15px] font-bold text-white group-hover:text-blue-400 transition-colors">{{ $article->user->name }}</p>
                                <p class="text-[11px] text-white/30 font-medium tracking-widest">Contributor</p>
                            </div>
                        </a>
                    </div>
                    @endif

                </aside>
            </div>

        </main>
    </div>
</div>
@endsection
