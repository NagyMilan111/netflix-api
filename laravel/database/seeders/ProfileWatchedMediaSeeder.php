<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Media;
use Illuminate\Database\Seeder;

class ProfileWatchedMediaSeeder extends Seeder
{
    public function run()
    {
        $profiles = Profile::all();
        $media = Media::all();

        foreach ($profiles as $profile) {
            // Get a list of media IDs that are not already attached to the profile
            $attachedMedia = $profile->watchedMedia->pluck('media_id')->toArray();
            $availableMedia = $media->whereNotIn('media_id', $attachedMedia);

            // If there are available media, attach one
            if ($availableMedia->isNotEmpty()) {
                $randomMedia = $availableMedia->random();

                $profile->watchedMedia()->attach(
                    $randomMedia->media_id,
                    [
                        'pause_spot' => '00:30:00',
                        'times_watched' => rand(1, 10),
                        'last_watch_date' => now()->subDays(rand(1, 365)),
                    ]
                );
            }
        }
    }
}