<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Http\Controllers\HomeController::class)->name('home');
Route::get('/test', function () {
    return 'Routing is working!';
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('settings', 'profile')
    ->middleware(['auth'])
    ->name('settings'); // Renamed from profile to settings to avoid confusion

Route::get('/wiki/create', \App\Livewire\Article\Create::class)
    ->middleware(['auth'])
    ->name('wiki.create');

Route::get('/search', [\App\Http\Controllers\ArticleController::class, 'index'])->name('search');
Route::get('/browse', [\App\Http\Controllers\ArticleController::class, 'index'])->name('wiki.index');
Route::get('/browse-old', [\App\Http\Controllers\ArticleController::class, 'index'])->name('browse');
Route::get('/wiki/{article:slug}', [\App\Http\Controllers\ArticleController::class, 'show'])->name('wiki.show');
Route::get('/wiki/{article:slug}/edit', \App\Livewire\Article\Edit::class)
    ->middleware(['auth'])
    ->name('wiki.edit');

Route::get('/user/{user:username}', \App\Livewire\UserProfile::class)->name('profile');

require __DIR__.'/auth.php';
