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

      <div class="col-10 m-2 mx-auto">
        <label for="beaconID" class="form-label">Beacon編號</label>
        <input class="form-control" type="text" id="beaconID" name="beaconID" value="" required placeholder="請輸入Beacon編號">
      </div>

      <div class="col-10 m-2 mx-auto">
        <label for="beaconModel" class="form-label">Beacon型號</label>
        <input class="form-control" type="text" id="beaconModel" name="beaconModel" value="" required placeholder="請輸入Beacon型號">
      </div>

      <div class="row">
        <div class="d-grid gap-2 col-2 mx-auto">
          <button class="btn btn-primary m-3" type="submit">送出</button>
        </div>
      </div>
      <br><br><br><br>
    </form>
  </div>
</div>
<?php $this->load->view('templates/new_footer');?>