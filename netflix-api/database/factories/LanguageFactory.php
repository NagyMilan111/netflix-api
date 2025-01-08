<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Language>
 */
class LanguageFactory extends Factory
{
    public function definition()
    {
        return [
            'lang_name' => $this->faker->unique()->randomElement(['English', 'Spanish', 'French', 'German', 'Japanese']),
        ];
    }
}
