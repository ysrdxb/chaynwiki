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
    <h2 class="text-xl font-bold text-white mb-4 tracking-tight">Verify your email</h2>
    <p class="text-sm text-white/50 mb-8 font-medium italic">
        We sent a verification link to your email. Click it to activate your account.
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 text-sm text-green-400 font-bold bg-green-400/10 px-5 py-4 rounded-2xl border border-green-400/20 flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            A new verification link has been sent to your email address.
        </div>
    @endif

    <div class="flex flex-col gap-4">
        <!-- Resend Button -->
        <button
            type="button"
            wire:click="sendVerification"
            wire:loading.attr="disabled"
            wire:target="sendVerification"
            class="group w-full flex items-center justify-center bg-white hover:bg-gray-100 text-[#0d1117] font-black py-1.5 px-1.5 rounded-full transition-all hover:scale-[1.01] active:scale-[0.99] shadow-xl shadow-black/20 disabled:opacity-70 disabled:cursor-not-allowed"
        >
            <div class="flex-1 py-3 px-6 flex items-center justify-center gap-2">
                <span wire:loading.remove wire:target="sendVerification">Resend verification email</span>
                <span wire:loading wire:target="sendVerification" class="flex items-center gap-2">
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

        <!-- Logout Button -->
        <button
            type="button"
            wire:click="logout"
            wire:loading.attr="disabled"
            wire:target="logout"
            class="w-full px-6 py-4 rounded-2xl border border-white/10 text-white/50 text-sm font-bold hover:text-white hover:border-white/20 hover:bg-white/5 transition-all disabled:opacity-60 disabled:cursor-not-allowed text-center"
        >
            <span wire:loading.remove wire:target="logout">Log out</span>
            <span wire:loading wire:target="logout">Signing out...</span>
        </button>
    </div>
</div>
