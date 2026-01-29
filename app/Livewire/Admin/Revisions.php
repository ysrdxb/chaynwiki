<?php

namespace App\Livewire\Admin;

use App\Models\Revision;
use Livewire\Component;
use Livewire\WithPagination;

class Revisions extends Component
{
    use WithPagination;

    public $filterStatus = 'pending';

    public function approve($id)
    {
        $revision = Revision::findOrFail($id);
        
        // Apply changes to article
        $article = $revision->article;
        $article->update($revision->content_snapshot);
        
        $revision->update(['status' => 'approved']);
        
        session()->flash('message', 'Revision approved and synced!');
    }

    public function reject($id)
    {
        $revision = Revision::findOrFail($id);
        $revision->update(['status' => 'rejected']);
        
        session()->flash('message', 'Revision rejected.');
    }

    public function render()
    {
        $revisions = Revision::query()
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->with(['article', 'user'])
            ->latest()
            ->paginate(15);

        return view('livewire.admin.revisions', [
            'revisions' => $revisions
        ])->layout('layouts.admin');
    }
}
