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

      <div class="card-content">
        <form action="<?php echo site_url($url); ?>"
          method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />
          <?php echo isset($error) ? '<p class="text-danger text-center">' . $error . '</p>' : ''; ?>
          <?php echo isset($success) ? '<p class="text-success text-center">' . $success . '</p>' : ''; ?>

          <?php if ($hasDelegation != '0' && $youthRate == '100' && $intakeRate == '100' && $caseAssessmentRate == '100' && $individualCounselingRate == '100' && $groupCounselingRate == '100'): ?>

          <?php else: ?>
            <h5 class="text-dark text-center">有尚未完成之表單(未完成無法結案)</h5>

            <table class="table table-hover text-center" style="border:2px grey solid;">
              <thead class="thead-dark">
                <tr>
                  <?php if ($youthRate != '100'): ?>
                    <th scope="col">基本資料</th>
                  <?php endif;?>
                  <?php if ($intakeRate != '100'): ?>
                    <th scope="col">青少年初評表</th>
                    <?php endif;?>
                  <?php if ($caseAssessmentRate != '100'): ?>
                    <th scope="col">開案學員資料表</th>
                  <?php endif;?>
                  <?php if ($individualCounselingRate != '100'): ?>
                    <th scope="col">個別輔導諮詢</th>
                  <?php endif;?>
                  <?php if ($groupCounselingRate != '100'): ?>
                    <th scope="col">團體輔導諮詢</th>
                  <?php endif;?>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <?php if ($youthRate != '100'): ?>
                    <td>
                      <a class="btn btn-info" href="<?php echo site_url('youth/personal_data/' . $youths->no); ?>">查看/修改</a>
                    </td>
                  <?php endif;?>
                  <?php if ($intakeRate != '100'): ?>
                    <td>
                      <a class="btn btn-info" href="<?php echo site_url('youth/intake/' . $youths->no); ?>">查看/修改</a>
                    </td>
                  <?php endif;?>
                  <?php if ($caseAssessmentRate != '100'): ?>
                    <td>
                      <a class="btn btn-info" href="<?php echo site_url('member/case_assessment/' . $member); ?>">查看/修改</a>
                    </td>
                    <?php endif;?>
                  <?php if ($individualCounselingRate != '100'): ?>
                    <td>
                      <a class="btn btn-info" href="<?php echo site_url('member/get_individual_counseling_table_by_member/' . $member); ?>">查看/修改</a>
                    </td>
                    <?php endif;?>
                  <?php if ($groupCounselingRate != '100'): ?>
                    <td>
                      <a class="btn btn-info" href="<?php echo site_url('member/get_group_counseling_table_by_member/' . $member); ?>">查看/修改</a>
                    </td>
                  <?php endif;?>
                </tr>
              </tbody>
            </table>

          <?php endif;?>

          <h5 class="text-dark text-center">青少年背景資料</h5>

          <!-- name -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formName" class="form-label">姓名*</label>
              <input class="form-control" type="text" id="formName" name="name" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($youths)) ? "" : $youths->name ?>">
            </div>
          </div>

          <div class="row">
            <div class="input-field col s10 offset-m2 m8">
              <label for="formInterviewDate">初談日期</label>
            </div>
          </div>


          <!-- interviewDate -->
          <div class="row">
            <div class="input-field col s10 offset-m2 m8">
              <input readonly type="text" id="formInterviewDate" name="interviewDate" class="datepicker" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($caseAssessments)) ? "" : $caseAssessments->interview_date ?>">
              <label for="formInterviewDate"></label>
            </div>
          </div>

           <!-- juniorGraduateYear -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formJuniorGraduateYear" class="form-label">國中畢業年度(填寫「年度」非「學年度，並請填列民國年」)</label>
              <input readonly class="form-control" type="number" id="formJuniorGraduateYear" min="0" name="juniorGraduateYear" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($youths)) ? "" : $youths->junior_graduate_year ?>">
            </div>
          </div>

          <!-- juniorDropoutRecord -->
          <div class="col-10 m-2 mx-auto">
            <label>國中是否曾有中輟通報紀錄</label>
            <div class="input-group">
              <select disabled class="form-select" name="juniorDropoutRecord" <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?>>
              <?php if (isset($youths->junior_dropout_record)) {
                  if ($youths->junior_dropout_record == "1") { ?>
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

          <!-- counselIdentity -->
          <div class="col-10 m-2 mx-auto">
            <label>輔導時身分</label>
            <div class="input-group">
              <select disabled class="form-select" name="counselIdentity" <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?>>
              <?php if (empty($youths->counsel_identity)) { ?>
                <option disabled selected value>請選擇</option>
                <?php } foreach ($counselIdentitys as $i) {
                  if (!empty($youths->counsel_identity)) {
                    if ($i['no'] == $youths->counsel_identity) { ?>
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

          <!-- juniorSchool -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formJuniorSchool" class="form-label">國中學校/年級</label>
              <input class="form-control" type="text" id="formJuniorSchool" name="juniorSchool" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($youths)) ? "" : $youths->junior_school ?>">
            </div>
          </div>

          <!-- seniorSchool -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formSeniorSchool" class="form-label">高中學校/年級/科系</label>
              <input class="form-control" type="text" id="formSeniorSchool" name="seniorSchool" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($youths)) ? "" : $youths->senior_school ?>">
            </div>
          </div>

          <!-- source -->
          <div class="col-10 m-2 mx-auto">
            <label>青少年來源</label>
            <div class="input-group">
              <select disabled class="form-select" name="source" <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?>>
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

          <!-- counselTarget -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formCounselTarget" class="form-label">預計輔導目標及綜合評估(請條列):</label>
              <textarea readonly class="form-control" type="text" id="formCounselTarget" name="counselTarget" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?>><?php echo (empty($caseAssessments)) ? "" : $caseAssessments->counsel_target ?></textarea>
            </div>
          </div>

          <h5 class="text-dark text-center">輔導情形(（系統自動統計時數，不需修改)</h5>

          <div class="col-10 m-2 mx-auto">
            <table class="table table-hover text-center">
              <thead class="thead-dark">
                <tr>
                  <th>項目</th>
                  <th>時數</th>
                  <th>紀錄</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>個別諮詢小時</td>
                  <td><?php echo (empty($individualCounselingHour)) ? "0" : $individualCounselingHour ?></td>
                  <td><a class="btn btn-info" href="<?php echo site_url('member/get_individual_counseling_table_by_member/' . $member); ?>">個別諮詢紀錄</a></td>
                </tr>
                <tr>
                  <td>團體輔導小時</td>
                  <td><?php echo (empty($groupCounselingHour)) ? "0" : $groupCounselingHour ?></td>
                  <td><a class="btn btn-info" href="<?php echo site_url('member/get_group_counseling_table_by_member/' . $member); ?>">團體輔導紀錄</a></td>
                </tr>
                <tr>
                  <td>已參與生涯探索課程小時</td>
                  <td><?php echo (empty($courseAttendanceHour)) ? "0" : $courseAttendanceHour ?></td>
                  <td><a class="btn btn-info" href="<?php echo site_url('course/get_course_attendance_table_by_member/' . $member); ?>">參與課程紀錄</a></td>
                </tr>
                <tr>
                  <td>已參與工作體驗小時</td>
                  <td><?php echo (empty($workAttendanceHour)) ? "0" : $workAttendanceHour ?></td>
                  <td><a class="btn btn-info" href="<?php echo site_url('work/get_work_attendance_table_by_member/' . $member); ?>">參與工作紀錄</a></td>
                </tr>
              </tbody>
            </table>
          </div>

          <h5 class="text-dark text-center">參與工作情形(（系統自動統計時數，不需修改)</h5>

          <div class="col-10 m-2 mx-auto">
            <table class="table table-hover text-center">
              <thead class="thead-dark">
                <tr>
                  <th></th>
                  <th>職種</th>
                  <th>時數</th>
                  <th>單位</th>
                </tr>
              </thead>
              <tbody>
                <?php $count = 0; 
                      foreach ($workAttendances as $i) { 
                        $count++;?>
                  <tr>
                    <td><?php echo $count?></td>
                    <td><?php foreach ($categorys as $j){ if($j['no'] == $i['category']) echo $j['content'];} ?></td>
                    <td><?php echo (empty($i['duration'])) ? "0" : $i['duration'] ?></td>
                    <td><?php echo (empty($i['name'])) ? "" : $i['name'] ?></td>
                  </tr>
                <?php }?>
              </tbody>
            </table>
          </div>

          <h5 class="text-dark text-center">轉銜情形(（系統自動統計時數，不需修改)</h5>

          <div class="col-10 m-2 mx-auto">
            <table class="table table-hover text-center">
              <thead class="thead-dark">
                <tr>
                  <th>項目</th>
                  <th>時數</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>教育資源-已連結小時</td>
                  <td><?php echo (empty($educationSourceHour)) ? "0" : $educationSourceHour ?></td>
                 
                </tr>
                <tr>
                  <td>勞政資源-已連結小時</td>
                  <td><?php echo (empty($laborSourceHour)) ? "0" : $laborSourceHour ?></td>
                 
                </tr>
                <tr>
                  <td>社政資源-已連結小時</td>
                  <td><?php echo (empty($socialSourceHour)) ? "0" : $socialSourceHour ?></td>
                  
                </tr>
                <tr>
                  <td>衛政資源-已連結小時</td>
                  <td><?php echo (empty($healthSourceHour)) ? "0" : $healthSourceHour ?></td>
                 
                </tr>
                <tr>
                  <td>警政資源-已連結小時</td>
                  <td><?php echo (empty($officeSourceHour)) ? "0" : $officeSourceHour ?></td>
                </tr>
                <tr>
                  <td>司法資源-已連結小時</td>
                  <td><?php echo (empty($judicialSourceHour)) ? "0" : $judicialSourceHour ?></td>
                </tr>
                <tr>
                  <td>其他資源-已連結小時</td>
                  <td><?php echo (empty($otherSourceHour)) ? "0" : $otherSourceHour ?></td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- trend -->
          <div class="col-10 m-2 mx-auto">
            <label>結案動向</label>
            <div class="input-group">
              <select class="form-select" name="trend" <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?>>
              <?php if (empty($endCases->trend)) { ?>
                <option disabled selected value>請選擇</option>
                <?php } foreach ($trends as $i) {
                  if (!empty($endCases->trend)) {
                    if ($i['no'] == $endCases->trend) { ?>
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

          <!-- workDescription -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formWorkDescription" class="form-label">就業職種/單位/職稱</label>
              <input class="form-control" type="text" id="formWorkDescription" name="workDescription" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($endCases)) ? "" : $endCases->work_description ?>">
            </div>
          </div>

          <!-- isOriginCompany -->
          <div class="col-10 m-2 mx-auto">
            <label>是否原工作體驗單位留用</label>
            <div class="input-group">
              <select class="form-select" name="isOriginCompany1" <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?>>
              <?php if (isset($endCases->is_origin_company)) {
                  if ($endCases->is_origin_company == "1") { ?>
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

          <!-- schoolDescription -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formSchoolDescription" class="form-label">學校/系科/年級/部別</label>
              <input class="form-control" type="text" id="formSchoolDescription" name="schoolDescription" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($endCases)) ? "" : $endCases->school_description ?>">
            </div>
          </div>

          <!-- trainingDescription -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formTrainingDescription" class="form-label">職訓項目</label>
              <input class="form-control" type="text" id="formTrainingDescription" name="trainingDescription" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($endCases)) ? "" : $endCases->training_description ?>">
            </div>
          </div>

          <!-- unresistibleReason -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formUnresistibleReason" class="form-label">不可抗力說明</label>
              <input class="form-control" type="text" id="formUnresistibleReason" name="unresistibleReason" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($endCases)) ? "" : $endCases->unresistible_reason ?>">
            </div>
          </div>

          <!-- otherDescription -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formOtherDescription" class="form-label">其他說明</label>
              <input class="form-control" type="text" id="formOtherDescription" name="otherDescription" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($endCases)) ? "" : $endCases->other_description ?>">
            </div>
          </div>

          <!-- isCompleteCounsel -->
          <div class="col-10 m-2 mx-auto">
            <label>是否達成輔導目標</label>
            <div class="input-group">
              <select class="form-select" name="isCompleteCounsel" <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?>>
              <?php if (isset($endCases->is_complete_counsel)) {
                  if ($endCases->is_complete_counsel == "1") { ?>
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

          <!-- completeCounselReason -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formCompleteCounselReason" class="form-label">沒有達成輔導目標的原因</label>
              <input class="form-control" type="text" id="formCompleteCounselReason" name="completeCounselReason" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($endCases)) ? "" : $endCases->complete_counsel_reason ?>">
            </div>
          </div>

          <!-- isTransfer -->
          <div class="col-10 m-2 mx-auto">
            <label>是否需後續轉銜</label>
            <div class="input-group">
              <select class="form-select" name="isTransfer" <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?>>
              <?php if (isset($endCases->is_transfer)) {
                  if ($endCases->is_transfer == "1") { ?>
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

          <!-- transferPlace -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formTransferPlace" class="form-label">轉銜單位說明</label>
              <input class="form-control" type="text" id="formTransferPlace" name="transferPlace" placeholder="將與OO高職輔導室保持聯絡" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($endCases)) ? "" : $endCases->transfer_place ?>">
            </div>
          </div>

          <!-- transferReason -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formTransferReason" class="form-label">轉銜原因</label>
              <input class="form-control" type="text" id="formTransferReason" name="transferReason" placeholder="協助個案穩定就學狀況" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($endCases)) ? "" : $endCases->transfer_reason ?>">
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
                <a class="col-10 m-2 mx-auto" href="<?php echo site_url() . '/files/' . $caseAssessments->family_diagram_name; ?>" download="家系圖">家系圖(jpg/png/pdf)</a>
              <?php else: ?>
                <div class="col-10 m-2 mx-auto">
                  <img class="img-fluid" src="<?php echo site_url() . '/files/' . $caseAssessments->family_diagram_name; ?>" />
                </div>
              <?php endif;?>
            <?php endif;?>
          </div>

          <?php if ($hasDelegation != '0' && $youthRate == '100' && $intakeRate == '100' && $caseAssessmentRate == '100' && $individualCounselingRate == '100' && $groupCounselingRate == '100'): ?>
          <div class="row">
            <div class="d-grid gap-2 col-2 mx-auto">
              <button class="btn btn-primary my-5" type="submit">送出</button>
            </div>
          </div>
          <?php else: ?>
            <!-- <h6 class="card-title text-center">有尚未完成之表單(未完成無法結案)</h6>

            <table class="responsive-table highlight">
              <thead class="thead-dark">
                <tr>
                  <?php if ($youthRate != '100'): ?>
                    <th scope="col">基本資料</th>
                  <?php endif;?>
                  <?php if ($intakeRate != '100'): ?>
                    <th scope="col">青少年初評表</th>
                    <?php endif;?>
                  <?php if ($caseAssessmentRate != '100'): ?>
                    <th scope="col">開案學員資料表</th>
                  <?php endif;?>
                  <?php if ($individualCounselingRate != '100'): ?>
                    <th scope="col">個別輔導諮詢</th>
                  <?php endif;?>
                  <?php if ($groupCounselingRate != '100'): ?>
                    <th scope="col">團體輔導諮詢</th>
                  <?php endif;?>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <?php if ($youthRate != '100'): ?>
                    <td>
                      <a class="btn waves-effect blue lighten-1" href="<?php echo site_url('youth/personal_data/' . $youths->no); ?>">查看/修改</a>
                    </td>
                  <?php endif;?>
                  <?php if ($intakeRate != '100'): ?>
                    <td>
                      <a class="btn waves-effect blue lighten-1" href="<?php echo site_url('youth/intake/' . $youths->no); ?>">查看/修改</a>
                    </td>
                  <?php endif;?>
                  <?php if ($caseAssessmentRate != '100'): ?>
                    <td>
                      <a class="btn waves-effect blue lighten-1" href="<?php echo site_url('member/case_assessment/' . $member); ?>">查看/修改</a>
                    </td>
                    <?php endif;?>
                  <?php if ($individualCounselingRate != '100'): ?>
                    <td>
                      <a class="btn waves-effect blue lighten-1" href="<?php echo site_url('member/get_individual_counseling_table_by_member/' . $member); ?>">查看/修改</a>
                    </td>
                    <?php endif;?>
                  <?php if ($groupCounselingRate != '100'): ?>
                    <td>
                      <a class="btn waves-effect blue lighten-1" href="<?php echo site_url('member/get_group_counseling_table_by_member/' . $member); ?>">查看/修改</a>
                    </td>
                  <?php endif;?>
                </tr>
              </tbody>
            </table> -->

          <?php endif;?>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo site_url(); ?>assets/js/ElementBinder.js"></script>
<script type="text/javascript">
  const elementRelation = new ElementBinder();
  // elementRelation.selectInput('trend', 'workDescription', '已就業');
  // elementRelation.selectInput('trend', 'isOriginCompany', '已就業');
  // elementRelation.selectInput('trend', 'schoolDescription', '已就學(全職學生)');
  // elementRelation.selectInput('trend', 'workDescription', '半工半讀');
  // elementRelation.selectInput('trend', 'schoolDescription', '半工半讀');
  // elementRelation.selectInput('trend', 'trainingDescription', '參加職訓');
  // elementRelation.selectInput('trend', 'unresistibleReason', '不可抗力(說明)');
  // elementRelation.selectInput('trend', 'otherDescription', '其他(說明)');

  elementRelation.selectInput('isCompleteCounsel', 'completeCounselReason', '否');
  elementRelation.selectInput('isTransfer', 'transferPlace', '是');
  elementRelation.selectInput('isTransfer', 'transferReason', '是');

</script>

<?php $this->load->view('templates/new_footer');?>
