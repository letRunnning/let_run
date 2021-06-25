<?php
class CounselingMemberCountReportModel extends CI_Model {
  /*
   * create course
   */
  function create_one($schoolYouth, $workYouth, $vocationalTrainingYouth, $otherYouth, $noPlanYouth, $forceMajeureYouth, 
    $schoolMember, $workMember, $vocationalTrainingMember, $otherMember, $noPlanMember, $forceMajeureMember,
    $counselorNote, $newCaseMember, $oldCaseMember, $twoYearSurvryCaseMember, $oneYearSurvryCaseMember, $nowYearSurvryCaseMember,
    $nextYearSurvryCaseMember, $highSchoolSurvryCaseMember, $monthCounselingHour, $monthCourseHour, $monthWorkingHour, $courseNote, 
    $forceMajeureNote, $workTrainningNote, $workNote, $fundingExecute, $otherNote, $insureNote, $month, $year, $project) {

    $this->school_youth = $schoolYouth;
    $this->work_youth = $workYouth;
    $this->vocational_training_youth = $vocationalTrainingYouth;
    $this->other_youth = $otherYouth;
    $this->no_plan_youth = $noPlanYouth;
    $this->force_majeure_youth = $forceMajeureYouth;

    $this->school_member = $schoolMember;
    $this->work_member = $workMember;
    $this->vocational_training_member = $vocationalTrainingMember;
    $this->other_member = $otherMember;
    $this->no_plan_member = $noPlanMember;
    $this->force_majeure_member = $forceMajeureMember;
    $this->counselor_note = $counselorNote;
    $this->new_case_member = $newCaseMember;
    $this->old_case_member = $oldCaseMember;
    $this->two_year_survry_case_member = $twoYearSurvryCaseMember;
    $this->one_year_survry_case_member = $oneYearSurvryCaseMember;
    $this->now_year_survry_case_member = $nowYearSurvryCaseMember;
    $this->next_year_survry_case_member = $nextYearSurvryCaseMember;
    $this->high_school_survry_case_member = $highSchoolSurvryCaseMember;
    $this->month_counseling_hour = $monthCounselingHour;
    $this->month_course_hour = $monthCourseHour;
    $this->month_working_hour = $monthWorkingHour;
    $this->course_note = $courseNote;
    $this->force_majeure_note = $forceMajeureNote;
    $this->work_trainning_note = $workTrainningNote;
    $this->work_note = $workNote;
    $this->funding_execute = $fundingExecute;
    $this->other_note = $otherNote;
    $this->insure_note = $insureNote;

    $this->month = $month;
    $this->year = $year;
    $this->project = $project;
    $this->is_review = 0;
    $this->date = date("Y-m-d");

    return ($this->db->insert('counseling_member_count_report', $this)) ? $this->db->insert_id() : '';
  }

  /*
   * update course by no
   */
  function update_one($schoolYouth, $workYouth, $vocationalTrainingYouth, $otherYouth, $noPlanYouth, $forceMajeureYouth,
    $schoolMember, $workMember, $vocationalTrainingMember, $otherMember, $noPlanMember, $forceMajeureMember,
    $counselorNote, $newCaseMember, $oldCaseMember, $twoYearSurvryCaseMember, $oneYearSurvryCaseMember, $nowYearSurvryCaseMember,
    $nextYearSurvryCaseMember, $highSchoolSurvryCaseMember, $monthCounselingHour, $monthCourseHour, $monthWorkingHour, $courseNote, 
    $forceMajeureNote, $workTrainningNote, $workNote, $fundingExecute, $otherNote, $insureNote, $month, $year, $project) {

      $this->school_youth = $schoolYouth;
      $this->work_youth = $workYouth;
      $this->vocational_training_youth = $vocationalTrainingYouth;
      $this->other_youth = $otherYouth;
      $this->no_plan_youth = $noPlanYouth;
      $this->force_majeure_youth = $forceMajeureYouth;
      
      $this->school_member = $schoolMember;
      $this->work_member = $workMember;
      $this->vocational_training_member = $vocationalTrainingMember;
      $this->other_member = $otherMember;
      $this->no_plan_member = $noPlanMember;
      $this->force_majeure_member = $forceMajeureMember;
      $this->counselor_note = $counselorNote;
      $this->new_case_member = $newCaseMember;
      $this->old_case_member = $oldCaseMember;
      $this->two_year_survry_case_member = $twoYearSurvryCaseMember;
      $this->one_year_survry_case_member = $oneYearSurvryCaseMember;
      $this->now_year_survry_case_member = $nowYearSurvryCaseMember;
      $this->next_year_survry_case_member = $nextYearSurvryCaseMember;
      $this->high_school_survry_case_member = $highSchoolSurvryCaseMember;
      $this->month_counseling_hour = $monthCounselingHour;
      $this->month_course_hour = $monthCourseHour;
      $this->month_working_hour = $monthWorkingHour;
      $this->course_note = $courseNote;
      $this->force_majeure_note = $forceMajeureNote;
      $this->work_trainning_note = $workTrainningNote;
      $this->work_note = $workNote;
      $this->funding_execute = $fundingExecute;
      $this->other_note = $otherNote;
      $this->insure_note = $insureNote;

      $this->db->where('month', $month);
      $this->db->where('year', $year);
      $this->db->where('project', $project);
    return $this->db->update('counseling_member_count_report', $this);
  }

  function update_file_by_no($no, $reportFile) {

      
      $this->report_file = $reportFile;

      $this->db->where('no', $no);
    
    return $this->db->update('counseling_member_count_report', $this);
  }



  /*
   * Get course by organization
   * @Return: course object
   */
  function get_no_by_county($county, $yearType, $month) {
    $this->db->select('counseling_member_count_report.no, counseling_member_count_report.is_review');
    $this->db->join('project', 'counseling_member_count_report.project = project.no');
    $this->db->where('project.county', $county);
    $this->db->where('counseling_member_count_report.year', $yearType);
    $this->db->where('counseling_member_count_report.month', $month);
    $result = $this->db->get('counseling_member_count_report', 1)->row();
    return $result;
  }

  /*
   * Get expert_list by no
   * @Return: expert_list object
   */
  function get_by_no($year, $month, $county) {
    $this->db->select('counseling_member_count_report.*, 
        project.name as project_name, project.execute_mode, project.execute_way,
        project.counselor_count, project.meeting_count, project.counseling_member,
        project.counseling_hour, project.course_hour, project.working_member,
        project.working_hour,
        files.name as report_file_name');
    $this->db->join('project', 'counseling_member_count_report.project = project.no');
    $this->db->join('files', 'counseling_member_count_report.report_file = files.no', 'left');
    $this->db->where('counseling_member_count_report.year', $year);
    $this->db->where('counseling_member_count_report.month', $month);
    $this->db->where('project.county', $county);

    $result = $this->db->get('counseling_member_count_report', 1)->row();
    return $result;
  }

  function get_by_all($year, $month, $county) {
    
    $this->db->select('county.name, counseling_member_count_report.*, project.name as project_name, project.execute_mode, project.execute_way,
    project.counselor_count, project.meeting_count, project.counseling_member,
    project.counseling_hour, project.course_hour, project.working_member,
    project.working_hour');    
    $this->db->join('project', 'county.no = project.county');
    $this->db->join('counseling_member_count_report', 'counseling_member_count_report.project = project.no');
    $this->db->where('counseling_member_count_report.year', $year);
    $this->db->where('counseling_member_count_report.month', $month);
    if ($county != 'all') {
        $this->db->where('county.no', $county);
    }
    $this->db->where('county.no!=', 23);

    $result = $this->db->get('county')->result_array();
    return $result;
  }
}