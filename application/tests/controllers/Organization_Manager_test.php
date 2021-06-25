<?php
/**
 * Organization Manager Test
 *
 * 1. sidebar check
 * 2. create organization contractor account
 * 
 */

class Organization_Manager_test extends TestCase
{

  public function setUp() {
    // initialize instance
    $this->resetInstance();
    // login with organization manager account
    $this->request(
      'POST',
      ['user', 'login'],
      [
        'id' => 'organizationmanager',
        'password' => 'password'
      ]
    );
  }

  public function test_sidebar_check() {
    // check sidebar has yda role's features or not
    $output = $this->request('GET', 'user/index');
    $this->assertContains('建立本機構承辦人帳號', $output);
  }

  public function test_create_organization_contractor_account() {
    // create county contractor account controller test
    $output = $this->request(
      'POST',
      ['user', 'create_organization_contractor_account'],
      [
        'id' => 'org12',
        'password' => '123456789',
        'userName' => 'org12'
      ]
    );
    $this->assertContains('新增成功', $output);
    // check user table has new user row
    $query = $this->CI->db->query("select 1 from users where id = 'org12' 
      and name = 'org12' and manager = 0 and county = 1;");
    $isUserExist = $query->num_rows();
    $this->assertEquals(1, $isUserExist);
    // clear up fake data
    $this->CI->db->query("delete from users where id = 'org12' and name = 'org12' 
      and manager = 0 and county = 1;");
  }
}