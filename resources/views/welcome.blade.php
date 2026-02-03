@extends('layouts.wiki')

@section('title', 'ChaynWiki — Your Community-Driven Music Encyclopedia')

@push('styles')
<style>
    /* =============================================
       CHAYNWIKI V3 - REFINED DESIGN SYSTEM
       More depth, less harsh, better contrast
       ============================================= */
    
    /* === CORE BACKGROUNDS - Refined Palette === */
    .bg-primary { background-color: #0a0a12; }
    .bg-secondary { background-color: #0f0f1a; }
    .bg-tertiary { background-color: #151522; }
    .bg-surface { background-color: #1a1a2e; }
    .bg-card { background-color: #12121f; }
    .bg-card-hover { background-color: #1a1a2e; }
    .bg-elevated { background: linear-gradient(135deg, #151522 0%, #1a1a2e 100%); }
    
    /* === SECTION BORDERS - Refined === */
    .section-divider {
        position: relative;
    }
    .section-divider::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100%;
        max-width: 1200px;
        height: 1px;
        background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.1) 20%, rgba(255,255,255,0.1) 80%, transparent 100%);
    }
    
    /* === TYPOGRAPHY V2 === */
    .text-hero-v2 { 
        font-size: clamp(36px, 6vw, 56px); 
        line-height: 1.05; 
        font-weight: 700;
        font-style: italic;
        letter-spacing: -0.03em;
    }
    .text-section-heading { 
        font-size: 13px; 
        font-weight: 700; 
        letter-spacing: 0.15em;
        text-transform: uppercase;
    }
    .text-section-subhead { 
        font-size: 15px; 
        color: rgba(255,255,255,0.7); 
        line-height: 1.6;
    }
    .text-card-heading { 
        font-size: 16px; 
        font-weight: 600; 
    }
    .text-card-subtext { 
        font-size: 13px; 
        color: rgba(255,255,255,0.6); 
    }
    .text-tag { 
        font-size: 10px; 
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }
    .text-stat-number { 
        font-size: 32px; 
        font-weight: 800;
        letter-spacing: -0.02em;
    }
    
    /* === PREMIUM CARD V2 === */
    .card-v2 {
        background: linear-gradient(145deg, rgba(21,21,34,0.9) 0%, rgba(26,26,46,0.8) 100%);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        backdrop-filter: blur(12px);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .card-v2:hover {
        border-color: rgba(255, 255, 255, 0.18);
        background: linear-gradient(145deg, rgba(26,26,46,0.95) 0%, rgba(32,32,56,0.9) 100%);
        transform: translateY(-2px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.5);
    }
    
    /* === GRADIENT CARDS - Vibrant === */
    .grad-purple { background: linear-gradient(145deg, #3b1d6b 0%, #5b21b6 50%, #7c3aed 100%); }
    .grad-blue { background: linear-gradient(145deg, #0c4a6e 0%, #0369a1 50%, #0ea5e9 100%); }
    .grad-pink { background: linear-gradient(145deg, #701a45 0%, #be185d 50%, #f472b6 100%); }
    .grad-cyan { background: linear-gradient(145deg, #115e59 0%, #0d9488 50%, #2dd4bf 100%); }
    .grad-orange { background: linear-gradient(145deg, #7c2d12 0%, #c2410c 50%, #f97316 100%); }
    .grad-green { background: linear-gradient(145deg, #14532d 0%, #15803d 50%, #22c55e 100%); }
    
    /* === ANIMATED CIRCULAR PROGRESS === */
    .progress-ring {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: conic-gradient(
            from 0deg,
            #3b82f6 0deg 120deg,
            #8b5cf6 120deg 240deg,
            #ec4899 240deg 360deg
        );
        padding: 4px;
        animation: rotate-glow 8s linear infinite;
    }
    .progress-ring-inner {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: #050510;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    @keyframes rotate-glow {
        0% { filter: hue-rotate(0deg); }
        100% { filter: hue-rotate(360deg); }
    }
    
    /* === BUTTONS V2 - More Vibrant === */
    .btn-primary-v2 {
        background: linear-gradient(135deg, #2a91ff 0%, #1a73f5 100%);
        color: white;
        font-weight: 600;
        padding: 12px 24px;
        border-radius: 100px;
        font-size: 13px;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        box-shadow: 0 4px 15px rgba(42, 145, 255, 0.25);
    }
    .btn-primary-v2:hover {
        background: linear-gradient(135deg, #52b5ff 0%, #2a91ff 100%);
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(42, 145, 255, 0.35);
    }
    .btn-primary-white {
        background: white;
        color: #0a0a12;
        font-weight: 600;
        padding: 12px 24px;
        border-radius: 100px;
        font-size: 13px;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .btn-primary-white:hover {
        background: #f0f0f0;
        transform: translateY(-1px);
    }
    .btn-secondary-v2 {
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.15);
        color: white;
        font-weight: 500;
        padding: 12px 24px;
        border-radius: 50px;
        font-size: 14px;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-secondary-v2:hover {
        background: rgba(255,255,255,0.12);
        border-color: rgba(255,255,255,0.25);
    }
    
    /* === SEARCH BAR V2 - Better Visibility === */
    .search-bar-v2 {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 100px;
        transition: all 0.3s;
    }
    .search-bar-v2:focus-within {
        border-color: rgba(42, 145, 255, 0.4);
        background: rgba(255,255,255,0.08);
        box-shadow: 0 0 20px rgba(42, 145, 255, 0.1);
    }
    
    /* === PILL TABS - Enhanced === */
    .pill-tab {
        padding: 10px 22px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.25s ease;
    }
    .pill-tab-active {
        background: linear-gradient(135deg, #2a91ff 0%, #1a73f5 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(42, 145, 255, 0.3);
    }
    .pill-tab-inactive {
        background: rgba(255,255,255,0.06);
        color: rgba(255,255,255,0.7);
        border: 1px solid rgba(255,255,255,0.1);
    }
    .pill-tab-inactive:hover {
        background: rgba(255,255,255,0.1);
        color: white;
        border-color: rgba(255,255,255,0.15);
    }
    
    /* === TABLE V2 - Enhanced === */
    .table-v2 {
        border-collapse: separate;
        border-spacing: 0;
    }
    .table-v2 th {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: rgba(255,255,255,0.5);
        padding: 16px 20px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .table-v2 td {
        padding: 16px 20px;
        border-bottom: 1px solid rgba(255,255,255,0.06);
        font-size: 14px;
    }
    .table-v2 tr:hover td {
        background: rgba(42, 145, 255, 0.05);
    }
    
    /* === ANIMATIONS === */
    @keyframes fade-up {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-up {
        animation: fade-up 0.6s ease-out forwards;
    }
    
    /* === GLOW EFFECTS - Enhanced === */
    .glow-blue { box-shadow: 0 0 50px rgba(42, 145, 255, 0.2); }
    .glow-purple { box-shadow: 0 0 50px rgba(168, 85, 247, 0.2); }
    .glow-pink { box-shadow: 0 0 50px rgba(236, 72, 153, 0.2); }
    .glow-cyan { box-shadow: 0 0 50px rgba(34, 211, 238, 0.2); }
    
    /* === SKELETON LOADING === */
    .skeleton-v2 {
        background: linear-gradient(90deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.08) 50%, rgba(255,255,255,0.03) 100%);
        background-size: 200% 100%;
        animation: skeleton-shimmer 1.5s ease-in-out infinite;
        border-radius: 8px;
    }
    @keyframes skeleton-shimmer {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    /* === PREMIUM V3 ENHANCEMENTS === */
    
    /* Rotating Gradient Border Card */
    .card-premium-v3 {
        position: relative;
        background: #0D0D1A;
        border-radius: 20px;
        z-index: 1;
        overflow: hidden;
    }
    .card-premium-v3::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: conic-gradient(from 0deg, transparent 0deg 300deg, #3b82f6 360deg);
        animation: rotate-border 4s linear infinite;
        z-index: -1;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .card-premium-v3:hover::before {
        opacity: 1;
    }
    .card-premium-v3::after {
        content: '';
        position: absolute;
        inset: 2px;
        background: #0D0D1A;
        border-radius: 18px;
        z-index: -1;
    }
    @keyframes rotate-border {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* Weather Radar Visualization */
    .weather-radar {
        position: relative;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(59,130,246,0.1) 0%, transparent 70%);
        border: 1px solid rgba(255,255,255,0.05);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .radar-sweep {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: conic-gradient(from 0deg, rgba(59,130,246,0.4) 0deg, transparent 90deg);
        border-radius: 50%;
        animation: rotate-border 4s linear infinite;
        pointer-events: none;
    }
    .radar-circle {
        position: absolute;
        border-radius: 50%;
        border: 1px solid rgba(255,255,255,0.05);
    }
    .radar-dot {
        position: absolute;
        width: 6px;
        height: 6px;
        background: #3b82f6;
        border-radius: 50%;
        box-shadow: 0 0 10px #3b82f6;
        animation: pulse-dot 2s infinite;
    }
    @keyframes pulse-dot {
        0%, 100% { opacity: 0.3; transform: scale(1); }
        50% { opacity: 1; transform: scale(1.5); }
    }

    /* Glass List Items */
    .glass-list-item {
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 16px;
        transition: all 0.3s ease;
    }
    .glass-list-item:hover {
        background: rgba(255,255,255,0.05);
        border-color: rgba(255,255,255,0.1);
        transform: translateX(8px);
    }

    /* Background Large Text */
    .bg-text-large {
        position: absolute;
        bottom: -10px;
        right: -10px;
        font-size: 80px;
        font-weight: 900;
        color: rgba(255,255,255,0.03);
        pointer-events: none;
        line-height: 1;
        text-transform: uppercase;
        font-style: italic;
    }

    /* Insight Glow Icon */
    .insight-glow-icon {
        position: relative;
        z-index: 1;
    }
    .insight-glow-icon::before {
        content: '';
        position: absolute;
        inset: -10px;
        background: radial-gradient(circle, currentColor 0%, transparent 70%);
        opacity: 0.15;
        z-index: -1;
        border-radius: 50%;
    }

    /* Mosaic Layout */
    .mosaic-card {
        background: #0D0D1A;
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 24px;
        padding: 24px;
        transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
        position: relative;
        overflow: hidden;
    }
    .mosaic-card:hover {
        background: #12121F;
        border-color: rgba(59, 130, 246, 0.3);
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0,0,0,0.4), 0 0 20px rgba(59, 130, 246, 0.1);
    }
    .mosaic-icon-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #3b82f6;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-bottom: 20px;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    /* Hyper-Premium Weather Radar */
    .tactical-scan {
        position: relative;
        width: 240px;
        height: 240px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .scan-ring {
        position: absolute;
        border-radius: 50%;
        border: 1px solid rgba(59, 130, 246, 0.1);
        transition: all 0.5s ease;
    }
    .scan-ring-outer {
        width: 100%;
        height: 100%;
        border-style: dashed;
        border-width: 2px;
        animation: rotate-border 20s linear infinite;
        opacity: 0.3;
    }
    .scan-ring-mid {
        width: 75%;
        height: 75%;
        border-color: rgba(139, 92, 246, 0.15);
        animation: rotate-border 12s linear infinite reverse;
    }
    .scan-ring-inner {
        width: 50%;
        height: 50%;
        border-color: rgba(236, 72, 153, 0.2);
        animation: rotate-border 8s linear infinite;
    }
    .scan-flicker {
        position: absolute;
        width: 100%;
        height: 100%;
        background: conic-gradient(from 0deg, rgba(59, 130, 246, 0.15) 0deg, transparent 60deg);
        border-radius: 50%;
        animation: rotate-border 4s linear infinite;
    }
    .projection-line {
        position: absolute;
        height: 1px;
        background: linear-gradient(90deg, rgba(59, 130, 246, 0.5), transparent);
        transform-origin: left center;
        pointer-events: none;
        opacity: 0.3;
        z-index: 0;
    }
    .counting-number {
        font-variant-numeric: tabular-nums;
    }
    .sync-blip {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #10b981;
        position: relative;
    }
    .sync-blip::after {
        content: '';
        position: absolute;
        inset: -4px;
        border: 1px solid #10b981;
        border-radius: 50%;
        animation: ping 2s cubic-bezier(0, 0, 0.2, 1) infinite;
    }
    /* Premium Topic Slider */
    .slider-container {
        display: flex;
        overflow-x: auto;
        scroll-behavior: smooth;
        -ms-overflow-style: none;
        scrollbar-width: none;
        scroll-snap-type: x mandatory;
        gap: 24px;
        padding: 4px;
    }
    .slider-container::-webkit-scrollbar {
        display: none;
    }
    .topic-card-premium {
        flex: 0 0 400px;
        scroll-snap-align: start;
        background: #080815;
        border: 1px solid rgba(255, 255, 255, 0.03);
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    }
    .topic-card-premium:hover {
        border-color: rgba(59, 130, 246, 0.3);
        transform: translateY(-8px);
        box-shadow: 0 24px 48px rgba(0, 0, 0, 0.5);
    }
    .topic-category-tag {
        font-size: 11px;
        font-weight: 700;
        text-transform: capitalize;
        color: #3b82f6;
    }
    .nav-btn {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        border: 1px solid rgba(255, 255, 255, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        transition: all 0.3s;
    }
    .nav-btn:hover {
        background: white;
        color: #050510;
        border-color: white;
    }
    .nav-btn:disabled {
        opacity: 0.2;
        cursor: not-allowed;
    }
    .contributor-avatar {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        object-fit: cover;
    }
    /* Quick Action Strip */
    .quick-action-pill {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 100px;
        padding: 8px 20px;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .quick-action-pill:hover {
        background: rgba(255, 255, 255, 0.06);
        border-color: rgba(255, 255, 255, 0.15);
        transform: translateY(-2px);
    }
    .quick-action-pill .icon-plus {
        width: 20px;
        height: 20px;
        background: #3b82f6;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
        font-weight: bold;
    }
</style>
@endpush

@section('content')
    {{-- =========================================
         HERO SECTION V2
         ========================================= --}}
    <section class="pt-28 pb-16 bg-primary section-divider">
        <div class="max-w-[1200px] mx-auto px-8">
            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-500/10 border border-blue-500/20 mb-6">
                <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                <span class="text-blue-400 text-tag">Community Driven</span>
            </div>
            
            {{-- Title --}}
            <h1 class="text-hero-v2 text-white mb-4">
                THE ULTIMATE OPEN-SOURCE<br>
                MUSIC ARCHIVE & ENCYCLOPEDIA
            </h1>
            
            {{-- Disclaimer --}}
            <p class="text-section-subhead mb-10 max-w-lg">
                Independent, unbiased, and powered by listeners. We're a community-run platform dedicated to archiving music history, free from the algorithms of major streaming services. Not affiliated with SoundCloud.
            </p>
            
            {{-- Search Bar --}}
            <form action="{{ route('search') }}" method="GET" class="max-w-[620px] mb-8">
                <div class="search-bar-v2 flex items-center">
                    <svg class="w-5 h-5 text-gray-500 ml-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input 
                        type="text" 
                        name="q" 
                        placeholder="Search for artists, songs, genres..." 
                        class="flex-1 bg-transparent border-none focus:ring-0 text-white placeholder-gray-500 px-4 py-4 text-[15px]"
                    >
                    <button type="submit" class="btn-primary-v2 m-1.5">
                        Search
                        <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                    </button>
                </div>
            </form>

            {{-- Quick Stats --}}
            <div class="flex flex-wrap items-center gap-8 text-[13px] text-gray-500">
                <span><strong class="text-white font-semibold">{{ number_format($heroStats['articles'] ?? 0) }}</strong> Articles</span>
                <span><strong class="text-white font-semibold">{{ number_format($heroStats['contributors'] ?? 0) }}</strong> Contributors</span>
                <span><strong class="text-white font-semibold">{{ number_format($heroStats['genres'] ?? 0) }}</strong> Genres Covered</span>
            </div>
        </div>
    </section>

    <section class="py-10 bg-secondary section-divider border-t border-white/5">
        <div class="max-w-[1200px] mx-auto px-8 flex flex-col md:flex-row items-center gap-10">
            <span class="text-[11px] font-black text-white/30 uppercase tracking-[0.2em] whitespace-nowrap">Global Operations</span>
            
            <div class="flex flex-wrap items-center gap-4">
                <a href="{{ route('wiki.create') }}" class="quick-action-pill group">
                    <span class="text-white/60 text-sm font-bold group-hover:text-white transition-colors">Create Record</span>
                    <div class="icon-plus">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </div>
                </a>
                
                <a href="{{ route('wiki.index') }}" class="quick-action-pill group">
                    <span class="text-white/60 text-sm font-bold group-hover:text-white transition-colors">Archive Browser</span>
                    <div class="icon-plus">
                        <svg class="w-2 h-2" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>
                    </div>
                </a>
                
                <a href="{{ route('leaderboard') }}" class="quick-action-pill group">
                    <span class="text-white/60 text-sm font-bold group-hover:text-white transition-colors">Impact Index</span>
                    <div class="icon-plus">
                        <svg class="w-2 h-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </div>
                </a>
                
                @auth
                <a href="{{ route('profile', auth()->user()->username) }}" class="quick-action-pill group">
                    <span class="text-white/60 text-sm font-bold group-hover:text-white transition-colors">My Identity</span>
                    <div class="icon-plus">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                </a>
                @endauth
            </div>
        </div>
    </section>



    {{-- =========================================
         NEW TOPICS SECTION - FIGMA QUALITY
         ========================================= --}}
    <section class="py-24 bg-[#1A1A2E] relative overflow-hidden" 
        x-data="{ 
            loaded: false,
            canScrollLeft: false,
            canScrollRight: true,
            scroll(direction) {
                const container = this.$refs.slider;
                const scrollAmount = 340; // Card width + gap
                container.scrollBy({ left: direction === 'left' ? -scrollAmount : scrollAmount, behavior: 'smooth' });
                setTimeout(() => this.updateArrows(), 400);
            },
            updateArrows() {
                const container = this.$refs.slider;
                this.canScrollLeft = container.scrollLeft > 0;
                this.canScrollRight = container.scrollLeft < (container.scrollWidth - container.clientWidth - 10);
            }
        }" 
        x-init="setTimeout(() => { loaded = true; updateArrows(); }, 600)">
        
        <div class="max-w-[1400px] mx-auto px-8">
            {{-- Section Header --}}
            <div class="flex items-start justify-between mb-12">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l2.4 7.2h7.6l-6.1 4.5 2.3 7.3-6.2-4.5-6.2 4.5 2.3-7.3-6.1-4.5h7.6z"/>
                        </svg>
                        <h2 class="text-3xl font-bold text-white">New Topics</h2>
                    </div>
                    <p class="text-white/50 text-sm">Recently added by the community</p>
                </div>
                
                {{-- Navigation Arrows --}}
                <div class="flex items-center gap-3">
                    <button 
                        @click="scroll('left')" 
                        :disabled="!canScrollLeft"
                        :class="canScrollLeft ? 'bg-white/10 hover:bg-white/20' : 'bg-white/5 opacity-40 cursor-not-allowed'"
                        class="w-12 h-12 rounded-full flex items-center justify-center text-white transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button 
                        @click="scroll('right')" 
                        :disabled="!canScrollRight"
                        :class="canScrollRight ? 'bg-white/10 hover:bg-white/20' : 'bg-white/5 opacity-40 cursor-not-allowed'"
                        class="w-12 h-12 rounded-full flex items-center justify-center text-white transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Skeleton Loading --}}
            <div x-show="!loaded" class="flex gap-6">
                <div class="flex-shrink-0 w-[320px] h-[440px] bg-white/5 rounded-3xl animate-pulse"></div>
                <div class="flex-shrink-0 w-[320px] h-[440px] bg-white/5 rounded-3xl animate-pulse"></div>
                <div class="flex-shrink-0 w-[320px] h-[440px] bg-white/5 rounded-3xl animate-pulse"></div>
                <div class="flex-shrink-0 w-[320px] h-[440px] bg-white/5 rounded-3xl animate-pulse"></div>
            </div>

            {{-- Cards Container --}}
            <div 
                x-show="loaded" 
                x-ref="slider"
                @scroll.debounce.100ms="updateArrows()"
                class="flex gap-6 overflow-x-auto scrollbar-hide scroll-smooth"
                style="display: none; scrollbar-width: none; -ms-overflow-style: none;">
                
                @if($newTopicCards->isEmpty())
                    <div class="text-white/50 text-sm">No new topics yet. Be the first to publish a record.</div>
                @else
                @foreach($newTopicCards as $topic)
                <a href="{{ $topic['url'] }}" class="flex-shrink-0 w-[320px] group">
                    <div class="relative h-[440px] rounded-3xl overflow-hidden bg-[#0D0D1A] border border-white/5 hover:border-white/10 transition-all duration-500">
                        {{-- Large Cover Image --}}
                        <div class="absolute inset-0">
                            @if($topic['image'])
                                <img 
                                    src="{{ $topic['image'] }}" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" 
                                    alt="{{ $topic['title'] }}">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-900/40 via-purple-900/30 to-black"></div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0D0D1A] via-[#0D0D1A]/60 to-transparent"></div>
                        </div>

                        {{-- Content Overlay --}}
                        <div class="absolute inset-0 p-6 flex flex-col justify-end">
                            {{-- Category Tag --}}
                            <div class="mb-3">
                                <span class="inline-block px-3 py-1 bg-blue-600/20 backdrop-blur-sm border border-blue-500/30 rounded-lg text-blue-400 text-[10px] font-bold uppercase tracking-wider">
                                    {{ $topic['category'] }}
                                </span>
                            </div>

                            {{-- Title --}}
                            <h3 class="text-2xl font-bold text-white mb-2 leading-tight">
                                {{ $topic['title'] }}
                            </h3>

                            {{-- Description --}}
                            <p class="text-white/60 text-sm mb-4 line-clamp-2">
                                {{ $topic['desc'] }}
                            </p>

                            {{-- User Info --}}
                            <div class="flex items-center gap-2 mb-4">
                                <div class="w-6 h-6 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                    <span class="text-white text-[10px] font-bold">{{ strtoupper(substr($topic['user'], 0, 1)) }}</span>
                                </div>
                                <div class="flex-1">
                                    <span class="text-white text-xs font-medium">{{ $topic['user'] }}</span>
                                </div>
                                <span class="text-white/40 text-[10px]">{{ $topic['date'] }}</span>
                            </div>

                            {{-- Stats Row --}}
                            <div class="flex items-center gap-4 pt-3 border-t border-white/10">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <span class="text-white/60 text-xs font-medium">{{ number_format($topic['views']) }}</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <span class="text-white/60 text-xs font-medium">{{ number_format($topic['edits']) }} edits</span>
                                </div>
                                <div class="flex items-center gap-1.5 ml-auto">
                                    <svg class="w-4 h-4 text-white/40" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-white/60 text-xs font-medium">{{ number_format($topic['edits']) }} edits</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
                @endif
            </div>
        </div>
    </section>

    {{-- =========================================
         REAL-TIME MUSIC WEATHER V2 - WITH SKELETON
         ========================================= --}}
    <section class="py-16 bg-primary section-divider" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 1000)">
        <div class="max-w-[1200px] mx-auto px-8">
            {{-- Skeleton State --}}
            <div x-show="!loaded" class="flex flex-col lg:flex-row items-center gap-12">
                <div class="flex-shrink-0">
                    <x-skeleton type="progress-ring" />
                </div>
                <div class="flex-1 w-full">
                    <div class="skeleton-v2 h-5 w-48 mb-6" style="background: linear-gradient(90deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.08) 50%, rgba(255,255,255,0.03) 100%); background-size: 200% 100%; animation: skeleton-shimmer 1.5s ease-in-out infinite; border-radius: 8px;"></div>
                    <div class="grid grid-cols-3 gap-6 lg:gap-12">
                        <x-skeleton type="stat-card" :count="3" />
                    </div>
                </div>
            </div>

            {{-- Loaded State --}}
            <div x-show="loaded" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="flex flex-col lg:flex-row items-center gap-20" style="display: none;">
                {{-- Hyper-Premium Tactical Scan Radar --}}
                <div class="flex-shrink-0 relative">
                    <div class="tactical-scan">
                        {{-- Concentric Scanning Rings --}}
                        <div class="scan-ring scan-ring-outer"></div>
                        <div class="scan-ring scan-ring-mid"></div>
                        <div class="scan-ring scan-ring-inner"></div>
                        
                        {{-- Scanning Flicker effect --}}
                        <div class="scan-flicker"></div>
                        
                        {{-- Data Nodes --}}
                        <div class="radar-dot" style="top: 30%; left: 30%; animation-delay: 0.2s;"></div>
                        <div class="radar-dot" style="top: 55%; left: 65%; animation-delay: 0.8s;"></div>
                        <div class="radar-dot" style="top: 45%; left: 20%; animation-delay: 1.5s;"></div>
                        
                        {{-- Center Core --}}
                        <div class="relative z-10 text-center">
                            <div class="relative">
                                <span class="text-[44px] font-black text-white block leading-none tracking-tighter counting-number">{{ $musicPulse['live_flow'] ?? 0 }}</span>
                                <span class="absolute -top-1 -right-4 text-blue-500 font-bold">%</span>
                            </div>
                            <span class="text-[10px] text-blue-400 font-bold uppercase tracking-[0.2em] mt-1 block">Live Flow</span>
                        </div>
                    </div>
                    
                    {{-- Projection Lines pointing to stats (Visual only) --}}
                    <div class="projection-line w-24 left-[240px] top-[40px] rotate-[15deg] hidden lg:block"></div>
                    <div class="projection-line w-24 left-[240px] top-[120px] rotate-[0deg] hidden lg:block"></div>
                    <div class="projection-line w-24 left-[240px] top-[200px] rotate-[-15deg] hidden lg:block"></div>
                </div>

                {{-- Content Dashboard --}}
                <div class="flex-1 w-full">
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-6">
                        <div class="max-w-md">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="px-3 py-1 bg-blue-500/10 border border-blue-500/20 rounded-lg text-[10px] text-blue-400 font-black uppercase tracking-widest">Global Music Pulse</div>
                                <div class="h-px flex-1 bg-gradient-to-r from-blue-500/30 to-transparent"></div>
                            </div>
                            <h2 class="text-4xl font-black text-white italic tracking-tight mb-3">LISTENING PULSE INDEX</h2>
                            <p class="text-white/40 leading-relaxed font-medium">This tactical visualization tracks real-time community engagement, artist momentum, and emerging subgenres across the ChaynWiki network.</p>
                        </div>
                        
                        <div class="flex items-center gap-4 p-4 bg-white/5 border border-white/10 rounded-2xl backdrop-blur-md">
                            <div class="sync-blip"></div>
                            <div>
                                <span class="text-white font-bold block leading-none mb-1">LIVE SYNCED</span>
                                <span class="text-[10px] text-gray-500 font-black uppercase tracking-widest">{{ number_format($musicPulse['edits_today'] ?? 0) }} edits today</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Stat 1 --}}
                        <div class="group relative">
                            <div class="absolute inset-0 bg-blue-500/10 blur-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="card-v2 p-8 relative z-10 border-blue-500/10 group-hover:border-blue-500/30">
                                <div class="flex items-start justify-between mb-8">
                                    <div class="p-3 bg-blue-500/10 rounded-xl text-blue-400 border border-blue-500/10">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-blue-400 text-xs font-black uppercase tracking-widest">{{ number_format($musicPulse['edits_week'] ?? 0) }} / 7d</span>
                                    </div>
                                </div>
                                <p class="text-white/40 text-[11px] font-black uppercase tracking-[0.15em] mb-1">Network Activity</p>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-3xl font-black text-white italic">{{ number_format($musicPulse['edits_week'] ?? 0) }} edits</span>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Stat 2 --}}
                        <div class="group relative">
                            <div class="absolute inset-0 bg-purple-500/10 blur-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="card-v2 p-8 relative z-10 border-purple-500/10 group-hover:border-purple-500/30">
                                <div class="flex items-start justify-between mb-8">
                                    <div class="p-3 bg-purple-500/10 rounded-xl text-purple-400 border border-purple-500/10">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.99 7.99 0 0120 13a7.99 7.99 0 01-2.343 5.657z"/></svg>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-purple-400 text-xs font-black uppercase tracking-widest">{{ number_format($musicPulse['new_articles_week'] ?? 0) }} / 7d</span>
                                    </div>
                                </div>
                                <p class="text-white/40 text-[11px] font-black uppercase tracking-[0.15em] mb-1">Global Sentiment</p>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-3xl font-black text-white italic">{{ number_format($musicPulse['new_articles_week'] ?? 0) }} new</span>
                                </div>
                            </div>
                        </div>

                        {{-- Stat 3 --}}
                        <div class="group relative">
                            <div class="absolute inset-0 bg-pink-500/10 blur-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="card-v2 p-8 relative z-10 border-pink-500/10 group-hover:border-pink-500/30">
                                <div class="flex items-start justify-between mb-8">
                                    <div class="p-3 bg-pink-500/10 rounded-xl text-pink-400 border border-pink-500/10">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-pink-400 text-xs font-black uppercase tracking-widest">{{ number_format($musicPulse['active_contributors_week'] ?? 0) }} active</span>
                                    </div>
                                </div>
                                <p class="text-white/40 text-[11px] font-black uppercase tracking-[0.15em] mb-1">Active Mentions</p>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-3xl font-black text-white italic">{{ number_format($musicPulse['active_contributors_week'] ?? 0) }} people</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- =========================================
         BROWSE BY CATEGORY V2 - INTERACTIVE TABS
         ========================================= --}}
    <section class="py-16 bg-secondary section-divider" 
        x-data='(() => {
            const categories = @json($categoryTabs ?? []);
            return {
                activeTab: Object.keys(categories)[0] || "All",
                loading: false,
                categories,
                switchTab(tab) {
                    if (this.activeTab === tab) return;
                    this.loading = true;
                    this.activeTab = tab;
                    setTimeout(() => { this.loading = false; }, 600);
                }
            };
        })()'>
        <div class="max-w-[1200px] mx-auto px-8">
            <h2 class="text-section-heading text-white mb-2">Browse by Category</h2>
            <p class="text-section-subhead mb-8">Explore the encyclopedia by filtering content type or genre.</p>
            
            {{-- Interactive Category Pills --}}
            <div class="flex flex-wrap gap-2 mb-8">
                <template x-for="tab in Object.keys(categories)" :key="tab">
                    <button 
                        @click="switchTab(tab)"
                        :class="activeTab === tab ? 'pill-tab pill-tab-active' : 'pill-tab pill-tab-inactive'"
                        x-text="tab">
                    </button>
                </template>
            </div>

            {{-- Loading Skeleton --}}
            <div x-show="loading" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @for($i = 0; $i < 4; $i++)
                <div class="skeleton-card-v2 flex items-center justify-between p-4" style="background: linear-gradient(135deg, rgba(255,255,255,0.02) 0%, rgba(255,255,255,0.01) 100%); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 16px;">
                    <div>
                        <div class="skeleton-v2 h-4 w-24 mb-2"></div>
                        <div class="skeleton-v2 h-3 w-16"></div>
                    </div>
                    <div class="skeleton-v2 w-4 h-4 rounded"></div>
                </div>
                @endfor
            </div>

            {{-- Dynamic Category Grid --}}
            <div x-show="!loading" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <template x-if="!categories[activeTab] || categories[activeTab].length === 0">
                    <div class="col-span-2 md:col-span-4 text-white/40 text-sm">No items available yet.</div>
                </template>
                <template x-for="(item, index) in categories[activeTab]" :key="index">
                    <a :href="item.url" class="card-v2 flex items-center justify-between p-4 group cursor-pointer">
                        <div class="flex items-center gap-3">
                            <span class="text-xl" x-text="item.icon"></span>
                            <div>
                                <span class="text-[14px] text-white group-hover:text-blue-400 transition-colors" x-text="item.name"></span>
                                <span class="block text-[12px] text-gray-600" x-text="item.count"></span>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-gray-600 group-hover:text-blue-400 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </template>
            </div>
        </div>
    </section>

    {{-- =========================================
         DISCOVER SECTION V2
         ========================================= --}}
    <section class="py-16 bg-primary section-divider">
        <div class="max-w-[1200px] mx-auto px-8">
            <div class="mb-16">
                <h2 class="text-[32px] font-bold text-white mb-2 uppercase tracking-tight">The Soundtrack of Right Now</h2>
                <p class="text-white/40 text-lg">From emerging underground subgenres to the mainstream's biggest shifts.</p>
            </div>

            @php
                $discoverIcons = [
                    'artist' => '🎤',
                    'song' => '🎵',
                    'genre' => '🎸',
                    'playlist' => '📀',
                    'term' => '🧠',
                ];
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12">
                @if($trendingArticles->isEmpty())
                    <div class="text-white/40 text-sm">No discoveries yet. Publish a topic to get things moving.</div>
                @else
                    @foreach($trendingArticles as $article)
                        <a href="{{ route('wiki.show', $article->slug) }}" class="mosaic-card group cursor-pointer">
                            <div class="mosaic-icon-circle">
                                <span class="text-sm">{{ $discoverIcons[$article->category] ?? '📚' }}</span>
                            </div>
                            <h3 class="text-xl font-black text-white mb-4 uppercase tracking-[0.05em]">{{ $article->title }}</h3>
                            <p class="text-white/40 text-[14px]">{{ number_format($article->view_count) }} views · {{ ucfirst($article->category) }}</p>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    {{-- =========================================
         RANKED ITEMS V2
         ========================================= --}}
    <section class="py-16 bg-secondary section-divider">
        <div class="max-w-[1200px] mx-auto px-8">
            <div class="flex items-center justify-between mb-10">
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 bg-yellow-500/10 rounded-xl flex items-center justify-center text-yellow-500">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </span>
                    <h2 class="text-section-heading text-white">Ranked Items</h2>
                </div>
                <a href="{{ route('leaderboard') }}" class="btn-secondary-v2 py-2 px-6">View Full Rankings</a>
            </div>

            <div class="space-y-4">
                @php
                    $rankIcons = [
                        'artist' => '🎤',
                        'song' => '🎵',
                        'genre' => '🎸',
                        'playlist' => '📀',
                        'term' => '🧠',
                    ];
                @endphp
                @if($rankedArticles->isEmpty())
                    <div class="text-white/40 text-sm">No rankings yet. Views will surface top items here.</div>
                @else
                @foreach($rankedArticles as $i => $article)
                <div class="glass-list-item p-5 flex flex-col md:flex-row md:items-center justify-between gap-6 group">
                    <div class="flex items-center gap-6">
                        {{-- Rank Number --}}
                        <div class="w-10 h-10 flex items-center justify-center">
                            @if($i < 3)
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br @if($i==0) from-yellow-400 to-orange-500 @elseif($i==1) from-gray-300 to-gray-500 @else from-orange-400 to-red-600 @endif flex items-center justify-center shadow-lg @if($i==0) shadow-yellow-500/20 @endif">
                                    <span class="text-white font-black text-sm">{{ $i + 1 }}</span>
                                </div>
                            @else
                                <span class="text-white/20 font-black text-lg">{{ $i + 1 }}</span>
                            @endif
                        </div>
                        
                        {{-- Content --}}
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                                {{ $rankIcons[$article->category] ?? '📚' }}
                            </div>
                            <div>
                                <h4 class="text-white font-bold group-hover:text-blue-400 transition-colors">
                                    <a href="{{ route('wiki.show', $article->slug) }}">{{ $article->title }}</a>
                                </h4>
                                <span class="text-[11px] text-gray-500 uppercase tracking-widest">{{ ucfirst($article->category) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-8 justify-between md:justify-end">
                        {{-- Metrics --}}
                        <div class="text-right">
                            <div class="flex items-center gap-2">
                                <span class="text-white font-bold">{{ number_format($article->view_count) }}</span>
                                @if($article->trending_score > 0)
                                    <span class="text-green-500 text-[11px] font-bold">{{ number_format($article->trending_score, 1) }}</span>
                                @endif
                            </div>
                            <span class="text-[11px] text-gray-500 uppercase tracking-widest text-right block">Views / Trend</span>
                        </div>
                        
                        {{-- Contributor --}}
                        <div class="flex items-center gap-3 pr-4">
                            <div class="text-right">
                                <span class="text-white/60 text-sm font-medium">{{ $article->user ? '@' . $article->user->username : 'Community' }}</span>
                                <span class="text-[10px] text-gray-600 uppercase tracking-widest block">Contributor</span>
                            </div>
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 p-0.5">
                                <div class="w-full h-full rounded-full bg-[#050511] flex items-center justify-center text-[10px] text-white">
                                    {{ strtoupper(substr($article->user?->username ?? 'C', 0, 1)) }}
                                </div>
                            </div>
                        </div>

                        {{-- Action --}}
                        <button class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-white/40 group-hover:bg-blue-500 group-hover:text-white group-hover:border-blue-500 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </section>

    {{-- =========================================
         COMMUNITY INSIGHTS V2
         ========================================= --}}
    <section class="py-16 bg-primary section-divider">
        <div class="max-w-[1200px] mx-auto px-8">
            <div class="flex items-center gap-3 mb-10">
                <div class="w-1.5 h-8 bg-blue-500/40 rounded-full"></div>
                <h2 class="text-section-heading text-white">Community Insights</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @if($insightCards->isEmpty())
                    <div class="text-white/40 text-sm">No insight data available yet.</div>
                @else
                @foreach($insightCards as $insight)
                <a href="{{ $insight['url'] }}" class="@if($insight['premium']) card-premium-v3 @else card-v2 @endif p-8 flex flex-col justify-between group h-[220px]">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-[10px] font-black text-white/40 uppercase tracking-[0.2em] mb-4">{{ $insight['label'] }}</p>
                            <h3 class="text-2xl font-black text-white group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r @if($insight['gradient'] == 'grad-purple') from-purple-400 to-pink-500 @elseif($insight['gradient'] == 'grad-blue') from-blue-400 to-cyan-500 @else from-pink-400 to-orange-500 @endif transition-all">
                                {{ $insight['value'] }}
                            </h3>
                        </div>
                        <div class="insight-glow-icon text-2xl group-hover:scale-125 transition-transform duration-500" style="color: {{ $insight['color'] }}">
                            {{ $insight['icon'] }}
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-white/40 font-medium">{{ $insight['meta'] }}</p>
                        <svg class="w-5 h-5 text-white/20 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </div>
                </a>
                @endforeach
                @endif
            </div>
        </div>
    </section>

    {{-- =========================================
         CTA SECTION V2
         ========================================= --}}
    <section class="py-20 bg-secondary">
        <div class="max-w-[1200px] mx-auto px-8 text-center">
            <div class="max-w-xl mx-auto">
                <h2 class="text-[24px] md:text-[28px] font-bold text-white mb-4 leading-tight uppercase">
                    Is there a missing piece in our music history?
                </h2>
                <p class="text-section-subhead mb-8">
                    ChaynWiki is built by the records you love. If an artist, song, or movement is missing, start the archive yourself today.
                </p>
                <div class="flex flex-wrap items-center justify-center gap-4">
                    <a href="{{ route('wiki.create') }}" class="btn-primary-v2">
                        Create New Topic
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </a>
                    <a href="{{ route('wiki.index') }}" class="btn-secondary-v2">
                        Browse All Topics
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
