<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $password = '';

    /**
     * Confirm the current user's password.
     */
    public function confirmPassword(): void
    {
        $this->validate([
            'password' => ['required', 'string'],
        ]);

        if (! Auth::guard('web')->validate([
            'email' => Auth::user()->email,
            'password' => $this->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        session(['auth.password_confirmed_at' => time()]);

        $this->redirectIntended(default: route('dashboard'), navigate: true);
    }
}; ?>

<div>
    <h2 class="text-[32px] font-bold text-white mb-4">Confirm Password</h2>
    <p class="text-white/50 text-[14px] font-medium mb-12">
        This is a secure area. Please confirm your password to continue.
    </p>

    <form wire:submit="confirmPassword" class="space-y-6">
        <!-- Password -->
        <div class="space-y-2">
            <label for="password" class="text-[15px] font-medium text-white/80 ml-1">Password</label>
            <div class="relative group">
                <input
                    wire:model="password"
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Enter your Password"
                    class="block w-full px-6 py-3 bg-[#161b22] border border-white/5 rounded-[14px] text-white text-[15px] placeholder-white/20 focus:border-white/10 focus:outline-none transition-all shadow-2xl"
                />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 ml-4" />
        </div>

        <!-- Submit Button -->
        <button 
            type="submit" 
            wire:loading.attr="disabled"
            wire:target="confirmPassword"
            class="group w-full flex items-center justify-between bg-white hover:bg-gray-100 px-8 py-3 rounded-full transition-all duration-300 shadow-2xl shadow-black/40"
        >
            <div class="flex-1 text-center">
                <span wire:loading.remove wire:target="confirmPassword" class="text-[#0d1117] text-[17px] font-bold">
                    Confirm Password
                </span>
                <span wire:loading wire:target="confirmPassword" class="flex items-center justify-center gap-2 text-[#0d1117] text-[17px] font-bold">
                    <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle>
                        <path class="opacity-75" d="M4 12a8 8 0 018-8" stroke-width="4" stroke-linecap="round"></path>
                    </svg>
                    Verifying...
                </span>
            </div>
            
            <div class="w-8 h-8 rounded-full bg-[#3b82f6] flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M7 17L17 7M17 7H7M17 7V17"/>
                </svg>
            </div>
        </button>
    </form>
</div>
