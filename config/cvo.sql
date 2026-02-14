--
-- MySQL 5.6.17
-- Thu, 07 Jun 2018 18:16:12 +0000
--

DROP DATABASE IF EXISTS `cvo`;

CREATE DATABASE `cvo` DEFAULT CHARSET latin1;

USE `cvo`;

DROP TABLE IF EXISTS `documenti`;

CREATE TABLE `documenti` (
   `nome` varchar(255) not null,
   `descrizione` varchar(255) not null,
   `indirizzo` varchar(255) not null,
   PRIMARY KEY (`indirizzo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `documenti` (`nome`, `descrizione`, `indirizzo`) VALUES ('myCV', 'Example CV', 'assets\\cvs\\myCV.pdf');
INSERT INTO `documenti` (`nome`, `descrizione`, `indirizzo`) VALUES ('myCV1', 'Example CV', 'assets\\cvs\\myCV1.pdf');

SELECT * FROM `documenti`;

DROP TABLE IF EXISTS `utenti`;

CREATE TABLE `utenti` (
   `nome` varchar(255) not null,
   `cognome` varchar(255) not null,
   `indirizzoEmail` varchar(255) not null,
   `indirizzoTelefonico` varchar(255),
   `password` char(6) not null,
   PRIMARY KEY (`password`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

SELECT * FROM `utenti`;