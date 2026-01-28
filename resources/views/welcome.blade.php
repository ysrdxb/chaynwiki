<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChaynWiki - Your Community-Driven Music Encyclopedia</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 400: '#60a5fa',
                            500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a', 950: '#172554',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    },
                    animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .text-gradient {
            background: linear-gradient(135deg, #fff 0%, #94a3b8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="antialiased bg-[#050511] min-h-screen text-white overflow-x-hidden font-sans selection:bg-brand-500 selection:text-white">
    
    <!-- Hero Background with Animated Overlay -->
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute inset-0 bg-[#050511]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_var(--tw-gradient-stops))] from-brand-900/30 via-[#050511] to-[#050511]"></div>
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-[0.04]"></div>
        <!-- Animated gradient orbs -->
        <div class="absolute top-1/4 -left-32 w-96 h-96 bg-brand-600/10 rounded-full blur-[100px] animate-pulse-slow"></div>
        <div class="absolute bottom-1/4 -right-32 w-96 h-96 bg-purple-600/10 rounded-full blur-[100px] animate-pulse-slow" style="animation-delay: 1s;"></div>
    </div>

    <!-- Navigation -->
    <x-navigation />

    <div class="relative z-10">
        
        <!-- Section: Hero -->
        <section class="relative pt-32 pb-24 border-b border-white/10 overflow-hidden">
            <!-- Decorative Star -->
            <div class="absolute top-12 right-12 text-white/20 select-none">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0l2.5 9.5 9.5 2.5-9.5 2.5-2.5 9.5-2.5-9.5-9.5-2.5 9.5-2.5z"/></svg>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="max-w-4xl">
                    <!-- Decorative circular element -->
                    <div class="mb-10">
                        <div class="inline-flex items-center gap-3 px-4 py-2.5 rounded-full border border-white/10 bg-[#0f0f1a]">
                            <span class="w-2 h-2 rounded-full bg-white/60"></span>
                            <span class="text-[10px] font-medium text-white/60 uppercase tracking-[0.15em]">Community Driven</span>
                        </div>
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-display font-black text-white mb-8 tracking-[-0.03em] leading-[1.05] uppercase">
                        <span class="font-sans font-medium tracking-normal">Your Community-Driven</span><br>
                        <span class="text-gradient">Music Encyclopedia</span>
                    </h1>

                    <!-- Simple Search Bar -->
                    <div class="max-w-3xl mb-12">
                        <form action="{{ route('search') }}" method="GET" class="relative">
                            <div class="flex items-center bg-[#0f0f1a] border border-white/10 rounded-full p-2">
                                <div class="pl-4 pr-3">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                                <input 
                                    type="text" 
                                    name="q"
                                    placeholder="Search for a song, artist, or genre..." 
                                    class="flex-1 bg-transparent border-none text-white placeholder-gray-500 focus:ring-0 px-2 py-3 text-sm"
                                >
                                <button type="submit" class="bg-white text-black rounded-full px-6 py-2.5 font-bold text-sm hover:bg-gray-100 transition-all">
                                    Search
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Pills Actions -->
                    <div class="flex flex-wrap gap-3 mb-8">
                        <a href="{{ route('wiki.create') }}" class="flex items-center gap-2 px-5 py-2.5 rounded-full border border-white/5 bg-[#0f0f1a] hover:border-white/20 transition-all">
                            <svg class="w-3.5 h-3.5 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            <span class="text-xs font-bold text-white/80 uppercase tracking-wider">CONTRIBUTE A TOPIC</span>
                        </a>
                        <a href="{{ route('wiki.index') }}" class="flex items-center gap-2 px-5 py-2.5 rounded-full border border-white/5 bg-[#0f0f1a] hover:border-white/20 transition-all">
                            <svg class="w-3.5 h-3.5 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            <span class="text-xs font-bold text-white/80 uppercase tracking-wider">BROWSE CATEGORIES</span>
                        </a>
                    </div>

                    <!-- Quick Categories -->
                    <div class="flex flex-wrap gap-3">
                        @php
                            $quickCats = [
                                ['label' => 'Artists'],
                                ['label' => 'Lyrics'],
                                ['label' => 'Live Changes'],
                                ['label' => 'Masterline'],
                            ];
                        @endphp
                        @foreach($quickCats as $qc)
                        <a href="#" class="flex items-center gap-2 px-4 py-2 rounded-full border border-white/5 bg-[#0f0f1a] hover:border-white/20 transition-all">
                            <svg class="w-3 h-3 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            <span class="text-[10px] font-bold text-white/50 uppercase tracking-wider">{{ $qc['label'] }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 1: New Topics -->
        <section class="border-b border-white/10 py-24 relative overflow-hidden">
            <!-- Decorative Star -->
            <div class="absolute bottom-12 left-12 text-white/20 select-none">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0l2.5 9.5 9.5 2.5-9.5 2.5-2.5 9.5-2.5-9.5-9.5-2.5 9.5-2.5z"/></svg>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h2 class="text-3xl font-display font-black text-white mb-2 uppercase tracking-tight">NEW TOPICS</h2>
                    <p class="text-gray-500 text-xs font-mono uppercase tracking-[0.2em]">Recently added by the community</p>
                </div>
                <div class="flex gap-2">
                    <button class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-white hover:bg-white/10 transition">&larr;</button>
                    <button class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-white hover:bg-white/10 transition">&rarr;</button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($newTopics->take(3) as $topic)
                <div class="bg-[#0A0A14] rounded-[24px] border border-white/10 hover:border-white/20 transition-all duration-300 overflow-hidden flex flex-col h-full">
                    <div class="relative aspect-video overflow-hidden">
                        @php
                            $hasRealImage = $topic->featured_image && !str_contains($topic->featured_image, 'placehold.co');
                            $imagePath = $hasRealImage ? (str_starts_with($topic->featured_image, 'http') ? $topic->featured_image : Storage::url($topic->featured_image)) : asset('images/card_midnight.png');
                        @endphp
                        <img src="{{ $imagePath }}" class="w-full h-full object-cover opacity-70">
                        <div class="absolute top-4 left-4">
                            <span class="bg-brand-600 text-white text-[9px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">{{ $topic->category }}</span>
                        </div>
                    </div>
                    <div class="p-6 flex flex-col flex-1">
                        <h3 class="text-xl font-bold text-white mb-3 uppercase tracking-tight">{{ $topic->title }}</h3>
                        <p class="text-gray-500 text-xs leading-relaxed mb-8 line-clamp-2">
                            {{ Str::limit(strip_tags($topic->content), 100) }}
                        </p>
                        <div class="mt-auto pt-6 border-t border-white/5 flex items-center justify-between text-[11px] font-mono text-gray-500">
                            <div class="flex items-center gap-2">
                                <span class="w-5 h-5 rounded-full bg-brand-500/20 flex items-center justify-center text-[8px] text-brand-400 font-bold">A</span>
                                <span class="font-bold text-gray-400">Admin</span>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> {{ number_format($topic->view_count) }}</span>
                                <span class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> 2</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <!-- Section 2: Real-Time Music Weather -->
        <section class="border-b border-white/10 py-24 relative overflow-hidden">
            <!-- Decorative Star -->
            <div class="absolute top-12 right-12 text-white/20 select-none">
                <svg class="w-8 h-8 rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0l2.5 9.5 9.5 2.5-9.5 2.5-2.5 9.5-2.5-9.5-9.5-2.5 9.5-2.5z"/></svg>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center gap-16">
                <!-- Left: Radar Chart -->
                <div class="w-full md:w-1/2">
                    <h2 class="text-3xl font-bold text-white mb-2 relative z-10 uppercase tracking-tight">Real-Time Music Weather</h2>
                    <p class="text-gray-500 mb-12 relative z-10 max-w-lg text-xs leading-relaxed">Advanced AI visualization tracking global sonic shifts, emerging sub-cultures, and virality vectors in real-time.</p>
                    
                    <div class="relative aspect-square max-w-[400px] mx-auto">
                        <img src="{{ asset('images/music_weather_chart.png') }}" class="relative w-full h-full object-contain">
                        <div class="absolute -top-4 left-1/2 -translate-x-1/2 text-[9px] font-mono text-brand-400 tracking-[0.2em] uppercase">Pop Virality</div>
                        <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 text-[9px] font-mono text-purple-400 tracking-[0.2em] uppercase">Genre Depth</div>
                    </div>
                </div>

                <!-- Right: Legend Items -->
                <div class="w-full md:w-1/2 grid grid-cols-1 gap-4">
                    @php
                        $weatherStats = [
                            ['label' => 'Rising Genres', 'desc' => 'Emerging micro-cultures across global digital landscapes.', 'dot' => 'bg-blue-500'],
                            ['label' => 'Viral Artists', 'desc' => 'Creators maximizing audience engagement and reach.', 'dot' => 'bg-red-500'],
                            ['label' => 'Trending Songs', 'desc' => 'High-velocity tracks shifting sonic expectations.', 'dot' => 'bg-green-500'],
                            ['label' => 'Declining trends', 'desc' => 'Patterns losing momentum in the current meta-culture.', 'dot' => 'bg-pink-500'],
                        ];
                    @endphp
                    @foreach($weatherStats as $stat)
                    <div class="bg-[#0A0A14] border border-white/10 rounded-2xl p-6 hover:bg-white/[0.02] transition-all cursor-pointer">
                        <div class="flex items-center gap-4 mb-2">
                            <span class="w-3.5 h-3.5 rounded-full {{ $stat['dot'] }}"></span>
                            <h3 class="text-lg font-bold text-white uppercase tracking-tight">{{ $stat['label'] }}</h3>
                        </div>
                        <p class="text-gray-500 text-xs leading-relaxed max-w-sm pl-7">{{ $stat['desc'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Section 3: BROWSE BY CATEGORY -->
        <section class="border-b border-white/10 py-24 relative overflow-hidden">
            <!-- Decorative Star -->
            <div class="absolute bottom-12 left-12 text-white/20 select-none">
                <svg class="w-7 h-7 -rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0l2.5 9.5 9.5 2.5-9.5 2.5-2.5 9.5-2.5-9.5-9.5-2.5 9.5-2.5z"/></svg>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-display font-black text-white mb-2 uppercase tracking-tight">BROWSE BY CATEGORY</h2>
                    <p class="text-gray-500 text-xs font-mono uppercase tracking-[0.2em] max-w-2xl leading-relaxed">Explore the genres shaping today's music landscape — from timeless favorites to global sounds.</p>
                </div>
                <div class="flex gap-2">
                    <button class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-white hover:bg-white/10 transition">&larr;</button>
                    <button class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-white hover:bg-white/10 transition">&rarr;</button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @php
                    $categories = [
                        ['label' => 'Genres', 'icon' => 'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3', 'desc' => '2 851 entries, curated collections from various genres and sonic styles.', 'btn' => 'Explore Genre +'],
                        ['label' => 'Artists', 'icon' => 'M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z', 'desc' => '1 402 entries, discover creators shaping the global digital music culture.', 'btn' => 'View Artists +'],
                        ['label' => 'Songs', 'icon' => 'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3', 'desc' => '5 102 entries, lyrical analysis and sonic breakdowns of viral hits.', 'btn' => 'Explore Songs +'],
                    ];
                @endphp

                @foreach($categories as $cat)
                <div class="bg-[#0A0A14] border border-white/10 rounded-[32px] p-10 hover:bg-white/[0.02] transition-all flex flex-col items-start">
                    <div class="w-12 h-12 rounded-full bg-white/5 flex items-center justify-center mb-8">
                        <svg class="w-6 h-6 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M{{ $cat['icon'] }}"></path></svg>
                    </div>
                    <h3 class="text-2xl font-display font-black text-white mb-4 uppercase tracking-tight">{{ $cat['label'] }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-10">
                        {{ $cat['desc'] }}
                    </p>
                    <a href="#" class="inline-flex items-center gap-2 px-6 py-3 rounded-full border border-white/10 text-brand-400 text-xs font-bold uppercase tracking-wider hover:bg-brand-500 hover:text-white hover:border-brand-500 transition-all">
                        {{ $cat['btn'] }}
                    </a>
                </div>
                @endforeach
            </div>
        </section>

        <!-- Section 4: DISCOVER WHAT'S SHAPING TODAY'S MUSIC -->
        <section class="border-b border-white/10 py-24 relative overflow-hidden">
            <!-- Decorative Star -->
            <div class="absolute top-12 right-12 text-white/20 select-none">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0l2.5 9.5 9.5 2.5-9.5 2.5-2.5 9.5-2.5-9.5-9.5-2.5 9.5-2.5z"/></svg>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-display font-black text-white mb-2 uppercase tracking-tight">DISCOVER WHAT'S SHAPING TODAY'S MUSIC</h2>
            <p class="text-gray-500 text-xs font-mono uppercase tracking-[0.2em] mb-12">Keywords, moods, and tags designed to aid discoverability.</p>
            
            <div class="relative h-[400px] bg-gradient-to-b from-transparent to-[#050511] overflow-hidden">
                @php
                    $tags = [
                        ['label' => 'HYPERPOP', 'icon' => 'blue', 'pos' => 'top: 10%; left: 0%;'],
                        ['label' => 'BURNA BOY', 'icon' => 'purple', 'pos' => 'bottom: 20%; left: 15%;'],
                        ['label' => 'BLINDING LIGHTS', 'icon' => 'teal', 'pos' => 'top: 20%; left: 40%;'],
                        ['label' => 'AFROFUSION', 'icon' => 'pink', 'pos' => 'bottom: 10%; left: 55%;'],
                        ['label' => 'EMERGING SUBGENRE', 'icon' => 'gray', 'pos' => 'top: 30%; right: 0%;'],
                    ];
                @endphp

                @foreach($tags as $t)
                <div class="absolute group cursor-pointer transition-transform duration-300 hover:scale-105" style="{{ $t['pos'] }}">
                    <div class="flex flex-col bg-[#0A0A14] border border-white/10 rounded-2xl p-6">
                        <div class="mb-4">
                            @if($t['icon'] == 'blue')
                                <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-blue-400"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM5.884 6.68a1 1 0 101.415-1.414L6.593 4.56a1 1 0 00-1.414 1.414l.705.707zm5.912 2.154a1 1 0 11-1.414-1.414l.707-.707a1 1 0 111.414 1.414l-.707.707zM10 11a1 1 0 100-2 1 1 0 000 2zm-4.243 1.414l-.707.707a1 1 0 001.414 1.414l.707-.707a1 1 0 00-1.414-1.414zm5.657 0l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zM5 10a1 1 0 11-2 0 1 1 0 012 0zm12 0a1 1 0 11-2 0 1 1 0 012 0z"/></svg></div>
                            @elseif($t['icon'] == 'purple')
                                <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-purple-400"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-1.815-4.27C14.894 10.273 15.485 10 16 10a4 4 0 014 4v4h-4zM6.185 10.73A5.972 5.972 0 004 15v3H0v-3a4 4 0 014-4c.515 0 1.106.273 1.815.73z"/></svg></div>
                            @elseif($t['icon'] == 'teal')
                                <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-teal-400"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/></svg></div>
                            @elseif($t['icon'] == 'pink')
                                <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-pink-400"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg></div>
                            @else
                                <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-gray-400"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z"/></svg></div>
                            @endif
                        </div>
                        <h4 class="text-sm font-bold text-white mb-2 uppercase tracking-wider group-hover:text-brand-400 transition-colors">{{ $t['label'] }}</h4>
                        <span class="text-[10px] font-mono text-gray-500 tracking-wider uppercase">Rise Trend Sonic</span>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <!-- Section 5: RANKED ITEM -->
        <section class="border-b border-white/10 py-24 relative overflow-hidden">
            <!-- Decorative Star -->
            <div class="absolute bottom-12 left-12 text-white/20 select-none">
                <svg class="w-6 h-6 rotate-45" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0l2.5 9.5 9.5 2.5-9.5 2.5-2.5 9.5-2.5-9.5-9.5-2.5 9.5-2.5z"/></svg>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h2 class="text-3xl font-display font-black text-white mb-2 uppercase tracking-tight">RANKED ITEM</h2>
                    <p class="text-gray-500 text-xs font-mono uppercase tracking-[0.2em] leading-relaxed">Top rated, most popular songs, artists and trending music rankings.</p>
                </div>
                <div class="flex gap-2">
                    <button class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-white hover:bg-white/10 transition">&larr;</button>
                    <button class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-white hover:bg-white/10 transition">&rarr;</button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @php
                    $rankedItems = [
                        ['type' => 'Song', 'title' => "God's Plan", 'desc' => "Deep dive into the record-breaking hit by Drake, exploring its cultural impact and lyrical meaning.", 'img' => 'images/gods_plan.png', 'views' => '24K', 'edits' => '2', 'tags' => 'Rap, Pop, High Energy'],
                        ['type' => 'Genre', 'title' => 'Hyperpop', 'desc' => 'Exploring the glitchy, high-octane world of hyperpop, from its pioneers to its viral TikTok dominance.', 'img' => 'images/card_electro.png', 'views' => '18K', 'edits' => '5', 'tags' => 'Electronic, Viral, Glitch'],
                        ['type' => 'Artist', 'title' => 'Billie Eilish', 'desc' => 'Tracking the evolution of a global icon, from "Ocean Eyes" to her experimental avant-pop masterpieces.', 'img' => 'images/card_midnight.png', 'views' => '42K', 'edits' => '8', 'tags' => 'Pop, Alternative, Dark'],
                    ];
                @endphp
                @foreach($rankedItems as $item)
                <div class="bg-[#0A0A14] rounded-[24px] border border-white/10 hover:border-white/20 transition-all duration-300 overflow-hidden flex flex-col">
                    <div class="relative aspect-video overflow-hidden">
                        <img src="{{ asset($item['img']) }}" class="w-full h-full object-cover opacity-70">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0A0A14] to-transparent opacity-60"></div>
                        <div class="absolute top-4 left-4">
                            <span class="bg-brand-600 text-white text-[9px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">{{ $item['type'] }}</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-white mb-3 uppercase tracking-tight">{{ $item['title'] }}</h3>
                        <p class="text-gray-500 text-xs leading-relaxed line-clamp-2 mb-6">{{ $item['desc'] }}</p>
                        <div class="flex items-center gap-4 text-[11px] font-mono text-gray-500 pt-6 border-t border-white/5">
                            <span class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> {{ $item['views'] }}</span>
                            <span class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> {{ $item['edits'] }}</span>
                            <span class="text-brand-500/60 ml-auto">{{ $item['tags'] }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <!-- Section 6: COMMUNITY INSIGHTS -->
        <section class="border-b border-white/10 py-24 relative overflow-hidden">
            <!-- Decorative Star -->
            <div class="absolute top-12 right-12 text-white/20 select-none">
                <svg class="w-8 h-8 -rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0l2.5 9.5 9.5 2.5-9.5 2.5-2.5 9.5-2.5-9.5-9.5-2.5 9.5-2.5z"/></svg>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-display font-black text-white mb-2 uppercase tracking-tight">COMMUNITY INSIGHTS</h2>
            <p class="text-gray-500 text-xs font-mono uppercase tracking-[0.2em] mb-12">Detailed statistics and analytics about our growing database.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-24">
                @php
                    $insightCards = [
                        ['label' => 'Most Edited Artist Today', 'value' => 'Drake', 'btn' => 'EXPLORE'],
                        ['label' => 'Most Added Genre', 'value' => 'Afrobeats', 'btn' => 'VIEW'],
                        ['label' => 'Fastest Growing Playlist', 'value' => 'Summer 26', 'btn' => 'VIEW'],
                    ];
                @endphp
                @foreach($insightCards as $insight)
                <div class="bg-[#0A0A14] border border-white/10 rounded-2xl p-8 flex flex-col hover:bg-white/[0.02] transition-all">
                    <div class="text-gray-500 text-[10px] mb-4 uppercase tracking-[0.2em] font-mono">{{ $insight['label'] }}</div>
                    <div class="flex justify-between items-end">
                        <div class="text-2xl font-black text-white uppercase tracking-tight">{{ $insight['value'] }}</div>
                        <a href="#" class="px-5 py-2 bg-brand-600 rounded-full text-[10px] font-bold text-white hover:bg-brand-500 transition-all uppercase tracking-widest">{{ $insight['btn'] }}</a>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <!-- Section 7: ADD TOPIC CTA -->
        <section class="border-b border-white/10 py-32 relative">
            <!-- Decorative Star -->
            <div class="absolute top-12 right-12 text-white/20 select-none">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0l2.5 9.5 9.5 2.5-9.5 2.5-2.5 9.5-2.5-9.5-9.5-2.5 9.5-2.5z"/></svg>
            </div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center text-center">
                <h2 class="text-3xl md:text-5xl font-black text-white mb-10 uppercase tracking-[-0.03em] leading-none font-display max-w-3xl">
                    CAN'T FIND THE TOPIC YOU'RE LOOKING FOR? ADD IT NOW!
                </h2>
                <a href="{{ route('wiki.create') }}" class="inline-flex items-center gap-3 px-8 py-3.5 bg-white text-black font-bold rounded-full hover:bg-gray-100 transition-all text-xs uppercase tracking-[0.1em] shadow-xl">
                    Add a New Topic 
                    <span class="bg-brand-600 rounded-full w-6 h-6 flex items-center justify-center text-white">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    </span>
                </a>
            </div>
        </section>
    </div>
    
    <!-- Footer -->
    <x-footer />
</body>
</html>
