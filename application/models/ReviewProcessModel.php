<?php
class ReviewProcessModel extends CI_Model
{
    /*
     * create one project
     * @Return: Boolean
     */
    public function create_one($reportName, $reportNo, $reviewStatus, $reviewProcess)
    {

        $this->report_name = $reportName;
        $this->report_no = $reportNo;
        $this->review_status = $reviewStatus;
        $this->review_process = $reviewProcess;

        return ($this->db->insert('review_process', $this)) ? $this->db->insert_id() : false;
    }

    public function update_one($reportName, $reportNo, $reviewStatus, $reviewProcess)
    {

        $this->review_status = $reviewStatus;

        $this->db->where('review_process', $reviewProcess);
        $this->db->where('report_name', $reportName);
        $this->db->where('report_no', $reportNo);

        return $this->db->update('review_process', $this);
    }

    public function get_by_report_no($reportName, $reportNo)
    {
        $this->db->where('report_no', $reportNo);
        $this->db->where('report_name', $reportName);
        return $this->db->get('review_process')->result_array();
    }

    public function get_by_counselor($reportName, $reportNo)
    {
        $this->db->where('report_no', $reportNo);
        $this->db->where('report_name', $reportName);
        $this->db->where('review_process', 6);
        return $this->db->get('review_process')->row();
    }

    public function get_by_county($reportName, $reportNo)
    {
        $this->db->where('report_no', $reportNo);
        $this->db->where('report_name', $reportName);
        $this->db->where('review_process', 3);
        return $this->db->get('review_process')->row();
    }

    public function get_by_yda($reportName, $reportNo)
    {
        $this->db->where('report_no', $reportNo);
        $this->db->where('report_name', $reportName);
        $this->db->where('review_process', 1);
        return $this->db->get('review_process')->row();
    }

}
