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
    <h2 class="text-xl font-bold text-white mb-4 tracking-tight">Confirm your password</h2>
    <p class="text-sm text-white/50 mb-8 font-medium">
        This is a secure area. Please confirm your password to continue.
    </p>

    <form wire:submit="confirmPassword" class="space-y-6">
        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-bold text-white mb-2 tracking-wide">Password</label>
            <input
                wire:model="password"
                id="password"
                class="block w-full px-5 py-4 bg-white/[0.03] border border-white/10 rounded-2xl text-white placeholder-white/20 focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all font-medium outline-none"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="Enter your Password"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <button 
            type="submit" 
            wire:loading.attr="disabled" 
            wire:target="confirmPassword"
            class="group w-full flex items-center justify-center bg-white hover:bg-gray-100 text-[#0d1117] font-black py-1.5 px-1.5 rounded-full transition-all hover:scale-[1.01] active:scale-[0.99] shadow-xl shadow-black/20 disabled:opacity-70 disabled:cursor-not-allowed"
        >
            <div class="flex-1 py-3 px-6 flex items-center justify-center gap-2">
                <span wire:loading.remove wire:target="confirmPassword">Confirm Access</span>
                <span wire:loading wire:target="confirmPassword" class="flex items-center gap-2">
                    <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle>
                        <path class="opacity-75" d="M4 12a8 8 0 018-8" stroke-width="4" stroke-linecap="round"></path>
                    </svg>
                    Verifying...
                </span>
            </div>
            
            <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center shrink-0 shadow-inner">
                <svg class="w-5 h-5 text-white transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </div>
        </button>
    </form>
</div>
