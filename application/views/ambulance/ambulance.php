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

      <div class="col-10 m-2 mx-auto">
        <label for="hospital" class="form-label">醫院名稱</label>
        <input class="form-control" type="text" id="hospital" name="hospital" value="<?php echo (empty($ambulance)) ? "" : $ambulance->hospital_name ?>" required placeholder="請輸入醫院名稱">
      </div>

      <div class="col-10 m-2 mx-auto">
        <label for="hospitalPhone" class="form-label">醫院電話</label>
        <input class="form-control" type="text" id="hospitalPhone" name="hospitalPhone" value="<?php echo (empty($ambulance)) ? "" : $ambulance->hospital_phone ?>" required placeholder="請輸入醫院電話">
      </div>

      <div class="col-10 m-2 mx-auto">
        <label for="licensePlate" class="form-label">車牌</label>
        <input class="form-control" type="text" id="licensePlate" name="licensePlate" value="<?php echo (empty($ambulance)) ? "" : $ambulance->liciense_plate ?>" required placeholder="請輸入車牌">
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