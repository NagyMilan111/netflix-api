DELIMITER //
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
        SET result_message = 'Media not found.';
    ELSE
        DELETE FROM Media
        WHERE media_id = p_media_id;

        SET result_message = 'Media removed successfully.';
    END IF;
END //
DELIMITER ;
