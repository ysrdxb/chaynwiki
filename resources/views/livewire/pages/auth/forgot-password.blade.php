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
    <h2 class="text-[32px] font-black text-white uppercase tracking-tightest mb-4 italic" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        <span class="text-blue-500">Key Recovery</span> / Node Restore
    </h2>
    <p class="text-white/20 text-[11px] font-black uppercase tracking-[0.4em] mb-12">
        Lost access? Enter identifier to dispatch a restoration link.
    </p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink" class="space-y-6">
        <div class="space-y-3">
            <label for="email" class="text-[10px] font-black text-white/20 uppercase tracking-[0.4em] ml-4">Access Identifier</label>
            <div class="relative group">
                <input 
                    wire:model="email" 
                    id="email" 
                    type="email" 
                    name="email" 
                    required 
                    autofocus
                    placeholder="Enter node identifier..."
                    class="block w-full px-8 py-5 bg-white/[0.03] border border-white/5 rounded-[2rem] text-white text-[13px] font-black uppercase tracking-widest placeholder-white/10 focus:border-blue-500/30 focus:bg-white/[0.05] focus:outline-none focus:ring-4 focus:ring-blue-500/5 transition-all shadow-2xl"
                >
                <div class="absolute right-6 top-1/2 -translate-y-1/2 text-white/10 group-focus-within:text-blue-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 ml-4" />
        </div>

        <!-- Submit Button -->
        <button 
            type="submit" 
            wire:loading.attr="disabled"
            wire:target="sendPasswordResetLink"
            class="btn-figma-primary !w-full !py-5 !rounded-[2rem] shadow-2xl shadow-blue-500/10"
        >
            <span wire:loading.remove wire:target="sendPasswordResetLink">Dispatch Restoration Link</span>
            <span wire:loading wire:target="sendPasswordResetLink" class="flex items-center gap-2">
                <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle>
                    <path class="opacity-75" d="M4 12a8 8 0 018-8" stroke-width="4" stroke-linecap="round"></path>
                </svg>
                Sending...
            </span>
            
            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
        </button>
    </form>

    <p class="mt-12 text-center text-white/20 text-[11px] font-black uppercase tracking-[0.3em]">
        Back to safety? 
        <a href="{{ route('login') }}" wire:navigate class="text-blue-500 hover:text-white transition-colors border-b border-blue-500/30 hover:border-white pb-1 ml-2">
            Access Node
        </a>
    </p>
</div>
