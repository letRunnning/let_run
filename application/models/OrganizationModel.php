<?php
class OrganizationModel extends CI_Model {
  /*
   * check is name exist
   * @Return: Boolean
   */
  function is_name_exist($name) {
    $this->db->where('name', $name);
    return $this->db->get('organization', 1)->num_rows() > 0;
  }

  /*
   * create one organization personnel
   * @Return: Boolean
   */
  function create_one($county, $name, $phone, $address) {
    $this->county = $county;
    $this->name = $name;
    $this->phone = $phone;
    $this->address = $address;
    return $this->db->insert('organization', $this);
  }

  /*
   * get by county
   * @Return: array of organization object
   */
  function get_by_county($county) {
    $this->db->where('county', $county);
    return $this->db->get('organization')->result_array();
  }

   /*
   * get one county by id
   * @Return: array of county object
   */
  function get_by_no($no) {
    $this->db->select('organization.name,
      users.name as userName');
    $this->db->join('users', 'organization.no = users.organization');
    $this->db->where('no', $no);
    return $this->db->get('organization')->row();
  }

  function get_name_by_no($no) {
    $this->db->select('organization.name');
    $this->db->where('no', $no);
    return $this->db->get('organization')->row();
  }

  /*
   * get current project number
   * @Return: int
   */
  function get_by_project($county) {
    $this->db->where('county', $county);
    $this->db->where('organization', $organization);
    $this->db->where('has_delegation', 1);
    $this->db->order_by('no', 'desc');
    $this->db->limit(1);
    
    return $this->db->get('county_delegate_organization')->row()->project;
  }
}