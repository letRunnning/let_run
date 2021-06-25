<?php
class Work extends CI_Controller
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
        $this->load->model('CompanyModel');
        $this->load->model('WorkExperienceModel');
        $this->load->model('WorkAttendanceModel');
        $this->load->model('InsuranceModel');
    }

    public function get_company_table_by_organization()
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(2,3,4,5,6);
        if (in_array($current_role, $accept_role)) {
            $counselor = $passport['counselor'];
            $organization = $passport['organization'];

            $companys = $this->CompanyModel->get_by_organization($organization);
            $categorys = $this->MenuModel->get_by_form_and_column('company', 'category');

            $beSentDataset = array(
                'title' => '店家參考清單(歷年資料)',
                'url' => '/work/company/',
                'role' => $current_role,
                'companys' => $companys,
                'categorys' => $categorys,
                'userTitle' => $userTitle,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $this->load->view('/work/company_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function company($no = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $organization = $passport['organization'];
        $accept_role = array(2,3,4,5,6);

        valid_roles($accept_role);

        $companys = $no ? $this->CompanyModel->get_by_no($no) : null;
        if ($companys) {
          if ($organization != $companys->organization) {
              redirect('user/login');
          }
        }
        $categorys = $this->MenuModel->get_by_form_and_column('company', 'category');

        $beSentDataset = array(
            'title' => '店家參考資料(歷年資料)',
            'url' => '/work/company/' . $no,
            'role' => $current_role,
            'companys' => $companys,
            'categorys' => $categorys,
            'userTitle' => $userTitle,
            'security' => $this->security,
            'password' => $passport['password'],
            'updatePwd' => $passport['updatePwd']
        );

        $companyData = [];
        $companyData['organization'] = $passport['organization'];

        $companyColumns = $this->CompanyModel->get_edited_columns_metadata();
        $isLoading = count($this->input->post()) === 0;
        foreach ($companyColumns as $column) {
            $columnName = $column->column_name;
            // optional column not need 'require' checking
            $checker = 'trim|htmlspecialchars|xss_clean';
            $this->form_validation->set_rules($columnName, $column->column_comment, $checker);
        }

        if (!$isLoading && $this->form_validation->run() != false) {
            foreach ($companyColumns as $column) {
                // set default value from database or update value by new input value
                $columnName = $column->column_name;
                $companyData[$columnName] = $isLoading && $companys ? $companys[$columnName] : $this->input->post($columnName);
            }
            // handling course
            if ($companys) {
                $newCompany = $companyData;
                $isExecuteSuccess = $this->CompanyModel->update_by_no($no, $newCompany);
                if ($isExecuteSuccess) {
                    $beSentDataset['success'] = '修改成功';
                    redirect('work/get_company_table_by_organization');
                } else {
                    $beSentDataset['error'] = '修改失敗';
                }
            } else {
                $no = $this->CompanyModel->create_one($companyData);
                if ($no) {
                    $beSentDataset['success'] = '新增成功';
                    redirect('work/get_company_table_by_organization');
                } else {
                    $beSentDataset['error'] = '新增失敗';
                }
            }
        }

        $companys = $no ? $this->CompanyModel->get_by_no($no) : null;
        $beSentDataset['companys'] = $companys;
        $beSentDataset['url'] = '/work/company/' . $no;

        $this->load->view('/work/company', $beSentDataset);
    }

    public function get_work_experience_table_by_organization($yearType = null)
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

            $workExperiences = $this->WorkExperienceModel->get_by_organization($organization, $yearType);
            $companys = $this->CompanyModel->get_all();

            $beSentDataset = array(
                'title' => '工作體驗清單(今年度資料)',
                'url' => '/work/work_experience/',
                'role' => $current_role,
                'workExperiences' => $workExperiences,
                'companys' => $companys,
                'yearType' => $yearType,
                'years' => $years,
                'userTitle' => $userTitle,
                'hasDelegation' => $hasDelegation,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $this->load->view('/work/work_experience_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function work_experience($no = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(2,3,4,5,6);
        if (in_array($current_role, $accept_role)) {
            $counselor = $passport['counselor'];
            $organization = $passport['organization'];

            $workExperiences = $no ? $this->WorkExperienceModel->get_by_no($no) : null;
            if ($workExperiences) {
              if ($organization != $workExperiences->organization) {
                  redirect('user/login');
              }
            }
            $companys = $this->CompanyModel->get_by_organization($organization);

            $beSentDataset = array(
                'title' => '工作體驗資料(今年度資料)',
                'url' => '/work/work_experience/' . $no,
                'role' => $current_role,
                'workExperiences' => $workExperiences,
                'companys' => $companys,
                'userTitle' => $userTitle,
                'security' => $this->security,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $company = $this->security->xss_clean($this->input->post('company'));
            $startTime = $this->security->xss_clean($this->input->post('startTime'));
            $endTime = $this->security->xss_clean($this->input->post('endTime'));

            if (empty($company)) {
                return $this->load->view('/work/work_experience', $beSentDataset);
            }

            if(strtotime($startTime) >= strtotime($endTime)){
              $beSentDataset['error']="開始時間不可大於或等於結束時間";
              return $this->load->view('/work/work_experience', $beSentDataset);
            }

            if (empty($workExperiences)) {
                $isExecuteSuccess = $this->WorkExperienceModel->create_one($company, $startTime, $endTime, $organization);
                $no = $isExecuteSuccess;
            } else {
                $isExecuteSuccess = $this->WorkExperienceModel->update_by_no($company, $startTime, $endTime, $organization, $no);
            }

            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
                redirect('work/get_work_experience_table_by_organization');
            } else {
                $beSentDataset['error'] = '新增失敗';
            }

            $workExperiences = $no ? $this->WorkExperienceModel->get_by_no($no) : null;
            $beSentDataset['workExperiences'] = $workExperiences;
            $beSentDataset['url'] = '/work/work_experience/' . $no;

            $this->load->view('/work/work_experience', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function get_work_attendance_table_by_organization($yearType = null)
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

            $workAttendances = $this->WorkAttendanceModel->get_by_organization_member($organization, $yearType);

            $beSentDataset = array(
                'title' => '工作體驗時數清單(執行當日更新、每月自動統計報表數據)',
                'url' => '/work/work_attendance/',
                'role' => $current_role,
                'workAttendances' => $workAttendances,
                'yearType' => $yearType,
                'years' => $years,
                'userTitle' => $userTitle,
                'hasDelegation' => $hasDelegation,
                'canInsert' => '1',
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $this->load->view('/work/work_attendance_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function get_work_attendance_table_by_member($member = null, $yearType = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
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

            $workAttendances = $this->WorkAttendanceModel->get_by_member($member, $yearType);
            $hasDelegation = $this->ProjectModel->get_has_delegation_by_member($member)->has_delegation;
            $beSentDataset = array(
                'title' => '工作體驗時數清單(執行當日更新、每月自動統計報表數據)',
                'url' => '/work/work_attendance/',
                'role' => $current_role,
                'workAttendances' => $workAttendances,
                'userTitle' => $userTitle,
                'hasDelegation' => $hasDelegation,
                'yearType' => $yearType,
                'years' => $years,
                'canInsert' => '0',
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $this->load->view('/work/work_attendance_member_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function work_attendance($workType = null, $no = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(2,3,4,5,6);
        if (in_array($current_role, $accept_role)) {
            $counselor = $passport['counselor'];
            $organization = $passport['organization'];
            $county = $passport['county'];

            $workExperiences = $this->WorkExperienceModel->get_by_organization($organization, date("Y") - 1911);
            $workAttendances = $no ? $this->WorkAttendanceModel->get_by_no($no) : null;
            if($workAttendances) {
              check_member($workAttendances->member, $county);
            }
            $members = $this->MemberModel->get_by_organization_course_work($organization);
            $hasDelegation = $members ? $this->ProjectModel->get_has_delegation_by_member($members[0]['no'])->has_delegation : '0';

          
            $workInfo = $workType ? $this->WorkExperienceModel->get_by_no($workType) : null;


            $beSentDataset = array(
                'title' => '工作體驗時數表(執行當日更新、每月自動統計報表數據)',
                'url' => '/work/work_attendance/' . $workType . '/'. $no,
                'role' => $current_role,
                'workAttendances' => $workAttendances,
                'workExperiences' => $workExperiences,
                'members' => $members,
                'userTitle' => $userTitle,
                'hasDelegation' => $hasDelegation,
                'security' => $this->security,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'no' => $no,
                'workType' => $workType,
                'workInfo' => $workInfo
            );

            $workExperience = $workType;
            $member = $this->security->xss_clean($this->input->post('member'));
            $startTime = $this->security->xss_clean($this->input->post('startTime'));
            $endTime = $this->security->xss_clean($this->input->post('endTime'));
           // $duration = $this->security->xss_clean($this->input->post('duration'));
            $note = $this->security->xss_clean($this->input->post('note'));
            $isInsurance = $this->security->xss_clean($this->input->post('is_insurance'));
            $insuranceStartDate = $this->security->xss_clean($this->input->post('insurance_start_date'));
            $insuranceEndDate = $this->security->xss_clean($this->input->post('insurance_end_date'));

            if (empty($member)) {
                return $this->load->view('/work/work_attendance', $beSentDataset);
            }

            if(strtotime($startTime) >= strtotime($endTime)){
              $beSentDataset['error']="開始時間不可大於或等於結束時間";
              return $this->load->view('/work/work_attendance', $beSentDataset);
            }else{
                // 以小時為單位
                $duration =(strtotime($endTime) - strtotime($startTime))/3600;
            }

          
                $isInsuranceSuccess = $this->InsuranceModel->check_is_insurance($member, $endTime);
                if ($isInsuranceSuccess == 0) {
                    $beSentDataset['error'] = '該學員查無投保紀錄，新增失敗';
                    return $this->load->view('/work/work_attendance', $beSentDataset);
                }
            

            if (empty($workAttendances)) {
                $isExecuteSuccess = $this->WorkAttendanceModel->create_one($workExperience, $member, $startTime, $endTime, $duration, $isInsurance, $insuranceStartDate, $insuranceEndDate, $note);
                $no = $isExecuteSuccess;
            } else {
                $isExecuteSuccess = $this->WorkAttendanceModel->update_by_no($workExperience, $member, $startTime, $endTime, $duration, $isInsurance, $insuranceStartDate, $insuranceEndDate, $note, $no);
            }

            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
                redirect('work/get_work_attendance_table_by_organization/');
            } else {
                $beSentDataset['error'] = '新增失敗';
            }

            $workAttendances = $no ? $this->WorkAttendanceModel->get_by_no($no) : null;
            $beSentDataset['workAttendances'] = $workAttendances;
            $beSentDataset['url'] = '/work/work_attendance/' . $workType . '/'. $no;

            $this->load->view('/work/work_attendance', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
}
