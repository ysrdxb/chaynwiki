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

    <!-- HERO SECTION -->
    <div class="relative min-h-[50vh] flex items-end pt-32 pb-16 overflow-hidden bg-[#0d1117] border-b border-white/5">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="{{ $featured_image }}" onerror="this.onerror=null;this.src='{{ $placeholder }}';"
                class="w-full h-full object-cover grayscale opacity-10 blur-2xl scale-110">
            <div class="absolute inset-0 bg-gradient-to-t from-[#0d1117] via-[#0d1117]/90 to-transparent"></div>
        </div>

        <div class="relative z-10 max-w-[1400px] mx-auto px-8 w-full">
            <div class="flex flex-col lg:flex-row gap-12 items-end">
                <!-- Cover Image -->
                <div class="shrink-0 group">
                    <div class="absolute -inset-4 bg-blue-400/20 blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
                    <div class="w-56 h-56 lg:w-72 lg:h-72 rounded-[2rem] overflow-hidden border border-white/10 shadow-2xl relative z-10">
                        <img src="{{ $featured_image }}" onerror="this.onerror=null;this.src='{{ $placeholder }}';"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-1000"
                            alt="{{ $article->title }}">
                    </div>
                </div>

                <!-- Article Info -->
                <div class="flex-1 pb-4">
                    <!-- Breadcrumb -->
                    <nav class="flex items-center gap-2 text-[10px] font-black text-white/30 uppercase tracking-[0.2em] mb-6">
                        <a href="{{ route('home') }}" class="hover:text-blue-400 transition-colors">Home</a>
                        <span>/</span>
                        <a href="{{ route('wiki.index', ['category' => $article->category]) }}" class="hover:text-blue-400 transition-colors">{{ ucfirst($article->category) }}</a>
                        <span>/</span>
                        <span class="text-blue-400">{{ Str::limit($article->title, 30) }}</span>
                    </nav>

                    <!-- Category Badge -->
                    <span class="px-3 py-1 bg-blue-400/10 border border-blue-400/20 rounded-lg text-[10px] text-blue-400 font-black uppercase tracking-widest inline-block mb-4">
                        {{ ucfirst($article->category) }}
                    </span>

                    <!-- Title -->
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white uppercase tracking-tighter mb-6 leading-none">
                        {{ $article->title }}
                    </h1>

                    <!-- Stats Strip -->
                    <div class="flex flex-wrap items-center gap-6 text-[10px] font-bold text-white/40 uppercase tracking-widest">
                        <div class="flex items-center gap-2">
                            <div class="w-1.5 h-1.5 rounded-full bg-blue-400"></div>
                            <span>{{ number_format($article->view_count ?? 0) }} Views</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-1.5 h-1.5 rounded-full bg-white/20"></div>
                            <span>Updated {{ optional($article->updated_at)->format('M d, Y') ?? 'N/A' }}</span>
                        </div>
                        @if($article->user)
                        <div class="flex items-center gap-2">
                            <div class="w-1.5 h-1.5 rounded-full bg-white/20"></div>
                            <span>By {{ $article->user->name }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RAPID-FIRE SECTION -->
    <section class="bg-[#0d1117] py-12 border-b border-white/5">
        <div class="max-w-[1400px] mx-auto px-8">
            <h2 class="section-title mb-6">Quick Facts</h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-[#161b22]/40 border border-white/5 rounded-[20px] p-6 hover:border-white/10 transition-all">
                    <div class="w-10 h-10 rounded-full bg-blue-400/10 flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    </div>
                    <p class="text-[10px] font-bold text-white/30 uppercase tracking-widest mb-1">Category</p>
                    <p class="text-white text-sm font-bold">{{ ucfirst($article->category) }}</p>
                </div>

                <div class="bg-[#161b22]/40 border border-white/5 rounded-[20px] p-6 hover:border-white/10 transition-all">
                    <div class="w-10 h-10 rounded-full bg-blue-400/10 flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </div>
                    <p class="text-[10px] font-bold text-white/30 uppercase tracking-widest mb-1">Views</p>
                    <p class="text-white text-sm font-bold">{{ number_format($article->view_count ?? 0) }}</p>
                </div>

                <div class="bg-[#161b22]/40 border border-white/5 rounded-[20px] p-6 hover:border-white/10 transition-all">
                    <div class="w-10 h-10 rounded-full bg-blue-400/10 flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <p class="text-[10px] font-bold text-white/30 uppercase tracking-widest mb-1">Created</p>
                    <p class="text-white text-sm font-bold">{{ optional($article->created_at)->format('M d, Y') ?? 'N/A' }}</p>
                </div>

                <div class="bg-[#161b22]/40 border border-white/5 rounded-[20px] p-6 hover:border-white/10 transition-all">
                    <div class="w-10 h-10 rounded-full bg-blue-400/10 flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                    </div>
                    <p class="text-[10px] font-bold text-white/30 uppercase tracking-widest mb-1">Status</p>
                    <p class="text-white text-sm font-bold">{{ ucfirst($article->status ?? 'Published') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- MAIN CONTENT GRID -->
    <div class="max-w-[1400px] mx-auto px-8 py-16">
        <div class="flex flex-col lg:flex-row gap-16">
            <!-- Main Column -->
            <div class="flex-1 min-w-0 space-y-16">
                <!-- Overview Section -->
                <section>
                    <div class="flex items-center gap-6 mb-10">
                        <h2 class="section-title">Overview</h2>
                        <div class="flex-1 h-px bg-white/5"></div>
                    </div>

                    <div class="bg-[#161b22]/40 border border-white/5 rounded-[20px] p-8 mb-8">
                        <article class="prose prose-invert prose-lg max-w-none">
                            <div class="article-content text-white/70 text-base leading-relaxed">
                                @if(!empty($article->content))
                                    {!! Str::markdown($article->content) !!}
                                @else
                                    <p class="text-white/50 text-sm">This record is still being authored. Check back soon for the full entry.</p>
                                @endif
                            </div>
                        </article>
                    </div>
                </section>

                <!-- Comments Section -->
                <section>
                    <div class="flex items-center gap-6 mb-10">
                        <h2 class="section-title">Discussion</h2>
                        <div class="flex-1 h-px bg-white/5"></div>
                    </div>
                    <livewire:article.comments :article="$article" />
                </section>
            </div>

            <!-- Sidebar -->
            <div class="w-full lg:w-80 space-y-8">
                <!-- Quick Actions -->
                <div class="bg-[#161b22]/40 border border-white/5 p-8 rounded-[20px] hover:border-white/10 transition-all">
                    <h3 class="text-lg font-black text-white uppercase tracking-tighter mb-6">Actions</h3>

                    <div class="space-y-3">
                        @auth
                            @if($article->user_id === auth()->id())
                                <a href="{{ route('wiki.edit', $article) }}" class="btn-figma-primary w-full flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Edit Article
                                </a>
                            @endif
                        @endauth
                        <livewire:article.bookmark-button :article="$article" />
                    </div>
                </div>

                <!-- Contributor / Author -->
                @if($article->user)
                <div class="bg-[#161b22]/40 border border-white/5 rounded-[20px] p-6 hover:border-white/10 transition-all">
                    <h3 class="text-xs font-semibold text-white/50 uppercase tracking-[0.2em] mb-4">Created By</h3>

                    <a href="{{ route('profile', $article->user->username) }}" class="flex items-center gap-4 group">
                        <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-white/10 group-hover:border-blue-400/50 transition-colors">
                            @if($article->user->avatar)
                                <img src="{{ $article->user->avatar }}" alt="{{ $article->user->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-blue-400/10 flex items-center justify-center text-blue-400 font-black text-sm">
                                    {{ strtoupper(substr($article->user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="text-white font-bold group-hover:text-blue-400 transition-colors">{{ $article->user->name }}</p>
                            <p class="text-white/30 text-xs">{{ '@' . $article->user->username }}</p>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center group-hover:bg-blue-400 group-hover:text-white transition-all text-white/30">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </a>

                    <div class="mt-4 pt-4 border-t border-white/5 flex items-center justify-between text-[10px] text-white/30">
                        <span>Member Since {{ $article->user->created_at->format('M Y') }}</span>
                        <span class="text-blue-400">{{ $article->user->reputation_score ?? 0 }} pts</span>
                    </div>
                </div>
                @endif

                <!-- Table of Contents -->
                <div class="bg-[#161b22]/40 border border-white/5 rounded-[20px] p-6 hover:border-white/10 transition-all">
                    <h3 class="text-xs font-semibold text-white/50 uppercase tracking-[0.2em] mb-4">In This Article</h3>
                    <x-table-of-contents :content="$article->content ?? ''" />
                </div>
            </div>
        </div>
    </div>
@endsection
