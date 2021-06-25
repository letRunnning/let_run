<?php
class DblogModel extends CI_Model {
  
  function get_log($account, $startTime, $endTime) {
  
    $this->db->where('user', $account);
    $this->db->where('time >=', $startTime);
    $this->db->where('time <=', $endTime);
    $this->db->group_by("time");
    $result = $this->db->get('db_log')->result_array();
    return $result;
  }


}