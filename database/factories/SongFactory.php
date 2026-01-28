<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Song>
 */
class SongFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'album' => $this->faker->words(3, true),
            'release_date' => $this->faker->date(),
            'duration' => $this->faker->numberBetween(180, 300),
            'stream_count' => $this->faker->numberBetween(1000, 1000000),
            'lyrics' => $this->faker->text(),
        ];
    }
}
