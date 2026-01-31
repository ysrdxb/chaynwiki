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

        $this->redirect(route('dashboard', absolute: false), navigate: true);
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
                class="block w-full px-4 py-3.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all font-medium"
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
                class="block w-full px-4 py-3.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all font-medium"
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
                class="block w-full px-4 py-3.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all font-medium"
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
                placeholder="Enter your Password"
                class="block w-full px-4 py-3.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all font-medium"
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
                    class="w-4 h-4 rounded bg-white/5 border-white/10 text-blue-500 focus:ring-blue-500"
                >
                <span class="text-sm text-gray-400">I agree all terms and conditions</span>
            </label>
            <x-input-error :messages="$errors->get('agree_terms')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <button 
            type="submit" 
            class="w-full flex items-center justify-center gap-2 bg-blue-500 hover:bg-blue-600 text-white font-bold py-4 rounded-full transition-all hover:scale-[1.02] active:scale-[0.98] shadow-lg shadow-blue-500/25"
        >
            Sign Up
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </button>
    </form>

    <!-- Login Link -->
    <p class="mt-8 text-center text-gray-400">
        Already have an account? 
        <a href="{{ route('login') }}" wire:navigate class="text-white font-semibold hover:text-blue-400 transition-colors">
            Login now
        </a>
    </p>
</div>
