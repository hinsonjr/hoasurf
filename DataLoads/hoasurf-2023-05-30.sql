-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2023 at 01:07 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hoasurf`
--

-- --------------------------------------------------------

--
-- Table structure for table `building`
--

CREATE TABLE `building` (
  `id` int(11) NOT NULL,
  `hoa_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address1` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address2` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `building`
--

INSERT INTO `building` (`id`, `hoa_id`, `name`, `address1`, `address2`, `city`, `state`, `zip`) VALUES
(1, 1, 'South Building', '6727 Turtlemound Rd', NULL, 'New Smyrna Beach', 'FL', '32169'),
(2, 1, 'North Building', '6713 Turtlemound Rd.', NULL, 'New Smyrna Beach', 'FL', '32169'),
(3, 2, '257 Minorca', '257 Minorca Beach Way', NULL, 'New Smyrna Beach', 'FL', '32169');

-- --------------------------------------------------------

--
-- Table structure for table `debug`
--

CREATE TABLE `debug` (
  `id` int(11) NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` int(11) DEFAULT 5,
  `log_at` date DEFAULT NULL,
  `log_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220102163859', '2022-01-02 11:39:00', 474),
('DoctrineMigrations\\Version20230524110103', '2023-05-24 07:01:10', 95),
('DoctrineMigrations\\Version20230525120222', '2023-05-25 08:02:23', 51),
('DoctrineMigrations\\Version20230525132507', '2023-05-25 09:25:10', 179);

-- --------------------------------------------------------

--
-- Table structure for table `hoa`
--

CREATE TABLE `hoa` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_phone` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hoa`
--

INSERT INTO `hoa` (`id`, `name`, `admin_name`, `admin_phone`, `admin_email`, `short_name`) VALUES
(1, 'Chadham By The Sea Homeowners Association, Inc.', 'Tina Morbitzer', NULL, 'tina@morbitzer.com', 'Chadham'),
(2, 'Minorca Property Association, Inc.', 'someone', '555', 'lkj', 'Minorca HOA');

-- --------------------------------------------------------

--
-- Table structure for table `hoa_report_category`
--

CREATE TABLE `hoa_report_category` (
  `id` int(11) NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordering` int(11) NOT NULL,
  `hoa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hoa_report_category`
--

INSERT INTO `hoa_report_category` (`id`, `category`, `ordering`, `hoa_id`) VALUES
(1, 'Owner Dues', 150, 1),
(2, 'Equipment and Assets', 0, 1),
(3, 'Cash', 150, 1),
(4, 'Scheduled Maintenance', 150, 1),
(5, 'Unscheduled Maintenance', 150, 1),
(6, 'Reserve Fund', 150, 1),
(7, 'Owner Receivables', 150, 1),
(8, 'Prepaid Expenses', 150, 1),
(9, 'Operating Expenses', 150, 1),
(10, 'Owner Assessments', 80, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ledger_account`
--

CREATE TABLE `ledger_account` (
  `id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `hoa_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `balance` decimal(12,2) NOT NULL,
  `start_balance` decimal(12,2) NOT NULL,
  `hoa_report_category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ledger_account`
--

INSERT INTO `ledger_account` (`id`, `type_id`, `hoa_id`, `name`, `balance`, `start_balance`, `hoa_report_category_id`) VALUES
(1, 6, 1, 'Owner Payments', '-1199660.00', '0.00', 1),
(2, 1, 1, 'Cash', '-28559.35', '0.00', 3),
(3, 3, 1, 'Pool Scheduled Maintenance', '45.00', '0.00', 4),
(4, 3, 1, 'Pool Unscheduled Maintenance', '-325.00', '0.00', 5),
(5, 1, 1, 'Reserve Fund', '-200.00', '0.00', 6),
(6, 1, 1, 'Other Receivables', '0.00', '0.00', 7),
(7, 1, 1, 'Prepaid Insurance', '0.00', '0.00', 8),
(8, 1, 1, 'Other Prepaid Expenses', '0.00', '0.00', 8),
(9, 1, 1, 'Superintendant Apartment', '-340.65', '0.00', 9),
(10, 1, 1, 'Fixtures and Equipment', '0.00', '0.00', 2),
(11, 1, 1, 'Unit 215 - HOA Monthly Receivables', '620.00', '0.00', 7),
(12, 5, 1, 'Owner Receivables', '2146455.00', '0.00', 6),
(13, 6, 1, 'Owner Assessments', '-946795.00', '0.00', 10),
(14, 1, 1, 'Fered', '0.00', '0.00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `ledger_type`
--

CREATE TABLE `ledger_type` (
  `id` int(11) NOT NULL,
  `name` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_debit` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ledger_type`
--

INSERT INTO `ledger_type` (`id`, `name`, `is_debit`) VALUES
(1, 'Assets', 1),
(2, 'Dividend', 1),
(3, 'Expenses', 1),
(4, 'Liabilities', 0),
(5, 'Equity', 0),
(6, 'Revenue', 1),
(7, 'Test', 1);

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_object`
--

CREATE TABLE `maintenance_object` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `hoa_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `period` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `period_amount` decimal(16,2) DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `maintenance_object`
--

INSERT INTO `maintenance_object` (`id`, `vendor_id`, `hoa_id`, `name`, `description`, `period`, `period_amount`, `location`) VALUES
(1, NULL, 1, 'Pool Interior', 'Pool Surface', 'every 10 years', '30000.00', 'between buildings'),
(2, 3, 1, 'Landscaping Maintenance', 'Shrub and Tree Maintenance', 'Quarterly', '500.00', 'All over property'),
(3, 2, 1, 'Lawn', 'Maintenance of the grass and minor shrubs', 'Weekly', '300.00', 'All property');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_by_id` int(11) NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` date DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `hoa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `type_id`, `category_id`, `created_by_id`, `subject`, `body`, `expiration`, `created_at`, `updated_at`, `parent_id`, `hoa_id`) VALUES
(1, 8, 1, 1, 'This is a test of the Message Creation', 'Please do this.', '2023-05-02', '2023-04-30', '2023-04-30', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `message_category`
--

CREATE TABLE `message_category` (
  `id` int(11) NOT NULL,
  `category` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hoa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `message_category`
--

INSERT INTO `message_category` (`id`, `category`, `hoa_id`) VALUES
(1, 'HomeOwner Notification', NULL),
(2, 'Social', NULL),
(3, 'Information', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `message_type`
--

CREATE TABLE `message_type` (
  `id` int(11) NOT NULL,
  `type` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `message_type`
--

INSERT INTO `message_type` (`id`, `type`) VALUES
(1, 'HOA Dues Invoice'),
(5, 'HOA Late Payment Notice'),
(6, 'HOA Assessment Invoice'),
(7, 'Happy Hour'),
(8, 'HOA Board Meeting'),
(9, 'HOA Member Meeting');

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE `owner` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address2` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `own_percent` double NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `owner`
--

INSERT INTO `owner` (`id`, `user_id`, `name`, `start_date`, `end_date`, `address`, `address2`, `city`, `state`, `zip`, `phone`, `country`, `own_percent`, `email`) VALUES
(48, NULL, 'MCMASTER JOHN F', '2021-03-21', NULL, '14311 E TIPPERARY CIR', '', 'WICHITA', 'KS', '67230', NULL, 'US', 100, NULL),
(49, NULL, 'JOHNSON RUTH L', '2001-02-15', NULL, '624 DARTMOUTH AVE', '', 'ORLANDO', 'FL', '32804', NULL, 'US', 100, NULL),
(50, NULL, 'PARESI BARBARA', '2002-07-15', NULL, '6713 TURTLEMOUND RD', '', 'NEW SMYRNA BEACH', 'FL', '32169', NULL, 'US', 100, NULL),
(51, NULL, 'REYNOLDS SHORE INVESTMENTS LLC', '2013-10-25', NULL, '2924 WESTCHESTER AVE', '', 'ORLANDO', 'FL', '32803', NULL, 'US', 100, NULL),
(52, NULL, 'WATSON JOSEPH R & CASSAUNDRA N', '1999-05-15', NULL, '885 SEDALIA ST STE 202', '', 'OCOEE', 'FL', '34761', NULL, 'US', 100, NULL),
(53, NULL, 'MARTINEZ PABLO', '2020-10-30', NULL, '1207 SPRING LAKE DR', '', 'ORLANDO', 'FL', '32804', NULL, 'US', 100, NULL),
(54, NULL, 'OLEARY TERRILL D', '2020-06-16', NULL, '3817 LAKE LAPEER DR', '', 'METAMORA', 'MI', '48455', NULL, 'US', 100, NULL),
(55, NULL, 'MCGOWAN DANIEL', '2020-10-04', NULL, '4073 PALMETTO DR', '', 'LEXINGTON', 'KY', '40513', NULL, 'US', 100, NULL),
(56, NULL, 'MOSLEY ALISON HICKS', '2021-06-30', NULL, '106 COVE COLONY RD', '', 'MAITLAND', 'FL', '32751', NULL, 'US', 100, NULL),
(57, NULL, 'ALLEN W RILEY', '1993-08-15', NULL, '6713 TURTLEMOUND RD #413', '', 'NEW SMYRNA BEACH ', 'FL', '32169', NULL, 'US', 100, NULL),
(58, NULL, 'HOOKER MARCUS P', '2021-09-07', NULL, '5038 OAK ISLAND RD', '', 'BELLE ISLE', 'FL', '34787', NULL, 'US', 100, NULL),
(59, NULL, 'MEURER RAYMOND T & BARBARA TR', '2010-08-27', NULL, '863 WINDCREST PL', '', 'WINTER SPRINGS', 'FL', '32708', NULL, 'US', 100, NULL),
(60, NULL, 'LEMOS DEVELOPMENT GROUP LLC', '2021-02-04', NULL, '10395 NARCOOSSEE RD 100', NULL, 'ORLANDO', 'FL', '32832', NULL, 'US', 100, 'hinson+U110@ticketsocket.com'),
(61, NULL, 'CALLAHAN DENNIS', '2021-04-13', '2023-04-21', '6713 TURTLE MOUND RD # 214', NULL, 'NEW SMYRNA', 'FL', '32169', NULL, 'US', 100, NULL),
(62, NULL, 'HOLLAND FAMILY INVESTMENT', '2016-06-20', NULL, '5224 W SR 46 STE 378', '', 'SANFORD', 'FL', '32771', NULL, 'US', 100, NULL),
(63, NULL, 'WILLIAMS JOHN F ETAL', '1993-04-15', NULL, '6713 TURTLEMOUND RD #313', '', 'NEW SMYRNA BEACH', 'FL', '32169', NULL, 'US', 100, NULL),
(64, NULL, 'LAMPRECHT HILGARDT', '2015-03-19', NULL, '912 JOHNS POINT DR', '', 'WINTER GARDEN ', 'FL', '34787', NULL, 'US', 100, NULL),
(65, NULL, 'TABAK FRED N', '2020-10-02', NULL, '6045 N GREEN BAY AVE', '', 'GLENDALE', 'WI', '53209', NULL, 'US', 100, NULL),
(66, NULL, 'MULLEN MARGARET B  TR', '2001-01-15', NULL, '6713 TURTLEMOUND RD 414', '', 'NEW SMYRNA BEACH', 'FL', '32169', NULL, 'US', 100, NULL),
(67, NULL, 'RHODEN WILLIAM C', '2015-08-13', NULL, '4638 THORNLEA RD', '', 'ORLANDO', 'FL', '32817', NULL, 'US', 100, NULL),
(68, NULL, 'FREEMAN DANA J TR', '1989-08-15', NULL, '6387 POSTELL LN', '', 'FRISCO', 'TX', '75035', NULL, 'US', 100, NULL),
(69, NULL, 'VALENTINE DANNA HOPE', '2020-09-09', NULL, '2039 HOFFNER AVE', NULL, 'BELLE ISLE', 'FL', '32809', NULL, 'US', 100, 'hinson+U111@ticketsocket.com'),
(70, NULL, 'VOLL JOSEPH G & ANTOINETTE', '1996-10-15', NULL, '17 COLONIAL DR', '', 'MONROE', 'CT', '6468', NULL, 'US', 100, NULL),
(71, NULL, 'KISH THOMAS L', '2000-07-15', NULL, '6713 TURTLE MOUND RD UNIT 118', '', 'NEW SMYRNA BEACH', 'FL', '32169', NULL, 'US', 100, NULL),
(72, NULL, 'BUZZI ANDREW J JR', '2021-06-01', NULL, '38 OBTUSE RD', '', 'NEWTOWN', 'CT', '6470', NULL, 'US', 100, NULL),
(73, NULL, 'THE KEEN PROPERTIES LLC', '2016-01-05', NULL, '739 BEAR CREEK CIR', '', 'WINTER SPRINGS', 'FL', '32708', NULL, 'US', 100, NULL),
(74, NULL, 'BOECKEL EDWARD H', '1998-06-15', NULL, '302 SWEETWATER COVE', '', 'LONGWOOD', 'FL', '32779', NULL, 'US', 100, NULL),
(75, NULL, 'GILCHRIST PATRICK', '2021-02-11', NULL, '8104 ANTWERP CIR', '', 'PORT CHARLOTTE', 'FL', '33981', NULL, 'US', 100, NULL),
(76, NULL, 'COLLINS CHERYL A TR', '1989-05-15', NULL, '3879 GATLIN WOODS WAY', '', 'ORLANDO', 'FL', '32812', NULL, 'US', 100, NULL),
(77, NULL, 'STONER B A', '1999-12-15', NULL, '3306 PINETREE DR SE', '', 'SMYRNA', 'GA', '30080', NULL, 'US', 100, NULL),
(78, NULL, 'OLIVER ROBERT WAYNE', '2021-06-23', NULL, '4860 CHURCH LN', '', 'GALESVILLE', 'MD', '20765', NULL, 'US', 100, NULL),
(79, NULL, 'BARNHART CHRISTINE A  TR', '1990-01-15', NULL, '1161 WHITESELL DR', '', 'WINTER PARK', 'FL', '32789', NULL, 'US', 100, NULL),
(80, NULL, 'RUSSO DANIEL E TR', '2021-08-27', NULL, '3262 OAKMONT TERRACE', '', 'LONGWOOD', 'FL', '32779', NULL, 'US', 100, NULL),
(81, NULL, 'MARSH ROBERT L TR', '2005-11-04', NULL, '54 DANADA DR', '', 'WHEATON', 'IL', '60189', NULL, 'US', 100, NULL),
(82, NULL, 'ORTIZ ANDRES VICENTE TR', '2021-07-26', NULL, '1683 LAKEHURST AVE', '', 'WINTER PARK', 'FL', '32789', NULL, 'US', 100, NULL),
(83, NULL, 'SULLIVAN JACQUELINE P TR', '1989-05-15', NULL, '939 W 2ND AVE', '', 'WINDERMERE', 'FL', '34786', NULL, 'US', 100, NULL),
(84, 1, 'PAYCER WAYNE', '2021-01-29', NULL, '6727 TURTLEMOUND RD UNIT 115', '', 'NEW SMYRNA BEACH', 'FL', '32169', NULL, 'US', 100, NULL),
(85, NULL, 'HICKEY HAROLD T', '2020-07-17', NULL, '484 NASH LN', '', 'PORT ORANGE', 'FL', '32127', NULL, 'US', 100, NULL),
(86, NULL, 'WEST OSCAR & DIONNE M', '2009-06-01', NULL, '1571 WINGATE DR', '', 'DELAND', 'FL', '32724', NULL, 'US', 100, NULL),
(87, NULL, 'GATZ SHERRIE WILLIAMSON', '2004-03-15', NULL, '6727 TURTLEMOUND RD #319', '', 'NEW SMYRNA BEACH', 'FL', '32169', NULL, 'US', 100, NULL),
(88, NULL, 'BROWN MICHELLE A', '2014-04-21', NULL, '900 BOWERSOX DR', '', 'LADY LAKE', 'FL', '32159', NULL, 'US', 100, NULL),
(89, 13, 'FOLSOM JOYCE A', '1996-12-15', NULL, '6727 TURTLEMOUND RD #217', '', 'NEW SMYRNA BEACH', 'FL', '32169', NULL, 'US', 100, NULL),
(90, NULL, 'GUILLERMO M PRADA & ELVIRA A', '1989-06-15', NULL, '2010 ROSSMORE CT', '', 'NEW SMYRNA BEACH', 'FL', '32168', NULL, 'US', 100, NULL),
(91, NULL, 'GREENBERG HAROLD L', '1990-11-15', NULL, '280 SPRINGSIDE RD', '', 'LONGWOOD', 'FL', '32779', NULL, 'US', 100, NULL),
(92, NULL, 'SIMONCINI REALTY TRUST', '1989-05-15', NULL, '16 POLLOCK ST', '', 'WORCESTER', 'MA', '01604', NULL, 'US', 100, NULL),
(93, NULL, 'STRAUSS HOWARD', '2021-01-12', NULL, 'PO BOX 540772', '', 'ORLANDO', 'FL', '32854', NULL, 'US', 100, NULL),
(94, 4, 'Hinson Stephens', '2020-09-11', NULL, '6727 Turtlemound Rd', '215', 'New Smyrna Beach', 'Florida', '32169', '4075923989', 'US', 100, 'hinsonjr@outlook.com'),
(95, NULL, 'KENNY SUE ANN', '2002-04-15', NULL, '830 HADDOCK AVE', '', 'NEW SMYRNA BEACH', 'FL', '32169', NULL, 'US', 100, NULL),
(96, NULL, 'HALE PHILIP', '2016-08-26', NULL, '1 CITY CENTER DR UNIT 1600', ' ', 'MISSISSAUGA', 'ON', 'L5B 1M2', NULL, 'US', 100, NULL),
(97, NULL, 'GOMEZ JORGE & LUZSTELLA', '1989-05-15', NULL, '2 STONEGATE', '', 'LONGWOOD', 'FL', '32750', NULL, 'US', 100, NULL),
(98, NULL, 'PETERSON BRADLEY C', '2019-07-31', NULL, '6727 TURTLEMOUND RD #416', '', 'NEW SMYRNA BEACH', 'FL', '32169', NULL, 'US', 100, NULL),
(99, NULL, 'STROBECK MICHAEL K', '2014-07-16', NULL, '1570 HANKS AVE', '', 'ORLANDO', 'FL', '32814', NULL, 'US', 100, NULL),
(100, NULL, 'JEFFERY F HANSEN REVOCABLE TRUST - TR', '2021-07-02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 100, NULL),
(101, 4, 'Sharon Stephens', '2020-09-11', NULL, '6727 Turtlemound Rd #215', NULL, 'New Smyrna Beach', 'FL', '32169', '4075923989', NULL, 100, 'hinsonjr@outlook.com'),
(102, NULL, 'PETERSON BRADLEY C', '2019-07-31', NULL, '6727 TURTLEMOUND RD #416', NULL, 'New Smyrna Beach', 'FL', '32169', NULL, NULL, 100, NULL),
(103, NULL, 'Wayne S. and Marie Pamela and N. Jane King Hundley', '2016-02-03', '2020-09-11', '707 Mining Gap Conn', NULL, 'Young Harris', 'GA', '30582', NULL, NULL, 100, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `owner_invoice`
--

CREATE TABLE `owner_invoice` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `paid_date` date DEFAULT NULL,
  `unit_owner_id` int(11) NOT NULL,
  `hoa_id` int(11) NOT NULL,
  `post_date` date NOT NULL,
  `type_id` int(11) NOT NULL,
  `amount` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `owner_invoice_type`
--

CREATE TABLE `owner_invoice_type` (
  `id` int(11) NOT NULL,
  `credit_account_id` int(11) NOT NULL,
  `debit_account_id` int(11) NOT NULL,
  `type` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `owner_invoice_type`
--

INSERT INTO `owner_invoice_type` (`id`, `credit_account_id`, `debit_account_id`, `type`) VALUES
(1, 13, 12, 'Assessment'),
(2, 1, 12, 'Owner Dues');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `created_by_id` int(11) NOT NULL,
  `assigned_to_id` int(11) NOT NULL,
  `completed_by_id` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `completed_date` datetime DEFAULT NULL,
  `notes` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request_status`
--

CREATE TABLE `request_status` (
  `id` int(11) NOT NULL,
  `status` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request_type`
--

CREATE TABLE `request_type` (
  `id` int(11) NOT NULL,
  `type` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `request_type`
--

INSERT INTO `request_type` (`id`, `type`) VALUES
(1, 'Service'),
(2, 'Document'),
(3, 'Parking and Gate Access'),
(4, 'Building Maintenance'),
(5, 'Unit Maintenance'),
(6, 'Lawn Maintenance'),
(7, 'Pool Maintenance');

-- --------------------------------------------------------

--
-- Table structure for table `reset_password_request`
--

CREATE TABLE `reset_password_request` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `selector` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `role_name`, `status`) VALUES
(1, 'Super Admin (full access)', 'ROLE_SUPER_ADMIN', 1),
(2, 'HOA Administrator', 'ROLE_HOA_ADMIN', 1),
(3, 'HOA Board Member', 'ROLE_HOA_BOARD', 1),
(4, 'HOA Owner', 'ROLE_HOA_OWNER', 1),
(5, 'HOA Vendor', 'ROLE_HOA_VENDER', 1),
(6, 'HOA Acccountant', 'ROLE_HOA_ACCOUNTING', 1);

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `credit_account_id` int(11) NOT NULL,
  `debit_account_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `credit_account_id`, `debit_account_id`, `date`, `amount`, `deleted`) VALUES
(1, 11, 2, '2022-02-21 22:06:41', '620.00', 0),
(2, 2, 3, '2022-02-21 22:06:41', '30000.00', 0),
(3, 2, 3, '2023-04-21 06:45:00', '50.00', 0),
(4, 4, 2, '2023-05-07 00:00:00', '325.00', 0),
(5, 5, 2, '2023-05-07 00:00:00', '200.00', 0),
(6, 2, 3, '2023-05-10 00:00:00', '50.00', 0),
(7, 3, 2, '2023-05-10 00:00:00', '55.00', 0),
(8, 9, 2, '2023-05-11 00:00:00', '340.65', 0);

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int(11) NOT NULL,
  `building_id` int(11) DEFAULT NULL,
  `unit_number` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sf` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `beds` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `baths` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `building_id`, `unit_number`, `description`, `sf`, `beds`, `baths`) VALUES
(110, 2, '110', NULL, '1410', '3', '2'),
(111, 2, '111', NULL, '1410', '3', '2'),
(112, 2, '112', NULL, '1410', '3', '2'),
(113, 2, '113', NULL, '1410', '3', '2'),
(114, 2, '114', NULL, '1410', '3', '2'),
(115, 1, '115', NULL, '1410', '3', '2'),
(116, 1, '116', NULL, '1180', '2', '2'),
(117, 1, '117', NULL, '1180', '2', '2'),
(118, 1, '118', NULL, '1410', '3', '2'),
(119, 1, '119', NULL, '1410', '3', '2'),
(120, 1, '120', NULL, '1410', '3', '2'),
(210, 2, '210', NULL, '1410', '3', '2'),
(211, 2, '211', NULL, '1410', '3', '2'),
(212, 2, '212', NULL, '1410', '3', '2'),
(213, 2, '213', NULL, '1410', '3', '2'),
(214, 2, '214', NULL, '1410', '3', '2'),
(215, 1, '215', NULL, '1410', '3', '2'),
(216, 1, '216', NULL, '1180', '2', '2'),
(217, 1, '217', NULL, '1180', '2', '2'),
(218, 1, '218', NULL, '1410', '3', '2'),
(219, 1, '219', NULL, '1410', '3', '2'),
(220, 1, '220', NULL, '1410', '3', '2'),
(310, 2, '310', NULL, '1410', '3', '2'),
(311, 2, '311', NULL, '1410', '3', '2'),
(312, 2, '312', NULL, '1410', '3', '2'),
(313, 2, '313', NULL, '1410', '3', '2'),
(314, 2, '314', NULL, '1410', '3', '2'),
(315, 1, '315', NULL, '1410', '3', '2'),
(316, 1, '316', NULL, '1180', '2', '2'),
(317, 1, '317', NULL, '1180', '2', '2'),
(318, 1, '318', NULL, '1410', '3', '2'),
(319, 1, '319', NULL, '1410', '3', '2'),
(320, 1, '320', NULL, '1410', '3', '2'),
(410, 2, '410', NULL, '1410', '3', '2'),
(411, 2, '411', NULL, '1410', '3', '2'),
(412, 2, '412', NULL, '1410', '3', '2'),
(413, 2, '413', NULL, '1410', '3', '2'),
(414, 2, '414', NULL, '1410', '3', '2'),
(415, 1, '415', NULL, '1410', '3', '2'),
(416, 1, '416', NULL, '1180', '2', '2'),
(417, 1, '417', NULL, '1180', '2', '2'),
(418, 1, '418', NULL, '1410', '3', '2'),
(419, 1, '419', NULL, '1410', '3', '2'),
(420, 1, '420', NULL, '1410', '3', '2'),
(510, 2, '510', NULL, '1526', '3', '2'),
(512, 2, '512', NULL, '1410', '3', '2'),
(514, 2, '514', NULL, '1526', '3', '2'),
(515, 1, '515', NULL, '1410', '3', '2'),
(516, 1, '516', NULL, '1180', '2', '2'),
(517, 1, '517', NULL, '1180', '2', '2'),
(518, 1, '518', NULL, '1526', '3', '2'),
(520, 1, '520', NULL, '1410', '3', '2');

-- --------------------------------------------------------

--
-- Table structure for table `unit_owner`
--

CREATE TABLE `unit_owner` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `own_percent` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `unit_owner`
--

INSERT INTO `unit_owner` (`id`, `owner_id`, `unit_id`, `start_date`, `end_date`, `own_percent`) VALUES
(1, 48, 112, '2021-03-21', NULL, 100),
(2, 49, 210, '2001-02-15', NULL, 100),
(3, 50, 211, '2002-07-15', NULL, 100),
(4, 51, 310, '2013-10-25', NULL, 100),
(5, 52, 312, '1999-05-15', NULL, 100),
(6, 53, 314, '2020-10-30', NULL, 100),
(7, 54, 411, '2020-06-16', NULL, 100),
(8, 55, 412, '2020-10-04', NULL, 100),
(9, 56, 114, '2021-06-30', NULL, 100),
(10, 57, 413, '1993-08-15', NULL, 100),
(11, 58, 212, '2021-09-07', NULL, 100),
(12, 59, 512, '2010-08-27', NULL, 100),
(13, 60, 110, '2021-02-04', NULL, 100),
(14, 61, 214, '2021-04-13', '2023-04-21', 100),
(15, 62, 410, '2016-06-20', NULL, 100),
(16, 63, 313, '1993-04-15', NULL, 100),
(17, 64, 113, '2015-03-19', NULL, 100),
(18, 65, 213, '2020-10-02', NULL, 100),
(19, 66, 414, '2001-01-15', NULL, 100),
(20, 67, 510, '2015-08-13', NULL, 100),
(21, 68, 514, '1989-08-15', NULL, 100),
(22, 69, 111, '2020-09-09', NULL, 100),
(23, 70, 311, '1996-10-15', NULL, 100),
(24, 71, 118, '2000-07-15', NULL, 100),
(25, 72, 120, '2021-06-01', NULL, 100),
(26, 73, 417, '2016-01-05', NULL, 100),
(27, 74, 420, '1998-06-15', NULL, 100),
(28, 75, 316, '2021-02-11', NULL, 100),
(29, 76, 318, '1989-05-15', NULL, 100),
(30, 77, 515, '1999-12-15', NULL, 100),
(31, 78, 520, '2021-06-23', NULL, 100),
(32, 79, 216, '1990-01-15', NULL, 100),
(33, 80, 218, '2021-08-27', NULL, 100),
(34, 81, 415, '2005-11-04', NULL, 100),
(35, 82, 419, '2021-07-26', NULL, 100),
(36, 83, 518, '1989-05-15', NULL, 100),
(37, 84, 115, '2021-01-29', NULL, 100),
(38, 85, 315, '2020-07-17', NULL, 100),
(39, 86, 317, '2009-06-01', NULL, 100),
(40, 87, 319, '2004-03-15', NULL, 100),
(41, 88, 320, '2014-04-21', NULL, 100),
(42, 89, 217, '1996-12-15', NULL, 100),
(43, 90, 516, '1989-06-15', NULL, 100),
(44, 91, 517, '1990-11-15', NULL, 100),
(45, 92, 117, '1989-05-15', NULL, 100),
(46, 93, 116, '2021-01-12', NULL, 100),
(47, 94, 215, '2020-09-11', NULL, 100),
(48, 95, 220, '2002-04-15', NULL, 100),
(49, 96, 119, '2016-08-26', NULL, 100),
(50, 97, 219, '1989-05-15', NULL, 100),
(51, 98, 416, '2019-07-31', NULL, 100),
(52, 99, 418, '2014-07-16', NULL, 100),
(53, 101, 215, '2020-09-11', NULL, 100),
(54, 103, 215, '1996-09-30', '2020-09-11', 100);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `active_hoa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `name`, `password`, `is_verified`, `last_login`, `active_hoa_id`) VALUES
(1, 'hinsonjr@outlook.com', 'Super Admin Hinson', '$2y$13$DQJiRvkHEKUt8TQSzYQnaeArYzgCe3Y0LK5ejfJIKVxhlWPTsJDRC', 0, NULL, 1),
(2, 'tina@morbitzer.com', 'Tina Morbitzer', '$2y$13$DQJiRvkHEKUt8TQSzYQnaeArYzgCe3Y0LK5ejfJIKVxhlWPTsJDRC', 0, NULL, 1),
(3, 'RileyAllen@rileyattn.com', 'Riley Allen', '$2y$13$DQJiRvkHEKUt8TQSzYQnaeArYzgCe3Y0LK5ejfJIKVxhlWPTsJDRC', 0, NULL, 1),
(4, 'hinsonjr@justbiz.biz', 'Hinson Stephens Owner', '$2y$13$DQJiRvkHEKUt8TQSzYQnaeArYzgCe3Y0LK5ejfJIKVxhlWPTsJDRC', 0, '2022-01-10 09:55:45', 1),
(11, 'irisharon@yahoo.com', 'Sharon Stephens', '$2y$13$DQJiRvkHEKUt8TQSzYQnaeArYzgCe3Y0LK5ejfJIKVxhlWPTsJDRC', 0, NULL, 1),
(13, 'hinsonjr@gmail.com', 'Joyce', '$2y$13$DQJiRvkHEKUt8TQSzYQnaeArYzgCe3Y0LK5ejfJIKVxhlWPTsJDRC', 0, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`user_id`, `role_id`) VALUES
(1, 1),
(4, 4),
(13, 4);

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hoa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`id`, `name`, `contact_name`, `contact_number`, `contact_email`, `type`, `description`, `hoa_id`) VALUES
(1, 'Giles Electric Company', NULL, '386-767-5895', NULL, 'Fire Protection and Alarm', NULL, NULL),
(2, 'Terra-Scape', NULL, '386-427-9514', 'gkennedy@terra-scape.net', 'Landscaping', NULL, NULL),
(3, 'Dobsons Woods & Water Inc.', NULL, '(407) 841-0030', 'info@dobsonsww.com', 'Landscape and Irrigation', 'Sprinkler Systems', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `building`
--
ALTER TABLE `building`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E16F61D4549D404C` (`hoa_id`);

--
-- Indexes for table `debug`
--
ALTER TABLE `debug`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `hoa`
--
ALTER TABLE `hoa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hoa_report_category`
--
ALTER TABLE `hoa_report_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_CA9E92A6549D404C` (`hoa_id`);

--
-- Indexes for table `ledger_account`
--
ALTER TABLE `ledger_account`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B3339695C54C8C93` (`type_id`),
  ADD KEY `IDX_B3339695549D404C` (`hoa_id`),
  ADD KEY `IDX_B3339695EF74B2F3` (`hoa_report_category_id`);

--
-- Indexes for table `ledger_type`
--
ALTER TABLE `ledger_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenance_object`
--
ALTER TABLE `maintenance_object`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_82509DE5F603EE73` (`vendor_id`),
  ADD KEY `IDX_82509DE5549D404C` (`hoa_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B6BD307FC54C8C93` (`type_id`),
  ADD KEY `IDX_B6BD307F12469DE2` (`category_id`),
  ADD KEY `IDX_B6BD307FB03A8386` (`created_by_id`),
  ADD KEY `IDX_B6BD307F727ACA70` (`parent_id`),
  ADD KEY `IDX_B6BD307F549D404C` (`hoa_id`);

--
-- Indexes for table `message_category`
--
ALTER TABLE `message_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F6ADDD0549D404C` (`hoa_id`);

--
-- Indexes for table `message_type`
--
ALTER TABLE `message_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `owner`
--
ALTER TABLE `owner`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_CF60E67CA76ED395` (`user_id`);

--
-- Indexes for table `owner_invoice`
--
ALTER TABLE `owner_invoice`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1C13919B2FC0CB0F` (`transaction_id`),
  ADD KEY `IDX_1C13919B549D404C` (`hoa_id`),
  ADD KEY `IDX_1C13919BC54C8C93` (`type_id`),
  ADD KEY `IDX_1C13919BB028B6B` (`unit_owner_id`);

--
-- Indexes for table `owner_invoice_type`
--
ALTER TABLE `owner_invoice_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8AC6F7866813E404` (`credit_account_id`),
  ADD KEY `IDX_8AC6F786204C4EAA` (`debit_account_id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3B978F9FC54C8C93` (`type_id`),
  ADD KEY `IDX_3B978F9FB03A8386` (`created_by_id`),
  ADD KEY `IDX_3B978F9FF4BD7827` (`assigned_to_id`),
  ADD KEY `IDX_3B978F9F85ECDE76` (`completed_by_id`),
  ADD KEY `IDX_3B978F9F6BF700BD` (`status_id`);

--
-- Indexes for table `request_status`
--
ALTER TABLE `request_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_type`
--
ALTER TABLE `request_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7CE748AA76ED395` (`user_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_723705D16813E404` (`credit_account_id`),
  ADD KEY `IDX_723705D1204C4EAA` (`debit_account_id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DCBB0C534D2A7E12` (`building_id`);

--
-- Indexes for table `unit_owner`
--
ALTER TABLE `unit_owner`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_445298777E3C61F9` (`owner_id`),
  ADD KEY `IDX_44529877F8BD700D` (`unit_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  ADD KEY `IDX_8D93D649CBA4995B` (`active_hoa_id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `IDX_2DE8C6A3A76ED395` (`user_id`),
  ADD KEY `IDX_2DE8C6A3D60322AC` (`role_id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F52233F6549D404C` (`hoa_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `building`
--
ALTER TABLE `building`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `debug`
--
ALTER TABLE `debug`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hoa`
--
ALTER TABLE `hoa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hoa_report_category`
--
ALTER TABLE `hoa_report_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ledger_account`
--
ALTER TABLE `ledger_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `ledger_type`
--
ALTER TABLE `ledger_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `maintenance_object`
--
ALTER TABLE `maintenance_object`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `message_category`
--
ALTER TABLE `message_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `message_type`
--
ALTER TABLE `message_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `owner`
--
ALTER TABLE `owner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `owner_invoice`
--
ALTER TABLE `owner_invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `owner_invoice_type`
--
ALTER TABLE `owner_invoice_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_status`
--
ALTER TABLE `request_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_type`
--
ALTER TABLE `request_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=696;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=523;

--
-- AUTO_INCREMENT for table `unit_owner`
--
ALTER TABLE `unit_owner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `building`
--
ALTER TABLE `building`
  ADD CONSTRAINT `FK_E16F61D4549D404C` FOREIGN KEY (`hoa_id`) REFERENCES `hoa` (`id`);

--
-- Constraints for table `hoa_report_category`
--
ALTER TABLE `hoa_report_category`
  ADD CONSTRAINT `FK_CA9E92A6549D404C` FOREIGN KEY (`hoa_id`) REFERENCES `hoa` (`id`);

--
-- Constraints for table `ledger_account`
--
ALTER TABLE `ledger_account`
  ADD CONSTRAINT `FK_B3339695549D404C` FOREIGN KEY (`hoa_id`) REFERENCES `hoa` (`id`),
  ADD CONSTRAINT `FK_B3339695C54C8C93` FOREIGN KEY (`type_id`) REFERENCES `ledger_type` (`id`),
  ADD CONSTRAINT `FK_B3339695EF74B2F3` FOREIGN KEY (`hoa_report_category_id`) REFERENCES `hoa_report_category` (`id`);

--
-- Constraints for table `maintenance_object`
--
ALTER TABLE `maintenance_object`
  ADD CONSTRAINT `FK_82509DE5549D404C` FOREIGN KEY (`hoa_id`) REFERENCES `hoa` (`id`),
  ADD CONSTRAINT `FK_82509DE5F603EE73` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`);

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `FK_B6BD307F12469DE2` FOREIGN KEY (`category_id`) REFERENCES `message_category` (`id`),
  ADD CONSTRAINT `FK_B6BD307F549D404C` FOREIGN KEY (`hoa_id`) REFERENCES `hoa` (`id`),
  ADD CONSTRAINT `FK_B6BD307F727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `message` (`id`),
  ADD CONSTRAINT `FK_B6BD307FB03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_B6BD307FC54C8C93` FOREIGN KEY (`type_id`) REFERENCES `message_type` (`id`);

--
-- Constraints for table `message_category`
--
ALTER TABLE `message_category`
  ADD CONSTRAINT `FK_F6ADDD0549D404C` FOREIGN KEY (`hoa_id`) REFERENCES `hoa` (`id`);

--
-- Constraints for table `owner`
--
ALTER TABLE `owner`
  ADD CONSTRAINT `FK_CF60E67CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `owner_invoice`
--
ALTER TABLE `owner_invoice`
  ADD CONSTRAINT `FK_1C13919B2FC0CB0F` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`id`),
  ADD CONSTRAINT `FK_1C13919B549D404C` FOREIGN KEY (`hoa_id`) REFERENCES `hoa` (`id`),
  ADD CONSTRAINT `FK_1C13919BB028B6B` FOREIGN KEY (`unit_owner_id`) REFERENCES `unit_owner` (`id`),
  ADD CONSTRAINT `FK_1C13919BC54C8C93` FOREIGN KEY (`type_id`) REFERENCES `owner_invoice_type` (`id`);

--
-- Constraints for table `owner_invoice_type`
--
ALTER TABLE `owner_invoice_type`
  ADD CONSTRAINT `FK_8AC6F786204C4EAA` FOREIGN KEY (`debit_account_id`) REFERENCES `ledger_account` (`id`),
  ADD CONSTRAINT `FK_8AC6F7866813E404` FOREIGN KEY (`credit_account_id`) REFERENCES `ledger_account` (`id`);

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `FK_3B978F9F6BF700BD` FOREIGN KEY (`status_id`) REFERENCES `request_status` (`id`),
  ADD CONSTRAINT `FK_3B978F9F85ECDE76` FOREIGN KEY (`completed_by_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_3B978F9FB03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_3B978F9FC54C8C93` FOREIGN KEY (`type_id`) REFERENCES `request_type` (`id`),
  ADD CONSTRAINT `FK_3B978F9FF4BD7827` FOREIGN KEY (`assigned_to_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `FK_723705D1204C4EAA` FOREIGN KEY (`debit_account_id`) REFERENCES `ledger_account` (`id`),
  ADD CONSTRAINT `FK_723705D16813E404` FOREIGN KEY (`credit_account_id`) REFERENCES `ledger_account` (`id`);

--
-- Constraints for table `unit`
--
ALTER TABLE `unit`
  ADD CONSTRAINT `FK_DCBB0C534D2A7E12` FOREIGN KEY (`building_id`) REFERENCES `building` (`id`);

--
-- Constraints for table `unit_owner`
--
ALTER TABLE `unit_owner`
  ADD CONSTRAINT `FK_1929416E7E3C61F9` FOREIGN KEY (`owner_id`) REFERENCES `owner` (`id`),
  ADD CONSTRAINT `FK_1929416EF8BD700D` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D649CBA4995B` FOREIGN KEY (`active_hoa_id`) REFERENCES `hoa` (`id`);

--
-- Constraints for table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `FK_2DE8C6A3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_2DE8C6A3D60322AC` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vendor`
--
ALTER TABLE `vendor`
  ADD CONSTRAINT `FK_F52233F6549D404C` FOREIGN KEY (`hoa_id`) REFERENCES `hoa` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
