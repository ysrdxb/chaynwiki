<?php

namespace App\Livewire\Admin;

use App\Models\Revision;
use Livewire\Component;
use Livewire\WithPagination;

class Revisions extends Component
{
    use WithPagination;

    public $filterStatus = 'pending';

    public function approve($id, \App\Services\ReputationService $reputation, \App\Services\CacheService $cache)
    {
        $revision = Revision::findOrFail($id);
        
        // Apply changes to article
        $article = $revision->article;
        $article->update($revision->content_snapshot);
        
        // Clear caches and reset AI analysis
        $cache->clearArticleCache($article->id);
        $article->analysis()?->delete();
        
        $revision->update([
            'status' => 'approved',
            'moderated_by' => auth()->id(),
            'moderated_at' => now(),
        ]);

        // Award reputation to the contributor
        if ($revision->user) {
            $reputation->award(
                $revision->user, 
                \App\Services\ReputationService::POINTS_REVISION_APPROVED, 
                "Consensus: Revision approved for '{$article->title}'"
            );
        }
        
        session()->flash('message', 'Revision approved, caches flushed, and AI re-analysis queued!');
    }

    public function reject($id)
    {
        $revision = Revision::findOrFail($id);
        $revision->update([
            'status' => 'rejected',
            'moderated_by' => auth()->id(),
            'moderated_at' => now(),
        ]);
        
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
