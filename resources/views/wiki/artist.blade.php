@extends('layouts.wiki')

@section('title', $article->title)

@section('content')
    <!-- Hero Header -->
    <div class="relative h-[60vh] min-h-[500px] flex items-end pb-12 overflow-hidden">
        <!-- Background Image -->
        @if($article->featured_image)
            <img src="{{ Storage::url($article->featured_image) }}" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-[#050511] via-[#050511]/80 to-transparent"></div>
            <div class="absolute inset-0 bg-blue-900/20 mix-blend-overlay"></div>
        @else
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-indigo-900/40 via-[#050511] to-[#050511]"></div>
        @endif

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="flex flex-col md:flex-row items-end gap-8">
                <!-- Artist Avatar (Round) -->
                <div class="w-48 h-48 md:w-64 md:h-64 rounded-full shadow-2xl overflow-hidden border-4 border-white/10 bg-gray-800 flex-shrink-0 relative group">
                     @if($article->featured_image)
                        <img src="{{ Storage::url($article->featured_image) }}" class="w-full h-full object-cover">
                    @else
                        <div class="flex items-center justify-center h-full text-white/20">
                            <svg class="w-32 h-32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                    @endif
                </div>

                <!-- Info -->
                <div class="flex-1 mb-4">
                    <div class="flex items-center gap-3 mb-2 text-sm font-bold tracking-widest uppercase">
                        <span class="text-purple-400">Artist</span>
                        <span class="w-1 h-1 rounded-full bg-gray-500"></span>
                        <span class="text-gray-400">Updated {{ $article->updated_at->diffForHumans() }}</span>
                    </div>
                    <h1 class="text-6xl md:text-8xl font-display font-black text-white mb-6 leading-none shadow-black drop-shadow-lg">{{ $article->title }}</h1>
                    
                     <div class="flex flex-wrap items-center gap-4">
                        <a href="#" class="px-6 py-2 bg-white text-black font-bold rounded-full hover:bg-gray-200 transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg> Play Top Tracks
                        </a>
                        <button class="px-6 py-2 bg-white/10 hover:bg-white/20 text-white font-bold rounded-full transition backdrop-blur-md border border-white/10">
                            Follow Artist
                        </button>
                        <livewire:article.bookmark-button :article="$article" />
                         <div class="flex gap-2 ml-4">
                            <a href="#" class="p-2 text-gray-400 hover:text-white transition"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.948-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                                <a href="#" class="p-2 text-gray-400 hover:text-white transition"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                            </div>
                         </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12 relative z-20">
        <div class="flex flex-col lg:flex-row gap-12">
            
            <!-- Left Column: Biography -->
            <div class="flex-1 space-y-12">
                <section class="prose prose-invert prose-lg max-w-none">
                    <h2 class="text-3xl font-display font-bold text-white mb-6">Biography</h2>
                    <div class="bg-white/5 border border-white/5 rounded-3xl p-8 backdrop-blur-sm">
                        {!! $article->content !!}
                    </div>
                </section>

                <!-- Discography Section -->
                <section>
                    <h2 class="text-3xl font-display font-bold text-white mb-6">Discography</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <!-- Placeholder Entries for Discography -->
                         <div class="group bg-gray-900 rounded-xl overflow-hidden border border-white/5 hover:border-white/20 transition">
                            <div class="aspect-square bg-gray-800 relative">
                                <!-- Placeholder Image -->
                                <div class="absolute inset-0 bg-gradient-to-tr from-gray-800 to-gray-700"></div>
                            </div>
                            <div class="p-4">
                                <h4 class="font-bold text-white truncate group-hover:text-brand-400 transition">Album Title</h4>
                                <p class="text-xs text-gray-500">2024</p>
                            </div>
                         </div>
                          <div class="group bg-gray-900 rounded-xl overflow-hidden border border-white/5 hover:border-white/20 transition">
                            <div class="aspect-square bg-gray-800 relative">
                                <div class="absolute inset-0 bg-gradient-to-tr from-gray-800 to-gray-700"></div>
                            </div>
                            <div class="p-4">
                                <h4 class="font-bold text-white truncate group-hover:text-brand-400 transition">Another Album</h4>
                                <p class="text-xs text-gray-500">2022</p>
                            </div>
                         </div>
                    </div>
                </section>

                <!-- Discussion Section -->
                <section>
                    <livewire:article.comments :article="$article" />
                </section>
            </div>

            <!-- Sidebar -->
            <div class="w-full lg:w-80 space-y-8">
                 <!-- Artist Facts -->
                <div class="bg-gray-900 border border-white/10 rounded-2xl p-6 sticky top-24">
                    <h3 class="text-xl font-bold text-white mb-4">Artist Facts</h3>
                     <dl class="space-y-4 text-sm">
                        <div class="flex justify-between py-2 border-b border-white/5">
                            <dt class="text-gray-500">Origin</dt>
                            <dd class="text-white font-medium text-right">Toronto, Canada</dd>
                        </div>
                        <div class="flex justify-between py-2 border-b border-white/5">
                            <dt class="text-gray-500">Active</dt>
                            <dd class="text-white font-medium text-right">2010 - Present</dd>
                        </div>
                         <div class="flex justify-between py-2 border-b border-white/5">
                            <dt class="text-gray-500">Labels</dt>
                            <dd class="text-white font-medium text-right">XO, Republic</dd>
                        </div>
                    </dl>
                    
                    <div class="mt-8 pt-6 border-t border-white/10">
                         <a href="{{ route('wiki.edit', $article->slug) }}" class="w-full py-2 bg-white/5 text-white font-bold rounded-xl hover:bg-white/10 transition mb-3 flex items-center justify-center">
                            Edit Biography
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
