<?php

// database/migrations/xxxx_xx_xx_create_update_profile_preferences_procedure.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateUpdateProfilePreferencesProcedure extends Migration
{
    public function up()
    {
        DB::unprepared('
            CREATE PROCEDURE update_profile_preferences (
                IN p_profile_id INT,
                IN p_profile_name VARCHAR(255),
                IN p_profile_image VARCHAR(255),
                IN p_profile_age INT,
                IN p_profile_lang INT,
                IN p_profile_movies_preferred TINYINT(1),
                OUT result_message VARCHAR(255)
            )
            BEGIN
                DECLARE profile_exists INT;

                SELECT COUNT(*) INTO profile_exists
                FROM Profile
                WHERE profile_id = p_profile_id;

                IF profile_exists = 0 THEN
                    SET result_message = "Profile not found.";
                ELSE
                    UPDATE Profile
                    SET profile_name = p_profile_name,
                        profile_image = p_profile_image,
                        profile_age = p_profile_age,
                        profile_lang = p_profile_lang,
                        profile_movies_preferred = p_profile_movies_preferred
                    WHERE profile_id = p_profile_id;

                    SET result_message = "Profile preferences updated successfully.";
                END IF;
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_profile_preferences');
    }
}