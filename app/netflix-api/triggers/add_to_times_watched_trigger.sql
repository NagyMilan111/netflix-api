DELIMITER //

CREATE TRIGGER update_times_watched
AFTER UPDATE ON Profile_Watched_Media
FOR EACH ROW
BEGIN
    DECLARE total_seconds INT;
    DECLARE watched_seconds INT;
    DECLARE percentage_watched DECIMAL(5, 2);

    --caalculate the total duration in seconds
    SELECT TIME_TO_SEC(duration) INTO total_seconds
    FROM Media
    WHERE media_id = NEW.media_id;

    --calculate the amount of time watched in seconds when paused
    SET watched_seconds = TIME_TO_SEC(NEW.pause_spot);

    --calculate the percentage watched
    SET percentage_watched = (watched_seconds / total_seconds) * 100;

    --check if its 90% watched
    IF percentage_watched >= 90 THEN
        --ensure it only adds once when its crossing 90%
        IF OLD.pause_spot < SEC_TO_TIME(total_seconds * 0.9) THEN
            UPDATE Profile_Watched_Media
            SET times_watched = times_watched + 1,
                last_watch_date = CURDATE()
            WHERE profile_id = NEW.profile_id AND media_id = NEW.media_id;
        END IF;
    END IF;
END;

//

DELIMITER ;
