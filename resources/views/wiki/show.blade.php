@extends('layouts.wiki')

@section('title', $article->title . ' - ChaynWiki')

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
        $placeholder = match ($article->category) {
            'artist' => 'https://images.unsplash.com/photo-1493225255756-d9584f8606e9?auto=format&fit=crop&q=80&w=1200',
            'song' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&q=80&w=1200',
            'genre' => 'https://images.unsplash.com/photo-1514525253361-bee8a48740ad?auto=format&fit=crop&q=80&w=1200',
            'playlist' => 'https://images.unsplash.com/photo-1459749411177-042180ce6742?auto=format&fit=crop&q=80&w=1200',
            'term' => 'https://images.unsplash.com/photo-1514320299584-4bd06b02a04e?auto=format&fit=crop&q=80&w=1200',
            default => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&q=80&w=1200',
        };

        $featured_image = $article->featured_image;
        if ($featured_image && !Str::startsWith($featured_image, ['http://', 'https://'])) {
            $featured_image = Storage::url($featured_image);
        }
        $featured_image = $featured_image ?: $placeholder;
    @endphp

    <div x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 500)">
        <!-- Skeleton Loading -->
        <div x-show="!loaded" class="relative pt-32 pb-16 bg-primary min-h-screen">
            <div class="max-w-[1200px] mx-auto px-8">
                <div class="skeleton-v2 h-12 w-3/4 mb-8"></div>
                <div class="grid lg:grid-cols-3 gap-12">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="skeleton-v2 h-5 w-full"></div>
                        <div class="skeleton-v2 h-5 w-5/6"></div>
                        <div class="skeleton-v2 h-80 w-full rounded-2xl"></div>
                    </div>
                    <div class="space-y-4">
                        <div class="skeleton-v2 h-56 w-full rounded-2xl"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actual Content -->
        <div x-show="loaded" x-transition:enter="transition duration-500" style="display: none;">
            <!-- HERO SECTION -->
            <div class="relative pt-24 pb-12 bg-primary section-divider overflow-hidden">
                <div class="absolute inset-0 z-0">
                    <img src="{{ $featured_image }}" onerror="this.onerror=null;this.src='{{ $placeholder }}';" class="w-full h-full object-cover grayscale opacity-5 blur-xl scale-125">
                    <div class="absolute inset-0 bg-gradient-to-t from-primary via-primary/80 to-transparent"></div>
                </div>
                
                <div class="relative z-10 max-w-[1200px] mx-auto px-8">
                    <div class="flex flex-col lg:flex-row gap-10 items-end">
                        <div class="flex-1">
                            <nav class="flex items-center gap-2 text-[9px] font-black text-white/20 uppercase tracking-[0.2em] mb-6">
                                <a href="{{ route('home') }}" class="hover:text-[#38bdf8]">Home</a>
                                <span>/</span>
                                <span class="text-[#38bdf8]">{{ strtoupper($article->category) }}</span>
                            </nav>

                            <h1 class="text-4xl lg:text-6xl font-black text-white italic uppercase tracking-tighter mb-6 leading-none">
                                {{ $article->title }}
                            </h1>

                            <div class="flex flex-wrap items-center gap-5 text-[10px] font-black text-white/20 uppercase tracking-widest mt-8">
                                <div class="flex items-center gap-2">
                                    <span class="w-1 h-1 rounded-full bg-[#38bdf8]"></span>
                                    Updated {{ optional($article->updated_at)->format('M d, Y') ?? 'Unknown' }}
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="w-1 h-1 rounded-full bg-white/5"></span>
                                    {{ number_format($article->view_count ?? 0) }} Views
                                </div>
                            </div>
                        </div>

                        <div class="lg:w-64 flex-shrink-0">
                            <div class="aspect-square rounded-2xl overflow-hidden border border-white/5 shadow-2xl relative group">
                                <img src="{{ $featured_image }}" onerror="this.onerror=null;this.src='{{ $placeholder }}';" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MAIN CONTENT AREA -->
            <div class="max-w-[1200px] mx-auto px-8 py-16">
                <div class="flex flex-col lg:flex-row gap-12">
                    <!-- Main Column -->
                    <div class="flex-1 min-w-0">
                        <article class="prose prose-invert prose-base max-w-none">
                            <div class="article-content text-white/60 text-sm leading-relaxed">
                                @if(!empty($article->content))
                                    {!! Str::markdown($article->content) !!}
                                @else
                                    <p class="text-white/50 text-sm">This record is still being authored. Check back soon for the full entry.</p>
                                @endif
                            </div>
                        </article>

                        <section class="mt-12 pt-10 border-t border-white/5">
                            <livewire:article.comments :article="$article" />
                        </section>
                    </div>

                    <!-- Sidebar -->
                    <aside class="w-full lg:w-72 space-y-8">
                        <div class="bg-secondary border border-white/5 p-6 rounded-2xl">
                            <h3 class="text-base font-black text-white italic uppercase tracking-tighter mb-5">Quick Actions</h3>
                            <div class="space-y-3">
                                @auth
                                    @if($article->user_id === auth()->id())
                                        <a href="{{ route('wiki.edit', $article) }}" class="w-full py-3.5 bg-[#38bdf8] text-[#0a0e14] font-semibold text-[10px] uppercase tracking-widest rounded-xl flex items-center justify-center gap-2 hover:bg-[#7dd3fc] transition-all shadow-xl shadow-[#38bdf8]/10">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            Modify Archive
                                        </a>
                                    @endif
                                @endauth
                                <livewire:article.bookmark-button :article="$article" />
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h3 class="text-xs font-semibold text-white/50 uppercase tracking-[0.2em]">Registry Index</h3>
                            <x-table-of-contents :content="$article->content ?? ''" />
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
@endsection
