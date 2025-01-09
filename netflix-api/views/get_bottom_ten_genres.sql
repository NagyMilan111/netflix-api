CREATE VIEW get_least_popular_genres AS
SELECT 
    Genre.genre_name AS GenreName,
    COUNT(Profile_Watched_Media.profile_id) AS TotalViews
FROM 
    Media
JOIN 
    Genre ON Media.genre_id = Genre.genre_id
JOIN 
    Profile_Watched_Media ON Media.media_id = Profile_Watched_Media.media_id
GROUP BY 
    Genre.genre_id, Genre.genre_name
ORDER BY 
    TotalViews ASC;
SELECT * FROM get_least_popular_genres LIMIT 10;
