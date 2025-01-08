<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Define seeders and their respective tables/views
        $seeders = [
            RolesSeeder::class => 'roles',
            SubscriptionsSeeder::class => 'subscriptions',
            AccountsSeeder::class => 'accounts',
            ProfilesSeeder::class => 'profiles',
            DiscountedUsersSeeder::class => 'discounted_users',
            GenresSeeder::class => 'genres',
            SeriesSeeder::class => 'series',
            EpisodesSeeder::class => 'episodes',
            MoviesSeeder::class => 'movies',
            MediasSeeder::class => 'medias',
            LanguagesSeeder::class => 'languages',
            SubtitlesSeeder::class => 'subtitles',
            ViewingClassificationsSeeder::class => 'viewing_classifications',
            ProfilesWatchedMediasSeeder::class => 'profiles_watched_medias',
            ProfilesWatchListSeeder::class => 'profiles_watch_list',
            ProfileGenresSeeder::class => 'profile_genres',
            ProfileViewingClassificationsSeeder::class => 'profiles_viewing_classifications',
        ];

        // Run regular table-based seeders
        foreach ($seeders as $seeder => $table) {
            if (DB::table($table)->count() === 0) {
                $this->call($seeder);
                $this->command->info("$seeder seeded successfully.");
            } else {
                $this->command->warn("$table table is not empty. Skipping $seeder.");
            }
        }

        // Handle the MoviesEpisodesSeeder separately as it creates a view
        $this->call(MoviesEpisodesSeeder::class);
        $this->command->info('MoviesEpisodesSeeder (view creation) executed successfully.');

        $this->command->info('Database seeded successfully.');
    }
}
