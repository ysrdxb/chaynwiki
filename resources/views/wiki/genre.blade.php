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
    <!-- HERO SECTION -->
    <div class="relative min-h-[40vh] flex items-center bg-primary section-divider overflow-hidden pt-32">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-5"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-[#38bdf8]/5 via-transparent to-transparent"></div>
        
        <div class="relative z-10 max-w-[1200px] mx-auto px-8 w-full">
            <div class="max-w-3xl">
                <span class="text-xs font-semibold text-[#38bdf8] uppercase tracking-[0.3em] mb-4 block">Archive Classification</span>
                <h1 class="text-7xl lg:text-9xl font-black text-white italic uppercase tracking-tighter mb-8 leading-none">
                    {{ $article->title }}
                </h1>
                <div class="flex flex-wrap items-center gap-4">
                    <a href="{{ route('wiki.edit', $article->slug) }}" class="px-7 py-3.5 bg-white text-black rounded-xl text-[11px] font-semibold uppercase tracking-widest hover:scale-105 transition-all flex items-center justify-center gap-3 relative overflow-hidden group">
                        <span class="relative z-10">Edit Classification</span>
                        <div class="w-4 h-4 rounded-full bg-[#38bdf8]/20 flex items-center justify-center relative z-10">
                            <div class="w-1.5 h-1.5 rounded-full bg-[#38bdf8] shadow-[0_0_8px_rgba(56,189,248,0.8)]"></div>
                        </div>
                    </a>
                    <div class="flex items-center gap-3 px-5 py-3 bg-white/8 border border-white/15 rounded-2xl min-h-[48px] mb-2">
                         <livewire:article.vote-button :model="$article" wire:key="vote-article-{{ $article->id }}" />
                        <span class="text-[10px] font-semibold uppercase tracking-[0.2em] text-white/60">Community Score</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENT AREA -->
    <section class="bg-primary section-divider">
        <div class="max-w-[1200px] mx-auto px-8 py-20">
        <div class="flex flex-col lg:flex-row gap-16">
            <div class="flex-1">
                <article class="prose prose-invert prose-lg max-w-none">
                    <div class="text-white/60 text-sm leading-relaxed">
                        {!! Str::markdown($article->content) !!}
                    </div>
                </article>
                
                <section class="mt-20 pt-16 border-t border-white/5">
                    <livewire:article.comments :article="$article" />
                </section>
            </div>
            
            <div class="w-full lg:w-80">
                <div class="glass p-8 rounded-3xl border border-white/10 bg-[#0f1419]">
                    <h3 class="text-lg font-black text-white italic uppercase tracking-tighter mb-6">Quick Facts</h3>
                    <p class="text-white/50 text-sm leading-relaxed mb-8">
                        This genre represents a core node in our music archive. Contributors are encouraged to document sub-genres and historical origins.
                    </p>
                    
                    <div class="space-y-4">
                        <livewire:article.play-button 
                            :articleId="$article->id" 
                            label="Listen to Audio Pulse"
                            class="w-full py-3.5 bg-[#38bdf8] text-[#0a0e14] rounded-2xl text-[11px] font-semibold uppercase tracking-[0.2em] hover:scale-[1.02] flex items-center justify-center gap-3 shadow-xl shadow-[#38bdf8]/20"
                        />

                        <x-article.⚡add-to-crate :article="$article" />

                        <div class="flex justify-between items-center py-3 border-b border-white/5">
                            <span class="text-[10px] font-semibold text-white/50 uppercase tracking-widest">Articles</span>
                            <span class="text-white font-bold">170</span>
                        </div>
                        <div class="flex justify-between items-center py-5">
                            <span class="text-[10px] font-semibold text-white/50 uppercase tracking-widest">Archive Utility</span>
                             <livewire:article.vote-button :model="$article" wire:key="sidebar-vote-article-{{ $article->id }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
