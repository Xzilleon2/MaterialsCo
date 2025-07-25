-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2025 at 04:49 AM
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
-- Table structure for table `distribution`
--

CREATE TABLE `distribution` (
  `DISTRIBUTION_ID` int(11) NOT NULL,
  `MATERIAL_ID` int(11) DEFAULT NULL,
  `USER_ID` int(11) DEFAULT NULL,
  `RESERVATION_ID` int(11) DEFAULT NULL,
  `QUANTITY` int(11) DEFAULT NULL,
  `LOCATION` varchar(255) DEFAULT NULL,
  `DATE_RELEASED` date DEFAULT NULL,
  `REMARKS` varchar(255) DEFAULT NULL,
  `APPROVED_BY` varchar(255) DEFAULT NULL,
  `STATUS` varchar(50) DEFAULT 'Pending',
  `IS_ACTIVE` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `MATERIAL_ID` int(11) NOT NULL,
  `MATERIAL_NAME` varchar(100) DEFAULT NULL,
  `QUANTITY` int(11) DEFAULT NULL,
  `PRICE` int(11) DEFAULT NULL,
  `SIZE` varchar(11) DEFAULT NULL,
  `MODEL` varchar(50) DEFAULT NULL,
  `DATE_ADDED` date NOT NULL DEFAULT current_timestamp(),
  `IS_ACTIVE` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `RESERVATION_DATE` date DEFAULT NULL,
  `CLAIMING_DATE` date DEFAULT NULL,
  `STATUS` varchar(50) DEFAULT NULL,
  `IS_ACTIVE` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stocks_log`
--

CREATE TABLE `stocks_log` (
  `STOCKS_ID` int(11) NOT NULL,
  `MATERIAL_ID` int(11) DEFAULT NULL,
  `DISTRIBUTION_ID` int(11) DEFAULT NULL,
  `USER_ID` int(11) DEFAULT NULL,
  `QUANTITY` int(11) DEFAULT NULL,
  `TRANSACTION_TYPE` varchar(50) DEFAULT NULL,
  `TIME_AND_DATE` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `USER_ID` int(11) NOT NULL,
  `NAME` varchar(100) DEFAULT NULL,
  `AGE` int(11) DEFAULT NULL,
  `EMAIL` varchar(100) DEFAULT NULL,
  `PASSWORD` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`USER_ID`, `NAME`, `AGE`, `EMAIL`, `PASSWORD`) VALUES
(1, 'Joseph Steward Mejos', 21, 'Xzilleon2@gmail.com', '$2y$10$SdtFxSf3OzaTNEIPedG6G.dsqwE3o0ikQ5lyVOwAeOJb1FLptp.Pe'),
(2, 'John Lemon', 20, 'Zigaral00@gmail.com', '$2y$10$vFOY0yG/TaPzJ5XoRQznHubM47V8HDW/IDWO6tdKgIStXl5Nithze'),
(3, 'Joseph Steward Mejos', 21, 'Xzilleon2@gmail.com', '$2y$10$Hy8.oRjc9n2GeFKbkwsYcOAlz8m2HbG6uViMmoPVNgSYJfjzDMtS6'),
(4, 'John Lemon3123123', 22, 'Xzilleon2@gmail.com', '$2y$10$u0usCYEq5Akye5iUW6fVlutgWl0reJI68.hncrVNE6tWwDb7hJPn6');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_distribution`
-- (See below for the actual view)
--
CREATE TABLE `view_distribution` (
`DISTRIBUTION_ID` int(11)
,`MATERIAL_ID` int(11)
,`USER_ID` int(11)
,`QUANTITY` int(11)
,`LOCATION` varchar(255)
,`DATE_RELEASED` date
,`REMARKS` varchar(255)
,`STATUS` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_inventory`
-- (See below for the actual view)
--
CREATE TABLE `view_inventory` (
`MATERIAL_ID` int(11)
,`MATERIAL_NAME` varchar(100)
,`QUANTITY` int(11)
,`PRICE` int(11)
,`SIZE` varchar(11)
,`MODEL` varchar(50)
,`DATE_ADDED` date
,`IS_ACTIVE` tinyint(1)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_reservation`
-- (See below for the actual view)
--
CREATE TABLE `view_reservation` (
`RESERVATION_ID` int(11)
,`MATERIAL_ID` int(11)
,`USER_ID` int(11)
,`QUANTITY` int(11)
,`PURPOSE` varchar(255)
,`RESERVATION_DATE` date
,`CLAIMING_DATE` date
,`STATUS` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_stocks_log`
-- (See below for the actual view)
--
CREATE TABLE `view_stocks_log` (
`STOCKS_ID` int(11)
,`MATERIAL_ID` int(11)
,`USER_ID` int(11)
,`QUANTITY` int(11)
,`TRANSACTION_TYPE` varchar(50)
,`TIME_AND_DATE` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_user`
-- (See below for the actual view)
--
CREATE TABLE `view_user` (
`USER_ID` int(11)
,`NAME` varchar(100)
,`AGE` int(11)
,`EMAIL` varchar(100)
,`PASSWORD` varchar(100)
);

-- --------------------------------------------------------

--
-- Structure for view `view_distribution`
--
DROP TABLE IF EXISTS `view_distribution`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_distribution`  AS SELECT `distribution`.`DISTRIBUTION_ID` AS `DISTRIBUTION_ID`, `distribution`.`MATERIAL_ID` AS `MATERIAL_ID`, `distribution`.`USER_ID` AS `USER_ID`, `distribution`.`QUANTITY` AS `QUANTITY`, `distribution`.`LOCATION` AS `LOCATION`, `distribution`.`DATE_RELEASED` AS `DATE_RELEASED`, `distribution`.`REMARKS` AS `REMARKS`, `distribution`.`STATUS` AS `STATUS` FROM `distribution` ;

-- --------------------------------------------------------

--
-- Structure for view `view_inventory`
--
DROP TABLE IF EXISTS `view_inventory`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_inventory`  AS SELECT `inventory`.`MATERIAL_ID` AS `MATERIAL_ID`, `inventory`.`MATERIAL_NAME` AS `MATERIAL_NAME`, `inventory`.`QUANTITY` AS `QUANTITY`, `inventory`.`PRICE` AS `PRICE`, `inventory`.`SIZE` AS `SIZE`, `inventory`.`MODEL` AS `MODEL`, `inventory`.`DATE_ADDED` AS `DATE_ADDED`, `inventory`.`IS_ACTIVE` AS `IS_ACTIVE` FROM `inventory` ;

-- --------------------------------------------------------

--
-- Structure for view `view_reservation`
--
DROP TABLE IF EXISTS `view_reservation`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_reservation`  AS SELECT `reservation`.`RESERVATION_ID` AS `RESERVATION_ID`, `reservation`.`MATERIAL_ID` AS `MATERIAL_ID`, `reservation`.`USER_ID` AS `USER_ID`, `reservation`.`QUANTITY` AS `QUANTITY`, `reservation`.`PURPOSE` AS `PURPOSE`, `reservation`.`RESERVATION_DATE` AS `RESERVATION_DATE`, `reservation`.`CLAIMING_DATE` AS `CLAIMING_DATE`, `reservation`.`STATUS` AS `STATUS` FROM `reservation` ;

-- --------------------------------------------------------

--
-- Structure for view `view_stocks_log`
--
DROP TABLE IF EXISTS `view_stocks_log`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_stocks_log`  AS SELECT `stocks_log`.`STOCKS_ID` AS `STOCKS_ID`, `stocks_log`.`MATERIAL_ID` AS `MATERIAL_ID`, `stocks_log`.`USER_ID` AS `USER_ID`, `stocks_log`.`QUANTITY` AS `QUANTITY`, `stocks_log`.`TRANSACTION_TYPE` AS `TRANSACTION_TYPE`, `stocks_log`.`TIME_AND_DATE` AS `TIME_AND_DATE` FROM `stocks_log` ;

-- --------------------------------------------------------

--
-- Structure for view `view_user`
--
DROP TABLE IF EXISTS `view_user`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_user`  AS SELECT `user`.`USER_ID` AS `USER_ID`, `user`.`NAME` AS `NAME`, `user`.`AGE` AS `AGE`, `user`.`EMAIL` AS `EMAIL`, `user`.`PASSWORD` AS `PASSWORD` FROM `user` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `distribution`
--
ALTER TABLE `distribution`
  ADD PRIMARY KEY (`DISTRIBUTION_ID`),
  ADD KEY `MATERIAL_ID` (`MATERIAL_ID`),
  ADD KEY `USER_ID` (`USER_ID`),
  ADD KEY `fk_distribution_reservation` (`RESERVATION_ID`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`MATERIAL_ID`);

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
  ADD PRIMARY KEY (`STOCKS_ID`),
  ADD KEY `MATERIAL_ID` (`MATERIAL_ID`),
  ADD KEY `USER_ID` (`USER_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`USER_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `distribution`
--
ALTER TABLE `distribution`
  MODIFY `DISTRIBUTION_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `MATERIAL_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `RESERVATION_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `stocks_log`
--
ALTER TABLE `stocks_log`
  MODIFY `STOCKS_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `USER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `distribution`
--
ALTER TABLE `distribution`
  ADD CONSTRAINT `distribution_ibfk_1` FOREIGN KEY (`MATERIAL_ID`) REFERENCES `inventory` (`MATERIAL_ID`),
  ADD CONSTRAINT `distribution_ibfk_2` FOREIGN KEY (`USER_ID`) REFERENCES `user` (`USER_ID`),
  ADD CONSTRAINT `fk_distribution_reservation` FOREIGN KEY (`RESERVATION_ID`) REFERENCES `reservation` (`RESERVATION_ID`);

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`MATERIAL_ID`) REFERENCES `inventory` (`MATERIAL_ID`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`USER_ID`) REFERENCES `user` (`USER_ID`);

--
-- Constraints for table `stocks_log`
--
ALTER TABLE `stocks_log`
  ADD CONSTRAINT `stocks_log_ibfk_1` FOREIGN KEY (`MATERIAL_ID`) REFERENCES `inventory` (`MATERIAL_ID`),
  ADD CONSTRAINT `stocks_log_ibfk_2` FOREIGN KEY (`USER_ID`) REFERENCES `user` (`USER_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
