<?php
class Course extends CI_Controller
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
        $this->load->model('CourseReferenceModel');
        $this->load->model('CourseModel');
        $this->load->model('CourseAttendanceModel');
        $this->load->model('CourseAttendanceDeleteModel');
        $this->load->model('ExpertListModel');
        $this->load->model('InsuranceModel');
    }

    public function get_expert_table_by_organization()
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $accept_role = array(2,3,4,5,6);
        if (in_array($current_role, $accept_role)) {
            $counselor = $passport['counselor'];
            $organization = $passport['organization'];
            $userTitle = $passport['userTitle'];
            $expertLists = $this->ExpertListModel->get_by_organization($organization);
            $beSentDataset = array(
                'title' => '講師清單',
                'url' => '/course/expert_list/',
                'role' => $current_role,
                'expertLists' => $expertLists,
                'userTitle' => $userTitle,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $this->load->view('/course/expert_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function expert_list($no = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(2,3,4,5,6);
        if (in_array($current_role, $accept_role)) {
            $counselor = $passport['counselor'];
            $organization = $passport['organization'];

            $expertLists = $no ? $this->ExpertListModel->get_by_no($no) : null;
            if ($expertLists) {
                if ($organization != $expertLists->organization) {
                    redirect('user/login');
                }
            }

            $genders = $this->MenuModel->get_by_form_and_column('expert_list', 'gender');

            $beSentDataset = array(
                'title' => '講師基本資料',
                'url' => '/course/expert_list/' . $no,
                'role' => $current_role,
                'expertLists' => $expertLists,
                'genders' => $genders,
                'userTitle' => $userTitle,
                'security' => $this->security,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $expertName = $this->security->xss_clean($this->input->post('expertName'));
            $gender = $this->security->xss_clean($this->input->post('gender'));
            $phone = $this->security->xss_clean($this->input->post('phone'));
            $email = $this->security->xss_clean($this->input->post('email'));
            $education = $this->security->xss_clean($this->input->post('education'));
            $profession = $this->security->xss_clean($this->input->post('profession'));
            $resideCounty = $this->security->xss_clean($this->input->post('resideCounty'));
            $isOpen = $this->security->xss_clean($this->input->post('isOpen'));

            if (empty($expertName)) {
                return $this->load->view('/course/expert', $beSentDataset);
            }

            if (empty($expertLists)) {
                $isExecuteSuccess = $this->ExpertListModel->create_one($expertName, $gender, $phone, $email, $education, $profession, $resideCounty, $organization, $isOpen);
                $no = $isExecuteSuccess;
            } else {
                $isExecuteSuccess = $this->ExpertListModel->update_by_no($expertName, $gender, $phone, $email, $education, $profession, $resideCounty, $organization, $isOpen, $no);
            }

            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
                redirect('course/get_expert_table_by_organization');
            } else {
                $beSentDataset['error'] = '新增失敗';
            }

            $expertLists = $no ? $this->ExpertListModel->get_by_no($no) : null;
            $beSentDataset['expertLists'] = $expertLists;
            $beSentDataset['url'] = '/course/expert_list/' . $no;

            $this->load->view('/course/expert', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function get_course_reference_table_by_organization()
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(2,3,4,5,6);
        if (in_array($current_role, $accept_role)) {
            $counselor = $passport['counselor'];
            $organization = $passport['organization'];

            $courseReferences = $this->CourseReferenceModel->get_by_organization($organization);
            $categorys = $this->MenuModel->get_by_form_and_column('course_reference', 'category');

            $beSentDataset = array(
                'title' => '課程參考清單(歷年資料)',
                'url' => '/course/course_reference/',
                'role' => $current_role,
                'courseReferences' => $courseReferences,
                'categorys' => $categorys,
                'userTitle' => $userTitle,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $this->load->view('/course/course_reference_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function course_reference($no = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(2,3,4,5,6);
        if (in_array($current_role, $accept_role)) {
            $counselor = $passport['counselor'];
            $organization = $passport['organization'];

            $courseReferences = $no ? $this->CourseReferenceModel->get_by_no($no) : null;
            if ($courseReferences) {
                if ($organization != $courseReferences->organization) {
                    redirect('user/login');
                }
            }

            $experts = $this->ExpertListModel->get_by_organization($organization);

            $genders = $this->MenuModel->get_by_form_and_column('expert_list', 'gender');
            $categorys = $this->MenuModel->get_by_form_and_column('course_reference', 'category');

            $beSentDataset = array(
                'title' => '課程參考資料(歷年資料)',
                'url' => '/course/course_reference/' . $no,
                'role' => $current_role,
                'courseReferences' => $courseReferences,
                'experts' => $experts,
                'categorys' => $categorys,
                'userTitle' => $userTitle,
                'security' => $this->security,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $courseName = $this->security->xss_clean($this->input->post('courseName'));
            $duration = $this->security->xss_clean($this->input->post('duration'));
            $expert = $this->security->xss_clean($this->input->post('expert'));
            $category = $this->security->xss_clean($this->input->post('category'));
            $content = $this->security->xss_clean($this->input->post('content'));

            if (empty($courseName)) {
                return $this->load->view('/course/course_reference', $beSentDataset);
            }

            if (empty($courseReferences)) {
                $isExecuteSuccess = $this->CourseReferenceModel->create_one($courseName, $duration, $expert, $organization, $category, $content);
                $no = $isExecuteSuccess;
            } else {
                $isExecuteSuccess = $this->CourseReferenceModel->update_by_no($courseName, $duration, $expert, $organization, $category, $content, $no);
            }

            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
                redirect('course/get_course_reference_table_by_organization');
            } else {
                $beSentDataset['error'] = '新增失敗';
            }

            $courseReferences = $no ? $this->CourseReferenceModel->get_by_no($no) : null;
            $beSentDataset['courseReferences'] = $courseReferences;
            $beSentDataset['url'] = '/course/course_reference/' . $no;

            $this->load->view('/course/course_reference', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function get_course_table_by_organization($yearType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(2,3,4,5,6);
        if (in_array($current_role, $accept_role)) {
            $counselor = $passport['counselor'];
            $organization = $passport['organization'];

            $years = $this->MemberModel->get_year_by_organization($organization);

            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }

            $hasDelegation = ($yearType == date("Y") - 1911) ? '1' : '0';

            $courses = $this->CourseModel->get_by_organization($organization, $yearType);
            $categorys = $this->MenuModel->get_by_form_and_column('course_reference', 'category');

            $beSentDataset = array(
                'title' => '課程開設清單(今年度資料)',
                'url' => '/course/course/',
                'role' => $current_role,
                'categorys' => $categorys,
                'courses' => $courses,
                'yearType' => $yearType,
                'years' => $years,
                'userTitle' => $userTitle,
                'hasDelegation' => $hasDelegation,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $this->load->view('/course/course_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function course($no = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(2,3,4,5,6);
        if (in_array($current_role, $accept_role)) {
            $counselor = $passport['counselor'];
            $organization = $passport['organization'];

            $courseReferences = $this->CourseReferenceModel->get_by_organization($organization);
            $courses = $no ? $this->CourseModel->get_by_no($no) : null;
            if ($courses) {
                if ($organization != $courses->organization) {
                    redirect('user/login');
                }
            }
            

            $beSentDataset = array(
                'title' => '課程開設表(今年度資料)',
                'url' => '/course/course/' . $no,
                'role' => $current_role,
                'courseReferences' => $courseReferences,
                'courses' => $courses,
                'userTitle' => $userTitle,
                'security' => $this->security,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $courseReference = $this->security->xss_clean($this->input->post('courseReference'));
            $startTime = $this->security->xss_clean($this->input->post('startTime'));
            $endTime = $this->security->xss_clean($this->input->post('endTime'));

            if(strtotime($startTime) >= strtotime($endTime)){
              $beSentDataset['error']="開始時間不可大於或等於結束時間";
              return $this->load->view('/course/course', $beSentDataset);
            }

            if (empty($courseReference)) {
                return $this->load->view('/course/course', $beSentDataset);
            }

            if (empty($courses)) {
                $isExecuteSuccess = $this->CourseModel->create_one($courseReference, $startTime, $endTime, $organization);
                $no = $isExecuteSuccess;
            } else {
                $isExecuteSuccess = $this->CourseModel->update_by_no($courseReference, $startTime, $endTime, $organization, $no);
            }

            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
                redirect('course/get_course_table_by_organization');
            } else {
                $beSentDataset['error'] = '新增失敗';
            }

            $courses = $no ? $this->CourseModel->get_by_no($no) : null;
            $beSentDataset['courses'] = $courses;
            $beSentDataset['url'] = '/course/course/' . $no;

            $this->load->view('/course/course', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function get_course_attendance_table_by_organization($yearType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(2,3,4,5,6);
        if (in_array($current_role, $accept_role)) {
            $counselor = $passport['counselor'];
            $organization = $passport['organization'];

            $years = $this->MemberModel->get_year_by_organization($organization);

            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }

            $hasDelegation = ($yearType == date("Y") - 1911) ? '1' : '0';

            $courseAttendances = $this->CourseAttendanceModel->get_by_organization($organization, $yearType);
            $courseAttendanceMembers = $this->CourseAttendanceModel->get_by_organization_youthName($organization, $yearType);

            $beSentDataset = array(
                'title' => '課程時數清單(執行當日更新、每月自動統計報表數據)',
                'url' => '/course/course_attendance/',
                'role' => $current_role,
                'courseAttendances' => $courseAttendances,
                'courseAttendanceMembers' => $courseAttendanceMembers,
                'yearType' => $yearType,
                'years' => $years,
                'userTitle' => $userTitle,
                'hasDelegation' => $hasDelegation,
                'canInsert' => '1',
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $this->load->view('/course/course_attendance_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function get_course_attendance_table_by_member($member = null, $yearType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(2,3,4,5,6);
        if (in_array($current_role, $accept_role)) {
            $counselor = $passport['counselor'];
            $organization = $passport['organization'];
            $county = $passport['county'];
            check_member($member, $county);

            $years = $this->MemberModel->get_year_by_organization($organization);

            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }

            $courseAttendances = $this->CourseAttendanceModel->get_by_member($member, $yearType);
            $courseAttendanceMembers = $this->CourseAttendanceModel->get_by_organization_youthName($organization, $yearType);
            $hasDelegation = $this->ProjectModel->get_has_delegation_by_member($member)->has_delegation;
            $beSentDataset = array(
                'title' => '課程時數清單(執行當日更新、每月自動統計報表數據)',
                'url' => '/course/course_attendance/',
                'role' => $current_role,
                'courseAttendances' => $courseAttendances,
                'courseAttendanceMembers' => $courseAttendanceMembers,
                'userTitle' => $userTitle,
                'hasDelegation' => $hasDelegation,
                'yearType' => $yearType,
                'years' => $years,
                'canInsert' => '0',
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $this->load->view('/course/course_attendance_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function course_attendance($course = null, $startTime = null)
    {
        $startTime = urldecode($startTime);
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(2,3,4,5,6);
        if (in_array($current_role, $accept_role)) {
            $counselor = $passport['counselor'];
            $organization = $passport['organization'];

         
            

            $courses = $this->CourseModel->get_by_organization($organization, date("Y") - 1911);
            $courseAttendances = $startTime ? $this->CourseAttendanceModel->get_by_start_time($organization, $startTime) : null;

            $members = $this->MemberModel->get_by_organization_course_work($organization);

            $participantArray = [];
            $participantRecord = $startTime ? $this->CourseAttendanceModel->get_participants_by_start_time($organization, $startTime) : null;
            if (!empty($participantRecord)) {
                foreach ($participantRecord as $i) {
                    array_push($participantArray, $i['member']);
                    $member = $i['member'];
                }
            }

            $hasDelegation = $members ? $this->ProjectModel->get_has_delegation_by_member($members[0]['no'])->has_delegation : '0';

            $courseType = $course ? $this->CourseModel->get_by_no($course)->no : $course;
            $courseInfo = $courseType ? $this->CourseModel->get_by_no($courseType) : null;

            $beSentDataset = array(
                'title' => '課程時數表(執行當日更新、每月自動統計報表數據)',
                'url' => '/course/course_attendance/' . $courseType . '/' . $startTime,
                'role' => $current_role,
                'courseAttendances' => $courseAttendances,
                'members' => $members,
                'participantArray' => $participantArray,
                'courses' => $courses,
                'userTitle' => $userTitle,
                'hasDelegation' => $hasDelegation,
                'security' => $this->security,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'courseType' => $courseType,
                'courseInfo' => $courseInfo,
                'startTime' => $startTime
            );

            $course = $courseType;
            $member = $this->security->xss_clean($this->input->post('member'));
            $startTime = $this->security->xss_clean($this->input->post('startTime'));
            $endTime = $this->security->xss_clean($this->input->post('endTime'));
            //$duration = $this->security->xss_clean($this->input->post('duration'));
            $note = $this->security->xss_clean($this->input->post('note'));
            $isInsurance = $this->security->xss_clean($this->input->post('is_insurance'));
            $insuranceStartDate = $this->security->xss_clean($this->input->post('insurance_start_date'));
            $insuranceEndDate = $this->security->xss_clean($this->input->post('insurance_end_date'));

            if (empty($member)) {
                return $this->load->view('/course/course_attendance', $beSentDataset);
            }

            if(strtotime($startTime) >= strtotime($endTime)){
              $beSentDataset['error']="開始時間不可大於或等於結束時間";
              return $this->load->view('/course/course_attendance', $beSentDataset);
            }else{
                // 以小時為單位
                $duration =(strtotime($endTime) - strtotime($startTime))/3600;
            }

            if (!empty($member)) {
                foreach ($member as $i) {
                    $isInsuranceSuccess = $this->InsuranceModel->check_is_insurance($i, $endTime);
                    if ($isInsuranceSuccess == 0) {
                        $memberInfo = $this->MemberModel->get_by_no($i);
                        $beSentDataset['error'] = '系統編號 : ' . $memberInfo->system_no . ' 姓名 : ' . $memberInfo->name . ' 查無投保紀錄，新增失敗';
                        return $this->load->view('/course/course_attendance', $beSentDataset);
                    }
                }
            }

            if (empty($courseAttendances)) {
                if (!empty($member)) {
                    foreach ($member as $i) {
                        $isExecuteSuccess = $this->CourseAttendanceModel->create_one($course, $i, $startTime, $endTime, $duration, $isInsurance, $insuranceStartDate, $insuranceEndDate, $note);
                    }
                }

            } else {
                $isExecuteSuccess = $this->CourseAttendanceDeleteModel->delete_by_no($startTime, $organization);
                if (!empty($member)) {
                    foreach ($member as $i) {
                        $isExecuteSuccess = $this->CourseAttendanceModel->create_one($course, $i, $startTime, $endTime, $duration, $isInsurance, $insuranceStartDate, $insuranceEndDate, $note);
                    }
                }
                //$isExecuteSuccess = $this->CourseAttendanceModel->update_by_no($course, $i, $startTime, $endTime, $duration, $no);
            }

            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
                redirect('course/get_course_attendance_table_by_organization');
            } else {
                $beSentDataset['error'] = '新增失敗';
            }

            $courseAttendances = $startTime ? $this->CourseAttendanceModel->get_by_start_time($organization, $startTime) : null;
            $beSentDataset['courseAttendances'] = $courseAttendances;
            $beSentDataset['url'] = '/course/course_attendance/' . $courseType . '/' . $startTime;
            $participantArray = [];
            $participantRecord = $startTime ? $this->CourseAttendanceModel->get_participants_by_start_time($organization, $startTime) : null;
            if (!empty($participantRecord)) {
                foreach ($participantRecord as $i) {
                    array_push($participantArray, $i['member']);
                }
            }
            $beSentDataset['participantArray'] = $participantArray;

            $this->load->view('/course/course_attendance', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
}
