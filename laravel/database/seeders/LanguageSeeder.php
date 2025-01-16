<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run()
    {
        $languages = ['English', 'Spanish', 'Dutch', 'German', 'Japanese'];

        foreach ($languages as $language) {
            Language::firstOrCreate(['language_name' => $language]); // Ensure the column name matches
        }

        $this->command->info('Languages seeded successfully.');
    }
}