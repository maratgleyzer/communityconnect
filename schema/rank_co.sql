-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 05, 2010 at 03:39 AM
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
-- Table structure for table `rank_co`
--

CREATE TABLE IF NOT EXISTS `rank_co` (
  `sa` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
  `checkouts` bigint(21) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rank_co`
--

INSERT INTO `rank_co` (`sa`, `checkouts`) VALUES
('SW24', 191857),
('RB23', 167349),
('SV27', 152164),
('CH37', 145816),
('SU29', 145378),
('EN13', 128270),
('CC12', 121883),
('WC30', 113425),
('SM28', 95147),
('WH32', 91729),
('LV17', 49679),
('MQ19', 23510),
('WV31', 18420),
('LA18', 16322),
('MV21', 14175),
('ME36', 5541),
('MC22', 661),
('SE26', 483),
('BD10', 230),
('BK11', 102),
('MT20', 14);
