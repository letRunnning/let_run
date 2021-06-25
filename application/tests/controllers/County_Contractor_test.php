<?php
/**
 * County Contractor Test
 *
 * 1. sidebar check
 * 2. create county contractor account
 * 
 */

class County_Contractor_test extends TestCase
{
  private $county = 1;
  private $name = 'project1';
  private $executeMode = '123';
  private $executeWay = '456';
  private $counselingMember = '10';
  private $counselingHour = '60';
  private $courseHour = '100';
  private $workingMember = '10';
  private $date = '2020-08-04';
  private $organizationName = 'org1';
  private $phone = '09xxxxxxxx';
  private $address = 'taiwan';

  public function setUp() {
    // initialize instance
    $this->resetInstance();
    // login with county contractor account
    $this->request(
      'POST',
      ['user', 'login'],
      [
        'id' => 'countycontractor',
        'password' => 'password'
      ]
    );
  }

  public function test_sidebar_check() {
    // check sidebar has yda role's features or not
    $output = $this->request('GET', 'user/index');
    $this->assertContains('開設計畫案', $output);
    $this->assertContains('新增計畫執行機構', $output);
    $this->assertContains('委託計畫執行機構', $output);
    $this->assertContains('建立機構主管帳號', $output);
    $this->assertContains('建立機構承辦人帳號', $output);
  }

  public function test_create_project() {
    // create project controller test
    // define input
    $output = $this->request(
      'POST',
      ['project', 'create_project'],
      [
        'name' => $this->name,
        'executeMode' => $this->executeMode,
        'executeWay' => $this->executeWay,
        'counselingMember' => $this->counselingMember,
        'counselingHour' => $this->counselingHour,
        'courseHour' => $this->courseHour,
        'workingMember' => $this->workingMember,
        'date' => $this->date
      ]
    );
    $this->assertContains('新增成功', $output);
    // check user table has new user row
    $query = $this->CI->db->query("select 1 from project where county = ? and name = ? and execute_mode = ? 
      and execute_way = ? and counseling_member = ? and counseling_hour = ? and course_hour = ?
      and working_member = ? and date = ?;", array($this->county, $this->name, $this->executeMode, 
      $this->executeWay, $this->counselingMember, $this->counselingHour, 
      $this->courseHour, $this->workingMember, $this->date));
    $isProjectExist = $query->num_rows();
    $this->assertEquals(1, $isProjectExist);
  }

  public function test_create_organization() {
    // create organization controller test
    $output = $this->request(
      'POST',
      ['organization', 'create_organization'],
      [
        'name' => $this->organizationName,
        'phone' => $this->phone,
        'address' => $this->address
      ]
    );
    $this->assertContains('新增成功', $output);
    // check user table has new user row
    $query = $this->CI->db->query("select 1 from organization where county = ? and name = ? and phone = ? 
      and address = ?;", array($this->county, $this->organizationName, $this->phone, $this->address));
    $isOrganizationExist = $query->num_rows();
    $this->assertEquals(1, $isOrganizationExist);
  }

  public function test_delegate_project_to_organization() {
    // create organization controller test
    $query = $this->CI->db->query("select no from project where name = ?
      and execute_mode = ?;", array($this->name, $this->executeMode));
    $project = $query->row(0)->no;
    $query = $this->CI->db->query("select no from organization where name = ? 
      and address = ?;", array($this->organizationName, $this->address));
    $organization = $query->row(0)->no;
    $output = $this->request(
      'POST',
      ['county', 'delegate_project_to_organization'],
      [
        'project' => $project,
        'organization' => $organization
      ]
    );
    $this->assertContains('新增成功', $output);
    // check if duplicated relation trigger alert message
    $output = $this->request(
      'POST',
      ['county', 'delegate_project_to_organization'],
      [
        'project' => $project,
        'organization' => $organization
      ]
    );
    $this->assertContains('已經存在委任關係了', $output);
    // check user table has new user row
    $query = $this->CI->db->query("select 1 from county_delegate_organization where county = ? 
      and project = ? and organization = ?;", array($this->county, $project, $organization));
    $isRelationExist = $query->num_rows();
    $this->assertEquals(1, $isRelationExist);
  }

  public function test_create_organization_manager_account() {
    // create organization manager account controller test
    $query = $this->CI->db->query("select no from organization where name = ? 
      and address = ?;", array($this->organizationName, $this->address));
    $organization = $query->row(0)->no;
    $output = $this->request(
      'POST',
      ['user', 'create_organization_manager_account'],
      [
        'id' => 'org11',
        'password' => '123456789',
        'userName' => 'org11',
        'organization' => $organization
      ]
    );
    $this->assertContains('新增成功', $output);
    // check user table has new user row
    $query = $this->CI->db->query("select 1 from users where id = 'org11' and name = 'org11' 
      and manager = 1 and county = ? and organization = ?;", array($this->county, $organization));
    $isUserExist = $query->num_rows();
    $this->assertEquals(1, $isUserExist);
    // if organization doesn't has relation with county then trigger alert message
    $output = $this->request(
      'POST',
      ['organization', 'create_organization'],
      [
        'name' => 'org12',
        'phone' => 'xxx',
        'address' => 'xxx'
      ]
    );
    $query = $this->CI->db->query("select no from organization where name = 'org12' and phone = 'xxx' 
    and address = 'xxx';");
    $notDelegationOrganizationNo = $query->row(0)->no;
    $output = $this->request(
      'POST',
      ['user', 'create_organization_manager_account'],
      [
        'id' => 'org12',
        'password' => '123456789',
        'userName' => 'org12',
        'organization' => $notDelegationOrganizationNo
      ]
    );
    $this->assertContains('本縣市尚未與此機構建立委任關係，請先設定委任關係', $output);
    // clear up fake data
    $this->CI->db->query("delete from users where id = 'org11' and name = 'org11' 
      and manager = 1 and county = ? and organization = ?;", array($this->county, $organization));
  }

  public function test_create_organization_contractor_account() {
    // create organization contractor account controller test
    $query = $this->CI->db->query("select no from organization where name = 'org1' and address = 'taiwan';");
    $organization = $query->row(0)->no;
    $output = $this->request(
      'POST',
      ['user', 'create_organization_contractor_account'],
      [
        'id' => 'org12',
        'password' => '123456789',
        'userName' => 'org12',
        'organization' => $organization
      ]
    );
    $this->assertContains('新增成功', $output);
    // check user table has new user row
    $query = $this->CI->db->query("select 1 from users where id = 'org12' and name = 'org12' 
      and manager = 0 and county = ? and organization = ?;", array($this->county, $organization));
    $isUserExist = $query->num_rows();
    $this->assertEquals(1, $isUserExist);
    // if organization doesn't has relation with county then trigger alert message
    $query = $this->CI->db->query("select no from organization where name = 'org12' and phone = 'xxx' 
    and address = 'xxx';");
    $notDelegationOrganizationNo = $query->row(0)->no;
    $output = $this->request(
      'POST',
      ['user', 'create_organization_contractor_account'],
      [
        'id' => 'org13',
        'password' => '123456789',
        'userName' => 'org13',
        'organization' => $notDelegationOrganizationNo
      ]
    );
    $this->assertContains('本縣市尚未與此機構建立委任關係，請先設定委任關係', $output);
    // clear up fake data
    $this->CI->db->query("delete from users where id = 'org12' and name = 'org12' 
      and manager = 0 and county = ? and organization = ?;", array($this->county, $organization));
    $this->CI->db->query("delete from organization where no = ?;", array($notDelegationOrganizationNo));
  }

  public function test_clear_setup_fake_data() {
    // clear up fake data generated by setup function
    $query = $this->CI->db->query("select no from project where county = ? and name = ? and execute_mode = ? 
      and execute_way = ? and counseling_member = ? and counseling_hour = ? and course_hour = ?
      and working_member = ? and date = ?;", array($this->county, $this->name, $this->executeMode, 
      $this->executeWay, $this->counselingMember, $this->counselingHour, $this->courseHour, 
      $this->workingMember, $this->date));
    $project = $query->row(0)->no;
    $query = $this->CI->db->query("select no from organization where county = ? and name = ? and phone = ? 
    and address = ?;", array($this->county, $this->organizationName, $this->phone, $this->address));
    $organization = $query->row(0)->no;
    // clear county contractor account
    // clear project
    $this->CI->db->query("delete from project where no = ?;", array($project));
    // clear organization
    $this->CI->db->query("delete from organization where no = ?;", array($organization));
    // clear relation between project and organization
    $this->CI->db->query("delete from county_delegate_organization where county = ? 
      and project = ? and organization = ?;", array($this->county, $project, $organization));
    // check fake data cleared
    $query = $this->CI->db->query("select 1 from project where no = ?;", array($project));
    $isProjectExist = $query->num_rows();
    $this->assertEquals(0, $isProjectExist);
    $query = $this->CI->db->query("select 1 from organization where no = ?;", array($organization));
    $isOrganizationExist = $query->num_rows();
    $this->assertEquals(0, $isOrganizationExist);
    $query = $this->CI->db->query("select 1 from county_delegate_organization where county = ? 
      and project = ? and organization = ?;", array($this->county, $project, $organization));
    $isRelationExist = $query->num_rows();
    $this->assertEquals(0, $isRelationExist);
  }
}