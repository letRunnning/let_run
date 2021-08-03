<?php
class Ambulance extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('AmbulanceModel');
        $this->load->model('AmbulancePlacementModel');
        $this->load->model('RunModel');
        $this->load->model('PassingPointModel');
    }

    public function ambulance_table()
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        $ambulance = $this->AmbulanceModel->get_all_ambulance();

        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '救護車清單',
                'url' => '/ambulance/ambulance_table/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'ambulance' => $ambulance
            );

            $this->load->view('/ambulance/ambulance_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    
    public function ambulance($liciense = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);

        $ambulance = $liciense ? $this->AmbulanceModel->get_ambulance_by_id($liciense) : null;
        $activities = $this->RunModel->get_all_active();
        $pass = $this->PassingPointModel->get_all_passing_point();

        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '救護車資訊',
                'url' => '/ambulance/ambulance/' . $liciense,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'security' => $this->security,
                'ambulance' => $ambulance,
                'activities' => $activities,
                'pass' => $pass
            );

            $hospital = $this->security->xss_clean($this->input->post('hospital'));
            $hospitalPhone = $this->security->xss_clean($this->input->post('hospitalPhone'));
            $liciense = $this->security->xss_clean($this->input->post('liciensePlate'));
            $running = $this->security->xss_clean($this->input->post('runActive'));
            $passPoint = $this->security->xss_clean($this->input->post('passPoint'));
            $time = $this->security->xss_clean($this->input->post('time'));

            if (empty($liciense)) return $this->load->view('/ambulance/ambulance', $beSentDataset);

            if (empty($ambulance)) {
                $isExecuteSuccess = $this->AmbulanceModel->create_one($hospital, $hospitalPhone, $liciense, $running, $passPoint, $time);
            } else {
                $isExecuteSuccess = $this->AmbulanceModel->update_by_id($hospital, $hospitalPhone, $liciense, $running, $passPoint, $time);
            }

            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
                redirect('ambulance/ambulance_table');
            } else {
                $beSentDataset['error'] = '新增失敗';
                redirect('ambulance/ambulance_table');
            }

            $ambulance = $liciense ? $this->AmbulanceModel->get_by_id($liciense) : null;
            $beSentDataset['ambulance'] = $ambulance;
            $ambulances = $this->AmbulanceModel->get_all_ambulance();
            $beSentDataset['ambulances'] = $ambulances;

            $this->load->view('/ambulance/ambulance_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    // public function ambulance_placement_table()
    // {
    //     $passport = $this->session->userdata('passport');
    //     $userTitle = $passport['userTitle'];
    //     $current_role = $passport['role'];
    //     $accept_role = array(6);

    //     $ambulancePlacement = $this->AmbulancePlacementModel->get_all_ambulance_placement();

    //     if (in_array($current_role, $accept_role)) {
    //         $beSentDataset = array(
    //             'title' => '救護車停置點清單',
    //             'url' => '/ambulance/ambulance_placement_table/',
    //             'role' => $current_role,
    //             'userTitle' => $userTitle,
    //             'current_role' => $current_role,
    //             'password' => $passport['password'],
    //             'ambulancePlacement' => $ambulancePlacement
    //         );

    //         $this->load->view('/ambulance/ambulance_placement_table', $beSentDataset);
    //     } else {
    //         redirect('user/login');
    //     }
    // }

    // public function ambulance_placement($liciense = null)
    // {
    //     $passport = $this->session->userdata('passport');
    //     $userTitle = $passport['userTitle'];
    //     $current_role = $passport['role'];
    //     $accept_role = array(6);

    //     $activities = $this->RunModel->get_all_active();
    //     $pass = $this->PassingPointModel->get_all_passing_point();
    //     $ambulance = $liciense ? $this->AmbulanceModel->get_ambulance_placement_by_id($liciense) : null;

    //     if (in_array($current_role, $accept_role)) {
    //         $beSentDataset = array(
    //             'title' => '救護車停置點',
    //             'url' => '/ambulance/ambulance_placement/' . $liciense,
    //             'role' => $current_role,
    //             'userTitle' => $userTitle,
    //             'current_role' => $current_role,
    //             'password' => $passport['password'],
    //             'security' => $this->security,
    //             'activities' => $activities,
    //             'ambulance' => $ambulance,
    //             'pass' => $pass
    //         );

    //         $this->load->view('/ambulance/ambulance_placement', $beSentDataset);
    //     } else {
    //         redirect('user/login');
    //     }
    // }
}