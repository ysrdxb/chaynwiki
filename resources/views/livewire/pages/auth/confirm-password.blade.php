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
    <h2 class="text-xl font-bold text-white mb-4">Confirm your password</h2>
    <p class="text-sm text-white/50 mb-6">
        This is a secure area. Please confirm your password to continue.
    </p>

    <form wire:submit="confirmPassword" class="space-y-6">
        <div>
            <label for="password" class="block text-sm font-bold text-white/80 mb-2">Password</label>
            <input
                wire:model="password"
                id="password"
                class="block w-full px-4 py-3.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-[#64748b] focus:border-[#38bdf8] focus:ring-2 focus:ring-[#38bdf8]/20 transition-all font-medium"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="Enter your Password"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <button 
            type="submit" 
            wire:loading.attr="disabled" 
            wire:target="confirmPassword"
            class="w-full flex items-center justify-center gap-2 bg-[#38bdf8] hover:bg-[#7dd3fc] text-[#0a0e14] font-bold py-4 rounded-full transition-all hover:scale-[1.02] active:scale-[0.98] shadow-lg shadow-[#38bdf8]/25 disabled:opacity-60 disabled:cursor-not-allowed"
        >
            <span wire:loading.remove wire:target="confirmPassword" class="flex items-center gap-2">
                Confirm
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </span>
            <span wire:loading wire:target="confirmPassword" class="flex items-center gap-2">
                <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle>
                    <path class="opacity-75" d="M4 12a8 8 0 018-8" stroke-width="4" stroke-linecap="round"></path>
                </svg>
                Verifying...
            </span>
        </button>
    </form>
</div>
