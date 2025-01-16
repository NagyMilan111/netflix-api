DELIMITER //
CREATE PROCEDURE remove_watchlist (
    IN profile_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE watchlist_exists INT;

    SELECT COUNT(*) INTO watchlist_exists
    FROM Watchlist
    WHERE profile_id = profile_id;

    IF watchlist_exists = 0 THEN
        SET result_message = 'No watchlist exists for this profile.';
    ELSE
        DELETE FROM Watchlist
        WHERE profile_id = profile_id;
        SET result_message = 'Watchlist removed successfully.';
    END IF;
END //
DELIMITER ;
