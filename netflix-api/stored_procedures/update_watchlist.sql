DELIMITER //
CREATE PROCEDURE remove_watchlist (
    IN p_profile_id INT,
    IN p_media_id INT,
    IN p_series_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE watchlist_exists INT;

    SELECT COUNT(*) INTO watchlist_exists
    FROM Watchlist
    WHERE profile_id = p_profile_id AND media_id = p_media_id AND series_id = p_series_id ;

    IF watchlist_exists = 0 THEN
        SET result_message = 'No watchlist exists for this profile.';
    ELSE
        DELETE FROM Watchlist
        WHERE profile_id = p_profile_id AND media_id = p_media_id AND series_id = p_series_id;
        SET result_message = 'Removed from watchlist successfully.';
    END IF;
END //
DELIMITER ;
