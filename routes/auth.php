<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    Livewire\Volt\Volt::route('register', 'pages.auth.register')
        ->name('register');

    Livewire\Volt\Volt::route('login', 'pages.auth.login')
        ->name('login');

    Livewire\Volt\Volt::route('forgot-password', 'pages.auth.forgot-password')
        ->name('password.request');

    Livewire\Volt\Volt::route('reset-password/{token}', 'pages.auth.reset-password')
        ->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Livewire\Volt\Volt::route('verify-email', 'pages.auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Livewire\Volt\Volt::route('confirm-password', 'pages.auth.confirm-password')
        ->name('password.confirm');

    Route::post('logout', \App\Livewire\Actions\Logout::class)
        ->name('logout');
});
