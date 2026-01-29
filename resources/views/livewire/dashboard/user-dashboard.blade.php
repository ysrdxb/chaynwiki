<div class="animate-fade-in relative">
    {{-- Background Glows --}}
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute top-1/4 -left-32 w-[600px] h-[600px] bg-brand-500/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-1/4 -right-32 w-[600px] h-[600px] bg-purple-500/10 rounded-full blur-[120px]"></div>
    </div>

    <div class="relative z-10 space-y-12">
        {{-- Profile Header Card --}}
        <div class="bg-[#0A0A14]/60 backdrop-blur-2xl border border-white/10 rounded-[40px] p-8 md:p-12 overflow-hidden relative group">
            <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-gradient-to-br from-brand-600/10 to-transparent blur-[80px] -mr-40 -mt-40 transition-transform duration-1000 group-hover:scale-110"></div>
            
            <div class="flex flex-col md:flex-row items-center gap-8 relative z-10">
                <div class="relative">
                    <div class="w-32 h-32 rounded-3xl bg-gradient-to-tr from-brand-500 to-purple-500 p-1 shadow-[0_0_40px_rgba(59,130,246,0.3)]">
                        <div class="w-full h-full rounded-[20px] bg-[#050511] flex items-center justify-center overflow-hidden">
                            @if($user->avatar)
                                <img src="{{ $user->avatar }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-4xl font-display font-black text-white">{{ substr($user->name, 0, 1) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="absolute -bottom-2 -right-2 px-3 py-1 bg-brand-500 text-white text-[10px] font-mono font-black uppercase tracking-tighter rounded-full shadow-lg border border-white/20">
                        Level {{ $user->level }}
                    </div>
                </div>

                <div class="text-center md:text-left flex-1">
                    <h1 class="text-4xl md:text-5xl font-display font-black text-white uppercase tracking-tight mb-2">
                        {{ $user->name }}
                    </h1>
                    <div class="flex flex-wrap justify-center md:justify-start gap-4">
                        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/5 border border-white/10 text-brand-400 text-xs font-bold uppercase tracking-widest">
                            <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></span>
                            {{ $user->rank_name }}
                        </span>
                        <span class="text-gray-500 text-sm flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $user->location ?? 'Unknown Node' }}
                        </span>
                    </div>
                </div>

                <div class="flex gap-4">
                    <a href="{{ route('settings') }}" wire:navigate class="px-6 py-3 bg-white/5 hover:bg-white/10 border border-white/10 rounded-2xl text-sm font-bold text-white transition-all">
                        Edit Account
                    </a>
                </div>
            </div>
        </div>

        {{-- Impact Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            {{-- Reputation --}}
            <div class="bg-[#0A0A14]/40 backdrop-blur-xl border border-white/10 rounded-3xl p-6 relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-br from-brand-600/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="text-xs font-mono font-bold text-gray-500 uppercase tracking-widest mb-4">Reputation</div>
                <div class="flex items-end gap-2">
                    <div class="text-4xl font-display font-black text-white">{{ number_format($stats['reputation']) }}</div>
                    <div class="text-brand-400 text-xs font-bold mb-1.5">pts</div>
                </div>
            </div>

            {{-- Contributions --}}
            <div class="bg-[#0A0A14]/40 backdrop-blur-xl border border-white/10 rounded-3xl p-6 relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-600/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="text-xs font-mono font-bold text-gray-500 uppercase tracking-widest mb-4">Edits Approved</div>
                <div class="flex items-end gap-2">
                    <div class="text-4xl font-display font-black text-white">{{ $stats['contributions'] }}</div>
                    <div class="text-purple-400 text-xs font-bold mb-1.5">+{{ $stats['contributions'] * 50 }} xp</div>
                </div>
            </div>

            {{-- Bookmarks --}}
            <div class="bg-[#0A0A14]/40 backdrop-blur-xl border border-white/10 rounded-3xl p-6 relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-br from-pink-600/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="text-xs font-mono font-bold text-gray-500 uppercase tracking-widest mb-4">Saved Records</div>
                <div class="flex items-end gap-2">
                    <div class="text-4xl font-display font-black text-white">{{ $stats['bookmarks'] }}</div>
                    <div class="text-pink-400 text-xs font-bold mb-1.5">tracks</div>
                </div>
            </div>

            {{-- Level Progress --}}
            <div class="bg-[#0A0A14]/40 backdrop-blur-xl border border-white/10 rounded-3xl p-6 relative overflow-hidden group flex flex-col justify-between">
                <div class="text-xs font-mono font-bold text-gray-500 uppercase tracking-widest mb-2">Next Rank</div>
                <div class="w-full bg-white/5 rounded-full h-2 mb-2">
                    <div class="bg-gradient-to-r from-brand-500 to-purple-500 h-full rounded-full" style="width: {{ ($stats['reputation'] % 100) }}%"></div>
                </div>
                <div class="flex justify-between text-[10px] font-bold uppercase tracking-tighter">
                    <span class="text-brand-400">{{ ($stats['reputation'] % 100) }} / 100 XP</span>
                    <span class="text-gray-600">Level {{ $user->level + 1 }}</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Activity Timeline --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-display font-black text-white uppercase tracking-tight">Sonic Timeline</h2>
                    <span class="text-xs text-gray-500 font-mono">Real-time Feed</span>
                </div>

                <div class="space-y-4">
                    @forelse($activities as $act)
                        <div class="flex items-center gap-6 p-4 rounded-2xl bg-white/5 border border-white/5 hover:border-white/10 transition group">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center {{ $act['type'] === 'contribution' ? 'bg-brand-500/10 text-brand-400' : 'bg-pink-500/10 text-pink-400' }}">
                                @if($act['icon'] === 'pencil')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="text-white font-bold text-sm tracking-tight">{{ $act['title'] }}</div>
                                <div class="text-gray-500 text-xs mt-0.5">{{ $act['date']->diffForHumans() }}</div>
                            </div>
                            <div>
                                @if($act['type'] === 'contribution')
                                    <span class="text-[10px] font-black uppercase px-2 py-1 rounded {{ $act['status'] === 'approved' ? 'bg-green-500/20 text-green-400' : ($act['status'] === 'rejected' ? 'bg-red-500/20 text-red-400' : 'bg-yellow-500/20 text-yellow-400') }}">
                                        {{ $act['status'] }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 border-2 border-dashed border-white/5 rounded-[32px]">
                            <p class="text-gray-600 font-bold uppercase tracking-widest text-xs">No activity recorded yet</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Recommendations / Quick Actions --}}
            <div class="space-y-6">
                <h2 class="text-2xl font-display font-black text-white uppercase tracking-tight">Discovery</h2>
                <div class="space-y-4">
                    @foreach($recommendations as $rec)
                        <a href="{{ route('wiki.show', $rec->slug) }}" wire:navigate class="flex items-center gap-4 p-3 rounded-2xl bg-white/5 hover:bg-white/10 transition border border-transparent hover:border-white/10 group">
                            <div class="w-14 h-14 rounded-xl bg-white/10 flex-shrink-0 relative overflow-hidden">
                                @if($rec->featured_image)
                                    <img src="{{ Storage::url($rec->featured_image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-brand-600/20 text-brand-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="overflow-hidden">
                                <div class="text-white font-bold truncate">{{ $rec->title }}</div>
                                <div class="text-gray-500 text-xs uppercase tracking-widest">{{ $rec->category }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- Action Card --}}
                <div class="p-6 rounded-[32px] bg-gradient-to-br from-brand-600 to-purple-700 shadow-xl overflow-hidden relative group">
                    <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
                    <div class="relative z-10 text-center">
                        <div class="text-sm font-bold text-white/80 uppercase tracking-widest mb-4">Start Contributing</div>
                        <h3 class="text-xl font-display font-black text-white uppercase line-tight mb-6">Contribute your knowledge</h3>
                        <a href="{{ route('wiki.create') }}" wire:navigate class="inline-block px-8 py-3 bg-white text-brand-700 font-bold rounded-full hover:scale-105 transition-transform shadow-lg">
                            Add Article
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
