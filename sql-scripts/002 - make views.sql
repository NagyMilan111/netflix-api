CREATE VIEW Get_All_Revenue AS
SELECT 
    SUM(
        CASE
            WHEN Account.discount_active = 1 THEN Subscription.subscription_price - 2
            ELSE Subscription.subscription_price
        END
    ) AS TotalRevenue
FROM 
    Account
JOIN 
    Subscription ON Account.subscription_id = Subscription.subscription_id;

CREATE VIEW Get_All_Genres_By_Views AS
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
    TotalViews DESC;

CREATE VIEW Get_Watched_Media_By_Views AS
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

CREATE VIEW Get_Movies_By_Views AS
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

CREATE VIEW Get_Watched_Series_By_Views AS
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
    TimesWatched DESC;

CREATE VIEW Get_Amount_Of_Discounted_Users AS
SELECT 
    CONCAT(
        COUNT(CASE WHEN discount_active = 1 THEN 1 END),
        ' out of ',
        COUNT(*),
        ' users have a discount active'
    ) AS DiscountSummary
FROM 
    Account;

CREATE VIEW Get_Bottom_Ten_Genres AS
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
SELECT * FROM Get_Bottom_Ten_Genres LIMIT 10;

CREATE VIEW Get_Bottom_Ten_Media AS
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
    TimesWatched ASC;
SELECT * FROM Get_Bottom_Ten_Media LIMIT 10;

CREATE VIEW Get_Bottom_Ten_Movies AS
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
    TimesWatched ASC;
SELECT * FROM Get_Bottom_Ten_Movies LIMIT 10;

CREATE VIEW Get_Bottom_Ten_Series AS
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
SELECT * FROM Get_Bottom_Ten_Series LIMIT 10;

CREATE VIEW Get_Top_Ten_Longest_Series AS
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
    EpisodeCount DESC
LIMIT 10;

CREATE VIEW Get_Top_Ten_Shortest_Series AS
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

CREATE VIEW Get_Top_Ten_Longest_Movies AS
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

CREATE VIEW Get_Top_Ten_Shortest_Movies AS
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

CREATE VIEW Get_Top_Ten_Watched_Genres AS
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
    TotalViews DESC
LIMIT 10;

CREATE VIEW Get_Top_Ten_Watched_Media AS
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
SELECT * FROM Get_Top_Ten_Watched_Media LIMIT 10;

CREATE VIEW Get_Top_Ten_Watched_Movies AS
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
SELECT * FROM Get_Top_Ten_Watched_Movies LIMIT 10;

CREATE VIEW Get_Top_Ten_Watched_Series AS
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
    TimesWatched DESC;
SELECT * FROM Get_Top_Ten_Watched_Series LIMIT 10;

CREATE VIEW Get_Subscription_Details AS
SELECT
    a.account_id,
    s.subscription_name,
    s.subscription_price,
    a.billed_from,
    a.discount_active
FROM
    Account AS a
        JOIN
    Subscription AS s ON a.subscription_id = s.subscription_id;

CREATE VIEW Get_Token AS
SELECT
    account_id,
    token
FROM
    Tokens;

CREATE VIEW Get_Account_Id AS
SELECT
    account_id
FROM
    Account;

CREATE VIEW List_Series AS
SELECT
    series_id,
    title,
    number_of_seasons
FROM
    Series;

CREATE VIEW List_Episodes AS
SELECT
    media_id,
    title,
    duration,
    series_id,
    season,
    genre_id
FROM
    Media
WHERE series_id IS NOT NULL AND season IS NOT NULL;