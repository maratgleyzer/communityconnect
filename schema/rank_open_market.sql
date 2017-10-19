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
-- Table structure for table `rank_open_market`
--

CREATE TABLE IF NOT EXISTS `rank_open_market` (
  `sa` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
  `open_market` decimal(36,4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rank_open_market`
--

INSERT INTO `rank_open_market` (`sa`, `open_market`) VALUES
('MT20', '25.0000'),
('BD10', '5.8824'),
('BK11', '2.3810'),
('MC22', '1.4423'),
('SE26', '0.7752'),
('ME36', '0.2134'),
('LV17', '0.2055'),
('WC30', '0.1987'),
('CC12', '0.1753'),
('MV21', '0.1736'),
('WV31', '0.1636'),
('SU29', '0.1529'),
('RB23', '0.1481'),
('MQ19', '0.1451'),
('SM28', '0.1409'),
('WH32', '0.1098'),
('SV27', '0.0910'),
('SW24', '0.0898'),
('LA18', '0.0795'),
('EN13', '0.0615'),
('CH37', '0.0553');
