<?php
class CompanyModel extends CI_Model {

  /*
   * get columns from schema
   */
  function get_edited_columns_metadata() {
    $sql = "select column_name, column_comment 
      from information_schema.columns 
      where table_name = 'company' and table_schema = 'yda' 
      and column_name not in ('no', 'organization', 'start_time', 'end_time'); ";
    return $this->db->query($sql)->result();
  }

  /*
   * create company
   */
  function create_one($data) {
    return ($this->db->insert('company', $data)) ? $this->db->insert_id() : false;
  }

  // /*
  //  * create company
  //  */
  // function create_one($name, $duration, $startTime, $endTime, $bossName, $phone, 
  //   $category, $content, $requirement, $address, $organization, $isOpen) {

  //   $this->name = $name;
  //   $this->duration = $duration;
  //   $this->start_time = $startTime;
  //   $this->end_time = $endTime;
  //   $this->boss_name = $bossName;
  //   $this->phone = $phone;
  //   $this->category = $category;
  //   $this->content = $content;
  //   $this->requirement = $requirement;
  //   $this->address = $address;
  //   $this->organization = $organization;
  //   $this->is_open = $isOpen;
  
  //   return ($this->db->insert('company', $this)) ? $this->db->insert_id() : '';
  // }

   /*
   * update course by no
   */
  function update_by_no($no, $data) {
    $this->db->where('no', $no);
    $this->db->update('company', $data);
    return true;
  }

  // /*
  //  * update company by no
  //  */
  // function update_by_no($name, $duration, $startTime, $endTime, $bossName, $phone, 
  //   $category, $content, $requirement, $address, $organization, $isOpen, $no) {

  //   $this->name = $name;
  //   $this->duration = $duration;
  //   $this->start_time = $startTime;
  //   $this->end_time = $endTime;
  //   $this->boss_name = $bossName;
  //   $this->phone = $phone;
  //   $this->category = $category;
  //   $this->content = $content;
  //   $this->requirement = $requirement;
  //   $this->address = $address;
  //   $this->organization = $organization;
  //   $this->is_open = $isOpen;
      
  //   $this->db->where('no', $no);
  //   return $this->db->update('company', $this);
  // }

  /*
   * Get company by organization
   * @Return: company object
   */
  function get_by_organization($organization) {
    $this->db->where('organization', $organization);
    $result = $this->db->get('company')->result_array();
    return $result;
  }

  /*
   * Get company by no
   * @Return: company object
   */
  function get_by_no($no) {
    $this->db->where('no', $no);
    $result = $this->db->get('company', 1)->row();
    return $result;
  }
 
  /*
   * Get company
   * @Return: company object
   */
  function get_all() {
    $result = $this->db->get('company')->result_array();
    return $result;
  }
}