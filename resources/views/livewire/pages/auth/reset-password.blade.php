<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;

new #[Layout('layouts.guest')] class extends Component
{
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));

            return;
        }

        Session::flash('status', __($status));

        $this->redirectRoute('login', navigate: true);
    }
}; ?>

<div>
    <h2 class="text-xl font-bold text-white mb-4">Set a new password</h2>
    <p class="text-sm text-white/50 mb-6">Choose a strong password you haven’t used before.</p>

    <form wire:submit="resetPassword" class="space-y-6">
        <div>
            <label for="email" class="block text-sm font-bold text-white/80 mb-2">Email</label>
            <input 
                wire:model="email" 
                id="email" 
                class="block w-full px-4 py-3.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-[#64748b] focus:border-[#38bdf8] focus:ring-2 focus:ring-[#38bdf8]/20 transition-all font-medium"
                type="email" 
                name="email" 
                required 
                autofocus 
                autocomplete="username"
                placeholder="Enter Email Address"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="block text-sm font-bold text-white/80 mb-2">New Password</label>
            <input 
                wire:model="password" 
                id="password" 
                class="block w-full px-4 py-3.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-[#64748b] focus:border-[#38bdf8] focus:ring-2 focus:ring-[#38bdf8]/20 transition-all font-medium"
                type="password" 
                name="password" 
                required 
                autocomplete="new-password"
                placeholder="Enter your Password"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-bold text-white/80 mb-2">Confirm Password</label>
            <input 
                wire:model="password_confirmation" 
                id="password_confirmation" 
                class="block w-full px-4 py-3.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-[#64748b] focus:border-[#38bdf8] focus:ring-2 focus:ring-[#38bdf8]/20 transition-all font-medium"
                type="password"
                name="password_confirmation" 
                required 
                autocomplete="new-password"
                placeholder="Confirm your Password"
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button 
            type="submit" 
            wire:loading.attr="disabled" 
            wire:target="resetPassword"
            class="w-full flex items-center justify-center gap-2 bg-[#38bdf8] hover:bg-[#7dd3fc] text-[#0a0e14] font-bold py-4 rounded-full transition-all hover:scale-[1.02] active:scale-[0.98] shadow-lg shadow-[#38bdf8]/25 disabled:opacity-60 disabled:cursor-not-allowed"
        >
            <span wire:loading.remove wire:target="resetPassword" class="flex items-center gap-2">
                Reset Password
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </span>
            <span wire:loading wire:target="resetPassword" class="flex items-center gap-2">
                <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle>
                    <path class="opacity-75" d="M4 12a8 8 0 018-8" stroke-width="4" stroke-linecap="round"></path>
                </svg>
                Updating...
            </span>
        </button>
    </form>
</div>
