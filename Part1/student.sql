-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 22, 2018 at 02:00 AM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student`
--

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `ID` varchar(128) NOT NULL,
  `Name` varchar(128) DEFAULT NULL,
  `Major` varchar(128) DEFAULT NULL,
  `Year` varchar(128) DEFAULT NULL,
  `userid` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`ID`, `Name`, `Major`, `Year`, `userid`, `email`) VALUES
('1', 'Andy', 'CS', 'Freshman', 'student1', 'andy@utdallas.edu'),
('2', 'Brad', 'CS', 'Senior', 'student2', 'brad@utdalals.edu'),
('3', 'Evan', 'EE', 'Junior', 'student3', 'evan@utdallas.edu'),
('4', 'Josh', 'SE', 'Freshman', 'student4', 'josh@utdallas.edu'),
('5', 'James', 'CS', 'Senior', 'student5', 'james@utdallas.edu'),
('6', 'Justin', 'SE', 'Junior', 'student6', 'justin@utdallas.edu');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
