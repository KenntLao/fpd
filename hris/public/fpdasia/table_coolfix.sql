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
-- Table structure for table `table_coolfix`
--

CREATE TABLE `table_coolfix` (
  `c_id` int(4) NOT NULL,
  `c_name` varchar(250) NOT NULL,
  `c_description` mediumtext NOT NULL,
  `c_icon` varchar(250) NOT NULL,
  `c_deleted` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_coolfix`
--

INSERT INTO `table_coolfix` (`c_id`, `c_name`, `c_description`, `c_icon`, `c_deleted`) VALUES
(1, 'Aircon Services', '<p>\r\n\r\nPerform preventive maintenance services of air conditioners which includes periodic cleaning of evaporators, condenser fins, filter and drain pans, check water leaks, electrical controls, thermostat, switches, and other accessories. Also conducts minor/major repairs based on the noted deficiencies of units.\r\n\r\n<br></p>', 'Air Conditioner Services.png', NULL),
(2, 'Generators Services', '<p>\r\n\r\nConduct periodic check-up before, during and after warm up to ensure unit is efficient and in normal operating condition.\r\n\r\n<br></p>', 'Generator Set Services.png', NULL),
(3, 'Electrical Repairs & Installation', '<p>\r\n\r\nTroubleshoot, repair shorted electrical circuits, replace defective parts and perform electrical rewiring works and installation.\r\n\r\n<br></p>', 'Electrical Repair & Installation.png', NULL),
(4, 'Plumbing Repairs & Installation', '<p>\r\n\r\nRepair or replace plumbing fixtures and faucets and conduct pipe fitting and declogging works.\r\n\r\n<br></p>', 'Plumbing Repair & Installation.png', NULL),
(5, 'Civil Works', '<p>\r\n\r\nPerform basic carpentry works, welding, painting ad masonry.\r\n\r\n<br></p>', 'Civil Works.png', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `table_coolfix`
--
ALTER TABLE `table_coolfix`
  ADD PRIMARY KEY (`c_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `table_coolfix`
--
ALTER TABLE `table_coolfix`
  MODIFY `c_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
