{{-- 
    CHAYNWIKI Navigation Header V2
    Ocean Depth Theme - Premium glassmorphism styling
--}}

<header class="fixed top-0 left-0 right-0 z-50" x-data="{ scrolled: false, mobileOpen: false }" 
    @scroll.window="scrolled = window.scrollY > 20">
    
    {{-- Background with always-visible border --}}
    <div class="absolute inset-0 transition-all duration-300 border-b border-white/5"
        :class="scrolled ? 'bg-[#0d1117]/95 backdrop-blur-xl' : 'bg-[#0d1117]'">
    </div>
    
    <div class="relative max-w-[1400px] mx-auto px-8">
        <div class="h-20 flex items-center justify-between">
            
            {{-- Left: Logo --}}
            <a href="{{ route('home') }}" wire:navigate class="group transition-transform active:scale-95">
                <span class="text-[22px] font-black text-white uppercase tracking-tighter leading-none" 
                    style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    CHAYN<span class="text-blue-500">WIKI</span>
                </span>
            </a>

            {{-- Center: Search (Desktop) --}}
            <div class="hidden md:flex flex-1 max-w-[400px] mx-8">
                @livewire('header-search')
            </div>

            {{-- Right: Nav + Actions --}}
            <div class="flex items-center gap-6">
                {{-- Navigation Links (Desktop) --}}
                <nav class="hidden lg:flex items-center gap-1">
                    <a href="{{ route('wiki.index') }}?category=artist" class="px-4 py-2 text-[13px] font-extrabold text-white/50 hover:text-white uppercase tracking-widest transition-all">Artists</a>
                    <a href="{{ route('wiki.index') }}?category=genre" class="px-4 py-2 text-[13px] font-extrabold text-white/50 hover:text-white uppercase tracking-widest transition-all">Genres</a>
                    <a href="{{ route('wiki.index') }}?category=song" class="px-4 py-2 text-[13px] font-extrabold text-white/50 hover:text-white uppercase tracking-widest transition-all">Lyrics</a>
                    <a href="{{ route('wiki.index') }}?category=playlist" class="px-4 py-2 text-[13px] font-extrabold text-white/50 hover:text-white uppercase tracking-widest transition-all">Playlists</a>
                </nav>

                <div class="h-6 w-px bg-white/10 hidden lg:block"></div>

                {{-- Avatar/Auth Unified --}}
                <div class="relative" x-data="{ open: false }">
                    @auth
                        <button @click="open = !open" 
                            class="flex items-center gap-3 p-1 rounded-full bg-white/5 border border-white/10 hover:border-blue-500/50 transition-all group shadow-2xl">
                            <div class="w-9 h-9 rounded-full overflow-hidden flex items-center justify-center bg-gradient-to-br from-blue-500 to-blue-700 text-white font-black text-[11px] shadow-lg group-hover:scale-105 transition-transform">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <svg class="w-4 h-4 text-white/30 group-hover:text-white transition-colors mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        
                        {{-- Dropdown - Ultra Premium --}}
                        <div x-show="open" @click.away="open = false" 
                            x-transition:enter="transition ease-out duration-200" 
                            x-transition:enter-start="opacity-0 scale-95 translate-y-2" 
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0" 
                            x-transition:leave="transition ease-in duration-150" 
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0" 
                            x-transition:leave-end="opacity-0 scale-95 translate-y-2" 
                            class="absolute right-0 mt-3 w-72 glass-card !bg-[#161b22]/95 backdrop-blur-2xl rounded-2xl shadow-3xl overflow-hidden z-[60] border border-white/5" style="display: none;">
                            
                            {{-- User Info --}}
                            <div class="p-6 bg-white/[0.02] border-b border-white/5">
                                <div class="font-black text-white text-[16px] uppercase tracking-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ auth()->user()->name }}</div>
                                <div class="text-[10px] text-blue-500 font-black uppercase tracking-[0.3em] mt-1.5">{{ auth()->user()->username ?? 'ACCESS_LEVEL_CONTRIBUTOR' }}</div>
                            </div>
                            
                            {{-- Menu Items --}}
                            <div class="p-2 space-y-1">
                                <a href="{{ route('dashboard') }}" class="flex items-center gap-4 px-4 py-3.5 text-[12px] font-black uppercase tracking-widest text-white/50 hover:text-white hover:bg-white/5 rounded-xl transition-all group">
                                    <div class="w-9 h-9 rounded-lg bg-white/5 flex items-center justify-center group-hover:bg-blue-500/10 transition-colors border border-transparent group-hover:border-blue-500/20">
                                        <svg class="w-4 h-4 text-white/40 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                    </div>
                                    <span>Terminal</span>
                                </a>
                                <a href="{{ route('profile', ['username' => auth()->user()->username]) }}" class="flex items-center gap-4 px-4 py-3.5 text-[12px] font-black uppercase tracking-widest text-white/50 hover:text-white hover:bg-white/5 rounded-xl transition-all group">
                                    <div class="w-9 h-9 rounded-lg bg-white/5 flex items-center justify-center group-hover:bg-blue-500/10 transition-colors border border-transparent group-hover:border-blue-500/20">
                                        <svg class="w-4 h-4 text-white/40 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    </div>
                                    <span>Node Profile</span>
                                </a>
                                <a href="{{ route('wiki.create') }}" class="flex items-center gap-4 px-4 py-3.5 text-[12px] font-black uppercase tracking-widest text-white/50 hover:text-white hover:bg-white/5 rounded-xl transition-all group">
                                    <div class="w-9 h-9 rounded-lg bg-blue-500/10 flex items-center justify-center group-hover:bg-blue-500 transition-colors border border-blue-500/20">
                                        <svg class="w-4 h-4 text-blue-500 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                                    </div>
                                    <span class="text-blue-500 group-hover:text-white transition-colors">Submit Data</span>
                                </a>
                            </div>
                            
                            {{-- Logout --}}
                            <div class="p-2 border-t border-white/5">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-4 w-full px-4 py-3.5 text-[12px] font-black uppercase tracking-widest text-red-500/60 hover:text-red-500 hover:bg-red-500/5 rounded-xl transition-all group">
                                        <div class="w-9 h-9 rounded-lg bg-red-500/5 flex items-center justify-center group-hover:bg-red-500/10 transition-colors border border-transparent group-hover:border-red-500/20">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        </div>
                                        <span>Log Out</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" 
                            class="flex items-center justify-center w-10 h-10 rounded-full bg-white/5 border border-white/10 hover:border-blue-500/50 hover:bg-blue-500/10 transition-all group shadow-2xl relative overflow-hidden">
                            <div class="absolute inset-0 bg-blue-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <svg class="w-5 h-5 text-white/40 group-hover:text-blue-500 transition-all group-hover:scale-110 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </a>
                    @endauth
                </div>

                {{-- Mobile Menu Button --}}
                <button @click="mobileOpen = !mobileOpen" class="lg:hidden w-10 h-10 flex items-center justify-center text-white bg-white/5 border border-white/10 rounded-xl transition-all active:scale-90">
                    <svg x-show="!mobileOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" 
        class="lg:hidden absolute top-full left-0 right-0 bg-[#0d1117]/98 backdrop-blur-3xl border-b border-white/5 shadow-2xl overflow-hidden" style="display: none;">
        <div class="max-w-[1400px] mx-auto px-8 py-10 space-y-6">
            {{-- Mobile Search --}}
            <div class="mb-2">
                @livewire('header-search')
            </div>
            
            {{-- Mobile Nav Links --}}
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('wiki.index') }}?category=artist" class="flex flex-col gap-1 p-5 rounded-2xl bg-white/5 border border-white/5 hover:bg-white/10 transition-all group">
                    <span class="text-[13px] font-black text-white uppercase tracking-widest group-hover:text-blue-500 transition-colors">Artists</span>
                    <span class="text-[9px] text-white/20 font-black uppercase tracking-widest group-hover:text-blue-500/40 transition-colors">Node Archive</span>
                </a>
                <a href="{{ route('wiki.index') }}?category=genre" class="flex flex-col gap-1 p-5 rounded-2xl bg-white/5 border border-white/5 hover:bg-white/10 transition-all group">
                    <span class="text-[13px] font-black text-white uppercase tracking-widest group-hover:text-blue-500 transition-colors">Genres</span>
                    <span class="text-[9px] text-white/20 font-black uppercase tracking-widest group-hover:text-blue-500/40 transition-colors">Spectrum Scan</span>
                </a>
                <a href="{{ route('wiki.index') }}?category=song" class="flex flex-col gap-1 p-5 rounded-2xl bg-white/5 border border-white/5 hover:bg-white/10 transition-all group">
                    <span class="text-[13px] font-black text-white uppercase tracking-widest group-hover:text-blue-500 transition-colors">Lyrics</span>
                    <span class="text-[9px] text-white/20 font-black uppercase tracking-widest group-hover:text-blue-500/40 transition-colors">Signal Logic</span>
                </a>
                <a href="{{ route('wiki.index') }}?category=playlist" class="flex flex-col gap-1 p-5 rounded-2xl bg-white/5 border border-white/5 hover:bg-white/10 transition-all group">
                    <span class="text-[13px] font-black text-white uppercase tracking-widest group-hover:text-blue-500 transition-colors">Playlists</span>
                    <span class="text-[9px] text-white/20 font-black uppercase tracking-widest group-hover:text-blue-500/40 transition-colors">Compiled Data</span>
                </a>
            </div>
            
            {{-- Mobile Auth Actions --}}
            <div class="pt-6 border-t border-white/5 space-y-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-figma-primary w-full text-center py-4">
                        ENTER TERMINAL
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-center py-4 text-[11px] font-black text-red-500/60 uppercase tracking-[0.3em] hover:text-red-500 transition-colors">
                            TERMINATE SESSION
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-figma-primary w-full text-center py-4">
                        AUTHORIZE ACCESS
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>
