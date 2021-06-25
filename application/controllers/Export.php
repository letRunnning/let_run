<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Export extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('UserModel');
    $this->load->model('YdaModel');
    $this->load->model('CountyModel');
    $this->load->model('OrganizationModel');
    $this->load->model('CourseModel');
    $this->load->model('CounselorModel');
    $this->load->model('MenuModel');
    $this->load->model('ReportModel');
    $this->load->model('CountyModel');
    $this->load->model('YouthModel');
    $this->load->model('ProjectModel');
    $this->load->model('WorkAttendanceModel');
    $this->load->model('CounselingMemberCountReportModel');
    $this->load->model('CompletionModel');
    $this->load->model('MemberModel');
    $this->load->model('InsuranceModel');
    $this->load->model('CaseAssessmentModel');
    $this->load->model('SeasonalReviewModel');
    $this->load->model('ReviewModel');
    $this->load->model('CountyContactModel');
    $this->load->model('MonthMemberTempCounselingModel');
    $this->load->model('CounselorServingMemberModel');
    $this->load->model('CounselorServingMemberUpdateModel');
    $this->load->model('UserTempModel');
    $this->load->model('TwoYearsTrendSurveyCountReportModel');
    $this->load->model('OneYearsTrendSurveyCountReportModel');
    $this->load->model('NowYearsTrendSurveyCountReportModel');
    $this->load->model('OldCaseTrendSurveyCountReportModel');
    $this->load->model('CounselorManpowerReportModel');
    $this->load->model('CounselingIdentityCountReportModel');
    $this->load->model('CounselingMeetingCountReportModel');
    $this->load->model('FundingApproveModel');
    $this->load->model('TimingReportModel');
    $this->load->library('user_agent');
  }

  public function youth_data_export($reportType = null, $year = null)
  {
      $passport = $this->session->userdata('passport');
      $current_role = $passport['role'];
      $userTitle = $passport['userTitle'];
      $accept_role = array(2, 3, 4, 5, 6);
      $countyType = $passport['county'];
      $organization = $passport['organization'];
      $counselor = $passport['counselor'];
      $id = $passport['id'];

      valid_roles($accept_role);

      $counties = $this->CountyModel->get_all();
      $countyName = "";
      foreach ($counties as $value) {
        if ($value['no'] == $countyType) {
          $countyName = $value['name'];
        }
      }

      if ($reportType = 'youthTrack') {
          
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
          $sheet = youth_data($sheet, $countyType, $year, $id, 'all');
          // $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet,'Mpdf');
          // $writer->writeAllSheets();
          // $spreadsheet->getSecurity()->setLockWindows(true);
          // $spreadsheet->getSecurity()->setLockStructure(true); 

          $sheet2 = $spreadsheet->createSheet();
          $sheet2 = youth_data($sheet2, $countyType, $year, $id, ( (date('Y')-1911-4) . '_trend'));
          $sheet2->setTitle((date('Y')-1911-4) . '動向調查');

          $sheet3 = $spreadsheet->createSheet();
          $sheet3 = youth_data($sheet3, $countyType, $year, $id, ( (date('Y')-1911-3) . '_trend'));
          $sheet3->setTitle((date('Y')-1911-3) . '動向調查');

          $sheet4 = $spreadsheet->createSheet();
          $sheet4 = youth_data($sheet4, $countyType, $year, $id, ( (date('Y')-1911-2) . '_trend'));
          $sheet4->setTitle((date('Y')-1911-2) . '動向調查');

          $sheet5 = $spreadsheet->createSheet();
          $sheet5 = youth_data($sheet5, $countyType, $year, $id, 'high');
          $sheet5->setTitle('高中已錄取未註冊');

          $sheet6 = $spreadsheet->createSheet();
          $sheet6 = youth_data($sheet6, $countyType, $year, $id, 'referral');
          $sheet6->setTitle('轉介或自行開發');

          $writer = new Xlsx($spreadsheet);
          $filename = $year . '年' . $countyName . '青少年資料.xlsx';
          //$writer->save(FCPATH . 'files/' . $year . '年' . $countyName . '青少年資料.xlsx');
          header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
          //header("Content-type:application/pdf");

          header('Content-Disposition: attachment;filename="' . $filename . '"');
          header('Cache-Control: max-age=0');

          $writer = new Xlsx($spreadsheet);
          $writer->save('php://output');

      }
  }

  public function counselor_report_export($reportType = null, $year = null)
  { 
    $passport = $this->session->userdata('passport');
    $current_role = $passport['role'];
    $userTitle = $passport['userTitle'];
    $accept_role = array(6);
    $countyType = $passport['county'];
    $organization = $passport['organization'];
    $counselor = $passport['counselor'];

    valid_roles($accept_role);

    if ($reportType == 'countyDelegateOrganization') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_countyDelegateOrganization($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年縣市計畫資訊.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'memberCounseling') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_memberCounseling($sheet, $countyType, $counselor, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年學員輔導清單.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'counselEffection') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_counselEffection($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年輔導成效統計表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'counselEffectionIndividual') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_counselEffectionIndividual($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年個別輔導時數統計表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'counselEffectionGroup') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_counselEffectionGroup($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年團體輔導時數統計表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'counselEffectionCourse') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_counselEffectionCourse($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年生涯探索課程或活動時數統計表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'counselEffectionWork') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_counselEffectionWork($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年生涯探索課程或活動時數統計表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'counselEffectionMeeting') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_counselEffectionMeeting($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年跨局處會議及預防性講座統計表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeOldCaseTrack') {        
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_surveyTypeOldCaseTrack($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年前一年度開案後動向調查追蹤表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeTwoYears') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_surveyTypeTwoYears($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = ($year - 4) . '學年度國中畢業未升學未就業青少年動向調查表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeOneYears') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_surveyTypeOneYears($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = ($year - 3) . '學年度國中畢業未升學未就業青少年動向調查表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeNowYears') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_surveyTypeNowYears($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = ($year - 2) . '學年度國中畢業未升學未就業青少年動向調查表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeHighSchoolTrack') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_surveyTypeHighSchoolTrack($sheet, $countyType, $year);      
      $writer = new Xlsx($spreadsheet);
      $filename = ($year-1) . '年度高中已錄取未註冊青少年動向調查追蹤表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeTwoYearsTrack') {          
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_surveyTypeTwoYearsTrack($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = ($year - 4) . '學年度國中畢業未升學未就業青少年動向調查追蹤表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeOneYearsTrack') {
        
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_surveyTypeOneYearsTrack($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = ($year - 3) . '學年度國中畢業未升學未就業青少年動向調查追蹤表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeNowYearsTrack') {          
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_surveyTypeNowYearsTrack($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = ($year - 2) . '學年度國中畢業未升學未就業青少年動向調查追蹤表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'all') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_countyDelegateOrganization($sheet, $countyType, $year);

      $sheet2 = $spreadsheet->createSheet();
      $sheet2 = counselor_report_memberCounseling($sheet2, $countyType, $counselor, $year);
    
      $sheet3 = $spreadsheet->createSheet();
      $sheet3 = counselor_report_counselEffection($sheet3, $countyType, $year);
    
      $sheet4 = $spreadsheet->createSheet();
      $sheet4 = counselor_report_counselEffectionIndividual($sheet4, $countyType, $year);

      $sheet5 = $spreadsheet->createSheet();
      $sheet5 = counselor_report_counselEffectionGroup($sheet5, $countyType, $year);
      
      $sheet6 = $spreadsheet->createSheet();
      $sheet6 = counselor_report_counselEffectionCourse($sheet6, $countyType, $year);
  
      $sheet7 = $spreadsheet->createSheet();
      $sheet7 = counselor_report_counselEffectionWork($sheet7, $countyType, $year);
  
      $sheet8 = $spreadsheet->createSheet();
      $sheet8 = counselor_report_counselEffectionMeeting($sheet8, $countyType, $year);
     
      $sheet9 = $spreadsheet->createSheet();
      $sheet9 = counselor_report_surveyTypeOldCaseTrack($sheet9, $countyType, $year);
     
      $sheet10 = $spreadsheet->createSheet();
      $sheet10 = counselor_report_surveyTypeTwoYears($sheet10, $countyType, $year);

      $sheet11 = $spreadsheet->createSheet();
      $sheet11 = counselor_report_surveyTypeOneYears($sheet11, $countyType, $year);

      $sheet12 = $spreadsheet->createSheet();
      $sheet12 = counselor_report_surveyTypeNowYears($sheet12, $countyType, $year);
  
      $sheet13 = $spreadsheet->createSheet();
      $sheet13 = counselor_report_surveyTypeHighSchoolTrack($sheet13, $countyType, $year);  

      $sheet14 = $spreadsheet->createSheet();
      $sheet14 = counselor_report_surveyTypeTwoYearsTrack($sheet14, $countyType, $year);
     
      $sheet15 = $spreadsheet->createSheet();
      $sheet15 = counselor_report_surveyTypeOneYearsTrack($sheet15, $countyType, $year);
  
      $sheet16 = $spreadsheet->createSheet();
      $sheet16 = counselor_report_surveyTypeNowYearsTrack($sheet16, $countyType, $year);

      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年輔導員報表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }
  }

  public function organization_report_export($reportType = null, $year = null)
  {
    $passport = $this->session->userdata('passport');
    $current_role = $passport['role'];
    $userTitle = $passport['userTitle'];
    $accept_role = array(4, 5);
    $countyType = $passport['county'];
    $organization = $passport['organization'];

    valid_roles($accept_role);

    if ($reportType == 'countyDelegateOrganization') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_countyDelegateOrganization($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年縣市計畫資訊.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'memberCounseling') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_memberCounseling($sheet, $countyType, $counselor, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年學員輔導清單.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'counselEffection') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_counselEffection($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年輔導成效統計表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'counselEffectionIndividual') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_counselEffectionIndividual($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年個別輔導時數統計表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'counselEffectionGroup') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_counselEffectionGroup($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年團體輔導時數統計表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'counselEffectionCourse') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_counselEffectionCourse($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年生涯探索課程或活動時數統計表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'counselEffectionWork') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_counselEffectionWork($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年生涯探索課程或活動時數統計表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'counselEffectionMeeting') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_counselEffectionMeeting($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年跨局處會議及預防性講座統計表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeOldCaseTrack') {        
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_surveyTypeOldCaseTrack($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年前一年度開案後動向調查追蹤表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeTwoYears') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_surveyTypeTwoYears($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = ($year - 4) . '學年度國中畢業未升學未就業青少年動向調查表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeOneYears') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_surveyTypeOneYears($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = ($year - 3) . '學年度國中畢業未升學未就業青少年動向調查表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeNowYears') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_surveyTypeNowYears($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = ($year - 2) . '學年度國中畢業未升學未就業青少年動向調查表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeHighSchoolTrack') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_surveyTypeHighSchoolTrack($sheet, $countyType, $year);      
      $writer = new Xlsx($spreadsheet);
      $filename = ($year-1) . '年度高中已錄取未註冊青少年動向調查追蹤表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeTwoYearsTrack') {          
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_surveyTypeTwoYearsTrack($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = ($year - 4) . '學年度國中畢業未升學未就業青少年動向調查追蹤表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeOneYearsTrack') {
        
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_surveyTypeOneYearsTrack($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = ($year - 3) . '學年度國中畢業未升學未就業青少年動向調查追蹤表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeNowYearsTrack') {          
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_surveyTypeNowYearsTrack($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = ($year - 2) . '學年度國中畢業未升學未就業青少年動向調查追蹤表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'all') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_countyDelegateOrganization($sheet, $countyType, $year);

      // $sheet2 = $spreadsheet->createSheet();
      // $sheet2 = counselor_report_memberCounseling($sheet2, $countyType, $counselor, $year);
    
      $sheet3 = $spreadsheet->createSheet();
      $sheet3 = counselor_report_counselEffection($sheet3, $countyType, $year);
    
      $sheet4 = $spreadsheet->createSheet();
      $sheet4 = counselor_report_counselEffectionIndividual($sheet4, $countyType, $year);

      $sheet5 = $spreadsheet->createSheet();
      $sheet5 = counselor_report_counselEffectionGroup($sheet5, $countyType, $year);
      
      $sheet6 = $spreadsheet->createSheet();
      $sheet6 = counselor_report_counselEffectionCourse($sheet6, $countyType, $year);
  
      $sheet7 = $spreadsheet->createSheet();
      $sheet7 = counselor_report_counselEffectionWork($sheet7, $countyType, $year);
  
      $sheet8 = $spreadsheet->createSheet();
      $sheet8 = counselor_report_counselEffectionMeeting($sheet8, $countyType, $year);
     
      $sheet9 = $spreadsheet->createSheet();
      $sheet9 = counselor_report_surveyTypeOldCaseTrack($sheet9, $countyType, $year);
     
      $sheet10 = $spreadsheet->createSheet();
      $sheet10 = counselor_report_surveyTypeTwoYears($sheet10, $countyType, $year);

      $sheet11 = $spreadsheet->createSheet();
      $sheet11 = counselor_report_surveyTypeOneYears($sheet11, $countyType, $year);

      $sheet12 = $spreadsheet->createSheet();
      $sheet12 = counselor_report_surveyTypeNowYears($sheet12, $countyType, $year);
  
      $sheet13 = $spreadsheet->createSheet();
      $sheet13 = counselor_report_surveyTypeHighSchoolTrack($sheet13, $countyType, $year);  

      $sheet14 = $spreadsheet->createSheet();
      $sheet14 = counselor_report_surveyTypeTwoYearsTrack($sheet14, $countyType, $year);
     
      $sheet15 = $spreadsheet->createSheet();
      $sheet15 = counselor_report_surveyTypeOneYearsTrack($sheet15, $countyType, $year);
  
      $sheet16 = $spreadsheet->createSheet();
      $sheet16 = counselor_report_surveyTypeNowYearsTrack($sheet16, $countyType, $year);

      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年機構報表.xlsx';
      //$writer->save(FCPATH . 'files/' . ($year) . '年機構報表.xlsx');
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');

      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');

    }

  }

  public function county_report_export($reportType = null, $year = null)
  {
    $passport = $this->session->userdata('passport');
    $current_role = $passport['role'];
    $userTitle = $passport['userTitle'];
    $accept_role = array(2, 3);
    $countyType = $passport['county'];

    valid_roles($accept_role);

    if ($reportType == 'countyDelegateOrganization') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_countyDelegateOrganization($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年縣市計畫資訊.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'memberCounseling') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_memberCounseling($sheet, $countyType, $counselor, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年學員輔導清單.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'counselEffection') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_counselEffection($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年輔導成效統計表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'counselEffectionIndividual') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_counselEffectionIndividual($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年個別輔導時數統計表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'counselEffectionGroup') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_counselEffectionGroup($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年團體輔導時數統計表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'counselEffectionCourse') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_counselEffectionCourse($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年生涯探索課程或活動時數統計表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'counselEffectionWork') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_counselEffectionWork($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年生涯探索課程或活動時數統計表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'counselEffectionMeeting') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_counselEffectionMeeting($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年跨局處會議及預防性講座統計表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeOldCaseTrack') {        
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_surveyTypeOldCaseTrack($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年前一年度開案後動向調查追蹤表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeTwoYears') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_surveyTypeTwoYears($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = ($year - 4) . '學年度國中畢業未升學未就業青少年動向調查表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeOneYears') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_surveyTypeOneYears($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = ($year - 3) . '學年度國中畢業未升學未就業青少年動向調查表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeNowYears') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_surveyTypeNowYears($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = ($year - 2) . '學年度國中畢業未升學未就業青少年動向調查表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeHighSchoolTrack') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_surveyTypeHighSchoolTrack($sheet, $countyType, $year);      
      $writer = new Xlsx($spreadsheet);
      $filename = ($year-1) . '年度高中已錄取未註冊青少年動向調查追蹤表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeTwoYearsTrack') {          
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_surveyTypeTwoYearsTrack($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = ($year - 4) . '學年度國中畢業未升學未就業青少年動向調查追蹤表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeOneYearsTrack') {
        
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_surveyTypeOneYearsTrack($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = ($year - 3) . '學年度國中畢業未升學未就業青少年動向調查追蹤表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeNowYearsTrack') {          
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_surveyTypeNowYearsTrack($sheet, $countyType, $year);
      $writer = new Xlsx($spreadsheet);
      $filename = ($year - 2) . '學年度國中畢業未升學未就業青少年動向調查追蹤表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'all') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = counselor_report_countyDelegateOrganization($sheet, $countyType, $year);

      // $sheet2 = $spreadsheet->createSheet();
      // $sheet2 = counselor_report_memberCounseling($sheet2, $countyType, $counselor, $year);
    
      $sheet3 = $spreadsheet->createSheet();
      $sheet3 = counselor_report_counselEffection($sheet3, $countyType, $year);
    
      $sheet4 = $spreadsheet->createSheet();
      $sheet4 = counselor_report_counselEffectionIndividual($sheet4, $countyType, $year);

      $sheet5 = $spreadsheet->createSheet();
      $sheet5 = counselor_report_counselEffectionGroup($sheet5, $countyType, $year);
      
      $sheet6 = $spreadsheet->createSheet();
      $sheet6 = counselor_report_counselEffectionCourse($sheet6, $countyType, $year);
  
      $sheet7 = $spreadsheet->createSheet();
      $sheet7 = counselor_report_counselEffectionWork($sheet7, $countyType, $year);
  
      $sheet8 = $spreadsheet->createSheet();
      $sheet8 = counselor_report_counselEffectionMeeting($sheet8, $countyType, $year);
     
      $sheet9 = $spreadsheet->createSheet();
      $sheet9 = counselor_report_surveyTypeOldCaseTrack($sheet9, $countyType, $year);
     
      $sheet10 = $spreadsheet->createSheet();
      $sheet10 = counselor_report_surveyTypeTwoYears($sheet10, $countyType, $year);

      $sheet11 = $spreadsheet->createSheet();
      $sheet11 = counselor_report_surveyTypeOneYears($sheet11, $countyType, $year);

      $sheet12 = $spreadsheet->createSheet();
      $sheet12 = counselor_report_surveyTypeNowYears($sheet12, $countyType, $year);
  
      $sheet13 = $spreadsheet->createSheet();
      $sheet13 = counselor_report_surveyTypeHighSchoolTrack($sheet13, $countyType, $year);  

      $sheet14 = $spreadsheet->createSheet();
      $sheet14 = counselor_report_surveyTypeTwoYearsTrack($sheet14, $countyType, $year);
     
      $sheet15 = $spreadsheet->createSheet();
      $sheet15 = counselor_report_surveyTypeOneYearsTrack($sheet15, $countyType, $year);
  
      $sheet16 = $spreadsheet->createSheet();
      $sheet16 = counselor_report_surveyTypeNowYearsTrack($sheet16, $countyType, $year);

      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年縣市報表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

  }

  public function yda_report_export($reportType = null, $year = null, $month = null)
  {
    $passport = $this->session->userdata('passport');
    $current_role = $passport['role'];
    $userTitle = $passport['userTitle'];
    $accept_role = array(1, 8, 9);
    $countyType = 'all';
    $counties = $this->CountyModel->get_all();  

    valid_roles($accept_role);

    if ($reportType == 'countyDelegateOrganization') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = yda_report_countyDelegateOrganization($sheet, $countyType, $year);

      $s_num = 0;
      foreach ($counties as $value) {
        $s_num += 1;
        $sheetname = 'sheet' . $s_num;
        $sheetname = $spreadsheet->createSheet();
        $sheetname = counselor_report_countyDelegateOrganization($sheetname,  $value['no'], $year);
        $sheetname->setTitle($value['name']);
      }

      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年縣市計畫資訊.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'counselEffection') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = yda_report_counselEffection($sheet, $countyType, $year);

      $s_num = 0;
      foreach ($counties as $value) {
        $s_num += 1;
        $sheetname = 'sheet' . $s_num;
        $sheetname = $spreadsheet->createSheet();
        $sheetname = counselor_report_counselEffection($sheetname,  $value['no'], $year);
        $sheetname->setTitle($value['name']);
      }

      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年輔導成效統計表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'counselEffectionIndividual') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = yda_report_counselEffectionIndividual($sheet, $countyType, $year);

      $s_num = 0;
      foreach ($counties as $value) {
        $s_num += 1;
        $sheetname = 'sheet' . $s_num;
        $sheetname = $spreadsheet->createSheet();
        $sheetname = counselor_report_counselEffectionIndividual($sheetname,  $value['no'], $year);
        $sheetname->setTitle($value['name']);
      }

      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年個別輔導時數統計表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');         
    }

    if ($reportType == 'counselEffectionGroup') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = yda_report_counselEffectionGroup($sheet, $countyType, $year);

      $s_num = 0;
      foreach ($counties as $value) {
        $s_num += 1;
        $sheetname = 'sheet' . $s_num;
        $sheetname = $spreadsheet->createSheet();
        $sheetname = counselor_report_counselEffectionGroup($sheetname,  $value['no'], $year);
        $sheetname->setTitle($value['name']);
      }

      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年團體輔導時數統計表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'counselEffectionCourse') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = yda_report_counselEffectionCourse($sheet, $countyType, $year);

      $s_num = 0;
      foreach ($counties as $value) {
        $s_num += 1;
        $sheetname = 'sheet' . $s_num;
        $sheetname = $spreadsheet->createSheet();
        $sheetname = counselor_report_counselEffectionCourse($sheetname,  $value['no'], $year);
        $sheetname->setTitle($value['name']);
      }

      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年生涯探索課程或活動時數統計表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'counselEffectionWork') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = yda_report_counselEffectionWork($sheet, $countyType, $year);

      $s_num = 0;
      foreach ($counties as $value) {
        $s_num += 1;
        $sheetname = 'sheet' . $s_num;
        $sheetname = $spreadsheet->createSheet();
        $sheetname = counselor_report_counselEffectionWork($sheetname,  $value['no'], $year);
        $sheetname->setTitle($value['name']);
      }

      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年工作體驗時數統計表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'counselEffectionMeeting') {     
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = yda_report_counselEffectionMeeting($sheet, $countyType, $year);

      $s_num = 0;
      foreach ($counties as $value) {
        $s_num += 1;
        $sheetname = 'sheet' . $s_num;
        $sheetname = $spreadsheet->createSheet();
        $sheetname = counselor_report_counselEffectionMeeting($sheetname,  $value['no'], $year);
        $sheetname->setTitle($value['name']);
      }

      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年跨局處會議及預防性講座統計表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeOldCaseTrack') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = yda_report_surveyTypeOldCaseTrack($sheet, $countyType, $year);

      $s_num = 0;
      foreach ($counties as $value) {
        $s_num += 1;
        $sheetname = 'sheet' . $s_num;
        $sheetname = $spreadsheet->createSheet();
        $sheetname = counselor_report_surveyTypeOldCaseTrack($sheetname,  $value['no'], $year);
        $sheetname->setTitle($value['name']);
      }

      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年前一年度開案後動向調查追蹤表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeTwoYears') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = yda_report_surveyTypeTwoYears($sheet, $countyType, $year);

      $s_num = 0;
      foreach ($counties as $value) {
        $s_num += 1;
        $sheetname = 'sheet' . $s_num;
        $sheetname = $spreadsheet->createSheet();
        $sheetname = counselor_report_surveyTypeTwoYears($sheetname,  $value['no'], $year);
        $sheetname->setTitle($value['name']);
      }

      $writer = new Xlsx($spreadsheet);
      $filename = ($year - 4) . '學年度國中畢業未升學未就業青少年動向調查表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeOneYears') {   
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = yda_report_surveyTypeOneYears($sheet, $countyType, $year);

      $s_num = 0;
      foreach ($counties as $value) {
        $s_num += 1;
        $sheetname = 'sheet' . $s_num;
        $sheetname = $spreadsheet->createSheet();
        $sheetname = counselor_report_surveyTypeOneYears($sheetname,  $value['no'], $year);
        $sheetname->setTitle($value['name']);
      }

      $writer = new Xlsx($spreadsheet);
      $filename = ($year - 3) . '學年度國中畢業未升學未就業青少年動向調查表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeNowYears') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = yda_report_surveyTypeNowYears($sheet, $countyType, $year);

      $s_num = 0;
      foreach ($counties as $value) {
        $s_num += 1;
        $sheetname = 'sheet' . $s_num;
        $sheetname = $spreadsheet->createSheet();
        $sheetname = counselor_report_surveyTypeNowYears($sheetname,  $value['no'], $year);
        $sheetname->setTitle($value['name']);
      }

      $writer = new Xlsx($spreadsheet);
      $filename = ($year - 2) . '學年度國中畢業未升學未就業青少年動向調查表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeHighSchoolTrack') {        
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = yda_report_surveyTypeHighSchoolTrack($sheet, $countyType, $year);

      $s_num = 0;
      foreach ($counties as $value) {
        $s_num += 1;
        $sheetname = 'sheet' . $s_num;
        $sheetname = $spreadsheet->createSheet();
        $sheetname = counselor_report_surveyTypeHighSchoolTrack($sheetname,  $value['no'], $year);
        $sheetname->setTitle($value['name']);
      }

      $writer = new Xlsx($spreadsheet);
      $filename = ($year - 1) . '年度高中已錄取未註冊青少年動向調查追蹤表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');

      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeTwoYearsTrack') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = yda_report_surveyTypeTwoYearsTrack($sheet, $countyType, $year);

      $s_num = 0;
      foreach ($counties as $value) {
        $s_num += 1;
        $sheetname = 'sheet' . $s_num;
        $sheetname = $spreadsheet->createSheet();
        $sheetname = counselor_report_surveyTypeTwoYearsTrack($sheetname,  $value['no'], $year);
        $sheetname->setTitle($value['name']);
      }

      $writer = new Xlsx($spreadsheet);
      $filename = ($year - 4) . '學年度國中畢業未升學未就業青少年動向調查追蹤表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');

      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeOneYearsTrack') {    
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = yda_report_surveyTypeOneYearsTrack($sheet, $countyType, $year);

      $s_num = 0;
      foreach ($counties as $value) {
        $s_num += 1;
        $sheetname = 'sheet' . $s_num;
        $sheetname = $spreadsheet->createSheet();
        $sheetname = counselor_report_surveyTypeOneYearsTrack($sheetname,  $value['no'], $year);
        $sheetname->setTitle($value['name']);
      }

      $writer = new Xlsx($spreadsheet);
      $filename = ($year - 3) . '學年度國中畢業未升學未就業青少年動向調查追蹤表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeNowYearsTrack') {     
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = yda_report_surveyTypeNowYearsTrack($sheet, $countyType, $year);

      $s_num = 0;
      foreach ($counties as $value) {
        $s_num += 1;
        $sheetname = 'sheet' . $s_num;
        $sheetname = $spreadsheet->createSheet();
        $sheetname = counselor_report_surveyTypeNowYearsTrack($sheetname,  $value['no'], $year);
        $sheetname->setTitle($value['name']);
      }

      $writer = new Xlsx($spreadsheet);
      $filename = ($year - 2) . '學年度國中畢業未升學未就業青少年動向調查追蹤表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'all') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = yda_report_countyDelegateOrganization($sheet, $countyType, $year);

      // $sheet2 = $spreadsheet->createSheet();
      // $sheet2 = yda_report_memberCounseling($sheet2, $countyType, $counselor, $year);

      $sheet3 = $spreadsheet->createSheet();
      $sheet3 = yda_report_counselEffection($sheet3, $countyType, $year);
    
      $sheet4 = $spreadsheet->createSheet();
      $sheet4 = yda_report_counselEffectionIndividual($sheet4, $countyType, $year);

      $sheet5 = $spreadsheet->createSheet();
      $sheet5 = yda_report_counselEffectionGroup($sheet5, $countyType, $year);
      
      $sheet6 = $spreadsheet->createSheet();
      $sheet6 = yda_report_counselEffectionCourse($sheet6, $countyType, $year);
  
      $sheet7 = $spreadsheet->createSheet();
      $sheet7 = yda_report_counselEffectionWork($sheet7, $countyType, $year);
  
      $sheet8 = $spreadsheet->createSheet();
      $sheet8 = yda_report_counselEffectionMeeting($sheet8, $countyType, $year);
     
      $sheet9 = $spreadsheet->createSheet();
      $sheet9 = yda_report_surveyTypeOldCaseTrack($sheet9, $countyType, $year);
     
      $sheet10 = $spreadsheet->createSheet();
      $sheet10 = yda_report_surveyTypeTwoYears($sheet10, $countyType, $year);

      $sheet11 = $spreadsheet->createSheet();
      $sheet11 = yda_report_surveyTypeOneYears($sheet11, $countyType, $year);

      $sheet12 = $spreadsheet->createSheet();
      $sheet12 = yda_report_surveyTypeNowYears($sheet12, $countyType, $year);
  
      $sheet13 = $spreadsheet->createSheet();
      $sheet13 = yda_report_surveyTypeHighSchoolTrack($sheet13, $countyType, $year);  

      $sheet14 = $spreadsheet->createSheet();
      $sheet14 = yda_report_surveyTypeTwoYearsTrack($sheet14, $countyType, $year);
     
      $sheet15 = $spreadsheet->createSheet();
      $sheet15 = yda_report_surveyTypeOneYearsTrack($sheet15, $countyType, $year);
  
      $sheet16 = $spreadsheet->createSheet();
      $sheet16 = yda_report_surveyTypeNowYearsTrack($sheet16, $countyType, $year);

      $writer = new Xlsx($spreadsheet);
      $filename = $year . '年青年署報表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

  }

  public function organization_month_report_export($reportType = null, $yearType = null, $monthType = null)
  {
    $passport = $this->session->userdata('passport');
    $current_role = $passport['role'];
    $userTitle = $passport['userTitle'];
    $accept_role = array(2, 3, 4, 5);
    $county = $passport['county'];
    $organization = $passport['organization'];
    $counties = $this->CountyModel->get_all();
    $countyName = "";
    foreach ($counties as $value) {
      if ($value['no'] == $county) {
        $countyName = $value['name'];
      }
    }

    valid_roles($accept_role);

    if ($reportType == 'counselingExecuteReport') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = county_month_counselingExecuteReport($sheet, $yearType, $monthType, $county);
      $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

      // $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
      // $drawing->setName('PhpSpreadsheet logo');
      // $drawing->setPath(FCPATH . 'images/yda_logo.png');
      // $drawing->setCoordinates('F5');
      // $drawing->getShadow()->setVisible(true);
      // $drawing->setWorksheet($sheet);
      $writer = new Xlsx($spreadsheet);
      $filename = $yearType . '年' . $monthType . '月' . $countyName . '-執行進度表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');        
    }

    if ($reportType == 'counselingMemberCountReport') {         
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = county_month_counselingMemberCountReport($sheet, $yearType, $monthType, $county);
      $sheet->getPageSetup()->setFitToPage(TRUE)->setFitToWidth(1)->setFitToHeight(0)->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
      $writer = new Xlsx($spreadsheet);
      $filename = $yearType . '年' . $monthType . '月' . $countyName . '-輔導人數統計表.xlsx';
      //$writer->save(FCPATH . 'files/' . $yearType . '年' . $countyName . '輔導人數統計表.xlsx');
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'counselorManpowerReport') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = county_month_counselorManpowerReport($sheet, $yearType, $monthType, $county);
      $sheet->getPageSetup()->setFitToPage(TRUE)->setFitToWidth(1)->setFitToHeight(0)->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
      $writer = new Xlsx($spreadsheet);
      $filename = $yearType . '年' . $monthType . '月' . $countyName . '-輔導人力概況表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'CounselingIdentityCountReport') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = county_month_CounselingIdentityCountReport($sheet, $yearType, $monthType, $county);
      $sheet->getPageSetup()->setFitToPage(TRUE)->setFitToWidth(1)->setFitToHeight(0)->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
      $writer = new Xlsx($spreadsheet);
      $filename = $yearType . '年' . $monthType . '月' . $countyName . '-輔導對象身分統計表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'CounselingMeetingCountRepor') {    
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = county_month_CounselingMeetingCountRepor($sheet, $yearType, $monthType, $county);
      $sheet->getPageSetup()->setFitToPage(TRUE)->setFitToWidth(1)->setFitToHeight(0)->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
      $writer = new Xlsx($spreadsheet);
      $filename = $yearType . '年' . $monthType . '月' . $countyName . '-辦理會議或講座統計表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'TwoYearsTrendSurveyCountReport') {        
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = county_month_TwoYearsTrendSurveyCountReport($sheet, $yearType, $monthType, $county);
      $sheet->getPageSetup()->setFitToPage(TRUE)->setFitToWidth(1)->setFitToHeight(0)->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
      $writer = new Xlsx($spreadsheet);
      $filename = ($yearType - 4) . '學年度國中畢業未升學未就業青少年動向調查結果後續追蹤表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'OneYearsTrendSurveyCountReport') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = county_month_OneYearsTrendSurveyCountReport($sheet, $yearType, $monthType, $county);
      $sheet->getPageSetup()->setFitToPage(TRUE)->setFitToWidth(1)->setFitToHeight(0)->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
      $writer = new Xlsx($spreadsheet);
      $filename = ($yearType - 3) . '學年度國中畢業未升學未就業青少年動向調查結果後續追蹤表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'NowYearsTrendSurveyCountReport') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = county_month_NowYearsTrendSurveyCountReport($sheet, $yearType, $monthType, $county);
      $sheet->getPageSetup()->setFitToPage(TRUE)->setFitToWidth(1)->setFitToHeight(0)->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
      $writer = new Xlsx($spreadsheet);
      $filename = ($yearType - 2) . '學年度國中畢業未升學未就業青少年動向調查結果後續追蹤表.xlsx';
      //$writer->save(FCPATH . 'files/' . ($yearType - 2) . '學年度國中畢業未升學未就業青少年動向調查結果後續追蹤表.xlsx');
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'OldCaseTrendSurveyCountReport') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = county_month_OldCaseTrendSurveyCountReport($sheet, $yearType, $monthType, $county);
      $sheet->getPageSetup()->setFitToPage(TRUE)->setFitToWidth(1)->setFitToHeight(0)->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
      $writer = new Xlsx($spreadsheet);
      $filename = ($countyName) . '前一年開案動向調查追蹤.xlsx';
      //$writer->save(FCPATH . 'files/' . ($countyName) . '前一年開案動向調查追蹤.xlsx');
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'HighSchoolTrendSurveyCountReport') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = county_month_HighSchoolTrendSurveyCountReport($sheet, $yearType, $monthType, $county);
      $sheet->getPageSetup()->setFitToPage(TRUE)->setFitToWidth(1)->setFitToHeight(0)->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
      $writer = new Xlsx($spreadsheet);
      $filename = ($countyName) . '高中已錄取未註冊動向調查追蹤.xlsx';
      //$writer->save(FCPATH . 'files/' . ($countyName) . '前一年開案動向調查追蹤.xlsx');
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'all') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = county_month_counselingMemberCountReport($sheet, $yearType, $monthType, $county);

      $sheet3 = $spreadsheet->createSheet();
      $sheet3 = county_month_CounselingIdentityCountReport($sheet3, $yearType, $monthType, $county);
    
      $sheet4 = $spreadsheet->createSheet();
      $sheet4 = county_month_CounselingMeetingCountRepor($sheet4, $yearType, $monthType, $county);

      $sheet5 = $spreadsheet->createSheet();
      $sheet5 = county_month_counselorManpowerReport($sheet5, $yearType, $monthType, $county);

      if ($monthType % 3 == 0) {
        $sheet6 = $spreadsheet->createSheet();
        $sheet6 = county_month_TwoYearsTrendSurveyCountReport($sheet6, $yearType, $monthType, $county);

        $sheet7 = $spreadsheet->createSheet();
        $sheet7 = county_month_OneYearsTrendSurveyCountReport($sheet7, $yearType, $monthType, $county);

        $sheet8 = $spreadsheet->createSheet();
        $sheet8 = county_month_NowYearsTrendSurveyCountReport($sheet8, $yearType, $monthType, $county);
   
        $sheet9 = $spreadsheet->createSheet();
        $sheet9 = county_month_OldCaseTrendSurveyCountReport($sheet9, $yearType, $monthType, $county);

        $sheet10 = $spreadsheet->createSheet();
        $sheet10 = county_month_HighSchoolTrendSurveyCountReport($sheet10, $yearType, $monthType, $county);
      }
     
      $writer = new Xlsx($spreadsheet);
      $filename = $yearType . '年' . $monthType . '月' . $countyName .'彙整總表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }
  }

  public function yda_month_report_export($reportType = null, $yearType = null, $monthType = null)
  {
    $passport = $this->session->userdata('passport');
    $current_role = $passport['role'];
    $userTitle = $passport['userTitle'];
    $accept_role = array(1, 8, 9);
    $countyType = 'all';

    valid_roles($accept_role);

    if ($reportType == 'counselingExecuteReport') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = yda_month_counselingExecuteReport($sheet, $yearType, $monthType);
      $writer = new Xlsx($spreadsheet);
      $filename = $yearType . '年' . $monthType . '月' . '-執行進度表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'counselingMemberCountReport') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = yda_month_counselingMemberCountReport($sheet, $yearType, $monthType);
      $writer = new Xlsx($spreadsheet);
      //$writer->save(FCPATH . 'files/' . '青少年資料.xlsx');
      $filename = $yearType . '年' . $monthType . '月' . '-輔導人數統計表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'CounselingIdentityCountReport') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = yda_month_CounselingIdentityCountReport($sheet, $yearType, $monthType);
      $writer = new Xlsx($spreadsheet);
      $filename = $yearType . '年' . $monthType . '月' . '-輔導對象身分統計表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'CounselingMeetingCountReport') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = yda_month_CounselingMeetingCountRepor($sheet, $yearType, $monthType);
      $writer = new Xlsx($spreadsheet);
      $filename = $yearType . '年' . $monthType . '月' . '-辦理會議或講座統計表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'counselorManpowerCountReport') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = yda_month_counselorManpowerReport($sheet, $yearType, $monthType);
      $writer = new Xlsx($spreadsheet);
      $filename = $yearType . '年' . $monthType . '月' . '-輔導人力統計表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'fundingExecuteReport') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = yda_month_fundingExecuteReport($sheet, $yearType, $monthType);
      $writer = new Xlsx($spreadsheet);
      $filename = ($yearType) . '年' . $monthType . '月經費執行情形表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeTwoYearsTrack') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = yda_month_TwoYearsTrendSurveyCountReport($sheet, $yearType, $monthType);
      $writer = new Xlsx($spreadsheet);
      $filename = $yearType . '年' . $monthType . '月' . '-' . ($yearType - 4) . '學年度動向調查追蹤表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeOneYearsTrack') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = yda_month_OneYearsTrendSurveyCountReport($sheet, $yearType, $monthType);
      $writer = new Xlsx($spreadsheet);
      $filename = $yearType . '年' . $monthType . '月' . '-' . ($yearType - 3) . '學年度動向調查追蹤表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeNowYearsTrack') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = yda_month_NowYearsTrendSurveyCountReport($sheet, $yearType, $monthType);
      $writer = new Xlsx($spreadsheet);
      $filename = $yearType . '年' . $monthType . '月' . '-' . ($yearType - 2) . '學年度動向調查追蹤表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeOldCaseTrack') { 
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = yda_month_OldCaseTrendSurveyCountReport($sheet, $yearType, $monthType);
      $writer = new Xlsx($spreadsheet);
      $filename = $yearType . '年' . $monthType . '月' . '-' . '前一年結案後動向調查追蹤表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'surveyTypeHighSchoolTrack') { 
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = yda_month_HighSchoolTrendSurveyCountReport($sheet, $yearType, $monthType);
      $writer = new Xlsx($spreadsheet);
      $filename = $yearType . '年' . $monthType . '月' . '-' . '高中已錄取未註冊動向調查追蹤表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'timingReport') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = yda_month_timingReport($sheet, $yearType, $monthType);
      $writer = new Xlsx($spreadsheet);
      $filename = $yearType . '年' . $monthType . '月' . '-' . '回傳情形紀錄表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

    if ($reportType == 'all') {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet = yda_month_counselingMemberCountReport($sheet, $yearType, $monthType);

      $sheet3 = $spreadsheet->createSheet();
      $sheet3 = yda_month_CounselingIdentityCountReport($sheet3, $yearType, $monthType);
    
      $sheet4 = $spreadsheet->createSheet();
      $sheet4 = yda_month_CounselingMeetingCountRepor($sheet4, $yearType, $monthType);

      $sheet5 = $spreadsheet->createSheet();
      $sheet5 = yda_month_counselorManpowerReport($sheet5, $yearType, $monthType);

      $sheet6 = $spreadsheet->createSheet();
      $sheet6 = yda_month_timingReport($sheet6, $yearType, $monthType);

      $sheet7 = $spreadsheet->createSheet();
      $sheet7 = yda_month_fundingExecuteReport($sheet7, $yearType, $monthType);

      if ($monthType % 3 == 0) {
        $sheet8 = $spreadsheet->createSheet();
        $sheet8 = yda_month_TwoYearsTrendSurveyCountReport($sheet8, $yearType, $monthType);

        $sheet9 = $spreadsheet->createSheet();
        $sheet9 = yda_month_OneYearsTrendSurveyCountReport($sheet9, $yearType, $monthType);

        $sheet10= $spreadsheet->createSheet();
        $sheet10 = yda_month_NowYearsTrendSurveyCountReport($sheet10, $yearType, $monthType);
   
        $sheet11 = $spreadsheet->createSheet();
        $sheet11 = yda_month_OldCaseTrendSurveyCountReport($sheet11, $yearType, $monthType);

        $sheet12 = $spreadsheet->createSheet();
        $sheet12 = yda_month_HighSchoolTrendSurveyCountReport($sheet12, $yearType, $monthType);
      }
     
      $writer = new Xlsx($spreadsheet);
      $filename = $yearType . '年' . $monthType . '月' .'彙整總表.xlsx';
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');
    }

  }

}
