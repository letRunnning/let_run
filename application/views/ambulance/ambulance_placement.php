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
      <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />

      <?php echo isset($error) ? '<p class="text-danger text-center">' . $error . '</p>' : ''; ?>
      <?php echo isset($success) ? '<p class="text-success text-center">' . $success . '</p>' : ''; ?>

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
          <label>補給站</label>
          <div class="input-group">
            <select class="form-select" name="supply" id="supply">
              <?php if (empty($ambulancePlacement->supply_ID)) { ?>
                <option disabled selected value>請選擇</option>
              <?php } ?>
              <?php foreach ($pass as $i) {
                      if (!empty($ambulancePlacement->supply_ID)) {
                        if ($i['supply_ID'] == $ambulancePlacement->supply_ID) { ?>
                          <option selected value="<?php echo $i['supply_ID']; ?>"><?php echo $i['supply_name']; ?></option>
                  <?php } else { ?>
                          <option value="<?php echo $i['supply_ID']; ?>"><?php echo $i['supply_name']; ?></option>
                  <?php }
                      } else { ?>
                        <option value="<?php echo $i['supply_ID']; ?>"><?php echo $i['supply_name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>

      <div class="row justify-content-center my-3" id="chineseDiv">
        <div class="col-md-5">
          <label>醫院名稱</label>
          <div class="input-group">
            <select class="form-select" name="hospital" id="hospital">
              <?php if (empty($ambulancePlacement->liciense_plate)) { ?>
                <option disabled selected value>請選擇</option>
              <?php } ?>
              <?php foreach ($ambulanceDetails as $i) {
                      if (!empty($ambulancePlacement->liciense_plate)) {
                        if ($i['hospital_name'] == $ambulancePlacement->liciense_plate) { ?>
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
          <label>車牌號碼</label>
            <div class="input-group">
              <select class="form-select" name="liciense" id="liciense">
                <?php if (empty($ambulancePlacement->liciense_plate)) { ?>
                  <option disabled selected value>請選擇</option>
                <?php } ?>
                <?php foreach ($liciensePlate as $i) {
                        if (!empty($ambulancePlacement->liciense_plate)) {
                          if ($i['liciense_plate'] == $ambulancePlacement->liciense_plate) { ?>
                            <option selected value="<?php echo $i['liciense_plate']; ?>"><?php echo $i['liciense_plate']; ?></option>
                  <?php } else { ?>
                          <option value="<?php echo $i['liciense_plate']; ?>"><?php echo $i['liciense_plate']; ?></option>
                  <?php }
                      } else { ?>
                        <option value="<?php echo $i['liciense_plate']; ?>"><?php echo $i['liciense_plate']; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>

      <div class="col-10 m-2 mx-auto">
        <label for="time">時間*</label><br />
        <div class="bootstrap-iso">
        <!-- data-link-field="time" -->
          <div class="input-group date form_datetime col-md-12" >
            <input class="form-control" id="date-daily" onchange="myFunction()" type="text" value="<?php echo (empty($ambulancePlacement)) ? "" : $ambulancePlacement->time ?>" readonly>
            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
          </div>
          <input type="hidden" id="time" name="time" value="" /><br/>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- <script type="text/javascript" src="<?php echo site_url(); ?>assets/jquery/jquery-1.8.3.min.js" charset="UTF-8"></script> -->
<!-- <script type="text/javascript" src="<?php echo site_url(); ?>assets/js/jquery-1.8.3.min.js" charset="UTF-8"></script> -->
<script type="text/javascript" src="<?php echo site_url(); ?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>assets/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>assets/js/locales/bootstrap-datetimepicker.zh-TW.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>assets/js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        language: 'zh-TW',
        format: 'yyyy-mm-dd hh:ii:00',
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        startDate:new Date(),
        showMeridian: 0 // 是否顯示上下午
    });
</script>
<script>
  function myFunction() {
    var x = document.getElementById("date-daily").value;
    document.getElementById("time").value = x;
  }
</script>

<?php $this->load->view('templates/new_footer'); ?>