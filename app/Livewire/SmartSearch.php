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
        'query' => ['except' => '', 'as' => 'q'],
        'category' => ['except' => 'all'],
        'sortBy' => ['except' => 'relevance'],
    ];

    public function mount(): void
    {
        // Read 'q' parameter from URL if present
        if (request()->has('q') && empty($this->query)) {
            $this->query = request()->get('q');
        }
        
        $service = app(SmartSearchService::class);
        $this->trending = $service->getTrendingSearches(8);
        $this->categories = $service->getCategoryFacets();
    }

    public function updatedQuery(): void
    {
        $this->resetPage();
        
        // Suggestion fetching removed as per user request (redundant on main search page)
        $this->showSuggestions = false;
    }

    public function updatedCategory(): void
    {
        $this->resetPage();
    }

    public function updatedSortBy(): void
    {
        $this->resetPage();
    }

    public function selectSuggestion($suggestion): void
    {
        if (is_array($suggestion)) {
            if (!empty($suggestion['url'])) {
                $this->redirect($suggestion['url']);
                return;
            }
            $this->query = $suggestion['title'];
        } else {
            $this->query = $suggestion;
        }
        
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

    public function requestArchivalEntry($title, $cat = 'general'): void
    {
        if (!auth()->check()) {
            $this->redirect(route('login'));
            return;
        }

        $exists = \App\Models\Wantlist::where('title', $title)->where('status', 'pending')->first();
        
        if ($exists) {
            // Upvote instead
            if (!$exists->voters()->where('user_id', auth()->id())->exists()) {
                $exists->increment('votes');
                $exists->voters()->attach(auth()->id());
                session()->flash('message', 'Acquisition request prioritized!');
            } else {
                session()->flash('message', 'You have already requested this target.');
            }
        } else {
            $req = \App\Models\Wantlist::create([
                'user_id' => auth()->id(),
                'title' => $title,
                'category' => $cat,
                'status' => 'pending',
                'votes' => 1
            ]);
            $req->voters()->attach(auth()->id());
            session()->flash('message', 'Target added to Neural Map Wantlist!');
        }
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
