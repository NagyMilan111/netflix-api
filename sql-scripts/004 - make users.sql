-- User creation

CREATE USER 'senior'@'%' IDENTIFIED BY 'password';
GRANT SHUTDOWN, CREATE USER, RELOAD ON *.* TO 'senior'@'%';
GRANT CREATE ROUTINE, CREATE, SELECT, EXECUTE, DELETE, CREATE VIEW, ALTER ROUTINE, INDEX, EVENT,
    INSERT, LOCK TABLES, SHOW VIEW, TRIGGER, UPDATE, ALTER, GRANT OPTION
    ON Netflix.* TO 'senior'@'%';
GRANT SELECT ON mysql.proc TO 'senior'@'%';


CREATE USER 'medior'@'%' IDENTIFIED BY 'password';
GRANT CREATE ROUTINE, CREATE VIEW, INDEX, TRIGGER
    ON Netflix.* TO 'medior'@'%';
GRANT SELECT ON mysql.proc TO 'medior'@'%';

GRANT SELECT, DELETE, UPDATE, INSERT ON Netflix.Language TO 'medior'@'%';
GRANT SELECT, DELETE, UPDATE, INSERT ON Netflix.Genre TO 'medior'@'%';
GRANT SELECT, DELETE, UPDATE, INSERT ON Netflix.Viewing_Classification TO 'medior'@'%';
GRANT SELECT, DELETE, UPDATE, INSERT ON Netflix.Account TO 'medior'@'%';
GRANT SELECT, DELETE, UPDATE, INSERT ON Netflix.Profile TO 'medior'@'%';
GRANT SELECT, DELETE, UPDATE, INSERT ON Netflix.Series TO 'medior'@'%';
GRANT SELECT, DELETE, UPDATE, INSERT ON Netflix.Media TO 'medior'@'%';
GRANT SELECT, DELETE, UPDATE, INSERT ON Netflix.Media_Quality TO 'medior'@'%';
GRANT SELECT, DELETE, UPDATE, INSERT ON Netflix.Subtitle TO 'medior'@'%';
GRANT SELECT, DELETE, UPDATE, INSERT ON Netflix.Profile_Genre TO 'medior'@'%';
GRANT SELECT, DELETE, UPDATE, INSERT ON Netflix.Profile_Viewing_Classification TO 'medior'@'%';
GRANT SELECT, DELETE, UPDATE, INSERT ON Netflix.Profile_Watched_Media TO 'medior'@'%';
GRANT SELECT, DELETE, UPDATE, INSERT ON Netflix.Profile_Watch_List TO 'medior'@'%';
GRANT SELECT, DELETE, UPDATE, INSERT ON Netflix.Logs TO 'medior'@'%';
GRANT SELECT, DELETE, UPDATE, INSERT ON Netflix.Tokens TO 'medior'@'%';

GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Add_Media TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Add_Profile TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Add_Watchlist TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Block_User TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Remove_Media TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Remove_Profile TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Remove_Account TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Remove_Watchlist TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Currently_Watched TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Profile_Genre TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE User_Login TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Get_Media TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Get_Profile TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Register_User TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Password TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Pause_Spot TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Fetch_Pause_Spot TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Log_Play_Action TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Profile_Preferences TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Insert_Token TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Delete_Token TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Token TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Profile_Watch_List TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Delete_From_Profile_Watch_List TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Insert_Series TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Series TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Delete_Series TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Insert_Episode TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Episode TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Delete_Episode TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Profile_Viewing_Classification TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Insert_Classification TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Classification TO 'medior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Delete_Classification TO 'medior'@'%';

GRANT SELECT, SHOW VIEW, ALTER ON `Get_All_Revenue` TO 'medior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_All_Genres_By_Views` TO 'medior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Watched_Media_By_Views` TO 'medior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Movies_By_Views` TO 'medior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Watched_Series_By_Views` TO 'medior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Amount_Of_Discounted_Users` TO 'medior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Bottom_Ten_Genres` TO 'medior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Bottom_Ten_Media` TO 'medior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Bottom_Ten_Movies` TO 'medior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Bottom_Ten_Series` TO 'medior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Top_Ten_Longest_Series` TO 'medior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Top_Ten_Shortest_Series` TO 'medior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Top_Ten_Longest_Movies` TO 'medior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Top_Ten_Shortest_Movies` TO 'medior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Top_Ten_Watched_Genres` TO 'medior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Top_Ten_Watched_Media` TO 'medior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Top_Ten_Watched_Movies` TO 'medior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Top_Ten_Watched_Series` TO 'medior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Subscription_Details` TO 'medior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Token` TO 'medior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Account_Id` TO 'medior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `List_Series` TO 'medior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `List_Episodes` TO 'medior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Profile_Id` TO 'medior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `List_Watch_List` TO 'medior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `List_Classifications` TO 'medior'@'%';


CREATE USER 'junior'@'%' IDENTIFIED BY 'password';
GRANT CREATE VIEW, INDEX ON Netflix.* TO 'junior'@'%';
GRANT SELECT ON mysql.proc TO 'junior'@'%';

GRANT SELECT, DELETE, UPDATE, INSERT ON Netflix.Language TO 'junior'@'%';
GRANT SELECT, DELETE, UPDATE, INSERT ON Netflix.Genre TO 'junior'@'%';
GRANT SELECT, DELETE, UPDATE, INSERT ON Netflix.Viewing_Classification TO 'junior'@'%';
GRANT SELECT, DELETE, UPDATE, INSERT ON Netflix.Profile TO 'junior'@'%';
GRANT SELECT, DELETE, UPDATE, INSERT ON Netflix.Series TO 'junior'@'%';
GRANT SELECT, DELETE, UPDATE, INSERT ON Netflix.Media TO 'junior'@'%';
GRANT SELECT, DELETE, UPDATE, INSERT ON Netflix.Media_Quality TO 'junior'@'%';
GRANT SELECT, DELETE, UPDATE, INSERT ON Netflix.Subtitle TO 'junior'@'%';
GRANT SELECT, DELETE, UPDATE, INSERT ON Netflix.Profile_Genre TO 'junior'@'%';
GRANT SELECT, DELETE, UPDATE, INSERT ON Netflix.Profile_Viewing_Classification TO 'junior'@'%';
GRANT SELECT, DELETE, UPDATE, INSERT ON Netflix.Profile_Watched_Media TO 'junior'@'%';
GRANT SELECT, DELETE, UPDATE, INSERT ON Netflix.Profile_Watch_List TO 'junior'@'%';
GRANT SELECT, DELETE, UPDATE, INSERT ON Netflix.Logs TO 'junior'@'%';
GRANT SELECT, DELETE, UPDATE, INSERT ON Netflix.Tokens TO 'junior'@'%';

GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Add_Media TO 'junior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Add_Profile TO 'junior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Add_Watchlist TO 'junior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Remove_Media TO 'junior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Remove_Profile TO 'junior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Remove_Watchlist TO 'junior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Currently_Watched TO 'junior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Profile_Genre TO 'junior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Get_Media TO 'junior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Get_Profile TO 'junior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Password TO 'junior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Pause_Spot TO 'junior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Fetch_Pause_Spot TO 'junior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Log_Play_Action TO 'junior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Profile_Preferences TO 'junior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Insert_Token TO 'junior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Delete_Token TO 'junior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Token TO 'junior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Profile_Watch_List TO 'junior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Delete_From_Profile_Watch_List TO 'junior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Insert_Series TO 'junior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Series TO 'junior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Delete_Series TO 'junior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Insert_Episode TO 'junior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Episode TO 'junior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Delete_Episode TO 'junior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Profile_Viewing_Classification TO 'junior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Insert_Classification TO 'junior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Classification TO 'junior'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Delete_Classification TO 'junior'@'%';

GRANT SELECT, SHOW VIEW, ALTER ON `Get_All_Genres_By_Views` TO 'junior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Watched_Media_By_Views` TO 'junior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Movies_By_Views` TO 'junior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Watched_Series_By_Views` TO 'junior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Bottom_Ten_Genres` TO 'junior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Bottom_Ten_Media` TO 'junior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Bottom_Ten_Movies` TO 'junior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Bottom_Ten_Series` TO 'junior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Top_Ten_Longest_Series` TO 'junior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Top_Ten_Shortest_Series` TO 'junior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Top_Ten_Longest_Movies` TO 'junior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Top_Ten_Shortest_Movies` TO 'junior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Top_Ten_Watched_Genres` TO 'junior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Top_Ten_Watched_Media` TO 'junior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Top_Ten_Watched_Movies` TO 'junior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Top_Ten_Watched_Series` TO 'junior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Token` TO 'junior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `List_Series` TO 'junior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `List_Episodes` TO 'junior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `Get_Profile_Id` TO 'junior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `List_Watch_List` TO 'junior'@'%';
GRANT SELECT, SHOW VIEW, ALTER ON `List_Classifications` TO 'junior'@'%';

CREATE USER 'api'@'%' IDENTIFIED BY 'password';

GRANT EXECUTE ON PROCEDURE Add_Media TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Add_Profile TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Add_Watchlist TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Apply_Discount TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Block_User TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Remove_Media TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Remove_Profile TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Remove_Account TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Remove_Watchlist TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Update_Currently_Watched TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Update_Profile_Genre TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE User_Login TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Get_Media TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Get_Profile TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Register_User TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Update_Password TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Update_Pause_Spot TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Fetch_Pause_Spot TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Log_Play_Action TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Update_Profile_Preferences TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Update_Account_Subscription TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Insert_Token TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Delete_Token TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Update_Token TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Update_Profile_Watch_List TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Delete_From_Profile_Watch_List TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Insert_Series TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Update_Series TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Delete_Series TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Insert_Episode TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Update_Episode TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Delete_Episode TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Update_Profile_Viewing_Classification TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Insert_Classification TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Update_Classification TO 'api'@'%';
GRANT EXECUTE ON PROCEDURE Delete_Classification TO 'api'@'%';

GRANT SELECT ON `Get_All_Revenue` TO 'api'@'%';
GRANT SELECT ON `Get_All_Genres_By_Views` TO 'api'@'%';
GRANT SELECT ON `Get_Watched_Media_By_Views` TO 'api'@'%';
GRANT SELECT ON `Get_Movies_By_Views` TO 'api'@'%';
GRANT SELECT ON `Get_Watched_Series_By_Views` TO 'api'@'%';
GRANT SELECT ON `Get_Amount_Of_Discounted_Users` TO 'api'@'%';
GRANT SELECT ON `Get_Bottom_Ten_Genres` TO 'api'@'%';
GRANT SELECT ON `Get_Bottom_Ten_Media` TO 'api'@'%';
GRANT SELECT ON `Get_Bottom_Ten_Movies` TO 'api'@'%';
GRANT SELECT ON `Get_Bottom_Ten_Series` TO 'api'@'%';
GRANT SELECT ON `Get_Top_Ten_Longest_Series` TO 'api'@'%';
GRANT SELECT ON `Get_Top_Ten_Shortest_Series` TO 'api'@'%';
GRANT SELECT ON `Get_Top_Ten_Longest_Movies` TO 'api'@'%';
GRANT SELECT ON `Get_Top_Ten_Shortest_Movies` TO 'api'@'%';
GRANT SELECT ON `Get_Top_Ten_Watched_Genres` TO 'api'@'%';
GRANT SELECT ON `Get_Top_Ten_Watched_Media` TO 'api'@'%';
GRANT SELECT ON `Get_Top_Ten_Watched_Movies` TO 'api'@'%';
GRANT SELECT ON `Get_Top_Ten_Watched_Series` TO 'api'@'%';
GRANT SELECT ON `Get_Subscription_Details` TO 'api'@'%';
GRANT SELECT ON `Get_Token` TO 'api'@'%';
GRANT SELECT ON `Get_Account_Id` TO 'api'@'%';
GRANT SELECT ON `List_Series` TO 'api'@'%';
GRANT SELECT ON `List_Episodes` TO 'api'@'%';
GRANT SELECT ON `Get_Profile_Id` TO 'api'@'%';
GRANT SELECT ON `List_Watch_List` TO 'api'@'%';
GRANT SELECT ON `List_Classifications` TO 'api'@'%';

-- Drop root users (if they exist)

ALTER DEFINER=`senior`@`%` VIEW `Netflix`.`Get_Top_Ten_Longest_Series` AS select `Netflix`.`Series`.`title` AS `SeriesTitle`,count(`Netflix`.`Media`.`media_id`) AS `EpisodeCount` from (`Netflix`.`Series` join `Netflix`.`Media` on(`Netflix`.`Series`.`series_id` = `Netflix`.`Media`.`series_id`)) group by `Netflix`.`Series`.`series_id`,`Netflix`.`Series`.`title` order by count(`Netflix`.`Media`.`media_id`) desc limit 10;
ALTER DEFINER=`senior`@`%` VIEW `Netflix`.`Get_Subscription_Details` AS select `a`.`account_id` AS `account_id`,`s`.`subscription_name` AS `subscription_name`,`s`.`subscription_price` AS `subscription_price`,`a`.`billed_from` AS `billed_from`,`a`.`discount_active` AS `discount_active` from (`Netflix`.`Account` `a` join `Netflix`.`Subscription` `s` on(`a`.`subscription_id` = `s`.`subscription_id`));
ALTER DEFINER=`senior`@`%` VIEW `Netflix`.`List_Series` AS select `Netflix`.`Series`.`series_id` AS `series_id`,`Netflix`.`Series`.`title` AS `title`,`Netflix`.`Series`.`number_of_seasons` AS `number_of_seasons` from `Netflix`.`Series`;
ALTER DEFINER=`senior`@`%` VIEW `Netflix`.`Get_Top_Ten_Shortest_Series` AS select `Netflix`.`Series`.`title` AS `SeriesTitle`,count(`Netflix`.`Media`.`media_id`) AS `EpisodeCount` from (`Netflix`.`Series` join `Netflix`.`Media` on(`Netflix`.`Series`.`series_id` = `Netflix`.`Media`.`series_id`)) group by `Netflix`.`Series`.`series_id`,`Netflix`.`Series`.`title` order by count(`Netflix`.`Media`.`media_id`) limit 10;
ALTER DEFINER=`senior`@`%` VIEW `Netflix`.`Get_Amount_Of_Discounted_Users` AS select concat(count(case when `Netflix`.`Account`.`discount_active` = 1 then 1 end),' out of ',count(0),' users have a discount active') AS `DiscountSummary` from `Netflix`.`Account`;
ALTER DEFINER=`senior`@`%` VIEW `Netflix`.`List_Classifications` AS select `Netflix`.`Viewing_Classification`.`classification_id` AS `classification_id`,`Netflix`.`Viewing_Classification`.`classification` AS `classification` from `Netflix`.`Viewing_Classification`;
ALTER DEFINER=`senior`@`%` VIEW `Netflix`.`Get_Top_Ten_Watched_Genres` AS select `Netflix`.`Genre`.`genre_name` AS `GenreName`,count(`Netflix`.`Profile_Watched_Media`.`profile_id`) AS `TotalViews` from ((`Netflix`.`Media` join `Netflix`.`Genre` on(`Netflix`.`Media`.`genre_id` = `Netflix`.`Genre`.`genre_id`)) join `Netflix`.`Profile_Watched_Media` on(`Netflix`.`Media`.`media_id` = `Netflix`.`Profile_Watched_Media`.`media_id`)) group by `Netflix`.`Genre`.`genre_id`,`Netflix`.`Genre`.`genre_name` order by count(`Netflix`.`Profile_Watched_Media`.`profile_id`) desc limit 10;
ALTER DEFINER=`senior`@`%` VIEW `Netflix`.`Get_Bottom_Ten_Series` AS select `Netflix`.`Series`.`title` AS `SeriesTitle`,count(`Netflix`.`Profile_Watched_Media`.`profile_id`) AS `TimesWatched` from ((`Netflix`.`Media` join `Netflix`.`Profile_Watched_Media` on(`Netflix`.`Media`.`media_id` = `Netflix`.`Profile_Watched_Media`.`media_id`)) join `Netflix`.`Series` on(`Netflix`.`Media`.`series_id` = `Netflix`.`Series`.`series_id`)) where `Netflix`.`Media`.`series_id` is not null group by `Netflix`.`Series`.`series_id`,`Netflix`.`Series`.`title` order by count(`Netflix`.`Profile_Watched_Media`.`profile_id`);
ALTER DEFINER=`senior`@`%` VIEW `Netflix`.`Get_Bottom_Ten_Movies` AS select `Netflix`.`Media`.`title` AS `MovieTitle`,count(`Netflix`.`Profile_Watched_Media`.`profile_id`) AS `TimesWatched` from (`Netflix`.`Media` join `Netflix`.`Profile_Watched_Media` on(`Netflix`.`Media`.`media_id` = `Netflix`.`Profile_Watched_Media`.`media_id`)) where `Netflix`.`Media`.`series_id` is null group by `Netflix`.`Media`.`media_id`,`Netflix`.`Media`.`title` order by count(`Netflix`.`Profile_Watched_Media`.`profile_id`);
ALTER DEFINER=`senior`@`%` VIEW `Netflix`.`Get_Watched_Series_By_Views` AS select `Netflix`.`Series`.`title` AS `SeriesTitle`,count(`Netflix`.`Profile_Watched_Media`.`profile_id`) AS `TimesWatched` from ((`Netflix`.`Media` join `Netflix`.`Profile_Watched_Media` on(`Netflix`.`Media`.`media_id` = `Netflix`.`Profile_Watched_Media`.`media_id`)) join `Netflix`.`Series` on(`Netflix`.`Media`.`series_id` = `Netflix`.`Series`.`series_id`)) where `Netflix`.`Media`.`series_id` is not null group by `Netflix`.`Series`.`series_id`,`Netflix`.`Series`.`title` order by count(`Netflix`.`Profile_Watched_Media`.`profile_id`) desc;
ALTER DEFINER=`senior`@`%` VIEW `Netflix`.`Get_All_Genres_By_Views` AS select `Netflix`.`Genre`.`genre_name` AS `GenreName`,count(`Netflix`.`Profile_Watched_Media`.`profile_id`) AS `TotalViews` from ((`Netflix`.`Media` join `Netflix`.`Genre` on(`Netflix`.`Media`.`genre_id` = `Netflix`.`Genre`.`genre_id`)) join `Netflix`.`Profile_Watched_Media` on(`Netflix`.`Media`.`media_id` = `Netflix`.`Profile_Watched_Media`.`media_id`)) group by `Netflix`.`Genre`.`genre_id`,`Netflix`.`Genre`.`genre_name` order by count(`Netflix`.`Profile_Watched_Media`.`profile_id`) desc;
ALTER DEFINER=`senior`@`%` VIEW `Netflix`.`Get_Bottom_Ten_Genres` AS select `Netflix`.`Genre`.`genre_name` AS `GenreName`,count(`Netflix`.`Profile_Watched_Media`.`profile_id`) AS `TotalViews` from ((`Netflix`.`Media` join `Netflix`.`Genre` on(`Netflix`.`Media`.`genre_id` = `Netflix`.`Genre`.`genre_id`)) join `Netflix`.`Profile_Watched_Media` on(`Netflix`.`Media`.`media_id` = `Netflix`.`Profile_Watched_Media`.`media_id`)) group by `Netflix`.`Genre`.`genre_id`,`Netflix`.`Genre`.`genre_name` order by count(`Netflix`.`Profile_Watched_Media`.`profile_id`);
ALTER DEFINER=`senior`@`%` VIEW `Netflix`.`Get_Account_Id` AS select `Netflix`.`Account`.`account_id` AS `account_id` from `Netflix`.`Account`;
ALTER DEFINER=`senior`@`%` VIEW `Netflix`.`Get_Top_Ten_Shortest_Movies` AS select `Netflix`.`Media`.`title` AS `MovieTitle`,`Netflix`.`Media`.`duration` AS `MovieDuration` from `Netflix`.`Media` where `Netflix`.`Media`.`series_id` is null order by `Netflix`.`Media`.`duration` limit 10;
ALTER DEFINER=`senior`@`%` VIEW `Netflix`.`Get_Movies_By_Views` AS select `Netflix`.`Media`.`title` AS `MovieTitle`,count(`Netflix`.`Profile_Watched_Media`.`profile_id`) AS `TimesWatched` from (`Netflix`.`Media` join `Netflix`.`Profile_Watched_Media` on(`Netflix`.`Media`.`media_id` = `Netflix`.`Profile_Watched_Media`.`media_id`)) where `Netflix`.`Media`.`series_id` is null group by `Netflix`.`Media`.`media_id`,`Netflix`.`Media`.`title` order by count(`Netflix`.`Profile_Watched_Media`.`profile_id`) desc;
ALTER DEFINER=`senior`@`%` VIEW `Netflix`.`Get_Top_Ten_Watched_Series` AS select `Netflix`.`Series`.`title` AS `SeriesTitle`,count(`Netflix`.`Profile_Watched_Media`.`profile_id`) AS `TimesWatched` from ((`Netflix`.`Media` join `Netflix`.`Profile_Watched_Media` on(`Netflix`.`Media`.`media_id` = `Netflix`.`Profile_Watched_Media`.`media_id`)) join `Netflix`.`Series` on(`Netflix`.`Media`.`series_id` = `Netflix`.`Series`.`series_id`)) where `Netflix`.`Media`.`series_id` is not null group by `Netflix`.`Series`.`series_id`,`Netflix`.`Series`.`title` order by count(`Netflix`.`Profile_Watched_Media`.`profile_id`) desc;
ALTER DEFINER=`senior`@`%` VIEW `Netflix`.`List_Watch_List` AS select `Netflix`.`Profile_Watch_List`.`media_id` AS `media_id`,`Netflix`.`Profile_Watch_List`.`series_id` AS `series_id`,`Netflix`.`Profile_Watch_List`.`profile_id` AS `profile_id` from `Netflix`.`Profile_Watch_List`;
ALTER DEFINER=`senior`@`%` VIEW `Netflix`.`Get_Bottom_Ten_Media` AS select `Netflix`.`Media`.`title` AS `MediaTitle`,count(`Netflix`.`Profile_Watched_Media`.`profile_id`) AS `TimesWatched` from (`Netflix`.`Media` join `Netflix`.`Profile_Watched_Media` on(`Netflix`.`Media`.`media_id` = `Netflix`.`Profile_Watched_Media`.`media_id`)) group by `Netflix`.`Media`.`media_id`,`Netflix`.`Media`.`title` order by count(`Netflix`.`Profile_Watched_Media`.`profile_id`);
ALTER DEFINER=`senior`@`%` VIEW `Netflix`.`Get_Top_Ten_Watched_Media` AS select `Netflix`.`Media`.`title` AS `MediaTitle`,count(`Netflix`.`Profile_Watched_Media`.`profile_id`) AS `TimesWatched` from (`Netflix`.`Media` join `Netflix`.`Profile_Watched_Media` on(`Netflix`.`Media`.`media_id` = `Netflix`.`Profile_Watched_Media`.`media_id`)) group by `Netflix`.`Media`.`media_id`,`Netflix`.`Media`.`title` order by count(`Netflix`.`Profile_Watched_Media`.`profile_id`) desc;
ALTER DEFINER=`senior`@`%` VIEW `Netflix`.`Get_Profile_Id` AS select `Netflix`.`Profile`.`profile_id` AS `profile_id` from `Netflix`.`Profile`;
ALTER DEFINER=`senior`@`%` VIEW `Netflix`.`Get_Top_Ten_Longest_Movies` AS select `Netflix`.`Media`.`title` AS `MovieTitle`,`Netflix`.`Media`.`duration` AS `MovieDuration` from `Netflix`.`Media` where `Netflix`.`Media`.`series_id` is null order by `Netflix`.`Media`.`duration` desc limit 10;
ALTER DEFINER=`senior`@`%` VIEW `Netflix`.`List_Episodes` AS select `Netflix`.`Media`.`media_id` AS `media_id`,`Netflix`.`Media`.`title` AS `title`,`Netflix`.`Media`.`duration` AS `duration`,`Netflix`.`Media`.`series_id` AS `series_id`,`Netflix`.`Media`.`season` AS `season`,`Netflix`.`Media`.`genre_id` AS `genre_id` from `Netflix`.`Media` where `Netflix`.`Media`.`series_id` is not null and `Netflix`.`Media`.`season` is not null;
ALTER DEFINER=`senior`@`%` VIEW `Netflix`.`Get_All_Revenue` AS select sum(case when `Netflix`.`Account`.`discount_active` = 1 then `Netflix`.`Subscription`.`subscription_price` - 2 else `Netflix`.`Subscription`.`subscription_price` end) AS `TotalRevenue` from (`Netflix`.`Account` join `Netflix`.`Subscription` on(`Netflix`.`Account`.`subscription_id` = `Netflix`.`Subscription`.`subscription_id`));
ALTER DEFINER=`senior`@`%` VIEW `Netflix`.`Get_Top_Ten_Watched_Movies` AS select `Netflix`.`Media`.`title` AS `MovieTitle`,count(`Netflix`.`Profile_Watched_Media`.`profile_id`) AS `TimesWatched` from (`Netflix`.`Media` join `Netflix`.`Profile_Watched_Media` on(`Netflix`.`Media`.`media_id` = `Netflix`.`Profile_Watched_Media`.`media_id`)) where `Netflix`.`Media`.`series_id` is null group by `Netflix`.`Media`.`media_id`,`Netflix`.`Media`.`title` order by count(`Netflix`.`Profile_Watched_Media`.`profile_id`) desc;
ALTER DEFINER=`senior`@`%` VIEW `Netflix`.`Get_Watched_Media_By_Views` AS select `Netflix`.`Media`.`title` AS `MediaTitle`,count(`Netflix`.`Profile_Watched_Media`.`profile_id`) AS `TimesWatched` from (`Netflix`.`Media` join `Netflix`.`Profile_Watched_Media` on(`Netflix`.`Media`.`media_id` = `Netflix`.`Profile_Watched_Media`.`media_id`)) group by `Netflix`.`Media`.`media_id`,`Netflix`.`Media`.`title` order by count(`Netflix`.`Profile_Watched_Media`.`profile_id`) desc;
ALTER DEFINER=`senior`@`%` VIEW `Netflix`.`Get_Token` AS select `Netflix`.`Tokens`.`account_id` AS `account_id`,`Netflix`.`Tokens`.`token` AS `token` from `Netflix`.`Tokens`;


DROP USER IF EXISTS 'root'@'localhost';
DROP USER IF EXISTS 'root'@'%';

-- Flush privileges to apply changes
FLUSH PRIVILEGES;


