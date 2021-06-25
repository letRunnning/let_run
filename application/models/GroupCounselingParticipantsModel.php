<?php
class GroupCounselingParticipantsModel extends CI_Model {
  
  /*
   * create group_counseling_participants
   */
  function create_one($groupCounseling, $counselor, $member) {

    $this->group_counseling = $groupCounseling;
    $this->counselor = $counselor;
    $this->member = $member;
  
    return $this->db->insert('group_counseling_participants', $this);
  }

  /*
   * update group_counseling_participants by member
   */
  function update_by_member($groupCounseling, $counselor, $member, 
    $isPunctual, $participationLevel, $descriptionOther) {

    $this->counselor = $counselor;
    $this->member = $member;
    $this->is_punctual = $isPunctual;
    $this->participation_level = $participationLevel;
    $this->description_other = $descriptionOther;

    $this->db->where('group_counseling', $groupCounseling);
    $this->db->where('member', $member);
    return $this->db->update('group_counseling_participants', $this);
  }

  /*
   * delete group_counseling_participants by groupCounseling
   */
  function delete_by_group_counseling($groupCounseling) {
    $this->db->where('group_counseling', $groupCounseling);
    return $this->db->delete('group_counseling_participants', $this);
  }

  /*
   * Get group_counseling_participants by groupCounseling
   * @Return: group_counseling_participants object
   */
  function get_by_group_counseling($groupCounseling) {
    $this->db->select('group_counseling_participants.*, member.system_no, youth.name');
    $this->db->join('member', 'group_counseling_participants.member = member.no');
    $this->db->join('youth', 'member.youth = youth.no');
    $this->db->where('group_counseling', $groupCounseling);
    $result = $this->db->get('group_counseling_participants')->result_array();
    return $result;
  }

  /*
   * Get group_counseling_participants hours by member
   * @Return: groupCounselingHour 
   */
  function get_group_counseling_hour_by_member($member) {
    $this->db->select('SUM(group_counseling.duration_hour) as groupCounselingHour');
    $this->db->join('group_counseling', 'group_counseling_participants.group_counseling = group_counseling.no');
    $this->db->where('group_counseling_participants.member', $member);
    $result = $this->db->get('group_counseling_participants', 1)->row();
    return $result;
  }

  function delete_participant_by_group_counseling_id($group_counseling_participants_id){

    $this->group_counseling = 0;
    $this->db->where('no', $group_counseling_participants_id);
    return $this->db->update('group_counseling_participants', $this);

  }

}