<?php $this->load->view('templates/new_header');?>

<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">計畫案管理</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>

<div class="container" style="width:100%;">
	<div class="row">
		<div class="card-body col-sm-12">
      <h4 class="card-title text-center"><?php echo $title ?></h4>
      <div class="card-content">
        <form action="<?php echo site_url($url); ?>"
          method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <input class="form-control" type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />
          <?php echo isset($error) ? '<p class="red-text text-darken-1 text-center">' . $error . '</p>' : ''; ?>
          <?php echo isset($success) ? '<p class="green-text text-accent-4 text-center">' . $success . '</p>' : ''; ?>

                    <!-- executeWay -->
        <div class="row">
          <div class="input-field col-10 s10 offset-m2 m8 mx-auto">
              <label>辦理方式*</label>
              <select class="form-select" name="executeWay">
                <?php if (empty($projects->execute_way)) {?>
                  <option disabled selected value>請選擇</option>
                  <?php }
foreach ($executeWays as $i) {
    if (!empty($projects->execute_way)) {
        if ($i['no'] == $projects->execute_way) {?>
                      <option selected value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                    <?php } else {?>
                      <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                    <?php }
    } else {?>
                    <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                  <?php }?>
                <?php }?>
              </select>
            </div>
          </div>

          <!-- executeMode -->
          <div class="row">
          <div class="input-field col-10 s10 offset-m2 m8 mx-auto">
              <label>辦理模式</label>
              <select class="form-select" name="executeMode">
                <?php if (empty($projects->execute_mode)) {?>
                  <option disabled selected value>請選擇</option>
                  <?php }
foreach ($executeModes as $i) {
    if (!empty($projects->execute_mode)) {
        if ($i['no'] == $projects->execute_mode) {?>
                                        <option selected value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                                      <?php } else {?>
                                        <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                                      <?php }
    } else {?>
                    <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                  <?php }?>
                <?php }?>
              </select>
            </div>
          </div>

          
          <div class="col-10 m-2 mx-auto">
            <label for="formYear">年度*</label>
            <input class="form-control" type="number" min="<?php echo date("Y") - 1911 ?>" id="formYear" name="year" value="<?php echo (empty($projects)) ? "" : $projects->year ?>">
          </div>

        <!-- name -->
        
          <div class="col-10 m-2 mx-auto">
            <label for="formName">計畫名稱</label>
            <input class="form-control" type="text" id="formName" name="name" value="<?php echo (empty($projects)) ? (date("Y") - 1911) . '年' . $countyName . '青少年生涯探索號' : $projects->name ?>" required>
          </div>

        
          <div class="col-10 m-2 mx-auto">
            <label for="formCounselorCount">輔導員數量*</label>
            <input class="form-control" type="number" min="0" id="formCounselorCount" name="counselorCount" value="<?php echo (empty($projects)) ? "" : $projects->counselor_count ?>" required>
          </div>
        
          <div class="col-10 m-2 mx-auto">
            <label for="formMeetingCount">跨局處會議次數</label>
            <input class="form-control" type="number" min="0" id="formMeetingCount" name="meetingCount" value="<?php echo (empty($projects)) ? "" : $projects->meeting_count ?>">
          </div>
        
          <div class="col-10 m-2 mx-auto">
            <label for="formCounselingYouth">預計關懷追蹤人數</label>
            <input class="form-control" type="number" min="0" id="formCounselingYouth" name="counselingYouth" value="<?php echo (empty($projects)) ? "" : $projects->counseling_youth ?>">
          </div>
        
          <div class="col-10 m-2 mx-auto">
            <label for="formCounselingMember">預計輔導人數</label>
            <input class="form-control" type="number" min="0" id="formCounselingMember" name="counselingMember" value="<?php echo (empty($projects)) ? "" : $projects->counseling_member ?>">
          </div>
        
          <div class="col-10 m-2 mx-auto">
            <label for="formCounselingHour">個別諮詢(小時)</label>
            <input class="form-control" type="number" min="0" max="80" id="formCounselingHour" name="counselingHour" value="<?php echo (empty($projects)) ? "" : $projects->counseling_hour ?>">
          </div>
        
          <div class="col-10 m-2 mx-auto">
            <label for="formGroupCounselingHour">團體輔導(小時)</label>
            <input class="form-control" type="number" min="0" max="80" id="formGroupCounselingHour" name="groupCounselingHour" value="<?php echo (empty($projects)) ? "" : $projects->group_counseling_hour ?>">
          </div>
        
          <div class="col-10 m-2 mx-auto">
            <label for="formCourseHour">生涯探索課程或活動(小時)</label>
            <input class="form-control" type="number" min="0" max="140" id="formCourseHour" name="courseHour" value="<?php echo (empty($projects)) ? "" : $projects->course_hour ?>">
          </div>
        
          <div class="col-10 m-2 mx-auto">
            <label for="formWorkingMember">工作體驗(人)</label>
            <input class="form-control" type="number" min="0" id="formWorkingMember" name="workingMember" value="<?php echo (empty($projects)) ? "" : $projects->working_member ?>">
          </div>
        
          <div class="col-10 m-2 mx-auto">
            <label for="formWorkingHour">工作體驗(小時/人)</label>
            <input class="form-control" type="number" min="0" id="formWorkingHour" name="workingHour" value="<?php echo (empty($projects)) ? "" : $projects->working_hour ?>">
          </div>
        
          <div class="col-10 m-2 mx-auto">
            <label for="formTrackDescription">輔導個案之後續轉銜及追蹤:</label>
            <textarea class="form-control" id="formTrackDescription" class="materialize-textarea" placeholder=""
              name="trackDescription"><?php echo (empty($projects)) ? "" : $projects->track_description ?></textarea>
          </div>
        
          <div class="col-10 m-2 mx-auto">
            <label for="formFunding">計畫總經費</label>
            <input class="form-control" type="number" min="0" id="formFunding" name="funding" value="<?php echo (empty($projects)) ? "" : $projects->funding ?>">
          </div>

        
          <div class="col-10 m-2 mx-auto">
            <label for="formNote">備註:</label>
            <textarea class="form-control" id="formNote" class="materialize-textarea" placeholder=""
              name="note"><?php echo (empty($projects)) ? "" : $projects->note ?></textarea>
          </div>

          <!-- <div class="row">
            <div class="input-field col s10 offset-m2 m8"></div>
              <input type="text" id="formDate" name="date" class="datepicker" value="<?php echo (empty($projects)) ? "" : $projects->date ?>">
              <label for="formDate">填表日期*</label>
            </div>
          </div> -->

          <?php if ($isUpdateProject == 1): ?>
          <div class="row">
            <button class="btn waves-effect col s6 offset-m4 m4 blue darken-4" type="submit">建立</button>
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
  elementRelation.selectInput('executeWay', 'executeMode', '委辦');


</script>


<?php $this->load->view('templates/new_footer');?>