<?php
class Checkin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('CheckinModel');
    }

    public function staff_checkin_table()
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        $checkin = $this->CheckinModel->get_all_staff_checkin();

        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '工作人員報到狀態',
                'url' => '/checkin/staff_checkin_table/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'checkin' => $checkin
            );

            $this->load->view('/checkin/staff_checkin_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function member_checkin_table()
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        $registration = $this->CheckinModel->get_all_registration();

        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '會員報到狀態',
                'url' => '/checkin/member_checkin_table/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'registration' => $registration
            );

            $this->load->view('/checkin/member_checkin_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
}