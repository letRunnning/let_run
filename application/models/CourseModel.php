<?php
class CourseModel extends CI_Model {
  /*
   * create course
   */
  function create_one($courseReference, $startTime, $endTime, $organization) {

    $this->course_reference = $courseReference;
    $this->start_time = $startTime;
    $this->end_time = $endTime;
    $this->organization = $organization;
    $this->year = date("Y")-1911;
  
    return ($this->db->insert('course', $this)) ? $this->db->insert_id() : '';
  }

  /*
   * update course by no
   */
  function update_by_no($courseReference, $startTime, $endTime, $organization, $no) {

    $this->course_reference = $courseReference;
    $this->start_time = $startTime;
    $this->end_time = $endTime;
    $this->organization = $organization;
    
    $this->db->where('no', $no);
    return $this->db->update('course', $this);
  }

  /*
   * Get course by organization
   * @Return: course object
   */
  function get_by_organization($organization, $yearType) {
    $this->db->select('course.*, course_reference.name as course_name, course_reference.category, expert_list.name as expert_name');
    $this->db->join('course_reference', 'course_reference.no = course.course_reference');
    $this->db->join('expert_list', 'course_reference.expert = expert_list.no');
    $this->db->where('course.organization', $organization);
    $this->db->where('course.year', $yearType);
    $result = $this->db->get('course')->result_array();
    return $result;
  }

  function get_course_by_organization($organization, $yearType, $monthType) {
    $this->db->select('course_attendance.*, course_reference.name as course_name, course_reference.category, expert_list.name as expert_name');
    $this->db->join('course', 'course.no = course_attendance.course');
    $this->db->join('course_reference', 'course_reference.no = course.course_reference');
    $this->db->join('expert_list', 'course_reference.expert = expert_list.no');
    $this->db->where('course.organization', $organization);
    $this->db->where('course.year', $yearType);
    $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
    $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;
    $this->db->where('course_attendance.start_time <', ($addYear + 1911) . '-' . $addMonth .'-1');
    $this->db->group_by("course_attendance.start_time");
    $result = $this->db->get('course_attendance')->result_array();
    return $result;
  }

  /*
   * Get expert_list by no
   * @Return: expert_list object
   */
  function get_by_no($no) {
    // $this->db->select('course_reference.*, expert_list.name as expert_name');
    // $this->db->join('expert_list', 'course_reference.expert = expert_list.no');
    $this->db->where('no', $no);
    $result = $this->db->get('course', 1)->row();
    return $result;
  }
}