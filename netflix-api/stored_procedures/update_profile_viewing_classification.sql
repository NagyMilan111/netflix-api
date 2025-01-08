DELIMITER //
CREATE PROCEDURE update_profile_viewing_classification (
    IN p_profile_id INT,
    IN p_classification_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE profile_exists INT;
    DECLARE classification_exists INT;

    -- Check if the profile exists
    SELECT COUNT(*) INTO profile_exists
    FROM Profile
    WHERE profile_id = p_profile_id;

    -- Check if the classification exists
    SELECT COUNT(*) INTO classification_exists
    FROM Classification
    WHERE classification_id = p_classification_id;

    -- Validation checks
    IF profile_exists = 0 THEN
        SET result_message = 'Profile does not exist.';
    ELSEIF classification_exists = 0 THEN
        SET result_message = 'Classification does not exist.';
    ELSE
        -- Update or insert the profile viewing classification
        INSERT INTO Profile_Classification (profile_id, classification_id)
        VALUES (p_profile_id, p_classification_id)
        ON DUPLICATE KEY UPDATE classification_id = p_classification_id;

        SET result_message = 'Viewing classification updated successfully.';
    END IF;
END //
DELIMITER ;
