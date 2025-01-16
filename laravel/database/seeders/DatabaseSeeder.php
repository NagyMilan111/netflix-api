<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Configuration for table seeders.
     * Set to `true` to enable table seeders.
     */
    protected $enableTableSeeders = true;


    protected $tableSeeders = [
        'accounts' => AccountSeeder::class,
        'profiles' => ProfileSeeder::class,
        'genres' => GenreSeeder::class,
        'series' => SeriesSeeder::class,
        'media' => MediaSeeder::class,
        'media_qualities' => MediaQualitySeeder::class,
        'subscriptions' => SubscriptionSeeder::class,
        'languages' => LanguageSeeder::class,
        'subtitles' => SubtitleSeeder::class,
        'profile_genre' => ProfileGenreSeeder::class,
        'viewing_classifications' => ViewingClassificationSeeder::class,
        'profile_viewing_classification' => ProfileViewingClassificationSeeder::class,
        'profile_watch_lists' => ProfileWatchListSeeder::class,
        'watchlists' =>  WatchlistSeeder::class,
        'profile_watched_media' => ProfileWatchedMediaSeeder::class,
        'discounted_users' => DiscountedUserSeeder::class,
        'tokens' => TokenSeeder::class,
        'views' => ViewSeeder::class,
    ];


    public function run()
    {
        // Run table seeders if enabled
        if ($this->enableTableSeeders) {
            $this->runTableSeeders();
        }
    }

    /**
     * Run seeders for tables if they are empty.
     */
    protected function runTableSeeders()
    {
        foreach ($this->tableSeeders as $table => $seederClass) {
            if (Schema::hasTable($table) && DB::table($table)->count() === 0) {
                $this->call($seederClass);
                $this->command->info("Seeded table: $table");
            } else {
                $this->command->warn("Skipping seeder for table: $table (not empty or does not exist)");
            }
        }
    }
}