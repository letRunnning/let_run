<?php
class ExpertListModel extends CI_Model {

  /*
   * create expert_list
   */
  function create_one($name, $gender, $phone, $email, $education, $profession, $resideCounty, $organization, $isOpen) {

    $this->name = $name;
    $this->gender = $gender;
    $this->phone = $phone;
    $this->email = $email;
    $this->education = $education;
    $this->profession = $profession;
    $this->reside_county = $resideCounty;
    $this->organization = $organization;
    $this->is_open = $isOpen;
  
    return ($this->db->insert('expert_list', $this)) ? $this->db->insert_id() : '';
  }

  /* 
   * update expert_list by no
   */
  function update_by_no($name, $gender, $phone, $email, $education, $profession, $resideCounty, $organization, $isOpen, $no) {

    $this->name = $name;
    $this->gender = $gender;
    $this->phone = $phone;
    $this->email = $email;
    $this->education = $education;
    $this->profession = $profession;
    $this->reside_county = $resideCounty;
    $this->organization = $organization;
    $this->is_open = $isOpen;
    
    $this->db->where('no', $no);
    return $this->db->update('expert_list', $this);
  }

  /*
   * Get expert_list by organization
   * @Return: expert_list object
   */
  function get_by_organization($organization) {
    $this->db->where('organization', $organization);
    $result = $this->db->get('expert_list')->result_array();
    return $result;
  }

   /*
   * Get expert_list by no
   * @Return: expert_list object
   */
  function get_by_no($no) {
    $this->db->where('no', $no);
    $result = $this->db->get('expert_list', 1)->row();
    return $result;
  }
}