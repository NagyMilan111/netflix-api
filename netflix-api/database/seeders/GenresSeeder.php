<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenresSeeder extends Seeder
{
    public function run()
    {
        $genres = ['Action', 'Comedy', 'Drama', 'Horror', 'Sci-Fi', 'Fantasy', 'Thriller'];

        foreach ($genres as $genre) {
            Genre::firstOrCreate(['genre_name' => $genre]); // Avoid duplicates
        }

        $this->command->info('Genres seeded successfully.');
    }
}
