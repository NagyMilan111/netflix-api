<?php

// database/migrations/xxxx_xx_00_create_remove_profile_procedure.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateRemoveProfileProcedure extends Migration
{
    public function up()
    {
        DB::unprepared('
            CREATE PROCEDURE remove_profile (
                IN profile_id INT,
                OUT result_message VARCHAR(255)
            )
            BEGIN
                DECLARE profile_exists INT;

                SELECT COUNT(*) INTO profile_exists
                FROM Profile
                WHERE profile_id = profile_id;

                IF profile_exists = 0 THEN
                    SET result_message = "Profile not found.";
                ELSE
                    DELETE FROM Profile
                    WHERE profile_id = profile_id;
                    SET result_message = "Profile removed successfully.";
                END IF;
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS remove_profile');
    }
}