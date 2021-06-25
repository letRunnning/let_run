<?php $this->load->view('templates/new_header');?>
<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">評估開案</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/youth/get_all_youth_table'); ?>">需關懷追蹤青少年清單</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/youth/get_seasonal_review_table_by_youth/'.$youths->no); ?>">季追蹤清單</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>

<div class="container" style="width:100%;">
	<div class="row">
		<div class="card-body col-sm-12">
      <h4 class="card-title text-center"><?php echo $title ?></h4>
    </div>
    <div class="col-md-12">
        <form action="<?php echo site_url($url);?>" 
          method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />
          <?php echo isset($error) ? '<p class="red-text text-darken-1 text-center">'.$error.'</p>' : '';?>
          <?php echo isset($success) ? '<p class="green-text text-accent-4 text-center">'.$success.'</p>' : '';?>

    <!-- <input name="yearType" type="radio" value="chinese" checked="checked" style="display:none"/> -->

          <h6 class="text-center">青少年: <?php echo $youthName; ?></h6>
          <!-- <div class="row justify-content-md-center input-group"> -->
          <div class="col-3 m-4  mx-auto">
          <!-- <label for="formDate">追蹤日期*</label> -->
            <label for="formDate">追蹤日期*</label>
            <div class="col" style="text-align:center">
              <input  id="formDate" class="form-control datepickerTW" value="<?php echo (empty($seasonalReviews)) ? "" : $seasonalReviews->date ?>">
            </div>
          </div>

    <div class="row justify-content-center">
			<div class="col-sm-10 col-md-3 mb-3" id="chineseDiv">
        <label for="formDate">民國年追蹤日期*</label>
        <input type="text" id="dateTo" class="form-control" value="<?php echo $dateTW?>">
      </div>
    </div>
    <div class="row justify-content-center">
			<div class="col-sm-10 col-md-3 mb-3">
        <label for="formDate">民國年追蹤日期*</label>
        <input type="text" name="date" id="hiddenTo" class="form-control"/>
      </div>
    </div>


          <!-- isCounseling -->
          <div class="col-10 m-2 mx-auto">
            <label for="counties" style="text-align:center;"class="col-form-label">是否進入本計畫輔導</label>
              <select name="isCounseling" class="form-select">
              <?php if(isset($seasonalReviews->is_counseling)){
                if($seasonalReviews->is_counseling == "1"){?>
                <option value="1" selected>是</option>
                <option value="0" >否</option>
              <?php }else{?>
                <option value="1" >是</option>
                <option value="0" selected>否</option>
              <?php }
              }else{
                if($isCounselingMember){?>
                <option value="1">是</option>
                
                <?php }else{ ?>
                  <option value="0">否</option>
              <?php }}?>
              </select>
          </div>
            
          <!-- trend -->
          
          <div class="col-10 m-2 mx-auto">
            <label for="counties">動向調查</label>
            <!-- <div class="col"> -->
              <select name="trend" class="form-select" > 
                <?php if(empty($seasonalReviews->trend)){?>
                  <option disabled selected value>請選擇</option>
                  <?php }foreach($trends as $i) { 
                  if(!empty($seasonalReviews->trend)){
                    if($i['no'] == $seasonalReviews->trend){ ?>
                      <option selected value="<?php echo $i['no'];?>"><?php echo $i['content'];?></option>
                    <?php }
                    else{ ?>
                      <option value="<?php echo $i['no'];?>"><?php echo $i['content'];?></option>
                    <?php }
                  }else{ ?>
                    <option value="<?php echo $i['no'];?>"><?php echo $i['content'];?></option>
                  <?php } ?>
                <?php } ?>
              </select>
            <!-- </div> -->
          <!-- </div> -->
          </div>

          <!-- trendDescription -->
          <!-- <div class="row">
            <div class="input-field col s10 offset-m2 m8">
              <textarea class="form-control" id="formTrendDescription" name="trendDescription" class="materialize-textarea" ><?php echo (empty($seasonalReviews)) ? "" : $seasonalReviews->trend_description ?></textarea>
              <label for="formTrendDescription">動向調查-說明(如選填「其他」、「其他單位協助」、「未取得聯繫」請說明原因)</label>
            </div>
          </div> -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formTrendDescription">動向調查-說明(如選填「其他」、「其他單位協助」、「未取得聯繫」請說明原因)</label>
              <textarea class="form-control" id="formTrendDescription" name="trendDescription" aria-label="With textarea"><?php echo (empty($seasonalReviews)) ? "" : $seasonalReviews->trend_description ?></textarea>
            </div>
          </div><br>

          <!-- <div class="row">
            <button class="btn" type="submit">建立</button>
          </div> -->
          <div class="row text-center">
            <div class="my-5">
              <button class="btn btn-primary" type="submit" style="width:150px">送出</button>
            </div>
          </div>
        
        </form>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo site_url();?>assets/js/ElementBinder.js"></script>
<script type="text/javascript">
  $('.datepickerTW').datepickerTW();
  // const elementRelation = new ElementBinder();
  // elementRelation.selectInput('isCounseling', 'trend', '否');
  // elementRelation.selectInput('isCounseling', 'trendDescription', '否');
  

</script>
<?php $this->load->view('templates/new_footer');?>