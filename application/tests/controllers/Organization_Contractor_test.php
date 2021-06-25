<?php
/**
 * Organization Contractor Test
 *
 * 1. sidebar check
 * 2. create county contractor account
 * 
 */

class Organization_Contractor_test extends TestCase
{

  public function setUp() {
    // initialize instance
    $this->resetInstance();
    // login with organization contractor account
    $this->request(
      'POST',
      ['user', 'login'],
      [
        'id' => 'organizationcontractor',
        'password' => 'password'
      ]
    );
  }

  public function test_sidebar_check() {
    // check sidebar has yda role's features or not
    $output = $this->request('GET', 'user/index');
    $this->assertContains('建立輔導員帳號', $output);
  }

  public function test_create_counselor_account() {
    // create county contractor account controller test
    $identification = 'N123456000';
    $gender = '132';
    $birth = '1994-03-21';
    $department = 'NCNU';
    $fax = '00xx00';
    $phone = '09009900';
    $email = 'ncnu@gmail.com';
    $householdAddress = 'xx市x區xx路12號';
    $resideAddress = 'xx市x區xx路12號';
    $educationStartDate = '2012-07-01';
    $educationCompleteDate = '2012-09-01';
    $educationSchool = 'NCNU';
    $educationDepartment = 'IM';
    $workStartDate = '2012-07-01';
    $workCompleteDate = '2012-09-01';
    $workDepartment = 'IM';
    $workPosition = 'Programmer';
    $dutyDate = '2012-10-01';
    $qualification = '223,446';
    $output = $this->request(
      'POST',
      ['user', 'create_counselor_account'],
      [
        'id' => 'counselor11',
        'password' => '123456789',
        'userName' => 'counselor11',
        'identification' => $identification,
        'gender' => $gender,
        'birth' => $birth,
        'department' => $department,
        'fax' => $fax,
        'phone' => $phone,
        'email' => $email,
        'householdAddress' => $householdAddress,
        'resideAddress' => $resideAddress,
        'educationStartDate' => $educationStartDate,
        'educationCompleteDate' => $educationCompleteDate,
        'educationSchool' => $educationSchool,
        'educationDepartment' => $educationDepartment,
        'workStartDate' => $workStartDate,
        'workCompleteDate' => $workCompleteDate,
        'workDepartment' => $workDepartment,
        'workPosition' => $workPosition,
        'dutyDate' => $dutyDate,
        'qualification' => explode(",", $qualification)
      ]
    );
    $this->assertContains('新增成功', $output);
    // check user table has new user row
    $query = $this->CI->db->query("select counselor from users where id = 'counselor11' 
      and name = 'counselor11' and manager = 0 and county = 1 and organization = 1;");
    $isUserExist = $query->num_rows();
    $userCounselor = $query->row(0)->counselor;
    $this->assertEquals(1, $isUserExist);
    $query = $this->CI->db->query("select no from counselor where identification = ? 
      and gender = ? and birth = ? and department = ? and fax = ? and phone = ? and email = ? 
      and household_address = ? and reside_address = ? and education_start_date = ? 
      and education_complete_date = ? and education_school = ? and education_department = ? 
      and work_start_date = ? and work_complete_date = ? and work_department = ? and work_position = ? 
      and duty_date = ? and qualification = ?;", 
      array($identification, $gender, $birth, $department, $fax, $phone, $email, $householdAddress,
      $resideAddress, $educationStartDate, $educationCompleteDate, $educationSchool, $educationDepartment,
      $workStartDate, $workCompleteDate, $workDepartment, $workPosition, $dutyDate, $qualification));
    $counselorNo = $query->row(0)->no;
    $this->assertEquals($userCounselor, $counselorNo);
    // clear up fake data
    $this->CI->db->query("delete from users where id = 'counselor11' 
      and name = 'counselor11' and manager = 0 and county = 1 and organization = 1;");
    $this->CI->db->query("delete from counselor where identification = ? 
      and gender = ? and birth = ? and department = ? and fax = ? and phone = ? and email = ? 
      and household_address = ? and reside_address = ? and education_start_date = ? 
      and education_complete_date = ? and education_school = ? and education_department = ? 
      and work_start_date = ? and work_complete_date = ? and work_department = ? and work_position = ? 
      and duty_date = ? and qualification = ?;", 
      array($identification, $gender, $birth, $department, $fax, $phone, $email, $householdAddress,
      $resideAddress, $educationStartDate, $educationCompleteDate, $educationSchool, $educationDepartment,
      $workStartDate, $workCompleteDate, $workDepartment, $workPosition, $dutyDate, $qualification));
  }
}