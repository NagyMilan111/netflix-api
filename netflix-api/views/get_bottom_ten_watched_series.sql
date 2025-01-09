CREATE VIEW BottomSeries AS
SELECT 
    Series.title AS SeriesTitle,
    COUNT(Profile_Watched_Media.profile_id) AS TimesWatched
FROM 
    Media
JOIN 
    Profile_Watched_Media ON Media.media_id = Profile_Watched_Media.media_id
JOIN 
    Series ON Media.series_id = Series.series_id
WHERE 
    Media.series_id IS NOT NULL
GROUP BY 
    Series.series_id, Series.title
ORDER BY 
    TimesWatched ASC;
SELECT * FROM BottomSeries LIMIT 10;
