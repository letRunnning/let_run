<?php
class MonthReviewModel extends CI_Model {
  /*
   * create month review
   */
  function create_one($member, $date, $way, $wayOther) {

    $this->member = $member;
    $this->date = $date;
    $this->way = $way;
    $this->way_other = $wayOther;

    return ($this->db->insert('month_review', $this)) ? $this->db->insert_id() : false;
  }

  /*
   * update month review
   */
  function update_by_no($member, $date, $way, $wayOther, $no) {

    $this->member = $member;
    $this->date = $date;
    $this->way = $way;
    $this->way_other = $wayOther;

    $this->db->where('no', $no);
    return $this->db->update('month_review', $this);
  }

  /*
   * Get seasonal review by youth
   * @Return: case_assessment object
   */
  function get_by_member($member) {
    $this->db->where('member', $member);
    $result = $this->db->get('month_review')->result_array();
    return $result;
  }

  /*
   * Get seasonal review by no
   * @Return: seasonal review object
   */
  function get_by_no($no) {
    $this->db->where('no', $no);

    $result = $this->db->get('month_review', 1)->row();
    return $result;
  }

  function get_by_date($member, $fromDate, $toDate) {
    $this->db->where('member', $member);
    $this->db->where('date<=', $toDate);
    $this->db->where('date>=', $fromDate);

    $result = $this->db->get('month_review')->result_array();
    return $result;
  }
}