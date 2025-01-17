<?php

// database/migrations/xxxx_xx_xx_create_block_user_procedure.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateBlockUserProcedure extends Migration
{
    public function up()
    {
        DB::unprepared('
            CREATE PROCEDURE block_user (
                IN user_email VARCHAR(255),
                OUT result_message VARCHAR(255)
            )
            BEGIN
                DECLARE user_exists INT;

                SELECT COUNT(*) INTO user_exists
                FROM Account
                WHERE email = user_email;

                IF user_exists = 0 THEN
                    SET result_message = "User not found.";
                ELSE
                    UPDATE Account
                    SET blocked = 1
                    WHERE email = user_email;
                    SET result_message = "User successfully blocked.";
                END IF;
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS block_user');
    }
}