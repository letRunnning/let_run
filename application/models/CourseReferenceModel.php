<?php
class CourseReferenceModel extends CI_Model {

  /*
   * create course_reference
   */
  function create_one($name, $duration, $expert, $organization, $category, $content) {

    $this->name = $name;
    $this->duration = $duration;
    $this->expert = $expert;
    $this->organization = $organization;
    $this->category = $category;
    $this->content = $content;
  
    return ($this->db->insert('course_reference', $this)) ? $this->db->insert_id() : '';
  }

  /*
   * update course_reference by no
   */
  function update_by_no($name, $duration, $expert, $organization, $category, $content, $no) {

    $this->name = $name;
    $this->duration = $duration;
    $this->expert = $expert;
    $this->organization = $organization;
    $this->category = $category;
    $this->content = $content;
    
    $this->db->where('no', $no);
    return $this->db->update('course_reference', $this);
  }

  /*
   * Get course_reference by organization
   * @Return: course_reference object
   */
  function get_by_organization($organization) {
    $this->db->select('course_reference.*, expert_list.name as expert_name');
    $this->db->join('expert_list', 'course_reference.expert = expert_list.no');
    $this->db->where('course_reference.organization', $organization);
    $result = $this->db->get('course_reference')->result_array();
    return $result;
  }

  /*
   * Get course_reference by no
   * @Return: no object
   */
  function get_by_no($no) {   
    $this->db->where('no', $no);
    $result = $this->db->get('course_reference', 1)->row();
    return $result;
  }
}