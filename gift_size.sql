-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2021-11-22 03:54:54
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
-- 資料表結構 `gift_size`
--

CREATE TABLE `gift_size` (
  `registration_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '報名編號',
  `gift_ID` bigint(50) NOT NULL COMMENT '禮品編號',
  `size` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'F' COMMENT '尺寸'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='禮品尺寸';

INSERT INTO `gift_size`(`registration_ID`, `gift_ID`, `size`) 
VALUES 
('A1M000001','1','F'),
('A1M000002','2','S'),
('A1M000003','3','F'),
('A1M000013','1','F'),
('A6M000001','5','F'),
('A6M000006','5','F'),
('A6M000007','5','F'),
('A6M0000013','5','F'),
('A6M0000014','5','F');
--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `gift_size`
--
ALTER TABLE `gift_size`
  ADD PRIMARY KEY (`registration_ID`),
  ADD KEY `gsize_gift_id` (`gift_ID`);

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `gift_size`
--
ALTER TABLE `gift_size`
  ADD CONSTRAINT `gsize_gift_id` FOREIGN KEY (`gift_ID`) REFERENCES `gift` (`gift_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `gsize_registration_id` FOREIGN KEY (`registration_ID`) REFERENCES `registration` (`registration_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
