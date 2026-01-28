@extends('layouts.wiki')

@section('title', request('q') ? 'Search: ' . request('q') : 'Browse ' . ucfirst(request('category', 'Articles')))

@section('content')
<div class="relative min-h-screen bg-[#050511]">
    <!-- Background Decor (Consistent with Homepage) -->
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_var(--tw-gradient-stops))] from-brand-900/10 via-[#050511] to-[#050511]"></div>
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-[0.03]"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <!-- Figma Header: big query + results count -->
        <div class="text-center mb-16">
            <h1 class="text-6xl md:text-8xl font-display font-black text-white mb-4 tracking-tighter uppercase font-display">
                {{ $search ?? 'Browse' }}
            </h1>
            <p class="text-gray-500 font-mono text-xs uppercase tracking-[0.3em]">
                Total Results: {{ isset($results) ? sprintf('%02d', $results['total_count']) : (isset($articles) ? sprintf('%02d', $articles->total()) : '00') }}
            </p>
        </div>

        <!-- Filter Pill Bar -->
        <div class="flex flex-wrap justify-center gap-3 mb-20">
            <a href="{{ route('wiki.index', ['q' => $search]) }}" class="px-8 py-3 rounded-full border {{ !request('category') ? 'bg-brand-600 text-white border-brand-500 shadow-lg shadow-brand-500/20' : 'bg-white/5 text-gray-400 border-white/10 hover:bg-white/10 hover:text-white transition-all' }} font-bold text-sm">All</a>
            @foreach(['artist', 'song', 'genre', 'playlist'] as $cat)
                <a href="{{ route('wiki.index', ['q' => $search, 'category' => $cat]) }}" class="px-8 py-3 rounded-full border {{ request('category') == $cat ? 'bg-brand-600 text-white border-brand-500 shadow-lg shadow-brand-500/20' : 'bg-white/5 text-gray-400 border-white/10 hover:bg-white/10 hover:text-white transition-all' }} font-bold text-sm capitalize">{{ $cat }}s</a>
            @endforeach
        </div>

        @if(isset($results))
            <!-- Grouped Results View (Initial Search) -->
            <div class="space-y-32">
                @foreach(['song' => 'Songs', 'artist' => 'Artists', 'genre' => 'Genres'] as $key => $label)
                    @if($results[$key.'s']->count() > 0)
                        <section>
                            <div class="flex items-center justify-between mb-10 pb-6 border-b border-white/10">
                                <h2 class="text-2xl md:text-4xl font-display font-black text-white tracking-tight uppercase">{{ $label }} Matching "{{ $search }}"</h2>
                                <div class="flex gap-2">
                                    <button class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-white hover:bg-white/10 transition">&larr;</button>
                                    <button class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-white hover:bg-white/10 transition">&rarr;</button>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                @foreach($results[$key.'s'] as $topic)
                                    <!-- Card Component (Simplified for grid) -->
                                    <div class="group relative aspect-video rounded-3xl overflow-hidden bg-gray-900 border border-white/5 hover:border-brand-500/30 transition-all duration-500">
                                        @php
                                            $hasRealImage = $topic->featured_image && !str_contains($topic->featured_image, 'placehold.co');
                                            $fallbacks = ['images/card_electro.png', 'images/gods_plan.png', 'images/card_midnight.png', 'images/card_luna.png'];
                                            $fallback = $fallbacks[$loop->index % count($fallbacks)];
                                            $imagePath = $hasRealImage ? (str_starts_with($topic->featured_image, 'http') ? $topic->featured_image : Storage::url($topic->featured_image)) : asset($fallback);
                                        @endphp
                                        <img src="{{ $imagePath }}" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:opacity-80 transition duration-700">
                                        <div class="absolute inset-0 bg-gradient-to-t from-[#050511] via-[#050511]/40 to-transparent"></div>
                                        
                                        <!-- Card Footer Label -->
                                        <div class="absolute bottom-0 inset-x-0 p-6 z-10">
                                            <div class="flex items-center gap-2 mb-1">
                                                 <span class="text-brand-400 text-[10px] font-mono uppercase tracking-wider">{{ $topic->category }}</span>
                                                  @if($topic->category == 'song')
                                                    <span class="w-1 h-1 rounded-full bg-white/20"></span>
                                                    <span class="text-gray-400 text-[10px] font-mono italic">2024</span>
                                                  @endif
                                            </div>
                                            <h3 class="text-xl font-bold text-white mb-4 leading-tight group-hover:text-brand-300 transition-colors">
                                                {{ $topic->title }}
                                            </h3>
                                            
                                            <div class="flex items-center justify-between border-t border-white/10 pt-4">
                                                 <a href="{{ route('wiki.show', $topic->slug) }}" class="flex items-center gap-2 text-[11px] font-bold text-gray-400 hover:text-white transition-colors group/btn">
                                                    View Details 
                                                    <span class="w-5 h-5 rounded-full bg-brand-600 flex items-center justify-center text-white shadow-lg shadow-brand-500/20 group-hover/btn:scale-110 transition-transform">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                                    </span>
                                                 </a>
                                                 <div class="flex items-center gap-1.5 text-[10px] font-mono text-gray-500">
                                                    {{ number_format($topic->view_count) }} Views
                                                 </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endif
                @endforeach
            </div>
        @else
            <!-- Filtered/Paginated Results View -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">
                @forelse($articles as $topic)
                    <div class="group relative aspect-video rounded-3xl overflow-hidden bg-gray-900 border border-white/5 hover:border-brand-500/30 transition-all duration-500">
                        @php
                            $hasRealImage = $topic->featured_image && !str_contains($topic->featured_image, 'placehold.co');
                            $fallbacks = ['images/card_electro.png', 'images/gods_plan.png', 'images/card_midnight.png', 'images/card_luna.png'];
                            $fallback = $fallbacks[$loop->index % count($fallbacks)];
                            $imagePath = $hasRealImage ? (str_starts_with($topic->featured_image, 'http') ? $topic->featured_image : Storage::url($topic->featured_image)) : asset($fallback);
                        @endphp
                        <img src="{{ $imagePath }}" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:opacity-80 transition duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#050511] via-[#050511]/40 to-transparent"></div>
                        
                        <div class="absolute bottom-0 inset-x-0 p-6 z-10">
                            <div class="flex items-center gap-2 mb-1">
                                 <span class="text-brand-400 text-[10px] font-mono uppercase tracking-wider">{{ $topic->category }}</span>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-4 leading-tight group-hover:text-brand-300 transition-colors">
                                {{ $topic->title }}
                            </h3>
                            
                            <div class="flex items-center justify-between border-t border-white/10 pt-4">
                                 <a href="{{ route('wiki.show', $topic->slug) }}" class="flex items-center gap-2 text-[11px] font-bold text-gray-400 hover:text-white transition-colors group/btn">
                                    View Details 
                                    <span class="w-5 h-5 rounded-full bg-brand-600 flex items-center justify-center text-white shadow-lg shadow-brand-500/20 group-hover/btn:scale-110 transition-transform">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </span>
                                 </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-40 text-center rounded-[40px] bg-white/5 border border-dashed border-white/10">
                        <h3 class="text-3xl font-display font-black text-white mb-4 uppercase tracking-tighter">Negative sonic match</h3>
                        <p class="text-gray-500 max-w-xs mx-auto mb-10 leading-relaxed">The frequency you're searching for hasn't been mapped yet.</p>
                        <a href="{{ route('wiki.create') }}" class="inline-flex items-center gap-3 px-10 py-4 bg-brand-600 rounded-full text-white font-black uppercase tracking-widest hover:bg-brand-500 transition-all shadow-xl">Create Page +</a>
                    </div>
                @endforelse
            </div>

            <div class="mt-20">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

