<?php

namespace Database\Factories;

use App\Models\Episode;
use Illuminate\Database\Eloquent\Factories\Factory;

class EpisodeFactory extends Factory
{
    protected $model = Episode::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(6),
            'series_id' => null, // This will be assigned during seeding
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
