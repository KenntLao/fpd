-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2019 at 09:34 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fpdasia_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `table_engineering_services`
--

CREATE TABLE `table_engineering_services` (
  `es_id` int(4) NOT NULL,
  `es_name` varchar(250) NOT NULL,
  `es_description` mediumtext NOT NULL,
  `es_icon` varchar(250) NOT NULL,
  `es_deleted` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_engineering_services`
--

INSERT INTO `table_engineering_services` (`es_id`, `es_name`, `es_description`, `es_icon`, `es_deleted`) VALUES
(2, 'Technical & Safety Audit', '<p>\r\n\r\nInspect, calibrate and test all equipment and facilities to ensure a well maintained, fully functioning equipment which conform to the highest operational and safety standards.\r\n\r\n<br></p>', 'Technical &  Safety.png', NULL),
(3, 'Electrical Audit', '<p>\r\n\r\nExamine safety &amp; efficiency of electrical installations of any industrial, commercial, office, residential unit &amp; other buildings. It is performed by data gathering, inspection, testing and verification. Electrical Audit is conducted by experienced professionals with the aim of reducing risk and ensuring safety in compliance with Philippine Electrical Code &amp; other relevant standards.\r\n\r\n<br></p>', 'Electrical Audit.png', NULL),
(4, 'Power Quality Audit', '<p>\r\n\r\nDetect power disturbances such as dips, swell, transient, harmonics, unbalance, over voltage, under voltage and power interruption using power quality analyzer. It is also equipped with advanced power quality functions and energy monetization capability that will enable you to identify energy saving solutions.\r\n\r\n<br></p>', 'Power Quality Audit.png', NULL),
(5, 'Electrical Thermal Scanning', '<p>\r\n\r\nCheck equipmentâ€™ temperature and identify hotspots using an infrared imaging camera. This is likewise undertaken to ensure that the equipment is working properly without disrupting normal operations and to ensure safety from equipment breakdowns.\r\n\r\n<br></p>', 'Thermal Scanning.png', NULL),
(6, 'Vetting', '<p>\r\n\r\nVerify actual implementation of the construction based from the appoved construction plan of a house or unit in a building.\r\n\r\n<br></p>', 'Vetting.png', NULL),
(7, 'Fit-Out Management', '<p>\r\n\r\nMonitors construction of a unit based on the approved plans and specifications.\r\n\r\n<br></p>', 'Fit-Out Management.png', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `table_engineering_services`
--
ALTER TABLE `table_engineering_services`
  ADD PRIMARY KEY (`es_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `table_engineering_services`
--
ALTER TABLE `table_engineering_services`
  MODIFY `es_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
