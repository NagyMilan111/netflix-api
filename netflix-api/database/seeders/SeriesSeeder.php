<?php

namespace Database\Seeders;

use App\Models\Series;
use App\Models\Genre;
use Illuminate\Database\Seeder;

class SeriesSeeder extends Seeder
{
    public function run()
    {
        $genres = Genre::all();

        if ($genres->isEmpty()) {
            $this->command->error('No genres found. Please seed the genres table first.');
            return;
        }

        $this->command->info('Genres found: ' . $genres->count());

        // Create multiple series
        Series::factory(10)->make()->each(function ($series) use ($genres) {
            $series->genre_id = $genres->random()->genre_id; // Assign a random genre
            $series->save();

            $this->command->info("Series created with title: {$series->title}, Genre ID: {$series->genre_id}");
        });

        $this->command->info('Series seeded successfully.');
    }
}
