<?php
class Review extends CI_Controller
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
        $this->load->model('MemberModel');
        $this->load->model('CaseAssessmentModel');
        $this->load->model('ReviewModel');
        $this->load->model('CountyContactModel');
        $this->load->model('MonthMemberTempCounselingModel');
        $this->load->model('CounselorServingMemberModel');
        $this->load->model('CounselorServingMemberUpdateModel');
        $this->load->model('UserModel');
        $this->load->model('UserTempModel');
        $this->load->model('YouthModel');
        $this->load->model('SeasonalReviewModel');
    }

    public function review_table()
    {
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $accept_role = array(3,4);
        if (in_array($current_role, $accept_role)) {
            $county = $passport['county'];
            $reviews = $county ? $this->ReviewModel->get_by_county($county, $current_role) : $this->ReviewModel->get_by_yda();
            $statuses = $this->MenuModel->get_by_form_and_column('review', 'status');
            
            $statusAgree = $this->MenuModel->get_no_resource_by_content('批准', 'review')->no;
            $statusWaiting = $this->MenuModel->get_no_resource_by_content('等待批准中', 'review')->no;
            $statusDisagree = $this->MenuModel->get_no_resource_by_content('未批准', 'review')->no;

            $reviewsAgree = $this->ReviewModel->get_by_status($statusAgree, $county, $current_role);
            $reviewsWaiting = $this->ReviewModel->get_by_status($statusWaiting, $county, $current_role);
            $reviewsDisagree = $this->ReviewModel->get_by_status($statusDisagree, $county, $current_role);
            
            $beSentDataset = array(
                'title' => '審核清單',
                'url' => '/review/review',
                'role' => $current_role,
                'userTitle' => $userTitle,
                'reviewsAgree' => $reviewsAgree,
                'reviewsWaiting' => $reviewsWaiting,
                'reviewsDisagree' => $reviewsDisagree,
                'statuses' => $statuses,
                'password' => $passport['password'],
                'updatePwd' => $passport['updatePwd']
            );

            $this->load->view('/review/review_table', $beSentDataset);
        } else {
            redirect('user/login');
        }
    }

    public function review($no = null)
    {
        valid_roles(array(3,4));
        $passport = $this->session->userdata('passport');
        $current_role = $passport['role'];
        $userTitle = $passport['userTitle'];
        $county = $passport['county'];

        $statuses = $this->MenuModel->get_by_form_and_column('review', 'status');
        $reviews = $no ? $this->ReviewModel->get_by_no($no) : null;
        if($reviews) {
          if($county != $reviews->county) redirect('user/login');
        }

        $statusAgree = $this->MenuModel->get_no_resource_by_content('批准', 'review')->no;
        $statusWaiting = $this->MenuModel->get_no_resource_by_content('等待批准中', 'review')->no;

        $beSentDataset = array(
            'title' => '審核',
            'url' => '/review/review/' . $no,
            'role' => $current_role,
            'userTitle' => $userTitle,
            'reviews' => $reviews,
            'security' => $this->security,
            'statuses' => $statuses,
            'statusWaiting' => $statusWaiting,
            'organizationName' => null,
            'password' => $passport['password'],
            'updatePwd' => $passport['updatePwd']
        );

        if ($reviews->form_name == 'case_assessment') {
            $caseAssessments = $reviews->form_no ? $this->CaseAssessmentModel->get_by_member_temp($reviews->form_no) : null;
            $counselors = $this->UserModel->get_counselor_by_county($county);

            $beSentDataset['caseAssessments'] = $caseAssessments;
            $beSentDataset['counselors'] = $counselors;
        } elseif ($reviews->form_name == 'counselor_users') {
            $users = $reviews->form_no ? $this->UserTempModel->get_by_no($reviews->form_no) : null;
            $countyName = $this->CountyModel->get_code_by_no($reviews->county)->name;
            if ($users->organization) {
                $organizationName = $this->OrganizationModel->get_name_by_no($users->organization)->name;
                $beSentDataset['organizationName'] = $organizationName;
            }
            $beSentDataset['users'] = $users;
            $beSentDataset['countyName'] = $countyName;
        } elseif ($reviews->form_name == 'update_usable') {
            $userUsable = $reviews->form_no ? $this->UserModel->get_by_id_for_update_usable($reviews->form_no) : null;
            $beSentDataset['userUsable'] = $userUsable;
            $beSentDataset['usable'] = $reviews->update_value;
        } elseif($reviews->form_name == 'end_youth') {
            $youths = $this->YouthModel->get_by_no($reviews->form_no);
            $seasonalReviews = $this->SeasonalReviewModel->get_by_youth($reviews->form_no);
            $trends = $this->MenuModel->get_by_form_and_column_order('seasonal_review', 'trend');
            $beSentDataset['youths'] = $youths;
            $beSentDataset['seasonalReviews'] = $seasonalReviews;
            $beSentDataset['trends'] = $trends;
        } elseif($reviews->form_name == 'reopen_youth') {
          $youths = $this->YouthModel->get_by_no($reviews->form_no);
          $seasonalReviews = $this->SeasonalReviewModel->get_by_youth($reviews->form_no);
          $trends = $this->MenuModel->get_by_form_and_column_order('seasonal_review', 'trend');
          $beSentDataset['youths'] = $youths;
          $beSentDataset['seasonalReviews'] = $seasonalReviews;
          $beSentDataset['trends'] = $trends;
        } elseif($reviews->form_name == 'transfer_youth') {
          $youths = $this->YouthModel->get_by_no($reviews->form_no);
          $seasonalReviews = $this->SeasonalReviewModel->get_by_youth($reviews->form_no);
          $trends = $this->MenuModel->get_by_form_and_column_order('seasonal_review', 'trend');
          $counties = $this->CountyModel->get_all();
          $preReviews = $this->ReviewModel->get_by_youth_pre_county('transfer_youth', $reviews->form_no);
          $preCounty = 0;
          foreach($preReviews as $value) {
            $preCounty = $value['county'];
          }

          $beSentDataset['youths'] = $youths;
          $beSentDataset['seasonalReviews'] = $seasonalReviews;
          $beSentDataset['trends'] = $trends;
          $beSentDataset['counties'] = $counties;
          $beSentDataset['preCounty'] = $preCounty;
        }

        $status = $this->security->xss_clean($this->input->post('status'));
        $note = $this->security->xss_clean($this->input->post('note'));
        $reviewer = $passport['id'];

        if (empty($note)) {
            return $this->load->view('/review/review', $beSentDataset);
        } else {
            foreach ($statuses as $i) {
                if ($i['no'] == $status) {
                    $statusText = $i['content'];
                }
            }
            $isExecuteSuccess = $this->ReviewModel->update_one(
                $status, $reviewer, $note, $no);

            if ($isExecuteSuccess) {

                if ($reviews->form_name == 'case_assessment') {
                    $recipientUser = $this->UserModel->get_by_counselor($reviews->update_value);
                    $recipient = $recipientUser->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】輔導員更換審核結果通知';
                    $content = '<p>' . $recipientUser->name . ' 君 您好:</p>'
                    . '<p>有關您更換輔導員申請結果為 :' . $statusText . ' </p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipient, $title, $content);

                } elseif ($reviews->form_name == 'counselor_users') {
                    $recipient = $users->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】申請帳號審核結果通知';

                    $successContent = ($status == $statusAgree) ? '<p>帳號為 :' . $users->id . '</p>'
                    . '<p>密碼為 : 000000 </p>'
                    . '<p>登入後請先更改密碼，並留意須遵守設定限制。</p>' : '';

                    $content = '<p>' . $users->name . ' 君 您好:</p>'
                    . '<p>有關您申請帳號申請結果為 :' . $statusText . ' </p>'
                    . $successContent
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipient, $title, $content);
                } elseif ($reviews->form_name == 'update_usable') {
                    $recipient = $userUsable->email;
                    $title = '【教育部青年發展署雙青計畫行政系統】申請更改帳號狀態審核結果通知';

                    $content = '<p>' . $userUsable->name . ' 君 您好:</p>'
                    . '<p>有關您的帳號狀態申請結果為 :' . $statusText . ' </p>'
                    . '<p>祝 平安快樂</p><p></p>'
                    . '<p>教育部青年發展署雙青計畫行政系統</p>'
                    . '<p>' . date('Y-m-d') . '</p>'
                        . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                    //api_send_email_temp($recipient, $title, $content);
                } elseif ($reviews->form_name == 'end_youth') {
                  $recipientUser = $this->UserModel->get_counselor_by_county($reviews->county);
                  foreach ($recipientUser as $value) {
                      $recipient = $value['email'];
                      $title = '【教育部青年發展署雙青計畫行政系統】青少年結案審核結果通知';
                      $content = '<p>' . $recipientUser->name . ' 君 您好:</p>'
                      . '<p>有關您青少年結案申請結果為 :' . $statusText . ' </p>'
                      . '<p>祝 平安快樂</p><p></p>'
                      . '<p>教育部青年發展署雙青計畫行政系統</p>'
                      . '<p>' . date('Y-m-d') . '</p>'
                      . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                      //api_send_email_temp($recipient, $title, $content);
                  }
                } elseif ($reviews->form_name == 'reopen_youth') {
                  $recipientUser = $this->UserModel->get_counselor_by_county($reviews->county);
                  foreach ($recipientUser as $value) {
                      $recipient = $value['email'];
                      $title = '【教育部青年發展署雙青計畫行政系統】青少年復案審核結果通知';
                      $content = '<p>' . $recipientUser->name . ' 君 您好:</p>'
                      . '<p>有關您青少年復案審申請結果為 :' . $statusText . ' </p>'
                      . '<p>祝 平安快樂</p><p></p>'
                      . '<p>教育部青年發展署雙青計畫行政系統</p>'
                      . '<p>' . date('Y-m-d') . '</p>'
                      . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                      //api_send_email_temp($recipient, $title, $content);
                  }
                } elseif ($reviews->form_name == 'transfer_youth') {

                  if ($reviews->update_value == $county) {
                      $recipientUser = $this->UserModel->get_counselor_by_county($preCounty);
                      foreach ($recipientUser as $value) {
                          $recipient = $value['email'];
                          $title = '【教育部青年發展署雙青計畫行政系統】青少年轉介審核結果通知';
                          $content = '<p>' . $recipientUser->name . ' 君 您好:</p>'
                      . '<p>有關您青少年轉介申請結果為 :' . $statusText . ' </p>'
                      . '<p>祝 平安快樂</p><p></p>'
                      . '<p>教育部青年發展署雙青計畫行政系統</p>'
                      . '<p>' . date('Y-m-d') . '</p>'
                      . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                          //api_send_email_temp($recipient, $title, $content);
                      }

                      $countyContractorUser = $this->UserModel->get_by_county_contractor($preCounty);


                      $recipient = $countyContractorUser->email;
                      $title = '【教育部青年發展署雙青計畫行政系統】青少年轉介審核結果通知';
                      $content = '<p>' . $countyContractorUser->name . ' 君 您好:</p>'
                  . '<p>有關您青少年轉介申請結果為 :' . $statusText . ' </p>'
                  . '<p>祝 平安快樂</p><p></p>'
                  . '<p>教育部青年發展署雙青計畫行政系統</p>'
                  . '<p>' . date('Y-m-d') . '</p>'
                  . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

                      //api_send_email_temp($recipient, $title, $content);

                      //$ydaSupportUser = $this->UserModel->get_latest_yda_support();



                  }
                }

                if ($status == $statusAgree) {
                    if ($reviews->form_name == 'case_assessment') {
                        $isUpdateCaseTemp = $this->CaseAssessmentModel->update_temp_counselor_by_no($reviews->update_value, $reviews->form_no);
                        $isUpdateCase = $this->CaseAssessmentModel->update_counselor_by_no($reviews->update_value, $reviews->form_no);
                        $isUpdateMember = $this->MemberModel->update_counselor_by_no($reviews->form_no, $reviews->update_value);
                        $isCreateServing = $this->CounselorServingMemberModel->create_counselor_serving_member($reviews->update_value, $caseAssessments->member);
                        $isUpdateServing = $this->CounselorServingMemberUpdateModel->update_counselor_serving_member($caseAssessments->counselor, $caseAssessments->member);
                    } elseif ($reviews->form_name == 'counselor_users') {
                        
                        $data = [];
                        $data['id'] = $users->id;
                        $data['password'] = $users->password;
                        $data['name'] = $users->name;
                        $data['manager'] = $users->manager;
                        $data['yda'] = $users->yda;
                        $data['county'] = $users->county;
                        $data['organization'] = $users->organization;
                        $data['counselor'] = $users->counselor;
                        $data['youth'] = $users->youth;
                        $data['email'] = $users->email;
                        $data['line'] = $users->line;
                        $isCreateUser = $this->UserModel->create_one($data);
                    } elseif ($reviews->form_name == 'update_usable') {
                        $isUpdateSuccess = $this->UserModel->update_by_id($reviews->form_no, $reviews->update_value);
                    } elseif($reviews->form_name == 'end_youth') {
                        $isUpdateSuccess = $this->YouthModel->update_is_end_by_no($reviews->update_value, $reviews->form_no);
                    } elseif($reviews->form_name == 'reopen_youth') {
                      $isUpdateSuccess = $this->YouthModel->update_is_end_by_no($reviews->update_value, $reviews->form_no);
                    } elseif($reviews->form_name == 'transfer_youth') {
                      if($reviews->update_value == $county){
                        $isUpdateSuccess = $this->YouthModel->update_county_by_no($reviews->update_value, $reviews->form_no);
                      } else {
                        $isExecuteSuccess = $this->ReviewModel->create_one(
                          'transfer_youth',
                          $reviews->form_no,
                          3,
                          $statusWaiting,
                          $reviews->reason,
                          'county',
                          $reviews->update_value,
                          $reviews->update_value
                        );
                      }
                  }
                }

                $beSentDataset['success'] = '新增成功';
                redirect('review/review_table');

            }
        }

        $this->load->view('/review/review', $beSentDataset);
    }
}
