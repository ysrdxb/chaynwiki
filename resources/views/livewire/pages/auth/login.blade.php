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
            $this->redirectIntended(default: '/admin/dashboard', navigate: true);
            return;
        }

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <h2 class="text-xl font-bold text-white mb-8">Log In to Your Account</h2>
    
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-6">
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-bold text-white/80 mb-2">Email</label>
            <input 
                wire:model="form.email" 
                id="email" 
                type="email" 
                name="email" 
                required 
                autofocus 
                autocomplete="username"
                placeholder="Enter Email Address"
                class="block w-full px-4 py-3.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all font-medium"
            >
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-bold text-white/80 mb-2">Password</label>
            <input 
                wire:model="form.password" 
                id="password" 
                type="password"
                name="password"
                required 
                autocomplete="current-password"
                placeholder="Enter your Password"
                class="block w-full px-4 py-3.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all font-medium"
            >
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me + Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember" class="flex items-center gap-2 cursor-pointer">
                <input 
                    wire:model="form.remember" 
                    id="remember" 
                    type="checkbox" 
                    name="remember"
                    class="w-4 h-4 rounded bg-white/5 border-white/10 text-blue-500 focus:ring-blue-500"
                >
                <span class="text-sm text-gray-400">Remember Me</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" wire:navigate class="text-sm text-blue-400 hover:text-blue-300 transition-colors">
                    Forgot Password?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <button 
            type="submit" 
            class="w-full flex items-center justify-center gap-2 bg-blue-500 hover:bg-blue-600 text-white font-bold py-4 rounded-full transition-all hover:scale-[1.02] active:scale-[0.98] shadow-lg shadow-blue-500/25"
        >
            Login
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </button>
    </form>

    <!-- Sign Up Link -->
    <p class="mt-8 text-center text-gray-400">
        Don't have an account? 
        <a href="{{ route('register') }}" wire:navigate class="text-white font-semibold hover:text-blue-400 transition-colors">
            Sign up now
        </a>
    </p>
</div>
