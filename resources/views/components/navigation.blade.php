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
            <a href="{{ route('home') }}" wire:navigate class="group">
                <span class="text-2xl font-black text-white uppercase tracking-tight transition-colors" style="font-family: 'Plus Jakarta Sans', sans-serif;">CHAYNWIKI</span>
            </a>

            {{-- Center: Search (Desktop) --}}
            <div class="hidden md:flex flex-1 max-w-sm mx-12">
                @livewire('header-search')
            </div>

            {{-- Right: Nav + Actions --}}
            <div class="flex items-center gap-2">
                {{-- Navigation Links (Desktop) - Direct category links like Figma --}}
                <nav class="hidden lg:flex items-center gap-1">
                    <a href="{{ route('wiki.index') }}?category=artist" class="px-5 py-2 text-[14px] font-bold text-white/50 hover:text-white transition-colors">Artists</a>
                    <a href="{{ route('wiki.index') }}?category=genre" class="px-5 py-2 text-[14px] font-bold text-white/50 hover:text-white transition-colors">Genres</a>
                    <a href="{{ route('wiki.index') }}?category=song" class="px-5 py-2 text-[14px] font-bold text-white/50 hover:text-white transition-colors">Lyrics</a>
                    <a href="{{ route('wiki.index') }}?category=playlist" class="px-5 py-2 text-[14px] font-bold text-white/50 hover:text-white transition-colors">Playlists</a>
                </nav>

                {{-- Avatar/Auth --}}
                @if (Route::has('login'))
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="w-9 h-9 rounded-full overflow-hidden ring-1 ring-white/10 hover:ring-white/30 transition-all">
                                <div class="w-full h-full bg-[#3b82f6] flex items-center justify-center text-white font-bold text-[12px]">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            </button>
                            
                            {{-- Dropdown - Unified Surface --}}
                            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" 
                                class="absolute right-0 mt-3 w-56 bg-[#161b22] border border-white/5 rounded-2xl shadow-2xl overflow-hidden" style="display: none;">
                                
                                {{-- User Info --}}
                                <div class="p-4 border-b border-white/5">
                                    <div class="font-bold text-white text-[14px]">{{ auth()->user()->name }}</div>
                                    <div class="text-[12px] text-white/40 truncate">{{ auth()->user()->email }}</div>
                                </div>
                                
                                {{-- Menu --}}
                                <div class="p-2">
                                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-[13px] text-white/60 hover:text-white hover:bg-white/5 rounded-xl transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                        Dashboard
                                    </a>
                                    <a href="{{ route('profile', auth()->user()) }}" class="flex items-center gap-3 px-3 py-2.5 text-[13px] text-white/60 hover:text-white hover:bg-white/5 rounded-xl transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        Profile
                                    </a>
                                    <a href="{{ route('wiki.create') }}" class="flex items-center gap-3 px-3 py-2.5 text-[13px] text-white/60 hover:text-white hover:bg-white/5 rounded-xl transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Create Article
                                    </a>
                                </div>
                                
                                {{-- Logout --}}
                                <div class="p-2 border-t border-white/5">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-3 w-full px-3 py-2.5 text-[13px] text-red-400 hover:bg-red-400/5 rounded-xl transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                            Sign out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="w-9 h-9 rounded-full overflow-hidden ring-1 ring-white/10 hover:ring-white/30 transition-all">
                            <div class="w-full h-full bg-[#3b82f6] flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        </a>
                    @endauth
                @endif

                {{-- Mobile Menu Button --}}
                <button @click="mobileOpen = !mobileOpen" class="lg:hidden ml-2 w-9 h-9 flex items-center justify-center text-white hover:bg-white/5 rounded-xl transition-all">
                    <svg x-show="!mobileOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" 
        class="lg:hidden absolute top-full left-0 right-0 bg-[#0d1117]/98 backdrop-blur-xl border-b border-white/5" style="display: none;">
        <div class="max-w-[1200px] mx-auto px-6 py-8 space-y-4">
            {{-- Mobile Search --}}
            <div class="mb-4">
                @livewire('header-search')
            </div>
            
            {{-- Mobile Nav Links --}}
            <a href="{{ route('wiki.index') }}?category=artist" class="block px-4 py-3 text-[14px] font-bold text-white/50 hover:text-white uppercase tracking-widest transition-all">Artists</a>
            <a href="{{ route('wiki.index') }}?category=genre" class="block px-4 py-3 text-[14px] font-bold text-white/50 hover:text-white uppercase tracking-widest transition-all">Genres</a>
            <a href="{{ route('wiki.index') }}?category=song" class="block px-4 py-3 text-[14px] font-bold text-white/50 hover:text-white uppercase tracking-widest transition-all">Lyrics</a>
            <a href="{{ route('wiki.index') }}?category=playlist" class="block px-4 py-3 text-[14px] font-bold text-white/50 hover:text-white uppercase tracking-widest transition-all">Playlists</a>
            
            {{-- Mobile Create Button --}}
            <a href="{{ route('wiki.create') }}" class="flex items-center justify-center gap-2 mt-4 px-6 py-4 bg-white text-[#0d1117] text-[14px] font-black uppercase tracking-tighter rounded-full transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Create New Topic
            </a>
        </div>
    </div>
</header>
