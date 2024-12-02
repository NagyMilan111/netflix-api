<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguagesSeeder extends Seeder
{
    public function run()
    {
        $languages = ['English', 'Spanish', 'Dutch', 'German', 'Japanese'];

        foreach ($languages as $language) {
            Language::firstOrCreate(['language_name' => $language]); // Ensure the correct column is used
        }

        $this->command->info('Languages seeded successfully.');
    }
}
