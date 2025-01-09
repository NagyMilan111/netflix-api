CREATE VIEW get_all_revenue AS
SELECT 
    SUM(
        CASE
            WHEN Account.discount_active = 1 THEN Subscription.subscription_price - 2
            ELSE Subscription.subscription_price
        END
    ) AS TotalRevenue
FROM 
    Account
JOIN 
    Subscription ON Account.subscription_id = Subscription.subscription_id;
