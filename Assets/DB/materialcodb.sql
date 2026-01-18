-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2026 at 03:11 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `materialcodb`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `MATERIAL_ID` int(11) NOT NULL,
  `USER_ID` int(11) DEFAULT NULL,
  `MATERIAL_NAME` varchar(100) DEFAULT NULL,
  `QUANTITY` int(11) DEFAULT NULL,
  `PRICE` int(11) DEFAULT NULL,
  `DESCRIPTION` varchar(50) DEFAULT NULL,
  `DATE_ADDED` date NOT NULL DEFAULT current_timestamp(),
  `IS_ACTIVE` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`MATERIAL_ID`, `USER_ID`, `MATERIAL_NAME`, `QUANTITY`, `PRICE`, `DESCRIPTION`, `DATE_ADDED`, `IS_ACTIVE`) VALUES
(65, 8, 'Brown Cardboard Box', 50, 50, 'N/A', '2026-01-17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `MEMBER_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `ORGANIZATION_ID` int(11) NOT NULL,
  `REMARKS` varchar(255) NOT NULL,
  `DATE_JOINED` datetime NOT NULL DEFAULT current_timestamp(),
  `IS_ACTIVE` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`MEMBER_ID`, `USER_ID`, `ORGANIZATION_ID`, `REMARKS`, `DATE_JOINED`, `IS_ACTIVE`) VALUES
(1, 8, 3, 'adios', '0000-00-00 00:00:00', 0),
(2, 8, 3, 'adios', '2026-01-17 09:34:08', 0),
(3, 8, 3, 'adios', '2026-01-17 09:58:20', 0),
(4, 8, 3, 'adios', '2026-01-17 09:58:23', 0),
(5, 8, 3, 'adios', '2026-01-17 09:58:25', 0),
(6, 8, 3, 'adios', '2026-01-17 09:58:27', 0);

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `ORGANIZATION_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `NAME` varchar(255) NOT NULL,
  `ADDRESS` text DEFAULT NULL,
  `TYPE` varchar(100) DEFAULT NULL,
  `CREATED_AT` datetime DEFAULT current_timestamp(),
  `IS_ACTIVE` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`ORGANIZATION_ID`, `USER_ID`, `NAME`, `ADDRESS`, `TYPE`, `CREATED_AT`, `IS_ACTIVE`) VALUES
(1, 8, 'Test 1', 'Blank 2', 'School', '2026-01-14 16:38:16', 1),
(2, 10, 'yash', '123', 'scool', '2026-01-16 12:34:09', 1),
(3, 8, 'tes1', 'blank', 'school', '2026-01-17 08:48:03', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `RESERVATION_ID` int(11) NOT NULL,
  `MATERIAL_ID` int(11) DEFAULT NULL,
  `USER_ID` int(11) DEFAULT NULL,
  `QUANTITY` int(11) DEFAULT NULL,
  `REQUESTOR` varchar(255) DEFAULT NULL,
  `PURPOSE` varchar(255) DEFAULT NULL,
  `RESERVATION_DATE` date DEFAULT current_timestamp(),
  `CLAIMING_DATE` date DEFAULT NULL,
  `STATUS` varchar(50) DEFAULT 'On Process',
  `IS_ACTIVE` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`RESERVATION_ID`, `MATERIAL_ID`, `USER_ID`, `QUANTITY`, `REQUESTOR`, `PURPOSE`, `RESERVATION_DATE`, `CLAIMING_DATE`, `STATUS`, `IS_ACTIVE`) VALUES
(32, 65, 8, 16, 'fishy', 'N/A', '2026-01-17', '2026-01-23', 'CLAIMED', 1);

-- --------------------------------------------------------

--
-- Table structure for table `stocks_log`
--

CREATE TABLE `stocks_log` (
  `STOCKS_ID` int(11) NOT NULL,
  `MATERIAL_NAME` varchar(100) NOT NULL,
  `USER_ID` int(11) DEFAULT NULL,
  `SOURCE_TABLE` varchar(100) DEFAULT NULL,
  `SOURCE_ID` int(11) DEFAULT NULL,
  `QUANTITY` int(11) NOT NULL,
  `TRANSACTION_TYPE` varchar(255) NOT NULL,
  `TIME_AND_DATE` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stocks_log`
--

INSERT INTO `stocks_log` (`STOCKS_ID`, `MATERIAL_NAME`, `USER_ID`, `SOURCE_TABLE`, `SOURCE_ID`, `QUANTITY`, `TRANSACTION_TYPE`, `TIME_AND_DATE`) VALUES
(44, 'Brown Cardboard Box', 8, 'inventory', 65, 50, 'INSERTED ITEM', '2026-01-17 20:22:19'),
(45, 'Brown Cardboard Box', 8, 'reservation', 32, 16, 'RESERVED ITEM', '2026-01-17 20:22:33'),
(46, 'Brown Cardboard Box', 8, 'reservation', 32, 16, 'STATUS UPDATED TO Reserved', '2026-01-17 20:45:37'),
(47, 'Brown Cardboard Box', 8, 'reservation', 32, 16, 'STATUS UPDATED TO CLAIMED', '2026-01-17 20:46:43');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `USER_ID` int(11) NOT NULL,
  `NAME` varchar(100) DEFAULT NULL,
  `EMAIL` varchar(100) DEFAULT NULL,
  `PASSWORD` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`USER_ID`, `NAME`, `EMAIL`, `PASSWORD`) VALUES
(8, 'Joseph Mejos', 'Xzilleon2@gmail.com', '$2y$10$oLhAU413PYYlc3FWdQA03OqK3DOtKuq9tepTaEhHiWWcugluyE0tS'),
(9, 'Joseph Mejos', 'Nizarech@gmail.com', '$2y$10$XKOYpb9Xv7w8cjKUr9i3FumfL7IFsjTwdUVO7QtFyw7dpwTJpQ/D.'),
(10, 'alviliango', 'goalvilian@gmail.com', '$2y$10$pDz3fTaZ5k2SgURLMOWjcOp6XwNFgcq2FNdvgcfnxmqUZXNuDHidW');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`MATERIAL_ID`),
  ADD KEY `fk_inventory_user` (`USER_ID`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`MEMBER_ID`),
  ADD KEY `USER_ID` (`USER_ID`),
  ADD KEY `ORGANIZATION_ID` (`ORGANIZATION_ID`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`ORGANIZATION_ID`),
  ADD KEY `USER_ID` (`USER_ID`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`RESERVATION_ID`),
  ADD KEY `MATERIAL_ID` (`MATERIAL_ID`),
  ADD KEY `USER_ID` (`USER_ID`);

--
-- Indexes for table `stocks_log`
--
ALTER TABLE `stocks_log`
  ADD PRIMARY KEY (`STOCKS_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`USER_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `MATERIAL_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `MEMBER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `ORGANIZATION_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `RESERVATION_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `stocks_log`
--
ALTER TABLE `stocks_log`
  MODIFY `STOCKS_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `USER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `fk_inventory_user` FOREIGN KEY (`USER_ID`) REFERENCES `user` (`USER_ID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `user` (`USER_ID`),
  ADD CONSTRAINT `members_ibfk_2` FOREIGN KEY (`ORGANIZATION_ID`) REFERENCES `organizations` (`ORGANIZATION_ID`);

--
-- Constraints for table `organizations`
--
ALTER TABLE `organizations`
  ADD CONSTRAINT `organizations_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `user` (`USER_ID`);

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`MATERIAL_ID`) REFERENCES `inventory` (`MATERIAL_ID`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`USER_ID`) REFERENCES `user` (`USER_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
