<?php
class County extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('CountyModel');
        $this->load->model('OrganizationModel');
        $this->load->model('ProjectModel');
        $this->load->model('MenuModel');
        $this->load->model('CounselingMemberCountReportModel');
        $this->load->model('CompletionModel');
        $this->load->model('MemberModel');
        $this->load->model('CaseAssessmentModel');
        $this->load->model('ReviewModel');
        $this->load->model('CountyContactModel');
        $this->load->model('MonthMemberTempCounselingModel');
        $this->load->model('CounselorServingMemberModel');
        $this->load->model('CounselorServingMemberUpdateModel');
        $this->load->model('UserModel');
        $this->load->model('UserTempModel');
    }

    public function create_county()
    {
        valid_roles(array(1,9));
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $beSentDataset = array(
            'title' => '新增縣市',
            'url' => '/county/create_county',
            'role' => $current_role,
            'userTitle' => $userTitle,
            'security' => $this->security,
            'password' => $passport['password'],
            'updatePwd' => $passport['updatePwd']
        );
        // get data from frontend
        $name = $this->security->xss_clean($this->input->post('name'));
        $phone = $this->security->xss_clean($this->input->post('phone'));
        $orgnizer = $this->security->xss_clean($this->input->post('orgnizer'));
        if (empty($name) || empty($phone)) {
            return $this->load->view('create_county', $beSentDataset);
        }
        // fetch data from model
        $isNameExist = $this->CountyModel->is_name_exist($name);
        if ($isNameExist) {
            $beSentDataset['error'] = '已經存在相同名稱的縣市了';
        } else {
            $isExecuteSuccess = $this->CountyModel->create_one($name, $phone, $orgnizer);
            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
            } else {
                $beSentDataset['error'] = '新增失敗';
            }
        }
        $this->load->view('/county/create_county', $beSentDataset);
    }

    public function delegate_project_to_organization()
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(2, 3);
        if (in_array($current_role, $accept_role)) {
            $county = $passport['county'];
            $projects = $this->ProjectModel->get_by_county($county);
            $organizations = $this->OrganizationModel->get_by_county($county);
            $beSentDataset = array(
                'title' => '委託計畫執行機構',
                'url' => '/county/delegate_project_to_organization',
                'role' => $current_role,
                'projects' => $projects,
                'organizations' => $organizations,
                'userTitle' => $userTitle,
                'security' => $this->security,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            // get data from frontend
            $project = $this->security->xss_clean($this->input->post('project'));
            $organization = $this->security->xss_clean($this->input->post('organization'));
            if (empty($project) || empty($organization)) {
                return $this->load->view('/county/delegate_project_to_organization', $beSentDataset);
            }
            // fetch data from model
            $isRelationExist = $this->CountyModel->is_county_project_organization_relation_exist($county, $organization, $project);
            if ($isRelationExist) {
                $beSentDataset['error'] = '已經存在委任關係了';
            } else {
                $isExecuteSuccess = $this->CountyModel->delegate_project_to_organization($county, $organization, $project);
                if ($isExecuteSuccess) {
                    $beSentDataset['success'] = '新增成功';
                } else {
                    $beSentDataset['error'] = '新增失敗';
                }
            }
            $this->load->view('/county/delegate_project_to_organization', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function county_contact_table()
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(2, 3);
        if (in_array($current_role, $accept_role)) {
            $county = $passport['county'];
            $countyContacts = $this->CountyContactModel->get_by_county($county);
            $counties = $this->CountyModel->get_all();

            $beSentDataset = array(
                'title' => '縣市聯繫窗口清單',
                'url' => '/county/county_contact',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'countyContacts' => $countyContacts,
                'counties' => $counties,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $this->load->view('/county/county_contact_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function county_contact($no = null)
    {
        valid_roles(array(2, 3));
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $county = $passport['county'];

        $countyContacts = $no ? $this->CountyContactModel->get_by_no($no) : null;
        
        if($county != $countyContacts->county) redirect('user/login');

        $beSentDataset = array(
            'title' => '縣市聯繫窗口',
            'url' => '/county/county_contact/' . $no,
            'role' => $current_role,
            'userTitle' => $userTitle,
            'countyContacts' => $countyContacts,
            'security' => $this->security,
            'password' => $passport['password'],
            'updatePwd' => $passport['updatePwd']
        );

        $name = $this->security->xss_clean($this->input->post('name'));
        $phone = $this->security->xss_clean($this->input->post('phone'));
        $orgnizer = $this->security->xss_clean($this->input->post('orgnizer'));
        $email = $this->security->xss_clean($this->input->post('email'));
        $title = $this->security->xss_clean($this->input->post('title'));
        #$receiveGroup = $this->input->post('receiveGroup') ? implode(",", $this->input->post('receiveGroup')) : null;

        if (empty($name)) {
            return $this->load->view('/county/county_contact', $beSentDataset);
        }

        if (empty($countyContacts)) {
            $isExecuteSuccess = $this->CountyContactModel->create_one(
                $county, $name, $phone, $orgnizer, $email, $title
            );

            $no = $isExecuteSuccess;
        } else {
            $isExecuteSuccess = $this->CountyContactModel->update_one(
                $county, $name, $phone, $orgnizer, $email, $title, $no
            );
        }
        if ($isExecuteSuccess) {
            $beSentDataset['success'] = '新增成功';
            redirect('county/county_contact_table');
        } else {
            $beSentDataset['error'] = '新增失敗';
        }

        $countyContacts = $no ? $this->CountyContactModel->get_by_no($no) : null;

        $beSentDataset['countyContacts'] = $countyContacts;
        $beSentDataset['url'] = '/county/county_contact/' . $no;

        $this->load->view('/county/county_contact', $beSentDataset);
    }

    public function counseling_member_count_report($yearType = null, $monthType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(2, 3);
        if (in_array($current_role, $accept_role)) {
            $county = $passport['county'];

            $projects = $this->ProjectModel->get_latest_by_county($county);
            $countyAndOrg = $this->CountyModel->get_by_county($county);
            $counselingMemberCountReport = $this->CounselingMemberCountReportModel->get_by_no($yearType, $monthType, $county);
            $executeModes = $this->MenuModel->get_by_form_and_column('project', 'execute_mode');
            $executeWays = $this->MenuModel->get_by_form_and_column('project', 'execute_way');
            $counties = $this->CountyModel->get_all();

            $beSentDataset = array(
                'title' => '<表一>輔導人數統計',
                'url' => '/county/counseling_member_count_report',
                'role' => $current_role,
                'executeModes' => $executeModes,
                'executeWays' => $executeWays,
                'counties' => $counties,
                'county' => $county,
                'counselingMemberCountReport' => $counselingMemberCountReport,
                'userTitle' => $userTitle,
                'projects' => $projects,
                'countyAndOrg' => $countyAndOrg,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            // get data from frontend
            // $project = $this->input->post('project');
            // $organization = $this->input->post('organization');
            // if(empty($project) || empty($organization)) {
            //   return $this->load->view('delegate_project_to_organization', $beSentDataset);
            // }
            // // fetch data from model
            // $isRelationExist = $this->CountyModel->is_county_project_organization_relation_exist($county, $organization, $project);
            // if($isRelationExist) {
            //   $beSentDataset['error'] = '已經存在委任關係了';
            // } else {
            //   $isExecuteSuccess = $this->CountyModel->delegate_project_to_organization($county, $organization, $project);
            //   if($isExecuteSuccess) {
            //     $beSentDataset['success'] = '新增成功';
            //   } else {
            //     $beSentDataset['error'] = '新增失敗';
            //   }
            // }
            $this->load->view('counseling_member_count_report', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function counseling_member_count_report_table($yearType = null, $monthType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(2, 3);
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

            $counselingMemberCountReport = $this->CounselingMemberCountReportModel->get_no_by_county($county, $yearType, $monthType);
            $counselingMemberCountReportNo = empty($counselingMemberCountReport) ? null : $counselingMemberCountReport->no;
            $counselingMemberCountReportNo = empty($counselingMemberCountReportNo) ? null : $counselingMemberCountReportNo;

            $counselingMemberCountReportIsReview = empty($counselingMemberCountReport) ? null : $counselingMemberCountReport->is_review;
            $counselingMemberCountReportIsReview = empty($counselingMemberCountReportIsReview) ? 0 : $counselingMemberCountReportIsReview;

            $counselingMemberCountReportCompletion = $this->CompletionModel->get_rate_by_form_no('counseling_member_count_report', $counselingMemberCountReportNo);
            $counselingMemberCountReportCompletion = empty($counselingMemberCountReportCompletion) ? 0 : $counselingMemberCountReportCompletion;

            $beSentDataset = array(
                'title' => '輔導成效表單清單',
                'url' => '/county/counseling_member_count_report_table/',
                'role' => $current_role,
                'years' => $years,
                'months' => $months,
                'yearType' => $yearType,
                'monthType' => $monthType,
                'counselingMemberCountReportNo' => $counselingMemberCountReportNo,
                'counselingMemberCountReportIsReview' => $counselingMemberCountReportIsReview,
                'counselingMemberCountReportCompletion' => $counselingMemberCountReportCompletion,
                'userTitle' => $userTitle,
                'security' => $this->security,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            // get data from frontend
            // $project = $this->input->post('project');
            // $organization = $this->input->post('organization');
            // if(empty($project) || empty($organization)) {
            //   return $this->load->view('delegate_project_to_organization', $beSentDataset);
            // }
            // // fetch data from model
            // $isRelationExist = $this->CountyModel->is_county_project_organization_relation_exist($county, $organization, $project);
            // if($isRelationExist) {
            //   $beSentDataset['error'] = '已經存在委任關係了';
            // } else {
            //   $isExecuteSuccess = $this->CountyModel->delegate_project_to_organization($county, $organization, $project);
            //   if($isExecuteSuccess) {
            //     $beSentDataset['success'] = '新增成功';
            //   } else {
            //     $beSentDataset['error'] = '新增失敗';
            //   }
            // }
            $this->load->view('counseling_member_count_report_table', $beSentDataset);
        } else {
            //redirect('user/login');
        }
    }

    public function month_member_temp_counseling($yearType = null, $monthType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(2, 3);

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

            $members = $this->MemberModel->get_member_month($county, $yearType);
            $monthMemberTempCounselings = $this->MonthMemberTempCounselingModel->get_by_county_and_month($county, $monthType, $yearType);
            $trends = $this->MenuModel->get_by_form_and_column('end_case', 'trend');
            $hasDelegation = $this->ProjectModel->get_has_delegation_by_member($members[0]['no'])->has_delegation;

            $beSentDataset = array(
                'title' => '每月輔導成效概況表',
                'url' => '/county/month_member_temp_counseling/' . $yearType . '/' . $monthType,
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
                return $this->load->view('month_member_temp_counseling', $beSentDataset);
            }

            if ($monthMemberTempCounselings) {
                for ($i = 0; $i < count($monthMemberTempCounselings); $i++) {

                    $isExecuteSuccess = $this->MonthMemberTempCounselingModel->update_by_county_and_month($monthMemberTempCounselings[$i]['member'], $trend[$i], $trendDescription[$i], $monthType, $county);
                }

            } else {
                if ($trend && $trendDescription) {
                    for ($i = 0; $i < count($members); $i++) {
                        $isExecuteSuccess = $this->MonthMemberTempCounselingModel->create_one($members[$i]['no'], $trend[$i], $trendDescription[$i], $monthType, $county);
                    }
                }

            }

            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
            } else {
                $beSentDataset['error'] = '新增失敗';
            }
            $monthMemberTempCounselings = $this->MonthMemberTempCounselingModel->get_by_county_and_month($county, $monthType, $yearType);
            $beSentDataset['monthMemberTempCounselings'] = $monthMemberTempCounselings;

            $this->load->view('month_member_temp_counseling', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
}
