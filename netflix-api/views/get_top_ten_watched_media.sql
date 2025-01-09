CREATE VIEW MostWatchedMedia AS
SELECT 
    Media.title AS MediaTitle,
    COUNT(Profile_Watched_Media.profile_id) AS TimesWatched
FROM 
    Media
JOIN 
    Profile_Watched_Media ON Media.media_id = Profile_Watched_Media.media_id
GROUP BY 
    Media.media_id, Media.title
ORDER BY 
    TimesWatched DESC;
SELECT * FROM MostWatchedMedia LIMIT 10;
