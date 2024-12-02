<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Genre;
use Illuminate\Database\Seeder;

class MoviesSeeder extends Seeder
{
    public function run()
    {
        // Check if genres exist
        if (Genre::count() === 0) {
            $this->command->error('No genres found in the database. Please seed genres first.');
            return;
        }

        // Create movies associated with genres
        Genre::all()->each(function ($genre) {
            Movie::factory(1000)->create([
                'genre_id' => $genre->genre_id, // Associate movies with a valid genre
            ]);
        });

        $this->command->info('Movies seeded successfully.');
    }
}
