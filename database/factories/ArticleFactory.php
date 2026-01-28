<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'category' => $this->faker->randomElement(['song', 'artist', 'genre']),
            'title' => $this->faker->sentence(3),
            'slug' => $this->faker->slug(),
            'content' => $this->faker->paragraphs(3, true),
            'excerpt' => $this->faker->paragraph(),
            'featured_image' => 'https://placehold.co/600x400',
            'view_count' => $this->faker->numberBetween(0, 10000),
            'trending_score' => $this->faker->randomFloat(2, 0, 100),
            'status' => 'published',
            'published_at' => now(),
        ];
    }
}
