<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section>
    <header class="mb-10">
        <h2 class="text-2xl font-black text-white uppercase tracking-tightest" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            ACCESS KEYS <span class="text-white/10 ml-2">/ ENCRYPTION</span>
        </h2>
        <p class="text-[10px] font-black text-white/20 uppercase tracking-[0.3em] mt-2">Update your node access authentication sequence.</p>
    </header>

    <form wire:submit="updatePassword" class="space-y-8">
        <div class="space-y-3">
            <x-input-label for="update_password_current_password" :value="__('CURRENT ACCESS KEY')" class="text-[10px] font-black text-white/40 uppercase tracking-[0.4em] ml-1" />
            <div class="relative group">
                <div class="absolute inset-0 bg-blue-500/5 rounded-2xl blur-xl group-focus-within:bg-blue-500/10 transition-all duration-500"></div>
                <x-text-input wire:model="current_password" id="update_password_current_password" name="current_password" type="password" class="block w-full h-16 bg-[#0d1117] border-white/5 focus:border-blue-500/20 focus:ring-0 rounded-2xl text-sm font-black text-white uppercase tracking-widest px-6 transition-all duration-500" autocomplete="current-password" placeholder="••••••••••••" />
            </div>
            <x-input-error :messages="$errors->get('current_password')" class="mt-2 ml-1" />
        </div>

        <div class="space-y-3">
            <x-input-label for="update_password_password" :value="__('NEW ACCESS KEY')" class="text-[10px] font-black text-white/40 uppercase tracking-[0.4em] ml-1" />
            <div class="relative group">
                <div class="absolute inset-0 bg-blue-500/5 rounded-2xl blur-xl group-focus-within:bg-blue-500/10 transition-all duration-500"></div>
                <x-text-input wire:model="password" id="update_password_password" name="password" type="password" class="block w-full h-16 bg-[#0d1117] border-white/5 focus:border-blue-500/20 focus:ring-0 rounded-2xl text-sm font-black text-white uppercase tracking-widest px-6 transition-all duration-500" autocomplete="new-password" placeholder="••••••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 ml-1" />
        </div>

        <div class="space-y-3">
            <x-input-label for="update_password_password_confirmation" :value="__('CONFIRM KEY SEQUENCE')" class="text-[10px] font-black text-white/40 uppercase tracking-[0.4em] ml-1" />
            <div class="relative group">
                <div class="absolute inset-0 bg-blue-500/5 rounded-2xl blur-xl group-focus-within:bg-blue-500/10 transition-all duration-500"></div>
                <x-text-input wire:model="password_confirmation" id="update_password_password_confirmation" name="password_confirmation" type="password" class="block w-full h-16 bg-[#0d1117] border-white/5 focus:border-blue-500/20 focus:ring-0 rounded-2xl text-sm font-black text-white uppercase tracking-widest px-6 transition-all duration-500" autocomplete="new-password" placeholder="••••••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 ml-1" />
        </div>

        <div class="flex items-center gap-8 pt-4">
            <button type="submit" class="btn-figma-primary !px-10 !py-4 shadow-3xl">
                <span>{{ __('Flash New Key') }}</span>
                <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
            </button>

            <x-action-message class="flex items-center gap-2 text-[10px] font-black text-green-500 uppercase tracking-[0.3em]" on="password-updated">
                <div class="w-1.5 h-1.5 rounded-full bg-current"></div>
                {{ __('Key Matrix Updated') }}
            </x-action-message>
        </div>
    </form>
</section>
