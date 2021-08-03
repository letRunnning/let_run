<?php $this->load->view('templates/new_header'); ?>
<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/ambulance/ambulance_table'); ?>" <?php echo $url == '/ambulance/ambulance_table' ? 'active' : ''; ?>>救護車清單</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
    </ol>
  </nav>
</div>

<div class="container" style="width:95%">
  <div class="row">
    <form action="<?php echo site_url($url); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
      <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />

      <?php echo isset($error) ? '<p class="red-text text-darken-3 text-center">' . $error . '</p>' : ''; ?>
      <?php echo isset($success) ? '<p class="green-text text-darken-3 text-center">' . $success . '</p>' : ''; ?>

      <div class="row justify-content-center" id="chineseDiv">
        <div class="col-md-5">
          <label>路跑活動</label>
          <div class="input-group">
            <select class="form-select" name="runActive" id="runActive">
              <?php if (empty($ambulance->running_ID)) { ?>
                <option disabled selected value>請選擇</option>
              <?php } ?>
              <?php foreach ($activities as $i) {
                      if (!empty($ambulance->running_ID)) {
                        if ($i['running_ID'] == $ambulance->running_ID) { ?>
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
              <?php if (empty($ambulance->pass_ID)) { ?>
                <option disabled selected value>請選擇</option>
              <?php } ?>
              <?php foreach ($pass as $i) {
                      if (!empty($ambulance->pass_ID)) {
                        if ($i['pass_ID'] == $ambulance->pass_ID) { ?>
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

      <div class="col-10 m-2 mx-auto">
        <label for="hospital" class="form-label">醫院名稱</label>
        <input class="form-control" type="text" id="hospital" name="hospital" value="<?php echo (empty($ambulance)) ? "" : $ambulance->hospital_name ?>" required placeholder="請輸入醫院名稱">
      </div>

      <div class="col-10 m-2 mx-auto">
        <label for="hospitalPhone" class="form-label">醫院電話</label>
        <input class="form-control" type="text" id="hospitalPhone" name="hospitalPhone" value="<?php echo (empty($ambulance)) ? "" : $ambulance->hospital_phone ?>" required placeholder="請輸入醫院電話">
      </div>

      <div class="col-10 m-2 mx-auto">
        <label for="liciensePlate" class="form-label">車牌</label>
        <input class="form-control" type="text" id="liciensePlate" name="liciensePlate" value="<?php echo (empty($ambulance)) ? "" : $ambulance->liciense_plate ?>" required placeholder="請輸入車牌"
          <?php if (!empty($ambulance)) echo "readonly" ?>>
      </div>

      <div class="col-10 m-2 mx-auto">
        <label for="time">時間*</label>
        <div class="input-group date form_datetime col-md-5" data-date-format="yyyy-mm-dd hh:ii" data-link-field="time">
          <input class="form-control" size="16" type="text" value="<?php echo (empty($ambulance)) ? "" : $ambulance->arrivetime ?>" readonly>
          <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
          <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
        </div>
        <input type="hidden" id="time" value="" /><br/>
      </div>

      <div class="row my-5">
        <div class="d-grid gap-2 col-2 mx-auto">
          <button class="btn btn-primary m-3" type="submit">送出</button>
        </div>
      </div>

    </form>
  </div>
</div>

<script type="text/javascript" src="<?php echo site_url(); ?>assets/jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>assets/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>assets/js/locales/bootstrap-datetimepicker.zh-TW.js" charset="UTF-8"></script>

<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        language: 'zh-TW',
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

<?php $this->load->view('templates/new_footer'); ?>