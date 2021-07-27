CREATE TABLE `beacon_placement` (
  `beacon_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Beacon 編號',
  `running_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '路跑編號',
  `type` tinyint(4) DEFAULT NULL COMMENT '種類',
  `longitude` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '經度',
  `latitude` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '緯度',
  `is_available` tinyint(4) NOT NULL COMMENT '是否啟用'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Beacon 放置';
ALTER TABLE `beacon_placement`
  ADD PRIMARY KEY (`beacon_ID`,`running_ID`);
ALTER TABLE `beacon_placement`
  ADD CONSTRAINT `B_beacon_id` FOREIGN KEY (`beacon_ID`) REFERENCES `beacon` (`beacon_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `beacon_placement` 
    ADD CONSTRAINT `beacon_placement_running_id` FOREIGN KEY (`running_ID`) REFERENCES `running_activity` (`running_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
INSERT INTO `beacon_placement` (`beacon_ID`,`running_ID`, `type`, `longitude`, `latitude`, `is_available`) VALUES
('EWR-ERQ-45','A1', '起點', '12.45', '159.8', 1),
('SFH-FGH-24','A1', '補給站', '14.87', '87.05', 0),
('SFH-FGH-40','A1', '終點', '102.51', '10.5', 1);

CREATE TABLE `ambulance_place` (
  `pass_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '經過點編號',
  `running_ID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '路跑編號',
  `liciense_plate` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '車牌',
  `time` datetime NOT NULL COMMENT '時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='救護車放置';
ALTER TABLE `ambulance_place`
  ADD PRIMARY KEY (`pass_ID`,`running_ID`);
ALTER TABLE `ambulance_place`
  ADD CONSTRAINT `am_pass_running_ID` FOREIGN KEY (`running_ID`) REFERENCES `running_activity` (`running_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `ambulance_place`
  ADD CONSTRAINT `ambulance_detailsPass_id` FOREIGN KEY (`pass_ID`) REFERENCES `passing_point` (`pass_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
INSERT INTO `ambulance_place` (`pass_ID`,`running_ID`,`liciense_plate`,`time`) VALUES
('L3','A1','ABV-1234', '2020-05-01 14:00:00'),
('L2','A1','ABV-1234', '2020-05-02 13:15:00'),
('L1','A1','ABV-3214', '2020-05-01 13:15:00');

DROP TABLE ` ambulance_details `;
CREATE TABLE `ambulance_details` (
  `liciense_plate` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '車牌',
  `hospital_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '醫院名稱',
  `hospital_phone` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '醫院電話'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='救護車資訊';
ALTER TABLE `ambulance_details`
  ADD PRIMARY KEY (`liciense_plate`);