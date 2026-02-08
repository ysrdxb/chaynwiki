<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

class UserProfile extends Component
{
    public User $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    #[Layout('layouts.wiki')]
    public function render()
    {
        $articles = $this->user->articles()->latest()->take(12)->get();
        $totalViews = $this->user->articles()->sum('view_count');
        $revisionsCount = $this->user->revisions()->where('status', 'approved')->count();
        
        // Additional stats for Figma design
        $topicsAdded = $this->user->articles()->where('status', 'published')->count();
        $editsMade = $this->user->revisions()->count();
        $approvedContributions = $this->user->revisions()->where('status', 'approved')->count();
        $pendingReviews = $this->user->revisions()->where('status', 'pending')->count();
        $points = ($topicsAdded * 10) + ($editsMade * 5) + ($approvedContributions * 3);
        
        // Calculate badges
        $badges = $this->calculateBadges($topicsAdded, $editsMade, $approvedContributions);
        
        return view('livewire.user-profile', [
            'articles' => $articles,
            'totalViews' => $totalViews,
            'revisionsCount' => $revisionsCount,
            'topicsAdded' => $topicsAdded,
            'editsMade' => $editsMade,
            'approvedContributions' => $approvedContributions,
            'pendingReviews' => $pendingReviews,
            'points' => $points,
            'badges' => $badges,
        ]);
    }
    
    private function calculateBadges($topicsAdded, $editsMade, $approvedContributions)
    {
        $badges = [];
        
        if ($topicsAdded >= 200) {
            $badges[] = [
                'title' => '200+ Verified Contributions',
                'description' => 'Verified contributions',
            ];
        }
        
        if ($approvedContributions >= 100) {
            $badges[] = [
                'title' => 'Verified Editor',
                'description' => 'Consistently accurate submissions',
            ];
        }
        
        if ($editsMade >= 150) {
            $badges[] = [
                'title' => 'Fast Responder',
                'description' => 'Active in correcting and updating metadata',
            ];
        }
        
        if ($totalViews = $this->user->articles()->sum('view_count') >= 10000) {
            $badges[] = [
                'title' => 'Community Favorite',
                'description' => 'Contributions received high user engagement',
            ];
        }
        
        return $badges;
    }
}
