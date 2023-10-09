-- --------------------------------------------------------
-- Host:                         192.168.12.1
-- Server versie:                11.1.2-MariaDB-1:11.1.2+maria~deb12 - mariadb.org binary distribution
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Versie:              12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Databasestructuur van fruition wordt geschreven
CREATE DATABASE IF NOT EXISTS `fruition` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `fruition`;

-- Structuur van  tabel fruition.images wordt geschreven
CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` longblob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumpen data van tabel fruition.images: ~0 rows (ongeveer)
DELETE FROM `images`;

-- Structuur van  tabel fruition.items wordt geschreven
CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `description` longtext DEFAULT NULL,
  `type` int(11) NOT NULL,
  `season` int(11) NOT NULL,
  `longtitude` decimal(8,6) NOT NULL,
  `latitude` decimal(8,6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `types` (`type`),
  KEY `seasons` (`season`),
  KEY `users` (`author`),
  CONSTRAINT `seasons` FOREIGN KEY (`season`) REFERENCES `seasons` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `types` FOREIGN KEY (`type`) REFERENCES `types` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `users` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumpen data van tabel fruition.items: ~0 rows (ongeveer)
DELETE FROM `items`;

-- Structuur van  tabel fruition.roles wordt geschreven
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumpen data van tabel fruition.roles: ~4 rows (ongeveer)
DELETE FROM `roles`;
INSERT INTO `roles` (`id`, `name`) VALUES
	(1, 'guest'),
	(2, 'user'),
	(3, 'admin'),
	(4, 'owner');

-- Structuur van  tabel fruition.seasons wordt geschreven
CREATE TABLE IF NOT EXISTS `seasons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumpen data van tabel fruition.seasons: ~4 rows (ongeveer)
DELETE FROM `seasons`;
INSERT INTO `seasons` (`id`, `name`, `start`, `end`) VALUES
	(1, 'Spring', '0000-03-21', '0000-06-21'),
	(2, 'Summer', '0000-06-21', '0000-09-23'),
	(3, 'Autumn', '0000-09-23', '0000-12-21'),
	(4, 'Winter', '0000-12-21', '0000-03-21');

-- Structuur van  tabel fruition.submissions wordt geschreven
CREATE TABLE IF NOT EXISTS `submissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `approved` int(1) NOT NULL DEFAULT 0,
  `item` int(11) NOT NULL,
  `admin` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumpen data van tabel fruition.submissions: ~0 rows (ongeveer)
DELETE FROM `submissions`;

-- Structuur van  tabel fruition.types wordt geschreven
CREATE TABLE IF NOT EXISTS `types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumpen data van tabel fruition.types: ~0 rows (ongeveer)
DELETE FROM `types`;

-- Structuur van  tabel fruition.users wordt geschreven
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_image` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`),
  KEY `FK_users_roles` (`role`),
  KEY `images` (`profile_image`),
  CONSTRAINT `FK_users_roles` FOREIGN KEY (`role`) REFERENCES `roles` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `images` FOREIGN KEY (`profile_image`) REFERENCES `images` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumpen data van tabel fruition.users: ~0 rows (ongeveer)
DELETE FROM `users`;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
