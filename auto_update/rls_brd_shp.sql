-- --------------------------------------------------------
-- Host:                         www.anpira.it
-- Versione server:              5.5.68-MariaDB - MariaDB Server
-- S.O. server:                  Linux
-- HeidiSQL Versione:            11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dump della struttura di tabella auto_update.rls_brd_shp
CREATE TABLE IF NOT EXISTS `rls_brd_shp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_id` int(11) NOT NULL DEFAULT '0',
  `shop_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

-- Dump dei dati della tabella auto_update.rls_brd_shp: ~40 rows (circa)
DELETE FROM `rls_brd_shp`;
/*!40000 ALTER TABLE `rls_brd_shp` DISABLE KEYS */;
INSERT INTO `rls_brd_shp` (`id`, `brand_id`, `shop_id`) VALUES
	(1, 3, 3),
	(2, 5, 4),
	(3, 4, 5),
	(4, 2, 6),
	(5, 6, 7),
	(6, 6, 226),
	(7, 3, 240),
	(8, 7, 242),
	(9, 4, 243),
	(10, 6, 244),
	(11, 6, 245),
	(12, 6, 246),
	(13, 6, 247),
	(14, 6, 248),
	(15, 3, 249),
	(16, 3, 250),
	(17, 3, 251),
	(18, 3, 252),
	(19, 3, 253),
	(20, 3, 254),
	(21, 3, 255),
	(22, 6, 256),
	(23, 6, 257),
	(24, 6, 258),
	(25, 6, 259),
	(26, 6, 260),
	(27, 6, 261),
	(28, 6, 262),
	(29, 6, 263),
	(30, 6, 264),
	(31, 6, 265),
	(32, 6, 266),
	(33, 6, 267),
	(34, 6, 268),
	(35, 6, 269),
	(36, 6, 270),
	(37, 6, 271),
	(38, 6, 272),
	(39, 6, 273),
	(40, 6, 274);
/*!40000 ALTER TABLE `rls_brd_shp` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
