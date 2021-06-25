<?php
class SeasonalReviewModel extends CI_Model
{
    /*
     * create seasonal review
     */
    public function create_one($youth, $counselor, $date, $isCounseling, $trend, $trendDescription)
    {
        $this->youth = $youth;
        $this->counselor = $counselor;
        $this->date = $date;
        $this->is_counseling = $isCounseling;
        $this->trend = $trend;
        $this->trend_description = $trendDescription;
        return ($this->db->insert('seasonal_review', $this)) ? $this->db->insert_id() : false;
    }

    /*
     * update seasonal review by youth
     */
    public function update_by_no($youth, $counselor, $date, $isCounseling, $trend, $trendDescription, $no)
    {
        $this->youth = $youth;
        $this->counselor = $counselor;
        $this->date = $date;
        $this->is_counseling = $isCounseling;
        $this->trend = $trend;
        $this->trend_description = $trendDescription;

        $this->db->where('no', $no);
        return $this->db->update('seasonal_review', $this);
    }

    /*
     * Get seasonal review by youth
     * @Return: case_assessment object
     */
    public function get_by_youth($youth)
    {
        $this->db->where('youth', $youth);
        $result = $this->db->get('seasonal_review')->result_array();
        return $result;
    }

    public function get_by_date($youth, $toDate, $fromDate)
    {
        $this->db->where('youth', $youth);
        $this->db->where('date<=', $toDate);
        $this->db->where('date>=', $fromDate);
        $result = $this->db->get('seasonal_review')->result_array();
        return $result;
    }



    public function get_by_youth_one($youth)
    {
        $this->db->where('youth', $youth);
        $this->db->order_by('no', 'desc');
        $result = $this->db->get('seasonal_review', 1)->row();
        return $result;
    }

    public function get_by_county($county)
    {
        $this->db->select('seasonal_review.*');
        $this->db->join('youth', 'seasonal_review.youth = youth.no');
        $this->db->where('youth.county', $county);
        $this->db->order_by('seasonal_review.no', 'desc');
        $result = $this->db->get('seasonal_review')->result_array();
        return $result;
    }

    /*
     * Get seasonal review by no
     * @Return: seasonal review object
     */
    public function get_by_no($no)
    {
        $this->db->select('*, DATE_SUB(`date`,INTERVAL 1911 YEAR)AS dateTW');
        $this->db->where('no', $no);

        $result = $this->db->get('seasonal_review', 1)->row();
        return $result;
    }

    public function get_two_years_by_report($county)
    {
        $this->db->select('seasonal_review.*, youth.name');
        $this->db->join('youth', 'seasonal_review.youth = youth.no');
        $this->db->where('youth.county', $county);
        $this->db->where('youth.source_school_year', date("Y") - 1911 - 4);
        $this->db->order_by('seasonal_review.no desc, seasonal_review.youth desc');

        $result = $this->db->get('(SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review')->result_array();
        return $result;
    }

    public function get_one_years_by_report($county)
    {
        $this->db->select('seasonal_review.*, youth.name');
        $this->db->join('youth', 'seasonal_review.youth = youth.no');
        $this->db->where('youth.county', $county);
        $this->db->where('youth.source_school_year', date("Y") - 1911 - 3);
        $this->db->order_by('seasonal_review.no desc, seasonal_review.youth desc');

        $result = $this->db->get('(SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review')->result_array();
        return $result;
    }

    public function get_now_years_by_report($county)
    {
        $this->db->select('seasonal_review.*, youth.name');
        $this->db->join('youth', 'seasonal_review.youth = youth.no');
        $this->db->where('youth.county', $county);
        $this->db->where('youth.source_school_year', date("Y") - 1911 - 2);
        $this->db->order_by('seasonal_review.no desc, seasonal_review.youth desc');

        $result = $this->db->get('(SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review')->result_array();
        return $result;
    }

    public function get_old_case_by_report($county, $source)
    {
        $this->db->select('seasonal_review.*, youth.name');
        $this->db->join('youth', 'seasonal_review.youth = youth.no');
        $this->db->join('member', 'member.youth = youth.no');
        $this->db->where('member.year', date("Y") - 1911 - 1);
        $this->db->where('youth.county', $county);
        //$this->db->where('youth.source', $source);
        //$this->db->like('youth.source', $source, 'both');
        $this->db->order_by('seasonal_review.no desc, seasonal_review.youth desc');

        $result = $this->db->get('(SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review')->result_array();
        return $result;
    }
}
