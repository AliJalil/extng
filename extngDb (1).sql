-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 23, 2023 at 08:04 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `extngDb`
--

-- --------------------------------------------------------

--
-- Table structure for table `detectionEmps`
--

CREATE TABLE `detectionEmps` (
  `deId` int(11) NOT NULL,
  `dId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `exId` int(11) DEFAULT NULL,
  `isActive` int(11) DEFAULT 1,
  `isDeleted` tinyint(4) DEFAULT 0,
  `createdAt` varchar(250) DEFAULT unix_timestamp(current_timestamp())
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `detectionEmps`
--

INSERT INTO `detectionEmps` (`deId`, `dId`, `userId`, `exId`, `isActive`, `isDeleted`, `createdAt`) VALUES
(1, 1, 1, 2, 1, 1, '1679038566'),
(2, 1, 1, 3, 1, 1, '1679038566'),
(3, 1, 1, 5, 1, 1, '1679038566'),
(4, 1, 1, 7, 1, 1, '1679038566'),
(8, 1, 24, 8, 1, 0, '1679038566'),
(9, 1, 24, 10, 1, 0, '1679038566'),
(14, 1, 25, 3, 1, 1, '1679150191'),
(15, 1, 25, 4, 1, 1, '1679150191'),
(20, 1, 34, 1, 1, 1, '1679158990'),
(21, 1, 34, 5, 1, 0, '1679158990'),
(29, 1, 29, 1, 1, 0, '1679249181'),
(30, 1, 29, 2, 1, 0, '1679249181'),
(31, 1, 29, 3, 1, 0, '1679249181'),
(32, 1, 29, 4, 1, 0, '1679249181');

-- --------------------------------------------------------

--
-- Table structure for table `detections`
--

CREATE TABLE `detections` (
  `dId` int(11) NOT NULL,
  `dName` varchar(250) DEFAULT NULL,
  `startIn` varchar(250) DEFAULT NULL,
  `endAt` varchar(250) DEFAULT NULL,
  `isCurrent` tinyint(4) DEFAULT 0,
  `notes` varchar(250) DEFAULT NULL,
  `isActive` tinyint(4) DEFAULT 1,
  `isDeleted` tinyint(4) DEFAULT 0,
  `createdAt` varchar(250) DEFAULT unix_timestamp(current_timestamp()),
  `createdBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `detections`
--

INSERT INTO `detections` (`dId`, `dName`, `startIn`, `endAt`, `isCurrent`, `notes`, `isActive`, `isDeleted`, `createdAt`, `createdBy`) VALUES
(1, 'الشهر الثالث ٢٠٢٣', '1990-06-04', '1971-10-11', 1, 'بسم الله', 1, 0, '1679040541', 60);

-- --------------------------------------------------------

--
-- Table structure for table `detectionsInfo`
--

CREATE TABLE `detectionsInfo` (
  `dInfoId` int(11) NOT NULL,
  `deId` int(11) DEFAULT -1 COMMENT 'رقم الكشف',
  `exId` int(11) DEFAULT -1 COMMENT 'رقم المطفأة',
  `assignTo` int(11) DEFAULT -1 COMMENT 'ايدي اليوزر المكلف بمتابعة الكشف',
  `isThere` tinyint(4) DEFAULT NULL COMMENT 'موجودة, او غير موجودة',
  `lockIsGood` tinyint(4) DEFAULT NULL COMMENT 'حالة بسمار الامان',
  `gageIsGood` tinyint(4) DEFAULT NULL COMMENT 'حالة العداد',
  `jetIsGood` int(11) DEFAULT NULL COMMENT 'حالة الخرطوم',
  `handleIsGood` tinyint(4) DEFAULT NULL COMMENT 'حالة المقبض',
  `isUsed` tinyint(4) DEFAULT NULL COMMENT 'تم استخدامها',
  `notes` text DEFAULT NULL,
  `gps` varchar(300) DEFAULT NULL COMMENT 'موقع الكشف',
  `isActive` tinyint(4) DEFAULT 1,
  `isDeleted` tinyint(4) DEFAULT 0,
  `createdAt` varchar(250) DEFAULT unix_timestamp(current_timestamp()),
  `createdBy` int(11) DEFAULT -1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `detectionsInfo`
--

INSERT INTO `detectionsInfo` (`dInfoId`, `deId`, `exId`, `assignTo`, `isThere`, `lockIsGood`, `gageIsGood`, `jetIsGood`, `handleIsGood`, `isUsed`, `notes`, `gps`, `isActive`, `isDeleted`, `createdAt`, `createdBy`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 'No', NULL, 1, 0, '1679150674', 1),
(2, 1, 2, 1, 0, 1, 1, 1, 1, 1, 'No', NULL, 1, 0, '1679150674', 1),
(3, 1, 3, 1, 1, 1, 1, 1, 1, 1, 'No', NULL, 1, 0, '1679150674', 3),
(4, 1, 4, 1, 1, 1, 1, 1, 1, 1, 'No', NULL, 1, 0, '1679150674', 2),
(5, 1, 4, 1, 1, 1, 1, 1, 1, 1, 'No', NULL, 1, 0, '1679150674', 1),
(6, 0, 0, -1, 1, 1, 1, 1, 2, 2, 'لايوجد', NULL, 1, 0, '1679497954', 60),
(7, 1, 0, -1, 2, 2, 1, 2, 1, 2, 'لاتوجد ملاحظات', NULL, 1, 0, '1679505861', 60),
(8, 1, 0, -1, 2, 2, 1, 2, 1, 2, 'لاتوجد ملاحظات', NULL, 1, 0, '1679505865', 60),
(9, 1, 0, -1, 2, 2, 2, 2, 2, 2, 'ما ادري', NULL, 1, 0, '1679505973', 60),
(10, 1, 1, -1, 1, 1, 1, 1, 2, 2, 'Quo recusandae Sunt', NULL, 1, 0, '1679506046', 60);

-- --------------------------------------------------------

--
-- Table structure for table `extinguishers`
--

CREATE TABLE `extinguishers` (
  `exId` int(11) NOT NULL,
  `exSeq` int(11) DEFAULT 0 COMMENT 'التسلسل\n',
  `exNo` int(11) DEFAULT 0 COMMENT 'الرقم',
  `exName` varchar(250) DEFAULT NULL,
  `exType` varchar(250) DEFAULT NULL,
  `exSize` varchar(250) DEFAULT NULL,
  `exPlace` varchar(250) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `state` tinyint(4) DEFAULT 0 COMMENT 'تالفة',
  `ignoreBy` tinyint(4) DEFAULT -1,
  `isActive` tinyint(4) DEFAULT 1,
  `isDeleted` tinyint(4) DEFAULT 0,
  `createdBy` int(11) DEFAULT 0,
  `createdAt` varchar(250) DEFAULT unix_timestamp(current_timestamp())
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Extinguishers\nمعلومات المطافئ';

--
-- Dumping data for table `extinguishers`
--

INSERT INTO `extinguishers` (`exId`, `exSeq`, `exNo`, `exName`, `exType`, `exSize`, `exPlace`, `notes`, `state`, `ignoreBy`, `isActive`, `isDeleted`, `createdBy`, `createdAt`) VALUES
(1, 50, 660, 'مطفئة', '2', '3', 'Ullam e23', 'لاتوجد ملاحظات', 2, 60, 1, 0, 60, '1677607266'),
(2, 50, 661, 'مطفئة 1', '3', '3', 'Ullam 25', 'لاتوجد ملاحظات', 0, -1, 1, 0, 60, '1677607266'),
(3, 50, 662, ' 2مطفئة', '2', '3', 'صحن فاطمة', 'لاتوجد ملاحظات', 0, -1, 1, 0, 60, '1677607266'),
(4, 50, 663, '3مطفئة', '1', '3', 'العتبة العلوية', 'لاتوجد ملاحظات', 0, -1, 1, 0, 60, '1677607266'),
(5, 50, 664, '4مطفئة', '3', '3', 'باب الصحن', 'Ea porro ex consecte', 0, -1, 1, 1, 60, '1677607266'),
(6, 50, 665, '5مطفئة', '2', '3', 'ما اندلها', 'لاتوجد ملاحظات', 0, -1, 1, 0, 60, '1677607266'),
(7, 50, 666, '6مطفئة', '1', '1', 'شمدريني وين', 'لاتوجد ملاحظات', 0, -1, 1, 0, 60, '1677607266'),
(8, 50, 667, '7مطفئة', '3', '2', 'يمكن بشارع الرسول', 'لاتوجد ملاحظات', 0, -1, 1, 0, 60, '1677607266'),
(9, 50, 668, '8مطفئة', '3', '3', 'باب الطوسي', 'لاتوجد ملاحظات', 0, -1, 1, 0, 60, '1677607266'),
(10, 50, 669, '9مطفئة', '3', '3', 'شارع الصادق', 'لاتوجد ملاحظات', 0, -1, 1, 0, 60, '1677607266'),
(11, 0, 0, NULL, '0', '0', '', '', 0, -1, 1, 0, 60, '1679144842'),
(12, 0, 0, NULL, '0', '0', '', '', 0, -1, 1, 0, 60, '1679144861'),
(13, 0, 0, NULL, '0', '0', '', '', 0, -1, 1, 0, 60, '1679149571'),
(14, 0, 0, NULL, '0', '0', '', '', 0, -1, 1, 0, 60, '1679149788'),
(15, 0, 0, NULL, '0', '0', '', '', 0, -1, 1, 0, 60, '1679150099');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `pId` int(11) DEFAULT NULL,
  `pName` varchar(150) DEFAULT NULL,
  `pNameAr` varchar(100) DEFAULT NULL,
  `isDeleted` tinyint(4) DEFAULT NULL,
  `isActive` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`pId`, `pName`, `pNameAr`, `isDeleted`, `isActive`) VALUES
(1, 'AddGift', 'اضافة مطفأة', 0, 1),
(2, 'EditGift', 'تعديل مطفأة', 0, 1),
(3, 'DeleteGift', 'حذف مطفأة', 0, 1),
(4, 'AddUser', 'اضافة مستخدم', 0, 1),
(5, 'EditUser', 'تعديل مستخدم', 0, 1),
(6, 'DeleteUser', 'حذف مستخدم', 0, 1),
(9, 'StatementView', 'عرض الكشف', 0, 1),
(11, 'ManagePage', 'صفحة الادارة', 0, 1),
(12, 'ViewTables', 'عرض الجداول', 0, 1),
(10, 'StatementViewUser', 'عرض كشف المستخدم فقط', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `sId` int(11) NOT NULL,
  `sName` varchar(250) DEFAULT NULL,
  `isActive` tinyint(4) DEFAULT 1,
  `isDeleted` int(11) DEFAULT 0,
  `createdBy` int(11) DEFAULT 0,
  `createdAt` varchar(250) DEFAULT unix_timestamp(current_timestamp())
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`sId`, `sName`, `isActive`, `isDeleted`, `createdBy`, `createdAt`) VALUES
(1, 'حجم ٢٠', 1, 0, 0, '1677605765'),
(2, 'حجم ٣٠', 1, 0, 0, '1677605765'),
(3, 'حجم ٤٠', 1, 0, 0, '1677605765');

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `tId` int(11) NOT NULL,
  `tName` varchar(250) DEFAULT NULL,
  `isActive` tinyint(4) DEFAULT 1,
  `isDeleted` tinyint(4) DEFAULT 0,
  `createdBy` int(11) DEFAULT 0,
  `createdAt` varchar(250) DEFAULT unix_timestamp(current_timestamp())
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`tId`, `tName`, `isActive`, `isDeleted`, `createdBy`, `createdAt`) VALUES
(1, 'صغير', 1, 0, 0, '1677605798'),
(2, 'متوسط', 1, 0, 0, '1677605798'),
(3, 'كبير', 1, 0, 0, '1677605798');

-- --------------------------------------------------------

--
-- Table structure for table `userpermissions`
--

CREATE TABLE `userpermissions` (
  `upId` int(11) DEFAULT NULL,
  `pId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `isActive` tinyint(4) DEFAULT NULL,
  `isDelleted` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `userpermissions`
--

INSERT INTO `userpermissions` (`upId`, `pId`, `userId`, `isActive`, `isDelleted`) VALUES
(17, 9, 7, 1, 0),
(18, 1, 16, 1, 0),
(19, 3, 16, 1, 0),
(20, 4, 16, 1, 0),
(21, 6, 16, 1, 0),
(22, 7, 16, 1, 0),
(23, 8, 16, 1, 0),
(24, 9, 16, 1, 0),
(27, 1, 18, 1, 0),
(28, 2, 18, 1, 0),
(29, 3, 18, 1, 0),
(30, 4, 18, 1, 0),
(31, 5, 18, 1, 0),
(32, 6, 18, 1, 0),
(33, 7, 18, 1, 0),
(34, 8, 18, 1, 0),
(35, 9, 18, 1, 0),
(36, 10, 18, 1, 0),
(73, 1, 21, 1, 0),
(74, 2, 21, 1, 0),
(119, 1, 13, 1, 0),
(120, 2, 13, 1, 0),
(121, 3, 13, 1, 0),
(122, 4, 13, 1, 0),
(123, 5, 13, 1, 0),
(124, 6, 13, 1, 0),
(125, 7, 13, 1, 0),
(126, 8, 13, 1, 0),
(127, 9, 13, 1, 0),
(128, 10, 13, 1, 0),
(139, 1, 17, 1, 0),
(140, 2, 17, 1, 0),
(141, 3, 17, 1, 0),
(142, 1, 20, 1, 0),
(143, 2, 20, 1, 0),
(144, 3, 20, 1, 0),
(145, 4, 20, 1, 0),
(146, 7, 20, 1, 0),
(147, 8, 20, 1, 0),
(148, 9, 20, 1, 0),
(149, 10, 20, 1, 0),
(150, 1, 22, 1, 0),
(151, 2, 22, 1, 0),
(152, 3, 22, 1, 0),
(153, 4, 22, 1, 0),
(154, 5, 22, 1, 0),
(155, 6, 22, 1, 0),
(156, 7, 22, 1, 0),
(157, 8, 22, 1, 0),
(158, 9, 22, 1, 0),
(159, 10, 22, 1, 0),
(215, 1, 26, 1, 0),
(216, 9, 26, 1, 0),
(217, 10, 26, 1, 0),
(218, 11, 26, 1, 0),
(219, 12, 26, 1, 0),
(478, 1, 29, 1, 0),
(479, 9, 29, 1, 0),
(480, 10, 29, 1, 0),
(481, 11, 29, 1, 0),
(482, 12, 29, 1, 0),
(483, 1, 23, 1, 0),
(484, 9, 23, 1, 0),
(485, 10, 23, 1, 0),
(486, 11, 23, 1, 0),
(487, 12, 23, 1, 0),
(509, 8, 28, 1, 0),
(585, 1, 42, 1, 0),
(586, 9, 42, 1, 0),
(587, 10, 42, 1, 0),
(588, 11, 42, 1, 0),
(589, 12, 42, 1, 0),
(635, 7, 49, 1, 0),
(636, 10, 49, 1, 0),
(658, 7, 50, 1, 0),
(773, 7, 58, 1, 0),
(774, 8, 51, 1, 0),
(775, 9, 51, 1, 0),
(776, 8, 52, 1, 0),
(777, 9, 52, 1, 0),
(778, 8, 53, 1, 0),
(779, 9, 53, 1, 0),
(780, 8, 54, 1, 0),
(781, 9, 54, 1, 0),
(782, 8, 55, 1, 0),
(783, 9, 55, 1, 0),
(784, 8, 56, 1, 0),
(785, 9, 56, 1, 0),
(786, 8, 57, 1, 0),
(787, 9, 57, 1, 0),
(857, 1, 11, 1, 0),
(858, 9, 11, 1, 0),
(859, 10, 11, 1, 0),
(860, 11, 11, 1, 0),
(861, 12, 11, 1, 0),
(862, 13, 11, 1, 0),
(863, 1, 60, 1, 0),
(864, 2, 60, 1, 0),
(865, 3, 60, 1, 0),
(866, 4, 60, 1, 0),
(867, 5, 60, 1, 0),
(868, 6, 60, 1, 0),
(869, 7, 60, 1, 0),
(870, 8, 60, 1, 0),
(871, 9, 60, 1, 0),
(872, 10, 60, 1, 0),
(873, 11, 60, 1, 0),
(874, 12, 60, 1, 0),
(875, 13, 60, 1, 0),
(876, 7, 61, 1, 0),
(890, 1, 48, 1, 0),
(891, 9, 48, 1, 0),
(892, 10, 48, 1, 0),
(893, 12, 48, 1, 0),
(894, 1, 47, 1, 0),
(895, 9, 47, 1, 0),
(896, 10, 47, 1, 0),
(897, 12, 47, 1, 0),
(898, 1, 46, 1, 0),
(899, 9, 46, 1, 0),
(900, 10, 46, 1, 0),
(901, 12, 46, 1, 0),
(902, 1, 2, 1, 0),
(903, 2, 2, 1, 0),
(904, 3, 2, 1, 0),
(905, 4, 2, 1, 0),
(906, 5, 2, 1, 0),
(907, 6, 2, 1, 0),
(908, 7, 2, 1, 0),
(909, 8, 2, 1, 0),
(910, 9, 2, 1, 0),
(911, 10, 2, 1, 0),
(912, 11, 2, 1, 0),
(913, 12, 2, 1, 0),
(914, 13, 2, 1, 0),
(915, 1, 45, 1, 0),
(916, 9, 45, 1, 0),
(917, 10, 45, 1, 0),
(918, 12, 45, 1, 0),
(919, 1, 44, 1, 0),
(920, 9, 44, 1, 0),
(921, 10, 44, 1, 0),
(922, 12, 44, 1, 0),
(923, 1, 43, 1, 0),
(924, 9, 43, 1, 0),
(925, 10, 43, 1, 0),
(926, 12, 43, 1, 0),
(927, 1, 41, 1, 0),
(928, 9, 41, 1, 0),
(929, 10, 41, 1, 0),
(930, 12, 41, 1, 0),
(936, 1, 40, 1, 0),
(937, 9, 40, 1, 0),
(938, 10, 40, 1, 0),
(939, 11, 40, 1, 0),
(940, 12, 40, 1, 0),
(941, 13, 40, 1, 0),
(942, 1, 39, 1, 0),
(943, 9, 39, 1, 0),
(944, 10, 39, 1, 0),
(945, 12, 39, 1, 0),
(946, 1, 38, 1, 0),
(947, 9, 38, 1, 0),
(948, 10, 38, 1, 0),
(949, 12, 38, 1, 0),
(950, 1, 37, 1, 0),
(951, 9, 37, 1, 0),
(952, 10, 37, 1, 0),
(953, 12, 37, 1, 0),
(960, 1, 35, 1, 0),
(961, 9, 35, 1, 0),
(962, 10, 35, 1, 0),
(963, 12, 35, 1, 0),
(964, 1, 34, 1, 0),
(965, 9, 34, 1, 0),
(966, 10, 34, 1, 0),
(967, 12, 34, 1, 0),
(968, 1, 33, 1, 0),
(969, 9, 33, 1, 0),
(970, 10, 33, 1, 0),
(971, 12, 33, 1, 0),
(972, 1, 32, 1, 0),
(973, 9, 32, 1, 0),
(974, 10, 32, 1, 0),
(975, 12, 32, 1, 0),
(980, 1, 30, 1, 0),
(981, 9, 30, 1, 0),
(982, 10, 30, 1, 0),
(983, 12, 30, 1, 0),
(984, 1, 31, 1, 0),
(985, 9, 31, 1, 0),
(986, 10, 31, 1, 0),
(987, 12, 31, 1, 0),
(988, 1, 27, 1, 0),
(989, 9, 27, 1, 0),
(990, 10, 27, 1, 0),
(991, 12, 27, 1, 0),
(992, 1, 25, 1, 0),
(993, 9, 25, 1, 0),
(994, 10, 25, 1, 0),
(995, 11, 25, 1, 0),
(996, 12, 25, 1, 0),
(997, 13, 25, 1, 0),
(998, 1, 24, 1, 0),
(999, 2, 24, 1, 0),
(1000, 9, 24, 1, 0),
(1001, 10, 24, 1, 0),
(1002, 11, 24, 1, 0),
(1003, 12, 24, 1, 0),
(1004, 13, 24, 1, 0),
(1005, 1, 36, 1, 0),
(1006, 9, 36, 1, 0),
(1007, 10, 36, 1, 0),
(1008, 12, 36, 1, 0),
(1009, 13, 36, 1, 0),
(1010, 4, 59, 1, 0),
(1011, 5, 59, 1, 0),
(1012, 6, 59, 1, 0),
(1013, 11, 59, 1, 0),
(1014, 4, 59, 1, 0),
(1015, 5, 59, 1, 0),
(1016, 6, 59, 1, 0),
(1021, 4, 63, 1, 0),
(1022, 5, 63, 1, 0),
(1023, 6, 63, 1, 0),
(1024, 11, 63, 1, 0),
(1037, 1, 64, 1, 0),
(1038, 2, 64, 1, 0),
(1039, 9, 64, 1, 0),
(1040, 10, 64, 1, 0),
(1041, 12, 64, 1, 0),
(1042, 1, 62, 1, 0),
(1043, 2, 62, 1, 0),
(1044, 9, 62, 1, 0),
(1045, 10, 62, 1, 0),
(1046, 12, 62, 1, 0),
(NULL, 10, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `userName` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `img` varchar(250) DEFAULT NULL,
  `uImgDeleted` tinyint(4) DEFAULT NULL,
  `isActive` varchar(1) DEFAULT NULL,
  `isDeleted` tinyint(4) DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdAt` varchar(250) DEFAULT unix_timestamp(current_timestamp())
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `name`, `userName`, `password`, `img`, `uImgDeleted`, `isActive`, `isDeleted`, `createdBy`, `createdAt`) VALUES
(0, 'لم تدقق', NULL, NULL, NULL, 0, '1', 0, NULL, '1667835154'),
(1, 'علي عبدالزهرة', 'xyz', '$2y$10$8fMtrzsyVJjA.UAUip0NwuNVq9x6TfyZkGRjjqx0aeFuzw7DJDvwy', '1912094018_1669286757.png', 0, '1', 0, NULL, '1636371440'),
(2, 'Ali', 'yy', NULL, NULL, 0, '1', 0, NULL, '1636371440'),
(3, 'حسين علي محمد', 'hus', '$2y$10$wLx2x8CNlm15Pn5FljZjsO8MJVApT9fRFF/KMxtgqSSiJYfFt54Xu', NULL, 0, '1', 1, 1, '1640162430'),
(11, 'Ali Jalil', 'ali', '$2y$10$1p6fJuUkLYOOB9u6jBxjGeimYI6wHKeNsJPlm4LAd5wOgrZvM0sZe', 'http://localhost/gifts/images/statics/noimageicon.png', 0, '1', 0, 0, '1667220307'),
(12, '1Ali Jalil', '1ali', '$2y$10$d45yta7OaGCK7vqRkKatEOjGz1nD3mbDw1FasOpKn2vU1vA3vtYeC', 'http://localhost/gifts/images/statics/noimageicon.png', 0, '1', 1, 0, '1667223452'),
(13, 'Sharon Cooke', 'kuruf', '$2y$10$zujPA6a1orIIASfKi0yzMe7NTW38mkI/KEKgtxMvDdqy4fYd.PcNC', '1809836469_1669011706.jpg', 0, '1', 1, 0, '1667225016'),
(14, 'Sharon Cooke', '5kuruf', '$2y$10$fyAWmU0zwXRsOp.UEHjBbOmd9SXt4vjw3swm2gUc8FPecmLtCtNEq', 'http://localhost/gifts/images/statics/noimageicon.png', 0, '1', 1, 0, '1667225085'),
(15, 'Noel Simmons', 'vydane', '$2y$10$TOYAQ.ZrI8D0ipESccF5UeSaDoyK2gKQreFI6YhRmpshorJjQJd1e', 'http://localhost/gifts/images/statics/noimageicon.png', 0, '1', 1, 0, '1667226411'),
(16, 'Skyler Castaneda', 'cotunely', '$2y$10$ErweIFwjMOIq2gQDC/2GqOQuD9Eg9rf4R7sORq5LGTWBpggRcQQJa', 'http://localhost/gifts/images/statics/noimageicon.png', 0, '1', 1, 0, '1667226512'),
(17, 'محسن حسين فاهم ٥', 'ali23', '$2y$10$fNFWsJrFdoYgKdMb0AV1EOhGzwaMD0fjXvBDh6dQYG5WPP6sy6yYO', 'http://localhost/gifts/images/statics/noimageicon.png', 0, '1', 1, 0, '1667231285'),
(18, 'Ali Jalil', 'husam', '$2y$10$ivANYiufPYjJ6sxSE7RdWeG6ujI5.SMm0a7.3pwmZVz5Rlpy/a2ci', 'http://localhost/gifts/images/statics/noimageicon.png', 0, '1', 1, 0, '1667749136'),
(20, 'tweet 2022', 'hyu', '$2y$10$nkeldPKgKZ4CQ1eOCwKmwuw1x0prMcUqIEcBzZccWz2.pC/HIWR2q', 'http://localhost/gifts/images/statics/noimageicon.png', 0, '1', 1, 0, '1668531106'),
(21, 'Oleg Dodson', 'kepute', '$2y$10$b87z3uXCvI7O0ojPX0Vre.auR8Z2JwyNZwQfLMUHLQbITwhfnc6vC', 'http://localhost/gifts/images/statics/noimageicon.png', 0, '1', 1, 0, '1668532813'),
(22, 'zyara', 'krA', '$2y$10$RNkkHFLFMPk7NbSe4KI45O.C6AowwWpYLsxd0jYJzPDbWaOe2uWGW', 'http://localhost/gifts/images/statics/noimageicon.png', 0, '1', 1, 0, '1668682164'),
(23, 'حسين طالب يحيى الزاملي', 'حسين الزاملي', '$2y$10$qApRUuQbvFee2L1Tcq9B0eEPmnDZG93l66T1cw0dUm1ZzI32B/tJ.', 'http://localhost/gifts/images/statics/noimageicon.png', 0, '1', 1, 0, '1668682646'),
(24, 'فاتح  الكرماني', 'فاتح', '$2y$10$mcOhJT2zLFB3/z.M2u6mROMwkxhL3SXx9pyFVH1HwUpGTzBkszO4i', '1948918314_1671865990.png', 0, '1', 0, 0, '1669026632'),
(25, 'زيد خضير السراج', 'زيد', '$2y$10$wxeKhnqNfiEUddbhG/CSA.pcVze8KNYX0cBqmJtGnAP.2JAUcy7gC', '906870458_1669698739.png', 0, '1', 0, 0, '1669099717'),
(26, 'منير', 'moneer', '$2y$10$8k9hfGySXkxI0CtHJsoR0eKVNuGyk8eE1f3rLItoj0KJaC8zm6n/i', 'http://imamali.tech:50031/gifts/images/statics/noimageicon.png', 0, '1', 1, 0, '1669099882'),
(27, 'حسين طالب الزاملي', 'حسين طالب', '$2y$10$oZ43Xi6mDcv0SFmrB1OVWeBDw3pnJVhVcxGdc0VWtJ0yBX.hjH5Ie', '1776710414_1671781472.png', 0, '1', 0, 0, '1669099949'),
(28, 'حيدر ناجح الحسناوي', 'حيدر ناجح', '$2y$10$w1zbY6znv1XA32WZf0FrrO.LDtzbu8YJOb9Ifux2l/Y/.SxsULPUK', 'http://imamali.tech:50031/gifts/images/statics/noimageicon.png', 0, '1', 1, 0, '1669099996'),
(29, 'حيدر محمد  الباججي', 'حيدر الباججي', '$2y$10$w8zBFncb0Lf2rMA7sMyEy.DRzyL0IJFKrxXcNhSa04QbZGNcg5zHa', '71556113_1671781504.png', 0, '1', 0, 0, '1669100056'),
(30, 'منير عبد الكريم الخاقاني', 'منير', '$2y$10$j6fzH9J4Xf/sZu3HIQ69.OjEp/EnMda/iyfJ7g/zsSCaPyjgXh8fS', '1802359160_1673531781.png', 0, '1', 0, 0, '1669100085'),
(31, 'امجد سعد الحمامي', 'امجد الحمامي', '$2y$10$/qNC6v.8/UkP7qLU0slhUOvdXJpGyny60ffdLZDJWvkyovvfoZy8i', '1653186971_1671781531.png', 0, '1', 0, 0, '1669100101'),
(32, 'حسن هادي كزار  الجبري', 'حسن', '$2y$10$88zT7vYKxQN/Q2gx8RPd8OtAJQ52y174p8FskTXUabTkl4OUwzrjS', '1575217551_1671866295.png', 0, '1', 0, 0, '1669100117'),
(33, 'احمد عزيز الحسناوي', 'احمد عزيز', '$2y$10$zsoX8qtYZ8KR3V5C13n9KOjt6zG32l36SBU8Q4mMap6VFV9cYvu5O', '291244192_1671781564.png', 0, '1', 0, 0, '1669100133'),
(34, 'مصطفى محمد  الوائلي', 'مصطفى محمد', '$2y$10$PpAQl0t25wZsFHX0xhdC0.mcdD86NOzn./oV5RePbBMBjbObuTb.O', '1827418409_1671783158.png', 0, '1', 0, 0, '1669794881'),
(35, 'سيف صالح الخفاجي', 'سيف', '$2y$10$zE1Lm9H/Uf/X.VDnBTDX/uiQRefn2DXYPUFKB5QK5xfDOqN7FlOBe', '1356505282_1671783190.png', 0, '1', 0, 0, '1669794955'),
(36, 'عباس فاتح الكرماني', 'عباس', '$2y$10$.vPs/W4k3wP7A1sI0GW82e4lnoiOwflaW8CNIdfdHbWiZAwtP2hvq', '1330191130_1671783200.png', 0, '1', 0, 0, '1669794989'),
(37, 'عزيز ماجد ابو صيبع', 'عزيز', '$2y$10$1D6dPRCzyj76xnOrek/5LuHUHZcWVVcivLm0Es2AC6SVYRGDp2ABm', '1567220518_1671783223.png', 0, '1', 0, 0, '1669795036'),
(38, 'علي محمد محبوبة', 'علي', '$2y$10$svzz04Z0U8L1cNB7Dl/H/u4/2eoev7VsOpunv.jMKSJGOXndKHGqK', '1611045016_1671783239.png', 0, '1', 0, 0, '1669795068'),
(39, 'محمد جعفر رضا حبل المتين', 'محمد جعفر', '$2y$10$NDp1IYbTZZrzlBk2Z8560ORanDOWg3X2xd/REhvZ1dhuquoElnaGm', '1583462232_1671783247.png', 0, '1', 0, 0, '1669795169'),
(40, 'زيد يحيى كاظم خليفة', 'زيد خليفة', '$2y$10$SS7KiOPJukWBE89iDqPOxu4ZY0ElSyheh6UGL2EDV0S8OCRWekZO.', '1467077921_1671783261.png', 0, '1', 0, 0, '1669795199'),
(41, 'امير حافظ عباس صبي', 'امير', '$2y$10$DOFcvoNfgv3wbPoDFVLS8Ogcr5ePAmmLsybv6z7AvmKEUAH/BR2Sa', '738449622_1672120050.png', 0, '1', 0, 0, '1669795293'),
(42, 'محمد عباس فاضل شكر', 'محمد عباس', '$2y$10$.kJrlBO7DeReoniCVkl2.uOhdWZ126GTwICL4aCKg3FZZMEKH1Ch.', '1945289190_1672377476.png', 0, '1', 0, 0, '1669795953'),
(43, 'مصطفى قاسم السهلاني', 'مصطفى قاسم', '$2y$10$DEnxFa3tIUyezDGXNeozcuvrVIfwd/MSlAqbpcC2gWcZsKkADiTMq', '1022135977_1671783336.png', 0, '1', 0, 0, '1669796075'),
(44, 'احمد كريم ابو غنيم', 'احمد كريم', '$2y$10$gSCNp4KefG94GBgWqZFvJOTo73cEtSNryy0eaLSryfrL9XBWw7mK.', '400878145_1671783386.png', 0, '1', 0, 0, '1669796118'),
(45, 'معتز كاظم الفرطوسي', 'معتز', '$2y$10$sB.fk8aomO1iobdQK1jX.uW2yLVqW01/GnsZMDq07lPFgzNQ6529q', '844417812_1671783413.png', 0, '1', 0, 0, '1669796170'),
(46, 'حسين احمد محمد شبر', 'حسين شبر', '$2y$10$e/3oPEAxmxssURXQbr.GUe0xR.368UqmLB.LOm9.DN.YCInLhXvFm', '1722803340_1671783454.png', 0, '1', 0, 0, '1669796204'),
(47, 'فرقان ماجد الخطيب', 'فرقان', '$2y$10$fKjzA2Uglg/VxgaOmIlAh.6JgXsiZWv3kgbvZdbNiB8RFodvnW3B6', '630449407_1671783464.png', 0, '1', 0, 0, '1669796318'),
(48, 'حيدر حسن خليفة', 'حيدر خليفة', '$2y$10$fbOAAQIA0ybua640LLiGi.5242uNdmXOWW6d8oWoVlr3JRrrG0h0q', '1573673621_1671783475.png', 0, '1', 0, 0, '1669796350'),
(49, 'قاسم علي سلمان الميالي', 'قاسم الميالي', '$2y$10$5DbOXcjHCN4t6F3oKJV.TuufKDjWuDjx1Tyquwdnp.zWLDJAMcCN.', 'http://imamali.tech:50031/gifts/images/statics/noimageicon.png', 0, '1', 1, 0, '1670236892'),
(50, 'قاسم علي الميالي', 'سيد قاسم', '$2y$10$WocZWpHD1UiA3cs2VKupteoXgUg0IIUZgFmSka2fU9pgd5HXMu.Cy', 'http://imamali.tech:50031/gifts/images/statics/noimageicon.png', 0, '1', 0, 0, '1670236912'),
(51, 'مؤيد صاحب المذحجي', 'مؤيد', '$2y$10$yNdrSmPQwZjRxUVf.GlE7ekhj1av26iM0IHvK2cqcSW7I5c./Wyay', 'http://imamali.tech:50031/gifts/images/statics/noimageicon.png', 0, '1', 0, 0, '1670236994'),
(52, 'عماد عبد علي كشكول', 'عماد', '$2y$10$N1zBwDmvPUzXXNLhUwTyHOjeGCA5RZMkYGqtIptQXD7mHA6N5rclG', 'http://imamali.tech:50031/gifts/images/statics/noimageicon.png', 0, '1', 0, 0, '1670237417'),
(53, 'علي ميري محمد الزاملي', 'علي ميري', '$2y$10$wIlMZzniMlKg9XR.XPKQXO0nKXt/aYdwXMFygqj7SAldAa4DGE5yK', 'http://imamali.tech:50031/gifts/images/statics/noimageicon.png', 0, '1', 0, 0, '1670237450'),
(54, 'عبد الله ازهر ابو صيبع', 'عبد الله', '$2y$10$LnWGfJBzNUJDUJ/BHSwySuy0R0l6rvh0HbuBkPfxUPhHqZVSQ8xCK', 'http://imamali.tech:50031/gifts/images/statics/noimageicon.png', 0, '1', 0, 0, '1671002329'),
(55, 'سيف كريم خليفة', 'سيف خليفة', '$2y$10$HidtKrGFuw/TUX3b0esmfufX3BKsMcv11u/50lkArIZfLY1hM4B76', 'http://imamali.tech:50031/gifts/images/statics/noimageicon.png', 0, '1', 0, 0, '1671002357'),
(56, 'مصطفى جواد المحناوي', 'مصطفى جواد', '$2y$10$fyj6qn73xCVIYjD2p0Z4dOFZrzUb/l.B2m7dtgktwpKb.7MBDECl2', 'http://imamali.tech:50031/gifts/images/statics/noimageicon.png', 0, '1', 0, 0, '1671002376'),
(57, 'اثير حازم  حميد', 'اثير', '$2y$10$oRMLdCHaP/3sJeF9Wk6k1eUdT75GgG3Wkkm2Al29D4JpIp6Gru1MG', 'http://imamali.tech:50031/gifts/images/statics/noimageicon.png', 0, '1', 0, 0, '1671178463'),
(58, 'حيدر فاضل الجابري', 'حيدر الجابري', '$2y$10$hVjtWULZjOzmZzGqgvb17e1p7TfNZlDAqs7LYrq5/skuCB.WVACbu', 'http://imamali.tech:50031/gifts/images/statics/noimageicon.png', 0, '1', 0, 0, '1671701628'),
(59, 'وليد ابوحنه', 'waleed', '$2y$10$hMuV/iaU6DQ5rDFPZTQ6UOVgdcs0HcfSYyYu80IYNuteKFxXvzZx6', 'http://imamali.tech:50031/gifts/images/statics/noimageicon.png', 0, '1', 0, 0, '1672551214'),
(60, 'ميسر منذر عدنان', 'hh', '$2y$10$a3Kg/HuFoN/zo0YrGkdxpO1JfxKLNqoClO1.O/ATNoV2Gt03eDVTq', 'http://imamali.tech:50031/gifts/images/statics/noimageicon.png', 0, '1', 0, 0, '1672847973'),
(61, 'kk', 'kk', '$2y$10$gOiU8/m2w0IQYIBkQYhcFuEWeyR5VAxOfLUQKRnfGpSJQqHF.zD1u', 'http://imamali.tech:50031/gifts/images/statics/noimageicon.png', 0, '1', 0, 0, '1674374393'),
(62, 'علاء عبد اللطيف محمد', 'علاء', '$2y$10$UiixNacdrcqcE1L9cMs.hO5f0zZzVZ9Xag9Ww2HkzqP8DHmD/YquW', '790083269_1676025032.png', 0, '1', 0, 0, '1676010300'),
(63, 'اكرم طالب كريم', 'akram', '$2y$10$6S1thz2Tqj0TS3OONPaHu.uT8.C79MeOEGMFGs32R189Gq.0wUFaK', 'http://imamali.tech:50031/gifts/images/statics/noimageicon.png', 0, '1', 0, 0, '1676010477'),
(64, 'مصطفى خلف حسين', 'مصطفى', '$2y$10$Vee.74Z3bd7WfDcI5jW34.9NiCchYc775dIi7NMMu4wAHu0xeeAqC', '1816937093_1676025043.png', 0, '1', 0, 0, '1676011083');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detectionEmps`
--
ALTER TABLE `detectionEmps`
  ADD PRIMARY KEY (`deId`),
  ADD UNIQUE KEY `preventDuplicate` (`dId`,`userId`,`exId`);

--
-- Indexes for table `detections`
--
ALTER TABLE `detections`
  ADD PRIMARY KEY (`dId`);

--
-- Indexes for table `detectionsInfo`
--
ALTER TABLE `detectionsInfo`
  ADD PRIMARY KEY (`dInfoId`);

--
-- Indexes for table `extinguishers`
--
ALTER TABLE `extinguishers`
  ADD PRIMARY KEY (`exId`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`sId`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`tId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detectionEmps`
--
ALTER TABLE `detectionEmps`
  MODIFY `deId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `detections`
--
ALTER TABLE `detections`
  MODIFY `dId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detectionsInfo`
--
ALTER TABLE `detectionsInfo`
  MODIFY `dInfoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `extinguishers`
--
ALTER TABLE `extinguishers`
  MODIFY `exId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `sId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `tId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
