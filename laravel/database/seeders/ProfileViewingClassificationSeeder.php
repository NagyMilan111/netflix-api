<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\ViewingClassification;
use Illuminate\Database\Seeder;

class ProfileViewingClassificationSeeder extends Seeder
{
    public function run()
    {
        // Get all profiles and viewing classifications
        $profiles = Profile::all();
        $classifications = ViewingClassification::all();

        // Ensure there are profiles and classifications to associate
        if ($profiles->isEmpty() || $classifications->isEmpty()) {
            $this->command->warn('No profiles or viewing classifications found. Please run the ProfileSeeder and ViewingClassificationSeeder first.');
            return;
        }

        // Attach viewing classifications to profiles
        foreach ($profiles as $profile) {
            // Get a list of classification IDs that are not already attached to the profile
            $attachedClassifications = $profile->viewingClassifications->pluck('classification_id')->toArray();
            $availableClassifications = $classifications->whereNotIn('classification_id', $attachedClassifications);

            // If there are available classifications, attach 1–3 random ones
            if ($availableClassifications->isNotEmpty()) {
                $randomClassifications = $availableClassifications->random(rand(1, 3))->pluck('classification_id')->toArray();

                // Attach the random classifications to the profile
                foreach ($randomClassifications as $classificationId) {
                    if (!in_array($classificationId, $attachedClassifications)) {
                        $profile->viewingClassifications()->attach($classificationId);
                    }
                }
            }
        }

        $this->command->info('ProfileViewingClassificationSeeder completed successfully.');
    }
}