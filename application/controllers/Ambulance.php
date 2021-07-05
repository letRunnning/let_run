<?php
class Ambulance extends CI_Controller
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

    public function ambulance_table()
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '救護車清單',
                'url' => '/ambulance/ambulance_table/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password']
            );

            $this->load->view('/ambulance/ambulance_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    
    public function ambulance()
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '救護車資訊',
                'url' => '/ambulance/ambulance/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password']
            );

            $this->load->view('/ambulance/ambulance', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function ambulance_place_table()
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '救護車停置點清單',
                'url' => '/ambulance/ambulance_place_table/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password']
            );

            $this->load->view('/ambulance/ambulance_place_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function ambulance_place()
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '救護車停置點',
                'url' => '/ambulance/ambulance_place/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password']
            );

            $this->load->view('/ambulance/ambulance_place', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
}