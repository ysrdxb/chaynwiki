<?php

namespace App\Livewire\Article;

use App\Models\Article;
use App\Models\Comment;
use Livewire\Component;

class Comments extends Component
{
    public Article $article;
    public $content = '';
    public $parentId = null;
    public $showReplyForm = null;

    protected $rules = [
        'content' => 'required|min:3|max:1000',
    ];

    public function mount(Article $article)
    {
        $this->article = $article;
    }

    public function submit()
    {
        $this->validate();

        $this->article->comments()->create([
            'user_id' => auth()->id(),
            'content' => $this->content,
            'parent_id' => $this->parentId,
        ]);

        $this->reset(['content', 'parentId', 'showReplyForm']);
        $this->dispatch('comment-added');
    }

    public function setReply($commentId)
    {
        $this->parentId = $commentId;
        $this->showReplyForm = $commentId;
    }

    public function cancelReply()
    {
        $this->reset(['parentId', 'showReplyForm']);
    }

    public function delete($commentId)
    {
        $comment = Comment::find($commentId);
        
        // Authorization check
        if ($comment && $comment->user_id === auth()->id()) {
            $comment->delete();
        }
    }

    public function render()
    {
        $comments = $this->article->comments()
            ->whereNull('parent_id')
            ->with(['user', 'replies.user'])
            ->latest()
            ->get();

        return view('livewire.article.comments', [
            'comments' => $comments
        ]);
    }
}
