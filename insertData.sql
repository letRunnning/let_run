use `run`;
INSERT INTO `files` (`no`, `name`, `original_name`, `path`, `create_time`, `usable`) VALUES
(1, 'chihiro048.jpg', 'chihiro048.jpg', NULL, '2021-07-09 22:34:52', 1),
(2, 'ponyo041.jpg', 'ponyo041.jpg', NULL, '2021-07-09 22:34:52', 1),
(3, 'ponyo047.jpg', 'ponyo047.jpg', NULL, '2021-07-09 22:34:52', 1),
(4, '968b1af51deafcaf376e6640d03ca3de.png', 'T.png', NULL, '2021-08-03 10:56:01', 1),
(5, '08db15c5cfc661174f4eff412dc4749b.png', 'T.png', NULL, '2021-08-03 10:56:44', 1);

INSERT INTO `running_activity` (`running_ID`, `start_time`, `end_time`, `place`, `name`, `date`, `payment_account`, `payment_bank_code`, `file_no`, `affidavit`) VALUES
('A1', '2021-04-01 00:00:00', '2021-05-01 00:00:00', '國立暨南大學', '暨大春健', '2021-06-01', '1234-4564-3213-6546', '006', 5,'切結書一'),
('A2', '2021-05-01 00:00:00', '2021-06-01 00:00:00', '台中市台灣大道1號', '台中花博馬拉松', '2021-07-01', '1234-4564-3213-6546', '006', NULL,'切結書二'),
('A3', '2021-06-01 00:00:00', '2021-07-01 00:00:00', '南投縣埔里鎮', '埔里山城路跑', '2021-08-01', '1234-4564-3213-6546', '006', NULL,'切結書三'),
('A4', '2021-07-01 00:00:00', '2021-08-01 00:00:00', '屏東縣山地門鄉山地路1號', '屏東霧台之旅', '2021-09-01', '1234-4564-3213-6546', '006', NULL,'切結書四'),
('A5', '2021-08-01 00:00:00', '2021-09-01 00:00:00', '台中市后里區1號', '台中后里之旅', '2021-10-01', '1234-4564-3213-6546', '006', NULL,'切結書五');

INSERT INTO `running_group` (`running_ID`, `group_name`, `kilometers`, `maximum_number`, `start_time`, `end_time`, `qrcode`, `amount`, `place`, `time`) VALUES
('A1', '休閒組', 5, 500, '2021-07-01 07:00:00', '2021-07-01 09:00:00', 'dsad456', 1500, '管院門口', '2021-07-01 06:30:00'),
('A1', '挑戰組', 10, 500, '2021-07-01 06:30:00', '2021-07-01 09:00:00', 'ereg6521', 2000, '管院門口', '2021-07-01 06:00:00');

INSERT INTO `member` (`member_ID`, `id_card`, `name`, `phone`, `email`, `birthday`, `password`, `address`, `contact_name`, `contact_phone`, `relation`, `file_no`) VALUES
('M000001', 'A221234567', '會員一', '0912345678', '123@gmail.com', '2000-07-01', '$2y$10$FBTil9SiGTDRy3tLAMq7r.VYNhbTlTbw2djrxvfKNf3FVacMkHJ4y', '台北市', '會依爸', '0975321854', '父女', 3),
('M000002', 'B121234567', '會員二', '0978945612', '456@gmail.com', '1998-03-18', '$2y$10$NAwfKe1HUd0EmEmk4udmZeDFOCIdajqUlM.IC667dm84Yc.4rKJay', '新竹縣', '會二爸', '0975321877', '父子', 4),
('M000003', 'C120123456', '會員三', '0900000000', '789@gmail.com', '1955-07-05', '$2y$10$NAwfKe1HUd0EmEmk4udmZeDFOCIdajqUlM.IC667dm84Yc.4rKJay', '嘉義市', '會三媽', '0975321888', '母子', 4),
('M000004', 'B123456789', '王小明', '0912345675', '123456@gmail.com', '2001-07-20', '$2y$10$NAwfKe1HUd0EmEmk4udmZeDFOCIdajqUlM.IC667dm84Yc.4rKJay', '台中市北區三民路一段19號', '王大陸', '0987654320', '父', 5);

INSERT INTO `registration` (`registration_ID`, `member_ID`, `time`, `running_ID`, `group_name`) VALUES
('A1M000001', 'M000001', '2021-07-05 15:13:00', 'A1', '休閒組'),
('A1M000002', 'M000002', '2021-07-05 17:18:01', 'A1', '挑戰組'),
('A1M000003', 'M000003', '2021-07-05 11:10:01', 'A1', '休閒組'),
('A1M000004', 'M000004', '2021/08/15 09:53:49', 'A1', '休閒組'),
('A2M000004', 'M000004', '2021-08-01 00:00:00', 'A2', '挑戰組');

INSERT INTO `transaction` (`registration_ID`, `member_ID`, `time`, `bank_code`, `remittance_account`) VALUES
('A1M000001', 'M000001', '2021-07-31 10:53:10', '013', '000112346123'),
('A1M000002', 'M000002', '2021-07-05 17:13:01', '013', '000112346789'),
('A1M000003', 'M000003', '2021-07-10 10:53:20', '013', '000112346456');

INSERT INTO `supply_location`(`supply_ID`, `supply_name`, `longitude`, `latitude`, `running_ID`,`detail`) 
VALUES 
('L1', '暨大大草原', '120.98006570524116', '23.960285234270888','A1','番茄、水'),
('L2', '暨大管院', '120.92723553770514', '23.95230837755845','A1','香蕉、水'),
('L3', '暨大學活', '120.9270873235081', '23.949237919998264','A1','番茄、水'),
('L4', '暨大鵲橋', '120.92811593111232', '23.94964747755151','A1','香蕉、水'),
('L5', '暨大方劇', '120.92908402510038', '23.951931894146004','A1','番茄、水');

INSERT INTO `beacon`(`beacon_ID`, `type`, `version`, `is_available`) VALUES
('EWR-ERQ-45', 'A233','4.0', 0),
('SFH-FGH-24', 'V140','4.0', 0),
('SFH-FGH-40', 'A4785','5.1', 0);

INSERT INTO `beacon_placement`( `beacon_ID`, `running_ID`, `supply_ID`, `longitude`, `latitude`) VALUES
('EWR-ERQ-45', 'A1','L2', '12.45', '159.8'),
('SFH-FGH-24', 'A1','L3', '14.87', '87.05'),
('SFH-FGH-40', 'A1','L4', '102.51', '10.5');

INSERT INTO `location`(`member_ID`, `running_ID`, `pass_time`, `longitude`, `latitude`, `beacon_ID`) VALUES
('M000001', 'A1', '2020-05-01 09:00:00', 123.12, 456.45, 'EWR-ERQ-45'),
('M000001', 'A1', '2020-05-01 09:10:00', 123.12, 456.45, 'SFH-FGH-40');

-- INSERT INTO `passing_point` (`supply_ID`, `pass_name`, `longitude`, `latitude`) VALUES
-- ('L1', '暨大大草原', '12.45', '159.8'),
-- ('L2', '暨大管院', '102.51', '10.5'),
-- ('L3', '暨大學活', '14.87', '87.05');


INSERT INTO `ambulance_details` (`liciense_plate`,  `hospital_name`, `hospital_phone`) VALUES
('ABV-1234', '埔里榮民醫院', '0912345687'),
('ABV-7899',  '埔里基督教醫院', '0912345678'),
('ABV-3214', '埔里基督教醫院', '0912345678');

INSERT INTO `route` (`supply_ID`, `running_ID`, `group_name`, `priority`) VALUES
('L1', 'A1', '休閒組', 1),
('L2', 'A1', '休閒組', 2),
('L3', 'A1', '菁英組', 1);

INSERT INTO `staff` (`staff_ID`, `name`, `password`, `id_card`, `phone`, `email`, `lineid`, `birthday`, `address`, `contact_name`, `contact_phone`, `relation`, `file_no`) VALUES
('S000001', '袁宮依', '$2y$10$w3m3aRSH9I5DdEx4SAdOQ.BqS8kXumpkyJGyzXXSkNy16YTIuPMF6', 'T123456789', '0912123123', '123@gmail.com', 'E123', '1999-01-01', '埔里鎮中山路1號', '宮依爸', '0932321321', '父女', NULL),
('S000002', '袁宮二', '$2y$10$w3m3aRSH9I5DdEx4SAdOQ.BqS8kXumpkyJGyzXXSkNy16YTIuPMF6', 'T123456987', '0945456456', '456@gmail.com', 'E456', '1999-01-02', '埔里鎮中山路2號', '宮二爸', '0965654654', '父子', NULL),
('S000003', '袁宮參', '$2y$10$w3m3aRSH9I5DdEx4SAdOQ.BqS8kXumpkyJGyzXXSkNy16YTIuPMF6', 'T123456987', '0978789789', '789@gmail.com', 'E789', '1999-01-03', '埔里鎮中山路ˇ3號', '宮參媽', '0932321321', '母女', NULL),
('S000004', 'testMan', '$2y$10$w3m3aRSH9I5DdEx4SAdOQ.BqS8kXumpkyJGyzXXSkNy16YTIuPMF6', 't00000000', '09999999', 'test@gmail.com', 'testlineid', '2021-08-08', 'test-add', 'test-parent', '08888888', '父子', NULL),
('S000005', 'testMan', '$2y$10$w3m3aRSH9I5DdEx4SAdOQ.BqS8kXumpkyJGyzXXSkNy16YTIuPMF6', 't00000000', '09999999', 'test@gmail.com', 'testlineid', '2021-08-08', 'test-add', 'test-parent', '08888888', '父子', NULL),
('S000007', '小鹿', '$2y$10$A1xUqdakPBwKaax4twPZl.liFDTBSgHHGxnupNhHmZt4HFCM4/nrO', '0987665443', '0987665443', 'B1234567@gmail.com', '1234566', '1997-08-03', '台北市花田區花田一路', '斑比', '0988112345', '父', 5);

INSERT INTO `work_content` (`work_ID`,`running_ID`, `place`, `content`) VALUES
('1','A1', '暨南大學學生活動中心', '伺機而動'),
('2','A1', '暨南大學學生活動中心', '負責記錄已報到會員名單'),
('3','A1', '日月潭伊達邵', '伺機而動');

INSERT INTO `work_group` (`workgroup_ID`, `running_ID`, `name`, `leader`, `line`, `assembletime`, `assembleplace`,`maximum_number`) VALUES
(1, 'A1', '機動組', '袁宮依', 'http://line.me/ti/g/W14ABM_xo_', '2020-05-01 09:00:00', '暨南大學學生活動中心',100),
(2, 'A1', '報到組', '袁宮二', 'http://line.me/ti/v/W14ABM_vo_', '2020-05-01 09:00:00', '暨南大學大草坪',100),
(3, 'A2', '機動組', '袁宮依', 'http://line.me/ti/g/W14JIS_vo_', '2020-06-05 09:00:00', '日月潭伊達邵',100);

INSERT INTO `staff_participation`(`workgroup_ID`, `staff_ID`, `running_ID`, `checkin_time`) VALUES
(1, 'S000001', 'A1', NULL),
(3, 'S000001', 'A2', NULL),
(2, 'S000002', 'A1', NULL),
(2, 'S000003', 'A1', NULL),
(3, 'S000003', 'A2', NULL),
(1, 'S000005', 'A1', NULL),
(3, 'S000005', 'A2', NULL);

INSERT INTO `assignment` (`work_ID`, `time`, `workgroup_ID`) VALUES
('1', '2020-05-01 13:15:00', 1),
('2', '2020-05-01 13:15:00', 2),
('3', '2020-05-01 13:15:00', 2);

INSERT INTO `redeem` (`registration_ID`, `staff_ID`, `redeem_time`) VALUES
('A1M000001', 'E108211032', '2020-05-01 16:15:00'),
('A1M000002', 'E108211032', '2020-05-01 16:16:15'),
('A1M000003', 'E108211031', '2020-05-01 16:20:00');

INSERT INTO `gift` (`gift_ID`, `group_name`, `gift_name`, `running_ID`, `file_no`) VALUES
('G1', '休閒組', '毛巾', 'A1', NULL),
('G2', '休閒組', 'T-shirt', 'A1', NULL),
('G3', '休閒組', '水壺', 'A1', NULL);

INSERT INTO `gift_detail` (`gift_ID`, `gdetail_size`, `gdetail_amount`) VALUES
('G1', 'F', 100),
('G2', 'M', 100),
('G2', 'S', 100),
('G3', 'F', 100);

INSERT INTO `gift_size` (`registration_ID`, `gift_ID`, `size`) VALUES
('A1M000001', 'G1', 'F'),
('A1M000002', 'G2', 'S'),
('A1M000003', 'G3', 'F');

INSERT INTO `grade` (`running_ID`, `group_name`, `order`, `member_ID`) VALUES
('A1', '休閒組', 1, 'M000001'),
('A1', '休閒組', 2, 'M000002'),
('A1', '休閒組', 3, 'M000003');

INSERT INTO `ambulance_placement` (`supply_ID`,`running_ID`,`liciense_plate`,`time`) VALUES
('L3','A1','ABV-1234', '2020-05-01 14:00:00'),
('L2','A1','ABV-1234', '2020-05-02 13:15:00'),
('L1','A1','ABV-3214', '2020-05-01 13:15:00');

INSERT INTO `route_detail` (`no`, `running_ID`, `group_name`, `detail`, `longitude`, `latitude`) VALUES
(1, 'A1', '休閒組', '大學路右轉', '120.93032423', '23.95030649'),
(2, 'A1', '休閒組', '左轉', '120.93088581', '23.95041975'),
(3, 'A1', '休閒組', '左轉', '120.93109088', '23.95177417'),
(4, 'A1', '休閒組', '直走', '120.93023162', '23.95189620'),
(5, 'A1', '休閒組', '右轉', '120.93045483', '23.95280107'),
(6, 'A1', '休閒組', '繼續往前', '120.93095031', '23.95347542'),
(7, 'A1', '休閒組', '左轉台灣欒樹步道', '120.93113671', '23.95423017'),
(8, 'A1', '休閒組', '左彎', '120.92841381', '23.95453039'),
(9, 'A1', '休閒組', '左彎', '120.92760945', '23.95451131'),
(11, 'A1', '挑戰組', '起點', '120.93567161', '23.95056852'),
(13, 'A1', '挑戰組', '直走', '120.93528627', '23.95079672'),
(14, 'A1', '挑戰組', '右轉', '120.93488438', '23.95082149'),
(15, 'A1', '挑戰組', '直走', '120.93482664', '23.95137099'),
(16, 'A1', '挑戰組', '直走', '120.93468235', '23.95197897'),
(17, 'A1', '挑戰組', '直走', '120.93446410', '23.95250661'),
(18, 'A1', '挑戰組', '直走', '120.93401535', '23.95316487'),
(19, 'A1', '挑戰組', '直走', '120.93360765', '23.95353941'),
(20, 'A1', '挑戰組', '直走', '120.93277214', '23.95399189'),
(21, 'A1', '挑戰組', '直走', '120.93114520', '23.95426658'),
(22, 'A1', '挑戰組', '右轉', '120.92838534', '23.95455564'),
(23, 'A1', '挑戰組', '左彎', '120.92830822', '23.95633720'),
(26, 'A1', '挑戰組', '左彎', '120.92816355', '23.95668170'),
(27, 'A1', '挑戰組', '直走', '120.92784616', '23.95683618'),
(28, 'A1', '挑戰組', '直走', '120.92738372', '23.95685133'),
(29, 'A1', '挑戰組', '左轉', '120.92674327', '23.95687252');

INSERT INTO `checkin` (`registration_ID`, `staff_ID`, `checkin_time`) VALUES
('A1M000001', 'S000001', '2021-08-04 20:56:46'),
('A1M000002', 'S000001', '2021-08-02 22:39:06'),
('A1M000003', 'S000001', '2021-08-02 22:35:00'),
('A2M000004', 'S000005', '2021-08-12 12:55:37');