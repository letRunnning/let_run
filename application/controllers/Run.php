<?php
class Run extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('RunModel');
        $this->load->model('MenuModel');
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

    public function run_active_table()
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        $activities = $this->RunModel->get_all_active();
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '路跑活動清單',
                'url' => '/run/run_active/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'activities' => $activities,
                'password' => $passport['password']
            );
            // foreach ($activities as $i) {
            //     echo $i['name'];
            // }

            $this->load->view('/run/run_active_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    public function run_active($runNo= null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        $activity = $this->RunModel->get_active_by_id($runNo);
        
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '路跑活動詳細內容',
                'url' => '/run/run_active/'.$runNo,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'activity' => $activity,
                'password' => $passport['password']
            );

            $this->load->view('/run/run_active', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    public function workgroup()
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '路跑工作組別',
                'url' => '/run/workgroup/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password']
            );

            $this->load->view('/run/workgroup', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    public function rungroup_gift_table()
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '路跑組別 & 禮品',
                'url' => '/run/rungroup_gift_table/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password']
            );

            $this->load->view('/run/rungroup_gift_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    public function rungroup_gift($rungroupNo = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '路跑禮品表單',
                'url' => '/run/rungroup_gift/'.$rungroupNo,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password']
            );

            $this->load->view('/run/rungroup_gift', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    public function pass_point_table($no = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '路跑經過點',
                'url' => '/run/pass_point/'.$no,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password']
            );

            $this->load->view('/run/pass_point_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    public function pass_point($no = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '路跑經過點表單',
                'url' => '/run/pass_point/'.$no,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password']
            );

            $this->load->view('/run/pass_point', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    public function route_table($no = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '路跑路線',
                'url' => '/run/route/'.$no,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password']
            );

            $this->load->view('/run/route_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    public function route($no = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '路跑路線',
                'url' => '/run/route/'.$no,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password']
            );

            $this->load->view('/run/route', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function print_join_proof()
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '列印參賽證明',
                'url' => '/run/print_join_proof/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password']
            );

            $this->load->view('/run/print_join_proof', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function dynamic_position_graph()
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '動態位置圖表',
                'url' => '/run/dynamic_position_graph/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password']
            );

            $this->load->view('/run/dynamic_position_graph', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
}