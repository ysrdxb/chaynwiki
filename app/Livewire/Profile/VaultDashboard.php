<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;

class VaultDashboard extends Component
{
    public $totalValue = 0;
    public $rarityScore = 0;
    public $itemsCount = 0;
    public $topGems = [];
    public $mostValuableCrate = null;

    public function mount()
    {
        $user = Auth::user();
        if (!$user) return;

        // Fetch all articles from user's crates
        $articles = Article::whereHas('crates', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with('crates')->get();
        
        $this->itemsCount = $articles->unique('id')->count();

        // Calculate Cultural Value
        // Formula: (Trust Score * View Count Factor) + Rarity Bonus
        foreach ($articles as $article) {
            $baseValue = $article->trust_score ?? 10;
            $viewFactor = log($article->views_count + 1) * 2;
            $rarityBonus = 1000 / ($article->views_count + 1); // Less views = Rare
            
            $this->totalValue += ($baseValue * $viewFactor) + $rarityBonus;
        }
        
        $this->totalValue = round($this->totalValue);

        // Calculate Rarity Score (Average inverse popularity)
        if ($this->itemsCount > 0) {
            $avgViews = $articles->avg('views_count');
            $this->rarityScore = round(100 - min(($avgViews / 100), 99)); // 0-100 scale inverted
        }

        // Top Gems (High Value Items)
        $this->topGems = $articles->sortByDesc('trust_score')->take(3);
    }

    public function render()
    {
        return view('livewire.profile.vault-dashboard');
    }
}
