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
    <h2 class="text-[32px] font-bold text-white mb-4">Forgot Password</h2>
    <p class="text-white/50 text-[14px] font-medium mb-12">
        Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.
    </p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink" class="space-y-6">
        <div class="space-y-2">
            <label for="email" class="text-[15px] font-medium text-white/80 ml-1">Email</label>
            <div class="relative group">
                <input 
                    wire:model="email" 
                    id="email" 
                    type="email" 
                    name="email" 
                    required 
                    autofocus
                    placeholder="Enter your email address"
                    class="block w-full px-6 py-3 bg-[#161b22] border border-white/5 rounded-[14px] text-white text-[15px] placeholder-white/20 focus:border-white/10 focus:outline-none transition-all shadow-2xl"
                >
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 ml-4" />
        </div>

        <!-- Submit Button -->
        <button 
            type="submit" 
            wire:loading.attr="disabled"
            wire:target="sendPasswordResetLink"
            class="group w-full flex items-center justify-between bg-white hover:bg-gray-100 px-8 py-3 rounded-full transition-all duration-300 shadow-2xl shadow-black/40"
        >
            <div class="flex-1 text-center">
                <span wire:loading.remove wire:target="sendPasswordResetLink" class="text-[#0d1117] text-[17px] font-bold">
                    Email Password Reset Link
                </span>
                <span wire:loading wire:target="sendPasswordResetLink" class="flex items-center justify-center gap-2 text-[#0d1117] text-[17px] font-bold">
                    <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle>
                        <path class="opacity-75" d="M4 12a8 8 0 018-8" stroke-width="4" stroke-linecap="round"></path>
                    </svg>
                    Sending...
                </span>
            </div>
            
            <div class="w-8 h-8 rounded-full bg-[#3b82f6] flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M7 17L17 7M17 7H7M17 7V17"/>
                </svg>
            </div>
        </button>
    </form>

    <div class="mt-16 text-center">
        <span class="text-white/30 text-[14px] font-medium">Remember your password?</span> 
        <a href="{{ route('login') }}" wire:navigate class="text-white text-[14px] font-black hover:text-blue-400 transition-colors ml-1">
            Login now
        </a>
    </div>
</div>
