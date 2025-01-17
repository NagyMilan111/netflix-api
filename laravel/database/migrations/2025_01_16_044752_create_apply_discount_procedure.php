<?php

// database/migrations/xxxx_xx_xx_create_apply_discount_procedure.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateApplyDiscountProcedure extends Migration
{
    public function up()
    {
        DB::unprepared('
            CREATE PROCEDURE apply_discount (
                IN inviter_account_id INT,
                IN invitee_account_id INT,
                OUT result_message VARCHAR(255)
            )
            BEGIN
                DECLARE inviter_exists INT;
                DECLARE invitee_exists INT;
                DECLARE invitee_already_invited INT;

                SELECT COUNT(*) INTO inviter_exists
                FROM Account
                WHERE account_id = inviter_account_id;

                SELECT COUNT(*) INTO invitee_exists
                FROM Account
                WHERE account_id = invitee_account_id;

                SELECT COUNT(*) INTO invitee_already_invited
                FROM Discounted_Users
                WHERE invited_account_id = invitee_account_id;

                IF inviter_exists = 0 THEN
                    SET result_message = "Inviter does not exist.";
                ELSEIF invitee_exists = 0 THEN
                    SET result_message = "Invitee does not exist.";
                ELSEIF invitee_already_invited > 0 THEN
                    SET result_message = "Invitee has already been invited.";
                ELSE
                    INSERT INTO Discounted_Users (account_id, invited_account_id)
                    VALUES (inviter_account_id, invitee_account_id);

                    UPDATE Account
                    SET discount_active = 1
                    WHERE account_id = inviter_account_id;

                    UPDATE Account
                    SET discount_active = 1
                    WHERE account_id = invitee_account_id;

                    SET result_message = "Discount applied successfully.";
                END IF;
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS apply_discount');
    }
}