CREATE VIEW top_10_longest_movies AS
SELECT 
    title AS MovieTitle,
    duration AS MovieDuration
FROM 
    Media
WHERE 
    series_id IS NULL
ORDER BY 
    duration DESC
LIMIT 10;