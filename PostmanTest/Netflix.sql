-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mariadb
-- Generation Time: Jan 14, 2025 at 08:02 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `Account`
--

CREATE TABLE `Account` (
  `account_id` int(11) NOT NULL,
  `subscription_id` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `hashed_password` varchar(255) NOT NULL,
  `blocked` tinyint(1) DEFAULT 0,
  `discount_active` tinyint(1) DEFAULT 0,
  `billed_from` date NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `Account`
--

INSERT INTO `Account` (`account_id`, `subscription_id`, `email`, `hashed_password`, `blocked`, `discount_active`, `billed_from`, `created_at`, `updated_at`) VALUES
(3, 1, 'test@example.com', '$2y$12$wP4Km2/nbDEDqUwxQ5UFdOQNKGkQE6TH0Mo2vilOtcTiwWrCNzda6', 0, 1, '2025-02-01', '2025-01-14 19:31:45', '2025-01-14 19:59:24'),
(4, 2, 'blocked_user@example.com', '$2y$10$3r4jTt9b.N0Ax2ZhUw9HCeu7p3W5GtRYUzU5k5LmlcY7z8QbVFSla', 1, 0, '2023-01-01', '2025-01-14 19:31:45', '2025-01-14 19:31:45'),
(5, 3, 'daryl@example.com', '$2y$12$qA3IOUci6ozHk4qkWB/pd.nop5vu..WBt/97WXDVGXVUY5kWrcl3q', 0, 0, '2023-01-15', '2025-01-14 19:31:54', '2025-01-14 19:31:54');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Discounted_Users`
--

CREATE TABLE `Discounted_Users` (
  `account_id` int(11) NOT NULL,
  `invited_account_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Genre`
--

CREATE TABLE `Genre` (
  `genre_id` int(11) NOT NULL,
  `genre_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `Genre`
--

INSERT INTO `Genre` (`genre_id`, `genre_name`) VALUES
(1, 'Action'),
(2, 'Comedy'),
(3, 'Drama'),
(4, 'Horror');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Language`
--

CREATE TABLE `Language` (
  `lang_id` int(11) NOT NULL,
  `lang` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `Language`
--

INSERT INTO `Language` (`lang_id`, `lang`) VALUES
(1, 'English'),
(2, 'Spanish'),
(3, 'French'),
(4, 'German');

-- --------------------------------------------------------

--
-- Table structure for table `Media`
--

CREATE TABLE `Media` (
  `media_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `duration` time NOT NULL DEFAULT '00:00:00',
  `series_id` int(11) DEFAULT NULL,
  `season` int(11) DEFAULT NULL,
  `genre_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `Media`
--

INSERT INTO `Media` (`media_id`, `title`, `duration`, `series_id`, `season`, `genre_id`) VALUES
(1, 'Stranger Things S1E1', '00:48:00', 1, 1, 1),
(2, 'Friends S1E1', '00:22:00', 2, 1, 2),
(3, 'Breaking Bad S1E1', '00:58:00', 3, 1, 3),
(4, 'A Quiet Place', '01:30:00', NULL, NULL, 4);

-- --------------------------------------------------------

--
-- Table structure for table `Media_Quality`
--

CREATE TABLE `Media_Quality` (
  `media_id` int(11) NOT NULL,
  `has_uhd_version` tinyint(1) DEFAULT 0,
  `has_hd_version` tinyint(1) DEFAULT 0,
  `has_sd_version` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(4, '0001_01_01_000001_create_cache_table', 1),
(5, '0001_01_01_000002_create_jobs_table', 1),
(6, '2024_12_01_191350_create_subscriptions_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Profile`
--

CREATE TABLE `Profile` (
  `profile_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `profile_name` varchar(255) NOT NULL,
  `profile_image` varchar(255) NOT NULL DEFAULT 'placeholder.jpeg',
  `profile_age` int(11) NOT NULL,
  `profile_lang` int(11) NOT NULL,
  `profile_movies_preferred` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `Profile`
--

INSERT INTO `Profile` (`profile_id`, `account_id`, `profile_name`, `profile_image`, `profile_age`, `profile_lang`, `profile_movies_preferred`, `created_at`, `updated_at`) VALUES
(6, 3, 'Test Profile', 'test.jpeg', 25, 1, 1, '2025-01-14 19:56:29', '2025-01-14 19:56:29'),
(7, 3, 'John Profile', 'john.jpeg', 30, 1, 1, '2025-01-14 19:56:29', '2025-01-14 19:56:29'),
(8, 4, 'Emily Profile', 'emily.jpeg', 25, 2, 0, '2025-01-14 19:56:29', '2025-01-14 19:56:29'),
(9, 5, 'Daryl Profile', 'daryl.jpeg', 28, 3, 1, '2025-01-14 19:56:29', '2025-01-14 19:56:29'),
(10, 3, 'John Doe', 'placeholder.jpeg', 30, 1, 0, '2025-01-14 19:56:38', '2025-01-14 19:56:38');

-- --------------------------------------------------------

--
-- Table structure for table `Profile_Genre`
--

CREATE TABLE `Profile_Genre` (
  `profile_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Profile_Viewing_Classification`
--

CREATE TABLE `Profile_Viewing_Classification` (
  `profile_id` int(11) NOT NULL,
  `classification_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Profile_Watched_Media`
--

CREATE TABLE `Profile_Watched_Media` (
  `profile_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `subtitle_id` int(11) DEFAULT NULL,
  `pause_spot` time NOT NULL DEFAULT '00:00:00',
  `times_watched` int(11) DEFAULT 0,
  `last_watch_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Profile_Watch_List`
--

CREATE TABLE `Profile_Watch_List` (
  `list_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `media_id` int(11) DEFAULT NULL,
  `series_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Series`
--

CREATE TABLE `Series` (
  `series_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `genre_id` int(11) NOT NULL,
  `number_of_seasons` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `Series`
--

INSERT INTO `Series` (`series_id`, `title`, `genre_id`, `number_of_seasons`) VALUES
(1, 'Stranger Things', 1, 4),
(2, 'Friends', 2, 10),
(3, 'Breaking Bad', 3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `Subscription`
--

CREATE TABLE `Subscription` (
  `subscription_id` int(11) NOT NULL,
  `subscription_name` varchar(255) NOT NULL,
  `subscription_price` float NOT NULL DEFAULT 7.99
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `Subscription`
--

INSERT INTO `Subscription` (`subscription_id`, `subscription_name`, `subscription_price`) VALUES
(1, 'Basic', 7.99),
(2, 'Standard', 13.99),
(3, 'Premium', 17.99);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `subscription_id` bigint(20) UNSIGNED NOT NULL,
  `subscription_name` varchar(255) NOT NULL,
  `subscription_price` decimal(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Subtitle`
--

CREATE TABLE `Subtitle` (
  `subtitle_id` int(11) NOT NULL,
  `subtitle_lang` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `subtitle_location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `token_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`token_id`, `account_id`, `token`, `created_at`, `updated_at`) VALUES
(2, 3, 'afd23de3fd4ee222e05a87cd56e7c8fc8e510cbba997dbf7f85a2f99fc120cd8f25b745b51e3895c', '2025-01-14 19:43:40', '2025-01-14 19:43:40');

-- --------------------------------------------------------

--
-- Table structure for table `Viewing_Classification`
--

CREATE TABLE `Viewing_Classification` (
  `classification_id` int(11) NOT NULL,
  `classification` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Account`
--
ALTER TABLE `Account`
  ADD PRIMARY KEY (`account_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `subscription_id` (`subscription_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `Discounted_Users`
--
ALTER TABLE `Discounted_Users`
  ADD PRIMARY KEY (`account_id`,`invited_account_id`),
  ADD KEY `invited_account_id` (`invited_account_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `Genre`
--
ALTER TABLE `Genre`
  ADD PRIMARY KEY (`genre_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Language`
--
ALTER TABLE `Language`
  ADD PRIMARY KEY (`lang_id`);

--
-- Indexes for table `Media`
--
ALTER TABLE `Media`
  ADD PRIMARY KEY (`media_id`),
  ADD KEY `series_id` (`series_id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Indexes for table `Media_Quality`
--
ALTER TABLE `Media_Quality`
  ADD PRIMARY KEY (`media_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Profile`
--
ALTER TABLE `Profile`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `profile_lang` (`profile_lang`);

--
-- Indexes for table `Profile_Genre`
--
ALTER TABLE `Profile_Genre`
  ADD PRIMARY KEY (`profile_id`,`genre_id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Indexes for table `Profile_Viewing_Classification`
--
ALTER TABLE `Profile_Viewing_Classification`
  ADD PRIMARY KEY (`profile_id`,`classification_id`),
  ADD KEY `classification_id` (`classification_id`);

--
-- Indexes for table `Profile_Watched_Media`
--
ALTER TABLE `Profile_Watched_Media`
  ADD PRIMARY KEY (`profile_id`,`media_id`),
  ADD KEY `media_id` (`media_id`),
  ADD KEY `subtitle_id` (`subtitle_id`);

--
-- Indexes for table `Profile_Watch_List`
--
ALTER TABLE `Profile_Watch_List`
  ADD PRIMARY KEY (`list_id`),
  ADD KEY `profile_id` (`profile_id`),
  ADD KEY `media_id` (`media_id`),
  ADD KEY `series_id` (`series_id`);

--
-- Indexes for table `Series`
--
ALTER TABLE `Series`
  ADD PRIMARY KEY (`series_id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Indexes for table `Subscription`
--
ALTER TABLE `Subscription`
  ADD PRIMARY KEY (`subscription_id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`subscription_id`),
  ADD UNIQUE KEY `subscriptions_subscription_name_unique` (`subscription_name`);

--
-- Indexes for table `Subtitle`
--
ALTER TABLE `Subtitle`
  ADD PRIMARY KEY (`subtitle_id`),
  ADD KEY `subtitle_lang` (`subtitle_lang`),
  ADD KEY `media_id` (`media_id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`token_id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `Viewing_Classification`
--
ALTER TABLE `Viewing_Classification`
  ADD PRIMARY KEY (`classification_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Account`
--
ALTER TABLE `Account`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Genre`
--
ALTER TABLE `Genre`
  MODIFY `genre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Language`
--
ALTER TABLE `Language`
  MODIFY `lang_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Media`
--
ALTER TABLE `Media`
  MODIFY `media_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `Profile`
--
ALTER TABLE `Profile`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `Profile_Watch_List`
--
ALTER TABLE `Profile_Watch_List`
  MODIFY `list_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Series`
--
ALTER TABLE `Series`
  MODIFY `series_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Subscription`
--
ALTER TABLE `Subscription`
  MODIFY `subscription_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `subscription_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Subtitle`
--
ALTER TABLE `Subtitle`
  MODIFY `subtitle_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `token_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Viewing_Classification`
--
ALTER TABLE `Viewing_Classification`
  MODIFY `classification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Account`
--
ALTER TABLE `Account`
  ADD CONSTRAINT `Account_ibfk_1` FOREIGN KEY (`subscription_id`) REFERENCES `Subscription` (`subscription_id`) ON DELETE CASCADE;

--
-- Constraints for table `Discounted_Users`
--
ALTER TABLE `Discounted_Users`
  ADD CONSTRAINT `Discounted_Users_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `Account` (`account_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Discounted_Users_ibfk_2` FOREIGN KEY (`invited_account_id`) REFERENCES `Account` (`account_id`) ON DELETE CASCADE;

--
-- Constraints for table `Media`
--
ALTER TABLE `Media`
  ADD CONSTRAINT `Media_ibfk_1` FOREIGN KEY (`series_id`) REFERENCES `Series` (`series_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Media_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `Genre` (`genre_id`) ON DELETE CASCADE;

--
-- Constraints for table `Media_Quality`
--
ALTER TABLE `Media_Quality`
  ADD CONSTRAINT `Media_Quality_ibfk_1` FOREIGN KEY (`media_id`) REFERENCES `Media` (`media_id`) ON DELETE CASCADE;

--
-- Constraints for table `Profile`
--
ALTER TABLE `Profile`
  ADD CONSTRAINT `Profile_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `Account` (`account_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Profile_ibfk_2` FOREIGN KEY (`profile_lang`) REFERENCES `Language` (`lang_id`) ON DELETE CASCADE;

--
-- Constraints for table `Profile_Genre`
--
ALTER TABLE `Profile_Genre`
  ADD CONSTRAINT `Profile_Genre_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `Profile` (`profile_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Profile_Genre_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `Genre` (`genre_id`) ON DELETE CASCADE;

--
-- Constraints for table `Profile_Viewing_Classification`
--
ALTER TABLE `Profile_Viewing_Classification`
  ADD CONSTRAINT `Profile_Viewing_Classification_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `Profile` (`profile_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Profile_Viewing_Classification_ibfk_2` FOREIGN KEY (`classification_id`) REFERENCES `Viewing_Classification` (`classification_id`) ON DELETE CASCADE;

--
-- Constraints for table `Profile_Watched_Media`
--
ALTER TABLE `Profile_Watched_Media`
  ADD CONSTRAINT `Profile_Watched_Media_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `Profile` (`profile_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Profile_Watched_Media_ibfk_2` FOREIGN KEY (`media_id`) REFERENCES `Media` (`media_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Profile_Watched_Media_ibfk_3` FOREIGN KEY (`subtitle_id`) REFERENCES `Subtitle` (`subtitle_id`) ON DELETE CASCADE;

--
-- Constraints for table `Profile_Watch_List`
--
ALTER TABLE `Profile_Watch_List`
  ADD CONSTRAINT `Profile_Watch_List_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `Profile` (`profile_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Profile_Watch_List_ibfk_2` FOREIGN KEY (`media_id`) REFERENCES `Media` (`media_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Profile_Watch_List_ibfk_3` FOREIGN KEY (`series_id`) REFERENCES `Series` (`series_id`) ON DELETE CASCADE;

--
-- Constraints for table `Series`
--
ALTER TABLE `Series`
  ADD CONSTRAINT `Series_ibfk_1` FOREIGN KEY (`genre_id`) REFERENCES `Genre` (`genre_id`) ON DELETE CASCADE;

--
-- Constraints for table `Subtitle`
--
ALTER TABLE `Subtitle`
  ADD CONSTRAINT `Subtitle_ibfk_1` FOREIGN KEY (`subtitle_lang`) REFERENCES `Language` (`lang_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Subtitle_ibfk_2` FOREIGN KEY (`media_id`) REFERENCES `Media` (`media_id`) ON DELETE CASCADE;

--
-- Constraints for table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `tokens_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `Account` (`account_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
