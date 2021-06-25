<?php
class IndividualCounselingModel extends CI_Model {
   /*
   * create individual_counseling
   */
  function create_one($counselor, $member, $startTime, $endTime, $durationHour, $serviceType, $serviceWay, $referralResource,
                        $referralDescription, $serviceTarget, $serviceContent, $futurePlan) {
    $this->counselor = $counselor;
    $this->member = $member;
    $this->start_time = $startTime;
    $this->end_time = $endTime;
    $this->duration_hour = $durationHour;
    $this->service_type = $serviceType;
    $this->service_way = $serviceWay;
    $this->referral_resource = $referralResource;
    $this->referral_description = $referralDescription;
    $this->service_target = $serviceTarget;
    $this->service_content = $serviceContent;
    $this->future_plan = $futurePlan;
    return ($this->db->insert('individual_counseling', $this)) ? $this->db->insert_id() : false;
  }

  /*
   * update individual_counseling by no
   */
  function update_by_no($counselor, $member, $startTime, $endTime, $durationHour, $serviceType, $serviceWay, $referralResource,
                        $referralDescription, $serviceTarget, $serviceContent, $futurePlan, $no) {
    $this->counselor = $counselor;
    $this->member = $member;
    $this->start_time = $startTime;
    $this->end_time = $endTime;
    $this->duration_hour = $durationHour;
    $this->service_type = $serviceType;
    $this->service_way = $serviceWay;
    $this->referral_resource = $referralResource;
    $this->referral_description = $referralDescription;
    $this->service_target = $serviceTarget;
    $this->service_content = $serviceContent;
    $this->future_plan = $futurePlan;

    $this->db->where('no', $no);
    return $this->db->update('individual_counseling', $this);
  }
  
  /*
   * Get individual_counseling by member
   * @Return: individual_counseling object
   */
  function get_by_member($member) {
    $this->db->where('member', $member);
    $result = $this->db->get('individual_counseling')->result_array();
    return $result;
  }

  /*
   * Get individual_counseling by no
   * @Return: individual_counseling object
   */
  function get_by_no($no) {
    $this->db->where('no', $no);

    $result = $this->db->get('individual_counseling', 1)->row();
    return $result;
  }

  /*
   * Get individual_counseling_hour by member
   * @Return: individual_counseling_hour object
   */
  function get_individual_counseling_hour_by_member($member) {
    $this->db->select('SUM(duration_hour) as individualCounselingHour');
    $this->db->where('member', $member);
    $result = $this->db->get('individual_counseling', 1)->row();
    return $result;
  }

  /*
   * Get referral_source_hour by member
   * @Return: referral_source_hour object
   */
  function get_referral_source_hour_by_member($member, $referralResource) {
    $this->db->select('SUM(duration_hour) as referralResourceHour');
    $this->db->where('member', $member);
    $this->db->where('referral_resource', $referralResource);
    $result = $this->db->get('individual_counseling', 1)->row();
    return $result;
  }
}