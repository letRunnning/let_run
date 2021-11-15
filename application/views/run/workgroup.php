<?php $this->load->view('templates/new_header');
if(!empty($workgroupInfo)){
  // echo $workData[1]['workList'];
  // echo $workgroupInfo->runName;
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
        <a href="<?php echo site_url('/run/workgroup_table'); ?>">工作組別</a>
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
           <select onchange="location = this.value;" class="form-select mb-3" name="runActive" id="G-runActive" >
          <?php if(empty($workgroupInfo->name)){?>
            <option selected value="<?php echo site_url('run/workgroup/'); ?>">請選擇路跑活動</option>
            <?php foreach($activities as $i) {?>
            <option  <?php echo ($runID == $i['running_ID']) ? 'selected' : '' ?> value="<?php echo site_url('run/workgroup/'.$i['running_ID']); ?>" ><?php echo $i['name']?></option>
            <?php } }else{ ?>
            <option  value="<?php echo $workgroupInfo->running_ID?>"><?php echo $workgroupInfo->name?></option>
            <?php } ?>
        </select>
        </div>

        <div class="col-10 m-2 mx-auto">
            <label for="workgroupName" class="form-label">工作組別名稱</label>
            <input class="form-control" type="text" id="workgroupName" name="workgroupName" value="<?php echo (empty($workgroupInfo))?"":  $workgroupInfo->workName?>" required placeholder="請輸入工作組別名稱">
        </div>

        <div class="col-10 m-2 mx-auto">
            <label for="leader" class="form-label">工作組別負責人</label>
            <input class="form-control" type="text" id="leader" name="leader" value="<?php echo (empty($workgroupInfo))?"":  $workgroupInfo->leader?>" required placeholder="請輸入工作組別名稱">
        </div>

        <div class="col-10 m-2 mx-auto">
            <label for="line" class="form-label">工作Line群組連結</label>
            <input class="form-control" type="text" id="line" name="line" value="<?php echo (empty($workgroupInfo))?"":  $workgroupInfo->line?>" required placeholder="請輸入工作組別名稱">
        </div>
        <div class="col-10 m-2 mx-auto">
          <label for="time">集合時間</label><br />
          <div class="bootstrap-iso">
            <div class="input-group date form_datetime col-md-12" >
              <input class="form-control" id="date-daily" type="text" name="assumbly_time" value="<?php echo (empty($workgroupInfo)) ? "" : $workgroupInfo->assembletime ?>">
              <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
              <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
            </div>
          </div>
          <label for="time">結束時間</label><br />
          <div class="bootstrap-iso">
            <div class="input-group date form_datetime col-md-12" >
              <input class="form-control" id="date-daily" type="text" name="endtime" value="<?php echo (empty($workgroupInfo)) ? "" : $workgroupInfo->endtime ?>">
              <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
              <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
            </div>
          </div>
        </div>
        <div class="col-10 m-2 mx-auto">
            <label for="assemblyPlace" class="form-label">集合地點</label>
            <input class="form-control" type="text" id="assemblyPlace" name="assemblyPlace" value="<?php echo (empty($workgroupInfo))?"":  $workgroupInfo->assembleplace?>" required placeholder="請輸入集合地點">
        </div> 
        <div class="col-10 m-2 mx-auto">
            <label for="peoples" class="form-label">人數上限</label>
            <input class="form-control" type="text" id="peoples" name="maximum_number" value="<?php echo (empty($workgroupInfo))?"":  $workgroupInfo->maximum_number?>" required placeholder="請輸入人數上限">
        </div>

        <?php if(!empty($assignments)){ ?>
      <div class="col-10 m-2 mx-auto m-4">
        <table class="table tableForm" style="border: 1px #0091ea solid;border-top: 2px #0091ea solid;border-bottom: 2px #0091ea solid;background-color:">
          <thead>
            <tr style="text-align:left;">
              <th scope="col" colspan="4" class="fs-6" style="text-align:left;border-bottom: 1px #0091ea solid;">工作項目</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($assignments as $i => $value) { ?>
              <tr class = "text-center">
                <td scope="col"><?php echo $i+1?></td>
                <td scope="col"><?php echo $value['content']?></td>
                <td scope="col"><?php echo $value['place']?></td>
          <!-- <td scope="col"><a type="button" class="btn btn-warning" href="<?php echo site_url('run/workgroup/'.$i['runID'].'/'.$i['workgroup_ID']  );?>">編輯/查看</a></td> -->
                <td style="text-align:center;"> 
                  <a type="button" class="btn btn-danger btn-sm px-3" href="<?php echo site_url('run/deletedata/'.$runID.'/'.$workgroupID.'/'.$value['work_ID']);?>">
                    <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <?php } ?>

        <div class="row group">
          <div class="col-10 m-2 mx-auto yourUlId"  id="yourUlId" >
            <label for="peoples" class="form-label">工作項目</label>
            <select class="form-select mb-3" id="G-runActive" name="workList[]" >
              <?php //if(empty($workgroupInfo->name)){?>
                <option  value="">請選擇工作項目</option>
                <?php foreach($workcontents as $i) {?>
                <option value="<?php echo $i['work_ID'] ?>" ><?php echo $i['content'] ?></option>
                <?php } ?>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- <script type="text/javascript" src="<?php echo site_url(); ?>assets/jquery/jquery-1.8.3.min.js" charset="UTF-8"></script> -->
<!-- <script type="text/javascript" src="<?php echo site_url(); ?>assets/js/jquery-1.8.3.min.js" charset="UTF-8"></script> -->
<script type="text/javascript" src="<?php echo site_url(); ?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>assets/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>assets/js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>assets/js/locales/bootstrap-datetimepicker.zh-TW.js" charset="UTF-8"></script>

<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        language: 'zh-TW',
        format: 'yyyy-mm-dd hh:ii:00',
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        startDate:new Date(),
        showMeridian: 0 // 是否顯示上下午
    });
</script>

<?php $this->load->view('templates/new_footer');?>