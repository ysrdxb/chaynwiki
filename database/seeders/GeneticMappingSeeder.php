<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeneticMappingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::first();

        // 1. Edwin Birdsong - Cola Bottle Baby (Ancestor)
        $birdsongArt = \App\Models\Article::updateOrCreate(
            ['slug' => 'cola-bottle-baby'],
            [
                'user_id' => $user->id,
                'title' => 'Cola Bottle Baby',
                'category' => 'song',
                'status' => 'published',
                'content' => 'Classic funk track known for its iconic synth riff.'
            ]
        );
        $birdsongSong = \App\Models\Song::updateOrCreate(
            ['article_id' => $birdsongArt->id],
            [
                'title' => 'Cola Bottle Baby',
                'artist_id' => 2, // Pharrell (placeholder)
                'release_date' => '1979-01-01'
            ]
        );

        // 2. Daft Punk - Harder, Better, Faster, Stronger (Mid-point)
        $daftArt = \App\Models\Article::updateOrCreate(
            ['slug' => 'hbfs'],
            [
                'user_id' => $user->id,
                'title' => 'Harder, Better, Faster, Stronger',
                'category' => 'song',
                'status' => 'published',
                'content' => 'A standout track from Discovery.'
            ]
        );
        $daftSong = \App\Models\Song::updateOrCreate(
            ['article_id' => $daftArt->id],
            [
                'title' => 'Harder, Better, Faster, Stronger',
                'artist_id' => 1, // Daft Punk
                'release_date' => '2001-10-13'
            ]
        );

        // 3. Kanye West - Stronger (Descendant)
        $kanyeArt = \App\Models\Article::updateOrCreate(
            ['slug' => 'stronger'],
            [
                'user_id' => $user->id,
                'title' => 'Stronger',
                'category' => 'song',
                'status' => 'published',
                'content' => 'Kanye West hits the mainstream with this Daft Punk sample.'
            ]
        );
        $kanyeSong = \App\Models\Song::updateOrCreate(
            ['article_id' => $kanyeArt->id],
            [
                'title' => 'Stronger',
                'artist_id' => 3, // Kanye West
                'release_date' => '2007-07-31'
            ]
        );

        // Relationships (Delete existing to avoid duplicates if re-running)
        \App\Models\ArticleRelationship::whereIn('source_id', [$daftArt->id, $kanyeArt->id])
            ->whereIn('target_id', [$birdsongArt->id, $daftArt->id])
            ->delete();

        \App\Models\ArticleRelationship::create([
            'source_id' => $daftArt->id,
            'target_id' => $birdsongArt->id,
            'type' => 'samples',
            'metadata' => ['timestamp' => '0:00']
        ]);

        \App\Models\ArticleRelationship::create([
            'source_id' => $kanyeArt->id,
            'target_id' => $daftArt->id,
            'type' => 'samples',
            'metadata' => ['timestamp' => '0:00']
        ]);
    }
}
