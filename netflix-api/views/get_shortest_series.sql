CREATE VIEW get_shortest_series AS
SELECT 
    Series.title AS SeriesTitle,
    COUNT(Media.media_id) AS EpisodeCount
FROM 
    Series
JOIN 
    Media ON Series.series_id = Media.series_id
GROUP BY 
    Series.series_id, Series.title
ORDER BY 
    EpisodeCount ASC
LIMIT 10;
