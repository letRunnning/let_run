<?php $this->load->view('templates/new_header');
if(!empty($workData)){
  // echo $workData[1]['workList'];
  foreach($workData as $i){
    // echo $i['runActive'];
    // echo $i['workgroupName'];
    // echo $i['workList'];
    // echo $i['assemblyTime'];
    // echo $i['assemblyPlace'];
    // echo $i['peoples'];
  }
}
?>
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
        <a href="<?php echo site_url('/run/workgroup_table'); ?>">工作組別 & 項目</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>
<div class="container">
  <div class="row">
    <form action="<?php echo site_url($url); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
    <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />
    <?php echo isset($error) ? '<p class="red-text text-darken-3 text-center">' . $error . '</p>' : ''; ?>
    <?php echo isset($success) ? '<p class="green-text text-darken-3 text-center">' . $success . '</p>' : ''; ?>
      <div class="col-10 m-2 mx-auto">
        <label>路跑活動</label>
        <select class="form-select mb-3" name="runActive" id="runActive" >
        <?php if(empty($workgroupInfo->name)){?>
          <option selected value="A1">請選擇</option>
          <?php foreach($activities as $i) {?>
          <option  value="<?php echo $i['running_ID']?>"><?php echo $i['name']?></option>
          <?php } }else{ ?>
            <option  value="<?php echo $workgroupInfo->running_ID?>"><?php echo $workgroupInfo->name?></option>
            <?php } ?>
        </select>
        </div>

        <div class="col-10 m-2 mx-auto">
            <label for="workgroupName" class="form-label">工作組別名稱</label>
            <input class="form-control" type="text" id="workgroupName" name="workgroupName" value="<?php echo (empty($workgroupInfo))?"":  $workgroupInfo->workName?>" required placeholder="請輸入工作組別名稱">
        </div>
        <div class="row group">
          <div class="col-10 m-2 mx-auto">
              <label for="workList" class="form-label">工作項目</label>
              <input class="form-control" type="text" id="workList" name="workList" value="<?php echo (empty($workContents))?"":  $workContents->content?>" required placeholder="請輸入工作項目">
          </div>
          <div class="col-10 m-2 mx-auto">
              <label for="assemblyTime">集合時間</label>
              <input type="text" id="assemblyTime" name="assemblyTime" class="form-control timepicker_TW" value="<?php echo (empty($workContents))?"":  $workContents->assembletime?>" required placeholder="請輸入活動日期">
          </div>
          <div class="col-10 m-2 mx-auto">
              <label for="assemblyPlace" class="form-label">集合地點</label>
              <input class="form-control" type="text" id="assemblyPlace" name="assemblyPlace" value="<?php echo (empty($workContents))?"":  $workContents->assembleplace?>" required placeholder="請輸入集合地點">
          </div> 
          <div class="col-10 m-2 mx-auto">
              <label for="peoples" class="form-label">人數上限</label>
              <input class="form-control" type="text" id="peoples" name="maximum_number" value="<?php echo (empty($workContents))?"":  $workContents->maximum_number?>" required placeholder="請輸入人數上限">
          </div> 
          <div class="col-10 m-2 mx-auto">
            <hr>
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