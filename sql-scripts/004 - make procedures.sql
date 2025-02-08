DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Add_Media(
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
        SELECT COUNT(*)
        INTO series_exists
        FROM Series
        WHERE series_id = p_series_id;

        IF series_exists = 0 THEN
            SET result_message = 'Series does not exist.';
        END IF;
    END IF;

    IF p_genre_id IS NOT NULL THEN
        SELECT COUNT(*)
        INTO genre_exists
        FROM Genre
        WHERE genre_id = p_genre_id;

        IF genre_exists = 0 THEN
            SET result_message = 'Genre does not exist.';
        END IF;
    END IF;

    INSERT INTO Media (title, duration, series_id, season, genre_id)
    VALUES (p_title, p_duration, p_series_id, p_season, p_genre_id);

    SET result_message = 'Media added successfully.';
END //

DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Add_Profile(
    IN p_account_id INT,
    IN p_profile_name VARCHAR(255),
    IN p_profile_image VARCHAR(255),
    IN p_profile_age INT,
    IN p_profile_lang INT,
    IN p_profile_movies_preferred TINYINT(1),
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE account_exists INT;
    DECLARE amount_of_profiles INT;

    SELECT COUNT(*)
    INTO account_exists
    FROM Account
    WHERE account_id = p_account_id;

    IF account_exists = 0 THEN
        SET result_message = 'Account not found.';
    ELSE

        SELECT COUNT(*)
        INTO amount_of_profiles
        FROM Profile
        WHERE account_id = p_account_id;

        IF amount_of_profiles < 4 THEN


            INSERT INTO Profile (account_id,
                                 profile_name,
                                 profile_image,
                                 profile_age,
                                 profile_lang,
                                 profile_movies_preferred)
            VALUES (p_account_id,
                    p_profile_name,
                    p_profile_image,
                    p_profile_age,
                    p_profile_lang,
                    p_profile_movies_preferred);

            SET result_message = 'Profile added successfully.';
        ELSE
            SET result_message = 'Can not add profile, too many profiles present already.';
        END IF;
    END IF;
END //

DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Add_Watchlist(
    IN p_profile_id INT,
    IN input_media_id INT,
    IN input_series_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE watchlist_exists INT;

    SELECT COUNT(*)
    INTO watchlist_exists
    FROM Profile_Watch_List
    WHERE profile_id = p_profile_id
      AND media_id = input_media_id
      AND series_id = input_series_id;

    IF watchlist_exists > 0 THEN
        SET result_message = 'Watchlist already exists for this profile.';
    ELSE
        INSERT INTO Profile_Watch_List (profile_id, media_id, series_id)
        VALUES (p_profile_id, media_id, series_id);
        SET result_message = 'Watchlist added successfully.';
    END IF;
END //

DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Apply_Discount(
    IN inviter_account_id INT,
    IN invitee_account_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE inviter_exists INT;
    DECLARE invitee_exists INT;
    DECLARE invitee_already_invited INT;

    SELECT COUNT(*)
    INTO inviter_exists
    FROM Account
    WHERE account_id = inviter_account_id;

    SELECT COUNT(*)
    INTO invitee_exists
    FROM Account
    WHERE account_id = invitee_account_id;

    SELECT COUNT(*)
    INTO invitee_already_invited
    FROM Discounted_Users
    WHERE invited_account_id = invitee_account_id;

    IF inviter_exists = 0 THEN
        SET result_message = 'Inviter does not exist.';
    ELSEIF invitee_exists = 0 THEN
        SET result_message = 'Invitee does not exist.';
    ELSEIF invitee_already_invited > 0 THEN
        SET result_message = 'Invitee has already been invited.';
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

CREATE DEFINER=`senior`@`%` PROCEDURE Block_User(
    IN user_email VARCHAR(255),
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE user_exists INT;
    DECLARE rows_affected INT;

    SELECT COUNT(*)
    INTO user_exists
    FROM Account
    WHERE email = user_email;

    IF user_exists = 0 THEN
        SET result_message = 'User not found.';
    ELSE
        UPDATE Account
        SET blocked = 1
        WHERE email = user_email;

        SET rows_affected = ROW_COUNT();

        IF rows_affected > 0 THEN
            SET result_message = 'User successfully blocked.';
        ELSE
            SET result_message = 'User already blocked.';
        END IF;
    END IF;
END //

DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Remove_Media(
    IN p_media_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE media_exists INT;

    SELECT COUNT(*)
    INTO media_exists
    FROM Media
    WHERE media_id = p_media_id;

    IF media_exists = 0 THEN
        SET result_message = 'Media not found.';
    ELSE
        DELETE
        FROM Media
        WHERE media_id = p_media_id;

        SET result_message = 'Media removed successfully.';
    END IF;
END //

DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Remove_Profile(
    IN p_profile_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE profile_exists INT;

    SELECT COUNT(*)
    INTO profile_exists
    FROM Profile
    WHERE profile_id = p_profile_id;

    IF profile_exists = 0 THEN
        SET result_message = 'Profile not found.';
    ELSE
        DELETE
        FROM Profile
        WHERE profile_id = p_profile_id;

        SET result_message = 'Profile removed successfully.';
    END IF;
END //

DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Remove_Account(
    IN user_account_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE account_exists INT;

    SELECT COUNT(*)
    INTO account_exists
    FROM Account
    WHERE account_id = user_account_id;

    IF account_exists = 0 THEN
        SET result_message = 'Account not found.';
    ELSE
        DELETE
        FROM Discounted_Users
        WHERE account_id = user_account_id
           OR invited_account_id = user_account_id;

        DELETE
        FROM Account
        WHERE account_id = user_account_id;

        SET result_message = 'Account removed successfully.';
    END IF;
END //

DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Remove_Watchlist(
    IN p_profile_id INT,
    IN p_media_id INT,
    IN p_series_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE watchlist_exists INT;

    SELECT COUNT(*)
    INTO watchlist_exists
    FROM Profile_Watch_List
    WHERE profile_id = p_profile_id
      AND media_id = p_media_id
      AND series_id = p_series_id;

    IF watchlist_exists = 0 THEN
        SET result_message = 'No watchlist exists for this profile.';
    ELSE
        DELETE
        FROM Profile_Watch_List
        WHERE profile_id = p_profile_id
          AND media_id = p_media_id
          AND series_id = p_series_id;

        SET result_message = 'Removed from watchlist successfully.';
    END IF;
END //

DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Update_Currently_Watched(
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

    SELECT COUNT(*)
    INTO profile_exists
    FROM Profile
    WHERE profile_id = p_profile_id;

    SELECT COUNT(*)
    INTO media_exists
    FROM Media
    WHERE media_id = p_media_id;

    IF profile_exists = 0 THEN
        SET result_message = 'Profile does not exist.';
    ELSEIF media_exists = 0 THEN
        SET result_message = 'Media does not exist.';
    ELSE
        INSERT INTO Profile_Watched_Media (profile_id, media_id, subtitle_id, pause_spot, times_watched,
                                           last_watch_date)
        VALUES (p_profile_id, p_media_id, p_subtitle_id, p_pause_spot, 1, p_last_watch_date)
        ON DUPLICATE KEY UPDATE subtitle_id     = p_subtitle_id,
                                pause_spot      = p_pause_spot,
                                times_watched   = times_watched + 1,
                                last_watch_date = p_last_watch_date;

        SET result_message = 'Currently watched media updated successfully.';
    END IF;
END //

DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Update_Profile_Genre(
    IN p_profile_id INT,
    IN p_genre_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE profile_exists INT;
    DECLARE genre_exists INT;

    SELECT COUNT(*)
    INTO profile_exists
    FROM Profile
    WHERE profile_id = p_profile_id;

    SELECT COUNT(*)
    INTO genre_exists
    FROM Genre
    WHERE genre_id = p_genre_id;

    IF profile_exists = 0 THEN
        SET result_message = 'Profile does not exist.';
    ELSEIF genre_exists = 0 THEN
        SET result_message = 'Genre does not exist.';
    ELSE
        INSERT INTO Profile_Genre (profile_id, genre_id)
        VALUES (p_profile_id, p_genre_id)
        ON DUPLICATE KEY UPDATE genre_id = p_genre_id;

        SET result_message = 'Profile genre updated successfully.';
    END IF;
END //

DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE User_Login(
    IN user_email VARCHAR(255),
    OUT result_message VARCHAR(255),
    OUT result_account_id INT,
    OUT result_hashed_password VARCHAR(255)
)
BEGIN
    DECLARE user_exists INT DEFAULT 0;
    DECLARE temp_hashed_password VARCHAR(255);
    DECLARE user_blocked INT;
    DECLARE temp_account_id INT;

    -- Check if the user exists and retrieve the necessary details
    SELECT COUNT(*), account_id, hashed_password, blocked
    INTO user_exists, temp_account_id, temp_hashed_password, user_blocked
    FROM Account
    WHERE email = user_email;

    -- If no user is found, set the result message and return
    IF user_exists = 0 THEN
        SET result_message = 'User not found.';
        SET result_account_id = NULL;
        SET result_hashed_password = NULL;
        -- If the user is blocked, set the result message and return
    ELSEIF user_blocked = 1 THEN
        SET result_message = 'User is blocked.';
        SET result_account_id = NULL;
        SET result_hashed_password = NULL;
    ELSE
        SET result_message = 'Authentication required.';
        SET result_account_id = temp_account_id;
        SET result_hashed_password = temp_hashed_password;
    END IF;
END //

DELIMITER ;


DELIMITER ;

DELIMITER //
CREATE DEFINER=`senior`@`%` PROCEDURE Get_Media(
    IN p_media_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE media_exists INT;

    SELECT COUNT(*)
    INTO media_exists
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
CREATE DEFINER=`senior`@`%` PROCEDURE Get_Profile(
    IN p_profile_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE profile_exists INT;

    SELECT COUNT(*)
    INTO profile_exists
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
CREATE DEFINER=`senior`@`%` PROCEDURE Register_User(
    IN user_email VARCHAR(255),
    IN user_password VARCHAR(255),
    IN p_subscription_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE email_exists INT;

    SELECT COUNT(*)
    INTO email_exists
    FROM Account
    WHERE email = user_email;

    IF email_exists > 0 THEN
        SET result_message = 'Email already exists.';
    ELSE
        INSERT INTO Account (email,
                             hashed_password,
                             subscription_id,
                             blocked,
                             discount_active,
                             billed_from)
        VALUES (user_email,
                user_password,
                p_subscription_id,
                0,
                0,
                DATE_ADD(CURDATE(), INTERVAL 7 DAY));

        SET result_message = 'User registered successfully.';
    END IF;
END //
DELIMITER ;

DELIMITER //
CREATE DEFINER=`senior`@`%` PROCEDURE Update_Password(
    IN user_email VARCHAR(255),
    IN new_password VARCHAR(255),
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE user_exists INT;

    SELECT COUNT(*)
    INTO user_exists
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

DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Update_Pause_Spot(
    IN input_profile_id INT,
    IN input_media_id INT,
    IN input_pause_spot VARCHAR(255),
    OUT output_message VARCHAR(255),
    OUT output_pause_spot VARCHAR(255)
)
BEGIN
    DECLARE row_count INT;
    DECLARE profile_exists INT;
    DECLARE media_exists INT;

    SELECT COUNT(*)
    INTO profile_exists
    FROM Profile
    WHERE profile_id = input_profile_id;

    IF profile_exists > 0 THEN

        SELECT COUNT(*)
        INTO media_exists
        FROM Media
        WHERE media_id = input_media_id;

        IF media_exists > 0 THEN

            -- Update the pause_spot for the given media
            UPDATE Profile_Watched_Media
            SET pause_spot = input_pause_spot
            WHERE profile_id = input_profile_id
              AND media_id = input_media_id;

            -- Check if any row was updated
            SET row_count = ROW_COUNT();

            IF row_count = 0 THEN
                SET output_message = 'Failed to update pause spot.';
                SET output_pause_spot = NULL;
            END IF;

            -- Success message
            SET output_message = 'Media paused.';
            SET output_pause_spot = input_pause_spot;
        ELSE
            SET output_message = 'Media not found.';
            SET output_pause_spot = NULL;
        END IF;
    ELSE
        SET output_message = 'Profile not found.';
        SET output_pause_spot = NULL;
    END IF;
END //

DELIMITER ;

DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Fetch_Pause_Spot(
    IN input_profile_id INT,
    IN input_media_id INT,
    OUT output_message VARCHAR(255),
    OUT output_pause_spot VARCHAR(255)
)
BEGIN
    DECLARE p_pause_spot TIME;
    DECLARE media_exists INT;
    DECLARE profile_exists INT;

    -- Validate that the media exists
    SELECT COUNT(*)
    INTO media_exists
    FROM Media
    WHERE media_id = input_media_id;

    IF media_exists > 0 THEN


        SELECT COUNT(*)
        INTO profile_exists
        FROM Profile
        WHERE profile_id = input_profile_id;

        IF profile_exists > 0 THEN

            -- Fetch the last pause spot
            SELECT p_pause_spot
            INTO p_pause_spot
            FROM Profile_Watched_Media
            WHERE profile_id = input_profile_id
              AND media_id = input_media_id;

            -- Check if the watch data exists
            IF p_pause_spot IS NOT NULL THEN

                -- Success message
                SET output_message = 'Media resumed.';
                SET output_pause_spot = p_pause_spot;
            ELSE
                SET output_message = 'No watch data was found for this media.';
                SET output_pause_spot = NULL;
            END IF;

        ELSE
            SET output_message = 'Profile not found.';
            SET output_pause_spot = NULL;
        END IF;
    ELSE
        SET output_message = 'Media not found.';
        SET output_pause_spot = NULL;
    END IF;
END //

DELIMITER ;


DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Log_Play_Action(
    IN input_profile_id INT,
    IN input_media_id INT,
    OUT output_message VARCHAR(255),
    OUT output_media_id INT
)
BEGIN
    DECLARE media_exists INT;
    DECLARE profile_exists INT;

    SELECT COUNT(*)
    INTO media_exists
    FROM Media
    WHERE media_id = input_media_id;

    IF media_exists = 0 THEN
        SET output_message = 'Media not found.';
        SET output_media_id = NULL;
    ELSE

        SELECT COUNT(*)
        INTO profile_exists
        FROM Profile
        WHERE profile_id = input_profile_id;

        IF profile_exists > 0 THEN

            INSERT INTO Profile_Watched_Media (profile_id, media_id, pause_spot, last_watch_date)
            VALUES (input_profile_id, input_media_id, '00:00:00', NOW())
            ON DUPLICATE KEY UPDATE pause_spot      = '00:00:00',
                                    last_watch_date = NOW();

            -- Success message
            SET output_message = 'Media is playing.';
            SET output_media_id = input_media_id;

        ELSE
            SET output_message = 'Profile not found.';
            SET output_media_id = NULL;
        END IF;
    END IF;
END //

DELIMITER ;


DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Update_Profile_Preferences(
    IN input_profile_id INT,
    IN input_profile_movies_preferred BOOLEAN,
    OUT output_message VARCHAR(255)
)
BEGIN
    DECLARE profile_exists INT;
    DECLARE current_preference BOOLEAN;
    DECLARE rows_affected INT;

    -- Validate that the profile exists
    SELECT COUNT(*), profile_movies_preferred
    INTO profile_exists, current_preference
    FROM Profile
    WHERE profile_id = input_profile_id;

    IF profile_exists = 1 THEN
        -- Check if the new value is different from the current value
        IF input_profile_movies_preferred IS NOT NULL AND input_profile_movies_preferred != current_preference THEN
            -- Update preferences in the database
            UPDATE Profile
            SET profile_movies_preferred = input_profile_movies_preferred
            WHERE profile_id = input_profile_id;

            -- Check if any row was updated
            SET rows_affected = ROW_COUNT();

            IF rows_affected = 1 THEN
                SET output_message = 'Preferences updated successfully.';
            ELSE
                SET output_message = 'Failed to update preferences.';
            END IF;
        ELSE
            -- No changes were made
            SET output_message = 'Failed to update preferences due to no changes being made.';
        END IF;
    ELSE
        -- Profile not found
        SET output_message = 'Profile not found.';
    END IF;
END //

DELIMITER ;

DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Update_Account_Subscription(
    IN input_account_id INT,
    IN input_subscription_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE account_exists INT;
    DECLARE subscription_exists INT;
    DECLARE rows_affected INT;

    -- Validate that the account exists
    SELECT COUNT(*)
    INTO account_exists
    FROM Account
    WHERE account_id = input_account_id;

    IF account_exists = 1 THEN


        -- Validate that the subscription exists
        SELECT COUNT(*)
        INTO subscription_exists
        FROM Subscription
        WHERE subscription_id = input_subscription_id;

        IF subscription_exists = 1 THEN


            -- Update the subscription details for the given account
            UPDATE Account
            SET subscription_id = input_subscription_id
            WHERE account_id = input_account_id;

            -- Check if any row was updated
            SET rows_affected = ROW_COUNT();

            IF rows_affected = 0 THEN
                SET result_message = 'Failed to update subscription. No changes made.';
            ELSE
                SET result_message = 'Subscription updated successfully.';
            END IF;

        ELSE
            SET result_message = 'Subscription not found.';
        END IF;

    ELSE
        SET result_message = 'Account not found.';
    END IF;
END //

DELIMITER ;


DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Insert_Token(
    IN input_account_id INT,
    IN input_token VARCHAR(255),
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE rows_affected INT;

    INSERT INTO Tokens (account_id, token)
    VALUES (input_account_id, input_token);

    SET rows_affected = ROW_COUNT();

    IF rows_affected > 0 THEN
        SET result_message = 'Token inserted successfully.';
    ELSE
        SET  result_message = 'Something went wrong.';
    END IF;
END //

DELIMITER ;


DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Delete_Token(
    IN input_token VARCHAR(255),
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE rows_affected INT;

    -- Delete the token from the Tokens table
    DELETE
    FROM Tokens
    WHERE token = input_token;

    -- Check if any row was deleted
    SET rows_affected = ROW_COUNT();

    IF rows_affected > 0 THEN
        SET result_message = 'Token deleted successfully.';
    ELSE
        SET result_message = 'No matching token found to delete.';
    END IF;
END //

DELIMITER ;


DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Update_Token(
    IN old_token VARCHAR(255),
    IN new_token VARCHAR(255),
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE rows_affected INT;

    -- Update the token in the Tokens table
    UPDATE Tokens
    SET token = new_token
    WHERE token = old_token;

    -- Check if any row was updated
    SET rows_affected = ROW_COUNT();

    IF rows_affected > 0 THEN
        SET result_message = 'Token updated successfully.';
    ELSE
        SET result_message = 'No matching token found to update.';
    END IF;
END //

DELIMITER ;

DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Update_Profile_Watch_List(
    IN input_profile_id INT,
    IN input_media_id INT,
    IN input_series_id INT,
    IN input_action varchar(255),
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE profile_exists INT;
    DECLARE media_exists INT;
    DECLARE series_exists INT;
    DECLARE rows_affected INT;

    SELECT COUNT(*)
    INTO profile_exists
    FROM Profile
    WHERE profile_id = input_profile_id;

    IF profile_exists > 0 THEN

        SELECT COUNT(*)
        INTO media_exists
        FROM Media
        WHERE media_id = input_media_id;

        IF media_exists > 0 THEN

            SELECT COUNT(*)
            INTO series_exists
            FROM Series
            WHERE series_id = input_series_id;

            IF input_series_id IS NULL THEN

                IF input_action = 'add' THEN
                    INSERT INTO Profile_Watch_List (profile_id, media_id, series_id)
                    VALUES (input_profile_id, input_media_id, NULL);
                    SET rows_affected = ROW_COUNT();
                    SET result_message = 'Media added to watch list successfully.';
                ELSE
                    DELETE
                    FROM Profile_Watch_List
                    WHERE profile_id = input_profile_id
                      AND media_id = input_media_id
                      AND series_id IS NULL;
                    SET rows_affected = ROW_COUNT();
                    SET result_message = 'Media removed from watch list successfully.';
                END IF;

            ELSEIF series_exists > 0 THEN
                IF input_action = 'add' THEN
                    INSERT INTO Profile_Watch_List (profile_id, media_id, series_id)
                    VALUES (input_profile_id, input_media_id, input_series_id);
                    SET rows_affected = ROW_COUNT();
                    SET result_message = 'Media added to watch list successfully.';
                ELSE
                    DELETE
                    FROM Profile_Watch_List
                    WHERE profile_id = input_profile_id
                      AND media_id = input_media_id
                      AND series_id = series_id;
                    SET rows_affected = ROW_COUNT();
                    SET result_message = 'Media removed from watch list successfully.';
                END IF;
            ELSE
                SET result_message = 'Series not found.';
            END IF;
        ELSE
            SET result_message = 'Media not found.';
        END IF;
    ELSE
        SET result_message = 'Profile not found.';
    END IF;
END //

DELIMITER ;


DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Delete_From_Profile_Watch_List(
    IN input_profile_id INT,
    IN input_media_id INT,
    IN input_series_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    -- Delete the row from the Profile_Watch_List table
    DELETE
    FROM Profile_Watch_List
    WHERE profile_id = input_profile_id
      AND media_id = input_media_id
      AND (
        (series_id IS NULL AND input_series_id IS NULL) OR
        (series_id = input_series_id)
        );

    -- Check if any row was deleted
    IF ROW_COUNT() > 0 THEN
        SET result_message = 'Row deleted from Profile_Watch_List successfully.';
    ELSE
        SET result_message = 'No matching row found to delete.';
    END IF;
END //

DELIMITER ;

DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Insert_Series(
    IN input_title VARCHAR(255),
    IN input_genre_id INT,
    IN input_number_of_seasons INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE rows_affected INT;
    DECLARE genre_exists INT;

    SELECT COUNT(*)
    INTO genre_exists
    FROM Genre
    WHERE genre_id = input_genre_id;

    IF genre_exists > 0 THEN

        -- Insert the values into the Series table
        INSERT INTO Series (title, genre_id, number_of_seasons)
        VALUES (input_title, input_genre_id, input_number_of_seasons);

        -- Check if the insertion was successful
        SET rows_affected = ROW_COUNT();

        IF rows_affected > 0 THEN
            SET result_message = 'Series inserted successfully.';
        ELSE
            SET result_message = 'Failed to insert series.';
        END IF;
    ELSE
        SET result_message = 'Genre not found.';
    END IF;
END //

DELIMITER ;


DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Update_Series(
    IN input_id INT,
    IN input_title VARCHAR(255),
    IN input_genre_id INT,
    IN input_number_of_seasons INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE series_exists INT;
    DECLARE rows_affected INT;

    -- Check if the series exists
    SELECT COUNT(*)
    INTO series_exists
    FROM Series
    WHERE series_id = input_id;

    IF series_exists = 1 THEN

        -- Update the Series table with the provided values
        UPDATE Series
        SET title             = input_title,
            genre_id          = input_genre_id,
            number_of_seasons = input_number_of_seasons
        WHERE series_id = input_id;

        -- Check if any row was updated
        SET rows_affected = ROW_COUNT();

        IF rows_affected > 0 THEN
            SET result_message = 'Series updated successfully.';
        ELSE
            SET result_message = 'Failed to update series. No changes made.';
        END IF;

    ELSE
        SET result_message = 'Series not found.';
    END IF;
END //

DELIMITER ;

DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Delete_Series(
    IN input_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE series_exists INT;
    DECLARE rows_affected INT;

    -- Check if the series exists
    SELECT COUNT(*)
    INTO series_exists
    FROM Series
    WHERE series_id = input_id;

    IF series_exists = 1 THEN


        -- Delete the series from the Series table
        DELETE
        FROM Series
        WHERE series_id = input_id;

        -- Check if any row was deleted
        SET rows_affected = ROW_COUNT();

        IF rows_affected > 0 THEN
            SET result_message = 'Series deleted successfully.';
        ELSE
            SET result_message = 'Failed to delete series.';
        END IF;

    ELSE
        SET result_message = 'Series not found.';
    END IF;
END //

DELIMITER ;

DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Insert_Episode(
    IN input_title VARCHAR(255),
    IN input_duration TIME,
    IN input_series_id INT,
    IN input_season INT,
    IN input_genre_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE rows_affected INT;
    DECLARE series_exists INT;
    DECLARE genre_exists INT;

    SELECT COUNT(*)
    INTO series_exists
    FROM Series
    WHERE series_id = input_series_id;

    IF series_exists > 0 THEN

        SELECT COUNT(*)
        INTO genre_exists
        FROM Genre
        WHERE genre_id = input_genre_id;

        IF genre_exists > 0 THEN

            INSERT INTO Media (title, duration, series_id, season, genre_id)
            VALUES (input_title, input_duration, input_series_id, input_season, input_genre_id);

            -- Check if the row was successfully inserted
            SET rows_affected = ROW_COUNT();

            IF rows_affected > 0 THEN
                SET result_message = 'Episode inserted successfully.';
            ELSE
                SET result_message = 'Failed to insert episode.';
            END IF;
        ELSE
            SET result_message = 'Genre not found.';
        END IF;
    ELSE
        SET result_message = 'Series not found.';
    END IF;
END //

DELIMITER ;

DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Update_Episode(
    IN input_id INT,
    IN input_title VARCHAR(255),
    IN input_duration TIME,
    IN input_series_id INT,
    IN input_season INT,
    IN input_genre_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE episode_exists INT;
    DECLARE rows_affected INT;

    DECLARE series_exists INT;
    DECLARE genre_exists INT;

    SELECT COUNT(*)
    INTO series_exists
    FROM Series
    WHERE series_id = input_series_id;

    IF series_exists > 0 THEN

        SELECT COUNT(*)
        INTO genre_exists
        FROM Genre
        WHERE genre_id = input_genre_id;

        IF genre_exists > 0 THEN

            -- Check if the episode exists in the Media table
            SELECT COUNT(*)
            INTO episode_exists
            FROM Media
            WHERE media_id = input_id;

            IF episode_exists > 0 THEN


                -- Update the episode in the Media table
                UPDATE Media
                SET title     = input_title,
                    duration  = input_duration,
                    series_id = input_series_id,
                    season    = input_season,
                    genre_id  = input_genre_id
                WHERE media_id = input_id;

                -- Check if any row was updated
                SET rows_affected = ROW_COUNT();

                IF rows_affected > 0 THEN
                    SET result_message = 'Episode updated successfully.';
                ELSE
                    SET result_message = 'Failed to update episode. No changes made.';
                END IF;
            ELSE
                SET result_message = 'Episode not found.';
            END IF;
        ELSE
            SET result_message = 'Genre not found.';
        END IF;
    ELSE
        SET result_message = 'Series not found.';
    END IF;
END //

DELIMITER ;

DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Delete_Episode(
    IN input_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE episode_exists INT;
    DECLARE rows_affected INT;

    -- Check if the episode exists in the Media table
    SELECT COUNT(*)
    INTO episode_exists
    FROM Media
    WHERE media_id = input_id;

    IF episode_exists = 1 THEN


        -- Delete the episode from the Media table
        DELETE
        FROM Media
        WHERE media_id = input_id;

        -- Check if any row was deleted
        SET rows_affected = ROW_COUNT();

        IF rows_affected > 0 THEN
            SET result_message = 'Episode deleted successfully.';
        ELSE
            SET result_message = 'Failed to delete episode.';
        END IF;
    ELSE
        SET result_message = 'Episode not found.';
    END IF;
END //

DELIMITER ;

DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Update_Profile_Viewing_Classification(
    IN input_profile_id INT,
    IN input_classification_id INT,
    IN input_action VARCHAR(255),
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE profile_exists INT;
    DECLARE classification_exists INT;
    DECLARE rows_affected INT;

    SELECT COUNT(*)
    INTO profile_exists
    FROM Profile
    WHERE profile_id = input_profile_id;

    IF profile_exists > 0 THEN

        SELECT COUNT(*)
        INTO classification_exists
        FROM Viewing_Classification
        WHERE classification_id = input_classification_id;

        IF classification_exists > 0 THEN

            IF input_action = 'add' THEN

                INSERT INTO Profile_Viewing_Classification (profile_id, classification_id)
                VALUES (input_profile_id, input_classification_id);

                SET rows_affected = ROW_COUNT();

                IF rows_affected > 0 THEN
                    SET result_message = 'Viewing classification added successfully.';
                ELSE
                    SET result_message = 'Failed to add viewing classification.';
                END IF;
            ELSE
                DELETE
                FROM Profile_Viewing_Classification
                WHERE profile_id = input_profile_id
                  AND classification_id = input_classification_id;

                SET rows_affected = ROW_COUNT();

                IF rows_affected > 0 THEN
                    SET result_message = 'Viewing classification removed successfully.';
                ELSE
                    SET result_message = 'Failed to remove viewing classification.';
                END IF;
            END IF;
        ELSE
            SET result_message = 'Viewing classification not found.';
        END IF;
    ELSE
        SET result_message = 'Profile not found.';
    END IF;

END //

DELIMITER ;

DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Insert_Classification(
    IN input_classification VARCHAR(255),
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE rows_affected INT;

    INSERT INTO Viewing_Classification (classification)
    VALUES (input_classification);

    -- Check if the row was successfully inserted
    SET rows_affected = ROW_COUNT();

    IF rows_affected > 0 THEN
        SET result_message = 'Classification inserted successfully.';
    ELSE
        SET result_message = 'Failed to insert classification.';
    END IF;
END //

DELIMITER ;

DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Update_Classification(
    IN input_id INT,
    IN input_classification INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE classification_exists INT;
    DECLARE rows_affected INT;

    SELECT COUNT(*)
    INTO classification_exists
    FROM Viewing_Classification
    WHERE classification_id = input_id;

    IF classification_exists > 0 THEN

        UPDATE Viewing_Classification
        SET classification = input_classification
        WHERE classification_id = input_id;

        -- Check if any row was updated
        SET rows_affected = ROW_COUNT();

        IF rows_affected > 0 THEN
            SET result_message = 'Classification updated successfully.';
        ELSE
            SET result_message = 'Failed to update classification. No changes made.';
        END IF;
    ELSE
        SET result_message = 'Classification not found.';
    END IF;
END //

DELIMITER ;

DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Delete_Classification(
    IN input_id INT,
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE classification_exists INT;
    DECLARE rows_affected INT;

    SELECT COUNT(*)
    INTO classification_exists
    FROM Viewing_Classification
    WHERE classification_id = input_id;

    IF classification_exists > 0 THEN


        DELETE
        FROM Viewing_Classification
        WHERE classification_id = input_id;

        -- Check if any row was deleted
        SET rows_affected = ROW_COUNT();

        IF rows_affected > 0 THEN
            SET result_message = 'Classification deleted successfully.';
        ELSE
            SET result_message = 'Failed to delete classification.';
        END IF;
    ELSE
        SET result_message = 'Classification not found.';
    END IF;
END //

DELIMITER ;

DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Insert_Api_Key(
    IN input_api_key varchar(255),
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE rows_affected INT;

    INSERT INTO Api_Keys VALUES (input_api_key, DATE_ADD(NOW(), INTERVAL 72 HOUR));

    SET rows_affected = ROW_COUNT();
    IF rows_affected > 0 THEN
        SET result_message = 'Api key inserted successfully.';
    ELSE
        SET result_message = 'Something went wrong.';
    END IF;

END //

DELIMITER ;

DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Update_Api_Key(
    IN old_api_key varchar(255),
    IN new_api_key varchar(255),
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE rows_affected INT;

    UPDATE Api_Keys SET api_key = new_api_key, expire_at = DATE_ADD(NOW(), INTERVAL 72 HOUR)
    WHERE api_key = old_api_key;

    SET rows_affected = ROW_COUNT();
    IF rows_affected > 0 THEN
        SET result_message = 'Api key updated successfully.';
    ELSE
        SET result_message = 'Something went wrong.';
    END IF;

END //

DELIMITER ;

DELIMITER //

CREATE DEFINER=`senior`@`%` PROCEDURE Revoke_Api_Key(
    IN input_api_key varchar(255),
    OUT result_message VARCHAR(255)
)
BEGIN
    DECLARE rows_affected INT;

    DELETE FROM Api_Keys WHERE api_key = input_api_key;

    SET rows_affected = ROW_COUNT();
    IF rows_affected > 0 THEN
        SET result_message = 'Api key revoked successfully.';
    ELSE
        SET result_message = 'Something went wrong.';
    END IF;

END //

DELIMITER ;