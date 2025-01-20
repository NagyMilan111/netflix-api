<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Check if the column already exists
        if (!Schema::hasColumn('Profile_Watched_Media', 'times_watched')) {
            Schema::table('Profile_Watched_Media', function (Blueprint $table) {
                $table->integer('times_watched')->default(0)->after('pause_spot');
            });
        }
    }

    public function down()
    {
        // Check if the column exists before dropping it
        if (Schema::hasColumn('Profile_Watched_Media', 'times_watched')) {
            Schema::table('Profile_Watched_Media', function (Blueprint $table) {
                $table->dropColumn('times_watched');
            });
        }
    }
};