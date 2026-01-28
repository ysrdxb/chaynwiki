<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

class UserProfile extends Component
{
    public User $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    #[Layout('layouts.wiki')]
    public function render()
    {
        return view('livewire.user-profile', [
            'articles' => $this->user->articles()->latest()->take(10)->get(),
            'totalViews' => $this->user->articles()->sum('view_count'),
            'revisionsCount' => $this->user->revisions()->where('status', 'approved')->count(),
        ]);
    }
}
