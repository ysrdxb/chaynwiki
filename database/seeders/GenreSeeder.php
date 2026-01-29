<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Article;
use App\Models\User;
use App\Models\Artist;
use App\Models\GenreRelationship;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        // Fresh start
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Genre::truncate();
        GenreRelationship::truncate();
        Article::truncate();
        Artist::truncate();
        DB::table('artist_collaborations')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $user = User::first() ?? User::create([
            'name' => 'Admin',
            'email' => 'admin@chaynwiki.com',
            'password' => bcrypt('password'),
        ]);

        // 1. Seed Genres
        $genres = [
            [
                'name' => 'Electronic',
                'description' => 'Music that employs electronic musical instruments.',
                'color' => '#8B5CF6', 
                'era_start' => 1970,
                'children' => [
                    [
                        'name' => 'House',
                        'color' => '#A78BFA',
                        'era_start' => 1980,
                        'children' => [
                            ['name' => 'Deep House', 'color' => '#C4B5FD', 'era_start' => 1985],
                            ['name' => 'Tech House', 'color' => '#C4B5FD', 'era_start' => 1990],
                        ]
                    ],
                    [
                        'name' => 'Techno',
                        'color' => '#7C3AED',
                        'era_start' => 1980,
                    ],
                ]
            ],
            [
                'name' => 'Rock',
                'description' => 'Originating in the 1950s.',
                'color' => '#EC4899', 
                'era_start' => 1950,
                'children' => [
                    [
                        'name' => 'Alternative Rock',
                        'color' => '#F472B6',
                        'era_start' => 1980,
                        'children' => [
                            ['name' => 'Grunge', 'color' => '#FBCFE8', 'era_start' => 1980],
                            ['name' => 'Indie Rock', 'color' => '#FBCFE8', 'era_start' => 1980],
                        ]
                    ],
                    [
                        'name' => 'Metal',
                        'color' => '#DB2777',
                        'era_start' => 1970,
                    ]
                ]
            ],
            [
                'name' => 'Hip Hop',
                'description' => 'Developed in the Bronx in the 1970s.',
                'color' => '#F59E0B', 
                'era_start' => 1970,
                'children' => [
                    ['name' => 'Old School', 'color' => '#FBBF24', 'era_start' => 1970],
                    ['name' => 'Trap', 'color' => '#FBBF24', 'era_start' => 2000],
                ]
            ]
        ];

        foreach ($genres as $root) {
            $this->createGenre($root, $user->id);
        }

        // 2. Seed Artists
        $artists = [
            ['name' => 'Daft Punk', 'genre' => 'Electronic'],
            ['name' => 'Pharrell Williams', 'genre' => 'Hip Hop'],
            ['name' => 'Kanye West', 'genre' => 'Hip Hop'],
            ['name' => 'Nirvana', 'genre' => 'Rock'],
            ['name' => 'David Bowie', 'genre' => 'Rock'],
            ['name' => 'Queen', 'genre' => 'Rock'],
        ];

        $artistModels = [];
        foreach ($artists as $a) {
            $article = Article::create([
                'user_id' => $user->id,
                'title' => $a['name'],
                'slug' => Str::slug($a['name']),
                'content' => "Biography of {$a['name']}.",
                'category' => 'artist',
                'status' => 'published',
                'published_at' => now(),
            ]);

            $artistModels[$a['name']] = Artist::create([
                'article_id' => $article->id,
                'name' => $a['name'],
                'active_from' => now()->subYears(20),
            ]);
        }

        // 3. Seed Collaborations
        if (isset($artistModels['Daft Punk']) && isset($artistModels['Pharrell Williams'])) {
            DB::table('artist_collaborations')->insert([
                'artist1_id' => $artistModels['Daft Punk']->article_id,
                'artist2_id' => $artistModels['Pharrell Williams']->article_id,
                'collaboration_type' => 'feature',
                'work_title' => 'Get Lucky',
                'year' => 2013,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        if (isset($artistModels['Kanye West']) && isset($artistModels['Daft Punk'])) {
            DB::table('artist_collaborations')->insert([
                'artist1_id' => $artistModels['Kanye West']->article_id,
                'artist2_id' => $artistModels['Daft Punk']->article_id,
                'collaboration_type' => 'sample',
                'work_title' => 'Stronger',
                'year' => 2007,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function createGenre(array $data, int $userId, ?int $parentId = null): void
    {
        $article = Article::create([
            'user_id' => $userId,
            'title' => $data['name'],
            'slug' => Str::slug($data['name']),
            'content' => $data['description'] ?? "Information about the genre {$data['name']}.",
            'category' => 'genre',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $genre = Genre::create([
            'article_id' => $article->id,
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'description' => $data['description'] ?? "A sub-genre of music.",
            'color' => $data['color'] ?? '#6B7280',
            'parent_genre_id' => $parentId,
            'era_start' => $data['era_start'] ?? 2000,
            'popularity_score' => rand(60, 100),
        ]);

        if ($parentId) {
            GenreRelationship::create([
                'source_genre_id' => $parentId,
                'target_genre_id' => $genre->id,
                'relationship_type' => 'derived_from',
                'strength' => 90,
            ]);
        }

        if (isset($data['children'])) {
            foreach ($data['children'] as $child) {
                $this->createGenre($child, $userId, $genre->id);
            }
        }
    }
}
