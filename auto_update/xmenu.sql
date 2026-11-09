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

-- Dump della struttura di tabella auto_update.xmenu
CREATE TABLE IF NOT EXISTS `xmenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voce` varchar(200) NOT NULL DEFAULT '0',
  `azione` varchar(200) DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  `url` varchar(250) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dump dei dati della tabella auto_update.xmenu: ~4 rows (circa)
DELETE FROM `xmenu`;
/*!40000 ALTER TABLE `xmenu` DISABLE KEYS */;
INSERT INTO `xmenu` (`id`, `voce`, `azione`, `level`, `url`) VALUES
	(1, '(USA MODULI)Aggiornamenti', '1', 5, '0'),
	(2, 'rest', '1', 1, ''),
	(3, 'Controllo', '1', 100, '0'),
	(4, 'Moduli', '1', 5, '0');
/*!40000 ALTER TABLE `xmenu` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
