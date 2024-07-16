-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               8.0.37 - MySQL Community Server - GPL
-- Операционная система:         Win64
-- HeidiSQL Версия:              12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Дамп структуры базы данных test
CREATE DATABASE IF NOT EXISTS `test` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `test`;

-- Дамп структуры для таблица test.person
CREATE TABLE IF NOT EXISTS `person` (
  `idperson` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `sex` enum('MALE','FEMALE') DEFAULT NULL,
  PRIMARY KEY (`idperson`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Дамп данных таблицы test.person: ~2 rows (приблизительно)
INSERT INTO `person` (`idperson`, `name`, `surname`, `birthday`, `sex`) VALUES
	(119, 'dastan', 'makkambaev', '2024-07-11', 'MALE'),
	(120, 'userName', 'userName', '2012-10-18', 'MALE');

-- Дамп структуры для таблица test.privilege
CREATE TABLE IF NOT EXISTS `privilege` (
  `idprivilege` int NOT NULL AUTO_INCREMENT,
  `idrole` int DEFAULT NULL,
  `operation` enum('CREATE','READ','UPDATE','DELETE') DEFAULT NULL,
  `entity` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idprivilege`),
  KEY `idrole_idx` (`idrole`),
  CONSTRAINT `idrole` FOREIGN KEY (`idrole`) REFERENCES `role` (`idrole`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Дамп данных таблицы test.privilege: ~0 rows (приблизительно)

-- Дамп структуры для таблица test.role
CREATE TABLE IF NOT EXISTS `role` (
  `idrole` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idrole`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Дамп данных таблицы test.role: ~3 rows (приблизительно)
INSERT INTO `role` (`idrole`, `name`) VALUES
	(2, 'ADMIN'),
	(1, 'SUPERADMIN'),
	(3, 'USER');

-- Дамп структуры для таблица test.user
CREATE TABLE IF NOT EXISTS `user` (
  `iduser` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(512) NOT NULL,
  `idperson` int DEFAULT NULL,
  PRIMARY KEY (`iduser`),
  UNIQUE KEY `usercol_UNIQUE` (`username`),
  KEY `idperson_idx` (`idperson`),
  CONSTRAINT `idperson` FOREIGN KEY (`idperson`) REFERENCES `person` (`idperson`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Дамп данных таблицы test.user: ~2 rows (приблизительно)
INSERT INTO `user` (`iduser`, `username`, `password`, `idperson`) VALUES
	(125, 'admin', '21232f297a57a5a743894a0e4a801fc3', 119),
	(126, 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 120);

-- Дамп структуры для таблица test.user_role
CREATE TABLE IF NOT EXISTS `user_role` (
  `iduser_role` int NOT NULL AUTO_INCREMENT,
  `user` int DEFAULT NULL,
  `role` int DEFAULT NULL,
  PRIMARY KEY (`iduser_role`),
  KEY `user_idx` (`user`),
  KEY `role_idx` (`role`),
  CONSTRAINT `role` FOREIGN KEY (`role`) REFERENCES `role` (`idrole`),
  CONSTRAINT `user` FOREIGN KEY (`user`) REFERENCES `user` (`iduser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Дамп данных таблицы test.user_role: ~0 rows (приблизительно)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
