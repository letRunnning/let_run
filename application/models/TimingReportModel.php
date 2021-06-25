<?php
class TimingReportModel extends CI_Model
{
    /*
     * create seasonal review
     */
    public function create_one($county, $yda, $month, $year)
    {
        $this->county = $county;
        $this->yda = $yda;
        $this->date = date("Y-m-d");
        $this->month = $month;
        $this->year = $year;

        return ($this->db->insert('timing_report', $this)) ? $this->db->insert_id() : false;
    }

    /*
     * update seasonal review by youth
     */
    public function update_by_no($county, $yda, $month, $year, $no)
    {
        $this->county = $county;
        $this->yda = $yda;
        $this->date = date("Y-m-d");
        $this->month = $month;
        $this->year = $year;

        $this->db->where('county', $county);
        return $this->db->update('timing_report', $this);
    }

    public function get_county_by_county($county, $year, $month)
    {
        $this->db->where('county', $county);
        $this->db->where('year', $year);
        $this->db->where('month', $month);
        $this->db->where('yda', null);
        $this->db->limit(1);
        $result = $this->db->get('timing_report')->row();
        return $result;
    }

    public function get_yda_by_county($county, $year, $month)
    {
        $this->db->where('county', $county);
        $this->db->where('year', $year);
        $this->db->where('month', $month);
        $this->db->where('yda!=', null);
        $this->db->limit(1);
        $result = $this->db->get('timing_report')->row();
        return $result;
    }

    /*
     * Get seasonal review by no
     * @Return: seasonal review object
     */
    public function get_by_no($no)
    {
        $this->db->where('no', $no);

        $result = $this->db->get('insurance', 1)->row();
        return $result;
    }

    public function get_by_organization($organization, $yearType)
    {
        $this->db->select('insurance.*, youth.name, member.system_no');
        $this->db->join('member', 'insurance.member = member.no');
        $this->db->join('youth', 'youth.no = member.youth');
        $this->db->where('member.organization', $organization);
        $this->db->where('member.year', $yearType);
        $this->db->order_by('member.system_no', 'asc');
        $result = $this->db->get('insurance')->result_array();
        return $result;
    }

    public function check_is_insurance($member, $endDate)
    {
        $this->db->select('insurance.*');

        $this->db->where('insurance.member', $member);
        $this->db->where('insurance.start_date <=', $endDate);
        $this->db->where('DATE_ADD(end_date, INTERVAL 1 DAY) >=', $endDate);

        $result = $this->db->get('insurance')->num_rows();
        return $result;
    }

    public function get_two_years_by_report($county)
    {
        $this->db->select('seasonal_review.*, youth.name');
        $this->db->join('youth', 'seasonal_review.youth = youth.no');
        $this->db->where('youth.county', $county);
        $this->db->where('youth.source_school_year', date("Y") - 1911 - 4);
        $this->db->order_by('seasonal_review.no desc, seasonal_review.youth desc');

        $result = $this->db->get('seasonal_review')->result_array();
        return $result;
    }

    public function get_one_years_by_report($county)
    {
        $this->db->select('seasonal_review.*, youth.name');
        $this->db->join('youth', 'seasonal_review.youth = youth.no');
        $this->db->where('youth.county', $county);
        $this->db->where('youth.source_school_year', date("Y") - 1911 - 3);
        $this->db->order_by('seasonal_review.no desc, seasonal_review.youth desc');

        $result = $this->db->get('seasonal_review')->result_array();
        return $result;
    }

    public function get_now_years_by_report($county)
    {
        $this->db->select('seasonal_review.*, youth.name');
        $this->db->join('youth', 'seasonal_review.youth = youth.no');
        $this->db->where('youth.county', $county);
        $this->db->where('youth.source_school_year', date("Y") - 1911 - 2);
        $this->db->order_by('seasonal_review.no desc, seasonal_review.youth desc');

        $result = $this->db->get('seasonal_review')->result_array();
        return $result;
    }
}
