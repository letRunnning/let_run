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
        $this->load->model('UserTempModel');
        $this->load->model('YdaModel');
        $this->load->model('CountyModel');
        $this->load->model('OrganizationModel');
        $this->load->model('CounselorModel');
        $this->load->model('MenuModel');
        $this->load->model('ReportModel');
        $this->load->model('ReviewModel');
        $this->load->model('CountyModel');
        $this->load->model('MessagerModel');
        $this->load->model('ProjectModel');
        $this->load->model('CountyContactModel');
        $this->load->model('SchoolModel');
        $this->load->model('DblogModel');
        $this->load->model('AuditModel');
    }

    public function tt(){
      $this->load->view('/templates/new_test');
    }

    public function index()
    {
        $passport = $this->session->userdata('passport');
        
        if ($passport) {
        
            $current_role = $passport['role'];
            $userTitle = $passport['userTitle'];
            $id = $passport['id'];
            
            $statisticsData =$passport['county'] ? $this->ReportModel->get_statistics_card_county(date("Y")-1911, $passport['county']) : $this->ReportModel->get_statistics_card();
            $countyData = $this->CountyModel->get_all();
            $countyContacts = $this->CountyContactModel->get_all();
            $counties = $this->CountyModel->get_all();
            $messagers = $this->MessagerModel->get_show();
            $types = $this->MenuModel->get_by_form_and_column('messager', 'type');
            $beSentDataset = array(
                'title' => '首頁',
                'url' => '/user/index',
                'role' => $current_role,
                'statisticsData' => $statisticsData,
                'countyData' => $countyData,
                'userTitle' => $userTitle,
                'messagers' => $messagers,
                'types' => $types,
                'id' => $id,
                'countyContacts' => $countyContacts,
                'counties' => $counties,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $this->load->view('dashboard', $beSentDataset);
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
            if($checkLoign>=3) {
              $this->UserModel->update_login_fail_time_by_id($id);
              $minutes_to_add = 15;

              $time = new DateTime(date("Y-m-d H:i:s"));
              $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
              $beSentDataset['error'] = '因密碼輸入錯誤三次，下次能登入時間為 ' .$time->format('Y-m-d H:i:s'); 
              
              return $this->load->view('/user/login', $beSentDataset);
            }

            if($user['login_fail_time']) {
              $minutes_to_add = 15;

              $time = new DateTime($user['login_fail_time']);
              $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
              if(date("Y-m-d H:i:s") < $time->format('Y-m-d H:i:s')) {
                $beSentDataset['error'] = '因密碼輸入錯誤三次，下次能登入時間為 ' .$time->format('Y-m-d H:i:s'); 
                return $this->load->view('/user/login', $beSentDataset);
              }
              
            }

            // verify password
            if (password_verify($password, $user['password'])) {
                $manager = $user['manager'];
                $yda = $user['yda'];
                $county = $user['county'];
                $organization = $user['organization'];
                $counselor = $user['counselor'];
                $youth = $user['youth'];

                $effectiveDate = $user['update_password_time'];
                if(empty($effectiveDate)){
                    $updatePwd = false;
                }else {
                    $effectiveDate = date('Y-m-d H:i:s', strtotime("+3 months", strtotime($effectiveDate)));
                    $updatePwd = date("Y-m-d H:i:s") > $effectiveDate ? true : false;
                }

                /**
                 * Passport data structure define
                 * (isManager, ydaNo, countyNo, organizationNo, counselorNo, youthNo)
                 * System role define
                 * 1. Youth Development Administration contractor (1, 11, null, null, null, null)
                 * 2. county administration manager (1, null, 12, null, null, null)
                 * 3. county administration contractor (0, null, 12, null, null, null)
                 * 4. organization manager (1, null, 12, 13, null, null)
                 * 5. organization contractor (0, null, 12, 13, null, null)
                 * 6. counselor (0, null, 12, 13, 14, null)
                 * 7. youth (0, null, null, null, null, 15)
                 */

                // define role
                if (!empty($yda) && $manager == 1) {
                    $role = 1;
                    $userTitle = '教育部青年發展署';
                } elseif ($manager == 1 && !empty($county) && empty($organization) && empty($counselor)) {
                    $role = 2;
                    $userTitle = $this->CountyModel->get_by_no($county)->name . '-' . $user['name'];
                } elseif ($manager == 0 && !empty($county) && empty($organization) && empty($counselor)) {
                    $role = 3;
                    $userTitle = $this->CountyModel->get_by_no($county)->name . '-' . $user['name'];
                } elseif ($manager == 1 && !empty($county) && !empty($organization) && empty($counselor)) {
                    $role = 4;
                    $userTitle = $this->OrganizationModel->get_by_no($organization)->name . '-' . $user['name'];
                } elseif ($manager == 0 && !empty($county) && !empty($organization) && empty($counselor)) {
                    $role = 5;
                    $userTitle = $this->OrganizationModel->get_by_no($organization)->name . '-' . $user['name'];
                } elseif (!empty($counselor)) {
                    $role = 6;
                    $userTitle = $user['name'];
                } elseif (!empty($youth)) {
                    $role = 7;
                } elseif (!empty($yda) && $manager == 0) {
                    $role = 8;
                    $userTitle = '支援計畫人員';
                } elseif (!empty($yda) && $manager == 2) {
                  $role = 9;
                  $userTitle = '青年署主管';
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

    public function forget_password()
    {
        $passport = $this->session->userdata('passport');
        $userTitle = '';
        if ($passport) {
            redirect('/');
        }

        // $this->load->helper('captcha');
        // $config = array(
        //     'img_path' => 'files/captcha/',
        //     'img_url' => base_url() . 'files/captcha/',
        //     'font_path' => FCPATH . 'assets/font/Roboto-Regular.ttf',
        //     'font_size' => 26,
        //     'word_length' => 4,
        //     'img_width' => 250,
        //     'img_height' => 40,
        // );

        // $captcha = create_captcha($config);
        // $captchaCode = $this->session->userdata('captchaCode');

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
      
        // $captchas = $this->security->xss_clean($this->input->post('captcha'));

        if (empty($id)) {
            // $this->session->unset_userdata('captchaCode');
            // $this->session->set_userdata('captchaCode', $captcha['word']);
            return $this->load->view('/user/forget_password', $beSentDataset);
        }

        // if ($captchas != $captchaCode) {
        //     $beSentDataset['error'] = '帳號密碼錯誤';
        //     $this->session->unset_userdata('captchaCode');
        //     $this->session->set_userdata('captchaCode', $captcha['word']);
        //     return $this->load->view('/user/forget_password', $beSentDataset);
        // }
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
        //   $this->session->unset_userdata('captchaCode');
        //   $this->session->set_userdata('captchaCode', $captcha['word']);
          $this->load->view('/user/forget_password', $beSentDataset);
        }
    }

    public function forget_password_mail($id = null) {
      
      if($id) {
        $password = '000000';
        $user = $this->UserModel->get_by_id($id);
        $isExecuteSuccess = $this->UserModel->update_password($id, $password, $users['password'], $users['last_password_one'], $users['last_password_two']);
        if($isExecuteSuccess) {
          $user = $this->UserModel->get_by_id($id);
          // check user exist
          if ($user->num_rows() > 0) {
              // format user
              $user = $user->row_array();
              $manager = $user['manager'];
              $yda = $user['yda'];
              $county = $user['county'];
              $organization = $user['organization'];
              $counselor = $user['counselor'];
              $youth = $user['youth'];

              // define role
              if (!empty($yda) && $manager == 1) {
                  $role = 1;
                  $userTitle = '教育部青年發展署';
              } elseif ($manager == 1 && !empty($county) && empty($organization) && empty($counselor)) {
                  $role = 2;
                  $userTitle = $this->CountyModel->get_by_no($county)->name . '-' . $user['name'];
              } elseif ($manager == 0 && !empty($county) && empty($organization) && empty($counselor)) {
                  $role = 3;
                  $userTitle = $this->CountyModel->get_by_no($county)->name . '-' . $user['name'];
              } elseif ($manager == 1 && !empty($county) && !empty($organization) && empty($counselor)) {
                  $role = 4;
                  $userTitle = $this->OrganizationModel->get_by_no($organization)->name . '-' . $user['name'];
              } elseif ($manager == 0 && !empty($county) && !empty($organization) && empty($counselor)) {
                  $role = 5;
                  $userTitle = $this->OrganizationModel->get_by_no($organization)->name . '-' . $user['name'];
              } elseif (!empty($counselor)) {
                  $role = 6;
                  $userTitle = $user['name'];
              } elseif (!empty($youth)) {
                  $role = 7;
              } elseif (!empty($yda) && $manager == 0) {
                  $role = 8;
                  $userTitle = '支援計畫人員';
              } else {
                  // unexcept authentication
                  $beSentDataset['error'] = '系統錯誤';
                //   $this->session->unset_userdata('captchaCode');
                //   $this->session->set_userdata('captchaCode', $captcha['word']);
                  //$this->load->view('/user/login', $beSentDataset);
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
                  'updatePwd' => $passport['updatePwd']
              );
              $this->session->unset_userdata('passport');
              $this->session->set_userdata('passport', $passport);
              redirect('user/login');          
          } else {
              $beSentDataset['error'] = '帳號密碼錯誤';
            //   $this->session->unset_userdata('captchaCode');
            //   $this->session->set_userdata('captchaCode', $captcha['word']);
              $this->load->view('/user/login', $beSentDataset);
          }
        }
      }
    }

    public function logout()
    {
        $this->session->unset_userdata('passport');
        $this->session->sess_destroy();
        redirect('user/login');
    }

    public function create_yda_account()
    {
        $passport = $this->session->userdata('passport');
        $current_role = $this->session->userdata('passport')['role'];
        $userTitle = $this->session->userdata('passport')['userTitle'];
        $accept_role = array(1, 9);
        valid_roles($accept_role);
        $beSentDataset = array(
            'title' => '建立青年署專員帳號',
            'url' => '/user/create_yda_account',
            'role' => $current_role,
            'kind' => 'yda',
            'userTitle' => $userTitle,
            'security' => $this->security,
            'users' => null,
            'roleInfo' => null,
            'countyType' => null,
            'latestId' => null,
            'accountPrefix' => null,
            'password' => $passport['password'],
            'updatePwd' => $passport['updatePwd']
        );

        $passwordVerify = $this->security->xss_clean($this->input->post('passwordVerify'));
        $usersData = [];
        $ydaData = [];
        $usersColumns = $this->UserModel->get_edited_columns_metadata();
        $ydaColumns = $this->YdaModel->get_edited_columns_metadata();
        foreach ($usersColumns as $column) {
            $columnName = $column->column_name;
            $checker = 'trim|htmlspecialchars|xss_clean';
            $this->form_validation->set_rules($columnName, $column->column_comment, $checker);
        }
        foreach ($ydaColumns as $column) {
            $columnName = $column->column_name;
            $checker = 'trim|htmlspecialchars|xss_clean';
            $this->form_validation->set_rules($columnName, $column->column_comment, $checker);
        }
        if ($this->form_validation->run() != false) {
            foreach ($usersColumns as $column) {
                $columnName = $column->column_name;
                $usersData[$columnName] = $this->input->post($columnName);
            }
            foreach ($ydaColumns as $column) {
                $columnName = $column->column_name;
                $ydaData[$columnName] = $this->input->post($columnName);
            }
            $isIdExist = $this->UserModel->is_id_exist($usersData['id']);
            if ($isIdExist) {
                $beSentDataset['error'] = '帳號已經存在';
            } else {
                if (preg_match("/[0-9]+/", $usersData['password'])) {
                    if ($usersData['password'] == $passwordVerify) {
                        $ydaNo = $this->YdaModel->create_one($ydaData);
                        $usersData['manager'] = 1;
                        $usersData['usable'] = 1;
                        $usersData['password'] = password_hash($usersData['password'], PASSWORD_DEFAULT);
                        if ($ydaNo) {
                            $usersData['yda'] = $ydaNo;
                            $isUserExecuteSuccess = $this->UserModel->create_one($usersData);
                            if ($isUserExecuteSuccess) {
                                $beSentDataset['success'] = '新增成功';
                            } else {
                                $beSentDataset['error'] = '新增失敗';
                            }
                        } else {
                            $beSentDataset['error'] = '新增失敗';
                        }
                    } else {
                        $beSentDataset['error'] = '密碼兩者不相同';
                    }
                } else {
                    $beSentDataset['error'] = '密碼需包含英文字母大寫、英文字母小寫與數字並長度大於8';
                }
            }
        }
        $this->load->view('/user/create_account', $beSentDataset);
    }

    public function create_yda_support_account()
    {
        $passport = $this->session->userdata('passport');
        $current_role = $this->session->userdata('passport')['role'];
        $userTitle = $this->session->userdata('passport')['userTitle'];
        $accept_role = array(1, 9);
        valid_roles($accept_role);

        $latestId = $this->UserModel->get_latest_yda_support() ? $this->UserModel->get_latest_yda_support()->id : '尚無前一組帳號';
        $accountPrefix = 'teenager-yda0';

        $beSentDataset = array(
            'title' => '建立支援計畫人員帳號',
            'url' => '/user/create_yda_support_account',
            'role' => $current_role,
            'kind' => 'support',
            'userTitle' => $userTitle,
            'security' => $this->security,
            'users' => null,
            'roleInfo' => null,
            'countyType' => null,
            'latestId' => $latestId,
            'accountPrefix' => $accountPrefix,
            'password' => $passport['password'],
            'updatePwd' => $passport['updatePwd']
        );

        $passwordVerify = $this->security->xss_clean($this->input->post('passwordVerify'));
        $usersData = [];
        $ydaData = [];
        $usersColumns = $this->UserModel->get_edited_columns_metadata();
        $ydaColumns = $this->YdaModel->get_edited_columns_metadata();
        foreach ($usersColumns as $column) {
            $columnName = $column->column_name;
            $checker = 'trim|htmlspecialchars|xss_clean';
            $this->form_validation->set_rules($columnName, $column->column_comment, $checker);
        }
        foreach ($ydaColumns as $column) {
            $columnName = $column->column_name;
            $checker = 'trim|htmlspecialchars|xss_clean';
            $this->form_validation->set_rules($columnName, $column->column_comment, $checker);
        }
        if ($this->form_validation->run() != false) {
            foreach ($usersColumns as $column) {
                $columnName = $column->column_name;
                $usersData[$columnName] = $this->input->post($columnName);
            }
            foreach ($ydaColumns as $column) {
                $columnName = $column->column_name;
                $ydaData[$columnName] = $this->input->post($columnName);
            }
            $isIdExist = $this->UserModel->is_id_exist($usersData['id']);
            if ($isIdExist) {
                $beSentDataset['error'] = '帳號已經存在';
            } else {
                if (preg_match("/[0-9]+/", $usersData['password'])) {
                    if ($usersData['password'] == $passwordVerify) {
                        $ydaNo = $this->YdaModel->create_one($ydaData);
                        $usersData['manager'] = 0;
                        $usersData['usable'] = 1;
                        $usersData['password'] = password_hash($usersData['password'], PASSWORD_DEFAULT);
                        if ($ydaNo) {
                            $usersData['yda'] = $ydaNo;
                            $isUserExecuteSuccess = $this->UserModel->create_one($usersData);
                            if ($isUserExecuteSuccess) {
                                $ydaManager = $this->UserModel->get_by_yda_row();

                                $recipient = $ydaManager->email;
                                $title = '【教育部青年發展署雙青計畫行政系統】新增「支援計畫人員」帳號通知';
                                $content = '<p>' . $ydaManager->name . ' 君 您好:</p>'
                                . '<p>教育部青年發展署新增了一位「支援計畫人員」</p>'
                                . '<p>帳號為 :' . $usersData['id'] . '</p>'
                                . '<p>姓名為 :' . $usersData['name'] . '</p>'
                                . '<p>祝 平安快樂</p><p></p>'
                                . '<p>教育部青年發展署雙青計畫行政系統</p>'
                                . '<p>' . date('Y-m-d') . '</p>'
                                    . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                                //api_send_email_temp($recipient, $title, $content);

                                $recipientUser = $usersData['email'];
                                $titleUser = '【教育部青年發展署雙青計畫行政系統】「支援計畫人員」帳號建立成功通知';
                                $contentUser = '<p>' . $usersData['name'] . ' 君 您好:</p>'
                                . '<p>教育部青年發展署新增了一位「支援計畫人員」</p>'
                                . '<p>帳號為 :' . $usersData['id'] . '</p>'
                                . '<p>密碼為 : 000000 </p>'
                                . '<p>登入後請先更改密碼，並留意須遵守設定限制。</p>'
                                . '<p>祝 平安快樂</p><p></p>'
                                . '<p>教育部青年發展署雙青計畫行政系統</p>'
                                . '<p>' . date('Y-m-d') . '</p>'
                                    . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                                //api_send_email_temp($recipientUser, $titleUser, $contentUser);
                                $beSentDataset['success'] = '建立帳號成功';
                            } else {
                                $beSentDataset['error'] = '新增失敗';
                            }
                        } else {
                            $beSentDataset['error'] = '新增失敗';
                        }
                    } else {
                        $beSentDataset['error'] = '密碼兩者不相同';
                    }
                } else {
                    $beSentDataset['error'] = '密碼需包含英文字母大寫、英文字母小寫與數字並長度大於8';
                }
            }
        }
        $this->load->view('/user/create_account', $beSentDataset);
    }

    public function create_county_manager_account($countyType = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $this->session->userdata('passport')['userTitle'];
        $current_role = $passport['role'];
        $county = $passport['county'];
        $accept_role = array(1, 9);
        valid_roles($accept_role);
        $counties = $this->CountyModel->get_all();

        $countyNumber = '?';
        $latestId = '';

        if ($county) {
            $countyNumber = strtolower($this->CountyModel->get_code_by_no($county)->code);
        }

        if ($countyType) {
            $countyNumber = strtolower($this->CountyModel->get_code_by_no($countyType)->code);
            $latestId = $this->UserModel->get_latest_county_manager($countyType) ? $this->UserModel->get_latest_county_manager($countyType)->id : '尚無前一組帳號';
        }

        $accountPrefix = 'teenager-' . $countyNumber . '1';
        #$countyNumber = $this->CountyModel->get_by_no
        $beSentDataset = array(
            'title' => '建立縣市主管帳號',
            'url' => '/user/create_county_manager_account',
            'role' => $current_role,
            'kind' => 'county_manager',
            'counties' => $counties,
            'userTitle' => $userTitle,
            'security' => $this->security,
            'users' => null,
            'roleInfo' => null,
            'accountPrefix' => $accountPrefix,
            'countyType' => $countyType,
            'latestId' => $latestId,
            'password' => $passport['password'],
            'updatePwd' => $passport['updatePwd']
        );

        $passwordVerify = $this->security->xss_clean($this->input->post('passwordVerify'));
        $usersData = [];
        $usersColumns = $this->UserModel->get_edited_columns_metadata();
        foreach ($usersColumns as $column) {
            $columnName = $column->column_name;
            $checker = 'trim|htmlspecialchars|xss_clean';
            $this->form_validation->set_rules($columnName, $column->column_comment, $checker);
        }
        if ($this->form_validation->run() != false) {
            foreach ($usersColumns as $column) {
                $columnName = $column->column_name;
                $usersData[$columnName] = $this->input->post($columnName);
            }
            if ($current_role == 1) {
                $usersData['county'] = $countyType;
            }
            if ($usersData['county']) {
                $isIdExist = $this->UserModel->is_id_exist($usersData['id']);
                if ($isIdExist) {
                    $beSentDataset['error'] = '帳號已經存在';
                } else {
                    $isCountyManagerExist = $this->UserModel->is_county_manager_exist($usersData['county']);
                    if ($isCountyManagerExist) {
                        $beSentDataset['error'] = '已有一組縣市主管帳號存在';
                    } else {
                        if (preg_match("/[0-9]+/", $usersData['password'])) {
                            if ($usersData['password'] == $passwordVerify) {
                                $usersData['manager'] = 1;
                                $usersData['usable'] = 1;
                                $usersData['password'] = password_hash($usersData['password'], PASSWORD_DEFAULT);
                                $isUserExecuteSuccess = $this->UserModel->create_one($usersData);
                                if ($isUserExecuteSuccess) {
                                    $ydaManager = $this->UserModel->get_by_yda_row();
                                    $countyName = $this->CountyModel->get_code_by_no($usersData['county'])->name;

                                    $recipient = $ydaManager->email;
                                    $title = '【教育部青年發展署雙青計畫行政系統】新增「' . $countyName . '主管」帳號通知';
                                    $content = '<p>' . $ydaManager->name . ' 君 您好:</p>'
                                    . '<p>' . $countyName . '新增了一位「縣市主管」</p>'
                                    . '<p>帳號為 :' . $usersData['id'] . '</p>'
                                    . '<p>姓名為 :' . $usersData['name'] . '</p>'
                                    . '<p>祝 平安快樂</p><p></p>'
                                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                                    . '<p>' . date('Y-m-d') . '</p>'
                                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                                    //api_send_email_temp($recipient, $title, $content);

                                    $recipientUser = $usersData['email'];
                                    $titleUser = '【教育部青年發展署雙青計畫行政系統】「縣市主管」帳號建立成功通知';
                                    $contentUser = '<p>' . $usersData['name'] . ' 君 您好:</p>'
                                    . '<p>教育部青年發展署新增了一位「縣市主管」</p>'
                                    . '<p>帳號為 :' . $usersData['id'] . '</p>'
                                    . '<p>密碼為 : 000000 </p>'
                                    . '<p>登入後請先更改密碼，並留意須遵守設定限制。</p>'
                                    . '<p>祝 平安快樂</p><p></p>'
                                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                                    . '<p>' . date('Y-m-d') . '</p>'
                                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                                    //api_send_email_temp($recipientUser, $titleUser, $contentUser);
                                    $beSentDataset['success'] = '建立帳號成功';
                                } else {
                                    $beSentDataset['error'] = '新增失敗';
                                }
                            } else {
                                $beSentDataset['error'] = '密碼兩者不相同';
                            }
                        } else {
                            $beSentDataset['error'] = '密碼需包含英文字母大寫、英文字母小寫與數字並長度大於8';
                        }
                    }
                }
            } else {
                $beSentDataset['error'] = '請先新增縣市';
            }
        }
        $this->load->view('/user/create_account', $beSentDataset);
    }

    public function create_county_contractor_account($countyType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $county = $passport['county'] ? $passport['county'] : $countyType;
        $accept_role = array(1, 2, 9);
        valid_roles($accept_role);
        $counties = $this->CountyModel->get_all();

        $statusWaiting = $this->MenuModel->get_no_resource_by_content('等待批准中', 'review')->no;
        $countyNumber = '?';
        $latestId = '';

        if ($county) {
            $countyNumber = strtolower($this->CountyModel->get_code_by_no($county)->code);
            $latestId = $this->UserModel->get_latest_county_contractor($county) ? $this->UserModel->get_latest_county_contractor($county)->id : '尚無前一組帳號';
        }

        if ($countyType) {
            $countyNumber = strtolower($this->CountyModel->get_code_by_no($countyType)->code);
            $latestId = $this->UserModel->get_latest_county_contractor($countyType) ? $this->UserModel->get_latest_county_contractor($countyType)->id : '尚無前一組帳號';
        }

        $accountPrefix = 'teenager-' . $countyNumber . '2';

        $beSentDataset = array(
            'title' => '建立縣市承辦人帳號',
            'url' => '/user/create_county_contractor_account',
            'role' => $current_role,
            'kind' => 'county_contractor',
            'userTitle' => $userTitle,
            'security' => $this->security,
            'users' => null,
            'roleInfo' => null,
            'accountPrefix' => $accountPrefix,
            'countyType' => $countyType,
            'latestId' => $latestId,
            'password' => $passport['password'],
            'updatePwd' => $passport['updatePwd']
        );
        if ($current_role === 1) {
            $counties = $this->CountyModel->get_all();
            $beSentDataset['counties'] = $counties;
        }

        $passwordVerify = $this->security->xss_clean($this->input->post('passwordVerify'));
        $usersData = [];
        $usersColumns = $this->UserModel->get_edited_columns_metadata();
        foreach ($usersColumns as $column) {
            $columnName = $column->column_name;
            $checker = 'trim|htmlspecialchars|xss_clean';
            $this->form_validation->set_rules($columnName, $column->column_comment, $checker);
        }
        if ($this->form_validation->run() != false) {
            foreach ($usersColumns as $column) {
                $columnName = $column->column_name;
                $usersData[$columnName] = $this->input->post($columnName);
            }
            $usersData['county'] = $passport['county'] ? $passport['county'] : $countyType;
            if ($usersData['county']) {
                $isIdExist = $this->UserModel->is_id_exist($usersData['id']);
                if ($isIdExist) {
                    $beSentDataset['error'] = '帳號已經存在';
                } else {
                    $isCountyContractorExist = $this->UserModel->is_county_contractor_exist($usersData['county']);
                    if ($isCountyContractorExist) {
                        $beSentDataset['error'] = '已有一組縣市承辦人帳號存在';
                    } else {
                        if (preg_match("/[0-9]+/", $usersData['password'])) {
                            if ($usersData['password'] == $passwordVerify) {
                                $usersData['manager'] = 0;
                                $usersData['usable'] = 1;
                                $usersData['password'] = password_hash($usersData['password'], PASSWORD_DEFAULT);
                                $isUserExecuteSuccess = $this->UserModel->create_one($usersData);

                                if ($isUserExecuteSuccess) {
                                    $isReviewExecuteSuccess = $this->ReviewModel->create_one('users', $isUserExecuteSuccess, 1, $statusWaiting, '建立縣市承辦人', null, null, $county);
                                    if ($isReviewExecuteSuccess) {
                                        $ydaManager = $this->UserModel->get_by_yda_row();
                                        $countyName = $this->CountyModel->get_code_by_no($county)->name;

                                        $recipient = $ydaManager->email;
                                        $title = '【教育部青年發展署雙青計畫行政系統】新增「' . $countyName . '承辦人」帳號通知';
                                        $content = '<p>' . $ydaManager->name . ' 君 您好:</p>'
                                        . '<p>' . $countyName . '新增了一位「縣市承辦人」</p>'
                                        . '<p>帳號為 :' . $usersData['id'] . '</p>'
                                        . '<p>姓名為 :' . $usersData['name'] . '</p>'
                                        . '<p>祝 平安快樂</p><p></p>'
                                        . '<p>教育部青年發展署雙青計畫行政系統</p>'
                                        . '<p>' . date('Y-m-d') . '</p>'
                                            . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                                        //api_send_email_temp($recipient, $title, $content);

                                        $recipientUser = $usersData['email'];
                                        $titleUser = '【教育部青年發展署雙青計畫行政系統】「縣市承辦人」帳號建立成功通知';
                                        $contentUser = '<p>' . $usersData['name'] . ' 君 您好:</p>'
                                        . '<p>' . $countyName .'主管新增了一位「縣市承辦人」</p>'
                                        . '<p>帳號為 :' . $usersData['id'] . '</p>'
                                        . '<p>密碼為 : 000000 </p>'
                                        . '<p>登入後請先更改密碼，並留意須遵守設定限制。</p>'
                                        . '<p>祝 平安快樂</p><p></p>'
                                        . '<p>教育部青年發展署雙青計畫行政系統</p>'
                                        . '<p>' . date('Y-m-d') . '</p>'
                                            . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                                        //api_send_email_temp($recipientUser, $titleUser, $contentUser);
                                        $beSentDataset['success'] = '建立帳號成功';
                                    } else {
                                        $beSentDataset['error'] = '申請失敗';
                                    }
                                } else {
                                    $beSentDataset['error'] = '新增失敗';
                                }
                            } else {
                                $beSentDataset['error'] = '密碼兩者不相同';
                            }
                        } else {
                            $beSentDataset['error'] = '密碼需包含英文字母大寫、英文字母小寫與數字並長度大於8';
                        }
                    }
                }
            } else {
                $beSentDataset['error'] = '請先新增縣市';
            }
        }
        $this->load->view('/user/create_account', $beSentDataset);
    }

    public function create_organization_manager_account($countyType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(2, 3, 4);
        valid_roles($accept_role);
        $county = $passport['county'];
        $organizations = $this->OrganizationModel->get_by_county($county);
        $statusWaiting = $this->MenuModel->get_no_resource_by_content('等待批准中', 'review')->no;

        $countyNumber = '?';
        $latestId = '';

        if ($county) {
            $countyNumber = strtolower($this->CountyModel->get_code_by_no($county)->code);
            $latestId = $this->UserModel->get_latest_organization_manager($county) ? $this->UserModel->get_latest_organization_manager($county)->id : '尚無前一組帳號';
        }

        $accountPrefix = 'teenager-' . $countyNumber . '3';

        $beSentDataset = array(
            'title' => '建立機構主管帳號',
            'url' => '/user/create_organization_manager_account',
            'role' => $current_role,
            'kind' => 'organization_manager',
            'organizations' => $organizations,
            'userTitle' => $userTitle,
            'security' => $this->security,
            'users' => null,
            'roleInfo' => null,
            'accountPrefix' => $accountPrefix,
            'latestId' => $latestId,
            'countyType' => $countyType,
            'password' => $passport['password'],
            'updatePwd' => $passport['updatePwd']
        );

        $passwordVerify = $this->security->xss_clean($this->input->post('passwordVerify'));
        $usersData = [];
        $usersColumns = $this->UserModel->get_edited_columns_metadata();
        foreach ($usersColumns as $column) {
            $columnName = $column->column_name;
            $checker = 'trim|htmlspecialchars|xss_clean';
            $this->form_validation->set_rules($columnName, $column->column_comment, $checker);
        }
        if ($this->form_validation->run() != false) {
            foreach ($usersColumns as $column) {
                $columnName = $column->column_name;
                $usersData[$columnName] = $this->input->post($columnName);
            }
            $usersData['organization'] = $passport['organization'] ? $passport['organization'] : $usersData['organization'];
            $usersData['county'] = $passport['county'];

            $isOrganizationHasRelation = $this->CountyModel->is_organization_has_relation($usersData['county'], $usersData['organization']);
            if ($usersData['organization']) {
                $isIdExist = $this->UserModel->is_id_exist($usersData['id']);
                if ($isIdExist) {
                    $beSentDataset['error'] = '帳號已經存在';
                } else {
                    $isOrganizationManagerExist = $this->UserModel->is_organization_manager_exist($usersData['county'], $usersData['organization']);
                    if ($isOrganizationManagerExist) {
                        $beSentDataset['error'] = '已有一組機構主管帳號存在';
                    } else {
                        if (preg_match("/[0-9]+/", $usersData['password'])) {
                            if ($usersData['password'] == $passwordVerify) {
                                $usersData['manager'] = 1;
                                $usersData['usable'] = 1;
                                $usersData['password'] = password_hash($usersData['password'], PASSWORD_DEFAULT);
                                $isUserExecuteSuccess = $this->UserModel->create_one($usersData);
                                if ($isUserExecuteSuccess) {
                                    $isReviewExecuteSuccess = $this->ReviewModel->create_one('users', $isUserExecuteSuccess, 2, $statusWaiting, '建立機構主管', null, null, $county);
                                    if ($isReviewExecuteSuccess) {
                                        $countyManager = $this->UserModel->get_by_county_manager($usersData['county']);
                                        $organizationName = $this->OrganizationModel->get_name_by_no($usersData['organization'])->name;
                                        $countyName = $this->CountyModel->get_code_by_no($county)->name;

                                        $recipient = $countyManager->email;
                                        $title = '【教育部青年發展署雙青計畫行政系統】新增' . $organizationName . '主管通知';
                                        $content = '<p>' . $countyManager->name . ' 君 您好:</p>'
                                        . '<p>' . $organizationName . '新增了一位「機構主管」</p>'
                                        . '<p>帳號為 :' . $usersData['id'] . '</p>'
                                        . '<p>姓名為 :' . $usersData['name'] . '</p>'
                                        . '<p>祝 平安快樂</p><p></p>'
                                        . '<p>教育部青年發展署雙青計畫行政系統</p>'
                                        . '<p>' . date('Y-m-d') . '</p>'
                                            . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                                        //api_send_email_temp($recipient, $title, $content);

                                        $recipientUser = $usersData['email'];
                                        $titleUser = '【教育部青年發展署雙青計畫行政系統】「機構主管」帳號建立成功通知';
                                        $contentUser = '<p>' . $usersData['name'] . ' 君 您好:</p>'
                                        . '<p>' . $countyName . '承辦人新增了一位「機構主管」</p>'
                                        . '<p>帳號為 :' . $usersData['id'] . '</p>'
                                        . '<p>密碼為 : 000000 </p>'
                                        . '<p>登入後請先更改密碼，並留意須遵守設定限制。</p>'
                                        . '<p>祝 平安快樂</p><p></p>'
                                        . '<p>教育部青年發展署雙青計畫行政系統</p>'
                                        . '<p>' . date('Y-m-d') . '</p>'
                                            . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                                        //api_send_email_temp($recipientUser, $titleUser, $contentUser);
                                        $beSentDataset['success'] = '新增成功';
                                    } else {
                                        $beSentDataset['error'] = '申請失敗';
                                    }
                                } else {
                                    $beSentDataset['error'] = '新增失敗';
                                }
                            } else {
                                $beSentDataset['error'] = '密碼兩者不相同';
                            }
                        } else {
                            $beSentDataset['error'] = '密碼需包含英文字母大寫、英文字母小寫與數字並長度大於8';
                        }
                    }
                }
            } elseif ($isOrganizationHasRelation !== true) {
                $beSentDataset['error'] = '本縣市尚未與此機構建立委任關係，請先設定委任關係';
            } else {
                $beSentDataset['error'] = '請先新增機構';
            }
        }
        $this->load->view('/user/create_account', $beSentDataset);
    }

    public function create_organization_contractor_account($countyType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(2, 3, 4);
        valid_roles($accept_role);

        $county = $passport['county'];
        $countyNumber = '?';
        $latestId = '';
        $statusWaiting = $this->MenuModel->get_no_resource_by_content('等待批准中', 'review')->no;

        if ($county) {
            $countyNumber = strtolower($this->CountyModel->get_code_by_no($county)->code);
            $latestId = $this->UserModel->get_latest_organization_contractor($county) ? $this->UserModel->get_latest_organization_contractor($county)->id : '尚無前一組帳號';
        }

        $accountPrefix = 'teenager-' . $countyNumber . '4';

        $beSentDataset = array(
            'title' => '建立機構承辦人帳號',
            'url' => '/user/create_organization_contractor_account',
            'role' => $current_role,
            'kind' => 'organization_contractor',
            'userTitle' => $userTitle,
            'security' => $this->security,
            'users' => null,
            'roleInfo' => null,
            'accountPrefix' => $accountPrefix,
            'latestId' => $latestId,
            'countyType' => $countyType,
            'password' => $passport['password'],
            'updatePwd' => $passport['updatePwd']
        );
        if ($current_role === 3 || $current_role === 2) {
            $organizations = $this->OrganizationModel->get_by_county($passport['county']);
            $beSentDataset['organizations'] = $organizations;
        }

        $passwordVerify = $this->security->xss_clean($this->input->post('passwordVerify'));
        $usersData = [];
        $usersColumns = $this->UserModel->get_edited_columns_metadata();
        foreach ($usersColumns as $column) {
            $columnName = $column->column_name;
            $checker = 'trim|htmlspecialchars|xss_clean';
            $this->form_validation->set_rules($columnName, $column->column_comment, $checker);
        }
        if ($this->form_validation->run() != false) {
            foreach ($usersColumns as $column) {
                $columnName = $column->column_name;
                $usersData[$columnName] = $this->input->post($columnName);
            }
            $usersData['organization'] = $passport['organization'] ? $passport['organization'] : $usersData['organization'];
            $usersData['county'] = $passport['county'];
            $isOrganizationHasRelation = $this->CountyModel->is_organization_has_relation($usersData['county'], $usersData['organization']);
            if ($usersData['organization']) {
                $isIdExist = $this->UserModel->is_id_exist($usersData['id']);
                if ($isIdExist) {
                    $beSentDataset['error'] = '帳號已經存在';
                } else {
                    $isOrganizationContractorExist = $this->UserModel->is_organization_contractor_exist($usersData['county'], $usersData['organization']);
                    if ($isOrganizationContractorExist) {
                        $beSentDataset['error'] = '已有一組機構承辦人帳號存在';
                    } else {
                        if (preg_match("/[0-9]+/", $usersData['password'])) {
                            if ($usersData['password'] == $passwordVerify) {
                                $usersData['manager'] = 0;
                                $usersData['usable'] = 1;
                                $usersData['password'] = password_hash($usersData['password'], PASSWORD_DEFAULT);
                                $isUserExecuteSuccess = $this->UserModel->create_one($usersData);
                                if ($isUserExecuteSuccess) {
                                    $isReviewExecuteSuccess = $this->ReviewModel->create_one('users', $isUserExecuteSuccess, 2, $statusWaiting, '建立機構承辦人', null, null, $county);
                                    if ($isReviewExecuteSuccess) {
                                        $countyManager = $this->UserModel->get_by_county_manager($usersData['county']);
                                        $organizationName = $this->OrganizationModel->get_name_by_no($usersData['organization'])->name;

                                        $recipient = $countyManager->email;
                                        $title = '【教育部青年發展署雙青計畫行政系統】新增機構承辦人通知';
                                        $content = '<p>' . $countyManager->name . ' 君 您好:</p>'
                                        . '<p>' . $organizationName . '新增了一位機構承辦人</p>'
                                        . '<p>帳號為 :' . $usersData['id'] . '</p>'
                                        . '<p>姓名為 :' . $usersData['name'] . '</p>'
                                        . '<p>祝 平安快樂</p><p></p>'
                                        . '<p>教育部青年發展署雙青計畫行政系統</p>'
                                        . '<p>' . date('Y-m-d') . '</p>'
                                            . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                                        //api_send_email_temp($recipient, $title, $content);

                                        $recipientUser = $usersData['email'];
                                        $titleUser = '【教育部青年發展署雙青計畫行政系統】「機構承辦人」帳號建立成功通知';
                                        $contentUser = '<p>' . $usersData['name'] . ' 君 您好:</p>'
                                        . '<p>' . $organizationName . '主管新增了一位「機構承辦人」</p>'
                                        . '<p>帳號為 :' . $usersData['id'] . '</p>'
                                        . '<p>密碼為 : 000000 </p>'
                                        . '<p>登入後請先更改密碼，並留意須遵守設定限制。</p>'
                                        . '<p>祝 平安快樂</p><p></p>'
                                        . '<p>教育部青年發展署雙青計畫行政系統</p>'
                                        . '<p>' . date('Y-m-d') . '</p>'
                                            . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                                        //api_send_email_temp($recipientUser, $titleUser, $contentUser);
                                        $beSentDataset['success'] = '新增成功';
                                    } else {
                                        $beSentDataset['error'] = '申請失敗';
                                    }
                                } else {
                                    $beSentDataset['error'] = '新增失敗';
                                }
                            } else {
                                $beSentDataset['error'] = '密碼兩者不相同';
                            }
                        } else {
                            $beSentDataset['error'] = '密碼需包含英文字母大寫、英文字母小寫與數字並長度大於8';
                        }
                    }
                }
            } elseif ($isOrganizationHasRelation !== true) {
                if ($passport['organization']) {
                    $beSentDataset['error'] = '本機構尚未與縣市建立委任關係';
                } else {
                    $beSentDataset['error'] = '本縣市尚未與此機構建立委任關係，請先設定委任關係';
                }
            } else {
                $beSentDataset['error'] = '請先新增機構';
            }
        }
        $this->load->view('/user/create_account', $beSentDataset);
    }

    public function create_counselor_account($countyType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(2, 4, 5);

        valid_roles($accept_role);

        $county = $passport['county'];
        $genders = $this->MenuModel->get_by_form_and_column('counselor', 'gender');
        $qualifications = $this->MenuModel->get_by_form_and_column('counselor', 'qualification');
        $highestEducations = $this->MenuModel->get_by_form_and_column('counselor', 'highest_education');
        $affiliatedDepartments = $this->MenuModel->get_by_form_and_column('counselor', 'affiliated_department');
        $statusWaiting = $this->MenuModel->get_no_resource_by_content('等待批准中', 'review')->no;

        $beSentDataset = array(
            'title' => '建立輔導員帳號',
            'url' => '/user/create_counselor_account',
            'role' => $current_role,
            'kind' => 'counselor',
            'genders' => $genders,
            'qualifications' => $qualifications,
            'highestEducations' => $highestEducations,
            'affiliatedDepartments' => $affiliatedDepartments,
            'userTitle' => $userTitle,
            'security' => $this->security,
            'users' => null,
            'roleInfo' => null,
            'accountPrefix' => null,
            'latestId' => null,
            'countyType' => $countyType,
            'password' => $passport['password'],
            'updatePwd' => $passport['updatePwd']
        );

        if ($current_role === 3 || $current_role === 2) {
            $organizations = $this->OrganizationModel->get_by_county($passport['county']);
            $beSentDataset['organizations'] = $organizations;
        }

        $passwordVerify = $this->security->xss_clean($this->input->post('passwordVerify'));
        $counselorData = [];
        $counselorColumns = $this->CounselorModel->get_edited_columns_metadata();
        $usersData = [];
        $usersColumns = $this->UserModel->get_edited_columns_metadata();
        foreach ($counselorColumns as $column) {
            $columnName = $column->column_name;
            $checker = 'trim|htmlspecialchars|xss_clean';
            $this->form_validation->set_rules($columnName, $column->column_comment, $checker);
        }
        foreach ($usersColumns as $column) {
            $columnName = $column->column_name;
            $checker = 'trim|htmlspecialchars|xss_clean';
            $this->form_validation->set_rules($columnName, $column->column_comment, $checker);
        }
        if ($this->form_validation->run() != false) {
            foreach ($counselorColumns as $column) {
                $columnName = $column->column_name;
                $counselorData[$columnName] = $this->input->post($columnName);
            }
            $checkboxColumns = array('education_start_date', 'education_complete_date', 'education_school', 'education_department', 'work_start_date', 'work_complete_date', 'work_department', 'work_position', 'qualification');
            foreach ($checkboxColumns as $column) {
                $counselorData[$column] = $this->input->post($column) ? implode(",", $this->input->post($column)) : 0;
            }
            foreach ($usersColumns as $column) {
                $columnName = $column->column_name;
                $usersData[$columnName] = $this->input->post($columnName);
            }
            $isIdExist = $this->UserModel->is_id_exist($usersData['id']);
            if ($isIdExist) {
                $beSentDataset['error'] = '帳號已經存在';
            } else {

                $usersData['organization'] = $passport['organization'] ? $passport['organization'] : $usersData['organization'];
                $usersData['county'] = $passport['county'];
                $counselorData['organization'] = $passport['organization'] ? $passport['organization'] : $counselorData['organization'];
                $usersData['manager'] = 0;
                $usersData['usable'] = 1;

                $counselorLimit = $this->ProjectModel->get_latest_by_county($usersData['county'])->counselor_count;
                $isCounselorExist = $this->UserModel->is_counselor_exist($usersData['county'], $usersData['organization']);
                if ($isCounselorExist >= $counselorLimit) {
                    $beSentDataset['error'] = '輔導員帳號數量已達計畫申請上限';
                } else {
                    if (preg_match("/[0-9]+/", $usersData['password'])) {
                        if ($usersData['password'] == $passwordVerify) {
                            $usersData['password'] = password_hash($usersData['password'], PASSWORD_DEFAULT);
                            $counselor = $this->CounselorModel->create_one($counselorData);
                            $usersData['counselor'] = $counselor;
                            $isUserExecuteSuccess = $this->UserTempModel->create_one($usersData);
                            if ($counselor && $isUserExecuteSuccess) {
                                $isReviewExecuteSuccess = $this->ReviewModel->create_one('counselor_users', $isUserExecuteSuccess, 4, $statusWaiting, '建立輔導員', null, null, $county);
                                if ($isReviewExecuteSuccess) {
                                    $organizationManager = $this->UserModel->get_by_organization_manager($usersData['organization']);
                                    $organizationName = $this->OrganizationModel->get_name_by_no($usersData['organization'])->name;

                                    $recipient = $organizationManager->email;
                                    $title = '【教育部青年發展署雙青計畫行政系統】新增「輔導員」通知';
                                    $content = '<p>' . $organizationManager->name . ' 君 您好:</p>'
                                    . '<p>' . $organizationName . '新增了一位「輔導員」</p>'
                                    . '<p>帳號為 :' . $usersData['id'] . '</p>'
                                    . '<p>姓名為 :' . $usersData['name'] . '</p>'
                                    . '<p>此帳號需要您的審核才能開始使用，請撥空進行審核。</p>'
                                    . '<p>祝 平安快樂</p><p></p>'
                                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                                    . '<p>' . date('Y-m-d') . '</p>'
                                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                                    //api_send_email_temp($recipient, $title, $content);
                                    $beSentDataset['success'] = '已送出申請';
                                } else {
                                    $beSentDataset['error'] = '申請失敗';
                                }
                            } else {
                                $beSentDataset['error'] = '新增失敗';
                            }
                        } else {
                            $beSentDataset['error'] = '密碼兩者不相同';
                        }
                    } else {
                        $beSentDataset['error'] = '密碼需包含英文字母大寫、英文字母小寫與數字並長度大於8';
                    }
                }
            }
        }
        $this->load->view('/user/create_account', $beSentDataset);
    }

    public function account_manage_table($countyType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(1, 2, 3, 4, 5, 9);

        valid_roles($accept_role);

        $county = $passport['county'] ? $passport['county'] : $countyType;

        $counties = $this->CountyModel->get_all();

        $ydaUsers = $ydaSupportUsers = $countyManageUsers = $countyUsers = $organizationManageUsers = $organizationUsers = $counselorUsers = $youthUsers = [];
        $users = $this->UserModel->get_all();
        foreach ($users as $i) {
            if (!empty($i['yda'])):
                if ($i['manager'] == 1) {
                    array_push($ydaUsers, $i);
                } else {
                    array_push($ydaSupportUsers, $i);
                } elseif ($i['manager'] == 1 && !empty($i['county']) && empty($i['organization']) && empty($i['counselor'])):
                if (!empty($county)) {
                    if ($county == $i['county']) {
                        array_push($countyManageUsers, $i);
                    }
                } else {
                    array_push($countyManageUsers, $i);
                } elseif ($i['manager'] == 0 && !empty($i['county']) && empty($i['organization']) && empty($i['counselor'])):
                if (!empty($county)) {
                    if ($county == $i['county']) {
                        array_push($countyUsers, $i);
                    }
                } else {
                    array_push($countyUsers, $i);
                } elseif ($i['manager'] == 1 && !empty($i['county']) && !empty($i['organization']) && empty($i['counselor'])):
                if (!empty($county)) {
                    if ($county == $i['county']) {
                        array_push($organizationManageUsers, $i);
                    }
                } else {
                    array_push($organizationManageUsers, $i);
                } elseif ($i['manager'] == 0 && !empty($i['county']) && !empty($i['organization']) && empty($i['counselor'])):
                if (!empty($county)) {
                    if ($county == $i['county']) {
                        array_push($organizationUsers, $i);
                    }
                } else {
                    array_push($organizationUsers, $i);
                } elseif (!empty($i['counselor'])):
                if (!empty($county)) {
                    if ($county == $i['county']) {
                        array_push($counselorUsers, $i);
                    }
                } else {
                    array_push($counselorUsers, $i);
                } elseif (!empty($youth)):
                array_push($youthUsers, $i);
            endif;
        }

        // $ydaUsers = $this->UserModel->get_by_yda();
        // $countyUsers = $this->UserModel->get_by_county($county);
        $beSentDataset = array(
            'title' => '人員帳號管理',
            'url' => '/user/account_manage_table',
            'role' => $current_role,
            'county' => $county,
            'counties' => $counties,
            'userTitle' => $userTitle,
            'current_role' => $current_role,
            'accept_role' => $accept_role,
            'ydaUsers' => $ydaUsers,
            'ydaSupportUsers' => $ydaSupportUsers,
            'countyManageUsers' => $countyManageUsers,
            'countyUsers' => $countyUsers,
            'organizationManageUsers' => $organizationManageUsers,
            'organizationUsers' => $organizationUsers,
            'counselorUsers' => $counselorUsers,
            'youthUsers' => $youthUsers,
            'password' => $passport['password'],
            'updatePwd' => $passport['updatePwd']
        );

        $this->load->view('/user/account_manage_table', $beSentDataset);
    }

    public function update_manage_usable($id = null, $usable = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(1, 2, 3, 4, 5, 9);
        valid_roles($accept_role);

        if ($usable == '1'):
            $usable = '0';
        elseif ($usable == '0'):
            $usable = '1';
        endif;

        $isUpdateSuccess = null;
        $userInfo = $this->UserModel->get_by_id_for_update_usable($id);
        $selfInfo = $this->UserModel->get_by_id_for_update_usable($passport['id']);

        # 支援計畫人員
        if ($userInfo->yda != null && $userInfo->manager == '0') {
            $isUpdateSuccess = $this->UserModel->update_by_id($id, $usable);
            if ($isUpdateSuccess) {
                if ($usable == '1') { #啟用

                    $ydaManager = $this->UserModel->get_by_yda_row();

                    $recipientSave = $ydaManager->email;
                    $titleSave = '【教育部青年發展署雙青計畫行政系統】啟用「支援計畫人員」通知';
                    $contentSave = '<p>' . $ydaManager->name . ' 君 您好:</p>'
                    . '<p>' . $selfInfo->name . '將「支援計畫人員」啟用</p>'
                    . '<p>帳號為 :' . $userInfo->id . '</p>'
                    . '<p>姓名為 :' . $userInfo->name . '</p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipientSave, $titleSave, $contentSave);

                    $recipientNotify = $userInfo->email;
                    $titleNotify = '【教育部青年發展署雙青計畫行政系統】帳號啟用通知';
                    $contentNotify = '<p>' . $userInfo->name . ' 君 您好:</p>'
                    . '<p>您的「支援計畫人員」帳號已啟用</p>'
                    . '<p>帳號為 :' . $userInfo->id . '</p>'
                    . '<p>姓名為 :' . $userInfo->name . '</p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipientNotify, $titleNotify, $contentNotify);
                } else {
                    $ydaManager = $this->UserModel->get_by_yda_row();

                    $recipientSave = $ydaManager->email;
                    $titleSave = '【教育部青年發展署雙青計畫行政系統】停用「支援計畫人員」通知';
                    $contentSave = '<p>' . $ydaManager->name . ' 君 您好:</p>'
                    . '<p>' . $selfInfo->name . '將「支援計畫人員」停用</p>'
                    . '<p>帳號為 :' . $userInfo->id . '</p>'
                    . '<p>姓名為 :' . $userInfo->name . '</p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipientSave, $titleSave, $contentSave);

                    $recipientNotify = $userInfo->email;
                    $titleNotify = '【教育部青年發展署雙青計畫行政系統】帳號停用通知';
                    $contentNotify = '<p>' . $userInfo->name . ' 君 您好:</p>'
                    . '<p>您的「支援計畫人員」帳號已啟用</p>'
                    . '<p>帳號為 :' . $userInfo->id . '</p>'
                    . '<p>姓名為 :' . $userInfo->name . '</p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipientNotify, $titleNotify, $contentNotify);
                }
            }
        }
        #縣市主管
        elseif ($userInfo->manager == '1' && $userInfo->county != null && $userInfo->organization == null) {
            if($usable == '1'){
              if($this->UserModel->is_county_manager_exist($userInfo->county)){
                redirect('user/account_manage_table');
              }
            }
            $isUpdateSuccess = $this->UserModel->update_by_id($id, $usable);
            if ($isUpdateSuccess) {
                if ($usable == '1') { #啟用

                    $ydaManager = $this->UserModel->get_by_yda_row();

                    $recipientSave = $ydaManager->email;
                    $titleSave = '【教育部青年發展署雙青計畫行政系統】啟用「縣市主管」通知';
                    $contentSave = '<p>' . $ydaManager->name . ' 君 您好:</p>'
                    . '<p>' . $selfInfo->name . '將「縣市主管」啟用</p>'
                    . '<p>帳號為 :' . $userInfo->id . '</p>'
                    . '<p>姓名為 :' . $userInfo->name . '</p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipientSave, $titleSave, $contentSave);

                    $recipientNotify = $userInfo->email;
                    $titleNotify = '【教育部青年發展署雙青計畫行政系統】帳號啟用通知';
                    $contentNotify = '<p>' . $userInfo->name . ' 君 您好:</p>'
                    . '<p>您的「縣市主管」帳號已啟用</p>'
                    . '<p>帳號為 :' . $userInfo->id . '</p>'
                    . '<p>姓名為 :' . $userInfo->name . '</p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipientNotify, $titleNotify, $contentNotify);

                } else {

                    $ydaManager = $this->UserModel->get_by_yda_row();

                    $recipientSave = $ydaManager->email;
                    $titleSave = '【教育部青年發展署雙青計畫行政系統】停用「縣市主管」通知';
                    $contentSave = '<p>' . $ydaManager->name . ' 君 您好:</p>'
                    . '<p>' . $selfInfo->name . '將「縣市主管」停用</p>'
                    . '<p>帳號為 :' . $userInfo->id . '</p>'
                    . '<p>姓名為 :' . $userInfo->name . '</p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipientSave, $titleSave, $contentSave);

                    $recipientNotify = $userInfo->email;
                    $titleNotify = '【教育部青年發展署雙青計畫行政系統】帳號停用通知';
                    $contentNotify = '<p>' . $userInfo->name . ' 君 您好:</p>'
                    . '<p>您的「縣市主管」帳號已停用</p>'
                    . '<p>帳號為 :' . $userInfo->id . '</p>'
                    . '<p>姓名為 :' . $userInfo->name . '</p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipientNotify, $titleNotify, $contentNotify);
                }
            }
        }
        # 縣市承辦人
        elseif ($userInfo->manager == '0' && $userInfo->county != null && $userInfo->organization == null) {
            if($usable == '1'){
              if($this->UserModel->is_county_contractor_exist($userInfo->county)){
                redirect('user/account_manage_table');
              }
            }
            $isUpdateSuccess = $this->UserModel->update_by_id($id, $usable);
            if ($isUpdateSuccess) {
                if ($usable == '1') { #啟用

                    $ydaManager = $this->UserModel->get_by_yda_row();

                    $recipientSave = $ydaManager->email;
                    $titleSave = '【教育部青年發展署雙青計畫行政系統】啟用「縣市承辦人」通知';
                    $contentSave = '<p>' . $ydaManager->name . ' 君 您好:</p>'
                    . '<p>' . $selfInfo->name . '將「縣市承辦人」啟用</p>'
                    . '<p>帳號為 :' . $userInfo->id . '</p>'
                    . '<p>姓名為 :' . $userInfo->name . '</p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipientSave, $titleSave, $contentSave);

                    $recipientNotify = $userInfo->email;
                    $titleNotify = '【教育部青年發展署雙青計畫行政系統】帳號啟用通知';
                    $contentNotify = '<p>' . $userInfo->name . ' 君 您好:</p>'
                    . '<p>您的「縣市承辦人」帳號已啟用</p>'
                    . '<p>帳號為 :' . $userInfo->id . '</p>'
                    . '<p>姓名為 :' . $userInfo->name . '</p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipientNotify, $titleNotify, $contentNotify);

                } else {

                    $ydaManager = $this->UserModel->get_by_yda_row();

                    $recipientSave = $ydaManager->email;
                    $titleSave = '【教育部青年發展署雙青計畫行政系統】停用「縣市承辦人」通知';
                    $contentSave = '<p>' . $ydaManager->name . ' 君 您好:</p>'
                    . '<p>' . $selfInfo->name . '將「縣市承辦人」停用</p>'
                    . '<p>帳號為 :' . $userInfo->id . '</p>'
                    . '<p>姓名為 :' . $userInfo->name . '</p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipientSave, $titleSave, $contentSave);

                    $recipientNotify = $userInfo->email;
                    $titleNotify = '【教育部青年發展署雙青計畫行政系統】帳號停用通知';
                    $contentNotify = '<p>' . $userInfo->name . ' 君 您好:</p>'
                    . '<p>您的「縣市承辦人」帳號已停用</p>'
                    . '<p>帳號為 :' . $userInfo->id . '</p>'
                    . '<p>姓名為 :' . $userInfo->name . '</p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipientNotify, $titleNotify, $contentNotify);
                }
            }
        }
        # 機構主管
        elseif ($userInfo->manager == '1' && $userInfo->county != null && $userInfo->organization != null) {
            if($usable == '1'){
              if($this->UserModel->is_organization_manager_exist($userInfo->county,$userInfo->organization)){
                redirect('user/account_manage_table');
              }
            }
            $isUpdateSuccess = $this->UserModel->update_by_id($id, $usable);
            if ($isUpdateSuccess) {
                if ($usable == '1') { #啟用

                    $countyManager = $this->UserModel->get_by_county_manager($passport['county']);

                    $recipientSave = $countyManager->email;
                    $titleSave = '【教育部青年發展署雙青計畫行政系統】啟用「機構主管」通知';
                    $contentSave = '<p>' . $countyManager->name . ' 君 您好:</p>'
                    . '<p>' . $selfInfo->name . '將「機構主管」啟用</p>'
                    . '<p>帳號為 :' . $userInfo->id . '</p>'
                    . '<p>姓名為 :' . $userInfo->name . '</p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipientSave, $titleSave, $contentSave);

                    $recipientNotify = $userInfo->email;
                    $titleNotify = '【教育部青年發展署雙青計畫行政系統】帳號啟用通知';
                    $contentNotify = '<p>' . $userInfo->name . ' 君 您好:</p>'
                    . '<p>您的「機構主管」帳號已啟用</p>'
                    . '<p>帳號為 :' . $userInfo->id . '</p>'
                    . '<p>姓名為 :' . $userInfo->name . '</p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipientNotify, $titleNotify, $contentNotify);

                } else {

                    $countyManager = $this->UserModel->get_by_county_manager($passport['county']);

                    $recipientSave = $countyManager->email;
                    $titleSave = '【教育部青年發展署雙青計畫行政系統】停用「機構主管」通知';
                    $contentSave = '<p>' . $countyManager->name . ' 君 您好:</p>'
                    . '<p>' . $selfInfo->name . '將「機構主管」停用</p>'
                    . '<p>帳號為 :' . $userInfo->id . '</p>'
                    . '<p>姓名為 :' . $userInfo->name . '</p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipientSave, $titleSave, $contentSave);

                    $recipientNotify = $userInfo->email;
                    $titleNotify = '【教育部青年發展署雙青計畫行政系統】帳號停用通知';
                    $contentNotify = '<p>' . $userInfo->name . ' 君 您好:</p>'
                    . '<p>您的「機構主管」帳號已停用</p>'
                    . '<p>帳號為 :' . $userInfo->id . '</p>'
                    . '<p>姓名為 :' . $userInfo->name . '</p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipientNotify, $titleNotify, $contentNotify);
                }
            }
        }
        # 機構承辦人
        elseif ($userInfo->manager == '0' && $userInfo->county != null && $userInfo->organization != null && $userInfo->counselor == null) {
            if($usable == '1'){
              if($this->UserModel->is_organization_contractor_exist($userInfo->county, $userInfo->organization)){
                redirect('user/account_manage_table');
              }
            }
            $isUpdateSuccess = $this->UserModel->update_by_id($id, $usable);
            if ($isUpdateSuccess) {
                if ($usable == '1') { #啟用

                    $countyManager = $this->UserModel->get_by_county_manager($passport['county']);

                    $recipientSave = $countyManager->email;
                    $titleSave = '【教育部青年發展署雙青計畫行政系統】啟用「機構承辦人」通知';
                    $contentSave = '<p>' . $countyManager->name . ' 君 您好:</p>'
                    . '<p>' . $selfInfo->name . '將「機構承辦人」啟用</p>'
                    . '<p>帳號為 :' . $userInfo->id . '</p>'
                    . '<p>姓名為 :' . $userInfo->name . '</p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipientSave, $titleSave, $contentSave);

                    $recipientNotify = $userInfo->email;
                    $titleNotify = '【教育部青年發展署雙青計畫行政系統】帳號啟用通知';
                    $contentNotify = '<p>' . $userInfo->name . ' 君 您好:</p>'
                    . '<p>您的「機構承辦人」帳號已啟用</p>'
                    . '<p>帳號為 :' . $userInfo->id . '</p>'
                    . '<p>姓名為 :' . $userInfo->name . '</p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipientNotify, $titleNotify, $contentNotify);

                } else {

                    $countyManager = $this->UserModel->get_by_county_manager($passport['county']);

                    $recipientSave = $countyManager->email;
                    $titleSave = '【教育部青年發展署雙青計畫行政系統】停用「機構承辦人」通知';
                    $contentSave = '<p>' . $countyManager->name . ' 君 您好:</p>'
                    . '<p>' . $selfInfo->name . '將「機構承辦人」停用</p>'
                    . '<p>帳號為 :' . $userInfo->id . '</p>'
                    . '<p>姓名為 :' . $userInfo->name . '</p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipientSave, $titleSave, $contentSave);

                    $recipientNotify = $userInfo->email;
                    $titleNotify = '【教育部青年發展署雙青計畫行政系統】帳號停用通知';
                    $contentNotify = '<p>' . $userInfo->name . ' 君 您好:</p>'
                    . '<p>您的「機構承辦人」帳號已停用</p>'
                    . '<p>帳號為 :' . $userInfo->id . '</p>'
                    . '<p>姓名為 :' . $userInfo->name . '</p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipientNotify, $titleNotify, $contentNotify);
                }
            }
        }
        # 輔導員
        elseif ($userInfo->manager == '0' && $userInfo->county != null && $userInfo->organization != null && $userInfo->counselor != null) {
            $formName = 'update_usable';
            $formNo = $id;
            $reviewerRole = 4;
            $status = $this->MenuModel->get_no_resource_by_content('等待批准中', 'review')->no;
            $updateColumn = 'usable';
            $updateValue = $usable;
            $isUpdateSuccess = $this->ReviewModel->create_one($formName, $formNo, $reviewerRole, $status, '更改輔導員帳號狀態',
                $updateColumn, $updateValue, $passport['county']);
            if ($isUpdateSuccess) {
                if ($usable == '1') { #啟用

                    $organizationManager = $this->UserModel->get_by_organization_manager($usersData['organization']);

                    $recipientSave = $organizationManager->email;
                    $titleSave = '【教育部青年發展署雙青計畫行政系統】啟用「輔導員」申請通知';
                    $contentSave = '<p>' . $organizationManager->name . ' 君 您好:</p>'
                    . '<p>' . $selfInfo->name . '將「輔導員」啟用</p>'
                    . '<p>帳號為 :' . $userInfo->id . '</p>'
                    . '<p>姓名為 :' . $userInfo->name . '</p>'
                    . '<p>此動作需要您的審核才會生效，請撥空進行審核。</p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipientSave, $titleSave, $contentSave);

                } else {

                    $organizationManager = $this->UserModel->get_by_organization_manager($usersData['organization']);

                    $recipientSave = $organizationManager->email;
                    $titleSave = '【教育部青年發展署雙青計畫行政系統】停用「輔導員」申請通知';
                    $contentSave = '<p>' . $organizationManager->name . ' 君 您好:</p>'
                    . '<p>' . $selfInfo->name . '將「輔導員」停用</p>'
                    . '<p>帳號為 :' . $userInfo->id . '</p>'
                    . '<p>姓名為 :' . $userInfo->name . '</p>'
                    . '<p>此動作需要您的審核才會生效，請撥空進行審核。</p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipientSave, $titleSave, $contentSave);
                }
            }
        }

        else {
          $isUpdateSuccess = $this->UserModel->update_by_id($id, $usable);
        }

        if ($isUpdateSuccess) {
            redirect('user/account_manage_table');
        }
    }
    public function member_info()
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '查看會員個人資訊',
                'url' => '/user/member_info',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'security' => $this->security,
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
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '查看工作人員個人資訊',
                'url' => '/user/staff_info',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'security' => $this->security,
                'password' => $passport['password']
            );
            $this->load->view('/user/staff_info', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function user_info($countyType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $id = $passport['id'];
        $userTitle = $passport['userTitle'];
        $counselor = $passport['counselor'];
        $county = $passport['county'];
        $accept_role = array(1, 2, 3, 4, 5, 6, 8, 9);
        $roleInfo = null;

        if (in_array($current_role, $accept_role)) {
            $users = $id ? $this->UserModel->get_by_id($id)->row_array() : null;
            $genders = $this->MenuModel->get_by_form_and_column('youth', 'gender');
            $qualifications = $this->MenuModel->get_by_form_and_column('counselor', 'qualification');
            $highestEducations = $this->MenuModel->get_by_form_and_column('counselor', 'highest_education');
            $affiliatedDepartments = $this->MenuModel->get_by_form_and_column('counselor', 'affiliated_department');

            if ($current_role == 1):
                $roleInfo = $this->YdaModel->get_by_no($users['yda']);
                $kind = 'yda';
            elseif ($current_role == 2):
                $kind = 'county_manager';
            elseif ($current_role == 3):
                $kind = 'county_contractor';
            elseif ($current_role == 4):
                $kind = 'organization_manager';
            elseif ($current_role == 5):
                $kind = 'organization_contractor';
            elseif ($current_role == 6):
                $roleInfo = $this->CounselorModel->get_by_no($users['counselor']);
                $kind = 'counselor';
            elseif ($current_role == 8):
                $roleInfo = $this->YdaModel->get_by_no($users['yda']);
                $kind = 'support';
            endif;

            $beSentDataset = array(
                'title' => '修改個人資訊',
                'url' => '/user/user_info',
                'role' => $current_role,
                'genders' => $genders,
                'qualifications' => $qualifications,
                'highestEducations' => $highestEducations,
                'affiliatedDepartments' => $affiliatedDepartments,
                'roleInfo' => $roleInfo,
                'users' => $users,
                'userTitle' => $userTitle,
                'security' => $this->security,
                'kind' => $kind,
                'accountPrefix' => null,
                'latestId' => null,
                'countyType' => $countyType,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            if($roleInfo && $kind == 'counselor') {
              $schoolHistory = [];
              $schoolHistoryItem = [];

              $workHistory = [];
              $workHistoryItem = [];

              $educationStartDateArray = explode(",", $roleInfo->education_start_date);
              $educationCompleteDateArray = explode(",", $roleInfo->education_complete_date);
              $educationSchoolArray = explode(",", $roleInfo->education_school);
              $educationDepartmentArray = explode(",", $roleInfo->education_department);
              $workStartDateArray = explode(",", $roleInfo->work_start_date);
              $workCompleteDateArray = explode(",", $roleInfo->work_complete_date);
              $workDepartmentArray = explode(",", $roleInfo->work_department);
              $workPositionArray = explode(",", $roleInfo->work_position);

              for($i=0; $i<count($educationStartDateArray); $i++) {
                $schoolHistoryItem['educationStartDate'] = $educationStartDateArray[$i];
                $schoolHistoryItem['educationCompleteDate'] = $educationCompleteDateArray[$i];
                $schoolHistoryItem['educationSchool'] = $educationSchoolArray[$i];
                $schoolHistoryItem['educationDepartment'] = $educationDepartmentArray[$i];
                array_push($schoolHistory, $schoolHistoryItem);            
              }

              for($i=0; $i<count($workStartDateArray); $i++) {
               
                $workHistoryItem['workStartDate'] = $workStartDateArray[$i];
                $workHistoryItem['workCompleteDate'] = $workCompleteDateArray[$i];
                $workHistoryItem['workDepartment'] = $workDepartmentArray[$i];
                $workHistoryItem['workPosition'] = $workPositionArray[$i];
                array_push($workHistory, $workHistoryItem);      
              }

              $beSentDataset['schoolHistory'] = $schoolHistory;
              $beSentDataset['workHistory'] = $workHistory;
            }

            $name = $this->security->xss_clean($this->input->post('name'));
            $line = $this->security->xss_clean($this->input->post('line'));
            $identification = $this->security->xss_clean($this->input->post('identification'));
            $gender = $this->security->xss_clean($this->input->post('gender'));
            $birth = $this->security->xss_clean($this->input->post('birth'));
            $department = $this->security->xss_clean($this->input->post('department'));
            $fax = $this->security->xss_clean($this->input->post('fax'));
            $phone = $this->security->xss_clean($this->input->post('phone'));
            $officePhone = $this->security->xss_clean($this->input->post('office_phone'));
            $email = $this->security->xss_clean($this->input->post('email'));
            $householdAddress = $this->security->xss_clean($this->input->post('household_address'));
            $resideAddress = $this->security->xss_clean($this->input->post('reside_address'));
            $highestEducation = $this->security->xss_clean($this->input->post('highest_education'));
            $affiliatedDepartment = $this->security->xss_clean($this->input->post('affiliated_department'));

            $transportation = $this->input->post('transportation') ? implode(",", $this->security->xss_clean($this->input->post('transportation'))) : null;

            $educationStartDate = $this->input->post('education_start_date') ? implode(",", $this->security->xss_clean($this->input->post('education_start_date'))) : null;
            $educationCompleteDate = $this->input->post('education_complete_date') ? implode(",", $this->security->xss_clean($this->input->post('education_complete_date'))) : null;
            $educationSchool = $this->input->post('education_school') ? implode(",", $this->security->xss_clean($this->input->post('education_school'))) : null;
            $educationDepartment = $this->input->post('education_department') ? implode(",", $this->security->xss_clean($this->input->post('education_department'))) : null;
            $workStartDate = $this->input->post('work_start_date') ? implode(",", $this->security->xss_clean($this->input->post('work_start_date'))) : null;
            $workCompleteDate = $this->input->post('work_complete_date') ? implode(",", $this->security->xss_clean($this->input->post('work_complete_date'))) : null;
            $workDepartment = $this->input->post('work_department') ? implode(",", $this->security->xss_clean($this->input->post('work_department'))) : null;
            $workPosition = $this->input->post('work_position') ? implode(",", $this->security->xss_clean($this->input->post('work_position'))) : null;

            $dutyDate = $this->security->xss_clean($this->input->post('duty_date'));
            $qualification = $this->input->post('qualification') ? implode(",", $this->security->xss_clean($this->input->post('qualification'))) : null;

            if (empty($name)) {
                return $this->load->view('/user/create_account', $beSentDataset);
            }

            if (!empty($users)) {
                $isExecuteSuccess = $this->UserModel->update_user($id, $name, $email, $line, $officePhone);

                if ($current_role == 1):
                    $roleExecuteSuccess = $this->YdaModel->update_one($phone, $users['yda']);
                elseif ($current_role == 6):
                    $roleExecuteSuccess = $this->CounselorModel->update_one($identification, $gender, $birth, $department, $fax, $phone, $email,
                        $householdAddress, $resideAddress, $educationStartDate, $educationCompleteDate,
                        $educationSchool, $educationDepartment, $workStartDate, $workCompleteDate,
                        $workDepartment, $workPosition, $dutyDate, $qualification, $highestEducation, $affiliatedDepartment, $users['counselor']);
                endif;
            }

            if ($users && $isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
            } else {
                $beSentDataset['error'] = '新增失敗';
            }

            if ($current_role == 1):
                $roleInfo = $this->YdaModel->get_by_no($users['yda']);
            elseif ($current_role == 6):
                $roleInfo = $this->CounselorModel->get_by_no($users['counselor']);
            endif;

            $users = $id ? $this->UserModel->get_by_id($id)->row_array() : null;
            $beSentDataset['users'] = $users;
            $beSentDataset['roleInfo'] = $roleInfo;
            if($roleInfo && $kind == 'counselor') {
              $schoolHistory = [];
              $schoolHistoryItem = [];

              $workHistory = [];
              $workHistoryItem = [];

              $educationStartDateArray = explode(",", $roleInfo->education_start_date);
              $educationCompleteDateArray = explode(",", $roleInfo->education_complete_date);
              $educationSchoolArray = explode(",", $roleInfo->education_school);
              $educationDepartmentArray = explode(",", $roleInfo->education_department);
              $workStartDateArray = explode(",", $roleInfo->work_start_date);
              $workCompleteDateArray = explode(",", $roleInfo->work_complete_date);
              $workDepartmentArray = explode(",", $roleInfo->work_department);
              $workPositionArray = explode(",", $roleInfo->work_position);

              for($i=0; $i<count($educationStartDateArray); $i++) {
                $schoolHistoryItem['educationStartDate'] = $educationStartDateArray[$i];
                $schoolHistoryItem['educationCompleteDate'] = $educationCompleteDateArray[$i];
                $schoolHistoryItem['educationSchool'] = $educationSchoolArray[$i];
                $schoolHistoryItem['educationDepartment'] = $educationDepartmentArray[$i];
                array_push($schoolHistory, $schoolHistoryItem);            
              }

              for($i=0; $i<count($workStartDateArray); $i++) {
               
                $workHistoryItem['workStartDate'] = $workStartDateArray[$i];
                $workHistoryItem['workCompleteDate'] = $workCompleteDateArray[$i];
                $workHistoryItem['workDepartment'] = $workDepartmentArray[$i];
                $workHistoryItem['workPosition'] = $workPositionArray[$i];
                array_push($workHistory, $workHistoryItem);      
              }

              $beSentDataset['schoolHistory'] = $schoolHistory;
              $beSentDataset['workHistory'] = $workHistory;
            }

            $this->load->view('/user/create_account', $beSentDataset);
        }
    }

    public function user_password()
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $id = $passport['id'];
        $userTitle = $passport['userTitle'];
        $counselor = $passport['counselor'];
        $county = $passport['county'];
        $accept_role = array(1, 2, 3, 4, 5, 6, 8, 9);
        $roleInfo = null;

        if (in_array($current_role, $accept_role)) {
            $users = $id ? $this->UserModel->get_by_id($id)->row_array() : null;

            $beSentDataset = array(
                'title' => '修改個人密碼',
                'url' => '/user/user_password/',
                'role' => $current_role,
                'roleInfo' => $roleInfo,
                'users' => $users,
                'userTitle' => $userTitle,
                'security' => $this->security,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $password = $this->security->xss_clean($this->input->post('password'));
            $passwordNew = $this->security->xss_clean($this->input->post('passwordNew'));

            if ($passwordNew) {
                if (preg_match("/[0-9]+/", $passwordNew) && preg_match("/[a-z]+/", $passwordNew) && preg_match("/[A-Z]+/", $passwordNew) && strlen($passwordNew) >= 8) {
                    $passwordVerify = $this->security->xss_clean($this->input->post('passwordVerify'));

                    if (empty($password)) {
                        return $this->load->view('/user/update_password', $beSentDataset);
                    }

                    $isExecuteSuccess = null;

                    if(password_verify($passwordNew, $users['last_password_one']) || password_verify($passwordNew, $users['last_password_two'] || password_verify($passwordNew, $users['last_password_three']))) {
                      $beSentDataset['error'] = '新密碼不能與其三次相同';
                      return $this->load->view('/user/update_password', $beSentDataset);
                    }

                    if (password_verify($password, $users['password'])) {
                        if ($passwordNew == $passwordVerify) {
                            $isExecuteSuccess = $this->UserModel->update_password($id, $passwordNew, $users['password'], $users['last_password_one'], $users['last_password_two']);
                        } else {
                            $beSentDataset['error'] = '新密碼不相符';
                            $this->load->view('/user/update_password', $beSentDataset);
                        }
                    } else {
                        $beSentDataset['error'] = '舊密碼不相符';
                        $this->load->view('/user/update_password', $beSentDataset);
                    }

                    if ($users && $isExecuteSuccess) {
                        $beSentDataset['success'] = '新增成功';
                        redirect('user/logout');
                    } else {
                        $beSentDataset['error'] = '新增失敗';
                    }

                    $users = $id ? $this->UserModel->get_by_id($id)->row_array() : null;
                    $beSentDataset['users'] = $users;
                } else {
                    $beSentDataset['error'] = '密碼需包含英文字母大寫、英文字母小寫與數字並長度大於8';
                }
            }

            $this->load->view('/user/update_password', $beSentDataset);
        }
    }

    public function contact_us()
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport ? $passport['userTitle'] : null;
        $current_role = $passport ? $passport['role'] : null;
        $accept_role = array(1, 2, 3, 4, 5, 6, 8, 9);
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '聯絡我們',
                'url' => '/user/account_manage_table',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'password' => null,
                'updatePwd' => null
            );

            $this->load->view('/user/contact_us', $beSentDataset);
        } else {
            $beSentDataset = array(
                'title' => '聯絡我們',
                'url' => '/user/account_manage_table',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'password' => null,
                'updatePwd' => null
            );

            $this->load->view('/user/contact_us', $beSentDataset);
        }
    }

    public function audit_table($accountGroup = null, $county = 0,  $account = null, $startTime = null, $endTime = null) 
    {
      $passport = $this->session->userdata('passport');
      $userTitle = $passport ? $passport['userTitle'] : null;
      $current_role = $passport ? $passport['role'] : null;
      $accept_role = array(1, 8, 9);
      if (in_array($current_role, $accept_role)) {
        $statuses = $this->MenuModel->get_by_form_and_column('audit', 'status');
        $accountGroups = $this->MenuModel->get_by_form_and_column('messager', 'group');
        $ydaGroupNo = $this->MenuModel->get_no_resource_by_content('青年發展署', 'messager')->no;
        $countyGroupNo = $this->MenuModel->get_no_resource_by_content('承辦縣市', 'messager')->no;
        $organizationGroupNo = $this->MenuModel->get_no_resource_by_content('執行機關', 'messager')->no;
        $counselorGroupNo = $this->MenuModel->get_no_resource_by_content('輔導員', 'messager')->no;
        $counties = $this->CountyModel->get_all();
        $accounts = null;
        if($accountGroup == $ydaGroupNo) {
          $accounts = $this->UserModel->get_yda_user();
        } elseif ($accountGroup == $countyGroupNo) {
          $accounts = $this->UserModel->get_county_user_by_county($county);
        } elseif ($accountGroup == $organizationGroupNo) {
          $accounts = $this->UserModel->get_organization_user_by_county($county);
        } elseif ($accountGroup == $counselorGroupNo) {
          $accounts = $this->UserModel->get_counselor_user_by_county($county);
        }

        $logs = null;
        
        $beSentDataset = array(
          'title' => '稽查',
          'url' => '/user/audit_table/',
          'role' => $current_role,
          'userTitle' => $userTitle,
          'password' => $passport['password'],
          'security' => $this->security,
          'accountGroups' => $accountGroups,
          'accountGroup' => $accountGroup,
          'counties' => $counties,
          'ydaGroupNo' => $ydaGroupNo,
          'county' => $county,
          'account' => $account,
          'accounts' => $accounts,
          'logs' => $logs,
          'startTime' => $startTime,
          'endTime' => $endTime,
          'updatePwd' => $passport['updatePwd'],
          'statuses' => $statuses
        );

        $startTime = $this->security->xss_clean($this->input->post('startTime'));
        $endTime = $this->security->xss_clean($this->input->post('endTime'));

        $id =  $account;
        $auditId = $passport['id'];
        $status = $this->security->xss_clean($this->input->post('status'));
        $note = $this->security->xss_clean($this->input->post('note'));

        if($startTime && $endTime) {
          $logs = $this->DblogModel->get_log($account, $startTime, $endTime);
          $beSentDataset['logs'] = $logs;
          $beSentDataset['startTime'] = $startTime;
          $beSentDataset['endTime'] = $endTime;

          if (isset($_POST['save'])) {
            if ($status && $note) {
                $isExecuteSuccess = $this->AuditModel->create_one($id, $auditId, $status, $startTime, $endTime, $note);
                redirect('user/audit_record_table');
            }

          }
        }

        $this->load->view('/user/audit_table', $beSentDataset);
      } 
    }

    public function audit_record_table()
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(1,8, 9);
        if (in_array($current_role, $accept_role)) {

            $audits = $this->AuditModel->get_by_all();
            $statuses = $this->MenuModel->get_by_form_and_column('audit', 'status');
           
            $beSentDataset = array(
                'title' => '稽查清單',
                'url' => '/user/audit_table',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'audits' => $audits,
                'statuses' => $statuses,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $this->load->view('/user/audit_record_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
}
