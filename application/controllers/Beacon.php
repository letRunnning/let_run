<?php
class Beacon extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('BeaconModel');
    }

    public function beacon_table()
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        $beacons = $this->BeaconModel->get_all_beacon();

        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => 'Beacon清單',
                'url' => '/beacon/beacon_table/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'beacons' => $beacons
            );

            $this->load->view('/beacon/beacon_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function beacon($beaconID = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);

        $beacon = $beaconID ? $this->BeaconModel->get_beacon_by_id($beaconID) : null;

        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => 'Beacon',
                'url' => '/beacon/beacon/' . $beaconID,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'security' => $this->security,
                'beacon' => $beacon
            );
            // print_r($beacon);

            $beaconID = $this->security->xss_clean($this->input->post('beaconID'));
            $beaconType = $this->security->xss_clean($this->input->post('beaconType'));
            $isAvailable = $this->security->xss_clean($this->input->post('isAvailable'));

            if (empty($beaconID)) return $this->load->view('/beacon/beacon', $beSentDataset);

            if (empty($beacon)) {
                $isExecuteSuccess = $this->BeaconModel->create_one($beaconID, $beaconType, $isAvailable);
            } else {
                $isExecuteSuccess = $this->BeaconModel->update_by_id($beaconID, $beaconType, $isAvailable);
            }

            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
                redirect('beacon/beacon_table');
            } else {
                $beSentDataset['error'] = '新增失敗';
            }

            $beacon = $beaconID ? $this->BeaconModel->get_by_id($beaconID) : null;
            $beSentDataset['beacon'] = $beacon;
            $beacons = $this->BeaconModel->get_all_beacon();
            $beSentDataset['beacons'] = $beacons;

            $this->load->view('/beacon/beacon_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function beacon_place_table()
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => 'Beacon放置點清單',
                'url' => '/beacon/beacon_place_table/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password']
            );

            $this->load->view('/beacon/beacon_place_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    
    public function beacon_place()
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => 'Beacon放置點',
                'url' => '/beacon/beacon_place/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password']
            );

            $this->load->view('/beacon/beacon_place', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }


}