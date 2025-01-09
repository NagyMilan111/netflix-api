DELIMITER //
CREATE PROCEDURE remove_profile (
    IN p_profile_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE profile_exists INT;

    SELECT COUNT(*) INTO profile_exists
    FROM Profile
    WHERE profile_id = p_profile_id;

    IF profile_exists = 0 THEN
        SET result_message = 'Profile not found.';
    ELSE
        DELETE FROM Profile
        WHERE profile_id = p_profile_id;
        SET result_message = 'Profile removed successfully.';
    END IF;
END //
DELIMITER ;
