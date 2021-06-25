<?php
class WorkAttendanceModel extends CI_Model {
  /*
   * create work_attendance
   */
  function create_one($workExperience, $member, $startTime, $endTime, $duration, $isInsurance, $insuranceStartDate, $insuranceEndDate, $note) {

    $this->work_experience = $workExperience;
    $this->member = $member;
    $this->start_time = $startTime;
    $this->end_time = $endTime;
    $this->duration = $duration;
    $this->is_insurance = $isInsurance;
    $this->insurance_start_date = $insuranceStartDate;
    $this->insurance_end_date = $insuranceEndDate;
    $this->note = $note;
  
    return ($this->db->insert('work_attendance', $this)) ? $this->db->insert_id() : '';
  }

  /*
   * update work_attendance by member
   */
  function update_by_no($workExperience, $member, $startTime, $endTime, $duration, $isInsurance, $insuranceStartDate, $insuranceEndDate, $note, $no) {

    $this->work_experience = $workExperience;
    $this->start_time = $startTime;
    $this->end_time = $endTime;
    $this->duration = $duration;
    $this->is_insurance = $isInsurance;
    $this->insurance_start_date = $insuranceStartDate;
    $this->insurance_end_date = $insuranceEndDate;
    $this->member = $member;
    $this->note = $note;
    
    $this->db->where('no', $no);
    return $this->db->update('work_attendance', $this);
  }

  /*
   * Get work_attendance by organization
   * @Return: work_attendance object
   */
  function get_by_organization($organization, $yearType) {
    $this->db->select('work_attendance.*, company.name, work_experience.no as workExperienceNo, youth.name as youthName');
    $this->db->join('work_experience', 'work_experience.no = work_attendance.work_experience');
    $this->db->join('company', 'company.no = work_experience.company');
    $this->db->join('member', 'work_attendance.member = member.no');
    $this->db->join('youth', 'member.youth = youth.no');
    $this->db->where('work_experience.organization', $organization);
    $this->db->where('work_experience.year', $yearType);
    $result = $this->db->get('work_attendance')->result_array();
    return $result;
  }

  function get_by_organization_member($organization, $yearType) {
    $this->db->select('work_attendance.*, company.name, work_experience.no as workExperienceNo, youth.name as youthName, member.no as memberNo, sum(work_attendance.duration) as sum');
    $this->db->join('work_experience', 'work_experience.no = work_attendance.work_experience');
    $this->db->join('company', 'company.no = work_experience.company');
    $this->db->join('member', 'work_attendance.member = member.no');
    $this->db->join('youth', 'member.youth = youth.no');
    $this->db->where('work_experience.organization', $organization);
    $this->db->where('work_experience.year', $yearType);
    $this->db->group_by('work_attendance.member');
    $result = $this->db->get('work_attendance')->result_array();
    return $result;
  }

  function get_work_by_organization($organization, $yearType, $monthType) {
    $this->db->select('work_attendance.*, company.name, work_experience.no as workExperienceNo, youth.name as youthName, member.no as memberNo, member.system_no, sum(work_attendance.duration) as sum');
    $this->db->join('work_experience', 'work_experience.no = work_attendance.work_experience');
    $this->db->join('company', 'company.no = work_experience.company');
    $this->db->join('member', 'work_attendance.member = member.no');
    $this->db->join('youth', 'member.youth = youth.no', 'left');
    $this->db->where('work_experience.organization', $organization);
    $this->db->where('work_experience.year', $yearType);
    $this->db->group_by('work_attendance.member');
    $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
    $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;
    $this->db->where('work_attendance.start_time <', ($addYear + 1911) . '-' . $addMonth .'-1');
    $result = $this->db->get('work_attendance')->result_array();
    return $result;
  }

  function get_work_by_member($member, $yearType, $monthType) {
    $this->db->select('work_attendance.*, company.name, work_experience.no as workExperienceNo, youth.name as youthName, member.no as memberNo, member.no as memberNo, sum(work_attendance.duration) as sum');
    $this->db->join('work_experience', 'work_experience.no = work_attendance.work_experience');
    $this->db->join('company', 'company.no = work_experience.company');
    $this->db->join('member', 'work_attendance.member = member.no');
    $this->db->join('youth', 'member.youth = youth.no', 'left');
    $this->db->where('work_attendance.member', $member);
    $this->db->where('work_experience.year', $yearType);
    $this->db->group_by('work_attendance.work_experience');
    $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
    $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;
    $this->db->where('work_attendance.start_time <', ($addYear + 1911) . '-' . $addMonth .'-1');
    $result = $this->db->get('work_attendance')->result_array();
    return $result;
  }

   /*
   * Get work_attendance by member
   * @Return: work_attendance object
   */
  function get_by_member($member, $yearType) {
    $this->db->select('work_attendance.*, company.name, work_experience.no as workExperienceNo, youth.name as youthName');
    $this->db->join('work_experience', 'work_experience.no = work_attendance.work_experience');
    $this->db->join('company', 'company.no = work_experience.company');
    $this->db->join('member', 'work_attendance.member = member.no');
    $this->db->join('youth', 'member.youth = youth.no');
    $this->db->where('work_attendance.member', $member);
    $this->db->where('work_experience.year', $yearType);
    $result = $this->db->get('work_attendance')->result_array();
    return $result;
  }

  /*
   * Get company by no
   * @Return: company object
   */
  function get_by_no($no) {
    $this->db->select('work_attendance.*, company.name');
    $this->db->join('work_experience', 'work_experience.no = work_attendance.work_experience');
    $this->db->join('company', 'company.no = work_experience.company');
    $this->db->where('work_attendance.no', $no);
    $result = $this->db->get('work_attendance', 1)->row();
    return $result;
  }

  /*
   * Get work_attendance by member
   * @Return: work_attendance object
   */
  function get_work_attendance_by_member($member) {
    $this->db->select('company.*, sum(work_attendance.duration) as duration');
    $this->db->join('work_experience', 'work_experience.no = work_attendance.work_experience');
    $this->db->join('company', 'company.no = work_experience.company');
    $this->db->where('work_attendance.member', $member);
    $this->db->group_by("company.no");
    $result = $this->db->get('work_attendance')->result_array();
    return $result;
  }

  /*
   * Get work_attendance_hour by member
   * @Return: work_attendance_hour object
   */
  function get_work_attendance_hour_by_member($member) {
    $this->db->select('IFNULL(SUM(duration), 0) as workAttendanceHour');
    $this->db->where('work_attendance.member', $member);
    $result = $this->db->get('work_attendance', 1)->row();
    return $result;
  }

}