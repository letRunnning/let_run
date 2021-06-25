<?php
class CounselorManpowerReportModel extends CI_Model
{
    /*
     * create course
     */
    public function create_one($projectCounselor, $reallyCounselor, $educationCounselor, $counselingCenterCounselor, $schoolCounselor, $outsourcingCounselor,
        $bachelorDegree, $masterDegree, $qualificationOne, $qualificationTwo, $qualificationThree, $qualificationFour,
        $qualificationFive, $qualificationSix, $note, $month, $year, $project) {

        $this->project_counselor = $projectCounselor;
        $this->really_counselor = $reallyCounselor;
        $this->education_counselor = $educationCounselor;
        $this->counseling_center_counselor = $counselingCenterCounselor;
        $this->school_counselor = $schoolCounselor;
        $this->outsourcing_counselor = $outsourcingCounselor;
        $this->bachelor_degree = $bachelorDegree;
        $this->master_degree = $masterDegree;
        $this->qualification_one = $qualificationOne;
        $this->qualification_two = $qualificationTwo;
        $this->qualification_three = $qualificationThree;
        $this->qualification_four = $qualificationFour;
        $this->qualification_five = $qualificationFive;
        $this->qualification_six = $qualificationSix;
        $this->note = $note;

        $this->month = $month;
        $this->year = $year;
        $this->project = $project;
        $this->is_review = 0;
        $this->date = date("Y-m-d");

        return ($this->db->insert('counselor_manpower_report', $this)) ? $this->db->insert_id() : '';
    }

    /*
     * update course by no
     */
    public function update_one($projectCounselor, $reallyCounselor, $educationCounselor, $counselingCenterCounselor, $schoolCounselor, $outsourcingCounselor,
        $bachelorDegree, $masterDegree, $qualificationOne, $qualificationTwo, $qualificationThree, $qualificationFour,
        $qualificationFive, $qualificationSix, $note, $month, $year, $project) {

        $this->project_counselor = $projectCounselor;
        $this->really_counselor = $reallyCounselor;
        $this->education_counselor = $educationCounselor;
        $this->counseling_center_counselor = $counselingCenterCounselor;
        $this->school_counselor = $schoolCounselor;
        $this->outsourcing_counselor = $outsourcingCounselor;
        $this->bachelor_degree = $bachelorDegree;
        $this->master_degree = $masterDegree;
        $this->qualification_one = $qualificationOne;
        $this->qualification_two = $qualificationTwo;
        $this->qualification_three = $qualificationThree;
        $this->qualification_four = $qualificationFour;
        $this->qualification_five = $qualificationFive;
        $this->qualification_six = $qualificationSix;
        $this->note = $note;

        $this->db->where('month', $month);
        $this->db->where('year', $year);
        $this->db->where('project', $project);
        return $this->db->update('counselor_manpower_report', $this);
    }

    /*
     * Get course by organization
     * @Return: course object
     */
    public function get_no_by_county($county, $yearType, $month)
    {
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
    public function get_by_no($year, $month, $county)
    {
        $this->db->select('counselor_manpower_report.*, files.name as report_file_name');
        $this->db->join('project', 'counselor_manpower_report.project = project.no');
        $this->db->join('files', 'counselor_manpower_report.report_file = files.no', 'left');
        $this->db->where('counselor_manpower_report.year', $year);
        $this->db->where('counselor_manpower_report.month', $month);
        $this->db->where('project.county', $county);

        $result = $this->db->get('counselor_manpower_report', 1)->row();
        return $result;
    }

    function update_file_by_no($no, $reportFile) {
    
      $this->report_file = $reportFile;
  
      $this->db->where('no', $no);
    
      return $this->db->update('counselor_manpower_report', $this);
    }

    public function get_by_all($year, $month, $county)
    {
        $this->db->select('county.name, counselor_manpower_report.*');
        $this->db->join('project', 'county.no = project.county');
        $this->db->join('counselor_manpower_report', 'counselor_manpower_report.project = project.no');
        $this->db->where('counselor_manpower_report.year', $year);
        $this->db->where('counselor_manpower_report.month', $month);
        if ($county != 'all') {
            $this->db->where('county.no', $county);
        }
        $this->db->where('county.no!=', 23);

        $result = $this->db->get('county')->result_array();
        return $result;
    }
}
