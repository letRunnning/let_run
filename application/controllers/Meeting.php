<?php
class Meeting extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MenuModel');
        $this->load->model('YouthModel');
        $this->load->model('CaseAssessmentModel');
        $this->load->model('ProjectModel');
        $this->load->model('CountyModel');
        $this->load->model('MemberModel');
        $this->load->model('FileModel');
        $this->load->model('SeasonalReviewModel');
        $this->load->model('IndividualCounselingModel');
        $this->load->model('GroupCounselingModel');
        $this->load->model('GroupCounselingParticipantsModel');
        $this->load->model('CourseAttendanceModel');
        $this->load->model('WorkAttendanceModel');
        $this->load->model('EndCaseModel');
        $this->load->model('CompletionModel');
        $this->load->model('MonthReviewModel');
        $this->load->model('MeetingModel');
        $this->load->model('UserModel');
    }

    public function meeting_table($yearType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(2, 3, 6);
        if (in_array($current_role, $accept_role)) {
            $counselor = $passport['counselor'];
            $county = $passport['county'];
            $counselorInfo = $this->UserModel->get_counselor_user_by_county($county);

            $organization = $passport['organization'] ? $passport['organization'] : $counselorInfo[0]['organization'];

            $years = $this->MemberModel->get_year_by_organization($organization);

            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }

            $hasDelegation = ($yearType == date("Y") - 1911) ? '1' : '0';

            $meetings = $this->MeetingModel->get_by_organization($organization, $yearType);
            $meetingTypes = $this->MenuModel->get_by_form_and_column('meeting', 'meeting_type');

            $beSentDataset = array(
                'title' => '跨局處會議及預防性講座清單',
                'url' => '/meeting/meeting/',
                'role' => $current_role,
                'meetings' => $meetings,
                'meetingTypes' => $meetingTypes,
                'yearType' => $yearType,
                'years' => $years,
                'userTitle' => $userTitle,
                'hasDelegation' => $hasDelegation,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $this->load->view('/meeting/meeting_table', $beSentDataset);
        } else {
            redirect('user/login');
        }

    }

    public function meeting($no = null, $yearType = null)
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(2, 3, 6);
        if (in_array($current_role, $accept_role)) {
            $counselor = $passport['counselor'];
            $county = $passport['county'];
            $counselorInfo = $this->UserModel->get_counselor_user_by_county($county);

            $organization = $passport['organization'] ? $passport['organization'] : $counselorInfo[0]['organization'];

            $meetings = $no ? $this->MeetingModel->get_by_no($no) : null;
            if ($meetings) {
              if ($organization != $meetings->organization) {
                  redirect('user/login');
              }
            }
            $meetingTypes = $this->MenuModel->get_by_form_and_column('meeting', 'meeting_type');

            if ($yearType == null) {
                $yearType = date("Y") - 1911;
            }

            $hasDelegation = ($yearType == date("Y") - 1911) ? '1' : '0';

            $beSentDataset = array(
                'title' => '跨局處會議及預防性講座(執行當日更新、每月自動統計報表數據)',
                'url' => '/meeting/meeting/' . $no . '/' . $yearType,
                'role' => $current_role,
                'meetings' => $meetings,
                'meetingTypes' => $meetingTypes,
                'userTitle' => $userTitle,
                'hasDelegation' => $hasDelegation,
                'security' => $this->security,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $title = $this->security->xss_clean($this->input->post('title'));
            $meetingType = $this->security->xss_clean($this->input->post('meetingType'));
            $startTime = $this->security->xss_clean($this->input->post('startTime'));
            $chairman = $this->security->xss_clean($this->input->post('chairman'));
            $chairmanBackground = $this->security->xss_clean($this->input->post('chairmanBackground'));
            $note = $this->security->xss_clean($this->input->post('note'));
            $participants = $this->security->xss_clean($this->input->post('participants'));

            if (empty($title)) {
                return $this->load->view('/meeting/meeting', $beSentDataset);
            }

            if (empty($meetings)) {
                $isExecuteSuccess = $this->MeetingModel->create_one($title, $meetingType, $participants, $startTime, $chairman, $chairmanBackground, $note, $organization);

            } else {
                $isExecuteSuccess = $this->MeetingModel->update_by_no($title, $meetingType, $participants, $startTime, $chairman, $chairmanBackground, $note, $organization, $no);
            }

            if ($isExecuteSuccess) {
                $beSentDataset['success'] = '新增成功';
                redirect('meeting/meeting_table');
            } else {
                $beSentDataset['error'] = '新增失敗';
            }

            $this->load->view('/meeting/meeting', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }
}
