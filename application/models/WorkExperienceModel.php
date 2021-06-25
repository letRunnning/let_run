<?php
class WorkExperienceModel extends CI_Model {
  /*
   * create work_experience
   */
  function create_one($company, $startTime, $endTime, $organization) {

    $this->company = $company;
    $this->start_time = $startTime;
    $this->end_time = $endTime;
    $this->organization = $organization;
    $this->year = date("Y")-1911;
  
    return ($this->db->insert('work_experience', $this)) ? $this->db->insert_id() : '';
  }

  /*
   * update company by no
   */
  function update_by_no($company, $startTime, $endTime, $organization, $no) {

    $this->company = $company;
    $this->start_time = $startTime;
    $this->end_time = $endTime;
    $this->organization = $organization;
      
    $this->db->where('no', $no);
    return $this->db->update('work_experience', $this);
  }

  /*
   * Get company by organization
   * @Return: company object
   */
  function get_by_organization($organization, $yearType) {
    $this->db->select('work_experience.*, company.name');
    $this->db->join('company', 'company.no = work_experience.company');
    $this->db->where('work_experience.organization', $organization);
    $this->db->where('work_experience.year', $yearType);
    $result = $this->db->get('work_experience')->result_array();
    return $result;
  }

  /*
   * Get company by no
   * @Return: company object
   */
  function get_by_no($no) {
    $this->db->where('no', $no);
    $result = $this->db->get('work_experience', 1)->row();
    return $result;
  }
}