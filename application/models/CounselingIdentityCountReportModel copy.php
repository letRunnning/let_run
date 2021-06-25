<?php
class CounselingIdentityCountReportModel extends CI_Model
{
  function get_education_type()
  {
    $sql = "select menu.content
    from menu,case_assessment_temp
    where menu.column_name='education'
    AND case_assessment_temp.education=menu.no
    GROUP BY menu.content";
    return $this->db->query($sql)->result_array();
  }
  // 國中未畢業中輟A
  function get_junior_under_graduate_count($gender, $year, $monthType,$county,$educationTypeNo,$genderNo)
  {
    $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
    $addYear =  ($monthType + 1 > 12) ? $year + 1 : $year ;

    $date = ($addYear + 1911) . '-' . $addMonth .'-1';
    $this->db->where('member.create_date <', ($addYear + 1911) . '-' . $addMonth .'-1');
    if ($gender == "boy") {
      $query = $this->db->query("select COUNT(case_assessment_temp.no) as count_num
    FROM `case_assessment_temp`,`member`,`youth`
    WHERE `education` = $educationTypeNo
    AND youth.gender=$genderNo
    AND case_assessment_temp.member=member.no
    AND member.year=$year
    AND member.create_date <'$date'
    AND member.youth=youth.no
    AND member.county = $county");
    } else {
      $query = $this->db->query("select COUNT(case_assessment_temp.no) as count_num
    FROM `case_assessment_temp`,`member`,`youth` 
    WHERE `education` = $educationTypeNo
    AND youth.gender=$genderNo
    AND case_assessment_temp.member=member.no
    AND member.year=$year
    AND member.youth=youth.no
    AND member.create_date <'$date'
    AND member.county = $county");
    }

    if ($query->num_rows()) {
      return $query->result_array();
    }
  }
  // 中輟滿16歲未升學未就業B
  function get_sixteen_years_old_not_employed_not_studying($gender, $year,$monthType,$county,$educationTypeNo,$genderNo)
  {
    $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
    $addYear =  ($monthType + 1 > 12) ? $year + 1 : $year ;

    $date = ($addYear + 1911) . '-' . $addMonth .'-1';
    if ($gender == "boy") {
      $query = $this->db->query("select COUNT(case_assessment_temp.no) as count_num
      FROM `case_assessment_temp`,`member`,`youth`
      WHERE `education` = $educationTypeNo
      AND youth.gender=$genderNo
      AND case_assessment_temp.member=member.no
      AND member.year=$year
      AND member.youth=youth.no
      AND member.create_date <'$date'
      AND member.county = $county");
    } else {
      $query = $this->db->query("select COUNT(case_assessment_temp.no) as count_num
      FROM `case_assessment_temp`,`member`,`youth`
      WHERE `education` = $educationTypeNo
      AND youth.gender=$genderNo
      AND case_assessment_temp.member=member.no
      AND member.year=$year
      AND member.youth=youth.no
      AND member.create_date <'$date'
      AND member.county = $county");
    }
    if ($query->num_rows()) {
      return $query->result_array();
    }
  }
  // 國中畢(結)業未就學未就業C 應屆
  function junior_graduated_this_year_unemployed_not_studying($gender, $year,$monthType,$county,$educationTypeNo,$genderNo)
  {
    $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
    $addYear =  ($monthType + 1 > 12) ? $year + 1 : $year ;

    $date = ($addYear + 1911) . '-' . $addMonth .'-1';
    if ($gender == "boy") {
      $query = $this->db->query("select COUNT(case_assessment_temp.no) as count_num
      FROM `case_assessment_temp`,`member`,`youth`
      WHERE `education` = $educationTypeNo
      AND youth.gender=$genderNo
      AND case_assessment_temp.member=member.no
      AND member.year=$year
      AND member.youth=youth.no
      AND member.create_date <'$date'
      AND member.county = $county");
    } else {
      $query = $this->db->query("select COUNT(case_assessment_temp.no) as count_num
      FROM `case_assessment_temp`,`member`,`youth`
      WHERE `education` = $educationTypeNo
      AND youth.gender=$genderNo
      AND case_assessment_temp.member=member.no
      AND member.year=$year
      AND member.youth=youth.no
      AND member.create_date <'$date'
      AND member.county = $county");
    }
    if ($query->num_rows()) { //避免count=0 被判定為null
      return $query->result_array();
    }
  }
  // 國中畢(結)業未就學未就業C 非應屆
  function junior_graduated_not_this_year_unemployed_not_studying($gender, $year,$monthType,$county,$educationTypeNo,$genderNo)
  {
    $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
    $addYear =  ($monthType + 1 > 12) ? $year + 1 : $year ;

    $date = ($addYear + 1911) . '-' . $addMonth .'-1';
    if ($gender == "boy") {
      $query = $this->db->query("select COUNT(case_assessment_temp.no) as count_num
      FROM `case_assessment_temp`,`member`,`youth`
      WHERE `education` = $educationTypeNo
      AND youth.gender=$genderNo
      AND case_assessment_temp.member=member.no
      AND member.year=$year
      AND member.create_date <'$date'
      AND member.youth=youth.no
      AND member.county = $county");
    } else {
      $query = $this->db->query("select COUNT(case_assessment_temp.no) as count_num
      FROM `case_assessment_temp`,`member`,`youth`
      WHERE `education` = $educationTypeNo
      AND youth.gender=$genderNo
      AND case_assessment_temp.member=member.no
      AND member.year=$year
      AND member.youth=youth.no
      AND member.create_date <'$date'
      AND member.county = $county");
    }
    if ($query->num_rows()) { //避免count=0 被判定為null
      return $query->result_array();
    }
  }
  // 高中中離D
  function drop_out_from_senior($gender, $year,$monthType,$county,$educationTypeOne,$educationTypeThree,$genderNo)
  {
    $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
    $addYear =  ($monthType + 1 > 12) ? $year + 1 : $year ;

    $date = ($addYear + 1911) . '-' . $addMonth .'-1';
    if ($gender == "boy") {
      $query = $this->db->query("select COUNT(case_assessment_temp.no) as count_num
      FROM `case_assessment_temp`,`member`,`youth`
      WHERE `education` BETWEEN $educationTypeOne AND $educationTypeThree
      AND youth.gender=$genderNo
      AND case_assessment_temp.member=member.no
      AND member.year=$year
      AND member.youth=youth.no
      AND member.create_date <'$date'
      AND member.county = $county");
    } else {
      $query = $this->db->query("select COUNT(case_assessment_temp.no) as count_num
      FROM `case_assessment_temp`,`member`,`youth`
      WHERE `education` BETWEEN $educationTypeOne AND $educationTypeThree
      AND youth.gender=$genderNo
      AND case_assessment_temp.member=member.no
      AND member.year=$year
      AND member.youth=youth.no
      AND member.create_date <'$date'
      AND member.county = $county");
    }
    if ($query->num_rows()) { //避免count=0 被判定為null
      return $query->result_array();
    }
  }
  /*
   * Get counseling_identity_count_report course by organization
   * @Return: course object
   */
  function get_identity_no_by_county($county, $yearType, $month)
  {
    $query=$this->db->query("SELECT counseling_identity_count_report.no, counseling_identity_count_report.is_review
    from counseling_identity_count_report,project
    where project.county= $county
    AND counseling_identity_count_report.year=$yearType
    AND counseling_identity_count_report.month=$month
    AND counseling_identity_count_report.project = project.no");
    return $query->row();
  }

  function create_one($junior_under_graduate_boy,$junior_under_graduate_girl,$sixteen_years_old_not_employed_not_studying_boy,
  $sixteen_years_old_not_employed_not_studying_girl,$junior_graduated_this_year_unemployed_not_studying_boy,
  $junior_graduated_this_year_unemployed_not_studying_girl,$junior_graduated_not_this_year_unemployed_not_studying_boy,
  $junior_graduated_not_this_year_unemployed_not_studying_girl,$drop_out_from_senior_boy,
  $drop_out_from_senior_girl,$month,$year,$project,$is_review,$date)
  {
    $this->junior_under_graduate_boy=$junior_under_graduate_boy;
    $this->junior_under_graduate_girl=$junior_under_graduate_girl;
    $this->sixteen_years_old_not_employed_not_studying_boy=$sixteen_years_old_not_employed_not_studying_boy;
    $this->sixteen_years_old_not_employed_not_studying_girl=$sixteen_years_old_not_employed_not_studying_girl;
    $this->junior_graduated_this_year_unemployed_not_studying_boy=$junior_graduated_this_year_unemployed_not_studying_boy;
    $this->junior_graduated_this_year_unemployed_not_studying_girl=$junior_graduated_this_year_unemployed_not_studying_girl;
    $this->junior_graduated_not_this_year_unemployed_not_studying_boy=$junior_graduated_not_this_year_unemployed_not_studying_boy;
    $this->junior_graduated_not_this_year_unemployed_not_studying_girl=$junior_graduated_not_this_year_unemployed_not_studying_girl;
    $this->drop_out_from_senior_boy=$drop_out_from_senior_boy;
    $this->drop_out_from_senior_girl=$drop_out_from_senior_girl;
    $this->month=$month;
    $this->year=$year;
    $this->project=$project;
    $this->is_review=$is_review;
    $this->date=$date;
    // return ($this->db->insert('counseling_identity_count_report', $insertData)) ? $this->db->insert_id() : false;
    // $result = $this->db->insert('counseling_identity_count_report', $this);
    // if ($result) {
    //   return true;
    // } else {
    //   $error = $this->db->error();
    //   return $error;
    // }
    return ($this->db->insert('counseling_identity_count_report', $this)) ? $this->db->insert_id() : '';
  }
  
  function edit($junior_under_graduate_boy,$junior_under_graduate_girl,$sixteen_years_old_not_employed_not_studying_boy,
  $sixteen_years_old_not_employed_not_studying_girl,$junior_graduated_this_year_unemployed_not_studying_boy,
  $junior_graduated_this_year_unemployed_not_studying_girl,$junior_graduated_not_this_year_unemployed_not_studying_boy,
  $junior_graduated_not_this_year_unemployed_not_studying_girl,$drop_out_from_senior_boy,
  $drop_out_from_senior_girl,$month,$year,$project,$is_review,$date, $no)
  {
    $this->junior_under_graduate_boy=$junior_under_graduate_boy;
    $this->junior_under_graduate_girl=$junior_under_graduate_girl;
    $this->sixteen_years_old_not_employed_not_studying_boy=$sixteen_years_old_not_employed_not_studying_boy;
    $this->sixteen_years_old_not_employed_not_studying_girl=$sixteen_years_old_not_employed_not_studying_girl;
    $this->junior_graduated_this_year_unemployed_not_studying_boy=$junior_graduated_this_year_unemployed_not_studying_boy;
    $this->junior_graduated_this_year_unemployed_not_studying_girl=$junior_graduated_this_year_unemployed_not_studying_girl;
    $this->junior_graduated_not_this_year_unemployed_not_studying_boy=$junior_graduated_not_this_year_unemployed_not_studying_boy;
    $this->junior_graduated_not_this_year_unemployed_not_studying_girl=$junior_graduated_not_this_year_unemployed_not_studying_girl;
    $this->drop_out_from_senior_boy=$drop_out_from_senior_boy;
    $this->drop_out_from_senior_girl=$drop_out_from_senior_girl;
    $this->month=$month;
    $this->year=$year;
    $this->project=$project;
    $this->is_review=$is_review;
    $this->date=$date;
    $this->db->where('no', $no);
    // return ($this->db->insert('counseling_identity_count_report', $insertData)) ? $this->db->insert_id() : false;
    $result = $this->db->update('counseling_identity_count_report', $this);
    if ($result) {
      return true;
    } else {
      $error = $this->db->error();
      return $error;
    }
  }
  // 取得已輸入資料
  function get_inserted_identity_count_data($year,$month,$county)
  {
    $query = $this->db->query("SELECT * FROM `counseling_identity_count_report` WHERE `project`=$county AND `month`=$month AND `year`=$year");
    if ($query->num_rows()) {
      return $query->row();
    }
  }
  public function get_by_all($year, $month, $county)
    {
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

    function create_review_process($report_no, $review_status)
    {
      return $this->db->query("INSERT INTO `review_process` (`no`, `report_name`, `report_no`, `review_process`, `review_status`) VALUES (NULL, 'counseling_identity_count_report', $report_no, 6, $review_status)
      , (NULL, 'counseling_identity_count_report', $report_no, 3, $review_status), (NULL, 'counseling_identity_count_report', $report_no, 1, $review_status);");
    }
    function update_review_process($report_no, $review_status)
    {
      return $this->db->query("UPDATE `review_process` SET `review_status` = '$review_status' WHERE `review_process`.`no` = $report_no;");
    }
    function create_review_log($report_no, $review_status, $time, $comment, $role, $uID)
    {
      return $this->db->query("INSERT INTO `review_log` (`no`, `report_name`, `report_no`,`review_status`,`time`,`comment`,`user_role`,`user_id`) 
      VALUES (NULL, 'counseling_identity_count_report', $report_no,$review_status,'$time','$comment',$role,'$uID');");
    }
    function get_review_log_status_comment($role, $report_no)
    {
      $query = $this->db->query("SELECT * FROM `review_log` WHERE `report_name` LIKE 'counseling_identity_count_report' AND `report_no`=$report_no ORDER BY `time` ASC");
      if ($query->num_rows()) {
        return $query->result_array();
      }
    }
    function get_review_process($report_no)
    {
      $query = $this->db->query("SELECT * FROM `review_process` WHERE `report_name`='counseling_identity_count_report'
      AND `report_no`=$report_no");
      if ($query->num_rows()) {
        return $query->result_array();
      }
    }
    function get_county_contractor($county)
    {
      $this->db->select('users.name,users.id');
      $this->db->from('users');
      $this->db->where('county', $county);
      $this->db->where('manager', 0);
      $this->db->where('organization', null);
      $result = $this->db->get()->result_array();
      return $result;
    }
    public function get_by_yda()
    {
      $this->db->where('yda !=', null);
      $this->db->where('manager', 1);
      $result = $this->db->get('users')->result_array();
      return $result;
    }
    function get_first_submit_conse_id($report_no)
    {
      $query = $this->db->query("SELECT * FROM `review_log` WHERE `report_name` LIKE 'counseling_identity_count_report' AND `report_no`=$report_no ORDER BY `time` ASC");
      if ($query->num_rows()) {
        return $query->row();
      }
    }
  

}
