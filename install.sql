-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2016 at 12:08 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `title` varchar(1000) CHARACTER SET utf8 NOT NULL,
  `date` datetime NOT NULL,
  `text` varchar(10000) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `title`, `date`, `text`) VALUES
(22, 'Ð¡ÐµÐ½ÑÐ°Ñ†Ð¸Ð¾Ð½Ð½Ð°Ñ Ð½Ð¾Ð²Ð¾ÑÑ‚ÑŒ!!!', '2016-12-19 00:02:58', '<p><strong>Ð¡ÐµÐ³Ð¾Ð´Ð½Ñ Ñ€Ð¾Ð²Ð½Ð¾ Ð² Ð¿Ð¾Ð»Ð½Ð¾Ñ‡ÑŒ Ð‘Ð°Ñ‚Ñ‹Ñ€Ð¾Ð²Ð° ÐÐ¹Ð³ÑƒÐ»ÑŒ Ð Ð°Ð¼Ð¸Ð»ÐµÐ²Ð½Ð° Ð·Ð°ÑÐ²Ð¸Ð»Ð° Ð¾ ÑÐ²Ð¾ÐµÐ¼ Ð¿Ñ€Ð¾Ñ‚ÐµÐ·Ðµ Ð¿Ñ€Ð¾Ñ‚Ð¸Ð² Ð½ÐµÑÐ¿Ñ€Ð°Ð²ÐµÐ´Ð»Ð¸Ð²Ð¾ÑÑ‚Ð¸.</strong></p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 NOT NULL,
  `messages` varchar(300) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `messages`) VALUES
(1, 'Ð’Ð¸ÐºÑ‚Ð¾Ñ€', 'vicgerrard@gmail.com', 'werqwerqwerwerqwerqwerwerqwerqwer'),
(2, 'Ð’Ð¸ÐºÑ‚Ð¾Ñ€', 'vicgerrard@gmail.com', 'erqwerqweerqwerqweerqwerqweerqwerqweerqwerqweerqwerqwe'),
(3, 'ÐÐ¹Ð³ÑƒÐ»ÑŒ Ð‘Ð°Ñ‚Ñ‹Ñ€Ð¾Ð²Ð°', 'aigulbatyrova@gmail.com', 'Ñ Ð¿Ñ€Ð¾Ñ‚ÐµÑÑ‚ÑƒÑŽ Ð¿Ñ€Ð¾Ñ‚Ð¸Ð² Ð½ÐµÑÐ¿Ñ€Ð°Ð²ÐµÐ´Ð»Ð¸Ð²Ð¾ÑÑ‚Ð¸!');

-- --------------------------------------------------------

--
-- Table structure for table `map`
--

CREATE TABLE `map` (
  `center_latitude` float NOT NULL,
  `center_longitude` float NOT NULL,
  `zoom` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `map`
--

INSERT INTO `map` (`center_latitude`, `center_longitude`, `zoom`) VALUES
(10, 100, 8);

-- --------------------------------------------------------

--
-- Table structure for table `markers`
--

CREATE TABLE `markers` (
  `id` int(11) NOT NULL,
  `title` varchar(100) CHARACTER SET utf8 NOT NULL,
  `address` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `image` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `url` varchar(100) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `Login` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `Login`, `Password`) VALUES
(0, 'admin', 'password');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `markers`
--
ALTER TABLE `markers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Login` (`Login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `markers`
--
ALTER TABLE `markers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
