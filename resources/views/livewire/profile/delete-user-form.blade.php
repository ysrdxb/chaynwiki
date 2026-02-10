<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="space-y-8">
    <header class="mb-10">
        <h2 class="text-2xl font-black text-red-500 uppercase tracking-tightest" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            TERMINATE NODE <span class="text-white/10 ml-2">/ DESTRUCTIVE</span>
        </h2>
        <p class="text-[10px] font-black text-white/20 uppercase tracking-[0.3em] mt-2">Request permanent disconnection of this node identifier from the global archive.</p>
    </header>

    <div class="p-8 rounded-3xl bg-red-500/[0.03] border border-red-500/10 backdrop-blur-md mb-8">
        <p class="text-[11px] font-medium text-white/40 leading-relaxed uppercase tracking-wider">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. This action is irreversible.') }}
        </p>
    </div>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="group relative px-8 py-4 bg-red-500/10 hover:bg-red-500 border border-red-500/20 hover:border-red-500 rounded-2xl transition-all duration-500 overflow-hidden shadow-3xl"
    >
        <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="relative z-10 flex items-center gap-4">
            <span class="text-[10px] font-black text-red-500 group-hover:text-white uppercase tracking-[0.4em] transition-colors">{{ __('Terminate Account') }}</span>
            <div class="w-8 h-8 rounded-full bg-red-500/20 group-hover:bg-white/20 flex items-center justify-center transition-colors">
                <svg class="w-4 h-4 text-red-500 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </div>
        </div>
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="p-4 bg-[#0d1117] rounded-[2.5rem] overflow-hidden">
            <div class="p-10 card-premium h-auto !bg-[#161b22]/60 backdrop-blur-md rounded-[2.2rem] border-red-500/20 shadow-3xl">
                <header class="mb-10">
                    <h2 class="text-3xl font-black text-white uppercase tracking-tightest leading-none mb-4" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        FINAL <span class="text-red-500">CONFIRMATION</span>
                    </h2>
                    <p class="text-[11px] font-black text-white/30 uppercase tracking-[0.3em] leading-relaxed">
                        {{ __('To prevent accidental termination, please enter your node access key to authorize the destruction of this identity.') }}
                    </p>
                </header>

                <div class="space-y-3">
                    <x-input-label for="password" value="{{ __('AUTH_KEY') }}" class="text-[10px] font-black text-white/40 uppercase tracking-[0.4em] ml-1" />
                    <div class="relative group">
                        <div class="absolute inset-0 bg-red-500/5 rounded-2xl blur-xl group-focus-within:bg-red-500/10 transition-all duration-500"></div>
                        <x-text-input
                            wire:model="password"
                            id="password"
                            name="password"
                            type="password"
                            class="block w-full h-16 bg-[#0d1117] border-white/5 focus:border-red-500/20 focus:ring-0 rounded-2xl text-sm font-black text-white uppercase tracking-widest px-6 transition-all duration-500"
                            placeholder="••••••••••••"
                        />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 ml-1" />
                </div>

                <div class="mt-12 flex flex-col md:flex-row items-center gap-4">
                    <button type="button" x-on:click="$dispatch('close')" class="w-full md:w-auto px-10 py-5 bg-white/5 hover:bg-white/10 border border-white/5 rounded-2xl text-[10px] font-black text-white uppercase tracking-[0.4em] transition-all shadow-xl">
                        {{ __('Abort Sequence') }}
                    </button>

                    <button type="submit" class="w-full md:flex-1 group relative px-10 py-5 bg-red-500 hover:bg-red-600 rounded-2xl transition-all duration-500 overflow-hidden shadow-3xl">
                        <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative z-10 flex items-center justify-center gap-4">
                            <span class="text-[10px] font-black text-white uppercase tracking-[0.4em]">{{ __('Destruct Node') }}</span>
                            <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center">
                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </div>
                        </div>
                    </button>
                </div>
            </div>
        </form>
    </x-modal>
</section>
