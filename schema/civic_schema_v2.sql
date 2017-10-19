-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 05, 2010 at 01:47 AM
-- Server version: 5.1.41
-- PHP Version: 5.3.2-1ubuntu4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `civic2`
--

-- --------------------------------------------------------

--
-- Table structure for table `serviceareas`
--

CREATE TABLE IF NOT EXISTS `area` (
`AREA_ID` char(4) NOT NULL,
`AREA` char(32) NOT NULL,
PRIMARY KEY (`AREA_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

--
-- Dumping data for table `serviceareas`
--



-- --------------------------------------------------------

--
-- Table structure for table `item_types`
--

CREATE TABLE IF NOT EXISTS `item` (
`ITEM_ID` char(3) NOT NULL,
`ITEM` char(32) NOT NULL,
`APNF` tinyint(1) unsigned NOT NULL DEFAULT '0',
`APF` tinyint(1) unsigned NOT NULL DEFAULT '0',
`AP` tinyint(1) unsigned NOT NULL DEFAULT '0',
`AAVG` tinyint(1) unsigned NOT NULL DEFAULT '0',
`AAVS` tinyint(1) unsigned NOT NULL DEFAULT '0',
`AAV` tinyint(1) unsigned NOT NULL DEFAULT '0',
`JPNF` tinyint(1) unsigned NOT NULL DEFAULT '0',
`JPF` tinyint(1) unsigned NOT NULL DEFAULT '0',
`JP` tinyint(1) unsigned NOT NULL DEFAULT '0',
`JAVG` tinyint(1) unsigned NOT NULL DEFAULT '0',
`JAVS` tinyint(1) unsigned NOT NULL DEFAULT '0',
`JAV` tinyint(1) unsigned NOT NULL DEFAULT '0',
`YAP` tinyint(1) unsigned NOT NULL DEFAULT '0',
`YAAV` tinyint(1) unsigned NOT NULL DEFAULT '0',
`JYAP` tinyint(1) unsigned NOT NULL DEFAULT '0',
`JYAAV` tinyint(1) unsigned NOT NULL DEFAULT '0',
`TNF` tinyint(1) unsigned NOT NULL DEFAULT '0',
`TF` tinyint(1) unsigned NOT NULL DEFAULT '0',
`TAVG` tinyint(1) unsigned NOT NULL DEFAULT '0',
`TAVS` tinyint(1) unsigned NOT NULL DEFAULT '0',
`TP` tinyint(1) unsigned NOT NULL DEFAULT '0',
`TAV` tinyint(1) unsigned NOT NULL DEFAULT '0',
`TA` tinyint(1) unsigned NOT NULL DEFAULT '0',
`TJ` tinyint(1) unsigned NOT NULL DEFAULT '0',
`TYA` tinyint(1) unsigned NOT NULL DEFAULT '0',
`TJYA` tinyint(1) unsigned NOT NULL DEFAULT '0',
`TNO` tinyint(1) unsigned NOT NULL DEFAULT '0',
`OAV` tinyint(1) unsigned NOT NULL DEFAULT '0',
`OP` tinyint(1) unsigned NOT NULL DEFAULT '0',
`OI` tinyint(1) unsigned NOT NULL DEFAULT '0',
`TOT_OTHER` tinyint(1) unsigned NOT NULL DEFAULT '0',
PRIMARY KEY (`ITEM_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=220 ;

--
-- Dumping data for table `item_types`
--


-- --------------------------------------------------------

--
-- Table structure for table `material_types`
--

CREATE TABLE IF NOT EXISTS `material` (
`MATERIAL_ID` char(1) NOT NULL,
`MATERIAL` char(32) NOT NULL,
PRIMARY KEY (`MATERIAL_ID`),
UNIQUE INDEX `ui_material` (`MATERIAL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

--
-- Dumping data for table `material_types`
--


-- --------------------------------------------------------

--
-- Table structure for table `block_group`
--

CREATE TABLE IF NOT EXISTS `block` (
`BLOCK_ID` bigint(12) unsigned NOT NULL,
`BLOCK_GROUP` tinyint unsigned NOT NULL,
`AREA_ID` char(4) NOT NULL,
`AREA_ID_2` char(4) DEFAULT NULL,
`TAPSEGNAM` char(32) DEFAULT NULL,
`LIFECODE` char(4) DEFAULT NULL,
`LIFENAME` char(32) DEFAULT NULL,
`STATE_FIPS` char(2) NOT NULL,
`CNTY_FIPS` char(3) NOT NULL,
`TRACT` char(6) NOT NULL,
`SQMI` decimal(7,2) unsigned NOT NULL,
`TPAT` smallint(5) unsigned DEFAULT NULL,
`HISTCKO` mediumint(8) unsigned DEFAULT NULL,
`TCKO_SMPLPERD` mediumint(8) unsigned DEFAULT NULL,
`DOMTAP` tinyint unsigned NOT NULL,
`TOTPOP_CY` mediumint(6) unsigned NOT NULL,
PRIMARY KEY (`BLOCK_ID`),
CONSTRAINT `fk_block` FOREIGN KEY (`AREA_ID`) REFERENCES `area` (`AREA_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=833 ;

--
-- Dumping data for table `block_groups`
--


-- --------------------------------------------------------

--
-- Table structure for table `patrons`
--

CREATE TABLE IF NOT EXISTS `patron` (
`PATRON_ID` int(8) unsigned NOT NULL AUTO_INCREMENT,
`BLOCK_ID` bigint(12) unsigned NOT NULL,
`AREA_ID` char(4) NOT NULL,
`ADDRESS` char(64) DEFAULT NULL,
`CITY` char(32) DEFAULT NULL,
`STATE` char(2) DEFAULT NULL,
`ZIP_CODE` char(5) DEFAULT NULL,
`LATITUDE` double DEFAULT NULL,
`LONGITUDE` double DEFAULT NULL,
`EXPIRE_DATE` date DEFAULT NULL,
`HISTCKO` smallint(5) unsigned NOT NULL DEFAULT '0',
`SQMI` decimal(7,2) unsigned DEFAULT NULL,
PRIMARY KEY (`PATRON_ID`),
CONSTRAINT `fk_1_patron` FOREIGN KEY (`BLOCK_ID`) REFERENCES `block` (`BLOCK_ID`),
CONSTRAINT `fk_2_patron` FOREIGN KEY (`AREA_ID`) REFERENCES `area` (`AREA_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

--
-- Dumping data for table `patrons`
--


-- --------------------------------------------------------

--
-- Table structure for table `block_group_sum`
--

CREATE TABLE IF NOT EXISTS `block_sum` (
`BLOCK_ID` bigint(12) unsigned NOT NULL,
`AREA_ID` char(4) NOT NULL, 
`MATERIAL_ID` char(1) NOT NULL,
`ITEM_ID` char(3) NOT NULL,
`CHECKOUT_DATE` date NOT NULL,
`CHECKOUTS` smallint(4) unsigned NOT NULL,
UNIQUE INDEX `ui_block_sum` (`BLOCK_ID`,`MATERIAL_ID`,`ITEM_ID`,`CHECKOUT_DATE`),
CONSTRAINT `fk_1_block_sum` FOREIGN KEY (`BLOCK_ID`) REFERENCES `block` (`BLOCK_ID`),
CONSTRAINT `fk_2_block_sum` FOREIGN KEY (`AREA_ID`) REFERENCES `area` (`AREA_ID`),
CONSTRAINT `fk_3_block_sum` FOREIGN KEY (`MATERIAL_ID`) REFERENCES `material` (`MATERIAL_ID`),
CONSTRAINT `fk_4_block_sum` FOREIGN KEY (`ITEM_ID`) REFERENCES `item` (`ITEM_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

--
-- Dumping data for table `block_group_sum`
--


-- --------------------------------------------------------

--
-- Table structure for table `checkout`
--

CREATE TABLE IF NOT EXISTS `checkout` (
`CHECKOUT_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
`PATRON_ID` int(8) unsigned NOT NULL,
`BLOCK_ID` bigint(12) unsigned NOT NULL,
`MATERIAL_ID` char(1) NOT NULL,
`ITEM_ID` char(3) NOT NULL,
`CHECKOUT_TIME` datetime NOT NULL,
PRIMARY KEY (`CHECKOUT_ID`),
UNIQUE INDEX `ui_checkout` (`PATRON_ID`,`MATERIAL_ID`,`ITEM_ID`,`CHECKOUT_TIME`),
CONSTRAINT `fk_1_checkout` FOREIGN KEY (`PATRON_ID`) REFERENCES `patron` (`PATRON_ID`),
CONSTRAINT `fk_2_checkout` FOREIGN KEY (`BLOCK_ID`) REFERENCES `block` (`BLOCK_ID`),
CONSTRAINT `fk_3_checkout` FOREIGN KEY (`MATERIAL_ID`) REFERENCES `material` (`MATERIAL_ID`),
CONSTRAINT `fk_4_checkout` FOREIGN KEY (`ITEM_ID`) REFERENCES `item` (`ITEM_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

--
-- Dumping data for table `checkouts`
--


-- --------------------------------------------------------

--
-- Table structure for table `checkout_sum`
--

CREATE TABLE IF NOT EXISTS `checkout_sum` (
`PATRON_ID` int(8) unsigned NOT NULL,
`BLOCK_ID` bigint(12) unsigned NOT NULL,
`MATERIAL_ID` char(1) NOT NULL,
`ITEM_ID` char(3) NOT NULL,
`CHECKOUT_DATE` date NOT NULL,
`CHECKOUTS` smallint(4) unsigned NOT NULL,
UNIQUE INDEX `ui_checkout_sum` (`PATRON_ID`,`MATERIAL_ID`,`ITEM_ID`,`CHECKOUT_DATE`),
CONSTRAINT `fk_1_checkout_sum` FOREIGN KEY (`PATRON_ID`) REFERENCES `patron` (`PATRON_ID`),
CONSTRAINT `fk_2_checkout_sum` FOREIGN KEY (`BLOCK_ID`) REFERENCES `block` (`BLOCK_ID`),
CONSTRAINT `fk_3_checkout_sum` FOREIGN KEY (`MATERIAL_ID`) REFERENCES `material` (`MATERIAL_ID`),
CONSTRAINT `fk_4_checkout_sum` FOREIGN KEY (`ITEM_ID`) REFERENCES `item` (`ITEM_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

--
-- Dumping data for table `checkoutsum`
--


-- --------------------------------------------------------

--
-- Table structure for table `error_logs`
--

CREATE TABLE IF NOT EXISTS `error` (
`ERROR_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
`PAGE` char(64) NOT NULL,
`MESSAGE` text NOT NULL,
`PARAMETER` char(64) DEFAULT NULL,
`ERROR_TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`ERROR_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `error_logs`
--


-- --------------------------------------------------------

--
-- Table structure for table `rank_co`
--

CREATE TABLE IF NOT EXISTS `rank_checkout` (
`AREA_ID` char(4) NOT NULL,
`CHECKOUTS` int(8) unsigned NOT NULL DEFAULT '0',
UNIQUE KEY (`AREA_ID`),
CONSTRAINT `fk_rank_checkout` FOREIGN KEY (`AREA_ID`) REFERENCES `area` (`AREA_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

--
-- Dumping data for table `rank_co`
--


-- --------------------------------------------------------

--
-- Table structure for table `rank_open_market`
--

CREATE TABLE IF NOT EXISTS `rank_open_market` (
`AREA_ID` char(4) NOT NULL,
`OPEN_MARKETS` decimal(7,4) unsigned NOT NULL DEFAULT '0',
UNIQUE KEY (`AREA_ID`),
CONSTRAINT `fk_rank_open_market` FOREIGN KEY (`AREA_ID`) REFERENCES `area` (`AREA_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

--
-- Dumping data for table `rank_open_market`
--


-- --------------------------------------------------------

--
-- Table structure for table `rank_patrons`
--

CREATE TABLE IF NOT EXISTS `rank_patron` (
`AREA_ID` char(4) NOT NULL,
`PATRONS` int(8) unsigned NOT NULL DEFAULT '0',
UNIQUE KEY (`AREA_ID`),
CONSTRAINT `fk_rank_patron` FOREIGN KEY (`AREA_ID`) REFERENCES `area` (`AREA_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

--
-- Dumping data for table `rank_patrons`
--


-- --------------------------------------------------------

--
-- Table structure for table `rank_population`
--

CREATE TABLE IF NOT EXISTS `rank_population` (
`AREA_ID` char(4) NOT NULL,
`POPULATION` int(8) unsigned NOT NULL DEFAULT '0',
UNIQUE KEY (`AREA_ID`),
CONSTRAINT `fk_rank_population` FOREIGN KEY (`AREA_ID`) REFERENCES `area` (`AREA_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;


--
-- Dumping data for table `rank_population`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`USER_ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
`EMAIL` char(64) NOT NULL,
`PASSWORD` char(64) NOT NULL,
`TEMPPASS` varchar(16) DEFAULT NULL,
`VALIDATION` varchar(16) NOT NULL,
`VALID` tinyint(1) NOT NULL DEFAULT '0',
`DISABLE` tinyint(1) NOT NULL DEFAULT '0',
PRIMARY KEY (`USER_ID`),
UNIQUE INDEX `ui_users` (`EMAIL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=34 ;

--
-- Dumping data for table `users`
--

