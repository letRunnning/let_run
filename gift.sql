-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2021-11-22 03:51:23
-- 伺服器版本： 10.4.19-MariaDB
-- PHP 版本： 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `run`
--

-- --------------------------------------------------------

--
-- 資料表結構 `gift`
--

CREATE TABLE `gift` (
  `gift_ID` bigint(50) NOT NULL COMMENT '禮品編號',
  `group_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '組別名稱',
  `gift_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '禮品名稱',
  `running_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '路跑編號',
  `file_no` bigint(20) UNSIGNED DEFAULT NULL COMMENT '照片檔案編號'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='路跑禮品';

--
-- 傾印資料表的資料 `gift`
--

INSERT INTO `gift` (`gift_ID`, `group_name`, `gift_name`, `running_ID`, `file_no`) VALUES
(1,'休閒組','毛巾','A1',29),
(2,'休閒組','T-shirt','A1',27),
(3,'休閒組','水壺','A1',28),
(4,'休閒組','金萱烏龍','A6',12),
(5,'挑戰組','金萱烏龍','A6',12),
(6,'休閒組','小蛋糕','A6',13),
(7,'挑戰組','小蛋糕','A6',13),
(8,'挑戰組','熱敷巾','A1',31);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `gift`
--
ALTER TABLE `gift`
  ADD PRIMARY KEY (`gift_ID`,`group_name`),
  ADD KEY `gift_running_id` (`running_ID`),
  ADD KEY `gift_file_no` (`file_no`);
ALTER TABLE `gift`
  MODIFY `gift_ID` bigint(50) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '組代碼';
COMMIT;
--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `gift`
--
ALTER TABLE `gift`
  ADD CONSTRAINT `gift_file_no` FOREIGN KEY (`file_no`) REFERENCES `files` (`no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `gift_running_id` FOREIGN KEY (`running_ID`) REFERENCES `running_activity` (`running_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
