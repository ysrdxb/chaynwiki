<div class="relative min-h-screen bg-[#050511] pt-32 pb-24">
    <!-- Background Decor -->
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_var(--tw-gradient-stops))] from-brand-900/20 via-[#050511] to-[#050511]"></div>
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-[0.05]"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Profile Header -->
        <div class="bg-[#0A0A14] border border-white/5 rounded-[40px] p-10 md:p-16 mb-16 shadow-2xl relative overflow-hidden">
            <!-- Decorative Star -->
            <div class="absolute right-12 top-12 text-white/10">
                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0l2.5 9.5 9.5 2.5-9.5 2.5-2.5 9.5-2.5-9.5-9.5-2.5 9.5-2.5z"/></svg>
            </div>

            <div class="flex flex-col md:flex-row items-center md:items-start gap-12">
                <!-- Avatar -->
                <div class="shrink-0 relative">
                    <div class="w-40 h-40 md:w-56 md:h-56 rounded-full overflow-hidden border-4 border-white/5 shadow-2xl bg-[#11111a] flex items-center justify-center">
                        @if($user->avatar)
                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-6xl font-black text-white/20">{{ substr($user->name, 0, 1) }}</span>
                        @endif
                    </div>
                    <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 bg-brand-600 px-6 py-2 rounded-full border border-gray-900 shadow-xl text-[10px] font-black uppercase tracking-widest text-white whitespace-nowrap">
                        Level {{ $user->level }} • {{ $user->rank_name }}
                    </div>
                </div>

                <!-- Info -->
                <div class="flex-1 text-center md:text-left">
                    <div class="mb-8">
                        <h1 class="text-5xl md:text-7xl font-display font-black text-white mb-2 uppercase tracking-tighter">{{ $user->name }}</h1>
                        <p class="text-brand-400 font-mono text-sm uppercase tracking-[0.4em]">{{ '@' . $user->username }}</p>
                    </div>

                    @if($user->bio)
                        <p class="text-gray-400 text-lg leading-relaxed max-w-2xl mb-8">{{ $user->bio }}</p>
                    @else
                        <p class="text-gray-600 italic mb-8">This contributor is still writing their own story...</p>
                    @endif

                    <div class="flex flex-wrap justify-center md:justify-start gap-8 text-xs font-mono text-gray-500 uppercase tracking-widest">
                        @if($user->location)
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $user->location }}
                            </div>
                        @endif
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Sonic Node Joined {{ $user->created_at->format('M d, Y') }}
                        </div>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-2 gap-4 w-full md:w-72">
                    <div class="bg-white/5 border border-white/5 rounded-3xl p-6 text-center group hover:border-brand-500/30 transition-all">
                        <div class="text-3xl font-black text-white group-hover:text-brand-400 transition">{{ $user->reputation_score }}</div>
                        <div class="text-[9px] text-gray-500 uppercase tracking-widest font-mono">Reputation</div>
                    </div>
                    <div class="bg-white/5 border border-white/5 rounded-3xl p-6 text-center group hover:border-brand-500/30 transition-all">
                        <div class="text-3xl font-black text-white group-hover:text-brand-400 transition">{{ $revisionsCount }}</div>
                        <div class="text-[9px] text-gray-500 uppercase tracking-widest font-mono">Accepted Edits</div>
                    </div>
                    <div class="bg-white/5 border border-white/5 rounded-3xl p-6 text-center group hover:border-brand-500/30 transition-all">
                        <div class="text-3xl font-black text-white group-hover:text-brand-400 transition">{{ $articles->count() }}</div>
                        <div class="text-[9px] text-gray-500 uppercase tracking-widest font-mono">Core Pages</div>
                    </div>
                    <div class="bg-white/5 border border-white/5 rounded-3xl p-6 text-center group hover:border-brand-500/30 transition-all">
                        <div class="text-3xl font-black text-white group-hover:text-brand-400 transition">{{ number_format($totalViews) }}</div>
                        <div class="text-[9px] text-gray-500 uppercase tracking-widest font-mono">Impact Views</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Sidebar: Achievements/Badges -->
            <div class="space-y-8">
                <div class="bg-[#0A0A14] border border-white/5 rounded-3xl p-8">
                    <h3 class="text-xs font-mono font-bold text-white uppercase tracking-[0.3em] mb-8 pb-4 border-b border-white/5">Sonic Badges</h3>
                    <div class="grid grid-cols-4 gap-4">
                        <div class="aspect-square rounded-2xl bg-brand-500/10 border border-brand-500/20 flex items-center justify-center text-brand-400" title="Founder">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        </div>
                        <div class="aspect-square rounded-2xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400" title="High Contributor">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-1.815-4.27C14.894 10.273 15.485 10 16 10a4 4 0 014 4v4h-4zM6.185 10.73A5.972 5.972 0 004 15v3H0v-3a4 4 0 014-4c.515 0 1.106.273 1.815.73z"/></svg>
                        </div>
                        <div class="aspect-square rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <div class="aspect-square rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-[#0A0A14] border border-white/5 rounded-3xl p-8">
                    <h3 class="text-xs font-mono font-bold text-white uppercase tracking-[0.3em] mb-8 pb-4 border-b border-white/5">Network Status</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center text-xs font-mono">
                            <span class="text-gray-500 uppercase">Trust level</span>
                            <span class="text-brand-400 font-bold">ALPHA</span>
                        </div>
                        <div class="flex justify-between items-center text-xs font-mono">
                            <span class="text-gray-500 uppercase">Status</span>
                            <span class="text-green-500 font-bold">Verfied Node</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main: Activity Feed -->
            <div class="lg:col-span-2 space-y-8">
                <div class="flex items-center justify-between mb-8 pb-4 border-b border-white/5">
                    <h2 class="text-2xl font-display font-black text-white uppercase tracking-tight">Recent Archives</h2>
                    <span class="text-xs font-mono text-gray-500 uppercase tracking-widest">Showing latest 10 contributions</span>
                </div>
                
                <div class="space-y-6">
                    @forelse($articles as $article)
                        <a href="{{ route('wiki.show', $article->slug) }}" class="group block bg-[#0A0A14] border border-white/5 rounded-3xl p-8 hover:border-brand-500/30 transition-all duration-500 relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-brand-500/0 to-brand-500/0 group-hover:from-brand-500/[0.02] transition-all"></div>
                            
                            <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-4">
                                        <span class="px-3 py-1 bg-white/5 text-gray-400 text-[9px] font-mono font-bold uppercase tracking-widest rounded-full border border-white/5 group-hover:border-brand-500/30 transition shadow-sm">{{ $article->category }}</span>
                                        <span class="text-[9px] font-mono text-gray-600 uppercase tracking-widest">{{ $article->created_at->diffForHumans() }}</span>
                                    </div>
                                    <h4 class="text-2xl font-black text-white group-hover:text-brand-400 transition mb-3 uppercase tracking-tighter">{{ $article->title }}</h4>
                                    <p class="text-gray-500 text-sm leading-relaxed max-w-2xl line-clamp-2">{{ $article->excerpt ?? Str::limit(strip_tags($article->content), 120) }}</p>
                                </div>
                                <div class="shrink-0 flex items-center gap-2 group-hover:translate-x-2 transition-transform">
                                    <span class="text-[10px] font-mono font-bold text-gray-700 group-hover:text-brand-400 uppercase tracking-widest">View Record</span>
                                    <div class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-white group-hover:bg-brand-600 group-hover:border-brand-600 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-24 bg-[#0A0A14] border border-dashed border-white/10 rounded-3xl">
                            <div class="w-16 h-16 rounded-full bg-white/5 flex items-center justify-center mx-auto mb-6">
                                <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            </div>
                            <h3 class="text-xl font-display font-bold text-white mb-2 uppercase tracking-tight">Vast Silence</h3>
                            <p class="text-gray-600 text-sm max-w-xs mx-auto">This node has not yet contributed to the global sonic database.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
