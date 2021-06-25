<?php
class AuditModel extends CI_Model {
   /*
   * get project by county
   * @Return: array of county object
   */
  function get_by_all() {
    $this->db->order_by("date", "desc");

    return $this->db->get('audit')->result_array();
  }

  function create_one($id, $auditId, $status, $startDate, $endDate, $note) {

    $this->id = $id;
    $this->audit_id = $auditId;
    $this->status = $status;
    $this->note = $note;
    $this->start_date = $startDate;
    $this->end_date = $endDate;
    $this->date = date("Y-m-d");
   
    return $this->db->insert('audit', $this);
  }

  


}