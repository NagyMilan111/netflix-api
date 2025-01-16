<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    public function definition()
    {
        return [
            'profile_name' => $this->faker->firstName,
            'profile_language' => $this->faker->randomElement(['English', 'Spanish', 'French']),
            'profile_is_kids' => $this->faker->boolean,
        ];
    }
}
