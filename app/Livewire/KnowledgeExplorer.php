<?php

namespace App\Livewire;

use App\Services\KnowledgeExplorerService;
use Livewire\Component;

class KnowledgeExplorer extends Component
{
    public string $activeTab = 'genres';
    public ?int $selectedGenre = null;
    public ?array $genreDetails = null;

    public function mount(): void
    {
        // Initialize with genre network view
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
        $this->selectedGenre = null;
        $this->genreDetails = null;
    }

    public function selectGenre(int $genreId): void
    {
        $this->selectedGenre = $genreId;
        $service = app(KnowledgeExplorerService::class);
        $this->genreDetails = $service->getGenreDetails($genreId);
    }

    public function closeDetails(): void
    {
        $this->selectedGenre = null;
        $this->genreDetails = null;
    }

    public function render()
    {
        $service = app(KnowledgeExplorerService::class);

        return view('livewire.knowledge-explorer', [
            'genreNetwork' => $service->getGenreNetwork(),
            'artistNetwork' => $service->getArtistNetwork(),
            'timeline' => $service->getTimeline(),
        ])->layout('layouts.wiki');
    }
}
