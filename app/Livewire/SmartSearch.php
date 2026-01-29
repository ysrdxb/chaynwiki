<?php

namespace App\Livewire;

use App\Services\SmartSearchService;
use Livewire\Component;
use Livewire\WithPagination;

class SmartSearch extends Component
{
    use WithPagination;

    public string $query = '';
    public string $category = 'all';
    public string $sortBy = 'relevance';
    
    public array $suggestions = [];
    public array $trending = [];
    public array $categories = [];
    public bool $showSuggestions = false;

    protected $queryString = [
        'query' => ['except' => ''],
        'category' => ['except' => 'all'],
        'sortBy' => ['except' => 'relevance'],
    ];

    public function mount(): void
    {
        $service = app(SmartSearchService::class);
        $this->trending = $service->getTrendingSearches(8);
        $this->categories = $service->getCategoryFacets();
    }

    public function updatedQuery(): void
    {
        $this->resetPage();
        
        if (strlen($this->query) >= 2) {
            $service = app(SmartSearchService::class);
            $this->suggestions = $service->getSuggestions($this->query, 5);
            $this->showSuggestions = !empty($this->suggestions);
        } else {
            $this->showSuggestions = false;
        }
    }

    public function updatedCategory(): void
    {
        $this->resetPage();
    }

    public function updatedSortBy(): void
    {
        $this->resetPage();
    }

    public function selectSuggestion(string $suggestion): void
    {
        $this->query = $suggestion;
        $this->showSuggestions = false;
    }

    public function search(): void
    {
        $this->showSuggestions = false;
    }

    public function clearSearch(): void
    {
        $this->query = '';
        $this->category = 'all';
        $this->sortBy = 'relevance';
        $this->showSuggestions = false;
        $this->resetPage();
    }

    public function render()
    {
        $results = null;
        
        if (!empty($this->query)) {
            $service = app(SmartSearchService::class);
            $results = $service->search(
                $this->query,
                $this->category === 'all' ? null : $this->category,
                $this->sortBy,
                12,
                auth()->id()
            );
        }

        return view('livewire.smart-search', [
            'results' => $results,
        ])->layout('layouts.wiki');
    }
}
