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

Route::get('/wiki/generate', \App\Livewire\Article\GenerateArticle::class)
    ->middleware(['auth'])
    ->name('wiki.generate');

Route::get('/tools/lyrics', \App\Livewire\Article\LyricAnalyzer::class)
    ->name('tools.lyrics');

Route::get('/leaderboard', \App\Livewire\Leaderboard::class)
    ->name('leaderboard');

Route::get('/explore', \App\Livewire\KnowledgeExplorer::class)
    ->name('explore');

Route::get('/search', \App\Livewire\SmartSearch::class)->name('search');
Route::get('/browse', [\App\Http\Controllers\ArticleController::class, 'index'])->name('wiki.index');
Route::get('/browse-old', [\App\Http\Controllers\ArticleController::class, 'index'])->name('browse');
Route::get('/wiki/{article:slug}', [\App\Http\Controllers\ArticleController::class, 'show'])->name('wiki.show');
Route::get('/wiki/{article:slug}/edit', \App\Livewire\Article\Edit::class)
    ->middleware(['auth'])
    ->name('wiki.edit');

Route::get('/user/{user:username}', \App\Livewire\UserProfile::class)->name('profile');

// Custom Admin Panel (Livewire)
Route::middleware(['auth', 'can:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
    Route::get('/articles', \App\Livewire\Admin\Articles::class)->name('admin.articles');
    Route::get('/revisions', \App\Livewire\Admin\Revisions::class)->name('admin.revisions');
    Route::get('/batch-analysis', \App\Livewire\Admin\BatchAnalysis::class)->name('admin.batch-analysis');
    Route::get('/knowledge-graph', \App\Livewire\Admin\KnowledgeGraph::class)->name('admin.knowledge-graph');
    Route::get('/users', \App\Livewire\Admin\Users::class)->name('admin.users');
});

require __DIR__.'/auth.php';
