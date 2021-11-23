CREATE TABLE `temp_email` (
  `no` bigint(20) UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL COMMENT '流水號',
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '信箱',
  `captcha` int(8) DEFAULT NULL COMMENT '驗證碼',
  `time` datetime DEFAULT NULL COMMENT '儲存時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='暫存信箱驗證碼';
