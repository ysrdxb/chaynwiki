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

<div class="w-full">
    <h3 class="text-[24px] font-bold text-white mb-10">Create an Account</h3>
    
    <form wire:submit="register" class="space-y-6">
        <!-- Full Name -->
        <div class="space-y-2">
            <label for="name" class="text-[15px] font-medium text-white/80 ml-2">Full Name</label>
            <div class="relative group">
                <input 
                    wire:model="name" 
                    id="name" 
                    type="text" 
                    name="name" 
                    required 
                    autofocus 
                    autocomplete="name"
                    placeholder="Enter your full name"
                    class="block w-full px-6 py-3 bg-[#161b22] border border-white/5 rounded-[14px] text-white text-[15px] placeholder-white/20 focus:border-white/10 focus:outline-none transition-all shadow-2xl"
                >
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2 ml-4" />
        </div>

        <!-- Email Address -->
        <div class="space-y-2">
            <label for="email" class="text-[15px] font-medium text-white/80 ml-2">Email</label>
            <div class="relative group">
                <input 
                    wire:model="email" 
                    id="email" 
                    type="email" 
                    name="email" 
                    required 
                    autocomplete="username"
                    placeholder="Enter Email Address"
                    class="block w-full px-6 py-3 bg-[#161b22] border border-white/5 rounded-[14px] text-white text-[15px] placeholder-white/20 focus:border-white/10 focus:outline-none transition-all shadow-2xl"
                >
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 ml-4" />
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <!-- Password -->
            <div class="space-y-2">
                <label for="password" class="text-[15px] font-medium text-white/80 ml-2">Password</label>
                <div class="relative group">
                    <input 
                        wire:model="password" 
                        id="password" 
                        type="password"
                        name="password"
                        required 
                        autocomplete="new-password"
                        placeholder="Enter your Password"
                        class="block w-full px-6 py-3 bg-[#161b22] border border-white/5 rounded-[14px] text-white text-[15px] placeholder-white/20 focus:border-white/10 focus:outline-none transition-all shadow-2xl"
                    >
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 ml-4" />
            </div>

            <!-- Confirm Password -->
            <div class="space-y-2">
                <label for="password_confirmation" class="text-[15px] font-medium text-white/80 ml-2">Confirm Password</label>
                <div class="relative group">
                    <input 
                        wire:model="password_confirmation" 
                        id="password_confirmation" 
                        type="password"
                        name="password_confirmation" 
                        required 
                        autocomplete="new-password"
                        placeholder="Enter your Password"
                        class="block w-full px-6 py-3 bg-[#161b22] border border-white/5 rounded-[14px] text-white text-[15px] placeholder-white/20 focus:border-white/10 focus:outline-none transition-all shadow-2xl"
                    >
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 ml-4" />
            </div>
        </div>

        <!-- Terms Checkbox -->
        <div class="px-2 pt-2">
            <label for="agree_terms" class="flex items-center gap-3 cursor-pointer group">
                <input 
                    wire:model="agree_terms" 
                    id="agree_terms" 
                    type="checkbox" 
                    name="agree_terms"
                    class="w-5 h-5 border-white/10 bg-white/5 rounded-[4px] text-blue-500 focus:ring-blue-500/20 focus:ring-offset-0 transition-all cursor-pointer"
                >
                <span class="text-[14px] font-medium text-white/40 group-hover:text-white transition-colors">I agree all terms and conditions</span>
            </label>
            <x-input-error :messages="$errors->get('agree_terms')" class="mt-2 ml-4" />
        </div>

        <!-- Submit Button -->
        <button 
            type="submit" 
            wire:loading.attr="disabled"
            wire:target="register"
            class="group w-full flex items-center justify-between bg-white hover:bg-gray-100 px-8 py-3 rounded-full transition-all duration-300 shadow-2xl shadow-black/40"
        >
            <div class="flex-1 text-center">
                <span wire:loading.remove wire:target="register" class="text-[#0d1117] text-[17px] font-bold">
                    Sign up
                </span>
                <span wire:loading wire:target="register" class="flex items-center justify-center gap-2 text-[#0d1117] text-[17px] font-bold">
                    <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle>
                        <path class="opacity-75" d="M4 12a8 8 0 018-8" stroke-width="4" stroke-linecap="round"></path>
                    </svg>
                    Creating account...
                </span>
            </div>
            
            <div class="w-8 h-8 rounded-full bg-[#3b82f6] flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M7 17L17 7M17 7H7M17 7V17"/>
                </svg>
            </div>
        </button>
    </form>

    <!-- Login Link -->
    <div class="mt-16 text-center">
        <span class="text-white/30 text-[14px] font-medium">Already have an account?</span> 
        <a href="{{ route('login') }}" wire:navigate class="text-white text-[14px] font-black hover:text-blue-400 transition-colors ml-1">
            Login now
        </a>
    </div>
</div>
