-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 27, 2020 at 04:11 AM
-- Server version: 5.7.24
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `amenities`
--

DROP TABLE IF EXISTS `amenities`;
CREATE TABLE IF NOT EXISTS `amenities` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `sub_property_id` bigint(255) NOT NULL DEFAULT '0',
  `date` varchar(250) NOT NULL,
  `venue` varchar(500) NOT NULL,
  `subject` varchar(250) NOT NULL,
  `project_name` varchar(250) NOT NULL,
  `time_started_end` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL DEFAULT '0',
  `temp_del` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `boardrooms`
--

DROP TABLE IF EXISTS `boardrooms`;
CREATE TABLE IF NOT EXISTS `boardrooms` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `sub_property_id` bigint(255) NOT NULL DEFAULT '0',
  `date_reserve` varchar(250) NOT NULL,
  `time_from` varchar(255) NOT NULL,
  `time_to` varchar(255) NOT NULL,
  `department` varchar(500) NOT NULL,
  `room` varchar(255) NOT NULL,
  `purpose` varchar(250) NOT NULL,
  `reserved_by` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL DEFAULT '0',
  `temp_del` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `calibrations`
--

DROP TABLE IF EXISTS `calibrations`;
CREATE TABLE IF NOT EXISTS `calibrations` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `sub_property_id` bigint(255) NOT NULL,
  `prepared_by` bigint(255) DEFAULT NULL,
  `account_mode` varchar(255) NOT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `date_created` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT '0',
  `temp_del` varchar(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `calibration_monitoring`
--

DROP TABLE IF EXISTS `calibration_monitoring`;
CREATE TABLE IF NOT EXISTS `calibration_monitoring` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `calibration_id` bigint(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `equipment` varchar(255) NOT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `serial_number` varchar(255) DEFAULT NULL,
  `date_calibrated` varchar(255) DEFAULT NULL,
  `frequency` varchar(255) DEFAULT NULL,
  `accepted_tolerance` varchar(255) DEFAULT NULL,
  `next_calibration_date` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `calibration_plan`
--

DROP TABLE IF EXISTS `calibration_plan`;
CREATE TABLE IF NOT EXISTS `calibration_plan` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `calibration_id` bigint(255) NOT NULL,
  `instrument` varchar(255) NOT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `serial_number` varchar(255) DEFAULT NULL,
  `date_calibrated` varchar(255) DEFAULT NULL,
  `due_date_calibration` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cancelled_collection`
--

DROP TABLE IF EXISTS `cancelled_collection`;
CREATE TABLE IF NOT EXISTS `cancelled_collection` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `collection_id` bigint(255) NOT NULL,
  `attachment` varchar(1000) NOT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  `user_id` bigint(255) NOT NULL,
  `account_mode` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `check_voucher`
--

DROP TABLE IF EXISTS `check_voucher`;
CREATE TABLE IF NOT EXISTS `check_voucher` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `property_id` bigint(255) NOT NULL,
  `date` varchar(55) DEFAULT NULL,
  `reference_number` varchar(255) DEFAULT NULL,
  `bank` int(10) DEFAULT NULL,
  `other_bank` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `check_number` varchar(255) DEFAULT NULL,
  `particulars` varchar(1000) DEFAULT NULL,
  `payee` varchar(500) DEFAULT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `client_id` varchar(20) NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `contact_person` varchar(100) NOT NULL DEFAULT '',
  `contact_details` varchar(100) NOT NULL DEFAULT '',
  `status` int(1) NOT NULL DEFAULT '0',
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clusters`
--

DROP TABLE IF EXISTS `clusters`;
CREATE TABLE IF NOT EXISTS `clusters` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `cluster_name` varchar(255) NOT NULL,
  `assigned` bigint(255) DEFAULT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `collection_undeposited`
--

DROP TABLE IF EXISTS `collection_undeposited`;
CREATE TABLE IF NOT EXISTS `collection_undeposited` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `sub_property_id` bigint(255) NOT NULL,
  `collection_date` varchar(255) NOT NULL,
  `grand_total` varchar(255) NOT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `module` varchar(255) NOT NULL,
  `module_type` varchar(255) NOT NULL,
  `module_id` bigint(255) NOT NULL,
  `comment` varchar(1000) DEFAULT NULL,
  `comment_date` varchar(255) NOT NULL,
  `user_id` bigint(255) NOT NULL,
  `user_account_mode` varchar(255) DEFAULT NULL,
  `seen_by` varchar(10000) DEFAULT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `commercial_unit_types`
--

DROP TABLE IF EXISTS `commercial_unit_types`;
CREATE TABLE IF NOT EXISTS `commercial_unit_types` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `commercial_unit_type` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `contract`
--

DROP TABLE IF EXISTS `contract`;
CREATE TABLE IF NOT EXISTS `contract` (
  `id` bigint(250) NOT NULL AUTO_INCREMENT,
  `prospect_id` bigint(250) NOT NULL,
  `acquisition_date` varchar(255) NOT NULL,
  `renewal_date` varchar(250) NOT NULL,
  `contract_contact_person` varchar(250) NOT NULL,
  `contact_number` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT '0',
  `term_of_payment` int(20) NOT NULL DEFAULT '0',
  `advance_payment` varchar(255) DEFAULT NULL,
  `number_of_month` varchar(255) DEFAULT NULL,
  `attachment` varchar(10000) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `security_deposit` varchar(250) DEFAULT NULL,
  `mode_of_payment` varchar(250) DEFAULT NULL,
  `contract_duration` int(10) DEFAULT '0',
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `num_code` int(3) NOT NULL DEFAULT '0',
  `alpha_2_code` varchar(2) DEFAULT NULL,
  `alpha_3_code` varchar(3) DEFAULT NULL,
  `en_short_name` varchar(52) DEFAULT NULL,
  `nationality` varchar(39) DEFAULT NULL,
  PRIMARY KEY (`num_code`),
  UNIQUE KEY `alpha_2_code` (`alpha_2_code`),
  UNIQUE KEY `alpha_3_code` (`alpha_3_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`num_code`, `alpha_2_code`, `alpha_3_code`, `en_short_name`, `nationality`) VALUES
(4, 'AF', 'AFG', 'Afghanistan', 'Afghan'),
(8, 'AL', 'ALB', 'Albania', 'Albanian'),
(10, 'AQ', 'ATA', 'Antarctica', 'Antarctic'),
(12, 'DZ', 'DZA', 'Algeria', 'Algerian'),
(16, 'AS', 'ASM', 'American Samoa', 'American Samoan'),
(20, 'AD', 'AND', 'Andorra', 'Andorran'),
(24, 'AO', 'AGO', 'Angola', 'Angolan'),
(28, 'AG', 'ATG', 'Antigua and Barbuda', 'Antiguan or Barbudan'),
(31, 'AZ', 'AZE', 'Azerbaijan', 'Azerbaijani, Azeri'),
(32, 'AR', 'ARG', 'Argentina', 'Argentine'),
(36, 'AU', 'AUS', 'Australia', 'Australian'),
(40, 'AT', 'AUT', 'Austria', 'Austrian'),
(44, 'BS', 'BHS', 'Bahamas', 'Bahamian'),
(48, 'BH', 'BHR', 'Bahrain', 'Bahraini'),
(50, 'BD', 'BGD', 'Bangladesh', 'Bangladeshi'),
(51, 'AM', 'ARM', 'Armenia', 'Armenian'),
(52, 'BB', 'BRB', 'Barbados', 'Barbadian'),
(56, 'BE', 'BEL', 'Belgium', 'Belgian'),
(60, 'BM', 'BMU', 'Bermuda', 'Bermudian, Bermudan'),
(64, 'BT', 'BTN', 'Bhutan', 'Bhutanese'),
(68, 'BO', 'BOL', 'Bolivia (Plurinational State of)', 'Bolivian'),
(70, 'BA', 'BIH', 'Bosnia and Herzegovina', 'Bosnian or Herzegovinian'),
(72, 'BW', 'BWA', 'Botswana', 'Motswana, Botswanan'),
(74, 'BV', 'BVT', 'Bouvet Island', 'Bouvet Island'),
(76, 'BR', 'BRA', 'Brazil', 'Brazilian'),
(84, 'BZ', 'BLZ', 'Belize', 'Belizean'),
(86, 'IO', 'IOT', 'British Indian Ocean Territory', 'BIOT'),
(90, 'SB', 'SLB', 'Solomon Islands', 'Solomon Island'),
(92, 'VG', 'VGB', 'Virgin Islands (British)', 'British Virgin Island'),
(96, 'BN', 'BRN', 'Brunei Darussalam', 'Bruneian'),
(100, 'BG', 'BGR', 'Bulgaria', 'Bulgarian'),
(104, 'MM', 'MMR', 'Myanmar', 'Burmese'),
(108, 'BI', 'BDI', 'Burundi', 'Burundian'),
(112, 'BY', 'BLR', 'Belarus', 'Belarusian'),
(116, 'KH', 'KHM', 'Cambodia', 'Cambodian'),
(120, 'CM', 'CMR', 'Cameroon', 'Cameroonian'),
(124, 'CA', 'CAN', 'Canada', 'Canadian'),
(132, 'CV', 'CPV', 'Cabo Verde', 'Cabo Verdean'),
(136, 'KY', 'CYM', 'Cayman Islands', 'Caymanian'),
(140, 'CF', 'CAF', 'Central African Republic', 'Central African'),
(144, 'LK', 'LKA', 'Sri Lanka', 'Sri Lankan'),
(148, 'TD', 'TCD', 'Chad', 'Chadian'),
(152, 'CL', 'CHL', 'Chile', 'Chilean'),
(156, 'CN', 'CHN', 'China', 'Chinese'),
(158, 'TW', 'TWN', 'Taiwan, Province of China', 'Chinese, Taiwanese'),
(162, 'CX', 'CXR', 'Christmas Island', 'Christmas Island'),
(166, 'CC', 'CCK', 'Cocos (Keeling) Islands', 'Cocos Island'),
(170, 'CO', 'COL', 'Colombia', 'Colombian'),
(174, 'KM', 'COM', 'Comoros', 'Comoran, Comorian'),
(175, 'YT', 'MYT', 'Mayotte', 'Mahoran'),
(178, 'CG', 'COG', 'Congo (Republic of the)', 'Congolese'),
(180, 'CD', 'COD', 'Congo (Democratic Republic of the)', 'Congolese'),
(184, 'CK', 'COK', 'Cook Islands', 'Cook Island'),
(188, 'CR', 'CRI', 'Costa Rica', 'Costa Rican'),
(191, 'HR', 'HRV', 'Croatia', 'Croatian'),
(192, 'CU', 'CUB', 'Cuba', 'Cuban'),
(196, 'CY', 'CYP', 'Cyprus', 'Cypriot'),
(203, 'CZ', 'CZE', 'Czech Republic', 'Czech'),
(204, 'BJ', 'BEN', 'Benin', 'Beninese, Beninois'),
(208, 'DK', 'DNK', 'Denmark', 'Danish'),
(212, 'DM', 'DMA', 'Dominica', 'Dominican'),
(214, 'DO', 'DOM', 'Dominican Republic', 'Dominican'),
(218, 'EC', 'ECU', 'Ecuador', 'Ecuadorian'),
(222, 'SV', 'SLV', 'El Salvador', 'Salvadoran'),
(226, 'GQ', 'GNQ', 'Equatorial Guinea', 'Equatorial Guinean, Equatoguinean'),
(231, 'ET', 'ETH', 'Ethiopia', 'Ethiopian'),
(232, 'ER', 'ERI', 'Eritrea', 'Eritrean'),
(233, 'EE', 'EST', 'Estonia', 'Estonian'),
(234, 'FO', 'FRO', 'Faroe Islands', 'Faroese'),
(238, 'FK', 'FLK', 'Falkland Islands (Malvinas)', 'Falkland Island'),
(239, 'GS', 'SGS', 'South Georgia and the South Sandwich Islands', 'South Georgia or South Sandwich Islands'),
(242, 'FJ', 'FJI', 'Fiji', 'Fijian'),
(246, 'FI', 'FIN', 'Finland', 'Finnish'),
(248, 'AX', 'ALA', 'Åland Islands', 'Åland Island'),
(250, 'FR', 'FRA', 'France', 'French'),
(254, 'GF', 'GUF', 'French Guiana', 'French Guianese'),
(258, 'PF', 'PYF', 'French Polynesia', 'French Polynesian'),
(260, 'TF', 'ATF', 'French Southern Territories', 'French Southern Territories'),
(262, 'DJ', 'DJI', 'Djibouti', 'Djiboutian'),
(266, 'GA', 'GAB', 'Gabon', 'Gabonese'),
(268, 'GE', 'GEO', 'Georgia', 'Georgian'),
(270, 'GM', 'GMB', 'Gambia', 'Gambian'),
(275, 'PS', 'PSE', 'Palestine, State of', 'Palestinian'),
(276, 'DE', 'DEU', 'Germany', 'German'),
(288, 'GH', 'GHA', 'Ghana', 'Ghanaian'),
(292, 'GI', 'GIB', 'Gibraltar', 'Gibraltar'),
(296, 'KI', 'KIR', 'Kiribati', 'I-Kiribati'),
(300, 'GR', 'GRC', 'Greece', 'Greek, Hellenic'),
(304, 'GL', 'GRL', 'Greenland', 'Greenlandic'),
(308, 'GD', 'GRD', 'Grenada', 'Grenadian'),
(312, 'GP', 'GLP', 'Guadeloupe', 'Guadeloupe'),
(316, 'GU', 'GUM', 'Guam', 'Guamanian, Guambat'),
(320, 'GT', 'GTM', 'Guatemala', 'Guatemalan'),
(324, 'GN', 'GIN', 'Guinea', 'Guinean'),
(328, 'GY', 'GUY', 'Guyana', 'Guyanese'),
(332, 'HT', 'HTI', 'Haiti', 'Haitian'),
(334, 'HM', 'HMD', 'Heard Island and McDonald Islands', 'Heard Island or McDonald Islands'),
(336, 'VA', 'VAT', 'Vatican City State', 'Vatican'),
(340, 'HN', 'HND', 'Honduras', 'Honduran'),
(344, 'HK', 'HKG', 'Hong Kong', 'Hong Kong, Hong Kongese'),
(348, 'HU', 'HUN', 'Hungary', 'Hungarian, Magyar'),
(352, 'IS', 'ISL', 'Iceland', 'Icelandic'),
(356, 'IN', 'IND', 'India', 'Indian'),
(360, 'ID', 'IDN', 'Indonesia', 'Indonesian'),
(364, 'IR', 'IRN', 'Iran', 'Iranian, Persian'),
(368, 'IQ', 'IRQ', 'Iraq', 'Iraqi'),
(372, 'IE', 'IRL', 'Ireland', 'Irish'),
(376, 'IL', 'ISR', 'Israel', 'Israeli'),
(380, 'IT', 'ITA', 'Italy', 'Italian'),
(384, 'CI', 'CIV', 'Côte d\'Ivoire', 'Ivorian'),
(388, 'JM', 'JAM', 'Jamaica', 'Jamaican'),
(392, 'JP', 'JPN', 'Japan', 'Japanese'),
(398, 'KZ', 'KAZ', 'Kazakhstan', 'Kazakhstani, Kazakh'),
(400, 'JO', 'JOR', 'Jordan', 'Jordanian'),
(404, 'KE', 'KEN', 'Kenya', 'Kenyan'),
(408, 'KP', 'PRK', 'Korea (Democratic People\'s Republic of)', 'North Korean'),
(410, 'KR', 'KOR', 'Korea (Republic of)', 'South Korean'),
(414, 'KW', 'KWT', 'Kuwait', 'Kuwaiti'),
(417, 'KG', 'KGZ', 'Kyrgyzstan', 'Kyrgyzstani, Kyrgyz, Kirgiz, Kirghiz'),
(418, 'LA', 'LAO', 'Lao People\'s Democratic Republic', 'Lao, Laotian'),
(422, 'LB', 'LBN', 'Lebanon', 'Lebanese'),
(426, 'LS', 'LSO', 'Lesotho', 'Basotho'),
(428, 'LV', 'LVA', 'Latvia', 'Latvian'),
(430, 'LR', 'LBR', 'Liberia', 'Liberian'),
(434, 'LY', 'LBY', 'Libya', 'Libyan'),
(438, 'LI', 'LIE', 'Liechtenstein', 'Liechtenstein'),
(440, 'LT', 'LTU', 'Lithuania', 'Lithuanian'),
(442, 'LU', 'LUX', 'Luxembourg', 'Luxembourg, Luxembourgish'),
(446, 'MO', 'MAC', 'Macao', 'Macanese, Chinese'),
(450, 'MG', 'MDG', 'Madagascar', 'Malagasy'),
(454, 'MW', 'MWI', 'Malawi', 'Malawian'),
(458, 'MY', 'MYS', 'Malaysia', 'Malaysian'),
(462, 'MV', 'MDV', 'Maldives', 'Maldivian'),
(466, 'ML', 'MLI', 'Mali', 'Malian, Malinese'),
(470, 'MT', 'MLT', 'Malta', 'Maltese'),
(474, 'MQ', 'MTQ', 'Martinique', 'Martiniquais, Martinican'),
(478, 'MR', 'MRT', 'Mauritania', 'Mauritanian'),
(480, 'MU', 'MUS', 'Mauritius', 'Mauritian'),
(484, 'MX', 'MEX', 'Mexico', 'Mexican'),
(492, 'MC', 'MCO', 'Monaco', 'Monégasque, Monacan'),
(496, 'MN', 'MNG', 'Mongolia', 'Mongolian'),
(498, 'MD', 'MDA', 'Moldova (Republic of)', 'Moldovan'),
(499, 'ME', 'MNE', 'Montenegro', 'Montenegrin'),
(500, 'MS', 'MSR', 'Montserrat', 'Montserratian'),
(504, 'MA', 'MAR', 'Morocco', 'Moroccan'),
(508, 'MZ', 'MOZ', 'Mozambique', 'Mozambican'),
(512, 'OM', 'OMN', 'Oman', 'Omani'),
(516, 'NA', 'NAM', 'Namibia', 'Namibian'),
(520, 'NR', 'NRU', 'Nauru', 'Nauruan'),
(524, 'NP', 'NPL', 'Nepal', 'Nepali, Nepalese'),
(528, 'NL', 'NLD', 'Netherlands', 'Dutch, Netherlandic'),
(531, 'CW', 'CUW', 'Curaçao', 'Curaçaoan'),
(533, 'AW', 'ABW', 'Aruba', 'Aruban'),
(534, 'SX', 'SXM', 'Sint Maarten (Dutch part)', 'Sint Maarten'),
(535, 'BQ', 'BES', 'Bonaire, Sint Eustatius and Saba', 'Bonaire'),
(540, 'NC', 'NCL', 'New Caledonia', 'New Caledonian'),
(548, 'VU', 'VUT', 'Vanuatu', 'Ni-Vanuatu, Vanuatuan'),
(554, 'NZ', 'NZL', 'New Zealand', 'New Zealand, NZ'),
(558, 'NI', 'NIC', 'Nicaragua', 'Nicaraguan'),
(562, 'NE', 'NER', 'Niger', 'Nigerien'),
(566, 'NG', 'NGA', 'Nigeria', 'Nigerian'),
(570, 'NU', 'NIU', 'Niue', 'Niuean'),
(574, 'NF', 'NFK', 'Norfolk Island', 'Norfolk Island'),
(578, 'NO', 'NOR', 'Norway', 'Norwegian'),
(580, 'MP', 'MNP', 'Northern Mariana Islands', 'Northern Marianan'),
(581, 'UM', 'UMI', 'United States Minor Outlying Islands', 'American'),
(583, 'FM', 'FSM', 'Micronesia (Federated States of)', 'Micronesian'),
(584, 'MH', 'MHL', 'Marshall Islands', 'Marshallese'),
(585, 'PW', 'PLW', 'Palau', 'Palauan'),
(586, 'PK', 'PAK', 'Pakistan', 'Pakistani'),
(591, 'PA', 'PAN', 'Panama', 'Panamanian'),
(598, 'PG', 'PNG', 'Papua New Guinea', 'Papua New Guinean, Papuan'),
(600, 'PY', 'PRY', 'Paraguay', 'Paraguayan'),
(604, 'PE', 'PER', 'Peru', 'Peruvian'),
(608, 'PH', 'PHL', 'Philippines', 'Philippine, Filipino'),
(612, 'PN', 'PCN', 'Pitcairn', 'Pitcairn Island'),
(616, 'PL', 'POL', 'Poland', 'Polish'),
(620, 'PT', 'PRT', 'Portugal', 'Portuguese'),
(624, 'GW', 'GNB', 'Guinea-Bissau', 'Bissau-Guinean'),
(626, 'TL', 'TLS', 'Timor-Leste', 'Timorese'),
(630, 'PR', 'PRI', 'Puerto Rico', 'Puerto Rican'),
(634, 'QA', 'QAT', 'Qatar', 'Qatari'),
(638, 'RE', 'REU', 'Réunion', 'Réunionese, Réunionnais'),
(642, 'RO', 'ROU', 'Romania', 'Romanian'),
(643, 'RU', 'RUS', 'Russian Federation', 'Russian'),
(646, 'RW', 'RWA', 'Rwanda', 'Rwandan'),
(652, 'BL', 'BLM', 'Saint Barthélemy', 'Barthélemois'),
(654, 'SH', 'SHN', 'Saint Helena, Ascension and Tristan da Cunha', 'Saint Helenian'),
(659, 'KN', 'KNA', 'Saint Kitts and Nevis', 'Kittitian or Nevisian'),
(660, 'AI', 'AIA', 'Anguilla', 'Anguillan'),
(662, 'LC', 'LCA', 'Saint Lucia', 'Saint Lucian'),
(663, 'MF', 'MAF', 'Saint Martin (French part)', 'Saint-Martinoise'),
(666, 'PM', 'SPM', 'Saint Pierre and Miquelon', 'Saint-Pierrais or Miquelonnais'),
(670, 'VC', 'VCT', 'Saint Vincent and the Grenadines', 'Saint Vincentian, Vincentian'),
(674, 'SM', 'SMR', 'San Marino', 'Sammarinese'),
(678, 'ST', 'STP', 'Sao Tome and Principe', 'São Toméan'),
(682, 'SA', 'SAU', 'Saudi Arabia', 'Saudi, Saudi Arabian'),
(686, 'SN', 'SEN', 'Senegal', 'Senegalese'),
(688, 'RS', 'SRB', 'Serbia', 'Serbian'),
(690, 'SC', 'SYC', 'Seychelles', 'Seychellois'),
(694, 'SL', 'SLE', 'Sierra Leone', 'Sierra Leonean'),
(702, 'SG', 'SGP', 'Singapore', 'Singaporean'),
(703, 'SK', 'SVK', 'Slovakia', 'Slovak'),
(704, 'VN', 'VNM', 'Vietnam', 'Vietnamese'),
(705, 'SI', 'SVN', 'Slovenia', 'Slovenian, Slovene'),
(706, 'SO', 'SOM', 'Somalia', 'Somali, Somalian'),
(710, 'ZA', 'ZAF', 'South Africa', 'South African'),
(716, 'ZW', 'ZWE', 'Zimbabwe', 'Zimbabwean'),
(724, 'ES', 'ESP', 'Spain', 'Spanish'),
(728, 'SS', 'SSD', 'South Sudan', 'South Sudanese'),
(729, 'SD', 'SDN', 'Sudan', 'Sudanese'),
(732, 'EH', 'ESH', 'Western Sahara', 'Sahrawi, Sahrawian, Sahraouian'),
(740, 'SR', 'SUR', 'Suriname', 'Surinamese'),
(744, 'SJ', 'SJM', 'Svalbard and Jan Mayen', 'Svalbard'),
(748, 'SZ', 'SWZ', 'Swaziland', 'Swazi'),
(752, 'SE', 'SWE', 'Sweden', 'Swedish'),
(756, 'CH', 'CHE', 'Switzerland', 'Swiss'),
(760, 'SY', 'SYR', 'Syrian Arab Republic', 'Syrian'),
(762, 'TJ', 'TJK', 'Tajikistan', 'Tajikistani'),
(764, 'TH', 'THA', 'Thailand', 'Thai'),
(768, 'TG', 'TGO', 'Togo', 'Togolese'),
(772, 'TK', 'TKL', 'Tokelau', 'Tokelauan'),
(776, 'TO', 'TON', 'Tonga', 'Tongan'),
(780, 'TT', 'TTO', 'Trinidad and Tobago', 'Trinidadian or Tobagonian'),
(784, 'AE', 'ARE', 'United Arab Emirates', 'Emirati, Emirian, Emiri'),
(788, 'TN', 'TUN', 'Tunisia', 'Tunisian'),
(792, 'TR', 'TUR', 'Turkey', 'Turkish'),
(795, 'TM', 'TKM', 'Turkmenistan', 'Turkmen'),
(796, 'TC', 'TCA', 'Turks and Caicos Islands', 'Turks and Caicos Island'),
(798, 'TV', 'TUV', 'Tuvalu', 'Tuvaluan'),
(800, 'UG', 'UGA', 'Uganda', 'Ugandan'),
(804, 'UA', 'UKR', 'Ukraine', 'Ukrainian'),
(807, 'MK', 'MKD', 'Macedonia (the former Yugoslav Republic of)', 'Macedonian'),
(818, 'EG', 'EGY', 'Egypt', 'Egyptian'),
(826, 'GB', 'GBR', 'United Kingdom of Great Britain and Northern Ireland', 'British, UK'),
(831, 'GG', 'GGY', 'Guernsey', 'Channel Island'),
(832, 'JE', 'JEY', 'Jersey', 'Channel Island'),
(833, 'IM', 'IMN', 'Isle of Man', 'Manx'),
(834, 'TZ', 'TZA', 'Tanzania, United Republic of', 'Tanzanian'),
(840, 'US', 'USA', 'United States of America', 'American'),
(850, 'VI', 'VIR', 'Virgin Islands (U.S.)', 'U.S. Virgin Island'),
(854, 'BF', 'BFA', 'Burkina Faso', 'Burkinabé'),
(858, 'UY', 'URY', 'Uruguay', 'Uruguayan'),
(860, 'UZ', 'UZB', 'Uzbekistan', 'Uzbekistani, Uzbek'),
(862, 'VE', 'VEN', 'Venezuela (Bolivarian Republic of)', 'Venezuelan'),
(876, 'WF', 'WLF', 'Wallis and Futuna', 'Wallis and Futuna, Wallisian or Futunan'),
(882, 'WS', 'WSM', 'Samoa', 'Samoan'),
(887, 'YE', 'YEM', 'Yemen', 'Yemeni'),
(894, 'ZM', 'ZMB', 'Zambia', 'Zambian');

-- --------------------------------------------------------

--
-- Table structure for table `count_sheet_collections`
--

DROP TABLE IF EXISTS `count_sheet_collections`;
CREATE TABLE IF NOT EXISTS `count_sheet_collections` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `property_id` bigint(255) NOT NULL,
  `cashier` varchar(255) DEFAULT NULL,
  `custodian` varchar(255) DEFAULT NULL,
  `amount_of_fund` varchar(255) DEFAULT NULL,
  `counted_by` varchar(255) DEFAULT NULL,
  `account_mode` varchar(255) DEFAULT NULL,
  `acknowledge_by` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `count_sheet_collection_bills`
--

DROP TABLE IF EXISTS `count_sheet_collection_bills`;
CREATE TABLE IF NOT EXISTS `count_sheet_collection_bills` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `collection_id` bigint(255) NOT NULL,
  `denomination` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `count_sheet_collection_certification`
--

DROP TABLE IF EXISTS `count_sheet_collection_certification`;
CREATE TABLE IF NOT EXISTS `count_sheet_collection_certification` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `collection_id` bigint(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `amount_currency` varchar(255) NOT NULL,
  `counted_by` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `count_sheet_collection_checks`
--

DROP TABLE IF EXISTS `count_sheet_collection_checks`;
CREATE TABLE IF NOT EXISTS `count_sheet_collection_checks` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `collection_id` bigint(255) NOT NULL,
  `or_no` varchar(255) DEFAULT NULL,
  `bank` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `count_sheet_collection_initial_finding`
--

DROP TABLE IF EXISTS `count_sheet_collection_initial_finding`;
CREATE TABLE IF NOT EXISTS `count_sheet_collection_initial_finding` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `collection_id` bigint(255) NOT NULL,
  `initial_finding` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `compliance` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `count_sheet_collection_totals`
--

DROP TABLE IF EXISTS `count_sheet_collection_totals`;
CREATE TABLE IF NOT EXISTS `count_sheet_collection_totals` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `collection_id` bigint(255) NOT NULL,
  `bills_total` varchar(255) DEFAULT NULL,
  `checks_total` varchar(255) DEFAULT NULL,
  `total_bills_coins` varchar(255) DEFAULT NULL,
  `total_checks` varchar(255) DEFAULT NULL,
  `total_per_count_1` varchar(255) DEFAULT NULL,
  `total_to_be_counted_for` varchar(255) DEFAULT NULL,
  `total_per_count_2` varchar(255) DEFAULT NULL,
  `total_overage` varchar(255) DEFAULT NULL,
  `total_others` varchar(255) DEFAULT NULL,
  `total_others_specify` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `count_sheet_collection_undeposited`
--

DROP TABLE IF EXISTS `count_sheet_collection_undeposited`;
CREATE TABLE IF NOT EXISTS `count_sheet_collection_undeposited` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `collection_id` bigint(255) NOT NULL,
  `or_ar_number` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `payee` varchar(255) NOT NULL,
  `particulars` varchar(1000) NOT NULL,
  `check_number` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `daily_collections`
--

DROP TABLE IF EXISTS `daily_collections`;
CREATE TABLE IF NOT EXISTS `daily_collections` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `sub_property_id` bigint(255) NOT NULL,
  `unit_id` varchar(255) DEFAULT NULL,
  `others` varchar(5000) DEFAULT NULL,
  `tenant_ids` varchar(1000) DEFAULT NULL,
  `collection_date` varchar(255) DEFAULT NULL,
  `voucher_type` varchar(255) DEFAULT NULL,
  `or_number` varchar(255) DEFAULT NULL,
  `ar_number` varchar(255) DEFAULT NULL,
  `pr_number` varchar(255) DEFAULT NULL,
  `particulars` varchar(255) NOT NULL,
  `attachment` varchar(1000) DEFAULT NULL,
  `deposit_payment_slip_attachment` varchar(1000) DEFAULT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `daily_collections_payment_types`
--

DROP TABLE IF EXISTS `daily_collections_payment_types`;
CREATE TABLE IF NOT EXISTS `daily_collections_payment_types` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `daily_collection_id` bigint(255) NOT NULL,
  `payment_type` int(10) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `bank` varchar(500) DEFAULT NULL,
  `other_bank` varchar(255) DEFAULT NULL,
  `check_number` varchar(255) DEFAULT NULL,
  `date_of_check` varchar(255) DEFAULT NULL,
  `transaction_details` varchar(255) DEFAULT NULL,
  `deposit_slip` varchar(255) DEFAULT NULL,
  `reference_number` varchar(255) DEFAULT NULL,
  `receipt_type` varchar(10) DEFAULT NULL,
  `status` int(10) DEFAULT '0',
  `recorded_date` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `daily_collection_reports`
--

DROP TABLE IF EXISTS `daily_collection_reports`;
CREATE TABLE IF NOT EXISTS `daily_collection_reports` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `sub_property_id` bigint(255) NOT NULL,
  `report_date` varchar(255) NOT NULL,
  `collection_date` varchar(255) NOT NULL,
  `grand_total` varchar(255) NOT NULL,
  `prepared_by` bigint(255) NOT NULL,
  `prepared_by_account_mode` varchar(255) NOT NULL,
  `verified_by` bigint(255) DEFAULT NULL,
  `verified_by_account_mode` varchar(255) DEFAULT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  `temp_del` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `daily_collection_report_cash_count`
--

DROP TABLE IF EXISTS `daily_collection_report_cash_count`;
CREATE TABLE IF NOT EXISTS `daily_collection_report_cash_count` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `collection_report_id` bigint(255) NOT NULL,
  `denomination` varchar(255) NOT NULL,
  `quantity` int(20) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `daily_deposit`
--

DROP TABLE IF EXISTS `daily_deposit`;
CREATE TABLE IF NOT EXISTS `daily_deposit` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `sub_property_id` bigint(255) NOT NULL,
  `deposit_date` varchar(255) NOT NULL,
  `recorded_date` varchar(255) DEFAULT NULL,
  `total_deposited` varchar(255) DEFAULT NULL,
  `deposited_by` bigint(255) DEFAULT NULL,
  `account_mode` varchar(255) DEFAULT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `daily_deposit_reference`
--

DROP TABLE IF EXISTS `daily_deposit_reference`;
CREATE TABLE IF NOT EXISTS `daily_deposit_reference` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `deposit_id` bigint(255) NOT NULL,
  `deposit_reference` varchar(500) DEFAULT NULL,
  `attachments` varchar(5000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `day_plan`
--

DROP TABLE IF EXISTS `day_plan`;
CREATE TABLE IF NOT EXISTS `day_plan` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `prospect_id` bigint(255) NOT NULL,
  `deployment_date` varchar(255) NOT NULL,
  `day_plan_status` int(20) NOT NULL DEFAULT '0',
  `created_date` varchar(255) DEFAULT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `day_plan_days`
--

DROP TABLE IF EXISTS `day_plan_days`;
CREATE TABLE IF NOT EXISTS `day_plan_days` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `day_plan_id` bigint(255) NOT NULL,
  `to_be_accomplished_date` varchar(255) DEFAULT NULL,
  `day_category` varchar(255) DEFAULT NULL,
  `plan_date` varchar(255) DEFAULT NULL,
  `plan_date_to` varchar(255) DEFAULT NULL,
  `plan_action` varchar(1000) DEFAULT NULL,
  `department_id` bigint(255) DEFAULT NULL,
  `plan_remarks` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE IF NOT EXISTS `departments` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `department_code` varchar(5) NOT NULL DEFAULT '',
  `department_name` varchar(100) NOT NULL DEFAULT '',
  `status` int(1) NOT NULL DEFAULT '0',
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department_code`, `department_name`, `status`, `temp_del`) VALUES
(1, 'MGT', 'Management', 0, 0),
(2, 'EGR', 'Engineering', 0, 0),
(3, 'MNT', 'Maintainance', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `document_management_contracts`
--

DROP TABLE IF EXISTS `document_management_contracts`;
CREATE TABLE IF NOT EXISTS `document_management_contracts` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `sub_property_id` bigint(255) NOT NULL,
  `contractor` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `type_of_service` int(20) NOT NULL,
  `type_of_service_specify` varchar(255) DEFAULT NULL,
  `contact_person` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `accreditation_date` varchar(255) NOT NULL,
  `term_beginning_date` varchar(255) NOT NULL,
  `term_ended_date` varchar(255) NOT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `downpayments`
--

DROP TABLE IF EXISTS `downpayments`;
CREATE TABLE IF NOT EXISTS `downpayments` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `prospect_id` int(250) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `attachment` varchar(500) DEFAULT NULL,
  `date` varchar(255) NOT NULL,
  `or_num` varchar(250) NOT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(20) NOT NULL,
  `upass` varchar(200) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL DEFAULT '',
  `lastname` varchar(50) NOT NULL,
  `gender` int(1) NOT NULL DEFAULT '0',
  `code_name` varchar(255) NOT NULL DEFAULT '',
  `photo` varchar(100) NOT NULL DEFAULT '',
  `role_ids` varchar(500) NOT NULL DEFAULT ',',
  `department_id` bigint(255) NOT NULL DEFAULT '0',
  `property_ids` varchar(500) NOT NULL DEFAULT ',',
  `sub_property_ids` varchar(1000) NOT NULL DEFAULT ',',
  `language` int(2) NOT NULL DEFAULT '0',
  `data_per_page` int(3) NOT NULL DEFAULT '20',
  `last_login` int(20) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `employee_id`, `upass`, `firstname`, `middlename`, `lastname`, `gender`, `code_name`, `photo`, `role_ids`, `department_id`, `property_ids`, `sub_property_ids`, `language`, `data_per_page`, `last_login`, `status`, `temp_del`) VALUES
(1, '10001', '7K+yo6DUjh7kQbqrqjLwR3Jrv8uT8wRgkwKf/j9PKRPo4K9qGD3Y4T4SKUyJyyacYdVZcWH4wxHM0j8o1guBeA==', 'Ryan X', '', 'Reyes', 0, '', '', ',2,', 1, ',2,', ',5,6,', 0, 20, 1574926760, 0, 0),
(2, '10002', 'Z03aAnu/ruBlO4tOzjIGGwGV9Nw9LTU50GVszZdpU07jeOJ7/4aMncb/g4QaOuZOud5nGj0bWYa0n43AiYk4xg==', 'Ryan Michael', 'Lao', 'Reyes', 0, '', '', ',2,', 1, ',1,2,', ',1,5,6,', 0, 20, 0, 0, 0),
(3, '10003', '6rioAZYW3m7/NAirGwTRFbD6Fxf57UltTUQ2O7dxQQZVh/mqQnnSuIrM5jWi07uHuRDAHwbcfHmto9xYpwbC0A==', 'Zerik', '', 'Feyt', 0, '', '', ',2,', 1, ',1,2,3,', ',1,5,6,15,16,17,18,19,20,21,22,', 0, 20, 0, 0, 0),
(4, '10004', 'AxTeXS+iZvLIqLnrgCc5dLaXw4Cua70/Qz3mXPKhwc4QW4WcOx9lY/87ZbUllDqsD3KuQMfSTR6FCClKHhW+OQ==', 'Building', '', 'Manager', 0, '', '', ',3,', 1, ',1,2,3,', ',1,5,6,15,16,17,18,19,20,21,22,', 0, 20, 1576477848, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `equipments`
--

DROP TABLE IF EXISTS `equipments`;
CREATE TABLE IF NOT EXISTS `equipments` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `sub_property_id` bigint(255) NOT NULL,
  `serial_number` varchar(255) DEFAULT NULL,
  `equipment_name` varchar(500) NOT NULL,
  `equipment_type` varchar(500) NOT NULL,
  `equipment_capacity` varchar(500) NOT NULL,
  `equipment_description` varchar(1000) DEFAULT NULL,
  `equipment_location` varchar(500) DEFAULT '',
  `date_acquired` varchar(255) DEFAULT NULL,
  `amount` varchar(255) NOT NULL DEFAULT '0',
  `supplier` varchar(500) DEFAULT NULL,
  `equipment_key` varchar(255) DEFAULT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fpd_notifications`
--

DROP TABLE IF EXISTS `fpd_notifications`;
CREATE TABLE IF NOT EXISTS `fpd_notifications` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `notification` varchar(255) NOT NULL,
  `source_id` bigint(255) DEFAULT NULL,
  `source_account_mode` varchar(255) DEFAULT NULL,
  `module` varchar(255) DEFAULT NULL,
  `module_id` bigint(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `user_id` bigint(255) NOT NULL,
  `account_mode` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fund_count_sheet`
--

DROP TABLE IF EXISTS `fund_count_sheet`;
CREATE TABLE IF NOT EXISTS `fund_count_sheet` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `property_id` bigint(255) NOT NULL,
  `custodian` varchar(255) DEFAULT NULL,
  `amount_of_fund` varchar(255) DEFAULT NULL,
  `counted_by` bigint(255) NOT NULL,
  `account_mode` varchar(255) NOT NULL,
  `acknowledge_by` varchar(255) NOT NULL,
  `unreplenished_recommendation` varchar(1000) DEFAULT NULL,
  `unreplenished_custodian` varchar(255) DEFAULT NULL,
  `unreplenished_building_manager` varchar(255) DEFAULT NULL,
  `unliquidated_custodian` varchar(255) DEFAULT NULL,
  `unliquidated_building_manager` varchar(255) DEFAULT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fund_count_sheet_bills`
--

DROP TABLE IF EXISTS `fund_count_sheet_bills`;
CREATE TABLE IF NOT EXISTS `fund_count_sheet_bills` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `fund_count_sheet_id` bigint(255) NOT NULL,
  `denomination` varchar(255) NOT NULL,
  `quantity` int(10) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fund_count_sheet_certification`
--

DROP TABLE IF EXISTS `fund_count_sheet_certification`;
CREATE TABLE IF NOT EXISTS `fund_count_sheet_certification` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `fund_count_sheet_id` bigint(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `amount_text` varchar(500) DEFAULT NULL,
  `amount_currency` varchar(255) DEFAULT NULL,
  `counted_by` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fund_count_sheet_findings`
--

DROP TABLE IF EXISTS `fund_count_sheet_findings`;
CREATE TABLE IF NOT EXISTS `fund_count_sheet_findings` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `fund_count_sheet_id` bigint(255) NOT NULL,
  `item` varchar(255) NOT NULL,
  `remarks` varchar(500) DEFAULT NULL,
  `compliance` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fund_count_sheet_total`
--

DROP TABLE IF EXISTS `fund_count_sheet_total`;
CREATE TABLE IF NOT EXISTS `fund_count_sheet_total` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `fund_count_sheet_id` bigint(255) NOT NULL,
  `total_bills` varchar(255) DEFAULT NULL,
  `unreplenished_pcv` varchar(255) DEFAULT NULL,
  `unliquidated_advances` varchar(255) DEFAULT NULL,
  `others` varchar(255) DEFAULT NULL,
  `others_specify` varchar(255) DEFAULT NULL,
  `total_per_count` varchar(500) DEFAULT NULL,
  `total_per_book` varchar(255) DEFAULT NULL,
  `overage_shortage` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fund_count_sheet_unliquidated`
--

DROP TABLE IF EXISTS `fund_count_sheet_unliquidated`;
CREATE TABLE IF NOT EXISTS `fund_count_sheet_unliquidated` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `fund_count_sheet_id` bigint(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `payee` varchar(255) DEFAULT NULL,
  `particulars` varchar(255) DEFAULT NULL,
  `pcv_number` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `findings` varchar(5000) DEFAULT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fund_count_sheet_unreplenished`
--

DROP TABLE IF EXISTS `fund_count_sheet_unreplenished`;
CREATE TABLE IF NOT EXISTS `fund_count_sheet_unreplenished` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `fund_count_sheet_id` bigint(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `payee` varchar(255) DEFAULT NULL,
  `particulars` varchar(255) DEFAULT NULL,
  `pcv_no` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `findings` varchar(255) DEFAULT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gate_pass_employees`
--

DROP TABLE IF EXISTS `gate_pass_employees`;
CREATE TABLE IF NOT EXISTS `gate_pass_employees` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `property_id` bigint(255) NOT NULL,
  `date` varchar(250) NOT NULL,
  `employee_name` varchar(250) NOT NULL,
  `purpose` varchar(250) NOT NULL,
  `prospect_id` int(250) NOT NULL DEFAULT '0',
  `person_department` varchar(250) NOT NULL,
  `time_in` varchar(250) NOT NULL,
  `time_out` varchar(250) DEFAULT NULL,
  `temp_del` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `hris_attendances`
--

DROP TABLE IF EXISTS `hris_attendances`;
CREATE TABLE IF NOT EXISTS `hris_attendances` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_id` bigint(20) NOT NULL,
  `time_in_photo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_out_photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_in` bigint(20) NOT NULL,
  `time_out` bigint(20) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_attendance_sheets`
--

DROP TABLE IF EXISTS `hris_attendance_sheets`;
CREATE TABLE IF NOT EXISTS `hris_attendance_sheets` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_benefits`
--

DROP TABLE IF EXISTS `hris_benefits`;
CREATE TABLE IF NOT EXISTS `hris_benefits` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hris_benefits`
--

INSERT INTO `hris_benefits` (`id`, `created_at`, `updated_at`, `name`) VALUES
(1, NULL, NULL, 'Paid Vacations'),
(2, NULL, NULL, 'Mandatory Benefits (SSS, HDMF, Philhealth)');

-- --------------------------------------------------------

--
-- Table structure for table `hris_candidates`
--

DROP TABLE IF EXISTS `hris_candidates`;
CREATE TABLE IF NOT EXISTS `hris_candidates` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `job_position_id` bigint(20) NOT NULL,
  `hiring_stage` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resume` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resume_headline` longtext COLLATE utf8mb4_unicode_ci,
  `profile_summary` longtext COLLATE utf8mb4_unicode_ci,
  `total_years_exp` longtext COLLATE utf8mb4_unicode_ci,
  `work_history` longtext COLLATE utf8mb4_unicode_ci,
  `education` longtext COLLATE utf8mb4_unicode_ci,
  `skills` longtext COLLATE utf8mb4_unicode_ci,
  `referees` longtext COLLATE utf8mb4_unicode_ci,
  `prefered_industry` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expected_salary` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_certifications`
--

DROP TABLE IF EXISTS `hris_certifications`;
CREATE TABLE IF NOT EXISTS `hris_certifications` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hris_certifications`
--

INSERT INTO `hris_certifications` (`id`, `created_at`, `updated_at`, `name`, `description`) VALUES
(1, NULL, NULL, 'TESDA Certification', 'TESDA Certification'),
(2, NULL, NULL, 'Special Course Certification', 'Special Course Certification');

-- --------------------------------------------------------

--
-- Table structure for table `hris_clients`
--

DROP TABLE IF EXISTS `hris_clients`;
CREATE TABLE IF NOT EXISTS `hris_clients` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci,
  `address` longtext COLLATE utf8mb4_unicode_ci,
  `contact_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_contact_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_company_assets`
--

DROP TABLE IF EXISTS `hris_company_assets`;
CREATE TABLE IF NOT EXISTS `hris_company_assets` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asset_type_id` bigint(20) NOT NULL,
  `employee_id` bigint(20) DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_company_asset_types`
--

DROP TABLE IF EXISTS `hris_company_asset_types`;
CREATE TABLE IF NOT EXISTS `hris_company_asset_types` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `attachment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_company_documents`
--

DROP TABLE IF EXISTS `hris_company_documents`;
CREATE TABLE IF NOT EXISTS `hris_company_documents` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` bigint(20) DEFAULT NULL,
  `employee_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_company_loan_types`
--

DROP TABLE IF EXISTS `hris_company_loan_types`;
CREATE TABLE IF NOT EXISTS `hris_company_loan_types` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hris_company_loan_types`
--

INSERT INTO `hris_company_loan_types` (`id`, `created_at`, `updated_at`, `name`, `details`) VALUES
(1, NULL, NULL, 'SSS Loan (first loan)', 'should have total of 36 months premium contribution'),
(2, NULL, NULL, 'SSS Loan (renewal)', 'should have paid at least half of the existing loan or paid at least 12 months'),
(3, NULL, NULL, 'Pag-IBIG (first loan)', 'should have total of 24 months premium contribution'),
(4, NULL, NULL, 'Pag-IBIG (renewal)', 'should have paid at least 6 months'),
(5, NULL, NULL, 'FEMCO Educ. Loan', 'should have at least paid half of the loan balance'),
(6, NULL, NULL, 'FEMCO Quick Loan', 'should have at least paid half of the loan balance'),
(7, NULL, NULL, 'FEMCO Regular Loan', 'should have at least paid half of the loan balance');

-- --------------------------------------------------------

--
-- Table structure for table `hris_company_structures`
--

DROP TABLE IF EXISTS `hris_company_structures`;
CREATE TABLE IF NOT EXISTS `hris_company_structures` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_structure` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hris_company_structures`
--

INSERT INTO `hris_company_structures` (`id`, `created_at`, `updated_at`, `code`, `name`, `details`, `address`, `type`, `country`, `timezone`, `parent_structure`) VALUES
(1, NULL, NULL, 'CMO', 'Central Management Office', 'Central Management Office', '', 'Head Office', 'Philippines', 'Asia/Manila', ''),
(2, NULL, NULL, 'ESD', 'Engineering Services Divisions', 'Engineering Services Divisions', '', 'Department', 'Philippines', 'Asia/Manila', 'Central Management Office'),
(3, NULL, NULL, 'EO', 'Executive Office', 'Executive Office', '', 'Head Office', 'Philippines', 'Asia/Manila', 'Central Management Office'),
(4, NULL, NULL, 'POD', 'Property Operations Divisions', 'Property Operations Divisions', '', 'Department', 'Philippines', 'Asia/Manila', 'Central Management Office'),
(5, NULL, NULL, 'GSD', 'General Support Department', 'General Support Department', '', 'Department', 'Philippines', 'Asia/Manila', 'Corporate Support & Services Division'),
(6, NULL, NULL, 'BDM', 'Business Development & Marketing Department', 'Business Development & Marketing Department', '', 'Department', 'Philippines', 'Asia/Manila', 'Executive Office'),
(7, NULL, NULL, 'IAD', 'Internal Audit Department', 'Internal Audit Department', '', 'Department', 'Philippines', 'Asia/Manila', 'Executive Office'),
(8, NULL, NULL, 'QEHS', 'Quality, Environmental, Health and Safety Department', 'Quality, Environmental, Health and Safety Department', '', 'Department', 'Philippines', 'Asia/Manila', 'Executive Office'),
(9, NULL, NULL, 'TSAD', 'Technical & Safety Audit Department', 'Technical & Safety Audit Department', '', 'Department', 'Philippines', 'Asia/Manila', 'Engineering Services Divisions'),
(10, NULL, NULL, 'TSD', 'Technical Services Department', 'Technical Services Department', '', 'Department', 'Philippines', 'Asia/Manila', 'Engineering Services Divisions'),
(11, NULL, NULL, 'CAD', 'Corporate Accounting Department', 'Corporate Accounting Department', '', 'Department', 'Philippines', 'Asia/Manila', 'Finance & Accounting Department'),
(12, NULL, NULL, 'PAD', 'Project Accounting Department', 'Project Accounting Department', '', 'Department', 'Philippines', 'Asia/Manila', 'Finance & Accounting Department'),
(13, NULL, NULL, 'SBU', 'Strategic Business Unit', 'Strategic Business Unit', '', 'Department', 'Philippines', 'Asia/Manila', 'Property Operations Divisions'),
(14, NULL, NULL, 'CSSD', 'Corporate Support & Services Division', 'Corporate Support & Services Division', '', 'Head Office', 'Philippines', 'Asia/Manila', 'Central Management Office'),
(15, NULL, NULL, 'HRMD', 'Human Resource Management Department', 'Human Resource Management Department', '', 'Department', 'Philippines', 'Asia/Manila', 'Corporate Support & Services Division'),
(16, NULL, NULL, 'ITD', 'Information Technology Department', 'Information Technology Department', '', 'Department', 'Philippines', 'Asia/Manila', 'Corporate Support & Services Division'),
(17, NULL, NULL, 'LSD', 'Legal Services Department', 'Legal Services Department (LSD)', '', 'Department', 'Philippines', 'Asia/Manila', 'Corporate Support & Services Department'),
(18, NULL, NULL, 'SBU-1', 'SBU 1', 'SBU 1', '', 'Sub Unit', 'Philippines', 'Asia/Manila', 'Property Operations Division'),
(19, NULL, NULL, 'SBU-2', 'SBU 2', 'SBU 2', '', 'Sub Unit', 'Philippines', 'Asia/Manila', 'Property Operations Division'),
(20, NULL, NULL, 'SBU-3', 'SBU 3', 'SBU 3', '', 'Sub Unit', 'Philippines', 'Asia/Manila', 'Property Operations Division'),
(21, NULL, NULL, 'SBU-4', 'SBU 4', 'SBU 4', '', 'Sub Unit', 'Afghanistan', 'Asia/Manila', 'Property Operations Division'),
(22, NULL, NULL, 'SBU-5', 'SBU 5', 'SBU 5', '', 'Sub Unit', 'Afghanistan', 'Asia/Manila', 'Property Operations Division'),
(23, NULL, NULL, 'SBU-6', 'SBU 6', 'SBU 6', '', 'Sub Unit', 'Philippines', 'Asia/Manila', 'Property Operations Division'),
(24, NULL, NULL, 'SBU-7', 'SBU 7', 'SBU 7', '', 'Sub Unit', 'Philippines', 'Asia/Manila', 'Property Operations Division'),
(25, NULL, NULL, 'SBU-8', 'SBU 8', 'SBU 8', '', 'Sub Unit', 'Philippines', 'Asia/Manila', 'Property Operations Division'),
(26, NULL, NULL, 'SBU-9', 'SBU 9', 'SBU 9', '', 'Sub Unit', 'Philippines', 'Asia/Manila', 'Property Operations Division');

-- --------------------------------------------------------

--
-- Table structure for table `hris_company_types`
--

DROP TABLE IF EXISTS `hris_company_types`;
CREATE TABLE IF NOT EXISTS `hris_company_types` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_countries`
--

DROP TABLE IF EXISTS `hris_countries`;
CREATE TABLE IF NOT EXISTS `hris_countries` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=243 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hris_countries`
--

INSERT INTO `hris_countries` (`id`, `created_at`, `updated_at`, `code`, `name`) VALUES
(1, NULL, NULL, 'US', 'United States'),
(2, NULL, NULL, 'CA', 'Canada'),
(3, NULL, NULL, 'AF', 'Afghanistan'),
(4, NULL, NULL, 'AL', 'Albania'),
(5, NULL, NULL, 'DZ', 'Algeria'),
(6, NULL, NULL, 'AS', 'American Samoa'),
(7, NULL, NULL, 'AD', 'Andorra'),
(8, NULL, NULL, 'AO', 'Angola'),
(9, NULL, NULL, 'AI', 'Anguilla'),
(10, NULL, NULL, 'AQ', 'Antarctica'),
(11, NULL, NULL, 'AG', 'Antigua and/or Barbuda'),
(12, NULL, NULL, 'AR', 'Argentina'),
(13, NULL, NULL, 'AM', 'Armenia'),
(14, NULL, NULL, 'AW', 'Aruba'),
(15, NULL, NULL, 'AU', 'Australia'),
(16, NULL, NULL, 'AT', 'Austria'),
(17, NULL, NULL, 'AZ', 'Azerbaijan'),
(18, NULL, NULL, 'BS', 'Bahamas'),
(19, NULL, NULL, 'BH', 'Bahrain'),
(20, NULL, NULL, 'BD', 'Bangladesh'),
(21, NULL, NULL, 'BB', 'Barbados'),
(22, NULL, NULL, 'BY', 'Belarus'),
(23, NULL, NULL, 'BE', 'Belgium'),
(24, NULL, NULL, 'BZ', 'Belize'),
(25, NULL, NULL, 'BJ', 'Benin'),
(26, NULL, NULL, 'BM', 'Bermuda'),
(27, NULL, NULL, 'BT', 'Bhutan'),
(28, NULL, NULL, 'BO', 'Bolivia'),
(29, NULL, NULL, 'BA', 'Bosnia and Herzegovina'),
(30, NULL, NULL, 'BW', 'Botswana'),
(31, NULL, NULL, 'BV', 'Bouvet Island'),
(32, NULL, NULL, 'BR', 'Brazil'),
(33, NULL, NULL, 'IO', 'British lndian Ocean Territory'),
(34, NULL, NULL, 'BN', 'Brunei Darussalam'),
(35, NULL, NULL, 'BG', 'Bulgaria'),
(36, NULL, NULL, 'BF', 'Burkina Faso'),
(37, NULL, NULL, 'BI', 'Burundi'),
(38, NULL, NULL, 'KH', 'Cambodia'),
(39, NULL, NULL, 'CM', 'Cameroon'),
(40, NULL, NULL, 'CV', 'Cape Verde'),
(41, NULL, NULL, 'KY', 'Cayman Islands'),
(42, NULL, NULL, 'CF', 'Central African Republic'),
(43, NULL, NULL, 'TD', 'Chad'),
(44, NULL, NULL, 'CL', 'Chile'),
(45, NULL, NULL, 'CN', 'China'),
(46, NULL, NULL, 'CX', 'Christmas Island'),
(47, NULL, NULL, 'CC', 'Cocos (Keeling) Islands'),
(48, NULL, NULL, 'CO', 'Colombia'),
(49, NULL, NULL, 'KM', 'Comoros'),
(50, NULL, NULL, 'CG', 'Congo'),
(51, NULL, NULL, 'CK', 'Cook Islands'),
(52, NULL, NULL, 'CR', 'Costa Rica'),
(53, NULL, NULL, 'HR', 'Croatia (Hrvatska)'),
(54, NULL, NULL, 'CU', 'Cuba'),
(55, NULL, NULL, 'CY', 'Cyprus'),
(56, NULL, NULL, 'CZ', 'Czech Republic'),
(57, NULL, NULL, 'CD', 'Democratic Republic of Congo'),
(58, NULL, NULL, 'DK', 'Denmark'),
(59, NULL, NULL, 'DJ', 'Djibouti'),
(60, NULL, NULL, 'DM', 'Dominica'),
(61, NULL, NULL, 'DO', 'Dominican Republic'),
(62, NULL, NULL, 'TP', 'East Timor'),
(63, NULL, NULL, 'EC', 'Ecudaor'),
(64, NULL, NULL, 'EG', 'Egypt'),
(65, NULL, NULL, 'SV', 'El Salvador'),
(66, NULL, NULL, 'GQ', 'Equatorial Guinea'),
(67, NULL, NULL, 'ER', 'Eritrea'),
(68, NULL, NULL, 'EE', 'Estonia'),
(69, NULL, NULL, 'ET', 'Ethiopia'),
(70, NULL, NULL, 'FK', 'Falkland Islands (Malvinas)'),
(71, NULL, NULL, 'FO', 'Faroe Islands'),
(72, NULL, NULL, 'FJ', 'Fiji'),
(73, NULL, NULL, 'FI', 'Finland'),
(74, NULL, NULL, 'FR', 'France'),
(75, NULL, NULL, 'FX', 'France, Metropolitan'),
(76, NULL, NULL, 'GF', 'French Guiana'),
(77, NULL, NULL, 'PF', 'French Polynesia'),
(78, NULL, NULL, 'TF', 'French Southern Territories'),
(79, NULL, NULL, 'GA', 'Gabon'),
(80, NULL, NULL, 'GM', 'Gambia'),
(81, NULL, NULL, 'GE', 'Georgia'),
(82, NULL, NULL, 'DE', 'Germany'),
(83, NULL, NULL, 'GH', 'Ghana'),
(84, NULL, NULL, 'GI', 'Gibraltar'),
(85, NULL, NULL, 'GR', 'Greece'),
(86, NULL, NULL, 'GL', 'Greenland'),
(87, NULL, NULL, 'GD', 'Grenada'),
(88, NULL, NULL, 'GP', 'Guadeloupe'),
(89, NULL, NULL, 'GU', 'Guam'),
(90, NULL, NULL, 'GT', 'Guatemala'),
(91, NULL, NULL, 'GN', 'Guinea'),
(92, NULL, NULL, 'GW', 'Guinea-Bissau'),
(93, NULL, NULL, 'GY', 'Guyana'),
(94, NULL, NULL, 'HT', 'Haiti'),
(95, NULL, NULL, 'HM', 'Heard and Mc Donald Islands'),
(96, NULL, NULL, 'HN', 'Honduras'),
(97, NULL, NULL, 'HK', 'Hong Kong'),
(98, NULL, NULL, 'HU', 'Hungary'),
(99, NULL, NULL, 'IS', 'Iceland'),
(100, NULL, NULL, 'IN', 'India'),
(101, NULL, NULL, 'ID', 'Indonesia'),
(102, NULL, NULL, 'IR', 'Iran (Islamic Republic of)'),
(103, NULL, NULL, 'IQ', 'Iraq'),
(104, NULL, NULL, 'IE', 'Ireland'),
(105, NULL, NULL, 'IL', 'Israel'),
(106, NULL, NULL, 'IT', 'Italy'),
(107, NULL, NULL, 'CI', 'Ivory Coast'),
(108, NULL, NULL, 'JM', 'Jamaica'),
(109, NULL, NULL, 'JP', 'Japan'),
(110, NULL, NULL, 'JO', 'Jordan'),
(111, NULL, NULL, 'KZ', 'Kazakhstan'),
(112, NULL, NULL, 'KE', 'Kenya'),
(113, NULL, NULL, 'KI', 'Kiribati'),
(114, NULL, NULL, 'KP', 'Korea, Democratic People\'s Republic of'),
(115, NULL, NULL, 'KR', 'Korea, Republic of'),
(116, NULL, NULL, 'KW', 'Kuwait'),
(117, NULL, NULL, 'KG', 'Kyrgyzstan'),
(118, NULL, NULL, 'LA', 'Lao People\'s Democratic Republic'),
(119, NULL, NULL, 'LV', 'Latvia'),
(120, NULL, NULL, 'LB', 'Lebanon'),
(121, NULL, NULL, 'LS', 'Lesotho'),
(122, NULL, NULL, 'LR', 'Liberia'),
(123, NULL, NULL, 'LY', 'Libyan Arab Jamahiriya'),
(124, NULL, NULL, 'LI', 'Liechtenstein'),
(125, NULL, NULL, 'LT', 'Lithuania'),
(126, NULL, NULL, 'LU', 'Luxembourg'),
(127, NULL, NULL, 'MO', 'Macau'),
(128, NULL, NULL, 'MK', 'Macedonia'),
(129, NULL, NULL, 'MG', 'Madagascar'),
(130, NULL, NULL, 'MW', 'Malawi'),
(131, NULL, NULL, 'MY', 'Malaysia'),
(132, NULL, NULL, 'MV', 'Maldives'),
(133, NULL, NULL, 'ML', 'Mali'),
(134, NULL, NULL, 'MT', 'Malta'),
(135, NULL, NULL, 'MH', 'Marshall Islands'),
(136, NULL, NULL, 'MQ', 'Martinique'),
(137, NULL, NULL, 'MR', 'Mauritania'),
(138, NULL, NULL, 'MU', 'Mauritius'),
(139, NULL, NULL, 'TY', 'Mayotte'),
(140, NULL, NULL, 'MX', 'Mexico'),
(141, NULL, NULL, 'FM', 'Micronesia, Federated States of'),
(142, NULL, NULL, 'MD', 'Moldova, Republic of'),
(143, NULL, NULL, 'MC', 'Monaco'),
(144, NULL, NULL, 'MN', 'Mongolia'),
(145, NULL, NULL, 'MS', 'Montserrat'),
(146, NULL, NULL, 'MA', 'Morocco'),
(147, NULL, NULL, 'MZ', 'Mozambique'),
(148, NULL, NULL, 'MM', 'Myanmar'),
(149, NULL, NULL, 'NA', 'Namibia'),
(150, NULL, NULL, 'NR', 'Nauru'),
(151, NULL, NULL, 'NP', 'Nepal'),
(152, NULL, NULL, 'NL', 'Netherlands'),
(153, NULL, NULL, 'AN', 'Netherlands Antilles'),
(154, NULL, NULL, 'NC', 'New Caledonia'),
(155, NULL, NULL, 'NZ', 'New Zealand'),
(156, NULL, NULL, 'NI', 'Nicaragua'),
(157, NULL, NULL, 'NE', 'Niger'),
(158, NULL, NULL, 'NG', 'Nigeria'),
(159, NULL, NULL, 'NU', 'Niue'),
(160, NULL, NULL, 'NF', 'Norfork Island'),
(161, NULL, NULL, 'MP', 'Northern Mariana Islands'),
(162, NULL, NULL, 'NO', 'Norway'),
(163, NULL, NULL, 'OM', 'Oman'),
(164, NULL, NULL, 'PK', 'Pakistan'),
(165, NULL, NULL, 'PW', 'Palau'),
(166, NULL, NULL, 'PA', 'Panama'),
(167, NULL, NULL, 'PG', 'Papua New Guinea'),
(168, NULL, NULL, 'PY', 'Paraguay'),
(169, NULL, NULL, 'PE', 'Peru'),
(170, NULL, NULL, 'PH', 'Philippines'),
(171, NULL, NULL, 'PN', 'Pitcairn'),
(172, NULL, NULL, 'PL', 'Poland'),
(173, NULL, NULL, 'PT', 'Portugal'),
(174, NULL, NULL, 'PR', 'Puerto Rico'),
(175, NULL, NULL, 'QA', 'Qatar'),
(176, NULL, NULL, 'SS', 'Republic of South Sudan'),
(177, NULL, NULL, 'RE', 'Reunion'),
(178, NULL, NULL, 'RO', 'Romania'),
(179, NULL, NULL, 'RU', 'Russian Federation'),
(180, NULL, NULL, 'RW', 'Rwanda'),
(181, NULL, NULL, 'KN', 'Saint Kitts and Nevis'),
(182, NULL, NULL, 'LC', 'Saint Lucia'),
(183, NULL, NULL, 'VC', 'Saint Vincent and the Grenadines'),
(184, NULL, NULL, 'WS', 'Samoa'),
(185, NULL, NULL, 'SM', 'San Marino'),
(186, NULL, NULL, 'ST', 'Sao Tome and Principe'),
(187, NULL, NULL, 'SA', 'Saudi Arabia'),
(188, NULL, NULL, 'SN', 'Senegal'),
(189, NULL, NULL, 'RS', 'Serbia'),
(190, NULL, NULL, 'SC', 'Seychelles'),
(191, NULL, NULL, 'SL', 'Sierra Leone'),
(192, NULL, NULL, 'SG', 'Singapore'),
(193, NULL, NULL, 'SK', 'Slovakia'),
(194, NULL, NULL, 'SI', 'Slovenia'),
(195, NULL, NULL, 'SB', 'Solomon Islands'),
(196, NULL, NULL, 'SO', 'Somalia'),
(197, NULL, NULL, 'ZA', 'South Africa'),
(198, NULL, NULL, 'GS', 'South Georgia South Sandwich Islands'),
(199, NULL, NULL, 'ES', 'Spain'),
(200, NULL, NULL, 'LK', 'Sri Lanka'),
(201, NULL, NULL, 'SH', 'St. Helena'),
(202, NULL, NULL, 'PM', 'St. Pierre and Miquelon'),
(203, NULL, NULL, 'SD', 'Sudan'),
(204, NULL, NULL, 'SR', 'Suriname'),
(205, NULL, NULL, 'SJ', 'Svalbarn and Jan Mayen Islands'),
(206, NULL, NULL, 'SZ', 'Swaziland'),
(207, NULL, NULL, 'SE', 'Sweden'),
(208, NULL, NULL, 'CH', 'Switzerland'),
(209, NULL, NULL, 'SY', 'Syrian Arab Republic'),
(210, NULL, NULL, 'TW', 'Taiwan'),
(211, NULL, NULL, 'TJ', 'Tajikistan'),
(212, NULL, NULL, 'TZ', 'Tanzania, United Republic of'),
(213, NULL, NULL, 'TH', 'Thailand'),
(214, NULL, NULL, 'TG', 'Togo'),
(215, NULL, NULL, 'TK', 'Tokelau'),
(216, NULL, NULL, 'TO', 'Tonga'),
(217, NULL, NULL, 'TT', 'Trinidad and Tobago'),
(218, NULL, NULL, 'TN', 'Tunisia'),
(219, NULL, NULL, 'TR', 'Turkey'),
(220, NULL, NULL, 'TM', 'Turkmenistan'),
(221, NULL, NULL, 'TC', 'Turks and Caicos Islands'),
(222, NULL, NULL, 'TV', 'Tuvalu'),
(223, NULL, NULL, 'UG', 'Uganda'),
(224, NULL, NULL, 'UA', 'Ukraine'),
(225, NULL, NULL, 'AE', 'United Arab Emirates'),
(226, NULL, NULL, 'GB', 'United Kingdom'),
(227, NULL, NULL, 'UM', 'United States minor outlying islands'),
(228, NULL, NULL, 'UY', 'Uruguay'),
(229, NULL, NULL, 'UZ', 'Uzbekistan'),
(230, NULL, NULL, 'VU', 'Vanuatu'),
(231, NULL, NULL, 'VA', 'Vatican City State'),
(232, NULL, NULL, 'VE', 'Venezuela'),
(233, NULL, NULL, 'VN', 'Vietnam'),
(234, NULL, NULL, 'VG', 'Virgin Islands (British)'),
(235, NULL, NULL, 'VI', 'Virgin Islands (U.S.)'),
(236, NULL, NULL, 'WF', 'Wallis and Futuna Islands'),
(237, NULL, NULL, 'EH', 'Western Sahara'),
(238, NULL, NULL, 'YE', 'Yemen'),
(239, NULL, NULL, 'YU', 'Yugoslavia'),
(240, NULL, NULL, 'ZR', 'Zaire'),
(241, NULL, NULL, 'ZM', 'Zambia'),
(242, NULL, NULL, 'ZW', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `hris_courses`
--

DROP TABLE IF EXISTS `hris_courses`;
CREATE TABLE IF NOT EXISTS `hris_courses` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coordinator` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trainer` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trainer_details` longtext COLLATE utf8mb4_unicode_ci,
  `payment_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost` int(11) NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hris_courses`
--

INSERT INTO `hris_courses` (`id`, `created_at`, `updated_at`, `code`, `name`, `coordinator`, `trainer`, `trainer_details`, `payment_type`, `currency`, `cost`, `status`) VALUES
(1, NULL, NULL, '101', 'Course Test 01', 'SocialConz Digital', '', '', 'Company Sponsored', 'Philippine Peso', 0, 'Active'),
(2, NULL, NULL, '102', 'Course Test 02', 'SocialConz Digital', '', '', 'Company Sponsored', 'Philippine Peso', 0, 'Active'),
(3, NULL, NULL, '103', 'Course Test 03', 'SocialConz Digital', '', '', 'Company Sponsored', 'Philippine Peso', 0, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `hris_currencies`
--

DROP TABLE IF EXISTS `hris_currencies`;
CREATE TABLE IF NOT EXISTS `hris_currencies` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=104 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hris_currencies`
--

INSERT INTO `hris_currencies` (`id`, `created_at`, `updated_at`, `code`, `name`, `symbol`) VALUES
(1, NULL, NULL, 'AFN', 'Afghani', '؋'),
(2, NULL, NULL, 'ALL', 'Lek', 'Lek'),
(3, NULL, NULL, 'ANG', 'Netherlands Antillian Guilder', 'ƒ'),
(4, NULL, NULL, 'ARS', 'Argentine Peso', '$'),
(5, NULL, NULL, 'AUD', 'Australian Dollar', '$'),
(6, NULL, NULL, 'AWG', 'Aruban Guilder', 'ƒ'),
(7, NULL, NULL, 'AZN', 'Azerbaijanian Manat', 'ман'),
(8, NULL, NULL, 'BAM', 'Convertible Marks', 'KM'),
(9, NULL, NULL, 'BBD', 'Barbados Dollar', '$'),
(10, NULL, NULL, 'BGN', 'Bulgarian Lev', 'лв'),
(11, NULL, NULL, 'BMD', 'Bermudian Dollar', '$'),
(12, NULL, NULL, 'BND', 'Brunei Dollar', '$'),
(13, NULL, NULL, 'BOB', 'BOV Boliviano Mvdol', '$b'),
(14, NULL, NULL, 'BRL', 'Brazilian Real', 'R$'),
(15, NULL, NULL, 'BSD', 'Bahamian Dollar', '$'),
(16, NULL, NULL, 'BWP', 'Pula', 'P'),
(17, NULL, NULL, 'BYR', 'Belarussian Ruble', 'p.'),
(18, NULL, NULL, 'BZD', 'Belize Dollar', 'BZ$'),
(19, NULL, NULL, 'CAD', 'Canadian Dollar', '$'),
(20, NULL, NULL, 'CHF', 'Swiss Franc', 'CHF'),
(21, NULL, NULL, 'CLP', 'CLF Chilean Peso Unidades de fomento', '$'),
(22, NULL, NULL, 'CNY', 'Yuan Renminbi', '¥'),
(23, NULL, NULL, 'COP', 'COU Colombian Peso Unidad de Valor Real', '$'),
(24, NULL, NULL, 'CRC', 'Costa Rican Colon', '₡'),
(25, NULL, NULL, 'CUP', 'CUC Cuban Peso Peso Convertible', '₱'),
(26, NULL, NULL, 'CZK', 'Czech Koruna', 'Kč'),
(27, NULL, NULL, 'DKK', 'Danish Krone', 'kr'),
(28, NULL, NULL, 'DOP', 'Dominican Peso', 'RD$'),
(29, NULL, NULL, 'EGP', 'Egyptian Pound', '£'),
(30, NULL, NULL, 'EUR', 'Euro', '€'),
(31, NULL, NULL, 'FJD', 'Fiji Dollar', '$'),
(32, NULL, NULL, 'FKP', 'Falkland Islands Pound', '£'),
(33, NULL, NULL, 'GBP', 'Pound Sterling', '£'),
(34, NULL, NULL, 'GIP', 'Gibraltar Pound', '£'),
(35, NULL, NULL, 'GTQ', 'Quetzal', 'Q'),
(36, NULL, NULL, 'GYD', 'Guyana Dollar', '$'),
(37, NULL, NULL, 'HKD', 'Hong Kong Dollar', '$'),
(38, NULL, NULL, 'HNL', 'Lempira', 'L'),
(39, NULL, NULL, 'HRK', 'Croatian Kuna', 'kn'),
(40, NULL, NULL, 'HUF', 'Forint', 'Ft'),
(41, NULL, NULL, 'IDR', 'Rupiah', 'Rp'),
(42, NULL, NULL, 'ILS', 'New Israeli Sheqel', '₪'),
(43, NULL, NULL, 'IRR', 'Iranian Rial', '﷼'),
(44, NULL, NULL, 'ISK', 'Iceland Krona', 'kr'),
(45, NULL, NULL, 'JMD', 'Jamaican Dollar', 'J$'),
(46, NULL, NULL, 'JPY', 'Yen', '¥'),
(47, NULL, NULL, 'KGS', 'Som', 'лв'),
(48, NULL, NULL, 'KHR', 'Riel', '៛'),
(49, NULL, NULL, 'KPW', 'North Korean Won', '₩'),
(50, NULL, NULL, 'KRW', 'Won', '₩'),
(51, NULL, NULL, 'KYD', 'Cayman Islands Dollar', '$'),
(52, NULL, NULL, 'KZT', 'Tenge', 'лв'),
(53, NULL, NULL, 'LAK', 'Kip', '₭'),
(54, NULL, NULL, 'LBP', 'Lebanese Pound', '£'),
(55, NULL, NULL, 'LKR', 'Sri Lanka Rupee', '₨'),
(56, NULL, NULL, 'LRD', 'Liberian Dollar', '$'),
(57, NULL, NULL, 'LTL', 'Lithuanian Litas', 'Lt'),
(58, NULL, NULL, 'LVL', 'Latvian Lats', 'Ls'),
(59, NULL, NULL, 'MKD', 'Denar', 'ден'),
(60, NULL, NULL, 'MNT', 'Tugrik', '₮'),
(61, NULL, NULL, 'MUR', 'Mauritius Rupee', '₨'),
(62, NULL, NULL, 'MXN', 'MXV Mexican Peso Mexican Unidad de Inversion (UDI)', '$'),
(63, NULL, NULL, 'MYR', 'Malaysian Ringgit', 'RM'),
(64, NULL, NULL, 'MZN', 'Metical', 'MT'),
(65, NULL, NULL, 'NGN', 'Naira', '₦'),
(66, NULL, NULL, 'NIO', 'Cordoba Oro', 'C$'),
(67, NULL, NULL, 'NOK', 'Norwegian Krone', 'kr'),
(68, NULL, NULL, 'NPR', 'Nepalese Rupee', '₨'),
(69, NULL, NULL, 'NZD', 'New Zealand Dollar', '$'),
(70, NULL, NULL, 'OMR', 'Rial Omani', '﷼'),
(71, NULL, NULL, 'PAB', 'USD Balboa US Dollar', 'B/.'),
(72, NULL, NULL, 'PEN', 'Nuevo Sol', 'S/.'),
(73, NULL, NULL, 'PHP', 'Philippine Peso', 'Php'),
(74, NULL, NULL, 'PKR', 'Pakistan Rupee', '₨'),
(75, NULL, NULL, 'PLN', 'Zloty', 'zł'),
(76, NULL, NULL, 'PYG', 'Guarani', 'Gs'),
(77, NULL, NULL, 'QAR', 'Qatari Rial', '﷼'),
(78, NULL, NULL, 'RON', 'New Leu', 'lei'),
(79, NULL, NULL, 'RSD', 'Serbian Dinar', 'Дин.'),
(80, NULL, NULL, 'RUB', 'Russian Ruble', 'руб'),
(81, NULL, NULL, 'SAR', 'Saudi Riyal', '﷼'),
(82, NULL, NULL, 'SBD', 'Solomon Islands Dollar', '$'),
(83, NULL, NULL, 'SCR', 'Seychelles Rupee', '₨'),
(84, NULL, NULL, 'SEK', 'Swedish Krona', 'kr'),
(85, NULL, NULL, 'SGD', 'Singapore Dollar', '$'),
(86, NULL, NULL, 'SHP', 'Saint Helena Pound', '£'),
(87, NULL, NULL, 'SOS', 'Somali Shilling', 'S'),
(88, NULL, NULL, 'SRD', 'Surinam Dollar', '$'),
(89, NULL, NULL, 'SVC', 'USD El Salvador Colon US Dollar', '$'),
(90, NULL, NULL, 'SYP', 'Syrian Pound', '£'),
(91, NULL, NULL, 'THB', 'Baht', '฿'),
(92, NULL, NULL, 'TRY', 'Turkish Lira', 'TL'),
(93, NULL, NULL, 'TTD', 'Trinidad and Tobago Dollar', 'TT$'),
(94, NULL, NULL, 'TWD', 'New Taiwan Dollar', 'NT$'),
(95, NULL, NULL, 'UAH', 'Hryvnia', '₴'),
(96, NULL, NULL, 'USD', 'US Dollar', '$'),
(97, NULL, NULL, 'UYU', 'UYI Peso Uruguayo Uruguay Peso en Unidades Indexadas', '$U'),
(98, NULL, NULL, 'UZS', 'Uzbekistan Sum', 'лв'),
(99, NULL, NULL, 'VEF', 'Bolivar Fuerte', 'Bs'),
(100, NULL, NULL, 'VND', 'Dong', '₫'),
(101, NULL, NULL, 'XCD', 'East Caribbean Dollar', '$'),
(102, NULL, NULL, 'YER', 'Yemeni Rial', '﷼'),
(103, NULL, NULL, 'ZAR', 'Rand', 'R');

-- --------------------------------------------------------

--
-- Table structure for table `hris_daily_time_records`
--

DROP TABLE IF EXISTS `hris_daily_time_records`;
CREATE TABLE IF NOT EXISTS `hris_daily_time_records` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_departments`
--

DROP TABLE IF EXISTS `hris_departments`;
CREATE TABLE IF NOT EXISTS `hris_departments` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `department_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hris_departments`
--

INSERT INTO `hris_departments` (`id`, `department_code`, `department_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'ESD', 'Engineering Services Department', 0, NULL, NULL),
(2, 'TSAD', 'Technical & Safety Audit Department', 0, NULL, NULL),
(3, 'TSD', 'Technical Services Department', 0, NULL, NULL),
(4, 'EO', 'Executive Office', 0, NULL, NULL),
(5, 'BDM', 'Business Development & Marketing Department', 0, NULL, NULL),
(6, 'IAD', 'Internal Audit Department', 0, NULL, NULL),
(7, 'QEHS', 'Quality, Environmental, Health and Safety Department', 0, NULL, NULL),
(8, 'POD', 'Property Operations Division', 0, NULL, NULL),
(9, 'POD', 'SBU1', 0, NULL, NULL),
(10, 'POD', 'SBU2', 0, NULL, NULL),
(11, 'POD', 'SBU3', 0, NULL, NULL),
(12, 'POD', 'SBU4', 0, NULL, NULL),
(13, 'POD', 'SBU5', 0, NULL, NULL),
(14, 'POD', 'SBU6', 0, NULL, NULL),
(15, 'POD', 'SBU7', 0, NULL, NULL),
(16, 'POD', 'SBU8', 0, NULL, NULL),
(17, 'POD', 'SBU9', 0, NULL, NULL),
(18, 'POD', 'SBU10', 0, NULL, NULL),
(19, 'FAD', 'Finance & Accounting Department', 0, NULL, NULL),
(20, 'CAD', 'Corporate Accounting Department', 0, NULL, NULL),
(21, 'PAD', 'Project Accounting Department', 0, NULL, NULL),
(22, 'CSSD', 'Corporate Support & Services Division', 0, NULL, NULL),
(23, 'GSD', 'General Support Department', 0, NULL, NULL),
(24, 'HRMD', 'Human Resources Management Department', 0, NULL, NULL),
(25, 'ITD', 'Information Technology Department', 0, NULL, NULL),
(26, 'LSD', 'Legal Services Department', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hris_document_types`
--

DROP TABLE IF EXISTS `hris_document_types`;
CREATE TABLE IF NOT EXISTS `hris_document_types` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notify_expiry` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expire_notification_month` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expire_notification_week` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expire_notification_day` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_educations`
--

DROP TABLE IF EXISTS `hris_educations`;
CREATE TABLE IF NOT EXISTS `hris_educations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hris_educations`
--

INSERT INTO `hris_educations` (`id`, `created_at`, `updated_at`, `name`, `description`) VALUES
(1, NULL, NULL, 'Bachelors Degree', 'Bachelors Degree'),
(2, NULL, NULL, 'Diploma', 'Diploma'),
(3, NULL, NULL, 'Masters Degree', 'Masters Degree'),
(4, NULL, NULL, 'Doctorate', 'Doctorate'),
(5, NULL, NULL, 'Vocational Course Graduate', 'Vocational Course Graduate');

-- --------------------------------------------------------

--
-- Table structure for table `hris_education_levels`
--

DROP TABLE IF EXISTS `hris_education_levels`;
CREATE TABLE IF NOT EXISTS `hris_education_levels` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hris_education_levels`
--

INSERT INTO `hris_education_levels` (`id`, `created_at`, `updated_at`, `name`) VALUES
(1, NULL, NULL, 'Unspecified'),
(2, NULL, NULL, 'High School or equivalent'),
(3, NULL, NULL, 'Certification'),
(4, NULL, NULL, 'Vocational');

-- --------------------------------------------------------

--
-- Table structure for table `hris_emergency_contacts`
--

DROP TABLE IF EXISTS `hris_emergency_contacts`;
CREATE TABLE IF NOT EXISTS `hris_emergency_contacts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_id` bigint(20) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `relationship` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_employees`
--

DROP TABLE IF EXISTS `hris_employees`;
CREATE TABLE IF NOT EXISTS `hris_employees` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_number` bigint(20) DEFAULT NULL,
  `employee_photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG',
  `firstname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middlename` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nationality` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `place_birth` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dependant` int(11) DEFAULT NULL,
  `marital_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_address` longtext COLLATE utf8mb4_unicode_ci,
  `home_address` longtext COLLATE utf8mb4_unicode_ci,
  `home_distance` int(11) DEFAULT NULL,
  `emergency_contact` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cert_level` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `field_study` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pagibig` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sss` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phic` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employment_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `private_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `joined_date` date DEFAULT NULL,
  `termination_date` date DEFAULT NULL,
  `job_title_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT '0',
  `supervisor` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pay_grade` int(11) DEFAULT NULL,
  `role_id` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ',',
  `last_login` bigint(20) NOT NULL DEFAULT '0',
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=489 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hris_employees`
--

INSERT INTO `hris_employees` (`id`, `employee_number`, `employee_photo`, `username`, `password`, `firstname`, `middlename`, `lastname`, `nationality`, `birthday`, `gender`, `place_birth`, `dependant`, `marital_status`, `work_address`, `home_address`, `home_distance`, `emergency_contact`, `emergency_no`, `cert_level`, `field_study`, `school`, `pagibig`, `sss`, `phic`, `employment_status`, `work_no`, `work_phone`, `work_email`, `private_email`, `joined_date`, `termination_date`, `job_title_id`, `department_id`, `supervisor`, `pay_grade`, `role_id`, `last_login`, `status`, `created_at`, `updated_at`) VALUES
(15, 212, '87cbc044-0b7e-3af9-8414-dd603ef68555.png', 'GSR212', '$2y$10$RA85V0hSCOLRjJQoqBBJvO9eNrG4WUFyxgv8PEXMlpdNsLfpsNIIm', 'GUILLERMO', 'SAPE', 'RAMIREZ JR.', 'Filipino', '1962-05-31', 'M', 'PARAÑAQUE', NULL, 'Married', NULL, '8170 BRGY. SAN DIONISIO SUCAT ROAD PARAÑAQUE', NULL, NULL, NULL, NULL, NULL, NULL, '101002231593', '3300591902', '190905167166', 'REGULAR', '9328853162', NULL, 'sample@sample.com', 'no2yram@yahoo.com', '1993-04-02', NULL, 72, NULL, NULL, NULL, ',,8,,', 0, 'active', '2020-08-24 02:18:09', '2020-08-27 04:09:57'),
(13, 157, 'pic1.png', 'NDP157', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'NAZARIO', 'DELA CRUZ', 'PARIAL', 'Filipino', '1962-01-09', 'M', 'BATAAN', NULL, 'Married', NULL, 'B11 L30 EVERGREEN HEIGHTS, GAYA-GAYA, SAN JOSE DEL MONTE CITY, BULACAN', NULL, NULL, NULL, NULL, NULL, NULL, '101002216715', '3306654801', '10501855788', 'CO-TERMINUS', '9216309663', NULL, NULL, 'junparial@yahoo.com', '1992-03-09', NULL, 48, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:09', '2020-08-24 02:18:09'),
(14, 177, 'pic2.png', 'CFB177', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'CAROLINE', 'FUNTANAR', 'BANDAIREL', 'FILIPINO', '1971-04-01', 'F', 'MANILA', NULL, 'Single', NULL, 'B27 L21/23 STA. ROSA HILLS, PUTING KAHOY, SILANG CAVITE', NULL, NULL, NULL, NULL, NULL, NULL, '101002216194', '3331632623', '20505041381', 'CO-TERMINUS', '9494603711 / 09778218397', NULL, NULL, 'cfbandairel@yahoo.com.ph', '1992-09-01', NULL, 8, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:09', '2020-08-24 02:18:09'),
(12, 121, 'pic1.png', 'CBF121', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'CEFERINO, JR.', 'BENIN', 'FABIAN', 'Filipino', '1959-10-17', 'M', 'PARAÑAQUE CITY', NULL, 'Married', NULL, '187 Pag-asa St. Caniogan, Pasig City', NULL, NULL, NULL, NULL, NULL, NULL, '101002224676', '359604445', '30501237511', 'REGULAR', '9166062336', NULL, NULL, 'bodgef@yahoo.com', '1991-09-02', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:09', '2020-08-24 02:18:09'),
(10, 60, 'pic1.png', 'DGD60', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'DONATO', 'GARCIA', 'DIN', 'FILIPINO', '1967-12-12', 'M', 'TAAL BATANGAS', NULL, 'Married', NULL, 'PHASE 5 BLOCK 6 LOT 31 MOLAVE DRIVE SORENTO TOWN HOME, HABAY BACOOR CAVITE', NULL, NULL, NULL, NULL, NULL, NULL, '101002216437', '3312786556', '190905166895', 'REGULAR', '9175917514', NULL, NULL, 'doodsgdin2@gmail.com', '1991-03-26', NULL, 13, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:09', '2020-08-24 02:18:09'),
(11, 69, 'pic1.png', 'MDC69', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MICHAEL', 'DIAZ', 'CARREON', 'Filipino', '1962-03-13', 'M', 'QUEZON CITY', NULL, 'Married', NULL, '137 L ASINAS ST SAN JUAN CITY', NULL, NULL, NULL, NULL, NULL, NULL, '101002216337', '375270316', '190905166941', 'CO-TERMINUS', '09198888983', NULL, NULL, NULL, '1994-10-05', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:09', '2020-08-24 02:18:09'),
(5, 456789, 'b1ff61af-9a74-3199-933d-1724bfdf04cc.png', 'hr.payroll', '$2y$10$s8lg0.CbxWNWThR6WqMPh.0ex0TY7OASJ.HztcOgv4U21WZBykNz2', 'Patrick', NULL, 'Badeo', NULL, NULL, 'male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sample@sample', 'sample@sample', NULL, NULL, 45, 15, '6', NULL, ',6,', 1598316828, 'active', '2020-08-24 02:06:52', '2020-08-25 15:53:31'),
(6, 78945612, 'dc69e36e-6b2f-3d67-910c-9c80522b75d7.png', 'hr.officer', '$2y$10$yUGSo/q/iNra3mFlAifHCejCdzcOfJ08NZ8gsnN1kcD/duJS0UJWy', 'Isay', NULL, 'Castillo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sample@sample.com', 'sample@sample.com', NULL, NULL, 45, 15, NULL, NULL, ',4,6,', 1598317233, 'active', '2020-08-24 02:13:04', '2020-08-25 16:01:37'),
(7, 123456789, '993d68b1-0918-349e-826e-badc828ea907.png', 'hr.officer2', '$2y$10$2bS2UEvZO3AsOz4VxpXtZOx3pvhaWKLEeNdM6isMNniGqqvQLzU9e', 'Tyson', NULL, 'Tan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sample@sample.com', 'sample@sample.com', NULL, NULL, 45, 15, NULL, NULL, ',6,', 1598317176, 'active', '2020-08-24 02:14:23', '2020-08-25 15:59:52'),
(8, 321321, '74cb9be6-c161-367d-b8fd-0ea42c99678b.png', 'hr.recruitment', '$2y$10$eaDb/w7EwlXCTJDtiYXF.OHaPhrYdk7SiBSudwWrPBN1csgqzJX9.', 'Joanne', NULL, 'Bauyon', NULL, NULL, 'female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sample@sample.com', 'sample@sample.com', NULL, NULL, 45, 15, NULL, NULL, ',6,', 1598418679, 'active', '2020-08-24 02:15:20', '2020-08-25 15:56:36'),
(9, 984562, 'pic2.png', 'hr.payroll2', '$2y$10$mwwqObMhxLOO9.sg14EGtu9ONRhdhYPhU3HlztInL5lON2GpVW3t6', 'Margett', NULL, 'Tolentino', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sample@sample.com', 'sample@sample.com', NULL, NULL, 45, 1, NULL, NULL, ',6,', 1598316924, 'active', '2020-08-24 02:16:09', '2020-08-25 15:55:12'),
(16, 251, 'pic1.png', 'JJP251', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JOSE ANGELITO', 'JIMENO', 'PEREZ', 'FILIPINO', '1961-04-13', 'M', 'DAVAO CITY', NULL, 'Married', NULL, 'UNIT 2E, GEN LUNA APTS,  #138 GEN LUNA ST., BGY. 15, CALOOCAN CITY', NULL, NULL, NULL, NULL, NULL, NULL, '101002216726', '909422064', '10501855346', 'REGULAR', '9153481479', NULL, NULL, 'ancelumiks04@yahoo.com', '1993-09-06', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:09', '2020-08-24 02:18:09'),
(17, 254, 'pic2.png', 'ATP254', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ANDREA', 'TECSON', 'PONCE', 'Filipino', '1969-11-30', 'F', 'PASIG CITY', NULL, 'Married', NULL, '#227 P. ROSALES ST., PATEROS, M.M.', NULL, NULL, NULL, NULL, NULL, NULL, '101002216748', '395540547', '60500991847', 'CO-TERMINUS', '09162270991', NULL, NULL, 'annietponce2003@yahoo.com', '1995-01-23', NULL, 9, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:09', '2020-08-24 02:18:09'),
(18, 286, 'pic2.png', 'LCC286', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'LELIS', 'CRUZ', 'CASTILLO', 'FILIPINO', '1965-07-18', 'F', 'PATEROS', NULL, 'Married', NULL, '521 T. SULIT ST., BRGY. AGUHO, PATEROS, METRO-MANILA', NULL, NULL, NULL, NULL, NULL, NULL, '101002217182', '3313888932', '10501311001', 'CO-TERMINUS', '0933-3962758', NULL, NULL, 'leni_718@yahoo.com.ph', '1994-01-04', NULL, 9, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:09', '2020-08-24 02:18:09'),
(19, 318, 'pic1.png', 'AGR318', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ARNEL', 'GALLARDO', 'ROMULO', 'Filipino', '1962-06-27', 'M', 'Luisiana, Laguna', NULL, 'Married', NULL, '128 Ganado Biñan, Laguna', NULL, NULL, NULL, NULL, NULL, NULL, '101002216815', '403480764', '10501855451', 'CO-TERMINUS', '9159331217', NULL, NULL, 'arnelromulo90@yahoo.com', '1994-03-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:09', '2020-08-24 02:18:09'),
(20, 336, 'pic1.png', 'RBB336', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RENATO', 'BUCE', 'BARCELONA', 'FILIPINO', '1969-11-26', 'M', 'TABACO ALBAY', NULL, 'Married', NULL, 'BLK 4 LOT 7 VILLA CRECENCIA,NAGPAYONG PASIG CITY', NULL, NULL, NULL, NULL, NULL, NULL, '101002216215', '397215469', '10501311958', 'CO-TERMINUS', '09106890073', NULL, NULL, NULL, '1994-05-20', NULL, 0, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:09', '2020-08-24 02:18:09'),
(21, 351, 'pic1.png', 'CMM351', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'CRISOSTOMO', 'MALACAMAN', 'MALASIQUE', 'FILIPINO', '1963-02-08', 'M', 'M. STO. TOMAS BATANGAS', NULL, 'Married', NULL, 'POB. 2 MALVAR ST, STO TOMAS BATANGAS', NULL, NULL, NULL, NULL, NULL, NULL, '101002216572', '405839821', '190905167514', 'REGULAR', '9235221093', NULL, NULL, 'arnel.malasique@yahoo.com', '1994-06-29', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:09', '2020-08-24 02:18:09'),
(22, 365, 'pic1.png', 'JDS365', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JOSE', 'DEL MUNDO', 'SAMUDIO', 'Filipino', '1961-06-19', 'M', 'Quezon City', NULL, 'Single', NULL, 'Blk 1 Lot 16 Villa Ricardo, Brgy. San Antonio, San Pedro, Laguna', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-6872', '39-162482-3', '10-50185564-8', 'CO-TERMINUS', '984-9295', NULL, NULL, 'JOEY61330@gmail.com', '1994-08-08', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:09', '2020-08-24 02:18:09'),
(23, 382, 'pic2.png', 'ALG382', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ARISTONA', 'LABOY', 'GARCIA', 'FILIPINO', '1962-08-06', 'F', 'ILOILO', NULL, 'Married', NULL, '#467 7TH ST. GHQ VILLAGE,  BGY. KATUPARAN, TAGUIG', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-6503', '37-936231-4', '10-50327371-9', 'CO-TERMINUS', '0915-610-0406', NULL, NULL, 'aries_8662@yahoo.com/ariesgarcia92395@gmail.com', '1994-08-29', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:09', '2020-08-24 02:18:09'),
(24, 390, 'pic2.png', 'JRE390', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JENNY', 'ROMULO', 'ESPIRITU', 'Filipino', '1967-07-04', 'F', 'LAGUNA', NULL, 'Married', NULL, '39 B. INTERIOR RIZAL STREET SAN PEDRO LAGUNA', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0223-4411', '33-0966773-0', '10501855516', 'CO-TERMINUS', '09332757973', NULL, NULL, 'jenrespiritu@yahoo.com', '1994-09-08', NULL, 28, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:09', '2020-08-24 02:18:09'),
(25, 418, 'pic1.png', 'FRD418', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'FRANKLIN', 'ROSALES', 'DELA CRUZ', 'Filipino', '1964-01-29', 'M', 'MANILA CITY', NULL, 'Married', NULL, 'B37 L7 PHASE 7 CARISSA HOMES SUBD. PUNTA TANZA CAVITE', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-6403', '37-556745-6', '10501311648', 'CO-TERMINUS', '9228113849', NULL, NULL, 'frankierdc@yahoo.com', '1995-01-17', NULL, 49, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:09', '2020-08-24 02:18:09'),
(26, 486, 'pic1.png', 'RMG486', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ROMEO', 'MANE', 'GECANA', 'Filipino', '1961-02-05', 'M', 'STA ROSA FLORIDA LAGUNA', NULL, 'Married', NULL, 'BLK 5 LOT 24 METROVILLE SUBD BGRY BAMBAGO STA ROSA LAGUNA', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-6515', '04-0545066-6', '19-090516699-2', 'CO-TERMINUS', '9094668013', NULL, NULL, NULL, '1995-04-27', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:09', '2020-08-24 02:18:09'),
(27, 495, 'pic1.png', 'EEA495', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'EDUARDO', 'ERNACIO', 'APOLINARIO', 'Filipino', '1963-02-05', 'M', 'TONDO, MANILA', NULL, 'Single', NULL, '1538 INT. QUIRINO AVE. PACO, MANILA', NULL, NULL, NULL, NULL, NULL, NULL, '101002216126', '388453719', '01-050131202-4', 'CO-TERMINUS', '9092604922', NULL, NULL, 'ee.apolinario05@gmail.com', '1995-08-16', NULL, 48, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:09', '2020-08-24 02:18:09'),
(28, 507, 'pic1.png', 'ABC507', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ANTONIO, JR.', 'BAUTISTA', 'CAPITO', 'Filipino', '1966-03-15', 'M', 'CABA LA UNION', NULL, 'Married', NULL, '76 MAGSAYSAY ST. SOUTH ADMIRAL VILLAGE PARAÑAQUE CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-6315', '108184022', '10501312172', 'REGULAR', '0922-820-2664', NULL, NULL, 'abcapito@fpdasia.net', '1995-04-17', NULL, 15, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:09', '2020-08-24 02:18:09'),
(29, 510, 'pic1.png', 'EDP510', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'EMILIO', 'DELA ROSA', 'PARADERO', 'Filipino', '1962-05-28', 'M', 'LEMERY BATANGAS', NULL, 'Married', NULL, '122 BARANGAY BUKAL LEMERY BATANGAS', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-6703', '03-7726164-0', '0905-0198-0128', 'CO-TERMINUS', '0912-7748-212', NULL, NULL, NULL, '1995-10-10', NULL, 57, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:09', '2020-08-24 02:18:09'),
(30, 527, 'pic1.png', 'MSV527', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MARLON', 'SEVEGAN', 'VENANCIO', 'Filipino', '1971-01-03', 'M', 'SAN AQUILINO ROXAS, MINDORO', NULL, 'Single', NULL, 'BLOCK 152 FORT ST. LAKAS BISIG SAN ANDRES CAINTA RIZAL', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-6937', '33-3458899-4', '10-50185588-5', 'CO-TERMINUS', '9295872257', NULL, NULL, NULL, '1995-11-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:09', '2020-08-24 02:18:09'),
(31, 541, 'pic1.png', 'AGM541', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ADONIS', 'GOZON', 'MANZANARES', 'Filipino', '1970-06-03', 'M', 'SAN PEDRO LAGUNA', NULL, 'Married', NULL, 'BLK 27,LOT 44 SOUTH VILL. 3-A SAN PEDRO LAGUNA', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-6637', '33-0549298-3', '10-50178575-5', 'CO-TERMINUS', '0906-5767562', NULL, NULL, 'adonismanzanares63@gmail.com', '1995-01-04', NULL, 0, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:09', '2020-08-24 02:18:09'),
(32, 554, 'pic1.png', 'AVP554', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ANTHONY', 'VALDERAMA', 'PACALLAGAN', 'FILIPINO', '1963-08-12', 'M', 'TONDO, MANILA', NULL, 'Married', NULL, 'BLK.-25, L-17 CAYAPONBO STA. MARIA VILLAGE, TAGUIG CITY', NULL, NULL, NULL, NULL, NULL, NULL, '101002216683', '374850724', '10501855745', 'CO-TERMINUS', '9327280700', NULL, NULL, NULL, '1996-01-16', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(33, 565, 'pic1.png', 'JCR565', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JOHN', 'CARREON', 'RAMOS', 'Filipino', '1970-12-22', 'M', 'QUEZON CITY', NULL, 'Married', NULL, '#51 MARYTOWN, LOYOLA HEIGHTS, Q.C.', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-6772', '33-0148738-7', '30-50267139-8', 'CO-TERMINUS', NULL, NULL, NULL, NULL, '1996-02-23', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(34, 632, 'pic2.png', 'GGJ632', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'GRAZIELLA', 'GARCIA', 'JOSE', 'Filipino', '1960-10-09', 'F', 'Manila', NULL, 'Married', NULL, '122 MH Del Pilar St., Sto. Tomas, Pasig City', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-6559', '03-5294991-6', '10-50131134-6', 'CO-TERMINUS', '09202891767  /  02-2136814', NULL, NULL, 'graziellajose@yahoo.com.ph', '1996-07-22', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(35, 646, 'pic1.png', 'HSE646', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'HADJILODIN', 'SANTILLAN', 'ESTOLLOSO', 'Filipino', '1968-11-22', 'M', 'CULASI ANTIQUE', NULL, 'Married', NULL, '12106 BRGY,178 DAGAT DAGATAN CAMARIN CALOOCAN CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-6494', '38-298009-7', '20503278252', 'CO-TERMINUS', '9208001301', NULL, NULL, NULL, '1996-08-05', NULL, 48, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(36, 650, 'pic1.png', 'AAB650', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ARMANDO', 'ARELLANO', 'BUNAG', 'Filipino', '1965-02-06', 'M', 'SAN LEONARDO NUEVA ECIJA', NULL, 'Married', NULL, '113 KATIPUNAN KALIWA EAST POINT BAGBAG NOVALICHES QEZON CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-6272', '36-912496-0', '10-50131185-0', 'CO-TERMINUS', '9198840478', NULL, NULL, NULL, '1996-08-20', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(37, 668, 'pic2.png', 'RLC668', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RONELIA', 'LAPITAN', 'CARITATIVO', 'Filipino', '1963-08-31', 'F', 'TARLAC, TARLAC', NULL, 'Married', NULL, '1334 H. KALIMBAS ST., STA. CRUZ, MANILA', NULL, NULL, NULL, NULL, NULL, NULL, '101-00221-6326', '038154237-1', '19-090516739-5', 'CO-TERMINUS', '09276331128', NULL, NULL, 'liezeler@yahoo.com', '1996-10-07', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(38, 713, 'pic1.png', 'RAV713', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RUFINO', 'AÑONUEVO', 'VILLANUEVA', 'Filipino', '1969-07-10', 'M', 'LAGUNA', NULL, 'Married', NULL, 'PUROK 1 STA. CRUZ STO. TOMAS BATANGAS', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-6959', '04-1037581-7', '10-50204672-7', 'CO-TERMINUS', '9279742007', NULL, NULL, NULL, '1997-01-23', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(39, 723, 'pic1.png', 'PTM723', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'POLICARPO III', 'TUMANDA', 'MANALASTAS', 'Filipino', '1970-06-14', 'M', 'Ozamiz City', NULL, 'Single', NULL, '6061D Fr. Gomez St., South Cembo, Makati City', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-6594', '33-1796443-8', '19-090516732-8', 'REGULAR', '0922-8029614', NULL, NULL, 'polimanalastas@yahoo.com', '1997-02-07', NULL, 31, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(40, 730, 'pic1.png', 'HCS730', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'HIPOLITO', 'CAMASIS', 'SALIDO JR. ', 'Filipino', '1960-06-12', 'M', 'PATEROS METRO MANILA', NULL, 'Married', NULL, '8-ALLEY 5 STA. ANA PATEROS METRO MANILA', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0223-3600', '35-271020-0', '10-50185561-3', 'CO-TERMINUS', '9184895303', NULL, NULL, 'hipolitosalido_valet@yahoo.com', '1997-02-24', NULL, 74, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(41, 793, 'pic1.png', 'MVV793', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MANUEL', 'VALENCIA', 'VILLANUEVA', 'Filipino', '1975-07-25', 'M', 'Quezon City', NULL, 'Married', NULL, 'C332 Smile Citi Homes, Novaliches, Quezon City', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-6948', '33-5137297-6', '19-090516607-0', 'CO-TERMINUS', '0999-1733578', NULL, NULL, 'sweetmanny75@yahoo.com', '1997-06-02', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(42, 824, 'pic1.png', 'DDD824', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'DANILO', 'DELUTE', 'DADEA', 'FILIPINO', '1964-03-04', 'M', 'MARIKINA CITY', NULL, 'Married', NULL, '1692 F. MUNOZ ST., PASAY CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-6372', '50-272579-9', '10-50131188-5', 'REGULAR', '9267361343', NULL, NULL, NULL, '1997-07-17', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(43, 878, 'pic2.png', 'JBC878', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JELYN', 'BAS', 'CELOS', 'Filipino', '1974-02-25', 'F', 'PANTAO LIBON', NULL, 'Single', NULL, 'ALLEY 26 BLK 68 LOT 31 PH2 A GRAND RIVERASIDE PASCAM I GEN. TRIAS CAVITE', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-6348', '33-4336424-8', '10-50131210-5', 'CO-TERMINUS', '9325731479', NULL, NULL, 'celosjelyn@yahoo.com', '1998-01-02', NULL, 65, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(44, 881, 'pic1.png', 'RPR881', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ROMEO', 'PANIZALES', 'RAZOTE', 'FILIPINO', '1961-07-01', 'M', 'MANILA', NULL, 'Married', NULL, '9441 RETIRO ST.GUADALUPE MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-6783', '03-8536832-8', '19-090516635-6', 'CO-TERMINUS', '0907-1649978', NULL, NULL, NULL, '1998-01-05', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(45, 890, 'pic1.png', 'AGS890', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ALBERTO', 'GRATIJA', 'SALOMON', 'Filipino', '1975-05-16', 'M', 'LIGAO CITY ALBAY', NULL, 'Married', NULL, 'B10 L23 PABAHAY 2000 BRGY. PARADAHAN II TANZA, CAVITE', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-6859', '33-3497088-7', '60-50099187-1', 'CO-TERMINUS', '0906-4941078', NULL, NULL, 'albertosalomon@yahoo.com', '1998-01-16', NULL, 52, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(46, 940, 'pic1.png', 'RDG940', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ROGELIO', 'DELFIN', 'GONZALES', 'Filipino', '1961-08-09', 'M', 'Lucena City', NULL, 'Married', NULL, '13 Velasquez St. BG Ilog Pasig City', NULL, NULL, NULL, NULL, NULL, NULL, '101002217024', '381025209', '10501311168', 'CO-TERMINUS', '9215192390', NULL, NULL, NULL, '1998-06-16', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(47, 941, 'pic1.png', 'RRA941', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RENANTE', 'ROSALES', 'ADOPTANTE', 'Filipino', '1974-12-19', 'M', 'PALANAS, MASBATE', NULL, 'Married', NULL, '#30 QUEZON ST. PINAGBUHATAN NAGPAYONG PASIG CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-7001', '33-5105517-0', '60-50099182-0', 'CO-TERMINUS', '0918-4593786', NULL, NULL, NULL, '1998-06-16', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(48, 954, 'pic1.png', 'FLM954', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'FELINO', 'LIBAO', 'MARAVE', 'FILIPINO', '1974-07-25', 'M', 'STA. CRUZ STO. TOMAS BATANGAS', NULL, 'Married', NULL, '#9A MULAWIN ST. JABSON SITE ROSARIO PASIG', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-7035', '04-0865313-0', '10-50178545-3', 'CO-TERMINUS', '9398071191', NULL, NULL, 'NONE', '1998-07-02', NULL, 56, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(49, 960, 'pic1.png', 'RSS960', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RAMON', 'SORREDA', 'SANTELICES', 'FILIPINO', '1956-12-31', 'M', 'SAN ANDRES CATANDUANES', NULL, 'Married', NULL, '33-ESTACID SUBD. MARTIREZ DEL 96 PATEROS, METRO MANILA', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-7081', '36-225118-6', '10-50185568-0', 'CO-TERMINUS', '9998778533', NULL, NULL, NULL, '1998-07-16', NULL, 74, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(50, 4011, 'pic1.png', 'JBR4011', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JIMBO', 'BARTOLOME', 'REYES', 'Filipino', '1976-05-05', 'M', 'MANILA', NULL, 'Single ', NULL, '915-J SAN ANTONIO ST., MALATE, MANILA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '34-3679480-6', ' 01-052118391-3', 'CO-TERMINUS', '0910486916 - person contact', NULL, NULL, 'reyesjimbo@gmail.com', '2014-02-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(51, 964, 'pic1.png', 'JPE964', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JOHNREFE', 'PELLAZAR', 'ESTELLOSO', 'Filipino', '1970-09-19', 'M', 'Bukidnon', NULL, 'Married', NULL, '3801 F. Nazario St. Singkamas Makati City', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-7046', '33-2946000-1', '19-090516593-7', 'CO-TERMINUS', '0915-4547635', NULL, NULL, 'johnrefe@yahoo.com/john_jpe@yahoo.com', '1998-08-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(52, 965, 'pic1.png', 'APO965', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ALEX', 'PAGLINAWAN', 'ORION', 'Filipino', '1973-12-12', 'M', 'Sasa Davao City', NULL, 'Married', NULL, '202 Guiho St. Brgy Cembo Makati City', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-7070', '09-14455398', '10-50185573-7', 'CO-TERMINUS', '0998-8598929', NULL, NULL, 'alexorion73@yahoo.com', '1998-08-03', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(53, 966, 'pic1.png', 'JPE966', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JONATHAN', 'PELLAZAR', 'ESTELLOSO', 'Filipino', '1974-12-12', 'M', 'BUKIDNON', NULL, 'Married', NULL, '38 MASVILLE AVE., SUCAT. BRGY. BF HOMES, PARNAQUE CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-7057', '33-2947338-6', '10-50131176-1', 'CO-TERMINUS', '09081052118', NULL, NULL, NULL, '1998-08-04', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(54, 993, 'pic1.png', 'JSA993', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JUANITO', 'SABLADA', 'ABENA', 'Filipino', '1965-01-05', 'M', 'MANILA', NULL, 'Married', NULL, '75 SAN RAFAEL ST MANDALUYONG CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-7147', '03-5599289-2', '01-052121184-4', 'CO-TERMINUS', '0999-7279025', NULL, NULL, NULL, '1998-10-01', NULL, 55, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(55, 1002, 'pic2.png', 'EPD1002', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ELEONOR', 'PRING', 'DIAZ', 'Filipino', '1971-04-29', 'F', 'PAMPANGA', NULL, 'Married', NULL, 'U20 MORNINGTON PLACE TAFT AVENUE PASAY CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-8401', '3338488977', '10501311680', 'CO-TERMINUS', '09216631613/09228631614', NULL, NULL, 'eleonordiaz@yahoo.com', '1998-11-03', NULL, 8, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(56, 1005, 'pic1.png', 'MGM1005', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MARK ANTHONY', 'GALIT', 'MORALES', 'Filipino', '1978-10-15', 'M', 'MANILA', NULL, 'Married', NULL, '32 KANLAON ST. MANDALUYONG CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-7193', '33-2843633-7', '19-090516639-9', 'CO-TERMINUS', '0917-3770126', NULL, NULL, NULL, '1998-11-04', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(57, 1022, 'pic1.png', 'JPN1022', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JOSEPH', 'PLUTADO', 'NUÑEZ', 'Filipino', '1976-08-24', 'M', 'NABUA CAMARINES SUR', NULL, 'Married', NULL, 'BLOCK 6 LOT 7 VIOLA ST. CAMELLA SORENTO PANAPAAN BACOOR CAVITE', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-5152', '33-5519879-0', '10-50178548-8', 'REGULAR', '0922-815-7406', NULL, NULL, 'jpnunez@fpdasia.net', '1999-01-27', NULL, 2, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(58, 1028, 'pic1.png', 'ACP1028', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ALDWIN', 'CUBILE', 'PAREJA', 'Filipino', '1975-03-26', 'M', 'PARAÑAQUE', NULL, 'Single', NULL, '610 GRUAR SUBDIVISION, 1ST ST. STO DOMINGO CAINTA RIZAL', NULL, NULL, NULL, NULL, NULL, NULL, '101002218392', '3353540489', '10501855761', 'CO-TERMINUS', '9055299621', NULL, NULL, 'parejaaldwin@yahoo.com', '1999-03-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(59, 1046, 'pic1.png', 'AGG1046', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ANDRES', 'GABOTERO', 'GALLARDO', 'Filipino', '1971-11-20', 'M', 'TONDO MANILA', NULL, 'Married', NULL, '2294 MALAYA ST. BALUT TONDO METRO MANILA', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-8446', '33-0821292-4', '10-50131179-6', 'CO-TERMINUS', '9272682893', NULL, NULL, 'gallardoandy20@gmail.com', '1999-05-12', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(60, 1080, 'pic1.png', 'RBC1080', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'REY', 'BASIERTO', 'CANDELARIO', 'Filipino', '1968-10-10', 'M', 'CATARMAN, NORTH SAMAR', NULL, 'Married', NULL, '#88 FORESTRY SITIO, MABILOG, BRGY. CULIAT, QUEZON CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-9512', '33-1067846-2', '190505929334', 'CO-TERMINUS', '09206528053', NULL, NULL, 'candelario_rey@yahoo.com', '1999-09-07', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(61, 1091, 'pic1.png', 'FDC1091', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'FELIX', 'DALUZ', 'CLAUDIO', 'FILIPINO', '1965-03-25', 'M', 'MANILA', NULL, 'Single', NULL, '1958 KAHILOM 2 STREET, PANDACAN , METRO MANILA ', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-9791', '38-593331-3', '10-50131211-3', 'CO-TERMINUS', '9488660624', NULL, NULL, NULL, '1999-10-26', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(62, 1098, 'pic1.png', 'ERH1098', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'EDUARDO', 'REVINA', 'HILOT', 'FILIPINO', '1970-05-07', 'M', 'QUEZON CITY', NULL, 'Married', NULL, 'B58, L8, PASSIFLORA ST. HARMONY HILLS 2 LOMA DE GATO, MARILAO, BULACAN', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-9812', '33-0322076-2', '19-051122583-7', 'CO-TERMINUS', '0908-4849447', NULL, NULL, 'edwardhilot@yahoo.com', '1999-11-09', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(63, 1100, 'pic1.png', 'JVL1100', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JERYMY', 'VILLAPANDO', 'LAYGO', 'Filipino', '1978-09-04', 'M', NULL, NULL, 'Married', NULL, 'STA CRUZ STO TOMA BATANGAS', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-9823', '33-5046503-3', '10-50131137-0', 'CO-TERMINUS', '09215302322', NULL, NULL, 'jerymylaygo@yahoo.com', '1999-11-11', NULL, 48, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(64, 1105, 'pic1.png', 'RRB1105', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ROGER', 'RETORIANO', 'BARRERA', 'Filipino', '1964-02-21', 'M', 'CAINTA RIZAL', NULL, 'Married', NULL, 'FLOODWAY CAINTA RIZAL', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-9856', '33-0103817-6', '10-50131193-1', 'CO-TERMINUS', NULL, NULL, NULL, NULL, '1999-12-11', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(65, 1127, 'pic1.png', 'PPN1127', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'PAULO', 'PLOTADO', 'NUÑEZ', 'FILIPINO', '1969-03-01', 'M', 'NABUA CAMSUR', NULL, 'Married', NULL, 'ROSARIO, BATANGAS', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-9956', '33-4440813-2', '10-50178531-3', 'CO-TERMINUS', '0906-9574176', NULL, NULL, 'paulonuñez1@yahoo.com', '2000-02-12', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(66, 1133, 'pic1.png', 'MMM1133', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MELO', 'MENDEZ', 'MARTIN', 'FILIPINO', '1970-07-17', 'M', 'UMINGAN, PANGASINAN', NULL, 'Married', NULL, 'BLK.3-C, LOT 4, VOLTERRA ST., COURTYARD OF MAIA ALTA, ', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-9980', '33-3214801-9', '10-50178535-6', 'CO-TERMINUS', '0918-591-6932', NULL, NULL, 'melommartin@yahoo.com.ph', '2000-03-22', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(67, 1151, 'pic1.png', 'JBO1151', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JOSE', 'BERMILLO', 'ONSAY', 'Filipino', '1965-08-27', 'M', 'ALBAY', NULL, 'Married', NULL, 'PH2 SEC. 1 BLK 14 LOT 25 BELVEDER TANZA CAVITE CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-0034', '03-7579901-7', '10-50185718-7', 'CO-TERMINUS', '0906-9759388', NULL, NULL, 'j.onsay@yahoo.com', '2000-05-15', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(68, 1155, 'pic1.png', 'GTP1155', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'GLENN', 'TARIGA', 'PINEDA', 'Filipino', '1976-12-23', 'M', 'MANILA', NULL, 'Married', NULL, '9 DAMAYAN ST. BAGONG SILANG, CALOOCAN CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-0045', '33-4781961-8', '10-50185556-7', 'CO-TERMINUS', '9463430307', NULL, NULL, 'glennpineda076@yahoo.com', '2000-05-22', NULL, 52, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(69, 1167, 'pic1.png', 'RSB1167', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ROLLY', 'SALES', 'BASILLA', 'FILIPINO', '1976-01-17', 'M', 'CAMARINES SUR', NULL, 'Married', NULL, 'UNIT 205 UP DELTA LAMBDA GK VILLAGE PHASE I, PINAGSAMA TAGUIG CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-0068', '33-2215709-4', '19-090516711-5', 'CO-TERMINUS', '9189913245', NULL, NULL, 'N/A', '2000-07-17', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(70, 1200, 'pic1.png', 'NGS1200', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'NOEL', 'GUINO', 'SAMONTE', 'Filipino', '1965-07-29', 'M', 'SAN JUAN BATANGAS', NULL, 'Married', NULL, '213 PUROK 5 STA. CRUZ STO TOMAS BATANGAS', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-0257', '39-900527-9', '10-50185562-1', 'CO-TERMINUS', '0999-477-80-29', NULL, NULL, NULL, '2000-10-10', NULL, 56, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(71, 1228, 'pic1.png', 'DBA1228', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'DHARRY', 'BASCO', 'AQUINO', 'Filipino', '1974-04-26', 'M', 'CALOOCAN CITY', NULL, 'Married', NULL, '159 O. REYES ST. SANTULAN, MALABON CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-0413', '33-3935397-5', '19-090516577-5', 'CO-TERMINUS', '9204852888', NULL, NULL, 'dharry_aquino@yahoo.com.ph', '2000-12-15', NULL, 69, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(72, 1234, 'pic1.png', 'BVV1234', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'BILLY', 'VALDEZ', 'VILLANUEVA', 'FILIPINO', '1972-08-16', 'M', 'PIAZ VILLASIS PANGASINAN', NULL, 'Married', NULL, '44G-A PALMERA ST. SAMPALOC MANILA', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-0524', '33-0947977-9', '10-50204672-7', 'CO-TERMINUS', '09268181061', NULL, NULL, 'leeken_16@yahoo.com', '2001-01-02', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(73, 1247, 'pic1.png', 'EGS1247', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ELMER', 'GOMEZ', 'SISON', 'Filipino', '1966-07-01', 'M', 'ALAMINOS, PANGASINAN', NULL, 'Married', NULL, '20 RD2 LOT 2 LUPANG ARENDA ST TAYTAY RIZAL', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-0613', '03-8798322-2', '10-50185583-4', 'CO-TERMINUS', '9103687814', NULL, NULL, 'N/A', '2001-01-30', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(74, 1266, 'pic1.png', 'RAA1266', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RODGIE', 'ARDENIA', 'AREVALO', 'FILIPINO', '1971-12-30', 'M', 'TALISAY NEGROS OCCIDENTAL', NULL, 'Married', NULL, 'B10 L2 SIMONA SUBD. BRGY. SAN ISIDRO TAYTAY, RIZAL', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-0557', '3332604113', '19-051525917-5', 'CO-TERMINUS', '9395955943', NULL, NULL, 'gienikai.comshop@yahoo.com', '2001-01-26', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(75, 1285, 'pic1.png', 'DVV1285', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'DENNIS', 'VALENCIA', 'VILLANUEVA', 'FILIPINO', '1978-10-10', 'M', 'LIPA CITY', NULL, 'Married', NULL, 'LIPA CITY BATANGAS', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-0624', '43-169808-1', '09-05003416-4', 'CO-TERMINUS', NULL, NULL, NULL, NULL, '2001-02-20', NULL, 56, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(76, 1290, 'pic1.png', 'ADD1290', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ANASTACIO', 'DE LEON', 'DIMACUHA', 'Filipino', '1972-07-26', 'M', 'BATANGAS CITY', NULL, 'Married', NULL, '                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               ', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-0724', '33-1885297-6', '10-50131212-1', 'CO-TERMINUS', '9263503204', NULL, NULL, NULL, '2001-03-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(77, 1299, 'pic1.png', 'MOV1299', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MIGUEL', 'OMANDAC', 'VERGARA', 'Filipino', '1962-08-28', 'M', 'MINDANAO', NULL, 'Married', NULL, '7 UNIVERSITY VALLEY OLD BALARA QUEZON CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-0746', '33-0002242-6', '19-089098980-6', 'CO-TERMINUS', '099555-98326', NULL, NULL, NULL, '2001-03-07', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(78, 1302, 'pic1.png', 'ENM1302', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'EMIL', 'NAVARRO', 'MALICAT', 'FILIPINO', '1978-02-08', 'M', 'BATANGAS', NULL, 'Married', NULL, '2190-B LEVERIZA ST. PASAY CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-0735', '04-3173954-2', '90-50191170-3', 'CO-TERMINUS', '9083756666', NULL, NULL, 'pikit238@yahoo.com.ph', '2001-03-15', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(79, 1327, 'pic1.png', 'VBP1327', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'VENER', 'BASILIO', 'PONCE', 'Filipino', '1964-10-15', 'M', 'Makati', NULL, 'Married', NULL, '2775 Buencamino Street, Makati City', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-6759', '03-7556746-9', '10-50185557-5', 'CO-TERMINUS', '0915-8514979', NULL, NULL, 'benj0015@yahoo.com', '2001-05-01', NULL, 17, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(80, 1343, 'pic1.png', 'RSG1343', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RAMIL', 'SUA', 'GALLANO', 'Filipino', '1977-07-15', 'M', 'TONDO MANILA', NULL, 'Married', NULL, '31 SAN JOSE ST. BARANGAY SAN ANTONIO QUEZON CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-0881', '33-2897541-6', '19-051388821-3', 'REGULAR', NULL, NULL, NULL, NULL, '2001-06-27', NULL, 1, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(81, 1366, 'pic2.png', 'SMA1366', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'SHIELA', 'MARTINEZ', 'ARCE', 'Filipino', '1978-02-10', 'F', 'QUEZON CITY', NULL, 'Married', NULL, 'BLK 33 LOT 6 VIOLETA ST. ZONE 7, PEMBO, MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-0924', '33-5029832-3', '19-090516605-4', 'CO-TERMINUS', '9176496054', NULL, NULL, 'cielomartinez1018@yahoo.com', '2001-08-22', NULL, 65, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(82, 1372, 'pic1.png', 'JLA1372', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JUVENAL', 'LADARAN', 'ABELLERA', 'Filipino', '1976-10-17', 'M', 'SAN JUAN METRO MANILA', NULL, 'Married', NULL, '298 VILLAMOR ST. BGDY TIBAGAN SAN JUAN CITY METRO MANILA', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-0981', '91-820917-1', '10-50131205-9', 'CO-TERMINUS', '9234082341', NULL, NULL, 'juvenalabellera@gmail.com', '2001-09-03', NULL, 50, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(83, 1396, 'pic1.png', 'ESD1396', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ERNESTO', 'SACAYAN', 'DE VERA', 'Filipino', '1964-11-28', 'M', 'Naga City', NULL, 'Married', NULL, '8344 Brgy Del Remedio San Pablo, Laguna', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-1055', '33-7684319-2', '10-50131162-1', 'REGULAR', '0930-1383460', NULL, NULL, 'ernestodevera1964@yahoo.com', '2001-11-09', NULL, 55, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(84, 1400, 'pic1.png', 'GBB1400', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'GERARDO', 'BENDIOLA', 'BARRIOS', ' Filipino', '1969-11-10', 'M', 'SABANG, CALABANGA, CAMARIÑAS SUR', NULL, 'Married', NULL, 'BLK. 276 LOT 5 ADARNA ST. BRGY. RIZAL, MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-1067', '50-373757-9', '20-50410371-5', 'CO-TERMINUS', '9064611117', NULL, NULL, 'NA', '2001-11-24', NULL, 55, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(85, 1408, 'pic1.png', 'EBR1408', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'EDWIN', 'BANDOLIN', 'RAPER', 'FILIPINO', '1962-07-21', 'M', NULL, NULL, 'Married', NULL, 'BLK 58 LOT 23 PHASE 2 EAST WOOD RESIDENCE RODRIGUEZ RIZAL', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-1112', '03-6757232-3', '19-050820147-1', 'REGULAR', '9177234905', NULL, NULL, 'fitout.manager@thenetbuildings.ph', '2002-01-02', NULL, 40, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(86, 1410, 'pic1.png', 'ESD1410', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'EDWIN', 'SARONG', 'DELOS ANGELES', 'FILIPINO', '1972-01-10', 'M', 'MARIKINA', NULL, 'Single', NULL, '44 ST. PEREGRINE ST. FR. H-D-L-C HOMES BARGY. MARIKINA CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-1391', '33-3681772-8', '01-052118382-4', 'CO-TERMINUS', '9201208241', NULL, NULL, 'edelosangeles@yahoo.com', '2002-01-05', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(87, 1429, 'pic2.png', 'RDP1429', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ROSARIO', 'DEQUIÑA', 'PALLERA', 'Filipino', '1964-04-23', 'F', 'LAS PIÑAS', NULL, 'Married', NULL, '234 REAL ST., E. ALDANA  LAS PINAS CITY  ', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-1168', '37-746737-6', '19-051869096-9', 'REGULAR', '9228209045', NULL, NULL, 'chat_pallera@yahoo.com', '2002-03-09', NULL, 58, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(88, 1434, 'pic1.png', 'FGS1434', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'FERNANDO', 'GONZALES', 'SEVILLA', 'Filipino', '1968-10-14', 'M', 'MANILA', NULL, 'Married', NULL, '21 WEST RIVERSIDE ST. S.F.D.M. QUEZON CITY', NULL, NULL, NULL, NULL, NULL, NULL, '101-00222-1212', '3-8483685-1', '19-090516610-0', 'CO-TERMINUS', '9994145591', NULL, NULL, 'NA', '2002-04-16', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(89, 1441, 'pic2.png', 'BPM1441', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'BERNARDITA', 'PENAFLOR', 'MANASAN', 'Filipino', '1961-12-16', 'F', 'BATAAN', NULL, 'Single', NULL, '28 NOTREDAME ST EASTSIDE MANORS, RAYMUNDO AVE, PASIG', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-1200', '20-590108-5', '19-050834391-8', 'REGULAR', '9189119947', NULL, NULL, '             bpmanasan@yahoo.com.ph', '2002-05-20', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(90, 1444, 'pic2.png', 'ERT1444', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'EVELYN', 'RODRIGUEZ', 'TIMBAL', 'Filipino', '1963-11-23', 'F', 'BATO, CATANDUANES', NULL, 'Single', NULL, 'B9 L3 HOLLAND ST, FRANCEVILLE HOMES, SILANG CAVITE', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-1223', '3-7178296-3', '19-051781366-8', 'REGULAR', '0977-6897570', NULL, NULL, 'ertimbal@fpdasia.net', '2002-05-16', NULL, 59, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(91, 1465, 'pic2.png', 'MLG1465', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MARIA GRETA', 'LEGASPI', 'GARCIA', 'Filipino', '1967-12-17', 'F', 'PASAY CITY', NULL, NULL, NULL, 'B7 L15 SYCAMORE ST PACITA COMPLEX 2 SAN PEDRO LAGUNA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, ' 03-8718051-7', '01-050915834-2', 'REGULAR', '9178835930', NULL, NULL, 'OPERATIONS.MANAGER@NETBUILDINGS.PH', '2002-10-10', NULL, 60, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(92, 1480, 'pic1.png', 'SDS1480', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'SHELDON', 'DEAN', 'SALVO', 'Filipino', '1969-06-22', 'M', 'ORMOC CITY LEYTE', NULL, 'Married', NULL, '810-BATAAN ST. SAMPALOC MANILA', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0221-6861', '33-0595623-8', '10-50628787-7', 'CO-TERMINUS', '9777211042', NULL, NULL, 'sheldonsalvo_valet@yahoo.com', '2002-12-16', NULL, 74, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(93, 1488, 'pic1.png', 'ABD1488', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ALEXANDER', 'BUTE', 'DOSOL', 'FILIPINO', '1962-11-05', 'M', 'BOHOL', NULL, 'Single', NULL, 'BLK 10 LT 1 CAMIA ST. T.S. CRUZ SUB. ALMANZA II LAS PIÑAS CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-1800', '39-100346-0', '10-50131169-9', 'CO-TERMINUS', 'N/A', NULL, NULL, NULL, '2002-12-26', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(94, 1536, 'pic1.png', 'VCM1536', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'VERGEL', 'COLARENA', 'MANILAG', 'FILIPINO', '1959-07-30', 'M', 'CAMARINES SUR', NULL, 'Married', NULL, 'BLK 7 LOT 32 PHASE 1 LL CUBURAN, SAN ISIDRO RODRIGUEZ, RIZAL', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-0801', '33-4382977-0', '19-052147113-5', 'CO-TERMINUS', NULL, NULL, NULL, NULL, '2003-07-15', NULL, 27, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(95, 1537, 'pic1.png', 'EMV1537', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'EMERSON ', 'MEDALLA', 'VILLANO ', 'FILIPINO', '1980-11-16', 'M', 'BALAYAN, BATANGAS', NULL, 'Married', NULL, '1717 ANDALUCIA ST., STA. CRUZ MANILA ', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-2088', '33-7285857-6', '19-089428227-8', 'CO-TERMINUS', '0917-5143192', NULL, NULL, 'villanosonny@yahoo.com.ph', '2003-07-28', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(96, 1558, 'pic2.png', 'EFB1558', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ELLEN', 'FERNANDO', 'BALINGUE', 'Filipino', '1981-03-20', 'F', 'PATEROS METRO MANILA', NULL, 'Married', NULL, 'BLOCK 1 LOT 15 SAMASIPAT HOME OWNERS ASSOCIATION STA ANA TAGUIG CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-2133', '33-7864371-4', '19-089895564-1', 'CO-TERMINUS', '9293888601', NULL, NULL, 'ellenbalingue@yahoo.com', '2003-10-06', NULL, 9, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(97, 1567, 'pic1.png', 'APA1567', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ARMANDO', 'PARCON', 'ARTICULO', 'Filipino', '1963-03-14', 'M', 'E.B. MAGALONA', NULL, 'Married', NULL, 'BLK3 LOT 7 MOLINO HOMES  1 SUBD. MOLINO 3, BACOOR CITY, CAVITE', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-2233', '03-6462205-6', '19-051924238-2', 'CO-TERMINUS', '9391446459', NULL, NULL, 'armando_articulo@yahoo.com', '2003-10-27', NULL, 21, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(98, 1568, 'pic1.png', 'LBF1568', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'LICERIO', 'BUNAO', 'FREDELUCES', 'Filipino', '1972-07-23', 'M', 'DASOL, PANGASINAN', NULL, 'Married', NULL, 'Blk 3 Lot 7 Lupang Pangako, Payatas, QC', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-2255', '33-3791599-1', '19-090516588-0', 'CO-TERMINUS', '9277419058', NULL, NULL, 'licerio_fredeluces@yahoo.com/iyongfredeluces@yahoo.com', '2003-10-27', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(99, 1582, 'pic1.png', 'WAN1582', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'WILLIE', 'ALFEREZ', 'NARANJA', 'Filipino', '1966-10-25', 'M', 'ZAMBALES', NULL, 'Married', NULL, '240 SITIO MATATAG WESTERN BICUTAN, TAGUIG CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-2844', '02-0795427-6', '19-050094165-4', 'REGULAR', '0922-8203159', NULL, NULL, NULL, '2004-01-06', NULL, 30, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(100, 1632, 'pic1.png', 'RVD1632', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ROBERTO', 'VINLUAN', 'DELOS SANTOS', 'Filipino', '1965-11-21', 'M', 'SAN CARLOS CITY', NULL, 'Married', NULL, '0036 AREA 7 BRGY BOTOCAN, PROJECT 2 QUEZON CITY ', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-3143', '33-0569521-4', '05-050048675-6', 'CO-TERMINUS', '895-1229', NULL, NULL, 'N/A', '2004-05-25', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(101, 1666, 'pic1.png', 'DGF1666', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'DIONISIO,JR.', 'GARCIA', 'FABRO', 'Filipino', '1968-12-29', 'M', 'PANGASINAN', NULL, 'Married', NULL, 'BLOCK 44 KALAYAAN AVE. PITUGO MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-3399', '33-1064524-6', '01-050131178-8', 'REGULAR', NULL, NULL, NULL, 'pjfabro@tyahoo.com', '2004-08-02', NULL, 72, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(102, 1669, 'pic1.png', 'ODA1669', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'OLIVER', 'DIZON', 'ALULOD', 'Filipino', '1971-07-02', 'M', 'BINONDO, MANILA', NULL, 'Married', NULL, '891 P. ABAD SANTOS ST., TONDO MANILA', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-3377', '33-0719714-7', '19-051268074-0', 'CO-TERMINUS', '0915-444-9922', NULL, NULL, 'oliver.alulod@yahoo.com.ph', '2004-08-03', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(103, 1684, 'pic2.png', 'RRD1684', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ROWENA', 'REYES', 'DE GUZMAN', 'FILIPINO', '1968-10-24', 'F', 'MANILA', NULL, 'Married', NULL, '#3 EVARDONI ST. SAN FRANCISCO DEL MONTE QUEZON CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-3666', '33-0767998-2', '19-051741124-1', 'REGULAR', '9228244902', NULL, NULL, 'rordeguzman@yahoo.com.ph', '2004-10-01', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10');
INSERT INTO `hris_employees` (`id`, `employee_number`, `employee_photo`, `username`, `password`, `firstname`, `middlename`, `lastname`, `nationality`, `birthday`, `gender`, `place_birth`, `dependant`, `marital_status`, `work_address`, `home_address`, `home_distance`, `emergency_contact`, `emergency_no`, `cert_level`, `field_study`, `school`, `pagibig`, `sss`, `phic`, `employment_status`, `work_no`, `work_phone`, `work_email`, `private_email`, `joined_date`, `termination_date`, `job_title_id`, `department_id`, `supervisor`, `pay_grade`, `role_id`, `last_login`, `status`, `created_at`, `updated_at`) VALUES
(104, 1708, 'pic2.png', 'LHG1708', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'LIDUVINA', 'HADLOCON', 'GACUTE', 'Filipino', '1971-04-14', 'F', 'Southern Leyte', NULL, 'Married', NULL, 'Blk 2 Lot 42 La Terraza 1A, Bucandala Imus Cavite', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-3754', '33-0191473-7', '19-052409139-2', 'CO-TERMINUS', '9778035320', NULL, NULL, 'bing_gacute@yahoo.com', '2004-10-21', NULL, 9, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(105, 1710, 'pic1.png', 'ABJ1710', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ALAN', 'BACARON', 'JINGABO', 'FILIPINO', '1968-01-26', 'M', 'BACOLOD CITY', NULL, 'Single', NULL, '35 YAKAL ST. CRISTINA SUBD. CONCEPCION MARIKINA', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-3766', '07-1307058-9', '01-052118385-9', 'CO-TERMINUS', '0977-2196262', NULL, NULL, 'ajjingabo@gmail.com', '2004-10-22', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(106, 1717, 'pic1.png', 'TFF1717', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'TEODOLFO', 'FESTIJO', 'FRONDA', 'Filipino', '1971-04-05', 'M', 'SITIO BIBIT BRGY MAYAMOT ANTIPOLO CITY', NULL, 'Single', NULL, 'SITIO BIBIT BRGY MAYAMOT ANTIPOLO CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-3743', '33-3474203-1', '01-051987654-5', 'CO-TERMINUS', '9152988841', NULL, NULL, 'N/A', '2004-11-11', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(107, 1721, 'pic1.png', 'CHQ1721', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'CEAZAR', 'HILADO', 'QUIAMBAO', 'Filipino', '1967-09-16', 'M', 'PASIG CITY', NULL, 'Married', NULL, '463 DAANG BAKAL ST. HAGDAN BATO, LIBIS, MANDALUYONG CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-3808', '03-9011199-7', '19-051533753-2', 'CO-TERMINUS', '9232761985', NULL, NULL, 'ceazarquiambao@yahoo.com', '2004-11-16', NULL, 48, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(108, 1725, 'pic2.png', 'HDR1725', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'HILYN ', 'DEGOMA', 'ROSETE', 'Filipino', '1982-04-16', 'F', 'Ilo-ilo City', NULL, 'Married', NULL, '7116 General Ricarte St. South Cembo makati City', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-3954', '07-2142257-2', '19-090254625-5', 'CO-TERMINUS', '0920-5366339', NULL, NULL, 'feudzzy_82@yahoo.com', '2004-11-22', NULL, 9, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(109, 1740, 'pic1.png', 'FPP1740', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'FERNANDO', 'PEREZ', 'POSADAS', 'FILIPINO', '1961-12-09', 'M', 'SAN CARLOS CITY PANGASINAN', NULL, NULL, NULL, '126 NARRA ST. PROJECT 3 QUEZON CITY', NULL, NULL, NULL, NULL, NULL, NULL, '0005-054589-02', '35-948639-1', '03-050243315-2', 'REGULAR', '9228820313', NULL, NULL, 'posadas_fernando@yahoo.com', '2005-02-01', NULL, 34, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(110, 1770, 'pic1.png', 'STT1770', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'SANITO', 'TORRECAMPO', 'TRESVALLES', 'Filipino', '1975-04-27', 'M', 'BATO CATANDUANES', NULL, 'Married', NULL, 'EPHESUS ST. DELARA COMPOUND MULTINATIONAL VILLAGE MOONWALK PARANAQUE', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-4798', '33-3860179-6', '19-089528304-9', 'CO-TERMINUS', '0939-868-9821', NULL, NULL, NULL, '2005-04-18', NULL, 56, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(111, 1775, 'pic1.png', 'EPP1775', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ERNESTO', 'PASTORFIDE', 'PASTORFIDE JR', 'Filipino', '1978-07-27', 'M', 'MAKATI CITY', NULL, 'Married', NULL, 'BLK 251 LOT 28 JUPITER STREET PEMBO MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-4765', '33-4298239-1', '19-051120948-3', 'CO-TERMINUS', '0932-5801482', NULL, NULL, 'N/A', '2005-05-05', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(112, 1776, 'pic1.png', 'NAD1776', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'NILO', 'AGUILLON', 'DELGADO', 'FILIPINO', '1972-05-26', 'M', 'MAKATI CITY', NULL, 'Married', NULL, 'BLK 167 LOT 04 CALACHUCHI ST PEMBO MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-4753', '33-0512260-6', '19-089311842-3', 'CO-TERMINUS', '9489145088', NULL, NULL, 'nad888fpd@gmail.com', '2005-05-05', NULL, 69, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(113, 1787, 'pic1.png', 'OBP1787', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'OLIVER ', 'BALUYOT', 'PUNTIL', 'Filipino', '1971-08-21', 'M', 'Quezon City', NULL, 'Single', NULL, '54 Tampoy St., Proj. 2, Q.C.', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-4776', '33-2277470-7', '19-050911945-0', 'REGULAR', '0925-5444-727', NULL, NULL, 'obp821@yahoo.com.ph', '2005-05-15', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(114, 1806, 'pic1.png', 'RAI1806', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ROLANDO', 'ABRIZA', 'ILAO', 'Filipino', '1961-10-08', 'M', 'BILOGO, TAYSAN, BATANGAS', NULL, 'Married', NULL, 'BLK. 22 LOT 8 PH. 8 PARKLANE BRGY. SANTIAGO, GEN. TRIAS, CAVITE', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-5418', '04-0305265-5', '19-051547747-4', 'CO-TERMINUS', '9475185386', NULL, NULL, 'NA', '2005-07-05', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(115, 1821, 'pic2.png', 'LCR1821', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'LILYBETH', 'CAPULONG', 'RONQUILLO', 'FILIPINO', '1973-02-26', 'F', 'PAMPANGA', NULL, 'Single', NULL, '171-S 22ND AVE. EAST REMBO FORT BONIFACIO, MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-5986', '02-1562755-3', '19-050976396-1', 'CO-TERMINUS', '0977-8165090', NULL, NULL, 'lilybethronquillo@yahoo.com', '2005-08-25', NULL, 0, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(116, 1822, 'pic1.png', 'BDB1822', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'BERNARDO', 'DEMONTERVEDE', 'BILBAO', 'Filipino', '1970-12-02', 'M', 'SARA, ILO-ILO CITY', NULL, 'Married', NULL, 'LOT 10, BLK. 1,BAGONG SILANG, SUCAT, MUNTINLUPA.', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-5930', '33-0960721-1', '01-050327373-5', 'CO-TERMINUS', '9277102306', NULL, NULL, 'bernardobilbao171@gmail.com', '2005-08-29', NULL, 48, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(117, 4002, 'pic1.png', 'DHR4002', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'DEMOCRITO', 'HERADA', 'ROSALIM JR.', 'FILIPINO', '1973-09-05', 'M', 'CADIZ CITY, OCC.', NULL, 'Married ', NULL, '104 4TH ST. KAINGIN II, HALIK ALON STO. NIÑO PARAÑQUE CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1211-1479-3126', '33-1343094-0', '01-050636257-7', 'CO-TERMINUS', '9279502640', NULL, NULL, 'democrito.rosalem@gmail.com', '2014-01-17', NULL, 42, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(118, 1825, 'pic1.png', 'ESB1825', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'EDMUNDO', 'SILABA', 'BEATO', 'FILIPINO', '1968-09-04', 'M', 'NABUA CAMSUR', NULL, 'Married', NULL, 'BLK 2 L11 PH2 ANONAS ST. SP WEST CAMELLA HOMES MOLINO 3 BACOOR, CAVITE CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-5929', '05-0373858-1', '06-050099186-3', 'CO-TERMINUS', NULL, NULL, NULL, NULL, '2005-09-03', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(119, 1827, 'pic2.png', 'LLE1827', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'LOMIE', 'LABRADOR', 'ERESUELO', 'Filipino', '1981-05-14', 'F', 'NEGROS OCIDENTAL', NULL, 'Single', NULL, '2823 UNIT B BORNEO ST. SAN ISIDRO MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-5941', '33-9135975-5', '02-050052014-1', 'CO-TERMINUS', '9178105141', NULL, NULL, 'mimi_eresuelo@yahoo.com', '2005-09-12', NULL, 9, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(120, 1834, 'pic1.png', 'RMM1834', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'REX', 'MALGAPO', 'MASAGCA', 'Filipino', '1975-01-28', 'M', '42B SAINT MICHAEL STREET, LA COLONIA TOWN HOME, PARANAQUE CITY', NULL, 'Single', NULL, '42B SAINT MICHAEL STREET, LA COLONIA TOWN HOME, PARANAQUE CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-6274', '33-9563102-6', '01-052118387-5', 'CO-TERMINUS', '09293979148', NULL, NULL, 'masagcarex@yahoo.com', '2005-09-22', NULL, 0, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(121, 1851, 'pic1.png', 'OBA1851', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'OSCAR', 'BALUCA', 'ABINAL', 'FILIPINO', '1973-04-13', 'M', 'NABUA CAM. SUR', NULL, 'Married', NULL, '7U J VILENCIO ST MANDALUYONG CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-6585', '33-2845848-3', '19-051574211-9', 'CO-TERMINUS', '9219918652', NULL, NULL, 'oscar_abinal@yahoo.com', '2005-10-28', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(122, 1871, 'pic1.png', 'JGM1871', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JEAR', 'GARFIL', 'MANEJA', 'Filipino', '1978-05-28', 'M', 'BACOLOD CITY', NULL, 'Married', NULL, 'BLOCK 4 LOT 12 GVH 2  BINAGONAN RIZAL', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-6739', '33-4711498-6', '01-051428498-4', 'CO-TERMINUS', '09214428855', NULL, NULL, 'jearmaneja@yahoo.com', '2005-12-09', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(123, 1875, 'pic2.png', 'MML1875', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MARLYN', 'MARMOL', 'LOPEZ', 'Filipino', '1958-06-12', 'F', 'DARAGA, ALBAY', NULL, 'Married', NULL, '7094 MAGSAYSAY ST., SOUTH CEMBO MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-6996', '03-5986154-7', '19-050206428-6', 'REGULAR', '0922-3911215', NULL, NULL, 'marlopez0612@yahoo.com', '2006-01-06', NULL, 75, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(124, 1881, 'pic2.png', 'LOZ1881', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'LAILA ARNIE', 'ORDOÑEZ', 'ZARAGOSA', 'Filipino', '1976-05-22', 'F', 'CAMARINES SUR', NULL, 'Married', NULL, 'BLK 196, LOT 32, TAURUS ST., PEMBO, MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0223-4990', '05-0517732-8', '19-090179071-3', 'CO-TERMINUS', '9277855988/09081879125', NULL, NULL, 'lailazaragosa@yahoo.com', '2006-01-30', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(125, 4003, 'pic1.png', 'EDS4003', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ERNESTO', 'DULATRE', 'SABADO JR.', 'FILIPINO', '1982-04-05', 'M', 'LA UNION', NULL, 'Single ', NULL, '51 EUCALYPTOS ST. WESTERN BICUTAN TAGUIG CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1211-1470-0049', '33-8816738-7', '23-002762876-7', 'CO-TERMINUS', '9186612217', NULL, NULL, NULL, '2014-01-17', NULL, 42, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(126, 1897, 'pic2.png', 'MSC1897', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MARIA VANESSA', 'SUVA', 'CID', 'Filipino', '1972-10-24', 'F', 'BAGUIO CITY', NULL, 'Single', NULL, '7213 SAN MATEO ST. OLYMPIA ', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-4431', '33-2903996-6', '01-050110499-5', 'REGULAR', '0917-8825633 / 0922-8825633', NULL, NULL, 'va_knee_too@yahoo.com', '2005-03-14', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(127, 1901, 'pic1.png', 'EJF1901', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ELVIN', 'JARLIGO', 'FUENTES', 'Filipino', '1966-04-03', 'M', 'SURIGAO CITY', NULL, 'Married', NULL, 'BLK 19 BERMAI EAST ROAD FLODWAY SAN ANDRES CAINTA RIZAL', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-7604', '03-9151542-4', '01-051421435-8', 'CO-TERMINUS', '9071568362', NULL, NULL, NULL, '2006-03-18', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(128, 1909, 'pic1.png', 'EBC1909', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ENRICO', 'BORJA', 'CRUZ', 'Filipino', '1970-02-23', 'M', 'PASIG CITY', NULL, 'Single', NULL, '94 A. BONIFACIO ST., MANDALUYONG CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-8203', '33-0787057-4', '03-025465950-5', 'CO-TERMINUS', '0915-7362188 / 094-77181617', NULL, NULL, 'cruzeric111@gmail.com', '2006-04-04', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(129, 1911, 'pic2.png', 'CPC1911', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'CAROLYN', 'PLEGARIA', 'CHICOTE', 'Filipino', '1980-10-22', 'F', 'RIZAL', NULL, 'Married', NULL, '88 MASAGANA ST.,  BUHANGIN, BINANGONAN, RIZAL', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-8194', '04-1238752-8', '01-050767637-0', 'CO-TERMINUS', '9178156032', NULL, NULL, 'carolyn_chicote@yahoo.com', '2006-04-05', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(130, 1912, 'pic1.png', 'GDT1912', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'GIL', 'DELA CRUZ', 'TRISTE', 'FILIPINO', '1970-06-20', 'M', 'AKLAN', NULL, 'Married', NULL, '#3805 GUERNICA ST.PALANAN MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-8237', '33-1114677-3', '19-025014470-2', 'CO-TERMINUS', '833-5362 / 09272701432', NULL, NULL, 'annalt2002@yahoo.com', '2006-04-10', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(131, 1916, 'pic1.png', 'AAE1916', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ABNER', 'ACILO', 'EJANDA', 'Filipino', '1967-01-07', 'M', 'ZAMBALES', NULL, 'Married', NULL, 'BLK 12 LOT 14 URBAN BLISS BARANKA MARIKINA CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-8215', '02-0848134-0', ' 19-052158090-2', 'CO-TERMINUS', NULL, NULL, NULL, NULL, '2006-04-12', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(132, 1946, 'pic2.png', 'PDG1946', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'PAMELA', 'DIZON', 'GIRON', 'Filipino', '1978-03-14', 'F', 'BULACAN', NULL, 'Single', NULL, 'Blk 199 Lot  11 Taurus St. Brgy Pembo Makati City', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-8415', '33-6957077-3', '19-089472509-9', 'CO-TERMINUS', '9175015267/09175015267', NULL, NULL, 'pamgiron14@yahoo.com', '2006-06-26', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(133, 1952, 'pic1.png', 'HFD1952', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'HONORIO, JR.', 'FLORES', 'DAVID', 'Filipino', '1981-10-03', 'M', 'BLK. 12 LOT 9, VILLA HERMANO SUBD., SANTO CRISTO, HERMANO, BULACAN', NULL, 'Married', NULL, 'BLK. 12 LOT 9, VILLA HERMANO SUBD., SANTO CRISTO, HERMANO, BULACAN', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0222-8403', '34-0133580-5', '03-050489157-3', 'CO-TERMINUS', '0925-696-1003', NULL, NULL, 'jay03david@yahoo.com', '2006-07-10', NULL, 17, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(134, 1970, 'pic1.png', 'RMY1970', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'REX', 'MALGAPO', 'YUTUC', 'Filipino', '1962-01-16', 'M', 'MANILA', NULL, 'Married', NULL, 'LOT 8 BLOCK 57, STARLIGHT RESIDENCES, STARLIGHT ST., RANCHO ESTATE 3, CONCEPCION DOS, MARIKINA CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0223-0472', '03-6447220-6', '03-050197185-1', 'REGULAR', '09989892800/09055104393/ 2801171', NULL, NULL, 'rdmyutuc@yahoo.com', '2006-09-12', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(135, 1971, 'pic1.png', 'DMU1971', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'DANILO', 'MEZA', 'UMBAO', 'FILIPINO', '1979-03-31', 'M', 'COTABATO CITY', NULL, 'Married', NULL, 'LOT 5A, OLD SUCAT ROAD, SAN DIONISIO, PARAÑAQUE CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0223-1158', '33-6182258-4', '02-050388163-3', 'CO-TERMINUS', '0920-6486439', NULL, NULL, 'daniloumbao@gmail.com', '2006-09-26', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(136, 1976, 'pic2.png', 'VDM1976', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'VENICE LAURENCE', 'DE JESUS', 'MANALUS', 'Filipino', '1980-06-07', 'F', 'MANILA', NULL, 'Married', NULL, '6 SAN MARCO STREET MOONWALK VILLAGE LAS PINAS CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0223-1125', '33-7887739-9', '01-050027385-8', 'CO-TERMINUS', '0922-8195871', NULL, NULL, 'Venicelaurence@yahoo.com', '2006-10-16', NULL, 12, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(137, 2004, 'pic1.png', 'FGA2004', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'FRANCISCO', 'GRADO', 'ARAÑEZ', 'Filipino', '1974-01-18', 'M', 'RIVERSIDE CALINAN DAVAO CITY', NULL, 'Married', NULL, '80 MT MAKILING ST., PALAR  TAGUIG CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0223-3523', '09-1911004-9', '01-050283601-9', 'CO-TERMINUS', '0929-3603053', NULL, NULL, NULL, '2007-03-07', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(138, 2011, 'pic1.png', 'MDC2011', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MICHAEL', 'DIA', 'CLAROS', 'Filipino', '1977-11-22', 'M', 'TACLOBAN CITY, LEYTE', NULL, 'Married', NULL, 'BACOOR CAVITE.', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0223-3534', '06-1860391-2', '08-050901968-5', 'REGULAR', '0932-851-1442', NULL, NULL, 'mikediaclaros@yahoo.com', '2007-03-15', NULL, 25, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(139, 2018, 'pic1.png', 'GJB2018', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'GEROLD', 'JOSE', 'BARTOLAY', 'Filipino', '1980-03-16', 'M', 'SAN JACINTO, MASBATE CITY', NULL, 'Single', NULL, '#949 STO. NIÑO VILLAMOR ST. CAMARIN CALOOCAN CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0223-4389', '33-6388138-7', '03-051282672-1', 'CO-TERMINUS', '9293511406', NULL, NULL, 'gj.bartolay@gmail.com', '2007-04-16', NULL, 48, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(140, 2035, 'pic1.png', 'MDM2035', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MARIO JR.', 'DE LEON', 'MARTIN ', 'Filipino', '1980-01-21', 'M', 'PARAÑAQUE', NULL, 'Married', NULL, '6198 SANDIVILLE ST. SUCAT PARAÑAQUE CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0223-4609', '33-5926791-5', '19-089559375-7', 'CO-TERMINUS', '9203684978', NULL, NULL, NULL, '2007-06-08', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(141, 2041, 'pic2.png', 'GPB2041', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'GINGIN ', 'PAINAGAN', 'BELANO', 'Filipino', '1979-05-10', 'F', 'SO. LEYTE ', NULL, 'Married', NULL, '534 CEBU STREET PITOGO MAKATI CITY ', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0223-4967', '08-2263980-8', '15-025140341-6 ', 'CO-TERMINUS', '0922-3535-110', NULL, NULL, 'ginbelano@gmail.com ', '2007-06-30', NULL, 9, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(142, 2042, 'pic1.png', 'CLP2042', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'CARLOS', 'LIM', 'PARKER', 'FILIPINO', '1958-09-13', 'M', 'QUEZON CITY', NULL, 'Married', NULL, 'BLK 177 LOT 10 CADENA DE AMOR ST. PEMBO MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0223-4978', '03-4740483-5', '19-090490497-3', 'REGULAR', '9175570741', NULL, NULL, 'clparker1328@gmail.com', '2007-06-20', NULL, 31, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(143, 2047, 'pic2.png', 'JBH2047', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JONNA ME', 'BURNOT', 'HERNANDEZ', 'Filipino', '1983-07-13', 'F', 'LLANERA, NUEVA ECIJA', NULL, 'Married', NULL, '290 SACREPANTE STREET, BARANGKA, MANDALUYONG CITY.', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0223-5343', '01-1639068-8', '01-052188034-7', 'CO-TERMINUS', '0915-319-5803 / 0933-085-4809', NULL, NULL, 'jonnabhernandez@gmail.com', '2007-08-06', NULL, 9, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(144, 2055, 'pic2.png', 'MBC2055', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MA. ATHENA', 'BALANE', 'CAPIRAL', 'Filipino', '1966-12-14', 'F', 'TONDO MANILA', NULL, 'Single', NULL, 'UNIT 9 #21 ASTER ST., WEST FAIRVIEW EXEC. HOMES WEST FAIRVIEW, QC', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0223-6220', '33-1421873-4', '19-089216307-7', 'REGULAR', '0918-9409967 / (02) 573-9058', NULL, NULL, 'abcaps1214@yahoo.com', '2007-08-28', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(145, 2062, 'pic1.png', 'ABD2062', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ARNEL', 'BOLIDO', 'DIZON', 'Filipino', '1977-02-02', 'M', 'TO FOLLOW', NULL, 'Single', NULL, 'TO FOLLOW', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0223-6242', '33-7198312-5', '02-050601693-3', 'CO-TERMINUS', '0921-529-7382', NULL, NULL, 'to follow', '2007-09-10', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(146, 2078, 'pic1.png', 'LSQ2078', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'LEYLORD', 'SERRA', 'QUARTO', 'Filipino', '1979-06-10', 'M', 'Manila', NULL, 'Married', NULL, '# 3 2nd Avenue Goodrich Village Concepcion Uno Marikina City', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0223-8117', '33-8976873-0', '01-050072422-1', 'CO-TERMINUS', '0947-8999204 / 0933 - 4434088', NULL, NULL, 'leylord14@yahoo.com / leylord14@gmail.com', '2007-10-27', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(147, 2080, 'pic2.png', 'JBF2080', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JOAN', 'BELANDRES', 'FERRER', 'FILIPINO', '1975-07-01', 'F', 'ILOILO CITY', NULL, 'Married', NULL, 'BLK12 L4 TERESA PARK SUBD., PILAR LAS PIÑAS CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0223-8027', '07-2034805-5', '11-200-353-750-4 ', 'CO-TERMINUS', '9175627571', NULL, NULL, 'joan_belandres@yahoo.com', '2007-10-31', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(148, 2083, 'pic1.png', 'AMC2083', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'AUGUSTO', 'MACALALAG', 'CALABIT', 'Filipino', '1965-08-18', 'M', 'Sta. Cruz Laguna', NULL, 'Married', NULL, 'Villa Palao Ballic Calamba', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0223-7975', '04-0540971-4', '08-200260741-3', 'CO-TERMINUS', '9283178180', NULL, NULL, 'augusto_calabit@yahoo.com', '2007-11-12', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(149, 2090, 'pic1.png', 'FAM2090', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'FRANCISCO III', 'AMENE', 'MACALALAG', 'Filipino', '1972-11-04', 'M', 'MANDAON, MASBATE', NULL, 'Married', NULL, '#150 UNIT 104B, 29 DE AGOSTO ST. BARANGAY SALAPAN,SAN JUAN CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0223-8062', '33-1386223-3', '02-050681075-3', 'CO-TERMINUS', '0936-9897013', NULL, NULL, 'francism888@gmail.com', '2007-12-03', NULL, 48, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(150, 2091, 'pic1.png', 'NBA2091', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'NORMAN', 'BACTAD', 'ALQUEZA', 'Filipino', '1972-05-24', 'M', 'ZAMBALES', NULL, 'Married', NULL, '# 94 AMBUKLAO ST., NAPOCOR VILLAGE TANDANG SORA QUEZON CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0223-7964', '33-7471000-7', '01-051196644-8', 'CO-TERMINUS', NULL, NULL, NULL, 'normanalqueza_24@yahoo.com', '2007-11-26', NULL, 0, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(151, 2118, 'pic1.png', 'TAS2118', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'TOLENTINO', 'ALIM', 'SANTOS', 'FILIPINO', '1965-05-29', 'M', 'MANILA', NULL, 'Married', NULL, '117 MINDANAO ST. PHASE 4 LUPANG PANGAKO PAYATAS Q.C.', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0223-8874', '03-7235135-1', ' 19-052346307-5', 'CO-TERMINUS', '0947-1769975', NULL, NULL, 'tolentinosantos65@yahoo.com', '2008-01-29', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(152, 2122, 'pic1.png', 'EEC2122', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'EPIFANIO   JR.', 'EBALE', 'CABALES', 'Filipino', '1978-04-10', 'M', 'BATO, LEYTE', NULL, 'Married', NULL, 'BLK.7, PLANTERS, CAINTA, RIZAL', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0223-8705', '33-6051369-0', '01-052118381-6', 'CO-TERMINUS', '9322248593', NULL, NULL, NULL, '2008-01-24', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(153, 2127, 'pic1.png', 'CMN2127', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'CYRUS ERIK', 'MAGAYANES', 'NAGUIT', 'FILIPINO', '1986-03-20', 'M', 'MAKATI', NULL, 'Married', NULL, '044 KALAYAAN AVE. PITOGO MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0223-8840', '34-0001586-7', '01-051620108-3', 'CO-TERMINUS', '9164237841', NULL, NULL, 'bhatunehozai@gmail.com', '2008-02-05', NULL, 17, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(154, 2135, 'pic1.png', 'HHG2135', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'HENRY', 'HERNANDEZ', 'GLOR', 'Filipino', '1974-02-08', 'M', 'MANILA', NULL, 'Married', NULL, '#12 Aberdeen St. Project 8 Quezon City', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0223-8763', '33-3174008-1', '0-1052118384-0', 'CO-TERMINUS', '9194781231', NULL, NULL, NULL, '2008-02-15', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(155, 2139, 'pic2.png', 'MRN2139', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MIRIAM', 'ROSARIO', 'NICOLAS', 'Filipino', '1984-12-18', 'F', 'PASIG', NULL, 'Married', NULL, '8275 DAPITAN ST., GUADALUPE NUEVO, MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0223-8863', '33-9391603-1', '02-050188501-1', 'CO-TERMINUS', '9195773638', NULL, NULL, 'yam.rosario@yahoo.com', '2008-02-28', NULL, 9, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(156, 2144, 'pic1.png', 'HVS2144', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'HERMOGENES JR.', 'VALDEZ', 'SACAY', 'Filipino', '1964-10-11', 'M', 'Manila', NULL, 'Married', NULL, 'B11 L9 New Mahogany Vil., Brgy. San Isidro, Cabuyao, Laguna', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0223-9473', '04-1167205-6', '01-050569209-3', 'REGULAR', '9178670013', NULL, NULL, 'rufinopacifictower@yahoo.com', '2008-04-01', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(157, 2165, 'pic1.png', 'LCB2165', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'LE-ROY', 'CASABOL', 'BILAN', 'FILIPINO', '1982-07-27', 'M', 'LAGUNA', NULL, 'Single', NULL, 'BLK 222 LOT07 SAMPAGUITA COR. MULLEN ST. PEMBO MAKATI', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0223-9950', '33-9642122-2', '01-052118380-8', 'CO-TERMINUS', '9178036798', NULL, NULL, 'leroybilan@gmail.com', '2008-05-12', NULL, 19, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(158, 2167, 'pic2.png', 'LJB2167', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'LAIZA MARIE', 'JALAC', 'BERNAL', 'Filipino', '1987-11-28', 'F', 'Boac, Marinduque', NULL, 'Single', NULL, '04E Mulawin St. Lower Bicutan, Taguig City', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0223-9984', '34-1066524-9', '01-050732607-8', 'REGULAR', '9175315873', NULL, NULL, 'jalac1128@gmail.com', '2008-05-15', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(159, 2175, 'pic1.png', 'EDN2175', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ENRICO', 'DOROPA', 'NICOLAS', 'FILIPINO', '1979-04-23', 'M', 'BULACAN', NULL, 'Married', NULL, '118 SITIO CENTRAL BUENAVISTA STA. MARIA BULACAN', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0224-1151', '33-8856822-9', '02-050194332-1', 'REGULAR', '9228904424', NULL, NULL, 'enrico_nicolas@yahoo.com', '2008-06-30', NULL, 26, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:10', '2020-08-24 02:18:10'),
(160, 2188, 'pic1.png', 'RRV2188', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ROSAURO', 'RUBIO', 'VARONA', 'Filipino', '1973-10-03', 'M', 'QUEZON CITY', NULL, 'Single', NULL, '110 KASUNDUAN ST. COMM. AVE. QC', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0224-2916', '33-1908804-0', '01-05057944-5', 'REGULAR', '0921-3694727', NULL, NULL, 'rossvarona1121@gmail.com', '2008-08-15', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(161, 2191, 'pic2.png', 'LBP2191', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'LARADEL', 'BARRENO', 'PARICO', 'Filipino', '1983-01-12', 'F', 'Pasig City', NULL, 'Married', NULL, '554 R. Vicencio St. cor. L. Gonzales St. Brgy. Hagdang Bato Libis Mandaluyong City ', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0224-2773', '33-8886343-2', '03-050197345-5', 'CO-TERMINUS', '0922-8392626', NULL, NULL, 'lara_deejay25@yahoo.com', '2008-07-25', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(162, 2192, 'pic1.png', 'GPC2192', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'GEORGE', 'PRIMAVERA', 'CAGUIOA', 'Filipino', '1979-05-08', 'M', 'CALOOCAN CITY', NULL, 'Married', NULL, '4 LIRIO EXT. ST. CAA CPD PH 1-A BF INT\'L VILL LAS PINAS CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0224-2795', '33-5829716-4', '19-089259531-7', 'CO-TERMINUS', '9179427144', NULL, NULL, 'gcaguioabhoy@gmail.com', '2008-07-25', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(163, 2200, 'pic1.png', 'JCA2200', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JOSEPH PETER', 'CAPAROS', 'ALMOGUERA', 'FILIPINO', '1978-06-20', 'M', 'MANILA', NULL, 'Married', NULL, '24C - G.B. SANTOS ST. SAN JUAN CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0224-3783', '33-4969397-1', '02-050553264-4', 'CO-TERMINUS', '9217769623', NULL, NULL, 'stroker081@yahoo.com', '2008-09-09', NULL, 17, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(164, 2201, 'pic1.png', 'RAD2201', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RENE', 'ARINGO', 'DEL  AYRE', 'FILIPINO', '1978-12-05', 'M', 'LEGASPI CITY', NULL, 'Single', NULL, 'BLK44 LOT21 PH1, SAN JOSE DEL MONTE HTS., MUZON, CSJDM, BULACAN', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0224-2804', '33-4791065-6', '01-051079885-1', 'CO-TERMINUS', '0930-6028933 / 0995-5314929', NULL, NULL, 'redyale_mst2201@yahoo.com', '2008-08-15', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(165, 2217, 'pic1.png', 'RPT2217', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RICHARD', 'PAREDES', 'TABARANGAO', 'Filipino', '1974-09-03', 'M', 'QUEZON CITY', NULL, 'Single', NULL, '9-C MAKADIOS ST. SIKATUNA VILLAGE PROJECT 2 QUEZON CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0224-3894', '03-9149227-5', '01-052188046-0', 'CO-TERMINUS', '9998301306', NULL, NULL, NULL, '2008-09-15', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(166, 2229, 'pic1.png', 'DBA2229', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'DOMINGO', 'BERESO', 'ALBERTO', 'Filipino', '1972-12-01', 'M', 'Ocampo cam. Sur.', NULL, 'Married', NULL, 'Lot 30/32 Daang kalabaw St. Napindan taguig city.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '33-2028712-8', '01-052118379-4', 'CO-TERMINUS', '9283219448', NULL, NULL, 'sandyalberto50@yahoo.com', '2008-10-01', NULL, 48, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(167, 2283, 'pic2.png', 'MSS2283', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MELINDA', 'SALONGA', 'SUBRADO', 'Filipino', '1977-12-28', 'F', 'CARDONA, RIZAL', NULL, 'Married', NULL, 'BLK 21 LOT 12-A EASTWOOD RESIDENCES PHASE 6, SAN ISIDRO MONTALBAN RIZAL', NULL, NULL, NULL, NULL, NULL, NULL, '1020-0302-2698', '33-5196105-7', '01-050473779-4', 'CO-TERMINUS', '09175315844 / (02) 423-1952', NULL, NULL, 'mhel_fil@yahoo.com.ph', '2009-01-10', NULL, 9, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(168, 2330, 'pic1.png', 'BCF2330', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'BERNARDO', 'CUARTEROS', 'FACURI', 'FILIPINO', '1982-12-06', 'M', 'PASAY CITY', NULL, 'Married', NULL, '# 12 PALICO 1, IMUS CAVITE', NULL, NULL, NULL, NULL, NULL, NULL, '1090-0262-3425', '33-8606053-8', '02-050417448-5', 'CO-TERMINUS', '09303520027/09273366457', NULL, NULL, 'Bfacuri@yahoo.com', '2009-03-09', NULL, 17, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(169, 2331, 'pic1.png', 'JDM2331', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JOSEPH', 'DIZON', 'MURAO', 'Filipino', '1977-05-26', 'M', 'MANILA', NULL, 'Married', NULL, '2437 CHROMIUM STREET, SAN ANDRES, BUKID, MANILA', NULL, NULL, NULL, NULL, NULL, NULL, '1211-7441-0443', '33-2930959-9', '19-200576961-9    ', 'CO-TERMINUS', '9065043551', NULL, NULL, 'muraoadrian@gmail.com', '2009-03-18', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(170, 2333, 'pic1.png', 'EAG2333', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'EDMOND', 'ALBESA', 'GANZORE', 'FILIPINO', '1977-12-20', 'M', 'SANJUAN', NULL, 'Single', NULL, 'UNIT 309 BSMRC P. MARTINEZ ST. MANDALUYONG CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1090-01396-292', '33-4960512-1', '19-051274701-2', 'CO-TERMINUS', '9077709927', NULL, NULL, 'markedmond20@yahoo.com.ph', '2009-03-24', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(171, 2345, 'pic1.png', 'RCG2345', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'REYNALDO', 'CASTILLO', 'GERONA', 'FILIPINO', '1960-05-09', 'M', 'TIBIAO, ANTIQUE', NULL, 'Married', NULL, '95 ADELFA ST. VISAYAS AVE. CULIAT, QUEZON CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1210-2021-0176', '34-759200-6', '01-052118383-2', 'CO-TERMINUS', '0929-668-8179', NULL, NULL, 'reyegerona@yahoo.com', '2009-04-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(172, 2346, 'pic1.png', 'RAR2346', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ROLANDO', 'ANOG', 'RODRIGUEZ', 'Filipino', '1976-12-16', 'M', 'RIZAL', NULL, 'Married', NULL, '736 KASINAY ST. DARANGAN, BINANGONAN, RIZAL', NULL, NULL, NULL, NULL, NULL, NULL, '1210-6612-9564', '33-5165220-1', '01-050703714-9', 'CO-TERMINUS', '9463430307', NULL, NULL, NULL, '2009-04-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(173, 2347, 'pic1.png', ' AM2347', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', ' ARNOLD', 'ALCANTARA', 'MARTINEZ', 'Filipino', '1978-03-26', 'M', 'Manila', NULL, 'Married', NULL, ' 8093 Progreso St. Guadalupe Viejo Makati City', NULL, NULL, NULL, NULL, NULL, NULL, '1211-7366-4007', '33-4589296-7', '19-200860628-1', 'CO-TERMINUS', NULL, NULL, NULL, ' arnoldmartinez425@yahoo.com', '2009-04-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(174, 2354, 'pic1.png', 'CMR2354', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'CONSTANCIO', 'MARTINEZ', 'RABACAL', 'FILIPINO', '1964-01-28', 'M', 'NEGROS ', NULL, 'Married', NULL, 'COLOOCAN CITY', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '33-0334326-7', '01-051247239-2', 'CO-TERMINUS', '09662158994', NULL, NULL, NULL, '2009-04-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(175, 2365, 'pic1.png', 'ADS2365', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ADRIAN', 'DILAG', 'SANTOS', 'Filipino', '1981-10-19', 'M', 'TAGUIG', NULL, 'Single', NULL, '#11 CADEÑA DE AMOR EXT. WAWA TAGUIG CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1090-0152-4590', '33-7037304-0', '01-051179526-0', 'CO-TERMINUS', '9397773001', NULL, NULL, 'santosian19.sa@gmail.com', '2009-04-27', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(176, 2370, 'pic1.png', 'JAI2370', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JORGE', 'AVEN', 'IBALIO', 'Filipino', '1968-02-20', 'M', 'Fort Bonifacio', NULL, 'Married', NULL, '7092 Gen. Ricarte St. South Cembo Makati City', NULL, NULL, NULL, NULL, NULL, NULL, '121178726621', '33-0312479-0', '01-051033517-7', 'REGULAR', '09171598934', NULL, NULL, 'dyordz_10@yahoo.com', '2009-05-01', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(177, 2372, 'pic1.png', 'EMS2372', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'EDWIN', 'MEJIA', 'SAMSON', 'Filipino', '1971-05-27', 'M', 'MAKATI CITY', NULL, 'Married', NULL, '3490 MOLA STREET,LAPAZ, MAKATI CITY.', NULL, NULL, NULL, NULL, NULL, NULL, '1210-6937-6025', '33-0188211-5', '01-051033516-9', 'CO-TERMINUS', '0939-323-7956', NULL, NULL, 'edwin2345@gmail.com', '2009-05-15', NULL, 17, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(178, 2395, 'pic1.png', 'EMM2395', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ELMER', 'MAYUYU', 'MICLAT', 'FILIPINO', '1978-06-06', 'M', 'CAPAS, TARLAC', NULL, 'Married', NULL, '0164 LIGTASAN ST. CUTCUT-II CAPAS TARLAC', NULL, NULL, NULL, NULL, NULL, NULL, ' 1210-5840-5255', '02-1413028-7', '23-004614846-6', 'CO-TERMINUS', '9272117213', NULL, NULL, 'columbusparreno@yahoo.com', '2009-05-25', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(179, 2402, 'pic1.png', 'CAP2402', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'COLUMBUS', 'ALVARADO', 'PARREÑO', 'FILIPINO', '1972-11-26', 'M', 'BACOLOD CITY', NULL, 'Married', NULL, 'BLOCK 10 LOT 28 SUMMERFIELD SUBD. BRGY. OSORIO,TRECE MARTIRES CITY , CAVITE', NULL, NULL, NULL, NULL, NULL, NULL, '9123-2703-5616', '07-1693232-3', '19-090217855-8', 'CO-TERMINUS', '0927-2117-213', NULL, NULL, 'N/A', '2009-05-29', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(180, 2409, 'pic1.png', 'APF2409', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ARISTOTLE', 'PARRA', 'FLORIDO', 'Filipino', '1982-10-29', 'M', 'QUEZON CITY', NULL, 'Married', NULL, '#53 SAINT FRANCIS ST. PUROK 14 SIGNAL VILLAGE TAGUIG CITY', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '34-1253639-2', '12-050763212-8', 'CO-TERMINUS', '0926-7546450', NULL, NULL, 'selujahkondz@yahoo.com', '2009-06-01', NULL, 17, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(181, 2431, 'pic1.png', 'PVP2431', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'PAULO', 'VEGALLERA', 'PERACULLO', 'Filipino', '1973-08-04', 'M', 'BACOLOD CITY', NULL, 'Married', NULL, 'WAWA TAGUIG CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0031-4805', '33-2670558-1', '19-090518184-3', 'CO-TERMINUS', '0926-8963080', NULL, NULL, NULL, '2009-06-25', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(182, 2486, 'pic1.png', 'RBC2486', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RONELYN', 'BILLONES', 'COROZ', 'Filipino', '1972-06-01', 'M', 'PARAÑAQUE', NULL, 'Married', NULL, 'PUROK CAMACHILLE SUN VALLEY PARAÑAQUE CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1211-3130-2330', '33-3874667-7', '03-050472922-9', 'CO-TERMINUS', NULL, NULL, NULL, NULL, '2009-11-06', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(183, 2500, 'pic1.png', 'JVA2500', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JAN RIO', 'VITOR', 'AMPO', 'Filipino', '1984-01-18', 'M', 'POBLACIO, SAGBAYAN, BOHOL', NULL, 'Single', NULL, '353 WEST REMBO, SITIO 8 BLK 8, MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1211-1570-5500', '33-7714249-4', '02-050602447-2', 'CO-TERMINUS', '0977-169-6592', NULL, NULL, 'Jan_Ampo@yahoo.com', '2010-01-11', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(184, 2523, 'pic1.png', 'LAP2523', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'LEONARD', 'ACULLADOR', 'PEDROSO', 'Filipino', '1982-02-17', 'M', 'Duenas Iloilo', NULL, 'Single', NULL, 'Blk. 58 Brgy. Sta. Maria Dasmarinas Cavite', NULL, NULL, NULL, NULL, NULL, NULL, '1211-7292-5224', '04-1900990-6', '08-025444854-4', 'CO-TERMINUS', '9228225804', NULL, NULL, 'pedroso_fpdasia@yahoo.com', '2010-03-02', NULL, 37, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(185, 2526, 'pic1.png', 'JMM2526', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JONIERY', 'MARCO', 'MORADILLO', '      FILIPINO', '1989-05-26', 'M', 'CAMALIG ALBAY', NULL, 'Single', NULL, 'BLK 59 UNIT1 GK ROTARY VILLAGE PH2 PINAGSAMA TAGUIG CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1210-8917-6633', '34-1415191-1', '01-052118388-3', 'CO-TERMINUS', '9159011546', NULL, NULL, 'joniery_23@yahoo.com', '2010-03-05', NULL, 17, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(186, 2543, 'pic1.png', 'RED2543', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RON', 'ESTAVILLO', 'DAGDAYAN', 'Filipino', '1985-01-05', 'M', 'QUEZON CITY', NULL, 'Single', NULL, 'L47 B2 P4 GSIS AVE.COGEO VILL. ANTIPOLO CITY', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '34-0907447-2', '01-050650380-4', 'CO-TERMINUS', '9399356065', NULL, NULL, 'rondagdayan@gmail.com', '2010-05-06', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(187, 2548, 'pic2.png', 'MAP2548', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MELANIE', 'AGOBA', 'PEREZ', 'FILIPINO', '1976-04-03', 'F', 'MANDALUYONG CITY', NULL, 'Single', NULL, '174 M. AQUINO ST. PAG-ASA AREA D. CAMARIN CALOOCAN CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1210-1336-3310', '33-4931693-1', '03-050392184-3', 'REGULAR', '0949-9904642', NULL, NULL, 'maijhed@yahoo.com', '2010-05-13', NULL, 8, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(188, 2552, 'pic2.png', 'EER2552', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'EVELYN', 'ESCALONA', 'RAMIL', 'Filipino', '1969-05-15', 'F', 'SANTIAGO, ILOCOS SUR', NULL, 'Married', NULL, 'LOT1 BLOCK3, BEACON PLACE, NAGA RD. PULANGLUPA DOS, LAS PINAS CITY, M.M.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '33-6359505-5', '01-050730882-7', 'REGULAR', '9269901474', NULL, NULL, 'eve_ramil15@yahoo.com', '2010-06-11', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(189, 2630, 'pic1.png', 'MBD2630', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MICHAEL', 'BAYLIN', 'DOBLADA', 'Filipino', '1976-10-02', 'M', 'MANDALUYONG CITY', NULL, 'Married', NULL, '#16 MARIVELES ST., HI-WAY HILLS, MANDALUYONG CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1211-5257-5745', '33-2742124-6', '19-200603626-7', 'CO-TERMINUS', '9262298641', NULL, NULL, 'tatlong3bugoy@gmail.com', '2011-02-01', NULL, 42, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(190, 2631, 'pic1.png', 'NVD2631', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'NICOLAS JR.', 'VITOR', 'DECLARO', 'Filipino', '1977-12-21', 'M', 'BOHOL', NULL, 'Married', NULL, '171 CINTRO SITIO MARILOG CULIAO QC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '33-4702849-6', '01-051981819-7', 'CO-TERMINUS', '0927-5169364', NULL, NULL, 'nicolas77declaro@gmail.com', '2011-02-01', NULL, 42, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(191, 2641, 'pic1.png', 'RCV2641', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RICHARD', 'CANCERAN', 'VALLESFIN', 'Filipino', '1984-04-18', 'M', 'CABUYAO, LAGUNA', NULL, 'Single', NULL, 'PUROK 30, ZONE 5 MANSANAS ST., VILLA GUIDO, MAHABANG PARANG, ANGONO, RIZAL  ', NULL, NULL, NULL, NULL, NULL, NULL, '1210-6022-3760', '33-8885395-0', '01-051541207-2', 'REGULAR', '0918-698-1103, 0923-745-8374', NULL, NULL, 'vallesfinrichard@yahoo.com', '2011-03-11', NULL, 37, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(192, 2671, 'pic1.png', 'DML2671', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'DENNIS', 'MALABUNGA', 'LALIS', 'Filipino', '1980-11-16', 'M', 'MANILA', NULL, 'Married', NULL, '709 BAGUMBAYAN STREET, BACOOD, STA MESA, MANILA', NULL, NULL, NULL, NULL, NULL, NULL, '1080-0118-7839', '33-7837058-2', '03-050377829-3', 'CO-TERMINUS', '9064612359', NULL, NULL, 'engr.tpcc@gmail.com', '2011-07-20', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(193, 2674, 'pic1.png', 'AEG2674', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ALDEN', 'ESCUSA', 'GANADEN', 'Filipino', '1987-02-04', 'M', 'IBA, ZAMBALES', NULL, 'Single', NULL, '3910A MACABULOS ST. BANGKAL, MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '34-2305587-5', '01-025298088-7', 'CO-TERMINUS', '9478714454', NULL, NULL, 'britzibhampton@yahoo.com', '2011-06-25', NULL, 5, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(194, 2677, 'pic2.png', 'MBF2677', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MIRLA', 'BAYOMBON', 'FAJARDO', 'Filipino', '1975-05-29', 'F', 'MALABON', NULL, 'Married', NULL, '796 TRAMO ST. MANUYO LAS PIÑAS CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1060-0107-4982 ', '33-5531399-9', '19-0505066104-0  ', 'CO-TERMINUS', '09496925502', NULL, NULL, 'mirlafajardo@yahoo.com', '2011-08-02', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(195, 2681, 'pic1.png', 'JDB2681', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JACJY', 'DURAN', 'BARGADO', 'FILIPINO', '1984-06-14', 'M', 'CAGAYAN, VALLEY', NULL, 'Single', NULL, '633B SANCHO PANZA SAMPALOC MANILA', NULL, NULL, NULL, NULL, NULL, NULL, '1211-0269-1405', '01-1930430-9', '01-025285212-9', 'CO-TERMINUS', '9163551429', NULL, NULL, 'jdbargado@ymail.com', '2011-07-01', NULL, 48, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(196, 2684, 'pic2.png', 'MGG2684', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MARJORIE', 'GREGORIO', 'GARFIN', 'Filipino', '1991-03-03', 'F', 'TAGUIG CITY', NULL, 'Single', NULL, '#7 MEDEL STREET, ZONE 3,SIGNAL VILLAGE, TAGUIG CITY.', NULL, NULL, NULL, NULL, NULL, NULL, '1210-9939-9992', '34-1826328-7', '01-051196617-0', 'CO-TERMINUS', '0915-765-0423', NULL, NULL, 'marjoriegarfin03@gmail.com', '2011-07-29', NULL, 65, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(197, 2685, 'pic2.png', 'JCC2685', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JESSICA', 'CHING', 'CASTRO', 'FILIPINO', '1983-10-17', 'F', 'MAKATI', NULL, 'Single', NULL, 'PRINCESS BLDG ROOM 801 8314 SGT FABIAN YABUT COR MANGGAHAN GUADALUPE NUEVO MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1090-0217-300', '33-8035155-7', '03-050043165-9', 'CO-TERMINUS', '9173183191', NULL, NULL, 'cjesica06@yahoo.com', '2011-08-05', NULL, 9, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(198, 2688, 'pic1.png', 'JHS2688', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JORGE', 'HIMONGALA', 'SATINITIGAN', 'Filipino', '1976-01-15', 'M', 'TAGUIG CITY', NULL, 'Single', NULL, '#18 AGUINALDO ST ZONE 6 TAGUIG CITY MM POROK 18', NULL, NULL, NULL, NULL, NULL, NULL, '1211-1035-8303', '33-6295864-8', '19-051284054-3', 'CO-TERMINUS', '9063464971', NULL, NULL, 'jorgesatinitigan@yahoo.com', '2011-08-16', NULL, 42, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(199, 2689, 'pic1.png', 'JMC2689', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JUN', 'MANUEL', 'CABURAL', 'Filipino', '1983-07-07', 'M', 'PANGASINAN', NULL, 'Single', NULL, '4382 BUENSOCISO ST. DON GALO PARAÑAQUE CITY', NULL, NULL, NULL, NULL, NULL, NULL, '121152541865', '33-873997-9', '23-002739348-4', 'CO-TERMINUS', '09164764971', NULL, NULL, 'juncabural07@yahoo.com', '2011-08-16', NULL, 42, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(200, 2703, 'pic1.png', 'KEM2703', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'KARL ANGEL', 'ESTEBAN', 'MONTEMAYOR', 'Filipino', '1986-07-23', 'M', 'MANILA', NULL, 'Single', NULL, '191-S 28TH AVE., EAST REMBO, MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1210-5899-2967', '34-0711442-8', ' 03-050392374-9', 'REGULAR', '9065420284', NULL, NULL, 'chock_08@yahoo.com', '2011-09-30', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(201, 2716, 'pic2.png', 'LPT2716', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'LILIA MARITES', 'PASTOR', 'TORRES', 'Filipino', '1969-02-11', 'F', 'ILOCOS SUR', NULL, 'Single', NULL, '20 MILAGROSA STREET, VILLA SABINA SUBDIVISION, NOVALICHES, QUEZON CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1020-02753225', '33-3443198-6', '19-051708395-3', 'CO-TERMINUS', '9179560811', NULL, NULL, 'liatorres11@yahoo.com', '2011-10-12', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11');
INSERT INTO `hris_employees` (`id`, `employee_number`, `employee_photo`, `username`, `password`, `firstname`, `middlename`, `lastname`, `nationality`, `birthday`, `gender`, `place_birth`, `dependant`, `marital_status`, `work_address`, `home_address`, `home_distance`, `emergency_contact`, `emergency_no`, `cert_level`, `field_study`, `school`, `pagibig`, `sss`, `phic`, `employment_status`, `work_no`, `work_phone`, `work_email`, `private_email`, `joined_date`, `termination_date`, `job_title_id`, `department_id`, `supervisor`, `pay_grade`, `role_id`, `last_login`, `status`, `created_at`, `updated_at`) VALUES
(202, 2717, 'pic2.png', 'RDC2717', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ROWENA', 'DE JESUS', 'CAPELLAN', 'FILIPINO', '1973-10-28', 'F', 'SAN MIGUEL , BUL.', NULL, 'Married', NULL, '3637 A DAVILA STREET, BRGY LA PAZ, PASONG TAMO MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0050-2386', '33-2638773-4', '19-088836869-1', 'REGULAR', '9254700257', NULL, NULL, 'ena_1028@yahoo.com', '2011-10-17', NULL, 7, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(203, 2724, 'pic1.png', 'CRC2724', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'CHRISTOPHER', 'RIVERA', 'CRUZADO', 'Filipino', '1978-05-17', 'M', 'Manila', NULL, 'Married', NULL, '1038 A. Dela Cruz St. Hermosa Tondo manila', NULL, NULL, NULL, NULL, NULL, NULL, '1020-0087-9935', '33-7170818-0', '08-050476729-2', 'CO-TERMINUS', '0998-8581938', NULL, NULL, 'cruzado_christopher@yahoo.com.ph', '2011-10-19', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(204, 2761, 'pic1.png', 'CGM2761', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'CARLO ANGELO', 'GUCE', 'MAGPANTAY', 'Filipino', '1985-07-31', 'M', 'MANILA', NULL, 'Married', NULL, 'BO. UNITED NATION BETTERLIVING SUBD. PARAÑAQUE', NULL, NULL, NULL, NULL, NULL, NULL, '1210-2277-0810', '34-0333883-9', '00-412362960-1', 'CO-TERMINUS', '0998-9719658', NULL, NULL, 'magpantaycarloangelo@yahoo.com.ph', '2012-02-28', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(205, 2772, 'pic1.png', 'BMM2772', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'BENEDICT', 'MALABANA', 'MAAC', 'Filipino', '1978-05-05', 'M', 'MARINDUQUE', NULL, 'Married', NULL, 'BLK 14 LOT 61 ISTANA SUBD, TANZA, CAVITE', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0257-8854', '33-5652964-3', '19-051106280-6', 'CO-TERMINUS', '09158949244', NULL, NULL, 'benz_maac@yahoo.com', '2012-03-16', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(206, 2777, 'pic1.png', 'VOR2777', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'VIRGILIO', 'ORDOÑA', 'ROSQUETA', 'FILIPINO', '1979-01-19', 'M', 'LA UNION', NULL, 'Married', NULL, 'BLK 17 LOT 7 EP VILL PH2 BRGY PINAGSAMA TAGUIG CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1210-0709-9186', '33-2597655-7', '19-089564413-0', 'CO-TERMINUS', '9982347127', NULL, NULL, 'vherosq_2650@yahoo.com', '2012-03-19', NULL, 22, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(207, 2804, 'pic1.png', 'HHB2804', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'HERNAN', 'HUSGAPA', 'BENSURTO', 'Filipino', '1987-08-12', 'M', 'MASBATE', NULL, 'Single', NULL, 'SARASA COMPOUND F. CRUZ, MALIBAY, PASAY CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1210-2843-2914', '34-1416555-4', '02-025733558-6', 'CO-TERMINUS', '9073132816', NULL, NULL, 'herobensurto_87@yahoo.com', '2012-04-27', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(208, 2813, 'pic1.png', 'LGP2813', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'LERENCIO', 'GARGOLES', 'PARAMI', 'Filipino', '1988-08-10', 'M', 'POBLACION TAPAZ, CAPIZ', NULL, 'Single', NULL, '232 DR.SIXTO ANTONIO AVE. CANIOGAN', NULL, NULL, NULL, NULL, NULL, NULL, '1210-4009-6150', '34-0951229-3', '02-050409409-0', 'CO-TERMINUS', '9295209002', NULL, NULL, 'mackyparami@yahoo.com', '2012-05-10', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(209, 2818, 'pic1.png', 'NCS2818', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'NOEL', 'CASTILLO', 'SAGDULLAS', 'FILIPINO', '1969-10-02', 'M', 'WESTERN SAMAR', NULL, 'Married', NULL, 'B14 L1 SEC 30 P3 KATUPARAN VILLAGE, BAGTAS TANZA CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1210-4619-9816', '03-9955075-3', '19-052238966-1', 'CO-TERMINUS', '0923-5972716', NULL, NULL, 'noe_inc99@yahoo.com', '2012-05-18', NULL, 0, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(210, 2831, 'pic1.png', 'RYT2831', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RODIE MARTE', 'YABUT', 'TIAMZON', 'Filipino', '1982-04-24', 'M', 'SAN FERNANDO PAMPANGA', NULL, 'Married', NULL, '404 GANGES BLDG. RIVERFRONT RESIDENCES DR. SIXTO AVENUE BRGY. CANIOGAN PASIG CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1020-0006-3795', '33-9962925-4', '07-025295763-2', 'REGULAR', '09228046189', NULL, NULL, 'rmyt_rme@yahoo.com', '2012-06-11', NULL, 61, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(211, 2835, 'pic2.png', 'SBN2835', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'SARAH JANE', 'BATALLA', 'NAVAROSSA', 'FILIPINO', '1986-08-23', 'F', 'PANSOL CALAMBA CITY LAGUNA', NULL, 'Married', NULL, '4TH FLR. BLK 225 LOT 04 AZALEA ST. PEMBO MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1090-0232-4731', '04-1983507-3', '01-050818258-4', 'REGULAR', '9257083086', NULL, NULL, 'jane_rizanne08@yahoo.com', '2012-07-09', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(212, 2841, 'pic2.png', 'PPT2841', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'PERSEVERANDA', 'PACHECO', 'TRINIDAD', 'FILIPINO', '1972-06-12', 'F', 'MANILA', NULL, 'Married', NULL, '186 ARNAIZ AVE PASAY CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0020-5191', '33-1886924-4', '19-08866187-9', 'REGULAR', '0942-4611690', NULL, NULL, 'percy_916@yahoo.com.ph', '2012-07-19', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(213, 2849, 'pic1.png', 'JLR2849', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JOHNREY', 'LAMPARAS', 'ROSALES', 'FILIPINO', '1984-08-30', 'M', 'OROQUIETA CITY', NULL, 'Single', NULL, '172 AREA 6-B GAULI ST. BRGY. HOLY SPIRIT, QUEZON CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1210-7398-4294', '33-7878673-6', ' 03-050034002-5', 'CO-TERMINUS', '0919-980-4451', NULL, NULL, 'r.johnrey66@ymail.com', '2012-08-02', NULL, 55, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(214, 2859, 'pic1.png', 'EGD2859', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ELMER', 'GALOPE', 'DULUTAN', 'Filipino', '1970-11-07', 'M', 'NASUGBU, BATANGAS', NULL, 'Married', NULL, 'ACMPH.7 B 6 L1 ALAPAN 1-A IMUS CAVITE', NULL, NULL, NULL, NULL, NULL, NULL, '1210-2374-4131', '03-8992583-5', '19-052179396-5', 'CO-TERMINUS', '0927-4953245', NULL, NULL, 'egdulutan46@gmail.com', '2012-08-28', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(215, 2881, 'pic1.png', 'IBS2881', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'IAN', 'BAYRON', 'SEBASTIAN', 'FILIPINO', '1974-09-07', 'M', 'BUKID CALUMPIT, BULACAN', NULL, 'Widower', NULL, 'BUKID CALUMPIT, BULACAN', NULL, NULL, NULL, NULL, NULL, NULL, '1210-6546-1106', '33-3397252-7', '02-051009046-3', 'CO-TERMINUS', '(0910) 1442505', NULL, NULL, NULL, '2012-10-15', NULL, 0, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(216, 2888, 'pic1.png', 'ERM2888', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'EUGENE', 'RUPANAN', 'MERCADO', 'FILIPINO', '1982-11-15', 'M', 'BATANGAS', NULL, 'Single', NULL, '428 ACACIA ST. DAGATAN, LIPA CITY, BATANGAS ', NULL, NULL, NULL, NULL, NULL, NULL, '1210-6637-5438', '04-1873589-9', '09-025020196-5', 'CO-TERMINUS', '0906-571-2163 / 0912-646-1188', NULL, NULL, 'eugenemercado143@gmail.com', '2012-10-25', NULL, 17, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(217, 2890, 'pic1.png', 'JDL2890', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JAPETH', 'DUNGOG', 'LOPEZ', 'Filipino', '1978-10-06', 'M', 'MANILA', NULL, 'Married', NULL, 'BLk 9 Lot 1 Dreamland Subdivision, Taguig City', NULL, NULL, NULL, NULL, NULL, NULL, '109-00337-8128', '33-4520853-5', '1090-0337-8128', 'CO-TERMINUS', '9771760047', NULL, NULL, 'lopezjapeth@yahoo.com', '2012-10-29', NULL, 69, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(218, 2902, 'pic1.png', 'RMO2902', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RANDYSON', 'MOCORO', 'ORTIZ', 'Filipino', '1970-03-05', 'M', 'QUEZON CITY', NULL, 'Married', NULL, '#38 KAPILIGAN ST. ARANETA AVE. QUEZON CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1040-0328-4238', '33-0218211-5', '01-050007115-5', 'CO-TERMINUS', '9206792246', NULL, NULL, 'ortizrandyson@yahoo.com', '2012-12-04', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(219, 2918, 'pic2.png', 'BVR2918', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'BERNADETTE', 'VALLESTERO', 'RAMOS', 'Filipino', '1988-09-25', 'F', 'Baras, Rizal', NULL, 'Single', NULL, '97-C Trabajo St. Brgy San Salvador Baras, Rizal', NULL, NULL, NULL, NULL, NULL, NULL, '1210-3190-6841', '34-2158820-5', '03-050715577-0', 'CO-TERMINUS', '9056711245', NULL, NULL, 'dhette_21@yahoo.com', '2013-01-21', NULL, 9, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(220, 2921, 'pic2.png', 'JNS2921', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JANET', 'NATAVIO', 'SAFRANCA', 'Filipino', '1963-07-08', 'F', 'QUEZON CITY', NULL, 'Single', NULL, '2245 - A Molave St. Tondo, Manila 1012', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0017-2989', '34-3623378-1', '03-000212258-4', 'REGULAR', '9228201551', NULL, NULL, 'janetnsafranca@gmail.com', '2013-01-28', NULL, 64, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(221, 2925, 'pic1.png', 'NCM2925', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'NOLY', 'CANDELASA', 'MALATE', 'Filipino', '1976-11-13', 'M', 'STO. TOMAS DAVAO DEL NORTE', NULL, 'Married', NULL, 'BUKID SITE FURTUNATA VILLAGE BRGY, SAN ISIDRO PARAÑAQUE CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1210-8049-2811', '34-1660328-9', '08-050883889-5', 'CO-TERMINUS', '9289693712', NULL, NULL, 'ups_nols76@yahoo.com', '2013-02-04', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(222, 2939, 'pic2.png', 'MAC2939', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MARY GRACE', 'AGUILAR', 'CAUMAN', 'FILIPINO', '1979-04-14', 'F', 'MANILA', NULL, 'Single', NULL, '9 SAN MIGUEL VILLAGE LIAS MARILAO BULACAN', NULL, NULL, NULL, NULL, NULL, NULL, '1090-0205-1867', '33-6261842-5', '19-090224493-3', 'CO-TERMINUS', '0906-2368290', NULL, NULL, 'marygracecauman@yahoo.com', '2013-03-13', NULL, 9, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(223, 2972, 'pic2.png', 'RPJ2972', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ROCHELLE', 'PEREZ', 'JINGCO', 'Filipino', '1984-12-05', 'F', 'PASIG CITY', NULL, 'Single ', NULL, 'BLK 201 LOT 19 UPPER AZUCENA ST., PEMBO, MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1020-0197-7451', '33-8525995-5', '19-089888037-4', 'CO-TERMINUS', NULL, NULL, NULL, 'chel.jingco@yahoo.com', '2013-04-03', NULL, 9, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(224, 2996, 'pic1.png', 'WBP2996', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'WILFREDO', 'BILLONES', 'PEREZ', 'FILIPINO', '1969-07-17', 'M', 'MASANTOL PAMPANGA', NULL, 'Married', NULL, 'Blk 2 Lot 10 Cocohills Bagumbayan, Taguig Cityq', NULL, NULL, NULL, NULL, NULL, NULL, '1210-1390-9674', '02-0836345-5', '02-025193263-9', 'CO-TERMINUS', '9238179960', NULL, NULL, 'whillieperez@yahoo.com', '2013-05-17', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(225, 3004, 'pic1.png', 'INR3004', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ISRAEL', 'NEPOMUCENO', 'RAMIREZ', 'Filipino', '1982-01-02', 'M', 'MANILA', NULL, 'Single', NULL, '50 MULAWIN ST. MARICABAN, PASAY CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1210-8252-0753', '33-9579392-2', '01-050961235-3', 'CO-TERMINUS', '9322485241', NULL, NULL, 'john.bravo73@yahoo.com', '2013-06-03', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(226, 3010, 'pic1.png', 'FLV3010', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'FELIX', 'LIPATA', 'VERANO', 'FILIPINO', '1974-01-02', 'M', 'SAMAR', NULL, 'Married', NULL, '3010 NIÑADA ST. BGY. COMMONWEALTH Q.C.', NULL, NULL, NULL, NULL, NULL, NULL, '0009-2381-4604', '33-3031442-1', '19-051662616-3', 'CO-TERMINUS', '0939-5045611', NULL, NULL, 'fverano08@gmail.com', '2013-06-17', NULL, 48, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(227, 3020, 'pic2.png', 'JAI3020', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JIZZA', 'ASIS', 'IPULAN', 'FILIPINO', '1977-05-26', 'F', 'JASAAN MISAMIS ORIENTAL', NULL, 'Single', NULL, '485 MAGANDA ST. STA MESA MANIL', NULL, NULL, NULL, NULL, NULL, NULL, '1050-0035-9694', '08-1230041-9', '19-089958856-1', 'CO-TERMINUS', '9272795106', NULL, NULL, 'jai_pdcai2014@yahoo.com.ph', '2013-06-24', NULL, 9, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(228, 3025, 'pic2.png', 'MSM3025', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MARIA LUISA', 'SORIANO', 'MAMBA', 'FILIPINO', '1982-10-09', 'F', 'STA. CRUZ MANILA', NULL, 'Single', NULL, '129 ISAROG STREET LALOMA, QUEZON CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1020-0354-8825', '33-9402385-5', '19-200677466-7', 'CO-TERMINUS', '0917-8156692', NULL, NULL, 'louie_soriano_09@yahoo.com', '2013-07-08', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(229, 3026, 'pic2.png', 'MAS3026', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MARIA ROSITA', 'AMOLADOR', 'SANTOS', 'FILIPINO', '1979-09-23', 'F', 'PASAY CITY', NULL, 'Married', NULL, '17TH 2ND ST. VILLAMOR AIR BASE, PASAY CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1020-0287-6305', '33-7261874-5', '19-090079289-5', 'CO-TERMINUS', '0932-8520775', NULL, NULL, 'nhengamolador@yahoo.com', '2013-07-08', NULL, 9, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(230, 3029, 'pic2.png', 'CQM3029', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'CARLA CAMILLE', 'QUINIO', 'MIGUEL', 'Filipino', '1992-12-23', 'F', 'BATAAN', NULL, 'Single', NULL, ' 1973 MAHOGANY ST. GOMEZ VILLE, ROSARIO PASIG CITY', NULL, NULL, NULL, NULL, NULL, NULL, '9132-0412-9501', '02-3466965-7', '03-051088710-3', 'CO-TERMINUS', '09985752674', NULL, NULL, 'miguelcarlac2013@gmail.com', '2013-07-08', NULL, 9, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(231, 3048, 'pic1.png', 'AAD3048', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'AQUINO, JR.', 'ALTURA', 'DIONISIO', 'FILIPINO', '1983-09-11', 'M', 'TAGUIG', NULL, 'Married', NULL, '67 GUERRERO ST. WAWA, TAGUIG CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1210-1879-8739', '04-1623015-0', '01-050447157-3', 'CO-TERMINUS', '9258050914', NULL, NULL, 'adionisio_11@yahoo.com', '2013-09-09', NULL, 69, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(232, 3058, 'pic2.png', 'SDV3058', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'SARAH KATREEN', 'DABU', 'VERGARA', 'FILIPINO', '1993-02-12', 'F', 'BATAAN', NULL, 'Single', NULL, 'PRINCESS BLDG ROOM 401 8314 SGT FABIAN YABUT COR MANGGAHAN GUADALUPE NUEVO MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1211-0009-9377', '02-3526200-8', '01-025520866-2', 'CO-TERMINUS', '9165527284', NULL, NULL, 'xaichi_012@yahoo.com', '2013-09-24', NULL, 65, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(233, 3080, 'pic2.png', 'HBF3080', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'HAYDEE', 'BARBON', 'FERRER', 'FILIPINO', '1993-12-14', 'F', 'BANGUED, ABRA', NULL, 'Single', NULL, '12 D, KATIPUNAN AVE., KINGSPOINT SUBD., NOVALICHES, QUEZON CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1211-0442-8244', '34-4196401-6', '01-025810050-1', 'CO-TERMINUS', '9272740725', NULL, NULL, 'ferrerhaydee@icloud.com', '2013-11-15', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(234, 3084, 'pic1.png', 'EAA3084', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'EMELITO', 'ABANTO', 'ADIA', 'Filipino', '1961-01-10', 'M', 'BAUAN BATANGAS', NULL, 'Married', NULL, '60 BLOCK 41 LOT 24 MARGARITA MORAN ST. BF RESORT VILLAGE TALON DOS LAS PIÑAS CITY', NULL, NULL, NULL, NULL, NULL, NULL, '0001-1157-3604', '03-6576790-7', '01-050399317-7', 'REGULAR', '0922-805-1103', NULL, NULL, 'eaadia@fpdasia.net', '2013-12-01', NULL, 32, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(235, 3094, 'pic2.png', 'CAA3094', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'CHERRY JOY', 'ALCANTARA', 'AUSTRIA', 'FILIPINO', '1987-07-10', 'F', 'PASIG CITY', NULL, 'Married', NULL, 'PHASE 8A BLK. 163 PACKAGE 12 LOT 8 BAGONG SILANG, CALOOCAN CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1460-0031-5792', '04-1983729-1', '08-050801831-6', 'REGULAR', '0933-3305938', NULL, NULL, 'cherryjoyaustria@yahoo.com', '2014-01-06', NULL, 45, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(236, 3097, 'pic2.png', 'NTB3097', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'NOVAH LEA', 'TEMBREVILLA', 'BARCENA', 'FILIPINO', '1989-11-01', 'F', 'NEGROS OCCIDENTAL', NULL, 'Single', NULL, '49F MANALO STREET BRGY STO TOMAS PASIG CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1210-2594-2346', '34-2136205-2', '02-050702238-4', 'CO-TERMINUS', '9467665365', NULL, NULL, 'novahleat@yahoo.com', '2014-01-15', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(237, 4001, 'pic2.png', 'MNB4001', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MARIA EDITHA SUERTE', 'NICOLAS', 'BUL-LALAYAO', 'FILIPINO', '1978-11-27', 'F', 'BATAC ILOCOS NORTE', NULL, 'Single ', NULL, '#7733 JB ROXAS ST. BRGY OLYMPIA MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, ' 1010-0351-2791', '33-7024290-6', ' 02-050188607-7', 'CO-TERMINUS', '0927-254-9728', NULL, NULL, 'marie_bullalayao@yahoo.com', '2014-01-17', NULL, 0, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(238, 4004, 'pic1.png', 'VAB4004', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'VENER', 'ABEJO', 'BOLIDO', 'FILIPINO', '1987-08-11', 'M', NULL, NULL, 'Married', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9140-9706-7331', '34-2997933-7', '30511428064', 'CO-TERMINUS', NULL, NULL, NULL, NULL, '2014-01-17', NULL, 42, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(239, 4023, 'pic1.png', 'LBS4023', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'LEMWEL', 'BORROMEO', 'SIAPNO', 'Filipino', '1976-12-24', 'M', 'ALBAY', NULL, 'Married', NULL, '#69 ZONE 1-A SAN VICENTE TABACO CITY, ALBAY', NULL, NULL, NULL, NULL, NULL, NULL, '1090-03367861', '05-0916355-8', '19-089781672-9', 'CO-TERMINUS', NULL, NULL, NULL, NULL, '2014-02-28', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(240, 3130, 'pic1.png', 'JMA3130', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JOSEPH', 'MAHIPOS', 'ABELLO', 'Filipino', '1969-11-23', 'M', 'NEGROS OCCIDENTAL', NULL, 'Married', NULL, 'PUROK-9 PNR SITE WEST BICUTAN TAGUIG', NULL, NULL, NULL, NULL, NULL, NULL, '0002-272721-03', '33-3054070-3', '19-051459478-7', 'CO-TERMINUS', '0995-5319687', NULL, NULL, 'abellojoseph7@gmail.com', '2014-03-28', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(241, 3132, 'pic1.png', 'RHR3132', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ROMANUEL', 'HARME', 'RIVERA', 'Filipino', '1987-12-02', 'M', 'BINONDO MANILA', NULL, 'Married', NULL, '340 P CARREON ST. BINONDO MANILA', NULL, NULL, NULL, NULL, NULL, NULL, '1211-1491-4096', '34-0243792-2', ' 02-050489730-4', 'CO-TERMINUS', '9774259344', NULL, NULL, 'namo_rivera@yahoo.com', '2014-04-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(242, 3137, 'pic1.png', 'NFP3137', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'NORBERTO JR.', 'FEVIDAL', 'PORTILLO', 'FILIPINO', '1986-11-10', 'M', 'TACLOBAN LEYTE', NULL, 'Married', NULL, 'BLK-17,LOT12,PHASE-1 BN-2 BRGY. SAN ISIDRO ANTIPOLO', NULL, NULL, NULL, NULL, NULL, NULL, '1211-1547-8334', '33-9860711-2', '03-050389920-1', 'CO-TERMINUS', '9120259449', NULL, NULL, 'BERTPORTILLO2K@GMAIL.COM', '2014-04-11', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(243, 3139, 'pic2.png', 'AAA3139', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'AIZA', 'AUSTRIA', 'ANGELES', 'Filipino', '1987-09-15', 'F', 'ALFONSO, CAVITE', NULL, 'Married', NULL, '564 LUKSUHIN IBABA ALFONSO, CAVITE', NULL, NULL, NULL, NULL, NULL, NULL, '9120-8404-0190', '34-1249741-5', '01-0514681622', 'CO-TERMINUS', '0930-954-0868', NULL, NULL, 'aiza_angeles15@yahoo.com', '2014-04-11', NULL, 9, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(244, 3154, 'pic1.png', 'VFB3154', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'VIVENCIO', 'FABRE', 'BACORRO JR. ', 'Filipino', '1977-01-03', 'M', 'METRO MANILA', NULL, 'Married', NULL, 'BLK. 138 L2 NHY TIGBE P-4 NORZAGARAY BULACAN', NULL, NULL, NULL, NULL, NULL, NULL, '1040-0204-4358', '33-4766165-9', '01-051505909-7', 'CO-TERMINUS', '9233104300', NULL, NULL, 'vivenciobacorro94@gmail.com', '2014-05-12', NULL, 50, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(245, 3155, 'pic1.png', 'RUF3155', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RODRIGO JR.', 'UGAY', 'FARRO', 'Filipino', '1991-09-21', 'M', 'MAKATI, DELPAN', NULL, 'Single', NULL, 'BLK 38 LOT 15 P4 CRISTOBAL ST., UPPER BICUTAN, TAGUIG CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1210-6967-9250', '34-2639127-7', '01-051449880-1', 'CO-TERMINUS', '9126986850', NULL, NULL, 'rod102215@gmail.com', '2014-05-12', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(246, 3163, 'pic1.png', 'GIL3163', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'GIOVANNE', 'INIEGO', 'LAMPARAS', 'FILIPINO', '1985-04-01', 'M', 'OROQUIETA CITY, MISAMIS OCCIDENTAL', NULL, 'Single', NULL, '#051 WALING-WALING ST. PAYATAS A. QUEZON CITY', NULL, NULL, NULL, NULL, NULL, NULL, '9141-4213-6201', '34-1261684-3', '03-025601325-4', 'CO-TERMINUS', '9473871609', NULL, NULL, 'giovanne.lamparas@yahoo.com', '2014-05-23', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(247, 3186, 'pic1.png', 'ESG3186', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ELBERT', 'SOGUILON', 'GOLPERICA', 'Filipino', '1987-03-19', 'M', 'ORIENTAL MINDORO', NULL, 'Married ', NULL, 'BLK 44, LOT 17, BRGY. PINAGSAMA PHASE 2, C5, TAGUIG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '34-1148724-8', '02-025747686-4', 'CO-TERMINUS', '9062453906', NULL, NULL, 'golpericabert@gmail.com', '2014-07-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(248, 3200, 'pic2.png', 'MSJ3200', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MARIA LUISA', 'SENERES', 'JOVEN', 'Filipino', '1968-01-27', 'F', 'QUEZON CITY', NULL, 'Single', NULL, 'BLK. 17 LOT 6, GOLDENVILLE 2, SABANG, DASMARINAS, CAVITE', NULL, NULL, NULL, NULL, NULL, NULL, '1020-0046-0236', '04-1133443-3', '08-050725747-3', 'REGULAR', '0919 5656172', NULL, NULL, 'luiven2003@yahoo.com', '2014-08-04', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(249, 3215, 'pic1.png', 'ACD3215', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'AR-JAY', 'CADAG', 'DELA CRUZ', 'Filipino', '1986-11-25', 'M', 'AURORA', NULL, 'Single', NULL, 'PANAY ST. BRGY PITOGO, MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1210-6824-4707', '02-2925234-1', '08-051114297-4', 'CO-TERMINUS', '9329884820', NULL, NULL, 'rjdc86@yahoo.com', '2014-09-01', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(250, 3217, 'pic1.png', 'RBL3217', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RAUL DELFIN', 'BAUTISTA', 'LAZARO', 'Filipino', '1964-12-24', 'M', 'MALOLOS, BULACAN', NULL, 'Married', NULL, 'L4B7P8 Mayflower St., Greenland Executive Village, Cainta Rizal', NULL, NULL, NULL, NULL, NULL, NULL, '1090-0139-0287', '03-8388428-6', '19-089504051-0', 'REGULAR', '09228046196', NULL, NULL, 'lazarorauldelfin@yahoo.com', '2014-09-05', NULL, 39, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(251, 3219, 'pic2.png', 'JCT3219', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JEAN KEZIAH', 'CANADIDO', 'TAN', 'Filipino', '1989-09-14', 'F', 'VALENZUELA M.M.', NULL, 'Single', NULL, '7812 J.B. ROXAS ST. BRGY. OLYMPIA, MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1210-4084-2619', '34-2351480-8', '01-025357781-4', 'CO-TERMINUS', '9069691408', NULL, NULL, 'jkctan08@gmail.com', '2014-09-05', NULL, 9, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(252, 3223, 'pic2.png', 'MCT3223', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MARIA FE', 'CAUSAREN', 'TUAZON', 'FILIPINO', '1986-05-04', 'F', 'TAGUIG', NULL, 'Single', NULL, '04 ILANG ILANG ST. TOMASA ESTATE SUBD. PH. II USUSAN TAGUIG CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0325-6758', '34-0527296-4', '01-050531192-8', 'CO-TERMINUS', '9173802085', NULL, NULL, 'mafe_50486@yahoo.com', '2014-09-16', NULL, 9, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(253, 3226, 'pic1.png', 'NRS3226', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'NICKY', 'RONQUILLO', 'SEBASTIAN', 'Filipino', '1992-12-01', 'M', 'Mandaluyong City', NULL, 'Single', NULL, '3k1 E Auinaldo St. West Pembo makati City', NULL, NULL, NULL, NULL, NULL, NULL, '9132-4290-4486', '34-4083965-0', ' 01-025561006-1', 'CO-TERMINUS', '9173373810', NULL, NULL, 'nickz943@yahoo.com', '2014-10-01', NULL, 17, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(254, 3243, 'pic2.png', 'EJJ3243', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ELIZABETH', 'JANGAYO', 'JOAQUIN', 'Filipino', '1993-11-17', 'F', 'Ilo-Ilo City', NULL, 'Single', NULL, 'Odiong Roxas Oriental Mindoro', NULL, NULL, NULL, NULL, NULL, NULL, '1211-3156-4368', '34-4839017-5', '01-051975067-3', 'CO-TERMINUS', '9488156650', NULL, NULL, 'Elizabethjjoquin@gmail.com', '2014-11-10', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(255, 3252, 'pic2.png', 'MML3252', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MARICEL', 'MILLENA', 'LORICA', 'FILIPINO', '1983-02-22', 'F', 'DARAGA, ALBAY', NULL, 'Single', NULL, 'ROSARIO, PASIG CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1211-2273-2867', '33-8537957-6', '0302-5654-3997', 'CO-TERMINUS', '9331396792', NULL, NULL, 'MACEJO@gmail.com', '2014-11-19', NULL, 17, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(256, 3254, 'pic2.png', 'MRR3254', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MELODY', 'RIVERA', 'REYES', 'FILIPINO', '1989-02-24', 'F', 'MAKATI', NULL, 'Married', NULL, '316 DAPITAN ST. GUAD. NUEVO, MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1211-3186-7624', '34-0086559-6', '19-200933688-1', 'CO-TERMINUS', '9174970405', NULL, NULL, 'mengkai24@gmail.com', '2014-11-18', NULL, 65, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(257, 3255, 'pic2.png', 'MGG3255', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MARY LUZ', 'GURAY', 'GUAN', 'FILIPINO', '1987-02-04', 'F', 'SORSOGON', NULL, 'Single', NULL, '122 BLK. 43 PINAGSAMA VILLAGE, TAGUIG CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1210-3999-0047', '34-0708434-1', '19-090569127-2', 'CO-TERMINUS', '9271207410', NULL, NULL, 'maryluz.guan@gmail.com', '2014-11-20', NULL, 9, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(258, 3260, 'pic1.png', 'JLB3260', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JOMAR', 'LUVINARIO', 'BANAAG', 'Filipino', '1983-04-01', 'M', 'SAN JUAN,BATANGAS', NULL, 'Married', NULL, '#1311 A. BERNARDIANO STREET, UGONG, VALENZUELA CITY.', NULL, NULL, NULL, NULL, NULL, NULL, '1210-4361-5141', '33-6539062-7', '02-050717610-1', 'CO-TERMINUS', '0943-059-5813', NULL, NULL, 'journey_n3@yahoo.com', '2015-01-27', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(259, 3261, 'pic1.png', 'PFN3261', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'PONCE', 'FERRER', 'NEPACENA', 'FILIPINO', '1966-06-23', 'M', 'NOVALICHES QUEZON CITY', NULL, 'Married', NULL, '814 PRIME ROSE ST. LAKEVIEW PUTATAN MUNTINLUPA CITY', NULL, NULL, NULL, NULL, NULL, NULL, '0009-1955-4302', '03-9272922-2', '08-050013501-1', 'CO-TERMINUS', '0939-7149648', NULL, NULL, 'pnepacena@gmail.com', '2015-01-27', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(260, 3268, 'pic1.png', 'XPB3268', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'XAVIER', 'PAGUIO', 'BERMUDEZ', 'FILIPINO', '1990-07-10', 'M', 'MANILA', NULL, 'Single', NULL, '41-B KALIRAYA ST. QUEZON CITY', NULL, NULL, NULL, NULL, NULL, NULL, '9131-0813-5505', '34-3553434-2', '02-025880005-3', 'REGULAR', '9064831200', NULL, NULL, 'xavierbermudez@gmail.com', '2015-01-27', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(261, 3272, 'pic1.png', 'GME3272', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'GLENN', 'MANGANA', 'EBOSEO', 'Filipino', '1974-05-31', 'M', 'MAKATI', NULL, 'Single', NULL, '3084 AGUINALDO ST. SOUTH CEMBO MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, '4010-0003-9634', '33-6284147-0', '23-004174154-1', 'CO-TERMINUS', '9226713196', NULL, NULL, 'glenn_eboseo@yahoo.com', '2015-02-16', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(262, 3278, 'pic1.png', 'GAR3278', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'GERALDINO', 'ABAYON', 'REYES', 'Filipino', '1979-05-10', 'M', 'PANDACAN, MANILA', NULL, 'Married', NULL, '94 EVERLASTING STREET, PZBG COMPOUND, QUEZON AVENUE, QUEZON CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1211-4010-0373', '33-7677516-3', '03-050352513-1', 'CO-TERMINUS', '09197250661', NULL, NULL, 'joharie12@yahoo.com', '2015-03-17', NULL, 17, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(263, 3279, 'pic1.png', 'ROJ3279', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'REYNALDO', 'OCLARIT', 'JAMERO', 'Filipino', '1982-03-27', 'M', 'BUKIDNON', NULL, 'Married', NULL, '470 A-2 EAGLE ST. SITIO VETERANS BRGY BAGONG SILANGAN Q,C ', NULL, NULL, NULL, NULL, NULL, NULL, '1210-3317-2821', '33-9112071-9', '01-050386335-4', 'CO-TERMINUS', '0930-6777466', NULL, NULL, NULL, '2015-03-02', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(264, 3280, 'pic1.png', 'RPL3280', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RANDEL', 'PETRONIO', 'LIPIO', 'Filipino', '1984-09-27', 'M', 'MANILA', NULL, 'Married', NULL, 'BLK 47 LOT 1 PALIPARAN III DASMARIÑAS CAVITE', NULL, NULL, NULL, NULL, NULL, NULL, '1211-7580-3520', '34-1468086-4', '19-026780971-6', 'CO-TERMINUS', '9773848527', NULL, NULL, NULL, '2015-02-16', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(265, 3283, 'pic1.png', 'JMC3283', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JOSE', 'MAGHANOY', 'CAGUBCOB', 'FILIPINO', '1967-01-02', 'M', 'GITAGUM, MISAMIS ORIENTAL', NULL, 'Married', NULL, '400 LAWAAN ST.CREEKLAND HAGONOY, TAGUIG CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1020-0344-9391', '08-0692338-1', '01-050019972-0', 'CO-TERMINUS', '09333066991', NULL, NULL, NULL, '2015-03-18', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(266, 3294, 'pic1.png', 'RCT3294', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ROLANDO', 'CAMINO', 'TABLIZO', 'Filipino', '1970-08-28', 'M', 'ANGELES CITY ', NULL, 'Married', NULL, '790 MASBATE ST. MAKATI CITY ', NULL, NULL, NULL, NULL, NULL, NULL, '1040-0071-9121', '03-9662224-4', '01-050187078-7', 'CO-TERMINUS', '9152257864', NULL, NULL, 'N/A', '2015-03-31', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(267, 3299, 'pic2.png', 'LCD3299', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'LANIE', 'CORTEZ', 'DE GUZMAN', 'FILIPINO', '1972-02-15', 'F', 'CABANATUAN CITY', NULL, 'Married', NULL, '10B ROXAS CIRCLE, SAUYO, NOVALICHES, QUEZON CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1050-0124-7148', '02-1081287-1', '08-050237996-1', 'CO-TERMINUS', '0922-769-5592', NULL, NULL, 'einaldeguzman@yahoo.com', '2015-04-06', NULL, 9, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(268, 4012, 'pic2.png', 'LTS4012', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'LIEZEL', 'TIPSAY', 'SANCHEZ', 'Filipino', '1976-01-12', 'F', 'NEG. OCC.', NULL, 'Married ', NULL, 'RM 209, BLDG. 18, MRB VILL., C5 RD, BRGY USUSAN, TAGUIG', NULL, NULL, NULL, NULL, NULL, NULL, '2003-462-23507', '33-4673598-4', '01-050318024-9', 'CO-TERMINUS', '09771707206/09289683769', NULL, NULL, 'ltipsay@yahoo.com', '2014-02-01', NULL, 9, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(269, 3312, 'pic1.png', 'KMD3312', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'KIM', 'MALUBAG', 'DUA', 'Filipino', '1976-09-30', 'M', 'CABANATUAN CITY', NULL, 'Married', NULL, 'B6 NARRA ST. CEMBO,MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, '9150-1281-7217', '33-6687411-3', '03-050140509-0', 'CO-TERMINUS', '9163565038', NULL, NULL, 'dua_kim@yahoo.com', '2015-05-05', NULL, 74, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(270, 3315, 'pic1.png', 'PAB3315', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'PAUL EMWEIL', 'AMIN', 'BRIOBO', 'Filipino', '1983-03-14', 'M', 'VALENZUELA CITY', NULL, 'Married', NULL, 'BSA Tower, 108 Legaspi St. Legaspi Village, Makati City', NULL, NULL, NULL, NULL, NULL, NULL, '1090-0320-1350', '33-8593006-7', '02-025064694-2', 'CO-TERMINUS', '09294725983/09278802852', NULL, NULL, 'llemuel101@yahoo.com', '2015-05-13', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(271, 3334, 'pic1.png', 'JSP3334', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JAY', 'SIGUA', 'PRANGAN', 'Filipino', '1991-05-25', 'M', 'VICTORIA, LAGUNA', NULL, 'Single', NULL, '#915 ME PUROK 2, BRGY. BANCA-BANCA, VICTORIA, LAGUNA', NULL, NULL, NULL, NULL, NULL, NULL, '1211-5044-1563', '04-2918354-0', '02-051099783-3', 'CO-TERMINUS', '9125485092', NULL, NULL, 'prangan_jay@yahoo.com', '2015-06-26', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(272, 3336, 'pic2.png', 'ERL3336', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ELEANOR KATHRYN', 'RABUY', 'LUKBAN', 'Filipino', '1975-10-16', 'F', 'Manila', NULL, 'Married', NULL, 'Unit 6A LPL Plaza Bldg, Leviste St, Salcedo Village, Makati City', NULL, NULL, NULL, NULL, NULL, NULL, '0210-8775-6009', '33-4741096-5', '19-090450764-8', 'REGULAR', '09178041675', NULL, NULL, 'ekgrabuy@gmail.com', '2015-07-06', NULL, 33, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(273, 3338, 'pic2.png', 'MVA3338', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MA. JESSERYL', 'VILLANUEVA', 'ARNAIZ', 'FILIPINO', '1993-04-17', 'F', 'NEGROS OCCIDENTAL', NULL, 'Single', NULL, 'BURGOS ST. ISABELA NEGROS OCCIDENTAL', NULL, NULL, NULL, NULL, NULL, NULL, '9140-6603-2708', '07-2846570-7', '11-050625430-2', 'CO-TERMINUS', '0977-3748641', NULL, NULL, 'jesserylarnaiz@yahoo.com', '2015-07-13', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(274, 3339, 'pic1.png', 'EAO3339', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'EDGAR', 'ACEDERA', 'O\'NEIL', 'FILIPINO', '1977-11-19', 'M', 'MANILA', NULL, 'Married', NULL, '287 ALFONSO ISIDRO TOLENTINO ST., PASAY CITY', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '33-1978607-0', '01-050434326-5', 'CO-TERMINUS', '9176997465', NULL, NULL, 'rangerone3six@yahoo.com', '2015-07-14', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(275, 3346, 'pic1.png', 'AFR3346', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ALMERO', 'FUENTES', 'ROGAN', 'FILIPINO', '1980-10-10', 'M', 'NUMANCIA, AKLAN', NULL, 'Married', NULL, '#19 AQUARIUS ST. PAMPLONA PARK, PAMPLONA 2, LAS PINAS CITY', NULL, NULL, NULL, NULL, NULL, NULL, '0010-1092-0901', '33-8530662-0', '19-090133161-1', 'REGULAR', '0906 432 6166', NULL, NULL, 'rogan.almero@gmail.com', '2015-08-03', NULL, 60, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(276, 3353, 'pic2.png', 'RRV3353', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RACHEL', 'RIVERA', 'VALDEZ', 'Filipino', '1995-07-21', 'F', 'MAKATI CITY', NULL, 'Single', NULL, 'BKL 75 L6 BLUEBOZ EXT. BRGY RIZAL MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1211-3727-8229', '34-4978227-4', '01-025732717-0', 'CO-TERMINUS', '9352461927', NULL, NULL, 'rachelr_valdez@yahoo.com', '2015-08-18', NULL, 65, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(277, 3354, 'pic2.png', 'ATA3354', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ALISANDRA PATRICIA', 'TARROJA', 'ADA', 'Filipino', '1994-05-29', 'F', 'MAKATI CITY', NULL, 'Single', NULL, '2508-C ELORIAGA ST. STA. ANA MANILA', NULL, NULL, NULL, NULL, NULL, NULL, '1211-5172-8277', '34-5318614-1', '01-025792420-9', 'CO-TERMINUS', '0907-4748842', NULL, NULL, 'alisandra_ada@yahoo.com', '2015-08-18', NULL, 65, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(278, 3357, 'pic2.png', 'CIA3357', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'CAMILLE', 'ILAO', 'ABIAD', 'Filipino', '1994-10-03', 'F', 'MATABUNGKAY, LIAN BATANGAS', NULL, 'Single', NULL, '47A ROAD 10, BAGONG PAG-ASA, QUEZON CITY.', NULL, NULL, NULL, NULL, NULL, NULL, '1211-5262-3636', '34-5345624-0', '09-251191171-2', 'CO-TERMINUS', '0916-844-8306', NULL, NULL, 'abiad.camille@gmail.com', '2015-08-25', NULL, 65, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(279, 3374, 'pic1.png', 'JMV3374', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JOEL', 'MANALANG', 'VITUG', 'FILIPINO', '1980-07-31', 'M', 'MARIKINA', NULL, 'Single', NULL, '169 MALAYA ST. MALANDAY MARIKINA CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1210-7538-2108', '33-8621184-0', '03-050287805-7', 'CO-TERMINUS', '9987652073', NULL, NULL, 'vitugjoel@yahoo.com', '2015-10-13', NULL, 17, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(280, 3378, 'pic1.png', 'RSA3378', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ROBERTO JR.', 'SESCON', 'AYURO', 'FILIPINO', '1990-06-01', 'M', 'MAKATI', NULL, 'Single', NULL, 'BLK 10 LOT 21 J. P. RIZAL ST. BRGY. RIZAL MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1211-0218-9389', '34-1340466-9', '01-025325874-3', 'CO-TERMINUS', '9183495399', NULL, NULL, 'ayuro.roberto06@gmail.com', '2015-10-19', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(281, 3380, 'pic1.png', 'ODP3380', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'OSCAR JR.', 'DIZON', 'PACAIGUE', 'FILIPINO', '1983-03-21', 'M', 'MANILA', NULL, 'Married', NULL, '#2 DOÑA PACITA ST. VILLA BEATRIZ, M. BALARA Q.C.', NULL, NULL, NULL, NULL, NULL, NULL, '9122-7804-7266', '34-1383188-9', '01-050879577-2', 'REGULAR', '0947-9593070', NULL, NULL, 'o.pacaigue@yahoo.com', '2015-10-05', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(282, 3381, 'pic1.png', 'MRC3381', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MARS', 'REYES', 'CARO', 'Filipino', '1991-05-24', 'M', 'SAN PABLO CITY, LAGUNA', NULL, 'Single', NULL, 'UNIT 513 ROCK FORT RESIDENCES BARANGAY PINAGKAISAHAN, KALAYAAN AVE. MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1211-5344-9019', '01-2222504-8', '06-050145690-2', 'CO-TERMINUS', '0977-7318809', NULL, NULL, 'caro_mars@yahoo.com', '2015-10-19', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(283, 3382, 'pic1.png', 'NUV3382', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'NEIL', 'URETA', 'VILLASOTO', 'Filipino', '1985-06-02', 'M', 'PASIG CITY', NULL, 'Single', NULL, '#4 NOMALILI ST. BRGY. CENTRAL SIGNAL VILLAGE TAGUIG CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1211-1428-1920', '33-9834627-9', '01-050898554-7', 'CO-TERMINUS', '09279733262', NULL, NULL, 'shiro_jazz_tanaka@yahoo.com', '2015-10-22', NULL, 17, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(284, 3385, 'pic2.png', 'MED3385', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MARY JANE', 'ESPEJO', 'DE GUZMAN-JUNIO', 'Filipino', '1979-09-14', 'F', 'CALOOCAN CITY, MANILA', NULL, 'Married', NULL, 'PALIPARAN SITE DASMARIÑAS CITY, CAVITE', NULL, NULL, NULL, NULL, NULL, NULL, '1020-0315-1253', '02-1505565-9', '01-025387032-5', 'CO-TERMINUS', '09773477800', NULL, NULL, 'maryjane_deguzman2000@yahoo.com', '2015-10-20', NULL, 65, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(285, 3391, 'pic1.png', 'MDL3391', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MARK PAUL', 'DIZON', 'LULU', 'Filipino', '1990-09-11', 'M', 'PAMPANGGA', NULL, 'Single', NULL, '78 SAN PEDRO STA. ANA PAMPANGGA', NULL, NULL, NULL, NULL, NULL, NULL, '1210-7900-5993', '02-3312366-0', '07-025604799-1', 'REGULAR', '9153091128', NULL, NULL, 'markpaullulu@gmail.com', '2015-10-29', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(286, 3392, 'pic1.png', 'LMS3392', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'LEGORIO', 'MENDOZA', 'SABARIAS JR.', 'Filipino', '1991-03-17', 'M', 'MANILA', NULL, 'Single', NULL, 'P8-11 1ST STREET VILLAMOR AIR BASE PASAY CITY ', NULL, NULL, NULL, NULL, NULL, NULL, '1211-3582-9680', '34-2536644-9', '01-051234836-5', 'CO-TERMINUS', '9354850398', NULL, NULL, 'legors_17@yahoo.com', '2015-10-30', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(287, 3394, 'pic2.png', 'ACA3394', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ALYSON CHRISTIE', 'CONDE', 'ARAGON', 'FILIPINO', '1987-12-25', 'F', 'ANGONO RIZAL', NULL, 'Married', NULL, '275 SAMPAGUITA ST., MAMBOG, BINANGONAN RIZAL', NULL, NULL, NULL, NULL, NULL, NULL, '1210-5430-9250', '34-1135480-5', '01-050645087-5', 'CO-TERMINUS', '9278007675', NULL, NULL, 'aragon.alysonchristie@yahoo.com', '2015-11-04', NULL, 0, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:11', '2020-08-24 02:18:11'),
(288, 3395, 'pic2.png', 'ETM3395', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'EDELYN', 'TRIÑANES', 'MORATALLA', 'Filipino', '1983-03-31', 'F', 'PIODURAN ALBAY', NULL, 'Single', NULL, 'Unit 3A, 4410 Calatagan St. Brgy Palanan, Makati City', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0208-8649', '33-9088100-4', '01-050281141-5', 'REGULAR', '9213243145', NULL, NULL, 'speedo_bluedz@yahoo.com', '2015-11-04', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(289, 3396, 'pic1.png', 'WRD3396', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'WILSON', 'ROBLES', 'DAVID', 'Filipino', '1979-12-02', 'M', 'MANILA', NULL, 'Single', NULL, 'BLDG A-109 JCS VILLAGE PUNTA STA ANA MANILA', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0323-6576', '33-4962852-2', '01-050623493-5', 'CO-TERMINUS', '09502677151', NULL, NULL, 'robsponks_831@yahoo.com', '2015-11-05', NULL, 17, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(290, 3403, 'pic1.png', 'JDR3403', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'J-SOR', 'DIOLA', 'RAMOS', 'Filipino', '1991-11-08', 'M', 'Lutucan Sariyaya Quezon Province', NULL, 'Single', NULL, 'Sito Pontor Bignay 1 Lutucan Sariyaya Quezon Province', NULL, NULL, NULL, NULL, NULL, NULL, '1210-9496-9213', '34-1914792-0', '01-051564644-8', 'CO-TERMINUS', '9489995876', NULL, NULL, 'jsorramos@yahoo.com', '2015-11-23', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(291, 3404, 'pic2.png', 'NBS3404', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'NEFBELL', 'BANDEJAS', 'SUAVERDEZ', 'Filipino', '1993-11-17', 'F', '91 PUROK ILAN-ILANG, BRGY. ANTIKIN,INFANTA QUEZON', NULL, 'Single', NULL, '16 ROAD 4 SAN MIGUEL HEIGHTS MARILAS, VALENZUELA', NULL, NULL, NULL, NULL, NULL, NULL, '1211-5847-7553', '34-5509769-4', '02-026614806-3', 'CO-TERMINUS', '0943-465-6041', NULL, NULL, 'nefsuaverdez@gmail.com', '2015-11-17', NULL, 22, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(292, 3408, 'pic1.png', 'ADH3408', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ARMANDO', 'DELA VEGA', 'HUMARANG', 'FILIPINO', '1989-09-27', 'M', 'TRECE MARTIRES CITY, CAVITE', NULL, 'Single', NULL, '#30A BRGY. CALIBUYO, TANZA, CAVITE', NULL, NULL, NULL, NULL, NULL, NULL, '1210-0433-6109', '34-2621405-3', '08-051072274-8', 'CO-TERMINUS', '9065400990', NULL, NULL, 'Arman20seven@gmail.com', '2015-12-18', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(293, 3427, 'pic2.png', 'MBM3427', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MAE ANN', 'BERNARDO', 'MATAWARAN', 'Filipino', '1995-07-21', 'F', 'TANAY RIZAL', NULL, 'Single', NULL, 'BLK 10 Lot 3 Dau St. Little Tanay Ville Brgy. Tandang Kutyo Tanay, Rizal', NULL, NULL, NULL, NULL, NULL, NULL, '1211-4859-4729', '34-5059805-9', '01-025777771-0', 'CO-TERMINUS', '0936-7959221', NULL, NULL, 'matawaranmaeann@gmail.com', '2016-02-09', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(294, 3435, 'pic1.png', 'RNR3435', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'REGIE', 'NAVIDA', 'RAMOS', 'Filipino', '1988-07-21', 'M', 'QUEZON CITY', NULL, 'Married', NULL, '5 Lanzones St. Libis Bulelak Malanday Marikina City', NULL, NULL, NULL, NULL, NULL, NULL, '1210-0531-2922', '34-2453417-5', '01-051131230-8', 'REGULAR', '9258912307', NULL, NULL, 'regie_ramos@yahoo.com', '2016-03-01', NULL, 60, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(295, 3439, 'pic2.png', 'RSF3439', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RHODA', 'STA.ROMANA', 'FLORES', 'Filipino', '1982-10-29', 'F', 'OTON ILOILO', NULL, 'Single', NULL, '2474 BELARMINO ST. BANGKAL MAKATI CITY', NULL, NULL, NULL, NULL, NULL, NULL, '1210-3318-9448', '33-8747576-6', '02-050660494-0', 'REGULAR', '0935-9553044', NULL, NULL, 'rhodaflores16@yahoo.com', '2016-03-11', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(296, 3451, 'pic2.png', 'HAL3451', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'HAZELINE JOY', 'ABARRO', 'LEONCIO', 'Filipino', '1988-01-01', 'F', 'Rosario, Cavite', NULL, 'Single', NULL, '184 Abueg St. (Daang Bukid), Brgy. Poblacion, Rosario Cavite', NULL, NULL, NULL, NULL, NULL, NULL, '1210-5492-9040', '34-1548223-6', '08-050977485-8', 'REGULAR', '9568692847', NULL, NULL, 'hazeline_jhoy@yahoo.com', '2016-04-11', NULL, 41, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(297, 3457, 'pic1.png', 'BCT3457', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'BON ALLAN', 'CO', 'TAN', 'Filipino', '1983-11-22', 'M', 'Manila City', NULL, 'Married', NULL, 'B37 L58 Villa Corzon Guyong Sta. Maria, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, '1020-0069-2591', '34-0042730-3', '02-050290881-3', 'CO-TERMINUS', '9158226548', NULL, NULL, 'bon_allan@yahoo.com', '2016-04-07', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(298, 3461, 'pic1.png', 'JAD3461', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JOEL', 'ABINON', 'DELIGERO', 'Filipino', '1969-06-01', 'M', 'Southern Leyte', NULL, 'Married', NULL, 'B88 L27 Amorseco St. Brgy Rizal Makati City', NULL, NULL, NULL, NULL, NULL, NULL, '1210-3036-3807', '33-3284985-5', '03-050395155-6', 'CO-TERMINUS', '9326014795', NULL, NULL, 'vpjoel_deligero@yahoo.com', '2016-04-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(299, 3464, 'pic2.png', 'RDB3464', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ROCHELLE', 'DELA CRUZ', 'BUENDIA', 'Filipino', '1982-01-13', 'F', 'Polo, Valenzuela', NULL, 'Married', NULL, '#7 Libya St. Greenheights Subdivision, Marikina City', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0307-4074', '33-6260582-3', '1909-0058-3889', 'REGULAR', '9152632147', NULL, NULL, 'rochelle_13delacruz@hotmail.com', '2016-04-25', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12');
INSERT INTO `hris_employees` (`id`, `employee_number`, `employee_photo`, `username`, `password`, `firstname`, `middlename`, `lastname`, `nationality`, `birthday`, `gender`, `place_birth`, `dependant`, `marital_status`, `work_address`, `home_address`, `home_distance`, `emergency_contact`, `emergency_no`, `cert_level`, `field_study`, `school`, `pagibig`, `sss`, `phic`, `employment_status`, `work_no`, `work_phone`, `work_email`, `private_email`, `joined_date`, `termination_date`, `job_title_id`, `department_id`, `supervisor`, `pay_grade`, `role_id`, `last_login`, `status`, `created_at`, `updated_at`) VALUES
(300, 3466, 'pic2.png', 'JME3466', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JOVY', 'MAGUAD', 'ESPARAGOZA', 'Filipino', '1987-10-17', 'F', 'Negros, Occidental', NULL, 'Single', NULL, '#58 P. Cruz Brgy. San Jose Mandaluyong City', NULL, NULL, NULL, NULL, NULL, NULL, '1211-2235-3210', '34-2514872-2', '02-050668428-6', 'CO-TERMINUS', '9236975976', NULL, NULL, 'jovy.esparagoza@yahoo.com', '2016-04-25', NULL, 43, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(301, 3475, 'pic1.png', 'AES3475', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ANTONIO', 'EDEN', 'SANORJO', 'Filipino', '1976-08-03', 'M', 'Pasig City', NULL, 'Married', NULL, '183-H 25th Ave. East Rembo Makati City ', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0377-0878', '33-5585568-0', '19-200710716-8', 'CO-TERMINUS', '9774880142', NULL, NULL, 'sanorjojr.antonio@yahoo.com', '2016-04-27', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(302, 3483, 'pic1.png', 'CYT3483', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'CHRISTIAN', 'YGRUBAY', 'TIU', 'Filipino', '1993-12-06', 'M', 'Taguig City', NULL, 'Single', NULL, '153 Blk 7 Zone 3 Fort Bonifacio Taguig City', NULL, NULL, NULL, NULL, NULL, NULL, '1211-6947-0648', '34-5885857-1', '01-052149366-1', 'CO-TERMINUS', '09275611339', NULL, NULL, 'christiantiu.propertymanager@gmail.com ', '2016-05-05', NULL, 0, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(303, 3487, 'pic2.png', 'JFD3487', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JOSIELINE', 'FABLATIN', 'DACAYO', 'Filipino', '1965-02-17', 'F', 'San, Narciso Zambales', NULL, 'Single', NULL, '8B 1st St. Simplicio Cruz Compound San Isidro Parañaque', NULL, NULL, NULL, NULL, NULL, NULL, '0022-6394-3709', '02-0823381-5', '07-050223706-1', 'CO-TERMINUS', '9209465321', NULL, NULL, 'joydac@yahoo.com', '2016-05-13', NULL, 7, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(304, 3488, 'pic1.png', 'WGQ3488', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'WILIJADO JR.', 'GUTUAL', 'QUIMNO', 'Filipino', '1993-06-06', 'M', 'Cagayan De Oro', NULL, 'Single', NULL, '#81 Kalayaan Brgy Central Diliman, Quezon City', NULL, NULL, NULL, NULL, NULL, NULL, '9123-2403-8401', '08-1983188-4', '15-050332245-7', 'CO-TERMINUS', '9261312967', NULL, NULL, NULL, '2016-04-01', NULL, 29, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(305, 3492, 'pic2.png', 'JRB3492', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JENNIFER', 'RUIZ', 'BUSTAMANTE', 'Filipino', '1969-08-27', 'F', 'Quezon City', NULL, 'Married', NULL, 'D5- 567 I. Reyes St. Pasay City', NULL, NULL, NULL, NULL, NULL, NULL, '1210-2348-0686', '33-1283320-5', '19-052204468-0', 'REGULAR', '9054754730/ 09998503117', NULL, NULL, 'jenbustamante@gmail.com', '2016-05-30', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(306, 3494, 'pic1.png', 'RMO3494', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'REYNALDO', 'MONTEROLA', 'OCHO JR', 'Filipino', '1978-09-21', 'M', 'Agusan Del Norte', NULL, 'Single', NULL, 'Purok 4 Blk 1 San Guillermo St. Bayanan, Muntinlupa Lupa City', NULL, NULL, NULL, NULL, NULL, NULL, '121-16469-5305', '33-5880282-1', '19-025451927-1', 'CO-TERMINUS', '9300188546', NULL, NULL, NULL, '2016-06-06', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(307, 3495, 'pic1.png', 'APL3495', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ANGELO', 'PERMANO', 'LOPEZ', 'Filipino', '1995-11-15', 'M', 'Bicutan', NULL, 'Single', NULL, '62B Eucalyptus St. Western Bicutan Taguig City', NULL, NULL, NULL, NULL, NULL, NULL, '1211-6371-3379', '34-4319802-6', '02051158-6179', 'CO-TERMINUS', '09308889771', NULL, NULL, 'angelolopez06@yahoo.com', '2016-06-06', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(308, 3507, 'pic1.png', 'NA3507', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'NATHANIEL', NULL, 'ABAYA', 'Filipino', '1994-11-26', 'M', 'Makati City', NULL, 'Single', NULL, '#044 -A Kalayaan Ave. Brgy Pitogo Makati City', NULL, NULL, NULL, NULL, NULL, NULL, '1211-7555-9767', '34-4190262-5', '01-200154556-4', 'REGULAR', '9058591635', NULL, NULL, 'lyleadernath@gmail.com', '2016-07-11', NULL, 0, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(309, 3514, 'pic1.png', 'RVI3514', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RHONIE', 'VALDEZ', 'ISIT', 'Filipino', '1990-09-05', 'M', 'Urdaneta, Pangasinan', NULL, 'Single', NULL, '24 Sgt. Bumatay, Mandaluyong City', NULL, NULL, NULL, NULL, NULL, NULL, '1211-3105-2504', '34-4835616-4', '02-051104233-0', 'CO-TERMINUS', '9434301431', NULL, NULL, 'rhonie.isit5@gmail.com', '2016-07-25', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(310, 3525, 'pic1.png', 'JBB3525', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JOVEN', 'BOLIMA', 'BORDEOS', 'Filipino', '1992-01-15', 'M', 'Tabaco, City', NULL, 'Single', NULL, '#50 Mt. Makiling St. Palar Vill, Pinagsama, Taguig City', NULL, NULL, NULL, NULL, NULL, NULL, '1211-08673278', '05-1121345-4', '02-051029357-7', 'CO-TERMINUS', '9305113162', NULL, NULL, 'jov.bordeos011592@gmail.com', '2016-08-25', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(311, 3530, 'pic1.png', 'JCT3530', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JEREMY', 'CHUA', 'TAN', 'Filipino', '1979-11-22', 'M', 'Manila', NULL, 'Single', NULL, '35 Big Horseshoe village, Quezon City', NULL, NULL, NULL, NULL, NULL, NULL, '1211-8090-4674', '33-8572448-0', '01-025989477-3', 'REGULAR', '9052378778', NULL, NULL, 'jeremyctan@yahoo.com', '2016-09-05', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(312, 3539, 'pic2.png', 'APS3539', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ABEGAIL', 'PASCION', 'SUGUITAN', 'Filipino', '1991-12-21', 'F', 'La Union', NULL, 'Single', NULL, '#32 M. Flores St. Bagong Ilog, Pasig City', NULL, NULL, NULL, NULL, NULL, NULL, '9142-5925-7219', '01-2332975-2', '04-050171514-1', 'CO-TERMINUS', '9359660694', NULL, NULL, 'ap.suguitan@yahoo.com', '2016-09-21', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(313, 3544, 'pic2.png', 'KPB3544', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'KATHERINE', 'PANGILINAN', 'BAGTANG', 'Filipino', '1992-09-06', 'F', 'Quezon City', NULL, 'Single', NULL, 'Unit 2B Dr. Pilapil St. Sagad Pasig City', NULL, NULL, NULL, NULL, NULL, NULL, '1211-5940-0120', '34-4002556-1', '03-051112793-5', 'CO-TERMINUS', '9058052211', NULL, NULL, 'kathbagtang@yahoo.com', '2016-10-04', NULL, 9, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(314, 3545, 'pic1.png', 'GRM3545', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'GREG JAKE', 'RODRIGUEZ', 'MIA', 'Filipino', '1986-03-04', 'M', 'Sta. Cruz, Laguna', NULL, 'Married', NULL, '497 Fellowship St. Perpetual Village 5, Bacoor Cavite', NULL, NULL, NULL, NULL, NULL, NULL, '1210-3763-9353', '34-0203755-5', '08-025420915-9', 'CO-TERMINUS', '9157812389', NULL, NULL, 'gregmia07@yahoo.com', '2016-10-04', NULL, 69, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(315, 3548, 'pic1.png', 'MCB3548', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MAHER', 'CHANTENGCO', 'BERNABE', 'Filipino', '1993-01-23', 'M', 'Subic, Zambales', NULL, 'Single', NULL, '#660 M. Lerma St. Sotto Mayor Camp. Brgy Old Zaniga Mandaluyong City', NULL, NULL, NULL, NULL, NULL, NULL, '1211-4336-4120', '02-3821499-8', '0705-0960-1796', 'CO-TERMINUS', '9468663724', NULL, NULL, 'leemantiae23@gmail.com, engineer.bernabe@gmail.com', '2016-10-10', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(316, 3559, 'pic1.png', 'RRT3559', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ROBERTO', 'RODRIGUEZ', 'TERCERO', 'Filipino', '1973-04-29', 'M', 'Camarines Sur', NULL, 'Married', NULL, '259 Duhat Ext Napico, Pasig City', NULL, NULL, NULL, NULL, NULL, NULL, '1210-1992-1832', '05-0443585-4', '1905-1798-3342', 'CO-TERMINUS', '9303689941', NULL, NULL, 'terceroroberto@yahoo.com', '2016-11-18', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(317, 3566, 'pic2.png', 'SMP3566', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'SHARMAINE', 'MADRIDEO', 'PEÑEDA', 'Filipino', '1993-11-10', 'F', 'Manila', NULL, 'Single', NULL, '1888 New antipolo St. Sta Cruz, manila', NULL, NULL, NULL, NULL, NULL, NULL, '1210-0257-', '34-3127000-8', '0202-5712-4844', 'REGULAR', '9177471024', NULL, NULL, 'sharmainepeneda@yahoo.com', '2017-02-07', NULL, 0, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(318, 3568, 'pic1.png', 'ELE3568', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'EDWARD', 'LAMZON', 'EMBERGA', 'Filipino', '1985-03-02', 'M', 'Quezon City', NULL, 'Single', NULL, '187 Ranger St. Purok 1 A New Lower Bicutan, taguig City', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '33-9004973-6', '0102-5493-4211', 'CO-TERMINUS', '9173458916', NULL, NULL, 'edward.emberga@gmail.com', '2017-01-20', NULL, 17, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(319, 3571, 'pic2.png', 'SAP3571', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'SHARON JOYCE', 'ARANDA', 'PINEDA', 'Filipino', '1981-03-29', 'F', 'Manila', NULL, 'Married', NULL, '21B E. Jacinto St. Malinao,  Pasig', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0227-7429', '33-8369269-5', '1909-0199-9892', 'REGULAR', '9776457599', NULL, NULL, 'sja_pineda@yahoo.com', '2017-02-01', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(320, 3577, 'pic1.png', 'PKC3577', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'PAUL JR', 'KHO', 'CHUA', 'Chinese', '1971-09-22', 'M', 'MANILA', NULL, 'Single', NULL, '567 Ilang Ilang St. Binondo, Manila', NULL, NULL, NULL, NULL, NULL, NULL, '0008-0012-3002', '33-1769957-0', '1905-2383-3115', 'REGULAR', '9178394061', NULL, NULL, 'paulchua2@gmail.com', '2017-02-21', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(321, 3578, 'pic1.png', 'BMM3578', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'BERNIE ROSS', 'MARTIN', 'MANANSALA', 'Filipino', '1993-11-24', 'M', 'Caloocan ', NULL, 'Single', NULL, 'B16 L7 Torcillo St. Dagat Dagatan Caloocan City', NULL, NULL, NULL, NULL, NULL, NULL, '1211-9274-5558', '34-6562974-8', '0202-6858-9717', 'CO-TERMINUS', '9352750949', NULL, NULL, 'manansalabernie@gmail.com', '2017-02-20', NULL, 66, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(322, 3583, 'pic1.png', 'KSC3583', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'KIM CARLO', 'SANGALIA', 'CRISOSTOMO', 'Filipino', '1995-08-24', 'M', 'Navotas City', NULL, 'Single', NULL, '13A Santiago St. Navotas City', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '24-5305506-5', '0105-2070-2186', 'REGULAR', '9174779811', NULL, NULL, 'kimcarlocrisostomo24@yahoo.com', '2017-03-07', NULL, 13, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(323, 3584, 'pic1.png', 'UAU3584', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ULYSSES', 'ARSENIA', 'UMADHAY', 'Filipino', '1972-08-01', 'M', 'Caloocan ', NULL, 'Married', NULL, '11D Balagtas St. Purok 7 Lower Bicutan Taguig City', NULL, NULL, NULL, NULL, NULL, NULL, '1010-0024-4557', '33-3299825-6', '1920-0684-8091', 'CO-TERMINUS', '9974289866', NULL, NULL, 'umadhayulysses@gmail.com', '2017-03-08', NULL, 17, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(324, 3586, 'pic1.png', 'JME3586', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JOHN VINCENT', 'MACALTAO', 'EDEJER', 'Filipino', '1996-06-30', 'M', 'Zambales', NULL, 'Single', NULL, '9709 Kamagong St. San Antonio village, Makati City', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '02-3986711-1', '5050-298-5024', 'REGULAR', '9158827899', NULL, NULL, 'edejerjohnvincent@gmail.com', '2017-03-22', NULL, 46, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(325, 3588, 'pic2.png', 'ASD3588', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ALEXIS JILLAINE', 'SARIO', 'DEL VALLE', 'Filipino', '1996-05-28', 'F', 'Cavite', NULL, 'Single', NULL, 'B1 L47 C Garden Valley Subdivision Molino III, Bacoor Cabite', NULL, NULL, NULL, NULL, NULL, NULL, '1211-2765-6689', '34-4758585-5', '0802-5832-6141', 'CO-TERMINUS', '9365481461', NULL, NULL, 'jillainealexisdelvalle@gmail.com', '2017-03-22', NULL, 65, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(326, 3598, 'pic1.png', 'VAT3598', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'VIRGIL EMILSON', 'ALCAUSIN', 'TABUGADIR', 'Filipino', '1993-10-13', 'M', 'Manila', NULL, 'Single', NULL, 'L60 B4 Andover St. Vermont Park, Antipolo City', NULL, NULL, NULL, NULL, NULL, NULL, '9153-0999-3051', '34-5476536-7', '0102-5864-9325', 'CO-TERMINUS', '9771391873', NULL, NULL, 'emilson.tabugadir@hotmail.com', '2017-05-08', NULL, 0, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(327, 3603, 'pic1.png', 'EDC3603', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'EIVIN ROBERT', 'DAVID', 'CRUZ', 'Filipino', '1987-06-20', 'M', 'Manila', NULL, 'Single', NULL, 'Cluster 5 Unit 3-J U.N Gardens Condominium Cristobal St. Paco, Manila', NULL, NULL, NULL, NULL, NULL, NULL, '1211-0650-3556', '34-1125581-0', '0105-1056-2661', 'CO-TERMINUS', '9192975041', NULL, NULL, 'nivie20@yahoo.com', '2017-05-29', NULL, 17, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(328, 3605, 'pic1.png', 'MAF3605', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MICHAEL', 'ABILA', 'FOLLOSO', 'Filipino', '1986-06-18', 'M', 'Bato, Camarines', NULL, 'Married', NULL, 'Diego Silang Village Brgy Ususan Taguig City', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '34-3499180-5', '0102-5461-7909', 'CO-TERMINUS', '9054456634', NULL, NULL, 'michaelfolloso18@gmail.com', '2017-06-01', NULL, 69, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(329, 3609, 'pic2.png', 'KAG3609', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'KHRISTINE ', 'ALMANO', 'GUMAPAC', 'Filipino', '1995-08-02', 'F', 'Binan, Laguna', NULL, 'Single', NULL, '0018 Mabini St. Dela Paz Binan Laguna', NULL, NULL, NULL, NULL, NULL, NULL, '1211-0298-9466', '04-2807823-2', '0802-5604-5064', 'CO-TERMINUS', '9367783912', NULL, NULL, 'kristinealmano@yahoo.com', '2017-06-16', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(330, 3611, 'pic1.png', 'JNP3611', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JAYMAR', 'NICOLAS', 'PANOPIO', 'Filipino', '1990-06-05', 'M', 'Batangas', NULL, 'Married', NULL, '29 Cebu St. Pael Subd. Brgy, Culiat, Quezon City', NULL, NULL, NULL, NULL, NULL, NULL, '1211-6673-8944', '04-2210243-4', '0820-1075-9702', 'CO-TERMINUS', '09083392483/09278742187', NULL, NULL, 'jpanopio05@gmail.com', '2017-06-21', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(331, 3617, 'pic2.png', 'ASD3617', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ARMAINE ERIKA', 'SANTOS', 'DATA', 'Filipino', '1995-05-04', 'F', 'Manila', NULL, 'Single', NULL, '53 K-6th St. Kamuning, Quezon City', NULL, NULL, NULL, NULL, NULL, NULL, '1211-0090-4994', '34-3775876-0', '0105-1595-6706', 'CO-TERMINUS', '9173852951', NULL, NULL, 'armaineerika.data@gmail.com', '2017-07-01', NULL, 9, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(332, 3618, 'pic1.png', 'BDV3618', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'BRYANT', 'DELMACION', 'VILLA ', 'Filipino', '1992-01-10', 'M', 'Manila', NULL, 'Married', NULL, '129 Rizal Avenue Brgy 5 Lucban, Quezon', NULL, NULL, NULL, NULL, NULL, NULL, '1211-3243-2462', '04-3227671-6', '0802-5862-6412', 'CO-TERMINUS', '9951261823', NULL, NULL, 'bryant_villa@yahoo.com', '2017-08-07', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(333, 3622, 'pic1.png', 'ATB3622', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'AMANCIO', 'TUBALLA', 'BAJADO', 'Filipino', '1991-09-26', 'M', 'Negros Oriental', NULL, 'Single', NULL, '9 Casoy St. Blk 37, Addition Hills, Mandaluyong City', NULL, NULL, NULL, NULL, NULL, NULL, '1211-1466-6725', '34-2730007-6', '0302-5511-9326', 'CO-TERMINUS', '9174529940', NULL, NULL, 'cio.bajado@gmail.com', '2017-08-30', NULL, 17, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(334, 3627, 'pic2.png', 'AEM3627', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'APRIL LYN', 'ESTELLERO', 'MENDOZA', 'Filipino', '1981-06-02', 'F', 'Marikina', NULL, 'Single', NULL, 'B5 L17 Phase 1 Greenbrier Village San Mateo Rizal', NULL, NULL, NULL, NULL, NULL, NULL, '1080-0163-8610', '33-7456034-1', '1900-0822-1719', 'CO-TERMINUS', '09369422451', NULL, NULL, 'aprillynmendoza31@gmail.com', '2017-09-21', NULL, 7, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(335, 3633, 'pic2.png', 'MGA3633', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MARIA THERESA', 'GUINTO', 'ABRIO', 'Filipino', '1984-03-12', 'F', 'Manila', NULL, 'Married', NULL, '1655 Yakal St. Sta Cruz, Manila', NULL, NULL, NULL, NULL, NULL, NULL, '0039-7326-7511', '33-8958607-7', '0305-0179-4380', 'PROBATIONARY', '9106890852', NULL, NULL, 'theresaabrio@yahoo.com', '2017-10-17', NULL, 8, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(336, 3638, 'pic2.png', 'SFT3638', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'SOLEDAD', 'FERNANDEZ', 'TUGANO', 'Filipino', '1962-08-15', 'F', 'Manila', NULL, 'Single', NULL, '#60 Gitna St. Brgy Apolonio, Samson, Quezon City', NULL, NULL, NULL, NULL, NULL, NULL, '1210-2281-3560', '03-6959760-2', '1905-2381-6334', 'PROBATIONARY', '9157411601', NULL, NULL, 'tuganomaria.soledad@yahoo.com', '2017-10-24', NULL, 8, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(337, 3639, 'pic1.png', 'KST3639', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'KHAREEM', 'SANTIAGO', 'TABUGARA', 'Filipino', '1987-10-19', 'M', 'Pasay City', NULL, 'Single', NULL, '2019-A Aurora St. Pasay City', NULL, NULL, NULL, NULL, NULL, NULL, '1212-1184-1898', '34-5020586-3', '0102-6207-6240', 'PROBATIONARY', '9153113106', NULL, NULL, 'khareemtabugara@yahoo.com', '2017-10-25', NULL, 63, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(338, 3640, 'pic1.png', 'JFB3640', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JOHN PAUL', 'FORMENTO', 'BRIONES', 'Filipino', '1995-09-02', 'M', 'Manila', NULL, 'Single', NULL, '502 Purdue St. South Pointe Town Homes, Brgy. Merville, Parañaque City', NULL, NULL, NULL, NULL, NULL, NULL, '9172911260597', '34-7146126-2', '0102-6207-3098', 'PROBATIONARY', '9361726043', NULL, NULL, 'john_paul_briones02@yahoo.com', '2017-10-24', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(339, 3643, 'pic1.png', 'JVM3643', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JOHN SHELITO', 'VALEROS', 'MIRANDA', 'Filipino', '1994-05-19', 'M', 'Taguig City', NULL, 'Single', NULL, '#65 Jr. Soriano Compound San Guillermo St. Putatan Muntinlupa City', NULL, NULL, NULL, NULL, NULL, NULL, '1211-7494-5397', '34-6065170-8', '0102-5977-0233', 'CO-TERMINUS', '9061982786', NULL, NULL, 'johnshelitomiranda@gmail.com', '2017-11-27', NULL, 17, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(340, 3644, 'pic2.png', 'CCF3644', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'CHESKA ANNA', 'CORPUZ', 'FRANCO', 'Filipino', '1994-07-08', 'F', 'Tondo, Manila', NULL, 'Single', NULL, 'Blk 13 Lot 23 Marianas St. Emerald Crest Village, Brgy San Jose, Dasmarinas, Cavite', NULL, NULL, NULL, NULL, NULL, NULL, '1211-5014-7730', '04-3556741-9', '0802-5996-2971', 'PROBATIONARY', '9369390481', NULL, NULL, 'cheskaannafranco@ymail.com', '2017-11-20', NULL, 63, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(341, 3649, 'pic1.png', 'CMM3649', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'CHARLIE DEAN', 'MAGSIPOC', 'MANUEL', 'Filipino', '1994-10-30', 'M', 'Manila', NULL, 'Single', NULL, 'Lot 12 Blk 29 Bagong Silang 3 queens row area J, queens row west, Bacoor Cavite', NULL, NULL, NULL, NULL, NULL, NULL, '1211-5332-1191', '34-5297453-2', '0205-1154-6592', 'CO-TERMINUS', '9157960709', NULL, NULL, 'manuelcharliedean@gmail.com', '2018-01-25', NULL, 17, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(342, 3650, 'pic1.png', 'JAD3650', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JULIUS', 'AVILA', 'DA', 'Filipino', '1978-12-14', 'M', 'Manila', NULL, 'Single', NULL, '251 Sto Rosario St. Brgy Holy Spirit, Quezon City', NULL, NULL, NULL, NULL, NULL, NULL, '1210-9540-6895', '33-4751468-3', '0305-1145-1449', 'CO-TERMINUS', '9567312663', NULL, NULL, 'juliusavilada@gmail.com', '2018-01-08', NULL, 42, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(343, 3652, 'pic1.png', 'DAG3652', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'DENNIS', 'AREVALO', 'GUTIERREZ', 'Filipino', '1984-03-11', 'M', 'Paranaque City', NULL, 'Married', NULL, 'Unit B-2735 P. Villanueva St. Pasay City', NULL, NULL, NULL, NULL, NULL, NULL, '1211-0304-2334', '33-7973556-6', '0102-5420-2113', 'CO-TERMINUS', '9166344584', NULL, NULL, 'denz.gutierrez@gmail.com', '2017-12-18', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(344, 3655, 'pic2.png', 'HAO3655', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'HANNAH', 'AGRAVIADOR', 'OPELARIO', 'Filipino', '1969-08-16', 'F', 'Kabankalan City', NULL, 'Single', NULL, 'Unit 2D 401 Lafayette Bldg. Cluster 2, Chateau Elysee Paranaque City', NULL, NULL, NULL, NULL, NULL, NULL, '1210-3768-4950', '07-1445154-7', '1902-6220-8161', 'PROBATIONARY', '9162476782', NULL, NULL, 'luk4han_agrav@yahoo.com', '2018-01-24', NULL, 8, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(345, 3660, 'pic1.png', 'RCM3660', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RODEL', 'CABANGON', 'MARVIDA', 'Filipino', '1968-05-03', 'M', 'Quezon', NULL, 'Married', NULL, '3225 Manga Ave. Resetlement Area Kalawaan Pasig City', NULL, NULL, NULL, NULL, NULL, NULL, '1210-0167-4049', '03-8872946-9', '1908-9217-8082', 'CO-TERMINUS', '9215405896', NULL, NULL, 'eamfco90@gmail.com', '2018-02-01', NULL, 48, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(346, 3661, 'pic1.png', 'IAG3661', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ISMAEL JR.', 'AMARILLE', 'GASANG', 'Filipino', '1988-11-29', 'M', 'Quezon City', NULL, 'Single', NULL, '75 Sto. Domingo St. Brgy Holy Spirit, Quezon ', NULL, NULL, NULL, NULL, NULL, NULL, '1211-0927-4637', '34-0371335-7', '0305-1066-8967', 'CO-TERMINUS', '9323170077', NULL, NULL, 'jvallentine17@gmail.com', '2018-02-12', NULL, 42, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(347, 3663, 'pic1.png', 'JCL3663', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JESSIE', 'CASABON', 'LUMBANG', 'Filipino', '1979-08-23', 'M', 'MAKATI', NULL, 'Single', NULL, '6446 Camia St. Guadalupe Viejo, Makati City', NULL, NULL, NULL, NULL, NULL, NULL, '1210-7022-6510', '33-6290891-5', '1920-1000-9622', 'CO-TERMINUS', '9566513009', NULL, NULL, 'lumbangjessie@gmail.com', '2018-03-05', NULL, 42, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(348, 3667, 'pic1.png', 'EMT3667', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ELMAR', 'MENDOZA', 'TAMPIL', 'Filipino', '1993-08-22', 'M', 'Valenzuela', NULL, 'Single', NULL, 'Blk 6 Lot 8 Rosemont Ville Macabling Sta. Rosa City', NULL, NULL, NULL, NULL, NULL, NULL, '1211-3633-0296', '34-4823438-3', '0102-5726-4519', 'CO-TERMINUS', '9778446969', NULL, NULL, 'elmartampil@yahoo.com', '2018-03-19', NULL, 22, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(349, 3670, 'pic1.png', 'MPC3670', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MARK DANIEL', 'PILI', 'CRISOSTOMO', 'Filipino', '1994-08-23', 'M', 'Camarines Sur', NULL, 'Single', NULL, '1614 16th Floor Kassel Condominium, Taft Ave, Malate Manila', NULL, NULL, NULL, NULL, NULL, NULL, '1211-8772-5254', '05-1351988-4', '1025-1322-8004', 'PROBATIONARY', '09567203761 / (054) 8811070', NULL, NULL, 'cris.mdaniel@yahoo.com', '2018-04-03', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(350, 3671, 'pic2.png', 'MCB3671', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MONIQUE', 'CABANOS', 'BADONG', 'Filipino', '1993-05-05', 'F', 'Camarines Sur', NULL, 'Single', NULL, '#3 Herbs St, Zone 6, Brgy South Signal Village, Taguig City', NULL, NULL, NULL, NULL, NULL, NULL, '1211-2247-4194', '34-4483370-4', '0102-5642-8615', 'PROBATIONARY', '09266727921', NULL, NULL, 'moniquebadz@yahoo.com', '2018-04-03', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(351, 3674, 'pic2.png', 'JR3674', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JUDY ANNE PEARL', NULL, 'RELATOR', 'Filipino', '1996-06-11', 'F', 'Manila', NULL, 'Single', NULL, '1415-C Ilang-ilang St, Pandacan, Manila', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '34-5680776-0', '0202-6656-6426', 'PROBATIONARY', '09062434072', NULL, NULL, 'judyannefighting@gmail.com', '2018-04-23', NULL, 65, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(352, 3675, 'pic1.png', 'JNA3675', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JEROME', 'NOMBRADO', 'ABANGAN', 'Filipino', '1986-05-05', 'M', 'Caloocan City', NULL, 'Married', NULL, '002 Kilyawan St, Brgy Sta. Monica, Novaliches, Quezon City', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '34-3383013-2', '0302-6261-0760', 'CO-TERMINUS', '09463963727', NULL, NULL, 'jerome_abanggan@yahoo.com', '2018-04-27', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(353, 3676, 'pic1.png', 'JDM3676', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JOHN RAY', 'DELA TORRE', 'MARTIREZ', 'Filipino', '1992-12-06', 'M', 'General Nakar, Quezon', NULL, 'Single', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1212-0063-8351', '34-6774557-8', '0825-2165-7487', 'CO-TERMINUS', NULL, NULL, NULL, NULL, '2018-05-02', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(354, 3680, 'pic1.png', 'RLL3680', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RICARDO', 'LIGUTOM', 'LAYAGUE', 'Filipino', '1991-05-29', 'M', 'Mandaluyong City', NULL, 'Married', NULL, '1634 Camino Dela Fe St, Brgy Guadalupe Nuevo, Makati City', NULL, NULL, NULL, NULL, NULL, NULL, '121112052897', '3443901828', '010255946833', 'PROBATIONARY', '09565668702', NULL, NULL, 'rlayague.kingdominic@gmail.com', '2018-06-01', NULL, 0, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(355, 3682, 'pic2.png', 'DCS3682', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'DONALYN', 'CITRON', 'SARMIENTO', 'Filipino', '1997-05-14', 'F', 'LIPA CITY', NULL, 'Single', NULL, '1019 P. Campa St. Sampaloc, Manila', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0439176068', '082522096748', 'PROBATIONARY', NULL, NULL, NULL, 'donalynsarmiento@yahoo.com', '2018-06-06', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(356, 3683, 'pic2.png', 'WAL3683', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'WYLENE', 'ANTOLIN', 'LEGASPI', 'Filipino', '1980-10-10', 'F', 'Las Piñas City', NULL, 'Single', NULL, 'Blk 9 Lot 5 Minesview Park St., Teresa Park Subd, Las Pinas City', NULL, NULL, NULL, NULL, NULL, NULL, '101002972244', '3383006032', '010505229687', 'PROBATIONARY', '09151798796', NULL, NULL, 'wylenelegaspi@gmail.com', '2018-06-25', NULL, 13, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(357, 3684, 'pic1.png', 'AAA3684', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ANGELO', 'ARCELLANA', 'ANGELES', 'Filipino', '1964-07-24', 'M', 'Manila', NULL, 'Married', NULL, '7344 Orchard St, Ph 9 Marcelo Green Village, Paranaque City', NULL, NULL, NULL, NULL, NULL, NULL, '000204096604', '0383981574', '030502869333', 'PROBATIONARY', '09062627257', NULL, NULL, 'angelo_angeles2007@yahoo.com', '2018-06-25', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(358, 3687, 'pic2.png', 'EPC3687', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'EUNICE', 'PASCUAL', 'CABILING', 'Filipino', '1996-01-07', 'F', 'QUIAPO, MANILA', NULL, 'Single', NULL, '301 INT. 15 AGUADO ST. SAN MIGUEL, MANILA', NULL, NULL, NULL, NULL, NULL, NULL, '121108917884', '3443080969', '020261267366', 'PROBATIONARY', '09353932347', NULL, NULL, 'nicecabiling@gmail.com', '2018-12-18', NULL, 51, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(359, 3688, 'pic1.png', 'MSJ3688', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MICHAEL ANGELO', 'SANTOS', 'JAMIG', 'Filipino', '1987-03-31', 'M', 'Pasay City', NULL, 'Single', NULL, 'LOT 6 BLK 2 PH 2 PANTRANCO COMPOUND, PASONG TAMO, QUEZON CITY', NULL, NULL, NULL, NULL, NULL, NULL, '121005709450', '3397601779', '030501959983', 'PROBATIONARY', '09176445614', NULL, NULL, NULL, '2018-07-11', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(360, 3689, 'pic2.png', 'AAO3689', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ALGIE', 'ALTURA', 'ORNIDO', 'Filipino', '1979-04-10', 'F', 'FLORIDA BLANCA, PAMPANGA', NULL, 'Married', NULL, 'P 113c 17th 2nd St. Villamor Air Base, Pasay city', NULL, NULL, NULL, NULL, NULL, NULL, '121049981189', '3367756052', '190894524158', 'PROBATIONARY', '09198825498', NULL, NULL, 'gietxt2003@yahoo.com', '2018-07-16', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(361, 3690, 'pic2.png', 'SIM3690', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'SHERYLL', 'IBAYAN', 'MIRASOL', 'Filipino', '1983-10-18', 'F', 'Manila', NULL, 'Single', NULL, '35 Waling- Waling St. Roxas District Quezon City', NULL, NULL, NULL, NULL, NULL, NULL, '121064614340', '3418503727', '030251375662', 'PROBATIONARY', '09954924522', NULL, NULL, 'sheryllmirasol@yahoo.com', '2018-07-23', NULL, 0, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(362, 3691, 'pic2.png', 'JHM3691', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JONALYN', 'HABOC', 'MAGUNDAYAO', 'Filipino', '1993-05-13', 'F', 'Manila', NULL, 'Single', NULL, '2826 Luzviminda St. CAA Las Piñas City', NULL, NULL, NULL, NULL, NULL, NULL, '121016667031', '3426632237', '020508146303', 'PROBATIONARY', '09266791218', NULL, NULL, 'jonalyn_magundayao@yahoo.com', '2018-08-28', NULL, 0, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(363, 3693, 'pic1.png', 'BMG3693', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'BRIAN EDWARD', 'MAPUA', 'GONZALES', 'Filipino', '1987-07-15', 'M', 'Manila', NULL, 'Married', NULL, '20 Reparo St. Morning Breeze Subd. Caloocan City', NULL, NULL, NULL, NULL, NULL, NULL, '911298065546', '3421478483', '1105 04913562', 'CO-TERMINUS', '09453976695', NULL, NULL, 'edwardgonzales.ph@gmail.com', '2018-08-06', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(364, 3694, 'pic2.png', 'LGV3694', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'LOVELY', 'GAYNILO', 'VILLANUEVA', 'Filipino', '1991-08-27', 'F', 'Cavite', NULL, 'Single', NULL, '70 Batunan Sampaloc 4, Dasmariñas, Cavite', NULL, NULL, NULL, NULL, NULL, NULL, '121067122002', '3426075234', '020509203947', 'CO-TERMINUS', '09956280655/09457456662', NULL, NULL, 'loveaveunalliv@yahoo.com/ lvillanueva.epmc@gmail.com', '2018-08-28', NULL, 13, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(365, 3700, 'pic1.png', 'ENF3700', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'EDWARD JOSEPH', 'NAVARROZA', 'FRANCIA', 'Filipino', '1994-04-19', 'M', 'Sipocot, Camariñez Sur', NULL, 'Single', NULL, 'Blk 32 Lot 10, Carissa 4A, Brgy. Kaypian, San Jose Del Monte, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, '121180131386', '3435557798', '220000761869', 'CO-TERMINUS', '09959249264', NULL, NULL, 'franciaej19@gmail.com', '2018-09-24', NULL, 0, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(366, 3705, 'pic1.png', 'F S3705', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'FRANCIS', ' PAZ', 'SANTIAGO', 'Filipino', '1978-11-20', 'M', 'Marikina', NULL, 'Married', NULL, '50 Narra St. Marikina Heights, Marikina City', NULL, NULL, NULL, NULL, NULL, NULL, '108002612634', '3364821362', '070503922078', 'REGULAR', '09283741572/09063591228', NULL, NULL, 'engrsantiago@gmail.com', '2018-10-24', NULL, 60, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(367, 3706, 'pic2.png', 'RSU3706', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RHODA', 'SOMBRERO', 'UMANDAP', 'Filipino', '1986-11-23', 'F', 'Pasig City', NULL, 'Single', NULL, 'Brgy. Fort Bonifacio Gate 3, Taguig City', NULL, NULL, NULL, NULL, NULL, NULL, '106001971897', '3405332532', '080507034822', 'REGULAR', '09959117844', NULL, NULL, 'rsumandap@yahoo.com', '2018-11-12', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(368, 3707, 'pic1.png', 'JDC3707', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JONATHAN ISHMAEL', 'DOMINGO', 'CRUZ', 'Filipino', '1993-02-17', 'M', 'Parañaque', NULL, 'Single', NULL, '399 A M.L. Quezon St. Lower Bicutan, Taguig City', NULL, NULL, NULL, NULL, NULL, NULL, '1212-3518-4972', '3428846694', '010263661767', 'CO-TERMINUS', '09060563720', NULL, NULL, 'jonathancruz549@yahoo.com', '2018-11-14', NULL, 69, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(369, 3708, 'pic2.png', 'MAM3708', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MARIELLE ANN', 'AGUILAR', 'MARTIN', 'Filipino', '1996-03-23', 'F', 'Batangas', NULL, 'Single', NULL, '3rdflr 24H City Hotel, 1406 Vito Cruz Ext. Cor., Balagtas St. Makati City', NULL, NULL, NULL, NULL, NULL, NULL, '121238086244', '3479812046', '092020595320', 'REGULAR', '09759772868', NULL, NULL, 'marielleannmartin@gmail.com', '2018-11-16', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(370, 3710, 'pic2.png', 'AEN3710', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ANNIE', 'EBUENGA', 'NAVATO', 'Filipino', '1996-01-12', 'F', 'Navotas City', NULL, 'Single', NULL, '1282 Cocaoc Kasayaan St. Poblacion Bugallon, Pangasinan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3480517505', '022510551625', 'CO-TERMINUS', '09260017662', NULL, NULL, 'einna.otavan@gmail.com', '2018-11-19', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(371, 3713, 'pic1.png', 'REJ3713', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RONNIE', 'ESPINO', 'JARDIN', 'Filipino', '1989-05-19', 'M', 'Antique', NULL, 'Married', NULL, '2113 Simon St. Sampaloc Manila', NULL, NULL, NULL, NULL, NULL, NULL, '121088509794', '0727613534', '022069426309', 'PROBATIONARY', '09263895389', NULL, NULL, 'nylaer09@gmail.com', '2018-11-20', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(372, 3714, 'pic2.png', 'MHO3714', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MONIQUE', 'HERAMIA', 'ORIENZA', 'Filipino', '1974-08-12', 'F', 'Dagupan City', NULL, 'Single', NULL, '0029 Samson St. Brgy. Iba Meycauayan Bulacan ', NULL, NULL, NULL, NULL, NULL, NULL, '121010857420', '3346129891', '050250210644', 'PROBATIONARY', '09355976187/09478085930', NULL, NULL, 'mon.orienza@gmail.com', '2018-11-27', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(373, 3716, 'pic1.png', 'JML3716', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'J.V. NEL ', 'MIRAS', 'LUMANGLAS', 'Filipino', '1993-11-10', 'M', 'Quezon Province', NULL, 'Single', NULL, 'Unit 4 1508 G. Tuazon St. Sampaloc, Manila', NULL, NULL, NULL, NULL, NULL, NULL, '121172570826', '3459780017', '082522414308', 'CO-TERMINUS', '09167031936', NULL, NULL, 'jvlumanglas@gmail.com', '2018-12-11', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(374, 3717, 'pic1.png', 'RLM3717', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RHINE HART', 'LOBRIN', 'MONTERO', 'Filipino', '1980-09-26', 'M', 'Quezon City', NULL, 'Married', NULL, 'L9 B14 Everlasting St. Dolmar Golden Hills Llano Caloocan City', NULL, NULL, NULL, NULL, NULL, NULL, '107001067120', '3376847732', '190895961411', 'PROBATIONARY', '09238254071', NULL, NULL, 'rh1n3hartm0nt3r0@gmail.com', '2018-11-26', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(375, 3721, 'pic1.png', 'CLM3721', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'CHLOIE ANTHONY', 'LORA', 'MALONZO', 'Filipino', '1995-05-21', 'M', 'Taguig City', NULL, 'Single', NULL, 'Oila A Bweboz St. Ext. Rizal, Makati City', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3459117444', '010259511432', 'CO-TERMINUS', '09458131935', NULL, NULL, 'chloiemalonzo@gmail.com', '2018-12-11', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(376, 3723, 'pic1.png', 'JTM3723', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JEROME ', 'TAÑEZ', 'MACABINQUIL', 'Filipino', '1994-08-14', 'M', 'Quezon City ', NULL, 'Single', NULL, 'Blk. 4 Lot 1 Section 21 Phase 3 Pabahay 2000 Brgy. Muzon SJDM Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, '121240895400', '3479808584', '212506700644', 'PROBATIONARY', '09051801783', NULL, NULL, 'jerome.macabinquil@yahoo.com ', '2019-01-15', NULL, 71, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(377, 3724, 'pic2.png', 'RVV3724', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'REVELA LEARNIE ', 'VELASCO', 'VIDAL ', 'Filipino', '1994-06-28', 'F', 'Pangasinan', NULL, 'Single', NULL, 'Ibarra St. Brgy. 85 Pasay City, Manila ', NULL, NULL, NULL, NULL, NULL, NULL, '121151275030', '0238642638', '050255310140', 'PROBATIONARY', '09123823600', NULL, NULL, 'revela.vidal@gmail.com', '2019-01-15', NULL, 0, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(378, 3726, 'pic2.png', 'SAE3726', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'SHEAN MARIE ', 'ATENTA ', 'ESTANISLAO', 'Filipino', '1994-11-01', 'F', 'Butuan City ', NULL, 'Single', NULL, 'Barangay 434 Zone 44 District 4518 Valencia St. Sampaloc Manila ', NULL, NULL, NULL, NULL, NULL, NULL, '121127445628', '0825514920', '180252791238', 'CO-TERMINUS', '09483683743', NULL, NULL, 'sheanmarie@gmail.com', '2019-01-17', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(379, 3727, 'pic1.png', 'AHD3727', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ART JOHN ERROL ', 'HINDAP', 'DULDULAO', 'Filipino', '1996-12-18', 'M', 'Caloocan City ', NULL, 'Single', NULL, '2611 K Jesus St. Brgy. 836 Pandacan Manila ', NULL, NULL, NULL, NULL, NULL, NULL, '121238701099', '3472347974', '022501551884', 'PROBATIONARY', '09353534118', NULL, NULL, 'duldulao.errol18@gmail.com ', '2019-01-28', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(380, 3728, 'pic1.png', 'JVB3728', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JOSSEAROHI', 'VERGARA', 'BABON ', 'Filipino', '1992-04-10', 'M', 'Manila City', NULL, 'Single ', NULL, 'B1 L7 BTHOA Compound, Tomas Manuel Sub. Valenzuela City ', NULL, NULL, NULL, NULL, NULL, NULL, '121121930783', '3425732824', '020510752113', 'CO-TERMINUS', '09352659598', NULL, NULL, 'jossea.rohi@gmail.com', '2018-12-17', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(381, 3729, 'pic2.png', 'JTL3729', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JUDY ANN ', 'TIMBLACO ', 'LUNES ', 'Filipino', '1996-05-12', 'F', 'San Pedro Laguna ', NULL, 'Single ', NULL, '10th 17th St. Brgy. 183 Villamor Airbase Pasay City ', NULL, NULL, NULL, NULL, NULL, NULL, '121167180035', '3458112291', '080260913607', 'CO-TERMINUS', '09361767167', NULL, NULL, 'judyann.lunes@gmail.com', '2019-02-04', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(382, 3731, 'pic2.png', 'PCA3731', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'PRESCENTACION ', 'CRUZAT', 'ALVAREZ', 'Filipino', '1995-12-08', 'F', 'Quezon Province', NULL, 'Single', NULL, 'Summerbreeze II Sta. Maria Sto. Tomas Batngas', NULL, NULL, NULL, NULL, NULL, NULL, '121172404970', '0437372547', '082525100746', 'CO-TERMINUS', '09756977915', NULL, NULL, 'prescentacion.alvarez@yahoo.com', '2019-02-06', NULL, 5, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(383, 3733, 'pic1.png', 'MTU3733', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MICHAEL ADRIAN ', 'TY ', 'UY ', 'Filipino', '1982-07-20', 'M', 'Manila City', NULL, 'Married ', NULL, '18 PQ Future Point 3, III Panay Ave., South Triangle, Quezon City ', NULL, NULL, NULL, NULL, NULL, NULL, '107000985162', '3390519923', '090502896287', 'PROBATIONARY', '09177209972', NULL, NULL, 'mikeuy720@gmail.com ', '2019-02-18', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(384, 3734, 'pic2.png', 'JSP3734', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JEAN PAULINE ', 'SARONA ', 'PATRICIO', 'Filipino', '1998-11-01', 'F', 'Manila City', NULL, 'Single ', NULL, '409 F Pampanga St. Gagalangin Tondo, Manila ', NULL, NULL, NULL, NULL, NULL, NULL, '121243648239', '3449199595', '022500335053', 'PROBATIONARY', '09239982723', NULL, NULL, 'pauline_patricio23@yahoo.com ', '2019-02-18', NULL, 0, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(385, 3737, 'pic1.png', 'BPC3737', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'BERNARDITO', 'PINEDA', 'CUETA', 'Filipino', '1967-02-18', 'M', 'Manila City', NULL, 'Single', NULL, '3455 St. Ignatius St. Rockville, Tabang, Plaridel Bulacan ', NULL, NULL, NULL, NULL, NULL, NULL, '121003069467', '0394735531', '190887117059', 'CO-TERMINUS', '09058229755', NULL, NULL, 'bernicueta@yahoo.com ', '2019-03-07', NULL, 8, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(386, 3739, 'pic1.png', 'JLP3739', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JOVERT', 'LUCERO', 'PUNONGBAYAN', 'Filipino', '1993-09-15', 'M', 'Manila', NULL, 'Single', NULL, '1714 Diamante St. San Andres Bukid Manila ', NULL, NULL, NULL, NULL, NULL, NULL, '121155369079', '3454194585', '020265883878', 'CO-TERMINUS', '09953410005', NULL, NULL, 'punongbayan.jovert@gmail.com', '2019-03-18', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(387, 3740, 'pic1.png', 'OGP3740', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ORVEN HARRY ', 'GONZALVO', 'PANEM ', 'Filipino', '1985-07-25', 'M', 'Manila City', NULL, 'Married', NULL, 'Blk 6 Lot 6 Hawk St. Camella 2 Putatan Muntinlupa City ', NULL, NULL, NULL, NULL, NULL, NULL, '121159201904', '3408952472', '030504169444', 'PROBATIONARY', '09260098100', NULL, NULL, 'ohpanem@gmail.com', '2019-03-20', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(388, 3741, 'pic1.png', 'GSG3741', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'GARETT BRIAN ', 'SY', 'GO', 'Filipino', '1987-09-10', 'M', 'Manila City', NULL, 'Single', NULL, 'Unit 8-A Columbian International Tower 500 Santol St. Sta. Mesa ', NULL, NULL, NULL, NULL, NULL, NULL, '121225582823', '3474792734', '020258182937', 'PROBATIONARY', '09228131392', NULL, NULL, 'garettgo@gmail.com ', '2019-03-20', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(389, 3742, 'pic1.png', 'CAG3742', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'CARLO DEAN ', 'AGUADO', 'GUILLES', 'Filipino', '1989-11-25', 'M', 'Batangas ', NULL, 'Married', NULL, '23 Pisces St. Lourdes Village Brgy. Bolbok Batangas City ', NULL, NULL, NULL, NULL, NULL, NULL, '121038119265', '0425591521', '010514380584', 'PROBATIONARY', '09055295612', NULL, NULL, 'carlodeanguilles@gmail.com', '2019-03-21', NULL, 0, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(390, 3745, 'pic1.png', 'K D3745', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'KEITH ALBERT', ' PEÑAMORA', 'DRONA ', 'Filipino ', '1985-12-27', 'M', 'Laguna ', NULL, 'Married ', NULL, '#5 B Carnation St. Drj Village Savjo, Quezon City ', NULL, NULL, NULL, NULL, NULL, NULL, '121062287583', '0418677410', '080507056206', 'PROBATIONARY', '09053487009', NULL, NULL, 'keithdrona@gmail.com', '2019-03-28', NULL, 38, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(391, 3746, 'pic1.png', 'NUD3746', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'NICANOR JR. ', 'URBANO', 'DE CASTRO ', 'Filipino', '1995-09-11', 'M', 'Manila', NULL, 'Single', NULL, '1312 San Perfecto St. Galicia Sampaloc Manila ', NULL, NULL, NULL, NULL, NULL, NULL, '121226875390', '3476255460', '80515476052', 'PROBATIONARY', '09950812703', NULL, NULL, 'nickdecastro8@gmail.com ', '2019-04-01', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(392, 3748, 'pic1.png', 'EVP3748', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'EARL JOHN ', 'VILLACORTE', 'PATRICIO ', 'Filipino ', '1993-12-20', 'M', 'Tondo, Manila', NULL, 'Single', NULL, 'B16 L3 Flamingo St. Town and Country Village, Abangan Norte, Marilao Bulacan ', NULL, NULL, NULL, NULL, NULL, NULL, '121168092480', '0239406585', '030513142834', 'CO-TERMINUS', '09167820771', NULL, NULL, 'ejpatricio@gmail.com', '2019-04-30', NULL, 21, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(393, 3749, 'pic1.png', 'RCT3749', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RICKY FRANZ', 'CABALDE ', 'TEODOSIO', 'Filipino ', '1996-05-02', 'M', 'Quezon City ', NULL, 'Single', NULL, 'Road 8 SPI St. Purok 3 New Lower Bicutan Taguig City ', NULL, NULL, NULL, NULL, NULL, NULL, '121130001493', '3448061569', '010256870342', 'CO-TERMINUS', '09272396402', NULL, NULL, 'rikiprans@gmail.com', '2019-04-30', NULL, 21, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(394, 3750, 'pic2.png', 'JPR3750', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JEMALYN ', 'PANGAN ', 'ROSERO', 'Filipino ', '1989-09-24', 'F', 'Quezon City ', NULL, 'Married ', NULL, '#025 Jasmin St. Brgy. Batasan Hills, Quezon City ', NULL, NULL, NULL, NULL, NULL, NULL, '121135074231', '3423733142', '030509387547', 'CO-TERMINUS', '09322149149', NULL, NULL, 'jemalyn.rosero@gmail.com ', '2019-05-02', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(395, 3751, 'pic1.png', 'AMP3751', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ARIEL ', 'MANALILI', 'PANGAN ', 'Filpino', '1992-12-23', 'M', 'Lubao, Pampanga', NULL, 'Single ', NULL, 'Green Residences, Taft Avenue, Malate Manila ', NULL, NULL, NULL, NULL, NULL, NULL, '121159538987', '0237603681', '070509392801', 'CO-TERMINUS', '09664668240', NULL, NULL, 'pangan.ariel28@gmail.com ', '2019-05-06', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(396, 3752, 'pic1.png', 'BML3752', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'BAYANI JR. ', 'MANGI ', 'LOPEZ', 'Filipino ', '1984-01-29', 'M', 'Biñan, Laguna ', NULL, 'Married', NULL, '1853 Dian cor. Ampere St. Palanan Makati City ', NULL, NULL, NULL, NULL, NULL, NULL, '121188850381', '3398376362', '090502191216', 'PROBATIONARY', '09955776689', NULL, NULL, 'bjaylopez@yahoo.com.ph', '2019-05-07', NULL, 71, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12');
INSERT INTO `hris_employees` (`id`, `employee_number`, `employee_photo`, `username`, `password`, `firstname`, `middlename`, `lastname`, `nationality`, `birthday`, `gender`, `place_birth`, `dependant`, `marital_status`, `work_address`, `home_address`, `home_distance`, `emergency_contact`, `emergency_no`, `cert_level`, `field_study`, `school`, `pagibig`, `sss`, `phic`, `employment_status`, `work_no`, `work_phone`, `work_email`, `private_email`, `joined_date`, `termination_date`, `job_title_id`, `department_id`, `supervisor`, `pay_grade`, `role_id`, `last_login`, `status`, `created_at`, `updated_at`) VALUES
(397, 3753, 'pic2.png', 'RON3753', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ROCHELL', 'ORDONIO', 'NONO ', 'Filipino ', '1989-10-08', 'F', 'San Guillermo, Isabela ', NULL, 'Single ', NULL, '#38 Marigold St. Rivera Village Brgy. 200, Naia Road, Pasay City ', NULL, NULL, NULL, NULL, NULL, NULL, '121229696734', '0120827422', '060501365001', 'PROBATIONARY', '09352205929', NULL, NULL, 'nonorochell24@gmail.com ', '2019-05-09', NULL, 43, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(398, 3754, 'pic2.png', 'MFC3754', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MAY JEZIEL ', 'FERNANDEZ', 'CASTAÑEDA', 'Filipino', '1995-12-08', 'F', 'Basista, Pangasinan ', NULL, 'Single ', NULL, 'Unit 302 E61 Homes 2, Mola St. Makati City', NULL, NULL, NULL, NULL, NULL, NULL, '12119482682', '3473593264', '052510406303', 'PROBATIONARY', '09301804417', NULL, NULL, 'cjeziel09@gmail.com ', '2019-05-16', NULL, 62, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(399, 3756, 'pic1.png', 'JCY3756', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JONAS ', 'CAMPOS ', 'YIN ', 'Filipino', '1996-12-02', 'M', 'Caloocan ', NULL, 'Single', NULL, '46 Buklod ng Nayon Sangandaan Caloocan City ', NULL, NULL, NULL, NULL, NULL, NULL, '121250342451', '3484338133', '022504419030', 'CO-TERMINUS', '09427934297', NULL, NULL, 'yin.jonas@yahoo.com', '2019-05-29', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(400, 3757, 'pic1.png', 'ZRD3757', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ZACARIAS', 'ROXAS', 'DE CHAVEZ', 'Filipino', '1972-11-05', 'M', 'Tanauan, Batangas', NULL, 'Married', NULL, '67 Minahan Main Road Malanday Marikina City ', NULL, NULL, NULL, NULL, NULL, NULL, '101000215383', '3314013023', '190892089667', 'CO-TERMINUS', '09215762831', NULL, NULL, 'dechavezz@gmail.com', '2019-06-01', NULL, 48, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(401, 3758, 'pic1.png', 'FVC3758', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'FREDDERICK', 'VALERIO', 'CO BENG ', 'Filipino', '1969-02-13', 'M', 'Manila', NULL, 'Single', NULL, 'Zamboanga Lane 1J Reyes St. Karuhatan Valenzuela City', NULL, NULL, NULL, NULL, NULL, NULL, '121117233426', '3308794086', '010517285078', 'CO-TERMINUS', '09226830777', NULL, NULL, 'fredderick.cobeng@yahoo.com', '2019-06-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(402, 3761, 'pic2.png', 'YDB3761', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'YXABELLA BERNADYNE', 'DEL MAR ', 'BALUYOT', 'Filipino', '1996-11-14', 'F', 'Cebu City', NULL, 'Single ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '121230105302', '0241665259', '052517361437', 'PROBATIONARY', '09271447863', NULL, NULL, 'yxabellabaluyot@gmail.com', '2019-06-19', NULL, 8, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(403, 3762, 'pic2.png', 'KNC3762', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'KIMBERLY MAE', 'NOCILLADO', 'CRISOSTOMO', 'Filipino ', '1997-03-11', 'F', 'Dagupan City', NULL, 'Single', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '121252035039', '0241667257', '050257400686', 'PROBATIONARY', '09207237925', NULL, NULL, 'kimberly.mae.crisostomo@gmail.com', '2019-06-19', NULL, 8, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(404, 3763, 'pic1.png', 'JDY3763', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JEREMIAH DAVIDSON ', 'DAVID', 'YANSON', 'Filipino', '1993-03-17', 'M', 'Pasig City', NULL, 'Single', NULL, '#20 Duhat St. Summergreen Subd. Brgy. San Andres, Cainta Rizal ', NULL, NULL, NULL, NULL, NULL, NULL, '121143666509', '0731503915', '110254476218', 'PROBATIONARY', '09778155885', NULL, NULL, 'JDDYanson@gmail.com', '2019-06-18', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(405, 3764, 'pic1.png', 'HHB3764', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'HERWIN JOHN ', 'HERRERA', 'BAUTISTA', 'Filipino ', '1996-10-30', 'M', 'Caloocan City ', NULL, 'Single', NULL, 'Blk. 88 Lot 4 Kawal St. D. Dagatan Ext. Caloocan ', NULL, NULL, NULL, NULL, NULL, NULL, '121239743402', '3479484474', '022525834011', 'CO-TERMINUS', '09277083474', NULL, NULL, 'bherwinjohn@gmail.com', '2019-06-24', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(406, 3765, 'pic2.png', 'MCS3765', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MARY JOYCE', 'CRUZ', 'SAN PEDRO', 'Filipino ', '1995-01-17', 'F', 'Quezon City', NULL, 'Single', NULL, '741 C. Solis St. Tondo, Manila ', NULL, NULL, NULL, NULL, NULL, NULL, '121193424873', '3463374215', '020268152572', 'CO-TERMINUS', '09218626243', NULL, NULL, 'joycesp17@gmail.com', '2019-06-24', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(407, 3766, 'pic2.png', 'ERP3766', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ELMIE JEAN', 'RAPISTA', 'PANEDA', 'Filipino', '1995-06-24', 'F', 'Puerto Galera', NULL, 'Single', NULL, '7Q T3 Avida Towers San Lazaro, Sta. Cruz Manila ', NULL, NULL, NULL, NULL, NULL, NULL, '121255316163', '3485510905', '072505389256', 'CO-TERMINUS', '09555970440', NULL, NULL, 'elmiepaneda24@gmail.com', '2019-06-26', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(408, 3768, 'pic2.png', 'PMN3768', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'PRINCESS GENEVA', 'MAMARIL', 'NARCISO', 'Filipino', '1996-02-25', 'F', 'San Carlos, Pangasinan', NULL, 'Single ', NULL, '24H City Hotel P. Ocampo Cor. Balagtas St. Brgy. La Paz Makati City. ', NULL, NULL, NULL, NULL, NULL, NULL, '121227300381', '0244011648', '052520146644', 'PROBATIONARY', '09283928975', NULL, NULL, 'princessgeneva_narciso@yahoo.com ', '2019-07-08', NULL, 46, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(409, 3770, 'pic2.png', 'RRA3770', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ROCHELLE ', 'RUFO ', 'ARTAZO', 'Filipino ', '1996-06-22', 'F', 'Palawan ', NULL, 'Single ', NULL, 'Georgia St. Annex 40, Betterliving Subd. Parañaque City ', NULL, NULL, NULL, NULL, NULL, NULL, '121269124127', '34-85531670', '090256814462', 'CO-TERMINUS', '09468526945', NULL, NULL, 'rochelleartazo@gmail.com ', '2019-07-16', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(410, 3771, 'pic1.png', 'JLL3771', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JASPER ALLEN ', 'LIPANA ', 'LIZARDO ', 'Filipino ', '1996-07-15', 'M', 'Manila City', NULL, 'Single ', NULL, '138 Esguerra St. Brgy. 75 Caloocan City ', NULL, NULL, NULL, NULL, NULL, NULL, '121213456944', '3471922772', '022505552524', 'CO-TERMINUS', '09176260079', NULL, NULL, 'ja.lizardo011@gmail.com ', '2019-07-17', NULL, 21, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(411, 3772, 'pic2.png', 'JMZ3772', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JEM', 'MAYA ', 'ZAMORA ', 'Filipino ', '1991-12-20', 'F', 'Balanga, Bataan ', NULL, 'Single', NULL, 'Blk 18 Lot 27 Amethyst St. Verapaz Homes Brgy. Alas-asin, Mariveles Batan ', NULL, NULL, NULL, NULL, NULL, NULL, '121123050176', '0236600834', '070508200585', 'PROBATIONARY', '0917201220', NULL, NULL, 'jem.zamora@yahoo.com ', '2019-07-22', NULL, 0, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:12', '2020-08-24 02:18:12'),
(412, 3774, 'pic1.png', 'KDL3774', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'KEVIN', 'DEMAIN ', 'LEDESMA ', 'Filipino ', '1994-04-05', 'M', 'Manila City', NULL, 'Single ', NULL, 'P1 Blk. 15 Lot 18 Prism St. Sunrise Hills Subd. Brgy. Sabang Dasma City Cavite ', NULL, NULL, NULL, NULL, NULL, NULL, '121213185984', '3435258819', '012510393307', 'PROBATIONARY', '09185763259 / 09360637261', NULL, NULL, 'kevzleds@gmail.com ', '2019-07-23', NULL, 21, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(413, 3775, 'pic2.png', 'KFB3775', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'KRIZIA DANICE', 'FAJARDO ', 'BAMBA', 'Filipino', '1996-01-16', 'F', 'Manila City ', NULL, 'Single ', NULL, '86 Aramismis St. Brgy. Veterans Village Project 7, Quezon City ', NULL, NULL, NULL, NULL, NULL, NULL, '121255770580', '3486456097', '020272771864', 'PROBATIONARY', '09185964090', NULL, NULL, 'Kriziabamba0116@gmail.com', '2019-07-30', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(414, 3776, 'pic2.png', 'MSJ3776', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MARIMAR ', 'SARZADILLA', 'JUANATA ', 'Filipino ', '1997-08-13', 'F', 'Pangasinan', NULL, 'Single ', NULL, 'Blk. 14 Lot 13 Madrigal Compound Ilaya Las Piñas City', NULL, NULL, NULL, NULL, NULL, NULL, '121240036016', '3480472624', '010263941409', 'CO-TERMINUS', '09121137364', NULL, NULL, 'marimar_juanata@yahoo.com ', '2019-08-02', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(415, 3777, 'pic2.png', 'JLZ3777', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JANE ', 'LAJADA ', 'ZARCENO ', 'Filipino ', '1986-01-01', 'F', 'GMA Cavite', NULL, 'Married ', NULL, 'B4 L5 Aventine Crownasia Cayetano Ave. Ususan Taguig ', NULL, NULL, NULL, NULL, NULL, NULL, '001041053811', '3405715308', '010504909927', 'PROBATIONARY', '09989531593 / 09062188852', NULL, NULL, 'jhaneyzarceno16@gmail.com ', '2019-08-06', NULL, 60, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(416, 3778, 'pic1.png', 'PAM3778', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'PEPE', 'ABEL ', 'MANALO', 'Filipino', '1978-07-10', 'M', 'Oriental Mindoro', NULL, 'Married', NULL, 'Lot 4 Block 71 Road 11 Garnet St. Prok 3 New Lower Bicutan Taguig City', NULL, NULL, NULL, NULL, NULL, NULL, '121033319278', '3370464739', '190263502802', 'CO-TERMINUS', '09425263857', NULL, NULL, 'phelps.manalo@gmail.com ', '2019-08-01', NULL, 48, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(417, 3779, 'pic1.png', 'RTV3779', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RODERICK ', 'TUANO ', 'VILLASIN', 'Filipino', '1975-03-27', 'M', 'Quezon City', NULL, 'Married', NULL, '2065 E. Araullo St. Pureza Sta. Mesa Manila ', NULL, NULL, NULL, NULL, NULL, NULL, '101000241595', '3319492908', '190257299124', 'CO-TERMINUS', '09321300896', NULL, NULL, 'roderickvillasin@yahoo.com ', '2019-08-01', NULL, 48, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(418, 3781, 'pic1.png', 'REP3781', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ROMAR', 'ELICA', 'PUNAY', 'Filipino', '1998-05-08', 'M', 'Taytay, Rizal', NULL, 'Single', NULL, 'Blk. 3 Duhat St. Samagta Floodway Taytay Rizal ', NULL, NULL, NULL, NULL, NULL, NULL, '121184640687', '3463233107', '032506352931', 'CO-TERMINUS', '09198988628', NULL, NULL, 'romarpunay123@gmail.com ', '2019-08-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(419, 3782, 'pic1.png', 'ODA3782', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'OSCAR', 'DELOS SANTOS', 'AGUSTIN', 'Filipino', '1975-12-12', 'M', 'Naguilian, Isabela', NULL, 'Separated', NULL, '50 Narra St. Saint Anthony Subd. Taytay Rizal ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3454112017', '010258503509', 'CO-TERMINUS', '09756873701', NULL, NULL, 'agustinoscar0875@gmail.com', '2019-08-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(420, 3783, 'pic1.png', 'RID3783', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'REYNALDO', 'ISIPIN', 'DECANO', 'Filipino', '1963-05-16', 'M', 'Manila', NULL, 'Married', NULL, '534 Inocencio St. Pasay City ', NULL, NULL, NULL, NULL, NULL, NULL, '121035223564', '0364228007', '190508964971', 'CO-TERMINUS', '09177951667', NULL, NULL, 'reynaldodecano05@gmail.com ', '2019-08-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(421, 3784, 'pic1.png', 'YPF3784', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'YVES MICHAEL', 'PENOSO', 'FERNANDEZ', 'Filipino', '1992-12-29', 'M', 'Marikina ', NULL, 'Married', NULL, '10579 Blk. 11 Lot 23 PKG 2A Phase 6 Camarin Brgy. 178 Caloocan City ', NULL, NULL, NULL, NULL, NULL, NULL, '121122853249', '3435951488', '030510303918', 'CO-TERMINUS', '09165038035', NULL, NULL, 'yvesmfernandez@gmail.com', '2019-08-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(422, 3785, 'pic1.png', 'SVD3785', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'SAMUEL', 'VILLADOS', 'DELANTAR', 'Filipino', '1981-05-01', 'M', 'Pasay City', NULL, 'Married', NULL, '0997 Hiyas Subd. Malolos City Bulacan ', NULL, NULL, NULL, NULL, NULL, NULL, '101001327528', '3316130221', '010503202986', 'CO-TERMINUS', '09262240817', NULL, NULL, 'delantar_s@yahoo.com ', '2019-08-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(423, 3786, 'pic1.png', 'RBC3786', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ROMYLON', 'BALOLONG', 'CAMAT', 'Filipino', '1976-04-06', 'M', 'Dagupan, Pangasinan', NULL, 'Single', NULL, 'KS 7 415 Navarro St. General Trias Cavite', NULL, NULL, NULL, NULL, NULL, NULL, '101000250719', '0218083084', '010508737314', 'CO-TERMINUS', '09184309245', NULL, NULL, 'loncamat@yahoo.com', '2019-08-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(424, 3787, 'pic1.png', 'NTB3787', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'NEIL JAMES', 'TUGAHAN', 'BUSICO', 'Filipino', '1994-11-20', 'M', 'Zamboanga Del Norte ', NULL, 'Single', NULL, 'Blk 44 Lot 32 Phase 4A Duquise Ville Silangan San Mateo Rizal ', NULL, NULL, NULL, NULL, NULL, NULL, '121209279980', '3470600642', '032520692230', 'CO-TERMINUS', '09997989126', NULL, NULL, 'neiljamesbusico1823@gmail.com', '2019-08-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(425, 3788, 'pic1.png', 'JDP3788', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JONAS EXEQUIEL', 'DE LUNA', 'PABELLAN', 'Filipino', '1997-02-20', 'M', 'Taguig City', NULL, 'Single', NULL, '55 DMC Brgy. Sta. Ana Taguig City ', NULL, NULL, NULL, NULL, NULL, NULL, '121236115864', '3480737398', '152512930985', 'CO-TERMINUS', '09360831255', NULL, NULL, 'pabellan.jonas@gmail.com ', '2019-08-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(426, 3790, 'pic1.png', 'JVB3790', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JERRY', 'VICENTE', 'BALENJARE', 'Filipino', '1984-04-22', 'M', 'Manila', NULL, 'Single', NULL, '1228 Interior 4 Kahilom Pandacan Manila ', NULL, NULL, NULL, NULL, NULL, NULL, '109002635760', '3404744037', '020503730295', 'CO-TERMINUS', '09359445035', NULL, NULL, 'jherfoxvicente@gmail.com ', '2019-08-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(427, 3791, 'pic1.png', 'DES3791', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'DONALD', 'ESTRADA', 'SORIANO', 'Filipino', '1969-12-11', 'M', 'Manila', NULL, 'Married', NULL, 'Phase 2 Blk. 15 Lot 17 Mary Cris Homes, Bucandala 3, Imus Cavite', NULL, NULL, NULL, NULL, NULL, NULL, '101000246822', '3330899030', '190515454458', 'CO-TERMINUS', '09097685075', NULL, NULL, 'ds664025@gmail.com', '2019-08-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(428, 3792, 'pic1.png', 'EMS3792', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'EDUARDO', 'MORENO', 'SANTOS', 'Filipino', '1965-12-14', 'M', 'Sta. Lucia, Ilocos Sur ', NULL, 'Married', NULL, 'A 603 JCS Vill. Posadas St. Punta Sta. Ana Manila', NULL, NULL, NULL, NULL, NULL, NULL, '109002070455', '3308574167', '190895052667', 'CO-TERMINUS', '09327888580', NULL, NULL, 'eduardo66santos11@gmail.com', '2019-08-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(429, 3793, 'pic1.png', 'RPR3793', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RAYMART', 'PAPIO', 'RAMILO', 'Filipino', '1993-11-09', 'M', 'Marikina', NULL, 'Single', NULL, '488 Perpetual St. Malanday Marikina', NULL, NULL, NULL, NULL, NULL, NULL, '121164745062', '3452350088', '030258949281', 'CO-TERMINUS', '09395845128', NULL, NULL, 'raymart_bad@yahoo.com', '2019-08-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(430, 3794, 'pic1.png', 'AFU3794', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ALVIN ', 'FERNANDEZ', 'UNDALOC', 'Filipino', '1985-08-08', 'M', 'Ivisan, Capiz', NULL, 'Married ', NULL, '1230 B Sagat St. Paco Manila ', NULL, NULL, NULL, NULL, NULL, NULL, '108001546992', '3393774846', '030503942085', 'CO-TERMINUS', '09102532552', NULL, NULL, 'alvin.undaloc08@gmail.com', '2019-08-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(431, 3795, 'pic1.png', 'DST3795', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'DANILO', 'SIGUIN', 'TERRADO', 'Filipino', '1979-12-10', 'M', 'Manila', NULL, 'Single', NULL, '11 Mulawin St. Jabson Site Pasig City ', NULL, NULL, NULL, NULL, NULL, NULL, '101000208420', '3340672373', '220000675423', 'CO-TERMINUS', '09280580477', NULL, NULL, 'dterrado79.dt@gmail.com', '2019-08-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(432, 3796, 'pic1.png', 'RBD3796', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RUZEL', 'BANAS', 'DELA CRUZ', 'Filipino', '1995-01-01', 'M', 'Mandaluyong City', NULL, 'Single ', NULL, '5 Blk 38 Upo St. Brgy. Addition Hills Mandaluyong City', NULL, NULL, NULL, NULL, NULL, NULL, '121164956699', '3457132256', '020266657278', 'CO-TERMINUS', '09089201434', NULL, NULL, 'rbdelacruzrtu@gmail.com', '2019-08-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(433, 3797, 'pic1.png', 'RAP3797', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RICHARD', 'ADAYO', 'PALAYPAYON', 'Filipino', '1983-12-03', 'M', 'Valenzuela ', NULL, 'Single', NULL, '37 R Castillo Brgy. Kalawaan Pasig City', NULL, NULL, NULL, NULL, NULL, NULL, '121163128856', '3389506439', '010503765476', 'CO-TERMINUS', '09054343473', NULL, NULL, 'richardpalaypayon.RP@gmail.com', '2019-08-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(434, 3798, 'pic1.png', 'BBM3798', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'BRYAN JAY ', 'BALLESTEROS', 'MATIAS', 'Filipino', '1991-12-09', 'M', 'San Manuel, Isabela ', NULL, 'Single ', NULL, 'Blk. 6 Lot 33 Victoria Town Homes Brgy. Pooc Sta. Rosa City Laguna', NULL, NULL, NULL, NULL, NULL, NULL, '121130066924', '0123211213', '080258481279', 'CO-TERMINUS', '09163767898', NULL, NULL, 'bjaymatias@gmail.com', '2019-08-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(435, 3799, 'pic1.png', 'RCG3799', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'REYNALD', 'CABRILLAS', 'GARCIA', 'Filipino', '1988-10-17', 'M', 'Bani, Pangasinan', NULL, 'Maried ', NULL, 'San Antonio, Tulay Bato, Biñan ', NULL, NULL, NULL, NULL, NULL, NULL, '121149345258', '0236944590', '052011282733', 'CO-TERMINUS', '09465671914', NULL, NULL, 'reynaldgarcia865@gmail.com', '2019-08-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(436, 3800, 'pic1.png', 'ASC3800', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ANGELO MAR ', 'SANTIAGO', 'CASERES', 'Filipino', '1993-10-05', 'M', 'San Juan City', NULL, 'Single ', NULL, '437 Arayat St. Mandaluyong City ', NULL, NULL, NULL, NULL, NULL, NULL, '121084335336', '3448224487', '220001236962', 'CO-TERMINUS', '09278984801', NULL, NULL, 'angelocaseres030303@gmail.com ', '2019-08-01', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(437, 3801, 'pic1.png', 'MEV3801', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MARVIN CLINTON ', 'ENCARNACION ', 'VILLANUEVA', 'Filipino', '1996-11-23', 'M', 'Manila', NULL, 'Single', NULL, '87 M De Onon St. Marulas Valenzuela City', NULL, NULL, NULL, NULL, NULL, NULL, '121235342954', '3479040821', '020271436379', 'CO-TERMINUS', '09271509613', NULL, NULL, 'villanueva.marvin231996@gmail.com', '2019-08-13', NULL, 21, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(438, 3802, 'pic1.png', 'JBM3802', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JOVIC', 'BORROMEO', 'MENDOZA', 'Filipino', '1987-12-31', 'M', 'Quezon City ', NULL, 'Single', NULL, 'Phase 6 Blk. 9 Lot 31 Gov. Hills Subd. Brgy. Biclatan Gen. Trias Cavite', NULL, NULL, NULL, NULL, NULL, NULL, '121057377226', '3422035087', '030506487907', 'PROBATIONARY', '09176510601', NULL, NULL, 'jbmendoza31@gmail.com', '2019-08-16', NULL, 60, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(439, 3803, 'pic1.png', 'JML3803', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JOEY', 'MERCADO', 'LACBAY JR.', 'Filipino', '1993-12-28', 'M', 'Pila, Laguna', NULL, 'Single ', NULL, '002 Rizal St. Brgy. Sto. Niño Lumban Laguna ', NULL, NULL, NULL, NULL, NULL, NULL, '121231225267', '0441135615', '080264846815', 'CO-TERMINUS', '09568727372', NULL, NULL, 'waikiben@gmail.com', '2019-08-16', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(440, 3804, 'pic1.png', 'RQG3804', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ROBERT JAY', 'QUIZON', 'GAPASIN ', 'Filipino', '1984-10-12', 'M', 'Pasig City', NULL, 'Married ', NULL, '4 Jackson St. Vista Verde North Exec. Village Brgy. Llano Caloocan City ', NULL, NULL, NULL, NULL, NULL, NULL, '121023230502', '3390234622', '030502128937', 'CO-TERMINUS', '09287709683', NULL, NULL, 'gapasinobet@gmail.com', '2019-08-17', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(441, 3806, 'pic1.png', 'JCF3806', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JEARUS JIM', 'CANONOY', 'FLORES', 'Filipino ', '1997-12-16', 'M', 'San Fernado, La Union ', NULL, 'Single', NULL, '219 Ballay Bauang, La Union ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0127902722', '010265163314', 'CO-TERMINUS', '09270434321', NULL, NULL, 'jearusflores1697@gmail.com', '2019-09-02', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(442, 3808, 'pic1.png', ' CF3808', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', ' JERSON ERWIN TRENT ', 'CABOTE', 'FLORES', 'Filipino ', '1997-03-22', 'M', 'Makati City ', NULL, 'Single ', NULL, 'Blk 30 Lot 13 Efficiency St. PH 1 Heritage Homes Loma De Gato, Marilao Bulacan ', NULL, NULL, NULL, NULL, NULL, NULL, '121236412147', '3479038244', '020271517921', 'PROBATIONARY', '09054212536', NULL, NULL, 'itsjrsn.22@gmail.com', '2019-09-02', NULL, 0, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(443, 3810, 'pic1.png', 'RSB3810', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RAINHOLD ', 'SALAZAR ', 'BACIA', 'Filipino ', '1995-08-16', 'M', 'Daanbantayan, Cebu ', NULL, 'Single ', NULL, 'Lot 49 Blk. 4 Princetown Subd. Brgy. 171 Bagumbong Caloocan City', NULL, NULL, NULL, NULL, NULL, NULL, '121214680905', '3472273226', '020270006729', 'PROBATIONARY', '09477991159', NULL, NULL, 'rainholdbacia@gmail.com ', '2019-09-04', NULL, 21, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(444, 3811, 'pic1.png', 'AVS3811', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ARVIN JAY ', 'VIOLA ', 'SAURE ', 'Filipino ', '1988-08-18', 'M', 'Manila ', NULL, 'Married ', NULL, '841 Matimyas St. Sampaloc Manila', NULL, NULL, NULL, NULL, NULL, NULL, '121090750551', '3428753020', '020259538026', 'PROBATIONARY', '09266644521', NULL, NULL, 'arvinsaure@gmail.com ', '2019-09-09', NULL, 21, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(445, 3812, 'pic1.png', 'FCS3812', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'FORTUNATO ', 'CEBALLOS ', 'SORONGON ', 'Filipino ', '1965-01-22', 'M', 'Pototan, Iloilo ', NULL, 'Married ', NULL, 'Blk 1 Lot b1 Simon St. Filinvest South Brgy. Tubigan Biñan City Laguna ', NULL, NULL, NULL, NULL, NULL, NULL, '101001068178', '0713244878', '190893951419', 'CO-TERMINUS', '09177856353', NULL, NULL, 'jun.sorongon@yahoo.com ', '2019-09-09', NULL, 0, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(446, 3816, 'pic1.png', 'RBD3816', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'RICHARD ', 'BARCIBE ', 'DE GUZMAN ', 'Filipino ', '1977-06-17', 'M', 'Bulacan', NULL, 'Married ', NULL, '2381 Arellano Ave. Singalong, Manila ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3326223005', NULL, 'CO-TERMINUS', '09452541122', NULL, NULL, 'engrchard21@yahoo.com ', '2019-09-13', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(447, 3817, 'pic1.png', 'JMJ3817', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JERSWIN ', 'MILLOREN ', 'JUSAY', 'Filipino', '1997-07-13', 'M', 'Cuenca, Batangas ', NULL, 'Single', NULL, '5690 Libra St. Centennial II Nagpayong Brgy. Pinagbuhatan, Pasig City ', NULL, NULL, NULL, NULL, NULL, NULL, '121237070659', '3478455747', '012512081094', 'CO-TERMINUS', '09508893561', NULL, NULL, 'jusayjerswin@gmail.com ', '2019-09-16', NULL, 21, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(448, 3818, 'pic2.png', 'EBA3818', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ELLA MAE ', 'BUERANO', 'ATIENZA', 'Filipino ', '1998-10-11', 'F', 'Abiacao, San Luis Batangas', NULL, 'Single', NULL, '230 H- UP Lapidario St. Sampaloc Manila ', NULL, NULL, NULL, NULL, NULL, NULL, '121258426888', '3487504430', '020272935271', 'PROBATIONARY', '09506976115', NULL, NULL, 'ellamaeatienza7@gmail.com ', '2019-09-27', NULL, 5, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(449, 3819, 'pic1.png', 'EAL3819', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'EDGAR ', 'ABUDA ', 'LANDA ', 'Filipino ', '1976-11-03', 'M', 'Quezon City ', NULL, 'Single', NULL, '488 Kaunlaran St. Brgy. Commonwealth Quezon City ', NULL, NULL, NULL, NULL, NULL, NULL, '101000223820', '3340663191', NULL, 'CO-TERMINUS', '09612443292', NULL, NULL, 'edgarvirgie25@gmail.com ', '2019-10-01', NULL, 48, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(450, 3820, 'pic1.png', 'JSM3820', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JOHN EDWARD ', 'SOLIVERES', 'MASAGCA', 'Filipino ', '1994-10-12', 'M', 'Virac, Catanduanes', NULL, 'Single ', NULL, '149 3A 7th St. Fabie Subd. Paco, Manila', NULL, NULL, NULL, NULL, NULL, NULL, '919242321516', '0514411473', '100502632676', 'PROBATIONARY', '09092182714', NULL, NULL, 'masagcajohnedward@gmail.com ', '2019-10-01', NULL, 47, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(451, 3821, 'pic2.png', 'JSL3821', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JUSTINE SARAH', 'SANTOS ', 'LEE', 'Filipino ', '1994-09-29', 'F', 'Manila City ', NULL, 'Single ', NULL, '2093-B Bato Ext. Raxabago St. Tondo, Manila ', NULL, NULL, NULL, NULL, NULL, NULL, '121157259788', '3454547983', '030258640167', 'PROBATIONARY', '09778137517', NULL, NULL, 'leejustinesarah@gmail.com ', '2019-10-01', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(452, 3822, 'pic1.png', 'JGP3822', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JOEBEL', 'GABIOTA', 'PATRICIO', 'Flipino ', '1968-08-07', 'M', 'Sagay, Negros Occidental ', NULL, 'Married ', NULL, '79 Sampaloc St. Zone 1 Signal Village Taguig City', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0398869209', '190524352730', 'CO-TERMINUS', '09751727236', NULL, NULL, 'joebelpatricio@yahoo.com', '2019-10-02', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(453, 3823, 'pic1.png', 'MMU3823', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MARK ANTHONY ', 'MANUEL', 'UY ', 'Filipino ', '1993-02-18', 'M', 'Valenzuela City ', NULL, 'Single', NULL, '330 Tandang Manang St. Parada Valenzuela City ', NULL, NULL, NULL, NULL, NULL, NULL, '121251090851', '3484426430', NULL, 'CO-TERMINUS', '09451354756', NULL, NULL, 'markuy32@gmail.com', '2019-10-08', NULL, 69, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(454, 3824, 'pic1.png', 'AJL3824', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ARIEL ', 'JABINAR', 'LABONG ', 'Flipino ', '1993-09-11', 'M', 'Motiong Samar ', NULL, 'Single ', NULL, 'Purok 3, Peñafrancia Subd. Brgy. Cupang, Antipolo City', NULL, NULL, NULL, NULL, NULL, NULL, '121165791423', '3454562117', '030258666638', 'CO-TERMINUS', '09391062314', NULL, NULL, 'arieljabinar53@gmail.com', '2019-10-07', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(455, 3825, 'pic1.png', 'JPP3825', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JAMES RUSSELL', 'PAYAWAL ', 'PADO ', 'Flipino ', '1996-11-27', 'M', 'Manila City ', NULL, 'Single', NULL, 'Lot 18 Blk. 601 Cardinal St. Heritage Homes Marilao, Bulacan', NULL, NULL, NULL, NULL, NULL, NULL, '121237176711', '3479690970', '212503389905', 'CO-TERMINUS', '09776376169', NULL, NULL, 'jamesrussellpado@gmail.com', '2019-10-24', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(456, 3826, 'pic1.png', 'PDR3826', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'PERCIVAL', 'DACARA', 'ROSOS', 'Filipino', '1971-01-13', 'M', 'Manila City ', NULL, 'Married ', NULL, '1718 Pampanga St. Sta. Cruz Manila', NULL, NULL, NULL, NULL, NULL, NULL, '105000106860', '0396596493', '190511037976', 'CO-TERMINUS', '09179130503', NULL, NULL, '1371bobrerosos@gmail.com', '2019-10-06', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(457, 3829, 'pic1.png', 'JRD3829', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JOBELLE', 'RAMOS', 'DELA CRUZ', 'Filipino ', '1986-08-25', 'M', 'Pilar, Sorsogon ', NULL, 'Married', NULL, 'Block 49 Lot 29 Phase 2 Pinagsama Village Taguig City', NULL, NULL, NULL, NULL, NULL, NULL, '121084548550', '3381246577', '010500893708', 'PROBATIONARY', '09154605435', NULL, NULL, 'jobelleramosdcruz@gmail.com ', '2019-10-16', NULL, 23, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(458, 3830, 'pic1.png', 'JBG3830', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JOFRE', 'BAÑEZ', 'GRAPE ', 'Filipino ', '1970-01-30', 'M', 'San Juan Rizal ', NULL, 'Single ', NULL, '3087 Jenny\'s Ave. Rosario, Pasig City ', NULL, NULL, NULL, NULL, NULL, NULL, '109002054656', '3307478442', '010511688847', 'CO-TERMINUS', '09164325821', NULL, NULL, 'jgrape0130@gmail.com', '2019-10-23', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(459, 3831, 'pic2.png', 'JAF3831', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JUDY ANN ', 'ABAOAG', 'FERNANDEZ', 'Filipino ', '1996-11-17', 'F', 'Bautista, Pangasinan ', NULL, 'Single ', NULL, '3417 Guernica cor. Dayap St. Palanan, Makati City', NULL, NULL, NULL, NULL, NULL, NULL, '121214371708', '3472215967', '030262213427', 'PROBATIONARY', '09073062115', NULL, NULL, 'judyannfernandez17@gmail.com', '2019-10-28', NULL, 46, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(460, 3832, 'pic2.png', 'KDG3832', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'KATE GERALDINE ', 'DE ROXAS', 'GAMILLA', 'Filipino', '1995-01-10', 'F', 'Malabon City ', NULL, 'Single', NULL, 'Blk 15 Lot 86 Phase 3 Area 2 Tanigue St. Longos Malabon City ', NULL, NULL, NULL, NULL, NULL, NULL, '121199448363', '3467651905', '022509448918', 'CO-TERMINUS', '09357726451', NULL, NULL, 'geraldinegamilla@yahoo.com', '2019-10-30', NULL, 69, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(461, 3833, 'pic1.png', 'KPP3833', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'KIM HENSTHER ', 'PORNESO ', 'PRINCESA', 'Filipino', '1997-09-14', 'M', 'Cabanatuan City ', NULL, 'Single ', NULL, 'Brgy. Poblacion West 3 Aliaga Nueva Ecija ', NULL, NULL, NULL, NULL, NULL, NULL, '121236885033', '0244670717', '210256068510', 'CO-TERMINUS', '09275428021', NULL, NULL, 'khp.princesa@gmail.com ', '2019-11-04', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(462, 3834, 'pic1.png', 'JAC3834', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JAMES LAWRENCE', 'AREVALO ', 'CRISTOBAL', 'Filipino ', '1996-12-30', 'M', 'Sta. Cruz, Manila ', NULL, 'Single', NULL, '1724 Old Antipolo St. Sta Cruz, Manila', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3481248271', '022526571057', 'CO-TERMINUS', '09055187946', NULL, NULL, 'jameslaw.cristobal@gmail.com', '2019-11-11', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(463, 3835, 'pic1.png', 'CLA3835', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'CLYDE CHESTER', 'LOPEZ', 'ALBAO ', 'Filipino', '1995-08-23', 'M', 'Tacloban, Leyte', NULL, 'Single', NULL, 'Unit 413, S6 R. Delfin St. Finihomes Marulas , Valenzuela City ', NULL, NULL, NULL, NULL, NULL, NULL, '919316782565', '3489614234', '020273222570', 'CO-TERMINUS', '09274057392', NULL, NULL, 'albaoclyde7890@gmail.com ', '2019-11-18', NULL, 69, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(464, 3836, 'pic2.png', 'AMO3836', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ANN CAMILLE ', 'MERCENE', 'ODRONIA ', 'Filipino ', '1993-07-08', 'F', 'Manila ', NULL, 'Single ', NULL, 'Blk. 72 L20 Z-5 JP Rizal St. Upper Bicutan Taguig City ', NULL, NULL, NULL, NULL, NULL, NULL, '121214035179', '3431611544', '012518798527', 'CO-TERMINUS', '09213865901', NULL, NULL, 'odroniaa@yahoo.com', '2019-11-20', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(465, 3838, 'pic1.png', 'RAL3838', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ROLLIE ', 'ADORO', 'LUNA ', 'Filipino ', '1978-04-30', 'M', 'Manila ', NULL, 'Married ', NULL, '308 Callejon 2 Sta. Cruz Pasig City', NULL, NULL, NULL, NULL, NULL, NULL, '121112874967', '3345211166', '090252351689', 'CO-TERMINUS', '09464788377', NULL, NULL, 'rollieluna1287@yahoo.com ', '2019-11-21', NULL, 53, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(466, 3839, 'pic1.png', 'RLO3839', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ROYCE JOHN ', 'LALAGUNA ', 'OMILA ', 'Filipino ', '1996-01-08', 'M', 'Manila ', NULL, 'Single ', NULL, '224 D. Ampil St. Sta. Mesa Manila ', NULL, NULL, NULL, NULL, NULL, NULL, '919317882221', '3489722702', '020273237438', 'CO-TERMINUS', '09277439459', NULL, NULL, 'rjomila@gmail.com', '2019-11-25', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(467, 3840, 'pic2.png', 'MKT3840', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'MARGETT', 'KATIGBAK', 'TOLENTINO ', 'Filipino ', '1998-09-14', 'F', 'Cavite City ', NULL, 'Single ', NULL, 'Sito Tala, Brgy. Munting Indang, Nasugbu, Batangas', NULL, NULL, NULL, NULL, NULL, NULL, '121254667667', '0442611581', '090256797657', 'PROBATIONARY', '09973076193', NULL, NULL, 'margettktolentino14@gmail.com', '2019-11-25', NULL, 44, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(468, 3841, 'pic1.png', 'JLB3841', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JESUS PATRICK ', 'LINOG ', 'BADEO ', 'Filipino ', '1995-05-27', 'M', 'Manila ', NULL, 'Single ', NULL, '2313 Nickel St. San Andres Bukid, Manila', NULL, NULL, NULL, NULL, NULL, NULL, '121102787854', '3441360652', '020260624890', 'PROBATIONARY', '09774882195', NULL, NULL, 'badeojesuspatrick@gmail.com', '2019-11-25', NULL, 35, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(469, 3842, 'pic1.png', 'GGV3842', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'GERARD ', 'GALLEGOS', 'VIRAY ', 'Filipino ', '1995-12-29', 'M', 'Valenzuela', NULL, 'Single ', NULL, '112 Orange Road Potrero Malabon City ', NULL, NULL, NULL, NULL, NULL, NULL, '121236173625', '3479343052', '020269505401', 'CO-TERMINUS', '09459800947', NULL, NULL, 'ghe.viray029@yahoo.com ', '2019-11-25', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(470, 3843, 'pic1.png', 'NCM3843', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'NEIL OLIVER', 'CASTILLO', 'MACALINAO ', 'Filipino ', '1995-12-24', 'M', 'Dinalupihan, Bataan ', NULL, 'Single ', NULL, '1477 Galvani St. San Isidro Makati City ', NULL, NULL, NULL, NULL, NULL, NULL, '121237612016', '0239158257', '070511373024', 'PROBATIONARY', '09771423827', NULL, NULL, 'neomacalinao@gmail.com', '2019-12-02', NULL, 21, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(471, 3844, 'pic2.png', 'RTM3844', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ROSELY ', 'TANAID', 'MEREDORES', 'Filipino', '1994-11-09', 'F', 'Baybay City, Leyte ', NULL, 'Single ', NULL, '2019 F. Magsaysay St. Guadalupe Nuevo, Makati City ', NULL, NULL, NULL, NULL, NULL, NULL, '121144760085', '3450503507', '020511310181', 'CO-TERMINUS', '09352343600', NULL, NULL, 'rosely09meredores@gmail.com', '2019-12-02', NULL, 9, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(472, 3845, 'pic1.png', 'GLV3845', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'GABRIELLE ', 'LISBOA ', 'VALIENTE ', 'Filipino ', '1994-03-13', 'M', 'Manila City ', NULL, 'Single', NULL, 'Blk 21 Lot 7 Delaware St. Manuela Ville San Agustin II Dasmariñas Cavite ', NULL, NULL, NULL, NULL, NULL, NULL, '121264682932', '3490443203', NULL, 'CO-TERMINUS', '09657998000 / 09292375191', NULL, NULL, 'gabriellelisboavaliente@gmail.com', '2019-12-16', NULL, 69, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(473, 3846, 'pic1.png', 'JTJ3846', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JEAN PIERRE', 'TIONGSON', 'JOCSON ', 'Filipino ', '1994-11-18', 'M', 'Balanga, Bataan ', NULL, 'Single ', NULL, '55-A Victoria St. Brgy. Sauyo Quezon City ', NULL, NULL, NULL, NULL, NULL, NULL, '121259533316', '3488081897', '020273018116', 'CO-TERMINUS', '09271282869', NULL, NULL, 'pierre.jocson@gmail.com ', '2019-12-16', NULL, 69, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(474, 3847, 'pic2.png', 'AME3847', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ASHLIE JOY ', 'MANUEL', 'EDEP', 'Filipino', '1997-10-16', 'F', 'Angeles City, Pampanga', NULL, 'Single ', NULL, 'Blk 19 Lot 10, Bright Homes Cay Pombo Sta. Maria Bulacan ', NULL, NULL, NULL, NULL, NULL, NULL, '919347771792', '3490509419', '210256973612', 'CO-TERMINUS', '09493112839', NULL, NULL, 'edepashlie@gmail.com', '2019-12-16', NULL, 69, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(475, 3848, 'pic1.png', 'AAP3848', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'ALAIN', 'ANTONIO', 'PERALTA', 'Filipino', '1990-08-24', 'M', 'Quezon City ', NULL, 'Single ', NULL, 'A-38 1093 Leyte St. District IV Brgy. 562 Sampaloc  Manila ', NULL, NULL, NULL, NULL, NULL, NULL, '121263871255', '3472565976', '020273264192', 'CO-TERMINUS', '09554167250', NULL, NULL, 'alainperaltz@gmail.com', '2020-01-06', NULL, 21, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(476, 3849, 'pic1.png', 'DIS3849', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'DUSTIN', 'IGNACIO', 'SANTIAGO', 'Filipino', '1996-06-18', 'M', 'Manila City ', NULL, 'Single ', NULL, '13 B., C. Alberto St., BF Resort Village, Brgy. Talon Dos Las Piñas City ', NULL, NULL, NULL, NULL, NULL, NULL, '121213830785', '3472019118', '012514384604', 'CO-TERMINUS', '09567255633', NULL, NULL, 'dstnignc@gmail.com', '2020-01-06', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(477, 3850, 'pic2.png', 'JSO3850', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JAZZIL PEARL', 'SANIEL', 'OCAMPO', 'Filipino', '1996-09-30', 'F', 'Marikina City', NULL, 'Single', NULL, '1473 Monggo St. District 2 Napico Manggahan Pasig City', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '12512959065', 'CO-TERMINUS', '9210915129', NULL, NULL, 'jazzilocampo1996@gmail.com', '2020-01-10', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(478, 3851, 'pic2.png', 'PFZ3851', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'PHEA JOY ', 'FERRER', 'ZAMORA ', 'Filipino', '1996-08-03', 'F', 'San Carlos City, Pangasinan', NULL, 'Single ', NULL, 'Purok II Brgy. Manzon, San Carlos City, Pangasinan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0244905686', '032505606476', 'PROBATIONARY', '09363592173', NULL, NULL, 'zamoraphea@gmail.com', '2020-01-13', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(479, 3852, 'pic1.png', 'JAY3852', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JAMER AUGUSTINE', 'ABRAJANO ', 'YAPCHULAY ', 'Filipino', '1993-05-27', 'M', 'Pasay City ', NULL, 'Single ', NULL, '2442 Lakandula St. Yapchulay Compound Units I and J, Pasay City ', NULL, NULL, NULL, NULL, NULL, NULL, '121264959842', '3424097599', '010260894469', 'PROBATIONARY', '09175002726', NULL, NULL, 'jameryapchulay27@gmail.com', '2020-01-20', NULL, 0, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(480, 3853, 'pic1.png', 'CWL3853', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'CHRISOSTOMO ', 'WONG', 'LADERAS', 'Filipino', '1995-12-24', 'M', 'San Jose City, Nueva Ecija ', NULL, 'Single', NULL, '5/F 8192 Christina Apartelle, Constancia St. Brgy. Olympia, Makati City ', NULL, NULL, NULL, NULL, NULL, NULL, '121213783961', '0242979342', '210255259835', 'CO-TERMINUS', '09452087344', NULL, NULL, 'chrisostomoladeras@yahoo.com', '2020-01-21', NULL, 7, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(481, 3854, 'pic1.png', 'EVN3854', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'EUGENE', 'VIANZON', 'NAVARRO', 'Filipino', '1994-12-12', 'M', 'Balanga City, Bataan', NULL, 'Single', NULL, '185 Lote Sto. Domingo Orion, Bataan', NULL, NULL, NULL, NULL, NULL, NULL, '121246684031', '3482948978', '72501913260', 'CO-TERMINUS', '9672463992', NULL, NULL, 'eugenenavarro.en@gmail.com', '2020-01-30', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(482, 3855, 'pic1.png', 'ELO3855', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'EDWARD JOSEPH', 'LEYESA', 'ODESTE', 'Filipino', '1983-07-08', 'M', 'Manila', NULL, 'Single', NULL, 'U-1123 The Manila Residences Tower I, Taft Ave., Malate Manila', NULL, NULL, NULL, NULL, NULL, NULL, '12120212756', '3383199185', '121202012756', 'PROBATIONARY', '9177837128', NULL, NULL, 'ejodeste@gmail.com', '2020-02-03', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(483, 3856, 'pic2.png', 'GCC3856', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'GLADYS', 'CUARESMA', 'CASIBANG', 'Filipino', '1999-01-27', 'F', 'Dr. Jose Fabella Memorial Hospital, Manila', NULL, 'Single', NULL, '7 Katuwiran St. Napindan, Taguig City', NULL, NULL, NULL, NULL, NULL, NULL, '121249138775', '245547496', '52516177160', 'PROBATIONARY', '9500995873', NULL, NULL, 'Casibanggladys01@gmail.com', '2020-02-05', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(484, 3857, 'pic2.png', 'PMG3857', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'PATRICIA', 'MIRA', 'GASITA', 'Filipino', '2000-01-10', 'F', 'San Fabian, Pangasinan', NULL, 'Single', NULL, 'Barangay Tiblong San Fabian, Pangasinan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '129068127', '52523057731', 'PROBATIONARY', '9274593407', NULL, NULL, 'patriciamiragacita@gmail.com', '2020-02-05', NULL, 3, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(485, 3858, 'pic1.png', 'KCD3858', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'KISSLE DAVE', 'CASTRO', 'DE GUZMAN', 'Filipino', '1996-10-03', 'M', 'San Carlos City Pangasinan', NULL, 'Single', NULL, '62 Talang San Carlos City Pangasinan', NULL, NULL, NULL, NULL, NULL, NULL, '121263639054', '3487548409', '52517341770', 'CO-TERMINUS', '9498612984', NULL, NULL, NULL, '2020-02-05', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(486, 3859, 'pic2.png', 'SGB3859', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'SHAINE AIRA', 'GUBE', 'BOBADILLA', 'Filipino', '1999-06-29', 'F', 'Calaca, Batangas', NULL, 'Single', NULL, '061 Igualdad St. Poblacion 1 Calaca, Batangas', NULL, NULL, NULL, NULL, NULL, NULL, '121254499735', '3486306163', '90256817194', 'PROBATIONARY', '9173681768', NULL, NULL, 'bshaineaira@gmail.com', '2020-02-05', NULL, 44, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(487, 3860, 'pic1.png', 'JMD3860', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'JORELLE', 'MENCIAS', 'DELESMO', 'Filipino', '1997-06-21', 'M', 'San Roque Hospital Liang, Malolos, Bulacan', NULL, 'Single', NULL, '371 Purok 4 Capalangan Apalit, Pampanga', NULL, NULL, NULL, NULL, NULL, NULL, '121260209252', '3476194097', '72503883873', 'CO-TERMINUS', '9957809851', NULL, NULL, 'jorelled77@gmail.com', '2020-02-07', NULL, 20, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13'),
(488, 3861, 'pic1.png', 'GDM3861', '$2y$10$bvtNa/aI2yP9H.wf1UkV9.wBpXAZ/5NCCO2iaceAtytBqcHgga0AG', 'GERVINE MALONE', 'DUQUE', 'MORALLOS', 'Filipino', '1987-11-23', 'M', 'District II, Quezon City', NULL, 'Married', NULL, '64 Sampaguita St. Sto. Rosario Silangan Pateros City', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'PROBATIONARY', '9273379064', NULL, NULL, 'revivals00@yahoo.com', '2020-03-02', NULL, 64, 0, '', 0, ',', 0, 'active', '2020-08-24 02:18:13', '2020-08-24 02:18:13');

-- --------------------------------------------------------

--
-- Table structure for table `hris_employee_certifications`
--

DROP TABLE IF EXISTS `hris_employee_certifications`;
CREATE TABLE IF NOT EXISTS `hris_employee_certifications` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_id` bigint(20) NOT NULL,
  `certification_id` bigint(20) NOT NULL,
  `institute` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `granted_on` date DEFAULT NULL,
  `valid_thru` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_employee_dependents`
--

DROP TABLE IF EXISTS `hris_employee_dependents`;
CREATE TABLE IF NOT EXISTS `hris_employee_dependents` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_id` bigint(20) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `relationship` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_employee_documents`
--

DROP TABLE IF EXISTS `hris_employee_documents`;
CREATE TABLE IF NOT EXISTS `hris_employee_documents` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_id` bigint(20) NOT NULL,
  `document_type_id` bigint(20) NOT NULL,
  `date_added` date NOT NULL,
  `valid_until` date DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci,
  `attachment` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_employee_educations`
--

DROP TABLE IF EXISTS `hris_employee_educations`;
CREATE TABLE IF NOT EXISTS `hris_employee_educations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_id` bigint(20) NOT NULL,
  `education_id` bigint(20) NOT NULL,
  `institute` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date DEFAULT NULL,
  `completed` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_employee_expenses`
--

DROP TABLE IF EXISTS `hris_employee_expenses`;
CREATE TABLE IF NOT EXISTS `hris_employee_expenses` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_id` bigint(20) NOT NULL,
  `expense_date` date NOT NULL,
  `payment_method_id` bigint(20) NOT NULL,
  `ref_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payee` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expense_category_id` bigint(20) NOT NULL,
  `notes` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `receipt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment_1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment_2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_employee_languages`
--

DROP TABLE IF EXISTS `hris_employee_languages`;
CREATE TABLE IF NOT EXISTS `hris_employee_languages` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_id` bigint(20) NOT NULL,
  `language_id` bigint(20) NOT NULL,
  `reading` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `speaking` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `writing` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `understanding` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_employee_loans`
--

DROP TABLE IF EXISTS `hris_employee_loans`;
CREATE TABLE IF NOT EXISTS `hris_employee_loans` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_id` bigint(20) NOT NULL,
  `loan_type_id` bigint(20) NOT NULL,
  `loan_start_date` date NOT NULL,
  `last_installment_date` date NOT NULL,
  `loan_period` int(11) NOT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `loan_amount` int(11) NOT NULL,
  `monthly_installment` int(11) NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_employee_projects`
--

DROP TABLE IF EXISTS `hris_employee_projects`;
CREATE TABLE IF NOT EXISTS `hris_employee_projects` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_id` bigint(20) NOT NULL,
  `project_id` bigint(20) NOT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_employee_skills`
--

DROP TABLE IF EXISTS `hris_employee_skills`;
CREATE TABLE IF NOT EXISTS `hris_employee_skills` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_id` bigint(20) NOT NULL,
  `skill_id` bigint(20) NOT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_employee_training_sessions`
--

DROP TABLE IF EXISTS `hris_employee_training_sessions`;
CREATE TABLE IF NOT EXISTS `hris_employee_training_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_id` bigint(20) NOT NULL,
  `training_session_id` bigint(20) NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_employment_statuses`
--

DROP TABLE IF EXISTS `hris_employment_statuses`;
CREATE TABLE IF NOT EXISTS `hris_employment_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hris_employment_statuses`
--

INSERT INTO `hris_employment_statuses` (`id`, `created_at`, `updated_at`, `name`, `description`) VALUES
(1, NULL, NULL, 'REGULAR', 'REGULAR'),
(2, NULL, NULL, 'CO-TERMINUS', 'CO-TERMINUS'),
(3, NULL, NULL, 'PROBATIONARY', 'PROBATIONARY'),
(4, NULL, NULL, 'FIXED-TERM', 'FIXED-TERM');

-- --------------------------------------------------------

--
-- Table structure for table `hris_employment_types`
--

DROP TABLE IF EXISTS `hris_employment_types`;
CREATE TABLE IF NOT EXISTS `hris_employment_types` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hris_employment_types`
--

INSERT INTO `hris_employment_types` (`id`, `created_at`, `updated_at`, `name`) VALUES
(1, NULL, NULL, 'Regular'),
(2, NULL, NULL, 'Co-Terminus'),
(3, NULL, NULL, 'Probationary'),
(4, NULL, NULL, 'Fixed-Term');

-- --------------------------------------------------------

--
-- Table structure for table `hris_expenses_categories`
--

DROP TABLE IF EXISTS `hris_expenses_categories`;
CREATE TABLE IF NOT EXISTS `hris_expenses_categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hris_expenses_categories`
--

INSERT INTO `hris_expenses_categories` (`id`, `created_at`, `updated_at`, `name`) VALUES
(1, NULL, NULL, 'Auto - Gas'),
(2, NULL, NULL, 'Auto - Insurance'),
(3, NULL, NULL, 'Maintenance'),
(4, NULL, NULL, 'Repair'),
(5, NULL, NULL, 'Transportation'),
(6, NULL, NULL, 'Bank fees'),
(7, NULL, NULL, 'Dining Out'),
(8, NULL, NULL, 'Entertainment'),
(9, NULL, NULL, 'Hotel / Motel'),
(10, NULL, NULL, 'Insurance'),
(11, NULL, NULL, 'Interest Charges'),
(12, NULL, NULL, 'Loan Payment'),
(13, NULL, NULL, 'Medical'),
(14, NULL, NULL, 'Mileage'),
(15, NULL, NULL, 'Rent'),
(16, NULL, NULL, 'Rental Car'),
(17, NULL, NULL, 'Utility'),
(18, NULL, NULL, 'Clothing');

-- --------------------------------------------------------

--
-- Table structure for table `hris_experience_levels`
--

DROP TABLE IF EXISTS `hris_experience_levels`;
CREATE TABLE IF NOT EXISTS `hris_experience_levels` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hris_experience_levels`
--

INSERT INTO `hris_experience_levels` (`id`, `created_at`, `updated_at`, `name`) VALUES
(1, NULL, NULL, 'Not Applicable'),
(2, NULL, NULL, 'Internship'),
(3, NULL, NULL, 'Entry Level'),
(4, NULL, NULL, 'Associate'),
(5, NULL, NULL, 'Mid-Senior Level'),
(6, NULL, NULL, 'Director'),
(7, NULL, NULL, 'Executive'),
(8, NULL, NULL, '2 - 3 years'),
(9, NULL, NULL, '3 - 5 years'),
(10, NULL, NULL, '1 - 2 years'),
(11, NULL, NULL, 'At least 3 years'),
(12, NULL, NULL, 'Less than 6 months'),
(13, NULL, NULL, '1 year'),
(14, NULL, NULL, '3 - 4 years'),
(15, NULL, NULL, '2 years');

-- --------------------------------------------------------

--
-- Table structure for table `hris_holidays`
--

DROP TABLE IF EXISTS `hris_holidays`;
CREATE TABLE IF NOT EXISTS `hris_holidays` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holiday_date` date NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_itinerary_requests`
--

DROP TABLE IF EXISTS `hris_itinerary_requests`;
CREATE TABLE IF NOT EXISTS `hris_itinerary_requests` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_id` int(11) NOT NULL,
  `supervisor_id` int(11) DEFAULT NULL,
  `role_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transportation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purpose` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `travel_from` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `travel_to` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `travel_date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `return_date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_id` int(11) NOT NULL,
  `total_funding_proposed` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment_1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment_2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment_3` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_job_functions`
--

DROP TABLE IF EXISTS `hris_job_functions`;
CREATE TABLE IF NOT EXISTS `hris_job_functions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hris_job_functions`
--

INSERT INTO `hris_job_functions` (`id`, `created_at`, `updated_at`, `name`) VALUES
(1, NULL, NULL, 'Accounting/Auditing'),
(2, NULL, NULL, 'Administrative and Support Services'),
(3, NULL, NULL, 'Advertising'),
(4, NULL, NULL, 'Business Analyst'),
(5, NULL, NULL, 'Financial Analyst'),
(6, NULL, NULL, 'Data Analyst'),
(7, NULL, NULL, 'Art/Creative');

-- --------------------------------------------------------

--
-- Table structure for table `hris_job_positions`
--

DROP TABLE IF EXISTS `hris_job_positions`;
CREATE TABLE IF NOT EXISTS `hris_job_positions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `job_title_id` bigint(20) NOT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hiring_manager` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show_hiring_manager_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirements` longtext COLLATE utf8mb4_unicode_ci,
  `benefit_id` bigint(20) NOT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` bigint(20) DEFAULT NULL,
  `employment_type_id` bigint(20) DEFAULT NULL,
  `exp_level_id` bigint(20) DEFAULT NULL,
  `job_function_id` bigint(20) DEFAULT NULL,
  `education_level_id` bigint(20) DEFAULT NULL,
  `show_salary` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salary_min` int(11) DEFAULT NULL,
  `salary_max` int(11) DEFAULT NULL,
  `keywords` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `closing_date` date DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_job_titles`
--

DROP TABLE IF EXISTS `hris_job_titles`;
CREATE TABLE IF NOT EXISTS `hris_job_titles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `specification` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hris_job_titles`
--

INSERT INTO `hris_job_titles` (`id`, `created_at`, `updated_at`, `code`, `name`, `description`, `specification`) VALUES
(1, NULL, NULL, 'ESD-CO', 'Account Engineer I', 'Account Engineer I', 'Account Engineer I'),
(2, NULL, NULL, 'ESD-CO', 'Account Engineer III', 'Account Engineer III', 'Account Engineer III'),
(3, NULL, NULL, 'RAA', 'Accounting Assistant', 'Accounting Assistant', 'Accounting Assistant'),
(4, NULL, NULL, 'AA', 'Accounting Assistant', 'Accounting Assistant', 'Accounting Assistant'),
(5, NULL, NULL, 'RAA', 'Accounting Assistant - Reliever', 'Accounting Assistant - Reliever', 'Accounting Assistant - Reliever'),
(6, NULL, NULL, 'SSA', 'Accounting Assistant II', 'Accounting Assistant II', 'Accounting Assistant II'),
(7, NULL, NULL, 'ACS-CO', 'Accounting Officer', 'Accounting Officer', 'Accounting Officer'),
(8, NULL, NULL, 'ACS', 'Accounting Supervisor', 'Accounting Supervisor', 'Accounting Supervisor'),
(9, NULL, NULL, 'AS', 'Administrative Assistant', 'Administrative Assistant', 'Administrative Assistant'),
(10, NULL, NULL, 'RAS', 'Administrative Assistant', 'Administrative Assistant', 'Administrative Assistant'),
(11, NULL, NULL, 'SSA-CO', 'Administrative Assistant (Marketing)', 'Administrative Assistant (Marketing)', 'Administrative Assistant (Marketing)'),
(12, NULL, NULL, 'SSA-CO', 'Administrative Supervisor', 'Administrative Supervisor', 'Administrative Supervisor'),
(13, NULL, NULL, 'BM', 'Assistant Building Manager', 'Assistant Building Manager', 'Assistant Building Manager'),
(14, NULL, NULL, 'ABM', 'Assistant Building Manager', 'Assistant Building Manager', 'Assistant Building Manager'),
(15, NULL, NULL, 'ESD-CO', 'Assistant Department Manager', 'Assistant Department Manager', 'Assistant Department Manager'),
(16, NULL, NULL, 'B & C', 'Biling and Collection Assistant', 'Biling and Collection Assistant', 'Biling and Collection Assistant'),
(17, NULL, NULL, 'SSA', 'BMS Operator', 'BMS Operator', 'BMS Operator'),
(18, NULL, NULL, 'SSA-CO', 'Bookkeeper', 'Bookkeeper', 'Bookkeeper'),
(19, NULL, NULL, 'BE', 'Building Administrator', 'Building Administrator', 'Building Administrator'),
(20, NULL, NULL, 'RBE', 'Building Engineer', 'Building Engineer', 'Building Engineer'),
(21, NULL, NULL, 'RBE', 'Building Engineer - Reliever', 'Building Engineer - Reliever', 'Building Engineer - Reliever'),
(22, NULL, NULL, 'BE', 'Building Engineer I', 'Building Engineer I', 'Building Engineer I'),
(23, NULL, NULL, 'RBM', 'Building Manager', 'Building Manager', 'Building Manager'),
(24, NULL, NULL, 'RBM', 'Building Manager - Reliever (Ocean Tower)', 'Building Manager - Reliever (Ocean Tower)', 'Building Manager - Reliever (Ocean Tower)'),
(25, NULL, NULL, 'BM', 'Building Manager II', 'Building Manager II', 'Building Manager II'),
(26, NULL, NULL, 'BM', 'Building Manager III', 'Building Manager III', 'Building Manager III'),
(27, NULL, NULL, 'T', 'Carpenter/Plumber', 'Carpenter/Plumber', 'Carpenter/Plumber'),
(28, NULL, NULL, 'SSA', 'Cashier', 'Cashier', 'Cashier'),
(29, NULL, NULL, 'T', 'Chiller Operator', 'Chiller Operator', 'Chiller Operator'),
(30, NULL, NULL, 'SSA-CO', 'Company Driver', 'Company Driver', 'Company Driver'),
(31, NULL, NULL, 'BM', 'Complex Manager', 'Complex Manager', 'Complex Manager'),
(32, NULL, NULL, 'MT', 'Director for Engineering Services', 'Director for Engineering Services', 'Director for Engineering Services'),
(33, NULL, NULL, 'DH', 'Director for HRCSD', 'Director for HRCSD', 'Director for HRCSD'),
(34, NULL, NULL, 'MT', 'Director for Property Operations', 'Director for Property Operations', 'Director for Property Operations'),
(35, NULL, NULL, 'SSA-CO', 'Encoder', 'Encoder', 'Encoder'),
(36, NULL, NULL, 'DH', 'Engineering Operations Manager', 'Engineering Operations Manager', 'Engineering Operations Manager'),
(37, NULL, NULL, 'ESD-CO', 'Facilities Engineer', 'Facilities Engineer', 'Facilities Engineer'),
(38, NULL, NULL, 'BM', 'Facilities Manager', 'Facilities Manager', 'Facilities Manager'),
(39, NULL, NULL, 'MT', 'Finance and IT Associate Director', 'Finance and IT Associate Director', 'Finance and IT Associate Director'),
(40, NULL, NULL, 'BM', 'Fit-Out Manager', 'Fit-Out Manager', 'Fit-Out Manager'),
(41, NULL, NULL, 'SSA-CO', 'General Services Officer', 'General Services Officer', 'General Services Officer'),
(42, NULL, NULL, 'SSA', 'Gondola Operator', 'Gondola Operator', 'Gondola Operator'),
(43, NULL, NULL, 'SSA', 'GSD Assistant', 'GSD Assistant', 'GSD Assistant'),
(44, NULL, NULL, 'SSA-CO', 'HR Assistant', 'HR Assistant', 'HR Assistant'),
(45, NULL, NULL, 'SSA-CO', 'HR Officer', 'HR Officer', 'HR Officer'),
(46, NULL, NULL, 'SSA-CO', 'Internal Auditor', 'Internal Auditor', 'Internal Auditor'),
(47, NULL, NULL, 'SSA-CO', 'IT Assistant', 'IT Assistant', 'IT Assistant'),
(48, NULL, NULL, 'T', 'Lead Technician', 'Lead Technician', 'Lead Technician'),
(49, NULL, NULL, 'SSA', 'Liason Officer', 'Liason Officer', 'Liason Officer'),
(50, NULL, NULL, 'SSA', 'Lift Attendant', 'Lift Attendant', 'Lift Attendant'),
(51, NULL, NULL, 'SSA-CO', 'Marketing Assistant', 'Marketing Assistant', 'Marketing Assistant'),
(52, NULL, NULL, 'SSA', 'Messenger', 'Messenger', 'Messenger'),
(53, NULL, NULL, 'T', 'Multi-skilled Technician', 'Multi-skilled Technician', 'Multi-skilled Technician'),
(54, NULL, NULL, 'RT', 'Multi-skilled Technician', 'Multi-skilled Technician', 'Multi-skilled Technician'),
(55, NULL, NULL, 'T', 'Multi-skilled Technician - Reliever', 'Multi-skilled Technician - Reliever', 'Multi-skilled Technician - Reliever'),
(56, NULL, NULL, 'ESD-AT', 'Multi-skilled Technician I', 'Multi-skilled Technician I', 'Multi-skilled Technician I'),
(57, NULL, NULL, 'ESD-AT', 'Multi-skilled Technician II', 'Multi-skilled Technician II', 'Multi-skilled Technician II'),
(58, NULL, NULL, 'SSA-CO', 'Officer I (FITD)', 'Officer I (FITD)', 'Officer I (FITD)'),
(59, NULL, NULL, 'ASC-CO', 'Officer II (FITD)', 'Officer II (FITD)', 'Officer II (FITD)'),
(60, NULL, NULL, 'CH', 'Operations Manager', 'Operations Manager', 'Operations Manager'),
(61, NULL, NULL, 'CH', 'Operations Manager II', 'Operations Manager II', 'Operations Manager II'),
(62, NULL, NULL, 'ACS-CO', 'Project Accounting Supervisor', 'Project Accounting Supervisor', 'Project Accounting Supervisor'),
(63, NULL, NULL, 'ACS-CO', 'QEHS Assistant', 'QEHS Assistant', 'QEHS Assistant'),
(64, NULL, NULL, 'DH', 'QEHS Manager', 'QEHS Manager', 'QEHS Manager'),
(65, NULL, NULL, 'R', 'Receptionist', 'Receptionist', 'Receptionist'),
(66, NULL, NULL, 'BE', 'Shift Engineer', 'Shift Engineer', 'Shift Engineer'),
(67, NULL, NULL, 'SSA', 'Shift Engineer', 'Shift Engineer', 'Shift Engineer'),
(68, NULL, NULL, 'SE', 'Shift Engineer', 'Shift Engineer', 'Shift Engineer'),
(69, NULL, NULL, 'SSA', 'Technical Assistant', 'Technical Assistant', 'Technical Assistant'),
(70, NULL, NULL, 'T', 'Technical Assistant', 'Technical Assistant', 'Technical Assistant'),
(71, NULL, NULL, 'ESD-CO', 'Technical Safety Auditor', 'Technical Safety Auditor', 'Technical Safety Auditor'),
(72, NULL, NULL, 'TS', 'Technical Supervisor', 'Technical Supervisor', 'Technical Supervisor'),
(73, NULL, NULL, 'ESD-AT', 'Technical Supervisor', 'Technical Supervisor', 'Technical Supervisor'),
(74, NULL, NULL, 'SSA', 'Valet Driver', 'Valet Driver', 'Valet Driver'),
(75, NULL, NULL, 'BM', 'Village Manager', 'Village Manager', 'Village Manager');

-- --------------------------------------------------------

--
-- Table structure for table `hris_languages`
--

DROP TABLE IF EXISTS `hris_languages`;
CREATE TABLE IF NOT EXISTS `hris_languages` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hris_languages`
--

INSERT INTO `hris_languages` (`id`, `created_at`, `updated_at`, `name`, `description`) VALUES
(1, NULL, NULL, 'Filipino', 'Filipino'),
(2, NULL, NULL, 'English', 'English'),
(3, NULL, NULL, 'Visayan Language', 'Visayan Language');

-- --------------------------------------------------------

--
-- Table structure for table `hris_leaves`
--

DROP TABLE IF EXISTS `hris_leaves`;
CREATE TABLE IF NOT EXISTS `hris_leaves` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `leave_type_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `leave_start_date` bigint(20) NOT NULL,
  `leave_end_date` bigint(20) NOT NULL,
  `approved_date` bigint(20) DEFAULT NULL,
  `approved_by_id` bigint(20) DEFAULT NULL,
  `supervisor_id` bigint(20) DEFAULT NULL,
  `remarks` longtext COLLATE utf8mb4_unicode_ci,
  `reason` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_leave_entitlements`
--

DROP TABLE IF EXISTS `hris_leave_entitlements`;
CREATE TABLE IF NOT EXISTS `hris_leave_entitlements` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_leave_groups`
--

DROP TABLE IF EXISTS `hris_leave_groups`;
CREATE TABLE IF NOT EXISTS `hris_leave_groups` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `job_title_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_leave_group_employees`
--

DROP TABLE IF EXISTS `hris_leave_group_employees`;
CREATE TABLE IF NOT EXISTS `hris_leave_group_employees` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_id` bigint(20) NOT NULL,
  `leave_group_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_leave_periods`
--

DROP TABLE IF EXISTS `hris_leave_periods`;
CREATE TABLE IF NOT EXISTS `hris_leave_periods` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hris_leave_periods`
--

INSERT INTO `hris_leave_periods` (`id`, `created_at`, `updated_at`, `name`, `start`, `end`) VALUES
(1, '2020-08-24 18:56:17', '2020-08-24 18:56:17', 'sample', '2020-01-01', '2020-12-31');

-- --------------------------------------------------------

--
-- Table structure for table `hris_leave_rules`
--

DROP TABLE IF EXISTS `hris_leave_rules`;
CREATE TABLE IF NOT EXISTS `hris_leave_rules` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `leave_type_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `leave_group_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employment_status_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exp_days` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `leave_period_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_per_year` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supervisor_assign_leave` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_can_apply` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apply_beyond_current` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `leave_accrue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `proportionate_on_joined_date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_leave_period` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_leave_types`
--

DROP TABLE IF EXISTS `hris_leave_types`;
CREATE TABLE IF NOT EXISTS `hris_leave_types` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `leave_color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hris_leave_types`
--

INSERT INTO `hris_leave_types` (`id`, `created_at`, `updated_at`, `name`, `leave_color`) VALUES
(1, '2020-08-24 18:53:02', '2020-08-24 18:53:02', 'Sick Leave', '#32CD3'),
(2, '2020-08-24 18:54:02', '2020-08-24 18:54:02', 'Vacation Leave', '#00800'),
(3, '2020-08-24 18:54:34', '2020-08-24 18:54:34', 'Leave without Pay', '#8B000');

-- --------------------------------------------------------

--
-- Table structure for table `hris_notifs`
--

DROP TABLE IF EXISTS `hris_notifs`;
CREATE TABLE IF NOT EXISTS `hris_notifs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `supervisor_id` int(11) NOT NULL,
  `notif_message` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `read` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_overtimes`
--

DROP TABLE IF EXISTS `hris_overtimes`;
CREATE TABLE IF NOT EXISTS `hris_overtimes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `acc_mode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sender_id` bigint(20) NOT NULL,
  `department_id` bigint(20) NOT NULL,
  `employee_id` bigint(20) NOT NULL,
  `ot_difference` int(11) NOT NULL,
  `ot_date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ot_time_in` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ot_time_out` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `overtime_category_id` bigint(20) NOT NULL,
  `employee_remarks` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `overtime_type_id` bigint(20) DEFAULT NULL,
  `supervisor_remarks` longtext COLLATE utf8mb4_unicode_ci,
  `supervisor_id` bigint(20) DEFAULT NULL,
  `role_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_by_id` bigint(20) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `REG` int(11) DEFAULT NULL,
  `REG_8` int(11) DEFAULT NULL,
  `REG_ND1` int(11) DEFAULT NULL,
  `REG_ND2` int(11) DEFAULT NULL,
  `RST` int(11) DEFAULT NULL,
  `RST_8` int(11) DEFAULT NULL,
  `RST_ND1` int(11) DEFAULT NULL,
  `RST_ND2` int(11) DEFAULT NULL,
  `LGL` int(11) DEFAULT NULL,
  `LGL_8` int(11) DEFAULT NULL,
  `LGL_ND1` int(11) DEFAULT NULL,
  `LGL_ND2` int(11) DEFAULT NULL,
  `LGLRST` int(11) DEFAULT NULL,
  `LGLRST_8` int(11) DEFAULT NULL,
  `LGLRST_ND1` int(11) DEFAULT NULL,
  `LGLRST_ND2` int(11) DEFAULT NULL,
  `SPL` int(11) DEFAULT NULL,
  `SPL_8` int(11) DEFAULT NULL,
  `SPL_ND1` int(11) DEFAULT NULL,
  `SPL_ND2` int(11) DEFAULT NULL,
  `SPLRST` int(11) DEFAULT NULL,
  `SPLRST_8` int(11) DEFAULT NULL,
  `SPLRST_ND1` int(11) DEFAULT NULL,
  `SPLRST_ND2` int(11) DEFAULT NULL,
  `SPRS_CLIEN` int(11) DEFAULT NULL,
  `SPRS_CLIEN_8` int(11) DEFAULT NULL,
  `SPRS_CLIEN_ND1` int(11) DEFAULT NULL,
  `SPRS_CLIEN_ND2` int(11) DEFAULT NULL,
  `LGRS_CLIEN` int(11) DEFAULT NULL,
  `LGRS_CLIEN_8` int(11) DEFAULT NULL,
  `LGRS_CLIEN_ND1` int(11) DEFAULT NULL,
  `LGRS_CLIEN_ND2` int(11) DEFAULT NULL,
  `SPL_CLIENT` int(11) DEFAULT NULL,
  `SPL_CLIENT_8` int(11) DEFAULT NULL,
  `SPL_CLIENT_ND1` int(11) DEFAULT NULL,
  `SPL_CLIENT_ND2` int(11) DEFAULT NULL,
  `RST_CLIENT` int(11) DEFAULT NULL,
  `RST_CLIENT_8` int(11) DEFAULT NULL,
  `RST_CLIENT_ND1` int(11) DEFAULT NULL,
  `RST_CLIENT_ND2` int(11) DEFAULT NULL,
  `REG_CLIENT` int(11) DEFAULT NULL,
  `REG_CLIENT_8` int(11) DEFAULT NULL,
  `REG_CLIENT_ND1` int(11) DEFAULT NULL,
  `REG_CLIENT_ND2` int(11) DEFAULT NULL,
  `REGND_CLIE` int(11) DEFAULT NULL,
  `REGND_CLIE_8` int(11) DEFAULT NULL,
  `REGND_CLIE_ND1` int(11) DEFAULT NULL,
  `REGND_CLIE_ND2` int(11) DEFAULT NULL,
  `LG_CLIENT` int(11) DEFAULT NULL,
  `LG_CLIENT_8` int(11) DEFAULT NULL,
  `LG_CLIENT_ND1` int(11) DEFAULT NULL,
  `LG_CLIENT_ND2` int(11) DEFAULT NULL,
  `LGLSPL` int(11) DEFAULT NULL,
  `LGLSPL_8` int(11) DEFAULT NULL,
  `LGLSPL_ND1` int(11) DEFAULT NULL,
  `LGLSPL_ND2` int(11) DEFAULT NULL,
  `LGLSPLRST` int(11) DEFAULT NULL,
  `LGLSPLRST_8` int(11) DEFAULT NULL,
  `LGLSPLRST_ND1` int(11) DEFAULT NULL,
  `LGLSPLRST_ND2` int(11) DEFAULT NULL,
  `LGLSPL_CLI` int(11) DEFAULT NULL,
  `LGLSPL_CLI_8` int(11) DEFAULT NULL,
  `LGLSPL_CLI_ND1` int(11) DEFAULT NULL,
  `LGLSPL_CLI_ND2` int(11) DEFAULT NULL,
  `LGLSPL_ND1_2` int(11) DEFAULT NULL,
  `LGLSPL_ND1_2_8` int(11) DEFAULT NULL,
  `LGLSPL_ND1_2_ND1` int(11) DEFAULT NULL,
  `LGLSPL_ND1_2_ND2` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hris_overtimes`
--

INSERT INTO `hris_overtimes` (`id`, `created_at`, `updated_at`, `acc_mode`, `sender_id`, `department_id`, `employee_id`, `ot_difference`, `ot_date`, `ot_time_in`, `ot_time_out`, `overtime_category_id`, `employee_remarks`, `overtime_type_id`, `supervisor_remarks`, `supervisor_id`, `role_id`, `approved_date`, `approved_by_id`, `status`, `REG`, `REG_8`, `REG_ND1`, `REG_ND2`, `RST`, `RST_8`, `RST_ND1`, `RST_ND2`, `LGL`, `LGL_8`, `LGL_ND1`, `LGL_ND2`, `LGLRST`, `LGLRST_8`, `LGLRST_ND1`, `LGLRST_ND2`, `SPL`, `SPL_8`, `SPL_ND1`, `SPL_ND2`, `SPLRST`, `SPLRST_8`, `SPLRST_ND1`, `SPLRST_ND2`, `SPRS_CLIEN`, `SPRS_CLIEN_8`, `SPRS_CLIEN_ND1`, `SPRS_CLIEN_ND2`, `LGRS_CLIEN`, `LGRS_CLIEN_8`, `LGRS_CLIEN_ND1`, `LGRS_CLIEN_ND2`, `SPL_CLIENT`, `SPL_CLIENT_8`, `SPL_CLIENT_ND1`, `SPL_CLIENT_ND2`, `RST_CLIENT`, `RST_CLIENT_8`, `RST_CLIENT_ND1`, `RST_CLIENT_ND2`, `REG_CLIENT`, `REG_CLIENT_8`, `REG_CLIENT_ND1`, `REG_CLIENT_ND2`, `REGND_CLIE`, `REGND_CLIE_8`, `REGND_CLIE_ND1`, `REGND_CLIE_ND2`, `LG_CLIENT`, `LG_CLIENT_8`, `LG_CLIENT_ND1`, `LG_CLIENT_ND2`, `LGLSPL`, `LGLSPL_8`, `LGLSPL_ND1`, `LGLSPL_ND2`, `LGLSPLRST`, `LGLSPLRST_8`, `LGLSPLRST_ND1`, `LGLSPLRST_ND2`, `LGLSPL_CLI`, `LGLSPL_CLI_8`, `LGLSPL_CLI_ND1`, `LGLSPL_CLI_ND2`, `LGLSPL_ND1_2`, `LGLSPL_ND1_2_8`, `LGLSPL_ND1_2_ND1`, `LGLSPL_ND1_2_ND2`) VALUES
(1, '2020-08-24 17:57:52', '2020-08-24 17:59:02', 'employee', 5, 15, 5, 3, '2020-08-24', '1700', '2000', 1, 'sample', 3, 'sample', 6, ',4,6,', '2020-08-24 10:59:02', 6, 1, NULL, NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hris_overtime_categories`
--

DROP TABLE IF EXISTS `hris_overtime_categories`;
CREATE TABLE IF NOT EXISTS `hris_overtime_categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hris_overtime_categories`
--

INSERT INTO `hris_overtime_categories` (`id`, `created_at`, `updated_at`, `name`) VALUES
(1, NULL, NULL, 'EXTENDED DUTY DUE TO NEW EMPLOYEE UNDER FAMILIARIZATION, TURNOVER'),
(2, NULL, NULL, 'AS PER SCHEDULE'),
(3, NULL, NULL, 'RELIEVER (LEAVE/ ABSENT/ LATE/ REST DAY OF EMPLOYEE)'),
(4, NULL, NULL, 'LACK OF MANPOWER'),
(5, NULL, NULL, 'REST DAY DUTY - SPECIAL HOLIDAY'),
(6, NULL, NULL, 'REST DAY DUTY - LEGAL HOLIDAY'),
(7, NULL, NULL, 'REST DAY DUTY - HOLIDAY ON REST DAY');

-- --------------------------------------------------------

--
-- Table structure for table `hris_overtime_requests`
--

DROP TABLE IF EXISTS `hris_overtime_requests`;
CREATE TABLE IF NOT EXISTS `hris_overtime_requests` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_overtime_types`
--

DROP TABLE IF EXISTS `hris_overtime_types`;
CREATE TABLE IF NOT EXISTS `hris_overtime_types` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hris_overtime_types`
--

INSERT INTO `hris_overtime_types` (`id`, `created_at`, `updated_at`, `name`) VALUES
(1, NULL, NULL, 'REG'),
(2, NULL, NULL, 'REG_>8'),
(3, NULL, NULL, 'REG_ND1'),
(4, NULL, NULL, 'REG_ND2'),
(5, NULL, NULL, 'RST'),
(6, NULL, NULL, 'RST_>8'),
(7, NULL, NULL, 'RST_ND1'),
(8, NULL, NULL, 'RST_ND2'),
(9, NULL, NULL, 'LGL'),
(10, NULL, NULL, 'LGL_>8'),
(11, NULL, NULL, 'LGL_ND1'),
(12, NULL, NULL, 'LGL_ND2'),
(13, NULL, NULL, 'LGLRST'),
(14, NULL, NULL, 'LGLRST_>8'),
(15, NULL, NULL, 'LGLRST_ND1'),
(16, NULL, NULL, 'LGLRST_ND2'),
(17, NULL, NULL, 'SPL'),
(18, NULL, NULL, 'SPL_>8'),
(19, NULL, NULL, 'SPL_ND1'),
(20, NULL, NULL, 'SPL_ND2'),
(21, NULL, NULL, 'SPLRST'),
(22, NULL, NULL, 'SPLRST_>8'),
(23, NULL, NULL, 'SPLRST_ND1'),
(24, NULL, NULL, 'SPLRST_ND2'),
(25, NULL, NULL, 'SPRS_CLIEN'),
(26, NULL, NULL, 'SPRS_CLIEN_>8'),
(27, NULL, NULL, 'SPRS_CLIEN_ND1'),
(28, NULL, NULL, 'SPRS_CLIEN_ND2'),
(29, NULL, NULL, 'LGRS_CLIEN'),
(30, NULL, NULL, 'LGRS_CLIEN_>8'),
(31, NULL, NULL, 'LGRS_CLIEN_ND1'),
(32, NULL, NULL, 'LGRS_CLIEN_ND2'),
(33, NULL, NULL, 'SPL_CLIENT'),
(34, NULL, NULL, 'SPL_CLIENT_>8'),
(35, NULL, NULL, 'SPL_CLIENT_ND1'),
(36, NULL, NULL, 'SPL_CLIENT_ND2'),
(37, NULL, NULL, 'RST_CLIENT'),
(38, NULL, NULL, 'RST_CLIENT_>8'),
(39, NULL, NULL, 'RST_CLIENT_ND1'),
(40, NULL, NULL, 'RST_CLIENT_ND2'),
(41, NULL, NULL, 'REG_CLIENT'),
(42, NULL, NULL, 'REG_CLIENT_>8'),
(43, NULL, NULL, 'REG_CLIENT_ND1'),
(44, NULL, NULL, 'REG_CLIENT_ND2'),
(45, NULL, NULL, 'REGND_CLIE'),
(46, NULL, NULL, 'REGND_CLIE_>8'),
(47, NULL, NULL, 'REGND_CLIE_ND1'),
(48, NULL, NULL, 'REGND_CLIE_ND2'),
(49, NULL, NULL, 'LG_CLIENT'),
(50, NULL, NULL, 'LG_CLIENT_>8'),
(51, NULL, NULL, 'LG_CLIENT_ND1'),
(52, NULL, NULL, 'LG_CLIENT_ND2'),
(53, NULL, NULL, 'LGLSPL'),
(54, NULL, NULL, 'LGLSPL_>8'),
(55, NULL, NULL, 'LGLSPL_ND1'),
(56, NULL, NULL, 'LGLSPL_ND2'),
(57, NULL, NULL, 'LGLSPLRST'),
(58, NULL, NULL, 'LGLSPLRST_>8'),
(59, NULL, NULL, 'LGLSPLRST_ND1'),
(60, NULL, NULL, 'LGLSPLRST_ND2'),
(61, NULL, NULL, 'LGLSPL_CLI'),
(62, NULL, NULL, 'LGLSPL_CLI_>8'),
(63, NULL, NULL, 'LGLSPL_CLI_ND1'),
(64, NULL, NULL, 'LGLSPL_CLI_ND2'),
(65, NULL, NULL, 'LGLSPL_ND1(2)'),
(66, NULL, NULL, 'LGLSPL_ND1(2)_>8'),
(67, NULL, NULL, 'LGLSPL_ND1(2)_ND1'),
(68, NULL, NULL, 'LGLSPL_ND1(2)_ND2');

-- --------------------------------------------------------

--
-- Table structure for table `hris_paid_time_offs`
--

DROP TABLE IF EXISTS `hris_paid_time_offs`;
CREATE TABLE IF NOT EXISTS `hris_paid_time_offs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `leave_type_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `leave_period_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_payment_methods`
--

DROP TABLE IF EXISTS `hris_payment_methods`;
CREATE TABLE IF NOT EXISTS `hris_payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hris_payment_methods`
--

INSERT INTO `hris_payment_methods` (`id`, `created_at`, `updated_at`, `name`) VALUES
(1, NULL, NULL, 'Cash'),
(2, NULL, NULL, 'Check'),
(3, NULL, NULL, 'Credit Card'),
(4, NULL, NULL, 'Debit Card');

-- --------------------------------------------------------

--
-- Table structure for table `hris_pay_grades`
--

DROP TABLE IF EXISTS `hris_pay_grades`;
CREATE TABLE IF NOT EXISTS `hris_pay_grades` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_salary` int(11) NOT NULL,
  `max_salary` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hris_pay_grades`
--

INSERT INTO `hris_pay_grades` (`id`, `created_at`, `updated_at`, `name`, `currency`, `min_salary`, `max_salary`) VALUES
(1, NULL, NULL, '1', 'Philippine Peso', 13400, 14700),
(2, NULL, NULL, '2', 'Philippine Peso', 14700, 16200),
(3, NULL, NULL, '3', 'Philippine Peso', 16200, 18000);

-- --------------------------------------------------------

--
-- Table structure for table `hris_projects`
--

DROP TABLE IF EXISTS `hris_projects`;
CREATE TABLE IF NOT EXISTS `hris_projects` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` bigint(20) DEFAULT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_skills`
--

DROP TABLE IF EXISTS `hris_skills`;
CREATE TABLE IF NOT EXISTS `hris_skills` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hris_skills`
--

INSERT INTO `hris_skills` (`id`, `created_at`, `updated_at`, `name`, `description`) VALUES
(1, NULL, NULL, 'Analytical and problem solving skills', 'Employers want people who can use creativity, reasoning and past experiences to identify and solve problems effectively.'),
(2, NULL, NULL, 'Communication skills', 'Listening, speaking and writing. Employers want people who can accurately interpret what others are saying and organize and express their thoughts clearly..'),
(3, NULL, NULL, 'Teamwork', 'In today’s work environment, many jobs involve working in one or more groups. Employers want someone who can bring out the best in others.'),
(4, NULL, NULL, 'Personal management skills', 'The ability to plan and manage multiple assignments and tasks, set priorities and adapt to changing conditions and work assignments.'),
(5, NULL, NULL, 'Interpersonal effectiveness', 'Employers usually note whether an employee can relate to co-workers and build relationships with others in the organization.'),
(6, NULL, NULL, 'Computer/technical literacy', 'Although employers expect to provide training on job-specific software, they also expect employees to be proficient with basic computer skills.'),
(7, NULL, NULL, 'Leadership/management skills', 'The ability to take charge and manage your co-workers, if required, is a welcome trait. Most employers look for signs of leadership qualities.'),
(8, NULL, NULL, 'Learning skills', 'Jobs are constantly changing and evolving, and employers want people who can grow and learn as changes come.'),
(9, NULL, NULL, 'Academic competence in reading and math', 'Although most jobs don’t require calculus, almost all jobs require the ability to read and comprehend  instructions and perform basic math.'),
(10, NULL, NULL, 'Strong work values', 'Dependability, honesty, selfconfidence and a positive attitude are prized qualities in any profession. Employers look for personal integrity.'),
(11, NULL, NULL, 'Conceptual skills', 'Conceptual skills'),
(12, NULL, NULL, 'Creative thinking skills', 'Creative thinking skills'),
(13, NULL, NULL, 'Critical thinking skills', 'Critical thinking skills'),
(14, NULL, NULL, 'Decision-making skills', 'Decision-making skills'),
(15, NULL, NULL, 'Employability skills', 'Employability skills'),
(16, NULL, NULL, 'Marketing skills', 'Marketing skills'),
(17, NULL, NULL, 'Organizational skills', 'Organizational skills'),
(18, NULL, NULL, 'Project management skills', 'Project management skills'),
(19, NULL, NULL, 'Soft skills and hard skills', 'Soft skills and hard skills'),
(20, NULL, NULL, 'Time management skills', 'Time management skills'),
(21, NULL, NULL, 'Transferable skills', 'Transferable skills'),
(22, NULL, NULL, 'Effective communication', 'Effective communication'),
(23, NULL, NULL, 'Adaptability skills', 'Adaptability skills');

-- --------------------------------------------------------

--
-- Table structure for table `hris_system_logs`
--

DROP TABLE IF EXISTS `hris_system_logs`;
CREATE TABLE IF NOT EXISTS `hris_system_logs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action_id` bigint(20) DEFAULT NULL,
  `field` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_data` text COLLATE utf8mb4_unicode_ci,
  `new_data` text COLLATE utf8mb4_unicode_ci,
  `log_date_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hris_system_logs`
--

INSERT INTO `hris_system_logs` (`id`, `created_at`, `updated_at`, `user`, `module`, `action`, `action_id`, `field`, `old_data`, `new_data`, `log_date_time`) VALUES
(1, NULL, NULL, 'hr.officer', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 10:23:21'),
(2, NULL, NULL, 'superadmin', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 10:36:39'),
(3, NULL, NULL, 'hr.payroll', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 10:56:36'),
(4, '2020-08-24 17:57:53', '2020-08-24 17:57:53', 'hr.payroll', 'Time Management - Overtime', 'add', 1, NULL, NULL, NULL, '2020-08-24 10:57:53'),
(5, NULL, NULL, 'hr.officer', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 10:58:09'),
(6, '2020-08-24 17:59:02', '2020-08-24 17:59:02', 'hr.officer', 'Time Management - Overtime', 'update', 1, 'status', 'Pending', 'Approved', '2020-08-24 10:59:02'),
(7, NULL, NULL, 'hr.payroll', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 10:59:20'),
(8, NULL, NULL, 'superadmin', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 11:00:11'),
(9, NULL, NULL, 'hr.officer', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 11:00:38'),
(10, '2020-08-24 18:08:17', '2020-08-24 18:08:17', 'hr.officer', 'Time Management - Work Shift Assignment', 'update', 1, 'employee', '', 'Patrick Badeo', '2020-08-24 11:08:17'),
(11, '2020-08-24 18:08:17', '2020-08-24 18:08:17', 'hr.officer', 'Time Management - Work Shift Assignment', 'update', 1, 'date from', '2020-08-24', '2020-08-24', '2020-08-24 11:08:17'),
(12, '2020-08-24 18:08:17', '2020-08-24 18:08:17', 'hr.officer', 'Time Management - Work Shift Assignment', 'update', 1, 'date to', '2020-11-24', '2020-11-24', '2020-08-24 11:08:17'),
(13, '2020-08-24 18:11:55', '2020-08-24 18:11:55', 'hr.officer', 'Time Management - Work Shift Assignment', 'add', 1, NULL, NULL, NULL, '2020-08-24 11:11:55'),
(14, '2020-08-24 18:12:14', '2020-08-24 18:12:14', 'hr.officer', 'Time Management - Work Shift Assignment', 'update', 5, 'employee', 'Isay Castillo', 'Tyson Tan', '2020-08-24 11:12:14'),
(15, '2020-08-24 18:12:34', '2020-08-24 18:12:34', 'hr.officer', 'Time Management - Work Shift Assignment', 'add', 1, NULL, NULL, NULL, '2020-08-24 11:12:34'),
(16, '2020-08-24 18:13:15', '2020-08-24 18:13:15', 'hr.officer', 'Time Management - Work Shift Assignment', 'add', 1, NULL, NULL, NULL, '2020-08-24 11:13:15'),
(17, NULL, NULL, 'hr.officer', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 11:14:04'),
(18, NULL, NULL, 'hr.payroll', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 11:14:21'),
(19, NULL, NULL, 'hr.officer', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 11:18:37'),
(20, NULL, NULL, 'hr.officer', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 11:20:45'),
(21, NULL, NULL, 'hr.officer', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 11:24:14'),
(22, NULL, NULL, 'hr.officer', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 11:24:46'),
(23, NULL, NULL, 'hr.officer', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 11:26:04'),
(24, NULL, NULL, 'hr.officer', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 11:34:50'),
(25, NULL, NULL, 'hr.officer', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 11:36:32'),
(26, NULL, NULL, 'hr.officer', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 11:37:06'),
(27, NULL, NULL, 'hr.officer', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 11:37:23'),
(28, NULL, NULL, 'hr.officer', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 11:42:35'),
(29, NULL, NULL, 'hr.officer', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 11:44:48'),
(30, NULL, NULL, 'hr.payroll', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 11:48:11'),
(31, '2020-08-24 18:49:09', '2020-08-24 18:49:09', 'hr.payroll', 'Employee Management - Itenerary Request', 'add', 1, NULL, NULL, NULL, '2020-08-24 11:49:09'),
(32, NULL, NULL, 'hr.officer', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 11:49:54'),
(33, '2020-08-24 18:53:02', '2020-08-24 18:53:02', 'hr.officer', 'Leave Settings - Leave Type', 'add', 1, NULL, NULL, NULL, '2020-08-24 11:53:02'),
(34, '2020-08-24 18:54:02', '2020-08-24 18:54:02', 'hr.officer', 'Leave Settings - Leave Type', 'add', 2, NULL, NULL, NULL, '2020-08-24 11:54:02'),
(35, '2020-08-24 18:54:34', '2020-08-24 18:54:34', 'hr.officer', 'Leave Settings - Leave Type', 'add', 3, NULL, NULL, NULL, '2020-08-24 11:54:34'),
(36, '2020-08-24 18:56:17', '2020-08-24 18:56:17', 'hr.officer', 'Leave Settings - Leave Period', 'add', 1, NULL, NULL, NULL, '2020-08-24 11:56:17'),
(37, NULL, NULL, 'hr.officer', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 15:38:33'),
(38, NULL, NULL, 'hr.officer', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 15:43:40'),
(39, NULL, NULL, 'hr.officer', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 15:43:48'),
(40, NULL, NULL, 'hr.payroll', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 15:43:53'),
(41, NULL, NULL, 'hr.payroll', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 15:54:17'),
(42, NULL, NULL, 'hr.officer', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 16:08:45'),
(43, NULL, NULL, 'superadmin', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 16:20:41'),
(44, NULL, NULL, 'superadmin', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 16:21:21'),
(45, '2020-08-24 23:34:10', '2020-08-24 23:34:10', 'superadmin', 'Employee Management - Itenerary Request', 'update', 1, 'status', 'Pending', 'Approved', '2020-08-24 16:34:10'),
(46, NULL, NULL, 'hr.payroll', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 16:36:34'),
(47, NULL, NULL, 'hr.officer', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 16:43:03'),
(48, NULL, NULL, 'superadmin', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-24 17:55:53'),
(49, NULL, NULL, 'hr.recruitment', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-25 08:03:02'),
(50, NULL, NULL, 'Hr.payroll', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-25 08:52:03'),
(51, NULL, NULL, 'Hr.payroll', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-25 08:53:48'),
(52, NULL, NULL, 'Hr.payroll2', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-25 08:54:09'),
(53, NULL, NULL, 'Hr.payroll2', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-25 08:55:24'),
(54, NULL, NULL, 'Hr.recruitment', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-25 08:55:41'),
(55, NULL, NULL, 'Hr.officer', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-25 08:56:53'),
(56, NULL, NULL, 'Hr.officer2', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-25 08:59:36'),
(57, NULL, NULL, 'Hr.officer', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-25 09:00:33'),
(58, NULL, NULL, 'hr.recruitment', NULL, 'login', NULL, NULL, NULL, NULL, '2020-08-26 13:11:19');

-- --------------------------------------------------------

--
-- Table structure for table `hris_time_projects`
--

DROP TABLE IF EXISTS `hris_time_projects`;
CREATE TABLE IF NOT EXISTS `hris_time_projects` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `project` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_time_sheets`
--

DROP TABLE IF EXISTS `hris_time_sheets`;
CREATE TABLE IF NOT EXISTS `hris_time_sheets` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_time_zones`
--

DROP TABLE IF EXISTS `hris_time_zones`;
CREATE TABLE IF NOT EXISTS `hris_time_zones` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `utc` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=145 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hris_time_zones`
--

INSERT INTO `hris_time_zones` (`id`, `created_at`, `updated_at`, `utc`, `name`) VALUES
(1, NULL, NULL, '(UTC-11:00)', 'Pacific/Midway'),
(2, NULL, NULL, '(UTC-11:00)', 'Pacific/Samoa'),
(3, NULL, NULL, '(UTC-10:00)', 'Pacific/Honolulu'),
(4, NULL, NULL, '(UTC-09:00)', 'US/Alaska'),
(5, NULL, NULL, '(UTC-08:00)', 'America/Los_Angeles'),
(6, NULL, NULL, '(UTC-08:00)', 'America/Tijuana'),
(7, NULL, NULL, '(UTC-07:00)', 'US/Arizona'),
(8, NULL, NULL, '(UTC-07:00)', 'America/Chihuahua'),
(9, NULL, NULL, '(UTC-07:00)', 'America/Chihuahua'),
(10, NULL, NULL, '(UTC-07:00)', 'America/Mazatlan'),
(11, NULL, NULL, '(UTC-07:00)', 'US/Mountain'),
(12, NULL, NULL, '(UTC-06:00)', 'America/Managua'),
(13, NULL, NULL, '(UTC-06:00)', 'US/Central'),
(14, NULL, NULL, '(UTC-06:00)', 'America/Mexico_City'),
(15, NULL, NULL, '(UTC-06:00)', 'America/Mexico_City'),
(16, NULL, NULL, '(UTC-06:00)', 'America/Monterrey'),
(17, NULL, NULL, '(UTC-06:00)', 'Canada/Saskatchewan'),
(18, NULL, NULL, '(UTC-05:00)', 'America/Bogota'),
(19, NULL, NULL, '(UTC-05:00)', 'US/Eastern'),
(20, NULL, NULL, '(UTC-05:00)', 'US/East-Indiana'),
(21, NULL, NULL, '(UTC-05:00)', 'America/Lima'),
(22, NULL, NULL, '(UTC-05:00)', 'America/Bogota'),
(23, NULL, NULL, '(UTC-04:00)', 'Canada/Atlantic'),
(24, NULL, NULL, '(UTC-04:30)', 'America/Caracas'),
(25, NULL, NULL, '(UTC-04:00)', 'America/La_Paz'),
(26, NULL, NULL, '(UTC-04:00)', 'America/Santiago'),
(27, NULL, NULL, '(UTC-03:30)', 'Canada/Newfoundland'),
(28, NULL, NULL, '(UTC-03:00)', 'America/Sao_Paulo'),
(29, NULL, NULL, '(UTC-03:00)', 'America/Argentina/Buenos_Aires'),
(30, NULL, NULL, '(UTC-03:00)', 'America/Argentina/Buenos_Aires'),
(31, NULL, NULL, '(UTC-03:00)', 'America/Godthab'),
(32, NULL, NULL, '(UTC-02:00)', 'America/Noronha'),
(33, NULL, NULL, '(UTC-01:00)', 'Atlantic/Azores'),
(34, NULL, NULL, '(UTC-01:00)', 'Atlantic/Cape_Verde'),
(35, NULL, NULL, '(UTC+00:00)', 'Africa/Casablanca'),
(36, NULL, NULL, '(UTC+00:00)', 'Europe/London'),
(37, NULL, NULL, '(UTC+00:00)', 'Etc/Greenwich'),
(38, NULL, NULL, '(UTC+00:00)', 'Europe/Lisbon'),
(39, NULL, NULL, '(UTC+00:00)', 'Europe/London'),
(40, NULL, NULL, '(UTC+00:00)', 'Africa/Monrovia'),
(41, NULL, NULL, '(UTC+00:00)', 'UTC'),
(42, NULL, NULL, '(UTC+01:00)', 'Europe/Amsterdam'),
(43, NULL, NULL, '(UTC+01:00)', 'Europe/Belgrade'),
(44, NULL, NULL, '(UTC+01:00)', 'Europe/Berlin'),
(45, NULL, NULL, '(UTC+01:00)', 'Europe/Berlin'),
(46, NULL, NULL, '(UTC+01:00)', 'Europe/Bratislava'),
(47, NULL, NULL, '(UTC+01:00)', 'Europe/Brussels'),
(48, NULL, NULL, '(UTC+01:00)', 'Europe/Budapest'),
(49, NULL, NULL, '(UTC+01:00)', 'Europe/Copenhagen'),
(50, NULL, NULL, '(UTC+01:00)', 'Europe/Ljubljana'),
(51, NULL, NULL, '(UTC+01:00)', 'Europe/Madrid'),
(52, NULL, NULL, '(UTC+01:00)', 'Europe/Paris'),
(53, NULL, NULL, '(UTC+01:00)', 'Europe/Prague'),
(54, NULL, NULL, '(UTC+01:00)', 'Europe/Rome'),
(55, NULL, NULL, '(UTC+01:00)', 'Europe/Sarajevo'),
(56, NULL, NULL, '(UTC+01:00)', 'Europe/Skopje'),
(57, NULL, NULL, '(UTC+01:00)', 'Europe/Stockholm'),
(58, NULL, NULL, '(UTC+01:00)', 'Europe/Vienna'),
(59, NULL, NULL, '(UTC+01:00)', 'Europe/Warsaw'),
(60, NULL, NULL, '(UTC+01:00)', 'Africa/Lagos'),
(61, NULL, NULL, '(UTC+01:00)', 'Europe/Zagreb'),
(62, NULL, NULL, '(UTC+02:00)', 'Europe/Athens'),
(63, NULL, NULL, '(UTC+02:00)', 'Europe/Bucharest'),
(64, NULL, NULL, '(UTC+02:00)', 'Africa/Cairo'),
(65, NULL, NULL, '(UTC+02:00)', 'Africa/Harare'),
(66, NULL, NULL, '(UTC+02:00)', 'Europe/Helsinki'),
(67, NULL, NULL, '(UTC+02:00)', 'Europe/Istanbul'),
(68, NULL, NULL, '(UTC+02:00)', 'Asia/Jerusalem'),
(69, NULL, NULL, '(UTC+02:00)', 'Europe/Helsinki'),
(70, NULL, NULL, '(UTC+02:00)', 'Africa/Johannesburg'),
(71, NULL, NULL, '(UTC+02:00)', 'Europe/Riga'),
(72, NULL, NULL, '(UTC+02:00)', 'Europe/Sofia'),
(73, NULL, NULL, '(UTC+02:00)', 'Europe/Tallinn'),
(74, NULL, NULL, '(UTC+02:00)', 'Europe/Vilnius'),
(75, NULL, NULL, '(UTC+03:00)', 'Asia/Baghdad'),
(76, NULL, NULL, '(UTC+03:00)', 'Asia/Kuwait'),
(77, NULL, NULL, '(UTC+03:00)', 'Europe/Minsk'),
(78, NULL, NULL, '(UTC+03:00)', 'Europe/Moscow'),
(79, NULL, NULL, '(UTC+03:00)', 'Africa/Nairobi'),
(80, NULL, NULL, '(UTC+03:00)', 'Asia/Riyadh'),
(81, NULL, NULL, '(UTC+03:00)', 'Europe/Moscow'),
(82, NULL, NULL, '(UTC+03:00)', 'Europe/Volgograd'),
(83, NULL, NULL, '(UTC+03:30)', 'Asia/Tehran'),
(84, NULL, NULL, '(UTC+04:00)', 'Asia/Muscat'),
(85, NULL, NULL, '(UTC+04:00)', 'Asia/Baku'),
(86, NULL, NULL, '(UTC+04:00)', 'Asia/Muscat'),
(87, NULL, NULL, '(UTC+04:00)', 'Asia/Tbilisi'),
(88, NULL, NULL, '(UTC+04:00)', 'Asia/Yerevan'),
(89, NULL, NULL, '(UTC+04:30)', 'Asia/Kabul'),
(90, NULL, NULL, '(UTC+05:00)', 'Asia/Yekaterinburg'),
(91, NULL, NULL, '(UTC+05:00)', 'Asia/Karachi'),
(92, NULL, NULL, '(UTC+05:00)', 'Asia/Karachi'),
(93, NULL, NULL, '(UTC+05:00)', 'Asia/Tashkent'),
(94, NULL, NULL, '(UTC+05:30)', 'Asia/Calcutta'),
(95, NULL, NULL, '(UTC+05:30)', 'Asia/Kolkata'),
(96, NULL, NULL, '(UTC+05:30)', 'Asia/Calcutta'),
(97, NULL, NULL, '(UTC+05:30)', 'Asia/Calcutta'),
(98, NULL, NULL, '(UTC+05:30)', 'Asia/Calcutta'),
(99, NULL, NULL, '(UTC+05:45)', 'Asia/Katmandu'),
(100, NULL, NULL, '(UTC+06:00)', 'Asia/Almaty'),
(101, NULL, NULL, '(UTC+06:00)', 'Asia/Dhaka'),
(102, NULL, NULL, '(UTC+06:00)', 'Asia/Dhaka'),
(103, NULL, NULL, '(UTC+06:00)', 'Asia/Novosibirsk'),
(104, NULL, NULL, '(UTC+06:30)', 'Asia/Rangoon'),
(105, NULL, NULL, '(UTC+07:00)', 'Asia/Bangkok'),
(106, NULL, NULL, '(UTC+07:00)', 'Asia/Bangkok'),
(107, NULL, NULL, '(UTC+07:00)', 'Asia/Jakarta'),
(108, NULL, NULL, '(UTC+07:00)', 'Asia/Krasnoyarsk'),
(109, NULL, NULL, '(UTC+08:00)', 'Asia/Hong_Kong'),
(110, NULL, NULL, '(UTC+08:00)', 'Asia/Chongqing'),
(111, NULL, NULL, '(UTC+08:00)', 'Asia/Hong_Kong'),
(112, NULL, NULL, '(UTC+08:00)', 'Asia/Irkutsk'),
(113, NULL, NULL, '(UTC+08:00)', 'Asia/Kuala_Lumpur'),
(114, NULL, NULL, '(UTC+08:00)', 'Asia/Manila'),
(115, NULL, NULL, '(UTC+08:00)', 'Australia/Perth'),
(116, NULL, NULL, '(UTC+08:00)', 'Asia/Singapore'),
(117, NULL, NULL, '(UTC+08:00)', 'Asia/Taipei'),
(118, NULL, NULL, '(UTC+08:00)', 'Asia/Ulan_Bator'),
(119, NULL, NULL, '(UTC+08:00)', 'Asia/Urumqi'),
(120, NULL, NULL, '(UTC+09:00)', 'Asia/Tokyo'),
(121, NULL, NULL, '(UTC+09:00)', 'Asia/Tokyo'),
(122, NULL, NULL, '(UTC+09:00)', 'Asia/Seoul'),
(123, NULL, NULL, '(UTC+09:00)', 'Asia/Tokyo'),
(124, NULL, NULL, '(UTC+09:00)', 'Asia/Yakutsk'),
(125, NULL, NULL, '(UTC+09:30)', 'Australia/Adelaide'),
(126, NULL, NULL, '(UTC+09:30)', 'Australia/Darwin'),
(127, NULL, NULL, '(UTC+10:00)', 'Australia/Brisbane'),
(128, NULL, NULL, '(UTC+10:00)', 'Australia/Canberra'),
(129, NULL, NULL, '(UTC+10:00)', 'Pacific/Guam'),
(130, NULL, NULL, '(UTC+10:00)', 'Australia/Hobart'),
(131, NULL, NULL, '(UTC+10:00)', 'Asia/Magadan'),
(132, NULL, NULL, '(UTC+10:00)', 'Australia/Melbourne'),
(133, NULL, NULL, '(UTC+10:00)', 'Pacific/Port_Moresby'),
(134, NULL, NULL, '(UTC+10:00)', 'Australia/Sydney'),
(135, NULL, NULL, '(UTC+10:00)', 'Asia/Vladivostok'),
(136, NULL, NULL, '(UTC+12:00)', 'Pacific/Auckland'),
(137, NULL, NULL, '(UTC+12:00)', 'Pacific/Fiji'),
(138, NULL, NULL, '(UTC+12:00)', 'Pacific/Kwajalein'),
(139, NULL, NULL, '(UTC+12:00)', 'Asia/Kamchatka'),
(140, NULL, NULL, '(UTC+12:00).', 'Pacific/Fiji'),
(141, NULL, NULL, '(UTC+12:00)', 'Asia/Magadan'),
(142, NULL, NULL, '(UTC+12:00).', 'Asia/Magadan'),
(143, NULL, NULL, '(UTC+12:00)', 'Pacific/Auckland'),
(144, NULL, NULL, '(UTC+13:00)', 'Pacific/Tongatapu');

-- --------------------------------------------------------

--
-- Table structure for table `hris_training_sessions`
--

DROP TABLE IF EXISTS `hris_training_sessions`;
CREATE TABLE IF NOT EXISTS `hris_training_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_id` bigint(20) NOT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci,
  `scheduled_time` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `assignment_due_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attendance_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `training_cert_required` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hris_workshift_assignments`
--

DROP TABLE IF EXISTS `hris_workshift_assignments`;
CREATE TABLE IF NOT EXISTS `hris_workshift_assignments` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` bigint(20) NOT NULL,
  `workshift_id` bigint(20) NOT NULL,
  `date_from` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_to` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hris_workshift_assignments`
--

INSERT INTO `hris_workshift_assignments` (`id`, `employee_id`, `workshift_id`, `date_from`, `date_to`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, 4, '20200824', '20201124', 0, '2020-08-24 02:06:14', '2020-08-24 18:08:17'),
(2, 2, 3, '2020-08-24', '2020-11-24', 0, '2020-08-24 02:06:14', '2020-08-24 02:06:14'),
(3, 3, 2, '2020-08-24', '2020-11-24', 0, '2020-08-24 02:06:14', '2020-08-24 02:06:14'),
(4, 3, 2, '2020-08-24', '2020-11-24', 0, '2020-08-24 02:06:14', '2020-08-24 02:06:14'),
(5, 7, 4, '20200824', '20201231', 0, '2020-08-24 18:09:08', '2020-08-24 18:12:14'),
(6, 6, 4, '20200824', '20201231', 0, '2020-08-24 18:11:55', '2020-08-24 18:11:55'),
(7, 9, 4, '20200824', '20201231', 0, '2020-08-24 18:12:34', '2020-08-24 18:12:34'),
(8, 8, 4, '20200824', '20201231', 0, '2020-08-24 18:13:15', '2020-08-24 18:13:15');

-- --------------------------------------------------------

--
-- Table structure for table `hris_work_shift_managements`
--

DROP TABLE IF EXISTS `hris_work_shift_managements`;
CREATE TABLE IF NOT EXISTS `hris_work_shift_managements` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `workshift_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `monday_shift` int(11) DEFAULT '0',
  `monday_time_in` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `monday_time_out` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `tuesday_shift` int(11) DEFAULT '0',
  `tuesday_time_in` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `tuesday_time_out` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `wednesday_shift` int(11) DEFAULT '0',
  `wednesday_time_in` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `wednesday_time_out` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `thursday_shift` int(11) DEFAULT '0',
  `thursday_time_in` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `thursday_time_out` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `friday_shift` int(11) DEFAULT '0',
  `friday_time_in` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `friday_time_out` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `saturday_shift` int(11) DEFAULT '0',
  `saturday_time_in` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `saturday_time_out` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `sunday_shift` int(11) DEFAULT '0',
  `sunday_time_in` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `sunday_time_out` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hris_work_shift_managements`
--

INSERT INTO `hris_work_shift_managements` (`id`, `workshift_name`, `monday_shift`, `monday_time_in`, `monday_time_out`, `tuesday_shift`, `tuesday_time_in`, `tuesday_time_out`, `wednesday_shift`, `wednesday_time_in`, `wednesday_time_out`, `thursday_shift`, `thursday_time_in`, `thursday_time_out`, `friday_shift`, `friday_time_in`, `friday_time_out`, `saturday_shift`, `saturday_time_in`, `saturday_time_out`, `sunday_shift`, `sunday_time_in`, `sunday_time_out`, `created_at`, `updated_at`) VALUES
(1, 'Workshift 608', 1, '0600', '1500', 1, '0600', '1500', 1, '0600', '1500', 1, '0600', '1500', 1, '0600', '1500', 0, '0000', '0000', 0, '0000', '0000', '2020-08-24 02:06:14', '2020-08-24 23:38:14'),
(2, 'Workshift 470', 1, '0830', '1830', 1, '0830', '1830', 1, '0830', '1830', 1, '0830', '1830', 1, '0830', '1830', 0, '0000', '0000', 0, '0000', '0000', '2020-08-24 02:06:14', '2020-08-24 18:02:35'),
(3, 'Workshift 545', 1, '0900', '1800', 1, '0900', '1800', 1, '0900', '1800', 1, '0900', '1800', 1, '0500', '1800', 0, '0000', '0000', 0, '0000', '0000', '2020-08-24 02:06:14', '2020-08-24 18:03:16'),
(4, 'Workshift 652', 1, '0800', '1700', 1, '0800', '1700', 1, '0800', '1700', 1, '0800', '1700', 1, '0800', '1700', 0, '0000', '0000', 0, '0000', '0000', '2020-08-24 02:06:14', '2020-08-24 18:03:51');

-- --------------------------------------------------------

--
-- Table structure for table `hris_work_weeks`
--

DROP TABLE IF EXISTS `hris_work_weeks`;
CREATE TABLE IF NOT EXISTS `hris_work_weeks` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `day` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `iad_audit_correctives`
--

DROP TABLE IF EXISTS `iad_audit_correctives`;
CREATE TABLE IF NOT EXISTS `iad_audit_correctives` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `property_id` bigint(255) NOT NULL,
  `reference_number` varchar(255) NOT NULL,
  `major_count` int(10) NOT NULL DEFAULT '0',
  `minor_count` int(10) NOT NULL DEFAULT '0',
  `note_count` int(10) NOT NULL DEFAULT '0',
  `attachments` varchar(10000) DEFAULT NULL,
  `created_by` bigint(255) NOT NULL,
  `account_mode` varchar(255) NOT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `iad_audit_correctives_auditees`
--

DROP TABLE IF EXISTS `iad_audit_correctives_auditees`;
CREATE TABLE IF NOT EXISTS `iad_audit_correctives_auditees` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `corrective_id` bigint(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `iad_audit_correctives_findings`
--

DROP TABLE IF EXISTS `iad_audit_correctives_findings`;
CREATE TABLE IF NOT EXISTS `iad_audit_correctives_findings` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `corrective_id` bigint(255) NOT NULL,
  `findings_key` varchar(255) NOT NULL,
  `findings` varchar(255) NOT NULL,
  `covered_period` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `sub_category` varchar(255) NOT NULL,
  `complied` int(10) DEFAULT NULL,
  `classification` varchar(10) DEFAULT NULL,
  `risks` varchar(1000) DEFAULT NULL,
  `recommendations` varchar(1000) DEFAULT NULL,
  `root_cause` varchar(1000) DEFAULT NULL,
  `correction` varchar(1000) DEFAULT NULL,
  `corrective_action` varchar(255) DEFAULT NULL,
  `timeline` varchar(255) DEFAULT NULL,
  `responsible_party` varchar(1000) DEFAULT NULL,
  `verification_date` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `incident_reports`
--

DROP TABLE IF EXISTS `incident_reports`;
CREATE TABLE IF NOT EXISTS `incident_reports` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `unit_id` int(255) NOT NULL,
  `incident_date` varchar(255) NOT NULL,
  `incident_time` varchar(255) NOT NULL,
  `remarks` varchar(250) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `service` varchar(20) NOT NULL,
  `severity_level` varchar(255) NOT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `labor_cost`
--

DROP TABLE IF EXISTS `labor_cost`;
CREATE TABLE IF NOT EXISTS `labor_cost` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `prospect_id` bigint(255) NOT NULL,
  `night_shift_personnel` int(20) DEFAULT '1',
  `rounded_up_total` varchar(255) DEFAULT NULL,
  `proposal_category` varchar(255) NOT NULL,
  `created_by` bigint(255) NOT NULL,
  `created_by_account_mode` varchar(255) NOT NULL,
  `updated_by` bigint(255) DEFAULT NULL,
  `updated_by_account_mode` varchar(255) DEFAULT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  `parent_version` bigint(255) DEFAULT NULL,
  `version` int(10) NOT NULL DEFAULT '1',
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `labor_cost_outsource`
--

DROP TABLE IF EXISTS `labor_cost_outsource`;
CREATE TABLE IF NOT EXISTS `labor_cost_outsource` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `prospect_id` bigint(255) NOT NULL,
  `night_shift_personnel` int(10) NOT NULL DEFAULT '1',
  `total_montly_labor_cost` varchar(255) DEFAULT NULL,
  `round_up_total` varchar(255) DEFAULT NULL,
  `labor_cost_category` varchar(255) DEFAULT NULL,
  `created_by` bigint(255) NOT NULL,
  `created_by_account_mode` varchar(255) NOT NULL,
  `updated_by` bigint(255) DEFAULT NULL,
  `updated_by_account_mode` varchar(255) DEFAULT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  `parent_version` bigint(255) DEFAULT '0',
  `version` int(10) NOT NULL DEFAULT '1',
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `labor_cost_outsource_positions`
--

DROP TABLE IF EXISTS `labor_cost_outsource_positions`;
CREATE TABLE IF NOT EXISTS `labor_cost_outsource_positions` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `labor_cost_id` bigint(255) NOT NULL,
  `position_id` bigint(255) NOT NULL,
  `basic_salary` varchar(255) NOT NULL,
  `allowance` varchar(255) DEFAULT NULL,
  `vl_sl` varchar(255) DEFAULT NULL,
  `night_shift` int(10) DEFAULT '0',
  `nd` varchar(255) DEFAULT NULL,
  `total_compensation` varchar(255) DEFAULT NULL,
  `total_gmb` varchar(255) DEFAULT NULL,
  `total_cib` varchar(255) DEFAULT NULL,
  `sub_total` varchar(255) DEFAULT NULL,
  `admin_overhead` varchar(255) DEFAULT NULL,
  `montly_labor_cost` varchar(255) NOT NULL,
  `rounded_up_total` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `labor_cost_positions`
--

DROP TABLE IF EXISTS `labor_cost_positions`;
CREATE TABLE IF NOT EXISTS `labor_cost_positions` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `labor_cost_id` bigint(255) NOT NULL,
  `position_id` bigint(255) NOT NULL,
  `basic_salary` varchar(255) DEFAULT NULL,
  `allowance` varchar(255) DEFAULT NULL,
  `vl_sl` varchar(255) DEFAULT NULL,
  `night_shift` int(10) DEFAULT '0',
  `nd` varchar(255) DEFAULT NULL,
  `monthly_labor_cost` varchar(255) DEFAULT NULL,
  `refief_pool` varchar(255) DEFAULT NULL,
  `total_compensation` varchar(255) DEFAULT NULL,
  `total_gmb` varchar(255) DEFAULT NULL,
  `total_cib` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  `rounded_up_total` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mail_logs`
--

DROP TABLE IF EXISTS `mail_logs`;
CREATE TABLE IF NOT EXISTS `mail_logs` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `reference_number` varchar(255) NOT NULL,
  `date_received` varchar(255) NOT NULL,
  `addressee` varchar(1000) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `date_sent` varchar(255) NOT NULL,
  `remarks` varchar(1000) DEFAULT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6031 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(5963, '2019_08_19_000000_create_failed_jobs_table', 3),
(5964, '2020_05_12_062039_create_hris_job_positions_table', 3),
(5965, '2020_05_12_101012_create_hris_employment_types_table', 3),
(5966, '2020_05_12_125243_create_hris_education_levels_table', 3),
(5967, '2020_05_12_132321_create_hris_benefits_table', 3),
(5968, '2020_05_12_132352_create_hris_experience_levels_table', 3),
(5969, '2020_05_12_132406_create_hris_job_functions_table', 3),
(5970, '2020_05_13_080745_create_hris_candidates_table', 3),
(5971, '2020_05_14_224546_create_hris_countries_table', 3),
(5972, '2020_05_16_114513_create_hris_currencies_table', 3),
(5973, '2020_05_19_123228_create_hris_time_zones_table', 3),
(5974, '2020_05_19_153006_create_hris_company_structures_table', 3),
(5975, '2020_05_20_062211_create_hris_job_titles_table', 3),
(5976, '2020_05_20_071646_create_hris_pay_grades_table', 3),
(5977, '2020_05_20_074746_create_hris_employment_statuses_table', 3),
(5978, '2020_05_20_083100_create_hris_skills_table', 3),
(5979, '2020_05_20_090313_create_hris_educations_table', 3),
(5980, '2020_05_20_092404_create_hris_certifications_table', 3),
(5981, '2020_05_20_092421_create_hris_languages_table', 3),
(5982, '2020_05_20_094308_create_hris_courses_table', 3),
(5983, '2020_05_20_095332_create_hris_employee_training_sessions_table', 3),
(5984, '2020_05_20_095353_create_hris_training_sessions_table', 3),
(5985, '2020_05_21_040633_create_hris_clients_table', 3),
(5986, '2020_05_21_040649_create_hris_projects_table', 3),
(5987, '2020_05_21_070032_create_hris_expenses_categories_table', 3),
(5988, '2020_05_21_070114_create_hris_payment_methods_table', 3),
(5989, '2020_05_21_070143_create_hris_employee_expenses_table', 3),
(5990, '2020_05_25_011850_create_hris_leave_groups_table', 3),
(5991, '2020_05_28_120208_create_hris_leave_group_employees_table', 3),
(5992, '2020_05_28_134140_create_hris_work_weeks_table', 3),
(5993, '2020_05_28_141510_create_hris_leave_periods_table', 3),
(5994, '2020_05_28_150514_create_hris_holidays_table', 3),
(5995, '2020_05_28_170915_create_hris_leave_types_table', 3),
(5996, '2020_05_29_123103_create_hris_time_projects_table', 3),
(692, '2020_06_22_221435_create_hris_notifs_table', 2),
(5997, '2020_05_29_135031_create_hris_attendances_table', 3),
(5998, '2020_05_29_155839_create_hris_time_sheets_table', 3),
(5999, '2020_05_29_165722_create_hris_attendance_sheets_table', 3),
(6000, '2020_06_02_153728_create_hris_overtime_categories_table', 3),
(6001, '2020_06_02_155448_create_hris_employees_table', 3),
(6002, '2020_06_02_175737_create_hris_employee_loans_table', 3),
(6003, '2020_06_02_182927_create_hris_company_loan_types_table', 3),
(6004, '2020_06_04_162629_create_hris_work_shift_managements_table', 3),
(6005, '2020_06_07_161617_create_hris_workshift_assignments_table', 3),
(6006, '2020_06_08_171341_create_hris_employee_skills_table', 3),
(6007, '2020_06_08_171403_create_hris_employee_educations_table', 3),
(6008, '2020_06_08_171434_create_hris_employee_certifications_table', 3),
(6009, '2020_06_08_171450_create_hris_employee_languages_table', 3),
(6010, '2020_06_09_104334_create_hris_employee_dependents_table', 3),
(6011, '2020_06_09_112013_create_hris_emergency_contacts_table', 3),
(6012, '2020_06_09_195233_create_hris_employee_projects_table', 3),
(6013, '2020_06_09_200550_create_hris_leave_rules_table', 3),
(6014, '2020_06_09_213841_create_hris_paid_time_offs_table', 3),
(6015, '2020_06_10_121201_create_hris_company_asset_types_table', 3),
(6016, '2020_06_10_121225_create_hris_company_assets_table', 3),
(6017, '2020_06_10_192005_create_hris_overtimes_table', 3),
(6018, '2020_06_11_143624_create_hris_system_logs_table', 3),
(6019, '2020_06_14_130943_create_hris_departments_table', 3),
(6020, '2020_06_16_154828_create_hris_company_documents_table', 3),
(6021, '2020_06_17_031010_create_hris_document_types_table', 3),
(6022, '2020_06_17_131138_create_hris_employee_documents_table', 3),
(6023, '2020_06_22_225336_create_hris_notifs_table', 3),
(6024, '2020_06_23_193835_create_notifications_table', 3),
(6025, '2020_06_24_191555_create_hris_itenerary_requests_table', 3),
(6026, '2020_06_29_045821_create_hris_daily_time_records_table', 3),
(6027, '2020_06_29_124613_create_hris_leaves_table', 3),
(6028, '2020_07_22_155356_create_hris_overtime_types_table', 3),
(6029, '2020_08_21_182014_create_hris_leave_entitlements_table', 3),
(6030, '2020_06_24_191555_create_hris_itinerary_requests_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `minutes_of_meetings`
--

DROP TABLE IF EXISTS `minutes_of_meetings`;
CREATE TABLE IF NOT EXISTS `minutes_of_meetings` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `department_id` int(255) DEFAULT NULL,
  `property_id` varchar(250) DEFAULT NULL,
  `date_reserve` varchar(255) NOT NULL,
  `time_to` varchar(255) NOT NULL,
  `time_from` varchar(255) NOT NULL,
  `venue` varchar(500) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `type_of_meeting` varchar(255) NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `order_by` varchar(255) NOT NULL,
  `prepared_by` varchar(255) NOT NULL,
  `reviewed_by` varchar(255) NOT NULL,
  `approved_by` varchar(255) NOT NULL,
  `mom_category` varchar(20) NOT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mom_action_plan`
--

DROP TABLE IF EXISTS `mom_action_plan`;
CREATE TABLE IF NOT EXISTS `mom_action_plan` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `mom_id` int(250) NOT NULL,
  `details` varchar(1000) NOT NULL,
  `action_plan_status` varchar(255) NOT NULL,
  `responsible_party` varchar(255) NOT NULL,
  `due_date` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mom_attendees`
--

DROP TABLE IF EXISTS `mom_attendees`;
CREATE TABLE IF NOT EXISTS `mom_attendees` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `mom_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `move_inout_requests`
--

DROP TABLE IF EXISTS `move_inout_requests`;
CREATE TABLE IF NOT EXISTS `move_inout_requests` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `sub_property_id` bigint(255) NOT NULL,
  `request` varchar(250) NOT NULL,
  `date` varchar(250) NOT NULL,
  `quantity` varchar(250) DEFAULT NULL,
  `person_material` varchar(255) DEFAULT NULL,
  `unit` varchar(250) NOT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `status` varchar(250) NOT NULL,
  `temp_del` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `move_inout_request_item`
--

DROP TABLE IF EXISTS `move_inout_request_item`;
CREATE TABLE IF NOT EXISTS `move_inout_request_item` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `move_inout_id` int(255) NOT NULL,
  `item_no` varchar(255) NOT NULL,
  `item_description` varchar(1000) NOT NULL,
  `code` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nni`
--

DROP TABLE IF EXISTS `nni`;
CREATE TABLE IF NOT EXISTS `nni` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `prospect_id` int(20) NOT NULL,
  `labor_cost_breakdown` varchar(500) DEFAULT NULL,
  `detailed_scope_of_work` varchar(500) DEFAULT NULL,
  `nni_attachment` varchar(500) DEFAULT NULL,
  `ntp_attachment` varchar(500) DEFAULT NULL,
  `signed_notice_to_proceed` int(4) DEFAULT '0',
  `remarks` varchar(255) NOT NULL,
  `assigned` bigint(255) DEFAULT NULL,
  `status` int(30) DEFAULT '0',
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nni_cad`
--

DROP TABLE IF EXISTS `nni_cad`;
CREATE TABLE IF NOT EXISTS `nni_cad` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `nni_id` int(20) NOT NULL,
  `property_administration` varchar(255) DEFAULT NULL,
  `revenue_allocation` varchar(255) DEFAULT NULL,
  `terms` varchar(255) DEFAULT NULL,
  `term_option` varchar(255) DEFAULT NULL,
  `revenue_amount` varchar(255) DEFAULT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nni_cad_tab`
--

DROP TABLE IF EXISTS `nni_cad_tab`;
CREATE TABLE IF NOT EXISTS `nni_cad_tab` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `nni_id` bigint(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `user_id` bigint(255) DEFAULT NULL,
  `account_mode` varchar(255) DEFAULT NULL,
  `assigned` bigint(255) DEFAULT NULL,
  `vat` int(30) NOT NULL DEFAULT '0',
  `labor_cost` varchar(255) DEFAULT NULL,
  `labor_cost_outsource` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nni_hr`
--

DROP TABLE IF EXISTS `nni_hr`;
CREATE TABLE IF NOT EXISTS `nni_hr` (
  `id` bigint(250) NOT NULL AUTO_INCREMENT,
  `nni_id` int(20) NOT NULL,
  `manpower_plantilla` varchar(255) DEFAULT NULL,
  `head_count` varchar(250) DEFAULT '0',
  `budget_base_pay` varchar(255) DEFAULT NULL,
  `budget_allowance` varchar(255) DEFAULT NULL,
  `total_compensation` varchar(255) DEFAULT NULL,
  `total_gmb` varchar(255) DEFAULT NULL,
  `total_cib` varchar(255) DEFAULT NULL,
  `total_lc` varchar(255) DEFAULT NULL,
  `deployment_date` varchar(250) DEFAULT NULL,
  `special_qualification` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `origin` varchar(255) DEFAULT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nni_hr_tab`
--

DROP TABLE IF EXISTS `nni_hr_tab`;
CREATE TABLE IF NOT EXISTS `nni_hr_tab` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `nni_id` bigint(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `user_id` bigint(255) DEFAULT NULL,
  `account_mode` varchar(255) DEFAULT NULL,
  `assigned` bigint(255) DEFAULT NULL,
  `budget_total` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nni_it`
--

DROP TABLE IF EXISTS `nni_it`;
CREATE TABLE IF NOT EXISTS `nni_it` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `nni_id` int(20) NOT NULL,
  `server_access` varchar(250) DEFAULT NULL,
  `webpage_access` int(2) NOT NULL DEFAULT '0',
  `my_fpd` int(2) NOT NULL DEFAULT '0',
  `fpd_nexus` int(2) NOT NULL DEFAULT '0',
  `acumatica` int(2) NOT NULL DEFAULT '0',
  `status` int(20) DEFAULT NULL,
  `assigned` bigint(255) DEFAULT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nni_it_staffs`
--

DROP TABLE IF EXISTS `nni_it_staffs`;
CREATE TABLE IF NOT EXISTS `nni_it_staffs` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `nni_it_id` int(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `server_access` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notice_to_proceed`
--

DROP TABLE IF EXISTS `notice_to_proceed`;
CREATE TABLE IF NOT EXISTS `notice_to_proceed` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `prospect_id` bigint(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `remarks` longtext NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('117d43da-45b0-4b61-852a-eec79f864dad', 'App\\Notifications\\SupervisorNotif', 'App\\hris_employee', 6, '{\"employee_id\":5,\"supervisor_id\":\"6\",\"notif_message\":\"Patrick Badeo Sent an overtime request!\"}', NULL, '2020-08-24 17:57:53', '2020-08-24 17:57:53'),
('c9d9c378-a3e5-452d-a11b-c41a55ae9f82', 'App\\Notifications\\WorkShiftNotif', 'App\\hris_employee', 6, '{\"employee_id\":6,\"notif_message\":\"Isay Castillo Assigned you to a new Work shift!\"}', NULL, '2020-08-24 18:11:55', '2020-08-24 18:11:55'),
('765cd995-7af8-4412-b851-ad506ecf1c21', 'App\\Notifications\\WorkShiftNotif', 'App\\hris_employee', 9, '{\"employee_id\":6,\"notif_message\":\"Isay Castillo Assigned you to a new Work shift!\"}', NULL, '2020-08-24 18:12:34', '2020-08-24 18:12:34'),
('c71dbf29-000b-4815-95a0-84a8d64a35a4', 'App\\Notifications\\WorkShiftNotif', 'App\\hris_employee', 8, '{\"employee_id\":6,\"notif_message\":\"Isay Castillo Assigned you to a new Work shift!\"}', NULL, '2020-08-24 18:13:15', '2020-08-24 18:13:15');

-- --------------------------------------------------------

--
-- Table structure for table `occupants`
--

DROP TABLE IF EXISTS `occupants`;
CREATE TABLE IF NOT EXISTS `occupants` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `lastname` varchar(25) NOT NULL,
  `gender` int(1) NOT NULL,
  `civil_status` int(1) DEFAULT NULL,
  `birthdate` varchar(10) DEFAULT NULL,
  `citizenship_id` bigint(255) NOT NULL DEFAULT '0',
  `relationship_to_tenant` varchar(250) DEFAULT NULL,
  `social_status` varchar(250) DEFAULT NULL,
  `unit_id` bigint(255) NOT NULL,
  `status` int(1) DEFAULT '0',
  `temp_del` int(20) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `on_hand_collection`
--

DROP TABLE IF EXISTS `on_hand_collection`;
CREATE TABLE IF NOT EXISTS `on_hand_collection` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `property_id` bigint(255) NOT NULL,
  `cashier` varchar(255) DEFAULT NULL,
  `status` int(10) DEFAULT '0',
  `attachment` varchar(1000) DEFAULT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `on_hand_collection_bills`
--

DROP TABLE IF EXISTS `on_hand_collection_bills`;
CREATE TABLE IF NOT EXISTS `on_hand_collection_bills` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `collection_id` bigint(255) NOT NULL,
  `denomination` varchar(255) DEFAULT NULL,
  `quantity` int(20) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `on_hand_collection_checks`
--

DROP TABLE IF EXISTS `on_hand_collection_checks`;
CREATE TABLE IF NOT EXISTS `on_hand_collection_checks` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `collection_id` bigint(255) NOT NULL,
  `or_number` varchar(255) DEFAULT NULL,
  `bank` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `on_hand_collection_credit_card`
--

DROP TABLE IF EXISTS `on_hand_collection_credit_card`;
CREATE TABLE IF NOT EXISTS `on_hand_collection_credit_card` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `collection_id` bigint(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `card_type` varchar(255) NOT NULL,
  `date_of_payment` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `on_hand_collection_direct_deposit`
--

DROP TABLE IF EXISTS `on_hand_collection_direct_deposit`;
CREATE TABLE IF NOT EXISTS `on_hand_collection_direct_deposit` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `collection_id` bigint(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `bank` varchar(255) NOT NULL,
  `date_deposited` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `on_hand_collection_totals`
--

DROP TABLE IF EXISTS `on_hand_collection_totals`;
CREATE TABLE IF NOT EXISTS `on_hand_collection_totals` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `collection_id` bigint(255) NOT NULL,
  `total_bills` varchar(255) DEFAULT NULL,
  `total_checks` varchar(255) DEFAULT NULL,
  `total_per_count` varchar(255) DEFAULT NULL,
  `total_to_be_counted_for` varchar(255) DEFAULT NULL,
  `overage_shortage` varchar(255) DEFAULT NULL,
  `others` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `operations_audit_tsa`
--

DROP TABLE IF EXISTS `operations_audit_tsa`;
CREATE TABLE IF NOT EXISTS `operations_audit_tsa` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `prospect_id` bigint(255) NOT NULL DEFAULT '0',
  `property_id` varchar(255) NOT NULL DEFAULT '0',
  `date_of_audit` varchar(255) DEFAULT NULL,
  `date_presented` varchar(255) NOT NULL,
  `summary` text NOT NULL,
  `building_description` text,
  `building_picture` varchar(500) DEFAULT NULL,
  `status` int(30) DEFAULT '0',
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `operations_audit_tsa_as_built_plans`
--

DROP TABLE IF EXISTS `operations_audit_tsa_as_built_plans`;
CREATE TABLE IF NOT EXISTS `operations_audit_tsa_as_built_plans` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `tsa_id` bigint(255) NOT NULL,
  `system_id` bigint(255) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `sheets` varchar(1000) DEFAULT NULL,
  `recommendation` varchar(500) DEFAULT NULL,
  `findings` varchar(255) DEFAULT NULL,
  `prioritization` varchar(255) DEFAULT NULL,
  `prioritization_specify` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `operations_audit_tsa_compliances_and_non_conformances`
--

DROP TABLE IF EXISTS `operations_audit_tsa_compliances_and_non_conformances`;
CREATE TABLE IF NOT EXISTS `operations_audit_tsa_compliances_and_non_conformances` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `tsa_id` bigint(255) NOT NULL,
  `non_conformance` varchar(1000) DEFAULT NULL,
  `status` varchar(1000) DEFAULT NULL,
  `remarks` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `operations_audit_tsa_equipment_manuals`
--

DROP TABLE IF EXISTS `operations_audit_tsa_equipment_manuals`;
CREATE TABLE IF NOT EXISTS `operations_audit_tsa_equipment_manuals` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `tsa_id` bigint(255) NOT NULL,
  `system_id` bigint(255) NOT NULL,
  `contractor` varchar(500) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `submitted_documents` varchar(500) DEFAULT NULL,
  `findings` varchar(255) DEFAULT NULL,
  `prioritization` varchar(255) DEFAULT NULL,
  `prioritization_specify` varchar(1000) DEFAULT NULL,
  `recommendation` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `operations_audit_tsa_fire_safety_and_security`
--

DROP TABLE IF EXISTS `operations_audit_tsa_fire_safety_and_security`;
CREATE TABLE IF NOT EXISTS `operations_audit_tsa_fire_safety_and_security` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `tsa_id` bigint(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `details` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `operations_audit_tsa_fire_safety_and_security_site`
--

DROP TABLE IF EXISTS `operations_audit_tsa_fire_safety_and_security_site`;
CREATE TABLE IF NOT EXISTS `operations_audit_tsa_fire_safety_and_security_site` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `fire_safety_id` bigint(255) NOT NULL,
  `site` varchar(255) DEFAULT NULL,
  `category` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `operations_audit_tsa_fire_safety_and_security_site_location`
--

DROP TABLE IF EXISTS `operations_audit_tsa_fire_safety_and_security_site_location`;
CREATE TABLE IF NOT EXISTS `operations_audit_tsa_fire_safety_and_security_site_location` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `site_id` bigint(255) NOT NULL,
  `category` int(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `capacity` varchar(255) DEFAULT NULL,
  `date_of_last_refill` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `operations_audit_tsa_permit_licences`
--

DROP TABLE IF EXISTS `operations_audit_tsa_permit_licences`;
CREATE TABLE IF NOT EXISTS `operations_audit_tsa_permit_licences` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `tsa_id` bigint(255) NOT NULL,
  `system_id` bigint(255) DEFAULT NULL,
  `particulars` varchar(255) NOT NULL,
  `date_of_issuance` varchar(5000) DEFAULT NULL,
  `findings` varchar(255) DEFAULT NULL,
  `prioritization` varchar(255) DEFAULT NULL,
  `prioritization_specify` varchar(500) DEFAULT NULL,
  `recommendation` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `operations_audit_tsa_safety_inspection_checklist`
--

DROP TABLE IF EXISTS `operations_audit_tsa_safety_inspection_checklist`;
CREATE TABLE IF NOT EXISTS `operations_audit_tsa_safety_inspection_checklist` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `tsa_id` bigint(255) NOT NULL,
  `particulars` varchar(20) DEFAULT NULL,
  `standards` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `remarks` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `operations_audit_tsa_system`
--

DROP TABLE IF EXISTS `operations_audit_tsa_system`;
CREATE TABLE IF NOT EXISTS `operations_audit_tsa_system` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `tsa_id` bigint(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `details` varchar(10000) DEFAULT NULL,
  `notes` varchar(10000) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `operations_audit_tsa_system_locations`
--

DROP TABLE IF EXISTS `operations_audit_tsa_system_locations`;
CREATE TABLE IF NOT EXISTS `operations_audit_tsa_system_locations` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `system_id` bigint(255) NOT NULL,
  `location` varchar(500) DEFAULT NULL,
  `unit` varchar(500) DEFAULT NULL,
  `findings` varchar(255) DEFAULT NULL,
  `findings_specify` varchar(1000) DEFAULT NULL,
  `prioritization` varchar(255) DEFAULT NULL,
  `prioritization_specify` varchar(1000) DEFAULT NULL,
  `recommendation` varchar(5000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `operations_audit_tsa_system_pictures`
--

DROP TABLE IF EXISTS `operations_audit_tsa_system_pictures`;
CREATE TABLE IF NOT EXISTS `operations_audit_tsa_system_pictures` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `system_id` bigint(255) NOT NULL,
  `picture` varchar(500) DEFAULT NULL,
  `findings` varchar(255) DEFAULT NULL,
  `prioritization` varchar(255) DEFAULT NULL,
  `prioritization_specify` varchar(1000) DEFAULT NULL,
  `recommendations` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `operations_audit_tsa_system_units`
--

DROP TABLE IF EXISTS `operations_audit_tsa_system_units`;
CREATE TABLE IF NOT EXISTS `operations_audit_tsa_system_units` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `location_id` bigint(255) NOT NULL,
  `specification_category` varchar(255) NOT NULL,
  `specification` varchar(255) DEFAULT NULL,
  `operational_data` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `operation_permits`
--

DROP TABLE IF EXISTS `operation_permits`;
CREATE TABLE IF NOT EXISTS `operation_permits` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `property_id` bigint(255) NOT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `operation_permits_licences`
--

DROP TABLE IF EXISTS `operation_permits_licences`;
CREATE TABLE IF NOT EXISTS `operation_permits_licences` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `permit_id` bigint(255) NOT NULL,
  `permit_licences_id` bigint(255) NOT NULL,
  `permit_number` varchar(255) DEFAULT NULL,
  `date_issued` varchar(255) DEFAULT NULL,
  `remarks` varchar(1000) DEFAULT NULL,
  `date_submitted` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `other_tasks`
--

DROP TABLE IF EXISTS `other_tasks`;
CREATE TABLE IF NOT EXISTS `other_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` varchar(255) NOT NULL,
  `title` varchar(500) NOT NULL,
  `date` varchar(255) NOT NULL,
  `status` int(20) NOT NULL DEFAULT '0',
  `incharges` varchar(255) NOT NULL,
  `created_by` bigint(255) NOT NULL,
  `account_mode` varchar(255) NOT NULL,
  `attachment` varchar(10000) DEFAULT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `other_task_activities`
--

DROP TABLE IF EXISTS `other_task_activities`;
CREATE TABLE IF NOT EXISTS `other_task_activities` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `other_task_id` int(255) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `remarks_by` bigint(255) DEFAULT NULL,
  `remarks_by_account_mode` varchar(255) DEFAULT NULL,
  `action_taken` varchar(5000) DEFAULT NULL,
  `action_taken_by` bigint(255) DEFAULT NULL,
  `action_taken_by_account_mode` varchar(255) DEFAULT NULL,
  `date` varchar(255) NOT NULL,
  `timeline` varchar(255) NOT NULL,
  `activity_attachment` varchar(1000) DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `permits_and_licences`
--

DROP TABLE IF EXISTS `permits_and_licences`;
CREATE TABLE IF NOT EXISTS `permits_and_licences` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `module` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permits_and_licences`
--

INSERT INTO `permits_and_licences` (`id`, `name`, `module`, `category`, `temp_del`) VALUES
(1, 'Fire Safety Inspection Certificate', 'pre-operation-audit-tsa', NULL, 0),
(2, 'Business Permit', 'pre-operation-audit-tsa', NULL, 0),
(3, 'Sanitary Permit', 'pre-operation-audit-tsa', NULL, 0),
(4, 'Air-Conditioning', 'pre-operation-audit-tsa', NULL, 0),
(5, 'Internal Combustion Engine', 'pre-operation-audit-tsa', NULL, 0),
(6, 'Machinery (Pumps)', 'pre-operation-audit-tsa', NULL, 0),
(7, 'Elevator Certificate', 'pre-operation-audit-tsa', NULL, 0),
(8, 'Electrical Certificate', 'pre-operation-audit-tsa', NULL, 0),
(9, 'Mechanical Certificate', 'pre-operation-audit-tsa', NULL, 0),
(10, 'ERC (Genset)', 'pre-operation-audit-tsa', NULL, 0),
(11, 'Certificate of Occupancy', 'pre-operation-audit-tsa', NULL, 0),
(12, 'ECC', 'pre-operation-audit-tsa', NULL, 0),
(13, 'PTO Genset', 'pre-operation-audit-tsa', NULL, 0),
(14, 'MWSS Certificate of Exemption', 'pre-operation-audit-tsa', NULL, 0),
(15, 'Hazardous Waste Registration Certificate', 'pre-operation-audit-tsa', NULL, 0),
(16, 'Seismograph Installation Certificate', 'pre-operation-audit-tsa', NULL, 0),
(17, 'Business Permit', 'task-permits-and-licences', 'annual', 0),
(18, 'Baranggay Permit', 'task-permits-and-licences', 'annual', 0),
(19, 'FSIC', 'task-permits-and-licences', 'annual', 0),
(20, 'PTO Genset', 'task-permits-and-licences', 'annual', 0),
(21, 'STP Discharge Permit', 'task-permits-and-licences', 'annual', 0),
(22, 'Annual Inspections', 'task-permits-and-licences', 'annual', 0),
(23, 'Registration of Books', 'task-permits-and-licences', 'annual', 0),
(24, 'BIR 0605', 'task-permits-and-licences', 'annual', 0),
(25, 'Income Tax Return', 'task-permits-and-licences', 'annual', 0),
(26, 'Alphalist – 1604E', 'task-permits-and-licences', 'annual', 0),
(27, 'Audited FS', 'task-permits-and-licences', 'annual', 0),
(28, 'General Information Sheet', 'task-permits-and-licences', 'annual', 0),
(29, 'VAT 2550Q', 'task-permits-and-licences', 'quarterly', 0),
(30, 'Real Estate Tax', 'task-permits-and-licences', 'quarterly', 0),
(31, 'SMR (DENR/LLDA)', 'task-permits-and-licences', 'quarterly', 0),
(32, 'Income Tax Return', 'task-permits-and-licences', 'quarterly', 0),
(33, 'Withholding Tax (1601-E)', 'task-permits-and-licences', 'monthly', 0),
(34, 'Percentage Tax (2551 M)', 'task-permits-and-licences', 'monthly', 0),
(35, 'Valued Added Tax (2550 M)', 'task-permits-and-licences', 'monthly', 0);

-- --------------------------------------------------------

--
-- Table structure for table `poa_pad_checklist`
--

DROP TABLE IF EXISTS `poa_pad_checklist`;
CREATE TABLE IF NOT EXISTS `poa_pad_checklist` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `prospect_id` bigint(255) NOT NULL,
  `month` varchar(255) NOT NULL,
  `accounting_assistant` varchar(255) DEFAULT NULL,
  `accounting_supervisor` varchar(255) DEFAULT NULL,
  `building_manager` varchar(255) DEFAULT NULL,
  `checked_by` varchar(255) DEFAULT NULL,
  `noted_by` varchar(255) DEFAULT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `poa_pad_checklist_item`
--

DROP TABLE IF EXISTS `poa_pad_checklist_item`;
CREATE TABLE IF NOT EXISTS `poa_pad_checklist_item` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `pad_checklist_id` bigint(255) NOT NULL,
  `checklist_id` bigint(255) NOT NULL,
  `reference_document` varchar(500) DEFAULT NULL,
  `status` varchar(1000) DEFAULT NULL,
  `remarks` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `poa_pad_pcc`
--

DROP TABLE IF EXISTS `poa_pad_pcc`;
CREATE TABLE IF NOT EXISTS `poa_pad_pcc` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `prospect_id` bigint(255) NOT NULL,
  `pcc_date` varchar(255) NOT NULL,
  `custodian` varchar(255) DEFAULT NULL,
  `amount_of_fund` varchar(255) DEFAULT NULL,
  `total_cash_on_hand` varchar(255) DEFAULT NULL,
  `unreplenished` varchar(255) DEFAULT NULL,
  `unliquidated` varchar(255) DEFAULT NULL,
  `check_replenishment` varchar(255) DEFAULT NULL,
  `total_per_count1` varchar(255) DEFAULT NULL,
  `total_per_count2` varchar(255) DEFAULT NULL,
  `total_per_books` varchar(255) DEFAULT NULL,
  `overage_shortage` varchar(255) DEFAULT NULL,
  `counted_by` varchar(255) DEFAULT NULL,
  `acknowledge_by` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `poa_pad_pcc_cash`
--

DROP TABLE IF EXISTS `poa_pad_pcc_cash`;
CREATE TABLE IF NOT EXISTS `poa_pad_pcc_cash` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `pcc_id` bigint(255) NOT NULL,
  `denomination` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `poa_pad_pcc_certification`
--

DROP TABLE IF EXISTS `poa_pad_pcc_certification`;
CREATE TABLE IF NOT EXISTS `poa_pad_pcc_certification` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `pcc_id` bigint(255) NOT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `counted_by` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `poa_pad_pcc_items`
--

DROP TABLE IF EXISTS `poa_pad_pcc_items`;
CREATE TABLE IF NOT EXISTS `poa_pad_pcc_items` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `pcc_id` bigint(255) NOT NULL,
  `item_id` bigint(255) NOT NULL,
  `status_compliance` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `poa_pad_pcv`
--

DROP TABLE IF EXISTS `poa_pad_pcv`;
CREATE TABLE IF NOT EXISTS `poa_pad_pcv` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `prospect_id` bigint(255) NOT NULL,
  `accounting_supervisor` varchar(255) DEFAULT NULL,
  `pcf_custodian` varchar(255) DEFAULT NULL,
  `building_manager` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `poa_pad_pcv_findings`
--

DROP TABLE IF EXISTS `poa_pad_pcv_findings`;
CREATE TABLE IF NOT EXISTS `poa_pad_pcv_findings` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `particular_id` bigint(255) NOT NULL,
  `legend` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `poa_pad_pcv_particulars`
--

DROP TABLE IF EXISTS `poa_pad_pcv_particulars`;
CREATE TABLE IF NOT EXISTS `poa_pad_pcv_particulars` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `pcv_id` bigint(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `payee` varchar(255) DEFAULT NULL,
  `particulars` varchar(1000) DEFAULT NULL,
  `pcv_no` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `positions_for_project`
--

DROP TABLE IF EXISTS `positions_for_project`;
CREATE TABLE IF NOT EXISTS `positions_for_project` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `position` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `job_grade` varchar(255) DEFAULT NULL,
  `minimum_basic_pay` varchar(255) DEFAULT NULL,
  `maximum_basic_pay` varchar(255) DEFAULT NULL,
  `equivalent_position` varchar(255) DEFAULT NULL,
  `uniform` varchar(255) DEFAULT NULL,
  `office_activities_total` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `positions_for_project`
--

INSERT INTO `positions_for_project` (`id`, `position`, `code`, `job_grade`, `minimum_basic_pay`, `maximum_basic_pay`, `equivalent_position`, `uniform`, `office_activities_total`) VALUES
(1, 'Multi-Skilled Technician I', 'MST I', '1', '13,400.00', '14,700.00', 'Electrician, Aircon Technician, Shift Technician, Carpenter, Carpenter/Plumber/Painter', '580', '600'),
(2, 'Driver I', 'Dr I', '1', '13,400.00', '14,700.00', 'Company Driver, Valet Driver', '486.5', '400'),
(3, 'Equipment Operator I', 'EO I', '1', '13,400.00', '14,700.00', 'BMS Operator, Chiller Tender, BMU Contoller, Powerplant Operator, Genset Operator, STP Operator, Gondola Operator, Lift Attendant', '580', '600'),
(4, 'Messenger I', 'Ms I', '1', '13,400.00', '14,700.00', 'Messenger', '486.5', '400'),
(5, 'Utility Worker I', 'UW I', '1', '13,400.00', '14,700.00', 'Technical Aide/Utility', '486.5', '400'),
(6, 'Parking Attendant I', 'PA I', '1', '13,400.00', '14,700.00', 'Parking Attendant', '486.5', '400'),
(7, 'Parking Cashier I', 'PC I', '1', '13,400.00', '14,700.00', 'none', '486.5', '400'),
(8, 'Multi-Skilled Technician II', 'MST II', '2', '14,700.00', '16,200.00', 'Senior Technician', '580', '600'),
(9, 'Driver II', 'Dr II', '2', '14,700.00', '16,200.00', 'none', '486.5', '400'),
(10, 'Equipment Operator II', 'EO II', '2', '14,700.00', '16,200.00', 'none', '580', '600'),
(11, 'Messenger II', 'Ms II', '2', '14,700.00', '16,200.00', 'none', '486.5', '400'),
(12, 'Utility Worker II', 'UW II', '2', '14,700.00', '16,200.00', 'none', '486.5', '400'),
(13, 'Parking Attendant II', 'PA II', '2', '14,700.00', '16,200.00', 'none', '486.5', '400'),
(14, 'Parking Cashier II', 'PC II', '2', '14,700.00', '16,200.00', 'none', '486.5', '400'),
(15, 'Driver III', 'Dr III', '3', '16,200.00', '18,000.00', 'none', '486.5', '400'),
(16, 'Technical Assistant I', 'TA I', '3', '16,200.00', '18,000.00', 'Technical Assistant', '486.5', '550'),
(17, 'Administrative Assistant I', 'AdA I', '3', '16,200.00', '18,000.00', 'Admin. Assistant, Admin. Staff, Liaison Officer, Safety Clerk', '486.5', '500'),
(18, 'Accounting Assistant I', 'AcA I', '3', '16,200.00', '18,000.00', 'Accounting Assistant', '486.5', '500'),
(19, 'Billing and Collections Assistant I', 'BCA I', '3', '16,200.00', '18,000.00', 'Billing & Collection Clerk, Billing & Colections Assistant', '486.5', '500'),
(20, 'Receptionist I', 'Rc I', '3', '16,200.00', '18,000.00', 'Concierge / Receptionist, Front Desk Clerk', '486.5', '400'),
(21, 'Lead Technician', 'LT I', '3', '16,200.00', '18,000.00', 'Lead Technician, Foreman', '580', '600'),
(22, 'Technical Assistant II', 'TA II', '4', '18,000.00', '20,000.00', 'none', '486.5', '550'),
(23, 'Administrative Assistant II', 'AdA II', '4', '18,000.00', '20,000.00', 'none', '486.5', '500'),
(24, 'Accounting Assistant II', 'AcA II', '4', '18,000.00', '20,000.00', 'none', '486.5', '500'),
(25, 'Billing and Collections Assistant II', 'BCA II', '4', '18,000.00', '20,000.00', 'none', '486.5', '500'),
(26, 'Receptionist II', 'Rc II', '4', '18,000.00', '20,000.00', 'none', '486.5', '500'),
(27, 'Technical Supervisor', 'TS ', '4', '18,000.00', '20,000.00', 'Technical Supervisor', '486.5', '550'),
(28, 'Technical Assistant III', 'TA III', '5', '20,000.00', '22,200.00', 'none', '486.5', '550'),
(29, 'Administrative Assistant III', 'AdA III', '5', '20,000.00', '22,200.00', 'none', '486.5', '500'),
(30, 'Accounting Assistant III', 'AcA III', '5', '20,000.00', '22,200.00', 'none', '486.5', '500'),
(31, 'Billing and Collections Assistant III', 'BCA III', '5', '20,000.00', '22,200.00', 'none', '486.5', '500'),
(32, 'Receptionist III', 'Rc III', '5', '20,000.00', '22,200.00', 'none', '486.5', '550'),
(33, 'Technical Services Coordinator I', 'TSC I', '5', '20,000.00', '22,200.00', 'Technical Services Coordinator', '486.5', '550'),
(34, 'Operations Administrative Supervisor I', 'OAS I', '6', '22,200.00', '25,100.00', 'Administrative Supervisor', '486.5', '1600'),
(35, 'Accounting Officer I', 'AcO I', '6', '22,200.00', '25,100.00', 'none', '486.5', '1600'),
(36, 'Tenants Relations Officer I', 'TRO I', '6', '22,200.00', '25,100.00', 'none', '486.5', '1600'),
(37, 'Building Engineer I', 'BE I', '6', '22,200.00', '25,100.00', 'Building Engineer,  Shift Engineer', '551.5', '1600'),
(38, 'Facilities Engineer I', 'FE I', '6', '22,200.00', '25,100.00', 'Facilities Engineer', '551.5', '1600'),
(39, 'Fit Out Engineer I', 'FOE I', '6', '22,200.00', '25,100.00', 'Fit Out Engineer', '551.5', '1600'),
(40, 'Fit Out Facilitator I', 'FOF I', '6', '22,200.00', '25,100.00', 'Fit Out Facilitator', '551.5', '1600'),
(41, 'Village Engineer I', 'VE I', '6', '22,200.00', '25,100.00', 'Village Engineer', '551.5', '1600'),
(42, 'Safety Inspector I', 'SI I', '6', '22,200.00', '25,100.00', 'Safety Inspector', '486.5', '1600'),
(43, 'Technical Services Coordinator II', 'TSC II', '6', '22,200.00', '25,100.00', 'none', '486.5', '550'),
(44, 'Operations Administrative Supervisor II', 'OAS II', '7', '25,100.00', '28,400.00', 'none', '486.5', '1600'),
(45, 'Accounting Officer II', 'AcO II', '7', '25,100.00', '28,400.00', 'none', '486.5', '1600'),
(46, 'Tenants relations Officer II', 'TRO II', '7', '25,100.00', '28,400.00', 'none', '486.5', '1600'),
(47, 'Building Engineer II', 'BE II', '7', '25,100.00', '28,400.00', 'none', '551.5', '1600'),
(48, 'Facilities Engineer II', 'FE II', '7', '25,100.00', '28,400.00', 'none', '551.5', '1600'),
(49, 'Fit Out Engineer II', 'FOE II', '7', '25,100.00', '28,400.00', 'none', '551.5', '1600'),
(50, 'Fit Out Facilitator II', 'FOF II', '7', '25,100.00', '28,400.00', 'none', '551.5', '1600'),
(51, 'Village Engineer II', 'VE II', '7', '25,100.00', '28,400.00', 'none', '551.5', '1600'),
(52, 'Safety Inspector II', 'SI II', '7', '25,100.00', '28,400.00', 'none', '486.5', '1600'),
(53, 'Technical Services Coordinator III', 'TSC III', '7', '25,100.00', '28,400.00', 'none', '486.5', '550'),
(54, 'Operations Administrative Supervisor III', 'OAS III', '8', '28,400.00', '32,100.00', 'none', '486.5', '1600'),
(55, 'Accounting Officer III', 'AcO III', '8', '28,400.00', '32,100.00', 'none', '486.5', '1600'),
(56, 'Tenants Relations Officer III', 'TRO III', '8', '28,400.00', '32,100.00', 'none', '486.5', '1600'),
(57, 'Building Administrator', 'BA', '8', '28,400.00', '32,100.00', 'none', '585', '1600'),
(58, 'Assistant Building Manager', 'ABM', '8', '28,400.00', '32,100.00', 'none', '585', '1600'),
(59, 'Chief Engineer', 'CE', '8', '28,400.00', '32,100.00', 'Chief Engineer, Engineering Manager', '551.5', '1600'),
(60, 'Building Engineer III', 'BE III', '8', '28,400.00', '32,100.00', 'Senior Building Engineer', '551.5', '1600'),
(61, 'Facilities Engineer III', 'FE III', '8', '28,400.00', '32,100.00', 'none', '551.5', '1600'),
(62, 'Fit Out Engineer III', 'FOE III', '8', '28,400.00', '32,100.00', 'none', '551.5', '1600'),
(63, 'Fit Out Facilitator III', 'FOF III', '8', '28,400.00', '32,100.00', 'none', '551.5', '1600'),
(64, 'Village Engineer III', 'VE III', '8', '28,400.00', '32,100.00', 'none', '551.5', '1600'),
(65, 'Building Manager I', 'BM I', '9', '32,100.00', '37,000.00', 'Building Manager, Night Shift Building Administrator', '585', '1800'),
(66, 'Fit Out Manager I', 'FOM I', '9', '32,100.00', '37,000.00', 'Technical / Fit Out Manager', '585', '1800'),
(67, 'Village Manager I', 'VM I', '9', '32,100.00', '37,000.00', 'Village Manager', '585', '1800'),
(68, 'Tenant Relations Manager I', 'TRM I', '9', '32,100.00', '37,000.00', 'Tenant Relation Manager, Tenants Relations Officer (functioning as BM)', '585', '1800'),
(69, 'Building Manager II', 'BM II', '10', '37,000.00', '43,000.00', 'none', '585', '1800'),
(70, 'Fit Out Manager II', 'FOM II', '10', '37,000.00', '43,000.00', 'none', '585', '1800'),
(71, 'Village Manager II', 'VM II', '10', '37,000.00', '43,000.00', 'none', '585', '1800'),
(72, 'Tenant Relations Manager II', 'TRM II', '10', '37,000.00', '43,000.00', 'none', '585', '1800'),
(73, 'Estate Manager I', 'EM I', '10', '37,000.00', '43,000.00', 'Estate Manager', '585', '1800'),
(74, 'Complex Manager I', 'CM I', '10', '37,000.00', '43,000.00', 'Complex Manager', '585', '1800'),
(75, 'Building Manager III', 'BM III', '11', '43,000.00', '49,000.00', 'none', '585', '1800'),
(76, 'Fit Out Manager III', 'FOM III', '11', '43,000.00', '49,000.00', 'none', '585', '1800'),
(77, 'Village Manager III', 'VM III', '11', '43,000.00', '49,000.00', 'none', '585', '1800'),
(78, 'Tenants Relations Manager III', 'TRM III', '11', '43,000.00', '49,000.00', 'none', '585', '1800'),
(79, 'Estate Manager II', 'EM II', '11', '43,000.00', '49,000.00', 'none', '585', '1800'),
(80, 'Complex Manager II', 'CM II', '11', '43,000.00', '49,000.00', 'none', '585', '1800');

-- --------------------------------------------------------

--
-- Table structure for table `preventive_maintenance`
--

DROP TABLE IF EXISTS `preventive_maintenance`;
CREATE TABLE IF NOT EXISTS `preventive_maintenance` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `sub_property_id` bigint(255) NOT NULL,
  `equipment_id` bigint(255) NOT NULL,
  `employee_id` bigint(255) NOT NULL,
  `frequency` int(10) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `month_of` int(10) DEFAULT NULL,
  `before_picture` varchar(1000) DEFAULT NULL,
  `after_picture` varchar(1000) DEFAULT NULL,
  `preventive_maintenance_status` varchar(255) NOT NULL DEFAULT '0',
  `date` varchar(255) NOT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `preventive_maintenance_activities`
--

DROP TABLE IF EXISTS `preventive_maintenance_activities`;
CREATE TABLE IF NOT EXISTS `preventive_maintenance_activities` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `item_to_check_id` bigint(255) NOT NULL,
  `frequency_code` varchar(500) DEFAULT NULL,
  `is_checked` int(20) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `preventive_maintenance_item_to_check`
--

DROP TABLE IF EXISTS `preventive_maintenance_item_to_check`;
CREATE TABLE IF NOT EXISTS `preventive_maintenance_item_to_check` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `preventive_maintenance_id` bigint(255) NOT NULL,
  `item_to_check` varchar(500) NOT NULL,
  `frequency` int(10) NOT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_operation_audit`
--

DROP TABLE IF EXISTS `pre_operation_audit`;
CREATE TABLE IF NOT EXISTS `pre_operation_audit` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `prospect_id` bigint(255) NOT NULL,
  `auditee` varchar(255) DEFAULT NULL,
  `date_of_audit` varchar(255) NOT NULL,
  `auditors` varchar(255) DEFAULT NULL,
  `department` varchar(255) NOT NULL DEFAULT '',
  `status` int(10) NOT NULL DEFAULT '0',
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_operation_audit_checklist`
--

DROP TABLE IF EXISTS `pre_operation_audit_checklist`;
CREATE TABLE IF NOT EXISTS `pre_operation_audit_checklist` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `audit_id` bigint(255) NOT NULL,
  `checklist_id` bigint(255) NOT NULL,
  `check_status` varchar(255) DEFAULT NULL,
  `color_code` varchar(255) DEFAULT 'warning',
  `compliances` varchar(1000) DEFAULT NULL,
  `actions` varchar(1000) DEFAULT NULL,
  `auditor` bigint(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_operation_audit_tsa`
--

DROP TABLE IF EXISTS `pre_operation_audit_tsa`;
CREATE TABLE IF NOT EXISTS `pre_operation_audit_tsa` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `prospect_id` bigint(255) NOT NULL,
  `date_of_audit` varchar(255) DEFAULT NULL,
  `date_presented` varchar(255) NOT NULL DEFAULT '',
  `summary` text,
  `building_description` text,
  `building_picture` varchar(500) NOT NULL DEFAULT '',
  `status` int(30) DEFAULT '0',
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_operation_audit_tsa_as_built_plans`
--

DROP TABLE IF EXISTS `pre_operation_audit_tsa_as_built_plans`;
CREATE TABLE IF NOT EXISTS `pre_operation_audit_tsa_as_built_plans` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `tsa_id` bigint(255) NOT NULL,
  `system_id` bigint(255) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `sheets_available` varchar(1000) DEFAULT NULL,
  `recommendation` varchar(1000) DEFAULT NULL,
  `findings` varchar(500) DEFAULT NULL,
  `prioritization` varchar(500) DEFAULT NULL,
  `prioritization_specify` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_operation_audit_tsa_compliances`
--

DROP TABLE IF EXISTS `pre_operation_audit_tsa_compliances`;
CREATE TABLE IF NOT EXISTS `pre_operation_audit_tsa_compliances` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `tsa_id` bigint(255) NOT NULL,
  `conformance` varchar(1000) DEFAULT NULL,
  `status` varchar(1000) DEFAULT NULL,
  `remarks` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_operation_audit_tsa_equipment_manuals`
--

DROP TABLE IF EXISTS `pre_operation_audit_tsa_equipment_manuals`;
CREATE TABLE IF NOT EXISTS `pre_operation_audit_tsa_equipment_manuals` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `tsa_id` bigint(255) NOT NULL,
  `system_id` bigint(255) NOT NULL,
  `contractor` varchar(500) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `submitted_documents` varchar(500) DEFAULT NULL,
  `findings` varchar(500) DEFAULT NULL,
  `prioritization` varchar(500) DEFAULT NULL,
  `prioritization_specify` varchar(500) DEFAULT NULL,
  `recommendation` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_operation_audit_tsa_fire_safety_and_security`
--

DROP TABLE IF EXISTS `pre_operation_audit_tsa_fire_safety_and_security`;
CREATE TABLE IF NOT EXISTS `pre_operation_audit_tsa_fire_safety_and_security` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `tsa_id` bigint(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `details` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_operation_audit_tsa_fire_safety_and_security_site`
--

DROP TABLE IF EXISTS `pre_operation_audit_tsa_fire_safety_and_security_site`;
CREATE TABLE IF NOT EXISTS `pre_operation_audit_tsa_fire_safety_and_security_site` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `fire_safety_id` bigint(255) NOT NULL,
  `site` varchar(255) DEFAULT NULL,
  `category` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_operation_audit_tsa_fire_safety_and_security_site_location`
--

DROP TABLE IF EXISTS `pre_operation_audit_tsa_fire_safety_and_security_site_location`;
CREATE TABLE IF NOT EXISTS `pre_operation_audit_tsa_fire_safety_and_security_site_location` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `site_id` bigint(255) NOT NULL,
  `category` int(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `capacity` varchar(255) DEFAULT NULL,
  `date_of_last_refill` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_operation_audit_tsa_permit_licences`
--

DROP TABLE IF EXISTS `pre_operation_audit_tsa_permit_licences`;
CREATE TABLE IF NOT EXISTS `pre_operation_audit_tsa_permit_licences` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `tsa_id` bigint(255) NOT NULL,
  `system_id` bigint(255) NOT NULL,
  `particulars` varchar(255) NOT NULL,
  `date_of_issuance` varchar(5000) DEFAULT NULL,
  `findings` varchar(500) DEFAULT NULL,
  `prioritization` varchar(500) DEFAULT NULL,
  `prioritization_specify` varchar(500) DEFAULT NULL,
  `recommendation` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_operation_audit_tsa_system`
--

DROP TABLE IF EXISTS `pre_operation_audit_tsa_system`;
CREATE TABLE IF NOT EXISTS `pre_operation_audit_tsa_system` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `tsa_id` bigint(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `details` varchar(10000) DEFAULT NULL,
  `notes` varchar(10000) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_operation_audit_tsa_system_locations`
--

DROP TABLE IF EXISTS `pre_operation_audit_tsa_system_locations`;
CREATE TABLE IF NOT EXISTS `pre_operation_audit_tsa_system_locations` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `system_id` bigint(255) NOT NULL,
  `location` varchar(500) DEFAULT NULL,
  `unit` varchar(500) DEFAULT NULL,
  `findings` varchar(255) DEFAULT NULL,
  `findings_specify` varchar(1000) DEFAULT NULL,
  `prioritization` varchar(255) DEFAULT NULL,
  `prioritization_specify` varchar(1000) DEFAULT NULL,
  `remarks` varchar(10000) DEFAULT NULL,
  `recommendation` varchar(5000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_operation_audit_tsa_system_pictures`
--

DROP TABLE IF EXISTS `pre_operation_audit_tsa_system_pictures`;
CREATE TABLE IF NOT EXISTS `pre_operation_audit_tsa_system_pictures` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `system_id` bigint(255) NOT NULL,
  `picture` varchar(500) DEFAULT NULL,
  `findings` varchar(255) DEFAULT NULL,
  `prioritization` varchar(255) DEFAULT NULL,
  `prioritization_specify` varchar(1000) DEFAULT NULL,
  `recommendations` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_operation_audit_tsa_system_units`
--

DROP TABLE IF EXISTS `pre_operation_audit_tsa_system_units`;
CREATE TABLE IF NOT EXISTS `pre_operation_audit_tsa_system_units` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `location_id` bigint(255) NOT NULL,
  `specification_category` varchar(255) NOT NULL,
  `specification` varchar(255) DEFAULT NULL,
  `operational_data` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_operation_checklist`
--

DROP TABLE IF EXISTS `pre_operation_checklist`;
CREATE TABLE IF NOT EXISTS `pre_operation_checklist` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `iso_clause` varchar(255) DEFAULT NULL,
  `reference_document` varchar(500) DEFAULT NULL,
  `item` varchar(1000) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `parent` varchar(255) DEFAULT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=263 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pre_operation_checklist`
--

INSERT INTO `pre_operation_checklist` (`id`, `iso_clause`, `reference_document`, `item`, `category`, `parent`, `temp_del`) VALUES
(1, 'Q (5.2),E (5.2)', 'QEHS Policy', 'Check if the QEHS Policy is posted and understood by all FPD employees including Sub-Con.', 'administration', NULL, 0),
(2, '', 'Preparation of Property Handbook', 'Check if the handbook contains the following documents:', 'administration', NULL, 0),
(3, 'Q (7.5.2)', '-do-', '1. Title Page (to be requested from Operations Assistant)', 'administration', NULL, 0),
(4, 'Q (7.5.2)', '-do-', '2. Record of Amendment (to be requested from QEHS Dept)', 'administration', NULL, 0),
(5, 'Q (7.5.2)', '-do-', '3. Approval Sheet (to be requested from QEHS Dept)', 'administration', NULL, 0),
(6, 'Q (7.5.2)', '-do-', '4. Table of Contents (to be requested from QEHS Dept)', 'administration', NULL, 0),
(7, 'Q (7.5.2)', '-do-', '5. Property Information', 'administration', NULL, 0),
(8, 'Q (7.5.2)', '-do-', '5.1 Property Profile ', 'administration', '7', 0),
(9, 'Q (7.5.2)', '-do-', '5.2 Brochures, Pamplets, and other Marketing collaterals (if applicable)', 'administration', '7', 0),
(10, 'Q (7.5.2)', '-do-', '5.3 Deed of conveyance', 'administration', '7', 0),
(11, 'Q (7.5.2)', '-do-', '5.4 Transfer Certificate Title', 'administration', '7', 0),
(12, 'Q (7.5.2)', '-do-', '6. Masterlist of Unit Owners/Tenants', 'administration', NULL, 0),
(13, 'Q (7.5.2)', '-do-', '7. Property Guidelines', 'administration', NULL, 0),
(14, 'Q (7.5.2)', '-do-', '7.1 House Rules & Regulations', 'administration', '13', 0),
(15, 'Q (8.5.1)', '-do-', '7.2 House Rules & Regulations must have evidence of being official like signatories of BODs and the like', 'administration', '13', 0),
(16, 'Q (7.5.2)', '-do-', '7.3 Fit-Out works/ Renovation Guidelines', 'administration', '13', 0),
(17, 'Q (8.5.1)', '-do-', '7.4 Fit-Out works/ Renovation Guidelines must have evidence of being official like signatories of BODs and the like', 'administration', '13', 0),
(18, 'Q (8.2.2)', '-do-', '7.5 Master Deed and Declaration of Restrictions', 'administration', '13', 0),
(19, 'Q (7.5.2)', '-do-', '7.6 Other Guidelines (if applicable)', 'administration', '13', 0),
(20, 'Q (7.5.2)', '-do-', '8. Property Staffing and Shift Schedules', 'administration', NULL, 0),
(21, 'Q (5.3)', '-do-', '8.1 Organizational Structure', 'administration', '20', 0),
(22, 'Q (8.1)', '-do-', '8.2 Manpower Deployment (reflecting FPD organic, In-house-if applicable, and outsouced) ', 'administration', '20', 0),
(23, 'Q (7.5.2)', '-do-', '9. Checklist of Plans and Drawings', 'administration', NULL, 0),
(24, 'Q (8.5.3)', '-do-', '9.1 Are the plans and drawings kept and stored properly?', 'administration', '23', 0),
(25, 'Q (7.5.2)', '-do-', '10. Masterlist of Equipment Manuals', 'administration', NULL, 0),
(26, 'Q (7.5.3.2)', '-do-', '10.1 Check if the manuals listed in the masterlist is still available and present', 'administration', NULL, 0),
(27, 'Q (7.5.2)', '-do-', '11. Major Equipment Inventory Log', 'administration', NULL, 0),
(28, 'Q (7.5.2)', '-do-', '12. Masterlist of Tools', 'administration', NULL, 0),
(29, 'Q (7.5.2)', '-do-', '13. Condominium Corporation/ Association Documents', 'administration', NULL, 0),
(30, 'Q (7.5.2)', '-do-', 'Registration', 'administration', '29', 0),
(31, 'Q (8.2.2)', '-do-', '13.1 Registration with SEC/HIGC - One time', 'administration', '29', 0),
(32, 'Q (8.2.2)', '-do-', '13.2 Registration with House and Land Use Regulatory Board (HLURB)- One time', 'administration', '29', 0),
(33, 'Q (8.2.2) or Q (7.5.3.2 if no record but SEC registered)', '-do-', '13.3 Articles of Incorporation and By-Laws', 'administration', '29', 0),
(34, 'Q (8.2.2)', '-do-', '13.4 Registration with BIR - One time', 'administration', '29', 0),
(35, 'Q (8.2.2)', '-do-', 'Financials *Updated Annually*', 'administration', '29', 0),
(36, 'Q (8.2.2)', '-do-', '13.5 Latest audited financial statements', 'administration', '29', 0),
(37, 'Q (8.2.2)', '-do-', '13.6 Approved CAPEX & OPEX Budget', 'administration', '29', 0),
(38, 'Q (8.2.2)', '-do-', '13.7  Tax Declaration (Assessment and payment of Real Estate/ Property Tax, Land, Common Area, and Machineries * Updated Annually *)', 'administration', '29', 0),
(39, 'Q (8.2.2)', '-do-', '13.8 Land', 'administration', '29', 0),
(40, 'Q (8.2.2)', '-do-', '13.8 Building/Common Area', 'administration', '29', 0),
(41, 'Q (8.2.2)', '-do-', '13.9 Machineries/ Capital Equipment', 'administration', '29', 0),
(42, 'Q (8.2.2)', '-do-', '14. Documents, Permits, and Licenses', 'administration', NULL, 0),
(43, 'Q (8.2.2)', '-do-', 'Local', 'administration', '42', 0),
(44, 'Q (8.2.2)', '-do-', '14.1 Business Permit - Annual', 'administration', '42', 0),
(45, 'Q (8.2.2)', '-do-', '14.2 Sanitary Permit - Annual', 'administration', '42', 0),
(46, 'Q (8.2.2)', '-do-', '14.3 Building Permit - One Time', 'administration', '42', 0),
(47, 'Q (8.2.2)', '-do-', '14.4 Occupancy Permit - One Time', 'administration', '42', 0),
(48, 'Q (8.2.2)', '-do-', '14.5 Electrical Permit - Annual', 'administration', '42', 0),
(49, 'Q (8.2.2)', '-do-', '14.6 Mechanical Permit - Annual', 'administration', '42', 0),
(50, 'Q (8.2.2)', '-do-', '14.7 Signage Permit - Annual', 'administration', '42', 0),
(51, 'E (6.1.3)', '-do-', '14.8 Permit to Operate Elevator - Annual (as stipulated in the permit must be posted near the machine)', 'administration', '42', 0),
(52, 'E (6.1.3)', '-do-', '14.9 Permit to Operate Escalator - Annual (as stipulated in the permit must be posted near the escalator', 'administration', '42', 0),
(53, 'E (6.1.3)', '-do-', '14.10 Permit to Operate Genset - Annual (as stipulated in the permit must be posted near the Genset', 'administration', '42', 0),
(54, 'E (6.1.3)', '-do-', '14.11 Permit to Operate Airconditioning/ Refrigeration - Annual (as stipulated in the permit must be posted near the Airconditioning/ Refrigeration units)', 'administration', '42', 0),
(55, 'E (6.1.3)', '-do-', '14.12 Permit to Operate Machinery - Annual (as stipulated in the permit must be posted near the pumps / equipment)', 'administration', '42', 0),
(56, 'E (6.1.3)', '-do-', '14.13 Fire Safety Inspection Cert - Annual', 'administration', '42', 0),
(57, 'E (6.1.3)', '-do-', 'National', 'administration', NULL, 0),
(58, 'E (6.1.3)', '-do-', '14.11 DENR/ECC - One Time', 'administration', '42', 0),
(59, 'E (6.1.3)', '-do-', 'DENR APSI - Every 5 Years', 'administration', NULL, 0),
(60, 'E (6.1.3)', '-do-', '14.12 ERC/COC - Every 5 years', 'administration', '42', 0),
(61, 'E (6.1.3)', '-do-', '14.13 Discharge Permit (Check the clearance for the renewal period) /  - If connected to other Treatment Plant, a certificate of sewer connection must be present together with a copy of discharge permit of the Treatment Plant where the a project is connected or a certificate off exemption from DENR.', 'administration', NULL, 0),
(62, 'E (6.1.3)', '-do-', '14.14 If they have haulers, Permit to Transport and Certificate of Treatment of Hauler', 'administration', NULL, 0),
(63, 'E (6.1.3)', '-do-', '14.15 Hazardous Waste ID', 'administration', NULL, 0),
(64, 'Q (7.5.2)', '-do-', '15. Masterlist of Major Service Contracts / Agreements (updated as appropriate)', 'administration', NULL, 0),
(65, 'Q (8.2.2, 7.5.3.2)', '-do-', '15.1 PM Contract Scope of Work', 'administration', '64', 0),
(66, 'Q (7.5.3.2)', '-do-', '15.2 Security Services Contract', 'administration', '64', 0),
(67, 'Q (7.5.3.2)', '-do-', '15.3 Housekeeping Services Contract', 'administration', '64', 0),
(68, 'Q (7.5.3.2)', '-do-', '15.4 Others (i.e. Elevators, Power Center, Genset, Pest Control Service, etc.)', 'administration', '64', 0),
(69, 'Q (7.5.2)', '-do-', '16. Masterlist of Insurance (check the insurance policy / must be updated as appropriate)', 'administration', NULL, 0),
(70, 'Q (8.2.2)', '-do-', '16.1 Current Property Insurance Cover', 'administration', '69', 0),
(71, 'Q (8.2.2)', '-do-', '16.2 Current Comprehensive General Liability Insurance Cover (CGL)', 'administration', '69', 0),
(72, 'Q (8.2.2)', '-do-', 'PM/FM/VM Documentation', 'administration', NULL, 0),
(73, 'Q (7.1)', '-do-', '17. Current Work Program - Annual', 'administration', NULL, 0),
(74, 'Q (7.1.3)', '-do-', '18. Preventive Maintenance Schedule - Annual', 'administration', NULL, 0),
(75, 'Q (7.1.3)', '-do-', '19. Calibration Plan - Annual (only monitoring & measuring devices should be reflected in the plan)', 'administration', NULL, 0),
(76, 'Q (7.5.3.2), E (7.5.2)', '-do-', '20. List of Quality Records - must be updated as appropriate; the list must contain Quality and Environmental records and must state corresponding retention and preservation period', 'administration', NULL, 0),
(77, 'Q (7.5.3.2)\r\nE (7.5.2)', '-do-', '21. List of Legal and Other Requirements. If none, check how they monitor legal compliances.', 'administration', NULL, 0),
(78, 'Q (8.4)', 'Supplier Sub-contractor Accreditation', '1.  Who qualifies Major Service Contractors? Are they conducting bidding?  If not, check document to show that it is known to BOD.', 'administration', NULL, 0),
(79, 'Q (7.2)', '-do-', '2.  Check for the training records of Major Service Contractors', 'administration', NULL, 0),
(80, 'Q (8.4)', '-do-', '3.  Check the Major Service Contractors monthly performance evaluation', 'administration', NULL, 0),
(81, 'Q (7.5.3.2)', 'Records Control Procedure', 'Check the Record Filing System and Indexing', 'administration', NULL, 0),
(82, 'Q (8.5.2)', 'Inventory of Consumable Items and Office Equipment', '1. Check the supplies inventory ledger for office supplies.', 'administration', NULL, 0),
(83, 'Q (8.5.4)', '-do-', '2. Check if the inventory balance is consistent with the actual count', 'administration', NULL, 0),
(84, 'Q (8.5.2)', '-do-', '3. Check if they have office equipment and furnitures tagging.', 'administration', NULL, 0),
(85, 'Q (8.2.1)', 'Preparation of Management Report', 'Check if they have an updated Management Report or what report do they submit to the Board', 'administration', NULL, 0),
(86, 'Q (6.2)', 'Scorecard', 'Check if they are using scorecard.  If yes, check the  results and corrective action done for unattained objectives.', 'administration', NULL, 0),
(87, 'Q (8.5.1)', 'Project Inspection', 'Check the implementation of BM/VM/FM Daily Inspection Activity.  Accomplished daily inspection form must be present.', 'administration', NULL, 0),
(88, 'Q (8.7)', 'Control of Nonconforming Service / Handling of Customer Complaint Request', '1. Check if they have a process to handle complaint or request of clients.', 'administration', NULL, 0),
(89, 'Q (8.7.1)', '-do-', '2. Check how they monitor complaints? ', 'administration', NULL, 0),
(90, 'Q (9.1.3)', '-do-', '3. Check if the complaint received are analyzed and root cause identified.', 'administration', NULL, 0),
(91, 'Q (8.5.1)', '-do-', '4. Check the implementation of Job Order and Work Order.', 'administration', NULL, 0),
(92, 'E (6.1.2)', 'Aspect Impact Assessment Procedure', 'Check if they have List of Aspects and has identified significant aspects based on the given ratings (EHS Assessment).  ', 'administration', NULL, 0),
(93, 'E (6.2.1)', '-do-', 'Check if they have set of Objectives, Targets, and Programs (OTP).  All identified significant aspects must have corresponding OTPs.', 'administration', NULL, 0),
(94, 'E (9.1)', 'Monitoring and Measurement Procedure', 'Check the monitoring process of all significant  aspects with corresponding OTPs, i.e. result of genset emission  test, water and electric consumption, etc.', 'administration', NULL, 0),
(95, 'E (6.1.3)', 'Pollution Control Officer', 'Check if they have an appointed PCO and accreditation status', 'administration', NULL, 0),
(96, 'E (6.1.3)', '-do-', 'Check if PCO has complied with/submitted the following as per DAO 2014-2:', 'administration', NULL, 0),
(247, 'E (7.5)', '-do-', '2. Hazardous Waste Monitoring Form', 'administration', '98', 0),
(97, 'E (7.4)', 'External & Internal Communication Procedure', 'Check the communication process of quality and environmental program within the project (ex. programs, notice of violation/s, etc):\r\n', 'administration', NULL, 0),
(248, 'E (7.5)', '-do-', '3. List of Approved Chemicals', 'administration', '98', 0),
(244, 'E (7.4)', '-do-', '1.  Environmental significant aspects and OTPs must be communicated to all.  Check how this communicated to the Board and unit owners/tenants.', 'administration', '97', 0),
(98, 'E (7.5)', 'Solid Waste Mgt Procedure / Hazardous Waste Management / Air Pollution Control / Energy & Water Conservation', 'Check if they have the following:', 'administration', NULL, 0),
(99, 'E (8.1)', 'Solid Waste Mgt Procedure / Hazardous Waste Management / Air Pollution Control / Energy & Water Conservation', 'Check the implementation of labeled garbage bins and waste segregation at the Admin Office', 'administration', NULL, 0),
(100, 'E (7.1)', 'Solid Waste Mgt Procedure / Hazardous Waste Management / Air Pollution Control / Energy & Water Conservation', 'Check Hazardous Waste Management Storage', 'administration', NULL, 0),
(101, 'E (7.1)', 'Solid Waste Mgt Procedure / Hazardous Waste Management / Air Pollution Control / Energy & Water Conservation', 'Check Solid Waste Segregation/Management', 'administration', NULL, 0),
(102, 'E (8.2)', '-do-', '1. Check if they have Emergency Preparedness Guidelines', 'administration', NULL, 0),
(103, 'E (7.1)', '-do-', '2. Check if they have Emergency Response Team Organizational Structure. Check for their training records.', 'administration', NULL, 0),
(104, 'E (8.2)', '-do-', '3. Check if they have performed the following drills:', 'administration', NULL, 0),
(255, 'E (9.1.2)', 'Compliance Evaluation Procedure / Air Pollution Control', '1. Water Potability Test', 'administration', '106', 0),
(105, 'E (8.1)', 'Quality, Environmental, Health and Safety Policy', 'Check if theres a 5S Committee already and if they are doing 5S Audit.', 'administration', NULL, 0),
(106, 'E (9.1.2)', 'Compliance Evaluation Procedure / Air Pollution Control', 'Check if they have the following records:', 'administration', NULL, 0),
(259, 'E (8.1)', 'Operational Control', '1.1 Spill kits', 'engineering', '118', 0),
(260, 'E (8.1)', 'Operational Control', '1.2 Fire Extinguishers', 'engineering', '118', 0),
(107, 'Q (8.5.3)', 'ISO 9001 Standard', 'If plans and drawings were kept at the engineering section, are they properly kept and stored?', 'engineering', NULL, 0),
(108, 'Q (8.5.3)', 'ISO 9001 Standard', 'If they are keeping an equipment manual as stated in the masterlist of equipment manual, check its availability in the area.', 'engineering', NULL, 0),
(109, 'Q (8.5.4)', 'ISO 9001 Standard', 'If they are keeping tools as stated in the masterlist of tools, it must be available, identified, properly kept, and stored.', 'engineering', NULL, 0),
(110, 'Q (7.1.3)', 'ISO 9001 Standard', 'Do they have communication equipment?  How about the workspace?', 'engineering', NULL, 0),
(111, 'Q (7.1.5)', 'ISO 9001 Standard', 'Check monitoring & measuring devices, it must be available, calibrated, identified, properly kept, and stored', 'engineering', NULL, 0),
(112, 'Q (7.1.3) / E (7.1)', 'Preventive Maintenance Program', '1. Check the consistency of PM schedule vs. the actual conduct of PM (records should be available as evidence). ', 'engineering', NULL, 0),
(113, 'Q (7.1.3) / E (7.1)', 'Preventive Maintenance Program', '2. Check for the updated inspection records of all equipment.', 'engineering', NULL, 0),
(114, 'Q (7.5.3.2)', 'Preventive Maintenance Program', '3. Check the availability of equipment record of all equipment.', 'engineering', NULL, 0),
(115, 'Q (7.1.5) / E (9.1)', 'Preventive Maintenance Program', '4. Check the consistency of Calibration Plan vs. the actual conduct of calibration (calibration or  verification records should be available as evidence).<br>  \r\nNote1: Only the monitoring and measuring devices should be calibrated.<br>\r\nNote2: If the monitoring & measuring equipment is an environment-related equipment<br>\r\nNote3: Calibration must be done every 2 years, or as per advised by TSA.', 'engineering', NULL, 0),
(116, 'Q (8.5.2)', 'Inventory of Consumable Items and Office Equipment', '1. Check the supplies inventory ledger of engineering section.', 'engineering', NULL, 0),
(117, 'Q (8.5.4)', 'Inventory of Consumable Items and Office Equipment', '2. Check if the inventory balance is consistent with the actual count.', 'engineering', NULL, 0),
(118, 'E (8.1)', 'Operational Control', '1.  Check the availability of the following to the appropriate areas:\r\n', 'engineering', NULL, 0),
(119, 'E (8.1)', 'Operational Control', '2. Emergency lights - must be functional', 'engineering', NULL, 0),
(120, 'E (8.1)', 'Operational Control', '3. Fire extinguishers\r\n    - must be inspected monthly', 'engineering', NULL, 0),
(121, 'E (8.1)', 'Operational Control/ Hazardous Waste Mgt.', '4. Hazardous waste area\r\n    - must be properly labeled', 'engineering', NULL, 0),
(122, 'E (8.1)', 'Operational Control/Hazardous Waste Management', '5.  Posted MSDS to areas with chemicals', 'engineering', NULL, 0),
(123, 'E (7.5.3)', 'Operational Control/Hazardous Waste Management', '5.1 Check if all chemicals used were included in the list of approved chemicals.', 'engineering', '122', 0),
(124, 'Legal and Other Reqts.', 'Operational Control/Hazardous Waste Management', '6. 5S', 'engineering', NULL, 0),
(125, 'E (8.1)', 'Operational Control/Solid Waste Management', '7. Labeled garbage bins and waste segregation at the common areas', 'engineering', NULL, 0),
(126, 'E (6.1.3)', 'Operational Control/Solid Waste Management', '1. Permit to Operate (PTO) must be posted near the equipment (see provisions in the permit)', 'engineering', NULL, 0),
(127, 'E (6.1.3)', 'Operational Control/Solid Waste Management', '2.  Installation of Seismograph Recording Instrumenation', 'engineering', NULL, 0),
(128, 'Q (7.1.4)', 'ISO 9001 Standard', 'For those areas with required temperature, check their compliance.', 'engineering', NULL, 0),
(129, 'E (8.1)', 'Operational Control', 'Check the availability of the following to the appropriate areas:', 'housekeeping', NULL, 0),
(262, 'E (8.1)', 'Operational Control', '2.  Fire Extinguishers', 'housekeeping', '129', 0),
(130, 'E (8.1)', 'Operational Control', '2. Posted MSDS to areas with chemicals', 'housekeeping', NULL, 0),
(131, 'E (8.1)', 'Operational Control', '3. 5S', 'housekeeping', NULL, 0),
(132, 'E (8.1)', 'Operational Control/Solid Waste Management', '4. Check the solid waste segregation at the garbage storage room.', 'housekeeping', NULL, 0),
(133, 'E (7.5.3)', 'Operational Control/Hazardous Waste Management', 'Check if all chemicals used were included in the list of approved chemicals.', 'housekeeping', NULL, 0),
(134, 'E (8.2)', 'Operational Control/Hazardous Waste Management', 'Check the use of Incident Investigation Report. (if the format was not utilized, cite it as observation only)', 'security', NULL, 0),
(135, 'E (8.1)', 'Operational Control', 'Check the 5S implementation.', 'security', NULL, 0),
(136, 'E (8.1)', 'Operational Control', 'Check the availability of the following to the appropriate areas: <br> 1. Spill kit <br>2. Fire Extinguishers', 'carpark', NULL, 0),
(137, 'E (8.1)', 'Operational Control', '2. 5S', 'carpark', NULL, 0),
(138, 'E (8.1)', 'Operational Control', '3. Emergency lights - must be functional', 'carpark', NULL, 0),
(139, 'E (8.1)', 'Operational Control', '4. Fire extinguishers - must be inspected monthly', 'carpark', NULL, 0),
(140, 'E (8.1)', 'Operational Control/Solid Waste Management', '5. Labeled garbage bins and waste segregation.', 'carpark', NULL, 0),
(141, 'Q (8.5.5)', 'ISO 9001 Standard', 'Check the implementation of water quality check of swimming pool. It must be supported by monitoring records.', 'swimming pool', NULL, 0),
(142, 'E (8.1)', 'Operational Control', 'Check the availability of the following to the appropriate areas: <br>1. Spill kit on area where the chemicals used in pool were stored. <br>2.  Fire Extinguishers', 'swimming pool', NULL, 0),
(143, 'E (8.1)', 'Operational Control', '2. 5S', 'swimming pool', NULL, 0),
(144, 'E (8.1)', 'Operational Control', '3. Emergency lights - must be functional', 'swimming pool', NULL, 0),
(145, 'E (8.1)', 'Operational Control', '4. Fire extinguishers - must be inspected monthly', 'swimming pool', NULL, 0),
(146, 'E (8.1)', 'Operational Control/Solid Waste Management', '5. Labeled garbage bins and waste segregation.', 'swimming pool', NULL, 0),
(147, 'E (8.1)', 'Operational Control/Hazardous Waste Mgt', '6.  Check the posted MSDS inside the storage area of chemicals.', 'swimming pool', NULL, 0),
(148, 'E (7.5.3)', 'Operational Control/Hazardous Waste Mgt', '7.  Check if  the chemicals used were included in the list of approved chemicals', 'swimming pool', NULL, 0),
(149, '1', NULL, 'Petty Cash Fund (see attached Petty Cash Count Sheet)', 'pad', NULL, 0),
(150, '1.1', NULL, 'No cash overage or shortage in PCF.', 'pad', NULL, 0),
(151, '2', NULL, 'Cash Collection Report', 'pad', NULL, 0),
(152, '2.1', NULL, 'Prepared and submitted daily by Billing & Collection or Admin Assistant.', 'pad', NULL, 0),
(153, '2.2', NULL, 'Reviewed and signed by Building Manager.', 'pad', NULL, 0),
(154, '3', NULL, 'Cash Position Report', 'pad', NULL, 0),
(155, '3.1', NULL, 'Prepared and submitted weekly by Accounting Assistant.', 'pad', NULL, 0),
(156, '3.2', NULL, 'Reviewed and signed by Building Manager.', 'pad', NULL, 0),
(157, '4', NULL, 'Monthly Bank Reconciliation', 'pad', NULL, 0),
(158, '4.1', NULL, 'Done within the 1st week of following month.', 'pad', NULL, 0),
(159, '5', NULL, 'Collection', 'pad', NULL, 0),
(160, '5.1', NULL, 'Collection are deposited intact in the bank on the same day or on the following banking day.', 'pad', NULL, 0),
(161, '5.2', NULL, 'Collection thru checks are named under the Corporation.', 'pad', NULL, 0),
(162, '5.3', NULL, 'OR is signed by cashier, payor and Building Manager.', 'pad', NULL, 0),
(163, '5.4', NULL, 'Machine validated deposit slip is attached in every OR issued.', 'pad', NULL, 0),
(164, '5.5', NULL, 'One OR per DS. Amount in OR is equal to DS.', 'pad', NULL, 0),
(165, '5.6', NULL, 'In case of direct deposit, proof of deposit is attached in OR.', 'pad', NULL, 0),
(166, '5.7', NULL, 'Undeposited collection is not used to defray the Company expenses or to encash personal checks.', 'pad', NULL, 0),
(167, '5.8', NULL, 'Collection of construction bond/security deposit is deposited in bank account of the Corporation separate from operating fund.', 'pad', NULL, 0),
(168, '5.9', NULL, 'In case of check payment for construction bond, photocopy of check is attached to 201 file of the Unit Owner.', 'pad', NULL, 0),
(169, '5.10', NULL, 'Collection efficiency report is submitted monthly to BM.', 'pad', NULL, 0),
(170, '5.11', NULL, 'Cashier is different from the one who maintains the books.', 'pad', NULL, 0),
(171, '5.12', NULL, 'Official receipt is issued for cash payment, dated check and bills payment services.', 'pad', NULL, 0),
(172, '5.13', NULL, 'Acknowledgement receipt is issued for construction bond, other deposit and other non-income collection.', 'pad', NULL, 0),
(173, '5.14', NULL, 'Provisional receipt is issued for post-dated check collected.', 'pad', NULL, 0),
(174, '5.15', NULL, 'PDC register is maintained.', 'pad', NULL, 0),
(175, '5.16', NULL, 'Duplicate and triplicate copy of ORs are carbonized. Only the white copy (original copy) is in pen ink.', 'pad', NULL, 0),
(176, '5.17', NULL, 'Original copies of cancelled receipts are intact and properly marked [CANCELLED].', 'pad', NULL, 0),
(177, '5.18', NULL, 'Separate ledger is maintained for contruction bond reflecting details of payment and when it was claimed.', 'pad', NULL, 0),
(178, '5.19', NULL, 'Attachments are on file in claiming construction bond/security deposit.', 'pad', NULL, 0),
(179, '5.19.1', NULL, 'Certificate of completion or clearance from the building.', 'pad', NULL, 0),
(180, '5.19.2', NULL, 'Acknowledgement receipt with the ID of the payee indicated in the AR.', 'pad', NULL, 0),
(181, '5.19.3', NULL, 'Authorization letter from the Unit Owner if a representative will claim the bond.', 'pad', NULL, 0),
(182, '6', NULL, 'Disbursement', 'pad', NULL, 0),
(183, '6.1', NULL, 'Checks are chronologically issued.', 'pad', NULL, 0),
(184, '6.2', NULL, 'Payee is not named to [CASH] or non-existing person.', 'pad', NULL, 0),
(185, '6.3', NULL, 'Check vouchers are free from [any] alterations and stamped paid.', 'pad', NULL, 0),
(186, '6.4', NULL, 'Supporting documents are attached (sales/service invoice, receiving report and SOA) and are stamped (PAID).', 'pad', NULL, 0),
(187, '6.5', NULL, 'Cancelled checks are intact and labeled as [CANCELLED].', 'pad', NULL, 0),
(188, '6.6', NULL, 'Check vouchers are properly approved and signed by the receiver.', 'pad', NULL, 0),
(189, '6.7', NULL, 'Expenses without ORs are supported by acknowledgement receipt. ', 'pad', NULL, 0),
(190, '6.8', NULL, 'Standardized approval for expenses above Php 300,000.00.', 'pad', NULL, 0),
(191, '7', NULL, 'Billing/Statement of Account', 'pad', NULL, 0),
(192, '7.1', NULL, 'Timely issuance of ASD, water, electricity billing, special assessment, penalties and interest, if any, and others.', 'pad', NULL, 0),
(193, '7.2', NULL, 'Monthly SOA are signed by Building Manager and sent to debtors.', 'pad', NULL, 0),
(194, '7.3', NULL, 'Outstanding balances are included in SOA per Unit Owner/Tenant.', 'pad', NULL, 0),
(195, '7.4', NULL, 'SOA tally with the subsidiary ledger per Unit Owner/Tenant.', 'pad', NULL, 0),
(196, '7.5', NULL, 'Reminder letter is prepared by Accounting Assistant and signed by BM at least once a week for outstanding accounts.', 'pad', NULL, 0),
(197, '8', NULL, 'BIR Filing', 'pad', NULL, 0),
(198, '8.1', NULL, 'Monthly', 'pad', NULL, 0),
(199, '8.1.1', NULL, 'Withholding Tax-C (1601C)', 'pad', NULL, 0),
(200, '8.1.2', NULL, 'Withholding Tax-E (0619E) - 10th of following month', 'pad', NULL, 0),
(201, '8.1.3', NULL, 'Value-added Tax (2550M) - 20th of following month', 'pad', NULL, 0),
(202, '8.2', NULL, 'Quarterly', 'pad', NULL, 0),
(203, '8.2.1', NULL, 'Withholding Tax-E (1601EQ) - 30th of following month', 'pad', NULL, 0),
(204, '8.2.2', NULL, 'Percentage Tax (2551Q) - 25th of following month', 'pad', NULL, 0),
(205, '8.2.3', NULL, 'Value-added Tax (2550Q) - 25th of following month', 'pad', NULL, 0),
(206, '8.2.4', NULL, 'Income Tax (1702Q) - May 30, Aug 29, Nov 29', 'pad', NULL, 0),
(207, '8.2.5', NULL, 'Real Estate Tax - Jan 20, Apr 20, Jul 20, Oct 20', 'pad', NULL, 0),
(208, '8.3', NULL, 'Annual', 'pad', NULL, 0),
(209, '8.3.1', NULL, 'Income Tax (Apr 15)', 'pad', NULL, 0),
(210, '8.3.2', NULL, 'Municipal Tax (Jan 20)', 'pad', NULL, 0),
(211, '8.3.3', NULL, 'Alphalist (1604E) - Mar 1, (1604C) - Jan 31', 'pad', NULL, 0),
(212, '8.3.4', NULL, 'BIR Registration (Jan 30)', 'pad', NULL, 0),
(213, '8.3.5', NULL, 'Registration of Books', 'pad', NULL, 0),
(214, '8.3.5.1', NULL, 'Computerized - Jan 15', 'pad', NULL, 0),
(215, '8.3.5.2', NULL, 'Manual - Dec 28 or once pages of the ledger is used up', 'pad', NULL, 0),
(216, '9', NULL, 'Financial Statements', 'pad', NULL, 0),
(217, '9.1', NULL, 'Monthly FS are submitted on or before 20th day of followig month to BOT.', 'pad', NULL, 0),
(218, '9.2', NULL, 'General Ledger', 'pad', NULL, 0),
(219, '9.3', NULL, 'Check Disbursement Book', 'pad', NULL, 0),
(220, '9.4', NULL, 'Cash Receipts Book', 'pad', NULL, 0),
(221, '9.5', NULL, 'Journal Book', 'pad', NULL, 0),
(222, '9.6', NULL, 'Credit/Debit Note', 'pad', NULL, 0),
(223, '9.7', NULL, 'Subsidiary Ledger', 'pad', NULL, 0),
(224, '9.7.1', NULL, 'Accounts Receivable Aging of Accounts', 'pad', NULL, 0),
(225, '9.7.2', NULL, 'Schedule of Prepayments', 'pad', NULL, 0),
(226, '9.7.3', NULL, 'Schedule of Investments', 'pad', NULL, 0),
(227, '9.7.4', NULL, 'Lapsing Schedule of PPE', 'pad', NULL, 0),
(228, '9.7.5', NULL, 'Schedule of Accruals', 'pad', NULL, 0),
(229, '9.7.6', NULL, 'Schedule of Advances', 'pad', NULL, 0),
(230, '9.7.7', NULL, 'Schedule Construction Bond/Security Deposit', 'pad', NULL, 0),
(231, '9.8', NULL, 'Schedules and GL are reconciled and accurate.', 'pad', NULL, 0),
(232, '10', NULL, 'Accounting Forms (OR,AR,PR,CV)', 'pad', NULL, 0),
(233, '10.1', NULL, 'Unused accountable forms is secured with lock.', 'pad', NULL, 0),
(234, '10.2', NULL, 'Custodian is different from the cashier.', 'pad', NULL, 0),
(235, '10.3', NULL, 'User/cashier have no access to unused forms.', 'pad', NULL, 0),
(236, '10.4', NULL, 'Official receipts are free from [any] alterations.', 'pad', NULL, 0),
(237, '10.5', NULL, 'Erroneously filled up ORs are labeled as [CANCELLED].', 'pad', NULL, 0),
(238, '10.6', NULL, 'All cancelled receipts are filed and retained in 3 copies.', 'pad', NULL, 0),
(239, 'E (6.1.3)', 'Pollution Control Officer', '1. Designation and accreditation of PCO as per Sec 7 (proof of designation/training)', 'administration', '96', 0),
(240, 'E (6.1.3)', 'Pollution Control Officer', '2. Attendance to 8 hrs training of the Managing Head as per Sec 5.1 (proof of training)', 'administration', '96', 0),
(241, 'E (6.1.3)', 'Pollution Control Officer', '3. Self-Monitoring Report (SMR)', 'administration', '96', 0),
(242, 'E (6.1.3)', 'Pollution Control Officer', '4. Compliance Monitoring Report (CMR)- if applicable', 'administration', '96', 0),
(243, 'E (6.1.3)', 'Pollution Control Officer', '5. Check the content if its consistent with the actual monitoring on site.', 'administration', '96', 0),
(246, 'E (7.5)', 'Solid Waste Mgt Procedure / Hazardous Waste Management / Air Pollution Control / Energy & Water Conservation', '1. Solid Waste Monitoring Form', 'administration', '98', 0),
(245, 'E (7.4)', 'External & Internal Communication Procedure', '2. Check if they have received external environmental complaints and how is it communicated within to the Board', 'administration', '97', 0),
(249, 'E (7.5)', 'Solid Waste Mgt Procedure / Hazardous Waste Management / Air Pollution Control / Energy & Water Conservation', '4. MSDS of all approved chemicals', 'administration', '98', 0),
(250, 'E (7.5)', 'Solid Waste Mgt Procedure / Hazardous Waste Management / Air Pollution Control / Energy & Water Conservation', '5. Safety Inspection Checklist', 'administration', '98', 0),
(251, 'E (7.5)', 'Solid Waste Mgt Procedure / Hazardous Waste Management / Air Pollution Control / Energy & Water Conservation', '6. Light switching monitoring (if applicable)', 'administration', '98', 0),
(252, 'E (7.5)', 'Solid Waste Mgt Procedure / Hazardous Waste Management / Air Pollution Control / Energy & Water Conservation', '7. Emission Test Monitoring (if applicable)', 'administration', '98', 0),
(253, 'E (8.2)', 'Emergency Preparedness & Response Procedure', '3.1 Fire Drill/Earthquake Drill (2x/year)', 'administration', '104', 0),
(254, 'E (8.2)', 'Emergency Preparedness & Response Procedure', '3.2 Spill Drill', 'administration', '104', 0),
(256, 'E (9.1.2)', 'Compliance Evaluation Procedure / Air Pollution Control', '2. Effluent Test Result (Monthly)', 'administration', '106', 0),
(257, 'E (9.1.2)', 'Compliance Evaluation Procedure / Air Pollution Control', '3. Emission Test Result', 'administration', '106', 0),
(258, 'E (9.1.2)', 'Compliance Evaluation Procedure / Air Pollution Control', '4. Record of biodegradable and non-biodegradable waste generation', 'administration', '106', 0),
(261, 'E (8.1)', 'Operational Control', '1. Spill kit', 'housekeeping', '129', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pre_ops_pad_checklist`
--

DROP TABLE IF EXISTS `pre_ops_pad_checklist`;
CREATE TABLE IF NOT EXISTS `pre_ops_pad_checklist` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `prospect_id` bigint(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `account_mode` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `other_matters` varchar(2000) DEFAULT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_ops_pad_checklist_accounting_forms`
--

DROP TABLE IF EXISTS `pre_ops_pad_checklist_accounting_forms`;
CREATE TABLE IF NOT EXISTS `pre_ops_pad_checklist_accounting_forms` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `checklist_id` bigint(255) NOT NULL,
  `types` varchar(255) DEFAULT NULL,
  `status` int(2) NOT NULL,
  `numbered` varchar(255) DEFAULT NULL,
  `numbered_as_used` varchar(255) DEFAULT NULL,
  `remarks` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_ops_pad_checklist_attachments`
--

DROP TABLE IF EXISTS `pre_ops_pad_checklist_attachments`;
CREATE TABLE IF NOT EXISTS `pre_ops_pad_checklist_attachments` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `checklist_id` bigint(255) NOT NULL,
  `remarks` varchar(500) DEFAULT NULL,
  `attachment` varchar(1000) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_ops_pad_checklist_bank_accounts_and_related_documents`
--

DROP TABLE IF EXISTS `pre_ops_pad_checklist_bank_accounts_and_related_documents`;
CREATE TABLE IF NOT EXISTS `pre_ops_pad_checklist_bank_accounts_and_related_documents` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `checklist_id` bigint(255) NOT NULL,
  `types` varchar(500) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_ops_pad_checklist_billing_formula_with_supporting_subsidiary`
--

DROP TABLE IF EXISTS `pre_ops_pad_checklist_billing_formula_with_supporting_subsidiary`;
CREATE TABLE IF NOT EXISTS `pre_ops_pad_checklist_billing_formula_with_supporting_subsidiary` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `checklist_id` bigint(255) NOT NULL,
  `types` varchar(500) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_ops_pad_checklist_books_of_accounts`
--

DROP TABLE IF EXISTS `pre_ops_pad_checklist_books_of_accounts`;
CREATE TABLE IF NOT EXISTS `pre_ops_pad_checklist_books_of_accounts` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `checklist_id` int(255) NOT NULL,
  `types` varchar(500) DEFAULT NULL,
  `value` varchar(500) DEFAULT NULL,
  `category` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_ops_pad_checklist_books_of_accounts_types`
--

DROP TABLE IF EXISTS `pre_ops_pad_checklist_books_of_accounts_types`;
CREATE TABLE IF NOT EXISTS `pre_ops_pad_checklist_books_of_accounts_types` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `checklist_id` int(255) NOT NULL,
  `types` varchar(500) DEFAULT NULL,
  `status` varchar(500) DEFAULT NULL,
  `date_from_to` varchar(255) DEFAULT NULL,
  `date_received` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_ops_pad_checklist_budgets_present_previous`
--

DROP TABLE IF EXISTS `pre_ops_pad_checklist_budgets_present_previous`;
CREATE TABLE IF NOT EXISTS `pre_ops_pad_checklist_budgets_present_previous` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `checklist_id` bigint(255) NOT NULL,
  `types` varchar(255) DEFAULT NULL,
  `date_of_approval` varchar(255) DEFAULT NULL,
  `assesment_rate` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_ops_pad_checklist_cash_on_hand`
--

DROP TABLE IF EXISTS `pre_ops_pad_checklist_cash_on_hand`;
CREATE TABLE IF NOT EXISTS `pre_ops_pad_checklist_cash_on_hand` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `checklist_id` bigint(255) NOT NULL,
  `types` varchar(500) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_ops_pad_checklist_certificate_of_deposits`
--

DROP TABLE IF EXISTS `pre_ops_pad_checklist_certificate_of_deposits`;
CREATE TABLE IF NOT EXISTS `pre_ops_pad_checklist_certificate_of_deposits` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `checklist_id` bigint(255) NOT NULL,
  `types` varchar(500) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_ops_pad_checklist_credits`
--

DROP TABLE IF EXISTS `pre_ops_pad_checklist_credits`;
CREATE TABLE IF NOT EXISTS `pre_ops_pad_checklist_credits` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `checklist_id` bigint(255) NOT NULL,
  `credit_by` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `signature` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_ops_pad_checklist_financial_management_reports`
--

DROP TABLE IF EXISTS `pre_ops_pad_checklist_financial_management_reports`;
CREATE TABLE IF NOT EXISTS `pre_ops_pad_checklist_financial_management_reports` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `checklist_id` bigint(255) NOT NULL,
  `types` varchar(500) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `latest_report_submitted` varchar(255) DEFAULT NULL,
  `date_submitted` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_ops_pad_checklist_list_of_pending_accounting_projects`
--

DROP TABLE IF EXISTS `pre_ops_pad_checklist_list_of_pending_accounting_projects`;
CREATE TABLE IF NOT EXISTS `pre_ops_pad_checklist_list_of_pending_accounting_projects` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `checklist_id` bigint(255) NOT NULL,
  `list` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_ops_pad_checklist_permit_and_licenses_bir`
--

DROP TABLE IF EXISTS `pre_ops_pad_checklist_permit_and_licenses_bir`;
CREATE TABLE IF NOT EXISTS `pre_ops_pad_checklist_permit_and_licenses_bir` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `checklist_id` int(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `cor_number` varchar(255) DEFAULT NULL,
  `rdo_number` varchar(255) DEFAULT NULL,
  `display` int(2) NOT NULL,
  `display_specify` varchar(255) DEFAULT NULL,
  `line_of_business` varchar(500) DEFAULT NULL,
  `tax_checklist` varchar(255) DEFAULT NULL,
  `tax_specify` varchar(500) DEFAULT NULL,
  `notice_public_display` int(2) NOT NULL,
  `notice_public_specify` varchar(1000) DEFAULT NULL,
  `annual_registration` varchar(1000) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `date_paid` varchar(255) DEFAULT NULL,
  `others` varchar(500) DEFAULT NULL,
  `inhouse` varchar(255) DEFAULT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_ops_pad_checklist_permit_and_licenses_local_government`
--

DROP TABLE IF EXISTS `pre_ops_pad_checklist_permit_and_licenses_local_government`;
CREATE TABLE IF NOT EXISTS `pre_ops_pad_checklist_permit_and_licenses_local_government` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `checklist_id` int(255) NOT NULL,
  `business_permit_number` varchar(500) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `display` varchar(20) DEFAULT NULL,
  `value` varchar(500) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_ops_pad_checklist_permit_and_licenses_philhealth_and_pagibig`
--

DROP TABLE IF EXISTS `pre_ops_pad_checklist_permit_and_licenses_philhealth_and_pagibig`;
CREATE TABLE IF NOT EXISTS `pre_ops_pad_checklist_permit_and_licenses_philhealth_and_pagibig` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `checklist_id` int(255) NOT NULL,
  `value` varchar(500) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_ops_pad_checklist_permit_and_licenses_security_exchange`
--

DROP TABLE IF EXISTS `pre_ops_pad_checklist_permit_and_licenses_security_exchange`;
CREATE TABLE IF NOT EXISTS `pre_ops_pad_checklist_permit_and_licenses_security_exchange` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `checklist_id` int(255) NOT NULL,
  `value` varchar(500) DEFAULT NULL,
  `category` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_ops_pad_checklist_permit_and_licenses_sss`
--

DROP TABLE IF EXISTS `pre_ops_pad_checklist_permit_and_licenses_sss`;
CREATE TABLE IF NOT EXISTS `pre_ops_pad_checklist_permit_and_licenses_sss` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `checklist_id` int(255) NOT NULL,
  `value` varchar(500) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_ops_pad_checklist_schedule_of_assesments_dues_and_deposits`
--

DROP TABLE IF EXISTS `pre_ops_pad_checklist_schedule_of_assesments_dues_and_deposits`;
CREATE TABLE IF NOT EXISTS `pre_ops_pad_checklist_schedule_of_assesments_dues_and_deposits` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `checklist_id` bigint(255) NOT NULL,
  `types` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_ops_pad_checklist_takeover`
--

DROP TABLE IF EXISTS `pre_ops_pad_checklist_takeover`;
CREATE TABLE IF NOT EXISTS `pre_ops_pad_checklist_takeover` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `checklist_id` int(255) NOT NULL,
  `parent_id` varchar(255) DEFAULT NULL,
  `turnover_takeover_by` varchar(255) DEFAULT NULL,
  `accepted_by` varchar(255) DEFAULT NULL,
  `notes` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_ops_pad_checklist_tax_compliance_review_nirc`
--

DROP TABLE IF EXISTS `pre_ops_pad_checklist_tax_compliance_review_nirc`;
CREATE TABLE IF NOT EXISTS `pre_ops_pad_checklist_tax_compliance_review_nirc` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `checklist_id` bigint(255) NOT NULL,
  `nirc_types` varchar(255) DEFAULT NULL,
  `status` varchar(500) DEFAULT NULL,
  `latest_return_filed` varchar(255) DEFAULT NULL,
  `date_filed_remitted` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_ops_pad_checklist_tax_compliance_review_real_estate_tax`
--

DROP TABLE IF EXISTS `pre_ops_pad_checklist_tax_compliance_review_real_estate_tax`;
CREATE TABLE IF NOT EXISTS `pre_ops_pad_checklist_tax_compliance_review_real_estate_tax` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `checklist_id` varchar(255) DEFAULT NULL,
  `period_covered` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `reference` varchar(500) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_ops_pad_checklist_unpaid_invoices`
--

DROP TABLE IF EXISTS `pre_ops_pad_checklist_unpaid_invoices`;
CREATE TABLE IF NOT EXISTS `pre_ops_pad_checklist_unpaid_invoices` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `checklist_id` bigint(255) NOT NULL,
  `types` varchar(500) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prf`
--

DROP TABLE IF EXISTS `prf`;
CREATE TABLE IF NOT EXISTS `prf` (
  `id` bigint(250) NOT NULL AUTO_INCREMENT,
  `prospect_id` bigint(250) NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `temp_del` int(20) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prf_departments`
--

DROP TABLE IF EXISTS `prf_departments`;
CREATE TABLE IF NOT EXISTS `prf_departments` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `prf_id` bigint(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `department` varchar(500) DEFAULT NULL,
  `job_title` varchar(500) DEFAULT NULL,
  `number_of_staff` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT '0',
  `code` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

DROP TABLE IF EXISTS `properties`;
CREATE TABLE IF NOT EXISTS `properties` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `property_id` varchar(255) NOT NULL,
  `prospect_id` bigint(255) DEFAULT NULL,
  `property_code` varchar(10) NOT NULL DEFAULT '',
  `property_name` varchar(100) NOT NULL DEFAULT '',
  `client_id` bigint(255) NOT NULL DEFAULT '0',
  `cluster_id` bigint(255) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `proposals`
--

DROP TABLE IF EXISTS `proposals`;
CREATE TABLE IF NOT EXISTS `proposals` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `prospect_id` bigint(255) NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `proposal_esd_etspqa`
--

DROP TABLE IF EXISTS `proposal_esd_etspqa`;
CREATE TABLE IF NOT EXISTS `proposal_esd_etspqa` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `prospect_id` bigint(255) NOT NULL,
  `reference_number` varchar(250) NOT NULL,
  `clientName` varchar(500) NOT NULL,
  `address_line1` varchar(500) DEFAULT NULL,
  `address_line2` varchar(500) DEFAULT NULL,
  `payment_terms` varchar(500) DEFAULT NULL,
  `validity_period` varchar(500) DEFAULT NULL,
  `signatoryName` varchar(500) DEFAULT NULL,
  `signatoryPosition` varchar(500) DEFAULT NULL,
  `signatoryDepartment` varchar(500) DEFAULT NULL,
  `letter_subject` varchar(500) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `temp_del` int(11) NOT NULL DEFAULT '0',
  `date` date DEFAULT NULL,
  `conformeSignatoryName` varchar(500) DEFAULT NULL,
  `conformeSignatoryContact` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `proposal_esd_etspqa_items`
--

DROP TABLE IF EXISTS `proposal_esd_etspqa_items`;
CREATE TABLE IF NOT EXISTS `proposal_esd_etspqa_items` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `proposal_id` bigint(255) NOT NULL,
  `number` int(11) NOT NULL DEFAULT '1',
  `item` text,
  PRIMARY KEY (`id`),
  KEY `proposal_esd_etspqa_items_proposal_esd_etspqa_id_fk` (`proposal_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `proposal_esd_etspqa_objectives`
--

DROP TABLE IF EXISTS `proposal_esd_etspqa_objectives`;
CREATE TABLE IF NOT EXISTS `proposal_esd_etspqa_objectives` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `proposal_id` bigint(255) NOT NULL,
  `number` int(11) NOT NULL DEFAULT '1',
  `objective` text,
  PRIMARY KEY (`id`),
  KEY `proposal_esd_etspqa_objectives_proposal_esd_etspqa_id_fk` (`proposal_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `proposal_esd_etspqa_psa_scopes`
--

DROP TABLE IF EXISTS `proposal_esd_etspqa_psa_scopes`;
CREATE TABLE IF NOT EXISTS `proposal_esd_etspqa_psa_scopes` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `proposal_id` bigint(255) NOT NULL,
  `scopeOf` text,
  PRIMARY KEY (`id`),
  KEY `proposal_esd_etspqa_psa_scope_of_works_proposal_esd_etspqa_id_fk` (`proposal_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `proposal_esd_generic`
--

DROP TABLE IF EXISTS `proposal_esd_generic`;
CREATE TABLE IF NOT EXISTS `proposal_esd_generic` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `prospect_id` bigint(255) NOT NULL,
  `reference_number` varchar(255) NOT NULL,
  `salutation` varchar(255) NOT NULL,
  `client` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `letter_subject` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `other_service` varchar(500) DEFAULT NULL,
  `payment_terms` varchar(255) NOT NULL,
  `warranty_period` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `short_location` varchar(255) NOT NULL,
  `proposal_validity` varchar(255) NOT NULL,
  `created_by` bigint(255) NOT NULL,
  `account_mode` varchar(255) NOT NULL,
  `position` varchar(255) DEFAULT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `proposal_esd_generic_items`
--

DROP TABLE IF EXISTS `proposal_esd_generic_items`;
CREATE TABLE IF NOT EXISTS `proposal_esd_generic_items` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `proposal_esd_generic_id` bigint(255) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `has_costing` int(10) NOT NULL DEFAULT '0',
  `item_code` int(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `proposal_esd_generic_labor_cost`
--

DROP TABLE IF EXISTS `proposal_esd_generic_labor_cost`;
CREATE TABLE IF NOT EXISTS `proposal_esd_generic_labor_cost` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `esd_generic_item_id` bigint(255) NOT NULL,
  `labor_cost` varchar(255) NOT NULL,
  `vat` varchar(255) NOT NULL,
  `other` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `labor_cost_code` int(30) DEFAULT NULL,
  `option_code` int(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `proposal_esd_generic_options`
--

DROP TABLE IF EXISTS `proposal_esd_generic_options`;
CREATE TABLE IF NOT EXISTS `proposal_esd_generic_options` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `esd_generic_labor_cost_id` bigint(255) NOT NULL,
  `quantity` int(20) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `unit_price` varchar(255) DEFAULT NULL,
  `total_price` varchar(255) DEFAULT NULL,
  `lc_quantity` int(30) NOT NULL,
  `lc_unit` varchar(255) NOT NULL,
  `lc_unit_cost` varchar(255) NOT NULL,
  `lc_total` varchar(255) NOT NULL,
  `sub_total` varchar(255) NOT NULL,
  `options_code` int(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `proposal_esd_generic_scope_of_works`
--

DROP TABLE IF EXISTS `proposal_esd_generic_scope_of_works`;
CREATE TABLE IF NOT EXISTS `proposal_esd_generic_scope_of_works` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `esd_generic_item_id` bigint(255) NOT NULL,
  `material_name` varchar(255) NOT NULL,
  `material_code` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `proposal_esd_generic_signatory`
--

DROP TABLE IF EXISTS `proposal_esd_generic_signatory`;
CREATE TABLE IF NOT EXISTS `proposal_esd_generic_signatory` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `proposal_esd_generic_id` bigint(255) NOT NULL,
  `noted_by` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `conforme_name` varchar(255) NOT NULL,
  `conforme_contact` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `proposal_esd_tsa`
--

DROP TABLE IF EXISTS `proposal_esd_tsa`;
CREATE TABLE IF NOT EXISTS `proposal_esd_tsa` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `prospect_id` bigint(255) NOT NULL,
  `reference_number` varchar(250) NOT NULL,
  `clientName` varchar(500) NOT NULL,
  `address_line1` varchar(500) DEFAULT NULL,
  `address_line2` varchar(500) DEFAULT NULL,
  `payment_terms` varchar(500) DEFAULT NULL,
  `validity_period` varchar(500) DEFAULT NULL,
  `signatoryName` varchar(500) DEFAULT NULL,
  `signatoryPosition` varchar(500) DEFAULT NULL,
  `signatoryDepartment` varchar(500) DEFAULT NULL,
  `letter_subject` varchar(500) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `temp_del` int(11) NOT NULL DEFAULT '0',
  `date` date DEFAULT NULL,
  `conformeSignatoryName` varchar(500) DEFAULT NULL,
  `conformeSignatoryContact` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `proposal_tsa_reference_number_uindex` (`reference_number`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `proposal_esd_tsa_objectives`
--

DROP TABLE IF EXISTS `proposal_esd_tsa_objectives`;
CREATE TABLE IF NOT EXISTS `proposal_esd_tsa_objectives` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `proposal_id` bigint(255) NOT NULL,
  `number` int(11) NOT NULL DEFAULT '6',
  `objective` text,
  PRIMARY KEY (`id`),
  KEY `proposal_esd_tsa_objectives_proposal_esd_tsa_id_fk` (`proposal_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `proposal_esd_tsa_scopes`
--

DROP TABLE IF EXISTS `proposal_esd_tsa_scopes`;
CREATE TABLE IF NOT EXISTS `proposal_esd_tsa_scopes` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `proposal_id` bigint(255) NOT NULL,
  `scope` text,
  PRIMARY KEY (`id`),
  KEY `proposal_esd_tsa_scopes_proposal_esd_tsa_id_fk` (`proposal_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `proposal_esd_tsa_tasks`
--

DROP TABLE IF EXISTS `proposal_esd_tsa_tasks`;
CREATE TABLE IF NOT EXISTS `proposal_esd_tsa_tasks` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `scope_id` bigint(255) NOT NULL,
  `number` int(11) NOT NULL DEFAULT '1',
  `task` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `proposal_esd_tsa_tasks_proposal_esd_tsa_scopes_id_fk` (`scope_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `proposal_introductory_letters`
--

DROP TABLE IF EXISTS `proposal_introductory_letters`;
CREATE TABLE IF NOT EXISTS `proposal_introductory_letters` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `prospect_id` int(255) NOT NULL,
  `dear_name` varchar(255) NOT NULL,
  `services` varchar(255) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `trunkline_no` varchar(255) NOT NULL,
  `fax_no` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `proposal_category` varchar(250) NOT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `proposal_letter`
--

DROP TABLE IF EXISTS `proposal_letter`;
CREATE TABLE IF NOT EXISTS `proposal_letter` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `proposal_id` bigint(255) NOT NULL,
  `honorifics` varchar(255) DEFAULT NULL,
  `services` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `days` varchar(255) DEFAULT NULL,
  `service_fee` varchar(255) DEFAULT NULL,
  `term_of_payment` varchar(255) DEFAULT NULL,
  `fax_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `noted_by` varchar(255) DEFAULT NULL,
  `conforme` varchar(255) DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `proposal_services`
--

DROP TABLE IF EXISTS `proposal_services`;
CREATE TABLE IF NOT EXISTS `proposal_services` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `proposal_id` bigint(255) NOT NULL,
  `date` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `honorifics` varchar(255) DEFAULT NULL,
  `prepared_by` varchar(255) DEFAULT NULL,
  `checked_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `proposal_service_area`
--

DROP TABLE IF EXISTS `proposal_service_area`;
CREATE TABLE IF NOT EXISTS `proposal_service_area` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `service_id` bigint(255) NOT NULL,
  `quantity` int(30) NOT NULL DEFAULT '0',
  `description` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `unit_price` varchar(255) DEFAULT NULL,
  `total_price` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prospecting`
--

DROP TABLE IF EXISTS `prospecting`;
CREATE TABLE IF NOT EXISTS `prospecting` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `reference_number` varchar(250) NOT NULL,
  `project_name` varchar(100) NOT NULL,
  `owner_developer` varchar(250) NOT NULL,
  `location` varchar(250) NOT NULL,
  `property_category` varchar(250) NOT NULL,
  `property_category_others` varchar(250) DEFAULT NULL,
  `number_of_building` varchar(250) NOT NULL,
  `property_age` int(11) NOT NULL,
  `service_required` varchar(250) NOT NULL,
  `other_services` varchar(250) NOT NULL,
  `current_property_management` varchar(250) NOT NULL,
  `other_remarks` varchar(1000) DEFAULT '',
  `contact_person` varchar(250) NOT NULL,
  `designation` varchar(250) NOT NULL,
  `telephone` varchar(100) DEFAULT NULL,
  `mobile_number` varchar(255) NOT NULL,
  `email_address` varchar(250) NOT NULL,
  `remarks_on_contact_person` varchar(250) NOT NULL,
  `referred_by` varchar(250) NOT NULL,
  `lead_received_through` varchar(250) NOT NULL,
  `other_lead_remarks` varchar(250) NOT NULL,
  `due_date` varchar(255) DEFAULT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  `declined_remarks` varchar(1000) DEFAULT '',
  `date` int(20) DEFAULT NULL,
  `created_by` bigint(255) DEFAULT NULL,
  `account_mode` varchar(255) DEFAULT NULL,
  `prospecting_category` int(20) DEFAULT '0',
  `temp_del` int(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prospecting_activities`
--

DROP TABLE IF EXISTS `prospecting_activities`;
CREATE TABLE IF NOT EXISTS `prospecting_activities` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `prospect_id` bigint(255) NOT NULL,
  `activity_code` varchar(255) NOT NULL,
  `activity_type` varchar(255) NOT NULL,
  `activity_category` varchar(255) DEFAULT NULL,
  `activity_date` varchar(255) NOT NULL,
  `activity_status` varchar(1000) DEFAULT NULL,
  `activity_timeline` varchar(255) DEFAULT NULL,
  `activity_attachment` varchar(255) DEFAULT NULL,
  `created_at` varchar(255) NOT NULL DEFAULT '0',
  `created_by` bigint(255) DEFAULT NULL,
  `account_mode` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prospecting_activity_remarks`
--

DROP TABLE IF EXISTS `prospecting_activity_remarks`;
CREATE TABLE IF NOT EXISTS `prospecting_activity_remarks` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `prospect_id` bigint(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_date` varchar(255) NOT NULL,
  `created_by` bigint(255) NOT NULL,
  `account_mode` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prospecting_contacts`
--

DROP TABLE IF EXISTS `prospecting_contacts`;
CREATE TABLE IF NOT EXISTS `prospecting_contacts` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `prospect_id` int(250) NOT NULL,
  `contact_person` varchar(250) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `office_address` varchar(500) DEFAULT NULL,
  `email_address` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `temp_del` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prospecting_hr_information`
--

DROP TABLE IF EXISTS `prospecting_hr_information`;
CREATE TABLE IF NOT EXISTS `prospecting_hr_information` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `prospect_id` bigint(255) NOT NULL,
  `manpower_plantilla` varchar(500) NOT NULL,
  `head_count` varchar(255) DEFAULT NULL,
  `base_pay` varchar(255) DEFAULT NULL,
  `allowance` varchar(255) DEFAULT NULL,
  `special_qualification` varchar(500) DEFAULT NULL,
  `remarks` varchar(1000) DEFAULT NULL,
  `status` int(10) DEFAULT '0',
  `send_by` bigint(255) NOT NULL,
  `account_mode` varchar(255) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reminders`
--

DROP TABLE IF EXISTS `reminders`;
CREATE TABLE IF NOT EXISTS `reminders` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `reminder_msg` varchar(255) NOT NULL,
  `target_id` bigint(255) NOT NULL,
  `module` varchar(255) NOT NULL,
  `reminder_date` varchar(255) NOT NULL,
  `user_id` bigint(255) NOT NULL,
  `user_account_mode` varchar(255) NOT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  `permissions` varchar(20000) NOT NULL DEFAULT '',
  `status` int(1) NOT NULL DEFAULT '0',
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `permissions`, `status`, `temp_del`) VALUES
(1, 'Super Admin', 'all', 0, 0),
(2, 'IT Officer', 'all', 0, 0),
(3, 'Building Manager', 'employees,properties', 0, 1594869624),
(4, 'Supervisor', 'employee-leave-list,daily-time-records,attendance,overtime,overtime-add,overtime-edit,overtime-delete,employees,employee-add,employee-edit,employee-delete', 0, 0),
(5, 'sample', 'employees,calendar', 0, 1592392497),
(6, 'HR Officer', 'admin,company-structure,company-structure-add,company-structure-edit,company-structure-delete,job-title,job-title-add,job-title-edit,job-title-delete,pay-grade,pay-grade-add,pay-grade-edit,pay-grade-delete,employment-status,employment-status-add,employment-status-edit,employment-status-delete,skill,skill-add,skill-edit,skill-delete,education,education-add,education-edit,education-delete,certification,certification-add,certification-edit,certification-delete,language,language-add,language-edit,language-delete,course,course-add,course-edit,course-delete,training-session,training-session-add,training-session-edit,training-session-delete,employee-training-session,employee-training-session-add,employee-training-session-edit,employee-training-session-delete,client,client-add,client-edit,client-delete,project,project-add,project-edit,project-delete,employee-project,employee-project-add,employee-project-edit,employee-project-delete,leave-type,leave-type-add,leave-type-edit,leave-type-delete,leave-period,leave-period-add,leave-period-edit,leave-period-delete,work-week,work-week-add,work-week-edit,work-week-delete,holiday,holiday-add,holiday-edit,holiday-delete,leave-rule,leave-rule-add,leave-rule-edit,leave-rule-delete,paid-time-off,paid-time-off-add,paid-time-off-edit,paid-time-off-delete,skill,skill-add,skill-edit,skill-delete,leave-group,leave-group-add,leave-group-edit,leave-group-delete,leave-group-employee,leave-group-employee-add,leave-group-employee-edit,leave-group-employee-delete,employee-leave-list,expense-category,expense-category-add,expense-category-edit,expense-category-delete,payment-method,payment-method-add,payment-method-edit,payment-method-delete,employee-expense,employee-expense-add,employee-expense-edit,employee-expense-delete,overtime-category,overtime-category-add,overtime-category-edit,overtime-category-delete,loan-type,loan-type-add,loan-type-edit,loan-type-delete,employee-loan,employee-loan-add,employee-loan-edit,employee-loan-delete,company-asset-type,company-asset-type-add,company-asset-type-edit,company-asset-type-delete,company-asset,company-asset-add,company-asset-edit,company-asset-delete,audit-log,employee-skill,employee-skill-add,employee-skill-edit,employee-skill-delete,employee-education,employee-education-add,employee-education-edit,employee-education-delete,employee-certification,employee-certification-add,employee-certification-edit,employee-certification-delete,employee-language,employee-language-add,employee-language-edit,employee-language-delete,employee-dependent,employee-dependent-add,employee-dependent-edit,employee-dependent-delete,emergency-contact,emergency-contact-add,emergency-contact-edit,emergency-contact-delete,daily-time-records,attendance,overtime,overtime-add,overtime-edit,overtime-delete,benefit,benefit-add,benefit-edit,benefit-delete,education-level,education-level-add,education-level-edit,education-level-delete,employment-type,employment-type-add,employment-type-edit,employment-type-delete,experience-level,experience-level-add,experience-level-edit,experience-level-delete,job-function,job-function-add,job-function-edit,job-function-delete,job-position,job-position-add,job-position-edit,job-position-delete,candidate,candidate-add,candidate-edit,candidate-delete,employees,employee-add,employee-edit,employee-delete,itenerary-request,itenerary-request-add,itenerary-request-edit,itenerary-request-delete,company-document,company-document-add,company-document-edit,company-document-delete,document-type,document-type-add,document-type-edit,document-type-delete,employee-document,employee-document-add,employee-document-edit,employee-document-delete,workshift-management,workshift-add,workshift-edit,workshift-delete,workshift-assignment,workshift-add-assignment,workshift-edit-assignment,workshift-delete-assignment,clients,client-add,client-edit,client-delete,admin', 0, 0),
(7, 'HR People', 'job-title,job-title-add,job-title-edit,job-title-delete,pay-grade,pay-grade-add,pay-grade-edit,pay-grade-delete,employment-status,employment-status-add,employment-status-edit,employment-status-delete,skill,skill-add,skill-edit,skill-delete,education,education-add,education-edit,education-delete,certification,certification-add,certification-edit,certification-delete,language,language-add,language-edit,language-delete,client,client-add,client-edit,client-delete,project,project-add,project-edit,project-delete,employee-project,employee-project-add,employee-project-edit,employee-project-delete,leave-type,leave-type-add,leave-type-edit,leave-type-delete,leave-period,leave-period-add,leave-period-edit,leave-period-delete,work-week,work-week-add,work-week-edit,work-week-delete,holiday,holiday-add,holiday-edit,holiday-delete,leave-rule,leave-rule-add,leave-rule-edit,leave-rule-delete,paid-time-off,paid-time-off-add,paid-time-off-edit,paid-time-off-delete,skill,skill-add,skill-edit,skill-delete,leave-group,leave-group-add,leave-group-edit,leave-group-delete,leave-group-employee,leave-group-employee-add,leave-group-employee-edit,leave-group-employee-delete,employee-leave-list,expense-category,expense-category-add,expense-category-edit,expense-category-delete,payment-method,payment-method-add,payment-method-edit,payment-method-delete,employee-expense,employee-expense-add,employee-expense-edit,employee-expense-delete,overtime-category,overtime-category-add,overtime-category-edit,overtime-category-delete,loan-type,loan-type-add,loan-type-edit,loan-type-delete,employee-loan,employee-loan-add,employee-loan-edit,employee-loan-delete,company-asset-type,company-asset-type-add,company-asset-type-edit,company-asset-type-delete,company-asset,company-asset-add,company-asset-edit,company-asset-delete,employee-skill,employee-skill-add,employee-skill-edit,employee-skill-delete,employee-education,employee-education-add,employee-education-edit,employee-education-delete,employee-certification,employee-certification-add,employee-certification-edit,employee-certification-delete,employee-language,employee-language-add,employee-language-edit,employee-language-delete,employee-dependent,employee-dependent-add,employee-dependent-edit,employee-dependent-delete,emergency-contact,emergency-contact-add,emergency-contact-edit,emergency-contact-delete,daily-time-records,attendance,overtime,overtime-add,overtime-edit,overtime-delete,benefit,benefit-add,benefit-edit,benefit-delete,education-level,education-level-add,education-level-edit,education-level-delete,employment-type,employment-type-add,employment-type-edit,employment-type-delete,experience-level,experience-level-add,experience-level-edit,experience-level-delete,job-function,job-function-add,job-function-delete,job-position,job-position-add,job-position-edit,job-position-delete,candidate,candidate-add,candidate-edit,candidate-delete,employees,employee-add,employee-edit,employee-delete,itenerary-request,itenerary-request-add,itenerary-request-edit,itenerary-request-delete,company-document,company-document-add,company-document-edit,company-document-delete,document-type,document-type-add,document-type-edit,document-type-delete,employee-document,employee-document-add,employee-document-edit,employee-document-delete,workshift-management,workshift-add,workshift-edit,workshift-delete,workshift-assignment,workshift-add-assignment,workshift-edit-assignment,workshift-delete-assignment,client-add,client-edit,client-delete', 0, 0),
(8, 'Employee', 'work-week,work-week-add,work-week-edit,work-week-delete,employee-leave-list,overtime-category,employee-skill,employee-skill-edit,employee-education,employee-education-edit,employee-certification,employee-certification-edit,employee-language,employee-language-add,employee-language-edit,employee-dependent,employee-dependent-add,employee-dependent-edit,emergency-contact,emergency-contact-add,emergency-contact-edit,daily-time-records,attendance,overtime,overtime-add,overtime-edit,education-level,education-level-add,education-level-edit,employment-type,employment-type-add,employment-type-edit,experience-level,experience-level-add,experience-level-edit,job-function,job-function-add,job-function-edit,job-position,job-position-add,job-position-edit,itenerary-request,itenerary-request-add,itenerary-request-edit,document-type,document-type-edit,employee-document,employee-document-edit', 0, 0),
(9, 'Timekeeper', 'work-week,work-week-add,work-week-edit,work-week-delete,holiday,holiday-add,holiday-edit,holiday-delete,leave-rule,leave-rule-add,leave-rule-edit,leave-rule-delete,paid-time-off,paid-time-off-add,paid-time-off-edit,paid-time-off-delete,leave-group,leave-group-add,leave-group-edit,leave-group-delete,leave-group-employee,leave-group-employee-add,leave-group-employee-edit,leave-group-employee-delete,employee-leave-list,daily-time-records,attendance,overtime,overtime-add,overtime-edit,workshift-management,workshift-add,workshift-edit,workshift-delete,workshift-assignment,workshift-add-assignment,workshift-edit-assignment,workshift-delete-assignment', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `service_providers`
--

DROP TABLE IF EXISTS `service_providers`;
CREATE TABLE IF NOT EXISTS `service_providers` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `sub_property_id` bigint(255) NOT NULL DEFAULT '0',
  `name_of_the_company` varchar(250) NOT NULL,
  `services` varchar(250) NOT NULL,
  `contact_person` varchar(250) NOT NULL,
  `mobile_number` varchar(250) NOT NULL,
  `landline_number` varchar(250) NOT NULL,
  `email_address` varchar(250) NOT NULL,
  `temp_del` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `service_requests`
--

DROP TABLE IF EXISTS `service_requests`;
CREATE TABLE IF NOT EXISTS `service_requests` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `unit_id` int(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `complainant` varchar(250) DEFAULT NULL,
  `account_type` varchar(250) DEFAULT NULL,
  `service` varchar(250) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `assessment` varchar(1000) DEFAULT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  `temp_del` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sub_properties`
--

DROP TABLE IF EXISTS `sub_properties`;
CREATE TABLE IF NOT EXISTS `sub_properties` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `property_id` bigint(255) NOT NULL DEFAULT '0',
  `sub_property_name` varchar(100) NOT NULL DEFAULT '',
  `sub_property_association_dues` int(255) DEFAULT '0',
  `sub_property_inclusive_of` varchar(500) NOT NULL DEFAULT ' ',
  `sub_property_joining_fee` int(255) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sub_properties_amenities`
--

DROP TABLE IF EXISTS `sub_properties_amenities`;
CREATE TABLE IF NOT EXISTS `sub_properties_amenities` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `sub_property_id` bigint(255) NOT NULL,
  `amenity_name` varchar(1000) NOT NULL,
  `amenity_description` varchar(10000) DEFAULT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sub_properties_floors_units`
--

DROP TABLE IF EXISTS `sub_properties_floors_units`;
CREATE TABLE IF NOT EXISTS `sub_properties_floors_units` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `sub_property_id` bigint(255) NOT NULL,
  `sub_property_category` varchar(1000) NOT NULL,
  `sub_property_floor_no` int(20) NOT NULL,
  `sub_property_unit_no` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sub_properties_parking`
--

DROP TABLE IF EXISTS `sub_properties_parking`;
CREATE TABLE IF NOT EXISTS `sub_properties_parking` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `sub_property_id` bigint(255) NOT NULL,
  `parking_category` varchar(1000) NOT NULL,
  `parking_slot_no` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `system_log`
--

DROP TABLE IF EXISTS `system_log`;
CREATE TABLE IF NOT EXISTS `system_log` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(255) NOT NULL DEFAULT '0',
  `account_mode` varchar(255) NOT NULL DEFAULT '',
  `module` varchar(255) NOT NULL DEFAULT '',
  `target_id` bigint(255) NOT NULL DEFAULT '0',
  `action` varchar(10) NOT NULL,
  `change_log` text NOT NULL,
  `epoch_time` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=177 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `system_log`
--

INSERT INTO `system_log` (`id`, `user_id`, `account_mode`, `module`, `target_id`, `action`, `change_log`, `epoch_time`) VALUES
(1, 1, 'user', 'role', 4, 'add', '', 1592310332),
(2, 1, 'user', 'role', 5, 'add', '', 1592392471),
(3, 1, 'employee', 'login', 1, 'login', '', 1592660170),
(4, 2, 'employee', 'login', 2, 'login', '', 1592660440),
(5, 1, 'employee', 'login', 1, 'login', '', 1592660504),
(6, 1, 'employee', 'login', 1, 'login', '', 1592827266),
(7, 1, 'employee', 'login', 1, 'login', '', 1592827277),
(8, 1, 'employee', 'login', 1, 'login', '', 1592839613),
(9, 2, 'employee', 'login', 2, 'login', '', 1592839852),
(10, 1, 'employee', 'login', 1, 'login', '', 1592915038),
(11, 2, 'employee', 'login', 2, 'login', '', 1592915258),
(12, 1, 'employee', 'login', 1, 'login', '', 1592917099),
(13, 2, 'employee', 'login', 2, 'login', '', 1592917790),
(14, 2, 'employee', 'login', 2, 'login', '', 1592918197),
(15, 1, 'employee', 'login', 1, 'login', '', 1592918317),
(16, 2, 'employee', 'login', 2, 'login', '', 1592918360),
(17, 1, 'employee', 'login', 1, 'login', '', 1592918706),
(18, 2, 'employee', 'login', 2, 'login', '', 1592920267),
(19, 1, 'employee', 'login', 1, 'login', '', 1592921353),
(20, 2, 'employee', 'login', 2, 'login', '', 1592921394),
(21, 1, 'employee', 'login', 1, 'login', '', 1593005384),
(22, 1, 'employee', 'login', 1, 'login', '', 1593005876),
(23, 1, 'employee', 'login', 1, 'login', '', 1593255991),
(24, 2, 'employee', 'login', 2, 'login', '', 1593256746),
(25, 1, 'employee', 'login', 1, 'login', '', 1593257835),
(26, 1, 'employee', 'login', 1, 'login', '', 1593547253),
(27, 1, 'employee', 'login', 1, 'login', '', 1593548620),
(28, 1, 'employee', 'login', 1, 'login', '', 1593704746),
(29, 1, 'employee', 'login', 1, 'login', '', 1593738987),
(30, 1, 'employee', 'login', 1, 'login', '', 1593873251),
(31, 4, 'employee', 'login', 4, 'login', '', 1593885536),
(32, 4, 'employee', 'login', 4, 'login', '', 1593960213),
(33, 2, 'employee', 'login', 2, 'login', '', 1594079013),
(34, 2, 'employee', 'login', 2, 'login', '', 1594079335),
(35, 2, 'employee', 'login', 2, 'login', '', 1594239168),
(36, 1, 'user', 'role', 6, 'add', '', 1594702021),
(37, 5, 'employee', 'login', 5, 'login', '', 1594702377),
(38, 5, 'employee', 'login', 5, 'login', '', 1594702646),
(39, 1, 'employee', 'login', 1, 'login', '', 1594702680),
(40, 1, 'user', 'role', 6, 'update', 'lang_permissions::admin,company-structure,company-structure-add,company-structure-edit,company-structure-delete,job-title,job-title-add,job-title-edit,job-title-delete,pay-grade,pay-grade-add,pay-grade-edit,pay-grade-delete,employment-status,employment-status-add,employment-status-edit,employment-status-delete,skill,skill-add,skill-edit,skill-delete,education,education-add,education-edit,education-delete,certification,certification-add,certification-edit,certification-delete,language,language-add,language-edit,language-delete,course,course-add,course-edit,course-delete,training-session,training-session-add,training-session-edit,training-session-delete,employee-training-session,employee-training-session-add,employee-training-session-edit,employee-training-session-delete,client,client-add,client-edit,client-delete,project,project-add,project-edit,project-delete,employee-project,employee-project-add,employee-project-edit,employee-project-delete,leave-type,leave-type-add,leave-type-edit,leave-type-delete,leave-period,leave-period-add,leave-period-edit,leave-period-delete,work-week,work-week-add,work-week-edit,work-week-delete,holiday,holiday-add,holiday-edit,holiday-delete,leave-rule,leave-rule-add,leave-rule-edit,leave-rule-delete,paid-time-off,paid-time-off-add,paid-time-off-edit,paid-time-off-delete,skill,skill-add,skill-edit,skill-delete,leave-group,leave-group-add,leave-group-edit,leave-group-delete,leave-group-employee,leave-group-employee-add,leave-group-employee-edit,leave-group-employee-delete,employee-leave-list,expense-category,expense-category-add,expense-category-edit,expense-category-delete,payment-method,payment-method-add,payment-method-edit,payment-method-delete,employee-expense,employee-expense-add,employee-expense-edit,employee-expense-delete,overtime-category,overtime-category-add,overtime-category-edit,overtime-category-delete,loan-type,loan-type-add,loan-type-edit,loan-type-delete,employee-loan,employee-loan-add,employee-loan-edit,employee-loan-delete,company-asset-type,company-asset-type-add,company-asset-type-edit,company-asset-type-delete,company-asset,company-asset-add,company-asset-edit,company-asset-delete,audit-log,employee-skill,employee-skill-add,employee-skill-edit,employee-skill-delete,overtime,overtime-add,overtime-edit,overtime-delete,employment-type,employment-type-add,employment-type-edit,employment-type-delete,job-function,job-function-add,job-function-edit,job-function-delete,job-position,job-position-add,job-position-edit,job-position-delete,candidate,candidate-add,candidate-edit,candidate-delete,employees,employee-add,employee-edit,employee-delete,itenerary-request,itenerary-request-add,itenerary-request-edit,itenerary-request-delete,company-document,company-document-add,company-document-edit,company-document-delete,document-type,document-type-add,document-type-edit,document-type-delete,employee-document,employee-document-add,employee-document-edit,employee-document-delete,workshift-management,workshift-add,workshift-edit,workshift-delete,workshift-assignment,workshift-add-assignment,workshift-edit-assignment,workshift-delete-assignment==admin,company-structure,company-structure-add,company-structure-edit,company-structure-delete,job-title,job-title-add,job-title-edit,job-title-delete,pay-grade,pay-grade-add,pay-grade-edit,pay-grade-delete,employment-status,employment-status-add,employment-status-edit,employment-status-delete,skill,skill-add,skill-edit,skill-delete,education,education-add,education-edit,education-delete,certification,certification-add,certification-edit,certification-delete,language,language-add,language-edit,language-delete,course,course-add,course-edit,course-delete,training-session,training-session-add,training-session-edit,training-session-delete,employee-training-session,employee-training-session-add,employee-training-session-edit,employee-training-session-delete,client,client-add,client-edit,client-delete,project,project-add,project-edit,project-delete,employee-project,employee-project-add,employee-project-edit,employee-project-delete,leave-type,leave-type-add,leave-type-edit,leave-type-delete,leave-period,leave-period-add,leave-period-edit,leave-period-delete,work-week,work-week-add,work-week-edit,work-week-delete,holiday,holiday-add,holiday-edit,holiday-delete,leave-rule,leave-rule-add,leave-rule-edit,leave-rule-delete,paid-time-off,paid-time-off-add,paid-time-off-edit,paid-time-off-delete,skill,skill-add,skill-edit,skill-delete,leave-group,leave-group-add,leave-group-edit,leave-group-delete,leave-group-employee,leave-group-employee-add,leave-group-employee-edit,leave-group-employee-delete,employee-leave-list,expense-category,expense-category-add,expense-category-edit,expense-category-delete,payment-method,payment-method-add,payment-method-edit,payment-method-delete,employee-expense,employee-expense-add,employee-expense-edit,employee-expense-delete,overtime-category,overtime-category-add,overtime-category-edit,overtime-category-delete,loan-type,loan-type-add,loan-type-edit,loan-type-delete,employee-loan,employee-loan-add,employee-loan-edit,employee-loan-delete,company-asset-type,company-asset-type-add,company-asset-type-edit,company-asset-type-delete,company-asset,company-asset-add,company-asset-edit,company-asset-delete,audit-log,employee-skill,employee-skill-add,employee-skill-edit,employee-skill-delete,daily-time-records,overtime,overtime-add,overtime-edit,overtime-delete,employment-type,employment-type-add,employment-type-edit,employment-type-delete,job-function,job-function-add,job-function-edit,job-function-delete,job-position,job-position-add,job-position-edit,job-position-delete,candidate,candidate-add,candidate-edit,candidate-delete,employees,employee-add,employee-edit,employee-delete,itenerary-request,itenerary-request-add,itenerary-request-edit,itenerary-request-delete,company-document,company-document-add,company-document-edit,company-document-delete,document-type,document-type-add,document-type-edit,document-type-delete,employee-document,employee-document-add,employee-document-edit,employee-document-delete,workshift-management,workshift-add,workshift-edit,workshift-delete,workshift-assignment,workshift-add-assignment,workshift-edit-assignment,workshift-delete-assignment,client-add,client-edit,client-delete,admin', 1594704353),
(41, 5, 'employee', 'login', 5, 'login', '', 1594704364),
(42, 5, 'employee', 'login', 5, 'login', '', 1594706907),
(43, 5, 'employee', 'login', 5, 'login', '', 1594707800),
(44, 1, 'user', 'role', 4, 'update', 'lang_permissions::employees,employee-add,employee-edit,employee-delete==overtime,overtime-add,overtime-edit,overtime-delete,employees,employee-add,employee-edit,employee-delete', 1594707870),
(45, 5, 'employee', 'login', 5, 'login', '', 1594707892),
(46, 1, 'user', 'role', 7, 'add', '', 1594723650),
(47, 1, 'user', 'role', 8, 'add', '', 1594723798),
(48, 1, 'user', 'user', 3, 'add', '', 1594799327),
(49, 1, 'user', 'role', 9, 'add', '', 1594800403),
(50, 1, 'employee', 'login', 1, 'login', '', 1594800828),
(51, 1, 'user', 'role', 6, 'update', 'lang_permissions::admin,company-structure,company-structure-add,company-structure-edit,company-structure-delete,job-title,job-title-add,job-title-edit,job-title-delete,pay-grade,pay-grade-add,pay-grade-edit,pay-grade-delete,employment-status,employment-status-add,employment-status-edit,employment-status-delete,skill,skill-add,skill-edit,skill-delete,education,education-add,education-edit,education-delete,certification,certification-add,certification-edit,certification-delete,language,language-add,language-edit,language-delete,course,course-add,course-edit,course-delete,training-session,training-session-add,training-session-edit,training-session-delete,employee-training-session,employee-training-session-add,employee-training-session-edit,employee-training-session-delete,client,client-add,client-edit,client-delete,project,project-add,project-edit,project-delete,employee-project,employee-project-add,employee-project-edit,employee-project-delete,leave-type,leave-type-add,leave-type-edit,leave-type-delete,leave-period,leave-period-add,leave-period-edit,leave-period-delete,work-week,work-week-add,work-week-edit,work-week-delete,holiday,holiday-add,holiday-edit,holiday-delete,leave-rule,leave-rule-add,leave-rule-edit,leave-rule-delete,paid-time-off,paid-time-off-add,paid-time-off-edit,paid-time-off-delete,skill,skill-add,skill-edit,skill-delete,leave-group,leave-group-add,leave-group-edit,leave-group-delete,leave-group-employee,leave-group-employee-add,leave-group-employee-edit,leave-group-employee-delete,employee-leave-list,expense-category,expense-category-add,expense-category-edit,expense-category-delete,payment-method,payment-method-add,payment-method-edit,payment-method-delete,employee-expense,employee-expense-add,employee-expense-edit,employee-expense-delete,overtime-category,overtime-category-add,overtime-category-edit,overtime-category-delete,loan-type,loan-type-add,loan-type-edit,loan-type-delete,employee-loan,employee-loan-add,employee-loan-edit,employee-loan-delete,company-asset-type,company-asset-type-add,company-asset-type-edit,company-asset-type-delete,company-asset,company-asset-add,company-asset-edit,company-asset-delete,audit-log,employee-skill,employee-skill-add,employee-skill-edit,employee-skill-delete,daily-time-records,overtime,overtime-add,overtime-edit,overtime-delete,employment-type,employment-type-add,employment-type-edit,employment-type-delete,job-function,job-function-add,job-function-edit,job-function-delete,job-position,job-position-add,job-position-edit,job-position-delete,candidate,candidate-add,candidate-edit,candidate-delete,employees,employee-add,employee-edit,employee-delete,itenerary-request,itenerary-request-add,itenerary-request-edit,itenerary-request-delete,company-document,company-document-add,company-document-edit,company-document-delete,document-type,document-type-add,document-type-edit,document-type-delete,employee-document,employee-document-add,employee-document-edit,employee-document-delete,workshift-management,workshift-add,workshift-edit,workshift-delete,workshift-assignment,workshift-add-assignment,workshift-edit-assignment,workshift-delete-assignment,client-add,client-edit,client-delete,admin==admin,company-structure,company-structure-add,company-structure-edit,company-structure-delete,job-title,job-title-add,job-title-edit,job-title-delete,pay-grade,pay-grade-add,pay-grade-edit,pay-grade-delete,employment-status,employment-status-add,employment-status-edit,employment-status-delete,skill,skill-add,skill-edit,skill-delete,education,education-add,education-edit,education-delete,certification,certification-add,certification-edit,certification-delete,language,language-add,language-edit,language-delete,course,course-add,course-edit,course-delete,training-session,training-session-add,training-session-edit,training-session-delete,employee-training-session,employee-training-session-add,employee-training-session-edit,employee-training-session-delete,client,client-add,client-edit,client-delete,project,project-add,project-edit,project-delete,employee-project,employee-project-add,employee-project-edit,employee-project-delete,leave-type,leave-type-add,leave-type-edit,leave-type-delete,leave-period,leave-period-add,leave-period-edit,leave-period-delete,work-week,work-week-add,work-week-edit,work-week-delete,holiday,holiday-add,holiday-edit,holiday-delete,leave-rule,leave-rule-add,leave-rule-edit,leave-rule-delete,paid-time-off,paid-time-off-add,paid-time-off-edit,paid-time-off-delete,skill,skill-add,skill-edit,skill-delete,leave-group,leave-group-add,leave-group-edit,leave-group-delete,leave-group-employee,leave-group-employee-add,leave-group-employee-edit,leave-group-employee-delete,employee-leave-list,expense-category,expense-category-add,expense-category-edit,expense-category-delete,payment-method,payment-method-add,payment-method-edit,payment-method-delete,employee-expense,employee-expense-add,employee-expense-edit,employee-expense-delete,overtime-category,overtime-category-add,overtime-category-edit,overtime-category-delete,loan-type,loan-type-add,loan-type-edit,loan-type-delete,employee-loan,employee-loan-add,employee-loan-edit,employee-loan-delete,company-asset-type,company-asset-type-add,company-asset-type-edit,company-asset-type-delete,company-asset,company-asset-add,company-asset-edit,company-asset-delete,audit-log,employee-skill,employee-skill-add,employee-skill-edit,employee-skill-delete,daily-time-records,attendance,overtime,overtime-add,overtime-edit,overtime-delete,employment-type,employment-type-add,employment-type-edit,employment-type-delete,job-function,job-function-add,job-function-edit,job-function-delete,job-position,job-position-add,job-position-edit,job-position-delete,candidate,candidate-add,candidate-edit,candidate-delete,employees,employee-add,employee-edit,employee-delete,itenerary-request,itenerary-request-add,itenerary-request-edit,itenerary-request-delete,company-document,company-document-add,company-document-edit,company-document-delete,document-type,document-type-add,document-type-edit,document-type-delete,employee-document,employee-document-add,employee-document-edit,employee-document-delete,workshift-management,workshift-add,workshift-edit,workshift-delete,workshift-assignment,workshift-add-assignment,workshift-edit-assignment,workshift-delete-assignment,client-add,client-edit,client-delete,admin', 1594801903),
(52, 1, 'user', 'role', 9, 'update', 'lang_permissions::work-week,work-week-add,work-week-edit,work-week-delete,holiday,holiday-add,holiday-edit,holiday-delete,leave-rule,leave-rule-add,leave-rule-edit,leave-rule-delete,paid-time-off,paid-time-off-add,paid-time-off-edit,paid-time-off-delete,leave-group,leave-group-add,leave-group-edit,leave-group-delete,leave-group-employee,leave-group-employee-add,leave-group-employee-edit,leave-group-employee-delete,employee-leave-list,daily-time-records,overtime,overtime-add,overtime-edit,workshift-management,workshift-add,workshift-edit,workshift-delete,workshift-assignment,workshift-add-assignment,workshift-edit-assignment,workshift-delete-assignment==work-week,work-week-add,work-week-edit,work-week-delete,holiday,holiday-add,holiday-edit,holiday-delete,leave-rule,leave-rule-add,leave-rule-edit,leave-rule-delete,paid-time-off,paid-time-off-add,paid-time-off-edit,paid-time-off-delete,leave-group,leave-group-add,leave-group-edit,leave-group-delete,leave-group-employee,leave-group-employee-add,leave-group-employee-edit,leave-group-employee-delete,employee-leave-list,daily-time-records,attendance,overtime,overtime-add,overtime-edit,workshift-management,workshift-add,workshift-edit,workshift-delete,workshift-assignment,workshift-add-assignment,workshift-edit-assignment,workshift-delete-assignment', 1594801927),
(53, 1, 'employee', 'login', 1, 'login', '', 1594801974),
(54, 1, 'employee', 'login', 1, 'login', '', 1594802436),
(55, 4, 'employee', 'login', 4, 'login', '', 1594803196),
(56, 1, 'employee', 'login', 1, 'login', '', 1594803633),
(57, 1, 'employee', 'login', 1, 'login', '', 1594822250),
(58, 1, 'employee', 'login', 1, 'login', '', 1594864927),
(59, 1, 'employee', 'login', 1, 'login', '', 1594866360),
(60, 4, 'employee', 'login', 4, 'login', '', 1594869421),
(61, 4, 'employee', 'login', 4, 'login', '', 1594869448),
(62, 4, 'employee', 'login', 4, 'login', '', 1594869466),
(63, 1, 'user', 'role', 8, 'update', 'lang_permissions::skill,skill-edit,education,education-edit,certification,certification-edit,language,language-edit,course,course-edit,leave-type,employee-leave-list,overtime-category,overtime-category-edit,employee-skill,employee-skill-edit,employee-education,employee-education-edit,employee-certification,employee-certification-edit,employee-language,employee-language-edit,employee-dependent,employee-dependent-edit,emergency-contact,emergency-contact-edit,daily-time-records,overtime,overtime-edit,education-level,education-level-edit,employment-type,itenerary-request,itenerary-request-edit,document-type,document-type-edit,employee-document,employee-document-edit==skill,skill-edit,education,education-edit,certification,certification-edit,language,language-edit,course,course-edit,leave-type,skill,skill-edit,employee-leave-list,overtime-category,overtime-category-edit,employee-skill,employee-skill-edit,employee-education,employee-education-edit,employee-certification,employee-certification-edit,employee-language,employee-language-edit,employee-dependent,employee-dependent-edit,emergency-contact,emergency-contact-edit,daily-time-records,attendance,overtime,overtime-edit,education-level,education-level-edit,employment-type,itenerary-request,itenerary-request-edit,document-type,document-type-edit,employee-document,employee-document-edit', 1594869522),
(64, 1, 'user', 'role', 7, 'update', 'lang_permissions::job-title,job-title-add,job-title-edit,job-title-delete,pay-grade,pay-grade-add,pay-grade-edit,pay-grade-delete,employment-status,employment-status-add,employment-status-edit,employment-status-delete,skill,skill-add,skill-edit,skill-delete,education,education-add,education-edit,education-delete,certification,certification-add,certification-edit,certification-delete,language,language-add,language-edit,language-delete,client,client-add,client-edit,client-delete,project,project-add,project-edit,project-delete,employee-project,employee-project-add,employee-project-edit,employee-project-delete,leave-type,leave-type-add,leave-type-edit,leave-type-delete,leave-period,leave-period-add,leave-period-edit,leave-period-delete,work-week,work-week-add,work-week-edit,work-week-delete,holiday,holiday-add,holiday-edit,holiday-delete,leave-rule,leave-rule-add,leave-rule-edit,leave-rule-delete,paid-time-off,paid-time-off-add,paid-time-off-edit,paid-time-off-delete,skill,skill-add,skill-edit,skill-delete,leave-group,leave-group-add,leave-group-edit,leave-group-delete,leave-group-employee,leave-group-employee-add,leave-group-employee-edit,leave-group-employee-delete,employee-leave-list,expense-category,expense-category-add,expense-category-edit,expense-category-delete,payment-method,payment-method-add,payment-method-edit,payment-method-delete,employee-expense,employee-expense-add,employee-expense-edit,employee-expense-delete,overtime-category,overtime-category-add,overtime-category-edit,overtime-category-delete,loan-type,loan-type-add,loan-type-edit,loan-type-delete,employee-loan,employee-loan-add,employee-loan-edit,employee-loan-delete,company-asset-type,company-asset-type-add,company-asset-type-edit,company-asset-type-delete,company-asset,company-asset-add,company-asset-edit,company-asset-delete,employee-skill,employee-skill-add,employee-skill-edit,employee-skill-delete,employee-education,employee-education-add,employee-education-edit,employee-education-delete,employee-certification,employee-certification-add,employee-certification-edit,employee-certification-delete,employee-language,employee-language-add,employee-language-edit,employee-language-delete,employee-dependent,employee-dependent-add,employee-dependent-edit,employee-dependent-delete,emergency-contact,emergency-contact-add,emergency-contact-edit,emergency-contact-delete,daily-time-records,overtime,overtime-add,overtime-edit,overtime-delete,benefit,benefit-add,benefit-edit,benefit-delete,education-level,education-level-add,education-level-edit,education-level-delete,employment-type,employment-type-add,employment-type-edit,employment-type-delete,experience-level,experience-level-add,experience-level-edit,experience-level-delete,job-function,job-function-add,job-function-delete,job-position,job-position-add,job-position-edit,job-position-delete,candidate,candidate-add,candidate-edit,candidate-delete,employees,employee-add,employee-edit,employee-delete,itenerary-request,itenerary-request-add,itenerary-request-edit,itenerary-request-delete,company-document,company-document-add,company-document-edit,company-document-delete,document-type,document-type-add,document-type-edit,document-type-delete,employee-document,employee-document-add,employee-document-edit,employee-document-delete,workshift-management,workshift-add,workshift-edit,workshift-delete,workshift-assignment,workshift-add-assignment,workshift-edit-assignment,workshift-delete-assignment==job-title,job-title-add,job-title-edit,job-title-delete,pay-grade,pay-grade-add,pay-grade-edit,pay-grade-delete,employment-status,employment-status-add,employment-status-edit,employment-status-delete,skill,skill-add,skill-edit,skill-delete,education,education-add,education-edit,education-delete,certification,certification-add,certification-edit,certification-delete,language,language-add,language-edit,language-delete,client,client-add,client-edit,client-delete,project,project-add,project-edit,project-delete,employee-project,employee-project-add,employee-project-edit,employee-project-delete,leave-type,leave-type-add,leave-type-edit,leave-type-delete,leave-period,leave-period-add,leave-period-edit,leave-period-delete,work-week,work-week-add,work-week-edit,work-week-delete,holiday,holiday-add,holiday-edit,holiday-delete,leave-rule,leave-rule-add,leave-rule-edit,leave-rule-delete,paid-time-off,paid-time-off-add,paid-time-off-edit,paid-time-off-delete,skill,skill-add,skill-edit,skill-delete,leave-group,leave-group-add,leave-group-edit,leave-group-delete,leave-group-employee,leave-group-employee-add,leave-group-employee-edit,leave-group-employee-delete,employee-leave-list,expense-category,expense-category-add,expense-category-edit,expense-category-delete,payment-method,payment-method-add,payment-method-edit,payment-method-delete,employee-expense,employee-expense-add,employee-expense-edit,employee-expense-delete,overtime-category,overtime-category-add,overtime-category-edit,overtime-category-delete,loan-type,loan-type-add,loan-type-edit,loan-type-delete,employee-loan,employee-loan-add,employee-loan-edit,employee-loan-delete,company-asset-type,company-asset-type-add,company-asset-type-edit,company-asset-type-delete,company-asset,company-asset-add,company-asset-edit,company-asset-delete,employee-skill,employee-skill-add,employee-skill-edit,employee-skill-delete,employee-education,employee-education-add,employee-education-edit,employee-education-delete,employee-certification,employee-certification-add,employee-certification-edit,employee-certification-delete,employee-language,employee-language-add,employee-language-edit,employee-language-delete,employee-dependent,employee-dependent-add,employee-dependent-edit,employee-dependent-delete,emergency-contact,emergency-contact-add,emergency-contact-edit,emergency-contact-delete,daily-time-records,attendance,overtime,overtime-add,overtime-edit,overtime-delete,benefit,benefit-add,benefit-edit,benefit-delete,education-level,education-level-add,education-level-edit,education-level-delete,employment-type,employment-type-add,employment-type-edit,employment-type-delete,experience-level,experience-level-add,experience-level-edit,experience-level-delete,job-function,job-function-add,job-function-delete,job-position,job-position-add,job-position-edit,job-position-delete,candidate,candidate-add,candidate-edit,candidate-delete,employees,employee-add,employee-edit,employee-delete,itenerary-request,itenerary-request-add,itenerary-request-edit,itenerary-request-delete,company-document,company-document-add,company-document-edit,company-document-delete,document-type,document-type-add,document-type-edit,document-type-delete,employee-document,employee-document-add,employee-document-edit,employee-document-delete,workshift-management,workshift-add,workshift-edit,workshift-delete,workshift-assignment,workshift-add-assignment,workshift-edit-assignment,workshift-delete-assignment,client-add,client-edit,client-delete', 1594869554),
(65, 4, 'employee', 'login', 4, 'login', '', 1594869647),
(66, 4, 'employee', 'login', 4, 'login', '', 1594869791),
(67, 2, 'employee', 'login', 2, 'login', '', 1594869936),
(68, 1, 'user', 'role', 4, 'update', 'lang_permissions::overtime,overtime-add,overtime-edit,overtime-delete,employees,employee-add,employee-edit,employee-delete==employee-leave-list,daily-time-records,attendance,overtime,overtime-add,overtime-edit,overtime-delete,employees,employee-add,employee-edit,employee-delete', 1594870087),
(69, 2, 'employee', 'login', 2, 'login', '', 1594870111),
(70, 2, 'employee', 'login', 2, 'login', '', 1594872313),
(71, 1, 'user', 'role', 8, 'update', 'lang_permissions::skill,skill-edit,education,education-edit,certification,certification-edit,language,language-edit,course,course-edit,leave-type,skill,skill-edit,employee-leave-list,overtime-category,overtime-category-edit,employee-skill,employee-skill-edit,employee-education,employee-education-edit,employee-certification,employee-certification-edit,employee-language,employee-language-edit,employee-dependent,employee-dependent-edit,emergency-contact,emergency-contact-edit,daily-time-records,attendance,overtime,overtime-edit,education-level,education-level-edit,employment-type,itenerary-request,itenerary-request-edit,document-type,document-type-edit,employee-document,employee-document-edit==work-week,work-week-add,work-week-edit,work-week-delete,employee-leave-list,overtime-category,employee-skill,employee-skill-edit,employee-education,employee-education-edit,employee-certification,employee-certification-edit,employee-language,employee-language-add,employee-language-edit,employee-dependent,employee-dependent-add,employee-dependent-edit,emergency-contact,emergency-contact-add,emergency-contact-edit,daily-time-records,attendance,overtime,overtime-add,overtime-edit,education-level,education-level-add,education-level-edit,employment-type,employment-type-add,employment-type-edit,experience-level,experience-level-add,experience-level-edit,job-function,job-function-add,job-function-edit,job-position,job-position-add,job-position-edit,itenerary-request,itenerary-request-add,itenerary-request-edit,document-type,document-type-edit,employee-document,employee-document-edit', 1594872513),
(72, 2, 'employee', 'login', 2, 'login', '', 1594874228),
(73, 6, 'employee', 'login', 6, 'login', '', 1594874501),
(74, 1, 'user', 'role', 6, 'update', 'lang_permissions::admin,company-structure,company-structure-add,company-structure-edit,company-structure-delete,job-title,job-title-add,job-title-edit,job-title-delete,pay-grade,pay-grade-add,pay-grade-edit,pay-grade-delete,employment-status,employment-status-add,employment-status-edit,employment-status-delete,skill,skill-add,skill-edit,skill-delete,education,education-add,education-edit,education-delete,certification,certification-add,certification-edit,certification-delete,language,language-add,language-edit,language-delete,course,course-add,course-edit,course-delete,training-session,training-session-add,training-session-edit,training-session-delete,employee-training-session,employee-training-session-add,employee-training-session-edit,employee-training-session-delete,client,client-add,client-edit,client-delete,project,project-add,project-edit,project-delete,employee-project,employee-project-add,employee-project-edit,employee-project-delete,leave-type,leave-type-add,leave-type-edit,leave-type-delete,leave-period,leave-period-add,leave-period-edit,leave-period-delete,work-week,work-week-add,work-week-edit,work-week-delete,holiday,holiday-add,holiday-edit,holiday-delete,leave-rule,leave-rule-add,leave-rule-edit,leave-rule-delete,paid-time-off,paid-time-off-add,paid-time-off-edit,paid-time-off-delete,skill,skill-add,skill-edit,skill-delete,leave-group,leave-group-add,leave-group-edit,leave-group-delete,leave-group-employee,leave-group-employee-add,leave-group-employee-edit,leave-group-employee-delete,employee-leave-list,expense-category,expense-category-add,expense-category-edit,expense-category-delete,payment-method,payment-method-add,payment-method-edit,payment-method-delete,employee-expense,employee-expense-add,employee-expense-edit,employee-expense-delete,overtime-category,overtime-category-add,overtime-category-edit,overtime-category-delete,loan-type,loan-type-add,loan-type-edit,loan-type-delete,employee-loan,employee-loan-add,employee-loan-edit,employee-loan-delete,company-asset-type,company-asset-type-add,company-asset-type-edit,company-asset-type-delete,company-asset,company-asset-add,company-asset-edit,company-asset-delete,audit-log,employee-skill,employee-skill-add,employee-skill-edit,employee-skill-delete,daily-time-records,attendance,overtime,overtime-add,overtime-edit,overtime-delete,employment-type,employment-type-add,employment-type-edit,employment-type-delete,job-function,job-function-add,job-function-edit,job-function-delete,job-position,job-position-add,job-position-edit,job-position-delete,candidate,candidate-add,candidate-edit,candidate-delete,employees,employee-add,employee-edit,employee-delete,itenerary-request,itenerary-request-add,itenerary-request-edit,itenerary-request-delete,company-document,company-document-add,company-document-edit,company-document-delete,document-type,document-type-add,document-type-edit,document-type-delete,employee-document,employee-document-add,employee-document-edit,employee-document-delete,workshift-management,workshift-add,workshift-edit,workshift-delete,workshift-assignment,workshift-add-assignment,workshift-edit-assignment,workshift-delete-assignment,client-add,client-edit,client-delete,admin==admin,company-structure,company-structure-add,company-structure-edit,company-structure-delete,job-title,job-title-add,job-title-edit,job-title-delete,pay-grade,pay-grade-add,pay-grade-edit,pay-grade-delete,employment-status,employment-status-add,employment-status-edit,employment-status-delete,skill,skill-add,skill-edit,skill-delete,education,education-add,education-edit,education-delete,certification,certification-add,certification-edit,certification-delete,language,language-add,language-edit,language-delete,course,course-add,course-edit,course-delete,training-session,training-session-add,training-session-edit,training-session-delete,employee-training-session,employee-training-session-add,employee-training-session-edit,employee-training-session-delete,client,client-add,client-edit,client-delete,project,project-add,project-edit,project-delete,employee-project,employee-project-add,employee-project-edit,employee-project-delete,leave-type,leave-type-add,leave-type-edit,leave-type-delete,leave-period,leave-period-add,leave-period-edit,leave-period-delete,work-week,work-week-add,work-week-edit,work-week-delete,holiday,holiday-add,holiday-edit,holiday-delete,leave-rule,leave-rule-add,leave-rule-edit,leave-rule-delete,paid-time-off,paid-time-off-add,paid-time-off-edit,paid-time-off-delete,skill,skill-add,skill-edit,skill-delete,leave-group,leave-group-add,leave-group-edit,leave-group-delete,leave-group-employee,leave-group-employee-add,leave-group-employee-edit,leave-group-employee-delete,employee-leave-list,expense-category,expense-category-add,expense-category-edit,expense-category-delete,payment-method,payment-method-add,payment-method-edit,payment-method-delete,employee-expense,employee-expense-add,employee-expense-edit,employee-expense-delete,overtime-category,overtime-category-add,overtime-category-edit,overtime-category-delete,loan-type,loan-type-add,loan-type-edit,loan-type-delete,employee-loan,employee-loan-add,employee-loan-edit,employee-loan-delete,company-asset-type,company-asset-type-add,company-asset-type-edit,company-asset-type-delete,company-asset,company-asset-add,company-asset-edit,company-asset-delete,audit-log,employee-skill,employee-skill-add,employee-skill-edit,employee-skill-delete,employee-education,employee-education-add,employee-education-edit,employee-education-delete,employee-certification,employee-certification-add,employee-certification-edit,employee-certification-delete,employee-language,employee-language-add,employee-language-edit,employee-language-delete,employee-dependent,employee-dependent-add,employee-dependent-edit,employee-dependent-delete,emergency-contact,emergency-contact-add,emergency-contact-edit,emergency-contact-delete,daily-time-records,attendance,overtime,overtime-add,overtime-edit,overtime-delete,benefit,benefit-add,benefit-edit,benefit-delete,education-level,education-level-add,education-level-edit,employment-type,employment-type-add,employment-type-edit,employment-type-delete,experience-level,experience-level-add,experience-level-edit,experience-level-delete,job-function,job-function-add,job-function-edit,job-function-delete,job-position,job-position-add,job-position-edit,job-position-delete,candidate,candidate-add,candidate-edit,candidate-delete,employees,employee-add,employee-edit,employee-delete,itenerary-request,itenerary-request-add,itenerary-request-edit,itenerary-request-delete,company-document,company-document-add,company-document-edit,company-document-delete,document-type,document-type-add,document-type-edit,document-type-delete,employee-document,employee-document-add,employee-document-edit,employee-document-delete,workshift-management,workshift-add,workshift-edit,workshift-delete,workshift-assignment,workshift-add-assignment,workshift-edit-assignment,workshift-delete-assignment,admin', 1594876339),
(75, 6, 'employee', 'login', 6, 'login', '', 1594876348),
(76, 1, 'user', 'role', 6, 'update', 'lang_permissions::admin,company-structure,company-structure-add,company-structure-edit,company-structure-delete,job-title,job-title-add,job-title-edit,job-title-delete,pay-grade,pay-grade-add,pay-grade-edit,pay-grade-delete,employment-status,employment-status-add,employment-status-edit,employment-status-delete,skill,skill-add,skill-edit,skill-delete,education,education-add,education-edit,education-delete,certification,certification-add,certification-edit,certification-delete,language,language-add,language-edit,language-delete,course,course-add,course-edit,course-delete,training-session,training-session-add,training-session-edit,training-session-delete,employee-training-session,employee-training-session-add,employee-training-session-edit,employee-training-session-delete,client,client-add,client-edit,client-delete,project,project-add,project-edit,project-delete,employee-project,employee-project-add,employee-project-edit,employee-project-delete,leave-type,leave-type-add,leave-type-edit,leave-type-delete,leave-period,leave-period-add,leave-period-edit,leave-period-delete,work-week,work-week-add,work-week-edit,work-week-delete,holiday,holiday-add,holiday-edit,holiday-delete,leave-rule,leave-rule-add,leave-rule-edit,leave-rule-delete,paid-time-off,paid-time-off-add,paid-time-off-edit,paid-time-off-delete,skill,skill-add,skill-edit,skill-delete,leave-group,leave-group-add,leave-group-edit,leave-group-delete,leave-group-employee,leave-group-employee-add,leave-group-employee-edit,leave-group-employee-delete,employee-leave-list,expense-category,expense-category-add,expense-category-edit,expense-category-delete,payment-method,payment-method-add,payment-method-edit,payment-method-delete,employee-expense,employee-expense-add,employee-expense-edit,employee-expense-delete,overtime-category,overtime-category-add,overtime-category-edit,overtime-category-delete,loan-type,loan-type-add,loan-type-edit,loan-type-delete,employee-loan,employee-loan-add,employee-loan-edit,employee-loan-delete,company-asset-type,company-asset-type-add,company-asset-type-edit,company-asset-type-delete,company-asset,company-asset-add,company-asset-edit,company-asset-delete,audit-log,employee-skill,employee-skill-add,employee-skill-edit,employee-skill-delete,employee-education,employee-education-add,employee-education-edit,employee-education-delete,employee-certification,employee-certification-add,employee-certification-edit,employee-certification-delete,employee-language,employee-language-add,employee-language-edit,employee-language-delete,employee-dependent,employee-dependent-add,employee-dependent-edit,employee-dependent-delete,emergency-contact,emergency-contact-add,emergency-contact-edit,emergency-contact-delete,daily-time-records,attendance,overtime,overtime-add,overtime-edit,overtime-delete,benefit,benefit-add,benefit-edit,benefit-delete,education-level,education-level-add,education-level-edit,employment-type,employment-type-add,employment-type-edit,employment-type-delete,experience-level,experience-level-add,experience-level-edit,experience-level-delete,job-function,job-function-add,job-function-edit,job-function-delete,job-position,job-position-add,job-position-edit,job-position-delete,candidate,candidate-add,candidate-edit,candidate-delete,employees,employee-add,employee-edit,employee-delete,itenerary-request,itenerary-request-add,itenerary-request-edit,itenerary-request-delete,company-document,company-document-add,company-document-edit,company-document-delete,document-type,document-type-add,document-type-edit,document-type-delete,employee-document,employee-document-add,employee-document-edit,employee-document-delete,workshift-management,workshift-add,workshift-edit,workshift-delete,workshift-assignment,workshift-add-assignment,workshift-edit-assignment,workshift-delete-assignment,admin==admin,company-structure,company-structure-add,company-structure-edit,company-structure-delete,job-title,job-title-add,job-title-edit,job-title-delete,pay-grade,pay-grade-add,pay-grade-edit,pay-grade-delete,employment-status,employment-status-add,employment-status-edit,employment-status-delete,skill,skill-add,skill-edit,skill-delete,education,education-add,education-edit,education-delete,certification,certification-add,certification-edit,certification-delete,language,language-add,language-edit,language-delete,course,course-add,course-edit,course-delete,training-session,training-session-add,training-session-edit,training-session-delete,employee-training-session,employee-training-session-add,employee-training-session-edit,employee-training-session-delete,client,client-add,client-edit,client-delete,project,project-add,project-edit,project-delete,employee-project,employee-project-add,employee-project-edit,employee-project-delete,leave-type,leave-type-add,leave-type-edit,leave-type-delete,leave-period,leave-period-add,leave-period-edit,leave-period-delete,work-week,work-week-add,work-week-edit,work-week-delete,holiday,holiday-add,holiday-edit,holiday-delete,leave-rule,leave-rule-add,leave-rule-edit,leave-rule-delete,paid-time-off,paid-time-off-add,paid-time-off-edit,paid-time-off-delete,skill,skill-add,skill-edit,skill-delete,leave-group,leave-group-add,leave-group-edit,leave-group-delete,leave-group-employee,leave-group-employee-add,leave-group-employee-edit,leave-group-employee-delete,employee-leave-list,expense-category,expense-category-add,expense-category-edit,expense-category-delete,payment-method,payment-method-add,payment-method-edit,payment-method-delete,employee-expense,employee-expense-add,employee-expense-edit,employee-expense-delete,overtime-category,overtime-category-add,overtime-category-edit,overtime-category-delete,loan-type,loan-type-add,loan-type-edit,loan-type-delete,employee-loan,employee-loan-add,employee-loan-edit,employee-loan-delete,company-asset-type,company-asset-type-add,company-asset-type-edit,company-asset-type-delete,company-asset,company-asset-add,company-asset-edit,company-asset-delete,audit-log,employee-skill,employee-skill-add,employee-skill-edit,employee-skill-delete,employee-education,employee-education-add,employee-education-edit,employee-education-delete,employee-certification,employee-certification-add,employee-certification-edit,employee-certification-delete,employee-language,employee-language-add,employee-language-edit,employee-language-delete,employee-dependent,employee-dependent-add,employee-dependent-edit,employee-dependent-delete,emergency-contact,emergency-contact-add,emergency-contact-edit,emergency-contact-delete,daily-time-records,attendance,overtime,overtime-add,overtime-edit,overtime-delete,benefit,benefit-add,benefit-edit,benefit-delete,education-level,education-level-add,education-level-edit,education-level-delete,employment-type,employment-type-add,employment-type-edit,employment-type-delete,experience-level,experience-level-add,experience-level-edit,experience-level-delete,job-function,job-function-add,job-function-edit,job-function-delete,job-position,job-position-add,job-position-edit,job-position-delete,candidate,candidate-add,candidate-edit,candidate-delete,employees,employee-add,employee-edit,employee-delete,itenerary-request,itenerary-request-add,itenerary-request-edit,itenerary-request-delete,company-document,company-document-add,company-document-edit,company-document-delete,document-type,document-type-add,document-type-edit,document-type-delete,employee-document,employee-document-add,employee-document-edit,employee-document-delete,workshift-management,workshift-add,workshift-edit,workshift-delete,workshift-assignment,workshift-add-assignment,workshift-edit-assignment,workshift-delete-assignment,clients,client-add,client-edit,client-delete,admin', 1594876424),
(77, 6, 'employee', 'login', 6, 'login', '', 1594877718),
(78, 3, 'employee', 'login', 3, 'login', '', 1594877752),
(79, 4, 'employee', 'login', 4, 'login', '', 1594878198),
(80, 2, 'employee', 'login', 2, 'login', '', 1594878836),
(81, 4, 'employee', 'login', 4, 'login', '', 1594879655),
(82, 6, 'employee', 'login', 6, 'login', '', 1594888219),
(83, 6, 'employee', 'login', 6, 'login', '', 1594894630),
(84, 1, 'employee', 'login', 1, 'login', '', 1597101238),
(85, 1, 'employee', 'login', 1, 'login', '', 1597219775),
(86, 1, 'employee', 'login', 1, 'login', '', 1597255862),
(87, 1, 'employee', 'login', 1, 'login', '', 1597255990),
(88, 1, 'employee', 'login', 1, 'login', '', 1597260864),
(89, 2, 'employee', 'login', 2, 'login', '', 1597288139),
(90, 3, 'employee', 'login', 3, 'login', '', 1597288242),
(91, 3, 'employee', 'login', 3, 'login', '', 1597288353),
(92, 1, 'employee', 'login', 1, 'login', '', 1597288406),
(93, 3, 'employee', 'login', 3, 'login', '', 1597288470),
(94, 3, 'employee', 'login', 3, 'login', '', 1597288534),
(95, 3, 'employee', 'login', 3, 'login', '', 1597288858),
(96, 3, 'employee', 'login', 3, 'login', '', 1597288945),
(97, 3, 'employee', 'login', 3, 'login', '', 1597289155),
(98, 3, 'employee', 'login', 3, 'login', '', 1597349267),
(99, 3, 'employee', 'login', 3, 'login', '', 1597362565),
(100, 1, 'employee', 'login', 1, 'login', '', 1597369384),
(101, 3, 'employee', 'login', 3, 'login', '', 1597369424),
(102, 3, 'employee', 'login', 3, 'login', '', 1597380114),
(103, 1, 'employee', 'login', 1, 'login', '', 1597383910),
(104, 3, 'employee', 'login', 3, 'login', '', 1597460394),
(105, 5, 'employee', 'login', 5, 'login', '', 1597735041),
(106, 5, 'employee', 'login', 5, 'login', '', 1597900578),
(107, 5, 'employee', 'login', 5, 'login', '', 1597900631),
(108, 1, 'employee', 'login', 1, 'login', '', 1597901230),
(109, 2, 'employee', 'login', 2, 'login', '', 1597901308),
(110, 1, 'employee', 'login', 1, 'login', '', 1598059857),
(111, 1, 'employee', 'login', 1, 'login', '', 1598060382),
(112, 1, 'employee', 'login', 1, 'login', '', 1598061128),
(113, 1, 'employee', 'login', 1, 'login', '', 1598061478),
(114, 2, 'employee', 'login', 2, 'login', '', 1598070995),
(115, 1, 'employee', 'login', 1, 'login', '', 1598078177),
(116, 1, 'employee', 'login', 1, 'login', '', 1598082835),
(117, 1, 'employee', 'login', 1, 'login', '', 1598082946),
(118, 1, 'employee', 'login', 1, 'login', '', 1598083254),
(119, 2, 'employee', 'login', 2, 'login', '', 1598083280),
(120, 2, 'employee', 'login', 2, 'login', '', 1598084207),
(121, 2, 'employee', 'login', 2, 'login', '', 1598084946),
(122, 3, 'employee', 'login', 3, 'login', '', 1598091452),
(123, 2, 'employee', 'login', 2, 'login', '', 1598095043),
(124, 3, 'employee', 'login', 3, 'login', '', 1598095107),
(125, 3, 'employee', 'login', 3, 'login', '', 1598098061),
(126, 2, 'employee', 'login', 2, 'login', '', 1598099823),
(127, 4, 'employee', 'login', 4, 'login', '', 1598150718),
(128, 1, 'employee', 'login', 1, 'login', '', 1598151245),
(129, 2, 'employee', 'login', 2, 'login', '', 1598151313),
(130, 4, 'employee', 'login', 4, 'login', '', 1598151402),
(131, 1, 'employee', 'login', 1, 'login', '', 1598152272),
(132, 2, 'employee', 'login', 2, 'login', '', 1598160858),
(133, 2, 'employee', 'login', 2, 'login', '', 1598163096),
(134, 487, 'employee', 'login', 487, 'login', '', 1598169691),
(135, 484, 'employee', 'login', 484, 'login', '', 1598169778),
(136, 486, 'employee', 'login', 486, 'login', '', 1598169880),
(137, 487, 'employee', 'login', 487, 'login', '', 1598169924),
(138, 488, 'employee', 'login', 488, 'login', '', 1598169928),
(139, 6, 'employee', 'login', 6, 'login', '', 1598235801),
(140, 5, 'employee', 'login', 5, 'login', '', 1598237796),
(141, 6, 'employee', 'login', 6, 'login', '', 1598237889),
(142, 5, 'employee', 'login', 5, 'login', '', 1598237960),
(143, 6, 'employee', 'login', 6, 'login', '', 1598238038),
(144, 6, 'employee', 'login', 6, 'login', '', 1598238844),
(145, 5, 'employee', 'login', 5, 'login', '', 1598238861),
(146, 6, 'employee', 'login', 6, 'login', '', 1598239117),
(147, 6, 'employee', 'login', 6, 'login', '', 1598239245),
(148, 6, 'employee', 'login', 6, 'login', '', 1598239454),
(149, 6, 'employee', 'login', 6, 'login', '', 1598239486),
(150, 6, 'employee', 'login', 6, 'login', '', 1598239564),
(151, 6, 'employee', 'login', 6, 'login', '', 1598240090),
(152, 6, 'employee', 'login', 6, 'login', '', 1598240192),
(153, 6, 'employee', 'login', 6, 'login', '', 1598240226),
(154, 6, 'employee', 'login', 6, 'login', '', 1598240243),
(155, 6, 'employee', 'login', 6, 'login', '', 1598240555),
(156, 6, 'employee', 'login', 6, 'login', '', 1598240688),
(157, 5, 'employee', 'login', 5, 'login', '', 1598240891),
(158, 6, 'employee', 'login', 6, 'login', '', 1598240994),
(159, 6, 'employee', 'login', 6, 'login', '', 1598254713),
(160, 6, 'employee', 'login', 6, 'login', '', 1598255020),
(161, 6, 'employee', 'login', 6, 'login', '', 1598255028),
(162, 5, 'employee', 'login', 5, 'login', '', 1598255033),
(163, 5, 'employee', 'login', 5, 'login', '', 1598255657),
(164, 6, 'employee', 'login', 6, 'login', '', 1598256525),
(165, 5, 'employee', 'login', 5, 'login', '', 1598258194),
(166, 6, 'employee', 'login', 6, 'login', '', 1598258583),
(167, 8, 'employee', 'login', 8, 'login', '', 1598313782),
(168, 5, 'employee', 'login', 5, 'login', '', 1598316723),
(169, 5, 'employee', 'login', 5, 'login', '', 1598316828),
(170, 9, 'employee', 'login', 9, 'login', '', 1598316849),
(171, 9, 'employee', 'login', 9, 'login', '', 1598316924),
(172, 8, 'employee', 'login', 8, 'login', '', 1598316941),
(173, 6, 'employee', 'login', 6, 'login', '', 1598317013),
(174, 7, 'employee', 'login', 7, 'login', '', 1598317176),
(175, 6, 'employee', 'login', 6, 'login', '', 1598317233),
(176, 8, 'employee', 'login', 8, 'login', '', 1598418679);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) NOT NULL,
  `sub_property_id` bigint(255) NOT NULL,
  `task_description` varchar(1000) NOT NULL,
  `task_proirity` int(10) NOT NULL DEFAULT '0',
  `task_type` int(10) NOT NULL DEFAULT '0',
  `start_date` bigint(255) NOT NULL DEFAULT '0',
  `due_date` bigint(255) NOT NULL DEFAULT '0',
  `temp_del` bigint(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `task_assigned`
--

DROP TABLE IF EXISTS `task_assigned`;
CREATE TABLE IF NOT EXISTS `task_assigned` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `task_id` bigint(255) NOT NULL,
  `employee_id` bigint(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `task_inspection_bm_checklist`
--

DROP TABLE IF EXISTS `task_inspection_bm_checklist`;
CREATE TABLE IF NOT EXISTS `task_inspection_bm_checklist` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `sub_property_id` bigint(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `created_by` bigint(255) NOT NULL,
  `account_mode` varchar(255) NOT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `task_inspection_bm_checklist_tab`
--

DROP TABLE IF EXISTS `task_inspection_bm_checklist_tab`;
CREATE TABLE IF NOT EXISTS `task_inspection_bm_checklist_tab` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `bm_checklist_id` bigint(255) NOT NULL,
  `tab_category` varchar(255) NOT NULL,
  `remarks` varchar(5000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `task_inspection_bm_checklist_tab_categories`
--

DROP TABLE IF EXISTS `task_inspection_bm_checklist_tab_categories`;
CREATE TABLE IF NOT EXISTS `task_inspection_bm_checklist_tab_categories` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `checklist_tab_id` bigint(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `check_value` int(10) DEFAULT '0',
  `check_color` int(10) DEFAULT NULL,
  `notes` varchar(5000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `task_inspection_emergency_light`
--

DROP TABLE IF EXISTS `task_inspection_emergency_light`;
CREATE TABLE IF NOT EXISTS `task_inspection_emergency_light` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `sub_property_id` varchar(250) NOT NULL,
  `month` varchar(10) CHARACTER SET utf16 NOT NULL,
  `conducted_by` varchar(250) NOT NULL,
  `conducted_date` varchar(20) NOT NULL,
  `room_department` varchar(250) NOT NULL,
  `location_area` varchar(250) NOT NULL,
  `reviewed_by` varchar(250) NOT NULL,
  `reviewed_date` varchar(20) NOT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `task_inspection_emergency_light_checklist`
--

DROP TABLE IF EXISTS `task_inspection_emergency_light_checklist`;
CREATE TABLE IF NOT EXISTS `task_inspection_emergency_light_checklist` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `inspection_el_id` bigint(255) NOT NULL,
  `item` int(20) NOT NULL,
  `standard` varchar(1000) DEFAULT NULL,
  `check_value` varchar(255) DEFAULT NULL,
  `remarks` varchar(1000) DEFAULT NULL,
  `actions` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `task_inspection_engineering_checklist`
--

DROP TABLE IF EXISTS `task_inspection_engineering_checklist`;
CREATE TABLE IF NOT EXISTS `task_inspection_engineering_checklist` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `sub_property_id` int(255) NOT NULL,
  `work_reference_no` varchar(255) NOT NULL,
  `rated_v_and_i` varchar(255) NOT NULL,
  `customer` varchar(255) NOT NULL,
  `test_equipment_used` varchar(255) NOT NULL,
  `inspected_by` varchar(255) NOT NULL,
  `inspected_date` varchar(255) NOT NULL,
  `inspected_time` varchar(255) NOT NULL,
  `checked_by` varchar(255) NOT NULL,
  `checked_date` varchar(255) NOT NULL,
  `checked_time` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `task_inspection_engineer_general_and_function_check`
--

DROP TABLE IF EXISTS `task_inspection_engineer_general_and_function_check`;
CREATE TABLE IF NOT EXISTS `task_inspection_engineer_general_and_function_check` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `engineering_id` int(255) NOT NULL,
  `criteria` varchar(255) NOT NULL,
  `item_no` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `task_inspection_engineer_power_and_grounding_wirings`
--

DROP TABLE IF EXISTS `task_inspection_engineer_power_and_grounding_wirings`;
CREATE TABLE IF NOT EXISTS `task_inspection_engineer_power_and_grounding_wirings` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `engineering_id` int(255) NOT NULL,
  `power_wirings` varchar(255) NOT NULL,
  `grounding_wire` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `task_inspection_engineer_supply_voltage_and_load_current_reading`
--

DROP TABLE IF EXISTS `task_inspection_engineer_supply_voltage_and_load_current_reading`;
CREATE TABLE IF NOT EXISTS `task_inspection_engineer_supply_voltage_and_load_current_reading` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `engineering_id` int(255) NOT NULL,
  `l1_l2` varchar(255) NOT NULL,
  `l2_l3` varchar(255) NOT NULL,
  `l1_l3` varchar(255) NOT NULL,
  `u` varchar(255) NOT NULL,
  `v` varchar(255) NOT NULL,
  `w` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `task_inspection_fire_extinguisher`
--

DROP TABLE IF EXISTS `task_inspection_fire_extinguisher`;
CREATE TABLE IF NOT EXISTS `task_inspection_fire_extinguisher` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `sub_property_id` bigint(255) NOT NULL,
  `month` varchar(10) NOT NULL,
  `year` varchar(255) NOT NULL,
  `room_department` varchar(255) DEFAULT NULL,
  `location_area` varchar(255) DEFAULT NULL,
  `tagging` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `conducted_by` bigint(255) DEFAULT NULL,
  `conducted_date` varchar(255) DEFAULT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `task_inspection_fire_extinguisher_checklist`
--

DROP TABLE IF EXISTS `task_inspection_fire_extinguisher_checklist`;
CREATE TABLE IF NOT EXISTS `task_inspection_fire_extinguisher_checklist` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `inspection_fe_id` bigint(255) NOT NULL,
  `item` int(20) NOT NULL,
  `standard` varchar(1000) DEFAULT NULL,
  `check_value` varchar(255) DEFAULT NULL,
  `remarks` varchar(1000) DEFAULT NULL,
  `actions` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `task_inspection_maintenance_fcu`
--

DROP TABLE IF EXISTS `task_inspection_maintenance_fcu`;
CREATE TABLE IF NOT EXISTS `task_inspection_maintenance_fcu` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `sub_property_id` int(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `model_no` varchar(255) NOT NULL,
  `location_unit_no` varchar(255) NOT NULL,
  `serial_no` varchar(250) NOT NULL,
  `time_started` varchar(255) NOT NULL,
  `time_finished` varchar(255) DEFAULT NULL,
  `recommendations` varchar(1000) DEFAULT NULL,
  `conducted_by` varchar(255) NOT NULL,
  `acknowledged_by` varchar(255) NOT NULL,
  `noted_by` varchar(255) NOT NULL,
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `task_inspection_maintenance_fcu_items`
--

DROP TABLE IF EXISTS `task_inspection_maintenance_fcu_items`;
CREATE TABLE IF NOT EXISTS `task_inspection_maintenance_fcu_items` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `fcu_id` int(255) NOT NULL,
  `scope_of_works` varchar(500) NOT NULL,
  `remarks` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `task_job_order`
--

DROP TABLE IF EXISTS `task_job_order`;
CREATE TABLE IF NOT EXISTS `task_job_order` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `job_order_no` bigint(255) NOT NULL,
  `unit_id` bigint(255) NOT NULL DEFAULT '0',
  `assigned` varchar(255) DEFAULT NULL,
  `target_id` bigint(255) NOT NULL,
  `target_category` int(20) NOT NULL,
  `requestor_account_mode` varchar(255) NOT NULL,
  `job_order_date` varchar(255) DEFAULT NULL,
  `job_order_nature` int(10) DEFAULT NULL,
  `job_order_nature_specify` varchar(500) DEFAULT NULL,
  `job_order_description` varchar(10000) DEFAULT NULL,
  `priority` int(20) NOT NULL DEFAULT '0',
  `status` int(20) NOT NULL DEFAULT '0',
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `task_work_order`
--

DROP TABLE IF EXISTS `task_work_order`;
CREATE TABLE IF NOT EXISTS `task_work_order` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `work_order_no` bigint(255) NOT NULL,
  `unit_id` bigint(255) NOT NULL DEFAULT '0',
  `employee_id` bigint(255) DEFAULT NULL,
  `target_id` bigint(255) DEFAULT NULL,
  `target_category` int(20) DEFAULT '0',
  `requestor_account_mode` varchar(255) NOT NULL,
  `work_order_date` varchar(255) NOT NULL,
  `work_order_nature` int(10) NOT NULL DEFAULT '0',
  `work_order_nature_specify` varchar(500) DEFAULT '',
  `work_order_description` varchar(10000) DEFAULT NULL,
  `priority` int(20) NOT NULL DEFAULT '0',
  `status` int(20) NOT NULL DEFAULT '0',
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

DROP TABLE IF EXISTS `tenants`;
CREATE TABLE IF NOT EXISTS `tenants` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `tenant_id` varchar(20) NOT NULL,
  `upass` varchar(200) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL DEFAULT '',
  `lastname` varchar(50) NOT NULL,
  `gender` int(1) NOT NULL DEFAULT '0',
  `birthdate` varchar(10) NOT NULL DEFAULT '',
  `citizenship_id` bigint(255) NOT NULL DEFAULT '0',
  `relationship_to_owner` varchar(250) DEFAULT NULL,
  `social_status` varchar(250) DEFAULT NULL,
  `parking` varchar(255) DEFAULT NULL,
  `photo` varchar(100) NOT NULL DEFAULT '',
  `language` int(2) NOT NULL DEFAULT '0',
  `data_per_page` int(3) NOT NULL DEFAULT '20',
  `last_login` int(20) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `time_logs`
--

DROP TABLE IF EXISTS `time_logs`;
CREATE TABLE IF NOT EXISTS `time_logs` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `employee_id` bigint(255) NOT NULL,
  `time_in` int(20) NOT NULL,
  `time_out` int(20) NOT NULL DEFAULT '0',
  `time_rendered` int(20) NOT NULL DEFAULT '0',
  `date_code` varchar(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `unidentified`
--

DROP TABLE IF EXISTS `unidentified`;
CREATE TABLE IF NOT EXISTS `unidentified` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `sub_property_id` bigint(255) NOT NULL,
  `form_of_payment` varchar(255) DEFAULT NULL,
  `date_deposited` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `bank` int(10) DEFAULT NULL,
  `other_bank` varchar(255) DEFAULT NULL,
  `deposit_reference` varchar(255) DEFAULT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
CREATE TABLE IF NOT EXISTS `units` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(10) NOT NULL DEFAULT '',
  `unit_capacity` int(3) NOT NULL DEFAULT '1',
  `unit_owner_id` bigint(255) NOT NULL DEFAULT '0',
  `property_id` bigint(255) NOT NULL DEFAULT '0',
  `sub_property_id` bigint(255) NOT NULL DEFAULT '0',
  `unit_type` int(1) NOT NULL DEFAULT '0',
  `commercial_unit_type_id` bigint(255) NOT NULL DEFAULT '0',
  `vacancy_status` int(1) NOT NULL DEFAULT '0',
  `vacancy_type` int(1) NOT NULL DEFAULT '0',
  `unit_area` float NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `unit_owners`
--

DROP TABLE IF EXISTS `unit_owners`;
CREATE TABLE IF NOT EXISTS `unit_owners` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `unit_owner_id` varchar(20) NOT NULL,
  `upass` varchar(200) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL DEFAULT '',
  `lastname` varchar(50) NOT NULL,
  `gender` int(1) NOT NULL DEFAULT '0',
  `civil_status` int(1) NOT NULL DEFAULT '0',
  `birthdate` varchar(10) NOT NULL DEFAULT '',
  `citizenship_id` bigint(255) NOT NULL DEFAULT '0',
  `parking` varchar(255) DEFAULT NULL,
  `photo` varchar(100) NOT NULL DEFAULT '',
  `language` int(2) NOT NULL DEFAULT '0',
  `last_login` int(20) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `unit_tenants`
--

DROP TABLE IF EXISTS `unit_tenants`;
CREATE TABLE IF NOT EXISTS `unit_tenants` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `unit_id` bigint(255) NOT NULL DEFAULT '0',
  `tenant_id` bigint(255) NOT NULL DEFAULT '0',
  `date_from` int(8) NOT NULL DEFAULT '0',
  `date_to` int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `uname` varchar(20) NOT NULL,
  `upass` varchar(200) NOT NULL,
  `firstname` varchar(50) NOT NULL DEFAULT '',
  `lastname` varchar(50) NOT NULL DEFAULT '',
  `role_ids` varchar(500) NOT NULL DEFAULT ',',
  `permissions` varchar(20000) NOT NULL DEFAULT '',
  `language` int(2) NOT NULL DEFAULT '0',
  `data_per_page` int(3) NOT NULL DEFAULT '20',
  `last_login` int(20) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `temp_del` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uname`, `upass`, `firstname`, `lastname`, `role_ids`, `permissions`, `language`, `data_per_page`, `last_login`, `status`, `temp_del`) VALUES
(1, 'superadmin', 'vPmx+MLTHVVPYovF9mbudINnch0QLFpDMh3S0omg5dNjrKBjj3GTOH1Zy9YBTGQu3kQ3dMu07lZR65guGg2WIA==', 'Super', 'Admin', ',1,', '', 0, 20, 1598262953, 0, 0),
(2, 'admin', 'wVvRN8Mt3dRGPZKj3XTs9uJYhci0R2JZa/DnhmTcK0PeH7riZ7No5xpxVhk0VZJFfPwOtot4oGYcP80O6jWo/A==', 'Ryan', 'Reyes', ',2,', '', 0, 20, 0, 0, 0),
(3, 'hr officer', 'otxJGP8L6v2T7IrkClUikn0ZAZjxPUiEa2r2XVHAmowwysA09f+m5WxGe6s128JT9kS5C6Fywpc+FTgifPCfIA==', 'Isay', 'Castillo', ',6,', '', 0, 20, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

DROP TABLE IF EXISTS `visitors`;
CREATE TABLE IF NOT EXISTS `visitors` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `sub_property_id` bigint(255) NOT NULL DEFAULT '0',
  `date` varchar(255) NOT NULL,
  `time_in` varchar(250) NOT NULL,
  `time_out` varchar(250) NOT NULL,
  `name_of_visitor` varchar(250) NOT NULL,
  `company_address` varchar(1000) NOT NULL,
  `person_to_visit` varchar(250) NOT NULL,
  `purpose` varchar(250) NOT NULL,
  `purpose_others` varchar(500) DEFAULT NULL,
  `status` varchar(250) DEFAULT '0',
  `created_by` int(20) DEFAULT NULL,
  `account_type` varchar(255) DEFAULT NULL,
  `temp_del` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
