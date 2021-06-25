<?php
class EndCaseModel extends CI_Model {
  /*
   * create one end_case
   * @Return: Boolean
   */

  function create_one($member, $trend, $workDescription, $isOriginCompany,
   $schoolDescription, $trainingDescription, $isCompleteCounsel, $completeCounselReason, 
   $isTransfer, $transferPlace, $transferReason, $unresistibleReason, $otherDescription) {
    // youth basic information
    $this->member = $member;
    $this->trend = $trend;
    $this->work_description = $workDescription;
    $this->is_origin_company = $isOriginCompany;
    $this->school_description = $schoolDescription;
    $this->training_description = $trainingDescription;
    $this->is_complete_counsel = $isCompleteCounsel;
    $this->complete_counsel_reason = $completeCounselReason;
    $this->is_transfer = $isTransfer;
    $this->transfer_place = $transferPlace;
    $this->transfer_reason = $transferReason;
    $this->unresistible_reason = $unresistibleReason;
    $this->other_description = $otherDescription;
    $this->date = date("Y-m-d");

    return ($this->db->insert('end_case', $this)) ? $this->db->insert_id() : false;
  }

  /*
   * update end_case by no
   * @Return: Boolean
   */

  function update_by_member($member, $trend, $workDescription, $isOriginCompany,
   $schoolDescription, $trainingDescription, $isCompleteCounsel, 
   $completeCounselReason, $isTransfer, $transferPlace, $transferReason, 
   $unresistibleReason, $otherDescription) {
    // youth basic information
    $this->trend = $trend;
    $this->work_description = $workDescription;
    $this->is_origin_company = $isOriginCompany;
    $this->school_description = $schoolDescription;
    $this->training_description = $trainingDescription;
    $this->is_complete_counsel = $isCompleteCounsel;
    $this->complete_counsel_reason = $completeCounselReason;
    $this->is_transfer = $isTransfer;
    $this->transfer_place = $transferPlace;
    $this->transfer_reason = $transferReason;
    $this->unresistible_reason = $unresistibleReason;
    $this->other_description = $otherDescription;

    $this->db->where('member', $member);

    return $this->db->update('end_case', $this);
  }

  /*
   * Get end_case by member
   * @Return: end_case object
   */
  function get_by_member($member) {
    $this->db->where('member', $member);
    $result = $this->db->get('end_case', 1)->row();
    return $result;
  }

  /*
   * Get end_case by no
   * @Return: end_case object
   */
  function get_by_no($no) {
    $this->db->where('no', $no);

    $result = $this->db->get('end_case', 1)->row();
    return $result;
  }

  /*
   * Get end_case by no
   * @Return: end_case object
   */
  function get_by_counselor($counselor) {
    $this->db->select('end_case.*');
    $this->db->from('end_case');
    $this->db->join('member', 'member.no = end_case.member');
    $this->db->where('member.counselor', $counselor);

    $result = $this->db->get()->result_array();
    return $result;
  }
}