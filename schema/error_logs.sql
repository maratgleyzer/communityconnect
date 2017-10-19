-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 05, 2010 at 03:38 AM
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
-- Table structure for table `error_logs`
--

CREATE TABLE IF NOT EXISTS `error_logs` (
  `error_log_id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(64) DEFAULT NULL,
  `error_msg` longtext,
  `opt_param1` varchar(64) DEFAULT NULL,
  `log_time` datetime DEFAULT NULL,
  PRIMARY KEY (`error_log_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `error_logs`
--

INSERT INTO `error_logs` (`error_log_id`, `page`, `error_msg`, `opt_param1`, `log_time`) VALUES
(1, 'Create Account', 'insert into users (email,password,validationx) values (''z5wang@comcast.net'',''5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8'',''zjbsr5yney'')', 'z5wang@comcast.net', '2010-10-01 17:39:19'),
(2, 'Create Account', 'insert into users (email,password,validation) values (''z4wang@comcast.net'',''5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8'',''ittaitktne'')', 'z4wang@comcast.net', '2010-10-01 17:58:48'),
(3, 'Create Account', 'insert into users (email,password,validation) values (''z4wang@comcast.net'',''5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8'',''rrojwi2s5n'')', 'z4wang@comcast.net', '2010-10-01 18:53:30'),
(4, 'Create Account', 'insert into users (email,password,validation) values (''z5wang@comcast.net'',''5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8'',''mc8hi238mn'')', 'z5wang@comcast.net', '2010-10-01 19:08:54'),
(5, 'Create Account', 'insert into users (email,password,validation) values (''z4wang@comcast.net'',''5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8'',''fueg2nakzz'')', 'z4wang@comcast.net', '2010-10-01 20:53:40'),
(6, 'Create Account', 'insert into users (email,password,validation) values (''z5wang@comcast.net'',''5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8'',''p525afymog'')', 'z5wang@comcast.net', '2010-10-01 20:56:13'),
(7, 'Create Account', 'insert into users (email,password,validation) values (''z4wang@hotmail.com'',''5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8'',''wxepxryacd'')', 'z4wang@hotmail.com', '2010-10-01 21:02:14'),
(8, 'Create Account', 'insert into users (email,password,validation) values (''z4wang@hotmail.com'',''5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8'',''r2vqsdqbmc'')', 'z4wang@hotmail.com', '2010-10-01 21:04:51'),
(9, 'Create Account', 'insert into users (email,password,validation) values (''z5wang@comcast.net'',''5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8'',''qxf2cf2fp7'')', 'z5wang@comcast.net', '2010-10-02 01:49:12'),
(10, 'Create Account', 'insert into users (email,password,validation) values (''support@gartrellgroup.com'',''9155ef5fde64a89f06048015eb7c1b09f8db67ed'',''z5q8vperia'')', 'support@gartrellgroup.com', '2010-10-02 21:17:41'),
(11, 'Create Account', 'insert into users (email,password,validation) values (''shawsupport@gartrellgroup.com'',''a94a8fe5ccb19ba61c4c0873d391e987982fbbd3'',''afq4c0ec3w'')', 'shawsupport@gartrellgroup.com', '2010-10-02 21:18:07'),
(12, 'Create Account', 'insert into users (email,password,validation) values (''klickitatsupport@gartrellgroup.com'',''a94a8fe5ccb19ba61c4c0873d391e987982fbbd3'',''vzw48c2vex'')', 'klickitatsupport@gartrellgroup.com', '2010-10-02 21:51:34');
