<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        $achievements = [
            // Contributor Achievements
            [
                'slug' => 'first-article',
                'name' => 'First Contribution',
                'description' => 'Create your first wiki article',
                'icon' => '✍️',
                'category' => 'contributor',
                'tier' => 'bronze',
                'points' => 10,
                'requirements' => ['articles_created' => 1],
            ],
            [
                'slug' => 'prolific-writer',
                'name' => 'Prolific Writer',
                'description' => 'Create 10 wiki articles',
                'icon' => '📚',
                'category' => 'contributor',
                'tier' => 'silver',
                'points' => 50,
                'requirements' => ['articles_created' => 10],
            ],
            [
                'slug' => 'wiki-master',
                'name' => 'Wiki Master',
                'description' => 'Create 50 wiki articles',
                'icon' => '🏆',
                'category' => 'contributor',
                'tier' => 'gold',
                'points' => 200,
                'requirements' => ['articles_created' => 50],
            ],
            [
                'slug' => 'legend',
                'name' => 'Living Legend',
                'description' => 'Create 100 wiki articles',
                'icon' => '👑',
                'category' => 'contributor',
                'tier' => 'platinum',
                'points' => 500,
                'requirements' => ['articles_created' => 100],
            ],

            // Editor Achievements
            [
                'slug' => 'first-edit',
                'name' => 'Editor',
                'description' => 'Make your first edit to an existing article',
                'icon' => '✏️',
                'category' => 'editor',
                'tier' => 'bronze',
                'points' => 5,
                'requirements' => ['edits_made' => 1],
            ],
            [
                'slug' => 'dedicated-editor',
                'name' => 'Dedicated Editor',
                'description' => 'Make 50 edits',
                'icon' => '📝',
                'category' => 'editor',
                'tier' => 'silver',
                'points' => 75,
                'requirements' => ['edits_made' => 50],
            ],
            [
                'slug' => 'perfectionist',
                'name' => 'Perfectionist',
                'description' => 'Make 200 edits',
                'icon' => '💎',
                'category' => 'editor',
                'tier' => 'gold',
                'points' => 250,
                'requirements' => ['edits_made' => 200],
            ],

            // Expert Achievements
            [
                'slug' => 'hip-hop-head',
                'name' => 'Hip Hop Head',
                'description' => 'Create 10 articles about hip-hop',
                'icon' => '🎤',
                'category' => 'expert',
                'tier' => 'silver',
                'points' => 100,
                'requirements' => ['category_articles' => ['hip-hop' => 10]],
            ],
            [
                'slug' => 'rock-scholar',
                'name' => 'Rock Scholar',
                'description' => 'Create 10 articles about rock music',
                'icon' => '🎸',
                'category' => 'expert',
                'tier' => 'silver',
                'points' => 100,
                'requirements' => ['category_articles' => ['rock' => 10]],
            ],
            [
                'slug' => 'pop-expert',
                'name' => 'Pop Expert',
                'description' => 'Create 10 articles about pop music',
                'icon' => '🌟',
                'category' => 'expert',
                'tier' => 'silver',
                'points' => 100,
                'requirements' => ['category_articles' => ['pop' => 10]],
            ],

            // Streak Achievements
            [
                'slug' => 'week-streak',
                'name' => 'Week Warrior',
                'description' => 'Maintain a 7-day contribution streak',
                'icon' => '🔥',
                'category' => 'streak',
                'tier' => 'bronze',
                'points' => 25,
                'requirements' => ['streak_days' => 7],
            ],
            [
                'slug' => 'month-streak',
                'name' => 'Monthly Champion',
                'description' => 'Maintain a 30-day contribution streak',
                'icon' => '⚡',
                'category' => 'streak',
                'tier' => 'gold',
                'points' => 150,
                'requirements' => ['streak_days' => 30],
            ],

            // Community Achievements
            [
                'slug' => 'helpful',
                'name' => 'Helpful',
                'description' => 'Have your articles viewed 1,000 times',
                'icon' => '💡',
                'category' => 'community',
                'tier' => 'bronze',
                'points' => 20,
                'requirements' => ['total_views' => 1000],
            ],
            [
                'slug' => 'influencer',
                'name' => 'Influencer',
                'description' => 'Have your articles viewed 10,000 times',
                'icon' => '🌍',
                'category' => 'community',
                'tier' => 'silver',
                'points' => 100,
                'requirements' => ['total_views' => 10000],
            ],
            [
                'slug' => 'viral',
                'name' => 'Viral',
                'description' => 'Have your articles viewed 100,000 times',
                'icon' => '🚀',
                'category' => 'community',
                'tier' => 'platinum',
                'points' => 500,
                'requirements' => ['total_views' => 100000],
            ],

            // Special Achievements
            [
                'slug' => 'early-adopter',
                'name' => 'Early Adopter',
                'description' => 'Join ChaynWiki in its first year',
                'icon' => '🌱',
                'category' => 'special',
                'tier' => 'gold',
                'points' => 100,
                'requirements' => ['joined_before' => '2027-01-01'],
            ],
            [
                'slug' => 'ai-pioneer',
                'name' => 'AI Pioneer',
                'description' => 'Use AI to generate 5 article drafts',
                'icon' => '🤖',
                'category' => 'special',
                'tier' => 'silver',
                'points' => 50,
                'requirements' => ['ai_generations' => 5],
            ],
        ];

        foreach ($achievements as $achievement) {
            Achievement::updateOrCreate(
                ['slug' => $achievement['slug']],
                $achievement
            );
        }
    }
}
