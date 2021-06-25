<?php
class ProjectModel extends CI_Model {
  /*
   * create one project
   * @Return: Boolean
   */
  function create_one($county, $name, $executeMode, $executeWay, $counselorCount,
  $meetingCount, $counselingMember, $counselingHour, $courseHour, $workingMember, $workingHour, $groupCounselingHour,
  $counselingYouth, $trackDescription, $year, $date, $funding, $note) {

    $this->county = $county;
    $this->name = $name;
    $this->execute_mode = $executeMode;
    $this->execute_way = $executeWay;
    $this->counselor_count = $counselorCount;
    $this->meeting_count = $meetingCount;
    $this->counseling_member = $counselingMember;
    $this->counseling_hour = $counselingHour;
    $this->course_hour = $courseHour;
    $this->working_member = $workingMember;
    $this->working_hour = $workingHour;
    $this->group_counseling_hour = $groupCounselingHour;
    $this->counseling_youth = $counselingYouth;
    $this->track_description = $trackDescription;

    $this->year = $year;
    $this->date = $date;
    $this->funding = $funding;
    $this->note = $note;
    return ($this->db->insert('project', $this)) ? $this->db->insert_id() : false;
  }

  function update_one($county, $name, $executeMode, $executeWay, $counselorCount,
  $meetingCount, $counselingMember, $counselingHour, $courseHour, $workingMember, $workingHour, $groupCounselingHour,
  $counselingYouth, $trackDescription, $year, $date, $no, $funding, $note) {

    $this->county = $county;
    $this->name = $name;
    $this->execute_mode = $executeMode;
    $this->execute_way = $executeWay;
    $this->counselor_count = $counselorCount;
    $this->meeting_count = $meetingCount;
    $this->counseling_member = $counselingMember;
    $this->counseling_hour = $counselingHour;
    $this->course_hour = $courseHour;
    $this->working_member = $workingMember;
    $this->working_hour = $workingHour;
    $this->group_counseling_hour = $groupCounselingHour;
    $this->counseling_youth = $counselingYouth;
    $this->track_description = $trackDescription;
    $this->year = $year;
    $this->date = $date;
    $this->funding = $funding;
    $this->note = $note;
    $this->db->where('no', $no);

    return $this->db->update('project', $this);
  }

  /*
   * get project by county
   * @Return: array of county object
   */
  function get_by_county($county) {
    $this->db->where('county', $county);
    return $this->db->get('project')->result_array();
  }

  function check_is_excit($county) {
    $this->db->where('county_delegate_organization.has_delegation', 1);
    $this->db->where('county_delegate_organization.county', $county);
    return $this->db->get('county_delegate_organization')->num_rows();
  }

   /*
   * get project by county
   * @Return: array of county object
   */
  function get_by_no($no) {
    $this->db->where('no', $no);
    return $this->db->get('project', 1)->row();
  }

  function get_has_delegation_by_member($member) {
    $this->db->select('county_delegate_organization.has_delegation');

    $this->db->join('county_delegate_organization', 'county_delegate_organization.project = member.project');
    $this->db->where('member.no', $member);
    
    return $this->db->get('member', 1)->row();
  }

  /*
   * get project by county
   * @Return: array of county object
   */
  function get_distinct_year_by_county($county) {
    $this->db->select('year');
    $this->db->where('county', $county);
    $this->db->group_by("year");
    return $this->db->get('project')->result_array();
  }

  /*
   * get latest one project by county
   * @Return: array of county object
   */
  function get_latest_by_county($county) {
    $this->db->select('project.*,
      county.name as countyName');
    $this->db->join('county', 'project.county = county.no');
    $this->db->where('project.county', $county);
    $this->db->order_by('no', 'desc');
    $this->db->limit(1);
    return $this->db->get('project')->row();
  }

  /*
   * get project by county_delegate_organization
   * @Return: array of county_delegate_organization object
   */
  function get_county_delegate_organization_by_county($county) {
    $this->db->select('project.no, project.name as projectName, project.year, project.execute_mode, project.execute_way,
      county.name as countyName, 
      organization.name as organizationName, organization.phone, organization.address,
      county_delegate_organization.has_delegation');
    $this->db->join('project', 'county_delegate_organization.project = project.no');
    $this->db->join('county', 'county_delegate_organization.county = county.no');
    $this->db->join('organization', 'county_delegate_organization.organization = organization.no');
    $this->db->where('county_delegate_organization.county', $county);
    return $this->db->get('county_delegate_organization')->result_array();
  }

  /*
   * get project by county_delegate_organization
   * @Return: array of county_delegate_organization object
   */
  function get_county_delegate_organization_by_county_and_year($county, $year) {
    $this->db->select('project.no, project.name as projectName, project.year, project.execute_mode, project.execute_way,
      county.name as countyName, 
      organization.name as organizationName, organization.phone, organization.address,
      county_delegate_organization.has_delegation');
    $this->db->join('project', 'county_delegate_organization.project = project.no');
    $this->db->join('county', 'county_delegate_organization.county = county.no');
    $this->db->join('organization', 'county_delegate_organization.organization = organization.no');
    $this->db->where('county_delegate_organization.county', $county);
    $this->db->where('project.year', $year);
    return $this->db->get('county_delegate_organization')->result_array();
  }

  function get_all_by_county_no($no)
  {
    if($no !='all'){
    $this->db->where('no', $no);
    return $this->db->get('project', 1)->result_array();
    }else{
      $this->db->select('project.*, county.name as countyName');

     $this->db->join('county', 'project.county = county.no');
      return $this->db->get('project')->result_array();
    }
  }

  function get_project_and_organization_by_no($project) {
    $this->db->select('project.*,
      county.name as countyName, 
      organization.name as organizationName, organization.phone, organization.address,
      county_delegate_organization.has_delegation');
    $this->db->join('county_delegate_organization', 'county_delegate_organization.project = project.no');
    $this->db->join('county', 'county_delegate_organization.county = county.no');
    $this->db->join('organization', 'county_delegate_organization.organization = organization.no');
    $this->db->where('project.no', $project);
    return $this->db->get('project')->row();
  }


}