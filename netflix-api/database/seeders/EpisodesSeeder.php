<?php

namespace Database\Seeders;

use App\Models\Episode;
use App\Models\Series;
use Illuminate\Database\Seeder;

class EpisodesSeeder extends Seeder
{
    public function run()
    {
        $series = Series::all();

        if ($series->isEmpty()) {
            $this->command->error('No series found. Please seed the series table first.');
            return;
        }

        $this->command->info("Series count: {$series->count()}");

        $series->each(function ($singleSeries) {
            if (empty($singleSeries->id)) {
                $this->command->error("Series ID is missing for Title: {$singleSeries->title}");
                return;
            }

            $this->command->info("Processing Series ID: {$singleSeries->id}, Title: {$singleSeries->title}");

            $episodesCount = rand(5, 15); // Random number of episodes (5 to 15)

            Episode::factory($episodesCount)->create([
                'series_id' => $singleSeries->id, // Assign episodes to the series
            ]);

            $this->command->info("Created {$episodesCount} episodes for Series ID: {$singleSeries->id}");
        });

        $this->command->info('Episodes seeded successfully.');
    }
}
