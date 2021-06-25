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
        <a href="<?php echo site_url('/course/get_course_table_by_organization'); ?>" <?php echo $url == '/course/get_course_table_by_organization' ? 'active' : ''; ?>>課程開設清單</a>
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
        <form action="<?php echo site_url($url);?>" 
          method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />
          <?php echo isset($error) ? '<p class="text-danger text-center">'.$error.'</p>' : '';?>
          <?php echo isset($success) ? '<p class="text-success text-center">'.$success.'</p>' : '';?>

          <!-- courseReference -->
          <div class="col-10 m-2 mx-auto">
            <label>課程名稱*</label>
            <div class="input-group">
              <select class="form-select" name="courseReference" id="courseReference">
              <?php if (empty($courses->course_reference)) { ?>
                <option disabled selected value>請選擇</option>
              <?php } ?>
              <?php foreach ($courseReferences as $i) {
                      if (!empty($courses->course_reference)) {
                        if ($i['no'] == $courses->course_reference) { ?>
                          <option selected value="<?php echo $i['no'];?>"><?php echo $i['name'];?></option>
                  <?php } else { ?>
                          <option value="<?php echo $i['no'];?>"><?php echo $i['name'];?></option>
                  <?php }
                      } else {?>
                          <option value="<?php echo $i['no'];?>"><?php echo $i['name'];?></option>
                <?php } ?>
              <?php } ?>
              </select>
              <a href="<?php echo site_url('course/course_reference/');?>" class="btn btn-primary m-1">+</a>
            </div>
          </div>
          
          <!-- startTime -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formStartTime">開始時間</label>
              <input class="form-control datepickerTW" type="text" id="formStartTime" name="startTime"
              value="<?php echo (empty($courses)) ? "" : $courses->start_time ?>">
            </div>
          </div>

          <!-- endTime -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formEndTime">結束時間</label>
              <input class="form-control datepickerTW" type="text" id="formEndTime" name="endTime"
              value="<?php echo (empty($courses)) ? "" : $courses->end_time ?>">
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="col-md-5" >
            <label for="formStartTime">開始時間(日期)</label>
              <input class="form-control" type="text" id="formStartTime" name="startTime"
              value="<?php echo (empty($courses)) ? "" : $courses->start_time ?>">
            </div>
            <div class="col-md-5">
            <label for="formStartTime">時間</label>
              <input class="form-control time-picker" type="text" id="formStartTime" name="startTime"
              value="<?php echo (empty($courses)) ? "" : $courses->start_time ?>">
            </div>
          </div>

          <!-- <div class="row justify-content-center">
            <div class="col-sm-10 col-md-3 mb-3" id="chineseDiv">
              <label for="formDate">民國年追蹤日期*</label>
              <input type="text" id="dateTo" class="form-control">
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="col-sm-10 col-md-3 mb-3">
              <label for="formDate">民國年追蹤日期*</label>
              <input type="text" name="date" id="hiddenTo" class="form-control"/>
            </div>
          </div> -->

          <div class="col-md-6">
            <div class="md-form">
            <label>timepicker</label>
            <input type="text" class="time-picker form-control" name="3" >
            </div>
          </div>

          <div class="row">
            <div class="d-grid gap-2 col-2 mx-auto">
              <button class="btn btn-primary m-3" type="submit">送出</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo site_url();?>assets/js/ElementBinder.js"></script>
<script type="text/javascript">
  // $('.datepickerTW').datepickerTW();
  // $(".time-picker").hunterTimePicker();

  const elementRelation = new ElementBinder();
  
</script>

<?php $this->load->view('templates/new_footer');?>
