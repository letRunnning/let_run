<?php
class CounselingIdentityCountReportUpdateModel extends CI_Model
{
  
  
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
  

}
