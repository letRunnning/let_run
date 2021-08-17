<?php
class Beacon extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('BeaconModel');
        $this->load->model('BeaconPlacementModel');
        $this->load->model('RunModel');
        $this->load->model('SupplyLocationModel');
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
                redirect('beacon/beacon_table');
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

    public function beacon_placement_table()
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        $beaconPlacement = $this->BeaconPlacementModel->get_all_beacon_placement();

        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => 'Beacon放置點清單',
                'url' => '/beacon/beacon_placement_table/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'beaconPlacement' => $beaconPlacement
            );

            $this->load->view('/beacon/beacon_placement_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    
    public function beacon_placement($beaconID = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);

        $beaconPlacement = $beaconID ? $this->BeaconPlacementModel->get_beacon_placement_by_id($beaconID) : null;
        $beacons = $this->BeaconModel->get_all_beacon();
        $activities = $this->RunModel->get_all_active();
        $supply = $this->SupplyLocationModel->get_all_supply_location();

        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => 'Beacon放置點',
                'url' => '/beacon/beacon_placement/' . $beaconID,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'security' => $this->security,
                'beaconPlacement' => $beaconPlacement,
                'beacons' => $beacons,
                'activities' => $activities,
                'supply' => $supply
            );

            $beaconID = $this->security->xss_clean($this->input->post('beaconID'));
            $runActive = $this->security->xss_clean($this->input->post('runActive'));
            $supplyID = $this->security->xss_clean($this->input->post('supplyID'));

            if (empty($beaconID)) return $this->load->view('/beacon/beacon_placement', $beSentDataset);

            if (empty($beaconPlacement)) {
                $isExecuteSuccess = $this->BeaconPlacementModel->create_one($beaconID, $runActive, $supplyID);
            } else {
                $isExecuteSuccess = $this->BeaconPlacementModel->update_by_id($beaconID, $runActive, $supplyID);
            }

            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
                redirect('beacon/beacon_placement_table');
            } else {
                $beSentDataset['error'] = '新增失敗';
                redirect('beacon/beacon_placement_table');
            }
            
            $beaconPlacement = $beaconID ? $this->BeaconPlacementModel->get_by_id($beaconID) : null;
            $beSentDataset['beaconPlacement'] = $beaconPlacement;
            $placement = $this->BeaconPlacementModel->get_all_beacon_placement();
            $beSentDataset['placement'] = $placement;

            $this->load->view('/beacon/beacon_placement_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
}