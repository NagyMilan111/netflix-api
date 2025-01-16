-- Create the database
CREATE DATABASE IF NOT EXISTS `Netflix`;
USE `Netflix`;

-- Create tables in the correct order based on dependencies

-- 1. Create Language table (independent)
CREATE TABLE IF NOT EXISTS `Language` (
    lang_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    lang VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- 2. Create Genre table (independent)
CREATE TABLE IF NOT EXISTS `Genre` (
    genre_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    genre_name VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- 3. Create Viewing Classification table (independent)
CREATE TABLE IF NOT EXISTS `Viewing_Classification` (
    classification_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    classification VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- 4. Create Subscription table (independent)
CREATE TABLE IF NOT EXISTS `Subscription` (
    subscription_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    subscription_name VARCHAR(255) NOT NULL,
    subscription_price FLOAT NOT NULL DEFAULT 7.99
) ENGINE=InnoDB;

-- 5. Create Account table (depends on Subscription)
CREATE TABLE IF NOT EXISTS `Account` (
    account_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    subscription_id INT(11),
    email VARCHAR(255) NOT NULL UNIQUE,
    hashed_password VARCHAR(255) NOT NULL,
    blocked TINYINT(1) DEFAULT 0,
    discount_active TINYINT(1) DEFAULT 0,
    billed_from DATE NOT NULL,
    FOREIGN KEY (subscription_id) REFERENCES `Subscription` (subscription_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 6. Create Profile table (depends on Account and Language)
CREATE TABLE IF NOT EXISTS `Profile` (
    profile_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    account_id INT(11) NOT NULL,
    profile_name VARCHAR(255) NOT NULL,
    profile_image VARCHAR(255) NOT NULL DEFAULT 'placeholder.jpeg',
    profile_age INT(11) NOT NULL,
    profile_lang INT(11) NOT NULL,
    profile_movies_preferred TINYINT(1) DEFAULT 0,
    FOREIGN KEY (account_id) REFERENCES `Account` (account_id) ON DELETE CASCADE,
    FOREIGN KEY (profile_lang) REFERENCES `Language` (lang_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 7. Create Series table (depends on Genre)
CREATE TABLE IF NOT EXISTS `Series` (
    series_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    genre_id INT(11) NOT NULL,
    number_of_seasons INT(11) DEFAULT 1,
    FOREIGN KEY (genre_id) REFERENCES `Genre` (genre_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 8. Create Media table (independent)
CREATE TABLE IF NOT EXISTS `Media` (
    media_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    duration TIME NOT NULL DEFAULT '00:00:00',
    series_id INT(11) NULL,
    season INT(11) NULL,
	genre_id INT(11) NULL,
    FOREIGN KEY (series_id) REFERENCES `Series` (series_id) ON DELETE CASCADE,
	FOREIGN KEY (genre_id) REFERENCES `Genre` (genre_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 9. Create Media_Quality table (depends on Media)
CREATE TABLE IF NOT EXISTS `Media_Quality` (
    media_id INT(11) PRIMARY KEY,
    has_uhd_version TINYINT(1) DEFAULT 0,
    has_hd_version TINYINT(1) DEFAULT 0,
	has_sd_version TINYINT(1) DEFAULT 1,
    FOREIGN KEY (media_id) REFERENCES `Media` (media_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 10. Create Subtitle table (depends on Language and Media)
CREATE TABLE IF NOT EXISTS `Subtitle` (
    subtitle_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    subtitle_lang INT(11) NOT NULL,
    media_id INT(11) NOT NULL,
    subtitle_location VARCHAR(255) NOT NULL,
    FOREIGN KEY (subtitle_lang) REFERENCES `Language` (lang_id) ON DELETE CASCADE,
    FOREIGN KEY (media_id) REFERENCES `Media` (media_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 11. Create Profile_Genre table (depends on Profile and Genre)
CREATE TABLE IF NOT EXISTS `Profile_Genre` (
    profile_id INT(11) NOT NULL,
    genre_id INT(11) NOT NULL,
    PRIMARY KEY (profile_id, genre_id),
    FOREIGN KEY (profile_id) REFERENCES `Profile` (profile_id) ON DELETE CASCADE,
    FOREIGN KEY (genre_id) REFERENCES `Genre` (genre_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 12. Create Profile_Viewing_Classification table (depends on Profile and Viewing_Classification)
CREATE TABLE IF NOT EXISTS `Profile_Viewing_Classification` (
    profile_id INT(11) NOT NULL,
    classification_id INT(11) NOT NULL,
    PRIMARY KEY (profile_id, classification_id),
    FOREIGN KEY (profile_id) REFERENCES `Profile` (profile_id) ON DELETE CASCADE,
    FOREIGN KEY (classification_id) REFERENCES `Viewing_Classification` (classification_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 13. Create Profile_Watched_Media table (depends on Profile, Media, and Subtitle)
CREATE TABLE IF NOT EXISTS `Profile_Watched_Media` (
    profile_id INT(11) NOT NULL,
    media_id INT(11) NOT NULL,
    subtitle_id INT(11) NULL,
    pause_spot TIME NOT NULL DEFAULT '00:00:00',
    times_watched INT(11) DEFAULT 0,
    last_watch_date DATE NULL,
    PRIMARY KEY (profile_id, media_id),
    FOREIGN KEY (profile_id) REFERENCES `Profile` (profile_id) ON DELETE CASCADE,
    FOREIGN KEY (media_id) REFERENCES `Media` (media_id) ON DELETE CASCADE,
    FOREIGN KEY (subtitle_id) REFERENCES `Subtitle` (subtitle_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 14. Create Profile_Watch_List table (depends on Profile, Movie, and Series)
CREATE TABLE IF NOT EXISTS `Profile_Watch_List` (
    list_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    profile_id INT(11) NOT NULL,
    media_id INT(11) NULL,
    series_id INT(11) NULL,
    FOREIGN KEY (profile_id) REFERENCES `Profile` (profile_id) ON DELETE CASCADE,
    FOREIGN KEY (media_id) REFERENCES `Media` (media_id) ON DELETE CASCADE,
    FOREIGN KEY (series_id) REFERENCES `Series` (series_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 15. Create Discounted_Users table (depends on Account)
CREATE TABLE IF NOT EXISTS `Discounted_Users` (
    account_id INT(11) NOT NULL,
    invited_account_id INT(11) NOT NULL,
    PRIMARY KEY (account_id, invited_account_id),
    FOREIGN KEY (account_id) REFERENCES `Account` (account_id) ON DELETE CASCADE,
    FOREIGN KEY (invited_account_id) REFERENCES `Account` (account_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 16. Create Logs
CREATE TABLE IF NOT EXISTS `Logs` (
    message varchar(255) NOT NULL,
    time datetime NOT NULL
) ENGINE=InnoDB;

-- 17. Create Tokens
CREATE TABLE IF NOT EXISTS `Tokens` (
    account_id INT(11) NOT NULL,
    token INT(11) NOT NULL
) ENGINE=InnoDB;
