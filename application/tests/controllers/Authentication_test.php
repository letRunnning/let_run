<?php
/**
 * Authentication Test
 *
 * 1. permission reject
 * 2. login fail
 * 3. login success
 * 
 */

class Authentication_test extends TestCase
{
  public function test_permission_reject() {
    // If user has not signed in, must be redirect to login page
    $output = $this->request('GET', 'user/index');
    $this->assertRedirect('user/login', 302);
  }

  public function test_login_fail() {
    // Give a error account and must be reject
    $output = $this->request(
      'POST',
      ['user', 'login'],
      [
        'id' => 'yda',
        'password' => '123456789'
      ]
    );
    $this->assertContains('帳號密碼錯誤', $output);
  }

  public function test_login_success() {
    // Give a correct account and must be redirect to index page
    $this->request(
      'POST',
      ['user', 'login'],
      [
        'id' => 'yda',
        'password' => 'password'
      ]
    );
    $this->assertRedirect('user/index', 302);
    $output = $this->request('GET', 'user/index');
    $this->assertContains('登出', $output);
  }

}
