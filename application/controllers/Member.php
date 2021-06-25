<?php
class Member extends CI_Controller
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
        $this->load->model('FileModel');
        $this->load->model('SeasonalReviewModel');
        $this->load->model('IndividualCounselingModel');
        $this->load->model('GroupCounselingModel');
        $this->load->model('GroupCounselingParticipantsModel');
        $this->load->model('CourseAttendanceModel');
        $this->load->model('WorkAttendanceModel');
        $this->load->model('EndCaseModel');
        $this->load->model('CompletionModel');
        $this->load->model('MonthReviewModel');
        $this->load->model('ReviewModel');
        $this->load->model('OrganizationModel');
        $this->load->model('InsuranceModel');
    }

    public function get_member_table_by_counselor($county = 1,$yearType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $counselor = $passport['counselor'];
            $organization = $passport['organization'];

            $years = $this->MemberModel->get_year_by_organization($organization);

            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }

            $members = $this->MemberModel->get_by_conselor($counselor, $yearType);

            $endCases = $this->EndCaseModel->get_by_counselor($counselor);

            $beSentDataset = array(
                'title' => '開案學員清單',
                'url' => '/member/get_member_table_by_counselor',
                'role' => $current_role,
                'members' => $members,
                'endCases' => $endCases,
                'yearType' => $yearType,
                'years' => $years,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'county' => $county
            );

            $this->load->view('/member/member_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function get_member_table_by_county($county = 22,$yearType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(2, 3,9);
        if (in_array($current_role, $accept_role)) {
            $county = $passport['county'] ? $passport['county'] : $county;
            $counties = $this->CountyModel->get_all();

            $years = $this->MemberModel->get_year_by_county($county);

            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }

            $members = $this->MemberModel->get_by_county($county, $yearType);

            $beSentDataset = array(
                'title' => '開案學員清單',
                'url' => '/member/get_member_table_by_county',
                'role' => $current_role,
                'members' => $members,
                'yearType' => $yearType,
                'years' => $years,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'counties' => $counties,
                'county' => $county
            );

            $this->load->view('/member/member_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function get_member_table_by_organization($county = 1,$yearType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(4, 5);
        if (in_array($current_role, $accept_role)) {
            $organization = $passport['organization'];
            $county = $passport['county'];

            $years = $this->MemberModel->get_year_by_organization($organization);

            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }

            $members = $this->MemberModel->get_by_county($county, $yearType);

            $beSentDataset = array(
                'title' => '開案學員清單',
                'url' => '/member/get_member_table_by_organization',
                'role' => $current_role,
                'members' => $members,
                'yearType' => $yearType,
                'years' => $years,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'county' => $county
            );

            if ($current_role == 5) {
                $reviews = $this->ReviewModel->get_by_county($county, $current_role);
                $beSentDataset['reviews'] = $reviews;

            }

            $this->load->view('/member/member_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function individual_counseling($memberNo = null, $no = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $county = $passport['county'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            if (empty($memberNo)) {
                return show_404();
            }
            check_member($memberNo, $county);
            $individualCounselings = $no ? $this->IndividualCounselingModel->get_by_no($no) : null;
            $members = $this->MemberModel->get_by_no($memberNo);
            $hasDelegation = $this->ProjectModel->get_has_delegation_by_member($memberNo)->has_delegation;

            $memberName = $members->name;
            $memberSystemNo = $members->system_no;
            $serviceTypes = $this->MenuModel->get_by_form_and_column('individual_counseling', 'service_type');
            $serviceWays = $this->MenuModel->get_by_form_and_column('individual_counseling', 'service_way_member');
            $referralResources = $this->MenuModel->get_by_form_and_column('individual_counseling', 'referral_resource');

            $counselor = $passport['counselor'];
            $beSentDataset = array(
                'title' => '個別諮詢紀錄表',
                'url' => '/member/individual_counseling/' . $memberNo . '/' . $no,
                'memberNo' => $memberNo,
                'role' => $current_role,
                'memberSystemNo' => $memberSystemNo,
                'memberName' => $memberName,
                'serviceTypes' => $serviceTypes,
                'serviceWays' => $serviceWays,
                'referralResources' => $referralResources,
                'individualCounselings' => $individualCounselings,
                'userTitle' => $userTitle,
                'hasDelegation' => $hasDelegation,
                'security' => $this->security,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $startTime = $this->security->xss_clean($this->input->post('startTime'));
            $endTime = $this->security->xss_clean($this->input->post('endTime'));
            // $durationHour = $this->security->xss_clean($this->input->post('durationHour'));
            $serviceType = $this->security->xss_clean($this->input->post('serviceType'));
            $serviceWay = $this->security->xss_clean($this->input->post('serviceWay'));
            $referralResource = $this->security->xss_clean($this->input->post('referralResource'));
            $referralDescription = $this->security->xss_clean($this->input->post('referralDescription'));
            $serviceTarget = $this->security->xss_clean($this->input->post('serviceTarget'));
            $serviceContent = $this->security->xss_clean($this->input->post('serviceContent'));
            $futurePlan = $this->security->xss_clean($this->input->post('futurePlan'));

            if (empty($startTime) || empty($endTime)) {
                return $this->load->view('/member/individual_counseling', $beSentDataset);
            }

            if (strtotime($startTime) >= strtotime($endTime)) {
                $beSentDataset['error'] = "開始時間不可大於或等於結束時間";
                return $this->load->view('/member/individual_counseling', $beSentDataset);
            } else {
                // 以小時為單位
                $durationHour = (strtotime($endTime) - strtotime($startTime)) / 3600;
            }

            if (empty($individualCounselings)) {
                $isExecuteSuccess = $this->IndividualCounselingModel->create_one($counselor, $memberNo,
                    $startTime, $endTime, $durationHour, $serviceType, $serviceWay, $referralResource,
                    $referralDescription, $serviceTarget, $serviceContent, $futurePlan);
                $no = $isExecuteSuccess;

                $individualCounselingArray = array($counselor, $memberNo,
                    $startTime, $endTime, $durationHour, $serviceType, $serviceTarget, $serviceContent, $futurePlan);

                $individualCounselingNum = 0;
                foreach ($individualCounselingArray as $value) {
                    if ($value != null) {
                        $individualCounselingNum++;
                    }
                }

                $individualCounselingRate = round($individualCounselingNum / count($individualCounselingArray), 2) * 100;
                $individualCounselingSuccess = $this->CompletionModel->create_one('individual_counseling', $no, $individualCounselingRate);
            } else {
                $isExecuteSuccess = $this->IndividualCounselingModel->update_by_no($counselor, $memberNo,
                    $startTime, $endTime, $durationHour, $serviceType, $serviceWay, $referralResource,
                    $referralDescription, $serviceTarget, $serviceContent, $futurePlan, $no);

                $individualCounselingArray = array($counselor, $memberNo,
                    $startTime, $endTime, $durationHour, $serviceType, $serviceTarget, $serviceContent, $futurePlan);

                $individualCounselingNum = 0;
                foreach ($individualCounselingArray as $value) {
                    if ($value != null) {
                        $individualCounselingNum++;
                    }
                }

                $individualCounselingRate = round($individualCounselingNum / count($individualCounselingArray), 2) * 100;
                $individualCounselingSuccess = $this->CompletionModel->update_one('individual_counseling', $no, $individualCounselingRate);
            }

            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
                redirect('member/get_individual_counseling_table_by_member/' . $memberNo);
            } else {
                $beSentDataset['error'] = '新增失敗';
            }

            $individualCounselings = $no ? $this->IndividualCounselingModel->get_by_no($no) : null;
            $beSentDataset['individualCounselings'] = $individualCounselings;
            $beSentDataset['url'] = '/member/individual_counseling/' . $memberNo . '/' . $no;

            $this->load->view('/member/individual_counseling', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function get_individual_counseling_table_by_member($member = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $county = $passport['county'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            if (empty($member)) {
                return show_404();
            }
            check_member($member, $county);

            $individualCounselings = $this->IndividualCounselingModel->get_by_member($member);
            $individualCounselingCompletions = $this->CompletionModel->get_rate_by_form_name('individual_counseling');
            $hasDelegation = $this->ProjectModel->get_has_delegation_by_member($member)->has_delegation;
            $members = $this->MemberModel->get_by_no($member);

            $beSentDataset = array(
                'title' => '個別輔導諮詢清單',
                'url' => '/member/individual_counseling/' . $member,
                'role' => $current_role,
                'members' => $member,
                'individualCounselingCompletions' => $individualCounselingCompletions,
                'individualCounselings' => $individualCounselings,
                'userTitle' => $userTitle,
                'hasDelegation' => $hasDelegation,
                'password' => $passport['password'],
                'members' => $members,
                'updatePwd' => $passport['updatePwd']
            );

            $this->load->view('/member/individual_counseling_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function case_assessment($member = null, $isContinue = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $county = $passport['county'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            check_member($member, $county);
            if ($isContinue) {
                $identification = $this->MemberModel->get_by_member($member)->identification;
                $oldMember = $this->MemberModel->get_by_identification($identification)->no;
                $caseAssessments = $this->CaseAssessmentModel->get_by_member($oldMember);
            } else {
                $caseAssessments = $member ? $this->CaseAssessmentModel->get_by_member_temp($member) : null;
            }
            $hasDelegation = $this->ProjectModel->get_has_delegation_by_member($member)->has_delegation;

            $interviewWays = $this->MenuModel->get_by_form_and_column('case_assessment', 'interview_way');
            $educations = $this->MenuModel->get_by_form_and_column('case_assessment', 'education');
            $sources = $this->MenuModel->get_by_form_and_column('case_assessment', 'source');
            $backgrounds = $this->MenuModel->get_by_form_and_column('case_assessment', 'background');
            $transportations = $this->MenuModel->get_by_form_and_column('case_assessment', 'transportation');
            $teacherInteractivePatterns = $this->MenuModel->get_by_form_and_column('case_assessment', 'teacher_interactive_pattern');
            $peerInteractivePatterns = $this->MenuModel->get_by_form_and_column('case_assessment', 'peer_interactive_pattern');
            $academicPerformances = $this->MenuModel->get_by_form_and_column('case_assessment', 'academic_performance');
            $issues = $this->MenuModel->get_by_form_and_column('case_assessment', 'issue');
            $counselWays = $this->MenuModel->get_by_form_and_column('case_assessment', 'counsel_way');
            $statuses = $this->MenuModel->get_by_form_and_column('review', 'status');

            $county = $passport['county'];
            $project = $this->ProjectModel->get_latest_by_county($county)->no;

            $statusWaiting = $this->MenuModel->get_no_resource_by_content('等待批准中', 'review')->no;
            $reviews = $this->ReviewModel->get_by_case_assessment($member, $statusWaiting);
            $members = $this->MemberModel->get_by_no($member);
            $youths = $this->YouthModel->get_by_no($members->youth);

            $age = 0;
            if(empty($youths->birth) || (substr($youths->birth, 0, 4) == 1911) ) {
              $age = 0;
            } else {
              $age = intval((strtotime(date("Y-m-d")) - strtotime($youths->birth) ) /3600/24/365 );
            }

            $educationAgeArray = [];

            foreach($educations as $value) {
              if($value['content'] == '中輟滿16歲未升學未就業') {
                if($age>=16) array_push($educationAgeArray, $value);
              } 
              
              if($value['content'] == '國中畢業未升學未就業(應屆畢業)') {
                if(( strtotime($youths->birth) >= strtotime((date("Y")-16) . "-09-01")) && ( strtotime($youths->birth) <= strtotime((date("Y")-15) . "-09-01"))) array_push($educationAgeArray, $value);        
              } 
              
              if($value['content'] == '國中畢業未升學未就業(非應屆畢業)') {
                if($age>=15) array_push($educationAgeArray, $value);
              }

              if($value['content'] == '高中中離(一年級)') {
                if($age>=15) array_push($educationAgeArray, $value);
              }

              if($value['content'] == '高中中離(二年級)') {
                if($age>=15) array_push($educationAgeArray, $value);
              }

              if($value['content'] == '高中中離(三年級)') {
                if($age>=15) array_push($educationAgeArray, $value);
              }        
            }

            $beSentDataset = array(
                'title' => '開案學員資料表',
                'url' => '/member/case_assessment/' . $member,
                'role' => $current_role,
                'interviewWays' => $interviewWays,
                'educations' => $educations,
                'sources' => $sources,
                'backgrounds' => $backgrounds,
                'transportations' => $transportations,
                'teacherInteractivePatterns' => $teacherInteractivePatterns,
                'peerInteractivePatterns' => $peerInteractivePatterns,
                'academicPerformances' => $academicPerformances,
                'issues' => $issues,
                'counselWays' => $counselWays,
                'caseAssessments' => $caseAssessments,
                'userTitle' => $userTitle,
                'hasDelegation' => $hasDelegation,
                'security' => $this->security,
                'reviews' => $reviews,
                'statuses' => $statuses,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'members' => $members,
                'educationAgeArray' => $educationAgeArray,
                'age' => $age
            );

            $counselor = $passport['counselor'];

            // get data from frontend
            $interviewDate = $this->security->xss_clean($this->input->post('interviewDate'));
            $interviewWay = $this->security->xss_clean($this->input->post('interviewWay'));
            $interviewPlace = $this->security->xss_clean($this->input->post('interviewPlace'));
            $education = $this->security->xss_clean($this->input->post('education'));
            $source = $this->security->xss_clean($this->input->post('source'));
            $sourceOther = $this->security->xss_clean($this->input->post('sourceOther'));
            $surveyYear = $this->security->xss_clean($this->input->post('surveyYear'));
            $background = $this->input->post('background') ? implode(",", $this->security->xss_clean($this->input->post('background'))) : null;
            $backgroundOther = $this->security->xss_clean($this->input->post('backgroundOther'));
            $appearanceHabits = $this->security->xss_clean($this->input->post('appearanceHabits'));
            $majorSetback = $this->security->xss_clean($this->input->post('majorSetback'));
            $interestPlan = $this->security->xss_clean($this->input->post('interestPlan'));
            $interactiveExperience = $this->security->xss_clean($this->input->post('interactiveExperience'));
            $transportation = $this->input->post('transportation') ? implode(",", $this->security->xss_clean($this->input->post('transportation'))) : null;
            $transportationOther = $this->security->xss_clean($this->input->post('transportationOther'));
            $medicalSupport = $this->security->xss_clean($this->input->post('medicalSupport'));
            $medicalReason = $this->security->xss_clean($this->input->post('medicalReason'));
            $familyMember = $this->security->xss_clean($this->input->post('familyMember'));
            $familyInteractivePattern = $this->security->xss_clean($this->input->post('familyInteractivePattern'));
            $communityInteractivePattern = $this->security->xss_clean($this->input->post('communityInteractivePattern'));
            $familyMajorSetback = $this->security->xss_clean($this->input->post('familyMajorSetback'));
            $familyOtherSetback = $this->security->xss_clean($this->input->post('familyOtherSetback'));
            $schoolHistory = $this->security->xss_clean($this->input->post('schoolHistory'));
            $teacherInteractivePattern = $this->security->xss_clean($this->input->post('teacherInteractivePattern'));
            $teacherBadReason = $this->security->xss_clean($this->input->post('teacherBadReason'));
            $peerInteractivePattern = $this->security->xss_clean($this->input->post('peerInteractivePattern'));
            $peerBadReason = $this->security->xss_clean($this->input->post('peerBadReason'));
            $academicPerformance = $this->security->xss_clean($this->input->post('academicPerformance'));
            $interestSubject = $this->security->xss_clean($this->input->post('interestSubject'));
            $violation = $this->security->xss_clean($this->input->post('violation'));
            $violationDescription = $this->security->xss_clean($this->input->post('violationDescription'));
            $welfareSupport = $this->security->xss_clean($this->input->post('welfareSupport'));
            $welfareAmount = $this->security->xss_clean($this->input->post('welfareAmount'));
            $welfareSource = $this->security->xss_clean($this->input->post('welfareSource'));
            $eventSource = $this->security->xss_clean($this->input->post('eventSource'));
            $eventDescription = $this->security->xss_clean($this->input->post('eventDescription'));
            $servingSource = $this->security->xss_clean($this->input->post('servingSource'));
            $servingInstitution = $this->security->xss_clean($this->input->post('servingInstitution'));
            $servingProfessional = $this->security->xss_clean($this->input->post('servingProfessional'));
            $servingPhone = $this->security->xss_clean($this->input->post('servingPhone'));
            $issue = $this->security->xss_clean($this->input->post('issue')) ? implode(",", $this->security->xss_clean($this->input->post('issue'))) : null;
            $issueOther = $this->security->xss_clean($this->input->post('issueOther'));
            $counselWay = $this->input->post('counselWay') ? implode(",", $this->security->xss_clean($this->input->post('counselWay'))) : null;
            $counselWayOther = $this->security->xss_clean($this->input->post('counselWayOther'));
            $counselTarget = $this->security->xss_clean($this->input->post('counselTarget'));
            $familyDiagram = $caseAssessments ? $caseAssessments->family_diagram : null;
            $representativeAgreement = $caseAssessments ? $caseAssessments->representative_agreement : null;

            if (empty($interviewDate)) {
                return $this->load->view('/member/case_assessment', $beSentDataset);
            }

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
            if ($this->upload->do_upload('familyDiagram')) {
                $fileMetaData = $this->upload->data();
                $familyDiagram = $this->FileModel->create_one($member, $fileMetaData['file_name'], $fileMetaData['orig_name']);
            }

            // upload representative agreement
            if ($this->upload->do_upload('representativeAgreement')) {
                $fileMetaData = $this->upload->data();
                $representativeAgreement = $this->FileModel->create_one($member, $fileMetaData['file_name'], $fileMetaData['orig_name']);
            }

            if ($member && $interviewDate && $interviewWay && $education && $source && $background && $appearanceHabits &&
                $majorSetback && $interestPlan && $interactiveExperience && $transportation &&
                $familyMember && $familyInteractivePattern && $communityInteractivePattern &&
                $schoolHistory && $teacherInteractivePattern && $teacherBadReason && $peerInteractivePattern && $peerBadReason &&
                $academicPerformance && $interestSubject && $issue && $counselWay && $counselTarget && $familyDiagram && $representativeAgreement && $counselor) {

                $isExecuteSuccess = $this->CaseAssessmentModel->update_by_youth($member, $interviewDate, $interviewWay, $interviewPlace, $education, $source, $sourceOther,
                    $surveyYear, $background, $backgroundOther, $appearanceHabits, $majorSetback, $interestPlan, $interactiveExperience,
                    $transportation, $transportationOther, $medicalSupport, $medicalReason, $familyMember,
                    $familyInteractivePattern, $communityInteractivePattern, $familyMajorSetback, $familyOtherSetback,
                    $schoolHistory, $teacherInteractivePattern, $teacherBadReason, $peerInteractivePattern, $peerBadReason,
                    $academicPerformance, $interestSubject, $violation, $violationDescription, $welfareSupport,
                    $welfareAmount, $welfareSource, $eventSource, $eventDescription, $servingSource, $servingInstitution,
                    $servingProfessional, $servingPhone, $issue, $issueOther, $counselWay, $counselWayOther, $counselTarget, $familyDiagram, $representativeAgreement, $counselor);

                $caseAssessmentArray = array($member, $interviewDate, $interviewWay, $education, $source,
                    $surveyYear, $background, $appearanceHabits, $majorSetback, $interestPlan, $interactiveExperience,
                    $transportation, $medicalSupport, $familyMember,
                    $familyInteractivePattern, $communityInteractivePattern, $familyMajorSetback, $familyOtherSetback,
                    $schoolHistory, $teacherInteractivePattern, $teacherBadReason, $peerInteractivePattern, $peerBadReason,
                    $academicPerformance, $interestSubject, $violation, $issue, $issueOther, $counselWay, $counselTarget, $familyDiagram, $representativeAgreement, $counselor);

                $caseAssessmentNum = 0;
                foreach ($caseAssessmentArray as $value) {
                    if ($value != null || $value == 0) {
                        $caseAssessmentNum++;
                    }
                }

                $caseAssessmentRate = round($caseAssessmentNum / count($caseAssessmentArray), 2) * 100;
                $caseAssessmentCompletionSuccess = $this->CompletionModel->update_one('case_assessment', $member, $caseAssessmentRate);
            }

            $isExecuteSuccess = $this->CaseAssessmentModel->update_by_youth_temp($member, $interviewDate, $interviewWay, $interviewPlace, $education, $source, $sourceOther,
                $surveyYear, $background, $backgroundOther, $appearanceHabits, $majorSetback, $interestPlan, $interactiveExperience,
                $transportation, $transportationOther, $medicalSupport, $medicalReason, $familyMember,
                $familyInteractivePattern, $communityInteractivePattern, $familyMajorSetback, $familyOtherSetback,
                $schoolHistory, $teacherInteractivePattern, $teacherBadReason, $peerInteractivePattern, $peerBadReason,
                $academicPerformance, $interestSubject, $violation, $violationDescription, $welfareSupport,
                $welfareAmount, $welfareSource, $eventSource, $eventDescription, $servingSource, $servingInstitution,
                $servingProfessional, $servingPhone, $issue, $issueOther, $counselWay, $counselWayOther, $counselTarget, $familyDiagram, $representativeAgreement, $counselor);

            if ($member && $isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
            } else {
                $beSentDataset['error'] = '新增失敗';
            }

            $caseAssessments = $member ? $this->CaseAssessmentModel->get_by_member_temp($member) : null;

            $beSentDataset['caseAssessments'] = $caseAssessments;
            $beSentDataset['url'] = '/member/case_assessment/' . $member;

            $this->load->view('/member/case_assessment', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function get_group_counseling_table_by_member($member = null, $yearType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $county = $passport['county'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            if (empty($member)) {
                return show_404();
            }
            check_member($member, $county);
            $organization = $passport['organization'];
            $years = $this->MemberModel->get_year_by_organization($organization);

            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }

            $groupCounselings = $this->GroupCounselingModel->get_by_member($member, $yearType);
            $groupCounselingCompletions = $this->CompletionModel->get_rate_by_form_name('group_counseling');
            $hasDelegation = $this->ProjectModel->get_has_delegation_by_member($member)->has_delegation;
            $beSentDataset = array(
                'title' => '團體輔導紀錄表',
                'url' => 'member/group_counseling/' . $member,
                'role' => $current_role,
                'members' => $member,
                'groupCounselings' => $groupCounselings,
                'groupCounselingCompletions' => $groupCounselingCompletions,
                'userTitle' => $userTitle,
                'hasDelegation' => $hasDelegation,
                'yearType' => $yearType,
                'years' => $years,
                'canInsert' => '0',
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $this->load->view('/member/group_counseling_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function get_group_counseling_table_by_organization($yearType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(6);

        if (in_array($current_role, $accept_role)) {
            $organization = $passport['organization'];

            $years = $this->MemberModel->get_year_by_organization($organization);

            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }

            $hasDelegation = ($yearType == date("Y") - 1911) ? '1' : '0';

            $groupCounselings = $this->GroupCounselingModel->get_by_organization($organization, $yearType);
            $groupCounselingCompletions = $this->CompletionModel->get_rate_by_form_name('group_counseling');

            $beSentDataset = array(
                'title' => '團體輔導紀錄清單',
                'url' => 'member/group_counseling_participants/',
                'role' => $current_role,
                'groupCounselings' => $groupCounselings,
                'groupCounselingCompletions' => $groupCounselingCompletions,
                'yearType' => $yearType,
                'years' => $years,
                'userTitle' => $userTitle,
                'hasDelegation' => $hasDelegation,
                'canInsert' => '1',
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $this->load->view('/member/group_counseling_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function group_counseling_participants($no = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {

            $groupCounseling = $no;
            $counselor = $passport['counselor'];
            $organization = $passport['organization'];

            $participantArray = [];
            $participantRecord = $no ? $this->GroupCounselingModel->get_participants_by_group_counseling($no) : null;
            if (!empty($participantRecord)) {
                foreach ($participantRecord as $i) {
                    array_push($participantArray, $i['member']);
                }
            }

            $members = $this->MemberModel->get_by_organization_course_work($organization);

            $beSentDataset = array(
                'title' => '團體輔導紀錄表',
                'url' => '/member/group_counseling_participants/' . $no,
                'role' => $current_role,
                'members' => $members,
                'participantArray' => $participantArray,
                'userTitle' => $userTitle,
                'security' => $this->security,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $participants = $this->security->xss_clean($this->input->post('participants'));

            if (empty($participants)) {
                return $this->load->view('/member/group_counseling_participants', $beSentDataset);
            }

            if (empty($no)) {
                $groupCounseling = $this->GroupCounselingModel->create_one(null);
                $groupCounselingCompletionSuccess = $this->CompletionModel->create_one('group_counseling', $groupCounseling, 5);
                foreach ($participants as $i) {
                    $isExecuteSuccess = $this->GroupCounselingParticipantsModel->create_one($groupCounseling, $counselor, $i);
                }
            } else {
                foreach ($participants as $i) {
                    $is_checked = 0;
                    foreach ($participantArray as $p) {
                        // 是否為已勾選的學員
                        if ($p == $i) {
                            $is_checked++;
                        }
                    }
                    if ($is_checked == 0) {
                        $isExecuteSuccess = $this->GroupCounselingParticipantsModel->create_one($groupCounseling, $counselor, $i);
                    }
                }

            }

            if ($isExecuteSuccess) {
                redirect('member/group_counseling/' . $groupCounseling);
            }
        } else {
            redirect('user/login');
        }
    }

    public function group_counseling($no = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $county = $passport['county'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            if (empty($no)) {
                return show_404();
            }
            $groupCounselings = $this->GroupCounselingModel->get_by_no($no);
            $participants = $this->GroupCounselingParticipantsModel->get_by_group_counseling($no);
            foreach($participants as $value) {
              check_member($value['member'], $county);
            }

            $serviceTargets = $this->MenuModel->get_by_form_and_column('group_counseling', 'service_target');

            $counselor = $passport['counselor'];

            $hasDelegation = $this->ProjectModel->get_has_delegation_by_member($participants[0]['member'])->has_delegation;

            $beSentDataset = array(
                'title' => '團體輔導紀錄表',
                'url' => '/member/group_counseling/' . $no,
                'role' => $current_role,
                'serviceTargets' => $serviceTargets,
                'groupCounselings' => $groupCounselings,
                'participants' => $participants,
                'userTitle' => $userTitle,
                'hasDelegation' => $hasDelegation,
                'security' => $this->security,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $title = $this->security->xss_clean($this->input->post('title'));
            $startTime = $this->security->xss_clean($this->input->post('startTime'));
            $endTime = $this->security->xss_clean($this->input->post('endTime'));
            //$durationHour = $this->security->xss_clean($this->input->post('durationHour'));
            $serviceTarget = $this->security->xss_clean($this->input->post('serviceTarget'));
            $serviceTargetOther = $this->security->xss_clean($this->input->post('serviceTargetOther'));

            $isPunctual = $this->security->xss_clean($this->input->post('isPunctual'));
            $participationLevel = $this->security->xss_clean($this->input->post('participationLevel'));
            $descriptionOther = $this->security->xss_clean($this->input->post('descriptionOther'));

            $importantEvent = $this->security->xss_clean($this->input->post('importantEvent'));
            $evaluation = $this->security->xss_clean($this->input->post('evaluation'));
            $review = $this->security->xss_clean($this->input->post('review'));

            if (empty($startTime) || empty($endTime)) {
                return $this->load->view('/member/group_counseling', $beSentDataset);
            }

            if (strtotime($startTime) >= strtotime($endTime)) {
                $beSentDataset['error'] = "開始時間不可大於或等於結束時間";
                return $this->load->view('/member/group_counseling', $beSentDataset);
            } else {
                // 以小時為單位
                $durationHour = (strtotime($endTime) - strtotime($startTime)) / 3600;
            }

            $isExecuteSuccess = $this->GroupCounselingModel->update_by_no($title, $startTime, $endTime,
                $durationHour, $serviceTarget, $serviceTargetOther,
                $importantEvent, $evaluation, $review, $no);

            $groupCounselingArray = array($title, $startTime, $endTime,
                $durationHour, $serviceTarget,
                $importantEvent, $evaluation, $review, $no);

            $groupCounselingNum = 0;
            foreach ($groupCounselingArray as $value) {
                if ($value != null) {
                    $groupCounselingNum++;
                }
            }

            $groupCounselingRate = round($groupCounselingNum / count($groupCounselingArray), 2) * 100;
            $groupCounselingCompletionSuccess = $this->CompletionModel->update_one('group_counseling', $no, $groupCounselingRate);

            $temp_count = 0;
            foreach ($participants as $i) {
                $isExecuteSuccess = $this->GroupCounselingParticipantsModel->update_by_member($no, $counselor, $i['member'],
                    $isPunctual[$temp_count], $participationLevel[$temp_count], $descriptionOther[$temp_count]);

                $temp_count++;
            }

            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
                redirect('member/get_group_counseling_table_by_organization/');
            } else {
                $beSentDataset['error'] = '新增失敗';
            }

            $groupCounselings = $this->GroupCounselingModel->get_by_no($no);
            $participants = $this->GroupCounselingParticipantsModel->get_by_group_counseling($no);

            $beSentDataset['groupCounselings'] = $groupCounselings;
            $beSentDataset['participants'] = $participants;
            $beSentDataset['url'] = '/member/group_counseling/' . '/' . $no;

            $this->load->view('/member/group_counseling', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function group_counseling_participants_delete($group_counseling_participants_id = null, $groupCounseling = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            if (empty($group_counseling_participants_id)) {
                return show_404();
            }
            $is_delete_success = $this->GroupCounselingParticipantsModel->delete_participant_by_group_counseling_id($group_counseling_participants_id);
            if ($is_delete_success) {
                redirect('member/group_counseling/' . $groupCounseling);
            } else {
                echo "刪除失敗";
            }
        }
    }

    public function end_case($member = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $county = $passport['county'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            check_member($member, $county);
            $endCases = $member ? $this->EndCaseModel->get_by_member($member) : null;

            $educationSourceNumber = $this->MenuModel->get_referral_resource_by_content('教育資源')->no;
            $laborSourceNumber = $this->MenuModel->get_referral_resource_by_content('勞政資源')->no;
            $socialSourceNumber = $this->MenuModel->get_referral_resource_by_content('社政資源')->no;
            $healthSourceNumber = $this->MenuModel->get_referral_resource_by_content('衛政資源')->no;
            $officeSourceNumber = $this->MenuModel->get_referral_resource_by_content('警政資源')->no;
            $judicialSourceNumber = $this->MenuModel->get_referral_resource_by_content('司法資源')->no;
            $otherSourceNumber = $this->MenuModel->get_referral_resource_by_content('其他資源')->no;

            $trends = $this->MenuModel->get_by_form_and_column('end_case', 'trend');
            $juniorSchoolConditions = $this->MenuModel->get_by_form_and_column('youth', 'junior_school_condition');
            $seniorSchoolConditions = $this->MenuModel->get_by_form_and_column('youth', 'senior_school_condition');
            $sources = $this->MenuModel->get_by_form_and_column('case_assessment', 'source');
            $categorys = $this->MenuModel->get_by_form_and_column('company', 'category');
            $counselIdentitys = $this->MenuModel->get_by_form_and_column('youth', 'counsel_identity');

            $youths = $this->MemberModel->get_by_member($member);
            $caseAssessments = $member ? $this->CaseAssessmentModel->get_by_member($member) : null;
            $groupCounselingHour = $this->GroupCounselingParticipantsModel->get_group_counseling_hour_by_member($member)->groupCounselingHour;
            $individualCounselingHour = $this->IndividualCounselingModel->get_individual_counseling_hour_by_member($member)->individualCounselingHour;
            $counselingHour = $groupCounselingHour + $individualCounselingHour;
            $courseAttendanceHour = $this->CourseAttendanceModel->get_course_attendance_hour_by_member($member)->courseAttendanceHour;
            $workAttendances = $this->WorkAttendanceModel->get_work_attendance_by_member($member);
            $workAttendanceHour = $this->WorkAttendanceModel->get_work_attendance_hour_by_member($member)->workAttendanceHour;

            $educationSourceHour = $this->IndividualCounselingModel->get_referral_source_hour_by_member($member, $educationSourceNumber)->referralResourceHour;
            $laborSourceHour = $this->IndividualCounselingModel->get_referral_source_hour_by_member($member, $laborSourceNumber)->referralResourceHour;
            $socialSourceHour = $this->IndividualCounselingModel->get_referral_source_hour_by_member($member, $socialSourceNumber)->referralResourceHour;
            $healthSourceHour = $this->IndividualCounselingModel->get_referral_source_hour_by_member($member, $healthSourceNumber)->referralResourceHour;
            $officeSourceHour = $this->IndividualCounselingModel->get_referral_source_hour_by_member($member, $officeSourceNumber)->referralResourceHour;
            $judicialSourceHour = $this->IndividualCounselingModel->get_referral_source_hour_by_member($member, $judicialSourceNumber)->referralResourceHour;
            $otherSourceHour = $this->IndividualCounselingModel->get_referral_source_hour_by_member($member, $otherSourceNumber)->referralResourceHour;

            $county = $passport['county'];
            $project = $this->ProjectModel->get_latest_by_county($county)->no;

            $hasDelegation = $this->ProjectModel->get_has_delegation_by_member($member)->has_delegation;

            $youthCompletion = $this->CompletionModel->get_rate_by_form_no('youth', $youths->no);
            $intakeCompletion = $this->CompletionModel->get_rate_by_form_no('intake', $youths->no);
            $caseAssessmentCompletion = $this->CompletionModel->get_rate_by_form_no('case_assessment', $member);

            $individualCounselingCompletions = [];
            $individualCounselings = $this->IndividualCounselingModel->get_by_member($member);
            foreach ($individualCounselings as $value) {
                $individualCounselingCompletion = $this->CompletionModel->get_rate_by_form_no('individual_counseling', $value['no']);
                if (!empty($individualCounselingCompletion)) {
                    array_push($individualCounselingCompletions, $individualCounselingCompletion->rate);
                }
            }

            $groupCounselingCompletions = [];
            $groupCounselings = $this->GroupCounselingModel->get_by_member($member, date("Y") - 1911);
            foreach ($groupCounselings as $value) {
                $groupCounselingCompletion = $this->CompletionModel->get_rate_by_form_no('group_counseling', $value['no']);
                if (!empty($groupCounselingCompletion)) {
                    array_push($groupCounselingCompletions, $groupCounselingCompletion->rate);
                }
            }

            $youthRate = $youthCompletion ? $youthCompletion->rate : null;
            $intakeRate = $intakeCompletion ? $intakeCompletion->rate : null;
            $caseAssessmentRate = $caseAssessmentCompletion ? $caseAssessmentCompletion->rate : null;
            $individualCounselingRate = '100';
            $groupCounselingRate = '100';
            foreach ($individualCounselingCompletions as $value) {
                if (!empty($value)) {
                    if ($value != '100') {
                        $individualCounselingRate = $value;
                        break;
                    } else {
                        $individualCounselingRate = $value;
                    }
                } else {
                    $individualCounselingRate = '100';
                }
            }

            foreach ($groupCounselingCompletions as $value) {
                if (!empty($value)) {
                    if ($value != '100') {
                        $groupCounselingRate = $value;
                        break;
                    } else {
                        $groupCounselingRate = $value;
                    }
                } else {
                    $groupCounselingRate = '100';
                }
            }

            $beSentDataset = array(
                'title' => '結案評估表',
                'url' => '/member/end_case/' . $member,
                'role' => $current_role,
                'member' => $member,
                'trends' => $trends,
                'juniorSchoolConditions' => $juniorSchoolConditions,
                'seniorSchoolConditions' => $seniorSchoolConditions,
                'sources' => $sources,
                'counselIdentitys' => $counselIdentitys,
                'categorys' => $categorys,
                'groupCounselingHour' => $groupCounselingHour,
                'individualCounselingHour' => $individualCounselingHour,
                'counselingHour' => $counselingHour,
                'courseAttendanceHour' => $courseAttendanceHour,
                'workAttendances' => $workAttendances,
                'workAttendanceHour' => $workAttendanceHour,
                'educationSourceHour' => $educationSourceHour,
                'laborSourceHour' => $laborSourceHour,
                'socialSourceHour' => $socialSourceHour,
                'healthSourceHour' => $healthSourceHour,
                'officeSourceHour' => $officeSourceHour,
                'judicialSourceHour' => $judicialSourceHour,
                'otherSourceHour' => $otherSourceHour,
                'youths' => $youths,
                'caseAssessments' => $caseAssessments,
                'endCases' => $endCases,
                'userTitle' => $userTitle,
                'hasDelegation' => $hasDelegation,
                'security' => $this->security,
                'youthRate' => $youthRate,
                'intakeRate' => $intakeRate,
                'caseAssessmentRate' => $caseAssessmentRate,
                'individualCounselingRate' => $individualCounselingRate,
                'groupCounselingRate' => $groupCounselingRate,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $counselor = $passport['counselor'];

            // get data from frontend
            $name = $this->security->xss_clean($this->input->post('name'));
            $juniorGraduateYear = $this->security->xss_clean($this->input->post('juniorGraduateYear'));
            $juniorDropoutRecord = $this->security->xss_clean($this->input->post('juniorDropoutRecord'));
            $counselIdentity = $this->security->xss_clean($this->input->post('counselIdentity'));
            $juniorSchoolCondition = $this->security->xss_clean($this->input->post('juniorSchoolCondition'));
            $seniorSchoolCondition = $this->security->xss_clean($this->input->post('seniorSchoolCondition'));
            $juniorSchool = $this->security->xss_clean($this->input->post('juniorSchool'));
            $seniorSchool = $this->security->xss_clean($this->input->post('seniorSchool'));
            $trend = $this->security->xss_clean($this->input->post('trend'));
            $workDescription = $this->security->xss_clean($this->input->post('workDescription'));
            $isOriginCompany = $this->security->xss_clean($this->input->post('isOriginCompany'));
            $schoolDescription = $this->security->xss_clean($this->input->post('schoolDescription'));
            $trainingDescription = $this->security->xss_clean($this->input->post('trainingDescription'));
            $unresistibleReason = $this->security->xss_clean($this->input->post('unresistibleReason'));
            $otherDescription = $this->security->xss_clean($this->input->post('otherDescription'));
            $isCompleteCounsel = $this->security->xss_clean($this->input->post('isCompleteCounsel'));
            $completeCounselReason = $this->security->xss_clean($this->input->post('completeCounselReason'));
            $isTransfer = $this->security->xss_clean($this->input->post('isTransfer'));
            $transferPlace = $this->security->xss_clean($this->input->post('transferPlace'));
            $transferReason = $this->security->xss_clean($this->input->post('transferReason'));

            $familyDiagram = $caseAssessments ? $caseAssessments->family_diagram : null;

            if (empty($name)) {
                return $this->load->view('/member/end_case', $beSentDataset);
            }

            // file format define
            $config['upload_path'] = './files/';
            $config['allowed_types'] = 'jpg|png|pdf';
            $config['max_size'] = 5000;
            $config['max_width'] = 5000;
            $config['max_height'] = 5000;
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);
            // upload family diagram
            if ($this->upload->do_upload('familyDiagram')) {
                $fileMetaData = $this->upload->data();
                $familyDiagram = $this->FileModel->create_one($member, $fileMetaData['file_name'], $fileMetaData['orig_name']);
            }

            if (empty($endCases)) {
                $isExecuteSuccess = $this->EndCaseModel->create_one($member, $trend, $workDescription, $isOriginCompany,
                    $schoolDescription, $trainingDescription, $isCompleteCounsel, $completeCounselReason,
                    $isTransfer, $transferPlace, $transferReason, $unresistibleReason, $otherDescription);
                $isUpdateEndDate = $this->MemberModel->update_end_date_by_no($member);
                $isUploadExecuteSuccess = $this->CaseAssessmentModel->update_family_diagram_by_member($familyDiagram, $member);
                $isUpdateYouth = $this->YouthModel->update_junior_by_no($juniorSchool, $seniorSchool, $youths->no);

                $endCaseArray = array($member, $trend, $workDescription, $isOriginCompany,
                    $schoolDescription, $trainingDescription, $isCompleteCounsel, $completeCounselReason,
                    $isTransfer, $transferPlace, $transferReason, $unresistibleReason, $otherDescription);

                $endCaseNum = 0;
                foreach ($endCaseArray as $value) {
                    if ($value != null) {
                        $endCaseNum++;
                    }
                }

                $endCaseRate = round($endCaseNum / count($endCaseArray), 2) * 100;
                $endCaseSuccess = $this->CompletionModel->create_one('end_case', $member, $endCaseRate);

            } else {
                $isExecuteSuccess = $this->EndCaseModel->update_by_member($member, $trend, $workDescription, $isOriginCompany,
                    $schoolDescription, $trainingDescription, $isCompleteCounsel,
                    $completeCounselReason, $isTransfer, $transferPlace, $transferReason,
                    $unresistibleReason, $otherDescription);
                $isUploadExecuteSuccess = $this->CaseAssessmentModel->update_family_diagram_by_member($familyDiagram, $member);
                $isUpdateYouth = $this->YouthModel->update_junior_by_no($juniorSchool, $seniorSchool, $youths->no);

                $endCaseArray = array($member, $trend, $workDescription, $isOriginCompany,
                    $schoolDescription, $trainingDescription, $isCompleteCounsel, $completeCounselReason,
                    $isTransfer, $transferPlace, $transferReason, $unresistibleReason, $otherDescription);

                $endCaseNum = 0;
                foreach ($endCaseArray as $value) {
                    if ($value != null) {
                        $endCaseNum++;
                    }
                }

                $endCaseRate = round($endCaseNum / count($endCaseArray), 2) * 100;
                $endCaseSuccess = $this->CompletionModel->update_one('end_case', $member, $endCaseRate);

            }

            if ($member && $isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
            } else {
                $beSentDataset['error'] = '新增失敗';
            }

            $endCases = $member ? $this->EndCaseModel->get_by_member($member) : null;
            $youths = $this->MemberModel->get_by_member($member);
            $caseAssessments = $member ? $this->CaseAssessmentModel->get_by_member($member) : null;

            $beSentDataset['endCases'] = $endCases;
            $beSentDataset['youths'] = $youths;
            $beSentDataset['caseAssessments'] = $caseAssessments;
            $beSentDataset['url'] = '/member/end_case/' . $member;

            $this->load->view('/member/end_case', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function get_month_review_table_by_member($member = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $county = $passport['county'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            if (empty($member)) {
                return show_404();
            }
            check_member($member, $county);
            $monthReviews = $this->MonthReviewModel->get_by_member($member);
            $monthReviewCompletions = $this->CompletionModel->get_rate_by_form_name('month_review');
            $hasDelegation = $this->ProjectModel->get_has_delegation_by_member($member)->has_delegation;
            $beSentDataset = array(
                'title' => '當年度結案後月追蹤清單',
                'url' => '/member/month_review/' . $member,
                'role' => $current_role,
                'member' => $member,
                'monthReviewCompletions' => $monthReviewCompletions,
                'monthReviews' => $monthReviews,
                'userTitle' => $userTitle,
                'hasDelegation' => $hasDelegation,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $this->load->view('/member/month_review_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function month_review($member = null, $no = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $county = $passport['county'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            check_member($member, $county);
            $members = $this->MemberModel->get_by_no($member);
            $monthReviews = $no ? $this->MonthReviewModel->get_by_no($no) : null;
            // redirect to error 404 if youth not found
            if (empty($members)) {
                return show_404();
            }
            $ways = $this->MenuModel->get_by_form_and_column('month_review', 'way');

            $counselor = $passport['counselor'];
            $hasDelegation = $this->ProjectModel->get_has_delegation_by_member($member)->has_delegation;

            $beSentDataset = array(
                'title' => '當年度結案後月追蹤表單',
                'url' => '/member/month_review/' . $member . '/' . $no,
                'member' => $member,
                'role' => $current_role,
                'ways' => $ways,
                'members' => $members,
                'monthReviews' => $monthReviews,
                'userTitle' => $userTitle,
                'hasDelegation' => $hasDelegation,
                'security' => $this->security,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $date = $this->security->xss_clean($this->input->post('date'));
            $way = $this->security->xss_clean($this->input->post('way'));
            $wayOther = $this->security->xss_clean($this->input->post('wayOther'));

            if (empty($date) || empty($way)) {
                return $this->load->view('/member/month_review', $beSentDataset);
            }

            if (empty($monthReviews)) {
                $isExecuteSuccess = $this->MonthReviewModel->create_one($member, $date, $way, $wayOther);
                $no = $isExecuteSuccess;

                $monthReviewArray = array($member, $date, $way, $wayOther);

                $monthReviewNum = 0;
                foreach ($monthReviewArray as $value) {
                    if ($value != null) {
                        $monthReviewNum++;
                    }
                }

                $monthReviewRate = round($monthReviewNum / count($monthReviewArray), 2) * 100;
                $monthReviewCompletionSuccess = $this->CompletionModel->create_one('month_review', $no, $monthReviewRate);
            } else {
                $isExecuteSuccess = $this->MonthReviewModel->update_by_no($member, $date, $way, $wayOther, $no);
                $monthReviewArray = array($member, $date, $way, $wayOther);

                $monthReviewNum = 0;
                foreach ($monthReviewArray as $value) {
                    if ($value != null) {
                        $monthReviewNum++;
                    }
                }

                $monthReviewRate = round($monthReviewNum / count($monthReviewArray), 2) * 100;
                $monthReviewCompletionSuccess = $this->CompletionModel->update_one('month_review', $no, $monthReviewRate);
            }

            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
                redirect('member/get_month_review_table_by_member/' . $member);

            } else {
                $beSentDataset['error'] = '新增失敗';
            }

            $monthReviews = $no ? $this->MonthReviewModel->get_by_no($no) : null;
            $beSentDataset['monthReviews'] = $monthReviews;
            $beSentDataset['url'] = '/member/month_review/' . $member . '/' . $no;

            $this->load->view('/member/month_review', $beSentDataset);
        }
    }

    public function get_insurance_table_by_member($member = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $county = $passport['county'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            if (empty($member)) {
                return show_404();
            }
            check_member($member, $county);
            $insurances = $this->InsuranceModel->get_by_member($member);

            $hasDelegation = $this->ProjectModel->get_has_delegation_by_member($member)->has_delegation;
            $members = $this->MemberModel->get_by_no($member);
            $beSentDataset = array(
                'title' => '投保紀錄清單',
                'url' => '/member/insurance/' . $member,
                'role' => $current_role,
                'member' => $member,
                'insurances' => $insurances,
                'userTitle' => $userTitle,
                'hasDelegation' => $hasDelegation,
                'password' => $passport['password'],
                'members' => $members,
                'updatePwd' => $passport['updatePwd']
            );

            $this->load->view('/member/insurance_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function insurance($member = null, $no = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $county = $passport['county'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            check_member($member, $county);
            $members = $this->MemberModel->get_by_no($member);
            $insurances = $no ? $this->InsuranceModel->get_by_no($no) : null;
            // redirect to error 404 if youth not found
            if (empty($members)) {
                return show_404();
            }

            $counselor = $passport['counselor'];
            $hasDelegation = $this->ProjectModel->get_has_delegation_by_member($member)->has_delegation;
            $types = $this->MenuModel->get_by_form_and_column('insurance', 'type');

            $beSentDataset = array(
                'title' => '投保紀錄',
                'url' => '/member/insurance/' . $member . '/' . $no,
                'member' => $member,
                'role' => $current_role,
                'members' => $members,
                'insurances' => $insurances,
                'userTitle' => $userTitle,
                'hasDelegation' => $hasDelegation,
                'security' => $this->security,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'types' => $types
            );

            $startDate = $this->security->xss_clean($this->input->post('start_date'));
            $endDate = $this->security->xss_clean($this->input->post('end_date'));
            $note = $this->security->xss_clean($this->input->post('note'));
            $type = $this->security->xss_clean($this->input->post('type'));

            if (empty($member) || empty($startDate)) {
                return $this->load->view('/member/insurance', $beSentDataset);
            }

            if(strtotime($startDate) >= strtotime($endDate)){
              $beSentDataset['error']="開始時間不可大於或等於結束時間";
              return $this->load->view('/member/insurance', $beSentDataset);
            }

            if (empty($insurances)) {
                $isExecuteSuccess = $this->InsuranceModel->create_one($member, $startDate, $endDate, $note, $type);
                $no = $isExecuteSuccess;
            } else {
                $isExecuteSuccess = $this->InsuranceModel->update_by_no($member, $startDate, $endDate, $note, $type, $no);
            }

            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
                redirect('member/get_insurance_table_by_member/' . $member);

            } else {
                $beSentDataset['error'] = '新增失敗';
            }

            $insurances = $no ? $this->InsuranceModel->get_by_no($no) : null;
            $beSentDataset['insurances'] = $insurances;
            $beSentDataset['url'] = '/member/insurance/' . $member . '/' . $no;

            $this->load->view('/member/insurance', $beSentDataset);
        }
    }

    public function change_counselor($member = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $county = $passport['county'];
        $accept_role = array(4, 5);
        if (in_array($current_role, $accept_role)) {
           
            $organization = $passport['organization'];
            $county = $passport['county'];
            check_member($member, $county);

            $caseAssessments = $member ? $this->CaseAssessmentModel->get_by_member_temp($member) : null;
            $counselors = $this->UserModel->get_counselor_by_organization($organization, $county);
            $memberInfo = $member ? $this->MemberModel->get_by_member($member) : null;

            $beSentDataset = array(
                'title' => '更換輔導員申請',
                'url' => '/member/change_counselor/' . $member,
                'role' => $current_role,
                'counselors' => $counselors,
                'caseAssessments' => $caseAssessments,
                'userTitle' => $userTitle,
                'security' => $this->security,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $counselor = $passport['counselor'];

            // get data from frontend
            $newCounselor = $this->security->xss_clean($this->input->post('newCounselor'));
            $reason = $this->security->xss_clean($this->input->post('reason'));
            $formName = 'case_assessment';
            $formNo = $member;
            $reviewerRole = 4;
            $status = $this->MenuModel->get_no_resource_by_content('等待批准中', 'review')->no;
            $updateColumn = 'counselor';
            $updateValue = $newCounselor;

            if (empty($reason)) {
                return $this->load->view('/member/change_counselor', $beSentDataset);
            }

            if ($newCounselor && $reason) {

                $isExecuteSuccess = $this->ReviewModel->create_one($formName, $formNo, $reviewerRole, $status, $reason,
                    $updateColumn, $updateValue, $county);

                if ($member && $isExecuteSuccess) {
                    $organizationManager = $this->UserModel->get_by_organization_manager($passport['organization']);
                    $organizationName = $this->OrganizationModel->get_name_by_no($organization)->name;

                    $recipient = $organizationManager->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】學員更換輔導員通知';
                    $content = '<p>' . $organizationManager->name . ' 君 您好:</p>'
                    . '<p>' . $organizationName . '提出更換輔導員之申請</p>'
                    . '<p>原因 : ' . $reason . '</p>'
                    . '<p>學員名稱 : ' . $memberInfo->name . '</p>'
                    . '<p>學員編號 : ' . $memberInfo->system_no . '</p>'
                    . '<p>此申請需要您的審核才會生效，請撥空進行審核。</p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                     //api_send_email_temp($recipient, $title, $content);
                    $beSentDataset['success'] = '已送出申請';
                } else {
                    $beSentDataset['error'] = '新增失敗';
                }
            }

            $this->load->view('/member/change_counselor', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function change_counselor_apply($member = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {

            $organization = $passport['organization'];
            $county = $passport['county'];
            check_member($member, $county);

            $caseAssessments = $member ? $this->CaseAssessmentModel->get_by_member_temp($member) : null;
            $counselors = $this->UserModel->get_counselor_by_organization($organization, $county);
            $memberInfo = $member ? $this->MemberModel->get_by_member($member) : null;

            $beSentDataset = array(
                'title' => '更換輔導員申請',
                'url' => '/member/change_counselor_apply/' . $member,
                'role' => $current_role,
                'counselors' => $counselors,
                'caseAssessments' => $caseAssessments,
                'userTitle' => $userTitle,
                'security' => $this->security,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $counselor = $passport['counselor'];
            $counselorInfo = $this->UserModel->get_by_counselor($counselor);

            // get data from frontend

            $reason = $this->security->xss_clean($this->input->post('reason'));
            $formName = 'case_assessment';
            $formNo = $member;
            $reviewerRole = 5;
            $status = $this->MenuModel->get_no_resource_by_content('等待批准中', 'review')->no;
            $updateColumn = 'counselor';
            $updateValue = null;

            if (empty($reason)) {
                return $this->load->view('/member/change_counselor', $beSentDataset);
            }

            if ($reason) {

                $isExecuteSuccess = $this->ReviewModel->create_one($formName, $formNo, $reviewerRole, $status, $reason,
                    $updateColumn, $updateValue, $county);

                if ($member && $isExecuteSuccess) {
                    $organizationContractor = $this->UserModel->get_by_organization_contractor($organization);
                    $organizationName = $this->OrganizationModel->get_name_by_no($organization)->name;

                    $recipient = $organizationContractor->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】學員更換輔導員通知';
                    $content = '<p>' . $organizationContractor->name . ' 君 您好:</p>'
                    . '<p>' . $counselorInfo->name . '提出更換輔導員之申請</p>'
                    . '<p>原因 : ' . $reason . '</p>'
                    . '<p>學員名稱 : ' . $memberInfo->name . '</p>'
                    . '<p>學員編號 : ' . $memberInfo->system_no . '</p>'
                    . '<p>此申請需要您選擇欲更換之輔導員，請撥空進行更換。</p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                     //api_send_email_temp($recipient, $title, $content);
                    $beSentDataset['success'] = '已送出申請';
                    redirect('member/case_assessment/' . $member);
                } else {
                    $beSentDataset['error'] = '新增失敗';
                }
            }

            $this->load->view('/member/change_counselor', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    // public function change_counselor_apply($member = null)
    // {
    //     $passport = $this->session->userdata('passport');
    //     $current_role = $passport['role'];
    //     $userTitle = $passport['userTitle'];
    //     $accept_role = array(6);
    //     if (in_array($current_role, $accept_role)) {

    //         $organization = $passport['organization'];
    //         $county = $passport['county'];

    //         $caseAssessments = $member ? $this->CaseAssessmentModel->get_by_member_temp($member) : null;
    //         $counselors = $this->UserModel->get_counselor_by_organization($organization, $county);

    //         $beSentDataset = array(
    //             'title' => '更換輔導員申請',
    //             'url' => '/member/change_counselor_apply/' . $member,
    //             'role' => $current_role,
    //             'counselors' => $counselors,
    //             'caseAssessments' => $caseAssessments,
    //             'userTitle' => $userTitle,
    //             'security' => $this->security,
    //         );

    //         $counselor = $passport['counselor'];

    //         // get data from frontend

    //         $reason = $this->security->xss_clean($this->input->post('reason'));
    //         $formName = 'case_assessment';
    //         $formNo = $member;
    //         $reviewerRole = 5;
    //         $status = $this->MenuModel->get_no_resource_by_content('等待批准中', 'review')->no;
    //         $updateColumn = 'counselor';
    //         $updateValue = null;

    //         if (empty($reason)) {
    //             return $this->load->view('/member/change_counselor', $beSentDataset);
    //         }

    //         if ($reason) {

    //             $isExecuteSuccess = $this->ReviewModel->create_one($formName, $formNo, $reviewerRole, $status, $reason,
    //               $updateColumn, $updateValue, $county);

    //             if ($member && $isExecuteSuccess) {
    //                 $beSentDataset['success'] = '新增成功';
    //                 redirect('member/case_assessment/' . $member);
    //             } else {
    //                 $beSentDataset['error'] = '新增失敗';
    //             }
    //         }

    //         $this->load->view('/member/change_counselor', $beSentDataset);
    //     } else {
    //         redirect('user/login');
    //     }
    // }
}
