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
            <h1 class="text-[56px] md:text-[72px] font-black text-white uppercase leading-[1.05] tracking-tighter mb-4" style="letter-spacing: -0.04em;">
                YOUR COMMUNITY-DRIVEN<br>
                MUSIC ENCYCLOPEDIA
            </h1>
            <p class="text-white/50 text-[14px] font-medium mb-10">
                We are not affiliated with SoundCloud / Spotify.
            </p>
            <form action="{{ route('search') }}" method="GET" class="max-w-[640px] mb-12">
                <div class="flex items-center bg-[#161b22]/80 backdrop-blur-sm border border-white/5 rounded-full p-1.5 focus-within:border-white/10 transition-all">
                    <input 
                        type="text" 
                        name="q" 
                        placeholder="Search for a song, artist, or genre..." 
                        class="flex-1 bg-transparent border-none focus:ring-0 text-white placeholder-white/20 text-[16px] px-6 font-medium tracking-tight"
                    >
                    <button type="submit" class="flex items-center gap-3 px-6 py-2.5 bg-white text-[#0d1117] rounded-full hover:bg-gray-100 transition-all group">
                        <span class="text-[14px] font-black uppercase tracking-tight">Search</span>
                        <div class="w-6 h-6 bg-[#3b82f6] rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                    </button>
                </div>
            </form>
            <div class="flex flex-wrap items-center gap-4 mb-14">
                <a href="{{ route('wiki.create') }}" class="flex items-center gap-4 px-8 py-3 rounded-full border border-white/20 text-white text-[16px] font-semibold hover:bg-white/5 transition-all group">
                    <span>Contribute a Topic</span>
                    <div class="w-6 h-6 bg-[#3b82f6] rounded-full flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg shadow-blue-500/20">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                    </div>
                </a>
                <a href="{{ route('wiki.index') }}" class="flex items-center gap-4 px-8 py-3 rounded-full border border-white/20 text-white text-[16px] font-semibold hover:bg-white/5 transition-all group">
                    <span>Browse Categories</span>
                    <div class="w-6 h-6 bg-[#3b82f6] rounded-full flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg shadow-blue-500/20">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
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
                    <h2 class="section-title mb-2">New Topics</h2>
                    <p class="section-subtitle">Recently added by the community</p>
                </div>
                
                {{-- Navigation Arrows - Figma Style --}}
                <div class="hidden md:flex items-center gap-4">
                    <button @click="sliderScroll(-400)" :class="canScrollLeft ? 'text-white border-white/20' : 'text-white/10 border-white/5 cursor-not-allowed'" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center transition-all bg-transparent hover:border-white/40 group">
                        <svg class="w-5 h-5 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button @click="sliderScroll(400)" :class="canScrollRight ? 'text-white border-white/20' : 'text-white/10 border-white/5 cursor-not-allowed'" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center transition-all bg-transparent hover:border-white/40 group">
                        <svg class="w-5 h-5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            {{-- Slider Container --}}
            <div class="overflow-x-auto scrollbar-hide -mx-8 px-8" x-ref="newTopicsSlider" @scroll="checkScroll()" style="scrollbar-width: none; -ms-overflow-style: none;">
                <div class="flex gap-6 pb-8">
                    @foreach($newTopicCards as $index => $topic)
                    <div class="card-premium-unified min-w-[340px] md:min-w-[420px] group">
                        <a href="{{ $topic['url'] }}" class="block h-full">
                            {{-- Image --}}
                            <div class="relative aspect-video rounded-2xl overflow-hidden mb-6">
                                @if($topic['image'])
                                    <img src="{{ $topic['image'] }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-700" alt="{{ $topic['title'] }}" onerror="this.src='{{ asset('images/hero_background.png') }}'; this.onerror=null;">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-900/40 to-black flex items-center justify-center">
                                        <svg class="w-12 h-12 text-white/10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                    </div>
                                @endif
                                {{-- Genre Label removed from here --}}
                            </div>

                            {{-- Text Content --}}
                            <div class="px-2">
                                <span class="text-[#3b82f6] text-[12px] font-bold block mb-1">{{ $topic['category'] }}</span>
                                <h3 class="text-white text-[24px] font-bold tracking-tight mb-2 group-hover:text-blue-400 transition-colors">
                                    {{ $topic['title'] }}
                                </h3>
                                <p class="text-white/40 text-[14px] font-medium leading-relaxed mb-6 line-clamp-2">
                                    {{ $topic['desc'] ?? 'A unique exploration of musical landscapes and cultural influences shaping the industry today.' }}
                                </p>
                                
                                {{-- User Metadata Row --}}
                                <div class="flex items-center gap-2 mb-6">
                                    <div class="w-8 h-8 rounded-full bg-blue-500/10 border border-white/5 flex items-center justify-center overflow-hidden">
                                        <span class="text-[12px] text-blue-400 font-bold">{{ substr($topic['user'] ?? 'CW', 0, 1) }}</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-white/80 text-[12px] font-bold">{{ $topic['user'] }}</span>
                                        <span class="text-white/30 text-[10px]">{{ $topic['date'] ?? 'Nov 18, 2025' }}</span>
                                    </div>
                                </div>

                                {{-- Meta Counters Row --}}
                                <div class="flex items-center gap-6 text-white/40 text-[12px] font-bold">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span>{{ number_format($topic['views'] ?? 0) }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        <span>{{ $topic['edits'] ?? 0 }} edits</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><rect width="18" height="18" x="3" y="3" rx="4" stroke="currentColor"/><path stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4"/></svg>
                                        <span>{{ $topic['edits'] ?? 0 }} edits</span>
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
            'submission' => 70,
            'edit' => 85,
            'consensus' => 40,
            'intensity' => 60,
        ];

        // Calculate diamond points
        $centerX = 200; $centerY = 200; $maxRadius = 140;
        $getPoint = function($angle, $value) use ($centerX, $centerY, $maxRadius) {
            $radius = ($value / 100) * $maxRadius;
            $radian = deg2rad($angle - 90);
            $x = $centerX + $radius * cos($radian);
            $y = $centerY + $radius * sin($radian);
            return ['x' => round($x), 'y' => round($y)];
        };
        $angles = [0, 90, 180, 270];
        $values = [
            $radarData['submission'] ?? $radarData['viral_artists'] ?? 50, 
            $radarData['edit'] ?? $radarData['trending_songs'] ?? 50, 
            $radarData['consensus'] ?? $radarData['declining_trends'] ?? 50, 
            $radarData['intensity'] ?? $radarData['rising_genres'] ?? 50
        ];
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
                        <h2 class="section-title mb-4">Real-Time Music Weather</h2>
                        <p class="section-subtitle">A live visualization of musical trends and community momentum.</p>
                    </div>

                    <div class="relative w-full max-w-[400px] mx-auto z-10">
                        <svg viewBox="0 0 400 400" class="w-full h-auto drop-shadow-[0_0_30px_rgba(59,130,246,0.1)]">
                            {{-- Concentric Diamond Guides --}}
                            <g stroke="white" fill="none">
                                <polygon points="200,60 340,200 200,340 60,200" stroke-width="1" opacity="0.08"/>
                                <polygon points="200,107 293,200 200,293 107,200" stroke-width="1" opacity="0.05"/>
                                <polygon points="200,153 247,200 200,247 153,200" stroke-width="1" opacity="0.03"/>
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
                                fill="rgba(59,130,246,0.15)" 
                                stroke="#3b82f6" 
                                stroke-width="2"
                                class="transition-all duration-1000"
                                :class="animateIn ? 'opacity-100' : 'opacity-0'"
                                style="transform-origin: center; transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);"
                            />
                            
                            {{-- Gradient definition --}}
                            <defs>
                                <linearGradient id="radarGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#3b82f6;stop-opacity:0.6"/>
                                    <stop offset="100%" style="stop-color:#a855f7;stop-opacity:0.3"/>
                                </linearGradient>
                            </defs>
                            
                            <g class="cursor-pointer">
                                {{-- Submission Velocity (Top) --}}
                                <circle 
                                    cx="{{ $pointCoords[0]['x'] }}" cy="{{ $pointCoords[0]['y'] }}" r="6" 
                                    fill="#ec4899"
                                    @mouseenter="hovered = 'submission'"
                                    @mouseleave="hovered = null"
                                    @click="active = 'submission'"
                                    :r="active === 'submission' || hovered === 'submission' ? 12 : 6"
                                    class="transition-all duration-300"
                                />

                                {{-- Edit Activity (Right) --}}
                                <circle 
                                    cx="{{ $pointCoords[1]['x'] }}" cy="{{ $pointCoords[1]['y'] }}" r="6" 
                                    fill="#22d3ee"
                                    @mouseenter="hovered = 'edit'"
                                    @mouseleave="hovered = null"
                                    @click="active = 'edit'"
                                    :r="active === 'edit' || hovered === 'edit' ? 12 : 6"
                                    class="transition-all duration-300"
                                />

                                {{-- Community Consensus (Bottom) --}}
                                <circle 
                                    cx="{{ $pointCoords[2]['x'] }}" cy="{{ $pointCoords[2]['y'] }}" r="6" 
                                    fill="#f472b6"
                                    @mouseenter="hovered = 'consensus'"
                                    @mouseleave="hovered = null"
                                    @click="active = 'consensus'"
                                    :r="active === 'consensus' || hovered === 'consensus' ? 12 : 6"
                                    class="transition-all duration-300"
                                />

                                {{-- Trend Intensity (Left) --}}
                                <circle 
                                    cx="{{ $pointCoords[3]['x'] }}" cy="{{ $pointCoords[3]['y'] }}" r="6" 
                                    fill="#3b82f6"
                                    @mouseenter="hovered = 'intensity'"
                                    @mouseleave="hovered = null"
                                    @click="active = 'intensity'"
                                    :r="active === 'intensity' || hovered === 'intensity' ? 12 : 6"
                                    class="transition-all duration-300"
                                />
                            </g>
                        </svg>
                        
                        {{-- Labels around the radar --}}
                        <div class="absolute -top-4 left-1/2 -translate-x-1/2 text-center w-full">
                            <span class="text-white text-[11px] font-black uppercase tracking-widest cursor-pointer transition-all" 
                                  @click="active = 'submission'"
                                  :class="active === 'submission' ? 'text-pink-400 opacity-100' : 'opacity-20'">Submission Velocity</span>
                        </div>
                        <div class="absolute top-1/2 -right-16 -translate-y-1/2">
                            <span class="text-white text-[11px] font-black uppercase tracking-widest cursor-pointer transition-all block rotate-90"
                                  @click="active = 'edit'"
                                  :class="active === 'edit' ? 'text-cyan-400 opacity-100' : 'opacity-20'">Edit Activity</span>
                        </div>
                        <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 text-center w-full">
                            <span class="text-white text-[11px] font-black uppercase tracking-widest cursor-pointer transition-all"
                                  @click="active = 'consensus'"
                                  :class="active === 'consensus' ? 'text-pink-300 opacity-100' : 'opacity-20'">Community Consensus</span>
                        </div>
                        <div class="absolute top-1/2 -left-16 -translate-y-1/2">
                            <span class="text-white text-[11px] font-black uppercase tracking-widest cursor-pointer transition-all block -rotate-90"
                                  @click="active = 'intensity'"
                                  :class="active === 'intensity' ? 'text-blue-500 opacity-100' : 'opacity-20'">Trend Intensity</span>
                        </div>
                    </div>
                </div>

                {{-- Right: Info Cards --}}
                <div class="w-full lg:w-1/2 grid grid-cols-1 gap-4">
                    {{-- Submission Velocity Card --}}
                    <div @mouseenter="active = 'submission'" 
                         class="bg-[#161b22]/60 border border-white/5 rounded-[20px] p-6 flex items-center justify-between transition-all duration-300 cursor-pointer group hover:border-white/10"
                         :class="active === 'submission' ? 'bg-[#1c2128]' : ''">
                        <div class="flex items-center gap-5">
                            <div class="w-10 h-10 rounded-full bg-pink-500/10 border border-pink-500/20 flex items-center justify-center text-pink-400 group-hover:bg-pink-500 group-hover:text-white transition-all duration-300 shadow-lg shadow-pink-500/10">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            </div>
                            <div>
                                <h4 class="text-white text-[18px] font-bold tracking-tight">Submission Velocity</h4>
                                <p class="text-white/40 text-[13px]">Rate of new topic additions by the community.</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-white/20 group-hover:text-white/40 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </div>

                    {{-- Edit Activity Card --}}
                    <div @mouseenter="active = 'edit'" 
                         class="bg-[#161b22]/60 border border-white/5 rounded-[20px] p-6 flex items-center justify-between transition-all duration-300 cursor-pointer group hover:border-white/10"
                         :class="active === 'edit' ? 'bg-[#1c2128]' : ''">
                        <div class="flex items-center gap-5">
                            <div class="w-10 h-10 rounded-full bg-cyan-500/10 border border-cyan-500/20 flex items-center justify-center text-cyan-400 group-hover:bg-cyan-500 group-hover:text-white transition-all duration-300 shadow-lg shadow-cyan-500/10">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-white text-[18px] font-bold tracking-tight">Edit Activity</h4>
                                <p class="text-white/40 text-[13px]">Frequency and depth of real-time article refinements.</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-white/20 group-hover:text-white/40 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </div>

                    {{-- Community Consensus Card --}}
                    <div @mouseenter="active = 'consensus'" 
                         class="bg-[#161b22]/60 border border-white/5 rounded-[20px] p-6 flex items-center justify-between transition-all duration-300 cursor-pointer group hover:border-white/10"
                         :class="active === 'consensus' ? 'bg-[#1c2128]' : ''">
                        <div class="flex items-center gap-5">
                            <div class="w-10 h-10 rounded-full bg-pink-300/10 border border-pink-300/20 flex items-center justify-center text-pink-300 group-hover:bg-pink-300 group-hover:text-white transition-all duration-300 shadow-lg shadow-pink-300/10">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            </div>
                            <div>
                                <h4 class="text-white text-[18px] font-bold tracking-tight">Community Consensus</h4>
                                <p class="text-white/40 text-[13px]">Agreement level on article quality and verification.</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-white/20 group-hover:text-white/40 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </div>

                    {{-- Trend Intensity Card --}}
                    <div @mouseenter="active = 'intensity'" 
                         class="bg-[#161b22]/60 border border-white/5 rounded-[20px] p-6 flex items-center justify-between transition-all duration-300 cursor-pointer group hover:border-white/10"
                         :class="active === 'intensity' ? 'bg-[#1c2128]' : ''">
                        <div class="flex items-center gap-5">
                            <div class="w-10 h-10 rounded-full bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400 group-hover:bg-blue-500 group-hover:text-white transition-all duration-300 shadow-lg shadow-blue-500/10">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"/></svg>
                            </div>
                            <div>
                                <h4 class="text-white text-[18px] font-bold tracking-tight">Trend Intensity</h4>
                                <p class="text-white/40 text-[13px]">Strength of current musical movements platform-wide.</p>
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

    <section class="section-unified py-24 bg-[#0d1117] border-t border-white/5 relative z-10 overflow-hidden" 
             x-data="{ 
                canScrollLeft: false, 
                canScrollRight: true,
                sliderScroll(amount) {
                    const slider = this.$refs.catSlider;
                    slider.scrollBy({ left: amount, behavior: 'smooth' });
                },
                checkScroll() {
                    const slider = this.$refs.catSlider;
                    this.canScrollLeft = slider.scrollLeft > 10;
                    this.canScrollRight = slider.scrollLeft < (slider.scrollWidth - slider.clientWidth - 10);
                }
            }" x-init="checkScroll()">
        <div class="max-w-[1400px] mx-auto px-8">
            <div class="flex items-end justify-between mb-16">
                <div class="max-w-2xl">
                    <h2 class="section-title mb-2 uppercase">BROWSE BY CATEGORY</h2>
                    <p class="section-subtitle">Explore genres, artists, playlists, songs, and essential music terminology.</p>
                </div>

                {{-- Slider Controls --}}
                <div class="hidden md:flex items-center gap-4">
                    <button @click="sliderScroll(-400)" :class="canScrollLeft ? 'text-white border-white/20' : 'text-white/10 border-white/5 cursor-not-allowed'" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center transition-all bg-transparent hover:border-white/40 group">
                        <svg class="w-5 h-5 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button @click="sliderScroll(400)" :class="canScrollRight ? 'text-white border-white/20' : 'text-white/10 border-white/5 cursor-not-allowed'" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center transition-all bg-transparent hover:border-white/40 group">
                        <svg class="w-5 h-5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto scrollbar-hide -mx-8 px-8" x-ref="catSlider" @scroll="checkScroll()" style="scrollbar-width: none; -ms-overflow-style: none;">
                <div class="flex gap-6 pb-8">
                    @foreach($categories as $index => $cat)
                    <div class="card-premium-unified min-w-[340px] md:min-w-[420px] p-8 bg-[#161b22]/60 border border-white/5 group flex flex-col justify-between">
                        <div>
                            <h3 class="text-white text-[32px] font-bold tracking-tight mb-4">{{ $cat['title'] }}</h3>
                            <p class="text-white/40 text-[15px] font-medium leading-relaxed mb-8">{{ $cat['desc'] }}</p>
                            
                            <div class="flex items-center gap-3 mb-10">
                                <div class="w-6 h-6 rounded-full bg-blue-600 flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <span class="text-white/60 text-[14px] font-medium">{{ $cat['count'] }}</span>
                            </div>
                        </div>
                        
                        <div class="flex">
                            @if($index === 0)
                                <a href="{{ $cat['url'] }}" class="group inline-flex items-center gap-4 bg-white hover:bg-gray-100 px-8 py-4 rounded-full transition-all duration-300">
                                    <span class="text-[#0d1117] text-[15px] font-black uppercase tracking-tight">Explore {{ $cat['title'] }}</span>
                                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </div>
                                </a>
                            @else
                                <a href="{{ $cat['url'] }}" class="group inline-flex items-center gap-4 bg-transparent border border-white/20 hover:bg-white/5 px-8 py-4 rounded-full transition-all duration-300">
                                    <span class="text-white text-[15px] font-black uppercase tracking-tight">{{ $index === 1 ? 'View' : 'Explore' }} {{ $cat['title'] }}</span>
                                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </div>
                                </a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
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
                    <h2 class="text-white text-[32px] font-black uppercase tracking-tight mb-2" style="font-family: 'MODERNIZ', sans-serif;">RANKED ITEM</h2>
                    <p class="section-subtitle">Explore genres, artists, playlists, songs, and essential music terminology.</p>
                </div>
                
                <div class="hidden md:flex items-center gap-4">
                    <button @click="sliderScroll(-400)" :class="canScrollLeft ? 'text-white border-white/20' : 'text-white/10 border-white/5 cursor-not-allowed'" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center transition-all bg-transparent hover:border-white/40 group">
                        <svg class="w-5 h-5 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button @click="sliderScroll(400)" :class="canScrollRight ? 'text-white border-white/20' : 'text-white/10 border-white/5 cursor-not-allowed'" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center transition-all bg-transparent hover:border-white/40 group">
                        <svg class="w-5 h-5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto scrollbar-hide -mx-8 px-8" x-ref="rankedSlider" @scroll="checkScroll()" style="scrollbar-width: none; -ms-overflow-style: none;">
                <div class="flex gap-6 pb-8">
                    @foreach($rankedArticles as $index => $article)
                    <div class="bg-[#161b22]/90 border border-white/10 rounded-[32px] p-8 min-w-[340px] md:min-w-[420px] group transition-all duration-300 hover:border-white/20 hover:bg-[#1c2128]">
                        <a href="{{ route('wiki.show', $article->slug) }}" class="block h-full">
                            <div class="relative aspect-video rounded-[24px] overflow-hidden mb-8">
                                <img src="{{ $article->featured_image }}" class="w-full h-full object-cover group-hover:scale-105 transition-all duration-700" alt="{{ $article->title }}" onerror="this.src='{{ asset('images/hero_background.png') }}'; this.onerror=null;">
                            </div>

                            <div class="px-1">
                                <span class="text-[#3b82f6] text-[12px] font-bold block mb-2 uppercase tracking-wide">{{ $article->category }}</span>
                                <h3 class="text-white text-[28px] font-bold tracking-tight mb-3 group-hover:text-blue-400 transition-colors leading-tight">{{ $article->title }}</h3>
                                <p class="text-white/40 text-[14px] font-medium leading-relaxed mb-8 line-clamp-2">
                                    {{ $article->meta_description ?? 'The definitive community archive exploring the depth of ' . strtolower($article->title) . '.' }}
                                </p>
                                
                                {{-- Meta Counters Row - Figma Fidelity Sync --}}
                                <div class="flex items-center gap-6 text-white/40 text-[12px] font-bold mt-auto border-t border-white/5 pt-6">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span class="text-white/60 tracking-tight">{{ ($article->view_count ?? 0) / 1000000 >= 1 ? number_format($article->view_count / 1000000, 1) . 'M' : number_format($article->view_count ?? 0) }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-white/20 uppercase tracking-widest text-[10px]">SEO Score:</span>
                                        <span class="text-white/60">{{ $article->seo_score ?? 92 }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-white/20 uppercase tracking-widest text-[10px]">Engagement:</span>
                                        <span class="text-white/60">High Activity</span>
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
                <h2 class="section-title mb-2">Community Insights</h2>
                <p class="section-subtitle">Real-time metrics on how the community is expanding the global music knowledge base.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Stat Card 1 --}}
                <div class="card-premium-unified p-8 flex flex-col min-h-[220px] group">
                    <span class="text-white/40 text-[12px] font-bold uppercase tracking-widest mb-6">Total contributors</span>
                    <div class="text-[48px] font-black text-white leading-none tracking-tighter mb-auto">{{ number_format($heroStats['contributors']) }}</div>
                    <div class="flex justify-end">
                        <div class="w-10 h-10 rounded-full bg-blue-500/10 border border-white/10 flex items-center justify-center group-hover:bg-blue-500 transition-all duration-300">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                    </div>
                </div>

                {{-- Stat Card 2 --}}
                <div class="card-premium-unified p-8 flex flex-col min-h-[220px] group">
                    <span class="text-white/40 text-[12px] font-bold uppercase tracking-widest mb-6">Article changes</span>
                    <div class="text-[48px] font-black text-white leading-none tracking-tighter mb-auto">{{ number_format($heroStats['revisions']) }}</div>
                    <div class="flex justify-end">
                        <div class="w-10 h-10 rounded-full bg-blue-500/10 border border-white/10 flex items-center justify-center group-hover:bg-blue-500 transition-all duration-300">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                    </div>
                </div>

                {{-- Stat Card 3 --}}
                <div class="card-premium-unified p-8 flex flex-col min-h-[220px] group">
                    <span class="text-white/40 text-[12px] font-bold uppercase tracking-widest mb-6">Artists indexed</span>
                    <div class="text-[48px] font-black text-white leading-none tracking-tighter mb-auto">{{ number_format($heroStats['artists']) }}</div>
                    <div class="flex justify-end">
                        <div class="w-10 h-10 rounded-full bg-blue-500/10 border border-white/10 flex items-center justify-center group-hover:bg-blue-500 transition-all duration-300">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                    </div>
                </div>

                {{-- Stat Card 4 --}}
                <div class="card-premium-unified p-8 flex flex-col min-h-[220px] group">
                    <span class="text-white/40 text-[12px] font-bold uppercase tracking-widest mb-6">Total topics</span>
                    <div class="text-[48px] font-black text-white leading-none tracking-tighter mb-auto">{{ number_format($heroStats['articles']) }}</div>
                    <div class="flex justify-end">
                        <div class="w-10 h-10 rounded-full bg-blue-500/10 border border-white/10 flex items-center justify-center group-hover:bg-blue-500 transition-all duration-300">
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
            <h2 class="text-[40px] md:text-[64px] font-black text-white tracking-tighter mb-16 max-w-4xl mx-auto leading-[1.0]">
                Can't find the topic you're looking for? Add it now!
            </h2>
            
            <div class="flex justify-center">
                <a href="{{ route('wiki.create') }}" class="group inline-flex items-center gap-6 bg-white hover:bg-gray-100 px-10 py-5 rounded-full transition-all duration-300 shadow-2xl shadow-black/40">
                    <span class="text-[#0d1117] text-[18px] font-black uppercase tracking-tighter">
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
