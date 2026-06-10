-- KoraStream Database Schema & Seeds

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Drop existing tables to ensure a clean installation
DROP TABLE IF EXISTS `match_servers`, `matches`, `channels`, `teams`, `leagues`, `admins`, `ad_settings`, `app_settings`;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('super_admin','admin','editor') NOT NULL DEFAULT 'admin',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `leagues`
--

CREATE TABLE IF NOT EXISTS `leagues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `logo` varchar(500) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `logo` varchar(500) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `channels`
--

CREATE TABLE IF NOT EXISTS `channels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `logo` varchar(500) DEFAULT NULL,
  `stream_url` text DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `matches`
--

CREATE TABLE IF NOT EXISTS `matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `home_team_id` int(11) NOT NULL,
  `away_team_id` int(11) NOT NULL,
  `league_id` int(11) NOT NULL,
  `match_time` datetime NOT NULL,
  `status` enum('upcoming','live','finished') NOT NULL DEFAULT 'upcoming',
  `home_score` int(11) DEFAULT 0,
  `away_score` int(11) DEFAULT 0,
  `commentator` varchar(100) DEFAULT NULL,
  `channel_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `home_team_id` (`home_team_id`),
  KEY `away_team_id` (`away_team_id`),
  KEY `league_id` (`league_id`),
  KEY `channel_id` (`channel_id`),
  CONSTRAINT `matches_ibfk_1` FOREIGN KEY (`home_team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
  CONSTRAINT `matches_ibfk_2` FOREIGN KEY (`away_team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
  CONSTRAINT `matches_ibfk_3` FOREIGN KEY (`league_id`) REFERENCES `leagues` (`id`) ON DELETE CASCADE,
  CONSTRAINT `matches_ibfk_4` FOREIGN KEY (`channel_id`) REFERENCES `channels` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `match_servers`
--

CREATE TABLE IF NOT EXISTS `match_servers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `match_id` int(11) NOT NULL,
  `server_name` varchar(100) NOT NULL,
  `stream_url` text NOT NULL,
  `player_type` enum('iframe','m3u8','youtube','dash') NOT NULL DEFAULT 'iframe',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `match_id` (`match_id`),
  CONSTRAINT `match_servers_ibfk_1` FOREIGN KEY (`match_id`) REFERENCES `matches` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `ad_settings`
--

CREATE TABLE IF NOT EXISTS `ad_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `network_name` varchar(50) NOT NULL,
  `settings_json` json DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `network_name` (`network_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `app_settings`
--

CREATE TABLE IF NOT EXISTS `app_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Seeds for table `app_settings`
--

INSERT INTO `app_settings` (`setting_key`, `setting_value`) VALUES
('site_name', 'KoraStream'),
('site_description', 'Watch live football matches directly on your device with high quality'),
('maintenance_mode', '0'),
('enable_channels', '1'),
('facebook_url', '#'),
('telegram_url', 'https://t.me/korastream'),
('custom_head_code', '');

--
-- Seeds for table `ad_settings`
--

INSERT INTO `ad_settings` (`network_name`, `settings_json`, `is_active`) VALUES
('banner_header', '{"code": ""}', 0),
('banner_player', '{"code": ""}', 0),
('popunder', '{"code": ""}', 0);

--
-- Mock seeds for sports data (teams, leagues, channels, matches)
--

INSERT INTO `leagues` (`id`, `name`, `logo`) VALUES
(1, 'UEFA Champions League', NULL),
(2, 'Premier League', NULL),
(3, 'La Liga', NULL);

INSERT INTO `teams` (`id`, `name`, `logo`) VALUES
(1, 'Real Madrid', NULL),
(2, 'Barcelona', NULL),
(3, 'Manchester City', NULL),
(4, 'Liverpool', NULL),
(5, 'Arsenal', NULL),
(6, 'Paris Saint-Germain', NULL);

INSERT INTO `channels` (`id`, `name`, `logo`, `stream_url`, `status`) VALUES
(1, 'beIN Sports HD 1', NULL, 'https://test-streams.mux.dev/x36xhzz/x36xhzz.m3u8', 'active'),
(2, 'beIN Sports HD 2', NULL, 'https://test-streams.mux.dev/x36xhzz/x36xhzz.m3u8', 'active'),
(3, 'SSC News', NULL, '', 'active');

-- Add one live match and one upcoming match
INSERT INTO `matches` (`id`, `home_team_id`, `away_team_id`, `league_id`, `match_time`, `status`, `home_score`, `away_score`, `commentator`, `channel_id`) VALUES
(1, 1, 2, 3, NOW(), 'live', 2, 1, 'Issam Chaouali', 1),
(2, 3, 4, 2, DATE_ADD(NOW(), INTERVAL 1 DAY), 'upcoming', 0, 0, 'Hafid Derradji', 2);

-- Servers for the live match (HLS test stream)
INSERT INTO `match_servers` (`match_id`, `server_name`, `stream_url`, `player_type`) VALUES
(1, 'Main Server (HD)', 'https://test-streams.mux.dev/x36xhzz/x36xhzz.m3u8', 'm3u8'),
(1, 'Backup Server (SD)', 'https://test-streams.mux.dev/x36xhzz/x36xhzz.m3u8', 'm3u8'),
(1, 'External Player (Iframe)', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'iframe');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
