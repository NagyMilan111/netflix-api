<?php

// database/migrations/xxxx_xx_00_create_update_user_subscription_procedure.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateUpdateUserSubscriptionProcedure extends Migration
{
    public function up()
    {
        DB::unprepared('
            CREATE PROCEDURE update_user_subscription (
                IN user_email VARCHAR(255),
                IN new_subscription_id INT,
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
                    SET subscription_id = new_subscription_id
                    WHERE email = user_email;
                    SET result_message = "Subscription updated successfully.";
                END IF;
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_user_subscription');
    }
}