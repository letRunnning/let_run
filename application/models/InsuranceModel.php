<?php
class InsuranceModel extends CI_Model
{
    /*
     * create seasonal review
     */
    public function create_one($member, $startDate, $endDate, $note, $type)
    {
        $this->member = $member;
        $this->start_date = $startDate;
        $this->end_date = $endDate;
        $this->note = $note;
        $this->type = $type;


        return ($this->db->insert('insurance', $this)) ? $this->db->insert_id() : false;
    }

    /*
     * update seasonal review by youth
     */
    public function update_by_no($member, $startDate, $endDate, $note, $type, $no)
    {
        $this->member = $member;
        $this->start_date = $startDate;
        $this->end_date = $endDate;
        $this->note = $note;
        $this->type = $type;

        $this->db->where('no', $no);
        return $this->db->update('insurance', $this);
    }

    public function get_by_member($member)
    {
        $this->db->where('member', $member);
        $result = $this->db->get('insurance')->result_array();
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

    public function get_by_organization($organization, $yearType, $monthType)
    {
        $this->db->select('insurance.*, member.system_no, youth.name as name');
        $this->db->join('member', 'insurance.member = member.no');
        $this->db->join('youth', 'youth.no = member.youth');
        $this->db->where('member.organization', $organization);
        $this->db->where('member.year', $yearType);
        $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
        $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;
        $this->db->where('insurance.start_date <', ($addYear + 1911) . '-' . $addMonth .'-1');
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
