<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\Profile;
use App\Models\ProfileWatchList;
use Illuminate\Database\Seeder;

class ProfileWatchListSeeder extends Seeder
{
    public function run()
    {
        // Get all profiles and media
        $profiles = Profile::all();
        $media = Media::all();

        // Ensure there are profiles and media to associate
        if ($profiles->isEmpty() || $media->isEmpty()) {
            $this->command->warn('No profiles or media found. Please run the ProfileSeeder and MediaSeeder first.');
            return;
        }

        // Attach media to profiles
        foreach ($profiles as $profile) {
            $numWatchListEntries = rand(1, 5); // Each profile has 1–5 watch list entries
            for ($i = 0; $i < $numWatchListEntries; $i++) {
                ProfileWatchList::create([
                    'profile_id' => $profile->profile_id,
                    'media_id' => $media->random()->media_id,
                    'pause_spot' => '00:' . rand(10, 50) . ':' . rand(10, 59),
                    'times_watched' => rand(1, 10),
                    'last_watch_date' => now()->subDays(rand(1, 365)),
                ]);
            }
        }

        $this->command->info('ProfileWatchListSeeder completed successfully.');
    }
}