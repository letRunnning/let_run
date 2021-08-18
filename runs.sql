-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2021-07-17 09:01:53
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
-- 資料庫： `runs`
--

-- --------------------------------------------------------

--
-- 資料表結構 `ambulance_details`
--
CREATE DATABASE `runnings`;
use `runnings`;

CREATE TABLE `route_detail` (
  `no` bigint(20) UNSIGNED NOT NULL COMMENT '流水號',
  `running_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '路跑編號',
  `group_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '組別名稱',
  `detail` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '路線詳細說明',
  `longitude` DECIMAL( 11, 8 ) COMMENT '經度',
  `latitude` DECIMAL( 10, 8 ) NOT NULL COMMENT '緯度'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='路線詳細內容';

CREATE TABLE `db_log` (
  `user` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '使用者帳號',
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '操作時間',
  `function` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '操作函式',
  `command` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '操作內容'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='資料庫操作紀錄';
CREATE TABLE `users` (
  `id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '帳號',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '密碼',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '姓名',
  `manager` tinyint(4) NOT NULL DEFAULT 0 COMMENT '是否為主管',
  `yda` tinyint(3) UNSIGNED DEFAULT NULL COMMENT '青年署專員編號',
  `county` tinyint(3) UNSIGNED DEFAULT NULL COMMENT '縣市編號',
  `organization` mediumint(8) UNSIGNED DEFAULT NULL COMMENT '機構編號',
  `counselor` mediumint(8) UNSIGNED DEFAULT NULL COMMENT '輔導員編號',
  `youth` bigint(20) UNSIGNED DEFAULT NULL COMMENT '青少年',
  `usable` tinyint(4) NOT NULL DEFAULT 1 COMMENT '可否使用',
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '聯繫email',
  `line` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'line帳號',
  `office_phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '辦公室聯絡電話'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='使用者';

--
-- 傾印資料表的資料 `users`
--

INSERT INTO `users` (`id`, `password`, `name`, `manager`, `yda`, `county`, `organization`, `counselor`, `youth`, `usable`, `email`, `line`, `office_phone`) VALUES
('counselor', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '輔導員', 0, NULL, 1, 1, 1, NULL, 1, NULL, NULL, NULL),
('countycontractor', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '縣市承辦人', 0, NULL, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL),
('countymanager', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '縣市主管', 1, NULL, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL),
('organizationcontractor', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '機構承辦人', 0, NULL, 1, 1, NULL, NULL, 1, NULL, NULL, NULL),
('organizationmanager', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '機構主管', 1, NULL, 1, 1, NULL, NULL, 1, NULL, NULL, NULL),
('user', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '李負責人', 0, 0, 0, 0, 1, NULL, 1, NULL, NULL, NULL),
('yda', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '青年署專員', 1, 1, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL);


CREATE TABLE `ambulance_details` (
  `liciense_plate` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '車牌',
  `hospital_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '醫院名稱',
  `hospital_phone` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '醫院電話'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='救護車資訊';
--
-- 資料表結構 `ambulance_place`
--

CREATE TABLE `ambulance_place` (
  `no` bigint(20) UNSIGNED NOT NULL COMMENT '流水號',
  `supply_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '補給站編號',
  `running_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '路跑編號',
  `liciense_plate` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '車牌',
  `time` datetime NOT NULL COMMENT '時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='救護車放置';
-- --------------------------------------------------------

--
-- 資料表結構 `assignment`
--

CREATE TABLE `assignment` (
  `work_ID` bigint(20) UNSIGNED NOT NULL COMMENT '工作編號',
  `time` datetime NOT NULL COMMENT '時間',
  `workgroup_ID` bigint(50) UNSIGNED NOT NULL COMMENT '組代碼'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='分派';

-- --------------------------------------------------------

--
-- 資料表結構 `beacon`
--

CREATE TABLE `beacon` (
  `beacon_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Beacon 編號',
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '型號',
  `version` varchar(50) NOT NULL COMMENT '藍芽版本',
  `is_available` int(5) NOT NULL COMMENT '是否使用'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Beacon';

-- --------------------------------------------------------

--
-- 資料表結構 `beacon_placement`
--

CREATE TABLE `beacon_placement` (
  `no` bigint(20) UNSIGNED NOT NULL COMMENT '流水號',
  `beacon_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Beacon 編號',
  `running_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '路跑編號',
  `supply_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '補給站編號',
  `longitude` DECIMAL( 11, 8 )  NOT NULL COMMENT '經度',
  `latitude` DECIMAL( 10, 8 ) NOT NULL COMMENT '緯度'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Beacon 放置';

-- --------------------------------------------------------

--
-- 資料表結構 `checkin`
--

CREATE TABLE `checkin` (
  `registration_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '報名編號',
  `staff_ID` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '員工編號',
  `checkin_time` datetime NOT NULL COMMENT '報到時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='報到';

-- --------------------------------------------------------

--
-- 資料表結構 `files`
--

CREATE TABLE `files` (
  `no` bigint(20) UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL COMMENT '流水號',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '檔案名稱',
  `original_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '檔案原始名稱',
  `path` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '檔案路徑',
  `create_time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '建立時間',
  `usable` tinyint(4) NOT NULL DEFAULT 1 COMMENT '可否使用'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='檔案';

-- --------------------------------------------------------

--
-- 資料表結構 `gift`
--

CREATE TABLE `gift` (
  `gift_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '禮品編號',
  `group_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '組別名稱',
  `gift_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '禮品名稱',
  `running_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '路跑編號',
  `file_no` bigint(20) UNSIGNED DEFAULT NULL COMMENT '照片檔案編號'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='路跑禮品';

-- --------------------------------------------------------

--
-- 資料表結構 `gift_detail`
--

CREATE TABLE `gift_detail` (
  `gift_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '禮品編號',
  `gdetail_size` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'F' COMMENT '尺寸',
  `gdetail_amount` int(5) NOT NULL COMMENT '數量'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='禮品詳細資料';

-- --------------------------------------------------------

--
-- 資料表結構 `gift_size`
--

CREATE TABLE `gift_size` (
  `registration_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '報名編號',
  `gift_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '禮品編號',
  `size` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'F' COMMENT '尺寸'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='禮品尺寸';

-- --------------------------------------------------------

--
-- 資料表結構 `grade`
--

CREATE TABLE `grade` (
  `running_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '路跑編號',
  `group_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '組別名稱',
  `order` int(50) NOT NULL COMMENT '名次',
  `member_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '會員編號'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='名次';

-- --------------------------------------------------------

--
-- 資料表結構 `location`
--

CREATE TABLE `location` (
  `member_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '會員編號',
  `running_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '路跑編號',
  `pass_time` datetime NOT NULL COMMENT '經過時間',
  `longitude` DECIMAL( 11, 8 )  NOT NULL COMMENT '經度',
  `latitude` DECIMAL( 10, 8 ) NOT NULL COMMENT '緯度',
  `beacon_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Beacon 編號'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='位置資訊';

-- --------------------------------------------------------

--
-- 資料表結構 `member`
--

CREATE TABLE `member` (
  `member_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '會員編號',
  `id_card` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '身分證',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '姓名',
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '電話',
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '信箱',
  `birthday` date NOT NULL COMMENT '生日',
  `password` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '密碼',
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '地址',
  `contact_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '緊急連絡人姓名',
  `contact_phone` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '緊急連絡人電話',
  `relation` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '與會員之關係',
  `file_no` bigint(20) UNSIGNED DEFAULT NULL COMMENT '照片檔案編號'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='會員';

-- --------------------------------------------------------

--
-- 資料表結構 `supply_location`
--

CREATE TABLE `supply_location` (
  `supply_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '補給站編號',
  `supply_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '補給站名稱',
  `longitude` DECIMAL( 11, 8 )  NOT NULL COMMENT '經度',
  `latitude` DECIMAL( 10, 8 ) NOT NULL COMMENT '緯度',
  `running_ID` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '路跑編號',
  `detail` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '補給物資'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='補給站';

-- --------------------------------------------------------

--
-- 資料表結構 `redeem`
--

CREATE TABLE `redeem` (
  `registration_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '報名編號',
  `staff_ID` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '員工編號',
  `redeem_time` datetime NOT NULL COMMENT '兌換時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='兌換';

-- --------------------------------------------------------

--
-- 資料表結構 `registration`
--

CREATE TABLE `registration` (
  `registration_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '報名編號',
  `member_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '會員編號',
  `time` datetime NOT NULL COMMENT '報名時間',
  `running_ID` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '路跑編號',
  `group_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '組別名稱',
  `qrcode` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'QRcode'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='報名';

-- --------------------------------------------------------

--
-- 資料表結構 `route`
--

CREATE TABLE `route` (
  `supply_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '補給站編號',
  `running_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '路跑編號',
  `group_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '組別名稱',
  `priority` int(100) NOT NULL COMMENT '排序'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='路線';

-- --------------------------------------------------------

--
-- 資料表結構 `running_activity`
--

CREATE TABLE `running_activity` (
  `running_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '路跑編號',
  `start_time` datetime NOT NULL COMMENT '報名開始時間',
  `end_time` datetime NOT NULL COMMENT '報名結束時間',
  `place` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '活動地點',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '活動名稱',
  `date` date NOT NULL COMMENT '活動日期',
  `payment_account` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '繳費帳號',
  `payment_bank_code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '繳費銀行代碼',
  `file_no` bigint(20) UNSIGNED DEFAULT NULL COMMENT '照片檔案編號',
  `affidavit` text NOT NULL COMMENT '切結書'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='路跑活動';

-- --------------------------------------------------------

--
-- 資料表結構 `running_group`
--

CREATE TABLE `running_group` (
  `running_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '路跑編號',
  `group_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '組別名稱',
  `kilometers` int(50) NOT NULL COMMENT '公里數',
  `maximum_number` int(20) NOT NULL COMMENT '人數上限',
  `start_time` datetime NOT NULL COMMENT '起跑時間',
  `end_time` datetime NOT NULL COMMENT '結束時間',
  `qrcode` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '禮品QRcode',
  `amount` int(20) NOT NULL COMMENT '報名金額',
  `place` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '報到地點',
  `time` datetime NOT NULL COMMENT '報到時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='路跑組別';

-- --------------------------------------------------------

--
-- 資料表結構 `staff`
--

CREATE TABLE `staff` (
  `staff_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '員工編號',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '姓名',
  `password` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '密碼',
  `id_card` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '身分證',
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '電話',
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '信箱',
  `lineid` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'LineID',
  `birthday` date NOT NULL COMMENT '生日',
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '地址',
  `contact_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '緊急連絡人姓名',
  `contact_phone` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '緊急連絡人電話',
  `relation` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '與會員之關係',
  `file_no` bigint(20) UNSIGNED DEFAULT NULL COMMENT '照片檔案編號'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='工作人員';

-- --------------------------------------------------------

--
-- 資料表結構 `staff_participation`
--

CREATE TABLE `staff_participation` (
  `workgroup_ID` bigint(50) UNSIGNED NOT NULL COMMENT '組代碼',
  `staff_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '員工ID',
  `running_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '路跑編號',
  `checkin_time` datetime NULL COMMENT '報到時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='參與';



-- --------------------------------------------------------

--
-- 資料表結構 `transaction`
--

CREATE TABLE `transaction` (
  `registration_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '報名編號',
  `member_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '會員編號',
  `time` datetime NOT NULL COMMENT '交易時間',
  `bank_code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '銀行代號',
  `remittance_account` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '匯款帳號'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='交易';

-- --------------------------------------------------------

--
-- 資料表結構 `work_content`
--

CREATE TABLE `work_content` (
  `work_ID` bigint(20) UNSIGNED NOT NULL COMMENT '工作編號',
  `running_ID` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '路跑編號',
  `place` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '地點',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '內容'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='工作內容';

-- --------------------------------------------------------

--
-- 資料表結構 `work_group`
--

CREATE TABLE `work_group` (
  `workgroup_ID` bigint(50) UNSIGNED NOT NULL COMMENT '組代碼',
  `running_ID` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '路跑編號',
  `name` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '名稱',
  `leader` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '負責人',
  `line` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '工作Line群組',
  `assembletime` datetime NOT NULL COMMENT '集合時間',
  `endtime` datetime NOT NULL COMMENT '結束時間',
  `assembleplace` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '集合地點',
  `maximum_number` int(20) NOT NULL COMMENT '人數上限'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='工作組別';

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `ambulance_details`
--
ALTER TABLE `ambulance_details`
  ADD PRIMARY KEY (`liciense_plate`);
  -- ADD PRIMARY KEY (`liciense_plate`,`arrivetime`),
  -- ADD KEY `am_supply_ID` (`supply_ID`);

--
-- 資料表索引 `ambulance_place`
--
ALTER TABLE `ambulance_place`
  -- ADD PRIMARY KEY (`supply_ID`,`running_ID`);
  ADD PRIMARY KEY (`no`),
  ADD KEY `ambulance_place_running_id` (`running_ID`),
  ADD KEY `ambulance_place_supply_id` (`supply_ID`);


--
-- 資料表索引 `assignment`
--
ALTER TABLE `assignment`
  ADD PRIMARY KEY (`work_ID`,`workgroup_ID`),
  ADD KEY `assig_workgroup_id` (`workgroup_ID`);

--
-- 資料表索引 `beacon`
--
ALTER TABLE `beacon`
  ADD PRIMARY KEY (`beacon_ID`);

--
-- 資料表索引 `beacon_placement`
--
ALTER TABLE `beacon_placement`
  ADD PRIMARY KEY (`no`),
  ADD KEY `beacon_placement_beacon_id` (`beacon_ID`),
  ADD KEY `beacon_placement_running_id` (`running_ID`),
  ADD KEY `beacon_placement_supply_id` (`supply_ID`);

--
-- 資料表索引 `checkin`
--
ALTER TABLE `checkin`
  ADD PRIMARY KEY (`registration_ID`),
  ADD KEY `checkin_staff_id` (`staff_ID`);

--
-- 資料表索引 `files`
--
-- ALTER TABLE `files`
--   ADD PRIMARY KEY (`no`);

--
-- 資料表索引 `gift`
--
ALTER TABLE `gift`
  ADD PRIMARY KEY (`gift_ID`,`group_name`),
  ADD KEY `gift_running_id` (`running_ID`),
  ADD KEY `gift_file_no` (`file_no`);

--
-- 資料表索引 `gift_detail`
--
ALTER TABLE `gift_detail`
  ADD PRIMARY KEY (`gift_ID`,`gdetail_size`);

--
-- 資料表索引 `gift_size`
--
ALTER TABLE `gift_size`
  ADD PRIMARY KEY (`registration_ID`),
  ADD KEY `gsize_gift_id` (`gift_ID`);

--
-- 資料表索引 `grade`
--
ALTER TABLE `grade`
  ADD PRIMARY KEY (`running_ID`,`group_name`,`order`),
  ADD KEY `grade_member_id` (`member_ID`);

--
-- 資料表索引 `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`member_ID`,`running_ID`,`pass_time`),
  ADD KEY `loc_running_id` (`running_ID`);

--
-- 資料表索引 `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_ID`),
  ADD KEY `member_file_no` (`file_no`);

--
-- 資料表索引 `supply_location`
--
ALTER TABLE `supply_location`
  ADD PRIMARY KEY (`supply_ID`),
  ADD KEY `supply_location_running_ID` (`running_ID`);
--
-- 資料表索引 `redeem`
--
ALTER TABLE `redeem`
  ADD PRIMARY KEY (`registration_ID`);

--
-- 資料表索引 `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`registration_ID`),
  ADD KEY `regi_member_id` (`member_ID`),
  ADD KEY `regi_running_id` (`running_ID`);

--
-- 資料表索引 `route`
--
ALTER TABLE `route`
  ADD PRIMARY KEY (`supply_ID`,`priority`) USING BTREE,
  ADD KEY `route_running_id` (`running_ID`);

--
-- 資料表索引 `running_activity`
--
ALTER TABLE `running_activity`
  ADD PRIMARY KEY (`running_ID`),
  ADD KEY `running_activity_file_no` (`file_no`);

--
-- 資料表索引 `running_group`
--
ALTER TABLE `running_group`
  ADD PRIMARY KEY (`running_ID`,`group_name`);

--
-- 資料表索引 `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_ID`),
  ADD KEY `staff_file_no` (`file_no`);

--
-- 資料表索引 `staff_participation`
--
ALTER TABLE `staff_participation`
  ADD PRIMARY KEY (`workgroup_ID`,`staff_ID`),
  ADD KEY `staff_participation_staff_id` (`staff_ID`);

--
-- 資料表索引 `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`registration_ID`),
  ADD KEY `trans_member_id` (`member_ID`);

--
-- 資料表索引 `work_content`
--
ALTER TABLE `work_content`
  ADD PRIMARY KEY (`work_ID`),
  ADD KEY `work_content_running_ID` (`running_ID`);
--
-- 資料表索引 `staff_participation`
--
ALTER TABLE `staff_participation`
  ADD CONSTRAINT `staff_participation_running_id` FOREIGN KEY (`running_ID`) REFERENCES `running_activity` (`running_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表索引 `work_group`
--
ALTER TABLE `work_group`
  ADD PRIMARY KEY (`workgroup_ID`),
  ADD KEY `work_running_ID` (`running_ID`);

ALTER TABLE `work_group`
  MODIFY `workgroup_ID` bigint(50) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '組代碼';
COMMIT;
--
-- 已傾印資料表的限制式
--
ALTER TABLE `work_content`
  MODIFY `work_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '工作編號';

ALTER TABLE `beacon_placement`
  MODIFY `no` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '流水號';
ALTER TABLE `ambulance_place`
  MODIFY `no` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '流水號';

-- 資料表的限制式 `work_content`
--
ALTER TABLE `work_content`
  ADD CONSTRAINT `work_content_running_ID` FOREIGN KEY (`running_ID`) REFERENCES `running_activity` (`running_ID`) on delete CASCADE on update CASCADE;

--
-- 資料表的限制式 `assignment`
--

-- ALTER TABLE `assignment`
--   ADD CONSTRAINT `work_content_running_ID` FOREIGN KEY (`running_ID`) REFERENCES `running_activity` (`running_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `assignment`
  ADD CONSTRAINT `assig_work_id` FOREIGN KEY (`work_ID`) REFERENCES `work_content` (`work_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assig_workgroup_id` FOREIGN KEY (`workgroup_ID`) REFERENCES `work_group` (`workgroup_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `beacon_placement`
--
ALTER TABLE `beacon_placement`
  ADD CONSTRAINT `B_beacon_id` FOREIGN KEY (`beacon_ID`) REFERENCES `beacon` (`beacon_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `beacon_placement_running_id` FOREIGN KEY (`running_ID`) REFERENCES `running_activity` (`running_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `beacon_placement_supply_id` FOREIGN KEY (`supply_ID`) REFERENCES `supply_location` (`supply_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `checkin`
--
ALTER TABLE `checkin`
  ADD CONSTRAINT `checkin_registration_id` FOREIGN KEY (`registration_ID`) REFERENCES `registration` (`registration_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `checkin_staff_id` FOREIGN KEY (`staff_ID`) REFERENCES `staff` (`staff_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `gift`
--
ALTER TABLE `gift`
  ADD CONSTRAINT `gift_file_no` FOREIGN KEY (`file_no`) REFERENCES `files` (`no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `gift_running_id` FOREIGN KEY (`running_ID`) REFERENCES `running_activity` (`running_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `gift_detail`
--
ALTER TABLE `gift_detail`
  ADD CONSTRAINT `gdetail_gift_ID` FOREIGN KEY (`gift_ID`) REFERENCES `gift` (`gift_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `gift_size`
--
ALTER TABLE `gift_size`
  ADD CONSTRAINT `gsize_gift_id` FOREIGN KEY (`gift_ID`) REFERENCES `gift` (`gift_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `gsize_registration_id` FOREIGN KEY (`registration_ID`) REFERENCES `registration` (`registration_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `grade`
--
ALTER TABLE `grade`
  ADD CONSTRAINT `grade_member_id` FOREIGN KEY (`member_ID`) REFERENCES `member` (`member_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `grade_running_ID` FOREIGN KEY (`running_ID`) REFERENCES `running_activity` (`running_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `location`
--
ALTER TABLE `location`
  ADD CONSTRAINT `loc_member_id` FOREIGN KEY (`member_ID`) REFERENCES `member` (`member_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `loc_running_id` FOREIGN KEY (`running_ID`) REFERENCES `running_activity` (`running_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `member`
--
ALTER TABLE `member`
  ADD CONSTRAINT `member_file_no` FOREIGN KEY (`file_no`) REFERENCES `files` (`no`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `redeem`
--
ALTER TABLE `redeem`
  ADD CONSTRAINT `redeem_regis_id` FOREIGN KEY (`registration_ID`) REFERENCES `registration` (`registration_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `registration`
--
ALTER TABLE `registration`
  ADD CONSTRAINT `regi_member_id` FOREIGN KEY (`member_ID`) REFERENCES `member` (`member_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `regi_running_id` FOREIGN KEY (`running_ID`) REFERENCES `running_activity` (`running_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `route`
--
ALTER TABLE `route`
  ADD CONSTRAINT `route_supply_ID` FOREIGN KEY (`supply_ID`) REFERENCES `supply_location` (`supply_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `route_running_id` FOREIGN KEY (`running_ID`) REFERENCES `running_activity` (`running_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `running_activity`
--
ALTER TABLE `running_activity`
  ADD CONSTRAINT `running_activity_file_no` FOREIGN KEY (`file_no`) REFERENCES `files` (`no`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `running_group`
--
ALTER TABLE `running_group`
  ADD CONSTRAINT `group_running_id` FOREIGN KEY (`running_ID`) REFERENCES `running_activity` (`running_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_file_no` FOREIGN KEY (`file_no`) REFERENCES `files` (`no`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `staff_participation`
--
ALTER TABLE `staff_participation`
  ADD CONSTRAINT `par_staff_ID` FOREIGN KEY (`staff_ID`) REFERENCES `staff` (`staff_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `trans_member_id` FOREIGN KEY (`member_ID`) REFERENCES `member` (`member_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `trans_registration_id` FOREIGN KEY (`registration_ID`) REFERENCES `registration` (`registration_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的限制式 `work_group`
--
ALTER TABLE `work_group`
  ADD CONSTRAINT `work_running_ID` FOREIGN KEY (`running_ID`) REFERENCES `running_activity` (`running_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

ALTER TABLE `supply_location`
  ADD CONSTRAINT `supply_location_running_ID` FOREIGN KEY (`running_ID`) REFERENCES `running_activity` (`running_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
--
-- 資料表的限制式 `ambulance_place`
--
ALTER TABLE `ambulance_place`
  ADD CONSTRAINT `am_pass_running_ID` FOREIGN KEY (`running_ID`) REFERENCES `running_activity` (`running_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ambulance_detailssupply_ID` FOREIGN KEY (`supply_ID`) REFERENCES `supply_location` (`supply_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `route_detail`
  ADD PRIMARY KEY (`no`,`running_ID`,`group_name`),
  ADD KEY `route_detail_running_ID` (`running_ID`);
ALTER TABLE `route_detail`
  MODIFY `no` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '流水號';
ALTER TABLE `route_detail`
  ADD CONSTRAINT `route_detail_running_ID` FOREIGN KEY (`running_ID`) REFERENCES `running_activity` (`running_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
