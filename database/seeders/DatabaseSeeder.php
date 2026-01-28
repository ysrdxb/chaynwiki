<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@chaynwiki.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Regular User
        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        // Create some content
        \App\Models\Article::factory()
            ->count(10)
            ->create([
                'category' => 'song'
            ])
            ->each(function ($article) {
                // Create associated song for each article
                \App\Models\Song::factory()->create([
                    'article_id' => $article->id,
                    'title' => $article->title,
                ]);
            });
    }
}
