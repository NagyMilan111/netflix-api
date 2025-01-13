DELIMITER //

CREATE PROCEDURE Add_Media (
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
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = result_message;
        END IF;
    END IF;

    IF p_genre_id IS NOT NULL THEN
        SELECT COUNT(*) INTO genre_exists
        FROM Genre
        WHERE genre_id = p_genre_id;

        IF genre_exists = 0 THEN
            SET result_message = 'Genre does not exist.';
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = result_message;
        END IF;
    END IF;

    INSERT INTO Media (title, duration, series_id, season, genre_id)
    VALUES (p_title, p_duration, p_series_id, p_season, p_genre_id);

    SET result_message = 'Media added successfully.';
END //

DELIMITER //

CREATE PROCEDURE Add_Profile (
    IN p_account_id INT,
    IN profile_name VARCHAR(255),
    IN profile_image VARCHAR(255),
    IN profile_age INT,
    IN profile_lang INT,
    IN profile_movies_preferred TINYINT(1),
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE account_exists INT;

    SELECT COUNT(*) INTO account_exists
    FROM Account
    WHERE account_id = p_account_id;

    IF account_exists = 0 THEN
        SET result_message = 'Account not found.';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = result_message;
    ELSE
        INSERT INTO Profile (
            account_id,
            profile_name,
            profile_image,
            profile_age,
            profile_lang,
            profile_movies_preferred
        )
        VALUES (
            p_account_id,
            profile_name,
            profile_image,
            profile_age,
            profile_lang,
            profile_movies_preferred
        );

        SET result_message = 'Profile added successfully.';
    END IF;
END //

DELIMITER //

CREATE PROCEDURE Add_Watchlist (
    IN p_profile_id INT,
    IN media_id INT,
    IN series_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE watchlist_exists INT;

    SELECT COUNT(*) INTO watchlist_exists
    FROM Watchlist
    WHERE profile_id = p_profile_id AND media_id = media_id AND series_id = series_id;

    IF watchlist_exists > 0 THEN
        SET result_message = 'Watchlist already exists for this profile.';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = result_message;
    ELSE
        INSERT INTO Watchlist (profile_id, media_id, series_id)
        VALUES (p_profile_id, media_id, series_id);
        SET result_message = 'Watchlist added successfully.';
    END IF;
END //

DELIMITER //

CREATE PROCEDURE Apply_Discount (
    IN inviter_account_id INT,
    IN invitee_account_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE inviter_exists INT;
    DECLARE invitee_exists INT;
    DECLARE invitee_already_invited INT;

    SELECT COUNT(*) INTO inviter_exists
    FROM Account
    WHERE account_id = inviter_account_id;

    SELECT COUNT(*) INTO invitee_exists
    FROM Account
    WHERE account_id = invitee_account_id;

    SELECT COUNT(*) INTO invitee_already_invited
    FROM Discounted_Users
    WHERE invited_account_id = invitee_account_id;

    IF inviter_exists = 0 THEN
        SET result_message = 'Inviter does not exist.';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = result_message;
    ELSEIF invitee_exists = 0 THEN
        SET result_message = 'Invitee does not exist.';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = result_message;
    ELSEIF invitee_already_invited > 0 THEN
        SET result_message = 'Invitee has already been invited.';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = result_message;
    ELSE
        INSERT INTO Discounted_Users (account_id, invited_account_id)
        VALUES (inviter_account_id, invitee_account_id);

        UPDATE Account
        SET discount_active = 1
        WHERE account_id = inviter_account_id;

        UPDATE Account
        SET discount_active = 1
        WHERE account_id = invitee_account_id;

        SET result_message = 'Discount applied successfully.';
    END IF;
END //

DELIMITER //

CREATE PROCEDURE Block_User (
    IN user_email VARCHAR(255),
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE user_exists INT;

    SELECT COUNT(*) INTO user_exists
    FROM Account
    WHERE email = user_email;

    IF user_exists = 0 THEN
        SET result_message = 'User not found.';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = result_message;
    ELSE
        UPDATE Account
        SET blocked = 1
        WHERE email = user_email;

        SET result_message = 'User successfully blocked.';
    END IF;
END //

DELIMITER //

CREATE PROCEDURE Remove_Media (
    IN p_media_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE media_exists INT;

    SELECT COUNT(*) INTO media_exists
    FROM Media
    WHERE media_id = p_media_id;

    IF media_exists = 0 THEN
        SET result_message = 'Media not found.';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = result_message;
    ELSE
        DELETE FROM Media
        WHERE media_id = p_media_id;

        SET result_message = 'Media removed successfully.';
    END IF;
END //

DELIMITER //

CREATE PROCEDURE Remove_Profile (
    IN p_profile_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE profile_exists INT;

    SELECT COUNT(*) INTO profile_exists
    FROM Profile
    WHERE profile_id = p_profile_id;

    IF profile_exists = 0 THEN
        SET result_message = 'Profile not found.';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = result_message;
    ELSE
        DELETE FROM Profile
        WHERE profile_id = p_profile_id;

        SET result_message = 'Profile removed successfully.';
    END IF;
END //

DELIMITER //

CREATE PROCEDURE Remove_User (
    IN user_account_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE account_exists INT;

    SELECT COUNT(*) INTO account_exists
    FROM Account
    WHERE account_id = user_account_id;

    IF account_exists = 0 THEN
        SET result_message = 'Account not found.';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = result_message;
    ELSE
        DELETE FROM Discounted_Users
        WHERE account_id = user_account_id OR invited_account_id = user_account_id;

        DELETE FROM Account
        WHERE account_id = user_account_id;

        SET result_message = 'Account removed successfully.';
    END IF;
END //

DELIMITER //

CREATE PROCEDURE Remove_Watchlist (
    IN p_profile_id INT,
    IN p_media_id INT,
    IN p_series_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE watchlist_exists INT;

    SELECT COUNT(*) INTO watchlist_exists
    FROM Watchlist
    WHERE profile_id = p_profile_id AND media_id = p_media_id AND series_id = p_series_id;

    IF watchlist_exists = 0 THEN
        SET result_message = 'No watchlist exists for this profile.';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = result_message;
    ELSE
        DELETE FROM Watchlist
        WHERE profile_id = p_profile_id AND media_id = p_media_id AND series_id = p_series_id;

        SET result_message = 'Removed from watchlist successfully.';
    END IF;
END //

DELIMITER //

CREATE PROCEDURE Update_Currently_Watched (
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
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = result_message;
    ELSEIF media_exists = 0 THEN
        SET result_message = 'Media does not exist.';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = result_message;
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

DELIMITER //

CREATE PROCEDURE Update_Profile_Genre (
    IN p_profile_id INT,
    IN p_genre_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE profile_exists INT;
    DECLARE genre_exists INT;

    SELECT COUNT(*) INTO profile_exists
    FROM Profile
    WHERE profile_id = p_profile_id;

    SELECT COUNT(*) INTO genre_exists
    FROM Genre
    WHERE genre_id = p_genre_id;

    IF profile_exists = 0 THEN
        SET result_message = 'Profile does not exist.';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = result_message;
    ELSEIF genre_exists = 0 THEN
        SET result_message = 'Genre does not exist.';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = result_message;
    ELSE
        INSERT INTO Profile_Genre (profile_id, genre_id)
        VALUES (p_profile_id, p_genre_id)
        ON DUPLICATE KEY UPDATE 
            genre_id = p_genre_id;

        SET result_message = 'Profile genre updated successfully.';
    END IF;
END //

DELIMITER //

CREATE PROCEDURE User_Login (
    IN user_email VARCHAR(255),
    IN user_password VARCHAR(255),
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE user_exists INT;
    DECLARE stored_password_hash VARCHAR(255);
    DECLARE user_blocked INT;

    SELECT COUNT(*), password, blocked
    INTO user_exists, stored_password_hash, user_blocked
    FROM Account
    WHERE email = user_email;

    IF user_exists = 0 THEN
        SET result_message = 'User not found.';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = result_message;
    ELSEIF user_blocked = 1 THEN
        SET result_message = 'User is blocked.';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = result_message;
    ELSEIF stored_password_hash != user_password THEN -- Replace with proper hashing check in practice
        SET result_message = 'Incorrect password.';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = result_message;
    ELSE
        SET result_message = 'User login successful.';
    END IF;
END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE Get_Media (
    IN p_media_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE media_exists INT;

    SELECT COUNT(*) INTO media_exists
    FROM Media
    WHERE media_id = p_media_id;

    IF media_exists = 0 THEN
        SET result_message = 'Media not found.';
    ELSE
        SELECT title, duration, series_id, season, genre_id
        INTO result_message
        FROM Media
        WHERE media_id = p_media_id;
    END IF;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE Get_Profile (
    IN p_profile_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE profile_exists INT;

    SELECT COUNT(*) INTO profile_exists
    FROM Profile
    WHERE profile_id = p_profile_id;

    IF profile_exists = 0 THEN
        SET result_message = 'Profile not found.';
    ELSE
        SELECT profile_name, profile_image, profile_age, profile_lang, profile_movies_preferred
        INTO result_message
        FROM Profile
        WHERE profile_id = p_profile_id;
    END IF;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE Get_Watchlist (
    IN p_profile_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE watchlist_exists INT;

    SELECT COUNT(*) INTO watchlist_exists
    FROM Watchlist
    WHERE profile_id = p_profile_id;

    IF watchlist_exists = 0 THEN
        SET result_message = 'No watchlist found for this profile.';
    ELSE
        SELECT media_id, series_id
        INTO result_message
        FROM Watchlist
        WHERE profile_id = p_profile_id;
    END IF;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE Register_User (
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
            DATE_ADD(CURDATE(), INTERVAL 7 DAY)
        );

        SET result_message = 'User registered successfully.';
    END IF;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE Update_Password (
    IN user_email VARCHAR(255),
    IN new_password VARCHAR(255),
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE user_exists INT;

    SELECT COUNT(*) INTO user_exists
    FROM Account
    WHERE email = user_email;

    IF user_exists = 0 THEN
        SET result_message = 'User not found.';
    ELSE
        UPDATE Account
        SET hashed_password = new_password
        WHERE email = user_email;

        SET result_message = 'Password updated successfully.';
    END IF;
END //
DELIMITER ;
