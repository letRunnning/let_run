<?php
class FundingApproveModel extends CI_Model
{
    /*
     * create seasonal review
     */
    public function create_one($county, $funding, $date, $note)
    {
        $this->county = $county;
        $this->funding = $funding;
        $this->date = $date;
        $this->note = $note;

        return ($this->db->insert('funding_approve', $this)) ? $this->db->insert_id() : false;
    }

    /*
     * update seasonal review by youth
     */
    public function update_by_no($county, $funding, $note, $date, $no)
    {
        $this->county = $county;
        $this->funding = $funding;
        $this->date = $date;
        $this->note = $note;

        $this->db->where('no', $no);
        return $this->db->update('funding_approve', $this);
    }

    public function get_by_county($county)
    {
        $this->db->where('county', $county);
        $result = $this->db->get('funding_approve')->result_array();
        return $result;
    }

    public function get_by_county_and_year($county, $year, $month)
    {
        $this->db->select('IFNULL(sum(funding),0) as sum');
        $addMonth = ($month + 1 > 12) ? 1 : $month + 1;
        $addYear = ($month + 1 > 12) ? $year + 1 : $year;

        $this->db->where('funding_approve.date <', ($addYear + 1911) . '-' . $addMonth . '-1');
        $this->db->where('funding_approve.date >=', ($addYear + 1911) . '-1-1');

        $this->db->where('county', $county);
        $result = $this->db->get('funding_approve')->row();
        return $result;
    }

    public function get_sum_by_county($county)
    {
        $this->db->select('sum(funding) as sum');

        $this->db->where('county', $county);
        $result = $this->db->get('funding_approve')->row();
        return $result;
    }

    /*
     * Get seasonal review by no
     * @Return: seasonal review object
     */
    public function get_by_no($no)
    {
        $this->db->where('no', $no);

        $result = $this->db->get('funding_approve', 1)->row();
        return $result;
    }

    public function get_by_all()
    {
        $result = $this->db->get('funding_approve')->result_array();
        return $result;
    }
}
