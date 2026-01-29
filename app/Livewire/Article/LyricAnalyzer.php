<?php

namespace App\Livewire\Article;

use App\Services\LyricAnalysisService;
use App\Services\OllamaService;
use Livewire\Component;

class LyricAnalyzer extends Component
{
    public string $lyrics = '';
    public bool $isAnalyzing = false;
    public bool $ollamaAvailable = false;
    
    public ?array $analysis = null;
    public ?string $error = null;

    public function mount(): void
    {
        $this->checkOllama();
    }

    public function checkOllama(): void
    {
        $this->ollamaAvailable = app(OllamaService::class)->isAvailable();
    }

    public function analyze(): void
    {
        $this->validate([
            'lyrics' => 'required|min:20',
        ]);

        if (!$this->ollamaAvailable) {
            $this->error = 'AI service is not available. Please start Ollama.';
            return;
        }

        $this->isAnalyzing = true;
        $this->error = null;
        $this->analysis = null;

        try {
            $service = app(LyricAnalysisService::class);
            $this->analysis = $service->analyze($this->lyrics);

            if (!$this->analysis) {
                $this->error = 'Analysis failed. Please try again.';
            }
        } catch (\Exception $e) {
            $this->error = 'An error occurred: ' . $e->getMessage();
        } finally {
            $this->isAnalyzing = false;
        }
    }

    public function clear(): void
    {
        $this->lyrics = '';
        $this->analysis = null;
        $this->error = null;
    }

    public function render()
    {
        return view('livewire.article.lyric-analyzer')
            ->layout('layouts.wiki');
    }
}
