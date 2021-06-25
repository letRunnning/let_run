<?php
class CountyModel extends CI_Model {
  /*
   * check is name exist
   * @Return: Boolean
   */
  function is_name_exist($name) {
    $this->db->where('name', $name);
    return $this->db->get('county', 1)->num_rows() > 0;
  }

  /*
   * create county
   */
  function create_one($name, $phone, $orgnizer) {
    $this->name = $name;
    $this->phone = $phone;
    $this->orgnizer = $orgnizer;
    return $this->db->insert('county', $this);
  }

  /*
   * get all county
   * @Return: array of county object
   */
  function get_all() {
    $this->db->order_by("priority", "asc");
    $this->db->where('no!=', 23);
    return $this->db->get('county')->result_array();
  }

  function get_one($county) {
    $this->db->where('no', $county);
    return $this->db->get('county')->result_array();
  }

  /*
   * delegate project to organization
   * @Return: array of county object
   */
  function delegate_project_to_organization($county, $organization, $project) {
    $this->county = $county;
    $this->organization = $organization;
    $this->project = $project;
    return $this->db->insert('county_delegate_organization', $this);
  }

  /*
   * check is relation between county, project, organization exist
   * @Return: Boolean
   */
  function is_county_project_organization_relation_exist($county, $organization, $project) {
    $this->db->where('county', $county);
    $this->db->where('organization', $organization);
    $this->db->where('project', $project);
    return $this->db->get('county_delegate_organization', 1)->num_rows() > 0;
  }

  /*
   * check is organization has delegating relation exist
   * @Return: Boolean
   */
  function is_organization_has_relation($county, $organization) {
    $this->db->where('county', $county);
    $this->db->where('organization', $organization);
    $this->db->where('has_delegation', 1);
    return $this->db->get('county_delegate_organization', 1)->num_rows() > 0;
  }

  function get_by_county($county) {
    $this->db->select('county.orgnizer,
    organization.name as organizationName');
    $this->db->join('county', 'county.no = county_delegate_organization.county');
    $this->db->join('organization', 'organization.no = county_delegate_organization.organization');
    $this->db->where('has_delegation', 1);
    $this->db->where('county.no', $county);
    return $this->db->get('county_delegate_organization')->row();
  }

  /*
   * get one county by id
   * @Return: array of county object
   */
  function get_by_no($no) {
    $this->db->select('county.*,
      users.name as userName');
    $this->db->join('users', 'county.no = users.county');
    $this->db->where('no', $no);
    return $this->db->get('county')->row();
  }

  function get_by_no_new($no) {
    $this->db->select('county.*');
    $this->db->where('no', $no);
    return $this->db->get('county')->row();
  }

  function get_code_by_no($no) {
    $this->db->select('county.*');
    $this->db->where('no', $no);
    return $this->db->get('county')->row();
  }

  function get_counseling_member_count_report_by_county_and_year($county, $year) {
    $this->db->select('project.*,
      county.orgnizer,
      organization.name as organizationName');

    $this->db->join('county_delegate_organization', 'county_delegate_organization.project = project.no');
    $this->db->join('organization', 'organization.county = county_delegate_organization.county');
    $this->db->join('county', 'county.no = county_delegate_organization.county');

    $this->db->where('project.year', $year-1911);
    $this->db->where('project.county', $county);

    $result = $this->db->get('project', 1)->row();
    return $result;
  }

  function update_updateProject_by_county($county, $updateProject)
  {

      $this->update_project = $updateProject;
      $this->db->where('no', $county);
      return $this->db->update('county', $this);
  }
}