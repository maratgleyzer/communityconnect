-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 05, 2010 at 03:41 AM
-- Server version: 5.1.41
-- PHP Version: 5.3.2-1ubuntu4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `civic`
--

-- --------------------------------------------------------


--



--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `validation` varchar(25) NOT NULL,
  `temppass` varchar(25) DEFAULT '',
  `valid` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `validation`, `temppass`, `valid`) VALUES
(1, 'w@g.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', '', '', 0),
(2, 'marc', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', '', 0),
(13, 'wooleys@gmail.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', '6ew8vsyhpw', 'n8tba63f0t', 0),
(9, 'info@gartrellgroup.com', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'u35usxdbnq', '', 0),
(14, 'root@m.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', '3rnqeqz0xq', '', 0),
(15, 'root1@m.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', 'jpkyabnmra', '', 0),
(16, 'root@ms.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', 'ty68p78esf', '', 0),
(17, 'bryce@gartrellgroup.com', '5e86e8cdc7188d53916fcd1d7294cee4611c7c49', 'fqpxo27drg', '', 0),
(18, 'roots@mail.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', 'wncggd8m64', '', 0),
(19, 'bryce@ggroup.com', '1ff2b3704aede04eecb51e50ca698efd50a1379b', 'yh0powctbk', '', 0),
(20, 'maf@civictechnologies.com', '865fed3e783400fcd0b78818afd0cf4ca5755a6a', 'm085sczhxn', '', 0),
(21, 'civictechnologies@gmail.com', 'd33c80bc45d65303e33ca83108a9952b745af9ef', 'ydr4asbftp', '', 0),
(22, 'z45wang@comcast.net', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '78eu0t74it', '', 0),
(23, 'z46wang@comcast.net', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'ittaitktne', '', 0),
(24, 'z43wang@comcast.net', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'rrojwi2s5n', '', 0),
(25, 'z44wang@comcast.net', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'mc8hi238mn', '', 0),
(26, 'z41wang@comcast.net', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'fueg2nakzz', '', 0),
(27, 'z42wang@comcast.net', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'p525afymog', '', 0),
(28, 'z42wang@hotmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'wxepxryacd', '', 0),
(29, 'z4wang@hotmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'r2vqsdqbmc', '', 0),
(30, 'z5wang@comcast.net', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'qxf2cf2fp7', '', 0),
(31, 'support@gartrellgroup.com', '9155ef5fde64a89f06048015eb7c1b09f8db67ed', 'z5q8vperia', '', 0),
(32, 'shawsupport@gartrellgroup.com', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'afq4c0ec3w', '', 0),
(33, 'klickitatsupport@gartrellgroup.com', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'vzw48c2vex', '', 0);
