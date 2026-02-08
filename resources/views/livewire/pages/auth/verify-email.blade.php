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
    <h2 class="text-xl font-bold text-white mb-4">Verify your email</h2>
    <p class="text-sm text-white/50 mb-6 font-medium">
        We sent a verification link to your email. Click it to activate your account.
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 text-sm text-green-400 font-medium bg-green-400/10 px-4 py-3 rounded-xl border border-green-400/20">
            A new verification link has been sent to your email address.
        </div>
    @endif

    <div class="flex flex-col sm:flex-row gap-4 items-center">
        <button
            type="button"
            wire:click="sendVerification"
            wire:loading.attr="disabled"
            wire:target="sendVerification"
            class="w-full sm:w-auto flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-500 text-white font-bold py-3.5 px-6 rounded-full transition-all hover:scale-[1.02] active:scale-[0.98] shadow-lg shadow-blue-900/20 disabled:opacity-60 disabled:cursor-not-allowed"
        >
            <span wire:loading.remove wire:target="sendVerification" class="flex items-center gap-2">
                Resend verification email
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </span>
            <span wire:loading wire:target="sendVerification" class="flex items-center gap-2">
                <svg class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle>
                    <path class="opacity-75" d="M4 12a8 8 0 018-8" stroke-width="4" stroke-linecap="round"></path>
                </svg>
                Sending...
            </span>
        </button>

        <button
            type="button"
            wire:click="logout"
            wire:loading.attr="disabled"
            wire:target="logout"
            class="w-full sm:w-auto px-6 py-3.5 rounded-full border border-white/10 text-white/60 text-sm font-bold hover:text-white hover:border-white/20 hover:bg-white/5 transition-all disabled:opacity-60 disabled:cursor-not-allowed"
        >
            <span wire:loading.remove wire:target="logout">Log out</span>
            <span wire:loading wire:target="logout">Signing out...</span>
        </button>
    </div>
</div>
