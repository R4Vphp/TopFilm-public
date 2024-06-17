SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `top_film` DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci;
USE `top_film`;

CREATE TABLE IF NOT EXISTS `directors` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(32) NOT NULL,
  `lastName` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=158 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE IF NOT EXISTS `list_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movieId` int(11) NOT NULL,
  `listId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `movieId` (`movieId`,`listId`),
  KEY `listId` (`listId`)
) ENGINE=InnoDB AUTO_INCREMENT=501 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE IF NOT EXISTS `list_headers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `createdAt` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE IF NOT EXISTS `logins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `ipAddress` varchar(16) NOT NULL,
  `occuredAt` int(11) NOT NULL,
  `succeeded` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE IF NOT EXISTS `movies` (
  `id` int(11) NOT NULL,
  `originalTitle` varchar(64) NOT NULL,
  `polishTitle` varchar(64) NOT NULL,
  `productionYear` int(4) NOT NULL,
  `duration` int(11) DEFAULT NULL,
  `directorId` int(3) NOT NULL,
  `image` varchar(16) DEFAULT NULL,
  `uploadAt` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `directorID` (`directorId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE IF NOT EXISTS `movie_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `movieId` int(11) NOT NULL,
  `watched` int(1) NOT NULL,
  `rating` int(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`,`movieId`),
  KEY `movieId` (`movieId`)
) ENGINE=InnoDB AUTO_INCREMENT=619 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE IF NOT EXISTS `registration_tokens` (
  `token` varchar(16) NOT NULL,
  PRIMARY KEY (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

INSERT INTO `registration_tokens` (`token`) VALUES
('06D7-1C3D'),
('0758-2139'),
('0F2C-8940'),
('1A00-4113'),
('534E-1817'),
('65AF-F49D'),
('6748-6278'),
('780C-863A'),
('8B50-3E99'),
('9283-A767'),
('AC6F-930B'),
('AF58-25EE'),
('B13D-8CEF'),
('D300-3450'),
('D418-50D2'),
('D528-F1C7'),
('D69C-CD00');

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(128) NOT NULL,
  `createdAt` int(11) NOT NULL,
  `permissions` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;


ALTER TABLE `list_content`
  ADD CONSTRAINT `list_content_ibfk_1` FOREIGN KEY (`listId`) REFERENCES `list_headers` (`id`),
  ADD CONSTRAINT `list_content_ibfk_2` FOREIGN KEY (`movieId`) REFERENCES `movies` (`id`);

ALTER TABLE `list_headers`
  ADD CONSTRAINT `list_headers_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

ALTER TABLE `movies`
  ADD CONSTRAINT `movies_ibfk_1` FOREIGN KEY (`directorID`) REFERENCES `directors` (`id`),
  ADD CONSTRAINT `movies_ibfk_2` FOREIGN KEY (`directorId`) REFERENCES `directors` (`id`);

ALTER TABLE `movie_status`
  ADD CONSTRAINT `movie_status_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `movie_status_ibfk_2` FOREIGN KEY (`movieId`) REFERENCES `movies` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
