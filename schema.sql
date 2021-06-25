create database yda;

use yda;

create table menu (
    no smallint unsigned not null auto_increment primary key comment '流水號',
    form_name varchar(50) comment '表單名稱',
    column_name varchar(50) comment '欄位名稱',
    content varchar(255) comment '選項',
    priority TINYINT NULL COMMENT '排序'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='選單列表';

create table questionnaire (
    no smallint unsigned not null auto_increment primary key comment '流水號',
    name varchar(50) null comment '問卷名稱',
     year bigint null comment '年度'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='問卷列表';

create table problem (
    no smallint unsigned not null auto_increment primary key comment '流水號',
    questionnaire varchar(50) null comment '問卷no',
    title varchar(50) null comment '大標',
    tag_one varchar(50) null comment 'tag1',
    tag_two varchar(50) null comment 'tag2',
    tag_three varchar(50) null comment 'tag3',
    type varchar(50) null comment '類型',
    content text null comment '內容'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='問卷題目列表';

create table answer (
    no smallint unsigned not null auto_increment primary key comment '流水號',
    user_id varchar(30) null comment '帳號',
    questionnaire varchar(50) null comment '問卷no',
    problem varchar(50) null comment '題目no',
    answer varchar(50) null comment '類型',
    time timestamp null comment '建立時間' 
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='問卷答案列表';

create table review (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    form_name varchar(50) comment '表單名稱',
    form_no varchar(50) comment '表單流水號',
    reviewer_role bigint unsigned null comment '審核者角色代碼',
    reviewer varchar(30) null comment '審核者id',
    status varchar(10) comment '審核狀態',
    reason varchar(100) comment '申請原因',
    note varchar(100) comment '審核備註',
    update_column varchar(30) null comment '要修改的欄位',
    update_value varchar(30) null comment '要修改的值',
    create_time timestamp null comment '建立時間', 
    end_time timestamp null comment '結束時間', 
    county bigint unsigned null comment '縣市'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='審核表單';

insert into menu (form_name, column_name, content) values('review', 'status', '等待審核中');
insert into menu (form_name, column_name, content) values('review', 'status', '審核通過');
insert into menu (form_name, column_name, content) values('review', 'status', '審核拒絕');

create table county_contact (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    county bigint unsigned not null comment '縣市',
    name varchar(50) comment '姓名',
    phone varchar(50) comment '縣市電話',
    orgnizer varchar(50) comment '承辦單位',
    email varchar(50) comment '信箱',
    title varchar(50) comment '職稱'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='縣市聯絡窗口';

create table messager (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    type bigint unsigned not null comment '分類',
    content varchar(200) null comment '內容',
    announcer varchar(50) null comment '發布者',
    receive_group varchar(50) null comment '發布對象',
    create_date date not null comment '創建日期',
    is_view tinyint not null default 1 comment '是否顯示'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='訊息管理';

insert into menu (form_name, column_name, content) values('messager', 'type', '最新消息');
insert into menu (form_name, column_name, content) values('messager', 'type', '新聞發布');
insert into menu (form_name, column_name, content) values('messager', 'type', '徵求人才');
insert into menu (form_name, column_name, content) values('messager', 'type', '開會通知');
insert into menu (form_name, column_name, content) values('messager', 'type', '資料繳交');
insert into menu (form_name, column_name, content) values('messager', 'group', '青年發展署專員');
insert into menu (form_name, column_name, content) values('messager', 'group', '縣市承辦人');
insert into menu (form_name, column_name, content) values('messager', 'group', '機構承辦人');
insert into menu (form_name, column_name, content) values('messager', 'group', '輔導員');

CREATE TABLE counseling_identity_count_report (
  no bigint unsigned not null auto_increment primary key comment '流水號',
  junior_under_graduate_boy bigint UNSIGNED NULL COMMENT '國中未畢業男性',
  junior_under_graduate_girl int(20) UNSIGNED NULL COMMENT '國中未畢業女性',
  sixteen_years_old_not_employed_not_studying_boy bigint UNSIGNED NULL COMMENT '滿16未升學未就業男性',
  sixteen_years_old_not_employed_not_studying_girl bigint UNSIGNED NULL COMMENT '滿16未升學未就業女性',
  junior_graduated_this_year_unemployed_not_studying_boy bigint UNSIGNED NULL COMMENT '國中畢業應屆未升學未就業男性',
  junior_graduated_this_year_unemployed_not_studying_girl bigint UNSIGNED NULL COMMENT '國中畢業應屆未升學未就業女性',
  junior_graduated_not_this_year_unemployed_not_studying_boy bigint UNSIGNED NULL COMMENT '國中畢業非應屆未升學未就業男性',
  junior_graduated_not_this_year_unemployed_not_studying_girl bigint UNSIGNED NULL COMMENT '國中畢業非應屆未升學未就業女性',
  drop_out_from_senior_boy bigint UNSIGNED NULL COMMENT '高中中離男性',
  drop_out_from_senior_girl bigint UNSIGNED NULL COMMENT '高中中離女性',
  month bigint NULL COMMENT '月份',
  year bigint NULL COMMENT '年度',
  project bigint UNSIGNED NOT NULL COMMENT '計劃案',
  is_review tinyint NOT NULL DEFAULT 0 COMMENT '是否審核',
  date date NOT NULL COMMENT '填表日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='輔導對象身分別統計';

CREATE TABLE `meeting_count_report` (
  no bigint unsigned not null auto_increment primary key comment '流水號',
  time_note TEXT NULL,
  planning_holding_meeting_count bigint UNSIGNED NULL COMMENT '預計辦理活動或講座場次',
  actual_holding_meeting_count bigint UNSIGNED DEFAULT NULL COMMENT '實際辦理活動或講座場次',
  planning_involved_people bigint UNSIGNED DEFAULT NULL COMMENT '預計活動或講座參與人次',
  actual_involved_people bigint UNSIGNED DEFAULT NULL COMMENT '實際活動或講座參與人次',
  meeting_count_note text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '備註',
  month bigint NULL COMMENT '月份',
  year bigint NULL COMMENT '年度',
  project bigint UNSIGNED NULL COMMENT '計劃案',
  is_review tinyint NOT NULL DEFAULT 0 COMMENT '是否審核',
  date date NOT NULL COMMENT '填表日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='跨局處會議/預防性講座場次/人數統計';


create table counselor_manpower_report (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    project_counselor bigint null comment '預估輔導員數量',
    really_counselor bigint null comment '實際輔導員數量',
    education_counselor bigint null comment '隸屬教育處',
    counseling_center_counselor bigint null comment '隸屬輔諮中心',
    school_counselor bigint null comment '隸屬學校',
    outsourcing_counselor bigint null comment '隸屬委外單位',
    bachelor_degree bigint null comment '學士',
    master_degree bigint null comment '碩士',
    qualification_one bigint null comment '符合國內公立或教育部立案之私立大專校院或經教育部承認之國外大專校院，教育學、社會(含社工、社福)學、心理學、諮商輔導、勞工關係、人力資源等相關科系畢業者',
    qualification_two bigint null comment '國內公立或教育部立案之私立大專校院或經教育部承認之國外大專校院相當科、系、組、所畢業，領有畢業證書，具備考選部公告社會工作師或心理師應考資格者',
    qualification_three bigint null comment '具社會工作師證照',
    qualification_four bigint null comment '具心理師證照',
    qualification_five bigint null comment '具就業服務乙級技術士證照',
    qualification_six bigint null comment '具政府機關核發之就業服務專業人員證書',
    note text null comment '備註',
    month bigint null comment '月份',
    year bigint null comment '年度',
    project bigint unsigned not null comment '計劃案',
    is_review tinyint not null default 0 comment '是否審核',
    date date not null comment '填表日期'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='輔導人力統計表';


create table new_old_case_trend_survey_count_report (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    one bigint null comment '已就業',
    two bigint null comment '已就學',
    three bigint null comment '職業訓練或勞政單位協助',
    four bigint null comment '其他(具輔導成效)',
    five bigint null comment '準備升學',
    six bigint null comment '準備或正在找工作',
    seven bigint null comment '家務勞動',
    eight bigint null comment '健康因素',
    nine bigint null comment '尚無規劃',
    ten bigint null comment '未取得聯繫',
    eleven bigint null comment '其他(尚無輔導成效)',
    twelve bigint null comment '特教生',
    thirteen bigint null comment '移民出國',
    fourteen bigint null comment '警政或司法單位',
    fifteen bigint null comment '服兵役',
    sixteen bigint null comment '成年',
    seventeen bigint null comment '死亡',
    eighteen bigint null comment '總計',
    nineteen bigint null comment '青少年人數',
    note text null comment '備註',
    month bigint null comment '月份',
    year bigint null comment '年度',
    project bigint unsigned not null comment '計劃案',
    is_review tinyint not null default 0 comment '是否審核',
    date date not null comment '填表日期',
    report_file text null comment '報表電子檔'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='新-前一年開案動向調查追蹤';

create table new_two_years_trend_survey_count_report (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    one bigint null comment '已就業',
    two bigint null comment '已就學',
    three bigint null comment '職業訓練或勞政單位協助',
    four bigint null comment '其他(具輔導成效)',
    five bigint null comment '準備升學',
    six bigint null comment '準備或正在找工作',
    seven bigint null comment '家務勞動',
    eight bigint null comment '健康因素',
    nine bigint null comment '尚無規劃',
    ten bigint null comment '未取得聯繫',
    eleven bigint null comment '其他(尚無輔導成效)',
    twelve bigint null comment '特教生',
    thirteen bigint null comment '移民出國',
    fourteen bigint null comment '警政或司法單位',
    fifteen bigint null comment '服兵役',
    sixteen bigint null comment '成年',
    seventeen bigint null comment '死亡',
    eighteen bigint null comment '總計',
    nineteen bigint null comment '青少年人數',
    note text null comment '備註',
    month bigint null comment '月份',
    year bigint null comment '年度',
    project bigint unsigned not null comment '計劃案',
    is_review tinyint not null default 0 comment '是否審核',
    date date not null comment '填表日期',
    report_file text null comment '報表電子檔'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='新-兩年前動向調查追蹤';

create table new_one_years_trend_survey_count_report (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    one bigint null comment '已就業',
    two bigint null comment '已就學',
    three bigint null comment '職業訓練或勞政單位協助',
    four bigint null comment '其他(具輔導成效)',
    five bigint null comment '準備升學',
    six bigint null comment '準備或正在找工作',
    seven bigint null comment '家務勞動',
    eight bigint null comment '健康因素',
    nine bigint null comment '尚無規劃',
    ten bigint null comment '未取得聯繫',
    eleven bigint null comment '其他(尚無輔導成效)',
    twelve bigint null comment '特教生',
    thirteen bigint null comment '移民出國',
    fourteen bigint null comment '警政或司法單位',
    fifteen bigint null comment '服兵役',
    sixteen bigint null comment '成年',
    seventeen bigint null comment '死亡',
    eighteen bigint null comment '總計',
    nineteen bigint null comment '青少年人數',
    note text null comment '備註',
    month bigint null comment '月份',
    year bigint null comment '年度',
    project bigint unsigned not null comment '計劃案',
    is_review tinyint not null default 0 comment '是否審核',
    date date not null comment '填表日期',
    report_file text null comment '報表電子檔'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='新-一年前動向調查追蹤';

create table new_now_years_trend_survey_count_report (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    one bigint null comment '已就業',
    two bigint null comment '已就學',
    three bigint null comment '職業訓練或勞政單位協助',
    four bigint null comment '其他(具輔導成效)',
    five bigint null comment '準備升學',
    six bigint null comment '準備或正在找工作',
    seven bigint null comment '家務勞動',
    eight bigint null comment '健康因素',
    nine bigint null comment '尚無規劃',
    ten bigint null comment '未取得聯繫',
    eleven bigint null comment '其他(尚無輔導成效)',
    twelve bigint null comment '特教生',
    thirteen bigint null comment '移民出國',
    fourteen bigint null comment '警政或司法單位',
    fifteen bigint null comment '服兵役',
    sixteen bigint null comment '成年',
    seventeen bigint null comment '死亡',
    eighteen bigint null comment '總計',
    nineteen bigint null comment '青少年人數',
    note text null comment '備註',
    month bigint null comment '月份',
    year bigint null comment '年度',
    project bigint unsigned not null comment '計劃案',
    is_review tinyint not null default 0 comment '是否審核',
    date date not null comment '填表日期',
    report_file text null comment '報表電子檔'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='新-今年前動向調查追蹤';

create table new_high_school_trend_survey_count_report (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    one bigint null comment '已就業',
    two bigint null comment '已就學',
    three bigint null comment '職業訓練或勞政單位協助',
    four bigint null comment '其他(具輔導成效)',
    five bigint null comment '準備升學',
    six bigint null comment '準備或正在找工作',
    seven bigint null comment '家務勞動',
    eight bigint null comment '健康因素',
    nine bigint null comment '尚無規劃',
    ten bigint null comment '未取得聯繫',
    eleven bigint null comment '其他(尚無輔導成效)',
    twelve bigint null comment '特教生',
    thirteen bigint null comment '移民出國',
    fourteen bigint null comment '警政或司法單位',
    fifteen bigint null comment '服兵役',
    sixteen bigint null comment '成年',
    seventeen bigint null comment '死亡',
    eighteen bigint null comment '總計',
    nineteen bigint null comment '青少年人數',
    note text null comment '備註',
    month bigint null comment '月份',
    year bigint null comment '年度',
    project bigint unsigned not null comment '計劃案',
    is_review tinyint not null default 0 comment '是否審核',
    date date not null comment '填表日期',
    report_file text null comment '報表電子檔'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='新-高中動向調查追蹤';


create table two_years_trend_survey_count_report (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    already_attending_school bigint null comment '已就學',
    already_working bigint null comment '已就業',
    prepare_to_school bigint null comment '準備升學',
    prepare_to_work bigint null comment '準備工作',
    no_plan bigint null comment '尚無計畫',
    lost_contact bigint null comment '失聯',
    transfer_labor bigint null comment '轉銜至勞政',
    transfer_other bigint null comment '轉銜至其他',
    in_case bigint null comment '進入本計畫輔導',
    other bigint null comment '其他(不可抗力)',
    military bigint null comment '服兵役/等待服兵役',
    pregnancy bigint null comment '待產/育嬰',
    death bigint null comment '死亡',
    immigration bigint null comment '移民/出國',
    no_assistance bigint null comment '不須協助',
    health bigint null comment '健康因素',
    special_education_student bigint null comment '特教生',
    training bigint null comment '參加職訓',
    family_labor bigint null comment '家務勞動',
    note varchar(200) null comment '備註',
    month bigint null comment '月份',
    year bigint null comment '年度',
    project bigint unsigned not null comment '計劃案',
    is_review tinyint not null default 0 comment '是否審核',
    date date not null comment '填表日期'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='兩年前動向調查追蹤';

create table one_years_trend_survey_count_report (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    already_attending_school bigint null comment '已就學',
    already_working bigint null comment '已就業',
    prepare_to_school bigint null comment '準備升學',
    prepare_to_work bigint null comment '準備工作',
    no_plan bigint null comment '尚無計畫',
    lost_contact bigint null comment '失聯',
    transfer_labor bigint null comment '轉銜至勞政',
    transfer_other bigint null comment '轉銜至其他',
    in_case bigint null comment '進入本計畫輔導',
    other bigint null comment '其他(不可抗力)',
    military bigint null comment '服兵役/等待服兵役',
    pregnancy bigint null comment '待產/育嬰',
    death bigint null comment '死亡',
    immigration bigint null comment '移民/出國',
    no_assistance bigint null comment '不須協助',
    health bigint null comment '健康因素',
    special_education_student bigint null comment '特教生',
    training bigint null comment '參加職訓',
    family_labor bigint null comment '家務勞動',
    note varchar(200) null comment '備註',
    month bigint null comment '月份',
    year bigint null comment '年度',
    project bigint unsigned not null comment '計劃案',
    is_review tinyint not null default 0 comment '是否審核',
    date date not null comment '填表日期'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='一年前動向調查追蹤';

create table now_years_trend_survey_count_report (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    already_attending_school bigint null comment '已就學',
    already_working bigint null comment '已就業',
    prepare_to_school bigint null comment '準備升學',
    prepare_to_work bigint null comment '準備工作',
    no_plan bigint null comment '尚無計畫',
    lost_contact bigint null comment '失聯',
    transfer_labor bigint null comment '轉銜至勞政',
    transfer_other bigint null comment '轉銜至其他',
    in_case bigint null comment '進入本計畫輔導',
    other bigint null comment '其他(不可抗力)',
    military bigint null comment '服兵役/等待服兵役',
    pregnancy bigint null comment '待產/育嬰',
    death bigint null comment '死亡',
    immigration bigint null comment '移民/出國',
    no_assistance bigint null comment '不須協助',
    health bigint null comment '健康因素',
    special_education_student bigint null comment '特教生',
    training bigint null comment '參加職訓',
    family_labor bigint null comment '家務勞動',
    note varchar(200) null comment '備註',
    month bigint null comment '月份',
    year bigint null comment '年度',
    project bigint unsigned not null comment '計劃案',
    is_review tinyint not null default 0 comment '是否審核',
    date date not null comment '填表日期'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='今年前動向調查追蹤';

create table high_school_trend_survey_count_report (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    already_attending_school bigint null comment '已就學',
    already_working bigint null comment '已就業',
    prepare_to_school bigint null comment '準備升學',
    prepare_to_work bigint null comment '準備工作',
    no_plan bigint null comment '尚無計畫',
    lost_contact bigint null comment '失聯',
    transfer_labor bigint null comment '轉銜至勞政',
    transfer_other bigint null comment '轉銜至其他',
    in_case bigint null comment '進入本計畫輔導',
    other bigint null comment '其他(不可抗力)',
    military bigint null comment '服兵役/等待服兵役',
    pregnancy bigint null comment '待產/育嬰',
    death bigint null comment '死亡',
    immigration bigint null comment '移民/出國',
    no_assistance bigint null comment '不須協助',
    health bigint null comment '健康因素',
    special_education_student bigint null comment '特教生',
    training bigint null comment '參加職訓',
    family_labor bigint null comment '家務勞動',
    self_study bigint null comment '自學',
    adult bigint null comment '成年',
    transfer_office bigint null comment '轉銜警政司法',
    note varchar(200) null comment '備註',
    month bigint null comment '月份',
    year bigint null comment '年度',
    project bigint unsigned not null comment '計劃案',
    is_review tinyint not null default 0 comment '是否審核',
    date date not null comment '填表日期'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='高中動向調查追蹤';

create table counseling_member_count_report (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    school_member bigint unsigned comment '已就學人數',
    work_member bigint unsigned comment '已就業人數',
    vocational_training_member bigint unsigned comment '參加職訓人數',
    other_member bigint unsigned comment '其他人數',
    no_plan_member bigint unsigned comment '尚無規劃人數',
    force_majeure_member bigint unsigned comment '不可抗力因素人數',
    counselor_note varchar(200) null comment '輔導員備註',
    new_case_member bigint unsigned comment '本年度新開案個案人數',
    old_case_member bigint unsigned comment '前一年度持續輔導人數',
    two_year_survry_case_member bigint unsigned comment '兩年前學年度動向調查結果輔導人數',
    one_year_survry_case_member bigint unsigned comment '一年前學年度動向調查結果輔導人數',
    now_year_survry_case_member bigint unsigned comment '本年學年度動向調查結果輔導人數',
    month_counseling_hour float unsigned comment '本月輔導會談小時',
    month_course_hour float unsigned comment '本月生涯探索課程或活動小時',
    month_working_hour float unsigned comment '本月工作體驗小時',
    course_note varchar(200) null comment '簡述生涯探索課程',
    force_majeure_note varchar(200) null comment '簡述不可抗力及其他人數之原因',
    work_trainning_note varchar(200) null comment '簡述參加職訓人數之單位及課程',
    work_note varchar(200) null comment '簡述本月工作歷程',
    funding_execute varchar(10) null comment '經費執行率(已執行金額/總經費金額)',
    other_note varchar(200) null comment '其他事項',
    insure_note varchar(200) null comment '投保事項',
    month bigint null comment '月份',
    year bigint null comment '年度',
    project bigint unsigned not null comment '計劃案',
    is_review tinyint not null default 0 comment '是否審核',
    date date not null comment '填表日期'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='輔導人數統計表';

create table month_member_temp_counseling (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    member bigint unsigned not null comment 'memberNo',
    trend varchar(10) comment '動向(單選)',
    trend_description varchar(30) comment '動向-說明',
    month bigint null comment '月份',
    year bigint null comment '年度',
    county tinyint unsigned comment '縣市編號'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='每月學園輔導成效概況表';

create table users (
    id varchar(30) primary key comment '帳號',
    password varchar(255) not null comment '密碼',
    name varchar(50) comment '姓名',
    manager tinyint not null default 0 comment '是否為主管',
    yda tinyint unsigned comment '青年署專員編號',
    county tinyint unsigned comment '縣市編號',
    organization mediumint unsigned comment '機構編號',
    counselor mediumint unsigned comment '輔導員編號',
    youth bigint unsigned comment '青少年',
    usable tinyint not null default 1 comment '可否使用',
    email varchar(100) comment '聯繫email',
    line varchar(100) comment 'line帳號'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='使用者';

create table users_temp (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    id varchar(30) comment '帳號',
    password varchar(255) not null comment '密碼',
    name varchar(50) comment '姓名',
    manager tinyint not null default 0 comment '是否為主管',
    yda tinyint unsigned comment '青年署專員編號',
    county tinyint unsigned comment '縣市編號',
    organization mediumint unsigned comment '機構編號',
    counselor mediumint unsigned comment '輔導員編號',
    youth bigint unsigned comment '青少年',
    usable tinyint not null default 1 comment '可否使用',
    email varchar(100) comment '聯繫email',
    line varchar(100) comment 'line帳號'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='使用者_暫存';

create table files (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    owner bigint unsigned not null comment '檔案連結的實體編號',
    name varchar(50) comment '檔案名稱',
    original_name varchar(50) comment '檔案原始名稱',
    path varchar(50) comment '檔案路徑',
    create_time timestamp default current_timestamp comment '建立時間',
    usable tinyint not null default 1 comment '可否使用'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='檔案';

create table youth (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    identification varchar(255) comment '身分證',
    name varchar(50) comment '姓名',
    birth date null comment '出生年月日',
    gender varchar(10) comment '性別',
    phone varchar(50) comment '電話',
    household_address varchar(255) comment '戶籍地址',
    reside_address varchar(255) comment '居住地址',
    junior_graduate_year varchar(10) comment '國中畢業年度',
    junior_dropout_record tinyint comment '國中是否曾有中輟通報紀錄',
    counsel_identity varchar(10) comment '輔導時身分',
    junior_school_condition varchar(10) comment '國中學歷狀態',
    senior_school_condition varchar(10) comment '高中學歷狀態',
    junior_school varchar(50) comment '國中學校/年級/科系',
    senior_school varchar(50) comment '高中學校/年級/科系',
    guardian_name varchar(50) comment '監護人姓名',
    guardianship varchar(50) comment '監護人關係',
    guardian_phone varchar(50) comment '監護人電話',
    guardian_household_address varchar(255) comment '監護人戶籍地址',
    guardian_reside_address varchar(255) comment '監護人居住地址',
    county tinyint unsigned comment '縣市編號',
    source varchar(50) comment '青少年來源',
    source_school_year int comment '動向調查學年度',
    survey_type varchar(50) comment '動向調查類別',
    year bigint null comment '年度',
    is_end TINYINT NULL COMMENT '是否結案'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='青少年基本資料';

insert into menu (form_name, column_name, content) values('youth', 'gender', '男');
insert into menu (form_name, column_name, content) values('youth', 'gender', '女');
insert into menu (form_name, column_name, content) values('youth', 'junior_school_condition', '應屆畢業');
insert into menu (form_name, column_name, content) values('youth', 'junior_school_condition', '畢業');
insert into menu (form_name, column_name, content) values('youth', 'junior_school_condition', '結業');
insert into menu (form_name, column_name, content) values('youth', 'junior_school_condition', '中輟');
insert into menu (form_name, column_name, content) values('youth', 'senior_school_condition', '具學籍');
insert into menu (form_name, column_name, content) values('youth', 'senior_school_condition', '無學籍');
insert into menu (form_name, column_name, content) values('youth', 'source', '動向調查');
insert into menu (form_name, column_name, content) values('youth', 'source', '轉介或自行開發');
insert into menu (form_name, column_name, content) values('youth', 'source', '高中已報到未註冊');
insert into menu (form_name, column_name, content) values('youth', 'counsel_identity', '國中未畢業中輟');
insert into menu (form_name, column_name, content) values('youth', 'counsel_identity', '中輟滿16歲未升學未就業');
insert into menu (form_name, column_name, content) values('youth', 'counsel_identity', '國中畢業未就學未就業(應屆畢業)');
insert into menu (form_name, column_name, content) values('youth', 'counsel_identity', '國中畢業未就學未就業(非應屆畢業)');
insert into menu (form_name, column_name, content) values('youth', 'counsel_identity', '高中中離');

#delete from menu where column_name = 'survey_type';
insert into menu (form_name, column_name, content) values('youth', 'survey_type', '01已就業');
insert into menu (form_name, column_name, content) values('youth', 'survey_type', '02已就學');
insert into menu (form_name, column_name, content) values('youth', 'survey_type', '03特教生');
insert into menu (form_name, column_name, content) values('youth', 'survey_type', '04準備升學');
insert into menu (form_name, column_name, content) values('youth', 'survey_type', '05準備或正在找工作');
insert into menu (form_name, column_name, content) values('youth', 'survey_type', '06參加職訓');
insert into menu (form_name, column_name, content) values('youth', 'survey_type', '07家務勞動');
insert into menu (form_name, column_name, content) values('youth', 'survey_type', '08健康因素');
insert into menu (form_name, column_name, content) values('youth', 'survey_type', '09尚未規劃');
insert into menu (form_name, column_name, content) values('youth', 'survey_type', '10失聯');
insert into menu (form_name, column_name, content) values('youth', 'survey_type', '11自學');
insert into menu (form_name, column_name, content) values('youth', 'survey_type', '12其他動向(懷孕待產、社福機構安置、轉學待追蹤等)');
insert into menu (form_name, column_name, content) values('youth', 'survey_type', '13不可抗力(去世、司法問題、出國)');

insert into menu (form_name, column_name, content) values('youth', 'survey_type', '12其他動向(懷孕待產)');
insert into menu (form_name, column_name, content) values('youth', 'survey_type', '12其他動向(社福機構安置)');
insert into menu (form_name, column_name, content) values('youth', 'survey_type', '12其他動向(轉學)');
insert into menu (form_name, column_name, content) values('youth', 'survey_type', '13不可抗力(去世)');
insert into menu (form_name, column_name, content) values('youth', 'survey_type', '13不可抗力(司法問題)');
insert into menu (form_name, column_name, content) values('youth', 'survey_type', '13不可抗力(出國)');

create table yda (
    no tinyint unsigned not null auto_increment primary key comment '流水號',
    phone varchar(50) comment '電話'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='青年署專員基本資料';

create table county (
    no tinyint unsigned not null auto_increment primary key comment '流水號',
    name varchar(50) not null comment '縣市名稱',
    code varchar(1) not null comment '縣市代碼',
    phone varchar(50) comment '縣市電話',
    orgnizer varchar(50) comment '承辦單位',
    priority TINYINT NULL COMMENT '排序',
    update_project TINYINT NULL COMMENT '是否可修改計畫案'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='縣市基本資料';


ALTER TABLE `county` AUTO_INCREMENT = 1;
INSERT INTO `county` (`no`, `name`, `code`, `phone`, `orgnizer`) VALUES 
(NULL, '彰化縣', 'N', '04-7273173', '特殊教育科'), 
(NULL, '臺北市', 'A', '02-27208889', '中等教育科'), 
(NULL, '新北市', 'F', '02-29603456', '技職教育科'), 
(NULL, '桃園市', 'H', '03-3322101', '學輔校安室'), 
(NULL, '新竹市', 'O', '03-5248168', '學務管理科'),
(NULL, '新竹縣', 'J', '03-5518101', '特殊教育科'), 
(NULL, '苗栗縣', 'K', '037-559706', '特殊教育科'),
(NULL, '臺中市', 'B', '04-22289111', '學生事務室'), 
(NULL, '南投縣', 'M', '049-2222106', '特殊教育科'),
(NULL, '雲林縣', 'P', '05-5522467', '學務管理科'),
(NULL, '嘉義縣', 'Q', '05-3620123', '學務特教科'), 
(NULL, '臺南市', 'D', '06-6337942', '特殊教育科'), 
(NULL, '高雄市', 'E', '07-7995678', '國中教育科'), 
(NULL, '屏東縣', 'T', '08-7371783', '特殊教育科'), 
(NULL, '臺東縣', 'V', '089-322002', '學務管理科'), 
(NULL, '宜蘭縣', 'G', '03-9251000', '學務管理科'), 
(NULL, '花蓮縣', 'U', '03-8462860', '學務管理科'), 
(NULL, '嘉義市', 'I', '05-2285823 ', '學輔校安科'),
(NULL, '澎湖縣', 'X', '06-9274400', '學務管理科'),
(NULL, '連江縣', 'Z', '0836‐25171', '學務管理科'), 
(NULL, '金門縣', 'W', '082‐325630', '學務管理科'),
(NULL, '基隆市', 'C', '', '');



create table organization (
    no mediumint unsigned not null auto_increment primary key comment '流水號',
    county tinyint unsigned not null comment '所屬縣市',
    name varchar(50) comment '機構名稱',
    phone varchar(50) comment '機構電話',
    address varchar(500) comment '地址'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='機構基本資料';

ALTER TABLE `organization` AUTO_INCREMENT = 1;
INSERT INTO `organization` (`no`, `county`, `name`, `phone`, `address`) VALUES 
(NULL, '1', '彰化縣學生輔導諮商中心', '04-7285236', '彰化市公園路1段409號'),
(NULL, '2', '臺北市學生輔導諮商中心', '02-25632156', '台北市中山區吉林路110號3樓'),
(NULL, '2', '社團法人中華基督教以琳關懷協會', '02-25970002', '台北巿新生北路三段82巷37號B1'),
(NULL, '3', '財團法人淨化社會文教基金會', '02-82611993', '新北市土城區學府路一段23巷21號2樓'),
(NULL, '4', '桃園市學生輔導諮商中心', '03-4609199', '桃園市平鎮區平東路168號'),
(NULL, '5', '新竹市學生輔導諮商中心', '03-5286661', '新竹市東區民族路33號'),
(NULL, '6', '新竹縣學生輔導諮商中心', '03-5110916', '新竹縣竹東鎮中山路68號'),
(NULL, '7', '苗栗縣學生輔導諮商中心', '037-350067', '苗栗市國華路1121號'),
(NULL, '9', '南投縣學生輔導諮商中心 ', '049-2222549', '南投縣南投市祖祠路361號'),
(NULL, '10', '雲林縣東仁國中', '05-6312888', '雲林縣虎尾鎮東明路85號'),
(NULL, '11', '嘉義縣學生輔導諮商中心', '05-2949193', '嘉義縣太保市祥和一路東段1號3樓'),
(NULL, '12', '台南市學生輔導諮商中心', '06-2521083', '台南市北區和緯路一段2號'),
(NULL, '12', '社團法人台南市教育及兒童青少年發展協會', '06-2205589', '台南市中西區保安路201-1號2樓'),
(NULL, '13', '高雄市中山國中', '07-8021765', '高雄市小港區漢民路352號'),
(NULL, '14', '屏東縣學生輔導諮商中心', '08-7337192', '屏東市蘭州街2號'),
(NULL, '15', '臺東縣學生輔導諮商中心', '089-323756', '臺東市桂林北路52巷124號'),
(NULL, '16', '宜蘭縣學生輔導諮商中心', '03-9352090', '宜蘭縣宜蘭市泰山路60號百齡樓4樓'),
(NULL, '18', '嘉義市學生輔導諮商中心', '05-2786113', '嘉義市山子頂269-1號'),
(NULL, '19', '澎湖縣學生輔導諮商中心', '06-9276009', '澎湖縣馬公市三多路450號'),
(NULL, '20', '連江縣學生輔導諮商中心', '0836-23694', '連江縣南竿鄉介壽村76號'),
(NULL, '21', '金門縣學生輔導諮商中心', '082-330360', '金門縣金湖鎮太湖路三段1號行政大樓3樓'),
(NULL, '22', '基隆市學生輔導諮商中心', '02-24301585', '基隆市安樂區武崙街205號');

create table counselor (
    no mediumint unsigned not null auto_increment primary key comment '流水號',
    organization mediumint unsigned not null comment '所屬機構',
    identification varchar(255) comment '身分證',
    gender varchar(10) comment '性別',
    birth date comment '出生年月日',
    department varchar(50) comment '單位',
    fax varchar(50) comment '傳真',
    phone varchar(50) comment '電話',
    email varchar(50) comment '電子郵件',
    household_address varchar(255) comment '戶籍地址',
    reside_address varchar(255) comment '居住地址',
    education_start_date varchar(200) comment '學歷-起',
    education_complete_date varchar(200) comment '學歷-迄',
    education_school varchar(200) comment '學校名稱',
    education_department varchar(200) comment '科系',
    highest_education varchar(10) comment '最高學歷',
    affiliated_department varchar(10) comment '隸屬部門',
    work_start_date varchar(200) comment '經歷-起',
    work_complete_date varchar(200) comment '經歷-迄',
    work_department varchar(200) comment '服務單位名稱',
    work_position varchar(200) comment '擔任職務',
    duty_date date comment '到職日',
    qualification varchar(30) comment '專任輔導員資格(多選)'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='輔導員基本資料';

insert into menu (form_name, column_name, content) values('counselor', 'gender', '男');
insert into menu (form_name, column_name, content) values('counselor', 'gender', '女');
insert into menu (form_name, column_name, content) values('counselor', 'qualification', '領有社會工作師或心理師證照者');
insert into menu (form_name, column_name, content) values('counselor', 'qualification', '具就業服務乙級技術士證照或領有政府機關核發之就業服務專業人員證書者');
insert into menu (form_name, column_name, content) values('counselor', 'qualification', '符合國內公立或教育部立案之私立大專校院或經教育部承認之國外大專校院，教育學、社會(含社工、社福)學、心理學、諮商輔導、勞工關係、人力資源等相關科系畢業者');
insert into menu (form_name, column_name, content) values('counselor', 'qualification', '國內公立或教育部立案之私立大專校院或經教育部承認之國外大專校院相當科、系、組、所畢業，領有畢業證書，具備考選部公告社會工作師或心理師應考資格者');
insert into menu (form_name, column_name, content) values('counselor', 'highest_education', '碩士');
insert into menu (form_name, column_name, content) values('counselor', 'highest_education', '學士');
insert into menu (form_name, column_name, content) values('counselor', 'affiliated_department', '教育局(處)');
insert into menu (form_name, column_name, content) values('counselor', 'affiliated_department', '輔諮中心');
insert into menu (form_name, column_name, content) values('counselor', 'affiliated_department', '學校');
insert into menu (form_name, column_name, content) values('counselor', 'affiliated_department', '委外單位');

create table expert_list (
    no mediumint unsigned not null auto_increment primary key comment '流水號',
    name varchar(50) comment '姓名',
    gender varchar(10) comment '性別',
    phone varchar(50) comment '電話',
    email varchar(50) comment '電子郵件',
    education varchar(50) comment '教育程度',
    profession varchar(50) comment '專業',
    reside_county varchar(255) comment '居住地址',
    organization mediumint unsigned not null comment '開課機構',
    is_open tinyint comment '是否開放'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='專家基本資料';

insert into menu (form_name, column_name, content) values('expert_list', 'gender', '男');
insert into menu (form_name, column_name, content) values('expert_list', 'gender', '女');

create table course_reference (
    no mediumint unsigned not null auto_increment primary key comment '流水號',
    name varchar(50) comment '課程名稱',
    duration varchar(50) comment '上課時數',
    expert mediumint unsigned not null comment '開課老師',
    organization mediumint unsigned not null comment '開課機構',
    category varchar(10) comment '課程類別',
    content varchar(50) comment '課程內容'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='課程參考';

insert into menu (form_name, column_name, content) values('course_reference', 'category', '生涯探索與就業力培訓');
insert into menu (form_name, column_name, content) values('course_reference', 'category', '體驗教育及志願服務');
insert into menu (form_name, column_name, content) values('course_reference', 'category', '法治(含反毒)及性別平等教育');
insert into menu (form_name, column_name, content) values('course_reference', 'category', '其他及彈性運用');

create table course (
    no int unsigned not null auto_increment primary key comment '流水號',
    course_reference mediumint unsigned not null comment '參考課程',
    organization mediumint unsigned not null comment '開課機構',
    start_time timestamp null comment '上課時間',
    end_time timestamp null comment '下課時間',
    year bigint null comment '年度'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='課程';

create table company (
    no mediumint unsigned not null auto_increment primary key comment '流水號',
    name varchar(50) comment '公司名稱',
    boss_name varchar(50) comment '老闆名稱',
    phone varchar(50) comment '老闆電話',
    category varchar(10) comment '工作類別(單選)',
    content varchar(50) comment '工作內容',
    requirement varchar(50) comment '工作條件',
    address varchar(255) comment '工作地址',
    organization mediumint unsigned not null comment '開課機構',
    is_open tinyint comment '是否開放'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='公司';

insert into menu (form_name, column_name, content) values('company', 'category', '農、林、漁、牧業');
insert into menu (form_name, column_name, content) values('company', 'category', '礦業及土石採取業');
insert into menu (form_name, column_name, content) values('company', 'category', '製造業');
insert into menu (form_name, column_name, content) values('company', 'category', '電力及燃氣供應業');
insert into menu (form_name, column_name, content) values('company', 'category', '用水供應及污染整治業');
insert into menu (form_name, column_name, content) values('company', 'category', '營建工程業');
insert into menu (form_name, column_name, content) values('company', 'category', '批發及零售業');
insert into menu (form_name, column_name, content) values('company', 'category', '運輸及倉儲業');
insert into menu (form_name, column_name, content) values('company', 'category', '住宿及餐飲業');
insert into menu (form_name, column_name, content) values('company', 'category', '出版、影音製作、傳播及資通訊服務業');
insert into menu (form_name, column_name, content) values('company', 'category', '金融及保險業');
insert into menu (form_name, column_name, content) values('company', 'category', '不動產業');
insert into menu (form_name, column_name, content) values('company', 'category', '專業、科學及技術服務業');
insert into menu (form_name, column_name, content) values('company', 'category', '支援服務業');
insert into menu (form_name, column_name, content) values('company', 'category', '公共行政及國防；強制性社會安全');
insert into menu (form_name, column_name, content) values('company', 'category', '教育業');
insert into menu (form_name, column_name, content) values('company', 'category', '醫療保健及社會工作服務業');
insert into menu (form_name, column_name, content) values('company', 'category', '藝術、娛樂及休閒服務業');
insert into menu (form_name, column_name, content) values('company', 'category', '其他服務業');

create table work_experience (
    no int unsigned not null auto_increment primary key comment '流水號',
    company mediumint unsigned not null comment '公司',
    start_time timestamp null comment '上班時間',
    end_time timestamp null comment '下班時間',
    organization mediumint unsigned not null comment '開課機構',
    year bigint null comment '年度'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='工作體驗';

create table member (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    system_no varchar(15) not null comment '系統編號',
    youth bigint unsigned not null comment '青少年',
    counselor mediumint unsigned not null comment '開案輔導員',
    project bigint unsigned not null comment '計劃案',
    organization mediumint unsigned not null comment '開案機構',
    county tinyint unsigned not null comment '開案縣市',
    create_date date not null comment '開按日',
    end_date date comment '結案日',
    year bigint null comment '年度'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='學員基本資料';

create table project (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    name varchar(50) comment '計畫名稱',
    county tinyint unsigned not null comment '承辦單位',
    execute_mode varchar(10) comment '辦理模式(單選)',
    execute_way varchar(10) comment '辦理方式(單選)',
    counselor_count mediumint unsigned not null comment '輔導員數量',
    meeting_count mediumint unsigned not null comment '跨局處會議次數',
    counseling_member mediumint unsigned not null comment '輔導會談-人數',
    counseling_hour mediumint unsigned not null comment '輔導會談-小時/人',
    course_hour mediumint unsigned not null comment '生涯探索課程或活動-小時',
    working_member mediumint unsigned not null comment '工作體驗-人數',
    working_hour mediumint unsigned not null comment '工作體驗-小時',
    funding VARCHAR(20) NULL COMMENT '計畫經費',
    note TEXT NULL COMMENT '備註',
    year bigint not null comment '年度',
    date date not null comment '填表日期'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='計劃案';

ALTER TABLE `project` AUTO_INCREMENT = 1;
INSERT INTO `project` (`no`, `name`, `county`, `execute_mode`, `execute_way`, `counselor_count`, `meeting_count`, `counseling_member`, `counseling_hour`, `course_hour`, `working_member`, `working_hour`, `year`, `date`) VALUES 
(NULL, '彰化縣計畫', '1', '36', '38', '2', '2', '20', '10', '120', '10', '12', '109', '2020-11-02'),
(NULL, '臺北市計畫', '2', '36', '38', '2', '2', '20', '10', '120', '10', '12', '109', '2020-11-02'),
(NULL, '新北市計畫', '3', '36', '38', '2', '2', '20', '10', '120', '10', '12', '109', '2020-11-02'),
(NULL, '桃園市計畫', '4', '36', '38', '2', '2', '20', '10', '120', '10', '12', '109', '2020-11-02'),
(NULL, '新竹市計畫', '5', '36', '38', '2', '2', '20', '10', '120', '10', '12', '109', '2020-11-02'),
(NULL, '新竹縣計畫', '6', '36', '38', '2', '2', '20', '10', '120', '10', '12', '109', '2020-11-02'),
(NULL, '苗栗縣計畫', '7', '36', '38', '2', '2', '20', '10', '120', '10', '12', '109', '2020-11-02'),
(NULL, '臺中市計畫', '8', '36', '38', '2', '2', '20', '10', '120', '10', '12', '109', '2020-11-02'),
(NULL, '南投縣計畫', '9', '36', '38', '2', '2', '20', '10', '120', '10', '12', '109', '2020-11-02'),
(NULL, '雲林縣計畫', '10', '36', '38', '2', '2', '20', '10', '120', '10', '12', '109', '2020-11-02'),
(NULL, '嘉義縣計畫', '11', '36', '38', '2', '2', '20', '10', '120', '10', '12', '109', '2020-11-02'),
(NULL, '臺南市計畫', '12', '36', '38', '2', '2', '20', '10', '120', '10', '12', '109', '2020-11-02'),
(NULL, '高雄市計畫', '13', '36', '38', '2', '2', '20', '10', '120', '10', '12', '109', '2020-11-02'),
(NULL, '屏東縣計畫', '14', '36', '38', '2', '2', '20', '10', '120', '10', '12', '109', '2020-11-02'),
(NULL, '臺東縣計畫', '15', '36', '38', '2', '2', '20', '10', '120', '10', '12', '109', '2020-11-02'),
(NULL, '宜蘭縣計畫', '16', '36', '38', '2', '2', '20', '10', '120', '10', '12', '109', '2020-11-02'),
(NULL, '花蓮縣計畫', '17', '36', '38', '2', '2', '20', '10', '120', '10', '12', '109', '2020-11-02'),
(NULL, '嘉義市計畫', '18', '36', '38', '2', '2', '20', '10', '120', '10', '12', '109', '2020-11-02'),
(NULL, '澎湖縣計畫', '19', '36', '38', '2', '2', '20', '10', '120', '10', '12', '109', '2020-11-02'),
(NULL, '連江縣計畫', '20', '36', '38', '2', '2', '20', '10', '120', '10', '12', '109', '2020-11-02'),
(NULL, '金門縣計畫', '21', '36', '38', '2', '2', '20', '10', '120', '10', '12', '109', '2020-11-02'),
(NULL, '基隆市計畫', '22', '36', '38', '2', '2', '20', '10', '120', '10', '12', '109', '2020-11-02');

insert into menu (form_name, column_name, content) values('project', 'execute_mode', '模式一:輔導會談');
insert into menu (form_name, column_name, content) values('project', 'execute_mode', '模式二:輔導會談+生涯探索課程或活動');
insert into menu (form_name, column_name, content) values('project', 'execute_mode', '模式三:輔導會談+生涯探索課程或活動+工作體驗');
insert into menu (form_name, column_name, content) values('project', 'execute_way', '自辦');
insert into menu (form_name, column_name, content) values('project', 'execute_way', '委辦');

create table county_delegate_organization (
    no mediumint unsigned not null auto_increment primary key comment '流水號',
    county tinyint unsigned not null comment '開案縣市',
    organization mediumint unsigned not null comment '服務機構',
    project mediumint unsigned not null comment '執行計畫',
    has_delegation tinyint not null default 1 comment '是否服務中'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='縣市委任的機構';

INSERT INTO `county_delegate_organization` (`no`, `county`, `organization`, `project`, `has_delegation`) VALUES 
(NULL, '1', '1', '1', '1'),
(NULL, '2', '2', '2', '1'),
(NULL, '2', '3', '2', '1'),
(NULL, '3', '4', '3', '1'),
(NULL, '4', '5', '4', '1'),
(NULL, '5', '6', '5', '1'),
(NULL, '6', '7', '6', '1'),
(NULL, '7', '8', '7', '1'),
(NULL, '9', '9', '9', '1'),
(NULL, '10', '10', '10', '1'),
(NULL, '11', '11', '11', '1'),
(NULL, '12', '12', '12', '1'),
(NULL, '12', '13', '12', '1'),
(NULL, '13', '14', '13', '1'),
(NULL, '14', '15', '14', '1'),
(NULL, '15', '16', '15', '1'),
(NULL, '16', '17', '16', '1'),
(NULL, '18', '18', '18', '1'),
(NULL, '19', '19', '19', '1'),
(NULL, '20', '20', '20', '1'),
(NULL, '21', '21', '21', '1'),
(NULL, '22', '22', '22', '1');

create table intake (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    youth bigint unsigned not null comment '青少年編號',
    project bigint unsigned not null comment '計劃案',
    -- 轉介單位基本資料
    referral_institution varchar(30) comment '轉介單位-名稱',
    referral_name varchar(30) comment '轉介單位-聯絡人',
    referral_phone varchar(50) comment '轉介單位-電話', 
    -- 轉介單位的處遇概況
    referral_target text comment '服務目標與際遇',
    referral_attitude varchar(10) comment '處遇態度',
    referral_attitude_other varchar(30) comment '處遇態度-其他', 
    -- 青少年主要需求   
    major_demand varchar(10) comment '主要需求',
    major_demand_other text comment '主要需求-其他',
    open_case tinyint comment '是否開案'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='青少年初評表';
insert into menu (form_name, column_name, content) values('intake', 'referral_attitude', '積極介入');
insert into menu (form_name, column_name, content) values('intake', 'referral_attitude', '消極轉介');
insert into menu (form_name, column_name, content) values('intake', 'referral_attitude', '預備結案');
insert into menu (form_name, column_name, content) values('intake', 'referral_attitude', '已結案');
insert into menu (form_name, column_name, content) values('intake', 'referral_attitude', '其他');
insert into menu (form_name, column_name, content) values('intake', 'major_demand', '就學');
insert into menu (form_name, column_name, content) values('intake', 'major_demand', '就業');
insert into menu (form_name, column_name, content) values('intake', 'major_demand', '其他');

create table case_assessment_temp (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    -- 青少年背景資料
    member bigint unsigned not null comment '系統編號',
    interview_date date comment '初談日期',
    intervvarchariew_way varchar(10) comment '進行方式(單選)',
    interview_place (30) comment '諮詢地點',
    education varchar(10) comment '學歷狀況(單選)',
    source varchar(10) comment '青少年來源(單選)',
    source_other varchar(30) comment '青少年來源-其他',
    survey_year varchar(30) comment '動向調查名單-學年度',
    background varchar(30) comment '青少年身分別(複選)',
    background_other varchar(30) comment '青少年身分別-其他',
    -- 青少年概況
    appearance_habits text comment '儀容/生活習慣',
    major_setback text comment '生命重大事件',
    interest_plan text comment '興趣/未來規劃',
    interactive_experience text comment '互動經驗',
    transportation varchar(30) comment '交通能力(復選)',
    transportation_other varchar(30) comment '交通能力-其他',
    medical_support tinyint comment '醫療需求',
    medical_reason text comment '醫療需求-原因',
    -- 家庭概況
    family_member text comment '家庭成員',
    family_interactive_pattern text comment '家庭互動模式',
    community_interactive_pattern text comment '社區互動模式',
    family_major_setback text comment '家庭重大事件',
    family_other_setback text comment '其他事件',
    -- 學校概況
    school_history text comment '就學史',
    teacher_interactive_pattern varchar(10) comment '師生關係與互動',
    teacher_bad_reason text comment '師生關係與互動-補充說明',
    peer_interactive_pattern varchar(10) comment '同儕關係',
    peer_bad_reason text comment '同儕關係-補充說明',
    academic_performance varchar(10) comment '學業表現',
    interest_subject varchar(30) comment '學業表現-有興趣科目',
    violation tinyint comment '違規行為',
    violation_description text comment '違規行為-說明',
    -- 其他資源介入概況
    welfare_support tinyint comment '福利身分或資源',
    welfare_amount mediumint unsigned comment '補助金額',
    welfare_source varchar(30) comment '補助來源',
    event_source varchar(30) comment '通報單位',
    event_description text comment '通報事件',
    serving_source TINYINT NULL COMMENT '其他民間單位',
    serving_institution varchar(30) comment '已接受服務-單位',
    serving_professional varchar(30) comment '已接受服務-專業人員',
    serving_phone varchar(30) comment '已接受服務-聯絡電話',
    -- 青少年議題
    issue varchar(100) comment '青少年議題(複選)',
    issue_other varchar(30) comment '青少年議題-其他',
    -- 開案決策
    counsel_way varchar(50) comment '預計輔導方式(複選)',
    counsel_way_other varchar(30) comment '預計輔導方式-其他',
    counsel_target text comment '預計輔導目標及綜合評估',
    -- 圖檔
    family_diagram varchar(80) comment '家系圖',
    representative_agreement varchar(80) comment '法定代理人同意書',
    counselor mediumint unsigned not null comment '評估人員'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='開案評估表_暫存';

create table case_assessment (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    -- 青少年背景資料
    member bigint unsigned not null comment '系統編號',
    interview_date date comment '初談日期',
    interview_way varchar(10) comment '進行方式(單選)',
    interview_place varchar(30) comment '諮詢地點',
    education varchar(10) comment '學歷狀況(單選)',
    source varchar(10) comment '青少年來源(單選)',
    source_other varchar(30) comment '青少年來源-其他',
    survey_year varchar(30) comment '動向調查名單-學年度',
    background varchar(30) comment '青少年身分別(複選)',
    background_other varchar(30) comment '青少年身分別-其他',
    -- 青少年概況
    appearance_habits text comment '儀容/生活習慣',
    major_setback text comment '生命重大事件',
    interest_plan text comment '興趣/未來規劃',
    interactive_experience text comment '互動經驗',
    transportation varchar(10) comment '交通能力(單選)',
    transportation_other varchar(30) comment '交通能力-其他',
    medical_support tinyint comment '醫療需求',
    medical_reason text comment '醫療需求-原因',
    -- 家庭概況
    family_member text comment '家庭成員',
    family_interactive_pattern text comment '家庭互動模式',
    community_interactive_pattern text comment '社區互動模式',
    family_major_setback text comment '家庭重大事件',
    family_other_setback text comment '其他事件',
    -- 學校概況
    school_history text comment '就學史',
    teacher_interactive_pattern varchar(10) comment '師生關係與互動',
    teacher_bad_reason text comment '師生關係與互動-補充說明',
    peer_interactive_pattern varchar(10) comment '同儕關係',
    peer_bad_reason text comment '同儕關係-補充說明',
    academic_performance varchar(10) comment '學業表現',
    interest_subject varchar(30) comment '學業表現-有興趣科目',
    violation tinyint comment '違規行為',
    violation_description text comment '違規行為-說明',
    -- 其他資源介入概況
    welfare_support tinyint comment '福利身分或資源',
    welfare_amount mediumint unsigned comment '補助金額',
    welfare_source varchar(30) comment '補助來源',
    event_source varchar(30) comment '通報單位',
    event_description text comment '通報事件',
    serving_source TINYINT NULL COMMENT '其他民間單位',
    serving_institution varchar(30) comment '已接受服務-單位',
    serving_professional varchar(30) comment '已接受服務-專業人員',
    serving_phone varchar(30) comment '已接受服務-聯絡電話',
    -- 青少年議題
    issue varchar(100) comment '青少年議題(複選)',
    issue_other varchar(30) comment '青少年議題-其他',
    -- 開案決策
    counsel_way varchar(50) comment '預計輔導方式(複選)',
    counsel_way_other varchar(30) comment '預計輔導方式-其他',
    counsel_target text comment '預計輔導目標及綜合評估',
    -- 圖檔
    family_diagram varchar(80) comment '家系圖',
    representative_agreement varchar(80) comment '法定代理人同意書',
    counselor mediumint unsigned not null comment '評估人員'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='開案評估表';

insert into menu (form_name, column_name, content) values('case_assessment', 'interview_way', '電話');
insert into menu (form_name, column_name, content) values('case_assessment', 'interview_way', '面訪');
insert into menu (form_name, column_name, content) values('case_assessment', 'education', '國中未畢業中輟');
insert into menu (form_name, column_name, content) values('case_assessment', 'education', '中輟滿16歲未升學未就業');
insert into menu (form_name, column_name, content) values('case_assessment', 'education', '國中畢業未升學未就業(應屆畢業)');
insert into menu (form_name, column_name, content) values('case_assessment', 'education', '國中畢業未升學未就業(非應屆畢業)');
insert into menu (form_name, column_name, content) values('case_assessment', 'education', '高中中離(一年級)');
insert into menu (form_name, column_name, content) values('case_assessment', 'education', '高中中離(二年級)');
insert into menu (form_name, column_name, content) values('case_assessment', 'education', '高中中離(三年級)');
insert into menu (form_name, column_name, content) values('case_assessment', 'source', '動向調查名單');
insert into menu (form_name, column_name, content) values('case_assessment', 'source', '家長');
insert into menu (form_name, column_name, content) values('case_assessment', 'source', '學校');
insert into menu (form_name, column_name, content) values('case_assessment', 'source', '社會團體');
insert into menu (form_name, column_name, content) values('case_assessment', 'source', '安置機構');
insert into menu (form_name, column_name, content) values('case_assessment', 'source', '警政司法機構');
insert into menu (form_name, column_name, content) values('case_assessment', 'source', '學員及舊生');
insert into menu (form_name, column_name, content) values('case_assessment', 'source', '法務部轉介');
insert into menu (form_name, column_name, content) values('case_assessment', 'source', '其他');
insert into menu (form_name, column_name, content) values('case_assessment', 'background', '一般身分');
insert into menu (form_name, column_name, content) values('case_assessment', 'background', '原住民身分');
insert into menu (form_name, column_name, content) values('case_assessment', 'background', '低收及中低收入戶');
insert into menu (form_name, column_name, content) values('case_assessment', 'background', '單親家庭');
insert into menu (form_name, column_name, content) values('case_assessment', 'background', '隔代家庭');
insert into menu (form_name, column_name, content) values('case_assessment', 'background', '身心障礙者');
insert into menu (form_name, column_name, content) values('case_assessment', 'background', '新住民子女');
insert into menu (form_name, column_name, content) values('case_assessment', 'background', '自立青年');
insert into menu (form_name, column_name, content) values('case_assessment', 'background', '其他');
insert into menu (form_name, column_name, content) values('case_assessment', 'transportation', '腳踏車');
insert into menu (form_name, column_name, content) values('case_assessment', 'transportation', '公車');
insert into menu (form_name, column_name, content) values('case_assessment', 'transportation', '火車');
insert into menu (form_name, column_name, content) values('case_assessment', 'transportation', '機車(滿18歲且有駕照)');
insert into menu (form_name, column_name, content) values('case_assessment', 'transportation', '其他');
insert into menu (form_name, column_name, content) values('case_assessment', 'teacher_interactive_pattern', '反抗或不服從');
insert into menu (form_name, column_name, content) values('case_assessment', 'teacher_interactive_pattern', '偶有反抗');
insert into menu (form_name, column_name, content) values('case_assessment', 'teacher_interactive_pattern', '願意聽從');
insert into menu (form_name, column_name, content) values('case_assessment', 'teacher_interactive_pattern', '關係不佳');
insert into menu (form_name, column_name, content) values('case_assessment', 'peer_interactive_pattern', '有同儕的支持與協助');
insert into menu (form_name, column_name, content) values('case_assessment', 'peer_interactive_pattern', '與班上同學人際關係不佳');
insert into menu (form_name, column_name, content) values('case_assessment', 'peer_interactive_pattern', '被貼負面標籤');
insert into menu (form_name, column_name, content) values('case_assessment', 'academic_performance', '勝任學校課業');
insert into menu (form_name, column_name, content) values('case_assessment', 'academic_performance', '學業成就低落');
insert into menu (form_name, column_name, content) values('case_assessment', 'academic_performance', '缺乏學習目標與動力');
insert into menu (form_name, column_name, content) values('case_assessment', 'issue', '拒學/中輟');
insert into menu (form_name, column_name, content) values('case_assessment', 'issue', '自傷/自殺');
insert into menu (form_name, column_name, content) values('case_assessment', 'issue', '網路成癮');
insert into menu (form_name, column_name, content) values('case_assessment', 'issue', '性侵(行為人)');
insert into menu (form_name, column_name, content) values('case_assessment', 'issue', '性侵(被行為人)');
insert into menu (form_name, column_name, content) values('case_assessment', 'issue', '合意性行為');
insert into menu (form_name, column_name, content) values('case_assessment', 'issue', '性騷擾(行為人)');
insert into menu (form_name, column_name, content) values('case_assessment', 'issue', '性騷擾(被行為人)');
insert into menu (form_name, column_name, content) values('case_assessment', 'issue', '家暴/兒虐');
insert into menu (form_name, column_name, content) values('case_assessment', 'issue', '哀傷/失落');
insert into menu (form_name, column_name, content) values('case_assessment', 'issue', '家庭/親子');
insert into menu (form_name, column_name, content) values('case_assessment', 'issue', '情緒困擾');
insert into menu (form_name, column_name, content) values('case_assessment', 'issue', '人際困擾');
insert into menu (form_name, column_name, content) values('case_assessment', 'issue', '學習困擾');
insert into menu (form_name, column_name, content) values('case_assessment', 'issue', '一般精神疾患(醫生診斷:過動、緘默、焦慮、憂鬱等)');
insert into menu (form_name, column_name, content) values('case_assessment', 'issue', '特教(特教鑑定)');
insert into menu (form_name, column_name, content) values('case_assessment', 'issue', '偏差行為(暴力、說謊等)');
insert into menu (form_name, column_name, content) values('case_assessment', 'issue', '性別/感情困擾');
insert into menu (form_name, column_name, content) values('case_assessment', 'issue', '其他');
insert into menu (form_name, column_name, content) values('case_assessment', 'counsel_way', '輔導會談');
insert into menu (form_name, column_name, content) values('case_assessment', 'counsel_way', '生涯探索課程或活動');
insert into menu (form_name, column_name, content) values('case_assessment', 'counsel_way', '工作體驗');
insert into menu (form_name, column_name, content) values('case_assessment', 'counsel_way', '轉介個別諮商');
insert into menu (form_name, column_name, content) values('case_assessment', 'counsel_way', '其他');

create table counselor_serving_member (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    counselor mediumint unsigned not null comment '輔導員',
    member bigint unsigned not null comment '學員',
    has_relation tinyint not null default 1 comment '有無關係'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='輔導員服務中的學員';

create table individual_counseling (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    counselor mediumint unsigned not null comment '輔導員',
    member bigint unsigned not null comment '學員',
    start_time timestamp null comment '開始時間',
    end_time timestamp null comment '結束時間',
    duration_hour float not null comment '諮詢歷時(小時)',
    service_type varchar(10) comment '服務類型(單選)',
    service_way varchar(10) comment '服務方式(單選)',
    community_service_other varchar(30) comment '系統諮詢-其他',
    referral_resource varchar(10) comment '轉銜情形(單選)',
    referral_description text comment '轉銜說明',
    service_target text comment '服務目標',
    service_content text comment '服務內容',
    future_plan text comment '處遇計畫'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='個別諮詢紀錄表';

insert into menu (form_name, column_name, content) values('individual_counseling', 'service_type', '個案服務');
insert into menu (form_name, column_name, content) values('individual_counseling', 'service_type', '系統服務');
-- when service_type == '個案服務'
insert into menu (form_name, column_name, content) values('individual_counseling', 'service_way_member', '電訪');
insert into menu (form_name, column_name, content) values('individual_counseling', 'service_way_member', '親訪');
insert into menu (form_name, column_name, content) values('individual_counseling', 'service_way_member', '網路');
-- when service_type == '系統服務'
insert into menu (form_name, column_name, content) values('individual_counseling', 'service_way_community', '家長諮詢');
insert into menu (form_name, column_name, content) values('individual_counseling', 'service_way_community', '學校諮詢');
insert into menu (form_name, column_name, content) values('individual_counseling', 'service_way_community', '工作店家諮詢');
insert into menu (form_name, column_name, content) values('individual_counseling', 'service_way_community', '個案研討會議');
insert into menu (form_name, column_name, content) values('individual_counseling', 'service_way_community', '其他系統諮詢');

insert into menu (form_name, column_name, content) values('individual_counseling', 'referral_resource', '教育資源');
insert into menu (form_name, column_name, content) values('individual_counseling', 'referral_resource', '勞政資源');
insert into menu (form_name, column_name, content) values('individual_counseling', 'referral_resource', '社政資源');
insert into menu (form_name, column_name, content) values('individual_counseling', 'referral_resource', '衛政資源');
insert into menu (form_name, column_name, content) values('individual_counseling', 'referral_resource', '警政資源');
insert into menu (form_name, column_name, content) values('individual_counseling', 'referral_resource', '司法資源');
insert into menu (form_name, column_name, content) values('individual_counseling', 'referral_resource', '其他資源');

create table group_counseling (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    title varchar(30) comment '單元名稱',
    start_time timestamp null comment '開始時間',
    end_time timestamp null comment '結束時間',
    duration_hour float null comment '諮詢歷時(小時)',
    service_target varchar(10) comment '團體目標',
    service_target_other varchar(30) comment '團體目標-其他',
    member_performance text comment '學員表現',
    important_event text comment '重要事件',
    evaluation text comment '整體評估',
    review text comment '檢討/建議',
    year bigint null comment '年度' 
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='團體輔導紀錄表';

insert into menu (form_name, column_name, content) values('group_counseling', 'service_target', '生涯探索');
insert into menu (form_name, column_name, content) values('group_counseling', 'service_target', '人際溝通與互動');
insert into menu (form_name, column_name, content) values('group_counseling', 'service_target', '體驗教育');
insert into menu (form_name, column_name, content) values('group_counseling', 'service_target', '環境教育');
insert into menu (form_name, column_name, content) values('group_counseling', 'service_target', '法治教育');
insert into menu (form_name, column_name, content) values('group_counseling', 'service_target', '性別平等教育');
insert into menu (form_name, column_name, content) values('group_counseling', 'service_target', '職業訓練');
insert into menu (form_name, column_name, content) values('group_counseling', 'service_target', '志願服務');

create table group_counseling_participants (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    group_counseling bigint unsigned not null comment '團體輔導編號',
    counselor mediumint unsigned not null comment '輔導員',
    member bigint unsigned not null comment '學員',
    is_punctual tinyint null comment '是否準時出席',
    participation_level tinyint not null comment '參與程度(1-5分)',
    description_other text comment '其他敘述'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='團體輔導參與者';

create table attend_course (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    course int unsigned not null comment '課程',
    member bigint unsigned not null comment '學員'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='學員修課紀錄';

create table attend_work (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    work_experience int unsigned not null comment '工作體驗',
    member bigint unsigned not null comment '學員'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='學員工作紀錄';

create table course_attendance (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    course int unsigned not null comment '課程',
    member bigint unsigned not null comment '學員',
    start_time timestamp null comment '上課時間',
    end_time timestamp null comment '下課時間',
    duration float not null comment '歷時',
    note text null comment '備註',
    is_insurance TINYINT NULL COMMENT '是否保險',
    insurance_start_date DATE NULL COMMENT '保險開始日期', 
    insurance_end_date DATE NULL COMMENT '保險結束日期',
    organization mediumint unsigned null comment '所屬機構',
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='學員上課出勤表';

create table insurance (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    member bigint unsigned not null comment '學員',
    start_date DATE NULL COMMENT '保險開始日期', 
    end_date DATE NULL COMMENT '保險結束日期',
    note varchar(50) comment '備註'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='投保紀錄';

create table work_attendance (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    work_experience int unsigned not null comment '工作體驗',
    member bigint unsigned not null comment '學員',
    start_time timestamp null comment '上班時間',
    end_time timestamp null comment '下班時間',
    duration float not null comment '歷時',
    note text null comment '備註',
    is_insurance TINYINT NULL COMMENT '是否保險',
    insurance_start_date DATE NULL COMMENT '保險開始日期', 
    insurance_end_date DATE NULL COMMENT '保險結束日期'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='學員工作出勤表';

create table db_log (
    user varchar(30) comment '使用者帳號',
    time timestamp comment '操作時間',
    function text comment '操作函式',
    command varchar(50) comment '操作內容'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='資料庫操作紀錄';

create table month_review (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    youth bigint unsigned null comment '青少年',
    member bigint unsigned not null comment '學員',
    date date not null comment '追蹤日期',
    way varchar(10) comment '追蹤方式(單選)',
    way_other varchar(30) comment '追蹤方式-其他'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='月追蹤紀錄表';

insert into menu (form_name, column_name, content) values('month_review', 'way', '面訪');
insert into menu (form_name, column_name, content) values('month_review', 'way', '電訪');
insert into menu (form_name, column_name, content) values('month_review', 'way', '網路活動(Email、Line)');
insert into menu (form_name, column_name, content) values('month_review', 'way', '團體活動');
insert into menu (form_name, column_name, content) values('month_review', 'way', '其他');

create table seasonal_review (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    youth bigint unsigned not null comment '青少年',
    counselor mediumint unsigned not null comment '輔導員',
    date date not null comment '追蹤日期',
    is_counseling tinyint not null default 0 comment '是否進入本計畫輔導',
    trend varchar(10) comment '動向(單選)',
    trend_description varchar(30) comment '動向-說明'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='季追蹤紀錄表';

insert into menu (form_name, column_name, content) values('seasonal_review', 'trend', '已就學');
insert into menu (form_name, column_name, content) values('seasonal_review', 'trend', '已就業');
insert into menu (form_name, column_name, content) values('seasonal_review', 'trend', '準備升學');
insert into menu (form_name, column_name, content) values('seasonal_review', 'trend', '準備就業');
insert into menu (form_name, column_name, content) values('seasonal_review', 'trend', '勞政單位協助中');
insert into menu (form_name, column_name, content) values('seasonal_review', 'trend', '社政單位協助中');
insert into menu (form_name, column_name, content) values('seasonal_review', 'trend', '衛政單位協助中');
insert into menu (form_name, column_name, content) values('seasonal_review', 'trend', '警政單位協助中');
insert into menu (form_name, column_name, content) values('seasonal_review', 'trend', '司法單位協助中');
insert into menu (form_name, column_name, content) values('seasonal_review', 'trend', '其他單位協助中');
insert into menu (form_name, column_name, content) values('seasonal_review', 'trend', '尚無規劃');
insert into menu (form_name, column_name, content) values('seasonal_review', 'trend', '未取得聯繫');
insert into menu (form_name, column_name, content) values('seasonal_review', 'trend', '服兵役');
insert into menu (form_name, column_name, content) values('seasonal_review', 'trend', '待產/育兒');
insert into menu (form_name, column_name, content) values('seasonal_review', 'trend', '移民');
insert into menu (form_name, column_name, content) values('seasonal_review', 'trend', '健康因素休養中');
insert into menu (form_name, column_name, content) values('seasonal_review', 'trend', '其他');

insert into menu (form_name, column_name, content) values('seasonal_review', 'trend', '參加職訓');
insert into menu (form_name, column_name, content) values('seasonal_review', 'trend', '家務勞動');
insert into menu (form_name, column_name, content) values('seasonal_review', 'trend', '死亡');
insert into menu (form_name, column_name, content) values('seasonal_review', 'trend', '特教生');


create table end_case (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    member bigint unsigned not null comment '學員流水號',
    trend varchar(10) comment '結案動向',
    work_description varchar(100) comment '就業職種/單位/職稱',
    is_origin_company tinyint comment '是否原工作體驗單位留用',
    school_description varchar(100) comment '學校/系科/年級/部別',
    training_description varchar(100) comment '職訓項目',
    is_complete_counsel tinyint comment '是否達成輔導目標',
    complete_counsel_reason varchar(100) comment '沒有達成輔導目標的原因',
    is_transfer tinyint comment '是否需要後續轉銜',
    transfer_place varchar(100) comment '轉銜單位說明',
    transfer_reason varchar(100) comment '轉銜原因',
    unresistible_reason varchar(100) comment '不可抗拒原因',
    other_description varchar(100) comment '其他',
    date date comment '填表日期'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='結案評估表';

insert into menu (form_name, column_name, content) values('end_case', 'trend', '已就業');
insert into menu (form_name, column_name, content) values('end_case', 'trend', '已就學(全職學生)');
insert into menu (form_name, column_name, content) values('end_case', 'trend', '半工半讀');
insert into menu (form_name, column_name, content) values('end_case', 'trend', '參加職訓');
insert into menu (form_name, column_name, content) values('end_case', 'trend', '準備就業');
insert into menu (form_name, column_name, content) values('end_case', 'trend', '準備就學');
insert into menu (form_name, column_name, content) values('end_case', 'trend', '尚無規劃，須持續輔導');
insert into menu (form_name, column_name, content) values('end_case', 'trend', '不可抗力(說明)');
insert into menu (form_name, column_name, content) values('end_case', 'trend', '其他(說明)');

create table completion (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    form_name varchar(50) comment '表單名稱',
    form_no bigint comment '表單流水號',
    rate int comment '完成率'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='表單完成率';

create table meeting (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    title varchar(30) comment '跨局處會議名稱',
    meeting_type varchar(10) comment '會議類型(單選)',
    start_time date null comment '開始時間',
    chairman varchar(30) comment '主席',
    chairman_background varchar(1000) comment '主席背景',
    note varchar(1000) comment '備註',
    organization mediumint unsigned null comment '所屬機構',
    year bigint null comment '年度'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='跨局處會議';

insert into menu (form_name, column_name, content) values('meeting', 'meeting_type', '跨局處會議');
insert into menu (form_name, column_name, content) values('meeting', 'meeting_type', '預防性講座');

create table funding_approve (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    county bigint unsigned null comment '縣市',
    funding varchar(20) comment '撥付經費',
    date date not null comment '撥付日期',
    note varchar(100) comment '審核備註',
    year bigint null comment '年度'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='撥付經費';

create table timing_report (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    county bigint unsigned null comment '縣市',
    yda bigint unsigned null comment '青年署',
    date date not null comment '繳交日期',
    month bigint null comment '月份',
    year bigint null comment '年度'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='報表繳交時間表';



ALTER TABLE `youth` CHANGE `household_address` `household_address` VARBINARY(255) NULL DEFAULT NULL COMMENT '戶籍地址', 
CHANGE `reside_address` `reside_address` VARBINARY(255) NULL DEFAULT NULL COMMENT '居住地址', 
CHANGE `guardian_household_address` `guardian_household_address` VARBINARY(255) NULL DEFAULT NULL COMMENT '監護人戶籍地址', 
CHANGE `guardian_reside_address` `guardian_reside_address` VARBINARY(255) NULL DEFAULT NULL COMMENT '監護人居住地址';
ALTER TABLE `youth` CHANGE `identification` `identification` VARBINARY(255) NULL DEFAULT NULL COMMENT '身分證';

ALTER TABLE `project` ADD `funding` VARCHAR(20) NULL COMMENT '計畫經費' AFTER `working_hour`;

INSERT INTO `menu` (`no`, `form_name`, `column_name`, `content`) VALUES
(NULL, 'review_log', 'review_status', '批准'),
(NULL, 'review_log', 'review_status', '未批准'),
(NULL, 'review_log', 'review_status', '等待送出'),
(NULL, 'review_process', 'review_status', '批准'),
(NULL, 'review_process', 'review_status', '未批准');
(NULL, 'review_process', 'review_status', '等待送出');
ALTER TABLE `review_log` CHANGE `user_id` `user_id` VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '提交者id';



create table audit (
    no bigint unsigned not null auto_increment primary key comment '流水號',
    id varchar(30) comment '被稽查的ID',
    audit_id varchar(10) comment '稽查人',
    status varchar(10) comment '稽查結果',
    note text comment '備註',
    start_date date null comment '開始時間',
    end_date date null comment '結束時間',
    date date null comment '時間'
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='稽查';

insert into menu (form_name, column_name, content) values('audit', 'status', '通過');
insert into menu (form_name, column_name, content) values('audit', 'status', '不通過');
