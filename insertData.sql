INSERT INTO `files` (`no`, `name`, `original_name`, `path`, `create_time`, `usable`) VALUES
(1, 'chihiro048.jpg', 'chihiro048.jpg', NULL, '2021-07-10 06:34:52', 1),
(2, 'ponyo041.jpg', 'ponyo041.jpg', NULL, '2021-07-10 06:34:52', 1),
(3, 'ponyo047.jpg', 'ponyo047.jpg', NULL, '2021-07-10 06:34:52', 1);

INSERT INTO `running_activity` (`running_ID`, `start_time`, `end_time`, `place`, `name`, `date`, `payment_account`, `payment_bank_code`, `file_no`) VALUES
('A1', '2021-04-01 00:00:00', '2021-05-01 00:00:00', '國立暨南大學', '暨大春健', '2021-06-01', '1234-4564-3213-6546', '006', NULL),
('A2', '2021-05-01 00:00:00', '2021-06-01 00:00:00', '台中市台灣大道1號', '台中花博馬拉松', '2021-07-01', '1234-4564-3213-6546', '006', NULL),
('A3', '2021-06-01 00:00:00', '2021-07-01 00:00:00', '南投縣埔里鎮', '埔里山城路跑', '2021-08-01', '1234-4564-3213-6546', '006', NULL),
('A4', '2021-07-01 00:00:00', '2021-08-01 00:00:00', '屏東縣山地門鄉山地路1號', '屏東霧台之旅', '2021-09-01', '1234-4564-3213-6546', '006', NULL),
('A5', '2021-08-01 00:00:00', '2021-09-01 00:00:00', '台中市后里區1號', '台中后里之旅', '2021-10-01', '1234-4564-3213-6546', '006', NULL);

INSERT INTO `running_group` (`running_ID`, `group_name`, `kilometers`, `maximum_number`, `start_time`, `end_time`, `qrcode`, `amount`, `place`, `time`) VALUES
('A1', '休閒組', 5, 500, '2021-07-01 07:00:00', '2021-07-01 09:00:00', 'dsad456', 1500, '管院門口', '2021-07-01 06:30:00'),
('A1', '挑戰組', 10, 500, '2021-07-01 06:30:00', '2021-07-01 09:00:00', 'ereg6521', 2000, '管院門口', '2021-07-01 06:00:00');

INSERT INTO `member` (`member_ID`, `id_card`, `name`, `phone`, `email`, `birthday`, `password`, `address`, `contact_name`, `contact_phone`, `relation`, `file_no`) VALUES
('M000001', 'A221234567', '會員一', '0912345678', '123@gmail.com', '2000-07-01', NULL, '台北市', '會依爸', '0975321854', '父女', NULL),
('M000002', 'B121234567', '會員二', '0978945612', '456@gmail.com', '1998-03-18', NULL, '新竹縣', '會二爸', '0975321877', '父子', NULL),
('M000003', 'C120123456', '會員三', '0900000000', '789@gmail.com', '1955-07-05', NULL, '嘉義市', '會三媽', '0975321888', '母子', NULL);

INSERT INTO `registration` (`registration_ID`, `member_ID`, `time`, `running_ID`, `group_name`, `qrcode`) VALUES
('A1M000001', 'M000001', '2021-07-05 15:13:00', 'A1', '休閒組', 'ASDW-SAD-9'),
('A1M000002', 'M000002', '2021-07-05 17:18:01', 'A1', '挑戰組', 'SDFE-TY-56'),
('A1M000003', 'M000003', '2021-07-05 11:10:01', 'A1', '休閒駔', 'DFMG-TT-16');

INSERT INTO `transaction` (`registration_ID`, `member_ID`, `time`, `bank_code`, `remittance_account`) VALUES
('A1M000001', 'M000001', '2021-07-31 10:53:10', '013', '000112346123'),
('A1M000002', 'M000002', '2021-07-05 17:13:01', '013', '000112346789'),
('A1M000003', 'M000003', '2021-07-10 10:53:20', '013', '000112346456');

INSERT INTO `beacon` (`beacon_ID`, `type`, `is_available`) VALUES
('EWR-ERQ-45', 'A233', 0),
('SFH-FGH-24', 'V140', 0),
('SFH-FGH-40', 'A4785', 0);

INSERT INTO `beacon_placement` (`beacon_ID`, `type`, `longitude`, `latitude`, `is_available`) VALUES
('EWR-ERQ-45', '起點', '12.45', '159.8', 1),
('SFH-FGH-24', '補給站', '14.87', '87.05', 0),
('SFH-FGH-40', '終點', '102.51', '10.5', 1);

INSERT INTO `location` (`member_ID`, `running_ID`, `pass_time`, `pass_longitude`, `pass_latitude`, `beacon_ID`) VALUES
('M000001', 'A1', '2020-05-01 09:00:00', 123.12, 456.45, 'EWR-ERQ-45'),
('M000001', 'A1', '2020-05-01 09:10:00', 123.12, 456.45, 'SFH-FGH-40');

INSERT INTO `passing_point` (`pass_ID`, `pass_name`, `longitude`, `latitude`) VALUES
('L1', '暨大大草原', '12.45', '159.8'),
('L2', '暨大管院', '102.51', '10.5'),
('L3', '暨大學活', '14.87', '87.05');

INSERT INTO `ambulance_details` (`liciense_plate`, `arrivetime`, `hospital_name`, `hospital_phone`, `pass_ID`) VALUES
('ABV-1234', '2020-05-01 14:00:00', '埔里榮民醫院', '0912345687', 'L3'),
('ABV-1234', '2020-05-02 13:15:00', '埔里基督教醫院', '0912345678', 'L2'),
('ABV-3214', '2020-05-01 13:15:00', '埔里基督教醫院', '0912345678', 'L1');

INSERT INTO `route` (`pass_ID`, `running_ID`, `group_name`, `priority`) VALUES
('L1', 'A1', '休閒組', 1),
('L2', 'A1', '休閒組', 2),
('L3', 'A1', '菁英組', 1);

INSERT INTO `staff` (`staff_ID`, `name`, `password`, `id_card`, `phone`, `email`, `lineid`, `birthday`, `address`, `contact_name`, `contact_phone`, `relation`, `file_no`) VALUES
('S000001', '袁宮依', '', 'T123456789', '0912123123', '123@gmail.com', 'E123', '1999-01-01', '埔里鎮中山路1號', '宮依爸', '0932321321', '父女', NULL),
('S000002', '袁宮二', '', 'T123456987', '0945456456', '456@gmail.com', 'E456', '1999-01-02', '埔里鎮中山路2號', '宮二爸', '0965654654', '父子', NULL),
('S000003', '袁宮參', '', 'T123456987', '0978789789', '789@gmail.com', 'E789', '1999-01-03', '埔里鎮中山路ˇ3號', '宮參媽', '0932321321', '母女', NULL);

INSERT INTO `work_content` (`work_ID`,`running_ID`, `place`, `content`) VALUES
('1','A1', '暨南大學學生活動中心', '伺機而動'),
('2','A1', '暨南大學學生活動中心', '負責記錄已報到會員名單'),
('3','A1', '日月潭伊達邵', '伺機而動');

INSERT INTO `work_group` (`workgroup_ID`, `running_ID`, `name`, `leader`, `line`, `assembletime`, `assembleplace`,`maximum_number`) VALUES
(1, 'A1', '機動組', '袁宮依', 'http://line.me/ti/g/W14ABM_xo_', '2020-05-01 09:00:00', '暨南大學學生活動中心',100),
(2, 'A1', '報到組', '袁宮二', 'http://line.me/ti/v/W14ABM_vo_', '2020-05-01 09:00:00', '暨南大學大草坪',100),
(3, 'A2', '機動組', '袁宮依', 'http://line.me/ti/g/W14JIS_vo_', '2020-06-05 09:00:00', '日月潭伊達邵',100);

INSERT INTO `staff_participation` (`workgroup_ID`, `staff_ID`, `status`) VALUES
(1, 'S000001', 1),
(2, 'S000002', 0),
(3, 'S000003', 0);

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