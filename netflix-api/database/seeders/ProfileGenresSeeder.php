<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileGenresSeeder extends Seeder
{
    public function run()
    {
        Profile::all()->each(function ($profile) {
            Genre::inRandomOrder()->take(2)->get()->each(function ($genre) use ($profile) {
                \DB::table('profile_genres')->insert([
                    'profile_id' => $profile->profile_id,
                    'genre_id' => $genre->genre_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
        });

        $this->command->info('Profile genres seeded successfully.');
    }
}
