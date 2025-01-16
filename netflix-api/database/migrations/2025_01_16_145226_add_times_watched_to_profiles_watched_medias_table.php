<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('profiles_watched_medias', function (Blueprint $table) {
            $table->integer('times_watched')->default(0)->after('pause_spot');
        });
    }

    public function down()
    {
        Schema::table('profiles_watched_medias', function (Blueprint $table) {
            $table->dropColumn('times_watched');
        });
    }
};
