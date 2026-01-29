<?php

namespace App\Livewire\Dashboard;

use App\Models\Article;
use App\Models\Bookmark;
use App\Models\Revision;
use Livewire\Component;

class UserDashboard extends Component
{
    public function render()
    {
        $user = auth()->user();
        
        // Stats
        $stats = [
            'reputation' => $user->reputation_score,
            'contributions' => $user->revisions()->where('status', 'approved')->count(),
            'bookmarks' => $user->bookmarks()->count(),
            'articles_count' => $user->articles()->count(),
        ];

        // Recent Activity (Mixed revisions and bookmarks)
        $activity = collect();
        
        // Add revisions
        $user->revisions()->latest()->limit(5)->get()->each(function($rev) use ($activity) {
            $activity->push([
                'type' => 'contribution',
                'title' => 'Suggested edit on ' . ($rev->article->title ?? 'Deleted Article'),
                'status' => $rev->status, // pending, approved, rejected
                'date' => $rev->created_at,
                'icon' => 'pencil',
            ]);
        });

        // Add bookmarks
        $user->bookmarks()->latest()->with('article')->limit(5)->get()->each(function($bookmark) use ($activity) {
            $activity->push([
                'type' => 'bookmark',
                'title' => 'Saved ' . ($bookmark->article->title ?? 'Unknown Record'),
                'status' => 'saved',
                'date' => $bookmark->created_at,
                'icon' => 'bookmark',
            ]);
        });

        $sortedActivity = $activity->sortByDesc('date')->take(6);

        // Featured Recommendations (Based on user's recent bookmarks or general popular)
        $recommendations = Article::where('status', 'published')
            ->orderByDesc('view_count')
            ->limit(4)
            ->get();

        return view('livewire.dashboard.user-dashboard', [
            'stats' => $stats,
            'activities' => $sortedActivity,
            'recommendations' => $recommendations,
            'user' => $user
        ]);
    }
}
