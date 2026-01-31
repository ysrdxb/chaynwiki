@extends('layouts.wiki')

@section('title', $article->title . ' - Music Terminology - ChaynWiki')

@section('content')
    @php
        $featured_image = $article->featured_image ?: 'https://images.unsplash.com/photo-1514320299584-4bd06b02a04e?auto=format&fit=crop&q=80&w=1200';
    @endphp

    <div x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 500)">
        <!-- Actual Content -->
        <div x-show="loaded" x-transition:enter="transition duration-500">
            <!-- HERO SECTION -->
            <div class="relative pt-24 pb-12 bg-primary section-divider overflow-hidden">
                <div class="absolute inset-0 z-0">
                    <img src="{{ $featured_image }}" class="w-full h-full object-cover grayscale opacity-5 blur-xl scale-125">
                    <div class="absolute inset-0 bg-gradient-to-t from-primary via-primary/80 to-transparent"></div>
                </div>
                
                <div class="relative z-10 max-w-[1200px] mx-auto px-8">
                    <div class="flex flex-col lg:flex-row gap-10 items-end">
                        <div class="flex-1">
                            <nav class="flex items-center gap-2 text-[9px] font-black text-white/20 uppercase tracking-[0.2em] mb-6">
                                <a href="{{ route('home') }}" class="hover:text-blue-400">Home</a>
                                <span>/</span>
                                <a href="{{ route('wiki.index', ['category' => 'term']) }}" class="hover:text-blue-400">Glossary</a>
                                <span>/</span>
                                <span class="text-blue-500">{{ $article->term->category_type ?? 'Terms' }}</span>
                            </nav>

                            <h1 class="text-4xl lg:text-7xl font-black text-white italic uppercase tracking-tighter mb-4 leading-none">
                                {{ $article->title }}
                            </h1>
                            
                            @if($article->term->phonetic)
                                <p class="text-blue-500 font-mono text-lg mb-6">{{ $article->term->phonetic }}</p>
                            @endif

                            <div class="flex flex-wrap items-center gap-5 text-[10px] font-black text-white/20 uppercase tracking-widest mt-8">
                                <div class="flex items-center gap-2">
                                    <span class="w-1 h-1 rounded-full bg-blue-500"></span>
                                    Origin: {{ $article->term->origin_language ?? 'Unknown' }}
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="w-1 h-1 rounded-full bg-white/5"></span>
                                    {{ number_format($article->view_count ?? 0) }} Views
                                </div>
                                <div class="px-3 py-1 bg-white/5 rounded-lg border border-white/10 text-white/40">
                                    {{ strtoupper($article->term->category_type ?? 'General') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MAIN CONTENT AREA -->
            <div class="max-w-[1200px] mx-auto px-8 py-12">
                <div class="flex flex-col lg:flex-row gap-12">
                    <!-- Main Column -->
                    <div class="flex-1 min-w-0">
                        <article class="prose prose-invert prose-base max-w-none">
                            <h2 class="text-xl font-black text-white italic uppercase tracking-tighter mb-8 flex items-center gap-3">
                                <span class="w-8 h-px bg-blue-500"></span>
                                Definition & Usage
                            </h2>
                            <div class="article-content text-white/50 leading-relaxed text-lg">
                                {!! $article->content !!}
                            </div>
                        </article>

                        <section class="mt-16 pt-12 border-t border-white/5">
                            <livewire:article.comments :article="$article" />
                        </section>
                    </div>

                    <!-- Sidebar -->
                    <aside class="w-full lg:w-72 space-y-8">
                        <div class="bg-secondary border border-white/5 p-8 rounded-2xl relative overflow-hidden group">
                             <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 blur-3xl rounded-full -mr-16 -mt-16 group-hover:bg-blue-500/10 transition-colors"></div>
                             
                             <div class="relative z-10">
                                <h3 class="text-lg font-black text-white italic uppercase tracking-tighter mb-6">Archive Actions</h3>
                                <div class="space-y-3">
                                    <livewire:article.vote-button :model="$article" wire:key="vote-article-{{ $article->id }}" />
                                    <livewire:article.bookmark-button :article="$article" />
                                </div>
                             </div>
                        </div>

                        <div class="space-y-4">
                            <h3 class="text-[9px] font-black text-white/10 uppercase tracking-[0.2em]">Related Terms</h3>
                            <div class="flex flex-wrap gap-2">
                                @forelse($article->term->related_terms ?? [] as $related)
                                    <a href="#" class="px-4 py-2 bg-white/5 border border-white/5 rounded-xl text-[10px] text-white/40 hover:text-blue-400 hover:border-blue-500/30 transition-all uppercase font-black tracking-widest">
                                        {{ $related }}
                                    </a>
                                @empty
                                    <p class="text-[10px] text-white/10 italic">No linked terms found.</p>
                                @endforelse
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
@endsection
