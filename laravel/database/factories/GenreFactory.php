<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GenreFactory extends Factory
{
    public function definition()
    {
        static $usedGenres = [];
        $allGenres = ['Action', 'Comedy', 'Drama', 'Horror', 'Sci-Fi', 'Fantasy', 'Thriller'];

        $availableGenres = array_diff($allGenres, $usedGenres);
        if (empty($availableGenres)) {
            $usedGenres = []; // Reset if all genres are used
            $availableGenres = $allGenres;
        }

        $genre = $this->faker->randomElement($availableGenres);
        $usedGenres[] = $genre;

        return [
            'genre_name' => $genre,
        ];
    }
}
