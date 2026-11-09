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

-- Dump della struttura di tabella auto_update.rls_brd_grp
CREATE TABLE IF NOT EXISTS `rls_brd_grp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_id` int(11) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- Dump dei dati della tabella auto_update.rls_brd_grp: ~17 rows (circa)
DELETE FROM `rls_brd_grp`;
/*!40000 ALTER TABLE `rls_brd_grp` DISABLE KEYS */;
INSERT INTO `rls_brd_grp` (`id`, `brand_id`, `group_id`) VALUES
	(1, 4, 7),
	(2, 6, 8),
	(3, 6, 9),
	(4, 6, 10),
	(5, 6, 11),
	(6, 6, 12),
	(7, 6, 13),
	(8, 7, 14),
	(9, 6, 18),
	(10, 3, 19),
	(11, 6, 20),
	(12, 6, 21),
	(13, 6, 22),
	(14, 6, 23),
	(15, 6, 24),
	(16, 6, 25),
	(17, 6, 26);
/*!40000 ALTER TABLE `rls_brd_grp` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
