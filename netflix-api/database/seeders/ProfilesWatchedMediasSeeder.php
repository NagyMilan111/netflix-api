<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfilesWatchedMediasSeeder extends Seeder
{
    public function run()
    {
        Profile::all()->each(function ($profile) {
            Media::inRandomOrder()->take(5)->get()->each(function ($media) use ($profile) {
                \DB::table('profiles_watched_medias')->insert([
                    'profile_id' => $profile->profile_id,
                    'media_id' => $media->media_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
        });

        $this->command->info('Profiles watched medias seeded successfully.');
    }
}
