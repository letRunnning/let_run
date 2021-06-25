<?php
class OneYearsTrendSurveyCountReportModel extends CI_Model
{
  /*
   * create course
   */
  function create_one(
    $alreadyAttendingSchool,
    $alreadyWorking,
    $prepareToSchool,
    $prepareToWork,
    $noPlan,
    $lostContact,
    $transferLabor,
    $transferOther,
    $inCase,
    $other,
    $military,
    $pregnancy,
    $death,
    $immigration,
    $noAssistance,
    $health,
    $specialEducationStudent,
    $training,
    $familyLabor,
    $note,
    $month,
    $year,
    $project
  ) {

    $this->already_attending_school = $alreadyAttendingSchool;
    $this->already_working = $alreadyWorking;
    $this->prepare_to_school = $prepareToSchool;
    $this->prepare_to_work = $prepareToWork;
    $this->no_plan = $noPlan;
    $this->lost_contact = $lostContact;
    $this->transfer_labor = $transferLabor;
    $this->transfer_other = $transferOther;
    $this->in_case = $inCase;
    $this->other = $other;
    $this->military = $military;
    $this->pregnancy = $pregnancy;
    $this->death = $death;
    $this->immigration = $immigration;
    $this->no_assistance = $noAssistance;
    $this->health = $health;
    $this->note = $note;
    $this->special_education_student = $specialEducationStudent;
    $this->training = $training;
    $this->family_labor = $familyLabor;

    $this->month = $month;
    $this->year = $year;
    $this->project = $project;
    $this->is_review = 0;
    $this->date = date("Y-m-d");

    return ($this->db->insert('one_years_trend_survey_count_report', $this)) ? $this->db->insert_id() : '';
  }

  function create_one_new($one, $two, $three, $four, $five, $six,
  $seven, $eight, $nine, $ten, $eleven, $twelve,
  $thirteen, $fourteen, $fifteen, $sixteen, $seventeen, $eighteen, $nineteen, $note, $month, $year, $project) {

  $this->one = $one;
  $this->two = $two;
  $this->three = $three;
  $this->four = $four;
  $this->five = $five;
  $this->six = $six;
  $this->seven = $seven;
  $this->eight = $eight;
  $this->nine = $nine;
  $this->ten = $ten;
  $this->eleven = $eleven;
  $this->twelve = $twelve;
  $this->thirteen = $thirteen;
  $this->fourteen = $fourteen;
  $this->fifteen = $fifteen;
  $this->sixteen = $sixteen;
  $this->seventeen = $seventeen;
  $this->eighteen = $eighteen;
  $this->nineteen = $nineteen;

  $this->note = $note;
  $this->month = $month;
  $this->year = $year;
  $this->project = $project;
  $this->is_review = 0;
  $this->date = date("Y-m-d");

  return ($this->db->insert('new_one_years_trend_survey_count_report', $this)) ? $this->db->insert_id() : '';
}

  /*
   * update course by no
   */
  function update_one(
    $alreadyAttendingSchool,
    $alreadyWorking,
    $prepareToSchool,
    $prepareToWork,
    $noPlan,
    $lostContact,
    $transferLabor,
    $transferOther,
    $inCase,
    $other,
    $military,
    $pregnancy,
    $death,
    $immigration,
    $noAssistance,
    $health,
    $specialEducationStudent,
    $training,
    $familyLabor,
    $note,
    $month,
    $year,
    $project
  ) {

    $this->already_attending_school = $alreadyAttendingSchool;
    $this->already_working = $alreadyWorking;
    $this->prepare_to_school = $prepareToSchool;
    $this->prepare_to_work = $prepareToWork;
    $this->no_plan = $noPlan;
    $this->lost_contact = $lostContact;
    $this->transfer_labor = $transferLabor;
    $this->transfer_other = $transferOther;
    $this->in_case = $inCase;
    $this->other = $other;
    $this->military = $military;
    $this->pregnancy = $pregnancy;
    $this->death = $death;
    $this->immigration = $immigration;
    $this->no_assistance = $noAssistance;
    $this->health = $health;
    $this->note = $note;
    $this->special_education_student = $specialEducationStudent;
    $this->training = $training;
    $this->family_labor = $familyLabor;

    $this->db->where('month', $month);
    $this->db->where('year', $year);
    $this->db->where('project', $project);
    return $this->db->update('one_years_trend_survey_count_report', $this);
  }

  function udpdate_one_new($one, $two, $three, $four, $five, $six,
    $seven, $eight, $nine, $ten, $eleven, $twelve,
    $thirteen, $fourteen, $fifteen, $sixteen, $seventeen, $eighteen, $nineteen, $note, $month, $year, $project) {

    $this->one = $one;
    $this->two = $two;
    $this->three = $three;
    $this->four = $four;
    $this->five = $five;
    $this->six = $six;
    $this->seven = $seven;
    $this->eight = $eight;
    $this->nine = $nine;
    $this->ten = $ten;
    $this->eleven = $eleven;
    $this->twelve = $twelve;
    $this->thirteen = $thirteen;
    $this->fourteen = $fourteen;
    $this->fifteen = $fifteen;
    $this->sixteen = $sixteen;
    $this->seventeen = $seventeen;
    $this->eighteen = $eighteen;
    $this->nineteen = $nineteen;

    $this->note = $note;
    $this->db->where('month', $month);
    $this->db->where('year', $year);
    $this->db->where('project', $project);

    return $this->db->update('new_one_years_trend_survey_count_report', $this);
  }

  /*
   * Get course by organization
   * @Return: course object
   */
  function get_no_by_county($county, $yearType, $month)
  {
    $this->db->select('counseling_member_count_report.no, counseling_member_count_report.is_review');
    $this->db->join('project', 'counseling_member_count_report.project = project.no');
    $this->db->where('project.county', $county);
    $this->db->where('counseling_member_count_report.year', $yearType);
    $this->db->where('counseling_member_count_report.month', $month);
    $result = $this->db->get('counseling_member_count_report', 1)->row();
    return $result;
  }

  function update_file_by_no($no, $reportFile) {
    
    $this->report_file = $reportFile;

    $this->db->where('no', $no);
  
    return $this->db->update('new_one_years_trend_survey_count_report', $this);
  }

  /*
   * Get expert_list by no
   * @Return: expert_list object
   */
  function get_by_no($year, $month, $county)
  {
    $this->db->select('new_one_years_trend_survey_count_report.*, files.name as report_file_name, (select Count(*) from youth where youth.source_school_year = ' . ($year-3) .' and youth.county = ' . $county . ') as youthCount');    
    $this->db->join('project', 'new_one_years_trend_survey_count_report.project = project.no');
    $this->db->join('files', 'new_one_years_trend_survey_count_report.report_file = files.no', 'left');
    $this->db->where('new_one_years_trend_survey_count_report.year', $year);
    $this->db->where('new_one_years_trend_survey_count_report.month', $month);
    $this->db->where('project.county', $county);

    $result = $this->db->get('new_one_years_trend_survey_count_report', 1)->row();
    return $result;
  }

  function get_by_all($year, $month, $county)
  {

    $this->db->select('county.name, new_one_years_trend_survey_count_report.* ,(select Count(*) from youth where youth.source_school_year = ' . ($year-3) .' and youth.county = county.no) as youthCount');
    $this->db->join('project', 'county.no = project.county');
    $this->db->join('new_one_years_trend_survey_count_report', 'new_one_years_trend_survey_count_report.project = project.no');
    $this->db->where('new_one_years_trend_survey_count_report.year', $year);
    $this->db->where('new_one_years_trend_survey_count_report.month', $month);

    if ($county != 'all') {
      $this->db->where('county.no', $county);
    }
    $this->db->where('county.no!=', 23);

    $result = $this->db->get('county')->result_array();
    return $result;
  }
}
