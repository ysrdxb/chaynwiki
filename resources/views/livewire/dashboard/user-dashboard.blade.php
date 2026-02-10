<div class="animate-fade-in relative min-h-screen" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 400)">
    
    {{-- Background Elements --}}
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-blue-500/5 rounded-full blur-[120px] opacity-50"></div>
        <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-indigo-500/5 rounded-full blur-[100px] opacity-30"></div>
    </div>

    {{-- Main Content Container --}}
    <div class="relative z-10 max-w-7xl mx-auto space-y-12 pb-20" x-show="loaded" 
         x-transition:enter="transition ease-out duration-700" 
         x-transition:enter-start="opacity-0 translate-y-8" 
         x-transition:enter-end="opacity-100 translate-y-0">
        
        {{-- Profile Header Refined --}}
        <div class="card-premium !bg-[#161b22]/60 backdrop-blur-md !p-10 relative overflow-hidden group border-white/5 hover:border-blue-500/20 transition-all duration-700">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/[0.03] via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center gap-10">
                {{-- Avatar Refined --}}
                <div class="relative shrink-0 group/avatar">
                    <div class="w-40 h-40 rounded-[2.5rem] p-1 bg-gradient-to-br from-white/10 to-transparent group-hover/avatar:from-blue-500/50 transition-all duration-500 shadow-3xl">
                        <div class="w-full h-full rounded-[2.2rem] bg-[#0d1117] flex items-center justify-center overflow-hidden border border-white/5">
                             @if($user->avatar)
                                <img src="{{ $user->avatar }}" class="w-full h-full object-cover grayscale group-hover/avatar:grayscale-0 group-hover/avatar:scale-110 transition-all duration-700">
                            @else
                                <span class="text-7xl font-black text-white/5 select-none transition-all duration-700 group-hover/avatar:text-blue-500 group-hover/avatar:scale-110" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ substr($user->name, 0, 1) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="absolute -bottom-3 left-1/2 -translate-x-1/2 bg-blue-500 border-[3px] border-[#161b22] text-white text-[10px] font-black uppercase tracking-widest px-4 py-1.5 rounded-xl shadow-3xl group-hover/avatar:scale-110 transition-transform duration-500">
                        RANK {{ $user->level }}
                    </div>
                </div>

                {{-- User Info Refined --}}
                <div class="flex-1 text-center md:text-left">
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 mb-4">
                        <span class="px-3 py-1 bg-blue-500/10 border border-blue-500/20 rounded-lg text-[10px] font-black text-blue-500 uppercase tracking-widest">Authorized Session</span>
                        <span class="text-white/20 text-[10px] font-black uppercase tracking-[0.3em]">Established {{ $user->created_at->format('Y') }}</span>
                    </div>
                    <h1 class="text-[54px] md:text-[72px] font-black text-white uppercase tracking-tightest leading-[0.85] mb-6" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        {{ $user->name }}
                    </h1>
                    
                    <div class="flex flex-wrap justify-center md:justify-start gap-8 items-center">
                        <div class="flex items-center gap-3 text-[11px] font-black text-white/40 uppercase tracking-[0.3em]">
                            <div class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></div>
                            {{ $user->rank_name ?? 'Senior Contributor' }}
                        </div>
                        <div class="flex items-center gap-3 text-[11px] font-black text-white/40 uppercase tracking-[0.3em]">
                             <svg class="w-4 h-4 text-blue-500/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                             {{ $user->location ?? 'GLOBAL_NODE' }}
                        </div>
                    </div>
                </div>

                {{-- Action Button Refined --}}
                <div class="shrink-0 pt-6 md:pt-0">
                     <a href="{{ route('settings') }}" wire:navigate class="btn-figma-secondary !px-8 !py-4 shadow-3xl">
                        <span>Node Settings</span>
                        <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center shadow-inner group-hover:rotate-90 transition-transform duration-700">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        {{-- Stats Grid Refined --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            {{-- Reputation Refined --}}
            <div class="card-premium h-auto !bg-[#161b22]/40 backdrop-blur-sm !p-8 group overflow-hidden border-white/5 hover:border-blue-500/20 transition-all duration-500 shadow-3xl">
                <div class="absolute inset-0 bg-blue-500/[0.02] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="flex items-center justify-between mb-8">
                    <span class="text-[10px] font-black text-white/20 uppercase tracking-[0.4em]">Node Reputation</span>
                    <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center text-blue-500 shadow-3xl group-hover:bg-blue-500 group-hover:text-white transition-all duration-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-[44px] font-black text-white uppercase tracking-tightest leading-none" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ number_format($stats['reputation']) }}</span>
                    <span class="text-[10px] font-black text-blue-500 uppercase tracking-widest">CREDITS</span>
                </div>
            </div>

            {{-- Contributions Refined --}}
            <div class="card-premium h-auto !bg-[#161b22]/40 backdrop-blur-sm !p-8 group overflow-hidden border-white/5 hover:border-green-500/20 transition-all duration-500 shadow-3xl">
                <div class="absolute inset-0 bg-green-500/[0.02] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="flex items-center justify-between mb-8">
                    <span class="text-[10px] font-black text-white/20 uppercase tracking-[0.4em]">Index Activity</span>
                    <div class="w-8 h-8 rounded-lg bg-green-500/10 flex items-center justify-center text-green-500 shadow-3xl group-hover:bg-green-500 group-hover:text-white transition-all duration-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-[44px] font-black text-white uppercase tracking-tightest leading-none" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ number_format($stats['contributions']) }}</span>
                    <span class="text-[10px] font-black text-green-500 uppercase tracking-widest">COMMITS</span>
                </div>
            </div>

            {{-- Saved Items Refined --}}
            <div class="card-premium h-auto !bg-[#161b22]/40 backdrop-blur-sm !p-8 group overflow-hidden border-white/5 hover:border-purple-500/20 transition-all duration-500 shadow-3xl">
                <div class="absolute inset-0 bg-purple-500/[0.02] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="flex items-center justify-between mb-8">
                    <span class="text-[10px] font-black text-white/20 uppercase tracking-[0.4em]">Secured Data</span>
                    <div class="w-8 h-8 rounded-lg bg-purple-500/10 flex items-center justify-center text-purple-500 shadow-3xl group-hover:bg-purple-500 group-hover:text-white transition-all duration-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-[44px] font-black text-white uppercase tracking-tightest leading-none" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ number_format($stats['bookmarks']) }}</span>
                    <span class="text-[10px] font-black text-purple-500 uppercase tracking-widest">RECORDS</span>
                </div>
            </div>

            {{-- Progress --}}
            <div class="bg-[#161b22] border border-white/5 rounded-2xl p-6 relative flex flex-col justify-between">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[10px] font-black text-white/40 uppercase tracking-widest">Next Level</span>
                    <span class="text-[10px] font-bold text-white">{{ ($stats['reputation'] % 100) }}%</span>
                </div>
                <div class="w-full bg-white/5 rounded-full h-2 overflow-hidden">
                    <div class="h-full bg-blue-500 rounded-full" style="width: {{ ($stats['reputation'] % 100) }}%"></div>
                </div>
                <div class="mt-2 text-[10px] text-white/30 font-medium">
                    {{ 100 - ($stats['reputation'] % 100) }} XP to Level {{ $user->level + 1 }}
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Activity Feed Refined --}}
            <div class="lg:col-span-2 space-y-10">
                <div class="flex items-center border-b border-white/5 pb-6">
                    <div class="w-1.5 h-10 bg-blue-500 rounded-full mr-6"></div>
                    <h2 class="text-2xl font-black text-white uppercase tracking-tightest" style="font-family: 'Plus Jakarta Sans', sans-serif;">RECENT LOGS <span class="text-white/10 ml-4 font-black">/ TRANSMISSION FEED</span></h2>
                </div>

                <div class="space-y-6">
                    @forelse($activities as $act)
                        <div class="group relative">
                            <div class="absolute -left-4 top-1/2 -translate-y-1/2 w-1 h-0 group-hover:h-full bg-blue-500 transition-all duration-500 rounded-full"></div>
                            <div class="card-premium h-auto !bg-[#161b22]/40 backdrop-blur-sm !p-8 flex flex-col md:flex-row md:items-center justify-between gap-6 hover:translate-x-2 transition-all duration-500 border-white/5 hover:border-blue-500/20 shadow-3xl">
                                <div class="flex items-center gap-8 flex-1 min-w-0">
                                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center shrink-0 border border-white/10 group-hover:bg-blue-500/10 group-hover:border-blue-500/20 transition-all duration-500 {{ $act['type'] === 'contribution' ? 'bg-blue-500/5 text-blue-500' : 'bg-purple-500/5 text-purple-500 group-hover:bg-purple-500/10 group-hover:border-purple-500/20 group-hover:text-purple-500' }}">
                                        @if($act['icon'] === 'pencil')
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        @else
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-4 mb-2">
                                            <h3 class="text-lg font-black text-white uppercase tracking-tightest truncate group-hover:text-blue-500 transition-colors" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $act['title'] }}</h3>
                                            <div class="w-1.5 h-1.5 rounded-full bg-white/10 hidden md:block"></div>
                                            <span class="text-[10px] font-black text-white/20 uppercase tracking-[0.3em] hidden md:block">{{ $act['date']->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-[11px] font-black text-white/20 uppercase tracking-[0.4em] mb-4">
                                            {{ $act['type'] === 'contribution' ? 'DATA_COMMIT' : 'CACHE_SAVE' }}
                                        </p>
                                        @if($act['type'] === 'contribution')
                                            <div class="inline-flex items-center gap-3 px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest shadow-2xl {{ $act['status'] === 'approved' ? 'bg-green-500/10 text-green-400 border border-green-500/10' : ($act['status'] === 'rejected' ? 'bg-red-500/10 text-red-500 border border-red-500/10' : 'bg-yellow-500/10 text-yellow-500 border border-yellow-500/10') }}">
                                                <div class="w-1.5 h-1.5 rounded-full bg-current animate-pulse"></div>
                                                {{ $act['status'] }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="w-12 h-12 rounded-full bg-white/5 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-500 translate-x-4 group-hover:translate-x-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-32 rounded-[3.5rem] border border-dashed border-white/5 bg-white/[0.01] shadow-3xl">
                            <div class="w-24 h-24 rounded-full bg-blue-500/5 mx-auto mb-10 flex items-center justify-center border border-white/5 shadow-3xl">
                                <svg class="w-10 h-10 text-white/10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <p class="text-white/10 text-[11px] font-black uppercase tracking-[0.5em]">No synchronization history detected</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-8">
            {{-- Sidebar Refined --}}
            <div class="space-y-12">
                {{-- Recommended Refined --}}
                <div class="space-y-8">
                    <div class="flex items-center border-b border-white/5 pb-4">
                        <h2 class="text-xl font-black text-white uppercase tracking-tightest" style="font-family: 'Plus Jakarta Sans', sans-serif;">SUGGESTED <span class="text-white/10 ml-2">DATA</span></h2>
                    </div>
                    <div class="space-y-3">
                        @foreach($recommendations as $rec)
                            <a href="{{ route('wiki.show', $rec->slug) }}" wire:navigate class="flex items-center gap-5 p-4 rounded-2xl bg-white/[0.01] hover:bg-white/[0.03] border border-white/0 hover:border-white/5 transition-all duration-500 group">
                                <div class="w-16 h-16 rounded-xl bg-[#0d1117] relative overflow-hidden shrink-0 border border-white/5 shadow-2xl">
                                    @if($rec->featured_image)
                                        <img src="{{ Storage::url($rec->featured_image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-white/5">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-blue-500/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-sm font-black text-white uppercase tracking-tightest group-hover:text-blue-500 transition-colors truncate mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $rec->title }}</h4>
                                    <p class="text-[9px] font-black text-white/20 uppercase tracking-[0.3em]">{{ $rec->category }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Quick Actions Refined --}}
                <div class="card-premium h-auto !bg-blue-600 !p-10 text-center relative overflow-hidden group border-none shadow-3xl shadow-blue-500/20">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                    <div class="absolute -top-12 -right-12 w-48 h-48 bg-white/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
                    
                    <div class="relative z-10">
                        <div class="w-20 h-20 bg-white/10 rounded-[2rem] flex items-center justify-center mx-auto mb-8 backdrop-blur-md shadow-3xl border border-white/20 group-hover:rotate-12 transition-transform duration-500">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <h3 class="text-3xl font-black text-white uppercase tracking-tightest mb-4 leading-none" style="font-family: 'Plus Jakarta Sans', sans-serif;">INDEX NEW DATA</h3>
                        <p class="text-[11px] font-black text-white/60 mb-10 uppercase tracking-[0.3em] leading-relaxed">Contribute to the global knowledge archive</p>
                        <a href="{{ route('wiki.create') }}" wire:navigate class="block w-full py-5 bg-white text-blue-600 text-[11px] font-black uppercase tracking-[0.4em] rounded-[1.5rem] hover:bg-blue-50 transition-all shadow-3xl hover:scale-[1.02] active:scale-[0.98]">
                            Start Commit
                        </a>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
