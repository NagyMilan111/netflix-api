<?php

namespace Database\Factories;

use App\Models\Media;
use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubtitleFactory extends Factory
{
    public function definition()
    {
        $language = Language::inRandomOrder()->first();

        if (!$language) {
            throw new \Exception('No languages found. Please seed the languages table first.');
        }

        return [
            'media_id' => Media::inRandomOrder()->first()->media_id,
            'lang_id' => $language->lang_id, // Assign a valid lang_id
            'subtitle_location' => $this->faker->url,
        ];
    }
}
