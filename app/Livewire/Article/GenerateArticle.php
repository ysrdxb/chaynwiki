<?php

namespace App\Livewire\Article;

use App\Services\ArticleGeneratorService;
use App\Services\OllamaService;
use Livewire\Component;

class GenerateArticle extends Component
{
    public string $topic = '';
    public string $category = 'general';
    public bool $isGenerating = false;
    public bool $ollamaAvailable = false;
    
    public ?array $generatedDraft = null;
    public ?string $error = null;
    
    public array $categories = [
        'general' => 'General Topic',
        'song' => 'Song',
        'artist' => 'Artist / Band',
        'genre' => 'Music Genre',
    ];

    public function mount(): void
    {
        $this->checkOllama();
    }

    public function checkOllama(): void
    {
        $ollama = app(OllamaService::class);
        $this->ollamaAvailable = $ollama->isAvailable();
    }

    public function generate(): void
    {
        $this->validate([
            'topic' => 'required|min:2|max:200',
            'category' => 'required|in:' . implode(',', array_keys($this->categories)),
        ]);

        if (!$this->ollamaAvailable) {
            $this->error = 'Ollama is not running. Please start Ollama first.';
            return;
        }

        $this->isGenerating = true;
        $this->error = null;
        $this->generatedDraft = null;

        try {
            $generator = app(ArticleGeneratorService::class);
            $this->generatedDraft = $generator->generateDraft(
                $this->topic,
                $this->category,
                auth()->id()
            );

            if (!$this->generatedDraft) {
                $this->error = 'Failed to generate article. Please try again.';
            }
        } catch (\Exception $e) {
            $this->error = 'An error occurred: ' . $e->getMessage();
        } finally {
            $this->isGenerating = false;
        }
    }

    public function useAsDraft(): void
    {
        if ($this->generatedDraft) {
            session()->flash('draft', $this->generatedDraft);
            $this->redirect(route('wiki.create'));
        }
    }

    public function regenerate(): void
    {
        $this->generate();
    }

    public function clear(): void
    {
        $this->generatedDraft = null;
        $this->error = null;
        $this->topic = '';
    }

    public function render()
    {
        return view('livewire.article.generate-article')
            ->layout('layouts.wiki');
    }
}
