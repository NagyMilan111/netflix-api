<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Series;
use Illuminate\Database\Seeder;

class SeriesSeeder extends Seeder
{
    public function run()
    {
        // Get all genres
        $genres = Genre::all();

        // Ensure there are genres to assign to series
        if ($genres->isEmpty()) {
            $this->command->warn('No genres found. Please run the GenreSeeder first.');
            return;
        }

        // Series titles (you can customize this list)
        $seriesTitles = [
            'Breaking Bad',
            'Game of Thrones',
            'Stranger Things',
            'The Crown',
            'The Mandalorian',
            'The Witcher',
            'Friends',
            'The Office',
            'Sherlock',
            'Black Mirror',
            'Westworld',
            'Narcos',
            'The Boys',
            'Fargo',
        ];

        // Create series for each title
        foreach ($seriesTitles as $title) {
            Series::create([
                'title' => $title,
                'genre_id' => $genres->random()->genre_id, // Assign a random genre_id
                'number_of_seasons' => rand(1, 5), // Random number of seasons (1–5)
                'times_watched' => rand(0, 1000), // Random number of times watched
            ]);
        }
    }
}