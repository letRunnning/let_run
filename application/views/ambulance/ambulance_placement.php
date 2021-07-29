<?php $this->load->view('templates/new_header'); ?>
<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/ambulance/ambulance_placement_table'); ?>" <?php echo $url == '/ambulance/ambulance_placement_table' ? 'active' : ''; ?>>救護車停置點清單</a>
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
          <div class="input-group">
            <select class="form-select" name="runActive" id="runActive">
              <?php if (empty($ambulancePlacement->running_ID)) { ?>
                <option disabled selected value>請選擇</option>
              <?php } ?>
              <?php foreach ($activities as $i) {
                      if (!empty($ambulancePlacement->running_ID)) {
                        if ($i['running_ID'] == $ambulancePlacement->running_ID) { ?>
                          <option selected value="<?php echo $i['running_ID']; ?>"><?php echo $i['name']; ?></option>
                  <?php } else { ?>
                          <option value="<?php echo $i['running_ID']; ?>"><?php echo $i['name']; ?></option>
                  <?php }
                      } else { ?>
                        <option value="<?php echo $i['running_ID']; ?>"><?php echo $i['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="col-md-5">
          <label>經過點</label>
          <div class="input-group">
            <select class="form-select" name="passPoint" id="passPoint">
              <?php if (empty($ambulancePlacement->pass_ID)) { ?>
                <option disabled selected value>請選擇</option>
              <?php } ?>
              <?php foreach ($pass as $i) {
                      if (!empty($ambulancePlacement->pass_ID)) {
                        if ($i['pass_ID'] == $ambulancePlacement->pass_ID) { ?>
                          <option selected value="<?php echo $i['pass_ID']; ?>"><?php echo $i['pass_name']; ?></option>
                  <?php } else { ?>
                          <option value="<?php echo $i['pass_ID']; ?>"><?php echo $i['pass_name']; ?></option>
                  <?php }
                      } else { ?>
                        <option value="<?php echo $i['pass_ID']; ?>"><?php echo $i['pass_name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>

      <div class="row justify-content-center" id="chineseDiv">
        <div class="col-md-5">
          <label>醫院</label>
          <div class="input-group">
            <select class="form-select" name="hospital" id="hospital">
              <?php if (empty($ambulancePlacement->hospital_name)) { ?>
                <option disabled selected value>請選擇</option>
              <?php } ?>
              <?php foreach ($pass as $i) {
                      if (!empty($ambulancePlacement->hospital_name)) {
                        if ($i['hospital_name'] == $ambulancePlacement->hospital_name) { ?>
                          <option selected value="<?php echo $i['hospital_name']; ?>"><?php echo $i['hospital_name']; ?></option>
                  <?php } else { ?>
                          <option value="<?php echo $i['hospital_name']; ?>"><?php echo $i['hospital_name']; ?></option>
                  <?php }
                      } else { ?>
                        <option value="<?php echo $i['hospital_name']; ?>"><?php echo $i['hospital_name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
          </div>
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