<?php
/**
 * Counselor Test
 *
 * 1. sidebar check
 * 2. create organization contractor account
 * 
 */

class Counselor_test extends TestCase
{

  public function setUp() {
    // initialize instance
    $this->resetInstance();
    // login with organization manager account
    $this->request(
      'POST',
      ['user', 'login'],
      [
        'id' => 'counselor',
        'password' => 'password'
      ]
    );
  }

  public function test_sidebar_check() {
    // check sidebar has yda role's features or not
    $output = $this->request('GET', 'user/index');
    $this->assertContains('青少年初評表', $output);
    $this->assertContains('青少年列表', $output);
    $this->assertContains('學員列表', $output);
    $this->assertContains('團體輔導紀錄表', $output);
    $this->assertContains('課程參考清單', $output);
  }

  public function test_get_youth_table() {
    // check youth table has fake data
    $output = $this->request('GET', '/youth/get_all_youth_table');
    $this->assertContains('N123456789', $output);
    $this->assertContains('GJim Tsai', $output);
    $this->assertContains('基本資料', $output);
    $this->assertContains('青少年初評表', $output);
    $this->assertContains('季追蹤歷史', $output);
  }

  public function test_get_personal_data() {
    // check youth table has fake data
    $output = $this->request('GET', '/youth/personal_data/1');
    $this->assertContains('N123456789', $output);
    $this->assertContains('GJim Tsai', $output);
    $this->assertContains('0900000000', $output);
    $this->assertContains('青少年初評表', $output);
    $this->assertContains('季追蹤歷史', $output);
  }

  // public function test_create_intake() {
  //   // create county contractor account controller test
  //   $output = $this->request(
  //     'POST',
  //     ['user', 'create_organization_contractor_account'],
  //     [
  //       'id' => 'org12',
  //       'password' => '123456789',
  //       'userName' => 'org12'
  //     ]
  //   );
  //   $this->assertContains('新增成功', $output);
  //   // check user table has new user row
  //   $query = $this->CI->db->query("select 1 from users where id = 'org12' 
  //     and name = 'org12' and manager = 0 and county = 1;");
  //   $isUserExist = $query->num_rows();
  //   $this->assertEquals(1, $isUserExist);
  //   // clear up fake data
  //   $this->CI->db->query("delete from users where id = 'org12' and name = 'org12' 
  //     and manager = 0 and county = 1;");
  // }

  public function test_clear_setup_fake_data() {

  }
}