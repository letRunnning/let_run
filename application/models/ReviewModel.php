<?php
class ReviewModel extends CI_Model {
  /*
   * create one project
   * @Return: Boolean
   */
  function create_one($formName, $formNo, $reviewerRole, $status, $reason, 
    $updateColumn, $updateValue, $county) {

    $this->form_name = $formName;
    $this->form_no = $formNo;
    $this->reviewer_role = $reviewerRole;
    $this->status = $status;
    $this->reason = $reason;
    $this->update_column = $updateColumn;
    $this->update_value = $updateValue;
    $this->county = $county;
    $this->create_time = date('Y-m-d H:i:s');

    return ($this->db->insert('review', $this)) ? $this->db->insert_id() : false;
  }

  function create_note_one($formName, $formNo, $reviewerRole, $status, $reason, 
    $updateColumn, $updateValue, $county, $note) {

    $this->form_name = $formName;
    $this->form_no = $formNo;
    $this->reviewer_role = $reviewerRole;
    $this->status = $status;
    $this->reason = $reason;
    $this->update_column = $updateColumn;
    $this->update_value = $updateValue;
    $this->county = $county;
    $this->note = $note;
    $this->create_time = date('Y-m-d H:i:s');

    return ($this->db->insert('review', $this)) ? $this->db->insert_id() : false;
  }

  function update_one($status, $reviewer, $note, $no) {

    $this->status = $status;
    $this->reviewer = $reviewer;
    $this->note = $note;
    $this->end_time = date('Y-m-d H:i:s');
    
    $this->db->where('no', $no);

    return $this->db->update('review', $this);
  }

  function get_by_formName_and_formNo($formName, $formNo) {
    $this->db->where('form_name', $formName);
    $this->db->where('form_no', $formNo);
    $this->db->order_by("create_time", "asc");
    return $this->db->get('review')->result_array();
  }

  /*
   * get project by county
   * @Return: array of county object
   */
  function get_by_county($county, $role) {
    $this->db->where('reviewer_role', $role);
    $this->db->where('county', $county);
    $this->db->order_by("status", "asc");
    return $this->db->get('review')->result_array();
  }

  function get_by_status($status, $county, $role) {
    $this->db->where('reviewer_role', $role);
    $this->db->where('county', $county);
    $this->db->where('status', $status);
    $this->db->order_by("create_time", "desc");
    return $this->db->get('review')->result_array();
  }

  function get_by_yda() {
    $this->db->where('reviewer_role', 1);
    $this->db->order_by("status", "asc");
    return $this->db->get('review')->result_array();
  }

  function get_by_youth_pre_county($formName, $formNo) {
    $this->db->where('form_name', $formName);
    $this->db->where('form_no', $formNo);
    $this->db->order_by("create_time", "desc");
    return $this->db->get('review', 2)->result_array();
  }


   /*
   * get project by county
   * @Return: array of county object
   */
  function get_by_no($no) {
    $this->db->where('no', $no);
    return $this->db->get('review', 1)->row();
  }

  function get_by_case_assessment($caseAssessmentNo, $statusWaiting) {
    $this->db->where('form_name', 'case_assessment');
    $this->db->where('form_no', $caseAssessmentNo);
    $this->db->where('status', $statusWaiting);
    $this->db->where('reviewer_role', 4);
    return $this->db->get('review')->result_array();
  }

  function create_review_process($report_no, $review_status, $report_name)
    {
      return $this->db->query("INSERT INTO `review_process` (`no`, `report_name`, `report_no`, `review_process`, `review_status`) VALUES (NULL, '$report_name', $report_no, 6, $review_status)
      , (NULL, '$report_name', $report_no, 3, $review_status), (NULL, '$report_name', $report_no, 1, $review_status);");
    }
    function update_review_process($report_no, $review_status, $report_name)
    {
      return $this->db->query("UPDATE `review_process` SET `review_status` = '$review_status' WHERE `review_process`.`no` = $report_no AND `report_name` = '$report_name';");
    }
    function create_review_log($report_no, $review_status, $time, $comment, $role, $uID, $report_name)
    {
      return $this->db->query("INSERT INTO `review_log` (`no`, `report_name`, `report_no`,`review_status`,`time`,`comment`,`user_role`,`user_id`) 
      VALUES (NULL, '$report_name', $report_no,$review_status,'$time','$comment',$role,'$uID');");
    }
    function get_review_log_status_comment($role, $report_no, $report_name)
    {
      $query = $this->db->query("SELECT * FROM `review_log` WHERE `report_name` = '$report_name' AND `report_no`=$report_no ORDER BY `time` ASC");
      if ($query->num_rows()) {
        return $query->result_array();
      }
    }
    function get_review_process($report_no, $report_name)
    {
      $query = $this->db->query("SELECT * FROM `review_process` WHERE `report_name`= '$report_name'
      AND `report_no`=$report_no");
      if ($query->num_rows()) {
        return $query->result_array();
      }
    }

    function get_county_contractor($county)
    {
      $this->db->select('users.name,users.id');
      $this->db->from('users');
      $this->db->where('county', $county);
      $this->db->where('manager', 0);
      $this->db->where('organization', null);
      $result = $this->db->get()->result_array();
      return $result;
    }

    
  
    function get_first_submit_conse_id($report_no, $report_name)
    {
      $query = $this->db->query("SELECT * FROM `review_log` WHERE `report_name` = '$report_name' AND `report_no`=$report_no ORDER BY `time` ASC");
      if ($query->num_rows()) {
        return $query->row();
      }
    }

}