<?php
class Check extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('CheckModel');
        $this->load->model('RunModel');
    }

    public function staff_apply_table($rid = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);

        $runID = $rid ? $rid : null;
        $activities = $this->RunModel->get_all_active();
        $application = $this->CheckModel->get_all_staff_application();
        $applications = $rid ? $this->CheckModel->get_staff_apply_by_runningID($rid) : null;

        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '工作人員申請活動',
                'url' => '/check/staff_apply_table/' . $rid,
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'runID' => $runID,
                'activities' => $activities,
                'application' => $application,
                'applications' => $applications
            );

            $this->load->view('/check/staff_apply_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function member_pay_status_table($rid = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);

        $runID = $rid ? $rid : null;
        $activities = $this->RunModel->get_all_active();
        $payment = $this->CheckModel->get_all_member_pay();
        $payments = $rid ? $this->CheckModel->get_pay_status_by_runningID($rid) : null;

        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '繳費狀態',
                'url' => '/check/member_pay_status_table/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'runID' => $runID,
                'activities' => $activities,
                'payment' => $payment,
                'payments' => $payments
            );
            $this->load->view('/check/member_pay_status_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function check_payment_status($rid = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);

        $info = $this->CheckModel->get_member_payment();
        $runID = $rid ? $rid : null;
        $activities = $this->RunModel->get_all_active();
        $payment = $this->CheckModel->get_all_member_pay();
        $payments = $rid ? $this->CheckModel->get_pay_status_by_runningID($rid) : null;

        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '繳費狀態',
                'url' => '/check/member_pay_status_table/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'runID' => $runID,
                'activities' => $activities,
                'payment' => $payment,
                'payments' => $payments
            );

            $data = array();
            $now = date('Y-m-d');
            foreach ($info as $i) {
                // 交易時間是空的 & 報名結束時間的一個禮拜後 -> 期限剩餘五天
                $time = date('Y-m-d H:i:s', strtotime($i['end_time']. '+1week'));
                
                if ($i['time'] == '' && $time <= date('Y-m-d H:i:s')) {
                    // $url = "https://letrun05.000webhostapp.com/letRun/sendReminderEmail.php";
                    $url = "http://running.im.ncnu.edu.tw/run_api/sendReminderEmail.php";
                    $data = array(
                        'member_ID' => $i['member_ID'],
                        'running_ID' => $i['running_ID'],
                        'email' => $i['email']
                    );

                    //open connection
                    $ch = curl_init();

                    //set the url, number of POST vars, POST data
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    //execute post
                    $result = curl_exec($ch);
                    // var_dump($result);
                    //close connection
                    curl_close($ch);

                    $isExecuteSuccess = $this->CheckModel->update_by_id($i['member_ID'], $now);
                }
            }
            $this->load->view('/check/member_pay_status_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
    
    public function gift_status_table($rid = null)
    {
        $passport = $this->session->userdata('passport');
        $userTitle = $passport['userTitle'];
        $current_role = $passport['role'];
        $accept_role = array(6);

        $runID = $rid ? $rid : null;
        $activities = $this->RunModel->get_all_active();
        $status = $this->CheckModel->get_all_gift_status();
        $statuses = $rid ? $this->CheckModel->get_gift_status_by_runningID($rid) : null;

        if (in_array($current_role, $accept_role)) {
            $beSentDataset = array(
                'title' => '兌換禮品狀態',
                'url' => '/check/gift_status_table/',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'current_role' => $current_role,
                'password' => $passport['password'],
                'runID' => $runID,
                'activities' => $activities,
                'status' => $status,
                'statuses' => $statuses
            );

            $this->load->view('/check/gift_status_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
}