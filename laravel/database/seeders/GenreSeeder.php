<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    public function run()
    {
        $genres = [
            'Action', 'Comedy', 'Drama', 'Horror', 'Sci-Fi', 'Thriller', 'Documentary'
        ];

        foreach ($genres as $genreName) {
            Genre::create(['genre_name' => $genreName]);
        }
    }
}