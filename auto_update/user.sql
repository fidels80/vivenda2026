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

-- Dump della struttura di tabella auto_update.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(10) NOT NULL DEFAULT '',
  `auth_key` varchar(32) NOT NULL DEFAULT '',
  `password_hash` varchar(250) NOT NULL DEFAULT '',
  `password_reset_token` varchar(250) NOT NULL DEFAULT '',
  `email` varchar(250) NOT NULL DEFAULT '',
  `status` varchar(250) NOT NULL DEFAULT '',
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  `level` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dump dei dati della tabella auto_update.user: ~4 rows (circa)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `level`) VALUES
	(1, 'admin', 'kb2IauUg-w3G8tFn14cXMJWAyKxuFJ8V', '$2y$13$plE1acGR1qhi3UTtrbxBye33NOV4YK2dHSgzlFNFy1X3MGTWfAFKi', '', 'm.cardinale@tecneo.it', '10', 1603269737, 1603269737, 100),
	(2, 'a.piras', 'MA3clSJc-l9Y5HH9mpmbOthOFWUKkbr6', '$2y$13$gwF/87IGnDIk7WC5nxBt3uFJaBIN6wstAIr8tH/1BuHADP87X.XbG', '', 'a.piras@tecneo.it', '10', 1603273885, 1603273885, 100),
	(3, 'marconicol', 'CDQY1fiWJYWt-IKbnClQARRZPVj1PagQ', '$2y$13$M00RxCozIh/vKMxdQj74Jux5bGTNUgCnlVkII7tP5pDdX/DWfHHnG', '', 'm.nicolanti@tecneo.it', '10', 1603795312, 1603795312, 100),
	(4, 'testpermer', 'JLa1wTHs67VaPckqInP33qj2WQOGwRmb', '$2y$13$x3EOGpZCMsxXHwzNigkTwe1eMi.aSfrdeD7iZqiFLigujcv6WlFbK', '', 'cardinale.marco@gmail.com', '10', 1605602133, 1605602133, 70);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
