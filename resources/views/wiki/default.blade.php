@extends('layouts.wiki')

@section('title', $article->title)

@section('content')
    <div class="relative pt-32 pb-12 bg-black border-b border-white/5">
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-5xl font-display font-bold text-white mb-4">{{ $article->title }}</h1>
            <div class="flex items-center gap-4 text-sm text-gray-500">
                <span>{{ ucfirst($article->category) }}</span>
                <span>•</span>
                <span>Last updated {{ $article->updated_at->format('M d, Y') }}</span>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <article class="prose prose-invert max-w-none mb-12">
            {!! $article->content !!}
        </article>

        <section class="max-w-4xl">
             <livewire:article.comments :article="$article" />
        </section>
    </div>
@endsection
