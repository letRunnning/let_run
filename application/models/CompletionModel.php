<?php
class CompletionModel extends CI_Model {
  /*
   * create completion 
   */
  function create_one($formName, $formNo, $rate) {
    $this->form_name = $formName;
    $this->form_no = $formNo;
    $this->rate = $rate;
   
    return $this->db->insert('completion', $this);
  }

  /*
   * update completion by formName and formNo
   */
  function update_one($formName, $formNo, $rate) {
    $this->rate = $rate;
   
    $this->db->where('form_name', $formName);
    $this->db->where('form_no', $formNo);
    return $this->db->update('completion', $this);
  }

  /*
   * get menu items by content
   * @Return: Boolean
   */
  function get_rate_by_form_no($formName, $formNo) {
    $this->db->where('form_name', $formName);
    $this->db->where('form_no', $formNo);
    return $this->db->get('completion', 1)->row();
  }

  /*
   * get menu items by content
   * @Return: Boolean
   */
  function get_rate_by_form_name($formName) {
    $this->db->where('form_name', $formName);
    return $this->db->get('completion')->result_array();
  }
}