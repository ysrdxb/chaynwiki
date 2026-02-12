<div class="space-y-8">
    
    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        {{-- Total Articles --}}
        <div class="p-6 rounded-2xl bg-[#161b22]/60 backdrop-blur-xl border border-white/5 relative overflow-hidden group hover:border-blue-500/30 transition-all duration-300">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
            <div class="relative z-10">
                <p class="text-[11px] font-black text-blue-400 uppercase tracking-widest mb-1">Total Content</p>
                <h3 class="text-[32px] font-black text-white tracking-tighter leading-none">{{ number_format($stats['articles'] ?? 0) }}</h3>
                <div class="flex items-center gap-2 mt-4">
                    <span class="px-2 py-0.5 rounded bg-blue-500/10 border border-blue-500/20 text-[10px] font-bold text-blue-400">+12 this week</span>
                </div>
            </div>
        </div>

        {{-- Total Users --}}
        <div class="p-6 rounded-2xl bg-[#161b22]/60 backdrop-blur-xl border border-white/5 relative overflow-hidden group hover:border-purple-500/30 transition-all duration-300">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
            <div class="relative z-10">
                <p class="text-[11px] font-black text-purple-400 uppercase tracking-widest mb-1">Community</p>
                <h3 class="text-[32px] font-black text-white tracking-tighter leading-none">{{ number_format($stats['users'] ?? 0) }}</h3>
                <div class="flex items-center gap-2 mt-4">
                    <span class="px-2 py-0.5 rounded bg-purple-500/10 border border-purple-500/20 text-[10px] font-bold text-purple-400">+5 new users</span>
                </div>
            </div>
        </div>

        {{-- Neural Nodes --}}
        <div class="p-6 rounded-2xl bg-[#161b22]/60 backdrop-blur-xl border border-white/5 relative overflow-hidden group hover:border-emerald-500/30 transition-all duration-300">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div class="relative z-10">
                <p class="text-[11px] font-black text-emerald-400 uppercase tracking-widest mb-1">Neural Nodes</p>
                <h3 class="text-[32px] font-black text-white tracking-tighter leading-none">{{ number_format($stats['nodes'] ?? 0) }}</h3>
                <div class="flex items-center gap-2 mt-4">
                    <span class="px-2 py-0.5 rounded bg-emerald-500/10 border border-emerald-500/20 text-[10px] font-bold text-emerald-400">Active Graph</span>
                </div>
            </div>
        </div>

        {{-- Pending Revisions --}}
        <div class="p-6 rounded-2xl bg-[#161b22]/60 backdrop-blur-xl border border-white/5 relative overflow-hidden group hover:border-orange-500/30 transition-all duration-300">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="relative z-10">
                <p class="text-[11px] font-black text-orange-400 uppercase tracking-widest mb-1">Pending Review</p>
                <h3 class="text-[32px] font-black text-white tracking-tighter leading-none">{{ number_format($stats['revisions'] ?? 0) }}</h3>
                <div class="flex items-center gap-2 mt-4">
                    <a href="{{ route('admin.revisions') }}" class="px-2 py-0.5 rounded bg-orange-500/10 border border-orange-500/20 text-[10px] font-bold text-orange-400 hover:bg-orange-500/20 transition-colors">Review Queue &rarr;</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Activity & Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Activity Feed --}}
        <div class="lg:col-span-2 p-8 rounded-[32px] bg-[#161b22]/60 backdrop-blur-xl border border-white/5">
            <h3 class="text-[18px] font-black text-white uppercase tracking-tighter mb-6 flex items-center gap-3">
                <span class="w-2 h-2 rounded-full bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.5)]"></span>
                Recent System Activity
            </h3>
            
            <div class="space-y-4">
                @foreach($recentActivity ?? [] as $activity)
                    <div class="flex items-center gap-4 p-4 rounded-xl bg-white/[0.02] border border-white/5 hover:bg-white/[0.04] transition-colors group">
                        <div class="w-10 h-10 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-400 font-bold text-xs ring-1 ring-white/5 group-hover:bg-blue-500/20 transition-colors">
                            {{ substr($activity->user->name ?? 'S', 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <p class="text-[13px] font-bold text-white group-hover:text-blue-400 transition-colors">
                                {{ $activity->description }}
                                <span class="text-white/40 font-normal ml-1">by {{ $activity->user->name ?? 'System' }}</span>
                            </p>
                            <p class="text-[10px] text-white/30 font-medium uppercase tracking-wider mt-1">{{ $activity->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endforeach
                
                @if(empty($recentActivity))
                    <div class="text-center py-8 text-white/20 text-[12px] font-bold uppercase tracking-widest">
                        No recent activity recorded
                    </div>
                @endif
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="p-8 rounded-[32px] bg-[#161b22]/60 backdrop-blur-xl border border-white/5">
            <h3 class="text-[18px] font-black text-white uppercase tracking-tighter mb-6 flex items-center gap-3">
                <span class="w-2 h-2 rounded-full bg-purple-500 shadow-[0_0_10px_rgba(168,85,247,0.5)]"></span>
                Quick Tools
            </h3>
            
            <div class="space-y-3">
                <a href="{{ route('wiki.generate') }}" class="flex items-center gap-3 p-4 rounded-xl bg-purple-500/10 border border-purple-500/20 hover:bg-purple-500/20 hover:border-purple-500/30 transition-all group">
                    <div class="w-10 h-10 rounded-lg bg-purple-500/20 flex items-center justify-center text-purple-400 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <div>
                        <div class="text-[13px] font-bold text-white group-hover:text-purple-300 transition-colors">AI Article Generator</div>
                        <div class="text-[10px] text-white/40 mt-0.5 group-hover:text-white/60">Create content with Neural Map</div>
                    </div>
                </a>

                <a href="{{ route('tools.lyrics') }}" class="flex items-center gap-3 p-4 rounded-xl bg-pink-500/10 border border-pink-500/20 hover:bg-pink-500/20 hover:border-pink-500/30 transition-all group">
                    <div class="w-10 h-10 rounded-lg bg-pink-500/20 flex items-center justify-center text-pink-400 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                    </div>
                    <div>
                        <div class="text-[13px] font-bold text-white group-hover:text-pink-300 transition-colors">Lyric Analyzer</div>
                        <div class="text-[10px] text-white/40 mt-0.5 group-hover:text-white/60">Sentiment & rhyme analysis</div>
                    </div>
                </a>

                <button wire:click="$refresh" class="w-full flex items-center gap-3 p-4 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all group text-left">
                    <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center text-white/40 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    </div>
                    <div>
                        <div class="text-[13px] font-bold text-white">Refresh Data</div>
                        <div class="text-[10px] text-white/40 mt-0.5">Update real-time stats</div>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>
