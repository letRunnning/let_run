<?php
class Report extends CI_Controller
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
      $this->load->model('MonthReviewModel');
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
      $this->load->model('HighSchoolTrendSurveyCountReportModel');
      $this->load->model('CounselorManpowerReportModel');
      $this->load->model('CounselingIdentityCountReportModel');
      $this->load->model('CounselingMeetingCountReportModel');
      $this->load->model('ReviewProcessModel');
      $this->load->model('ReviewLogModel');
      $this->load->model('FundingApproveModel');
      $this->load->model('TimingReportModel');
      $this->load->model('FileModel');

      $this->load->helper('report');
    }

    public function verify_table($yearType = null, $monthType = null, $type = null, $trend = null) {
      $passport = $this->session->userdata('passport');
      $current_role = $passport['role'];
      $userTitle = $passport['userTitle'];
      $userId = $passport['id'];
      $accept_role = array(6);

      valid_roles($accept_role);

      $county = $passport['county'];
      $organization = $passport['organization'];

      $yearType = $yearType ? $yearType : date("Y") - 1911;
      $monthType = $monthType ? $monthType : date("m");

      $trends = $this->MenuModel->get_by_form_and_column_order('seasonal_review', 'trend');
      $endCaseTrends = $this->MenuModel->get_by_form_and_column('end_case', 'trend');

      $beSentDataset = array(
        'title' => '確認表格',
        'url' => '/report/verify_table/' . $yearType . '/' . $monthType . '/' . $type,
        'role' => $current_role,
        'county' => $county,
        'userTitle' => $userTitle,
        'yearType' => $yearType,
        'monthType' => $monthType,
        'password' => $passport['password'],
        'updatePwd' => $passport['updatePwd'],
        'security' => $this->security,
        'trends' => $trends,
        'endCaseTrends' => $endCaseTrends,
        'type' => $type,
        'trend' => $trend
      );

      if($type == 'report_one_seasonal_review') :
        $surveyTypeData = get_seasonal_review_trend_menu_no($county, $yearType, null);
        $accumCounselingYouth = $this->ReportModel->report_one_get_seasonal_review_report_by_county($county, $yearType, $monthType);
        $value = report_one_seasonal_review_table_value($surveyTypeData, $accumCounselingYouth);

        if($trend == 'one') : 
          $beSentDataset['value'] = $value['one'];
          $beSentDataset['trendName'] = '累積關懷追蹤人數';        
          $beSentDataset['trendInclude'] = '追蹤青少年其來源為109高中已錄取未註冊與108國中動向調查(4-12類別)的青少年人次';        
        elseif($trend == 'two') : 
          $beSentDataset['value'] = $value['two'];
          $beSentDataset['trendName'] = '已就學人數';        
          $beSentDataset['trendInclude'] = '已就學';        
        elseif($trend == 'three') : 
          $beSentDataset['value'] = $value['three'];
          $beSentDataset['trendName'] = '已就業人數';        
          $beSentDataset['trendInclude'] = '已就業';        
        elseif($trend == 'four') : 
          $beSentDataset['value'] = $value['four'];
          $beSentDataset['trendName'] = '參加職訓人數';        
          $beSentDataset['trendInclude'] = '參加職訓';     
        elseif($trend == 'five') : 
          $beSentDataset['value'] = $value['five'];
          $beSentDataset['trendName'] = '其他人數';        
          $beSentDataset['trendInclude'] = '準備升學、準備或正在找工作、家務勞動、健康因素(含休養中)、社政單位協助中、衛政單位協助中、其他單位協助中、自學、待產/育兒、其他';     
        elseif($trend == 'six') : 
          $beSentDataset['value'] = $value['six'];
          $beSentDataset['trendName'] = '尚無動向或失聯人數';        
          $beSentDataset['trendInclude'] = '尚無規劃、未取得聯繫、已開案青少年';     
        elseif($trend == 'seven') : 
          $beSentDataset['value'] = $value['seven'];
          $beSentDataset['trendName'] = '不可抗力人數';        
          $beSentDataset['trendInclude'] = '特教生、移民(出國)、服兵役、警政單位協助中、司法單位協助中、成年、死亡';     
        endif;

      elseif($type == 'report_one_member_month_temp') :
        $trendTypeData = get_end_case_trend_menu_no();
        $accumCounselingMember = $this->ReportModel->report_one_get_member_temp_report_by_county($county, $yearType, $monthType);
        $value = report_one_month_member_temp_counseling_table_value($trendTypeData, $accumCounselingMember);

        if($trend == 'one') : 
          $beSentDataset['value'] = $value['one'];
          $beSentDataset['trendName'] = '累積輔導人數';        
          $beSentDataset['trendInclude'] = '輔導成效概況表中的暫時動向';        
        elseif($trend == 'two') : 
          $beSentDataset['value'] = $value['two'];
          $beSentDataset['trendName'] = '已就學人數';        
          $beSentDataset['trendInclude'] = '已就學(全職學生)';        
        elseif($trend == 'three') : 
          $beSentDataset['value'] = $value['three'];
          $beSentDataset['trendName'] = '已就業人數';        
          $beSentDataset['trendInclude'] = '已就業';        
        elseif($trend == 'four') : 
          $beSentDataset['value'] = $value['four'];
          $beSentDataset['trendName'] = '參加職訓人數';        
          $beSentDataset['trendInclude'] = '參加職訓(說明)';     
        elseif($trend == 'five') : 
          $beSentDataset['value'] = $value['five'];
          $beSentDataset['trendName'] = '其他人數';        
          $beSentDataset['trendInclude'] = '半工半讀、準備就業、準備就學、其他(說明)';     
        elseif($trend == 'six') : 
          $beSentDataset['value'] = $value['six'];
          $beSentDataset['trendName'] = '尚無動向或失聯人數';        
          $beSentDataset['trendInclude'] = '尚無規劃，須持續輔導';     
        elseif($trend == 'seven') : 
          $beSentDataset['value'] = $value['seven'];
          $beSentDataset['trendName'] = '不可抗力人數';        
          $beSentDataset['trendInclude'] = '不可抗力(說明)';     
        endif;

      elseif($type == 'report_one_member_source') :
        $members = $this->MemberModel->get_member_month($county, $yearType, $monthType);
        $memberData = [];
        $memberData['county'] = $county;
        $memberData['year'] = $yearType;
        $memberData['month'] = $monthType;
        $value = report_one_member_source_table_value($memberData, $members);

        if($trend == 'one') : 
          $beSentDataset['value'] = $value['one'];
          $beSentDataset['trendName'] = '本年度新開案個案人數';        
          $beSentDataset['trendInclude'] = '';        
        elseif($trend == 'two') : 
          $beSentDataset['value'] = $value['two'];
          $beSentDataset['trendName'] = '前一年度持續輔導人數';        
          $beSentDataset['trendInclude'] = '';        
        elseif($trend == 'three') : 
          $beSentDataset['value'] = $value['three'];
          $beSentDataset['trendName'] = '106學年度動向調查結果輔導人數';        
          $beSentDataset['trendInclude'] = '';        
        elseif($trend == 'four') : 
          $beSentDataset['value'] = $value['four'];
          $beSentDataset['trendName'] = '107學年度動向調查結果輔導人數';        
          $beSentDataset['trendInclude'] = '';     
        elseif($trend == 'five') : 
          $beSentDataset['value'] = $value['five'];
          $beSentDataset['trendName'] = '108學年度動向調查結果輔導人數';        
          $beSentDataset['trendInclude'] = '';     
        elseif($trend == 'six') : 
          $beSentDataset['value'] = $value['six'];
          $beSentDataset['trendName'] = '109學年度動向調查結果輔導人數';        
          $beSentDataset['trendInclude'] = '';     
        elseif($trend == 'seven') : 
          $beSentDataset['value'] = $value['seven'];
          $beSentDataset['trendName'] = '109年度高中已錄取未註冊結果輔導人數';        
          $beSentDataset['trendInclude'] = '';     
        endif;
      elseif($type == 'report_one_member_counseling') :
        $members = $this->MemberModel->get_member_month($county, $yearType, $monthType);
        $memberData = [];
        $memberData['county'] = $county;
        $memberData['year'] = $yearType;
        $memberData['month'] = $monthType;
        $value = $this->ReportModel->get_member_counseling_by_county($county, $monthType, $yearType);

        if($trend == 'one') : 
          $valueOne = $this->ReportModel->report_one_get_individual_counseling_by_county($county, $yearType, $monthType);
          $valueTwo = $this->ReportModel->report_one_get_group_counseling_by_county($county, $yearType, $monthType);
          $beSentDataset['valueOne'] = $valueOne;
          $beSentDataset['valueTwo'] = $valueTwo;
          $beSentDataset['sumOne'] = $value->individualCounselingCount;
          $beSentDataset['sumTwo'] = $value->groupCounselingCount;
          $beSentDataset['trendName'] = '輔導會談小時';        
          $beSentDataset['trendInclude'] = '個別輔導小時與團體輔導小時之總計';        
        elseif($trend == 'two') : 
          $valueOne = $this->ReportModel->report_one_get_course_by_county($county, $yearType, $monthType);
          $valueTwo = $this->ReportModel->report_one_get_course_member_name_by_county($county, $yearType, $monthType);
          $beSentDataset['valueOne'] = $valueOne;
          $beSentDataset['valueTwo'] = $valueTwo;
          $beSentDataset['sumOne'] = $value->courseAttendanceCount;
          $beSentDataset['trendName'] = '課程時數';        
          $beSentDataset['trendInclude'] = '';        
        elseif($trend == 'three') : 
          $valueOne = $this->ReportModel->report_one_get_work_by_county($county, $yearType, $monthType);
          $beSentDataset['valueOne'] = $valueOne;
          $beSentDataset['sumOne'] = $value->workAttendanceCount;
          $beSentDataset['trendName'] = '工作體驗時數';        
          $beSentDataset['trendInclude'] = '';        
           
        endif;
 
        
      
      elseif($type == 'report_five') :
        $schoolYear = (date("Y")-1911-4);
        $surveyTypeData = get_seasonal_review_trend_menu_no($county, $yearType, null);
        $seasonalReviews = $this->ReportModel->report_survey_type_seasonal_review_by_county($county, $yearType, $monthType, $schoolYear);
        $youths = $this->ReportModel->report_survey_type_youth_by_county($county, $schoolYear);
        $value = report_seasonal_review_table_value($surveyTypeData, $seasonalReviews, $youths);

        if($trend == 'one') :
          $beSentDataset['value'] = $value['one'];
          $beSentDataset['trendName'] = '已就業人數';        
          $beSentDataset['trendInclude'] = '已就業';
        elseif($trend == 'two') :
          $beSentDataset['value'] = $value['two'];
          $beSentDataset['trendName'] = '已就學人數';        
          $beSentDataset['trendInclude'] = '已就學';
        elseif($trend == 'three') :
          $beSentDataset['value'] = $value['three'];
          $beSentDataset['trendName'] = '職業訓練或勞政單位協助中人數';        
          $beSentDataset['trendInclude'] = '參加職訓、勞政單位協助中';
        elseif($trend == 'four') :
          $beSentDataset['value'] = $value['four'];
          $beSentDataset['trendName'] = '其他(具輔導成效)人數';        
          $beSentDataset['trendInclude'] = '社政單位協助中、衛政單位協助中、其他單位協助中、自學';
        elseif($trend == 'five') :
          $beSentDataset['value'] = $value['five'];
          $beSentDataset['trendName'] = '準備升學人數';        
          $beSentDataset['trendInclude'] = '準備升學';
        elseif($trend == 'six') :
          $beSentDataset['value'] = $value['six'];
          $beSentDataset['trendName'] = '準備或正在找工作人數';        
          $beSentDataset['trendInclude'] = '準備或正在找工作';
        elseif($trend == 'seven') :
          $beSentDataset['value'] = $value['seven'];
          $beSentDataset['trendName'] = '家務勞動人數';        
          $beSentDataset['trendInclude'] = '家務勞動';
        elseif($trend == 'eight') :
          $beSentDataset['value'] = $value['eight'];
          $beSentDataset['trendName'] = '健康因素(含休養中)人數';        
          $beSentDataset['trendInclude'] = '健康因素(含休養中)';
        elseif($trend == 'nine') :
          $beSentDataset['value'] = $value['nine'];
          $beSentDataset['trendName'] = '尚無規劃人數';        
          $beSentDataset['trendInclude'] = '尚無規劃、開案青少年';
        elseif($trend == 'ten') :
          $beSentDataset['value'] = $value['ten'];
          $beSentDataset['trendName'] = '未取得聯繫人數';        
          $beSentDataset['trendInclude'] = '未取得聯繫';
        elseif($trend == 'eleven') :
          $beSentDataset['value'] = $value['eleven'];
          $beSentDataset['trendName'] = '其他(尚無輔導成效)人數';        
          $beSentDataset['trendInclude'] = '待產/育兒、其他';
        elseif($trend == 'twelve') :
          $beSentDataset['value'] = $value['twelve'];
          $beSentDataset['trendName'] = '特教生人數';        
          $beSentDataset['trendInclude'] = '特教生';
        elseif($trend == 'thirteen') :
          $beSentDataset['value'] = $value['thirteen'];
          $beSentDataset['trendName'] = '移民(出國)人數';        
          $beSentDataset['trendInclude'] = '移民(出國)';
        elseif($trend == 'fourteen') :
          $beSentDataset['value'] = $value['fourteen'];
          $beSentDataset['trendName'] = '警政或司法單位協助中人數';        
          $beSentDataset['trendInclude'] = '警政單位協助中、司法單位協助中';
        elseif($trend == 'fifteen') :
          $beSentDataset['value'] = $value['fifteen'];
          $beSentDataset['trendName'] = '服兵役人數';        
          $beSentDataset['trendInclude'] = '服兵役';
        elseif($trend == 'sixteen') :
          $beSentDataset['value'] = $value['sixteen'];
          $beSentDataset['trendName'] = '死亡人數';        
          $beSentDataset['trendInclude'] = '死亡';
        elseif($trend == 'seventeen') :
          $beSentDataset['value'] = $value['seventeen'];
          $beSentDataset['trendName'] = '成年人數';        
          $beSentDataset['trendInclude'] = '成年';
        elseif($trend == 'eighteen') :
          $beSentDataset['value'] = $value['eighteen'];
          $beSentDataset['trendName'] = '總計';        
          $beSentDataset['trendInclude'] = '';
        elseif($trend == 'nineteen') :
          $beSentDataset['value'] = $value['nineteen'];
          $beSentDataset['trendName'] = '青少年人數';        
          $beSentDataset['trendInclude'] = $schoolYear . '年動向調查原始動向4-12類別之青少年';
        endif;   
      elseif($type == 'report_six') :
        $schoolYear = (date("Y")-1911-3);
        $surveyTypeData = get_seasonal_review_trend_menu_no($county, $yearType, null);
        $seasonalReviews = $this->ReportModel->report_survey_type_seasonal_review_by_county($county, $yearType, $monthType, $schoolYear);
        $youths = $this->ReportModel->report_survey_type_youth_by_county($county, $schoolYear);
        $value = report_seasonal_review_table_value($surveyTypeData, $seasonalReviews, $youths);

        if($trend == 'one') :
          $beSentDataset['value'] = $value['one'];
          $beSentDataset['trendName'] = '已就業人數';        
          $beSentDataset['trendInclude'] = '已就業';
        elseif($trend == 'two') :
          $beSentDataset['value'] = $value['two'];
          $beSentDataset['trendName'] = '已就學人數';        
          $beSentDataset['trendInclude'] = '已就學';
        elseif($trend == 'three') :
          $beSentDataset['value'] = $value['three'];
          $beSentDataset['trendName'] = '職業訓練或勞政單位協助中人數';        
          $beSentDataset['trendInclude'] = '參加職訓、勞政單位協助中';
        elseif($trend == 'four') :
          $beSentDataset['value'] = $value['four'];
          $beSentDataset['trendName'] = '其他(具輔導成效)人數';        
          $beSentDataset['trendInclude'] = '社政單位協助中、衛政單位協助中、其他單位協助中、自學';
        elseif($trend == 'five') :
          $beSentDataset['value'] = $value['five'];
          $beSentDataset['trendName'] = '準備升學人數';        
          $beSentDataset['trendInclude'] = '準備升學';
        elseif($trend == 'six') :
          $beSentDataset['value'] = $value['six'];
          $beSentDataset['trendName'] = '準備或正在找工作人數';        
          $beSentDataset['trendInclude'] = '準備或正在找工作';
        elseif($trend == 'seven') :
          $beSentDataset['value'] = $value['seven'];
          $beSentDataset['trendName'] = '家務勞動人數';        
          $beSentDataset['trendInclude'] = '家務勞動';
        elseif($trend == 'eight') :
          $beSentDataset['value'] = $value['eight'];
          $beSentDataset['trendName'] = '健康因素(含休養中)人數';        
          $beSentDataset['trendInclude'] = '健康因素(含休養中)';
        elseif($trend == 'nine') :
          $beSentDataset['value'] = $value['nine'];
          $beSentDataset['trendName'] = '尚無規劃人數';        
          $beSentDataset['trendInclude'] = '尚無規劃、開案青少年';
        elseif($trend == 'ten') :
          $beSentDataset['value'] = $value['ten'];
          $beSentDataset['trendName'] = '未取得聯繫人數';        
          $beSentDataset['trendInclude'] = '未取得聯繫';
        elseif($trend == 'eleven') :
          $beSentDataset['value'] = $value['eleven'];
          $beSentDataset['trendName'] = '其他(尚無輔導成效)人數';        
          $beSentDataset['trendInclude'] = '待產/育兒、其他';
        elseif($trend == 'twelve') :
          $beSentDataset['value'] = $value['twelve'];
          $beSentDataset['trendName'] = '特教生人數';        
          $beSentDataset['trendInclude'] = '特教生';
        elseif($trend == 'thirteen') :
          $beSentDataset['value'] = $value['thirteen'];
          $beSentDataset['trendName'] = '移民(出國)人數';        
          $beSentDataset['trendInclude'] = '移民(出國)';
        elseif($trend == 'fourteen') :
          $beSentDataset['value'] = $value['fourteen'];
          $beSentDataset['trendName'] = '警政或司法單位協助中人數';        
          $beSentDataset['trendInclude'] = '警政單位協助中、司法單位協助中';
        elseif($trend == 'fifteen') :
          $beSentDataset['value'] = $value['fifteen'];
          $beSentDataset['trendName'] = '服兵役人數';        
          $beSentDataset['trendInclude'] = '服兵役';
        elseif($trend == 'sixteen') :
          $beSentDataset['value'] = $value['sixteen'];
          $beSentDataset['trendName'] = '死亡人數';        
          $beSentDataset['trendInclude'] = '死亡';
        elseif($trend == 'seventeen') :
          $beSentDataset['value'] = $value['seventeen'];
          $beSentDataset['trendName'] = '成年人數';        
          $beSentDataset['trendInclude'] = '成年';
        elseif($trend == 'eighteen') :
          $beSentDataset['value'] = $value['eighteen'];
          $beSentDataset['trendName'] = '總計';        
          $beSentDataset['trendInclude'] = '';
        elseif($trend == 'nineteen') :
          $beSentDataset['value'] = $value['nineteen'];
          $beSentDataset['trendName'] = '青少年人數';        
          $beSentDataset['trendInclude'] = $schoolYear . '年動向調查原始動向4-12類別之青少年';
        endif;   
      elseif($type == 'report_seven') :
        $schoolYear = (date("Y")-1911-2);
        $surveyTypeData = get_seasonal_review_trend_menu_no($county, $yearType, null);
        $seasonalReviews = $this->ReportModel->report_survey_type_seasonal_review_by_county($county, $yearType, $monthType, $schoolYear);
        $youths = $this->ReportModel->report_survey_type_youth_by_county($county, $schoolYear);
        $value = report_seasonal_review_table_value($surveyTypeData, $seasonalReviews, $youths);

        if($trend == 'one') :
          $beSentDataset['value'] = $value['one'];
          $beSentDataset['trendName'] = '已就業人數';        
          $beSentDataset['trendInclude'] = '已就業';
        elseif($trend == 'two') :
          $beSentDataset['value'] = $value['two'];
          $beSentDataset['trendName'] = '已就學人數';        
          $beSentDataset['trendInclude'] = '已就學';
        elseif($trend == 'three') :
          $beSentDataset['value'] = $value['three'];
          $beSentDataset['trendName'] = '職業訓練或勞政單位協助中人數';        
          $beSentDataset['trendInclude'] = '參加職訓、勞政單位協助中';
        elseif($trend == 'four') :
          $beSentDataset['value'] = $value['four'];
          $beSentDataset['trendName'] = '其他(具輔導成效)人數';        
          $beSentDataset['trendInclude'] = '社政單位協助中、衛政單位協助中、其他單位協助中、自學';
        elseif($trend == 'five') :
          $beSentDataset['value'] = $value['five'];
          $beSentDataset['trendName'] = '準備升學人數';        
          $beSentDataset['trendInclude'] = '準備升學';
        elseif($trend == 'six') :
          $beSentDataset['value'] = $value['six'];
          $beSentDataset['trendName'] = '準備或正在找工作人數';        
          $beSentDataset['trendInclude'] = '準備或正在找工作';
        elseif($trend == 'seven') :
          $beSentDataset['value'] = $value['seven'];
          $beSentDataset['trendName'] = '家務勞動人數';        
          $beSentDataset['trendInclude'] = '家務勞動';
        elseif($trend == 'eight') :
          $beSentDataset['value'] = $value['eight'];
          $beSentDataset['trendName'] = '健康因素(含休養中)人數';        
          $beSentDataset['trendInclude'] = '健康因素(含休養中)';
        elseif($trend == 'nine') :
          $beSentDataset['value'] = $value['nine'];
          $beSentDataset['trendName'] = '尚無規劃人數';        
          $beSentDataset['trendInclude'] = '尚無規劃、開案青少年';
        elseif($trend == 'ten') :
          $beSentDataset['value'] = $value['ten'];
          $beSentDataset['trendName'] = '未取得聯繫人數';        
          $beSentDataset['trendInclude'] = '未取得聯繫';
        elseif($trend == 'eleven') :
          $beSentDataset['value'] = $value['eleven'];
          $beSentDataset['trendName'] = '其他(尚無輔導成效)人數';        
          $beSentDataset['trendInclude'] = '待產/育兒、其他';
        elseif($trend == 'twelve') :
          $beSentDataset['value'] = $value['twelve'];
          $beSentDataset['trendName'] = '特教生人數';        
          $beSentDataset['trendInclude'] = '特教生';
        elseif($trend == 'thirteen') :
          $beSentDataset['value'] = $value['thirteen'];
          $beSentDataset['trendName'] = '移民(出國)人數';        
          $beSentDataset['trendInclude'] = '移民(出國)';
        elseif($trend == 'fourteen') :
          $beSentDataset['value'] = $value['fourteen'];
          $beSentDataset['trendName'] = '警政或司法單位協助中人數';        
          $beSentDataset['trendInclude'] = '警政單位協助中、司法單位協助中';
        elseif($trend == 'fifteen') :
          $beSentDataset['value'] = $value['fifteen'];
          $beSentDataset['trendName'] = '服兵役人數';        
          $beSentDataset['trendInclude'] = '服兵役';
        elseif($trend == 'sixteen') :
          $beSentDataset['value'] = $value['sixteen'];
          $beSentDataset['trendName'] = '死亡人數';        
          $beSentDataset['trendInclude'] = '死亡';
        elseif($trend == 'seventeen') :
          $beSentDataset['value'] = $value['seventeen'];
          $beSentDataset['trendName'] = '成年人數';        
          $beSentDataset['trendInclude'] = '成年';
        elseif($trend == 'eighteen') :
          $beSentDataset['value'] = $value['eighteen'];
          $beSentDataset['trendName'] = '總計';        
          $beSentDataset['trendInclude'] = '';
        elseif($trend == 'nineteen') :
          $beSentDataset['value'] = $value['nineteen'];
          $beSentDataset['trendName'] = '青少年人數';        
          $beSentDataset['trendInclude'] = $schoolYear . '年動向調查原始動向4-12類別之青少年';
        endif;
      elseif($type == 'report_eight') :
        $surveyTypeData = get_seasonal_review_trend_menu_no($county, $yearType, null);
        $seasonalReviews = $this->ReportModel->report_old_case_seasonal_review_by_county($county, $yearType, $monthType);
        $youths = $this->ReportModel->report_old_case_youth_by_county($county, $yearType);
        $value = report_seasonal_review_table_value($surveyTypeData, $seasonalReviews, $youths);

        if($trend == 'one') :
          $beSentDataset['value'] = $value['one'];
          $beSentDataset['trendName'] = '已就業人數';        
          $beSentDataset['trendInclude'] = '已就業';
        elseif($trend == 'two') :
          $beSentDataset['value'] = $value['two'];
          $beSentDataset['trendName'] = '已就學人數';        
          $beSentDataset['trendInclude'] = '已就學';
        elseif($trend == 'three') :
          $beSentDataset['value'] = $value['three'];
          $beSentDataset['trendName'] = '職業訓練或勞政單位協助中人數';        
          $beSentDataset['trendInclude'] = '參加職訓、勞政單位協助中';
        elseif($trend == 'four') :
          $beSentDataset['value'] = $value['four'];
          $beSentDataset['trendName'] = '其他(具輔導成效)人數';        
          $beSentDataset['trendInclude'] = '社政單位協助中、衛政單位協助中、其他單位協助中、自學';
        elseif($trend == 'five') :
          $beSentDataset['value'] = $value['five'];
          $beSentDataset['trendName'] = '準備升學人數';        
          $beSentDataset['trendInclude'] = '準備升學';
        elseif($trend == 'six') :
          $beSentDataset['value'] = $value['six'];
          $beSentDataset['trendName'] = '準備或正在找工作人數';        
          $beSentDataset['trendInclude'] = '準備或正在找工作';
        elseif($trend == 'seven') :
          $beSentDataset['value'] = $value['seven'];
          $beSentDataset['trendName'] = '家務勞動人數';        
          $beSentDataset['trendInclude'] = '家務勞動';
        elseif($trend == 'eight') :
          $beSentDataset['value'] = $value['eight'];
          $beSentDataset['trendName'] = '健康因素(含休養中)人數';        
          $beSentDataset['trendInclude'] = '健康因素(含休養中)';
        elseif($trend == 'nine') :
          $beSentDataset['value'] = $value['nine'];
          $beSentDataset['trendName'] = '尚無規劃人數';        
          $beSentDataset['trendInclude'] = '尚無規劃、開案青少年';
        elseif($trend == 'ten') :
          $beSentDataset['value'] = $value['ten'];
          $beSentDataset['trendName'] = '未取得聯繫人數';        
          $beSentDataset['trendInclude'] = '未取得聯繫';
        elseif($trend == 'eleven') :
          $beSentDataset['value'] = $value['eleven'];
          $beSentDataset['trendName'] = '其他(尚無輔導成效)人數';        
          $beSentDataset['trendInclude'] = '待產/育兒、其他';
        elseif($trend == 'twelve') :
          $beSentDataset['value'] = $value['twelve'];
          $beSentDataset['trendName'] = '特教生人數';        
          $beSentDataset['trendInclude'] = '特教生';
        elseif($trend == 'thirteen') :
          $beSentDataset['value'] = $value['thirteen'];
          $beSentDataset['trendName'] = '移民(出國)人數';        
          $beSentDataset['trendInclude'] = '移民(出國)';
        elseif($trend == 'fourteen') :
          $beSentDataset['value'] = $value['fourteen'];
          $beSentDataset['trendName'] = '警政或司法單位協助中人數';        
          $beSentDataset['trendInclude'] = '警政單位協助中、司法單位協助中';
        elseif($trend == 'fifteen') :
          $beSentDataset['value'] = $value['fifteen'];
          $beSentDataset['trendName'] = '服兵役人數';        
          $beSentDataset['trendInclude'] = '服兵役';
        elseif($trend == 'sixteen') :
          $beSentDataset['value'] = $value['sixteen'];
          $beSentDataset['trendName'] = '死亡人數';        
          $beSentDataset['trendInclude'] = '死亡';
        elseif($trend == 'seventeen') :
          $beSentDataset['value'] = $value['seventeen'];
          $beSentDataset['trendName'] = '成年人數';        
          $beSentDataset['trendInclude'] = '成年';
        elseif($trend == 'eighteen') :
          $beSentDataset['value'] = $value['eighteen'];
          $beSentDataset['trendName'] = '總計';        
          $beSentDataset['trendInclude'] = '';
        elseif($trend == 'nineteen') :
          $beSentDataset['value'] = $value['nineteen'];
          $beSentDataset['trendName'] = '青少年人數';        
          $beSentDataset['trendInclude'] = '前一年結案後之青少年';
        endif;
      elseif($type == 'report_nine') :
        $surveyTypeData = get_seasonal_review_trend_menu_no($county, $yearType, null);
        $seasonalReviews = $this->ReportModel->report_high_school_seasonal_review_by_county($county, $yearType, $monthType);
        $youths = $this->ReportModel->report_high_school_youth_by_county($county);
        $value = report_seasonal_review_table_value($surveyTypeData, $seasonalReviews, $youths);

        if($trend == 'one') :
          $beSentDataset['value'] = $value['one'];
          $beSentDataset['trendName'] = '已就業人數';        
          $beSentDataset['trendInclude'] = '已就業';
        elseif($trend == 'two') :
          $beSentDataset['value'] = $value['two'];
          $beSentDataset['trendName'] = '已就學人數';        
          $beSentDataset['trendInclude'] = '已就學';
        elseif($trend == 'three') :
          $beSentDataset['value'] = $value['three'];
          $beSentDataset['trendName'] = '職業訓練或勞政單位協助中人數';        
          $beSentDataset['trendInclude'] = '參加職訓、勞政單位協助中';
        elseif($trend == 'four') :
          $beSentDataset['value'] = $value['four'];
          $beSentDataset['trendName'] = '其他(具輔導成效)人數';        
          $beSentDataset['trendInclude'] = '社政單位協助中、衛政單位協助中、其他單位協助中、自學';
        elseif($trend == 'five') :
          $beSentDataset['value'] = $value['five'];
          $beSentDataset['trendName'] = '準備升學人數';        
          $beSentDataset['trendInclude'] = '準備升學';
        elseif($trend == 'six') :
          $beSentDataset['value'] = $value['six'];
          $beSentDataset['trendName'] = '準備或正在找工作人數';        
          $beSentDataset['trendInclude'] = '準備或正在找工作';
        elseif($trend == 'seven') :
          $beSentDataset['value'] = $value['seven'];
          $beSentDataset['trendName'] = '家務勞動人數';        
          $beSentDataset['trendInclude'] = '家務勞動';
        elseif($trend == 'eight') :
          $beSentDataset['value'] = $value['eight'];
          $beSentDataset['trendName'] = '健康因素(含休養中)人數';        
          $beSentDataset['trendInclude'] = '健康因素(含休養中)';
        elseif($trend == 'nine') :
          $beSentDataset['value'] = $value['nine'];
          $beSentDataset['trendName'] = '尚無規劃人數';        
          $beSentDataset['trendInclude'] = '尚無規劃、開案青少年';
        elseif($trend == 'ten') :
          $beSentDataset['value'] = $value['ten'];
          $beSentDataset['trendName'] = '未取得聯繫人數';        
          $beSentDataset['trendInclude'] = '未取得聯繫';
        elseif($trend == 'eleven') :
          $beSentDataset['value'] = $value['eleven'];
          $beSentDataset['trendName'] = '其他(尚無輔導成效)人數';        
          $beSentDataset['trendInclude'] = '待產/育兒、其他';
        elseif($trend == 'twelve') :
          $beSentDataset['value'] = $value['twelve'];
          $beSentDataset['trendName'] = '特教生人數';        
          $beSentDataset['trendInclude'] = '特教生';
        elseif($trend == 'thirteen') :
          $beSentDataset['value'] = $value['thirteen'];
          $beSentDataset['trendName'] = '移民(出國)人數';        
          $beSentDataset['trendInclude'] = '移民(出國)';
        elseif($trend == 'fourteen') :
          $beSentDataset['value'] = $value['fourteen'];
          $beSentDataset['trendName'] = '警政或司法單位協助中人數';        
          $beSentDataset['trendInclude'] = '警政單位協助中、司法單位協助中';
        elseif($trend == 'fifteen') :
          $beSentDataset['value'] = $value['fifteen'];
          $beSentDataset['trendName'] = '服兵役人數';        
          $beSentDataset['trendInclude'] = '服兵役';
        elseif($trend == 'sixteen') :
          $beSentDataset['value'] = $value['sixteen'];
          $beSentDataset['trendName'] = '死亡人數';        
          $beSentDataset['trendInclude'] = '死亡';
        elseif($trend == 'seventeen') :
          $beSentDataset['value'] = $value['seventeen'];
          $beSentDataset['trendName'] = '成年人數';        
          $beSentDataset['trendInclude'] = '成年';
        elseif($trend == 'eighteen') :
          $beSentDataset['value'] = $value['eighteen'];
          $beSentDataset['trendName'] = '總計';        
          $beSentDataset['trendInclude'] = '';
        elseif($trend == 'nineteen') :
          $beSentDataset['value'] = $value['nineteen'];
          $beSentDataset['trendName'] = '青少年人數';        
          $beSentDataset['trendInclude'] = '高中已錄取未註之青少年';
        endif;
      
      endif;

      $this->load->view('report/verify_table', $beSentDataset);
    }

    public function organization_manager_report_table()
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(4, 5);
        valid_roles($accept_role);

        if (in_array($current_role, $accept_role)) {
            $organization = $passport['organization'];
            $educationSourceNumber = $this->MenuModel->get_referral_resource_by_content('教育資源')->no;
            $laborSourceNumber = $this->MenuModel->get_referral_resource_by_content('勞政資源')->no;
            $socialSourceNumber = $this->MenuModel->get_referral_resource_by_content('社政資源')->no;
            $healthSourceNumber = $this->MenuModel->get_referral_resource_by_content('衛政資源')->no;
            $officeSourceNumber = $this->MenuModel->get_referral_resource_by_content('警政資源')->no;
            $judicialSourceNumber = $this->MenuModel->get_referral_resource_by_content('司法資源')->no;
            $otherSourceNumber = $this->MenuModel->get_referral_resource_by_content('其他資源')->no;
            $members = $this->ReportModel->get_report_by_organization($organization, $educationSourceNumber, $laborSourceNumber, $socialSourceNumber, $healthSourceNumber, $officeSourceNumber, $judicialSourceNumber, $otherSourceNumber);
            $beSentDataset = array(
                'title' => '即時數據統計-學員清單',
                'url' => '/report/counselor_report_table',
                'role' => $current_role,
                'members' => $members,
                'userTitle' => $userTitle,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $this->load->view('counselor_report_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function yda_report_table($reportType = 'counselEffection', $countyType = null, $yearType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(1, 8);
        valid_roles($accept_role);

        if ($yearType == null) {
            $yearType = date("Y") - 1911;
        }

        if ($countyType == null) {
            $countyType = 'all';
        }
        if ($reportType == null) {
            $reportType = ' ';
        }

        $counties = $this->CountyModel->get_all();
        $years = $this->YouthModel->get_distinct_years();

        $beSentDataset = array(
            'title' => '青年署即時數據統計',
            'url' => '/report/yda_report_table/',
            'role' => $current_role,
            'reportType' => $reportType,
            'counties' => $counties,
            'countyType' => $countyType,
            'yearType' => $yearType,
            'years' => $years,
            'userTitle' => $userTitle,
            'password' => $passport['password'],
            'updatePwd' => $passport['updatePwd']
        );

        if ($reportType == 'surveyTypeTwoYears' || $reportType == 'all') {
            $surveyTypes = $this->MenuModel->get_by_form_and_column('youth', 'survey_type');
            $surveyTypeData = [];
            $surveyTypeData['surveyTypeNumberOne'] = $this->MenuModel->get_no_resource_by_content('01已就業', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwo'] = $this->MenuModel->get_no_resource_by_content('02已就學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThree'] = $this->MenuModel->get_no_resource_by_content('03特教生', 'youth')->no;
            $surveyTypeData['surveyTypeNumberFour'] = $this->MenuModel->get_no_resource_by_content('04準備升學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberFive'] = $this->MenuModel->get_no_resource_by_content('05準備或正在找工作', 'youth')->no;
            $surveyTypeData['surveyTypeNumberSix'] = $this->MenuModel->get_no_resource_by_content('06參加職訓', 'youth')->no;
            $surveyTypeData['surveyTypeNumberSeven'] = $this->MenuModel->get_no_resource_by_content('07家務勞動', 'youth')->no;
            $surveyTypeData['surveyTypeNumberEight'] = $this->MenuModel->get_no_resource_by_content('08健康因素', 'youth')->no;
            $surveyTypeData['surveyTypeNumberNine'] = $this->MenuModel->get_no_resource_by_content('09尚未規劃', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTen'] = $this->MenuModel->get_no_resource_by_content('10失聯', 'youth')->no;
            $surveyTypeData['surveyTypeNumberEleven'] = $this->MenuModel->get_no_resource_by_content('11自學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelve'] = $this->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產、社福機構安置、轉學待追蹤等)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveOne'] = $this->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveTwo'] = $this->MenuModel->get_no_resource_by_content('12其他動向(社福機構安置)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveThree'] = $this->MenuModel->get_no_resource_by_content('12其他動向(轉學)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteen'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(去世、司法問題、出國)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenOne'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(去世)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenTwo'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(司法問題)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenThree'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(出國)', 'youth')->no;

            $surveyTypeData['county'] = $countyType;
            $surveyTypeData['yearType'] = $yearType - 4;
            $surveyTypeTwoYearsCounts = $this->ReportModel->get_survey_type_by_county($surveyTypeData);

            $sumDetail = [];
            $sumDetail['surveyTypeNumberOne'] = $sumDetail['surveyTypeNumberTwo'] = $sumDetail['surveyTypeNumberThree'] = $sumDetail['surveyTypeNumberFour']  
             = $sumDetail['surveyTypeNumberFive'] = $sumDetail['surveyTypeNumberSix'] = $sumDetail['surveyTypeNumberSeven'] = $sumDetail['surveyTypeNumberEight']  
             = $sumDetail['surveyTypeNumberNine'] = $sumDetail['surveyTypeNumberTen'] = $sumDetail['surveyTypeNumberEleven'] = $sumDetail['surveyTypeNumberTwelve']  
             = $sumDetail['surveyTypeNumberTwelveOne'] = $sumDetail['surveyTypeNumberTwelveTwo'] = $sumDetail['surveyTypeNumberTwelveThree'] = $sumDetail['surveyTypeNumberThirteen']  
             = $sumDetail['surveyTypeNumberThirteenOne'] = $sumDetail['surveyTypeNumberThirteenTwo'] = $sumDetail['surveyTypeNumberThirteenThree'] = 0;

            foreach($surveyTypeTwoYearsCounts as $i) {
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

            $beSentDataset['surveyTypes'] = $surveyTypes;
            $beSentDataset['surveyTypeTwoYearsSumDetail'] = $sumDetail;
            $beSentDataset['surveyTypeTwoYearsCounts'] = $surveyTypeTwoYearsCounts;
        }

        if ($reportType == 'surveyTypeOneYears' || $reportType == 'all') {
            $surveyTypes = $this->MenuModel->get_by_form_and_column('youth', 'survey_type');
            $surveyTypeData = [];
            $surveyTypeData['surveyTypeNumberOne'] = $this->MenuModel->get_no_resource_by_content('01已就業', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwo'] = $this->MenuModel->get_no_resource_by_content('02已就學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThree'] = $this->MenuModel->get_no_resource_by_content('03特教生', 'youth')->no;
            $surveyTypeData['surveyTypeNumberFour'] = $this->MenuModel->get_no_resource_by_content('04準備升學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberFive'] = $this->MenuModel->get_no_resource_by_content('05準備或正在找工作', 'youth')->no;
            $surveyTypeData['surveyTypeNumberSix'] = $this->MenuModel->get_no_resource_by_content('06參加職訓', 'youth')->no;
            $surveyTypeData['surveyTypeNumberSeven'] = $this->MenuModel->get_no_resource_by_content('07家務勞動', 'youth')->no;
            $surveyTypeData['surveyTypeNumberEight'] = $this->MenuModel->get_no_resource_by_content('08健康因素', 'youth')->no;
            $surveyTypeData['surveyTypeNumberNine'] = $this->MenuModel->get_no_resource_by_content('09尚未規劃', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTen'] = $this->MenuModel->get_no_resource_by_content('10失聯', 'youth')->no;
            $surveyTypeData['surveyTypeNumberEleven'] = $this->MenuModel->get_no_resource_by_content('11自學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelve'] = $this->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產、社福機構安置、轉學待追蹤等)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveOne'] = $this->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveTwo'] = $this->MenuModel->get_no_resource_by_content('12其他動向(社福機構安置)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveThree'] = $this->MenuModel->get_no_resource_by_content('12其他動向(轉學)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteen'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(去世、司法問題、出國)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenOne'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(去世)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenTwo'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(司法問題)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenThree'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(出國)', 'youth')->no;

            $surveyTypeData['county'] = $countyType;
            $surveyTypeData['yearType'] = $yearType - 3;
            $surveyTypeOneYearsCounts = $this->ReportModel->get_survey_type_by_county($surveyTypeData);

            $sumDetail = [];
            $sumDetail['surveyTypeNumberOne'] = $sumDetail['surveyTypeNumberTwo'] = $sumDetail['surveyTypeNumberThree'] = $sumDetail['surveyTypeNumberFour']  
             = $sumDetail['surveyTypeNumberFive'] = $sumDetail['surveyTypeNumberSix'] = $sumDetail['surveyTypeNumberSeven'] = $sumDetail['surveyTypeNumberEight']  
             = $sumDetail['surveyTypeNumberNine'] = $sumDetail['surveyTypeNumberTen'] = $sumDetail['surveyTypeNumberEleven'] = $sumDetail['surveyTypeNumberTwelve']  
             = $sumDetail['surveyTypeNumberTwelveOne'] = $sumDetail['surveyTypeNumberTwelveTwo'] = $sumDetail['surveyTypeNumberTwelveThree'] = $sumDetail['surveyTypeNumberThirteen']  
             = $sumDetail['surveyTypeNumberThirteenOne'] = $sumDetail['surveyTypeNumberThirteenTwo'] = $sumDetail['surveyTypeNumberThirteenThree'] = 0;

            foreach($surveyTypeOneYearsCounts as $i) {
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

            $beSentDataset['surveyTypes'] = $surveyTypes;
            $beSentDataset['surveyTypeOneYearsSumDetail'] = $sumDetail;
            $beSentDataset['surveyTypeOneYearsCounts'] = $surveyTypeOneYearsCounts;
        }

        if ($reportType == 'surveyTypeNowYears' || $reportType == 'all') {
            $surveyTypes = $this->MenuModel->get_by_form_and_column('youth', 'survey_type');
            $surveyTypeData = [];
            $surveyTypeData['surveyTypeNumberOne'] = $this->MenuModel->get_no_resource_by_content('01已就業', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwo'] = $this->MenuModel->get_no_resource_by_content('02已就學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThree'] = $this->MenuModel->get_no_resource_by_content('03特教生', 'youth')->no;
            $surveyTypeData['surveyTypeNumberFour'] = $this->MenuModel->get_no_resource_by_content('04準備升學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberFive'] = $this->MenuModel->get_no_resource_by_content('05準備或正在找工作', 'youth')->no;
            $surveyTypeData['surveyTypeNumberSix'] = $this->MenuModel->get_no_resource_by_content('06參加職訓', 'youth')->no;
            $surveyTypeData['surveyTypeNumberSeven'] = $this->MenuModel->get_no_resource_by_content('07家務勞動', 'youth')->no;
            $surveyTypeData['surveyTypeNumberEight'] = $this->MenuModel->get_no_resource_by_content('08健康因素', 'youth')->no;
            $surveyTypeData['surveyTypeNumberNine'] = $this->MenuModel->get_no_resource_by_content('09尚未規劃', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTen'] = $this->MenuModel->get_no_resource_by_content('10失聯', 'youth')->no;
            $surveyTypeData['surveyTypeNumberEleven'] = $this->MenuModel->get_no_resource_by_content('11自學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelve'] = $this->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產、社福機構安置、轉學待追蹤等)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveOne'] = $this->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveTwo'] = $this->MenuModel->get_no_resource_by_content('12其他動向(社福機構安置)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveThree'] = $this->MenuModel->get_no_resource_by_content('12其他動向(轉學)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteen'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(去世、司法問題、出國)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenOne'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(去世)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenTwo'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(司法問題)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenThree'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(出國)', 'youth')->no;

            $surveyTypeData['county'] = $countyType;
            $surveyTypeData['yearType'] = $yearType - 2;
            $surveyTypeNowYearsCounts = $this->ReportModel->get_survey_type_by_county($surveyTypeData);

            $sumDetail = [];
            $sumDetail['surveyTypeNumberOne'] = $sumDetail['surveyTypeNumberTwo'] = $sumDetail['surveyTypeNumberThree'] = $sumDetail['surveyTypeNumberFour']  
             = $sumDetail['surveyTypeNumberFive'] = $sumDetail['surveyTypeNumberSix'] = $sumDetail['surveyTypeNumberSeven'] = $sumDetail['surveyTypeNumberEight']  
             = $sumDetail['surveyTypeNumberNine'] = $sumDetail['surveyTypeNumberTen'] = $sumDetail['surveyTypeNumberEleven'] = $sumDetail['surveyTypeNumberTwelve']  
             = $sumDetail['surveyTypeNumberTwelveOne'] = $sumDetail['surveyTypeNumberTwelveTwo'] = $sumDetail['surveyTypeNumberTwelveThree'] = $sumDetail['surveyTypeNumberThirteen']  
             = $sumDetail['surveyTypeNumberThirteenOne'] = $sumDetail['surveyTypeNumberThirteenTwo'] = $sumDetail['surveyTypeNumberThirteenThree'] = 0;

            foreach($surveyTypeNowYearsCounts as $i) {
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

            $beSentDataset['surveyTypes'] = $surveyTypes;
            $beSentDataset['surveyTypeNowYearsSumDetail'] = $sumDetail;
            $beSentDataset['surveyTypeNowYearsCounts'] = $surveyTypeNowYearsCounts;
        }

        if ($reportType == 'surveyTypeHighSchoolTrack' || $reportType == 'all') {

          $source = $this->MenuModel->get_no_resource_by_content('高中已錄取未註冊', 'youth')->no;
          $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $yearType - 4, $source);
          $surveyTypeHighSchoolTrack = $this->ReportModel->get_high_school_seasonal_review_by_county($surveyTypeData);
          
          $sumDetail = get_seasonal_review_sum($surveyTypeHighSchoolTrack);
          $tableValue = get_seasonal_review_table($surveyTypeHighSchoolTrack);
        
          if ($countyType == 'all') $counties = $this->CountyModel->get_all();
          else $counties = $this->CountyModel->get_one($countyType);
          
          $note = $this->ReportModel->get_high_school_seasonal_review_note_by_county($surveyTypeData);
          $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

          $beSentDataset['noteDetail'] = $noteDetailArray;
          $beSentDataset['valueSum'] = $sumDetail;
          $beSentDataset['value'] = $tableValue;
        }

        if ($reportType == 'surveyTypeTwoYearsTrack' || $reportType == 'all') {

          $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $yearType - 4, null);
          $trackData = $this->ReportModel->get_seasonal_review_by_county($surveyTypeData);
          $sumDetail = get_seasonal_review_sum($trackData);
          $tableValue = get_seasonal_review_table($trackData);
        
          if ($countyType == 'all') $counties = $this->CountyModel->get_all();
          else $counties = $this->CountyModel->get_one($countyType);
          
          $note = $this->ReportModel->get_seasonal_review_note_by_county($surveyTypeData);
          $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

          $beSentDataset['noteDetail'] = $noteDetailArray;
          $beSentDataset['valueSum'] = $sumDetail;
          $beSentDataset['value'] = $tableValue;     
        }

        if ($reportType == 'surveyTypeOneYearsTrack' || $reportType == 'all') {

          $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $yearType - 3, null);
          $trackData = $this->ReportModel->get_seasonal_review_by_county($surveyTypeData);
          $sumDetail = get_seasonal_review_sum($trackData);
          $tableValue = get_seasonal_review_table($trackData);
        
          if ($countyType == 'all') $counties = $this->CountyModel->get_all();
          else $counties = $this->CountyModel->get_one($countyType);
          
          $note = $this->ReportModel->get_seasonal_review_note_by_county($surveyTypeData);
          $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

          $beSentDataset['noteDetail'] = $noteDetailArray;
          $beSentDataset['valueSum'] = $sumDetail;
          $beSentDataset['value'] = $tableValue;
        }

        if ($reportType == 'surveyTypeNowYearsTrack' || $reportType == 'all') {

          $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $yearType - 2, null);
          $trackData = $this->ReportModel->get_seasonal_review_by_county($surveyTypeData);
          $sumDetail = get_seasonal_review_sum($trackData);
          $tableValue = get_seasonal_review_table($trackData);
        
          if ($countyType == 'all') $counties = $this->CountyModel->get_all();
          else $counties = $this->CountyModel->get_one($countyType);
          
          $note = $this->ReportModel->get_seasonal_review_note_by_county($surveyTypeData);
          $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

          $beSentDataset['noteDetail'] = $noteDetailArray;
          $beSentDataset['valueSum'] = $sumDetail;
          $beSentDataset['value'] = $tableValue;
        }

        if ($reportType == 'surveyTypeOldCaseTrack' || $reportType == 'all') {

          $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $yearType - 1, null);
          $trackData = $this->ReportModel->get_old_case_seasonal_review_by_county($surveyTypeData);
          $sumDetail = get_seasonal_review_sum($trackData);
          $tableValue = get_seasonal_review_table($trackData);
        
          if ($countyType == 'all') $counties = $this->CountyModel->get_all();
          else $counties = $this->CountyModel->get_one($countyType);
          
          $note = $this->ReportModel->get_old_case_seasonal_review_note_by_county($surveyTypeData);
          $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

          $beSentDataset['noteDetail'] = $noteDetailArray;
          $beSentDataset['valueSum'] = $sumDetail;
          $beSentDataset['value'] = $tableValue;
        }

        if ($reportType == 'counselEffection' || $reportType == 'all') {

            $surveyTypeData = [];
            $surveyTypeData['schoolSource'] = $this->MenuModel->get_no_resource_by_content('動向調查', 'youth')->no;
            $surveyTypeData['referralSource'] = $this->MenuModel->get_no_resource_by_content('轉介或自行開發', 'youth')->no;
            $surveyTypeData['highSource'] = $this->MenuModel->get_no_resource_by_content('高中已錄取未註冊', 'youth')->no;
            $counselEffectionCounts = $this->ReportModel->get_counsel_effection_by_county($countyType, $yearType, $surveyTypeData);

            $sumDetail = [];
            $sumDetail['schoolSourceCount'] = $sumDetail['highSourceCount'] = $sumDetail['referralSourceCount'] = $sumDetail['memberCount']  
             = $sumDetail['seasonalReviewCount'] = $sumDetail['monthReviewCount'] = $sumDetail['individualCounselingCount'] = $sumDetail['groupCounselingCount']  
             = $sumDetail['courseAttendanceCount'] = $sumDetail['workAttendanceCount'] = $sumDetail['endCaseCount'] = 0;

            $trendMemberArray = [];
            foreach($counselEffectionCounts as $i) {

              $trendMember = get_end_case_track_youth($i['no']);
          
              $sumDetail['schoolSourceCount'] += ($i['schoolSourceCount'] + count($trendMember));
              $sumDetail['highSourceCount'] += $i['highSourceCount'];
              //$sumDetail['referralSourceCount'] += $i['referralSourceCount'];
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

            $beSentDataset['counselEffectionCounts'] = $counselEffectionCounts;
            $beSentDataset['counselEffectionCountsSumDetail'] = $sumDetail;
            $beSentDataset['trendMemberArray'] = $trendMemberArray;
        }

        if ($reportType == 'counselEffectionIndividual' || $reportType == 'all') {

            $data = [];
            $data['phoneService'] = $this->MenuModel->get_no_resource_by_content('電訪', 'individual_counseling')->no;
            $data['personallyService'] = $this->MenuModel->get_no_resource_by_content('親訪', 'individual_counseling')->no;
            $data['internetService'] = $this->MenuModel->get_no_resource_by_content('網路', 'individual_counseling')->no;
            $data['educationService'] = $this->MenuModel->get_no_resource_by_content('教育資源', 'individual_counseling')->no;
            $data['laborService'] = $this->MenuModel->get_no_resource_by_content('勞政資源', 'individual_counseling')->no;
            $data['socialService'] = $this->MenuModel->get_no_resource_by_content('社政資源', 'individual_counseling')->no;
            $data['healthService'] = $this->MenuModel->get_no_resource_by_content('衛政資源', 'individual_counseling')->no;
            $data['officeService'] = $this->MenuModel->get_no_resource_by_content('警政資源', 'individual_counseling')->no;
            $data['judicialService'] = $this->MenuModel->get_no_resource_by_content('司法資源', 'individual_counseling')->no;
            $data['otherService'] = $this->MenuModel->get_no_resource_by_content('其他資源', 'individual_counseling')->no;

            $data['county'] = $countyType;
            $data['yearType'] = $yearType;
            $counselEffectionIndividual = $this->ReportModel->get_individual_counseling_report_by_county($data);

            $sumDetail = [];
            $sumDetail['phoneServiceCount'] = $sumDetail['personallyServiceCount'] = $sumDetail['internetServiceCount'] = $sumDetail['educationServiceCount']  
             = $sumDetail['laborServiceCount'] = $sumDetail['socialServiceCount'] = $sumDetail['officeServiceCount'] = $sumDetail['judicialServiceCount']  
             = $sumDetail['healthServiceCount'] = $sumDetail['otherServiceCount'] = 0;

            foreach($counselEffectionIndividual as $i) {
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

            $beSentDataset['counselEffectionIndividual'] = $counselEffectionIndividual;
            $beSentDataset['counselEffectionIndividualSumDetail'] = $sumDetail;
        }

        if ($reportType == 'counselEffectionGroup' || $reportType == 'all') {

            $data = [];
            $data['exploreService'] = $this->MenuModel->get_no_resource_by_content('生涯探索', 'group_counseling')->no;
            $data['interactiveService'] = $this->MenuModel->get_no_resource_by_content('人際溝通與互動', 'group_counseling')->no;
            $data['experienceService'] = $this->MenuModel->get_no_resource_by_content('體驗教育', 'group_counseling')->no;
            $data['environmentService'] = $this->MenuModel->get_no_resource_by_content('環境教育', 'group_counseling')->no;
            $data['judicialService'] = $this->MenuModel->get_no_resource_by_content('法治教育', 'group_counseling')->no;
            $data['genderService'] = $this->MenuModel->get_no_resource_by_content('性別平等教育', 'group_counseling')->no;
            $data['professionService'] = $this->MenuModel->get_no_resource_by_content('職業訓練', 'group_counseling')->no;
            $data['volunteerService'] = $this->MenuModel->get_no_resource_by_content('志願服務', 'group_counseling')->no;
            $data['otherService'] = $this->MenuModel->get_no_resource_by_content('其他', 'group_counseling')->no;

            $data['county'] = $countyType;
            $data['yearType'] = $yearType;
            $counselEffectionGroup = $this->ReportModel->get_group_counseling_report_by_county($data);

            $sumDetail = [];
            $sumDetail['exploreServiceCount'] = $sumDetail['interactiveServiceCount'] = $sumDetail['experienceServiceCount'] = $sumDetail['environmentServiceCount']  
             = $sumDetail['judicialServiceCount'] = $sumDetail['genderServiceCount'] = $sumDetail['professionServiceCount'] = $sumDetail['volunteerServiceCount']  
             = $sumDetail['otherServiceCount'] = 0;

            foreach($counselEffectionGroup as $i) {
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

            $beSentDataset['counselEffectionGroup'] = $counselEffectionGroup;
            $beSentDataset['counselEffectionGroupSumDetail'] = $sumDetail;
        }

        if ($reportType == 'counselEffectionCourse' || $reportType == 'all') {

            $data = [];
            $data['exploreCourse'] = $this->MenuModel->get_no_resource_by_content('生涯探索與就業力培訓', 'course_reference')->no;
            $data['experienceCourse'] = $this->MenuModel->get_no_resource_by_content('體驗教育及志願服務', 'course_reference')->no;
            $data['officeCourse'] = $this->MenuModel->get_no_resource_by_content('法治(含反毒)及性別平等教育', 'course_reference')->no;
            $data['otherCourse'] = $this->MenuModel->get_no_resource_by_content('其他及彈性運用', 'course_reference')->no;

            $data['county'] = $countyType;
            $data['yearType'] = $yearType;
            $counselEffectionCourse = $this->ReportModel->get_course_report_by_county($data);

            $sumDetail = [];
            $sumDetail['exploreCourseCount'] = $sumDetail['experienceCourseCount'] = $sumDetail['officeCourseCount'] = $sumDetail['otherCourseCount'] = 0;

            foreach($counselEffectionCourse as $i) {
              $sumDetail['exploreCourseCount'] += $i['exploreCourseCount'];
              $sumDetail['experienceCourseCount'] += $i['experienceCourseCount'];
              $sumDetail['officeCourseCount'] += $i['officeCourseCount'];
              $sumDetail['otherCourseCount'] += $i['otherCourseCount'];
       
            }


            $beSentDataset['counselEffectionCourse'] = $counselEffectionCourse;
            $beSentDataset['counselEffectionCourseSumDetail'] = $sumDetail;
        }

        if ($reportType == 'counselEffectionWork' || $reportType == 'all') {

            $data = [];
            $data['farmWork'] = $this->MenuModel->get_no_resource_by_content('農、林、漁、牧業', 'company')->no;
            $data['miningWork'] = $this->MenuModel->get_no_resource_by_content('礦業及土石採取業', 'company')->no;
            $data['manufacturingWork'] = $this->MenuModel->get_no_resource_by_content('製造業', 'company')->no;
            $data['electricityWork'] = $this->MenuModel->get_no_resource_by_content('電力及燃氣供應業', 'company')->no;
            $data['waterWork'] = $this->MenuModel->get_no_resource_by_content('用水供應及污染整治業', 'company')->no;
            $data['buildWork'] = $this->MenuModel->get_no_resource_by_content('營建工程業', 'company')->no;
            $data['wholesaleWork'] = $this->MenuModel->get_no_resource_by_content('批發及零售業', 'company')->no;
            $data['transportWork'] = $this->MenuModel->get_no_resource_by_content('運輸及倉儲業', 'company')->no;
            $data['hotelWork'] = $this->MenuModel->get_no_resource_by_content('住宿及餐飲業', 'company')->no;
            $data['publishWork'] = $this->MenuModel->get_no_resource_by_content('出版、影音製作、傳播及資通訊服務業', 'company')->no;
            $data['financialWork'] = $this->MenuModel->get_no_resource_by_content('金融及保險業', 'company')->no;
            $data['immovablesWork'] = $this->MenuModel->get_no_resource_by_content('不動產業', 'company')->no;
            $data['scienceWork'] = $this->MenuModel->get_no_resource_by_content('專業、科學及技術服務業', 'company')->no;
            $data['supportWork'] = $this->MenuModel->get_no_resource_by_content('支援服務業', 'company')->no;
            $data['militaryWork'] = $this->MenuModel->get_no_resource_by_content('公共行政及國防；強制性社會安全', 'company')->no;
            $data['educationWork'] = $this->MenuModel->get_no_resource_by_content('教育業', 'company')->no;
            $data['hospitalWork'] = $this->MenuModel->get_no_resource_by_content('醫療保健及社會工作服務業', 'company')->no;
            $data['artWork'] = $this->MenuModel->get_no_resource_by_content('藝術、娛樂及休閒服務業', 'company')->no;
            $data['otherWork'] = $this->MenuModel->get_no_resource_by_content('其他服務業', 'company')->no;

            $data['county'] = $countyType;
            $data['yearType'] = $yearType;
            $counselEffectionWork = $this->ReportModel->get_work_report_by_county($data);

            $sumDetail = [];
            $sumDetail['farmWorkCount'] = $sumDetail['miningWorkCount'] = $sumDetail['manufacturingWorkCount'] = $sumDetail['electricityWorkCount']  
             = $sumDetail['waterWorkCount'] = $sumDetail['buildWorkCount'] = $sumDetail['wholesaleWorkCount'] = $sumDetail['transportWorkCount']  
             = $sumDetail['hotelWorkCount'] = $sumDetail['publishWorkCount'] = $sumDetail['financialWorkCount'] = $sumDetail['immovablesWorkCount']
             = $sumDetail['scienceWorkCount'] = $sumDetail['supportWorkCount'] = $sumDetail['militaryWorkCount'] = $sumDetail['educationWorkCount'] 
             = $sumDetail['hospitalWorkCount'] = $sumDetail['artWorkCount'] = $sumDetail['otherWorkCount'] = 0;

            foreach($counselEffectionWork as $i) {
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


            $beSentDataset['counselEffectionWork'] = $counselEffectionWork;
            $beSentDataset['counselEffectionWorkSumDetail'] = $sumDetail;
        }

        if ($reportType == 'counselEffectionMeeting' || $reportType == 'all') {

            $data = [];
            $data['meetingType'] = $this->MenuModel->get_no_resource_by_content('跨局處會議', 'meeting')->no;
            $data['activityType'] = $this->MenuModel->get_no_resource_by_content('預防性講座', 'meeting')->no;

            $data['county'] = $countyType;
            $data['yearType'] = $yearType;
            $counselEffectionMeeting = $this->ReportModel->get_meeting_report_by_county($data);

            $sumDetail = [];
            $sumDetail['meetingCount'] = $sumDetail['activityCount'] = 0;

            foreach($counselEffectionMeeting as $i) {
              $sumDetail['meetingCount'] += $i['meetingCount'];
              $sumDetail['activityCount'] += $i['activityCount'];      
            }

            $beSentDataset['counselEffectionMeeting'] = $counselEffectionMeeting;
            $beSentDataset['counselEffectionMeetingSumDetail'] = $sumDetail;
        }

        if ($reportType == 'countyDelegateOrganization' || $reportType == 'all') {
            $countyDelegateOrganizations = $this->ReportModel->get_county_delegate_organization($countyType, $yearType);
            $executeModes = $this->MenuModel->get_by_form_and_column('project', 'execute_mode');
            $executeWays = $this->MenuModel->get_by_form_and_column('project', 'execute_way');
            $beSentDataset['countyDelegateOrganizations'] = $countyDelegateOrganizations;
            $beSentDataset['executeModes'] = $executeModes;
            $beSentDataset['executeWays'] = $executeWays;
        }

        $this->load->view('report/yda_report_table', $beSentDataset);
    }

    public function county_report_table($reportType = 'counselEffection', $yearType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(2, 3);
        $countyType = $passport['county'];
        valid_roles($accept_role);

        if ($yearType == null) {
            $yearType = date("Y") - 1911;
        }

        if ($reportType == null) {
            $reportType = ' ';
        }

        $counties = $this->CountyModel->get_all();
        $years = $this->YouthModel->get_distinct_years();

        $beSentDataset = array(
            'title' => '縣市即時數據統計',
            'url' => '/report/county_report_table/',
            'role' => $current_role,
            'reportType' => $reportType,
            'counties' => $counties,
            'countyType' => $countyType,
            'yearType' => $yearType,
            'years' => $years,
            'userTitle' => $userTitle,
            'password' => $passport['password'],
            'updatePwd' => $passport['updatePwd']
        );

        if ($reportType == 'surveyTypeTwoYears' || $reportType == 'all') {
            $surveyTypes = $this->MenuModel->get_by_form_and_column('youth', 'survey_type');
            $surveyTypeData = [];
            $surveyTypeData['surveyTypeNumberOne'] = $this->MenuModel->get_no_resource_by_content('01已就業', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwo'] = $this->MenuModel->get_no_resource_by_content('02已就學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThree'] = $this->MenuModel->get_no_resource_by_content('03特教生', 'youth')->no;
            $surveyTypeData['surveyTypeNumberFour'] = $this->MenuModel->get_no_resource_by_content('04準備升學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberFive'] = $this->MenuModel->get_no_resource_by_content('05準備或正在找工作', 'youth')->no;
            $surveyTypeData['surveyTypeNumberSix'] = $this->MenuModel->get_no_resource_by_content('06參加職訓', 'youth')->no;
            $surveyTypeData['surveyTypeNumberSeven'] = $this->MenuModel->get_no_resource_by_content('07家務勞動', 'youth')->no;
            $surveyTypeData['surveyTypeNumberEight'] = $this->MenuModel->get_no_resource_by_content('08健康因素', 'youth')->no;
            $surveyTypeData['surveyTypeNumberNine'] = $this->MenuModel->get_no_resource_by_content('09尚未規劃', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTen'] = $this->MenuModel->get_no_resource_by_content('10失聯', 'youth')->no;
            $surveyTypeData['surveyTypeNumberEleven'] = $this->MenuModel->get_no_resource_by_content('11自學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelve'] = $this->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產、社福機構安置、轉學待追蹤等)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveOne'] = $this->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveTwo'] = $this->MenuModel->get_no_resource_by_content('12其他動向(社福機構安置)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveThree'] = $this->MenuModel->get_no_resource_by_content('12其他動向(轉學)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteen'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(去世、司法問題、出國)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenOne'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(去世)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenTwo'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(司法問題)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenThree'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(出國)', 'youth')->no;

            $surveyTypeData['county'] = $countyType;
            $surveyTypeData['yearType'] = $yearType - 4;
            $surveyTypeTwoYearsCounts = $this->ReportModel->get_survey_type_by_county($surveyTypeData);

            $beSentDataset['surveyTypes'] = $surveyTypes;
            $beSentDataset['surveyTypeTwoYearsCounts'] = $surveyTypeTwoYearsCounts;
        }

        if ($reportType == 'surveyTypeOneYears' || $reportType == 'all') {
            $surveyTypes = $this->MenuModel->get_by_form_and_column('youth', 'survey_type');
            $surveyTypeData = [];
            $surveyTypeData['surveyTypeNumberOne'] = $this->MenuModel->get_no_resource_by_content('01已就業', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwo'] = $this->MenuModel->get_no_resource_by_content('02已就學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThree'] = $this->MenuModel->get_no_resource_by_content('03特教生', 'youth')->no;
            $surveyTypeData['surveyTypeNumberFour'] = $this->MenuModel->get_no_resource_by_content('04準備升學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberFive'] = $this->MenuModel->get_no_resource_by_content('05準備或正在找工作', 'youth')->no;
            $surveyTypeData['surveyTypeNumberSix'] = $this->MenuModel->get_no_resource_by_content('06參加職訓', 'youth')->no;
            $surveyTypeData['surveyTypeNumberSeven'] = $this->MenuModel->get_no_resource_by_content('07家務勞動', 'youth')->no;
            $surveyTypeData['surveyTypeNumberEight'] = $this->MenuModel->get_no_resource_by_content('08健康因素', 'youth')->no;
            $surveyTypeData['surveyTypeNumberNine'] = $this->MenuModel->get_no_resource_by_content('09尚未規劃', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTen'] = $this->MenuModel->get_no_resource_by_content('10失聯', 'youth')->no;
            $surveyTypeData['surveyTypeNumberEleven'] = $this->MenuModel->get_no_resource_by_content('11自學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelve'] = $this->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產、社福機構安置、轉學待追蹤等)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveOne'] = $this->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveTwo'] = $this->MenuModel->get_no_resource_by_content('12其他動向(社福機構安置)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveThree'] = $this->MenuModel->get_no_resource_by_content('12其他動向(轉學)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteen'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(去世、司法問題、出國)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenOne'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(去世)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenTwo'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(司法問題)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenThree'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(出國)', 'youth')->no;

            $surveyTypeData['county'] = $countyType;
            $surveyTypeData['yearType'] = $yearType - 3;
            $surveyTypeOneYearsCounts = $this->ReportModel->get_survey_type_by_county($surveyTypeData);

            $beSentDataset['surveyTypes'] = $surveyTypes;
            $beSentDataset['surveyTypeOneYearsCounts'] = $surveyTypeOneYearsCounts;
        }

        if ($reportType == 'surveyTypeNowYears' || $reportType == 'all') {
            $surveyTypes = $this->MenuModel->get_by_form_and_column('youth', 'survey_type');
            $surveyTypeData = [];
            $surveyTypeData['surveyTypeNumberOne'] = $this->MenuModel->get_no_resource_by_content('01已就業', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwo'] = $this->MenuModel->get_no_resource_by_content('02已就學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThree'] = $this->MenuModel->get_no_resource_by_content('03特教生', 'youth')->no;
            $surveyTypeData['surveyTypeNumberFour'] = $this->MenuModel->get_no_resource_by_content('04準備升學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberFive'] = $this->MenuModel->get_no_resource_by_content('05準備或正在找工作', 'youth')->no;
            $surveyTypeData['surveyTypeNumberSix'] = $this->MenuModel->get_no_resource_by_content('06參加職訓', 'youth')->no;
            $surveyTypeData['surveyTypeNumberSeven'] = $this->MenuModel->get_no_resource_by_content('07家務勞動', 'youth')->no;
            $surveyTypeData['surveyTypeNumberEight'] = $this->MenuModel->get_no_resource_by_content('08健康因素', 'youth')->no;
            $surveyTypeData['surveyTypeNumberNine'] = $this->MenuModel->get_no_resource_by_content('09尚未規劃', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTen'] = $this->MenuModel->get_no_resource_by_content('10失聯', 'youth')->no;
            $surveyTypeData['surveyTypeNumberEleven'] = $this->MenuModel->get_no_resource_by_content('11自學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelve'] = $this->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產、社福機構安置、轉學待追蹤等)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveOne'] = $this->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveTwo'] = $this->MenuModel->get_no_resource_by_content('12其他動向(社福機構安置)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveThree'] = $this->MenuModel->get_no_resource_by_content('12其他動向(轉學)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteen'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(去世、司法問題、出國)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenOne'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(去世)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenTwo'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(司法問題)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenThree'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(出國)', 'youth')->no;

            $surveyTypeData['county'] = $countyType;
            $surveyTypeData['yearType'] = $yearType - 2;
            $surveyTypeNowYearsCounts = $this->ReportModel->get_survey_type_by_county($surveyTypeData);

            $beSentDataset['surveyTypes'] = $surveyTypes;
            $beSentDataset['surveyTypeNowYearsCounts'] = $surveyTypeNowYearsCounts;
        }

        if ($reportType == 'surveyTypeHighSchoolTrack' || $reportType == 'all') {

          $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $yearType - 4, null);
          $trackData = $this->ReportModel->get_seasonal_review_by_county($surveyTypeData);
          $sumDetail = get_seasonal_review_sum($trackData);
          $tableValue = get_seasonal_review_table($trackData);
        
          if ($countyType == 'all') $counties = $this->CountyModel->get_all();
          else $counties = $this->CountyModel->get_one($countyType);
          
          $note = $this->ReportModel->get_seasonal_review_note_by_county($surveyTypeData);
          $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

          $beSentDataset['noteDetail'] = $noteDetailArray;
          $beSentDataset['valueSum'] = $sumDetail;
          $beSentDataset['value'] = $tableValue;
        }

        if ($reportType == 'surveyTypeTwoYearsTrack' || $reportType == 'all') {

          $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $yearType - 4, null);
          $trackData = $this->ReportModel->get_seasonal_review_by_county($surveyTypeData);
          $sumDetail = get_seasonal_review_sum($trackData);
          $tableValue = get_seasonal_review_table($trackData);
        
          if ($countyType == 'all') $counties = $this->CountyModel->get_all();
          else $counties = $this->CountyModel->get_one($countyType);
          
          $note = $this->ReportModel->get_seasonal_review_note_by_county($surveyTypeData);
          $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

          $beSentDataset['noteDetail'] = $noteDetailArray;
          $beSentDataset['valueSum'] = $sumDetail;
          $beSentDataset['value'] = $tableValue;     
        }

        if ($reportType == 'surveyTypeOneYearsTrack' || $reportType == 'all') {

          $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $yearType - 3, null);
          $trackData = $this->ReportModel->get_seasonal_review_by_county($surveyTypeData);
          $sumDetail = get_seasonal_review_sum($trackData);
          $tableValue = get_seasonal_review_table($trackData);
        
          if ($countyType == 'all') $counties = $this->CountyModel->get_all();
          else $counties = $this->CountyModel->get_one($countyType);
          
          $note = $this->ReportModel->get_seasonal_review_note_by_county($surveyTypeData);
          $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

          $beSentDataset['noteDetail'] = $noteDetailArray;
          $beSentDataset['valueSum'] = $sumDetail;
          $beSentDataset['value'] = $tableValue;
        }

        if ($reportType == 'surveyTypeNowYearsTrack' || $reportType == 'all') {

          $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $yearType - 2, null);
          $trackData = $this->ReportModel->get_seasonal_review_by_county($surveyTypeData);
          $sumDetail = get_seasonal_review_sum($trackData);
          $tableValue = get_seasonal_review_table($trackData);
        
          if ($countyType == 'all') $counties = $this->CountyModel->get_all();
          else $counties = $this->CountyModel->get_one($countyType);
          
          $note = $this->ReportModel->get_seasonal_review_note_by_county($surveyTypeData);
          $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

          $beSentDataset['noteDetail'] = $noteDetailArray;
          $beSentDataset['valueSum'] = $sumDetail;
          $beSentDataset['value'] = $tableValue;
        }

        if ($reportType == 'surveyTypeOldCaseTrack' || $reportType == 'all') {

          $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $yearType - 1, null);
          $trackData = $this->ReportModel->get_old_case_seasonal_review_by_county($surveyTypeData);
          $sumDetail = get_seasonal_review_sum($trackData);
          $tableValue = get_seasonal_review_table($trackData);
        
          if ($countyType == 'all') $counties = $this->CountyModel->get_all();
          else $counties = $this->CountyModel->get_one($countyType);
          
          $note = $this->ReportModel->get_old_case_seasonal_review_note_by_county($surveyTypeData);
          $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

          $beSentDataset['noteDetail'] = $noteDetailArray;
          $beSentDataset['valueSum'] = $sumDetail;
          $beSentDataset['value'] = $tableValue;
        }

        if ($reportType == 'counselEffection' || $reportType == 'all') {
            $surveyTypeData = [];
            $surveyTypeData['schoolSource'] = $this->MenuModel->get_no_resource_by_content('動向調查', 'youth')->no;
            $surveyTypeData['referralSource'] = $this->MenuModel->get_no_resource_by_content('轉介或自行開發', 'youth')->no;
            $surveyTypeData['highSource'] = $this->MenuModel->get_no_resource_by_content('高中已錄取未註冊', 'youth')->no;
            $counselEffectionCounts = $this->ReportModel->get_counsel_effection_by_county($countyType, $yearType, $surveyTypeData);
            $beSentDataset['counselEffectionCounts'] = $counselEffectionCounts;

            $trendMemberArray = get_end_case_track_youth($countyType);
           
            $beSentDataset['trendMemberArray'] = $trendMemberArray;

        }

        if ($reportType == 'counselEffectionIndividual' || $reportType == 'all') {

            $data = [];
            $data['phoneService'] = $this->MenuModel->get_no_resource_by_content('電訪', 'individual_counseling')->no;
            $data['personallyService'] = $this->MenuModel->get_no_resource_by_content('親訪', 'individual_counseling')->no;
            $data['internetService'] = $this->MenuModel->get_no_resource_by_content('網路', 'individual_counseling')->no;
            $data['educationService'] = $this->MenuModel->get_no_resource_by_content('教育資源', 'individual_counseling')->no;
            $data['laborService'] = $this->MenuModel->get_no_resource_by_content('勞政資源', 'individual_counseling')->no;
            $data['socialService'] = $this->MenuModel->get_no_resource_by_content('社政資源', 'individual_counseling')->no;
            $data['healthService'] = $this->MenuModel->get_no_resource_by_content('衛政資源', 'individual_counseling')->no;
            $data['officeService'] = $this->MenuModel->get_no_resource_by_content('警政資源', 'individual_counseling')->no;
            $data['judicialService'] = $this->MenuModel->get_no_resource_by_content('司法資源', 'individual_counseling')->no;
            $data['otherService'] = $this->MenuModel->get_no_resource_by_content('其他資源', 'individual_counseling')->no;

            $data['county'] = $countyType;
            $data['yearType'] = $yearType;
            $counselEffectionIndividual = $this->ReportModel->get_individual_counseling_report_by_county($data);

            $beSentDataset['counselEffectionIndividual'] = $counselEffectionIndividual;
        }

        if ($reportType == 'counselEffectionGroup' || $reportType == 'all') {

            $data = [];
            $data['exploreService'] = $this->MenuModel->get_no_resource_by_content('生涯探索', 'group_counseling')->no;
            $data['interactiveService'] = $this->MenuModel->get_no_resource_by_content('人際溝通與互動', 'group_counseling')->no;
            $data['experienceService'] = $this->MenuModel->get_no_resource_by_content('體驗教育', 'group_counseling')->no;
            $data['environmentService'] = $this->MenuModel->get_no_resource_by_content('環境教育', 'group_counseling')->no;
            $data['judicialService'] = $this->MenuModel->get_no_resource_by_content('法治教育', 'group_counseling')->no;
            $data['genderService'] = $this->MenuModel->get_no_resource_by_content('性別平等教育', 'group_counseling')->no;
            $data['professionService'] = $this->MenuModel->get_no_resource_by_content('職業訓練', 'group_counseling')->no;
            $data['volunteerService'] = $this->MenuModel->get_no_resource_by_content('志願服務', 'group_counseling')->no;
            $data['otherService'] = $this->MenuModel->get_no_resource_by_content('其他', 'group_counseling')->no;

            $data['county'] = $countyType;
            $data['yearType'] = $yearType;
            $counselEffectionGroup = $this->ReportModel->get_group_counseling_report_by_county($data);

            $beSentDataset['counselEffectionGroup'] = $counselEffectionGroup;
        }

        if ($reportType == 'counselEffectionCourse' || $reportType == 'all') {

            $data = [];
            $data['exploreCourse'] = $this->MenuModel->get_no_resource_by_content('生涯探索與就業力培訓', 'course_reference')->no;
            $data['experienceCourse'] = $this->MenuModel->get_no_resource_by_content('體驗教育及志願服務', 'course_reference')->no;
            $data['officeCourse'] = $this->MenuModel->get_no_resource_by_content('法治(含反毒)及性別平等教育', 'course_reference')->no;
            $data['otherCourse'] = $this->MenuModel->get_no_resource_by_content('其他及彈性運用', 'course_reference')->no;

            $data['county'] = $countyType;
            $data['yearType'] = $yearType;
            $counselEffectionCourse = $this->ReportModel->get_course_report_by_county($data);

            $beSentDataset['counselEffectionCourse'] = $counselEffectionCourse;
        }

        if ($reportType == 'counselEffectionWork' || $reportType == 'all') {

            $data = [];
            $data['farmWork'] = $this->MenuModel->get_no_resource_by_content('農、林、漁、牧業', 'company')->no;
            $data['miningWork'] = $this->MenuModel->get_no_resource_by_content('礦業及土石採取業', 'company')->no;
            $data['manufacturingWork'] = $this->MenuModel->get_no_resource_by_content('製造業', 'company')->no;
            $data['electricityWork'] = $this->MenuModel->get_no_resource_by_content('電力及燃氣供應業', 'company')->no;
            $data['waterWork'] = $this->MenuModel->get_no_resource_by_content('用水供應及污染整治業', 'company')->no;
            $data['buildWork'] = $this->MenuModel->get_no_resource_by_content('營建工程業', 'company')->no;
            $data['wholesaleWork'] = $this->MenuModel->get_no_resource_by_content('批發及零售業', 'company')->no;
            $data['transportWork'] = $this->MenuModel->get_no_resource_by_content('運輸及倉儲業', 'company')->no;
            $data['hotelWork'] = $this->MenuModel->get_no_resource_by_content('住宿及餐飲業', 'company')->no;
            $data['publishWork'] = $this->MenuModel->get_no_resource_by_content('出版、影音製作、傳播及資通訊服務業', 'company')->no;
            $data['financialWork'] = $this->MenuModel->get_no_resource_by_content('金融及保險業', 'company')->no;
            $data['immovablesWork'] = $this->MenuModel->get_no_resource_by_content('不動產業', 'company')->no;
            $data['scienceWork'] = $this->MenuModel->get_no_resource_by_content('專業、科學及技術服務業', 'company')->no;
            $data['supportWork'] = $this->MenuModel->get_no_resource_by_content('支援服務業', 'company')->no;
            $data['militaryWork'] = $this->MenuModel->get_no_resource_by_content('公共行政及國防；強制性社會安全', 'company')->no;
            $data['educationWork'] = $this->MenuModel->get_no_resource_by_content('教育業', 'company')->no;
            $data['hospitalWork'] = $this->MenuModel->get_no_resource_by_content('醫療保健及社會工作服務業', 'company')->no;
            $data['artWork'] = $this->MenuModel->get_no_resource_by_content('藝術、娛樂及休閒服務業', 'company')->no;
            $data['otherWork'] = $this->MenuModel->get_no_resource_by_content('其他服務業', 'company')->no;

            $data['county'] = $countyType;
            $data['yearType'] = $yearType;
            $counselEffectionWork = $this->ReportModel->get_work_report_by_county($data);

            $beSentDataset['counselEffectionWork'] = $counselEffectionWork;
        }

        if ($reportType == 'counselEffectionMeeting' || $reportType == 'all') {

            $data = [];
            $data['meetingType'] = $this->MenuModel->get_no_resource_by_content('跨局處會議', 'meeting')->no;
            $data['activityType'] = $this->MenuModel->get_no_resource_by_content('預防性講座', 'meeting')->no;

            $data['county'] = $countyType;
            $data['yearType'] = $yearType;
            $counselEffectionMeeting = $this->ReportModel->get_meeting_report_by_county($data);

            $beSentDataset['counselEffectionMeeting'] = $counselEffectionMeeting;
        }

        if ($reportType == 'countyDelegateOrganization' || $reportType == 'all') {
            $countyDelegateOrganizations = $this->ReportModel->get_county_delegate_organization($countyType, $yearType);
            $executeModes = $this->MenuModel->get_by_form_and_column('project', 'execute_mode');
            $executeWays = $this->MenuModel->get_by_form_and_column('project', 'execute_way');
            $beSentDataset['executeModes'] = $executeModes;
            $beSentDataset['executeWays'] = $executeWays;
            $beSentDataset['countyDelegateOrganizations'] = $countyDelegateOrganizations;
        }

        $this->load->view('report/county_report_table', $beSentDataset);
    }

    public function organization_report_table($reportType = 'counselEffection', $yearType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(4, 5);
        $countyType = $passport['county'];
        $organization = $passport['organization'];
        valid_roles($accept_role);

        if ($yearType == null) {
            $yearType = date("Y") - 1911;
        }

        if ($reportType == null) {
            $reportType = ' ';
        }

        $counties = $this->CountyModel->get_all();
        $years = $this->YouthModel->get_distinct_years();

        $beSentDataset = array(
            'title' => '機構即時數據統計',
            'url' => '/report/organization_report_table/',
            'role' => $current_role,
            'reportType' => $reportType,
            'counties' => $counties,
            'countyType' => $countyType,
            'yearType' => $yearType,
            'years' => $years,
            'userTitle' => $userTitle,
            'password' => $passport['password'],
            'updatePwd' => $passport['updatePwd']
        );

        if ($reportType == 'surveyTypeTwoYears' || $reportType == 'all') {
            $surveyTypes = $this->MenuModel->get_by_form_and_column('youth', 'survey_type');
            $surveyTypeData = [];
            $surveyTypeData['surveyTypeNumberOne'] = $this->MenuModel->get_no_resource_by_content('01已就業', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwo'] = $this->MenuModel->get_no_resource_by_content('02已就學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThree'] = $this->MenuModel->get_no_resource_by_content('03特教生', 'youth')->no;
            $surveyTypeData['surveyTypeNumberFour'] = $this->MenuModel->get_no_resource_by_content('04準備升學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberFive'] = $this->MenuModel->get_no_resource_by_content('05準備或正在找工作', 'youth')->no;
            $surveyTypeData['surveyTypeNumberSix'] = $this->MenuModel->get_no_resource_by_content('06參加職訓', 'youth')->no;
            $surveyTypeData['surveyTypeNumberSeven'] = $this->MenuModel->get_no_resource_by_content('07家務勞動', 'youth')->no;
            $surveyTypeData['surveyTypeNumberEight'] = $this->MenuModel->get_no_resource_by_content('08健康因素', 'youth')->no;
            $surveyTypeData['surveyTypeNumberNine'] = $this->MenuModel->get_no_resource_by_content('09尚未規劃', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTen'] = $this->MenuModel->get_no_resource_by_content('10失聯', 'youth')->no;
            $surveyTypeData['surveyTypeNumberEleven'] = $this->MenuModel->get_no_resource_by_content('11自學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelve'] = $this->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產、社福機構安置、轉學待追蹤等)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveOne'] = $this->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveTwo'] = $this->MenuModel->get_no_resource_by_content('12其他動向(社福機構安置)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveThree'] = $this->MenuModel->get_no_resource_by_content('12其他動向(轉學)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteen'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(去世、司法問題、出國)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenOne'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(去世)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenTwo'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(司法問題)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenThree'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(出國)', 'youth')->no;

            $surveyTypeData['county'] = $countyType;
            $surveyTypeData['yearType'] = $yearType - 4;
            $surveyTypeTwoYearsCounts = $this->ReportModel->get_survey_type_by_county($surveyTypeData);

            $beSentDataset['surveyTypes'] = $surveyTypes;
            $beSentDataset['surveyTypeTwoYearsCounts'] = $surveyTypeTwoYearsCounts;
        }

        if ($reportType == 'surveyTypeOneYears' || $reportType == 'all') {
            $surveyTypes = $this->MenuModel->get_by_form_and_column('youth', 'survey_type');
            $surveyTypeData = [];
            $surveyTypeData['surveyTypeNumberOne'] = $this->MenuModel->get_no_resource_by_content('01已就業', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwo'] = $this->MenuModel->get_no_resource_by_content('02已就學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThree'] = $this->MenuModel->get_no_resource_by_content('03特教生', 'youth')->no;
            $surveyTypeData['surveyTypeNumberFour'] = $this->MenuModel->get_no_resource_by_content('04準備升學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberFive'] = $this->MenuModel->get_no_resource_by_content('05準備或正在找工作', 'youth')->no;
            $surveyTypeData['surveyTypeNumberSix'] = $this->MenuModel->get_no_resource_by_content('06參加職訓', 'youth')->no;
            $surveyTypeData['surveyTypeNumberSeven'] = $this->MenuModel->get_no_resource_by_content('07家務勞動', 'youth')->no;
            $surveyTypeData['surveyTypeNumberEight'] = $this->MenuModel->get_no_resource_by_content('08健康因素', 'youth')->no;
            $surveyTypeData['surveyTypeNumberNine'] = $this->MenuModel->get_no_resource_by_content('09尚未規劃', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTen'] = $this->MenuModel->get_no_resource_by_content('10失聯', 'youth')->no;
            $surveyTypeData['surveyTypeNumberEleven'] = $this->MenuModel->get_no_resource_by_content('11自學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelve'] = $this->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產、社福機構安置、轉學待追蹤等)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveOne'] = $this->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveTwo'] = $this->MenuModel->get_no_resource_by_content('12其他動向(社福機構安置)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveThree'] = $this->MenuModel->get_no_resource_by_content('12其他動向(轉學)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteen'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(去世、司法問題、出國)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenOne'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(去世)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenTwo'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(司法問題)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenThree'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(出國)', 'youth')->no;

            $surveyTypeData['county'] = $countyType;
            $surveyTypeData['yearType'] = $yearType - 3;
            $surveyTypeOneYearsCounts = $this->ReportModel->get_survey_type_by_county($surveyTypeData);

            $beSentDataset['surveyTypes'] = $surveyTypes;
            $beSentDataset['surveyTypeOneYearsCounts'] = $surveyTypeOneYearsCounts;
        }

        if ($reportType == 'surveyTypeNowYears' || $reportType == 'all') {
            $surveyTypes = $this->MenuModel->get_by_form_and_column('youth', 'survey_type');
            $surveyTypeData = [];
            $surveyTypeData['surveyTypeNumberOne'] = $this->MenuModel->get_no_resource_by_content('01已就業', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwo'] = $this->MenuModel->get_no_resource_by_content('02已就學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThree'] = $this->MenuModel->get_no_resource_by_content('03特教生', 'youth')->no;
            $surveyTypeData['surveyTypeNumberFour'] = $this->MenuModel->get_no_resource_by_content('04準備升學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberFive'] = $this->MenuModel->get_no_resource_by_content('05準備或正在找工作', 'youth')->no;
            $surveyTypeData['surveyTypeNumberSix'] = $this->MenuModel->get_no_resource_by_content('06參加職訓', 'youth')->no;
            $surveyTypeData['surveyTypeNumberSeven'] = $this->MenuModel->get_no_resource_by_content('07家務勞動', 'youth')->no;
            $surveyTypeData['surveyTypeNumberEight'] = $this->MenuModel->get_no_resource_by_content('08健康因素', 'youth')->no;
            $surveyTypeData['surveyTypeNumberNine'] = $this->MenuModel->get_no_resource_by_content('09尚未規劃', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTen'] = $this->MenuModel->get_no_resource_by_content('10失聯', 'youth')->no;
            $surveyTypeData['surveyTypeNumberEleven'] = $this->MenuModel->get_no_resource_by_content('11自學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelve'] = $this->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產、社福機構安置、轉學待追蹤等)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveOne'] = $this->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveTwo'] = $this->MenuModel->get_no_resource_by_content('12其他動向(社福機構安置)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveThree'] = $this->MenuModel->get_no_resource_by_content('12其他動向(轉學)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteen'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(去世、司法問題、出國)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenOne'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(去世)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenTwo'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(司法問題)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenThree'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(出國)', 'youth')->no;

            $surveyTypeData['county'] = $countyType;
            $surveyTypeData['yearType'] = $yearType - 2;
            $surveyTypeNowYearsCounts = $this->ReportModel->get_survey_type_by_county($surveyTypeData);

            $beSentDataset['surveyTypes'] = $surveyTypes;
            $beSentDataset['surveyTypeNowYearsCounts'] = $surveyTypeNowYearsCounts;
        }

        if ($reportType == 'surveyTypeHighSchoolTrack' || $reportType == 'all') {

          $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $yearType - 4, null);
          $trackData = $this->ReportModel->get_seasonal_review_by_county($surveyTypeData);
          $sumDetail = get_seasonal_review_sum($trackData);
          $tableValue = get_seasonal_review_table($trackData);
        
          if ($countyType == 'all') $counties = $this->CountyModel->get_all();
          else $counties = $this->CountyModel->get_one($countyType);
          
          $note = $this->ReportModel->get_seasonal_review_note_by_county($surveyTypeData);
          $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

          $beSentDataset['noteDetail'] = $noteDetailArray;
          $beSentDataset['valueSum'] = $sumDetail;
          $beSentDataset['value'] = $tableValue;
        }

        if ($reportType == 'surveyTypeTwoYearsTrack' || $reportType == 'all') {

          $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $yearType - 4, null);
          $trackData = $this->ReportModel->get_seasonal_review_by_county($surveyTypeData);
          $sumDetail = get_seasonal_review_sum($trackData);
          $tableValue = get_seasonal_review_table($trackData);
        
          if ($countyType == 'all') $counties = $this->CountyModel->get_all();
          else $counties = $this->CountyModel->get_one($countyType);
          
          $note = $this->ReportModel->get_seasonal_review_note_by_county($surveyTypeData);
          $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

          $beSentDataset['noteDetail'] = $noteDetailArray;
          $beSentDataset['valueSum'] = $sumDetail;
          $beSentDataset['value'] = $tableValue;     
        }

        if ($reportType == 'surveyTypeOneYearsTrack' || $reportType == 'all') {

          $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $yearType - 3, null);
          $trackData = $this->ReportModel->get_seasonal_review_by_county($surveyTypeData);
          $sumDetail = get_seasonal_review_sum($trackData);
          $tableValue = get_seasonal_review_table($trackData);
        
          if ($countyType == 'all') $counties = $this->CountyModel->get_all();
          else $counties = $this->CountyModel->get_one($countyType);
          
          $note = $this->ReportModel->get_seasonal_review_note_by_county($surveyTypeData);
          $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

          $beSentDataset['noteDetail'] = $noteDetailArray;
          $beSentDataset['valueSum'] = $sumDetail;
          $beSentDataset['value'] = $tableValue;
        }

        if ($reportType == 'surveyTypeNowYearsTrack' || $reportType == 'all') {

          $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $yearType - 2, null);
          $trackData = $this->ReportModel->get_seasonal_review_by_county($surveyTypeData);
          $sumDetail = get_seasonal_review_sum($trackData);
          $tableValue = get_seasonal_review_table($trackData);
        
          if ($countyType == 'all') $counties = $this->CountyModel->get_all();
          else $counties = $this->CountyModel->get_one($countyType);
          
          $note = $this->ReportModel->get_seasonal_review_note_by_county($surveyTypeData);
          $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

          $beSentDataset['noteDetail'] = $noteDetailArray;
          $beSentDataset['valueSum'] = $sumDetail;
          $beSentDataset['value'] = $tableValue;
        }

        if ($reportType == 'surveyTypeOldCaseTrack' || $reportType == 'all') {

          $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $yearType - 1, null);
          $trackData = $this->ReportModel->get_old_case_seasonal_review_by_county($surveyTypeData);
          $sumDetail = get_seasonal_review_sum($trackData);
          $tableValue = get_seasonal_review_table($trackData);
        
          if ($countyType == 'all') $counties = $this->CountyModel->get_all();
          else $counties = $this->CountyModel->get_one($countyType);
          
          $note = $this->ReportModel->get_old_case_seasonal_review_note_by_county($surveyTypeData);
          $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

          $beSentDataset['noteDetail'] = $noteDetailArray;
          $beSentDataset['valueSum'] = $sumDetail;
          $beSentDataset['value'] = $tableValue;
        }

        if ($reportType == 'counselEffection' || $reportType == 'all') {
          $surveyTypeData = [];
          $surveyTypeData['schoolSource'] = $this->MenuModel->get_no_resource_by_content('動向調查', 'youth')->no;
          $surveyTypeData['referralSource'] = $this->MenuModel->get_no_resource_by_content('轉介或自行開發', 'youth')->no;
          $surveyTypeData['highSource'] = $this->MenuModel->get_no_resource_by_content('高中已錄取未註冊', 'youth')->no;
          $counselEffectionCounts = $this->ReportModel->get_counsel_effection_by_county($countyType, $yearType, $surveyTypeData);
          $beSentDataset['counselEffectionCounts'] = $counselEffectionCounts;

          $trendMemberArray = get_end_case_track_youth($countyType);
           
          $beSentDataset['trendMemberArray'] = $trendMemberArray;
      }

        if ($reportType == 'counselEffectionIndividual' || $reportType == 'all') {

            $data = [];
            $data['phoneService'] = $this->MenuModel->get_no_resource_by_content('電訪', 'individual_counseling')->no;
            $data['personallyService'] = $this->MenuModel->get_no_resource_by_content('親訪', 'individual_counseling')->no;
            $data['internetService'] = $this->MenuModel->get_no_resource_by_content('網路', 'individual_counseling')->no;
            $data['educationService'] = $this->MenuModel->get_no_resource_by_content('教育資源', 'individual_counseling')->no;
            $data['laborService'] = $this->MenuModel->get_no_resource_by_content('勞政資源', 'individual_counseling')->no;
            $data['socialService'] = $this->MenuModel->get_no_resource_by_content('社政資源', 'individual_counseling')->no;
            $data['healthService'] = $this->MenuModel->get_no_resource_by_content('衛政資源', 'individual_counseling')->no;
            $data['officeService'] = $this->MenuModel->get_no_resource_by_content('警政資源', 'individual_counseling')->no;
            $data['judicialService'] = $this->MenuModel->get_no_resource_by_content('司法資源', 'individual_counseling')->no;
            $data['otherService'] = $this->MenuModel->get_no_resource_by_content('其他資源', 'individual_counseling')->no;

            $data['county'] = $countyType;
            $data['yearType'] = $yearType;
            $counselEffectionIndividual = $this->ReportModel->get_individual_counseling_report_by_county($data);

            $beSentDataset['counselEffectionIndividual'] = $counselEffectionIndividual;
        }

        if ($reportType == 'counselEffectionGroup' || $reportType == 'all') {

            $data = [];
            $data['exploreService'] = $this->MenuModel->get_no_resource_by_content('生涯探索', 'group_counseling')->no;
            $data['interactiveService'] = $this->MenuModel->get_no_resource_by_content('人際溝通與互動', 'group_counseling')->no;
            $data['experienceService'] = $this->MenuModel->get_no_resource_by_content('體驗教育', 'group_counseling')->no;
            $data['environmentService'] = $this->MenuModel->get_no_resource_by_content('環境教育', 'group_counseling')->no;
            $data['judicialService'] = $this->MenuModel->get_no_resource_by_content('法治教育', 'group_counseling')->no;
            $data['genderService'] = $this->MenuModel->get_no_resource_by_content('性別平等教育', 'group_counseling')->no;
            $data['professionService'] = $this->MenuModel->get_no_resource_by_content('職業訓練', 'group_counseling')->no;
            $data['volunteerService'] = $this->MenuModel->get_no_resource_by_content('志願服務', 'group_counseling')->no;
            $data['otherService'] = $this->MenuModel->get_no_resource_by_content('其他', 'group_counseling')->no;

            $data['county'] = $countyType;
            $data['yearType'] = $yearType;
            $counselEffectionGroup = $this->ReportModel->get_group_counseling_report_by_county($data);

            $beSentDataset['counselEffectionGroup'] = $counselEffectionGroup;
        }

        if ($reportType == 'counselEffectionCourse' || $reportType == 'all') {

            $data = [];
            $data['exploreCourse'] = $this->MenuModel->get_no_resource_by_content('生涯探索與就業力培訓', 'course_reference')->no;
            $data['experienceCourse'] = $this->MenuModel->get_no_resource_by_content('體驗教育及志願服務', 'course_reference')->no;
            $data['officeCourse'] = $this->MenuModel->get_no_resource_by_content('法治(含反毒)及性別平等教育', 'course_reference')->no;
            $data['otherCourse'] = $this->MenuModel->get_no_resource_by_content('其他及彈性運用', 'course_reference')->no;

            $data['county'] = $countyType;
            $data['yearType'] = $yearType;
            $counselEffectionCourse = $this->ReportModel->get_course_report_by_county($data);

            $beSentDataset['counselEffectionCourse'] = $counselEffectionCourse;
        }

        if ($reportType == 'counselEffectionWork' || $reportType == 'all') {

            $data = [];
            $data['farmWork'] = $this->MenuModel->get_no_resource_by_content('農、林、漁、牧業', 'company')->no;
            $data['miningWork'] = $this->MenuModel->get_no_resource_by_content('礦業及土石採取業', 'company')->no;
            $data['manufacturingWork'] = $this->MenuModel->get_no_resource_by_content('製造業', 'company')->no;
            $data['electricityWork'] = $this->MenuModel->get_no_resource_by_content('電力及燃氣供應業', 'company')->no;
            $data['waterWork'] = $this->MenuModel->get_no_resource_by_content('用水供應及污染整治業', 'company')->no;
            $data['buildWork'] = $this->MenuModel->get_no_resource_by_content('營建工程業', 'company')->no;
            $data['wholesaleWork'] = $this->MenuModel->get_no_resource_by_content('批發及零售業', 'company')->no;
            $data['transportWork'] = $this->MenuModel->get_no_resource_by_content('運輸及倉儲業', 'company')->no;
            $data['hotelWork'] = $this->MenuModel->get_no_resource_by_content('住宿及餐飲業', 'company')->no;
            $data['publishWork'] = $this->MenuModel->get_no_resource_by_content('出版、影音製作、傳播及資通訊服務業', 'company')->no;
            $data['financialWork'] = $this->MenuModel->get_no_resource_by_content('金融及保險業', 'company')->no;
            $data['immovablesWork'] = $this->MenuModel->get_no_resource_by_content('不動產業', 'company')->no;
            $data['scienceWork'] = $this->MenuModel->get_no_resource_by_content('專業、科學及技術服務業', 'company')->no;
            $data['supportWork'] = $this->MenuModel->get_no_resource_by_content('支援服務業', 'company')->no;
            $data['militaryWork'] = $this->MenuModel->get_no_resource_by_content('公共行政及國防；強制性社會安全', 'company')->no;
            $data['educationWork'] = $this->MenuModel->get_no_resource_by_content('教育業', 'company')->no;
            $data['hospitalWork'] = $this->MenuModel->get_no_resource_by_content('醫療保健及社會工作服務業', 'company')->no;
            $data['artWork'] = $this->MenuModel->get_no_resource_by_content('藝術、娛樂及休閒服務業', 'company')->no;
            $data['otherWork'] = $this->MenuModel->get_no_resource_by_content('其他服務業', 'company')->no;

            $data['county'] = $countyType;
            $data['yearType'] = $yearType;
            $counselEffectionWork = $this->ReportModel->get_work_report_by_county($data);

            $beSentDataset['counselEffectionWork'] = $counselEffectionWork;
        }

        if ($reportType == 'counselEffectionMeeting' || $reportType == 'all') {

            $data = [];
            $data['meetingType'] = $this->MenuModel->get_no_resource_by_content('跨局處會議', 'meeting')->no;
            $data['activityType'] = $this->MenuModel->get_no_resource_by_content('預防性講座', 'meeting')->no;

            $data['county'] = $countyType;
            $data['yearType'] = $yearType;
            $counselEffectionMeeting = $this->ReportModel->get_meeting_report_by_county($data);

            $beSentDataset['counselEffectionMeeting'] = $counselEffectionMeeting;
        }

        if ($reportType == 'countyDelegateOrganization' || $reportType == 'all') {
            $countyDelegateOrganizations = $this->ReportModel->get_county_delegate_organization($countyType, $yearType);
            $executeModes = $this->MenuModel->get_by_form_and_column('project', 'execute_mode');
            $executeWays = $this->MenuModel->get_by_form_and_column('project', 'execute_way');
            $beSentDataset['executeModes'] = $executeModes;
            $beSentDataset['executeWays'] = $executeWays;
            $beSentDataset['countyDelegateOrganizations'] = $countyDelegateOrganizations;
        }

        if ($reportType == 'memberCounseling' || $reportType == 'all') {
            $memberCounselingData = [];
            $memberCounselingData['educationSourceNumber'] = $this->MenuModel->get_referral_resource_by_content('教育資源')->no;
            $memberCounselingData['laborSourceNumber'] = $this->MenuModel->get_referral_resource_by_content('勞政資源')->no;
            $memberCounselingData['socialSourceNumber'] = $this->MenuModel->get_referral_resource_by_content('社政資源')->no;
            $memberCounselingData['healthSourceNumber'] = $this->MenuModel->get_referral_resource_by_content('衛政資源')->no;
            $memberCounselingData['officeSourceNumber'] = $this->MenuModel->get_referral_resource_by_content('警政資源')->no;
            $memberCounselingData['judicialSourceNumber'] = $this->MenuModel->get_referral_resource_by_content('司法資源')->no;
            $memberCounselingData['otherSourceNumber'] = $this->MenuModel->get_referral_resource_by_content('其他資源')->no;
            $memberCounselingData['countyDelegateOrganizations'] = $this->ReportModel->get_county_delegate_organization($countyType, $yearType);
            $memberCounselingData['organization'] = $organization;
            $memberCounselingData['yearType'] = $yearType;

            $memberCounselings = $this->ReportModel->get_member_counseling($memberCounselingData);

            $beSentDataset['memberCounselings'] = $memberCounselings;
        }
        $this->load->view('report/organization_report_table', $beSentDataset);
    }

    public function counselor_report_table($reportType = 'memberCounseling', $yearType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(6);
        $countyType = $passport['county'];
        $organization = $passport['organization'];
        $counselor = $passport['counselor'];

        valid_roles($accept_role);

        if ($yearType == null) {
            $yearType = date("Y") - 1911;
        }

        if ($reportType == null) {
            $reportType = ' ';
        }

        $counties = $this->CountyModel->get_all();
        $years = $this->YouthModel->get_distinct_years();

        $beSentDataset = array(
            'title' => '輔導員即時數據統計',
            'url' => '/report/counselor_report_table/',
            'role' => $current_role,
            'reportType' => $reportType,
            'counties' => $counties,
            'countyType' => $countyType,
            'yearType' => $yearType,
            'years' => $years,
            'userTitle' => $userTitle,
            'password' => $passport['password'],
            'updatePwd' => $passport['updatePwd']
        );

        if ($reportType == 'surveyTypeTwoYears' || $reportType == 'all') {
            $surveyTypes = $this->MenuModel->get_by_form_and_column('youth', 'survey_type');
            $surveyTypeData = [];
            $surveyTypeData['surveyTypeNumberOne'] = $this->MenuModel->get_no_resource_by_content('01已就業', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwo'] = $this->MenuModel->get_no_resource_by_content('02已就學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThree'] = $this->MenuModel->get_no_resource_by_content('03特教生', 'youth')->no;
            $surveyTypeData['surveyTypeNumberFour'] = $this->MenuModel->get_no_resource_by_content('04準備升學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberFive'] = $this->MenuModel->get_no_resource_by_content('05準備或正在找工作', 'youth')->no;
            $surveyTypeData['surveyTypeNumberSix'] = $this->MenuModel->get_no_resource_by_content('06參加職訓', 'youth')->no;
            $surveyTypeData['surveyTypeNumberSeven'] = $this->MenuModel->get_no_resource_by_content('07家務勞動', 'youth')->no;
            $surveyTypeData['surveyTypeNumberEight'] = $this->MenuModel->get_no_resource_by_content('08健康因素', 'youth')->no;
            $surveyTypeData['surveyTypeNumberNine'] = $this->MenuModel->get_no_resource_by_content('09尚未規劃', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTen'] = $this->MenuModel->get_no_resource_by_content('10失聯', 'youth')->no;
            $surveyTypeData['surveyTypeNumberEleven'] = $this->MenuModel->get_no_resource_by_content('11自學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelve'] = $this->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產、社福機構安置、轉學待追蹤等)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveOne'] = $this->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveTwo'] = $this->MenuModel->get_no_resource_by_content('12其他動向(社福機構安置)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveThree'] = $this->MenuModel->get_no_resource_by_content('12其他動向(轉學)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteen'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(去世、司法問題、出國)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenOne'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(去世)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenTwo'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(司法問題)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenThree'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(出國)', 'youth')->no;

            $surveyTypeData['county'] = $countyType;
            $surveyTypeData['yearType'] = $yearType - 4;
            $surveyTypeTwoYearsCounts = $this->ReportModel->get_survey_type_by_county($surveyTypeData);

            $beSentDataset['surveyTypes'] = $surveyTypes;
            $beSentDataset['surveyTypeTwoYearsCounts'] = $surveyTypeTwoYearsCounts;
        }

        if ($reportType == 'surveyTypeOneYears' || $reportType == 'all') {
            $surveyTypes = $this->MenuModel->get_by_form_and_column('youth', 'survey_type');
            $surveyTypeData = [];
            $surveyTypeData['surveyTypeNumberOne'] = $this->MenuModel->get_no_resource_by_content('01已就業', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwo'] = $this->MenuModel->get_no_resource_by_content('02已就學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThree'] = $this->MenuModel->get_no_resource_by_content('03特教生', 'youth')->no;
            $surveyTypeData['surveyTypeNumberFour'] = $this->MenuModel->get_no_resource_by_content('04準備升學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberFive'] = $this->MenuModel->get_no_resource_by_content('05準備或正在找工作', 'youth')->no;
            $surveyTypeData['surveyTypeNumberSix'] = $this->MenuModel->get_no_resource_by_content('06參加職訓', 'youth')->no;
            $surveyTypeData['surveyTypeNumberSeven'] = $this->MenuModel->get_no_resource_by_content('07家務勞動', 'youth')->no;
            $surveyTypeData['surveyTypeNumberEight'] = $this->MenuModel->get_no_resource_by_content('08健康因素', 'youth')->no;
            $surveyTypeData['surveyTypeNumberNine'] = $this->MenuModel->get_no_resource_by_content('09尚未規劃', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTen'] = $this->MenuModel->get_no_resource_by_content('10失聯', 'youth')->no;
            $surveyTypeData['surveyTypeNumberEleven'] = $this->MenuModel->get_no_resource_by_content('11自學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelve'] = $this->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產、社福機構安置、轉學待追蹤等)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveOne'] = $this->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveTwo'] = $this->MenuModel->get_no_resource_by_content('12其他動向(社福機構安置)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveThree'] = $this->MenuModel->get_no_resource_by_content('12其他動向(轉學)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteen'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(去世、司法問題、出國)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenOne'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(去世)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenTwo'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(司法問題)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenThree'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(出國)', 'youth')->no;

            $surveyTypeData['county'] = $countyType;
            $surveyTypeData['yearType'] = $yearType - 3;
            $surveyTypeOneYearsCounts = $this->ReportModel->get_survey_type_by_county($surveyTypeData);

            $beSentDataset['surveyTypes'] = $surveyTypes;
            $beSentDataset['surveyTypeOneYearsCounts'] = $surveyTypeOneYearsCounts;
        }

        if ($reportType == 'surveyTypeNowYears' || $reportType == 'all') {
            $surveyTypes = $this->MenuModel->get_by_form_and_column('youth', 'survey_type');
            $surveyTypeData = [];
            $surveyTypeData['surveyTypeNumberOne'] = $this->MenuModel->get_no_resource_by_content('01已就業', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwo'] = $this->MenuModel->get_no_resource_by_content('02已就學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThree'] = $this->MenuModel->get_no_resource_by_content('03特教生', 'youth')->no;
            $surveyTypeData['surveyTypeNumberFour'] = $this->MenuModel->get_no_resource_by_content('04準備升學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberFive'] = $this->MenuModel->get_no_resource_by_content('05準備或正在找工作', 'youth')->no;
            $surveyTypeData['surveyTypeNumberSix'] = $this->MenuModel->get_no_resource_by_content('06參加職訓', 'youth')->no;
            $surveyTypeData['surveyTypeNumberSeven'] = $this->MenuModel->get_no_resource_by_content('07家務勞動', 'youth')->no;
            $surveyTypeData['surveyTypeNumberEight'] = $this->MenuModel->get_no_resource_by_content('08健康因素', 'youth')->no;
            $surveyTypeData['surveyTypeNumberNine'] = $this->MenuModel->get_no_resource_by_content('09尚未規劃', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTen'] = $this->MenuModel->get_no_resource_by_content('10失聯', 'youth')->no;
            $surveyTypeData['surveyTypeNumberEleven'] = $this->MenuModel->get_no_resource_by_content('11自學', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelve'] = $this->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產、社福機構安置、轉學待追蹤等)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveOne'] = $this->MenuModel->get_no_resource_by_content('12其他動向(懷孕待產)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveTwo'] = $this->MenuModel->get_no_resource_by_content('12其他動向(社福機構安置)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberTwelveThree'] = $this->MenuModel->get_no_resource_by_content('12其他動向(轉學)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteen'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(去世、司法問題、出國)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenOne'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(去世)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenTwo'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(司法問題)', 'youth')->no;
            $surveyTypeData['surveyTypeNumberThirteenThree'] = $this->MenuModel->get_no_resource_by_content('13不可抗力(出國)', 'youth')->no;

            $surveyTypeData['county'] = $countyType;
            $surveyTypeData['yearType'] = $yearType - 2;
            $surveyTypeNowYearsCounts = $this->ReportModel->get_survey_type_by_county($surveyTypeData);

            $beSentDataset['surveyTypes'] = $surveyTypes;
            $beSentDataset['surveyTypeNowYearsCounts'] = $surveyTypeNowYearsCounts;
        }

        if ($reportType == 'surveyTypeHighSchoolTrack' || $reportType == 'all') {

          $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $yearType - 4, null);
          $trackData = $this->ReportModel->get_seasonal_review_by_county($surveyTypeData);
          $sumDetail = get_seasonal_review_sum($trackData);
          $tableValue = get_seasonal_review_table($trackData);
        
          if ($countyType == 'all') $counties = $this->CountyModel->get_all();
          else $counties = $this->CountyModel->get_one($countyType);
          
          $note = $this->ReportModel->get_seasonal_review_note_by_county($surveyTypeData);
          $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

          $beSentDataset['noteDetail'] = $noteDetailArray;
          $beSentDataset['valueSum'] = $sumDetail;
          $beSentDataset['value'] = $tableValue;
        }

        if ($reportType == 'surveyTypeTwoYearsTrack' || $reportType == 'all') {

          $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $yearType - 4, null);
          $trackData = $this->ReportModel->get_seasonal_review_by_county($surveyTypeData);
          $sumDetail = get_seasonal_review_sum($trackData);
          $tableValue = get_seasonal_review_table($trackData);
        
          if ($countyType == 'all') $counties = $this->CountyModel->get_all();
          else $counties = $this->CountyModel->get_one($countyType);
          
          $note = $this->ReportModel->get_seasonal_review_note_by_county($surveyTypeData);
          $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

          $beSentDataset['noteDetail'] = $noteDetailArray;
          $beSentDataset['valueSum'] = $sumDetail;
          $beSentDataset['value'] = $tableValue;     
        }

        if ($reportType == 'surveyTypeOneYearsTrack' || $reportType == 'all') {

          $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $yearType - 3, null);
          $trackData = $this->ReportModel->get_seasonal_review_by_county($surveyTypeData);
          $sumDetail = get_seasonal_review_sum($trackData);
          $tableValue = get_seasonal_review_table($trackData);
        
          if ($countyType == 'all') $counties = $this->CountyModel->get_all();
          else $counties = $this->CountyModel->get_one($countyType);
          
          $note = $this->ReportModel->get_seasonal_review_note_by_county($surveyTypeData);
          $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

          $beSentDataset['noteDetail'] = $noteDetailArray;
          $beSentDataset['valueSum'] = $sumDetail;
          $beSentDataset['value'] = $tableValue;
        }

        if ($reportType == 'surveyTypeNowYearsTrack' || $reportType == 'all') {

          $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $yearType - 2, null);
          $trackData = $this->ReportModel->get_seasonal_review_by_county($surveyTypeData);
          $sumDetail = get_seasonal_review_sum($trackData);
          $tableValue = get_seasonal_review_table($trackData);
        
          if ($countyType == 'all') $counties = $this->CountyModel->get_all();
          else $counties = $this->CountyModel->get_one($countyType);
          
          $note = $this->ReportModel->get_seasonal_review_note_by_county($surveyTypeData);
          $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

          $beSentDataset['noteDetail'] = $noteDetailArray;
          $beSentDataset['valueSum'] = $sumDetail;
          $beSentDataset['value'] = $tableValue;
        }

        if ($reportType == 'surveyTypeOldCaseTrack' || $reportType == 'all') {

          $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $yearType - 1, null);
          $trackData = $this->ReportModel->get_old_case_seasonal_review_by_county($surveyTypeData);
          $sumDetail = get_seasonal_review_sum($trackData);
          $tableValue = get_seasonal_review_table($trackData);
        
          if ($countyType == 'all') $counties = $this->CountyModel->get_all();
          else $counties = $this->CountyModel->get_one($countyType);
          
          $note = $this->ReportModel->get_old_case_seasonal_review_note_by_county($surveyTypeData);
          $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

          $beSentDataset['noteDetail'] = $noteDetailArray;
          $beSentDataset['valueSum'] = $sumDetail;
          $beSentDataset['value'] = $tableValue;
        }

        if ($reportType == 'counselEffection' || $reportType == 'all') {
          $surveyTypeData = [];
          $surveyTypeData['schoolSource'] = $this->MenuModel->get_no_resource_by_content('動向調查', 'youth')->no;
          $surveyTypeData['referralSource'] = $this->MenuModel->get_no_resource_by_content('轉介或自行開發', 'youth')->no;
          $surveyTypeData['highSource'] = $this->MenuModel->get_no_resource_by_content('高中已錄取未註冊', 'youth')->no;
          $counselEffectionCounts = $this->ReportModel->get_counsel_effection_by_county($countyType, $yearType, $surveyTypeData);
          $beSentDataset['counselEffectionCounts'] = $counselEffectionCounts;

          $trendMemberArray = get_end_case_track_youth($countyType);
          $beSentDataset['trendMemberArray'] = $trendMemberArray;
      }

        if ($reportType == 'counselEffectionIndividual' || $reportType == 'all') {

            $data = [];
            $data['phoneService'] = $this->MenuModel->get_no_resource_by_content('電訪', 'individual_counseling')->no;
            $data['personallyService'] = $this->MenuModel->get_no_resource_by_content('親訪', 'individual_counseling')->no;
            $data['internetService'] = $this->MenuModel->get_no_resource_by_content('網路', 'individual_counseling')->no;
            $data['educationService'] = $this->MenuModel->get_no_resource_by_content('教育資源', 'individual_counseling')->no;
            $data['laborService'] = $this->MenuModel->get_no_resource_by_content('勞政資源', 'individual_counseling')->no;
            $data['socialService'] = $this->MenuModel->get_no_resource_by_content('社政資源', 'individual_counseling')->no;
            $data['healthService'] = $this->MenuModel->get_no_resource_by_content('衛政資源', 'individual_counseling')->no;
            $data['officeService'] = $this->MenuModel->get_no_resource_by_content('警政資源', 'individual_counseling')->no;
            $data['judicialService'] = $this->MenuModel->get_no_resource_by_content('司法資源', 'individual_counseling')->no;
            $data['otherService'] = $this->MenuModel->get_no_resource_by_content('其他資源', 'individual_counseling')->no;

            $data['county'] = $countyType;
            $data['yearType'] = $yearType;
            $counselEffectionIndividual = $this->ReportModel->get_individual_counseling_report_by_county($data);

            $beSentDataset['counselEffectionIndividual'] = $counselEffectionIndividual;
        }

        if ($reportType == 'counselEffectionGroup' || $reportType == 'all') {

            $data = [];
            $data['exploreService'] = $this->MenuModel->get_no_resource_by_content('生涯探索', 'group_counseling')->no;
            $data['interactiveService'] = $this->MenuModel->get_no_resource_by_content('人際溝通與互動', 'group_counseling')->no;
            $data['experienceService'] = $this->MenuModel->get_no_resource_by_content('體驗教育', 'group_counseling')->no;
            $data['environmentService'] = $this->MenuModel->get_no_resource_by_content('環境教育', 'group_counseling')->no;
            $data['judicialService'] = $this->MenuModel->get_no_resource_by_content('法治教育', 'group_counseling')->no;
            $data['genderService'] = $this->MenuModel->get_no_resource_by_content('性別平等教育', 'group_counseling')->no;
            $data['professionService'] = $this->MenuModel->get_no_resource_by_content('職業訓練', 'group_counseling')->no;
            $data['volunteerService'] = $this->MenuModel->get_no_resource_by_content('志願服務', 'group_counseling')->no;
            $data['otherService'] = $this->MenuModel->get_no_resource_by_content('其他', 'group_counseling')->no;

            $data['county'] = $countyType;
            $data['yearType'] = $yearType;
            $counselEffectionGroup = $this->ReportModel->get_group_counseling_report_by_county($data);

            $beSentDataset['counselEffectionGroup'] = $counselEffectionGroup;
        }

        if ($reportType == 'counselEffectionCourse' || $reportType == 'all') {

            $data = [];
            $data['exploreCourse'] = $this->MenuModel->get_no_resource_by_content('生涯探索與就業力培訓', 'course_reference')->no;
            $data['experienceCourse'] = $this->MenuModel->get_no_resource_by_content('體驗教育及志願服務', 'course_reference')->no;
            $data['officeCourse'] = $this->MenuModel->get_no_resource_by_content('法治(含反毒)及性別平等教育', 'course_reference')->no;
            $data['otherCourse'] = $this->MenuModel->get_no_resource_by_content('其他及彈性運用', 'course_reference')->no;

            $data['county'] = $countyType;
            $data['yearType'] = $yearType;
            $counselEffectionCourse = $this->ReportModel->get_course_report_by_county($data);

            $beSentDataset['counselEffectionCourse'] = $counselEffectionCourse;
        }

        if ($reportType == 'counselEffectionWork' || $reportType == 'all') {

            $data = [];
            $data['farmWork'] = $this->MenuModel->get_no_resource_by_content('農、林、漁、牧業', 'company')->no;
            $data['miningWork'] = $this->MenuModel->get_no_resource_by_content('礦業及土石採取業', 'company')->no;
            $data['manufacturingWork'] = $this->MenuModel->get_no_resource_by_content('製造業', 'company')->no;
            $data['electricityWork'] = $this->MenuModel->get_no_resource_by_content('電力及燃氣供應業', 'company')->no;
            $data['waterWork'] = $this->MenuModel->get_no_resource_by_content('用水供應及污染整治業', 'company')->no;
            $data['buildWork'] = $this->MenuModel->get_no_resource_by_content('營建工程業', 'company')->no;
            $data['wholesaleWork'] = $this->MenuModel->get_no_resource_by_content('批發及零售業', 'company')->no;
            $data['transportWork'] = $this->MenuModel->get_no_resource_by_content('運輸及倉儲業', 'company')->no;
            $data['hotelWork'] = $this->MenuModel->get_no_resource_by_content('住宿及餐飲業', 'company')->no;
            $data['publishWork'] = $this->MenuModel->get_no_resource_by_content('出版、影音製作、傳播及資通訊服務業', 'company')->no;
            $data['financialWork'] = $this->MenuModel->get_no_resource_by_content('金融及保險業', 'company')->no;
            $data['immovablesWork'] = $this->MenuModel->get_no_resource_by_content('不動產業', 'company')->no;
            $data['scienceWork'] = $this->MenuModel->get_no_resource_by_content('專業、科學及技術服務業', 'company')->no;
            $data['supportWork'] = $this->MenuModel->get_no_resource_by_content('支援服務業', 'company')->no;
            $data['militaryWork'] = $this->MenuModel->get_no_resource_by_content('公共行政及國防；強制性社會安全', 'company')->no;
            $data['educationWork'] = $this->MenuModel->get_no_resource_by_content('教育業', 'company')->no;
            $data['hospitalWork'] = $this->MenuModel->get_no_resource_by_content('醫療保健及社會工作服務業', 'company')->no;
            $data['artWork'] = $this->MenuModel->get_no_resource_by_content('藝術、娛樂及休閒服務業', 'company')->no;
            $data['otherWork'] = $this->MenuModel->get_no_resource_by_content('其他服務業', 'company')->no;

            $data['county'] = $countyType;
            $data['yearType'] = $yearType;
            $counselEffectionWork = $this->ReportModel->get_work_report_by_county($data);

            $beSentDataset['counselEffectionWork'] = $counselEffectionWork;
        }

        if ($reportType == 'counselEffectionMeeting' || $reportType == 'all') {

            $data = [];
            $data['meetingType'] = $this->MenuModel->get_no_resource_by_content('跨局處會議', 'meeting')->no;
            $data['activityType'] = $this->MenuModel->get_no_resource_by_content('預防性講座', 'meeting')->no;

            $data['county'] = $countyType;
            $data['yearType'] = $yearType;
            $counselEffectionMeeting = $this->ReportModel->get_meeting_report_by_county($data);

            $beSentDataset['counselEffectionMeeting'] = $counselEffectionMeeting;
        }

        if ($reportType == 'countyDelegateOrganization' || $reportType == 'all') {
            $countyDelegateOrganizations = $this->ReportModel->get_county_delegate_organization($countyType, $yearType);
            $executeModes = $this->MenuModel->get_by_form_and_column('project', 'execute_mode');
            $executeWays = $this->MenuModel->get_by_form_and_column('project', 'execute_way');
            $beSentDataset['executeModes'] = $executeModes;
            $beSentDataset['executeWays'] = $executeWays;
            $beSentDataset['countyDelegateOrganizations'] = $countyDelegateOrganizations;
        }

        if ($reportType == 'memberCounseling' || $reportType == 'all') {
            $memberCounselingData = [];
            $memberCounselingData['educationSourceNumber'] = $this->MenuModel->get_referral_resource_by_content('教育資源')->no;
            $memberCounselingData['laborSourceNumber'] = $this->MenuModel->get_referral_resource_by_content('勞政資源')->no;
            $memberCounselingData['socialSourceNumber'] = $this->MenuModel->get_referral_resource_by_content('社政資源')->no;
            $memberCounselingData['healthSourceNumber'] = $this->MenuModel->get_referral_resource_by_content('衛政資源')->no;
            $memberCounselingData['officeSourceNumber'] = $this->MenuModel->get_referral_resource_by_content('警政資源')->no;
            $memberCounselingData['judicialSourceNumber'] = $this->MenuModel->get_referral_resource_by_content('司法資源')->no;
            $memberCounselingData['otherSourceNumber'] = $this->MenuModel->get_referral_resource_by_content('其他資源')->no;
            $memberCounselingData['countyDelegateOrganizations'] = $this->ReportModel->get_county_delegate_organization($countyType, $yearType);
            $memberCounselingData['counselor'] = $counselor;
            $memberCounselingData['yearType'] = $yearType;

            $memberCounselings = $this->ReportModel->get_member_counseling_by_counseler($memberCounselingData);

            $beSentDataset['memberCounselings'] = $memberCounselings;
        }
        $this->load->view('report/counselor_report_table', $beSentDataset);
    }

    public function counseling_member_count_report_table($yearType = null, $monthType = null, $countyType = '1')
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(1, 2, 3, 4, 5, 6, 8, 9);
        if (in_array($current_role, $accept_role)) {

            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }
            if ($monthType == null) {
                $monthType = date("m");
            }

            $county = $passport['county'] ? $passport['county'] : $countyType;
            $years = $countyType ? $this->ProjectModel->get_distinct_year_by_county($countyType) : $this->ProjectModel->get_distinct_year_by_county('1');
            $months = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');

            $counselingMemberCountReport = $this->CounselingMemberCountReportModel->get_no_by_county($county, $yearType, $monthType);
            $counselingMemberCountReportNo = empty($counselingMemberCountReport) ? null : $counselingMemberCountReport->no;
            $counselingMemberCountReportNo = empty($counselingMemberCountReportNo) ? null : $counselingMemberCountReportNo;

            $counselingMemberCountReportIsReview = empty($counselingMemberCountReport) ? null : $counselingMemberCountReport->is_review;
            $counselingMemberCountReportIsReview = empty($counselingMemberCountReportIsReview) ? 0 : $counselingMemberCountReportIsReview;

            $counselingMemberCountReportCompletion = $this->CompletionModel->get_rate_by_form_no('counseling_member_count_report', $counselingMemberCountReportNo);
            $counselingMemberCountReportCompletionRate = empty($counselingMemberCountReportCompletion) ? 0 : $counselingMemberCountReportCompletion->rate;

            $twoYearsTrendSurveyCountReports = $this->TwoYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);

            $twoYearsTrendSurveyCountReportNo = empty($twoYearsTrendSurveyCountReports) ? null : $twoYearsTrendSurveyCountReports->no;
            $twoYearsTrendSurveyCountReportNo = empty($twoYearsTrendSurveyCountReportNo) ? null : $twoYearsTrendSurveyCountReportNo;

            $twoYearsTrendSurveyCountReportCompletion = $this->CompletionModel->get_rate_by_form_no('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReportNo);
            $twoYearsTrendSurveyCountReportCompletionRate = empty($twoYearsTrendSurveyCountReportCompletion) ? 0 : $twoYearsTrendSurveyCountReportCompletion->rate;

            $twoYearsTrendSurveyCountReportIsReview = empty($twoYearsTrendSurveyCountReports) ? null : $twoYearsTrendSurveyCountReports->is_review;
            $twoYearsTrendSurveyCountReportIsReview = empty($twoYearsTrendSurveyCountReportIsReview) ? 0 : $twoYearsTrendSurveyCountReportIsReview;

            $oneYearsTrendSurveyCountReports = $this->OneYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);

            $oneYearsTrendSurveyCountReportNo = empty($oneYearsTrendSurveyCountReports) ? null : $oneYearsTrendSurveyCountReports->no;
            $oneYearsTrendSurveyCountReportNo = empty($oneYearsTrendSurveyCountReportNo) ? null : $oneYearsTrendSurveyCountReportNo;

            $oneYearsTrendSurveyCountReportCompletion = $this->CompletionModel->get_rate_by_form_no('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReportNo);
            $oneYearsTrendSurveyCountReportCompletionRate = empty($oneYearsTrendSurveyCountReportCompletion) ? 0 : $oneYearsTrendSurveyCountReportCompletion->rate;

            $oneYearsTrendSurveyCountReportIsReview = empty($oneYearsTrendSurveyCountReports) ? null : $oneYearsTrendSurveyCountReports->is_review;
            $oneYearsTrendSurveyCountReportIsReview = empty($oneYearsTrendSurveyCountReportIsReview) ? 0 : $oneYearsTrendSurveyCountReportIsReview;

            $nowYearsTrendSurveyCountReports = $this->NowYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);

            $nowYearsTrendSurveyCountReportNo = empty($nowYearsTrendSurveyCountReports) ? null : $nowYearsTrendSurveyCountReports->no;
            $nowYearsTrendSurveyCountReportNo = empty($nowYearsTrendSurveyCountReportNo) ? null : $nowYearsTrendSurveyCountReportNo;

            $nowYearsTrendSurveyCountReportCompletion = $this->CompletionModel->get_rate_by_form_no('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReportNo);
            $nowYearsTrendSurveyCountReportCompletionRate = empty($nowYearsTrendSurveyCountReportCompletion) ? 0 : $nowYearsTrendSurveyCountReportCompletion->rate;

            $nowYearsTrendSurveyCountReportIsReview = empty($nowYearsTrendSurveyCountReports) ? null : $nowYearsTrendSurveyCountReports->is_review;
            $nowYearsTrendSurveyCountReportIsReview = empty($nowYearsTrendSurveyCountReportIsReview) ? 0 : $nowYearsTrendSurveyCountReportIsReview;

            $oldCaseTrendSurveyCountReports = $this->OldCaseTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);

            $oldCaseTrendSurveyCountReportNo = empty($oldCaseTrendSurveyCountReports) ? null : $oldCaseTrendSurveyCountReports->no;
            $oldCaseTrendSurveyCountReportNo = empty($oldCaseTrendSurveyCountReportNo) ? null : $oldCaseTrendSurveyCountReportNo;

            $oldCaseTrendSurveyCountReportCompletion = $this->CompletionModel->get_rate_by_form_no('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReportNo);
            $oldCaseTrendSurveyCountReportCompletionRate = empty($oldCaseTrendSurveyCountReportCompletion) ? 0 : $oldCaseTrendSurveyCountReportCompletion->rate;

            $oldCaseTrendSurveyCountReportIsReview = empty($oldCaseTrendSurveyCountReports) ? null : $oldCaseTrendSurveyCountReports->is_review;
            $oldCaseTrendSurveyCountReportIsReview = empty($oldCaseTrendSurveyCountReportIsReview) ? 0 : $oldCaseTrendSurveyCountReportIsReview;

            $highSchoolTrendSurveyCountReports = $this->HighSchoolTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);

            $highSchoolTrendSurveyCountReportNo = empty($highSchoolTrendSurveyCountReports) ? null : $highSchoolTrendSurveyCountReports->no;
            $highSchoolTrendSurveyCountReportNo = empty($highSchoolTrendSurveyCountReportNo) ? null : $highSchoolTrendSurveyCountReportNo;

            $highSchoolTrendSurveyCountReportCompletion = $this->CompletionModel->get_rate_by_form_no('old_case_trend_survey_count_report', $highSchoolTrendSurveyCountReportNo);
            $highSchoolTrendSurveyCountReportCompletionRate = empty($highSchoolTrendSurveyCountReportCompletion) ? 0 : $highSchoolTrendSurveyCountReportCompletion->rate;

            $highSchoolTrendSurveyCountReportIsReview = empty($highSchoolTrendSurveyCountReports) ? null : $highSchoolTrendSurveyCountReports->is_review;
            $highSchoolTrendSurveyCountReportIsReview = empty($highSchoolTrendSurveyCountReportIsReview) ? 0 : $highSchoolTrendSurveyCountReportIsReview;

            $counselorManpowerReports = $this->CounselorManpowerReportModel->get_by_no($yearType, $monthType, $county);

            $counselorManpowerReportNo = empty($counselorManpowerReports) ? null : $counselorManpowerReports->no;
            $counselorManpowerReportNo = empty($counselorManpowerReportNo) ? null : $counselorManpowerReportNo;

            $counselorManpowerReportCompletion = $this->CompletionModel->get_rate_by_form_no('counselor_manpower_report', $counselorManpowerReportNo);
            $counselorManpowerReportCompletionRate = empty($counselorManpowerReportCompletion) ? 0 : $counselorManpowerReportCompletion->rate;

            $counselorManpowerReportIsReview = empty($counselorManpowerReports) ? null : $counselorManpowerReports->is_review;
            $counselorManpowerReportIsReview = empty($counselorManpowerReportIsReview) ? 0 : $counselorManpowerReportIsReview;

            $counselingIdentityCountReport = $this->CounselingIdentityCountReportModel->get_identity_no_by_county($county, $yearType, $monthType);
            $counselingIdentityCountReportNo = empty($counselingIdentityCountReport) ? null : $counselingIdentityCountReport->no;
            $counselingIdentityCountReportNo = empty($counselingIdentityCountReportNo) ? null : $counselingIdentityCountReportNo;

            $counselingIdentityCountReportCompletion = $this->CompletionModel->get_rate_by_form_no('counseling_identity_count_report', $counselingIdentityCountReportNo);
            $counselingIdentityCountReportCompletionRate = empty($counselingIdentityCountReportCompletion) ? 0 : $counselingIdentityCountReportCompletion->rate;

            $counselingIdentityCountReportIsReview = empty($counselingIdentityCountReport) ? null : $counselingIdentityCountReport->is_review;
            $counselingIdentityCountReportIsReview = empty($counselingIdentityCountReportIsReview) ? 0 : $counselingIdentityCountReportIsReview;

            $meetingCountReport = $this->CounselingMeetingCountReportModel->get_meeting_no_by_county($county, $yearType, $monthType);
            $meetingCountReportNo = empty($meetingCountReport) ? null : $meetingCountReport->no;
            $meetingCountReportNo = empty($meetingCountReportNo) ? null : $meetingCountReportNo;

            $meetingCountReportCompletion = $this->CompletionModel->get_rate_by_form_no('meeting_count_report', $meetingCountReportNo);
            $meetingCountReportCompletionRate = empty($meetingCountReportCompletion) ? 0 : $meetingCountReportCompletion->rate;

            $meetingCountReportIsReview = empty($meetingCountReport) ? null : $meetingCountReport->is_review;
            $meetingCountReportIsReview = empty($meetingCountReportIsReview) ? 0 : $meetingCountReportIsReview;

            $beSentDataset = array(
                'title' => '每月執行進度表清單',
                'url' => '/report/counseling_member_count_report_table/',
                'role' => $current_role,
                'years' => $years,
                'months' => $months,
                'yearType' => $yearType,
                'monthType' => $monthType,
                'countyType' => $county,
                'counselingMemberCountReportNo' => $counselingMemberCountReportNo,
                'counselingMemberCountReportIsReview' => $counselingMemberCountReportIsReview,
                'counselingMemberCountReportCompletionRate' => $counselingMemberCountReportCompletionRate,
                'twoYearsTrendSurveyCountReportCompletionRate' => $twoYearsTrendSurveyCountReportCompletionRate,
                'twoYearsTrendSurveyCountReportIsReview' => $twoYearsTrendSurveyCountReportIsReview,
                'oneYearsTrendSurveyCountReportCompletionRate' => $oneYearsTrendSurveyCountReportCompletionRate,
                'oneYearsTrendSurveyCountReportIsReview' => $oneYearsTrendSurveyCountReportIsReview,
                'nowYearsTrendSurveyCountReportCompletionRate' => $nowYearsTrendSurveyCountReportCompletionRate,
                'nowYearsTrendSurveyCountReportIsReview' => $nowYearsTrendSurveyCountReportIsReview,
                'oldCaseTrendSurveyCountReportCompletionRate' => $oldCaseTrendSurveyCountReportCompletionRate,
                'oldCaseTrendSurveyCountReportIsReview' => $oldCaseTrendSurveyCountReportIsReview,
                'highSchoolTrendSurveyCountReportCompletionRate' => $highSchoolTrendSurveyCountReportCompletionRate,
                'highSchoolTrendSurveyCountReportIsReview' => $highSchoolTrendSurveyCountReportIsReview,
                'counselorManpowerReportCompletionRate' => $counselorManpowerReportCompletionRate,
                'counselorManpowerReportIsReview' => $counselorManpowerReportIsReview,
                'counselingIdentityCountReportCompletionRate' => $counselingIdentityCountReportCompletionRate,
                'counselingIdentityCountReportIsReview' => $counselingIdentityCountReportIsReview,
                'meetingCountReportCompletionRate' => $meetingCountReportCompletionRate,
                'meetingCountReportIsReview' => $meetingCountReportIsReview,
                'userTitle' => $userTitle,
                'security' => $this->security,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            if ($current_role == 1) {
                $counties = $this->CountyModel->get_all();
                $beSentDataset['counties'] = $counties;
            }

            $this->load->view('report/counseling_member_count_report_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function counseling_member_count_report($yearType = null, $monthType = null)
    {
      $passport = $this->session->userdata('passport');
      $current_role = $passport['role'];
      $userTitle = $passport['userTitle'];
      $userId = $passport['id'];
      $county = $passport['county'];
      $organization = $passport['organization'];

      $accept_role = array(6);
      valid_roles($accept_role);

      $yearType = $yearType ? $yearType : date("Y") - 1911;
      $monthType = $monthType ? $monthType : date("m");
      
      $counties = $this->CountyModel->get_all();
      $counselingMemberCountReport = $this->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $county);
      
      $countyName = "";
      foreach ($counties as $value) {
        if ($value['no'] == $county) $countyName = $value['name'];
      }

      // 提案內容(計畫書)
      $projects = $this->ProjectModel->get_latest_by_county($county);
      $countyAndOrg = $this->CountyModel->get_by_county($county);    
      $executeModes = $this->MenuModel->get_by_form_and_column('project', 'execute_mode');
      $executeWays = $this->MenuModel->get_by_form_and_column('project', 'execute_way');

      /**
       * 輔導人數統計(青少年)
       * 來源 : 109高中已錄取未註冊與108國中動向調查(4-12類別)的青少年
       **/
      $surveyTypeData = get_seasonal_review_trend_menu_no($county, $yearType, null);
      $accumCounselingYouth = $this->ReportModel->report_one_get_seasonal_review_report_by_county($county, $yearType, $monthType);
      $surveyType = report_one_seasonal_review_table_value($surveyTypeData, $accumCounselingYouth);
    
      /**
       * 輔導人數統計(學員)
       * 來源 : 本年度開案學員與輔導員成效概況表----(old)
       * 來源 : 本年度開案學員與輔導員成效概況表(結案的學員也需要被記錄)----(new)
       **/
      // 累積輔導人數
      $accumCounselingMemberCount = $this->MemberModel->get_by_county_count($county, $monthType, $yearType);

      // 輔導成效統計(每月暫時性)
      $trendTypeData = get_end_case_trend_menu_no();
      $accumCounselingMember = $this->ReportModel->report_one_get_member_temp_report_by_county($county, $yearType, $monthType);
      $monthMemberTempCounselings = report_one_month_member_temp_counseling_table_value($trendTypeData, $accumCounselingMember);

      /**
       * 本年度輔導對象來源
       **/

      $members = $this->MemberModel->get_member_month($county, $yearType, $monthType);
      $memberData = [];
      $memberData['county'] = $county;
      $memberData['year'] = $yearType;
      $memberData['month'] = $monthType;
      $memberSourceData = report_one_member_source_table_value($memberData, $members);
        /**
       * 青少年應該追蹤人數 : 108動向調查(4-12)與109高中-(108&109開案)
       */
      $highSchoolYouth = $this->YouthModel->get_high_school_youth_by_county($county);
      $nowYearTrendYouth = $this->YouthModel->get_now_years_need_track_youth_by_county($county);
      $youthSum = count($highSchoolYouth) + count($nowYearTrendYouth) - count($memberSourceData['five']) - count($memberSourceData['seven']);

       /**
       * 辦理情形
       **/
      
      $memberCounselingCount = $this->ReportModel->get_member_counseling_by_county($county, $monthType, $yearType);

      /**
       * 簡述不可抗力及其他人數之原因，簡述參加職訓人數之單位及課程
       * 來源：輔導成效況表
       **/
      $monthMemberTempNote = $this->MonthMemberTempCounselingModel->get_by_county_and_month($county, $monthType, $yearType);
     
      $forceMajeureNoteOne = "[不可抗力]" . "\n";
      $forceMajeureNoteTwo = "[其他]" . "\n";
      $workTrainningNote = "[參加職訓]"  . "\n";
      foreach ($monthMemberTempNote as $value) {
        if ($value['trend'] == $trendTypeData['forceMajeureNumber']) $forceMajeureNoteOne = $forceMajeureNoteOne . $value['youthName'] . ": " . $value['trend_description'] . "\n";
        elseif ($value['trend'] == $trendTypeData['otherNumberFour']) $forceMajeureNoteTwo = $forceMajeureNoteTwo . $value['youthName'] . ": " . $value['trend_description'] . "\n";
        elseif ($value['trend'] == $trendTypeData['vocationalTrainingNumber']) $workTrainningNote = $workTrainningNote . $value['youthName'] . ": " . $value['trend_description'] . "\n";      
      }
      if($forceMajeureNoteOne == "[不可抗力]" . "\n") $forceMajeureNoteOne = $forceMajeureNoteOne . '無' . "\n";
      if($forceMajeureNoteTwo == "[其他]" . "\n") $forceMajeureNoteTwo = $forceMajeureNoteTwo . '無'. "\n";
      if($workTrainningNote == "[參加職訓]"  . "\n") $workTrainningNote = $workTrainningNote . '無'. "\n";
      $forceMajeureNote = $forceMajeureNoteOne . $forceMajeureNoteTwo;

      /**
       * 簡述生涯探索課程與工作體驗紀錄
       * 來源：課程與工作體驗紀錄
       **/
      $courses = $this->CourseModel->get_course_by_organization($organization, $yearType, $monthType);
      $courseDetail = "[課程紀錄]" . "\n";
      foreach ($courses as $value) {
        $courseDetail = $courseDetail . $value['course_name'] . '-' . $value['duration'] . ' 備註：' . $value['note'] . "\n";
      }
      if($courseDetail == "[課程紀錄]" . "\n") $courseDetail = $courseDetail . '無' . "\n";

      $works = $this->WorkAttendanceModel->get_work_by_organization($organization, $yearType, $monthType);
      $workDetail = "[工作體驗紀錄]" . "\n";
      $tempSystemNo = "";
      foreach ($works as $value) {
        $memberWork = $this->WorkAttendanceModel->get_work_by_member($value['memberNo'], $yearType, $monthType);
        $count = 1;  
        foreach($memberWork as $m) {    
          if($count == 1 ) $workDetail = $workDetail . $m['youthName'] . '-' . '工作體驗總時數 : ' . $value['sum'] . '  店家' . $count . '.' . $m['name'] . $m['sum'] . '小時' .' 備註：' . $m['note'] . "\n";
          else $workDetail = $workDetail . "&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;" . '店家' . $count . '.' . $m['name'] . $m['sum'] . '小時' .' 備註：' . $m['note'] . "\n";
          $count += 1;
        }
      }
      if($workDetail == "[工作體驗紀錄]" . "\n") $workDetail = $workDetail . '無' . "\n";
      /**
       * 執行金額
       * 預先帶入上一個月資料
       */
      if($monthType != 1) {
        $lastMonthData = $this->CounselingMemberCountReportModel->get_by_no($yearType, $monthType-1, $projects->no);
      }

      /**
       * 投保事項
       * 來源：投保紀錄
       **/
      $insurances = $this->InsuranceModel->get_by_organization($organization, $yearType, $monthType);
      $insuranceDetail = "[投保紀錄]" . "\n";
      foreach ($insurances as $value) {
        $insuranceDetail = $insuranceDetail . $value['name'] . '-' . $value['start_date'] . '-' . $value['end_date'] . "\n";
      }
      if($insuranceDetail == "[投保紀錄]" . "\n") $insuranceDetail = $insuranceDetail . '無' . "\n";

      $processReviewStatuses = $this->MenuModel->get_by_form_and_column('review_process', 'review_status');
      $logReviewStatuses = $this->MenuModel->get_by_form_and_column('review_log', 'review_status');
      $reviewStatus = [];   
      $reviewStatus['review_process_not_pass'] = $this->MenuModel->get_no_resource_by_content('未批准', 'review_process')->no;    
      $reviewStatus['review_process_pass'] = $this->MenuModel->get_no_resource_by_content('批准', 'review_process')->no;
      $reviewStatus['review_process_wait'] = $this->MenuModel->get_no_resource_by_content('等待送出', 'review_process')->no;
      $reportProcessesCounselor = $counselingMemberCountReport ? $this->ReviewProcessModel->get_by_counselor('counseling_member_count_report', $counselingMemberCountReport->no) : null;
      $reportProcessesCounselorStatus = $reportProcessesCounselor ? $reportProcessesCounselor->review_status : null;
      $reportLogs = $counselingMemberCountReport ? $this->ReviewLogModel->get_by_report_no('counseling_member_count_report', $counselingMemberCountReport->no) : null;

      $beSentDataset = array(
        'title' => '表一.輔導人數統計表/執行進度表',
        'url' => '/report/counseling_member_count_report/' . $yearType . '/' . $monthType,
        'role' => $current_role,
        'executeModes' => $executeModes,
        'executeWays' => $executeWays,
        'counties' => $counties,
        'county' => $county,
        'counselingMemberCountReport' => $counselingMemberCountReport,
        'userTitle' => $userTitle,
        'projects' => $projects,
        'countyAndOrg' => $countyAndOrg,
        'yearType' => $yearType,
        'monthType' => $monthType,
        'accumCounselingMemberCount' => $accumCounselingMemberCount,
        'monthMemberTempCounselings' => $monthMemberTempCounselings,
        'memberCounselingCount' => $memberCounselingCount,
        'forceMajeureNote' => $forceMajeureNote,
        'workTrainningNote' => $workTrainningNote,
        'password' => $passport['password'],
        'updatePwd' => $passport['updatePwd'],
        'security' => $this->security,
        'courseDetail' => $courseDetail,
        'workDetail' => $workDetail,
        'insuranceDetail' => $insuranceDetail,
        'reportProcessesCounselorStatus' => $reportProcessesCounselorStatus,
        'reviewStatus' => $reviewStatus,
        'reportLogs' => $reportLogs,
        'processReviewStatuses' => $processReviewStatuses,
        'surveyType' =>$surveyType,
        'memberSourceData' => $memberSourceData,
        'youthSum' => $youthSum,
        'lastMonthData' => $lastMonthData
      );

      $schoolYouth = $surveyType ? count($surveyType['two']) : 0;
      $workYouth = $surveyType ? count($surveyType['three']) : 0;
      $vocationalTrainingYouth = $surveyType ? count($surveyType['four']) : 0;
      $otherYouth = $surveyType ? count($surveyType['five']) : 0;
      $noPlanYouth = $surveyType ? count($surveyType['six']) : 0;
      $forceMajeureYouth = $surveyType ? count($surveyType['seven']) : 0;

      $schoolMember = $monthMemberTempCounselings ? count($monthMemberTempCounselings['two']) : 0;
      $workMember = $monthMemberTempCounselings ? count($monthMemberTempCounselings['three']) : 0;
      $vocationalTrainingMember = $monthMemberTempCounselings ? count($monthMemberTempCounselings['four']): 0;
      $otherMember = $monthMemberTempCounselings ? count($monthMemberTempCounselings['five']): 0;
      $noPlanMember = $monthMemberTempCounselings ? count($monthMemberTempCounselings['six']): 0;
      $forceMajeureMember = $monthMemberTempCounselings ? count($monthMemberTempCounselings['seven']): 0;

      $counselorNote = $this->security->xss_clean($this->input->post('counselor_note'));
      $newCaseMember = $memberSourceData ? count($memberSourceData['one']) : 0;
      $oldCaseMember = $memberSourceData ? count($memberSourceData['two']) : 0;
      $twoYearSurvryCaseMember = $memberSourceData ? count($memberSourceData['three']) : 0;
      $oneYearSurvryCaseMember = $memberSourceData ? count($memberSourceData['four']) : 0;
      $nowYearSurvryCaseMember = $memberSourceData ? count($memberSourceData['five']) : 0;
      $nextYearSurvryCaseMember = $memberSourceData ? count($memberSourceData['six']) : 0;
      $highSchoolSurvryCaseMember = $memberSourceData ? count($memberSourceData['seven']) : 0;

      $monthCounselingHour = $memberCounselingCount->individualCounselingCount + $memberCounselingCount->groupCounselingCount;
      $monthCourseHour = $memberCounselingCount->courseAttendanceCount;
      $monthWorkingHour = $memberCounselingCount->workAttendanceCount;
      $courseNote = $courseDetail;
      $forceMajeureNote = $forceMajeureNote;
      $workTrainningNote = $workTrainningNote;

      $workNote = $workDetail;
      $fundingExecute = $this->input->post('funding_execute') ? $this->security->xss_clean($this->input->post('funding_execute')) : 0;
      $otherNote = $this->security->xss_clean($this->input->post('other_note'));
      $insureNote = $insuranceDetail;

      if (empty($otherNote)) {
        return $this->load->view('report/counseling_member_count_report', $beSentDataset);
      }

      $counselingMemberCountReportArray = array($schoolYouth, $workYouth, $vocationalTrainingYouth, $otherYouth, $noPlanYouth, $forceMajeureYouth,
        $schoolMember, $workMember, $vocationalTrainingMember, $otherMember, $noPlanMember, $forceMajeureMember,
        $newCaseMember, $oldCaseMember, $twoYearSurvryCaseMember, $oneYearSurvryCaseMember, $nowYearSurvryCaseMember,
        $monthCounselingHour, $monthCourseHour, $monthWorkingHour, $courseNote, $forceMajeureNote, $workTrainningNote, $workNote,
        $fundingExecute, $otherNote, $insureNote, $monthType, $yearType, $projects->no);

      if ($counselingMemberCountReport) {
        $isExecuteSuccess = $this->CounselingMemberCountReportModel->update_one($schoolYouth, $workYouth, $vocationalTrainingYouth, $otherYouth, $noPlanYouth, $forceMajeureYouth,
          $schoolMember, $workMember, $vocationalTrainingMember, $otherMember, $noPlanMember, $forceMajeureMember,
          $counselorNote, $newCaseMember, $oldCaseMember, $twoYearSurvryCaseMember, $oneYearSurvryCaseMember, $nowYearSurvryCaseMember, $nextYearSurvryCaseMember, $highSchoolSurvryCaseMember,
          $monthCounselingHour, $monthCourseHour, $monthWorkingHour, $courseNote, $forceMajeureNote, $workTrainningNote, $workNote,
          $fundingExecute, $otherNote, $insureNote, $monthType, $yearType, $projects->no);
          
        $counselingMemberCountReportSuccess = completion_create_function('update', 'counseling_member_count_report', $counselingMemberCountReport->no, $counselingMemberCountReportArray);
      } else {
        $isExecuteSuccess = $this->CounselingMemberCountReportModel->create_one($schoolYouth, $workYouth, $vocationalTrainingYouth, $otherYouth, $noPlanYouth, $forceMajeureYouth,
          $schoolMember, $workMember, $vocationalTrainingMember, $otherMember, $noPlanMember, $forceMajeureMember,
          $counselorNote, $newCaseMember, $oldCaseMember, $twoYearSurvryCaseMember, $oneYearSurvryCaseMember, $nowYearSurvryCaseMember, $nextYearSurvryCaseMember, $highSchoolSurvryCaseMember,
          $monthCounselingHour, $monthCourseHour, $monthWorkingHour, $courseNote, $forceMajeureNote, $workTrainningNote, $workNote,
          $fundingExecute, $otherNote, $insureNote, $monthType, $yearType, $projects->no);

        $counselingMemberCountReportSuccess = completion_create_function('create', 'counseling_member_count_report', $isExecuteSuccess, $counselingMemberCountReportArray);
      }

      $counselingMemberCountReport = $this->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $county);
      $beSentDataset['counselingMemberCountReport'] = $counselingMemberCountReport;

      if ($isExecuteSuccess) {
          $beSentDataset['success'] = '新增成功';

          if (isset($_POST['save'])) {
              $reportProcesses = $this->ReviewProcessModel->get_by_report_no('counseling_member_count_report', $counselingMemberCountReport->no);
              if ($reportProcesses) {
                  $this->ReviewProcessModel->update_one('counseling_member_count_report', $counselingMemberCountReport->no, $reviewStatus['review_process_pass'], 6);
                  $this->ReviewProcessModel->update_one('counseling_member_count_report', $counselingMemberCountReport->no, $reviewStatus['review_process_wait'], 3);
              } else {
                  $this->ReviewProcessModel->create_one('counseling_member_count_report', $counselingMemberCountReport->no, $reviewStatus['review_process_pass'], 6);
                  $this->ReviewProcessModel->create_one('counseling_member_count_report', $counselingMemberCountReport->no, $reviewStatus['review_process_wait'], 3);
                  $this->ReviewProcessModel->create_one('counseling_member_count_report', $counselingMemberCountReport->no, $reviewStatus['review_process_not_pass'], 1);
              }
              $countyContractor = $this->UserModel->get_latest_county_contractor($county);
              $this->ReviewLogModel->create_one('counseling_member_count_report', $counselingMemberCountReport->no, $reviewStatus['review_process_pass'], null, $current_role, $userId);
              $this->ReviewLogModel->create_one('counseling_member_count_report', $counselingMemberCountReport->no, $reviewStatus['review_process_wait'], null, 3, $countyContractor->id);

              $countyContractor = $this->UserModel->get_by_county_contractor($county);
              $userName = $this->UserModel->get_name_by_id($userId)->name;

              $recipient = $countyContractor->email;
              $title = '【教育部青年發展署雙青計畫行政系統】輔導員繳交' . $yearType . '年' . $monthType .'月 輔導人數統計表/執行進度表通知';
              $content = '<p>' . $countyContractor->name . ' 君 您好:</p>'
              . '<p>' . $userName . '繳交' . $yearType . '年' . $monthType . '月 輔導人數統計表/執行進度表</p>'
              . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
              . '<p>祝 平安快樂</p><p></p>'
              . '<p>教育部青年發展署雙青計畫行政系統</p>'
              . '<p>' . date('Y-m-d') . '</p>'
                  . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

              //api_send_email_temp($recipient, $title, $content);

              $oldCaseAlert = $oldCaseMember / ($newCaseMember+$oldCaseMember) ;
              
              if($oldCaseAlert > 0.2) {
               
  
                //api_send_email_temp($recipient, $title, $content);
                $ydaUsers = $this->UserModel->get_yda_user();

                foreach($ydaUsers as $value) {
                  $data = array(
                    'title'      => email_title_oldcase_alert($countyName),
                    'email' =>  $value['email'],
                    'content'    => email_content_oldcase_alert($value['name'], $countyName, $oldCaseMember, $newCaseMember, $monthType)
                  );
                  api_send_email($data);            
                }
              }

              $reportProcessesCounselorStatus = $counselingMemberCountReport ? $this->ReviewProcessModel->get_by_counselor('counseling_member_count_report', $counselingMemberCountReport->no)->review_status : null;
              $reportLogs = $counselingMemberCountReport ? $this->ReviewLogModel->get_by_report_no('counseling_member_count_report', $counselingMemberCountReport->no) : null;
              $beSentDataset['reportProcessesCounselorStatus'] = $reportProcessesCounselorStatus;
              $beSentDataset['reportLogs'] = $reportLogs;
          }
      } else {
          $beSentDataset['error'] = '新增失敗';
      }

      $this->load->view('report/counseling_member_count_report', $beSentDataset);
    }

    public function counseling_member_count_report_organization_table($yearType = null, $monthType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $userId = $passport['id'];
        $accept_role = array(2, 3, 4, 5, 6);
        $county = $passport['county'];
        if (in_array($current_role, $accept_role)) {
            $years = $this->ProjectModel->get_distinct_year_by_county($county);
            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }
            if ($monthType == null) {
                $monthType = date("m");
            }
            $months = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');

            $counselingMemberCountReport = $this->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $county);

            $projects = $this->ProjectModel->get_latest_by_county($county);
            $counties = $this->CountyModel->get_all();
            $accumCounselingMemberCount = $this->MemberModel->get_by_county_count($county, $monthType, $yearType);
          
            $countyName = "";
            foreach ($counties as $value) {
              $countyName = ($value['no'] == $county) ? $value['name'] : $countyName;   
            }
            
            $executeArray = report_one_execute_detail($county, $yearType, $monthType, 'web');
            $projectDetail = $executeArray['projectDetail'];
            $executeDetail = $executeArray['executeDetail'];

            $processReviewStatuses = $this->MenuModel->get_by_form_and_column('review_process', 'review_status');
            $logReviewStatuses = $this->MenuModel->get_by_form_and_column('review_log', 'review_status');
            $reviewStatus = [];
        
            $reviewStatus['review_process_not_pass'] = $this->MenuModel->get_no_resource_by_content('未批准', 'review_process')->no; 
            $reviewStatus['review_process_pass'] = $this->MenuModel->get_no_resource_by_content('批准', 'review_process')->no;
            $reviewStatus['review_process_wait'] = $this->MenuModel->get_no_resource_by_content('等待送出', 'review_process')->no;
       
            $reportProcessesCounty = $counselingMemberCountReport ? $this->ReviewProcessModel->get_by_county('counseling_member_count_report', $counselingMemberCountReport->no) : null;
            $reportProcessesCountyStatus = $reportProcessesCounty ? $reportProcessesCounty->review_status : null;
            $reportProcessesCounselor = $counselingMemberCountReport ? $this->ReviewProcessModel->get_by_counselor('counseling_member_count_report', $counselingMemberCountReport->no) : null;
            $reportProcessesCounselorStatus = $reportProcessesCounselor ? $reportProcessesCounselor->review_status : null;
            $reportLogs = $counselingMemberCountReport ? $this->ReviewLogModel->get_by_report_no('counseling_member_count_report', $counselingMemberCountReport->no) : null;
            
            $counselorId = "";

            if ($reportLogs) {
                foreach ($reportLogs as $value) {
                    if ($value['user_role'] == 6) {
                        $counselorId = $value['user_id'];
                    }
                }
            }

            $beSentDataset = array(
                'title' => '表一.輔導人數統計表/執行進度表',
                'url' => '/report/counseling_member_count_report_organization_table/' . $yearType . '/' . $monthType,
                'role' => $current_role,
                'years' => $years,
                'months' => $months,
                'counties' => $counties,
                'county' => $county,
                'counselingMemberCountReport' => $counselingMemberCountReport,
                'userTitle' => $userTitle,
                'projects' => $projects,
                'yearType' => $yearType,
                'monthType' => $monthType,
                'accumCounselingMemberCount' => $accumCounselingMemberCount,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'security' => $this->security,
                'projectDetail' => $projectDetail,
                'executeDetail' => $executeDetail,
                'countyName' => $countyName,
                'reportProcessesCountyStatus' => $reportProcessesCountyStatus,
                'reportProcessesCounselorStatus' => $reportProcessesCounselorStatus,
                'reviewStatus' => $reviewStatus,
                'reportLogs' => $reportLogs,
                'processReviewStatuses' => $processReviewStatuses
            );

            $reviewStatuses = $this->security->xss_clean($this->input->post('reviewStatus'));
            $comment = $this->security->xss_clean($this->input->post('comment'));
            $reportFile = $counselingMemberCountReport ? $counselingMemberCountReport->report_file : null;

            if (isset($_POST['resubmit'])) {
              $config['upload_path'] = './files/';
              $config['allowed_types'] = 'jpg|png|pdf';
              $config['max_size'] = 5000000;
              $config['max_width'] = 5000;
              $config['max_height'] = 5000;
              $config['encrypt_name'] = true;
              $this->load->library('upload', $config);
              // upload family diagram
              if ($this->upload->do_upload('reportFile')) {
                  $fileMetaData = $this->upload->data();
                  $reportFile = $this->FileModel->create_one($counselingMemberCountReport->no, $fileMetaData['file_name'], $fileMetaData['orig_name']);
              }

              $isUpdateReportFile = $this->CounselingMemberCountReportModel->update_file_by_no($counselingMemberCountReport->no, $reportFile);
              if ($isUpdateReportFile) {
                $counselingMemberCountReport = $this->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $county);
                $beSentDataset['counselingMemberCountReport'] = $counselingMemberCountReport;
                return $this->load->view('report/counseling_member_count_report_organization_table', $beSentDataset);
              }
            }

            if (empty($reviewStatuses)) {
              return $this->load->view('report/counseling_member_count_report_organization_table', $beSentDataset);
            }

            if ($monthType % 3 == 0) {
              $reportNameArray = ['high_school_trend_survey_count_report', 'counseling_member_count_report', 'two_years_trend_survey_count_report',
                  'one_years_trend_survey_count_report', 'now_years_trend_survey_count_report',
                  'old_case_trend_survey_count_report', 'counselor_manpower_report',
                  'counseling_identity_count_report', 'counseling_meeting_count_report'];
            } else {
                $reportNameArray = ['counseling_member_count_report', 'counselor_manpower_report',
                  'counseling_identity_count_report', 'counseling_meeting_count_report'];
            }

            $reportNoArray = [];
            $reportArray = [];

            $counselingMemberCountReport = $this->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $county);
            $counselingMemberCountReportNo = $counselingMemberCountReport ? $counselingMemberCountReport->no : 0;  
            array_push($reportArray, $counselingMemberCountReport);           
            array_push($reportNoArray, $counselingMemberCountReportNo);

            if ($monthType % 3 == 0) {
              $highSchoolTrendSurveyCountReports = $this->HighSchoolTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
              $highSchoolTrendSurveyCountReportNo = $highSchoolTrendSurveyCountReports ? $highSchoolTrendSurveyCountReports->no : 0;
              array_push($reportArray, $highSchoolTrendSurveyCountReports);
              array_push($reportNoArray, $highSchoolTrendSurveyCountReportNo);

                $twoYearsTrendSurveyCountReports = $this->TwoYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $twoYearsTrendSurveyCountReportNo = $twoYearsTrendSurveyCountReports ? $twoYearsTrendSurveyCountReports->no : 0;
                array_push($reportArray, $twoYearsTrendSurveyCountReports);
                array_push($reportNoArray, $twoYearsTrendSurveyCountReportNo);
            
                $oneYearsTrendSurveyCountReports = $this->OneYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $oneYearsTrendSurveyCountReportNo = $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->no : 0;
                array_push($reportArray, $oneYearsTrendSurveyCountReports);
                array_push($reportNoArray, $oneYearsTrendSurveyCountReportNo);
            
                $nowYearsTrendSurveyCountReports = $this->NowYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $nowYearsTrendSurveyCountReportNo = $nowYearsTrendSurveyCountReports ? $nowYearsTrendSurveyCountReports->no : 0;
                array_push($reportArray, $nowYearsTrendSurveyCountReports);
                array_push($reportNoArray, $nowYearsTrendSurveyCountReportNo);
            
                $oldCaseTrendSurveyCountReports = $this->OldCaseTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $oldCaseTrendSurveyCountReportNo = $oldCaseTrendSurveyCountReports ? $oldCaseTrendSurveyCountReports->no : 0;
                array_push($reportArray, $oldCaseTrendSurveyCountReports);
                array_push($reportNoArray, $oldCaseTrendSurveyCountReportNo);
            }
            
            $counselorManpowerReports = $this->CounselorManpowerReportModel->get_by_no($yearType, $monthType, $county);
            $counselorManpowerReportNo = $counselorManpowerReports ? $counselorManpowerReports->no : 0;
            array_push($reportArray, $counselorManpowerReports);      
            array_push($reportNoArray, $counselorManpowerReportNo);
            
            $get_inserted_identity_count_data = $this->CounselingIdentityCountReportModel->get_inserted_identity_count_data($yearType, $monthType, $projects->no);
            $counselingIdentityCountReportNo = $get_inserted_identity_count_data ? $get_inserted_identity_count_data->no : 0;
            array_push($reportArray, $get_inserted_identity_count_data);      
            array_push($reportNoArray, $counselingIdentityCountReportNo);
            
            $get_inserted_meeting_count_data = $this->CounselingMeetingCountReportModel->get_inserted_meeting_count_data($yearType, $monthType, $projects->no);
            $counselingMeetingCountReportNo = $get_inserted_meeting_count_data ? $get_inserted_meeting_count_data->no : 0;
            array_push($reportArray, $get_inserted_meeting_count_data);      
            array_push($reportNoArray, $counselingMeetingCountReportNo);

            // file format define
            // 檔案內容大小限制5000KB,並支援JPG,PNG,PDF
            $config['upload_path'] = './files/';
            $config['allowed_types'] = 'jpg|png|pdf';
            $config['max_size'] = 5000000;
            $config['max_width'] = 5000;
            $config['max_height'] = 5000;
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);
            // upload family diagram
            if ($this->upload->do_upload('reportFile')) {
                $fileMetaData = $this->upload->data();
                $reportFile = $this->FileModel->create_one($counselingMemberCountReport->no, $fileMetaData['file_name'], $fileMetaData['orig_name']);
            }

            $isUpdateReportFile = $this->CounselingMemberCountReportModel->update_file_by_no($counselingMemberCountReport->no, $reportFile);
            if ($isUpdateReportFile) {
                if ($reviewStatuses == $reviewStatus['review_process_not_pass']) {
                    $this->ReviewProcessModel->update_one('counseling_member_count_report', $counselingMemberCountReport->no, $reviewStatus['review_process_wait'], 6);
                    $this->ReviewProcessModel->update_one('counseling_member_count_report', $counselingMemberCountReport->no, $reviewStatus['review_process_not_pass'], 3);

                    $this->ReviewLogModel->create_one('counseling_member_count_report', $counselingMemberCountReport->no, $reviewStatus['review_process_not_pass'], $comment, $current_role, $userId);
                    $this->ReviewLogModel->create_one('counseling_member_count_report', $counselingMemberCountReport->no, $reviewStatus['review_process_wait'], null, 6, $counselorId);
            
                    $counselorInfo = $this->UserModel->get_name_by_id($counselorId);
                    $userName = $this->UserModel->get_name_by_id($userId)->name;

                    $recipient = $counselorInfo->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】縣市承辦人退回' . $yearType . '年' . $monthType .'月 輔導人數統計表/執行進度表通知';
                    $content = '<p>' . $counselorInfo->name . ' 君 您好:</p>'
                . '<p>' . $userName . '退回' . $yearType . '年' . $monthType . '月 輔導人數統計表/執行進度表</p>'
                . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
                . '<p>祝 平安快樂</p><p></p>'
                . '<p>教育部青年發展署雙青計畫行政系統</p>'
                . '<p>' . date('Y-m-d') . '</p>'
                    . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipient, $title, $content);
                } elseif ($reviewStatuses == $reviewStatus['review_process_pass']) {
                    
                    $ydaContractor = 'yda';
                    $this->ReviewProcessModel->update_one('counseling_member_count_report', $counselingMemberCountReport->no, $reviewStatus['review_process_wait'], 1);
                    $this->ReviewProcessModel->update_one('counseling_member_count_report', $counselingMemberCountReport->no, $reviewStatus['review_process_pass'], 3);

                    $this->ReviewLogModel->create_one('counseling_member_count_report', $counselingMemberCountReport->no, $reviewStatus['review_process_pass'], $comment, $current_role, $userId);
                    $this->ReviewLogModel->create_one('counseling_member_count_report', $counselingMemberCountReport->no, $reviewStatus['review_process_wait'], null, 1, $ydaContractor);
            
                    $check = 1;
                    $count = 0;
                    $reportProcessesCountyStatusArray = $reportProcessesYdaStatusArray = $reportLogsArray = [];
                    foreach ($reportNameArray as $reportName) {
                        $reportProcessesCounty = $reportArray[$count] ? $this->ReviewProcessModel->get_by_county($reportName, $reportNoArray[$count]) : null;
                        $reportProcessesCountyStatus = $reportProcessesCounty ? $reportProcessesCounty->review_status : null;

                        if ($reportProcessesCountyStatus != $reviewStatus['review_process_pass']) {
                            $check = 0;
                        }
                        array_push($reportProcessesCountyStatusArray, $reportProcessesCountyStatus);
                        $count++;
                    }

                    if ($check) { // 縣市報表全部已繳交
                        $this->TimingReportModel->create_one($county, null, $monthType, $yearType);
                    }
    
                    $ydaInfo = $this->UserModel->get_by_yda_row();
                    $userName = $this->UserModel->get_name_by_id($userId)->name;

                    $recipient = $ydaInfo->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】' . $countyName . '承辦人繳交' . $yearType . '年' . $monthType .'月 輔導人數統計表/執行進度表通知';
                    $content = '<p>' . $ydaInfo->name . ' 君 您好:</p>'
              . '<p>' . $countyName . '承辦人繳交' . $yearType . '年' . $monthType . '月 輔導人數統計表/執行進度表</p>'
              . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
              . '<p>祝 平安快樂</p><p></p>'
              . '<p>教育部青年發展署雙青計畫行政系統</p>'
              . '<p>' . date('Y-m-d') . '</p>'
                  . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipient, $title, $content);
                }

                $reportProcessesCountyStatus = $counselingMemberCountReport ? $this->ReviewProcessModel->get_by_county('counseling_member_count_report', $counselingMemberCountReport->no)->review_status : null;
                $reportProcessesCounselorStatus = $counselingMemberCountReport ? $this->ReviewProcessModel->get_by_counselor('counseling_member_count_report', $counselingMemberCountReport->no)->review_status : null;
                $reportLogs = $counselingMemberCountReport ? $this->ReviewLogModel->get_by_report_no('counseling_member_count_report', $counselingMemberCountReport->no) : null;
                $beSentDataset['reportProcessesCountyStatus'] = $reportProcessesCountyStatus;
                $beSentDataset['reportProcessesCounselorStatus'] = $reportProcessesCounselorStatus;
                $beSentDataset['reportLogs'] = $reportLogs;
            } else {
              $beSentDataset['error'] = '新增失敗';
            }

            $this->load->view('report/counseling_member_count_report_organization_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function counseling_member_count_report_yda_table($yearType = null, $monthType = null, $countyType = 'all')
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $userId = $passport['id'];
        $accept_role = array(1, 8, 9);
        if (in_array($current_role, $accept_role)) {
            $years = $this->ProjectModel->get_distinct_year_by_county("1");
            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }
            if ($monthType == null) {
                $monthType = date("m");
            }
            $months = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
            $countiesName = $this->CountyModel->get_all();

            $executeModes = $this->MenuModel->get_by_form_and_column('project', 'execute_mode');
            $executeWays = $this->MenuModel->get_by_form_and_column('project', 'execute_way');
            $qualifications = $this->MenuModel->get_by_form_and_column('counselor', 'qualification');

            $projectArray = [];
            $projectDetailArray = [];
            $accumCounselingMemberCountArray = [];
            $monthMemberTempCounselingArray = [];
            $executeDetailArray = [];
            $counselingMemberCountReportArray = [];

            $reportProcessesCountyStatusArray = [];
            $reportProcessesYdaStatusArray = [] ;
            $reportLogsArray = [];     
            $countyIdArray = [];
            $isOverTimeArray = [];

            $processReviewStatuses = $this->MenuModel->get_by_form_and_column('review_process', 'review_status');
            $logReviewStatuses = $this->MenuModel->get_by_form_and_column('review_log', 'review_status');
            $reviewStatus = [];
        
            $reviewStatus['review_process_not_pass'] = $this->MenuModel->get_no_resource_by_content('未批准', 'review_process')->no; 
            $reviewStatus['review_process_pass'] = $this->MenuModel->get_no_resource_by_content('批准', 'review_process')->no;
            $reviewStatus['review_process_wait'] = $this->MenuModel->get_no_resource_by_content('等待送出', 'review_process')->no;
       
            if ($countyType == 'all') {
                $counties = $this->CountyModel->get_all();
            } else {
                $counties = $this->CountyModel->get_one($countyType);
            }

            foreach ($counties as $county) {
                $projects = $this->ProjectModel->get_latest_by_county($county['no']);
                array_push($projectArray, $projects);

                $countyAndOrg = $this->CountyModel->get_by_county($county['no']);
                $counselingMemberCountReport = $this->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $county['no']);
                array_push($counselingMemberCountReportArray, $counselingMemberCountReport);

                $countyName = "";
                foreach ($counties as $value) {
                    if ($value['no'] == $county['no']) {
                        $countyName = $value['name'];
                    }
                }

                $executeArray = report_one_execute_detail($county['no'], $yearType, $monthType, 'web');
                $projectDetail = $executeArray['projectDetail'];
                $executeDetail = $executeArray['executeDetail'];
         
                array_push($projectDetailArray, $projectDetail);

                $accumCounselingMemberCount = $this->MemberModel->get_by_county_count($county['no'], $monthType, $yearType);
                array_push($accumCounselingMemberCountArray, $accumCounselingMemberCount);

              
                array_push($executeDetailArray, $executeDetail);

                $reportProcessesCounty = $counselingMemberCountReport ? $this->ReviewProcessModel->get_by_county('counseling_member_count_report', $counselingMemberCountReport->no) : null;
                $reportProcessesCountyStatus = $reportProcessesCounty ? $reportProcessesCounty->review_status : null;
                
                array_push($reportProcessesCountyStatusArray, $reportProcessesCountyStatus);
                
                $reportProcessesYda = $counselingMemberCountReport ? $this->ReviewProcessModel->get_by_yda('counseling_member_count_report', $counselingMemberCountReport->no) : null;
                $reportProcessesYdaStatus = $reportProcessesYda ? $reportProcessesYda->review_status : null;
                array_push($reportProcessesYdaStatusArray, $reportProcessesYdaStatus);
                
                $reportLogs = $counselingMemberCountReport ? $this->ReviewLogModel->get_by_report_no('counseling_member_count_report', $counselingMemberCountReport->no) : null;
                array_push($reportLogsArray, $reportLogs);
             
                $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
                $addMonth = ($addMonth > 9) ? $addMonth : '0'.$addMonth;
                $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;
                $overTimeDate = ($addYear + 1911) . '-' . $addMonth . '-05 00:00:00'; 
                $countyId = "";
                $isOverTime = 0;
                if ($reportLogs) {
                    foreach ($reportLogs as $value) {
                        if ($value['user_role'] == 3) {
                            $countyId = $value['user_id'];
                            $isOverTime = ($value['time'] > $overTimeDate) ? ($value['time'] > $overTimeDate) : 0;      
                        }
                    }
                    
                }
                array_push($countyIdArray, $countyId);
                array_push($isOverTimeArray, $isOverTime);
            }
        
            $beSentDataset = array(
                'title' => '表一.輔導人數統計表/執行進度表',
                'url' => '/report/counseling_member_count_report_yda_table/' . $yearType . '/' . $monthType . '/' . $countyType,
                'role' => $current_role,
                'years' => $years,
                'months' => $months,
                'executeModes' => $executeModes,
                'executeWays' => $executeWays,
                'counties' => $counties,
                'county' => $county,
                'countyType' => $countyType,
                'countiesName' => $countiesName,
                'counselingMemberCountReport' => $counselingMemberCountReport,
                'userTitle' => $userTitle,
                'projects' => $projects,
                'countyAndOrg' => $countyAndOrg,
                'yearType' => $yearType,
                'monthType' => $monthType,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'security' => $this->security,
                'projectDetail' => $projectDetail,
                'executeDetail' => $executeDetail,
                'countyName' => $countyName,
                'projectArray' => $projectArray,
                'projectDetailArray' => $projectDetailArray,
                'accumCounselingMemberCountArray' => $accumCounselingMemberCountArray,
                'monthMemberTempCounselingArray' => $monthMemberTempCounselingArray,
                'executeDetailArray' => $executeDetailArray,
                'counselingMemberCountReportArray' => $counselingMemberCountReportArray,
                'reportProcessesCountyStatusArray' => $reportProcessesCountyStatusArray,
                'reportProcessesYdaStatusArray' => $reportProcessesYdaStatusArray,
                'reportLogsArray' => $reportLogsArray,
                'countyIdArray' => $countyIdArray,
                'reviewStatus' => $reviewStatus,
                'processReviewStatuses' => $processReviewStatuses,
                'isOverTimeArray' => $isOverTimeArray
            );

            $reviewStatuses = $this->security->xss_clean($this->input->post('reviewStatus'));
            $comment = $this->security->xss_clean($this->input->post('comment'));

            if (empty($reviewStatuses)) {
                return $this->load->view('report/counseling_member_count_report_yda_table', $beSentDataset);
            }

            $reportProcessesCountyStatusArray = [];
            $reportProcessesYdaStatusArray = [] ;
            $reportLogsArray = [];     

            if ($monthType % 3 == 0) {
              $reportNameArray = ['high_school_trend_survey_count_report', 'counseling_member_count_report', 'two_years_trend_survey_count_report',
              'one_years_trend_survey_count_report', 'now_years_trend_survey_count_report',
              'old_case_trend_survey_count_report', 'counselor_manpower_report',
              'counseling_identity_count_report', 'counseling_meeting_count_report'];
            } else {
              $reportNameArray = ['counseling_member_count_report', 'counselor_manpower_report',
                'counseling_identity_count_report', 'counseling_meeting_count_report'];
            }            

            for ($i = 0; $i < count($counties); $i++) {
                $reportNoArray = [];
                $reportArray = [];

                $counselingMemberCountReport = $this->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                $counselingMemberCountReportNo = $counselingMemberCountReport ? $counselingMemberCountReport->no : 0;  
                array_push($reportArray, $counselingMemberCountReport);           
                array_push($reportNoArray, $counselingMemberCountReportNo);

                if ($monthType % 3 == 0) {

                  $highSchoolTrendSurveyCountReports = $this->HighSchoolTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                  $highSchoolTrendSurveyCountReportNo = $highSchoolTrendSurveyCountReports ? $highSchoolTrendSurveyCountReports->no : 0;
                  array_push($reportArray, $highSchoolTrendSurveyCountReports);
                  array_push($reportNoArray, $highSchoolTrendSurveyCountReportNo);

                    $twoYearsTrendSurveyCountReports = $this->TwoYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $twoYearsTrendSurveyCountReportNo = $twoYearsTrendSurveyCountReports ? $twoYearsTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $twoYearsTrendSurveyCountReports);
                    array_push($reportNoArray, $twoYearsTrendSurveyCountReportNo);
                
                    $oneYearsTrendSurveyCountReports = $this->OneYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $oneYearsTrendSurveyCountReportNo = $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $oneYearsTrendSurveyCountReports);
                    array_push($reportNoArray, $oneYearsTrendSurveyCountReportNo);
                
                    $nowYearsTrendSurveyCountReports = $this->NowYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $nowYearsTrendSurveyCountReportNo = $nowYearsTrendSurveyCountReports ? $nowYearsTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $nowYearsTrendSurveyCountReports);
                    array_push($reportNoArray, $nowYearsTrendSurveyCountReportNo);
                
                    $oldCaseTrendSurveyCountReports = $this->OldCaseTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $oldCaseTrendSurveyCountReportNo = $oldCaseTrendSurveyCountReports ? $oldCaseTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $oldCaseTrendSurveyCountReports);
                    array_push($reportNoArray, $oldCaseTrendSurveyCountReportNo);
                }
                
                $counselorManpowerReports = $this->CounselorManpowerReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                $counselorManpowerReportNo = $counselorManpowerReports ? $counselorManpowerReports->no : 0;
                array_push($reportArray, $counselorManpowerReports);      
                array_push($reportNoArray, $counselorManpowerReportNo);
                
                $get_inserted_identity_count_data = $this->CounselingIdentityCountReportModel->get_inserted_identity_count_data($yearType, $monthType, $projectArray[$i]->no);
                $counselingIdentityCountReportNo = $get_inserted_identity_count_data ? $get_inserted_identity_count_data->no : 0;
                array_push($reportArray, $get_inserted_identity_count_data);      
                array_push($reportNoArray, $counselingIdentityCountReportNo);
                
                $get_inserted_meeting_count_data = $this->CounselingMeetingCountReportModel->get_inserted_meeting_count_data($yearType, $monthType, $projectArray[$i]->no);
                $counselingMeetingCountReportNo = $get_inserted_meeting_count_data ? $get_inserted_meeting_count_data->no : 0;
                array_push($reportArray, $get_inserted_meeting_count_data);      
                array_push($reportNoArray, $counselingMeetingCountReportNo);
                
                if ($reviewStatuses == $reviewStatus['review_process_not_pass']) {

                    $this->ReviewProcessModel->update_one('counseling_member_count_report', $counselingMemberCountReportArray[$i]->no, $reviewStatus['review_process_wait'], 3);
                    $this->ReviewProcessModel->update_one('counseling_member_count_report', $counselingMemberCountReportArray[$i]->no, $reviewStatus['review_process_not_pass'], 1);

                    $this->ReviewLogModel->create_one('counseling_member_count_report', $counselingMemberCountReportArray[$i]->no, $reviewStatus['review_process_not_pass'], $comment, $current_role, $userId);
                    $this->ReviewLogModel->create_one('counseling_member_count_report', $counselingMemberCountReportArray[$i]->no, $reviewStatus['review_process_wait'], null, 3, $countyIdArray[$i]);
                
                    $countyContractor = $this->UserModel->get_name_by_id($countyIdArray[$i]);
                    $userName = $this->UserModel->get_name_by_id($userId)->name;
    
                    $recipient = $countyContractor->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】青年署退回' . $yearType . '年' . $monthType .'月 輔導人數統計表/執行進度表通知';
                    $content = '<p>' . $countyContractor->name . ' 君 您好:</p>'
                    . '<p>' . $userName . '退回' . $yearType . '年' . $monthType . '月 輔導人數統計表/執行進度表</p>'
                    . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';
    
                    //api_send_email_temp($recipient, $title, $content);

                } elseif ($reviewStatuses == $reviewStatus['review_process_pass']) {

                    $this->ReviewProcessModel->update_one('counseling_member_count_report', $counselingMemberCountReportArray[$i]->no, $reviewStatus['review_process_pass'], 1);

                    $this->ReviewLogModel->create_one('counseling_member_count_report', $counselingMemberCountReportArray[$i]->no, $reviewStatus['review_process_pass'], $comment, $current_role, $userId);

                    $check = 1;
                    $count = 0;
                    $reportProcessesCountyStatusArray = $reportProcessesYdaStatusArray = $reportLogsArray = [];
                    foreach($reportNameArray as $reportName) {
 
                      $reportProcessesYda = $reportArray[$count] ? $this->ReviewProcessModel->get_by_yda($reportName, $reportNoArray[$count]) : null;
                      $reportProcessesYdaStatus = $reportProcessesYda ? $reportProcessesYda->review_status : null;
      
                      array_push($reportProcessesYdaStatusArray, $reportProcessesYdaStatus);

                      if($reportProcessesCountyStatus != $reviewStatus['review_process_pass']) {
                        $check = 0;
                      }

                      $count ++;
                    }
                    $userInfo = $this->UserModel->get_name_by_id($userId);
                    if($check) { // 縣市報表全部已繳交
                      $this->TimingReportModel->create_one($counties[$i]['no'], $userInfo->yda, $monthType, $yearType);
                    }
                }
                $reportProcessesCountyStatus = $counselingMemberCountReportArray[$i] ? $this->ReviewProcessModel->get_by_county('counseling_member_count_report', $counselingMemberCountReportArray[$i]->no)->review_status : null;
                
                array_push($reportProcessesCountyStatusArray, $reportProcessesCountyStatus);
                
                $reportProcessesYdaStatus = $counselingMemberCountReportArray[$i] ? $this->ReviewProcessModel->get_by_yda('counseling_member_count_report', $counselingMemberCountReportArray[$i]->no)->review_status : null;
                array_push($reportProcessesYdaStatusArray, $reportProcessesYdaStatus);
                
                $reportLogs = $counselingMemberCountReportArray[$i] ? $this->ReviewLogModel->get_by_report_no('counseling_member_count_report', $counselingMemberCountReportArray[$i]->no) : null;
                array_push($reportLogsArray, $reportLogs);

                $countyId = "";
                if ($reportLogs) {
                    foreach ($reportLogs as $value) {
                        if ($value['user_role'] == 3) {
                            $countyId = $value['user_id'];
                        }
                    }
                }
                array_push($countyIdArray, $countyId);          
            }

            $beSentDataset['reportProcessesCountyStatusArray'] = $reportProcessesCountyStatusArray;
            $beSentDataset['reportProcessesYdaStatusArray'] = $reportProcessesYdaStatusArray;
            $beSentDataset['reportLogsArray'] = $reportLogsArray;

            $this->load->view('report/counseling_member_count_report_yda_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function month_member_temp_counseling($yearType = null, $monthType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(2, 3, 6);

        if (in_array($current_role, $accept_role)) {
            $county = $passport['county'];
            $years = $this->ProjectModel->get_distinct_year_by_county($county);
            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }
            if ($monthType == null) {
                $monthType = date("m");
            }
            $months = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
            $members = $this->MemberModel->get_member_month($county, $yearType, $monthType);

            $monthMemberTempCounselings = $this->MonthMemberTempCounselingModel->get_by_county_and_month($county, $monthType, $yearType);
            $trends = $this->MenuModel->get_by_form_and_column('end_case', 'trend');
            $hasDelegation = empty($members) ? 0 : $this->ProjectModel->get_has_delegation_by_member($members[0]['no'])->has_delegation;

            $beSentDataset = array(
                'title' => '每月輔導成效概況表',
                'url' => '/report/month_member_temp_counseling/' . $yearType . '/' . $monthType,
                'role' => $current_role,
                'years' => $years,
                'months' => $months,
                'yearType' => $yearType,
                'monthType' => $monthType,
                'userTitle' => $userTitle,
                'hasDelegation' => $hasDelegation,
                'members' => $members,
                'monthMemberTempCounselings' => $monthMemberTempCounselings,
                'trends' => $trends,
                'security' => $this->security,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $trend = $this->security->xss_clean($this->input->post('trend'));
            $trendDescription = $this->security->xss_clean($this->input->post('trendDescription'));

            if (empty($trend) && empty($trendDescription)) {
                return $this->load->view('report/month_member_temp_counseling', $beSentDataset);
            }

            $isInArray = 0;
            for ($i = 0; $i < count($members); $i++) {
              foreach($monthMemberTempCounselings as $value){
                if($value['member'] == $members[$i]['no']){
                  $isExecuteSuccess = $this->MonthMemberTempCounselingModel->update_by_county_and_month($members[$i]['no'], $trend[$i], $trendDescription[$i], $monthType, $county);
                  $isInArray = 1;
                }
              }
              if($isInArray == 0){
                $isExecuteSuccess = $this->MonthMemberTempCounselingModel->create_one($members[$i]['no'], $trend[$i], $trendDescription[$i], $monthType, $county);
              }
              $isInArray = 0;

            }

            // if ($monthMemberTempCounselings) {
            //     for ($i = 0; $i < count($monthMemberTempCounselings); $i++) {

            //         $isExecuteSuccess = $this->MonthMemberTempCounselingModel->update_by_county_and_month($monthMemberTempCounselings[$i]['member'], $trend[$i], $trendDescription[$i], $monthType, $county);
            //     }

            // } else {
            //     if ($trend && $trendDescription) {
            //         for ($i = 0; $i < count($members); $i++) {
            //             $isExecuteSuccess = $this->MonthMemberTempCounselingModel->create_one($members[$i]['no'], $trend[$i], $trendDescription[$i], $monthType, $county);
            //         }
            //     }

            // }

            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
                redirect('report/counseling_member_count_report/' . $yearType . '/' . $monthType);
            } else {
                $beSentDataset['error'] = '新增失敗';
            }
            $monthMemberTempCounselings = $this->MonthMemberTempCounselingModel->get_by_county_and_month($county, $monthType, $yearType);
            $beSentDataset['monthMemberTempCounselings'] = $monthMemberTempCounselings;

            $this->load->view('report/month_member_temp_counseling', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function funding_execute_report_yda_table($yearType = null, $monthType = null, $countyType = 'all')
    {
      $passport = $this->session->userdata('passport');
      $current_role = $passport['role'];
      $userTitle = $passport['userTitle'];
      $userId = $passport['id'];
      $accept_role = array(1, 8, 9);
      if (in_array($current_role, $accept_role)) {
          $years = $this->ProjectModel->get_distinct_year_by_county("1");
          if ($yearType == null) {
              $yearType = date("Y") - 1911;
          }
          if ($monthType == null) {
              $monthType = date("m");
          }
          $months = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
          $countiesName = $this->CountyModel->get_all();

          $executeModes = $this->MenuModel->get_by_form_and_column('project', 'execute_mode');
          $executeWays = $this->MenuModel->get_by_form_and_column('project', 'execute_way');
        

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


          $reportProcessesCountyStatusArray = [];
          $reportProcessesYdaStatusArray = [] ;
          $reportLogsArray = [];     
          $countyIdArray = [];
          $isOverTimeArray = [];
          

          $processReviewStatuses = $this->MenuModel->get_by_form_and_column('review_process', 'review_status');
          $logReviewStatuses = $this->MenuModel->get_by_form_and_column('review_log', 'review_status');
          $reviewStatus = [];
      
          $reviewStatus['review_process_not_pass'] = $this->MenuModel->get_no_resource_by_content('未批准', 'review_process')->no; 
          $reviewStatus['review_process_pass'] = $this->MenuModel->get_no_resource_by_content('批准', 'review_process')->no;
          $reviewStatus['review_process_wait'] = $this->MenuModel->get_no_resource_by_content('等待送出', 'review_process')->no;
     
          if ($countyType == 'all') {
              $counties = $this->CountyModel->get_all();
          } else {
              $counties = $this->CountyModel->get_one($countyType);
          }

          foreach ($counties as $county) {
              $projects = $this->ProjectModel->get_latest_by_county($county['no']);
              array_push($projectArray, $projects);

              $countyAndOrg = $this->CountyModel->get_by_county($county['no']);
              $counselingMemberCountReport = $this->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $county['no']);
              array_push($counselingMemberCountReportArray, $counselingMemberCountReport);

              $fundingApproves = $this->FundingApproveModel->get_by_county_and_year($county['no'], $yearType, $monthType);
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


              $reportProcessesCounty = $counselingMemberCountReport ? $this->ReviewProcessModel->get_by_county('counseling_member_count_report', $counselingMemberCountReport->no) : null;
              $reportProcessesCountyStatus = $reportProcessesCounty ? $reportProcessesCounty->review_status : null;
              
              array_push($reportProcessesCountyStatusArray, $reportProcessesCountyStatus);
              
              $reportProcessesYda = $counselingMemberCountReport ? $this->ReviewProcessModel->get_by_yda('counseling_member_count_report', $counselingMemberCountReport->no) : null;
              $reportProcessesYdaStatus = $reportProcessesYda ? $reportProcessesYda->review_status : null;
              array_push($reportProcessesYdaStatusArray, $reportProcessesYdaStatus);
              
              $reportLogs = $counselingMemberCountReport ? $this->ReviewLogModel->get_by_report_no('counseling_member_count_report', $counselingMemberCountReport->no) : null;
              array_push($reportLogsArray, $reportLogs);
           
              $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
              $addMonth = ($addMonth > 9) ? $addMonth : '0'.$addMonth;
              $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;
              $overTimeDate = ($addYear + 1911) . '-' . $addMonth . '-05 00:00:00'; 
              $countyId = "";
              $isOverTime = 0;
              if ($reportLogs) {
                  foreach ($reportLogs as $value) {
                      if ($value['user_role'] == 3) {
                          $countyId = $value['user_id'];
                          $isOverTime = ($value['time'] > $overTimeDate) ? ($value['time'] > $overTimeDate) : 0;      
                      }
                  }
                  
              }
              array_push($countyIdArray, $countyId);
              array_push($isOverTimeArray, $isOverTime);

              $sumDetail['projectFunding'] += $projects->funding;
              $sumDetail['fundingApprove'] += $fundingApproves->sum;
              $sumDetail['fundingApproveNotYet'] += ($projects->funding - $fundingApproves->sum);
              $sumDetail['fundingExecute'] += ($counselingMemberCountReport ? $counselingMemberCountReport->funding_execute : 0);
    

          }
      
          $beSentDataset = array(
              'title' => '經費執行情形表',
              'url' => '/report/funding_execute_report_yda_table/' . $yearType . '/' . $monthType . '/' . $countyType,
              'role' => $current_role,
              'years' => $years,
              'months' => $months,
              'executeModes' => $executeModes,
              'executeWays' => $executeWays,
              'counties' => $counties,
              'county' => $county,
              'countyType' => $countyType,
              'countiesName' => $countiesName,
              'counselingMemberCountReport' => $counselingMemberCountReport,
              'userTitle' => $userTitle,
              'projects' => $projects,
              'countyAndOrg' => $countyAndOrg,
              'yearType' => $yearType,
              'monthType' => $monthType,
              'password' => $passport['password'],
              'updatePwd' => $passport['updatePwd'],
              'security' => $this->security,
              'countyName' => $countyName,
              'projectArray' => $projectArray,
              'projectDetailArray' => $projectDetailArray,
              'counselingMemberCountReportArray' => $counselingMemberCountReportArray,
              'reportProcessesCountyStatusArray' => $reportProcessesCountyStatusArray,
              'reportProcessesYdaStatusArray' => $reportProcessesYdaStatusArray,
              'reportLogsArray' => $reportLogsArray,
              'countyIdArray' => $countyIdArray,
              'reviewStatus' => $reviewStatus,
              'processReviewStatuses' => $processReviewStatuses,
              'isOverTimeArray' => $isOverTimeArray,
              'fundingApproveArray' => $fundingApproveArray,
              'sumDetail' => $sumDetail
          );

   
          $reportProcessesCountyStatusArray = [];
          $reportProcessesYdaStatusArray = [] ;
          $reportLogsArray = [];     

          $this->load->view('report/funding_execute_report_yda_table', $beSentDataset);
      } else {
          redirect('user/login');
      }
    }

    public function timing_report_yda_table($yearType = null, $monthType = null, $countyType = 'all')
    {
      $passport = $this->session->userdata('passport');
      $current_role = $passport['role'];
      $userTitle = $passport['userTitle'];
      $userId = $passport['id'];
      $accept_role = array(1, 8, 9);
      if (in_array($current_role, $accept_role)) {
          $years = $this->ProjectModel->get_distinct_year_by_county("1");
          if ($yearType == null) {
              $yearType = date("Y") - 1911;
          }
          if ($monthType == null) {
              $monthType = date("m");
          }
          $months = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
          $countiesName = $this->CountyModel->get_all();

          $executeModes = $this->MenuModel->get_by_form_and_column('project', 'execute_mode');
          $executeWays = $this->MenuModel->get_by_form_and_column('project', 'execute_way');
        

          $projectArray = [];
          $reportNameArray = ['high_school_trend_survey_count_report', 'counseling_member_count_report', 'two_years_trend_survey_count_report',
                  'one_years_trend_survey_count_report', 'now_years_trend_survey_count_report',
                  'old_case_trend_survey_count_report', 'counselor_manpower_report',
                  'counseling_identity_count_report', 'counseling_meeting_count_report'];
       
            
          $reportProcessesYdaStatusArray = [] ;
          $reportLogsArray = [];     
          $countyIdArray = [];
          $isOverTimeArray = [];
          $timingReportCountyArray = [];
          $timingReportYdaArray = [];

          $earlyTimeDetailArray = [];
          $onTimeDetailArray = [];
          $lateTimeDetailArray = [];
          
          $processReviewStatuses = $this->MenuModel->get_by_form_and_column('review_process', 'review_status');
          $logReviewStatuses = $this->MenuModel->get_by_form_and_column('review_log', 'review_status');
          $reviewStatus = [];
      
          $reviewStatus['review_process_not_pass'] = $this->MenuModel->get_no_resource_by_content('未批准', 'review_process')->no; 
          $reviewStatus['review_process_pass'] = $this->MenuModel->get_no_resource_by_content('批准', 'review_process')->no;
          $reviewStatus['review_process_wait'] = $this->MenuModel->get_no_resource_by_content('等待送出', 'review_process')->no;
     
          if ($countyType == 'all') {
              $counties = $this->CountyModel->get_all();
          } else {
              $counties = $this->CountyModel->get_one($countyType);
          }

          foreach ($counties as $county) {
              $earlyTimeDetail = $onTimeDetail = $lateTimeDetail = "";

              $projects = $this->ProjectModel->get_latest_by_county($county['no']);
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

              $timingReportCounty = $this->TimingReportModel->get_county_by_county($county['no'], $yearType, $monthType);
              $timingReportYda = $this->TimingReportModel->get_yda_by_county($county['no'], $yearType, $monthType);

              array_push($timingReportCountyArray, $timingReportCounty);
              array_push($timingReportYdaArray, $timingReportYda);
   
              $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
              $addMonth = ($addMonth > 9) ? $addMonth : '0'.$addMonth;
              $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;
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
                  } elseif ($timingReportYda->date = $overTimeDate) {
                      $onTimeDetail = $onTimeDetail . $timingReportYda->date . "(通過)\n";
                  } elseif ($timingReportYda->date > $overTimeDate) {
                      $lateTimeDetail = $lateTimeDetail . $timingReportYda->date . "(通過)\n";
                  }
              }

              array_push($earlyTimeDetailArray, $earlyTimeDetail);
              array_push($onTimeDetailArray, $onTimeDetail);
              array_push($lateTimeDetailArray, $lateTimeDetail);          
          }
      
          $beSentDataset = array(
              'title' => '回傳情形紀錄表',
              'url' => '/report/timing_report_yda_table/' . $yearType . '/' . $monthType . '/' . $countyType,
              'role' => $current_role,
              'years' => $years,
              'months' => $months,
              'executeModes' => $executeModes,
              'executeWays' => $executeWays,
              'counties' => $counties,
              'county' => $county,
              'countyType' => $countyType,
              'countiesName' => $countiesName,
              'userTitle' => $userTitle,
              'projects' => $projects,
              'yearType' => $yearType,
              'monthType' => $monthType,
              'password' => $passport['password'],
              'updatePwd' => $passport['updatePwd'],
              'security' => $this->security,
              'countyName' => $countyName,
              'projectArray' => $projectArray,
              'countyIdArray' => $countyIdArray,
              'reviewStatus' => $reviewStatus,
              'processReviewStatuses' => $processReviewStatuses,
              'isOverTimeArray' => $isOverTimeArray,
              'earlyTimeDetailArray' => $earlyTimeDetailArray,
              'onTimeDetailArray' => $onTimeDetailArray,
              'lateTimeDetailArray' => $lateTimeDetailArray,
              'earlyTimeDetail' => $earlyTimeDetail
          );

   
          $reportProcessesCountyStatusArray = [];
          $reportProcessesYdaStatusArray = [] ;
          $reportLogsArray = [];     

          $this->load->view('report/timing_report_yda_table', $beSentDataset);
      } else {
          redirect('user/login');
      }
    }

    public function high_school_trend_survey_count_report($yearType = null, $monthType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];        
        $userId = $passport['id'];
        $accept_role = array(6);
        valid_roles($accept_role);
        $countyType = $passport['county'];
        $organization = $passport['organization'];

        $yearType = $yearType ? $yearType : date("Y") - 1911;
        $monthType = $monthType ? $monthType : date("m");

        $projects = $this->ProjectModel->get_latest_by_county($countyType);
        $countyAndOrg = $this->CountyModel->get_by_county($countyType);
        $highSchoolTrendSurveyCountReports = $this->HighSchoolTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $countyType);
          
        $executeModes = $this->MenuModel->get_by_form_and_column('project', 'execute_mode');
        $executeWays = $this->MenuModel->get_by_form_and_column('project', 'execute_way');
        $counties = $this->CountyModel->get_all();

        $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $yearType - 1, 229);
        $surveyTypeData['startDate'] = (date("Y")-1) . '-01-01';
        $surveyTypeData['endDate'] = date("Y") . '-' . ($monthType+1) . '-01';
        $trackData = $this->ReportModel->get_high_school_seasonal_review_month_report_by_county($surveyTypeData);
        $sumDetail = get_seasonal_review_sum($trackData);
        $tableValue = get_seasonal_review_table($trackData);

        if ($countyType == 'all') $counties = $this->CountyModel->get_all();
        else $counties = $this->CountyModel->get_one($countyType);
        
        $note = $this->ReportModel->get_high_school_seasonal_review_note_month_report_by_county($surveyTypeData);
        $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

        $processReviewStatuses = $this->MenuModel->get_by_form_and_column('review_process', 'review_status');
        $logReviewStatuses = $this->MenuModel->get_by_form_and_column('review_log', 'review_status');
        $reviewStatus = [];

        $reviewStatus['review_process_not_pass'] = $this->MenuModel->get_no_resource_by_content('未批准', 'review_process')->no;
        $reviewStatus['review_process_pass'] = $this->MenuModel->get_no_resource_by_content('批准', 'review_process')->no;
        $reviewStatus['review_process_wait'] = $this->MenuModel->get_no_resource_by_content('等待送出', 'review_process')->no;

        $reportProcessesCounselor = $highSchoolTrendSurveyCountReports ? $this->ReviewProcessModel->get_by_counselor('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReports->no) : null;
        $reportProcessesCounselorStatus = $reportProcessesCounselor ? $reportProcessesCounselor->review_status : null;
        $reportLogs = $highSchoolTrendSurveyCountReports ? $this->ReviewLogModel->get_by_report_no('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReports->no) : null;

        

        $beSentDataset = array(
          'title' => '表九.高中已錄取未註冊動向調查追蹤',
          'url' => '/report/high_school_trend_survey_count_report/' . $yearType . '/' . $monthType,
          'role' => $current_role,
          'executeModes' => $executeModes,
          'executeWays' => $executeWays,
          'counties' => $counties,
          'countyType' => $countyType,
          'userTitle' => $userTitle,
          'projects' => $projects,
          'countyAndOrg' => $countyAndOrg,
          'yearType' => $yearType,
          'monthType' => $monthType,
          'value' => $tableValue,
          'valueSum' => $sumDetail,
          'report' => $highSchoolTrendSurveyCountReports,
          'password' => $passport['password'],
          'updatePwd' => $passport['updatePwd'],
          'security' => $this->security,
          'reportProcessesCounselorStatus' => $reportProcessesCounselorStatus,
          'reviewStatus' => $reviewStatus,
          'reportLogs' => $reportLogs,
          'processReviewStatuses' => $processReviewStatuses,
          'noteDetail' => $noteDetailArray,
          'type' => 'report_nine'
        );

        foreach ($tableValue as $value) {
          $one = $value['one'];
          $two = $value['two'];
          $three = $value['three'];
          $four = $value['four'];
          $five = $value['five'];
          $six = $value['six'];
          $seven = $value['seven'];
          $eight = $value['eight'];
          $nine = $value['nine'];
          $ten = $value['ten'];
          $eleven = $value['eleven'];
          $twelve = $value['twelve'];
          $thirteen = $value['thirteen'];
          $fourteen = $value['fourteen'];
          $fifteen = $value['fifteen'];
          $sixteen = $value['sixteen'];
          $seventeen = $value['seventeen'];
          $eighteen = $value['eighteen'];
          $nineteen = $value['nineteen'];
        }
        $note = $noteDetailArray[0];

        // if (empty($note)) return $this->load->view('report/high_school_trend_survey_count_report', $beSentDataset);
        
        if (isset($_POST['save']) || isset($_POST['temp'])) {
            if ($highSchoolTrendSurveyCountReports) {
                $isExecuteSuccess = $this->HighSchoolTrendSurveyCountReportModel->udpdate_one_new(
                    $one,
                    $two,
                    $three,
                    $four,
                    $five,
                    $six,
                    $seven,
                    $eight,
                    $nine,
                    $ten,
                    $eleven,
                    $twelve,
                    $thirteen,
                    $fourteen,
                    $fifteen,
                    $sixteen,
                    $seventeen,
                    $eighteen,
                    $nineteen,
                    $note,
                    $monthType,
                    $yearType,
                    $projects->no
                );
         
                $highSchoolTrendSurveyCountReportArray = array($note, $monthType, $yearType, $projects->no);
                $highSchoolTrendSurveyCountReportNum = 0;
                foreach ($highSchoolTrendSurveyCountReportArray as $value) {
                    if ($value != null || $value == 0) {
                        $highSchoolTrendSurveyCountReportNum++;
                    }
                }

                $highSchoolTrendSurveyCountReportRate = round($highSchoolTrendSurveyCountReportNum / count($highSchoolTrendSurveyCountReportArray), 2) * 100;

                $highSchoolTrendSurveyCountReportsuccess = $this->CompletionModel->update_one('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReports->no, $highSchoolTrendSurveyCountReportRate);
            } else {
                $isExecuteSuccess = $this->HighSchoolTrendSurveyCountReportModel->create_one_new(
                    $one,
                    $two,
                    $three,
                    $four,
                    $five,
                    $six,
                    $seven,
                    $eight,
                    $nine,
                    $ten,
                    $eleven,
                    $twelve,
                    $thirteen,
                    $fourteen,
                    $fifteen,
                    $sixteen,
                    $seventeen,
                    $eighteen,
                    $nineteen,
                    $note,
                    $monthType,
                    $yearType,
                    $projects->no
                );


         

                $highSchoolTrendSurveyCountReportArray = array($note, $monthType, $yearType, $projects->no);

                $highSchoolTrendSurveyCountReportNum = 0;
                foreach ($highSchoolTrendSurveyCountReportArray as $value) {
                    if ($value != null || $value == 0) {
                        $highSchoolTrendSurveyCountReportNum++;
                    }
                }

                $highSchoolTrendSurveyCountReportRate = round($highSchoolTrendSurveyCountReportNum / count($highSchoolTrendSurveyCountReportArray), 2) * 100;

                $highSchoolTrendSurveyCountReportSuccess = $this->CompletionModel->create_one('high_school_trend_survey_count_report', $isExecuteSuccess, $highSchoolTrendSurveyCountReportRate);
            }

            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
                if (isset($_POST['save'])) {
                    $highSchoolTrendSurveyCountReports = $this->HighSchoolTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $countyType);
                    $reportProcesses = $this->ReviewProcessModel->get_by_report_no('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReports->no);
                    if ($reportProcesses) {
                        $this->ReviewProcessModel->update_one('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReports->no, $reviewStatus['review_process_pass'], 6);
                        $this->ReviewProcessModel->update_one('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], 3);
                    } else {
                        $this->ReviewProcessModel->create_one('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReports->no, $reviewStatus['review_process_pass'], 6);
                        $this->ReviewProcessModel->create_one('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], 3);
                        $this->ReviewProcessModel->create_one('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReports->no, $reviewStatus['review_process_not_pass'], 1);
                    }
                    $countyContractor = $this->UserModel->get_latest_county_contractor($countyType);
                    $this->ReviewLogModel->create_one('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReports->no, $reviewStatus['review_process_pass'], null, $current_role, $userId);
                    $this->ReviewLogModel->create_one('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], null, 3, $countyContractor->id);

                    $countyContractor = $this->UserModel->get_by_county_contractor($countyType);
                    $userName = $this->UserModel->get_name_by_id($userId)->name;

                    $recipient = $countyContractor->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】輔導員繳交' . $yearType . '年' . $monthType . '月高中已錄取未註冊動向調查追蹤表通知';
                    $content = '<p>' . $countyContractor->name . ' 君 您好:</p>'
              . '<p>' . $userName . '繳交' . $yearType . '年' . $monthType . '月高中已錄取未註冊動向調查追蹤表</p>'
              . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
              . '<p>祝 平安快樂</p><p></p>'
              . '<p>教育部青年發展署雙青計畫行政系統</p>'
              . '<p>' . date('Y-m-d') . '</p>'
                  . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipient, $title, $content);
              
                    $reportProcessesCounselorStatus = $highSchoolTrendSurveyCountReports ? $this->ReviewProcessModel->get_by_counselor('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReports->no)->review_status : null;
                    $reportLogs = $highSchoolTrendSurveyCountReports ? $this->ReviewLogModel->get_by_report_no('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReports->no) : null;
                    $beSentDataset['reportProcessesCounselorStatus'] = $reportProcessesCounselorStatus;
                    $beSentDataset['reportLogs'] = $reportLogs;
                }
            } else {
                $beSentDataset['error'] = '新增失敗';
            }
        }

        $highSchoolTrendSurveyCountReports = $this->HighSchoolTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $countyType);
        $beSentDataset['report'] = $highSchoolTrendSurveyCountReports;

        $this->load->view('report/high_school_trend_survey_count_report', $beSentDataset);
       
    }

    public function high_school_trend_survey_count_report_organization_table($yearType = null, $monthType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $userId = $passport['id'];
        $accept_role = array(2, 3, 4, 5);
        if (in_array($current_role, $accept_role)) {
            $county = $passport['county'];
            $years = $this->ProjectModel->get_distinct_year_by_county($county);
            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }
            if ($monthType == null) {
                $monthType = date("m");
            }
            $months = array('03', '06', '09', '12');

            $county = $passport['county'];
            $organization = $passport['organization'];

            $projects = $this->ProjectModel->get_latest_by_county($county);
            $countyAndOrg = $this->CountyModel->get_by_county($county);
            $highSchoolTrendSurveyCountReports = $this->HighSchoolTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
            $youthCount = $this->YouthModel->get_two_years_trend_by_county($county);
            $executeModes = $this->MenuModel->get_by_form_and_column('project', 'execute_mode');
            $executeWays = $this->MenuModel->get_by_form_and_column('project', 'execute_way');
            $counties = $this->CountyModel->get_all();

            $processReviewStatuses = $this->MenuModel->get_by_form_and_column('review_process', 'review_status');
            $logReviewStatuses = $this->MenuModel->get_by_form_and_column('review_log', 'review_status');
            $reviewStatus = [];

            $reviewStatus['review_process_not_pass'] = $this->MenuModel->get_no_resource_by_content('未批准', 'review_process')->no;
            $reviewStatus['review_process_pass'] = $this->MenuModel->get_no_resource_by_content('批准', 'review_process')->no;
            $reviewStatus['review_process_wait'] = $this->MenuModel->get_no_resource_by_content('等待送出', 'review_process')->no;

            $reportProcessesCounty = $highSchoolTrendSurveyCountReports ? $this->ReviewProcessModel->get_by_county('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReports->no) : null;
            $reportProcessesCountyStatus = $reportProcessesCounty ? $reportProcessesCounty->review_status : null;
            $reportProcessesCounselor = $highSchoolTrendSurveyCountReports ? $this->ReviewProcessModel->get_by_counselor('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReports->no) : null;
            $reportProcessesCounselorStatus = $reportProcessesCounselor ? $reportProcessesCounselor->review_status : null;
            $reportLogs = $highSchoolTrendSurveyCountReports ? $this->ReviewLogModel->get_by_report_no('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReports->no) : null;

            $counselorId = "";
            if ($reportLogs) {
              foreach ($reportLogs as $value) {
                  if ($value['user_role'] == 6) {
                      $counselorId = $value['user_id'];
                  }
              }
            }

            $countyName = "";
            foreach ($counties as $value) {
                if ($value['no'] == $county) {
                    $countyName = $value['name'];
                }
            }

            $beSentDataset = array(
                'title' => '表九.高中已錄取未註冊動向調查追蹤',
                'url' => '/report/high_school_trend_survey_count_report_organization_table/'. $yearType . '/' .$monthType,
                'role' => $current_role,
                'executeModes' => $executeModes,
                'executeWays' => $executeWays,
                'counties' => $counties,
                'countyType' => $county,
                'userTitle' => $userTitle,
                'projects' => $projects,
                'countyAndOrg' => $countyAndOrg,
                'yearType' => $yearType,
                'monthType' => $monthType,
                'youthCount' => $youthCount,
                'report' => $highSchoolTrendSurveyCountReports,
                'years' => $years,
                'months' => $months,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'security' => $this->security,
                'reportProcessesCountyStatus' => $reportProcessesCountyStatus,
                'reportProcessesCounselorStatus' => $reportProcessesCounselorStatus,
                'reviewStatus' => $reviewStatus,
                'reportLogs' => $reportLogs,
                'processReviewStatuses' => $processReviewStatuses,
                'value' => null,
                'valueSum' => null,
                'countyName' => $countyName
            );

            $reviewStatuses = $this->security->xss_clean($this->input->post('reviewStatus'));
            $comment = $this->security->xss_clean($this->input->post('comment'));
            $reportFile = $highSchoolTrendSurveyCountReports ? $highSchoolTrendSurveyCountReports->report_file : null;

            if (empty($reviewStatuses)) {
                return $this->load->view('report/high_school_trend_survey_count_report_organization_table', $beSentDataset);
            }

            if ($monthType % 3 == 0) {
              $reportNameArray = ['high_school_trend_survey_count_report', 'counseling_member_count_report', 'two_years_trend_survey_count_report',
                'one_years_trend_survey_count_report', 'now_years_trend_survey_count_report',
                'old_case_trend_survey_count_report', 'counselor_manpower_report',
                'counseling_identity_count_report', 'counseling_meeting_count_report'];
            } else {
                $reportNameArray = ['counseling_member_count_report', 'counselor_manpower_report',
                  'counseling_identity_count_report', 'counseling_meeting_count_report'];
            }

            $reportNoArray = [];
            $reportArray = [];

            $counselingMemberCountReport = $this->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $county);
            $counselingMemberCountReportNo = $counselingMemberCountReport ? $counselingMemberCountReport->no : 0;  
            array_push($reportArray, $counselingMemberCountReport);           
            array_push($reportNoArray, $counselingMemberCountReportNo);

            if ($monthType % 3 == 0) {

              $highSchoolTrendSurveyCountReports = $this->HighSchoolTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
              $highSchoolTrendSurveyCountReportNo = $highSchoolTrendSurveyCountReports ? $highSchoolTrendSurveyCountReports->no : 0;
              array_push($reportArray, $highSchoolTrendSurveyCountReports);
              array_push($reportNoArray, $highSchoolTrendSurveyCountReportNo);

              $highSchoolTrendSurveyCountReports = $this->HighSchoolTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
              $highSchoolTrendSurveyCountReportNo = $highSchoolTrendSurveyCountReports ? $highSchoolTrendSurveyCountReports->no : 0;
              array_push($reportArray, $highSchoolTrendSurveyCountReports);
              array_push($reportNoArray, $highSchoolTrendSurveyCountReportNo);

                $twoYearsTrendSurveyCountReports = $this->TwoYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $twoYearsTrendSurveyCountReportNo = $twoYearsTrendSurveyCountReports ? $twoYearsTrendSurveyCountReports->no : 0;
                array_push($reportArray, $twoYearsTrendSurveyCountReports);
                array_push($reportNoArray, $twoYearsTrendSurveyCountReportNo);
            
                $oneYearsTrendSurveyCountReports = $this->OneYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $oneYearsTrendSurveyCountReportNo = $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->no : 0;
                array_push($reportArray, $oneYearsTrendSurveyCountReports);
                array_push($reportNoArray, $oneYearsTrendSurveyCountReportNo);
            
                $nowYearsTrendSurveyCountReports = $this->NowYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $nowYearsTrendSurveyCountReportNo = $nowYearsTrendSurveyCountReports ? $nowYearsTrendSurveyCountReports->no : 0;
                array_push($reportArray, $nowYearsTrendSurveyCountReports);
                array_push($reportNoArray, $nowYearsTrendSurveyCountReportNo);
            
                $oldCaseTrendSurveyCountReports = $this->OldCaseTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $oldCaseTrendSurveyCountReportNo = $oldCaseTrendSurveyCountReports ? $oldCaseTrendSurveyCountReports->no : 0;
                array_push($reportArray, $oldCaseTrendSurveyCountReports);
                array_push($reportNoArray, $oldCaseTrendSurveyCountReportNo);
            }
            
            $counselorManpowerReports = $this->CounselorManpowerReportModel->get_by_no($yearType, $monthType, $county);
            $counselorManpowerReportNo = $counselorManpowerReports ? $counselorManpowerReports->no : 0;
            array_push($reportArray, $counselorManpowerReports);      
            array_push($reportNoArray, $counselorManpowerReportNo);
            
            $get_inserted_identity_count_data = $this->CounselingIdentityCountReportModel->get_inserted_identity_count_data($yearType, $monthType, $projects->no);
            $counselingIdentityCountReportNo = $get_inserted_identity_count_data ? $get_inserted_identity_count_data->no : 0;
            array_push($reportArray, $get_inserted_identity_count_data);      
            array_push($reportNoArray, $counselingIdentityCountReportNo);
            
            $get_inserted_meeting_count_data = $this->CounselingMeetingCountReportModel->get_inserted_meeting_count_data($yearType, $monthType, $projects->no);
            $counselingMeetingCountReportNo = $get_inserted_meeting_count_data ? $get_inserted_meeting_count_data->no : 0;
            array_push($reportArray, $get_inserted_meeting_count_data);      
            array_push($reportNoArray, $counselingMeetingCountReportNo);

            // file format define
            // 檔案內容大小限制5000KB,並支援JPG,PNG,PDF
            $config['upload_path'] = './files/';
            $config['allowed_types'] = 'jpg|png|pdf';
            $config['max_size'] = 5000;
            $config['max_width'] = 5000;
            $config['max_height'] = 5000;
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);
            // upload family diagram
            if ($this->upload->do_upload('reportFile')) {
                $fileMetaData = $this->upload->data();
                $reportFile = $this->FileModel->create_one($highSchoolTrendSurveyCountReports->no, $fileMetaData['file_name'], $fileMetaData['orig_name']);
            }

            $isUpdateReportFile = $this->HighSchoolTrendSurveyCountReportModel->update_file_by_no($highSchoolTrendSurveyCountReports->no, $reportFile);

            if ($isUpdateReportFile) {
                if ($reviewStatuses == $reviewStatus['review_process_not_pass']) {
                    $this->ReviewProcessModel->update_one('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], 6);
                    $this->ReviewProcessModel->update_one('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReports->no, $reviewStatus['review_process_not_pass'], 3);

                    $this->ReviewLogModel->create_one('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReports->no, $reviewStatus['review_process_not_pass'], $comment, $current_role, $userId);
                    $this->ReviewLogModel->create_one('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], null, 6, $counselorId);
            
                    $counselorInfo = $this->UserModel->get_name_by_id($counselorId);
                    $userName = $this->UserModel->get_name_by_id($userId)->name;

                    $recipient = $counselorInfo->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】縣市承辦人退回' . $yearType . '年' . $monthType .'月高中已錄取未註冊動向調查追蹤表通知';
                    $content = '<p>' . $counselorInfo->name . ' 君 您好:</p>'
                . '<p>' . $userName . '退回' . $yearType . '年' . $monthType . '月高中已錄取未註冊動向調查追蹤表</p>'
                . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
                . '<p>祝 平安快樂</p><p></p>'
                . '<p>教育部青年發展署雙青計畫行政系統</p>'
                . '<p>' . date('Y-m-d') . '</p>'
                    . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipient, $title, $content);
                } elseif ($reviewStatuses == $reviewStatus['review_process_pass']) {
                    $ydaContractor = 'yda';
                    $this->ReviewProcessModel->update_one('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], 1);
                    $this->ReviewProcessModel->update_one('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReports->no, $reviewStatus['review_process_pass'], 3);

                    $this->ReviewLogModel->create_one('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReports->no, $reviewStatus['review_process_pass'], $comment, $current_role, $userId);
                    $this->ReviewLogModel->create_one('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], null, 1, $ydaContractor);

                    $check = 1;
                    $count = 0;
                    $reportProcessesCountyStatusArray = $reportProcessesYdaStatusArray = $reportLogsArray = [];
                    foreach ($reportNameArray as $reportName) {
                        $reportProcessesCounty = $reportArray[$count] ? $this->ReviewProcessModel->get_by_county($reportName, $reportNoArray[$count]) : null;
                        $reportProcessesCountyStatus = $reportProcessesCounty ? $reportProcessesCounty->review_status : null;
  
                        if ($reportProcessesCountyStatus != $reviewStatus['review_process_pass']) {
                            $check = 0;
                        }
                        array_push($reportProcessesCountyStatusArray, $reportProcessesCountyStatus);
                        $count++;
                    }
  
                    if ($check) { // 縣市報表全部已繳交
                        $this->TimingReportModel->create_one($county, null, $monthType, $yearType);
                    }


                    $ydaInfo = $this->UserModel->get_by_yda_row();
                    $userName = $this->UserModel->get_name_by_id($userId)->name;
  
                    $recipient = $ydaInfo->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】' . $countyName . '承辦人繳交' . $yearType . '年' . $monthType .'月' . ($yearType - 4) . '學年度動向調查追蹤表通知';
                    $content = '<p>' . $ydaInfo->name . ' 君 您好:</p>'
                . '<p>' . $countyName . '承辦人繳交' . $yearType . '年' . $monthType . '月 ' . ($yearType - 4) . '學年度動向調查追蹤表</p>'
                . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
                . '<p>祝 平安快樂</p><p></p>'
                . '<p>教育部青年發展署雙青計畫行政系統</p>'
                . '<p>' . date('Y-m-d') . '</p>'
                    . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';
  
                    //api_send_email_temp($recipient, $title, $content);
                }

                $reportProcessesCountyStatus = $highSchoolTrendSurveyCountReports ? $this->ReviewProcessModel->get_by_county('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReports->no)->review_status : null;
                $reportProcessesCounselorStatus = $highSchoolTrendSurveyCountReports ? $this->ReviewProcessModel->get_by_counselor('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReports->no)->review_status : null;
                $reportLogs = $highSchoolTrendSurveyCountReports ? $this->ReviewLogModel->get_by_report_no('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReports->no) : null;
                $beSentDataset['reportProcessesCountyStatus'] = $reportProcessesCountyStatus;
                $beSentDataset['reportProcessesCounselorStatus'] = $reportProcessesCounselorStatus;
                $beSentDataset['reportLogs'] = $reportLogs;
            } else {
              $beSentDataset['error'] = '新增失敗';
            }

            $this->load->view('report/high_school_trend_survey_count_report_organization_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function high_school_trend_survey_count_report_yda_table($yearType = null, $monthType = null, $countyType = 'all')
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $userId = $passport['id'];
        $accept_role = array(1, 8, 9);
        if (in_array($current_role, $accept_role)) {
            $county = $countyType ? $countyType : '1';
            $years = $this->ProjectModel->get_distinct_year_by_county('1');
            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }
            if ($monthType == null) {
                $monthType = date("m");
            }
            $months = array('03', '06', '09', '12');
            $countiesName = $this->CountyModel->get_all();

            $highSchoolTrendSurveyCountReports = $this->HighSchoolTrendSurveyCountReportModel->get_by_all($yearType, $monthType, $countyType);

            $executeModes = $this->MenuModel->get_by_form_and_column('project', 'execute_mode');
            $executeWays = $this->MenuModel->get_by_form_and_column('project', 'execute_way');
            $counties = $this->CountyModel->get_all();

            $sumDetail = get_seasonal_review_month_report_sum($highSchoolTrendSurveyCountReports);

            $highSchoolTrendSurveyCountReportArray = [];
            $reportProcessesCountyStatusArray = [];
            $reportProcessesYdaStatusArray = [];
            $reportLogsArray = [];
            $countyIdArray = [];
            $isOverTimeArray = [];
            $projectArray = [];

            $processReviewStatuses = $this->MenuModel->get_by_form_and_column('review_process', 'review_status');
            $logReviewStatuses = $this->MenuModel->get_by_form_and_column('review_log', 'review_status');
            $reviewStatus = [];

            $reviewStatus['review_process_not_pass'] = $this->MenuModel->get_no_resource_by_content('未批准', 'review_process')->no;
            $reviewStatus['review_process_pass'] = $this->MenuModel->get_no_resource_by_content('批准', 'review_process')->no;
            $reviewStatus['review_process_wait'] = $this->MenuModel->get_no_resource_by_content('等待送出', 'review_process')->no;

            if ($countyType == 'all') {
                $counties = $this->CountyModel->get_all();
            } else {
                $counties = $this->CountyModel->get_one($countyType);
            }

            foreach ($counties as $county) {
                $projects = $this->ProjectModel->get_latest_by_county($county['no']);
                array_push($projectArray, $projects);

                $highSchoolTrendSurveyCountReport = $this->HighSchoolTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county['no']);
                array_push($highSchoolTrendSurveyCountReportArray, $highSchoolTrendSurveyCountReport);

                $reportProcessesCounty = $highSchoolTrendSurveyCountReport ? $this->ReviewProcessModel->get_by_county('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReport->no) : null;
                $reportProcessesCountyStatus = $reportProcessesCounty ? $reportProcessesCounty->review_status : null;

                array_push($reportProcessesCountyStatusArray, $reportProcessesCountyStatus);

                $reportProcessesYda = $highSchoolTrendSurveyCountReport ? $this->ReviewProcessModel->get_by_yda('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReport->no) : null;
                $reportProcessesYdaStatus = $reportProcessesYda ? $reportProcessesYda->review_status : null;
                array_push($reportProcessesYdaStatusArray, $reportProcessesYdaStatus);

                $reportLogs = $highSchoolTrendSurveyCountReport ? $this->ReviewLogModel->get_by_report_no('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReport->no) : null;
                array_push($reportLogsArray, $reportLogs);

                $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
                $addMonth = ($addMonth > 9) ? $addMonth : '0'.$addMonth;
                $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;
                $overTimeDate = ($addYear + 1911) . '-' . $addMonth . '-05 00:00:00'; 
                $countyId = "";
                $isOverTime = 0;
                if ($reportLogs) {
                    foreach ($reportLogs as $value) {
                        if ($value['user_role'] == 3) {
                            $countyId = $value['user_id'];
                            $isOverTime = ($value['time'] > $overTimeDate) ? ($value['time'] > $overTimeDate) : 0;      
                        }
                    }
                    
                }
                array_push($countyIdArray, $countyId);
                array_push($isOverTimeArray, $isOverTime);
            }

            $beSentDataset = array(
                'title' => '表九.高中已錄取未註冊動向調查追蹤',
                'url' => '/report/high_school_trend_survey_count_report_yda_table/' . $yearType . '/' . $monthType . '/' .$countyType,
                'role' => $current_role,
                'executeModes' => $executeModes,
                'executeWays' => $executeWays,
                'counties' => $counties,
                'countyType' => $countyType,
                'userTitle' => $userTitle,
                'yearType' => $yearType,
                'monthType' => $monthType,
                'highSchoolTrendSurveyCountReports' => $highSchoolTrendSurveyCountReports,
                'years' => $years,
                'months' => $months,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'security' => $this->security,
                'valueSum' => $sumDetail,
                'reportArray' => $highSchoolTrendSurveyCountReportArray,
                'reportProcessesCountyStatusArray' => $reportProcessesCountyStatusArray,
                'reportProcessesYdaStatusArray' => $reportProcessesYdaStatusArray,
                'reportLogsArray' => $reportLogsArray,
                'countyIdArray' => $countyIdArray,
                'reviewStatus' => $reviewStatus,
                'processReviewStatuses' => $processReviewStatuses,
                'isOverTimeArray' => $isOverTimeArray,
                'countiesName' => $countiesName,
                'reviewPage' => 'high_school_trend_survey_count_report_yda_table'
            );

            $reviewStatuses = $this->security->xss_clean($this->input->post('reviewStatus'));
            $comment = $this->security->xss_clean($this->input->post('comment'));

            if (empty($reviewStatuses)) {
                return $this->load->view('report/high_school_trend_survey_count_report_yda_table', $beSentDataset);
            }

            $reportProcessesCountyStatusArray = [];
            $reportProcessesYdaStatusArray = [];
            $reportLogsArray = [];

            if ($monthType % 3 == 0) {
                $reportNameArray = ['high_school_trend_survey_count_report', 'counseling_member_count_report', 'two_years_trend_survey_count_report',
                  'one_years_trend_survey_count_report', 'now_years_trend_survey_count_report',
                  'old_case_trend_survey_count_report', 'counselor_manpower_report',
                  'counseling_identity_count_report', 'counseling_meeting_count_report'];
            } else {
              $reportNameArray = ['counseling_member_count_report', 'counselor_manpower_report',
                'counseling_identity_count_report', 'counseling_meeting_count_report'];
            }    

            for ($i = 0; $i < count($counties); $i++) {

                $reportNoArray = [];
                $reportArray = [];

                $counselingMemberCountReport = $this->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                $counselingMemberCountReportNo = $counselingMemberCountReport ? $counselingMemberCountReport->no : 0;  
                array_push($reportArray, $counselingMemberCountReport);           
                array_push($reportNoArray, $counselingMemberCountReportNo);

                if ($monthType % 3 == 0) {

                  $highSchoolTrendSurveyCountReports = $this->HighSchoolTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                  $highSchoolTrendSurveyCountReportNo = $highSchoolTrendSurveyCountReports ? $highSchoolTrendSurveyCountReports->no : 0;
                  array_push($reportArray, $highSchoolTrendSurveyCountReports);
                  array_push($reportNoArray, $highSchoolTrendSurveyCountReportNo);

                    $twoYearsTrendSurveyCountReports = $this->TwoYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $twoYearsTrendSurveyCountReportNo = $twoYearsTrendSurveyCountReports ? $twoYearsTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $twoYearsTrendSurveyCountReports);
                    array_push($reportNoArray, $twoYearsTrendSurveyCountReportNo);
                
                    $oneYearsTrendSurveyCountReports = $this->OneYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $oneYearsTrendSurveyCountReportNo = $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $oneYearsTrendSurveyCountReports);
                    array_push($reportNoArray, $oneYearsTrendSurveyCountReportNo);
                
                    $nowYearsTrendSurveyCountReports = $this->NowYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $nowYearsTrendSurveyCountReportNo = $nowYearsTrendSurveyCountReports ? $nowYearsTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $nowYearsTrendSurveyCountReports);
                    array_push($reportNoArray, $nowYearsTrendSurveyCountReportNo);
                
                    $oldCaseTrendSurveyCountReports = $this->OldCaseTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $oldCaseTrendSurveyCountReportNo = $oldCaseTrendSurveyCountReports ? $oldCaseTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $oldCaseTrendSurveyCountReports);
                    array_push($reportNoArray, $oldCaseTrendSurveyCountReportNo);
                }
                
                $counselorManpowerReports = $this->CounselorManpowerReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                $counselorManpowerReportNo = $counselorManpowerReports ? $counselorManpowerReports->no : 0;
                array_push($reportArray, $counselorManpowerReports);      
                array_push($reportNoArray, $counselorManpowerReportNo);
                
                $get_inserted_identity_count_data = $this->CounselingIdentityCountReportModel->get_inserted_identity_count_data($yearType, $monthType, $projectArray[$i]->no);
                $counselingIdentityCountReportNo = $get_inserted_identity_count_data ? $get_inserted_identity_count_data->no : 0;
                array_push($reportArray, $get_inserted_identity_count_data);      
                array_push($reportNoArray, $counselingIdentityCountReportNo);
                
                $get_inserted_meeting_count_data = $this->CounselingMeetingCountReportModel->get_inserted_meeting_count_data($yearType, $monthType, $projectArray[$i]->no);
                $counselingMeetingCountReportNo = $get_inserted_meeting_count_data ? $get_inserted_meeting_count_data->no : 0;
                array_push($reportArray, $get_inserted_meeting_count_data);      
                array_push($reportNoArray, $counselingMeetingCountReportNo);

                if ($reviewStatuses == $reviewStatus['review_process_not_pass']) {

                    $this->ReviewProcessModel->update_one('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReportArray[$i]->no, $reviewStatus['review_process_wait'], 3);
                    $this->ReviewProcessModel->update_one('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReportArray[$i]->no, $reviewStatus['review_process_not_pass'], 1);

                    $this->ReviewLogModel->create_one('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReportArray[$i]->no, $reviewStatus['review_process_not_pass'], $comment, $current_role, $userId);
                    $this->ReviewLogModel->create_one('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReportArray[$i]->no, $reviewStatus['review_process_wait'], null, 3, $countyIdArray[$i]);
                
                    $countyContractor = $this->UserModel->get_name_by_id($countyIdArray[$i]);
                    $userName = $this->UserModel->get_name_by_id($userId)->name;
    
                    $recipient = $countyContractor->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】青年署退回' . $yearType . '年' . $monthType .'月高中已錄取未註冊動向調查追蹤表通知';
                    $content = '<p>' . $countyContractor->name . ' 君 您好:</p>'
                    . '<p>' . $userName . '退回' . $yearType . '年' . $monthType . '月已錄取未註冊動向調查追蹤表</p>'
                    . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';
    
                    //api_send_email_temp($recipient, $title, $content);

                } elseif ($reviewStatuses == $reviewStatus['review_process_pass']) {

                    $this->ReviewProcessModel->update_one('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReportArray[$i]->no, $reviewStatus['review_process_pass'], 1);

                    $this->ReviewLogModel->create_one('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReportArray[$i]->no, $reviewStatus['review_process_pass'], $comment, $current_role, $userId);

                    $check = 1;
                    $count = 0;
                    $reportProcessesCountyStatusArray = $reportProcessesYdaStatusArray = $reportLogsArray = [];
                    foreach($reportNameArray as $reportName) {
 
                      $reportProcessesYda = $reportArray[$count] ? $this->ReviewProcessModel->get_by_yda($reportName, $reportNoArray[$count]) : null;
                      $reportProcessesYdaStatus = $reportProcessesYda ? $reportProcessesYda->review_status : null;
      
                      array_push($reportProcessesYdaStatusArray, $reportProcessesYdaStatus);

                      if($reportProcessesCountyStatus != $reviewStatus['review_process_pass']) {
                        $check = 0;
                      }

                      $count ++;
                    }
                    $userInfo = $this->UserModel->get_name_by_id($userId);
                    if($check) { // 縣市報表全部已繳交
                      $this->TimingReportModel->create_one($counties[$i]['no'], $userInfo->yda, $monthType, $yearType);
                    }
                }
                $reportProcessesCountyStatus = $highSchoolTrendSurveyCountReportArray[$i] ? $this->ReviewProcessModel->get_by_county('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReportArray[$i]->no)->review_status : null;

                array_push($reportProcessesCountyStatusArray, $reportProcessesCountyStatus);

                $reportProcessesYdaStatus = $highSchoolTrendSurveyCountReportArray[$i] ? $this->ReviewProcessModel->get_by_yda('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReportArray[$i]->no)->review_status : null;
                array_push($reportProcessesYdaStatusArray, $reportProcessesYdaStatus);

                $reportLogs = $highSchoolTrendSurveyCountReportArray[$i] ? $this->ReviewLogModel->get_by_report_no('high_school_trend_survey_count_report', $highSchoolTrendSurveyCountReportArray[$i]->no) : null;
                array_push($reportLogsArray, $reportLogs);

                $countyId = "";
                if ($reportLogs) {
                    foreach ($reportLogs as $value) {
                        if ($value['user_role'] == 3) {
                            $countyId = $value['user_id'];
                        }
                    }
                }
                array_push($countyIdArray, $countyId);
            }

            $beSentDataset['reportProcessesCountyStatusArray'] = $reportProcessesCountyStatusArray;
            $beSentDataset['reportProcessesYdaStatusArray'] = $reportProcessesYdaStatusArray;
            $beSentDataset['reportLogsArray'] = $reportLogsArray;


            $this->load->view('report/high_school_trend_survey_count_report_yda_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function two_years_trend_survey_count_report($yearType = null, $monthType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];        
        $userId = $passport['id'];
        $accept_role = array(6);
        valid_roles($accept_role);
        $countyType = $passport['county'];
        $organization = $passport['organization'];

        $yearType = $yearType ? $yearType : date("Y") - 1911;
        $monthType = $monthType ? $monthType : date("m");

        $projects = $this->ProjectModel->get_latest_by_county($countyType);
        $countyAndOrg = $this->CountyModel->get_by_county($countyType);
        $twoYearsTrendSurveyCountReports = $this->TwoYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $countyType);
          
        $executeModes = $this->MenuModel->get_by_form_and_column('project', 'execute_mode');
        $executeWays = $this->MenuModel->get_by_form_and_column('project', 'execute_way');
        $counties = $this->CountyModel->get_all();

        $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $yearType - 4, null);
        $surveyTypeData['startDate'] = (date("Y")-1) . '-01-01';
        $surveyTypeData['endDate'] = date("Y") . '-' . ($monthType+1) . '-01';
        $trackData = $this->ReportModel->get_seasonal_review_month_report_by_county($surveyTypeData);
        $sumDetail = get_seasonal_review_sum($trackData);
        $tableValue = get_seasonal_review_table($trackData);

        if ($countyType == 'all') $counties = $this->CountyModel->get_all();
        else $counties = $this->CountyModel->get_one($countyType);
        
        $note = $this->ReportModel->get_seasonal_review_note_month_report_by_county($surveyTypeData);
        $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

        $processReviewStatuses = $this->MenuModel->get_by_form_and_column('review_process', 'review_status');
        $logReviewStatuses = $this->MenuModel->get_by_form_and_column('review_log', 'review_status');
        $reviewStatus = [];

        $reviewStatus['review_process_not_pass'] = $this->MenuModel->get_no_resource_by_content('未批准', 'review_process')->no;
        $reviewStatus['review_process_pass'] = $this->MenuModel->get_no_resource_by_content('批准', 'review_process')->no;
        $reviewStatus['review_process_wait'] = $this->MenuModel->get_no_resource_by_content('等待送出', 'review_process')->no;

        $reportProcessesCounselor = $twoYearsTrendSurveyCountReports ? $this->ReviewProcessModel->get_by_counselor('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReports->no) : null;
        $reportProcessesCounselorStatus = $reportProcessesCounselor ? $reportProcessesCounselor->review_status : null;
        $reportLogs = $twoYearsTrendSurveyCountReports ? $this->ReviewLogModel->get_by_report_no('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReports->no) : null;

        

        $beSentDataset = array(
          'title' => '表五.' .($yearType - 4) . '年動向調查追蹤',
          'url' => '/report/two_years_trend_survey_count_report/' . $yearType . '/' . $monthType,
          'role' => $current_role,
          'executeModes' => $executeModes,
          'executeWays' => $executeWays,
          'counties' => $counties,
          'countyType' => $countyType,
          'userTitle' => $userTitle,
          'projects' => $projects,
          'countyAndOrg' => $countyAndOrg,
          'yearType' => $yearType,
          'monthType' => $monthType,
          'value' => $tableValue,
          'valueSum' => $sumDetail,
          'report' => $twoYearsTrendSurveyCountReports,
          'password' => $passport['password'],
          'updatePwd' => $passport['updatePwd'],
          'security' => $this->security,
          'reportProcessesCounselorStatus' => $reportProcessesCounselorStatus,
          'reviewStatus' => $reviewStatus,
          'reportLogs' => $reportLogs,
          'processReviewStatuses' => $processReviewStatuses,
          'noteDetail' => $noteDetailArray,
          'type' =>'report_five'
        );

        foreach ($tableValue as $value) {
          $one = $value['one'];
          $two = $value['two'];
          $three = $value['three'];
          $four = $value['four'];
          $five = $value['five'];
          $six = $value['six'];
          $seven = $value['seven'];
          $eight = $value['eight'];
          $nine = $value['nine'];
          $ten = $value['ten'];
          $eleven = $value['eleven'];
          $twelve = $value['twelve'];
          $thirteen = $value['thirteen'];
          $fourteen = $value['fourteen'];
          $fifteen = $value['fifteen'];
          $sixteen = $value['sixteen'];
          $seventeen = $value['seventeen'];
          $eighteen = $value['eighteen'];
          $nineteen = $value['nineteen'];
        }
        $note = $noteDetailArray[0];

        // if (empty($note)) return $this->load->view('report/two_years_trend_survey_count_report', $beSentDataset);
        
        if (isset($_POST['save']) || isset($_POST['temp'])) {
            if ($twoYearsTrendSurveyCountReports) {
                $isExecuteSuccess = $this->TwoYearsTrendSurveyCountReportModel->udpdate_one_new(
                    $one,
                    $two,
                    $three,
                    $four,
                    $five,
                    $six,
                    $seven,
                    $eight,
                    $nine,
                    $ten,
                    $eleven,
                    $twelve,
                    $thirteen,
                    $fourteen,
                    $fifteen,
                    $sixteen,
                    $seventeen,
                    $eighteen,
                    $nineteen,
                    $note,
                    $monthType,
                    $yearType,
                    $projects->no
                );
         
                $twoYearsTrendSurveyCountReportArray = array($note, $monthType, $yearType, $projects->no);
                $twoYearsTrendSurveyCountReportNum = 0;
                foreach ($twoYearsTrendSurveyCountReportArray as $value) {
                    if ($value != null || $value == 0) {
                        $twoYearsTrendSurveyCountReportNum++;
                    }
                }

                $twoYearsTrendSurveyCountReportRate = round($twoYearsTrendSurveyCountReportNum / count($twoYearsTrendSurveyCountReportArray), 2) * 100;

                $twoYearsTrendSurveyCountReportSuccess = $this->CompletionModel->update_one('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReports->no, $twoYearsTrendSurveyCountReportRate);
            } else {
                $isExecuteSuccess = $this->TwoYearsTrendSurveyCountReportModel->create_one_new(
                    $one,
                    $two,
                    $three,
                    $four,
                    $five,
                    $six,
                    $seven,
                    $eight,
                    $nine,
                    $ten,
                    $eleven,
                    $twelve,
                    $thirteen,
                    $fourteen,
                    $fifteen,
                    $sixteen,
                    $seventeen,
                    $eighteen,
                    $nineteen,
                    $note,
                    $monthType,
                    $yearType,
                    $projects->no
                );


         

                $twoYearsTrendSurveyCountReportArray = array($note, $monthType, $yearType, $projects->no);

                $twoYearsTrendSurveyCountReportNum = 0;
                foreach ($twoYearsTrendSurveyCountReportArray as $value) {
                    if ($value != null || $value == 0) {
                        $twoYearsTrendSurveyCountReportNum++;
                    }
                }

                $twoYearsTrendSurveyCountReportRate = round($twoYearsTrendSurveyCountReportNum / count($twoYearsTrendSurveyCountReportArray), 2) * 100;

                $twoYearsTrendSurveyCountReportSuccess = $this->CompletionModel->create_one('two_years_trend_survey_count_report', $isExecuteSuccess, $twoYearsTrendSurveyCountReportRate);
            }

            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
                if (isset($_POST['save'])) {
                    $twoYearsTrendSurveyCountReports = $this->TwoYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $countyType);
                    $reportProcesses = $this->ReviewProcessModel->get_by_report_no('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReports->no);
                    if ($reportProcesses) {
                        $this->ReviewProcessModel->update_one('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReports->no, $reviewStatus['review_process_pass'], 6);
                        $this->ReviewProcessModel->update_one('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], 3);
                    } else {
                        $this->ReviewProcessModel->create_one('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReports->no, $reviewStatus['review_process_pass'], 6);
                        $this->ReviewProcessModel->create_one('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], 3);
                        $this->ReviewProcessModel->create_one('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReports->no, $reviewStatus['review_process_not_pass'], 1);
                    }
                    $countyContractor = $this->UserModel->get_latest_county_contractor($countyType);
                    $this->ReviewLogModel->create_one('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReports->no, $reviewStatus['review_process_pass'], null, $current_role, $userId);
                    $this->ReviewLogModel->create_one('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], null, 3, $countyContractor->id);

                    $countyContractor = $this->UserModel->get_by_county_contractor($countyType);
                    $userName = $this->UserModel->get_name_by_id($userId)->name;

                    $recipient = $countyContractor->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】輔導員繳交' . $yearType . '年' . $monthType . '月 ' . ($yearType - 4) . '學年度動向調查追蹤表通知';
                    $content = '<p>' . $countyContractor->name . ' 君 您好:</p>'
              . '<p>' . $userName . '繳交' . $yearType . '年' . $monthType . '月 ' . ($yearType - 4) . '學年度動向調查追蹤表</p>'
              . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
              . '<p>祝 平安快樂</p><p></p>'
              . '<p>教育部青年發展署雙青計畫行政系統</p>'
              . '<p>' . date('Y-m-d') . '</p>'
                  . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipient, $title, $content);
              
                    $reportProcessesCounselorStatus = $twoYearsTrendSurveyCountReports ? $this->ReviewProcessModel->get_by_counselor('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReports->no)->review_status : null;
                    $reportLogs = $twoYearsTrendSurveyCountReports ? $this->ReviewLogModel->get_by_report_no('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReports->no) : null;
                    $beSentDataset['reportProcessesCounselorStatus'] = $reportProcessesCounselorStatus;
                    $beSentDataset['reportLogs'] = $reportLogs;
                }
            } else {
                $beSentDataset['error'] = '新增失敗';
            }
        }

        $twoYearsTrendSurveyCountReports = $this->TwoYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $countyType);
        $beSentDataset['report'] = $twoYearsTrendSurveyCountReports;

        $this->load->view('report/two_years_trend_survey_count_report', $beSentDataset);
       
    }

    public function two_years_trend_survey_count_report_organization_table($yearType = null, $monthType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $userId = $passport['id'];
        $accept_role = array(2, 3, 4, 5);
        if (in_array($current_role, $accept_role)) {
            $county = $passport['county'];
            $years = $this->ProjectModel->get_distinct_year_by_county($county);
            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }
            if ($monthType == null) {
                $monthType = date("m");
            }
            $months = array('03', '06', '09', '12');

            $county = $passport['county'];
            $organization = $passport['organization'];

            $projects = $this->ProjectModel->get_latest_by_county($county);
            $countyAndOrg = $this->CountyModel->get_by_county($county);
            $twoYearsTrendSurveyCountReports = $this->TwoYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
            $youthCount = $this->YouthModel->get_two_years_trend_by_county($county);
            $executeModes = $this->MenuModel->get_by_form_and_column('project', 'execute_mode');
            $executeWays = $this->MenuModel->get_by_form_and_column('project', 'execute_way');
            $counties = $this->CountyModel->get_all();

            $processReviewStatuses = $this->MenuModel->get_by_form_and_column('review_process', 'review_status');
            $logReviewStatuses = $this->MenuModel->get_by_form_and_column('review_log', 'review_status');
            $reviewStatus = [];

            $reviewStatus['review_process_not_pass'] = $this->MenuModel->get_no_resource_by_content('未批准', 'review_process')->no;
            $reviewStatus['review_process_pass'] = $this->MenuModel->get_no_resource_by_content('批准', 'review_process')->no;
            $reviewStatus['review_process_wait'] = $this->MenuModel->get_no_resource_by_content('等待送出', 'review_process')->no;

            $reportProcessesCounty = $twoYearsTrendSurveyCountReports ? $this->ReviewProcessModel->get_by_county('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReports->no) : null;
            $reportProcessesCountyStatus = $reportProcessesCounty ? $reportProcessesCounty->review_status : null;
            $reportProcessesCounselor = $twoYearsTrendSurveyCountReports ? $this->ReviewProcessModel->get_by_counselor('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReports->no) : null;
            $reportProcessesCounselorStatus = $reportProcessesCounselor ? $reportProcessesCounselor->review_status : null;
            $reportLogs = $twoYearsTrendSurveyCountReports ? $this->ReviewLogModel->get_by_report_no('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReports->no) : null;

            $counselorId = "";
            if ($reportLogs) {
              foreach ($reportLogs as $value) {
                  if ($value['user_role'] == 6) {
                      $counselorId = $value['user_id'];
                  }
              }
            }

            $countyName = "";
            foreach ($counties as $value) {
                if ($value['no'] == $county) {
                    $countyName = $value['name'];
                }
            }

            $beSentDataset = array(
                'title' => '表五.' . ($yearType - 4) . '年動向調查追蹤',
                'url' => '/report/two_years_trend_survey_count_report_organization_table/'. $yearType . '/' .$monthType,
                'role' => $current_role,
                'executeModes' => $executeModes,
                'executeWays' => $executeWays,
                'counties' => $counties,
                'countyType' => $county,
                'userTitle' => $userTitle,
                'projects' => $projects,
                'countyAndOrg' => $countyAndOrg,
                'yearType' => $yearType,
                'monthType' => $monthType,
                'youthCount' => $youthCount,
                'report' => $twoYearsTrendSurveyCountReports,
                'years' => $years,
                'months' => $months,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'security' => $this->security,
                'reportProcessesCountyStatus' => $reportProcessesCountyStatus,
                'reportProcessesCounselorStatus' => $reportProcessesCounselorStatus,
                'reviewStatus' => $reviewStatus,
                'reportLogs' => $reportLogs,
                'processReviewStatuses' => $processReviewStatuses,
                'value' => null,
                'valueSum' => null,
                'countyName' => $countyName
            );

            $reviewStatuses = $this->security->xss_clean($this->input->post('reviewStatus'));
            $comment = $this->security->xss_clean($this->input->post('comment'));
            $reportFile = $twoYearsTrendSurveyCountReports ? $twoYearsTrendSurveyCountReports->report_file : null;

            if (empty($reviewStatuses)) {
                return $this->load->view('report/two_years_trend_survey_count_report_organization_table', $beSentDataset);
            }

            if ($monthType % 3 == 0) {
              $reportNameArray = ['high_school_trend_survey_count_report', 'counseling_member_count_report', 'two_years_trend_survey_count_report',
              'one_years_trend_survey_count_report', 'now_years_trend_survey_count_report',
              'old_case_trend_survey_count_report', 'counselor_manpower_report',
              'counseling_identity_count_report', 'counseling_meeting_count_report'];
            } else {
                $reportNameArray = ['counseling_member_count_report', 'counselor_manpower_report',
                  'counseling_identity_count_report', 'counseling_meeting_count_report'];
            }

            $reportNoArray = [];
            $reportArray = [];

            $counselingMemberCountReport = $this->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $county);
            $counselingMemberCountReportNo = $counselingMemberCountReport ? $counselingMemberCountReport->no : 0;  
            array_push($reportArray, $counselingMemberCountReport);           
            array_push($reportNoArray, $counselingMemberCountReportNo);

            if ($monthType % 3 == 0) {

              $highSchoolTrendSurveyCountReports = $this->HighSchoolTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
              $highSchoolTrendSurveyCountReportNo = $highSchoolTrendSurveyCountReports ? $highSchoolTrendSurveyCountReports->no : 0;
              array_push($reportArray, $highSchoolTrendSurveyCountReports);
              array_push($reportNoArray, $highSchoolTrendSurveyCountReportNo);

                $twoYearsTrendSurveyCountReports = $this->TwoYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $twoYearsTrendSurveyCountReportNo = $twoYearsTrendSurveyCountReports ? $twoYearsTrendSurveyCountReports->no : 0;
                array_push($reportArray, $twoYearsTrendSurveyCountReports);
                array_push($reportNoArray, $twoYearsTrendSurveyCountReportNo);
            
                $oneYearsTrendSurveyCountReports = $this->OneYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $oneYearsTrendSurveyCountReportNo = $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->no : 0;
                array_push($reportArray, $oneYearsTrendSurveyCountReports);
                array_push($reportNoArray, $oneYearsTrendSurveyCountReportNo);
            
                $nowYearsTrendSurveyCountReports = $this->NowYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $nowYearsTrendSurveyCountReportNo = $nowYearsTrendSurveyCountReports ? $nowYearsTrendSurveyCountReports->no : 0;
                array_push($reportArray, $nowYearsTrendSurveyCountReports);
                array_push($reportNoArray, $nowYearsTrendSurveyCountReportNo);
            
                $oldCaseTrendSurveyCountReports = $this->OldCaseTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $oldCaseTrendSurveyCountReportNo = $oldCaseTrendSurveyCountReports ? $oldCaseTrendSurveyCountReports->no : 0;
                array_push($reportArray, $oldCaseTrendSurveyCountReports);
                array_push($reportNoArray, $oldCaseTrendSurveyCountReportNo);
            }
            
            $counselorManpowerReports = $this->CounselorManpowerReportModel->get_by_no($yearType, $monthType, $county);
            $counselorManpowerReportNo = $counselorManpowerReports ? $counselorManpowerReports->no : 0;
            array_push($reportArray, $counselorManpowerReports);      
            array_push($reportNoArray, $counselorManpowerReportNo);
            
            $get_inserted_identity_count_data = $this->CounselingIdentityCountReportModel->get_inserted_identity_count_data($yearType, $monthType, $projects->no);
            $counselingIdentityCountReportNo = $get_inserted_identity_count_data ? $get_inserted_identity_count_data->no : 0;
            array_push($reportArray, $get_inserted_identity_count_data);      
            array_push($reportNoArray, $counselingIdentityCountReportNo);
            
            $get_inserted_meeting_count_data = $this->CounselingMeetingCountReportModel->get_inserted_meeting_count_data($yearType, $monthType, $projects->no);
            $counselingMeetingCountReportNo = $get_inserted_meeting_count_data ? $get_inserted_meeting_count_data->no : 0;
            array_push($reportArray, $get_inserted_meeting_count_data);      
            array_push($reportNoArray, $counselingMeetingCountReportNo);

            // file format define
            // 檔案內容大小限制5000KB,並支援JPG,PNG,PDF
            $config['upload_path'] = './files/';
            $config['allowed_types'] = 'jpg|png|pdf';
            $config['max_size'] = 5000;
            $config['max_width'] = 5000;
            $config['max_height'] = 5000;
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);
            // upload family diagram
            if ($this->upload->do_upload('reportFile')) {
                $fileMetaData = $this->upload->data();
                $reportFile = $this->FileModel->create_one($twoYearsTrendSurveyCountReports->no, $fileMetaData['file_name'], $fileMetaData['orig_name']);
            }

            $isUpdateReportFile = $this->TwoYearsTrendSurveyCountReportModel->update_file_by_no($twoYearsTrendSurveyCountReports->no, $reportFile);

            if ($isUpdateReportFile) {
                if ($reviewStatuses == $reviewStatus['review_process_not_pass']) {
                    $this->ReviewProcessModel->update_one('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], 6);
                    $this->ReviewProcessModel->update_one('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReports->no, $reviewStatus['review_process_not_pass'], 3);

                    $this->ReviewLogModel->create_one('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReports->no, $reviewStatus['review_process_not_pass'], $comment, $current_role, $userId);
                    $this->ReviewLogModel->create_one('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], null, 6, $counselorId);
            
                    $counselorInfo = $this->UserModel->get_name_by_id($counselorId);
                    $userName = $this->UserModel->get_name_by_id($userId)->name;

                    $recipient = $counselorInfo->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】縣市承辦人退回' . $yearType . '年' . $monthType .'月 ' . ($yearType - 4) . '學年度動向調查追蹤表通知';
                    $content = '<p>' . $counselorInfo->name . ' 君 您好:</p>'
                . '<p>' . $userName . '退回' . $yearType . '年' . $monthType . '月 ' . ($yearType - 4) . '學年度動向調查追蹤表</p>'
                . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
                . '<p>祝 平安快樂</p><p></p>'
                . '<p>教育部青年發展署雙青計畫行政系統</p>'
                . '<p>' . date('Y-m-d') . '</p>'
                    . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipient, $title, $content);
                } elseif ($reviewStatuses == $reviewStatus['review_process_pass']) {
                    $ydaContractor = 'yda';
                    $this->ReviewProcessModel->update_one('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], 1);
                    $this->ReviewProcessModel->update_one('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReports->no, $reviewStatus['review_process_pass'], 3);

                    $this->ReviewLogModel->create_one('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReports->no, $reviewStatus['review_process_pass'], $comment, $current_role, $userId);
                    $this->ReviewLogModel->create_one('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], null, 1, $ydaContractor);

                    $check = 1;
                    $count = 0;
                    $reportProcessesCountyStatusArray = $reportProcessesYdaStatusArray = $reportLogsArray = [];
                    foreach ($reportNameArray as $reportName) {
                        $reportProcessesCounty = $reportArray[$count] ? $this->ReviewProcessModel->get_by_county($reportName, $reportNoArray[$count]) : null;
                        $reportProcessesCountyStatus = $reportProcessesCounty ? $reportProcessesCounty->review_status : null;
  
                        if ($reportProcessesCountyStatus != $reviewStatus['review_process_pass']) {
                            $check = 0;
                        }
                        array_push($reportProcessesCountyStatusArray, $reportProcessesCountyStatus);
                        $count++;
                    }
  
                    if ($check) { // 縣市報表全部已繳交
                        $this->TimingReportModel->create_one($county, null, $monthType, $yearType);
                    }


                    $ydaInfo = $this->UserModel->get_by_yda_row();
                    $userName = $this->UserModel->get_name_by_id($userId)->name;
  
                    $recipient = $ydaInfo->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】' . $countyName . '承辦人繳交' . $yearType . '年' . $monthType .'月' . ($yearType - 4) . '學年度動向調查追蹤表通知';
                    $content = '<p>' . $ydaInfo->name . ' 君 您好:</p>'
                . '<p>' . $countyName . '承辦人繳交' . $yearType . '年' . $monthType . '月 ' . ($yearType - 4) . '學年度動向調查追蹤表</p>'
                . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
                . '<p>祝 平安快樂</p><p></p>'
                . '<p>教育部青年發展署雙青計畫行政系統</p>'
                . '<p>' . date('Y-m-d') . '</p>'
                    . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';
  
                    //api_send_email_temp($recipient, $title, $content);
                }

                $reportProcessesCountyStatus = $twoYearsTrendSurveyCountReports ? $this->ReviewProcessModel->get_by_county('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReports->no)->review_status : null;
                $reportProcessesCounselorStatus = $twoYearsTrendSurveyCountReports ? $this->ReviewProcessModel->get_by_counselor('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReports->no)->review_status : null;
                $reportLogs = $twoYearsTrendSurveyCountReports ? $this->ReviewLogModel->get_by_report_no('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReports->no) : null;
                $beSentDataset['reportProcessesCountyStatus'] = $reportProcessesCountyStatus;
                $beSentDataset['reportProcessesCounselorStatus'] = $reportProcessesCounselorStatus;
                $beSentDataset['reportLogs'] = $reportLogs;
            } else {
              $beSentDataset['error'] = '新增失敗';
            }

            $this->load->view('report/two_years_trend_survey_count_report_organization_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function two_years_trend_survey_count_report_yda_table($yearType = null, $monthType = null, $countyType = 'all')
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $userId = $passport['id'];
        $accept_role = array(1, 8, 9);
        if (in_array($current_role, $accept_role)) {
            $county = $countyType ? $countyType : '1';
            $years = $this->ProjectModel->get_distinct_year_by_county('1');
            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }
            if ($monthType == null) {
                $monthType = date("m");
            }
            $months = array('03', '06', '09', '12');
            $countiesName = $this->CountyModel->get_all();

            $twoYearsTrendSurveyCountReports = $this->TwoYearsTrendSurveyCountReportModel->get_by_all($yearType, $monthType, $countyType);

            $executeModes = $this->MenuModel->get_by_form_and_column('project', 'execute_mode');
            $executeWays = $this->MenuModel->get_by_form_and_column('project', 'execute_way');
            $counties = $this->CountyModel->get_all();

            $sumDetail = get_seasonal_review_month_report_sum($twoYearsTrendSurveyCountReports);

            $twoYearsTrendSurveyCountReportArray = [];
            $reportProcessesCountyStatusArray = [];
            $reportProcessesYdaStatusArray = [];
            $reportLogsArray = [];
            $countyIdArray = [];
            $isOverTimeArray = [];
            $projectArray = [];

            $processReviewStatuses = $this->MenuModel->get_by_form_and_column('review_process', 'review_status');
            $logReviewStatuses = $this->MenuModel->get_by_form_and_column('review_log', 'review_status');
            $reviewStatus = [];

            $reviewStatus['review_process_not_pass'] = $this->MenuModel->get_no_resource_by_content('未批准', 'review_process')->no;
            $reviewStatus['review_process_pass'] = $this->MenuModel->get_no_resource_by_content('批准', 'review_process')->no;
            $reviewStatus['review_process_wait'] = $this->MenuModel->get_no_resource_by_content('等待送出', 'review_process')->no;

            if ($countyType == 'all') {
                $counties = $this->CountyModel->get_all();
            } else {
                $counties = $this->CountyModel->get_one($countyType);
            }

            foreach ($counties as $county) {
                $projects = $this->ProjectModel->get_latest_by_county($county['no']);
                array_push($projectArray, $projects);

                $twoYearsTrendSurveyCountReport = $this->TwoYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county['no']);
                array_push($twoYearsTrendSurveyCountReportArray, $twoYearsTrendSurveyCountReport);

                $reportProcessesCounty = $twoYearsTrendSurveyCountReport ? $this->ReviewProcessModel->get_by_county('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReport->no) : null;
                $reportProcessesCountyStatus = $reportProcessesCounty ? $reportProcessesCounty->review_status : null;

                array_push($reportProcessesCountyStatusArray, $reportProcessesCountyStatus);

                $reportProcessesYda = $twoYearsTrendSurveyCountReport ? $this->ReviewProcessModel->get_by_yda('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReport->no) : null;
                $reportProcessesYdaStatus = $reportProcessesYda ? $reportProcessesYda->review_status : null;
                array_push($reportProcessesYdaStatusArray, $reportProcessesYdaStatus);

                $reportLogs = $twoYearsTrendSurveyCountReport ? $this->ReviewLogModel->get_by_report_no('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReport->no) : null;
                array_push($reportLogsArray, $reportLogs);

                $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
                $addMonth = ($addMonth > 9) ? $addMonth : '0'.$addMonth;
                $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;
                $overTimeDate = ($addYear + 1911) . '-' . $addMonth . '-05 00:00:00'; 
                $countyId = "";
                $isOverTime = 0;
                if ($reportLogs) {
                    foreach ($reportLogs as $value) {
                        if ($value['user_role'] == 3) {
                            $countyId = $value['user_id'];
                            $isOverTime = ($value['time'] > $overTimeDate) ? ($value['time'] > $overTimeDate) : 0;      
                        }
                    }
                    
                }
                array_push($countyIdArray, $countyId);
                array_push($isOverTimeArray, $isOverTime);
            }

            $beSentDataset = array(
                'title' => '表五.' . ($yearType - 4) . '年動向調查追蹤',
                'url' => '/report/two_years_trend_survey_count_report_yda_table/' . $yearType . '/' . $monthType . '/' .$countyType,
                'role' => $current_role,
                'executeModes' => $executeModes,
                'executeWays' => $executeWays,
                'counties' => $counties,
                'countyType' => $countyType,
                'userTitle' => $userTitle,
                'yearType' => $yearType,
                'monthType' => $monthType,
                'twoYearsTrendSurveyCountReports' => $twoYearsTrendSurveyCountReports,
                'years' => $years,
                'months' => $months,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'security' => $this->security,
                'valueSum' => $sumDetail,
                'reportArray' => $twoYearsTrendSurveyCountReportArray,
                'reportProcessesCountyStatusArray' => $reportProcessesCountyStatusArray,
                'reportProcessesYdaStatusArray' => $reportProcessesYdaStatusArray,
                'reportLogsArray' => $reportLogsArray,
                'countyIdArray' => $countyIdArray,
                'reviewStatus' => $reviewStatus,
                'processReviewStatuses' => $processReviewStatuses,
                'isOverTimeArray' => $isOverTimeArray,
                'countiesName' => $countiesName,
                'reviewPage' => 'two_years_trend_survey_count_report_yda_table'
            );

            $reviewStatuses = $this->security->xss_clean($this->input->post('reviewStatus'));
            $comment = $this->security->xss_clean($this->input->post('comment'));

            if (empty($reviewStatuses)) {
                return $this->load->view('report/two_years_trend_survey_count_report_yda_table', $beSentDataset);
            }

            $reportProcessesCountyStatusArray = [];
            $reportProcessesYdaStatusArray = [];
            $reportLogsArray = [];

            if ($monthType % 3 == 0) {
              $reportNameArray = ['high_school_trend_survey_count_report', 'counseling_member_count_report', 'two_years_trend_survey_count_report',
              'one_years_trend_survey_count_report', 'now_years_trend_survey_count_report',
              'old_case_trend_survey_count_report', 'counselor_manpower_report',
              'counseling_identity_count_report', 'counseling_meeting_count_report'];
            } else {
              $reportNameArray = ['counseling_member_count_report', 'counselor_manpower_report',
                'counseling_identity_count_report', 'counseling_meeting_count_report'];
            }    

            for ($i = 0; $i < count($counties); $i++) {

                $reportNoArray = [];
                $reportArray = [];

                $counselingMemberCountReport = $this->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                $counselingMemberCountReportNo = $counselingMemberCountReport ? $counselingMemberCountReport->no : 0;  
                array_push($reportArray, $counselingMemberCountReport);           
                array_push($reportNoArray, $counselingMemberCountReportNo);

                if ($monthType % 3 == 0) {
                  $highSchoolTrendSurveyCountReports = $this->HighSchoolTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                  $highSchoolTrendSurveyCountReportNo = $highSchoolTrendSurveyCountReports ? $highSchoolTrendSurveyCountReports->no : 0;
                  array_push($reportArray, $highSchoolTrendSurveyCountReports);
                  array_push($reportNoArray, $highSchoolTrendSurveyCountReportNo);

                    $twoYearsTrendSurveyCountReports = $this->TwoYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $twoYearsTrendSurveyCountReportNo = $twoYearsTrendSurveyCountReports ? $twoYearsTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $twoYearsTrendSurveyCountReports);
                    array_push($reportNoArray, $twoYearsTrendSurveyCountReportNo);
                
                    $oneYearsTrendSurveyCountReports = $this->OneYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $oneYearsTrendSurveyCountReportNo = $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $oneYearsTrendSurveyCountReports);
                    array_push($reportNoArray, $oneYearsTrendSurveyCountReportNo);
                
                    $nowYearsTrendSurveyCountReports = $this->NowYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $nowYearsTrendSurveyCountReportNo = $nowYearsTrendSurveyCountReports ? $nowYearsTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $nowYearsTrendSurveyCountReports);
                    array_push($reportNoArray, $nowYearsTrendSurveyCountReportNo);
                
                    $oldCaseTrendSurveyCountReports = $this->OldCaseTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $oldCaseTrendSurveyCountReportNo = $oldCaseTrendSurveyCountReports ? $oldCaseTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $oldCaseTrendSurveyCountReports);
                    array_push($reportNoArray, $oldCaseTrendSurveyCountReportNo);
                }
                
                $counselorManpowerReports = $this->CounselorManpowerReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                $counselorManpowerReportNo = $counselorManpowerReports ? $counselorManpowerReports->no : 0;
                array_push($reportArray, $counselorManpowerReports);      
                array_push($reportNoArray, $counselorManpowerReportNo);
                
                $get_inserted_identity_count_data = $this->CounselingIdentityCountReportModel->get_inserted_identity_count_data($yearType, $monthType, $projectArray[$i]->no);
                $counselingIdentityCountReportNo = $get_inserted_identity_count_data ? $get_inserted_identity_count_data->no : 0;
                array_push($reportArray, $get_inserted_identity_count_data);      
                array_push($reportNoArray, $counselingIdentityCountReportNo);
                
                $get_inserted_meeting_count_data = $this->CounselingMeetingCountReportModel->get_inserted_meeting_count_data($yearType, $monthType, $projectArray[$i]->no);
                $counselingMeetingCountReportNo = $get_inserted_meeting_count_data ? $get_inserted_meeting_count_data->no : 0;
                array_push($reportArray, $get_inserted_meeting_count_data);      
                array_push($reportNoArray, $counselingMeetingCountReportNo);

                if ($reviewStatuses == $reviewStatus['review_process_not_pass']) {

                    $this->ReviewProcessModel->update_one('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReportArray[$i]->no, $reviewStatus['review_process_wait'], 3);
                    $this->ReviewProcessModel->update_one('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReportArray[$i]->no, $reviewStatus['review_process_not_pass'], 1);

                    $this->ReviewLogModel->create_one('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReportArray[$i]->no, $reviewStatus['review_process_not_pass'], $comment, $current_role, $userId);
                    $this->ReviewLogModel->create_one('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReportArray[$i]->no, $reviewStatus['review_process_wait'], null, 3, $countyIdArray[$i]);
                
                    $countyContractor = $this->UserModel->get_name_by_id($countyIdArray[$i]);
                    $userName = $this->UserModel->get_name_by_id($userId)->name;
    
                    $recipient = $countyContractor->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】青年署退回' . $yearType . '年' . $monthType .'月 ' . ($yearType - 4) . ' 學年度動向調查追蹤表通知';
                    $content = '<p>' . $countyContractor->name . ' 君 您好:</p>'
                    . '<p>' . $userName . '退回' . $yearType . '年' . $monthType . '月 ' . ($yearType - 4) . ' 學年度動向調查追蹤表</p>'
                    . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';
    
                    //api_send_email_temp($recipient, $title, $content);

                } elseif ($reviewStatuses == $reviewStatus['review_process_pass']) {

                    $this->ReviewProcessModel->update_one('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReportArray[$i]->no, $reviewStatus['review_process_pass'], 1);

                    $this->ReviewLogModel->create_one('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReportArray[$i]->no, $reviewStatus['review_process_pass'], $comment, $current_role, $userId);

                    $check = 1;
                    $count = 0;
                    $reportProcessesCountyStatusArray = $reportProcessesYdaStatusArray = $reportLogsArray = [];
                    foreach($reportNameArray as $reportName) {
 
                      $reportProcessesYda = $reportArray[$count] ? $this->ReviewProcessModel->get_by_yda($reportName, $reportNoArray[$count]) : null;
                      $reportProcessesYdaStatus = $reportProcessesYda ? $reportProcessesYda->review_status : null;
      
                      array_push($reportProcessesYdaStatusArray, $reportProcessesYdaStatus);

                      if($reportProcessesCountyStatus != $reviewStatus['review_process_pass']) {
                        $check = 0;
                      }

                      $count ++;
                    }
                    $userInfo = $this->UserModel->get_name_by_id($userId);
                    if($check) { // 縣市報表全部已繳交
                      $this->TimingReportModel->create_one($counties[$i]['no'], $userInfo->yda, $monthType, $yearType);
                    }
                }
                $reportProcessesCountyStatus = $twoYearsTrendSurveyCountReportArray[$i] ? $this->ReviewProcessModel->get_by_county('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReportArray[$i]->no)->review_status : null;

                array_push($reportProcessesCountyStatusArray, $reportProcessesCountyStatus);

                $reportProcessesYdaStatus = $twoYearsTrendSurveyCountReportArray[$i] ? $this->ReviewProcessModel->get_by_yda('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReportArray[$i]->no)->review_status : null;
                array_push($reportProcessesYdaStatusArray, $reportProcessesYdaStatus);

                $reportLogs = $twoYearsTrendSurveyCountReportArray[$i] ? $this->ReviewLogModel->get_by_report_no('two_years_trend_survey_count_report', $twoYearsTrendSurveyCountReportArray[$i]->no) : null;
                array_push($reportLogsArray, $reportLogs);

                $countyId = "";
                if ($reportLogs) {
                    foreach ($reportLogs as $value) {
                        if ($value['user_role'] == 3) {
                            $countyId = $value['user_id'];
                        }
                    }
                }
                array_push($countyIdArray, $countyId);
            }

            $beSentDataset['reportProcessesCountyStatusArray'] = $reportProcessesCountyStatusArray;
            $beSentDataset['reportProcessesYdaStatusArray'] = $reportProcessesYdaStatusArray;
            $beSentDataset['reportLogsArray'] = $reportLogsArray;


            $this->load->view('report/two_years_trend_survey_count_report_yda_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function one_years_trend_survey_count_report($yearType = null, $monthType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $userId = $passport['id'];
        $accept_role = array(6);
        valid_roles($accept_role);
        $countyType = $passport['county'];
        $organization = $passport['organization'];

        $yearType = $yearType ? $yearType : date("Y") - 1911;
        $monthType = $monthType ? $monthType : date("m");

        $projects = $this->ProjectModel->get_latest_by_county($countyType);
        $countyAndOrg = $this->CountyModel->get_by_county($countyType);
        $oneYearsTrendSurveyCountReports = $this->OneYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $countyType);
          
        $executeModes = $this->MenuModel->get_by_form_and_column('project', 'execute_mode');
        $executeWays = $this->MenuModel->get_by_form_and_column('project', 'execute_way');
        $counties = $this->CountyModel->get_all();

        $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $yearType - 3, null);
        $surveyTypeData['startDate'] = (date("Y")-1) . '-01-01';
        $surveyTypeData['endDate'] = date("Y") . '-' . ($monthType+1) . '-01';
        $trackData = $this->ReportModel->get_seasonal_review_month_report_by_county($surveyTypeData);
        $sumDetail = get_seasonal_review_sum($trackData);
        $tableValue = get_seasonal_review_table($trackData);

        if ($countyType == 'all') $counties = $this->CountyModel->get_all();
        else $counties = $this->CountyModel->get_one($countyType);
        
        $note = $this->ReportModel->get_seasonal_review_note_month_report_by_county($surveyTypeData);
        $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);
       

        $processReviewStatuses = $this->MenuModel->get_by_form_and_column('review_process', 'review_status');
        $logReviewStatuses = $this->MenuModel->get_by_form_and_column('review_log', 'review_status');
        $reviewStatus = [];

        $reviewStatus['review_process_not_pass'] = $this->MenuModel->get_no_resource_by_content('未批准', 'review_process')->no;
        $reviewStatus['review_process_pass'] = $this->MenuModel->get_no_resource_by_content('批准', 'review_process')->no;
        $reviewStatus['review_process_wait'] = $this->MenuModel->get_no_resource_by_content('等待送出', 'review_process')->no;

        $reportProcessesCounselor = $oneYearsTrendSurveyCountReports ? $this->ReviewProcessModel->get_by_counselor('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReports->no) : null;
        $reportProcessesCounselorStatus = $reportProcessesCounselor ? $reportProcessesCounselor->review_status : null;
        $reportLogs = $oneYearsTrendSurveyCountReports ? $this->ReviewLogModel->get_by_report_no('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReports->no) : null;

        $beSentDataset = array(
          'title' => '表六.' . ($yearType - 3) . '年動向調查追蹤',
          'url' => '/report/one_years_trend_survey_count_report/' . $yearType . '/' . $monthType,
          'role' => $current_role,
          'executeModes' => $executeModes,
          'executeWays' => $executeWays,
          'counties' => $counties,
          'countyType' => $countyType,
          'userTitle' => $userTitle,
          'projects' => $projects,
          'countyAndOrg' => $countyAndOrg,
          'yearType' => $yearType,
          'monthType' => $monthType,
          'value' => $tableValue,
          'valueSum' => $sumDetail,
          'report' => $oneYearsTrendSurveyCountReports,
          'password' => $passport['password'],
          'updatePwd' => $passport['updatePwd'],
          'security' => $this->security,
          'reportProcessesCounselorStatus' => $reportProcessesCounselorStatus,
          'reviewStatus' => $reviewStatus,
          'reportLogs' => $reportLogs,
          'processReviewStatuses' => $processReviewStatuses,
          'noteDetail' => $noteDetailArray,
          'type' =>'report_six'
        );

        foreach ($tableValue as $value) {
          $one = $value['one'];
          $two = $value['two'];
          $three = $value['three'];
          $four = $value['four'];
          $five = $value['five'];
          $six = $value['six'];
          $seven = $value['seven'];
          $eight = $value['eight'];
          $nine = $value['nine'];
          $ten = $value['ten'];
          $eleven = $value['eleven'];
          $twelve = $value['twelve'];
          $thirteen = $value['thirteen'];
          $fourteen = $value['fourteen'];
          $fifteen = $value['fifteen'];
          $sixteen = $value['sixteen'];
          $seventeen = $value['seventeen'];
          $eighteen = $value['eighteen'];
          $nineteen = $value['nineteen'];
        }
        $note = $noteDetailArray[0];  

        // if (empty($note)) return $this->load->view('report/one_years_trend_survey_count_report', $beSentDataset);
            
        if (isset($_POST['save']) || isset($_POST['temp'])) {
            if ($oneYearsTrendSurveyCountReports) {
                $isExecuteSuccess = $this->OneYearsTrendSurveyCountReportModel->udpdate_one_new(
                    $one,
                    $two,
                    $three,
                    $four,
                    $five,
                    $six,
                    $seven,
                    $eight,
                    $nine,
                    $ten,
                    $eleven,
                    $twelve,
                    $thirteen,
                    $fourteen,
                    $fifteen,
                    $sixteen,
                    $seventeen,
                    $eighteen,
                    $nineteen,
                    $note,
                    $monthType,
                    $yearType,
                    $projects->no
                );
         
                $oneYearsTrendSurveyCountReportArray = array($note, $monthType, $yearType, $projects->no);

                $oneYearsTrendSurveyCountReportNum = 0;
                foreach ($oneYearsTrendSurveyCountReportArray as $value) {
                    if ($value != null || $value == 0) {
                        $oneYearsTrendSurveyCountReportNum++;
                    }
                }

                $oneYearsTrendSurveyCountReportRate = round($oneYearsTrendSurveyCountReportNum / count($oneYearsTrendSurveyCountReportArray), 2) * 100;
                $oneYearsTrendSurveyCountReportSuccess = $this->CompletionModel->update_one('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReports->no, $oneYearsTrendSurveyCountReportRate);
            } else {
                $isExecuteSuccess = $this->OneYearsTrendSurveyCountReportModel->create_one_new(
                    $one,
                    $two,
                    $three,
                    $four,
                    $five,
                    $six,
                    $seven,
                    $eight,
                    $nine,
                    $ten,
                    $eleven,
                    $twelve,
                    $thirteen,
                    $fourteen,
                    $fifteen,
                    $sixteen,
                    $seventeen,
                    $eighteen,
                    $nineteen,
                    $note,
                    $monthType,
                    $yearType,
                    $projects->no
                );

                $oneYearsTrendSurveyCountReportArray = array($note, $monthType, $yearType, $projects->no);

                $oneYearsTrendSurveyCountReportNum = 0;
                foreach ($oneYearsTrendSurveyCountReportArray as $value) {
                    if ($value != null) {
                        $oneYearsTrendSurveyCountReportNum++;
                    }
                }

                $oneYearsTrendSurveyCountReportRate = round($oneYearsTrendSurveyCountReportNum / count($oneYearsTrendSurveyCountReportArray), 2) * 100;

                $oneYearsTrendSurveyCountReportSuccess = $this->CompletionModel->create_one('one_years_trend_survey_count_report', $isExecuteSuccess, $oneYearsTrendSurveyCountReportRate);
            }

            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
                if (isset($_POST['save'])) {
                    $oneYearsTrendSurveyCountReports = $this->OneYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $countyType);
                    $reportProcesses = $this->ReviewProcessModel->get_by_report_no('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReports->no);
                    if ($reportProcesses) {
                        $this->ReviewProcessModel->update_one('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReports->no, $reviewStatus['review_process_pass'], 6);
                        $this->ReviewProcessModel->update_one('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], 3);
                    } else {
                        $this->ReviewProcessModel->create_one('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReports->no, $reviewStatus['review_process_pass'], 6);
                        $this->ReviewProcessModel->create_one('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], 3);
                        $this->ReviewProcessModel->create_one('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReports->no, $reviewStatus['review_process_not_pass'], 1);
                    }
                    $countyContractor = $this->UserModel->get_latest_county_contractor($countyType);
                    $this->ReviewLogModel->create_one('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReports->no, $reviewStatus['review_process_pass'], null, $current_role, $userId);
                    $this->ReviewLogModel->create_one('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], null, 3, $countyContractor->id);

                    $countyContractor = $this->UserModel->get_by_county_contractor($countyType);
                    $userName = $this->UserModel->get_name_by_id($userId)->name;

                    $recipient = $countyContractor->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】輔導員繳交' . $yearType . '年' . $monthType . '月 ' . ($yearType - 3) . '學年度動向調查追蹤表通知';
                    $content = '<p>' . $countyContractor->name . ' 君 您好:</p>'
            . '<p>' . $userName . '繳交' . $yearType . '年' . $monthType . '月 ' . ($yearType - 3) . '學年度動向調查追蹤表</p>'
            . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
            . '<p>祝 平安快樂</p><p></p>'
            . '<p>教育部青年發展署雙青計畫行政系統</p>'
            . '<p>' . date('Y-m-d') . '</p>'
                . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipient, $title, $content);

                    $reportProcessesCounselorStatus = $oneYearsTrendSurveyCountReports ? $this->ReviewProcessModel->get_by_counselor('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReports->no)->review_status : null;
                    $reportLogs = $oneYearsTrendSurveyCountReports ? $this->ReviewLogModel->get_by_report_no('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReports->no) : null;
                    $beSentDataset['reportProcessesCounselorStatus'] = $reportProcessesCounselorStatus;
                    $beSentDataset['reportLogs'] = $reportLogs;
                }
            } else {
                $beSentDataset['error'] = '新增失敗';
            }
        }

      $oneYearsTrendSurveyCountReports = $this->OneYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $countyType);
      $beSentDataset['report'] = $oneYearsTrendSurveyCountReports;

      $this->load->view('report/one_years_trend_survey_count_report', $beSentDataset);
       
    }

    public function one_years_trend_survey_count_report_organization_table($yearType = null, $monthType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $userId = $passport['id'];
        $accept_role = array(2, 3, 4, 5);
        if (in_array($current_role, $accept_role)) {
            $county = $passport['county'];
            $years = $this->ProjectModel->get_distinct_year_by_county($county);
            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }
            if ($monthType == null) {
                $monthType = date("m");
            }
            $months = array('03', '06', '09', '12');

            $county = $passport['county'];
            $organization = $passport['organization'];

            $projects = $this->ProjectModel->get_latest_by_county($county);
            $countyAndOrg = $this->CountyModel->get_by_county($county);
            $oneYearsTrendSurveyCountReports = $this->OneYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
            $youthCount = $this->YouthModel->get_one_years_trend_by_county($county);
            $executeModes = $this->MenuModel->get_by_form_and_column('project', 'execute_mode');
            $executeWays = $this->MenuModel->get_by_form_and_column('project', 'execute_way');
            $counties = $this->CountyModel->get_all();

            $processReviewStatuses = $this->MenuModel->get_by_form_and_column('review_process', 'review_status');
            $logReviewStatuses = $this->MenuModel->get_by_form_and_column('review_log', 'review_status');
            $reviewStatus = [];

            $reviewStatus['review_process_not_pass'] = $this->MenuModel->get_no_resource_by_content('未批准', 'review_process')->no;
            $reviewStatus['review_process_pass'] = $this->MenuModel->get_no_resource_by_content('批准', 'review_process')->no;
            $reviewStatus['review_process_wait'] = $this->MenuModel->get_no_resource_by_content('等待送出', 'review_process')->no;

            $reportProcessesCounty = $oneYearsTrendSurveyCountReports ? $this->ReviewProcessModel->get_by_county('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReports->no) : null;
            $reportProcessesCountyStatus = $reportProcessesCounty ? $reportProcessesCounty->review_status : null;
            $reportProcessesCounselor = $oneYearsTrendSurveyCountReports ? $this->ReviewProcessModel->get_by_counselor('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReports->no) : null;
            $reportProcessesCounselorStatus = $reportProcessesCounselor ? $reportProcessesCounselor->review_status : null;
            $reportLogs = $oneYearsTrendSurveyCountReports ? $this->ReviewLogModel->get_by_report_no('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReports->no) : null;

            $counselorId = "";
            if ($reportLogs) {
              foreach ($reportLogs as $value) {
                  if ($value['user_role'] == 6) {
                      $counselorId = $value['user_id'];
                  }
              }
            }

            $countyName = "";
            foreach ($counties as $value) {
                if ($value['no'] == $county) {
                    $countyName = $value['name'];
                }
            }

            $beSentDataset = array(
                'title' => '表六.' . ($yearType - 3) . '年動向調查追蹤',
                'url' => '/report/one_years_trend_survey_count_report_organization_table/'. $yearType . '/' .$monthType,
                'role' => $current_role,
                'executeModes' => $executeModes,
                'executeWays' => $executeWays,
                'counties' => $counties,
                'countyType' => $county,
                'userTitle' => $userTitle,
                'projects' => $projects,
                'countyAndOrg' => $countyAndOrg,
                'yearType' => $yearType,
                'monthType' => $monthType,
                'youthCount' => $youthCount,
                'report' => $oneYearsTrendSurveyCountReports,
                'years' => $years,
                'months' => $months,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'security' => $this->security,
                'reportProcessesCountyStatus' => $reportProcessesCountyStatus,
                'reportProcessesCounselorStatus' => $reportProcessesCounselorStatus,
                'reviewStatus' => $reviewStatus,
                'reportLogs' => $reportLogs,
                'processReviewStatuses' => $processReviewStatuses,
                'value' => null,
                'valueSum' => null,
                'countyName' => $countyName
            );

            $reviewStatuses = $this->security->xss_clean($this->input->post('reviewStatus'));
            $comment = $this->security->xss_clean($this->input->post('comment'));
            $reportFile = $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->report_file : null;

            if (empty($reviewStatuses)) {
                return $this->load->view('report/one_years_trend_survey_count_report_organization_table', $beSentDataset);
            }

            if ($monthType % 3 == 0) {
              $reportNameArray = ['high_school_trend_survey_count_report', 'counseling_member_count_report', 'two_years_trend_survey_count_report',
                  'one_years_trend_survey_count_report', 'now_years_trend_survey_count_report',
                  'old_case_trend_survey_count_report', 'counselor_manpower_report',
                  'counseling_identity_count_report', 'counseling_meeting_count_report'];
            } else {
                $reportNameArray = ['counseling_member_count_report', 'counselor_manpower_report',
                  'counseling_identity_count_report', 'counseling_meeting_count_report'];
            }

            $reportNoArray = [];
            $reportArray = [];

            $counselingMemberCountReport = $this->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $county);
            $counselingMemberCountReportNo = $counselingMemberCountReport ? $counselingMemberCountReport->no : 0;  
            array_push($reportArray, $counselingMemberCountReport);           
            array_push($reportNoArray, $counselingMemberCountReportNo);

            if ($monthType % 3 == 0) {

              $highSchoolTrendSurveyCountReports = $this->HighSchoolTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
              $highSchoolTrendSurveyCountReportNo = $highSchoolTrendSurveyCountReports ? $highSchoolTrendSurveyCountReports->no : 0;
              array_push($reportArray, $highSchoolTrendSurveyCountReports);
              array_push($reportNoArray, $highSchoolTrendSurveyCountReportNo);

                $twoYearsTrendSurveyCountReports = $this->TwoYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $twoYearsTrendSurveyCountReportNo = $twoYearsTrendSurveyCountReports ? $twoYearsTrendSurveyCountReports->no : 0;
                array_push($reportArray, $twoYearsTrendSurveyCountReports);
                array_push($reportNoArray, $twoYearsTrendSurveyCountReportNo);
            
                $oneYearsTrendSurveyCountReports = $this->OneYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $oneYearsTrendSurveyCountReportNo = $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->no : 0;
                array_push($reportArray, $oneYearsTrendSurveyCountReports);
                array_push($reportNoArray, $oneYearsTrendSurveyCountReportNo);
            
                $nowYearsTrendSurveyCountReports = $this->NowYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $nowYearsTrendSurveyCountReportNo = $nowYearsTrendSurveyCountReports ? $nowYearsTrendSurveyCountReports->no : 0;
                array_push($reportArray, $nowYearsTrendSurveyCountReports);
                array_push($reportNoArray, $nowYearsTrendSurveyCountReportNo);
            
                $oldCaseTrendSurveyCountReports = $this->OldCaseTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $oldCaseTrendSurveyCountReportNo = $oldCaseTrendSurveyCountReports ? $oldCaseTrendSurveyCountReports->no : 0;
                array_push($reportArray, $oldCaseTrendSurveyCountReports);
                array_push($reportNoArray, $oldCaseTrendSurveyCountReportNo);
            }
            
            $counselorManpowerReports = $this->CounselorManpowerReportModel->get_by_no($yearType, $monthType, $county);
            $counselorManpowerReportNo = $counselorManpowerReports ? $counselorManpowerReports->no : 0;
            array_push($reportArray, $counselorManpowerReports);      
            array_push($reportNoArray, $counselorManpowerReportNo);
            
            $get_inserted_identity_count_data = $this->CounselingIdentityCountReportModel->get_inserted_identity_count_data($yearType, $monthType, $projects->no);
            $counselingIdentityCountReportNo = $get_inserted_identity_count_data ? $get_inserted_identity_count_data->no : 0;
            array_push($reportArray, $get_inserted_identity_count_data);      
            array_push($reportNoArray, $counselingIdentityCountReportNo);
            
            $get_inserted_meeting_count_data = $this->CounselingMeetingCountReportModel->get_inserted_meeting_count_data($yearType, $monthType, $projects->no);
            $counselingMeetingCountReportNo = $get_inserted_meeting_count_data ? $get_inserted_meeting_count_data->no : 0;
            array_push($reportArray, $get_inserted_meeting_count_data);      
            array_push($reportNoArray, $counselingMeetingCountReportNo);

            // file format define
            // 檔案內容大小限制5000KB,並支援JPG,PNG,PDF
            $config['upload_path'] = './files/';
            $config['allowed_types'] = 'jpg|png|pdf';
            $config['max_size'] = 5000;
            $config['max_width'] = 5000;
            $config['max_height'] = 5000;
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);
            // upload family diagram
            if ($this->upload->do_upload('reportFile')) {
                $fileMetaData = $this->upload->data();
                $reportFile = $this->FileModel->create_one($oneYearsTrendSurveyCountReports->no, $fileMetaData['file_name'], $fileMetaData['orig_name']);
            }

            $isUpdateReportFile = $this->OneYearsTrendSurveyCountReportModel->update_file_by_no($oneYearsTrendSurveyCountReports->no, $reportFile);
            if ($isUpdateReportFile) {
                if ($reviewStatuses == $reviewStatus['review_process_not_pass']) {
                    $this->ReviewProcessModel->update_one('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], 6);
                    $this->ReviewProcessModel->update_one('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReports->no, $reviewStatus['review_process_not_pass'], 3);

                    $this->ReviewLogModel->create_one('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReports->no, $reviewStatus['review_process_not_pass'], $comment, $current_role, $userId);
                    $this->ReviewLogModel->create_one('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], null, 6, $counselorId);
            
                    $counselorInfo = $this->UserModel->get_name_by_id($counselorId);
                    $userName = $this->UserModel->get_name_by_id($userId)->name;

                    $recipient = $counselorInfo->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】縣市承辦人退回' . $yearType . '年' . $monthType .'月 ' . ($yearType - 3) . '學年度動向調查追蹤表通知';
                    $content = '<p>' . $counselorInfo->name . ' 君 您好:</p>'
                . '<p>' . $userName . '退回' . $yearType . '年' . $monthType . '月 ' . ($yearType - 3) . '學年度動向調查追蹤表</p>'
                . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
                . '<p>祝 平安快樂</p><p></p>'
                . '<p>教育部青年發展署雙青計畫行政系統</p>'
                . '<p>' . date('Y-m-d') . '</p>'
                    . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipient, $title, $content);
                } elseif ($reviewStatuses == $reviewStatus['review_process_pass']) {
                    $ydaContractor = 'yda';
                    $this->ReviewProcessModel->update_one('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], 1);
                    $this->ReviewProcessModel->update_one('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReports->no, $reviewStatus['review_process_pass'], 3);

                    $this->ReviewLogModel->create_one('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReports->no, $reviewStatus['review_process_pass'], $comment, $current_role, $userId);
                    $this->ReviewLogModel->create_one('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], null, 1, $ydaContractor);
            
                    $check = 1;
                    $count = 0;
                    $reportProcessesCountyStatusArray = $reportProcessesYdaStatusArray = $reportLogsArray = [];
                    foreach ($reportNameArray as $reportName) {
                        $reportProcessesCounty = $reportArray[$count] ? $this->ReviewProcessModel->get_by_county($reportName, $reportNoArray[$count]) : null;
                        $reportProcessesCountyStatus = $reportProcessesCounty ? $reportProcessesCounty->review_status : null;
  
                        if ($reportProcessesCountyStatus != $reviewStatus['review_process_pass']) {
                            $check = 0;
                        }
                        array_push($reportProcessesCountyStatusArray, $reportProcessesCountyStatus);
                        $count++;
                    }
  
                    if ($check) { // 縣市報表全部已繳交
                        $this->TimingReportModel->create_one($county, null, $monthType, $yearType);
                    }
                
                    $ydaInfo = $this->UserModel->get_by_yda_row();
                    $userName = $this->UserModel->get_name_by_id($userId)->name;
  
                    $recipient = $ydaInfo->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】' . $countyName . '承辦人繳交' . $yearType . '年' . $monthType .'月' . ($yearType - 3) . '學年度動向調查追蹤表通知';
                    $content = '<p>' . $ydaInfo->name . ' 君 您好:</p>'
                . '<p>' . $countyName . '承辦人繳交' . $yearType . '年' . $monthType . '月 ' . ($yearType - 3) . '學年度動向調查追蹤表</p>'
                . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
                . '<p>祝 平安快樂</p><p></p>'
                . '<p>教育部青年發展署雙青計畫行政系統</p>'
                . '<p>' . date('Y-m-d') . '</p>'
                    . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';
  
                    //api_send_email_temp($recipient, $title, $content);
                }

                $reportProcessesCountyStatus = $oneYearsTrendSurveyCountReports ? $this->ReviewProcessModel->get_by_county('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReports->no)->review_status : null;
                $reportProcessesCounselorStatus = $oneYearsTrendSurveyCountReports ? $this->ReviewProcessModel->get_by_counselor('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReports->no)->review_status : null;
                $reportLogs = $oneYearsTrendSurveyCountReports ? $this->ReviewLogModel->get_by_report_no('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReports->no) : null;
                $beSentDataset['reportProcessesCountyStatus'] = $reportProcessesCountyStatus;
                $beSentDataset['reportProcessesCounselorStatus'] = $reportProcessesCounselorStatus;
                $beSentDataset['reportLogs'] = $reportLogs;
            } else {
              $beSentDataset['error'] = '新增失敗';
            }


            $this->load->view('report/one_years_trend_survey_count_report_organization_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function one_years_trend_survey_count_report_yda_table($yearType = null, $monthType = null, $countyType = 'all')
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $userId = $passport['id'];
        $accept_role = array(1, 8, 9);
        if (in_array($current_role, $accept_role)) {
            $county = $countyType ? $countyType : '1';
            $years = $this->ProjectModel->get_distinct_year_by_county('1');
            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }
            if ($monthType == null) {
                $monthType = date("m");
            }
            $months = array('03', '06', '09', '12');
            $countiesName = $this->CountyModel->get_all();

            $oneYearsTrendSurveyCountReports = $this->OneYearsTrendSurveyCountReportModel->get_by_all($yearType, $monthType, $countyType);

            $executeModes = $this->MenuModel->get_by_form_and_column('project', 'execute_mode');
            $executeWays = $this->MenuModel->get_by_form_and_column('project', 'execute_way');
            $counties = $this->CountyModel->get_all();

            $sumDetail = get_seasonal_review_month_report_sum($oneYearsTrendSurveyCountReports);

            $oneYearsTrendSurveyCountReportArray = [];
            $reportProcessesCountyStatusArray = [];
            $reportProcessesYdaStatusArray = [];
            $reportLogsArray = [];
            $countyIdArray = [];
            $isOverTimeArray = [];
            $projectArray = [];

            $processReviewStatuses = $this->MenuModel->get_by_form_and_column('review_process', 'review_status');
            $logReviewStatuses = $this->MenuModel->get_by_form_and_column('review_log', 'review_status');
            $reviewStatus = [];

            $reviewStatus['review_process_not_pass'] = $this->MenuModel->get_no_resource_by_content('未批准', 'review_process')->no;
            $reviewStatus['review_process_pass'] = $this->MenuModel->get_no_resource_by_content('批准', 'review_process')->no;
            $reviewStatus['review_process_wait'] = $this->MenuModel->get_no_resource_by_content('等待送出', 'review_process')->no;

            if ($countyType == 'all') {
                $counties = $this->CountyModel->get_all();
            } else {
                $counties = $this->CountyModel->get_one($countyType);
            }

            foreach ($counties as $county) {
                $projects = $this->ProjectModel->get_latest_by_county($county['no']);
                array_push($projectArray, $projects);

                $oneYearsTrendSurveyCountReport = $this->OneYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county['no']);
                array_push($oneYearsTrendSurveyCountReportArray, $oneYearsTrendSurveyCountReport);

                $reportProcessesCounty = $oneYearsTrendSurveyCountReport ? $this->ReviewProcessModel->get_by_county('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReport->no) : null;
                $reportProcessesCountyStatus = $reportProcessesCounty ? $reportProcessesCounty->review_status : null;

                array_push($reportProcessesCountyStatusArray, $reportProcessesCountyStatus);

                $reportProcessesYda = $oneYearsTrendSurveyCountReport ? $this->ReviewProcessModel->get_by_yda('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReport->no) : null;
                $reportProcessesYdaStatus = $reportProcessesYda ? $reportProcessesYda->review_status : null;
                array_push($reportProcessesYdaStatusArray, $reportProcessesYdaStatus);

                $reportLogs = $oneYearsTrendSurveyCountReport ? $this->ReviewLogModel->get_by_report_no('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReport->no) : null;
                array_push($reportLogsArray, $reportLogs);

                $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
                $addMonth = ($addMonth > 9) ? $addMonth : '0'.$addMonth;
                $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;
                $overTimeDate = ($addYear + 1911) . '-' . $addMonth . '-05 00:00:00'; 
                $countyId = "";
                $isOverTime = 0;
                if ($reportLogs) {
                    foreach ($reportLogs as $value) {
                        if ($value['user_role'] == 3) {
                            $countyId = $value['user_id'];
                            $isOverTime = ($value['time'] > $overTimeDate) ? ($value['time'] > $overTimeDate) : 0;      
                        }
                    }
                    
                }
                array_push($countyIdArray, $countyId);
                array_push($isOverTimeArray, $isOverTime);
            }

            $beSentDataset = array(
                'title' => '表六.' . ($yearType - 3) . '年動向調查追蹤',
                'url' => '/report/one_years_trend_survey_count_report_yda_table/'. $yearType . '/' . $monthType . '/' .$countyType,
                'role' => $current_role,
                'executeModes' => $executeModes,
                'executeWays' => $executeWays,
                'counties' => $counties,
                'countyType' => $countyType,
                'userTitle' => $userTitle,
                'yearType' => $yearType,
                'monthType' => $monthType,
                'oneYearsTrendSurveyCountReports' => $oneYearsTrendSurveyCountReports,
                'years' => $years,
                'months' => $months,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'security' => $this->security,
                'valueSum' => $sumDetail,
                'reportArray' => $oneYearsTrendSurveyCountReportArray,
                'reportProcessesCountyStatusArray' => $reportProcessesCountyStatusArray,
                'reportProcessesYdaStatusArray' => $reportProcessesYdaStatusArray,
                'reportLogsArray' => $reportLogsArray,
                'countyIdArray' => $countyIdArray,
                'reviewStatus' => $reviewStatus,
                'processReviewStatuses' => $processReviewStatuses,
                'isOverTimeArray' => $isOverTimeArray,
                'countiesName' => $countiesName,
                'reviewPage' => 'one_years_trend_survey_count_report_yda_table'
            );

            $reviewStatuses = $this->security->xss_clean($this->input->post('reviewStatus'));
            $comment = $this->security->xss_clean($this->input->post('comment'));

            if (empty($reviewStatuses)) {
                return $this->load->view('report/one_years_trend_survey_count_report_yda_table', $beSentDataset);
            }

            $reportProcessesCountyStatusArray = [];
            $reportProcessesYdaStatusArray = [];
            $reportLogsArray = [];

            if ($monthType % 3 == 0) {
              $reportNameArray = ['high_school_trend_survey_count_report', 'counseling_member_count_report', 'two_years_trend_survey_count_report',
              'one_years_trend_survey_count_report', 'now_years_trend_survey_count_report',
              'old_case_trend_survey_count_report', 'counselor_manpower_report',
              'counseling_identity_count_report', 'counseling_meeting_count_report'];
            } else {
              $reportNameArray = ['counseling_member_count_report', 'counselor_manpower_report',
                'counseling_identity_count_report', 'counseling_meeting_count_report'];
            }        

            for ($i = 0; $i < count($counties); $i++) {
                $reportNoArray = [];
                $reportArray = [];

                $counselingMemberCountReport = $this->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                $counselingMemberCountReportNo = $counselingMemberCountReport ? $counselingMemberCountReport->no : 0;  
                array_push($reportArray, $counselingMemberCountReport);           
                array_push($reportNoArray, $counselingMemberCountReportNo);

                if ($monthType % 3 == 0) {
                  $highSchoolTrendSurveyCountReports = $this->HighSchoolTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                  $highSchoolTrendSurveyCountReportNo = $highSchoolTrendSurveyCountReports ? $highSchoolTrendSurveyCountReports->no : 0;
                  array_push($reportArray, $highSchoolTrendSurveyCountReports);
                  array_push($reportNoArray, $highSchoolTrendSurveyCountReportNo);

                    $twoYearsTrendSurveyCountReports = $this->TwoYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $twoYearsTrendSurveyCountReportNo = $twoYearsTrendSurveyCountReports ? $twoYearsTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $twoYearsTrendSurveyCountReports);
                    array_push($reportNoArray, $twoYearsTrendSurveyCountReportNo);
                
                    $oneYearsTrendSurveyCountReports = $this->OneYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $oneYearsTrendSurveyCountReportNo = $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $oneYearsTrendSurveyCountReports);
                    array_push($reportNoArray, $oneYearsTrendSurveyCountReportNo);
                
                    $nowYearsTrendSurveyCountReports = $this->NowYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $nowYearsTrendSurveyCountReportNo = $nowYearsTrendSurveyCountReports ? $nowYearsTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $nowYearsTrendSurveyCountReports);
                    array_push($reportNoArray, $nowYearsTrendSurveyCountReportNo);
                
                    $oldCaseTrendSurveyCountReports = $this->OldCaseTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $oldCaseTrendSurveyCountReportNo = $oldCaseTrendSurveyCountReports ? $oldCaseTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $oldCaseTrendSurveyCountReports);
                    array_push($reportNoArray, $oldCaseTrendSurveyCountReportNo);
                }
                
                $counselorManpowerReports = $this->CounselorManpowerReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                $counselorManpowerReportNo = $counselorManpowerReports ? $counselorManpowerReports->no : 0;
                array_push($reportArray, $counselorManpowerReports);      
                array_push($reportNoArray, $counselorManpowerReportNo);
                
                $get_inserted_identity_count_data = $this->CounselingIdentityCountReportModel->get_inserted_identity_count_data($yearType, $monthType, $projectArray[$i]->no);
                $counselingIdentityCountReportNo = $get_inserted_identity_count_data ? $get_inserted_identity_count_data->no : 0;
                array_push($reportArray, $get_inserted_identity_count_data);      
                array_push($reportNoArray, $counselingIdentityCountReportNo);
                
                $get_inserted_meeting_count_data = $this->CounselingMeetingCountReportModel->get_inserted_meeting_count_data($yearType, $monthType, $projectArray[$i]->no);
                $counselingMeetingCountReportNo = $get_inserted_meeting_count_data ? $get_inserted_meeting_count_data->no : 0;
                array_push($reportArray, $get_inserted_meeting_count_data);      
                array_push($reportNoArray, $counselingMeetingCountReportNo);

                if ($reviewStatuses == $reviewStatus['review_process_not_pass']) {

                    $this->ReviewProcessModel->update_one('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReportArray[$i]->no, $reviewStatus['review_process_wait'], 3);
                    $this->ReviewProcessModel->update_one('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReportArray[$i]->no, $reviewStatus['review_process_not_pass'], 1);

                    $this->ReviewLogModel->create_one('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReportArray[$i]->no, $reviewStatus['review_process_not_pass'], $comment, $current_role, $userId);
                    $this->ReviewLogModel->create_one('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReportArray[$i]->no, $reviewStatus['review_process_wait'], null, 3, $countyIdArray[$i]);
                
                    $countyContractor = $this->UserModel->get_name_by_id($countyIdArray[$i]);
                    $userName = $this->UserModel->get_name_by_id($userId)->name;
    
                    $recipient = $countyContractor->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】青年署退回' . $yearType . '年' . $monthType .'月 ' . ($yearType - 3) . ' 學年度動向調查追蹤表通知';
                    $content = '<p>' . $countyContractor->name . ' 君 您好:</p>'
                    . '<p>' . $userName . '退回' . $yearType . '年' . $monthType . '月 ' . ($yearType - 3) . ' 學年度動向調查追蹤表</p>'
                    . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';
    
                    //api_send_email_temp($recipient, $title, $content);
                } elseif ($reviewStatuses == $reviewStatus['review_process_pass']) {

                    $this->ReviewProcessModel->update_one('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReportArray[$i]->no, $reviewStatus['review_process_pass'], 1);

                    $this->ReviewLogModel->create_one('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReportArray[$i]->no, $reviewStatus['review_process_pass'], $comment, $current_role, $userId);

                    $check = 1;
                    $count = 0;
                    $reportProcessesCountyStatusArray = $reportProcessesYdaStatusArray = $reportLogsArray = [];
                    foreach($reportNameArray as $reportName) {
 
                      $reportProcessesYda = $reportArray[$count] ? $this->ReviewProcessModel->get_by_yda($reportName, $reportNoArray[$count]) : null;
                      $reportProcessesYdaStatus = $reportProcessesYda ? $reportProcessesYda->review_status : null;
      
                      array_push($reportProcessesYdaStatusArray, $reportProcessesYdaStatus);

                      if($reportProcessesCountyStatus != $reviewStatus['review_process_pass']) {
                        $check = 0;
                      }

                      $count ++;
                    }
                    $userInfo = $this->UserModel->get_name_by_id($userId);
                    if($check) { // 縣市報表全部已繳交
                      $this->TimingReportModel->create_one($counties[$i]['no'], $userInfo->yda, $monthType, $yearType);
                    }
                }
                $reportProcessesCountyStatus = $oneYearsTrendSurveyCountReportArray[$i] ? $this->ReviewProcessModel->get_by_county('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReportArray[$i]->no)->review_status : null;

                array_push($reportProcessesCountyStatusArray, $reportProcessesCountyStatus);

                $reportProcessesYdaStatus = $oneYearsTrendSurveyCountReportArray[$i] ? $this->ReviewProcessModel->get_by_yda('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReportArray[$i]->no)->review_status : null;
                array_push($reportProcessesYdaStatusArray, $reportProcessesYdaStatus);

                $reportLogs = $oneYearsTrendSurveyCountReportArray[$i] ? $this->ReviewLogModel->get_by_report_no('one_years_trend_survey_count_report', $oneYearsTrendSurveyCountReportArray[$i]->no) : null;
                array_push($reportLogsArray, $reportLogs);

                $countyId = "";
                if ($reportLogs) {
                    foreach ($reportLogs as $value) {
                        if ($value['user_role'] == 3) {
                            $countyId = $value['user_id'];
                        }
                    }
                }
                array_push($countyIdArray, $countyId);
            }

            $beSentDataset['reportProcessesCountyStatusArray'] = $reportProcessesCountyStatusArray;
            $beSentDataset['reportProcessesYdaStatusArray'] = $reportProcessesYdaStatusArray;
            $beSentDataset['reportLogsArray'] = $reportLogsArray;

            $this->load->view('report/one_years_trend_survey_count_report_yda_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function now_years_trend_survey_count_report($yearType = null, $monthType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userId = $passport['id'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $countyType = $passport['county'];
            $organization = $passport['organization'];
            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }
            if ($monthType == null) {
                $monthType = date("m");
            }

            $projects = $this->ProjectModel->get_latest_by_county($countyType);
            $countyAndOrg = $this->CountyModel->get_by_county($countyType);
            $nowYearsTrendSurveyCountReports = $this->NowYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $countyType);
          
            $executeModes = $this->MenuModel->get_by_form_and_column('project', 'execute_mode');
            $executeWays = $this->MenuModel->get_by_form_and_column('project', 'execute_way');
            $counties = $this->CountyModel->get_all();

           
                
            $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $yearType - 2, null);
            $surveyTypeData['startDate'] = (date("Y")-1) . '-01-01';
            $surveyTypeData['endDate'] = date("Y") . '-' . ($monthType+1) . '-01';
            $trackData = $this->ReportModel->get_seasonal_review_month_report_by_county($surveyTypeData);
            $sumDetail = get_seasonal_review_sum($trackData);
            $tableValue = get_seasonal_review_table($trackData);

            if ($countyType == 'all') $counties = $this->CountyModel->get_all();
            else $counties = $this->CountyModel->get_one($countyType);
            
            $note = $this->ReportModel->get_seasonal_review_note_month_report_by_county($surveyTypeData);
            $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);

            $processReviewStatuses = $this->MenuModel->get_by_form_and_column('review_process', 'review_status');
            $logReviewStatuses = $this->MenuModel->get_by_form_and_column('review_log', 'review_status');
            $reviewStatus = [];

            $reviewStatus['review_process_not_pass'] = $this->MenuModel->get_no_resource_by_content('未批准', 'review_process')->no;
            $reviewStatus['review_process_pass'] = $this->MenuModel->get_no_resource_by_content('批准', 'review_process')->no;
            $reviewStatus['review_process_wait'] = $this->MenuModel->get_no_resource_by_content('等待送出', 'review_process')->no;

            $reportProcessesCounselor = $nowYearsTrendSurveyCountReports ? $this->ReviewProcessModel->get_by_counselor('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReports->no) : null;
            $reportProcessesCounselorStatus = $reportProcessesCounselor ? $reportProcessesCounselor->review_status : null;
            $reportLogs = $nowYearsTrendSurveyCountReports ? $this->ReviewLogModel->get_by_report_no('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReports->no) : null;

            $beSentDataset = array(
                'title' => '表七.' . ($yearType - 2) . '年動向調查追蹤',
                'url' => '/report/now_years_trend_survey_count_report/' . $yearType . '/' . $monthType,
                'role' => $current_role,
                'executeModes' => $executeModes,
                'executeWays' => $executeWays,
                'counties' => $counties,
                'countyType' => $countyType,
                'userTitle' => $userTitle,
                'projects' => $projects,
                'countyAndOrg' => $countyAndOrg,
                'yearType' => $yearType,
                'monthType' => $monthType,
                'value' => $tableValue,
                'valueSum' => $sumDetail,
                'report' => $nowYearsTrendSurveyCountReports,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'security' => $this->security,
                'reportProcessesCounselorStatus' => $reportProcessesCounselorStatus,
                'reviewStatus' => $reviewStatus,
                'reportLogs' => $reportLogs,
                'processReviewStatuses' => $processReviewStatuses,
                'noteDetail' => $noteDetailArray,
                'type' =>'report_seven'
            );

            foreach ($tableValue as $value) {
              $one = $value['one'];
              $two = $value['two'];
              $three = $value['three'];
              $four = $value['four'];
              $five = $value['five'];
              $six = $value['six'];
              $seven = $value['seven'];
              $eight = $value['eight'];
              $nine = $value['nine'];
              $ten = $value['ten'];
              $eleven = $value['eleven'];
              $twelve = $value['twelve'];
              $thirteen = $value['thirteen'];
              $fourteen = $value['fourteen'];
              $fifteen = $value['fifteen'];
              $sixteen = $value['sixteen'];
              $seventeen = $value['seventeen'];
              $eighteen = $value['eighteen'];
              $nineteen = $value['nineteen'];
            }
            $note = $noteDetailArray[0];

            if (isset($_POST['save']) || isset($_POST['temp'])) {
                if ($nowYearsTrendSurveyCountReports) {
                    $isExecuteSuccess = $this->NowYearsTrendSurveyCountReportModel->udpdate_one_new(
                        $one,
                        $two,
                        $three,
                        $four,
                        $five,
                        $six,
                        $seven,
                        $eight,
                        $nine,
                        $ten,
                        $eleven,
                        $twelve,
                        $thirteen,
                        $fourteen,
                        $fifteen,
                        $sixteen,
                        $seventeen,
                        $eighteen,
                        $nineteen,
                        $note,
                        $monthType,
                        $yearType,
                        $projects->no
                    );

                    $nowYearsTrendSurveyCountReportArray = array($note, $monthType, $yearType, $projects->no);

                    $nowYearsTrendSurveyCountReportNum = 0;
                    foreach ($nowYearsTrendSurveyCountReportArray as $value) {
                        if ($value != null) {
                            $nowYearsTrendSurveyCountReportNum++;
                        }
                    }

                    $nowYearsTrendSurveyCountReportRate = round($nowYearsTrendSurveyCountReportNum / count($nowYearsTrendSurveyCountReportArray), 2) * 100;

                    $nowYearsTrendSurveyCountReportSuccess = $this->CompletionModel->update_one('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReports->no, $nowYearsTrendSurveyCountReportRate);
                } else {
                    $isExecuteSuccess = $this->NowYearsTrendSurveyCountReportModel->create_one_new(
                        $one,
                        $two,
                        $three,
                        $four,
                        $five,
                        $six,
                        $seven,
                        $eight,
                        $nine,
                        $ten,
                        $eleven,
                        $twelve,
                        $thirteen,
                        $fourteen,
                        $fifteen,
                        $sixteen,
                        $seventeen,
                        $eighteen,
                        $nineteen,
                        $note,
                        $monthType,
                        $yearType,
                        $projects->no
                    );

                    $nowYearsTrendSurveyCountReportArray = array($note, $monthType, $yearType, $projects->no);

                    $nowYearsTrendSurveyCountReportNum = 0;
                    foreach ($nowYearsTrendSurveyCountReportArray as $value) {
                        if ($value != null) {
                            $nowYearsTrendSurveyCountReportNum++;
                        }
                    }

                    $nowYearsTrendSurveyCountReportRate = round($nowYearsTrendSurveyCountReportNum / count($nowYearsTrendSurveyCountReportArray), 2) * 100;

                    $nowYearsTrendSurveyCountReportSuccess = $this->CompletionModel->create_one('now_years_trend_survey_count_report', $isExecuteSuccess, $nowYearsTrendSurveyCountReportRate);
                }

                if ($isExecuteSuccess) {
                    $beSentDataset['success'] = '新增成功';
                    if (isset($_POST['save'])) {
                        $nowYearsTrendSurveyCountReports = $this->NowYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $countyType);
                        $reportProcesses = $this->ReviewProcessModel->get_by_report_no('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReports->no);
                        if ($reportProcesses) {
                            $this->ReviewProcessModel->update_one('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReports->no, $reviewStatus['review_process_pass'], 6);
                            $this->ReviewProcessModel->update_one('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], 3);
                        } else {
                            $this->ReviewProcessModel->create_one('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReports->no, $reviewStatus['review_process_pass'], 6);
                            $this->ReviewProcessModel->create_one('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], 3);
                            $this->ReviewProcessModel->create_one('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReports->no, $reviewStatus['review_process_not_pass'], 1);
                        }
                        $countyContractor = $this->UserModel->get_latest_county_contractor($countyType);
                        $this->ReviewLogModel->create_one('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReports->no, $reviewStatus['review_process_pass'], null, $current_role, $userId);
                        $this->ReviewLogModel->create_one('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], null, 3, $countyContractor->id);

                        $countyContractor = $this->UserModel->get_by_county_contractor($countyType);
                        $userName = $this->UserModel->get_name_by_id($userId)->name;

                        $recipient = $countyContractor->email;
                        $title = '【教育部青年發展署雙青計畫行政系統】輔導員繳交' . $yearType . '年' . $monthType . '月 ' . ($yearType - 2) . '學年度動向調查追蹤表通知';
                        $content = '<p>' . $countyContractor->name . ' 君 您好:</p>'
                  . '<p>' . $userName . '繳交' . $yearType . '年' . $monthType . '月 ' . ($yearType - 2) . '學年度動向調查追蹤表</p>'
                  . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
                  . '<p>祝 平安快樂</p><p></p>'
                  . '<p>教育部青年發展署雙青計畫行政系統</p>'
                  . '<p>' . date('Y-m-d') . '</p>'
                      . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                        //api_send_email_temp($recipient, $title, $content);

                        $reportProcessesCounselorStatus = $nowYearsTrendSurveyCountReports ? $this->ReviewProcessModel->get_by_counselor('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReports->no)->review_status : null;
                        $reportLogs = $nowYearsTrendSurveyCountReports ? $this->ReviewLogModel->get_by_report_no('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReports->no) : null;
                        $beSentDataset['reportProcessesCounselorStatus'] = $reportProcessesCounselorStatus;
                        $beSentDataset['reportLogs'] = $reportLogs;
                    }
                } else {
                    $beSentDataset['error'] = '新增失敗';
                }
            }

            $nowYearsTrendSurveyCountReports = $this->NowYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $countyType);
            $beSentDataset['report'] = $nowYearsTrendSurveyCountReports;

            $this->load->view('report/now_years_trend_survey_count_report', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function now_years_trend_survey_count_report_organization_table($yearType = null, $monthType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $userId = $passport['id'];
        $accept_role = array(2, 3, 4, 5);
        if (in_array($current_role, $accept_role)) {
            $county = $passport['county'];
            $years = $this->ProjectModel->get_distinct_year_by_county($county);
            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }
            if ($monthType == null) {
                $monthType = date("m");
            }
            $months = array('03', '06', '09', '12');

            $county = $passport['county'];
            $organization = $passport['organization'];

            $projects = $this->ProjectModel->get_latest_by_county($county);
            $countyAndOrg = $this->CountyModel->get_by_county($county);
            $nowYearsTrendSurveyCountReports = $this->NowYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
            $youthCount = $this->YouthModel->get_now_years_trend_by_county($county);
            $executeModes = $this->MenuModel->get_by_form_and_column('project', 'execute_mode');
            $executeWays = $this->MenuModel->get_by_form_and_column('project', 'execute_way');
            $counties = $this->CountyModel->get_all();

            $processReviewStatuses = $this->MenuModel->get_by_form_and_column('review_process', 'review_status');
            $logReviewStatuses = $this->MenuModel->get_by_form_and_column('review_log', 'review_status');
            $reviewStatus = [];

            $reviewStatus['review_process_not_pass'] = $this->MenuModel->get_no_resource_by_content('未批准', 'review_process')->no;
            $reviewStatus['review_process_pass'] = $this->MenuModel->get_no_resource_by_content('批准', 'review_process')->no;
            $reviewStatus['review_process_wait'] = $this->MenuModel->get_no_resource_by_content('等待送出', 'review_process')->no;

            $reportProcessesCounty = $nowYearsTrendSurveyCountReports ? $this->ReviewProcessModel->get_by_county('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReports->no) : null;
            $reportProcessesCountyStatus = $reportProcessesCounty ? $reportProcessesCounty->review_status : null;
            $reportProcessesCounselor = $nowYearsTrendSurveyCountReports ? $this->ReviewProcessModel->get_by_counselor('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReports->no) : null;
            $reportProcessesCounselorStatus = $reportProcessesCounselor ? $reportProcessesCounselor->review_status : null;
            $reportLogs = $nowYearsTrendSurveyCountReports ? $this->ReviewLogModel->get_by_report_no('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReports->no) : null;

            $counselorId = "";
            if ($reportLogs) {
              foreach ($reportLogs as $value) {
                  if ($value['user_role'] == 6) {
                      $counselorId = $value['user_id'];
                  }
              }
            }

            $countyName = "";
            foreach ($counties as $value) {
                if ($value['no'] == $county) {
                    $countyName = $value['name'];
                }
            }


            $beSentDataset = array(
                'title' => '表七.' . ($yearType - 2) . '年動向調查追蹤',
                'url' => '/report/now_years_trend_survey_count_report_organization_table/'. $yearType . '/' .$monthType,
                'role' => $current_role,
                'executeModes' => $executeModes,
                'executeWays' => $executeWays,
                'counties' => $counties,
                'countyType' => $county,
                'userTitle' => $userTitle,
                'projects' => $projects,
                'countyAndOrg' => $countyAndOrg,
                'yearType' => $yearType,
                'monthType' => $monthType,
                'youthCount' => $youthCount,
                'report' => $nowYearsTrendSurveyCountReports,
                'years' => $years,
                'months' => $months,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'security' => $this->security,
                'reportProcessesCountyStatus' => $reportProcessesCountyStatus,
                'reportProcessesCounselorStatus' => $reportProcessesCounselorStatus,
                'reviewStatus' => $reviewStatus,
                'reportLogs' => $reportLogs,
                'processReviewStatuses' => $processReviewStatuses,
                'value' => null,
                'valueSum' => null,
                'countyName' => $countyName
            );

            $reviewStatuses = $this->security->xss_clean($this->input->post('reviewStatus'));
            $comment = $this->security->xss_clean($this->input->post('comment'));
            $reportFile = $nowYearsTrendSurveyCountReports ? $nowYearsTrendSurveyCountReports->report_file : null;

            if (empty($reviewStatuses)) {
                return $this->load->view('report/now_years_trend_survey_count_report_organization_table', $beSentDataset);
            }

            if ($monthType % 3 == 0) {
              $reportNameArray = ['high_school_trend_survey_count_report', 'counseling_member_count_report', 'two_years_trend_survey_count_report',
                  'one_years_trend_survey_count_report', 'now_years_trend_survey_count_report',
                  'old_case_trend_survey_count_report', 'counselor_manpower_report',
                  'counseling_identity_count_report', 'counseling_meeting_count_report'];
            } else {
                $reportNameArray = ['counseling_member_count_report', 'counselor_manpower_report',
                  'counseling_identity_count_report', 'counseling_meeting_count_report'];
            }

            $reportNoArray = [];
            $reportArray = [];

            $counselingMemberCountReport = $this->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $county);
            $counselingMemberCountReportNo = $counselingMemberCountReport ? $counselingMemberCountReport->no : 0;  
            array_push($reportArray, $counselingMemberCountReport);           
            array_push($reportNoArray, $counselingMemberCountReportNo);

            if ($monthType % 3 == 0) {

              $highSchoolTrendSurveyCountReports = $this->HighSchoolTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
              $highSchoolTrendSurveyCountReportNo = $highSchoolTrendSurveyCountReports ? $highSchoolTrendSurveyCountReports->no : 0;
              array_push($reportArray, $highSchoolTrendSurveyCountReports);
              array_push($reportNoArray, $highSchoolTrendSurveyCountReportNo);

                $twoYearsTrendSurveyCountReports = $this->TwoYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $twoYearsTrendSurveyCountReportNo = $twoYearsTrendSurveyCountReports ? $twoYearsTrendSurveyCountReports->no : 0;
                array_push($reportArray, $twoYearsTrendSurveyCountReports);
                array_push($reportNoArray, $twoYearsTrendSurveyCountReportNo);
            
                $oneYearsTrendSurveyCountReports = $this->OneYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $oneYearsTrendSurveyCountReportNo = $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->no : 0;
                array_push($reportArray, $oneYearsTrendSurveyCountReports);
                array_push($reportNoArray, $oneYearsTrendSurveyCountReportNo);
            
                $nowYearsTrendSurveyCountReports = $this->NowYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $nowYearsTrendSurveyCountReportNo = $nowYearsTrendSurveyCountReports ? $nowYearsTrendSurveyCountReports->no : 0;
                array_push($reportArray, $nowYearsTrendSurveyCountReports);
                array_push($reportNoArray, $nowYearsTrendSurveyCountReportNo);
            
                $oldCaseTrendSurveyCountReports = $this->OldCaseTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $oldCaseTrendSurveyCountReportNo = $oldCaseTrendSurveyCountReports ? $oldCaseTrendSurveyCountReports->no : 0;
                array_push($reportArray, $oldCaseTrendSurveyCountReports);
                array_push($reportNoArray, $oldCaseTrendSurveyCountReportNo);
            }
            
            $counselorManpowerReports = $this->CounselorManpowerReportModel->get_by_no($yearType, $monthType, $county);
            $counselorManpowerReportNo = $counselorManpowerReports ? $counselorManpowerReports->no : 0;
            array_push($reportArray, $counselorManpowerReports);      
            array_push($reportNoArray, $counselorManpowerReportNo);
            
            $get_inserted_identity_count_data = $this->CounselingIdentityCountReportModel->get_inserted_identity_count_data($yearType, $monthType, $projects->no);
            $counselingIdentityCountReportNo = $get_inserted_identity_count_data ? $get_inserted_identity_count_data->no : 0;
            array_push($reportArray, $get_inserted_identity_count_data);      
            array_push($reportNoArray, $counselingIdentityCountReportNo);
            
            $get_inserted_meeting_count_data = $this->CounselingMeetingCountReportModel->get_inserted_meeting_count_data($yearType, $monthType, $projects->no);
            $counselingMeetingCountReportNo = $get_inserted_meeting_count_data ? $get_inserted_meeting_count_data->no : 0;
            array_push($reportArray, $get_inserted_meeting_count_data);      
            array_push($reportNoArray, $counselingMeetingCountReportNo);

            // file format define
            // 檔案內容大小限制5000KB,並支援JPG,PNG,PDF
            $config['upload_path'] = './files/';
            $config['allowed_types'] = 'jpg|png|pdf';
            $config['max_size'] = 5000;
            $config['max_width'] = 5000;
            $config['max_height'] = 5000;
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);
            // upload family diagram
            if ($this->upload->do_upload('reportFile')) {
                $fileMetaData = $this->upload->data();
                $reportFile = $this->FileModel->create_one($nowYearsTrendSurveyCountReports->no, $fileMetaData['file_name'], $fileMetaData['orig_name']);
            }

            $isUpdateReportFile = $this->NowYearsTrendSurveyCountReportModel->update_file_by_no($nowYearsTrendSurveyCountReports->no, $reportFile);
            if ($isUpdateReportFile) {
                if ($reviewStatuses == $reviewStatus['review_process_not_pass']) {
                    $this->ReviewProcessModel->update_one('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], 6);
                    $this->ReviewProcessModel->update_one('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReports->no, $reviewStatus['review_process_not_pass'], 3);

                    $this->ReviewLogModel->create_one('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReports->no, $reviewStatus['review_process_not_pass'], $comment, $current_role, $userId);
                    $this->ReviewLogModel->create_one('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], null, 6, $counselorId);
            
                    $counselorInfo = $this->UserModel->get_name_by_id($counselorId);
                    $userName = $this->UserModel->get_name_by_id($userId)->name;

                    $recipient = $counselorInfo->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】縣市承辦人退回' . $yearType . '年' . $monthType .'月 ' . ($yearType - 2) . '學年度動向調查追蹤表通知';
                    $content = '<p>' . $counselorInfo->name . ' 君 您好:</p>'
                . '<p>' . $userName . '退回' . $yearType . '年' . $monthType . '月 ' . ($yearType - 2) . '學年度動向調查追蹤表</p>'
                . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
                . '<p>祝 平安快樂</p><p></p>'
                . '<p>教育部青年發展署雙青計畫行政系統</p>'
                . '<p>' . date('Y-m-d') . '</p>'
                    . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipient, $title, $content);
                } elseif ($reviewStatuses == $reviewStatus['review_process_pass']) {
                    $ydaContractor = 'yda';
                    $this->ReviewProcessModel->update_one('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], 1);
                    $this->ReviewProcessModel->update_one('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReports->no, $reviewStatus['review_process_pass'], 3);

                    $this->ReviewLogModel->create_one('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReports->no, $reviewStatus['review_process_pass'], $comment, $current_role, $userId);
                    $this->ReviewLogModel->create_one('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], null, 1, $ydaContractor);
            
                    $check = 1;
                    $count = 0;
                    $reportProcessesCountyStatusArray = $reportProcessesYdaStatusArray = $reportLogsArray = [];
                    foreach ($reportNameArray as $reportName) {
                        $reportProcessesCounty = $reportArray[$count] ? $this->ReviewProcessModel->get_by_county($reportName, $reportNoArray[$count]) : null;
                        $reportProcessesCountyStatus = $reportProcessesCounty ? $reportProcessesCounty->review_status : null;
  
                        if ($reportProcessesCountyStatus != $reviewStatus['review_process_pass']) {
                            $check = 0;
                        }
                        array_push($reportProcessesCountyStatusArray, $reportProcessesCountyStatus);
                        $count++;
                    }
  
                    if ($check) { // 縣市報表全部已繳交
                        $this->TimingReportModel->create_one($county, null, $monthType, $yearType);
                    }
                
                    $ydaInfo = $this->UserModel->get_by_yda_row();
                    $userName = $this->UserModel->get_name_by_id($userId)->name;
  
                    $recipient = $ydaInfo->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】' . $countyName . '承辦人繳交' . $yearType . '年' . $monthType .'月' . ($yearType - 2) . '學年度動向調查追蹤表通知';
                    $content = '<p>' . $ydaInfo->name . ' 君 您好:</p>'
                . '<p>' . $countyName . '承辦人繳交' . $yearType . '年' . $monthType . '月 ' . ($yearType - 2) . '學年度動向調查追蹤表</p>'
                . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
                . '<p>祝 平安快樂</p><p></p>'
                . '<p>教育部青年發展署雙青計畫行政系統</p>'
                . '<p>' . date('Y-m-d') . '</p>'
                    . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';
  
                    //api_send_email_temp($recipient, $title, $content);
                }

                $reportProcessesCountyStatus = $nowYearsTrendSurveyCountReports ? $this->ReviewProcessModel->get_by_county('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReports->no)->review_status : null;
                $reportProcessesCounselorStatus = $nowYearsTrendSurveyCountReports ? $this->ReviewProcessModel->get_by_counselor('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReports->no)->review_status : null;
                $reportLogs = $nowYearsTrendSurveyCountReports ? $this->ReviewLogModel->get_by_report_no('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReports->no) : null;
                $beSentDataset['reportProcessesCountyStatus'] = $reportProcessesCountyStatus;
                $beSentDataset['reportProcessesCounselorStatus'] = $reportProcessesCounselorStatus;
                $beSentDataset['reportLogs'] = $reportLogs;
            } else {
              $beSentDataset['error'] = '新增失敗';
            }

            $this->load->view('report/now_years_trend_survey_count_report_organization_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function now_years_trend_survey_count_report_yda_table($yearType = null, $monthType = null, $countyType = 'all')
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $userId = $passport['id'];
        $accept_role = array(1, 8, 9);
        if (in_array($current_role, $accept_role)) {
            $county = $countyType ? $countyType : '1';
            $years = $this->ProjectModel->get_distinct_year_by_county('1');
            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }
            if ($monthType == null) {
                $monthType = date("m");
            }
            $months = array('03', '06', '09', '12');
            $countiesName = $this->CountyModel->get_all();

            $nowYearsTrendSurveyCountReports = $this->NowYearsTrendSurveyCountReportModel->get_by_all($yearType, $monthType, $countyType);

            $executeModes = $this->MenuModel->get_by_form_and_column('project', 'execute_mode');
            $executeWays = $this->MenuModel->get_by_form_and_column('project', 'execute_way');
            $counties = $this->CountyModel->get_all();

            $sumDetail = get_seasonal_review_month_report_sum($nowYearsTrendSurveyCountReports);

            $nowYearsTrendSurveyCountReportArray = [];
            $reportProcessesCountyStatusArray = [];
            $reportProcessesYdaStatusArray = [];
            $reportLogsArray = [];
            $countyIdArray = [];
            $isOverTimeArray = [];
            $projectArray = [];

            $processReviewStatuses = $this->MenuModel->get_by_form_and_column('review_process', 'review_status');
            $logReviewStatuses = $this->MenuModel->get_by_form_and_column('review_log', 'review_status');
            $reviewStatus = [];

            $reviewStatus['review_process_not_pass'] = $this->MenuModel->get_no_resource_by_content('未批准', 'review_process')->no;
            $reviewStatus['review_process_pass'] = $this->MenuModel->get_no_resource_by_content('批准', 'review_process')->no;
            $reviewStatus['review_process_wait'] = $this->MenuModel->get_no_resource_by_content('等待送出', 'review_process')->no;

            if ($countyType == 'all') {
                $counties = $this->CountyModel->get_all();
            } else {
                $counties = $this->CountyModel->get_one($countyType);
            }

            foreach ($counties as $county) {
                $projects = $this->ProjectModel->get_latest_by_county($county['no']);
                array_push($projectArray, $projects);

                $nowYearsTrendSurveyCountReport = $this->NowYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county['no']);
                array_push($nowYearsTrendSurveyCountReportArray, $nowYearsTrendSurveyCountReport);

                $reportProcessesCounty = $nowYearsTrendSurveyCountReport ? $this->ReviewProcessModel->get_by_county('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReport->no) : null;
                $reportProcessesCountyStatus = $reportProcessesCounty ? $reportProcessesCounty->review_status : null;

                array_push($reportProcessesCountyStatusArray, $reportProcessesCountyStatus);

                $reportProcessesYda = $nowYearsTrendSurveyCountReport ? $this->ReviewProcessModel->get_by_yda('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReport->no) : null;
                $reportProcessesYdaStatus = $reportProcessesYda ? $reportProcessesYda->review_status : null;
                array_push($reportProcessesYdaStatusArray, $reportProcessesYdaStatus);

                $reportLogs = $nowYearsTrendSurveyCountReport ? $this->ReviewLogModel->get_by_report_no('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReport->no) : null;
                array_push($reportLogsArray, $reportLogs);

                $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
                $addMonth = ($addMonth > 9) ? $addMonth : '0'.$addMonth;
                $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;
                $overTimeDate = ($addYear + 1911) . '-' . $addMonth . '-05 00:00:00'; 
                $countyId = "";
                $isOverTime = 0;
                if ($reportLogs) {
                    foreach ($reportLogs as $value) {
                        if ($value['user_role'] == 3) {
                            $countyId = $value['user_id'];
                            $isOverTime = ($value['time'] > $overTimeDate) ? ($value['time'] > $overTimeDate) : 0;      
                        }
                    }
                    
                }
                array_push($countyIdArray, $countyId);
                array_push($isOverTimeArray, $isOverTime);
            }


            $beSentDataset = array(
                'title' => '表七.' . ($yearType - 2) . '年動向調查追蹤',
                'url' => '/report/now_years_trend_survey_count_report_yda_table/'. $yearType . '/' . $monthType . '/' .$countyType,
                'role' => $current_role,
                'executeModes' => $executeModes,
                'executeWays' => $executeWays,
                'counties' => $counties,
                'countyType' => $countyType,
                'userTitle' => $userTitle,
                'yearType' => $yearType,
                'monthType' => $monthType,
                'nowYearsTrendSurveyCountReports' => $nowYearsTrendSurveyCountReports,
                'years' => $years,
                'months' => $months,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'security' => $this->security,
                'valueSum' => $sumDetail,
                'reportArray' => $nowYearsTrendSurveyCountReportArray,
                'reportProcessesCountyStatusArray' => $reportProcessesCountyStatusArray,
                'reportProcessesYdaStatusArray' => $reportProcessesYdaStatusArray,
                'reportLogsArray' => $reportLogsArray,
                'countyIdArray' => $countyIdArray,
                'reviewStatus' => $reviewStatus,
                'processReviewStatuses' => $processReviewStatuses,
                'isOverTimeArray' => $isOverTimeArray,
                'countiesName' => $countiesName,
                'reviewPage' => 'now_years_trend_survey_count_report_yda_table'
            );

            $reviewStatuses = $this->security->xss_clean($this->input->post('reviewStatus'));
            $comment = $this->security->xss_clean($this->input->post('comment'));

            if (empty($reviewStatuses)) {
                return $this->load->view('report/now_years_trend_survey_count_report_yda_table', $beSentDataset);
            }

            $reportProcessesCountyStatusArray = [];
            $reportProcessesYdaStatusArray = [];
            $reportLogsArray = [];

            if ($monthType % 3 == 0) {
              $reportNameArray = ['high_school_trend_survey_count_report', 'counseling_member_count_report', 'two_years_trend_survey_count_report',
              'one_years_trend_survey_count_report', 'now_years_trend_survey_count_report',
              'old_case_trend_survey_count_report', 'counselor_manpower_report',
              'counseling_identity_count_report', 'counseling_meeting_count_report'];
            } else {
              $reportNameArray = ['counseling_member_count_report', 'counselor_manpower_report',
                'counseling_identity_count_report', 'counseling_meeting_count_report'];
            }      

            for ($i = 0; $i < count($counties); $i++) {

                $reportNoArray = [];
                $reportArray = [];

                $counselingMemberCountReport = $this->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                $counselingMemberCountReportNo = $counselingMemberCountReport ? $counselingMemberCountReport->no : 0;  
                array_push($reportArray, $counselingMemberCountReport);           
                array_push($reportNoArray, $counselingMemberCountReportNo);

                if ($monthType % 3 == 0) {
                  $highSchoolTrendSurveyCountReports = $this->HighSchoolTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                  $highSchoolTrendSurveyCountReportNo = $highSchoolTrendSurveyCountReports ? $highSchoolTrendSurveyCountReports->no : 0;
                  array_push($reportArray, $highSchoolTrendSurveyCountReports);
                  array_push($reportNoArray, $highSchoolTrendSurveyCountReportNo);

                    $twoYearsTrendSurveyCountReports = $this->TwoYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $twoYearsTrendSurveyCountReportNo = $twoYearsTrendSurveyCountReports ? $twoYearsTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $twoYearsTrendSurveyCountReports);
                    array_push($reportNoArray, $twoYearsTrendSurveyCountReportNo);
                
                    $oneYearsTrendSurveyCountReports = $this->OneYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $oneYearsTrendSurveyCountReportNo = $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $oneYearsTrendSurveyCountReports);
                    array_push($reportNoArray, $oneYearsTrendSurveyCountReportNo);
                
                    $nowYearsTrendSurveyCountReports = $this->NowYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $nowYearsTrendSurveyCountReportNo = $nowYearsTrendSurveyCountReports ? $nowYearsTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $nowYearsTrendSurveyCountReports);
                    array_push($reportNoArray, $nowYearsTrendSurveyCountReportNo);
                
                    $oldCaseTrendSurveyCountReports = $this->OldCaseTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $oldCaseTrendSurveyCountReportNo = $oldCaseTrendSurveyCountReports ? $oldCaseTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $oldCaseTrendSurveyCountReports);
                    array_push($reportNoArray, $oldCaseTrendSurveyCountReportNo);
                }
                
                $counselorManpowerReports = $this->CounselorManpowerReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                $counselorManpowerReportNo = $counselorManpowerReports ? $counselorManpowerReports->no : 0;
                array_push($reportArray, $counselorManpowerReports);      
                array_push($reportNoArray, $counselorManpowerReportNo);
                
                $get_inserted_identity_count_data = $this->CounselingIdentityCountReportModel->get_inserted_identity_count_data($yearType, $monthType, $projectArray[$i]->no);
                $counselingIdentityCountReportNo = $get_inserted_identity_count_data ? $get_inserted_identity_count_data->no : 0;
                array_push($reportArray, $get_inserted_identity_count_data);      
                array_push($reportNoArray, $counselingIdentityCountReportNo);
                
                $get_inserted_meeting_count_data = $this->CounselingMeetingCountReportModel->get_inserted_meeting_count_data($yearType, $monthType, $projectArray[$i]->no);
                $counselingMeetingCountReportNo = $get_inserted_meeting_count_data ? $get_inserted_meeting_count_data->no : 0;
                array_push($reportArray, $get_inserted_meeting_count_data);      
                array_push($reportNoArray, $counselingMeetingCountReportNo);

                if ($reviewStatuses == $reviewStatus['review_process_not_pass']) {

                    $this->ReviewProcessModel->update_one('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReportArray[$i]->no, $reviewStatus['review_process_wait'], 3);
                    $this->ReviewProcessModel->update_one('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReportArray[$i]->no, $reviewStatus['review_process_not_pass'], 1);

                    $this->ReviewLogModel->create_one('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReportArray[$i]->no, $reviewStatus['review_process_not_pass'], $comment, $current_role, $userId);
                    $this->ReviewLogModel->create_one('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReportArray[$i]->no, $reviewStatus['review_process_wait'], null, 3, $countyIdArray[$i]);
                
                    $countyContractor = $this->UserModel->get_name_by_id($countyIdArray[$i]);
                    $userName = $this->UserModel->get_name_by_id($userId)->name;
    
                    $recipient = $countyContractor->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】青年署退回' . $yearType . '年' . $monthType .'月 ' . ($yearType - 2) . ' 學年度動向調查追蹤表通知';
                    $content = '<p>' . $countyContractor->name . ' 君 您好:</p>'
                    . '<p>' . $userName . '退回' . $yearType . '年' . $monthType . '月 ' . ($yearType - 2) . ' 學年度動向調查追蹤表</p>'
                    . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';
    
                    //api_send_email_temp($recipient, $title, $content);
                } elseif ($reviewStatuses == $reviewStatus['review_process_pass']) {

                    $this->ReviewProcessModel->update_one('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReportArray[$i]->no, $reviewStatus['review_process_pass'], 1);

                    $this->ReviewLogModel->create_one('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReportArray[$i]->no, $reviewStatus['review_process_pass'], $comment, $current_role, $userId);

                    $check = 1;
                    $count = 0;
                    $reportProcessesCountyStatusArray = $reportProcessesYdaStatusArray = $reportLogsArray = [];
                    foreach($reportNameArray as $reportName) {
 
                      $reportProcessesYda = $reportArray[$count] ? $this->ReviewProcessModel->get_by_yda($reportName, $reportNoArray[$count]) : null;
                      $reportProcessesYdaStatus = $reportProcessesYda ? $reportProcessesYda->review_status : null;
      
                      array_push($reportProcessesYdaStatusArray, $reportProcessesYdaStatus);

                      if($reportProcessesCountyStatus != $reviewStatus['review_process_pass']) {
                        $check = 0;
                      }

                      $count ++;
                    }
                    $userInfo = $this->UserModel->get_name_by_id($userId);
                    if($check) { // 縣市報表全部已繳交
                      $this->TimingReportModel->create_one($counties[$i]['no'], $userInfo->yda, $monthType, $yearType);
                    }
                }
                $reportProcessesCountyStatus = $nowYearsTrendSurveyCountReportArray[$i] ? $this->ReviewProcessModel->get_by_county('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReportArray[$i]->no)->review_status : null;

                array_push($reportProcessesCountyStatusArray, $reportProcessesCountyStatus);

                $reportProcessesYdaStatus = $nowYearsTrendSurveyCountReportArray[$i] ? $this->ReviewProcessModel->get_by_yda('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReportArray[$i]->no)->review_status : null;
                array_push($reportProcessesYdaStatusArray, $reportProcessesYdaStatus);

                $reportLogs = $nowYearsTrendSurveyCountReportArray[$i] ? $this->ReviewLogModel->get_by_report_no('now_years_trend_survey_count_report', $nowYearsTrendSurveyCountReportArray[$i]->no) : null;
                array_push($reportLogsArray, $reportLogs);

                $countyId = "";
                if ($reportLogs) {
                    foreach ($reportLogs as $value) {
                        if ($value['user_role'] == 3) {
                            $countyId = $value['user_id'];
                        }
                    }
                }
                array_push($countyIdArray, $countyId);
            }

            $beSentDataset['reportProcessesCountyStatusArray'] = $reportProcessesCountyStatusArray;
            $beSentDataset['reportProcessesYdaStatusArray'] = $reportProcessesYdaStatusArray;
            $beSentDataset['reportLogsArray'] = $reportLogsArray;

            $this->load->view('report/now_years_trend_survey_count_report_yda_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function old_case_trend_survey_count_report($yearType = null, $monthType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $userId = $passport['id'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $countyType = $passport['county'];
            $organization = $passport['organization'];

            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }
            if ($monthType == null) {
                $monthType = date("m");
            }

            $projects = $this->ProjectModel->get_latest_by_county($countyType);
            $countyAndOrg = $this->CountyModel->get_by_county($countyType);
            $oldCaseTrendSurveyCountReports = $this->OldCaseTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $countyType);
            $source = $this->MenuModel->get_no_resource_by_content('轉介或自行開發', 'youth')->no;

           
            $executeModes = $this->MenuModel->get_by_form_and_column('project', 'execute_mode');
            $executeWays = $this->MenuModel->get_by_form_and_column('project', 'execute_way');
            $counties = $this->CountyModel->get_all();

            $surveyTypeData = get_seasonal_review_trend_menu_no($countyType, $yearType - 1, null);
            $surveyTypeData['startDate'] = (date("Y")-1) . '-01-01';
            $surveyTypeData['endDate'] = date("Y") . '-' . ($monthType+1) . '-01';
            $trackData = $this->ReportModel->get_old_case_seasonal_review_month_report_by_county($surveyTypeData);
            $sumDetail = get_seasonal_review_sum($trackData);
            $tableValue = get_seasonal_review_table($trackData);
          
            if ($countyType == 'all') $counties = $this->CountyModel->get_all();
            else $counties = $this->CountyModel->get_one($countyType);
            
            $note = $this->ReportModel->get_old_case_seasonal_review_note_month_report_by_county($surveyTypeData);
            $noteDetailArray = get_seasonal_review_note($counties, $surveyTypeData, $note);


            $processReviewStatuses = $this->MenuModel->get_by_form_and_column('review_process', 'review_status');
            $logReviewStatuses = $this->MenuModel->get_by_form_and_column('review_log', 'review_status');
            $reviewStatus = [];

            $reviewStatus['review_process_not_pass'] = $this->MenuModel->get_no_resource_by_content('未批准', 'review_process')->no;
            $reviewStatus['review_process_pass'] = $this->MenuModel->get_no_resource_by_content('批准', 'review_process')->no;
            $reviewStatus['review_process_wait'] = $this->MenuModel->get_no_resource_by_content('等待送出', 'review_process')->no;

            $reportProcessesCounselor = $oldCaseTrendSurveyCountReports ? $this->ReviewProcessModel->get_by_counselor('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReports->no) : null;
            $reportProcessesCounselorStatus = $reportProcessesCounselor ? $reportProcessesCounselor->review_status : null;
            $reportLogs = $oldCaseTrendSurveyCountReports ? $this->ReviewLogModel->get_by_report_no('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReports->no) : null;

            $beSentDataset = array(
                'title' => '表八.前一年結案後動向調查追蹤',
                'url' => '/report/old_case_trend_survey_count_report/' . $yearType . '/' . $monthType,
                'role' => $current_role,
                'executeModes' => $executeModes,
                'executeWays' => $executeWays,
                'counties' => $counties,
                'countyType' => $countyType,
                'userTitle' => $userTitle,
                'projects' => $projects,
                'countyAndOrg' => $countyAndOrg,
                'yearType' => $yearType,
                'monthType' => $monthType,
                'value' => $tableValue,
                'valueSum' => $sumDetail,
                'report' => $oldCaseTrendSurveyCountReports,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'security' => $this->security,
                'reportProcessesCounselorStatus' => $reportProcessesCounselorStatus,
                'reviewStatus' => $reviewStatus,
                'reportLogs' => $reportLogs,
                'processReviewStatuses' => $processReviewStatuses,
                'noteDetail' => $noteDetailArray,
                'type' => 'report_eight'
            );

            foreach ($tableValue as $value) {
              $one = $value['one'];
              $two = $value['two'];
              $three = $value['three'];
              $four = $value['four'];
              $five = $value['five'];
              $six = $value['six'];
              $seven = $value['seven'];
              $eight = $value['eight'];
              $nine = $value['nine'];
              $ten = $value['ten'];
              $eleven = $value['eleven'];
              $twelve = $value['twelve'];
              $thirteen = $value['thirteen'];
              $fourteen = $value['fourteen'];
              $fifteen = $value['fifteen'];
              $sixteen = $value['sixteen'];
              $seventeen = $value['seventeen'];
              $eighteen = $value['eighteen'];
              $nineteen = $value['nineteen'];
            }
            $note = $noteDetailArray[0];

            // if (empty($note)) {
            //     return $this->load->view('report/old_case_trend_survey_count_report', $beSentDataset);
            // }
            if (isset($_POST['save']) || isset($_POST['temp'])) {
                if ($oldCaseTrendSurveyCountReports) {
                    $isExecuteSuccess = $this->OldCaseTrendSurveyCountReportModel->udpdate_one_new(
                        $one,
                        $two,
                        $three,
                        $four,
                        $five,
                        $six,
                        $seven,
                        $eight,
                        $nine,
                        $ten,
                        $eleven,
                        $twelve,
                        $thirteen,
                        $fourteen,
                        $fifteen,
                        $sixteen,
                        $seventeen,
                        $eighteen,
                        $nineteen,
                        $note,
                        $monthType,
                        $yearType,
                        $projects->no
                    );

                    $oldCaseTrendSurveyCountReportArray = array($note, $monthType, $yearType, $projects->no);

                    $oldCaseTrendSurveyCountReportNum = 0;
                    foreach ($oldCaseTrendSurveyCountReportArray as $value) {
                        if ($value != null) {
                            $oldCaseTrendSurveyCountReportNum++;
                        }
                    }

                    $oldCaseTrendSurveyCountReportRate = round($oldCaseTrendSurveyCountReportNum / count($oldCaseTrendSurveyCountReportArray), 2) * 100;

                    $oldCaseTrendSurveyCountReportSuccess = $this->CompletionModel->update_one('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReports->no, $oldCaseTrendSurveyCountReportRate);
                } else {
                    $isExecuteSuccess = $this->OldCaseTrendSurveyCountReportModel->create_one_new(
                        $one,
                        $two,
                        $three,
                        $four,
                        $five,
                        $six,
                        $seven,
                        $eight,
                        $nine,
                        $ten,
                        $eleven,
                        $twelve,
                        $thirteen,
                        $fourteen,
                        $fifteen,
                        $sixteen,
                        $seventeen,
                        $eighteen,
                        $nineteen,
                        $note,
                        $monthType,
                        $yearType,
                        $projects->no
                    );
    

                    $oldCaseTrendSurveyCountReportArray = array($note, $monthType, $yearType, $projects->no);

                    $oldCaseTrendSurveyCountReportNum = 0;
                    foreach ($oldCaseTrendSurveyCountReportArray as $value) {
                        if ($value != null) {
                            $oldCaseTrendSurveyCountReportNum++;
                        }
                    }

                    $oldCaseTrendSurveyCountReportRate = round($oldCaseTrendSurveyCountReportNum / count($oldCaseTrendSurveyCountReportArray), 2) * 100;

                    $oldCaseTrendSurveyCountReportSuccess = $this->CompletionModel->create_one('old_case_trend_survey_count_report', $isExecuteSuccess, $oldCaseTrendSurveyCountReportRate);
                }

                if ($isExecuteSuccess) {
                    $beSentDataset['success'] = '新增成功';
                    if (isset($_POST['save'])) {
                        $oldCaseTrendSurveyCountReports = $this->OldCaseTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $countyType);
                        $reportProcesses = $this->ReviewProcessModel->get_by_report_no('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReports->no);
                        if ($reportProcesses) {
                            $this->ReviewProcessModel->update_one('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReports->no, $reviewStatus['review_process_pass'], 6);
                            $this->ReviewProcessModel->update_one('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], 3);
                        } else {
                            $this->ReviewProcessModel->create_one('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReports->no, $reviewStatus['review_process_pass'], 6);
                            $this->ReviewProcessModel->create_one('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], 3);
                            $this->ReviewProcessModel->create_one('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReports->no, $reviewStatus['review_process_not_pass'], 1);
                        }
                        $countyContractor = $this->UserModel->get_latest_county_contractor($countyType);
                        $this->ReviewLogModel->create_one('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReports->no, $reviewStatus['review_process_pass'], null, $current_role, $userId);
                        $this->ReviewLogModel->create_one('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], null, 3, $countyContractor->id);

                        $countyContractor = $this->UserModel->get_by_county_contractor($countyType);
                        $userName = $this->UserModel->get_name_by_id($userId)->name;

                        $recipient = $countyContractor->email;
                        $title = '【教育部青年發展署雙青計畫行政系統】輔導員繳交' . $yearType . '年' . $monthType . '月 前一年結案後動向調查追蹤表通知';
                        $content = '<p>' . $countyContractor->name . ' 君 您好:</p>'
                  . '<p>' . $userName . '繳交' . $yearType . '年' . $monthType . '月 前一年結案後動向調查追蹤表</p>'
                  . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
                  . '<p>祝 平安快樂</p><p></p>'
                  . '<p>教育部青年發展署雙青計畫行政系統</p>'
                  . '<p>' . date('Y-m-d') . '</p>'
                      . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                        //api_send_email_temp($recipient, $title, $content);

                        $reportProcessesCounselorStatus = $oldCaseTrendSurveyCountReports ? $this->ReviewProcessModel->get_by_counselor('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReports->no)->review_status : null;
                        $reportLogs = $oldCaseTrendSurveyCountReports ? $this->ReviewLogModel->get_by_report_no('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReports->no) : null;
                        $beSentDataset['reportProcessesCounselorStatus'] = $reportProcessesCounselorStatus;
                        $beSentDataset['reportLogs'] = $reportLogs;
                    }
                } else {
                    $beSentDataset['error'] = '新增失敗';
                }
            }

            $oldCaseTrendSurveyCountReports = $this->OldCaseTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $countyType);
            $beSentDataset['report'] = $oldCaseTrendSurveyCountReports;

            $this->load->view('report/old_case_trend_survey_count_report', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function old_case_trend_survey_count_report_organization_table($yearType = null, $monthType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $userId = $passport['id'];
        $accept_role = array(2, 3, 4, 5);
        if (in_array($current_role, $accept_role)) {
            $county = $passport['county'];
            $years = $this->ProjectModel->get_distinct_year_by_county($county);
            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }
            if ($monthType == null) {
                $monthType = date("m");
            }
            $months = array('03', '06', '09', '12');

            $county = $passport['county'];
            $organization = $passport['organization'];

            $projects = $this->ProjectModel->get_latest_by_county($county);
            $countyAndOrg = $this->CountyModel->get_by_county($county);
            $oldCaseTrendSurveyCountReports = $this->OldCaseTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
            $source = $this->MenuModel->get_no_resource_by_content('轉介或自行開發', 'youth')->no;

            $youthCount = $this->YouthModel->get_end_case_trend_by_county($county, $source);
            $executeModes = $this->MenuModel->get_by_form_and_column('project', 'execute_mode');
            $executeWays = $this->MenuModel->get_by_form_and_column('project', 'execute_way');
            $counties = $this->CountyModel->get_all();

            $processReviewStatuses = $this->MenuModel->get_by_form_and_column('review_process', 'review_status');
            $logReviewStatuses = $this->MenuModel->get_by_form_and_column('review_log', 'review_status');
            $reviewStatus = [];

            $reviewStatus['review_process_not_pass'] = $this->MenuModel->get_no_resource_by_content('未批准', 'review_process')->no;
            $reviewStatus['review_process_pass'] = $this->MenuModel->get_no_resource_by_content('批准', 'review_process')->no;
            $reviewStatus['review_process_wait'] = $this->MenuModel->get_no_resource_by_content('等待送出', 'review_process')->no;

            $reportProcessesCounty = $oldCaseTrendSurveyCountReports ? $this->ReviewProcessModel->get_by_county('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReports->no) : null;
            $reportProcessesCountyStatus = $reportProcessesCounty ? $reportProcessesCounty->review_status : null;
            $reportProcessesCounselor = $oldCaseTrendSurveyCountReports ? $this->ReviewProcessModel->get_by_counselor('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReports->no) : null;
            $reportProcessesCounselorStatus = $reportProcessesCounselor ? $reportProcessesCounselor->review_status : null;
            $reportLogs = $oldCaseTrendSurveyCountReports ? $this->ReviewLogModel->get_by_report_no('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReports->no) : null;

            $counselorId = "";
            if ($reportLogs) {
              foreach ($reportLogs as $value) {
                  if ($value['user_role'] == 6) {
                      $counselorId = $value['user_id'];
                  }
              }
            }

            $countyName = "";
            foreach ($counties as $value) {
                if ($value['no'] == $county) {
                    $countyName = $value['name'];
                }
            }

            $beSentDataset = array(
                'title' => '表八.前一年開案動向調查追蹤',
                'url' => '/report/old_case_trend_survey_count_report_organization_table/'. $yearType . '/' .$monthType,
                'role' => $current_role,
                'executeModes' => $executeModes,
                'executeWays' => $executeWays,
                'counties' => $counties,
                'countyType' => $county,
                'userTitle' => $userTitle,
                'projects' => $projects,
                'countyAndOrg' => $countyAndOrg,
                'yearType' => $yearType,
                'monthType' => $monthType,
                'youthCount' => $youthCount,
                'report' => $oldCaseTrendSurveyCountReports,
                'years' => $years,
                'months' => $months,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'security' => $this->security,
                'reportProcessesCountyStatus' => $reportProcessesCountyStatus,
                'reportProcessesCounselorStatus' => $reportProcessesCounselorStatus,
                'reviewStatus' => $reviewStatus,
                'reportLogs' => $reportLogs,
                'processReviewStatuses' => $processReviewStatuses,
                'value' => null,
                'valueSum' => null,
                'countyName' => $countyName
            );

            $reviewStatuses = $this->security->xss_clean($this->input->post('reviewStatus'));
            $comment = $this->security->xss_clean($this->input->post('comment'));
            $reportFile = $oldCaseTrendSurveyCountReports ? $oldCaseTrendSurveyCountReports->report_file : null;

            if (empty($reviewStatuses)) {
                return $this->load->view('report/old_case_trend_survey_count_report_organization_table', $beSentDataset);
            }

            if ($monthType % 3 == 0) {
              $reportNameArray = ['high_school_trend_survey_count_report', 'counseling_member_count_report', 'two_years_trend_survey_count_report',
                  'one_years_trend_survey_count_report', 'now_years_trend_survey_count_report',
                  'old_case_trend_survey_count_report', 'counselor_manpower_report',
                  'counseling_identity_count_report', 'counseling_meeting_count_report'];
            } else {
                $reportNameArray = ['counseling_member_count_report', 'counselor_manpower_report',
                  'counseling_identity_count_report', 'counseling_meeting_count_report'];
            }

            $reportNoArray = [];
            $reportArray = [];

            $counselingMemberCountReport = $this->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $county);
            $counselingMemberCountReportNo = $counselingMemberCountReport ? $counselingMemberCountReport->no : 0;  
            array_push($reportArray, $counselingMemberCountReport);           
            array_push($reportNoArray, $counselingMemberCountReportNo);

            if ($monthType % 3 == 0) {

              $highSchoolTrendSurveyCountReports = $this->HighSchoolTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
              $highSchoolTrendSurveyCountReportNo = $highSchoolTrendSurveyCountReports ? $highSchoolTrendSurveyCountReports->no : 0;
              array_push($reportArray, $highSchoolTrendSurveyCountReports);
              array_push($reportNoArray, $highSchoolTrendSurveyCountReportNo);

                $twoYearsTrendSurveyCountReports = $this->TwoYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $twoYearsTrendSurveyCountReportNo = $twoYearsTrendSurveyCountReports ? $twoYearsTrendSurveyCountReports->no : 0;
                array_push($reportArray, $twoYearsTrendSurveyCountReports);
                array_push($reportNoArray, $twoYearsTrendSurveyCountReportNo);
            
                $oneYearsTrendSurveyCountReports = $this->OneYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $oneYearsTrendSurveyCountReportNo = $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->no : 0;
                array_push($reportArray, $oneYearsTrendSurveyCountReports);
                array_push($reportNoArray, $oneYearsTrendSurveyCountReportNo);
            
                $nowYearsTrendSurveyCountReports = $this->NowYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $nowYearsTrendSurveyCountReportNo = $nowYearsTrendSurveyCountReports ? $nowYearsTrendSurveyCountReports->no : 0;
                array_push($reportArray, $nowYearsTrendSurveyCountReports);
                array_push($reportNoArray, $nowYearsTrendSurveyCountReportNo);
            
                $oldCaseTrendSurveyCountReports = $this->OldCaseTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $oldCaseTrendSurveyCountReportNo = $oldCaseTrendSurveyCountReports ? $oldCaseTrendSurveyCountReports->no : 0;
                array_push($reportArray, $oldCaseTrendSurveyCountReports);
                array_push($reportNoArray, $oldCaseTrendSurveyCountReportNo);
            }
            
            $counselorManpowerReports = $this->CounselorManpowerReportModel->get_by_no($yearType, $monthType, $county);
            $counselorManpowerReportNo = $counselorManpowerReports ? $counselorManpowerReports->no : 0;
            array_push($reportArray, $counselorManpowerReports);      
            array_push($reportNoArray, $counselorManpowerReportNo);
            
            $get_inserted_identity_count_data = $this->CounselingIdentityCountReportModel->get_inserted_identity_count_data($yearType, $monthType, $projects->no);
            $counselingIdentityCountReportNo = $get_inserted_identity_count_data ? $get_inserted_identity_count_data->no : 0;
            array_push($reportArray, $get_inserted_identity_count_data);      
            array_push($reportNoArray, $counselingIdentityCountReportNo);
            
            $get_inserted_meeting_count_data = $this->CounselingMeetingCountReportModel->get_inserted_meeting_count_data($yearType, $monthType, $projects->no);
            $counselingMeetingCountReportNo = $get_inserted_meeting_count_data ? $get_inserted_meeting_count_data->no : 0;
            array_push($reportArray, $get_inserted_meeting_count_data);      
            array_push($reportNoArray, $counselingMeetingCountReportNo);

            // file format define
            // 檔案內容大小限制5000KB,並支援JPG,PNG,PDF
            $config['upload_path'] = './files/';
            $config['allowed_types'] = 'jpg|png|pdf';
            $config['max_size'] = 5000;
            $config['max_width'] = 5000;
            $config['max_height'] = 5000;
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);
            // upload family diagram
            if ($this->upload->do_upload('reportFile')) {
                $fileMetaData = $this->upload->data();
                $reportFile = $this->FileModel->create_one($oldCaseTrendSurveyCountReports->no, $fileMetaData['file_name'], $fileMetaData['orig_name']);
            }

            $isUpdateReportFile = $this->OldCaseTrendSurveyCountReportModel->update_file_by_no($oldCaseTrendSurveyCountReports->no, $reportFile);
            if($isUpdateReportFile){

              if ($reviewStatuses == $reviewStatus['review_process_not_pass']) {
                  $this->ReviewProcessModel->update_one('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], 6);
                  $this->ReviewProcessModel->update_one('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReports->no, $reviewStatus['review_process_not_pass'], 3);

                  $this->ReviewLogModel->create_one('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReports->no, $reviewStatus['review_process_not_pass'], $comment, $current_role, $userId);
                  $this->ReviewLogModel->create_one('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], null, 6, $counselorId);

                  $counselorInfo = $this->UserModel->get_name_by_id($counselorId);
                  $userName = $this->UserModel->get_name_by_id($userId)->name;

                  $recipient = $counselorInfo->email;
                  $title = '【教育部青年發展署雙青計畫行政系統】縣市承辦人退回' . $yearType . '年' . $monthType .'月 前一年結案後動向調查追蹤表通知';
                  $content = '<p>' . $counselorInfo->name . ' 君 您好:</p>'
                  . '<p>' . $userName . '退回' . $yearType . '年' . $monthType . '月 前一年結案後動向調查追蹤表</p>'
                  . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
                  . '<p>祝 平安快樂</p><p></p>'
                  . '<p>教育部青年發展署雙青計畫行政系統</p>'
                  . '<p>' . date('Y-m-d') . '</p>'
                      . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                  //api_send_email_temp($recipient, $title, $content);
              
              } elseif ($reviewStatuses == $reviewStatus['review_process_pass']) {
                  $ydaContractor = 'yda';
                  $this->ReviewProcessModel->update_one('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], 1);
                  $this->ReviewProcessModel->update_one('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReports->no, $reviewStatus['review_process_pass'], 3);

                  $this->ReviewLogModel->create_one('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReports->no, $reviewStatus['review_process_pass'], $comment, $current_role, $userId);
                  $this->ReviewLogModel->create_one('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReports->no, $reviewStatus['review_process_wait'], null, 1, $ydaContractor);
              
                  $check = 1;
                  $count = 0;
                  $reportProcessesCountyStatusArray = $reportProcessesYdaStatusArray = $reportLogsArray = [];
                  foreach($reportNameArray as $reportName) {
                    $reportProcessesCounty = $reportArray[$count] ? $this->ReviewProcessModel->get_by_county($reportName, $reportNoArray[$count]) : null;
                    $reportProcessesCountyStatus = $reportProcessesCounty ? $reportProcessesCounty->review_status : null;
    
                    if($reportProcessesCountyStatus != $reviewStatus['review_process_pass']) {
                      $check = 0;
                    }            
                    array_push($reportProcessesCountyStatusArray, $reportProcessesCountyStatus);
                    $count++;
                  
                  }
    
                  if($check) { // 縣市報表全部已繳交
                    $this->TimingReportModel->create_one($county, null, $monthType, $yearType);
                  }
                
                  $ydaInfo = $this->UserModel->get_by_yda_row();
                  $userName = $this->UserModel->get_name_by_id($userId)->name;
    
                  $recipient = $ydaInfo->email;
                  $title = '【教育部青年發展署雙青計畫行政系統】' . $countyName . '承辦人繳交' . $yearType . '年' . $monthType .'月 前一年結案後動向調查追蹤表通知';
                  $content = '<p>' . $ydaInfo->name . ' 君 您好:</p>'
                  . '<p>' . $countyName . '承辦人繳交' . $yearType . '年' . $monthType . '月 前一年結案後動向調查追蹤表</p>'
                  . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
                  . '<p>祝 平安快樂</p><p></p>'
                  . '<p>教育部青年發展署雙青計畫行政系統</p>'
                  . '<p>' . date('Y-m-d') . '</p>'
                      . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';
    
                  //api_send_email_temp($recipient, $title, $content);
              }

              $reportProcessesCountyStatus = $oldCaseTrendSurveyCountReports ? $this->ReviewProcessModel->get_by_county('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReports->no)->review_status : null;
              $reportProcessesCounselorStatus = $oldCaseTrendSurveyCountReports ? $this->ReviewProcessModel->get_by_counselor('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReports->no)->review_status : null;
              $reportLogs = $oldCaseTrendSurveyCountReports ? $this->ReviewLogModel->get_by_report_no('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReports->no) : null;
              $beSentDataset['reportProcessesCountyStatus'] = $reportProcessesCountyStatus;
              $beSentDataset['reportProcessesCounselorStatus'] = $reportProcessesCounselorStatus;
              $beSentDataset['reportLogs'] = $reportLogs;
            } else {
              $beSentDataset['error'] = '新增失敗';
            }

            $this->load->view('report/old_case_trend_survey_count_report_organization_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function old_case_trend_survey_count_report_yda_table($yearType = null, $monthType = null, $countyType = 'all')
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $userId = $passport['id'];
        $accept_role = array(1, 8, 9);
        if (in_array($current_role, $accept_role)) {
            $county = $countyType ? $countyType : '1';
            $years = $this->ProjectModel->get_distinct_year_by_county('1');
            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }
            if ($monthType == null) {
                $monthType = date("m");
            }
            $months = array('03', '06', '09', '12');
            $countiesName = $this->CountyModel->get_all();

            $source = $this->MenuModel->get_no_resource_by_content('轉介或自行開發', 'youth')->no;
            $oldCaseTrendSurveyCountReports = $this->OldCaseTrendSurveyCountReportModel->get_by_all($yearType, $monthType, $countyType, $source);

            $executeModes = $this->MenuModel->get_by_form_and_column('project', 'execute_mode');
            $executeWays = $this->MenuModel->get_by_form_and_column('project', 'execute_way');
            $counties = $this->CountyModel->get_all();

            $sumDetail = get_seasonal_review_month_report_sum($oldCaseTrendSurveyCountReports);

            $oldCaseTrendSurveyCountReportArray = [];
            $reportProcessesCountyStatusArray = [];
            $reportProcessesYdaStatusArray = [];
            $reportLogsArray = [];
            $countyIdArray = [];
            $isOverTimeArray = [];
            $projectArray = [];

            $processReviewStatuses = $this->MenuModel->get_by_form_and_column('review_process', 'review_status');
            $logReviewStatuses = $this->MenuModel->get_by_form_and_column('review_log', 'review_status');
            $reviewStatus = [];

            $reviewStatus['review_process_not_pass'] = $this->MenuModel->get_no_resource_by_content('未批准', 'review_process')->no;
            $reviewStatus['review_process_pass'] = $this->MenuModel->get_no_resource_by_content('批准', 'review_process')->no;
            $reviewStatus['review_process_wait'] = $this->MenuModel->get_no_resource_by_content('等待送出', 'review_process')->no;

            if ($countyType == 'all') {
                $counties = $this->CountyModel->get_all();
            } else {
                $counties = $this->CountyModel->get_one($countyType);
            }

            foreach ($counties as $county) {
                $projects = $this->ProjectModel->get_latest_by_county($county['no']);
                array_push($projectArray, $projects);

                $oldCaseTrendSurveyCountReport = $this->OldCaseTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county['no']);
                array_push($oldCaseTrendSurveyCountReportArray, $oldCaseTrendSurveyCountReport);

                $reportProcessesCounty = $oldCaseTrendSurveyCountReport ? $this->ReviewProcessModel->get_by_county('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReport->no) : null;
                $reportProcessesCountyStatus = $reportProcessesCounty ? $reportProcessesCounty->review_status : null;

                array_push($reportProcessesCountyStatusArray, $reportProcessesCountyStatus);

                $reportProcessesYda = $oldCaseTrendSurveyCountReport ? $this->ReviewProcessModel->get_by_yda('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReport->no) : null;
                $reportProcessesYdaStatus = $reportProcessesYda ? $reportProcessesYda->review_status : null;
                array_push($reportProcessesYdaStatusArray, $reportProcessesYdaStatus);

                $reportLogs = $oldCaseTrendSurveyCountReport ? $this->ReviewLogModel->get_by_report_no('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReport->no) : null;
                array_push($reportLogsArray, $reportLogs);

                $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
                $addMonth = ($addMonth > 9) ? $addMonth : '0'.$addMonth;
                $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;
                $overTimeDate = ($addYear + 1911) . '-' . $addMonth . '-05 00:00:00'; 
                $countyId = "";
                $isOverTime = 0;
                if ($reportLogs) {
                    foreach ($reportLogs as $value) {
                        if ($value['user_role'] == 3) {
                            $countyId = $value['user_id'];
                            $isOverTime = ($value['time'] > $overTimeDate) ? ($value['time'] > $overTimeDate) : 0;      
                        }
                    }
                    
                }
                array_push($countyIdArray, $countyId);
                array_push($isOverTimeArray, $isOverTime);
            }


            $beSentDataset = array(
                'title' => '表八.前一年結案後動向調查追蹤',
                'url' => '/report/old_case_trend_survey_count_report_yda_table/' . $yearType . '/' . $monthType . '/' .$countyType,
                'role' => $current_role,
                'executeModes' => $executeModes,
                'executeWays' => $executeWays,
                'counties' => $counties,
                'countyType' => $countyType,
                'userTitle' => $userTitle,
                'yearType' => $yearType,
                'monthType' => $monthType,
                'oldCaseTrendSurveyCountReports' => $oldCaseTrendSurveyCountReports,
                'years' => $years,
                'months' => $months,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'security' => $this->security,
                'valueSum' => $sumDetail,
                'reportArray' => $oldCaseTrendSurveyCountReportArray,
                'reportProcessesCountyStatusArray' => $reportProcessesCountyStatusArray,
                'reportProcessesYdaStatusArray' => $reportProcessesYdaStatusArray,
                'reportLogsArray' => $reportLogsArray,
                'countyIdArray' => $countyIdArray,
                'reviewStatus' => $reviewStatus,
                'processReviewStatuses' => $processReviewStatuses,
                'isOverTimeArray' => $isOverTimeArray,
                'countiesName' => $countiesName,
                'reviewPage' => 'old_case_trend_survey_count_report_yda_table'
            );

            $reviewStatuses = $this->security->xss_clean($this->input->post('reviewStatus'));
            $comment = $this->security->xss_clean($this->input->post('comment'));

            if (empty($reviewStatuses)) {
                return $this->load->view('report/old_case_trend_survey_count_report_yda_table', $beSentDataset);
            }

            $reportProcessesCountyStatusArray = [];
            $reportProcessesYdaStatusArray = [];
            $reportLogsArray = [];

            if ($monthType % 3 == 0) {
              $reportNameArray = ['high_school_trend_survey_count_report', 'counseling_member_count_report', 'two_years_trend_survey_count_report',
              'one_years_trend_survey_count_report', 'now_years_trend_survey_count_report',
              'old_case_trend_survey_count_report', 'counselor_manpower_report',
              'counseling_identity_count_report', 'counseling_meeting_count_report'];
            } else {
              $reportNameArray = ['counseling_member_count_report', 'counselor_manpower_report',
                'counseling_identity_count_report', 'counseling_meeting_count_report'];
            }         

            for ($i = 0; $i < count($counties); $i++) {

                $reportNoArray = [];
                $reportArray = [];

                $counselingMemberCountReport = $this->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                $counselingMemberCountReportNo = $counselingMemberCountReport ? $counselingMemberCountReport->no : 0;  
                array_push($reportArray, $counselingMemberCountReport);           
                array_push($reportNoArray, $counselingMemberCountReportNo);

                if ($monthType % 3 == 0) {
                  $highSchoolTrendSurveyCountReports = $this->HighSchoolTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                  $highSchoolTrendSurveyCountReportNo = $highSchoolTrendSurveyCountReports ? $highSchoolTrendSurveyCountReports->no : 0;
                  array_push($reportArray, $highSchoolTrendSurveyCountReports);
                  array_push($reportNoArray, $highSchoolTrendSurveyCountReportNo);

                    $twoYearsTrendSurveyCountReports = $this->TwoYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $twoYearsTrendSurveyCountReportNo = $twoYearsTrendSurveyCountReports ? $twoYearsTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $twoYearsTrendSurveyCountReports);
                    array_push($reportNoArray, $twoYearsTrendSurveyCountReportNo);
                
                    $oneYearsTrendSurveyCountReports = $this->OneYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $oneYearsTrendSurveyCountReportNo = $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $oneYearsTrendSurveyCountReports);
                    array_push($reportNoArray, $oneYearsTrendSurveyCountReportNo);
                
                    $nowYearsTrendSurveyCountReports = $this->NowYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $nowYearsTrendSurveyCountReportNo = $nowYearsTrendSurveyCountReports ? $nowYearsTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $nowYearsTrendSurveyCountReports);
                    array_push($reportNoArray, $nowYearsTrendSurveyCountReportNo);
                
                    $oldCaseTrendSurveyCountReports = $this->OldCaseTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $oldCaseTrendSurveyCountReportNo = $oldCaseTrendSurveyCountReports ? $oldCaseTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $oldCaseTrendSurveyCountReports);
                    array_push($reportNoArray, $oldCaseTrendSurveyCountReportNo);
                }
                
                $counselorManpowerReports = $this->CounselorManpowerReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                $counselorManpowerReportNo = $counselorManpowerReports ? $counselorManpowerReports->no : 0;
                array_push($reportArray, $counselorManpowerReports);      
                array_push($reportNoArray, $counselorManpowerReportNo);
                
                $get_inserted_identity_count_data = $this->CounselingIdentityCountReportModel->get_inserted_identity_count_data($yearType, $monthType, $projectArray[$i]->no);
                $counselingIdentityCountReportNo = $get_inserted_identity_count_data ? $get_inserted_identity_count_data->no : 0;
                array_push($reportArray, $get_inserted_identity_count_data);      
                array_push($reportNoArray, $counselingIdentityCountReportNo);
                
                $get_inserted_meeting_count_data = $this->CounselingMeetingCountReportModel->get_inserted_meeting_count_data($yearType, $monthType, $projectArray[$i]->no);
                $counselingMeetingCountReportNo = $get_inserted_meeting_count_data ? $get_inserted_meeting_count_data->no : 0;
                array_push($reportArray, $get_inserted_meeting_count_data);      
                array_push($reportNoArray, $counselingMeetingCountReportNo);

                if ($reviewStatuses == $reviewStatus['review_process_not_pass']) {

                    $this->ReviewProcessModel->update_one('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReportArray[$i]->no, $reviewStatus['review_process_wait'], 3);
                    $this->ReviewProcessModel->update_one('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReportArray[$i]->no, $reviewStatus['review_process_not_pass'], 1);

                    $this->ReviewLogModel->create_one('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReportArray[$i]->no, $reviewStatus['review_process_not_pass'], $comment, $current_role, $userId);
                    $this->ReviewLogModel->create_one('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReportArray[$i]->no, $reviewStatus['review_process_wait'], null, 3, $countyIdArray[$i]);

                    $countyContractor = $this->UserModel->get_name_by_id($countyIdArray[$i]);
                    $userName = $this->UserModel->get_name_by_id($userId)->name;
    
                    $recipient = $countyContractor->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】青年署退回' . $yearType . '年' . $monthType .'月 前一年結案後動向調查追蹤表通知';
                    $content = '<p>' . $countyContractor->name . ' 君 您好:</p>'
                    . '<p>' . $userName . '退回' . $yearType . '年' . $monthType . '月前一年結案後動向調查追蹤表</p>'
                    . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';
    
                    //api_send_email_temp($recipient, $title, $content);
                
              } elseif ($reviewStatuses == $reviewStatus['review_process_pass']) {

                    $this->ReviewProcessModel->update_one('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReportArray[$i]->no, $reviewStatus['review_process_pass'], 1);

                    $this->ReviewLogModel->create_one('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReportArray[$i]->no, $reviewStatus['review_process_pass'], $comment, $current_role, $userId);

                    $check = 1;
                    $count = 0;
                    $reportProcessesCountyStatusArray = $reportProcessesYdaStatusArray = $reportLogsArray = [];
                    foreach($reportNameArray as $reportName) {
 
                      $reportProcessesYda = $reportArray[$count] ? $this->ReviewProcessModel->get_by_yda($reportName, $reportNoArray[$count]) : null;
                      $reportProcessesYdaStatus = $reportProcessesYda ? $reportProcessesYda->review_status : null;
      
                      array_push($reportProcessesYdaStatusArray, $reportProcessesYdaStatus);

                      if($reportProcessesCountyStatus != $reviewStatus['review_process_pass']) {
                        $check = 0;
                      }

                      $count ++;
                    }
                    $userInfo = $this->UserModel->get_name_by_id($userId);
                    if($check) { // 縣市報表全部已繳交
                      $this->TimingReportModel->create_one($counties[$i]['no'], $userInfo->yda, $monthType, $yearType);
                    }
                }
                $reportProcessesCountyStatus = $oldCaseTrendSurveyCountReportArray[$i] ? $this->ReviewProcessModel->get_by_county('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReportArray[$i]->no)->review_status : null;

                array_push($reportProcessesCountyStatusArray, $reportProcessesCountyStatus);

                $reportProcessesYdaStatus = $oldCaseTrendSurveyCountReportArray[$i] ? $this->ReviewProcessModel->get_by_yda('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReportArray[$i]->no)->review_status : null;
                array_push($reportProcessesYdaStatusArray, $reportProcessesYdaStatus);

                $reportLogs = $oldCaseTrendSurveyCountReportArray[$i] ? $this->ReviewLogModel->get_by_report_no('old_case_trend_survey_count_report', $oldCaseTrendSurveyCountReportArray[$i]->no) : null;
                array_push($reportLogsArray, $reportLogs);

                $countyId = "";
                if ($reportLogs) {
                    foreach ($reportLogs as $value) {
                        if ($value['user_role'] == 3) {
                            $countyId = $value['user_id'];
                        }
                    }
                }
                array_push($countyIdArray, $countyId);
            }

            $beSentDataset['reportProcessesCountyStatusArray'] = $reportProcessesCountyStatusArray;
            $beSentDataset['reportProcessesYdaStatusArray'] = $reportProcessesYdaStatusArray;
            $beSentDataset['reportLogsArray'] = $reportLogsArray;

            $this->load->view('report/old_case_trend_survey_count_report_yda_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function counselor_manpower_report($yearType = null, $monthType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $userId = $passport['id'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $county = $passport['county'];
            $organization = $passport['organization'];

            $years = $this->ProjectModel->get_distinct_year_by_county($county);
            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }
            if ($monthType == null) {
                $monthType = date("m");
            }
            $months = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');

            $projects = $this->ProjectModel->get_latest_by_county($county);
            $countyAndOrg = $this->CountyModel->get_by_county($county);
            $counselorManpowerReports = $this->CounselorManpowerReportModel->get_by_no($yearType, $monthType, $county);
            $counties = $this->CountyModel->get_all();
            $counselors = $this->CounselorModel->get_by_organization($yearType, $monthType, $organization);

            $counselorData = [];
            $counselorData['educationCounselor'] = $this->MenuModel->get_no_resource_by_content('教育局(處)', 'counselor')->no;
            $counselorData['counselingCenterCounselor'] = $this->MenuModel->get_no_resource_by_content('輔諮中心', 'counselor')->no;
            $counselorData['schoolCounselor'] = $this->MenuModel->get_no_resource_by_content('學校', 'counselor')->no;
            $counselorData['outsourcingCounselor'] = $this->MenuModel->get_no_resource_by_content('委外單位', 'counselor')->no;
            $counselorData['bachelorDegree'] = $this->MenuModel->get_no_resource_by_content('學士', 'counselor')->no;
            $counselorData['masterDegree'] = $this->MenuModel->get_no_resource_by_content('碩士', 'counselor')->no;
            $counselorData['qualificationOne'] = $this->MenuModel->get_no_resource_by_content('符合國內公立或教育部立案之私立大專校院或經教育部承認之國外大專校院，教育學、社會(含社工、社福)學、心理學、諮商輔導、勞工關係、人力資源等相關科系畢業者', 'counselor')->no;
            $counselorData['qualificationTwo'] = $this->MenuModel->get_no_resource_by_content('國內公立或教育部立案之私立大專校院或經教育部承認之國外大專校院相當科、系、組、所畢業，領有畢業證書，具備考選部公告社會工作師或心理師應考資格者', 'counselor')->no;
            $counselorData['qualificationThree'] = $this->MenuModel->get_no_resource_by_content('具社會工作師證照', 'counselor')->no;
            $counselorData['qualificationFour'] = $this->MenuModel->get_no_resource_by_content('具心理師證照', 'counselor')->no;
            $counselorData['qualificationFive'] = $this->MenuModel->get_no_resource_by_content('具就業服務乙級技術士證照', 'counselor')->no;
            $counselorData['qualificationSix'] = $this->MenuModel->get_no_resource_by_content('具政府機關核發之就業服務專業人員證書', 'counselor')->no;

            $counselorCount = [];
            $counselorCount['educationCounselor'] = 0;
            $counselorCount['counselingCenterCounselor'] = 0;
            $counselorCount['schoolCounselor'] = 0;
            $counselorCount['outsourcingCounselor'] = 0;
            $counselorCount['bachelorDegree'] = 0;
            $counselorCount['masterDegree'] = 0;
            $counselorCount['qualificationOne'] = 0;
            $counselorCount['qualificationTwo'] = 0;
            $counselorCount['qualificationThree'] = 0;
            $counselorCount['qualificationFour'] = 0;
            $counselorCount['qualificationFive'] = 0;
            $counselorCount['qualificationSix'] = 0;

            $counselorNote = "";

            # $issue = explode(",", $issue);

            foreach ($counselors as $value) {
     
                $seniority = ceil((strtotime(date("Y-m-d")) - strtotime($value['duty_date']) ) /3600/24/30 );

                $tempYear = substr($value['duty_date'], 0, 4) - 1911;
                $tempMonth = substr($value['duty_date'], 5, 2);
                $tempDay = substr($value['duty_date'], 8, 2);
                $dutyDate = $tempYear . $tempMonth . $tempDay;

                $counselorNote = $counselorNote . $value['userName'] . '：' . $dutyDate . "\n";
                
                if ($value['highest_education'] == $counselorData['masterDegree']):
                    $counselorCount['masterDegree']++;
                elseif ($value['highest_education'] == $counselorData['bachelorDegree']):
                    $counselorCount['bachelorDegree']++;
                endif;

                if ($value['affiliated_department'] == $counselorData['educationCounselor']):
                    $counselorCount['educationCounselor']++;
                elseif ($value['affiliated_department'] == $counselorData['counselingCenterCounselor']):
                    $counselorCount['counselingCenterCounselor']++;
                elseif ($value['affiliated_department'] == $counselorData['schoolCounselor']):
                    $counselorCount['schoolCounselor']++;
                elseif ($value['affiliated_department'] == $counselorData['outsourcingCounselor']):
                    $counselorCount['outsourcingCounselor']++;
                endif;

                $qualifications = explode(",", $value['qualification']);
                if (in_array($counselorData['qualificationOne'], $qualifications) == 1):
                    $counselorCount['qualificationOne']++;
                elseif (in_array($counselorData['qualificationTwo'], $qualifications) == 1):
                    $counselorCount['qualificationTwo']++;
                elseif (in_array($counselorData['qualificationThree'], $qualifications) == 1):
                    $counselorCount['qualificationThree']++;
                elseif (in_array($counselorData['qualificationFour'], $qualifications) == 1):
                    $counselorCount['qualificationFour']++;           
                elseif (in_array($counselorData['qualificationFive'], $qualifications) == 1):
                    $counselorCount['qualificationFive']++;
                elseif (in_array($counselorData['qualificationSix'], $qualifications) == 1):
                    $counselorCount['qualificationSix']++;
                endif;
            }

            $processReviewStatuses = $this->MenuModel->get_by_form_and_column('review_process', 'review_status');
            $logReviewStatuses = $this->MenuModel->get_by_form_and_column('review_log', 'review_status');
            $reviewStatus = [];
       
            $reviewStatus['review_process_not_pass'] = $this->MenuModel->get_no_resource_by_content('未批准', 'review_process')->no;    
            $reviewStatus['review_process_pass'] = $this->MenuModel->get_no_resource_by_content('批准', 'review_process')->no;
            $reviewStatus['review_process_wait'] = $this->MenuModel->get_no_resource_by_content('等待送出', 'review_process')->no;

            $reportProcessesCounselor = $counselorManpowerReports ? $this->ReviewProcessModel->get_by_counselor('counselor_manpower_report', $counselorManpowerReports->no) : null;
            $reportProcessesCounselorStatus = $reportProcessesCounselor ? $reportProcessesCounselor->review_status : null;
            $reportLogs = $counselorManpowerReports ? $this->ReviewLogModel->get_by_report_no('counselor_manpower_report', $counselorManpowerReports->no) : null;

            $beSentDataset = array(
                'title' => '表四.輔導人力概況表',
                'url' => '/report/counselor_manpower_report/' . $yearType . '/' . $monthType,
                'role' => $current_role,
                'counties' => $counties,
                'county' => $county,
                'userTitle' => $userTitle,
                'projects' => $projects,
                'countyAndOrg' => $countyAndOrg,
                'yearType' => $yearType,
                'monthType' => $monthType,
                'counselors' => $counselors,
                'counselorManpowerReports' => $counselorManpowerReports,
                'counselorCount' => $counselorCount,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'security' => $this->security,
                'reportProcessesCounselorStatus' => $reportProcessesCounselorStatus,
                'reviewStatus' => $reviewStatus,
                'reportLogs' => $reportLogs,
                'processReviewStatuses' => $processReviewStatuses,
                'counselorNote' => $counselorNote
            );

            $projectCounselor = $projects->counselor_count;
            $reallyCounselor = count($counselors);
            $educationCounselor = $counselorCount['educationCounselor'];
            $counselingCenterCounselor = $counselorCount['counselingCenterCounselor'];
            $schoolCounselor = $counselorCount['schoolCounselor'];
            $outsourcingCounselor = $counselorCount['outsourcingCounselor'];
            $bachelorDegree = $counselorCount['bachelorDegree'];
            $masterDegree = $counselorCount['masterDegree'];
            $qualificationOne = $counselorCount['qualificationOne'];
            $qualificationTwo = $counselorCount['qualificationTwo'];
            $qualificationThree = $counselorCount['qualificationThree'];
            $qualificationFour = $counselorCount['qualificationFour'];
            $qualificationFive = $counselorCount['qualificationFive'];
            $qualificationSix = $counselorCount['qualificationSix'];
            $note = $this->security->xss_clean($this->input->post('note'));

            if (empty($note)) {
                return $this->load->view('report/counselor_manpower_report', $beSentDataset);
            }

            if ($counselorManpowerReports) {
                print_r("fsdfdsfsd");
                $isExecuteSuccess = $this->CounselorManpowerReportModel->update_one($projectCounselor, $reallyCounselor, $educationCounselor, $counselingCenterCounselor, $schoolCounselor, $outsourcingCounselor,
                    $bachelorDegree, $masterDegree, $qualificationOne, $qualificationTwo, $qualificationThree, $qualificationFour,
                    $qualificationFive, $qualificationSix, $note, $monthType, $yearType, $projects->no);

                $counselorManpowerReportArray = array($note, $monthType, $yearType, $projects->no);

                $counselorManpowerReportNum = 0;
                foreach ($counselorManpowerReportArray as $value) {

                    if ($value != null) {
                        $counselorManpowerReportNum++;
                    }
                }

                $counselorManpowerReportRate = round($counselorManpowerReportNum / count($counselorManpowerReportArray), 2) * 100;

                $counselorManpowerReportSuccess = $this->CompletionModel->update_one('counselor_manpower_report', $counselorManpowerReports->no, $counselorManpowerReportRate);
            } else {

                $isExecuteSuccess = $this->CounselorManpowerReportModel->create_one($projectCounselor, $reallyCounselor, $educationCounselor, $counselingCenterCounselor, $schoolCounselor, $outsourcingCounselor,
                    $bachelorDegree, $masterDegree, $qualificationOne, $qualificationTwo, $qualificationThree, $qualificationFour,
                    $qualificationFive, $qualificationSix, $note, $monthType, $yearType, $projects->no);

                $counselorManpowerReportArray = array($note, $monthType, $yearType, $projects->no);

                $counselorManpowerReportNum = 0;
                foreach ($counselorManpowerReportArray as $value) {

                    if ($value != null) {
                        $counselorManpowerReportNum++;
                    }
                }

                $counselorManpowerReportRate = round($counselorManpowerReportNum / count($counselorManpowerReportArray), 2) * 100;

                $counselorManpowerReportSuccess = $this->CompletionModel->create_one('counselor_manpower_report', $isExecuteSuccess, $counselorManpowerReportRate);
            }

            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
                

                if (isset($_POST['save'])) {
                  $counselorManpowerReports = $this->CounselorManpowerReportModel->get_by_no($yearType, $monthType, $county);
                  $reportProcesses = $this->ReviewProcessModel->get_by_report_no('counselor_manpower_report', $counselorManpowerReports->no);
                  if ($reportProcesses) {
                      $this->ReviewProcessModel->update_one('counselor_manpower_report', $counselorManpowerReports->no, $reviewStatus['review_process_pass'], 6);
                      $this->ReviewProcessModel->update_one('counselor_manpower_report', $counselorManpowerReports->no, $reviewStatus['review_process_wait'], 3);
                  } else {
                      $this->ReviewProcessModel->create_one('counselor_manpower_report', $counselorManpowerReports->no, $reviewStatus['review_process_pass'], 6);
                      $this->ReviewProcessModel->create_one('counselor_manpower_report', $counselorManpowerReports->no, $reviewStatus['review_process_wait'], 3);
                      $this->ReviewProcessModel->create_one('counselor_manpower_report', $counselorManpowerReports->no, $reviewStatus['review_process_not_pass'], 1);
                  }
                  $countyContractor = $this->UserModel->get_latest_county_contractor($county);
                  $this->ReviewLogModel->create_one('counselor_manpower_report', $counselorManpowerReports->no, $reviewStatus['review_process_pass'], null, $current_role, $userId);
                  $this->ReviewLogModel->create_one('counselor_manpower_report', $counselorManpowerReports->no, $reviewStatus['review_process_wait'], null, 3, $countyContractor->id);

                  $countyContractor = $this->UserModel->get_by_county_contractor($county);
                  $userName = $this->UserModel->get_name_by_id($userId)->name;

                  $recipient = $countyContractor->email;
                  $title = '【教育部青年發展署雙青計畫行政系統】輔導員繳交' . $yearType . '年' . $monthType . '月 輔導人力概況表通知';
                  $content = '<p>' . $countyContractor->name . ' 君 您好:</p>'
                  . '<p>' . $userName . '繳交' . $yearType . '年' . $monthType . '月 輔導人力概況表</p>'
                  . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
                  . '<p>祝 平安快樂</p><p></p>'
                  . '<p>教育部青年發展署雙青計畫行政系統</p>'
                  . '<p>' . date('Y-m-d') . '</p>'
                      . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                  //api_send_email_temp($recipient, $title, $content);

                  $reportProcessesCounselorStatus = $counselorManpowerReports ? $this->ReviewProcessModel->get_by_counselor('counselor_manpower_report', $counselorManpowerReports->no)->review_status : null;
                  $reportLogs = $counselorManpowerReports ? $this->ReviewLogModel->get_by_report_no('counselor_manpower_report', $counselorManpowerReports->no) : null;
                  $beSentDataset['reportProcessesCounselorStatus'] = $reportProcessesCounselorStatus;
                  $beSentDataset['reportLogs'] = $reportLogs;
              }
            } else {
                $beSentDataset['error'] = '新增失敗';
            }

            $counselorManpowerReports = $this->CounselorManpowerReportModel->get_by_no($yearType, $monthType, $county);
            $beSentDataset['counselorManpowerReports'] = $counselorManpowerReports;

            $this->load->view('report/counselor_manpower_report', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function counselor_manpower_report_organization_table($yearType = null, $monthType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userId = $passport['id'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(2, 3, 4, 5);
        if (in_array($current_role, $accept_role)) {
            $county = $passport['county'];
            $years = $this->ProjectModel->get_distinct_year_by_county($county);
            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }
            if ($monthType == null) {
                $monthType = date("m");
            }
            $months = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');

            $county = $passport['county'];
            $organization = $passport['organization'];

            $projects = $this->ProjectModel->get_latest_by_county($county);
            $countyAndOrg = $this->CountyModel->get_by_county($county);
            $counselorManpowerReports = $this->CounselorManpowerReportModel->get_by_no($yearType, $monthType, $county);

            $counties = $this->CountyModel->get_all();

            $processReviewStatuses = $this->MenuModel->get_by_form_and_column('review_process', 'review_status');
            $logReviewStatuses = $this->MenuModel->get_by_form_and_column('review_log', 'review_status');
            $reviewStatus = [];
        
            $reviewStatus['review_process_not_pass'] = $this->MenuModel->get_no_resource_by_content('未批准', 'review_process')->no; 
            $reviewStatus['review_process_pass'] = $this->MenuModel->get_no_resource_by_content('批准', 'review_process')->no;
            $reviewStatus['review_process_wait'] = $this->MenuModel->get_no_resource_by_content('等待送出', 'review_process')->no;
       
            $reportProcessesCounty = $counselorManpowerReports ? $this->ReviewProcessModel->get_by_county('counselor_manpower_report', $counselorManpowerReports->no) : null;
            $reportProcessesCountyStatus = $reportProcessesCounty ? $reportProcessesCounty->review_status : null;
            $reportProcessesCounselor = $counselorManpowerReports ? $this->ReviewProcessModel->get_by_counselor('counselor_manpower_report', $counselorManpowerReports->no) : null;
            $reportProcessesCounselorStatus = $reportProcessesCounselor ? $reportProcessesCounselor->review_status : null;
            $reportLogs = $counselorManpowerReports ? $this->ReviewLogModel->get_by_report_no('counselor_manpower_report', $counselorManpowerReports->no) : null;
            
            $counselorId = "";
            if ($reportLogs) {
                foreach ($reportLogs as $value) {
                    if ($value['user_role'] == 6) {
                        $counselorId = $value['user_id'];
                    }
                }
            }

            $countyName = "";
            foreach ($counties as $value) {
                if ($value['no'] == $county) {
                    $countyName = $value['name'];
                }
            }

            $beSentDataset = array(
                'title' => '表四.輔導人力概況表',
                'url' => '/report/counselor_manpower_report_organization_table/' . $yearType . '/' . $monthType,
                'role' => $current_role,
                'counties' => $counties,
                'county' => $county,
                'userTitle' => $userTitle,
                'projects' => $projects,
                'countyAndOrg' => $countyAndOrg,
                'yearType' => $yearType,
                'monthType' => $monthType,
                'counselorManpowerReports' => $counselorManpowerReports,
                'years' => $years,
                'months' => $months,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'security' => $this->security,
                'reportProcessesCountyStatus' => $reportProcessesCountyStatus,
                'reportProcessesCounselorStatus' => $reportProcessesCounselorStatus,
                'reviewStatus' => $reviewStatus,
                'reportLogs' => $reportLogs,
                'processReviewStatuses' => $processReviewStatuses
            );

            $reviewStatuses = $this->security->xss_clean($this->input->post('reviewStatus'));
            $comment = $this->security->xss_clean($this->input->post('comment'));
            $reportFile = $counselorManpowerReports ? $counselorManpowerReports->report_file : null;

            if (isset($_POST['resubmit'])) {
              $config['upload_path'] = './files/';
              $config['allowed_types'] = 'jpg|png|pdf';
              $config['max_size'] = 5000;
              $config['max_width'] = 5000;
              $config['max_height'] = 5000;
              $config['encrypt_name'] = true;
              $this->load->library('upload', $config);
              // upload family diagram
              if ($this->upload->do_upload('reportFile')) {
                $fileMetaData = $this->upload->data();
                $reportFile = $this->FileModel->create_one($counselorManpowerReports->no, $fileMetaData['file_name'], $fileMetaData['orig_name']);
            }

            $isUpdateReportFile = $this->CounselorManpowerReportModel->update_file_by_no($counselorManpowerReports->no, $reportFile);
            if ($isUpdateReportFile) {
                $counselorManpowerReports = $this->CounselorManpowerReportModel->get_by_no($yearType, $monthType, $county);
                $beSentDataset['counselorManpowerReports'] = $counselorManpowerReports;
                return $this->load->view('report/counselor_manpower_report_organization_table', $beSentDataset);
              }
            }

            if (empty($reviewStatuses)) {
                return $this->load->view('report/counselor_manpower_report_organization_table', $beSentDataset);
            }

            if ($monthType % 3 == 0) {
              $reportNameArray = ['high_school_trend_survey_count_report', 'counseling_member_count_report', 'two_years_trend_survey_count_report',
                  'one_years_trend_survey_count_report', 'now_years_trend_survey_count_report',
                  'old_case_trend_survey_count_report', 'counselor_manpower_report',
                  'counseling_identity_count_report', 'counseling_meeting_count_report'];
            } else {
                $reportNameArray = ['counseling_member_count_report', 'counselor_manpower_report',
                  'counseling_identity_count_report', 'counseling_meeting_count_report'];
            }

            $reportNoArray = [];
            $reportArray = [];

            $counselingMemberCountReport = $this->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $county);
            $counselingMemberCountReportNo = $counselingMemberCountReport ? $counselingMemberCountReport->no : 0;  
            array_push($reportArray, $counselingMemberCountReport);           
            array_push($reportNoArray, $counselingMemberCountReportNo);

            if ($monthType % 3 == 0) {
              $highSchoolTrendSurveyCountReports = $this->HighSchoolTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
              $highSchoolTrendSurveyCountReportNo = $highSchoolTrendSurveyCountReports ? $highSchoolTrendSurveyCountReports->no : 0;
              array_push($reportArray, $highSchoolTrendSurveyCountReports);
              array_push($reportNoArray, $highSchoolTrendSurveyCountReportNo);

                $twoYearsTrendSurveyCountReports = $this->TwoYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $twoYearsTrendSurveyCountReportNo = $twoYearsTrendSurveyCountReports ? $twoYearsTrendSurveyCountReports->no : 0;
                array_push($reportArray, $twoYearsTrendSurveyCountReports);
                array_push($reportNoArray, $twoYearsTrendSurveyCountReportNo);
            
                $oneYearsTrendSurveyCountReports = $this->OneYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $oneYearsTrendSurveyCountReportNo = $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->no : 0;
                array_push($reportArray, $oneYearsTrendSurveyCountReports);
                array_push($reportNoArray, $oneYearsTrendSurveyCountReportNo);
            
                $nowYearsTrendSurveyCountReports = $this->NowYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $nowYearsTrendSurveyCountReportNo = $nowYearsTrendSurveyCountReports ? $nowYearsTrendSurveyCountReports->no : 0;
                array_push($reportArray, $nowYearsTrendSurveyCountReports);
                array_push($reportNoArray, $nowYearsTrendSurveyCountReportNo);
            
                $oldCaseTrendSurveyCountReports = $this->OldCaseTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $oldCaseTrendSurveyCountReportNo = $oldCaseTrendSurveyCountReports ? $oldCaseTrendSurveyCountReports->no : 0;
                array_push($reportArray, $oldCaseTrendSurveyCountReports);
                array_push($reportNoArray, $oldCaseTrendSurveyCountReportNo);
            }
            
            $counselorManpowerReports = $this->CounselorManpowerReportModel->get_by_no($yearType, $monthType, $county);
            $counselorManpowerReportNo = $counselorManpowerReports ? $counselorManpowerReports->no : 0;
            array_push($reportArray, $counselorManpowerReports);      
            array_push($reportNoArray, $counselorManpowerReportNo);
            
            $get_inserted_identity_count_data = $this->CounselingIdentityCountReportModel->get_inserted_identity_count_data($yearType, $monthType, $projects->no);
            $counselingIdentityCountReportNo = $get_inserted_identity_count_data ? $get_inserted_identity_count_data->no : 0;
            array_push($reportArray, $get_inserted_identity_count_data);      
            array_push($reportNoArray, $counselingIdentityCountReportNo);
            
            $get_inserted_meeting_count_data = $this->CounselingMeetingCountReportModel->get_inserted_meeting_count_data($yearType, $monthType, $projects->no);
            $counselingMeetingCountReportNo = $get_inserted_meeting_count_data ? $get_inserted_meeting_count_data->no : 0;
            array_push($reportArray, $get_inserted_meeting_count_data);      
            array_push($reportNoArray, $counselingMeetingCountReportNo);

            // file format define
            // 檔案內容大小限制5000KB,並支援JPG,PNG,PDF
            $config['upload_path'] = './files/';
            $config['allowed_types'] = 'jpg|png|pdf';
            $config['max_size'] = 5000;
            $config['max_width'] = 5000;
            $config['max_height'] = 5000;
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);
            // upload family diagram
            if ($this->upload->do_upload('reportFile')) {
                $fileMetaData = $this->upload->data();
                $reportFile = $this->FileModel->create_one($counselorManpowerReports->no, $fileMetaData['file_name'], $fileMetaData['orig_name']);
            }

            $isUpdateReportFile = $this->CounselorManpowerReportModel->update_file_by_no($counselorManpowerReports->no, $reportFile);
            
            if ($isUpdateReportFile) {
                if ($reviewStatuses == $reviewStatus['review_process_not_pass']) {
                    $this->ReviewProcessModel->update_one('counselor_manpower_report', $counselorManpowerReports->no, $reviewStatus['review_process_wait'], 6);
                    $this->ReviewProcessModel->update_one('counselor_manpower_report', $counselorManpowerReports->no, $reviewStatus['review_process_not_pass'], 3);

                    $this->ReviewLogModel->create_one('counselor_manpower_report', $counselorManpowerReports->no, $reviewStatus['review_process_not_pass'], $comment, $current_role, $userId);
                    $this->ReviewLogModel->create_one('counselor_manpower_report', $counselorManpowerReports->no, $reviewStatus['review_process_wait'], null, 6, $counselorId);
            
                    $counselorInfo = $this->UserModel->get_name_by_id($counselorId);
                    $userName = $this->UserModel->get_name_by_id($userId)->name;

                    $recipient = $counselorInfo->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】縣市承辦人退回' . $yearType . '年' . $monthType .'月 輔導人力概況表通知';
                    $content = '<p>' . $counselorInfo->name . ' 君 您好:</p>'
                . '<p>' . $userName . '退回' . $yearType . '年' . $monthType . '月 輔導人力概況表</p>'
                . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
                . '<p>祝 平安快樂</p><p></p>'
                . '<p>教育部青年發展署雙青計畫行政系統</p>'
                . '<p>' . date('Y-m-d') . '</p>'
                    . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipient, $title, $content);
                } elseif ($reviewStatuses == $reviewStatus['review_process_pass']) {
                    $ydaContractor = 'yda';
                    $this->ReviewProcessModel->update_one('counselor_manpower_report', $counselorManpowerReports->no, $reviewStatus['review_process_wait'], 1);
                    $this->ReviewProcessModel->update_one('counselor_manpower_report', $counselorManpowerReports->no, $reviewStatus['review_process_pass'], 3);

                    $this->ReviewLogModel->create_one('counselor_manpower_report', $counselorManpowerReports->no, $reviewStatus['review_process_pass'], $comment, $current_role, $userId);
                    $this->ReviewLogModel->create_one('counselor_manpower_report', $counselorManpowerReports->no, $reviewStatus['review_process_wait'], null, 1, $ydaContractor);
            
                    $check = 1;
                    $count = 0;
                    $reportProcessesCountyStatusArray = $reportProcessesYdaStatusArray = $reportLogsArray = [];
                    foreach ($reportNameArray as $reportName) {
                        $reportProcessesCounty = $reportArray[$count] ? $this->ReviewProcessModel->get_by_county($reportName, $reportNoArray[$count]) : null;
                        $reportProcessesCountyStatus = $reportProcessesCounty ? $reportProcessesCounty->review_status : null;

                        if ($reportProcessesCountyStatus != $reviewStatus['review_process_pass']) {
                            $check = 0;
                        }
                        array_push($reportProcessesCountyStatusArray, $reportProcessesCountyStatus);
                        $count++;
                    }

                    if ($check) { // 縣市報表全部已繳交
                        $this->TimingReportModel->create_one($county, null, $monthType, $yearType);
                    }
              
                    $ydaInfo = $this->UserModel->get_by_yda_row();
                    $userName = $this->UserModel->get_name_by_id($userId)->name;

                    $recipient = $ydaInfo->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】' . $countyName . '承辦人繳交' . $yearType . '年' . $monthType .'月 輔導人力概況表通知';
                    $content = '<p>' . $ydaInfo->name . ' 君 您好:</p>'
              . '<p>' . $countyName . '承辦人繳交' . $yearType . '年' . $monthType . '月 輔導人力概況表</p>'
              . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
              . '<p>祝 平安快樂</p><p></p>'
              . '<p>教育部青年發展署雙青計畫行政系統</p>'
              . '<p>' . date('Y-m-d') . '</p>'
                  . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipient, $title, $content);
                }

                $reportProcessesCountyStatus = $counselorManpowerReports ? $this->ReviewProcessModel->get_by_county('counselor_manpower_report', $counselorManpowerReports->no)->review_status : null;
                $reportProcessesCounselorStatus = $counselorManpowerReports ? $this->ReviewProcessModel->get_by_counselor('counselor_manpower_report', $counselorManpowerReports->no)->review_status : null;
                $reportLogs = $counselorManpowerReports ? $this->ReviewLogModel->get_by_report_no('counselor_manpower_report', $counselorManpowerReports->no) : null;
                $beSentDataset['reportProcessesCountyStatus'] = $reportProcessesCountyStatus;
                $beSentDataset['reportProcessesCounselorStatus'] = $reportProcessesCounselorStatus;
                $beSentDataset['reportLogs'] = $reportLogs;
            } else {
              $beSentDataset['error'] = '新增失敗';
            }
            $this->load->view('report/counselor_manpower_report_organization_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function counselor_manpower_report_yda_table($yearType = null, $monthType = null, $countyType = 'all')
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $userId = $passport['id'];
        $accept_role = array(1, 8, 9);
        if (in_array($current_role, $accept_role)) {
            $county = $countyType ? $countyType : '1';
            $years = $this->ProjectModel->get_distinct_year_by_county('1');
            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }
            if ($monthType == null) {
                $monthType = date("m");
            }
            $months = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
            $countiesName = $this->CountyModel->get_all();
            $counselorManpowerReports = $this->CounselorManpowerReportModel->get_by_all($yearType, $monthType, $countyType);
        

            $counties = $this->CountyModel->get_all();

            $sumDetail = [];
            $tempSum = $projectCounselorSum = $reallyCounselorSum = $educationCounselorSum = $counselingCenterCounselorSum = $schoolCounselorSum = $outsourcingCounselorSum = $bachelorDegreeSum
            = $masterDegreeSum = $qualificationOneSum = $qualificationTwoSum = $qualificationThreeSum = $qualificationFourSum = $qualificationFiveSum = $qualificationSixSum = 0;

            foreach ($counselorManpowerReports as $value) {
                $projectCounselorSum += $value['project_counselor'];
                $reallyCounselorSum += $value['really_counselor'];
                $educationCounselorSum += $value['education_counselor'];
                $counselingCenterCounselorSum += $value['counseling_center_counselor'];
                $schoolCounselorSum += $value['school_counselor'];
                $outsourcingCounselorSum += $value['outsourcing_counselor'];
                $bachelorDegreeSum += $value['bachelor_degree'];
                $masterDegreeSum += $value['master_degree'];
                $qualificationOneSum += $value['qualification_three'];
                $qualificationTwoSum += $value['qualification_four'];
                $qualificationThreeSum += ($value['qualification_one'] + $value['qualification_two'] + $value['qualification_five'] + $value['qualification_six']);
            }

            $sumDetail['projectCounselorSum'] = $projectCounselorSum;
            $sumDetail['reallyCounselorSum'] = $reallyCounselorSum;
            $sumDetail['educationCounselorSum'] = $educationCounselorSum;
            $sumDetail['counselingCenterCounselorSum'] = $counselingCenterCounselorSum;
            $sumDetail['schoolCounselorSum'] = $schoolCounselorSum;
            $sumDetail['outsourcingCounselorSum'] = $outsourcingCounselorSum;
            $sumDetail['bachelorDegreeSum'] = $bachelorDegreeSum;
            $sumDetail['masterDegreeSum'] = $masterDegreeSum;
            $sumDetail['qualificationOneSum'] = $qualificationOneSum;
            $sumDetail['qualificationTwoSum'] = $qualificationTwoSum;
            $sumDetail['qualificationThreeSum'] = $qualificationThreeSum;

            $projectArray = [];
            $counselorManpowerReportArray = [];
            $reportProcessesCountyStatusArray = [];
            $reportProcessesYdaStatusArray = [] ;
            $reportLogsArray = [];     
            $countyIdArray = [];
            $isOverTimeArray = [];

            $processReviewStatuses = $this->MenuModel->get_by_form_and_column('review_process', 'review_status');
            $logReviewStatuses = $this->MenuModel->get_by_form_and_column('review_log', 'review_status');
            $reviewStatus = [];
        
            $reviewStatus['review_process_not_pass'] = $this->MenuModel->get_no_resource_by_content('未批准', 'review_process')->no; 
            $reviewStatus['review_process_pass'] = $this->MenuModel->get_no_resource_by_content('批准', 'review_process')->no;
            $reviewStatus['review_process_wait'] = $this->MenuModel->get_no_resource_by_content('等待送出', 'review_process')->no;

            if ($countyType == 'all') {
              $counties = $this->CountyModel->get_all();
            } else {
                $counties = $this->CountyModel->get_one($countyType);
            }
          
            foreach ($counties as $county) {
              $projects = $this->ProjectModel->get_latest_by_county($county['no']);
              array_push($projectArray, $projects);
            
              $counselorManpowerReport = $this->CounselorManpowerReportModel->get_by_no($yearType, $monthType, $county['no']);
              array_push($counselorManpowerReportArray, $counselorManpowerReport);

              $reportProcessesCounty = $counselorManpowerReport ? $this->ReviewProcessModel->get_by_county('counselor_manpower_report', $counselorManpowerReport->no) : null;
              $reportProcessesCountyStatus = $reportProcessesCounty ? $reportProcessesCounty->review_status : null;
              
              array_push($reportProcessesCountyStatusArray, $reportProcessesCountyStatus);
              
              $reportProcessesYda = $counselorManpowerReport ? $this->ReviewProcessModel->get_by_yda('counselor_manpower_report', $counselorManpowerReport->no) : null;
              $reportProcessesYdaStatus = $reportProcessesYda ? $reportProcessesYda->review_status : null;
              array_push($reportProcessesYdaStatusArray, $reportProcessesYdaStatus);
              
              $reportLogs = $counselorManpowerReport ? $this->ReviewLogModel->get_by_report_no('counselor_manpower_report', $counselorManpowerReport->no) : null;
              array_push($reportLogsArray, $reportLogs);

              $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
              $addMonth = ($addMonth > 9) ? $addMonth : '0'.$addMonth;
              $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;
              $overTimeDate = ($addYear + 1911) . '-' . $addMonth . '-05 00:00:00'; 
              $countyId = "";
              $isOverTime = 0;
              if ($reportLogs) {
                  foreach ($reportLogs as $value) {
                      if ($value['user_role'] == 3) {
                          $countyId = $value['user_id'];
                          $isOverTime = ($value['time'] > $overTimeDate) ? ($value['time'] > $overTimeDate) : 0;      
                      }
                  }
                  
              }
              array_push($countyIdArray, $countyId);
              array_push($isOverTimeArray, $isOverTime);
            }


            $beSentDataset = array(
                'title' => '表四.輔導人力概況表',
                'url' => '/report/counselor_manpower_report_yda_table/' . $yearType . '/' . $monthType . '/' . $countyType,
                'role' => $current_role,
                'counties' => $counties,
                'countyType' => $countyType,
                'userTitle' => $userTitle,
                'yearType' => $yearType,
                'monthType' => $monthType,
                'counselorManpowerReports' => $counselorManpowerReports,
                'years' => $years,
                'months' => $months,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'security' => $this->security,
                'sumDetail' => $sumDetail,
                'counselorManpowerReportArray' => $counselorManpowerReportArray,
                'reportProcessesCountyStatusArray' => $reportProcessesCountyStatusArray,
                'reportProcessesYdaStatusArray' => $reportProcessesYdaStatusArray,
                'reportLogsArray' => $reportLogsArray,
                'countyIdArray' => $countyIdArray,
                'reviewStatus' => $reviewStatus,
                'processReviewStatuses' => $processReviewStatuses,
                'isOverTimeArray' => $isOverTimeArray,
                'countiesName' => $countiesName
            );

            $reviewStatuses = $this->security->xss_clean($this->input->post('reviewStatus'));
            $comment = $this->security->xss_clean($this->input->post('comment'));

            if (empty($reviewStatuses)) {
                return $this->load->view('report/counselor_manpower_report_yda_table', $beSentDataset);
            }

            $reportProcessesCountyStatusArray = [];
            $reportProcessesYdaStatusArray = [];
            $reportLogsArray = [];

            if ($monthType % 3 == 0) {
              $reportNameArray = ['high_school_trend_survey_count_report', 'counseling_member_count_report', 'two_years_trend_survey_count_report',
              'one_years_trend_survey_count_report', 'now_years_trend_survey_count_report',
              'old_case_trend_survey_count_report', 'counselor_manpower_report',
              'counseling_identity_count_report', 'counseling_meeting_count_report'];
            } else {
              $reportNameArray = ['counseling_member_count_report', 'counselor_manpower_report',
                'counseling_identity_count_report', 'counseling_meeting_count_report'];
            }          

            for ($i = 0; $i < count($counties); $i++) {

                $reportNoArray = [];
                $reportArray = [];

                $counselingMemberCountReport = $this->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                $counselingMemberCountReportNo = $counselingMemberCountReport ? $counselingMemberCountReport->no : 0;  
                array_push($reportArray, $counselingMemberCountReport);           
                array_push($reportNoArray, $counselingMemberCountReportNo);

                if ($monthType % 3 == 0) {
                  $highSchoolTrendSurveyCountReports = $this->HighSchoolTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                  $highSchoolTrendSurveyCountReportNo = $highSchoolTrendSurveyCountReports ? $highSchoolTrendSurveyCountReports->no : 0;
                  array_push($reportArray, $highSchoolTrendSurveyCountReports);
                  array_push($reportNoArray, $highSchoolTrendSurveyCountReportNo);

                    $twoYearsTrendSurveyCountReports = $this->TwoYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $twoYearsTrendSurveyCountReportNo = $twoYearsTrendSurveyCountReports ? $twoYearsTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $twoYearsTrendSurveyCountReports);
                    array_push($reportNoArray, $twoYearsTrendSurveyCountReportNo);
                
                    $oneYearsTrendSurveyCountReports = $this->OneYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $oneYearsTrendSurveyCountReportNo = $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $oneYearsTrendSurveyCountReports);
                    array_push($reportNoArray, $oneYearsTrendSurveyCountReportNo);
                
                    $nowYearsTrendSurveyCountReports = $this->NowYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $nowYearsTrendSurveyCountReportNo = $nowYearsTrendSurveyCountReports ? $nowYearsTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $nowYearsTrendSurveyCountReports);
                    array_push($reportNoArray, $nowYearsTrendSurveyCountReportNo);
                
                    $oldCaseTrendSurveyCountReports = $this->OldCaseTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $oldCaseTrendSurveyCountReportNo = $oldCaseTrendSurveyCountReports ? $oldCaseTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $oldCaseTrendSurveyCountReports);
                    array_push($reportNoArray, $oldCaseTrendSurveyCountReportNo);
                }
                
                $counselorManpowerReports = $this->CounselorManpowerReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                $counselorManpowerReportNo = $counselorManpowerReports ? $counselorManpowerReports->no : 0;
                array_push($reportArray, $counselorManpowerReports);      
                array_push($reportNoArray, $counselorManpowerReportNo);
                
                $get_inserted_identity_count_data = $this->CounselingIdentityCountReportModel->get_inserted_identity_count_data($yearType, $monthType, $projectArray[$i]->no);
                $counselingIdentityCountReportNo = $get_inserted_identity_count_data ? $get_inserted_identity_count_data->no : 0;
                array_push($reportArray, $get_inserted_identity_count_data);      
                array_push($reportNoArray, $counselingIdentityCountReportNo);
                
                $get_inserted_meeting_count_data = $this->CounselingMeetingCountReportModel->get_inserted_meeting_count_data($yearType, $monthType, $projectArray[$i]->no);
                $counselingMeetingCountReportNo = $get_inserted_meeting_count_data ? $get_inserted_meeting_count_data->no : 0;
                array_push($reportArray, $get_inserted_meeting_count_data);      
                array_push($reportNoArray, $counselingMeetingCountReportNo);

                if ($reviewStatuses == $reviewStatus['review_process_not_pass']) {

                    $this->ReviewProcessModel->update_one('counselor_manpower_report', $counselorManpowerReportArray[$i]->no, $reviewStatus['review_process_wait'], 3);
                    $this->ReviewProcessModel->update_one('counselor_manpower_report', $counselorManpowerReportArray[$i]->no, $reviewStatus['review_process_not_pass'], 1);

                    $this->ReviewLogModel->create_one('counselor_manpower_report', $counselorManpowerReportArray[$i]->no, $reviewStatus['review_process_not_pass'], $comment, $current_role, $userId);
                    $this->ReviewLogModel->create_one('counselor_manpower_report', $counselorManpowerReportArray[$i]->no, $reviewStatus['review_process_wait'], null, 3, $countyIdArray[$i]);
                
                    $countyContractor = $this->UserModel->get_name_by_id($countyIdArray[$i]);
                    $userName = $this->UserModel->get_name_by_id($userId)->name;
    
                    $recipient = $countyContractor->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】青年署退回' . $yearType . '年' . $monthType .'月 輔導人力概況表通知';
                    $content = '<p>' . $countyContractor->name . ' 君 您好:</p>'
                    . '<p>' . $userName . '退回' . $yearType . '年' . $monthType . '月 輔導人力概況表</p>'
                    . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';
    
                    //api_send_email_temp($recipient, $title, $content);
                } elseif ($reviewStatuses == $reviewStatus['review_process_pass']) {

                    $this->ReviewProcessModel->update_one('counselor_manpower_report', $counselorManpowerReportArray[$i]->no, $reviewStatus['review_process_pass'], 1);

                    $this->ReviewLogModel->create_one('counselor_manpower_report', $counselorManpowerReportArray[$i]->no, $reviewStatus['review_process_pass'], $comment, $current_role, $userId);

                    $check = 1;
                    $count = 0;
                    $reportProcessesCountyStatusArray = $reportProcessesYdaStatusArray = $reportLogsArray = [];
                    foreach($reportNameArray as $reportName) {
 
                      $reportProcessesYda = $reportArray[$count] ? $this->ReviewProcessModel->get_by_yda($reportName, $reportNoArray[$count]) : null;
                      $reportProcessesYdaStatus = $reportProcessesYda ? $reportProcessesYda->review_status : null;
      
                      array_push($reportProcessesYdaStatusArray, $reportProcessesYdaStatus);

                      if($reportProcessesCountyStatus != $reviewStatus['review_process_pass']) {
                        $check = 0;
                      }

                      $count ++;
                    }
                    $userInfo = $this->UserModel->get_name_by_id($userId);
                    if($check) { // 縣市報表全部已繳交
                      $this->TimingReportModel->create_one($counties[$i]['no'], $userInfo->yda, $monthType, $yearType);
                    }
                }
                $reportProcessesCountyStatus = $counselorManpowerReportArray[$i] ? $this->ReviewProcessModel->get_by_county('counselor_manpower_report', $counselorManpowerReportArray[$i]->no)->review_status : null;

                array_push($reportProcessesCountyStatusArray, $reportProcessesCountyStatus);

                $reportProcessesYdaStatus = $counselorManpowerReportArray[$i] ? $this->ReviewProcessModel->get_by_yda('counselor_manpower_report', $counselorManpowerReportArray[$i]->no)->review_status : null;
                array_push($reportProcessesYdaStatusArray, $reportProcessesYdaStatus);

                $reportLogs = $counselorManpowerReportArray[$i] ? $this->ReviewLogModel->get_by_report_no('counselor_manpower_report', $counselorManpowerReportArray[$i]->no) : null;
                array_push($reportLogsArray, $reportLogs);

                $countyId = "";
                if ($reportLogs) {
                    foreach ($reportLogs as $value) {
                        if ($value['user_role'] == 3) {
                            $countyId = $value['user_id'];
                        }
                    }
                }
                array_push($countyIdArray, $countyId);
            }

            $beSentDataset['reportProcessesCountyStatusArray'] = $reportProcessesCountyStatusArray;
            $beSentDataset['reportProcessesYdaStatusArray'] = $reportProcessesYdaStatusArray;
            $beSentDataset['reportLogsArray'] = $reportLogsArray;

            $this->load->view('report/counselor_manpower_report_yda_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function counseling_identity_count_report($yearType = null, $monthType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $userId = $passport['id'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $county = $passport['county'];
            $organization = $passport['organization'];
            $years = $this->ProjectModel->get_distinct_year_by_county($county);
            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }
            if ($monthType == null) {
                $monthType = date("m");
            }
            $months = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
            $projects = $this->ProjectModel->get_latest_by_county($county);
            $counties = $this->CountyModel->get_all();
            $get_inserted_identity_count_data = $this->CounselingIdentityCountReportModel->get_inserted_identity_count_data($yearType, $monthType, $projects->no);
            //取得menu對應no
            $educationTypeNo = [];
            $educationTypeNo['educationTypeJuniorUnderGraduate'] = 0;
            $educationTypeNo['educationTypeSixteenYearsOld'] = $this->MenuModel->get_no_resource_by_content('中輟滿16歲未升學未就業', 'case_assessment')->no;
            $educationTypeNo['educationTypeJuniorGraduatedThisYear'] = $this->MenuModel->get_no_resource_by_content('國中畢業未升學未就業(應屆畢業)', 'case_assessment')->no;
            $educationTypeNo['educationTypeJuniorGraduatedNotThisYear'] = $this->MenuModel->get_no_resource_by_content('國中畢業未升學未就業(非應屆畢業)', 'case_assessment')->no;

            //一到三年級的no
            $educationTypeNo['educationTypeDropOutFromSeniorOne'] = $this->MenuModel->get_no_resource_by_content('高中中離(一年級)', 'case_assessment')->no;
            $educationTypeNo['educationTypeDropOutFromSeniorThree'] = $this->MenuModel->get_no_resource_by_content('高中中離(三年級)', 'case_assessment')->no;
            $genderTypeNo = [];
            $genderTypeNo['boy'] = $this->MenuModel->get_no_resource_by_content('男', 'youth')->no;
            $genderTypeNo['girl'] = $this->MenuModel->get_no_resource_by_content('女', 'youth')->no;

            $processReviewStatuses = $this->MenuModel->get_by_form_and_column('review_process', 'review_status');
            $logReviewStatuses = $this->MenuModel->get_by_form_and_column('review_log', 'review_status');
            $reviewStatus = [];
       
            $reviewStatus['review_process_not_pass'] = $this->MenuModel->get_no_resource_by_content('未批准', 'review_process')->no;    
            $reviewStatus['review_process_pass'] = $this->MenuModel->get_no_resource_by_content('批准', 'review_process')->no;
            $reviewStatus['review_process_wait'] = $this->MenuModel->get_no_resource_by_content('等待送出', 'review_process')->no;


            $reportProcessesCounselor = $get_inserted_identity_count_data ? $this->ReviewProcessModel->get_by_counselor('counseling_identity_count_report', $get_inserted_identity_count_data->no) : null;
            $reportProcessesCounselorStatus = $reportProcessesCounselor ? $reportProcessesCounselor->review_status : null;
            $reportLogs = $get_inserted_identity_count_data ? $this->ReviewLogModel->get_by_report_no('counseling_identity_count_report', $get_inserted_identity_count_data->no) : null;

            $beSentDataset = array(
                'title' => '表二.輔導對象身分統計',
                'url' => '/report/counseling_identity_count_report/' . $yearType . "/" . $monthType,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'counties' => $counties,
                'county' => $county,
                'projects' => $projects,
                'security' => $this->security,
                'yearType' => $yearType,
                'monthType' => $monthType,
                'years' => $years,
                'months' => $months,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'get_inserted_identity_count_data' => $get_inserted_identity_count_data,
                'reportProcessesCounselorStatus' => $reportProcessesCounselorStatus,
                'reviewStatus' => $reviewStatus,
                'reportLogs' => $reportLogs,
                'processReviewStatuses' => $processReviewStatuses
            );

            $count_junior_under_graduate_boy = $this->CounselingIdentityCountReportModel->get_junior_under_graduate_count("boy", $yearType, $monthType, $county, $educationTypeNo['educationTypeJuniorUnderGraduate'], $genderTypeNo['boy'])[0]["count_num"];
            $count_junior_under_graduate_girl = $this->CounselingIdentityCountReportModel->get_junior_under_graduate_count("girl", $yearType, $monthType, $county, $educationTypeNo['educationTypeJuniorUnderGraduate'], $genderTypeNo['girl'])[0]["count_num"];
            $count_sixteen_years_old_not_employed_not_studying_boy = $this->CounselingIdentityCountReportModel->get_sixteen_years_old_not_employed_not_studying("boy", $yearType, $monthType, $county, $educationTypeNo['educationTypeSixteenYearsOld'], $genderTypeNo['boy'])[0]["count_num"];
            $count_sixteen_years_old_not_employed_not_studying_girl = $this->CounselingIdentityCountReportModel->get_sixteen_years_old_not_employed_not_studying("girl", $yearType, $monthType, $county, $educationTypeNo['educationTypeSixteenYearsOld'], $genderTypeNo['girl'])[0]["count_num"];
            $count_junior_graduated_this_year_unemployed_not_studying_boy = $this->CounselingIdentityCountReportModel->junior_graduated_this_year_unemployed_not_studying("boy", $yearType, $monthType, $county, $educationTypeNo['educationTypeJuniorGraduatedThisYear'], $genderTypeNo['boy'])[0]["count_num"];
            $count_junior_graduated_this_year_unemployed_not_studying_girl = $this->CounselingIdentityCountReportModel->junior_graduated_this_year_unemployed_not_studying("girl", $yearType, $monthType, $county, $educationTypeNo['educationTypeJuniorGraduatedThisYear'], $genderTypeNo['girl'])[0]["count_num"];
            $count_junior_graduated_not_this_year_unemployed_not_studying_boy = $this->CounselingIdentityCountReportModel->junior_graduated_not_this_year_unemployed_not_studying("boy", $yearType, $monthType, $county, $educationTypeNo['educationTypeJuniorGraduatedNotThisYear'], $genderTypeNo['boy'])[0]["count_num"];
            $count_junior_graduated_not_this_year_unemployed_not_studying_girl = $this->CounselingIdentityCountReportModel->junior_graduated_not_this_year_unemployed_not_studying("girl", $yearType, $monthType, $county, $educationTypeNo['educationTypeJuniorGraduatedNotThisYear'], $genderTypeNo['girl'])[0]["count_num"];
            $drop_out_from_senior_boy = $this->CounselingIdentityCountReportModel->drop_out_from_senior("boy", $yearType, $monthType, $county, $educationTypeNo['educationTypeDropOutFromSeniorOne'], $educationTypeNo['educationTypeDropOutFromSeniorThree'], $genderTypeNo['boy'])[0]["count_num"];
            $drop_out_from_senior_girl = $this->CounselingIdentityCountReportModel->drop_out_from_senior("girl", $yearType, $monthType, $county, $educationTypeNo['educationTypeDropOutFromSeniorOne'], $educationTypeNo['educationTypeDropOutFromSeniorThree'], $genderTypeNo['girl'])[0]["count_num"];

            $beSentDataset['count_junior_under_graduate_boy'] = $count_junior_under_graduate_boy;
            $beSentDataset['count_junior_under_graduate_girl'] = $count_junior_under_graduate_girl;
            $beSentDataset['count_sixteen_years_old_not_employed_not_studying_boy'] = $count_sixteen_years_old_not_employed_not_studying_boy;
            $beSentDataset['count_sixteen_years_old_not_employed_not_studying_girl'] = $count_sixteen_years_old_not_employed_not_studying_girl;
            $beSentDataset['count_junior_graduated_this_year_unemployed_not_studying_boy'] = $count_junior_graduated_this_year_unemployed_not_studying_boy;
            $beSentDataset['count_junior_graduated_this_year_unemployed_not_studying_girl'] = $count_junior_graduated_this_year_unemployed_not_studying_girl;
            $beSentDataset['count_junior_graduated_not_this_year_unemployed_not_studying_boy'] = $count_junior_graduated_not_this_year_unemployed_not_studying_boy;
            $beSentDataset['count_junior_graduated_not_this_year_unemployed_not_studying_girl'] = $count_junior_graduated_not_this_year_unemployed_not_studying_girl;
            $beSentDataset['drop_out_from_senior_boy'] = $drop_out_from_senior_boy;
            $beSentDataset['drop_out_from_senior_girl'] = $drop_out_from_senior_girl;

            $junior_under_graduate_boy = $count_junior_under_graduate_boy;
            $junior_under_graduate_girl = $count_junior_under_graduate_girl;
            $sixteen_years_old_not_employed_not_studying_boy = $count_sixteen_years_old_not_employed_not_studying_boy;
            $sixteen_years_old_not_employed_not_studying_girl = $count_sixteen_years_old_not_employed_not_studying_girl;
            $junior_graduated_this_year_unemployed_not_studying_boy = $count_junior_graduated_this_year_unemployed_not_studying_boy;
            $junior_graduated_this_year_unemployed_not_studying_girl = $count_junior_graduated_this_year_unemployed_not_studying_girl;
            $junior_graduated_not_this_year_unemployed_not_studying_boy = $count_junior_graduated_not_this_year_unemployed_not_studying_boy;
            $junior_graduated_not_this_year_unemployed_not_studying_girl = $count_junior_graduated_not_this_year_unemployed_not_studying_girl;
            $drop_out_from_senior_boy = $drop_out_from_senior_boy;
            $drop_out_from_senior_girl = $drop_out_from_senior_girl;
            $is_review = 0;
            $date = date('Y-m-d');

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // if ($this->security->xss_clean($this->input->post('check_create')) == null) {
                //     return $this->load->view('report/counseling_identity_count_report', $beSentDataset);
                // }

                if ($get_inserted_identity_count_data) {
                    $isExecuteSuccess = $this->CounselingIdentityCountReportModel->edit(
                        $junior_under_graduate_boy,
                        $junior_under_graduate_girl,
                        $sixteen_years_old_not_employed_not_studying_boy,
                        $sixteen_years_old_not_employed_not_studying_girl,
                        $junior_graduated_this_year_unemployed_not_studying_boy,
                        $junior_graduated_this_year_unemployed_not_studying_girl,
                        $junior_graduated_not_this_year_unemployed_not_studying_boy,
                        $junior_graduated_not_this_year_unemployed_not_studying_girl,
                        $drop_out_from_senior_boy,
                        $drop_out_from_senior_girl,
                        $monthType,
                        $yearType,
                        $projects->no,
                        $is_review,
                        $date,
                        $get_inserted_identity_count_data->no
                    );
                } else {
                    $isExecuteSuccess = $this->CounselingIdentityCountReportModel->create_one(
                        $junior_under_graduate_boy,
                        $junior_under_graduate_girl,
                        $sixteen_years_old_not_employed_not_studying_boy,
                        $sixteen_years_old_not_employed_not_studying_girl,
                        $junior_graduated_this_year_unemployed_not_studying_boy,
                        $junior_graduated_this_year_unemployed_not_studying_girl,
                        $junior_graduated_not_this_year_unemployed_not_studying_boy,
                        $junior_graduated_not_this_year_unemployed_not_studying_girl,
                        $drop_out_from_senior_boy,
                        $drop_out_from_senior_girl,
                        $monthType,
                        $yearType,
                        $projects->no,
                        $is_review,
                        $date
                    );
                    $counselingIdentityCountReportArray = array(
                    $junior_under_graduate_boy,
                    $junior_under_graduate_girl,
                    $sixteen_years_old_not_employed_not_studying_boy,
                    $sixteen_years_old_not_employed_not_studying_girl,
                    $junior_graduated_this_year_unemployed_not_studying_boy,
                    $junior_graduated_this_year_unemployed_not_studying_girl,
                    $junior_graduated_not_this_year_unemployed_not_studying_boy,
                    $junior_graduated_not_this_year_unemployed_not_studying_girl,
                    $drop_out_from_senior_boy,
                    $drop_out_from_senior_girl
                );

                    $counselingIdentityCountReportNum = 0;
                    foreach ($counselingIdentityCountReportArray as $value) {
                        if ($value != null || $value == 0) {
                            $counselingIdentityCountReportNum++;
                        }
                    }

                    $counselingIdentityCountReportRate = round($counselingIdentityCountReportNum / count($counselingIdentityCountReportArray), 2) * 100;
                    // print($counselingIdentityCountReportNum . '/' . $counselingIdentityCountReportRate);
                    $counselingIdentityCountReportSuccess = $this->CompletionModel->create_one('counseling_identity_count_report', $isExecuteSuccess, $counselingIdentityCountReportRate);
                }
                $get_inserted_identity_count_data = $this->CounselingIdentityCountReportModel->get_inserted_identity_count_data($yearType, $monthType, $county);
                $beSentDataset['get_inserted_identity_count_data'] = $get_inserted_identity_count_data;

                if ($isExecuteSuccess) {
                    $beSentDataset['success'] = '新增成功';

                    if (isset($_POST['save'])) {
                        $get_inserted_identity_count_data = $this->CounselingIdentityCountReportModel->get_inserted_identity_count_data($yearType, $monthType, $projects->no);
                        $reportProcesses = $this->ReviewProcessModel->get_by_report_no('counseling_identity_count_report', $get_inserted_identity_count_data->no);
                        if ($reportProcesses) {
                            $this->ReviewProcessModel->update_one('counseling_identity_count_report', $get_inserted_identity_count_data->no, $reviewStatus['review_process_pass'], 6);
                            $this->ReviewProcessModel->update_one('counseling_identity_count_report', $get_inserted_identity_count_data->no, $reviewStatus['review_process_wait'], 3);
                        } else {
                            $this->ReviewProcessModel->create_one('counseling_identity_count_report', $get_inserted_identity_count_data->no, $reviewStatus['review_process_pass'], 6);
                            $this->ReviewProcessModel->create_one('counseling_identity_count_report', $get_inserted_identity_count_data->no, $reviewStatus['review_process_wait'], 3);
                            $this->ReviewProcessModel->create_one('counseling_identity_count_report', $get_inserted_identity_count_data->no, $reviewStatus['review_process_not_pass'], 1);
                        }
                        $countyContractor = $this->UserModel->get_latest_county_contractor($county);
                        $this->ReviewLogModel->create_one('counseling_identity_count_report', $get_inserted_identity_count_data->no, $reviewStatus['review_process_pass'], null, $current_role, $userId);
                        $this->ReviewLogModel->create_one('counseling_identity_count_report', $get_inserted_identity_count_data->no, $reviewStatus['review_process_wait'], null, 3, $countyContractor->id);

                        $countyContractor = $this->UserModel->get_by_county_contractor($county);
                        $userName = $this->UserModel->get_name_by_id($userId)->name;

                        $recipient = $countyContractor->email;
                        $title = '【教育部青年發展署雙青計畫行政系統】輔導員繳交' . $yearType . '年' . $monthType . '月 輔導對象身分別統計表通知';
                        $content = '<p>' . $countyContractor->name . ' 君 您好:</p>'
                  . '<p>' . $userName . '繳交' . $yearType . '年' . $monthType . '月 輔導對象身分別統計表</p>'
                  . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
                  . '<p>祝 平安快樂</p><p></p>'
                  . '<p>教育部青年發展署雙青計畫行政系統</p>'
                  . '<p>' . date('Y-m-d') . '</p>'
                      . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                        //api_send_email_temp($recipient, $title, $content);

                        $reportProcessesCounselorStatus = $get_inserted_identity_count_data ? $this->ReviewProcessModel->get_by_counselor('counseling_identity_count_report', $get_inserted_identity_count_data->no)->review_status : null;
                        $reportLogs = $get_inserted_identity_count_data ? $this->ReviewLogModel->get_by_report_no('counseling_identity_count_report', $get_inserted_identity_count_data->no) : null;
                        $beSentDataset['reportProcessesCounselorStatus'] = $reportProcessesCounselorStatus;
                        $beSentDataset['reportLogs'] = $reportLogs;
                    }
                } else {
                    $beSentDataset['error'] = '新增失敗';
                }
            }

          $this->load->view('report/counseling_identity_count_report', $beSentDataset);

        }
    }

    public function counseling_identity_count_report_table($yearType = null, $monthType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $userId = $passport['id'];
        $accept_role = array(2, 3, 4, 5);
        if (in_array($current_role, $accept_role)) {
            $county = $passport['county'];
            $organization = $passport['organization'];
            $years = $this->ProjectModel->get_distinct_year_by_county($county);
            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }
            if ($monthType == null) {
                $monthType = date("m");
            }
            $months = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
            $countiesName = $this->CountyModel->get_all();
            // $year = date("Y"); //西元

            $projects = $this->ProjectModel->get_latest_by_county($county);
            $counties = $this->CountyModel->get_all();
            $get_inserted_identity_count_data = $this->CounselingIdentityCountReportModel->get_inserted_identity_count_data($yearType, $monthType, $projects->no);

            $processReviewStatuses = $this->MenuModel->get_by_form_and_column('review_process', 'review_status');
            $logReviewStatuses = $this->MenuModel->get_by_form_and_column('review_log', 'review_status');
            $reviewStatus = [];
        
            $reviewStatus['review_process_not_pass'] = $this->MenuModel->get_no_resource_by_content('未批准', 'review_process')->no; 
            $reviewStatus['review_process_pass'] = $this->MenuModel->get_no_resource_by_content('批准', 'review_process')->no;
            $reviewStatus['review_process_wait'] = $this->MenuModel->get_no_resource_by_content('等待送出', 'review_process')->no;
       
            $reportProcessesCounty = $get_inserted_identity_count_data ? $this->ReviewProcessModel->get_by_county('counseling_identity_count_report', $get_inserted_identity_count_data->no) : null;
            $reportProcessesCountyStatus = $reportProcessesCounty ? $reportProcessesCounty->review_status : null;
            $reportProcessesCounselor = $get_inserted_identity_count_data ? $this->ReviewProcessModel->get_by_counselor('counseling_identity_count_report', $get_inserted_identity_count_data->no) : null;
            $reportProcessesCounselorStatus = $reportProcessesCounselor ? $reportProcessesCounselor->review_status : null;
            $reportLogs = $get_inserted_identity_count_data ? $this->ReviewLogModel->get_by_report_no('counseling_identity_count_report', $get_inserted_identity_count_data->no) : null;
            
            $counselorId = "";
            if ($reportLogs) {
              foreach ($reportLogs as $value) {
                  if ($value['user_role'] == 3) {
                      $counselorId = $value['user_id'];
                  }
              }
            }
            $countyName = "";
            foreach ($counties as $value) {
                if ($value['no'] == $county) {
                    $countyName = $value['name'];
                }
            }

            $beSentDataset = array(
                'title' => '表二.輔導對象身分統計',
                'url' => '/report/counseling_identity_count_report_table/' . $yearType . "/" . $monthType,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'get_inserted_identity_count_data' => $get_inserted_identity_count_data,
                'counties' => $counties,
                'county' => $county,
                'projects' => $projects,
                'security' => $this->security,
                'yearType' => $yearType,
                'monthType' => $monthType,
                'years' => $years,
                'months' => $months,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'reportProcessesCountyStatus' => $reportProcessesCountyStatus,
                'reportProcessesCounselorStatus' => $reportProcessesCounselorStatus,
                'reviewStatus' => $reviewStatus,
                'reportLogs' => $reportLogs,
                'processReviewStatuses' => $processReviewStatuses,
                'countiesName' => $countiesName
            );

            $reviewStatuses = $this->security->xss_clean($this->input->post('reviewStatus'));
            $comment = $this->security->xss_clean($this->input->post('comment'));
            $reportFile = $get_inserted_identity_count_data ? $get_inserted_identity_count_data->report_file : null;

            if (isset($_POST['resubmit'])) {
              $config['upload_path'] = './files/';
              $config['allowed_types'] = 'jpg|png|pdf';
              $config['max_size'] = 5000;
              $config['max_width'] = 5000;
              $config['max_height'] = 5000;
              $config['encrypt_name'] = true;
              $this->load->library('upload', $config);
              // upload family diagram
              if ($this->upload->do_upload('reportFile')) {
                $fileMetaData = $this->upload->data();
                $reportFile = $this->FileModel->create_one($get_inserted_identity_count_data->no, $fileMetaData['file_name'], $fileMetaData['orig_name']);
              }

              $isUpdateReportFile = $this->CounselingIdentityCountReportModel->update_file_by_no($get_inserted_identity_count_data->no, $reportFile);
              if ($isUpdateReportFile) {
                $get_inserted_identity_count_data = $this->CounselingIdentityCountReportModel->get_inserted_identity_count_data($yearType, $monthType, $projects->no);
                $beSentDataset['get_inserted_identity_count_data'] = $get_inserted_identity_count_data;
                return $this->load->view('report/counseling_identity_count_report_table', $beSentDataset);
              }
            }

            if (empty($reviewStatuses)) {
                return $this->load->view('report/counseling_identity_count_report_table', $beSentDataset);
            }

            if ($monthType % 3 == 0) {
              $reportNameArray = ['high_school_trend_survey_count_report', 'counseling_member_count_report', 'two_years_trend_survey_count_report',
                  'one_years_trend_survey_count_report', 'now_years_trend_survey_count_report',
                  'old_case_trend_survey_count_report', 'counselor_manpower_report',
                  'counseling_identity_count_report', 'counseling_meeting_count_report'];
            } else {
                $reportNameArray = ['counseling_member_count_report', 'counselor_manpower_report',
                  'counseling_identity_count_report', 'counseling_meeting_count_report'];
            }

            $reportNoArray = [];
            $reportArray = [];

            $counselingMemberCountReport = $this->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $county);
            $counselingMemberCountReportNo = $counselingMemberCountReport ? $counselingMemberCountReport->no : 0;  
            array_push($reportArray, $counselingMemberCountReport);           
            array_push($reportNoArray, $counselingMemberCountReportNo);

            if ($monthType % 3 == 0) {
              $highSchoolTrendSurveyCountReports = $this->HighSchoolTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
              $highSchoolTrendSurveyCountReportNo = $highSchoolTrendSurveyCountReports ? $highSchoolTrendSurveyCountReports->no : 0;
              array_push($reportArray, $highSchoolTrendSurveyCountReports);
              array_push($reportNoArray, $highSchoolTrendSurveyCountReportNo);

                $twoYearsTrendSurveyCountReports = $this->TwoYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $twoYearsTrendSurveyCountReportNo = $twoYearsTrendSurveyCountReports ? $twoYearsTrendSurveyCountReports->no : 0;
                array_push($reportArray, $twoYearsTrendSurveyCountReports);
                array_push($reportNoArray, $twoYearsTrendSurveyCountReportNo);
            
                $oneYearsTrendSurveyCountReports = $this->OneYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $oneYearsTrendSurveyCountReportNo = $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->no : 0;
                array_push($reportArray, $oneYearsTrendSurveyCountReports);
                array_push($reportNoArray, $oneYearsTrendSurveyCountReportNo);
            
                $nowYearsTrendSurveyCountReports = $this->NowYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $nowYearsTrendSurveyCountReportNo = $nowYearsTrendSurveyCountReports ? $nowYearsTrendSurveyCountReports->no : 0;
                array_push($reportArray, $nowYearsTrendSurveyCountReports);
                array_push($reportNoArray, $nowYearsTrendSurveyCountReportNo);
            
                $oldCaseTrendSurveyCountReports = $this->OldCaseTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $oldCaseTrendSurveyCountReportNo = $oldCaseTrendSurveyCountReports ? $oldCaseTrendSurveyCountReports->no : 0;
                array_push($reportArray, $oldCaseTrendSurveyCountReports);
                array_push($reportNoArray, $oldCaseTrendSurveyCountReportNo);
            }
            
            $counselorManpowerReports = $this->CounselorManpowerReportModel->get_by_no($yearType, $monthType, $county);
            $counselorManpowerReportNo = $counselorManpowerReports ? $counselorManpowerReports->no : 0;
            array_push($reportArray, $counselorManpowerReports);      
            array_push($reportNoArray, $counselorManpowerReportNo);
            
            $get_inserted_identity_count_data = $this->CounselingIdentityCountReportModel->get_inserted_identity_count_data($yearType, $monthType, $projects->no);
            $counselingIdentityCountReportNo = $get_inserted_identity_count_data ? $get_inserted_identity_count_data->no : 0;
            array_push($reportArray, $get_inserted_identity_count_data);      
            array_push($reportNoArray, $counselingIdentityCountReportNo);
            
            $get_inserted_meeting_count_data = $this->CounselingMeetingCountReportModel->get_inserted_meeting_count_data($yearType, $monthType, $projects->no);
            $counselingMeetingCountReportNo = $get_inserted_meeting_count_data ? $get_inserted_meeting_count_data->no : 0;
            array_push($reportArray, $get_inserted_meeting_count_data);      
            array_push($reportNoArray, $counselingMeetingCountReportNo);

            // file format define
            // 檔案內容大小限制5000KB,並支援JPG,PNG,PDF
            $config['upload_path'] = './files/';
            $config['allowed_types'] = 'jpg|png|pdf';
            $config['max_size'] = 5000;
            $config['max_width'] = 5000;
            $config['max_height'] = 5000;
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);
            // upload family diagram
            if ($this->upload->do_upload('reportFile')) {
                $fileMetaData = $this->upload->data();
                $reportFile = $this->FileModel->create_one($get_inserted_identity_count_data->no, $fileMetaData['file_name'], $fileMetaData['orig_name']);
            }

            $isUpdateReportFile = $this->CounselingIdentityCountReportModel->update_file_by_no($get_inserted_identity_count_data->no, $reportFile);

            if ($isUpdateReportFile) {
                if ($reviewStatuses == $reviewStatus['review_process_not_pass']) {
                    $this->ReviewProcessModel->update_one('counseling_identity_count_report', $get_inserted_identity_count_data->no, $reviewStatus['review_process_wait'], 6);
                    $this->ReviewProcessModel->update_one('counseling_identity_count_report', $get_inserted_identity_count_data->no, $reviewStatus['review_process_not_pass'], 3);

                    $this->ReviewLogModel->create_one('counseling_identity_count_report', $get_inserted_identity_count_data->no, $reviewStatus['review_process_not_pass'], $comment, $current_role, $userId);
                    $this->ReviewLogModel->create_one('counseling_identity_count_report', $get_inserted_identity_count_data->no, $reviewStatus['review_process_wait'], null, 6, $counselorId);

                    $counselorInfo = $this->UserModel->get_name_by_id($counselorId);
                    $userName = $this->UserModel->get_name_by_id($userId)->name;

                    $recipient = $counselorInfo->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】縣市承辦人退回' . $yearType . '年' . $monthType .'月 輔導對象身分統計表通知';
                    $content = '<p>' . $counselorInfo->name . ' 君 您好:</p>'
                . '<p>' . $userName . '退回' . $yearType . '年' . $monthType . '月 輔導對象身分統計表</p>'
                . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
                . '<p>祝 平安快樂</p><p></p>'
                . '<p>教育部青年發展署雙青計畫行政系統</p>'
                . '<p>' . date('Y-m-d') . '</p>'
                    . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipient, $title, $content);
                } elseif ($reviewStatuses == $reviewStatus['review_process_pass']) {
                    $ydaContractor = 'yda';
                    $this->ReviewProcessModel->update_one('counseling_identity_count_report', $get_inserted_identity_count_data->no, $reviewStatus['review_process_wait'], 1);
                    $this->ReviewProcessModel->update_one('counseling_identity_count_report', $get_inserted_identity_count_data->no, $reviewStatus['review_process_pass'], 3);

                    $this->ReviewLogModel->create_one('counseling_identity_count_report', $get_inserted_identity_count_data->no, $reviewStatus['review_process_pass'], $comment, $current_role, $userId);
                    $this->ReviewLogModel->create_one('counseling_identity_count_report', $get_inserted_identity_count_data->no, $reviewStatus['review_process_wait'], null, 1, $ydaContractor);
            
                    $check = 1;
                    $count = 0;
                    $reportProcessesCountyStatusArray = $reportProcessesYdaStatusArray = $reportLogsArray = [];
                    foreach ($reportNameArray as $reportName) {
                        $reportProcessesCounty = $reportArray[$count] ? $this->ReviewProcessModel->get_by_county($reportName, $reportNoArray[$count]) : null;
                        $reportProcessesCountyStatus = $reportProcessesCounty ? $reportProcessesCounty->review_status : null;

                        if ($reportProcessesCountyStatus != $reviewStatus['review_process_pass']) {
                            $check = 0;
                        }
                        array_push($reportProcessesCountyStatusArray, $reportProcessesCountyStatus);
                        $count++;
                    }

                    if ($check) { // 縣市報表全部已繳交
                        $this->TimingReportModel->create_one($county, null, $monthType, $yearType);
                    }
              
                    $ydaInfo = $this->UserModel->get_by_yda_row();
                    $userName = $this->UserModel->get_name_by_id($userId)->name;

                    $recipient = $ydaInfo->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】' . $countyName . '承辦人繳交' . $yearType . '年' . $monthType .'月 輔導對象身分統計表通知';
                    $content = '<p>' . $ydaInfo->name . ' 君 您好:</p>'
              . '<p>' . $countyName . '承辦人繳交' . $yearType . '年' . $monthType . '月 輔導對象身分統計表</p>'
              . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
              . '<p>祝 平安快樂</p><p></p>'
              . '<p>教育部青年發展署雙青計畫行政系統</p>'
              . '<p>' . date('Y-m-d') . '</p>'
                  . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipient, $title, $content);
                }
            

                $reportProcessesCountyStatus = $get_inserted_identity_count_data ? $this->ReviewProcessModel->get_by_county('counseling_identity_count_report', $get_inserted_identity_count_data->no)->review_status : null;
                $reportProcessesCounselorStatus = $get_inserted_identity_count_data ? $this->ReviewProcessModel->get_by_counselor('counseling_identity_count_report', $get_inserted_identity_count_data->no)->review_status : null;
                $reportLogs = $get_inserted_identity_count_data ? $this->ReviewLogModel->get_by_report_no('counseling_identity_count_report', $get_inserted_identity_count_data->no) : null;
                $beSentDataset['reportProcessesCountyStatus'] = $reportProcessesCountyStatus;
                $beSentDataset['reportProcessesCounselorStatus'] = $reportProcessesCounselorStatus;
                $beSentDataset['reportLogs'] = $reportLogs;
            } else {
              $beSentDataset['error'] = '新增失敗';
            }

            $this->load->view('report/counseling_identity_count_report_table', $beSentDataset);
        }
    }

    public function counseling_identity_count_report_yda_table($yearType = null, $monthType = null, $countyType = 'all')
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $userId = $passport['id'];
        $accept_role = array(1, 8, 9);
        if (in_array($current_role, $accept_role)) {
            $county = $countyType ? $countyType : '1';
            $organization = $passport['organization'];
            $years = $this->ProjectModel->get_distinct_year_by_county('1');

            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }
            if ($monthType == null) {
                $monthType = date("m");
            }
            $months = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
            $countiesName = $this->CountyModel->get_all();
            $get_all_inserted_identity_count_data = $this->CounselingIdentityCountReportModel->get_by_all($yearType, $monthType, $county);

            $projectArray = [];
            $get_all_inserted_identity_count_data_array = [];
            $reportProcessesCountyStatusArray = [];
            $reportProcessesYdaStatusArray = [] ;
            $reportLogsArray = [];     
            $countyIdArray = [];
            $isOverTimeArray = [];

            $processReviewStatuses = $this->MenuModel->get_by_form_and_column('review_process', 'review_status');
            $logReviewStatuses = $this->MenuModel->get_by_form_and_column('review_log', 'review_status');
            $reviewStatus = [];
        
            $reviewStatus['review_process_not_pass'] = $this->MenuModel->get_no_resource_by_content('未批准', 'review_process')->no; 
            $reviewStatus['review_process_pass'] = $this->MenuModel->get_no_resource_by_content('批准', 'review_process')->no;
            $reviewStatus['review_process_wait'] = $this->MenuModel->get_no_resource_by_content('等待送出', 'review_process')->no;
       
            if ($countyType == 'all') {
                $counties = $this->CountyModel->get_all();
            } else {
                $counties = $this->CountyModel->get_one($countyType);
            }

            foreach ($counties as $county) {
              $projects = $this->ProjectModel->get_latest_by_county($county['no']);
              array_push($projectArray, $projects);

              $get_inserted_identity_count_data = $this->CounselingIdentityCountReportModel->get_inserted_identity_count_data($yearType, $monthType, $projects->no);
              array_push($get_all_inserted_identity_count_data_array, $get_inserted_identity_count_data);

              $reportProcessesCounty = $get_inserted_identity_count_data ? $this->ReviewProcessModel->get_by_county('counseling_identity_count_report', $get_inserted_identity_count_data->no) : null;
              $reportProcessesCountyStatus = $reportProcessesCounty ? $reportProcessesCounty->review_status : null;
              
              array_push($reportProcessesCountyStatusArray, $reportProcessesCountyStatus);
              
              $reportProcessesYda = $get_inserted_identity_count_data ? $this->ReviewProcessModel->get_by_yda('counseling_identity_count_report', $get_inserted_identity_count_data->no) : null;
              $reportProcessesYdaStatus = $reportProcessesYda ? $reportProcessesYda->review_status : null;
              array_push($reportProcessesYdaStatusArray, $reportProcessesYdaStatus);
              
              $reportLogs = $get_inserted_identity_count_data ? $this->ReviewLogModel->get_by_report_no('counseling_identity_count_report', $get_inserted_identity_count_data->no) : null;
              array_push($reportLogsArray, $reportLogs);

              $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
              $addMonth = ($addMonth > 9) ? $addMonth : '0'.$addMonth;
              $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;
              $overTimeDate = ($addYear + 1911) . '-' . $addMonth . '-05 00:00:00'; 
              $countyId = "";
              $isOverTime = 0;
              if ($reportLogs) {
                  foreach ($reportLogs as $value) {
                      if ($value['user_role'] == 3) {
                          $countyId = $value['user_id'];
                          $isOverTime = ($value['time'] > $overTimeDate) ? ($value['time'] > $overTimeDate) : 0;     
                      }
                  }
              }
              array_push($countyIdArray, $countyId);
              array_push($isOverTimeArray, $isOverTime);
            }

            $beSentDataset = array(
                'title' => '表二.輔導對象身分統計',
                'url' => '/report/counseling_identity_count_report_yda_table/' . $yearType . "/" . $monthType . '/' . $countyType,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'get_all_inserted_identity_count_data' => $get_all_inserted_identity_count_data,
                'counties' => $counties,
                'countyType' => $countyType,
                'county' => $county,
                'security' => $this->security,
                'yearType' => $yearType,
                'monthType' => $monthType,
                'years' => $years,
                'months' => $months,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'get_all_inserted_identity_count_data_array' => $get_all_inserted_identity_count_data_array,
                'reportProcessesCountyStatusArray' => $reportProcessesCountyStatusArray,
                'reportProcessesYdaStatusArray' => $reportProcessesYdaStatusArray,
                'reportLogsArray' => $reportLogsArray,
                'countyIdArray' => $countyIdArray,
                'reviewStatus' => $reviewStatus,
                'processReviewStatuses' => $processReviewStatuses,
                'isOverTimeArray' => $isOverTimeArray,
                'countiesName' => $countiesName
            );

            $reviewStatuses = $this->security->xss_clean($this->input->post('reviewStatus'));
            $comment = $this->security->xss_clean($this->input->post('comment'));

            if (empty($reviewStatuses)) {
                return $this->load->view('report/counseling_identity_count_report_yda_table', $beSentDataset);
            }

            $reportProcessesCountyStatusArray = [];
            $reportProcessesYdaStatusArray = [] ;
            $reportLogsArray = [];     

            if ($monthType % 3 == 0) {
              $reportNameArray = ['high_school_trend_survey_count_report', 'counseling_member_count_report', 'two_years_trend_survey_count_report',
              'one_years_trend_survey_count_report', 'now_years_trend_survey_count_report',
              'old_case_trend_survey_count_report', 'counselor_manpower_report',
              'counseling_identity_count_report', 'counseling_meeting_count_report'];
            } else {
              $reportNameArray = ['counseling_member_count_report', 'counselor_manpower_report',
                'counseling_identity_count_report', 'counseling_meeting_count_report'];
            }       
            

            for ($i = 0; $i < count($counties); $i++) {

                $reportNoArray = [];
                $reportArray = [];

                $counselingMemberCountReport = $this->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                $counselingMemberCountReportNo = $counselingMemberCountReport ? $counselingMemberCountReport->no : 0;  
                array_push($reportArray, $counselingMemberCountReport);           
                array_push($reportNoArray, $counselingMemberCountReportNo);

                if ($monthType % 3 == 0) {
                  $highSchoolTrendSurveyCountReports = $this->HighSchoolTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                  $highSchoolTrendSurveyCountReportNo = $highSchoolTrendSurveyCountReports ? $highSchoolTrendSurveyCountReports->no : 0;
                  array_push($reportArray, $highSchoolTrendSurveyCountReports);
                  array_push($reportNoArray, $highSchoolTrendSurveyCountReportNo);

                    $twoYearsTrendSurveyCountReports = $this->TwoYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $twoYearsTrendSurveyCountReportNo = $twoYearsTrendSurveyCountReports ? $twoYearsTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $twoYearsTrendSurveyCountReports);
                    array_push($reportNoArray, $twoYearsTrendSurveyCountReportNo);
                
                    $oneYearsTrendSurveyCountReports = $this->OneYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $oneYearsTrendSurveyCountReportNo = $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $oneYearsTrendSurveyCountReports);
                    array_push($reportNoArray, $oneYearsTrendSurveyCountReportNo);
                
                    $nowYearsTrendSurveyCountReports = $this->NowYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $nowYearsTrendSurveyCountReportNo = $nowYearsTrendSurveyCountReports ? $nowYearsTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $nowYearsTrendSurveyCountReports);
                    array_push($reportNoArray, $nowYearsTrendSurveyCountReportNo);
                
                    $oldCaseTrendSurveyCountReports = $this->OldCaseTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $oldCaseTrendSurveyCountReportNo = $oldCaseTrendSurveyCountReports ? $oldCaseTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $oldCaseTrendSurveyCountReports);
                    array_push($reportNoArray, $oldCaseTrendSurveyCountReportNo);
                }
                
                $counselorManpowerReports = $this->CounselorManpowerReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                $counselorManpowerReportNo = $counselorManpowerReports ? $counselorManpowerReports->no : 0;
                array_push($reportArray, $counselorManpowerReports);      
                array_push($reportNoArray, $counselorManpowerReportNo);
                
                $get_inserted_identity_count_data = $this->CounselingIdentityCountReportModel->get_inserted_identity_count_data($yearType, $monthType, $projectArray[$i]->no);
                $counselingIdentityCountReportNo = $get_inserted_identity_count_data ? $get_inserted_identity_count_data->no : 0;
                array_push($reportArray, $get_inserted_identity_count_data);      
                array_push($reportNoArray, $counselingIdentityCountReportNo);
                
                $get_inserted_meeting_count_data = $this->CounselingMeetingCountReportModel->get_inserted_meeting_count_data($yearType, $monthType, $projectArray[$i]->no);
                $counselingMeetingCountReportNo = $get_inserted_meeting_count_data ? $get_inserted_meeting_count_data->no : 0;
                array_push($reportArray, $get_inserted_meeting_count_data);      
                array_push($reportNoArray, $counselingMeetingCountReportNo);
                
                if ($reviewStatuses == $reviewStatus['review_process_not_pass']) {

                    $this->ReviewProcessModel->update_one('counseling_identity_count_report', $get_all_inserted_identity_count_data_array[$i]->no, $reviewStatus['review_process_wait'], 3);
                    $this->ReviewProcessModel->update_one('counseling_identity_count_report', $get_all_inserted_identity_count_data_array[$i]->no, $reviewStatus['review_process_not_pass'], 1);

                    $this->ReviewLogModel->create_one('counseling_identity_count_report', $get_all_inserted_identity_count_data_array[$i]->no, $reviewStatus['review_process_not_pass'], $comment, $current_role, $userId);
                    $this->ReviewLogModel->create_one('counseling_identity_count_report', $get_all_inserted_identity_count_data_array[$i]->no, $reviewStatus['review_process_wait'], null, 3, $countyIdArray[$i]);
                
                    $countyContractor = $this->UserModel->get_name_by_id($countyIdArray[$i]);
                    $userName = $this->UserModel->get_name_by_id($userId)->name;
    
                    $recipient = $countyContractor->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】青年署退回' . $yearType . '年' . $monthType .'月 輔導對象身分統計表通知';
                    $content = '<p>' . $countyContractor->name . ' 君 您好:</p>'
                    . '<p>' . $userName . '退回' . $yearType . '年' . $monthType . '月 輔導對象身分統計表</p>'
                    . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';
    
                    //api_send_email_temp($recipient, $title, $content);
                } elseif ($reviewStatuses == $reviewStatus['review_process_pass']) {

                    $this->ReviewProcessModel->update_one('counseling_identity_count_report', $get_all_inserted_identity_count_data_array[$i]->no, $reviewStatus['review_process_pass'], 1);

                    $this->ReviewLogModel->create_one('counseling_identity_count_report', $get_all_inserted_identity_count_data_array[$i]->no, $reviewStatus['review_process_pass'], $comment, $current_role, $userId);

                    $check = 1;
                    $count = 0;
                    $reportProcessesCountyStatusArray = $reportProcessesYdaStatusArray = $reportLogsArray = [];
                    foreach($reportNameArray as $reportName) {
 
                      $reportProcessesYda = $reportArray[$count] ? $this->ReviewProcessModel->get_by_yda($reportName, $reportNoArray[$count]) : null;
                      $reportProcessesYdaStatus = $reportProcessesYda ? $reportProcessesYda->review_status : null;
      
                      array_push($reportProcessesYdaStatusArray, $reportProcessesYdaStatus);

                      if($reportProcessesCountyStatus != $reviewStatus['review_process_pass']) {
                        $check = 0;
                      }

                      $count ++;
                    }
                    $userInfo = $this->UserModel->get_name_by_id($userId);
                    if($check) { // 縣市報表全部已繳交
                      $this->TimingReportModel->create_one($counties[$i]['no'], $userInfo->yda, $monthType, $yearType);
                    }
                }
                $reportProcessesCountyStatus = $get_all_inserted_identity_count_data_array[$i] ? $this->ReviewProcessModel->get_by_county('counseling_identity_count_report', $get_all_inserted_identity_count_data_array[$i]->no)->review_status : null;
                
                array_push($reportProcessesCountyStatusArray, $reportProcessesCountyStatus);
                
                $reportProcessesYdaStatus = $get_all_inserted_identity_count_data_array[$i] ? $this->ReviewProcessModel->get_by_yda('counseling_identity_count_report', $get_all_inserted_identity_count_data_array[$i]->no)->review_status : null;
                array_push($reportProcessesYdaStatusArray, $reportProcessesYdaStatus);
                
                $reportLogs = $get_all_inserted_identity_count_data_array[$i] ? $this->ReviewLogModel->get_by_report_no('counseling_identity_count_report', $get_all_inserted_identity_count_data_array[$i]->no) : null;
                array_push($reportLogsArray, $reportLogs);

                $countyId = "";
                if ($reportLogs) {
                    foreach ($reportLogs as $value) {
                        if ($value['user_role'] == 3) {
                            $countyId = $value['user_id'];
                        }
                    }
                }
                array_push($countyIdArray, $countyId);          
            }

            $beSentDataset['reportProcessesCountyStatusArray'] = $reportProcessesCountyStatusArray;
            $beSentDataset['reportProcessesYdaStatusArray'] = $reportProcessesYdaStatusArray;
            $beSentDataset['reportLogsArray'] = $reportLogsArray;

            $this->load->view('report/counseling_identity_count_report_yda_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function counseling_meeting_count_report($yearType = null, $monthType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $userId = $passport['id'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $county = $passport['county'];
            $organization = $passport['organization'];

            $years = $this->ProjectModel->get_distinct_year_by_county($county);
            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }
            if ($monthType == null) {
                $monthType = date("m");
            }
            $months = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
            $projects = $this->ProjectModel->get_latest_by_county($county);
            $get_inserted_meeting_count_data = $this->CounselingMeetingCountReportModel->get_inserted_meeting_count_data($yearType, $monthType, $projects->no);
            $counties = $this->CountyModel->get_all();
            $meetingTypeNo = [];
            $meetingTypeNo['meetingTypeNoPlanningMeeting'] = $this->MenuModel->get_no_resource_by_content('跨局處會議', 'meeting')->no; //61
            $meetingTypeNo['meetingTypeNoActualMeeting'] = $this->MenuModel->get_no_resource_by_content('預防性講座', 'meeting')->no; //62
            $note_detail = $this->CounselingMeetingCountReportModel->get_note_datail($yearType, $monthType, $organization);

            $meetingTimeDetail = "";
            $planningNoteDetail = "[跨局處會報]" . "\n";
            $actualNoteDetail = "[活動或講座]\n";
            $planingCount = 0;
            $actualCount = 0;
            $sumParticipant = 0;
            
            if (!empty($note_detail)) {
                foreach ($note_detail as $value) {
                    if ($value['meeting_type'] == $meetingTypeNo['meetingTypeNoPlanningMeeting']) {
                        $planingCount++;
                        $meetingTimeDetail = $meetingTimeDetail . $value['start_time'] . "\n";
                        $planningNoteDetail = $planningNoteDetail . $planingCount . '. ' . $value['start_time'] . ' ' . $value['title'] . ' 主席：' . $value['chairman'] . '-' . $value['chairman_background'] . ' 備註 :' . $value['note'] . "\n";
                    }

                    if ($value['meeting_type'] == $meetingTypeNo['meetingTypeNoActualMeeting']) {
                        $actualCount++;
                        $sumParticipant = $sumParticipant + $value['participants'];
                        $actualNoteDetail = $actualNoteDetail . $actualCount . '. ' . $value['start_time'] . ' ' . $value['title'] . ' 人次： ' . $value['participants'] . ' 備註 :' . $value['note'] . "\n";
                    }
                }
            }

            $meetingTimeDetail = strlen($meetingTimeDetail) == 0 ? "尚未辦理" : $meetingTimeDetail;

            $processReviewStatuses = $this->MenuModel->get_by_form_and_column('review_process', 'review_status');
            $logReviewStatuses = $this->MenuModel->get_by_form_and_column('review_log', 'review_status');
            $reviewStatus = [];
       
            $reviewStatus['review_process_not_pass'] = $this->MenuModel->get_no_resource_by_content('未批准', 'review_process')->no;    
            $reviewStatus['review_process_pass'] = $this->MenuModel->get_no_resource_by_content('批准', 'review_process')->no;
            $reviewStatus['review_process_wait'] = $this->MenuModel->get_no_resource_by_content('等待送出', 'review_process')->no;


            $reportProcessesCounselor = $get_inserted_meeting_count_data ? $this->ReviewProcessModel->get_by_counselor('counseling_meeting_count_report', $get_inserted_meeting_count_data->no) : null;
            $reportProcessesCounselorStatus = $reportProcessesCounselor ? $reportProcessesCounselor->review_status : null;
            $reportLogs = $get_inserted_meeting_count_data ? $this->ReviewLogModel->get_by_report_no('counseling_meeting_count_report', $get_inserted_meeting_count_data->no) : null;

            if($monthType != 1) {
              $lastMonthMeetingData = $this->CounselingMeetingCountReportModel->get_inserted_meeting_count_data($yearType, $monthType-1, $projects->no);
            }

            $beSentDataset = array(
                'title' => '表三.跨局處會議/預防性講座場次/人次統計',
                'url' => '/report/counseling_meeting_count_report/' . $yearType . "/" . $monthType,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'counties' => $counties,
                'county' => $county,
                'projects' => $projects,
                'organization' => $organization,
                'security' => $this->security,
                'yearType' => $yearType,
                'monthType' => $monthType,
                'years' => $years,
                'months' => $months,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'meetingTypeNoPlanningMeeting' => $meetingTypeNo['meetingTypeNoPlanningMeeting'],
                'meetingTypeNoActualMeeting' => $meetingTypeNo['meetingTypeNoActualMeeting'],
                'get_inserted_meeting_count_data' => $get_inserted_meeting_count_data,
                'note_detail' => $note_detail,
                'planningNoteDetail' => $planningNoteDetail,
                'actualNoteDetail' => $actualNoteDetail,
                'meetingTimeDetail' => $meetingTimeDetail,
                'sumParticipant' => $sumParticipant,
                'planingCount' => $planingCount,
                'actualCount' => $actualCount,
                'reportProcessesCounselorStatus' => $reportProcessesCounselorStatus,
                'reviewStatus' => $reviewStatus,
                'reportLogs' => $reportLogs,
                'processReviewStatuses' => $processReviewStatuses,
                'lastMonthMeetingData' => $lastMonthMeetingData
            );

            $planning_holding_meeting_count = $this->security->xss_clean($this->input->post('planning_holding_meeting_count'));
            $planning_involved_people = $this->security->xss_clean($this->input->post('planning_involved_people'));
            $meeting_count_note = $this->security->xss_clean($this->input->post('meeting_count_note'));
            $actual_holding_meeting_count = $actualCount;
            $actual_involved_people = $sumParticipant;
            $is_review = 0;
            $date = date("Y-m-d");
            $isExecuteSuccess = "";

            if (!$meeting_count_note) {
                return $this->load->view('report/counseling_meeting_count_report', $beSentDataset);
            }

            if (empty($get_inserted_meeting_count_data)) {
                $isExecuteSuccess = $this->CounselingMeetingCountReportModel->create_one(
                    $meetingTimeDetail,
                    $planning_holding_meeting_count,
                    $actual_holding_meeting_count,
                    $actual_involved_people,
                    $planning_involved_people,
                    $monthType,
                    $yearType,
                    $is_review,
                    $date,
                    $projects->no,
                    $meeting_count_note
                );
                $counselingMeetingCountReportArray = array(
                    $planning_holding_meeting_count,
                    $actual_involved_people,
                    $planning_involved_people,
                    $meeting_count_note
                );
                $counselingMeetingCountReportNum = 0;
                foreach ($counselingMeetingCountReportArray as $value) {

                    if ($value != null || $value == 0) {
                        $counselingMeetingCountReportNum++;
                    }
                }

                $counselingMeetingCountReportRate = round($counselingMeetingCountReportNum / count($counselingMeetingCountReportArray), 2) * 100;
                // print($counselingMeetingCountReportNum . '/' . $counselingMeetingCountReportRate);
                $counselingMeetingCountReportSuccess = $this->CompletionModel->create_one('meeting_count_report', $isExecuteSuccess, $counselingMeetingCountReportRate);
            } else {
             
                $isExecuteSuccess = $this->CounselingMeetingCountReportModel->edit(
                    $meetingTimeDetail,
                    $planning_holding_meeting_count,
                    $actual_holding_meeting_count,
                    $actual_involved_people,
                    $planning_involved_people,
                    $monthType,
                    $yearType,
                    $is_review,
                    $date,
                    $projects->no,
                    $meeting_count_note,
                    $get_inserted_meeting_count_data->no
                );
                $counselingMeetingCountReportArray = array(
                    $planning_holding_meeting_count,
                    $actual_involved_people,
                    $planning_involved_people,
                    $meeting_count_note
                );
                $counselingMeetingCountReportNum = 0;
                foreach ($counselingMeetingCountReportArray as $value) {
                    if ($value != null || $value == 0) {
                        $counselingMeetingCountReportNum++;
                    }
                }

                $counselingMeetingCountReportRate = round($counselingMeetingCountReportNum / count($counselingMeetingCountReportArray), 2) * 100;
                // print($counselingMeetingCountReportNum . '/' . $counselingMeetingCountReportRate);
                $counselingMeetingCountReportSuccess = $this->CompletionModel->update_one('meeting_count_report', $get_inserted_meeting_count_data->no, $counselingMeetingCountReportRate);

            }

            if ($isExecuteSuccess) {
                $get_inserted_meeting_count_data = $this->CounselingMeetingCountReportModel->get_inserted_meeting_count_data($yearType, $monthType, $projects->no);
                $note_detail = $this->CounselingMeetingCountReportModel->get_note_datail($yearType, $monthType, $organization);
                $actual_meeting_date_count = $this->CounselingMeetingCountReportModel->actual_meeting_date($yearType + 1911, $monthType, $organization, $meetingTypeNo['meetingTypeNoPlanningMeeting']);
                $beSentDataset['security'] = $this->security;
                $beSentDataset['get_inserted_meeting_count_data'] = $get_inserted_meeting_count_data;
                $beSentDataset['note_detail'] = $note_detail;
                $beSentDataset['actual_meeting_date_count'] = $actual_meeting_date_count;
                $beSentDataset['success'] = '新增成功';

                if (isset($_POST['save'])) {
                  $reportProcesses = $this->ReviewProcessModel->get_by_report_no('counseling_meeting_count_report', $get_inserted_meeting_count_data->no);
                  if ($reportProcesses) {
                      $this->ReviewProcessModel->update_one('counseling_meeting_count_report', $get_inserted_meeting_count_data->no, $reviewStatus['review_process_pass'], 6);
                      $this->ReviewProcessModel->update_one('counseling_meeting_count_report', $get_inserted_meeting_count_data->no, $reviewStatus['review_process_wait'], 3);
                  } else {
                      $this->ReviewProcessModel->create_one('counseling_meeting_count_report', $get_inserted_meeting_count_data->no, $reviewStatus['review_process_pass'], 6);
                      $this->ReviewProcessModel->create_one('counseling_meeting_count_report', $get_inserted_meeting_count_data->no, $reviewStatus['review_process_wait'], 3);
                      $this->ReviewProcessModel->create_one('counseling_meeting_count_report', $get_inserted_meeting_count_data->no, $reviewStatus['review_process_not_pass'], 1);
                  }
                  $countyContractor = $this->UserModel->get_latest_county_contractor($county);
                  $this->ReviewLogModel->create_one('counseling_meeting_count_report', $get_inserted_meeting_count_data->no, $reviewStatus['review_process_pass'], null, $current_role, $userId);
                  $this->ReviewLogModel->create_one('counseling_meeting_count_report', $get_inserted_meeting_count_data->no, $reviewStatus['review_process_wait'], null, 3, $countyContractor->id);

                  $countyContractor = $this->UserModel->get_by_county_contractor($county);
                  $userName = $this->UserModel->get_name_by_id($userId)->name;

                  $recipient = $countyContractor->email;
                  $title = '【教育部青年發展署雙青計畫行政系統】輔導員繳交' . $yearType . '年' . $monthType . '月 跨局處會議/預防性講座場次/人次統計表通知';
                  $content = '<p>' . $countyContractor->name . ' 君 您好:</p>'
                  . '<p>' . $userName . '繳交' . $yearType . '年' . $monthType . '月 跨局處會議/預防性講座場次/人次統計表</p>'
                  . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
                  . '<p>祝 平安快樂</p><p></p>'
                  . '<p>教育部青年發展署雙青計畫行政系統</p>'
                  . '<p>' . date('Y-m-d') . '</p>'
                      . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                  //api_send_email_temp($recipient, $title, $content);

                  $reportProcessesCounselorStatus = $get_inserted_meeting_count_data ? $this->ReviewProcessModel->get_by_counselor('counseling_meeting_count_report', $get_inserted_meeting_count_data->no)->review_status : null;
                  $reportLogs = $get_inserted_meeting_count_data ? $this->ReviewLogModel->get_by_report_no('counseling_meeting_count_report', $get_inserted_meeting_count_data->no) : null;
                  $beSentDataset['reportProcessesCounselorStatus'] = $reportProcessesCounselorStatus;
                  $beSentDataset['reportLogs'] = $reportLogs;
                }

            } else {
              $beSentDataset['error'] = '新增失敗';
            }

            $this->load->view('report/counseling_meeting_count_report', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function counseling_meeting_count_report_table($yearType = null, $monthType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userId = $passport['id'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(2, 3, 4, 5);
        if (in_array($current_role, $accept_role)) {
            $county = $passport['county'];
            $organization = $passport['organization'];
            if ($current_role == 2 || $current_role == 3) {
                //county以上的使用者 要對應其organization num
                $county_user_organ_num = $this->CounselingMeetingCountReportModel->get_county_user_organization_num($county);
                $organization = $county_user_organ_num->organization;
            }
            $years = $this->ProjectModel->get_distinct_year_by_county($county);
            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }
            if ($monthType == null) {
                $monthType = date("m");
            }
            $months = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
            $projects = $this->ProjectModel->get_latest_by_county($county);
            $get_inserted_meeting_count_data = $this->CounselingMeetingCountReportModel->get_inserted_meeting_count_data($yearType, $monthType, $projects->no);
            $counties = $this->CountyModel->get_all();

            $note_detail = $this->CounselingMeetingCountReportModel->get_note_datail($yearType, $monthType, $organization);
            $meetingTypeNo = [];
            $meetingTypeNo['meetingTypeNoPlanningMeeting'] = $this->MenuModel->get_no_resource_by_content('跨局處會議', 'meeting')->no;
            $meetingTypeNo['meetingTypeNoActualMeeting'] = $this->MenuModel->get_no_resource_by_content('預防性講座', 'meeting')->no;
            $actual_meeting_date_count = $this->CounselingMeetingCountReportModel->actual_meeting_date($yearType + 1911, $monthType, $organization, $meetingTypeNo['meetingTypeNoPlanningMeeting']);
            $actual_holding_meeting_count = $this->CounselingMeetingCountReportModel->actual_holding_meeting_count($yearType + 1911, $monthType, $organization, $meetingTypeNo['meetingTypeNoActualMeeting']);
            
            $processReviewStatuses = $this->MenuModel->get_by_form_and_column('review_process', 'review_status');
            $logReviewStatuses = $this->MenuModel->get_by_form_and_column('review_log', 'review_status');
            $reviewStatus = [];
        
            $reviewStatus['review_process_not_pass'] = $this->MenuModel->get_no_resource_by_content('未批准', 'review_process')->no; 
            $reviewStatus['review_process_pass'] = $this->MenuModel->get_no_resource_by_content('批准', 'review_process')->no;
            $reviewStatus['review_process_wait'] = $this->MenuModel->get_no_resource_by_content('等待送出', 'review_process')->no;
       
            $reportProcessesCounty = $get_inserted_meeting_count_data ? $this->ReviewProcessModel->get_by_county('counseling_meeting_count_report', $get_inserted_meeting_count_data->no) : null;
            $reportProcessesCountyStatus = $reportProcessesCounty ? $reportProcessesCounty->review_status : null;
            $reportProcessesCounselor = $get_inserted_meeting_count_data ? $this->ReviewProcessModel->get_by_counselor('counseling_meeting_count_report', $get_inserted_meeting_count_data->no) : null;
            $reportProcessesCounselorStatus = $reportProcessesCounselor ? $reportProcessesCounselor->review_status : null;
            $reportLogs = $get_inserted_meeting_count_data ? $this->ReviewLogModel->get_by_report_no('counseling_meeting_count_report', $get_inserted_meeting_count_data->no) : null;
            
            $counselorId = "";
            if ($reportLogs) {
              foreach ($reportLogs as $value) {
                  if ($value['user_role'] == 3) {
                      $counselorId = $value['user_id'];
                  }
              }
            }

            $countyName = "";
            foreach ($counties as $value) {
                if ($value['no'] == $county) {
                    $countyName = $value['name'];
                }
            }

            $beSentDataset = array(
                'title' => '表三.跨局處會議/預防性講座場次/人次統計',
                'url' => '/report/counseling_meeting_count_report_table/' . $yearType . "/" . $monthType,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'counties' => $counties,
                'county' => $county,
                'projects' => $projects,
                'organization' => $organization,
                'get_inserted_meeting_count_data' => $get_inserted_meeting_count_data,
                'actual_meeting_date_count' => $actual_meeting_date_count,
                'actual_holding_meeting_count' => $actual_holding_meeting_count,
                'note_detail' => $note_detail,
                'security' => $this->security,
                'yearType' => $yearType,
                'monthType' => $monthType,
                'years' => $years,
                'months' => $months,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'meetingTypeNoPlanningMeeting' => $meetingTypeNo['meetingTypeNoPlanningMeeting'],
                'meetingTypeNoActualMeeting' => $meetingTypeNo['meetingTypeNoActualMeeting'],
                'reportProcessesCountyStatus' => $reportProcessesCountyStatus,
                'reportProcessesCounselorStatus' => $reportProcessesCounselorStatus,
                'reviewStatus' => $reviewStatus,
                'reportLogs' => $reportLogs,
                'processReviewStatuses' => $processReviewStatuses
            );

            $reviewStatuses = $this->security->xss_clean($this->input->post('reviewStatus'));
            $comment = $this->security->xss_clean($this->input->post('comment'));
            $reportFile = $get_inserted_meeting_count_data ? $get_inserted_meeting_count_data->report_file : null;

            if (isset($_POST['resubmit'])) {
              $config['upload_path'] = './files/';
              $config['allowed_types'] = 'jpg|png|pdf';
              $config['max_size'] = 5000;
              $config['max_width'] = 5000;
              $config['max_height'] = 5000;
              $config['encrypt_name'] = true;
              $this->load->library('upload', $config);
              // upload family diagram
              if ($this->upload->do_upload('reportFile')) {
                $fileMetaData = $this->upload->data();
                $reportFile = $this->FileModel->create_one($get_inserted_meeting_count_data->no, $fileMetaData['file_name'], $fileMetaData['orig_name']);
              }

              $isUpdateReportFile = $this->CounselingMeetingCountReportModel->update_file_by_no($get_inserted_meeting_count_data->no, $reportFile);
              if ($isUpdateReportFile) {
                $get_inserted_meeting_count_data = $this->CounselingMeetingCountReportModel->get_inserted_meeting_count_data($yearType, $monthType, $projects->no);
                $beSentDataset['get_inserted_meeting_count_data'] = $get_inserted_meeting_count_data;
                return $this->load->view('report/counseling_meeting_count_report_table', $beSentDataset);
              }
            }

            if (empty($reviewStatuses)) {
                return $this->load->view('report/counseling_meeting_count_report_table', $beSentDataset);
            }

            if ($monthType % 3 == 0) {
              $reportNameArray = ['high_school_trend_survey_count_report', 'counseling_member_count_report', 'two_years_trend_survey_count_report',
                  'one_years_trend_survey_count_report', 'now_years_trend_survey_count_report',
                  'old_case_trend_survey_count_report', 'counselor_manpower_report',
                  'counseling_identity_count_report', 'counseling_meeting_count_report'];
            } else {
                $reportNameArray = ['counseling_member_count_report', 'counselor_manpower_report',
                  'counseling_identity_count_report', 'counseling_meeting_count_report'];
            }

            $reportNoArray = [];
            $reportArray = [];

            $counselingMemberCountReport = $this->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $county);
            $counselingMemberCountReportNo = $counselingMemberCountReport ? $counselingMemberCountReport->no : 0;  
            array_push($reportArray, $counselingMemberCountReport);           
            array_push($reportNoArray, $counselingMemberCountReportNo);

            if ($monthType % 3 == 0) {
              $highSchoolTrendSurveyCountReports = $this->HighSchoolTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
              $highSchoolTrendSurveyCountReportNo = $highSchoolTrendSurveyCountReports ? $highSchoolTrendSurveyCountReports->no : 0;
              array_push($reportArray, $highSchoolTrendSurveyCountReports);
              array_push($reportNoArray, $highSchoolTrendSurveyCountReportNo);

                $twoYearsTrendSurveyCountReports = $this->TwoYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $twoYearsTrendSurveyCountReportNo = $twoYearsTrendSurveyCountReports ? $twoYearsTrendSurveyCountReports->no : 0;
                array_push($reportArray, $twoYearsTrendSurveyCountReports);
                array_push($reportNoArray, $twoYearsTrendSurveyCountReportNo);
            
                $oneYearsTrendSurveyCountReports = $this->OneYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $oneYearsTrendSurveyCountReportNo = $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->no : 0;
                array_push($reportArray, $oneYearsTrendSurveyCountReports);
                array_push($reportNoArray, $oneYearsTrendSurveyCountReportNo);
            
                $nowYearsTrendSurveyCountReports = $this->NowYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $nowYearsTrendSurveyCountReportNo = $nowYearsTrendSurveyCountReports ? $nowYearsTrendSurveyCountReports->no : 0;
                array_push($reportArray, $nowYearsTrendSurveyCountReports);
                array_push($reportNoArray, $nowYearsTrendSurveyCountReportNo);
            
                $oldCaseTrendSurveyCountReports = $this->OldCaseTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county);
                $oldCaseTrendSurveyCountReportNo = $oldCaseTrendSurveyCountReports ? $oldCaseTrendSurveyCountReports->no : 0;
                array_push($reportArray, $oldCaseTrendSurveyCountReports);
                array_push($reportNoArray, $oldCaseTrendSurveyCountReportNo);
            }
            
            $counselorManpowerReports = $this->CounselorManpowerReportModel->get_by_no($yearType, $monthType, $county);
            $counselorManpowerReportNo = $counselorManpowerReports ? $counselorManpowerReports->no : 0;
            array_push($reportArray, $counselorManpowerReports);      
            array_push($reportNoArray, $counselorManpowerReportNo);
            
            $get_inserted_identity_count_data = $this->CounselingIdentityCountReportModel->get_inserted_identity_count_data($yearType, $monthType, $projects->no);
            $counselingIdentityCountReportNo = $get_inserted_identity_count_data ? $get_inserted_identity_count_data->no : 0;
            array_push($reportArray, $get_inserted_identity_count_data);      
            array_push($reportNoArray, $counselingIdentityCountReportNo);
            
            $get_inserted_meeting_count_data = $this->CounselingMeetingCountReportModel->get_inserted_meeting_count_data($yearType, $monthType, $projects->no);
            $counselingMeetingCountReportNo = $get_inserted_meeting_count_data ? $get_inserted_meeting_count_data->no : 0;
            array_push($reportArray, $get_inserted_meeting_count_data);      
            array_push($reportNoArray, $counselingMeetingCountReportNo);

            // file format define
            // 檔案內容大小限制5000KB,並支援JPG,PNG,PDF
            $config['upload_path'] = './files/';
            $config['allowed_types'] = 'jpg|png|pdf';
            $config['max_size'] = 5000;
            $config['max_width'] = 5000;
            $config['max_height'] = 5000;
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);
            // upload family diagram
            if ($this->upload->do_upload('reportFile')) {
                $fileMetaData = $this->upload->data();
                $reportFile = $this->FileModel->create_one($get_inserted_meeting_count_data->no, $fileMetaData['file_name'], $fileMetaData['orig_name']);
            }

            $isUpdateReportFile = $this->CounselingMeetingCountReportModel->update_file_by_no($get_inserted_meeting_count_data->no, $reportFile);
            if ($isUpdateReportFile) {
                if ($reviewStatuses == $reviewStatus['review_process_not_pass']) {
                    $this->ReviewProcessModel->update_one('counseling_meeting_count_report', $get_inserted_meeting_count_data->no, $reviewStatus['review_process_wait'], 6);
                    $this->ReviewProcessModel->update_one('counseling_meeting_count_report', $get_inserted_meeting_count_data->no, $reviewStatus['review_process_not_pass'], 3);

                    $this->ReviewLogModel->create_one('counseling_meeting_count_report', $get_inserted_meeting_count_data->no, $reviewStatus['review_process_not_pass'], $comment, $current_role, $userId);
                    $this->ReviewLogModel->create_one('counseling_meeting_count_report', $get_inserted_meeting_count_data->no, $reviewStatus['review_process_wait'], null, 6, $counselorId);
            
                    $counselorInfo = $this->UserModel->get_name_by_id($counselorId);
                    $userName = $this->UserModel->get_name_by_id($userId)->name;

                    $recipient = $counselorInfo->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】縣市承辦人退回' . $yearType . '年' . $monthType .'月 跨局處會議/預防性講座場次/人次統計表通知';
                    $content = '<p>' . $counselorInfo->name . ' 君 您好:</p>'
                . '<p>' . $userName . '退回' . $yearType . '年' . $monthType . '月 跨局處會議/預防性講座場次/人次統計表</p>'
                . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
                . '<p>祝 平安快樂</p><p></p>'
                . '<p>教育部青年發展署雙青計畫行政系統</p>'
                . '<p>' . date('Y-m-d') . '</p>'
                    . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipient, $title, $content);
                } elseif ($reviewStatuses == $reviewStatus['review_process_pass']) {
                    $ydaContractor = 'yda';
                    $this->ReviewProcessModel->update_one('counseling_meeting_count_report', $get_inserted_meeting_count_data->no, $reviewStatus['review_process_wait'], 1);
                    $this->ReviewProcessModel->update_one('counseling_meeting_count_report', $get_inserted_meeting_count_data->no, $reviewStatus['review_process_pass'], 3);

                    $this->ReviewLogModel->create_one('counseling_meeting_count_report', $get_inserted_meeting_count_data->no, $reviewStatus['review_process_pass'], $comment, $current_role, $userId);
                    $this->ReviewLogModel->create_one('counseling_meeting_count_report', $get_inserted_meeting_count_data->no, $reviewStatus['review_process_wait'], null, 1, $ydaContractor);
            
                    $check = 1;
                    $count = 0;
                    $reportProcessesCountyStatusArray = $reportProcessesYdaStatusArray = $reportLogsArray = [];
                    foreach ($reportNameArray as $reportName) {
                        $reportProcessesCounty = $reportArray[$count] ? $this->ReviewProcessModel->get_by_county($reportName, $reportNoArray[$count]) : null;
                        $reportProcessesCountyStatus = $reportProcessesCounty ? $reportProcessesCounty->review_status : null;

                        if ($reportProcessesCountyStatus != $reviewStatus['review_process_pass']) {
                            $check = 0;
                        }
                        array_push($reportProcessesCountyStatusArray, $reportProcessesCountyStatus);
                        $count++;
                    }

                    if ($check) { // 縣市報表全部已繳交
                        $this->TimingReportModel->create_one($county, null, $monthType, $yearType);
                    }
              
                    $ydaInfo = $this->UserModel->get_by_yda_row();
                    $userName = $this->UserModel->get_name_by_id($userId)->name;

                    $recipient = $ydaInfo->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】' . $countyName . '承辦人繳交' . $yearType . '年' . $monthType .'月 跨局處會議/預防性講座場次/人次統計表通知';
                    $content = '<p>' . $ydaInfo->name . ' 君 您好:</p>'
              . '<p>' . $countyName . '承辦人繳交' . $yearType . '年' . $monthType . '月 跨局處會議/預防性講座場次/人次統計表</p>'
              . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
              . '<p>祝 平安快樂</p><p></p>'
              . '<p>教育部青年發展署雙青計畫行政系統</p>'
              . '<p>' . date('Y-m-d') . '</p>'
                  . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipient, $title, $content);
                }

                $reportProcessesCountyStatus = $get_inserted_meeting_count_data ? $this->ReviewProcessModel->get_by_county('counseling_meeting_count_report', $get_inserted_meeting_count_data->no)->review_status : null;
                $reportProcessesCounselorStatus = $get_inserted_meeting_count_data ? $this->ReviewProcessModel->get_by_counselor('counseling_meeting_count_report', $get_inserted_meeting_count_data->no)->review_status : null;
                $reportLogs = $get_inserted_meeting_count_data ? $this->ReviewLogModel->get_by_report_no('counseling_meeting_count_report', $get_inserted_meeting_count_data->no) : null;
                $beSentDataset['reportProcessesCountyStatus'] = $reportProcessesCountyStatus;
                $beSentDataset['reportProcessesCounselorStatus'] = $reportProcessesCounselorStatus;
                $beSentDataset['reportLogs'] = $reportLogs;
            } else {
              $beSentDataset['error'] = '新增失敗';
            }

            $this->load->view('report/counseling_meeting_count_report_table', $beSentDataset);
        } else {
          redirect('user/login');
        }
    }

    public function counseling_meeting_count_report_yda_table($yearType = null, $monthType = null, $countyType = 'all')
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $userId = $passport['id'];
        $accept_role = array(1, 8, 9);
        if (in_array($current_role, $accept_role)) {
            $county = $countyType ? $countyType : '1';
            $organization = $passport['organization'] ? $passport['organization'] : 'all';
            $organ_num = $this->CounselingMeetingCountReportModel->get_organization_num();
            $years = $this->ProjectModel->get_distinct_year_by_county('1');
            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }
            if ($monthType == null) {
                $monthType = date("m");
            }
            $months = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
            $countiesName = $this->CountyModel->get_all();
            $projects = $this->ProjectModel->get_all_by_county_no('all'); //county對應的project no
            $get_all_inserted_meeting_count_data = $this->CounselingMeetingCountReportModel->get_by_all($yearType, $monthType, $county);
            if ($countyType == 'all') {
              $counties = $this->CountyModel->get_all();
            } else {
                $counties = $this->CountyModel->get_one($countyType);
            }

            $note_detail = $this->CounselingMeetingCountReportModel->get_note_datail($yearType, $monthType, $organization);
            $meetingTypeNo = [];
            $meetingTypeNo['meetingTypeNoPlanningMeeting'] = $this->MenuModel->get_no_resource_by_content('跨局處會議', 'meeting')->no;
            $meetingTypeNo['meetingTypeNoActualMeeting'] = $this->MenuModel->get_no_resource_by_content('預防性講座', 'meeting')->no;
            $countyExecuteType = $this->MenuModel->get_no_resource_by_content('委辦', 'project')->no;
            $actual_meeting_date_count = $this->CounselingMeetingCountReportModel->actual_meeting_date($yearType + 1911, $monthType, $organization, $meetingTypeNo['meetingTypeNoPlanningMeeting']);
            $actual_holding_meeting_count = $this->CounselingMeetingCountReportModel->actual_holding_meeting_count($yearType + 1911, $monthType, $organization, $meetingTypeNo['meetingTypeNoActualMeeting']);

            $sumDetail = [];
            $sumDetail['commission_meeting_count'] = 0;
            $sumDetail['commission_planning_holding_meeting_count'] = 0;
            $sumDetail['commission_actual_holding_meeting_count'] = 0;
            $sumDetail['commission_planning_involved_people'] = 0;
            $sumDetail['commission_actual_involved_people'] = 0;

            $sumDetail['self_meeting_count'] = 0;
            $sumDetail['self_planning_holding_meeting_count'] = 0;
            $sumDetail['self_actual_holding_meeting_count'] = 0;
            $sumDetail['self_planning_involved_people'] = 0;
            $sumDetail['self_actual_involved_people'] = 0;

            $tempSum = $planningHoldingSum = $actualHoldingSum = $planningInvolvedSum = $actualInvolvedSum = 0;

            foreach ($projects as $value) {
                $tempSum += $value['meeting_count'];
                if ($countyExecuteType == $value['execute_way']) {
                    $sumDetail['commission_meeting_count'] += $value['meeting_count'];
                } else {
                    $sumDetail['self_meeting_count'] += $value['meeting_count'];
                }
            }

            $sumDetail['meetingCountSum'] = $tempSum;
            $tempSum = 0;

            foreach ($get_all_inserted_meeting_count_data as $value) {

                foreach ($projects as $pro) {
                    if ($value['project'] == $pro['no']) {
                        if ($countyExecuteType == $pro['execute_way']) {
                            $sumDetail['commission_planning_holding_meeting_count'] += $value['planning_holding_meeting_count'];
                            $sumDetail['commission_actual_holding_meeting_count'] += $value['actual_holding_meeting_count'];
                            $sumDetail['commission_planning_involved_people'] += $value['planning_involved_people'];
                            $sumDetail['commission_actual_involved_people'] += $value['actual_involved_people'];
                        } else {
                            $sumDetail['self_planning_holding_meeting_count'] += $value['planning_holding_meeting_count'];
                            $sumDetail['self_actual_holding_meeting_count'] += $value['actual_holding_meeting_count'];
                            $sumDetail['self_planning_involved_people'] += $value['planning_involved_people'];
                            $sumDetail['self_actual_involved_people'] += $value['actual_involved_people'];
                        }
                    }
                }
                $planningHoldingSum += $value['planning_holding_meeting_count'];
                $actualHoldingSum += $value['actual_holding_meeting_count'];
                $planningInvolvedSum += $value['planning_involved_people'];
                $actualInvolvedSum += $value['actual_involved_people'];
            }

            $sumDetail['planningHoldingSum'] = $planningHoldingSum;
            $sumDetail['actualHoldingSum'] = $actualHoldingSum;
            $sumDetail['planningInvolvedSum'] = $planningInvolvedSum;
            $sumDetail['actualInvolvedSum'] = $actualInvolvedSum;

            $projectArray = [];
            $get_all_inserted_meeting_count_data_array = [];
            $reportProcessesCountyStatusArray = [];
            $reportProcessesYdaStatusArray = [] ;
            $reportLogsArray = [];     
            $countyIdArray = [];
            $isOverTimeArray = [];

            $processReviewStatuses = $this->MenuModel->get_by_form_and_column('review_process', 'review_status');
            $logReviewStatuses = $this->MenuModel->get_by_form_and_column('review_log', 'review_status');
            $reviewStatus = [];
        
            $reviewStatus['review_process_not_pass'] = $this->MenuModel->get_no_resource_by_content('未批准', 'review_process')->no; 
            $reviewStatus['review_process_pass'] = $this->MenuModel->get_no_resource_by_content('批准', 'review_process')->no;
            $reviewStatus['review_process_wait'] = $this->MenuModel->get_no_resource_by_content('等待送出', 'review_process')->no;
       

            foreach ($counties as $county) {
              $projects = $this->ProjectModel->get_latest_by_county($county['no']);
              array_push($projectArray, $projects);
            
              $get_inserted_meeting_count_data = $this->CounselingMeetingCountReportModel->get_inserted_meeting_count_data($yearType, $monthType, $projects->no);
              array_push($get_all_inserted_meeting_count_data_array, $get_inserted_meeting_count_data);

              $reportProcessesCounty = $get_inserted_meeting_count_data ? $this->ReviewProcessModel->get_by_county('counseling_meeting_count_report', $get_inserted_meeting_count_data->no) : null;
              $reportProcessesCountyStatus = $reportProcessesCounty ? $reportProcessesCounty->review_status : null;
              
              array_push($reportProcessesCountyStatusArray, $reportProcessesCountyStatus);
              
              $reportProcessesYda = $get_inserted_meeting_count_data ? $this->ReviewProcessModel->get_by_yda('counseling_meeting_count_report', $get_inserted_meeting_count_data->no) : null;
              $reportProcessesYdaStatus = $reportProcessesYda ? $reportProcessesYda->review_status : null;
              array_push($reportProcessesYdaStatusArray, $reportProcessesYdaStatus);
              
              $reportLogs = $get_inserted_meeting_count_data ? $this->ReviewLogModel->get_by_report_no('counseling_meeting_count_report', $get_inserted_meeting_count_data->no) : null;
              array_push($reportLogsArray, $reportLogs);

              $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
              $addMonth = ($addMonth > 9) ? $addMonth : '0'.$addMonth;
              $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;
              $overTimeDate = ($addYear + 1911) . '-' . $addMonth . '-05 00:00:00'; 
              $countyId = "";
              $isOverTime = 0;
              if ($reportLogs) {
                  foreach ($reportLogs as $value) {
                      if ($value['user_role'] == 3) {
                          $countyId = $value['user_id'];
                          $isOverTime = ($value['time'] > $overTimeDate) ? ($value['time'] > $overTimeDate) : 0;      
                      }
                  }
                  
              }
              array_push($countyIdArray, $countyId);
              array_push($isOverTimeArray, $isOverTime);
            }

            $beSentDataset = array(
                'title' => '表三.跨局處會議/預防性講座場次/人次統計',
                'url' => '/report/counseling_meeting_count_report_yda_table/' . $yearType . "/" . $monthType . '/' . $countyType,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'counties' => $counties,
                'county' => $county,
                'countyType' => $countyType,
                'projects' => $projects,
                'organization' => $organization,
                'get_all_inserted_meeting_count_data' => $get_all_inserted_meeting_count_data,
                'actual_meeting_date_count' => $actual_meeting_date_count,
                'actual_holding_meeting_count' => $actual_holding_meeting_count,
                'note_detail' => $note_detail,
                'organ_num' => $organ_num,
                'security' => $this->security,
                'yearType' => $yearType,
                'monthType' => $monthType,
                'years' => $years,
                'months' => $months,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'meetingTypeNoPlanningMeeting' => $meetingTypeNo['meetingTypeNoPlanningMeeting'],
                'meetingTypeNoActualMeeting' => $meetingTypeNo['meetingTypeNoActualMeeting'],
                'sumDetail' => $sumDetail,
                'get_all_inserted_meeting_count_data_array' => $get_all_inserted_meeting_count_data_array,
                'reportProcessesCountyStatusArray' => $reportProcessesCountyStatusArray,
                'reportProcessesYdaStatusArray' => $reportProcessesYdaStatusArray,
                'reportLogsArray' => $reportLogsArray,
                'countyIdArray' => $countyIdArray,
                'reviewStatus' => $reviewStatus,
                'processReviewStatuses' => $processReviewStatuses,
                'projectArray' => $projectArray,
                'isOverTimeArray' => $isOverTimeArray,
                'countiesName' => $countiesName
            );

            $reviewStatuses = $this->security->xss_clean($this->input->post('reviewStatus'));
            $comment = $this->security->xss_clean($this->input->post('comment'));

            if (empty($reviewStatuses)) {
                return $this->load->view('report/counseling_meeting_count_report_yda_table', $beSentDataset);
            }

            $reportProcessesCountyStatusArray = [];
            $reportProcessesYdaStatusArray = [] ;
            $reportLogsArray = [];     

            if ($monthType % 3 == 0) {
              $reportNameArray = ['high_school_trend_survey_count_report', 'counseling_member_count_report', 'two_years_trend_survey_count_report',
              'one_years_trend_survey_count_report', 'now_years_trend_survey_count_report',
              'old_case_trend_survey_count_report', 'counselor_manpower_report',
              'counseling_identity_count_report', 'counseling_meeting_count_report'];
            } else {
              $reportNameArray = ['counseling_member_count_report', 'counselor_manpower_report',
                'counseling_identity_count_report', 'counseling_meeting_count_report'];
            }    
            

            for ($i = 0; $i < count($counties); $i++) {
                $reportNoArray = [];
                $reportArray = [];

                $counselingMemberCountReport = $this->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                $counselingMemberCountReportNo = $counselingMemberCountReport ? $counselingMemberCountReport->no : 0;  
                array_push($reportArray, $counselingMemberCountReport);           
                array_push($reportNoArray, $counselingMemberCountReportNo);

                if ($monthType % 3 == 0) {
                  $highSchoolTrendSurveyCountReports = $this->HighSchoolTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                  $highSchoolTrendSurveyCountReportNo = $highSchoolTrendSurveyCountReports ? $highSchoolTrendSurveyCountReports->no : 0;
                  array_push($reportArray, $highSchoolTrendSurveyCountReports);
                  array_push($reportNoArray, $highSchoolTrendSurveyCountReportNo);
                  
                    $twoYearsTrendSurveyCountReports = $this->TwoYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $twoYearsTrendSurveyCountReportNo = $twoYearsTrendSurveyCountReports ? $twoYearsTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $twoYearsTrendSurveyCountReports);
                    array_push($reportNoArray, $twoYearsTrendSurveyCountReportNo);
                
                    $oneYearsTrendSurveyCountReports = $this->OneYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $oneYearsTrendSurveyCountReportNo = $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $oneYearsTrendSurveyCountReports);
                    array_push($reportNoArray, $oneYearsTrendSurveyCountReportNo);
                
                    $nowYearsTrendSurveyCountReports = $this->NowYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $nowYearsTrendSurveyCountReportNo = $nowYearsTrendSurveyCountReports ? $nowYearsTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $nowYearsTrendSurveyCountReports);
                    array_push($reportNoArray, $nowYearsTrendSurveyCountReportNo);
                
                    $oldCaseTrendSurveyCountReports = $this->OldCaseTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                    $oldCaseTrendSurveyCountReportNo = $oldCaseTrendSurveyCountReports ? $oldCaseTrendSurveyCountReports->no : 0;
                    array_push($reportArray, $oldCaseTrendSurveyCountReports);
                    array_push($reportNoArray, $oldCaseTrendSurveyCountReportNo);
                }
                
                $counselorManpowerReports = $this->CounselorManpowerReportModel->get_by_no($yearType, $monthType, $counties[$i]['no']);
                $counselorManpowerReportNo = $counselorManpowerReports ? $counselorManpowerReports->no : 0;
                array_push($reportArray, $counselorManpowerReports);      
                array_push($reportNoArray, $counselorManpowerReportNo);
                
                $get_inserted_identity_count_data = $this->CounselingIdentityCountReportModel->get_inserted_identity_count_data($yearType, $monthType, $projectArray[$i]->no);
                $counselingIdentityCountReportNo = $get_inserted_identity_count_data ? $get_inserted_identity_count_data->no : 0;
                array_push($reportArray, $get_inserted_identity_count_data);      
                array_push($reportNoArray, $counselingIdentityCountReportNo);
                
                $get_inserted_meeting_count_data = $this->CounselingMeetingCountReportModel->get_inserted_meeting_count_data($yearType, $monthType, $projectArray[$i]->no);
                $counselingMeetingCountReportNo = $get_inserted_meeting_count_data ? $get_inserted_meeting_count_data->no : 0;
                array_push($reportArray, $get_inserted_meeting_count_data);      
                array_push($reportNoArray, $counselingMeetingCountReportNo);
                
                if ($reviewStatuses == $reviewStatus['review_process_not_pass']) {

                    $this->ReviewProcessModel->update_one('counseling_meeting_count_report', $get_all_inserted_meeting_count_data_array[$i]->no, $reviewStatus['review_process_wait'], 3);
                    $this->ReviewProcessModel->update_one('counseling_meeting_count_report', $get_all_inserted_meeting_count_data_array[$i]->no, $reviewStatus['review_process_not_pass'], 1);

                    $this->ReviewLogModel->create_one('counseling_meeting_count_report', $get_all_inserted_meeting_count_data_array[$i]->no, $reviewStatus['review_process_not_pass'], $comment, $current_role, $userId);
                    $this->ReviewLogModel->create_one('counseling_meeting_count_report', $get_all_inserted_meeting_count_data_array[$i]->no, $reviewStatus['review_process_wait'], null, 3, $countyIdArray[$i]);
                
                    $countyContractor = $this->UserModel->get_name_by_id($countyIdArray[$i]);
                    $userName = $this->UserModel->get_name_by_id($userId)->name;
    
                    $recipient = $countyContractor->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】青年署退回' . $yearType . '年' . $monthType .'月 跨局處會議/預防性講座場次/人次統計表通知';
                    $content = '<p>' . $countyContractor->name . ' 君 您好:</p>'
                    . '<p>' . $userName . '退回' . $yearType . '年' . $monthType . '月 跨局處會議/預防性講座場次/人次統計表</p>'
                    . '<p>該報表需要您的批准，請撥空前往查看。</p><p></p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';
    
                    //api_send_email_temp($recipient, $title, $content);
                } elseif ($reviewStatuses == $reviewStatus['review_process_pass']) {

                    $this->ReviewProcessModel->update_one('counseling_meeting_count_report', $get_all_inserted_meeting_count_data_array[$i]->no, $reviewStatus['review_process_pass'], 1);

                    $this->ReviewLogModel->create_one('counseling_meeting_count_report', $get_all_inserted_meeting_count_data_array[$i]->no, $reviewStatus['review_process_pass'], $comment, $current_role, $userId);

                    $check = 1;
                    $count = 0;
                    $reportProcessesCountyStatusArray = $reportProcessesYdaStatusArray = $reportLogsArray = [];
                    foreach($reportNameArray as $reportName) {
 
                      $reportProcessesYda = $reportArray[$count] ? $this->ReviewProcessModel->get_by_yda($reportName, $reportNoArray[$count]) : null;
                      $reportProcessesYdaStatus = $reportProcessesYda ? $reportProcessesYda->review_status : null;
      
                      array_push($reportProcessesYdaStatusArray, $reportProcessesYdaStatus);

                      if($reportProcessesCountyStatus != $reviewStatus['review_process_pass']) {
                        $check = 0;
                      }

                      $count ++;
                    }
                    $userInfo = $this->UserModel->get_name_by_id($userId);
                    if($check) { // 縣市報表全部已繳交
                      $this->TimingReportModel->create_one($counties[$i]['no'], $userInfo->yda, $monthType, $yearType);
                    }
                }
                $reportProcessesCountyStatus = $get_all_inserted_meeting_count_data_array[$i] ? $this->ReviewProcessModel->get_by_county('counseling_meeting_count_report', $get_all_inserted_meeting_count_data_array[$i]->no)->review_status : null;
                
                array_push($reportProcessesCountyStatusArray, $reportProcessesCountyStatus);
                
                $reportProcessesYdaStatus = $get_all_inserted_meeting_count_data_array[$i] ? $this->ReviewProcessModel->get_by_yda('counseling_meeting_count_report', $get_all_inserted_meeting_count_data_array[$i]->no)->review_status : null;
                array_push($reportProcessesYdaStatusArray, $reportProcessesYdaStatus);
                
                $reportLogs = $get_all_inserted_meeting_count_data_array[$i] ? $this->ReviewLogModel->get_by_report_no('counseling_meeting_count_report', $get_all_inserted_meeting_count_data_array[$i]->no) : null;
                array_push($reportLogsArray, $reportLogs);

                $countyId = "";
                if ($reportLogs) {
                    foreach ($reportLogs as $value) {
                        if ($value['user_role'] == 3) {
                            $countyId = $value['user_id'];
                        }
                    }
                }
                array_push($countyIdArray, $countyId);          
            }

            $beSentDataset['reportProcessesCountyStatusArray'] = $reportProcessesCountyStatusArray;
            $beSentDataset['reportProcessesYdaStatusArray'] = $reportProcessesYdaStatusArray;
            $beSentDataset['reportLogsArray'] = $reportLogsArray;

            $this->load->view('report/counseling_meeting_count_report_yda_table', $beSentDataset);
        }
    }

    public function yda_month_report_table($reportType = 'counselingMemberCountReport', $yearType = null, $monthType = null, $countyType = 'all') 
    {
      $passport = $this->session->userdata('passport');
      $current_role = $passport['role'];
      $userTitle = $passport['userTitle'];
      $userId = $passport['id'];
      $accept_role = array(1, 8, 9);
      if (in_array($current_role, $accept_role)) {
        $years = $this->ProjectModel->get_distinct_year_by_county("1");
        if ($yearType == null) {
            $yearType = date("Y") - 1911;
        }
        if ($monthType == null) {
            $monthType = date("m");
        }
        $months = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
        $countiesName = $this->CountyModel->get_all();
        $executeModes = $this->MenuModel->get_by_form_and_column('project', 'execute_mode');
        $executeWays = $this->MenuModel->get_by_form_and_column('project', 'execute_way');

        if($reportType == 'counselingMemberCountReport') {
          $qualifications = $this->MenuModel->get_by_form_and_column('counselor', 'qualification');
          $projectArray = [];
          $projectDetailArray = [];
          $accumCounselingMemberCountArray = [];
          $monthMemberTempCounselingArray = [];
          $executeDetailArray = [];
          $counselingMemberCountReportArray = [];

          if ($countyType == 'all') $counties = $this->CountyModel->get_all();
          else $counties = $this->CountyModel->get_one($countyType);
          
          foreach ($counties as $county) {
            $projects = $this->ProjectModel->get_latest_by_county($county['no']);
            array_push($projectArray, $projects);

            $countyAndOrg = $this->CountyModel->get_by_county($county['no']);
            $counselingMemberCountReport = $this->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $county['no']);
            array_push($counselingMemberCountReportArray, $counselingMemberCountReport);

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

            $projectDetail = "";
            $projectDetail = $projectDetail . $executeMode . " <br/>";
            // $projectDetail = $projectDetail . $executeWay . " <br/>";
            $projectDetail = $projectDetail . $projects->counselor_count . "位專任輔導員、" . "跨局處會議" . $projects->meeting_count . "次、"
              . "生涯探索課程或活動" . $projects->course_hour . "小時、輔導會談" . $projects->counseling_member . "人x" . $projects->counseling_hour
              . "小時 = " . ($projects->counseling_member * $projects->counseling_hour) . "小時、工作體驗" . $projects->working_member . "人x" . $projects->working_hour
              . "小時 = " . ($projects->working_member * $projects->working_hour) . "小時、後續關懷追蹤六個月<br/>";
            $projectDetail = $projectDetail . "承辦單位 : " . $countyAndOrg->orgnizer . "<br/>";
            $projectDetail = $projectDetail . "執行單位 : " . $countyAndOrg->organizationName . "<br/>";

            array_push($projectDetailArray, $projectDetail);

            $accumCounselingMemberCount = $this->MemberModel->get_by_county_count($county['no'], $monthType, $yearType);
            array_push($accumCounselingMemberCountArray, $accumCounselingMemberCount);

            $monthMemberTempNote = $this->MonthMemberTempCounselingModel->get_by_county_and_month($county['no'], $monthType, $yearType);
            $twoYearSurvryCaseCount = empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->two_year_survry_case_member;
            $oneYearSurvryCaseCount = empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->one_year_survry_case_member;
            $nowYearSurvryCaseCount = empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->now_year_survry_case_member;
            $nextYearSurvryCaseCount = empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->next_year_survry_case_member;
            $highSchoolSurveryCaseCount = empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->high_school_survry_case_member;

            $forceMajeureNote = empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->force_majeure_note;
            $workTrainningNote = empty($counselingMemberCountReport) ? 0 : $counselingMemberCountReport->work_trainning_note;

            $counselorInfo = $this->UserModel->get_counselor_detail_by_county($county['no'], $yearType, $monthType);
            $counselorDetail = "";
            $counselorDetailArray = [];

            $executeDetail = "";
            if (!empty($counselingMemberCountReport)) {
              $executeDetail = $executeDetail . "一、 輔導員<br/>";
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
                array_push($counselorDetailArray, $counselorDetail);

                $executeDetail = $executeDetail . $memberCount . '. ' . $value['userName'] . '於' . $value['duty_date'] . '到職，' . $counselorDetail . "<br/>";

                $counselorDetail = "";
              }

              $executeDetail = $executeDetail . "二、 本年度輔導對象來源<br/>";
              $executeDetail = $executeDetail . "1. 本年度新開案個案人數：" . $counselingMemberCountReport->new_case_member . "<br/>";
              $executeDetail = $executeDetail . "2. 前一年度持續輔導人數：" . $counselingMemberCountReport->old_case_member . "<br/>";
              $executeDetail = $executeDetail . "3. " . ($yearType - 4) . "學年度動向調查結果輔導人數：" . $twoYearSurvryCaseCount . "<br/>";
              $executeDetail = $executeDetail . "4. " . ($yearType - 3) . "學年度動向調查結果輔導人數：" . $oneYearSurvryCaseCount . "<br/>";
              $executeDetail = $executeDetail . "5. " . ($yearType - 2) . "學年度動向調查結果輔導人數：" . $nowYearSurvryCaseCount . "<br/>";
              //$executeDetail = $executeDetail . "4. " . ($yearType - 1) . "學年度動向調查結果輔導人數：" . $nextYearSurvryCaseCount . "<br/>";
              $executeDetail = $executeDetail . "6. " . ($yearType - 1) . "學年度高中已錄取未註冊結果輔導人數：" . $highSchoolSurveryCaseCount . "<br/>";

              $executeDetail = $executeDetail . "三、 辦理情形<br/>";
              $executeDetail = $executeDetail . "1. 累計至本月輔導會談：" . $counselingMemberCountReport->month_counseling_hour .
                "小時、生涯探索課程或活動：" . $counselingMemberCountReport->month_course_hour . "小時、工作體驗：" . $counselingMemberCountReport->month_working_hour . "小時。<br/>";

              $executeDetail = $executeDetail . "2. 簡述生涯探索課程與工作體驗紀錄：<br/>";
              $executeDetail = $executeDetail . $counselingMemberCountReport->course_note . $counselingMemberCountReport->work_note . "<br/>";

              $executeDetail = $executeDetail . "3. 簡述不可抗力及其他人數之原因：<br/>";
              $executeDetail = $executeDetail . $counselingMemberCountReport->force_majeure_note . "<br/>";

              $executeDetail = $executeDetail . "4. 簡述參加職訓人數之單位及課程：<br/>";
              $executeDetail = $executeDetail . $counselingMemberCountReport->work_trainning_note . "<br/>";

              $executeDetail = $executeDetail . "5. 簡述本月工作歷程：<br/>";
              $executeDetail = $executeDetail . $counselingMemberCountReport->other_note . "<br/>";

              $projectFunding = $projects->funding ? $projects->funding : 1;
              $executeDetail = $executeDetail . "6. 經費執行率：";
              $executeDetail = $executeDetail . (round($counselingMemberCountReport->funding_execute / $projectFunding, 2) * 100) . "%(" . number_format($counselingMemberCountReport->funding_execute) . "元/" . number_format($projects->funding) . "元) <br/>";

              $executeDetail = $executeDetail . "四、 投保情形<br/>";
              $executeDetail = $executeDetail . $counselingMemberCountReport->insure_note . "<br/>";
            }

            array_push($executeDetailArray, $executeDetail);
          }
      
          $beSentDataset = array(
            'title' => '表一.輔導人數統計表/執行進度表',
            'url' => '/report/counseling_member_count_report_yda_table/' . $yearType . '/' . $monthType . '/' . $countyType,
            'role' => $current_role,
            'years' => $years,
            'months' => $months,
            'executeModes' => $executeModes,
            'executeWays' => $executeWays,
            'counties' => $counties,
            'county' => $county,
            'countyType' => $countyType,
            'countiesName' => $countiesName,
            'counselingMemberCountReport' => $counselingMemberCountReport,
            'userTitle' => $userTitle,
            'projects' => $projects,
            'countyAndOrg' => $countyAndOrg,
            'yearType' => $yearType,
            'monthType' => $monthType,
            'accumCounselingMemberCount' => $accumCounselingMemberCount,
            'twoYearSurvryCaseCount' => $twoYearSurvryCaseCount,
            'oneYearSurvryCaseCount' => $oneYearSurvryCaseCount,
            'nowYearSurvryCaseCount' => $nowYearSurvryCaseCount,
            'nextYearSurvryCaseCount' => $nextYearSurvryCaseCount,
            'highSchoolSurveryCaseCount' => $highSchoolSurveryCaseCount,
            'forceMajeureNote' => $forceMajeureNote,
            'workTrainningNote' => $workTrainningNote,
            'counselorInfo' => $counselorInfo,
            'counselorDetailArray' => $counselorDetailArray,
            'password' => $passport['password'],
            'updatePwd' => $passport['updatePwd'],
            'security' => $this->security,
            'projectDetail' => $projectDetail,
            'executeDetail' => $executeDetail,
            'countyName' => $countyName,
            'projectArray' => $projectArray,
            'projectDetailArray' => $projectDetailArray,
            'accumCounselingMemberCountArray' => $accumCounselingMemberCountArray,
            'monthMemberTempCounselingArray' => $monthMemberTempCounselingArray,
            'executeDetailArray' => $executeDetailArray,
            'counselingMemberCountReportArray' => $counselingMemberCountReportArray,
            'reportType' => 'counselingMemberCountReport'
          );

          return $this->load->view('report/yda_month_report_table', $beSentDataset);

        }

        if($reportType == 'counselingIdentityCountReport') {
          $get_all_inserted_identity_count_data = $this->CounselingIdentityCountReportModel->get_by_all($yearType, $monthType, $countyType);

          $get_all_inserted_identity_count_data_array = [];
     
          if ($countyType == 'all') $counties = $this->CountyModel->get_all();
          else $counties = $this->CountyModel->get_one($countyType);

          foreach ($counties as $county) {
            $projects = $this->ProjectModel->get_latest_by_county($county['no']);
          
            $get_inserted_identity_count_data = $this->CounselingIdentityCountReportModel->get_inserted_identity_count_data($yearType, $monthType, $projects->no);
            array_push($get_all_inserted_identity_count_data_array, $get_inserted_identity_count_data);
          }

          $beSentDataset = array(
            'title' => '表二.輔導對象身分統計',
            'url' => '/report/counseling_identity_count_report_yda_table/' . $yearType . "/" . $monthType . '/' . $countyType,
            'role' => $current_role,
            'userTitle' => $userTitle,
            'get_all_inserted_identity_count_data' => $get_all_inserted_identity_count_data,
            'counties' => $counties,
            'countyType' => $countyType,
            'county' => $county,
            'security' => $this->security,
            'yearType' => $yearType,
            'monthType' => $monthType,
            'years' => $years,
            'months' => $months,
            'password' => $passport['password'],
            'get_all_inserted_identity_count_data_array' => $get_all_inserted_identity_count_data_array,
            'reportType' => 'counselingIdentityCountReport'
          );

          return $this->load->view('report/yda_month_report_table', $beSentDataset);

        }

        if($reportType == 'counselingMeetingCountReport') {
          $get_all_inserted_meeting_count_data = $this->CounselingMeetingCountReportModel->get_by_all($yearType, $monthType, $countyType);
          if ($countyType == 'all') $counties = $this->CountyModel->get_all();
          else $counties = $this->CountyModel->get_one($countyType);
       
          $organization = 'all';
          $projects = $this->ProjectModel->get_all_by_county_no('all');
          $organ_num = $this->CounselingMeetingCountReportModel->get_organization_num();

          $note_detail = $this->CounselingMeetingCountReportModel->get_note_datail($yearType, $monthType, $organization);
          $meetingTypeNo = [];
          $meetingTypeNo['meetingTypeNoPlanningMeeting'] = $this->MenuModel->get_no_resource_by_content('跨局處會議', 'meeting')->no;
          $meetingTypeNo['meetingTypeNoActualMeeting'] = $this->MenuModel->get_no_resource_by_content('預防性講座', 'meeting')->no;
          $countyExecuteType = $this->MenuModel->get_no_resource_by_content('委辦', 'project')->no;
          $actual_meeting_date_count = $this->CounselingMeetingCountReportModel->actual_meeting_date($yearType + 1911, $monthType, $organization, $meetingTypeNo['meetingTypeNoPlanningMeeting']);
          $actual_holding_meeting_count = $this->CounselingMeetingCountReportModel->actual_holding_meeting_count($yearType + 1911, $monthType, $organization, $meetingTypeNo['meetingTypeNoActualMeeting']);

          $sumDetail = [];
          $sumDetail['commission_meeting_count'] = 0;
          $sumDetail['commission_planning_holding_meeting_count'] = 0;
          $sumDetail['commission_actual_holding_meeting_count'] = 0;
          $sumDetail['commission_planning_involved_people'] = 0;
          $sumDetail['commission_actual_involved_people'] = 0;

          $sumDetail['self_meeting_count'] = 0;
          $sumDetail['self_planning_holding_meeting_count'] = 0;
          $sumDetail['self_actual_holding_meeting_count'] = 0;
          $sumDetail['self_planning_involved_people'] = 0;
          $sumDetail['self_actual_involved_people'] = 0;

          $tempSum = $planningHoldingSum = $actualHoldingSum = $planningInvolvedSum = $actualInvolvedSum = 0;

          foreach ($projects as $value) {
            $tempSum += $value['meeting_count'];
            if ($countyExecuteType == $value['execute_way']) {
              $sumDetail['commission_meeting_count'] += $value['meeting_count'];
            } else {
              $sumDetail['self_meeting_count'] += $value['meeting_count'];
            }
          }

          $sumDetail['meetingCountSum'] = $tempSum;
          $tempSum = 0;

          foreach ($get_all_inserted_meeting_count_data as $value) {
            foreach ($projects as $pro) {
              if ($value['project'] == $pro['no']) {
                if ($countyExecuteType == $pro['execute_way']) {
                  $sumDetail['commission_planning_holding_meeting_count'] += $value['planning_holding_meeting_count'];
                  $sumDetail['commission_actual_holding_meeting_count'] += $value['actual_holding_meeting_count'];
                  $sumDetail['commission_planning_involved_people'] += $value['planning_involved_people'];
                  $sumDetail['commission_actual_involved_people'] += $value['actual_involved_people'];
                } else {
                  $sumDetail['self_planning_holding_meeting_count'] += $value['planning_holding_meeting_count'];
                  $sumDetail['self_actual_holding_meeting_count'] += $value['actual_holding_meeting_count'];
                  $sumDetail['self_planning_involved_people'] += $value['planning_involved_people'];
                  $sumDetail['self_actual_involved_people'] += $value['actual_involved_people'];
                }
              }
            }
            $planningHoldingSum += $value['planning_holding_meeting_count'];
            $actualHoldingSum += $value['actual_holding_meeting_count'];
            $planningInvolvedSum += $value['planning_involved_people'];
            $actualInvolvedSum += $value['actual_involved_people'];
          }

          $sumDetail['planningHoldingSum'] = $planningHoldingSum;
          $sumDetail['actualHoldingSum'] = $actualHoldingSum;
          $sumDetail['planningInvolvedSum'] = $planningInvolvedSum;
          $sumDetail['actualInvolvedSum'] = $actualInvolvedSum;

          $projectArray = [];
          $get_all_inserted_meeting_count_data_array = [];
      
          foreach ($counties as $county) {
            $projects = $this->ProjectModel->get_latest_by_county($county['no']);
            array_push($projectArray, $projects);
          
            $get_inserted_meeting_count_data = $this->CounselingMeetingCountReportModel->get_inserted_meeting_count_data($yearType, $monthType, $projects->no);
            array_push($get_all_inserted_meeting_count_data_array, $get_inserted_meeting_count_data);
          }

          $beSentDataset = array(
            'title' => '表三.跨局處會議/預防性講座場次/人次統計',
            'url' => '/report/counseling_meeting_count_report_yda_table/' . $yearType . "/" . $monthType . '/' . $countyType,
            'role' => $current_role,
            'userTitle' => $userTitle,
            'counties' => $counties,
            'county' => $county,
            'countyType' => $countyType,
            'projects' => $projects,
            'organization' => $organization,
            'get_all_inserted_meeting_count_data' => $get_all_inserted_meeting_count_data,
            'actual_meeting_date_count' => $actual_meeting_date_count,
            'actual_holding_meeting_count' => $actual_holding_meeting_count,
            'note_detail' => $note_detail,
            'organ_num' => $organ_num,
            'security' => $this->security,
            'yearType' => $yearType,
            'monthType' => $monthType,
            'years' => $years,
            'months' => $months,
            'password' => $passport['password'],
            'meetingTypeNoPlanningMeeting' => $meetingTypeNo['meetingTypeNoPlanningMeeting'],
            'meetingTypeNoActualMeeting' => $meetingTypeNo['meetingTypeNoActualMeeting'],
            'sumDetail' => $sumDetail,
            'get_all_inserted_meeting_count_data_array' => $get_all_inserted_meeting_count_data_array,
            'reportType' => 'counselingMeetingCountReport',
            'projectArray' => $projectArray
          );

          return $this->load->view('report/yda_month_report_table', $beSentDataset);

        }

        if($reportType == 'counselorManpowerCountReport') {
          $counselorManpowerReports = $this->CounselorManpowerReportModel->get_by_all($yearType, $monthType, $countyType);

          $sumDetail = [];
          $tempSum = $projectCounselorSum = $reallyCounselorSum = $educationCounselorSum = $counselingCenterCounselorSum = $schoolCounselorSum = $outsourcingCounselorSum = $bachelorDegreeSum
            = $masterDegreeSum = $qualificationOneSum = $qualificationTwoSum = $qualificationThreeSum = $qualificationFourSum = $qualificationFiveSum = $qualificationSixSum = 0;

          foreach ($counselorManpowerReports as $value) {
            $projectCounselorSum += $value['project_counselor'];
            $reallyCounselorSum += $value['really_counselor'];
            $educationCounselorSum += $value['education_counselor'];
            $counselingCenterCounselorSum += $value['counseling_center_counselor'];
            $schoolCounselorSum += $value['school_counselor'];
            $outsourcingCounselorSum += $value['outsourcing_counselor'];
            $bachelorDegreeSum += $value['bachelor_degree'];
            $masterDegreeSum += $value['master_degree'];
            $qualificationOneSum += $value['qualification_one'];
            $qualificationTwoSum += $value['qualification_two'];
            $qualificationThreeSum += $value['qualification_three'];
            $qualificationFourSum += $value['qualification_four'];
            $qualificationFiveSum += $value['qualification_five'];
            $qualificationSixSum += $value['qualification_six'];
          }

          $sumDetail['projectCounselorSum'] = $projectCounselorSum;
          $sumDetail['reallyCounselorSum'] = $reallyCounselorSum;
          $sumDetail['educationCounselorSum'] = $educationCounselorSum;
          $sumDetail['counselingCenterCounselorSum'] = $counselingCenterCounselorSum;
          $sumDetail['schoolCounselorSum'] = $schoolCounselorSum;
          $sumDetail['outsourcingCounselorSum'] = $outsourcingCounselorSum;
          $sumDetail['bachelorDegreeSum'] = $bachelorDegreeSum;
          $sumDetail['masterDegreeSum'] = $masterDegreeSum;
          $sumDetail['qualificationOneSum'] = $qualificationOneSum;
          $sumDetail['qualificationTwoSum'] = $qualificationTwoSum;
          $sumDetail['qualificationThreeSum'] = $qualificationThreeSum;
          $sumDetail['qualificationFourSum'] = $qualificationFourSum;
          $sumDetail['qualificationFiveSum'] = $qualificationFiveSum;
          $sumDetail['qualificationSixSum'] = $qualificationSixSum;

          $projectArray = [];
          $counselorManpowerReportArray = [];
         
          if ($countyType == 'all') $counties = $this->CountyModel->get_all();
          else $counties = $this->CountyModel->get_one($countyType);      
     
          foreach ($counties as $county) {
            $projects = $this->ProjectModel->get_latest_by_county($county['no']);
            array_push($projectArray, $projects);
          
            $counselorManpowerReport = $this->CounselorManpowerReportModel->get_by_no($yearType, $monthType, $county['no']);
            array_push($counselorManpowerReportArray, $counselorManpowerReport);      
          }


          $beSentDataset = array(
            'title' => '表四.輔導人力概況表',
            'url' => '/report/counselor_manpower_report_yda_table/' . $yearType . '/' . $monthType . '/' . $countyType,
            'role' => $current_role,
            'counties' => $counties,
            'countyType' => $countyType,
            'userTitle' => $userTitle,
            'yearType' => $yearType,
            'monthType' => $monthType,
            'counselorManpowerReports' => $counselorManpowerReports,
            'years' => $years,
            'months' => $months,
            'password' => $passport['password'],
            'security' => $this->security,
            'sumDetail' => $sumDetail,
            'counselorManpowerReportArray' => $counselorManpowerReportArray,
            'reportType' => 'counselingManpowerReport'
          );

          return $this->load->view('report/yda_month_report_table', $beSentDataset);
        }

        if($reportType == 'highSchoolTrendSurveyCountReport') {
          $highSchoolTrendSurveyCountReports = $this->HighSchoolTrendSurveyCountReportModel->get_by_all($yearType, $monthType, $countyType);

          $sumDetail = get_seasonal_review_month_report_sum($highSchoolTrendSurveyCountReports);

     
        

            $highSchoolTrendSurveyCountReportArray = [];

            if ($countyType == 'all') $counties = $this->CountyModel->get_all();
            else $counties = $this->CountyModel->get_one($countyType);

            foreach ($counties as $county) {
              $projects = $this->ProjectModel->get_latest_by_county($county['no']);

              $highSchoolTrendSurveyCountReport = $this->HighSchoolTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county['no']);
              array_push($highSchoolTrendSurveyCountReportArray, $highSchoolTrendSurveyCountReport);         
            }

            $beSentDataset = array(
              'title' => '表九.高中已錄取未註冊追蹤',
              'url' => '/report/high_school_trend_survey_count_report_yda_table/' . $yearType . '/' . $monthType . '/' .$countyType,
              'role' => $current_role,
              'executeModes' => $executeModes,
              'executeWays' => $executeWays,
              'counties' => $counties,
              'countyType' => $countyType,
              'userTitle' => $userTitle,
              'yearType' => $yearType,
              'monthType' => $monthType,
              'highSchoolTrendSurveyCountReports' => $highSchoolTrendSurveyCountReports,
              'years' => $years,
              'months' => $months,
              'password' => $passport['password'],
              'updatePwd' => $passport['updatePwd'],
              'security' => $this->security,
              'sumDetail' => $sumDetail,
              'reportType' => 'highSchoolTrendSurveyCountReport'
            );

          return $this->load->view('report/yda_month_report_table', $beSentDataset);
        }

        if($reportType == 'twoYearsTrendSurveyCountReport') {
          $twoYearsTrendSurveyCountReports = $this->TwoYearsTrendSurveyCountReportModel->get_by_all($yearType, $monthType, $countyType);

          $sumDetail = get_seasonal_review_month_report_sum($twoYearsTrendSurveyCountReports);

     
        

            $twoYearsTrendSurveyCountReportArray = [];

            if ($countyType == 'all') $counties = $this->CountyModel->get_all();
            else $counties = $this->CountyModel->get_one($countyType);

            foreach ($counties as $county) {
              $projects = $this->ProjectModel->get_latest_by_county($county['no']);

              $twoYearsTrendSurveyCountReport = $this->TwoYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county['no']);
              array_push($twoYearsTrendSurveyCountReportArray, $twoYearsTrendSurveyCountReport);         
            }

            $beSentDataset = array(
              'title' => '表五.' . ($yearType - 4) . '年動向調查追蹤',
              'url' => '/report/two_years_trend_survey_count_report_yda_table/' . $yearType . '/' . $monthType . '/' .$countyType,
              'role' => $current_role,
              'executeModes' => $executeModes,
              'executeWays' => $executeWays,
              'counties' => $counties,
              'countyType' => $countyType,
              'userTitle' => $userTitle,
              'yearType' => $yearType,
              'monthType' => $monthType,
              'twoYearsTrendSurveyCountReports' => $twoYearsTrendSurveyCountReports,
              'years' => $years,
              'months' => $months,
              'password' => $passport['password'],
              'updatePwd' => $passport['updatePwd'],
              'security' => $this->security,
              'sumDetail' => $sumDetail,
              'reportType' => 'twoYearsTrendSurveyCountReport'
            );

          return $this->load->view('report/yda_month_report_table', $beSentDataset);
        }

        if($reportType == 'oneYearsTrendSurveyCountReport') {
          $oneYearsTrendSurveyCountReports = $this->OneYearsTrendSurveyCountReportModel->get_by_all($yearType, $monthType, $countyType);

         

          $sumDetail = get_seasonal_review_month_report_sum($oneYearsTrendSurveyCountReports);


          $oneYearsTrendSurveyCountReportArray = [];

          if ($countyType == 'all') $counties = $this->CountyModel->get_all();
          else $counties = $this->CountyModel->get_one($countyType);

          foreach ($counties as $county) {
            $projects = $this->ProjectModel->get_latest_by_county($county['no']);

            $oneYearsTrendSurveyCountReport = $this->OneYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county['no']);
            array_push($oneYearsTrendSurveyCountReportArray, $oneYearsTrendSurveyCountReport);
          }

          $beSentDataset = array(
            'title' => '表六.' . ($yearType - 3) . '年動向調查追蹤',
            'url' => '/report/one_years_trend_survey_count_report_yda_table/'. $yearType . '/' . $monthType . '/' .$countyType,
            'role' => $current_role,
            'executeModes' => $executeModes,
            'executeWays' => $executeWays,
            'counties' => $counties,
            'countyType' => $countyType,
            'userTitle' => $userTitle,
            'yearType' => $yearType,
            'monthType' => $monthType,
            'oneYearsTrendSurveyCountReports' => $oneYearsTrendSurveyCountReports,
            'years' => $years,
            'months' => $months,
            'password' => $passport['password'],
            'updatePwd' => $passport['updatePwd'],
            'security' => $this->security,
            'sumDetail' => $sumDetail,
            'oneYearsTrendSurveyCountReportArray' => $oneYearsTrendSurveyCountReportArray,
            'reportType' => 'oneYearsTrendSurveyCountReport'
          );
          return $this->load->view('report/yda_month_report_table', $beSentDataset);
        }

        if($reportType == 'nowYearsTrendSurveyCountReport') {
          $nowYearsTrendSurveyCountReports = $this->NowYearsTrendSurveyCountReportModel->get_by_all($yearType, $monthType, $countyType);

          $sumDetail = get_seasonal_review_month_report_sum($nowYearsTrendSurveyCountReports);

          $nowYearsTrendSurveyCountReportArray = [];

          if ($countyType == 'all') $counties = $this->CountyModel->get_all();
          else $counties = $this->CountyModel->get_one($countyType);

          foreach ($counties as $county) {
            $projects = $this->ProjectModel->get_latest_by_county($county['no']);

            $nowYearsTrendSurveyCountReport = $this->NowYearsTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county['no']);
            array_push($nowYearsTrendSurveyCountReportArray, $nowYearsTrendSurveyCountReport);
          }

          $beSentDataset = array(
            'title' => '表七.' . ($yearType - 2) . '年動向調查追蹤',
            'url' => '/report/now_years_trend_survey_count_report_yda_table/'. $yearType . '/' . $monthType . '/' .$countyType,
            'role' => $current_role,
            'executeModes' => $executeModes,
            'executeWays' => $executeWays,
            'counties' => $counties,
            'countyType' => $countyType,
            'userTitle' => $userTitle,
            'yearType' => $yearType,
            'monthType' => $monthType,
            'nowYearsTrendSurveyCountReports' => $nowYearsTrendSurveyCountReports,
            'years' => $years,
            'months' => $months,
            'password' => $passport['password'],
            'updatePwd' => $passport['updatePwd'],
            'security' => $this->security,
            'sumDetail' => $sumDetail,
            'nowYearsTrendSurveyCountReportArray' => $nowYearsTrendSurveyCountReportArray,
            'reportType' => 'nowYearsTrendSurveyCountReport'
          );
          return $this->load->view('report/yda_month_report_table', $beSentDataset);
        }

        if($reportType == 'oldCaseTrendSurveyCountReport') {
          $source = $this->MenuModel->get_no_resource_by_content('轉介或自行開發', 'youth')->no;
          $oldCaseTrendSurveyCountReports = $this->OldCaseTrendSurveyCountReportModel->get_by_all($yearType, $monthType, $countyType, $source);

          $sumDetail = get_seasonal_review_month_report_sum($oldCaseTrendSurveyCountReports );

          $oldCaseTrendSurveyCountReportArray = [];

          if ($countyType == 'all') $counties = $this->CountyModel->get_all();
          else $counties = $this->CountyModel->get_one($countyType);

          foreach ($counties as $county) {
            $projects = $this->ProjectModel->get_latest_by_county($county['no']);

            $oldCaseTrendSurveyCountReport = $this->OldCaseTrendSurveyCountReportModel->get_by_no($yearType, $monthType, $county['no']);
            array_push($oldCaseTrendSurveyCountReportArray, $oldCaseTrendSurveyCountReport);
          }

          $beSentDataset = array(
            'title' => '表八.前一年結案後動向調查追蹤',
            'url' => '/report/one_years_trend_survey_count_report_yda_table/'. $yearType . '/' . $monthType . '/' .$countyType,
            'role' => $current_role,
            'executeModes' => $executeModes,
            'executeWays' => $executeWays,
            'counties' => $counties,
            'countyType' => $countyType,
            'userTitle' => $userTitle,
            'yearType' => $yearType,
            'monthType' => $monthType,
            'oldCaseTrendSurveyCountReports' => $oldCaseTrendSurveyCountReports,
            'years' => $years,
            'months' => $months,
            'password' => $passport['password'],
            'updatePwd' => $passport['updatePwd'],
            'security' => $this->security,
            'sumDetail' => $sumDetail,
            'oldCaseTrendSurveyCountReportArray' => $oldCaseTrendSurveyCountReportArray,
            'reportType' => 'oldCaseTrendSurveyCountReport'
          );
          return $this->load->view('report/yda_month_report_table', $beSentDataset);
        }

      } else {
        redirect('user/login');
      }
    }

}
