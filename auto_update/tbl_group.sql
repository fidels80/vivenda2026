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

-- Dump della struttura di tabella auto_update.tbl_group
CREATE TABLE IF NOT EXISTS `tbl_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `desk` varchar(200) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `grp_path` varchar(500) DEFAULT NULL,
  `flag` bit(1) DEFAULT NULL,
  `lista` text,
  `lista2` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

-- Dump dei dati della tabella auto_update.tbl_group: ~17 rows (circa)
DELETE FROM `tbl_group`;
/*!40000 ALTER TABLE `tbl_group` DISABLE KEYS */;
INSERT INTO `tbl_group` (`id`, `code`, `desk`, `brand_id`, `grp_path`, `flag`, `lista`, `lista2`) VALUES
	(6, 'provarel', 'provarel', 5, '', b'0', NULL, NULL),
	(8, 'test_1', 'test gruppo', 6, 'http://www.anpira.it:8077/basic/update/sd/std/client/', b'0', NULL, NULL),
	(9, 'Alpha', 'Gruppo Alpha Subdued', 6, 'http://www.anpira.it:8077/basic/update/sd/alpha2/client/', b'1', NULL, NULL),
	(10, 'Beta', 'Gruppo Beta  Subdued ', 6, 'http://www.anpira.it:8077/basic/update/sd/beta/client/', b'0', NULL, NULL),
	(11, 'Gamma', 'Gruppo Gamma Subdued', 6, 'http://www.anpira.it:8077/basic/update/sd/gamma/client/', b'0', NULL, NULL),
	(12, 'EASY', 'gruppo easy update subdued', 6, 'http://www.anpira.it:8077/basic/update/sd/easy/client/', b'1', NULL, NULL),
	(13, 'ZETA', 'Gruppo per smistare e disattivare gli aggiornamenti dei singoli negozi', 6, 'http://www.anpira.it:8077/basic/update/sd/zeta/client/', b'0', NULL, NULL),
	(15, 'EDAS', 'EDAS negozi', 4, 'http://www.anpira.it:8077/basic/update/sd/alpha2/client/', b'1', NULL, NULL),
	(18, 'SPAGNA', 'GRUPPO NEGOZI SPAGNA SUBDUED', 6, 'http://www.anpira.it:8077/basic/update/sd/alpha2/client/', b'1', NULL, NULL),
	(19, 'DENOIA', 'Negozi Tiny Island-GoodHarbour', 3, 'http://www.anpira.it:8077/basic/update/sd/alpha2/client/', b'0', NULL, NULL),
	(20, 'GERMANIA', 'GRUPPO NEGOZI GERMANIA SUBDUED', 6, 'http://www.anpira.it:8077/basic/update/sd/eu2021/client/', b'0', NULL, NULL),
	(21, 'BELGIO', 'GRUPPO NEGOZI BELGIO SUBDUED', 6, 'http://www.anpira.it:8077/basic/update/sd/eu2021/client/', b'0', NULL, NULL),
	(22, 'PAESIBASSI', 'GRUPPO NEGOZI PAESI BASSI SUBDUED', 6, 'http://www.anpira.it:8077/basic/update/sd/eu2021/client/', b'0', NULL, NULL),
	(23, 'FRANCIA', 'GRUPPO NEGOZI FRANCIA SUBDUED', 6, '', b'0', NULL, NULL),
	(24, 'SVIZZERA', 'GRUPPO NEGOZI SVIZZERA SUBDUED', 6, '', b'0', NULL, NULL),
	(25, 'ENGLAND', 'GRUPPO NEGOZI INGHILTERRA SUBDUED', 6, '', b'0', NULL, NULL),
	(26, 'AUSTRIA', 'GRUPPO NEGOZI AUSTRIA SUBDUED', 6, '', b'0', NULL, NULL);
/*!40000 ALTER TABLE `tbl_group` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
