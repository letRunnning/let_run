<?php
class MemberModel extends CI_Model {
  /*
   * create one member
   * @Return: Boolean
   */
  function create_one($systemNo, $youth, $counselor, $project, $organization, $county) {
    $this->system_no = $systemNo;
    $this->youth = $youth;
    $this->counselor = $counselor;
    $this->project = $project;
    $this->organization = $organization;
    $this->county = $county;
    $this->create_date = date('Y-m-d');
    $this->year = date("Y")-1911;
    return ($this->db->insert('member', $this)) ? $this->db->insert_id() : false;;
  }

   /*
   * create one counselor_serving_member
   * @Return: Boolean
   */
  function create_counselor_serving_member($counselor, $member) {
    $this->counselor = $counselor;
    $this->member = $member;
    return $this->db->insert('counselor_serving_member', $this);
  }

  /*
   * count county member in duration of project execution 
   * @Return: int
   */
  function count_county_member_in_project($project, $county) {
    $this->db->where('project', $project);
    $this->db->where('county', $county);
    $this->db->where('year', date("Y")-1911);
    return $this->db->get('member')->num_rows();
  }

  function get_year_by_organization($organization){
    $this->db->select('project.year');

    $this->db->from('project');
    $this->db->join('county_delegate_organization', 'county_delegate_organization.project = project.no');
    $this->db->where('county_delegate_organization.organization', $organization);
    $this->db->group_by("project.year");

    $result = $this->db->get()->result_array();
    return $result;
  }

  function get_year_by_county($county){
    $this->db->select('project.year');

    $this->db->from('project');
    $this->db->join('county_delegate_organization', 'county_delegate_organization.project = project.no');
    $this->db->where('county_delegate_organization.county', $county);
    $this->db->group_by("project.year");

    $result = $this->db->get()->result_array();
    return $result;
  }

  /*
   * Get member by counselor
   * @Return: member object
   */
  function get_by_conselor($counselor, $year) {
    $this->db->select('member.*, youth.no as youthNo, youth.name, youth.identification, 
    aes_decrypt(`identification`, "'.  $this->config->item('db_token') . '") as identifications');
    $this->db->from('member');
    $this->db->join('youth', 'member.youth = youth.no');
    $this->db->where('counselor', $counselor);
    $this->db->where('member.year', $year);

    $result = $this->db->get()->result_array();
    return $result;
  }

  function get_by_county($county, $year) {
    $this->db->select('member.*, youth.name as name, youth.identification, 
    aes_decrypt(`identification`, "'.  $this->config->item('db_token') . '") as identifications');
    $this->db->from('member');
    $this->db->join('youth', 'member.youth = youth.no');
    $this->db->where('member.county', $county);
    $this->db->where('member.year', $year);

    $result = $this->db->get()->result_array();
    return $result;
  }

  /*
   * Get member by organization
   * @Return: member object
   */
  function get_by_organization($organization) {
    $this->db->select('member.*, youth.name as name, youth.identification, 
    aes_decrypt(`identification`, "'.  $this->config->item('db_token') . '") as identifications');
    $this->db->from('member');
    $this->db->join('youth', 'member.youth = youth.no');
    $this->db->where('organization', $organization);
    $this->db->where('end_date', null);
    $this->db->where('member.year', date("Y")-1911);

    $result = $this->db->get()->result_array();
    return $result;
  }

  function get_by_organization_course_work($organization) {
    $this->db->select('member.*, youth.name, youth.identification, 
    aes_decrypt(`identification`, "'.  $this->config->item('db_token') . '") as identifications');
    $this->db->from('member');
    $this->db->join('youth', 'member.youth = youth.no');
    $this->db->where('organization', $organization);
    $this->db->where('end_date', null);
    $this->db->where('member.year', date("Y")-1911);

    $result = $this->db->get()->result_array();
    return $result;
  }

  function get_member_month($county, $year, $month) {
    $this->db->select('member.*, youth.name, youth.source, youth.survey_type, youth.source_school_year,
    aes_decrypt(`identification`, "'.  $this->config->item('db_token') . '") as identifications,
    (select end_case.trend from end_case where end_case.member = member.no) as trend');
    $this->db->from('member');
    $this->db->join('youth', 'member.youth = youth.no');
   
    $this->db->where('member.county', $county);

    $addMonth = ($month + 1 > 12) ? 1 : $month+1 ;
    $addYear =  ($month + 1 > 12) ? $year + 1 : $year ;

    $this->db->where('member.year', $year);
    $this->db->where('member.create_date <', ($addYear + 1911) . '-' . $addMonth .'-1');

    $result = $this->db->get()->result_array();
    return $result;
  }

  /*
   * Get member by no
   * @Return: member object
   */
  function get_by_no($no) {
    $this->db->select('member.*, youth.name');
    $this->db->join('youth', 'member.youth = youth.no');
    $this->db->where('member.no', $no);

    $result = $this->db->get('member', 1)->row();
    return $result;
  }

  /*
   * Get youth by member
   * @Return: youth object
   */
  function get_by_member($no) {
    $this->db->select('youth.*, member.system_no');
    $this->db->join('youth', 'member.youth = youth.no');
    $this->db->where('member.no', $no);

    $result = $this->db->get('member', 1)->row();
    return $result;
  }

  /*
   * Get youth by member
   * @Return: youth object
   */
  function get_by_identification($identification) {
    $this->db->select('member.no');
    $this->db->join('youth', 'member.youth = youth.no');
    $this->db->where('youth.identification', $identification);
    $this->db->order_by("member.create_date", "asc");

    $result = $this->db->get('member', 1)->row();
    return $result;
  }

  /*
   * check is member exist
   * @Return: Boolean
   */
  function is_member_exist($youth, $project) {
    $this->db->where('youth', $youth);
    $this->db->where('project', $project);
    $this->db->where('year', date("Y")-1911);
    
    return $this->db->get('member', 1)->num_rows() > 0;
  }

  function is_member($youth) {
    $this->db->where('youth', $youth);
    $this->db->where('end_date', null);
    return $this->db->get('member', 1)->num_rows() > 0;
  }

  /*
   * update youth by no
   * @Return: Boolean
   */
  function update_end_date_by_no($no) {
    $this->end_date = date('Y-m-d');
    
    $this->db->where('no', $no);
    return $this->db->update('member', $this);
  }

  function update_counselor_by_no($no, $counselor) {
    $this->counselor = $counselor;
    
    $this->db->where('no', $no);
    return $this->db->update('member', $this);
  }

  function get_by_organization_county($organization) {
    $this->db->select('member.*, youth.name, youth.identification, 
    aes_decrypt(`identification`, "'.  $this->config->item('db_token') . '") as identifications');
    $this->db->from('member');
    $this->db->join('youth', 'member.youth = youth.no');
    $this->db->where('organization', $organization);
    $this->db->where('member.year', date("Y")-1911);

    $result = $this->db->get()->num_rows();
    return $result;
  }
  

  function get_by_county_count($county, $monthType, $yearType) {
    $this->db->select('member.*, youth.name, youth.identification, 
    aes_decrypt(`identification`, "'.  $this->config->item('db_token') . '") as identifications');
    $this->db->from('member');
    $this->db->join('youth', 'member.youth = youth.no');
    $this->db->where('member.county', $county);
    $this->db->where('member.year', $yearType);

    $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
    $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;

    $this->db->where('member.create_date <', ($addYear + 1911) . '-' . $addMonth .'-1');

    $result = $this->db->get()->num_rows();
    return $result;
  }

  function get_new_case($county, $monthType, $yearType) {
    $this->db->select('youth.*, member.*');
    $this->db->from('member');
    $this->db->join('youth', 'member.youth = youth.no');
    $this->db->group_by('youth'); 
    $this->db->having('count(youth)',  1);
    $this->db->where('member.county', $county);
    
    $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
    $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;
    $this->db->where('member.create_date <', ($addYear + 1911) . '-' . $addMonth .'-1');
    // $this->db->where('member.end_date', null);

    $result = $this->db->get()->result_array();
    return $result;
  }

  function get_old_case($county, $monthType, $yearType) {
    $this->db->select('youth.*, member.*');
    $this->db->from('member');
    $this->db->join('youth', 'member.youth = youth.no');
    $this->db->group_by('youth'); 
    $this->db->having('count(*)>',  1);
    $this->db->where('member.county', $county);
    $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
    $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;
    $this->db->where('member.create_date <', ($addYear + 1911) . '-' . $addMonth .'-1');

    $result = $this->db->get()->result_array();
    return $result;
  }

  function get_two_year_survry_case_member($county, $monthType, $yearType) {
    $this->db->select('member.*');
    $this->db->from('member');
    $this->db->join('youth', 'member.youth = youth.no');
    $this->db->where('member.county', $county);
    $this->db->where('youth.source_school_year', $yearType-4);
    $this->db->where('member.year', $yearType);
    $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
    $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;
    $this->db->where('member.create_date <', ($addYear + 1911) . '-' . $addMonth .'-1');

    $result = $this->db->get()->num_rows();
    return $result;
  }

  function get_one_year_survry_case_member($county, $monthType, $yearType) {
    $this->db->select('member.*');
    $this->db->from('member');
    $this->db->join('youth', 'member.youth = youth.no');
    $this->db->where('member.county', $county);
    $this->db->where('youth.source_school_year', $yearType-3);
    $this->db->where('member.year', $yearType);
    $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
    $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;
    $this->db->where('member.create_date <', ($addYear + 1911) . '-' . $addMonth .'-1');

    $result = $this->db->get()->num_rows();
    return $result;
  }

  function get_now_year_survry_case_member($county, $monthType, $yearType) {
    $this->db->select('member.*');
    $this->db->from('member');
    $this->db->join('youth', 'member.youth = youth.no');
    $this->db->where('member.county', $county);
    $this->db->where('youth.source_school_year', $yearType-2);
    $this->db->where('member.year', $yearType);
    $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
    $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;
    $this->db->where('member.create_date <', ($addYear + 1911) . '-' . $addMonth .'-1');

    $result = $this->db->get()->num_rows();
    return $result;
  }

  function get_next_year_survry_case_member($county, $monthType, $yearType) {
    $this->db->select('member.*');
    $this->db->from('member');
    $this->db->join('youth', 'member.youth = youth.no');
    $this->db->where('member.county', $county);
    $this->db->where('youth.source_school_year', $yearType-1);
    $this->db->where('member.year', $yearType);
    $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
    $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;
    $this->db->where('member.create_date <', ($addYear + 1911) . '-' . $addMonth .'-1');

    $result = $this->db->get()->num_rows();
    return $result;
  }

  function get_high_school_survry_case_member($county, $monthType, $yearType, $sourceHigh) {
    $this->db->select('member.*');
    $this->db->from('member');
    $this->db->join('youth', 'member.youth = youth.no');
    $this->db->where('member.county', $county);
    $this->db->where('youth.source', $sourceHigh);
    //$this->db->like('youth.source', $sourceHigh, 'both');
  
    $this->db->where('member.year', $yearType);
    $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
    $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;
    $this->db->where('member.create_date <', ($addYear + 1911) . '-' . $addMonth .'-1');

    $result = $this->db->get()->num_rows();
    return $result;
  }
}