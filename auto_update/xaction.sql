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

-- Dump della struttura di tabella auto_update.xaction
CREATE TABLE IF NOT EXISTS `xaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo` varchar(200) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dump dei dati della tabella auto_update.xaction: ~1 rows (circa)
DELETE FROM `xaction`;
/*!40000 ALTER TABLE `xaction` DISABLE KEYS */;
INSERT INTO `xaction` (`id`, `Tipo`) VALUES
	(1, 'post');
/*!40000 ALTER TABLE `xaction` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
