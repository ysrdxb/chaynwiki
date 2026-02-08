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
    <h2 class="text-xl font-bold text-white mb-8 tracking-tight">Create an Account</h2>
    
    <form wire:submit="register" class="space-y-5">
        <!-- Full Name -->
        <div>
            <label for="name" class="block text-sm font-bold text-white mb-2 tracking-wide">Full Name</label>
            <input 
                wire:model="name" 
                id="name" 
                type="text" 
                name="name" 
                required 
                autofocus 
                autocomplete="name"
                placeholder="Enter your full name"
                class="block w-full px-5 py-4 bg-white/[0.03] border border-white/10 rounded-2xl text-white placeholder-white/20 focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all font-medium outline-none"
            >
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-bold text-white mb-2 tracking-wide">Email</label>
            <input 
                wire:model="email" 
                id="email" 
                type="email" 
                name="email" 
                required 
                autocomplete="username"
                placeholder="Enter Email Address"
                class="block w-full px-5 py-4 bg-white/[0.03] border border-white/10 rounded-2xl text-white placeholder-white/20 focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all font-medium outline-none"
            >
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-bold text-white mb-2 tracking-wide">Password</label>
            <input 
                wire:model="password" 
                id="password" 
                type="password"
                name="password"
                required 
                autocomplete="new-password"
                placeholder="Enter your Password"
                class="block w-full px-5 py-4 bg-white/[0.03] border border-white/10 rounded-2xl text-white placeholder-white/20 focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all font-medium outline-none"
            >
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-bold text-white mb-2 tracking-wide">Confirm Password</label>
            <input 
                wire:model="password_confirmation" 
                id="password_confirmation" 
                type="password"
                name="password_confirmation" 
                required 
                autocomplete="new-password"
                placeholder="Retype your Password"
                class="block w-full px-5 py-4 bg-white/[0.03] border border-white/10 rounded-2xl text-white placeholder-white/20 focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all font-medium outline-none"
            >
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Terms Checkbox -->
        <div>
            <label for="agree_terms" class="flex items-center gap-2 cursor-pointer group">
                <input 
                    wire:model="agree_terms" 
                    id="agree_terms" 
                    type="checkbox" 
                    name="agree_terms"
                    class="peer w-5 h-5 rounded-md bg-white/5 border-white/10 text-blue-600 focus:ring-offset-0 focus:ring-blue-500/20 transition-all"
                >
                <span class="text-sm text-white/40 font-medium group-hover:text-white/60 transition-colors">I agree all terms and conditions</span>
            </label>
            <x-input-error :messages="$errors->get('agree_terms')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <button 
            type="submit" 
            wire:loading.attr="disabled"
            wire:target="register"
            class="group w-full flex items-center justify-center bg-white hover:bg-gray-100 text-[#0d1117] font-black py-1.5 px-1.5 rounded-full transition-all hover:scale-[1.01] active:scale-[0.99] shadow-xl shadow-black/20 disabled:opacity-70 disabled:cursor-not-allowed"
        >
            <div class="flex-1 py-3 px-6 flex items-center justify-center gap-2">
                <span wire:loading.remove wire:target="register">Sign Up</span>
                <span wire:loading wire:target="register" class="flex items-center gap-2">
                    <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle>
                        <path class="opacity-75" d="M4 12a8 8 0 018-8" stroke-width="4" stroke-linecap="round"></path>
                    </svg>
                    Creating...
                </span>
            </div>
            
            <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center shrink-0 shadow-inner">
                <svg class="w-5 h-5 text-white transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </div>
        </button>
    </form>

    <!-- Login Link -->
    <p class="mt-8 text-center text-white/40 font-medium tracking-tight">
        Already have an account? 
        <a href="{{ route('login') }}" wire:navigate class="text-white font-black hover:text-blue-500 transition-colors border-b-2 border-white/10 hover:border-blue-500/50 pb-0.5">
            Login now
        </a>
    </p>
</div>
