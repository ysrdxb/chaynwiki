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
                }
            }
        }
    </script>
    <style>
        /* Premium Animations */
        @keyframes float { 0%, 100% { transform: translateY(0) rotate(0deg); } 50% { transform: translateY(-20px) rotate(2deg); } }
        @keyframes pulse-glow { 0%, 100% { opacity: 0.4; transform: scale(1); } 50% { opacity: 0.8; transform: scale(1.05); } }
        @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
        @keyframes gradient-shift { 0%, 100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }
        @keyframes rotate-slow { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        @keyframes fade-in-up { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes scale-in { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
        @keyframes border-dance { 0%, 100% { border-color: rgba(59, 130, 246, 0.5); } 25% { border-color: rgba(139, 92, 246, 0.5); } 50% { border-color: rgba(236, 72, 153, 0.5); } 75% { border-color: rgba(34, 197, 94, 0.5); } }

        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-pulse-glow { animation: pulse-glow 3s ease-in-out infinite; }
        .animate-shimmer { background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent); background-size: 200% 100%; animation: shimmer 2s infinite; }
        .animate-gradient { background-size: 200% 200%; animation: gradient-shift 8s ease infinite; }
        .animate-rotate-slow { animation: rotate-slow 20s linear infinite; }
        .animate-fade-in-up { animation: fade-in-up 0.8s ease-out forwards; }
        .animate-scale-in { animation: scale-in 0.6s ease-out forwards; }
        .animate-border-dance { animation: border-dance 4s ease-in-out infinite; }

        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }
        .delay-400 { animation-delay: 400ms; }
        .delay-500 { animation-delay: 500ms; }

        /* Glassmorphism */
        .glass { background: rgba(255,255,255,0.03); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.08); }
        .glass-strong { background: rgba(10,10,20,0.7); backdrop-filter: blur(30px); -webkit-backdrop-filter: blur(30px); border: 1px solid rgba(255,255,255,0.1); }

        /* Gradient Text */
        .text-gradient { background: linear-gradient(135deg, #fff 0%, #60a5fa 50%, #a78bfa 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .text-gradient-gold { background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #d97706 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

        /* Premium Card */
        .card-premium { position: relative; background: linear-gradient(135deg, rgba(15,15,30,0.9) 0%, rgba(10,10,20,0.95) 100%); border: 1px solid rgba(255,255,255,0.08); border-radius: 1.5rem; overflow: hidden; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-premium::before { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(59,130,246,0.1) 0%, transparent 50%, rgba(139,92,246,0.1) 100%); opacity: 0; transition: opacity 0.4s; }
        .card-premium:hover { transform: translateY(-8px) scale(1.02); border-color: rgba(59,130,246,0.3); box-shadow: 0 25px 50px -12px rgba(59,130,246,0.25), 0 0 0 1px rgba(59,130,246,0.1); }
        .card-premium:hover::before { opacity: 1; }

        /* Glow Effects */
        .glow-blue { box-shadow: 0 0 60px rgba(59,130,246,0.3), 0 0 120px rgba(59,130,246,0.1); }
        .glow-purple { box-shadow: 0 0 60px rgba(139,92,246,0.3), 0 0 120px rgba(139,92,246,0.1); }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0a0a14; }
        ::-webkit-scrollbar-thumb { background: linear-gradient(180deg, #3b82f6, #8b5cf6); border-radius: 4px; }
    </style>
</head>
<body class="antialiased bg-[#030308] min-h-screen text-white overflow-x-hidden font-sans selection:bg-brand-500 selection:text-white">
    
    <!-- Animated Background -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <!-- Base gradient -->
        <div class="absolute inset-0 bg-gradient-to-b from-[#0a0a1a] via-[#030308] to-[#030308]"></div>
        
        <!-- Animated orbs -->
        <div class="absolute top-0 left-1/4 w-[800px] h-[800px] bg-brand-600/20 rounded-full blur-[150px] animate-pulse-glow"></div>
        <div class="absolute top-1/3 right-0 w-[600px] h-[600px] bg-purple-600/20 rounded-full blur-[150px] animate-pulse-glow delay-300"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-pink-600/10 rounded-full blur-[150px] animate-pulse-glow delay-500"></div>
        
        <!-- Grid pattern -->
        <div class="absolute inset-0 opacity-[0.02]" style="background-image: linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 50px 50px;"></div>
        
        <!-- Noise texture -->
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 256 256%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22noise%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.9%22 numOctaves=%224%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23noise)%22/%3E%3C/svg%3E');"></div>
    </div>

    <!-- Navigation -->
    <x-navigation />

    <div class="relative z-10">
        
        <!-- HERO SECTION -->
        <section class="relative min-h-screen flex items-center justify-center py-32 overflow-hidden">
            <!-- Floating decorative elements -->
            <div class="absolute top-20 right-20 w-20 h-20 border border-white/10 rounded-2xl rotate-12 animate-float opacity-20"></div>
            <div class="absolute bottom-40 left-20 w-16 h-16 border border-brand-500/30 rounded-full animate-float delay-200 opacity-30"></div>
            <div class="absolute top-1/3 right-1/4 w-2 h-2 bg-brand-400 rounded-full animate-pulse"></div>
            <div class="absolute bottom-1/3 left-1/3 w-3 h-3 bg-purple-400 rounded-full animate-pulse delay-300"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <!-- Badge -->
                <div class="animate-fade-in-up opacity-0 mb-8">
                    <div class="inline-flex items-center gap-3 px-5 py-2.5 rounded-full glass animate-border-dance">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        <span class="text-xs font-semibold text-white/70 uppercase tracking-[0.2em]">AI-Powered • Community Driven</span>
                    </div>
                </div>
                
                <!-- Main Title -->
                <h1 class="animate-fade-in-up opacity-0 delay-100 text-5xl md:text-7xl lg:text-8xl font-display font-black mb-8 tracking-tight">
                    <span class="block text-white/90">The Ultimate</span>
                    <span class="block text-gradient">Music Encyclopedia</span>
                </h1>
                
                <!-- Subtitle -->
                <p class="animate-fade-in-up opacity-0 delay-200 text-xl md:text-2xl text-gray-400 max-w-3xl mx-auto mb-12 leading-relaxed">
                    Discover, create, and explore music knowledge with <span class="text-brand-400 font-semibold">AI-powered insights</span> and a passionate community.
                </p>
                
                <!-- Search Bar -->
                <div class="animate-fade-in-up opacity-0 delay-300 max-w-2xl mx-auto mb-12">
                    <form action="{{ route('search') }}" method="GET" class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-brand-600 via-purple-600 to-pink-600 rounded-2xl blur-lg opacity-30 group-hover:opacity-50 transition-opacity"></div>
                        <div class="relative flex items-center glass-strong rounded-2xl p-2">
                            <div class="pl-5 pr-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                name="q"
                                placeholder="Search artists, songs, genres, lyrics..." 
                                class="flex-1 bg-transparent !border-none !outline-none !shadow-none !ring-0 text-white placeholder-gray-500 px-3 py-4 text-lg"
                            >
                            <button type="submit" class="bg-gradient-to-r from-brand-600 to-brand-500 hover:from-brand-500 hover:to-brand-400 text-white rounded-xl px-8 py-4 font-bold text-sm transition-all hover:shadow-lg hover:shadow-brand-500/25">
                                Search
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Quick Actions -->
                <div class="animate-fade-in-up opacity-0 delay-400 flex flex-wrap justify-center gap-4 mb-16">
                    <a href="{{ route('wiki.generate') }}" class="group flex items-center gap-3 px-6 py-3 rounded-xl glass hover:bg-brand-600/20 transition-all border border-transparent hover:border-brand-500/30">
                        <span class="text-2xl">🤖</span>
                        <span class="text-sm font-semibold text-white/80 group-hover:text-white">AI Generate</span>
                    </a>
                    <a href="{{ route('explore') }}" class="group flex items-center gap-3 px-6 py-3 rounded-xl glass hover:bg-purple-600/20 transition-all border border-transparent hover:border-purple-500/30">
                        <span class="text-2xl">🌐</span>
                        <span class="text-sm font-semibold text-white/80 group-hover:text-white">Explore Map</span>
                    </a>
                    <a href="{{ route('leaderboard') }}" class="group flex items-center gap-3 px-6 py-3 rounded-xl glass hover:bg-yellow-600/20 transition-all border border-transparent hover:border-yellow-500/30">
                        <span class="text-2xl">🏆</span>
                        <span class="text-sm font-semibold text-white/80 group-hover:text-white">Leaderboard</span>
                    </a>
                    <a href="{{ route('tools.lyrics') }}" class="group flex items-center gap-3 px-6 py-3 rounded-xl glass hover:bg-pink-600/20 transition-all border border-transparent hover:border-pink-500/30">
                        <span class="text-2xl">🎤</span>
                        <span class="text-sm font-semibold text-white/80 group-hover:text-white">Lyric Analyzer</span>
                    </a>
                </div>
                
                <!-- Stats -->
                <div class="animate-fade-in-up opacity-0 delay-500 grid grid-cols-2 md:grid-cols-4 gap-6 max-w-3xl mx-auto">
                    @php
                        $stats = [
                            ['value' => '10K+', 'label' => 'Articles', 'icon' => '📚'],
                            ['value' => '500+', 'label' => 'Contributors', 'icon' => '👥'],
                            ['value' => '50+', 'label' => 'Genres', 'icon' => '🎸'],
                            ['value' => '24/7', 'label' => 'AI Assistant', 'icon' => '🤖'],
                        ];
                    @endphp
                    @foreach($stats as $stat)
                        <div class="glass rounded-2xl p-6 text-center hover:bg-white/5 transition-all">
                            <div class="text-3xl mb-2">{{ $stat['icon'] }}</div>
                            <div class="text-2xl md:text-3xl font-display font-black text-white mb-1">{{ $stat['value'] }}</div>
                            <div class="text-xs text-gray-500 uppercase tracking-wider">{{ $stat['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Scroll indicator -->
            <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce">
                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </div>
        </section>

        <!-- FEATURED ARTICLES -->
        <section class="py-24 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="flex items-center justify-between mb-12">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/10 text-brand-400 text-xs font-mono uppercase tracking-widest mb-4">
                            <span class="w-1.5 h-1.5 bg-brand-400 rounded-full animate-pulse"></span>
                            Trending Now
                        </div>
                        <h2 class="text-3xl md:text-4xl font-display font-black text-white">Featured Articles</h2>
                    </div>
                    <a href="{{ route('wiki.index') }}" class="hidden md:flex items-center gap-2 text-gray-400 hover:text-white transition-colors group">
                        <span>View All</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
                
                <!-- Article Grid -->
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @php
                        $featuredArticles = \App\Models\Article::where('status', 'published')
                            ->orderByDesc('view_count')
                            ->limit(6)
                            ->get();

                    @endphp
                    
                    @forelse($featuredArticles as $index => $article)
                        <a href="{{ route('wiki.show', $article) }}" class="card-premium p-6 group {{ $index === 0 ? 'md:col-span-2 md:row-span-2' : '' }}">
                            <div class="relative z-10">
                                <!-- Category Badge -->
                                <div class="flex items-center gap-2 mb-4">
                                    <span class="px-3 py-1 rounded-full bg-white/10 text-xs font-semibold text-white/70 capitalize">
                                        {{ $article->category }}
                                    </span>
                                    @if($index === 0)
                                        <span class="px-3 py-1 rounded-full bg-brand-500/20 text-brand-400 text-xs font-semibold">
                                            Featured
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Title -->
                                <h3 class="text-{{ $index === 0 ? '2xl md:text-3xl' : 'lg' }} font-display font-bold text-white mb-3 group-hover:text-brand-400 transition-colors">
                                    {{ $article->title }}
                                </h3>
                                
                                <!-- Excerpt -->
                                <p class="text-gray-400 text-sm mb-4 line-clamp-{{ $index === 0 ? '3' : '2' }}">
                                    {{ Str::limit(strip_tags($article->content), $index === 0 ? 200 : 100) }}
                                </p>
                                
                                <!-- Meta -->
                                <div class="flex items-center justify-between text-xs text-gray-500">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-brand-500/20 flex items-center justify-center text-brand-400 text-xs font-bold">
                                            {{ strtoupper(substr($article->user->name ?? 'A', 0, 1)) }}
                                        </div>
                                        <span>{{ $article->user->name ?? 'Anonymous' }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <span>{{ number_format($article->view_count ?? 0) }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        @for($i = 0; $i < 6; $i++)
                            <div class="card-premium p-6 {{ $i === 0 ? 'md:col-span-2 md:row-span-2' : '' }}">
                                <div class="animate-pulse">
                                    <div class="h-6 w-20 bg-white/10 rounded mb-4"></div>
                                    <div class="h-8 w-3/4 bg-white/10 rounded mb-3"></div>
                                    <div class="h-4 w-full bg-white/5 rounded mb-2"></div>
                                    <div class="h-4 w-2/3 bg-white/5 rounded"></div>
                                </div>
                            </div>
                        @endfor
                    @endforelse
                </div>
            </div>
        </section>

        <!-- FEATURES SECTION -->
        <section class="py-24 relative overflow-hidden">
            <!-- Background glow -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-gradient-to-r from-brand-600/10 to-purple-600/10 rounded-full blur-[150px]"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-16">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-purple-500/10 text-purple-400 text-xs font-mono uppercase tracking-widest mb-4">
                        ✨ Powered by AI
                    </div>
                    <h2 class="text-3xl md:text-5xl font-display font-black text-white mb-6">Next-Gen Features</h2>
                    <p class="text-gray-400 text-lg max-w-2xl mx-auto">Experience music knowledge like never before with our cutting-edge AI tools.</p>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @php
                        $features = [
                            ['icon' => '🤖', 'title' => 'AI Article Generator', 'desc' => 'Generate comprehensive wiki articles with Ollama AI', 'color' => 'brand', 'link' => route('wiki.generate')],
                            ['icon' => '💬', 'title' => 'AI Chat Assistant', 'desc' => 'Get instant answers about any music topic', 'color' => 'green', 'link' => '#'],
                            ['icon' => '🎤', 'title' => 'Lyric Analyzer', 'desc' => 'AI-powered rhyme schemes and theme detection', 'color' => 'pink', 'link' => route('tools.lyrics')],
                            ['icon' => '🌐', 'title' => 'Knowledge Explorer', 'desc' => 'Interactive genre maps and artist networks', 'color' => 'purple', 'link' => route('explore')],
                        ];
                    @endphp
                    
                    @foreach($features as $feature)
                        <a href="{{ $feature['link'] }}" class="card-premium p-8 text-center group">
                            <div class="relative z-10">
                                <div class="w-16 h-16 rounded-2xl bg-{{ $feature['color'] }}-500/20 flex items-center justify-center text-3xl mx-auto mb-6 group-hover:scale-110 transition-transform">
                                    {{ $feature['icon'] }}
                                </div>
                                <h3 class="text-lg font-display font-bold text-white mb-3">{{ $feature['title'] }}</h3>
                                <p class="text-gray-400 text-sm">{{ $feature['desc'] }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- CTA SECTION -->
        <section class="py-24 relative">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="relative">
                    <!-- Glow effect -->
                    <div class="absolute -inset-4 bg-gradient-to-r from-brand-600 via-purple-600 to-pink-600 rounded-3xl blur-2xl opacity-20"></div>
                    
                    <div class="relative glass-strong rounded-3xl p-12 md:p-16 text-center overflow-hidden">
                        <!-- Decorative elements -->
                        <div class="absolute top-0 right-0 w-64 h-64 bg-brand-500/10 rounded-full blur-3xl"></div>
                        <div class="absolute bottom-0 left-0 w-48 h-48 bg-purple-500/10 rounded-full blur-3xl"></div>
                        
                        <div class="relative z-10">
                            <h2 class="text-3xl md:text-5xl font-display font-black text-white mb-6">
                                Ready to Contribute?
                            </h2>
                            <p class="text-gray-400 text-lg mb-10 max-w-2xl mx-auto">
                                Join thousands of music enthusiasts building the ultimate music encyclopedia. Share your knowledge and earn achievements!
                            </p>
                            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                <a href="{{ route('wiki.create') }}" class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-gradient-to-r from-brand-600 to-brand-500 hover:from-brand-500 hover:to-brand-400 text-white font-bold rounded-xl transition-all hover:shadow-xl hover:shadow-brand-500/25 hover:-translate-y-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Create Article
                                </a>
                                <a href="{{ route('wiki.index') }}" class="inline-flex items-center justify-center gap-3 px-8 py-4 glass hover:bg-white/10 text-white font-bold rounded-xl transition-all hover:-translate-y-1">
                                    Browse Articles
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FOOTER -->
        <x-footer />
    </div>

    {{-- AI Chat Assistant Widget --}}
    @auth
        <livewire:chat-assistant />
    @endauth

    {{-- Toast Container --}}
    <x-toast-container />
</body>
</html>
