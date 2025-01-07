DELIMITER //
CREATE PROCEDURE add_media (
    IN p_title VARCHAR(255),
    IN p_duration TIME,
    IN p_series_id INT,
    IN p_season INT,
    IN p_genre_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE series_exists INT;
    DECLARE genre_exists INT;

    IF p_series_id IS NOT NULL THEN
        SELECT COUNT(*) INTO series_exists
        FROM Series
        WHERE series_id = p_series_id;

        IF series_exists = 0 THEN
            SET result_message = 'Series does not exist.';
            LEAVE BEGIN;
        END IF;
    END IF;

    IF p_genre_id IS NOT NULL THEN
        SELECT COUNT(*) INTO genre_exists
        FROM Genre
        WHERE genre_id = p_genre_id;

        IF genre_exists = 0 THEN
            SET result_message = 'Genre does not exist.';
            LEAVE BEGIN;
        END IF;
    END IF;

    INSERT INTO Media (title, duration, series_id, season, genre_id)
    VALUES (p_title, p_duration, p_series_id, p_season, p_genre_id);

    SET result_message = 'Media added successfully.';
END //
DELIMITER ;
