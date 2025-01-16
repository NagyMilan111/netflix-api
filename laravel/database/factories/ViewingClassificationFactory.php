<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ViewingClassification>
 */
class ViewingClassificationFactory extends Factory
{
    public function definition()
    {
        return [
            'classification_name' => $this->faker->unique()->randomElement(['PG', 'PG-13', 'R', 'NC-17']),
        ];
    }
}
