<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $user = auth()->user();
        if ($user->isModerator()) {
            $this->redirectIntended(default: route('admin.dashboard'), navigate: true);
            return;
        }

        $this->redirectIntended(default: route('dashboard'), navigate: true);
    }
}; ?>

<div>
    <h2 class="text-[32px] font-black text-white uppercase tracking-tightest mb-12" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        <span class="text-blue-500">Log In</span> / Node Access
    </h2>
    
    <form wire:submit="login" class="space-y-6">
        <!-- Email Address -->
        <div class="space-y-3">
            <label for="email" class="text-[10px] font-black text-white/20 uppercase tracking-[0.4em] ml-4">Access Identifier</label>
            <div class="relative group">
                <input 
                    wire:model="form.email" 
                    id="email" 
                    type="email" 
                    name="email" 
                    required 
                    autofocus 
                    autocomplete="username"
                    placeholder="Enter node identifier..."
                    class="block w-full px-8 py-5 bg-white/[0.03] border border-white/5 rounded-[2rem] text-white text-[13px] font-black uppercase tracking-widest placeholder-white/10 focus:border-blue-500/30 focus:bg-white/[0.05] focus:outline-none focus:ring-4 focus:ring-blue-500/5 transition-all shadow-2xl"
                >
                <div class="absolute right-6 top-1/2 -translate-y-1/2 text-white/10 group-focus-within:text-blue-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
            </div>
            <x-input-error :messages="$errors->get('form.email')" class="mt-2 ml-4" />
        </div>

        <!-- Password -->
        <div class="space-y-3">
            <label for="password" class="text-[10px] font-black text-white/20 uppercase tracking-[0.4em] ml-4">Secure Key</label>
            <div class="relative group">
                <input 
                    wire:model="form.password" 
                    id="password" 
                    type="password"
                    name="password"
                    required 
                    autocomplete="current-password"
                    placeholder="Enter security key..."
                    class="block w-full px-8 py-5 bg-white/[0.03] border border-white/5 rounded-[2rem] text-white text-[13px] font-black uppercase tracking-widest placeholder-white/10 focus:border-blue-500/30 focus:bg-white/[0.05] focus:outline-none focus:ring-4 focus:ring-blue-500/5 transition-all shadow-2xl"
                >
                <div class="absolute right-6 top-1/2 -translate-y-1/2 text-white/10 group-focus-within:text-blue-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-2 ml-4" />
        </div>

        <!-- Remember Me + Forgot Password -->
        <div class="flex items-center justify-between px-2">
            <label for="remember" class="flex items-center gap-3 cursor-pointer group">
                <input 
                    wire:model="form.remember" 
                    id="remember" 
                    type="checkbox" 
                    name="remember"
                    class="w-5 h-5 border-white/10 bg-white/5 rounded-lg text-blue-500 focus:ring-blue-500/20 focus:ring-offset-0 transition-all"
                >
                <span class="text-[11px] font-black text-white/20 uppercase tracking-widest group-hover:text-white/40 transition-colors">Maintain Session</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" wire:navigate class="text-[11px] font-black text-blue-500 uppercase tracking-widest hover:text-white transition-colors">
                    Key Recovery
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <button 
            type="submit" 
            wire:loading.attr="disabled"
            wire:target="login"
            class="btn-figma-primary !w-full !py-5 !rounded-[2rem] shadow-2xl shadow-blue-500/10"
        >
            <span wire:loading.remove wire:target="login">Initiate Authorization</span>
            <span wire:loading wire:target="login" class="flex items-center gap-2">
                <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle>
                    <path class="opacity-75" d="M4 12a8 8 0 018-8" stroke-width="4" stroke-linecap="round"></path>
                </svg>
                Processing...
            </span>
            
            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </div>
        </button>
    </form>

    <!-- Sign Up Link -->
    <p class="mt-12 text-center text-white/20 text-[11px] font-black uppercase tracking-[0.3em]">
        New node? 
        <a href="{{ route('register') }}" wire:navigate class="text-blue-500 hover:text-white transition-colors border-b border-blue-500/30 hover:border-white pb-1 ml-2">
            Create Identity
        </a>
    </p>
</div>
