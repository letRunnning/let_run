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

          <?php if ($reviews->form_name == 'case_assessment') :?>

          <!-- counselor -->
          <div class="col-10 m-2 mx-auto">
            <label>現任輔導員</label>
            <div class="input-group">
              <select class="form-select" name="counselor">
              <?php if (empty($caseAssessments->counselor)) { ?>
                <option disabled selected value>請選擇</option>
              <?php } ?>
              <?php foreach ($counselors as $i) {
                      if (!empty($caseAssessments->counselor)) {
                        if ($i['no'] == $caseAssessments->counselor) { ?>
                          <option selected value="<?php echo $i['no']; ?>"><?php echo $i['userName']; ?></option>
                  <?php } else { ?>
                          <option value="<?php echo $i['no']; ?>"><?php echo $i['userName']; ?></option>
                  <?php }
                      } ?>
              <?php } ?>
              </select>
            </div>
          </div>

          <div class="col-10 m-2 mx-auto">
            <label>欲接任之輔導員</label>
            <div class="input-group">
              <select class="form-select" name="counselor">
              <?php if (empty($reviews->update_value)) { ?>
                <option disabled selected value>請選擇</option>
              <?php } ?>
              <?php foreach ($counselors as $i) {
                      if (!empty($reviews->update_value)) {
                        if ($i['no'] == $reviews->update_value) { ?>
                          <option selected value="<?php echo $i['no']; ?>"><?php echo $i['userName']; ?></option>
                  <?php } else { ?>
                          <option value="<?php echo $i['no']; ?>"><?php echo $i['userName']; ?></option>
                  <?php }
                      } ?>
              <?php } ?>
              </select>
            </div>
          </div>

          <?php elseif ($reviews->form_name == 'counselor_users') :?>
          
          <div class="col-10 m-2 mx-auto">
            <label for="countyName" class="form-label">縣市</label>
            <input class="form-control" type="text" id="countyName" name="countyName" disabled
                value="<?php echo (empty($countyName)) ? "" : $countyName?>">
          </div>

          <?php if ($organizationName) :?>

          <div class="col-10 m-2 mx-auto">
            <label for="organizationName" class="form-label">縣市</label>
            <input class="form-control" type="text" id="organizationName" name="organizationName" disabled
                value="<?php echo (empty($organizationName)) ? "" : $organizationName?>">
          </div>

          <?php endif; ?>

          <div class="col-10 m-2 mx-auto">
            <label for="name" class="form-label">姓名</label>
            <input class="form-control" type="text" id="name" name="name" disabled
                value="<?php echo (empty($users)) ? "" : $users->name?>">
          </div>

          <div class="col-10 m-2 mx-auto">
            <label for="id" class="form-label">帳號</label>
            <input class="form-control" type="text" id="id" name="id" disabled
                value="<?php echo (empty($users)) ? "" : $users->id?>">
          </div>

          <?php endif; ?>

          <?php if ($reviews->form_name == 'update_usable') :?>

          <div class="col-10 m-2 mx-auto">
            <label for="name" class="form-label">姓名</label>
            <input class="form-control" type="text" id="name" name="name" disabled
                value="<?php echo (empty($userUsable)) ? "" : $userUsable->name ?>">
          </div>

          <div class="col-10 m-2 mx-auto">
            <label for="usable" class="form-label">帳號狀態</label>
            <input class="form-control" type="text" id="usable" name="usable" disabled
                value="<?php echo (empty($usable)) ? "停用" : "啟用"?>">
          </div>

          <?php endif; ?>

          <?php if ($reviews->form_name == 'end_youth' || $reviews->form_name == 'reopen_youth') :?>

          <div class="col-10 m-2 mx-auto">
            <label for="name" class="form-label">青少年姓名</label>
            <input class="form-control" type="text" id="name" name="name" readonly
                value="<?php echo (empty($youths)) ? "" : $youths->name?>">
          </div>

          <?php if ($seasonalReviews) { ?>
            <div class="card-content">
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
                      <td><?php echo date('Y-m-d', strtotime($i['date'])); ?></td>
                      <td><?php foreach ($trends as $value) {
                          if ($i['trend'] == $value['no']) {
                            echo $value['content'];
                          }
                        } ?>
                      </td>
                      <td>
                        <?php echo $i['trend_description'];?>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          
          <?php } ?>

          <?php endif; ?>

          <?php if ($reviews->form_name == 'transfer_youth') :?>

          <div class="col-10 m-2 mx-auto">
            <label for="name" class="form-label">青少年姓名</label>
            <input class="form-control" type="text" id="name" name="name" readonly
                value="<?php echo (empty($youths)) ? "" : $youths->name?>">
          </div>

          <?php if ($seasonalReviews) { ?>
            <div class="card-content">
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
                          } ?>
                        </td>
                      <td>
                        <?php echo $i['trend_description'];?>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          
          <?php } ?>

           <!-- county -->
          <div class="col-10 m-2 mx-auto">
            <label>目前所在縣市</label>
            <div class="input-group">
              <select class="form-select" name="county" id="county">
                <?php foreach ($counties as $i) { ?>
                  <option <?php echo ($preCounty == $i['no']) ? 'selected' : '' ?> value="<?php echo $i['no']; ?>"><?php echo $i['name'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

            <!-- county -->
          <div class="col-10 m-2 mx-auto">
            <label>欲轉介至縣市</label>
            <div class="input-group">
              <select class="form-select" name="updateValue" id="updateValue">
                <option disabled selected value>請選擇</option>
                <?php foreach ($counties as $i) { ?>
                  <option <?php echo ($reviews->update_value == $i['no']) ? 'selected' : '' ?> value="<?php echo $i['no']; ?>"><?php echo $i['name'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

          <?php endif; ?>

          <div class="col-10 m-2 mx-auto">
            <label for="reason" class="form-label">原因</label>
            <input class="form-control" type="text" id="reason" name="reason" readonly
                value="<?php echo (empty($reviews)) ? "" : $reviews->reason ?>">
          </div>

          <!-- status -->
          <div class="col-10 m-2 mx-auto">
            <label>狀態</label>
            <div class="input-group">
              <select class="form-select" name="status">
              <?php if (empty($reviews->status)) { ?>
                <option disabled selected value>請選擇</option>
              <?php } ?>
              <?php foreach ($statuses as $i) {
                      if (!empty($reviews->status)) {
                        if ($i['no'] == $reviews->status) { ?>
                          <option selected value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                  <?php } else { ?>
                          <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
     
          <div class="col-10 m-2 mx-auto">
            <label for="note" class="form-label">備註*</label>
            <input class="form-control" type="text" id="note" name="note" required
                value="<?php echo (empty($reviews)) ? "" : $reviews->note ?>">
          </div>

          <?php if ($reviews->status == $statusWaiting) : ?>
          <div class="row">
            <div class="d-grid gap-2 col-2 mx-auto">
              <button class="btn btn-primary my-5" type="submit">送出</button>
            </div>
          </div>
          <?php endif;?>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo site_url(); ?>assets/js/ElementBinder.js"></script>
<script type="text/javascript">
  const elementRelation = new ElementBinder();

</script>

<?php $this->load->view('templates/new_footer'); ?>
