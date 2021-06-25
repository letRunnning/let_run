<?php if (!defined('BASEPATH')) {
  exit('No direct script access allowed');
}

function report_one_execute_detail($county, $year, $month, $type) {
  $CI = get_instance();
  $CI->load->model('MenuModel');
  $CI->load->model('ProjectModel');
  $CI->load->model('CountyModel');
  $CI->load->model('CounselingMemberCountReportModel');
  $CI->load->model('MemberModel');
  $CI->load->model('UserModel');

  $projects = $CI->ProjectModel->get_latest_by_county($county);
  $countyAndOrg = $CI->CountyModel->get_by_county($county);
  $counselingMemberCountReport = $CI->CounselingMemberCountReportModel->get_by_no($year, $month, $county);
  $executeModes = $CI->MenuModel->get_by_form_and_column('project', 'execute_mode');
  $executeWays = $CI->MenuModel->get_by_form_and_column('project', 'execute_way');
  $qualifications = $CI->MenuModel->get_by_form_and_column('counselor', 'qualification');
  $counties = $CI->CountyModel->get_all();

  $countyName = "";
  foreach ($counties as $value) {
    $countyName = ($value['no'] == $county) ? $value['name'] : $countyName;   
  }

  $executeMode = "";
  $executeWay = "";
  foreach ($executeModes as $value) {
    $executeMode = ($value['no'] == $projects->execute_mode) ? $value['content'] : $executeMode;     
  }
  foreach ($executeWays as $value) {
    $executeWay = ($value['no'] == $projects->execute_way) ? $value['content'] : $executeWay;  
  }

  $space = "";
  $space = ($type == 'web') ? " <br/>" : " \n";

  $projectDetail = "";
  $projectDetail = $projectDetail . $executeMode . $space;
  $projectDetail = $projectDetail . $space;
  $projectDetail = $projectDetail . $executeWay . $space;

  if($executeWay == '委辦') {
    $counselorNote = $projects->counselor_count ? ($projects->counselor_count . "位專任輔導員") : "";
    $meetingNote = $projects->meeting_count ? ("、跨局處會議" . $projects->meeting_count . "次") : "";
    $counselingHourNote =  $projects->counseling_hour ? ("個別諮詢" . $projects->counseling_hour . "小時") : "";
    $groupCounselingHourNote = $projects->group_counseling_hour ? ("+團體輔導" . $projects->group_counseling_hour . "小時") : "";
    $courseNote = $projects->course_hour ? ("、生涯探索課程或活動" . $projects->course_hour . "小時") : "";
    $workNote = $projects->working_member ? ("、工作體驗" . $projects->working_member . "人x" . $projects->working_hour . "小時 = " . ($projects->working_member * $projects->working_hour) . "小時") : "";
    $counselingYouthNote = $projects->counseling_youth ? ("關懷" . $projects->counseling_youth . "人") : "";
    $counselingMemberNote = $projects->counseling_member ? ("、輔導" . $projects->counseling_member . "人") : "";
    $trackNote = $projects->track_description ? ("、" . $projects->track_description) : "";

    $projectDetail = $projectDetail . $counselorNote . $meetingNote . $space;
    $projectDetail = $projectDetail . $counselingHourNote . $groupCounselingHourNote . $courseNote . $workNote . $space;
    $projectDetail = $projectDetail . $counselingYouthNote . $counselingMemberNote . $trackNote . $space;
  } 

  $projectDetail = $projectDetail . $space;
  $projectDetail = $projectDetail . "承辦單位 : " . $countyAndOrg->orgnizer . $space;
  $projectDetail = $projectDetail . "執行單位 : " . $countyAndOrg->organizationName . $space;

  $accumCounselingMemberCount = $CI->MemberModel->get_by_county_count($county, $month, $year);

  $newCaseCount = empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->new_case_member;
  $oldCaseCount = empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->old_case_member;
  $twoYearSurvryCaseCount = empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->two_year_survry_case_member;
  $oneYearSurvryCaseCount = empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->one_year_survry_case_member;
  $nowYearSurvryCaseCount = empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->now_year_survry_case_member;
  $nextYearSurvryCaseCount = empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->next_year_survry_case_member;
  $highSchoolSurveryCaseCount = empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->high_school_survry_case_member;

  $forceMajeureNote = empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->force_majeure_note;
  $workTrainningNote = empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->work_trainning_note;

  $counselorInfo = $CI->UserModel->get_counselor_detail_by_county($county, $year, $month);
  $counselorDetail = "";
  $executeDetail = "";

  if ($counselingMemberCountReport) {
    $executeDetail = $executeDetail . "一、 輔導員" . $space;
    $memberCount = 0;
    foreach ($counselorInfo as $value) {
      $memberCount++;
      $tempCount = 1;
      $value['qualification'] = explode(",", $value['qualification']);
      foreach ($qualifications as $i) {
        if (in_array($i['no'], $value['qualification']) == 1) {
          $signal = ($tempCount == 1) ? '' : '、';
          $counselorDetail = $counselorDetail . '(' . $tempCount . ')' . $i['content'] . "";
          $tempCount++;
        }
      }
      $executeDetail = $executeDetail . $memberCount . '. ' . $value['userName'] . '於' . $value['duty_date'] . '到職，' . $counselorDetail . $space;
      $counselorDetail = "";
    }

    $executeDetail = $executeDetail . "二、 本年度輔導對象來源" . $space;
    $executeDetail = $executeDetail . "1. 本年度新開案個案人數：" . $counselingMemberCountReport->new_case_member . $space;
    $executeDetail = $executeDetail . "2. 前一年度持續輔導人數：" . $counselingMemberCountReport->old_case_member . $space;
    $executeDetail = $executeDetail . "3. " . ($year - 4) . "學年度動向調查結果輔導人數：" . $counselingMemberCountReport->two_year_survry_case_member . $space;
    $executeDetail = $executeDetail . "4. " . ($year - 3) . "學年度動向調查結果輔導人數：" . $counselingMemberCountReport->one_year_survry_case_member . $space;
    $executeDetail = $executeDetail . "5. " . ($year - 2) . "學年度動向調查結果輔導人數：" . $counselingMemberCountReport->now_year_survry_case_member . $space;
    //$executeDetail = $executeDetail . "4. " . ($year - 1) . "學年度動向調查結果輔導人數：" . $counselingMemberCountReport->next_year_survry_case_member . $space;
    $executeDetail = $executeDetail . "6. " . ($year - 1) . "學年度高中已錄取未註冊結果輔導人數：" . $counselingMemberCountReport->high_school_survry_case_member . $space;

    $executeDetail = $executeDetail . "三、 辦理情形" . $space;
    $executeDetail = $executeDetail . "1. 累計至本月輔導會談：" . $counselingMemberCountReport->month_counseling_hour .
      "小時、生涯探索課程或活動：" . $counselingMemberCountReport->month_course_hour . "小時、工作體驗：" . $counselingMemberCountReport->month_working_hour . "小時。" .$space;

    $executeDetail = $executeDetail . "2. 簡述生涯探索課程與工作體驗紀錄：" . $space;

    $executeDetail = $executeDetail . "3. 簡述不可抗力及其他人數之原因：" . $space;
    $executeDetail = $executeDetail . $counselingMemberCountReport->force_majeure_note;

    $executeDetail = $executeDetail . "4. 簡述參加職訓人數之單位及課程：" .$space;
    $executeDetail = $executeDetail . $counselingMemberCountReport->work_trainning_note;

    $executeDetail = $executeDetail . "5. 簡述本月工作歷程：" . $space;
    $executeDetail = $executeDetail . $counselingMemberCountReport->other_note . $space;

    $fundingExecute = $counselingMemberCountReport->funding_execute ? $counselingMemberCountReport->funding_execute : 0;

    $projectFunding = $projects->funding ? $projects->funding : 1;
    $executeDetail = $executeDetail . "6. 經費執行率：";
    $executeDetail = $executeDetail . (round($fundingExecute / $projectFunding, 2) * 100) . "%(" . number_format($fundingExecute) . "元/" . number_format($projects->funding) . "元)" . $space;

    $executeDetail = $executeDetail . "四、 投保情形" . $space;
    $executeDetail = $executeDetail . $counselingMemberCountReport->insure_note . $space;
  }

  $array = [];
  $array['projectDetail'] = $projectDetail;
  $array['executeDetail'] = $executeDetail;

  return $array;
}

function completion_create_function($type, $reportName, $reportNo, $reportArray) {
  $CI = get_instance();
  $CI->load->model('CompletionModel');

  $number = 0;
  foreach ($reportArray as $value) {
    if ($value != null || $value == 0) $number++;   
  }

  $rate = round($number / count($reportArray), 2) * 100;

  if($type == 'create') $isSuccess = $CI->CompletionModel->create_one($reportName, $reportNo, $rate);
  else $isSuccess = $CI->CompletionModel->update_one($reportName, $reportNo, $rate);

  return $isSuccess;

}

function youth_track_note($note) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('ReportModel');

}

function get_end_case_track_youth($countyType) {
  $CI = get_instance();

  $CI->load->model('MenuModel');
  $CI->load->model('MemberModel');
  $CI->load->model('MonthReviewModel');

  $youths = $CI->YouthModel->get_by_case_trend_and_county($countyType);
  $keepMemberArray = $trendMemberArray = $endMemberArray = [];
  foreach($youths as $value) {
    $isMember = $CI->MemberModel->is_member($value['no']);
    $value['originMonthReview'] = 0;
    $value['originSeasonalReview'] = 0;
    $value['alreadyMonthReview'] = 0;
    $value['alreadySeasonalReview'] = 0;
    if ($isMember) {
      array_push($keepMemberArray, $value);    
    }
    else {
      $endDate = $value['end_date'];
      $originMonth = substr($endDate, 5, 2);
      $originYear = substr($endDate, 0, 4);
      $originDay = substr($endDate, 8, 2);
      
      $originMonthReview = $originSeasonalReview = 0;
      

      if($originMonth + 6 > 12) {
        $temp = ($originMonth + 6) - 12;
        $originMonthReview = 12 - $originMonth;
        $temp = 6 - $originMonthReview;
        $originSeasonalReview = $temp / 3;
        $originSeasonalReview = ceil($originSeasonalReview);
        $value['originMonthReview'] = $originMonthReview;
        $value['originSeasonalReview'] = $originSeasonalReview;

        $onDateYear = $originYear + 1;
        $onDateMonth = ($originMonth + 6) - 12;
        $onDateDay = $originDay;
        $onDate = $onDateYear . '-' . $onDateMonth . '-' . $onDateDay;

        for($i = 0; $i < $originMonthReview; $i++  ) {
          $fromDate = $originYear . '-' . ($originMonth + $i) . '-' .$originDay;
          $toDate = $originYear . '-' . ($originMonth + $i + 1) . '-' .$originDay;
          $countMonth = count($CI->MonthReviewModel->get_by_date($value['memberNo'], $fromDate, $toDate));
          $value['alreadyMonthReview'] += ($countMonth) ? 1: 0;
        }

        for($i = 0; $i < ($originSeasonalReview*3); $i+=3  ) {
          $fromDate = ($originYear + 1) . '-' . (1 + $i) . '-' .$originDay;
          $toDate = $originYear . '-' . (1 + $i + 3) . '-' .$originDay;
          $countSeasonal = count($CI->SeasonalReviewModel->get_by_date($value['no'], $fromDate, $toDate));
          $value['alreadySeasonalReview'] += ($countSeasonal) ? 1: 0;
        }               
      } else {
        $originMonthReview = 6;
        $originSeasonalReview = 0;
        $value['originMonthReview'] = $originMonthReview;
        $value['originSeasonalReview'] = $originSeasonalReview;

        $onDateYear = $originYear;
        $onDateMonth = $originMonth + 6;
        $onDateDay = $originDay;
        $onDate = $onDateYear . '-' . $onDateMonth . '-' . $onDateDay;

        for($i = 0; $i < $originMonthReview; $i++  ) {
          $fromDate = $originYear . '-' . ($originMonth + $i) . '-' .$originDay;
          $toDate = $originYear . '-' . ($originMonth + $i + 1) . '-' .$originDay;
          $countMonth = count($CI->MonthReviewModel->get_by_date($value['memberNo'], $fromDate, $toDate));
          $value['alreadyMonthReview'] += ($countMonth) ? 1: 0;
        }
      }

      // $alreadyMonthReview = count($CI->MonthReviewModel->get_by_member($value['memberNo']));
      // $alreadySeasonalReview = count($CI->SeasonalReviewModel->get_by_youth($value['no']));
      $alreadyMonthReview = $value['alreadyMonthReview'];
      $alreadySeasonalReview = $value['alreadySeasonalReview'];

      $monthReview = $originMonthReview - $alreadyMonthReview;
      $seasonalReview = $originSeasonalReview - $alreadySeasonalReview;

      if($monthReview>0 || $seasonalReview>0) {
        array_push($trendMemberArray, $value); 
      } else {
        array_push($endMemberArray, $value);     
      }
     
      // if( ( strtotime(date("Y-m-d")) - strtotime($onDate)) < 0) {
      //   array_push($trendMemberArray, $value); 
      // } else {
      //   array_push($endMemberArray, $value);     
      // }
    }
  }

  return $trendMemberArray;
}

function get_seasonal_review_trend_menu_no($countyType, $yearType, $source) {
  $CI = get_instance();
  $CI->load->model('MenuModel');

  $surveyTypeData = [];
  $surveyTypeData['alreadyAttendingSchool'] = $CI->MenuModel->get_no_resource_by_content('已就學', 'seasonal_review')->no;
  $surveyTypeData['alreadyWorking'] = $CI->MenuModel->get_no_resource_by_content('已就業', 'seasonal_review')->no;
  $surveyTypeData['prepareToSchool'] = $CI->MenuModel->get_no_resource_by_content('準備升學', 'seasonal_review')->no;
  $surveyTypeData['prepareToWork'] = $CI->MenuModel->get_no_resource_by_content('準備或正在找工作', 'seasonal_review')->no;
  $surveyTypeData['transferLabor'] = $CI->MenuModel->get_no_resource_by_content('勞政單位協助中', 'seasonal_review')->no;
  $surveyTypeData['transferOtherOne'] = $CI->MenuModel->get_no_resource_by_content('社政單位協助中', 'seasonal_review')->no;
  $surveyTypeData['transferOtherTwo'] = $CI->MenuModel->get_no_resource_by_content('衛政單位協助中', 'seasonal_review')->no;
  $surveyTypeData['transferOtherThree'] = $CI->MenuModel->get_no_resource_by_content('警政單位協助中', 'seasonal_review')->no;
  $surveyTypeData['transferOtherFour'] = $CI->MenuModel->get_no_resource_by_content('司法單位協助中', 'seasonal_review')->no;
  $surveyTypeData['transferOtherFive'] = $CI->MenuModel->get_no_resource_by_content('其他單位協助中', 'seasonal_review')->no;
  $surveyTypeData['noPlan'] = $CI->MenuModel->get_no_resource_by_content('尚無規劃', 'seasonal_review')->no;
  $surveyTypeData['lostContact'] = $CI->MenuModel->get_no_resource_by_content('未取得聯繫', 'seasonal_review')->no;
  $surveyTypeData['military'] = $CI->MenuModel->get_no_resource_by_content('服兵役', 'seasonal_review')->no;
  $surveyTypeData['pregnancy'] = $CI->MenuModel->get_no_resource_by_content('待產/育兒', 'seasonal_review')->no;
  $surveyTypeData['immigration'] = $CI->MenuModel->get_no_resource_by_content('移民(出國)', 'seasonal_review')->no;
  $surveyTypeData['health'] = $CI->MenuModel->get_no_resource_by_content('健康因素(含休養中)', 'seasonal_review')->no;
  $surveyTypeData['other'] = $CI->MenuModel->get_no_resource_by_content('其他', 'seasonal_review')->no;
  $surveyTypeData['specialEducationStudent'] = $CI->MenuModel->get_no_resource_by_content('特教生', 'seasonal_review')->no;
  $surveyTypeData['training'] = $CI->MenuModel->get_no_resource_by_content('參加職訓', 'seasonal_review')->no;
  $surveyTypeData['familyLabor'] = $CI->MenuModel->get_no_resource_by_content('家務勞動', 'seasonal_review')->no;
  $surveyTypeData['death'] = $CI->MenuModel->get_no_resource_by_content('死亡', 'seasonal_review')->no;
  $surveyTypeData['adult'] = $CI->MenuModel->get_no_resource_by_content('成年', 'seasonal_review')->no;
  $surveyTypeData['selfStudy'] = $CI->MenuModel->get_no_resource_by_content('自學', 'seasonal_review')->no;
  $surveyTypeData['county'] = $countyType;
  $surveyTypeData['yearType'] = $yearType;
  $surveyTypeData['source'] = $source;

  return $surveyTypeData;
}

function get_seasonal_review_sum($value) {
  $typeArray = [];
  $typeArray['one'] = $typeArray['two'] = $typeArray['three'] = $typeArray['four']  
    = $typeArray['five'] = $typeArray['six'] = $typeArray['seven'] = $typeArray['eight']  
    = $typeArray['nine'] = $typeArray['ten'] = $typeArray['eleven'] = $typeArray['twelve']  
    = $typeArray['thirteen'] = $typeArray['fourteen'] = $typeArray['fifteen'] = $typeArray['sixteen']  
    = $typeArray['seventeen'] = $typeArray['eighteen'] = $typeArray['nineteen'] = 0;
  
  foreach($value as $i) {
    $typeArray['one'] += $i['already_working'];
    $typeArray['two'] += $i['already_attending_school'];
    $typeArray['three'] += ($i['training'] + $i['transfer_labor']);
    $typeArray['four'] += ($i['transfer_other_one'] + $i['transfer_other_two'] + $i['transfer_other_five'] + $i['self_study']);
    $typeArray['five'] += $i['prepare_to_school'];
    $typeArray['six'] += $i['prepare_to_work'];
    $typeArray['seven'] += $i['family_labor'];
    $typeArray['eight'] += $i['health'];
    $typeArray['nine'] += $i['no_plan'];
    $typeArray['ten'] += $i['lost_contact'];
    $typeArray['eleven'] += ($i['pregnancy'] + $i['other']);
    $typeArray['twelve'] += $i['special_education_student'];
    $typeArray['thirteen'] += $i['immigration'];
    $typeArray['fourteen'] += ($i['transfer_other_three'] + $i['transfer_other_four']);
    $typeArray['fifteen'] += $i['military'];
    $typeArray['sixteen'] += $i['death'];
    $typeArray['seventeen'] += $i['adult'];
    $typeArray['eighteen'] += ( $i['already_working'] + $i['already_attending_school'] + $i['training'] + $i['transfer_labor']  
      + $i['transfer_other_one'] + $i['transfer_other_two'] + $i['transfer_other_five'] + $i['self_study']
      + $i['prepare_to_school'] + $i['prepare_to_work'] + $i['family_labor'] + $i['health'] 
      + $i['no_plan'] + $i['lost_contact'] + $i['pregnancy'] + $i['other'] 
      + $i['special_education_student'] + $i['immigration'] + $i['transfer_other_three'] + $i['transfer_other_four']
      + $i['military'] + $i['death'] + $i['adult']);
    $typeArray['nineteen'] += $i['youthCount'];
  }

  return $typeArray;
}

function get_seasonal_review_month_report_sum($value) {
  $typeArray = [];
  $typeArray['one'] = $typeArray['two'] = $typeArray['three'] = $typeArray['four']  
    = $typeArray['five'] = $typeArray['six'] = $typeArray['seven'] = $typeArray['eight']  
    = $typeArray['nine'] = $typeArray['ten'] = $typeArray['eleven'] = $typeArray['twelve']  
    = $typeArray['thirteen'] = $typeArray['fourteen'] = $typeArray['fifteen'] = $typeArray['sixteen']  
    = $typeArray['seventeen'] = $typeArray['eighteen'] = $typeArray['nineteen'] = 0;
  
  foreach($value as $i) {
    $typeArray['one'] += $i['one'];
    $typeArray['two'] += $i['two'];
    $typeArray['three'] += $i['three'];
    $typeArray['four'] += $i['four'];
    $typeArray['five'] += $i['five'];
    $typeArray['six'] += $i['six'];
    $typeArray['seven'] += $i['seven'];
    $typeArray['eight'] += $i['eight'];
    $typeArray['nine'] += $i['nine'];
    $typeArray['ten'] += $i['ten'];
    $typeArray['eleven'] += $i['eleven'];
    $typeArray['twelve'] += $i['twelve'];
    $typeArray['thirteen'] += $i['thirteen'];
    $typeArray['fourteen'] += $i['fourteen'];
    $typeArray['fifteen'] += $i['fifteen'];
    $typeArray['sixteen'] += $i['sixteen'];
    $typeArray['seventeen'] += $i['seventeen'];
    $typeArray['eighteen'] += $i['eighteen'];
    $typeArray['nineteen'] += $i['nineteen'];
  }

  return $typeArray;
}

function get_seasonal_review_note($counties, $surveyTypeData, $note) {
  $CI = get_instance();
  $CI->load->model('ReportModel');
  $noteDetailArray = [];
  foreach ($counties as $county) {
              
    $noteTypeDetailArray = [];
    $alreadyAttendingSchoolDetail = '[已就學]';
    $alreadyWorkingDetail = '[已就業]';
    $prepareToSchoolDetail = '[準備升學]';
    $prepareToWorkDetail = '[準備或正在找工作]';
    $transferLaborDetail = '[勞政單位協助中]';
    $transferOtherOneDetail = '[社政單位協助中]';
    $transferOtherTwoDetail = '[衛政單位協助中]';
    $transferOtherThreeDetail = '[警政單位協助中]';
    $transferOtherFourDetail = '[司法單位協助中]';
    $transferOtherFiveDetail = '[其他單位協助中]';
    $noPlanDetail = '[尚無規劃]';
    $lostContactDetail = '[未取得聯繫]';
    $militaryDetail = '[服兵役]';
    $pregnancyDetail = '[待產/育兒]';
    $immigrationDetail = '[移民(出國)]';
    $healthDetail = '[健康因素(含休養中)]';
    $otherDetail = '[其他]';
    $specialEducationStudentDetail = '[特教生]';
    $trainingDetail = '[參加職訓]';
    $familyLaborDetail = '[家務勞動]';
    $deathDetail = '[死亡]';
    $adultDetail = '[成年]';
    $selfStudyDetail = '[自學]';
    $noteDetail = "";
    $surveyTypeData['county'] = $county['no'];
    
    if($note) {
      foreach($note as $value) {
        if ($value['trend'] == $surveyTypeData['alreadyAttendingSchool']) {
          if ($value['trend_description']) {
              $alreadyAttendingSchoolDetail = $alreadyAttendingSchoolDetail . "\n" . $value['youthName'] . '-' . $value['trend_description'];
          }
        }
        elseif ($value['trend'] == $surveyTypeData['alreadyWorking']) {
          if ($value['trend_description']) {
              $alreadyWorkingDetail = $alreadyWorkingDetail . "\n" . $value['youthName'] . '-' . $value['trend_description'];
          }
        }
        elseif ($value['trend'] == $surveyTypeData['prepareToSchool']) {
          if ($value['trend_description']) {
              $prepareToSchoolDetail = $prepareToSchoolDetail . "\n" . $value['youthName'] . '-' . $value['trend_description'];
          }
        }
        elseif ($value['trend'] == $surveyTypeData['prepareToWork']) {
          if ($value['trend_description']) {
              $prepareToWorkDetail = $prepareToWorkDetail . "\n" . $value['youthName'] . '-' . $value['trend_description'];
          }
        }
        elseif ($value['trend'] == $surveyTypeData['transferLabor']) {
          if ($value['trend_description']) {
              $transferLaborDetail = $transferLaborDetail . "\n" . $value['youthName'] . '-' . $value['trend_description'];
          }
        }
        elseif ($value['trend'] == $surveyTypeData['transferOtherOne']) {
          if ($value['trend_description']) {
              $transferOtherOneDetail = $transferOtherOneDetail . "\n" . $value['youthName'] . '-' . $value['trend_description'];
          }
        }
        elseif ($value['trend'] == $surveyTypeData['transferOtherTwo']) {
          if ($value['trend_description']) {
              $transferOtherTwoDetail = $transferOtherTwoDetail . "\n" . $value['youthName'] . '-' . $value['trend_description'];
          }
        }
        elseif ($value['trend'] == $surveyTypeData['transferOtherThree']) {
          if ($value['trend_description']) {
              $transferOtherThreeDetail = $transferOtherThreeDetail . "\n" . $value['youthName'] . '-' . $value['trend_description'];
          }
        }
        elseif ($value['trend'] == $surveyTypeData['transferOtherFour']) {
          if ($value['trend_description']) {
              $transferOtherFourDetail = $transferOtherFourDetail . "\n" . $value['youthName'] . '-' . $value['trend_description'];
          }
        }
        elseif ($value['trend'] == $surveyTypeData['transferOtherFive']) {
          if ($value['trend_description']) {
              $transferOtherFiveDetail = $transferOtherFiveDetail . "\n" . $value['youthName'] . '-' . $value['trend_description'];
          }
        }
        elseif ($value['trend'] == $surveyTypeData['noPlan']) {
          if ($value['trend_description']) {
              $noPlanDetail = $noPlanDetail . "\n" . $value['youthName'] . '-' . $value['trend_description'];
          }
        }
        elseif ($value['trend'] == $surveyTypeData['lostContact']) {
          if ($value['trend_description']) {
              $lostContactDetail = $lostContactDetail . "\n" . $value['youthName'] . '-' . $value['trend_description'];
          }
        }
        elseif ($value['trend'] == $surveyTypeData['military']) {
          if ($value['trend_description']) {
              $militaryDetail = $militaryDetail . "\n" . $value['youthName'] . '-' . $value['trend_description'];
          }
        }
        elseif ($value['trend'] == $surveyTypeData['pregnancy']) {
          if ($value['trend_description']) {
              $pregnancyDetail = $pregnancyDetail . "\n" . $value['youthName'] . '-' . $value['trend_description'];
          }
        }
        elseif ($value['trend'] == $surveyTypeData['immigration']) {
          if ($value['trend_description']) {
              $immigrationDetail = $immigrationDetail . "\n" . $value['youthName'] . '-' . $value['trend_description'];
          }
        }
        elseif ($value['trend'] == $surveyTypeData['health']) {
          if ($value['trend_description']) {
              $healthDetail = $healthDetail . "\n" . $value['youthName'] . '-' . $value['trend_description'];
          }
        }
        elseif ($value['trend'] == $surveyTypeData['other']) {
          if ($value['trend_description']) {
              $otherDetail = $otherDetail . "\n" . $value['youthName'] . '-' . $value['trend_description'];
          }
        }
        elseif ($value['trend'] == $surveyTypeData['specialEducationStudent']) {
          if ($value['trend_description']) {
              $specialEducationStudentDetail = $specialEducationStudentDetail . "\n" . $value['youthName'] . '-' . $value['trend_description'];
          }
        }
        elseif ($value['trend'] == $surveyTypeData['training']) {
          if ($value['trend_description']) {
              $trainingDetail = $trainingDetail . "\n" . $value['youthName'] . '-' . $value['trend_description'];
          }
        }
        elseif ($value['trend'] == $surveyTypeData['familyLabor']) {
          if ($value['trend_description']) {
              $familyLaborDetail = $familyLaborDetail . "\n" . $value['youthName'] . '-' . $value['trend_description'];
          }
        }
        elseif ($value['trend'] == $surveyTypeData['death']) {
          if ($value['trend_description']) {
              $deathDetail = $deathDetail . "\n" . $value['youthName'] . '-' . $value['trend_description'];
          }
        }   
        elseif ($value['trend'] == $surveyTypeData['adult']) {
          if ($value['adult']) {
              $adultDetail = $adultDetail . "\n" . $value['youthName'] . '-' . $value['trend_description'];
          }
        }  
        elseif ($value['trend'] == $surveyTypeData['selfStudy']) {
          if ($value['trend_description']) {
              $selfStudyDetail = $selfStudyDetail . "\n" . $value['youthName'] . '-' . $value['trend_description'];
          }
        }    
      }
    }

    array_push($noteTypeDetailArray, $alreadyAttendingSchoolDetail);
    array_push($noteTypeDetailArray, $alreadyWorkingDetail);
    array_push($noteTypeDetailArray, $prepareToSchoolDetail);
    array_push($noteTypeDetailArray, $prepareToWorkDetail);
    array_push($noteTypeDetailArray, $transferLaborDetail);
    array_push($noteTypeDetailArray, $transferOtherOneDetail);
    array_push($noteTypeDetailArray, $transferOtherTwoDetail);
    array_push($noteTypeDetailArray, $transferOtherThreeDetail);
    array_push($noteTypeDetailArray, $transferOtherFourDetail);
    array_push($noteTypeDetailArray, $transferOtherFiveDetail);
    array_push($noteTypeDetailArray, $noPlanDetail);
    array_push($noteTypeDetailArray, $lostContactDetail);
    array_push($noteTypeDetailArray, $militaryDetail);
    array_push($noteTypeDetailArray, $pregnancyDetail);
    array_push($noteTypeDetailArray, $immigrationDetail);
    array_push($noteTypeDetailArray, $healthDetail);
    array_push($noteTypeDetailArray, $otherDetail);
    array_push($noteTypeDetailArray, $specialEducationStudentDetail);
    array_push($noteTypeDetailArray, $trainingDetail);
    array_push($noteTypeDetailArray, $familyLaborDetail);
    array_push($noteTypeDetailArray, $deathDetail);
    array_push($noteTypeDetailArray, $adultDetail);
    array_push($noteTypeDetailArray, $selfStudyDetail);

    foreach($noteTypeDetailArray as $value) {
      if(strpos($value, "\n")){
        $noteDetail = $noteDetail . "\n" .$value;
      }
    }


    array_push($noteDetailArray, $noteDetail);
  }

  return $noteDetailArray;
}

function get_seasonal_review_table($value) {
  $valueArray = [];
  $typeArray = [];
  $typeArray['name'] = "";
  $typeArray['one'] = $typeArray['two'] = $typeArray['three'] = $typeArray['four']  
   = $typeArray['five'] = $typeArray['six'] = $typeArray['seven'] = $typeArray['eight']  
   = $typeArray['nine'] = $typeArray['ten'] = $typeArray['eleven'] = $typeArray['twelve']  
   = $typeArray['thirteen'] = $typeArray['fourteen'] = $typeArray['fifteen'] = $typeArray['sixteen']  
   = $typeArray['seventeen'] = $typeArray['eighteen'] = $typeArray['nineteen'] = 0;
  
  foreach($value as $i) {
    $typeArray['name'] = $i['name'];
    $typeArray['one'] = $i['already_working'];
    $typeArray['two'] = $i['already_attending_school'];
    $typeArray['three'] = $i['training'] + $i['transfer_labor'];
    $typeArray['four'] = $i['transfer_other_one'] + $i['transfer_other_two'] + $i['transfer_other_five'] + $i['self_study'];
    $typeArray['five'] = $i['prepare_to_school'];
    $typeArray['six'] = $i['prepare_to_work'];
    $typeArray['seven'] = $i['family_labor'];
    $typeArray['eight'] = $i['health'];
    $typeArray['nine'] = $i['no_plan'];
    $typeArray['ten'] = $i['lost_contact'];
    $typeArray['eleven'] = $i['pregnancy'] + $i['other'];
    $typeArray['twelve'] = $i['special_education_student'];
    $typeArray['thirteen'] = $i['immigration'];
    $typeArray['fourteen'] = $i['transfer_other_three'] + $i['transfer_other_four'];
    $typeArray['fifteen'] = $i['military'];
    $typeArray['sixteen'] = $i['death'];
    $typeArray['seventeen'] = $i['adult'];
    $typeArray['eighteen'] = ( $typeArray['one'] + $typeArray['two'] + $typeArray['three'] + $typeArray['four']  
      + $typeArray['five'] + $typeArray['six'] + $typeArray['seven'] + $typeArray['eight']  
      + $typeArray['nine'] + $typeArray['ten'] + $typeArray['eleven'] + $typeArray['twelve']  
      + $typeArray['thirteen'] + $typeArray['fourteen'] + $typeArray['fifteen'] + $typeArray['sixteen']  
      + $typeArray['seventeen'] );
    $typeArray['nineteen'] = $i['youthCount'];

    array_push($valueArray, $typeArray);
  }

  return $valueArray;
}


function report_one_seasonal_review_table_value($surveyTypeData, $seasonalReviews) {
  /**
   * one : 累積關懷人數
   * two : 已就學人數
   * three : 已就業人數
   * four : 參加職訓人數
   * five : 其他人數
   * six : 尚無動向或失蹤人數(包含開案學員)
   * seven : 不可抗力人數
   **/
  $surveyType = [];
  $surveyType['one'] = $surveyType['two'] = $surveyType['three'] 
    = $surveyType['four'] = $surveyType['five'] = $surveyType['six'] 
    = $surveyType['seven'] = [];

  foreach($seasonalReviews as $value) {
    if (empty($value['survey_type']) || ($value['survey_type'] >= 216 && $value['survey_type'] <= 232 && $value['survey_type'] != 225)) {
      array_push($surveyType['one'], $value);

      if ($value['trend'] == $surveyTypeData['alreadyAttendingSchool']) {
        array_push($surveyType['two'], $value);
      } elseif ($value['trend'] == $surveyTypeData['alreadyWorking']) {
        array_push($surveyType['three'], $value);
      } elseif ($value['trend'] == $surveyTypeData['prepareToSchool']) {
        array_push($surveyType['five'], $value);
      } elseif ($value['trend'] == $surveyTypeData['prepareToWork']) {
        array_push($surveyType['five'], $value);
      } elseif ($value['trend'] == $surveyTypeData['transferLabor']) {
        array_push($surveyType['five'], $value);
      } elseif ($value['trend'] == $surveyTypeData['transferOtherOne']) {
        array_push($surveyType['five'], $value);
      } elseif ($value['trend'] == $surveyTypeData['transferOtherTwo']) {
        array_push($surveyType['five'], $value);
      } elseif ($value['trend'] == $surveyTypeData['transferOtherThree']) {
        array_push($surveyType['five'], $value);
      } elseif ($value['trend'] == $surveyTypeData['transferOtherFour']) {
        array_push($surveyType['five'], $value);
      } elseif ($value['trend'] == $surveyTypeData['transferOtherFive']) {
        array_push($surveyType['five'], $value);
      } elseif ($value['trend'] == $surveyTypeData['noPlan']) {
        array_push($surveyType['six'], $value);
      } elseif ($value['trend'] == $surveyTypeData['lostContact']) {
        array_push($surveyType['six'], $value);
      } elseif ($value['trend'] == $surveyTypeData['military']) {
        array_push($surveyType['seven'], $value);
      } elseif ($value['trend'] == $surveyTypeData['pregnancy']) {
        array_push($surveyType['five'], $value);
      } elseif ($value['trend'] == $surveyTypeData['immigration']) {
        array_push($surveyType['seven'], $value);
      } elseif ($value['trend'] == $surveyTypeData['health']) {
        array_push($surveyType['five'], $value);
      } elseif ($value['trend'] == $surveyTypeData['other']) {
        array_push($surveyType['five'], $value);
      } elseif ($value['trend'] == $surveyTypeData['specialEducationStudent']) {
        array_push($surveyType['seven'], $value);
      } elseif ($value['trend'] == $surveyTypeData['training']) {
        array_push($surveyType['four'], $value);
      } elseif ($value['trend'] == $surveyTypeData['familyLabor']) {
        array_push($surveyType['five'], $value);
      } elseif ($value['trend'] == $surveyTypeData['death']) {
        array_push($surveyType['seven'], $value);
      } elseif ($value['trend'] == $surveyTypeData['adult']) {
        array_push($surveyType['seven'], $value);
      } elseif ($value['trend'] == $surveyTypeData['selfStudy']) {
        array_push($surveyType['five'], $value);
      } else ;

      if ($value['is_counseling']) {
        array_push($surveyType['six'], $value);
      }
    }
  }

  return $surveyType;
}

function report_one_month_member_temp_counseling_table_value($surveyTypeData, $monthTemps) {
  /**
   * one : 累積開案人數
   * two : 已就學人數
   * three : 已就業人數
   * four : 參加職訓人數
   * five : 其他人數
   * six : 尚無動向或失蹤人數(包含開案學員)
   * seven : 不可抗力人數
   **/
  $surveyType = [];
  $surveyType['one'] = $surveyType['two'] = $surveyType['three'] 
    = $surveyType['four'] = $surveyType['five'] = $surveyType['six'] 
    = $surveyType['seven'] = [];

  foreach($monthTemps as $value){
    array_push($surveyType['one'], $value);
    if ($value['trend'] == $surveyTypeData['schoolNumber']) {
      array_push($surveyType['two'], $value);
    } elseif ($value['trend'] == $surveyTypeData['workNumber']) {
      array_push($surveyType['three'], $value);
    } elseif ($value['trend'] == $surveyTypeData['vocationalTrainingNumber']) {
      array_push($surveyType['four'], $value);
    } elseif ($value['trend'] == $surveyTypeData['otherNumberOne']) {
      array_push($surveyType['five'], $value);
    } elseif ($value['trend'] == $surveyTypeData['otherNumberTwo']) {
      array_push($surveyType['five'], $value);
    } elseif ($value['trend'] == $surveyTypeData['otherNumberThree']) {
      array_push($surveyType['five'], $value);
    } elseif ($value['trend'] == $surveyTypeData['otherNumberFour']) {
      array_push($surveyType['five'], $value);
    } elseif ($value['trend'] == $surveyTypeData['noPlanNumber']) {
      array_push($surveyType['six'], $value);
    } elseif ($value['trend'] == $surveyTypeData['forceMajeureNumber']) {
      array_push($surveyType['seven'], $value);
    }
  }

  return $surveyType;
}

function report_one_member_source_table_value($memberData, $members) {
  /**
   * one : 本年度新開案個案人數
   * two : 前一年度持續輔導人數
   * three : 106學年度動向調查結果輔導人數
   * four : 107學年度動向調查結果輔導人數
   * five : 108學年度動向調查結果輔導人數
   * six : 109學年度動向調查結果輔導人數
   * seven : 109年度高中已錄取未註冊結果輔導人數
   **/

  $CI = get_instance();
  $CI->load->model('MemberModel');

  $surveyType = [];
  $surveyType['one'] = $surveyType['two'] = $surveyType['three'] 
    = $surveyType['four'] = $surveyType['five'] = $surveyType['six'] 
    = $surveyType['seven'] = [];

  $newCaseMember = $CI->MemberModel->get_new_case($memberData['county'], $memberData['month'], $memberData['year']);
  foreach($newCaseMember as $value) {
    if($value['year'] == (date("Y")-1911)) array_push($surveyType['one'], $value);
  }

  $oldCaseMember = $CI->MemberModel->get_old_case($memberData['county'], $memberData['month'], $memberData['year']);
  foreach($oldCaseMember as $value) {
    array_push($surveyType['two'], $value);
  }

  foreach($members as $value) {
    if($value['source_school_year'] == (date("Y")-1911-4)) {
      array_push($surveyType['three'], $value);
    } elseif($value['source_school_year'] == (date("Y")-1911-3)) {
      array_push($surveyType['four'], $value);
    } elseif($value['source_school_year'] == (date("Y")-1911-2)) {
      array_push($surveyType['five'], $value);
    } elseif($value['source_school_year'] == (date("Y")-1911-1)) {
      array_push($surveyType['six'], $value);
    } elseif($value['source'] == 229) {
      array_push($surveyType['seven'], $value);
    }
  }

  return $surveyType;
}

function get_end_case_trend_menu_no() {
  $CI = get_instance();
  $CI->load->model('MenuModel');

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

  return $trendTypeData;
}

function report_seasonal_review_table_value($surveyTypeData, $seasonalReviews, $youths) {

  $surveyType = [];
  $surveyType['name'] = "";
  $surveyType['one'] = $surveyType['two'] = $surveyType['three'] = $surveyType['four']  
   = $surveyType['five'] = $surveyType['six'] = $surveyType['seven'] = $surveyType['eight']  
   = $surveyType['nine'] = $surveyType['ten'] = $surveyType['eleven'] = $surveyType['twelve']  
   = $surveyType['thirteen'] = $surveyType['fourteen'] = $surveyType['fifteen'] = $surveyType['sixteen']  
   = $surveyType['seventeen'] = $surveyType['eighteen'] = $surveyType['nineteen'] = [];
   
  foreach($seasonalReviews as $value) {
    if ($value['trend'] == $surveyTypeData['alreadyWorking']) {
      array_push($surveyType['one'], $value);
    } elseif ($value['trend'] == $surveyTypeData['alreadyAttendingSchool']) {
      array_push($surveyType['two'], $value);
    } elseif ($value['trend'] == $surveyTypeData['training'] || $value['trend'] == $surveyTypeData['transferLabor']) {
      array_push($surveyType['three'], $value);
    } elseif ($value['trend'] == $surveyTypeData['transferOtherOne'] || $value['trend'] == $surveyTypeData['transferOtherTwo'] || $value['trend'] == $surveyTypeData['transferOtherFive'] || $value['trend'] == $surveyTypeData['selfStudy']) {
      array_push($surveyType['four'], $value);
    } elseif ($value['trend'] == $surveyTypeData['prepareToSchool']) {
      array_push($surveyType['five'], $value);
    } elseif ($value['trend'] == $surveyTypeData['prepareToWork']) {
      array_push($surveyType['six'], $value);
    } elseif ($value['trend'] == $surveyTypeData['familyLabor']) {
      array_push($surveyType['seven'], $value);
    } elseif ($value['trend'] == $surveyTypeData['health']) {
      array_push($surveyType['eight'], $value);
    } elseif ($value['trend'] == $surveyTypeData['noPlan']) {
      array_push($surveyType['nine'], $value);
    } elseif ($value['trend'] == $surveyTypeData['lostContact']) {
      array_push($surveyType['ten'], $value);
    } elseif ($value['trend'] == $surveyTypeData['pregnancy'] || $value['trend'] == $surveyTypeData['other']) {
      array_push($surveyType['eleven'], $value);
    } elseif ($value['trend'] == $surveyTypeData['specialEducationStudent']) {
      array_push($surveyType['twelve'], $value);
    } elseif ($value['trend'] == $surveyTypeData['immigration']) {
      array_push($surveyType['thirteen'], $value);
    } elseif ($value['trend'] == $surveyTypeData['transferOtherThree'] || $value['trend'] == $surveyTypeData['transferOtherFour']) {
      array_push($surveyType['fourteen'], $value);
    } elseif ($value['trend'] == $surveyTypeData['military']) {
      array_push($surveyType['fifteen'], $value);
    } elseif ($value['trend'] == $surveyTypeData['death']) {
      array_push($surveyType['sixteen'], $value);
    } elseif ($value['trend'] == $surveyTypeData['adult']) {
      array_push($surveyType['seventeen'], $value);
    } else ;

    if ($value['is_counseling']) {
      array_push($surveyType['nine'], $value);
    }

    array_push($surveyType['eighteen'], $value);
  }

  foreach($youths as $value) {
    array_push($surveyType['nineteen'], $value);
  }

  return $surveyType;
}
