<?php
class Organization extends CI_Controller{
  function __construct(){
    parent::__construct();
    $this->load->model('OrganizationModel');
  }

  function create_organization() {
    $passport = $this->session->userdata('passport');
    $current_role = $passport['role'];
    $userTitle = $passport['userTitle'];
    $accept_role = array(2,3);
    if(in_array($current_role, $accept_role)) {
      $beSentDataset = array(
        'title' => '新增計畫執行機構',
        'url' => '/organization/create_organization',
        'role' => $current_role,
        'userTitle' => $userTitle,
        'security' => $this->security,
        'password' => $passport['password'],
        'updatePwd' => $passport['updatePwd']
      );
      $county = $passport['county'];
      // get data from frontend
      $name = $this->security->xss_clean($this->input->post('name'));
      $phone = $this->security->xss_clean($this->input->post('phone'));
      $address = $this->security->xss_clean($this->input->post('address'));
      if(empty($name) || empty($phone) || empty($address)) {
        return $this->load->view('/organization/create_organization', $beSentDataset);
      }
      // fetch data from model
      $isNameExist = $this->OrganizationModel->is_name_exist($name);
      if($isNameExist) {
        $beSentDataset['error'] = '已經存在相同名稱的機構了';
      } else {
        $isExecuteSuccess = $this->OrganizationModel->create_one($county, $name, $phone, $address);
        if($isExecuteSuccess) {
          $beSentDataset['success'] = '新增成功';
          redirect('county/delegate_project_to_organization');
        } else {
          $beSentDataset['error'] = '新增失敗';
        }
      }
      $this->load->view('/organization/create_organization', $beSentDataset);
    } else {
      redirect('user/login');
    }
  }
}