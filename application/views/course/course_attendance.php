<?php $this->load->view('templates/new_header');?>

<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">生涯探索課程或活動(措施B)</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/course/get_course_attendance_table_by_organization'); ?>" <?php echo $url == '/course/get_course_attendance_table_by_organization' ? 'active' : ''; ?>>課程時數清單</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h4 class="text-dark text-center"><?php echo $title ?></h4>
      <div class="card-content">
        <form id="form" action="<?php echo site_url($url); ?>"
          method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />
          <?php echo isset($error) ? '<p class="text-danger text-center">' . $error . '</p>' : ''; ?>
          <?php echo isset($success) ? '<p class="text-success text-center">' . $success . '</p>' : ''; ?>
         
          <!-- course -->
          <div class="col-10 m-2 mx-auto">
            <label>課程名稱*</label>
            <div class="input-group">
              <select class="form-select" name="course" id="course" onchange="location = this.value;" <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?>>
              <?php if (empty($courseAttendances->course)) {?>
                  <option disabled selected value>請選擇</option>
                  <?php } foreach ($courses as $i) {
                    if (!empty($courseAttendances->course)) {
                      if ($i['no'] == $courseAttendances->course) {?>
                        <option selected value="<?php echo site_url($url . '' . $i['no'] . '/' . $startTime); ?>"><?php echo $i['course_name']; ?></option>
                      <?php } else {?>
                        <option value="<?php echo site_url($url . '' . $i['no']. '/' . $startTime); ?>"><?php echo $i['course_name']; ?></option>
                      <?php }
                    } else {
                      if ($i['no'] == $courseType) { ?>
                        <option selected value="<?php echo site_url($url . '' . $i['no']. '/' . $startTime); ?>"><?php echo $i['course_name']; ?></option>
                      <?php } else {?>
                        <option value="<?php echo site_url($url . '' . $i['no']. '/' . $startTime); ?>"><?php echo $i['course_name']; ?></option>
                      <?php }} ?>
                  <?php }?>
              </select>
            </div>
          </div>

          <!-- member -->
          <div class="col-10 m-2 mx-auto">
            <h6><b>參與學員(複選)*</b></h6>
            <div class="row">
              <?php foreach ($members as $i) { ?>
                <div class="col-6">
                  <p><label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="member[]" <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?>
                    <?php if (in_array($i['no'], $participantArray) == 1) {
                      echo "checked";
                    } else {"";}?>
                    value="<?php echo $i['no']; ?>">

                    <span><?php echo $i['system_no'] . $i['name']; ?></span>
                  </label>
                    <a href="<?php echo site_url('member/get_insurance_table_by_member/' . $i['no']); ?>" class="btn btn-primary m-2">投保</a>
                  </p>
                </div>
              <?php }?>
            </div>
          </div>

          <!-- startTime -->
          <div class="row">
            <div class="input-field col s10 offset-m2 m8">
              <input type="text" id="formStartTime" name="startTime" class="datetimepicker" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($courseAttendances)) ? $courseInfo ? $courseInfo->start_time : '' : $courseAttendances->start_time ?>">
              <label for="formStartTime">開始時間*</label>
            </div>
          </div>

          <!-- endTime -->
          <div class="row">
            <div class="input-field col s10 offset-m2 m8">
              <input type="text" id="formEndTime" name="endTime" required class="datetimepicker" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($courseAttendances)) ? $courseInfo? $courseInfo->end_time : '' : $courseAttendances->end_time ?>">
              <label for="formEndTime">結束時間*</label>
            </div>
          </div>

          <!-- duration -->
          <div class="col-10 m-2 mx-auto">
            <label for="formDuration" class="form-label">歷時*</label>
            <input class="form-control" type="number" id="formDuration" name="duration" min="0" step="0.25" placeholder="1" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($courseAttendances)) ? $courseInfo ? (strtotime($courseInfo->end_time) - strtotime($courseInfo->start_time))/3600 : 0 : $courseAttendances->duration ?>">
          </div>

          <div class="col-10 m-2 mx-auto">
            <label for="work_trainning_note" class="form-label">備註*</label>
            <textarea class="form-control" type="text" id="note" name="note" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?>><?php echo (empty($courseAttendances)) ? "" : $courseAttendances->note ?></textarea>
          </div>

          <?php if ($hasDelegation != '0'): ?>
          <div class="row">
            <div class="d-grid gap-2 col-2 mx-auto">
              <button class="btn btn-primary my-5" type="submit">建立</button>
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

  $('#print').click(function () {
        window.print();
  });

  // document.querySelector('input[name="endTime"]').addEventListener("change", myFunction);
  // document.querySelectorAll('select[target="formEndTime"]')
  
  
  document.addEventListener('DOMContentLoaded', function() {
    const selects = document.querySelectorAll('select');
    M.FormSelect.init(selects, {});
    const endTimeSelects = document.querySelectorAll('select[target="formEndTime"]');
    for ( i=0, n=endTimeSelects.length; i < n; i++) {
      endTimeSelects[i].addEventListener("change", myFunction);
    }
  });

  document.addEventListener('DOMContentLoaded', function() {
    const selects = document.querySelectorAll('select');
    M.FormSelect.init(selects, {});
    const startTimeSelects = document.querySelectorAll('select[target="formStartTime"]');
    for ( i=0, n=startTimeSelects.length; i < n; i++) {
      startTimeSelects[i].addEventListener("change", myFunction);
    }
  });
  function myFunction() {
    //value start
    const startTimeSelects = document.querySelectorAll('select[target="formStartTime"]');
    
    var startYear = startTimeSelects[0].value;
    var startMonth = startTimeSelects[1].value;
    var startDay = startTimeSelects[2].value;
    var startHour = startTimeSelects[3].value;
    var startMin = startTimeSelects[4].value;
    var startTime = startYear + '-' + startMonth + '-' + startDay + ' ' + startHour + ':' + startMin + ':00'; 

    const endTimeSelects = document.querySelectorAll('select[target="formEndTime"]');
    
    var endYear = endTimeSelects[0].value;
    var endMonth = endTimeSelects[1].value;
    var endDay = endTimeSelects[2].value;
    var endHour = endTimeSelects[3].value;
    var endMin = endTimeSelects[4].value;
    var endTime = endYear + '-' + endMonth + '-' + endDay + ' ' + endHour + ':' + endMin + ':00'; 

    // var start = Date.parse($('input[name="startTime"]').val()); //get timestamp

    // //value end
    // var end = Date.parse($('input[name="endTime"]').val()); //get timestamp

    var start = Date.parse(startTime); //get timestamp

    //value end
    var end = Date.parse(endTime); //get timestamp

    totalHours = NaN;
  
    if (start < end) {
      totalHours = (end - start) / 1000 / 60 /60 ; //milliseconds: /1000 / 60 / 60
    }
    $("#formDuration").val(totalHours);
  }


</script>

<?php $this->load->view('templates/new_footer');?>
