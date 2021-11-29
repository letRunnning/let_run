<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style;

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserModel');
    }

    public function index()
    {
        $passport = $this->session->userdata('passport');
        
        if ($passport) {
        
            $current_role = $passport['role'];
            $userTitle = $passport['userTitle'];
            $id = $passport['id'];
            $members = $this->UserModel->get_member_info();
            
            $beSentDataset = array(
                // 'title' => '首頁',
                'title' => '查看會員個人資訊',
                'url' => '/user/index',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'id' => $id,
                'members' => $members,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            // $this->load->view('dashboard', $beSentDataset);
            $this->load->view('/user/member_info', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function login()
    {
        $passport = $this->session->userdata('passport');
        
        // 檢查登入次數 
        $checkLoign = $this->session->userdata('checkLoign');
        if(empty($checkLoign)) {
          $checkLoign = 0;
          $this->session->set_userdata('checkLoign', $checkLoign);
          $checkLoign = $this->session->userdata('checkLoign');
        }
        $userTitle = '';
        if ($passport) {
            redirect('/');
        }


        // dataset will be sent to frontend
        $beSentDataset = array(
            'title' => '登入',
            'url' => '/user/login',
            'userTitle' => $userTitle,
            'security' => $this->security,
            'password' => null,
            'updatePwd' => null
        );
        // get data from frontend
        $id = $this->security->xss_clean($this->input->post('id'));
        $password = $this->security->xss_clean($this->input->post('password'));

        if (empty($id) || empty($password)) {
            return $this->load->view('/user/login', $beSentDataset);
        }

        // fetch data from model
        $user = $this->UserModel->get_by_id($id);
        // check user exist
        if ($user->num_rows() > 0) {
            // format user
            $user = $user->row_array();
            
            // login failed for three times, lock for 15 minutes
            // if($checkLoign>=3) {
            //   $this->UserModel->update_login_fail_time_by_id($id);
            //   $minutes_to_add = 15;

            //   $time = new DateTime(date("Y-m-d H:i:s"));
            //   $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
            //   $beSentDataset['error'] = '因密碼輸入錯誤三次，下次能登入時間為 ' .$time->format('Y-m-d H:i:s'); 
              
            //   return $this->load->view('/user/login', $beSentDataset);
            // }

            // if($user['login_fail_time']) {
            //   $minutes_to_add = 15;

            //   $time = new DateTime($user['login_fail_time']);
            //   $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
            //   if(date("Y-m-d H:i:s") < $time->format('Y-m-d H:i:s')) {
            //     $beSentDataset['error'] = '因密碼輸入錯誤三次，下次能登入時間為 ' .$time->format('Y-m-d H:i:s'); 
            //     return $this->load->view('/user/login', $beSentDataset);
            //   }
              
            // }

            // verify password
            if (password_verify($password, $user['password'])) {
                $manager = $user['manager'];
                $yda = $user['yda'];
                $county = $user['county'];
                $organization = $user['organization'];
                $counselor = $user['counselor'];
                $youth = $user['youth'];

                // $effectiveDate = $user['update_password_time'];
                // if(empty($effectiveDate)){
                //     $updatePwd = false;
                // }else {
                //     $effectiveDate = date('Y-m-d H:i:s', strtotime("+3 months", strtotime($effectiveDate)));
                //     $updatePwd = date("Y-m-d H:i:s") > $effectiveDate ? true : false;
                // }

                if ($manager == 0) {
                    $role = 6;
                    $userTitle = $user['name'];
                } else {
                    // unexcept authentication
                    $beSentDataset['error'] = '帳號密碼錯誤';
                    // $this->session->unset_userdata('captchaCode');
                    // $this->session->set_userdata('captchaCode', $captcha['word']);
                    $this->load->view('/user/login', $beSentDataset);
                }
                // define session passport
                $passport = array(
                    'id' => $id,
                    'role' => $role,
                    'yda' => $yda,
                    'county' => $county,
                    'organization' => $organization,
                    'counselor' => $counselor,
                    'youth' => $youth,
                    'userTitle' => $userTitle,
                    'security' => $this->security,
                    'password' => $password,
                    'updatePwd' => $updatePwd
                );

                $this->session->set_userdata('passport', $passport);
                redirect('user/index');
            } else {
                $beSentDataset['error'] = '帳號密碼錯誤';
                // $this->session->unset_userdata('captchaCode');
                // $this->session->set_userdata('captchaCode', $captcha['word']);
                $checkLoign ++;
                $this->session->set_userdata('checkLoign', $checkLoign);
                $this->load->view('/user/login', $beSentDataset);
            }
        } else {
            $beSentDataset['error'] = '帳號密碼錯誤';
            // $this->session->unset_userdata('captchaCode');
            // $this->session->set_userdata('captchaCode', $captcha['word']);
            $checkLoign ++;
            $this->session->set_userdata('checkLoign', $checkLoign);
            $this->load->view('/user/login', $beSentDataset);
        }
    }

    public function member_info()
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(6);
        $members = $this->UserModel->get_member_info();
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '查看會員個人資訊',
                'url' => '/user/member_info',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'security' => $this->security,
                'members' => $members,
                'password' => $passport['password']
            );
            $this->load->view('/user/member_info', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    public function staff_info()
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(6);
        $staffs = $this->UserModel->get_staff_info();
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '查看工作人員個人資訊',
                'url' => '/user/staff_info',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'staffs' => $staffs,
                'security' => $this->security,
                'password' => $passport['password']
            );
            $this->load->view('/user/staff_info', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function forget_password()
    {
        $passport = $this->session->userdata('passport');
        $userTitle = '';
        if ($passport) {
            redirect('/');
        }

        // dataset will be sent to frontend
        $beSentDataset = array(
            'title' => '忘記密碼',
            'url' => '/user/forget_password',
            'userTitle' => $userTitle,
            'security' => $this->security,
            // 'captcha' => $captcha,
            'password' => null,
            'updatePwd' => null
        );
        // get data from frontend
        $id = $this->security->xss_clean($this->input->post('id'));
      

        if (empty($id)) {
            return $this->load->view('/user/forget_password', $beSentDataset);
        }

        // fetch data from model
        $user = $this->UserModel->get_by_id($id);
        // check user exist
        if ($user->num_rows() > 0) {
          $user = $user->row();
          $data = array(
            'title' => email_title_reset_password(),
            'email' =>  $user->email,
            'content' => email_content_reset_password($user->name, $id)
          );
          //api_send_email($data);
 
          redirect('user/login');
        } else {
          $beSentDataset['error'] = '帳號密碼錯誤';
          $this->load->view('/user/forget_password', $beSentDataset);
        }
    }
    public function logout()
    {
        $this->session->unset_userdata('passport');
        $this->session->sess_destroy();
        redirect('user/login');
    }
}
