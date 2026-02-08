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

<section class="space-y-6">
    <header>
        <h2 class="text-xl font-black text-white uppercase tracking-tight">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-2 text-xs font-bold text-white/40 uppercase tracking-wider leading-relaxed">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-6 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-red-600 hover:bg-red-500 border-0"
    >{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="p-8 bg-[#161b22] border border-white/5 rounded-2xl overflow-hidden">

            <h2 class="text-xl font-black text-white uppercase tracking-tight">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-4 text-xs font-bold text-white/40 uppercase tracking-wider leading-relaxed">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-8">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    wire:model="password"
                    id="password"
                    name="password"
                    type="password"
                    class="block w-full bg-[#0d1117] border-white/10 focus:border-red-500 focus:ring-red-500/20 rounded-xl"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="px-6 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider border-white/10 bg-white/5 text-white hover:bg-white/10">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="px-6 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-red-600 hover:bg-red-500 border-0">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
