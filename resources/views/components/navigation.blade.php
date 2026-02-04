{{-- 
    CHAYNWIKI Navigation Header V2
    Ocean Depth Theme - Premium glassmorphism styling
--}}

<header class="fixed top-0 left-0 right-0 z-50" x-data="{ scrolled: false, mobileOpen: false }" 
    @scroll.window="scrolled = window.scrollY > 20">
    
    {{-- Glassmorphism Background - Ocean Depth --}}
    <div class="absolute inset-0 transition-all duration-300"
        :class="scrolled ? 'bg-[#0a0e14]/95 backdrop-blur-xl border-b border-[#38bdf8]/10' : 'bg-transparent'">
    </div>
    
    <div class="relative max-w-[1200px] mx-auto px-6 lg:px-8">
        <div class="h-20 flex items-center justify-between">
            
            {{-- Left: Logo --}}
            <a href="{{ route('home') }}" wire:navigate class="group">
                <span class="text-2xl font-black text-white uppercase tracking-tight group-hover:text-[#38bdf8] transition-colors">CHAYNWIKI</span>
            </a>

            {{-- Center: Search (Desktop) --}}
            <div class="hidden md:flex flex-1 max-w-sm mx-12">
                @livewire('header-search')
            </div>

            {{-- Right: Nav + Actions --}}
            <div class="flex items-center gap-2">
                {{-- Navigation Links (Desktop) --}}
                <nav class="hidden lg:flex items-center gap-2">
                    <a href="{{ route('wiki.index') }}" class="px-4 py-2 text-[10px] font-black text-white/60 uppercase tracking-[0.2em] hover:text-white hover:bg-[#38bdf8]/10 rounded-xl transition-all">Browse</a>
                    
                    {{-- More Dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button 
                            @click="open = !open"
                            @click.away="open = false"
                            class="flex items-center gap-2 px-4 py-2 text-[10px] font-black text-white/60 uppercase tracking-[0.2em] hover:text-white hover:bg-[#38bdf8]/10 rounded-xl transition-all"
                            :class="{ 'text-white bg-[#38bdf8]/10': open }"
                        >
                            More
                            <svg class="w-3.5 h-3.5 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        {{-- Mega Dropdown Panel - Ocean Depth --}}
                        <div 
                            x-show="open"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-2"
                            class="absolute right-0 mt-3 w-80 bg-[#0f1419] border border-[#38bdf8]/10 rounded-2xl shadow-2xl overflow-hidden"
                            style="display: none;"
                        >
                            <div class="grid grid-cols-2 gap-0">
                                {{-- Browse Section --}}
                                <div class="p-5 border-r border-[#38bdf8]/10">
                                    <h3 class="text-[10px] font-bold text-[#64748b] uppercase tracking-widest mb-3">Browse</h3>
                                    <div class="space-y-1">
                                        <a href="{{ route('wiki.index') }}?category=artist" @click="open = false" class="flex items-center gap-3 px-3 py-2.5 text-[13px] text-gray-400 hover:text-white hover:bg-[#38bdf8]/[0.08] rounded-lg transition-all">
                                            <svg class="w-4 h-4 text-[#a78bfa]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                            Artists
                                        </a>
                                        <a href="{{ route('wiki.index') }}?category=genre" @click="open = false" class="flex items-center gap-3 px-3 py-2.5 text-[13px] text-gray-400 hover:text-white hover:bg-[#38bdf8]/[0.08] rounded-lg transition-all">
                                            <svg class="w-4 h-4 text-[#2dd4bf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                                            Genres
                                        </a>
                                        <a href="{{ route('wiki.index') }}?category=song" @click="open = false" class="flex items-center gap-3 px-3 py-2.5 text-[13px] text-gray-400 hover:text-white hover:bg-[#38bdf8]/[0.08] rounded-lg transition-all">
                                            <svg class="w-4 h-4 text-[#38bdf8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                            Songs & Lyrics
                                        </a>
                                        <a href="{{ route('wiki.index') }}?category=playlist" @click="open = false" class="flex items-center gap-3 px-3 py-2.5 text-[13px] text-gray-400 hover:text-white hover:bg-[#38bdf8]/[0.08] rounded-lg transition-all">
                                            <svg class="w-4 h-4 text-[#f472b6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                            Playlists
                                        </a>
                                    </div>
                                </div>
                                
                                {{-- Tools & Community Section --}}
                                <div class="p-5">
                                    <h3 class="text-[10px] font-bold text-[#64748b] uppercase tracking-widest mb-3">Discover</h3>
                                    <div class="space-y-1">
                                        <a href="{{ route('explore') }}" @click="open = false" class="flex items-center gap-3 px-3 py-2.5 text-[13px] text-gray-400 hover:text-white hover:bg-[#38bdf8]/[0.08] rounded-lg transition-all">
                                            <svg class="w-4 h-4 text-[#2dd4bf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                                            Knowledge Explorer
                                        </a>
                                        <a href="{{ route('leaderboard') }}" @click="open = false" class="flex items-center gap-3 px-3 py-2.5 text-[13px] text-gray-400 hover:text-white hover:bg-[#38bdf8]/[0.08] rounded-lg transition-all">
                                            <svg class="w-4 h-4 text-[#fb923c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                            Rankings
                                        </a>
                                    </div>
                                    
                                    <h3 class="text-[10px] font-bold text-[#64748b] uppercase tracking-widest mb-3 mt-5">Tools</h3>
                                    <div class="space-y-1">
                                        <a href="{{ route('wiki.generate') }}" @click="open = false" class="flex items-center gap-3 px-3 py-2.5 text-[13px] text-gray-400 hover:text-white hover:bg-[#38bdf8]/[0.08] rounded-lg transition-all">
                                            <svg class="w-4 h-4 text-[#fb923c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                            AI Generator
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Bottom Bar --}}
                            <div class="px-5 py-3 bg-[#38bdf8]/[0.03] border-t border-[#38bdf8]/10">
                                <a href="{{ route('search') }}" @click="open = false" class="flex items-center justify-center gap-2 text-[12px] text-[#38bdf8] hover:text-[#7dd3fc] transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                    Search Everything
                                </a>
                            </div>
                        </div>
                    </div>
                </nav>

                {{-- Divider --}}
                <div class="hidden lg:block w-px h-6 bg-[#38bdf8]/15 mx-2"></div>

                {{-- Create Button - Ocean Depth --}}
                <a href="{{ route('wiki.create') }}" class="hidden sm:flex items-center gap-2 px-5 py-2 bg-gradient-to-r from-[#38bdf8] to-[#0ea5e9] hover:from-[#7dd3fc] hover:to-[#38bdf8] text-[#0a0e14] text-[9px] font-black uppercase tracking-widest rounded-xl transition-all shadow-lg shadow-[#38bdf8]/20">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span class="hidden md:inline">Create</span>
                </a>

                {{-- Avatar/Auth --}}
                @if (Route::has('login'))
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="w-9 h-9 rounded-full overflow-hidden ring-2 ring-[#38bdf8]/20 hover:ring-[#38bdf8]/50 transition-all">
                                <div class="w-full h-full bg-gradient-to-br from-[#f472b6] to-[#fb923c] flex items-center justify-center text-white font-bold text-[12px]">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            </button>
                            
                            {{-- Dropdown - Ocean Depth --}}
                            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" 
                                class="absolute right-0 mt-3 w-56 bg-[#0f1419] border border-[#38bdf8]/10 rounded-xl shadow-2xl overflow-hidden" style="display: none;">
                                
                                {{-- User Info --}}
                                <div class="p-4 border-b border-[#38bdf8]/10">
                                    <div class="font-semibold text-white text-[14px]">{{ auth()->user()->name }}</div>
                                    <div class="text-[12px] text-[#64748b] truncate">{{ auth()->user()->email }}</div>
                                </div>
                                
                                {{-- Menu --}}
                                <div class="p-2">
                                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-[13px] text-gray-400 hover:text-white hover:bg-[#38bdf8]/[0.08] rounded-lg transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                        Dashboard
                                    </a>
                                    <a href="{{ route('profile', auth()->user()) }}" class="flex items-center gap-3 px-3 py-2.5 text-[13px] text-gray-400 hover:text-white hover:bg-[#38bdf8]/[0.08] rounded-lg transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        Profile
                                    </a>
                                    <a href="{{ route('wiki.create') }}" class="flex items-center gap-3 px-3 py-2.5 text-[13px] text-gray-400 hover:text-white hover:bg-[#38bdf8]/[0.08] rounded-lg transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Create Article
                                    </a>
                                </div>
                                
                                {{-- Logout --}}
                                <div class="p-2 border-t border-[#38bdf8]/10">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-3 w-full px-3 py-2.5 text-[13px] text-[#f472b6] hover:bg-[#f472b6]/10 rounded-lg transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                            Sign out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="w-9 h-9 rounded-full overflow-hidden ring-2 ring-[#38bdf8]/20 hover:ring-[#38bdf8]/50 transition-all">
                            <div class="w-full h-full bg-gradient-to-br from-[#38bdf8] to-[#a78bfa] flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        </a>
                    @endauth
                @endif

                {{-- Mobile Menu Button --}}
                <button @click="mobileOpen = !mobileOpen" class="lg:hidden ml-2 w-9 h-9 flex items-center justify-center text-white hover:bg-[#38bdf8]/[0.08] rounded-lg transition-all">
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

    {{-- Mobile Menu - Ocean Depth --}}
    <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" 
        class="lg:hidden absolute top-full left-0 right-0 bg-[#0a0e14]/98 backdrop-blur-xl border-b border-[#38bdf8]/10" style="display: none;">
        <div class="max-w-[1200px] mx-auto px-6 py-4 space-y-2">
            {{-- Mobile Search --}}
            <div class="mb-4">
                @livewire('header-search')
            </div>
            
            {{-- Mobile Nav Links --}}
            <a href="{{ route('wiki.index') }}?category=artist" class="block px-4 py-3 text-[14px] text-gray-400 hover:text-white hover:bg-[#38bdf8]/[0.08] rounded-lg transition-all">Artists</a>
            <a href="{{ route('wiki.index') }}?category=genre" class="block px-4 py-3 text-[14px] text-gray-400 hover:text-white hover:bg-[#38bdf8]/[0.08] rounded-lg transition-all">Genres</a>
            <a href="{{ route('wiki.index') }}?category=song" class="block px-4 py-3 text-[14px] text-gray-400 hover:text-white hover:bg-[#38bdf8]/[0.08] rounded-lg transition-all">Lyrics</a>
            <a href="{{ route('wiki.index') }}?category=playlist" class="block px-4 py-3 text-[14px] text-gray-400 hover:text-white hover:bg-[#38bdf8]/[0.08] rounded-lg transition-all">Playlists</a>
            
            {{-- Mobile Create Button --}}
            <a href="{{ route('wiki.create') }}" class="flex items-center justify-center gap-2 mt-4 px-4 py-3 bg-gradient-to-r from-[#38bdf8] to-[#0ea5e9] hover:from-[#7dd3fc] hover:to-[#38bdf8] text-[#0a0e14] text-[14px] font-medium rounded-full transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Create New Topic
            </a>
        </div>
    </div>
</header>
