DELIMITER //
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
        SET result_message = 'User not found.';
    ELSE
        UPDATE Account
        SET blocked = 1
        WHERE email = user_email;
        SET result_message = 'User successfully blocked.';
    END IF;
END //
DELIMITER ;
