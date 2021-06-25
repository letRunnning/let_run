<?php
class Project extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ProjectModel');
        $this->load->model('MenuModel');
        $this->load->model('CountyModel');
        $this->load->model('UserModel');
        $this->load->model('FundingApproveModel');
        $this->load->model('ReportModel');
    }

    public function create_project($no = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(2, 3);
        if (in_array($current_role, $accept_role)) {
            $county = $passport['county'];
            $projects = $no ? $this->ProjectModel->get_by_no($no) : null;
            if($projects) {
              if($county != $projects->county) redirect('user/login');
            }
            $executeModes = $this->MenuModel->get_by_form_and_column('project', 'execute_mode');
            $executeWays = $this->MenuModel->get_by_form_and_column('project', 'execute_way');
            $counties = $this->CountyModel->get_all();
            $countyName = "";
            $isUpdateProject = 0;
            foreach ($counties as $value) {
                if ($value['no'] == $county) {
                    $countyName = $value['name'];
                    $isUpdateProject = $value['update_project'];
                }
            }
            $beSentDataset = array(
                'title' => '開設計畫案',
                'url' => '/project/create_project/' . $no,
                'role' => $current_role,
                'executeModes' => $executeModes,
                'executeWays' => $executeWays,
                'userTitle' => $userTitle,
                'projects' => $projects,
                'security' => $this->security,
                'countyName' => $countyName,
                'isUpdateProject' => $isUpdateProject,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            // get data from frontend
            $name = $this->security->xss_clean($this->input->post('name'));
            $executeMode = $this->security->xss_clean($this->input->post('executeMode'));
            $executeWay = $this->security->xss_clean($this->input->post('executeWay'));
            $counselorCount = $this->security->xss_clean($this->input->post('counselorCount'));
            $meetingCount = $this->security->xss_clean($this->input->post('meetingCount'));
            $counselingMember = $this->security->xss_clean($this->input->post('counselingMember'));
            $counselingHour = $this->security->xss_clean($this->input->post('counselingHour'));
            $courseHour = $this->security->xss_clean($this->input->post('courseHour'));
            $workingMember = $this->security->xss_clean($this->input->post('workingMember'));
            $workingHour = $this->security->xss_clean($this->input->post('workingHour'));
            $groupCounselingHour = $this->security->xss_clean($this->input->post('groupCounselingHour'));
            $counselingYouth = $this->security->xss_clean($this->input->post('counselingYouth'));
            $trackDescription = $this->security->xss_clean($this->input->post('trackDescription'));
            $year = $this->security->xss_clean($this->input->post('year'));
            $date = date("Y-m-d");
            $funding = $this->security->xss_clean($this->input->post('funding'));
            $note = $this->security->xss_clean($this->input->post('note'));

            if (empty($name)) {
                return $this->load->view('/project/create_project', $beSentDataset);
            }

            if (empty($projects)) {
                if ($this->ProjectModel->check_is_excit($county) == 0) {
                    $isExecuteSuccess = $this->ProjectModel->create_one(
                        $county,
                        $name,
                        $executeMode,
                        $executeWay,
                        $counselorCount,
                        $meetingCount,
                        $counselingMember,
                        $counselingHour,
                        $courseHour,
                        $workingMember,
                        $workingHour,
                        $groupCounselingHour,
                        $counselingYouth,
                        $trackDescription,
                        $year,
                        $date,
                        $funding,
                        $note
                    );

                    $no = $isExecuteSuccess;
                } else {
                    $beSentDataset['error'] = '新增失敗，已有計劃正在執行中';
                    return $this->load->view('/project/create_project', $beSentDataset);
                }
            } else {
                $isExecuteSuccess = $this->ProjectModel->update_one(
                    $county,
                    $name,
                    $executeMode,
                    $executeWay,
                    $counselorCount,
                    $meetingCount,
                    $counselingMember,
                    $counselingHour,
                    $courseHour,
                    $workingMember,
                    $workingHour,
                    $groupCounselingHour,
                    $counselingYouth,
                    $trackDescription,
                    $year,
                    $date,
                    $no,
                    $funding,
                    $note
                );
            }
            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
                $executeModeText = $executeWayText = "";
                $countyManager = $this->UserModel->get_by_county_manager($county);
                $projects = $no ? $this->ProjectModel->get_project_and_organization_by_no($no) : null;

                foreach ($executeModes as $value) {
                    if ($value['no'] == (empty($projects) ? '' : $projects->execute_mode)) {
                        $executeModeText = $value['content'];
                    }

                }
                foreach ($executeWays as $value) {
                    if ($value['no'] == (empty($projects) ? '' : $projects->execute_way)) {
                        $executeWayText = $value['content'];
                    }
                }

                $recipient = $countyManager->email;
                $title = '【教育部青年發展署雙青計畫行政系統】' . $name . '計畫內容修改通知';
                $content = '<p>' . $countyManager->name . ' 君 您好:</p>'
                . '<p>縣市承辦人對計畫內容進行了更動</p>'
                . '<p>計畫案內容如下：</p>'
                . '<p>縣市 :' . $projects->countyName . '</p>'
                . '<p>計畫名稱 :' . $projects->name . '</p>'
                . '<p>機構名稱 :' . $projects->organizationName . '</p>'
                . '<p>機構電話 :' . $projects->phone . '</p>'
                . '<p>機構地址 :' . $projects->address . '</p>'
                . '<p>辦理模式 :' . $executeModeText . '</p>'
                . '<p>辦理方式 :' . $executeWayText . '</p>'
                . '<p>輔導員數量 :' . $projects->counselor_count . '</p>'
                . '<p>跨局處會議次數 :' . $projects->meeting_count . '</p>'
                . '<p>輔導會談-人數 :' . $projects->counseling_member . '</p>'
                . '<p>輔導會談-小時/人 :' . $projects->counseling_hour . '</p>'
                . '<p>生涯探索課程-小時 :' . $projects->course_hour . '</p>'
                . '<p>工作體驗-人數 :' . $projects->working_member . '</p>'
                . '<p>工作體驗-小時 :' . $projects->working_hour . '</p>'
                . '<p>計畫經費 :' . number_format($projects->funding) . '</p>'
                . '<p>祝 平安快樂</p><p></p>'
                . '<p>教育部青年發展署雙青計畫行政系統</p>'
                . '<p>' . date('Y-m-d') . '</p>'
                    . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                api_send_email_temp($recipient, $title, $content);
            } else {
                $beSentDataset['error'] = '新增失敗';
            }

            $projects = $no ? $this->ProjectModel->get_by_no($no) : null;

            $beSentDataset['projects'] = $projects;
            $beSentDataset['url'] = '/project/create_project/' . $no;

            $this->load->view('/project/create_project', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function project_and_county($year = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(2, 3, 4);
        if (in_array($current_role, $accept_role)) {
            $county = $passport['county'];
            $distinctYears = $this->ProjectModel->get_distinct_year_by_county($county);

            if (empty($year)) {
                $countyDelegateOrganizations = $this->ProjectModel->get_county_delegate_organization_by_county($county);
            } else {
                $countyDelegateOrganizations = $this->ProjectModel->get_county_delegate_organization_by_county_and_year($county, $year);
            }

            $beSentDataset = array(
                'title' => '計畫與其執行單位紀錄清單',
                'url' => '/project/project_and_county/' . $year,
                'role' => $current_role,
                'countyDelegateOrganizations' => $countyDelegateOrganizations,
                'distinctYears' => $distinctYears,
                'year' => $year,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $this->load->view('/project/project_and_county_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function project_table($no = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(2, 3, 4, 5);
        $county = $passport['county'];
        if (in_array($current_role, $accept_role)) {
            $projects = $no ? $this->ProjectModel->get_project_and_organization_by_no($no) : null;
            if($projects) {
              if($county != $projects->county) redirect('user/login');
            }
            $executeModes = $this->MenuModel->get_by_form_and_column('project', 'execute_mode');
            $executeWays = $this->MenuModel->get_by_form_and_column('project', 'execute_way');
            $beSentDataset = array(
                'title' => '計畫案資訊',
                'url' => '/project/create_project/' . $no,
                'role' => $current_role,
                'executeModes' => $executeModes,
                'executeWays' => $executeWays,
                'userTitle' => $userTitle,
                'projects' => $projects,
                'security' => $this->security,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $this->load->view('/project/project_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function manage_county_and_project_table($year = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(1, 8, 9);
        if (in_array($current_role, $accept_role)) {
            $counties = $this->CountyModel->get_all();
            $fundingApproveArray = [];

            for ($i = 0; $i < count($counties); $i++) {
                $fundingApproves = $this->FundingApproveModel->get_by_county_and_year($counties[$i]['no'], date("Y") - 1911, date("m"));

                array_push($fundingApproveArray, $fundingApproves);
            }

            $beSentDataset = array(
                'title' => '縣市計畫案管理',
                'url' => '/project/manage_county_and_project_table/' . $year,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'counties' => $counties,
                'security' => $this->security,
                'fundingApproveArray' => $fundingApproveArray,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $this->load->view('/project/manage_county_and_project_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function funding_table($county = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(1, 8, 9);
        if (in_array($current_role, $accept_role)) {
            $counties = $this->CountyModel->get_by_no_new($county);
            $fundingApproves = $this->FundingApproveModel->get_by_county($county);
            $beSentDataset = array(
                'title' => '經費管理',
                'url' => '/project/funding/' . $county,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'counties' => $counties,
                'security' => $this->security,
                'fundingApproves' => $fundingApproves,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $this->load->view('/project/funding_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function funding($county = null, $no = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(1, 8, 9);
        if (in_array($current_role, $accept_role)) {
            $counties = $this->CountyModel->get_by_no_new($county);
            $fundingApproves = $no ? $this->FundingApproveModel->get_by_no($no) : null;
            $beSentDataset = array(
                'title' => '經費管理',
                'url' => '/project/funding/' . $county . '/' . $no,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'counties' => $counties,
                'security' => $this->security,
                'fundingApproves' => $fundingApproves,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $date = $this->security->xss_clean($this->input->post('date'));
            $funding = $this->security->xss_clean($this->input->post('funding'));
            $note = $this->security->xss_clean($this->input->post('note'));

            if (empty($funding)) {
                return $this->load->view('/project/funding', $beSentDataset);
            }

            if (empty($fundingApproves)) {
                $isExecuteSuccess = $this->FundingApproveModel->create_one($county, $funding, $date, $note);
                $no = $isExecuteSuccess;

            } else {
                $isExecuteSuccess = $this->FundingApproveModel->update_by_no($county, $funding, $note, $date, $no);
            }

            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
                redirect('project/funding_table/' . $county);

            } else {
                $beSentDataset['error'] = '新增失敗';
            }

            $this->load->view('/project/funding', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function manage_project_table($county = 'all', $year = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(1, 8, 9);
        if (in_array($current_role, $accept_role)) {
            $counties = $this->CountyModel->get_all();
            $countyDelegateOrganizations = $this->ReportModel->get_county_delegate_organization($county, $year);
            $executeModes = $this->MenuModel->get_by_form_and_column('project', 'execute_mode');
            $executeWays = $this->MenuModel->get_by_form_and_column('project', 'execute_way');

            $beSentDataset = array(
                'title' => '計畫案管理',
                'url' => '/project/manage_project_table/' . $county . '/' . $year,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'counties' => $counties,
                'security' => $this->security,
                'countyDelegateOrganizations' => $countyDelegateOrganizations,
                'executeModes' => $executeModes,
                'executeWays' => $executeWays,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $this->load->view('/project/manage_project_table', $beSentDataset);
        } else {
            redirect('user/login');
        }

    }

    public function update_county_project($county = null, $updateProject = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(1, 8, 9);
        if (in_array($current_role, $accept_role)) {
            $counties = $this->CountyModel->get_all();

            if ($county == 'all') {
                foreach ($counties as $value) {
                    $isExecuteSuccess = $this->CountyModel->update_updateProject_by_county($value['no'], $updateProject);
                }
            } else {
                $isExecuteSuccess = $this->CountyModel->update_updateProject_by_county($county, $updateProject);
            }

            if ($isExecuteSuccess) {
                redirect('project/manage_project_table/' . $county . '/110');
            }

        } else {
            redirect('user/login');
        }
    }
}
