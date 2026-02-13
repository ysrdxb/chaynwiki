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
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-[#3b82f6]/5 blur-[120px] rounded-full"></div>
        <div class="absolute bottom-[10%] right-[-10%] w-[30%] h-[30%] bg-purple-600/5 blur-[120px] rounded-full"></div>
    </div>

    {{-- =========================================
         HERO SECTION - FIGMA STYLE (LEFT-ALIGNED)
         ========================================= --}}
    {{-- =========================================
         HERO SECTION - FIGMA STYLE (LEFT-ALIGNED)
         ========================================= --}}
    <section class="pt-32 pb-16 bg-[#0d1117] relative z-10 overflow-hidden">
        <div class="max-w-[1400px] mx-auto px-8">
            <h1 class="text-[32px] sm:text-[48px] md:text-[64px] font-black text-white uppercase leading-[1.1] tracking-tight mb-4">
                YOUR COMMUNITY-DRIVEN<br>
                MUSIC ENCYCLOPEDIA
            </h1>
            <p class="text-white/50 text-[14px] font-medium mb-10">
                ChaynWiki is an independent archival platform. Not affiliated with SoundCloud or Spotify.
            </p>
            @livewire('home-search')
            <div class="flex flex-wrap items-center gap-4 mb-16">
                <a href="{{ route('wiki.create') }}" class="flex items-center gap-4 px-8 py-3.5 bg-white text-[#0d1117] rounded-full text-[15px] font-black uppercase tracking-tight hover:bg-gray-100 transition-all group shadow-xl shadow-black/20">
                    <span>Contribute a Topic</span>
                    <div class="w-6 h-6 bg-[#3b82f6] rounded-full flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg shadow-blue-500/20">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                    </div>
                </a>
                <a href="{{ route('wiki.index') }}" class="flex items-center gap-4 px-8 py-3.5 bg-white/5 border border-white/8 text-white rounded-full text-[15px] font-bold hover:bg-white/10 transition-all group">
                    <span>Explore Categories</span>
                    <div class="w-6 h-6 bg-[#3b82f6]/10 rounded-full flex items-center justify-center group-hover:bg-[#3b82f6] transition-all">
                        <svg class="w-3 h-3 text-[#3b82f6] group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
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
                    <a href="{{ route('admin.articles.generate') }}" class="action-pill">
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
                    <button @click="sliderScroll(-400)" :class="canScrollLeft ? 'text-white border-white/15' : 'text-white/10 border-white/5 cursor-not-allowed'" class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center transition-all bg-white/5 hover:bg-white/10 hover:border-white/20 group">
                        <svg class="w-5 h-5 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button @click="sliderScroll(400)" :class="canScrollRight ? 'text-white border-white/15' : 'text-white/10 border-white/5 cursor-not-allowed'" class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center transition-all bg-white/5 hover:bg-white/10 hover:border-white/20 group">
                        <svg class="w-5 h-5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
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
                                    <img src="{{ $topic['image'] }}" class="w-full h-full object-cover grayscale-[0.2] group-hover:grayscale-0 group-hover:scale-105 transition-all duration-700" alt="{{ $topic['title'] }}" onerror="this.src='{{ asset('images/hero_background.png') }}'; this.onerror=null;">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-[#161b22] to-black flex items-center justify-center">
                                        <svg class="w-12 h-12 text-white/5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13"/></svg>
                                    </div>
                                @endif
                                
                                {{-- Genre Badge Overlay --}}
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 bg-black/60 backdrop-blur-md border border-white/10 rounded text-blue-400 text-[10px] font-black uppercase tracking-[0.2em]">
                                        {{ $topic['category'] }}
                                    </span>
                                </div>
                            </div>

                            {{-- Text Content --}}
                            <div class="px-2 pb-2">
                                <h3 class="text-white text-[24px] font-bold tracking-tight mb-3 group-hover:text-blue-400 transition-colors">
                                    {{ $topic['title'] }}
                                </h3>
                                <p class="text-white/40 text-[14px] font-medium leading-relaxed mb-6 line-clamp-2">
                                    {{ $topic['desc'] ?? 'Explore this music database entry, enriched with community metrics and detailed information.' }}
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
                                <div class="flex items-center gap-6 mt-auto">
                                    <div class="flex items-center gap-2 text-white/40 group-hover:text-white/60 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span class="text-[12px] font-bold">{{ number_format($topic['views'] ?? 0) }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-white/40 group-hover:text-white/60 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        <span class="text-[12px] font-bold">{{ $topic['edits'] ?? 0 }} edits</span>
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
         PLATFORM ARCHIVE PULSE - DYNAMIC RADAR & STATS
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
            $radarData['rising_genres'] ?? 50, 
            $radarData['trending_songs'] ?? 50, 
            $radarData['declining_trends'] ?? 50, 
            $radarData['viral_artists'] ?? 50
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
             x-data="{ active: 'growth', hovered: null, animateIn: false }" 
             x-init="setTimeout(() => animateIn = true, 300)">
        <div class="max-w-[1400px] mx-auto px-6 sm:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
                {{-- Left: Radar Visualization --}}
                <div class="w-full lg:w-1/2 relative bg-[#161b22]/40 rounded-[32px] md:rounded-[40px] p-8 md:p-12 border border-white/5 overflow-hidden group">
                    {{-- Decore background --}}
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-blue-500/5 via-transparent to-transparent opacity-50"></div>

                    <div class="relative z-10 mb-10 text-center lg:text-left">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-blue-500/10 border border-blue-500/20 rounded-full mb-4">
                            <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                            <span class="text-[10px] font-black text-blue-400 uppercase tracking-widest">Live Platform Pulse</span>
                        </div>
                        <h2 class="section-title mb-4">Archival Momentum</h2>
                        <p class="section-subtitle">Real-time visualization of community updates and archive growth.</p>
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
                            
                            <g class="cursor-pointer">
                                {{-- Submission Velocity (Top) --}}
                                <circle 
                                    cx="{{ $pointCoords[0]['x'] }}" cy="{{ $pointCoords[0]['y'] }}" r="6" 
                                    fill="#ec4899"
                                    @mouseenter="hovered = 'growth'"
                                    @mouseleave="hovered = null"
                                    @click="active = 'growth'"
                                    :r="active === 'growth' || hovered === 'growth' ? 12 : 6"
                                    class="transition-all duration-300 shadow-lg"
                                />

                                {{-- Edit Activity (Right) --}}
                                <circle 
                                    cx="{{ $pointCoords[1]['x'] }}" cy="{{ $pointCoords[1]['y'] }}" r="6" 
                                    fill="#22d3ee"
                                    @mouseenter="hovered = 'activity'"
                                    @mouseleave="hovered = null"
                                    @click="active = 'activity'"
                                    :r="active === 'activity' || hovered === 'activity' ? 12 : 6"
                                    class="transition-all duration-300"
                                />

                                {{-- Community Consensus (Bottom) --}}
                                <circle 
                                    cx="{{ $pointCoords[2]['x'] }}" cy="{{ $pointCoords[2]['y'] }}" r="6" 
                                    fill="#f472b6"
                                    @mouseenter="hovered = 'trust'"
                                    @mouseleave="hovered = null"
                                    @click="active = 'trust'"
                                    :r="active === 'trust' || hovered === 'trust' ? 12 : 6"
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
                            <span class="text-white text-[10px] font-black uppercase tracking-widest cursor-pointer transition-all" 
                                  @click="active = 'growth'"
                                  :class="active === 'growth' ? 'text-pink-400 opacity-100' : 'opacity-20'">Topic Growth</span>
                        </div>
                        <div class="absolute top-1/2 -right-16 -translate-y-1/2">
                            <span class="text-white text-[10px] font-black uppercase tracking-widest cursor-pointer transition-all block rotate-90"
                                  @click="active = 'activity'"
                                  :class="active === 'activity' ? 'text-cyan-400 opacity-100' : 'opacity-20'">Edit Velocity</span>
                        </div>
                        <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 text-center w-full">
                            <span class="text-white text-[10px] font-black uppercase tracking-widest cursor-pointer transition-all"
                                  @click="active = 'trust'"
                                  :class="active === 'trust' ? 'text-pink-300 opacity-100' : 'opacity-20'">Archive Trust</span>
                        </div>
                        <div class="absolute top-1/2 -left-16 -translate-y-1/2">
                            <span class="text-white text-[10px] font-black uppercase tracking-widest cursor-pointer transition-all block -rotate-90"
                                  @click="active = 'intensity'"
                                  :class="active === 'intensity' ? 'text-blue-500 opacity-100' : 'opacity-20'">Trend Intensity</span>
                        </div>
                    </div>
                </div>

                {{-- Right: Integrated Data Widgets --}}
                <div class="w-full lg:w-1/2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Active Nodes Card --}}
                    <div @mouseenter="active = 'growth'" 
                         class="bg-[#161b22]/60 border border-white/5 rounded-[32px] p-6 sm:p-8 flex flex-col justify-between transition-all duration-500 cursor-pointer group hover:border-blue-500/30"
                         :class="active === 'growth' ? 'bg-[#1c2128] border-blue-500/20' : ''">
                        <div class="flex justify-between items-start mb-8">
                            <div class="w-12 h-12 rounded-2xl bg-pink-500/10 border border-pink-500/20 flex items-center justify-center text-pink-400 group-hover:bg-pink-500 group-hover:text-white transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                            </div>
                            <span class="text-[12px] font-black text-emerald-400 uppercase tracking-widest">+{{ $musicWeather['raw']['new_this_week'] ?? 0 }} this week</span>
                        </div>
                        <div>
                            <span class="text-white/40 text-[11px] font-bold uppercase tracking-widest mb-1 block">New Topics</span>
                            <h3 class="text-4xl font-black text-white tracking-tighter">{{ number_format($musicWeather['raw']['new_this_week'] ?? 0) }}</h3>
                        </div>
                    </div>

                    {{-- Edit Frequency Card --}}
                    <div @mouseenter="active = 'activity'" 
                         class="bg-[#161b22]/60 border border-white/5 rounded-[32px] p-8 flex flex-col justify-between transition-all duration-500 cursor-pointer group hover:border-cyan-500/30"
                         :class="active === 'activity' ? 'bg-[#1c2128] border-cyan-500/20' : ''">
                        <div class="flex justify-between items-start mb-8">
                            <div class="w-12 h-12 rounded-2xl bg-cyan-500/10 border border-cyan-500/20 flex items-center justify-center text-cyan-400 group-hover:bg-cyan-500 group-hover:text-white transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </div>
                            <span class="text-[12px] font-black text-white/20 uppercase tracking-widest">Live Updates</span>
                        </div>
                        <div>
                            <span class="text-white/40 text-[11px] font-bold uppercase tracking-widest mb-1 block">Daily Edits</span>
                            <h3 class="text-4xl font-black text-white tracking-tighter">{{ number_format($musicWeather['raw']['edits_today'] ?? 0) }}</h3>
                        </div>
                    </div>

                    {{-- Verification Score Card --}}
                    <div @mouseenter="active = 'trust'" 
                         class="bg-[#161b22]/60 border border-white/5 rounded-[32px] p-8 flex flex-col justify-between transition-all duration-500 cursor-pointer group hover:border-pink-500/30"
                         :class="active === 'trust' ? 'bg-[#1c2128] border-pink-500/20' : ''">
                        <div class="flex justify-between items-start mb-8">
                            <div class="w-12 h-12 rounded-2xl bg-pink-300/10 border border-pink-300/20 flex items-center justify-center text-pink-300 group-hover:bg-pink-300 group-hover:text-white transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <span class="text-[12px] font-black text-pink-400 uppercase tracking-widest">Archive Integrity</span>
                        </div>
                        <div>
                            <span class="text-white/40 text-[11px] font-bold uppercase tracking-widest mb-1 block">Verification Rate</span>
                            <h3 class="text-4xl font-black text-white tracking-tighter">{{ $musicWeather['raw']['verification_rate'] ?? 0 }}%</h3>
                        </div>
                    </div>

                    {{-- Pulse Momentum Card --}}
                    <div @mouseenter="active = 'intensity'" 
                         class="bg-[#161b22]/60 border border-white/5 rounded-[32px] p-8 flex flex-col justify-between transition-all duration-500 cursor-pointer group hover:border-blue-500/30"
                         :class="active === 'intensity' ? 'bg-[#1c2128] border-blue-500/20' : ''">
                        <div class="flex justify-between items-start mb-8">
                            <div class="w-12 h-12 rounded-2xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400 group-hover:bg-blue-500 group-hover:text-white transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.5)] animate-pulse"></span>
                                <span class="text-[12px] font-black text-blue-400 uppercase tracking-widest">{{ $musicWeather['raw']['active_now'] ?? 0 }} Online</span>
                            </div>
                        </div>
                        <div>
                            <span class="text-white/40 text-[11px] font-bold uppercase tracking-widest mb-1 block">Archive Momentum</span>
                            <h3 class="text-4xl font-black text-white tracking-tighter">High Activity</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
            </div>
        </div>
    </section>


    {{-- =========================================
         BROWSE BY CATEGORY - CARD GRID
         ========================================= --}}
    {{-- =========================================
         BROWSE BY CATEGORY - DYNAMIC SLIDER
         ========================================= --}}
    @php
        $categories = [
            [
                'key' => 'artist',
                'title' => 'Artists',
                'desc' => 'Profiles of musicians, producers, and performers with consolidated discographies.',
                'icon' => '<path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>',
                'count_label' => 'Entities',
            ],
            [
                'key' => 'song',
                'title' => 'Tracks',
                'desc' => 'Detailed track information including technical metadata, sample history, and credits.',
                'icon' => '<path d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                'count_label' => 'Tracks',
            ],
            [
                'key' => 'genre',
                'title' => 'Genres',
                'desc' => 'Deep archival entries for musical styles, tracing origins, subgenres, and regional evolutions.',
                'icon' => '<path d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>',
                'count_label' => 'Topics',
            ],
            [
                'key' => 'playlist',
                'title' => 'Playlists',
                'desc' => 'Curated lists of tracks for every mood, genre, or occasion, tracked across platforms.',
                'icon' => '<path d="M4 6h16M4 10h16M4 14h16M4 18h16"/>',
                'count_label' => 'Playlists',
            ],
            [
                'key' => 'term',
                'title' => 'Terminology',
                'desc' => 'Essential music terms, theory, equipment, and industry lingo for the modern archivist.',
                'icon' => '<path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>',
                'count_label' => 'Terms',
            ],
        ];
    @endphp

    <section class="section-unified py-24 bg-[#0d1117] border-t border-white/5 relative z-10"
             x-data="{ 
                canScrollLeft: false, 
                canScrollRight: true,
                checkScroll() {
                    let s = this.$refs.catSlider;
                    this.canScrollLeft = s.scrollLeft > 0;
                    this.canScrollRight = s.scrollLeft + s.offsetWidth < s.scrollWidth - 2;
                },
                sliderScroll(amount) {
                    this.$refs.catSlider.scrollBy({ left: amount, behavior: 'smooth' });
                    setTimeout(() => this.checkScroll(), 350);
                }
            }" x-init="checkScroll()">
        <div class="max-w-[1400px] mx-auto px-8">
            <div class="flex items-end justify-between mb-12">
                 <div class="max-w-2xl">
                    <h2 class="section-title mb-2">Explore Categories</h2>
                    <p class="section-subtitle">Browse through the main sections of our music library.</p>
                </div>
                 <div class="hidden md:flex items-center gap-4">
                    <button @click="sliderScroll(-400)" :class="canScrollLeft ? 'text-white border-white/15' : 'text-white/10 border-white/5 cursor-not-allowed'" class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center transition-all bg-white/5 hover:bg-white/10 hover:border-white/20 group">
                        <svg class="w-5 h-5 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button @click="sliderScroll(400)" :class="canScrollRight ? 'text-white border-white/15' : 'text-white/10 border-white/5 cursor-not-allowed'" class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center transition-all bg-white/5 hover:bg-white/10 hover:border-white/20 group">
                        <svg class="w-5 h-5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto scrollbar-hide -mx-8 px-8" x-ref="catSlider" @scroll="checkScroll()" style="scrollbar-width: none; -ms-overflow-style: none;">
                <div class="flex gap-6 pb-8">
                @foreach($categories as $cat)
                    <a href="{{ route('wiki.index', ['category' => $cat['key']]) }}" class="card-premium-unified min-w-[300px] md:min-w-[380px] p-8 bg-[#161b22]/60 border border-white/5 flex flex-col h-full group hover:bg-[#1c2128] transition-all duration-500">
                        <div class="w-12 h-12 rounded-full bg-blue-500 text-white flex items-center justify-center shadow-lg shadow-blue-500/10 mb-8 transition-transform group-hover:scale-110">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">{!! $cat['icon'] !!}</svg>
                        </div>
                        <h3 class="text-[24px] font-bold tracking-tight text-white mb-4 group-hover:text-blue-400 transition-colors">{{ $cat['title'] }}</h3>
                        <p class="text-white/40 text-[15px] font-medium leading-relaxed mb-10 line-clamp-2">
                            {{ $cat['desc'] }}
                        </p>
                        <div class="mt-auto flex justify-between items-center">
                            <span class="text-white/20 text-[12px] font-bold uppercase tracking-widest">
                                {{ number_format($categoryCounts->where('category', $cat['key'])->first()->total ?? 0) }} {{ $cat['count_label'] }}
                            </span>
                            <div class="px-6 py-2 bg-white/5 border border-white/5 rounded-full text-[13px] font-bold text-white/50 group-hover:bg-blue-500 group-hover:text-white group-hover:border-blue-500 transition-all">
                                Explore
                            </div>
                        </div>
                    </a>
                @endforeach
                </div>
            </div>
        </div>
    </section>
            </div>
        </div>
    </section>

    <section class="section-unified py-32 bg-[#0d1117] border-t border-white/5 relative z-10 overflow-hidden">
        {{-- Background Glow --}}
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-blue-500/5 blur-[160px] rounded-full pointer-events-none"></div>

        <div class="max-w-[1400px] mx-auto px-8 relative z-10">
            <div class="mb-24 max-w-3xl">
                <h2 class="text-white text-[32px] md:text-[40px] font-black uppercase tracking-tight mb-4" style="font-family: 'MODERNIZ', sans-serif;">
                    DISCOVER WHAT’S TRENDING IN MUSIC
                </h2>
                <p class="text-white/40 text-[18px] font-medium">A dynamic feed of community favorites and trending releases.</p>
            </div>

            {{-- Mosaic Staggered Layout - Exact Figma Pattern --}}
            <div class="flex flex-col md:flex-row gap-8 lg:gap-12">
                {{-- Column 1 --}}
                <div class="flex-1 flex flex-col gap-10">
                    {{-- Hyperpop Card - Top Left --}}
                    <a href="{{ route('wiki.index', ['category' => 'genre', 'q' => 'hyperpop']) }}" class="relative bg-[#161b22]/40 backdrop-blur-sm border border-white/5 rounded-[32px] p-10 hover:border-blue-500/30 hover:bg-[#161b22]/60 hover:shadow-lg hover:shadow-blue-500/10 transition-all duration-500 group">
                        <div class="absolute top-8 right-8 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[10px] font-black uppercase tracking-widest">
                            #1 Trending
                        </div>
                        <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center mb-10 group-hover:bg-blue-500 transition-all duration-300">
                            <svg class="w-6 h-6 text-blue-500 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        </div>
                        <h3 class="text-white text-[24px] font-black uppercase tracking-tight mb-2 group-hover:text-blue-400 transition-colors">HYPERPOP</h3>
                        <p class="text-white/40 text-[16px] font-medium">+78% growth this week</p>
                    </a>

                    {{-- Burna Boy Card - Lower Left --}}
                    <a href="{{ route('wiki.index', ['q' => 'Burna Boy']) }}" class="relative bg-[#161b22]/40 backdrop-blur-sm border border-white/5 rounded-[32px] p-10 hover:border-blue-500/30 hover:bg-[#161b22]/60 hover:shadow-lg hover:shadow-blue-500/10 transition-all duration-500 group md:mt-16">
                         <div class="absolute top-8 right-8 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[10px] font-black uppercase tracking-widest">
                            #3 Trending
                        </div>
                        <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center mb-10 group-hover:bg-blue-500 transition-all duration-300">
                            <svg class="w-6 h-6 text-blue-500 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <h3 class="text-white text-[24px] font-black uppercase tracking-tight mb-2 group-hover:text-blue-400 transition-colors">BURNA BOY</h3>
                        <p class="text-white/40 text-[16px] font-medium">Global Momentum</p>
                    </a>
                </div>

                {{-- Column 2 - Offset Middle --}}
                <div class="flex-1 flex flex-col gap-10 md:mt-24">
                    {{-- Blinding Lights Card - Middle Top (Offset) --}}
                    <a href="{{ route('wiki.index', ['q' => 'Blinding Lights']) }}" class="relative bg-[#161b22]/40 backdrop-blur-sm border border-white/5 rounded-[32px] p-10 hover:border-blue-500/30 hover:bg-[#161b22]/60 hover:shadow-lg hover:shadow-blue-500/10 transition-all duration-500 group">
                         <div class="absolute top-8 right-8 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[10px] font-black uppercase tracking-widest">
                            #2 Trending
                        </div>
                        <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center mb-10 group-hover:bg-blue-500 transition-all duration-300">
                            <svg class="w-6 h-6 text-blue-500 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </div>
                        <h3 class="text-white text-[24px] font-black uppercase tracking-tight mb-2 leading-tight group-hover:text-blue-400 transition-colors">BLINDING<br>LIGHTS</h3>
                        <p class="text-white/40 text-[16px] font-medium">Most edited today</p>
                    </a>

                    {{-- Afrofusion Card - Middle Bottom (Offset) --}}
                    <a href="{{ route('wiki.index', ['category' => 'genre', 'q' => 'afrofusion']) }}" class="relative bg-[#161b22]/40 backdrop-blur-sm border border-white/5 rounded-[32px] p-10 hover:border-blue-500/30 hover:bg-[#161b22]/60 hover:shadow-lg hover:shadow-blue-500/10 transition-all duration-500 group md:mt-16">
                         <div class="absolute top-8 right-8 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[10px] font-black uppercase tracking-widest">
                            Rising
                        </div>
                        <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center mb-10 group-hover:bg-blue-500 transition-all duration-300">
                            <svg class="w-6 h-6 text-blue-500 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <h3 class="text-white text-[24px] font-black uppercase tracking-tight mb-2 group-hover:text-blue-400 transition-colors">AFROFUSION</h3>
                        <p class="text-white/40 text-[16px] font-medium">Emerging subgenre</p>
                    </a>
                </div>

                {{-- Column 3 - Offset Right --}}
                <div class="flex-1 flex flex-col gap-10 md:mt-12">
                    {{-- Emerging Subgenre Card - Top Right (Offset) --}}
                    <a href="{{ route('wiki.index', ['category' => 'genre']) }}" class="relative bg-[#161b22]/40 backdrop-blur-sm border border-white/5 rounded-[32px] p-10 hover:border-blue-500/30 hover:bg-[#161b22]/60 hover:shadow-lg hover:shadow-blue-500/10 transition-all duration-500 group">
                         <div class="absolute top-8 right-8 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[10px] font-black uppercase tracking-widest">
                            New
                        </div>
                        <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center mb-10 group-hover:bg-blue-500 transition-all duration-300">
                            <svg class="w-6 h-6 text-blue-500 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/></svg>
                        </div>
                        <h3 class="text-white text-[24px] font-black uppercase tracking-tight mb-2 leading-tight group-hover:text-blue-400 transition-colors">EMERGING<br>SUBGENRE</h3>
                        <p class="text-white/40 text-[16px] font-medium">New Remix</p>
                    </a>
                </div>
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
                    <button @click="sliderScroll(-400)" :class="canScrollLeft ? 'text-white border-white/15' : 'text-white/10 border-white/5 cursor-not-allowed'" class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center transition-all bg-white/5 hover:bg-white/10 hover:border-white/20 group">
                        <svg class="w-5 h-5 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button @click="sliderScroll(400)" :class="canScrollRight ? 'text-white border-white/15' : 'text-white/10 border-white/5 cursor-not-allowed'" class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center transition-all bg-white/5 hover:bg-white/10 hover:border-white/20 group">
                        <svg class="w-5 h-5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto scrollbar-hide -mx-8 px-8" x-ref="rankedSlider" @scroll="checkScroll()" style="scrollbar-width: none; -ms-overflow-style: none;">
                <div class="flex gap-6 pb-8">
                    @foreach($rankedArticles as $index => $article)
                    <div class="card-premium-unified min-w-[340px] md:min-w-[420px] p-0 group">
                        <a href="{{ route('wiki.show', $article->slug) }}" class="block p-8">
                            {{-- Image with Rank Overlay --}}
                            <div class="relative aspect-video rounded-2xl overflow-hidden mb-8">
                                @if($article->featured_image)
                                    <img src="{{ $article->featured_image }}" class="w-full h-full object-cover grayscale-[0.2] group-hover:grayscale-0 group-hover:scale-105 transition-all duration-700" alt="{{ $article->title }}" onerror="this.src='{{ asset('images/hero_background.png') }}'; this.onerror=null;">
                                @else
                                    <div class="w-full h-full bg-[#1c2128] flex items-center justify-center">
                                        <svg class="w-12 h-12 text-white/5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13"/></svg>
                                    </div>
                                @endif
                                
                                {{-- Rank Overlay --}}
                                <div class="absolute top-4 left-4">
                                    <span class="text-[32px] font-black text-white/30 tracking-tighter leading-none select-none">
                                        {{ sprintf('%02d', $index + 1) }}
                                    </span>
                                </div>

                                {{-- Category Badge --}}
                                <div class="absolute top-4 right-4">
                                    <span class="px-3 py-1 bg-black/60 backdrop-blur-md border border-white/10 rounded text-blue-400 text-[10px] font-black uppercase tracking-[0.2em]">
                                        {{ $article->category }}
                                    </span>
                                </div>
                            </div>

                            <div class="px-1">
                                <h3 class="text-white text-[24px] font-bold tracking-tight mb-4 group-hover:text-blue-400 transition-colors leading-tight">
                                    {{ $article->title }}
                                </h3>
                                
                                <div class="flex items-center justify-between mt-auto pt-6 border-t border-white/5">
                                    <span class="text-white/20 uppercase tracking-widest text-[10px] font-bold">Community Rank: <span class="text-blue-400">#{{ $index + 1 }}</span></span>
                                    <div class="flex items-center gap-2 bg-white/5 px-3 py-1.5 rounded-full border border-white/5">
                                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12l-6-6h12l-6 6z"/></svg>
                                        <span class="text-white/60 text-[11px] font-black">{{ ($article->view_count ?? 0) / 1000 >= 1 ? number_format($article->view_count / 1000, 1) . 'K' : number_format($article->view_count ?? 0) }} Views</span>
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
    <section class="section-unified py-24 bg-[#0d1117] border-t border-white/5 relative z-10 overflow-hidden">
        <div class="max-w-[1400px] mx-auto px-8">
            <div class="mb-16 max-w-2xl">
                <h2 class="text-white text-[32px] font-black uppercase tracking-tight mb-2" style="font-family: 'MODERNIZ', sans-serif;">COMMUNITY INSIGHTS</h2>
                <p class="section-subtitle">Real-time statistics covering our archival momentum.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Card 1: New Topics --}}
                <div class="card-premium-unified bg-[#161b22]/60 border border-white/5 p-8 flex flex-col min-h-[200px] group transition-all duration-300 hover:bg-[#1c2128]">
                    <span class="text-white/40 text-[12px] font-bold uppercase tracking-widest mb-6">New Topics This Week</span>
                    <h3 class="text-[48px] font-black text-white leading-none tracking-tighter mb-auto">
                        {{ number_format(data_get($musicWeather, 'raw.new_this_week', 0)) }}
                    </h3>
                    <div class="self-end mt-4">
                        <div class="w-10 h-10 rounded-full bg-blue-500/10 border border-white/10 flex items-center justify-center text-blue-500 group-hover:bg-blue-500 group-hover:text-white transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Daily Edits --}}
                <div class="card-premium-unified bg-[#161b22]/60 border border-white/5 p-8 flex flex-col min-h-[200px] group transition-all duration-300 hover:bg-[#1c2128]">
                    <span class="text-white/40 text-[12px] font-bold uppercase tracking-widest mb-6">Edits Today</span>
                    <h3 class="text-[48px] font-black text-white leading-none tracking-tighter mb-auto">
                        {{ number_format(data_get($musicWeather, 'raw.edits_today', 0)) }}
                    </h3>
                    <div class="self-end mt-4">
                        <div class="w-10 h-10 rounded-full bg-cyan-500/10 border border-white/10 flex items-center justify-center text-cyan-500 group-hover:bg-cyan-500 group-hover:text-white transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </div>
                    </div>
                </div>

                {{-- Card 3: Active Users --}}
                <div class="card-premium-unified bg-[#161b22]/60 border border-white/5 p-8 flex flex-col min-h-[200px] group transition-all duration-300 hover:bg-[#1c2128]">
                    <span class="text-white/40 text-[12px] font-bold uppercase tracking-widest mb-6">Archivists Online</span>
                    <h3 class="text-[48px] font-black text-white leading-none tracking-tighter mb-auto">
                        {{ number_format(data_get($musicWeather, 'raw.active_now', 0)) }}
                    </h3>
                    <div class="self-end mt-4">
                         <div class="w-10 h-10 rounded-full bg-pink-500/10 border border-white/10 flex items-center justify-center text-pink-500 group-hover:bg-pink-500 group-hover:text-white transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                    </div>
                </div>

                {{-- Card 4: Verification Rate --}}
                <div class="card-premium-unified bg-[#161b22]/60 border border-white/5 p-8 flex flex-col min-h-[200px] group transition-all duration-300 hover:bg-[#1c2128]">
                    <span class="text-white/40 text-[12px] font-bold uppercase tracking-widest mb-6">Verification Rate</span>
                    <h3 class="text-[48px] font-black text-white leading-none tracking-tighter mb-auto">
                        {{ data_get($musicWeather, 'raw.verification_rate', 95) }}%
                    </h3>
                    <div class="self-end mt-4">
                        <div class="w-10 h-10 rounded-full bg-emerald-500/10 border border-white/10 flex items-center justify-center text-emerald-500 group-hover:bg-emerald-500 group-hover:text-white transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- =========================================
         CTA SECTION - DARK ARCHIVAL IMPACT
         ========================================= --}}
    <section class="section-unified py-24 bg-[#0d1117] border-t border-white/5 relative z-10 overflow-hidden">
        <div class="max-w-[1400px] mx-auto px-8">
            <div class="relative bg-[#161b22] rounded-[32px] md:rounded-[40px] p-8 sm:p-12 md:p-24 text-center border border-white/5 overflow-hidden group">
                {{-- Decorative background elements --}}
                <div class="absolute top-0 right-0 w-[300px] sm:w-[600px] h-[300px] sm:h-[600px] bg-blue-500/5 blur-[80px] sm:blur-[120px] rounded-full -translate-y-1/2 translate-x-1/2 group-hover:bg-blue-500/10 transition-all duration-700"></div>
                <div class="absolute bottom-0 left-0 w-[200px] sm:w-[400px] h-[200px] sm:h-[400px] bg-purple-500/5 blur-[60px] sm:blur-[100px] rounded-full translate-y-1/2 -translate-x-1/2"></div>

                <div class="relative z-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/5 border border-white/10 rounded-full mb-6 sm:mb-8">
                        <span class="text-[10px] font-black text-white/40 uppercase tracking-widest">Open Archive</span>
                    </div>
                    
                    <h2 class="text-[24px] sm:text-[32px] md:text-[56px] font-black text-white tracking-tight mb-8 sm:mb-12 max-w-4xl mx-auto uppercase leading-[1.2] sm:leading-[1.1]" style="font-family: 'MODERNIZ', sans-serif;">
                        Can't find the topic you're looking for?<br class="hidden sm:block">Add it to the network!
                    </h2>
                    
                    <div class="flex justify-center">
                        <a href="{{ route('wiki.create') }}" class="group inline-flex items-center gap-4 sm:gap-6 bg-white hover:bg-gray-100 px-8 py-4 sm:px-12 sm:py-5 rounded-full transition-all duration-300 shadow-2xl shadow-blue-900/40 w-full sm:w-auto justify-center">
                            <span class="text-[#0d1117] text-[14px] sm:text-[16px] font-black uppercase tracking-widest">
                                Build the Archive
                            </span>
                            <div class="w-8 h-8 bg-[#0d1117] rounded-full flex items-center justify-center group-hover:rotate-45 transition-transform duration-500 shrink-0">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                        </a>
                    </div>
                    
                    <p class="mt-12 text-white/20 text-[11px] font-bold uppercase tracking-[0.2em]">Become a contributor today and help scale the music knowledge graph.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
