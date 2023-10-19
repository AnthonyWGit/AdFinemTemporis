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
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table adfinemtemporis.battle : ~5 rows (environ)
REPLACE INTO `battle` (`id`, `xp_earned`, `gold_earned`, `demon_player1_id`, `demon_player2_id`) VALUES
	(31, 0, 0, 110, 111),
	(32, 0, 0, 110, 112),
	(33, 0, 0, 110, 113),
	(34, 0, 0, 110, 114),
	(35, 0, 0, 110, 115);

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table adfinemtemporis.demon_base : ~6 rows (environ)
REPLACE INTO `demon_base` (`id`, `str_demon_base`, `end_demon_base`, `agi_demon_base`, `inte_demon_base`, `lck_demon_base`, `img`, `name`, `pantheon`, `base_hp`) VALUES
	(1, 5, 5, 5, 5, 5, NULL, 'Ymir', 'Norse', 100),
	(2, 5, 5, 5, 5, 5, NULL, 'Hades', 'Greek', 80),
	(3, 5, 10, 20, 5, 5, NULL, 'Horus', 'Egyptian', 75),
	(4, 5, 10, 10, 20, 5, NULL, 'Xiuhcoatl', 'Aztec', 90),
	(5, 20, 15, 5, 5, 5, NULL, 'Chernobog', 'Slavic', 100),
	(6, 2, 2, 2, 2, 2, NULL, 'Imp', 'Latin', 110);

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
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table adfinemtemporis.demon_player : ~8 rows (environ)
REPLACE INTO `demon_player` (`id`, `player_id`, `trait_id`, `demon_base_id`, `str_points`, `end_points`, `agi_points`, `int_points`, `lck_points`, `experience`, `lvl_up_points`) VALUES
	(110, 4, 3, 3, 0, 0, 0, 0, 0, 0, 0),
	(111, 8, 2, 6, 0, 0, 0, 0, 0, 0, 0),
	(112, 8, 1, 6, 0, 0, 0, 0, 0, 0, 0),
	(113, 8, 6, 6, 0, 0, 0, 0, 0, 0, 0),
	(114, 8, 4, 6, 0, 0, 0, 0, 0, 0, 0),
	(115, 8, 4, 6, 0, 0, 0, 0, 0, 0, 0);

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

-- Listage des données de la table adfinemtemporis.demon_player_skill : ~8 rows (environ)
REPLACE INTO `demon_player_skill` (`demon_player_id`, `skill_id`) VALUES
	(110, 7),
	(111, 20),
	(112, 20),
	(113, 20),
	(114, 20),
	(115, 20);

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table adfinemtemporis.have_item : ~0 rows (environ)

-- Listage de la structure de table adfinemtemporis. item
CREATE TABLE IF NOT EXISTS `item` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1F1B251E12469DE2` (`category_id`),
  CONSTRAINT `FK_1F1B251E12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gold` int NOT NULL,
  `stage` int NOT NULL,
  `register_date` datetime NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_98197A65F85E0677` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table adfinemtemporis.player : ~5 rows (environ)
REPLACE INTO `player` (`id`, `username`, `password`, `gold`, `stage`, `register_date`, `email`, `roles`, `is_verified`) VALUES
	(1, 'Olalal', '$2y$13$nfKUHgbppLCB74JcIBmYc.ckMIte6jgfzxRir25HtbwTbkcaeazCC', 0, 0, '2023-10-11 10:43:53', 'ola@gmail.com', '[]', 0),
	(2, 'Olalale', '$2y$13$d4qayu3defJ6iO4Ssr.rbOBxjp1g2HSvNm2YsmgOE1WjEwyIiSHym', 0, 0, '2023-10-11 10:44:47', 'ola@gmail.com', '["ROLE_USER"]', 1),
	(4, 'User', '$2y$13$Oy57JjphDud1/cbc0MT0M.s/PfKt1UWg/tVLnP9Rqso1YxC0koFM2', 0, 1, '2023-10-11 13:05:13', 'user@gmail.com', '["ROLE_USER", "ROLE_IN_COMBAT", "ROLE_IN_COMBAT"]', 1),
	(5, 'Admin', '$2y$13$bu3ITkY7nVaBBlBjgxxcxexB7GVdv7XL0xj.LofbBCLRKEU432QDC', 0, 0, '2023-10-12 11:12:40', 'admin@gmail.com', '["ROLE_ADMIN"]', 1),
	(7, 'UserTwo', '$2y$13$CMcsnzGceFX/2YiL1Mpt5.vNLySi035fyLB6yZfjVpqChJLQqVg..', 0, 0, '2023-10-16 09:51:47', 'thisemail@gmail.com', '[]', 1),
	(8, 'CPU', 'p', 0, 0, '2023-10-17 23:59:07', 'null@null.fr', '["ROLE_CPU"]', 1);

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
	(4, 21),
	(7, 13),
	(7, 21);

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

-- Listage des données de la table adfinemtemporis.player_suggestions : ~2 rows (environ)
REPLACE INTO `player_suggestions` (`player_id`, `suggestion_id`) VALUES
	(4, 13),
	(7, 21);

-- Listage de la structure de table adfinemtemporis. skill
CREATE TABLE IF NOT EXISTS `skill` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `base_dmg` int NOT NULL,
  `dmg_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table adfinemtemporis.skill : ~19 rows (environ)
REPLACE INTO `skill` (`id`, `name`, `base_dmg`, `dmg_type`) VALUES
	(1, 'Charge', 100, 'phys'),
	(2, 'Stomp', 200, 'phys'),
	(3, 'Fire', 100, 'mag'),
	(4, 'Ice', 100, 'mag'),
	(5, 'Thunder', 100, 'mag'),
	(6, 'Water', 100, 'mag'),
	(7, 'Garrote', 120, 'agi'),
	(8, 'Hemorrage', 200, 'agi'),
	(9, 'Heal', 200, 'int'),
	(10, 'Lacerate', 150, 'str/agi'),
	(11, 'Bite', 120, 'str'),
	(12, 'Immolate', 80, 'mag'),
	(13, 'Frost', 300, 'mag'),
	(14, 'Ice Age', 500, 'mag'),
	(15, 'Rip and Tear', 450, 'phys'),
	(16, 'Inferno', 500, 'mag'),
	(17, 'Pillar of light', 450, 'mag'),
	(18, 'Dazing light', 200, 'mag'),
	(19, 'Curse', 50, 'pure'),
	(20, 'Buzz', 30, 'phys');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table adfinemtemporis.skill_table : ~5 rows (environ)
REPLACE INTO `skill_table` (`id`, `level`, `skill_id`, `demon_base_id`) VALUES
	(1, 1, 4, 1),
	(2, 10, 13, 1),
	(3, 15, 14, 1),
	(4, 1, 20, 6),
	(5, 1, 7, 3),
	(6, 10, 8, 3);

-- Listage de la structure de table adfinemtemporis. suggestion
CREATE TABLE IF NOT EXISTS `suggestion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_date` datetime NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table adfinemtemporis.suggestion : ~3 rows (environ)
REPLACE INTO `suggestion` (`id`, `title`, `post_content`, `img`, `post_date`, `status`) VALUES
	(7, 'GG geena', 'Postcontent', NULL, '2023-10-12 14:42:58', NULL),
	(13, 'Title', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus dictum leo ac nisl convallis sollicitudin. Cras nec ligula vel augue faucibus malesuada. Nulla tellus enim, volutpat sit amet tempus eu, laoreet et nisi. Cras sit amet dolor odio. Nulla nec sem velit. Suspendisse non maximus urna, a congue quam. Maecenas eu lorem molestie, venenatis eros eget, pulvinar est. Donec ornare mi vitae sem blandit, eget molestie erat sodales. Nullam a eros at purus malesuada sagittis quis at nibh. Nullam ut augue euismod, placerat eros non, volutpat nisi. In hac habitasse platea dictumst. Mauris sodales dui ante, nec pellentesque quam vestibulum eget. Morbi ut imperdiet diam. Vestibulum tristique nibh a ligula pharetra pulvinar non eget enim.\r\n\r\nCurabitur ex nunc, lacinia id mattis ut, mollis quis lectus. Nullam sit amet finibus purus, quis hendrerit nunc. Ut sed blandit nunc. Nullam semper euismod volutpat. Fusce convallis, augue vel pulvinar tempus, erat nibh porttitor velit, at tempus ex orci vitae lacus. Etiam est odio, pretium nec purus non, ornare vestibulum velit. Sed vitae libero nec orci mattis suscipit at placerat orci. Integer elementum elementum tempus. Sed consectetur libero ac risus aliquam condimentum.\r\n\r\nAenean lorem felis, mattis non nisi ut, lacinia ornare lorem. Etiam tempus consequat pretium. Curabitur consectetur turpis vitae augue euismod, efficitur molestie enim accumsan. Integer sagittis euismod posuere. Sed euismod eget quam efficitur convallis. Phasellus malesuada elit et nibh auctor dictum. Sed nulla diam, laoreet sit amet justo at, gravida ultricies lorem. Duis at purus ut velit efficitur faucibus. Cras eu molestie risus, vitae elementum libero. Morbi id molestie erat.\r\n\r\nSed augue tellus, porta id orci ac, accumsan venenatis leo. Cras vehicula imperdiet justo, congue volutpat risus cursus eu. Mauris eleifend finibus quam in lobortis. Ut eu ornare neque. Aliquam erat volutpat. In blandit sed massa non elementum. Morbi congue eleifend dolor, sit amet tincidunt erat hendrerit sed. Pellentesque in nisi congue, tristique massa non, ultricies felis.\r\n\r\nPraesent porttitor tempor velit nec ornare. Sed fringilla auctor sapien, eu aliquam sem elementum nec. Curabitur sed orci lacinia, sodales erat sit amet, hendrerit turpis. Integer consectetur velit non turpis sagittis faucibus. Fusce aliquam id est a tempus. Etiam luctus tellus sed dui malesuada euismod. Donec pharetra lorem et blandit volutpat. Suspendisse finibus interdum ipsum. Sed ac elit augue. Aenean vel lorem et nisi consequat feugiat. Cras aliquam ornare neque, id porta nibh consequat ac. Pellentesque sagittis, ante sit amet varius fringilla, odio neque consectetur lectus, facilisis rutrum sem diam in justo.\r\n\r\nPraesent mollis ipsum elit, id commodo elit egestas ac. Phasellus vel lacus et odio ultricies ullamcorper. Morbi pellentesque libero sapien, quis consequat lectus hendrerit eu. Vestibulum ullamcorper ligula ac urna tempus, in varius ex luctus. Proin elit enim, hendrerit eget ullamcorper quis, aliquam sit amet felis. Phasellus eget neque elementum, porttitor nulla sit amet, iaculis massa. Duis lectus arcu, iaculis gravida enim ut, venenatis tincidunt nisi. Donec rutrum euismod velit, sit amet maximus massa ornare et. Praesent eget augue mollis, viverra sapien vitae, faucibus augue.\r\n\r\nMaecenas scelerisque tellus ipsum, sed aliquam orci pellentesque in. Vestibulum dui enim, viverra ac dictum quis, faucibus nec justo. Aenean finibus feugiat dolor, nec interdum arcu accumsan et. Aenean consectetur mi non faucibus consequat. Praesent ac pretium felis, at fringilla odio. Donec scelerisque nisi ac lorem eleifend scelerisque. Aliquam fringilla ex nulla, ac semper mi dictum non. Sed in risus et diam mollis cursus nec vel dui. Integer eget felis lacinia diam interdum luctus vitae sed lorem. Nulla facilisi. Nunc dolor magna, sodales sit amet risus ut, gravida porta ex. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec sit amet rutrum augue. Etiam porta lacus felis, nec cursus nibh maximus sed. Ut venenatis enim libero, sit amet vulputate felis dapibus id.', NULL, '2023-10-16 09:23:09', 'pending'),
	(21, 'DZD', 'WHY DO YOU RIGOLE', 'placeholder-jpg-652d2fd3df486.jpg', '2023-10-16 12:42:59', 'pending');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
