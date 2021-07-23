<?php
class Run extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('RunModel');
        $this->load->model('FileModel');
    }
    public function run_active_table()
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        $activities = $this->RunModel->get_all_active();
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '路跑活動清單',
                'url' => '/run/run_active/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'activities' => $activities,
                'password' => $passport['password']
            );
            $this->load->view('/run/run_active_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    public function run_active($runNo = null) {
    
        $passport = $this->session->userdata('passport');
        $currentRole = $passport['role'];
        $userTitle = $passport['userTitle'];
    
        $acceptRole = array(6);
        $activity = $runNo ? $this->RunModel->get_active_by_id($runNo) : null;
    
        $beSentDataset = array(
          'title' => '路跑活動詳細內容',
          'url' => '/run/run_active/'.$runNo,
          'role' => $acceptRole,
          'userTitle' => $userTitle,
          'current_role' => $acceptRole,
          'activity' => $activity,
          'password' => $passport['password'],
          'security' => $this->security
        );
        
        $start_time="";
        $end_time="";
        $runName = $this->security->xss_clean($this->input->post('runName'));
        $dateRun = $this->security->xss_clean($this->input->post('dateRun'));
        $place = $this->security->xss_clean($this->input->post('place'));
        $startDate = $this->security->xss_clean($this->input->post('startDate'));
        $startTime = $this->security->xss_clean($this->input->post('startTime'));
        $endDate = $this->security->xss_clean($this->input->post('endDate'));
        $endTime = $this->security->xss_clean($this->input->post('endTime'));
        $bankCode = $this->security->xss_clean($this->input->post('bankCode'));
        $bankAccount = $this->security->xss_clean($this->input->post('bankAccount'));
        $start_time = $startDate.' '.$startTime.':00';
        $end_time = $endDate.' '.$endTime.':00';

        $config['upload_path'] = './files/photo';
        $config['allowed_types'] = 'jpg|png|pdf';
        $config['max_size'] = 5000;
        $config['max_width'] = 5000;
        $config['max_height'] = 5000;
        $config['encrypt_name'] = true;
        $this->load->library('upload', $config);
        // upload family diagram
        if ($this->upload->do_upload('photoFile')) {
            $fileMetaData = $this->upload->data();
            $file_no = $this->FileModel->create_one($fileMetaData['file_name'], $fileMetaData['orig_name']);
        }
    
        if (empty($runName)) return $this->load->view('/run/run_active', $beSentDataset);
        
        if (empty($activity)) {
          $isExecuteSuccess = $this->RunModel->create_one('A7',$runName, $dateRun, $place,$start_time,$end_time,$bankCode,$bankAccount,$file_no);
          $runNo = $isExecuteSuccess;
        } else {
          $isExecuteSuccess = $this->RunModel->update_by_id($runNo,$runName, $dateRun, $place,$start_time,$end_time,$bankCode,$bankAccount,$file_no);
        }
    
        if ($isExecuteSuccess) {
            print_r('yes');
        }else{
            print_r('yes');
        }
        if ($isExecuteSuccess) {
          $beSentDataset['success'] = '新增成功';
          $activities = $this->RunModel->get_all_active();
          $beSentDataset['activities'] = $activities;
          redirect('run/run_active_table');
        } else {
          $beSentDataset['error'] = '新增失敗';
        }
    
        $activity = $runNo ? $this->RunModel->get_by_no($runNo) : null;
        $beSentDataset['activity'] = $activity;
        // $beSentDataset['url'] = '/run/run_active/' . $runNo;
        $activities = $this->RunModel->get_all_active();
        $beSentDataset['activities'] = $activities;
        $this->load->view('/run/run_active_table', $beSentDataset);
           
    }
    public function workgroup($workgroupID = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        $activities = $this->RunModel->get_all_active();
        $workgroupInfo = $workgroupID ? $this->RunModel->get_workgrpup_byid($workgroupID):null;
        $workgroup_contents = $workgroupID ? $this->RunModel->get_workgroup_content_byid($workgroupID):null;
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '路跑工作組別',
                'url' => '/run/workgroup/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'security' => $this->security,
                'activities' => $activities,
                'workgroupInfo' => $workgroupInfo,
                'workContents' => $workgroup_contents
            );
            $workData=array();
            $runActive = $this->security->xss_clean($this->input->post('runActive'));
            // print_r($runActive);
            $temp['runActive'] = $runActive;
            $workgroupName = $this->security->xss_clean($this->input->post('workgroupName'));
            $temp['workgroupName'] = $workgroupName;
            // print_r($workgroupName);
            
            if(empty($runActive)){
                return $this->load->view('/run/workgroup', $beSentDataset);
            }else{
                $workgroups = array('workList', 'assemblyTime', 'assemblyPlace', 'maximum_number');
                foreach ($workgroups as $column) {
                    // $workData[$column] = $this->input->post($column) ? implode(",", $this->input->post($column)) : 0;
                    $temp[$column] = $this->security->xss_clean($this->input->post($column)) ? $this->security->xss_clean($this->input->post($column)):'';
                }
                if(!empty($temp)){
                    array_push($workData,$temp);
                    echo $i['runActive'];
                    echo $i['workgroupName'];
                    echo $i['workList'];
                    echo $i['assemblyTime'];
                    echo $i['assemblyPlace'];
                    echo $i['peoples'];
                    $isExecuteSuccess = $this->RunModel->create_workgroup($workData['runActive'],$workData['workgroupName'],$workData['workList'],$workData['assemblyTime'],$workData['assemblyPlace'],$workData['peoples']);
                    // $isExecuteSuccess = $this->RunModel->create_workgroup($workData['runActive'],$workData['workgroupName'],$workData['workList'],$workData['assemblyTime'],$workData['assemblyPlace'],$workData['peoples']);
                }
                if(!empty($workData)){
                    // echo $workData[0]['workList'];
                }
                $beSentDataset['workData'] =$workData;
                $this->load->view('/run/workgroup', $beSentDataset);
            }
        } else {
            redirect('user/login');
        }
    }
    public function workgroup_table()
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        $workgroups = $this->RunModel->get_all_workgrpup();
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '工作組別',
                'url' => '/run/workgroup/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'workgroups' => $workgroups
            );

            $this->load->view('/run/workgroup_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    public function workcontent_table($runNo = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        $runID = $runNo ? $runNo : null;
        $activities = $this->RunModel->get_all_active();
        $workgroups = $this->RunModel->get_all_workgrpup();
        $activity = $runNo ? $this->RunModel->get_active_by_id($runNo) : null;
        $workcontents = $runNo ? $this->RunModel->get_workcontents_by_id($runNo) : null;
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '工作項目',
                'url' => '/run/workcontent_table/'.$runNo,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'workgroups' => $workgroups,
                'activities' => $activities,
                'workcontents' => $workcontents,
                'runID' => $runID
            );

            $this->load->view('/run/workcontent_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    public function workcontent($runNo = null,$workID = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];

        $accept_role = array(6);

        $activities = $this->RunModel->get_all_active(); //下拉式選單用
        $activity = $runNo ? $this->RunModel->get_active_by_id($runNo) : null; //顯示當前的路跑
        $activity_work = $runNo ? $this->RunModel->get_active_work_by_id($runNo,$workID) : null; //顯示當前的路跑
        
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '工作項目表單',
                'url' => '/run/workcontent/'.$runNo.'/'.$workID,
                // 'url' => '/run/workcontent/'.$runNo.'/'.$workID,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'activities' => $activities,
                'activity' => $activity,
                'activity_work' => $activity_work,
                'runNo' => $runNo,
                'security' => $this->security
            );
            $runActive = $this->security->xss_clean($this->input->post('runActive'));
            $place = $this->security->xss_clean($this->input->post('place'));
            $content = $this->security->xss_clean($this->input->post('contents'));
            
            if (empty($runActive)) return $this->load->view('/run/workcontent', $beSentDataset);
            
            if (empty($activity)) {
                $isExecuteSuccess = $this->RunModel->create_work($runActive, $place, $content);
                $workID = $isExecuteSuccess;

            }else{
                $isExecuteSuccess = $this->RunModel->update_work($workID,$runActive, $place, $content);
                $runNo = $runActive;
            }
            
            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
            } else {
                $beSentDataset['error'] = '新增失敗';
            }
            $activity_work = $runNo ? $this->RunModel->get_active_work_by_id($runNo,$workID) : null;
            $activity = $runNo ? $this->RunModel->get_active_by_id($runNo) : null; //顯示當前的路跑
            // print_r($activity->name);
            $beSentDataset['activity_work'] = $activity_work;
            $beSentDataset['activity'] = $activity;
            $beSentDataset['runNo'] = $runActive;
            $beSentDataset['url'] = '/run/workcontent/'. $runActive.'/'.$workID;
            $this->load->view('/run/workcontent', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    public function rungroup_gift_table()
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '路跑組別 & 禮品',
                'url' => '/run/rungroup_gift_table/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password']
            );

            $this->load->view('/run/rungroup_gift_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    public function rungroup_gift($rungroupNo = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '路跑禮品表單',
                'url' => '/run/rungroup_gift/'.$rungroupNo,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password']
            );

            $this->load->view('/run/rungroup_gift', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    public function pass_point_table($no = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '路跑經過點',
                'url' => '/run/pass_point/'.$no,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password']
            );

            $this->load->view('/run/pass_point_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    public function pass_point($no = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '路跑經過點表單',
                'url' => '/run/pass_point/'.$no,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password']
            );

            $this->load->view('/run/pass_point', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    public function route_table($no = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '路跑路線',
                'url' => '/run/route/'.$no,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password']
            );

            $this->load->view('/run/route_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    public function route($no = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '路跑路線',
                'url' => '/run/route/'.$no,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password']
            );

            $this->load->view('/run/route', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function print_join_proof()
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '列印參賽證明',
                'url' => '/run/print_join_proof/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password']
            );

            $this->load->view('/run/print_join_proof', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function dynamic_position_graph()
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '動態位置圖表',
                'url' => '/run/dynamic_position_graph/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password']
            );

            $this->load->view('/run/dynamic_position_graph', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
}