<?php

namespace App\Livewire\Admin;

use App\Models\Article;
use App\Services\LyricAnalysisService;
use Livewire\Component;

class BatchAnalysis extends Component
{
    public $selectedArticles = [];
    public $isProcessing = false;
    public $results = null;

    public function process()
    {
        if (empty($this->selectedArticles)) {
            session()->flash('error', 'No articles selected.');
            return;
        }

        $this->isProcessing = true;
        
        try {
            $service = app(LyricAnalysisService::class);
            $this->results = $service->batchProcess($this->selectedArticles);
            session()->flash('message', 'Batch processing complete!');
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }

        $this->isProcessing = false;
    }

    public function render()
    {
        $articles = Article::where('category', 'song')
            ->latest()
            ->paginate(20);

        return view('livewire.admin.batch-analysis', [
            'articles' => $articles
        ])->layout('layouts.admin');
    }
}
