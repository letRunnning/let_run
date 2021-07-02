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
        <a href="<?php echo site_url('/run/route_table'); ?>">路跑路線</a>
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
          <option selected value="A1">暨大春健</option>
          <option selected value="A2">台中花博馬拉松</option>
        </select>
        </div>

        <div class="col-10 m-2 mx-auto">
            <label for="workgroupName" class="form-label">路跑組別</label>
            <input class="form-control" type="text" id="workgroupName" name="workgroupName" value="暨大春健" required placeholder="請輸入工作組別名稱">
        </div>
        <div class="row group">
          <div class="col-10 mx-auto">
            <label>經過點</label>
            <select class="form-select mb-3" name="runActive" id="runActive" >
              <option selected value="A1">經過點1</option>
              <option  value="A2">經過點2</option>
            </select>
        </div>
        </div> 
      <div class="row">
        <div class="d-grid gap-2 col-2 mx-auto">
          <button class="btn btn-primary m-3" type="submit">送出</button>
        </div>
      </div>
    </form>
  </div>
</div>
<?php $this->load->view('templates/new_footer');?>