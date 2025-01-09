CREATE VIEW get_amount_discounted_users AS
SELECT 
    CONCAT(
        COUNT(CASE WHEN discount_active = 1 THEN 1 END),
        ' out of ',
        COUNT(*),
        ' users have a discount active'
    ) AS DiscountSummary
FROM 
    Account;
