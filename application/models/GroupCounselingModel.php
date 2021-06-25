<?php
class GroupCounselingModel extends CI_Model {
   /*
   * create group_counseling
   */
  function create_one($title) {
    $this->title = $title;
    $this->year = date("Y")-1911;

    return ($this->db->insert('group_counseling', $this)) ? $this->db->insert_id() : '';
  }

  /*
   * create group_counseling_participants
   */
  function create_one_participants($groupCounseling, $counselor, $member) {

    $this->group_counseling = $groupCounseling;
    $this->counselor = $counselor;
    $this->member = $member;
  
    return $this->db->insert('group_counseling_participants', $this);
  }

  /*
   * update group_counseling by no
   */
  function update_by_no($title, $startTime, $endTime, $durationHour, $serviceTarget, 
  $serviceTargetOther, $importantEvent, $evaluation, $review, $no) {
    
    $this->title = $title;
    $this->start_time = $startTime;
    $this->end_time = $endTime;
    $this->duration_hour = $durationHour;
    $this->service_target = $serviceTarget;
    $this->service_target_other = $serviceTargetOther;
    $this->important_event = $importantEvent;
    $this->evaluation = $evaluation;
    $this->review = $review;

    $this->db->where('no', $no);
    return $this->db->update('group_counseling', $this);
  }

  /*
   * update group_counseling_participants
   */
  function update_participants_by_member($groupCcounseling, $counselor, $member, 
    $isPunctual, $participationLevel, $descriptionOther) {

    $this->counselor = $counselor;
    $this->member = $member;
    $this->is_punctual = $isPunctual;
    $this->participation_level = $participationLevel;
    $this->description_other = $descriptionOther;

    $this->db->where('group_counseling', $groupCcounseling);
    $this->db->where('member', $member);
    return $this->db->update('group_counseling_participants', $this);
  }

  /*
   * Get group_counseling by member
   * @Return: group_counseling object
   */
  function get_by_member($member, $yearType) {
    $this->db->select('group_counseling.*');
    $this->db->join('group_counseling', 'group_counseling_participants.group_counseling = group_counseling.no');
    $this->db->where('group_counseling.year', $yearType);
    $this->db->where('member', $member);
    $result = $this->db->get('group_counseling_participants')->result_array();
    return $result;
  }

  /*
   * Get group_counseling by organization
   * @Return: group_counseling object
   */
  function get_by_organization($organization, $yearType) {
    $this->db->select('group_counseling.*');
    $this->db->join('group_counseling_participants', 'group_counseling_participants.group_counseling = group_counseling.no');
    $this->db->join('member', 'group_counseling_participants.member = member.no');
    $this->db->where('member.organization', $organization);
    $this->db->where('group_counseling.year', $yearType);
    $this->db->group_by("group_counseling_participants.group_counseling"); 
    $result = $this->db->get('group_counseling')->result_array();
    return $result;
  }

  /*
   * Get group_counseling by no
   * @Return: group_counseling object
   */
  function get_by_no($no) {
    $this->db->where('no', $no);
    $result = $this->db->get('group_counseling', 1)->row();
    return $result;
  }

  /*
   * Get group_counseling_participants by no
   * @Return: group_counseling_participants object
   */
  function get_participants_by_group_counseling($no) {
    $this->db->where('group_counseling', $no);
    $result = $this->db->get('group_counseling_participants')->result_array();;
    return $result;
  }
}