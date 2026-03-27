<?php

namespace App\Livewire\Tools;

use App\Models\Artist;
use Livewire\Component;

class SoundMap extends Component
{
    public function render()
    {
        // Get artists with valid coordinates
        $points = Artist::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->with('article') // Assuming there's a relation
            ->get()
            ->map(function ($artist) {
                return [
                    'lat' => (float)$artist->latitude,
                    'lng' => (float)$artist->longitude,
                    'size' => 0.5,
                    'color' => '#38bdf8',
                    'name' => $artist->name,
                    'genre' => 'Genre', // Populate if available
                    'avatar' => $artist->article ? $artist->article->featured_image : null,
                    'url' => route('wiki.show', $artist->article ?? '#'),
                ];
            });

        return view('livewire.tools.sound-map', [
            'points' => $points
        ])->layout('layouts.wiki');
    }
}
