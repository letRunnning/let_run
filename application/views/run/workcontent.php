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
        <a href="<?php echo site_url('/run/workcontent_table'); ?>">工作項目</a>
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
                <?php if(empty($activity->name)){?>
                <option selected value="">請選擇</option>
                <?php foreach($activities as $i) {?>
                <option  value="<?php echo $i['running_ID']?>"><?php echo $i['name']?></option>
                <?php } }else{ ?>
                    <option  value="<?php echo $runNo?>"><?php echo $activity->name?></option>
                    <?php } ?>
                </select>
            </div>
        
            <div class="col-10 m-2 mx-auto">
                <label for="place" class="form-label fs-5">工作地點</label>
                <input class="form-control" type="text" id="place" name="place" value="<?php echo (empty($activity_work))?"":  $activity_work->place?>" required placeholder="請輸入工作地點">
            </div>
            <div class="col-10 m-2 mx-auto">
                <label for="contents" class="form-label fs-5">工作項目</label>
                <input class="form-control" type="text" id="contents" name="contents" value="<?php echo (empty($activity_work))?"":  $activity_work->content?>" required placeholder="請輸入工作項目">
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