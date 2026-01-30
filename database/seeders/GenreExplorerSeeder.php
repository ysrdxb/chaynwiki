<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\GenreRelationship;
use Illuminate\Database\Seeder;

class GenreExplorerSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks to allow truncation
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();

        // Clear existing data
        GenreRelationship::truncate();
        Genre::truncate();
        // Ideally we should truncate articles too, but that might delete other content.
        // For this seeder, we'll just create new ones. Using firstOrCreate to avoid duplicates if re-run without truncate.
        // But since we are truncating genres, we will just create new articles.
        
        // Re-enable foreign key checks
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // Create sample genres with explorer fields
        $genres = [
            ['name' => 'Rock', 'slug' => 'rock', 'color' => '#EF4444', 'era_start' => 1950, 'era_end' => null, 'popularity_score' => 95, 'description' => 'Electric guitar-driven music with strong rhythms'],
            ['name' => 'Jazz', 'slug' => 'jazz', 'color' => '#F59E0B', 'era_start' => 1920, 'era_end' => null, 'popularity_score' => 85, 'description' => 'Improvisational music with complex harmonies'],
            ['name' => 'Blues', 'slug' => 'blues', 'color' => '#3B82F6', 'era_start' => 1890, 'era_end' => null, 'popularity_score' => 75, 'description' => 'Soulful music with expressive vocals'],
            ['name' => 'Hip Hop', 'slug' => 'hip-hop', 'color' => '#8B5CF6', 'era_start' => 1970, 'era_end' => null, 'popularity_score' => 98, 'description' => 'Rhythmic music with rapping and beats'],
            ['name' => 'Electronic', 'slug' => 'electronic', 'color' => '#06B6D4', 'era_start' => 1980, 'era_end' => null, 'popularity_score' => 92, 'description' => 'Synthesizer and computer-based music'],
            ['name' => 'Pop', 'slug' => 'pop', 'color' => '#EC4899', 'era_start' => 1960, 'era_end' => null, 'popularity_score' => 100, 'description' => 'Mainstream popular music'],
            ['name' => 'Metal', 'slug' => 'metal', 'color' => '#DC2626', 'era_start' => 1970, 'era_end' => null, 'popularity_score' => 88, 'description' => 'Heavy distorted guitars and aggressive vocals'],
            ['name' => 'Punk', 'slug' => 'punk', 'color' => '#F97316', 'era_start' => 1974, 'era_end' => null, 'popularity_score' => 78, 'description' => 'Fast, raw, and rebellious rock music'],
            ['name' => 'R&B', 'slug' => 'rnb', 'color' => '#A855F7', 'era_start' => 1940, 'era_end' => null, 'popularity_score' => 90, 'description' => 'Rhythm and blues with soulful vocals'],
            ['name' => 'Country', 'slug' => 'country', 'color' => '#84CC16', 'era_start' => 1920, 'era_end' => null, 'popularity_score' => 82, 'description' => 'Folk-influenced American music'],
            ['name' => 'Reggae', 'slug' => 'reggae', 'color' => '#10B981', 'era_start' => 1968, 'era_end' => null, 'popularity_score' => 80, 'description' => 'Jamaican music with offbeat rhythms'],
            ['name' => 'Classical', 'slug' => 'classical', 'color' => '#6366F1', 'era_start' => 1750, 'era_end' => 1820, 'popularity_score' => 70, 'description' => 'Traditional orchestral music'],
        ];

        $genreIds = [];
        foreach ($genres as $genre) {
            // Find or Create required Article first
            $article = \App\Models\Article::firstOrCreate(
                ['slug' => $genre['slug']],
                [
                    'title' => $genre['name'],
                    'category' => 'genre',
                    'content' => $genre['description'],
                    'status' => 'published',
                    'view_count' => rand(1000, 50000),
                ]
            );

            // Create Genre
            $genreIds[$genre['slug']] = Genre::create([
                'article_id' => $article->id,
                'name' => $genre['name'],
                'slug' => $genre['slug'],
                'description' => $genre['description'],
                'color' => $genre['color'],
                'era_start' => $genre['era_start'],
                'era_end' => $genre['era_end'],
                'popularity_score' => $genre['popularity_score'],
                'origin_date' => (string)$genre['era_start'],
            ])->id;
        }

        // Create relationships
        $relationships = [
            // Rock influences
            ['source' => 'blues', 'target' => 'rock', 'type' => 'influences', 'strength' => 90],
            ['source' => 'rock', 'target' => 'metal', 'type' => 'influences', 'strength' => 85],
            ['source' => 'rock', 'target' => 'punk', 'type' => 'influences', 'strength' => 80],
            
            // Jazz influences
            ['source' => 'blues', 'target' => 'jazz', 'type' => 'influences', 'strength' => 75],
            ['source' => 'jazz', 'target' => 'hip-hop', 'type' => 'influences', 'strength' => 60],
            
            // Electronic
            ['source' => 'electronic', 'target' => 'hip-hop', 'type' => 'fusion_of', 'strength' => 70],
            ['source' => 'pop', 'target' => 'electronic', 'type' => 'fusion_of', 'strength' => 65],
            
            // R&B connections
            ['source' => 'blues', 'target' => 'rnb', 'type' => 'influences', 'strength' => 85],
            ['source' => 'rnb', 'target' => 'hip-hop', 'type' => 'influences', 'strength' => 90],
            ['source' => 'rnb', 'target' => 'pop', 'type' => 'influences', 'strength' => 75],
            
            // Reggae
            ['source' => 'rnb', 'target' => 'reggae', 'type' => 'influences', 'strength' => 60],
            ['source' => 'reggae', 'target' => 'hip-hop', 'type' => 'influences', 'strength' => 55],
        ];

        foreach ($relationships as $rel) {
            if (isset($genreIds[$rel['source']]) && isset($genreIds[$rel['target']])) {
                GenreRelationship::create([
                    'source_genre_id' => $genreIds[$rel['source']],
                    'target_genre_id' => $genreIds[$rel['target']],
                    'relationship_type' => $rel['type'],
                    'strength' => $rel['strength'],
                ]);
            }
        }

        $this->command->info('Genre explorer data seeded successfully!');
    }
}
