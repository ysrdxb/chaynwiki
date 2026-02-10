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
    <section class="pt-40 pb-24 bg-[#0d1117] relative z-10 overflow-hidden">
        <div class="max-w-[1400px] mx-auto px-8">
            {{-- Title - Left aligned Massive Typography --}}
            <div class="max-w-4xl mb-12">
                <h1 class="text-[56px] md:text-[80px] font-black text-white uppercase leading-[0.95] tracking-tightest mb-6" 
                    style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    YOUR COMMUNITY<br>
                    DRIVEN MUSIC<br>
                    ENCYCLOPEDIA
                </h1>
                
                {{-- Subtitle Disclaimer --}}
                <div class="flex items-center gap-3">
                    <div class="w-8 h-[1px] bg-white/20"></div>
                    <p class="text-white/40 text-[12px] font-bold uppercase tracking-[0.2em]" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        We are not affiliated with SoundCloud / Spotify
                    </p>
                </div>
            </div>
            
            {{-- Search Bar - Ultra Premium Pill style --}}
            <div class="max-w-[850px] mb-12 group">
                <form action="{{ route('search') }}" method="GET" class="relative">
                    <div class="absolute inset-y-0 left-6 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        name="q" 
                        placeholder="Search for a song, artist, or genre..." 
                        class="w-full bg-[#1c2128] border-2 border-white/5 rounded-full pl-16 pr-40 py-6 text-lg text-white placeholder-white/10 focus:outline-none focus:border-blue-500/50 focus:bg-[#252a33] transition-all shadow-2xl shadow-black/50"
                        style="font-family: 'Plus Jakarta Sans', sans-serif;"
                    >
                    <div class="absolute right-2 top-2 bottom-2">
                        <button type="submit" class="btn-figma-primary !h-full !px-8 !py-0 !rounded-full !text-[13px]">
                            Search
                        </button>
                    </div>
                </form>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-wrap items-center gap-4 mb-20">
                <a href="{{ route('wiki.create') }}" class="btn-figma-primary">
                    <span>Contribute now</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
                
                <a href="{{ route('wiki.index') }}" class="btn-figma-secondary">
                    <span>Explore Database</span>
                    <svg class="w-4 h-4 ml-1 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

            {{-- Quick Action Strip --}}
            <div class="flex flex-col gap-5">
                <div class="flex items-center gap-3">
                    <span class="text-blue-500 font-black text-[10px] uppercase tracking-[0.3em]">Quick Links</span>
                    <div class="h-[1px] w-12 bg-blue-500/30"></div>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('wiki.index', ['category' => 'genre']) }}" class="action-pill px-6 py-2.5 hover:scale-105">
                        <div class="pill-icon"></div>
                        Genres
                    </a>
                    <a href="{{ route('wiki.index', ['category' => 'artist']) }}" class="action-pill px-6 py-2.5 hover:scale-105">
                        <div class="pill-icon"></div>
                        Artists
                    </a>
                    <a href="{{ route('wiki.index', ['sort' => 'recent']) }}" class="action-pill px-6 py-2.5 hover:scale-105">
                        <div class="pill-icon"></div>
                        Recent Edits
                    </a>
                    <a href="{{ route('leaderboard') }}" class="action-pill px-6 py-2.5 hover:scale-105">
                        <div class="pill-icon"></div>
                        Leaderboard
                    </a>
                    <a href="{{ route('wiki.generate') }}" class="action-pill px-6 py-2.5 border-blue-500/20 bg-blue-500/5 hover:bg-blue-500/10 hover:scale-105">
                        <div class="pill-icon bg-blue-500"></div>
                        <span class="text-blue-400 font-bold">AI Analyzer</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
        </div>
    </section>

    {{-- =========================================
         NEW TOPICS SECTION - FIGMA DESIGN
         ========================================= --}}
    <section class="section-unified py-32 bg-[#0d1117] relative z-10 overflow-hidden" 
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
            <div class="flex items-end justify-between mb-16">
                <div class="max-w-2xl">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-[2px] bg-blue-500"></div>
                        <span class="text-blue-500 font-extrabold text-[12px] uppercase tracking-[0.4em]">Hot Releases</span>
                    </div>
                    <h2 class="section-title mb-3">NEW TOPICS</h2>
                    <p class="section-subtitle">Discover the latest contributions from our growing community.</p>
                </div>
                
                <div class="flex items-center gap-12">
                    <a href="{{ route('wiki.index', ['sort' => 'newest']) }}" class="hidden md:flex items-center gap-2 text-[12px] font-black text-white/40 hover:text-blue-500 uppercase tracking-widest transition-colors group">
                        See All Activity
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>

                    {{-- Navigation Arrows --}}
                    <div class="flex items-center gap-3">
                        <button @click="sliderScroll(-450)" :disabled="!canScrollLeft" :class="canScrollLeft ? 'text-white border-white/20 bg-white/5 opacity-100' : 'text-white/10 border-white/5 opacity-50 cursor-not-allowed'" class="w-14 h-14 rounded-full border border-white/10 flex items-center justify-center transition-all hover:bg-white/10 hover:border-white/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button @click="sliderScroll(450)" :disabled="!canScrollRight" :class="canScrollRight ? 'text-white border-white/20 bg-white/5 opacity-100' : 'text-white/10 border-white/5 opacity-50 cursor-not-allowed'" class="w-14 h-14 rounded-full border border-white/10 flex items-center justify-center transition-all hover:bg-white/10 hover:border-white/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Slider Container --}}
            <div class="overflow-x-auto scrollbar-hide -mx-8 px-8 no-scrollbar" x-ref="newTopicsSlider" @scroll="checkScroll()" style="scrollbar-width: none; -ms-overflow-style: none;">
                <div class="flex gap-8 pb-12">
                    @foreach($newTopicCards as $index => $topic)
                    <div class="card-premium-unified min-w-[380px] md:min-w-[450px] !p-0 group">
                        <a href="{{ $topic['url'] }}" class="block p-4">
                            {{-- Image Core --}}
                            <div class="relative aspect-[16/10] rounded-2xl overflow-hidden mb-8 shadow-2xl">
                                @if($topic['image'])
                                    <img src="{{ $topic['image'] }}" 
                                         onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1514525253361-bee8a19740c1?auto=format&fit=crop&q=80&w=800'; this.classList.add('opacity-50');"
                                         class="w-full h-full object-cover grayscale-[0.2] blur-[1px] group-hover:grayscale-0 group-hover:blur-0 group-hover:scale-105 transition-all duration-1000" alt="{{ $topic['title'] }}">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-900/60 to-[#0d1117] flex items-center justify-center">
                                        <svg class="w-16 h-16 text-white/5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                    </div>
                                @endif
                                
                                {{-- Floaters --}}
                                <div class="absolute top-4 left-4">
                                    <span class="text-white text-[10px] font-black uppercase tracking-[0.2em] bg-blue-600/90 backdrop-blur-md px-3 py-1.5 rounded-lg shadow-lg">{{ $topic['category'] }}</span>
                                </div>
                                <div class="absolute bottom-4 right-4 translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
                                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-navy-900 shadow-2xl">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Info --}}
                            <div class="px-2 pb-2">
                                <h3 class="text-white text-[22px] font-black tracking-tighter mb-3 group-hover:text-blue-400 transition-colors uppercase leading-tight">
                                    {{ $topic['title'] }}
                                </h3>
                                <p class="text-white/30 text-[14px] font-bold leading-relaxed mb-8 line-clamp-2 h-[2.8rem]">
                                    {{ $topic['desc'] ?? 'A deep dive into the cultural origins and evolutionary path of this musical phenomenon.' }}
                                </p>
                                
                                {{-- User Attribution --}}
                                <div class="flex items-center gap-3 pt-6 border-t border-white/5">
                                    <div class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center overflow-hidden">
                                        <span class="text-[10px] text-white/40 font-black uppercase">{{ substr($topic['user'] ?? 'CW', 0, 1) }}</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-[10px] text-white/20 font-black uppercase tracking-widest leading-none mb-1">Contributor</span>
                                        <span class="text-[12px] text-white/60 font-black tracking-tight leading-none">{{ $topic['user'] }}</span>
                                    </div>
                                    
                                    <div class="ml-auto flex items-center gap-4">
                                        <div class="flex flex-col items-end">
                                            <span class="text-[10px] text-white/20 font-black uppercase tracking-widest leading-none mb-1">Views</span>
                                            <span class="text-[12px] text-blue-400 font-black tracking-tight leading-none">{{ number_format($topic['views']) }}</span>
                                        </div>
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
        $radarData = array_merge([
            'submission_velocity' => 70,
            'edit_activity' => 85,
            'community_consensus' => 65,
            'trend_intensity' => 80,
        ], $musicWeather ?? []);

        // Calculate points for a 4-point radar (diamond)
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
            $radarData['submission_velocity'], 
            $radarData['edit_activity'], 
            $radarData['community_consensus'], 
            $radarData['trend_intensity']
        ];
        $points = []; $pointCoords = [];
        foreach ($angles as $i => $angle) {
            $point = $getPoint($angle, $values[$i]);
            $points[] = $point['x'] . ',' . $point['y'];
            $pointCoords[] = $point;
        }
        $polygonPoints = implode(' ', $points);
    @endphp

    <section class="section-unified py-32 bg-[#0d1117] relative z-10 overflow-hidden" 
             x-data="{ active: 'velocity', hovered: null, animateIn: false }" 
             x-init="setTimeout(() => animateIn = true, 300)">
        
        <div class="max-w-[1400px] mx-auto px-8">
            <div class="flex flex-col lg:flex-row items-center gap-24">
                {{-- Left: Radar Visualization --}}
                <div class="w-full lg:w-1/2 relative bg-[#161b22]/20 rounded-[48px] p-12 md:p-16 border border-white/5 overflow-hidden shadow-3xl">
                    {{-- Decore background --}}
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-blue-500/10 via-transparent to-transparent opacity-30"></div>

                    <div class="relative z-10 mb-16">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-[2px] bg-blue-500"></div>
                            <span class="text-blue-500 font-extrabold text-[12px] uppercase tracking-[0.4em]">Live Momentum</span>
                        </div>
                        <h2 class="text-[48px] md:text-[64px] font-black text-white uppercase tracking-tightest leading-[0.9] mb-6" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            MUSIC<br/>WEATHER
                        </h2>
                        <p class="text-white/30 text-[16px] font-bold leading-relaxed max-w-sm" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            A real-time visualization of community engagement and trend velocity.
                        </p>
                    </div>

                    <div class="relative w-full max-w-[420px] mx-auto z-10 pb-4">
                        <svg viewBox="0 0 400 400" class="w-full h-auto drop-shadow-[0_0_50px_rgba(59,130,246,0.15)]">
                            {{-- Concentric Guide Diamonds --}}
                            <g stroke="white" fill="none">
                                <path d="M200 60 L340 200 L200 340 L60 200 Z" stroke-opacity="0.1" stroke-width="1.5"/> {{-- 100% --}}
                                <path d="M200 107 L293 200 L200 293 L107 200 Z" stroke-opacity="0.05" stroke-width="1"/> {{-- 66% --}}
                                <path d="M200 153 L247 200 L200 247 L153 200 Z" stroke-opacity="0.03" stroke-width="1"/> {{-- 33% --}}
                            </g>
                            
                            {{-- Grid Lines --}}
                            <g stroke="white" stroke-width="1" stroke-opacity="0.05">
                                @foreach($angles as $angle)
                                    @php $p = $getPoint($angle, 100); @endphp
                                    <line x1="200" y1="200" x2="{{ $p['x'] }}" y2="{{ $p['y'] }}"/>
                                @endforeach
                            </g>

                            {{-- Animated Data Polygon --}}
                            <polygon 
                                points="{{ $polygonPoints }}" 
                                fill="rgba(59,130,246,0.1)" 
                                stroke="#3b82f6" 
                                stroke-width="3"
                                class="transition-all duration-1000"
                                :class="animateIn ? 'opacity-100' : 'opacity-0'"
                                style="transform-origin: center; transition: all 1s cubic-bezier(0.4, 0, 0.2, 1);"
                            />
                            
                            {{-- Interactive Data Points --}}
                            <g>
                                @foreach($values as $i => $val)
                                    @php 
                                        $colors = ['#ec4899', '#22d3ee', '#f472b6', '#3b82f6'];
                                        $keys = ['velocity', 'activity', 'consensus', 'intensity'];
                                    @endphp
                                    <circle 
                                        cx="{{ $pointCoords[$i]['x'] }}" cy="{{ $pointCoords[$i]['y'] }}" 
                                        r="7" 
                                        fill="{{ $colors[$i] }}"
                                        @mouseenter="hovered = '{{ $keys[$i] }}'; active = '{{ $keys[$i] }}'"
                                        @mouseleave="hovered = null"
                                        :r="active === '{{ $keys[$i] }}' ? 12 : 7"
                                        class="transition-all duration-300 cursor-pointer shadow-xl"
                                    />
                                @endforeach
                            </g>
                        </svg>
                        
                        {{-- Labels around the radar --}}
                        <div class="absolute -top-6 left-1/2 -translate-x-1/2 flex flex-col items-center">
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] transition-all duration-300"
                                  :class="active === 'velocity' ? 'text-pink-500 opacity-100' : 'text-white opacity-20'">Submission</span>
                        </div>
                        <div class="absolute top-1/2 -right-20 -translate-y-1/2 flex items-center">
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] transition-all duration-300 rotate-90"
                                  :class="active === 'activity' ? 'text-cyan-400 opacity-100' : 'text-white opacity-20'">Activity</span>
                        </div>
                        <div class="absolute -bottom-6 left-1/2 -translate-x-1/2 flex flex-col items-center">
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] transition-all duration-300"
                                  :class="active === 'consensus' ? 'text-pink-300 opacity-100' : 'text-white opacity-20'">Consensus</span>
                        </div>
                        <div class="absolute top-1/2 -left-20 -translate-y-1/2 flex items-center">
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] transition-all duration-300 -rotate-90"
                                  :class="active === 'intensity' ? 'text-blue-500 opacity-100' : 'text-white opacity-20'">Intensity</span>
                        </div>
                    </div>
                </div>

                {{-- Right: Content Details --}}
                <div class="w-full lg:w-1/2 flex flex-col gap-6">
                    <div class="space-y-4">
                        {{-- Metric 1: Velocity --}}
                        <div @mouseenter="active = 'velocity'" 
                             class="card-premium-unified !p-6 flex items-center gap-6 group cursor-pointer transition-all duration-500"
                             :class="active === 'velocity' ? 'border-blue-500/30 bg-blue-500/5' : 'bg-transparent border-white/5'">
                            <div class="w-14 h-14 rounded-2xl bg-pink-500/10 border border-pink-500/20 flex items-center justify-center text-pink-500 group-hover:scale-110 transition-transform duration-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-white text-[18px] font-black uppercase tracking-tighter mb-1">Submission Velocity</h4>
                                <p class="text-white/30 text-[13px] font-bold">New topics added per hour</p>
                            </div>
                            <div class="text-right">
                                <span class="text-[24px] font-black text-white tracking-tighter">{{ $radarData['submission_velocity'] }}%</span>
                            </div>
                        </div>

                        {{-- Metric 2: Activity --}}
                        <div @mouseenter="active = 'activity'" 
                             class="card-premium-unified !p-6 flex items-center gap-6 group cursor-pointer transition-all duration-500"
                             :class="active === 'activity' ? 'border-blue-500/30 bg-blue-500/5' : 'bg-transparent border-white/5'">
                            <div class="w-14 h-14 rounded-2xl bg-cyan-500/10 border border-cyan-500/20 flex items-center justify-center text-cyan-500 group-hover:scale-110 transition-transform duration-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-white text-[18px] font-black uppercase tracking-tighter mb-1">Revision Activity</h4>
                                <p class="text-white/30 text-[13px] font-bold">Community edits and verify actions</p>
                            </div>
                            <div class="text-right">
                                <span class="text-[24px] font-black text-white tracking-tighter">{{ $radarData['edit_activity'] }}%</span>
                            </div>
                        </div>

                        {{-- Metric 3: Consensus --}}
                        <div @mouseenter="active = 'consensus'" 
                             class="card-premium-unified !p-6 flex items-center gap-6 group cursor-pointer transition-all duration-500"
                             :class="active === 'consensus' ? 'border-blue-500/30 bg-blue-500/5' : 'bg-transparent border-white/5'">
                            <div class="w-14 h-14 rounded-2xl bg-pink-400/10 border border-pink-400/20 flex items-center justify-center text-pink-400 group-hover:scale-110 transition-transform duration-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-white text-[18px] font-black uppercase tracking-tighter mb-1">Community Consensus</h4>
                                <p class="text-white/30 text-[13px] font-bold">Accuracy score across all topics</p>
                            </div>
                            <div class="text-right">
                                <span class="text-[24px] font-black text-white tracking-tighter">{{ $radarData['community_consensus'] }}%</span>
                            </div>
                        </div>

                        {{-- Metric 4: Intensity --}}
                        <div @mouseenter="active = 'intensity'" 
                             class="card-premium-unified !p-6 flex items-center gap-6 group cursor-pointer transition-all duration-500"
                             :class="active === 'intensity' ? 'border-blue-500/30 bg-blue-500/5' : 'bg-transparent border-white/5'">
                            <div class="w-14 h-14 rounded-2xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-500 group-hover:scale-110 transition-transform duration-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-white text-[18px] font-black uppercase tracking-tighter mb-1">Momentum Intensity</h4>
                                <p class="text-white/30 text-[13px] font-bold">Exponential growth of the Wiki</p>
                            </div>
                            <div class="text-right">
                                <span class="text-[24px] font-black text-white tracking-tighter">{{ $radarData['trend_intensity'] }}%</span>
                            </div>
                        </div>
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

    <section class="section-unified py-32 bg-[#0d1117] relative z-10 overflow-hidden">
        <div class="max-w-[1400px] mx-auto px-8">
            <div class="flex items-end justify-between mb-20">
                <div class="max-w-2xl">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-[2px] bg-blue-500"></div>
                        <span class="text-blue-500 font-extrabold text-[12px] uppercase tracking-[0.4em]">Knowledge Base</span>
                    </div>
                    <h2 class="section-title mb-3">BROWSE BY CATEGORY</h2>
                    <p class="section-subtitle">Navigate through the most comprehensive database of music culture and history.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach(array_slice($categories, 0, 3) as $cat)
                <div class="card-premium-unified group relative">
                    <div class="relative z-10">
                        <div class="w-16 h-16 rounded-2xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-500 mb-10 group-hover:scale-110 group-hover:bg-blue-500 group-hover:text-white transition-all duration-500 shadow-xl">
                            @if($cat['key'] == 'genre')
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                            @elseif($cat['key'] == 'artist')
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            @else
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/></svg>
                            @endif
                        </div>
                        
                        <h3 class="text-white text-[28px] font-black uppercase tracking-tighter mb-4 leading-none">{{ $cat['title'] }}</h3>
                        <p class="text-white/30 text-[15px] font-bold leading-relaxed mb-12 h-20">{{ $cat['desc'] }}</p>
                        
                        <div class="flex items-center justify-between mt-auto pt-8 border-t border-white/5">
                            <div class="flex flex-col">
                                <span class="text-[10px] text-white/20 font-black uppercase tracking-widest leading-none mb-1">Index Volume</span>
                                <span class="text-[14px] text-blue-400 font-extrabold tracking-tight leading-none uppercase">{{ $cat['count'] }}</span>
                            </div>
                            
                            <a href="{{ $cat['url'] }}" class="w-12 h-12 rounded-full bg-white/5 border border-white/5 flex items-center justify-center text-white hover:bg-white hover:text-navy-900 transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section-unified py-32 bg-[#0d1117] relative z-10 overflow-hidden">
        <div class="max-w-[1400px] mx-auto px-8">
            <div class="flex items-end justify-between mb-20">
                <div class="max-w-2xl">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-[2px] bg-blue-500"></div>
                        <span class="text-blue-500 font-extrabold text-[12px] uppercase tracking-[0.4em]">Viral Now</span>
                    </div>
                    <h2 class="section-title mb-3">TRENDING TOPICS</h2>
                    <p class="section-subtitle">Real-time pulse of what the community is talking about right now.</p>
                </div>
            </div>

            {{-- Dynamic Trending Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($trendingArticles as $index => $article)
                <a href="{{ route('wiki.show', $article->slug) }}" class="card-premium-unified group block !p-10 relative overflow-hidden transition-all duration-500">
                    <div class="relative z-10 h-full flex flex-col">
                        <div class="mb-8 flex justify-between items-start">
                            <div class="w-14 h-14 rounded-2xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-500 group-hover:bg-blue-500 group-hover:text-white transition-all duration-500 shadow-xl">
                                @if($article->category === 'artist')
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                @elseif($article->category === 'song')
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                @else
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                @endif
                            </div>
                            
                            <div class="px-3 py-1.5 rounded-lg bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[10px] font-black uppercase tracking-[0.2em] shadow-lg">
                                #{{ $index + 1 }} TRENDING
                            </div>
                        </div>
                        
                        <h3 class="text-white text-[28px] font-black uppercase tracking-tighter mb-4 group-hover:text-blue-400 transition-colors line-clamp-1 leading-none">{{ $article->title }}</h3>
                        <p class="text-white/30 text-[14px] font-bold leading-relaxed mb-10 line-clamp-2 h-12">
                            {{ $article->meta_description ?? 'Join the community discussion about ' . $article->title . ' and discover what makes it trend.' }}
                        </p>
                        
                        <div class="mt-auto flex items-center justify-between pt-8 border-t border-white/5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center overflow-hidden">
                                    <span class="text-[10px] text-white/40 font-black uppercase">{{ substr($article->user->name ?? 'CW', 0, 1) }}</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[9px] text-white/20 font-black uppercase tracking-widest leading-none mb-1">Author</span>
                                    <span class="text-[12px] text-white/60 font-black tracking-tight leading-none">{{ $article->user->name ?? 'Community Hub' }}</span>
                                </div>
                            </div>
                            
                            <div class="flex flex-col items-end">
                                <span class="text-[9px] text-white/20 font-black uppercase tracking-widest leading-none mb-1">Impact</span>
                                <div class="flex items-center gap-1.5 text-blue-400 font-black text-[13px]">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
                                    {{ number_format($article->view_count) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>


    <section class="section-unified py-32 bg-[#0d1117] relative z-10 overflow-hidden" 
        x-data="{ 
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
        <div class="max-w-[1400px] mx-auto px-8">
            <div class="flex items-end justify-between mb-16">
                <div class="max-w-2xl">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-[2px] bg-blue-500"></div>
                        <span class="text-blue-500 font-extrabold text-[12px] uppercase tracking-[0.4em]">Hall of Fame</span>
                    </div>
                    <h2 class="section-title mb-3">RANKED ARCHIVES</h2>
                    <p class="section-subtitle">The highest rated musical entries determined by community consensus and engagement.</p>
                </div>
                
                {{-- Navigation Arrows --}}
                <div class="flex items-center gap-3">
                    <button @click="sliderScroll(-450)" :disabled="!canScrollLeft" :class="canScrollLeft ? 'text-white border-white/20 bg-white/5 opacity-100' : 'text-white/10 border-white/5 opacity-50 cursor-not-allowed'" class="w-14 h-14 rounded-full border border-white/10 flex items-center justify-center transition-all hover:bg-white/10 hover:border-white/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button @click="sliderScroll(450)" :disabled="!canScrollRight" :class="canScrollRight ? 'text-white border-white/20 bg-white/5 opacity-100' : 'text-white/10 border-white/5 opacity-50 cursor-not-allowed'" class="w-14 h-14 rounded-full border border-white/10 flex items-center justify-center transition-all hover:bg-white/10 hover:border-white/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            {{-- Slider Container --}}
            <div class="overflow-x-auto scrollbar-hide -mx-8 px-8 no-scrollbar" x-ref="rankedSlider" @scroll="checkScroll()" style="scrollbar-width: none; -ms-overflow-style: none;">
                <div class="flex gap-8 pb-12">
                    @foreach($rankedArticles as $index => $article)
                    <div class="card-premium-unified min-w-[380px] md:min-w-[450px] !p-0 group">
                        <a href="{{ route('wiki.show', $article->slug) }}" class="block p-4">
                            {{-- Image with Rank Overlay --}}
                            <div class="relative aspect-[16/10] rounded-2xl overflow-hidden mb-8 shadow-2xl">
                                <img src="{{ $article->featured_image }}" 
                                     onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&q=80&w=800'; this.classList.add('opacity-50');"
                                     class="w-full h-full object-cover grayscale-[0.2] blur-[1px] group-hover:grayscale-0 group-hover:blur-0 group-hover:scale-105 transition-all duration-1000" alt="{{ $article->title }}">
                                
                                {{-- Floaters --}}
                                <div class="absolute top-6 left-6">
                                    <div class="flex items-center gap-1">
                                        <span class="text-white text-[32px] font-black leading-none opacity-40 italic tracking-tighter">{{ sprintf('%02d', $index + 1) }}</span>
                                    </div>
                                </div>
                                <div class="absolute top-6 right-6">
                                    <span class="text-blue-400 text-[10px] font-black uppercase tracking-[0.2em] bg-black/40 backdrop-blur-md px-3 py-1.5 rounded-lg border border-white/5 shadow-lg">{{ $article->category }}</span>
                                </div>
                                <div class="absolute bottom-6 left-6 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                    <div class="flex items-center gap-2 px-4 py-2 bg-blue-600 rounded-full shadow-2xl">
                                        <span class="text-white text-[11px] font-black uppercase tracking-widest">View Concept</span>
                                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </div>
                                </div>
                            </div>

                            <div class="px-2 pb-2">
                                <h3 class="text-white text-[22px] font-black uppercase tracking-tighter mb-4 group-hover:text-blue-400 transition-colors leading-tight">{{ $article->title }}</h3>
                                <p class="text-white/30 text-[14px] font-bold leading-relaxed mb-8 line-clamp-2 h-[2.8rem]">Premium community archive meticulously exploring the cultural depth of {{ strtolower($article->title) }}.</p>
                                
                                <div class="flex items-center justify-between pt-6 border-t border-white/5">
                                    <div class="flex flex-col">
                                        <span class="text-[10px] text-white/20 font-black uppercase tracking-widest leading-none mb-1">Impact Radius</span>
                                        <div class="flex items-center gap-2 text-white/50 font-black text-[13px]">
                                            <svg class="w-3.5 h-3.5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            {{ number_format($article->view_count) }}
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end">
                                        <span class="text-[10px] text-white/20 font-black uppercase tracking-widest leading-none mb-1">Wiki Score</span>
                                        <span class="text-[14px] text-blue-400 font-black tracking-tight leading-none">#{{ $article->seo_score ?? 95 }}</span>
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
    <section class="section-unified py-32 bg-[#0d1117] relative z-10 overflow-hidden">
        <div class="max-w-[1400px] mx-auto px-8">
            <div class="flex items-end justify-between mb-20">
                <div class="max-w-2xl">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-[2px] bg-blue-500"></div>
                        <span class="text-blue-500 font-extrabold text-[12px] uppercase tracking-[0.4em]">Live Stats</span>
                    </div>
                    <h2 class="section-title mb-3">COMMUNITY MOMENTUM</h2>
                    <p class="section-subtitle">A transparent look at how the community is expanding the global music knowledge base.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                {{-- Stat Card 1 --}}
                <div class="card-premium-unified !p-10 flex flex-col min-h-[250px] group">
                    <span class="text-white/20 text-[11px] font-black uppercase tracking-[0.3em] mb-8">Active contributors</span>
                    <div class="text-[64px] font-black text-white leading-none tracking-tightest mb-auto group-hover:text-blue-400 transition-colors">{{ number_format($heroStats['contributors']) }}</div>
                    <div class="flex items-center justify-between border-t border-white/5 pt-6 mt-6">
                        <span class="text-white/40 text-[12px] font-bold">User Database</span>
                        <div class="w-10 h-10 rounded-full bg-blue-500/10 border border-white/10 flex items-center justify-center group-hover:bg-blue-500 group-hover:text-white transition-all shadow-xl">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                    </div>
                </div>

                {{-- Stat Card 2 --}}
                <div class="card-premium-unified !p-10 flex flex-col min-h-[250px] group">
                    <span class="text-white/20 text-[11px] font-black uppercase tracking-[0.3em] mb-8">Article revisions</span>
                    <div class="text-[64px] font-black text-white leading-none tracking-tightest mb-auto group-hover:text-blue-400 transition-colors">{{ number_format($heroStats['revisions'] / 1000, 1) }}k+</div>
                    <div class="flex items-center justify-between border-t border-white/5 pt-6 mt-6">
                        <span class="text-white/40 text-[12px] font-bold">Global Edits</span>
                        <div class="w-10 h-10 rounded-full bg-blue-500/10 border border-white/10 flex items-center justify-center group-hover:bg-blue-500 group-hover:text-white transition-all shadow-xl">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                    </div>
                </div>

                {{-- Stat Card 3 --}}
                <div class="card-premium-unified !p-10 flex flex-col min-h-[250px] group">
                    <span class="text-white/20 text-[11px] font-black uppercase tracking-[0.3em] mb-8">Artists indexed</span>
                    <div class="text-[64px] font-black text-white leading-none tracking-tightest mb-auto group-hover:text-blue-400 transition-colors">{{ number_format($heroStats['artists']) }}</div>
                    <div class="flex items-center justify-between border-t border-white/5 pt-6 mt-6">
                        <span class="text-white/40 text-[12px] font-bold">Talent Archive</span>
                        <div class="w-10 h-10 rounded-full bg-blue-500/10 border border-white/10 flex items-center justify-center group-hover:bg-blue-500 group-hover:text-white transition-all shadow-xl">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                    </div>
                </div>

                {{-- Stat Card 4 --}}
                <div class="card-premium-unified !p-10 flex flex-col min-h-[250px] group">
                    <span class="text-white/20 text-[11px] font-black uppercase tracking-[0.3em] mb-8">Live flow score</span>
                    <div class="text-[64px] font-black text-white leading-none tracking-tightest mb-auto group-hover:text-blue-400 transition-colors">{{ $musicPulse['live_flow'] }}%</div>
                    <div class="flex items-center justify-between border-t border-white/5 pt-6 mt-6">
                        <span class="text-white/40 text-[12px] font-bold">Velocity Index</span>
                        <div class="w-10 h-10 rounded-full bg-blue-500/10 border border-white/10 flex items-center justify-center group-hover:bg-blue-500 group-hover:text-white transition-all shadow-xl">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    <section class="section-unified py-48 bg-[#0d1117] relative overflow-hidden border-t border-white/5 z-10">
        {{-- Background Accents --}}
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[1000px] h-[600px] bg-blue-500/5 blur-[160px] rounded-full pointer-events-none"></div>

        <div class="max-w-[1400px] mx-auto px-8 text-center relative z-10">
            <div class="flex flex-col items-center max-w-4xl mx-auto">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-12 h-[1px] bg-blue-500/30"></div>
                    <span class="text-blue-500 font-extrabold text-[12px] uppercase tracking-[0.5em]">Join the Movement</span>
                    <div class="w-12 h-[1px] bg-blue-500/30"></div>
                </div>
                
                <h2 class="text-[56px] md:text-[80px] font-black text-white tracking-tightest mb-16 uppercase leading-[0.95]" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    MISSING SOMETHING?<br/>
                    ADD IT TO THE ARCHIVE.
                </h2>
                
                <div class="flex flex-wrap justify-center gap-6">
                    <a href="{{ route('wiki.create') }}" class="btn-figma-primary !px-12 !py-5 !text-[14px]">
                        <span>Contribute now</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                    
                    <a href="{{ route('register') }}" class="btn-figma-secondary !px-12 !py-5 !text-[14px]">
                        <span>Join Community</span>
                        <div class="w-5 h-5 bg-white/10 rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                        </div>
                    </a>
                </div>

                <p class="mt-16 text-white/20 text-[12px] font-bold uppercase tracking-[0.2em]">
                    Every contribution helps build the world's most detailed music hub.
                </p>
            </div>
        </div>
    </section>
@endsection
