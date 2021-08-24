<?php
class Check extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('CheckModel');
        $this->load->model('RunModel');
    }

    public function staff_apply_table($rid = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);

        $runID = $rid ? $rid : null;
        $activities = $this->RunModel->get_all_active();
        $application = $this->CheckModel->get_all_staff_application();
        $applications = $rid ? $this->CheckModel->get_staff_apply_by_runningID($rid) : null;

        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '工作人員申請活動',
                'url' => '/check/staff_apply_table/' . $rid,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'runID' => $runID,
                'activities' => $activities,
                'application' => $application,
                'applications' => $applications
            );

            $this->load->view('/check/staff_apply_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function member_pay_status_table()
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);

        $pay = $this->CheckModel->get_all_member_pay();

        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '繳費狀態',
                'url' => '/check/member_pay_status_table/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'pay' => $pay
            );

            $this->load->view('/check/member_pay_status_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    
    public function gift_status_table()
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);

        $status = $this->CheckModel->get_all_gift_status();

        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '兌換禮品狀態',
                'url' => '/check/gift_status_table/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'status' => $status
            );

            $this->load->view('/check/gift_status_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }


}