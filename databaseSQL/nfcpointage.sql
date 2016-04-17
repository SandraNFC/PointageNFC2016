-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Dim 17 Avril 2016 à 22:12
-- Version du serveur: 5.6.11-log
-- Version de PHP: 5.4.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `nfcpointage`
--

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

CREATE TABLE IF NOT EXISTS `cours` (
  `IDCOURS` int(11) NOT NULL AUTO_INCREMENT,
  `IDPROMOTION` int(11) DEFAULT NULL,
  `LIBELLE` varchar(50) NOT NULL,
  PRIMARY KEY (`IDCOURS`),
  KEY `FK_COURS_PROMOTION` (`IDPROMOTION`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `cours`
--

INSERT INTO `cours` (`IDCOURS`, `IDPROMOTION`, `LIBELLE`) VALUES
(1, 1, 'Android NFC'),
(2, 1, 'Conception avancée'),
(3, 1, 'JavaEE'),
(4, 2, 'Javascript Server Side'),
(5, 2, 'Oracle (Tuning - Sql3 - DB2)');

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE IF NOT EXISTS `etudiant` (
  `IDETUDIANT` int(11) NOT NULL AUTO_INCREMENT,
  `IDPROMOTION` int(11) DEFAULT NULL,
  `NOM` varchar(50) NOT NULL,
  `PRENOM` varchar(50) NOT NULL,
  `PSEUDO` varchar(50) NOT NULL,
  `MOTDEPASSE` text,
  PRIMARY KEY (`IDETUDIANT`),
  KEY `FK_PROMOTION_ETUDIANT` (`IDPROMOTION`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `etudiant`
--

INSERT INTO `etudiant` (`IDETUDIANT`, `IDPROMOTION`, `NOM`, `PRENOM`, `PSEUDO`, `MOTDEPASSE`) VALUES
(1, 1, 'Andriambelosoa', 'Tiana', 'tiana', 'tiana'),
(2, 1, 'Rakotonandrasana', 'Ravaka', 'ravaka', 'ravaka'),
(3, 1, 'Randrianavalona', 'Setra', 'setra', 'setra'),
(4, 2, 'Ramanantoanina', 'Sitraka', 'sitraka', 'sitraka'),
(5, 2, 'Ravelosoa', 'Soa', 'soa', 'soa'),
(6, 1, 'Razafiarison', 'Ny Aina', 'aina', 'aina'),
(7, 1, 'Razafinarivo', 'Mampionona', 'mampionona', 'mampionona');

-- --------------------------------------------------------

--
-- Structure de la table `pointage`
--

CREATE TABLE IF NOT EXISTS `pointage` (
  `IDPOINTAGE` int(11) NOT NULL AUTO_INCREMENT,
  `IDETUDIANT` int(11) DEFAULT NULL,
  `IDSC` int(11) DEFAULT NULL,
  `HEUREENTREEETUDIANT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`IDPOINTAGE`),
  KEY `FK_POINTAGE_ETUDIANT` (`IDETUDIANT`),
  KEY `FK_POINTAGE_SALLECOURS` (`IDSC`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

-- --------------------------------------------------------

--
-- Structure de la table `promotion`
--

CREATE TABLE IF NOT EXISTS `promotion` (
  `IDPROMOTION` int(11) NOT NULL AUTO_INCREMENT,
  `NOMPROMOTION` varchar(50) NOT NULL,
  PRIMARY KEY (`IDPROMOTION`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `promotion`
--

INSERT INTO `promotion` (`IDPROMOTION`, `NOMPROMOTION`) VALUES
(1, 'promotion 1'),
(2, 'promotion 2');

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

CREATE TABLE IF NOT EXISTS `salle` (
  `IDSALLE` int(11) NOT NULL AUTO_INCREMENT,
  `NUMSALLE` varchar(10) NOT NULL,
  `UID_TAG` varchar(50) NOT NULL,
  PRIMARY KEY (`IDSALLE`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `salle`
--

INSERT INTO `salle` (`IDSALLE`, `NUMSALLE`, `UID_TAG`) VALUES
(1, 'salle 1', 'tag 1'),
(2, 'salle 2', 'tag 2');

-- --------------------------------------------------------

--
-- Structure de la table `salle_cours`
--

CREATE TABLE IF NOT EXISTS `salle_cours` (
  `IDCOURS` int(11) NOT NULL,
  `IDSALLE` int(11) NOT NULL,
  `IDSC` int(11) NOT NULL AUTO_INCREMENT,
  `HEUREENTREE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `HEURESORTIE` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`IDSC`),
  KEY `FK_SALLE_COURS` (`IDCOURS`),
  KEY `FK_SALLE_COURS2` (`IDSALLE`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `salle_cours`
--

INSERT INTO `salle_cours` (`IDCOURS`, `IDSALLE`, `IDSC`, `HEUREENTREE`, `HEURESORTIE`) VALUES
(1, 1, 1, '2016-04-17 17:00:00', '2016-04-17 22:00:00'),
(1, 2, 2, '2016-04-18 04:00:00', '2016-04-18 08:00:00'),
(2, 1, 3, '2016-04-18 11:00:00', '2016-04-18 14:00:00'),
(3, 2, 4, '2016-04-19 11:00:00', '2016-04-19 14:00:00'),
(1, 1, 5, '2016-04-20 05:00:00', '2016-04-20 09:00:00'),
(1, 1, 6, '2016-04-20 14:00:00', '2016-04-20 16:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `IDUTILISATEUR` int(11) NOT NULL AUTO_INCREMENT,
  `NOMUTILISATEUR` varchar(50) NOT NULL,
  `LOGINUTILISATEUR` varchar(50) NOT NULL,
  `MOTDEPASSEUTILISATEUR` text NOT NULL,
  PRIMARY KEY (`IDUTILISATEUR`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`IDUTILISATEUR`, `NOMUTILISATEUR`, `LOGINUTILISATEUR`, `MOTDEPASSEUTILISATEUR`) VALUES
(3, 'Razafindrakoto Lita', 'admin1', 'litaadmin'),
(4, 'Rabary Vero', 'admin2', 'veroadmin');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `viewcourspromo`
--
CREATE TABLE IF NOT EXISTS `viewcourspromo` (
`IDCOURS` int(11)
,`COURS` varchar(50)
,`IDPROMOTION` int(11)
,`PROMOTION` varchar(50)
);
-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `viewetupromo`
--
CREATE TABLE IF NOT EXISTS `viewetupromo` (
`IDETUDIANT` int(11)
,`NOM` varchar(50)
,`PRENOM` varchar(50)
,`PSEUDO` varchar(50)
,`IDPROMOTION` int(11)
,`PROMOTION` varchar(50)
);
-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `viewpointage`
--
CREATE TABLE IF NOT EXISTS `viewpointage` (
`IDPOINTAGE` int(11)
,`IDETUDIANT` int(11)
,`NOM` varchar(50)
,`PRENOM` varchar(50)
,`PSEUDO` varchar(50)
,`IDPROMOTION` int(11)
,`PROMOTION` varchar(50)
,`IDSC` int(11)
,`IDCOURS` int(11)
,`COURS` varchar(50)
,`IDSALLE` int(11)
,`NUMSALLE` varchar(10)
,`HEUREENTREE` timestamp
,`HEURESORTIE` timestamp
,`HEUREENTREEETUDIANT` timestamp
);
-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `viewsallecours`
--
CREATE TABLE IF NOT EXISTS `viewsallecours` (
`IDSC` int(11)
,`IDCOURS` int(11)
,`COURS` varchar(50)
,`IDPROMOTION` int(11)
,`PROMOTION` varchar(50)
,`IDSALLE` int(11)
,`NUMSALLE` varchar(10)
,`HEUREENTREE` timestamp
,`HEURESORTIE` timestamp
);
-- --------------------------------------------------------

--
-- Structure de la vue `viewcourspromo`
--
DROP TABLE IF EXISTS `viewcourspromo`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewcourspromo` AS select `c`.`IDCOURS` AS `IDCOURS`,`c`.`LIBELLE` AS `COURS`,`pmt`.`IDPROMOTION` AS `IDPROMOTION`,`pmt`.`NOMPROMOTION` AS `PROMOTION` from (`cours` `c` join `promotion` `pmt`) where (`c`.`IDPROMOTION` = `pmt`.`IDPROMOTION`);

-- --------------------------------------------------------

--
-- Structure de la vue `viewetupromo`
--
DROP TABLE IF EXISTS `viewetupromo`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewetupromo` AS select `e`.`IDETUDIANT` AS `IDETUDIANT`,`e`.`NOM` AS `NOM`,`e`.`PRENOM` AS `PRENOM`,`e`.`PSEUDO` AS `PSEUDO`,`pmt`.`IDPROMOTION` AS `IDPROMOTION`,`pmt`.`NOMPROMOTION` AS `PROMOTION` from (`etudiant` `e` join `promotion` `pmt`) where (`e`.`IDPROMOTION` = `pmt`.`IDPROMOTION`);

-- --------------------------------------------------------

--
-- Structure de la vue `viewpointage`
--
DROP TABLE IF EXISTS `viewpointage`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewpointage` AS select `p`.`IDPOINTAGE` AS `IDPOINTAGE`,`p`.`IDETUDIANT` AS `IDETUDIANT`,`ve`.`NOM` AS `NOM`,`ve`.`PRENOM` AS `PRENOM`,`ve`.`PSEUDO` AS `PSEUDO`,`ve`.`IDPROMOTION` AS `IDPROMOTION`,`ve`.`PROMOTION` AS `PROMOTION`,`p`.`IDSC` AS `IDSC`,`vsc`.`IDCOURS` AS `IDCOURS`,`vsc`.`COURS` AS `COURS`,`vsc`.`IDSALLE` AS `IDSALLE`,`vsc`.`NUMSALLE` AS `NUMSALLE`,`vsc`.`HEUREENTREE` AS `HEUREENTREE`,`vsc`.`HEURESORTIE` AS `HEURESORTIE`,`p`.`HEUREENTREEETUDIANT` AS `HEUREENTREEETUDIANT` from ((`pointage` `p` join `viewetupromo` `ve`) join `viewsallecours` `vsc`) where ((`p`.`IDETUDIANT` = `ve`.`IDETUDIANT`) and (`p`.`IDSC` = `vsc`.`IDSC`));

-- --------------------------------------------------------

--
-- Structure de la vue `viewsallecours`
--
DROP TABLE IF EXISTS `viewsallecours`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewsallecours` AS select `sc`.`IDSC` AS `IDSC`,`c`.`IDCOURS` AS `IDCOURS`,`c`.`LIBELLE` AS `COURS`,`p`.`IDPROMOTION` AS `IDPROMOTION`,`p`.`NOMPROMOTION` AS `PROMOTION`,`s`.`IDSALLE` AS `IDSALLE`,`s`.`NUMSALLE` AS `NUMSALLE`,`sc`.`HEUREENTREE` AS `HEUREENTREE`,`sc`.`HEURESORTIE` AS `HEURESORTIE` from (((`salle_cours` `sc` join `cours` `c`) join `salle` `s`) join `promotion` `p`) where ((`sc`.`IDCOURS` = `c`.`IDCOURS`) and (`sc`.`IDSALLE` = `s`.`IDSALLE`) and (`p`.`IDPROMOTION` = `c`.`IDPROMOTION`));

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `cours`
--
ALTER TABLE `cours`
  ADD CONSTRAINT `FK_COURS_PROMOTION` FOREIGN KEY (`IDPROMOTION`) REFERENCES `promotion` (`IDPROMOTION`);

--
-- Contraintes pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD CONSTRAINT `FK_PROMOTION_ETUDIANT` FOREIGN KEY (`IDPROMOTION`) REFERENCES `promotion` (`IDPROMOTION`);

--
-- Contraintes pour la table `pointage`
--
ALTER TABLE `pointage`
  ADD CONSTRAINT `FK_POINTAGE_ETUDIANT` FOREIGN KEY (`IDETUDIANT`) REFERENCES `etudiant` (`IDETUDIANT`),
  ADD CONSTRAINT `FK_POINTAGE_SALLECOURS` FOREIGN KEY (`IDSC`) REFERENCES `salle_cours` (`IDSC`);

--
-- Contraintes pour la table `salle_cours`
--
ALTER TABLE `salle_cours`
  ADD CONSTRAINT `FK_SALLE_COURS` FOREIGN KEY (`IDCOURS`) REFERENCES `cours` (`IDCOURS`),
  ADD CONSTRAINT `FK_SALLE_COURS2` FOREIGN KEY (`IDSALLE`) REFERENCES `salle` (`IDSALLE`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
