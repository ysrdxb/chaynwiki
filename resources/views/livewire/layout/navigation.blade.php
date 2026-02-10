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

<nav x-data="{ open: false }" class="bg-black/60 border-b border-white/5 backdrop-blur-2xl fixed top-0 w-full z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-[1400px] mx-auto px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center gap-12">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" wire:navigate class="group">
                        <span class="text-3xl font-black tracking-tightest text-white uppercase italic group-hover:text-blue-500 transition-colors duration-500" style="font-family: 'Plus Jakarta Sans', sans-serif;">CHAYN<span class="text-blue-500 group-hover:text-white transition-colors duration-500">WIKI</span></span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:flex h-full items-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate class="text-[10px] font-black uppercase tracking-[0.3em] h-full flex items-center border-b-2 border-transparent hover:border-blue-500/50 transition-all duration-500 pt-1">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <a href="{{ route('wiki.index') }}" wire:navigate class="text-[10px] font-black uppercase tracking-[0.3em] text-white/40 hover:text-white transition-colors">
                        ARCHIVE
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="60">
                    <x-slot name="trigger">
                        @auth
                        <button class="inline-flex items-center gap-3 px-4 py-2 border border-white/5 rounded-xl bg-white/5 text-[10px] font-black uppercase tracking-[0.2em] text-white/60 hover:text-white hover:bg-white/10 transition-all duration-500 group">
                            <div class="w-6 h-6 rounded-full bg-blue-500/20 flex items-center justify-center border border-blue-500/20 group-hover:scale-110 transition-transform duration-500">
                                <svg class="w-3 h-3 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                            </div>
                            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name" class="italic"></div>
                            <svg class="w-3 h-3 text-white/20 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        @endauth
                        @guest
                        <a href="{{ route('login') }}" class="btn-figma-primary !py-2 !px-6 !text-[10px]">
                            LOG_IN
                        </a>
                        @endguest
                    </x-slot>

                    <x-slot name="content">
                        <div class="p-2 space-y-1">
                            @auth
                            <x-dropdown-link :href="route('settings')" wire:navigate class="!rounded-xl !text-[10px] !font-black !uppercase !tracking-widest !py-3 hover:!bg-blue-500/10 hover:!text-blue-500 transition-all italic">
                                {{ __('Configuration') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('profile', ['username' => auth()->user()->username])" wire:navigate class="!rounded-xl !text-[10px] !font-black !uppercase !tracking-widest !py-3 hover:!bg-blue-500/10 hover:!text-blue-500 transition-all italic">
                                {{ __('Public Node') }}
                            </x-dropdown-link>

                            <div class="h-px bg-white/5 my-1"></div>

                            <button wire:click="logout" class="w-full text-start group">
                                <x-dropdown-link class="!rounded-xl !text-[10px] !font-black !uppercase !tracking-widest !py-3 group-hover:!bg-red-500/10 group-hover:!text-red-500 transition-all italic">
                                    {{ __('Terminate Session') }}
                                </x-dropdown-link>
                            </button>
                            @endauth
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
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
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate class="rounded-2xl !text-[11px] !font-black !uppercase !tracking-[0.3em] !py-4">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <a href="{{ route('wiki.index') }}" wire:navigate class="block px-4 py-4 rounded-2xl text-[11px] font-black uppercase tracking-[0.3em] text-white/40 hover:text-white hover:bg-white/5 transition-all">
                ARCHIVE
            </a>
        </div>

        <!-- Responsive Settings Options -->
        @auth
        <div class="pt-6 pb-6 border-t border-white/5">
            <div class="px-8 mb-6">
                <div class="text-[12px] font-black text-white uppercase tracking-widest italic mb-1" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="text-[10px] font-black text-white/20 uppercase tracking-[0.2em]">{{ auth()->user()->email }}</div>
            </div>

            <div class="space-y-2 px-4">
                <x-responsive-nav-link :href="route('settings')" wire:navigate class="rounded-2xl !text-[10px] !font-black !uppercase !tracking-[0.3em] !py-4">
                    {{ __('Configuration') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('profile', ['username' => auth()->user()->username])" wire:navigate class="rounded-2xl !text-[10px] !font-black !uppercase !tracking-[0.3em] !py-4">
                    {{ __('Public Node') }}
                </x-responsive-nav-link>

                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link class="rounded-2xl !text-[10px] !font-black !uppercase !tracking-[0.3em] !py-4 !text-red-500">
                        {{ __('Terminate Session') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
        @else
        <div class="pt-6 pb-6 border-t border-white/5 px-4">
            <a href="{{ route('login') }}" class="block px-4 py-4 rounded-2xl text-[11px] font-black uppercase tracking-[0.3em] text-blue-500 bg-blue-500/10 text-center">LOGIN_NODE</a>
        </div>
        @endauth
    </div>
</nav>
