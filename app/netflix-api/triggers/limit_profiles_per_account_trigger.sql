DELIMITER //

CREATE TRIGGER limit_profiles_per_account
AFTER INSERT ON Profile
FOR EACH ROW
BEGIN
    DECLARE profile_count INT;
    
    SELECT COUNT(*) INTO profile_count
    FROM Profile
    WHERE account_id = NEW.account_id;
    
    IF profile_count > 4 THEN
        DELETE FROM Profile
        WHERE profile_id = NEW.profile_id;
    END IF;
END;

//

DELIMITER ;
