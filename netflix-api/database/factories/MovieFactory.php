<?php

namespace Database\Factories;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    public function definition()
    {
        $genre = Genre::inRandomOrder()->first();

        if (!$genre) {
            throw new \Exception('No genres found. Please seed genres first.');
        }

        return [
            'title' => $this->faker->sentence(3),
            'genre_id' => $genre->genre_id, // Always assign a valid genre_id
            'has_uhd_version' => $this->faker->boolean(),
            'has_hd_version' => $this->faker->boolean(),
        ];
    }
}
