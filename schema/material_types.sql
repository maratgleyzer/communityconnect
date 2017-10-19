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
-- Table structure for table `material_types`
--

CREATE TABLE IF NOT EXISTS `material_types` (
  `material_types` varchar(3) NOT NULL,
  `description` varchar(120) NOT NULL,
  PRIMARY KEY (`material_types`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `material_types`
--

INSERT INTO `material_types` (`material_types`, `description`) VALUES
('a', 'books'),
('c', 'music scores'),
('e', 'maps'),
('g', 'DVDs'),
('i', 'Audiobooks on CD'),
('j', 'Music CDs'),
('m', 'CDROM'),
('o', 'Kit'),
('l', 'large print'),
('1', 'Playaways'),
('s', 'Audiobook on cassette'),
('v', 'VHS');
