<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfilesWatchListSeeder extends Seeder
{
    public function run()
    {
        Profile::all()->each(function ($profile) {
            Media::inRandomOrder()->take(3)->get()->each(function ($media) use ($profile) {
                \DB::table('profiles_watch_list')->insert([
                    'profile_id' => $profile->profile_id,
                    'media_id' => $media->media_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
        });

        $this->command->info('Profiles watch list seeded successfully.');
    }
}
