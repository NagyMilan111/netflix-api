<?php

// database/migrations/xxxx_xx_00_create_add_profile_procedure.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateAddProfileProcedure extends Migration
{
    public function up()
    {
        DB::unprepared('
            CREATE PROCEDURE add_profile (
                IN account_id INT,
                IN profile_name VARCHAR(255),
                IN profile_image VARCHAR(255),
                IN profile_age INT,
                IN profile_lang INT,
                IN profile_movies_preferred TINYINT(1),
                OUT result_message VARCHAR(255)
            )
            BEGIN
                DECLARE account_exists INT;

                SELECT COUNT(*) INTO account_exists
                FROM Account
                WHERE account_id = account_id;

                IF account_exists = 0 THEN
                    SET result_message = "Account not found.";
                ELSE
                    INSERT INTO Profile (
                        account_id, 
                        profile_name, 
                        profile_image, 
                        profile_age, 
                        profile_lang, 
                        profile_movies_preferred
                    )
                    VALUES (
                        account_id, 
                        profile_name, 
                        profile_image, 
                        profile_age, 
                        profile_lang, 
                        profile_movies_preferred
                    );
                    SET result_message = "Profile added successfully.";
                END IF;
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS add_profile');
    }
}