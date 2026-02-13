<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MilestoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daft Punk (Artist 1)
        \App\Models\Milestone::create([
            'artist_id' => 1,
            'title' => 'Daft Punk Formation',
            'description' => 'Guy-Manuel de Homem-Christo and Thomas Bangalter form the duo in Paris.',
            'event_date' => '1993-01-01',
            'type' => 'event',
            'importance_score' => 100
        ]);

        \App\Models\Milestone::create([
            'artist_id' => 1,
            'title' => 'Homework Released',
            'description' => 'The debut studio album is released, revolutionizing house music.',
            'event_date' => '1997-01-20',
            'type' => 'release',
            'importance_score' => 95
        ]);

        \App\Models\Milestone::create([
            'artist_id' => 1,
            'title' => 'Discovery Era Begins',
            'description' => 'Transition to synth-pop inspired sounds and the introduction of robot personas.',
            'event_date' => '2001-02-26',
            'type' => 'milestone',
            'importance_score' => 90
        ]);

        \App\Models\Milestone::create([
            'artist_id' => 1,
            'title' => 'Alive 2007 Tour',
            'description' => 'The legendary pyramid stage tour that defined modern EDM visuals.',
            'event_date' => '2007-06-16',
            'type' => 'event',
            'importance_score' => 100
        ]);

        \App\Models\Milestone::create([
            'artist_id' => 1,
            'title' => 'Grammy Clean Sweep',
            'description' => 'Random Access Memories wins Album of the Year at the 56th Annual Grammy Awards.',
            'event_date' => '2014-01-26',
            'type' => 'award',
            'importance_score' => 100
        ]);

        // Electronic Genre (5)
        \App\Models\Milestone::create([
            'genre_id' => 5,
            'title' => 'Moog Synthesizer Invented',
            'description' => 'Robert Moog presents his voltage-controlled modular synthesizer.',
            'event_date' => '1964-10-12',
            'type' => 'event',
            'importance_score' => 100
        ]);

        \App\Models\Milestone::create([
            'genre_id' => 5,
            'title' => 'Kraftwerk - Autobahn',
            'description' => 'The release of Autobahn marks the birth of electronic pop.',
            'event_date' => '1974-11-01',
            'type' => 'release',
            'importance_score' => 95
        ]);
    }
}
