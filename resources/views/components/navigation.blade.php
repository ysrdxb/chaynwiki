<header class="fixed top-0 left-0 right-0 z-50" x-data="{ mobileMenuOpen: false, scrolled: false }" 
    @scroll.window="scrolled = window.scrollY > 50">
    <!-- Glassmorphism navbar -->
    <div class="transition-all duration-500" 
        :class="scrolled ? 'bg-[#030308]/90 backdrop-blur-2xl border-b border-white/10 shadow-2xl shadow-black/20' : 'bg-transparent'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center gap-10">
                <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-3 group">
                    <div class="relative">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-purple-600 flex items-center justify-center shadow-lg shadow-brand-500/30 group-hover:shadow-brand-500/50 transition-all group-hover:scale-105">
                            <span class="text-white font-bold text-lg">C</span>
                        </div>
                        <div class="absolute -inset-1 bg-gradient-to-br from-brand-500 to-purple-600 rounded-xl blur opacity-30 group-hover:opacity-50 transition-opacity"></div>
                    </div>
                    <span class="text-xl font-display font-black text-white tracking-tight">ChaynWiki</span>
                </a>
                
                <!-- Desktop Nav Links -->
                <nav class="hidden lg:flex items-center gap-1">
                    @php
                        $navLinks = [
                            ['label' => 'Browse', 'route' => 'wiki.index', 'icon' => '📚'],
                            ['label' => 'Explore', 'route' => 'explore', 'icon' => '🌐'],
                            ['label' => 'Leaderboard', 'route' => 'leaderboard', 'icon' => '🏆'],
                            ['label' => 'AI Tools', 'route' => 'wiki.generate', 'icon' => '🤖'],
                        ];
                    @endphp
                    @foreach($navLinks as $link)
                        <a href="{{ route($link['route']) }}" wire:navigate 
                            class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium text-gray-400 hover:text-white hover:bg-white/5 transition-all {{ request()->routeIs($link['route']) ? 'text-white bg-white/10' : '' }}">
                            <span class="text-base">{{ $link['icon'] }}</span>
                            <span>{{ $link['label'] }}</span>
                        </a>
                    @endforeach
                </nav>
            </div>

            <!-- Right side -->
            <div class="flex items-center gap-4">
                <!-- Search (Desktop) -->
                <form action="{{ route('search') }}" method="GET" class="hidden lg:flex items-center relative group">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-brand-500/50 to-purple-500/50 rounded-xl blur opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative flex items-center bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 focus-within:border-brand-500/50 focus-within:bg-white/10 transition-all w-64">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" name="q" placeholder="Search..." 
                            class="bg-transparent !border-none !outline-none !shadow-none !ring-0 text-sm text-white placeholder-gray-500 w-full px-3">
                    </div>
                </form>

                @if (Route::has('login'))
                    @auth
                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" 
                                class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/5 transition-all group">
                                <div class="relative">
                                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-brand-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                    <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-[#030308]"></div>
                                </div>
                                <div class="hidden md:block text-left">
                                    <div class="text-sm font-medium text-white">{{ auth()->user()->name }}</div>
                                    <div class="text-xs text-gray-500">{{ auth()->user()->points ?? 0 }} pts</div>
                                </div>
                                <svg class="w-4 h-4 text-gray-500 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            
                            <!-- Dropdown -->
                            <div x-show="open" @click.away="open = false" 
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                                class="absolute right-0 mt-3 w-64 bg-[#0A0A14]/95 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl overflow-hidden z-50"
                                style="display: none;">
                                
                                <!-- User Info -->
                                <div class="p-4 border-b border-white/10 bg-gradient-to-r from-brand-500/10 to-purple-500/10">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-brand-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="text-white font-semibold">{{ auth()->user()->name }}</div>
                                            <div class="text-xs text-brand-400">{{ auth()->user()->email }}</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="p-2">
                                    <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-300 hover:bg-white/5 hover:text-white transition-all">
                                        <span class="text-lg">📊</span>
                                        <span class="text-sm">Dashboard</span>
                                    </a>
                                    <a href="{{ route('profile', auth()->user()) }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-300 hover:bg-white/5 hover:text-white transition-all">
                                        <span class="text-lg">👤</span>
                                        <span class="text-sm">Profile</span>
                                    </a>
                                    @if(auth()->user()->isModerator())
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-brand-400 hover:bg-brand-500/10 transition-all">
                                            <span class="text-lg">⚙️</span>
                                            <span class="text-sm">Admin Panel</span>
                                        </a>
                                    @endif
                                </div>
                                
                                <div class="p-2 border-t border-white/10">
                                    <a href="{{ route('logout') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-red-400 hover:bg-red-500/10 w-full transition-all">
                                        <span class="text-lg">🚪</span>
                                        <span class="text-sm">Log Out</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" wire:navigate class="hidden md:flex items-center gap-2 px-4 py-2 text-gray-400 hover:text-white transition-colors text-sm font-medium">
                            Log in
                        </a>
                        <a href="{{ route('register') }}" wire:navigate class="hidden md:flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-brand-600 to-brand-500 hover:from-brand-500 hover:to-brand-400 text-white font-semibold rounded-xl transition-all hover:shadow-lg hover:shadow-brand-500/25 text-sm">
                            Get Started
                        </a>
                    @endauth
                @endif

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 rounded-xl text-gray-400 hover:text-white hover:bg-white/10 transition-all">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="lg:hidden bg-[#030308]/98 backdrop-blur-2xl border-b border-white/10 shadow-2xl"
        style="display: none;">
        <div class="max-w-7xl mx-auto px-4 py-6 space-y-2">
            <!-- Mobile Search -->
            <form action="{{ route('search') }}" method="GET" class="mb-4">
                <div class="flex items-center bg-white/5 border border-white/10 rounded-xl px-4 py-3">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="q" placeholder="Search..." class="bg-transparent border-none text-white placeholder-gray-500 focus:ring-0 w-full px-3">
                </div>
            </form>
            
            @php
                $mobileLinks = [
                    ['label' => 'Browse All', 'route' => 'wiki.index', 'icon' => '📚'],
                    ['label' => 'Explore Map', 'route' => 'explore', 'icon' => '🌐'],
                    ['label' => 'Leaderboard', 'route' => 'leaderboard', 'icon' => '🏆'],
                    ['label' => 'AI Generate', 'route' => 'wiki.generate', 'icon' => '🤖'],
                    ['label' => 'Lyric Analyzer', 'route' => 'tools.lyrics', 'icon' => '🎤'],
                ];
            @endphp
            @foreach($mobileLinks as $link)
                <a href="{{ route($link['route']) }}" wire:navigate class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-300 hover:bg-white/5 hover:text-white transition-all">
                    <span class="text-xl">{{ $link['icon'] }}</span>
                    <span class="font-medium">{{ $link['label'] }}</span>
                </a>
            @endforeach
            
            @guest
                <div class="pt-4 border-t border-white/10 grid grid-cols-2 gap-3">
                    <a href="{{ route('login') }}" wire:navigate class="px-4 py-3 text-center bg-white/5 border border-white/10 rounded-xl text-white font-medium hover:bg-white/10 transition-all">
                        Log in
                    </a>
                    <a href="{{ route('register') }}" wire:navigate class="px-4 py-3 text-center bg-gradient-to-r from-brand-600 to-brand-500 rounded-xl text-white font-medium hover:shadow-lg hover:shadow-brand-500/25 transition-all">
                        Sign up
                    </a>
                </div>
            @endguest
        </div>
    </div>
</header>
