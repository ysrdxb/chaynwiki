<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChaynWiki - The Ultra-Premium Music Encyclopedia</title>
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
        @keyframes fade-in-up { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes border-dance { 0%, 100% { border-color: rgba(59, 130, 246, 0.5); } 25% { border-color: rgba(139, 92, 246, 0.5); } 50% { border-color: rgba(236, 72, 153, 0.5); } 75% { border-color: rgba(34, 197, 94, 0.5); } }
        @keyframes slide-infinite { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-pulse-glow { animation: pulse-glow 3s ease-in-out infinite; }
        .animate-fade-in-up { animation: fade-in-up 0.8s ease-out forwards; opacity: 0; }
        .animate-border-dance { animation: border-dance 4s ease-in-out infinite; }
        .animate-slide-infinite { animation: slide-infinite 40s linear infinite; }

        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }
        .delay-400 { animation-delay: 400ms; }
        .delay-500 { animation-delay: 500ms; }

        /* Glassmorphism */
        .glass { background: rgba(255,255,255,0.03); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.08); }
        .glass-strong { background: rgba(10,10,20,0.7); backdrop-filter: blur(30px); -webkit-backdrop-filter: blur(30px); border: 1px solid rgba(255,255,255,0.1); }
        .glass-card { background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0) 100%); border: 1px solid rgba(255,255,255,0.1); border-radius: 1.5rem; }

        /* Premium Text */
        .text-gradient { background: linear-gradient(135deg, #fff 0%, #60a5fa 50%, #a78bfa 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .text-glow { text-shadow: 0 0 20px rgba(59, 130, 246, 0.5); }

        /* Card Effects */
        .card-premium { position: relative; background: linear-gradient(135deg, rgba(15,15,30,0.9) 0%, rgba(10,10,20,0.95) 100%); border: 1px solid rgba(255,255,255,0.08); border-radius: 1.5rem; overflow: hidden; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-premium::before { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(59,130,246,0.1) 0%, transparent 50%, rgba(139,92,246,0.1) 100%); opacity: 0; transition: opacity 0.4s; }
        .card-premium:hover { transform: translateY(-8px) rotateX(2deg); border-color: rgba(59,130,246,0.3); box-shadow: 0 25px 50px -12px rgba(59,130,246,0.25); }
        .card-premium:hover::before { opacity: 1; }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #030308; }
        ::-webkit-scrollbar-thumb { background: #1e1e2e; border-radius: 10px; }
    </style>
</head>
<body class="antialiased bg-[#030308] min-h-screen text-white overflow-x-hidden font-sans selection:bg-brand-500 selection:text-white">
    
    <!-- Vector Background Architecture -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-[#0a0a1a] via-[#030308] to-[#030308]"></div>
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-brand-600/10 rounded-full blur-[180px] animate-pulse-glow"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-purple-600/10 rounded-full blur-[180px] animate-pulse-glow delay-500"></div>
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.1) 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>

    <!-- Navigation Overlay -->
    <x-navigation />

    <div class="relative z-10">
        
        <!-- INTEL-DRIVEN HERO -->
        <section class="relative min-h-[95vh] flex flex-col items-center justify-center pt-32 pb-16 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <!-- Data Pulse Badge -->
                <div class="animate-fade-in-up mb-8">
                    <div class="inline-flex items-center gap-3 px-6 py-2 rounded-full glass border-brand-500/20">
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-500"></span>
                        </span>
                        <span class="text-[10px] font-black uppercase tracking-[0.3em] text-white/50">Industry Sync Active • v2.0 Platform</span>
                    </div>
                </div>
                
                <!-- Main Intelligence Title -->
                <h1 class="animate-fade-in-up delay-100 text-5xl md:text-8xl font-display font-black mb-8 tracking-tighter leading-tight">
                    <span class="block text-white">The Global</span>
                    <span class="block text-gradient">Music Intelligence</span>
                </h1>
                
                <p class="animate-fade-in-up delay-200 text-lg md:text-xl text-slate-400 max-w-3xl mx-auto mb-10 leading-relaxed">
                    Access real-time trends, community-mapped knowledge, and <span class="text-brand-400 font-bold border-b border-brand-500/30">AI-synthesized</span> research nodes across the modern music landscape.
                </p>
                
                <!-- Advanced Intelligence Search -->
                <div class="animate-fade-in-up delay-300 max-w-3xl mx-auto mb-16 px-4">
                    <form action="{{ route('search') }}" method="GET" class="relative group">
                        <div class="absolute -inset-1.5 bg-gradient-to-r from-brand-600 via-indigo-600 to-purple-600 rounded-[2rem] blur-xl opacity-20 group-hover:opacity-40 transition-opacity"></div>
                        <div class="relative flex items-center glass-strong rounded-2xl p-2 border border-white/5 shadow-2xl">
                            <div class="pl-6">
                                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <input type="text" name="q" placeholder="Decode artist, genre, or lyrical sentiment..." class="flex-1 bg-transparent !border-none !outline-none !shadow-none !ring-0 text-white placeholder-slate-600 px-4 py-4 md:py-6 text-lg md:text-xl font-medium">
                            <button type="submit" class="bg-gradient-to-br from-brand-600 to-brand-500 hover:from-brand-500 hover:to-brand-400 text-white rounded-xl px-10 py-4 md:py-5 font-black text-xs uppercase tracking-widest transition-all hover:scale-[1.02] active:scale-95 shadow-lg shadow-brand-600/20">
                                Initiate Search
                            </button>
                        </div>

                        <!-- Mini Hotfix Ticker Interface -->
                        <div class="mt-6 flex flex-wrap justify-center gap-3">
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mr-2 py-1">Trending Intelligence:</span>
                            @foreach($trendingTags as $tag)
                                <a href="/search?q={{ $tag['label'] }}" class="flex items-center gap-2 px-3 py-1 rounded-lg bg-white/5 border border-white/5 hover:border-brand-500/30 hover:bg-white/10 transition-all group">
                                    <div class="w-1 h-1 rounded-full bg-{{ $tag['style'] }}-500 group-hover:animate-pulse"></div>
                                    <span class="text-[10px] font-bold text-slate-400 group-hover:text-white transition-colors">#{{ $tag['label'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </form>
                </div>
                
                <!-- Impact Metrics Grid -->
                <div class="animate-fade-in-up delay-400 grid grid-cols-2 lg:grid-cols-4 gap-4 max-w-5xl mx-auto">
                    @php
                        $metrics = [
                            ['label' => 'Knowledge Nodes', 'value' => number_format($stats['songs'] + $stats['artists'] + $stats['genres']), 'diff' => '+12% wk', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                            ['label' => 'Commits Today', 'value' => $insights['new_wikis_today'], 'diff' => 'Active', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                            ['label' => 'Social Momentum', 'value' => '84.2k', 'diff' => 'Extreme', 'icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6'],
                            ['label' => 'AI Node Status', 'value' => 'Operational', 'diff' => '0ms Latency', 'icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                        ];
                    @endphp
                    @foreach($metrics as $metric)
                        <div class="glass p-5 text-left border-white/5 hover:bg-white/[0.05] transition-all group">
                            <div class="flex justify-between items-start mb-3">
                                <div class="p-2 rounded-lg bg-white/5 group-hover:bg-brand-500/10 transition-colors">
                                    <svg class="w-4 h-4 text-slate-400 group-hover:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $metric['icon'] }}"/></svg>
                                </div>
                                <span class="text-[9px] font-bold text-brand-500 uppercase tracking-widest bg-brand-500/10 px-2 py-0.5 rounded">{{ $metric['diff'] }}</span>
                            </div>
                            <div class="text-xl font-black text-white mb-1 tracking-tight">{{ $metric['value'] }}</div>
                            <div class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">{{ $metric['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- LIVE INDUSTRY WEATHER -->
        <section class="py-24 relative overflow-hidden bg-white/[0.01]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-12 gap-12 items-center">
                    <div class="lg:col-span-4 space-y-6">
                        <div class="inline-flex items-center gap-3 px-4 py-1.5 rounded-full bg-brand-500/10 border border-brand-500/20">
                            <span class="w-2 h-2 rounded-full bg-brand-400"></span>
                            <span class="text-[10px] font-black uppercase tracking-widest text-brand-400">Industry Vital Signs</span>
                        </div>
                        <h2 class="text-4xl md:text-5xl font-display font-black tracking-tighter">Music <br><span class="text-brand-400">Weather Report</span></h2>
                        <p class="text-slate-400 leading-relaxed">Cross-platform analytics driving the evolution of musical knowledge. We analyze data from YouTube, Spotify, and TikTok to provide instant knowledge nodes.</p>
                        
                        <div class="pt-6 space-y-4">
                            <div class="flex items-center gap-4 group">
                                <div class="w-12 h-12 rounded-xl bg-white/5 flex items-center justify-center text-xl group-hover:bg-brand-500/20 transition-all">🔥</div>
                                <div>
                                    <div class="text-xs font-bold text-slate-500 uppercase tracking-widest">Global Heatmap</div>
                                    <div class="text-white font-bold">{{ $musicWeather['rising_genres']['top'][0] }} is trending in 42 regions</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 group">
                                <div class="w-12 h-12 rounded-xl bg-white/5 flex items-center justify-center text-xl group-hover:bg-purple-500/20 transition-all">🚀</div>
                                <div>
                                    <div class="text-xs font-bold text-slate-500 uppercase tracking-widest">Viral Velocity</div>
                                    <div class="text-white font-bold">+{{ number_format($musicWeather['trending_songs']['count']) }}% engagement spike on {{ $musicWeather['trending_songs']['platform'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-8 grid md:grid-cols-2 gap-6">
                        <!-- Rising Genres Module -->
                        <div class="card-premium p-8 relative overflow-hidden group">
                           <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-brand-500/10 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                           <div class="relative z-10 flex flex-col h-full justify-between">
                               <div>
                                    <div class="flex justify-between items-center mb-8">
                                        <div class="text-[10px] font-black uppercase tracking-widest text-slate-500">Node Momentum</div>
                                        <div class="text-brand-400 font-bold text-xs">+{{ $musicWeather['rising_genres']['count'] }} New Genres</div>
                                    </div>
                                    <h3 class="text-2xl font-display font-black mb-4">Top Rising <br>Knowledge Zones</h3>
                                    <div class="space-y-3">
                                        @foreach($musicWeather['rising_genres']['top'] as $genre)
                                            <div class="flex items-center justify-between p-3 rounded-xl bg-white/5 border border-white/5 hover:border-brand-500/30 transition-all">
                                                <span class="text-sm font-bold text-slate-300"># {{ $genre }}</span>
                                                <svg class="w-3 h-3 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                            </div>
                                        @endforeach
                                    </div>
                               </div>
                               <div class="mt-8 text-[10px] font-bold text-slate-500 uppercase tracking-widest hover:text-white transition-colors cursor-pointer flex items-center">
                                   Explore full map 
                                   <svg class="w-3 h-3 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                               </div>
                           </div>
                        </div>

                        <!-- Viral Artist Intelligence -->
                        <div class="card-premium p-8 relative group overflow-hidden">
                           <div class="absolute -right-10 -top-10 w-40 h-40 bg-purple-500/10 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                           <div class="relative z-10 flex flex-col h-full justify-between">
                               <div>
                                    <div class="flex justify-between items-center mb-8">
                                        <div class="text-[10px] font-black uppercase tracking-widest text-slate-500">Anomaly Detected</div>
                                        <div class="px-2 py-0.5 rounded-md bg-purple-500/20 text-purple-400 font-bold text-[9px] uppercase tracking-widest">Viral Breakout</div>
                                    </div>
                                    <h3 class="text-2xl font-display font-black mb-2">Social Hub <br>Impact Leader</h3>
                                    <div class="text-5xl font-display font-black text-gradient mt-6 mb-4">{{ $musicWeather['viral_artists']['name'] }}</div>
                                    <div class="text-slate-500 text-xs font-bold uppercase tracking-widest">Region: {{ $musicWeather['viral_artists']['region'] }}</div>
                               </div>
                               <a href="/search?q={{ $musicWeather['viral_artists']['name'] }}" class="mt-8 px-6 py-3 rounded-xl bg-white/5 border border-white/5 text-[10px] font-black uppercase tracking-[0.2em] text-center hover:bg-brand-500/20 hover:border-brand-500/30 transition-all">Sync Biography Data</a>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- KNOWLEDGE SYNC FEED -->
        <section class="py-24 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-end gap-6 mb-12">
                    <div class="max-w-xl">
                        <div class="text-brand-500 text-[10px] font-black uppercase tracking-widest mb-4">Knowledge Repository</div>
                        <h2 class="text-4xl font-display font-black text-white">Freshly Indexed <br>Intelligence</h2>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex items-center px-4 py-2 rounded-xl bg-white/5 border border-white/5">
                            <span class="w-1.5 h-1.5 rounded-full bg-brand-500 mr-2 animate-pulse"></span>
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Node count: {{ number_format($stats['songs'] + $stats['artists']) }}</span>
                        </div>
                        <a href="{{ route('wiki.index') }}" class="px-6 py-2 rounded-xl bg-brand-600 hover:bg-brand-500 text-white text-[10px] font-black uppercase tracking-widest transition-all">Access Archive</a>
                    </div>
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    @foreach($newTopics as $index => $article)
                        <a href="{{ route('wiki.show', $article) }}" class="card-premium group p-1 ring-1 ring-white/5 hover:ring-brand-500/30 transition-all">
                            <div class="p-6">
                                <div class="flex items-center gap-3 mb-6">
                                    <span class="px-2 py-0.5 rounded-md text-[8px] font-black uppercase tracking-[0.2em] {{ $article->category === 'song' ? 'bg-teal-500/10 text-teal-400' : 'bg-brand-500/10 text-brand-400' }}">
                                        {{ $article->category }}
                                    </span>
                                    <span class="text-[9px] font-bold text-slate-600 uppercase tracking-widest">{{ $article->created_at->diffForHumans() }}</span>
                                </div>
                                <h3 class="text-xl font-display font-bold text-white group-hover:text-brand-400 transition-colors mb-4">{{ $article->title }}</h3>
                                <p class="text-slate-500 text-xs mb-8 line-clamp-2 leading-relaxed italic">"{{ Str::limit(strip_tags($article->content), 80) }}"</p>
                                
                                <div class="flex items-center justify-between pt-6 border-t border-white/5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-lg bg-white/5 flex items-center justify-center text-[10px] font-black text-brand-500">{{ substr($article->user->name, 0, 1) }}</div>
                                        <span class="text-[10px] font-bold text-slate-400">{{ $article->user->name }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 text-slate-600">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span class="text-[9px] font-bold tracking-widest">{{ $article->view_count }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- COMMUNITY ACTIVITY SYNC -->
        <section class="py-24 relative bg-brand-600/[0.02]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-12 gap-12">
                    <!-- Recent Intelligence Updates -->
                    <div class="lg:col-span-8">
                        <div class="flex items-end justify-between mb-10">
                            <div>
                                <div class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Sub-orbital Feed</div>
                                <h3 class="text-2xl font-display font-black text-white">Live Activity Sync</h3>
                            </div>
                            <div class="text-emerald-500 text-[10px] font-bold uppercase tracking-widest flex items-center">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-2 pulse"></span>
                                {{ $insights['total_edits'] }} Active Operations
                            </div>
                        </div>

                        <div class="space-y-4">
                            @foreach($recentUpdates as $update)
                                <div class="glass p-5 flex items-center gap-6 border-white/5 hover:bg-white/[0.05] transition-all group">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-2xl bg-white/5 flex flex-col items-center justify-center border border-white/10 group-hover:border-brand-500/30 transition-all">
                                        <div class="text-[10px] font-black uppercase text-slate-600">{{ $update->created_at->format('M') }}</div>
                                        <div class="text-sm font-black text-white group-hover:text-brand-400">{{ $update->created_at->format('d') }}</div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-xs font-black text-brand-400 uppercase tracking-widest mb-1 group-hover:text-white transition-colors">Mod: {{ $update->article->title }}</div>
                                        <div class="text-sm text-slate-300 truncate font-medium">"{{ $update->change_summary }}"</div>
                                        <div class="flex items-center gap-3 mt-2">
                                            <span class="text-[9px] font-bold text-slate-500 uppercase flex items-center">
                                                <svg class="w-2.5 h-2.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                                {{ $update->user->name }}
                                            </span>
                                            <span class="text-[9px] font-bold text-slate-700 uppercase tracking-tighter">{{ $update->user->rank_name }}</span>
                                        </div>
                                    </div>
                                    <div class="px-3 py-1 rounded-md bg-white/5 text-[8px] font-black uppercase tracking-widest text-slate-500">Node Sync</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Top Researchers -->
                    <div class="lg:col-span-4">
                         <div class="mb-10">
                            <div class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Impact Rankings</div>
                            <h3 class="text-2xl font-display font-black text-white">Elite Researchers</h3>
                        </div>
                        
                        <div class="glass-card p-6 border-white/5">
                            <div class="space-y-6">
                                @foreach($topContributors as $index => $user)
                                    <div class="flex items-center justify-between group">
                                        <div class="flex items-center gap-4">
                                            <div class="relative">
                                                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-600 to-indigo-600 flex items-center justify-center font-black text-sm border-2 border-white/5 group-hover:scale-110 transition-transform">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                                @if($index < 3)
                                                    <div class="absolute -top-2 -right-2 w-5 h-5 rounded-full {{ ['bg-yellow-500','bg-slate-400','bg-orange-600'][$index] }} flex items-center justify-center text-[8px] font-black text-white border-2 border-[#030308]">
                                                        {{ $index + 1 }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="text-sm font-black text-white">{{ $user->name }}</div>
                                                <div class="text-[9px] font-bold text-brand-400 uppercase tracking-widest">{{ $user->rank_name }}</div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-xs font-black text-white tracking-tight">{{ number_format($user->reputation_score) }}</div>
                                            <div class="text-[8px] font-black text-slate-600 uppercase tracking-widest">Impact</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <a href="{{ route('leaderboard') }}" class="block mt-8 text-center text-[9px] font-black uppercase tracking-[0.3em] text-slate-500 hover:text-white transition-all border-t border-white/5 pt-6">Access Full Leaderboard </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA INTELLIGENCE -->
        <section class="py-24 relative">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="card-premium p-16 text-center shadow-2xl shadow-brand-600/10">
                    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 200 200%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cpath fill=%22%234F46E5%22 d=%22M44.7,-76.4C58.1,-69.2,69.2,-58.1,77.3,-44.7C85.4,-31.3,90.5,-15.7,89.5,-0.6C88.5,14.5,81.4,29,72.4,41.4C63.4,53.8,52.5,64.1,39.6,71.5C26.7,78.9,13.3,83.4,-0.8,84.7C-14.8,86,-29.6,84.1,-43.1,77.3C-56.6,70.5,-68.8,58.8,-76.3,44.9C-83.8,31,-86.6,14.8,-86.3,0.2C-86,-14.3,-82.6,-28.6,-74.6,-41.8C-66.6,-55,-54,-67.1,-39.8,-74.1C-25.6,-81.1,-9.8,-83,1.6,-85.7C13,-88.4,26,-83.6,44.7,-76.4Z%22 transform=%22translate(100 100)%22 /%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: center; background-size: contain;"></div>
                    <div class="relative z-10">
                        <div class="text-brand-400 text-xs font-black uppercase tracking-widest mb-6 px-4 py-1.5 rounded-full bg-brand-500/10 inline-block border border-brand-500/20">Collaborative Initiative</div>
                        <h2 class="text-4xl md:text-6xl font-display font-black text-white mb-8 tracking-tighter">Expand the Neural <br>Record Network</h2>
                        <p class="text-slate-400 text-lg mb-12 max-w-2xl mx-auto font-medium">Contribute to the largest decentralized music encyclopedia. Your insights power the next generation of musical research. Initiate a new knowledge node today.</p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('wiki.create') }}" class="px-10 py-5 bg-white text-dark rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all hover:scale-105 active:scale-95 shadow-xl shadow-white/10">Initiate Node Creation</a>
                            <a href="{{ route('wiki.generate') }}" class="px-10 py-5 glass border-white/10 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all hover:bg-white/10 hover:border-white/20">Analyze via AI Assistant</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FOOTER -->
        <x-footer />
    </div>

    {{-- Core System Overlay Widgets --}}
    @auth
        <livewire:chat-assistant />
    @endauth
    <x-toast-container />

    <script>
        // Smooth reveal on scroll logic can be added here
        document.addEventListener('DOMContentLoaded', () => {
            const observerOptions = {
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fade-in-up');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('section, [class*="card-premium"], .glass').forEach(el => {
                // Pre-set opacity 0 for reveal
                el.style.opacity = '0';
                observer.observe(el);
            });
        });
    </script>
</body>
</html>
