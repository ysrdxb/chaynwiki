@extends('layouts.wiki')

@section('title', $article->title)

@section('content')
    <!-- HERO SECTION -->
    <div class="relative min-h-[40vh] flex items-center bg-primary section-divider overflow-hidden pt-32">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-5"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-blue-500/5 via-transparent to-transparent"></div>
        
        <div class="relative z-10 max-w-[1200px] mx-auto px-8 w-full">
            <div class="max-w-3xl">
                <span class="text-[10px] font-black text-blue-400 uppercase tracking-[0.3em] mb-4 block">Archive Classification</span>
                <h1 class="text-7xl lg:text-9xl font-black text-white italic uppercase tracking-tighter mb-8 leading-none">
                    {{ $article->title }}
                </h1>
                <div class="flex items-center gap-6">
                    <a href="{{ route('wiki.edit', $article->slug) }}" class="px-8 py-3 bg-white text-black rounded-lg text-[10px] font-black uppercase tracking-widest hover:scale-105 transition-all flex items-center justify-center gap-3 relative overflow-hidden group">
                        <span class="relative z-10">Edit Classification</span>
                        <div class="w-4 h-4 rounded-full bg-blue-500/20 flex items-center justify-center relative z-10">
                            <div class="w-1.5 h-1.5 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.8)]"></div>
                        </div>
                    </a>
                    <div class="flex items-center gap-3 px-6 py-2 bg-white/5 border border-white/10 rounded-2xl">
                         <livewire:article.vote-button :model="$article" wire:key="vote-article-{{ $article->id }}" />
                         <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Protocol Tier</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENT AREA -->
    <div class="max-w-[1200px] mx-auto px-8 py-20">
        <div class="flex flex-col lg:flex-row gap-16">
            <div class="flex-1">
                <article class="prose prose-invert prose-lg max-w-none">
                    <div class="text-slate-300 leading-relaxed font-medium">
                        {!! Str::markdown($article->content) !!}
                    </div>
                </article>
                
                <section class="mt-20 pt-16 border-t border-white/5">
                    <livewire:article.comments :article="$article" />
                </section>
            </div>
            
            <div class="w-full lg:w-80">
                <div class="glass p-8 rounded-3xl border border-white/10 bg-[#0D0D1A]">
                    <h3 class="text-xl font-black text-white italic uppercase tracking-tighter mb-6">Quick Facts</h3>
                    <p class="text-slate-400 text-sm leading-relaxed mb-8">
                        This genre represents a core node in our music archive. Contributors are encouraged to document sub-genres and historical origins.
                    </p>
                    
                    <div class="space-y-4">
                        <livewire:article.play-button 
                            :articleId="$article->id" 
                            label="Listen to Audio Pulse"
                            class="w-full py-4 bg-blue-500 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:scale-[1.02] flex items-center justify-center gap-3 shadow-xl shadow-blue-500/20"
                        />

                        <x-article.⚡add-to-crate :article="$article" />

                        <div class="flex justify-between items-center py-3 border-b border-white/5">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Articles</span>
                            <span class="text-white font-bold">170</span>
                        </div>
                        <div class="flex justify-between items-center py-5">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Archive Utility</span>
                             <livewire:article.vote-button :model="$article" wire:key="sidebar-vote-article-{{ $article->id }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
