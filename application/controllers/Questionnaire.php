<?php
class Questionnaire extends CI_Controller
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
        $this->load->model('QuestionnaireModel');
        $this->load->model('ProblemModel');
        $this->load->model('AnswerModel');
    }

    public function counselor_questionnaire()
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(6);
        if (in_array($current_role, $accept_role)) {
            $id = $passport['id'];
            $organization = $passport['organization'];
            $county = $passport['county'];
            $project = $this->ProjectModel->get_latest_by_county($county)->no;
            $projects = $this->ProjectModel->get_by_no($project);
            $meetingTypeNo['modeOne'] = $this->MenuModel->get_no_resource_by_content('模式一:輔導會談', 'project')->no;
            $meetingTypeNo['modeTwo'] = $this->MenuModel->get_no_resource_by_content('模式二:輔導會談+生涯探索課程或活動', 'project')->no;
            $meetingTypeNo['modeThree'] = $this->MenuModel->get_no_resource_by_content('模式三:輔導會談+生涯探索課程或活動+工作體驗', 'project')->no;
            $selfProject = $this->MenuModel->get_no_resource_by_content('自辦', 'project')->no;

            if($projects->execute_way == $selfProject) {
              redirect('user/login');
            }

            if ($projects->execute_mode == $meetingTypeNo['modeOne']) {
                $questionnaireName = '110年度未就學未就業青少年關懷扶助計畫[模式一] 學生特質與輔導成效分析問卷（輔導員版）';
            } elseif ($projects->execute_mode == $meetingTypeNo['modeTwo']) {
                $questionnaireName = '110年度未就學未就業青少年關懷扶助計畫[模式二] 學生特質與輔導成效分析問卷（輔導員版）';
            } elseif ($projects->execute_mode == $meetingTypeNo['modeThree']) {
                $questionnaireName = '110年度未就學未就業青少年關懷扶助計畫[模式三] 學生特質與輔導成效分析問卷（輔導員版）';
            }

            $problems = $this->QuestionnaireModel->get_all_question($questionnaireName);
            $partOneProblems = $partTwoProblems = [];

            $answerList = $this->AnswerModel->get_answer_by_id($questionnaireName, $id);

            if ($answerList) {
                foreach ($answerList as $value) {
                    if ($value['title'] == '學生特質') {
                        array_push($partOneProblems, $value);
                    } elseif ($value['title'] == '自我成效評估') {
                        array_push($partTwoProblems, $value);
                    }
                }

            } else {
                foreach ($problems as $value) {
                    if ($value['title'] == '學生特質') {
                        array_push($partOneProblems, $value);
                    } elseif ($value['title'] == '自我成效評估') {
                        array_push($partTwoProblems, $value);
                    }
                }
            }

            $beSentDataset = array(
                'title' => $questionnaireName,
                'url' => '/questionnaire/counselor_questionnaire',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'security' => $this->security,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd'],
                'partOneProblems' => $partOneProblems,
                'partTwoProblems' => $partTwoProblems,
                'answerList' => $answerList
            );

            $answers = $this->input->post('answer') ? implode(",", $this->security->xss_clean($this->input->post('answer'))) : null;

            if ($answers) {
                $ansTwo = [];
                foreach ($partTwoProblems as $i) {
                    $ans = $this->security->xss_clean($this->input->post($i['no'] . 'answer'));
                    array_push($ansTwo, $ans);
                }

                $ansOne = explode(",", $answers);

                $isUpdateExecuteSuccess = $this->AnswerModel->update_one($id);
                if ($isUpdateExecuteSuccess) {
                    for ($i = 0; $i < count($partOneProblems); $i++) {
                        $isExecuteSuccess = $this->AnswerModel->create_one($partOneProblems[$i]['questionnaireNo'], $partOneProblems[$i]['no'], $ansOne[$i], $id);
                    }
                    for ($i = 0; $i < count($partTwoProblems); $i++) {
                        $isExecuteSuccess = $this->AnswerModel->create_one($partTwoProblems[$i]['questionnaireNo'], $partTwoProblems[$i]['no'], $ansTwo[$i], $id);
                    }
                }
                if ($isExecuteSuccess) {
                    $beSentDataset['success'] = '新增成功';
                } else {
                    $beSentDataset['error'] = '新增失敗';
                }
            }

            $problems = $this->QuestionnaireModel->get_all_question($questionnaireName);
            $partOneProblems = $partTwoProblems = [];

            $answerList = $this->AnswerModel->get_answer_by_id($questionnaireName, $id);

            if ($answerList) {
                foreach ($answerList as $value) {
                    if ($value['title'] == '學生特質') {
                        array_push($partOneProblems, $value);
                    } elseif ($value['title'] == '自我成效評估') {
                        array_push($partTwoProblems, $value);
                    }
                }

            } else {
                foreach ($problems as $value) {
                    if ($value['title'] == '學生特質') {
                        array_push($partOneProblems, $value);
                    } elseif ($value['title'] == '自我成效評估') {
                        array_push($partTwoProblems, $value);
                    }
                }
            }

            $beSentDataset['partOneProblems'] = $partOneProblems;
            $beSentDataset['partTwoProblems'] = $partTwoProblems;
            $beSentDataset['answerList'] = $answerList;

            $this->load->view('/questionnaire/counselor_questionnaire', $beSentDataset);
        } else {
            redirect('user/login');
        }

    }

}
