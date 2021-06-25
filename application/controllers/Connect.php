<?php
class Connect extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ConnectModel');
       
    }

    public function update_user_password($token = null, $id = null, $password = null) {
      $key = $this->config->item('connect_token');

      if($token != $key || empty($id)) {
        return show_404();
      }

      $password = $password ? $password : '$2y$10$LaQJhjZaK/ncz2trvP403OWZXCybQ9OouE/YlJMyJgOOFBBKohW5e';
      $isExecuteSuccess = $this->ConnectModel->update_user_password($id, $password);

      if($isExecuteSuccess) print_r('success');
      else print_r('error');
    }

    public function update_user_usable($token = null, $id = null, $usable = null) {
      $key = $this->config->item('connect_token');

      if($token != $key || empty($id)) {
        return show_404();
      }

      $isExecuteSuccess = $this->ConnectModel->update_user_usable($id, $usable);

      if($isExecuteSuccess) print_r('success');
      else print_r('error');
    }

    public function update_user_county_and_organization($token = null, $id = null, $county = null, $organization = null) {
      $key = $this->config->item('connect_token');
      if($token != $key || empty($id) || empty($county) || empty($organization)) {
        return show_404();
      }

      $isExecuteSuccess = $this->ConnectModel->update_user_county_and_organization($id, $county, $organization);

      if($isExecuteSuccess) print_r('success');
      else print_r('error');
    }

    public function select_table($token = null, $tableName = null, $columnOne = null, $conditionOne = null, $columnTwo = null, $conditionTwo = null, $columnThree = null, $conditionThree = null) {
      $key = $this->config->item('connect_token');
      if($token != $key || empty($tableName)) {
        return show_404();
      }

      $columnArray = $conditionArray = [];

      if($columnOne) array_push($columnArray, $columnOne);
      if($columnTwo) array_push($columnArray, $columnTwo);
      if($columnThree) array_push($columnArray, $columnThree);
      if($conditionOne) array_push($conditionArray, $conditionOne);
      if($conditionTwo) array_push($conditionArray, $conditionTwo);
      if($conditionThree) array_push($conditionArray, $conditionThree);

      $isExecuteSuccess = $this->ConnectModel->get_table($tableName, $columnArray, $conditionArray);

      if($isExecuteSuccess) print_r($isExecuteSuccess);
      else print_r('error');
    }

    public function update_table($token = null, $tableName = null, $updateColumn = null, $updateValue = null, $columnOne = null, $conditionOne = null, $columnTwo = null, $conditionTwo = null, $columnThree = null, $conditionThree = null) {
      $key = $this->config->item('connect_token');
      if($token != $key || empty($tableName)) {
        return show_404();
      }

      $columnArray = $conditionArray = [];

      if($columnOne) array_push($columnArray, $columnOne);
      if($columnTwo) array_push($columnArray, $columnTwo);
      if($columnThree) array_push($columnArray, $columnThree);
      if($conditionOne) array_push($conditionArray, $conditionOne);
      if($conditionTwo) array_push($conditionArray, $conditionTwo);
      if($conditionThree) array_push($conditionArray, $conditionThree);

      $isExecuteSuccess = $this->ConnectModel->update_table($tableName, $updateColumn, $updateValue, $columnArray, $conditionArray);

      if($isExecuteSuccess) print_r('success');
      else print_r('error');
    }

    public function change() {
      $all = $this->ConnectModel->get_case();
      

      foreach($all as $value) {
        $major = $value['major_setback'] . "\n" . $value['family_major_setback'];
        $OK = $this->ConnectModel->update_case($value['no'], $major);
      }
    }

    // public function change_temp() {
    //   $all = $this->ConnectModel->get_case_temp();
      

    //   foreach($all as $value) {
    //     $major = $value['major_setback'] . "\n" . $value['family_major_setback'];
    //     print_r($value['major_setback']);
    //     print_r($value['family_major_setback']);
    //     $OK = $this->ConnectModel->update_case_temp($value['no'], $major);
    //   }
    // }


}
