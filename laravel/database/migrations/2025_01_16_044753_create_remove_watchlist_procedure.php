<?php

// database/migrations/xxxx_xx_00_create_remove_watchlist_procedure.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateRemoveWatchlistProcedure extends Migration
{
    public function up()
    {
        DB::unprepared('
            CREATE PROCEDURE remove_watchlist (
                IN profile_id INT,
                OUT result_message VARCHAR(255)
            )
            BEGIN
                DECLARE watchlist_exists INT;

                SELECT COUNT(*) INTO watchlist_exists
                FROM Watchlist
                WHERE profile_id = profile_id;

                IF watchlist_exists = 0 THEN
                    SET result_message = "No watchlist exists for this profile.";
                ELSE
                    DELETE FROM Watchlist
                    WHERE profile_id = profile_id;
                    SET result_message = "Watchlist removed successfully.";
                END IF;
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS remove_watchlist');
    }
}