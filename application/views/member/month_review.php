<?php $this->load->view('templates/new_header');?>

<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">輔導會談(措施A)</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/member/get_member_table_by_counselor'); ?>" <?php echo $url == '/member/get_member_table_by_counselor' ? 'active' : ''; ?>>開案學員清單</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/member/get_month_review_table_by_member/' . $member); ?>" <?php echo $url == '/member/get_month_review_table_by_member' ? 'active' : ''; ?>>當年度結案後月追蹤清單</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h4 class="text-dark text-center"><?php echo $title ?></h4>
      <div class="card-content">
        <form action="<?php echo site_url($url);?>" 
          method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />
          <?php echo isset($error) ? '<p class="text-danger text-center">'.$error.'</p>' : '';?>
          <?php echo isset($success) ? '<p class="text-success text-center">'.$success.'</p>' : '';?>
            
          <h6 class="text-center">學員: <?php echo $members->name; ?></h6>
          <h6 class="text-center">案號: <?php echo $members->system_no; ?></h6>

          <!-- date -->
          <div class="row">
            <div class="input-field col s10 offset-m2 m8">
              <input type="text" id="formDate" name="date" required class="datetimepicker" value="<?php echo (empty($monthReviews)) ? "" : $monthReviews->date ?>">
              <label for="formDate">追蹤日期*</label>
            </div>
          </div>

          <!-- way -->
          <div class="col-10 m-2 mx-auto">
            <label>追蹤方式*</label>
            <div class="input-group">
              <select class="form-select" name="way" <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?>>
              <?php if (empty($monthReviews->way)) { ?>
                <option disabled selected value>請選擇</option>
                <?php } foreach ($ways as $i) {
                  if (!empty($monthReviews->way)) {
                    if ($i['no'] == $monthReviews->way) { ?>
                      <option selected value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                    <?php } else { ?>
                      <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                    <?php }
                  } else { ?>
                    <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>

          <!-- wayOther -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formWayOther" class="form-label">追蹤敘述</label>
              <textarea class="form-control" type="text" id="formWayOther" placeholder="結案後用LINE關心個案就學狀況" name="wayOther" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?>><?php echo (empty($monthReviews)) ? "" : $monthReviews->way_other ?></textarea>
            </div>
          </div>

          <?php if($hasDelegation != '0'): ?>
          <div class="row">
            <div class="d-grid gap-2 col-2 mx-auto">
              <button class="btn btn-primary" type="submit">建立</button>
            </div>
          </div>
          <?php endif;?>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo site_url();?>assets/js/ElementBinder.js"></script>
<script type="text/javascript">
  const elementRelation = new ElementBinder();

</script>
<script type="text/javascript" src="<?php echo site_url();?>assets/js/ModeSwitch.js"></script>

<?php $this->load->view('templates/new_footer');?>
