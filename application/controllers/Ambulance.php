<?php
class Ambulance extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('AmbulanceModel');
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

        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '救護車資訊',
                'url' => '/ambulance/ambulance/' . $liciense,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'security' => $this->security,
                'ambulance' => $ambulance
            );

            $hospital = $this->security->xss_clean($this->input->post('hospital'));
            $hospitalPhone = $this->security->xss_clean($this->input->post('hospitalPhone'));
            $liciense = $this->security->xss_clean($this->input->post('licensePlate'));

            if (empty($liciense)) return $this->load->view('/ambulance/ambulance', $beSentDataset);

            if (empty($ambulance)) {
                $isExecuteSuccess = $this->AmbulanceModel->create_one($hospital, $hospitalPhone, $liciense);
            } else {
                $isExecuteSuccess = $this->AmbulanceModel->update_by_id($hospital, $hospitalPhone, $liciense);
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