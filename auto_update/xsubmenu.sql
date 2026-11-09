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

-- Dump della struttura di tabella auto_update.xsubmenu
CREATE TABLE IF NOT EXISTS `xsubmenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voce` varchar(200) NOT NULL DEFAULT '0',
  `azione` varchar(200) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  `url` varchar(5000) NOT NULL DEFAULT '0',
  `id_menu` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- Dump dei dati della tabella auto_update.xsubmenu: ~14 rows (circa)
DELETE FROM `xsubmenu`;
/*!40000 ALTER TABLE `xsubmenu` DISABLE KEYS */;
INSERT INTO `xsubmenu` (`id`, `voce`, `azione`, `level`, `url`, `id_menu`) VALUES
	(1, 'aziende', '', 1, '/tblbrand', 1),
	(2, 'Gruppi', '', 1, '/tblgroup', 1),
	(3, 'Negozi', '', 1, '/tblshop', 1),
	(4, 'lista', '1', 1, '/rest', 2),
	(5, 'metodi', '0', 1, '/rest/getactions?type=j', 2),
	(6, 'menu', '0', 100, '/xmenu', 3),
	(7, 'submenu', '0', 100, '/xsubmenu', 3),
	(8, 'azioni', '0', 100, '/xaction', 3),
	(9, 'utenti', '0', 100, '/user', 3),
	(10, 'relazioni utente form azioni', '0', 100, '/relusrformaction', 3),
	(11, 'test2222', 'url', 100, '/tblshop', 2),
	(12, 'moduli_aziende', '0', 1, '/autoupdate/tblbrand/index', 4),
	(13, 'moduli_gruppi', '0', 1, '/autoupdate/tblgroup/index', 4),
	(14, 'moduli_negozi', '0', 1, '/autoupdate/tblshop/index', 4);
/*!40000 ALTER TABLE `xsubmenu` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
