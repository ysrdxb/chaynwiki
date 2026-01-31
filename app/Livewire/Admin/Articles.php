<?php

namespace App\Livewire\Admin;

use App\Models\Article;
use Livewire\Component;
use Livewire\WithPagination;

class Articles extends Component
{
    use WithPagination;

    public $search = '';
    public $filterCategory = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteArticle($id)
    {
        $article = Article::find($id);
        if ($article) {
            $article->delete();
            session()->flash('message', 'Article moved to archive.');
        }
    }

    public function toggleFeatured($id)
    {
        $article = Article::find($id);
        if ($article) {
            $article->update(['is_featured' => !$article->is_featured]);
        }
    }

    public function render()
    {
        $articles = Article::query()
            ->with('user')
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->when($this->filterCategory, fn($q) => $q->where('category', $this->filterCategory))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.articles', [
            'articles' => $articles
        ])->layout('layouts.admin');
    }
}
