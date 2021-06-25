<?php
class Messager extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('CountyModel');
        $this->load->model('OrganizationModel');
        $this->load->model('ProjectModel');
        $this->load->model('MenuModel');
        $this->load->model('CounselingMemberCountReportModel');
        $this->load->model('CompletionModel');
        $this->load->model('MessagerModel');
        $this->load->model('UserModel');
    }

    public function messager($no = null)
    {
        valid_roles(array(1,8));
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $messagers = $no ? $this->MessagerModel->get_by_no($no) : null;
        $types = $this->MenuModel->get_by_form_and_column('messager', 'type');
        $receiveGroups = $this->MenuModel->get_by_form_and_column('messager', 'group');

        $ydaGroupNo = $this->MenuModel->get_no_resource_by_content('青年發展署', 'messager')->no;
        $countyGroupNo = $this->MenuModel->get_no_resource_by_content('承辦縣市', 'messager')->no;
        $organizationGroupNo = $this->MenuModel->get_no_resource_by_content('執行機關', 'messager')->no;
        $counselorGroupNo = $this->MenuModel->get_no_resource_by_content('輔導員', 'messager')->no;

        $beSentDataset = array(
            'title' => '新增訊息',
            'url' => '/messager/messager/' . $no,
            'role' => $current_role,
            'userTitle' => $userTitle,
            'types' => $types,
            'receiveGroups' => $receiveGroups,
            'messagers' => $messagers,
            'security' => $this->security,
            'password' => $passport['password'],
            'updatePwd' => $passport['updatePwd']
        );

        $type = $this->security->xss_clean($this->input->post('type'));
        $content = $this->security->xss_clean($this->input->post('content'));
        $announcer = $passport['id'];
        $receiveGroup = null;
        $isView = $this->security->xss_clean($this->input->post('isView'));
        $isEmail = $this->security->xss_clean($this->input->post('isEmail'));
        $receiveGroup = $this->input->post('receiveGroup') ? implode(",", $this->input->post('receiveGroup')) : null;

        if (empty($content)) {
            return $this->load->view('messager', $beSentDataset);
        }

        if (empty($messagers)) {
          $isExecuteSuccess = $this->MessagerModel->create_one(
            $type, $content, $announcer, $receiveGroup, $isView, $isEmail
          );
          $no = $isExecuteSuccess;
        } else {
          $isExecuteSuccess = $this->MessagerModel->update_by_no(
            $type, $content, $announcer, $receiveGroup, $isView, $isEmail, $no
          );
        }

        if($isEmail) {
          
          foreach($types as $i) {
            if($type == $i['no']) $typeString = $i['content'];
          }
          $receiveGroup = explode(",", $receiveGroup);

          if( in_array($ydaGroupNo, $receiveGroup) == 1) {
            $ydaUsers = $this->UserModel->get_yda_user();

            foreach($ydaUsers as $value) {
              $data = array(
                'title'      => email_title_messager(),
                'email' =>  $value['email'],
                'content'    => email_content_messager($value['name'], $typeString, $content)
              );
              //api_send_email($data);            
            }
          }

          if( in_array($countyGroupNo, $receiveGroup) == 1) {
            $countyUsers = $this->UserModel->get_county_user();

            foreach($countyUsers as $value) {
              $data = array(
                'title'      => email_title_messager(),
                'email' =>  $value['email'],
                'content'    => email_content_messager($value['name'], $typeString, $content)
              );
              api_send_email($data);            
            }
          }

          if( in_array($organizationGroupNo, $receiveGroup) == 1) {
            $organizationUsers = $this->UserModel->get_organization_user();

            foreach($organizationUsers as $value) {
              $data = array(
                'title'      => email_title_messager(),
                'email' =>  $value['email'],
                'content'    => email_content_messager($value['name'], $typeString, $content)
              );
              api_send_email($data);            
            }
          }

          if( in_array($counselorGroupNo, $receiveGroup) == 1) {
            $counselorUsers = $this->UserModel->get_counselor_user();

            foreach($counselorUsers as $value) {
              $data = array(
                'title'      => email_title_messager(),
                'email' =>  $value['email'],
                'content'    => email_content_messager($value['name'], $typeString, $content)
              );
              api_send_email($data);            
            }
          }


        }


        if ($isExecuteSuccess) {
            $beSentDataset['success'] = '新增成功';
            redirect('messager/messager_table');
        } else {
            $beSentDataset['error'] = '新增失敗';
        }

        $messagers = $no ? $this->MessagerModel->get_by_no($no) : null;

        $beSentDataset['messagers'] = $messagers;
        $beSentDataset['url'] = '/messager/messager/' . $no;

        $this->load->view('messager', $beSentDataset);

    }

    public function messager_table()
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(1,8,9);
        if (in_array($current_role, $accept_role)) {

            $messagers = $this->MessagerModel->get_all();
            $types = $this->MenuModel->get_by_form_and_column('messager', 'type');
            $receiveGroups = $this->MenuModel->get_by_form_and_column('messager', 'receive_group');
            $beSentDataset = array(
                'title' => '訊息清單',
                'url' => '/messager/messager',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'messagers' => $messagers,
                'types' => $types,
                'receiveGroups' => $receiveGroups,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $this->load->view('messager_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
}
