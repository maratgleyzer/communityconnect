-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 08, 2010 at 04:22 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.2-1ubuntu4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `civic_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE IF NOT EXISTS `area` (
  `AREA_ID` char(4) COLLATE utf8_unicode_ci NOT NULL,
  `AREA` char(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`AREA_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `block`
--

CREATE TABLE IF NOT EXISTS `block` (
  `BLOCK_ID` bigint(12) unsigned NOT NULL,
  `BLOCK_GROUP` tinyint(3) unsigned NOT NULL,
  `AREA_ID` char(4) COLLATE utf8_unicode_ci NOT NULL,
  `AREA_ID_2` char(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TAPSEGNAM` char(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `LIFECODE` char(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `LIFENAME` char(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `STATE_FIPS` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `CNTY_FIPS` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `TRACT` char(6) COLLATE utf8_unicode_ci NOT NULL,
  `SQMI` decimal(7,2) unsigned NOT NULL,
  `TPAT` smallint(5) unsigned DEFAULT NULL,
  `HISTCKO` mediumint(8) unsigned DEFAULT NULL,
  `TCKO_SMPLPERD` mediumint(8) unsigned DEFAULT NULL,
  `DOMTAP` tinyint(3) unsigned NOT NULL,
  `TOTPOP_CY` mediumint(6) unsigned NOT NULL,
  PRIMARY KEY (`BLOCK_ID`),
  KEY `fk_block` (`AREA_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `block_sum`
--

CREATE TABLE IF NOT EXISTS `block_sum` (
  `BLOCK_ID` bigint(12) unsigned NOT NULL,
  `AREA_ID` char(4) COLLATE utf8_unicode_ci NOT NULL,
  `MATERIAL_ID` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `ITEM_ID` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `CHECKOUT_DATE` date NOT NULL,
  `CHECKOUTS` smallint(4) unsigned NOT NULL,
  UNIQUE KEY `ui_block_sum` (`BLOCK_ID`,`MATERIAL_ID`,`ITEM_ID`,`CHECKOUT_DATE`),
  KEY `fk_2_block_sum` (`AREA_ID`),
  KEY `fk_3_block_sum` (`MATERIAL_ID`),
  KEY `fk_4_block_sum` (`ITEM_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `checkout`
--

CREATE TABLE IF NOT EXISTS `checkout` (
  `CHECKOUT_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `PATRON_ID` int(8) unsigned NOT NULL,
  `BLOCK_ID` bigint(12) unsigned NOT NULL,
  `MATERIAL_ID` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `ITEM_ID` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `CHECKOUT_TIME` datetime NOT NULL,
  PRIMARY KEY (`CHECKOUT_ID`),
  UNIQUE KEY `ui_checkout` (`PATRON_ID`,`MATERIAL_ID`,`ITEM_ID`,`CHECKOUT_TIME`),
  KEY `fk_2_checkout` (`BLOCK_ID`),
  KEY `fk_3_checkout` (`MATERIAL_ID`),
  KEY `fk_4_checkout` (`ITEM_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1541779 ;

-- --------------------------------------------------------

--
-- Table structure for table `checkout_sum`
--

CREATE TABLE IF NOT EXISTS `checkout_sum` (
  `PATRON_ID` int(8) unsigned NOT NULL,
  `BLOCK_ID` bigint(12) unsigned NOT NULL,
  `MATERIAL_ID` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `ITEM_ID` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `CHECKOUT_DATE` date NOT NULL,
  `CHECKOUTS` smallint(4) unsigned NOT NULL,
  UNIQUE KEY `ui_checkout_sum` (`PATRON_ID`,`MATERIAL_ID`,`ITEM_ID`,`CHECKOUT_DATE`),
  KEY `fk_2_checkout_sum` (`BLOCK_ID`),
  KEY `fk_3_checkout_sum` (`MATERIAL_ID`),
  KEY `fk_4_checkout_sum` (`ITEM_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `error`
--

CREATE TABLE IF NOT EXISTS `error` (
  `ERROR_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `PAGE` char(64) COLLATE utf8_unicode_ci NOT NULL,
  `MESSAGE` text COLLATE utf8_unicode_ci NOT NULL,
  `PARAMETER` char(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ERROR_TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ERROR_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `ITEM_ID` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `ITEM` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `A` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `AP` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `APF` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `APNF` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `AAV` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `AAVG` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `AAVS` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `J` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `JP` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `JPF` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `JPNF` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `JAV` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `JAVG` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `JAVS` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `YA` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `YAP` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `YAAV` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `O` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `OD` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `OP` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `OAV` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `CONTRACT` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ITEM_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

CREATE TABLE IF NOT EXISTS `material` (
  `MATERIAL_ID` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `MATERIAL` char(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`MATERIAL_ID`),
  UNIQUE KEY `ui_material` (`MATERIAL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patron`
--

CREATE TABLE IF NOT EXISTS `patron` (
  `PATRON_ID` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `BLOCK_ID` bigint(12) unsigned NOT NULL,
  `AREA_ID` char(4) COLLATE utf8_unicode_ci NOT NULL,
  `ADDRESS` char(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CITY` char(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `STATE` char(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ZIP_CODE` char(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `LATITUDE` double DEFAULT NULL,
  `LONGITUDE` double DEFAULT NULL,
  `EXPIRE_DATE` date DEFAULT NULL,
  `HISTCKO` smallint(5) unsigned NOT NULL DEFAULT '0',
  `SQMI` decimal(7,2) unsigned DEFAULT NULL,
  PRIMARY KEY (`PATRON_ID`),
  KEY `fk_1_patron` (`BLOCK_ID`),
  KEY `fk_2_patron` (`AREA_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2301618 ;

-- --------------------------------------------------------

--
-- Table structure for table `rank_checkout`
--

CREATE TABLE IF NOT EXISTS `rank_checkout` (
  `AREA_ID` char(4) COLLATE utf8_unicode_ci NOT NULL,
  `CHECKOUTS` int(8) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `AREA_ID` (`AREA_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rank_open_market`
--

CREATE TABLE IF NOT EXISTS `rank_open_market` (
  `AREA_ID` char(4) COLLATE utf8_unicode_ci NOT NULL,
  `OPEN_MARKETS` decimal(7,4) unsigned NOT NULL DEFAULT '0.0000',
  UNIQUE KEY `AREA_ID` (`AREA_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rank_patron`
--

CREATE TABLE IF NOT EXISTS `rank_patron` (
  `AREA_ID` char(4) COLLATE utf8_unicode_ci NOT NULL,
  `PATRONS` int(8) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `AREA_ID` (`AREA_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rank_population`
--

CREATE TABLE IF NOT EXISTS `rank_population` (
  `AREA_ID` char(4) COLLATE utf8_unicode_ci NOT NULL,
  `POPULATION` int(8) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `AREA_ID` (`AREA_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `USER_ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `EMAIL` char(64) COLLATE utf8_unicode_ci NOT NULL,
  `PASSWORD` char(64) COLLATE utf8_unicode_ci NOT NULL,
  `TEMPPASS` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VALIDATION` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `VALID` tinyint(1) NOT NULL DEFAULT '0',
  `DISABLE` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`USER_ID`),
  UNIQUE KEY `ui_users` (`EMAIL`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=35 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `block`
--
ALTER TABLE `block`
  ADD CONSTRAINT `fk_block` FOREIGN KEY (`AREA_ID`) REFERENCES `area` (`AREA_ID`);

--
-- Constraints for table `block_sum`
--
ALTER TABLE `block_sum`
  ADD CONSTRAINT `fk_1_block_sum` FOREIGN KEY (`BLOCK_ID`) REFERENCES `block` (`BLOCK_ID`),
  ADD CONSTRAINT `fk_2_block_sum` FOREIGN KEY (`AREA_ID`) REFERENCES `area` (`AREA_ID`),
  ADD CONSTRAINT `fk_3_block_sum` FOREIGN KEY (`MATERIAL_ID`) REFERENCES `material` (`MATERIAL_ID`),
  ADD CONSTRAINT `fk_4_block_sum` FOREIGN KEY (`ITEM_ID`) REFERENCES `item` (`ITEM_ID`);

--
-- Constraints for table `checkout`
--
ALTER TABLE `checkout`
  ADD CONSTRAINT `fk_1_checkout` FOREIGN KEY (`PATRON_ID`) REFERENCES `patron` (`PATRON_ID`),
  ADD CONSTRAINT `fk_2_checkout` FOREIGN KEY (`BLOCK_ID`) REFERENCES `block` (`BLOCK_ID`),
  ADD CONSTRAINT `fk_3_checkout` FOREIGN KEY (`MATERIAL_ID`) REFERENCES `material` (`MATERIAL_ID`),
  ADD CONSTRAINT `fk_4_checkout` FOREIGN KEY (`ITEM_ID`) REFERENCES `item` (`ITEM_ID`);

--
-- Constraints for table `checkout_sum`
--
ALTER TABLE `checkout_sum`
  ADD CONSTRAINT `fk_1_checkout_sum` FOREIGN KEY (`PATRON_ID`) REFERENCES `patron` (`PATRON_ID`),
  ADD CONSTRAINT `fk_2_checkout_sum` FOREIGN KEY (`BLOCK_ID`) REFERENCES `block` (`BLOCK_ID`),
  ADD CONSTRAINT `fk_3_checkout_sum` FOREIGN KEY (`MATERIAL_ID`) REFERENCES `material` (`MATERIAL_ID`),
  ADD CONSTRAINT `fk_4_checkout_sum` FOREIGN KEY (`ITEM_ID`) REFERENCES `item` (`ITEM_ID`);

--
-- Constraints for table `patron`
--
ALTER TABLE `patron`
  ADD CONSTRAINT `fk_1_patron` FOREIGN KEY (`BLOCK_ID`) REFERENCES `block` (`BLOCK_ID`),
  ADD CONSTRAINT `fk_2_patron` FOREIGN KEY (`AREA_ID`) REFERENCES `area` (`AREA_ID`);

--
-- Constraints for table `rank_checkout`
--
ALTER TABLE `rank_checkout`
  ADD CONSTRAINT `fk_rank_checkout` FOREIGN KEY (`AREA_ID`) REFERENCES `area` (`AREA_ID`);

--
-- Constraints for table `rank_open_market`
--
ALTER TABLE `rank_open_market`
  ADD CONSTRAINT `fk_rank_open_market` FOREIGN KEY (`AREA_ID`) REFERENCES `area` (`AREA_ID`);

--
-- Constraints for table `rank_patron`
--
ALTER TABLE `rank_patron`
  ADD CONSTRAINT `fk_rank_patron` FOREIGN KEY (`AREA_ID`) REFERENCES `area` (`AREA_ID`);

--
-- Constraints for table `rank_population`
--
ALTER TABLE `rank_population`
  ADD CONSTRAINT `fk_rank_population` FOREIGN KEY (`AREA_ID`) REFERENCES `area` (`AREA_ID`);
