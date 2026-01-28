<?php

namespace App\Livewire\Article;

use App\Models\Article;
use Livewire\Component;

class BookmarkButton extends Component
{
    public Article $article;
    public bool $isBookmarked = false;

    public function mount(Article $article)
    {
        $this->article = $article;
        $this->updateStatus();
    }

    public function toggle()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if ($this->isBookmarked) {
            $this->article->bookmarks()->where('user_id', auth()->id())->delete();
            $this->isBookmarked = false;
        } else {
            $this->article->bookmarks()->create([
                'user_id' => auth()->id()
            ]);
            $this->isBookmarked = true;
        }
    }

    public function updateStatus()
    {
        if (auth()->check()) {
            $this->isBookmarked = $this->article->bookmarks()->where('user_id', auth()->id())->exists();
        }
    }

    public function render()
    {
        return view('livewire.article.bookmark-button');
    }
}
