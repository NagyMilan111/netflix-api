DELIMITER //
CREATE PROCEDURE user_register (
    IN user_email VARCHAR(255),
    IN user_password VARCHAR(255),
    IN subscription_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE email_exists INT;

    SELECT COUNT(*) INTO email_exists
    FROM Account
    WHERE email = user_email;

    IF email_exists > 0 THEN
        SET result_message = 'Email already exists.';
    ELSE
        INSERT INTO Account (
            email, 
            hashed_password, 
            subscription_id, 
            blocked, 
            discount_active, 
            billed_from
        )
        VALUES (
            user_email,
            user_password,
            subscription_id,
            0,
            0,
            NULL
        );

        SET result_message = 'User registered successfully.';
    END IF;
END //
DELIMITER ;
