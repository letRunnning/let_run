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
        <a href="<?php echo site_url('/run/beacon'); ?>">Beacon</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>
<div class="container">
    <div class="row">
    <!-- <h4 class="text-dark text-center"><?php echo $title ?></h4> -->
        <form action="<?php echo site_url($url); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
            <div class="col-10 m-2 mx-auto">
                <label for="runName" class="form-label fs-5">Beacon編號</label>
                <input class="form-control" type="text" id="runName" name="runName" value="暨大春健" required placeholder="請輸入經過點名稱">
            </div>
            <div class="col-10 m-2 mx-auto">
                <label for="longitude" class="form-label fs-5">Beacon型號</label>
                <input class="form-control" type="text" id="longitude" name="longitude" value="156.12" required placeholder="請輸入經度">
            </div>
            <div class="col-10 m-2 mx-auto">
                <label for="longitude" class="form-label fs-5">是否可使用</label>
                <div class="form-check">
                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked>
                <label class="form-check-label" for="gridRadios1">
                    可使用
                </label>
                </div>
                <div class="form-check">
                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
                <label class="form-check-label" for="gridRadios2">
                    不可使用
                </label>
                </div>
            </div>
            
          <div class="row">
            <div class="d-grid gap-2 col-2 mx-auto">
              <button class="btn btn-primary m-3" type="submit">送出</button>
            </div>
          </div>
        </form>
    </div>
    <br><br><br><br><br><br><br>
</div>
<?php $this->load->view('templates/new_footer');?>