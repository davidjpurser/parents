-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Feb 07, 2016 at 03:27 PM
-- Server version: 5.5.45-cll-lve
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `davipmss_bcs`
--

-- --------------------------------------------------------

--
-- Table structure for table `parentsdb_bookings`
--

CREATE TABLE IF NOT EXISTS `parentsdb_bookings` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `staff` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `studentid` varchar(5) COLLATE latin1_general_ci NOT NULL,
  `expectedtimestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  `actualtimestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parentsdb_login`
--

CREATE TABLE IF NOT EXISTS `parentsdb_login` (
  `username` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(60) COLLATE latin1_general_ci NOT NULL,
  `type` varchar(10) COLLATE latin1_general_ci NOT NULL DEFAULT 'student',
  `department` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `staffname` varchar(100) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parentsdb_present`
--

CREATE TABLE IF NOT EXISTS `parentsdb_present` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `studentid` int(5) NOT NULL,
  `intime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `present` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parentsdb_students`
--

CREATE TABLE IF NOT EXISTS `parentsdb_students` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `lastname` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `form` varchar(5) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
