<?php $this->load->view('templates/new_header');?>

<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">工作體驗(措施C)</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/work/get_work_attendance_table_by_organization'); ?>" <?php echo $url == '/work/get_work_attendance_table_by_organization' ? 'active' : ''; ?>>工作體驗時數清單</a>
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
        <form action="<?php echo site_url($url); ?>"
          method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />
          <?php echo isset($error) ? '<p class="text-danger text-center">' . $error . '</p>' : ''; ?>
          <?php echo isset($success) ? '<p class="text-success text-center">' . $success . '</p>' : ''; ?>

          <!-- workExperience -->
          <div class="col-10 m-2 mx-auto">
            <label>店家名稱*</label>
            <div class="input-group">
              <select class="form-select" name="workExperience" onchange="location = this.value;" <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?>>
              <?php if (empty($workAttendances->work_experience)) { ?>
                <option disabled selected value>請選擇</option>
              <?php } ?>
              <?php foreach ($workExperiences as $i) {
                      if (!empty($workAttendances->work_experience)) {
                        if ($i['no'] == $workAttendances->work_experience) { ?>
                          <option selected value="<?php echo site_url('work/work_attendance/' . '' . $i['no'] . '/' . $no); ?>"><?php echo $i['name']; ?></option>
                  <?php } else { ?>
                    <option value="<?php echo site_url('work/work_attendance/' . '' . $i['no'] . '/' . $no); ?>"><?php echo $i['name']; ?></option>
                  <?php }
                      } else { 
                        if ($i['no'] == $workType) { ?>
                          <option selected value="<?php echo site_url('work/work_attendance/' . '' . $i['no'] . '/' . $no); ?>"><?php echo $i['name']; ?></option>
                        <?php } else { ?>
                          <option value="<?php echo site_url('work/work_attendance/' . '' . $i['no'] . '/' . $no); ?>"><?php echo $i['name']; ?></option>
                    <?php } }?>
                  <?php }?>
              </select>
              <a href="<?php echo site_url('work/work_experience/');?>" class="btn btn-primary m-1 input-group-text">+</a>
            </div>
          </div>

          <!-- member -->
          <div class="col-10 m-2 mx-auto">
            <label>學員名稱*</label>
            <div class="input-group">
              <select class="form-select" name="member" id="member" <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?>>
              <?php if (empty($workAttendances->member)) { ?>
                <option disabled selected value>請選擇</option>
              <?php } ?>
              <?php foreach ($members as $i) {
                      if (!empty($workAttendances->member)) {
                        if ($i['no'] == $workAttendances->member) { ?>
                          <option selected value="<?php echo $i['no']; ?>"><?php echo $i['system_no'] . $i['name']; ?></option>
                  <?php } else { ?>
                          <option value="<?php echo $i['no']; ?>"><?php echo $i['system_no'] . $i['name']; ?></option>
                  <?php }
                      } else {?>
                          <option value="<?php echo $i['no']; ?>"><?php echo $i['system_no'] . $i['name']; ?></option>
                <?php } ?>
              <?php } ?>
              </select>
              <a href="<?php echo site_url('member/get_member_table_by_counselor/');?>" class="btn btn-primary m-1">投保</a>
            </div>
          </div>


          <!-- startTime -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formStartTime">開始時間*</label>
              <input class="form-control datepickerTW" type="text" id="formStartTime" name="startTime" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($workAttendances)) ? $workInfo ? $workInfo->start_time : '' : $workAttendances->start_time ?>">
            </div>
          </div>

          <!-- endTime -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formEndTime">結束時間*</label>
              <input class="form-control datepickerTW" type="text" id="formEndTime" name="endTime" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($workAttendances)) ? $workInfo ? $workInfo->end_time : '' : $workAttendances->end_time ?>">
            </div>
          </div>

          <!-- duration -->
          <div class="col-10 m-2 mx-auto">
            <label for="formDuration" class="form-label">上班時數*</label>
            <input readonly class="form-control" type="number" id="formDuration" min="0" name="duration" step="0.25" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($workAttendances)) ? $workInfo ? (strtotime($workInfo->end_time) - strtotime($workInfo->start_time))/3600 : '' : $workAttendances->duration ?>">
          </div>

          <div class="col-10 m-2 mx-auto">
            <label for="work_trainning_note" class="form-label">備註*</label>
            <input class="form-control" type="text" id="note" name="note" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($workAttendances)) ? "" : $workAttendances->note ?>">
          </div>

          <?php if ($hasDelegation != '0'): ?>
            <div class="d-grid gap-2 col-2 mx-auto">
              <button class="btn btn-primary m-3" type="submit">送出</button>
            </div>
          <?php endif;?>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo site_url(); ?>assets/js/ElementBinder.js"></script>
<script type="text/javascript">
  $('.datepickerTW').datepickerTW();
  const elementRelation = new ElementBinder();
  $('#member').change(function() {
    var conceptName = $('#member').find(":selected").val();

    console.log('val' + conceptName);
  });

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
<script type="text/javascript" src="<?php echo site_url(); ?>assets/js/ModeSwitch.js"></script>
<?php $this->load->view('templates/new_footer');?>
