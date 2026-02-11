<?php

use App\Livewire\Actions\Logout;
use Livewire\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="bg-[#0a0a0a] border-b border-white/5 fixed top-0 w-full z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-[1500px] mx-auto px-12">
        <div class="flex items-center justify-between h-20">
            <!-- Left: Logo -->
            <div class="shrink-0">
                <a href="{{ route('dashboard') }}" wire:navigate class="group">
                    <span class="text-[32px] font-[950] text-white uppercase leading-none inline-block transform scale-y-110" 
                        style="font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.08em; font-weight: 1000;">CHAYNWIKI</span>
                </a>
            </div>

            <!-- Middle: Search Bar (Compact) -->
            <div class="hidden lg:flex flex-1 justify-center max-w-xl px-12">
                <div class="relative w-72 group">
                    <input type="text" placeholder="Search" class="w-full h-11 bg-[#161616] border-none rounded-full px-6 text-[14px] text-white/40 placeholder-white/30 focus:outline-none focus:ring-1 focus:ring-white/10 transition-all font-medium">
                    <div class="absolute right-1 top-1 bottom-1 w-9 h-9 bg-[#2563eb] rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>
            </div>

            <!-- Right: Nav Links + Avatar -->
            <div class="flex items-center gap-10">
                <nav class="hidden space-x-8 lg:flex items-center">
                    <a href="{{ route('wiki.index', ['category' => 'artist']) }}" wire:navigate class="text-[14px] font-medium text-white/40 hover:text-white transition-colors">
                        Artists
                    </a>
                    <a href="{{ route('wiki.index', ['category' => 'genre']) }}" wire:navigate class="text-[14px] font-medium text-white/40 hover:text-white transition-colors">
                        Genres
                    </a>
                    <a href="#" class="text-[14px] font-medium text-white/40 hover:text-white transition-colors">
                        Lyrics
                    </a>
                    <a href="#" class="text-[14px] font-medium text-white/40 hover:text-white transition-colors">
                        Playlist
                    </a>
                </nav>

                <!-- Avatar Dropdown -->
                <div class="ms-4">
                    <x-dropdown align="right" width="60">
                        <x-slot name="trigger">
                            @auth
                            <button class="flex items-center group transition-all duration-500">
                                <div class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center group-hover:bg-white/10 transition-all overflow-hidden p-0.5">
                                    @if(auth()->user()->profile_photo_url)
                                        <img src="{{ auth()->user()->profile_photo_url }}" class="w-full h-full rounded-full object-cover">
                                    @else
                                        <div class="w-full h-full rounded-full bg-gradient-to-br from-blue-500/20 to-purple-500/20 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white/40" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                                        </div>
                                    @endif
                                </div>
                            </button>
                            @endauth
                            @guest
                            <a href="{{ route('login') }}" class="btn-figma-primary !py-2 !px-6 !text-[10px]">
                                Log In
                            </a>
                            @endguest
                        </x-slot>

                        <x-slot name="content">
                            <div class="p-2 space-y-1">
                                @auth
                                <x-dropdown-link :href="route('settings')" wire:navigate class="!rounded-xl !text-[10px] !font-black !tracking-widest !py-3 hover:!bg-blue-500/10 hover:!text-blue-500 transition-all">
                                    {{ __('Settings') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('profile', ['username' => auth()->user()->username])" wire:navigate class="!rounded-xl !text-[10px] !font-black !tracking-widest !py-3 hover:!bg-blue-500/10 hover:!text-blue-500 transition-all">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <div class="h-px bg-white/5 my-1"></div>

                                <button wire:click="logout" class="w-full text-start group">
                                    <x-dropdown-link class="!rounded-xl !text-[10px] !font-black !tracking-widest !py-3 group-hover:!bg-red-500/10 group-hover:!text-red-500 transition-all">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </button>
                                @endauth
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center lg:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-3 rounded-xl text-white/40 hover:text-white hover:bg-white/5 transition duration-500 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-black/90 backdrop-blur-xl border-t border-white/5">
        <div class="pt-4 pb-6 space-y-2 px-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate class="rounded-2xl !text-[11px] !font-black !tracking-[0.3em] !py-4">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <a href="{{ route('wiki.index') }}" wire:navigate class="block px-4 py-4 rounded-2xl text-[11px] font-black tracking-[0.3em] text-white/40 hover:text-white hover:bg-white/5 transition-all">
                Library
            </a>
        </div>

        <!-- Responsive Settings Options -->
        @auth
        <div class="pt-6 pb-6 border-t border-white/5">
            <div class="px-8 mb-6">
                <div class="text-[12px] font-black text-white uppercase tracking-widest mb-1" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="text-[10px] font-black text-white/20 uppercase tracking-[0.2em]">{{ auth()->user()->email }}</div>
            </div>

            <div class="space-y-2 px-4">
                <x-responsive-nav-link :href="route('settings')" wire:navigate class="rounded-2xl !text-[10px] !font-black !uppercase !tracking-[0.3em] !py-4">
                    {{ __('Settings') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('profile', ['username' => auth()->user()->username])" wire:navigate class="rounded-2xl !text-[10px] !font-black !uppercase !tracking-[0.3em] !py-4">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link class="rounded-2xl !text-[10px] !font-black !uppercase !tracking-[0.3em] !py-4 !text-red-500">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
        @else
        <div class="pt-6 pb-6 border-t border-white/5 px-4">
            <a href="{{ route('login') }}" class="block px-4 py-4 rounded-2xl text-[11px] font-black uppercase tracking-[0.3em] text-blue-500 bg-blue-500/10 text-center">Log In</a>
        </div>
        @endauth
    </div>
</nav>
