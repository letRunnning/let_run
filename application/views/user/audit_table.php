<?php $this->load->view('templates/new_header');?>

<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">系統帳號管理</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/audit_record_table'); ?>" <?php echo $url == '/user/audit_record_table' ? 'active' : ''; ?>>稽查清單</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>

<div class="container" style="width:90%;">
  <div class="row">
    <div class="col-md-12">
      <h4 class="text-dark text-center"><?php echo $title ?></h4>
      <div class="card-content">
        <form action="<?php echo site_url($url . $accountGroup . '/' . $county . '/' . $account . '/' . $startTime . '/' . $endTime); ?>"
          method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />

        <!-- years -->
        <div class="col-10 m-2 mx-auto">
          <label>帳號群組</label>
          <div class="input-group">
            <select class="form-select" name="accountGroup" id="accountGroup" onchange="location = this.value;">
              <option disabled selected value>請選擇</option>
              <?php foreach ($accountGroups as $i) { ?>
                <option <?php echo ($accountGroup == ($i['no'])) ? 'selected' : '' ?>
                  value="<?php echo site_url($url . $i['no'] . '/' . $county . '/' . $account. '/' . $startTime . '/' . $endTime); ?>"><?php echo $i['content'] ?></option>
              <?php } ?>
            </select>
          </div>
          </div>

        <?php if ($accountGroup != $ydaGroupNo) :?>
         <!-- county -->
        <div class="col-10 m-2 mx-auto">
          <label>縣市</label>
          <div class="input-group">
            <select class="form-select" name="counties" id="counties" onchange="location = this.value;">
              <option disabled selected value>請選擇</option>
              <?php foreach ($counties as $i) { ?>
                <option <?php echo ($county == $i['no']) ? 'selected' : '' ?>
                  value="<?php echo site_url($url . $accountGroup . '/' . $i['no'] . '/' . $account. '/' . $startTime . '/' . $endTime); ?>"><?php echo $i['name'] ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <?php endif; ?>

        <div class="col-10 m-2 mx-auto">
          <label>帳號</label>
          <div class="input-group">
            <select class="form-select" name="account" id="account" onchange="location = this.value;">
              <option disabled selected value>請選擇</option>
              <?php foreach ($accounts as $i) { ?>
                <option <?php echo ($account == ($i['id'])) ? 'selected' : '' ?>
                  value="<?php echo site_url($url . $accountGroup . '/' . $county . '/'. $i['id']. '/' . $startTime . '/' . $endTime); ?>"><?php echo $i['id'] ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

         <div class="row">
            <div class="input-field col s10 offset-m2 m8">
              <input required type="text" id="formStartTime" name="startTime" class="datepicker" value="<?php echo $startTime ? $startTime : ""?>">
              <label for="formStartTime">開始時間*</label>
            </div>
          </div>


          <div class="row">
            <div class="input-field col s10 offset-m2 m8">
              <input required type="text" id="formEndTime" name="endTime" class="datepicker" value="<?php echo $endTime ? $endTime : ""?>">
              <label for="formEndTime">結束時間*</label>
            </div>
          </div>

          <div class="row">
            <div class="d-grid gap-2 col-2 mx-auto">
              <button class="btn btn-primary my-5" type="submit">送出</button>
            </div>
          </div>

          <?php if ($logs) :?>

            <table class="table table-hover text-center">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">帳號</th>
                  <th scope="col">時間</th>
                  <th scope="col">操作內容</th>
                  <th scope="col" style="width:50%;">操作函式</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($logs as $i) { ?>
                
                    <tr>
                      <td><?php echo $i['user']; ?></td>
                      <td><?php echo $i['time']; ?></td>
                      <td><?php 
                        if($i['function'] == 'user/index') echo '首頁';
                        elseif($i['function'] == 'user/forget_password') echo '忘記密碼';
                        elseif($i['function'] == 'user/logout') echo '登出';
                        elseif($i['function'] == 'user/create_yda_account') echo '建立計畫主持人帳號';
                        elseif($i['function'] == 'user/create_yda_support_account') echo '建立計畫支援人員帳號';
                        elseif($i['function'] == 'user/create_county_manager_account') echo '建立縣市主管帳號';
                        elseif($i['function'] == 'user/create_county_contractor_account') echo '建立縣市承辦人帳號';
                        elseif($i['function'] == 'user/create_county_contractor_account') echo '建立縣市主管帳號';
                        elseif($i['function'] == 'user/create_organization_manager_account') echo '建立機構主管帳號';
                        elseif($i['function'] == 'user/create_organization_contractor_account') echo '建立機構承辦人帳號';
                        elseif($i['function'] == 'user/create_counselor_account') echo '建立輔導員帳號';
                        elseif($i['function'] == 'user/account_manage_table') echo '系統帳號清單';
                        elseif($i['function'] == 'user/update_manage_usable') echo '停用使用者帳號';
                        elseif($i['function'] == 'user/user_info') echo '修改個人資料';
                        elseif($i['function'] == 'user/user_password') echo '修改個人密碼';
                        elseif($i['function'] == 'user/contact_us') echo '聯絡我們';
                        elseif($i['function'] == 'user/audit_table') echo '稽查';
                        elseif($i['function'] == 'user/audit_record_table') echo '稽查清單';
                        elseif($i['function'] == 'county/create_county') echo '新增縣市';
                        elseif($i['function'] == 'county/delegate_project_to_organization') echo '委託計畫執行機構';
                        elseif($i['function'] == 'county/county_contact_table') echo '縣市聯繫窗口清單';
                        elseif($i['function'] == 'county/county_contact') echo '新增縣市聯繫窗口';
                        elseif($i['function'] == 'course/get_expert_table_by_organization') echo '講師清單';
                        elseif($i['function'] == 'course/expert_list') echo '講師基本資料';
                        elseif($i['function'] == 'course/get_course_reference_table_by_organization') echo '課程參考清單(歷年資料)';
                        elseif($i['function'] == 'course/course_reference') echo '課程參考資料(歷年資料)';
                        elseif($i['function'] == 'course/get_course_table_by_organization') echo '課程開設清單(今年度資料)';
                        elseif($i['function'] == 'course/course') echo '課程開設表(今年度資料)';
                        elseif($i['function'] == 'course/get_course_attendance_table_by_organization') echo '課程時數清單(執行當日更新、每月自動統計報表數據)';
                        elseif($i['function'] == 'course/get_course_attendance_table_by_member') echo '課程時數清單(執行當日更新、每月自動統計報表數據)';
                        elseif($i['function'] == 'course/course_attendance') echo '課程時數表(執行當日更新、每月自動統計報表數據)';
                        elseif($i['function'] == 'export/youth_data_export') echo '匯出青少年資料';
                        elseif($i['function'] == 'export/counselor_report_export') echo '匯出輔導員即時數據';
                        elseif($i['function'] == 'export/organization_report_export') echo '匯出機構即時數據';
                        elseif($i['function'] == 'export/county_report_export') echo '匯出縣市即時數據';
                        elseif($i['function'] == 'export/organization_month_report_export') echo '匯出縣市每月執行報表';
                        elseif($i['function'] == 'export/yda_month_report_export') echo '匯出青年署每月執行報表';
                        elseif($i['function'] == 'meeting/meeting_table') echo '跨局處會議及預防性講座清單';
                        elseif($i['function'] == 'meeting/meeting') echo '跨局處會議及預防性講座';
                        elseif($i['function'] == 'member/get_member_table_by_counselor') echo '開案學員清單';
                        elseif($i['function'] == 'member/get_member_table_by_county') echo '開案學員清單';
                        elseif($i['function'] == 'member/get_member_table_by_organization') echo '開案學員清單';
                        elseif($i['function'] == 'member/individual_counseling') echo '個別諮詢紀錄表';
                        elseif($i['function'] == 'member/get_individual_counseling_table_by_member') echo '個別輔導諮詢清單';
                        elseif($i['function'] == 'member/case_assessment') echo '開案學員資料表';
                        elseif($i['function'] == 'member/get_group_counseling_table_by_member') echo '團體輔導紀錄表清單';
                        elseif($i['function'] == 'member/get_group_counseling_table_by_organization') echo '團體輔導紀錄表清單';
                        elseif($i['function'] == 'member/group_counseling_participants') echo '團體輔導紀錄表';
                        elseif($i['function'] == 'member/group_counseling') echo '團體輔導紀錄表';
                        elseif($i['function'] == 'member/group_counseling_participants_delete') echo '刪除團體輔導紀錄表';
                        elseif($i['function'] == 'member/end_case') echo '結案評估表';
                        elseif($i['function'] == 'member/get_month_review_table_by_member') echo '當年度結案後月追蹤清單';
                        elseif($i['function'] == 'member/month_review') echo '當年度結案後月追蹤表單';
                        elseif($i['function'] == 'member/get_insurance_table_by_member') echo '投保紀錄清單';
                        elseif($i['function'] == 'member/get_insurance_table_by_member') echo '投保紀錄';
                        elseif($i['function'] == 'member/change_counselor') echo '更換輔導員申請';
                        elseif($i['function'] == 'member/change_counselor_apply') echo '更換輔導員申請';
                        elseif($i['function'] == 'messager/messager') echo '新增訊息';
                        elseif($i['function'] == 'messager/messager_table') echo '訊息清單';
                        elseif($i['function'] == 'organization/create_organization') echo '新增計畫執行機構';
                        elseif($i['function'] == 'project/create_project') echo '開設計畫案';
                        elseif($i['function'] == 'project/project_and_county') echo '計畫與其執行單位紀錄清單';
                        elseif($i['function'] == 'project/project_table') echo '計畫案資訊';
                        elseif($i['function'] == 'project/manage_county_and_project_table') echo '縣市計畫案管理';
                        elseif($i['function'] == 'project/funding_table') echo '經費管理';
                        elseif($i['function'] == 'project/funding') echo '經費管理';
                        elseif($i['function'] == 'questionnaire/counselor_questionnaire') echo '輔導員問卷';
                        elseif($i['function'] == 'report/verify_table') echo '確認表格';
                        elseif($i['function'] == 'report/yda_report_table') echo '青年署即時數據統計';
                        elseif($i['function'] == 'report/county_report_table') echo '縣市即時數據統計';
                        elseif($i['function'] == 'report/organization_report_table') echo '機構即時數據統計';
                        elseif($i['function'] == 'report/counselor_report_table') echo '輔導員即時數據統計';
                        elseif($i['function'] == 'report/counseling_member_count_report_table') echo '每月執行進度表清單';
                        elseif($i['function'] == 'report/counseling_member_count_report') echo '表一.輔導人數統計表/執行進度表';
                        elseif($i['function'] == 'report/counseling_member_count_report_organization_table') echo '表一.輔導人數統計表/執行進度表';
                        elseif($i['function'] == 'report/counseling_member_count_report_yda_table') echo '表一.輔導人數統計表/執行進度表';
                        elseif($i['function'] == 'report/month_member_temp_counseling') echo '每月輔導成效概況表';
                        elseif($i['function'] == 'report/funding_execute_report_yda_table') echo '經費執行情形表';
                        elseif($i['function'] == 'report/timing_report_yda_table') echo '回傳情形紀錄表';
                        elseif($i['function'] == 'report/high_school_trend_survey_count_report') echo '表九.高中已錄取未註冊動向調查追蹤';
                        elseif($i['function'] == 'report/high_school_trend_survey_count_report_organization_table') echo '表九.高中已錄取未註冊動向調查追蹤';
                        elseif($i['function'] == 'report/high_school_trend_survey_count_report_yda_table') echo '表九.高中已錄取未註冊動向調查追蹤';
                        elseif($i['function'] == 'report/two_years_trend_survey_count_report') echo '表五.106年動向調查追蹤';
                        elseif($i['function'] == 'report/two_years_trend_survey_count_report_organization_table') echo '表五.106年動向調查追蹤';
                        elseif($i['function'] == 'report/two_years_trend_survey_count_report_yda_table') echo '表五.106年動向調查追蹤';
                        elseif($i['function'] == 'report/one_years_trend_survey_count_report') echo '表六.107年動向調查追蹤';
                        elseif($i['function'] == 'report/one_years_trend_survey_count_report_organization_table') echo '表表六.107年動向調查追蹤';
                        elseif($i['function'] == 'report/one_years_trend_survey_count_report_yda_table') echo '表六.107年動向調查追蹤';
                        elseif($i['function'] == 'report/now_years_trend_survey_count_report') echo '表七.108年動向調查追蹤';
                        elseif($i['function'] == 'report/now_years_trend_survey_count_report_organization_table') echo '表七.108年動向調查追蹤';
                        elseif($i['function'] == 'report/now_years_trend_survey_count_report_yda_table') echo '表七.108年動向調查追蹤';
                        elseif($i['function'] == 'report/old_case_trend_survey_count_report') echo '表八.前一年結案後動向調查追蹤';
                        elseif($i['function'] == 'report/old_case_trend_survey_count_report_organization_table') echo '表八.前一年結案後動向調查追蹤';
                        elseif($i['function'] == 'report/old_case_trend_survey_count_report_yda_table') echo '表八.前一年結案後動向調查追蹤';
                        elseif($i['function'] == 'report/counselor_manpower_report') echo '表四.輔導人力概況表';
                        elseif($i['function'] == 'report/counselor_manpower_report_organization_table') echo '表四.輔導人力概況表';
                        elseif($i['function'] == 'report/counselor_manpower_report_yda_table') echo '表四.輔導人力概況表';
                        elseif($i['function'] == 'report/counseling_identity_count_report') echo '表二.輔導對象身分統計';
                        elseif($i['function'] == 'report/counseling_identity_count_report_table') echo '表二.輔導對象身分統計';
                        elseif($i['function'] == 'report/counseling_identity_count_report_yda_table') echo '表二.輔導對象身分統計';
                        elseif($i['function'] == 'report/counseling_meeting_count_report') echo '表三.跨局處會議/預防性講座場次/人次統計';
                        elseif($i['function'] == 'report/counseling_meeting_count_report_table') echo '表三.跨局處會議/預防性講座場次/人次統計';
                        elseif($i['function'] == 'report/counseling_meeting_count_report_yda_table') echo '表三.跨局處會議/預防性講座場次/人次統計';
                        elseif($i['function'] == 'report/yda_month_report_table') echo '每月執行報表即時數據';
                        elseif($i['function'] == 'report/yda_month_report_table') echo '每月執行報表即時數據';
                        elseif($i['function'] == 'review/review_table') echo '審核清單';
                        elseif($i['function'] == 'review/review') echo '審核';
                        elseif($i['function'] == 'work/get_company_table_by_organization') echo '店家參考清單(歷年資料)';
                        elseif($i['function'] == 'work/company') echo '店家參考資料(歷年資料)';
                        elseif($i['function'] == 'work/get_work_experience_table_by_organization') echo '工作體驗清單(今年度資料)';
                        elseif($i['function'] == 'work/work_experience') echo '工作體驗資料(今年度資料)';
                        elseif($i['function'] == 'work/get_work_attendance_table_by_organization') echo '工作體驗時數清單(執行當日更新、每月自動統計報表數據)';
                        elseif($i['function'] == 'work/get_work_attendance_table_by_member') echo '工作體驗時數清單(執行當日更新、每月自動統計報表數據)';
                        elseif($i['function'] == 'work/work_attendance') echo '工作體驗時數表(執行當日更新、每月自動統計報表數據)';
                        elseif($i['function'] == 'youth/personal_data') echo '青少年基本資料';
                        elseif($i['function'] == 'youth/intake') echo '青少年初評表';
                        elseif($i['function'] == 'youth/get_all_source_youth_table') echo '原始來源清單（含動向調查清單、高中職已錄取未註冊、自行開發及其他單位轉介）';
                        elseif($i['function'] == 'youth/get_all_youth_table') echo '需關懷追蹤青少年清單（動向調查需政府介入者及高中職已錄取未註冊）';
                        elseif($i['function'] == 'youth/get_seasonal_review_table_by_youth') echo '季追蹤清單';
                        elseif($i['function'] == 'youth/seasonal_review') echo '季追蹤表單';
                        elseif($i['function'] == 'youth/end_youth_table') echo '青少年結案申請清單';
                        elseif($i['function'] == 'youth/end_youth') echo '青少年結案申請清單';
                        elseif($i['function'] == 'youth/transfer_youth_table') echo '青少年轉介申請清單';
                        elseif($i['function'] == 'youth/transfer_youth') echo '青少年轉介申請清單';
                        else echo $i['function'];
                      
                      ?></td>
                      <td><?php echo $i['command']; ?></td>
                    </tr>
   
                <?php }?>
              </tbody>
            </table>

            <div class="col-10 m-2 mx-auto">
              <label>審核</label>
              <div class="input-group">
                <select class="form-select" name="status" id="status">
                  <option disabled selected value>請選擇</option>
                  <?php foreach ($statuses as $i) { ?>
                    <option value="<?php echo $i['no']?>"><?php echo $i['content'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="col-10 m-2 mx-auto">
            <label for="formNote" class="form-label">備註:</label>
            <textarea class="form-control" id="formNote" name="note" placeholder=""></textarea>
          </div>

            <div class="row">
              <div class="d-grid gap-2 col-2 mx-auto">
                <button class="btn btn-primary my-5" name="save" value="Save" type="submit">送出</button>
              </div>
            </div>

          <?php endif;?>

       </form>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('templates/new_footer');?>
