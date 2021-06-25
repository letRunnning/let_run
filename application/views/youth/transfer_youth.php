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
        <a href="<?php echo site_url('/youth/transfer_youth_table/'.$youths->no); ?>">青少年轉介申請清單</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>
<div class="container text-center">
  <h4 class="text-center"><?php echo $title ?></h4>
  <!-- <div class="row " style="display:inline-block"> -->
    <form action="<?php echo site_url($url);?>"method="post" accept-charset="utf-8" enctype="multipart/form-data">
      <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />
      <?php echo isset($error) ? '<p class="red-text text-darken-1 text-center">'.$error.'</p>' : '';?>
      <?php echo isset($success) ? '<p class="green-text text-accent-4 text-center">'.$success.'</p>' : '';?>
      
      <h6 class="text-center">青少年: <?php echo $youths->name; ?></h6>

      <?php if($seasonalReviews){?>
        <div class="col-md-12 col-xs-12">
          <table id="youthTable" class="table table-hover">
              <thead class="thead-dark">
                <tr>
                  <th scope="col" class="header">日期</th>
                  <th scope="col" class="header">動向</th>
                  <th scope="col" class="header">動向說明</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($seasonalReviews as $i) { ?>
                  <tr>
                    <td><?php echo date('Y-m-d', strtotime($i['date']));?></td>
                    <td><?php foreach ($trends as $value) {
              if ($i['trend'] == $value['no']) {
                  echo $value['content'];
              }
          }?></td>
                    <td>
                      <?php echo $i['trend_description'];?>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
        </div>
        
      <?php }?>
      <?php $reviewCounty = $reviews ? $reviews->county : $county;
              $reviewUpdateValue = $reviews ? $reviews->update_value : null;?>
      <!-- county -->
      <div class="row p-1" >
        <div class="col" >
          <label style="font-size:18px">目前所在縣市</label>
          <select name="county" id="county" class="form-select">
          <?php foreach ($counties as $i) {?>
            <option <?php echo ($reviewCounty == $i['no']) ? 'selected' : '' ?> value="<?php echo $i['no']; ?>"><?php echo $i['name'] ?></option>
          <?php }?>
          </select>
        </div>
      </div>

      <!-- county -->
      <div class="row p-2">
        <div class="col" >
          <label style="font-size:18px">欲轉介至縣市</label>
          <select name="updateValue" id="updateValue" class="form-select">
          <option disabled selected value>請選擇</option>
          <?php foreach ($counties as $i) {?>
            <option <?php echo ($reviewUpdateValue == $i['no']) ? 'selected' : '' ?> value="<?php echo $i['no']; ?>"><?php echo $i['name'] ?></option>
          <?php }?>
          </select>
        </div>
      </div>
    
      <!-- reason -->
      <div class="row p-3">
        <div class="input-group">
          <span class="input-group-text" for="formReason" style="font-size:18px">轉介原因</span> 
          <textarea id="formReason" name="reason" class="form-control" aria-label="With textarea"><?php echo (empty($reviews)) ? "" : $reviews->reason ?></textarea>
        </div>
      </div>

      <div class="row mx-md-n5">
        <div class="col p-2">
          <button class="btn btn-primary" type="submit" style="width:100px">建立</button>
        </div>
      </div>
    </form>
  <!-- </div> -->
</div>

<script type="text/javascript" src="<?php echo site_url();?>assets/js/ElementBinder.js"></script>
<script type="text/javascript">
  const elementRelation = new ElementBinder();
  elementRelation.selectInput('isCounseling', 'trend', '否');
  elementRelation.selectInput('isCounseling', 'trendDescription', '否');

</script>
<?php $this->load->view('templates/new_footer');?>