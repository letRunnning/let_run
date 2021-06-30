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
        <a href="<?php echo site_url('/run/rungroup_gift_table'); ?>">路跑組別 & 禮品</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>
<div class="container" style="width:95%">
  <div class="row">
    <form action="<?php echo site_url($url); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
      <div class="col-10 m-2 mx-auto">
        <label>路跑活動</label>
        <select class="form-select mb-3" name="runActive" id="runActive" >
          <option selected value="">請選擇</option>
          <option selected value="A1">暨大春健</option>
          <option selected value="A2">台中花博馬拉松</option>
        </select>
        </div>

        <div class="col-10 m-2 mx-auto">
            <label for="rungroupName" class="form-label">組別名稱</label>
            <input class="form-control" type="text" id="rungroupName" name="rungroupName" value="休閒組" required placeholder="請輸入組別名稱">
        </div>
        <div class="col-10 m-2 mx-auto">
              <label for="peoples" class="form-label">人數上限</label>
              <input class="form-control" type="text" id="peoples" name="peoples" value="100" required placeholder="請輸入人數上限">
        </div>
        <div class="row justify-content-center" id="chineseDiv">
            <div class="col-md-5">
                <label for="runStart_date">起跑時間(日期)*</label>
                <input class="form-control" type="text" id="dateFrom" name="runStart_date" >
            </div>
            <div class="col-md-5">
                <label for="runStart_time">起跑時間(時間)*</label>
                <input class="form-control time-picker-start" type="text" id="formStartTime" name="runStart_time" >
            </div>
            <div class="col-md-5">
                <label for="runEnd_date">結束時間(日期)*</label>
                <input class="form-control" type="text" id="dateTo" name="runEnd_date">
            </div>
            <div class="col-md-5">
                <label for="runEnd_time">結束時間(時間)*</label>
                <input class="form-control time-picker-end" type="text" id="formEndTime" name="runEnd_time">
            </div>
          </div>
        <div class="col-10 m-2 mx-auto">
            <label for="assemblyPlace" class="form-label">報到地點</label>
            <input class="form-control" type="text" id="assemblyPlace" name="assemblyPlace" value="國立暨南大學" required placeholder="請輸入報到地點">
        </div>
        <div class="row justify-content-center" id="chineseDiv">
            <div class="col-md-5">
                <label for="assumblyDate">報到時間(日期)*</label>
                <input class="form-control" type="text" id="dateRun" name="assumblyDate">
            </div>
            <div class="col-md-5">
                <label for="assumblyTime">報到時間(時間)*</label>
                <input class="form-control time-picker-start" type="text" id="assumblyTime">
            </div>
        </div>
        <div class="col-10 m-2 mx-auto">
        <label for="price" class="form-label">報名金額</label>
          <input class="form-control" type="text" id="price" name="price" value="1500" required placeholder="請輸入報名金額">
        </div>
        <div class="row group">
          <div class="col-10 m-2 mx-auto">
            <label for="giftName">禮品名稱</label>
            <input type="text" id="giftName" name="giftName" class="form-control" value="紀念T" required placeholder="請輸入禮品名稱">
          </div>
          <div class="col-10 m-2 mx-auto">
            <label for="giftQrcode">禮品 Qrcode</label>
            <input type="text" id="giftQrcode" name="giftQrcode" class="form-control" value="" required placeholder="請輸入禮品 Qrcode">
          </div>
          <div class="col-10 m-2 mx-auto">
            <label for="photoFile">上傳圖片</label>
            <input type="file" id="photoFile" name="photoFile" class="form-control" value="" required >
          </div>
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