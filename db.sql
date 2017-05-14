-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 15 Mar 2015, 21:31
-- Server version: 5.5.40-36.1-log
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `se_db`
--
CREATE DATABASE IF NOT EXISTS `se_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `se_db`;
-- add constraints!!!
DROP TABLE IF EXISTS `dbs_users`;
CREATE TABLE IF NOT EXISTS `dbs_users` (
	`user_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
	`user_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
	`user_ip` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '',
	`user_password` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '',
	`user_email` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT '',
	`user_registered` int(11) unsigned NOT NULL DEFAULT UNIX_TIMESTAMP(), -- time;
	`user_level` tinyint(1) NOT NULL DEFAULT '0', -- 1 means admin;
	PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS `dbs_categories`;
CREATE TABLE IF NOT EXISTS `dbs_categories` (
	`cat_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
	`cat_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
	PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci AUTO_INCREMENT=2;

--
-- Dumping data for table `dbs_categories`
--

INSERT INTO `dbs_categories` (`cat_id`, `cat_name`) VALUES
(1, 'Default category (other)');

DROP TABLE IF EXISTS `dbs_events`;
CREATE TABLE IF NOT EXISTS `dbs_events` (
	`event_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
	`cat_id` mediumint(8) unsigned NOT NULL DEFAULT '1',
	`event_approved` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`event_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
	`event_owner` mediumint(8) unsigned NOT NULL DEFAULT '0',
	-- `event_time` int(11) unsigned NOT NULL DEFAULT '0',
	`event_date` date NOT NULL,
	PRIMARY KEY (`event_id`),
	KEY `cat_id` (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

ALTER TABLE `dbs_events` ADD CONSTRAINT events_fk_cat_id FOREIGN KEY `cat_id` REFERENCES `dbs_categories`.`cat_id` ON UPDATE CASCADE ON DELETE SET '1';

DROP TABLE IF EXISTS `dbs_enrollments`;
CREATE TABLE IF NOT EXISTS `dbs_enrollments` (
	`event_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
	`user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
	`user_status` tinyint(1) unsigned NOT NULL DEFAULT '0' -- 0: not accepted by the owner; 1: invited by owner, not confirmed by themselves; 2: confirmed;
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

ALTER TABLE `dbs_enrollments` ADD CONSTRAINT enrollments_fk_event_id FOREIGN KEY `event_id` REFERENCES `dbs_events`.`event_id` ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `dbs_enrollments` ADD CONSTRAINT enrollments_fk_user_id FOREIGN KEY `user_id` REFERENCES `dbs_users`.`user_id` ON DELETE CASCADE ON UPDATE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;