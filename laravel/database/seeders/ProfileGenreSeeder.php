<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileGenreSeeder extends Seeder
{
    public function run()
    {
        // Get all profiles and genres
        $profiles = Profile::all();
        $genres = Genre::all();

        // Ensure there are profiles and genres to associate
        if ($profiles->isEmpty() || $genres->isEmpty()) {
            $this->command->warn('No profiles or genres found. Please run the ProfileSeeder and GenreSeeder first.');
            return;
        }

        // Attach genres to profiles
        foreach ($profiles as $profile) {
            // Randomly attach 1–3 genres to each profile
            $randomGenres = $genres->random(min(3, $genres->count()))->pluck('genre_id');

            // Attach the genres to the profile
            $profile->genres()->attach($randomGenres);
        }

        $this->command->info('ProfileGenreSeeder completed successfully.');
    }
}