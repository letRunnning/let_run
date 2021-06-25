<?php
class SchoolModel extends CI_Model {
   /*
   * get project by county
   * @Return: array of county object
   */


  function get_all() 
  {
    $this->db->select('school.*');
    $result = $this->db->get('school')->result_array();
    return $result;
  }

  function update_one($name, $school) {

    $this->junior_school = $school . '/三年級/';
    $this->db->where('name', $name);
    return $this->db->update('youth', $this);
  }
}