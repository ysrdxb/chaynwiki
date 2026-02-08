<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $agree_terms = false;

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'agree_terms' => ['accepted'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        unset($validated['agree_terms']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard'), navigate: true);
    }
}; ?>

<div>
    <h2 class="text-xl font-bold text-white mb-8">Create an Account</h2>
    
    <form wire:submit="register" class="space-y-5">
        <!-- Full Name -->
        <div>
            <label for="name" class="block text-sm font-bold text-white/80 mb-2">Full Name</label>
            <input 
                wire:model="name" 
                id="name" 
                type="text" 
                name="name" 
                required 
                autofocus 
                autocomplete="name"
                placeholder="Enter your full name"
                class="block w-full px-4 py-3.5 bg-[#161b22] border border-white/5 rounded-xl text-white placeholder-white/40 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all font-medium"
            >
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-bold text-white/80 mb-2">Email</label>
            <input 
                wire:model="email" 
                id="email" 
                type="email" 
                name="email" 
                required 
                autocomplete="username"
                placeholder="Enter Email Address"
                class="block w-full px-4 py-3.5 bg-[#161b22] border border-white/5 rounded-xl text-white placeholder-white/40 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all font-medium"
            >
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-bold text-white/80 mb-2">Password</label>
            <input 
                wire:model="password" 
                id="password" 
                type="password"
                name="password"
                required 
                autocomplete="new-password"
                placeholder="Enter your Password"
                class="block w-full px-4 py-3.5 bg-[#161b22] border border-white/5 rounded-xl text-white placeholder-white/40 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all font-medium"
            >
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-bold text-white/80 mb-2">Confirm Password</label>
            <input 
                wire:model="password_confirmation" 
                id="password_confirmation" 
                type="password"
                name="password_confirmation"
                required 
                autocomplete="new-password"
                placeholder="Retype your Password"
                class="block w-full px-4 py-3.5 bg-[#161b22] border border-white/5 rounded-xl text-white placeholder-white/40 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all font-medium"
            >
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Terms Checkbox -->
        <div>
            <label for="agree_terms" class="flex items-center gap-2 cursor-pointer">
                <input 
                    wire:model="agree_terms" 
                    id="agree_terms" 
                    type="checkbox" 
                    name="agree_terms"
                    class="w-4 h-4 rounded bg-[#161b22] border-white/10 text-blue-500 focus:ring-blue-500"
                >
                <span class="text-sm text-white/40">I agree all terms and conditions</span>
            </label>
            <x-input-error :messages="$errors->get('agree_terms')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <button 
            type="submit" 
            wire:loading.attr="disabled"
            wire:target="register"
            class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-500 text-white font-bold py-4 rounded-full transition-all hover:scale-[1.02] active:scale-[0.98] shadow-lg shadow-blue-900/20 disabled:opacity-60 disabled:cursor-not-allowed"
        >
            <span wire:loading.remove wire:target="register" class="flex items-center gap-2">
                Create Account
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </span>
            <span wire:loading wire:target="register" class="flex items-center gap-2">
                <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle>
                    <path class="opacity-75" d="M4 12a8 8 0 018-8" stroke-width="4" stroke-linecap="round"></path>
                </svg>
                Creating...
            </span>
        </button>
    </form>

    <!-- Login Link -->
    <p class="mt-8 text-center text-white/40">
        Already have an account? 
        <a href="{{ route('login') }}" wire:navigate class="text-white font-semibold hover:text-blue-400 transition-colors">
            Log in
        </a>
    </p>
</div>
