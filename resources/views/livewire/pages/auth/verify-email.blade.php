<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.guest')] class extends Component
{
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard'), navigate: true);

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div>
    <h2 class="text-[32px] font-black text-white uppercase tracking-tightest mb-4" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        <span class="text-blue-500">Verify</span> / Identity Logic
    </h2>
    <p class="text-white/20 text-[11px] font-black uppercase tracking-[0.4em] mb-12">
        A verification link has been dispatched to your identifier. Activate to proceed.
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-10 p-5 rounded-[2rem] bg-green-500/10 border border-green-500/20 text-green-400 text-[11px] font-black uppercase tracking-widest flex items-center gap-4 shadow-2xl">
            <div class="w-10 h-10 rounded-full bg-green-500/10 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
            </div>
            Signal re-dispatched to identifier.
        </div>
    @endif

    <div class="flex flex-col gap-4">
        <!-- Resend Button -->
        <button
            type="button"
            wire:click="sendVerification"
            wire:loading.attr="disabled"
            wire:target="sendVerification"
            class="btn-figma-primary !w-full !py-5 !rounded-[2rem] shadow-2xl shadow-blue-500/10"
        >
            <span wire:loading.remove wire:target="sendVerification">Request New Signal</span>
            <span wire:loading wire:target="sendVerification" class="flex items-center gap-2">
                <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle>
                    <path class="opacity-75" d="M4 12a8 8 0 018-8" stroke-width="4" stroke-linecap="round"></path>
                </svg>
                Transmitting...
            </span>
            
            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </div>
        </button>

        <!-- Logout Button -->
        <button
            type="button"
            wire:click="logout"
            wire:loading.attr="disabled"
            wire:target="logout"
            class="mt-4 px-8 py-5 rounded-[2rem] border border-white/5 text-white/20 text-[11px] font-black uppercase tracking-[0.4em] hover:text-white hover:border-white/10 hover:bg-white/[0.02] transition-all disabled:opacity-60 disabled:cursor-not-allowed text-center"
        >
            <span wire:loading.remove wire:target="logout">Terminate Signal</span>
            <span wire:loading wire:target="logout">Ending...</span>
        </button>
    </div>
</div>
