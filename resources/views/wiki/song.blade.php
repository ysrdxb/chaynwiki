@extends('layouts.wiki')

@section('title', $article->title . ' - ' . ($article->song->artist->name ?? 'Artist'))

@push('seo')
    <meta property="og:title" content="{{ $article->title }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($article->content), 150) }}">
    <meta property="og:type" content="music.song">
    @if($article->featured_image)
        <meta property="og:image" content="{{ Storage::url($article->featured_image) }}">
    @endif
    
    @if($article->song && $article->song->artist && $article->song->spotify_id)
        <meta name="music:musician" content="{{ $article->song->artist->name ?? '' }}">
        <meta name="music:duration" content="{{ $article->song->duration ?? 0 }}">
    @endif
@endpush

@section('content')
    <!-- Hero Header -->
    <div class="relative h-[60vh] min-h-[500px] flex items-end pb-12 overflow-hidden">
        <!-- Background Image -->
        @if($article->featured_image)
            <img src="{{ Storage::url($article->featured_image) }}" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-[#050511] via-[#050511]/60 to-transparent"></div>
        @else
            <!-- Fallback Abstract Gradient -->
            <div class="absolute inset-0 bg-gradient-to-br from-blue-900/40 via-[#050511] to-purple-900/40"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#050511] via-[#050511]/60 to-transparent"></div>
        @endif

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="flex flex-col md:flex-row items-end gap-8">
                <!-- Cover Art -->
                <div class="w-48 h-48 md:w-64 md:h-64 rounded-xl shadow-2xl overflow-hidden border border-white/10 bg-gray-800 flex-shrink-0 relative group">
                     @if($article->featured_image)
                        <img src="{{ Storage::url($article->featured_image) }}" class="w-full h-full object-cover">
                    @else
                        <div class="flex items-center justify-center h-full text-white/20">
                            <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                        </div>
                    @endif
                    <!-- Spotify Play Button Overlay -->
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300 cursor-pointer">
                        <button class="w-16 h-16 rounded-full bg-green-500 text-black flex items-center justify-center hover:scale-105 transition shadow-lg">
                            <svg class="w-8 h-8 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Info -->
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2 text-sm font-bold tracking-widest uppercase">
                        <span class="text-blue-400">Song</span>
                        <span class="w-1 h-1 rounded-full bg-gray-500"></span>
                        <span class="text-gray-400">Updated {{ $article->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex items-center gap-4 mb-4">
                        <h1 class="text-5xl md:text-7xl font-display font-black text-white leading-tight shadow-black drop-shadow-lg">{{ $article->title }}</h1>
                        <div class="mt-4 flex items-center gap-4">
                             <livewire:article.vote-button :model="$article" />
                             <livewire:article.bookmark-button :article="$article" />
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-6 text-lg text-gray-300 font-medium">
                        @if($article->song && $article->song->artist)
                             <a href="{{ route('wiki.show', $article->song->artist->slug) }}" wire:navigate class="hover:text-white transition flex items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($article->song->artist->name ?? 'Artist') }}&background=random" class="w-8 h-8 rounded-full">
                                {{ $article->song->artist->name ?? 'Artist' }}
                             </a>
                        @endif
                         <span class="text-gray-600">•</span>
                         <span>{{ $article->song->release_date ?? 'Unknown Date' }}</span>
                         <span class="text-gray-600">•</span>
                         <span class="flex items-center gap-1"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> {{ number_format($article->song->stream_count ?? 0) }} Streams</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12 relative z-20">
        <div class="flex flex-col lg:flex-row gap-12">
            
            <!-- Left Column: Main Content -->
            <div class="flex-1 space-y-12">
                
                <!-- Description -->
                <section class="prose prose-invert prose-lg max-w-none">
                    <h2 class="text-3xl font-display font-bold text-white mb-6">About</h2>
                    <div class="bg-white/5 border border-white/5 rounded-3xl p-8 backdrop-blur-sm">
                        {!! $article->content !!}
                    </div>
                </section>

                <!-- Lyrics -->
                @if($article->song && $article->song->lyrics)
                <section>
                    <h2 class="text-3xl font-display font-bold text-white mb-6">Lyrics</h2>
                    <div class="bg-black/40 border border-white/5 rounded-3xl p-8 font-mono text-lg leading-relaxed text-gray-300 relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-4 opacity-50"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg></div>
                        {!! nl2br(e($article->song->lyrics)) !!}
                        
                        <!-- Fade Out for Long Lyrics (Expandable) -->
                        <div class="absolute bottom-0 inset-x-0 h-32 bg-gradient-to-t from-[#0A0A0A] to-transparent pointer-events-none"></div>
                        <div class="absolute bottom-8 left-1/2 -translate-x-1/2">
                            <button class="px-6 py-2 bg-white/10 hover:bg-white/20 rounded-full text-sm font-bold backdrop-blur-md transition">Expand Lyrics</button>
                        </div>
                    </div>
                </section>
                @endif
                
                <!-- Comments Section Placeholder -->
                 <section>
                    <h2 class="text-2xl font-display font-bold text-white mb-6">Discussion</h2>
                    <livewire:article.comments :article="$article" />
                </section>
            </div>

            <!-- Right Column: Sidebar -->
            <div class="w-full lg:w-96 space-y-8">
                
                <!-- Info Card -->
                <div class="bg-gray-900 border border-white/10 rounded-2xl p-6  sticky top-24">
                    <h3 class="text-xl font-bold text-white mb-4">Track Info</h3>
                    
                    <dl class="space-y-4 text-sm">
                        <div class="flex justify-between py-2 border-b border-white/5">
                            <dt class="text-gray-500">Album</dt>
                            <dd class="text-white font-medium text-right">{{ $article->song->album ?? 'Single' }}</dd>
                        </div>
                        <div class="flex justify-between py-2 border-b border-white/5">
                            <dt class="text-gray-500">Released</dt>
                            <dd class="text-white font-medium text-right">{{ $article->song->release_date ?? 'N/A' }}</dd>
                        </div>
                         <div class="flex justify-between py-2 border-b border-white/5">
                            <dt class="text-gray-500">Genre</dt>
                            <dd class="text-white font-medium text-right">{{ $article->genre ? $article->genre->name : 'N/A' }}</dd>
                        </div>
                        <div class="flex justify-between py-2 border-b border-white/5">
                            <dt class="text-gray-500">Producers</dt>
                            <dd class="text-white font-medium text-right">Max Martin, Oscar Holter</dd>
                        </div>
                         <div class="flex justify-between py-2 border-b border-white/5">
                            <dt class="text-gray-500">Label</dt>
                            <dd class="text-white font-medium text-right">XO / Republic</dd>
                        </div>
                    </dl>

                    <div class="mt-8">
                        <a href="{{ route('wiki.edit', $article->slug) }}" wire:navigate class="w-full py-3 bg-white text-black font-bold rounded-xl hover:bg-gray-200 transition mb-3 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Edit this Page
                        </a>
                         <button class="w-full py-3 bg-white/5 text-white font-bold rounded-xl hover:bg-white/10 transition flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            View History
                        </button>
                    </div>
                </div>

                <!-- Contributors -->
                <div>
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Top Contributors</h3>
                    <div class="flex -space-x-3 overflow-hidden">
                        <img class="inline-block h-10 w-10 rounded-full ring-2 ring-[#050511]" src="https://ui-avatars.com/api/?name=User+One&background=random" alt=""/>
                        <img class="inline-block h-10 w-10 rounded-full ring-2 ring-[#050511]" src="https://ui-avatars.com/api/?name=User+Two&background=random" alt=""/>
                        <img class="inline-block h-10 w-10 rounded-full ring-2 ring-[#050511]" src="https://ui-avatars.com/api/?name=User+Three&background=random" alt=""/>
                         <div class="h-10 w-10 rounded-full ring-2 ring-[#050511] bg-gray-800 flex items-center justify-center text-xs font-bold text-gray-400">+5</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
