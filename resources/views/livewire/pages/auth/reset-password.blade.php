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
    <h2 class="text-xl font-bold text-white mb-4 tracking-tight">Set a new password</h2>
    <p class="text-sm text-white/50 mb-8 font-medium">Choose a strong password you haven’t used before.</p>

    <form wire:submit="resetPassword" class="space-y-6">
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-bold text-white mb-2 tracking-wide">Email</label>
            <input 
                wire:model="email" 
                id="email" 
                class="block w-full px-5 py-4 bg-white/[0.03] border border-white/10 rounded-2xl text-white placeholder-white/20 focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all font-medium outline-none"
                type="email" 
                name="email" 
                required 
                autofocus 
                autocomplete="username"
                placeholder="Enter Email Address"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- New Password -->
        <div>
            <label for="password" class="block text-sm font-bold text-white mb-2 tracking-wide">New Password</label>
            <input 
                wire:model="password" 
                id="password" 
                class="block w-full px-5 py-4 bg-white/[0.03] border border-white/10 rounded-2xl text-white placeholder-white/20 focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all font-medium outline-none"
                type="password" 
                name="password" 
                required 
                autocomplete="new-password"
                placeholder="Enter your Password"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-bold text-white mb-2 tracking-wide">Confirm Password</label>
            <input 
                wire:model="password_confirmation" 
                id="password_confirmation" 
                class="block w-full px-5 py-4 bg-white/[0.03] border border-white/10 rounded-2xl text-white placeholder-white/20 focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all font-medium outline-none"
                type="password"
                name="password_confirmation" 
                required 
                autocomplete="new-password"
                placeholder="Confirm your Password"
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <button 
            type="submit" 
            wire:loading.attr="disabled" 
            wire:target="resetPassword"
            class="group w-full flex items-center justify-center bg-white hover:bg-gray-100 text-[#0d1117] font-black py-1.5 px-1.5 rounded-full transition-all hover:scale-[1.01] active:scale-[0.99] shadow-xl shadow-black/20 disabled:opacity-70 disabled:cursor-not-allowed"
        >
            <div class="flex-1 py-3 px-6 flex items-center justify-center gap-2">
                <span wire:loading.remove wire:target="resetPassword">Reset Password</span>
                <span wire:loading wire:target="resetPassword" class="flex items-center gap-2">
                    <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle>
                        <path class="opacity-75" d="M4 12a8 8 0 018-8" stroke-width="4" stroke-linecap="round"></path>
                    </svg>
                    Updating...
                </span>
            </div>
            
            <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center shrink-0 shadow-inner">
                <svg class="w-5 h-5 text-white transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </div>
        </button>
    </form>
</div>
