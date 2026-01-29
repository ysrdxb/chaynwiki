@extends('layouts.wiki')

@section('title', $article->title . ' - ChaynWiki')

@section('head')
    {{-- Reading progress bar --}}
    <div class="reading-progress" id="reading-progress"></div>
    
    {{-- Print styles --}}
    <style media="print">
        .no-print { display: none !important; }
        .print-only { display: block !important; }
        body { background: white !important; color: black !important; }
        .article-content { max-width: 100% !important; }
    </style>
@endsection

@section('content')
    {{-- Hero Header --}}
    <div class="relative pt-32 pb-16 bg-gradient-to-b from-[#050511] to-[#0A0A14] border-b border-white/10">
        {{-- Background pattern --}}
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"60\" height=\"60\"><circle cx=\"30\" cy=\"30\" r=\"1\" fill=\"white\"/></svg>')"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl">
                {{-- Breadcrumb --}}
                <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6 no-print">
                    <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                    <span>/</span>
                    <a href="{{ route('wiki.index') }}" class="hover:text-white transition-colors">Wiki</a>
                    <span>/</span>
                    <span class="text-gray-400 capitalize">{{ $article->category }}</span>
                </nav>

                {{-- Category Badge --}}
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-brand-500/20 text-brand-400 text-xs font-mono uppercase tracking-widest mb-4">
                    @switch($article->category)
                        @case('artist') <span>🎤</span> @break
                        @case('song') <span>🎵</span> @break
                        @case('genre') <span>🎸</span> @break
                        @default <span>📄</span>
                    @endswitch
                    {{ $article->category }}
                </div>

                {{-- Title --}}
                <h1 class="text-4xl md:text-5xl font-display font-black text-white mb-6">
                    {{ $article->title }}
                </h1>

                {{-- Meta info --}}
                <div class="flex flex-wrap items-center gap-6 text-sm text-gray-400">
                    {{-- Author --}}
                    @if($article->user)
                        <a href="{{ route('profile', $article->user) }}" class="flex items-center gap-2 hover:text-white transition-colors">
                            <div class="w-8 h-8 rounded-full bg-brand-500/20 flex items-center justify-center text-brand-400 font-bold">
                                {{ strtoupper(substr($article->user->name, 0, 1)) }}
                            </div>
                            <span>{{ $article->user->name }}</span>
                        </a>
                    @endif

                    {{-- Date --}}
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ $article->updated_at->format('M d, Y') }}</span>
                    </div>

                    {{-- Views --}}
                    @if($article->view_count)
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <span>{{ number_format($article->view_count) }} views</span>
                        </div>
                    @endif
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-4 mt-8 no-print">
                    @auth
                        @if($article->user_id === auth()->id())
                            <a href="{{ route('wiki.edit', $article) }}" class="flex items-center gap-2 px-4 py-2 bg-brand-600 hover:bg-brand-500 text-white rounded-lg transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                <span>Edit</span>
                            </a>
                        @endif
                    @endauth

                    <x-social-share :article="$article" />
                    
                    {{-- Print button --}}
                    <button onclick="window.print()" class="w-9 h-9 rounded-lg bg-white/5 hover:bg-white/10 flex items-center justify-center text-gray-400 hover:text-white transition-all" title="Print">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content Area --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex gap-12">
            {{-- Article Content --}}
            <article class="flex-1 min-w-0">
                <div class="article-content prose prose-invert prose-lg max-w-none 
                    prose-headings:font-display prose-headings:font-bold
                    prose-h2:text-2xl prose-h2:mt-12 prose-h2:mb-4 prose-h2:border-b prose-h2:border-white/10 prose-h2:pb-3
                    prose-h3:text-xl prose-h3:mt-8 prose-h3:mb-3
                    prose-p:text-gray-300 prose-p:leading-relaxed
                    prose-a:text-brand-400 prose-a:no-underline hover:prose-a:underline
                    prose-strong:text-white
                    prose-code:text-pink-400 prose-code:bg-pink-500/10 prose-code:px-1.5 prose-code:py-0.5 prose-code:rounded
                    prose-pre:bg-[#0A0A14] prose-pre:border prose-pre:border-white/10
                    prose-blockquote:border-brand-500 prose-blockquote:bg-brand-500/5 prose-blockquote:py-1 prose-blockquote:rounded-r-lg
                    prose-img:rounded-xl prose-img:border prose-img:border-white/10
                    prose-li:text-gray-300
                ">
                    {!! $article->content !!}
                </div>

                {{-- Related Articles --}}
                <x-related-articles :article="$article" />

                {{-- Comments Section --}}
                <section class="mt-12 pt-12 border-t border-white/10 no-print">
                    <livewire:article.comments :article="$article" />
                </section>
            </article>

            {{-- Sidebar (TOC) --}}
            <aside class="hidden xl:block w-72 flex-shrink-0 no-print">
                <x-table-of-contents :content="$article->content" />
            </aside>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Reading progress indicator
    const progressBar = document.getElementById('reading-progress');
    if (progressBar) {
        window.addEventListener('scroll', () => {
            const scrollTop = window.scrollY;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const progress = (scrollTop / docHeight) * 100;
            progressBar.style.width = `${Math.min(progress, 100)}%`;
        });
    }
</script>
@endpush
