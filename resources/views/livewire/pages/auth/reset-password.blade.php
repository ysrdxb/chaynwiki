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
    <h2 class="text-[32px] font-black text-white uppercase tracking-tightest mb-4" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        <span class="text-blue-500">Reset</span> / Node Security
    </h2>
    <p class="text-white/20 text-[11px] font-black uppercase tracking-[0.4em] mb-12">
        Token verified. Define new security credentials for your node.
    </p>

    <form wire:submit="resetPassword" class="space-y-6">
        <!-- Email Address -->
        <div class="space-y-3">
            <label for="email" class="text-[10px] font-black text-white/20 uppercase tracking-[0.4em] ml-4">Access Identifier</label>
            <div class="relative group">
                <input 
                    wire:model="email" 
                    id="email" 
                    type="email" 
                    name="email" 
                    required 
                    autofocus 
                    autocomplete="username"
                    placeholder="Enter node identifier..."
                    class="block w-full px-8 py-5 bg-white/[0.03] border border-white/5 rounded-[2rem] text-white text-[13px] font-black uppercase tracking-widest placeholder-white/10 focus:border-blue-500/30 focus:bg-white/[0.05] focus:outline-none focus:ring-4 focus:ring-blue-500/5 transition-all shadow-2xl"
                />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 ml-4" />
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <!-- New Password -->
            <div class="space-y-3">
                <label for="password" class="text-[10px] font-black text-white/20 uppercase tracking-[0.4em] ml-4">New Secure Key</label>
                <div class="relative group">
                    <input 
                        wire:model="password" 
                        id="password" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="new-password"
                        placeholder="Create key..."
                        class="block w-full px-8 py-5 bg-white/[0.03] border border-white/5 rounded-[2rem] text-white text-[13px] font-black uppercase tracking-widest placeholder-white/10 focus:border-blue-500/30 focus:bg-white/[0.05] focus:outline-none focus:ring-4 focus:ring-blue-500/5 transition-all shadow-2xl"
                    />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 ml-4" />
            </div>

            <!-- Confirm Password -->
            <div class="space-y-3">
                <label for="password_confirmation" class="text-[10px] font-black text-white/20 uppercase tracking-[0.4em] ml-4">Verify Key</label>
                <div class="relative group">
                    <input 
                        wire:model="password_confirmation" 
                        id="password_confirmation" 
                        type="password"
                        name="password_confirmation" 
                        required 
                        autocomplete="new-password"
                        placeholder="Retype key..."
                        class="block w-full px-8 py-5 bg-white/[0.03] border border-white/5 rounded-[2rem] text-white text-[13px] font-black uppercase tracking-widest placeholder-white/10 focus:border-blue-500/30 focus:bg-white/[0.05] focus:outline-none focus:ring-4 focus:ring-blue-500/5 transition-all shadow-2xl"
                    />
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 ml-4" />
            </div>
        </div>

        <!-- Submit Button -->
        <button 
            type="submit" 
            wire:loading.attr="disabled" 
            wire:target="resetPassword"
            class="btn-figma-primary !w-full !py-5 !rounded-[2rem] shadow-2xl shadow-blue-500/10"
        >
            <span wire:loading.remove wire:target="resetPassword">Finalize Key Update</span>
            <span wire:loading wire:target="resetPassword" class="flex items-center gap-2">
                <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle>
                    <path class="opacity-75" d="M4 12a8 8 0 018-8" stroke-width="4" stroke-linecap="round"></path>
                </svg>
                Processing...
            </span>
            
            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </div>
        </button>
    </form>
</div>
