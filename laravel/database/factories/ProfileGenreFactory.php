<?php

namespace Database\Factories;

namespace Database\Factories;

use App\Models\Profile;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileGenreFactory extends Factory
{
    public function definition()
    {
        return [
            'profile_id' => Profile::factory(),
            'genre_id' => Genre::factory(),
        ];
    }
}
