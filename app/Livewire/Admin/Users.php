<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public $search = '';
    public $filterRole = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updateRole($userId, $role)
    {
        $user = User::findOrFail($userId);
        $user->update(['role' => $role]);
        session()->flash('message', "User role updated to {$role}.");
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%")->orWhere('email', 'like', "%{$this->search}%"))
            ->when($this->filterRole, fn($q) => $q->where('role', $this->filterRole))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.users', [
            'users' => $users
        ])->layout('layouts.admin');
    }
}
