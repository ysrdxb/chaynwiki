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
        <h2 class="text-xl font-black text-white uppercase italic tracking-tighter">
            {{ __('Node Termination') }}
        </h2>

        <p class="mt-2 text-[10px] font-black text-white/20 uppercase tracking-widest leading-loose">
            {{ __('Termination of this node will permanently purge all associated metadata and neural associations from the archive. This action is irreversible.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-8 py-3 rounded-xl font-black text-[9px] uppercase tracking-widest"
    >{{ __('Initialize Shutdown') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="p-8 bg-secondary border border-white/5 rounded-2xl overflow-hidden">

            <h2 class="text-xl font-black text-white uppercase italic tracking-tighter">
                {{ __('Confirm Termination') }}
            </h2>

            <p class="mt-4 text-[10px] font-black text-white/20 uppercase tracking-widest leading-loose">
                {{ __('Enter your authorization cipher to permanently de-initialize this node and purge all associated records.') }}
            </p>

            <div class="mt-8">
                <x-input-label for="password" value="{{ __('Cipher') }}" class="sr-only" />

                <x-text-input
                    wire:model="password"
                    id="password"
                    name="password"
                    type="password"
                    class="block w-full"
                    placeholder="{{ __('Enter Cipher') }}"
                />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-10 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="px-6 py-2.5 rounded-xl font-black text-[9px] uppercase tracking-widest border-white/5 bg-white/5 text-white">
                    {{ __('Abort') }}
                </x-secondary-button>

                <x-danger-button class="px-6 py-2.5 rounded-xl font-black text-[9px] uppercase tracking-widest">
                    {{ __('Execute Purge') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
