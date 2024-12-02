<?php

namespace Database\Seeders;

use App\Models\ViewingClassification;
use Illuminate\Database\Seeder;

class ViewingClassificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ViewingClassification::factory(4)->create(); // Creates 4 classifications
    }
}
