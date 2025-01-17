<?php

// database/migrations/xxxx_xx_xx_create_remove_user_procedure.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateRemoveUserProcedure extends Migration
{
    public function up()
    {
        DB::unprepared('
            CREATE PROCEDURE remove_user (
                IN user_account_id INT,
                OUT result_message VARCHAR(255) 
            )
            BEGIN
                DECLARE account_exists INT; 

                SELECT COUNT(*) INTO account_exists
                FROM Account
                WHERE account_id = user_account_id;

                IF account_exists = 0 THEN
                    SET result_message = "Account not found."; 
                ELSE
                    DELETE FROM Discounted_Users
                    WHERE account_id = user_account_id;

                    DELETE FROM Discounted_Users
                    WHERE invited_account_id = user_account_id;

                    DELETE FROM Account
                    WHERE account_id = user_account_id;

                    SET result_message = "Account removed successfully.";
                END IF;
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS remove_user');
    }
}