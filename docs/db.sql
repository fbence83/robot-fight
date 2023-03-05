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
CREATE TABLE `robot` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id',
    `name` varchar(255) NOT NULL COMMENT 'Name',
    `type` enum('brawler','rouge','assault') NOT NULL COMMENT 'Type',
    `power` int(11) NOT NULL COMMENT 'Power',
    `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Create date',
    `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp() COMMENT 'Modify date',
    `deleted_at` datetime DEFAULT NULL COMMENT 'Delete date',
    `is_deleted` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Is deleted',
    PRIMARY KEY (`id`),
    UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='Robot'

-- Tábla adatainak mentése robot_fight_demo.robot: ~5 rows (hozzávetőleg)
INSERT INTO `robot` (`id`, `name`, `type`, `power`, `created_at`, `updated_at`, `deleted_at`, `is_deleted`) VALUES (NULL, 'R2D2', 'brawler', 100, '2023-03-05 03:55:57', NULL, NULL, 0);
INSERT INTO `robot` (`id`, `name`, `type`, `power`, `created_at`, `updated_at`, `deleted_at`, `is_deleted`) VALUES (NULL, 'Terminator', 'rouge', 100000, '2023-03-05 03:56:08', '2023-03-05 03:58:42', '2023-03-05 03:58:42', 1);
INSERT INTO `robot` (`id`, `name`, `type`, `power`, `created_at`, `updated_at`, `deleted_at`, `is_deleted`) VALUES (NULL, 'C3PO', 'assault', 12, '2023-03-05 03:57:08', NULL, NULL, 0);
INSERT INTO `robot` (`id`, `name`, `type`, `power`, `created_at`, `updated_at`, `deleted_at`, `is_deleted`) VALUES (NULL, 'Destroyer', 'rouge', 11111, '2023-03-05 03:57:26', '2023-03-05 03:58:37', NULL, 0);
INSERT INTO `robot` (`id`, `name`, `type`, `power`, `created_at`, `updated_at`, `deleted_at`, `is_deleted`) VALUES (NULL, 'R4D4', 'brawler', 100, '2023-03-05 03:59:02', NULL, NULL, 0);


/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
