@extends('layouts.wiki')

@section('title', $article->title)

@section('content')
<div class="min-h-screen bg-[#0d1117] flex justify-center">
    <div class="max-w-[1400px] w-full px-8 flex items-start gap-12 pt-32 pb-16">
        
        <!-- Sidebar Navigation (Simplified for Default) -->
@include('wiki._sidebar')

        <!-- Main Content -->
        <main class="flex-1 min-w-0">
             <!-- Top Action Row -->
             <div class="flex justify-between items-center mb-16">
                 <!-- Breadcrumbs -->
                 <nav class="flex items-center gap-2 text-[10px] font-bold text-white/30 tracking-[0.2em]">
                    <a href="{{ route('wiki.index') }}" class="hover:text-blue-400 transition-colors uppercase">All Topics</a>
                    <span>/</span>
                    <span class="text-white uppercase">{{ Str::limit($article->title, 30) }}</span>
                </nav>
            </div>

            <!-- Hero Section (Vertical Layout) -->
            <div class="relative w-full mb-24">
                 <!-- Text Content -->
                 <div class="relative z-10 w-full mb-12">
                     <!-- Title -->
                     <h1 class="text-soundbook-heading text-6xl sm:text-7xl md:text-8xl lg:text-[100px] text-white leading-[0.85] tracking-tighter mb-6 break-words">
                         {{ strtoupper($article->title) }}
                     </h1>
                     
                     <!-- Meta Data Row -->
                     <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-[13px] font-bold text-white/50 tracking-wide mb-8">
                         <span>Category: <span class="text-white">{{ ucfirst($article->category ?? 'General') }}</span></span>
                         <span class="w-1 h-1 rounded-full bg-white/20"></span>
                         <span>Updated: <span class="text-white">{{ optional($article->updated_at)->format('M d, Y') }}</span></span>
                     </div>
                 </div>
            </div>

            <div class="space-y-24">
                {{-- Content Section --}}
                <section>
                    <div class="flex items-center border-b border-white/5 pb-6 mb-10">
                        <div class="w-1.5 h-10 bg-blue-500 rounded-full mr-6 shadow-[0_0_15px_rgba(59,130,246,0.5)]"></div>
                        <h2 class="text-3xl font-black text-white tracking-tighter uppercase">Article Content</h2>
                    </div>
                    <article class="prose prose-invert prose-lg max-w-none">
                        <div class="article-content text-white/70 text-base leading-relaxed">
                            {!! $article->content !!}
                        </div>
                    </article>
                </section>

                {{-- Comments --}}
                <section>
                    <div class="flex items-center border-b border-white/5 pb-6 mb-10">
                        <div class="w-1.5 h-10 bg-purple-500 rounded-full mr-6 shadow-[0_0_15px_rgba(168,85,247,0.5)]"></div>
                        <h2 class="text-3xl font-black text-white tracking-tighter uppercase">Discussion</h2>
                    </div>
                    <div class="card-premium-unified !bg-[#161b22]/20 !p-12">
                         <livewire:article.comments :article="$article" />
                    </div>
                </section>
            </div>
        </main>
    </div>
</div>
@endsection
