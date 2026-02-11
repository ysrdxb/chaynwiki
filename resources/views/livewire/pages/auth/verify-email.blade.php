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
    <h2 class="text-[32px] font-bold text-white mb-4">Verify Email</h2>
    <p class="text-white/50 text-[14px] font-medium mb-12">
        Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-10 p-4 rounded-[14px] bg-green-500/10 border border-green-500/20 text-green-400 text-[14px] font-medium flex items-center gap-4 shadow-2xl">
            <div class="w-8 h-8 rounded-full bg-green-500/10 flex items-center justify-center shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
            </div>
            A new verification link has been sent to your email address.
        </div>
    @endif

    <div class="flex flex-col gap-6">
        <!-- Resend Button -->
        <button
            type="button"
            wire:click="sendVerification"
            wire:loading.attr="disabled"
            wire:target="sendVerification"
            class="group w-full flex items-center justify-between bg-white hover:bg-gray-100 px-8 py-3 rounded-full transition-all duration-300 shadow-2xl shadow-black/40"
        >
            <div class="flex-1 text-center">
                <span wire:loading.remove wire:target="sendVerification" class="text-[#0d1117] text-[17px] font-bold">
                    Resend Verification Email
                </span>
                <span wire:loading wire:target="sendVerification" class="flex items-center justify-center gap-2 text-[#0d1117] text-[17px] font-bold">
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

        <!-- Logout Button -->
        <button
            type="button"
            wire:click="logout"
            wire:loading.attr="disabled"
            wire:target="logout"
            class="w-full py-3 rounded-full border border-white/5 text-white/40 text-[14px] font-medium hover:text-white hover:border-white/10 hover:bg-white/[0.05] transition-all disabled:opacity-60 disabled:cursor-not-allowed text-center"
        >
            <span wire:loading.remove wire:target="logout">Log Out</span>
            <span wire:loading wire:target="logout">Logging out...</span>
        </button>
    </div>
</div>
