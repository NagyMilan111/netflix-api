CREATE VIEW top_10_shortest_movies AS
SELECT 
    title AS MovieTitle,
    duration AS MovieDuration
FROM 
    Media
WHERE 
    series_id IS NULL
ORDER BY 
    duration ASC
LIMIT 10;
