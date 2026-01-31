<?php

namespace App\Livewire;

use App\Services\GamificationService;
use Livewire\Component;

class Leaderboard extends Component
{
    public array $leaderboard = [];
    public array $rankings = []; // Top Nodes (Articles)
    
    // Filters
    public string $period = 'all'; // all, weekly, monthly
    public string $activeFilter = 'All'; // All, Recordings, Artist Profiles, Classifications
    public string $activeSort = 'Impact Score'; // Impact Score, Metadata Growth, Total Connections

    public bool $isLoading = false;

    public function mount(): void
    {
        $this->loadData();
    }

    public function loadData(): void
    {
        $this->isLoading = true;
        
        $service = app(GamificationService::class);
        
        // Load Contributors (Leaderboard)
        $this->leaderboard = $service->getLeaderboard(10, $this->period);

        // Load Top Nodes (Rankings)
        $this->rankings = $service->getTopNodes(
            $this->activeFilter,
            $this->activeSort,
            20
        );

        $this->isLoading = false;
    }

    public function setFilter(string $filter): void
    {
        $this->activeFilter = $filter;
        $this->loadData();
    }

    public function setSort(string $sort): void
    {
        $this->activeSort = $sort;
        $this->loadData();
    }

    public function setPeriod(string $period): void
    {
        $this->period = $period;
        $this->loadData();
    }

    public function render()
    {
        return view('livewire.leaderboard')
            ->layout('layouts.wiki');
    }
}
