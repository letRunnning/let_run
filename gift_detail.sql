-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2021-11-22 03:51:29
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
-- 資料表結構 `gift_detail`
--

CREATE TABLE `gift_detail` (
  `gift_ID` bigint(50) NOT NULL COMMENT '禮品編號',
  `gdetail_size` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'F' COMMENT '尺寸',
  `gdetail_amount` int(5) NOT NULL COMMENT '數量'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='禮品詳細資料';

--
-- 傾印資料表的資料 `gift_detail`
--

INSERT INTO `gift_detail` (`gift_ID`, `gdetail_size`, `gdetail_amount`) VALUES
(1,'F',100),
(2,'M',100),
(2,'S',100),
(3,'F',100),
(5,'F',100),
(7,'F',100);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `gift_detail`
--
ALTER TABLE `gift_detail`
  ADD PRIMARY KEY (`gift_ID`,`gdetail_size`);

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `gift_detail`
--
ALTER TABLE `gift_detail`
  ADD CONSTRAINT `gdetail_gift_ID` FOREIGN KEY (`gift_ID`) REFERENCES `gift` (`gift_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
