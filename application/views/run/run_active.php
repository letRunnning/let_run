<?php $this->load->view('templates/new_header');?>
<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">路跑活動</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/run/run_active_table'); ?>">路跑活動清單</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>

<div class="container">
    <div class="row">
      <form action="<?php echo site_url($url); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
      <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />
      
      <?php echo isset($error) ? '<p class="red-text text-darken-3 text-center">' . $error . '</p>' : ''; ?>
      <?php echo isset($success) ? '<p class="green-text text-darken-3 text-center">' . $success . '</p>' : ''; ?>
            
            <div class="col-10 m-2 mx-auto">
                <label for="runName" class="form-label">活動名稱</label>
                <input class="form-control" type="text" id="runName" name="runName" value="<?php echo (empty($activity)) ? "" : $activity->name ?>" placeholder="請輸入活動名稱">
            </div>
            <div class="row justify-content-center">
                <div class="col-10 m-2 mx-auto" id="chineseDiv">
                <label for="formDate">活動日期</label>
                <input type="text" id="dateRun" name="dateRun" class="form-control" value="<?php echo (empty($activity)) ? "" : $activity->date ?>" placeholder="請輸入活動日期">
                </div>
            </div>
            <div class="col-10 m-2 mx-auto">
                <label for="place" class="form-label">活動地點</label>
                <input class="form-control" type="text" id="place" name="place" value="國立暨南大學" placeholder="請輸入活動名稱">
            </div> 
            <!-- startTime -->
            <div class="row justify-content-center" id="chineseDiv">
                <div class="col-md-5">
                  <label for="formStartTime">開始報名時間(日期)*</label>
                  <input class="form-control" type="text" id="dateFrom"  name="startDate" value="<?php echo (empty($activity)) ? "" : substr($activity->start_time, 0, 10) ?>">
                </div>
                <div class="col-md-5">
                  <label for="formStartTime">開始報名時間(時間)*</label>
                  <input class="form-control time-picker-start" type="text" id="formStartTime" name="startTime" value="<?php echo (empty($activity)) ? "" : substr($activity->start_time, 11, strlen($activity->start_time)) ?>">
                </div>
            </div>
          <!-- endTime -->
          <div class="row justify-content-center">
            <div class="col-md-5">
              <label for="formEndTime">結束報名時間(日期)*</label>
              <input class="form-control" type="text" id="dateTo" name="endDate" value="<?php echo (empty($activity)) ? "" : $activity->date ?>">
            </div>
            <div class="col-md-5">
              <label for="formEndTime">結束報名時間(時間)*</label>
              <input class="form-control time-picker-end" type="text" id="formEndTime" name="endTime" value="<?php echo (empty($activity)) ? "" : $activity->date ?>">
            </div>
          </div>
          <div class="col-10 m-2 mx-auto">
                <label for="bankCode" class="form-label">銀行代號</label>
                <input class="form-control" type="text" id="bankCode" name="bankCode" value="<?php echo (empty($activity)) ? "" : $activity->bank_code ?>" placeholder="請輸入銀行代號">
            </div> 
          <div class="col-10 m-2 mx-auto">
              <label for="bankAccount" class="form-label">銀行帳號</label>
              <input class="form-control" type="text" id="bankAccount" name="bankAccount" value="<?php echo (empty($activity)) ? "" : $activity->bank_account ?>" placeholder="****-****-****-****">
          </div> 
          <div class="col-10 m-2 mx-auto">
            <label for="photoFile">上傳圖片(jpg/png/pdf)</label>
            <input type="file" id="photoFile" name="photoFile" class="form-control" >
          </div>
          <?php if (!empty($activity)): ?>
          <div class="col-10 m-2 mx-auto">
              <img class="img-fluid" style="width:250px"
                src="<?php echo site_url() . '/files/photo/' . $activity->photo_name; ?>" />
            </div>
          <?php endif; ?>

          <div class="row">
            <div class="d-grid gap-2 col-2 mx-auto">
              <button class="btn btn-primary m-3" type="submit">送出</button>
            </div>
          </div>
        </form>
    </div>
    <br><br><br><br><br><br><br>
</div>
<?php $this->load->view('templates/new_footer');?>