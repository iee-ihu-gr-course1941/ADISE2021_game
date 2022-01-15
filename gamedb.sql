-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2022 at 06:53 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gamedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `Gid` int(11) NOT NULL,
  `user` varchar(20) NOT NULL,
  `CardName` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`Gid`, `user`, `CardName`) VALUES
(173, 'ee', '1H'),
(173, 'mike', 'KC'),
(173, 'ee', '8D'),
(173, 'mike', '4C'),
(173, 'mike', '8S'),
(173, 'mike', '5D'),
(173, 'ee', '4S'),
(173, 'ee', '5S'),
(173, 'mike', '1D');

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `Gid` int(11) NOT NULL,
  `user1` varchar(20) NOT NULL,
  `user2` varchar(20) NOT NULL,
  `GameStatus` varchar(20) NOT NULL,
  `turn` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`Gid`, `user1`, `user2`, `GameStatus`, `turn`) VALUES
(173, 'mike', 'ee', 'started', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`) VALUES
('aris', '123'),
('stelios', '332'),
('mike', '123'),
('asd', '321'),
('qwe', '123'),
('jack', '123'),
('a', 'a'),
('b', 'b'),
('ee', 'ee'),
('qq', 'qq'),
('aa', 'aa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`Gid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `Gid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
