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
    <h2 class="text-xl font-bold text-white mb-8 tracking-tight">Log In to Your Account</h2>
    
    <form wire:submit="login" class="space-y-6">
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-bold text-white mb-2 tracking-wide">Email</label>
            <input 
                wire:model="form.email" 
                id="email" 
                type="email" 
                name="email" 
                required 
                autofocus 
                autocomplete="username"
                placeholder="Enter Email Address"
                class="block w-full px-5 py-4 bg-white/[0.03] border border-white/10 rounded-2xl text-white placeholder-white/20 focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all font-medium outline-none"
            >
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-bold text-white mb-2 tracking-wide">Password</label>
            <input 
                wire:model="form.password" 
                id="password" 
                type="password"
                name="password"
                required 
                autocomplete="current-password"
                placeholder="Enter your Password"
                class="block w-full px-5 py-4 bg-white/[0.03] border border-white/10 rounded-2xl text-white placeholder-white/20 focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all font-medium outline-none"
            >
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me + Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember" class="flex items-center gap-2 cursor-pointer group">
                <div class="relative flex items-center">
                    <input 
                        wire:model="form.remember" 
                        id="remember" 
                        type="checkbox" 
                        name="remember"
                        class="peer w-5 h-5 rounded-md bg-white/5 border-white/10 text-blue-600 focus:ring-offset-0 focus:ring-blue-500/20 transition-all"
                    >
                </div>
                <span class="text-sm text-white/40 font-medium group-hover:text-white/60 transition-colors">Remember Me</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" wire:navigate class="text-sm text-blue-500 font-bold hover:text-blue-400 transition-colors">
                    Forgot Password?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <button 
            type="submit" 
            wire:loading.attr="disabled"
            wire:target="login"
            class="group w-full flex items-center justify-center bg-white hover:bg-gray-100 text-[#0d1117] font-black py-1.5 px-1.5 rounded-full transition-all hover:scale-[1.01] active:scale-[0.99] shadow-xl shadow-black/20 disabled:opacity-70 disabled:cursor-not-allowed"
        >
            <div class="flex-1 py-3 px-6 flex items-center justify-center gap-2">
                <span wire:loading.remove wire:target="login">Login</span>
                <span wire:loading wire:target="login" class="flex items-center gap-2">
                    <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle>
                        <path class="opacity-75" d="M4 12a8 8 0 018-8" stroke-width="4" stroke-linecap="round"></path>
                    </svg>
                    Signing in...
                </span>
            </div>
            
            <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center shrink-0 shadow-inner">
                <svg class="w-5 h-5 text-white transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </div>
        </button>
    </form>

    <!-- Sign Up Link -->
    <p class="mt-8 text-center text-white/40 font-medium tracking-tight">
        Don't have an account? 
        <a href="{{ route('register') }}" wire:navigate class="text-white font-black hover:text-blue-500 transition-colors border-b-2 border-white/10 hover:border-blue-500/50 pb-0.5">
            Sign up now
        </a>
    </p>
</div>
