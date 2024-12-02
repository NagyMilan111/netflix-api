<?php

namespace Database\Seeders;

use App\Models\Media;
use Illuminate\Database\Seeder;

class MediasSeeder extends Seeder
{
    public function run()
    {
        Media::factory(10)->create(); // Seed 10 media entries
        $this->command->info('Medias seeded successfully.');
    }
}
