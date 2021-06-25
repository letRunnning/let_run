<?php
class MonthMemberTempCounselingModel extends CI_Model
{
    /*
     * create course
     */
    public function create_one($member, $trend, $trendDescription, $month, $county)
    {
        $this->member = $member;
        $this->trend = $trend;
        $this->trend_description = $trendDescription;
        $this->month = $month;
        $this->year = date("Y") - 1911;
        $this->county = $county;

        return ($this->db->insert('month_member_temp_counseling', $this)) ? $this->db->insert_id() : '';
    }

    /*
     * update course by no
     */
    public function update_by_county_and_month($member, $trend, $trendDescription, $month, $county)
    {
        $this->trend = $trend;
        $this->trend_description = $trendDescription;

        $this->db->where('county', $county);
        $this->db->where('month', $month);
        $this->db->where('member', $member);

        return $this->db->update('month_member_temp_counseling', $this);
    }

    public function delete_by_group_counseling($county, $month)
    {

        return $this->db->delete('month_member_temp_counseling', $this);
    }

    /*
     * Get course by organization
     * @Return: course object
     */
    public function get_by_county_and_month($county, $month, $year)
    {
        $this->db->select('month_member_temp_counseling.*,member.system_no, youth.name,
          youth.name as youthName,
          aes_decrypt(`identification`, "' . $this->config->item('db_token') . '") as identifications,
          (select end_case.trend from end_case where end_case.member = month_member_temp_counseling.member) as end_trend');
        
       
        $this->db->join('member', 'month_member_temp_counseling.member = member.no');
        $this->db->join('youth', 'member.youth = youth.no');
        $this->db->where('month_member_temp_counseling.county', $county);
        $this->db->where('month_member_temp_counseling.month', $month);
        $this->db->where('month_member_temp_counseling.year', $year);
        $result = $this->db->get('month_member_temp_counseling')->result_array();
        return $result;
    }

    /*
     * Get expert_list by no
     * @Return: expert_list object
     */
    public function get_by_member($county, $month, $member)
    {
      $this->db->select('month_member_temp_counseling.*,member.system_no, youth.name,
      aes_decrypt(`identification`, "' . $this->config->item('db_token') . '") as identifications');
      
     
      $this->db->join('member', 'month_member_temp_counseling.member = member.no');
      $this->db->join('youth', 'member.youth = youth.no');
      $this->db->where('county', $county);
      $this->db->where('month', $month);
      $this->db->where('member', $member);
      $this->db->where('year', date("Y")-1911);
      $result = $this->db->get('month_member_temp_counseling', 1)->row();
      return $result;
    }

    public function get_counseling_count_by_county_and_month($county, $month, $year, $trendTypeData)
    {
        $this->db->select('(select count(*) from month_member_temp_counseling where trend =' . $trendTypeData['schoolNumber'] . ' and county = ' . $county . ' and month = ' . $month .' and year = ' . $year . ') as schoolMember,
        (select count(*) from month_member_temp_counseling where trend =' . $trendTypeData['workNumber'] . ' and county = ' . $county . ' and month = ' . $month .' and year = ' . $year . ') as workMember,
        (select count(*) from month_member_temp_counseling where trend =' . $trendTypeData['vocationalTrainingNumber'] . ' and county = ' . $county . ' and month = ' . $month .' and year = ' . $year . ') as vocationalTrainingMember,
        (select count(*) from month_member_temp_counseling where trend =' . $trendTypeData['noPlanNumber'] . ' and county = ' . $county . ' and month = ' . $month .' and year = ' . $year . ') as noPlanMember,
        (select count(*) from month_member_temp_counseling where trend =' . $trendTypeData['forceMajeureNumber'] . ' and county = ' . $county . ' and month = ' . $month .' and year = ' . $year . ') as forceMajeureMember,
        (select count(*) from month_member_temp_counseling where trend =' . $trendTypeData['otherNumberOne'] . ' and county = ' . $county . ' and month = ' . $month .' and year = ' . $year . ') as otherNumberOne,
        (select count(*) from month_member_temp_counseling where trend =' . $trendTypeData['otherNumberTwo'] . ' and county = ' . $county . ' and month = ' . $month .' and year = ' . $year . ') as otherNumberTwo,
        (select count(*) from month_member_temp_counseling where trend =' . $trendTypeData['otherNumberThree'] . ' and county = ' . $county . ' and month = ' . $month .' and year = ' . $year . ') as otherNumberThree,
        (select count(*) from month_member_temp_counseling where trend =' . $trendTypeData['otherNumberFour'] . ' and county = ' . $county . ' and month = ' . $month .' and year = ' . $year . ') as otherNumberFour');
        
        $result = $this->db->get('month_member_temp_counseling', 1)->row();
        return $result;
    }
}
