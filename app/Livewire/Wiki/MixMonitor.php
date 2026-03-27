<?php

namespace App\Livewire\Wiki;

use Livewire\Component;
use App\Models\Article;

class MixMonitor extends Component
{
    public Article $rootArticle;
    public $searchQuery = '';
    public $candidateArticle = null;
    public $mixData = null;
    public $searchResults = [];

    public function updatedSearchQuery()
    {
        if (strlen($this->searchQuery) < 2) {
            $this->searchResults = [];
            return;
        }

        $this->searchResults = Article::where('category', 'song')
            ->where('id', '!=', $this->rootArticle->id)
            ->where('title', 'like', '%' . $this->searchQuery . '%')
            ->take(5)
            ->get();
    }

    public function selectCandidate($id)
    {
        $this->candidateArticle = Article::find($id);
        $this->calculateMix();
        $this->searchResults = [];
        $this->searchQuery = '';
    }

    public function calculateMix()
    {
        if (!$this->rootArticle || !$this->candidateArticle) return;

        $bpmA = (int) ($this->rootArticle->meta['bpm'] ?? 120);
        $bpmB = (int) ($this->candidateArticle->meta['bpm'] ?? 120);
        
        $keyA = $this->rootArticle->meta['camelot_key'] ?? '8A';
        $keyB = $this->candidateArticle->meta['camelot_key'] ?? '8A';

        // BPM Math
        $diff = $bpmB - $bpmA;
        $percent = ($diff / $bpmA) * 100;
        
        // Key Math (Simplified Camelot)
        // Extract Number and Letter
        preg_match('/(\d+)([AB])/', $keyA, $matchesA);
        preg_match('/(\d+)([AB])/', $keyB, $matchesB);
        
        $harmonicStatus = 'Unknown';
        $harmonicScore = 50;
        
        if (!empty($matchesA) && !empty($matchesB)) {
            $numA = (int)$matchesA[1];
            $charA = $matchesA[2];
            $numB = (int)$matchesB[1];
            $charB = $matchesB[2];

            // Harmonic Rules
            // Same Key
            if ($keyA === $keyB) {
                $harmonicStatus = 'Perfect Match';
                $harmonicScore = 100;
            }
            // Relative Major/Minor (8A <-> 8B)
            elseif ($numA === $numB && $charA !== $charB) {
                $harmonicStatus = 'Relative Key';
                $harmonicScore = 100;
            }
            // +/- 1 (e.g. 8A -> 9A or 7A)
            elseif (abs($numA - $numB) === 1 && $charA === $charB) {
                $harmonicStatus = 'Harmonic Step';
                $harmonicScore = 90;
            }
            // Energy Boost (+2)
            elseif (($numB - $numA) === 2 && $charA === $charB) {
                 $harmonicStatus = 'Energy Boost';
                 $harmonicScore = 80;
            }
            else {
                $harmonicStatus = 'Dissonant';
                $harmonicScore = 20;
            }
        }

        $this->mixData = [
            'bpm_diff' => round($diff, 1),
            'bpm_percent' => round($percent, 1),
            'harmonic_status' => $harmonicStatus,
            'harmonic_score' => $harmonicScore,
            'color' => $harmonicScore > 80 ? 'text-green-400' : ($harmonicScore > 50 ? 'text-yellow-400' : 'text-red-400')
        ];
    }

    public function render()
    {
        return view('livewire.wiki.mix-monitor');
    }
}
