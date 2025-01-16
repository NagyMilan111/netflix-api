<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Media;
use Illuminate\Database\Seeder;

class ViewSeeder extends Seeder
{
    public function run()
{
    // Ensure profiles and media exist
    if (Profile::count() === 0 || Media::count() === 0) {
        $this->command->warn('No profiles or media found. Please run the ProfileSeeder and MediaSeeder first.');
        return;
    }

    // Get all profiles and media
    $profiles = Profile::all();
    $media = Media::all();

    // Create views for each profile
    foreach ($profiles as $profile) {
        // Randomly select 1–5 media items for each profile
        $randomMedia = $media->random(rand(1, 5));

        foreach ($randomMedia as $item) {
            // Check if the combination already exists
            $exists = $profile->views()
                ->where('media_id', $item->media_id)
                ->exists();

            if (!$exists) {
                $profile->views()->create([
                    'media_id' => $item->media_id,
                    'times_watched' => rand(1, 10),
                    'last_watch_date' => now()->subDays(rand(1, 365)),
                ]);
            }
        }
    }

    $this->command->info('ViewSeeder completed successfully.');
}
}