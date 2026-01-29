<?php

namespace App\Livewire\Admin;

use App\Models\Article;
use App\Models\Revision;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $stats = [
            'articles' => Article::count(),
            'users' => User::count(),
            'pending_revisions' => Revision::where('status', 'pending')->count(),
            'total_reputation' => User::sum('reputation_score'),
        ];

        return view('livewire.admin.dashboard', [
            'stats' => $stats,
            'recent_revisions' => Revision::with(['article', 'user'])->latest()->limit(5)->get(),
        ])->layout('layouts.admin');
    }
}
