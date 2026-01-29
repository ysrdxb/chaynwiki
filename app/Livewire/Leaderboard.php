<?php

namespace App\Livewire;

use App\Services\GamificationService;
use Livewire\Component;

class Leaderboard extends Component
{
    public array $leaderboard = [];
    public array $topAchievers = [];
    public string $period = 'all';

    public function mount(): void
    {
        $this->loadLeaderboard();
    }

    public function loadLeaderboard(): void
    {
        $service = app(GamificationService::class);
        $this->leaderboard = $service->getLeaderboard(20, $this->period);
    }

    public function changePeriod(string $period): void
    {
        $this->period = $period;
        $this->loadLeaderboard();
    }

    public function render()
    {
        return view('livewire.leaderboard')
            ->layout('layouts.wiki');
    }
}
