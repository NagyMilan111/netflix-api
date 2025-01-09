CREATE VIEW AllWatchedSortedMovies AS
SELECT 
    Media.title AS MovieTitle,
    COUNT(Profile_Watched_Media.profile_id) AS TimesWatched
FROM 
    Media
JOIN 
    Profile_Watched_Media ON Media.media_id = Profile_Watched_Media.media_id
WHERE 
    Media.series_id IS NULL
GROUP BY 
    Media.media_id, Media.title
ORDER BY 
    TimesWatched DESC;