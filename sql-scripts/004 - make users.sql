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

GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Add_Media TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Add_Profile TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Add_Watchlist TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Apply_Discount TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Block_User TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Remove_Media TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Remove_Profile TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Remove_Account TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Remove_Watchlist TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Currently_Watched TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Profile_Genre TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE User_Login TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Get_Media TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Get_Profile TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Register_User TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Password TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Pause_Spot TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Fetch_Pause_Spot TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Log_Play_Action TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Profile_Preferences TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Account_Subscription TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Insert_Token TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Delete_Token TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Token TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Profile_Watch_List TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Delete_From_Profile_Watch_List TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Insert_Series TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Series TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Delete_Series TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Insert_Episode TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Episode TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Delete_Episode TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Profile_Viewing_Classification TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Insert_Classification TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Update_Classification TO 'api'@'%';
GRANT EXECUTE, ALTER ROUTINE ON PROCEDURE Delete_Classification TO 'api'@'%';

GRANT SELECT, SHOW VIEW ON `Get_All_Revenue` TO 'api'@'%';
GRANT SELECT, SHOW VIEW ON `Get_All_Genres_By_Views` TO 'api'@'%';
GRANT SELECT, SHOW VIEW ON `Get_Watched_Media_By_Views` TO 'api'@'%';
GRANT SELECT, SHOW VIEW ON `Get_Movies_By_Views` TO 'api'@'%';
GRANT SELECT, SHOW VIEW ON `Get_Watched_Series_By_Views` TO 'api'@'%';
GRANT SELECT, SHOW VIEW ON `Get_Amount_Of_Discounted_Users` TO 'api'@'%';
GRANT SELECT, SHOW VIEW ON `Get_Bottom_Ten_Genres` TO 'api'@'%';
GRANT SELECT, SHOW VIEW ON `Get_Bottom_Ten_Media` TO 'api'@'%';
GRANT SELECT, SHOW VIEW ON `Get_Bottom_Ten_Movies` TO 'api'@'%';
GRANT SELECT, SHOW VIEW ON `Get_Bottom_Ten_Series` TO 'api'@'%';
GRANT SELECT, SHOW VIEW ON `Get_Top_Ten_Longest_Series` TO 'api'@'%';
GRANT SELECT, SHOW VIEW ON `Get_Top_Ten_Shortest_Series` TO 'api'@'%';
GRANT SELECT, SHOW VIEW ON `Get_Top_Ten_Longest_Movies` TO 'api'@'%';
GRANT SELECT, SHOW VIEW ON `Get_Top_Ten_Shortest_Movies` TO 'api'@'%';
GRANT SELECT, SHOW VIEW ON `Get_Top_Ten_Watched_Genres` TO 'api'@'%';
GRANT SELECT, SHOW VIEW ON `Get_Top_Ten_Watched_Media` TO 'api'@'%';
GRANT SELECT, SHOW VIEW ON `Get_Top_Ten_Watched_Movies` TO 'api'@'%';
GRANT SELECT, SHOW VIEW ON `Get_Top_Ten_Watched_Series` TO 'api'@'%';
GRANT SELECT, SHOW VIEW ON `Get_Subscription_Details` TO 'api'@'%';
GRANT SELECT, SHOW VIEW ON `Get_Token` TO 'api'@'%';
GRANT SELECT, SHOW VIEW ON `Get_Account_Id` TO 'api'@'%';
GRANT SELECT, SHOW VIEW ON `List_Series` TO 'api'@'%';
GRANT SELECT, SHOW VIEW ON `List_Episodes` TO 'api'@'%';
GRANT SELECT, SHOW VIEW ON `Get_Profile_Id` TO 'api'@'%';
GRANT SELECT, SHOW VIEW ON `List_Watch_List` TO 'api'@'%';
GRANT SELECT, SHOW VIEW ON `List_Classifications` TO 'api'@'%';

-- Drop root users (if they exist)
DROP USER IF EXISTS 'root'@'localhost';
DROP USER IF EXISTS 'root'@'%';

-- Flush privileges to apply changes
FLUSH PRIVILEGES;


