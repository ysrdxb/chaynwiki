<?php

namespace App\Livewire\Article;

use App\Models\Article;
use App\Models\Revision;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class Edit extends Component
{
    use WithFileUploads;

    public Article $article;
    public $title;
    public $category;
    public $content;
    public $excerpt;
    public $featured_image;
    public $change_summary;

    protected $rules = [
        'title' => 'required|string|max:255',
        'category' => 'required|in:song,artist,genre,playlist,term',
        'content' => 'required|string',
        'excerpt' => 'nullable|string|max:500',
        'featured_image' => 'nullable|image|max:2048',
        'change_summary' => 'required|string|min:5|max:255',
    ];

    public function mount(Article $article)
    {
        $this->article = $article;
        $this->title = $article->title;
        $this->category = $article->category;
        $this->content = $article->content;
        $this->excerpt = $article->excerpt;
    }

    public function submit(\App\Services\CacheService $cache)
    {
        $this->validate();

        $data = [
            'category' => $this->category,
            'title' => $this->title,
            'content' => $this->content,
            'excerpt' => $this->excerpt,
        ];

        if ($this->featured_image) {
            $data['featured_image'] = $this->featured_image->store('articles', 'public');
        }

        $isModerator = auth()->user()->isModerator();

        if ($isModerator) {
            // Apply changes directly and create an approved revision record
            $this->article->update($data);
            
            // Clear cache and reset AI
            $cache->clearArticleCache($this->article->id);
            $this->article->analysis()?->delete();

            Revision::create([
                'article_id' => $this->article->id,
                'user_id' => auth()->id(),
                'content_snapshot' => $data,
                'change_summary' => $this->change_summary,
                'status' => 'approved',
            ]);

            session()->flash('message', 'Article updated successfully.');
        } else {
            // Propose an edit
            Revision::create([
                'article_id' => $this->article->id,
                'user_id' => auth()->id(),
                'content_snapshot' => $data,
                'change_summary' => $this->change_summary,
                'status' => 'pending',
            ]);

            session()->flash('message', 'Your edit has been submitted for moderation.');
        }

        return redirect()->route('wiki.show', $this->article->slug);
    }

    public function render()
    {
        return view('livewire.article.edit')
            ->layout('layouts.wiki');
    }
}
