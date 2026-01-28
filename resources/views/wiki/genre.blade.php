@extends('layouts.wiki')

@section('title', $article->title)

@section('content')
    <div class="relative pt-32 pb-12 bg-gray-900 border-b border-white/5">
        <div class="absolute inset-0 bg-[url('/images/grid.svg')] opacity-10"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto">
                <span class="text-brand-400 font-mono text-sm tracking-widest uppercase mb-4 block">Music Genre</span>
                <h1 class="text-6xl md:text-8xl font-display font-black text-white mb-6 uppercase tracking-tight">{{ $article->title }}</h1>
                <div class="flex items-center justify-center gap-4">
                    <a href="{{ route('wiki.edit', $article->slug) }}" class="inline-flex items-center gap-2 px-8 py-3 bg-white/5 border border-white/10 hover:bg-white/10 text-white font-bold rounded-full transition group">
                        <svg class="w-5 h-5 text-brand-400 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit Genre Facts
                    </a>
                    <livewire:article.bookmark-button :article="$article" />
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <article class="prose prose-invert prose-xl max-w-none">
            {!! $article->content !!}
        </article>
    </div>
@endsection
