DELIMITER //
CREATE PROCEDURE add_watchlist (
    IN p_profile_id INT,
    IN media_id INT,
    IN series_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE watchlist_exists INT;

    SELECT COUNT(*) INTO watchlist_exists
    FROM Watchlist
    WHERE profile_id = p_profile_id;

    IF watchlist_exists > 0 THEN
        SET result_message = 'Watchlist already exists for this profile.';
    ELSE
        INSERT INTO Watchlist (profile_id, media_id, series_id)
        VALUES (p_profile_id, media_id, series_id);
        SET result_message = 'Watchlist added successfully.';
    END IF;
END //
DELIMITER ;
