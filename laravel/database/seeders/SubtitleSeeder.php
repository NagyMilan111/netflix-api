<?php

namespace Database\Seeders;

use App\Models\Subtitle;
use Illuminate\Database\Seeder;

class SubtitleSeeder extends Seeder
{
    public function run()
    {
        Subtitle::factory(10)->create(); // Create 10 subtitles
        $this->command->info('Subtitles seeded successfully.');
    }
}