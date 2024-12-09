<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MoviesEpisodesSeeder extends Seeder
{
    public function run()
    {
        // Drop the view if it exists to avoid conflicts
        DB::statement('DROP VIEW IF EXISTS movies_episodes');

        // Create the view
        DB::statement("
            CREATE OR REPLACE VIEW movies_episodes AS
            SELECT 
                m.movie_id AS id,
                m.genre_id,
                m.has_uhd_version,
                m.has_hd_version,
                m.title AS details,
                NULL AS episode_id,
                NULL AS series_id,
                'Movie' AS media_type
            FROM movies m
            UNION ALL
            SELECT 
                e.episode_id AS id,
                NULL AS genre_id,
                NULL AS has_uhd_version,
                NULL AS has_hd_version,
                e.title AS details,
                e.episode_id,
                e.series_id,
                'Episode' AS media_type
            FROM episodes e;
        ");
    }
}
