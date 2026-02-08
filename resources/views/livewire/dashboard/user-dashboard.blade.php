<div class="animate-fade-in relative min-h-screen" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 400)">
    
    {{-- Background Elements --}}
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-blue-500/5 rounded-full blur-[120px] opacity-50"></div>
        <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-indigo-500/5 rounded-full blur-[100px] opacity-30"></div>
    </div>

    {{-- Main Content Container --}}
    <div class="relative z-10 max-w-7xl mx-auto space-y-8" x-show="loaded" 
         x-transition:enter="transition ease-out duration-700" 
         x-transition:enter-start="opacity-0 translate-y-4" 
         x-transition:enter-end="opacity-100 translate-y-0">
        
        {{-- Profile Header --}}
        <div class="bg-[#161b22] border border-white/5 rounded-2xl p-8 md:p-10 relative overflow-hidden shadow-2xl group">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/5 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center gap-8 md:gap-12">
                {{-- Avatar --}}
                <div class="relative shrink-0">
                    <div class="w-32 h-32 rounded-2xl p-1 bg-gradient-to-br from-white/10 to-transparent">
                        <div class="w-full h-full rounded-xl bg-[#0d1117] flex items-center justify-center overflow-hidden">
                             @if($user->avatar)
                                <img src="{{ $user->avatar }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-5xl font-black text-white/5 select-none">{{ substr($user->name, 0, 1) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="absolute -bottom-3 left-1/2 -translate-x-1/2 bg-[#0d1117] border border-blue-500/30 text-blue-400 text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-lg">
                        LVL {{ $user->level }}
                    </div>
                </div>

                {{-- User Info --}}
                <div class="flex-1 space-y-4">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[10px] font-black uppercase tracking-widest mb-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
                            Member Profile
                        </div>
                        <h1 class="text-4xl md:text-5xl font-black text-white uppercase tracking-tight leading-none">
                            {{ $user->name }}
                        </h1>
                    </div>
                    
                    <div class="flex flex-wrap gap-6 items-center">
                        <div class="flex items-center gap-3 text-xs font-bold text-white/40 uppercase tracking-wider">
                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            {{ $user->rank_name ?? 'Standard Member' }}
                        </div>
                        <div class="flex items-center gap-3 text-xs font-bold text-white/40 uppercase tracking-wider">
                             <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                             {{ $user->location ?? 'Global' }}
                        </div>
                        <div class="flex items-center gap-3 text-xs font-bold text-white/40 uppercase tracking-wider">
                             <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                             Joined {{ $user->created_at->format('M Y') }}
                        </div>
                    </div>
                </div>

                {{-- Action Button --}}
                <div>
                     <a href="{{ route('settings') }}" wire:navigate class="px-6 py-3 bg-white/5 hover:bg-white/10 border border-white/5 hover:border-white/10 rounded-xl text-xs font-bold text-white uppercase tracking-widest transition-all flex items-center gap-3 group/btn">
                        <span>Settings</span>
                        <svg class="w-4 h-4 text-white/40 group-hover/btn:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            {{-- Reputation --}}
            <div class="bg-[#161b22] border border-white/5 rounded-2xl p-6 relative group overflow-hidden hover:border-blue-500/30 transition-all duration-500">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-black text-white/40 uppercase tracking-widest">Reputation</span>
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-black text-white tracking-tight">{{ number_format($stats['reputation']) }}</span>
                    <span class="text-xs font-bold text-blue-500">XP</span>
                </div>
            </div>

            {{-- Contributions --}}
            <div class="bg-[#161b22] border border-white/5 rounded-2xl p-6 relative group overflow-hidden hover:border-green-500/30 transition-all duration-500">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-black text-white/40 uppercase tracking-widest">Contributions</span>
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-black text-white tracking-tight">{{ number_format($stats['contributions']) }}</span>
                    <span class="text-xs font-bold text-green-500">Edits</span>
                </div>
            </div>

            {{-- Saved Items --}}
            <div class="bg-[#161b22] border border-white/5 rounded-2xl p-6 relative group overflow-hidden hover:border-purple-500/30 transition-all duration-500">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-black text-white/40 uppercase tracking-widest">Saved Items</span>
                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-black text-white tracking-tight">{{ number_format($stats['bookmarks']) }}</span>
                    <span class="text-xs font-bold text-purple-500">Records</span>
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
            {{-- Activity Feed --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-white/5">
                    <h2 class="text-xl font-bold text-white">Recent Activity</h2>
                </div>

                <div class="space-y-4">
                    @forelse($activities as $act)
                        <div class="flex items-start gap-5 p-5 rounded-2xl bg-[#161b22] border border-white/5 hover:border-white/10 transition-colors group">
                            <div class="mt-1 w-10 h-10 rounded-xl flex items-center justify-center shrink-0 {{ $act['type'] === 'contribution' ? 'bg-blue-500/10 text-blue-500' : 'bg-purple-500/10 text-purple-500' }}">
                                @if($act['icon'] === 'pencil')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-4 mb-1">
                                    <h3 class="text-sm font-bold text-white group-hover:text-blue-400 transition-colors truncate">{{ $act['title'] }}</h3>
                                    <span class="text-[10px] font-bold text-white/30 uppercase shrink-0">{{ $act['date']->diffForHumans() }}</span>
                                </div>
                                <p class="text-xs text-white/50 line-clamp-1 mb-2">
                                    {{ $act['type'] === 'contribution' ? 'Contributed to standard wiki protocol' : 'Saved to personal registry' }}
                                </p>
                                @if($act['type'] === 'contribution')
                                    <div class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider {{ $act['status'] === 'approved' ? 'bg-green-500/10 text-green-500' : ($act['status'] === 'rejected' ? 'bg-red-500/10 text-red-500' : 'bg-yellow-500/10 text-yellow-500') }}">
                                        <span class="w-1 h-1 rounded-full bg-current"></span>
                                        {{ $act['status'] }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16 bg-[#161b22] border border-dashed border-white/5 rounded-2xl">
                            <svg class="w-12 h-12 text-white/10 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="text-sm text-white/40 font-medium">No activity recorded yet</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-8">
                {{-- Recommended --}}
                <div class="space-y-6">
                    <div class="flex items-center justify-between pb-4 border-b border-white/5">
                        <h2 class="text-xl font-bold text-white">Suggested</h2>
                    </div>
                    <div class="space-y-4">
                        @foreach($recommendations as $rec)
                            <a href="{{ route('wiki.show', $rec->slug) }}" wire:navigate class="flex items-center gap-4 p-3 rounded-xl hover:bg-white/5 transition-colors group">
                                <div class="w-12 h-12 rounded-lg bg-[#0d1117] relative overflow-hidden shrink-0 border border-white/5">
                                    @if($rec->featured_image)
                                        <img src="{{ Storage::url($rec->featured_image) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-white/10">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-sm font-bold text-white group-hover:text-blue-400 transition-colors truncate">{{ $rec->title }}</h4>
                                    <p class="text-[10px] font-bold text-white/40 uppercase tracking-wider">{{ $rec->category }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-6 text-center relative overflow-hidden group">
                    <div class="absolute inset-0 opacity-20 mix-blend-overlay" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 200 200%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22noise%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.65%22 numOctaves=%223%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23noise)%22 opacity=%221%22/%3E%3C/svg%3E')"></div>
                    <div class="absolute -top-12 -right-12 w-32 h-32 bg-white/20 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                    
                    <div class="relative z-10">
                        <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center mx-auto mb-4 backdrop-blur-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        </div>
                        <h3 class="text-lg font-black text-white uppercase tracking-tight mb-2">Create New Entry</h3>
                        <p class="text-xs text-blue-100/70 mb-6 font-medium">Contribute to the global knowledge base</p>
                        <a href="{{ route('wiki.create') }}" wire:navigate class="block w-full py-3 bg-white text-blue-600 text-xs font-black uppercase tracking-widest rounded-xl hover:bg-blue-50 transition-colors shadow-xl">
                            Start Writing
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
