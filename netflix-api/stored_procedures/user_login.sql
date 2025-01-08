DELIMITER //
CREATE PROCEDURE user_login (
    IN user_email VARCHAR(255),
    IN user_password VARCHAR(255),
    OUT result_message VARCHAR(255)
)

BEGIN
    DECLARE stored_hashed_password VARCHAR(255);
    DECLARE user_blocked TINYINT(1);
    DECLARE user_exists INT;

    SELECT COUNT(*), hashed_password, blocked
    INTO user_exists, stored_hashed_password, user_blocked
    FROM Account
    WHERE email = user_email;

    IF user_exists = 0 THEN
        SET result_message = 'Login failed: User not found.';
    ELSEIF user_blocked = 1 THEN
        SET result_message = 'Login failed: User is blocked.';
    ELSE
        IF user_password = stored_hashed_password THEN
            SET result_message = 'Login successful.';
        ELSE
            SET result_message = 'Login failed: Incorrect password.';
        END IF;
    END IF;
END //
DELIMITER ;
