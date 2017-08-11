-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2017 at 06:04 AM
-- Server version: 5.6.17-log
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `new_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `new_app_users`
--

CREATE TABLE IF NOT EXISTS `new_app_users` (
  `username` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `born` varchar(200) NOT NULL,
  `register_day` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(250) NOT NULL,
  `user_status` int(11) NOT NULL DEFAULT '1',
  `user_activation` varchar(250) NOT NULL,
  `new_psw` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `new_app_users`
--

INSERT INTO `new_app_users` (`username`, `first_name`, `last_name`, `email`, `born`, `register_day`, `user_id`, `password`, `user_status`, `user_activation`, `new_psw`) VALUES
('admin', 'Albin', 'Gasi', 'albin.g@live.com', '31.05.1992', '2017-08-05 21:51:16', 1, 'a6c6909b484cb7221cb9c10bc5e8e354', 2, 'asdadadas2424234', '02db2740cbbffb548b20ff4aba84f5c7');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
