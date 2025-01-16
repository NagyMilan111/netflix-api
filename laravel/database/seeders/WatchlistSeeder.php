<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Media;
use App\Models\Series;
use App\Models\Watchlist; // Use the correct model
use Illuminate\Database\Seeder;

class WatchlistSeeder extends Seeder
{
    public function run()
{
    $profiles = Profile::all();
    $media = Media::all();
    $series = Series::all();

    foreach ($profiles as $profile) {
        $randomMedia = $media->random();
        $randomSeries = $series->random();

        // Check if the combination already exists
        $exists = Watchlist::where('profile_id', $profile->profile_id)
            ->where('media_id', $randomMedia->media_id)
            ->exists();

        if (!$exists) {
            Watchlist::create([
                'profile_id' => $profile->profile_id,
                'media_id' => $randomMedia->media_id,
                'series_id' => $randomSeries->series_id,
            ]);
        }
    }
}
}