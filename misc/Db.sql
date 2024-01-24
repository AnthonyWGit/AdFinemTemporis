-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour adfinemtemporis
CREATE DATABASE IF NOT EXISTS `adfinemtemporis` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `adfinemtemporis`;

-- Listage de la structure de table adfinemtemporis. battle
CREATE TABLE IF NOT EXISTS `battle` (
  `id` int NOT NULL AUTO_INCREMENT,
  `xp_earned` int NOT NULL,
  `gold_earned` int NOT NULL,
  `demon_player1_id` int DEFAULT NULL,
  `demon_player2_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_139917346BE07B85` (`demon_player1_id`),
  KEY `IDX_139917347955D46B` (`demon_player2_id`),
  CONSTRAINT `FK_139917346BE07B85` FOREIGN KEY (`demon_player1_id`) REFERENCES `demon_player` (`id`),
  CONSTRAINT `FK_139917347955D46B` FOREIGN KEY (`demon_player2_id`) REFERENCES `demon_player` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=370 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table adfinemtemporis.battle : ~0 rows (environ)

-- Listage de la structure de table adfinemtemporis. category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table adfinemtemporis.category : ~2 rows (environ)
REPLACE INTO `category` (`id`, `name`) VALUES
	(1, 'Healing'),
	(2, 'Utility');

-- Listage de la structure de table adfinemtemporis. demon_base
CREATE TABLE IF NOT EXISTS `demon_base` (
  `id` int NOT NULL AUTO_INCREMENT,
  `str_demon_base` int NOT NULL,
  `end_demon_base` int NOT NULL,
  `agi_demon_base` int NOT NULL,
  `inte_demon_base` int NOT NULL,
  `lck_demon_base` int NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pantheon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `base_hp` int NOT NULL,
  `lore` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table adfinemtemporis.demon_base : ~7 rows (environ)
REPLACE INTO `demon_base` (`id`, `str_demon_base`, `end_demon_base`, `agi_demon_base`, `inte_demon_base`, `lck_demon_base`, `img`, `name`, `pantheon`, `base_hp`, `lore`) VALUES
	(1, 5, 5, 5, 5, 5, NULL, 'Ymir', 'Norse', 90, NULL),
	(2, 5, 5, 5, 5, 5, NULL, 'Hades', 'Greek', 90, NULL),
	(3, 5, 5, 5, 5, 5, NULL, 'Horus', 'Egyptian', 90, NULL),
	(4, 5, 10, 10, 20, 5, NULL, 'Xiuhcoatl', 'Aztec', 90, '\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum vehicula ipsum a odio egestas, sit amet pretium tortor consequat. Quisque placerat fringilla tellus, vel ultricies ipsum. Etiam risus mauris, feugiat eu elit in, dapibus bibendum lorem. Maecenas pulvinar, odio ac dictum vulputate, nisl ipsum cursus purus, id tempor purus turpis eu tellus. Morbi sed odio nec justo aliquam dictum a sit amet sem. Duis a orci lacus. Vivamus tempor mauris orci, nec lobortis ligula convallis vel. Etiam molestie cursus tellus, ac porta ligula iaculis a. Phasellus quis sem eros. Nullam nec risus pulvinar, tristique enim eget, malesuada nulla.\r\n\r\nMaecenas ut malesuada risus, eu mattis lacus. Vestibulum rhoncus tellus massa, id malesuada ligula sodales quis. Pellentesque felis odio, finibus ut molestie at, tristique ac magna. Phasellus id justo fringilla, aliquet lectus nec, pharetra dui. Mauris nec facilisis diam, et pulvinar arcu. Praesent et mauris vestibulum, rutrum nisi eu, rhoncus nisi. Nullam euismod aliquam imperdiet. Nullam vitae ipsum non erat efficitur vulputate sed a justo. Quisque ultrices id leo a eleifend.\r\n\r\nMaecenas leo ipsum, fringilla ac sodales et, pulvinar nec ipsum. Cras finibus tortor at ullamcorper bibendum. Nulla convallis sodales libero, et scelerisque tellus gravida eu. Nam maximus efficitur posuere. Aenean ac massa et leo suscipit fringilla vitae a enim. Vestibulum iaculis ligula a est commodo, in tincidunt orci accumsan. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ut urna nibh. Nunc non arcu in purus eleifend ullamcorper at sit amet lacus. Cras aliquam elit eget ante faucibus rutrum. Suspendisse feugiat metus vitae ligula viverra consectetur. Etiam dignissim, quam eget vulputate vestibulum, augue sem pulvinar orci, et vehicula metus ex sit amet ligula. Donec blandit dignissim purus ac malesuada. Sed vel tristique eros.\r\n\r\nAenean viverra faucibus lectus, in pulvinar sapien tempus nec. Curabitur feugiat vitae lacus in commodo. Pellentesque sed augue libero. Nulla interdum, metus in vehicula vestibulum, lacus ligula consequat dui, id cursus velit justo in lacus. Pellentesque fermentum, neque a mattis placerat, sem metus varius lectus, quis viverra urna enim quis felis. Morbi efficitur sit amet augue rutrum sagittis. Aenean id finibus ligula. Cras velit urna, tempus nec lorem nec, lacinia volutpat nibh. Aenean condimentum augue non hendrerit ultrices. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Curabitur finibus ut magna at accumsan. Suspendisse et maximus lectus. Praesent non dictum turpis. Nullam non mauris eros.\r\n\r\nUt feugiat ligula sed elit efficitur, non hendrerit justo fermentum. Integer arcu diam, vulputate at lobortis eleifend, malesuada eu ex. Nam gravida viverra est at lacinia. In hac habitasse platea dictumst. Nullam commodo tincidunt rhoncus. Praesent ac tincidunt nulla. Vestibulum porttitor, nibh sed dictum vestibulum, odio ante semper tortor, a commodo turpis magna eget metus. In dictum quis tortor ac dignissim. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nulla sit amet felis sit amet ante pulvinar auctor in et nisi. Praesent venenatis porta libero, vitae ultricies ante vehicula at. In rutrum eleifend leo, ut convallis libero scelerisque vel. Integer varius ut orci sed sodales. Aenean fermentum lobortis odio.'),
	(5, 800000, 15, 5, 5, 5, NULL, 'Chernobog', 'Slavic', 100, '\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum vehicula ipsum a odio egestas, sit amet pretium tortor consequat. Quisque placerat fringilla tellus, vel ultricies ipsum. Etiam risus mauris, feugiat eu elit in, dapibus bibendum lorem. Maecenas pulvinar, odio ac dictum vulputate, nisl ipsum cursus purus, id tempor purus turpis eu tellus. Morbi sed odio nec justo aliquam dictum a sit amet sem. Duis a orci lacus. Vivamus tempor mauris orci, nec lobortis ligula convallis vel. Etiam molestie cursus tellus, ac porta ligula iaculis a. Phasellus quis sem eros. Nullam nec risus pulvinar, tristique enim eget, malesuada nulla.\r\n\r\nMaecenas ut malesuada risus, eu mattis lacus. Vestibulum rhoncus tellus massa, id malesuada ligula sodales quis. Pellentesque felis odio, finibus ut molestie at, tristique ac magna. Phasellus id justo fringilla, aliquet lectus nec, pharetra dui. Mauris nec facilisis diam, et pulvinar arcu. Praesent et mauris vestibulum, rutrum nisi eu, rhoncus nisi. Nullam euismod aliquam imperdiet. Nullam vitae ipsum non erat efficitur vulputate sed a justo. Quisque ultrices id leo a eleifend.\r\n\r\nMaecenas leo ipsum, fringilla ac sodales et, pulvinar nec ipsum. Cras finibus tortor at ullamcorper bibendum. Nulla convallis sodales libero, et scelerisque tellus gravida eu. Nam maximus efficitur posuere. Aenean ac massa et leo suscipit fringilla vitae a enim. Vestibulum iaculis ligula a est commodo, in tincidunt orci accumsan. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ut urna nibh. Nunc non arcu in purus eleifend ullamcorper at sit amet lacus. Cras aliquam elit eget ante faucibus rutrum. Suspendisse feugiat metus vitae ligula viverra consectetur. Etiam dignissim, quam eget vulputate vestibulum, augue sem pulvinar orci, et vehicula metus ex sit amet ligula. Donec blandit dignissim purus ac malesuada. Sed vel tristique eros.\r\n\r\nAenean viverra faucibus lectus, in pulvinar sapien tempus nec. Curabitur feugiat vitae lacus in commodo. Pellentesque sed augue libero. Nulla interdum, metus in vehicula vestibulum, lacus ligula consequat dui, id cursus velit justo in lacus. Pellentesque fermentum, neque a mattis placerat, sem metus varius lectus, quis viverra urna enim quis felis. Morbi efficitur sit amet augue rutrum sagittis. Aenean id finibus ligula. Cras velit urna, tempus nec lorem nec, lacinia volutpat nibh. Aenean condimentum augue non hendrerit ultrices. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Curabitur finibus ut magna at accumsan. Suspendisse et maximus lectus. Praesent non dictum turpis. Nullam non mauris eros.\r\n\r\nUt feugiat ligula sed elit efficitur, non hendrerit justo fermentum. Integer arcu diam, vulputate at lobortis eleifend, malesuada eu ex. Nam gravida viverra est at lacinia. In hac habitasse platea dictumst. Nullam commodo tincidunt rhoncus. Praesent ac tincidunt nulla. Vestibulum porttitor, nibh sed dictum vestibulum, odio ante semper tortor, a commodo turpis magna eget metus. In dictum quis tortor ac dignissim. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nulla sit amet felis sit amet ante pulvinar auctor in et nisi. Praesent venenatis porta libero, vitae ultricies ante vehicula at. In rutrum eleifend leo, ut convallis libero scelerisque vel. Integer varius ut orci sed sodales. Aenean fermentum lobortis odio.'),
	(6, 2, 2, 2, 2, 2, NULL, 'Imp', 'Latin', 50, '\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum vehicula ipsum a odio egestas, sit amet pretium tortor consequat. Quisque placerat fringilla tellus, vel ultricies ipsum. Etiam risus mauris, feugiat eu elit in, dapibus bibendum lorem. Maecenas pulvinar, odio ac dictum vulputate, nisl ipsum cursus purus, id tempor purus turpis eu tellus. Morbi sed odio nec justo aliquam dictum a sit amet sem. Duis a orci lacus. Vivamus tempor mauris orci, nec lobortis ligula convallis vel. Etiam molestie cursus tellus, ac porta ligula iaculis a. Phasellus quis sem eros. Nullam nec risus pulvinar, tristique enim eget, malesuada nulla.\r\n\r\nMaecenas ut malesuada risus, eu mattis lacus. Vestibulum rhoncus tellus massa, id malesuada ligula sodales quis. Pellentesque felis odio, finibus ut molestie at, tristique ac magna. Phasellus id justo fringilla, aliquet lectus nec, pharetra dui. Mauris nec facilisis diam, et pulvinar arcu. Praesent et mauris vestibulum, rutrum nisi eu, rhoncus nisi. Nullam euismod aliquam imperdiet. Nullam vitae ipsum non erat efficitur vulputate sed a justo. Quisque ultrices id leo a eleifend.\r\n\r\nMaecenas leo ipsum, fringilla ac sodales et, pulvinar nec ipsum. Cras finibus tortor at ullamcorper bibendum. Nulla convallis sodales libero, et scelerisque tellus gravida eu. Nam maximus efficitur posuere. Aenean ac massa et leo suscipit fringilla vitae a enim. Vestibulum iaculis ligula a est commodo, in tincidunt orci accumsan. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ut urna nibh. Nunc non arcu in purus eleifend ullamcorper at sit amet lacus. Cras aliquam elit eget ante faucibus rutrum. Suspendisse feugiat metus vitae ligula viverra consectetur. Etiam dignissim, quam eget vulputate vestibulum, augue sem pulvinar orci, et vehicula metus ex sit amet ligula. Donec blandit dignissim purus ac malesuada. Sed vel tristique eros.\r\n\r\nAenean viverra faucibus lectus, in pulvinar sapien tempus nec. Curabitur feugiat vitae lacus in commodo. Pellentesque sed augue libero. Nulla interdum, metus in vehicula vestibulum, lacus ligula consequat dui, id cursus velit justo in lacus. Pellentesque fermentum, neque a mattis placerat, sem metus varius lectus, quis viverra urna enim quis felis. Morbi efficitur sit amet augue rutrum sagittis. Aenean id finibus ligula. Cras velit urna, tempus nec lorem nec, lacinia volutpat nibh. Aenean condimentum augue non hendrerit ultrices. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Curabitur finibus ut magna at accumsan. Suspendisse et maximus lectus. Praesent non dictum turpis. Nullam non mauris eros.\r\n\r\nUt feugiat ligula sed elit efficitur, non hendrerit justo fermentum. Integer arcu diam, vulputate at lobortis eleifend, malesuada eu ex. Nam gravida viverra est at lacinia. In hac habitasse platea dictumst. Nullam commodo tincidunt rhoncus. Praesent ac tincidunt nulla. Vestibulum porttitor, nibh sed dictum vestibulum, odio ante semper tortor, a commodo turpis magna eget metus. In dictum quis tortor ac dignissim. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nulla sit amet felis sit amet ante pulvinar auctor in et nisi. Praesent venenatis porta libero, vitae ultricies ante vehicula at. In rutrum eleifend leo, ut convallis libero scelerisque vel. Integer varius ut orci sed sodales. Aenean fermentum lobortis odio.'),
	(12, 5, 5, 5, 5, 5, NULL, 'TRC', 'qdqzbdqz', 15, 'HJDQZDJGZYde');

-- Listage de la structure de table adfinemtemporis. demon_player
CREATE TABLE IF NOT EXISTS `demon_player` (
  `id` int NOT NULL AUTO_INCREMENT,
  `player_id` int DEFAULT NULL,
  `trait_id` int NOT NULL,
  `demon_base_id` int DEFAULT NULL,
  `str_points` int NOT NULL,
  `end_points` int NOT NULL,
  `agi_points` int NOT NULL,
  `int_points` int NOT NULL,
  `lck_points` int NOT NULL,
  `experience` int NOT NULL,
  `lvl_up_points` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_EFE69AC699E6F5DF` (`player_id`),
  KEY `IDX_EFE69AC61C18632B` (`trait_id`),
  KEY `IDX_EFE69AC626CFD2F3` (`demon_base_id`),
  CONSTRAINT `FK_EFE69AC61C18632B` FOREIGN KEY (`trait_id`) REFERENCES `demon_trait` (`id`),
  CONSTRAINT `FK_EFE69AC626CFD2F3` FOREIGN KEY (`demon_base_id`) REFERENCES `demon_base` (`id`),
  CONSTRAINT `FK_EFE69AC699E6F5DF` FOREIGN KEY (`player_id`) REFERENCES `player` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=691 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table adfinemtemporis.demon_player : ~9 rows (environ)
REPLACE INTO `demon_player` (`id`, `player_id`, `trait_id`, `demon_base_id`, `str_points`, `end_points`, `agi_points`, `int_points`, `lck_points`, `experience`, `lvl_up_points`) VALUES
	(436, 8, 6, 6, 0, 0, 0, 0, 0, 0, 0),
	(437, 8, 4, 6, 0, 0, 0, 0, 0, 0, 0),
	(439, 8, 4, 6, 0, 0, 0, 0, 0, 0, 0),
	(440, 8, 6, 6, 0, 0, 0, 0, 0, 0, 0),
	(442, 8, 3, 6, 0, 0, 0, 0, 0, 0, 0),
	(448, 8, 3, 6, 0, 0, 0, 0, 0, 0, 0),
	(456, 1, 1, 1, 5, 0, 4, 0, 0, 0, 0),
	(482, 15, 4, 4, 0, 0, 0, 2, 0, 1800, 1),
	(689, 5, 2, 5, 0, 0, 0, 0, 0, 600, 1);

-- Listage de la structure de table adfinemtemporis. demon_player_skill
CREATE TABLE IF NOT EXISTS `demon_player_skill` (
  `demon_player_id` int NOT NULL,
  `skill_id` int NOT NULL,
  PRIMARY KEY (`demon_player_id`,`skill_id`),
  KEY `IDX_D9A8438A31A40AF0` (`demon_player_id`),
  KEY `IDX_D9A8438A5585C142` (`skill_id`),
  CONSTRAINT `FK_D9A8438A31A40AF0` FOREIGN KEY (`demon_player_id`) REFERENCES `demon_player` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_D9A8438A5585C142` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table adfinemtemporis.demon_player_skill : ~9 rows (environ)
REPLACE INTO `demon_player_skill` (`demon_player_id`, `skill_id`) VALUES
	(436, 20),
	(437, 20),
	(439, 20),
	(440, 20),
	(442, 20),
	(448, 20),
	(482, 3),
	(689, 1),
	(689, 19);

-- Listage de la structure de table adfinemtemporis. demon_trait
CREATE TABLE IF NOT EXISTS `demon_trait` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `strength` int NOT NULL,
  `endurance` int NOT NULL,
  `agility` int NOT NULL,
  `intelligence` int NOT NULL,
  `luck` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table adfinemtemporis.demon_trait : ~6 rows (environ)
REPLACE INTO `demon_trait` (`id`, `name`, `strength`, `endurance`, `agility`, `intelligence`, `luck`) VALUES
	(1, 'Sturdy', 0, 10, -5, 0, 0),
	(2, 'Agile', 0, 0, 10, 0, 0),
	(3, 'Frail', -5, -5, 10, 0, 5),
	(4, 'Luck', 0, 0, 0, 0, 10),
	(5, 'Brutal', 10, 0, 0, 0, 0),
	(6, 'Clumsy', 0, 0, -5, 0, 0);

-- Listage de la structure de table adfinemtemporis. have_item
CREATE TABLE IF NOT EXISTS `have_item` (
  `id` int NOT NULL AUTO_INCREMENT,
  `player_id` int DEFAULT NULL,
  `item_id` int DEFAULT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4E6E4ED799E6F5DF` (`player_id`),
  KEY `IDX_4E6E4ED7126F525E` (`item_id`),
  CONSTRAINT `FK_4E6E4ED7126F525E` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`),
  CONSTRAINT `FK_4E6E4ED799E6F5DF` FOREIGN KEY (`player_id`) REFERENCES `player` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table adfinemtemporis.have_item : ~2 rows (environ)

-- Listage de la structure de table adfinemtemporis. item
CREATE TABLE IF NOT EXISTS `item` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1F1B251E12469DE2` (`category_id`),
  CONSTRAINT `FK_1F1B251E12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table adfinemtemporis.item : ~3 rows (environ)
REPLACE INTO `item` (`id`, `category_id`, `name`, `cost`) VALUES
	(1, 1, 'Potion', 0),
	(2, 1, 'Super Potion', 0),
	(3, 1, 'Hyper Potion', 0);

-- Listage de la structure de table adfinemtemporis. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table adfinemtemporis.messenger_messages : ~0 rows (environ)

-- Listage de la structure de table adfinemtemporis. player
CREATE TABLE IF NOT EXISTS `player` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gold` int NOT NULL,
  `stage` int NOT NULL,
  `register_date` datetime NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roles` json NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `deletedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_98197A65F85E0677` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table adfinemtemporis.player : ~14 rows (environ)
REPLACE INTO `player` (`id`, `username`, `password`, `gold`, `stage`, `register_date`, `email`, `roles`, `is_verified`, `deletedAt`) VALUES
	(1, 'Olalal', '$2y$13$nfKUHgbppLCB74JcIBmYc.ckMIte6jgfzxRir25HtbwTbkcaeazCC', 0, 0, '2023-10-11 10:43:53', 'ola@gmail.com', '["ROLE_USER"]', 0, NULL),
	(2, 'Olalale', '$2y$13$d4qayu3defJ6iO4Ssr.rbOBxjp1g2HSvNm2YsmgOE1WjEwyIiSHym', 0, 0, '2023-10-11 10:44:47', 'ola@gmail.com', '["ROLE_USER"]', 1, NULL),
	(4, 'User', '$2y$13$Oy57JjphDud1/cbc0MT0M.s/PfKt1UWg/tVLnP9Rqso1YxC0koFM2', 0, 0, '2023-10-11 13:05:13', 'user@gmail.com', '["ROLE_USER"]', 1, NULL),
	(5, 'Admin', '$2y$13$bu3ITkY7nVaBBlBjgxxcxexB7GVdv7XL0xj.LofbBCLRKEU432QDC', 30, 9999, '2023-10-12 11:12:40', 'admin@gmail.com', '["ROLE_ADMIN"]', 1, NULL),
	(7, 'UserTwo', '$2y$13$CMcsnzGceFX/2YiL1Mpt5.vNLySi035fyLB6yZfjVpqChJLQqVg..', 0, 0, '2023-10-16 09:51:47', 'thisemail@gmail.com', '[]', 1, NULL),
	(8, 'CPU', 'p', 0, 0, '2023-10-17 23:59:07', 'null@null.fr', '["ROLE_CPU"]', 1, NULL),
	(10, 'Usere', '$2y$13$1U187peUsG2Ti6zIjPlBz.9Uu2tVc9q4bdPTGqH0NsDmAualSKj86', 0, 0, '2023-10-28 15:05:56', 'usere@gmail.com', '["ROLE_USER"]', 1, NULL),
	(11, 'KEKX', 'NOTSAFE', 0, 0, '2023-11-27 20:27:00', 'xxx@email.fr', '[]', 1, NULL),
	(12, 'Kekekew', '$2y$13$VaKw9NuQ0VoC2AoSrcCjGOr7pMYQbpKNyAPLD.Gnz9EycSLgfAeQy', 0, 0, '2023-12-30 12:20:01', 'keka@gmail.com', '["ROLE_USER", "ROLE_BANNED"]', 1, NULL),
	(15, 'Kekleo', '$2y$13$Aq.k8kXm3sgU7ljAGtg7me8kf.OW0dBTymg4KSOG1OzYdtPhwJzlO', 90, 9999, '2024-01-10 18:30:23', 'kekleo@gmail.com', '[]', 1, NULL),
	(16, 'Deleted user', '$2y$13$CJz0pNCC6tYFkJuYPnhSae0fI6gF59oHusoZ90Yqeno5SI.C2mKwW', 0, 0, '2024-01-19 20:57:18', 'Deleted email', '[]', 1, '2024-01-19 22:05:03'),
	(19, NULL, '$2y$13$lhnmeQJ9fBEjSftTf4eWVuOx4nZMcjwDCClDszwg008ZzV.y1XgVm', 0, 0, '2024-01-21 17:25:11', NULL, '[]', 1, '2024-01-21 18:52:27'),
	(20, NULL, '$2y$13$yQstSEE10mu4EKtCmUpv6OxGELxr2p/knU02W8vE/ZZFuVeaTpJrm', 0, 0, '2024-01-21 18:53:35', NULL, '[]', 1, '2024-01-21 18:54:05'),
	(21, NULL, '$2y$13$mYX1UQFshTi6F57Xq.iCeOHhXXA7gmr9c6swp46rtoSharlqYbOPK', 0, 0, '2024-01-21 19:00:51', NULL, '[]', 1, '2024-01-21 19:04:32');

-- Listage de la structure de table adfinemtemporis. player_likes
CREATE TABLE IF NOT EXISTS `player_likes` (
  `player_id` int NOT NULL,
  `suggestion_id` int NOT NULL,
  PRIMARY KEY (`player_id`,`suggestion_id`),
  KEY `IDX_F6B8353B99E6F5DF` (`player_id`),
  KEY `IDX_F6B8353BA41BB822` (`suggestion_id`),
  CONSTRAINT `FK_F6B8353B99E6F5DF` FOREIGN KEY (`player_id`) REFERENCES `player` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_F6B8353BA41BB822` FOREIGN KEY (`suggestion_id`) REFERENCES `suggestion` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table adfinemtemporis.player_likes : ~4 rows (environ)
REPLACE INTO `player_likes` (`player_id`, `suggestion_id`) VALUES
	(4, 13),
	(5, 13),
	(7, 13),
	(15, 27);

-- Listage de la structure de table adfinemtemporis. player_suggestions
CREATE TABLE IF NOT EXISTS `player_suggestions` (
  `player_id` int NOT NULL,
  `suggestion_id` int NOT NULL,
  PRIMARY KEY (`player_id`,`suggestion_id`),
  KEY `IDX_C9816F8199E6F5DF` (`player_id`),
  KEY `IDX_C9816F81A41BB822` (`suggestion_id`),
  CONSTRAINT `FK_C9816F8199E6F5DF` FOREIGN KEY (`player_id`) REFERENCES `player` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_C9816F81A41BB822` FOREIGN KEY (`suggestion_id`) REFERENCES `suggestion` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table adfinemtemporis.player_suggestions : ~3 rows (environ)
REPLACE INTO `player_suggestions` (`player_id`, `suggestion_id`) VALUES
	(4, 13),
	(5, 27),
	(16, 29);

-- Listage de la structure de table adfinemtemporis. reset_password_request
CREATE TABLE IF NOT EXISTS `reset_password_request` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `selector` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_7CE748AA76ED395` (`user_id`),
  CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `player` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table adfinemtemporis.reset_password_request : ~1 rows (environ)

-- Listage de la structure de table adfinemtemporis. skill
CREATE TABLE IF NOT EXISTS `skill` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `base_dmg` int NOT NULL,
  `dmg_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table adfinemtemporis.skill : ~20 rows (environ)
REPLACE INTO `skill` (`id`, `name`, `base_dmg`, `dmg_type`, `description`) VALUES
	(1, 'Charge', 100, 'phys', ''),
	(2, 'Stomp', 200, 'phys', ''),
	(3, 'Fire', 100, 'mag', ''),
	(4, 'Ice', 100, 'mag', ''),
	(5, 'Thunder', 100, 'mag', ''),
	(6, 'Water', 100, 'mag', ''),
	(7, 'Garrote', 150, 'agi', ''),
	(8, 'Hemorrage', 150, 'agi', ''),
	(9, 'Heal', 200, 'int', ''),
	(10, 'Lacerate', 150, 'str/agi', ''),
	(11, 'Bite', 120, 'phys', ''),
	(12, 'Immolate', 80, 'mag', ''),
	(13, 'Frost', 300, 'mag', ''),
	(14, 'Ice Age', 500, 'mag', ''),
	(15, 'Rip and Tear', 450, 'phys', ''),
	(16, 'Inferno', 500, 'mag', ''),
	(17, 'Pillar of light', 450, 'mag', ''),
	(18, 'Dazing light', 200, 'mag', ''),
	(19, 'Curse', 50, 'pure', ''),
	(20, 'Buzz', 30, 'phys', 'Some nasty sound.');

-- Listage de la structure de table adfinemtemporis. skill_table
CREATE TABLE IF NOT EXISTS `skill_table` (
  `id` int NOT NULL AUTO_INCREMENT,
  `level` int NOT NULL,
  `skill_id` int NOT NULL,
  `demon_base_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D3011C7A5585C142` (`skill_id`),
  KEY `IDX_D3011C7A26CFD2F3` (`demon_base_id`),
  CONSTRAINT `FK_D3011C7A26CFD2F3` FOREIGN KEY (`demon_base_id`) REFERENCES `demon_base` (`id`),
  CONSTRAINT `FK_D3011C7A5585C142` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table adfinemtemporis.skill_table : ~9 rows (environ)
REPLACE INTO `skill_table` (`id`, `level`, `skill_id`, `demon_base_id`) VALUES
	(1, 1, 4, 1),
	(2, 10, 13, 1),
	(3, 15, 14, 1),
	(4, 1, 20, 6),
	(5, 1, 7, 3),
	(6, 10, 8, 3),
	(7, 1, 1, 5),
	(8, 2, 19, 5),
	(9, 1, 3, 4);

-- Listage de la structure de table adfinemtemporis. suggestion
CREATE TABLE IF NOT EXISTS `suggestion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_date` datetime NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table adfinemtemporis.suggestion : ~2 rows (environ)
REPLACE INTO `suggestion` (`id`, `title`, `post_content`, `img`, `post_date`, `status`, `is_verified`) VALUES
	(27, 'Msg Test 0', 'Msg test', NULL, '2024-01-10 21:23:31', 'accepted', 0),
	(29, 'TitleIng', 'Post', NULL, '2024-01-19 21:23:27', 'pending', 2);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
