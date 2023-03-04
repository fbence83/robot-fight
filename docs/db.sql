-- --------------------------------------------------------
-- Hoszt:                        127.0.0.1
-- Szerver verzió:               10.4.24-MariaDB - mariadb.org binary distribution
-- Szerver OS:                   Win64
-- HeidiSQL Verzió:              12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Adatbázis struktúra mentése a robot_fight_demo.
CREATE DATABASE IF NOT EXISTS `robot_fight_demo` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `robot_fight_demo`;


-- Struktúra mentése tábla robot_fight_demo. robot
CREATE TABLE IF NOT EXISTS `robot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` enum('brawler','rouge','assault') NOT NULL,
  `power` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Create date',
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp() COMMENT 'Modify date',
  `deleted_at` datetime DEFAULT NULL COMMENT 'Delete date',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Is deleted',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='Robot';

-- Tábla adatainak mentése robot_fight_demo.robot: ~7 rows (hozzávetőleg)
REPLACE INTO `robot` (`id`, `name`, `type`, `power`, `created_at`, `updated_at`, `deleted_at`, `is_deleted`) VALUES
	(1, 'asd', 'brawler', 10, '2023-03-02 01:10:22', '2023-03-04 01:34:03', NULL, 1),
	(2, 'dfsdflaa', 'brawler', 100, '2023-03-03 01:10:22', '2023-03-04 01:58:23', NULL, 1),
	(3, 'bnv', 'assault', 14, '2023-03-04 01:00:22', '2023-03-04 02:08:05', NULL, 0),
	(4, 'sdfsd', 'brawler', 23, '2023-03-04 01:10:22', NULL, NULL, 0),
	(5, 'e4543', 'brawler', 2332, '2023-03-04 02:00:49', NULL, NULL, 0),
	(6, 'aaaaa3', 'brawler', 23, '2023-03-04 02:24:35', '2023-03-04 02:51:41', NULL, 0),
	(7, '1', 'brawler', 1, '2023-03-04 02:43:26', '2023-03-04 02:47:52', NULL, 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
