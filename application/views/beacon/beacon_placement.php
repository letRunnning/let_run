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
        <a href="<?php echo site_url('/beacon/beacon_placement_table'); ?>" <?php echo $url == '/beacon/beacon_placement_table' ? 'active' : ''; ?>>Beacon放置點清單</a>
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
        <label>Beacon編號</label>
        <div class="input-group">
          <select class="form-select" name="beaconID" id="beaconID">
            <?php if (empty($beaconPlacement->beacon_ID)) { ?>
              <option disabled selected value>請選擇</option>
            <?php } ?>
            <?php foreach ($beacons as $i) {
                    if (!empty($beaconPlacement->beacon_ID)) {
                      if ($i['beacon_ID'] == $beaconPlacement->beacon_ID) { ?>
                        <option selected value="<?php echo $i['beacon_ID']; ?>"><?php echo $i['beacon_ID']; ?></option>
                <?php } else { ?>
                        <option value="<?php echo $i['beacon_ID']; ?>"><?php echo $i['beacon_ID']; ?></option>
                <?php }
                    } else { ?>
                      <option value="<?php echo $i['beacon_ID']; ?>"><?php echo $i['beacon_ID']; ?></option>
              <?php } ?>
            <?php } ?>
          </select>
        </div>
      </div>

      <div class="row justify-content-center" id="chineseDiv">
        <div class="col-md-5">
          <label>路跑活動</label>
          <div class="input-group">
            <select class="form-select" name="runActive" id="runActive">
              <?php if (empty($beaconPlacement->running_ID)) { ?>
                <option disabled selected value>請選擇</option>
              <?php } ?>
              <?php foreach ($activities as $i) {
                      if (!empty($beaconPlacement->running_ID)) {
                        if ($i['running_ID'] == $beaconPlacement->running_ID) { ?>
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
            <select class="form-select" name="supplyID" id="supplyID">
              <?php if (empty($beaconPlacement->supply_ID)) { ?>
                <option disabled selected value>請選擇</option>
              <?php } ?>
              <?php foreach ($supply as $i) {
                      if (!empty($beaconPlacement->supply_ID)) {
                        if ($i['supply_ID'] == $beaconPlacement->supply_ID) { ?>
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

      <div class="row my-5">
        <div class="d-grid gap-2 col-2 mx-auto">
          <button class="btn btn-primary m-3" type="submit">送出</button>
        </div>
      </div>

    </form>
  </div>
</div>
<?php $this->load->view('templates/new_footer');?>