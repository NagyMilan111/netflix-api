-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mariadb
-- Generation Time: Feb 05, 2025 at 11:45 AM
-- Server version: 11.6.2-MariaDB-ubu2404
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Netflix`
--
--
-- Dumping data for table `Subscription`
--

INSERT INTO `Subscription` (`subscription_id`, `subscription_name`, `subscription_price`) VALUES
(1, 'standard', 7.99),
(2, 'premium', 13.99);

--
-- Dumping data for table `Account`
--

INSERT INTO `Account` (`account_id`, `subscription_id`, `email`, `hashed_password`, `blocked`, `discount_active`, `billed_from`) VALUES
(1, 2, 'email@email.com', 'mypassword', 0, 0, '2025-01-24'),
(2, 1, 'newuser@example.com', 'eyJpdiI6InVkekNhZTUvQmx0T1EyUENlajd4QlE9PSIsInZhbHVlIjoiV0hjNy9VRVZieVpTRmI1Rkk0QTFET3VFTE5wWXptcVpxblUzK28xK2NIbz0iLCJtYWMiOiJiNmYxNmIwZGE5ZWRmNTBkMjg1N2Q5MmRlODhlYzQ5N2E2NGMzMGI0NDM4NGZmN2M4NjZhOWQ3NGZmMmY5NTg1IiwidGFnIjoiIn0=', 0, 0, '2025-01-24'),
(3, 1, 'user654@example.com', '$2y$12$US8OAajiDK09fUY1bp/7bedHtk6onYuhIcR8zu2ep9YgycxnlJCem', 0, 0, '2025-02-04'),
(4, 1, 'user653244@example.com', '$2y$12$tqJ0Wyg4ljgQvW38n6SvBO.3DeK.vJfh6.EroWlpVGTIENp9bL7zO', 0, 0, '2025-02-04'),
(5, 1, 'test@example.com', '$2y$12$KbxW4lAAXC7cHdeeOfAyCOijG.weVBeb4aNzXTpoBD5hNxchojXPi', 1, 0, '2025-02-07');

--
-- Dumping data for table `Genre`
--

INSERT INTO `Genre` (`genre_id`, `genre_name`) VALUES
(1, 'something');

--
-- Dumping data for table `Language`
--

INSERT INTO `Language` (`lang_id`, `lang`) VALUES
(1, 'English');

--
-- Dumping data for table `Media`
--

INSERT INTO `Media` (`media_id`, `title`, `duration`, `series_id`, `season`, `genre_id`) VALUES
(1, 'movie', '01:09:01', NULL, NULL, 1),
(2, 'movie2', '05:34:21', NULL, NULL, 1);

--
-- Dumping data for table `Media_Quality`
--

INSERT INTO `Media_Quality` (`media_id`, `has_uhd_version`, `has_hd_version`, `has_sd_version`) VALUES
(1, 1, 1, 1);

--
-- Dumping data for table `Profile`
--

INSERT INTO `Profile` (`profile_id`, `account_id`, `profile_name`, `profile_image`, `profile_age`, `profile_lang`, `profile_movies_preferred`) VALUES
(4, 1, 'my profile', 'placeholder', 20, 1, 1),
(6, 1, 'my profile', 'placeholder', 20, 1, 1);

--
-- Dumping data for table `Profile_Watched_Media`
--

INSERT INTO `Profile_Watched_Media` (`profile_id`, `media_id`, `subtitle_id`, `pause_spot`, `times_watched`, `last_watch_date`) VALUES
(4, 1, 1, '00:10:00', 1, '2025-02-02');

--
-- Dumping data for table `Profile_Watch_List`
--

INSERT INTO `Profile_Watch_List` (`list_id`, `profile_id`, `media_id`, `series_id`) VALUES
(1, 4, 1, NULL);

--
-- Dumping data for table `Series`
--

INSERT INTO `Series` (`series_id`, `title`, `genre_id`, `number_of_seasons`) VALUES
(3, 'Squidgame', 1, 2),
(4, 'Squidgame', 1, 2);


--
-- Dumping data for table `Subtitle`
--

INSERT INTO `Subtitle` (`subtitle_id`, `subtitle_lang`, `media_id`, `subtitle_location`) VALUES
(1, 1, 1, 'bottom');

--
-- Dumping data for table `Tokens`
--

INSERT INTO `Tokens` (`account_id`, `token`) VALUES
(1, 'dde0ff46bee41a239450d495dad38c99dd396bab19ba38b63c6148bf21fab693f4a10ec192043234');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
