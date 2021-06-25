<?php
class CounselorServingMemberModel extends CI_Model {
   /*
   * create one counselor_serving_member
   * @Return: Boolean
   */
  function create_counselor_serving_member($counselor, $member) {
    $this->counselor = $counselor;
    $this->member = $member;
    return $this->db->insert('counselor_serving_member', $this);
  }

  function update_counselor_serving_member($counselor, $member) {
    $this->has_relation = 0;

    $this->db->where('member', $member);
    $this->db->where('counselor', $counselor);
    return $this->db->update('counselor_serving_member', $this);
  }
}