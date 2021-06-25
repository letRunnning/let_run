<?php
class CounselingMeetingCountReportModel extends CI_Model
{
    // 實際辦理跨局處會議時間
    public function get_note_datail($year, $monthType, $organization)
    {
        $addMonth = ($monthType + 1 > 12) ? 1 : $monthType + 1;
        $addYear = ($monthType + 1 > 12) ? $year + 1 : $year;

        $date = ($addYear + 1911) . '-' . $addMonth . '-1';
        $pastDate = ($year + 1911) . '-1-1';

        if ($organization != 'all') {
            $query = $this->db->query("SELECT *
    FROM `meeting`
    WHERE `organization` = $organization
    AND `start_time` < '$date'
    AND `start_time` > '$pastDate'");
        } else {
            $query = $this->db->query("SELECT *
    FROM `meeting`  WHERE `start_time` < '$date'
    AND `start_time` > '$pastDate'");
        }
        if ($query->num_rows()) {
            return $query->result_array();
        }
        // else{
        //   return "false";
        // }
    }

    public function get_meeting_all($year, $monthType, $county)
    {
        $addMonth = ($monthType + 1 > 12) ? 1 : $monthType + 1;
        $addYear = ($monthType + 1 > 12) ? $year + 1 : $year;

        $date = ($addYear + 1911) . '-' . $addMonth . '-1';
        $this->db->select('county.name, counseling_identity_count_report.*');
        $this->db->join('project', 'county.no = project.county');
        $this->db->join('counseling_identity_count_report', 'counseling_identity_count_report.project = project.no');
        $this->db->where('counseling_identity_count_report.year', $year);
        $this->db->where('counseling_identity_count_report.month', $month);
        if ($county != 'all') {
            $this->db->where('county.no', $county);
        }

        $result = $this->db->get('county')->result_array();
        return $result;
    }

    // 預計辦理活動或講座場次
    public function get_planning_meeting_count($county)
    {
        $query = $this->db->query("select project.meeting_count,project.no
      FROM `project`
      WHERE `project`.`county`=$county");
        if ($query->num_rows()) {
            return $query->row();
        }
    }

    // 實際辦理跨局處會議時間
    public function actual_meeting_date($year, $month, $organization, $meetingTypeNo)
    {
        if ($organization != "all") {
            $query = $this->db->query("SELECT `start_time`
    FROM `meeting`
    WHERE `meeting_type`=$meetingTypeNo
    AND `organization`=$organization
    AND `start_time` <= '$year-$month-31'
    GROUP BY start_time");
        } else {
            $query = $this->db->query("SELECT *
    FROM `meeting`
    WHERE `meeting_type`=$meetingTypeNo
    AND `start_time` <= '$year-$month-31'
    GROUP BY start_time");
        }

        if ($query->num_rows()) {
            return $query->result_array();
        }
    }

    // 實際辦理活動或講座場次
    public function actual_holding_meeting_count($year, $month, $organization, $meetingTypeNo)
    {
        if ($organization != "all") {
            $query = $this->db->query("SELECT COUNT(*) as actual_holding_meeting_count FROM `meeting`
    WHERE `meeting_type`=$meetingTypeNo
    AND `organization`=$organization
    AND `start_time` <= '$year-$month-31'");
        } else {
            $query = $this->db->query("SELECT COUNT(*) as actual_holding_meeting_count FROM `meeting`
    WHERE `meeting_type`=$meetingTypeNo
    AND `start_time` <= '$year-$month-31'");
        }
        if ($query->num_rows()) {
            return $query->row();
        }
    }

    // 取得已輸入資料
    public function get_inserted_meeting_count_data($year, $month, $county)
    {
        $query = $this->db->query("SELECT meeting_count_report.*, files.name as report_file_name FROM `meeting_count_report` left join `files` on `meeting_count_report`.report_file = `files`.no WHERE `project`=$county AND `month`=$month AND `year`=$year");
        if ($query->num_rows()) {
            return $query->row();
        }
    }

    function update_file_by_no($no, $reportFile) {
    
      $this->report_file = $reportFile;
  
      $this->db->where('no', $no);
    
      return $this->db->update('meeting_count_report', $this);
    }
    /*
     * Get meeting_count_report course by organization
     * @Return: course object
     */
    public function get_meeting_no_by_county($county, $yearType, $month)
    {
        $query = $this->db->query("SELECT meeting_count_report.no, meeting_count_report.is_review
    from meeting_count_report,project
    where project.county= $county
    AND meeting_count_report.year=$yearType
    AND meeting_count_report.month=$month
    AND meeting_count_report.project = project.no");
        return $query->row();
    }
    public function create_one(
        $time_note,
        $planning_holding_meeting_count,
        $actual_holding_meeting_count,
        $actual_involved_people,
        $planning_involved_people,
        $month,
        $year,
        $is_review,
        $date,
        $project,
        $meeting_count_note
    ) {
        $this->planning_holding_meeting_count = $planning_holding_meeting_count;
        $this->actual_holding_meeting_count = $actual_holding_meeting_count;
        $this->actual_involved_people = $actual_involved_people;
        $this->planning_involved_people = $planning_involved_people;
        $this->month = $month;
        $this->year = $year;
        $this->is_review = $is_review;
        $this->date = $date;
        $this->project = $project;
        $this->meeting_count_note = $meeting_count_note;
        $this->time_note = $time_note;
        // $result = $this->db->insert('meeting_count_report', $this);
        // if ($result) {
        //   return true;
        // } else {
        //   $error = $this->db->error();
        //   return $error;
        // }
        return ($this->db->insert('meeting_count_report', $this)) ? $this->db->insert_id() : '';
    }
    public function edit(
        $time_note,
        $planning_holding_meeting_count,
        $actual_holding_meeting_count,
        $actual_involved_people,
        $planning_involved_people,
        $month,
        $year,
        $is_review,
        $date,
        $project,
        $meeting_count_note,
        $get_update_data_id
    ) {
        $this->planning_holding_meeting_count = $planning_holding_meeting_count;
        $this->actual_involved_people = $actual_involved_people;
        $this->actual_holding_meeting_count = $actual_holding_meeting_count;
        $this->planning_involved_people = $planning_involved_people;
        $this->month = $month;
        $this->year = $year;
        $this->is_review = $is_review;
        $this->date = $date;
        $this->project = $project;
        $this->time_note = $time_note;
        $this->meeting_count_note = $meeting_count_note;
        $this->db->where('no', $get_update_data_id);
        $result = $this->db->update('meeting_count_report', $this);
        if ($result) {
            return true;
        } else {
            $error = $this->db->error();
            return $error;
        }
    }
    public function get_county_user_organization_num($county)
    {
        $query = $this->db->query("SELECT county_delegate_organization.`organization` FROM `county_delegate_organization`,users
    WHERE `users`.`county`=$county
    AND county_delegate_organization.county = users.county");
        if ($query->num_rows()) {
            return $query->row();
        }
    }
    public function get_organization_num()
    {
        $query = $this->db->query("SELECT `county`,`organization` FROM `county_delegate_organization`");
        if ($query->num_rows()) {
            return $query->result_array();
        }
    }
    public function get_meeting_count_data_num($month, $year, $project)
    {
        $query = $this->db->query("SELECT `no` FROM `meeting_count_report`
    WHERE `month`=$month
    AND `year`=$year
    AND `project` = $project");
        if ($query->num_rows()) {
            return $query->row();
        }
    }
    public function get_by_all($year, $month, $county)
    {
        $this->db->select('county.name, meeting_count_report.*');
        $this->db->join('project', 'county.no = project.county');
        $this->db->join('meeting_count_report', 'meeting_count_report.project = project.no');
        $this->db->where('meeting_count_report.year', $year);
        $this->db->where('meeting_count_report.month', $month);
        if ($county != 'all') {
            $this->db->where('county.no', $county);
        }
        $this->db->where('county.no!=', 23);

        $result = $this->db->get('county')->result_array();
        return $result;
    }
}
