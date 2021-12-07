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

    public function ambulance_table($hospital = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);

        $hospitalName = base64_decode($hospital) ? base64_decode($hospital) : null;
        $hospitals = $this->AmbulanceModel->get_ambulance_hospital_name();
        $ambulance = $this->AmbulanceModel->get_all_ambulance();
        $ambulances = base64_decode($hospital) ? $this->AmbulanceModel->get_ambulance_by_name(base64_decode($hospital)) : null;

        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '救護車清單',
                'url' => '/ambulance/ambulance_table/' . base64_decode($hospital),
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'hospitalName' => $hospitalName,
                'hospitals' => $hospitals,
                'ambulance' => $ambulance,
                'ambulances' => $ambulances
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
            $liciense = $this->security->xss_clean($this->input->post('liciensePlate'));

            if (empty($liciense)) return $this->load->view('/ambulance/ambulance', $beSentDataset);

            if (empty($ambulance)) {
                $isExecuteSuccess = $this->AmbulanceModel->create_one($hospital, $hospitalPhone, $liciense);
                $licensePlate = $isExecuteSuccess;
            } else {
                $isExecuteSuccess = $this->AmbulanceModel->update_by_id($hospital, $hospitalPhone, $liciense);
                $licensePlate = $liciense;
            }

            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
            } else {
                $beSentDataset['error'] = '新增失敗';
            }

            $ambulance = $licensePlate ? $this->AmbulanceModel->get_ambulance_by_id($licensePlate) : null;
            $beSentDataset['ambulance'] = $ambulance;
            $beSentDataset['url'] = '/ambulance/ambulance/' . $licensePlate;

            $this->load->view('/ambulance/ambulance', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function ambulance_placement_table($rid = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);

        $runID = $rid ? $rid : null;
        $activities = $this->RunModel->get_all_active();
        $ambulancePlacement = $this->AmbulancePlacementModel->get_all_ambulance_placement();
        $ambulancePlacements = $rid ? $this->AmbulancePlacementModel->get_ambulance_placement_by_runningID($rid) : null;

        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '救護車停置點清單',
                'url' => '/ambulance/ambulance_placement_table/' . $rid,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'ambulancePlacement' => $ambulancePlacement,
                'runID' => $runID,
                'activities' => $activities,
                'ambulancePlacements' => $ambulancePlacements
            );

            $this->load->view('/ambulance/ambulance_placement_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function ambulance_placement($no = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);

        $ambulancePlacement = $this->AmbulancePlacementModel->get_ambulance_placement_by_id($no);
        $activities = $this->RunModel->get_all_active();
        $pass = $this->PassingPointModel->get_all_passing_point();
        $ambulanceDetails = $this->AmbulanceModel->get_ambulance_hospital_name();
        $liciensePlate =  $this->AmbulanceModel->get_all_ambulance();

        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '救護車停置點',
                'url' => '/ambulance/ambulance_placement/' . $no,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'security' => $this->security,
                'no' => $no,
                'ambulancePlacement' => $ambulancePlacement,
                'activities' => $activities,
                'pass' => $pass,
                'ambulanceDetails' => $ambulanceDetails,
                'liciensePlate' => $liciensePlate
            );

            $running = $this->security->xss_clean($this->input->post('runActive'));
            $supply = $this->security->xss_clean($this->input->post('supply'));
            $licienseNum = $this->security->xss_clean($this->input->post('liciense'));
            $time = $this->security->xss_clean($this->input->post('time'));

            if (empty($licienseNum)) return $this->load->view('/ambulance/ambulance_placement', $beSentDataset);

            if (empty($ambulancePlacement)) {
                $isExecuteSuccess = $this->AmbulancePlacementModel->create_one($running, $supply, $licienseNum, $time);
                $id = $isExecuteSuccess;
                echo 1;
            } else {
                $isExecuteSuccess = $this->AmbulancePlacementModel->update_by_id($no, $running, $supply, $licienseNum, $time);
                $id = $no;
                echo 2;
            }

            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
            } else {
                $beSentDataset['error'] = '新增失敗';
            }

            $ambulancePlacement = $id ? $this->AmbulancePlacementModel->get_ambulance_placement_by_id($id) : null;
            $beSentDataset['ambulancePlacement'] = $ambulancePlacement;
            $beSentDataset['url'] = '/ambulance/ambulance_placement/' . $id;

            $this->load->view('/ambulance/ambulance_placement', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
}