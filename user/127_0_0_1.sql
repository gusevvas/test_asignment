-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 03, 2019 at 12:12 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user`
--
CREATE DATABASE IF NOT EXISTS `user` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `user`;

-- --------------------------------------------------------

--
-- Table structure for table `bonus`
--

DROP TABLE IF EXISTS `bonus`;
CREATE TABLE IF NOT EXISTS `bonus` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `bonus_name` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `bonus_type` int(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bonus`
--

INSERT INTO `bonus` (`id`, `bonus_name`, `bonus_type`) VALUES
(2, 'Bonus points!', 2),
(3, '<img src=\"creeper.jpg\">Aw man, a creeper!', 3),
(1, 'EUR for you!', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bonus_type`
--

DROP TABLE IF EXISTS `bonus_type`;
CREATE TABLE IF NOT EXISTS `bonus_type` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bonus_type`
--

INSERT INTO `bonus_type` (`id`, `name`) VALUES
(1, 'Money'),
(2, 'Bonus Points'),
(3, 'Item');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `money_upper_limit` int(32) NOT NULL,
  `money_lower_limit` int(32) NOT NULL,
  `bonus_lower_limit` int(32) NOT NULL,
  `bonus_upper_limit` int(32) NOT NULL,
  `bonus_coefficient` int(2) NOT NULL,
  `maximum_item_amount` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `money_upper_limit`, `money_lower_limit`, `bonus_lower_limit`, `bonus_upper_limit`, `bonus_coefficient`, `maximum_item_amount`) VALUES
(1, 2000, 100, 100, 3000, 50, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `money` int(5) NOT NULL,
  `bonusPoints` int(5) NOT NULL,
  `user_money_limit` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `money`, `bonusPoints`, `user_money_limit`) VALUES
(1, 'platformhelp', '123123', 100, 200, 5000);

-- --------------------------------------------------------

--
-- Table structure for table `user_bonus`
--

DROP TABLE IF EXISTS `user_bonus`;
CREATE TABLE IF NOT EXISTS `user_bonus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `bonus_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=127 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
