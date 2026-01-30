<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h2 class="text-xl font-black text-white uppercase italic tracking-tighter">
            {{ __('Node Identity') }}
        </h2>

        <p class="mt-2 text-[10px] font-black text-white/20 uppercase tracking-widest leading-loose">
            {{ __("Synchronize your account's profile information and primary communication relay.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-8 space-y-6">
        <div>
            <x-input-label for="name" :value="__('Identity Name')" class="text-[9px] font-black text-white/10 uppercase tracking-widest mb-1 ml-1" />
            <x-text-input wire:model="name" id="name" name="name" type="text" class="block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Primary Relay (Email)')" class="text-[9px] font-black text-white/10 uppercase tracking-widest mb-1 ml-1" />
            <x-text-input wire:model="email" id="email" name="email" type="email" class="block w-full" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div class="mt-4 p-4 rounded-xl bg-yellow-500/5 border border-yellow-500/10">
                    <p class="text-[10px] font-black text-yellow-500/60 uppercase tracking-widest">
                        {{ __('Relay verification pending.') }}

                        <button wire:click.prevent="sendVerification" class="underline hover:text-yellow-400 transition-colors">
                            {{ __('Initialize re-verification sequence.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-[9px] font-black text-green-500 uppercase tracking-widest">
                            {{ __('Verification sequence initialized. Check your relay inbox.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-6 pt-4">
            <x-primary-button>{{ __('Commit Changes') }}</x-primary-button>

            <x-action-message class="text-[9px] font-black text-green-500 uppercase tracking-widest" on="profile-updated">
                {{ __('Update Successful.') }}
            </x-action-message>
        </div>
    </form>
</section>
