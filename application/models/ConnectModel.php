<?php
class ConnectModel extends CI_Model {

  function update_file($file, $no) {

	
    $this->file = $file;
	
    $this->db->where('no', $no);
    return $this->db->update('download_file', $this);
	}

  function update_user_password($id, $password) {

    $this->password = $password;
    $this->db->where('id', $id);
    return $this->db->update('users', $this);
  }

  function update_user_usable($id, $usable) {

    $this->usable = $usable;
    $this->db->where('id', $id);
    return $this->db->update('users', $this);
  }

  function update_user_county_and_organization($id, $county, $organization) {

    $this->county = $county;
    $this->organization = $organization;
    $this->db->where('id', $id);
    return $this->db->update('users', $this);
  }

  function get_table($tableName, $columnArray, $conditionArray) {
    if(count($columnArray)>0) {
      for ($i = 0; $i < count($columnArray); $i++) {
        $this->db->where($columnArray[$i], $conditionArray[$i]);
      }
    }

    $result = $this->db->get($tableName)->result_array();
    return $result;
  }

  function update_table($tableName, $updateColumn, $updateValue, $columnArray, $conditionArray) {
    $this->$updateColumn = $updateValue;
    if(count($columnArray)>0) {
      for ($i = 0; $i < count($columnArray); $i++) {
        $this->db->where($columnArray[$i], $conditionArray[$i]);
      }
    }

    return $this->db->update($tableName, $this);
  }

  function get_case() {
    $result = $this->db->get('case_assessment')->result_array();
    return $result;
  }

  function update_case($no, $major) {
    $this->major_setback = $major;
    $this->db->where('no', $no);
    return $this->db->update('case_assessment', $this);
  }

  function get_case_temp() {
    $result = $this->db->get('case_assessment_temp')->result_array();
    return $result;
  }

  function update_case_temp($no, $major) {
    $this->major_setback = $major;
    $this->db->where('no', $no);
    return $this->db->update('case_assessment_temp', $this);
  }

  
}