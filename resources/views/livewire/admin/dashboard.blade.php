<div class="space-y-10">
    
    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Total Articles --}}
        <div class="p-8 rounded-[24px] bg-[#161b22] border border-white/5 relative overflow-hidden group hover:border-blue-500/30 transition-all duration-500 hover:shadow-2xl hover:shadow-blue-500/5">
            <div class="absolute top-0 right-0 p-6 opacity-5 group-hover:opacity-10 group-hover:scale-110 transition-all duration-500">
                <svg class="w-20 h-20 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-2 h-2 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.5)]"></div>
                    <p class="text-[10px] font-black text-blue-400 uppercase tracking-[0.2em]">Global Content</p>
                </div>
                <h3 class="text-[40px] font-black text-white tracking-tighter leading-none">{{ number_format($stats['articles'] ?? 0) }}</h3>
                <div class="flex items-center gap-2 mt-6">
                    <span class="px-2.5 py-1 rounded-lg bg-blue-500/10 border border-blue-500/20 text-[10px] font-bold text-blue-400 uppercase tracking-widest">+12 this week</span>
                </div>
            </div>
        </div>

        {{-- Total Users --}}
        <div class="p-8 rounded-[24px] bg-[#161b22] border border-white/5 relative overflow-hidden group hover:border-purple-500/30 transition-all duration-500 hover:shadow-2xl hover:shadow-purple-500/5">
            <div class="absolute top-0 right-0 p-6 opacity-5 group-hover:opacity-10 group-hover:scale-110 transition-all duration-500">
                <svg class="w-20 h-20 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-2 h-2 rounded-full bg-purple-500 shadow-[0_0_8px_rgba(168,85,247,0.5)]"></div>
                    <p class="text-[10px] font-black text-purple-400 uppercase tracking-[0.2em]">Community</p>
                </div>
                <h3 class="text-[40px] font-black text-white tracking-tighter leading-none">{{ number_format($stats['users'] ?? 0) }}</h3>
                <div class="flex items-center gap-2 mt-6">
                    <span class="px-2.5 py-1 rounded-lg bg-purple-500/10 border border-purple-500/20 text-[10px] font-bold text-purple-400 uppercase tracking-widest">+5 new users</span>
                </div>
            </div>
        </div>

        {{-- Neural Nodes --}}
        <div class="p-8 rounded-[24px] bg-[#161b22] border border-white/5 relative overflow-hidden group hover:border-emerald-500/30 transition-all duration-500 hover:shadow-2xl hover:shadow-emerald-500/5">
            <div class="absolute top-0 right-0 p-6 opacity-5 group-hover:opacity-10 group-hover:scale-110 transition-all duration-500">
                <svg class="w-20 h-20 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></div>
                    <p class="text-[10px] font-black text-emerald-400 uppercase tracking-[0.2em]">Neural Nodes</p>
                </div>
                <h3 class="text-[40px] font-black text-white tracking-tighter leading-none">{{ number_format($stats['nodes'] ?? 0) }}</h3>
                <div class="flex items-center gap-2 mt-6">
                    <span class="px-2.5 py-1 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-[10px] font-bold text-emerald-400 uppercase tracking-widest">Active Graph</span>
                </div>
            </div>
        </div>

        {{-- Pending Revisions --}}
        <div class="p-8 rounded-[24px] bg-[#161b22] border border-white/5 relative overflow-hidden group hover:border-orange-500/30 transition-all duration-500 hover:shadow-2xl hover:shadow-orange-500/5">
            <div class="absolute top-0 right-0 p-6 opacity-5 group-hover:opacity-10 group-hover:scale-110 transition-all duration-500">
                <svg class="w-20 h-20 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-2 h-2 rounded-full bg-orange-500 shadow-[0_0_8px_rgba(249,115,22,0.5)]"></div>
                    <p class="text-[10px] font-black text-orange-400 uppercase tracking-[0.2em]">Review Queue</p>
                </div>
                <h3 class="text-[40px] font-black text-white tracking-tighter leading-none">{{ number_format($stats['revisions'] ?? 0) }}</h3>
                <div class="flex items-center gap-2 mt-6">
                    <a href="{{ route('admin.revisions') }}" class="px-3 py-1.5 rounded-lg bg-orange-500/10 border border-orange-500/20 text-[10px] font-bold text-orange-400 hover:bg-orange-500/20 transition-all group-hover:px-4 uppercase tracking-widest">Review &rarr;</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Activity & Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Activity Feed --}}
        <div class="lg:col-span-2 p-10 rounded-[32px] bg-[#161b22] border border-white/5 relative overflow-hidden shadow-2xl">
             <div class="absolute top-0 right-0 p-10 opacity-[0.02] pointer-events-none">
                <svg class="w-64 h-64 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>

            <h3 class="text-[20px] font-black text-white uppercase tracking-tighter mb-8 flex items-center gap-4 relative z-10">
                <span class="w-3 h-3 rounded-full bg-blue-500 shadow-[0_0_15px_rgba(59,130,246,0.5)]"></span>
                System Pulsar Activity
            </h3>
            
            <div class="space-y-4 relative z-10">
                @foreach($recentActivity ?? [] as $activity)
                    <div class="flex items-center gap-5 p-5 rounded-2xl bg-white/[0.02] border border-white/5 hover:bg-white/[0.04] hover:border-white/10 transition-all group">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-blue-600/20 to-indigo-600/20 border border-white/10 flex items-center justify-center text-blue-400 font-bold text-sm shadow-xl group-hover:scale-105 transition-transform">
                            {{ substr($activity->user->name ?? 'S', 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[14px] font-bold text-white group-hover:text-blue-400 transition-colors whitespace-nowrap overflow-hidden text-ellipsis">
                                {{ $activity->description }}
                                <span class="text-white/30 font-medium ml-1">by {{ $activity->user->name ?? 'System' }}</span>
                            </p>
                            <div class="flex items-center gap-3 mt-1.5">
                                <p class="text-[9px] text-white/40 font-black uppercase tracking-widest">{{ $activity->created_at->diffForHumans() }}</p>
                                <div class="w-1 h-1 rounded-full bg-white/10"></div>
                                <p class="text-[9px] text-blue-500/60 font-black uppercase tracking-widest">Verified</p>
                            </div>
                        </div>
                        <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                             <svg class="w-5 h-5 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </div>
                @endforeach
                
                @if(empty($recentActivity))
                    <div class="flex flex-col items-center justify-center py-20 text-center opacity-40">
                         <svg class="w-16 h-16 text-white/10 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        <h4 class="text-sm font-black text-white uppercase tracking-[0.3em]">No Pulse Found</h4>
                        <p class="text-[10px] text-white/50 mt-2">Waiting for next system interaction...</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="p-10 rounded-[32px] bg-[#161b22] border border-white/5 shadow-2xl">
            <h3 class="text-[20px] font-black text-white uppercase tracking-tighter mb-8 flex items-center gap-4">
                <span class="w-3 h-3 rounded-full bg-purple-500 shadow-[0_0_15px_rgba(168,85,247,0.5)]"></span>
                Rapid Access
            </h3>
            
            <div class="space-y-4">
                <a href="{{ route('admin.articles.generate') }}" class="flex items-center gap-4 p-5 rounded-2xl bg-purple-500/5 border border-purple-500/10 hover:bg-purple-500/10 hover:border-purple-500/30 transition-all group overflow-hidden relative">
                    <div class="absolute inset-0 bg-gradient-to-tr from-purple-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="w-12 h-12 rounded-xl bg-purple-500/20 flex items-center justify-center text-purple-400 group-hover:scale-110 transition-transform relative z-10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <div class="relative z-10">
                        <div class="text-[14px] font-bold text-white group-hover:text-purple-300 transition-colors">AI Generator</div>
                        <div class="text-[10px] text-white/40 mt-1 uppercase tracking-widest font-black group-hover:text-white/60">Neural Pulse</div>
                    </div>
                </a>

                <a href="{{ route('tools.lyrics') }}" class="flex items-center gap-4 p-5 rounded-2xl bg-blue-500/5 border border-blue-500/10 hover:bg-blue-500/10 hover:border-blue-500/30 transition-all group overflow-hidden relative">
                    <div class="absolute inset-0 bg-gradient-to-tr from-blue-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center text-blue-400 group-hover:scale-110 transition-transform relative z-10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                    </div>
                    <div class="relative z-10">
                        <div class="text-[14px] font-bold text-white group-hover:text-blue-300 transition-colors">Lyric Analyzer</div>
                        <div class="text-[10px] text-white/40 mt-1 uppercase tracking-widest font-black group-hover:text-white/60">Deep Sentiment</div>
                    </div>
                </a>

                <button wire:click="$refresh" class="w-full flex items-center gap-4 p-5 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all group text-left overflow-hidden relative">
                    <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center text-white/40 group-hover:text-white group-hover:rotate-180 transition-all duration-500 relative z-10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    </div>
                    <div class="relative z-10">
                        <div class="text-[14px] font-bold text-white">Sync Dashboard</div>
                        <div class="text-[10px] text-white/40 mt-1 uppercase tracking-widest font-black">Refresh Core</div>
                    </div>
                </button>
            </div>
            
            <div class="mt-10 pt-10 border-t border-white/5">
                <div class="p-6 rounded-2xl bg-[#0d1117] border border-white/5">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                        <div class="text-[9px] font-black text-white/30 uppercase tracking-[0.2em]">Maintenance Mode</div>
                    </div>
                    <p class="text-[11px] text-white/40 leading-relaxed font-bold italic">"Consistency is the sound of excellence."</p>
                </div>
            </div>
        </div>
    </div>
</div>

