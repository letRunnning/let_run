<?php $this->load->view('templates/new_header');?>

<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <!-- <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">生涯探索課程或活動(措施B)</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/course/get_course_attendance_table_by_organization'); ?>" <?php echo $url == '/course/get_course_attendance_table_by_organization' ? 'active' : ''; ?>>課程時數清單(執行當日更新、每月自動統計報表數據)</a>
      </li> -->
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h4 class="text-dark text-center"><?php echo $title ?></h4>
      <div class="card-content">
        <form action="<?php echo site_url($url); ?>"
          method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />
          <?php echo isset($error) ? '<p class="text-danger text-center">' . $error . '</p>' : ''; ?>
          <?php echo isset($success) ? '<p class="text-success text-center">' . $success . '</p>' : ''; ?>

          <!-- interviewWay -->
          <div class="col-10 m-2 mx-auto">
            <label>訊息分類</label>
            <div class="input-group">
              <select class="form-select" name="type" required>
              <?php if (empty($messagers->type)) { ?>
                <option disabled selected value>請選擇</option>
              <?php } ?>
              <?php foreach ($types as $i) {
                      if (!empty($messagers->type)) {
                        if ($i['no'] == $messagers->type) { ?>
                          <option selected value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                  <?php } else { ?>
                          <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                  <?php }
                      } else {?>
                          <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                <?php } ?>
              <?php } ?>
              </select>
            </div>
          </div>

          <!-- content -->
          <div class="col-10 m-2 mx-auto">
            <label for="formContent" class="form-label">訊息內容</label>
            <textarea class="form-control" required type="text" id="formContent" name="content" placeholder=""><?php echo (empty($messagers)) ? "" : $messagers->content ?></textarea>
          </div>

          <div class="col-10 m-2 mx-auto">
            <h6 class="font-weight-bold">接收群組(可複選)</h6>
            <div class="row">
            <?php $receiveGroup = (empty($messagers)) ? null : $messagers->receive_group;
              $receiveGroup = explode(",", $receiveGroup);
              foreach ($receiveGroups as $i) { ?>
                <div class="col-6">
                  <p><label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="receiveGroup[]"
                    <?php if (in_array($i['no'], $receiveGroup) == 1) {
                      echo "checked";
                    } else {"";} ?>
                    value="<?php echo $i['no']; ?>">

                    <span><?php echo $i['content']; ?></span>
                  </label></p>
                </div>
              <?php } ?>
            </div>
          </div>


          <!-- isView -->
          <div class="col-10 m-2 mx-auto">
            <label>是否顯示</label>
            <div class="input-group">
              <select class="form-select" name="isView" required>
              <?php if (isset($messagers->is_view)) {
                  if ($messagers->is_view == "1") { ?>
                  <option value="1" selected>是</option>
                  <option value="0">否</option>
                <?php } else { ?>
                  <option value="1">是</option>
                  <option value="0" selected>否</option>
                <?php }
                } else { ?>
                  <option disabled selected value>請選擇</option>
                  <option value="1">是</option>
                  <option value="0">否</option>
                <?php } ?>
              </select>
            </div>
          </div>

           <!-- isEmail -->
          <div class="col-10 m-2 mx-auto">
            <label>是否寄信通知</label>
            <div class="input-group">
              <select class="form-select" name="isEmail" required>
              <?php if (isset($messagers->is_email)) {
                  if ($messagers->is_email == "1") { ?>
                  <option value="1" selected>是</option>
                  <option value="0">否</option>
                <?php } else { ?>
                  <option value="1">是</option>
                  <option value="0" selected>否</option>
                <?php }
                } else { ?>
                  <option disabled selected value>請選擇</option>
                  <option value="1">是</option>
                  <option value="0">否</option>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="row">
            <div class="d-grid gap-2 col-2 mx-auto">
              <button class="btn btn-primary my-5" type="submit">送出</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo site_url(); ?>assets/js/ElementBinder.js"></script>
<script type="text/javascript">
  const elementRelation = new ElementBinder();

</script>

<?php $this->load->view('templates/new_footer');?>
