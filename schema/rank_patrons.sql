-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 05, 2010 at 03:40 AM
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
-- Table structure for table `rank_patrons`
--

CREATE TABLE IF NOT EXISTS `rank_patrons` (
  `sa` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
  `v` bigint(21) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rank_patrons`
--

INSERT INTO `rank_patrons` (`sa`, `v`) VALUES
('SU29', 61465),
('SW24', 61281),
('RB23', 57401),
('SV27', 49459),
('EN13', 47150),
('CC12', 46196),
('WC30', 40763),
('CH37', 39805),
('WH32', 36441),
('SM28', 26254),
('LV17', 18493),
('WV31', 9780),
('MQ19', 6203),
('LA18', 5031),
('MV21', 2304),
('ME36', 937),
('MC22', 208),
('SE26', 129),
('BK11', 42),
('BD10', 17),
('MT20', 4);
