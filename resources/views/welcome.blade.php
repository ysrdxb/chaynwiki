@extends('layouts.wiki')

@section('title', 'ChaynWiki — Your Community-Driven Music Encyclopedia')

@push('styles')
<style>
    /* Final Figma refinements */
    .btn-figma-primary:hover, .btn-figma-secondary:hover {
        transform: translateY(-2px);
    }
    
    /* Figma-accurate letter spacing */
    .tracking-tighter {
        letter-spacing: -0.03em !important;
    }
</style>
@endpush

@section('content')
    {{-- Background Blobs --}}
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-[#3b82f6]/10 blur-[120px] rounded-full"></div>
        <div class="absolute bottom-[10%] right-[-10%] w-[30%] h-[30%] bg-purple-600/10 blur-[120px] rounded-full"></div>
        <div class="absolute top-[40%] right-[10%] w-[20%] h-[20%] bg-[#3b82f6]/5 blur-[100px] rounded-full"></div>
    </div>

    {{-- =========================================
         HERO SECTION - FIGMA STYLE (LEFT-ALIGNED)
         ========================================= --}}
    {{-- =========================================
         HERO SECTION - FIGMA STYLE (LEFT-ALIGNED)
         ========================================= --}}
    <section class="pt-32 pb-16 bg-[#0d1117] relative z-10 overflow-hidden">
        <div class="max-w-[1400px] mx-auto px-8">
            {{-- Title - Left aligned --}}
            <h1 class="text-[48px] md:text-[64px] font-black text-white uppercase leading-[1.1] tracking-tight mb-4" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                YOUR COMMUNITY-DRIVEN<br>
                MUSIC ENCYCLOPEDIA
            </h1>
            
            {{-- Subtitle --}}
            <p class="text-white/50 text-[14px] font-medium mb-10" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                We are not affiliated with SoundCloud / Spotify.
            </p>
            
            {{-- Search Bar - Pill Style --}}
            <form action="{{ route('search') }}" method="GET" class="max-w-[800px] mb-8">
                <div class="flex items-center bg-[#1c2128] border border-white/10 rounded-full p-1.5 focus-within:border-white/20 transition-all">
                    <input 
                        type="text" 
                        name="q" 
                        placeholder="Search for a song, artist, or genre..." 
                        class="flex-1 bg-transparent border-none focus:ring-0 text-white placeholder-white/20 px-6 py-3 text-[15px]"
                        style="font-family: 'Plus Jakarta Sans', sans-serif;"
                    >
                    <button type="submit" class="flex items-center gap-2 px-6 py-3 bg-white hover:bg-gray-100 text-[#0d1117] text-[14px] font-bold rounded-full transition-all" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        Search
                        <div class="w-5 h-5 bg-[#3b82f6] rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                    </button>
                </div>
            </form>

            {{-- Action Buttons --}}
            <div class="flex flex-wrap items-center gap-4 mb-16">
                <a href="{{ route('wiki.create') }}" class="btn-figma-primary group">
                    <span>Contribute a topic</span>
                    <div class="w-5 h-5 bg-[#3b82f6] rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </div>
                </a>
                
                <a href="{{ route('wiki.index') }}" class="btn-figma-secondary group">
                    <span>Browse categories</span>
                    <div class="w-5 h-5 bg-white/10 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </div>
                </a>
            </div>

            {{-- Quick Action Strip --}}
            <div class="flex flex-col gap-4">
                <span class="text-white/30 text-[11px] font-bold uppercase tracking-widest">Quick action strip</span>
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('wiki.index', ['category' => 'genre']) }}" class="action-pill">
                        <div class="pill-icon"></div>
                        Genres
                    </a>
                    <a href="{{ route('wiki.index', ['category' => 'artist']) }}" class="action-pill">
                        <div class="pill-icon"></div>
                        Artists
                    </a>
                    <a href="{{ route('wiki.index', ['sort' => 'recent']) }}" class="action-pill">
                        <div class="pill-icon"></div>
                        Most Changes
                    </a>
                    <a href="{{ route('leaderboard') }}" class="action-pill">
                        <div class="pill-icon"></div>
                        Leaderboard
                    </a>
                    <a href="{{ route('wiki.generate') }}" class="action-pill">
                        <div class="pill-icon bg-purple-500"></div>
                        AI Generator
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- =========================================
         NEW TOPICS SECTION - FIGMA DESIGN
         ========================================= --}}
    <section class="section-unified py-24 bg-[#0d1117] border-t border-white/5 relative z-10 overflow-hidden" 
        x-data="{ 
            canScrollLeft: false, 
            canScrollRight: true,
            checkScroll() {
                let s = this.$refs.newTopicsSlider;
                this.canScrollLeft = s.scrollLeft > 0;
                this.canScrollRight = s.scrollLeft + s.offsetWidth < s.scrollWidth - 2;
            },
            sliderScroll(amount) {
                this.$refs.newTopicsSlider.scrollBy({ left: amount, behavior: 'smooth' });
                setTimeout(() => this.checkScroll(), 350);
            }
        }" x-init="checkScroll()">
        <div class="max-w-[1400px] mx-auto px-8">
            <div class="flex items-end justify-between mb-12">
                <div class="max-w-2xl">
                    <h2 class="section-title mb-2">New topics</h2>
                    <p class="section-subtitle">Recently added by the community</p>
                </div>
                
                {{-- Navigation Arrows - Figma Style --}}
                <div class="hidden md:flex items-center gap-3">
                    <button @click="sliderScroll(-400)" :class="canScrollLeft ? 'text-white border-white/20' : 'text-white/10 border-white/5 cursor-not-allowed'" class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center transition-all bg-transparent hover:border-white/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button @click="sliderScroll(400)" :class="canScrollRight ? 'text-white border-white/20' : 'text-white/10 border-white/5 cursor-not-allowed'" class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center transition-all bg-transparent hover:border-white/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            {{-- Slider Container --}}
            <div class="overflow-x-auto scrollbar-hide -mx-8 px-8" x-ref="newTopicsSlider" @scroll="checkScroll()" style="scrollbar-width: none; -ms-overflow-style: none;">
                <div class="flex gap-6 pb-8">
                    @foreach($newTopicCards as $index => $topic)
                    <div class="card-premium-unified min-w-[340px] md:min-w-[420px] p-0 border-none group bg-transparent">
                        <a href="{{ $topic['url'] }}" class="block h-full">
                            {{-- Image --}}
                            <div class="relative aspect-video rounded-2xl overflow-hidden mb-6">
                                @if($topic['image'])
                                    <img src="{{ $topic['image'] }}" class="w-full h-full object-cover grayscale-[0.2] group-hover:grayscale-0 group-hover:scale-105 transition-all duration-700" alt="{{ $topic['title'] }}">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-900/40 to-black flex items-center justify-center">
                                        <svg class="w-12 h-12 text-white/10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                    </div>
                                @endif
                                {{-- Genre Label inside image --}}
                                <div class="absolute top-4 left-4">
                                    <span class="text-blue-400 text-[10px] font-black uppercase tracking-[0.2em] bg-black/40 backdrop-blur-md px-3 py-1 rounded">{{ $topic['category'] }}</span>
                                </div>
                            </div>

                            {{-- Text Content --}}
                            <div class="px-2">
                                <h3 class="text-white text-[24px] font-bold tracking-tight mb-2 group-hover:text-blue-400 transition-colors">
                                    {{ $topic['title'] }}
                                </h3>
                                <p class="text-white/40 text-[14px] font-medium leading-relaxed mb-6 line-clamp-2">
                                    {{ $topic['desc'] ?? 'A unique exploration of musical landscapes and cultural influences shaping the industry today.' }}
                                </p>
                                
                                {{-- Metadata Row --}}
                                <div class="flex items-center gap-4 text-white/30 text-[12px] font-bold">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-blue-500/20 flex items-center justify-center overflow-hidden border border-white/5">
                                            <span class="text-[10px] text-blue-400 uppercase">{{ substr($topic['user'] ?? 'CW', 0, 1) }}</span>
                                        </div>
                                        <span class="text-white/50">{{ $topic['user'] }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 ml-auto">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <span>{{ number_format($topic['views']) }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span>8</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>



    {{-- =========================================
         REAL-TIME MUSIC WEATHER - DYNAMIC RADAR
         ========================================= --}}
    @php
        $radarData = $musicWeather ?? [
            'viral_artists' => 70,
            'trending_songs' => 85,
            'declining_trends' => 40,
            'rising_genres' => 60,
        ];

        // Calculate pentagon points
        $centerX = 200; $centerY = 200; $maxRadius = 140;
        $getPoint = function($angle, $value) use ($centerX, $centerY, $maxRadius) {
            $radius = ($value / 100) * $maxRadius;
            $radian = deg2rad($angle - 90);
            $x = $centerX + $radius * cos($radian);
            $y = $centerY + $radius * sin($radian);
            return ['x' => round($x), 'y' => round($y)];
        };
        $angles = [0, 72, 144, 216, 288];
        $values = [$radarData['viral_artists'], $radarData['trending_songs'], $radarData['declining_trends'], $radarData['declining_trends'], $radarData['rising_genres']];
        $points = []; $pointCoords = [];
        foreach ($angles as $i => $angle) {
            $point = $getPoint($angle, $values[$i]);
            $points[] = $point['x'] . ',' . $point['y'];
            $pointCoords[] = $point;
        }
        $polygonPoints = implode(' ', $points);
    @endphp

    <section class="section-unified py-24 bg-[#0d1117] border-t border-white/5 relative z-10" 
             x-data="{ active: 'rising', hovered: null, animateIn: false }" 
             x-init="setTimeout(() => animateIn = true, 300)">
        <div class="max-w-[1400px] mx-auto px-8">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                {{-- Left: Radar Visualization --}}
                <div class="w-full lg:w-1/2 relative bg-[#161b22]/40 rounded-[40px] p-12 border border-white/5 overflow-hidden">
                    {{-- Decore background --}}
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-blue-500/5 via-transparent to-transparent opacity-50"></div>

                    <div class="relative z-10 mb-10 text-center lg:text-left">
                        <h2 class="text-[40px] md:text-[56px] font-black text-white uppercase tracking-tighter leading-[0.9] mb-4" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            Real-Time <br/>Music Weather
                        </h2>
                        <p class="text-white/40 text-[18px] font-medium leading-relaxed" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            A live visualization of musical trends and community momentum.
                        </p>
                    </div>

                    <div class="relative w-full max-w-[400px] mx-auto z-10">
                        <svg viewBox="0 0 400 400" class="w-full h-auto drop-shadow-[0_0_30px_rgba(59,130,246,0.1)]">
                            {{-- Concentric Rings --}}
                            <g stroke="white" fill="none" opacity="0.03">
                                <circle cx="200" cy="200" r="140" stroke-width="1"/>
                                <circle cx="200" cy="200" r="105" stroke-width="1"/>
                                <circle cx="200" cy="200" r="70" stroke-width="1"/>
                                <circle cx="200" cy="200" r="35" stroke-width="1"/>
                            </g>
                            
                            {{-- Grid Lines --}}
                            <g stroke="white" stroke-width="1" opacity="0.03">
                                @foreach($angles as $angle)
                                    @php $p = $getPoint($angle, 100); @endphp
                                    <line x1="200" y1="200" x2="{{ $p['x'] }}" y2="{{ $p['y'] }}"/>
                                @endforeach
                            </g>

                            {{-- Animated Data Polygon --}}
                            <polygon 
                                points="{{ $polygonPoints }}" 
                                fill="url(#radarGradient)" 
                                stroke="#3b82f6" 
                                stroke-width="2"
                                opacity="0.4"
                                class="transition-all duration-1000"
                                :class="animateIn ? 'opacity-40' : 'opacity-0'"
                                style="transform-origin: center; transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);"
                            />
                            
                            {{-- Gradient definition --}}
                            <defs>
                                <linearGradient id="radarGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#3b82f6;stop-opacity:0.6"/>
                                    <stop offset="100%" style="stop-color:#a855f7;stop-opacity:0.3"/>
                                </linearGradient>
                            </defs>
                            
                            {{-- Interactive Data Points --}}
                            <g class="cursor-pointer">
                                {{-- Viral Artists (Top) --}}
                                <circle 
                                    cx="{{ $pointCoords[0]['x'] }}" cy="{{ $pointCoords[0]['y'] }}" r="8" 
                                    fill="#ec4899"
                                    @mouseenter="hovered = 'viral'"
                                    @mouseleave="hovered = null"
                                    @click="active = 'viral'"
                                    :r="active === 'viral' || hovered === 'viral' ? 12 : 6"
                                    class="transition-all duration-300"
                                />

                                {{-- Trending Songs (Top-Right) --}}
                                <circle 
                                    cx="{{ $pointCoords[1]['x'] }}" cy="{{ $pointCoords[1]['y'] }}" r="8" 
                                    fill="#22d3ee"
                                    @mouseenter="hovered = 'trending'"
                                    @mouseleave="hovered = null"
                                    @click="active = 'trending'"
                                    :r="active === 'trending' || hovered === 'trending' ? 12 : 6"
                                    class="transition-all duration-300"
                                />

                                {{-- Declining (Bottom-Right) --}}
                                <circle 
                                    cx="{{ $pointCoords[2]['x'] }}" cy="{{ $pointCoords[2]['y'] }}" r="8" 
                                    fill="#f472b6"
                                    @mouseenter="hovered = 'declining'"
                                    @mouseleave="hovered = null"
                                    @click="active = 'declining'"
                                    :r="active === 'declining' || hovered === 'declining' ? 12 : 6"
                                    class="transition-all duration-300"
                                />

                                {{-- Rising Genres (Top-Left) --}}
                                <circle 
                                    cx="{{ $pointCoords[4]['x'] }}" cy="{{ $pointCoords[4]['y'] }}" r="8" 
                                    fill="#3b82f6"
                                    @mouseenter="hovered = 'rising'"
                                    @mouseleave="hovered = null"
                                    @click="active = 'rising'"
                                    :r="active === 'rising' || hovered === 'rising' ? 12 : 6"
                                    class="transition-all duration-300"
                                />
                            </g>
                        </svg>
                        
                        {{-- Labels around the radar --}}
                        <div class="absolute -top-2 left-1/2 -translate-x-1/2 text-center">
                            <span class="text-white text-[11px] font-black uppercase tracking-widest cursor-pointer transition-all" 
                                  @click="active = 'viral'"
                                  :class="active === 'viral' ? 'text-pink-400 opacity-100' : 'opacity-20'">Viral</span>
                        </div>
                        <div class="absolute top-1/2 -right-12 -translate-y-1/2">
                            <span class="text-white text-[11px] font-black uppercase tracking-widest cursor-pointer transition-all block rotate-90"
                                  @click="active = 'trending'"
                                  :class="active === 'trending' ? 'text-cyan-400 opacity-100' : 'opacity-20'">Trending</span>
                        </div>
                        <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 text-center">
                            <span class="text-white text-[11px] font-black uppercase tracking-widest cursor-pointer transition-all"
                                  @click="active = 'declining'"
                                  :class="active === 'declining' ? 'text-pink-300 opacity-100' : 'opacity-20'">Declining</span>
                        </div>
                        <div class="absolute top-1/2 -left-12 -translate-y-1/2">
                            <span class="text-white text-[11px] font-black uppercase tracking-widest cursor-pointer transition-all block -rotate-90"
                                  @click="active = 'rising'"
                                  :class="active === 'rising' ? 'text-blue-500 opacity-100' : 'opacity-20'">Rising</span>
                        </div>
                    </div>
                </div>

                {{-- Right: Info Cards --}}
                <div class="w-full lg:w-1/2 grid grid-cols-1 gap-4">
                    {{-- Rising Genres Card --}}
                    <div @mouseenter="active = 'rising'" 
                         class="bg-[#161b22]/60 border border-white/5 rounded-[20px] p-6 flex items-center justify-between transition-all duration-300 cursor-pointer group hover:border-white/10"
                         :class="active === 'rising' ? 'bg-[#1c2128]' : ''">
                        <div class="flex items-center gap-5">
                            <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white shadow-lg shadow-blue-500/20">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            </div>
                            <div>
                                <h4 class="text-white text-[18px] font-bold tracking-tight">Rising Genres</h4>
                                <p class="text-white/40 text-[13px]">Musical styles gaining momentum globally.</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-white/20 group-hover:text-white/40 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </div>

                    {{-- Viral Artists Card --}}
                    <div @mouseenter="active = 'viral'" 
                         class="bg-[#161b22]/60 border border-white/5 rounded-[20px] p-6 flex items-center justify-between transition-all duration-300 cursor-pointer group hover:border-white/10"
                         :class="active === 'viral' ? 'bg-[#1c2128]' : ''">
                        <div class="flex items-center gap-5">
                            <div class="w-10 h-10 rounded-full bg-pink-500 flex items-center justify-center text-white shadow-lg shadow-pink-500/20">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-white text-[18px] font-bold tracking-tight">Viral Artists</h4>
                                <p class="text-white/40 text-[13px]">Creators EXPERIENCING sudden spikes in attention.</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-white/20 group-hover:text-white/40 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </div>

                    {{-- Trending Songs Card --}}
                    <div @mouseenter="active = 'trending'" 
                         class="bg-[#161b22]/60 border border-white/5 rounded-[20px] p-6 flex items-center justify-between transition-all duration-300 cursor-pointer group hover:border-white/10"
                         :class="active === 'trending' ? 'bg-[#1c2128]' : ''">
                        <div class="flex items-center gap-5">
                            <div class="w-10 h-10 rounded-full bg-cyan-500 flex items-center justify-center text-white shadow-lg shadow-cyan-500/20">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 14 14"><path fill="currentColor" d="M2.5 0A2.5 2.5 0 0 0 0 2.5v9A2.5 2.5 0 0 0 2.5 14h9a2.5 2.5 0 0 0 2.5-2.5v-9A2.5 2.5 0 0 0 11.5 0h-9ZM11 5H3V4h8v1Zm0 3H3V7h8v1Zm-5 3H3v-1h3v1Z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-white text-[18px] font-bold tracking-tight">Trending Songs</h4>
                                <p class="text-white/40 text-[13px]">Most played and shared tracks right now.</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-white/20 group-hover:text-white/40 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </div>

                    {{-- Declining Trends Card --}}
                    <div @mouseenter="active = 'declining'" 
                         class="bg-[#161b22]/60 border border-white/5 rounded-[20px] p-6 flex items-center justify-between transition-all duration-300 cursor-pointer group hover:border-white/10"
                         :class="active === 'declining' ? 'bg-[#1c2128]' : ''">
                        <div class="flex items-center gap-5">
                            <div class="w-10 h-10 rounded-full bg-purple-500 flex items-center justify-center text-white shadow-lg shadow-purple-500/20">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"/></svg>
                            </div>
                            <div>
                                <h4 class="text-white text-[18px] font-bold tracking-tight">Declining trends</h4>
                                <p class="text-white/40 text-[13px]">Fading popularity and saturation points.</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-white/20 group-hover:text-white/40 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- =========================================
         BROWSE BY CATEGORY - CARD GRID
         ========================================= --}}
    @php
        $categories = [
            [
                'key' => 'genre',
                'title' => 'Genres',
                'desc' => 'Discover music styles, their origins, key pioneers, and how they evolved over time.',
                'count' => number_format($heroStats['genres'] ?? 0) . ' topics',
                'url' => route('wiki.index', ['category' => 'genre']),
            ],
            [
                'key' => 'artist',
                'title' => 'Artists',
                'desc' => 'Browse detailed artist profiles, bios, discographies, and related collaborations.',
                'count' => number_format($musicWeather['raw']['viral_artists'] ?? 0) . ' artists',
                'url' => route('wiki.index', ['category' => 'artist']),
            ],
            [
                'key' => 'song',
                'title' => 'Songs',
                'desc' => 'Lyrics, release dates, credits, streaming stats, and behind-the-music insights.',
                'count' => number_format($musicWeather['raw']['trending_songs'] ?? 0) . ' songs',
                'url' => route('wiki.index', ['category' => 'song']),
            ],
            [
                'key' => 'playlist',
                'title' => 'Playlists',
                'desc' => 'Curated lists of tracks for every mood, genre, or occasion.',
                'count' => number_format($categoryCounts->where('category', 'playlist')->first()->total ?? 0) . ' playlists',
                'url' => route('wiki.index', ['category' => 'playlist']),
            ],
            [
                'key' => 'term',
                'title' => 'Terminology',
                'desc' => 'Essential music terms, theory, equipment, and industry lingo.',
                'count' => number_format($categoryCounts->where('category', 'term')->first()->total ?? 0) . ' terms',
                'url' => route('wiki.index', ['category' => 'term']),
            ],
        ];
    @endphp

    <section class="section-unified py-24 bg-[#0d1117] border-t border-white/5 relative z-10 overflow-hidden">
        <div class="max-w-[1400px] mx-auto px-8">
            <div class="flex items-end justify-between mb-16">
                <div class="max-w-2xl">
                    <h2 class="section-title mb-2">Browse by category</h2>
                    <p class="section-subtitle">Discover our database with everything you need to know about music culture.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach(array_slice($categories, 0, 3) as $cat)
                <div class="card-premium-unified p-8 bg-[#161b22]/60 border border-white/5 group">
                    <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center text-white mb-8 shadow-lg shadow-blue-500/10">
                        @if($cat['key'] == 'genre')
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                        @elseif($cat['key'] == 'artist')
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        @else
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/></svg>
                        @endif
                    </div>
                    
                    <h3 class="text-white text-[24px] font-bold tracking-tight mb-4">{{ $cat['title'] }}</h3>
                    <p class="text-white/40 text-[15px] font-medium leading-relaxed mb-10">{{ $cat['desc'] }}</p>
                    
                    <div class="flex items-center justify-between mt-auto">
                        <span class="text-white/20 text-[12px] font-bold uppercase tracking-widest">{{ $cat['count'] }}</span>
                        <a href="{{ $cat['url'] }}" class="flex items-center gap-3 px-6 py-2 bg-white/5 border border-white/5 rounded-full text-white text-[13px] font-bold group-hover:bg-blue-500 group-hover:border-blue-500 transition-all">
                            <span>Explore</span>
                            <div class="w-5 h-5 bg-blue-500 rounded-full flex items-center justify-center group-hover:bg-white/20 transition-all">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section-unified py-24 bg-[#0d1117] border-t border-white/5 relative z-10 overflow-hidden">
        <div class="max-w-[1400px] mx-auto px-8">
            <div class="mb-12 max-w-2xl">
                <h2 class="section-title mb-2">Discover what's shaping today's music</h2>
                <p class="section-subtitle">Real-time trending topics and community favorites.</p>
            </div>

            {{-- Dynamic Trending Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($trendingArticles as $index => $article)
                <a href="{{ route('wiki.show', $article->slug) }}" class="group relative overflow-hidden rounded-[24px] border border-white/5 bg-[#161b22]/40 backdrop-blur-sm p-8 hover:border-blue-500/30 hover:bg-[#161b22]/60 hover:shadow-lg hover:shadow-blue-500/10 transition-all duration-300">
                    <div class="mb-6 flex justify-between items-start">
                        <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center group-hover:bg-blue-500 transition-colors">
                            @if($article->category === 'artist')
                                <svg class="w-6 h-6 text-blue-500 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            @elseif($article->category === 'song')
                                <svg class="w-6 h-6 text-blue-500 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                            @elseif($article->category === 'genre')
                                <svg class="w-6 h-6 text-blue-500 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            @else
                                <svg class="w-6 h-6 text-blue-500 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            @endif
                        </div>
                        
                        <div class="px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[10px] font-black uppercase tracking-widest">
                            #{{ $index + 1 }} Trending
                        </div>
                    </div>
                    
                    <h3 class="text-white text-[24px] font-black uppercase tracking-tighter mb-2 group-hover:text-blue-400 transition-colors line-clamp-1">{{ $article->title }}</h3>
                    <p class="text-white/50 text-[14px] font-medium mb-4 line-clamp-2">
                        {{ $article->meta_description ?? 'Join the community discussion about ' . $article->title . ' and discover what makes it trend.' }}
                    </p>
                    
                    <div class="flex items-center gap-4 text-white/30 text-[12px] font-bold">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
                            {{ number_format($article->view_count) }}
                        </span>
                        <span class="flex items-center gap-1.5 ml-auto text-blue-400">
                             Explore
                             <svg class="w-3 h-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>


    {{-- =========================================
         RANKED ARTICLES SECTION - FIGMA DESIGN
         ========================================= --}}
    <section class="section-unified py-24 bg-[#0d1117] border-t border-white/5 relative z-10 overflow-hidden">
        <div class="max-w-[1400px] mx-auto px-8" x-data="{
            canScrollLeft: false,
            canScrollRight: true,
            checkScroll() {
                let s = this.$refs.rankedSlider;
                this.canScrollLeft = s.scrollLeft > 0;
                this.canScrollRight = s.scrollLeft + s.offsetWidth < s.scrollWidth - 2;
            },
            sliderScroll(amount) {
                this.$refs.rankedSlider.scrollBy({ left: amount, behavior: 'smooth' });
                setTimeout(() => this.checkScroll(), 350);
            }
        }" x-init="checkScroll()">
            <div class="flex items-end justify-between mb-12">
                <div class="max-w-2xl">
                    <h2 class="section-title mb-2">Ranked articles</h2>
                    <p class="section-subtitle">Discover the top-rated and most influential archives according to our community rankings.</p>
                </div>
                
                <div class="hidden md:flex items-center gap-3">
                    <button @click="sliderScroll(-400)" :class="canScrollLeft ? 'text-white border-white/20' : 'text-white/10 border-white/5 cursor-not-allowed'" class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center transition-all bg-transparent hover:border-white/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button @click="sliderScroll(400)" :class="canScrollRight ? 'text-white border-white/20' : 'text-white/10 border-white/5 cursor-not-allowed'" class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center transition-all bg-transparent hover:border-white/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto scrollbar-hide -mx-8 px-8" x-ref="rankedSlider" @scroll="checkScroll()" style="scrollbar-width: none; -ms-overflow-style: none;">
                <div class="flex gap-6 pb-8">
                    @foreach($rankedArticles as $index => $article)
                    <div class="card-premium-unified min-w-[340px] md:min-w-[420px] p-0 border-none group bg-transparent">
                        <a href="{{ route('wiki.show', $article->slug) }}" class="block h-full">
                            <div class="relative aspect-video rounded-2xl overflow-hidden mb-6">
                                @if($article->image_url)
                                    <img src="{{ $article->image_url }}" class="w-full h-full object-cover grayscale-[0.2] group-hover:grayscale-0 group-hover:scale-105 transition-all duration-700" alt="{{ $article->title }}">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-900/40 to-black flex items-center justify-center">
                                        <svg class="w-12 h-12 text-white/10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                    </div>
                                @endif
                                
                                {{-- Rank Number overlay --}}
                                <div class="absolute top-4 left-4">
                                    <span class="text-white text-[24px] font-black opacity-30 shadow-text">0{{ $index + 1 }}</span>
                                </div>
                                {{-- Genre label --}}
                                <div class="absolute top-4 right-4">
                                    <span class="text-blue-400 text-[10px] font-black uppercase tracking-[0.2em] bg-black/40 backdrop-blur-md px-3 py-1 rounded">{{ $article->category }}</span>
                                </div>
                            </div>

                            <div class="px-2">
                                <h3 class="text-white text-[24px] font-bold tracking-tight mb-2 group-hover:text-blue-400 transition-colors">{{ $article->title }}</h3>
                                <p class="text-white/40 text-[14px] font-medium leading-relaxed mb-6 line-clamp-2">The definitive community archive exploring the depth of {{ strtolower($article->title) }}.</p>
                                
                                <div class="flex items-center gap-4 text-white/30 text-[12px] font-bold">
                                    <div class="flex items-center gap-1.5 bg-white/5 px-3 py-1 rounded-full border border-white/5">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <span class="text-white/50">{{ number_format($article->view_count) }} views</span>
                                    </div>
                                    <div class="ml-auto flex items-center gap-2">
                                        <span class="text-white/20 uppercase tracking-widest text-[10px]">Score</span>
                                        <span class="text-blue-400 font-bold">{{ $article->seo_score ?? 95 }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- =========================================
         COMMUNITY INSIGHTS - FIGMA DESIGN
         ========================================= --}}
    <section class="section-unified py-24 bg-[#0d1117] border-t border-white/5 relative z-10">
        <div class="max-w-[1400px] mx-auto px-8">
            <div class="mb-12 max-w-2xl">
                <h2 class="section-title mb-2">Community insights</h2>
                <p class="section-subtitle">Real-time metrics on how the community is expanding the global music knowledge base.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Stat Card 1 --}}
                <div class="card-premium-unified bg-[#161b22]/60 border border-white/5 p-8 flex flex-col min-h-[200px]">
                    <span class="text-white/40 text-[12px] font-bold uppercase tracking-widest mb-6">Total contributors</span>
                    <div class="text-[48px] font-black text-white leading-none tracking-tighter mb-auto">25,000+</div>
                    <div class="flex justify-end">
                        <div class="w-10 h-10 rounded-full bg-blue-500/10 border border-white/10 flex items-center justify-center group-hover:bg-blue-500 transition-all">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                    </div>
                </div>

                {{-- Stat Card 2 --}}
                <div class="card-premium-unified bg-[#161b22]/60 border border-white/5 p-8 flex flex-col min-h-[200px]">
                    <span class="text-white/40 text-[12px] font-bold uppercase tracking-widest mb-6">Article changes</span>
                    <div class="text-[48px] font-black text-white leading-none tracking-tighter mb-auto">850k+</div>
                    <div class="flex justify-end">
                        <div class="w-10 h-10 rounded-full bg-blue-500/10 border border-white/10 flex items-center justify-center group-hover:bg-blue-500 transition-all">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                    </div>
                </div>

                {{-- Stat Card 3 --}}
                <div class="card-premium-unified bg-[#161b22]/60 border border-white/5 p-8 flex flex-col min-h-[200px]">
                    <span class="text-white/40 text-[12px] font-bold uppercase tracking-widest mb-6">Artists indexed</span>
                    <div class="text-[48px] font-black text-white leading-none tracking-tighter mb-auto">12,400</div>
                    <div class="flex justify-end">
                        <div class="w-10 h-10 rounded-full bg-blue-500/10 border border-white/10 flex items-center justify-center group-hover:bg-blue-500 transition-all">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                    </div>
                </div>

                {{-- Stat Card 4 --}}
                <div class="card-premium-unified bg-[#161b22]/60 border border-white/5 p-8 flex flex-col min-h-[200px]">
                    <span class="text-white/40 text-[12px] font-bold uppercase tracking-widest mb-6">Community score</span>
                    <div class="text-[48px] font-black text-white leading-none tracking-tighter mb-auto">98.2%</div>
                    <div class="flex justify-end">
                        <div class="w-10 h-10 rounded-full bg-blue-500/10 border border-white/10 flex items-center justify-center group-hover:bg-blue-500 transition-all">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- =========================================
         CTA SECTION - FIGMA DESIGN
         ========================================= --}}
    <section class="section-unified py-32 bg-[#0d1117] relative overflow-hidden border-t border-white/5 relative z-10">
        {{-- Background Accents --}}
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-blue-500/5 blur-[120px] rounded-full pointer-events-none"></div>

        <div class="max-w-[1400px] mx-auto px-8 text-center relative z-10">
            <h2 class="text-[40px] md:text-[64px] font-black text-white tracking-tighter mb-16 max-w-4xl mx-auto leading-[1.0]" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Can't find the topic you're looking for? Add it now!
            </h2>
            
            <div class="flex justify-center">
                <a href="{{ route('wiki.create') }}" class="group inline-flex items-center gap-6 bg-white hover:bg-gray-100 px-10 py-5 rounded-full transition-all duration-300 shadow-2xl shadow-black/40">
                    <span class="text-[#0d1117] text-[18px] font-black uppercase tracking-tighter" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        Add a New Topic
                    </span>
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </div>
                </a>
            </div>
        </div>
    </section>
@endsection
