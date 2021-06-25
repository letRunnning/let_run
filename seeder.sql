use yda;

insert into youth select null, 'N123456789', 'GJim Tsai', '1994-03-21',
    (select no from menu where form_name = 'youth' and column_name = 'gender' limit 1),
    '0900000000', 'xx市x區xx路x號', 'xx市x區xx路x號',
    (select no from menu where form_name = 'youth' and column_name = 'junior_school_condition' limit 1),
    (select no from menu where form_name = 'youth' and column_name = 'senior_school_condition' limit 1),
    '居仁國中/3/普通科', '中興高中/3/普通科', 'Bear Tsai', 'parant', '0900000000', 'xx市x區xx路x號', 'xx市x區xx路x號';
insert into youth select null, 'N234567891', 'Andy Tsai', '1994-01-21',
    (select no from menu where form_name = 'youth' and column_name = 'gender' limit 1),
    '0900000000', 'xx市x區xx路x號', 'xx市x區xx路x號',
    (select no from menu where form_name = 'youth' and column_name = 'junior_school_condition' limit 1),
    (select no from menu where form_name = 'youth' and column_name = 'senior_school_condition' limit 1),
    '居仁國中/3/普通科', '中興高中/3/普通科', 'Bear Tsai', 'parant', '0900000000', 'xx市x區xx路x號', 'xx市x區xx路x號';
insert into youth select null, 'N345678912', 'Raymond Tsai', '1994-02-21',
    (select no from menu where form_name = 'youth' and column_name = 'gender' limit 1),
    '0900000000', 'xx市x區xx路x號', 'xx市x區xx路x號',
    (select no from menu where form_name = 'youth' and column_name = 'junior_school_condition' limit 1),
    (select no from menu where form_name = 'youth' and column_name = 'senior_school_condition' limit 1),
    '居仁國中/3/普通科', '中興高中/3/普通科', 'Bear Tsai', 'parant', '0900000000', 'xx市x區xx路x號', 'xx市x區xx路x號';

insert into youth(identification, name, birth) values('N456789123', 'Jody Lu', '1994-02-21');
insert into youth(identification, name, birth) values('N567891234', 'Megan Tsai', '1994-02-21');
insert into youth(identification, name, birth) values('N678912345', 'Jason Tsai', '1994-02-21');

insert into yda values(null, '0975131609');
insert into users values('yda', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
    '青年署專員', 1, 1, null, null, null, null, 1);

insert into users values('countymanager', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
    '縣市主管', 1, null, 1, null, null, null, 1);
insert into users values('countycontractor', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
    '縣市承辦人', 0, null, 1, null, null, null, 1);

insert into project select null, '109年度計畫', 1, (select no from menu where column_name = 'execute_mode' limit 1), 
    (select no from menu where column_name = 'execute_way' limit 1), 10, 60, 100, 10, '2020-08-06';
insert into organization values(null, 1, '社福機構', '0422600000', 'xx市x區xx路x號');
insert into county_delegate_organization values(null, 1, 1, 1, 1);
insert into users values('organizationmanager', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '機構主管', 1, null, 1, 1, null, null, 1);
insert into users values('organizationcontractor', '  $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '機構承辦人', 0, null, 1, 1, null, null, 1);

insert into counselor select null, 1, 'N123456700', 
    (select no from menu where form_name = 'counselor' and column_name = 'gender' limit 1), 
    '1994-03-21', '社專協會', '無', '0900000000', 'andyzero75@gmail.com', 
    'xx市x區xx路x號', 'xx市x區xx路x號', '2012-07-01', '2016-07-01', '暨南大學', 
    '資管系', '2018-07-01', '2020-07-01', '暨南大學', '工程師', '2020-08-01', 
    (select no from menu where form_name = 'counselor' and column_name = 'qualification' limit 1);
insert into users values('counselor', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '輔導員', 0, null, 1, 1, 1, null, 1);

INSERT INTO `users` (`id`, `password`, `name`, `manager`, `yda`, `county`, `organization`, `counselor`, `youth`, `usable`, `email`, `line`) VALUES 
('yda', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '青年署專員', '1', '1', NULL, NULL, NULL, NULL, '1', NULL, NULL), 
('countymanager', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '縣市主管', '1', NULL, '1', NULL, NULL, NULL, '1', NULL, NULL),
('countycontractor', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '縣市承辦人', '0', NULL, '1', NULL, NULL, NULL, '1', NULL, NULL), 
('organizationmanager', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '機構主管', '1', NULL, '1', '1', NULL, NULL, '1', NULL, NULL), 
('organizationcontractor', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '機構承辦人', '0', NULL, '1', '1', NULL, NULL, '1', NULL, NULL), 
('counselor', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '輔導員', '0', NULL, '1', '1', '1', NULL, '1', NULL, NULL);

UPDATE project set name = '109年彰化縣青少年生涯探索號' where no = '1';
UPDATE project set name = '109年臺北市青少年生涯探索號' where no = '2';
UPDATE project set name = '109年新北市青少年生涯探索號' where no = '3';
UPDATE project set name = '109年桃園市青少年生涯探索號' where no = '4';
UPDATE project set name = '109年新竹市青少年生涯探索號' where no = '5';
UPDATE project set name = '109年新竹縣青少年生涯探索號' where no = '6';
UPDATE project set name = '109年苗栗縣青少年生涯探索號' where no = '7';
UPDATE project set name = '109年臺中市青少年生涯探索號' where no = '8';
UPDATE project set name = '109年南投縣青少年生涯探索號' where no = '9';
UPDATE project set name = '109年雲林縣青少年生涯探索號' where no = '10';
UPDATE project set name = '109年嘉義縣青少年生涯探索號' where no = '11';
UPDATE project set name = '109年臺南市青少年生涯探索號' where no = '12';
UPDATE project set name = '109年高雄市青少年生涯探索號' where no = '13';
UPDATE project set name = '109年屏東縣青少年生涯探索號' where no = '14';
UPDATE project set name = '109年臺東縣青少年生涯探索號' where no = '15';
UPDATE project set name = '109年宜蘭縣青少年生涯探索號' where no = '16';
UPDATE project set name = '109年花蓮縣青少年生涯探索號' where no = '17';
UPDATE project set name = '109年嘉義市青少年生涯探索號' where no = '18';
UPDATE project set name = '109年澎湖縣青少年生涯探索號' where no = '19';
UPDATE project set name = '109年連江縣青少年生涯探索號' where no = '20';
UPDATE project set name = '109年金門縣青少年生涯探索號' where no = '21';
UPDATE project set name = '109年基隆市青少年生涯探索號' where no = '22';

ALTER TABLE `users` ADD `office_phone` VARCHAR(30) NULL COMMENT '辦公室聯絡電話' AFTER `line`;

insert into menu (form_name, column_name, content) values('counselor', 'qualification', '具社會工作師證照');
insert into menu (form_name, column_name, content) values('counselor', 'qualification', '具心理師證照');
insert into menu (form_name, column_name, content) values('counselor', 'qualification', '具就業服務乙級技術士證照');
insert into menu (form_name, column_name, content) values('counselor', 'qualification', '具政府機關核發之就業服務專業人員證書');

-- password 000000 : $2y$10$LaQJhjZaK/ncz2trvP403OWZXCybQ9OouE/YlJMyJgOOFBBKohW5e $2y$10$gwpgz1vrNMnxf80fyBkACuCqPhfjEOHqemUqhBgrv5jTjinn/yyoi
-- 桃園承辦 :$2y$10$Gtyq6stUbAgRZ7DO4X/InOQkpLYDvITTBmsLI2W4dB1mg57isK1G6

-- 高雄主管 : $10$LaQJhjZaK/ncz2trvP403OWZXCybQ9OouE/YlJMyJgOOFBBKohW5e
-- 高雄承辦 : $2y$10$QjDPhJES0lHfKTiZk.wsLOLKfRgtbJNO9x.ncw3WPXTf/xYBAXFN2
-- 宜蘭承辦 : $2y$10$4KEuKVkq7k9LGR2AOshmR..OsqeV508pqyi2bm.baGrDz1FjrboJq
-- 連江輔導員 : $2y$10$jpndDfhiQqxkn6FRkf6bXuujJvi.0PkCJv6B/ivQVwyhR6fs2wymS

ALTER TABLE `counselor` CHANGE `education_start_date` `education_start_date` VARCHAR(200) NULL DEFAULT NULL COMMENT '學歷-起', 
CHANGE `education_complete_date` `education_complete_date` VARCHAR(200) NULL DEFAULT NULL COMMENT '學歷-迄', 
CHANGE `education_school` `education_school` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '學校名稱', 
CHANGE `education_department` `education_department` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '科系', 
CHANGE `work_start_date` `work_start_date` VARCHAR(200) NULL DEFAULT NULL COMMENT '經歷-起', 
CHANGE `work_complete_date` `work_complete_date` VARCHAR(200) NULL DEFAULT NULL COMMENT '經歷-迄', 
CHANGE `work_department` `work_department` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '服務單位名稱', 
CHANGE `work_position` `work_position` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '擔任職務';

ALTER TABLE `counselor` ADD `highest_education` VARCHAR(10) NULL COMMENT '最高學歷' AFTER `education_department`, 
ADD `affiliated_department` VARCHAR(10) NULL COMMENT '隸屬部門' AFTER `highest_education`;

ALTER TABLE `course_attendance` ADD `is_insurance` TINYINT NULL COMMENT '是否保險' AFTER `duration`, 
ADD `insurance_start_date` DATE NULL COMMENT '保險開始日期' AFTER `is_insurance`, 
ADD `insurance_end_date` DATE NULL COMMENT '保險結束日期' AFTER `insurance_start_date`;

ALTER TABLE `work_attendance` ADD `is_insurance` TINYINT NULL COMMENT '是否保險' AFTER `duration`, 
ADD `insurance_start_date` DATE NULL COMMENT '保險開始日期' AFTER `is_insurance`, 
ADD `insurance_end_date` DATE NULL COMMENT '保險結束日期' AFTER `insurance_start_date`;

ALTER TABLE `case_assessment` ADD `serving_source` TINYINT NULL COMMENT '其他民間單位' AFTER `event_description`;

ALTER TABLE `intake` ADD `is_want` INT NULL COMMENT '是否願意加入本計畫' AFTER `major_demand_other`;

ALTER TABLE `meeting` ADD `participants` INT NULL COMMENT '參與人次' AFTER `meeting_type`;



ALTER TABLE `counseling_member_count_report` CHANGE `course_note` `course_note` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '簡述生涯探索課程', 
CHANGE `force_majeure_note` `force_majeure_note` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '簡述不可抗力及其他人數之原因', 
CHANGE `work_trainning_note` `work_trainning_note` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '簡述參加職訓人數之單位及課程', 
CHANGE `work_note` `work_note` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '簡述本月工作歷程',
 CHANGE `other_note` `other_note` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '其他事項', 
 CHANGE `insure_note` `insure_note` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '投保事項';

 ALTER TABLE `course_attendance` ADD `note` TEXT NULL COMMENT '備註' AFTER `duration`;
 ALTER TABLE `work_attendance` ADD `note` TEXT NULL COMMENT '備註' AFTER `duration`;
 ALTER TABLE `course_attendance` ADD `organization` MEDIUMINT NULL COMMENT '機構' AFTER `insurance_end_date`;
 ALTER TABLE `counseling_member_count_report` ADD `next_year_survry_case_member` BIGINT NULL COMMENT '下學年度動向調查結果輔導人數' AFTER `now_year_survry_case_member`, 
 ADD `high_school_survry_case_member` BIGINT NULL COMMENT '高中已錄取未註冊結果輔導人數' AFTER `next_year_survry_case_member`;

 ALTER TABLE `counseling_member_count_report` CHANGE `month_counseling_hour` `month_counseling_hour` FLOAT(20) UNSIGNED NULL DEFAULT NULL COMMENT '本月輔導會談小時', 
 CHANGE `month_course_hour` `month_course_hour` FLOAT(20) UNSIGNED NULL DEFAULT NULL COMMENT '本月生涯探索課程或活動小時', 
 CHANGE `month_working_hour` `month_working_hour` FLOAT(20) UNSIGNED NULL DEFAULT NULL COMMENT '本月工作體驗小時';

 ALTER TABLE `course_attendance` CHANGE `duration` `duration` FLOAT(9) NOT NULL COMMENT '歷時';
 ALTER TABLE `work_attendance` CHANGE `duration` `duration` FLOAT(9) NOT NULL COMMENT '歷時';

 ALTER TABLE `meeting_count_report` ADD `time_note` TEXT NULL AFTER `no`;
 ALTER TABLE `meeting_count_report` CHANGE `meeting_count_note` `meeting_count_note` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '備註';
 ALTER TABLE `county` ADD `priority` TINYINT NULL COMMENT '排序' AFTER `orgnizer`;

 ALTER TABLE `project` ADD `note` TEXT NULL COMMENT '備註' AFTER `funding`;
 ALTER TABLE `county` ADD `update_project` TINYINT NULL COMMENT '是否可修改計畫案' AFTER `priority`;




ALTER TABLE `counseling_member_count_report` ADD `report_file` TEXT NULL COMMENT '報表電子檔' AFTER `date`;
ALTER TABLE `counseling_identity_count_report` ADD `report_file` TEXT NULL COMMENT '報表電子檔' AFTER `date`;
ALTER TABLE `meeting_count_report` ADD `report_file` TEXT NULL COMMENT '報表電子檔' AFTER `date`;
ALTER TABLE `counselor_manpower_report` ADD `report_file` TEXT NULL COMMENT '報表電子檔' AFTER `date`;
ALTER TABLE `now_years_trend_survey_count_report` ADD `report_file` TEXT NULL COMMENT '報表電子檔' AFTER `date`;
ALTER TABLE `old_case_trend_survey_count_report` ADD `report_file` TEXT NULL COMMENT '報表電子檔' AFTER `date`;
ALTER TABLE `one_years_trend_survey_count_report` ADD `report_file` TEXT NULL COMMENT '報表電子檔' AFTER `date`;
ALTER TABLE `two_years_trend_survey_count_report` ADD `report_file` TEXT NULL COMMENT '報表電子檔' AFTER `date`;

ALTER TABLE `youth` ADD `is_end` TINYINT NULL COMMENT '是否結案' AFTER `year`;

ALTER TABLE `seasonal_review` CHANGE `date` `date` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '追蹤日期';



ALTER TABLE `company` ADD `is_view` TINYINT NULL COMMENT '是否刪除' AFTER `is_open`;
ALTER TABLE `course` ADD `is_view` TINYINT NULL COMMENT '是否刪除' AFTER `year`;
ALTER TABLE `course_reference` ADD `is_view` TINYINT NULL COMMENT '是否刪除' AFTER `content`;
ALTER TABLE `expert_list` ADD `is_view` TINYINT NULL COMMENT '是否刪除' AFTER `is_open`;
ALTER TABLE `course_attendance` ADD `is_view` TINYINT NULL COMMENT '是否刪除' AFTER `organization`;
ALTER TABLE `group_counseling` ADD `is_view` TINYINT NULL COMMENT '是否刪除' AFTER `year`;
ALTER TABLE `individual_counseling` ADD `is_view` TINYINT NULL COMMENT '是否刪除' AFTER `future_plan`;
ALTER TABLE `insurance` ADD `is_view` TINYINT NULL COMMENT '是否刪除' AFTER `note`;
ALTER TABLE `meeting` ADD `is_view` TINYINT NULL COMMENT '是否刪除' AFTER `year`;
ALTER TABLE `member` ADD `is_view` TINYINT NULL COMMENT '是否刪除' AFTER `year`;
ALTER TABLE `month_review` ADD `is_view` TINYINT NULL COMMENT '是否刪除' AFTER `way_other`;
ALTER TABLE `seasonal_review` ADD `is_view` TINYINT NULL COMMENT '是否刪除' AFTER `trend_description`;
ALTER TABLE `work_attendance` ADD `is_view` TINYINT NULL COMMENT '是否刪除' AFTER `insurance_end_date`;
ALTER TABLE `work_experience` ADD `is_view` TINYINT NULL COMMENT '是否刪除' AFTER `year`;

update `company` set  `is_view` = 1;
update `course` set  `is_view` = 1;
update `course_reference` set  `is_view` = 1;
update `expert_list` set  `is_view` = 1;
update `course_attendance` set  `is_view` = 1;
update `group_counseling` set  `is_view` = 1;
update `individual_counseling` set  `is_view` = 1;
update `insurance` set  `is_view` = 1;
update `meeting` set  `is_view` = 1;
update `member` set  `is_view` = 1;
update `month_review` set  `is_view` = 1;
update `seasonal_review` set  `is_view` = 1;
update `work_attendance` set  `is_view` = 1;
update `work_experience` set  `is_view` = 1;

ALTER TABLE `counseling_member_count_report` ADD `school_youth` BIGINT NULL COMMENT '已就學青少年' AFTER `report_file`, 
ADD `work_youth` BIGINT NULL COMMENT '已就業青少年' AFTER `school_youth`, 
ADD `vocational_training_youth` BIGINT NULL COMMENT '參加職訓青少年' AFTER `work_youth`, 
ADD `other_youth` BIGINT NULL COMMENT '其他青少年' AFTER `vocational_training_youth`, 
ADD `no_plan_youth` BIGINT NULL COMMENT '尚無規畫青少年' AFTER `other_youth`, 
ADD `force_majeure_youth` BIGINT NULL COMMENT '不可抗力因素青少年' AFTER `no_plan_youth`;

update `counseling_member_count_report` set `school_youth` = 0 and `work_youth` = 0 and `vocational_training_youth` = 0 and `other_youth`=0 and `no_plan_youth` = 0 and `force_majeure_youth` = 0;

ALTER TABLE `project` ADD `group_counseling_hour` MEDIUMINT NULL COMMENT '團體輔導小時' AFTER `working_hour`, 
ADD `counseling_youth` MEDIUMINT NULL COMMENT '關懷人數' AFTER `group_counseling_hour`, 
ADD `track_description` VARCHAR(255) NULL COMMENT '後續追蹤敘述' AFTER `counseling_youth`;

UPDATE member SET youth = '1960' WHERE youth = '7864';
UPDATE youth SET county = 23 WHERE NO = '7864';
UPDATE intake SET youth = '1960' WHERE youth = '7864';

UPDATE menu SET content = '家長推薦' WHERE NO = 49;
UPDATE menu SET content = '學校推薦' WHERE NO = 50;
UPDATE menu SET content = '社會團體推薦' WHERE NO = 51;
UPDATE menu SET content = '安置機構推薦' WHERE NO = 52;
UPDATE menu SET content = '警政司法機構推薦' WHERE NO = 53;
UPDATE menu SET content = '學員或舊生推薦' WHERE NO = 54;
UPDATE menu SET content = '法務部轉介(少年矯正機關)' WHERE NO = 55;
UPDATE menu SET content = '其他(請說明)' WHERE NO = 56;
INSERT INTO `menu` (`no`, `form_name`, `column_name`, `content`, `priority`) VALUES (NULL, 'case_assessment', 'source', '高中已錄取未註冊', NULL);
ALTER TABLE `review` CHANGE `reason` `reason` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '原因';

ALTER TABLE `messager` ADD `is_email` TINYINT NULL DEFAULT NULL COMMENT '是否寄信通知' AFTER `is_view`;
UPDATE menu SET content = '青年發展署' WHERE NO = 209;
UPDATE menu SET content = '承辦縣市' WHERE NO = 210;
UPDATE menu SET content = '執行機關' WHERE NO = 211;
UPDATE menu SET content = '輔導員' WHERE NO = 212;

update menu set content = '參加職訓(說明)' where no = 173;

update counseling_member_count_report set new_case_member = , old_case_member = where project = and month =1;

INSERT INTO `menu` (`no`, `form_name`, `column_name`, `content`, `priority`) VALUES 
(NULL, 'seasonal_review', 'trend', '自學', '18'), 
(NULL, 'seasonal_review', 'trend', '成年', '19');

ALTER TABLE `users` 
ADD `login_success_time` TIMESTAMP NULL AFTER `office_phone`, 
ADD `login_fail_time` TIMESTAMP NULL AFTER `login_success_time`, 
ADD `update_password_time` TIMESTAMP NULL AFTER `login_fail_time`, 
ADD `last_password_one` VARCHAR(255) NULL AFTER `update_password_time`, 
ADD `last_password_two` VARCHAR(255) NULL AFTER `last_password_one`, 
ADD `last_password_three` VARCHAR(255) NULL AFTER `last_password_two`;

update users set update_password_time = '2021-03-17 14:24:20';

ALTER TABLE `users_temp` 
ADD `login_success_time` TIMESTAMP NULL AFTER `office_phone`, 
ADD `login_fail_time` TIMESTAMP NULL AFTER `login_success_time`, 
ADD `update_password_time` TIMESTAMP NULL AFTER `login_fail_time`, 
ADD `last_password_one` VARCHAR(255) NULL AFTER `update_password_time`, 
ADD `last_password_two` VARCHAR(255) NULL AFTER `last_password_one`, 
ADD `last_password_three` VARCHAR(255) NULL AFTER `last_password_two`;

ALTER TABLE `now_years_trend_survey_count_report` 
ADD `self_study` BIGINT NOT NULL COMMENT '自學' AFTER `report_file`, 
ADD `adult` BIGINT NOT NULL COMMENT '成年' AFTER `self_study`, 
ADD `transfer_office` BIGINT NOT NULL COMMENT '轉銜警政司法' AFTER `adult`;

ALTER TABLE `old_case_trend_survey_count_report` 
ADD `self_study` BIGINT NOT NULL COMMENT '自學' AFTER `report_file`, 
ADD `adult` BIGINT NOT NULL COMMENT '成年' AFTER `self_study`, 
ADD `transfer_office` BIGINT NOT NULL COMMENT '轉銜警政司法' AFTER `adult`;

ALTER TABLE `one_years_trend_survey_count_report` 
ADD `self_study` BIGINT NOT NULL COMMENT '自學' AFTER `report_file`, 
ADD `adult` BIGINT NOT NULL COMMENT '成年' AFTER `self_study`, 
ADD `transfer_office` BIGINT NOT NULL COMMENT '轉銜警政司法' AFTER `adult`;

ALTER TABLE `two_years_trend_survey_count_report` 
ADD `self_study` BIGINT NOT NULL COMMENT '自學' AFTER `report_file`, 
ADD `adult` BIGINT NOT NULL COMMENT '成年' AFTER `self_study`, 
ADD `transfer_office` BIGINT NOT NULL COMMENT '轉銜警政司法' AFTER `adult`;

delete from review_log where report_name = 'two_years_trend_survey_count_report';
delete from review_process where report_name = 'two_years_trend_survey_count_report';

delete from review_log where report_name = 'one_years_trend_survey_count_report';
delete from review_process where report_name = 'one_years_trend_survey_count_report';

delete from review_log where report_name = 'now_years_trend_survey_count_report';
delete from review_process where report_name = 'now_years_trend_survey_count_report';

delete from review_log where report_name = 'old_case_trend_survey_count_report';
delete from review_process where report_name = 'old_case_trend_survey_count_report';

select * from review_log where report_name = 'high_school_trend_survey_count_report';

ALTER TABLE `insurance` ADD `type` VARCHAR(20) NULL COMMENT '類型' AFTER `note`;
INSERT INTO `menu` (`no`, `form_name`, `column_name`, `content`, `priority`) VALUES 
(NULL, 'insurance', 'type', '新台幣300萬元意外險和5萬元醫療險', '1'), 
(NULL, 'insurance', 'type', '新台幣300萬元意外險和5萬元醫療險+訓字保險', '1');