<?php
class UpdateRepeatTwoModel extends CI_Model
{
  public function update_by_youth($county, $no, $guardianName, $sourceSchoolYear, $surveyType) {

    $this->guardian_name = $guardianName;
    $this->source = '229,194';
    $this->source_school_year = $sourceSchoolYear;
    $this->survey_type = $surveyType;
    $this->year = 109;


    $this->db->where('no', $no);
    return $this->db->update('youth', $this);
  }
}