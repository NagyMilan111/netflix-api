<?php

namespace Database\Seeders;

use App\Models\ViewingClassification;
use Illuminate\Database\Seeder;

class ViewingClassificationSeeder extends Seeder
{
    public function run()
    {
        $classifications = ['G', 'PG', 'PG-13', 'R', 'NC-17'];

        foreach ($classifications as $classification) {
            ViewingClassification::create(['classification' => $classification]);
        }
    }
}