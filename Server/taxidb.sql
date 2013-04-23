-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2013 at 01:49 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `taxidb`
--

-- --------------------------------------------------------

--
-- Table structure for table `comenzi_sursa`
--

CREATE TABLE IF NOT EXISTS `comenzi_sursa` (
  `id_comanda` int(11) NOT NULL AUTO_INCREMENT,
  `latS` varchar(20) NOT NULL,
  `lngS` varchar(20) NOT NULL,
  `latD` varchar(20) NOT NULL,
  `lngD` varchar(20) NOT NULL,
  `DistS` varchar(20) NOT NULL,
  `DistD` varchar(20) NOT NULL,
  `id_masina` int(11) DEFAULT NULL,
  `done` int(11) NOT NULL,
  PRIMARY KEY (`id_comanda`),
  KEY `id_masina` (`id_masina`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `comenzi_sursa`
--

INSERT INTO `comenzi_sursa` (`id_comanda`, `latS`, `lngS`, `latD`, `lngD`, `DistS`, `DistD`, `id_masina`, `done`) VALUES
(1, '45.75332159318824', '21.224007606506348', '45.753561145759214', '21.223535537719727', '0.6049502215357', '0.045300614134397', 3, 1),
(2, '45.75339113741727', '21.213397979736328', '45.75740350234746', '21.210737228393555', '1.428231570369', '0.49173546127218', 4, 1),
(3, '45.74722231226201', '21.231250762939453', '45.760697019140615', '21.242237091064453', '0.45309626947948', '1.7242928733726', 2, 1),
(4, '45.75788257141754', '21.223783493041992', '45.75919999015249', '21.23459815979004', '1.981223250837', '0.85192322237569', 1, 1),
(5, '45.737218981809136', '21.2435245513916', '45.74081319904686', '21.27176284790039', '1.9883390013389', '2.2282363134208', 1, 1),
(6, '45.749647999606765', '21.236969232559204', '45.75351091368203', '21.23984456062317', '0.55641744559543', '0.4841531169608', 2, 1),
(7, '45.74923623912159', '21.236658096313477', '45.75361571770282', '21.239898204803467', '0.57287485493041', '0.54819261522175', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `maps`
--

CREATE TABLE IF NOT EXISTS `maps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nr_masina` varchar(15) NOT NULL,
  `lat` varchar(20) DEFAULT NULL,
  `lng` varchar(20) DEFAULT NULL,
  `busy` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Nr_masina` (`Nr_masina`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `maps`
--

INSERT INTO `maps` (`id`, `Nr_masina`, `lat`, `lng`, `busy`) VALUES
(1, 'AR 67 BUY', '45.74464464', '21.240863800048828', '1'),
(2, 'B 666 NEO', '45.7538328111198', '21.240209341049194', '0'),
(3, 'B 107 POP', '45.75339645347717', '21.2282133102417', '1'),
(4, 'BH 77 LEO', '45.753111983845194', '21.231796741485596', '0'),
(5, 'TM 23 ADI', '45.74125280184582', '21.22572422027588', '1'),
(6, 'TM 20 ANA', '45.73493286537856', '21.22666835784912', '1'),
(7, 'TM 90 TDI', '45.74790144145938', '21.225509643554688', '1');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comenzi_sursa`
--
ALTER TABLE `comenzi_sursa`
  ADD CONSTRAINT `comenzi_sursa_ibfk_1` FOREIGN KEY (`id_masina`) REFERENCES `maps` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
