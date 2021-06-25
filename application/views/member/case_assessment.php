<?php $this->load->view('templates/new_header');?>

<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">輔導會談(措施A)</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/member/get_member_table_by_counselor'); ?>" <?php echo $url == '/member/get_member_table_by_counselor' ? 'active' : ''; ?>>開案學員清單</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <!-- <div class="col-10 m-2"> 
        <a class="btn btn-success" href="<?php echo site_url('/member/get_member_table_by_counselor'); ?>">←學員列表</a>
      </div> -->
      <div class="row">
        <h4 class="text-dark text-center"><?php echo $title ?></h4>
      </div>
      
      <h6 class="text-center">編號: <?php echo $members->system_no; ?></h6>
      <h6 class="text-center">學員: <?php echo $members->name; ?></h6>

      <div class="card-content">
        <form action="<?php echo site_url($url); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>"
            value="<?php echo $security->get_csrf_hash() ?>" />
          <?php echo isset($error) ? '<p class="text-danger text-center">' . $error . '</p>' : ''; ?>
          <?php echo isset($success) ? '<p class="text-success text-center">' . $success . '</p>' : ''; ?>
         
          <!-- <?php if (empty($reviews)): ?>
            <div class="row">
              <a class="btn col s2 offset-s5 waves-effect blue lighten-1" href="<?php echo site_url('/member/change_counselor_apply/' . $caseAssessments->member); ?>">提出更換輔導員申請</a>
            </div>
          <?php else: ?>
            <h6 class="card-title text-center">正在審核更換輔導員</h6>
            <div class="card-content">
              <table class="highlight">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">日期</th>
                    <th scope="col">狀態</th>
                    <th scope="col">審核者</th>
                    <th scope="col">審核日期</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($reviews as $value) {?>

                    <tr>
                      <td><?php echo $value['create_time']; ?></td>
                      <td><?php foreach ($statuses as $i) {
    if ($i['no'] == $value['status']) {
        echo $i['content'];
    }
}?></td>
                      <td><?php if ($value['reviewer_role'] == 4): echo '縣市主管';else:echo '縣市承辦人';endif;?></td>
                      <td><?php echo $value['end_time']; ?></td>
                    </tr>
              <?php }?>

                </tbody>
              </table>
            </div>
          <?php endif;?> -->

          <!-- isContinue -->
          <div class="col-10 m-2 mx-auto">
            <label>是否匯入去年度開案評估表資料</label>
            <div class="input-group">
              <select class="form-select" name="isContinue" id="isContinue" onchange="location = this.value;"
                <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?>>
                <option value="<?php echo site_url($url . '/'); ?>">否</option>
                <option value="<?php echo site_url($url . '/1'); ?>">是</option>
              </select>
            </div>
          </div>

          <h5 class="text-dark text-center m-4">青少年背景資料</h5>

          <!-- interviewDate -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formInterviewDate" class="form-label">初談日期</label>
              <input date-provide="datepicker" class="form-control" data-date-format="yyyy-mm-dd" type="text" id="formInterviewDate" name="interviewDate" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($caseAssessments)) ? "" : $caseAssessments->interview_date ?>">
            </div>
          </div>
  
          <!-- <div class="input-group date" data-provide="datepicker">
            <div class="col-10 m-2 mx-auto">
              <label for="formInterviewDate" class="form-label">初談日期</label>
              <input type="text" class="form-control" id="formInterviewDate" name="interviewDate" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> >
            </div>
            <div class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </div>
          </div>

          <div class="input-append date" id="datetimepicker" data-date="12-02-2012" data-date-format="yyyy-mm-dd">
            <input class="span2" size="16" type="text">
            <span class="add-on"><i class="icon-th"></i></span>
          </div>  -->

          <script>
            $('#formInterviewDate').datetimepicker();
          </script>

          


          <!-- interviewWay -->
          <div class="col-10 m-2 mx-auto">
            <label>進行方式</label>
            <div class="input-group">
              <select class="form-select" name="interviewWay" id="interviewWay" <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?>>
              <?php if (empty($caseAssessments->interview_way)) { ?>
                <option disabled selected value>請選擇</option>
                <?php } foreach ($interviewWays as $i) {
                  if (!empty($caseAssessments->interview_way)) {
                    if ($i['no'] == $caseAssessments->interview_way) { ?>
                      <option selected value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                    <?php } else { ?>
                      <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                    <?php }
                  } else { ?>
                    <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>

          <!-- interviewPlace -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formInterviewPlace" class="form-label">諮詢地點</label>
              <input class="form-control" type="text" id="formInterviewPlace" name="interviewPlace" placeholder="OO國中輔導室" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($caseAssessments)) ? "" : $caseAssessments->interview_place ?>">
            </div>
          </div>

          <!-- interviewWay -->
          <div class="col-10 m-2 mx-auto">
            <label>學歷狀況
              <?php if (empty($age)) { ?>
                <h6 class="text-danger text-center">請先填寫該學員的生日</h5><br/>
              <?php } ?>
            </label>
            <div class="input-group">
              <select class="form-select" name="interviewWay" id="interviewWay" <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?>>
              <?php if (empty($caseAssessments->education)) { ?>
                <option disabled selected value><?php empty($age) ? "" : "請選擇"?></option>
                <?php } foreach ($educationAgeArray as $i) {
                  if (!empty($caseAssessments->education)) {
                    if ($i['no'] == $caseAssessments->education) { ?>
                      <option selected value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                    <?php } else { ?>
                      <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                    <?php }
                  } else { ?>
                    <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>

          <!-- source -->
          <div class="col-10 m-2 mx-auto">
            <label>青少年來源</label>
            <div class="input-group">
              <select class="form-select" name="source" <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?>>
              <?php if (empty($caseAssessments->source)) { ?>
                <option disabled selected value>請選擇</option>
                <?php } foreach ($sources as $i) {
                  if (!empty($caseAssessments->source)) {
                    if ($i['no'] == $caseAssessments->source) { ?>
                      <option selected value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                    <?php } else { ?>
                      <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                    <?php }
                  } else { ?>
                    <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>

          <!-- sourceOther -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formSourceOther" class="form-label">青少年來源-其他</label>
              <input class="form-control" type="text" id="formSourceOther" name="sourceOther" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($caseAssessments)) ? "" : $caseAssessments->source_other ?>">
            </div>
          </div>

          <!-- surveyYear -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formSurveyYear" class="form-label">動向調查名單-學年度</label>
              <input class="form-control" type="text" id="formSurveyYear" name="surveyYear" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($caseAssessments)) ? "" : $caseAssessments->survey_year ?>">
            </div>
          </div>

          <!-- background -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <h6 class="fw-bold">青少年身分別(可複選)</h6>
              <?php $background = (empty($caseAssessments)) ? null : $caseAssessments->background;
              $background = explode(",", $background);
              foreach ($backgrounds as $i) { ?>
                <div class="form-check form-check-inline">
                  <p><label>
                    <input class="form-check-input" type="checkbox" name="background[]"
                      <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?> <?php if (in_array($i['no'], $background) == 1) {
                        echo "checked";
                      } else {"";}?> value="<?php echo $i['no']; ?>">
                    <span><?php echo $i['content']; ?></span>
                  </label></p>
                </div>
              <?php } ?>
            </div>
          </div>

          <!-- backgroundOther -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formBackgroundOther" class="form-label">青少年身分別-其他</label>
              <input class="form-control" type="text" id="formBackgroundOther" name="backgroundOther" value="<?php echo (empty($caseAssessments)) ? "" : $caseAssessments->background_other ?>">
            </div>
          </div>

          <h5 class="text-dark text-center m-4">青少年狀況</h5>

          <!-- appearanceHabits -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formAppearanceHabits" class="form-label">儀容、生活習慣描述(是否有特殊習慣如菸癮、檳榔、日常作息):</label>
              <textarea class="form-control" type="text" id="formAppearanceHabits" name="appearanceHabits" placeholder="因畢業後都在家，沉迷於網路，作息日夜顛倒" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?>><?php echo (empty($caseAssessments)) ? "" : $caseAssessments->appearance_habits ?></textarea>
            </div>
          </div>

          <!-- majorSetback -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formMajorSetback" class="form-label">生命重大事件或家庭重大事件:</label>
              <textarea class="form-control" type="text" id="formMajorSetback" name="majorSetback" placeholder="1. 國小二年級父母離婚，案父取得監護權並與案父同住
2. 國中二年級下學期因被同學偷竊班費而被霸凌，由班導師轉介輔導室" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?>><?php echo (empty($caseAssessments)) ? "" : $caseAssessments->major_setback ?></textarea>
            </div>
          </div>

          <!-- interestPlan -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formInterestPlan" class="form-label">興趣與未來生涯規劃:</label>
              <textarea class="form-control" type="text" id="formInterestPlan" name="interestPlan" placeholder="對汽修有興趣，想往高職體系就讀但自信心不足，會考分數也不夠" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?>><?php echo (empty($caseAssessments)) ? "" : $caseAssessments->interest_plan ?></textarea>
            </div>
          </div>

          <!-- interactiveExperience -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formInteractiveExperience" class="form-label">互動經驗描述(表達能力、個性等):</label>
              <textarea class="form-control" type="text" id="formInteractiveExperience" name="interactiveExperience" placeholder="1. 個案口齒清晰，個性活潑
2. 思考及表達能力中下，口語互動上需有較多緩衝時間" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?>><?php echo (empty($caseAssessments)) ? "" : $caseAssessments->interactive_experience ?></textarea>
            </div>
          </div>

          <!-- transportation -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <h6 class="fw-bold">交通能力評估(可複選)</h6>
              <?php $transportation = (empty($caseAssessments)) ? null : $caseAssessments->transportation;
              $transportation = explode(",", $transportation);
              foreach ($transportations as $i) { ?>
                <div class="form-check form-check-inline">
                  <p><label>
                    <input class="form-check-input" type="checkbox" name="transportation[]"
                      <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?> <?php if (in_array($i['no'], $transportation) == 1) {
                        echo "checked";
                      } else {"";}?> value="<?php echo $i['no']; ?>">
                    <span><?php echo $i['content']; ?></span>
                  </label></p>
                </div>
              <?php } ?>
            </div>
          </div>

          <!-- transportationOther -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formTransportationOther" class="form-label">交通能力評估-其他</label>
              <input class="form-control" type="text" id="formTransportationOther" name="transportationOther" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($caseAssessments)) ? "" : $caseAssessments->transportation_other ?>">
            </div>
          </div>

          <!-- medicalSupport -->
          <div class="col-10 m-2 mx-auto">
            <label>醫療需求</label>
            <div class="input-group">
              <select class="form-select" name="medicalSupport" <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?>>
              <?php if (isset($caseAssessments->medical_support)) {
                  if ($caseAssessments->medical_support == "1") { ?>
                  <option value="1" selected>是</option>
                  <option value="0">否</option>
                <?php } else { ?>
                  <option value="1">是</option>
                  <option value="0" selected>否</option>
                <?php }
                } else { ?>
                  <option disabled selected value>請選擇</option>
                  <option value="1">是</option>
                  <option value="0">否</option>
                <?php } ?>
              </select>
            </div>
          </div>

          <!-- medicalReason -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formMedicalReason" class="form-label">醫療需求-原因</label>
              <input class="form-control" type="text" id="formMedicalReason" name="medicalReason" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($caseAssessments)) ? "" : $caseAssessments->medical_reason ?>">
            </div>
          </div>

          <h5 class="text-dark text-center m-4">家庭概況</h5>

          <!-- familyMember -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formFamilyMember" class="form-label">家庭成員(生活、環境、職業):</label>
              <textarea class="form-control" type="text" id="formFamilyMember" name="familyMember" placeholder="1. 案父母於個案國小2年級時因個性不合離婚
2. 與案父同住，案父以開計程車為業，與案祖父、祖母同住舊透天屋
3. 尚有小三歲的妹妹與案母同住" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?>><?php echo (empty($caseAssessments)) ? "" : $caseAssessments->family_member ?></textarea>
            </div>
          </div>

          <!-- familyInteractivePattern -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formFamilyInteractivePattern" class="form-label">家庭互動模式:</label>
              <textarea class="form-control" type="text" id="formFamilyInteractivePattern" name="familyInteractivePattern" placeholder="祖父母、父母以民主方式管教，但大人的觀念常與個案不合" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?>><?php echo (empty($caseAssessments)) ? "" : $caseAssessments->family_interactive_pattern ?></textarea>
            </div>
          </div>

          <!-- communityInteractivePattern -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formCommunityInteractivePattern" class="form-label">親屬與社區系統互動情形:</label>
              <textarea class="form-control" type="text" id="formCommunityInteractivePattern" name="familyInteractivePattern" placeholder="無特殊互動、也沒有與人結怨，個案會跟鄰居在倒垃圾時聊天" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?>><?php echo (empty($caseAssessments)) ? "" : $caseAssessments->community_interactive_pattern ?></textarea>
            </div>
          </div>

          <!-- familyMajorSetback -->
          <!-- <div class="row">
            <div class="input-field col s10 offset-m2 m8">
              <textarea id="formFamilyMajorSetback" class="materialize-textarea" placeholder="1.國小二年級父母離婚，案父取得監護權並與案父同住
2.國中二年級下學期因被同學偷竊班費而被霸凌，由班導師轉介輔導室" name="familyMajorSetback"
                <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?>><?php echo (empty($caseAssessments)) ? "" : $caseAssessments->family_major_setback ?></textarea>
              <label for="formFamilyMajorSetback">家庭重大事件:</label>
            </div>
          </div> -->

          <!-- familyOtherSetback -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formFamilyOtherSetback" class="form-label">其他事件(如家暴、性侵事件):</label>
              <textarea class="form-control" type="text" id="formFamilyOtherSetback" name="familyOtherSetback" placeholder="無" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?>><?php echo (empty($caseAssessments)) ? "" : $caseAssessments->family_other_setback ?></textarea>
            </div>
          </div>

          <h5 class="text-dark text-center m-4">學校概況</h5>

          <!-- schoolHistory -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formSchoolHistory" class="form-label">就學史:簡述學員國中、高中(職)就學歷史:</label>
              <textarea class="form-control" type="text" id="formSchoolHistory" name="schoolHistory" placeholder="OO國中準時畢業，欲就讀OO高職但未被錄取" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?>><?php echo (empty($caseAssessments)) ? "" : $caseAssessments->school_history ?></textarea>
            </div>
          </div>

          <!-- teacherInteractivePattern -->
          <div class="col-10 m-2 mx-auto">
            <label>師生關係與互動</label>
            <div class="input-group">
              <select class="form-select" name="teacherInteractivePattern" <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?>>
              <?php if (empty($inTakes->teacher_interactive_pattern)) { ?>
                <option disabled selected value>請選擇</option>
                <?php } foreach ($teacherInteractivePatterns as $i) {
                  if (!empty($caseAssessments->teacher_interactive_pattern)) {
                    if ($i['no'] == $caseAssessments->teacher_interactive_pattern) { ?>
                      <option selected value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                    <?php } else { ?>
                      <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                    <?php }
                  } else { ?>
                    <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>

          <!-- teacherBadReason -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formTeacherBadReason" class="form-label">師生關係與互動(補充說明):</label>
              <textarea class="form-control" type="text" id="formTeacherBadReason" name="teacherBadReason" placeholder="個案於課堂上偶爾會主動與老師互動，特別是體育課" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?>><?php echo (empty($caseAssessments)) ? "" : $caseAssessments->teacher_bad_reason ?></textarea>
            </div>
          </div>

          <!-- peerInteractivePattern -->
          <div class="col-10 m-2 mx-auto">
            <label>同儕關係</label>
            <div class="input-group">
              <select class="form-select" name="peerInteractivePattern" <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?>>
              <?php if (empty($inTakes->peer_interactive_pattern)) { ?>
                <option disabled selected value>請選擇</option>
                <?php } foreach ($peerInteractivePatterns as $i) {
                  if (!empty($caseAssessments->peer_interactive_pattern)) {
                    if ($i['no'] == $caseAssessments->peer_interactive_pattern) { ?>
                      <option selected value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                    <?php } else { ?>
                      <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                    <?php }
                  } else { ?>
                    <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>

          <!-- peerBadReason -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formPeerBadReason" class="form-label">同儕關係(補充說明):</label>
              <textarea class="form-control" type="text" id="formPeerBadReason" name="peerBadReason" placeholder="因被懷疑偷竊班費，曾有被霸凌經驗" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?>><?php echo (empty($caseAssessments)) ? "" : $caseAssessments->peer_bad_reason ?></textarea>
            </div>
          </div>

          <!-- academicPerformance -->
          <div class="col-10 m-2 mx-auto">
            <label>學業表現</label>
            <div class="input-group">
              <select class="form-select" name="academicPerformance" <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?>>
              <?php if (empty($inTakes->academic_performance)) { ?>
                <option disabled selected value>請選擇</option>
                <?php } foreach ($academicPerformances as $i) {
                  if (!empty($caseAssessments->academic_performance)) {
                    if ($i['no'] == $caseAssessments->academic_performance) { ?>
                      <option selected value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                    <?php } else { ?>
                      <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                    <?php }
                  } else { ?>
                    <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>

          <!-- interestSubject -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formInterestSubject" class="form-label">學業表現(補充說明):</label>
              <textarea class="form-control" type="text" id="formInterestSubject" name="interestSubject" placeholder="自述學業成績不如人" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?>><?php echo (empty($caseAssessments)) ? "" : $caseAssessments->interest_subject ?></textarea>
            </div>
          </div>

          <!-- violation -->
          <div class="col-10 m-2 mx-auto">
            <label>其他事件(如特殊事件、違規行為)</label>
            <div class="input-group">
              <select class="form-select" name="violation" <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?>>
              <?php if (isset($caseAssessments->violation)) {
                  if ($caseAssessments->violation == "1") { ?>
                  <option value="1" selected>是</option>
                  <option value="0">否</option>
                <?php } else { ?>
                  <option value="1">是</option>
                  <option value="0" selected>否</option>
                <?php }
                } else { ?>
                  <option disabled selected value>請選擇</option>
                  <option value="1">是</option>
                  <option value="0">否</option>
                <?php } ?>
              </select>
            </div>
          </div>

          <!-- violationDescription -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formViolationDescription" class="form-label">其他事件(補充說明):</label>
              <textarea class="form-control" type="text" id="formViolationDescription" name="violationDescription" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?>><?php echo (empty($caseAssessments)) ? "" : $caseAssessments->violation_description ?></textarea>
            </div>
          </div>

          <h5 class="text-dark text-center m-4">資源介入概況(政府單位或其他民間單位補助)</h5>

          <!-- welfareSupport -->
          <div class="col-10 m-2 mx-auto">
            <label>福利身分</label>
            <div class="input-group">
              <select class="form-select" name="welfareSupport" <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?>>
              <?php if (isset($caseAssessments->welfare_support)) {
                  if ($caseAssessments->welfare_support == "1") { ?>
                  <option value="1" selected>是</option>
                  <option value="0">否</option>
                <?php } else { ?>
                  <option value="1">是</option>
                  <option value="0" selected>否</option>
                <?php }
                } else { ?>
                  <option disabled selected value>請選擇</option>
                  <option value="1">是</option>
                  <option value="0">否</option>
                <?php } ?>
              </select>
            </div>
          </div>

          <!-- welfareAmount -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formWelfareAmount" class="form-label">補助金額</label>
              <input class="form-control" type="number" id="formWelfareAmount" name="welfareAmount" min="0" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($caseAssessments)) ? "" : $caseAssessments->welfare_amount ?>">
            </div>
          </div>

          <!-- welfareSource -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formWelfareSource" class="form-label">福利來源/單位</label>
              <input class="form-control" type="text" id="formWelfareSource" name="welfareSource" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($caseAssessments)) ? "" : $caseAssessments->welfare_source ?>">
            </div>
          </div>

          <!-- eventSource -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formEventSource" class="form-label">通報單位</label>
              <input class="form-control" type="text" id="formEventSource" name="eventSource" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($caseAssessments)) ? "" : $caseAssessments->event_source ?>">
            </div>
          </div>

          <!-- eventDescription -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formEventDescription" class="form-label">通報事件(補充說明):</label>
              <textarea class="form-control" type="text" id="formEventDescription" name="eventDescription" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?>><?php echo (empty($caseAssessments)) ? "" : $caseAssessments->event_description ?></textarea>
            </div>
          </div>
          
          <!-- servingSource -->
          <div class="col-10 m-2 mx-auto">
            <label>其他民間單位</label>
            <div class="input-group">
              <select class="form-select" name="servingSource" <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?>>
              <?php if (isset($caseAssessments->serving_source)) {
                  if ($caseAssessments->serving_source == "1") { ?>
                  <option value="1" selected>是</option>
                  <option value="0">否</option>
                <?php } else { ?>
                  <option value="1">是</option>
                  <option value="0" selected>否</option>
                <?php }
                } else { ?>
                  <option disabled selected value>請選擇</option>
                  <option value="1">是</option>
                  <option value="0">否</option>
                <?php } ?>
              </select>
            </div>
          </div>

        
          <!-- servingInstitution -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formServingInstitution" class="form-label">單位</label>
              <input class="form-control" type="text" id="formServingInstitution" name="servingInstitution" placeholder="無" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($caseAssessments)) ? "" : $caseAssessments->serving_institution ?>">
            </div>
          </div>

          <!-- servingProfessional -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formServingProfessional" class="form-label">專業人員姓名</label>
              <input class="form-control" type="text" id="formServingProfessional" name="servingProfessional" placeholder="無" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($caseAssessments)) ? "" : $caseAssessments->serving_professional ?>">
            </div>
          </div>

          <!-- servingPhone -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formServingPhone" class="form-label">連絡電話</label>
              <input class="form-control" type="text" id="formServingPhone" name="servingPhone" placeholder="無" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($caseAssessments)) ? "" : $caseAssessments->serving_phone ?>">
            </div>
          </div>

          <!-- issue -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <h6 class="fw-bold">青少年議題(可複選)</h6>
              <?php $issue = (empty($caseAssessments)) ? null : $caseAssessments->issue;
              $issue = explode(",", $issue);
              foreach ($issues as $i) { ?>
                <div class="form-check form-check-inline">
                  <p><label>
                    <input class="form-check-input" type="checkbox" name="issue[]"
                      <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?> <?php if (in_array($i['no'], $issue) == 1) {
                        echo "checked";
                      } else {"";}?> value="<?php echo $i['no']; ?>">
                    <span><?php echo $i['content']; ?></span>
                  </label></p>
                </div>
              <?php } ?>
            </div>
          </div>

          <!-- issueOther -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formIssueOther" class="form-label">青少年議題-其他</label>
              <input class="form-control" type="text" id="formIssueOther" name="issueOther" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($caseAssessments)) ? "" : $caseAssessments->issue_other ?>">
            </div>
          </div>

          <!-- counselWay -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <h6 class="fw-bold">預計輔導方式(可複選)</h6>
              <?php $counselWay = (empty($caseAssessments)) ? null : $caseAssessments->counsel_way;
              $counselWay = explode(",", $counselWay);
              foreach ($counselWays as $i) { ?>
                <div class="form-check form-check-inline">
                  <p><label>
                    <input class="form-check-input" type="checkbox" name="counselWay[]"
                      <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?> <?php if (in_array($i['no'], $counselWay) == 1) {
                        echo "checked";
                      } else {"";}?> value="<?php echo $i['no']; ?>">
                    <span><?php echo $i['content']; ?></span>
                  </label></p>
                </div>
              <?php } ?>
            </div>
          </div>

          <!-- counselWayOther -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formCounselWayOther" class="form-label">預計輔導方式-其他</label>
              <input class="form-control" type="text" id="formCounselWayOther" name="counselWayOther" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($caseAssessments)) ? "" : $caseAssessments->counsel_way_other ?>">
            </div>
          </div>

          <!-- counselTarget -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formCounselTarget" class="form-label">預計輔導目標及綜合評估(請條列):</label>
              <textarea class="form-control" type="text" id="formCounselTarget" placeholder="1. 帶領個案探索汽修專業，並進行工作體驗
2. 已就學為目標" name="counselTarget" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?>><?php echo (empty($caseAssessments)) ? "" : $caseAssessments->counsel_target ?></textarea>
            </div>
          </div>

          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <?php if ($hasDelegation != '0'): ?>
                <span>家系圖</span>
                <div class="input-group mb-3">
                  <input type="file" class="form-control" name="familyDiagram">
                </div>
              <?php endif;?>
            </div>
            <?php if (!empty($caseAssessments->family_diagram_name)): ?>
            <?php if (strpos($caseAssessments->family_diagram_name, 'pdf') !== false): ?>
            <a class="col-10 m-2 mx-auto"
              href="<?php echo site_url() . '/files/' . $caseAssessments->family_diagram_name; ?>" download="家系圖">家系圖(jpg/png/pdf)</a>
            <?php else: ?>
            <div class="col-10 m-2 mx-auto">
              <img class="img-fluid"
                src="<?php echo site_url() . '/files/' . $caseAssessments->family_diagram_name; ?>" />
            </div>
            <?php endif;?>
            <?php endif;?>
          </div>

          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <?php if ($hasDelegation != '0'): ?>
                <span>法定代理人同意書</span>
                <div class="input-group mb-3">
                  <input type="file" class="form-control" name="representativeAgreement">
                </div>
              <?php endif;?>
            </div>
            <?php if (!empty($caseAssessments->representative_agreement_name)): ?>
            <?php if (strpos($caseAssessments->representative_agreement_name, 'pdf') !== false): ?>
            <a class="col-10 m-2 mx-auto"
              href="<?php echo site_url() . '/files/' . $caseAssessments->representative_agreement_name; ?>"
              download="法定代理人同意書">法定代理人同意書(jpg/png/pdf)</a>
            <?php else: ?>
            <div class="col-10 m-2 mx-auto">
              <img class="img-fluid"
                src="<?php echo site_url() . '/files/' . $caseAssessments->representative_agreement_name; ?>" />
            </div>
            <?php endif;?>
            <?php endif;?>
          </div>

          <?php if ($hasDelegation != '0'): ?>
          <div class="row">
            <div class="d-grid gap-2 col-2 mx-auto">
              <button class="btn btn-primary my-5" type="submit">送出</button>
            </div>
          </div>
          <?php endif;?>

        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo site_url(); ?>assets/js/ElementBinder.js"></script>
<script type="text/javascript">
  const elementRelation = new ElementBinder();
  elementRelation.selectInput('interviewWay', 'interviewPlace', '面訪');
  elementRelation.selectInput('source', 'sourceOther', '其他');
  elementRelation.selectInput('source', 'surveyYear', '動向調查名單');
  elementRelation.checkboxInput('background[]', 'backgroundOther');
  elementRelation.checkboxInput('transportation[]', 'transportationOther', '其他');
  elementRelation.selectInput('medicalSupport', 'medicalReason', '是');
  elementRelation.selectInput('violation', 'violationDescription', '是');
  elementRelation.checkboxInput('counselWay[]', 'counselWayOther');
  elementRelation.checkboxInput('issue[]', 'issueOther');
  elementRelation.selectInput('welfareSupport', 'welfareAmount', '是');
  elementRelation.selectInput('welfareSupport', 'welfareSource', '是');
  elementRelation.selectInput('welfareSupport', 'eventSource', '是');
  elementRelation.selectInput('welfareSupport', 'eventDescription', '是');
  elementRelation.selectInput('servingSource', 'servingInstitution', '是');
  elementRelation.selectInput('servingSource', 'servingProfessional', '是');
  elementRelation.selectInput('servingSource', 'servingPhone', '是');

</script>

<?php $this->load->view('templates/new_footer');?>
