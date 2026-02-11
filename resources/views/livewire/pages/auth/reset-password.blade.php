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
    <h2 class="text-[32px] font-bold text-white mb-4">Reset Password</h2>
    <p class="text-white/50 text-[14px] font-medium mb-12">
        Define new security credentials for your account.
    </p>

    <form wire:submit="resetPassword" class="space-y-6">
        <!-- Email Address -->
        <div class="space-y-2">
            <label for="email" class="text-[15px] font-medium text-white/80 ml-1">Email</label>
            <div class="relative group">
                <input 
                    wire:model="email" 
                    id="email" 
                    type="email" 
                    name="email" 
                    required 
                    autofocus 
                    autocomplete="username"
                    placeholder="Enter your email address"
                    class="block w-full px-6 py-3 bg-[#161b22] border border-white/5 rounded-[14px] text-white text-[15px] placeholder-white/20 focus:border-white/10 focus:outline-none transition-all shadow-2xl"
                />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 ml-4" />
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <!-- New Password -->
            <div class="space-y-2">
                <label for="password" class="text-[15px] font-medium text-white/80 ml-1">New Password</label>
                <div class="relative group">
                    <input 
                        wire:model="password" 
                        id="password" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="new-password"
                        placeholder="Create password..."
                        class="block w-full px-6 py-3 bg-[#161b22] border border-white/5 rounded-[14px] text-white text-[15px] placeholder-white/20 focus:border-white/10 focus:outline-none transition-all shadow-2xl"
                    />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 ml-4" />
            </div>

            <!-- Confirm Password -->
            <div class="space-y-2">
                <label for="password_confirmation" class="text-[15px] font-medium text-white/80 ml-1">Confirm Password</label>
                <div class="relative group">
                    <input 
                        wire:model="password_confirmation" 
                        id="password_confirmation" 
                        type="password"
                        name="password_confirmation" 
                        required 
                        autocomplete="new-password"
                        placeholder="Retype password..."
                        class="block w-full px-6 py-3 bg-[#161b22] border border-white/5 rounded-[14px] text-white text-[15px] placeholder-white/20 focus:border-white/10 focus:outline-none transition-all shadow-2xl"
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
            class="group w-full flex items-center justify-between bg-white hover:bg-gray-100 px-8 py-3 rounded-full transition-all duration-300 shadow-2xl shadow-black/40"
        >
            <div class="flex-1 text-center">
                <span wire:loading.remove wire:target="resetPassword" class="text-[#0d1117] text-[17px] font-bold">
                    Reset Password
                </span>
                <span wire:loading wire:target="resetPassword" class="flex items-center justify-center gap-2 text-[#0d1117] text-[17px] font-bold">
                    <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle>
                        <path class="opacity-75" d="M4 12a8 8 0 018-8" stroke-width="4" stroke-linecap="round"></path>
                    </svg>
                    Processing...
                </span>
            </div>
            
            <div class="w-8 h-8 rounded-full bg-[#3b82f6] flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M7 17L17 7M17 7H7M17 7V17"/>
                </svg>
            </div>
        </button>
    </form>
</div>
