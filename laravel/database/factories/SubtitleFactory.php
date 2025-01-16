<?php

namespace Database\Factories;

use App\Models\Subtitle;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubtitleFactory extends Factory
{
    protected $model = Subtitle::class;

    public function definition()
    {
        return [
            'subtitle_lang' => \App\Models\Language::factory(), // Foreign key to languages table
            'media_id' => \App\Models\Media::factory(), // Foreign key to media table
            'subtitle_position' => $this->faker->numberBetween(1, 10), // Random position
        ];
    }
}