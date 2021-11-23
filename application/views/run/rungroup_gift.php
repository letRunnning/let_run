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
<div class="container">
  <div class="row">
    <form action="<?php echo site_url($url); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
    <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />
    <?php echo isset($error) ? '<p class="red-text text-center">' . $error . '</p>' : ''; ?>
    <?php echo isset($success) ? '<p class="red-text text-center">' . $success . '</p>' : ''; ?>
      <div class="col-10 m-2 mx-auto">
        <label>路跑活動</label>
           <select onchange="location = this.value;" class="form-select mb-3" name="runActive" id="G-runActive" >
          <?php if(empty($rungroupInfo->name)){?>
            <option selected value="<?php echo site_url('run/rungroup_gift/'); ?>">請選擇路跑活動</option>
            <?php foreach($activities as $i) {?>
            <option  <?php echo ($runNo == $i['running_ID']) ? 'selected' : '' ?> value="<?php echo site_url('run/rungroup_gift/'.$i['running_ID']); ?>" ><?php echo $i['name']?></option>
            <?php } }else{ ?>
            <option  value="<?php echo $rungroupInfo->running_ID?>"><?php echo $rungroupInfo->name?></option>
            <?php } ?>
        </select>
      </div>

        <div class="col-10 m-2 mx-auto">
            <label for="rungroupName" class="form-label">組別名稱</label>
            <input class="form-control" type="text" id="rungroupName" name="rungroupName" value="<?php echo (empty($rungroupInfo))?"":  $rungroupInfo->group_name?>" required placeholder="請輸入組別名稱">
        </div>
        <div class="col-10 m-2 mx-auto">
              <label for="peoples" class="form-label">人數上限</label>
              <input class="form-control" type="text" id="peoples" name="peoples" value="<?php echo (empty($rungroupInfo))?"":  $rungroupInfo->maximum_number?>" required placeholder="請輸入人數上限">
        </div>
        <div class="col-10 m-2 mx-auto">
            <label for="kilometers" class="form-label">公里數</label>
            <input class="form-control" type="text" id="kilometers" name="kilometers" value="<?php echo (empty($rungroupInfo))?"":  $rungroupInfo->kilometers?>" required placeholder="請輸入報到地點">
        </div>
      <div class="col-10 m-2 mx-auto">
      <label for="time">報到時間</label><br />
        <div class="bootstrap-iso">
          <div class="input-group date form_datetime col-md-12" >
            <input class="form-control" id="date-daily" type="text" name="assumbly_time" value="<?php echo (empty($rungroupInfo)) ? "" : $rungroupInfo->time ?>">
            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
          </div>
        </div>
        <label for="time">起跑時間</label><br />
        <div class="bootstrap-iso">
          <div class="input-group date form_datetime col-md-12" >
            <input class="form-control" id="date-daily" type="text" name="start_time" value="<?php echo (empty($rungroupInfo)) ? "" : $rungroupInfo->start_time ?>">
            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
          </div>
        </div>
        <label for="time">結束時間</label><br />
        <div class="bootstrap-iso">
          <div class="input-group date form_datetime col-md-12" >
            <input class="form-control" id="date-daily" type="text" name="end_time"value="<?php echo (empty($rungroupInfo)) ? "" : $rungroupInfo->end_time ?>">
            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
          </div>
        </div>
      </div>
        <div class="col-10 m-2 mx-auto">
            <label for="assemblyPlace" class="form-label">報到地點</label>
            <input class="form-control" type="text" id="assemblyPlace" name="assemblyPlace" value="<?php echo (empty($rungroupInfo))?"":  $rungroupInfo->place?>" required placeholder="請輸入報到地點">
        </div>
        
        <div class="col-10 m-2 mx-auto">
        <label for="price" class="form-label">報名金額</label>
          <input class="form-control" type="text" id="price" name="price" value="<?php echo (empty($rungroupInfo))?"":  $rungroupInfo->amount?>" required placeholder="請輸入報名金額">
        </div>
        <?php if(!empty($rungroupGift)){ ?>
      <div class="col-10 m-2 mx-auto m-4">
        <table class="table tableForm" style="border: 1px #0091ea solid;border-top: 2px #0091ea solid;border-bottom: 2px #0091ea solid;background-color:">
          <thead>
            <tr style="text-align:left;">
              <th scope="col" colspan="4" class="fs-6" style="text-align:left;border-bottom: 1px #0091ea solid;">禮品名稱</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($rungroupGift as $i => $value) { ?>
              <tr class = "text-center">
                <td scope="col"><?php echo $i+1?></td>
                <td scope="col"><?php echo $value['gift_name']?></td>
                <td scope="col"><img class="img-fluid" style="width:250px"
                src="<?php echo site_url() . '/files/photo/' . $value['name']; ?>" /></td>
                <td style="text-align:center;"> 
                  <a type="button" class="btn btn-danger btn-sm px-3" href="<?php echo site_url('run/deletedata_gift/'.$value['gift_ID'].'/'.base64_encode($value['group_name']).'/'.$runNo);?>">
                    <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <?php } ?>
        <!-- <div class="row"> -->
        <?php //foreach($rungroupGift as $i) { ?>
      <!-- <div class="col-10 m-2 mx-auto">
            <label for="giftName">禮品名稱</label>
            <input type="text" id="giftName" name="giftName" class="form-control" value="<?php echo $i['gift_name']?>" required placeholder="請輸入禮品名稱">
          </div>
          <div class="col-10 m-2 mx-auto">
          <input hidden class="form-control" type="text" id="fileNo" name="fileNo" value="<?php echo $i['file_no'] ?>">
                          <img class="img-fluid" style="width:250px"
                src="<?php echo site_url() . '/files/photo/' . $i['name']; ?>" />
            </div> -->
      <?php //} ?>
        <div class="row group">
          <div class="col-10 m-2 mx-auto">
            <label for="giftName">禮品名稱</label>
            <input type="text" id="giftName" name="giftName" class="form-control" value="" required placeholder="請輸入禮品名稱">
          </div>
          <div class="col-10 m-2 mx-auto">
            <label for="file">上傳圖片</label>
            <input type="file" id="file" name="file" class="form-control" value="" required >
          </div>
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
<script>
  function myFunction() {
    var x = document.getElementById("date-daily").value;
    document.getElementById("time").value = x;
  }
</script>
<?php $this->load->view('templates/new_footer');?>