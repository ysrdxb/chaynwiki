@extends('layouts.wiki')

@section('title', $article->title)

@section('content')
    <!-- HERO SECTION -->
    <div class="relative min-h-[40vh] flex items-center bg-primary section-divider overflow-hidden pt-20">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-5"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-blue-500/5 via-transparent to-transparent"></div>
        
        <div class="relative z-10 max-w-[1200px] mx-auto px-8 w-full">
            <div class="max-w-3xl">
                <span class="text-[10px] font-black text-blue-400 uppercase tracking-[0.3em] mb-4 block">Archive Classification</span>
                <h1 class="text-7xl lg:text-9xl font-black text-white italic uppercase tracking-tighter mb-8 leading-none">
                    {{ $article->title }}
                </h1>
                <div class="flex items-center gap-4">
                    <a href="{{ route('wiki.edit', $article->slug) }}" class="btn-primary-v2 px-8 py-3">
                        Edit Classification
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENT AREA -->
    <div class="max-w-[1200px] mx-auto px-8 py-20">
        <div class="flex flex-col lg:flex-row gap-16">
            <div class="flex-1">
                <article class="prose prose-invert prose-lg max-w-none">
                    <div class="text-white/60 leading-relaxed font-medium">
                        {!! $article->content !!}
                    </div>
                </article>
                
                <section class="mt-20 pt-16 border-t border-white/5">
                    <livewire:article.comments :article="$article" />
                </section>
            </div>
            
            <div class="w-full lg:w-80">
                <div class="glass p-8 rounded-3xl border border-white/10 bg-secondary">
                    <h3 class="text-xl font-black text-white italic uppercase tracking-tighter mb-6">Quick Facts</h3>
                    <p class="text-white/40 text-sm leading-relaxed mb-8">
                        This genre represents a core node in our music archive. Contributors are encouraged to document sub-genres and historical origins.
                    </p>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-white/5">
                            <span class="text-[10px] font-black text-white/30 uppercase tracking-widest">Articles</span>
                            <span class="text-white font-bold">{{ rand(50, 200) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
