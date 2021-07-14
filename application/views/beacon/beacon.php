<?php $this->load->view('templates/new_header');?>
<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">Beacon</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/beacon/beacon_table'); ?>" <?php echo $url == '/beacon/beacon_table' ? 'active' : ''; ?>>Beacon清單</a>
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

      <div class="col-10 m-2 mx-auto">
        <label for="beaconID" class="form-label">Beacon編號</label>
        <input class="form-control" type="text" id="beaconID" name="beaconID" value="<?php echo (empty($beacon)) ? "" : $beacon->beacon_ID ?>" required placeholder="請輸入Beacon編號"
          <?php if (!empty($beacon)) {
                  echo 'readonly';
                } ?>
        >
      </div>

      <div class="col-10 m-2 mx-auto">
        <label for="beaconType" class="form-label">Beacon型號</label>
        <input class="form-control" type="text" id="beaconType" name="beaconType" value="<?php echo (empty($beacon)) ? "" : $beacon->type ?>" required placeholder="請輸入Beacon型號">
      </div>

      <div class="col-10 m-2 mx-auto">
        <label>是否可使用</label>
        <div class="input-group">
          <select class="form-select" name="isAvailable" id="isAvailable">
          <?php if ($beacon->is_available == "0" || $beacon->is_available == "1") {
              if ($beacon->is_available == "1") { ?>
              <option value="1" selected>是</option>
              <option value="0">否</option>
            <?php } else { ?>
              <option value="1">是</option>
              <option value="0" selected>否</option>
            <?php }
            } else { ?>
              <option disabled selected value>請選擇</option>
              <option value="1">是</option>
              <option value="0">否</option>
            <?php } ?>
          </select>
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
<?php $this->load->view('templates/new_footer');?>