<?php

use Livewire\Component;

new class extends Component
{
    //
}; ?>

<nav class="relative z-50 flex items-center justify-between px-4 sm:px-6 lg:px-8 py-6">
    <!-- Logo Section -->
    <div class="flex items-center gap-3">
        <a href="{{ route('welcome') }}" class="flex items-center gap-3 group">
            <!-- Logo Icon -->
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center shadow-lg shadow-brand-500/20 group-hover:scale-105 transition-transform">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
            </div>
            <!-- Logo Text -->
            <span class="text-xl font-display font-black text-white tracking-tight uppercase group-hover:text-brand-400 transition-colors">
                CHAYNWIKI
            </span>
        </a>
    </div>

    <!-- Navigation Links - Hidden on mobile -->
    <div class="hidden md:flex items-center gap-8">
        <a href="{{ route('wiki.index') }}" class="text-sm font-medium text-white/70 hover:text-white transition-colors uppercase tracking-wider">
            Browse
        </a>
        <a href="#" class="text-sm font-medium text-white/70 hover:text-white transition-colors uppercase tracking-wider">
            Categories
        </a>
        <a href="#" class="text-sm font-medium text-white/70 hover:text-white transition-colors uppercase tracking-wider">
            Community
        </a>
        <a href="#" class="text-sm font-medium text-white/70 hover:text-white transition-colors uppercase tracking-wider">
            About
        </a>
    </div>

    <!-- Auth Buttons -->
    <div class="flex items-center gap-3">
        @auth
            <a
                href="{{ url('/dashboard') }}"
                class="hidden sm:flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/5 border border-white/10 text-white font-medium text-sm hover:bg-white/10 hover:border-white/20 transition-all"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                Dashboard
            </a>
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="w-10 h-10 rounded-full bg-brand-600 flex items-center justify-center text-white font-bold hover:bg-brand-500 transition-colors">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </button>
            </div>
        @else
            <a
                href="{{ route('login') }}"
                class="px-5 py-2.5 rounded-full text-white font-medium text-sm hover:text-brand-400 transition-colors"
            >
                Log in
            </a>
            <a
                href="{{ route('register') }}"
                class="px-5 py-2.5 rounded-full bg-white text-black font-bold text-sm hover:bg-gray-100 transition-all hover:scale-105"
            >
                Sign up
            </a>
        @endauth

        <!-- Mobile Menu Button -->
        <button class="md:hidden w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>
</nav>
