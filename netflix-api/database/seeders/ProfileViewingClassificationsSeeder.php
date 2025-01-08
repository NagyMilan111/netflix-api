<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\ViewingClassification;
use Illuminate\Database\Seeder;

class ProfileViewingClassificationsSeeder extends Seeder
{
    public function run()
    {
        $classifications = ViewingClassification::all();

        if ($classifications->isEmpty()) {
            $this->command->error('No viewing classifications found. Please seed the viewing classifications table first.');
            return;
        }

        Profile::all()->each(function ($profile) use ($classifications) {
            // Randomly assign 1-3 classifications to each profile
            $classifications->random(rand(1, 3))->each(function ($classification) use ($profile) {
                \DB::table('profiles_viewing_classifications')->insert([
                    'profile_id' => $profile->profile_id,
                    'classification_id' => $classification->classification_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
        });

        $this->command->info('Profile viewing classifications seeded successfully.');
    }
}
