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
        <a href="<?php echo site_url('/youth/end_youth_table/'.$youths->no); ?>">青少年結案申請清單</a>
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
          <table class="table table-hover">
            <thead class="thead-dark">
              <tr>
                <th scope="col">日期</th>
                <th scope="col">動向</th>
                <th scope="col">動向說明</th>
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

      <div class="row">
        <div class="col">
        <label style="font-size:18px">執行項目</label>
          <select name="updateValue" class="form-select">
          <?php if(isset($youths->is_end)){
            if($youths->is_end == "1"){?>
            <option value="0" selected>復案</option>
            <option value="1" disabled>結案</option>
          <?php }else{?>
            <option value="0" disabled>復案</option>
            <option value="1" selected>結案</option>
          <?php }
          }else{
            if($youths){?>
            <option value="1" selected>結案</option>
            
            <?php }else{ ?>
              
          <?php }}?>
          </select>
        </div>
      </div>

      <?php if($youths->is_end == "1") :?>
        
        <!-- reason -->
        <div class="md-3 row">
          <div class="input-group">
            <label for="formReason" style="font-size:18px">復案原因</label>
            <textarea class="form-control" id="formReason" name="reason" aria-label="With textarea"><?php echo (empty($reviews)) ? "" : $reviews->reason ?></textarea>
          </div>
        </div>

      <?php else :?>
        <?php $reason = $reviews ? $reviews->reason : null;?>
        <div class="row">
          <div class="input-field col s10 offset-m2 m8">
          <label style="font-size:18px">結案原因</label>
            <select name="reason" class="form-select" >
              <option disabled selected value>請選擇</option>
              <option value="處不可抗力狀態(如死亡、出國)" <?php if($reason == '處不可抗力狀態(如死亡、出國)') echo "selected" ?>>處不可抗力狀態(如死亡、出國)</option>
              <option value="已有明確生涯定向(如就學就業等)且經3個月後關懷確認" <?php if($reason == '已有明確生涯定向(如就學就業等)且經3個月後關懷確認') echo "selected" ?>>已有明確生涯定向(如就學就業等)且經3個月後關懷確認</option>
              <option value="經司法、衛政、社政裁定，有明確處遇(如司法處遇、安置處遇等)" <?php if($reason == '經司法、衛政、社政裁定，有明確處遇(如司法處遇、安置處遇等)') echo "selected" ?>>經司法、衛政、社政裁定，有明確處遇(如司法處遇、安置處遇等)</option>
              <option value="明確拒絕聯繫3次以上" <?php if($reason == '明確拒絕聯繫3次以上') echo "selected" ?>>明確拒絕聯繫3次以上</option>
              <option value="年滿18歲" <?php if($reason == '年滿18歲') echo "selected" ?>>年滿18歲</option>
            </select>
          </div>
        </div>

      <?php endif;?>

      <div class="md-3 row">
        <div class="input-field col s10 offset-m2 m8">
        <label for="note">備註</label>
          <input class="form-control" type="text" id="note" name="note"
            value="<?php echo (empty($reviews)) ? "" : $reviews->note ?>">
          </input>
        </div>
      </div>

      <div class="row mx-md-n5">
        <div class="col p-3">
          <button class="btn btn-primary" type="submit" style="width:100px">建立</button>
        </div>
      </div>
    </form>
</div>

<script type="text/javascript" src="<?php echo site_url();?>assets/js/ElementBinder.js"></script>
<script type="text/javascript">
  const elementRelation = new ElementBinder();
  elementRelation.selectInput('isCounseling', 'trend', '否');
  elementRelation.selectInput('isCounseling', 'trendDescription', '否');

</script>
<?php $this->load->view('templates/new_footer');?>