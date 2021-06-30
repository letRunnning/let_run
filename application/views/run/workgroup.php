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
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>
<div class="container">
  <div class="row">
  <form action="<?php echo site_url($url); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
      <!-- <div class="row justify-content-center"> -->
        <!-- <div class="col-sm-10 col-md-8 mb-3"> -->
        <div class="col-10 m-2 mx-auto">
          <label>路跑活動</label>
          <select class="form-select mb-3" name="runActive" id="runActive" >
            <option selected value="A1">暨大春健</option>
            <option selected value="A2">台中花博馬拉松</option>
          </select>
					</div>
				<!-- </div> -->
            <div class="col-10 m-2 mx-auto">
                <label for="workgroupName" class="form-label">工作組別名稱</label>
                <input class="form-control" type="text" id="workgroupName" name="workgroupName" value="暨大春健" required placeholder="請輸入工作組別名稱">
            </div>
            <div class="row group">
              <div class="col-10 m-2 mx-auto">
              <!-- <button type="button" class="btn btn-default" aria-label="Left Align">
                <i class="fas fa-plus"></i>
              </button> --> 
                  <label for="workList" class="form-label">工作項目</label>
                  <input class="form-control" type="text" id="workList" name="workList" value="清潔流動廁所" required placeholder="請輸入工作項目">
              </div>
              <div class="col-10 m-2 mx-auto">
                  <label for="assemblyTime">集合時間</label>
                  <input type="text" id="assemblyTime" class="form-control" value="2021/06/01 09:00" required placeholder="請輸入活動日期">
              </div>
              <div class="col-10 m-2 mx-auto">
                  <label for="assemblyPlace" class="form-label">集合地點</label>
                  <input class="form-control" type="text" id="assemblyPlace" name="assemblyPlace" value="國立暨南大學" required placeholder="請輸入集合地點">
              </div> 
              <div class="col-10 m-2 mx-auto">
                  <label for="peoples" class="form-label">人數上限</label>
                  <input class="form-control" type="text" id="peoples" name="peoples" value="100" required placeholder="請輸入人數上限">
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