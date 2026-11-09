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

-- Dump della struttura di tabella auto_update.rel_usr_form_action
CREATE TABLE IF NOT EXISTS `rel_usr_form_action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT '0',
  `form` varchar(255) NOT NULL DEFAULT '0',
  `read` bit(1) NOT NULL DEFAULT b'0',
  `write` bit(1) NOT NULL DEFAULT b'0',
  `delete` bit(1) NOT NULL DEFAULT b'0',
  `access` bit(1) NOT NULL DEFAULT b'0',
  `azione` varchar(250) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dump dei dati della tabella auto_update.rel_usr_form_action: ~5 rows (circa)
DELETE FROM `rel_usr_form_action`;
/*!40000 ALTER TABLE `rel_usr_form_action` DISABLE KEYS */;
INSERT INTO `rel_usr_form_action` (`id`, `id_user`, `form`, `read`, `write`, `delete`, `access`, `azione`, `level`) VALUES
	(1, 2, 'RlsBrdShp', b'0', b'0', b'0', b'0', 'Create', NULL),
	(2, NULL, 'Tblgroup', b'0', b'0', b'0', b'0', 'Index', 15),
	(3, NULL, 'Tblgroup', b'0', b'0', b'0', b'0', 'Update', 70),
	(4, NULL, 'Tblshop', b'0', b'0', b'0', b'0', 'Test', 25),
	(5, 2, 'Tblshop', b'0', b'0', b'0', b'0', 'Create', NULL);
/*!40000 ALTER TABLE `rel_usr_form_action` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
