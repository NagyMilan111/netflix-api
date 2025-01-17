<?php

// database/migrations/xxxx_xx_00_create_update_profile_genre_procedure.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateUpdateProfileGenreProcedure extends Migration
{
    public function up()
    {
        DB::unprepared('
            CREATE PROCEDURE update_profile_genre (
                IN p_profile_id INT,
                IN p_genre_id INT,
                OUT result_message VARCHAR(255)
            )
            BEGIN
                DECLARE profile_exists INT;
                DECLARE genre_exists INT;

                SELECT COUNT(*) INTO profile_exists
                FROM Profile
                WHERE profile_id = p_profile_id;

                SELECT COUNT(*) INTO genre_exists
                FROM Genre
                WHERE genre_id = p_genre_id;

                IF profile_exists = 0 THEN
                    SET result_message = "Profile does not exist.";
                ELSEIF genre_exists = 0 THEN
                    SET result_message = "Genre does not exist.";
                ELSE
                    INSERT INTO Profile_Genre (profile_id, genre_id)
                    VALUES (p_profile_id, p_genre_id)
                    ON DUPLICATE KEY UPDATE genre_id = p_genre_id;

                    SET result_message = "Profile genre updated successfully.";
                END IF;
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_profile_genre');
    }
}