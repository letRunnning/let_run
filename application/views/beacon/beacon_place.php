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
        <a href="<?php echo site_url('/beacon/beacon_place_table'); ?>" <?php echo $url == '/beacon/beacon_place_table' ? 'active' : ''; ?>>Beacon放置點清單</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
    </ol>
  </nav>
</div>

<div class="container" style="width:95%">
  <div class="row">
    <form action="<?php echo site_url($url); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
      
      <div class="col-10 m-2 mx-auto">
        <label>Beacon編號</label>
        <select class="form-select mb-3" name="beaconID" id="beaconID" >
          <option selected value="">請選擇</option>
          <option value="Ada Lovelace">Ada Lovelace</option>
          <option value="Grace Hopper">Grace Hopper</option>
        </select>
      </div>

      <div class="row justify-content-center" id="chineseDiv">
        <div class="col-md-5">
          <label>路跑活動</label>
          <select class="form-select mb-3" name="runActive" id="runActive" >
            <option selected value="">請選擇</option>
            <option value="A1">暨大春健</option>
            <option value="A2">台中花博馬拉松</option>
          </select>
        </div>

        <div class="col-md-5">
          <label>路跑組別</label>
          <select class="form-select mb-3" name="runGroup" id="runGroup" >
            <option selected value="">請選擇</option>
            <option value="10K休閒組">10K休閒組</option>
            <option value="15K挑戰組">15K挑戰組</option>
          </select>
        </div>
      </div>

      <!-- <div class="col-10 m-2 mx-auto">
        <label for="order" class="form-label">順序</label>
        <input class="form-control" type="text" id="order" name="order" value="" required placeholder="請輸入順序">
      </div> -->

      <div class="row justify-content-center" id="chineseDiv">
        <div class="col-md-5">
          <label for="longitude" class="form-label">經度</label>
          <input class="form-control" type="text" id="longitude" name="longitude" value="" required placeholder="請輸入經度">
        </div>

        <div class="col-md-5">
          <label for="latitude" class="form-label">緯度</label>
          <input class="form-control" type="text" id="latitude" name="latitude" value="" required placeholder="請輸入緯度">
        </div>
      </div>

      <div class="col-10 m-2 mx-auto">
        <label>種類</label>
        <select class="form-select mb-3" name="beaconID" id="beaconID" >
          <option selected value="">請選擇</option>
          <option value="起點">起點</option>
          <option value="終點">終點</option>
          <option value="補給站">補給站</option>
        </select>
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