<?php
class MenuModel extends CI_Model {
  /*
   * get menu items by form and column name
   * @Return: Boolean
   */
  function get_by_form_and_column($form, $column) {
    $this->db->where('form_name', $form);
    $this->db->where('column_name', $column);
    return $this->db->get('menu')->result_array();
  }

  function get_by_form_and_column_order($form, $column) {
    $this->db->where('form_name', $form);
    $this->db->where('column_name', $column);
    $this->db->order_by('priority', 'asc');
    return $this->db->get('menu')->result_array();
  }

  /*
   * get menu items by content
   * @Return: Boolean
   */
  function get_referral_resource_by_content($content) {
    $this->db->where('form_name', 'individual_counseling');
    $this->db->where('content', $content);
    return $this->db->get('menu', 1)->row();
  }

  /*
   * get menu items by content
   * @Return: Boolean
   */
  function get_no_resource_by_content($content, $formName) {
    $this->db->where('form_name', $formName);
    $this->db->where('content', $content);
    return $this->db->get('menu', 1)->row();
  }
}