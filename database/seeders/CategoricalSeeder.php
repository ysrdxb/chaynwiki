<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoricalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::first();

        // 1. Seed Terminology
        $terms = [
            [
                'title' => 'Reverb',
                'category' => 'term',
                'content' => 'Reverb is the persistence of sound after it is produced. It is created when a sound or signal is reflected causing numerous reflections to build up and then decay as the sound is absorbed by the surfaces of objects in the space.',
                'meta' => [
                    'phonetic' => '/rɪˈvɜːb/',
                    'category_type' => 'theory',
                    'origin_language' => 'Latin',
                    'related_terms' => ['Delay', 'Echo', 'Acoustics']
                ]
            ],
            [
                'title' => 'Syncopation',
                'category' => 'term',
                'content' => 'In music, syncopation involves a variety of rhythms which are in some way unexpected, making part or all of a tune or piece of music off-beat.',
                'meta' => [
                    'phonetic' => '/ˌsɪŋkəˈpeɪʃn/',
                    'category_type' => 'theory',
                    'origin_language' => 'Greek',
                    'related_terms' => ['Polyrhythm', 'Groove', 'Tempo']
                ]
            ]
        ];

        foreach ($terms as $t) {
            $article = \App\Models\Article::create([
                'user_id' => $user->id,
                'category' => $t['category'],
                'title' => $t['title'],
                'slug' => \Illuminate\Support\Str::slug($t['title']),
                'content' => $t['content'],
                'status' => 'published',
                'published_at' => now(),
            ]);

            $article->term()->create([
                'name' => $t['title'],
                'phonetic' => $t['meta']['phonetic'],
                'category_type' => $t['meta']['category_type'],
                'origin_language' => $t['meta']['origin_language'],
                'related_terms' => $t['meta']['related_terms'],
            ]);
        }

        // 2. Seed Playlists
        $playlists = [
            [
                'title' => 'Ethereal Gloom',
                'category' => 'playlist',
                'content' => 'A collection of haunting, atmospheric tracks that explore the intersection of dream pop and dark wave.',
                'meta' => [
                    'spotify_id' => '37i9dQZF1DXdbX4vYI9p06',
                    'track_count' => 45,
                    'curator_note' => 'Best enjoyed at 3 AM with headphones. Focuses on spatial clarity.'
                ]
            ],
            [
                'title' => 'Cyberpunk Protocol',
                'category' => 'playlist',
                'content' => 'High-energy industrial techno and synthwave for high-stress simulation environments.',
                'meta' => [
                    'spotify_id' => '37i9dQZF1DX6as9Y99u9Yv',
                    'track_count' => 32,
                    'curator_note' => 'Optimized for high-speed focus and aggressive productivity.'
                ]
            ]
        ];

        foreach ($playlists as $p) {
            $article = \App\Models\Article::create([
                'user_id' => $user->id,
                'category' => $p['category'],
                'title' => $p['title'],
                'slug' => \Illuminate\Support\Str::slug($p['title']),
                'content' => $p['content'],
                'status' => 'published',
                'published_at' => now(),
            ]);

            $article->playlist()->create([
                'title' => $p['title'],
                'spotify_id' => $p['meta']['spotify_id'],
                'track_count' => $p['meta']['track_count'],
                'curator_note' => $p['meta']['curator_note'],
            ]);
        }
    }
}
