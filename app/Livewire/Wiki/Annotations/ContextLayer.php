<?php

namespace App\Livewire\Wiki\Annotations;

use App\Models\Annotation;
use App\Models\Article;
use Livewire\Component;

class ContextLayer extends Component
{
    public int $articleId;
    public string $contextType = 'lyrics'; // 'bio', 'lyrics'
    public bool $isAnnotating = false;
    
    // For rendering highlights
    public $annotations = [];
    
    // For creating new annotation
    public $selection = null;
    public $newContent = '';

    public function mount(int $articleId, string $contextType = 'lyrics')
    {
        $this->articleId = $articleId;
        $this->contextType = $contextType;
        $this->loadAnnotations();
    }

    public function loadAnnotations()
    {
        $this->annotations = Annotation::where('article_id', $this->articleId)
            ->where('context_type', $this->contextType)
            ->with('user')
            ->orderBy('range_start')
            ->get()
            ->toArray();
    }

    public function saveAnnotation($selectionData)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->validate([
            'newContent' => 'required|min:5|max:1000',
        ]);

        Annotation::create([
            'user_id' => auth()->id(),
            'article_id' => $this->articleId,
            'highlighted_text' => $selectionData['text'],
            'range_start' => $selectionData['start'],
            'range_end' => $selectionData['end'],
            'context_type' => $this->contextType,
            'content' => $this->newContent,
            'votes' => 0,
            'is_verified' => auth()->user()->can('verify-annotations') ?? false,
        ]);

        $this->loadAnnotations();
        $this->newContent = '';
        $this->isAnnotating = false;
        $this->dispatch('annotation-saved');
    }

    public function render()
    {
        return view('livewire.wiki.annotations.context-layer');
    }
}
