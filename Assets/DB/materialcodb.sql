-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2025 at 02:06 PM
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
  `QUANTITY` int(11) DEFAULT NULL,
  `LOCATION` varchar(255) DEFAULT NULL,
  `DATE_RELEASED` date DEFAULT NULL,
  `REMARKS` varchar(255) DEFAULT NULL,
  `STATUS` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `distribution`
--
DELIMITER $$
CREATE TRIGGER `trg_after_distribution_insert` AFTER INSERT ON `distribution` FOR EACH ROW INSERT INTO STOCKS_LOG (
    MATERIAL_ID,
    USER_ID,
    INOUT_QUANTITY,
    TYPE,
    TIME_AND_DATE
)
VALUES (
    NEW.MATERIAL_ID,
    NEW.USER_ID,
    NEW.QUANTITY,
    'OUT',
    NOW()
)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_after_distribution_update_inventory` AFTER INSERT ON `distribution` FOR EACH ROW UPDATE INVENTORY
SET QUANTITY = QUANTITY - NEW.QUANTITY
WHERE MATERIAL_ID = NEW.MATERIAL_ID
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `MATERIAL_ID` int(11) NOT NULL,
  `MATERIAL_NAME` varchar(100) DEFAULT NULL,
  `QUANTITY` int(11) DEFAULT NULL,
  `SIZE` int(11) DEFAULT NULL,
  `PRICE` double DEFAULT NULL,
  `TYPE` varchar(50) DEFAULT NULL
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
  `PURPOSE` varchar(255) DEFAULT NULL,
  `RESERVATION_DATE` date DEFAULT NULL,
  `CLAIMING_DATE` date DEFAULT NULL,
  `STATUS` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `reservation`
--
DELIMITER $$
CREATE TRIGGER `trg_after_reservation_approve` AFTER UPDATE ON `reservation` FOR EACH ROW BEGIN
    IF NEW.STATUS = 'APPROVED' AND OLD.STATUS <> 'APPROVED' THEN
        INSERT INTO DISTRIBUTION (
            MATERIAL_ID,
            USER_ID,
            QUANTITY,
            LOCATION,
            DATE_RELEASED,
            REMARKS,
            STATUS
        ) VALUES (
            NEW.MATERIAL_ID,
            NEW.USER_ID,
            NEW.QUANTITY,
            'Default Location',     -- change as needed
            CURDATE(),
            'Auto-generated from approved reservation',
            'COMPLETED'
        );
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `stocks_log`
--

CREATE TABLE `stocks_log` (
  `STOCKS_ID` int(11) NOT NULL,
  `MATERIAL_ID` int(11) DEFAULT NULL,
  `USER_ID` int(11) DEFAULT NULL,
  `INOUT_QUANTITY` int(11) DEFAULT NULL,
  `TYPE` varchar(50) DEFAULT NULL,
  `TIME_AND_DATE` datetime DEFAULT NULL
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

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_distribution`
-- (See below for the actual view)
--
CREATE TABLE `view_distribution` (
`DISTRIBUTION_ID` int(11)
,`MATERIAL_ID` int(11)
,`MATERIAL_NAME` varchar(100)
,`USER_ID` int(11)
,`USER_NAME` varchar(100)
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
,`SIZE` int(11)
,`PRICE` double
,`TYPE` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_reservation`
-- (See below for the actual view)
--
CREATE TABLE `view_reservation` (
`RESERVATION_ID` int(11)
,`MATERIAL_ID` int(11)
,`MATERIAL_NAME` varchar(100)
,`USER_ID` int(11)
,`USER_NAME` varchar(100)
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
,`MATERIAL_NAME` varchar(100)
,`USER_ID` int(11)
,`USER_NAME` varchar(100)
,`INOUT_QUANTITY` int(11)
,`TYPE` varchar(50)
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
);

-- --------------------------------------------------------

--
-- Structure for view `view_distribution`
--
DROP TABLE IF EXISTS `view_distribution`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_distribution`  AS SELECT `d`.`DISTRIBUTION_ID` AS `DISTRIBUTION_ID`, `d`.`MATERIAL_ID` AS `MATERIAL_ID`, `i`.`MATERIAL_NAME` AS `MATERIAL_NAME`, `d`.`USER_ID` AS `USER_ID`, `u`.`NAME` AS `USER_NAME`, `d`.`QUANTITY` AS `QUANTITY`, `d`.`LOCATION` AS `LOCATION`, `d`.`DATE_RELEASED` AS `DATE_RELEASED`, `d`.`REMARKS` AS `REMARKS`, `d`.`STATUS` AS `STATUS` FROM ((`distribution` `d` join `user` `u` on(`d`.`USER_ID` = `u`.`USER_ID`)) join `inventory` `i` on(`d`.`MATERIAL_ID` = `i`.`MATERIAL_ID`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view_inventory`
--
DROP TABLE IF EXISTS `view_inventory`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_inventory`  AS SELECT `inventory`.`MATERIAL_ID` AS `MATERIAL_ID`, `inventory`.`MATERIAL_NAME` AS `MATERIAL_NAME`, `inventory`.`QUANTITY` AS `QUANTITY`, `inventory`.`SIZE` AS `SIZE`, `inventory`.`PRICE` AS `PRICE`, `inventory`.`TYPE` AS `TYPE` FROM `inventory` ;

-- --------------------------------------------------------

--
-- Structure for view `view_reservation`
--
DROP TABLE IF EXISTS `view_reservation`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_reservation`  AS SELECT `r`.`RESERVATION_ID` AS `RESERVATION_ID`, `r`.`MATERIAL_ID` AS `MATERIAL_ID`, `i`.`MATERIAL_NAME` AS `MATERIAL_NAME`, `r`.`USER_ID` AS `USER_ID`, `u`.`NAME` AS `USER_NAME`, `r`.`QUANTITY` AS `QUANTITY`, `r`.`PURPOSE` AS `PURPOSE`, `r`.`RESERVATION_DATE` AS `RESERVATION_DATE`, `r`.`CLAIMING_DATE` AS `CLAIMING_DATE`, `r`.`STATUS` AS `STATUS` FROM ((`reservation` `r` join `user` `u` on(`r`.`USER_ID` = `u`.`USER_ID`)) join `inventory` `i` on(`r`.`MATERIAL_ID` = `i`.`MATERIAL_ID`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view_stocks_log`
--
DROP TABLE IF EXISTS `view_stocks_log`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_stocks_log`  AS SELECT `sl`.`STOCKS_ID` AS `STOCKS_ID`, `sl`.`MATERIAL_ID` AS `MATERIAL_ID`, `i`.`MATERIAL_NAME` AS `MATERIAL_NAME`, `sl`.`USER_ID` AS `USER_ID`, `u`.`NAME` AS `USER_NAME`, `sl`.`INOUT_QUANTITY` AS `INOUT_QUANTITY`, `sl`.`TYPE` AS `TYPE`, `sl`.`TIME_AND_DATE` AS `TIME_AND_DATE` FROM ((`stocks_log` `sl` join `user` `u` on(`sl`.`USER_ID` = `u`.`USER_ID`)) join `inventory` `i` on(`sl`.`MATERIAL_ID` = `i`.`MATERIAL_ID`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view_user`
--
DROP TABLE IF EXISTS `view_user`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_user`  AS SELECT `user`.`USER_ID` AS `USER_ID`, `user`.`NAME` AS `NAME`, `user`.`AGE` AS `AGE`, `user`.`EMAIL` AS `EMAIL` FROM `user` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `distribution`
--
ALTER TABLE `distribution`
  ADD PRIMARY KEY (`DISTRIBUTION_ID`),
  ADD KEY `MATERIAL_ID` (`MATERIAL_ID`),
  ADD KEY `USER_ID` (`USER_ID`);

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
  MODIFY `DISTRIBUTION_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `MATERIAL_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `RESERVATION_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stocks_log`
--
ALTER TABLE `stocks_log`
  MODIFY `STOCKS_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `USER_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `distribution`
--
ALTER TABLE `distribution`
  ADD CONSTRAINT `distribution_ibfk_1` FOREIGN KEY (`MATERIAL_ID`) REFERENCES `inventory` (`MATERIAL_ID`),
  ADD CONSTRAINT `distribution_ibfk_2` FOREIGN KEY (`USER_ID`) REFERENCES `user` (`USER_ID`);

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
