<?php
class Run extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('RunModel');
        $this->load->model('FileModel');
        $this->load->model('AssignModel');
        $this->load->model('MapModel');
        $this->load->model('BeaconPlacementModel');
        $this->load->model('GiftModel');
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
        $fileNo = $this->security->xss_clean($this->input->post('fileNo'));
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
        if (empty($runName)) return $this->load->view('/run/run_active', $beSentDataset);
        
        if ($this->upload->do_upload('file')) {
            $fileMetaData = $this->upload->data();
            $pfile = (site_url().'files/photo/');
            print_r($pfile);
            $file_no = $this->FileModel->create_one($fileMetaData['file_name'], $fileMetaData['orig_name'],$fileMetaData['file_path']);
            // $file_no = $this->FileModel->create_one($fileMetaData['file_name'], $fileMetaData['orig_name'],$pfile);
        }else{
                echo $this->upload->display_errors();
        }

        if (empty($activity)) {
            $temp = $this->RunModel->getActiveNumber();
            $runNums = substr($temp->running_ID,1,strlen($temp->running_ID));
            $RID = 'A'.($runNums+1);
            $isExecuteSuccess = $this->RunModel->create_one($RID,$runName, $dateRun, $place,$start_time,$end_time,$bankCode,$bankAccount,$file_no);
            $runNo = $isExecuteSuccess;
        } else {
            if($file_no){
                $isExecuteSuccess = $this->RunModel->update_by_id($runNo,$runName, $dateRun, $place,$start_time,$end_time,$bankCode,$bankAccount,$file_no);
            }
        }
        if ($isExecuteSuccess) {
          $beSentDataset['success'] = '新增成功';
          $activities = $this->RunModel->get_all_active();
          $beSentDataset['activities'] = $activities;
          redirect('run/run_active_table');
        } else {
          $beSentDataset['error'] = '新增失敗';
        }
    
        $activity = $runNo ? $this->RunModel->get_active_by_id($runNo) : null;
        $beSentDataset['activity'] = $activity;
        $activities = $this->RunModel->get_all_active();
        $beSentDataset['activities'] = $activities;
        $this->load->view('/run/run_active_table', $beSentDataset);
           
    }
    public function deletedata($no=null,$runNo=null,$workgroupID=null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $response = $no ? $this->RunModel->deleteAssignment($no) : null;
            $runID = $runNo ? $runNo : null;
            $activities = $this->RunModel->get_all_active();
            $workgroupInfo = $workgroupID ? $this->RunModel->get_workgrpup_byid($workgroupID):null;
            $assignments = $workgroupID ? $this->RunModel->get_assignment_content($workgroupID):null;
            $workcontents = $runNo ? $this->RunModel->get_workcontents_by_id($runNo) : null;
            $beSentDataset = array(
                'title' => '路跑工作組別',
                'url' => '/run/workgroup/'.$runNo.'/'.$workgroupID,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'security' => $this->security,
                'activities' => $activities,
                'workgroupInfo' => $workgroupInfo,
                'assignments' => $assignments,
                'runID' => $runID,
                'workcontents' => $workcontents,
                'workgroupID' => $workgroupID
            );
            
            $this->load->view('/run/workgroup', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    public function workgroup($runNo = null,$workgroupID = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        $runID = $runNo ? $runNo : null;
        $activities = $this->RunModel->get_all_active();
        $workgroupInfo = $workgroupID ? $this->RunModel->get_workgrpup_byid($workgroupID):null;
        $assignments = $workgroupID ? $this->RunModel->get_assignment_content($workgroupID):null;
        $workcontents = $runNo ? $this->RunModel->get_workcontents_by_id($runNo) : null;
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '路跑工作組別',
                'url' => '/run/workgroup/'.$runNo.'/'.$workgroupID,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'security' => $this->security,
                'activities' => $activities,
                'workgroupInfo' => $workgroupInfo,
                'assignments' => $assignments,
                'runID' => $runID,
                'workcontents' => $workcontents,
                'workgroupID' => $workgroupID
            );

            $runActive = $this->security->xss_clean($this->input->post('runActive'));
            $workgroupName = $this->security->xss_clean($this->input->post('workgroupName'));
            $leader = $this->security->xss_clean($this->input->post('leader'));
            $line = $this->security->xss_clean($this->input->post('line'));
            $assemblyPlace = $this->security->xss_clean($this->input->post('assemblyPlace'));
            $maximum_number = $this->security->xss_clean($this->input->post('maximum_number'));
            $workList = $this->security->xss_clean($this->input->post('workList[]'));
            $startDate = $this->security->xss_clean($this->input->post('startDate'));
            $startTime = $this->security->xss_clean($this->input->post('startTime'));
            $assemblyTime = $startDate.' '.$startTime.':00';

            if (empty($runActive)) return $this->load->view('/run/workgroup', $beSentDataset);
            
            $isExecuteSuccess_2=null;

            if(empty($workgroupInfo)){
                $isExecuteSuccess = $this->RunModel->create_workgroup($runID, $workgroupName,$leader,$line,$assemblyTime,$assemblyPlace,$maximum_number);
                $workgroupID = $isExecuteSuccess;
                if(!empty($isExecuteSuccess) && !empty($workList)){
                    foreach($workList as $value){
                        $isExecuteSuccess_2 = $this->AssignModel->create_assignment($value,$assemblyTime,$workgroupID);
                    }
                }
            }else{
                $isExecuteSuccess = $this->RunModel->update_workgroup($runID, $workgroupName,$leader,$line,$assemblyTime,$assemblyPlace,$maximum_number,$workgroupID);
                if($workList){
                    foreach($workList as $value){
                        $isExecuteSuccess_2 = $this->AssignModel->create_assignment($value,$assemblyTime,$workgroupID);
                    }
                }
            }


            if($isExecuteSuccess){
                if($isExecuteSuccess_2){
                    $beSentDataset['success'] = '新增成功';
                }else{
                    $beSentDataset['success'] = '組別新增成功，分派尚未';
                }
            }else{
                $beSentDataset['error'] = '新增失敗';
            }
            $workgroupInfo = $workgroupID ? $this->RunModel->get_workgrpup_byid($workgroupID):null;
            $assignments = $workgroupID ? $this->RunModel->get_assignment_content($workgroupID):null;
            $assignments = $workgroupID ? $this->RunModel->get_assignment_content($workgroupID):null;
            $beSentDataset['workgroupInfo'] = $workgroupInfo;
            $beSentDataset['assignments'] = $assignments;
            $beSentDataset['workContents'] = $assignments;
            $beSentDataset['url'] = '/run/workgroup/'.$runNo.'/'.$workgroupID;
        $this->load->view('/run/workgroup', $beSentDataset);
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
        $activities = $this->RunModel->get_all_active();
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '工作組別',
                'url' => '/run/workgroup/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'security' => $this->security,
                'activities' => $activities,
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
        $rungroups = $this->RunModel->get_running_group();
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '路跑組別 & 禮品',
                'url' => '/run/rungroup_gift_table/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'rungroups' => $rungroups
            );

            $this->load->view('/run/rungroup_gift_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    public function rungroup_gift($runNo = null,$groupName=null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        $runID = $runNo ? $runNo : null;
        $activities = $this->RunModel->get_all_active();
        // $groupName = base64_decode($groupName);
        $rungroupInfo = ($runNo&&$groupName) ? $this->RunModel->get_rungroup_byid($runNo,base64_decode($groupName)):null;
        $rungroupGift = ($runNo&&$groupName) ? $this->RunModel->get_rungroupGift_byid($runNo,base64_decode($groupName)):null;
        // print_r($rungroupGift);
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '路跑禮品表單',
                'url' => '/run/rungroup_gift/'.$runNo.'/'.($groupName),
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'security' => $this->security,
                'rungroupInfo' => $rungroupInfo,
                'activities' => $activities,
                'runNo' => $runNo,
                'rungroupGift'=> $rungroupGift,
                'groupName' => $groupName
            );
            $runActive = $this->security->xss_clean($this->input->post('runActive'));
            $rungroupName = $this->security->xss_clean($this->input->post('rungroupName'));
            $kilometers = $this->security->xss_clean($this->input->post('kilometers'));
            $maximum_number = $this->security->xss_clean($this->input->post('peoples'));
            $time = $this->security->xss_clean($this->input->post('assumbly_time'));
            $start_time = $this->security->xss_clean($this->input->post('start_time'));
            $end_time = $this->security->xss_clean($this->input->post('end_time'));
            $place = $this->security->xss_clean($this->input->post('assemblyPlace'));
            $amount = $this->security->xss_clean($this->input->post('price'));
            $giftName = $this->security->xss_clean($this->input->post('giftName'));
            

            if (empty($runActive)) return $this->load->view('/run/rungroup_gift', $beSentDataset);
            
            $config['upload_path'] = './files/photo';
            $config['allowed_types'] = 'jpg|png|pdf';
            $config['max_size'] = 5000;
            $config['max_width'] = 5000;
            $config['max_height'] = 5000;
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);
            
            // if (empty($runActive)) return $this->load->view('/run/rungroup_gift', $beSentDataset);
            
            $isExecuteSuccess_3=null;
            if(empty($rungroupInfo)){
                $isExecuteSuccess = $this->RunModel->create_rungroup($runActive, $rungroupName, $kilometers, $maximum_number, $start_time, $end_time, $amount, $place, $time);
                $rungroupID = $isExecuteSuccess;
                if($giftName){
                    if ($this->upload->do_upload('file')) {
                        $fileMetaData = $this->upload->data();
                        $pfile = (site_url().'files/photo/');
                        // print_r($pfile);
                        $file_no = $this->FileModel->create_one($fileMetaData['file_name'], $fileMetaData['orig_name'],$fileMetaData['file_path']);
                        // $file_no = $this->FileModel->create_one($fileMetaData['file_name'], $fileMetaData['orig_name'],$pfile);
                    }else{
                            echo $this->upload->display_errors();
                    }
                    if($file_no){
                        $temp = $this->RunModel->getGiftNumber();
                        $giftNums = substr($temp->gift_ID,1,strlen($temp->gift_ID));
                        $GID = 'G'.($giftNums+1);
                        $isExecuteSuccess3 = $this->GiftModel->create_gift($GID,$giftName,base64_decode($groupName),$runActive,$file_no);
                    }
                }
            }else{
                $isExecuteSuccess = $this->RunModel->update_rungroup($runNo, $rungroupName, $kilometers, $maximum_number, $start_time, $end_time, $amount, $place, $time);
                if($giftName){
                    if ($this->upload->do_upload('file')) {
                        $fileMetaData = $this->upload->data();
                        $pfile = (site_url().'files/photo/');
                        // print_r($pfile);
                        $file_no = $this->FileModel->create_one($fileMetaData['file_name'], $fileMetaData['orig_name'],$fileMetaData['file_path']);
                        // $file_no = $this->FileModel->create_one($fileMetaData['file_name'], $fileMetaData['orig_name'],$pfile);
                    }else{
                            echo $this->upload->display_errors();
                    }
                    if($file_no){
                        $temp = $this->RunModel->getGiftNumber();
                        $giftNums = substr($temp->gift_ID,1,strlen($temp->gift_ID));
                        $GID = 'G'.($giftNums+1);
                        $isExecuteSuccess3 = $this->GiftModel->create_gift($GID,$giftName,base64_decode($groupName),$runNo,$file_no);
                    }
                }
            }


            if($isExecuteSuccess){
                $beSentDataset['url']='/run/rungroup_gift/'. $runID.'/'.base64_encode($rungroupName);
                if($isExecuteSuccess_3){
                    $beSentDataset['success'] = '新增成功';
                }else{
                    $beSentDataset['success'] = '組別新增成功';
                }
            }else{
                $beSentDataset['url']='/run/rungroup_gift/'. $runID.'/'.base64_encode($rungroupName);
                $beSentDataset['error'] = '新增失敗';
            }
            $rungroupInfo = ($runID&&$rungroupName) ? $this->RunModel->get_rungroup_byid($runID,$rungroupName):null;
            $rungroupGift = ($runID&&$rungroupName) ? $this->RunModel->get_rungroupGift_byid($runID,$rungroupName):null;
            $beSentDataset['rungroupInfo']=$rungroupInfo;
            $beSentDataset['rungroupGift']=$rungroupGift;
            $beSentDataset['url']='/run/rungroup_gift/'. $runID.'/'.base64_encode($rungroupName);
            $this->load->view('/run/rungroup_gift', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    public function deletedata_gift($giftID=null,$groupName=null,$runNo=null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        // $groupName = base64_decode($groupName);    
        if (in_array($current_role, $accept_role)) {
            $response = ($giftID&&$groupName) ? $this->RunModel->deleteGift($giftID,base64_decode($groupName)) : null;
            $activities = $this->RunModel->get_all_active();
            $rungroupInfo = ($runNo&&$groupName) ? $this->RunModel->get_rungroup_byid($runNo,base64_decode($groupName)):null;
            $rungroupGift = ($runNo&&$groupName) ? $this->RunModel->get_rungroupGift_byid($runNo,base64_decode($groupName)):null;
            $beSentDataset = array(
                'title' => '路跑禮品表單',
                'url' => '/run/rungroup_gift/'.$runNo.'/'.$groupName,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'security' => $this->security,
                'rungroupInfo' => $rungroupInfo,
                'activities' => $activities,
                'runNo' => $runNo,
                'rungroupGift'=> $rungroupGift,
                'groupName' => $groupName
            );
            redirect('/run/rungroup_gift/'.$runNo.'/'.$groupName);
            // $this->load->view('/run/rungroup_gift', $beSentDataset);
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
        // $points = $this->RunModel->get_passing_point();
        $points = $this->RunModel->get_supply_location();
        $activities = $this->RunModel->get_all_active();
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '路跑補給站',
                'url' => '/run/pass_point/'.$no,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'points' => $points,
                'activities' => $activities
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
        $activities = $this->RunModel->get_all_active();
        // $point = $no ? $this->RunModel->get_passPoint_by_no($no) : null ;
        $point = $no ? $this->RunModel->get_supply_location_by_no($no) : null ;
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '路跑補給站表單',
                'url' => '/run/pass_point/'.$no,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'point' => $point,
                'security' => $this->security,
                'activities' => $activities
            );
            $runActive = $this->security->xss_clean($this->input->post('runActive'));
            $supply_name = $this->security->xss_clean($this->input->post('supply_name'));
            $longitude = $this->security->xss_clean($this->input->post('longitude'));
            $latitude = $this->security->xss_clean($this->input->post('latitude'));
            $supplies = $this->security->xss_clean($this->input->post('supplies'));
            
        
            if (empty($supply_name)) return $this->load->view('/run/pass_point', $beSentDataset);
            
            if (empty($point)) {
            $num = $this->RunModel->getPassNumber();
            $Number = substr(($num->supply_ID),1,strlen($num->supply_ID))+1;
            $passID = 'L'.$Number;
            // $isExecuteSuccess = $this->RunModel->create_pass_point($passID,$supply_name,$longitude, $latitude);
            $isExecuteSuccess = $this->RunModel->create_supply_location($passID,$supply_name,$longitude, $latitude,$runActive,$supplies);
            } else {
            // $isExecuteSuccess = $this->RunModel->update_pass_point($no,$supply_name,$longitude, $latitude);
            $isExecuteSuccess = $this->RunModel->update_supply_location($no,$supply_name,$longitude, $latitude,$runActive,$supplies);
            }

            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
                $points = $this->RunModel->get_supply_location();
                $beSentDataset['points'] = $points;
                redirect('run/pass_point_table');
            } else {
                $beSentDataset['error'] = '新增失敗';
            }

            $this->load->view('/run/pass_point_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    public function supplies_map($no = null){
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        $activity = $no? $this->RunModel->get_active_by_id($no):null;
        $activities = $this->RunModel->get_all_active();
        $supplies = $no ? $this->RunModel->get_supply_location_by_run($no) : null ;
        $data = null;
        if (in_array($current_role, $accept_role)) {
            if($supplies){
                $data = array();
                foreach($supplies as $i){
                    $array = array( 
                        'supply_ID' => $i['supply_ID'],
                        'running_ID' => $i['running_ID'],
                        'supply_name' => urlencode($i['supply_name']),
                        'supplies' => urlencode($i['detail']),
                        'longitude' => $i['longitude'], // 因為有中文所以要用 urlencode 去 encode
                        'latitude' => $i['latitude']
                    );
                    array_push($data, $array);
                }
                $data = urldecode(json_encode($data, JSON_PRETTY_PRINT));
            }
            $points = $this->RunModel->get_supply_location();
            $activities = $this->RunModel->get_all_active();
            $beSentDataset = array(
                'title' => '路跑補給站',
                'url' => '/run/supplies_map/'.$no,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'security' => $this->security,
                'points' => $points,
                'activities' => $activities,
                'supplies' => $supplies,
                'data' => $data,
                'activity' => $activity
            );

            $this->load->view('/run/supplies_map', $beSentDataset);
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
        $activities = $this->RunModel->get_all_active();
        $groups = $this->RunModel->get_all_activeGroup();
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '路跑路線',
                'url' => '/run/route/'.$no,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'groups' => $groups
            );
            

            $this->load->view('/run/route_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    public function route($no = null,$g_name = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        $activities = $this->RunModel->get_all_active();
        $activity = $no? $this->RunModel->get_active_by_id($no):null;
        $groups = $no? $this->RunModel->get_activeGroup_by_no($no):null;
        // $routes = $no? $this->RunModel->get_routes_by_no($no):null;
        $route = null;
        $data = null;
        if($no && $g_name){
            $route = $this->MapModel->get_route($no,base64_decode($g_name));
            $data = array();
            foreach($route as $i){
                $array = array( 
                    'running_ID' => $i['running_ID'],
                    'group_name' => urlencode($i['group_name']),
                    'detail' => urlencode($i['detail']),
                    'longitude' => $i['longitude'], // 因為有中文所以要用 urlencode 去 encode
                    'latitude' => $i['latitude'],
                );
                array_push($data, $array);
            }
            $data = urldecode(json_encode($data, JSON_PRETTY_PRINT));
        }
        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '路跑路線',
                'url' => '/run/route/'.$no.'/'.$g_name,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'runID' => $no,//指定路跑編號
                'activity' => $activity,//指定路跑
                'routes' => $route,//指定路跑的某一組的路線祥資經緯度
                'groups' => $groups,//指定路跑之其組別下拉式選單
                'security' => $this->security,
                'group_name' => base64_decode($g_name),//指定路跑指定組別之名稱
                'data' => $data, //該特定路跑之指定組別之路線詳細資料
                'activities' => $activities
            );
            $runActive = $this->security->xss_clean($this->input->post('runActive'));
            $detail = $this->security->xss_clean($this->input->post('detail'));
            $groupName = $this->security->xss_clean($this->input->post('groupName'));
            $longitude = $this->security->xss_clean($this->input->post('longitude'));
            $latitude = $this->security->xss_clean($this->input->post('latitude'));
            
        
            if (empty($groupName)) return $this->load->view('/run/route', $beSentDataset);
            
            // if (empty($point)) {
            
            $isExecuteSuccess = $this->RunModel->create_route_detail($runActive,$groupName,$detail,$longitude, $latitude);
            // } else {
            // $isExecuteSuccess = $this->RunModel->update_pass_point($no,$pass_name,$longitude, $latitude);
            // }

            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
                // $points = $this->RunModel->get_passing_point();
                $beSentDataset['url'] = '/run/route/'.$no.'/'.$g_name;
                $route = $this->MapModel->get_route($no,base64_decode($g_name));
                $data = array();
                foreach($route as $i){
                    $array = array( 
                        'running_ID' => $i['running_ID'],
                        'group_name' => urlencode($i['group_name']),
                        'detail' => urlencode($i['detail']),
                        'longitude' => $i['longitude'], // 因為有中文所以要用 urlencode 去 encode
                        'latitude' => $i['latitude']
                    );
                    array_push($data, $array);
                }
                $data = urldecode(json_encode($data, JSON_PRETTY_PRINT));
                $beSentDataset['routes'] = $route;
                $beSentDataset['data'] = $data;
                // $this->load->view('/run/route', $beSentDataset);
            } else {
                $beSentDataset['url'] = '/run/route/'.$no.'/'.$g_name;
                $beSentDataset['error'] = '新增失敗';
            }

            $this->load->view('/run/route', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    public function routeEdit($no = null,$g_name = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
        $activity = $no? $this->RunModel->get_active_by_id($no):null;
        $groups = $no? $this->RunModel->get_activeGroup_by_no($no):null;
        // $routes = $no? $this->RunModel->get_routes_by_no($no):null;
        $route = null;
        $data = null;
        if($no && $g_name){
            $route = $this->MapModel->get_route($no,base64_decode($g_name));
            $data = array();
            foreach($route as $i){
                $array = array( 
                    'no' => $i['no'],
                    'running_ID' => $i['running_ID'],
                    'group_name' => urlencode($i['group_name']),
                    'detail' => urlencode($i['detail']),
                    'longitude' => $i['longitude'], // 因為有中文所以要用 urlencode 去 encode
                    'latitude' => $i['latitude']
                );
                array_push($data, $array);
            }
            $data = urldecode(json_encode($data, JSON_PRETTY_PRINT));
        }
        
            $beSentDataset = array(
                'title' => '路跑路線',
                'url' => '/run/routeEdit/'.$no.'/'.$g_name,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'runID' => $no,//指定路跑編號
                'activity' => $activity,//指定路跑
                'routes' => $route,//指定路跑的某一組的路線祥資經緯度
                'groups' => $groups,//指定路跑之其組別下拉式選單
                'security' => $this->security,
                'group_name' => base64_decode($g_name),//指定路跑指定組別之名稱
                'data' => $data //該特定路跑之指定組別之路線詳細資料
            );
            // $runActive = $this->security->xss_clean($this->input->post('runActive'));
            $target = $this->security->xss_clean($this->input->post('target'));
            // print_r($target);
            
        
            if (empty($target)) return $this->load->view('/run/routeEdit', $beSentDataset);
            
            // if (empty($point)) {
            
            $isExecuteSuccess = $this->MapModel->delete_point($target);
            // } else {
            // $isExecuteSuccess = $this->RunModel->update_pass_point($no,$pass_name,$longitude, $latitude);
            // }

            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '刪除成功';
                // $points = $this->RunModel->get_passing_point();
                $beSentDataset['url'] = '/run/routeEdit/'.$no.'/'.$g_name;
                $route = $this->MapModel->get_route($no,base64_decode($g_name));
                $data = array();
                foreach($route as $i){
                    $array = array( 
                        'running_ID' => $i['running_ID'],
                        'group_name' => urlencode($i['group_name']),
                        'detail' => urlencode($i['detail']),
                        'longitude' => $i['longitude'], // 因為有中文所以要用 urlencode 去 encode
                        'latitude' => $i['latitude']
                    );
                    array_push($data, $array);
                }
                $data = urldecode(json_encode($data, JSON_PRETTY_PRINT));
                $beSentDataset['routes'] = $route;
                $beSentDataset['data'] = $data;
                // $this->load->view('/run/route', $beSentDataset);
            } else {
                $beSentDataset['url'] = '/run/routeEdit/'.$no.'/'.$g_name;
                $beSentDataset['error'] = '新增失敗';
            }

            $this->load->view('/run/routeEdit', $beSentDataset);
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

    public function dynamic_position_graph($rid = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);

        $runID = $rid ? $rid : null;
        $activities = $this->RunModel->get_all_active();
        $beaconPlacement = $this->BeaconPlacementModel->get_all_beacon_placement();
        $beaconPlacements = $rid ? $this->BeaconPlacementModel->get_beacon_placement_by_runningID($rid) : null;

        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '動態位置圖表',
                'url' => '/run/dynamic_position_graph/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'runID' => $runID,
                'activities' => $activities,
                'beaconPlacement' => $beaconPlacement,
                'beaconPlacements' => $beaconPlacements
            );

            $this->load->view('/run/dynamic_position_graph', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
}