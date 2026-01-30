<?php

namespace App\Livewire\Article;

use App\Models\Article;
use App\Services\LyricAnalysisService;
use Livewire\Component;

class LyricInsights extends Component
{
    public Article $article;
    public ?array $analysis = null;
    public bool $isAnalyzing = false;
    public bool $isAvailable = false;

    public function mount(Article $article): void
    {
        $this->article = $article;
        $this->loadAnalysis();
    }

    public function loadAnalysis(): void
    {
        $service = app(LyricAnalysisService::class);
        $cached = $service->getCachedAnalysis($this->article->id);
        
        if ($cached) {
            $this->analysis = [
                'themes' => $cached->themes,
                'mood' => $cached->mood,
                'mood_score' => $cached->mood_score,
                'literary_devices' => $cached->literary_devices,
                'rhyme_scheme' => $cached->rhyme_scheme,
                'summary' => $cached->summary,
                'genre_hints' => $cached->suggested_tags,
            ];
            
            // Add computed rhyme visualization if we have lyrics
            if ($this->article->song && $this->article->song->lyrics) {
                $this->analysis['rhyme_visualization'] = $service->generateRhymeVisualization(
                    $this->article->song->lyrics, 
                    $this->analysis['rhyme_scheme'] ?? 'unknown'
                );
            }
        }
    }

    public function analyze(): void
    {
        if (!$this->article->song || !$this->article->song->lyrics) {
            return;
        }

        $this->isAnalyzing = true;
        
        try {
            $service = app(LyricAnalysisService::class);
            $result = $service->analyze($this->article->song->lyrics, $this->article->id);
            
            if ($result) {
                $this->analysis = $result;
            }
        } catch (\Exception $e) {
            // Log error
        } finally {
            $this->isAnalyzing = false;
        }
    }

    public function render()
    {
        return view('livewire.article.lyric-insights');
    }
}
