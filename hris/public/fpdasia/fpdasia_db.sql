-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 03, 2019 at 10:50 AM
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
-- Database: `db_fpdasia`
--

-- --------------------------------------------------------

--
-- Table structure for table `table_events`
--

CREATE TABLE `table_events` (
  `events_id` int(20) NOT NULL,
  `events_image` varchar(250) NOT NULL,
  `events_title` varchar(250) NOT NULL,
  `events_date` date NOT NULL,
  `events_caption` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_events`
--

INSERT INTO `table_events` (`events_id`, `events_image`, `events_title`, `events_date`, `events_caption`) VALUES
(1, 'events/01.jpg', '2014 Fourth Quarter Birthday Celebrations', '2014-12-23', 'October, November and December birthday celebrants feasted together at the 4th Quarter Birthday Brunch with FPD Asiaâ€™s Director and General Manager.'),
(2, 'events/02.jpg', 'FPD Asia Celebrated Christmas in Hollywood Style', '2019-08-05', 'FPD Asia gamely dressed up in various Hollywood characters to celebrate Christmas in a fab and fun way!'),
(3, 'events/03.jpg', 'FPD Asia Trained under DOLE for Occupational Health & Safety', '2014-12-01', 'With high regard for peopleâ€™s health and safety, FPD Asia participated in the Department of Labor and Employmentâ€™s (DOLE) Basic Occupational Health and Safety Training.'),
(4, 'events/04.jpg', 'Technical Knowledge Upgraded', '2014-11-22', 'FPD Asiaâ€™s Engineering Services Division conducted a Technical Seminar to upgrade the knowledge of technical personnel.'),
(5, 'events/05.jpg', 'Trainers Trained!', '2014-11-18', 'As people who are always client-facing, FPD Asia employees enjoyed learning about and exercising the differences between reporting, presenting and facilitating through the Train the Trainer Training, in partnership with LinkOD Training & Consulting.'),
(6, 'events/06.jpg', 'FPD Asia Joined TNGâ€™s Christmas Chorale Competition', '2014-11-06', 'FPD Asia formed a chorale that has been named The Voice of FPD Asia and joined The Net Groupâ€™s 4th Christmas Chorale Competition.');

-- --------------------------------------------------------

--
-- Table structure for table `table_gallery`
--

CREATE TABLE `table_gallery` (
  `gallery_id` int(4) NOT NULL,
  `gallery_image` varchar(250) NOT NULL,
  `gallery_name` varchar(250) NOT NULL,
  `gallery_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_gallery`
--

INSERT INTO `table_gallery` (`gallery_id`, `gallery_image`, `gallery_name`, `gallery_date`) VALUES
(1, 'gallery/22728650_1675321042512073_3696660235526301179_n.jpg', 'Corporate Social Responsibilty Fun Run', '2017-10-01'),
(2, 'gallery/2019 Corporate Social Responsibility.PNG', 'Corporate Social Responsibilty Repainting with Gawad Kalinga', '2019-06-01'),
(3, 'gallery/IMG_7679.jpg', 'FPD Asia Christmas Party', '2018-12-01'),
(4, 'gallery/IMG_20190329_163759.jpg', 'Fire Drill and Seminar ', '2019-03-01'),
(5, 'gallery/IMG_20190301_172204.jpg', 'FPD Asia Cares Team Building ', '2019-03-01'),
(6, 'gallery/Earth Hour 2019.PNG', 'FPD Asia Earth Hour Participation', '2019-03-30'),
(7, 'gallery/H&W.jpg', 'Health and Wellness', '2019-08-16'),
(8, 'gallery/IMG_20190326_173042.jpg', 'Training BOSH 1st Quarter ', '2019-03-26'),
(9, 'gallery/IMG_20190321_152308.jpg', 'Training MOBE 1st Quarter', '2019-03-21');

-- --------------------------------------------------------

--
-- Table structure for table `table_gallery_images`
--

CREATE TABLE `table_gallery_images` (
  `id` int(4) NOT NULL,
  `gallery_id` int(4) NOT NULL,
  `images` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_gallery_images`
--

INSERT INTO `table_gallery_images` (`id`, `gallery_id`, `images`) VALUES
(1, 1, 'gallery/22728650_1675321042512073_3696660235526301179_n.jpg'),
(2, 1, 'gallery/22789081_1675321152512062_3091466829048993850_n.jpg'),
(3, 2, 'gallery/_DSC7715.JPG'),
(4, 2, 'gallery/_DSC7722.JPG'),
(5, 2, 'gallery/_DSC7737.JPG'),
(6, 2, 'gallery/_DSC7791.JPG'),
(7, 2, 'gallery/_DSC7818.JPG'),
(8, 2, 'gallery/_DSC7898.JPG'),
(9, 2, 'gallery/_DSC7914.JPG'),
(10, 2, 'gallery/2019 Corporate Social Responsibility.PNG'),
(11, 2, 'gallery/62238348_2441671825895173_1375150899277594624_n.jpg'),
(13, 2, 'gallery/64962295_10219522416388921_691532611314515968_n.jpg'),
(14, 2, 'gallery/65193484_2322595084520391_7852738889121792000_n.jpg'),
(15, 2, 'gallery/65202145_10219522418188966_725878923614748672_n.jpg'),
(17, 2, 'gallery/65296913_1617184501750375_844084218966310912_n.jpg'),
(18, 2, 'gallery/65613793_1117857341743414_746000707957555200_n.jpg'),
(19, 3, 'gallery/IMG_6899.jpg'),
(20, 3, 'gallery/IMG_7041.jpg'),
(21, 3, 'gallery/IMG_7052.jpg'),
(22, 3, 'gallery/IMG_7111.jpg'),
(23, 3, 'gallery/IMG_7130.jpg'),
(24, 3, 'gallery/IMG_7192.jpg'),
(25, 3, 'gallery/IMG_7223.jpg'),
(26, 3, 'gallery/IMG_7284.jpg'),
(27, 3, 'gallery/IMG_7285.jpg'),
(28, 3, 'gallery/IMG_7643.jpg'),
(29, 3, 'gallery/IMG_7644.jpg'),
(30, 3, 'gallery/IMG_7663.jpg'),
(31, 3, 'gallery/IMG_7670.jpg'),
(32, 3, 'gallery/IMG_7679.jpg'),
(33, 4, 'gallery/IMG_20190329_144753.jpg'),
(34, 4, 'gallery/IMG_20190329_163544.jpg'),
(35, 4, 'gallery/IMG_20190329_163759.jpg'),
(36, 4, 'gallery/IMG_20190329_170728.jpg'),
(37, 4, 'gallery/IMG_20190329_172023.jpg'),
(38, 5, 'gallery/IMG_20190301_102621.jpg'),
(39, 5, 'gallery/IMG_20190301_103203.jpg'),
(40, 5, 'gallery/IMG_20190301_103205.jpg'),
(41, 5, 'gallery/IMG_20190301_103208.jpg'),
(42, 5, 'gallery/IMG_20190301_104253.jpg'),
(43, 5, 'gallery/IMG_20190301_104314.jpg'),
(44, 5, 'gallery/IMG_20190301_104359.jpg'),
(45, 5, 'gallery/IMG_20190301_105033.jpg'),
(46, 5, 'gallery/IMG_20190301_105506.jpg'),
(47, 5, 'gallery/IMG_20190301_105722.jpg'),
(48, 5, 'gallery/IMG_20190301_110758.jpg'),
(49, 5, 'gallery/IMG_20190301_172204.jpg'),
(50, 6, 'gallery/Earth Hour 2019.PNG'),
(51, 6, 'gallery/Renaissance.JPG'),
(52, 6, 'gallery/Renaissance1.JPG'),
(53, 6, 'gallery/Renaissance2.JPG'),
(54, 7, 'gallery/H&W.jpg'),
(55, 7, 'gallery/H&W1.jpg'),
(56, 7, 'gallery/H&W2.jpg'),
(57, 8, 'gallery/IMG_20190326_173042.jpg'),
(58, 8, 'gallery/IMG_20190326_173048.jpg'),
(59, 8, 'gallery/IMG_20190326_173059.jpg'),
(60, 9, 'gallery/IMG_20190321_152308.jpg'),
(61, 9, 'gallery/MOBE 1.1_20190321.jpg'),
(62, 9, 'gallery/MOBE 1.2_20190321.jpg'),
(63, 9, 'gallery/MOBE 1.3_20190321.jpg'),
(64, 9, 'gallery/MOBE 1.4_20190321.jpg'),
(65, 9, 'gallery/MOBE 1_20190321.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `table_home_slider`
--

CREATE TABLE `table_home_slider` (
  `home_slider_id` int(9) NOT NULL,
  `home_slider_image` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_home_slider`
--

INSERT INTO `table_home_slider` (`home_slider_id`, `home_slider_image`) VALUES
(2, 'slider/Home-Banner-2.jpg'),
(3, 'slider/Home-Banner-3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `table_press_releases`
--

CREATE TABLE `table_press_releases` (
  `press_releases_id` int(20) NOT NULL,
  `press_releases_image` varchar(100) NOT NULL,
  `press_releases_name` varchar(250) NOT NULL,
  `press_releases_newspaper` varchar(250) NOT NULL,
  `press_releases_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_press_releases`
--

INSERT INTO `table_press_releases` (`press_releases_id`, `press_releases_image`, `press_releases_name`, `press_releases_newspaper`, `press_releases_date`) VALUES
(8, 'press-releases/FPD Asia enhances property values with sound management.jpg', 'FPD Asia enhances property values with sound management', 'South China Morning Post', '2019-06-12'),
(9, 'press-releases/Two E-Com Center Management.jpg', 'Two E-Com Center Management', 'The Philippine Star', '2013-06-21'),
(10, 'press-releases/FPD Asia Teams up with W Tower-Malaya.jpg', 'FPD Asia Teams up with W Tower-Malaya', 'The Philippine Star', '2009-11-06'),
(12, 'press-releases/FPD To Manage SM Lands Two E-Com Center.jpg', 'FPD To Manage SM Lands Two E-Com Center', 'Manila Bulletin and Business Bulletin', '2013-06-14'),
(13, 'press-releases/FPD Asia Teams up with W Tower-Malaya.jpg', 'FPD Asia Teams up with W Tower-Malaya', 'Malaya', '2009-07-10'),
(14, 'press-releases/Robinson Land Taps FPD Asia.jpg', 'Robinson Land Taps FPD Asia', 'The Philippine Star and Business Section', '2012-02-08'),
(15, 'press-releases/FPD Asia Teams up with Seibu.jpg', 'FPD Asia Teams up with Seibu', 'Business World', '2009-03-03'),
(16, 'press-releases/FPD Asia Property Services is now ISO 9001-2008 Certified.jpg', 'FPD Asia Property Services is now ISO 9001-2008 Certified', 'Philippine Daily Inquirer and Business Section', '2011-05-16'),
(17, 'press-releases/FPD Asia Teams up with Seibu-Manila Bulletin.jpg', 'FPD Asia Teams up with Seibu-Manila Bulletin', 'Manila Bulletin', '2009-02-23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `table_events`
--
ALTER TABLE `table_events`
  ADD PRIMARY KEY (`events_id`);

--
-- Indexes for table `table_gallery`
--
ALTER TABLE `table_gallery`
  ADD PRIMARY KEY (`gallery_id`);

--
-- Indexes for table `table_gallery_images`
--
ALTER TABLE `table_gallery_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_home_slider`
--
ALTER TABLE `table_home_slider`
  ADD PRIMARY KEY (`home_slider_id`);

--
-- Indexes for table `table_press_releases`
--
ALTER TABLE `table_press_releases`
  ADD PRIMARY KEY (`press_releases_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `table_events`
--
ALTER TABLE `table_events`
  MODIFY `events_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `table_gallery`
--
ALTER TABLE `table_gallery`
  MODIFY `gallery_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `table_gallery_images`
--
ALTER TABLE `table_gallery_images`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `table_home_slider`
--
ALTER TABLE `table_home_slider`
  MODIFY `home_slider_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `table_press_releases`
--
ALTER TABLE `table_press_releases`
  MODIFY `press_releases_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
