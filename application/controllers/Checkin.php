<?php
class Checkin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('CheckinModel');
        $this->load->model('RunModel');
    }

    public function staff_checkin_table($rid = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);

        $runID = $rid ? $rid : null;
        $activities = $this->RunModel->get_all_active();
        $checkin = $this->CheckinModel->get_all_staff_checkin();
        $checkinByid = $rid ? $this->CheckinModel->get_staff_checkin_by_runningID($rid) : null;
        
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '工作人員報到狀態',
                'url' => '/checkin/staff_checkin_table/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'runID' => $runID,
                'activities' => $activities,
                'checkin' => $checkin,
                'checkinByid' => $checkinByid
            );

            $this->load->view('/checkin/staff_checkin_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function member_checkin_table($rid = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);

        $runID = $rid ? $rid : null;
        $activities = $this->RunModel->get_all_active();
        $registration = $this->CheckinModel->get_all_registration();
        $registrations = $rid ? $this->CheckinModel->get_member_checkin_by_runningID($rid) : null;

        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '會員報到狀態',
                'url' => '/checkin/member_checkin_table/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'runID' => $runID,
                'activities' => $activities,
                'registration' => $registration,
                'registrations' => $registrations
            );

            $this->load->view('/checkin/member_checkin_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
}