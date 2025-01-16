<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateGetTotalViewsForProfileProcedure extends Migration
{
    public function up()
    {
        // Drop the procedure if it exists
        DB::unprepared('DROP PROCEDURE IF EXISTS GetTotalViewsForProfile');

        // Create the stored procedure
        DB::unprepared('
            CREATE PROCEDURE GetTotalViewsForProfile(IN profileId INT)
            BEGIN
                SELECT SUM(times_watched) AS total_views
                FROM views
                WHERE profile_id = profileId;
            END
        ');
    }

    public function down()
    {
        // Drop the stored procedure
        DB::unprepared('DROP PROCEDURE IF EXISTS GetTotalViewsForProfile');
    }
}