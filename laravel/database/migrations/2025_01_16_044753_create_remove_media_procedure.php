<?php

// database/migrations/xxxx_xx_xx_create_remove_media_procedure.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateRemoveMediaProcedure extends Migration
{
    public function up()
    {
        DB::unprepared('
            CREATE PROCEDURE remove_media (
                IN p_media_id INT,
                OUT result_message VARCHAR(255)
            )
            BEGIN
                DECLARE media_exists INT;
                
                SELECT COUNT(*) INTO media_exists
                FROM Media
                WHERE media_id = p_media_id;

                IF media_exists = 0 THEN
                    SET result_message = "Media not found.";
                ELSE
                    DELETE FROM Media
                    WHERE media_id = p_media_id;

                    SET result_message = "Media removed successfully.";
                END IF;
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS remove_media');
    }
}