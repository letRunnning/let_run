<?php
class ReviewLogModel extends CI_Model {
  /*
   * create one project
   * @Return: Boolean
   */
  function create_one($reportName, $reportNo, $reviewStatus, $comment, 
    $userRole, $userId) {

    $this->report_name = $reportName;
    $this->report_no = $reportNo;
    $this->review_status = $reviewStatus;
    $this->time = date('Y-m-d H:i:s');
    $this->comment = $comment;
    $this->user_role = $userRole;
    $this->user_id = $userId;

    return ($this->db->insert('review_log', $this)) ? $this->db->insert_id() : false;
  }

  function get_by_report_no($reportName, $reportNo) {
    $this->db->select('review_log.*, users.name as userName');
    $this->db->join('users', 'review_log.user_id = users.id');
    $this->db->where('report_no', $reportNo);
    $this->db->where('report_name', $reportName);
    return $this->db->get('review_log')->result_array();
  }


}