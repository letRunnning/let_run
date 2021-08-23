<?php
class Beacon extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MapModel');
        $this->load->model('UserModel');
    }
    public function beacon_table($no = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '新增Beacon',
                'url' => '/beacon/beacon/'.$no,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password']
            );

            $this->load->view('/beacon/beacon_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    public function beacon($no = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '新增Beacon',
                'url' => '/beacon/beacon/'.$no,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password']
            );

            $this->load->view('/beacon/beacon', $beSentDataset);
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
    public function show_map()
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        $route = $this->MapModel->get_route('A1','休閒組');
        $data = array();
        foreach($route as $i){
            $array = array( 
                'running_ID' => $i['running_ID'],
                'group_name' => urlencode($i['group_name']),
                'detail' => urlencode($i['detail']),
                'longitude' => $i['longitude'], // 因為有中文所以要用 urlencode 去 encode
                'latitude' => $i['latitude']
            );
            array_push($data, $array);
        }
        $data = urldecode(json_encode($data, JSON_PRETTY_PRINT));
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => 'google map',
                'url' => '/beacon/show_map/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'route' => $route,
                'data' => $data
            );

            $this->load->view('/beacon/show_map', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }


}