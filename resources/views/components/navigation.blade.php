<header class="relative z-50 border-b border-white/10 bg-[#050511]/90 backdrop-blur-xl sticky top-0" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex justify-between items-center">
        <div class="flex items-center gap-12">
            <a href="/" class="text-2xl font-display font-black tracking-widest text-white uppercase flex items-center gap-2">
                CHAYNWIKI
            </a>
            
            <!-- Minimal Header Search (Desktop) - Figma Pill Style -->
            <form action="{{ route('search') }}" method="GET" class="hidden lg:flex items-center bg-[#11111a] border border-white/5 rounded-full px-4 py-1.5 w-80 focus-within:border-brand-500/50 transition-all duration-300">
                <input type="text" name="q" placeholder="Search" class="bg-transparent border-none text-[10px] text-gray-500 placeholder-gray-600 focus:ring-0 w-full p-0 leading-5 font-bold uppercase tracking-[0.2em]">
                <button type="submit" class="w-7 h-7 bg-brand-600 rounded-full text-white flex items-center justify-center hover:bg-brand-500 transition-colors shadow-lg ml-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </form>
        </div>

        <!-- Desktop Nav -->
        <div class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-400">
            <a href="{{ route('wiki.index', ['category' => 'artist']) }}" class="hover:text-white transition">Artists</a>
            <a href="{{ route('wiki.index', ['category' => 'genre']) }}" class="hover:text-white transition">Genres</a>
            <a href="{{ route('wiki.index', ['category' => 'song']) }}" class="hover:text-white transition">Lyrics</a>
            <a href="{{ route('wiki.index', ['category' => 'playlist']) }}" class="hover:text-white transition">Playlist</a>
            
            @if (Route::has('login'))
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="w-9 h-9 rounded-full overflow-hidden border-2 border-white/10 hover:border-brand-500/50 transition">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random" class="w-full h-full object-cover">
                        </button>
                         <div x-show="open" @click.away="open = false" 
                            class="absolute right-0 mt-3 w-56 bg-[#0A0A14] border border-white/10 rounded-xl shadow-2xl py-2 z-50 backdrop-blur-xl transform origin-top-right transition-all duration-200"
                            style="display: none;">
                            <div class="px-4 py-3 border-b border-white/5 mb-1">
                                <p class="text-sm text-white font-medium">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-brand-400 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/5 hover:text-white transition-colors">Dashboard</a>
                            @if(auth()->user()->isModerator())
                                <a href="/admin" class="block px-4 py-2 text-sm text-brand-400 hover:bg-white/5 transition-colors">Admin Panel</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-red-500/10 transition-colors">Log Out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition">Log in</a>
                @endauth
            @endif
        </div>

        <!-- Mobile Menu Button -->
        <div class="md:hidden flex items-center">
             @if (Route::has('login'))
                @auth
                    <div class="mr-4 text-white font-bold w-8 h-8 bg-brand-600 rounded-full flex items-center justify-center">{{ substr(auth()->user()->name, 0, 1) }}</div>
                @endauth
            @endif
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-400 hover:text-white p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" 
         class="md:hidden absolute top-20 left-0 right-0 bg-[#050511]/98 border-b border-white/10 backdrop-blur-2xl shadow-[0_20px_40px_rgba(0,0,0,0.8)] z-40"
         x-transition:enter="transition cubic-bezier(0.4, 0, 0.2, 1) duration-500"
         x-transition:enter-start="opacity-0 -translate-y-8"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition cubic-bezier(0.4, 0, 0.2, 1) duration-400"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-8"
         style="display: none;">
        <div class="px-4 pt-2 pb-6 space-y-4">
            <a href="{{ route('wiki.index', ['category' => 'artist']) }}" class="block text-gray-400 hover:text-white transition py-2">Artist</a>
            <a href="{{ route('wiki.index', ['category' => 'genre']) }}" class="block text-gray-400 hover:text-white transition py-2">Genre</a>
            <a href="{{ route('wiki.index', ['category' => 'song']) }}" class="block text-gray-400 hover:text-white transition py-2">Song</a>
            <a href="{{ route('wiki.index', ['category' => 'playlist']) }}" class="block text-gray-400 hover:text-white transition py-2">Playlist</a>
            @guest
                <a href="{{ route('login') }}" class="block w-full py-3 text-center bg-brand-600 rounded-xl text-white font-bold">Log in</a>
            @endguest
        </div>
    </div>
</header>
