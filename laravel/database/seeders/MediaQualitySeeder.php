<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\MediaQuality;
use Illuminate\Database\Seeder;

class MediaQualitySeeder extends Seeder
{
    public function run()
    {
        // Get all media records
        $media = Media::all();

        // Ensure there are media records to associate with media qualities
        if ($media->isEmpty()) {
            $this->command->warn('No media records found. Please run the MediaSeeder first.');
            return;
        }

        // Create media qualities for each media record
        foreach ($media as $item) {
            MediaQuality::create([
                'media_id' => $item->media_id, // Ensure media_id is assigned
                'has_uhd_version' => (bool) rand(0, 1),
                'has_hd_version' => (bool) rand(0, 1),
                'has_sd_version' => (bool) rand(0, 1),
            ]);
        }
    }
}