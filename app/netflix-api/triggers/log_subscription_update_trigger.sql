DELIMITER //

CREATE TRIGGER log_subscription_update
AFTER UPDATE ON Subscription
FOR EACH ROW
BEGIN
    INSERT INTO Logs (message, date)
    VALUES (CONCAT('Subscription updated: ID ', OLD.subscription_id, 
                   ', Name changed from ', OLD.subscription_name, ' to ', NEW.subscription_name, 
                   ', Price changed from ', OLD.subscription_price, ' to ', NEW.subscription_price),
            NOW());
END;

//

DELIMITER ;
