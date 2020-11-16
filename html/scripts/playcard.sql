-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 03, 2020 at 01:23 AM
-- Server version: 10.3.22-MariaDB-0+deb10u1
-- PHP Version: 7.3.14-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `playcard`
--

-- --------------------------------------------------------

--
-- Table structure for table `Bookings`
--

CREATE TABLE `Bookings` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `item` varchar(20) NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `start_day` int(11) NOT NULL,
  `end_day` int(11) DEFAULT NULL,
  `start_time` int(11) NOT NULL,
  `end_time` int(11) DEFAULT NULL,
  `canceled` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Bookings`
--

INSERT INTO `Bookings` (`id`, `name`, `phone`, `item`, `comment`, `start_day`, `end_day`, `start_time`, `end_time`, `canceled`) VALUES
(1, 'test', '55475', 'Meeting room', NULL, 1590157800, 1590589800, 54000, 84600, 0);

-- --------------------------------------------------------

--
-- Table structure for table `card`
--

CREATE TABLE `card` (
  `id` int(10) UNSIGNED NOT NULL,
  `card_id` varchar(255) NOT NULL,
  `credit` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `expires` timestamp NOT NULL DEFAULT current_timestamp(),
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `id` int(255) NOT NULL,
  `SiteTitle` varchar(255) NOT NULL,
  `GamePlay` int(4) DEFAULT NULL,
  `BirthdayBonus` int(5) DEFAULT NULL,
  `BackPic` varchar(255) DEFAULT NULL,
  `TimeFormat` varchar(10) NOT NULL,
  `T_GST` varchar(10) NOT NULL,
  `GST` int(5) NOT NULL,
  `T_Bonus` varchar(10) NOT NULL,
  `Bonus` int(10) NOT NULL,
  `BAmount` int(6) NOT NULL,
  `WheelC1` varchar(15) DEFAULT NULL,
  `WheelC2` varchar(15) DEFAULT NULL,
  `WheelC3` varchar(15) DEFAULT NULL,
  `WheelC4` varchar(15) DEFAULT NULL,
  `LedBright` int(5) DEFAULT NULL,
  `OTAUpdate` varchar(255) DEFAULT NULL,
  `THour1` float NOT NULL,
  `THour2` float NOT NULL,
  `THour3` float NOT NULL,
  `THour4` float NOT NULL,
  `THour5` float NOT NULL,
  `THour6` float NOT NULL,
  `THour7` float NOT NULL,
  `THour8` float NOT NULL,
  `THour9` float NOT NULL,
  `NameType` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `SiteTitle`, `GamePlay`, `BirthdayBonus`, `BackPic`, `TimeFormat`, `T_GST`, `GST`, `T_Bonus`, `Bonus`, `BAmount`, `WheelC1`, `WheelC2`, `WheelC3`, `WheelC4`, `LedBright`, `OTAUpdate`, `THour1`, `THour2`, `THour3`, `THour4`, `THour5`, `THour6`, `THour7`, `THour8`, `THour9`, `NameType`) VALUES
(0, 'RFID Pinball Scanner', NULL, NULL, 'loading.gif', 'TD', 'check', 6, '', 0, 0, 'Black', 'Blue', 'Black', 'Black', 25, NULL, 5, 7, 9, 11, 13, 15, 17, 19, 21, 'Cartoon');

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE `income` (
  `month` int(10) NOT NULL,
  `income` int(10) NOT NULL,
  `expencives` int(10) NOT NULL,
  `gross` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` int(10) UNSIGNED NOT NULL,
  `card_id` int(10) UNSIGNED NOT NULL,
  `time_in` timestamp NOT NULL DEFAULT current_timestamp(),
  `machine_uid` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `machine`
--

CREATE TABLE `machine` (
  `id` int(10) UNSIGNED NOT NULL,
  `machine_mac` varchar(255) NOT NULL,
  `machine_name` varchar(255) NOT NULL,
  `machine_value` int(10) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `version` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `machine`
--

INSERT INTO `machine` (`id`, `machine_mac`, `machine_name`, `machine_value`, `created`, `version`) VALUES
(3, '84:F3:EB:0F:52:7F', 'Fish Tales', 1, '2020-04-28 09:26:35', '1.0'),
(4, '18:FE:34:D2:06:9B', 'Dr Who', 2, '2020-07-04 14:20:03', '1.0');

-- --------------------------------------------------------

--
-- Table structure for table `Tags`
--

CREATE TABLE `Tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `TimeGot` int(10) NOT NULL,
  `rfid_uid` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(100) NOT NULL,
  `mobile` int(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `address2` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `credit` int(10) NOT NULL,
  `rfid_uid` varchar(255) NOT NULL,
  `TimeGot` int(10) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `image`, `mobile`, `email`, `address`, `address2`, `birthdate`, `credit`, `rfid_uid`, `TimeGot`, `created`) VALUES
(1, 'SmartAlec', '1588359402.jpg', 423106303, 'admin@smartaleclights.com', 'Finch Road', 'Murray Bridge', '0000-00-00', 296, 'b03f5756', 0, '2020-04-08 15:58:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Bookings`
--
ALTER TABLE `Bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `card`
--
ALTER TABLE `card`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `machine`
--
ALTER TABLE `machine`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `Tags`
--
ALTER TABLE `Tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Bookings`
--
ALTER TABLE `Bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `card`
--
ALTER TABLE `card`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `machine`
--
ALTER TABLE `machine`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `Tags`
--
ALTER TABLE `Tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
