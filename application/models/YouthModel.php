<?php
class YouthModel extends CI_Model
{
    /*
     * create one youth
     * @Return: Boolean
     */
    public function create_one($identification, $name, $birth, $gender,
        $phone, $householdAddress, $resideAddress, $juniorGraduateYear, $juniorDropoutRecord, $counselIdentity, $juniorSchoolCondition, $seniorSchoolCondition,
        $guardianName, $guardianShip, $guardianPhone,
        $guardianHouseholdAddress, $guardianResideAddress, $county, $source, $sourceSchoolYear, $surveyType) {

        $key = $this->config->item('db_token');

        #$this->identification = $identification;
        $this->db->set('identification', "AES_ENCRYPT('$identification', '$key')", false);
        $this->name = $name;
        $this->birth = $birth;
        $this->gender = $gender;
        $this->phone = $phone;
        $this->db->set('household_address', "AES_ENCRYPT('$householdAddress', '$key')", false);
        $this->db->set('reside_address', "AES_ENCRYPT('$resideAddress', '$key')", false);
        $this->junior_graduate_year = $juniorGraduateYear;
        $this->junior_dropout_record = $juniorDropoutRecord;
        $this->counsel_identity = $counselIdentity;
        $this->junior_school_condition = $juniorSchoolCondition;
        $this->senior_school_condition = $seniorSchoolCondition;
        $this->guardian_name = $guardianName;
        $this->guardianship = $guardianShip;
        $this->guardian_phone = $guardianPhone;
        $this->db->set('guardian_household_address', "AES_ENCRYPT('$guardianHouseholdAddress', '$key')", false);
        $this->db->set('guardian_reside_address', "AES_ENCRYPT('$guardianResideAddress', '$key')", false);
        $this->county = $county;
        $this->source = $source;
        $this->source_school_year = $sourceSchoolYear;
        $this->survey_type = $surveyType;
        $this->year = date("Y") - 1911;
        $this->is_end = 0;

        return ($this->db->insert('youth', $this)) ? $this->db->insert_id() : false;
    }

    /*
     * update youth by no
     * @Return: Boolean
     */
    public function update_by_no($youthNo, $identification, $name, $birth, $gender,
        $phone, $householdAddress, $resideAddress, $juniorGraduateYear, $juniorDropoutRecord, $counselIdentity, $juniorSchoolCondition, $seniorSchoolCondition,
        $guardianName, $guardianShip, $guardianPhone,
        $guardianHouseholdAddress, $guardianResideAddress, $county, $source, $sourceSchoolYear, $surveyType, $juniorSchool) {
        $key = $this->config->item('db_token');
        #$this->identification = $identification;
        $this->db->set('identification', "AES_ENCRYPT('$identification', '$key')", false);
        $this->name = $name;
        $this->birth = $birth;
        $this->gender = $gender;
        $this->phone = $phone;
        $this->db->set('household_address', "AES_ENCRYPT('$householdAddress', '$key')", false);
        $this->db->set('reside_address', "AES_ENCRYPT('$resideAddress', '$key')", false);
        $this->junior_graduate_year = $juniorGraduateYear;
        $this->junior_dropout_record = $juniorDropoutRecord;
        $this->counsel_identity = $counselIdentity;
        $this->junior_school_condition = $juniorSchoolCondition;
        $this->senior_school_condition = $seniorSchoolCondition;
        $this->guardian_name = $guardianName;
        $this->guardianship = $guardianShip;
        $this->guardian_phone = $guardianPhone;
        $this->db->set('guardian_household_address', "AES_ENCRYPT('$guardianHouseholdAddress', '$key')", false);
        $this->db->set('guardian_reside_address', "AES_ENCRYPT('$guardianResideAddress', '$key')", false);
        $this->county = $county;
        $this->source = $source;
        $this->source_school_year = $sourceSchoolYear;
        $this->survey_type = $surveyType;
        $this->junior_school = $juniorSchool;

        $this->db->where('no', $youthNo);
        return $this->db->update('youth', $this);
    }

    /*
     * update youth by no
     * @Return: Boolean
     */
    public function update_junior_by_no($juniorSchool, $seniorSchool, $youthNo)
    {

        $this->junior_school = $juniorSchool;
        $this->senior_school = $seniorSchool;

        $this->db->where('no', $youthNo);
        return $this->db->update('youth', $this);
    }

    public function update_is_end_by_no($isEnd, $no)
    {

        $this->is_end = $isEnd;

        $this->db->where('no', $no);
        return $this->db->update('youth', $this);
    }

    public function update_county_by_no($county, $no)
    {

        $this->county = $county;

        $this->db->where('no', $no);
        return $this->db->update('youth', $this);
    }

    /*
     * get all youth
     * @Return: array of youth object
     */
    public function get_all()
    {
        return $this->db->get('youth')->result_array();
    }

    /*
     * get all youth
     * @Return: array of youth object
     */
    public function get_all_source_by_county($county, $surveyType, $year)
    {

        $this->db->select('youth.*,  youth.name as youthName,
    aes_decrypt(`identification`, "' . $this->config->item('db_token') . '") as identifications');
        $this->db->where('county', $county);
        $this->db->where('source', $surveyType);
        if (!empty($year)) {

            $this->db->where('source_school_year', $year);
        }
        return $this->db->get('youth')->result_array();
    }

    /*
     * get youth by county
     * @Return: array of youth object
     */
    public function get_by_county($county, $noNeedSources, $sourceReferral)
    {
        $this->db->select('youth.*,  youth.name as youthName,
    aes_decrypt(`identification`, "' . $this->config->item('db_token') . '") as identifications,
    aes_decrypt(`household_address`, "' . $this->config->item('db_token') . '") as household_address_aes,
    aes_decrypt(`reside_address`, "' . $this->config->item('db_token') . '") as reside_address_aes,
    aes_decrypt(`guardian_household_address`, "' . $this->config->item('db_token') . '") as guardian_household_address_aes,
    aes_decrypt(`guardian_reside_address`, "' . $this->config->item('db_token') . '") as guardian_reside_address_aes');
        $this->db->where('county', $county);
        if ($noNeedSources != null) {
            foreach ($noNeedSources as $value) {
                $this->db->where('survey_type!=', $value);
            }
        }
        $sourceSchoolYearArray = array(date("Y")-1911-4,date("Y")-1911-3, date("Y")-1911-2, date("Y")-1911-1,0);
        $this->db->where_in('source_school_year', $sourceSchoolYearArray);
        $isEndArray = array(null,0);

        $this->db->where_in('is_end', $isEndArray);
      
        return $this->db->get('youth')->result_array();
    }

    /*
     * get youth by county
     * @Return: array of youth object
     */
    public function get_distinct_years()
    {
        $this->db->select('year');
        $this->db->group_by('year');
        return $this->db->get('youth')->result_array();
    }

    /*
     * Get youth by no
     * @Return: youth object
     */
    public function get_by_no($no)
    {
        $this->db->select('youth.*,
    aes_decrypt(`identification`, "' . $this->config->item('db_token') . '") as identifications,
    aes_decrypt(`household_address`, "' . $this->config->item('db_token') . '") as household_address_aes,
    aes_decrypt(`reside_address`, "' . $this->config->item('db_token') . '") as reside_address_aes,
    aes_decrypt(`guardian_household_address`, "' . $this->config->item('db_token') . '") as guardian_household_address_aes,
    aes_decrypt(`guardian_reside_address`, "' . $this->config->item('db_token') . '") as guardian_reside_address_aes');
        $this->db->where('no', $no);
        $result = $this->db->get('youth', 1)->row();
        return $result;
    }

    /*
     * get youth by county
     * @Return: array of youth object
     */
    public function get_by_source_and_county($source, $county, $noNeedSources)
    {
        $this->db->select('youth.*, youth.name as youthName,
    aes_decrypt(`identification`, "' . $this->config->item('db_token') . '") as identifications');
        //$this->db->where('source', $source);
        $this->db->like('source', $source, 'both');
        $this->db->where('county', $county);
        $sourceSchoolYearArray = array(date("Y")-1911-4,date("Y")-1911-3, date("Y")-1911-2, date("Y")-1911-1,0);
        $isEndArray = array(null,0);
        $this->db->where_in('source_school_year', $sourceSchoolYearArray);

        $this->db->where_in('is_end', $isEndArray);

        if ($noNeedSources != null) {
            foreach ($noNeedSources as $value) {
                $this->db->where('survey_type!=', $value);
            }
        }
        $this->db->order_by("source_school_year", "desc");

        return $this->db->get('youth')->result_array();
    }

    public function get_by_source_and_county_by_school_year($source, $county, $noNeedSources, $schoolYear)
    {
        $this->db->select('youth.*,  youth.name as youthName,
    aes_decrypt(`identification`, "' . $this->config->item('db_token') . '") as identifications,
    aes_decrypt(`household_address`, "' . $this->config->item('db_token') . '") as household_address_aes,
    aes_decrypt(`reside_address`, "' . $this->config->item('db_token') . '") as reside_address_aes,
    aes_decrypt(`guardian_household_address`, "' . $this->config->item('db_token') . '") as guardian_household_address_aes,
    aes_decrypt(`guardian_reside_address`, "' . $this->config->item('db_token') . '") as guardian_reside_address_aes');
        //$this->db->where('source', $source);
        $this->db->like('source', $source, 'both');
        $this->db->where('county', $county);
        $sourceSchoolYearArray = array(date("Y")-1911-4,date("Y")-1911-3, date("Y")-1911-2, date("Y")-1911-1,0);
        $isEndArray = array(null,0);
        $this->db->where('source_school_year', $schoolYear);

        $this->db->where_in('is_end', $isEndArray);

        if ($noNeedSources != null) {
            foreach ($noNeedSources as $value) {
                $this->db->where('survey_type!=', $value);
            }
        }
        $this->db->order_by("source_school_year", "desc");

        return $this->db->get('youth')->result_array();
    }



    public function get_end_by_source_and_county($source, $county, $noNeedSources)
    {
        $this->db->select('youth.*,  youth.name as youthName,
    aes_decrypt(`identification`, "' . $this->config->item('db_token') . '") as identifications');
        //$this->db->where('source', $source);
        $this->db->like('source', $source, 'both');
        $this->db->where('county', $county);
        $this->db->where('source_school_year >=', date("Y")-1911-4);
        $this->db->where('is_end' , 1);

        if ($noNeedSources != null) {
            foreach ($noNeedSources as $value) {
                $this->db->where('survey_type!=', $value);
            }
        }
        return $this->db->get('youth')->result_array();
    }

    public function get_by_referral_and_county($source, $county)
    {
        $this->db->select('youth.*,  youth.name as youthName,
    aes_decrypt(`identification`, "' . $this->config->item('db_token') . '") as identifications');
        $this->db->join('intake', 'intake.youth = youth.no');
        $this->db->where('intake.open_case', 1);
        //$this->db->where('source', $source);
        $this->db->like('source', $source, 'both');
        $this->db->where('county', $county);
        $sourceSchoolYearArray = array(date("Y")-1911-4,date("Y")-1911-3, date("Y")-1911-2, date("Y")-1911-1,0);
        $isEndArray = array(null,0);

        $this->db->where_in('is_end', $isEndArray);


        return $this->db->get('youth')->result_array();
    }

    public function get_by_source_referral_and_county($source, $county)
    {
        $this->db->select('youth.*,  youth.name as youthName,
    aes_decrypt(`identification`, "' . $this->config->item('db_token') . '") as identifications');
        //$this->db->where('source', $source);
        $this->db->like('source', $source, 'both');
        $this->db->where('county', $county);

        return $this->db->get('youth')->result_array();
    }

    public function get_by_high_and_county($source, $county)
    {
        $this->db->select('youth.*,  youth.name as youthName,
    aes_decrypt(`identification`, "' . $this->config->item('db_token') . '") as identifications,
    aes_decrypt(`household_address`, "' . $this->config->item('db_token') . '") as household_address_aes,
    aes_decrypt(`reside_address`, "' . $this->config->item('db_token') . '") as reside_address_aes,
    aes_decrypt(`guardian_household_address`, "' . $this->config->item('db_token') . '") as guardian_household_address_aes,
    aes_decrypt(`guardian_reside_address`, "' . $this->config->item('db_token') . '") as guardian_reside_address_aes');
        //$this->db->where('source', $source);
        $this->db->like('source', $source, 'both');
        $this->db->where('county', $county);
        $isEndArray = array(null,0);

        $this->db->where_in('is_end', $isEndArray);

        return $this->db->get('youth')->result_array();
    }

    public function get_end_by_high_and_county($source, $county)
    {
        $this->db->select('youth.*,  youth.name as youthName,
    aes_decrypt(`identification`, "' . $this->config->item('db_token') . '") as identifications');
        //$this->db->where('source', $source);
        $this->db->like('source', $source, 'both');
        $this->db->where('county', $county);
        $this->db->where('is_end', 1);

        return $this->db->get('youth')->result_array();
    }

    /*
     * get youth by county
     * @Return: array of youth object
     */
    public function get_by_case_and_county($county)
    {
        $this->db->select('youth.*,  youth.name as youthName,
    aes_decrypt(`identification`, "' . $this->config->item('db_token') . '") as identifications');
        $this->db->from('youth');
        $this->db->join('member', 'member.youth = youth.no');
        $this->db->where('youth.county', $county);
        $this->db->where('member.create_date <', '2021-01-01');
        $this->db->where_in('is_end', 0);
        return $this->db->get()->result_array();
    }

    public function get_by_case_trend_and_county($county)
    {
        $this->db->select('youth.*,  youth.name as youthName,
    aes_decrypt(`identification`, "' . $this->config->item('db_token') . '") as identifications, member.end_date, member.no as memberNo');
        $this->db->from('youth');
        $this->db->join('member', 'member.youth = youth.no');
        $this->db->where('youth.county', $county);
        $this->db->where('member.end_date !=', null);
        $this->db->where_in('is_end', 0);
        return $this->db->get()->result_array();
    }

    public function get_end_by_case_and_county($county)
    {
        $this->db->select('youth.*,  youth.name as youthName,
    aes_decrypt(`identification`, "' . $this->config->item('db_token') . '") as identifications');
        $this->db->from('youth');
        $this->db->join('member', 'member.youth = youth.no');
        $this->db->where('youth.county', $county);
        $this->db->where('member.create_date <', '2020-01-01');
        $this->db->where('is_end', 1);
        return $this->db->get()->result_array();
    }

    /*
     * get project by county
     * @Return: array of county object
     */
    public function get_distinct_source_school_year_by_county($county)
    {
        $this->db->select('source_school_year');
        $this->db->where('county', $county);
        $this->db->where('source_school_year!=', null);
        $this->db->where('source_school_year!=', 0);
        $this->db->group_by("source_school_year");
        return $this->db->get('youth')->result_array();
    }

    public function get_two_years_trend_by_county($county)
    {
        $this->db->select('youth.*');
        $this->db->where('source_school_year', date("Y") - 1911 - 4);
        $this->db->where('county', $county);

        return $this->db->get('youth')->num_rows();
    }

    public function get_one_years_trend_by_county($county)
    {
        $this->db->select('youth.*');
        $this->db->where('source_school_year', date("Y") - 1911 - 3);
        $this->db->where('county', $county);

        return $this->db->get('youth')->num_rows();
    }

    public function get_now_years_trend_by_county($county)
    {
        $this->db->select('youth.*');
        $this->db->where('source_school_year', date("Y") - 1911 - 2);
        $this->db->where('county', $county);

        return $this->db->get('youth')->num_rows();
    }

    public function get_end_case_trend_by_county($county, $source)
    {
        $this->db->select('youth.*');
        $this->db->join('member', 'member.youth = youth.no');

        //$this->db->where('youth.source', $source);
        //$this->db->like('source', $source, 'both');
        $this->db->where('member.year', date("Y") - 1911 - 1);
        $this->db->where('youth.county', $county);

        return $this->db->get('youth')->num_rows();
    }

    function get_repeat_youth($county)
    {
      $this->db->select('youth.*,
    aes_decrypt(`identification`, "' . $this->config->item('db_token') . '") as identifications');
        $this->db->where('county', $county);
        $this->db->group_by('name'); 
        $this->db->having('count(*)>',  1);
        $result = $this->db->get('youth')->result_array();
        return $result;
    }

    function get_repeat_youth_in($county, $name)
    {
      $this->db->select('youth.*,
    aes_decrypt(`identification`, "' . $this->config->item('db_token') . '") as identifications');
        $this->db->where('county', $county);
        $this->db->where('name', $name);
        $result = $this->db->get('youth')->result_array();
        return $result;
    }

    public function get_now_years_need_track_youth_by_county($county)
    {
      $this->db->select('youth.*');
      $this->db->where('youth.county', $county);
      $this->db->where('youth.source', 194);
      $this->db->where('youth.source_school_year', date("Y")-1911-2);
      $this->db->where('youth.survey_type >=', 216);
      $this->db->where('youth.survey_type <=', 232);
      $this->db->where('youth.survey_type !=', 225);
      return $this->db->get('youth')->result_array();
    }

    public function get_high_school_youth_by_county($county)
    {
      $this->db->select('youth.*');
      $this->db->where('youth.county', $county);
      $this->db->where('youth.source', 229);
      return $this->db->get('youth')->result_array();
    }

    public function get_one_years_need_track_youth_by_county($county)
    {
      $this->db->select('youth.*');
      $this->db->where('youth.county', $county);
      $this->db->where('youth.source', 194);
      $this->db->where('youth.source_school_year', date("Y")-1911-3);
      $this->db->where('youth.survey_type >=', 216);
      $this->db->where('youth.survey_type <=', 232);
      $this->db->where('youth.survey_type !=', 225);
      return $this->db->get('youth')->result_array();
    }

    public function get_two_years_need_track_youth_by_county($county)
    {
      $this->db->select('youth.*');
      $this->db->where('youth.county', $county);
      $this->db->where('youth.source', 194);
      $this->db->where('youth.source_school_year', date("Y")-1911-4);
      $this->db->where('youth.survey_type >=', 216);
      $this->db->where('youth.survey_type <=', 232);
      $this->db->where('youth.survey_type !=', 225);
      return $this->db->get('youth')->result_array();
    }

    public function get_transfer_out_youth_by_county($county) 
    {
      $this->db->select('review.*');
      $this->db->where('review.county', $county);
      $this->db->where('review.form_name', 'transfer_youth');
      $this->db->where('review.status', 237);
      $this->db->where('review.end_time >=', '2021-04-15 12:00:00');
      return $this->db->get('review')->result_array();
    }

    public function get_transfer_out_youth_by_youth($youth, $updateValue) 
    {
      $this->db->select('review.*');

      $this->db->where('review.form_no', $youth);
      $this->db->where('review.county', $updateValue);
      $this->db->where('review.form_name', 'transfer_youth');
      $this->db->where('review.status', 237);
      $this->db->where('review.end_time >=', '2021-04-15 12:00:00');

      $result = $this->db->get('review', 1)->row();
      return $result;
    }

    public function get_transfer_in_youth_by_county($county) 
    {
      $this->db->select('review.*');
      $this->db->where('review.county', $county);
      $this->db->where('review.update_value', $county);
      $this->db->where('review.form_name', 'transfer_youth');
      $this->db->where('review.status', 237);
      $this->db->where('review.end_time >=', '2021-04-15 12:00:00');
      return $this->db->get('review')->result_array();
    }

    public function get_now_years_end_youth_by_county($county)
    {
      $this->db->select('youth.*');
      $this->db->where('youth.county', $county);
      $this->db->where('youth.source', 194);
      $this->db->where('youth.source_school_year', date("Y")-1911-4);
      $this->db->where('youth.survey_type >=', 216);
      $this->db->where('youth.survey_type <=', 232);
      $this->db->where('youth.survey_type !=', 225);
      $this->db->where('youth.is_end', 1);

      return $this->db->get('youth')->result_array();
    }

    public function get_high_school_end_youth_by_county($county)
    {
      $this->db->select('youth.*');
      $this->db->where('youth.county', $county);
      $this->db->where('youth.source', 229);
      $this->db->where('youth.is_end', 1);
      return $this->db->get('youth')->result_array();
    }

}
