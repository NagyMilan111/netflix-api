CREATE VIEW top_10_shortest_movies AS
SELECT
    Media.title AS MovieTitle,
    Media.duration AS MovieDuration
FROM
    Media
WHERE
    Media.series_id IS NULL
ORDER BY
    Media.duration ASC
LIMIT 10;
