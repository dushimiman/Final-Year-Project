-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2022 at 01:29 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `banking`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `accountno` varchar(100) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `idcard` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `mobilepin` varchar(100) NOT NULL,
  `balance` varchar(100) NOT NULL DEFAULT '0',
  `deleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `accountno`, `fullname`, `idcard`, `phone`, `mobilepin`, `balance`, `deleted`) VALUES
(1, '1665434214', 'TWIZERE Samuel', '1199980040669222', '0788620995', '8239', '750000', 0),
(2, '1665434636', 'NDORI Jean', '1199980040669223', '0781733459', '7959', '150000', 0),
(3, '1665435574', 'NGABO Landry', '1199654677865443', '0786534452', '2761', '150000', 0),
(4, '1665435638', 'NGABO pic', '1199678653435547', '0789999999', '7212', '0', 0);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '123');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `account` varchar(100) NOT NULL,
  `ob` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `balance` varchar(100) NOT NULL,
  `trdate` varchar(100) NOT NULL,
  `trdatealt` varchar(100) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `type`, `account`, `ob`, `amount`, `balance`, `trdate`, `trdatealt`, `deleted`) VALUES
(1, 'in', '1665434214', '0', '1000000', '1000000', '1665434541', '2022-10-10', 0),
(2, 'in', '1665434214', '1000000', '250000', '1250000', '1665434594', '2022-10-10', 0),
(3, 'in', '1665434636', '0', '500000', '500000', '1665434831', '', 0),
(4, 'out', '1665434636', '500000', '300000', '200000', '1665435000', '2022-10-10', 0),
(5, 'in', '1665435574', '0', '100000', '100000', '1665436393', '2022-10-10', 0),
(6, 'in', '1665435638', '0', '7212', '7212', '1665436712', '', 0),
(7, 'in', '1665435638', '0', '7212', '7212', '1665436755', '', 0),
(8, 'in', '1665435638', '0', '7212', '7212', '1665436797', '', 0),
(9, 'in', '1665435574', '100000', '50000', '150000', '1665436991', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `id` int(11) NOT NULL,
  `fromacc` varchar(100) NOT NULL,
  `toacc` varchar(100) NOT NULL,
  `ob` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `balance` varchar(100) NOT NULL,
  `tdatetime` varchar(100) NOT NULL,
  `deleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transfers`
--

INSERT INTO `transfers` (`id`, `fromacc`, `toacc`, `ob`, `amount`, `balance`, `tdatetime`, `deleted`) VALUES
(1, '1665434214', '1665434636', '1250000', '500000', '750000', '1665434831', 0),
(2, '1665435638', '1665435638', '7212', '7212', '0', '1665436712', 0),
(3, '1665435638', '1665435638', '7212', '7212', '0', '1665436755', 0),
(4, '1665435638', '1665435638', '7212', '7212', '0', '1665436797', 0),
(5, '1665434636', '1665435574', '200000', '50000', '150000', '1665436991', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `fullname`, `phone`, `email`, `password`, `deleted`) VALUES
(1, 'Melchi Rogers', '0788620994', 'melchi@gmail.com', '123', 0),
(2, 'ndori claude', '0788953384', 'claudendori@gmail.com', '123', 0),
(3, 'benjos', '0788888888', 'benjos@gmail.com', '123', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
