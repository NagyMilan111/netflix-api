<?php

// database/migrations/xxxx_xx_00_create_add_watchlist_procedure.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateAddWatchlistProcedure extends Migration
{
    public function up()
    {
        DB::unprepared('
            CREATE PROCEDURE add_watchlist (
                IN profile_id INT,
                IN media_id INT,
                IN series_id INT,
                OUT result_message VARCHAR(255)
            )
            BEGIN
                DECLARE watchlist_exists INT;

                SELECT COUNT(*) INTO watchlist_exists
                FROM Watchlist
                WHERE profile_id = profile_id;

                IF watchlist_exists > 0 THEN
                    SET result_message = "Watchlist already exists for this profile.";
                ELSE
                    INSERT INTO Watchlist (profile_id, media_id, series_id)
                    VALUES (profile_id, media_id, series_id);
                    SET result_message = "Watchlist added successfully.";
                END IF;
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS add_watchlist');
    }
}