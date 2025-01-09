DELIMITER //
CREATE PROCEDURE remove_watchlist (
    IN p_profile_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE watchlist_exists INT;

    SELECT COUNT(*) INTO watchlist_exists
    FROM Watchlist
    WHERE profile_id = p_profile_id;

    IF watchlist_exists = 0 THEN
        SET result_message = 'No watchlist exists for this profile.';
    ELSE
        DELETE FROM Watchlist
        WHERE profile_id = p_profile_id;
        SET result_message = 'Removed watchlist successfully.';
    END IF;
END //
DELIMITER ;
