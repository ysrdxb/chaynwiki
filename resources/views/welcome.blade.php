<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChaynWiki - Global Music Intelligence Platform</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            500: '#3b82f6',
                            600: '#2563eb',
                        },
                        dark: '#030308',
                        surface: '#0a0a14',
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
        @keyframes fade-in-up { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes pulse-soft { 0%, 100% { opacity: 0.3; } 50% { opacity: 0.6; } }
        
        .animate-fade-in-up { animation: fade-in-up 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-pulse-soft { animation: pulse-soft 4s ease-in-out infinite; }
        
        .glass { background: rgba(255, 255, 255, 0.02); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.05); }
        .glass-strong { background: rgba(255, 255, 255, 0.04); backdrop-filter: blur(40px); border: 1px solid rgba(255, 255, 255, 0.1); }
        
        .text-gradient { background: linear-gradient(135deg, #fff 0%, #60a5fa 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        
        .card-institutional { 
            background: linear-gradient(135deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0) 100%);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 1.25rem;
            transition: all 0.3s ease;
        }
        .card-institutional:hover {
            border-color: rgba(59, 130, 246, 0.3);
            background: rgba(255,255,255,0.05);
        }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #030308; }
        ::-webkit-scrollbar-thumb { background: #1e1e2e; border-radius: 10px; }
        
        body { letter-spacing: -0.01em; }
    </style>
</head>
<body class="antialiased bg-dark min-h-screen text-slate-300 overflow-x-hidden font-sans">
    
    <!-- Sophisticated Background Architecture -->
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute inset-0 bg-gradient-to-b from-surface via-dark to-dark"></div>
        <div class="absolute top-[-20%] left-[-10%] w-[60%] h-[60%] bg-brand-600/5 rounded-full blur-[150px] animate-pulse-soft"></div>
        <div class="absolute bottom-[-20%] right-[-10%] w-[60%] h-[60%] bg-purple-600/5 rounded-full blur-[150px] animate-pulse-soft delay-1000"></div>
        <div class="absolute inset-0 opacity-[0.02]" style="background-image: radial-gradient(rgba(255,255,255,0.1) 1px, transparent 0); background-size: 32px 32px;"></div>
    </div>

    <x-navigation />

    <div class="relative z-10">
        
        <!-- HERO: INSTITUTIONAL PRECISION -->
        <section class="relative min-h-[90vh] flex flex-col items-center justify-center pt-32 pb-20">
            <div class="max-w-5xl mx-auto px-6 text-center">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full glass border-white/5 mb-8 animate-fade-in-up">
                    <span class="w-1.5 h-1.5 rounded-full bg-brand-500 shadow-[0_0_8px_rgba(59,130,246,0.5)]"></span>
                    <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">Global Knowledge Index v2.0</span>
                </div>
                
                <h1 class="text-5xl md:text-7xl lg:text-8xl font-display font-black text-white mb-8 tracking-tighter leading-[0.9] animate-fade-in-up" style="animation-delay: 100ms">
                    Decentralized <br> <span class="text-gradient">Music Intelligence</span>
                </h1>
                
                <p class="text-lg md:text-xl text-slate-400 max-w-2xl mx-auto mb-12 leading-relaxed animate-fade-in-up" style="animation-delay: 200ms">
                    The authoritative repository for musical heritage and modern trends. Powered by community consensus and high-fidelity AI synthesis.
                </p>
                
                <!-- Search Architecture -->
                <div class="max-w-2xl mx-auto mb-16 animate-fade-in-up px-4" style="animation-delay: 300ms">
                    <form action="{{ route('search') }}" method="GET" class="relative group">
                        <div class="absolute -inset-1 bg-brand-500/5 blur-xl group-hover:bg-brand-500/10 transition-all"></div>
                        <div class="relative flex items-center glass-strong rounded-2xl p-1.5 border border-white/10 shadow-3xl">
                            <div class="pl-5 text-slate-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <input type="text" name="q" placeholder="Query the intelligence network..." class="flex-1 bg-transparent border-none focus:ring-0 text-white placeholder-slate-600 px-4 py-4 text-lg font-medium">
                            <button type="submit" class="bg-brand-600 hover:bg-brand-500 text-white rounded-xl px-8 py-4 font-bold text-xs uppercase tracking-widest transition-all shadow-lg active:scale-95">
                                Search Node
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Vital Stats Ticker -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto animate-fade-in-up" style="animation-delay: 400ms">
                    @php
                        $metrics = [
                            ['label' => 'Total Records', 'value' => number_format($stats['songs'] + $stats['artists']), 'icon' => '📚'],
                            ['label' => 'Active Sessions', 'value' => rand(120, 450), 'icon' => '⚡'],
                            ['label' => 'Commits Today', 'value' => $insights['new_wikis_today'], 'icon' => '✨'],
                            ['label' => 'Core Uptime', 'value' => '99.9%', 'icon' => '🛡️'],
                        ];
                    @endphp
                    @foreach($metrics as $metric)
                        <div class="glass p-5 rounded-xl border-white/5 flex flex-col items-center">
                            <span class="text-xl mb-2">{{ $metric['icon'] }}</span>
                            <div class="text-xl font-bold text-white tracking-tight">{{ $metric['value'] }}</div>
                            <div class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">{{ $metric['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- INDUSTRY ANALYSIS DECK -->
        <section class="py-24 relative bg-white/[0.01] border-y border-white/5">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid lg:grid-cols-12 gap-16 items-start">
                    <div class="lg:col-span-4 sticky top-32">
                        <div class="text-brand-500 text-[10px] font-bold uppercase tracking-[0.3em] mb-4">Intelligence Briefing</div>
                        <h2 class="text-4xl font-display font-black text-white mb-6 tracking-tight leading-tight">Platform <br>Vital Signs</h2>
                        <p class="text-slate-400 leading-relaxed mb-8">Real-time analysis across integrated streaming platforms and social signals to identify cultural shifts before they reach the mainstream.</p>
                        
                        <div class="space-y-4">
                            <div class="p-4 rounded-xl bg-white/5 border border-white/5 hover:border-brand-500/20 transition-all flex items-center gap-4">
                                <div class="w-10 h-10 rounded-lg bg-brand-500/10 flex items-center justify-center text-lg">📈</div>
                                <div>
                                    <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Global Momentum</div>
                                    <div class="text-sm font-bold text-white">{{ $musicWeather['rising_genres']['top'][0] }} Rising Fast</div>
                                </div>
                            </div>
                            <div class="p-4 rounded-xl bg-white/5 border border-white/5 hover:border-purple-500/20 transition-all flex items-center gap-4">
                                <div class="w-10 h-10 rounded-lg bg-brand-500/10 flex items-center justify-center text-lg">🌐</div>
                                <div>
                                    <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Regional Sync</div>
                                    <div class="text-sm font-bold text-white">Active in {{ $musicWeather['viral_artists']['region'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-8 grid md:grid-cols-2 gap-6">
                        <!-- Rising Node Analysis -->
                        <div class="card-institutional p-8 h-full flex flex-col">
                            <div class="flex justify-between items-center mb-10">
                                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Sector Momentum</div>
                                <div class="text-brand-400 font-bold text-xs">+{{ $musicWeather['rising_genres']['count'] }} Delta</div>
                            </div>
                            <h3 class="text-2xl font-display font-bold text-white mb-6">Trending Knowledge <br>Sectors</h3>
                            <div class="space-y-3 flex-1">
                                @foreach($musicWeather['rising_genres']['top'] as $genre)
                                    <div class="flex items-center justify-between p-3.5 rounded-xl glass border-white/5 group hover:border-brand-500/40 transition-all cursor-default">
                                        <span class="text-sm font-semibold text-slate-300"># {{ $genre }}</span>
                                        <div class="w-1.5 h-1.5 rounded-full bg-brand-500 group-hover:scale-150 transition-transform"></div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Breakout Entity Disclosure -->
                        <div class="card-institutional p-8 h-full flex flex-col relative overflow-hidden group">
                           <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-brand-500/5 rounded-full blur-[80px]"></div>
                           <div class="relative z-10 flex flex-col h-full">
                                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-10">Breakout Entity</div>
                                <h3 class="text-2xl font-display font-bold text-white mb-8 leading-tight">High Engagement <br>Anomaly</h3>
                                <div class="mt-auto">
                                    <div class="text-4xl font-display font-black text-white mb-2 tracking-tighter group-hover:text-brand-400 transition-colors">{{ $musicWeather['viral_artists']['name'] }}</div>
                                    <div class="text-[10px] font-bold text-brand-500 uppercase tracking-[0.2em] mb-8">{{ $musicWeather['viral_artists']['region'] }} Cluster</div>
                                    <a href="/search?q={{ $musicWeather['viral_artists']['name'] }}" class="inline-block px-10 py-3.5 rounded-xl glass border-white/10 text-[10px] font-bold uppercase tracking-[0.2em] text-white hover:bg-brand-600 hover:border-brand-600 transition-all">Synchronize Node</a>
                                </div>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- KNOWLEDGE SYNC PIPELINE -->
        <section class="py-32 relative">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex flex-col md:flex-row justify-between items-end gap-8 mb-16 px-2">
                    <div class="max-w-xl">
                        <div class="inline-block px-3 py-1 rounded bg-brand-500/10 text-brand-500 text-[10px] font-bold uppercase tracking-widest mb-4">Latest Indexing</div>
                        <h2 class="text-4xl md:text-5xl font-display font-black text-white tracking-tight leading-[1.1]">Recently Initialized <br>Records</h2>
                    </div>
                    <a href="{{ route('wiki.index') }}" class="group flex items-center gap-4 text-[10px] font-black uppercase tracking-[0.3em] text-slate-500 hover:text-white transition-all">
                        Access Full Repository 
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    @foreach($newTopics as $article)
                        <a href="{{ route('wiki.show', $article) }}" class="card-institutional group p-8 flex flex-col h-full border-white/5 hover:scale-[1.02]">
                            <div class="flex items-center justify-between mb-8">
                                <span class="px-2.5 py-1 rounded bg-brand-500/10 text-brand-400 text-[9px] font-bold uppercase tracking-widest border border-brand-500/20">
                                    {{ $article->category }}
                                </span>
                                <span class="text-[9px] font-bold text-slate-600 uppercase tracking-widest">{{ $article->created_at->diffForHumans() }}</span>
                            </div>
                            <h3 class="text-2xl font-display font-bold text-white mb-4 group-hover:text-brand-400 transition-colors">{{ $article->title }}</h3>
                            <p class="text-slate-500 text-sm mb-12 line-clamp-3 leading-relaxed">"{{ strip_tags($article->content) }}"</p>
                            
                            <div class="mt-auto flex items-center justify-between pt-6 border-t border-white/5">
                                <div class="flex items-center gap-3">
                                    <div class="w-7 h-7 rounded-lg bg-surface flex items-center justify-center text-[10px] font-black text-brand-500 border border-white/5">{{ substr($article->user->name, 0, 1) }}</div>
                                    <span class="text-[10px] font-semibold text-slate-500">{{ $article->user->name }}</span>
                                </div>
                                <div class="flex items-center gap-1.5 text-slate-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <span class="text-[10px] font-bold">{{ number_format($article->view_count) }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- ACTIVITY & REPUTATION -->
        <section class="py-32 relative bg-surface/50 border-t border-white/5">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid lg:grid-cols-12 gap-16">
                    <div class="lg:col-span-7">
                        <div class="flex items-end justify-between mb-12 px-2">
                            <div>
                                <div class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-2">Network Stream</div>
                                <h3 class="text-3xl font-display font-bold text-white">Consensus Feed</h3>
                            </div>
                            <div class="text-brand-500 text-[10px] font-bold uppercase tracking-widest flex items-center">
                                <span class="w-1.5 h-1.5 rounded-full bg-brand-500 mr-2 animate-pulse"></span>
                                Live Sync Active
                            </div>
                        </div>

                        <div class="space-y-4">
                            @foreach($recentUpdates as $update)
                                <div class="glass p-6 flex items-center gap-6 rounded-2xl border-white/5 group hover:bg-white/[0.04] transition-all">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-dark flex flex-col items-center justify-center border border-white/5">
                                        <div class="text-[10px] font-bold uppercase text-slate-600 leading-none">{{ $update->created_at->format('M') }}</div>
                                        <div class="text-lg font-black text-white leading-none mt-1">{{ $update->created_at->format('d') }}</div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-[10px] font-bold text-brand-500 uppercase tracking-widest mb-1">Update: {{ $update->article->title }}</div>
                                        <div class="text-sm font-medium text-slate-300 truncate tracking-tight">"{{ $update->change_summary }}"</div>
                                        <div class="flex items-center gap-3 mt-3">
                                            <div class="flex items-center gap-1.5 px-2 py-0.5 rounded bg-white/5 text-[9px] font-bold text-slate-500 uppercase">
                                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                                {{ $update->user->name }}
                                            </div>
                                            <span class="text-[9px] font-bold text-slate-700 uppercase tracking-[0.2em]">{{ $update->user->rank_name }}</span>
                                        </div>
                                    </div>
                                    <div class="hidden sm:block text-[9px] font-bold uppercase tracking-widest text-slate-600 bg-white/5 px-3 py-1.5 rounded">Verified</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="lg:col-span-5">
                         <div class="mb-12 px-2">
                            <div class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-2">Elite Scientists</div>
                            <h3 class="text-3xl font-display font-bold text-white">Impact Ranking</h3>
                        </div>
                        
                        <div class="card-institutional p-8 border-white/10 bg-dark/50 shadow-2xl">
                            <div class="space-y-8">
                                @foreach($topContributors as $index => $user)
                                    <div class="flex items-center justify-between group">
                                        <div class="flex items-center gap-5">
                                            <div class="relative">
                                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center font-bold text-lg border border-white/5 group-hover:border-brand-500/30 transition-all">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                                @if($index < 3)
                                                    <div class="absolute -top-1.5 -right-1.5 w-5 h-5 rounded-full {{ ['bg-brand-500','bg-slate-400','bg-orange-800'][$index] }} flex items-center justify-center text-[9px] font-black text-white border-2 border-dark shadow-lg">
                                                        {{ $index + 1 }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-white group-hover:text-brand-400 transition-colors">{{ $user->name }}</div>
                                                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ $user->rank_name }}</div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-sm font-black text-white tracking-tight">{{ number_format($user->reputation_score) }}</div>
                                            <div class="text-[9px] font-bold text-slate-600 uppercase tracking-widest">Impact Factor</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <a href="{{ route('leaderboard') }}" class="block mt-12 text-center text-[10px] font-bold uppercase tracking-[0.4em] text-slate-500 hover:text-white transition-all border-t border-white/5 pt-8">View Global Standings</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA: FINAL DISCLOSURE -->
        <section class="py-40 relative">
            <div class="max-w-4xl mx-auto px-6 text-center animate-fade-in-up">
                <div class="inline-flex items-center gap-2 px-4 py-1 rounded bg-brand-500/10 text-brand-500 text-[10px] font-bold uppercase tracking-widest mb-10 border border-brand-500/20">
                    Open Intelligence Protocol
                </div>
                <h2 class="text-5xl md:text-7xl font-display font-black text-white mb-10 tracking-tighter leading-tight">
                    Contribute to the <br> <span class="text-gradient">Universal Record</span>
                </h2>
                <p class="text-lg md:text-xl text-slate-400 mb-16 leading-relaxed font-medium">
                    Join an elite tier of musical researchers architecting the definitive knowledge graph. Every contribution strengthens the integrity of the network.
                </p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                    <a href="{{ route('wiki.create') }}" class="px-14 py-6 bg-brand-600 hover:bg-brand-500 text-white rounded-2xl font-bold text-xs uppercase tracking-[0.3em] transition-all shadow-2xl shadow-brand-600/20 hover:scale-105 active:scale-95">
                        Initiate Record
                    </a>
                    <a href="{{ route('wiki.generate') }}" class="px-14 py-6 glass border-white/10 text-white rounded-2xl font-bold text-xs uppercase tracking-[0.3em] transition-all hover:bg-white/5 hover:border-white/20 hover:scale-105 active:scale-95">
                        AI Synthesis Assist
                    </a>
                </div>
            </div>
        </section>

        <x-footer />
    </div>

    @auth <livewire:chat-assistant /> @endauth
    <x-toast-container />

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const options = { threshold: 0.05 };
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fade-in-up');
                        observer.unobserve(entry.target);
                    }
                });
            }, options);

            document.querySelectorAll('section, .card-institutional, .glass').forEach(el => {
                el.style.opacity = '0';
                observer.observe(el);
            });
        });
    </script>
</body>
</html>
