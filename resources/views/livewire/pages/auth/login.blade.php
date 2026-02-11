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
        $this->form->validate();

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

<div class="w-full">
    <h3 class="text-[24px] font-bold text-white mb-10">Log In to Your Account</h3>
    
    <form wire:submit="login" class="space-y-6">
        <!-- Email Address -->
        <div class="space-y-2">
            <label for="email" class="text-[15px] font-medium text-white/80 ml-1">Email</label>
            <div class="relative">
                <input 
                    wire:model="form.email" 
                    id="email" 
                    type="email" 
                    name="email" 
                    required 
                    autofocus 
                    autocomplete="username"
                    placeholder="Enter Email Address"
                    class="block w-full px-6 py-3 bg-[#161b22] border border-white/5 rounded-[14px] text-white text-[15px] placeholder-white/20 focus:border-white/10 focus:outline-none transition-all shadow-2xl"
                >
            </div>
            <x-input-error :messages="$errors->get('form.email')" class="mt-2 ml-4" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <label for="password" class="text-[15px] font-medium text-white/80 ml-1">Password</label>
            <div class="relative">
                <input 
                    wire:model="form.password" 
                    id="password" 
                    type="password"
                    name="password"
                    required 
                    autocomplete="current-password"
                    placeholder="Enter your Password"
                    class="block w-full px-6 py-3 bg-[#161b22] border border-white/5 rounded-[14px] text-white text-[15px] placeholder-white/20 focus:border-white/10 focus:outline-none transition-all shadow-2xl"
                >
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-2 ml-4" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between px-1">
            <label for="remember" class="flex items-center gap-3 cursor-pointer group">
                <input 
                    wire:model="form.remember" 
                    id="remember" 
                    type="checkbox" 
                    name="remember"
                    class="w-5 h-5 border-white/10 bg-white/5 rounded-[4px] text-blue-500 focus:ring-blue-500/20 focus:ring-offset-0 transition-all cursor-pointer"
                >
                <span class="text-[14px] font-medium text-white/40 group-hover:text-white transition-colors">Remember Me</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" wire:navigate class="text-[14px] font-medium text-[#3b82f6] hover:text-white transition-colors">
                    Forgot Password?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <button 
            type="submit" 
            wire:loading.attr="disabled"
            wire:target="login"
            class="group w-full flex items-center justify-between bg-white hover:bg-gray-100 px-8 py-3 rounded-full transition-all duration-300 shadow-2xl shadow-black/40"
        >
            <div class="flex-1 text-center">
                <span wire:loading.remove wire:target="login" class="text-[#0d1117] text-[17px] font-bold">
                    Login
                </span>
                <span wire:loading wire:target="login" class="flex items-center justify-center gap-2 text-[#0d1117] text-[17px] font-bold">
                    <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle>
                        <path class="opacity-75" d="M4 12a8 8 0 018-8" stroke-width="4" stroke-linecap="round"></path>
                    </svg>
                    Logging in...
                </span>
            </div>
            
            <div class="w-8 h-8 rounded-full bg-[#3b82f6] flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M7 17L17 7M17 7H7M17 7V17"/>
                </svg>
            </div>
        </button>
    </form>

    <!-- Sign Up Link -->
    <div class="mt-16 text-center">
        <span class="text-white/30 text-[14px] font-medium">Don't have an account?</span> 
        <a href="{{ route('register') }}" wire:navigate class="text-white text-[14px] font-black hover:text-blue-400 transition-colors ml-1">
            Sign up now
        </a>
    </div>
</div>
