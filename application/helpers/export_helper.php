<?php if (!defined('BASEPATH')) {
    
    exit('No direct script access allowed');
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function youth_data($sheet, $countyType, $year, $id, $source) {
  $CI = get_instance();
  $CI->load->model('MenuModel');
  $CI->load->model('YouthModel');
  $CI->load->model('MemberModel');
  $CI->load->model('SeasonalReviewModel');

  $surveyTypes = $CI->MenuModel->get_by_form_and_column('youth', 'survey_type');
  $sources = $CI->MenuModel->get_by_form_and_column('youth', 'source');
  $genders = $CI->MenuModel->get_by_form_and_column('youth', 'gender');
  $juniorSchoolConditions = $CI->MenuModel->get_by_form_and_column('youth', 'junior_school_condition');
  $seniorSchoolConditions = $CI->MenuModel->get_by_form_and_column('youth', 'senior_school_condition');
  $counselIdentitys = $CI->MenuModel->get_by_form_and_column('youth', 'counsel_identity');
  $trends = $CI->MenuModel->get_by_form_and_column_order('seasonal_review', 'trend');

  $noNeedSources = [
    $CI->MenuModel->get_no_resource_by_content('01已就業', 'youth')->no,
    $CI->MenuModel->get_no_resource_by_content('02已就學', 'youth')->no,
    $CI->MenuModel->get_no_resource_by_content('03特教生', 'youth')->no,
    $CI->MenuModel->get_no_resource_by_content('13不可抗力(去世、司法問題、出國)', 'youth')->no,
    $CI->MenuModel->get_no_resource_by_content('13不可抗力(去世)', 'youth')->no,
    $CI->MenuModel->get_no_resource_by_content('13不可抗力(司法問題)', 'youth')->no,
    $CI->MenuModel->get_no_resource_by_content('13不可抗力(出國)', 'youth')->no
  ];

  $counties = $CI->CountyModel->get_all();
  $countyName = "";
  foreach ($counties as $value) {
    if ($value['no'] == $countyType) {
      $countyName = $value['name'];
    }
  }

  foreach ($sources as $s) {
    if ($s['content'] == "轉介或自行開發") {
      $sourceReferral = $s['no'];
    } else if ($s['content'] == "動向調查") {
      $sourceSurvey = $s['no'];
    } else if ($s['content'] == "高中已錄取未註冊") {
      $sourceHigh = $s['no'];
    }
  }

  if($source == 'all') $youths = $CI->YouthModel->get_by_county($countyType, $noNeedSources, $sourceReferral);
  elseif($source == (date('Y')-1911-4 . '_trend')) $youths = $CI->YouthModel->get_by_source_and_county_by_school_year($sourceSurvey, $countyType, $noNeedSources, date('Y')-1911-4);
  elseif($source == (date('Y')-1911-3 . '_trend')) $youths = $CI->YouthModel->get_by_source_and_county_by_school_year($sourceSurvey, $countyType, $noNeedSources, date('Y')-1911-3);
  elseif($source == (date('Y')-1911-2 . '_trend')) $youths = $CI->YouthModel->get_by_source_and_county_by_school_year($sourceSurvey, $countyType, $noNeedSources, date('Y')-1911-2);
  elseif($source == 'high') $youths = $CI->YouthModel->get_by_high_and_county($sourceHigh, $countyType);
  elseif($source == 'referral') $youths = $CI->YouthModel->get_by_high_and_county($sourceReferral, $countyType);

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle($year . '年' . $countyName . '青少年資料');
  $sheet->setCellValue('A1', '流水號');
  $sheet->setCellValue('B1', '系統編號');
  $sheet->getColumnDimension('B')->setWidth(0);
  $sheet->setCellValue('C1', '身分證');
  $sheet->getColumnDimension('C')->setWidth(22);
  $sheet->setCellValue('D1', '姓名');
  $sheet->setCellValue('E1', '生日');
  $sheet->getColumnDimension('E')->setWidth(15);
  $sheet->setCellValue('F1', '性別');
  $sheet->setCellValue('G1', '電話');
  $sheet->getColumnDimension('G')->setWidth(15);
  $sheet->setCellValue('H1', '戶籍地址');
  $sheet->getColumnDimension('H')->setWidth(22);
  $sheet->setCellValue('I1', '居住地址');
  $sheet->getColumnDimension('I')->setWidth(22);
  $sheet->setCellValue('J1', '國中畢業年度');
  $sheet->setCellValue('K1', '國中是否曾有中輟通報紀錄	');
  $sheet->setCellValue('L1', '輔導時身分');
  $sheet->getColumnDimension('L')->setWidth(15);
  $sheet->setCellValue('M1', '國中學歷狀態');
  $sheet->setCellValue('N1', '高中學歷狀態');
  $sheet->setCellValue('O1', '國中學校/年級/科系');
  $sheet->getColumnDimension('O')->setWidth(15);
  $sheet->setCellValue('P1', '高中學校/年級/科系');
  $sheet->getColumnDimension('P')->setWidth(15);

  $sheet->setCellValue('Q1', '監護人姓名');
  $sheet->setCellValue('R1', '監護人關係');
  $sheet->setCellValue('S1', '監護人電話');
  $sheet->setCellValue('T1', '監護人戶籍地址');
  $sheet->getColumnDimension('T')->setWidth(22);
  $sheet->setCellValue('U1', '監護人居住地址');
  $sheet->getColumnDimension('U')->setWidth(22);

  $sheet->setCellValue('V1', '青少年來源');
  $sheet->getColumnDimension('V')->setWidth(15);
  $sheet->setCellValue('W1', '動向調查學年度');
  $sheet->setCellValue('X1', '動向調查類別');
  $sheet->getColumnDimension('X')->setWidth(15);

  $sheet->setCellValue('Y1', '是否進入本計畫輔導');

  $sheet->setCellValue('Z1', '前一次追蹤日期');
  $sheet->setCellValue('AA1', '動向');
  $sheet->setCellValue('AB1', '動向(說明)');

  $count = 1;
  foreach ($youths as $value) {
    $count += 1;

    foreach ($genders as $i) {
      if ($i['no'] == $value['gender']) {
        $value['gender'] = $i['content'];
      }
    }

    if ($value['junior_dropout_record'] == '1') {
      $value['junior_dropout_record'] = '是';
    } else {
      $value['junior_dropout_record'] = '否';
    }

    foreach ($counselIdentitys as $i) {
      if ($i['no'] == $value['counsel_identity']) {
        $value['counsel_identity'] = $i['content'];
      }
    }

    foreach ($juniorSchoolConditions as $i) {
      if ($i['no'] == $value['junior_school_condition']) {
        $value['junior_school_condition'] = $i['content'];
      }
    }

    foreach ($seniorSchoolConditions as $i) {
      if ($i['no'] == $value['senior_school_condition']) {
        $value['senior_school_condition'] = $i['content'];
      }
    }

    foreach ($sources as $i) {
      if ($i['no'] == $value['source']) {
        $value['source'] = $i['content'];
      }
    }

    foreach ($surveyTypes as $i) {
      if ($i['no'] == $value['survey_type']) {
        $value['survey_type'] = $i['content'];
      }
    }

    $seasonalReviews = $CI->SeasonalReviewModel->get_by_youth_one($value['no']);
    $isMember = $CI->MemberModel->is_member($value['no']);

    $sheet->setCellValue('A' . $count, $count - 1);
    $sheet->setCellValue('B' . $count, $value['no']);
    $sheet->setCellValue('C' . $count, $value['identifications']);
    $sheet->setCellValue('D' . $count, $value['name']);
    $sheet->setCellValue('E' . $count, $value['birth']);
    $sheet->setCellValue('F' . $count, $value['gender']);
    $sheet->setCellValue('G' . $count, $value['phone']);
    $sheet->setCellValue('H' . $count, $value['household_address_aes']);
    $sheet->setCellValue('I' . $count, $value['reside_address_aes']);

    $sheet->setCellValue('J' . $count, $value['junior_graduate_year']);
    $sheet->setCellValue('K' . $count, $value['junior_dropout_record']);
    $sheet->setCellValue('L' . $count, $value['counsel_identity']);
    $sheet->setCellValue('M' . $count, $value['junior_school_condition']);
    $sheet->setCellValue('N' . $count, $value['senior_school_condition']);

    $sheet->setCellValue('O' . $count, $value['junior_school']);
    $sheet->setCellValue('P' . $count, $value['senior_school']);
    $sheet->setCellValue('Q' . $count, $value['guardian_name']);
    $sheet->setCellValue('R' . $count, $value['guardianship']);
    $sheet->setCellValue('S' . $count, $value['guardian_phone']);

    $sheet->setCellValue('T' . $count, $value['guardian_household_address_aes']);
    $sheet->setCellValue('U' . $count, $value['guardian_reside_address_aes']);
    $sheet->setCellValue('V' . $count, $value['source']);
    $sheet->setCellValue('W' . $count, $value['source_school_year']);
    $sheet->setCellValue('X' . $count, $value['survey_type']);

    $sheet->setCellValue('Y' . $count, $isMember ? '是' : '否');
    $sheet->setCellValue('Z' . $count, $seasonalReviews ? $seasonalReviews->date : '');

    if ($seasonalReviews) {
      foreach ($trends as $value) {
        if ($value['no'] == $seasonalReviews->trend) {
          $sheet->setCellValue('AA' . $count, $value['content']);
        }
      }
    }

    $sheet->setCellValue('AB' . $count, $seasonalReviews ? $seasonalReviews->trend_description : '');
  }

  $sheet->setCellValue('N' . ($count + 1 ), '資料匯出時間 : ' . date("Y-m-d H:i:s") . ' 匯出人員帳號: ' . $id);
  $sheet->mergeCells('N' . ($count + 1 ) . ':W' . ($count + 1));

  $sheet->setCellValue('A' . ($count + 2 ), '◎本頁內容涉及個人資料部分，請遵守個人資料保護法(下稱個資法)相關規定，其蒐集、處理或利用，不得逾越特定目的之必要範圍。');
  $sheet->mergeCells('A' . ($count + 2 ) . ':W' . ($count + 2));

  $sheet->setCellValue('A' . ($count + 3 ), '◎違反個資法規定，致個人資料遭不法蒐集、處理、利用或其他侵害當事人權利者，負損害賠償責任。');
  $sheet->mergeCells('A' . ($count + 3 ) . ':W' . ($count + 3));

  $sheet->getProtection()->setSheet(true);

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray)-1] . ($count))->applyFromArray($styleArray);

  return $sheet;
}

function yda_month_counselingExecuteReport($sheet, $yearType, $monthType) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('ProjectModel');
  $CI->load->model('CountyModel');
  $CI->load->model('CounselingMemberCountReportModel');
  $CI->load->model('MonthMemberTempCounselingModel');
  $CI->load->model('MemberModel');
  $CI->load->model('UserModel');
  $CI->load->helper('report');

  $countyType = 'all';

  $countiesName = $CI->CountyModel->get_all();

  $executeModes = $CI->MenuModel->get_by_form_and_column('project', 'execute_mode');
  $executeWays = $CI->MenuModel->get_by_form_and_column('project', 'execute_way');
  $qualifications = $CI->MenuModel->get_by_form_and_column('counselor', 'qualification');

  $projectArray = [];
  $projectDetailArray = [];
  $accumCounselingMemberCountArray = [];
  $monthMemberTempCounselingArray = [];
  $executeDetailArray = [];
  $counselingMemberCountReportArray = [];

  if ($countyType == 'all') {
    $counties = $CI->CountyModel->get_all();
  } else {
    $counties = $CI->CountyModel->get_one($countyType);
  }

  foreach ($counties as $county) {
    $projects = $CI->ProjectModel->get_latest_by_county($county['no']);
    array_push($projectArray, $projects);

    $countyAndOrg = $CI->CountyModel->get_by_county($county['no']);
    $counselingMemberCountReport = $CI->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $county['no']);
    array_push($counselingMemberCountReportArray, $counselingMemberCountReport);

    $executeArray = report_one_execute_detail($county['no'], $yearType, $monthType, 'excel');
    $projectDetail = $executeArray['projectDetail'];
    $executeDetail = $executeArray['executeDetail'];

    array_push($projectDetailArray, $projectDetail);

    $accumCounselingMemberCount = $CI->MemberModel->get_by_county_count($county['no'], $monthType, $yearType);
    array_push($accumCounselingMemberCountArray, $accumCounselingMemberCount);

    array_push($executeDetailArray, $executeDetail);
  }

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'P');
  foreach($columnNameArray as $column) {
    if($column != 'B' && $column != 'L') $sheet->getStyle($column)->getAlignment()->setVertical('center');
    if($column != 'B' && $column != 'L') $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    if($column == 'B' || $column == 'L') $sheet->getStyle($column)->getAlignment()->setVertical('top');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle($yearType . '年執行進度表');
  $sheet->setCellValue('A1', '縣市');
  $sheet->mergeCells('A1:A2');
  $sheet->setCellValue('B1', '提案計畫基本資料');
  $sheet->getStyle('B1')->getAlignment()->setVertical('center');
  $sheet->getStyle('B1')->getAlignment()->setHorizontal('center');
  $sheet->mergeCells('B1:B2');
  $sheet->getColumnDimension('B')->setWidth(25);
  $sheet->getColumnDimension('L')->setWidth(50);
  $sheet->getRowDimension('3')->setRowHeight(600);
  $sheet->setCellValue('C1', '預計輔導人數');
  $sheet->mergeCells('C1:C2');
  $sheet->getColumnDimension('C')->setWidth(5);
  $sheet->setCellValue('D1', '累積輔導人數');
  $sheet->mergeCells('D1:D2');
  $sheet->getColumnDimension('D')->setWidth(5);
  $sheet->setCellValue('E1', '關懷輔導成效');
  $sheet->mergeCells('E1:I1');
  $sheet->getStyle('E1:I1')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
  $sheet->setCellValue('E2', '已就學');
  $sheet->getColumnDimension('E')->setWidth(5);
  $sheet->setCellValue('F2', '已就業');
  $sheet->getColumnDimension('F')->setWidth(5);
  $sheet->setCellValue('G2', '參加職訓');
  $sheet->getColumnDimension('G')->setWidth(5);
  $sheet->setCellValue('H2', '其他');
  $sheet->getColumnDimension('H')->setWidth(5);
  $sheet->setCellValue('I2', '小計');
  $sheet->getColumnDimension('I')->setWidth(5);
  $sheet->getStyle('I2')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
 
  $sheet->setCellValue('J1', '尚無規劃輔導中');
  $sheet->mergeCells('J1:J2');
  $sheet->getColumnDimension('J')->setWidth(5);
  $sheet->setCellValue('K1', "不可抗力人數\n（司法安置、出國、死亡）");
  $sheet->mergeCells('K1:K2');
  $sheet->getColumnDimension('K')->setWidth(5);
  $sheet->setCellValue('L1', '辦理情形');
  
  $sheet->mergeCells('L1:P2');
  $sheet->getStyle('L1:P2')->getAlignment()->setVertical('center');
  $sheet->getStyle('L1:P2')->getAlignment()->setHorizontal('center');
  $count = 3;

  for ($i = 0; $i < count($counties); $i++) {
    $sheet->getRowDimension($count)->setRowHeight(600);
    $sheet->setCellValue('A' . $count, $counties[$i]['name']);
    $sheet->mergeCells('A' . $count . ':A' . ($count + 4));
    $sheet->getStyle('A' . $count)->getFont()->getColor()->setARGB(Style\Color::COLOR_RED);

    $sheet->setCellValue('B' . $count, str_replace("<br/>", "\n", $projectDetailArray[$i]));
    $sheet->mergeCells('B' . $count . ':B' . ($count + 4));
    $sheet->getStyle('B' . $count)->getFont()->getColor()->setARGB(Style\Color::COLOR_RED);

    $sheet->setCellValue('C' . $count, $projectArray[$i]->counseling_member);
    $sheet->getStyle('C' . $count)->getFont()->getColor()->setARGB(Style\Color::COLOR_RED);
    $sheet->getStyle('C' . $count)->getAlignment()->setVertical('top');

    $sheet->setCellValue('D' . $count, $accumCounselingMemberCountArray[$i]);
    $sheet->getStyle('D' . $count)->getFont()->getColor()->setARGB(Style\Color::COLOR_RED);
    $sheet->getStyle('D' . $count)->getAlignment()->setVertical('top');

    $sheet->setCellValue('E' . $count, (empty($counselingMemberCountReportArray[$i])) ? "0" : $counselingMemberCountReportArray[$i]->school_member);
    $sheet->getStyle('E' . $count)->getFont()->getColor()->setARGB(Style\Color::COLOR_RED);
    $sheet->getStyle('E' . $count)->getAlignment()->setVertical('top');

    $sheet->setCellValue('F' . $count, (empty($counselingMemberCountReportArray[$i])) ? "0" : $counselingMemberCountReportArray[$i]->work_member);
    $sheet->getStyle('F' . $count)->getFont()->getColor()->setARGB(Style\Color::COLOR_RED);
    $sheet->getStyle('F' . $count)->getAlignment()->setVertical('top');

    $sheet->setCellValue('G' . $count, (empty($counselingMemberCountReportArray[$i])) ? "0" : $counselingMemberCountReportArray[$i]->vocational_training_member);
    $sheet->getStyle('G' . $count)->getFont()->getColor()->setARGB(Style\Color::COLOR_RED);
    $sheet->getStyle('G' . $count)->getAlignment()->setVertical('top');

    $sheet->setCellValue('H' . $count, (empty($counselingMemberCountReportArray[$i])) ? "0" : $counselingMemberCountReportArray[$i]->other_member);
    $sheet->getStyle('H' . $count)->getFont()->getColor()->setARGB(Style\Color::COLOR_RED);
    $sheet->getStyle('H' . $count)->getAlignment()->setVertical('top');

    $sheet->setCellValue('I' . $count, (empty($counselingMemberCountReportArray[$i])) ? "0" : $counselingMemberCountReportArray[$i]->school_member + $counselingMemberCountReportArray[$i]->work_member + $counselingMemberCountReportArray[$i]->vocational_training_member + $counselingMemberCountReportArray[$i]->other_member);
    $sheet->getStyle('I' . $count)->getFont()->getColor()->setARGB(Style\Color::COLOR_RED);
    $sheet->getStyle('I' . $count)->getAlignment()->setVertical('top');
    $sheet->getStyle('I' . $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

    $sheet->setCellValue('J' . $count, (empty($counselingMemberCountReportArray[$i])) ? "0" : $counselingMemberCountReportArray[$i]->no_plan_member);
    $sheet->getStyle('J' . $count)->getFont()->getColor()->setARGB(Style\Color::COLOR_RED);
    $sheet->getStyle('J' . $count)->getAlignment()->setVertical('top');

    $sheet->setCellValue('K' . $count, (empty($counselingMemberCountReportArray[$i])) ? "0" : $counselingMemberCountReportArray[$i]->force_majeure_member);
    $sheet->getStyle('K' . $count)->getFont()->getColor()->setARGB(Style\Color::COLOR_RED);
    $sheet->getStyle('K' . $count)->getAlignment()->setVertical('top');

    $sheet->setCellValue('L' . $count, str_replace("<br/>", "\n", $executeDetailArray[$i]));
    $sheet->mergeCells('L' . $count . ':P' . ($count + 4));

    $count += 5;
  }


  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray)-1] . ($count + 4))->applyFromArray($styleArray);

  return $sheet;
}

function yda_month_counselingMemberCountReport($sheet, $yearType, $monthType) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('ProjectModel');
  $CI->load->model('CountyModel');
  $CI->load->model('CounselingMemberCountReportModel');
  $CI->load->model('MonthMemberTempCounselingModel');
  $CI->load->model('MemberModel');
  $CI->load->model('MonthReviewModel');
  $CI->load->model('SeasonalReviewModel');

  $countyType = 'all';

  $countiesName = $CI->CountyModel->get_all();
  $executeModes = $CI->MenuModel->get_by_form_and_column('project', 'execute_mode');
  $executeWays = $CI->MenuModel->get_by_form_and_column('project', 'execute_way');
  $qualifications = $CI->MenuModel->get_by_form_and_column('counselor', 'qualification');

  $projectArray = [];
  $projectDetailArray = [];
  $accumCounselingMemberCountArray = [];
  $accumCounselingYouthCountArray = [];
  $monthMemberTempCounselingArray = [];
  $executeDetailArray = [];
  $counselingMemberCountReportArray = [];
  $countyAndOrgArray = [];
  $executeModeArray = [];
  $sumArray = [];

  $sumArray['commissionCounselingYouth'] = 0;
  $sumArray['commissionCounselingMember'] = 0;
  $sumArray['commissionAccumCounselingMemberCount'] = 0;
  $sumArray['commissionAccumCounselingYouthCount'] = 0;
  $sumArray['commissionTwoYearSurvryCaseCount'] = 0;
  $sumArray['commissionOneYearSurvryCaseCount'] = 0;
  $sumArray['commissionNowYearSurvryCaseCount'] = 0;
  $sumArray['commissionNextYearSurvryCaseCount'] = 0;
  $sumArray['commissionHighSchoolSurveryCaseCount'] = 0;

  $sumArray['commissionSchoolYouth'] = 0;
  $sumArray['commissionWorkYouth'] = 0;
  $sumArray['commissionVocationalTrainingYouth'] = 0;
  $sumArray['commissionOtherYouth'] = 0;
  $sumArray['commissionNoPlanYouth'] = 0;
  $sumArray['commissionForceMajeureYouth'] = 0;
  $sumArray['commissionSchoolMember'] = 0;
  $sumArray['commissionWorkMember'] = 0;
  $sumArray['commissionVocationalTrainingMember'] = 0;
  $sumArray['commissionOtherMember'] = 0;
  $sumArray['commissionNoPlanMember'] = 0;
  $sumArray['commissionForceMajeureMember'] = 0;
  $sumArray['commissionSum'] = 0;

  $sumArray['commissionNewCaseMember'] = 0;
  $sumArray['commissionOldCaseMember'] = 0;

  $sumArray['selfCounselingYouth'] = 0;
  $sumArray['selfCounselingMember'] = 0;
  $sumArray['selfAccumCounselingMemberCount'] = 0;
  $sumArray['selfAccumCounselingYouthCount'] = 0;
  $sumArray['selfTwoYearSurvryCaseCount'] = 0;
  $sumArray['selfOneYearSurvryCaseCount'] = 0;
  $sumArray['selfNowYearSurvryCaseCount'] = 0;
  $sumArray['selfNextYearSurvryCaseCount'] = 0;
  $sumArray['selfHighSchoolSurveryCaseCount'] = 0;

  $sumArray['selfSchoolYouth'] = 0;
  $sumArray['selfWorkYouth'] = 0;
  $sumArray['selfVocationalTrainingYouth'] = 0;
  $sumArray['selfOtherYouth'] = 0;
  $sumArray['selfNoPlanYouth'] = 0;
  $sumArray['selfForceMajeureYouth'] = 0;
  $sumArray['selfSchoolMember'] = 0;
  $sumArray['selfWorkMember'] = 0;
  $sumArray['selfVocationalTrainingMember'] = 0;
  $sumArray['selfOtherMember'] = 0;
  $sumArray['selfNoPlanMember'] = 0;
  $sumArray['selfForceMajeureMember'] = 0;
  $sumArray['selfSum'] = 0;

  $sumArray['selfNewCaseMember'] = 0;
  $sumArray['selfOldCaseMember'] = 0;

  if ($countyType == 'all') {
    $counties = $CI->CountyModel->get_all();
  } else {
    $counties = $CI->CountyModel->get_one($countyType);
  }

  foreach ($counties as $county) {
    $projects = $CI->ProjectModel->get_latest_by_county($county['no']);
    array_push($projectArray, $projects);

    $countyAndOrg = $CI->CountyModel->get_by_county($county['no']);
    array_push($countyAndOrgArray, $countyAndOrg);
    $counselingMemberCountReport = $CI->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $county['no']);
    array_push($counselingMemberCountReportArray, $counselingMemberCountReport);

    $surveyTypeData = [];
    $surveyTypeData['schoolSource'] = $CI->MenuModel->get_no_resource_by_content('動向調查', 'youth')->no;
    $surveyTypeData['referralSource'] = $CI->MenuModel->get_no_resource_by_content('轉介或自行開發', 'youth')->no;
    $surveyTypeData['highSource'] = $CI->MenuModel->get_no_resource_by_content('高中已錄取未註冊', 'youth')->no;
    $counselEffectionCounts = $CI->ReportModel->get_counsel_effection_by_county($county['no'], $yearType, $surveyTypeData);
    $keepMemberArray = $trendMemberArray = $endMemberArray = [];
    $youths = $CI->YouthModel->get_by_case_trend_and_county($county['no']);
    foreach($youths as $value) {
      $isMember = $CI->MemberModel->is_member($value['no']);
      if ($isMember) {
        array_push($keepMemberArray, $value);    
      }
      else {
        $endDate = $value['end_date'];
        $originMonth = substr($endDate, 5, 2);
        
        $originMonthReview = $originSeasonalReview = 0;
        $value['originMonthReview'] = 0;
        $value['originSeasonalReview'] = 0;
        $value['alreadyMonthReview'] = 0;
        $value['alreadySeasonalReview'] = 0;

        if($originMonth + 6 > 12) {
          $temp = ($originMonth + 6) - 12;
          $originMonthReview = 12 - $originMonth;
          $temp = 6 - $originMonthReview;
          $originSeasonalReview = $temp / 3;
          $originSeasonalReview = ceil($originSeasonalReview);
          $value['originMonthReview'] = $originMonthReview;
          $value['originSeasonalReview'] = $originSeasonalReview;

        } else {
          $originMonthReview = 6;
          $originSeasonalReview = 0;
          $value['originMonthReview'] = $originMonthReview;
          $value['originSeasonalReview'] = $originSeasonalReview;
        }


        $alreadyMonthReview = count($CI->MonthReviewModel->get_by_member($value['memberNo']));
        $alreadySeasonalReview = count($CI->SeasonalReviewModel->get_by_youth($value['no']));
        $value['alreadyMonthReview'] = $alreadyMonthReview;
        $value['alreadySeasonalReview'] = $alreadySeasonalReview;

        $monthReview = $originMonthReview - $alreadyMonthReview;
        $seasonalReview = $originSeasonalReview - $alreadySeasonalReview;

        if($monthReview >= 0 && $seasonalReview >= 0 ) {
          array_push($trendMemberArray, $value); 
        } else {
          array_push($endMemberArray, $value);     
        }
      }
    }

    foreach($counselEffectionCounts as $i) {
      //$youthSum = ($i['schoolSourceCount'] + $i['highSourceCount'] + count($trendMemberArray));
      $youthSum = ($i['schoolSourceCount'] + $i['highSourceCount']);
    }
    array_push($accumCounselingYouthCountArray, $youthSum);

    $countyName = "";
    foreach ($counties as $value) {
      if ($value['no'] == $county['no']) {
        $countyName = $value['name'];
      }
    }

    $executeMode = "";
    $executeWay = "";
    foreach ($executeModes as $value) {
      if ($value['no'] == $projects->execute_mode) {
        $executeMode = $value['content'];
      }
    }
    foreach ($executeWays as $value) {
      if ($value['no'] == $projects->execute_way) {
        $executeWay = $value['content'];
      }
    }

    array_push($executeModeArray, $executeMode);

    $projectDetail = "";
    $projectDetail = $projectDetail . $executeMode . " <br/>";
    $projectDetail = $projectDetail . $executeWay . " <br/>";
    $projectDetail = $projectDetail . $projects->counselor_count . "位專任輔導員、" . "跨局處會議" . $projects->meeting_count . "次、"
      . "生涯探索課程或活動" . $projects->course_hour . "小時、輔導會談" . $projects->counseling_member . "人x" . $projects->counseling_hour
      . "小時 = " . ($projects->counseling_member * $projects->counseling_hour) . "小時、工作體驗" . $projects->working_member . "人x" . $projects->working_hour
      . "小時 = " . ($projects->working_member * $projects->working_hour) . "小時、後續關懷追蹤六個月<br/>";
    $projectDetail = $projectDetail . "承辦單位 : " . $countyAndOrg->orgnizer . "<br/>";
    $projectDetail = $projectDetail . "執行單位 : " . $countyAndOrg->organizationName . "<br/>";

    array_push($projectDetailArray, $projectDetail);

    $accumCounselingMemberCount = $CI->MemberModel->get_by_county_count($county['no'], $monthType, $yearType);
    array_push($accumCounselingMemberCountArray, $accumCounselingMemberCount);

    $monthMemberTempNote = $CI->MonthMemberTempCounselingModel->get_by_county_and_month($county['no'], $monthType, $yearType);
    $twoYearSurvryCaseCount = empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->two_year_survry_case_member;
    $oneYearSurvryCaseCount = empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->one_year_survry_case_member;
    $nowYearSurvryCaseCount = empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->now_year_survry_case_member;
    $nextYearSurvryCaseCount = empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->next_year_survry_case_member;
    $highSchoolSurveryCaseCount = empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->high_school_survry_case_member;

    if ($executeWay == '委辦') {
      $sumArray['commissionCounselingYouth'] += $projects->counseling_youth; //TODO
      $sumArray['commissionCounselingMember'] += $projects->counseling_member;
      $sumArray['commissionAccumCounselingMemberCount'] += $accumCounselingMemberCount;
      $sumArray['commissionAccumCounselingYouthCount'] += $youthSum;
      $sumArray['commissionTwoYearSurvryCaseCount'] += $twoYearSurvryCaseCount;
      $sumArray['commissionOneYearSurvryCaseCount'] += $oneYearSurvryCaseCount;
      $sumArray['commissionNowYearSurvryCaseCount'] += $twoYearSurvryCaseCount;
      $sumArray['commissionNextYearSurvryCaseCount'] += $nextYearSurvryCaseCount;
      $sumArray['commissionHighSchoolSurveryCaseCount'] += $highSchoolSurveryCaseCount;

      $sumArray['commissionSchoolYouth'] += empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->school_youth;
      $sumArray['commissionWorkYouth'] += empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->work_youth;
      $sumArray['commissionVocationalTrainingYouth'] += empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->vocational_training_youth;
      $sumArray['commissionOtherYouth'] += empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->other_youth;
      $sumArray['commissionNoPlanYouth'] += empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->no_plan_youth;
      $sumArray['commissionForceMajeureYouth'] += empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->force_majeure_youth;

      $sumArray['commissionSchoolMember'] += empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->school_member;
      $sumArray['commissionWorkMember'] += empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->work_member;
      $sumArray['commissionVocationalTrainingMember'] += empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->vocational_training_member;
      $sumArray['commissionOtherMember'] += empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->other_member;
      $sumArray['commissionNoPlanMember'] += empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->no_plan_member;
      $sumArray['commissionForceMajeureMember'] += empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->force_majeure_member;
      $sumArray['commissionNewCaseMember'] += empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->new_case_member;
      $sumArray['commissionOldCaseMember'] += empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->old_case_member;
    } else {
      $sumArray['selfCounselingYouth'] += $projects->counseling_youth; //TODO
      $sumArray['selfCounselingMember'] += $projects->counseling_member;
      $sumArray['selfAccumCounselingMemberCount'] += $accumCounselingMemberCount;
      $sumArray['selfAccumCounselingYouthCount'] += $youthSum;
      $sumArray['selfTwoYearSurvryCaseCount'] += $twoYearSurvryCaseCount;
      $sumArray['selfOneYearSurvryCaseCount'] += $oneYearSurvryCaseCount;
      $sumArray['selfNowYearSurvryCaseCount'] += $twoYearSurvryCaseCount;
      $sumArray['selfNextYearSurvryCaseCount'] += $nextYearSurvryCaseCount;
      $sumArray['selfHighSchoolSurveryCaseCount'] += $highSchoolSurveryCaseCount;

      $sumArray['selfSchoolYouth'] += empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->school_youth;
      $sumArray['selfWorkYouth'] += empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->work_youth;
      $sumArray['selfVocationalTrainingYouth'] += empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->vocational_training_youth;
      $sumArray['selfOtherYouth'] += empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->other_youth;
      $sumArray['selfNoPlanYouth'] += empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->no_plan_youth;
      $sumArray['selfForceMajeureYouth'] += empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->force_majeure_youth;

      $sumArray['selfSchoolMember'] += empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->school_member;
      $sumArray['selfWorkMember'] += empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->work_member;
      $sumArray['selfVocationalTrainingMember'] += empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->vocational_training_member;
      $sumArray['selfOtherMember'] += empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->other_member;
      $sumArray['selfNoPlanMember'] += empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->no_plan_member;
      $sumArray['selfForceMajeureMember'] += empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->force_majeure_member;
      $sumArray['selfNewCaseMember'] += empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->new_case_member;
      $sumArray['selfOldCaseMember'] += empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->old_case_member;
    }

    $forceMajeureNote = empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->force_majeure_note;
    $workTrainningNote = empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->work_trainning_note;
  }

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle('表一.輔導人數統計表');
  $sheet->setCellValue('A1', $yearType . '年青少年生涯探索號計畫' . $monthType . '月輔導人數統計表');
  $sheet->mergeCells('A1:AD1');
  $sheet->getRowDimension('1')->setRowHeight(25);
  $sheet->getStyle('A1')->getFont()->setBold(true);
  $sheet->setCellValue('AE1', '統計日期：');
  $sheet->mergeCells('AE1:AF1');
  $sheet->setCellValue('A2', '縣市');
  $sheet->mergeCells('A2:A4');
  $sheet->getColumnDimension('A')->setWidth(15);

  $sheet->setCellValue('B2', 'A累積關懷追蹤人數');
  $sheet->mergeCells('B2:D3');
  $sheet->getColumnDimension('B')->setWidth(7);
  $sheet->getColumnDimension('C')->setWidth(10);
  $sheet->getColumnDimension('D')->setWidth(10);

  $sheet->setCellValue('B4', 'B關懷人數');
  $sheet->getStyle('B4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
  
  $sheet->setCellValue('C4', 'C累積輔導人數(核定輔導人數)');
  $sheet->mergeCells('C4:D4');
  $sheet->getStyle('C4:D4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

  $sheet->setCellValue('E2', '關懷輔導成效');
  $sheet->mergeCells('E2:N2');

  $sheet->setCellValue('E3', '就學');
  $sheet->mergeCells('E3:F3');

  $sheet->setCellValue('E4', '關懷');
  $sheet->getStyle('E4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
  $sheet->setCellValue('F4', '輔導');
  $sheet->getStyle('F4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

  $sheet->setCellValue('G3', '就業');
  $sheet->mergeCells('G3:H3');
  $sheet->setCellValue('G4', '關懷');
  $sheet->getStyle('G4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
  $sheet->setCellValue('H4', '輔導');
  $sheet->getStyle('H4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

  $sheet->setCellValue('I3', '參加職訓');
  $sheet->mergeCells('I3:J3');
  $sheet->setCellValue('I4', '關懷');
  $sheet->getStyle('I4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
  $sheet->setCellValue('J4', '輔導');
  $sheet->getStyle('J4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

  $sheet->setCellValue('K3', '其他');
  $sheet->mergeCells('K3:L3');
  $sheet->setCellValue('K4', '關懷');
  $sheet->getStyle('K4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
  $sheet->setCellValue('L4', '輔導');
  $sheet->getStyle('L4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

  $sheet->setCellValue('M3', "小計\na");
  $sheet->mergeCells('M3:N3');
  $sheet->setCellValue('M4', '關懷');
  $sheet->getStyle('M4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
  $sheet->setCellValue('N4', '輔導');
  $sheet->getStyle('N4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

  $sheet->setCellValue('O2', "尚無動向或失聯\nb");
  $sheet->mergeCells('O2:P3');
  $sheet->getColumnDimension('O')->setWidth(13);
  $sheet->setCellValue('O4', '關懷');
  $sheet->getStyle('O4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
  $sheet->setCellValue('P4', '輔導');
  $sheet->getStyle('P4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

  $sheet->setCellValue('S2', "總計");
  $sheet->mergeCells('S2:S4');
  $sheet->getColumnDimension('S')->setWidth(0);

  $sheet->setCellValue('Q2', "不可抗力人數\n（司法安置、出國、死亡）\nc");
  $sheet->mergeCells('Q2:R3');
  $sheet->getColumnDimension('Q')->setWidth(13);
  $sheet->setCellValue('Q4', '關懷');
  $sheet->getStyle('Q4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
  $sheet->setCellValue('R4', '輔導');
  $sheet->getStyle('R4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

  $sheet->setCellValue('T2', '輔導對象來源');
  $sheet->mergeCells('T2:W2');
  $sheet->getStyle('T2:V2')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ebf1de');

  $sheet->setCellValue('T3', "本年度新開\n案個案人數");
  $sheet->getStyle('T3:T4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ebf1de');
  $sheet->getColumnDimension('T')->setWidth(13);
  $sheet->mergeCells('T3:T4');

  $sheet->setCellValue('U3', "前一年度持\n續輔導人數");
  $sheet->getColumnDimension('U')->setWidth(13);
  $sheet->mergeCells('U3:U4');

  $sheet->setCellValue('V3', "國中動向調查結\n果輔導人數");
  $sheet->getColumnDimension('V')->setWidth(13);
  $sheet->mergeCells('V3:V4');

  $sheet->setCellValue('W3', "高中已錄取未註冊動向調查結果輔導人數");
  $sheet->getColumnDimension('W')->setWidth(13);
  $sheet->mergeCells('W3:W4');

  $sheet->setCellValue('X2', '動向調查人數(學年度)');
  $sheet->mergeCells('X2:AB2');
  $sheet->getStyle('X2:AB2')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e4dfec');

  $sheet->setCellValue('X3', '國中未升學未就業動向調查');
  $sheet->getStyle('X3')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e4dfec');

  $sheet->setCellValue('AB3', '高中已錄取未註冊動向調查');
  $sheet->getStyle('AB3')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e4dfec');
  $sheet->getColumnDimension('AB')->setWidth(15);

  $sheet->setCellValue('X4', ($yearType - 4));
  $sheet->getStyle('X4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e4dfec');
  $sheet->getColumnDimension('X')->setWidth(10);
  $sheet->mergeCells('X3:AA3');
  $sheet->setCellValue('Y4', ($yearType - 3));
  $sheet->getStyle('Y4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e4dfec');
  $sheet->getColumnDimension('Y')->setWidth(10);
  //$sheet->mergeCells('Y3:Y4');
  $sheet->setCellValue('Z4', ($yearType - 2));
  $sheet->getStyle('Z4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e4dfec');
  $sheet->getColumnDimension('Z')->setWidth(10);
  //$sheet->mergeCells('Z3:Z4');
  $sheet->setCellValue('AA4', ($yearType - 1));
  $sheet->getStyle('AA4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e4dfec');
  $sheet->getColumnDimension('AA')->setWidth(0);
  //$sheet->mergeCells('AA3:AA4');
  $sheet->setCellValue('AB4', ($yearType - 1));
  $sheet->getStyle('AB4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e4dfec');
  $sheet->getColumnDimension('AB')->setWidth(10);
  //$sheet->mergeCells('AB3:AB4');
  $sheet->setCellValue('AC2', '備註');
  $sheet->mergeCells('AC2:AC4');
  $sheet->getColumnDimension('AC')->setWidth(20);
  $sheet->setCellValue('AD2', '辦理模式');
  $sheet->mergeCells('AD2:AD4');
  $sheet->setCellValue('AE2', '承辦單位');
  $sheet->mergeCells('AE2:AE4');
  $sheet->getColumnDimension('AE')->setWidth(20);
  $sheet->setCellValue('AF2', '執行單位');
  $sheet->mergeCells('AF2:AF4');
  $sheet->getColumnDimension('AF')->setWidth(25);

  $count = 5;

  for ($i = 0; $i < count($counties); $i++) {
    $sheet->setCellValue('A' . $count, $counties[$i]['name']);
    $sheet->mergeCells('A' . $count . ':A' . ($count+1));


    $sheet->setCellValue('B' . $count, $projectArray[$i]->counseling_youth);
    $sheet->mergeCells('B' . $count . ':D' . $count);

    $sheet->setCellValue('B' . ($count + 1), $accumCounselingYouthCountArray[$i]); //TODO
    $sheet->getStyle('B' . ($count + 1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
    

    $sheet->setCellValue('C' . ($count + 1), $accumCounselingMemberCountArray[$i] . '(' . $projectArray[$i]->counseling_member . ')');
    $sheet->mergeCells('C' . ($count+1) . ':D' . ($count+1));
    $sheet->getStyle('C' . ($count+1) . ':D' . ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

    $sheet->setCellValue('E' . $count, $counselingMemberCountReportArray[$i] ? ($counselingMemberCountReportArray[$i]->school_youth + $counselingMemberCountReportArray[$i]->school_member) : '0');
    $sheet->mergeCells('E' . $count . ':F' . $count);
    $sheet->setCellValue('E' . ($count+1), $counselingMemberCountReportArray[$i] ? $counselingMemberCountReportArray[$i]->school_youth : '0');
    $sheet->getStyle('E'. ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
    $sheet->setCellValue('F' . ($count+1), $counselingMemberCountReportArray[$i] ? $counselingMemberCountReportArray[$i]->school_member : '0');
    $sheet->getStyle('F'. ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

    $sheet->setCellValue('G' . $count, $counselingMemberCountReportArray[$i] ? ($counselingMemberCountReportArray[$i]->work_youth + $counselingMemberCountReportArray[$i]->work_member) : '0');
    $sheet->mergeCells('G' . $count . ':H' . $count);
    $sheet->setCellValue('G' . ($count+1), $counselingMemberCountReportArray[$i] ? $counselingMemberCountReportArray[$i]->work_youth : '0');
    $sheet->getStyle('G'. ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
    $sheet->setCellValue('H' . ($count+1), $counselingMemberCountReportArray[$i] ? $counselingMemberCountReportArray[$i]->work_member : '0');
    $sheet->getStyle('H'. ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

    $sheet->setCellValue('I' . $count, $counselingMemberCountReportArray[$i] ? ($counselingMemberCountReportArray[$i]->vocational_training_youth + $counselingMemberCountReportArray[$i]->vocational_training_member) : '0');
    $sheet->mergeCells('I' . $count . ':J' . $count);
    $sheet->setCellValue('I' . ($count+1), $counselingMemberCountReportArray[$i] ? $counselingMemberCountReportArray[$i]->vocational_training_youth : '0');
    $sheet->getStyle('I'. ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
    $sheet->setCellValue('J' . ($count+1), $counselingMemberCountReportArray[$i] ? $counselingMemberCountReportArray[$i]->vocational_training_member : '0');
    $sheet->getStyle('J'. ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

    $sheet->setCellValue('K' . $count, $counselingMemberCountReportArray[$i] ? ($counselingMemberCountReportArray[$i]->other_youth + $counselingMemberCountReportArray[$i]->other_member) : '0');
    $sheet->mergeCells('K' . $count . ':L' . $count);
    $sheet->setCellValue('K' . ($count+1), $counselingMemberCountReportArray[$i] ? $counselingMemberCountReportArray[$i]->other_youth : '0');
    $sheet->getStyle('K'. ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
    $sheet->setCellValue('L' . ($count+1), $counselingMemberCountReportArray[$i] ? $counselingMemberCountReportArray[$i]->other_member : '0');
    $sheet->getStyle('L'. ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

    $sheet->setCellValue('M' . $count, $counselingMemberCountReportArray[$i] ? ($counselingMemberCountReportArray[$i]->school_youth + $counselingMemberCountReportArray[$i]->school_member 
                                        + $counselingMemberCountReportArray[$i]->other_youth + $counselingMemberCountReportArray[$i]->other_member
                                        + $counselingMemberCountReportArray[$i]->work_youth + $counselingMemberCountReportArray[$i]->work_member
                                        + $counselingMemberCountReportArray[$i]->vocational_training_youth + $counselingMemberCountReportArray[$i]->vocational_training_member) : '0');
    $sheet->mergeCells('M' . $count . ':N' . $count);
    $sheet->setCellValue('M' . ($count+1), $counselingMemberCountReportArray[$i] ? ($counselingMemberCountReportArray[$i]->school_youth + $counselingMemberCountReportArray[$i]->other_youth
                                            + $counselingMemberCountReportArray[$i]->work_youth + $counselingMemberCountReportArray[$i]->vocational_training_youth) : '0');
    $sheet->getStyle('M'. ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
    $sheet->setCellValue('N' . ($count+1), $counselingMemberCountReportArray[$i] ? ($counselingMemberCountReportArray[$i]->school_member + $counselingMemberCountReportArray[$i]->other_member
                                            + $counselingMemberCountReportArray[$i]->work_member + $counselingMemberCountReportArray[$i]->vocational_training_member) : '0');
    $sheet->getStyle('N'. ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
    
    $sheet->setCellValue('O' . $count, $counselingMemberCountReportArray[$i] ? ($counselingMemberCountReportArray[$i]->no_plan_youth + $counselingMemberCountReportArray[$i]->no_plan_member) : '0');
    $sheet->mergeCells('O' . $count . ':P' . $count);
    $sheet->setCellValue('O' . ($count+1), $counselingMemberCountReportArray[$i] ? $counselingMemberCountReportArray[$i]->no_plan_youth : '0');
    $sheet->getStyle('O'. ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
    $sheet->setCellValue('P' . ($count+1), $counselingMemberCountReportArray[$i] ? $counselingMemberCountReportArray[$i]->no_plan_member : '0');
    $sheet->getStyle('P'. ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

    $sheet->setCellValue('Q' . $count, $counselingMemberCountReportArray[$i] ? ($counselingMemberCountReportArray[$i]->force_majeure_youth + $counselingMemberCountReportArray[$i]->force_majeure_member) : '0');
    $sheet->mergeCells('Q' . $count . ':R' . $count);
    $sheet->setCellValue('Q' . ($count+1), $counselingMemberCountReportArray[$i] ? $counselingMemberCountReportArray[$i]->force_majeure_youth: '0');
    $sheet->getStyle('Q'. ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
    $sheet->setCellValue('R' . ($count+1), $counselingMemberCountReportArray[$i] ? $counselingMemberCountReportArray[$i]->force_majeure_member: '0');
    $sheet->getStyle('R'. ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

    $sheet->setCellValue('S' . $count, $counselingMemberCountReportArray[$i] ? ($counselingMemberCountReportArray[$i]->school_youth + $counselingMemberCountReportArray[$i]->school_member 
                                        + $counselingMemberCountReportArray[$i]->other_youth + $counselingMemberCountReportArray[$i]->other_member
                                        + $counselingMemberCountReportArray[$i]->work_youth + $counselingMemberCountReportArray[$i]->work_member
                                        + $counselingMemberCountReportArray[$i]->vocational_training_youth + $counselingMemberCountReportArray[$i]->vocational_training_member
                                        + $counselingMemberCountReportArray[$i]->no_plan_youth + $counselingMemberCountReportArray[$i]->no_plan_member
                                        + $counselingMemberCountReportArray[$i]->force_majeure_youth + $counselingMemberCountReportArray[$i]->force_majeure_member) : '0');
    $sheet->mergeCells('S' . $count . ':S' . ($count+1));

    $sheet->setCellValue('T' . $count, $counselingMemberCountReportArray[$i] ? $counselingMemberCountReportArray[$i]->new_case_member: '0');
    $sheet->mergeCells('T' . $count . ':T' . ($count+1));
    $sheet->getStyle('T' . $count . ':T' . ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ebf1de');

    $sheet->setCellValue('U' . $count, $counselingMemberCountReportArray[$i] ? $counselingMemberCountReportArray[$i]->old_case_member: '0');
    $sheet->mergeCells('U' . $count . ':U' . ($count+1));

    $sheet->setCellValue('V' . $count, $counselingMemberCountReportArray[$i] ? ($counselingMemberCountReportArray[$i]->two_year_survry_case_member + $counselingMemberCountReportArray[$i]->one_year_survry_case_member 
                                        + $counselingMemberCountReportArray[$i]->now_year_survry_case_member + $counselingMemberCountReportArray[$i]->next_year_survry_case_member) : '0');
    $sheet->mergeCells('V' . $count . ':V' . ($count+1));

    $sheet->setCellValue('W' . $count, $counselingMemberCountReportArray[$i] ? $counselingMemberCountReportArray[$i]->high_school_survry_case_member : '0');
    $sheet->mergeCells('W' . $count . ':W' . ($count+1));
    
    $sheet->setCellValue('X' . $count, $counselingMemberCountReportArray[$i] ? $counselingMemberCountReportArray[$i]->two_year_survry_case_member : '0');
    $sheet->mergeCells('X' . $count . ':X' . ($count+1));

    $sheet->setCellValue('Y' . $count, $counselingMemberCountReportArray[$i] ? $counselingMemberCountReportArray[$i]->one_year_survry_case_member : '0');
    $sheet->mergeCells('Y' . $count . ':Y' . ($count+1));

    $sheet->setCellValue('Z' . $count, $counselingMemberCountReportArray[$i] ? $counselingMemberCountReportArray[$i]->now_year_survry_case_member : '0');
    $sheet->mergeCells('Z' . $count . ':Z' . ($count+1));

    $sheet->setCellValue('AA' . $count, $counselingMemberCountReportArray[$i] ? $counselingMemberCountReportArray[$i]->next_year_survry_case_member : '0');
    $sheet->mergeCells('AA' . $count . ':AA' . ($count+1));

    $sheet->setCellValue('AB' . $count, $counselingMemberCountReportArray[$i] ? $counselingMemberCountReportArray[$i]->high_school_survry_case_member : '0');
    $sheet->mergeCells('AB' . $count . ':AB' . ($count+1));

    $sheet->setCellValue('AC' . $count, $counselingMemberCountReportArray[$i] ? $counselingMemberCountReportArray[$i]->other_note : '無資料');
    $sheet->getStyle('AC' . $count)->getFont()->getColor()->setARGB(Style\Color::COLOR_RED);
    $sheet->mergeCells('AC' . $count . ':AC' . ($count+1));
    
    $sheet->setCellValue('AD' . $count, substr($executeModeArray[$i], 0, 9));
    $sheet->mergeCells('AD' . $count . ':AD' . ($count+1));

    $sheet->setCellValue('AE' . $count, $countyAndOrgArray[$i]->orgnizer);
    $sheet->mergeCells('AE' . $count . ':AE' . ($count+1));

    $sheet->setCellValue('AF' . $count, $countyAndOrgArray[$i]->organizationName);
    $sheet->mergeCells('AF' . $count . ':AF' . ($count+1));

    $count+=2;
  }

 

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column . $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('b8cce4');
  }

  $sheet->setCellValue('A' . ($count), '合計');
 
  $sheet->setCellValue('B' . ($count), $sumArray['commissionAccumCounselingYouthCount'] + $sumArray['selfAccumCounselingYouthCount']);
  $sheet->setCellValue('D' . ($count), $sumArray['commissionCounselingMember'] + $sumArray['selfCounselingMember']);
  $sheet->setCellValue('C' . ($count), $sumArray['commissionAccumCounselingMemberCount'] + $sumArray['selfAccumCounselingMemberCount']);
  
  $sheet->setCellValue('E' . ($count), $sumArray['commissionSchoolYouth'] + $sumArray['selfSchoolYouth']);
  $sheet->setCellValue('F' . ($count), $sumArray['commissionSchoolMember'] + $sumArray['selfSchoolMember']);

  $sheet->setCellValue('G' . ($count), $sumArray['commissionWorkYouth'] + $sumArray['selfWorkYouth']);
  $sheet->setCellValue('H' . ($count), $sumArray['commissionWorkMember'] + $sumArray['selfWorkMember']);

  $sheet->setCellValue('I' . ($count), $sumArray['commissionVocationalTrainingYouth'] + $sumArray['selfVocationalTrainingYouth']);
  $sheet->setCellValue('J' . ($count), $sumArray['commissionVocationalTrainingMember'] + $sumArray['selfVocationalTrainingMember']);
  
  $sheet->setCellValue('K' . ($count), $sumArray['commissionOtherYouth'] + $sumArray['selfOtherYouth']);
  $sheet->setCellValue('L' . ($count), $sumArray['commissionOtherMember'] + $sumArray['selfOtherMember']);


  $sheet->setCellValue('M' . ($count), $sumArray['commissionSchoolYouth'] + $sumArray['selfSchoolYouth'] + $sumArray['commissionWorkYouth'] 
    + $sumArray['selfWorkYouth'] + $sumArray['commissionVocationalTrainingYouth'] + $sumArray['selfVocationalTrainingYouth'] 
    + $sumArray['commissionOtherYouth'] + $sumArray['selfOtherYouth']);
  $sheet->setCellValue('N' . ($count), $sumArray['commissionSchoolMember'] + $sumArray['selfSchoolMember'] + $sumArray['commissionWorkMember'] 
    + $sumArray['selfWorkMember'] + $sumArray['commissionVocationalTrainingMember'] + $sumArray['selfVocationalTrainingMember'] 
    + $sumArray['commissionOtherMember'] + $sumArray['selfOtherMember']);

  $sheet->setCellValue('O' . ($count), $sumArray['commissionNoPlanYouth'] + $sumArray['selfNoPlanYouth']);
  $sheet->setCellValue('P' . ($count), $sumArray['commissionNoPlanMember'] + $sumArray['selfNoPlanMember']);

  $sheet->setCellValue('Q' . ($count), $sumArray['commissionForceMajeureYouth'] + $sumArray['selfForceMajeureYouth']);
  $sheet->setCellValue('R' . ($count), $sumArray['commissionForceMajeureMember'] + $sumArray['selfForceMajeureMember']);
  
  
  $sheet->setCellValue('T' . ($count), $sumArray['commissionNewCaseMember'] + $sumArray['selfNewCaseMember']);

  
  $sheet->setCellValue('U' . ($count), $sumArray['commissionOldCaseMember'] + $sumArray['selfOldCaseMember']);
  $sheet->setCellValue('V' . ($count), $sumArray['commissionTwoYearSurvryCaseCount'] + $sumArray['selfTwoYearSurvryCaseCount'] + $sumArray['commissionOneYearSurvryCaseCount'] 
    + $sumArray['selfOneYearSurvryCaseCount'] + $sumArray['commissionNowYearSurvryCaseCount'] + $sumArray['selfNowYearSurvryCaseCount'] 
    + $sumArray['commissionNextYearSurvryCaseCount'] + $sumArray['selfNextYearSurvryCaseCount']);
  $sheet->setCellValue('W' . ($count), $sumArray['commissionHighSchoolSurveryCaseCount'] + $sumArray['selfHighSchoolSurveryCaseCount']);
  $sheet->setCellValue('X' . ($count), $sumArray['commissionTwoYearSurvryCaseCount'] + $sumArray['selfTwoYearSurvryCaseCount']);
  $sheet->setCellValue('Y' . ($count), $sumArray['commissionOneYearSurvryCaseCount'] + $sumArray['selfOneYearSurvryCaseCount']);
  $sheet->setCellValue('Z' . ($count), $sumArray['commissionNowYearSurvryCaseCount'] + $sumArray['selfNowYearSurvryCaseCount']);
  $sheet->setCellValue('AA' . ($count), $sumArray['commissionNextYearSurvryCaseCount'] + $sumArray['selfNextYearSurvryCaseCount']);
  $sheet->setCellValue('AB' . ($count), $sumArray['commissionHighSchoolSurveryCaseCount'] + $sumArray['selfHighSchoolSurveryCaseCount']);
  $sheet->mergeCells('AC' . $count . ':AE' . ($count+2));

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column . ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e4dfec');
    $sheet->getStyle($column . ($count+2))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e4dfec');
  }

  $sheet->setCellValue('A' . ($count + 1), '委辦');
  $sheet->setCellValue('B' . ($count + 1), $sumArray['commissionAccumCounselingYouthCount']);
  $sheet->setCellValue('D' . ($count + 1), $sumArray['commissionCounselingMember']);
  $sheet->setCellValue('C' . ($count + 1), $sumArray['commissionAccumCounselingMemberCount']);
  
  $sheet->setCellValue('E' . ($count + 1), $sumArray['commissionSchoolYouth']);
  $sheet->setCellValue('F' . ($count + 1), $sumArray['commissionSchoolMember']);

  $sheet->setCellValue('G' . ($count + 1), $sumArray['commissionWorkYouth']);
  $sheet->setCellValue('H' . ($count + 1), $sumArray['commissionWorkMember']);

  $sheet->setCellValue('I' . ($count + 1), $sumArray['commissionVocationalTrainingYouth']);
  $sheet->setCellValue('J' . ($count + 1), $sumArray['commissionVocationalTrainingMember']);
  
  $sheet->setCellValue('K' . ($count + 1), $sumArray['commissionOtherYouth']);
  $sheet->setCellValue('L' . ($count + 1), $sumArray['commissionOtherMember']);


  $sheet->setCellValue('M' . ($count + 1), $sumArray['commissionSchoolYouth'] + $sumArray['commissionWorkYouth'] 
    + $sumArray['commissionVocationalTrainingYouth'] + $sumArray['commissionOtherYouth']);
  $sheet->setCellValue('N' . ($count + 1), $sumArray['commissionSchoolMember'] + $sumArray['commissionWorkMember'] 
    + $sumArray['commissionVocationalTrainingMember'] + $sumArray['commissionOtherMember']);

  $sheet->setCellValue('O' . ($count + 1), $sumArray['commissionNoPlanYouth']);
  $sheet->setCellValue('P' . ($count + 1), $sumArray['commissionNoPlanMember'] );

  $sheet->setCellValue('Q' . ($count + 1), $sumArray['commissionForceMajeureYouth']);
  $sheet->setCellValue('R' . ($count + 1), $sumArray['commissionForceMajeureMember']);
  
  
  $sheet->setCellValue('T' . ($count + 1), $sumArray['commissionNewCaseMember']);

  
  $sheet->setCellValue('U' . ($count + 1), $sumArray['commissionOldCaseMember']);
  $sheet->setCellValue('V' . ($count + 1), $sumArray['commissionTwoYearSurvryCaseCount']+ $sumArray['commissionOneYearSurvryCaseCount'] 
    + $sumArray['commissionNowYearSurvryCaseCount'] + $sumArray['commissionNextYearSurvryCaseCount']);
  $sheet->setCellValue('W' . ($count + 1), $sumArray['commissionHighSchoolSurveryCaseCount']);
  $sheet->setCellValue('X' . ($count + 1), $sumArray['commissionTwoYearSurvryCaseCount']);
  $sheet->setCellValue('Y' . ($count + 1), $sumArray['commissionOneYearSurvryCaseCount']);
  $sheet->setCellValue('Z' . ($count + 1), $sumArray['commissionNowYearSurvryCaseCount']);
  $sheet->setCellValue('AA' . ($count + 1), $sumArray['commissionNextYearSurvryCaseCount']);
  $sheet->setCellValue('AB' . ($count + 1), $sumArray['commissionHighSchoolSurveryCaseCount']);

  $sheet->setCellValue('A' . ($count + 2), '自辦');
  $sheet->setCellValue('B' . ($count + 2), $sumArray['selfAccumCounselingYouthCount']);
  $sheet->setCellValue('D' . ($count + 2), $sumArray['selfCounselingMember']);
  $sheet->setCellValue('C' . ($count + 2), $sumArray['selfAccumCounselingMemberCount']);
  
  $sheet->setCellValue('E' . ($count + 2), $sumArray['selfSchoolYouth']);
  $sheet->setCellValue('F' . ($count + 2), $sumArray['selfSchoolMember']);

  $sheet->setCellValue('G' . ($count + 2), $sumArray['selfWorkYouth']);
  $sheet->setCellValue('H' . ($count + 2), $sumArray['selfWorkMember']);

  $sheet->setCellValue('I' . ($count + 2), $sumArray['selfVocationalTrainingYouth']);
  $sheet->setCellValue('J' . ($count + 2), $sumArray['selfVocationalTrainingMember']);
  
  $sheet->setCellValue('K' . ($count + 2), $sumArray['selfOtherYouth']);
  $sheet->setCellValue('L' . ($count + 2), $sumArray['selfOtherMember']);


  $sheet->setCellValue('M' . ($count + 2), $sumArray['selfSchoolYouth'] + $sumArray['selfWorkYouth'] 
    + $sumArray['selfVocationalTrainingYouth'] + $sumArray['selfOtherYouth']);
  $sheet->setCellValue('N' . ($count + 2), $sumArray['selfSchoolMember'] + $sumArray['selfWorkMember'] 
    + $sumArray['selfVocationalTrainingMember'] + $sumArray['selfOtherMember']);

  $sheet->setCellValue('O' . ($count + 2), $sumArray['selfNoPlanYouth']);
  $sheet->setCellValue('P' . ($count + 2), $sumArray['selfNoPlanMember'] );

  $sheet->setCellValue('Q' . ($count + 2), $sumArray['selfForceMajeureYouth']);
  $sheet->setCellValue('R' . ($count + 2), $sumArray['selfForceMajeureMember']);
  
  
  $sheet->setCellValue('T' . ($count + 2), $sumArray['selfNewCaseMember']);

  
  $sheet->setCellValue('U' . ($count + 2), $sumArray['selfOldCaseMember']);
  $sheet->setCellValue('V' . ($count + 2), $sumArray['selfTwoYearSurvryCaseCount']+ $sumArray['selfOneYearSurvryCaseCount'] 
    + $sumArray['selfNowYearSurvryCaseCount'] + $sumArray['selfNextYearSurvryCaseCount']);
  $sheet->setCellValue('W' . ($count + 2), $sumArray['selfHighSchoolSurveryCaseCount']);
  $sheet->setCellValue('X' . ($count + 2), $sumArray['selfTwoYearSurvryCaseCount']);
  $sheet->setCellValue('Y' . ($count + 2), $sumArray['selfOneYearSurvryCaseCount']);
  $sheet->setCellValue('Z' . ($count + 2), $sumArray['selfNowYearSurvryCaseCount']);
  $sheet->setCellValue('AA' . ($count + 2), $sumArray['selfNextYearSurvryCaseCount']);
  $sheet->setCellValue('AB' . ($count + 2), $sumArray['selfHighSchoolSurveryCaseCount']);

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE');
  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray)-1] . ($count+2))->applyFromArray($styleArray);

  return $sheet;
}

function yda_month_CounselingIdentityCountReport($sheet, $yearType, $monthType) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('ProjectModel');
  $CI->load->model('CountyModel');
  $CI->load->model('CounselingIdentityCountReportModel');
  $CI->load->model('MemberModel');

  $countyType = 'all';

  $executeModes = $CI->MenuModel->get_by_form_and_column('project', 'execute_mode');
  $executeWays = $CI->MenuModel->get_by_form_and_column('project', 'execute_way');
  $counties = $CI->CountyModel->get_all();
  $get_inserted_identity_count_data_Array = [];
  $sumArray = [];

  $sumArray['commission_A_boy'] = 0;
  $sumArray['commission_A_girl'] = 0;
  $sumArray['commission_A_total'] = 0;
  $sumArray['commission_B_boy'] = 0;
  $sumArray['commission_B_girl'] = 0;
  $sumArray['commission_B_total'] = 0;
  $sumArray['commission_C1_boy'] = 0;
  $sumArray['commission_C1_girl'] = 0;
  $sumArray['commission_C2_boy'] = 0;
  $sumArray['commission_C2_girl'] = 0;
  $sumArray['commission_C_total'] = 0;
  $sumArray['commission_D_boy'] = 0;
  $sumArray['commission_D_girl'] = 0;
  $sumArray['commission_D_total'] = 0;
  $sumArray['commission_total'] = 0;

  $sumArray['self_A_boy'] = 0;
  $sumArray['self_A_girl'] = 0;
  $sumArray['self_A_total'] = 0;
  $sumArray['self_B_boy'] = 0;
  $sumArray['self_B_girl'] = 0;
  $sumArray['self_B_total'] = 0;
  $sumArray['self_C1_boy'] = 0;
  $sumArray['self_C1_girl'] = 0;
  $sumArray['self_C2_boy'] = 0;
  $sumArray['self_C2_girl'] = 0;
  $sumArray['self_C_total'] = 0;
  $sumArray['self_D_boy'] = 0;
  $sumArray['self_D_girl'] = 0;
  $sumArray['self_D_total'] = 0;
  $sumArray['self_total'] = 0;

  foreach ($counties as $county) {
    $projects = $CI->ProjectModel->get_latest_by_county($county['no']);
    $countyAndOrg = $CI->CountyModel->get_by_county($county['no']);
    $get_inserted_identity_count_data = $CI->CounselingIdentityCountReportModel->get_inserted_identity_count_data($yearType, $monthType, $projects->no);
    array_push($get_inserted_identity_count_data_Array, $get_inserted_identity_count_data);

    $countyName = "";
    foreach ($counties as $value) {
      if ($value['no'] == $county['no']) {
        $countyName = $value['name'];
      }
    }

    $executeMode = "";
    $executeWay = "";
    foreach ($executeModes as $value) {
      if ($value['no'] == $projects->execute_mode) {
        $executeMode = $value['content'];
      }
    }

    foreach ($executeWays as $value) {
      if ($value['no'] == $projects->execute_way) {
        $executeWay = $value['content'];
      }
    }

    if ($executeWay == '委辦') {
      $sumArray['commission_A_boy'] += empty($get_inserted_identity_count_data) ? 0 : $get_inserted_identity_count_data->junior_under_graduate_boy;
      $sumArray['commission_A_girl'] += empty($get_inserted_identity_count_data) ? 0 : $get_inserted_identity_count_data->junior_under_graduate_girl;
      $sumArray['commission_A_total'] += empty($get_inserted_identity_count_data) ? 0 : $get_inserted_identity_count_data->junior_under_graduate_boy + $get_inserted_identity_count_data->junior_under_graduate_girl;
      $sumArray['commission_B_boy'] += empty($get_inserted_identity_count_data) ? 0 : $get_inserted_identity_count_data->sixteen_years_old_not_employed_not_studying_boy;
      $sumArray['commission_B_girl'] += empty($get_inserted_identity_count_data) ? 0 : $get_inserted_identity_count_data->sixteen_years_old_not_employed_not_studying_girl;
      $sumArray['commission_B_total'] += empty($get_inserted_identity_count_data) ? 0 : $get_inserted_identity_count_data->sixteen_years_old_not_employed_not_studying_boy + $get_inserted_identity_count_data->sixteen_years_old_not_employed_not_studying_girl;
      $sumArray['commission_C1_boy'] += empty($get_inserted_identity_count_data) ? 0 : $get_inserted_identity_count_data->junior_graduated_this_year_unemployed_not_studying_boy;
      $sumArray['commission_C1_girl'] += empty($get_inserted_identity_count_data) ? 0 : $get_inserted_identity_count_data->junior_graduated_this_year_unemployed_not_studying_girl;
      $sumArray['commission_C2_boy'] += empty($get_inserted_identity_count_data) ? 0 : $get_inserted_identity_count_data->junior_graduated_not_this_year_unemployed_not_studying_boy;
      $sumArray['commission_C2_girl'] += empty($get_inserted_identity_count_data) ? 0 : $get_inserted_identity_count_data->junior_graduated_not_this_year_unemployed_not_studying_girl;
      $sumArray['commission_C_total'] += empty($get_inserted_identity_count_data) ? 0 : $get_inserted_identity_count_data->junior_graduated_this_year_unemployed_not_studying_boy + $get_inserted_identity_count_data->junior_graduated_this_year_unemployed_not_studying_girl 
        + $get_inserted_identity_count_data->junior_graduated_not_this_year_unemployed_not_studying_boy + $get_inserted_identity_count_data->junior_graduated_not_this_year_unemployed_not_studying_girl;
      $sumArray['commission_D_boy'] += empty($get_inserted_identity_count_data) ? 0 : $get_inserted_identity_count_data->drop_out_from_senior_boy;
      $sumArray['commission_D_girl'] += empty($get_inserted_identity_count_data) ? 0 : $get_inserted_identity_count_data->drop_out_from_senior_girl;
      $sumArray['commission_D_total'] += empty($get_inserted_identity_count_data) ? 0 : $get_inserted_identity_count_data->drop_out_from_senior_boy + $get_inserted_identity_count_data->drop_out_from_senior_girl;
      $sumArray['commission_total'] += empty($get_inserted_identity_count_data) ? 0 : $get_inserted_identity_count_data->sixteen_years_old_not_employed_not_studying_boy + $get_inserted_identity_count_data->sixteen_years_old_not_employed_not_studying_girl 
        + $get_inserted_identity_count_data->junior_graduated_this_year_unemployed_not_studying_boy + $get_inserted_identity_count_data->junior_graduated_this_year_unemployed_not_studying_girl 
        + $get_inserted_identity_count_data->junior_graduated_not_this_year_unemployed_not_studying_boy + $get_inserted_identity_count_data->junior_graduated_not_this_year_unemployed_not_studying_girl 
        + $get_inserted_identity_count_data->drop_out_from_senior_boy + $get_inserted_identity_count_data->drop_out_from_senior_girl;
    } else {
      $sumArray['self_A_boy'] += empty($get_inserted_identity_count_data) ? 0 : $get_inserted_identity_count_data->junior_under_graduate_boy;
      $sumArray['self_A_girl'] += empty($get_inserted_identity_count_data) ? 0 : $get_inserted_identity_count_data->junior_under_graduate_girl;
      $sumArray['self_A_total'] += empty($get_inserted_identity_count_data) ? 0 : $get_inserted_identity_count_data->junior_under_graduate_boy + $get_inserted_identity_count_data->junior_under_graduate_girl;
      $sumArray['self_B_boy'] += empty($get_inserted_identity_count_data) ? 0 : $get_inserted_identity_count_data->sixteen_years_old_not_employed_not_studying_boy;
      $sumArray['self_B_girl'] += empty($get_inserted_identity_count_data) ? 0 : $get_inserted_identity_count_data->sixteen_years_old_not_employed_not_studying_girl;
      $sumArray['self_B_total'] += empty($get_inserted_identity_count_data) ? 0 : $get_inserted_identity_count_data->sixteen_years_old_not_employed_not_studying_boy + $get_inserted_identity_count_data->sixteen_years_old_not_employed_not_studying_girl;
      $sumArray['self_C1_boy'] += empty($get_inserted_identity_count_data) ? 0 : $get_inserted_identity_count_data->junior_graduated_this_year_unemployed_not_studying_boy;
      $sumArray['self_C1_girl'] += empty($get_inserted_identity_count_data) ? 0 : $get_inserted_identity_count_data->junior_graduated_this_year_unemployed_not_studying_girl;
      $sumArray['self_C2_boy'] += empty($get_inserted_identity_count_data) ? 0 : $get_inserted_identity_count_data->junior_graduated_not_this_year_unemployed_not_studying_boy;
      $sumArray['self_C2_girl'] += empty($get_inserted_identity_count_data) ? 0 : $get_inserted_identity_count_data->junior_graduated_not_this_year_unemployed_not_studying_girl;
      $sumArray['self_C_total'] += empty($get_inserted_identity_count_data) ? 0 : $get_inserted_identity_count_data->junior_graduated_this_year_unemployed_not_studying_boy + $get_inserted_identity_count_data->junior_graduated_this_year_unemployed_not_studying_girl 
        + $get_inserted_identity_count_data->junior_graduated_not_this_year_unemployed_not_studying_boy + $get_inserted_identity_count_data->junior_graduated_not_this_year_unemployed_not_studying_girl;
      $sumArray['self_D_boy'] += empty($get_inserted_identity_count_data) ? 0 : $get_inserted_identity_count_data->drop_out_from_senior_boy;
      $sumArray['self_D_girl'] += empty($get_inserted_identity_count_data) ? 0 : $get_inserted_identity_count_data->drop_out_from_senior_girl;
      $sumArray['self_D_total'] += empty($get_inserted_identity_count_data) ? 0 : $get_inserted_identity_count_data->drop_out_from_senior_boy + $get_inserted_identity_count_data->drop_out_from_senior_girl;
      $sumArray['self_total'] += empty($get_inserted_identity_count_data) ? 0 : $get_inserted_identity_count_data->sixteen_years_old_not_employed_not_studying_boy + $get_inserted_identity_count_data->sixteen_years_old_not_employed_not_studying_girl 
        + $get_inserted_identity_count_data->junior_graduated_this_year_unemployed_not_studying_boy + $get_inserted_identity_count_data->junior_graduated_this_year_unemployed_not_studying_girl 
        + $get_inserted_identity_count_data->junior_graduated_not_this_year_unemployed_not_studying_boy + $get_inserted_identity_count_data->junior_graduated_not_this_year_unemployed_not_studying_girl 
        + $get_inserted_identity_count_data->drop_out_from_senior_boy + $get_inserted_identity_count_data->drop_out_from_senior_girl;
    }
  }

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle('表二.輔導對象身分統計表');
  $sheet->setCellValue('A1', $yearType . '年青少年生涯探索號計畫' . $monthType . '月輔導對象身分統計表');
  $sheet->mergeCells('A1:K1');
  $sheet->setCellValue('L1', '統計日期：' . (empty($get_inserted_identity_count_data) ? '' : $get_inserted_identity_count_data->date));
  $sheet->mergeCells('L1:M1');
  $sheet->setCellValue('A2', '類別');
  $sheet->mergeCells('A2:A3');
  $sheet->setCellValue('B2', "中輟滿16歲未升學未就業\nA");
  $sheet->mergeCells('B2:D3');
  $sheet->getColumnDimension('B')->setWidth(10);
  $sheet->getColumnDimension('C')->setWidth(10);
  $sheet->getColumnDimension('D')->setWidth(12);
  $sheet->setCellValue('E2', "國中畢(結)業未就學未就業\nB");
  $sheet->mergeCells('E2:I2');
  $sheet->getColumnDimension('E')->setWidth(10);
  $sheet->getColumnDimension('F')->setWidth(10);
  $sheet->getColumnDimension('G')->setWidth(10);
  $sheet->getColumnDimension('H')->setWidth(10);
  $sheet->getColumnDimension('I')->setWidth(12);
  $sheet->setCellValue('J2', "高中中離\nC");
  $sheet->mergeCells('J2:L3');
  $sheet->getColumnDimension('K')->setWidth(10);
  $sheet->getColumnDimension('K')->setWidth(10);
  $sheet->getColumnDimension('L')->setWidth(12);
  $sheet->setCellValue('M2', "合計");
  $sheet->mergeCells('M2:M4');
  $sheet->getStyle('M2:M4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

  $sheet->setCellValue('A4', '縣市別');
  $sheet->setCellValue('B4', '男');
  $sheet->setCellValue('C4', '女');
  $sheet->setCellValue('D4', '小計');
  $sheet->getStyle('D4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
  $sheet->setCellValue('E4', '男');
  $sheet->setCellValue('F4', '女');
  $sheet->setCellValue('G4', '男');
  $sheet->setCellValue('H4', '女');
  $sheet->setCellValue('E3', '應屆');
  $sheet->mergeCells('E3:F3');
  $sheet->setCellValue('G3', '非應屆');
  $sheet->mergeCells('G3:H3');
  $sheet->setCellValue('I3', '小計');
  $sheet->mergeCells('I3:I4');
  $sheet->getStyle('I3:I4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
  $sheet->setCellValue('J4', '男');
  $sheet->setCellValue('K4', '女');
  $sheet->setCellValue('L4', '小計');
  $sheet->getStyle('L4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');

  $count = 5;

  for ($i = 0; $i < count($counties); $i++) {
    $sheet->setCellValue('A' . $count, $counties[$i]['name']);
   
    $sheet->setCellValue('B' . $count, (empty($get_inserted_identity_count_data_Array[$i])) ? 0 : $get_inserted_identity_count_data_Array[$i]->sixteen_years_old_not_employed_not_studying_boy);
    $sheet->setCellValue('C' . $count, (empty($get_inserted_identity_count_data_Array[$i])) ? 0 : $get_inserted_identity_count_data_Array[$i]->sixteen_years_old_not_employed_not_studying_girl);
    $sheet->setCellValue('D' . $count, (empty($get_inserted_identity_count_data_Array[$i])) ? 0 : $get_inserted_identity_count_data_Array[$i]->sixteen_years_old_not_employed_not_studying_boy + $get_inserted_identity_count_data_Array[$i]->sixteen_years_old_not_employed_not_studying_girl);
    $sheet->getStyle('D' . $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
    $sheet->setCellValue('E' . $count, (empty($get_inserted_identity_count_data_Array[$i])) ? 0 : $get_inserted_identity_count_data_Array[$i]->junior_graduated_this_year_unemployed_not_studying_boy);
    $sheet->setCellValue('F' . $count, (empty($get_inserted_identity_count_data_Array[$i])) ? 0 : $get_inserted_identity_count_data_Array[$i]->junior_graduated_this_year_unemployed_not_studying_girl);
    $sheet->setCellValue('G' . $count, (empty($get_inserted_identity_count_data_Array[$i])) ? 0 : $get_inserted_identity_count_data_Array[$i]->junior_graduated_not_this_year_unemployed_not_studying_boy);
    $sheet->setCellValue('H' . $count, (empty($get_inserted_identity_count_data_Array[$i])) ? 0 : $get_inserted_identity_count_data_Array[$i]->junior_graduated_not_this_year_unemployed_not_studying_girl);
    $sheet->setCellValue('I' . $count, (empty($get_inserted_identity_count_data_Array[$i])) ? 0 : $get_inserted_identity_count_data_Array[$i]->junior_graduated_this_year_unemployed_not_studying_boy + $get_inserted_identity_count_data_Array[$i]->junior_graduated_this_year_unemployed_not_studying_girl 
      + $get_inserted_identity_count_data_Array[$i]->junior_graduated_not_this_year_unemployed_not_studying_boy + $get_inserted_identity_count_data_Array[$i]->junior_graduated_not_this_year_unemployed_not_studying_girl);
    $sheet->getStyle('I' . $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
    $sheet->setCellValue('J' . $count, (empty($get_inserted_identity_count_data_Array[$i])) ? 0 : $get_inserted_identity_count_data_Array[$i]->drop_out_from_senior_boy);
    $sheet->setCellValue('K' . $count, (empty($get_inserted_identity_count_data_Array[$i])) ? 0 : $get_inserted_identity_count_data_Array[$i]->drop_out_from_senior_girl);
    $sheet->setCellValue('L' . $count, (empty($get_inserted_identity_count_data_Array[$i])) ? 0 : $get_inserted_identity_count_data_Array[$i]->drop_out_from_senior_boy + $get_inserted_identity_count_data_Array[$i]->drop_out_from_senior_girl);
    $sheet->getStyle('L' . $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
    $sum = (empty($get_inserted_identity_count_data_Array[$i])) ? 0 : $get_inserted_identity_count_data_Array[$i]->sixteen_years_old_not_employed_not_studying_boy + $get_inserted_identity_count_data_Array[$i]->sixteen_years_old_not_employed_not_studying_girl
      + $get_inserted_identity_count_data_Array[$i]->junior_graduated_this_year_unemployed_not_studying_boy + $get_inserted_identity_count_data_Array[$i]->junior_graduated_this_year_unemployed_not_studying_girl + $get_inserted_identity_count_data_Array[$i]->junior_graduated_not_this_year_unemployed_not_studying_boy + $get_inserted_identity_count_data_Array[$i]->junior_graduated_not_this_year_unemployed_not_studying_girl
      + $get_inserted_identity_count_data_Array[$i]->drop_out_from_senior_boy + $get_inserted_identity_count_data_Array[$i]->drop_out_from_senior_girl;
    $sheet->setCellValue('M' . $count, $sum);
    $sheet->getStyle('M' . $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

    // $sum = ($sum == 0) ? 1 : $sum;
    // $sumA = (empty($get_inserted_identity_count_data_Array[$i])) ? 0 : $get_inserted_identity_count_data_Array[$i]->junior_under_graduate_boy + $get_inserted_identity_count_data_Array[$i]->junior_under_graduate_girl;
    // $QValue = round(($sumA) / $sum, 2) * 100;
    // $sheet->setCellValue('Q' . $count, $QValue . '%');
    // if ($QValue >= 30) {
    //   $sheet->getStyle('Q' . $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('B4F2EA');
    // }

    $count += 1;
  }

  $sheet->setCellValue('A' . ($count), '合計');
  $sheet->setCellValue('B' . ($count), $sumArray['commission_B_boy'] + $sumArray['self_B_boy']);
  $sheet->setCellValue('C' . ($count), $sumArray['commission_B_girl'] + $sumArray['self_B_girl']);
  $sheet->setCellValue('D' . ($count), $sumArray['commission_B_total'] + $sumArray['self_B_total']);
  $sheet->setCellValue('E' . ($count), $sumArray['commission_C1_boy'] + $sumArray['self_C1_boy']);
  $sheet->setCellValue('F' . ($count), $sumArray['commission_C1_girl'] + $sumArray['self_C1_girl']);
  $sheet->setCellValue('G' . ($count), $sumArray['commission_C2_boy'] + $sumArray['self_C2_boy']);
  $sheet->setCellValue('H' . ($count), $sumArray['commission_C2_girl'] + $sumArray['self_C2_girl']);
  $sheet->setCellValue('I' . ($count), $sumArray['commission_C_total'] + $sumArray['self_C_total']);
  $sheet->setCellValue('J' . ($count), $sumArray['commission_D_boy'] + $sumArray['self_D_boy']);
  $sheet->setCellValue('K' . ($count), $sumArray['commission_D_total'] + $sumArray['self_D_girl']);
  $sheet->setCellValue('L' . ($count), $sumArray['commission_D_total'] + $sumArray['self_D_total']);
  $sheet->setCellValue('M' . ($count), $sumArray['commission_total'] + $sumArray['self_total']);
  // $tempSum = (($sumArray['commission_total'] + $sumArray['self_total']) == 0) ? 1 : $sumArray['commission_total'] + $sumArray['self_total'];
  // $totalQValue = ($sumArray['commission_A_total'] + $sumArray['self_A_total']) / $tempSum;
  // $totalQValue = round($totalQValue, 2) * 100;
  // $sheet->setCellValue('Q' . $count, $totalQValue . '%');
  // if ($QValue >= 30) {
  //   $sheet->getStyle('Q' . $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('B4F2EA');
  // }

  $sheet->setCellValue('A' . ($count + 1), '委辦');
  $sheet->setCellValue('B' . ($count + 1), $sumArray['commission_B_boy']);
  $sheet->setCellValue('C' . ($count + 1), $sumArray['commission_B_girl']);
  $sheet->setCellValue('D' . ($count + 1), $sumArray['commission_B_total']);
  $sheet->setCellValue('E' . ($count + 1), $sumArray['commission_C1_boy']);
  $sheet->setCellValue('F' . ($count + 1), $sumArray['commission_C1_girl']);
  $sheet->setCellValue('G' . ($count + 1), $sumArray['commission_C2_boy']);
  $sheet->setCellValue('H' . ($count + 1), $sumArray['commission_C2_girl']);
  $sheet->setCellValue('I' . ($count + 1), $sumArray['commission_C_total']);
  $sheet->setCellValue('J' . ($count + 1), $sumArray['commission_D_boy']);
  $sheet->setCellValue('K' . ($count + 1), $sumArray['commission_D_total']);
  $sheet->setCellValue('L' . ($count + 1), $sumArray['commission_D_total']);
  $sheet->setCellValue('M' . ($count + 1), $sumArray['commission_total']);
  // $tempSum = (($sumArray['commission_total']) == 0) ? 1 : $sumArray['commission_total'];
  // $totalQValue = $sumArray['commission_A_total'] / $tempSum;
  // $totalQValue = round($totalQValue, 2) * 100;
  // $sheet->setCellValue('Q' . ($count + 1), $totalQValue . '%');
  // if ($QValue >= 30) {
  //   $sheet->getStyle('Q' . ($count + 1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('B4F2EA');
  // }

  $sheet->setCellValue('A' . ($count + 2), '自辦');
  $sheet->setCellValue('B' . ($count + 2), $sumArray['self_B_boy']);
  $sheet->setCellValue('C' . ($count + 2), $sumArray['self_B_girl']);
  $sheet->setCellValue('D' . ($count + 2), $sumArray['self_B_total']);
  $sheet->setCellValue('E' . ($count + 2), $sumArray['self_C1_boy']);
  $sheet->setCellValue('F' . ($count + 2), $sumArray['self_C1_girl']);
  $sheet->setCellValue('G' . ($count + 2), $sumArray['self_C2_boy']);
  $sheet->setCellValue('H' . ($count + 2), $sumArray['self_C2_girl']);
  $sheet->setCellValue('I' . ($count + 2), $sumArray['self_C_total']);
  $sheet->setCellValue('J' . ($count + 2), $sumArray['self_D_boy']);
  $sheet->setCellValue('K' . ($count + 2), $sumArray['self_D_girl']);
  $sheet->setCellValue('L' . ($count + 2), $sumArray['self_D_total']);
  $sheet->setCellValue('M' . ($count + 2), $sumArray['self_total']);
  // $tempSum = (($sumArray['self_total']) == 0) ? 1 : $sumArray['self_total'];
  // $totalQValue = $sumArray['self_A_total'] / $tempSum;
  // $totalQValue = round($totalQValue, 2) * 100;
  // $sheet->setCellValue('Q' . ($count + 2), $totalQValue . '%');
  // if ($QValue >= 30) {
  //   $sheet->getStyle('Q' . ($count + 2))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('B4F2EA');
  // }

  $tempSum = (($sumArray['commission_total'] + $sumArray['self_total']) == 0) ? 1 : $sumArray['commission_total'] + $sumArray['self_total'];
  $sheet->setCellValue('A' . ($count + 3), '百分比');
  $sheet->setCellValue('B' . ($count + 3), round(($sumArray['commission_B_boy'] + $sumArray['self_B_boy']) / $tempSum, 2) * 100 . '%');
  $sheet->setCellValue('C' . ($count + 3), round(($sumArray['commission_B_girl'] + $sumArray['self_B_girl']) / $tempSum, 2) * 100 . '%');
  $sheet->setCellValue('D' . ($count + 3), round(($sumArray['commission_B_total'] + $sumArray['self_B_total']) / $tempSum, 2) * 100 . '%');
  $sheet->setCellValue('E' . ($count + 3), round(($sumArray['commission_C1_boy'] + $sumArray['self_C1_boy']) / $tempSum, 2) * 100 . '%');
  $sheet->setCellValue('F' . ($count + 3), round(($sumArray['commission_C1_girl'] + $sumArray['self_C1_girl']) / $tempSum, 2) * 100 . '%');
  $sheet->setCellValue('G' . ($count + 3), round(($sumArray['commission_C2_boy'] + $sumArray['self_C2_boy']) / $tempSum, 2) * 100 . '%');
  $sheet->setCellValue('H' . ($count + 3), round(($sumArray['commission_C2_girl'] + $sumArray['self_C2_girl']) / $tempSum, 2) * 100 . '%');
  $sheet->setCellValue('I' . ($count + 3), round(($sumArray['commission_C_total'] + $sumArray['self_C_total']) / $tempSum, 2) * 100 . '%');
  $sheet->setCellValue('J' . ($count + 3), round(($sumArray['commission_D_boy'] + $sumArray['self_D_boy']) / $tempSum, 2) * 100 . '%');
  $sheet->setCellValue('K' . ($count + 3), round(($sumArray['commission_D_total'] + $sumArray['self_D_girl']) / $tempSum, 2) * 100 . '%');
  $sheet->setCellValue('L' . ($count + 3), round(($sumArray['commission_D_total'] + $sumArray['self_D_total']) / $tempSum, 2) * 100 . '%');
  $sheet->setCellValue('M' . ($count + 3), round($tempSum / $tempSum, 2) * 100 . '%');

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray)-1] . ($count+3))->applyFromArray($styleArray);


  return $sheet;
}

function yda_month_CounselingMeetingCountRepor($sheet, $yearType, $monthType) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('ProjectModel');
  $CI->load->model('CountyModel');
  $CI->load->model('CounselingMeetingCountReportModel');
  $CI->load->model('MemberModel');

  $executeModes = $CI->MenuModel->get_by_form_and_column('project', 'execute_mode');
  $executeWays = $CI->MenuModel->get_by_form_and_column('project', 'execute_way');
  $counties = $CI->CountyModel->get_all();
  $get_inserted_meeting_count_data_array = [];
  $sumArray = [];
  $projectArray = [];

  $sumArray['commission_meeting_count'] = 0;
  $sumArray['commission_planning_holding_meeting_count'] = 0;
  $sumArray['commission_actual_holding_meeting_count'] = 0;
  $sumArray['commission_planning_involved_people'] = 0;
  $sumArray['commission_actual_involved_people'] = 0;
  $sumArray['self_meeting_count'] = 0;
  $sumArray['self_planning_holding_meeting_count'] = 0;
  $sumArray['self_actual_holding_meeting_count'] = 0;
  $sumArray['self_planning_involved_people'] = 0;
  $sumArray['self_actual_involved_people'] = 0;

  foreach ($counties as $county) {
    $projects = $CI->ProjectModel->get_latest_by_county($county['no']);
    array_push($projectArray, $projects);

    $countyAndOrg = $CI->CountyModel->get_by_county($county['no']);
    $get_inserted_meeting_count_data = $CI->CounselingMeetingCountReportModel->get_inserted_meeting_count_data($yearType, $monthType, $projects->no);
    array_push($get_inserted_meeting_count_data_array, $get_inserted_meeting_count_data);

    $countyName = "";
    foreach ($counties as $value) {
      if ($value['no'] == $county['no']) {
        $countyName = $value['name'];
      }
    }

    $executeMode = "";
    $executeWay = "";
    foreach ($executeModes as $value) {
      if ($value['no'] == $projects->execute_mode) {
        $executeMode = $value['content'];
      }
    }

    foreach ($executeWays as $value) {
      if ($value['no'] == $projects->execute_way) {
        $executeWay = $value['content'];
      }
    }

    if ($executeWay == '委辦') {
      $sumArray['commission_meeting_count'] += empty($projects) ? 0 : $projects->meeting_count;
      $sumArray['commission_planning_holding_meeting_count'] += empty($get_inserted_meeting_count_data) ? 0 : $get_inserted_meeting_count_data->planning_holding_meeting_count;
      $sumArray['commission_actual_holding_meeting_count'] += empty($get_inserted_meeting_count_data) ? 0 : $get_inserted_meeting_count_data->actual_holding_meeting_count;
      $sumArray['commission_planning_involved_people'] += empty($get_inserted_meeting_count_data) ? 0 : $get_inserted_meeting_count_data->planning_involved_people;
      $sumArray['commission_actual_involved_people'] += empty($get_inserted_meeting_count_data) ? 0 : $get_inserted_meeting_count_data->actual_involved_people;
    } else {
      $sumArray['self_meeting_count'] += empty($projects) ? 0 : $projects->meeting_count;
      $sumArray['self_planning_holding_meeting_count'] += empty($get_inserted_meeting_count_data) ? 0 : $get_inserted_meeting_count_data->planning_holding_meeting_count;
      $sumArray['self_actual_holding_meeting_count'] += empty($get_inserted_meeting_count_data) ? 0 : $get_inserted_meeting_count_data->actual_holding_meeting_count;
      $sumArray['self_planning_involved_people'] += empty($get_inserted_meeting_count_data) ? 0 : $get_inserted_meeting_count_data->planning_involved_people;
      $sumArray['self_actual_involved_people'] += empty($get_inserted_meeting_count_data) ? 0 : $get_inserted_meeting_count_data->actual_involved_people;
    }
  }

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    if($column != 'I') $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle('表三.辦理會議或講座統計表');
  $sheet->setCellValue('A1', $yearType . '年青少年生涯探索號計畫' . $monthType . '月辦理會議或講座統計表');
  $sheet->mergeCells('A1:F1');
  $sheet->setCellValue('G1', '統計日期：');
  $sheet->mergeCells('G1:I1');
  $sheet->getStyle('G1:I1')->getAlignment()->setHorizontal('center');
  $sheet->setCellValue('A2', '縣市');
  $sheet->setCellValue('B2', "預計辦理跨局\n處會議場次");
  $sheet->getColumnDimension('B')->setWidth(15);
  $sheet->setCellValue('C2', "目前辦理跨局\n處會議時間");
  $sheet->getColumnDimension('c')->setWidth(15);
  $sheet->setCellValue('D2', '加總');
  $sheet->getStyle('D2')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('9BC9C9');
  $sheet->getColumnDimension('D')->setWidth(0);
  $sheet->setCellValue('E2', "預計辦理\n講座場次");
  $sheet->getColumnDimension('E')->setWidth(6);
  $sheet->setCellValue('F2', "目前辦理\n講座場次");
  $sheet->getColumnDimension('F')->setWidth(6);
  $sheet->setCellValue('G2', "預計講座\n參與人次");
  $sheet->getColumnDimension('G')->setWidth(6);
  $sheet->setCellValue('H2', "目前講座\n參與人次");
  $sheet->getColumnDimension('H')->setWidth(6);
  $sheet->setCellValue('I2', '備註(跨局處會議時間、名稱)');
  $sheet->getColumnDimension('I')->setWidth(50);

  $count = 3;

  for ($i = 0; $i < count($counties); $i++) {
    $sheet->setCellValue('A' . $count, $counties[$i]['name']);
    $sheet->setCellValue('B' . $count, (empty($projectArray[$i])) ? 0 : $projectArray[$i]->meeting_count);
    $sheet->setCellValue('C' . $count, (empty($get_inserted_meeting_count_data_array[$i])) ? '無資料' : $get_inserted_meeting_count_data_array[$i]->time_note);
    $sheet->setCellValue('E' . $count, (empty($get_inserted_meeting_count_data_array[$i])) ? 0 : $get_inserted_meeting_count_data_array[$i]->planning_holding_meeting_count);
    $sheet->setCellValue('F' . $count, (empty($get_inserted_meeting_count_data_array[$i])) ? 0 : $get_inserted_meeting_count_data_array[$i]->actual_holding_meeting_count);
    $sheet->setCellValue('G' . $count, (empty($get_inserted_meeting_count_data_array[$i])) ? 0 : $get_inserted_meeting_count_data_array[$i]->planning_involved_people);
    $sheet->setCellValue('H' . $count, (empty($get_inserted_meeting_count_data_array[$i])) ? 0 : $get_inserted_meeting_count_data_array[$i]->actual_involved_people);
    $sheet->setCellValue('I' . $count, (empty($get_inserted_meeting_count_data_array[$i])) ? '無資料' : $get_inserted_meeting_count_data_array[$i]->meeting_count_note);
    $count += 1;  
  }

  $sheet->setCellValue('A' . ($count), '合計');
  $sheet->setCellValue('B' . ($count), $sumArray['commission_meeting_count'] + $sumArray['self_meeting_count']);
  $sheet->setCellValue('E' . ($count), $sumArray['commission_planning_holding_meeting_count'] + $sumArray['self_planning_holding_meeting_count']);
  $sheet->setCellValue('F' . ($count), $sumArray['commission_actual_holding_meeting_count'] + $sumArray['self_actual_holding_meeting_count']);
  $sheet->setCellValue('G' . ($count), $sumArray['commission_planning_involved_people'] + $sumArray['self_planning_involved_people']);
  $sheet->setCellValue('H' . ($count), $sumArray['commission_actual_involved_people'] + $sumArray['self_actual_involved_people']);

  $sheet->setCellValue('A' . ($count + 1), '委辦');
  $sheet->setCellValue('B' . ($count + 1), $sumArray['commission_meeting_count']);
  $sheet->setCellValue('E' . ($count + 1), $sumArray['commission_planning_holding_meeting_count']);
  $sheet->setCellValue('F' . ($count + 1), $sumArray['commission_actual_holding_meeting_count']);
  $sheet->setCellValue('G' . ($count + 1), $sumArray['commission_planning_involved_people']);
  $sheet->setCellValue('H' . ($count + 1), $sumArray['commission_actual_involved_people']);

  $sheet->setCellValue('A' . ($count + 2), '自辦');
  $sheet->setCellValue('B' . ($count + 2), $sumArray['self_meeting_count']);
  $sheet->setCellValue('E' . ($count + 2), $sumArray['self_planning_holding_meeting_count']);
  $sheet->setCellValue('F' . ($count + 2), $sumArray['self_actual_holding_meeting_count']);
  $sheet->setCellValue('G' . ($count + 2), $sumArray['self_planning_involved_people']);
  $sheet->setCellValue('H' . ($count + 2), $sumArray['self_actual_involved_people']);

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray)-1] . ($count+2))->applyFromArray($styleArray);

  return $sheet;
}

function yda_month_counselorManpowerReport($sheet, $yearType, $monthType) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('ProjectModel');
  $CI->load->model('CountyModel');
  $CI->load->model('CounselorManpowerReportModel');
  $CI->load->model('MemberModel');

  $executeModes = $CI->MenuModel->get_by_form_and_column('project', 'execute_mode');
  $executeWays = $CI->MenuModel->get_by_form_and_column('project', 'execute_way');
  $counties = $CI->CountyModel->get_all();
  $counselorManpowerReportArray = [];
  $sumArray = [];
  $countyAndOrgArray = [];
  $projectArray = [];
  $executeModeArray = [];

  $sumArray['project_counselor'] = 0;
  $sumArray['really_counselor'] = 0;
  $sumArray['education_counselor'] = 0;
  $sumArray['counseling_center_counselor'] = 0;
  $sumArray['school_counselor'] = 0;
  $sumArray['outsourcing_counselor'] = 0;
  $sumArray['bachelor_degree'] = 0;
  $sumArray['master_degree'] = 0;
  $sumArray['qualification_one'] = 0;
  $sumArray['qualification_two'] = 0;
  $sumArray['qualification_three'] = 0;
  $sumArray['qualification_four'] = 0;
  $sumArray['qualification_five'] = 0;
  $sumArray['qualification_six'] = 0;

  foreach ($counties as $county) {
    $projects = $CI->ProjectModel->get_latest_by_county($county['no']);
    array_push($projectArray, $projects);

    $countyAndOrg = $CI->CountyModel->get_by_county($county['no']);
    array_push($countyAndOrgArray, $countyAndOrg);
    $counselorManpowerReports = $CI->CounselorManpowerReportModel->get_by_no($yearType, $monthType, $county['no']);

    array_push($counselorManpowerReportArray, $counselorManpowerReports);

    $countyName = "";
    foreach ($counties as $value) {
      if ($value['no'] == $county['no']) {
        $countyName = $value['name'];
      }
    }

    $executeMode = "";
    $executeWay = "";
    foreach ($executeModes as $value) {
      if ($value['no'] == $projects->execute_mode) {
        $executeMode = $value['content'];
      }
    }
    array_push($executeModeArray, $executeMode);

    foreach ($executeWays as $value) {
      if ($value['no'] == $projects->execute_way) {
        $executeWay = $value['content'];
      }
    }

    $sumArray['project_counselor'] += empty($counselorManpowerReports) ? 0 : $counselorManpowerReports->project_counselor;
    $sumArray['really_counselor'] += empty($counselorManpowerReports) ? 0 : $counselorManpowerReports->really_counselor;
    $sumArray['education_counselor'] += empty($counselorManpowerReports) ? 0 : $counselorManpowerReports->education_counselor;
    $sumArray['counseling_center_counselor'] += empty($counselorManpowerReports) ? 0 : $counselorManpowerReports->counseling_center_counselor;
    $sumArray['school_counselor'] += empty($counselorManpowerReports) ? 0 : $counselorManpowerReports->school_counselor;
    $sumArray['outsourcing_counselor'] += empty($counselorManpowerReports) ? 0 : $counselorManpowerReports->outsourcing_counselor;
    $sumArray['bachelor_degree'] += empty($counselorManpowerReports) ? 0 : $counselorManpowerReports->bachelor_degree;
    $sumArray['master_degree'] += empty($counselorManpowerReports) ? 0 : $counselorManpowerReports->master_degree;
    $sumArray['qualification_one'] += empty($counselorManpowerReports) ? 0 : $counselorManpowerReports->qualification_three;
    $sumArray['qualification_two'] += empty($counselorManpowerReports) ? 0 : $counselorManpowerReports->qualification_four;
    $sumArray['qualification_three'] += empty($counselorManpowerReports) ? 0 : $counselorManpowerReports->qualification_one + $counselorManpowerReports->qualification_two 
                                                                                + $counselorManpowerReports->qualification_five + $counselorManpowerReports->qualification_six;
  }

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    if($column != 'Q') $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle('表四.輔導人力概況表');
  $sheet->setCellValue('A1', $yearType . '年青少年生涯探索號計畫' . $monthType . '月輔導人力概況表');
  $sheet->mergeCells('A1:M1');
  $sheet->setCellValue('N1', '統計日期：');
  $sheet->setCellValue('A2', '縣市');
  $sheet->mergeCells('A2:A3');
  $sheet->getColumnDimension('A')->setWidth(7);
  $sheet->setCellValue('B2', '辦理模式');
  $sheet->mergeCells('B2:B3');
  $sheet->getColumnDimension('E')->setWidth(5);
  $sheet->setCellValue('C2', "專任輔\n導人員");
  $sheet->mergeCells('C2:D2');
  $sheet->getRowDimension('2')->setRowHeight(30);
  $sheet->setCellValue('C3', '預估');
  $sheet->getColumnDimension('C')->setWidth(5);
  $sheet->setCellValue('D3', '實際');
  $sheet->getColumnDimension('D')->setWidth(5);
  $sheet->setCellValue('E2', '輔導人員隸屬');
  $sheet->mergeCells('E2:H2');
  $sheet->getStyle('E2:H2')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fcd6b4');
  $sheet->setCellValue('E3', '教育局處');
  $sheet->getColumnDimension('E')->setWidth(5);
  $sheet->getStyle('E3')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
  $sheet->setCellValue('F3', '輔諮中心');
  $sheet->getStyle('F3')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
  $sheet->getColumnDimension('F')->setWidth(5);
  $sheet->setCellValue('G3', '學校');
  $sheet->getStyle('G3')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
  $sheet->getColumnDimension('G')->setWidth(5);
  $sheet->setCellValue('H3', '委外單位');
  $sheet->getStyle('H3')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
  $sheet->getColumnDimension('H')->setWidth(5);
  $sheet->setCellValue('I2', '學歷');
  $sheet->mergeCells('I2:J2');
  $sheet->getStyle('I2:J2')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d8e4bc');
  $sheet->setCellValue('I3', '學士');
  $sheet->getColumnDimension('I')->setWidth(5);
  $sheet->setCellValue('J3', '碩士');
  $sheet->getColumnDimension('J')->setWidth(5);
  $sheet->setCellValue('K2', '證照');
  $sheet->mergeCells('K2:M2');
  $sheet->getStyle('K2:M2')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fcd6b4');
  $sheet->setCellValue('K3', "具社會工作師證照");
  $sheet->getStyle('K3')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
  $sheet->getColumnDimension('K')->setWidth(20);
  $sheet->setCellValue('L3', "具心理師證照");
  $sheet->getStyle('L3')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
  $sheet->getColumnDimension('L')->setWidth(20);
  $sheet->setCellValue('M3', '無證照相關系所');
  $sheet->getStyle('M3')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
  $sheet->getColumnDimension('M')->setWidth(20);
  $sheet->setCellValue('N2', '備註(到職日)');
  $sheet->mergeCells('N2:N3');
  $sheet->getColumnDimension('N')->setWidth(30);
  $sheet->getRowDimension('4')->setRowHeight(80);
  $sheet->getStyle('N2:N3')->getAlignment()->setHorizontal('center');

  $count = 4;

  for ($i = 0; $i < count($counties); $i++) {
    $sheet->setCellValue('A' . $count, $counties[$i]['name']);
    $sheet->setCellValue('B' . $count, (empty($executeModeArray[$i])) ? '自辦' : substr($executeModeArray[$i], 0, 9));
    $sheet->setCellValue('C' . $count, (empty($counselorManpowerReportArray[$i])) ? 0 : $counselorManpowerReportArray[$i]->project_counselor);
    $sheet->setCellValue('D' . $count, (empty($counselorManpowerReportArray[$i])) ? 0 : $counselorManpowerReportArray[$i]->really_counselor);
    $sheet->setCellValue('E' . $count, (empty($counselorManpowerReportArray[$i])) ? 0 : $counselorManpowerReportArray[$i]->education_counselor);
    $sheet->getStyle('E' . $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
    $sheet->setCellValue('F' . $count, (empty($counselorManpowerReportArray[$i])) ? 0 : $counselorManpowerReportArray[$i]->counseling_center_counselor);
    $sheet->getStyle('F' . $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
    $sheet->setCellValue('G' . $count, (empty($counselorManpowerReportArray[$i])) ? 0 : $counselorManpowerReportArray[$i]->school_counselor);
    $sheet->getStyle('G' . $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
    $sheet->setCellValue('H' . $count, (empty($counselorManpowerReportArray[$i])) ? 0 : $counselorManpowerReportArray[$i]->outsourcing_counselor);
    $sheet->getStyle('H' . $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
    $sheet->setCellValue('I' . $count, (empty($counselorManpowerReportArray[$i])) ? 0 : $counselorManpowerReportArray[$i]->bachelor_degree);
    $sheet->setCellValue('J' . $count, (empty($counselorManpowerReportArray[$i])) ? 0 : $counselorManpowerReportArray[$i]->master_degree);
    $sheet->setCellValue('K' . $count, (empty($counselorManpowerReportArray[$i])) ? 0 : $counselorManpowerReportArray[$i]->qualification_three);
    $sheet->getStyle('K' . $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
    $sheet->setCellValue('L' . $count, (empty($counselorManpowerReportArray[$i])) ? 0 : $counselorManpowerReportArray[$i]->qualification_four);
    $sheet->getStyle('L' . $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
    $sheet->setCellValue('M' . $count, (empty($counselorManpowerReportArray[$i])) ? 0 : $counselorManpowerReportArray[$i]->qualification_one + $counselorManpowerReportArray[$i]->qualification_two 
                                                                                          + $counselorManpowerReportArray[$i]->qualification_five + $counselorManpowerReportArray[$i]->qualification_six);
    $sheet->getStyle('M' . $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
    $sheet->setCellValue('N' . $count, (empty($counselorManpowerReportArray[$i])) ? '無資料' : $counselorManpowerReportArray[$i]->note);
    $count += 1;
  }

  $sheet->setCellValue('A' . ($count), '小計');
  $sheet->mergeCells('A' . $count . ':B' . $count);
  $sheet->setCellValue('C' . ($count), $sumArray['project_counselor']);
  $sheet->setCellValue('D' . ($count), $sumArray['really_counselor']);
  $sheet->setCellValue('E' . ($count), $sumArray['education_counselor']);
  $sheet->getStyle('E' . $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
  $sheet->setCellValue('F' . ($count), $sumArray['counseling_center_counselor']);
  $sheet->getStyle('F' . $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
  $sheet->setCellValue('G' . ($count), $sumArray['school_counselor']);
  $sheet->getStyle('G' . $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
  $sheet->setCellValue('H' . ($count), $sumArray['outsourcing_counselor']);
  $sheet->getStyle('H' . $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
  $sheet->setCellValue('I' . ($count), $sumArray['bachelor_degree']);
  $sheet->setCellValue('J' . ($count), $sumArray['master_degree']);
  $sheet->setCellValue('K' . ($count), $sumArray['qualification_one']);
  $sheet->getStyle('K' . $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
  $sheet->setCellValue('L' . ($count), $sumArray['qualification_two']);
  $sheet->getStyle('L' . $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
  $sheet->setCellValue('M' . ($count), $sumArray['qualification_three']);
  $sheet->getStyle('M' . $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray)-1] . ($count))->applyFromArray($styleArray);

  return $sheet;
}

function yda_month_TwoYearsTrendSurveyCountReport($sheet, $yearType, $monthType) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('ProjectModel');
  $CI->load->model('CountyModel');
  $CI->load->model('TwoYearsTrendSurveyCountReportModel');
  $CI->load->model('MemberModel');
  $CI->load->helper('report');

  $countyType = 'all';
  $counties = $CI->CountyModel->get_all();
  $reportArray = [];
  $tableValue = $CI->TwoYearsTrendSurveyCountReportModel->get_by_all($yearType, $monthType, $countyType);

  if ($countyType == 'all') $counties = $CI->CountyModel->get_all();
  else $counties = $CI->CountyModel->get_one($countyType);

  $sumDetail = get_seasonal_review_month_report_sum($tableValue);
  foreach ($counties as $county) {
    $report = $CI->TwoYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county['no']);
    array_push($reportArray, $report);

  }
 
  $sheet->setTitle('表五.' . ($yearType - 4) . '學年度國中動向調查結果後續追蹤表');
  $sheet = month_yda_report_track_header($sheet, $reportArray, $sumDetail, $counties);

  return $sheet;
}

function yda_month_OneYearsTrendSurveyCountReport($sheet, $yearType, $monthType) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('ProjectModel');
  $CI->load->model('CountyModel');
  $CI->load->model('OneYearsTrendSurveyCountReportModel');
  $CI->load->model('MemberModel');
  $CI->load->helper('report');


  $countyType = 'all';
  $counties = $CI->CountyModel->get_all();
  $reportArray = [];
  $tableValue = $CI->OneYearsTrendSurveyCountReportModel->get_by_all($yearType, $monthType, $countyType);

  if ($countyType == 'all') $counties = $CI->CountyModel->get_all();
  else $counties = $CI->CountyModel->get_one($countyType);

  $sumDetail = get_seasonal_review_month_report_sum($tableValue);
  foreach ($counties as $county) {
    $report = $CI->OneYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county['no']);
    array_push($reportArray, $report);

  }
 
  $sheet->setTitle('表六.' . ($yearType - 3) . '學年度國中動向調查結果後續追蹤表');
  $sheet = month_yda_report_track_header($sheet, $reportArray, $sumDetail, $counties);

  return $sheet;
}

function yda_month_NowYearsTrendSurveyCountReport($sheet, $yearType, $monthType) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('ProjectModel');
  $CI->load->model('CountyModel');
  $CI->load->model('NowYearsTrendSurveyCountReportModel');
  $CI->load->model('MemberModel');

  $CI->load->helper('report');


  $countyType = 'all';
  $counties = $CI->CountyModel->get_all();
  $reportArray = [];
  $tableValue = $CI->NowYearsTrendSurveyCountReportModel->get_by_all($yearType, $monthType, $countyType);

  if ($countyType == 'all') $counties = $CI->CountyModel->get_all();
  else $counties = $CI->CountyModel->get_one($countyType);

  $sumDetail = get_seasonal_review_month_report_sum($tableValue);
  foreach ($counties as $county) {
    $report = $CI->NowYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county['no']);
    array_push($reportArray, $report);

  }
 
  $sheet->setTitle('表七.' . ($yearType - 2) . '學年度國中動向調查結果後續追蹤表');
  $sheet = month_yda_report_track_header($sheet, $reportArray, $sumDetail, $counties);
  return $sheet;
}

function yda_month_OldCaseTrendSurveyCountReport($sheet, $yearType, $monthType) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('ProjectModel');
  $CI->load->model('CountyModel');
  $CI->load->model('OldCaseTrendSurveyCountReportModel');
  $CI->load->model('MemberModel');

  $CI->load->helper('report');


  $countyType = 'all';
  $counties = $CI->CountyModel->get_all();
  $reportArray = [];
  $tableValue = $CI->OldCaseTrendSurveyCountReportModel->get_by_all($yearType, $monthType, $countyType, 195);

  if ($countyType == 'all') $counties = $CI->CountyModel->get_all();
  else $counties = $CI->CountyModel->get_one($countyType);

  $sumDetail = get_seasonal_review_month_report_sum($tableValue);
  foreach ($counties as $county) {
    $report = $CI->OldCaseTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county['no']);
    array_push($reportArray, $report);

  }
 
  $sheet->setTitle('表八.前一年度開案學員後續追蹤表');
  $sheet = month_yda_report_track_header($sheet, $reportArray, $sumDetail, $counties);

  return $sheet;
}

function yda_month_HighSchoolTrendSurveyCountReport($sheet, $yearType, $monthType) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('ProjectModel');
  $CI->load->model('CountyModel');
  $CI->load->model('HighSchoolTrendSurveyCountReportModel');
  $CI->load->model('MemberModel');

  $CI->load->helper('report');


  $countyType = 'all';
  $counties = $CI->CountyModel->get_all();
  $reportArray = [];
  $tableValue = $CI->HighSchoolTrendSurveyCountReportModel->get_by_all($yearType, $monthType, $countyType, 195);

  if ($countyType == 'all') $counties = $CI->CountyModel->get_all();
  else $counties = $CI->CountyModel->get_one($countyType);

  $sumDetail = get_seasonal_review_month_report_sum($tableValue);
  foreach ($counties as $county) {
    $report = $CI->HighSchoolTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county['no']);
    array_push($reportArray, $report);

  }
 
  $sheet->setTitle('表九.高中已錄取未註冊後續追蹤表');
  $sheet = month_yda_report_track_header($sheet, $reportArray, $sumDetail, $counties);

  return $sheet;
}

function yda_month_timingReport($sheet, $yearType, $monthType) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('ProjectModel');
  $CI->load->model('CountyModel');
  $CI->load->model('CounselingMemberCountReportModel');
  $CI->load->model('TimingReportModel');
  $CI->load->model('MemberModel');

  $countyType = 'all';

  $countiesName = $CI->CountyModel->get_all();

  $executeModes = $CI->MenuModel->get_by_form_and_column('project', 'execute_mode');
  $executeWays = $CI->MenuModel->get_by_form_and_column('project', 'execute_way');

  $projectArray = [];
  $reportNameArray = ['counseling_member_count_report', 'two_years_trend_survey_count_report',
    'one_years_trend_survey_count_report', 'now_years_trend_survey_count_report',
    'old_case_trend_survey_count_report', 'counselor_manpower_report',
    'counseling_identity_count_report', 'counseling_meeting_count_report'];

  $reportProcessesYdaStatusArray = [];
  $reportLogsArray = [];
  $countyIdArray = [];
  $isOverTimeArray = [];
  $timingReportCountyArray = [];
  $timingReportYdaArray = [];

  $earlyTimeDetailArray = [];
  $onTimeDetailArray = [];
  $lateTimeDetailArray = [];

  $commissionEarlyArray = $commissionOnTimeArray = $commissionLateTimeArray = [];
  $selfEarlyArray = $selfOnTimeArray = $selfLateTimeArray = [];


  $processReviewStatuses = $CI->MenuModel->get_by_form_and_column('review_process', 'review_status');
  $logReviewStatuses = $CI->MenuModel->get_by_form_and_column('review_log', 'review_status');
  $reviewStatus = [];

  $reviewStatus['review_process_not_pass'] = $CI->MenuModel->get_no_resource_by_content('未批准', 'review_process')->no;
  $reviewStatus['review_process_pass'] = $CI->MenuModel->get_no_resource_by_content('批准', 'review_process')->no;
  $reviewStatus['review_process_wait'] = $CI->MenuModel->get_no_resource_by_content('等待送出', 'review_process')->no;
  
  if ($countyType == 'all') {
    $counties = $CI->CountyModel->get_all();
  } else {
    $counties = $CI->CountyModel->get_one($countyType);
  }

  foreach ($counties as $county) {
    $earlyTimeDetail = $onTimeDetail = $lateTimeDetail = "";

    $projects = $CI->ProjectModel->get_latest_by_county($county['no']);
    array_push($projectArray, $projects);

    $countyName = "";
    foreach ($counties as $value) {
      if ($value['no'] == $county['no']) {
        $countyName = $value['name'];
      }
    }

    $executeMode = "";
    $executeWay = "";
    foreach ($executeModes as $value) {
      if ($value['no'] == $projects->execute_mode) {
        $executeMode = $value['content'];
      }
    }
    foreach ($executeWays as $value) {
     if ($value['no'] == $projects->execute_way) {
        $executeWay = $value['content'];
      }
    }

    $timingReportCounty = $CI->TimingReportModel->get_county_by_county($county['no'], $yearType, $monthType);
    $timingReportYda = $CI->TimingReportModel->get_yda_by_county($county['no'], $yearType, $monthType);

    array_push($timingReportCountyArray, $timingReportCounty);
    array_push($timingReportYdaArray, $timingReportYda);

    $addMonth = ($monthType + 1 > 12) ? 1 : $monthType + 1;
    $addMonth = ($addMonth > 9) ? $addMonth : '0' . $addMonth;
    $addYear = ($monthType + 1 > 12) ? $yearType + 1 : $yearType;
    $overTimeDate = ($addYear + 1911) . '-' . $addMonth . '-05';
    $countyId = "";
    $isOverTime = 0;

    array_push($countyIdArray, $countyId);
    array_push($isOverTimeArray, $isOverTime);

    if ($timingReportCounty) {
      if ($timingReportCounty->date < $overTimeDate) {
        $earlyTimeDetail = $earlyTimeDetail . $timingReportCounty->date . "\n";
      } elseif ($timingReportCounty->date = $overTimeDate) {
        $onTimeDetail = $onTimeDetail . $timingReportCounty->date . "\n";
      } elseif ($timingReportCounty->date > $overTimeDate) {
        $lateTimeDetail = $lateTimeDetail . $timingReportCounty->date . "\n";  
      }
    }

    if ($timingReportYda) {
      if ($timingReportYda->date < $overTimeDate) {
        $earlyTimeDetail = $earlyTimeDetail . $timingReportYda->date . "(通過)\n";
        if($executeWay == '委辦') array_push($commissionEarlyArray, $countyName);
        else array_push($selfEarlyArray, $countyName);
      } elseif ($timingReportYda->date = $overTimeDate) {
         $onTimeDetail = $onTimeDetail . $timingReportYda->date . "(通過)\n";
         if($executeWay == '委辦') array_push($commissionOnTimeArray, $countyName);
         else array_push($selfOnTimeArray, $countyName);
      } elseif ($timingReportYda->date > $overTimeDate) {
        $lateTimeDetail = $lateTimeDetail . $timingReportYda->date . "(通過)\n";
        if($executeWay == '委辦') array_push($commissionLateTimeArray, $countyName);
        else array_push($selfLateTimeArray, $countyName);
      }
    }

    array_push($earlyTimeDetailArray, $earlyTimeDetail);
    array_push($onTimeDetailArray, $onTimeDetail);
    array_push($lateTimeDetailArray, $lateTimeDetail);

  }

  $noteDetail = "";
  $noteDetail = $noteDetail . "回傳說明 :\n";

  $earlyNote = "(一)提前回報：" . (count($commissionEarlyArray) + count($selfEarlyArray)) . "縣市。\n";

  $commissionCountyName = $selfCountyName = "";
  if (count($commissionEarlyArray)) {
    foreach ($commissionEarlyArray as $value) {
      $commissionCountyName = $commissionCountyName . $value . "、";
    }
  } else {
    $commissionCountyName = '無';
  }

  if (count($selfEarlyArray)) {
    foreach ($selfEarlyArray as $value) {
      $selfCountyName = $selfCountyName . $value . "、";
    }
  } else {
    $selfCountyName = '無';
  }

  $commissionCountyNameCountNote = (count($commissionEarlyArray) > 1) ? ('等' . count($commissionEarlyArray) . '縣市') : '';
  $selfCountyNameCountNote = (count($selfEarlyArray) > 1) ? ('等' . count($selfEarlyArray) . '縣市') : '';
  $earlyNote = $earlyNote . "1、委辦縣市：" . $commissionCountyName . $commissionCountyNameCountNote . "。\n";
  $earlyNote = $earlyNote . "2、自辦縣市：" . $selfCountyName . $selfCountyNameCountNote . "。\n";

  $onTimeNote = "(二)準時回報：" . (count($commissionOnTimeArray) + count($selfOnTimeArray)) . "縣市。\n"; 
  $commissionCountyName = $selfCountyName = "";
  if (count($commissionOnTimeArray)) {
    foreach ($commissionOnTimeArray as $value) {
      $commissionCountyName = $commissionCountyName . $value . "、";
    }
  } else {
    $commissionCountyName = '無';
  }

  if (count($selfOnTimeArray)) {
    foreach ($selfOnTimeArray as $value) {
      $selfCountyName = $selfCountyName . $value . "、";
    }
  } else {
    $selfCountyName = '無';
  }

  $commissionCountyNameCountNote = (count($commissionOnTimeArray) > 1) ? ('等' . count($commissionOnTimeArray) . '縣市') : '';
  $selfCountyNameCountNote = (count($selfOnTimeArray) > 1) ? ('等' . count($selfOnTimeArray) . '縣市') : '';
  $onTimeNote = $onTimeNote . "1、委辦縣市：" . $commissionCountyName . $commissionCountyNameCountNote . "。\n";
  $onTimeNote = $onTimeNote . "2、自辦縣市：" . $selfCountyName . $selfCountyNameCountNote . "。\n";

  $lateTimeNote = "(三)逾時回報：" . (count($commissionLateTimeArray) + count($selfLateTimeArray)) . "縣市。\n"; 
  $commissionCountyName = $selfCountyName = "";
  if (count($commissionLateTimeArray)) {
    foreach ($commissionLateTimeArray as $value) {
      $commissionCountyName = $commissionCountyName . $value . "、";
    }
  } else {
    $commissionCountyName = '無';
  }

  if (count($selfLateTimeArray)) {
    foreach ($selfLateTimeArray as $value) {
      $selfCountyName = $selfCountyName . $value . "、";
    }
  } else {
    $selfCountyName = '無';
  }

  $commissionCountyNameCountNote = (count($commissionLateTimeArray) > 1) ? ('等' . count($commissionLateTimeArray) . '縣市') : '';
  $selfCountyNameCountNote = (count($selfLateTimeArray) > 1) ? ('等' . count($selfLateTimeArray) . '縣市') : '';
  $lateTimeNote = $lateTimeNote . "1、委辦縣市：" . $commissionCountyName . $commissionCountyNameCountNote . "。\n";
  $lateTimeNote = $lateTimeNote . "2、自辦縣市：" . $selfCountyName . $selfCountyNameCountNote . "。\n";

  $noteDetail = $noteDetail . $earlyNote . "\n" . $onTimeNote . "\n" . $lateTimeNote;

  $noteString = "註：\n" . 
    "1、本表應於每月5日前，以電子郵件方式回復前一個月執行進度表，如遇假日，應提前一日回傳。\n" . 
    "2、回傳資料未填寫完整或資料有誤，列為補正，並以補正最後日期計。 \n";

  $noteDetail = $noteDetail . $noteString;

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F');
  foreach($columnNameArray as $column) {
    if($column != 'E' && $column != 'F') $sheet->getStyle($column)->getAlignment()->setVertical('center');
    if($column != 'E' && $column != 'F') $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    if($column == 'E' ) $sheet->getStyle($column)->getAlignment()->setVertical('top');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle('回傳情形紀錄表');
  $sheet->setCellValue('A1', $yearType . '年青少年生涯探索號計畫' . $monthType . '月' . '回傳情形紀錄表');
  $sheet->mergeCells('A1:D1');
  $sheet->setCellValue('E1', '統計日期：');
  $sheet->mergeCells('E1:F1');
  $sheet->getColumnDimension('E')->setWidth(50);
  $sheet->setCellValue('A2', '縣市');
  $sheet->mergeCells('A2:A3');
  $sheet->setCellValue('B2', $monthType . '月');
  $sheet->mergeCells('B2:D2');
  $sheet->setCellValue('B3', "提前");
  $sheet->getStyle('B3')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ebf1de');
  $sheet->setCellValue('C3', "準時");
  $sheet->getStyle('C3')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fcd6b4');
  $sheet->setCellValue('D3', "逾時");
  $sheet->getStyle('D3')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('b7dee8');
  $count = 4;

  for ($i = 0; $i < count($counties); $i++) {
    $sheet->setCellValue('A' . $count, $counties[$i]['name']);
    $sheet->setCellValue('B' . $count, $earlyTimeDetailArray[$i]);
    $sheet->getColumnDimension('B')->setWidth(20);
    $sheet->setCellValue('C' . $count, $onTimeDetailArray[$i]);
    $sheet->getColumnDimension('C')->setWidth(20);
    $sheet->setCellValue('D' . $count, $lateTimeDetailArray[$i]);
    $sheet->getColumnDimension('D')->setWidth(20);
    $count += 1;
  }

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->setCellValue('E2', $noteDetail);
  $sheet->getStyle('E')->getAlignment()->setVertical('top');
  
  $sheet->mergeCells('E2:F' . ($count - 1));
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray)-1] . ($count-1))->applyFromArray($styleArray);

  return $sheet;
}

function yda_month_fundingExecuteReport($sheet, $yearType, $monthType) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('ProjectModel');
  $CI->load->model('CountyModel');
  $CI->load->model('CounselingMemberCountReportModel');
  $CI->load->model('FundingApproveModel');
  $CI->load->model('MemberModel');

  $countyType = 'all';

  $countiesName = $CI->CountyModel->get_all();

  $executeModes = $CI->MenuModel->get_by_form_and_column('project', 'execute_mode');
  $executeWays = $CI->MenuModel->get_by_form_and_column('project', 'execute_way');

  $projectArray = [];
  $projectDetailArray = [];
  $counselingMemberCountReportArray = [];
  $fundingApproveArray = [];
  $sumDetail = [];
  $sumDetail['projectFunding'] = 0;
  $sumDetail['fundingApprove'] = 0;
  $sumDetail['fundingApproveNotYet'] = 0;
  $sumDetail['fundingExecute'] = 0;
  $sumDetail['fundingExecutePercent'] = 0;

  if ($countyType == 'all') {
    $counties = $CI->CountyModel->get_all();
  } else {
    $counties = $CI->CountyModel->get_one($countyType);
  }

  foreach ($counties as $county) {
    $projects = $CI->ProjectModel->get_latest_by_county($county['no']);
    array_push($projectArray, $projects);

    $countyAndOrg = $CI->CountyModel->get_by_county($county['no']);
    $counselingMemberCountReport = $CI->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $county['no']);
    array_push($counselingMemberCountReportArray, $counselingMemberCountReport);

    $fundingApproves = $CI->FundingApproveModel->get_by_county_and_year($county['no'], $yearType, $monthType);
    array_push($fundingApproveArray, $fundingApproves);

    $countyName = "";
    foreach ($counties as $value) {
      if ($value['no'] == $county['no']) {
        $countyName = $value['name'];
      }
    }

    $executeMode = "";
    $executeWay = "";
    foreach ($executeModes as $value) {
      if ($value['no'] == $projects->execute_mode) {
        $executeMode = $value['content'];
      }
    }
    foreach ($executeWays as $value) {
      if ($value['no'] == $projects->execute_way) {
        $executeWay = $value['content'];
      }
    }

    $sumDetail['projectFunding'] += $projects->funding;
    $sumDetail['fundingApprove'] += $fundingApproves->sum;
    $sumDetail['fundingApproveNotYet'] += ($projects->funding - $fundingApproves->sum);
    $sumDetail['fundingExecute'] += ($counselingMemberCountReport ? $counselingMemberCountReport->funding_execute : 0);
  }

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle('經費執行情形表');
  $sheet->setCellValue('A1', ($yearType) . '年' . $monthType . '月經費執行情形表');
  $sheet->mergeCells('A1:D1');
  $sheet->setCellValue('E1', '統計日期：');
  $sheet->mergeCells('E1:F1');
  $sheet->setCellValue('A2', '縣市');
  $sheet->setCellValue('B2', "青年署\n核定經費A");
  $sheet->getColumnDimension('B')->setWidth(15);
  $sheet->setCellValue('C2', "青年署\n已撥付金額");
  $sheet->getColumnDimension('C')->setWidth(15);
  $sheet->setCellValue('D2', "青年署\n待撥付金額");
  $sheet->getColumnDimension('D')->setWidth(15);
  $sheet->setCellValue('E2', "縣市\n執行經費B");
  $sheet->getColumnDimension('E')->setWidth(15);
  $sheet->setCellValue('F2', "縣市截至" . $monthType . "月\n執行率C=(B/A)*100");
  $sheet->getColumnDimension('F')->setWidth(20);

  $count = 3;
  for ($i = 0; $i < count($counties); $i++) {
    $sheet->setCellValue('A' . $count, $counties[$i]['name']);
    $sheet->setCellValue('B' . $count, $projectArray[$i]->funding ? number_format($projectArray[$i]->funding) : 0);
    $sheet->setCellValue('C' . $count, $fundingApproveArray[$i]->sum ? number_format($fundingApproveArray[$i]->sum) : 0);
    $sheet->setCellValue('D' . $count, ($projectArray[$i]->funding - $fundingApproveArray[$i]->sum) ? number_format($projectArray[$i]->funding - $fundingApproveArray[$i]->sum) : 0);
    $sheet->setCellValue('E' . $count, $counselingMemberCountReportArray[$i] ? number_format($counselingMemberCountReportArray[$i]->funding_execute) : 0);
    $projectArray[$i]->funding = $projectArray[$i]->funding ? $projectArray[$i]->funding : 1;
    $fundingExecute = $counselingMemberCountReportArray[$i] ? $counselingMemberCountReportArray[$i]->funding_execute : 0;
    $sheet->setCellValue('F' . $count, round(($fundingExecute / $projectArray[$i]->funding), 2) * 100 . '%');
    $count += 1;
  }

  $sheet->setCellValue('A' . $count, '總計');
  $sheet->setCellValue('B' . $count, $sumDetail['projectFunding'] ? number_format($sumDetail['projectFunding']) : 0);
  $sheet->setCellValue('C' . $count, $sumDetail['fundingApprove'] ? number_format($sumDetail['fundingApprove']) : 0);
  $sheet->setCellValue('D' . $count, $sumDetail['fundingApproveNotYet'] ? number_format($sumDetail['fundingApproveNotYet']) : 0);
  $sheet->setCellValue('E' . $count, $sumDetail['fundingExecute'] ? number_format($sumDetail['fundingExecute']) : 0);
  $sumDetail['projectFunding'] = $sumDetail['projectFunding'] ? $sumDetail['projectFunding'] : 1;
  $sheet->setCellValue('F' . $count, round(($sumDetail['fundingExecute'] / $sumDetail['projectFunding']), 2) * 100 . '%');

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];

  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray)-1] . ($count))->applyFromArray($styleArray);

  return $sheet;
}

function county_month_counselingExecuteReport($sheet, $yearType, $monthType, $county) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('ProjectModel');
  $CI->load->model('CountyModel');
  $CI->load->model('CounselingMemberCountReportModel');
  $CI->load->model('MonthMemberTempCounselingModel');
  $CI->load->model('MemberModel');
  $CI->load->model('UserModel');

  $CI->load->helper('report');
  

  $counselingMemberCountReport = $CI->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $county);

  $projects = $CI->ProjectModel->get_latest_by_county($county);
  $counties = $CI->CountyModel->get_all();
  $accumCounselingMemberCount = $CI->MemberModel->get_by_county_count($county, $monthType, $yearType);

  $countyName = "";
  foreach ($counties as $value) {
    $countyName = ($value['no'] == $county) ? $value['name'] : $countyName;   
  }
  
  $executeArray = report_one_execute_detail($county, $yearType, $monthType, 'excel');
  $projectDetail = $executeArray['projectDetail'];
  $executeDetail = $executeArray['executeDetail'];


  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'P');
  foreach($columnNameArray as $column) {
    if($column != 'B' && $column != 'L') $sheet->getStyle($column)->getAlignment()->setVertical('center');
    if($column != 'B' && $column != 'L') $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    if($column == 'B' || $column == 'L') $sheet->getStyle($column)->getAlignment()->setVertical('top');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle($yearType . '年執行進度表');
  $sheet->setCellValue('A1', '縣市');
  $sheet->mergeCells('A1:A2');
  $sheet->setCellValue('B1', '提案計畫基本資料');
  $sheet->getStyle('B1')->getAlignment()->setVertical('center');
  $sheet->getStyle('B1')->getAlignment()->setHorizontal('center');
  $sheet->mergeCells('B1:B2');
  $sheet->getColumnDimension('B')->setWidth(25);
  $sheet->getColumnDimension('L')->setWidth(50);
  $sheet->getRowDimension('3')->setRowHeight(600);
  $sheet->setCellValue('C1', '預計輔導人數');
  $sheet->mergeCells('C1:C2');
  $sheet->getColumnDimension('C')->setWidth(5);
  $sheet->setCellValue('D1', '累積輔導人數');
  $sheet->mergeCells('D1:D2');
  $sheet->getColumnDimension('D')->setWidth(5);
  $sheet->setCellValue('E1', '關懷輔導成效');
  $sheet->mergeCells('E1:I1');
  $sheet->getStyle('E1:I1')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
  $sheet->setCellValue('E2', '已就學');
  $sheet->getColumnDimension('E')->setWidth(5);
  $sheet->setCellValue('F2', '已就業');
  $sheet->getColumnDimension('F')->setWidth(5);
  $sheet->setCellValue('G2', '參加職訓');
  $sheet->getColumnDimension('G')->setWidth(5);
  $sheet->setCellValue('H2', '其他');
  $sheet->getColumnDimension('H')->setWidth(5);
  $sheet->setCellValue('I2', '小計');
  $sheet->getColumnDimension('I')->setWidth(5);
  $sheet->getStyle('I2')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
 
  $sheet->setCellValue('J1', '尚無規劃輔導中');
  $sheet->mergeCells('J1:J2');
  $sheet->getColumnDimension('J')->setWidth(5);
  $sheet->setCellValue('K1', "不可抗力人數\n（司法安置、出國、死亡）");
  $sheet->mergeCells('K1:K2');
  $sheet->getColumnDimension('K')->setWidth(5);
  $sheet->setCellValue('L1', '辦理情形');
  
  $sheet->mergeCells('L1:P2');
  $sheet->getStyle('L1:P2')->getAlignment()->setVertical('center');
  $sheet->getStyle('L1:P2')->getAlignment()->setHorizontal('center');

  $count = 3;

  if ($counselingMemberCountReport) {
    $sheet->setCellValue('A' . $count, $countyName);
    $sheet->mergeCells('A' . $count . ':A' . ($count + 4));
    $sheet->getStyle('A' . $count)->getFont()->getColor()->setARGB(Style\Color::COLOR_RED);
    $sheet->setCellValue('B' . $count, $projectDetail);
    $sheet->mergeCells('B' . $count . ':B' . ($count + 4));
    $sheet->getStyle('B' . $count)->getFont()->getColor()->setARGB(Style\Color::COLOR_RED);
    $sheet->setCellValue('C' . $count, $projects->counseling_member);
    $sheet->getStyle('C' . $count)->getFont()->getColor()->setARGB(Style\Color::COLOR_RED);
    $sheet->getStyle('C' . $count)->getAlignment()->setVertical('top');
    $sheet->setCellValue('D' . $count, $accumCounselingMemberCount);
    $sheet->getStyle('D' . $count)->getFont()->getColor()->setARGB(Style\Color::COLOR_RED);
    $sheet->getStyle('D' . $count)->getAlignment()->setVertical('top');
    $sheet->setCellValue('E' . $count, $counselingMemberCountReport->school_member);
    $sheet->getStyle('E' . $count)->getFont()->getColor()->setARGB(Style\Color::COLOR_RED);
    $sheet->getStyle('E' . $count)->getAlignment()->setVertical('top');
    $sheet->setCellValue('F' . $count, $counselingMemberCountReport->work_member);
    $sheet->getStyle('F' . $count)->getFont()->getColor()->setARGB(Style\Color::COLOR_RED);
    $sheet->getStyle('F' . $count)->getAlignment()->setVertical('top');
    $sheet->setCellValue('G' . $count, $counselingMemberCountReport->vocational_training_member);
    $sheet->getStyle('G' . $count)->getFont()->getColor()->setARGB(Style\Color::COLOR_RED);
    $sheet->getStyle('G' . $count)->getAlignment()->setVertical('top');
    $sheet->setCellValue('H' . $count, $counselingMemberCountReport->other_member);
    $sheet->getStyle('H' . $count)->getFont()->getColor()->setARGB(Style\Color::COLOR_RED);
    $sheet->getStyle('H' . $count)->getAlignment()->setVertical('top');
    $sheet->setCellValue('I' . $count, $counselingMemberCountReport->school_member + $counselingMemberCountReport->work_member + $counselingMemberCountReport->vocational_training_member + $counselingMemberCountReport->other_member);
    $sheet->getStyle('I' . $count)->getFont()->getColor()->setARGB(Style\Color::COLOR_RED);
    $sheet->getStyle('I' . $count)->getAlignment()->setVertical('top');
    $sheet->getStyle('I'. $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
    $sheet->setCellValue('J' . $count, $counselingMemberCountReport->no_plan_member);
    $sheet->getStyle('J' . $count)->getFont()->getColor()->setARGB(Style\Color::COLOR_RED);
    $sheet->getStyle('J' . $count)->getAlignment()->setVertical('top');
    $sheet->setCellValue('K' . $count, $counselingMemberCountReport->force_majeure_member);
    $sheet->getStyle('K' . $count)->getFont()->getColor()->setARGB(Style\Color::COLOR_RED);
    $sheet->getStyle('K' . $count)->getAlignment()->setVertical('top');
    $sheet->setCellValue('L' . $count, $executeDetail);
    $sheet->mergeCells('L' . $count . ':P' . ($count + 4));
  }

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray)-1] . ($count + 4))->applyFromArray($styleArray);

  $count += 7;
  $sheet->setCellValue('C' . $count, '承辦人');
  $sheet->getStyle('C' . $count)->getFont()->setSize(18);
  $sheet->setCellValue('F' . $count, '單位主管');
  $sheet->getStyle('F' . $count)->getFont()->setSize(18);
  $sheet->setCellValue('K' . $count, '教育局(處)首長');
  $sheet->getStyle('K' . $count)->getFont()->setSize(18);

  return $sheet;
}

function county_month_counselingMemberCountReport($sheet, $yearType, $monthType, $county) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('ProjectModel');
  $CI->load->model('CountyModel');
  $CI->load->model('CounselingMemberCountReportModel');
  $CI->load->model('MonthMemberTempCounselingModel');
  $CI->load->model('MemberModel');
  $CI->load->model('MonthReviewModel');
  $CI->load->model('SeasonalReviewModel');

  $projects = $CI->ProjectModel->get_latest_by_county($county);
  $countyAndOrg = $CI->CountyModel->get_by_county($county);
  $counselingMemberCountReport = $CI->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $county);
  $executeModes = $CI->MenuModel->get_by_form_and_column('project', 'execute_mode');
  $executeWays = $CI->MenuModel->get_by_form_and_column('project', 'execute_way');
  $qualifications = $CI->MenuModel->get_by_form_and_column('counselor', 'qualification');
  $counties = $CI->CountyModel->get_all();

  $countyName = "";
  foreach ($counties as $value) {
    if ($value['no'] == $county) {
      $countyName = $value['name'];
    }
  }

  $executeMode = "";
  $executeWay = "";
  foreach ($executeModes as $value) {
    if ($value['no'] == $projects->execute_mode) {
      $executeMode = $value['content'];
    }
  }
  foreach ($executeWays as $value) {
    if ($value['no'] == $projects->execute_way) {
      $executeWay = $value['content'];
    }
  }

  $accumCounselingMemberCount = $CI->MemberModel->get_by_county_count($county, $monthType, $yearType);

  $trendTypeData = [];
  $trendTypeData['schoolNumber'] = $CI->MenuModel->get_no_resource_by_content('已就學(全職學生)', 'end_case')->no;
  $trendTypeData['workNumber'] = $CI->MenuModel->get_no_resource_by_content('已就業', 'end_case')->no;
  $trendTypeData['vocationalTrainingNumber'] = $CI->MenuModel->get_no_resource_by_content('參加職訓(說明)', 'end_case')->no;
  $trendTypeData['noPlanNumber'] = $CI->MenuModel->get_no_resource_by_content('尚無規劃，須持續輔導', 'end_case')->no;
  $trendTypeData['forceMajeureNumber'] = $CI->MenuModel->get_no_resource_by_content('不可抗力(說明)', 'end_case')->no;

  $trendTypeData['otherNumberOne'] = $CI->MenuModel->get_no_resource_by_content('半工半讀', 'end_case')->no;
  $trendTypeData['otherNumberTwo'] = $CI->MenuModel->get_no_resource_by_content('準備就業', 'end_case')->no;
  $trendTypeData['otherNumberThree'] = $CI->MenuModel->get_no_resource_by_content('準備就學', 'end_case')->no;
  $trendTypeData['otherNumberFour'] = $CI->MenuModel->get_no_resource_by_content('其他(說明)', 'end_case')->no;

  $monthMemberTempCounselings = $CI->MonthMemberTempCounselingModel->get_counseling_count_by_county_and_month($county, $monthType, $yearType, $trendTypeData);
  $newCaseMember = $CI->MemberModel->get_new_case($county, $monthType, $yearType);
  $newCaseCount = 0;
  foreach ($newCaseMember as $value) {
    if ($value['year'] == date("Y") - 1911) {
      $newCaseCount++;
    }
  }
  $oldCaseMember = $CI->MemberModel->get_old_case($county, $monthType, $yearType);
  $oldCaseCount = 0;
  foreach ($oldCaseMember as $value) {
    if ($value['year'] == date("Y") - 1911) {
      $oldCaseCount++;
    }
  }

  $sources = $CI->MenuModel->get_by_form_and_column('youth', 'source');
  foreach ($sources as $s) {
    if ($s['content'] == "轉介或自行開發") {
      $sourceReferral = $s['no'];
    } else if ($s['content'] == "動向調查") {
      $sourceSurvey = $s['no'];
    } else if ($s['content'] == "高中已錄取未註冊") {
      $sourceHigh = $s['no'];
    }
  }

  $twoYearSurvryCaseCount = $CI->MemberModel->get_two_year_survry_case_member($county, $monthType, $yearType);
  $oneYearSurvryCaseCount = $CI->MemberModel->get_one_year_survry_case_member($county, $monthType, $yearType);
  $nowYearSurvryCaseCount = $CI->MemberModel->get_now_year_survry_case_member($county, $monthType, $yearType);
  $nextYearSurvryCaseCount = $CI->MemberModel->get_next_year_survry_case_member($county, $monthType, $yearType);
  $highSchoolSurveryCaseCount = $CI->MemberModel->get_high_school_survry_case_member($county, $monthType, $yearType, $sourceHigh);

  $memberCounselingCount = $CI->ReportModel->get_member_counseling_by_county($county, $monthType, $yearType);

  $monthMemberTempNote = $CI->MonthMemberTempCounselingModel->get_by_county_and_month($county, $monthType, $yearType);
  $forceMajeureNote = $workTrainningNote = "";
  $forceMajeureNoteOne = "[不可抗力]" . "\n";
  $forceMajeureNoteTwo = "[其他]" . "\n";
  foreach ($monthMemberTempNote as $value) {
    if ($value['trend'] == $trendTypeData['forceMajeureNumber']) {
      $forceMajeureNoteOne = $forceMajeureNoteOne . $value['system_no'] . " " . $value['name'] . ": " . $value['trend_description'] . "\n";
    } elseif ($value['trend'] == $trendTypeData['otherNumberFour']) {
      $forceMajeureNoteTwo = $forceMajeureNoteTwo . $value['system_no'] . " " . $value['name'] . ": " . $value['trend_description'] . "\n";
    } elseif ($value['trend'] == $trendTypeData['vocationalTrainingNumber']) {
      $workTrainningNote = $workTrainningNote . $value['system_no'] . " " . $value['name'] . ": " . $value['trend_description'] . "\n";
    }
  }
  $forceMajeureNote = $forceMajeureNoteOne . $forceMajeureNoteTwo;

  $surveyTypeData = [];
    $surveyTypeData['schoolSource'] = $CI->MenuModel->get_no_resource_by_content('動向調查', 'youth')->no;
    $surveyTypeData['referralSource'] = $CI->MenuModel->get_no_resource_by_content('轉介或自行開發', 'youth')->no;
    $surveyTypeData['highSource'] = $CI->MenuModel->get_no_resource_by_content('高中已錄取未註冊', 'youth')->no;
    $counselEffectionCounts = $CI->ReportModel->get_counsel_effection_by_county($county, $yearType, $surveyTypeData);
    $keepMemberArray = $trendMemberArray = $endMemberArray = [];
    $youths = $CI->YouthModel->get_by_case_trend_and_county($county);
    foreach($youths as $value) {
      $isMember = $CI->MemberModel->is_member($value['no']);
      if ($isMember) {
        array_push($keepMemberArray, $value);    
      }
      else {
        $endDate = $value['end_date'];
        $originMonth = substr($endDate, 5, 2);
        
        $originMonthReview = $originSeasonalReview = 0;
        $value['originMonthReview'] = 0;
        $value['originSeasonalReview'] = 0;
        $value['alreadyMonthReview'] = 0;
        $value['alreadySeasonalReview'] = 0;

        if($originMonth + 6 > 12) {
          $temp = ($originMonth + 6) - 12;
          $originMonthReview = 12 - $originMonth;
          $temp = 6 - $originMonthReview;
          $originSeasonalReview = $temp / 3;
          $originSeasonalReview = ceil($originSeasonalReview);
          $value['originMonthReview'] = $originMonthReview;
          $value['originSeasonalReview'] = $originSeasonalReview;

        } else {
          $originMonthReview = 6;
          $originSeasonalReview = 0;
          $value['originMonthReview'] = $originMonthReview;
          $value['originSeasonalReview'] = $originSeasonalReview;
        }


        $alreadyMonthReview = count($CI->MonthReviewModel->get_by_member($value['memberNo']));
        $alreadySeasonalReview = count($CI->SeasonalReviewModel->get_by_youth($value['no']));
        $value['alreadyMonthReview'] = $alreadyMonthReview;
        $value['alreadySeasonalReview'] = $alreadySeasonalReview;

        $monthReview = $originMonthReview - $alreadyMonthReview;
        $seasonalReview = $originSeasonalReview - $alreadySeasonalReview;

        if($monthReview >= 0 && $seasonalReview >= 0 ) {
          array_push($trendMemberArray, $value); 
        } else {
          array_push($endMemberArray, $value);     
        }
      }
    }

    foreach($counselEffectionCounts as $i) {
      //$youthSum = ($i['schoolSourceCount'] + $i['highSourceCount'] + count($trendMemberArray));
      $youthSum = ($i['schoolSourceCount'] + $i['highSourceCount']);
    }

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle('表一.輔導人數統計表');
  $sheet->setCellValue('A1', $yearType . '年青少年生涯探索號計畫' . $monthType . '月輔導人數統計表');
  $sheet->mergeCells('A1:AD1');
  $sheet->setCellValue('AE1', '統計日期：' . (empty($counselingMemberCountReport) ? '' : $counselingMemberCountReport->date));
  $sheet->setCellValue('A2', '縣市');
  $sheet->mergeCells('A2:A4');
  $sheet->getColumnDimension('A')->setWidth(15);

  $sheet->setCellValue('B2', 'A核定關懷追蹤人數');
  $sheet->mergeCells('B2:D3');
  $sheet->getColumnDimension('B')->setWidth(7);
  $sheet->getColumnDimension('C')->setWidth(10);
  $sheet->getColumnDimension('D')->setWidth(10);

  $sheet->setCellValue('B4', 'B關懷人數');
  $sheet->getStyle('B4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
  
  $sheet->setCellValue('C4', 'C累積輔導人數(核定輔導人數)');
  $sheet->mergeCells('C4:D4');
  $sheet->getStyle('C4:D4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

  $sheet->setCellValue('E2', '關懷輔導成效');
  $sheet->mergeCells('E2:N2');

  $sheet->setCellValue('E3', '就學');
  $sheet->mergeCells('E3:F3');

  $sheet->setCellValue('E4', '關懷');
  $sheet->getStyle('E4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
  $sheet->setCellValue('F4', '輔導');
  $sheet->getStyle('F4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

  $sheet->setCellValue('G3', '就業');
  $sheet->mergeCells('G3:H3');
  $sheet->setCellValue('G4', '關懷');
  $sheet->getStyle('G4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
  $sheet->setCellValue('H4', '輔導');
  $sheet->getStyle('H4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

  $sheet->setCellValue('I3', '參加職訓');
  $sheet->mergeCells('I3:J3');
  $sheet->setCellValue('I4', '關懷');
  $sheet->getStyle('I4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
  $sheet->setCellValue('J4', '輔導');
  $sheet->getStyle('J4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

  $sheet->setCellValue('K3', '其他');
  $sheet->mergeCells('K3:L3');
  $sheet->setCellValue('K4', '關懷');
  $sheet->getStyle('K4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
  $sheet->setCellValue('L4', '輔導');
  $sheet->getStyle('L4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

  $sheet->setCellValue('M3', "小計\na");
  $sheet->mergeCells('M3:N3');
  $sheet->setCellValue('M4', '關懷');
  $sheet->getStyle('M4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
  $sheet->setCellValue('N4', '輔導');
  $sheet->getStyle('N4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

  $sheet->setCellValue('O2', "尚無動向或失聯\nb");
  $sheet->mergeCells('O2:P3');
  $sheet->getColumnDimension('O')->setWidth(13);
  $sheet->setCellValue('O4', '關懷');
  $sheet->getStyle('O4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
  $sheet->setCellValue('P4', '輔導');
  $sheet->getStyle('P4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

  $sheet->setCellValue('S2', "總計");
  $sheet->mergeCells('S2:S4');
  $sheet->getColumnDimension('S')->setWidth(0);

  $sheet->setCellValue('Q2', "不可抗力人數\n（司法安置、出國、死亡）\nc");
  $sheet->mergeCells('Q2:R3');
  $sheet->getColumnDimension('Q')->setWidth(13);
  $sheet->setCellValue('Q4', '關懷');
  $sheet->getStyle('Q4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
  $sheet->setCellValue('R4', '輔導');
  $sheet->getStyle('R4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

  $sheet->setCellValue('T2', '輔導對象來源');
  $sheet->mergeCells('T2:W2');
  $sheet->getStyle('T2:V2')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ebf1de');

  $sheet->setCellValue('T3', "本年度新開\n案個案人數");
  $sheet->getStyle('T3:T4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ebf1de');
  $sheet->getColumnDimension('T')->setWidth(13);
  $sheet->mergeCells('T3:T4');

  $sheet->setCellValue('U3', "前一年度持\n續輔導人數");
  $sheet->getColumnDimension('U')->setWidth(13);
  $sheet->mergeCells('U3:U4');

  $sheet->setCellValue('V3', "國中動向調查結\n果輔導人數");
  $sheet->getColumnDimension('V')->setWidth(13);
  $sheet->mergeCells('V3:V4');

  $sheet->setCellValue('W3', "高中已錄取未註冊動向調查結果輔導人數");
  $sheet->getColumnDimension('W')->setWidth(13);
  $sheet->mergeCells('W3:W4');

  $sheet->setCellValue('X2', '動向調查人數(學年度)');
  $sheet->mergeCells('X2:AB2');
  $sheet->getStyle('X2:AB2')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e4dfec');

  $sheet->setCellValue('X3', '國中未升學未就業動向調查');
  $sheet->getStyle('X3')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e4dfec');

  $sheet->setCellValue('AB3', '高中已錄取未註冊動向調查');
  $sheet->getStyle('AB3')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e4dfec');
  $sheet->getColumnDimension('AB')->setWidth(15);

  $sheet->setCellValue('X4', ($yearType - 4));
  $sheet->getStyle('X4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e4dfec');
  $sheet->getColumnDimension('X')->setWidth(10);
  $sheet->mergeCells('X3:AA3');
  $sheet->setCellValue('Y4', ($yearType - 3));
  $sheet->getStyle('Y4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e4dfec');
  $sheet->getColumnDimension('Y')->setWidth(10);
  //$sheet->mergeCells('Y3:Y4');
  $sheet->setCellValue('Z4', ($yearType - 2));
  $sheet->getStyle('Z4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e4dfec');
  $sheet->getColumnDimension('Z')->setWidth(10);
  //$sheet->mergeCells('Z3:Z4');
  $sheet->setCellValue('AA4', ($yearType - 1));
  $sheet->getStyle('AA4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e4dfec');
  $sheet->getColumnDimension('AA')->setWidth(0);
  //$sheet->mergeCells('AA3:AA4');
  $sheet->setCellValue('AB4', ($yearType - 1));
  $sheet->getStyle('AB4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e4dfec');
  $sheet->getColumnDimension('AB')->setWidth(10);
  //$sheet->mergeCells('AB3:AB4');
  $sheet->setCellValue('AC2', '備註');
  $sheet->mergeCells('AC2:AC4');
  $sheet->getColumnDimension('AC')->setWidth(20);
  $sheet->setCellValue('AD2', '辦理模式');
  $sheet->mergeCells('AD2:AD4');
  $sheet->setCellValue('AE2', '承辦單位');
  $sheet->mergeCells('AE2:AE4');
  $sheet->getColumnDimension('AE')->setWidth(20);
  $sheet->setCellValue('AF2', '執行單位');
  $sheet->mergeCells('AF2:AF4');
  $sheet->getColumnDimension('AF')->setWidth(25);

  $count = 5;

  if ($counselingMemberCountReport) {
      $sheet->setCellValue('A' . $count, $countyName);
      $sheet->mergeCells('A' . $count . ':A' . ($count+1));
      $sheet->setCellValue('B' . $count, $projects->counseling_youth); //TODO
      $sheet->mergeCells('B' . $count . ':D' . $count);

      $sheet->setCellValue('B' . ($count + 1), $youthSum); //TODO
      $sheet->getStyle('B' . ($count + 1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
      

      $sheet->setCellValue('C' . ($count + 1), $accumCounselingMemberCount . '(' . $projects->counseling_member . ')');
      $sheet->mergeCells('C' . ($count+1) . ':D' . ($count+1));
      $sheet->getStyle('C' . ($count+1) . ':D' . ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

      $sheet->setCellValue('E' . $count, $counselingMemberCountReport->school_youth + $counselingMemberCountReport->school_member);
      $sheet->mergeCells('E' . $count . ':F' . $count);
      $sheet->setCellValue('E' . ($count+1), $counselingMemberCountReport->school_youth);
      $sheet->getStyle('E'. ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
      $sheet->setCellValue('F' . ($count+1), $counselingMemberCountReport->school_member);
      $sheet->getStyle('F'. ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

      $sheet->setCellValue('G' . $count, $counselingMemberCountReport->work_youth + $counselingMemberCountReport->work_member);
      $sheet->mergeCells('G' . $count . ':H' . $count);
      $sheet->setCellValue('G' . ($count+1), $counselingMemberCountReport->work_youth);
      $sheet->getStyle('G'. ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
      $sheet->setCellValue('H' . ($count+1), $counselingMemberCountReport->work_member);
      $sheet->getStyle('H'. ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

      $sheet->setCellValue('I' . $count, $counselingMemberCountReport->vocational_training_youth + $counselingMemberCountReport->vocational_training_member);
      $sheet->mergeCells('I' . $count . ':J' . $count);
      $sheet->setCellValue('I' . ($count+1), $counselingMemberCountReport->vocational_training_youth);
      $sheet->getStyle('I'. ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
      $sheet->setCellValue('J' . ($count+1), $counselingMemberCountReport->vocational_training_member);
      $sheet->getStyle('J'. ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

      $sheet->setCellValue('K' . $count, $counselingMemberCountReport->other_youth + $counselingMemberCountReport->other_member);
      $sheet->mergeCells('K' . $count . ':L' . $count);
      $sheet->setCellValue('K' . ($count+1), $counselingMemberCountReport->other_youth);
      $sheet->getStyle('K'. ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
      $sheet->setCellValue('L' . ($count+1), $counselingMemberCountReport->other_member);
      $sheet->getStyle('L'. ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

      $sheet->setCellValue('M' . $count, $counselingMemberCountReport->school_youth + $counselingMemberCountReport->school_member 
                                          + $counselingMemberCountReport->other_youth + $counselingMemberCountReport->other_member
                                          + $counselingMemberCountReport->work_youth + $counselingMemberCountReport->work_member
                                          + $counselingMemberCountReport->vocational_training_youth + $counselingMemberCountReport->vocational_training_member);
      $sheet->mergeCells('M' . $count . ':N' . $count);
      $sheet->setCellValue('M' . ($count+1), $counselingMemberCountReport->school_youth + $counselingMemberCountReport->other_youth
                                              + $counselingMemberCountReport->work_youth + $counselingMemberCountReport->vocational_training_youth);
      $sheet->getStyle('M'. ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
      $sheet->setCellValue('N' . ($count+1), $counselingMemberCountReport->school_member + $counselingMemberCountReport->other_member
                                              + $counselingMemberCountReport->work_member + $counselingMemberCountReport->vocational_training_member);
      $sheet->getStyle('N'. ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
      
      $sheet->setCellValue('O' . $count, $counselingMemberCountReport->no_plan_youth + $counselingMemberCountReport->no_plan_member);
      $sheet->mergeCells('O' . $count . ':P' . $count);
      $sheet->setCellValue('O' . ($count+1), $counselingMemberCountReport->no_plan_youth);
      $sheet->getStyle('O'. ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
      $sheet->setCellValue('P' . ($count+1), $counselingMemberCountReport->no_plan_member);
      $sheet->getStyle('P'. ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

      $sheet->setCellValue('Q' . $count, $counselingMemberCountReport->force_majeure_youth + $counselingMemberCountReport->force_majeure_member);
      $sheet->mergeCells('Q' . $count . ':R' . $count);
      $sheet->setCellValue('Q' . ($count+1), $counselingMemberCountReport->force_majeure_youth);
      $sheet->getStyle('Q'. ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
      $sheet->setCellValue('R' . ($count+1), $counselingMemberCountReport->force_majeure_member);
      $sheet->getStyle('R'. ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

      $sheet->setCellValue('S' . $count, $counselingMemberCountReport->school_youth + $counselingMemberCountReport->school_member 
                                          + $counselingMemberCountReport->other_youth + $counselingMemberCountReport->other_member
                                          + $counselingMemberCountReport->work_youth + $counselingMemberCountReport->work_member
                                          + $counselingMemberCountReport->vocational_training_youth + $counselingMemberCountReport->vocational_training_member
                                          + $counselingMemberCountReport->no_plan_youth + $counselingMemberCountReport->no_plan_member
                                          + $counselingMemberCountReport->force_majeure_youth + $counselingMemberCountReport->force_majeure_member);
      $sheet->mergeCells('S' . $count . ':S' . ($count+1));

      $sheet->setCellValue('T' . $count, $counselingMemberCountReport ? $counselingMemberCountReport->new_case_member: '0');
      $sheet->mergeCells('T' . $count . ':T' . ($count+1));
      $sheet->getStyle('T' . $count . ':T' . ($count+1))->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ebf1de');
  
      $sheet->setCellValue('U' . $count, $counselingMemberCountReport ? $counselingMemberCountReport->old_case_member: '0');
      $sheet->mergeCells('U' . $count . ':U' . ($count+1));
  
      $sheet->setCellValue('V' . $count, $counselingMemberCountReport ? ($counselingMemberCountReport->two_year_survry_case_member + $counselingMemberCountReport->one_year_survry_case_member 
                                          + $counselingMemberCountReport->now_year_survry_case_member + $counselingMemberCountReport->next_year_survry_case_member) : '0');
      $sheet->mergeCells('V' . $count . ':V' . ($count+1));

      $sheet->setCellValue('W' . $count, $counselingMemberCountReport ? $counselingMemberCountReport->high_school_survry_case_member : '0');
      $sheet->mergeCells('W' . $count . ':W' . ($count+1));
      
      $sheet->setCellValue('X' . $count, $counselingMemberCountReport ? $counselingMemberCountReport->two_year_survry_case_member : '0');
      $sheet->mergeCells('X' . $count . ':X' . ($count+1));
  
      $sheet->setCellValue('Y' . $count, $counselingMemberCountReport ? $counselingMemberCountReport->one_year_survry_case_member : '0');
      $sheet->mergeCells('Y' . $count . ':Y' . ($count+1));
  
      $sheet->setCellValue('Z' . $count, $counselingMemberCountReport ? $counselingMemberCountReport->now_year_survry_case_member : '0');
      $sheet->mergeCells('Z' . $count . ':Z' . ($count+1));
  
      $sheet->setCellValue('AA' . $count, $counselingMemberCountReport ? $counselingMemberCountReport->next_year_survry_case_member : '0');
      $sheet->mergeCells('AA' . $count . ':AA' . ($count+1));
  
      $sheet->setCellValue('AB' . $count, $counselingMemberCountReport ? $counselingMemberCountReport->high_school_survry_case_member : '0');
      $sheet->mergeCells('AB' . $count . ':AB' . ($count+1));
  
      $sheet->setCellValue('AC' . $count, $counselingMemberCountReport ? $counselingMemberCountReport->other_note : '無資料');
      $sheet->getStyle('AC' . $count)->getFont()->getColor()->setARGB(Style\Color::COLOR_RED);
      $sheet->mergeCells('AC' . $count . ':AC' . ($count+1));
      
      $sheet->setCellValue('AD' . $count, substr($executeMode, 0, 9));
      $sheet->mergeCells('AD' . $count . ':AD' . ($count+1));
  
      $sheet->setCellValue('AE' . $count, $countyAndOrg->orgnizer);
      $sheet->mergeCells('AE' . $count . ':AE' . ($count+1));
  
      $sheet->setCellValue('AF' . $count, $countyAndOrg->organizationName);
      $sheet->mergeCells('AF' . $count . ':AF' . ($count+1));
  }

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray)-1] . ($count+1))->applyFromArray($styleArray);

  $count += 3;
  $sheet->setCellValue('C' . $count, '承辦人');
  $sheet->getStyle('C' . $count)->getFont()->setSize(18);
  $sheet->setCellValue('I' . $count, '單位主管');
  $sheet->getStyle('I' . $count)->getFont()->setSize(18);
  $sheet->setCellValue('M' . $count, '教育局(處)首長');
  $sheet->getStyle('M' . $count)->getFont()->setSize(18);

  return $sheet;
}

function county_month_counselorManpowerReport($sheet, $yearType, $monthType, $county) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('ProjectModel');
  $CI->load->model('CountyModel');
  $CI->load->model('CounselorManpowerReportModel');
  $CI->load->model('MemberModel');

  $projects = $CI->ProjectModel->get_latest_by_county($county);
  $countyAndOrg = $CI->CountyModel->get_by_county($county);
  $counselorManpowerReports = $CI->CounselorManpowerReportModel->get_by_no($yearType, $monthType, $county);
  $executeModes = $CI->MenuModel->get_by_form_and_column('project', 'execute_mode');
  $executeWays = $CI->MenuModel->get_by_form_and_column('project', 'execute_way');
  $counties = $CI->CountyModel->get_all();

  $countyName = "";
  foreach ($counties as $value) {
    if ($value['no'] == $county) {
      $countyName = $value['name'];
    }
  }

  $executeMode = "";
  foreach ($executeModes as $value) {
    if ($value['no'] == $projects->execute_mode) {
      $executeMode = $value['content'];
    }
  }

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    if($column != 'Q') $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle('表二.輔導人力概況表');
  $sheet->setCellValue('A1', $yearType . '年青少年生涯探索號計畫' . $monthType . '月輔導人力概況表');
  $sheet->mergeCells('A1:M1');
  $sheet->setCellValue('N1', '統計日期：' . (empty($counselorManpowerReports) ? '' : $counselorManpowerReports->date));
  $sheet->setCellValue('A2', '縣市');
  $sheet->mergeCells('A2:A3');
  $sheet->getColumnDimension('A')->setWidth(7);
  $sheet->setCellValue('B2', '辦理模式');
  $sheet->mergeCells('B2:B3');
  $sheet->getColumnDimension('E')->setWidth(5);
  $sheet->setCellValue('C2', "專任輔\n導人員");
  $sheet->mergeCells('C2:D2');
  $sheet->getRowDimension('2')->setRowHeight(30);
  $sheet->setCellValue('C3', '預估');
  $sheet->getColumnDimension('C')->setWidth(5);
  $sheet->setCellValue('D3', '實際');
  $sheet->getColumnDimension('D')->setWidth(5);
  $sheet->setCellValue('E2', '輔導人員隸屬');
  $sheet->mergeCells('E2:H2');
  $sheet->getStyle('E2:H2')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fcd6b4');
  $sheet->setCellValue('E3', '教育局處');
  $sheet->getColumnDimension('E')->setWidth(5);
  $sheet->getStyle('E3')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
  $sheet->setCellValue('F3', '輔諮中心');
  $sheet->getStyle('F3')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
  $sheet->getColumnDimension('F')->setWidth(5);
  $sheet->setCellValue('G3', '學校');
  $sheet->getStyle('G3')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
  $sheet->getColumnDimension('G')->setWidth(5);
  $sheet->setCellValue('H3', '委外單位');
  $sheet->getStyle('H3')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
  $sheet->getColumnDimension('H')->setWidth(5);
  $sheet->setCellValue('I2', '學歷');
  $sheet->mergeCells('I2:J2');
  $sheet->getStyle('I2:J2')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d8e4bc');
  $sheet->setCellValue('I3', '學士');
  $sheet->getColumnDimension('I')->setWidth(5);
  $sheet->setCellValue('J3', '碩士');
  $sheet->getColumnDimension('J')->setWidth(5);
  $sheet->setCellValue('K2', '證照');
  $sheet->mergeCells('K2:M2');
  $sheet->getStyle('K2:M2')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fcd6b4');
  $sheet->setCellValue('K3', "具社會工作師證照");
  $sheet->getStyle('K3')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
  $sheet->getColumnDimension('K')->setWidth(20);
  $sheet->setCellValue('L3', "具心理師證照");
  $sheet->getStyle('L3')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
  $sheet->getColumnDimension('L')->setWidth(20);
  $sheet->setCellValue('M3', '無證照相關系所');
  $sheet->getStyle('M3')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
  $sheet->getColumnDimension('M')->setWidth(20);
  $sheet->setCellValue('N2', '備註(到職日)');
  $sheet->mergeCells('N2:N3');
  $sheet->getColumnDimension('N')->setWidth(30);
  $sheet->getRowDimension('4')->setRowHeight(80);
  $sheet->getStyle('N2:N3')->getAlignment()->setHorizontal('center');

  $count = 4;

  if ($counselorManpowerReports) {
    $sheet->setCellValue('A' . $count, $countyName);
    $sheet->setCellValue('B' . $count, substr($executeMode, 0, 9));
    $sheet->setCellValue('C' . $count, $counselorManpowerReports->project_counselor);
    $sheet->setCellValue('D' . $count, $counselorManpowerReports->really_counselor);
    $sheet->setCellValue('E' . $count, $counselorManpowerReports->education_counselor);
    $sheet->getStyle('E'. $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
    $sheet->setCellValue('F' . $count, $counselorManpowerReports->counseling_center_counselor);
    $sheet->getStyle('F'. $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
    $sheet->setCellValue('G' . $count, $counselorManpowerReports->school_counselor);
    $sheet->getStyle('G'. $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
    $sheet->setCellValue('H' . $count, $counselorManpowerReports->outsourcing_counselor);
    $sheet->getStyle('H'. $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
    $sheet->setCellValue('I' . $count, $counselorManpowerReports->bachelor_degree);
    $sheet->setCellValue('J' . $count, $counselorManpowerReports->master_degree);
    $sheet->setCellValue('K' . $count, $counselorManpowerReports->qualification_three);
    $sheet->getStyle('K'. $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
    $sheet->setCellValue('L' . $count, $counselorManpowerReports->qualification_four);
    $sheet->getStyle('L'. $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
    $sheet->setCellValue('M' . $count, $counselorManpowerReports->qualification_one + $counselorManpowerReports->qualification_two 
                                        + $counselorManpowerReports->qualification_five + $counselorManpowerReports->qualification_six);
    $sheet->getStyle('M'. $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
    $sheet->setCellValue('N' . $count, $counselorManpowerReports->note);
  }

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray)-1] . ($count))->applyFromArray($styleArray);

  $count += 3;
  $sheet->setCellValue('C' . $count, '承辦人');
  $sheet->getStyle('C' . $count)->getFont()->setSize(18);
  $sheet->setCellValue('I' . $count, '單位主管');
  $sheet->getStyle('I' . $count)->getFont()->setSize(18);
  $sheet->setCellValue('M' . $count, '教育局(處)首長');
  $sheet->getStyle('M' . $count)->getFont()->setSize(18);

  return $sheet;
}

function county_month_CounselingIdentityCountReport($sheet, $yearType, $monthType, $county) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('ProjectModel');
  $CI->load->model('CountyModel');
  $CI->load->model('CounselingIdentityCountReportModel');
  $CI->load->model('MemberModel');

  $projects = $CI->ProjectModel->get_latest_by_county($county);
  $countyAndOrg = $CI->CountyModel->get_by_county($county);
  $get_inserted_identity_count_data = $CI->CounselingIdentityCountReportModel->get_inserted_identity_count_data($yearType, $monthType, $projects->no);
  $executeModes = $CI->MenuModel->get_by_form_and_column('project', 'execute_mode');
  $executeWays = $CI->MenuModel->get_by_form_and_column('project', 'execute_way');
  $counties = $CI->CountyModel->get_all();

  $countyName = "";
  foreach ($counties as $value) {
    if ($value['no'] == $county) {
      $countyName = $value['name'];
    }
  }

  $executeMode = "";
  $executeWay = "";
  foreach ($executeModes as $value) {
    if ($value['no'] == $projects->execute_mode) {
      $executeMode = $value['content'];
    }
  }

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle('表三.輔導對象身分統計表');
  $sheet->setCellValue('A1', $yearType . '年青少年生涯探索號計畫' . $monthType . '月輔導對象身分統計表');
  $sheet->mergeCells('A1:K1');
  $sheet->setCellValue('L1', '統計日期：' . (empty($get_inserted_identity_count_data) ? '' : $get_inserted_identity_count_data->date));
  $sheet->mergeCells('L1:M1');
  $sheet->setCellValue('A2', '類別');
  $sheet->mergeCells('A2:A3');
  $sheet->setCellValue('B2', "中輟滿16歲未升學未就業\nA");
  $sheet->mergeCells('B2:D3');
  $sheet->getColumnDimension('B')->setWidth(10);
  $sheet->getColumnDimension('C')->setWidth(10);
  $sheet->getColumnDimension('D')->setWidth(12);
  $sheet->setCellValue('E2', "國中畢(結)業未就學未就業B");
  $sheet->mergeCells('E2:I2');
  $sheet->getColumnDimension('E')->setWidth(10);
  $sheet->getColumnDimension('F')->setWidth(10);
  $sheet->getColumnDimension('G')->setWidth(10);
  $sheet->getColumnDimension('H')->setWidth(10);
  $sheet->getColumnDimension('I')->setWidth(12);
  $sheet->setCellValue('J2', "高中中離\nC");
  $sheet->mergeCells('J2:L3');
  $sheet->getColumnDimension('K')->setWidth(10);
  $sheet->getColumnDimension('K')->setWidth(10);
  $sheet->getColumnDimension('L')->setWidth(12);
  $sheet->setCellValue('M2', "合計");
  $sheet->mergeCells('M2:M4');
  $sheet->getStyle('M2:M4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');

  $sheet->setCellValue('A4', '縣市別');
  $sheet->setCellValue('B4', '男');
  $sheet->setCellValue('C4', '女');
  $sheet->setCellValue('D4', '小計');
  $sheet->getStyle('D4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
  $sheet->setCellValue('E4', '男');
  $sheet->setCellValue('F4', '女');
  $sheet->setCellValue('G4', '男');
  $sheet->setCellValue('H4', '女');
  $sheet->setCellValue('E3', '應屆');
  $sheet->mergeCells('E3:F3');
  $sheet->setCellValue('G3', '非應屆');
  $sheet->mergeCells('G3:H3');
  $sheet->setCellValue('I3', '小計');
  $sheet->mergeCells('I3:I4');
  $sheet->getStyle('I3:I4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
  $sheet->setCellValue('J4', '男');
  $sheet->setCellValue('K4', '女');
  $sheet->setCellValue('L4', '小計');
  $sheet->getStyle('L4')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');

  $count = 5;

  if ($get_inserted_identity_count_data) {
    $sheet->setCellValue('A' . $count, $countyName);
    $sheet->setCellValue('B' . $count, $get_inserted_identity_count_data->sixteen_years_old_not_employed_not_studying_boy);
    $sheet->setCellValue('C' . $count, $get_inserted_identity_count_data->sixteen_years_old_not_employed_not_studying_girl);
    $sheet->setCellValue('D' . $count, $get_inserted_identity_count_data->sixteen_years_old_not_employed_not_studying_boy + $get_inserted_identity_count_data->sixteen_years_old_not_employed_not_studying_girl);
    $sheet->getStyle('D' . $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
    $sheet->setCellValue('E' . $count, $get_inserted_identity_count_data->junior_graduated_this_year_unemployed_not_studying_boy);
    $sheet->setCellValue('F' . $count, $get_inserted_identity_count_data->junior_graduated_this_year_unemployed_not_studying_girl);
    $sheet->setCellValue('G' . $count, $get_inserted_identity_count_data->junior_graduated_not_this_year_unemployed_not_studying_boy);
    $sheet->setCellValue('H' . $count, $get_inserted_identity_count_data->junior_graduated_not_this_year_unemployed_not_studying_girl);
    $sheet->setCellValue('I' . $count, $get_inserted_identity_count_data->junior_graduated_this_year_unemployed_not_studying_boy + $get_inserted_identity_count_data->junior_graduated_this_year_unemployed_not_studying_girl 
      + $get_inserted_identity_count_data->junior_graduated_not_this_year_unemployed_not_studying_boy + $get_inserted_identity_count_data->junior_graduated_not_this_year_unemployed_not_studying_girl);
    $sheet->getStyle('I' . $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
    $sheet->setCellValue('J' . $count, $get_inserted_identity_count_data->drop_out_from_senior_boy);
    $sheet->setCellValue('K' . $count, $get_inserted_identity_count_data->drop_out_from_senior_girl);
    $sheet->setCellValue('L' . $count, $get_inserted_identity_count_data->drop_out_from_senior_boy + $get_inserted_identity_count_data->drop_out_from_senior_girl);
    $sheet->getStyle('L' . $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
    $sum = $get_inserted_identity_count_data->sixteen_years_old_not_employed_not_studying_boy + $get_inserted_identity_count_data->sixteen_years_old_not_employed_not_studying_girl
     + $get_inserted_identity_count_data->junior_graduated_this_year_unemployed_not_studying_boy + $get_inserted_identity_count_data->junior_graduated_this_year_unemployed_not_studying_girl 
     + $get_inserted_identity_count_data->junior_graduated_not_this_year_unemployed_not_studying_boy + $get_inserted_identity_count_data->junior_graduated_not_this_year_unemployed_not_studying_girl
     + $get_inserted_identity_count_data->drop_out_from_senior_boy + $get_inserted_identity_count_data->drop_out_from_senior_girl;

    $sheet->setCellValue('M' . $count, $sum);
    $sheet->getStyle('M' . $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fde9d9');
    // $sum = ($sum == 0) ? 1 : $sum;
    // $QValue = round(($get_inserted_identity_count_data->junior_under_graduate_boy + $get_inserted_identity_count_data->junior_under_graduate_girl) / $sum, 2) * 100;
    // $sheet->setCellValue('Q' . $count, $QValue . '%');
    // if ($QValue >= 30) {
    //   $sheet->getStyle('Q' . $count)->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('B4F2EA');
    // }
  }

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray)-1] . ($count))->applyFromArray($styleArray);

  $count += 3;
  $sheet->setCellValue('C' . $count, '承辦人');
  $sheet->getStyle('C' . $count)->getFont()->setSize(18);
  $sheet->setCellValue('G' . $count, '單位主管');
  $sheet->getStyle('G' . $count)->getFont()->setSize(18);
  $sheet->setCellValue('L' . $count, '教育局(處)首長');
  $sheet->getStyle('L' . $count)->getFont()->setSize(18);

  return $sheet;
}

function county_month_CounselingMeetingCountRepor($sheet, $yearType, $monthType, $county) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('ProjectModel');
  $CI->load->model('CountyModel');
  $CI->load->model('CounselingMeetingCountReportModel');
  $CI->load->model('MemberModel');

  $projects = $CI->ProjectModel->get_latest_by_county($county);
  $countyAndOrg = $CI->CountyModel->get_by_county($county);
  $get_inserted_meeting_count_data = $CI->CounselingMeetingCountReportModel->get_inserted_meeting_count_data($yearType, $monthType, $projects->no);
  $executeModes = $CI->MenuModel->get_by_form_and_column('project', 'execute_mode');
  $executeWays = $CI->MenuModel->get_by_form_and_column('project', 'execute_way');
  $counties = $CI->CountyModel->get_all();

  $countyName = "";
  foreach ($counties as $value) {
    if ($value['no'] == $county) {
      $countyName = $value['name'];
    }
  }

  $executeMode = "";
  $executeWay = "";
  foreach ($executeModes as $value) {
    if ($value['no'] == $projects->execute_mode) {
      $executeMode = $value['content'];
    }
  }

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    if($column != 'I') $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle('表四.辦理會議或講座統計表');
  $sheet->setCellValue('A1', $yearType . '年青少年生涯探索號計畫' . $monthType . '月辦理會議或講座統計表');
  $sheet->mergeCells('A1:G1');
  $sheet->setCellValue('I1', '統計日期：' . (empty($get_inserted_meeting_count_data) ? '' : $get_inserted_meeting_count_data->date));
  
  $sheet->setCellValue('A2', '縣市');
  $sheet->setCellValue('B2', "預計辦理跨局\n處會議場次");
  $sheet->getColumnDimension('B')->setWidth(15);
  $sheet->setCellValue('C2', "目前辦理跨局\n處會議時間");
  $sheet->getColumnDimension('c')->setWidth(15);
  $sheet->setCellValue('D2', '加總');
  $sheet->getStyle('D2')->getFill()->setFillType(Style\Fill::FILL_SOLID)->getStartColor()->setARGB('9BC9C9');
  $sheet->getColumnDimension('D')->setWidth(0);
  $sheet->setCellValue('E2', "預計辦理\n講座場次");
  $sheet->getColumnDimension('E')->setWidth(5);
  $sheet->setCellValue('F2', "目前辦理\n講座場次");
  $sheet->getColumnDimension('F')->setWidth(5);
  $sheet->setCellValue('G2', "預計講座\n參與人次");
  $sheet->getColumnDimension('G')->setWidth(5);
  $sheet->setCellValue('H2', "目前講座\n參與人次");
  $sheet->getColumnDimension('H')->setWidth(5);
  $sheet->setCellValue('I2', '備註(跨局處會議時間、名稱)');
  $sheet->getColumnDimension('I')->setWidth(50);

  $count = 3;

  if ($get_inserted_meeting_count_data) {
    $sheet->setCellValue('A' . $count, $countyName);
    $sheet->setCellValue('B' . $count, $projects->meeting_count);
    $sheet->setCellValue('C' . $count, $get_inserted_meeting_count_data->time_note);
    $sheet->setCellValue('E' . $count, $get_inserted_meeting_count_data->planning_holding_meeting_count);
    $sheet->setCellValue('F' . $count, $get_inserted_meeting_count_data->actual_holding_meeting_count);
    $sheet->setCellValue('G' . $count, $get_inserted_meeting_count_data->planning_involved_people);
    $sheet->setCellValue('H' . $count, $get_inserted_meeting_count_data->actual_involved_people);
    $sheet->setCellValue('I' . $count, $get_inserted_meeting_count_data->meeting_count_note);
  }

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray)-1] . ($count))->applyFromArray($styleArray);

  $count += 3;
  $sheet->setCellValue('B' . $count, '承辦人');
  $sheet->getStyle('B' . $count)->getFont()->setSize(18);
  $sheet->setCellValue('E' . $count, '單位主管');
  $sheet->getStyle('E' . $count)->getFont()->setSize(18);
  $sheet->setCellValue('I' . $count, '教育局(處)首長');
  $sheet->getStyle('I' . $count)->getFont()->setSize(18);

  return $sheet;
}

function county_month_HighSchoolTrendSurveyCountReport($sheet, $yearType, $monthType, $countyType) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('ProjectModel');
  $CI->load->model('CountyModel');
  $CI->load->model('HighSchoolTrendSurveyCountReportModel');
  $CI->load->model('MemberModel');
  $CI->load->helper('report');



  $tableValue = $CI->HighSchoolTrendSurveyCountReportModel->get_by_all($yearType, $monthType, $countyType);

  if ($countyType == 'all') $counties = $CI->CountyModel->get_all();
  else $counties = $CI->CountyModel->get_one($countyType);
 
  $sheet->setTitle('表九.高中已錄取未註冊動向調查結果後續追蹤表');
  $sheet = month_report_track_header($sheet, $tableValue, null, null);

  return $sheet;
}

function county_month_TwoYearsTrendSurveyCountReport($sheet, $yearType, $monthType, $countyType) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('ProjectModel');
  $CI->load->model('CountyModel');
  $CI->load->model('TwoYearsTrendSurveyCountReportModel');
  $CI->load->model('MemberModel');
  $CI->load->helper('report');



  $tableValue = $CI->TwoYearsTrendSurveyCountReportModel->get_by_all($yearType, $monthType, $countyType);

  if ($countyType == 'all') $counties = $CI->CountyModel->get_all();
  else $counties = $CI->CountyModel->get_one($countyType);
 
  $sheet->setTitle('表五.' . ($yearType - 4) . '學年度國中動向調查結果後續追蹤表');
  $sheet = month_report_track_header($sheet, $tableValue, null, null);

  return $sheet;
}

function county_month_OneYearsTrendSurveyCountReport($sheet, $yearType, $monthType, $countyType) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('ProjectModel');
  $CI->load->model('CountyModel');
  $CI->load->model('OneYearsTrendSurveyCountReportModel');
  $CI->load->model('MemberModel');
  
  $tableValue = $CI->OneYearsTrendSurveyCountReportModel->get_by_all($yearType, $monthType, $countyType);

  if ($countyType == 'all') $counties = $CI->CountyModel->get_all();
  else $counties = $CI->CountyModel->get_one($countyType);
 
  $sheet->setTitle('表六.' . ($yearType - 3) . '學年度國中動向調查結果後續追蹤表');
  $sheet = month_report_track_header($sheet, $tableValue, null, null);

  return $sheet;
}

function county_month_NowYearsTrendSurveyCountReport($sheet, $yearType, $monthType, $countyType) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('ProjectModel');
  $CI->load->model('CountyModel');
  $CI->load->model('OneYearsTrendSurveyCountReportModel');
  $CI->load->model('MemberModel');
  $tableValue = $CI->NowYearsTrendSurveyCountReportModel->get_by_all($yearType, $monthType, $countyType);

  if ($countyType == 'all') $counties = $CI->CountyModel->get_all();
  else $counties = $CI->CountyModel->get_one($countyType);
 
  $sheet->setTitle('表七.' . ($yearType - 2) . '學年度國中動向調查結果後續追蹤表');
  $sheet = month_report_track_header($sheet, $tableValue, null, null);

  return $sheet;
}

function county_month_OldCaseTrendSurveyCountReport($sheet, $yearType, $monthType, $countyType) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('ProjectModel');
  $CI->load->model('CountyModel');
  $CI->load->model('OldCaseTrendSurveyCountReportModel');
  $CI->load->model('MemberModel');

  $tableValue = $CI->OldCaseTrendSurveyCountReportModel->get_by_all($yearType, $monthType, $countyType, 195);

  if ($countyType == 'all') $counties = $CI->CountyModel->get_all();
  else $counties = $CI->CountyModel->get_one($countyType);
 
  $sheet->setTitle('表八.前一年度開案後續追蹤表');
  $sheet = month_report_track_header($sheet, $tableValue, null, null);

  return $sheet;
}

function yda_report_countyDelegateOrganization($sheet, $countyType, $year) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');

  $countyDelegateOrganizations = $CI->ReportModel->get_county_delegate_organization($countyType, $year);
  $executeModes = $CI->MenuModel->get_by_form_and_column('project', 'execute_mode');
  $executeWays = $CI->MenuModel->get_by_form_and_column('project', 'execute_way');

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle($year . '年縣市計畫資訊');
  $sheet->setCellValue('A1', '縣市');
  $sheet->setCellValue('B1', '計畫名稱');
  $sheet->getColumnDimension('B')->setWidth(30);
  $sheet->setCellValue('C1', '機構名稱');
  $sheet->getColumnDimension('C')->setWidth(30);
  $sheet->setCellValue('D1', '機構電話');
  $sheet->getColumnDimension('D')->setWidth(25);
  $sheet->setCellValue('E1', '機構地址');
  $sheet->getColumnDimension('E')->setWidth(30);
  $sheet->setCellValue('F1', '辦理模式');
  $sheet->setCellValue('G1', '辦理方式');
  $sheet->setCellValue('H1', '輔導員數量');
  $sheet->getColumnDimension('H')->setWidth(12);
  $sheet->setCellValue('I1', "跨局處會議\n次數");
  $sheet->getColumnDimension('I')->setWidth(12);
  $sheet->setCellValue('J1', "輔導人數");
  $sheet->getColumnDimension('J')->setWidth(12);
  $sheet->setCellValue('K1', "關懷人數");
  $sheet->getColumnDimension('K')->setWidth(12);
  $sheet->setCellValue('L1', "個別輔導\n小時");
  $sheet->getColumnDimension('L')->setWidth(12);
  $sheet->setCellValue('M1', "團體輔導\n小時");
  $sheet->getColumnDimension('M')->setWidth(12);
  $sheet->setCellValue('N1', "生涯探索\n課程小時");
  $sheet->getColumnDimension('N')->setWidth(12);
  $sheet->setCellValue('O1', "工作體驗\n人數");
  $sheet->getColumnDimension('O')->setWidth(12);
  $sheet->setCellValue('P1', "工作體驗\n小時");
  $sheet->getColumnDimension('P')->setWidth(12);
  $sheet->setCellValue('Q1', '計畫經費');
  $sheet->getColumnDimension('Q')->setWidth(12);

  $count = 1;
  foreach ($countyDelegateOrganizations as $value) {
    $count++;
    $sheet->setCellValue('A' . $count, $value['countyName']);
    $sheet->setCellValue('B' . $count, $value['projectName']);
    $sheet->setCellValue('C' . $count, $value['organizationName']);
    $sheet->setCellValue('D' . $count, $value['organizationPhone']);
    $sheet->setCellValue('E' . $count, $value['organizationAddress']);
    foreach ($executeModes as $i) {
        if ($i['no'] == $value['executeMode']) {
            $sheet->setCellValue('F' . $count, substr($i['content'], 0, 9));
        }
    }
    foreach ($executeWays as $i) {
        if ($i['no'] == $value['executeWay']) {
            $sheet->setCellValue('G' . $count, $i['content']);
        }
    }
    $sheet->setCellValue('H' . $count, $value['counselorCount']);
    $sheet->setCellValue('I' . $count, $value['meetingCount']);
    $sheet->setCellValue('J' . $count, $value['counselingMember']);
    $sheet->setCellValue('K' . $count, $value['counselingYouth']);
    $sheet->setCellValue('L' . $count, $value['counselingHour']);
    $sheet->setCellValue('M' . $count, $value['groupCounselingHour']);
    $sheet->setCellValue('N' . $count, $value['courseHour']);
    $sheet->setCellValue('O' . $count, $value['workingMember']);
    $sheet->setCellValue('P' . $count, $value['workingHour']);
    $sheet->setCellValue('Q' . $count, $value['funding'] ? number_format($value['funding']) : 0);
  }

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray)-1] . $count)->applyFromArray($styleArray);

  return $sheet;
}

function yda_report_counselEffection($sheet, $countyType, $year) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->helper('report');

  $surveyTypeData = [];
  $surveyTypeData['schoolSource'] = $CI->MenuModel->get_no_resource_by_content('動向調查', 'youth')->no;
  $surveyTypeData['referralSource'] = $CI->MenuModel->get_no_resource_by_content('轉介或自行開發', 'youth')->no;
  $surveyTypeData['highSource'] = $CI->MenuModel->get_no_resource_by_content('高中已錄取未註冊', 'youth')->no;
  $counselEffectionCounts = $CI->ReportModel->get_counsel_effection_by_county($countyType, $year, $surveyTypeData);

  $sumDetail = [];
  $sumDetail['schoolSourceCount'] = $sumDetail['highSourceCount'] = $sumDetail['referralSourceCount'] = $sumDetail['memberCount']
    = $sumDetail['seasonalReviewCount'] = $sumDetail['monthReviewCount'] = $sumDetail['individualCounselingCount'] = $sumDetail['groupCounselingCount']
    = $sumDetail['courseAttendanceCount'] = $sumDetail['workAttendanceCount'] = $sumDetail['endCaseCount'] = 0;

  $trendMemberArray = [];
  foreach ($counselEffectionCounts as $i) {
    $trendMember = get_end_case_track_youth($i['no']);
    $sumDetail['schoolSourceCount'] += ($i['schoolSourceCount'] + count($trendMember));
    $sumDetail['highSourceCount'] += $i['highSourceCount'];
    $sumDetail['memberCount'] += $i['memberCount'];
    $sumDetail['seasonalReviewCount'] += $i['seasonalReviewCount'];
    $sumDetail['monthReviewCount'] += $i['monthReviewCount'];
    $sumDetail['individualCounselingCount'] += $i['individualCounselingCount'];
    $sumDetail['groupCounselingCount'] += $i['groupCounselingCount'];
    $sumDetail['courseAttendanceCount'] += $i['courseAttendanceCount'];
    $sumDetail['workAttendanceCount'] += $i['workAttendanceCount'];
    $sumDetail['endCaseCount'] += $i['endCaseCount'];
    array_push($trendMemberArray, count($trendMember));
  }

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle($year . '年輔導成效統計表');
  $sheet->setCellValue('A1', '縣市');
  $sheet->mergeCells('A1:A2');
  $sheet->setCellValue('B1', '青少年總人數');
  $sheet->mergeCells('B1:B2');
  $sheet->setCellValue('C1', '學員總人數');
  $sheet->mergeCells('C1:C2');
  $sheet->setCellValue('D1', '關懷追蹤');
  $sheet->mergeCells('D1:E1');
  $sheet->setCellValue('D2', '季追蹤');
  $sheet->setCellValue('E2', '月追蹤');
  $sheet->setCellValue('F1', "措施A\n總計時數");
  $sheet->getColumnDimension('F')->setWidth(12);
  $sheet->mergeCells('F1:G1');
  $sheet->setCellValue('F2', '個別輔導');
  $sheet->setCellValue('G2', '團體輔導');
  $sheet->setCellValue('H1', "措施B課程\n總計時數");
  $sheet->getColumnDimension('H')->setWidth(12);
  $sheet->mergeCells('H1:H2');
  $sheet->setCellValue('I1', "措施C工作\n總計時數");
  $sheet->getColumnDimension('I')->setWidth(12);
  $sheet->mergeCells('I1:I2');
  $sheet->setCellValue('J1', '結案總人數');
  $sheet->getColumnDimension('J')->setWidth(12);
  $sheet->mergeCells('J1:J2');

  $index = 0;
  $count = 3;
  foreach ($counselEffectionCounts as $value) {
    
    $sheet->setCellValue('A' . $count, $value['name']);
    $sheet->mergeCells('A' . $count . ':A' . ($count + 1));
    $sheet->setCellValue('B' . $count, $value['schoolSourceCount'] + $value['highSourceCount'] + $trendMemberArray[$index]);
    $sheet->mergeCells('B' . $count . ':B' . ($count + 1));
    $sheet->setCellValue('C' . $count, $value['memberCount']);
    $sheet->mergeCells('C' . $count . ':C' . ($count + 1));
    $sheet->setCellValue('D' . $count, $value['seasonalReviewCount'] + $value['monthReviewCount']);
    $sheet->mergeCells('D' . $count . ':E' . $count);
    $sheet->setCellValue('D' . ($count + 1), $value['seasonalReviewCount']);
    $sheet->setCellValue('E' . ($count + 1), $value['monthReviewCount']);
    $sheet->setCellValue('F' . $count, $value['individualCounselingCount'] + $value['groupCounselingCount']);
    $sheet->mergeCells('F' . $count . ':G' . $count);
    $sheet->setCellValue('F' . ($count + 1), $value['individualCounselingCount']);
    $sheet->setCellValue('G' . ($count + 1), $value['groupCounselingCount']);
    $sheet->setCellValue('H' . $count, $value['courseAttendanceCount']);
    $sheet->mergeCells('H' . $count . ':H' . ($count + 1));
    $sheet->setCellValue('I' . $count, $value['workAttendanceCount']);
    $sheet->mergeCells('I' . $count . ':I' . ($count + 1));
    $sheet->setCellValue('J' . $count, $value['endCaseCount']);
    $sheet->mergeCells('J' . $count . ':J' . ($count + 1));
    $count = $count + 2;
    $index++;
  }

  //$count = $count + 2;
  $sheet->setCellValue('A' . $count, '總計');
  $sheet->mergeCells('A' . $count . ':A' . ($count + 1));
  $sheet->setCellValue('B' . $count, $sumDetail['schoolSourceCount'] + $sumDetail['highSourceCount']);
  $sheet->mergeCells('B' . $count . ':B' . ($count + 1));

  $sheet->setCellValue('C' . $count, $sumDetail['memberCount']);
  $sheet->mergeCells('C' . $count . ':C' . ($count + 1));

  $sheet->setCellValue('D' . $count, $sumDetail['seasonalReviewCount'] + $sumDetail['monthReviewCount']);
  $sheet->mergeCells('D' . $count . ':E' . $count);

  $sheet->setCellValue('D' . ($count + 1), $sumDetail['seasonalReviewCount']);
  $sheet->setCellValue('E' . ($count + 1), $sumDetail['monthReviewCount']);

  $sheet->setCellValue('F' . $count, $sumDetail['individualCounselingCount'] + $sumDetail['groupCounselingCount']);
  $sheet->mergeCells('F' . $count . ':G' . $count);

  $sheet->setCellValue('F' . ($count + 1), $sumDetail['individualCounselingCount']);
  $sheet->setCellValue('G' . ($count + 1), $sumDetail['groupCounselingCount']);

  $sheet->setCellValue('H' . $count, $sumDetail['courseAttendanceCount']);
  $sheet->mergeCells('H' . $count . ':H' . ($count + 1));
  $sheet->setCellValue('I' . $count, $sumDetail['workAttendanceCount']);
  $sheet->mergeCells('I' . $count . ':I' . ($count + 1));

  $sheet->setCellValue('J' . $count, $sumDetail['endCaseCount']);
  $sheet->mergeCells('J' . $count . ':J' . ($count + 1));

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray)-1] . ( $count + 1 ))->applyFromArray($styleArray);

  return $sheet;
}

function yda_report_counselEffectionIndividual($sheet, $countyType, $year) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');

  $data = [];
  $data['phoneService'] = $CI->MenuModel->get_no_resource_by_content('電訪', 'individual_counseling')->no;
  $data['personallyService'] = $CI->MenuModel->get_no_resource_by_content('親訪', 'individual_counseling')->no;
  $data['internetService'] = $CI->MenuModel->get_no_resource_by_content('網路', 'individual_counseling')->no;
  $data['educationService'] = $CI->MenuModel->get_no_resource_by_content('教育資源', 'individual_counseling')->no;
  $data['laborService'] = $CI->MenuModel->get_no_resource_by_content('勞政資源', 'individual_counseling')->no;
  $data['socialService'] = $CI->MenuModel->get_no_resource_by_content('社政資源', 'individual_counseling')->no;
  $data['healthService'] = $CI->MenuModel->get_no_resource_by_content('衛政資源', 'individual_counseling')->no;
  $data['officeService'] = $CI->MenuModel->get_no_resource_by_content('警政資源', 'individual_counseling')->no;
  $data['judicialService'] = $CI->MenuModel->get_no_resource_by_content('司法資源', 'individual_counseling')->no;
  $data['otherService'] = $CI->MenuModel->get_no_resource_by_content('其他資源', 'individual_counseling')->no;
  $data['county'] = $countyType;
  $data['yearType'] = $year;
  $counselEffectionIndividual = $CI->ReportModel->get_individual_counseling_report_by_county($data);

  $sumDetail = [];
  $sumDetail['phoneServiceCount'] = $sumDetail['personallyServiceCount'] = $sumDetail['internetServiceCount'] = $sumDetail['educationServiceCount']
    = $sumDetail['laborServiceCount'] = $sumDetail['socialServiceCount'] = $sumDetail['officeServiceCount'] = $sumDetail['judicialServiceCount']
    = $sumDetail['healthServiceCount'] = $sumDetail['otherServiceCount'] = 0;

  foreach ($counselEffectionIndividual as $i) {
    $sumDetail['phoneServiceCount'] += $i['phoneServiceCount'];
    $sumDetail['personallyServiceCount'] += $i['personallyServiceCount'];
    $sumDetail['internetServiceCount'] += $i['internetServiceCount'];
    $sumDetail['educationServiceCount'] += $i['educationServiceCount'];
    $sumDetail['laborServiceCount'] += $i['laborServiceCount'];
    $sumDetail['socialServiceCount'] += $i['socialServiceCount'];
    $sumDetail['officeServiceCount'] += $i['officeServiceCount'];
    $sumDetail['judicialServiceCount'] += $i['judicialServiceCount'];
    $sumDetail['healthServiceCount'] += $i['healthServiceCount'];
    $sumDetail['otherServiceCount'] += $i['otherServiceCount'];
  }

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle($year . '年個別輔導時數統計表');
  $sheet->setCellValue('A1', '縣市');
  $sheet->mergeCells('A1:A2');
  $sheet->setCellValue('B1', '個案服務');
  $sheet->mergeCells('B1:D1');
  $sheet->setCellValue('B2', '電訪');
  $sheet->setCellValue('C2', '親訪');
  $sheet->setCellValue('D2', '網路');
  $sheet->setCellValue('E1', '系統服務');
  $sheet->mergeCells('E1:K1');
  $sheet->setCellValue('E2', '教育資源');
  $sheet->setCellValue('F2', '勞政資源');
  $sheet->setCellValue('G2', '社政資源');
  $sheet->setCellValue('H2', '警政資源');
  $sheet->setCellValue('I2', '司法資源');
  $sheet->setCellValue('J2', '衛政資源');
  $sheet->setCellValue('K2', '其他資源');
  $sheet->setCellValue('L1', '個別輔導總時數');
  $sheet->getColumnDimension('L')->setWidth(15);
  $sheet->mergeCells('L1:L2');

  $count = 2;
  foreach ($counselEffectionIndividual as $value) {
    $count = $count + 2;
    $sheet->setCellValue('A' . $count, $value['name']);
    $sheet->mergeCells('A' . $count . ':A' . ($count + 1));
    $sheet->setCellValue('B' . $count, $value['phoneServiceCount'] + $value['personallyServiceCount'] + $value['internetServiceCount']);
    $sheet->mergeCells('B' . $count . ':D' . $count);
    $sheet->setCellValue('B' . ($count + 1), $value['phoneServiceCount']);
    $sheet->setCellValue('C' . ($count + 1), $value['personallyServiceCount']);
    $sheet->setCellValue('D' . ($count + 1), $value['internetServiceCount']);
    $sheet->setCellValue('E' . $count, $value['educationServiceCount'] + $value['laborServiceCount'] + $value['socialServiceCount'] + $value['officeServiceCount']
      + $value['judicialServiceCount'] + $value['healthServiceCount'] + $value['otherServiceCount']);
    $sheet->mergeCells('E' . $count . ':K' . $count);
    $sheet->setCellValue('E' . ($count + 1), $value['educationServiceCount']);
    $sheet->setCellValue('F' . ($count + 1), $value['laborServiceCount']);
    $sheet->setCellValue('G' . ($count + 1), $value['socialServiceCount']);
    $sheet->setCellValue('H' . ($count + 1), $value['officeServiceCount']);
    $sheet->setCellValue('I' . ($count + 1), $value['judicialServiceCount']);
    $sheet->setCellValue('J' . ($count + 1), $value['healthServiceCount']);
    $sheet->setCellValue('K' . ($count + 1), $value['otherServiceCount']);

    $sheet->setCellValue('L' . $count, $value['phoneServiceCount'] + $value['personallyServiceCount'] + $value['internetServiceCount'] + $value['educationServiceCount'] 
      + $value['laborServiceCount'] + $value['socialServiceCount'] + $value['officeServiceCount']
      + $value['judicialServiceCount'] + $value['healthServiceCount'] + $value['otherServiceCount']);
    $sheet->mergeCells('L' . $count . ':L' . ($count + 1));
  }

  $count = $count + 2;
  $sheet->setCellValue('A' . $count, '總計');
  $sheet->mergeCells('A' . $count . ':A' . ($count + 1));
  $sheet->setCellValue('B' . $count, $sumDetail['phoneServiceCount'] + $sumDetail['personallyServiceCount'] + $sumDetail['internetServiceCount']);
  $sheet->mergeCells('B' . $count . ':D' . $count);
  $sheet->setCellValue('B' . ($count + 1), $sumDetail['phoneServiceCount']);
  $sheet->setCellValue('C' . ($count + 1), $sumDetail['personallyServiceCount']);
  $sheet->setCellValue('D' . ($count + 1), $sumDetail['internetServiceCount']);
  $sheet->setCellValue('E' . $count, $sumDetail['educationServiceCount'] + $sumDetail['laborServiceCount'] + $sumDetail['socialServiceCount'] + $sumDetail['officeServiceCount']
    + $sumDetail['judicialServiceCount'] + $sumDetail['healthServiceCount'] + $sumDetail['otherServiceCount']);
  $sheet->mergeCells('E' . $count . ':K' . $count);
  $sheet->setCellValue('E' . ($count + 1), $sumDetail['educationServiceCount']);
  $sheet->setCellValue('F' . ($count + 1), $sumDetail['laborServiceCount']);
  $sheet->setCellValue('G' . ($count + 1), $sumDetail['socialServiceCount']);
  $sheet->setCellValue('H' . ($count + 1), $sumDetail['officeServiceCount']);
  $sheet->setCellValue('I' . ($count + 1), $sumDetail['judicialServiceCount']);
  $sheet->setCellValue('J' . ($count + 1), $sumDetail['healthServiceCount']);
  $sheet->setCellValue('K' . ($count + 1), $sumDetail['otherServiceCount']);
  $sheet->setCellValue('L' . $count, $sumDetail['phoneServiceCount'] + $sumDetail['personallyServiceCount'] + $sumDetail['internetServiceCount'] + $sumDetail['educationServiceCount'] 
    + $sumDetail['laborServiceCount'] + $sumDetail['socialServiceCount'] + $sumDetail['officeServiceCount']
    + $sumDetail['judicialServiceCount'] + $sumDetail['healthServiceCount'] + $sumDetail['otherServiceCount']);
  $sheet->mergeCells('L' . $count . ':L' . ($count + 1));

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray)-1] . ( $count + 1 ))->applyFromArray($styleArray);

  return $sheet;
}

function yda_report_counselEffectionGroup($sheet, $countyType, $year) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');

  $data = [];
  $data['exploreService'] = $CI->MenuModel->get_no_resource_by_content('生涯探索', 'group_counseling')->no;
  $data['interactiveService'] = $CI->MenuModel->get_no_resource_by_content('人際溝通與互動', 'group_counseling')->no;
  $data['experienceService'] = $CI->MenuModel->get_no_resource_by_content('體驗教育', 'group_counseling')->no;
  $data['environmentService'] = $CI->MenuModel->get_no_resource_by_content('環境教育', 'group_counseling')->no;
  $data['judicialService'] = $CI->MenuModel->get_no_resource_by_content('法治教育', 'group_counseling')->no;
  $data['genderService'] = $CI->MenuModel->get_no_resource_by_content('性別平等教育', 'group_counseling')->no;
  $data['professionService'] = $CI->MenuModel->get_no_resource_by_content('職業訓練', 'group_counseling')->no;
  $data['volunteerService'] = $CI->MenuModel->get_no_resource_by_content('志願服務', 'group_counseling')->no;
  $data['otherService'] = $CI->MenuModel->get_no_resource_by_content('其他', 'group_counseling')->no;

  $data['county'] = $countyType;
  $data['yearType'] = $year;
  $counselEffectionGroup = $CI->ReportModel->get_group_counseling_report_by_county($data);

  $sumDetail = [];
  $sumDetail['exploreServiceCount'] = $sumDetail['interactiveServiceCount'] = $sumDetail['experienceServiceCount'] = $sumDetail['environmentServiceCount']
    = $sumDetail['judicialServiceCount'] = $sumDetail['genderServiceCount'] = $sumDetail['professionServiceCount'] = $sumDetail['volunteerServiceCount']
    = $sumDetail['otherServiceCount'] = 0;

  foreach ($counselEffectionGroup as $i) {
    $sumDetail['exploreServiceCount'] += $i['exploreServiceCount'];
    $sumDetail['interactiveServiceCount'] += $i['interactiveServiceCount'];
    $sumDetail['experienceServiceCount'] += $i['experienceServiceCount'];
    $sumDetail['environmentServiceCount'] += $i['environmentServiceCount'];
    $sumDetail['judicialServiceCount'] += $i['judicialServiceCount'];
    $sumDetail['genderServiceCount'] += $i['genderServiceCount'];
    $sumDetail['professionServiceCount'] += $i['professionServiceCount'];
    $sumDetail['volunteerServiceCount'] += $i['volunteerServiceCount'];
    $sumDetail['otherServiceCount'] += $i['otherServiceCount'];
  }

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle($year . '年團體輔導時數統計表');
  $sheet->setCellValue('A1', '縣市');
  $sheet->setCellValue('B1', '生涯探索');
  $sheet->setCellValue('C1', '人際溝通與互動');
  $sheet->getColumnDimension('C')->setWidth(18);
  $sheet->setCellValue('D1', '體驗教育');
  $sheet->setCellValue('E1', '環境教育');
  $sheet->setCellValue('F1', '法治教育');
  $sheet->setCellValue('G1', '性別平等教育');
  $sheet->getColumnDimension('G')->setWidth(15);
  $sheet->setCellValue('H1', '職業訓練');
  $sheet->setCellValue('I1', '志願服務');
  $sheet->setCellValue('J1', '其他');
  $sheet->setCellValue('K1', '團體輔導總時數');
  $sheet->getColumnDimension('K')->setWidth(15);

  $count = 1;
  foreach ($counselEffectionGroup as $value) {
    $count++;
    $sheet->setCellValue('A' . $count, $value['name']);
    $sheet->setCellValue('B' . $count, $value['exploreServiceCount']);
    $sheet->setCellValue('C' . $count, $value['interactiveServiceCount']);
    $sheet->setCellValue('D' . $count, $value['experienceServiceCount']);
    $sheet->setCellValue('E' . $count, $value['environmentServiceCount']);
    $sheet->setCellValue('F' . $count, $value['judicialServiceCount']);
    $sheet->setCellValue('G' . $count, $value['genderServiceCount']);
    $sheet->setCellValue('H' . $count, $value['professionServiceCount']);
    $sheet->setCellValue('I' . $count, $value['volunteerServiceCount']);
    $sheet->setCellValue('J' . $count, $value['otherServiceCount']);
    $sheet->setCellValue('K' . $count, $value['exploreServiceCount'] + $value['interactiveServiceCount'] + $value['experienceServiceCount'] + $value['environmentServiceCount']
      + $value['judicialServiceCount'] + $value['genderServiceCount'] + $value['professionServiceCount'] + $value['volunteerServiceCount'] + $value['otherServiceCount']);
  }

  $count++;
  $sheet->setCellValue('A' . $count, '總計');
  $sheet->setCellValue('B' . $count, $sumDetail['exploreServiceCount']);
  $sheet->setCellValue('C' . $count, $sumDetail['interactiveServiceCount']);
  $sheet->setCellValue('D' . $count, $sumDetail['experienceServiceCount']);
  $sheet->setCellValue('E' . $count, $sumDetail['environmentServiceCount']);
  $sheet->setCellValue('F' . $count, $sumDetail['judicialServiceCount']);
  $sheet->setCellValue('G' . $count, $sumDetail['genderServiceCount']);
  $sheet->setCellValue('H' . $count, $sumDetail['professionServiceCount']);
  $sheet->setCellValue('I' . $count, $sumDetail['volunteerServiceCount']);
  $sheet->setCellValue('J' . $count, $sumDetail['otherServiceCount']);
  $sheet->setCellValue('K' . $count, $sumDetail['exploreServiceCount'] + $sumDetail['interactiveServiceCount'] + $sumDetail['experienceServiceCount'] + $sumDetail['environmentServiceCount']
    + $sumDetail['judicialServiceCount'] + $sumDetail['genderServiceCount'] + $sumDetail['professionServiceCount'] + $sumDetail['volunteerServiceCount'] + $sumDetail['otherServiceCount']);

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray)-1] . $count)->applyFromArray($styleArray);

  return $sheet;
}

function yda_report_counselEffectionCourse($sheet, $countyType, $year) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');

  $data = [];
  $data['exploreCourse'] = $CI->MenuModel->get_no_resource_by_content('生涯探索與就業力培訓', 'course_reference')->no;
  $data['experienceCourse'] = $CI->MenuModel->get_no_resource_by_content('體驗教育及志願服務', 'course_reference')->no;
  $data['officeCourse'] = $CI->MenuModel->get_no_resource_by_content('法治(含反毒)及性別平等教育', 'course_reference')->no;
  $data['otherCourse'] = $CI->MenuModel->get_no_resource_by_content('其他及彈性運用', 'course_reference')->no;

  $data['county'] = $countyType;
  $data['yearType'] = $year;
  $counselEffectionCourse = $CI->ReportModel->get_course_report_by_county($data);

  $sumDetail = [];
  $sumDetail['exploreCourseCount'] = $sumDetail['experienceCourseCount'] = $sumDetail['officeCourseCount'] = $sumDetail['otherCourseCount'] = 0;

  foreach ($counselEffectionCourse as $i) {
    $sumDetail['exploreCourseCount'] += $i['exploreCourseCount'];
    $sumDetail['experienceCourseCount'] += $i['experienceCourseCount'];
    $sumDetail['officeCourseCount'] += $i['officeCourseCount'];
    $sumDetail['otherCourseCount'] += $i['otherCourseCount'];
  }

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle($year . '年生涯探索課程或活動時數統計表');
  $sheet->setCellValue('A1', '縣市');
  $sheet->setCellValue('B1', "生涯探索與\n就業力培訓");
  $sheet->getColumnDimension('B')->setWidth(18);
  $sheet->setCellValue('C1', "體驗教育及\n志願服務");
  $sheet->getColumnDimension('C')->setWidth(18);
  $sheet->setCellValue('D1', "法治(含反毒)及\n性別平等教育");
  $sheet->getColumnDimension('D')->setWidth(18);
  $sheet->setCellValue('E1', "其他及彈性運用");
  $sheet->getColumnDimension('E')->setWidth(18);
  $sheet->setCellValue('F1', "生涯探索課程\n或活動總時數");
  $sheet->getColumnDimension('F')->setWidth(18);

  $count = 1;
  foreach ($counselEffectionCourse as $value) {
    $count++;
    $sheet->setCellValue('A' . $count, $value['name']);
    $sheet->setCellValue('B' . $count, $value['exploreCourseCount']);
    $sheet->setCellValue('C' . $count, $value['experienceCourseCount']);
    $sheet->setCellValue('D' . $count, $value['officeCourseCount']);
    $sheet->setCellValue('E' . $count, $value['otherCourseCount']);
    $sheet->setCellValue('F' . $count, $value['exploreCourseCount'] + $value['experienceCourseCount'] + $value['officeCourseCount'] + $value['otherCourseCount']);
  }

  $count++;
  $sheet->setCellValue('A' . $count, '總計');
  $sheet->setCellValue('B' . $count, $sumDetail['exploreCourseCount']);
  $sheet->setCellValue('C' . $count, $sumDetail['experienceCourseCount']);
  $sheet->setCellValue('D' . $count, $sumDetail['officeCourseCount']);
  $sheet->setCellValue('E' . $count, $sumDetail['otherCourseCount']);
  $sheet->setCellValue('F' . $count, $sumDetail['exploreCourseCount'] + $sumDetail['experienceCourseCount'] + $sumDetail['officeCourseCount'] + $sumDetail['otherCourseCount']);

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray)-1] . $count)->applyFromArray($styleArray);

  return $sheet;
}

function yda_report_counselEffectionWork($sheet, $countyType, $year) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');

  $data = [];
  $data['farmWork'] = $CI->MenuModel->get_no_resource_by_content('農、林、漁、牧業', 'company')->no;
  $data['miningWork'] = $CI->MenuModel->get_no_resource_by_content('礦業及土石採取業', 'company')->no;
  $data['manufacturingWork'] = $CI->MenuModel->get_no_resource_by_content('製造業', 'company')->no;
  $data['electricityWork'] = $CI->MenuModel->get_no_resource_by_content('電力及燃氣供應業', 'company')->no;
  $data['waterWork'] = $CI->MenuModel->get_no_resource_by_content('用水供應及污染整治業', 'company')->no;
  $data['buildWork'] = $CI->MenuModel->get_no_resource_by_content('營建工程業', 'company')->no;
  $data['wholesaleWork'] = $CI->MenuModel->get_no_resource_by_content('批發及零售業', 'company')->no;
  $data['transportWork'] = $CI->MenuModel->get_no_resource_by_content('運輸及倉儲業', 'company')->no;
  $data['hotelWork'] = $CI->MenuModel->get_no_resource_by_content('住宿及餐飲業', 'company')->no;
  $data['publishWork'] = $CI->MenuModel->get_no_resource_by_content('出版、影音製作、傳播及資通訊服務業', 'company')->no;
  $data['financialWork'] = $CI->MenuModel->get_no_resource_by_content('金融及保險業', 'company')->no;
  $data['immovablesWork'] = $CI->MenuModel->get_no_resource_by_content('不動產業', 'company')->no;
  $data['scienceWork'] = $CI->MenuModel->get_no_resource_by_content('專業、科學及技術服務業', 'company')->no;
  $data['supportWork'] = $CI->MenuModel->get_no_resource_by_content('支援服務業', 'company')->no;
  $data['militaryWork'] = $CI->MenuModel->get_no_resource_by_content('公共行政及國防；強制性社會安全', 'company')->no;
  $data['educationWork'] = $CI->MenuModel->get_no_resource_by_content('教育業', 'company')->no;
  $data['hospitalWork'] = $CI->MenuModel->get_no_resource_by_content('醫療保健及社會工作服務業', 'company')->no;
  $data['artWork'] = $CI->MenuModel->get_no_resource_by_content('藝術、娛樂及休閒服務業', 'company')->no;
  $data['otherWork'] = $CI->MenuModel->get_no_resource_by_content('其他服務業', 'company')->no;

  $data['county'] = $countyType;
  $data['yearType'] = $year;
  $counselEffectionWork = $CI->ReportModel->get_work_report_by_county($data);

  $sumDetail = [];
  $sumDetail['farmWorkCount'] = $sumDetail['miningWorkCount'] = $sumDetail['manufacturingWorkCount'] = $sumDetail['electricityWorkCount']
  = $sumDetail['waterWorkCount'] = $sumDetail['buildWorkCount'] = $sumDetail['wholesaleWorkCount'] = $sumDetail['transportWorkCount']
  = $sumDetail['hotelWorkCount'] = $sumDetail['publishWorkCount'] = $sumDetail['financialWorkCount'] = $sumDetail['immovablesWorkCount']
  = $sumDetail['scienceWorkCount'] = $sumDetail['supportWorkCount'] = $sumDetail['militaryWorkCount'] = $sumDetail['educationWorkCount']
  = $sumDetail['hospitalWorkCount'] = $sumDetail['artWorkCount'] = $sumDetail['otherWorkCount'] = 0;

  foreach ($counselEffectionWork as $i) {
    $sumDetail['farmWorkCount'] += $i['farmWorkCount'];
    $sumDetail['miningWorkCount'] += $i['miningWorkCount'];
    $sumDetail['manufacturingWorkCount'] += $i['manufacturingWorkCount'];
    $sumDetail['electricityWorkCount'] += $i['electricityWorkCount'];
    $sumDetail['waterWorkCount'] += $i['waterWorkCount'];
    $sumDetail['buildWorkCount'] += $i['buildWorkCount'];
    $sumDetail['wholesaleWorkCount'] += $i['wholesaleWorkCount'];
    $sumDetail['transportWorkCount'] += $i['transportWorkCount'];
    $sumDetail['hotelWorkCount'] += $i['hotelWorkCount'];
    $sumDetail['publishWorkCount'] += $i['publishWorkCount'];
    $sumDetail['financialWorkCount'] += $i['financialWorkCount'];
    $sumDetail['immovablesWorkCount'] += $i['immovablesWorkCount'];
    $sumDetail['scienceWorkCount'] += $i['scienceWorkCount'];
    $sumDetail['supportWorkCount'] += $i['supportWorkCount'];
    $sumDetail['militaryWorkCount'] += $i['militaryWorkCount'];
    $sumDetail['educationWorkCount'] += $i['educationWorkCount'];
    $sumDetail['hospitalWorkCount'] += $i['hospitalWorkCount'];
    $sumDetail['artWorkCount'] += $i['artWorkCount'];
    $sumDetail['otherWorkCount'] += $i['otherWorkCount'];
  }

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle($year . '年生涯探索課程或活動時數統計表');
  $sheet->setCellValue('A1', '縣市');
  $sheet->setCellValue('B1', '農、林、漁、牧業');
  $sheet->getColumnDimension('B')->setWidth(18);
  $sheet->setCellValue('C1', '礦業及土石採取業');
  $sheet->getColumnDimension('C')->setWidth(18);
  $sheet->setCellValue('D1', '製造業');
  $sheet->setCellValue('E1', '電力及燃氣供應業');
  $sheet->getColumnDimension('E')->setWidth(18);
  $sheet->setCellValue('F1', '用水供應及污染整治業');
  $sheet->getColumnDimension('F')->setWidth(18);
  $sheet->setCellValue('G1', '營建工程業');
  $sheet->setCellValue('H1', '批發及零售業');
  $sheet->setCellValue('I1', '運輸及倉儲業');
  $sheet->setCellValue('J1', '住宿及餐飲業');
  $sheet->setCellValue('K1', '出版、影音製作、傳播及資通訊服務業');
  $sheet->getColumnDimension('K')->setWidth(18);
  $sheet->setCellValue('L1', '金融及保險業');
  $sheet->setCellValue('M1', '不動產業');
  $sheet->setCellValue('N1', '專業、科學及技術服務業');
  $sheet->getColumnDimension('N')->setWidth(18);
  $sheet->setCellValue('O1', '支援服務業');
  $sheet->setCellValue('P1', '公共行政及國防；強制性社會安全');
  $sheet->getColumnDimension('P')->setWidth(18);
  $sheet->setCellValue('Q1', '教育業');
  $sheet->setCellValue('R1', '醫療保健及社會工作服務業');
  $sheet->getColumnDimension('R')->setWidth(18);
  $sheet->setCellValue('S1', '藝術、娛樂及休閒服務業');
  $sheet->getColumnDimension('S')->setWidth(18);
  $sheet->setCellValue('T1', '其他服務業');
  $sheet->setCellValue('U1', '工作體驗總時數');

  $count = 1;
  foreach ($counselEffectionWork as $value) {
    $count++;
    $sheet->setCellValue('A' . $count, $value['name']);
    $sheet->setCellValue('B' . $count, $value['farmWorkCount']);
    $sheet->setCellValue('C' . $count, $value['miningWorkCount']);
    $sheet->setCellValue('D' . $count, $value['manufacturingWorkCount']);
    $sheet->setCellValue('E' . $count, $value['electricityWorkCount']);
    $sheet->setCellValue('F' . $count, $value['waterWorkCount']);
    $sheet->setCellValue('G' . $count, $value['buildWorkCount']);
    $sheet->setCellValue('H' . $count, $value['wholesaleWorkCount']);
    $sheet->setCellValue('I' . $count, $value['transportWorkCount']);
    $sheet->setCellValue('J' . $count, $value['hotelWorkCount']);
    $sheet->setCellValue('K' . $count, $value['publishWorkCount']);
    $sheet->setCellValue('L' . $count, $value['financialWorkCount']);
    $sheet->setCellValue('M' . $count, $value['immovablesWorkCount']);
    $sheet->setCellValue('N' . $count, $value['scienceWorkCount']);
    $sheet->setCellValue('O' . $count, $value['supportWorkCount']);
    $sheet->setCellValue('P' . $count, $value['militaryWorkCount']);
    $sheet->setCellValue('Q' . $count, $value['educationWorkCount']);
    $sheet->setCellValue('R' . $count, $value['hospitalWorkCount']);
    $sheet->setCellValue('S' . $count, $value['artWorkCount']);
    $sheet->setCellValue('T' . $count, $value['otherWorkCount']);
    $sheet->setCellValue('U' . $count, $value['farmWorkCount'] + $value['miningWorkCount'] + $value['manufacturingWorkCount'] + $value['electricityWorkCount']
      + $value['waterWorkCount'] + $value['buildWorkCount'] + $value['wholesaleWorkCount'] + $value['transportWorkCount']
      + $value['hotelWorkCount'] + $value['publishWorkCount'] + $value['financialWorkCount'] + $value['immovablesWorkCount']
      + $value['scienceWorkCount'] + $value['supportWorkCount'] + $value['militaryWorkCount'] + $value['educationWorkCount']
      + $value['hospitalWorkCount'] + $value['artWorkCount'] + $value['otherWorkCount']);
  }

  $count++;
  $sheet->setCellValue('A' . $count, '總計');
  $sheet->setCellValue('B' . $count, $sumDetail['farmWorkCount']);
  $sheet->setCellValue('C' . $count, $sumDetail['miningWorkCount']);
  $sheet->setCellValue('D' . $count, $sumDetail['manufacturingWorkCount']);
  $sheet->setCellValue('E' . $count, $sumDetail['electricityWorkCount']);
  $sheet->setCellValue('F' . $count, $sumDetail['waterWorkCount']);
  $sheet->setCellValue('G' . $count, $sumDetail['buildWorkCount']);
  $sheet->setCellValue('H' . $count, $sumDetail['wholesaleWorkCount']);
  $sheet->setCellValue('I' . $count, $sumDetail['transportWorkCount']);
  $sheet->setCellValue('J' . $count, $sumDetail['hotelWorkCount']);
  $sheet->setCellValue('K' . $count, $sumDetail['publishWorkCount']);
  $sheet->setCellValue('L' . $count, $sumDetail['financialWorkCount']);
  $sheet->setCellValue('M' . $count, $sumDetail['immovablesWorkCount']);
  $sheet->setCellValue('N' . $count, $sumDetail['scienceWorkCount']);
  $sheet->setCellValue('O' . $count, $sumDetail['supportWorkCount']);
  $sheet->setCellValue('P' . $count, $sumDetail['militaryWorkCount']);
  $sheet->setCellValue('Q' . $count, $sumDetail['educationWorkCount']);
  $sheet->setCellValue('R' . $count, $sumDetail['hospitalWorkCount']);
  $sheet->setCellValue('S' . $count, $sumDetail['artWorkCount']);
  $sheet->setCellValue('T' . $count, $sumDetail['otherWorkCount']);
  $sheet->setCellValue('U' . $count, $sumDetail['farmWorkCount'] + $sumDetail['miningWorkCount'] + $sumDetail['manufacturingWorkCount'] + $sumDetail['electricityWorkCount']
    + $sumDetail['waterWorkCount'] + $sumDetail['buildWorkCount'] + $sumDetail['wholesaleWorkCount'] + $sumDetail['transportWorkCount']
    + $sumDetail['hotelWorkCount'] + $sumDetail['publishWorkCount'] + $sumDetail['financialWorkCount'] + $sumDetail['immovablesWorkCount']
    + $sumDetail['scienceWorkCount'] + $sumDetail['supportWorkCount'] + $sumDetail['militaryWorkCount'] + $sumDetail['educationWorkCount']
    + $sumDetail['hospitalWorkCount'] + $sumDetail['artWorkCount'] + $sumDetail['otherWorkCount']);


  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray)-1] . $count)->applyFromArray($styleArray);

  return $sheet;
}

function yda_report_counselEffectionMeeting($sheet, $countyType, $year) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');

  $data = [];
  $data['meetingType'] = $CI->MenuModel->get_no_resource_by_content('跨局處會議', 'meeting')->no;
  $data['activityType'] = $CI->MenuModel->get_no_resource_by_content('預防性講座', 'meeting')->no;

  $data['county'] = $countyType;
  $data['yearType'] = $year;
  $counselEffectionMeeting = $CI->ReportModel->get_meeting_report_by_county($data);

  $sumDetail = [];
  $sumDetail['meetingCount'] = $sumDetail['activityCount'] = 0;

  foreach ($counselEffectionMeeting as $i) {
    $sumDetail['meetingCount'] += $i['meetingCount'];
    $sumDetail['activityCount'] += $i['activityCount'];
  }

  $columnNameArray = array('A', 'B', 'C', 'D');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle($year . '年跨局處會議及預防性講座統計表');
  $sheet->setCellValue('A1', '縣市');
  $sheet->setCellValue('B1', '跨局處會議');
  $sheet->getColumnDimension('B')->setWidth(12);
  $sheet->setCellValue('C1', '預防性講座');
  $sheet->getColumnDimension('C')->setWidth(12);
  $sheet->setCellValue('D1', '跨局處會議及預防性講座總次數');
  $sheet->getColumnDimension('D')->setWidth(20);

  $count = 1;
  foreach ($counselEffectionMeeting as $value) {
    $count++;
    $sheet->setCellValue('A' . $count, $value['name']);
    $sheet->setCellValue('B' . $count, $value['meetingCount']);
    $sheet->setCellValue('C' . $count, $value['activityCount']);
    $sheet->setCellValue('D' . $count, $value['meetingCount'] + $value['activityCount']);
  }

  $count++;
  $sheet->setCellValue('A' . $count, '總計');
  $sheet->setCellValue('B' . $count, $sumDetail['meetingCount']);
  $sheet->setCellValue('C' . $count, $sumDetail['activityCount']);
  $sheet->setCellValue('D' . $count, $sumDetail['meetingCount'] + $sumDetail['activityCount']);

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray)-1] . $count)->applyFromArray($styleArray);

  return $sheet;
}

function yda_report_surveyTypeOldCaseTrack($sheet, $countyType, $year) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('CountyModel');
  $CI->load->helper('report');

  $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $year - 1, null);
  $trackData = $CI->ReportModel->get_old_case_seasonal_review_by_county($surveyTypeData);
  $sumDetail = get_seasonal_review_sum($trackData);
  $tableValue = get_seasonal_review_table($trackData);

  if ($countyType == 'all') $counties = $CI->CountyModel->get_all();
  else $counties = $CI->CountyModel->get_one($countyType);

  $note = $CI->ReportModel->get_old_case_seasonal_review_note_by_county($surveyTypeData);
  $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

  $sheet->setTitle($year . '年前一年度開案後動向調查追蹤表');
  $sheet = report_track_header($sheet, $tableValue, $sumDetail, $noteDetailArray);

  return $sheet;
}

function yda_report_surveyTypeTwoYears($sheet, $countyType, $year) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');

  $surveyTypeData = [];
  $surveyTypeData['surveyTypeNumberOne'] = $CI->MenuModel->get_no_resource_by_content('01已就業', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTwo'] = $CI->MenuModel->get_no_resource_by_content('02已就學', 'youth')->no;
  $surveyTypeData['surveyTypeNumberThree'] = $CI->MenuModel->get_no_resource_by_content('03特教生', 'youth')->no;
  $surveyTypeData['surveyTypeNumberFour'] = $CI->MenuModel->get_no_resource_by_content('04準備升學', 'youth')->no;
  $surveyTypeData['surveyTypeNumberFive'] = $CI->MenuModel->get_no_resource_by_content('05準備或正在找工作', 'youth')->no;
  $surveyTypeData['surveyTypeNumberSix'] = $CI->MenuModel->get_no_resource_by_content('06參加職訓', 'youth')->no;
  $surveyTypeData['surveyTypeNumberSeven'] = $CI->MenuModel->get_no_resource_by_content('07家務勞動', 'youth')->no;
  $surveyTypeData['surveyTypeNumberEight'] = $CI->MenuModel->get_no_resource_by_content('08健康因素', 'youth')->no;
  $surveyTypeData['surveyTypeNumberNine'] = $CI->MenuModel->get_no_resource_by_content('09尚未規劃', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTen'] = $CI->MenuModel->get_no_resource_by_content('10失聯', 'youth')->no;
  $surveyTypeData['surveyTypeNumberEleven'] = $CI->MenuModel->get_no_resource_by_content('11自學', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTwelve'] = $CI->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產、社福機構安置、轉學待追蹤等)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTwelveOne'] = $CI->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTwelveTwo'] = $CI->MenuModel->get_no_resource_by_content('12其他動向(社福機構安置)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTwelveThree'] = $CI->MenuModel->get_no_resource_by_content('12其他動向(轉學)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberThirteen'] = $CI->MenuModel->get_no_resource_by_content('13不可抗力(去世、司法問題、出國)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberThirteenOne'] = $CI->MenuModel->get_no_resource_by_content('13不可抗力(去世)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberThirteenTwo'] = $CI->MenuModel->get_no_resource_by_content('13不可抗力(司法問題)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberThirteenThree'] = $CI->MenuModel->get_no_resource_by_content('13不可抗力(出國)', 'youth')->no;

  $surveyTypeData['county'] = $countyType;
  $surveyTypeData['yearType'] = $year - 4;
  $surveyTypeTwoYearsCounts = $CI->ReportModel->get_survey_type_by_county($surveyTypeData);
  $sumDetail = [];
  $sumDetail['surveyTypeNumberOne'] = $sumDetail['surveyTypeNumberTwo'] = $sumDetail['surveyTypeNumberThree'] = $sumDetail['surveyTypeNumberFour']
    = $sumDetail['surveyTypeNumberFive'] = $sumDetail['surveyTypeNumberSix'] = $sumDetail['surveyTypeNumberSeven'] = $sumDetail['surveyTypeNumberEight']
    = $sumDetail['surveyTypeNumberNine'] = $sumDetail['surveyTypeNumberTen'] = $sumDetail['surveyTypeNumberEleven'] = $sumDetail['surveyTypeNumberTwelve']
    = $sumDetail['surveyTypeNumberTwelveOne'] = $sumDetail['surveyTypeNumberTwelveTwo'] = $sumDetail['surveyTypeNumberTwelveThree'] = $sumDetail['surveyTypeNumberThirteen']
    = $sumDetail['surveyTypeNumberThirteenOne'] = $sumDetail['surveyTypeNumberThirteenTwo'] = $sumDetail['surveyTypeNumberThirteenThree'] = 0;

  foreach ($surveyTypeTwoYearsCounts as $i) {
    $sumDetail['surveyTypeNumberOne'] += $i['surveyTypeNumberOne'];
    $sumDetail['surveyTypeNumberTwo'] += $i['surveyTypeNumberTwo'];
    $sumDetail['surveyTypeNumberThree'] += $i['surveyTypeNumberThree'];
    $sumDetail['surveyTypeNumberFour'] += $i['surveyTypeNumberFour'];
    $sumDetail['surveyTypeNumberFive'] += $i['surveyTypeNumberFive'];
    $sumDetail['surveyTypeNumberSix'] += $i['surveyTypeNumberSix'];
    $sumDetail['surveyTypeNumberSeven'] += $i['surveyTypeNumberSeven'];
    $sumDetail['surveyTypeNumberEight'] += $i['surveyTypeNumberEight'];
    $sumDetail['surveyTypeNumberNine'] += $i['surveyTypeNumberNine'];
    $sumDetail['surveyTypeNumberTen'] += $i['surveyTypeNumberTen'];
    $sumDetail['surveyTypeNumberEleven'] += $i['surveyTypeNumberEleven'];
    $sumDetail['surveyTypeNumberTwelve'] += $i['surveyTypeNumberTwelve'];
    $sumDetail['surveyTypeNumberTwelveOne'] += $i['surveyTypeNumberTwelveOne'];
    $sumDetail['surveyTypeNumberTwelveTwo'] += $i['surveyTypeNumberTwelveTwo'];
    $sumDetail['surveyTypeNumberTwelveThree'] += $i['surveyTypeNumberTwelveThree'];
    $sumDetail['surveyTypeNumberThirteen'] += $i['surveyTypeNumberThirteen'];
    $sumDetail['surveyTypeNumberThirteenOne'] += $i['surveyTypeNumberThirteenOne'];
    $sumDetail['surveyTypeNumberThirteenTwo'] += $i['surveyTypeNumberThirteenTwo'];
    $sumDetail['surveyTypeNumberThirteenThree'] += $i['surveyTypeNumberThirteenThree'];
  }

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle(($year - 4) . '學年度國中畢業未升學未就業青少年動向調查表');
  $sheet->setCellValue('A1', '縣市');
  $sheet->setCellValue('B1', '01已就業');
  $sheet->setCellValue('C1', '02已就學');
  $sheet->setCellValue('D1', '03特教生');
  $sheet->setCellValue('E1', '04準備升學');
  $sheet->setCellValue('F1', '05準備或正在找工作');
  $sheet->setCellValue('G1', '06參加職訓');
  $sheet->setCellValue('H1', '07家務勞動');
  $sheet->setCellValue('I1', '08健康因素');
  $sheet->setCellValue('J1', '09尚未規劃');
  $sheet->setCellValue('K1', '10失聯');
  $sheet->setCellValue('L1', '11自學');
  $sheet->setCellValue('M1', '12其他動向(懷孕待產、社福機構安置、轉學待追蹤等)');
  $sheet->getColumnDimension('M')->setWidth(20);
  $sheet->setCellValue('N1', '13不可抗力(去世、司法問題、出國)');
  $sheet->getColumnDimension('N')->setWidth(20);
  $sheet->setCellValue('O1', '需政府介入輔導人數(4-12)');
  $sheet->getColumnDimension('O')->setWidth(20);
  $sheet->setCellValue('P1', '未升學未就業人數(4-13)');
  $sheet->getColumnDimension('P')->setWidth(20);

  $count = 1;
  foreach ($surveyTypeTwoYearsCounts as $value) {
    $count++;
    $sheet->setCellValue('A' . $count, $value['name']);
    $sheet->setCellValue('B' . $count, $value['surveyTypeNumberOne']);
    $sheet->setCellValue('C' . $count, $value['surveyTypeNumberTwo']);
    $sheet->setCellValue('D' . $count, $value['surveyTypeNumberThree']);
    $sheet->setCellValue('E' . $count, $value['surveyTypeNumberFour']);
    $sheet->setCellValue('F' . $count, $value['surveyTypeNumberFive']);
    $sheet->setCellValue('G' . $count, $value['surveyTypeNumberSix']);
    $sheet->setCellValue('H' . $count, $value['surveyTypeNumberSeven']);
    $sheet->setCellValue('I' . $count, $value['surveyTypeNumberEight']);
    $sheet->setCellValue('J' . $count, $value['surveyTypeNumberNine']);
    $sheet->setCellValue('K' . $count, $value['surveyTypeNumberTen']);
    $sheet->setCellValue('L' . $count, $value['surveyTypeNumberEleven']);
    $sheet->setCellValue('M' . $count, $value['surveyTypeNumberTwelve'] + $value['surveyTypeNumberTwelveOne'] + $value['surveyTypeNumberTwelveTwo'] + $value['surveyTypeNumberTwelveThree']);
    $sheet->setCellValue('N' . $count, $value['surveyTypeNumberThirteen'] + $value['surveyTypeNumberThirteenOne'] + $value['surveyTypeNumberThirteenTwo'] + $value['surveyTypeNumberThirteenThree']);
    $sheet->setCellValue('O' . $count, $value['surveyTypeNumberFour'] + $value['surveyTypeNumberFive'] + $value['surveyTypeNumberSix'] + $value['surveyTypeNumberSeven']
      + $value['surveyTypeNumberEight'] + $value['surveyTypeNumberNine'] + $value['surveyTypeNumberTen'] + $value['surveyTypeNumberEleven']
      + $value['surveyTypeNumberTwelve'] + $value['surveyTypeNumberTwelveOne'] + $value['surveyTypeNumberTwelveTwo'] + $value['surveyTypeNumberTwelveThree']);
    $sheet->setCellValue('P' . $count, $value['surveyTypeNumberFour'] + $value['surveyTypeNumberFive'] + $value['surveyTypeNumberSix'] + $value['surveyTypeNumberSeven']
      + $value['surveyTypeNumberEight'] + $value['surveyTypeNumberNine'] + $value['surveyTypeNumberTen'] + $value['surveyTypeNumberEleven']
      + $value['surveyTypeNumberTwelve'] + $value['surveyTypeNumberTwelveOne'] + $value['surveyTypeNumberTwelveTwo'] + $value['surveyTypeNumberTwelveThree']
      + $value['surveyTypeNumberThirteen'] + $value['surveyTypeNumberThirteenOne'] + $value['surveyTypeNumberThirteenTwo'] + $value['surveyTypeNumberThirteenThree']);
  }

  $sheet->setCellValue('A' . ($count + 1), '總計');
  $sheet->setCellValue('B' . ($count + 1), $sumDetail['surveyTypeNumberOne']);
  $sheet->setCellValue('C' . ($count + 1), $sumDetail['surveyTypeNumberTwo']);
  $sheet->setCellValue('D' . ($count + 1), $sumDetail['surveyTypeNumberThree']);
  $sheet->setCellValue('E' . ($count + 1), $sumDetail['surveyTypeNumberFour']);
  $sheet->setCellValue('F' . ($count + 1), $sumDetail['surveyTypeNumberFive']);
  $sheet->setCellValue('G' . ($count + 1), $sumDetail['surveyTypeNumberSix']);
  $sheet->setCellValue('H' . ($count + 1), $sumDetail['surveyTypeNumberSeven']);
  $sheet->setCellValue('I' . ($count + 1), $sumDetail['surveyTypeNumberEight']);
  $sheet->setCellValue('J' . ($count + 1), $sumDetail['surveyTypeNumberNine']);
  $sheet->setCellValue('K' . ($count + 1), $sumDetail['surveyTypeNumberTen']);
  $sheet->setCellValue('L' . ($count + 1), $sumDetail['surveyTypeNumberEleven']);
  $sheet->setCellValue('M' . ($count + 1), $sumDetail['surveyTypeNumberTwelve'] + $sumDetail['surveyTypeNumberTwelveOne'] + $sumDetail['surveyTypeNumberTwelveTwo'] + $sumDetail['surveyTypeNumberTwelveThree']);
  $sheet->setCellValue('N' . ($count + 1), $sumDetail['surveyTypeNumberThirteen'] + $sumDetail['surveyTypeNumberThirteenOne'] + $sumDetail['surveyTypeNumberThirteenTwo'] + $sumDetail['surveyTypeNumberThirteenThree']);
  $sheet->setCellValue('O' . ($count + 1), $sumDetail['surveyTypeNumberFour'] + $sumDetail['surveyTypeNumberFive'] + $sumDetail['surveyTypeNumberSix'] + $sumDetail['surveyTypeNumberSeven']
    + $sumDetail['surveyTypeNumberEight'] + $sumDetail['surveyTypeNumberNine'] + $sumDetail['surveyTypeNumberTen'] + $sumDetail['surveyTypeNumberEleven']
    + $sumDetail['surveyTypeNumberTwelve'] + $sumDetail['surveyTypeNumberTwelveOne'] + $sumDetail['surveyTypeNumberTwelveTwo'] + $sumDetail['surveyTypeNumberTwelveThree']);
  $sheet->setCellValue('P' . ($count + 1), $sumDetail['surveyTypeNumberFour'] + $sumDetail['surveyTypeNumberFive'] + $sumDetail['surveyTypeNumberSix'] + $sumDetail['surveyTypeNumberSeven']
    + $sumDetail['surveyTypeNumberEight'] + $sumDetail['surveyTypeNumberNine'] + $sumDetail['surveyTypeNumberTen'] + $sumDetail['surveyTypeNumberEleven']
    + $sumDetail['surveyTypeNumberTwelve'] + $sumDetail['surveyTypeNumberTwelveOne'] + $sumDetail['surveyTypeNumberTwelveTwo'] + $sumDetail['surveyTypeNumberTwelveThree']
    + $sumDetail['surveyTypeNumberThirteen'] + $sumDetail['surveyTypeNumberThirteenOne'] + $sumDetail['surveyTypeNumberThirteenTwo'] + $sumDetail['surveyTypeNumberThirteenThree']);

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray)-1] . ($count + 1))->applyFromArray($styleArray);

  return $sheet;
}

function yda_report_surveyTypeOneYears($sheet, $countyType, $year) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');

  $surveyTypeData = [];
  $surveyTypeData['surveyTypeNumberOne'] = $CI->MenuModel->get_no_resource_by_content('01已就業', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTwo'] = $CI->MenuModel->get_no_resource_by_content('02已就學', 'youth')->no;
  $surveyTypeData['surveyTypeNumberThree'] = $CI->MenuModel->get_no_resource_by_content('03特教生', 'youth')->no;
  $surveyTypeData['surveyTypeNumberFour'] = $CI->MenuModel->get_no_resource_by_content('04準備升學', 'youth')->no;
  $surveyTypeData['surveyTypeNumberFive'] = $CI->MenuModel->get_no_resource_by_content('05準備或正在找工作', 'youth')->no;
  $surveyTypeData['surveyTypeNumberSix'] = $CI->MenuModel->get_no_resource_by_content('06參加職訓', 'youth')->no;
  $surveyTypeData['surveyTypeNumberSeven'] = $CI->MenuModel->get_no_resource_by_content('07家務勞動', 'youth')->no;
  $surveyTypeData['surveyTypeNumberEight'] = $CI->MenuModel->get_no_resource_by_content('08健康因素', 'youth')->no;
  $surveyTypeData['surveyTypeNumberNine'] = $CI->MenuModel->get_no_resource_by_content('09尚未規劃', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTen'] = $CI->MenuModel->get_no_resource_by_content('10失聯', 'youth')->no;
  $surveyTypeData['surveyTypeNumberEleven'] = $CI->MenuModel->get_no_resource_by_content('11自學', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTwelve'] = $CI->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產、社福機構安置、轉學待追蹤等)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTwelveOne'] = $CI->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTwelveTwo'] = $CI->MenuModel->get_no_resource_by_content('12其他動向(社福機構安置)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTwelveThree'] = $CI->MenuModel->get_no_resource_by_content('12其他動向(轉學)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberThirteen'] = $CI->MenuModel->get_no_resource_by_content('13不可抗力(去世、司法問題、出國)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberThirteenOne'] = $CI->MenuModel->get_no_resource_by_content('13不可抗力(去世)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberThirteenTwo'] = $CI->MenuModel->get_no_resource_by_content('13不可抗力(司法問題)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberThirteenThree'] = $CI->MenuModel->get_no_resource_by_content('13不可抗力(出國)', 'youth')->no;

  $surveyTypeData['county'] = $countyType;
  $surveyTypeData['yearType'] = $year - 3;
  $surveyTypeOneYearsCounts = $CI->ReportModel->get_survey_type_by_county($surveyTypeData);
  $sumDetail = [];
  $sumDetail['surveyTypeNumberOne'] = $sumDetail['surveyTypeNumberTwo'] = $sumDetail['surveyTypeNumberThree'] = $sumDetail['surveyTypeNumberFour']
    = $sumDetail['surveyTypeNumberFive'] = $sumDetail['surveyTypeNumberSix'] = $sumDetail['surveyTypeNumberSeven'] = $sumDetail['surveyTypeNumberEight']
    = $sumDetail['surveyTypeNumberNine'] = $sumDetail['surveyTypeNumberTen'] = $sumDetail['surveyTypeNumberEleven'] = $sumDetail['surveyTypeNumberTwelve']
    = $sumDetail['surveyTypeNumberTwelveOne'] = $sumDetail['surveyTypeNumberTwelveTwo'] = $sumDetail['surveyTypeNumberTwelveThree'] = $sumDetail['surveyTypeNumberThirteen']
    = $sumDetail['surveyTypeNumberThirteenOne'] = $sumDetail['surveyTypeNumberThirteenTwo'] = $sumDetail['surveyTypeNumberThirteenThree'] = 0;

  foreach ($surveyTypeOneYearsCounts as $i) {
    $sumDetail['surveyTypeNumberOne'] += $i['surveyTypeNumberOne'];
    $sumDetail['surveyTypeNumberTwo'] += $i['surveyTypeNumberTwo'];
    $sumDetail['surveyTypeNumberThree'] += $i['surveyTypeNumberThree'];
    $sumDetail['surveyTypeNumberFour'] += $i['surveyTypeNumberFour'];
    $sumDetail['surveyTypeNumberFive'] += $i['surveyTypeNumberFive'];
    $sumDetail['surveyTypeNumberSix'] += $i['surveyTypeNumberSix'];
    $sumDetail['surveyTypeNumberSeven'] += $i['surveyTypeNumberSeven'];
    $sumDetail['surveyTypeNumberEight'] += $i['surveyTypeNumberEight'];
    $sumDetail['surveyTypeNumberNine'] += $i['surveyTypeNumberNine'];
    $sumDetail['surveyTypeNumberTen'] += $i['surveyTypeNumberTen'];
    $sumDetail['surveyTypeNumberEleven'] += $i['surveyTypeNumberEleven'];
    $sumDetail['surveyTypeNumberTwelve'] += $i['surveyTypeNumberTwelve'];
    $sumDetail['surveyTypeNumberTwelveOne'] += $i['surveyTypeNumberTwelveOne'];
    $sumDetail['surveyTypeNumberTwelveTwo'] += $i['surveyTypeNumberTwelveTwo'];
    $sumDetail['surveyTypeNumberTwelveThree'] += $i['surveyTypeNumberTwelveThree'];
    $sumDetail['surveyTypeNumberThirteen'] += $i['surveyTypeNumberThirteen'];
    $sumDetail['surveyTypeNumberThirteenOne'] += $i['surveyTypeNumberThirteenOne'];
    $sumDetail['surveyTypeNumberThirteenTwo'] += $i['surveyTypeNumberThirteenTwo'];
    $sumDetail['surveyTypeNumberThirteenThree'] += $i['surveyTypeNumberThirteenThree'];
  }

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle(($year - 3) . '學年度國中畢業未升學未就業青少年動向調查表');
  $sheet->setCellValue('A1', '縣市');
  $sheet->setCellValue('B1', '01已就業');
  $sheet->setCellValue('C1', '02已就學');
  $sheet->setCellValue('D1', '03特教生');
  $sheet->setCellValue('E1', '04準備升學');
  $sheet->setCellValue('F1', '05準備或正在找工作');
  $sheet->setCellValue('G1', '06參加職訓');
  $sheet->setCellValue('H1', '07家務勞動');
  $sheet->setCellValue('I1', '08健康因素');
  $sheet->setCellValue('J1', '09尚未規劃');
  $sheet->setCellValue('K1', '10失聯');
  $sheet->setCellValue('L1', '11自學');
  $sheet->setCellValue('M1', '12其他動向(懷孕待產、社福機構安置、轉學待追蹤等)');
  $sheet->getColumnDimension('M')->setWidth(20);
  $sheet->setCellValue('N1', '13不可抗力(去世、司法問題、出國)');
  $sheet->getColumnDimension('N')->setWidth(20);
  $sheet->setCellValue('O1', '需政府介入輔導人數(4-12)');
  $sheet->getColumnDimension('O')->setWidth(20);
  $sheet->setCellValue('P1', '未升學未就業人數(4-13)');
  $sheet->getColumnDimension('P')->setWidth(20);

  $count = 1;
  foreach ($surveyTypeOneYearsCounts as $value) {
    $count++;
    $sheet->setCellValue('A' . $count, $value['name']);
    $sheet->setCellValue('B' . $count, $value['surveyTypeNumberOne']);
    $sheet->setCellValue('C' . $count, $value['surveyTypeNumberTwo']);
    $sheet->setCellValue('D' . $count, $value['surveyTypeNumberThree']);
    $sheet->setCellValue('E' . $count, $value['surveyTypeNumberFour']);
    $sheet->setCellValue('F' . $count, $value['surveyTypeNumberFive']);
    $sheet->setCellValue('G' . $count, $value['surveyTypeNumberSix']);
    $sheet->setCellValue('H' . $count, $value['surveyTypeNumberSeven']);
    $sheet->setCellValue('I' . $count, $value['surveyTypeNumberEight']);
    $sheet->setCellValue('J' . $count, $value['surveyTypeNumberNine']);
    $sheet->setCellValue('K' . $count, $value['surveyTypeNumberTen']);
    $sheet->setCellValue('L' . $count, $value['surveyTypeNumberEleven']);
    $sheet->setCellValue('M' . $count, $value['surveyTypeNumberTwelve'] + $value['surveyTypeNumberTwelveOne'] + $value['surveyTypeNumberTwelveTwo'] + $value['surveyTypeNumberTwelveThree']);
    $sheet->setCellValue('N' . $count, $value['surveyTypeNumberThirteen'] + $value['surveyTypeNumberThirteenOne'] + $value['surveyTypeNumberThirteenTwo'] + $value['surveyTypeNumberThirteenThree']);
    $sheet->setCellValue('O' . $count, $value['surveyTypeNumberFour'] + $value['surveyTypeNumberFive'] + $value['surveyTypeNumberSix'] + $value['surveyTypeNumberSeven']
      + $value['surveyTypeNumberEight'] + $value['surveyTypeNumberNine'] + $value['surveyTypeNumberTen'] + $value['surveyTypeNumberEleven']
      + $value['surveyTypeNumberTwelve'] + $value['surveyTypeNumberTwelveOne'] + $value['surveyTypeNumberTwelveTwo'] + $value['surveyTypeNumberTwelveThree']);
    $sheet->setCellValue('P' . $count, $value['surveyTypeNumberFour'] + $value['surveyTypeNumberFive'] + $value['surveyTypeNumberSix'] + $value['surveyTypeNumberSeven']
      + $value['surveyTypeNumberEight'] + $value['surveyTypeNumberNine'] + $value['surveyTypeNumberTen'] + $value['surveyTypeNumberEleven']
      + $value['surveyTypeNumberTwelve'] + $value['surveyTypeNumberTwelveOne'] + $value['surveyTypeNumberTwelveTwo'] + $value['surveyTypeNumberTwelveThree']
      + $value['surveyTypeNumberThirteen'] + $value['surveyTypeNumberThirteenOne'] + $value['surveyTypeNumberThirteenTwo'] + $value['surveyTypeNumberThirteenThree']);
  }

  $sheet->setCellValue('A' . ($count + 1), '總計');
  $sheet->setCellValue('B' . ($count + 1), $sumDetail['surveyTypeNumberOne']);
  $sheet->setCellValue('C' . ($count + 1), $sumDetail['surveyTypeNumberTwo']);
  $sheet->setCellValue('D' . ($count + 1), $sumDetail['surveyTypeNumberThree']);
  $sheet->setCellValue('E' . ($count + 1), $sumDetail['surveyTypeNumberFour']);
  $sheet->setCellValue('F' . ($count + 1), $sumDetail['surveyTypeNumberFive']);
  $sheet->setCellValue('G' . ($count + 1), $sumDetail['surveyTypeNumberSix']);
  $sheet->setCellValue('H' . ($count + 1), $sumDetail['surveyTypeNumberSeven']);
  $sheet->setCellValue('I' . ($count + 1), $sumDetail['surveyTypeNumberEight']);
  $sheet->setCellValue('J' . ($count + 1), $sumDetail['surveyTypeNumberNine']);
  $sheet->setCellValue('K' . ($count + 1), $sumDetail['surveyTypeNumberTen']);
  $sheet->setCellValue('L' . ($count + 1), $sumDetail['surveyTypeNumberEleven']);
  $sheet->setCellValue('M' . ($count + 1), $sumDetail['surveyTypeNumberTwelve'] + $sumDetail['surveyTypeNumberTwelveOne'] + $sumDetail['surveyTypeNumberTwelveTwo'] + $sumDetail['surveyTypeNumberTwelveThree']);
  $sheet->setCellValue('N' . ($count + 1), $sumDetail['surveyTypeNumberThirteen'] + $sumDetail['surveyTypeNumberThirteenOne'] + $sumDetail['surveyTypeNumberThirteenTwo'] + $sumDetail['surveyTypeNumberThirteenThree']);
  $sheet->setCellValue('O' . ($count + 1), $sumDetail['surveyTypeNumberFour'] + $sumDetail['surveyTypeNumberFive'] + $sumDetail['surveyTypeNumberSix'] + $sumDetail['surveyTypeNumberSeven']
    + $sumDetail['surveyTypeNumberEight'] + $sumDetail['surveyTypeNumberNine'] + $sumDetail['surveyTypeNumberTen'] + $sumDetail['surveyTypeNumberEleven']
    + $sumDetail['surveyTypeNumberTwelve'] + $sumDetail['surveyTypeNumberTwelveOne'] + $sumDetail['surveyTypeNumberTwelveTwo'] + $sumDetail['surveyTypeNumberTwelveThree']);
  $sheet->setCellValue('P' . ($count + 1), $sumDetail['surveyTypeNumberFour'] + $sumDetail['surveyTypeNumberFive'] + $sumDetail['surveyTypeNumberSix'] + $sumDetail['surveyTypeNumberSeven']
    + $sumDetail['surveyTypeNumberEight'] + $sumDetail['surveyTypeNumberNine'] + $sumDetail['surveyTypeNumberTen'] + $sumDetail['surveyTypeNumberEleven']
    + $sumDetail['surveyTypeNumberTwelve'] + $sumDetail['surveyTypeNumberTwelveOne'] + $sumDetail['surveyTypeNumberTwelveTwo'] + $sumDetail['surveyTypeNumberTwelveThree']
    + $sumDetail['surveyTypeNumberThirteen'] + $sumDetail['surveyTypeNumberThirteenOne'] + $sumDetail['surveyTypeNumberThirteenTwo'] + $sumDetail['surveyTypeNumberThirteenThree']);

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray)-1] . ($count + 1))->applyFromArray($styleArray);

  return $sheet;
}

function yda_report_surveyTypeNowYears($sheet, $countyType, $year) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');

  $surveyTypeData = [];
  $surveyTypeData['surveyTypeNumberOne'] = $CI->MenuModel->get_no_resource_by_content('01已就業', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTwo'] = $CI->MenuModel->get_no_resource_by_content('02已就學', 'youth')->no;
  $surveyTypeData['surveyTypeNumberThree'] = $CI->MenuModel->get_no_resource_by_content('03特教生', 'youth')->no;
  $surveyTypeData['surveyTypeNumberFour'] = $CI->MenuModel->get_no_resource_by_content('04準備升學', 'youth')->no;
  $surveyTypeData['surveyTypeNumberFive'] = $CI->MenuModel->get_no_resource_by_content('05準備或正在找工作', 'youth')->no;
  $surveyTypeData['surveyTypeNumberSix'] = $CI->MenuModel->get_no_resource_by_content('06參加職訓', 'youth')->no;
  $surveyTypeData['surveyTypeNumberSeven'] = $CI->MenuModel->get_no_resource_by_content('07家務勞動', 'youth')->no;
  $surveyTypeData['surveyTypeNumberEight'] = $CI->MenuModel->get_no_resource_by_content('08健康因素', 'youth')->no;
  $surveyTypeData['surveyTypeNumberNine'] = $CI->MenuModel->get_no_resource_by_content('09尚未規劃', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTen'] = $CI->MenuModel->get_no_resource_by_content('10失聯', 'youth')->no;
  $surveyTypeData['surveyTypeNumberEleven'] = $CI->MenuModel->get_no_resource_by_content('11自學', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTwelve'] = $CI->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產、社福機構安置、轉學待追蹤等)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTwelveOne'] = $CI->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTwelveTwo'] = $CI->MenuModel->get_no_resource_by_content('12其他動向(社福機構安置)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTwelveThree'] = $CI->MenuModel->get_no_resource_by_content('12其他動向(轉學)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberThirteen'] = $CI->MenuModel->get_no_resource_by_content('13不可抗力(去世、司法問題、出國)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberThirteenOne'] = $CI->MenuModel->get_no_resource_by_content('13不可抗力(去世)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberThirteenTwo'] = $CI->MenuModel->get_no_resource_by_content('13不可抗力(司法問題)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberThirteenThree'] = $CI->MenuModel->get_no_resource_by_content('13不可抗力(出國)', 'youth')->no;

  $surveyTypeData['county'] = $countyType;
  $surveyTypeData['yearType'] = $year - 2;
  $surveyTypeNowYearsCounts = $CI->ReportModel->get_survey_type_by_county($surveyTypeData);
  $sumDetail = [];
  $sumDetail['surveyTypeNumberOne'] = $sumDetail['surveyTypeNumberTwo'] = $sumDetail['surveyTypeNumberThree'] = $sumDetail['surveyTypeNumberFour']
    = $sumDetail['surveyTypeNumberFive'] = $sumDetail['surveyTypeNumberSix'] = $sumDetail['surveyTypeNumberSeven'] = $sumDetail['surveyTypeNumberEight']
    = $sumDetail['surveyTypeNumberNine'] = $sumDetail['surveyTypeNumberTen'] = $sumDetail['surveyTypeNumberEleven'] = $sumDetail['surveyTypeNumberTwelve']
    = $sumDetail['surveyTypeNumberTwelveOne'] = $sumDetail['surveyTypeNumberTwelveTwo'] = $sumDetail['surveyTypeNumberTwelveThree'] = $sumDetail['surveyTypeNumberThirteen']
    = $sumDetail['surveyTypeNumberThirteenOne'] = $sumDetail['surveyTypeNumberThirteenTwo'] = $sumDetail['surveyTypeNumberThirteenThree'] = 0;

  foreach ($surveyTypeNowYearsCounts as $i) {
    $sumDetail['surveyTypeNumberOne'] += $i['surveyTypeNumberOne'];
    $sumDetail['surveyTypeNumberTwo'] += $i['surveyTypeNumberTwo'];
    $sumDetail['surveyTypeNumberThree'] += $i['surveyTypeNumberThree'];
    $sumDetail['surveyTypeNumberFour'] += $i['surveyTypeNumberFour'];
    $sumDetail['surveyTypeNumberFive'] += $i['surveyTypeNumberFive'];
    $sumDetail['surveyTypeNumberSix'] += $i['surveyTypeNumberSix'];
    $sumDetail['surveyTypeNumberSeven'] += $i['surveyTypeNumberSeven'];
    $sumDetail['surveyTypeNumberEight'] += $i['surveyTypeNumberEight'];
    $sumDetail['surveyTypeNumberNine'] += $i['surveyTypeNumberNine'];
    $sumDetail['surveyTypeNumberTen'] += $i['surveyTypeNumberTen'];
    $sumDetail['surveyTypeNumberEleven'] += $i['surveyTypeNumberEleven'];
    $sumDetail['surveyTypeNumberTwelve'] += $i['surveyTypeNumberTwelve'];
    $sumDetail['surveyTypeNumberTwelveOne'] += $i['surveyTypeNumberTwelveOne'];
    $sumDetail['surveyTypeNumberTwelveTwo'] += $i['surveyTypeNumberTwelveTwo'];
    $sumDetail['surveyTypeNumberTwelveThree'] += $i['surveyTypeNumberTwelveThree'];
    $sumDetail['surveyTypeNumberThirteen'] += $i['surveyTypeNumberThirteen'];
    $sumDetail['surveyTypeNumberThirteenOne'] += $i['surveyTypeNumberThirteenOne'];
    $sumDetail['surveyTypeNumberThirteenTwo'] += $i['surveyTypeNumberThirteenTwo'];
    $sumDetail['surveyTypeNumberThirteenThree'] += $i['surveyTypeNumberThirteenThree'];
  }

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle(($year - 2) . '學年度國中畢業未升學未就業青少年動向調查表');
  $sheet->setCellValue('A1', '縣市');
  $sheet->setCellValue('B1', '01已就業');
  $sheet->setCellValue('C1', '02已就學');
  $sheet->setCellValue('D1', '03特教生');
  $sheet->setCellValue('E1', '04準備升學');
  $sheet->setCellValue('F1', '05準備或正在找工作');
  $sheet->setCellValue('G1', '06參加職訓');
  $sheet->setCellValue('H1', '07家務勞動');
  $sheet->setCellValue('I1', '08健康因素');
  $sheet->setCellValue('J1', '09尚未規劃');
  $sheet->setCellValue('K1', '10失聯');
  $sheet->setCellValue('L1', '11自學');
  $sheet->setCellValue('M1', '12其他動向(懷孕待產、社福機構安置、轉學待追蹤等)');
  $sheet->getColumnDimension('M')->setWidth(20);
  $sheet->setCellValue('N1', '13不可抗力(去世、司法問題、出國)');
  $sheet->getColumnDimension('N')->setWidth(20);
  $sheet->setCellValue('O1', '需政府介入輔導人數(4-12)');
  $sheet->getColumnDimension('O')->setWidth(20);
  $sheet->setCellValue('P1', '未升學未就業人數(4-13)');
  $sheet->getColumnDimension('P')->setWidth(20);

  $count = 1;
  foreach ($surveyTypeNowYearsCounts as $value) {
    $count++;
    $sheet->setCellValue('A' . $count, $value['name']);
    $sheet->setCellValue('B' . $count, $value['surveyTypeNumberOne']);
    $sheet->setCellValue('C' . $count, $value['surveyTypeNumberTwo']);
    $sheet->setCellValue('D' . $count, $value['surveyTypeNumberThree']);
    $sheet->setCellValue('E' . $count, $value['surveyTypeNumberFour']);
    $sheet->setCellValue('F' . $count, $value['surveyTypeNumberFive']);
    $sheet->setCellValue('G' . $count, $value['surveyTypeNumberSix']);
    $sheet->setCellValue('H' . $count, $value['surveyTypeNumberSeven']);
    $sheet->setCellValue('I' . $count, $value['surveyTypeNumberEight']);
    $sheet->setCellValue('J' . $count, $value['surveyTypeNumberNine']);
    $sheet->setCellValue('K' . $count, $value['surveyTypeNumberTen']);
    $sheet->setCellValue('L' . $count, $value['surveyTypeNumberEleven']);
    $sheet->setCellValue('M' . $count, $value['surveyTypeNumberTwelve'] + $value['surveyTypeNumberTwelveOne'] + $value['surveyTypeNumberTwelveTwo'] + $value['surveyTypeNumberTwelveThree']);
    $sheet->setCellValue('N' . $count, $value['surveyTypeNumberThirteen'] + $value['surveyTypeNumberThirteenOne'] + $value['surveyTypeNumberThirteenTwo'] + $value['surveyTypeNumberThirteenThree']);
    $sheet->setCellValue('O' . $count, $value['surveyTypeNumberFour'] + $value['surveyTypeNumberFive'] + $value['surveyTypeNumberSix'] + $value['surveyTypeNumberSeven']
      + $value['surveyTypeNumberEight'] + $value['surveyTypeNumberNine'] + $value['surveyTypeNumberTen'] + $value['surveyTypeNumberEleven']
      + $value['surveyTypeNumberTwelve'] + $value['surveyTypeNumberTwelveOne'] + $value['surveyTypeNumberTwelveTwo'] + $value['surveyTypeNumberTwelveThree']);
    $sheet->setCellValue('P' . $count, $value['surveyTypeNumberFour'] + $value['surveyTypeNumberFive'] + $value['surveyTypeNumberSix'] + $value['surveyTypeNumberSeven']
      + $value['surveyTypeNumberEight'] + $value['surveyTypeNumberNine'] + $value['surveyTypeNumberTen'] + $value['surveyTypeNumberEleven']
      + $value['surveyTypeNumberTwelve'] + $value['surveyTypeNumberTwelveOne'] + $value['surveyTypeNumberTwelveTwo'] + $value['surveyTypeNumberTwelveThree']
      + $value['surveyTypeNumberThirteen'] + $value['surveyTypeNumberThirteenOne'] + $value['surveyTypeNumberThirteenTwo'] + $value['surveyTypeNumberThirteenThree']);
  }

  $sheet->setCellValue('A' . ($count + 1), '總計');
  $sheet->setCellValue('B' . ($count + 1), $sumDetail['surveyTypeNumberOne']);
  $sheet->setCellValue('C' . ($count + 1), $sumDetail['surveyTypeNumberTwo']);
  $sheet->setCellValue('D' . ($count + 1), $sumDetail['surveyTypeNumberThree']);
  $sheet->setCellValue('E' . ($count + 1), $sumDetail['surveyTypeNumberFour']);
  $sheet->setCellValue('F' . ($count + 1), $sumDetail['surveyTypeNumberFive']);
  $sheet->setCellValue('G' . ($count + 1), $sumDetail['surveyTypeNumberSix']);
  $sheet->setCellValue('H' . ($count + 1), $sumDetail['surveyTypeNumberSeven']);
  $sheet->setCellValue('I' . ($count + 1), $sumDetail['surveyTypeNumberEight']);
  $sheet->setCellValue('J' . ($count + 1), $sumDetail['surveyTypeNumberNine']);
  $sheet->setCellValue('K' . ($count + 1), $sumDetail['surveyTypeNumberTen']);
  $sheet->setCellValue('L' . ($count + 1), $sumDetail['surveyTypeNumberEleven']);
  $sheet->setCellValue('M' . ($count + 1), $sumDetail['surveyTypeNumberTwelve'] + $sumDetail['surveyTypeNumberTwelveOne'] + $sumDetail['surveyTypeNumberTwelveTwo'] + $sumDetail['surveyTypeNumberTwelveThree']);
  $sheet->setCellValue('N' . ($count + 1), $sumDetail['surveyTypeNumberThirteen'] + $sumDetail['surveyTypeNumberThirteenOne'] + $sumDetail['surveyTypeNumberThirteenTwo'] + $sumDetail['surveyTypeNumberThirteenThree']);
  $sheet->setCellValue('O' . ($count + 1), $sumDetail['surveyTypeNumberFour'] + $sumDetail['surveyTypeNumberFive'] + $sumDetail['surveyTypeNumberSix'] + $sumDetail['surveyTypeNumberSeven']
    + $sumDetail['surveyTypeNumberEight'] + $sumDetail['surveyTypeNumberNine'] + $sumDetail['surveyTypeNumberTen'] + $sumDetail['surveyTypeNumberEleven']
    + $sumDetail['surveyTypeNumberTwelve'] + $sumDetail['surveyTypeNumberTwelveOne'] + $sumDetail['surveyTypeNumberTwelveTwo'] + $sumDetail['surveyTypeNumberTwelveThree']);
  $sheet->setCellValue('P' . ($count + 1), $sumDetail['surveyTypeNumberFour'] + $sumDetail['surveyTypeNumberFive'] + $sumDetail['surveyTypeNumberSix'] + $sumDetail['surveyTypeNumberSeven']
    + $sumDetail['surveyTypeNumberEight'] + $sumDetail['surveyTypeNumberNine'] + $sumDetail['surveyTypeNumberTen'] + $sumDetail['surveyTypeNumberEleven']
    + $sumDetail['surveyTypeNumberTwelve'] + $sumDetail['surveyTypeNumberTwelveOne'] + $sumDetail['surveyTypeNumberTwelveTwo'] + $sumDetail['surveyTypeNumberTwelveThree']
    + $sumDetail['surveyTypeNumberThirteen'] + $sumDetail['surveyTypeNumberThirteenOne'] + $sumDetail['surveyTypeNumberThirteenTwo'] + $sumDetail['surveyTypeNumberThirteenThree']);

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray)-1] . ($count + 1))->applyFromArray($styleArray);

  return $sheet;
}

function yda_report_surveyTypeHighSchoolTrack($sheet, $countyType, $year) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('CountyModel');

  $CI->load->helper('report');

  $source = $CI->MenuModel->get_no_resource_by_content('高中已錄取未註冊', 'youth')->no;
  $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $year - 4, $source);
  $trackData = $CI->ReportModel->get_high_school_seasonal_review_by_county($surveyTypeData);
  
  $sumDetail = get_seasonal_review_sum($trackData);
  $tableValue = get_seasonal_review_table($trackData);

  if ($countyType == 'all') $counties = $CI->CountyModel->get_all();
  else $counties = $CI->CountyModel->get_one($countyType);
  
  $note = $CI->ReportModel->get_high_school_seasonal_review_note_by_county($surveyTypeData);
  $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

  $sheet->setTitle(($year-1) . '年度高中已錄取未註冊青少年動向調查追蹤表');
  $sheet = report_track_header($sheet, $tableValue, $sumDetail, $noteDetailArray);

  return $sheet;
}

function yda_report_surveyTypeTwoYearsTrack($sheet, $countyType, $year) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('CountyModel');
  $CI->load->helper('report');

  $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $year - 4, null);
  $trackData = $CI->ReportModel->get_seasonal_review_by_county($surveyTypeData);
  $sumDetail = get_seasonal_review_sum($trackData);
  $tableValue = get_seasonal_review_table($trackData);

  if ($countyType == 'all') $counties = $CI->CountyModel->get_all();
  else $counties = $CI->CountyModel->get_one($countyType);

  $note = $CI->ReportModel->get_seasonal_review_note_by_county($surveyTypeData);
  $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

  $sheet->setTitle(($year - 4) . '學年度國中畢業未升學未就業青少年動向調查追蹤表');
  $sheet = report_track_header($sheet, $tableValue, $sumDetail, $noteDetailArray);

  return $sheet;
}

function yda_report_surveyTypeOneYearsTrack($sheet, $countyType, $year) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('CountyModel');
  $CI->load->helper('report');

  $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $year - 3, null);
  $trackData = $CI->ReportModel->get_seasonal_review_by_county($surveyTypeData);
  $sumDetail = get_seasonal_review_sum($trackData);
  $tableValue = get_seasonal_review_table($trackData);

  if ($countyType == 'all') $counties = $CI->CountyModel->get_all();
  else $counties = $CI->CountyModel->get_one($countyType);
  
  $note = $CI->ReportModel->get_seasonal_review_note_by_county($surveyTypeData);
  $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

  $sheet->setTitle(($year - 3) . '學年度國中畢業未升學未就業青少年動向調查追蹤表');
  $sheet = report_track_header($sheet, $tableValue, $sumDetail, $noteDetailArray);

  return $sheet;
}

function yda_report_surveyTypeNowYearsTrack($sheet, $countyType, $year) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('CountyModel');
  $CI->load->helper('report');

  $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $year - 2, null);
  $trackData = $CI->ReportModel->get_seasonal_review_by_county($surveyTypeData);
  $sumDetail = get_seasonal_review_sum($trackData);
  $tableValue = get_seasonal_review_table($trackData);

  if ($countyType == 'all') $counties = $CI->CountyModel->get_all();
  else $counties = $CI->CountyModel->get_one($countyType);
  
  $note = $CI->ReportModel->get_seasonal_review_note_by_county($surveyTypeData);
  $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

  $sheet->setTitle(($year - 2) . '學年度國中畢業未升學未就業青少年動向調查追蹤表');
  $sheet = report_track_header($sheet, $tableValue, $sumDetail, $noteDetailArray);

  return $sheet;
}

function counselor_report_countyDelegateOrganization($sheet, $countyType, $year) {

  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');

  $countyDelegateOrganizations = $CI->ReportModel->get_county_delegate_organization($countyType, $year);
  $executeModes = $CI->MenuModel->get_by_form_and_column('project', 'execute_mode');
  $executeWays = $CI->MenuModel->get_by_form_and_column('project', 'execute_way');

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle($year . '年縣市計畫資訊');
  $sheet->setCellValue('A1', '縣市');
  $sheet->setCellValue('B1', '計畫名稱');
  $sheet->getColumnDimension('B')->setWidth(30);
  $sheet->setCellValue('C1', '機構名稱');
  $sheet->getColumnDimension('C')->setWidth(30);
  $sheet->setCellValue('D1', '機構電話');
  $sheet->getColumnDimension('D')->setWidth(25);
  $sheet->setCellValue('E1', '機構地址');
  $sheet->getColumnDimension('E')->setWidth(30);
  $sheet->setCellValue('F1', '辦理模式');
  $sheet->setCellValue('G1', '辦理方式');
  $sheet->setCellValue('H1', '輔導員數量');
  $sheet->getColumnDimension('H')->setWidth(12);
  $sheet->setCellValue('I1', "跨局處會議\n次數");
  $sheet->getColumnDimension('I')->setWidth(12);
  $sheet->setCellValue('J1', "輔導人數");
  $sheet->getColumnDimension('J')->setWidth(12);
  $sheet->setCellValue('K1', "關懷人數");
  $sheet->getColumnDimension('K')->setWidth(12);
  $sheet->setCellValue('L1', "個別輔導\n小時");
  $sheet->getColumnDimension('L')->setWidth(12);
  $sheet->setCellValue('M1', "團體輔導\n小時");
  $sheet->getColumnDimension('M')->setWidth(12);
  $sheet->setCellValue('N1', "生涯探索\n課程小時");
  $sheet->getColumnDimension('N')->setWidth(12);
  $sheet->setCellValue('O1', "工作體驗\n人數");
  $sheet->getColumnDimension('O')->setWidth(12);
  $sheet->setCellValue('P1', "工作體驗\n小時");
  $sheet->getColumnDimension('P')->setWidth(12);
  $sheet->setCellValue('Q1', '計畫經費');
  $sheet->getColumnDimension('Q')->setWidth(12);

  foreach ($countyDelegateOrganizations as $value) {
    $sheet->setCellValue('A2', $value['countyName']);
    
    $sheet->setCellValue('B2', $value['projectName']);
    $sheet->setCellValue('C2', $value['organizationName']);
    $sheet->setCellValue('D2', $value['organizationPhone']);
    $sheet->setCellValue('E2', $value['organizationAddress']);
    foreach ($executeModes as $i) {
      if ($i['no'] == $value['executeMode']) {
          $sheet->setCellValue('F2', substr($i['content'], 0, 9));
      }
    }
    foreach ($executeWays as $i) {
      if ($i['no'] == $value['executeWay']) {
          $sheet->setCellValue('G2', $i['content']);
      }
    }
    $sheet->setCellValue('H2', $value['counselorCount']);
    $sheet->setCellValue('I2', $value['meetingCount']);
    $sheet->setCellValue('J2', $value['counselingMember']);
    $sheet->setCellValue('K2', $value['counselingYouth']);
    $sheet->setCellValue('L2', $value['counselingHour']);
    $sheet->setCellValue('M2', $value['groupCounselingHour']);
    $sheet->setCellValue('N2', $value['courseHour']);
    $sheet->setCellValue('O2', $value['workingMember']);
    $sheet->setCellValue('P2', $value['workingHour']);
    $sheet->setCellValue('Q2', number_format($value['funding']));
  }

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray)-1] . '2')->applyFromArray($styleArray);

  return $sheet;
}

function counselor_report_memberCounseling($sheet, $countyType, $counselor, $year) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');

  $memberCounselingData = [];
  $memberCounselingData['educationSourceNumber'] = $CI->MenuModel->get_referral_resource_by_content('教育資源')->no;
  $memberCounselingData['laborSourceNumber'] = $CI->MenuModel->get_referral_resource_by_content('勞政資源')->no;
  $memberCounselingData['socialSourceNumber'] = $CI->MenuModel->get_referral_resource_by_content('社政資源')->no;
  $memberCounselingData['healthSourceNumber'] = $CI->MenuModel->get_referral_resource_by_content('衛政資源')->no;
  $memberCounselingData['officeSourceNumber'] = $CI->MenuModel->get_referral_resource_by_content('警政資源')->no;
  $memberCounselingData['judicialSourceNumber'] = $CI->MenuModel->get_referral_resource_by_content('司法資源')->no;
  $memberCounselingData['otherSourceNumber'] = $CI->MenuModel->get_referral_resource_by_content('其他資源')->no;
  $memberCounselingData['countyDelegateOrganizations'] = $CI->ReportModel->get_county_delegate_organization($countyType, $year);
  $memberCounselingData['counselor'] = $counselor;
  $memberCounselingData['yearType'] = $year;

  $memberCounselings = $CI->ReportModel->get_member_counseling_by_counseler($memberCounselingData);

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle($year . '年學員輔導清單');
  $sheet->setCellValue('A1', '編號');
  $sheet->setCellValue('B1', '姓名');
  $sheet->setCellValue('C1', '輔導會談');
  $sheet->setCellValue('D1', '個別諮詢');
  $sheet->setCellValue('E1', '團體輔導');
  $sheet->setCellValue('F1', '生涯探索課程');
  $sheet->getColumnDimension('F')->setWidth(12);
  $sheet->setCellValue('G1', '工作體驗');

  $count = 1;
  foreach ($memberCounselings as $value) {
    $count++;
    $sheet->setCellValue('A' . $count, $value['system_no']);
    $sheet->setCellValue('B' . $count, $value['name']);
    $sheet->setCellValue('C' . $count, $value['individualCounselingHour']);
    $sheet->setCellValue('D' . $count, $value['individualCounselingHour']);
    $sheet->setCellValue('E' . $count, $value['groupCounselingHour']);
    $sheet->setCellValue('F' . $count, $value['courseAttendanceHour']);
    $sheet->setCellValue('G' . $count, $value['workAttendanceHour']);
  }

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray)-1] . $count)->applyFromArray($styleArray);

  return $sheet;
}

function counselor_report_counselEffection($sheet, $countyType, $year) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->helper('report');

  $surveyTypeData = [];
  $surveyTypeData['schoolSource'] = $CI->MenuModel->get_no_resource_by_content('動向調查', 'youth')->no;
  $surveyTypeData['referralSource'] = $CI->MenuModel->get_no_resource_by_content('轉介或自行開發', 'youth')->no;
  $surveyTypeData['highSource'] = $CI->MenuModel->get_no_resource_by_content('高中已錄取未註冊', 'youth')->no;
  $counselEffectionCounts = $CI->ReportModel->get_counsel_effection_by_county($countyType, $year, $surveyTypeData);
  $trendMemberArray = get_end_case_track_youth($countyType);

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle($year . '年輔導成效統計表');
  $sheet->setCellValue('A1', '縣市');
  $sheet->mergeCells('A1:A2');
  $sheet->setCellValue('B1', '青少年總人數');
  $sheet->mergeCells('B1:B2');
  $sheet->setCellValue('C1', '學員總人數');
  $sheet->mergeCells('C1:C2');
  $sheet->setCellValue('D1', '關懷追蹤');
  $sheet->mergeCells('D1:E1');
  $sheet->setCellValue('D2', '季追蹤');
  $sheet->setCellValue('E2', '月追蹤');
  $sheet->setCellValue('F1', "措施A\n總計時數");
  $sheet->getColumnDimension('F')->setWidth(12);
  $sheet->mergeCells('F1:G1');
  $sheet->setCellValue('F2', '個別輔導');
  $sheet->setCellValue('G2', '團體輔導');
  $sheet->setCellValue('H1', "措施B課程\n總計時數");
  $sheet->getColumnDimension('H')->setWidth(12);
  $sheet->mergeCells('H1:H2');
  $sheet->setCellValue('I1', "措施C工作\n總計時數");
  $sheet->getColumnDimension('I')->setWidth(12);
  $sheet->mergeCells('I1:I2');
  $sheet->setCellValue('J1', '結案總人數');
  $sheet->getColumnDimension('J')->setWidth(12);
  $sheet->mergeCells('J1:J2');

  $count = 2;
  foreach ($counselEffectionCounts as $value) {
    $count++;
    $sheet->setCellValue('A' . $count, $value['name']);
    $sheet->mergeCells('A' . $count . ':A' . ($count + 1));
    $sheet->setCellValue('B' . $count, $value['schoolSourceCount'] + $value['highSourceCount'] + count($trendMemberArray));
    $sheet->mergeCells('B' . $count . ':B' . ($count + 1));
    $sheet->setCellValue('C' . $count, $value['memberCount']);
    $sheet->mergeCells('C' . $count . ':C' . ($count + 1));
    $sheet->setCellValue('D' . $count, $value['seasonalReviewCount'] + $value['monthReviewCount']);
    $sheet->mergeCells('D' . $count . ':E' . $count);
    $sheet->setCellValue('D' . ($count + 1), $value['seasonalReviewCount']);
    $sheet->setCellValue('E' . ($count + 1), $value['monthReviewCount']);
    $sheet->setCellValue('F' . $count, $value['individualCounselingCount'] + $value['groupCounselingCount']);
    $sheet->mergeCells('F' . $count . ':G' . $count);
    $sheet->setCellValue('F' . ($count + 1), $value['individualCounselingCount']);
    $sheet->setCellValue('G' . ($count + 1), $value['groupCounselingCount']);
    $sheet->setCellValue('H' . $count, $value['courseAttendanceCount']);
    $sheet->mergeCells('H' . $count . ':H' . ($count + 1));
    $sheet->setCellValue('I' . $count, $value['workAttendanceCount']);
    $sheet->mergeCells('I' . $count . ':I' . ($count + 1));
    $sheet->setCellValue('J' . $count, $value['endCaseCount']);
    $sheet->mergeCells('J' . $count . ':J' . ($count + 1));
  }

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray) - 1] . ($count + 1))->applyFromArray($styleArray);

  return $sheet;
}

function counselor_report_counselEffectionIndividual($sheet, $countyType, $year) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');

  $data = [];
  $data['phoneService'] = $CI->MenuModel->get_no_resource_by_content('電訪', 'individual_counseling')->no;
  $data['personallyService'] = $CI->MenuModel->get_no_resource_by_content('親訪', 'individual_counseling')->no;
  $data['internetService'] = $CI->MenuModel->get_no_resource_by_content('網路', 'individual_counseling')->no;
  $data['educationService'] = $CI->MenuModel->get_no_resource_by_content('教育資源', 'individual_counseling')->no;
  $data['laborService'] = $CI->MenuModel->get_no_resource_by_content('勞政資源', 'individual_counseling')->no;
  $data['socialService'] = $CI->MenuModel->get_no_resource_by_content('社政資源', 'individual_counseling')->no;
  $data['healthService'] = $CI->MenuModel->get_no_resource_by_content('衛政資源', 'individual_counseling')->no;
  $data['officeService'] = $CI->MenuModel->get_no_resource_by_content('警政資源', 'individual_counseling')->no;
  $data['judicialService'] = $CI->MenuModel->get_no_resource_by_content('司法資源', 'individual_counseling')->no;
  $data['otherService'] = $CI->MenuModel->get_no_resource_by_content('其他資源', 'individual_counseling')->no;
  $data['county'] = $countyType;
  $data['yearType'] = $year;
  $counselEffectionIndividual = $CI->ReportModel->get_individual_counseling_report_by_county($data);

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle($year . '年個別輔導時數統計表');
  $sheet->setCellValue('A1', '縣市');
  $sheet->mergeCells('A1:A2');
  $sheet->setCellValue('B1', '個案服務');
  $sheet->mergeCells('B1:D1');
  $sheet->setCellValue('B2', '電訪');
  $sheet->setCellValue('C2', '親訪');
  $sheet->setCellValue('D2', '網路');
  $sheet->setCellValue('E1', '系統服務');
  $sheet->mergeCells('E1:K1');
  $sheet->setCellValue('E2', '教育資源');
  $sheet->setCellValue('F2', '勞政資源');
  $sheet->setCellValue('G2', '社政資源');
  $sheet->setCellValue('H2', '警政資源');
  $sheet->setCellValue('I2', '司法資源');
  $sheet->setCellValue('J2', '衛政資源');
  $sheet->setCellValue('K2', '其他資源');
  $sheet->setCellValue('L1', '個別輔導總時數');
  $sheet->getColumnDimension('L')->setWidth(15);
  $sheet->mergeCells('L1:L2');

  $count = 2;
  foreach ($counselEffectionIndividual as $value) {
    $count++;
    $sheet->setCellValue('A' . $count, $value['name']);
    $sheet->mergeCells('A' . $count . ':A' . ($count + 1));
    $sheet->setCellValue('B' . $count, $value['phoneServiceCount'] + $value['personallyServiceCount'] + $value['internetServiceCount']);
    $sheet->mergeCells('B' . $count . ':D' . $count);
    $sheet->setCellValue('B' . ($count + 1), $value['phoneServiceCount']);
    $sheet->setCellValue('C' . ($count + 1), $value['personallyServiceCount']);
    $sheet->setCellValue('D' . ($count + 1), $value['internetServiceCount']);
    $sheet->setCellValue('E' . $count, $value['educationServiceCount'] + $value['laborServiceCount'] + $value['socialServiceCount'] + $value['officeServiceCount']
      + $value['judicialServiceCount'] + $value['healthServiceCount'] + $value['otherServiceCount']);
    $sheet->mergeCells('E' . $count . ':K' . $count);
    $sheet->setCellValue('E' . ($count + 1), $value['educationServiceCount']);
    $sheet->setCellValue('F' . ($count + 1), $value['laborServiceCount']);
    $sheet->setCellValue('G' . ($count + 1), $value['socialServiceCount']);
    $sheet->setCellValue('H' . ($count + 1), $value['officeServiceCount']);
    $sheet->setCellValue('I' . ($count + 1), $value['judicialServiceCount']);
    $sheet->setCellValue('J' . ($count + 1), $value['healthServiceCount']);
    $sheet->setCellValue('K' . ($count + 1), $value['otherServiceCount']);
    $sheet->setCellValue('L' . $count, $value['phoneServiceCount'] + $value['personallyServiceCount'] + $value['internetServiceCount'] + $value['educationServiceCount'] + $value['laborServiceCount'] 
      + $value['socialServiceCount'] + $value['officeServiceCount'] + $value['judicialServiceCount'] + $value['healthServiceCount'] + $value['otherServiceCount']);
    $sheet->mergeCells('L' . $count . ':L' . ($count + 1));
  }

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray) - 1] . ($count + 1))->applyFromArray($styleArray);

  return $sheet;
}

function counselor_report_counselEffectionGroup($sheet, $countyType, $year) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');

  $data = [];
  $data['exploreService'] = $CI->MenuModel->get_no_resource_by_content('生涯探索', 'group_counseling')->no;
  $data['interactiveService'] = $CI->MenuModel->get_no_resource_by_content('人際溝通與互動', 'group_counseling')->no;
  $data['experienceService'] = $CI->MenuModel->get_no_resource_by_content('體驗教育', 'group_counseling')->no;
  $data['environmentService'] = $CI->MenuModel->get_no_resource_by_content('環境教育', 'group_counseling')->no;
  $data['judicialService'] = $CI->MenuModel->get_no_resource_by_content('法治教育', 'group_counseling')->no;
  $data['genderService'] = $CI->MenuModel->get_no_resource_by_content('性別平等教育', 'group_counseling')->no;
  $data['professionService'] = $CI->MenuModel->get_no_resource_by_content('職業訓練', 'group_counseling')->no;
  $data['volunteerService'] = $CI->MenuModel->get_no_resource_by_content('志願服務', 'group_counseling')->no;
  $data['otherService'] = $CI->MenuModel->get_no_resource_by_content('其他', 'group_counseling')->no;

  $data['county'] = $countyType;
  $data['yearType'] = $year;
  $counselEffectionGroup = $CI->ReportModel->get_group_counseling_report_by_county($data);

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle($year . '年團體輔導時數統計表');
  $sheet->setCellValue('A1', '縣市');
  $sheet->setCellValue('B1', '生涯探索');
  $sheet->setCellValue('C1', '人際溝通與互動');
  $sheet->getColumnDimension('C')->setWidth(18);
  $sheet->setCellValue('D1', '體驗教育');
  $sheet->setCellValue('E1', '環境教育');
  $sheet->setCellValue('F1', '法治教育');
  $sheet->setCellValue('G1', '性別平等教育');
  $sheet->getColumnDimension('G')->setWidth(15);
  $sheet->setCellValue('H1', '職業訓練');
  $sheet->setCellValue('I1', '志願服務');
  $sheet->setCellValue('J1', '其他');
  $sheet->setCellValue('K1', '團體輔導總時數');
  $sheet->getColumnDimension('K')->setWidth(15);

  $count = 1;
  foreach ($counselEffectionGroup as $value) {
    $count++;
    $sheet->setCellValue('A' . $count, $value['name']);
    $sheet->setCellValue('B' . $count, $value['exploreServiceCount']);
    $sheet->setCellValue('C' . $count, $value['interactiveServiceCount']);
    $sheet->setCellValue('D' . $count, $value['experienceServiceCount']);
    $sheet->setCellValue('E' . $count, $value['environmentServiceCount']);
    $sheet->setCellValue('F' . $count, $value['judicialServiceCount']);
    $sheet->setCellValue('G' . $count, $value['genderServiceCount']);
    $sheet->setCellValue('H' . $count, $value['professionServiceCount']);
    $sheet->setCellValue('I' . $count, $value['volunteerServiceCount']);
    $sheet->setCellValue('J' . $count, $value['otherServiceCount']);
    $sheet->setCellValue('K' . $count, $value['exploreServiceCount'] + $value['interactiveServiceCount'] + $value['experienceServiceCount'] + $value['environmentServiceCount']
      + $value['judicialServiceCount'] + $value['genderServiceCount'] + $value['professionServiceCount'] + $value['volunteerServiceCount'] + $value['otherServiceCount']);
  }

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray) - 1] . $count)->applyFromArray($styleArray);

  return $sheet;
}

function counselor_report_counselEffectionCourse($sheet, $countyType, $year) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');

  $data = [];
  $data['exploreCourse'] = $CI->MenuModel->get_no_resource_by_content('生涯探索與就業力培訓', 'course_reference')->no;
  $data['experienceCourse'] = $CI->MenuModel->get_no_resource_by_content('體驗教育及志願服務', 'course_reference')->no;
  $data['officeCourse'] = $CI->MenuModel->get_no_resource_by_content('法治(含反毒)及性別平等教育', 'course_reference')->no;
  $data['otherCourse'] = $CI->MenuModel->get_no_resource_by_content('其他及彈性運用', 'course_reference')->no;

  $data['county'] = $countyType;
  $data['yearType'] = $year;
  $counselEffectionCourse = $CI->ReportModel->get_course_report_by_county($data);

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle($year . '年生涯探索課程或活動時數統計表');
  $sheet->setCellValue('A1', '縣市');
  $sheet->setCellValue('B1', "生涯探索與\n就業力培訓");
  $sheet->getColumnDimension('B')->setWidth(18);
  $sheet->setCellValue('C1', "體驗教育及\n志願服務");
  $sheet->getColumnDimension('C')->setWidth(18);
  $sheet->setCellValue('D1', "法治(含反毒)及\n性別平等教育");
  $sheet->getColumnDimension('D')->setWidth(18);
  $sheet->setCellValue('E1', "其他及彈性運用");
  $sheet->getColumnDimension('E')->setWidth(18);
  $sheet->setCellValue('F1', "生涯探索課程\n或活動總時數");
  $sheet->getColumnDimension('F')->setWidth(18);

  $count = 1;
  foreach ($counselEffectionCourse as $value) {
    $count++;
    $sheet->setCellValue('A' . $count, $value['name']);
    $sheet->setCellValue('B' . $count, $value['exploreCourseCount']);
    $sheet->setCellValue('C' . $count, $value['experienceCourseCount']);
    $sheet->setCellValue('D' . $count, $value['officeCourseCount']);
    $sheet->setCellValue('E' . $count, $value['otherCourseCount']);
    $sheet->setCellValue('F' . $count, $value['exploreCourseCount'] + $value['experienceCourseCount'] + $value['officeCourseCount'] + $value['otherCourseCount']);
  }

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray) - 1] . $count)->applyFromArray($styleArray);

  return $sheet;
}

function counselor_report_counselEffectionWork($sheet, $countyType, $year) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');

  $data = [];
  $data['farmWork'] = $CI->MenuModel->get_no_resource_by_content('農、林、漁、牧業', 'company')->no;
  $data['miningWork'] = $CI->MenuModel->get_no_resource_by_content('礦業及土石採取業', 'company')->no;
  $data['manufacturingWork'] = $CI->MenuModel->get_no_resource_by_content('製造業', 'company')->no;
  $data['electricityWork'] = $CI->MenuModel->get_no_resource_by_content('電力及燃氣供應業', 'company')->no;
  $data['waterWork'] = $CI->MenuModel->get_no_resource_by_content('用水供應及污染整治業', 'company')->no;
  $data['buildWork'] = $CI->MenuModel->get_no_resource_by_content('營建工程業', 'company')->no;
  $data['wholesaleWork'] = $CI->MenuModel->get_no_resource_by_content('批發及零售業', 'company')->no;
  $data['transportWork'] = $CI->MenuModel->get_no_resource_by_content('運輸及倉儲業', 'company')->no;
  $data['hotelWork'] = $CI->MenuModel->get_no_resource_by_content('住宿及餐飲業', 'company')->no;
  $data['publishWork'] = $CI->MenuModel->get_no_resource_by_content('出版、影音製作、傳播及資通訊服務業', 'company')->no;
  $data['financialWork'] = $CI->MenuModel->get_no_resource_by_content('金融及保險業', 'company')->no;
  $data['immovablesWork'] = $CI->MenuModel->get_no_resource_by_content('不動產業', 'company')->no;
  $data['scienceWork'] = $CI->MenuModel->get_no_resource_by_content('專業、科學及技術服務業', 'company')->no;
  $data['supportWork'] = $CI->MenuModel->get_no_resource_by_content('支援服務業', 'company')->no;
  $data['militaryWork'] = $CI->MenuModel->get_no_resource_by_content('公共行政及國防；強制性社會安全', 'company')->no;
  $data['educationWork'] = $CI->MenuModel->get_no_resource_by_content('教育業', 'company')->no;
  $data['hospitalWork'] = $CI->MenuModel->get_no_resource_by_content('醫療保健及社會工作服務業', 'company')->no;
  $data['artWork'] = $CI->MenuModel->get_no_resource_by_content('藝術、娛樂及休閒服務業', 'company')->no;
  $data['otherWork'] = $CI->MenuModel->get_no_resource_by_content('其他服務業', 'company')->no;

  $data['county'] = $countyType;
  $data['yearType'] = $year;
  $counselEffectionWork = $CI->ReportModel->get_work_report_by_county($data);

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle($year . '年生涯探索課程或活動時數統計表');
  $sheet->setCellValue('A1', '縣市');
  $sheet->setCellValue('B1', '農、林、漁、牧業');
  $sheet->getColumnDimension('B')->setWidth(18);
  $sheet->setCellValue('C1', '礦業及土石採取業');
  $sheet->getColumnDimension('C')->setWidth(18);
  $sheet->setCellValue('D1', '製造業');
  $sheet->setCellValue('E1', '電力及燃氣供應業');
  $sheet->getColumnDimension('E')->setWidth(18);
  $sheet->setCellValue('F1', '用水供應及污染整治業');
  $sheet->getColumnDimension('F')->setWidth(18);
  $sheet->setCellValue('G1', '營建工程業');
  $sheet->setCellValue('H1', '批發及零售業');
  $sheet->setCellValue('I1', '運輸及倉儲業');
  $sheet->setCellValue('J1', '住宿及餐飲業');
  $sheet->setCellValue('K1', '出版、影音製作、傳播及資通訊服務業');
  $sheet->getColumnDimension('K')->setWidth(18);
  $sheet->setCellValue('L1', '金融及保險業');
  $sheet->setCellValue('M1', '不動產業');
  $sheet->setCellValue('N1', '專業、科學及技術服務業');
  $sheet->getColumnDimension('N')->setWidth(18);
  $sheet->setCellValue('O1', '支援服務業');
  $sheet->setCellValue('P1', '公共行政及國防；強制性社會安全');
  $sheet->getColumnDimension('P')->setWidth(18);
  $sheet->setCellValue('Q1', '教育業');
  $sheet->setCellValue('R1', '醫療保健及社會工作服務業');
  $sheet->getColumnDimension('R')->setWidth(18);
  $sheet->setCellValue('S1', '藝術、娛樂及休閒服務業');
  $sheet->getColumnDimension('S')->setWidth(18);
  $sheet->setCellValue('T1', '其他服務業');
  $sheet->setCellValue('U1', '工作體驗總時數');

  $count = 1;
  foreach ($counselEffectionWork as $value) {
    $count++;
    $sheet->setCellValue('A' . $count, $value['name']);
    $sheet->setCellValue('B' . $count, $value['farmWorkCount']);
    $sheet->setCellValue('C' . $count, $value['miningWorkCount']);
    $sheet->setCellValue('D' . $count, $value['manufacturingWorkCount']);
    $sheet->setCellValue('E' . $count, $value['electricityWorkCount']);
    $sheet->setCellValue('F' . $count, $value['waterWorkCount']);
    $sheet->setCellValue('G' . $count, $value['buildWorkCount']);
    $sheet->setCellValue('H' . $count, $value['wholesaleWorkCount']);
    $sheet->setCellValue('I' . $count, $value['transportWorkCount']);
    $sheet->setCellValue('J' . $count, $value['hotelWorkCount']);
    $sheet->setCellValue('K' . $count, $value['publishWorkCount']);
    $sheet->setCellValue('L' . $count, $value['financialWorkCount']);
    $sheet->setCellValue('M' . $count, $value['immovablesWorkCount']);
    $sheet->setCellValue('N' . $count, $value['scienceWorkCount']);
    $sheet->setCellValue('O' . $count, $value['supportWorkCount']);
    $sheet->setCellValue('P' . $count, $value['militaryWorkCount']);
    $sheet->setCellValue('Q' . $count, $value['educationWorkCount']);
    $sheet->setCellValue('R' . $count, $value['hospitalWorkCount']);
    $sheet->setCellValue('S' . $count, $value['artWorkCount']);
    $sheet->setCellValue('T' . $count, $value['otherWorkCount']);
    $sheet->setCellValue('U' . $count, $value['farmWorkCount'] + $value['miningWorkCount'] + $value['manufacturingWorkCount'] + $value['electricityWorkCount']
      + $value['waterWorkCount'] + $value['buildWorkCount'] + $value['wholesaleWorkCount'] + $value['transportWorkCount']
      + $value['hotelWorkCount'] + $value['publishWorkCount'] + $value['financialWorkCount'] + $value['immovablesWorkCount']
      + $value['scienceWorkCount'] + $value['supportWorkCount'] + $value['militaryWorkCount'] + $value['educationWorkCount']
      + $value['hospitalWorkCount'] + $value['artWorkCount'] + $value['otherWorkCount']);
  }

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray) - 1] . $count)->applyFromArray($styleArray);

  return $sheet;
}

function counselor_report_counselEffectionMeeting($sheet, $countyType, $year) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');

  $data = [];
  $data['meetingType'] = $CI->MenuModel->get_no_resource_by_content('跨局處會議', 'meeting')->no;
  $data['activityType'] = $CI->MenuModel->get_no_resource_by_content('預防性講座', 'meeting')->no;
  $data['county'] = $countyType;
  $data['yearType'] = $year;
  $counselEffectionMeeting = $CI->ReportModel->get_meeting_report_by_county($data);

  $columnNameArray = array('A', 'B', 'C', 'D');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle($year . '年跨局處會議及預防性講座統計表');
  $sheet->setCellValue('A1', '縣市');
  $sheet->setCellValue('B1', '跨局處會議');
  $sheet->getColumnDimension('B')->setWidth(12);
  $sheet->setCellValue('C1', '預防性講座');
  $sheet->getColumnDimension('C')->setWidth(12);
  $sheet->setCellValue('D1', '跨局處會議及預防性講座總次數');
  $sheet->getColumnDimension('D')->setWidth(20);

  $count = 1;
  foreach ($counselEffectionMeeting as $value) {
    $count++;
    $sheet->setCellValue('A' . $count, $value['name']);
    $sheet->setCellValue('B' . $count, $value['meetingCount']);
    $sheet->setCellValue('C' . $count, $value['activityCount']);
    $sheet->setCellValue('D' . $count, $value['meetingCount'] + $value['activityCount']);
  }

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray) - 1] . $count)->applyFromArray($styleArray);

  return $sheet;
}

function counselor_report_surveyTypeOldCaseTrack($sheet, $countyType, $year) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('CountyModel');
  $CI->load->helper('report');

  $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $year - 1, null);
  $trackData = $CI->ReportModel->get_old_case_seasonal_review_by_county($surveyTypeData);
  $sumDetail = null;
  $tableValue = get_seasonal_review_table($trackData);

  if ($countyType == 'all') $counties = $CI->CountyModel->get_all();
  else $counties = $CI->CountyModel->get_one($countyType);

  $note = $CI->ReportModel->get_old_case_seasonal_review_note_by_county($surveyTypeData);
  $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

  $sheet->setTitle($year . '年前一年度開案後動向調查追蹤表');
  $sheet = report_track_header($sheet, $tableValue, $sumDetail, $noteDetailArray);

  return $sheet;
}

function counselor_report_surveyTypeTwoYears($sheet, $countyType, $year) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');

  $surveyTypeData = [];
  $surveyTypeData['surveyTypeNumberOne'] = $CI->MenuModel->get_no_resource_by_content('01已就業', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTwo'] = $CI->MenuModel->get_no_resource_by_content('02已就學', 'youth')->no;
  $surveyTypeData['surveyTypeNumberThree'] = $CI->MenuModel->get_no_resource_by_content('03特教生', 'youth')->no;
  $surveyTypeData['surveyTypeNumberFour'] = $CI->MenuModel->get_no_resource_by_content('04準備升學', 'youth')->no;
  $surveyTypeData['surveyTypeNumberFive'] = $CI->MenuModel->get_no_resource_by_content('05準備或正在找工作', 'youth')->no;
  $surveyTypeData['surveyTypeNumberSix'] = $CI->MenuModel->get_no_resource_by_content('06參加職訓', 'youth')->no;
  $surveyTypeData['surveyTypeNumberSeven'] = $CI->MenuModel->get_no_resource_by_content('07家務勞動', 'youth')->no;
  $surveyTypeData['surveyTypeNumberEight'] = $CI->MenuModel->get_no_resource_by_content('08健康因素', 'youth')->no;
  $surveyTypeData['surveyTypeNumberNine'] = $CI->MenuModel->get_no_resource_by_content('09尚未規劃', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTen'] = $CI->MenuModel->get_no_resource_by_content('10失聯', 'youth')->no;
  $surveyTypeData['surveyTypeNumberEleven'] = $CI->MenuModel->get_no_resource_by_content('11自學', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTwelve'] = $CI->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產、社福機構安置、轉學待追蹤等)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTwelveOne'] = $CI->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTwelveTwo'] = $CI->MenuModel->get_no_resource_by_content('12其他動向(社福機構安置)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTwelveThree'] = $CI->MenuModel->get_no_resource_by_content('12其他動向(轉學)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberThirteen'] = $CI->MenuModel->get_no_resource_by_content('13不可抗力(去世、司法問題、出國)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberThirteenOne'] = $CI->MenuModel->get_no_resource_by_content('13不可抗力(去世)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberThirteenTwo'] = $CI->MenuModel->get_no_resource_by_content('13不可抗力(司法問題)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberThirteenThree'] = $CI->MenuModel->get_no_resource_by_content('13不可抗力(出國)', 'youth')->no;

  $surveyTypeData['county'] = $countyType;
  $surveyTypeData['yearType'] = $year - 4;
  $surveyTypeTwoYearsCounts = $CI->ReportModel->get_survey_type_by_county($surveyTypeData);

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle(($year - 4) . '學年度國中畢業未升學未就業青少年動向調查表');
  $sheet->setCellValue('A1', '縣市');
  $sheet->setCellValue('B1', '01已就業');
  $sheet->setCellValue('C1', '02已就學');
  $sheet->setCellValue('D1', '03特教生');
  $sheet->setCellValue('E1', '04準備升學');
  $sheet->setCellValue('F1', '05準備或正在找工作');
  $sheet->setCellValue('G1', '06參加職訓');
  $sheet->setCellValue('H1', '07家務勞動');
  $sheet->setCellValue('I1', '08健康因素');
  $sheet->setCellValue('J1', '09尚未規劃');
  $sheet->setCellValue('K1', '10失聯');
  $sheet->setCellValue('L1', '11自學');
  $sheet->setCellValue('M1', '12其他動向(懷孕待產、社福機構安置、轉學待追蹤等)');
  $sheet->getColumnDimension('M')->setWidth(20);
  $sheet->setCellValue('N1', '13不可抗力(去世、司法問題、出國)');
  $sheet->getColumnDimension('N')->setWidth(20);
  $sheet->setCellValue('O1', '需政府介入輔導人數(4-12)');
  $sheet->getColumnDimension('O')->setWidth(20);
  $sheet->setCellValue('P1', '未升學未就業人數(4-13)');
  $sheet->getColumnDimension('P')->setWidth(20);

  $count = 1;
  foreach ($surveyTypeTwoYearsCounts as $value) {
    $count++;
    $sheet->setCellValue('A' . $count, $value['name']);
    $sheet->setCellValue('B' . $count, $value['surveyTypeNumberOne']);
    $sheet->setCellValue('C' . $count, $value['surveyTypeNumberTwo']);
    $sheet->setCellValue('D' . $count, $value['surveyTypeNumberThree']);
    $sheet->setCellValue('E' . $count, $value['surveyTypeNumberFour']);
    $sheet->setCellValue('F' . $count, $value['surveyTypeNumberFive']);
    $sheet->setCellValue('G' . $count, $value['surveyTypeNumberSix']);
    $sheet->setCellValue('H' . $count, $value['surveyTypeNumberSeven']);
    $sheet->setCellValue('I' . $count, $value['surveyTypeNumberEight']);
    $sheet->setCellValue('J' . $count, $value['surveyTypeNumberNine']);
    $sheet->setCellValue('K' . $count, $value['surveyTypeNumberTen']);
    $sheet->setCellValue('L' . $count, $value['surveyTypeNumberEleven']);
    $sheet->setCellValue('M' . $count, $value['surveyTypeNumberTwelve'] + $value['surveyTypeNumberTwelveOne'] + $value['surveyTypeNumberTwelveTwo'] + $value['surveyTypeNumberTwelveThree']);
    $sheet->setCellValue('N' . $count, $value['surveyTypeNumberThirteen'] + $value['surveyTypeNumberThirteenOne'] + $value['surveyTypeNumberThirteenTwo'] + $value['surveyTypeNumberThirteenThree']);
    $sheet->setCellValue('O' . $count, $value['surveyTypeNumberFour'] + $value['surveyTypeNumberFive'] + $value['surveyTypeNumberSix'] + $value['surveyTypeNumberSeven']
      + $value['surveyTypeNumberEight'] + $value['surveyTypeNumberNine'] + $value['surveyTypeNumberTen'] + $value['surveyTypeNumberEleven']
      + $value['surveyTypeNumberTwelve'] + $value['surveyTypeNumberTwelveOne'] + $value['surveyTypeNumberTwelveTwo'] + $value['surveyTypeNumberTwelveThree']);
    $sheet->setCellValue('P' . $count, $value['surveyTypeNumberFour'] + $value['surveyTypeNumberFive'] + $value['surveyTypeNumberSix'] + $value['surveyTypeNumberSeven']
      + $value['surveyTypeNumberEight'] + $value['surveyTypeNumberNine'] + $value['surveyTypeNumberTen'] + $value['surveyTypeNumberEleven']
      + $value['surveyTypeNumberTwelve'] + $value['surveyTypeNumberTwelveOne'] + $value['surveyTypeNumberTwelveTwo'] + $value['surveyTypeNumberTwelveThree']
      + $value['surveyTypeNumberThirteen'] + $value['surveyTypeNumberThirteenOne'] + $value['surveyTypeNumberThirteenTwo'] + $value['surveyTypeNumberThirteenThree']);
  }

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray) - 1] . $count)->applyFromArray($styleArray);

  return $sheet;
}

function counselor_report_surveyTypeOneYears($sheet, $countyType, $year) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');

  $surveyTypeData = [];
  $surveyTypeData['surveyTypeNumberOne'] = $CI->MenuModel->get_no_resource_by_content('01已就業', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTwo'] = $CI->MenuModel->get_no_resource_by_content('02已就學', 'youth')->no;
  $surveyTypeData['surveyTypeNumberThree'] = $CI->MenuModel->get_no_resource_by_content('03特教生', 'youth')->no;
  $surveyTypeData['surveyTypeNumberFour'] = $CI->MenuModel->get_no_resource_by_content('04準備升學', 'youth')->no;
  $surveyTypeData['surveyTypeNumberFive'] = $CI->MenuModel->get_no_resource_by_content('05準備或正在找工作', 'youth')->no;
  $surveyTypeData['surveyTypeNumberSix'] = $CI->MenuModel->get_no_resource_by_content('06參加職訓', 'youth')->no;
  $surveyTypeData['surveyTypeNumberSeven'] = $CI->MenuModel->get_no_resource_by_content('07家務勞動', 'youth')->no;
  $surveyTypeData['surveyTypeNumberEight'] = $CI->MenuModel->get_no_resource_by_content('08健康因素', 'youth')->no;
  $surveyTypeData['surveyTypeNumberNine'] = $CI->MenuModel->get_no_resource_by_content('09尚未規劃', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTen'] = $CI->MenuModel->get_no_resource_by_content('10失聯', 'youth')->no;
  $surveyTypeData['surveyTypeNumberEleven'] = $CI->MenuModel->get_no_resource_by_content('11自學', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTwelve'] = $CI->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產、社福機構安置、轉學待追蹤等)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTwelveOne'] = $CI->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTwelveTwo'] = $CI->MenuModel->get_no_resource_by_content('12其他動向(社福機構安置)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTwelveThree'] = $CI->MenuModel->get_no_resource_by_content('12其他動向(轉學)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberThirteen'] = $CI->MenuModel->get_no_resource_by_content('13不可抗力(去世、司法問題、出國)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberThirteenOne'] = $CI->MenuModel->get_no_resource_by_content('13不可抗力(去世)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberThirteenTwo'] = $CI->MenuModel->get_no_resource_by_content('13不可抗力(司法問題)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberThirteenThree'] = $CI->MenuModel->get_no_resource_by_content('13不可抗力(出國)', 'youth')->no;

  $surveyTypeData['county'] = $countyType;
  $surveyTypeData['yearType'] = $year - 3;
  $surveyTypeOneYearsCounts = $CI->ReportModel->get_survey_type_by_county($surveyTypeData);

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle(($year - 3) . '學年度國中畢業未升學未就業青少年動向調查表');
  $sheet->setCellValue('A1', '縣市');
  $sheet->setCellValue('B1', '01已就業');
  $sheet->setCellValue('C1', '02已就學');
  $sheet->setCellValue('D1', '03特教生');
  $sheet->setCellValue('E1', '04準備升學');
  $sheet->setCellValue('F1', '05準備或正在找工作');
  $sheet->setCellValue('G1', '06參加職訓');
  $sheet->setCellValue('H1', '07家務勞動');
  $sheet->setCellValue('I1', '08健康因素');
  $sheet->setCellValue('J1', '09尚未規劃');
  $sheet->setCellValue('K1', '10失聯');
  $sheet->setCellValue('L1', '11自學');
  $sheet->setCellValue('M1', '12其他動向(懷孕待產、社福機構安置、轉學待追蹤等)');
  $sheet->getColumnDimension('M')->setWidth(20);
  $sheet->setCellValue('N1', '13不可抗力(去世、司法問題、出國)');
  $sheet->getColumnDimension('N')->setWidth(20);
  $sheet->setCellValue('O1', '需政府介入輔導人數(4-12)');
  $sheet->getColumnDimension('O')->setWidth(20);
  $sheet->setCellValue('P1', '未升學未就業人數(4-13)');
  $sheet->getColumnDimension('P')->setWidth(20);

  $count = 1;
  foreach ($surveyTypeOneYearsCounts as $value) {
    $count++;
    $sheet->setCellValue('A' . $count, $value['name']);
    $sheet->setCellValue('B' . $count, $value['surveyTypeNumberOne']);
    $sheet->setCellValue('C' . $count, $value['surveyTypeNumberTwo']);
    $sheet->setCellValue('D' . $count, $value['surveyTypeNumberThree']);
    $sheet->setCellValue('E' . $count, $value['surveyTypeNumberFour']);
    $sheet->setCellValue('F' . $count, $value['surveyTypeNumberFive']);
    $sheet->setCellValue('G' . $count, $value['surveyTypeNumberSix']);
    $sheet->setCellValue('H' . $count, $value['surveyTypeNumberSeven']);
    $sheet->setCellValue('I' . $count, $value['surveyTypeNumberEight']);
    $sheet->setCellValue('J' . $count, $value['surveyTypeNumberNine']);
    $sheet->setCellValue('K' . $count, $value['surveyTypeNumberTen']);
    $sheet->setCellValue('L' . $count, $value['surveyTypeNumberEleven']);
    $sheet->setCellValue('M' . $count, $value['surveyTypeNumberTwelve'] + $value['surveyTypeNumberTwelveOne'] + $value['surveyTypeNumberTwelveTwo'] + $value['surveyTypeNumberTwelveThree']);
    $sheet->setCellValue('N' . $count, $value['surveyTypeNumberThirteen'] + $value['surveyTypeNumberThirteenOne'] + $value['surveyTypeNumberThirteenTwo'] + $value['surveyTypeNumberThirteenThree']);
    $sheet->setCellValue('O' . $count, $value['surveyTypeNumberFour'] + $value['surveyTypeNumberFive'] + $value['surveyTypeNumberSix'] + $value['surveyTypeNumberSeven']
      + $value['surveyTypeNumberEight'] + $value['surveyTypeNumberNine'] + $value['surveyTypeNumberTen'] + $value['surveyTypeNumberEleven']
      + $value['surveyTypeNumberTwelve'] + $value['surveyTypeNumberTwelveOne'] + $value['surveyTypeNumberTwelveTwo'] + $value['surveyTypeNumberTwelveThree']);
    $sheet->setCellValue('P' . $count, $value['surveyTypeNumberFour'] + $value['surveyTypeNumberFive'] + $value['surveyTypeNumberSix'] + $value['surveyTypeNumberSeven']
      + $value['surveyTypeNumberEight'] + $value['surveyTypeNumberNine'] + $value['surveyTypeNumberTen'] + $value['surveyTypeNumberEleven']
      + $value['surveyTypeNumberTwelve'] + $value['surveyTypeNumberTwelveOne'] + $value['surveyTypeNumberTwelveTwo'] + $value['surveyTypeNumberTwelveThree']
      + $value['surveyTypeNumberThirteen'] + $value['surveyTypeNumberThirteenOne'] + $value['surveyTypeNumberThirteenTwo'] + $value['surveyTypeNumberThirteenThree']);
  }

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray) - 1] . $count)->applyFromArray($styleArray);

  return $sheet;
}

function counselor_report_surveyTypeNowYears($sheet, $countyType, $year) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');

  $surveyTypeData = [];
  $surveyTypeData['surveyTypeNumberOne'] = $CI->MenuModel->get_no_resource_by_content('01已就業', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTwo'] = $CI->MenuModel->get_no_resource_by_content('02已就學', 'youth')->no;
  $surveyTypeData['surveyTypeNumberThree'] = $CI->MenuModel->get_no_resource_by_content('03特教生', 'youth')->no;
  $surveyTypeData['surveyTypeNumberFour'] = $CI->MenuModel->get_no_resource_by_content('04準備升學', 'youth')->no;
  $surveyTypeData['surveyTypeNumberFive'] = $CI->MenuModel->get_no_resource_by_content('05準備或正在找工作', 'youth')->no;
  $surveyTypeData['surveyTypeNumberSix'] = $CI->MenuModel->get_no_resource_by_content('06參加職訓', 'youth')->no;
  $surveyTypeData['surveyTypeNumberSeven'] = $CI->MenuModel->get_no_resource_by_content('07家務勞動', 'youth')->no;
  $surveyTypeData['surveyTypeNumberEight'] = $CI->MenuModel->get_no_resource_by_content('08健康因素', 'youth')->no;
  $surveyTypeData['surveyTypeNumberNine'] = $CI->MenuModel->get_no_resource_by_content('09尚未規劃', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTen'] = $CI->MenuModel->get_no_resource_by_content('10失聯', 'youth')->no;
  $surveyTypeData['surveyTypeNumberEleven'] = $CI->MenuModel->get_no_resource_by_content('11自學', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTwelve'] = $CI->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產、社福機構安置、轉學待追蹤等)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTwelveOne'] = $CI->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTwelveTwo'] = $CI->MenuModel->get_no_resource_by_content('12其他動向(社福機構安置)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberTwelveThree'] = $CI->MenuModel->get_no_resource_by_content('12其他動向(轉學)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberThirteen'] = $CI->MenuModel->get_no_resource_by_content('13不可抗力(去世、司法問題、出國)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberThirteenOne'] = $CI->MenuModel->get_no_resource_by_content('13不可抗力(去世)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberThirteenTwo'] = $CI->MenuModel->get_no_resource_by_content('13不可抗力(司法問題)', 'youth')->no;
  $surveyTypeData['surveyTypeNumberThirteenThree'] = $CI->MenuModel->get_no_resource_by_content('13不可抗力(出國)', 'youth')->no;

  $surveyTypeData['county'] = $countyType;
  $surveyTypeData['yearType'] = $year - 2;
  $surveyTypeNowYearsCounts = $CI->ReportModel->get_survey_type_by_county($surveyTypeData);

  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setTitle(($year - 2) . '學年度國中畢業未升學未就業青少年動向調查表');
  $sheet->setCellValue('A1', '縣市');
  $sheet->setCellValue('B1', '01已就業');
  $sheet->setCellValue('C1', '02已就學');
  $sheet->setCellValue('D1', '03特教生');
  $sheet->setCellValue('E1', '04準備升學');
  $sheet->setCellValue('F1', '05準備或正在找工作');
  $sheet->setCellValue('G1', '06參加職訓');
  $sheet->setCellValue('H1', '07家務勞動');
  $sheet->setCellValue('I1', '08健康因素');
  $sheet->setCellValue('J1', '09尚未規劃');
  $sheet->setCellValue('K1', '10失聯');
  $sheet->setCellValue('L1', '11自學');
  $sheet->setCellValue('M1', '12其他動向(懷孕待產、社福機構安置、轉學待追蹤等)');
  $sheet->getColumnDimension('M')->setWidth(20);
  $sheet->setCellValue('N1', '13不可抗力(去世、司法問題、出國)');
  $sheet->getColumnDimension('N')->setWidth(20);
  $sheet->setCellValue('O1', '需政府介入輔導人數(4-12)');
  $sheet->getColumnDimension('O')->setWidth(20);
  $sheet->setCellValue('P1', '未升學未就業人數(4-13)');
  $sheet->getColumnDimension('P')->setWidth(20);

  $count = 1;
  foreach ($surveyTypeNowYearsCounts as $value) {
    $count++;
    $sheet->setCellValue('A' . $count, $value['name']);
    $sheet->setCellValue('B' . $count, $value['surveyTypeNumberOne']);
    $sheet->setCellValue('C' . $count, $value['surveyTypeNumberTwo']);
    $sheet->setCellValue('D' . $count, $value['surveyTypeNumberThree']);
    $sheet->setCellValue('E' . $count, $value['surveyTypeNumberFour']);
    $sheet->setCellValue('F' . $count, $value['surveyTypeNumberFive']);
    $sheet->setCellValue('G' . $count, $value['surveyTypeNumberSix']);
    $sheet->setCellValue('H' . $count, $value['surveyTypeNumberSeven']);
    $sheet->setCellValue('I' . $count, $value['surveyTypeNumberEight']);
    $sheet->setCellValue('J' . $count, $value['surveyTypeNumberNine']);
    $sheet->setCellValue('K' . $count, $value['surveyTypeNumberTen']);
    $sheet->setCellValue('L' . $count, $value['surveyTypeNumberEleven']);
    $sheet->setCellValue('M' . $count, $value['surveyTypeNumberTwelve'] + $value['surveyTypeNumberTwelveOne'] + $value['surveyTypeNumberTwelveTwo'] + $value['surveyTypeNumberTwelveThree']);
    $sheet->setCellValue('N' . $count, $value['surveyTypeNumberThirteen'] + $value['surveyTypeNumberThirteenOne'] + $value['surveyTypeNumberThirteenTwo'] + $value['surveyTypeNumberThirteenThree']);
    $sheet->setCellValue('O' . $count, $value['surveyTypeNumberFour'] + $value['surveyTypeNumberFive'] + $value['surveyTypeNumberSix'] + $value['surveyTypeNumberSeven']
      + $value['surveyTypeNumberEight'] + $value['surveyTypeNumberNine'] + $value['surveyTypeNumberTen'] + $value['surveyTypeNumberEleven']
      + $value['surveyTypeNumberTwelve'] + $value['surveyTypeNumberTwelveOne'] + $value['surveyTypeNumberTwelveTwo'] + $value['surveyTypeNumberTwelveThree']);
    $sheet->setCellValue('P' . $count, $value['surveyTypeNumberFour'] + $value['surveyTypeNumberFive'] + $value['surveyTypeNumberSix'] + $value['surveyTypeNumberSeven']
      + $value['surveyTypeNumberEight'] + $value['surveyTypeNumberNine'] + $value['surveyTypeNumberTen'] + $value['surveyTypeNumberEleven']
      + $value['surveyTypeNumberTwelve'] + $value['surveyTypeNumberTwelveOne'] + $value['surveyTypeNumberTwelveTwo'] + $value['surveyTypeNumberTwelveThree']
      + $value['surveyTypeNumberThirteen'] + $value['surveyTypeNumberThirteenOne'] + $value['surveyTypeNumberThirteenTwo'] + $value['surveyTypeNumberThirteenThree']);
  }

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray) - 1] . $count)->applyFromArray($styleArray);

  return $sheet;
}

function counselor_report_surveyTypeHighSchoolTrack($sheet, $countyType, $year) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('CountyModel');

  $CI->load->helper('report');

  $source = $CI->MenuModel->get_no_resource_by_content('高中已錄取未註冊', 'youth')->no;
  $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $year - 4, $source);
  $trackData = $CI->ReportModel->get_high_school_seasonal_review_by_county($surveyTypeData);
  
  $sumDetail = null;
  $tableValue = get_seasonal_review_table($trackData);

  if ($countyType == 'all') $counties = $CI->CountyModel->get_all();
  else $counties = $CI->CountyModel->get_one($countyType);
  
  $note = $CI->ReportModel->get_high_school_seasonal_review_note_by_county($surveyTypeData);
  $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

  $sheet->setTitle(($year-1) . '年度高中已錄取未註冊青少年動向調查追蹤表');
  $sheet = report_track_header($sheet, $tableValue, $sumDetail, $noteDetailArray);

  return $sheet;
}

function counselor_report_surveyTypeTwoYearsTrack($sheet, $countyType, $year) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('CountyModel');
  $CI->load->helper('report');

  $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $year - 4, null);
  $trackData = $CI->ReportModel->get_seasonal_review_by_county($surveyTypeData);
  $sumDetail = null;
  $tableValue = get_seasonal_review_table($trackData);

  if ($countyType == 'all') $counties = $CI->CountyModel->get_all();
  else $counties = $CI->CountyModel->get_one($countyType);
  $note = $CI->ReportModel->get_seasonal_review_note_by_county($surveyTypeData);
  $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);
  $sheet->setTitle(($year - 4) . '學年度國中畢業未升學未就業青少年動向調查追蹤表');
  $sheet = report_track_header($sheet, $tableValue, $sumDetail, $noteDetailArray);

  return $sheet;
}

function counselor_report_surveyTypeOneYearsTrack($sheet, $countyType, $year) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('CountyModel');
  $CI->load->helper('report');

  $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $year - 3, null);
  $trackData = $CI->ReportModel->get_seasonal_review_by_county($surveyTypeData);
  $sumDetail = null;
  $tableValue = get_seasonal_review_table($trackData);

  if ($countyType == 'all') $counties = $CI->CountyModel->get_all();
  else $counties = $CI->CountyModel->get_one($countyType);
  $note = $CI->ReportModel->get_seasonal_review_note_by_county($surveyTypeData);
  $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);
  $sheet->setTitle(($year - 3) . '學年度國中畢業未升學未就業青少年動向調查追蹤表');
  $sheet = report_track_header($sheet, $tableValue, $sumDetail, $noteDetailArray);

  return $sheet;
}

function counselor_report_surveyTypeNowYearsTrack($sheet, $countyType, $year) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');
  $CI->load->model('CountyModel');
  $CI->load->helper('report');

  $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $year - 2, null);
  $trackData = $CI->ReportModel->get_seasonal_review_by_county($surveyTypeData);
  $sumDetail = null;
  $tableValue = get_seasonal_review_table($trackData);

  if ($countyType == 'all') $counties = $CI->CountyModel->get_all();
  else $counties = $CI->CountyModel->get_one($countyType);

  $note = $CI->ReportModel->get_seasonal_review_note_by_county($surveyTypeData);
  $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

  $sheet->setTitle(($year - 2) . '學年度國中畢業未升學未就業青少年動向調查追蹤表');
  $sheet = report_track_header($sheet, $tableValue, $sumDetail, $noteDetailArray);

  return $sheet;
}

function report_track_header($sheet, $tableValue, $sumDetail, $noteDetailArray) {
  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setCellValue('A1', '縣市');
  $sheet->mergeCells('A1:A2');
  $sheet->setCellValue('B1', '具輔導成效');
  $sheet->mergeCells('B1:E1');

  $sheet->setCellValue('F1', '尚無輔導成效');
  $sheet->mergeCells('F1:L1');

  $sheet->setCellValue('M1', '不可抗力');
  $sheet->mergeCells('M1:R1');

  $sheet->setCellValue('S1', '總計');
  $sheet->mergeCells('S1:S2');
  $sheet->setCellValue('T1', '青少年人數');
  $sheet->mergeCells('T1:T2');
  $sheet->setCellValue('U1', '備註');
  $sheet->mergeCells('U1:U2');
  $sheet->getColumnDimension('U')->setWidth(100);


  $sheet->setCellValue('B2', '1.已就業');
  $sheet->setCellValue('C2', '2.已就學');
  $sheet->setCellValue('D2', '3.職業訓練或勞政單位協助中');
  $sheet->setCellValue('E2', '4.其他');

  $sheet->setCellValue('F2', '5.準備升學');
  $sheet->setCellValue('G2', '6.準備或正在找工作');
  $sheet->setCellValue('H2', '7.家務勞動');
  $sheet->setCellValue('I2', '8.健康因素');
  $sheet->setCellValue('J2', '9.尚未規劃');
  $sheet->setCellValue('K2', '10.失聯');
  $sheet->setCellValue('L2', '11.其他');

  $sheet->setCellValue('M2', '12.特教生');
  $sheet->setCellValue('N2', '13.移民');
  $sheet->setCellValue('O2', '14.警政或司法單位協助中');
  $sheet->setCellValue('P2', '15.服兵役');
  $sheet->setCellValue('Q2', '16.死亡');
  $sheet->setCellValue('R2', '17.成年');

  $count = 2;
  $index = 0;
  foreach ($tableValue as $value) {
    $count++;
    $sheet->setCellValue('A' . $count, $value['name']);
    $sheet->setCellValue('B' . $count, $value['one']);
    $sheet->setCellValue('C' . $count, $value['two']);
    $sheet->setCellValue('D' . $count, $value['three']);
    $sheet->setCellValue('E' . $count, $value['four']);
    $sheet->setCellValue('F' . $count, $value['five']);
    $sheet->setCellValue('G' . $count, $value['six']);
    $sheet->setCellValue('H' . $count, $value['seven']);
    $sheet->setCellValue('I' . $count, $value['eight']);
    $sheet->setCellValue('J' . $count, $value['nine']);
    $sheet->setCellValue('K' . $count, $value['ten']);
    $sheet->setCellValue('L' . $count, $value['eleven']);
    $sheet->setCellValue('M' . $count, $value['twelve']);
    $sheet->setCellValue('N' . $count, $value['thirteen']);
    $sheet->setCellValue('O' . $count, $value['fourteen']);
    $sheet->setCellValue('P' . $count, $value['fifteen']);
    $sheet->setCellValue('Q' . $count, $value['sixteen']);
    $sheet->setCellValue('R' . $count, $value['seventeen']);
    $sheet->setCellValue('S' . $count, $value['eighteen']);
    $sheet->setCellValue('T' . $count, $value['nineteen']);
    $sheet->setCellValue('U' . $count, $noteDetailArray[$index]);
    $index += 1;
  }

  if($sumDetail) :

    $count++;
    $sheet->setCellValue('A' . $count, '總計');
    $sheet->setCellValue('B' . $count, $sumDetail['one']);
    $sheet->setCellValue('C' . $count, $sumDetail['two']);
    $sheet->setCellValue('D' . $count, $sumDetail['three']);
    $sheet->setCellValue('E' . $count, $sumDetail['four']);
    $sheet->setCellValue('F' . $count, $sumDetail['five']);
    $sheet->setCellValue('G' . $count, $sumDetail['six']);
    $sheet->setCellValue('H' . $count, $sumDetail['seven']);
    $sheet->setCellValue('I' . $count, $sumDetail['eight']);
    $sheet->setCellValue('J' . $count, $sumDetail['nine']);
    $sheet->setCellValue('K' . $count, $sumDetail['ten']);
    $sheet->setCellValue('L' . $count, $sumDetail['eleven']);
    $sheet->setCellValue('M' . $count, $sumDetail['twelve']);
    $sheet->setCellValue('N' . $count, $sumDetail['thirteen']);
    $sheet->setCellValue('O' . $count, $sumDetail['fourteen']);
    $sheet->setCellValue('P' . $count, $sumDetail['fifteen']);
    $sheet->setCellValue('Q' . $count, $sumDetail['sixteen']);
    $sheet->setCellValue('R' . $count, $sumDetail['seventeen']);
    $sheet->setCellValue('S' . $count, $sumDetail['eighteen']);
    $sheet->setCellValue('T' . $count, $sumDetail['nineteen']);
  endif;

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray)-1] . $count)->applyFromArray($styleArray);

  return $sheet;
}

function month_report_track_header($sheet, $tableValue, $sumDetail, $noteDetailArray) {
  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setCellValue('A1', '縣市');
  $sheet->mergeCells('A1:A2');
  $sheet->setCellValue('B1', '具輔導成效');
  $sheet->mergeCells('B1:E1');

  $sheet->setCellValue('F1', '尚無輔導成效');
  $sheet->mergeCells('F1:L1');

  $sheet->setCellValue('M1', '不可抗力');
  $sheet->mergeCells('M1:R1');

  $sheet->setCellValue('S1', '總計');
  $sheet->mergeCells('S1:S2');
  $sheet->setCellValue('T1', '青少年人數');
  $sheet->mergeCells('T1:T2');
  $sheet->setCellValue('U1', '備註');
  $sheet->mergeCells('U1:U2');
  $sheet->getColumnDimension('U')->setWidth(100);


  $sheet->setCellValue('B2', '1.已就業');
  $sheet->setCellValue('C2', '2.已就學');
  $sheet->setCellValue('D2', '3.職業訓練或勞政單位協助中');
  $sheet->setCellValue('E2', '4.其他');

  $sheet->setCellValue('F2', '5.準備升學');
  $sheet->setCellValue('G2', '6.準備或正在找工作');
  $sheet->setCellValue('H2', '7.家務勞動');
  $sheet->setCellValue('I2', '8.健康因素');
  $sheet->setCellValue('J2', '9.尚未規劃');
  $sheet->setCellValue('K2', '10.失聯');
  $sheet->setCellValue('L2', '11.其他');

  $sheet->setCellValue('M2', '12.特教生');
  $sheet->setCellValue('N2', '13.移民');
  $sheet->setCellValue('O2', '14.警政或司法單位協助中');
  $sheet->setCellValue('P2', '15.服兵役');
  $sheet->setCellValue('Q2', '16.死亡');
  $sheet->setCellValue('R2', '17.成年');

  $count = 2;
  $index = 0;
  foreach ($tableValue as $value) {
    $count++;
    $sheet->setCellValue('A' . $count, $value['name']);
    $sheet->setCellValue('B' . $count, $value['one']);
    $sheet->setCellValue('C' . $count, $value['two']);
    $sheet->setCellValue('D' . $count, $value['three']);
    $sheet->setCellValue('E' . $count, $value['four']);
    $sheet->setCellValue('F' . $count, $value['five']);
    $sheet->setCellValue('G' . $count, $value['six']);
    $sheet->setCellValue('H' . $count, $value['seven']);
    $sheet->setCellValue('I' . $count, $value['eight']);
    $sheet->setCellValue('J' . $count, $value['nine']);
    $sheet->setCellValue('K' . $count, $value['ten']);
    $sheet->setCellValue('L' . $count, $value['eleven']);
    $sheet->setCellValue('M' . $count, $value['twelve']);
    $sheet->setCellValue('N' . $count, $value['thirteen']);
    $sheet->setCellValue('O' . $count, $value['fourteen']);
    $sheet->setCellValue('P' . $count, $value['fifteen']);
    $sheet->setCellValue('Q' . $count, $value['sixteen']);
    $sheet->setCellValue('R' . $count, $value['seventeen']);
    $sheet->setCellValue('S' . $count, $value['eighteen']);
    $sheet->setCellValue('T' . $count, $value['nineteen']);
    $sheet->setCellValue('U' . $count, $value['note']);
    $index += 1;
  }

  if($sumDetail) :

    $count++;
    $sheet->setCellValue('A' . $count, '總計');
    $sheet->setCellValue('B' . $count, $sumDetail['one']);
    $sheet->setCellValue('C' . $count, $sumDetail['two']);
    $sheet->setCellValue('D' . $count, $sumDetail['three']);
    $sheet->setCellValue('E' . $count, $sumDetail['four']);
    $sheet->setCellValue('F' . $count, $sumDetail['five']);
    $sheet->setCellValue('G' . $count, $sumDetail['six']);
    $sheet->setCellValue('H' . $count, $sumDetail['seven']);
    $sheet->setCellValue('I' . $count, $sumDetail['eight']);
    $sheet->setCellValue('J' . $count, $sumDetail['nine']);
    $sheet->setCellValue('K' . $count, $sumDetail['ten']);
    $sheet->setCellValue('L' . $count, $sumDetail['eleven']);
    $sheet->setCellValue('M' . $count, $sumDetail['twelve']);
    $sheet->setCellValue('N' . $count, $sumDetail['thirteen']);
    $sheet->setCellValue('O' . $count, $sumDetail['fourteen']);
    $sheet->setCellValue('P' . $count, $sumDetail['fifteen']);
    $sheet->setCellValue('Q' . $count, $sumDetail['sixteen']);
    $sheet->setCellValue('R' . $count, $sumDetail['seventeen']);
    $sheet->setCellValue('S' . $count, $sumDetail['eighteen']);
    $sheet->setCellValue('T' . $count, $sumDetail['nineteen']);
  endif;

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray)-1] . $count)->applyFromArray($styleArray);

  return $sheet;
}

function month_yda_report_track_header($sheet, $tableValue, $sumDetail, $counties) {
  $columnNameArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U');
  foreach($columnNameArray as $column) {
    $sheet->getStyle($column)->getAlignment()->setVertical('center');
    $sheet->getStyle($column)->getAlignment()->setHorizontal('center');
    $sheet->getStyle($column)->getAlignment()->setWrapText(true);
  }

  $sheet->setCellValue('A1', '縣市');
  $sheet->mergeCells('A1:A2');
  $sheet->setCellValue('B1', '具輔導成效');
  $sheet->mergeCells('B1:E1');

  $sheet->setCellValue('F1', '尚無輔導成效');
  $sheet->mergeCells('F1:L1');

  $sheet->setCellValue('M1', '不可抗力');
  $sheet->mergeCells('M1:R1');

  $sheet->setCellValue('S1', '總計');
  $sheet->mergeCells('S1:S2');
  $sheet->setCellValue('T1', '青少年人數');
  $sheet->mergeCells('T1:T2');
  $sheet->setCellValue('U1', '備註');
  $sheet->mergeCells('U1:U2');
  $sheet->getColumnDimension('U')->setWidth(100);


  $sheet->setCellValue('B2', '1.已就業');
  $sheet->setCellValue('C2', '2.已就學');
  $sheet->setCellValue('D2', '3.職業訓練或勞政單位協助中');
  $sheet->setCellValue('E2', '4.其他');

  $sheet->setCellValue('F2', '5.準備升學');
  $sheet->setCellValue('G2', '6.準備或正在找工作');
  $sheet->setCellValue('H2', '7.家務勞動');
  $sheet->setCellValue('I2', '8.健康因素');
  $sheet->setCellValue('J2', '9.尚未規劃');
  $sheet->setCellValue('K2', '10.失聯');
  $sheet->setCellValue('L2', '11.其他');

  $sheet->setCellValue('M2', '12.特教生');
  $sheet->setCellValue('N2', '13.移民');
  $sheet->setCellValue('O2', '14.警政或司法單位協助中');
  $sheet->setCellValue('P2', '15.服兵役');
  $sheet->setCellValue('Q2', '16.死亡');
  $sheet->setCellValue('R2', '17.成年');

  $count = 2;
  $index = 0;
  foreach ($tableValue as $value) {
    $count++;
    $sheet->setCellValue('A' . $count, $counties[$index]['name']);
    $sheet->setCellValue('B' . $count, empty($value) ? 0 : $value->one);
    $sheet->setCellValue('C' . $count, empty($value) ? 0 : $value->two);
    $sheet->setCellValue('D' . $count, empty($value) ? 0 : $value->three);
    $sheet->setCellValue('E' . $count, empty($value) ? 0 : $value->four);
    $sheet->setCellValue('F' . $count, empty($value) ? 0 : $value->five);
    $sheet->setCellValue('G' . $count, empty($value) ? 0 : $value->six);
    $sheet->setCellValue('H' . $count, empty($value) ? 0 : $value->seven);
    $sheet->setCellValue('I' . $count, empty($value) ? 0 : $value->eight);
    $sheet->setCellValue('J' . $count, empty($value) ? 0 : $value->nine);
    $sheet->setCellValue('K' . $count, empty($value) ? 0 : $value->ten);
    $sheet->setCellValue('L' . $count, empty($value) ? 0 : $value->eleven);
    $sheet->setCellValue('M' . $count, empty($value) ? 0 : $value->twelve);
    $sheet->setCellValue('N' . $count, empty($value) ? 0 : $value->thirteen);
    $sheet->setCellValue('O' . $count, empty($value) ? 0 : $value->fourteen);
    $sheet->setCellValue('P' . $count, empty($value) ? 0 : $value->fifteen);
    $sheet->setCellValue('Q' . $count, empty($value) ? 0 : $value->sixteen);
    $sheet->setCellValue('R' . $count, empty($value) ? 0 : $value->seventeen);
    $sheet->setCellValue('S' . $count, empty($value) ? 0 : $value->eighteen);
    $sheet->setCellValue('T' . $count, empty($value) ? 0 : $value->nineteen);
    $sheet->setCellValue('U' . $count, empty($value) ? 0 : $value->note);
    $index += 1;
  }

  if($sumDetail) :

    $count++;
    $sheet->setCellValue('A' . $count, '總計');
    $sheet->setCellValue('B' . $count, $sumDetail['one']);
    $sheet->setCellValue('C' . $count, $sumDetail['two']);
    $sheet->setCellValue('D' . $count, $sumDetail['three']);
    $sheet->setCellValue('E' . $count, $sumDetail['four']);
    $sheet->setCellValue('F' . $count, $sumDetail['five']);
    $sheet->setCellValue('G' . $count, $sumDetail['six']);
    $sheet->setCellValue('H' . $count, $sumDetail['seven']);
    $sheet->setCellValue('I' . $count, $sumDetail['eight']);
    $sheet->setCellValue('J' . $count, $sumDetail['nine']);
    $sheet->setCellValue('K' . $count, $sumDetail['ten']);
    $sheet->setCellValue('L' . $count, $sumDetail['eleven']);
    $sheet->setCellValue('M' . $count, $sumDetail['twelve']);
    $sheet->setCellValue('N' . $count, $sumDetail['thirteen']);
    $sheet->setCellValue('O' . $count, $sumDetail['fourteen']);
    $sheet->setCellValue('P' . $count, $sumDetail['fifteen']);
    $sheet->setCellValue('Q' . $count, $sumDetail['sixteen']);
    $sheet->setCellValue('R' . $count, $sumDetail['seventeen']);
    $sheet->setCellValue('S' . $count, $sumDetail['eighteen']);
    $sheet->setCellValue('T' . $count, $sumDetail['nineteen']);
  endif;

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => '00000000'],
      ],
    ],
  ];
  $sheet->getStyle($columnNameArray[0] . '1:' . $columnNameArray[count($columnNameArray)-1] . $count)->applyFromArray($styleArray);

  return $sheet;
}