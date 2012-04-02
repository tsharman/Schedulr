-- phpMyAdmin SQL Dump
-- version 3.4.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 02, 2012 at 11:35 PM
-- Server version: 5.1.61
-- PHP Version: 5.3.5-1ubuntu7.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `schedulr`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `title` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `courseid` mediumint(9) NOT NULL,
  `catalognum` smallint(6) NOT NULL,
  `dept` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `prof` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `section` tinyint(4) NOT NULL,
  `credits` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `M` tinyint(1) NOT NULL,
  `T` tinyint(1) NOT NULL,
  `W` tinyint(1) NOT NULL,
  `TH` tinyint(1) NOT NULL,
  `F` tinyint(1) NOT NULL,
  `SA` tinyint(1) NOT NULL,
  `SU` tinyint(1) NOT NULL,
  `location` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `req` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  KEY `courseid` (`courseid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE IF NOT EXISTS `schedules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=238 ;

-- --------------------------------------------------------

--
-- Table structure for table `schedule_to_course`
--

CREATE TABLE IF NOT EXISTS `schedule_to_course` (
  `scheduleid` int(11) NOT NULL,
  `courseid` int(11) NOT NULL,
  PRIMARY KEY (`scheduleid`,`courseid`),
  KEY `courseid` (`courseid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uniqname` varchar(10) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`uniqname`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
