<div class="animate-fade-in relative" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 600)">
    {{-- Background Glows --}}
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute top-1/4 -left-32 w-[600px] h-[600px] bg-blue-500/5 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-1/4 -right-32 w-[600px] h-[600px] bg-purple-500/5 rounded-full blur-[120px]"></div>
    </div>

    {{-- Skeleton Loading State --}}
    <div x-show="!loaded" class="relative z-10 space-y-8">
        {{-- Profile Header Skeleton --}}
        <div class="bg-[#0A0A14]/60 backdrop-blur-2xl border border-white/5 rounded-2xl p-8">
            <div class="flex flex-col md:flex-row items-center gap-8">
                <div class="w-24 h-24 rounded-xl skeleton-v2"></div>
                <div class="flex-1 text-center md:text-left">
                    <div class="h-10 w-48 mb-3 mx-auto md:mx-0 rounded skeleton-v2"></div>
                    <div class="flex flex-wrap justify-center md:justify-start gap-3">
                        <div class="h-6 w-20 rounded-full skeleton-v2"></div>
                        <div class="h-6 w-24 rounded-full skeleton-v2"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Grid Skeleton --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            @for($i = 0; $i < 4; $i++)
            <div class="bg-secondary border border-white/5 rounded-xl p-5 shadow-xl">
                <div class="h-1 w-12 mb-4 rounded skeleton-v2"></div>
                <div class="h-8 w-16 rounded skeleton-v2"></div>
            </div>
            @endfor
        </div>

        {{-- Activity Skeleton --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-4">
                <div class="h-8 w-40 rounded skeleton-v2 mb-4"></div>
                @for($i = 0; $i < 3; $i++)
                <div class="flex items-center gap-4 p-4 rounded-xl bg-white/5 border border-white/5">
                    <div class="w-10 h-10 rounded-lg skeleton-v2"></div>
                    <div class="flex-1">
                        <div class="h-4 w-32 mb-1 rounded skeleton-v2"></div>
                        <div class="h-3 w-16 rounded skeleton-v2"></div>
                    </div>
                </div>
                @endfor
            </div>
            <div class="space-y-4">
                <div class="h-8 w-24 rounded skeleton-v2 mb-4"></div>
                @for($i = 0; $i < 3; $i++)
                <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5">
                    <div class="w-12 h-12 rounded-lg skeleton-v2"></div>
                    <div>
                        <div class="h-4 w-24 mb-1 rounded skeleton-v2"></div>
                        <div class="h-3 w-16 rounded skeleton-v2"></div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>

    {{-- Actual Loaded Content --}}
    <div x-show="loaded" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="relative z-10 space-y-8" style="display: none;">
        {{-- Profile Header Card --}}
        <div class="bg-secondary border border-white/5 rounded-2xl p-8 md:p-12 overflow-hidden relative group shadow-2xl">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-500/5 blur-[100px] -mr-40 -mt-40 transition-all duration-1000 group-hover:bg-blue-500/10"></div>
            
            <div class="flex flex-col md:flex-row items-center gap-10 relative z-10">
                <div class="relative">
                    <div class="w-32 h-32 rounded-2xl p-1 bg-white/5 shadow-2_xl">
                        <div class="w-full h-full rounded-xl bg-primary flex items-center justify-center overflow-hidden">
                            @if($user->avatar)
                                <img src="{{ $user->avatar }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                            @else
                                <span class="text-4xl font-black text-white/5 italic select-none">{{ substr($user->name, 0, 1) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="absolute -bottom-3 left-1/2 -translate-x-1/2 px-4 py-1.5 bg-blue-600 text-white text-[9px] font-black uppercase tracking-[0.2em] rounded-xl shadow-2xl border border-[#050511] shadow-blue-500/20">
                        LVL {{ $user->level }}
                    </div>
                </div>

                <div class="text-center md:text-left flex-1">
                    <div class="mb-4">
                        <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-lg bg-blue-500/5 border border-blue-500/10 text-[8px] font-black text-blue-500 uppercase tracking-[0.2em] mb-3">
                            Authorized Node Identity
                        </div>
                        <h1 class="text-4xl md:text-6xl font-black text-white uppercase italic tracking-tighter mb-2 leading-none">
                            {{ $user->name }}
                        </h1>
                        <div class="flex flex-wrap justify-center md:justify-start gap-3 items-center">
                            <span class="text-white/20 text-[10px] font-black uppercase tracking-[0.3em] flex items-center gap-2">
                                <span class="w-1 h-1 rounded-full bg-blue-500 animate-pulse"></span>
                                {{ $user->rank_name ?? 'ELITE OPERATOR' }}
                            </span>
                            <span class="text-white/10 text-[10px] font-black uppercase tracking-[0.3em] flex items-center gap-2">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                {{ $user->location ?? 'GLOBAL NODE' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('settings') }}" wire:navigate class="px-8 py-3 bg-white/5 hover:bg-white/10 border border-white/5 rounded-xl text-[9px] font-black text-white uppercase tracking-[0.2em] transition-all active:scale-95">
                        CONFIGURATION
                    </a>
                </div>
            </div>
        </div>

        {{-- Impact Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- Reputation --}}
            <div class="bg-secondary border border-white/5 rounded-2xl p-6 relative overflow-hidden group/stat shadow-xl">
                <div class="text-[9px] font-black text-white/5 uppercase tracking-[0.2em] mb-4">Reputation Score</div>
                <div class="flex items-end gap-2">
                    <div class="text-4xl font-black text-white italic tracking-tighter group-hover/stat:text-blue-500 transition-colors">{{ number_format($stats['reputation']) }}</div>
                    <div class="text-blue-500/40 text-[9px] font-black mb-2 uppercase tracking-widest">PTS</div>
                </div>
            </div>

            {{-- Contributions --}}
            <div class="bg-secondary border border-white/5 rounded-2xl p-6 relative overflow-hidden group/stat shadow-xl">
                <div class="text-[9px] font-black text-white/5 uppercase tracking-[0.2em] mb-4">Archive Commits</div>
                <div class="flex items-end gap-2">
                    <div class="text-4xl font-black text-white italic tracking-tighter group-hover/stat:text-blue-500 transition-colors">{{ $stats['contributions'] }}</div>
                    <div class="text-blue-500/40 text-[9px] font-black mb-2 uppercase tracking-widest">NODES</div>
                </div>
            </div>

            {{-- Bookmarks --}}
            <div class="bg-secondary border border-white/5 rounded-2xl p-6 relative overflow-hidden group/stat shadow-xl">
                <div class="text-[9px] font-black text-white/5 uppercase tracking-[0.2em] mb-4">Saved Registry</div>
                <div class="flex items-end gap-2">
                    <div class="text-4xl font-black text-white italic tracking-tighter group-hover/stat:text-blue-500 transition-colors">{{ $stats['bookmarks'] }}</div>
                    <div class="text-blue-500/40 text-[9px] font-black mb-2 uppercase tracking-widest">RECORDS</div>
                </div>
            </div>

            {{-- Level Progress --}}
            <div class="bg-secondary border border-white/5 rounded-2xl p-6 relative overflow-hidden group shadow-xl flex flex-col justify-between">
                <div class="text-[9px] font-black text-white/5 uppercase tracking-[0.2em] mb-2">Sync Progress</div>
                <div class="w-full bg-white/5 rounded-full h-1.5 mb-2 overflow-hidden">
                    <div class="bg-blue-600 h-full rounded-full shadow-lg shadow-blue-500/40 transition-all duration-1000" style="width: {{ ($stats['reputation'] % 100) }}%"></div>
                </div>
                <div class="flex justify-between text-[8px] font-black uppercase tracking-[0.2em]">
                    <span class="text-blue-500">{{ ($stats['reputation'] % 100) }} / 100 XP</span>
                    <span class="text-white/5">NODE LVL {{ $user->level + 1 }}</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Activity Timeline --}}
            <div class="lg:col-span-2 space-y-8">
                <div class="flex items-center justify-between px-1">
                    <h2 class="text-xl font-black text-white uppercase italic tracking-tighter">Contribution Feed</h2>
                    <span class="text-[9px] text-white/10 font-black uppercase tracking-[0.3em] italic">Live Distribution Stream</span>
                </div>

                <div class="space-y-4">
                    @forelse($activities as $act)
                        <div class="flex items-center gap-6 p-6 rounded-2xl bg-secondary border border-white/5 hover:border-blue-500/20 transition-all duration-500 group shadow-xl">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-500 {{ $act['type'] === 'contribution' ? 'bg-blue-500/5 text-blue-500 group-hover:bg-blue-600 group-hover:text-white' : 'bg-blue-500/5 text-blue-500 group-hover:bg-blue-600 group-hover:text-white' }} shadow-lg">
                                @if($act['icon'] === 'pencil')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="text-white font-black text-base tracking-tight group-hover:text-blue-500 transition-colors uppercase italic mb-1">{{ $act['title'] }}</div>
                                <div class="text-white/5 text-[10px] font-black uppercase tracking-[0.3em] italic">{{ $act['date']->diffForHumans() }}</div>
                            </div>
                            <div>
                                @if($act['type'] === 'contribution')
                                    <span class="text-[9px] font-black uppercase px-3 py-1 rounded-lg border {{ $act['status'] === 'approved' ? 'bg-green-500/5 text-green-500 border-green-500/20' : ($act['status'] === 'rejected' ? 'bg-red-500/5 text-red-500 border-red-500/20' : 'bg-yellow-500/5 text-yellow-500 border-yellow-500/20') }}">
                                        {{ $act['status'] }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-20 bg-secondary border border-dashed border-white/5 rounded-2xl shadow-xl">
                            <p class="text-white/5 font-black uppercase tracking-[0.3em] text-[10px] italic">No archive activity detected</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Recommendations / Quick Actions --}}
            <div class="space-y-8">
                <h2 class="text-xl font-black text-white uppercase italic tracking-tighter pb-3 border-b border-white/5">Discovery</h2>
                <div class="space-y-4">
                    @foreach($recommendations as $rec)
                        <a href="{{ route('wiki.show', $rec->slug) }}" wire:navigate class="flex items-center gap-5 p-4 rounded-2xl bg-secondary hover:border-blue-500/20 transition-all duration-500 border border-white/5 group shadow-xl">
                            <div class="w-14 h-14 rounded-xl bg-white/5 flex-shrink-0 relative overflow-hidden shadow-lg">
                                @if($rec->featured_image)
                                    <img src="{{ Storage::url($rec->featured_image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-blue-500/5 text-blue-500">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="overflow-hidden">
                                <div class="text-white font-black text-[13px] truncate group-hover:text-blue-500 transition-colors uppercase italic tracking-tight mb-1">{{ $rec->title }}</div>
                                <div class="text-white/10 text-[9px] font-black uppercase tracking-[0.2em] italic">{{ $rec->category }} Protocol</div>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- Action Card --}}
                <div class="p-8 rounded-2xl bg-blue-600 shadow-2xl overflow-hidden relative group shadow-blue-500/10">
                    {{-- Decorative Circle --}}
                    <div class="absolute -right-16 -top-16 w-48 h-48 bg-white/10 rounded-full blur-3xl transition-all duration-1000 group-hover:scale-150"></div>
                    
                    <div class="relative z-10 text-center">
                        <div class="text-[10px] font-black text-white/40 uppercase tracking-[0.3em] mb-4 italic">Registry Protocol</div>
                        <h3 class="text-xl font-black text-white uppercase italic tracking-tighter mb-8 leading-tight">INITIALIZE NEW ARCHIVE NODES</h3>
                        <a href="{{ route('wiki.create') }}" wire:navigate class="inline-block px-10 py-4 bg-white text-blue-900 text-[10px] font-black uppercase tracking-[0.2em] rounded-xl hover:scale-105 transition-all shadow-2xl active:scale-95">
                            START SESSION
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
