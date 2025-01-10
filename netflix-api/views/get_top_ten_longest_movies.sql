CREATE VIEW top_10_longest_movies AS
SELECT
    Media.title AS MovieTitle,
    Media.duration AS MovieDuration
FROM
    Media
WHERE
    Media.series_id IS NULL
ORDER BY
    Media.duration DESC
LIMIT 10;
