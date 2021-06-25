<?php
class Youth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MenuModel');
        $this->load->model('YouthModel');
        $this->load->model('CaseAssessmentModel');
        $this->load->model('ProjectModel');
        $this->load->model('CountyModel');
        $this->load->model('MemberModel');
        $this->load->model('UserModel');
        $this->load->model('SeasonalReviewModel');
        $this->load->model('IntakeModel');
        $this->load->model('CompletionModel');
        $this->load->model('CounselorServingMemberModel');
        $this->load->model('ReviewModel');
        $this->load->model('MonthReviewModel');
        $this->load->model('SeasonalReviewModel');
    }

    public function personal_data($comePage = null, $youthNo = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $counselor = $passport['counselor'];
        $county = $passport['county'];
        $accept_role = array(2, 3, 4, 5, 6);

        if (in_array($current_role, $accept_role)) {

            check_youth($youthNo, $county);

            $youths = $youthNo ? $this->YouthModel->get_by_no($youthNo) : null;
            $genders = $this->MenuModel->get_by_form_and_column('youth', 'gender');
            $juniorSchoolConditions = $this->MenuModel->get_by_form_and_column('youth', 'junior_school_condition');
            $seniorSchoolConditions = $this->MenuModel->get_by_form_and_column('youth', 'senior_school_condition');
            $surveyTypes = $this->MenuModel->get_by_form_and_column('youth', 'survey_type');
            $sources = $this->MenuModel->get_by_form_and_column('youth', 'source');
            $counselIdentitys = $this->MenuModel->get_by_form_and_column('youth', 'counsel_identity');

            $beSentDataset = array(
                'title' => '青少年基本資料',
                'url' => '/youth/personal_data/' . $comePage . '/' . $youthNo,
                'role' => $current_role,
                'genders' => $genders,
                'juniorSchoolConditions' => $juniorSchoolConditions,
                'seniorSchoolConditions' => $seniorSchoolConditions,
                'surveyTypes' => $surveyTypes,
                'sources' => $sources,
                'counselIdentitys' => $counselIdentitys,
                'youths' => $youths,
                'userTitle' => $userTitle,
                'security' => $this->security,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'comePage' => $comePage
            );

            $identification = $this->security->xss_clean($this->input->post('identification'));
            $name = $this->security->xss_clean($this->input->post('name'));
            $birth = $this->security->xss_clean($this->input->post('birth'));
            $gender = $this->security->xss_clean($this->input->post('gender'));
            $phone = $this->security->xss_clean($this->input->post('phone'));
            $householdAddress = $this->security->xss_clean($this->input->post('householdAddress'));
            $resideAddress = $this->security->xss_clean($this->input->post('resideAddress'));
            $juniorGraduateYear = $this->security->xss_clean($this->input->post('juniorGraduateYear'));
            $juniorDropoutRecord = $this->security->xss_clean($this->input->post('juniorDropoutRecord'));
            $counselIdentity = $this->security->xss_clean($this->input->post('counselIdentity'));
            $juniorSchoolCondition = $this->security->xss_clean($this->input->post('juniorSchoolCondition'));
            $juniorSchoolOne = $this->security->xss_clean($this->input->post('juniorSchoolOne'));
            $juniorSchoolTwo = $this->security->xss_clean($this->input->post('juniorSchoolTwo'));
            $juniorSchoolThree = $this->security->xss_clean($this->input->post('juniorSchoolThree'));
            $juniorSchool = $juniorSchoolOne . '/' . $juniorSchoolTwo . '/' . $juniorSchoolThree;
            $seniorSchoolCondition = $this->security->xss_clean($this->input->post('seniorSchoolCondition'));
            $guardianName = $this->security->xss_clean($this->input->post('guardianName'));
            $guardianShip = $this->security->xss_clean($this->input->post('guardianShip'));
            $guardianPhone = $this->security->xss_clean($this->input->post('guardianPhone'));
            $guardianHouseholdAddressSame = $this->security->xss_clean($this->input->post('guardianHouseholdAddressSame'));
            $guardianResideAddressSame = $this->security->xss_clean($this->input->post('guardianResideAddressSame'));
            $guardianHouseholdAddress = ($guardianHouseholdAddressSame == "1") ? $householdAddress : $this->security->xss_clean($this->input->post('guardianHouseholdAddress'));
            $guardianResideAddress = ($guardianResideAddressSame == "1") ? $resideAddress : $this->security->xss_clean($this->input->post('guardianResideAddress'));
            $source = $youths ? $youths->source : null;
            $sourceSchoolYear = $this->security->xss_clean($this->input->post('sourceSchoolYear'));
            $surveyType = $youths->survey_type;

            if (empty($name)) {
                return $this->load->view('/youth/personal_data', $beSentDataset);
            }

            if (!empty($youths)) {
                $isExecuteSuccess = $this->YouthModel->update_by_no($youthNo, $identification, $name, $birth, $gender,
                    $phone, $householdAddress, $resideAddress, $juniorGraduateYear, $juniorDropoutRecord, $counselIdentity,
                    $juniorSchoolCondition, $seniorSchoolCondition, $guardianName, $guardianShip, $guardianPhone,
                    $guardianHouseholdAddress, $guardianResideAddress, $county, $source, $sourceSchoolYear, $surveyType, $juniorSchool);
            
                $youthNum = 0;
                $youthCompletionArray = array($identification, $name, $birth, $gender,
                    $phone, $householdAddress, $resideAddress, $juniorGraduateYear,
                    $juniorDropoutRecord, $counselIdentity, $guardianName, $guardianShip,
                    $guardianPhone, $guardianHouseholdAddress, $guardianResideAddress, $county, $source);
                foreach ($youthCompletionArray as $value) {
                    if ($value != null || $value == 0) {
                        $youthNum++;
                    }
                }
                $youthRate = round($youthNum / count($youthCompletionArray), 2) * 100;
                $youthCompletionSuccess = $this->CompletionModel->update_one('youth', $youthNo, $youthRate);
            }

            if ($youthNo && $isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
            } else {
                $beSentDataset['error'] = '新增失敗';
            }

            $youths = $youthNo ? $this->YouthModel->get_by_no($youthNo) : null;
            $beSentDataset['youths'] = $youths;
            $beSentDataset['url'] = '/youth/personal_data/' . $youthNo;

            $this->load->view('/youth/personal_data', $beSentDataset);
        }
    }

    public function intake($comePage = "new", $youthNo = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $county = $passport['county'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            check_youth($youthNo, $county);
            // get youth data by youthNo
            $youths = $youthNo ? $this->YouthModel->get_by_no($youthNo) : null;
            // get intake data by youthNo
            $intakes = $youths ? $this->IntakeModel->get_by_youth($youthNo) : null;
            $counselorCase = $youths ? $this->IntakeModel->get_youth_counselor($youthNo) : null;

            // get menu data
            $genders = $this->MenuModel->get_by_form_and_column('youth', 'gender');
            $referralAttitudes = $this->MenuModel->get_by_form_and_column('intake', 'referral_attitude');
            $majorDemands = $this->MenuModel->get_by_form_and_column('intake', 'major_demand');
            $juniorSchoolConditions = $this->MenuModel->get_by_form_and_column('youth', 'junior_school_condition');
            $seniorSchoolConditions = $this->MenuModel->get_by_form_and_column('youth', 'senior_school_condition');
            $surveyTypes = $this->MenuModel->get_by_form_and_column('youth', 'survey_type');
            $sources = $this->MenuModel->get_by_form_and_column('youth', 'source');
            $sourceCases = $this->MenuModel->get_by_form_and_column('case_assessment', 'source');
            $counselIdentitys = $this->MenuModel->get_by_form_and_column('youth', 'counsel_identity');

            $noNeedSources = [
                $this->MenuModel->get_no_resource_by_content('01已就業', 'youth')->no,
                $this->MenuModel->get_no_resource_by_content('02已就學', 'youth')->no,
                $this->MenuModel->get_no_resource_by_content('03特教生', 'youth')->no,
                $this->MenuModel->get_no_resource_by_content('13不可抗力(去世、司法問題、出國)', 'youth')->no,
                $this->MenuModel->get_no_resource_by_content('13不可抗力(去世)', 'youth')->no,
                $this->MenuModel->get_no_resource_by_content('13不可抗力(司法問題)', 'youth')->no,
                $this->MenuModel->get_no_resource_by_content('13不可抗力(出國)', 'youth')->no,
            ];

            // get sourceSurvey no in menu table
            foreach ($sourceCases as $sc) {
                if ($sc['content'] == "動向調查名單") {
                    $sourceSurvey = $sc['no'];
                }
            }
            // get sourceReferral no in menu table
            foreach ($sources as $s) {
                if ($s['content'] == "轉介或自行開發") {
                    $sourceReferral = $s['no'];
                }
            }

            // $youthTrendSource = $this->MenuModel->get_no_resource_by_content('動向調查', 'youth')->no;
            // $youthReferralSource = $this->MenuModel->get_no_resource_by_content('轉介或自行開發', 'youth')->no;
            // $youthHighSource = $this->MenuModel->get_no_resource_by_content('高中已錄取未註冊', 'youth')->no;
            // $youthSource = true;
            // if($youths) {
            //   if($youths->source == $youthTrendSource || $youths->source == $youthHighSource) $youthSource = false;
            // }
            // get county no
            $county = $passport['county'];
            $organization = $passport['organization'];
            // get counselor no
            $counselor = $passport['counselor'];
            // get current project by county
            $project = $this->ProjectModel->get_latest_by_county($county)->no;
            $counselors = $this->UserModel->get_counselor_by_organization($organization, $county);

            $beSentDataset = array(
                'title' => '青少年初評表',
                'url' => '/youth/intake/' . $comePage . '/' . $youthNo,
                'role' => $current_role,
                'genders' => $genders,
                'juniorSchoolConditions' => $juniorSchoolConditions,
                'seniorSchoolConditions' => $seniorSchoolConditions,
                'referralAttitudes' => $referralAttitudes,
                'majorDemands' => $majorDemands,
                'surveyTypes' => $surveyTypes,
                'sources' => $sources,
                'counselIdentitys' => $counselIdentitys,
                'youths' => $youths,
                'intakes' => $intakes,
                'userTitle' => $userTitle,
                'security' => $this->security,
                'counselors' => $counselors,
                'counselorCase' => $counselorCase,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'comePage' => $comePage
                // 'youthSource' => $youthSource
            );

            $referralInstitution = $this->security->xss_clean($this->input->post('referralInstitution'));
            $referralName = $this->security->xss_clean($this->input->post('referralName'));
            $referralPhone = $this->security->xss_clean($this->input->post('referralPhone'));
            $referralTarget = $this->security->xss_clean($this->input->post('referralTarget'));
            $referralAttitude = $this->security->xss_clean($this->input->post('referralAttitude'));
            $referralAttitudeOther = $this->security->xss_clean($this->input->post('referralAttitudeOther'));
            $identification = $this->security->xss_clean($this->input->post('identification'));
            $name = $this->security->xss_clean($this->input->post('name'));
            $birth = $this->security->xss_clean($this->input->post('birth'));
            $gender = $this->security->xss_clean($this->input->post('gender'));
            $phone = $this->security->xss_clean($this->input->post('phone'));
            $householdAddress = $this->security->xss_clean($this->input->post('householdAddress'));
            $resideAddress = $this->security->xss_clean($this->input->post('resideAddress'));
            $juniorGraduateYear = $this->security->xss_clean($this->input->post('juniorGraduateYear'));
            $juniorDropoutRecord = $this->security->xss_clean($this->input->post('juniorDropoutRecord'));
            $counselIdentity = $this->security->xss_clean($this->input->post('counselIdentity'));
            $juniorSchoolCondition = $this->security->xss_clean($this->input->post('juniorSchoolCondition'));
            $seniorSchoolCondition = $this->security->xss_clean($this->input->post('seniorSchoolCondition'));
            $guardianName = $this->security->xss_clean($this->input->post('guardianName'));
            $guardianShip = $this->security->xss_clean($this->input->post('guardianShip'));
            $guardianPhone = $this->security->xss_clean($this->input->post('guardianPhone'));
            $juniorSchoolOne = $this->security->xss_clean($this->input->post('juniorSchoolOne'));
            $juniorSchoolTwo = $this->security->xss_clean($this->input->post('juniorSchoolTwo'));
            $juniorSchoolThree = $this->security->xss_clean($this->input->post('juniorSchoolThree'));
            $juniorSchool = $juniorSchoolOne . '/' . $juniorSchoolTwo . '/' . $juniorSchoolThree;
            $guardianHouseholdAddressSame = $this->security->xss_clean($this->input->post('guardianHouseholdAddressSame'));
            $guardianResideAddressSame = $this->security->xss_clean($this->input->post('guardianResideAddressSame'));
            $guardianHouseholdAddress = ($guardianHouseholdAddressSame == "1") ? $householdAddress : $this->security->xss_clean($this->input->post('guardianHouseholdAddress'));
            $guardianResideAddress = ($guardianResideAddressSame == "1") ? $resideAddress : $this->security->xss_clean($this->input->post('guardianResideAddress'));

            $source = $youths ? $youths->source : null;
            $sourceSchoolYear = $youths ? $this->security->xss_clean($this->input->post('sourceSchoolYear')) : 0;
            $surveyType = $youths ? $youths->survey_type : null;

            $majorDemand = $this->security->xss_clean($this->input->post('majorDemand'));
            $majorDemandOther = $this->security->xss_clean($this->input->post('majorDemandOther'));
            $isWant = $this->security->xss_clean($this->input->post('isWant'));

            $counselor = $this->security->xss_clean($this->input->post('counselor'));

            if (in_array($surveyType, $noNeedSources)) {
                $openCase = '0';
            } else {
                $openCase = $this->security->xss_clean($this->input->post('openCase'));
            }

            if (empty($name)) {
                return $this->load->view('/youth/intake', $beSentDataset);
            }
            // create one youth if youth not exist
            if (empty($youths)) {
                $source = $sourceReferral;
                $youthNo = $this->YouthModel->create_one($identification, $name, $birth, $gender,
                    $phone, $householdAddress, $resideAddress, $juniorGraduateYear, $juniorDropoutRecord,
                    $counselIdentity, $juniorSchoolCondition, $seniorSchoolCondition, $guardianName,
                    $guardianShip, $guardianPhone, $guardianHouseholdAddress, $guardianResideAddress,
                    $county, $source, null, null, $juniorSchool);

                $youthNum = 0;
                $youthCompletionArray = array($identification, $name, $birth, $gender,
                    $phone, $householdAddress, $resideAddress, $juniorGraduateYear,
                    $juniorDropoutRecord, $counselIdentity, $guardianName, $guardianShip,
                    $guardianPhone, $guardianHouseholdAddress, $guardianResideAddress, $county, $source);
                foreach ($youthCompletionArray as $value) {
                    if ($value != null || $value == 0) {
                        $youthNum++;
                    }
                }
                $youthRate = round($youthNum / count($youthCompletionArray), 2) * 100;
                $youthCompletionSuccess = $this->CompletionModel->create_one('youth', $youthNo, $youthRate);
            } else {
                $isExecuteSuccess = $this->YouthModel->update_by_no($youthNo, $identification, $name, $birth, $gender,
                    $phone, $householdAddress, $resideAddress, $juniorGraduateYear, $juniorDropoutRecord, $counselIdentity,
                    $juniorSchoolCondition, $seniorSchoolCondition, $guardianName, $guardianShip, $guardianPhone,
                    $guardianHouseholdAddress, $guardianResideAddress, $county, $source, $sourceSchoolYear, $surveyType, $juniorSchool);

                $youthNum = 0;
                $youthCompletionArray = array($identification, $name, $birth, $gender,
                    $phone, $householdAddress, $resideAddress, $juniorGraduateYear,
                    $juniorDropoutRecord, $counselIdentity, $guardianName, $guardianShip,
                    $guardianPhone, $guardianHouseholdAddress, $guardianResideAddress, $county, $source);
                foreach ($youthCompletionArray as $value) {
                    if ($value != null || $value == 0) {
                        $youthNum++;
                    }
                }
                $youthRate = round($youthNum / count($youthCompletionArray), 2) * 100;
                $youthCompletionSuccess = $this->CompletionModel->update_one('youth', $youthNo, $youthRate);
            }
            if (!empty($intakes)) {
                // update intake by youth
                $isExecuteSuccess = $this->IntakeModel->update_by_youth($referralInstitution, $referralName,
                    $referralPhone, $youthNo, $project, $referralTarget, $referralAttitude,
                    $referralAttitudeOther, $majorDemand, $majorDemandOther, $isWant, $openCase);

                $intakeNum = 0;
                $intakeCompletionArray = array($youthNo, $project, $majorDemand, $openCase);
                foreach ($intakeCompletionArray as $value) {
                    if ($value != null || $value == 0) {
                        $intakeNum++;
                    }
                }
                $intakeRate = round($intakeNum / count($intakeCompletionArray), 2) * 100;
                $intakeCompletionSuccess = $this->CompletionModel->update_one('intake', $youthNo, $intakeRate);
            } else {
                // create one case assessment
                $isExecuteSuccess = $this->IntakeModel->create_one($referralInstitution, $referralName,
                    $referralPhone, $youthNo, $project, $referralTarget, $referralAttitude,
                    $referralAttitudeOther, $majorDemand, $majorDemandOther, $isWant, $openCase);

                $comePage = "allSource";

                $intakeNum = 0;
                $intakeCompletionArray = array($youthNo, $project, $majorDemand, $openCase);
                foreach ($intakeCompletionArray as $value) {
                    if ($value != null || $value == 0) {
                        $intakeNum++;
                    }
                }
                $intakeRate = round($intakeNum / count($intakeCompletionArray), 2) * 100;
                $intakeCompletionSuccess = $this->CompletionModel->create_one('intake', $youthNo, $intakeRate);
            }

            $isMemberExist = $this->MemberModel->is_member_exist($youthNo, $project);
            // create member if counselor agree to open case

            if ($openCase && !$isMemberExist) {
                #$counselor = $passport['counselor'];
                $organization = $passport['organization'];
                // generate system code
                $countyCode = $this->CountyModel->get_by_no($county)->code;
                $now = new DateTime('now');
                $semester = substr($now->modify('-1911 year')->format('Y'), 1);
                $caseCount = $this->MemberModel->count_county_member_in_project($project, $county) + 1;
                $caseNo = str_pad($caseCount, 3, '0', STR_PAD_LEFT);
                $systemNo = $countyCode . $semester . $caseNo;
                $member = $this->MemberModel->create_one($systemNo, $youthNo, $counselor, $project, $organization, $county);
                $counselorServingMember = $this->CounselorServingMemberModel->create_counselor_serving_member($counselor, $member);
                $comePage = "member";
                if (!empty($youths)) {
                    $this->CaseAssessmentModel->create_one($member, $counselor, $sourceSurvey, $youths->source_school_year);
                    $this->CaseAssessmentModel->create_one_temp($member, $counselor, $sourceSurvey, $youths->source_school_year);
                } else {
                    $this->CaseAssessmentModel->create_one($member, $counselor, null, null);
                    $this->CaseAssessmentModel->create_one_temp($member, $counselor, null, null);
                }
                $caseAssessmentCompletionSuccess = $this->CompletionModel->create_one('case_assessment', $member, 15);
            }

            if ($youthNo && $isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
                if ($comePage == "member") {
                    redirect('member/get_member_table_by_counselor');
                } else {
                    redirect('youth/get_all_youth_table');
                }
            } else {
                $beSentDataset['error'] = '新增失敗';
            }

            $youths = $youthNo ? $this->YouthModel->get_by_no($youthNo) : null;
            $intakes = $youths ? $this->IntakeModel->get_by_youth($youthNo) : null;
            $beSentDataset['youths'] = $youths;
            $beSentDataset['intakes'] = $intakes;
            $beSentDataset['url'] = '/youth/intake/' . $comePage . '/' . $youthNo;
            $this->load->view('/youth/intake', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function get_all_source_youth_table($county = 22, $youthSource = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(2, 3, 4, 5, 6, 9);
        if (in_array($current_role, $accept_role)) {
            $county = $passport['county'] ? $passport['county'] : $county;
            $counties = $this->CountyModel->get_all();

            $surveyTypes = $this->MenuModel->get_by_form_and_column('youth', 'survey_type');
            $sources = $this->MenuModel->get_by_form_and_column('youth', 'source');

            foreach ($sources as $s) {
                if ($s['content'] == "轉介或自行開發") {
                    $sourceReferral = $s['no'];
                } else if ($s['content'] == "動向調查") {
                    $sourceSurvey = $s['no'];
                } else if ($s['content'] == "高中已錄取未註冊") {
                    $sourceHigh = $s['no'];
                }
            }

            if ($youthSource == null || $youthSource == 'all') {
                $youths = $this->YouthModel->get_by_county($county, null, null);
            } elseif ($youthSource == 'trend') {
                $youths = $this->YouthModel->get_by_source_and_county($sourceSurvey, $county, null);
            } elseif ($youthSource == 'case') {
                $youths = $this->YouthModel->get_by_case_and_county($county);
            } elseif ($youthSource == 'high') {
                $youths = $this->YouthModel->get_by_high_and_county($sourceHigh, $county);
            } elseif ($youthSource == 'case_trend') {
              $youths = $this->YouthModel->get_by_case_trend_and_county($county);
            } else {
                $youths = $this->YouthModel->get_by_source_referral_and_county($sourceReferral, $county);
            }

            

            $beSentDataset = array(
                'title' => '原始來源清單（含動向調查清單、高中職已錄取未註冊、自行開發及其他單位轉介）',
                'url' => '/youth/get_all_source_youth_table/' . $county . '/' . $youthSource,
                'role' => $current_role,
                'youthSource' => $youthSource,
                'surveyTypes' => $surveyTypes,
                'youths' => $youths,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'counties' => $counties,
                'county' => $county
            );

            $this->load->view('/youth/source_youth_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function get_all_youth_table($county = 22, $youthType = 'track', $youthSource = 'all', $caseTrendType = null)
    {
      $passport = $this->session->userdata('passport');
      $userTitle = $passport['userTitle'];
      $current_role = $passport['role'];
      $county = $passport['county'] ? $passport['county'] : $county;
      $counties = $this->CountyModel->get_all();
      $accept_role = array(2, 3, 4, 5, 6, 9);
      valid_roles($accept_role);
    
      $surveyTypes = $this->MenuModel->get_by_form_and_column('youth', 'survey_type');
      $sources = $this->MenuModel->get_by_form_and_column('youth', 'source');
      $trends = $this->MenuModel->get_by_form_and_column_order('seasonal_review', 'trend');
      $seasonalReviews = $this->SeasonalReviewModel->get_by_county($county);
      $members = $this->MemberModel->get_new_case($county, date("m"), date("Y") - 1911);
      $seasonalReviewArray = [];
      $keepMemberArray = $trendMemberArray = $endMemberArray = [];

      foreach ($seasonalReviews as $value) {
        $value['is_member'] = 0;
        foreach ($members as $mem) {
          if ($value['youth'] == $mem['youth']) {
            $value['is_member'] = 1;
          }
        }
        array_push($seasonalReviewArray, $value);
      }

      $noNeedSources = [
        $this->MenuModel->get_no_resource_by_content('01已就業', 'youth')->no,
        $this->MenuModel->get_no_resource_by_content('02已就學', 'youth')->no,
        $this->MenuModel->get_no_resource_by_content('03特教生', 'youth')->no,
        $this->MenuModel->get_no_resource_by_content('13不可抗力(去世、司法問題、出國)', 'youth')->no,
        $this->MenuModel->get_no_resource_by_content('13不可抗力(去世)', 'youth')->no,
        $this->MenuModel->get_no_resource_by_content('13不可抗力(司法問題)', 'youth')->no,
        $this->MenuModel->get_no_resource_by_content('13不可抗力(出國)', 'youth')->no
      ];

      foreach ($sources as $s) {
        if ($s['content'] == "轉介或自行開發") {
          $sourceReferral = $s['no'];
        } else if ($s['content'] == "動向調查") {
          $sourceSurvey = $s['no'];
        } else if ($s['content'] == "高中已錄取未註冊") {
          $sourceHigh = $s['no'];
        }
      }

      if ($youthSource == null || $youthSource == 'all') {
        $youths = $this->YouthModel->get_by_county($county, $noNeedSources, $sourceReferral);
      } elseif ($youthSource == 'trend') {
        $youths = $this->YouthModel->get_by_source_and_county($sourceSurvey, $county, $noNeedSources);
      } elseif ($youthSource == 'case') {
        $youths = $this->YouthModel->get_by_case_and_county($county);
      } elseif ($youthSource == 'high') {
        $youths = $this->YouthModel->get_by_high_and_county($sourceHigh, $county);
      } elseif ($youthSource == 'case_trend') {
        $youths = $this->YouthModel->get_by_case_trend_and_county($county);
      } elseif ($youthSource == 'end_trend') {
        $youths = $this->YouthModel->get_end_by_source_and_county($sourceSurvey, $county, $noNeedSources);              
      } elseif ($youthSource == 'end_case') {
        $youths = $this->YouthModel->get_end_by_case_and_county($county);              
      } elseif ($youthSource == 'end_high') {
        $youths = $this->YouthModel->get_end_by_high_and_county($sourceHigh, $county);              
      } else {
        $youths = $this->YouthModel->get_by_referral_and_county($sourceReferral, $county);
      }
      
      if($youthSource == 'case_trend') {

        if($caseTrendType) {

          foreach($youths as $value) {
            $isMember = $this->MemberModel->is_member($value['no']);
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
                  $countMonth = count($this->MonthReviewModel->get_by_date($value['memberNo'], $fromDate, $toDate));
                  $value['alreadyMonthReview'] += ($countMonth) ? 1: 0;
                }

                for($i = 0; $i < ($originSeasonalReview*3); $i+=3  ) {
                  $fromDate = ($originYear + 1) . '-' . (1 + $i) . '-' .$originDay;
                  $toDate = $originYear . '-' . (1 + $i + 3) . '-' .$originDay;
                  $countSeasonal = count($this->SeasonalReviewModel->get_by_date($value['no'], $fromDate, $toDate));
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
                  $countMonth = count($this->MonthReviewModel->get_by_date($value['memberNo'], $fromDate, $toDate));
                  $value['alreadyMonthReview'] += ($countMonth) ? 1: 0;
                }
              }

              // $alreadyMonthReview = count($this->MonthReviewModel->get_by_member($value['memberNo']));
              // $alreadySeasonalReview = count($this->SeasonalReviewModel->get_by_youth($value['no']));
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
  
          if($caseTrendType == 'end') $youths = $endMemberArray;
          elseif($caseTrendType == 'trend')  $youths = $trendMemberArray;
          else $youths = $keepMemberArray;   
        }

      } elseif($youthSource == 'trend') {
        
        if($caseTrendType) {
          $youths = $this->YouthModel->get_by_source_and_county_by_school_year($sourceSurvey, $county, $noNeedSources, $caseTrendType);
        }
      }
      

      $beSentDataset = array(
        'title' => '需關懷追蹤青少年清單（動向調查需政府介入者及高中職已錄取未註冊）',
        'url' => '/youth/get_all_youth_table/' . $youthSource,
        'role' => $current_role,
        'youthSource' => $youthSource,
        'surveyTypes' => $surveyTypes,
        'youths' => $youths,
        'userTitle' => $userTitle,
        'current_role' => $current_role,
        'seasonalReviewArray' => $seasonalReviewArray,
        'trends' => $trends,
        'password' => $passport['password'],
        'updatePwd' => $passport['updatePwd'],
        'keepMemberArray' => $keepMemberArray,
        'trendMemberArray' => $trendMemberArray,
        'endMemberArray' => $endMemberArray,
        'caseTrendType' => $caseTrendType,
        'youthType' => $youthType,
        'counties' => $counties,
        'county' => $county
      );

      $this->load->view('/youth/youth_table', $beSentDataset);
    }

    public function get_seasonal_review_table_by_youth($youth = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $county = $passport['county'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            check_youth($youth, $county);
            if (empty($youth)) {
                return show_404();
            }
            $seasonalReviews = $this->SeasonalReviewModel->get_by_youth($youth);
            $seasonalReviewCompletions = $this->CompletionModel->get_rate_by_form_name('seasonal_review');
            $youths = $this->YouthModel->get_by_no($youth);

            $beSentDataset = array(
                'title' => '季追蹤清單',
                'url' => 'youth/seasonal_review/' . $youth,
                'role' => $current_role,
                'youth' => $youth,
                'seasonalReviewCompletions' => $seasonalReviewCompletions,
                'seasonalReviews' => $seasonalReviews,
                'userTitle' => $userTitle,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'youths' => $youths
            );

            $this->load->view('/youth/seasonal_review_table', $beSentDataset);

        } else {
            redirect('user/login');
        }
    }

    public function seasonal_review($youthNo = null, $no = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(3, 6);

        if (in_array($current_role, $accept_role)) {
            $county = $passport['county'];
            check_youth($youthNo, $county);
            $youths = $this->YouthModel->get_by_no($youthNo);
            $seasonalReviews = $no ? $this->SeasonalReviewModel->get_by_no($no) : null;
            $dateTW = '';
            if ($seasonalReviews != null){
              if($seasonalReviews->date != null){

                $date = $seasonalReviews->dateTW;
                $dateTW = substr($date,1,strlen($date));
                echo $dateTW;
              }
            }
            // redirect to error 404 if youth not found
            if (empty($youths)) {
                return show_404();
            }
            $trends = $this->MenuModel->get_by_form_and_column_order('seasonal_review', 'trend');
            $youths = $this->YouthModel->get_by_no($youthNo);
            $youthName = $youths->name;
            $counselor = $passport['counselor'] ? $passport['counselor'] : $county;
            $project = $this->ProjectModel->get_latest_by_county($county)->no;
            $isCounselingMember = $this->MemberModel->is_member_exist($youthNo, $project);

            $beSentDataset = array(
                'title' => '季追蹤表單',
                'url' => '/youth/seasonal_review/' . $youthNo . '/' . $no,
                'role' => $current_role,
                'trends' => $trends,
                'youthName' => $youthName,
                'seasonalReviews' => $seasonalReviews,
                'userTitle' => $userTitle,
                'isCounselingMember' => $isCounselingMember,
                'security' => $this->security,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'youths' => $youths,
                'dateTW' => $dateTW
            );

            $date = $this->security->xss_clean($this->input->post('date'));
            $isCounseling = $this->security->xss_clean($this->input->post('isCounseling'));
            $trend = $this->security->xss_clean($this->input->post('trend'));
            $trendDescription = $this->security->xss_clean($this->input->post('trendDescription'));

            if (empty($date)) {
                return $this->load->view('/youth/seasonal_review', $beSentDataset);
            }

            if (empty($seasonalReviews)) {
                $isExecuteSuccess = $this->SeasonalReviewModel->create_one($youthNo, $counselor, $date, $isCounseling, $trend, $trendDescription);
                $no = $isExecuteSuccess;

                $seasonalReviewArray = array($youthNo, $counselor, $date, $isCounseling, $trend);

                $seasonalReviewNum = 0;
                foreach ($seasonalReviewArray as $value) {
                    if ($value != null) {
                        $seasonalReviewNum++;
                    }
                }

                $seasonalReviewRate = $isCounseling ? 100 : round($seasonalReviewNum / count($seasonalReviewArray), 2) * 100;
                $seasonalReviewCompletionSuccess = $this->CompletionModel->create_one('seasonal_review', $no, $seasonalReviewRate);
            } else {
                $isExecuteSuccess = $this->SeasonalReviewModel->update_by_no($youthNo, $counselor, $date, $isCounseling, $trend, $trendDescription, $no);
                $seasonalReviewArray = array($youthNo, $counselor, $date, $isCounseling, $trend);

                $seasonalReviewNum = 0;
                foreach ($seasonalReviewArray as $value) {
                    if ($value != null) {
                        $seasonalReviewNum++;
                    }
                }

                $seasonalReviewRate = $isCounseling ? 100 : round($seasonalReviewNum / count($seasonalReviewArray), 2) * 100;
                $seasonalReviewCompletionSuccess = $this->CompletionModel->update_one('seasonal_review', $no, $seasonalReviewRate);
            }

            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
                redirect('youth/get_seasonal_review_table_by_youth/' . $youthNo);

            } else {
                $beSentDataset['error'] = '新增失敗';
            }

            $seasonalReviews = $no ? $this->SeasonalReviewModel->get_by_no($no) : null;
            $beSentDataset['seasonalReviews'] = $seasonalReviews;
            $beSentDataset['url'] = '/youth/seasonal_review/' . $youthNo . '/' . $no;

            $this->load->view('/youth/seasonal_review', $beSentDataset);
        }
    }

    public function end_youth_table($youthNo = null) 
    {
      $passport = $this->session->userdata('passport');
      $userTitle = $passport['userTitle'];
      $current_role = $passport['role'];
      $accept_role = array(6);
      

      if (in_array($current_role, $accept_role)) {
        $county = $passport['county'];
        check_youth($youthNo, $county);
        if (empty($youthNo)) {
          return show_404();
        }

        $youths = $this->YouthModel->get_by_no($youthNo);

        $reviews = $this->ReviewModel->get_by_formName_and_formNo('end_youth', $youthNo);
        $statuses = $this->MenuModel->get_by_form_and_column('review', 'status');

        $beSentDataset = array(
            'title' => '青少年結案申請清單',
            'url' => 'youth/end_youth/' . $youthNo,
            'role' => $current_role,
            'youth' => $youthNo,
            'userTitle' => $userTitle,
            'password' => $passport['password'],
            'updatePwd' => $passport['updatePwd'],
            'youths' => $youths,
            'reviews' => $reviews,
            'statuses' => $statuses
        );

        $this->load->view('/youth/end_youth_table', $beSentDataset);
      }

    }

    public function end_youth($youthNo = null, $no = null) 
    {
      $passport = $this->session->userdata('passport');
      $userTitle = $passport['userTitle'];
      $current_role = $passport['role'];
      $accept_role = array(6);
      

      if (in_array($current_role, $accept_role)) {
        $county = $passport['county'];
        check_youth($youthNo, $county);
        if (empty($youthNo)) {
          return show_404();
        }

        $youths = $this->YouthModel->get_by_no($youthNo);
        $county = $passport['county'];

        $seasonalReviews = $this->SeasonalReviewModel->get_by_youth($youthNo);
        $reviews = $no ? $this->ReviewModel->get_by_no($no) : null;
        $statuses = $this->MenuModel->get_by_form_and_column('review', 'status');
        $trends = $this->MenuModel->get_by_form_and_column_order('seasonal_review', 'trend');

        $statusAgree = $this->MenuModel->get_no_resource_by_content('批准', 'review')->no;
        $statusWaiting = $this->MenuModel->get_no_resource_by_content('等待批准中', 'review')->no;
        $statusDisagree = $this->MenuModel->get_no_resource_by_content('未批准', 'review')->no;
        
        $beSentDataset = array(
            'title' => '青少年結案申請清單',
            'url' => 'youth/end_youth/' . $youthNo . '/' . $no,
            'role' => $current_role,
            'youth' => $youthNo,
            'userTitle' => $userTitle,
            'password' => $passport['password'],
            'updatePwd' => $passport['updatePwd'],
            'youths' => $youths,
            'reviews' => $reviews,
            'statuses' => $statuses,
            'security' => $this->security,
            'seasonalReviews' => $seasonalReviews,
            'trends' => $trends
        );

        $updateValue = $this->security->xss_clean($this->input->post('updateValue'));
        $reason = $this->security->xss_clean($this->input->post('reason'));
        $note = $this->security->xss_clean($this->input->post('note'));
        $reviewerRole = 3;
        $formName = $updateValue ? 'end_youth' : 'reopen_youth';
        $updateColumn = 'is_end';
       

        if (empty($reason)) {
          return $this->load->view('/youth/end_youth', $beSentDataset);
        }

        $isMember = $this->MemberModel->is_member($youthNo);
        

        if (!$isMember) {
            if ($reviews) {
                return $this->load->view('/youth/end_youth', $beSentDataset);
            } else {
                $isExecuteSuccess = $this->ReviewModel->create_note_one(
                    $formName,
                    $youthNo,
                    $reviewerRole,
                    $statusWaiting,
                    $reason,
                    $updateColumn,
                    $updateValue,
                    $county,
                    $note
                );
                $no  = $isExecuteSuccess;
            }
            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
                redirect('youth/end_youth_table/' . $youthNo);
            } else {
                $beSentDataset['error'] = '新增失敗';
            }

            $reviews = $no ? $this->ReviewModel->get_by_no($no) : null;
            $beSentDataset['reviews'] = $reviews;
            $beSentDataset['url'] = '/youth/end_youth/' . $youthNo . '/' . $no;
        } else {
          $beSentDataset['error'] = '該青少年正在開案中';
        }

        $this->load->view('/youth/end_youth', $beSentDataset);


      }

    }

    public function transfer_youth_table($youthNo = null) 
    {
      $passport = $this->session->userdata('passport');
      $userTitle = $passport['userTitle'];
      $current_role = $passport['role'];
      $accept_role = array(6);
      

      if (in_array($current_role, $accept_role)) {
        $county = $passport['county'];
        check_youth($youthNo, $county);
        if (empty($youthNo)) {
          return show_404();
        }

        $youths = $this->YouthModel->get_by_no($youthNo);

        $reviews = $this->ReviewModel->get_by_formName_and_formNo('transfer_youth', $youthNo);
        $statuses = $this->MenuModel->get_by_form_and_column('review', 'status');

        $beSentDataset = array(
            'title' => '青少年轉介申請清單',
            'url' => 'youth/transfer_youth/' . $youthNo,
            'role' => $current_role,
            'youth' => $youthNo,
            'userTitle' => $userTitle,
            'password' => $passport['password'],
            'updatePwd' => $passport['updatePwd'],
            'youths' => $youths,
            'reviews' => $reviews,
            'statuses' => $statuses
        );

        $this->load->view('/youth/transfer_youth_table', $beSentDataset);
      }

    }

    public function transfer_youth($youthNo = null, $no = null) 
    {
      $passport = $this->session->userdata('passport');
      $userTitle = $passport['userTitle'];
      $current_role = $passport['role'];
      $accept_role = array(6);
      

      if (in_array($current_role, $accept_role)) {
        
        if (empty($youthNo)) {
          return show_404();
        }

        $county = $passport['county'];
        check_youth($youthNo, $county);

        $youths = $this->YouthModel->get_by_no($youthNo);
        $counties = $this->CountyModel->get_all();

        $seasonalReviews = $this->SeasonalReviewModel->get_by_youth($youthNo);
        $reviews = $no ? $this->ReviewModel->get_by_no($no) : null;
        $statuses = $this->MenuModel->get_by_form_and_column('review', 'status');
        $trends = $this->MenuModel->get_by_form_and_column_order('seasonal_review', 'trend');

        $statusAgree = $this->MenuModel->get_no_resource_by_content('批准', 'review')->no;
        $statusWaiting = $this->MenuModel->get_no_resource_by_content('等待批准中', 'review')->no;
        $statusDisagree = $this->MenuModel->get_no_resource_by_content('未批准', 'review')->no;
        
        $beSentDataset = array(
            'title' => '青少年轉介申請清單',
            'url' => 'youth/transfer_youth/' . $youthNo . '/' . $no,
            'role' => $current_role,
            'youth' => $youthNo,
            'userTitle' => $userTitle,
            'password' => $passport['password'],
            'updatePwd' => $passport['updatePwd'],
            'youths' => $youths,
            'reviews' => $reviews,
            'statuses' => $statuses,
            'security' => $this->security,
            'seasonalReviews' => $seasonalReviews,
            'trends' => $trends,
            'county' => $county,
            'counties' => $counties
        );

        $updateValue = $this->security->xss_clean($this->input->post('updateValue'));
        $reason = $this->security->xss_clean($this->input->post('reason'));
        $reviewerRole = 3;
        $formName = 'transfer_youth';
        $updateColumn = 'county';
       

        if (empty($reason)) {
          return $this->load->view('/youth/transfer_youth', $beSentDataset);
        }

        $isMember = $this->MemberModel->is_member($youthNo);
        
        if (!$isMember) {
            if ($reviews) {
                return $this->load->view('/youth/transfer_youth', $beSentDataset);
            } else {
                $isExecuteSuccess = $this->ReviewModel->create_one(
                    $formName,
                    $youthNo,
                    $reviewerRole,
                    $statusWaiting,
                    $reason,
                    $updateColumn,
                    $updateValue,
                    $county
                );
                $no  = $isExecuteSuccess;
            }
            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
                redirect('youth/transfer_youth_table/' . $youthNo);
            } else {
                $beSentDataset['error'] = '新增失敗';
            }

            $reviews = $no ? $this->ReviewModel->get_by_no($no) : null;
            $beSentDataset['reviews'] = $reviews;
            $beSentDataset['url'] = '/youth/transfer_youth/' . $youthNo . '/' . $no;
        } else {
          $beSentDataset['error'] = '該青少年正在開案中';
        }

        $this->load->view('/youth/transfer_youth', $beSentDataset);
      }

    }  

    public function repeat_youth($county) {
      $passport = $this->session->userdata('passport');
      $userTitle = $passport['userTitle'];
      $current_role = $passport['role'];
      $accept_role = array(6);
      $county = $passport['county'] ? $passport['county'] : $county;
      $youths = $this->YouthModel->get_repeat_youth($county);
      $beSentDataset = array(
        'title' => '需關懷追蹤青少年清單（動向調查需政府介入者及高中職已錄取未註冊）',
        'url' => '/youth/get_all_youth_table/',
        'role' => $current_role,
        'youths' => $youths,
        'userTitle' => $userTitle,
        'current_role' => $current_role,
        'password' => $passport['password'],
        'updatePwd' => $passport['updatePwd']
      );

      $this->load->view('/repeat_youth', $beSentDataset);
    }

    public function repeat_youth_in($county, $no) {
      $passport = $this->session->userdata('passport');
      $userTitle = $passport['userTitle'];
      $current_role = $passport['role'];
      $accept_role = array(6);
      $name = $this->YouthModel->get_by_no($no)->name;
      $youths = $this->YouthModel->get_repeat_youth_in($county, $name);

      $this->load->model('UpdateRepeatOneModel');
      $this->load->model('UpdateRepeatTwoModel');

      $saveData = [];
      $saveData['guardianName'] = $saveData['sourceSchoolYear'] = $saveData['surveyType'] = $saveData['no'] = '';
      $twoNo ='';
      foreach($youths as $value) {
        if($value['source'] == 194) {
          $saveData['guardianName'] = $value['guardian_name'];
          $saveData['sourceSchoolYear'] = $value['source_school_year'];
          $saveData['surveyType'] = $value['survey_type'];
          $saveData['no'] = $value['no'];
        } else {
          $twoNo = $value['no'];
        }
      }

      $beSentDataset = array(
        'title' => '需關懷追蹤青少年清單（動向調查需政府介入者及高中職已錄取未註冊）',
        'url' => '/youth/repeat_youth_in/' . $county . '/' . $no,
        'role' => $current_role,
        'youths' => $youths,
        'userTitle' => $userTitle,
        'current_role' => $current_role,
        'password' => $passport['password'],
        'updatePwd' => $passport['updatePwd'],
        'security' => $this->security
      );

      if (isset($_POST['save'])) {
        $one = $this->UpdateRepeatOneModel->update_by_youth($county, $saveData['no']);
        $two = $this->UpdateRepeatTwoModel->update_by_youth($county, $twoNo, $saveData['guardianName'], $saveData['sourceSchoolYear'], $saveData['surveyType']); 
        
        if($one & $two){
          redirect('youth/repeat_youth/' . $county);
        }
      }

      $this->load->view('/repeat_youth_in', $beSentDataset);
    }

   
}
