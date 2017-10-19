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
-- Table structure for table `rank_population`
--

CREATE TABLE IF NOT EXISTS `rank_population` (
  `sa` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
  `pop` decimal(32,0) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rank_population`
--

INSERT INTO `rank_population` (`sa`, `pop`) VALUES
('SU29', '207664'),
('EN13', '177435'),
('SW24', '170836'),
('SV27', '144713'),
('RB23', '143257'),
('CC12', '142727'),
('WC30', '113885'),
('CH37', '112226'),
('WH32', '95930'),
('LV17', '65660'),
('SM28', '58362'),
('WV31', '23388'),
('MQ19', '22014'),
('MV21', '9477'),
('LA18', '7748'),
('MC22', '5009'),
('SE26', '3790'),
('ME36', '3412'),
('BK11', '1582'),
('BD10', '383'),
('MT20', '264');
