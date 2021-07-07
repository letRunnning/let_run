<?php $this->load->view('templates/new_header'); ?>
<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/ambulance/ambulance_table'); ?>" <?php echo $url == '/ambulance/ambulance_table' ? 'active' : ''; ?>>救護車資訊清單</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
    </ol>
  </nav>
</div>

<div class="container" style="width:95%">
  <div class="row">
    <form action="<?php echo site_url($url); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
      
      <div class="row justify-content-center" id="chineseDiv">
        <div class="col-md-5">
          <label>路跑活動</label>
          <select class="form-select mb-3" name="runActive" id="runActive" >
            <option selected value="">請選擇</option>
            <option value="A1">暨大春健</option>
            <option value="A2">台中花博馬拉松</option>
          </select>
        </div>

        <!-- <div class="col-md-5">
          <label>路跑組別</label>
          <select class="form-select mb-3" name="runGroup" id="runGroup" >
            <option selected value="">請選擇</option>
            <option value="10K休閒組">10K休閒組</option>
            <option value="15K挑戰組">15K挑戰組</option>
          </select>
        </div>
      </div> -->

        <!-- <div class="col-10 m-2 mx-auto"> -->
        <div class="col-md-5">
          <label>經過點</label>
          <select class="form-select mb-3" name="passPoint" id="passPoint" >
            <option selected value="">請選擇</option>
            <option value="暨大大草原">暨大大草原</option>
            <option value="暨大體育館">暨大體育館</option>
          </select>
        </div>
      </div>

      <div class="row justify-content-center" id="chineseDiv">
        <div class="col-md-5">
          <label>醫院</label>
          <select class="form-select mb-3" name="hospital" id="hospital" >
            <option selected value="">請選擇</option>
            <option value="林氏醫院">林氏醫院</option>
            <option value="陳氏醫院">陳氏醫院</option>
          </select>
        </div>

        <div class="col-md-5">
          <label>車牌</label>
          <select class="form-select mb-3" name="hospital" id="hospital" >
            <option selected value="">請選擇</option>
            <option value="MVP-8877">MVP-8877</option>
            <option value="MVP-7799">MVP-7799</option>
          </select>
        </div>
      </div>

      <!-- startTime -->
      <div class="row justify-content-center" id="chineseDiv">
        <div class="col-md-5">
          <label for="formStartTime">時間(日期)*</label>
          <!-- <input class="form-control" type="text" id="dateFrom" value="<?php echo (empty($date_start)) ? "" : $date_start ?>"> -->
          <input class="form-control" type="text" id="dateFrom" name="startDate">
        </div>
        <div class="col-md-5">
          <label for="formStartTime">時間(時間)*</label>
          <!-- <input class="form-control time-picker-start" type="text" id="formStartTime" value="<?php echo (empty($time_start)) ? "" : $time_start ?>"> -->
          <input class="form-control time-picker-start" type="text" id="formStartTime" name="startTime">
        </div>
      </div>

      <div class="row my-5">
        <div class="d-grid gap-2 col-2 mx-auto">
          <button class="btn btn-primary m-3" type="submit">送出</button>
        </div>
      </div>

    </form>
  </div>
</div>
<?php $this->load->view('templates/new_footer'); ?>