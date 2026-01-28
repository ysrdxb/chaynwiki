<?php

namespace App\Livewire\Article;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class VoteButton extends Component
{
    public Model $model;
    public $score = 0;
    public $userVote = 0; // 0, 1, or -1

    public function mount(Model $model)
    {
        $this->model = $model;
        $this->updateScore();
        
        if (auth()->check()) {
            $vote = $model->votes()->where('user_id', auth()->id())->first();
            $this->userVote = $vote ? $vote->value : 0;
        }
    }

    public function vote($value)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $existingVote = $this->model->votes()->where('user_id', auth()->id())->first();

        if ($existingVote) {
            if ($existingVote->value === $value) {
                // Toggle off (remove vote)
                $existingVote->delete();
                $this->userVote = 0;
            } else {
                // Change vote
                $existingVote->update(['value' => $value]);
                $this->userVote = $value;
            }
        } else {
            // New vote
            $this->model->votes()->create([
                'user_id' => auth()->id(),
                'value' => $value
            ]);
            $this->userVote = $value;
        }

        $this->updateScore();
    }

    public function updateScore()
    {
        // Re-calculate total score
        $this->score = $this->model->votes()->sum('value');
        
        // Optimistic update of denormalized columns if they exist (optional)
        if (isset($this->model->upvotes)) {
            $this->model->update([
                'upvotes' => $this->model->votes()->where('value', 1)->count(),
                'downvotes' => $this->model->votes()->where('value', -1)->count(),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.article.vote-button');
    }
}
