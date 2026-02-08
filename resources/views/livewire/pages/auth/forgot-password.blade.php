<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div>
    <h2 class="text-xl font-bold text-white mb-4 tracking-tight">Reset your password</h2>
    <p class="text-sm text-white/50 mb-8 font-medium">
        Forgot your password? Enter your email and we’ll send a reset link.
    </p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink" class="space-y-6">
        <div>
            <label for="email" class="block text-sm font-bold text-white mb-2 tracking-wide">Email</label>
            <input 
                wire:model="email" 
                id="email" 
                type="email" 
                name="email" 
                required 
                autofocus
                placeholder="Enter Email Address"
                class="block w-full px-5 py-4 bg-white/[0.03] border border-white/10 rounded-2xl text-white placeholder-white/20 focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all font-medium outline-none"
            >
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <button 
            type="submit" 
            wire:loading.attr="disabled"
            wire:target="sendPasswordResetLink"
            class="group w-full flex items-center justify-center bg-white hover:bg-gray-100 text-[#0d1117] font-black py-1.5 px-1.5 rounded-full transition-all hover:scale-[1.01] active:scale-[0.99] shadow-xl shadow-black/20 disabled:opacity-70 disabled:cursor-not-allowed"
        >
            <div class="flex-1 py-3 px-6 flex items-center justify-center gap-2">
                <span wire:loading.remove wire:target="sendPasswordResetLink">Email reset link</span>
                <span wire:loading wire:target="sendPasswordResetLink" class="flex items-center gap-2">
                    <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle>
                        <path class="opacity-75" d="M4 12a8 8 0 018-8" stroke-width="4" stroke-linecap="round"></path>
                    </svg>
                    Sending...
                </span>
            </div>
            
            <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center shrink-0 shadow-inner">
                <svg class="w-5 h-5 text-white transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </div>
        </button>
    </form>

    <p class="mt-8 text-center text-white/40 font-medium tracking-tight">
        Remembered it?
        <a href="{{ route('login') }}" wire:navigate class="text-white font-black hover:text-blue-500 transition-colors border-b-2 border-white/10 hover:border-blue-500/50 pb-0.5">
            Login now
        </a>
    </p>
</div>
