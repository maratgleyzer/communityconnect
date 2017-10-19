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
-- Table structure for table `serviceareas`
--

CREATE TABLE IF NOT EXISTS `serviceareas` (
  `sa` varchar(5) NOT NULL,
  `serviceArea` varchar(100) NOT NULL,
  PRIMARY KEY (`sa`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `serviceareas`
--

INSERT INTO `serviceareas` (`sa`, `serviceArea`) VALUES
('BD10', 'Blue Diamond Library'),
('BK11', 'Bunkerville Library'),
('CC12', 'Clark County Library'),
('EN13', 'Enterprise Library'),
('GS14', 'Goodsprings Library'),
('IS16', 'Indian Spring Library'),
('LV17', 'Las Vegas Library'),
('LA18', 'Laughlin Library'),
('MQ19', 'Mesquite Library'),
('MT20', 'Moapa Town Library'),
('MV21', 'Moapa Valley'),
('MC22', 'Mount Charleston Library'),
('RB23', 'Rainbow Library'),
('SW24', 'Sahara West Library'),
('SV25', 'Sandy Valley Library'),
('SE26', 'Searchlight Library'),
('SV27', 'Spring Valley Library'),
('SM28', 'Summerlin Library'),
('SU29', 'Sunrise Library'),
('WC30', 'West Charleston Library'),
('WV31', 'West Las Vegas Library'),
('WH32', 'Whitney Library'),
('ME36', 'Meadows Library'),
('CH37', 'Centennial Hills Library');
