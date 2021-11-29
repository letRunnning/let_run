<?php
class Prints extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('RunModel');
        $this->load->model('FileModel');
        $this->load->model('AssignModel');
        $this->load->model('MapModel');
        $this->load->model('PrintsModel');
    }
    public function beacon_qrcode($runNo = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        $runID = $runNo ? $runNo : null;
        $activities = $this->RunModel->get_all_active();
        $activity = $runNo ? $this->RunModel->get_active_by_id($runNo) : null;
        $qrcodes = $runNo ? $this->PrintsModel->get_beacons_by_id($runNo) : null;
        if($qrcodes!= null){
            require_once 'phpqrcode/qrlib.php';
            $path = './files/qrcode/';
            foreach($qrcodes as $re){
                $name = base64_encode($re['beacon_ID']);
                $file = $path.$name.".png";
                QRcode::png($re['beacon_ID'], $file); // 產生qrcode，並存入image資料夾下
            }
        }
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '列印Beacon Qrcode',
                'url' => '/prints/beacon_qrcode/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'activities' => $activities,
                'activity' => $activity,
                'runID' => $runID,
                'qrcodes' => $qrcodes
            );

            $this->load->view('/prints/beacon_qrcode', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    public function run_qrcode($runNo = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        $runID = $runNo ? $runNo : null;
        $activities = $this->RunModel->get_all_active();
        $activity = $runNo ? $this->RunModel->get_active_by_id($runNo) : null;
        $qrcodes = $runNo ? $this->PrintsModel->get_beacons_by_id($runNo) : null;
        if($runNo!= null){
            require_once 'phpqrcode/qrlib.php';
            $path = './files/qrcode/';
            // foreach($qrcodes as $re){
            $name = base64_encode($runNo);
            $file = $path.$name.".png";
            QRcode::png($runNo, $file); // 產生qrcode，並存入image資料夾下
            // }
        }
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '列印路跑活動 Qrcode',
                'url' => '/prints/run_qrcode/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'activities' => $activities,
                'activity' => $activity,
                'runID' => $runID,
                'qrcodes' => $qrcodes
            );

            $this->load->view('/prints/run_qrcode', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    public function supply_qrcode($runNo = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        $runID = $runNo ? $runNo : null;
        $activities = $this->RunModel->get_all_active();
        $activity = $runNo ? $this->RunModel->get_active_by_id($runNo) : null;
        $supplys = $runNo ? $this->PrintsModel->get_supplys_by_id($runNo) : null;
        if($supplys!= null){
            require_once 'phpqrcode/qrlib.php';
            $path = './files/qrcode/';
            foreach($supplys as $re){
                $name = base64_encode($re['supply_ID']);
                $file = $path.$name.".png";
                QRcode::png($re['supply_ID'], $file); // 產生qrcode，並存入image資料夾下
            }
        }
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '列印補給站 Qrcode',
                'url' => '/prints/supply_qrcode/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'activities' => $activities,
                'activity' => $activity,
                'runID' => $runID,
                'supplys' => $supplys
            );

            $this->load->view('/prints/supply_qrcode', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
}