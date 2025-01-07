DELIMITER //
CREATE PROCEDURE update_currently_watched (
    IN p_profile_id INT,
    IN p_media_id INT,
    IN p_subtitle_id INT,
    IN p_pause_spot TIME,
    IN p_last_watch_date DATE,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE profile_exists INT;
    DECLARE media_exists INT;

    SELECT COUNT(*) INTO profile_exists
    FROM Profile
    WHERE profile_id = p_profile_id;

    SELECT COUNT(*) INTO media_exists
    FROM Media
    WHERE media_id = p_media_id;

    IF profile_exists = 0 THEN
        SET result_message = 'Profile does not exist.';
    ELSEIF media_exists = 0 THEN
        SET result_message = 'Media does not exist.';
    ELSE
        INSERT INTO Profile_Watched_Media (profile_id, media_id, subtitle_id, pause_spot, times_watched, last_watch_date)
        VALUES (p_profile_id, p_media_id, p_subtitle_id, p_pause_spot, 1, p_last_watch_date)
        ON DUPLICATE KEY UPDATE 
            subtitle_id = p_subtitle_id,
            pause_spot = p_pause_spot,
            times_watched = times_watched + 1,
            last_watch_date = p_last_watch_date;

        SET result_message = 'Currently watched media updated successfully.';
    END IF;
END //
DELIMITER ;
