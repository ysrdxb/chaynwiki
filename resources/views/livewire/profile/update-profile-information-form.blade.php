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
            $this->redirectIntended(default: route('dashboard'));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header class="mb-10">
        <h2 class="text-2xl font-black text-white uppercase tracking-tightest italic" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            NODE IDENTIFICATION <span class="text-white/10 ml-2">/ PROFILE</span>
        </h2>
        <p class="text-[10px] font-black text-white/20 uppercase tracking-[0.3em] mt-2 italic">Synchronize your display credentials with the global node.</p>
    </header>

    <form wire:submit="updateProfileInformation" class="space-y-8">
        <div class="space-y-3">
            <x-input-label for="name" :value="__('DISPLAY NAME')" class="text-[10px] font-black text-white/40 uppercase tracking-[0.4em] ml-1" />
            <div class="relative group">
                <div class="absolute inset-0 bg-blue-500/5 rounded-2xl blur-xl group-focus-within:bg-blue-500/10 transition-all duration-500"></div>
                <x-text-input wire:model="name" id="name" name="name" type="text" class="block w-full h-16 bg-[#0d1117] border-white/5 focus:border-blue-500/20 focus:ring-0 rounded-2xl text-sm font-black text-white uppercase tracking-widest px-6 transition-all duration-500 placeholder:text-white/5" required autofocus autocomplete="name" placeholder="NODE_IDENTIFIER" />
            </div>
            <x-input-error class="mt-2 ml-1" :messages="$errors->get('name')" />
        </div>

        <div class="space-y-3">
            <x-input-label for="email" :value="__('EMAIL ADDRESS')" class="text-[10px] font-black text-white/40 uppercase tracking-[0.4em] ml-1" />
            <div class="relative group">
                <div class="absolute inset-0 bg-blue-500/5 rounded-2xl blur-xl group-focus-within:bg-blue-500/10 transition-all duration-500"></div>
                <x-text-input wire:model="email" id="email" name="email" type="email" class="block w-full h-16 bg-[#0d1117] border-white/5 focus:border-blue-500/20 focus:ring-0 rounded-2xl text-sm font-black text-white uppercase tracking-widest px-6 transition-all duration-500 placeholder:text-white/5" required autocomplete="username" placeholder="NODE_TRANSMISSION_MAIL" />
            </div>
            <x-input-error class="mt-2 ml-1" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div class="mt-6 p-6 rounded-3xl bg-red-500/[0.03] border border-red-500/10 backdrop-blur-md">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-red-500/10 flex items-center justify-center text-red-500 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-[10px] font-black text-red-500 uppercase tracking-widest mb-1 italic">
                                {{ __('Email Verification Required') }}
                            </p>
                            <p class="text-[11px] font-medium text-white/40 mb-3">Your node credentials are currently unverified.</p>

                            <button wire:click.prevent="sendVerification" class="text-[10px] font-black text-white uppercase tracking-[0.2em] px-4 py-2 bg-white/5 rounded-lg hover:bg-white/10 transition-all border border-white/5">
                                {{ __('Resend Verification Segment') }}
                            </button>
                        </div>
                    </div>

                    @if (session('status') === 'verification-link-sent')
                        <div class="mt-4 flex items-center gap-3 text-green-500">
                            <div class="w-1.5 h-1.5 rounded-full bg-current animate-pulse"></div>
                            <p class="text-[10px] font-black uppercase tracking-widest">
                                {{ __('Transmission re-dispatched to your terminal.') }}
                            </p>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-8 pt-4">
            <button type="submit" class="btn-figma-primary !px-10 !py-4 shadow-3xl">
                <span>{{ __('Commit Changes') }}</span>
                <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                </div>
            </button>

            <x-action-message class="flex items-center gap-2 text-[10px] font-black text-green-500 uppercase tracking-[0.3em] italic" on="profile-updated">
                <div class="w-1.5 h-1.5 rounded-full bg-current"></div>
                {{ __('Sync Successful') }}
            </x-action-message>
        </div>
    </form>
</section>
