<?php

namespace App\Livewire\Article;

use Livewire\Component;

class PlayButton extends Component
{
    public $articleId;
    public $label = 'Listen to Audio Pulse';

    public function play()
    {
        $this->dispatch('play-article', articleId: $this->articleId);
    }

    public function render()
    {
        return view('livewire.article.play-button');
    }
}
