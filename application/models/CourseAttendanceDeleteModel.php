<?php
class CourseAttendanceDeleteModel extends CI_Model {
  /*
   * create course
   */
  function create_one($course, $member, $startTime, $endTime, $duration, $isInsurance, $insuranceStartDate, $insuranceEndDate) {
    $obj = (object)[
      'course' => $course,
      'member' => $member,
      'start_time' => $startTime,
      'end_time' => $endTime,
      'duration' => $duration,
      'is_insurance' => $isInsurance,
      'insurance_start_date' => $insuranceStartDate,
      'insurance_end_date' => $insuranceEndDate
    ];
  
    return ($this->db->insert('course_attendance', $obj)) ? $this->db->insert_id() : '';
  }

  /*
   * update course by no
   */
  function update_by_no($course, $member, $startTime, $endTime, $duration, $isInsurance, $insuranceStartDate, $insuranceEndDate, $no) {

    $this->course = $course;
    $this->member = $member;
    $this->start_time = $startTime;
    $this->end_time = $endTime;
    $this->duration = $duration;
    $this->is_insurance = $isInsurance;
    $this->insurance_start_date = $insuranceStartDate;
    $this->insurance_end_date = $insuranceEndDate;
    
    $this->db->where('no', $no);
    return $this->db->update('course_attendance', $this);
  }

  function delete_by_no($startTime) {
    $this->start_time = null;
    $this->db->where('start_time', $startTime);
    return $this->db->update('course_attendance', $this);
  }

  /*
   * Get course by organization
   * @Return: course object
   */
  function get_by_organization($organization, $yearType) {
    $this->db->select('course_attendance.*, course_reference.name');
    $this->db->join('course', 'course_attendance.course = course.no');
    $this->db->join('course_reference', 'course_reference.no = course.course_reference');
    $this->db->where('course.organization', $organization);
    $this->db->where('course.year', $yearType);
    $this->db->where('course_attendance.start_time !=', null);
    $this->db->group_by("course_attendance.start_time"); 
    $result = $this->db->get('course_attendance')->result_array();
    return $result;
  }

  /*
   * Get expert_list by no
   * @Return: expert_list object
   */
  function get_by_member($member, $yearType) {
    $this->db->select('course_attendance.*, course_reference.name');
    $this->db->join('course', 'course_attendance.course = course.no');
    $this->db->join('course_reference', 'course_reference.no = course.course_reference');
    $this->db->where('course_attendance.member', $member);
    $this->db->where('course.year', $yearType);
    $this->db->where('course_attendance.start_time !=', null);
    $this->db->group_by("course_attendance.start_time"); 
    $result = $this->db->get('course_attendance')->result_array();
    return $result;
  }

  /*
   * Get course_attendance by startTime
   * @Return: cocourse_attendanceurse object
   */
  function get_by_start_time($organization, $startTime) {
    $this->db->select('course_attendance.*, course_reference.name');
    $this->db->join('course', 'course_attendance.course = course.no');
    $this->db->join('course_reference', 'course_reference.no = course.course_reference');
    $this->db->where('course_attendance.start_time', $startTime);
    $this->db->where('course.organization', $organization);
    $this->db->where('course_attendance.start_time !=', null);
    $this->db->group_by("course_attendance.start_time"); 
    $result = $this->db->get('course_attendance', 1)->row();
    return $result;
  }

  /*
   * Get course_attendance by no
   * @Return: course_attendance object
   */
  function get_participants_by_start_time($organization, $startTime) {
    $this->db->select('course_attendance.*');
    $this->db->join('course', 'course_attendance.course = course.no');
    $this->db->where('course_attendance.start_time', $startTime);
    $this->db->where('course.organization', $organization);
    $this->db->where('course_attendance.start_time !=', null);
    $result = $this->db->get('course_attendance')->result_array();;
    return $result;
  }

  /*
   * Get course_attendance_hour by member
   * @Return: course_attendance_hour object
   */
  function get_course_attendance_hour_by_member($member) {
    $this->db->select('SUM(duration) as courseAttendanceHour');
    $this->db->where('member', $member);
    $this->db->where('course_attendance.start_time !=', null);
    $result = $this->db->get('course_attendance', 1)->row();
    return $result;
  }
}