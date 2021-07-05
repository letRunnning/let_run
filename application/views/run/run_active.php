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
    <!-- <h4 class="text-dark text-center"><?php echo $title ?></h4> -->
        <form action="<?php echo site_url($url); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
        <?php foreach($activity as $i){
            
        ?>
            <div class="col-10 m-2 mx-auto">
                <label for="runName" class="form-label">活動名稱</label>
                <input class="form-control" type="text" id="runName" name="runName" value="<?php echo $i['name'];?>" required placeholder="請輸入活動名稱">
            </div>
            <div class="row justify-content-center">
                <div class="col-10 m-2 mx-auto" id="chineseDiv">
                <label for="formDate">活動日期</label>
                <input type="text" id="dateRun" class="form-control" value="<?php echo $i['date'];?>" required placeholder="請輸入活動日期">
                </div>
            </div>
            <div class="col-10 m-2 mx-auto">
                <label for="place" class="form-label">活動地點</label>
                <input class="form-control" type="text" id="place" name="place" value="國立暨南大學" required placeholder="請輸入活動名稱">
            </div> 
            <!-- startTime -->
            <div class="row justify-content-center" id="chineseDiv">
                <div class="col-md-5">
                <label for="formStartTime">開始報名時間(日期)*</label>
                <!-- <input class="form-control" type="text" id="dateFrom" value="<?php echo (empty($date_start)) ? "" : $date_start ?>"> -->
                <input class="form-control" type="text" id="dateFrom" name="startDate">
                </div>
                <div class="col-md-5">
                <label for="formStartTime">開始報名時間(時間)*</label>
                <!-- <input class="form-control time-picker-start" type="text" id="formStartTime" value="<?php echo (empty($time_start)) ? "" : $time_start ?>"> -->
                <input class="form-control time-picker-start" type="text" id="formStartTime" name="startTime">
                </div>
            </div>
          <!-- endTime -->
          <div class="row justify-content-center">
            <div class="col-md-5">
              <label for="formEndTime">結束報名時間(日期)*</label>
              <input class="form-control" type="text" id="dateTo" name="endDate">
            </div>
            <div class="col-md-5">
              <label for="formEndTime">結束報名時間(時間)*</label>
              <input class="form-control time-picker-end" type="text" id="formEndTime" name="endTime">
            </div>
          </div>
          <div class="col-10 m-2 mx-auto">
                <label for="bankCode" class="form-label">銀行代號</label>
                <input class="form-control" type="text" id="bankCode" name="bankCode" value="" required placeholder="請輸入銀行代號">
            </div> 
          <div class="col-10 m-2 mx-auto">
              <label for="bankAccount" class="form-label">銀行帳號</label>
              <input class="form-control" type="text" id="bankAccount" name="bankAccount" value="" required placeholder="請輸入銀行帳號">
          </div> 
          <div class="col-10 m-2 mx-auto">
            <label for="photoFile">上傳圖片</label>
            <input type="file" id="photoFile" name="photoFile" class="form-control" value="" required >
          </div>
          <div class="row">
            <div class="d-grid gap-2 col-2 mx-auto">
              <button class="btn btn-primary m-3" type="submit">送出</button>
            </div>
          </div>
          <?php }?>
        </form>
    </div>
    <br><br><br><br><br><br><br>
</div>
<?php $this->load->view('templates/new_footer');?>