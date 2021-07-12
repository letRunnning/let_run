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
        <a href="<?php echo site_url('/run/pass_point_table'); ?>">路跑經過點</a>
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
                <label for="runName" class="form-label">經過點名稱</label>
                <input class="form-control" type="text" id="runName" name="runName" value="暨大春健" required placeholder="請輸入經過點名稱">
            </div>
            <div class="col-10 m-2 mx-auto">
                <label for="longitude" class="form-label">經度</label>
                <input class="form-control" type="text" id="longitude" name="longitude" value="156.12" required placeholder="請輸入經度">
            </div> 
            <div class="col-10 m-2 mx-auto">
                <label for="latitude" class="form-label">緯度</label>
                <input class="form-control" type="text" id="latitude" name="latitude" value="150.12" required placeholder="請輸入緯度">
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