<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Str;

class PulsePlayer extends Component
{
    public $currentArticle = null;
    public $isPlaying = false;
    public $progress = 0;
    public $isVisible = false;
    public $summary = '';
    public $fullContent = '';

    #[On('play-article')]
    public function loadArticle($articleId)
    {
        $this->currentArticle = Article::with(['artist', 'song', 'analysis'])->find($articleId);
        if (!$this->currentArticle) return;

        $this->isPlaying = true;
        $this->isVisible = true;
        $this->progress = 0;
        
        $this->summary = $this->currentArticle->analysis->summary ?? 
                        Str::limit(strip_tags($this->currentArticle->content), 300);

        $this->fullContent = strip_tags($this->currentArticle->content);
        
        $gradient = $this->currentArticle->analysis->ambient_signature['gradient'] ?? ['#3b82f6', '#8b5cf6'];
        $this->dispatch('pulse-started', [
            'gradient' => $gradient,
            'summary' => $this->summary,
            'content' => $this->fullContent
        ]);
    }

    #[On('stop-playback')]
    public function stop()
    {
        $this->isPlaying = false;
        $this->isVisible = false;
        $this->currentArticle = null;
    }

    public function toggle()
    {
        $this->isPlaying = !$this->isPlaying;
    }

    public function render()
    {
        return view('livewire.pulse-player');
    }
}
