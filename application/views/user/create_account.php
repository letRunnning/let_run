<?php $this->load->view('templates/new_header');?>

<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#"><?php if(strpos($title, '建立') !== false) echo '系統帳號管理'; else echo '個人帳號管理';?></a>
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
        <form action="<?php echo site_url($url . '/' . $countyType); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>"
            value="<?php echo $security->get_csrf_hash() ?>" />

          <?php echo isset($error) ? '<p class="text-danger text-center">' . $error . '</p>' : ''; ?>
          <?php echo isset($success) ? '<p class="text-success text-center">' . $success . '</p>' : ''; ?>

          <?php if ($role === 1 && strpos($kind, 'county') !== false): ?>

          <div class="col-10 m-2 mx-auto">
            <label>縣市</label>
            <div class="input-group">
              <select class="form-select" name="county" id="county" onchange="location = this.value;">
                <option disabled selected value>請選擇</option>
                <?php foreach ($counties as $i) {
                  if ($countyType == $i['no']): ?>
                    <option selected value="<?php echo site_url($url . '/' . $i['no']); ?>"><?php echo $i['name']; ?></option>
                  <?php else: ?>
                    <option  value="<?php echo site_url($url . '/' . $i['no']); ?>"><?php echo $i['name']; ?></option>
                  <?php endif; } ?>
              </select>
            </div>
          </div>

          <?php endif; ?>

          <?php if ($kind != 'counselor' && $kind != 'yda'): ?>

          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="id">前一組帳號 : <?php echo $latestId ?></label>
            </div>
          </div>

          <?php endif; ?>

          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="id" class="form-label">帳號*</label>
              <input class="form-control" type="text" id="id" name="id" <?php echo (empty($users)) ? "" : "disabled" ?> value="<?php echo (empty($users)) ? $accountPrefix : $users['id'] ?>">
            </div>
          </div>

          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="password" class="form-label">密碼(密碼需包含英文字母小寫與數字並長度大於8)*</label>
              <input class="form-control" readonly type="password" id="password" name="password" <?php echo (empty($users)) ? "" : "disabled" ?>
                value="<?php echo (empty($users)) ? "000000" : "********" ?>">
            </div>
          </div>

          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="passwordVerify" class="form-label">再次輸入密碼(密碼需包含英文字母小寫與數字並長度大於8)*</label>
              <input class="form-control" readonly type="password" id="passwordVerify" name="passwordVerify" <?php echo (empty($users)) ? "" : "disabled" ?>
                value="<?php echo (empty($users)) ? "000000" : "********" ?>">
            </div>
          </div>

          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="name" class="form-label">使用者姓名*</label>
              <input class="form-control" type="text" id="name" name="name" value="<?php echo (empty($users)) ? "" : $users['name'] ?>">
            </div>
          </div>

          <?php if ($role === 1 && ($kind == 'yda' || $kind == 'support')): ?>

          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="phone" class="form-label">專員電話*</label>
              <input class="form-control" type="text" id="phone" name="phone" value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->phone ?>">
            </div>
          </div>

          <?php endif; ?>

          <?php if (($role === 3 || $role === 2) && strpos($kind, 'organization') !== false): ?>

          <div class="col-10 m-2 mx-auto">
            <label>機構*</label>
            <div class="input-group">
              <select class="form-select" name="organization">
                <?php foreach ($organizations as $i) { ?>
                  <option value="<?php echo $i['no']; ?>"><?php echo $i['name']; ?></option>
                <?php } ?>
              </select>
              <a href="<?php echo site_url('/organization/create_organization'); ?>" class="btn btn-primary m-1">+</a>
            </div>
          </div>

          <?php endif; ?>

          <?php if ($kind === 'county_manager' || $kind === 'county_contractor' || $kind === 'organization_manager' || $kind === 'organization_contractor'): ?>

          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="office_phone" class="form-label">辦公室聯絡電話*</label>
              <input class="form-control" type="text" id="office_phone" name="office_phone" value="<?php echo (empty($users)) ? "" : $users->office_phone ?>">
            </div>
          </div>

          <?php endif; ?>

          <?php if ($kind === 'counselor'): ?>

          <?php if ($role === 2 && $kind === 'counselor') { ?>

            <div class="col-10 m-2 mx-auto">
              <label>機構*</label>
              <div class="input-group">
                <select class="form-select" name="organization">
                  <?php foreach ($organizations as $i) { ?>
                    <option value="<?php echo $i['no']; ?>"><?php echo $i['name']; ?></option>
                  <?php } ?>
                </select>
                <a href="<?php echo site_url('/organization/create_organization'); ?>"
                  class="btn btn-primary m-1">+</a>
              </div>
            </div>
          <?php } ?>

          <div class="col-10 m-2 mx-auto">
            <label>性別*</label>
            <div class="input-group">
              <select class="form-select" name="gender">
              <?php if (empty($roleInfo->gender)) { ?>
                <option disabled selected value>請選擇</option>
              <?php } ?>
              <?php foreach ($genders as $i) {
                      if (!empty($roleInfo->gender)) {
                        if ($i['no'] == $roleInfo->gender) { ?>
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

          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="department" class="form-label">聯絡電話-單位*</label>
              <input class="form-control" type="text" id="department" name="department" value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->department ?>">
            </div>
          </div>

          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="fax" class="form-label">聯絡電話-傳真</label>
              <input class="form-control" type="text" id="fax" name="fax" value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->fax ?>">
            </div>
          </div>

          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="phone" class="form-label">聯絡電話-手機</label>
              <input class="form-control" type="text" id="phone" name="phone" value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->phone ?>">
            </div>
          </div>

          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="email" class="form-label">電子郵件*</label>
              <input class="form-control" type="text" id="email" name="email" value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->email ?>">
            </div>
          </div>

          <div class="col-10 m-2 mx-auto">
            <label>最高學歷*</label>
            <div class="input-group">
              <select class="form-select" name="highest_education">
              <?php if (empty($roleInfo->highest_education)) { ?>
                <option disabled selected value>請選擇</option>
              <?php } ?>
              <?php foreach ($highestEducations as $i) {
                      if (!empty($roleInfo->highest_education)) {
                        if ($i['no'] == $roleInfo->highest_education) { ?>
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

          <h5 class="text-dark text-center">就學經歷</h5>

          <?php if (empty($roleInfo)): ?>
          <div class="row group">

            <div class="row">
              <div class="input-field col s10 offset-m2 m8-">
                <input type="text" id="education_start_date" name="education_start_date[]" class="datepicker" required
                  value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->education_start_date ?>">
                <label for="education_start_date">就學經歷-起*</label>
              </div>
            </div>

            <div class="row">
              <div class="input-field col s10 offset-m2 m8">
                <input type="text" id="education_complete_date" name="education_complete_date[]" class="datepicker" required
                  value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->education_complete_date ?>">
                <label for="education_complete_date">就學經歷-迄*</label>
              </div>
            </div>

            <div class="row">
              <div class="col-10 m-2 mx-auto">
                <label for="education_school" class="form-label">學校名稱*</label>
                <input class="form-control" type="text" id="education_school" name="education_school[]" value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->education_school ?>">
              </div>
            </div>

            <div class="row">
              <div class="col-10 m-2 mx-auto">
                <label for="education_department" class="form-label">科系*</label>
                <input class="form-control" type="text" id="education_department" name="education_department[]" value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->education_department ?>">
              </div>
            </div>

          </div>

          <?php else:
            foreach ($schoolHistory as $value) { ?>

              <div class="row">
                <div class="input-field col s10 offset-m2 m8-">
                  <input type="text" id="education_start_date" name="education_start_date[]" class="datepicker" required
                    value="<?php echo (empty($roleInfo)) ? "" : $value['educationStartDate'] ?>">
                  <label for="education_start_date">就學經歷-起*</label>
                </div>
              </div>

              <div class="row">
                <div class="input-field col s10 offset-m2 m8">
                  <input type="text" id="education_complete_date" name="education_complete_date[]" class="datepicker" required
                    value="<?php echo (empty($roleInfo)) ? "" : $value['educationCompleteDate'] ?>">
                  <label for="education_complete_date">就學經歷-迄*</label>
                </div>
              </div>

              <div class="row">
                <div class="col-10 m-2 mx-auto">
                  <label for="education_school" class="form-label">學校名稱*</label>
                  <input class="form-control" type="text" id="education_school" name="education_school[]" value="<?php echo (empty($roleInfo)) ? "" : $value['educationSchool'] ?>">
                </div>
              </div>

              <div class="row">
                <div class="col-10 m-2 mx-auto">
                  <label for="education_department" class="form-label">科系*</label>
                  <input class="form-control" type="text" id="education_department" name="education_department[]" value="<?php echo (empty($roleInfo)) ? "" : $value['educationDepartment'] ?>">
                </div>
              </div>

            <?php }
          endif; ?>

          <h5 class="text-dark text-center">服務經歷</h5>

          <?php if (empty($roleInfo)): ?>

          <div class="row group">

            <div class="row">
              <div class="input-field col s10 offset-m2 m8">
                <input type="text" id="work_start_date" name="work_start_date[]" class="datepicker" required
                  value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->work_start_date ?>">
                <label for="work_start_date">服務經歷-起*</label>
              </div>
            </div>

            <div class="row">
              <div class="input-field col s10 offset-m2 m8">
                <input type="text" id="work_complete_date" name="work_complete_date[]" class="datepicker" required
                  value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->work_complete_date ?>">
                <label for="work_complete_date">服務經歷-迄*</label>
              </div>
            </div>

            <div class="row">
              <div class="col-10 m-2 mx-auto">
                <label for="work_department" class="form-label">服務單位*</label>
                <input class="form-control" type="text" id="work_department" name="work_department[]" value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->work_department ?>">
              </div>
            </div>

            <div class="row">
              <div class="col-10 m-2 mx-auto">
                <label for="work_position" class="form-label">擔任職務*</label>
                <input class="form-control" type="text" id="work_position" name="work_position[]" value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->work_position ?>">
              </div>
            </div>

          </div>

          <?php else:
            foreach ($workHistory as $value) { ?>

              <div class="row">
                <div class="input-field col s10 offset-m2 m8">
                  <input type="text" id="work_start_date" name="work_start_date[]" class="datepicker" required
                    value="<?php echo (empty($roleInfo)) ? "" : $value['workStartDate'] ?>">
                  <label for="work_start_date">服務經歷-起*</label>
                </div>
              </div>

              <div class="row">
                <div class="input-field col s10 offset-m2 m8">
                  <input type="text" id="work_complete_date" name="work_complete_date[]" class="datepicker" required
                    value="<?php echo (empty($roleInfo)) ? "" : $value['workCompleteDate'] ?>">
                  <label for="work_complete_date">服務經歷-迄*</label>
                </div>
              </div>

              <div class="row">
                <div class="col-10 m-2 mx-auto">
                  <label for="work_department" class="form-label">服務單位*</label>
                  <input class="form-control" type="text" id="work_department" name="work_department[]" value="<?php echo (empty($roleInfo)) ? "" : $value['workDepartment'] ?>">
                </div>
              </div>

              <div class="row">
                <div class="col-10 m-2 mx-auto">
                  <label for="work_position" class="form-label">擔任職務*</label>
                  <input class="form-control" type="text" id="work_position" name="work_position[]" value="<?php echo (empty($roleInfo)) ? "" : $value['workPosition'] ?>">
                </div>
              </div>

            <?php }
          endif; ?>

          <div class="row">
              <div class="input-field col s10 offset-m2 m8">
                <input type="text" id="duty_date" name="duty_date" class="datepicker" required
                  value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->duty_date ?>">
                <label for="duty_date">到職日*</label>
              </div>
          </div>

          <div class="col-10 m-2 mx-auto">
            <label>人員隸屬*</label>
            <div class="input-group">
              <select class="form-select" name="affiliated_department">
              <?php if (empty($roleInfo->affiliated_department)) { ?>
                <option disabled selected value>請選擇</option>
              <?php } ?>
              <?php foreach ($affiliatedDepartments as $i) {
                      if (!empty($roleInfo->affiliated_department)) {
                        if ($i['no'] == $roleInfo->affiliated_department) { ?>
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

          <div class="col-10 m-5 mx-auto">
            <div class="row">
            <?php $qualification = (empty($roleInfo)) ? null : $roleInfo->qualification;
              $qualification = explode(",", $qualification);
              foreach ($qualifications as $i) { ?>
                <div class="col-6">
                  <p><label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="qualification[]"
                    <?php if (in_array($i['no'], $qualification) == 1) {
                      echo "checked";
                    } else {"";} ?>
                    value="<?php echo $i['no']; ?>">
                    <span><?php echo $i['content']; ?></span>
                  </label></p>
                </div>
              <?php } ?>
            </div>
          </div>

          <?php endif; ?>

          <?php if ($kind != 'counselor'): ?>

          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="email" class="form-label">聯繫email*</label>
              <input class="form-control" type="text" id="email" name="email" value="<?php echo (empty($users)) ? "" : $users['email'] ?>">
            </div>
          </div>

          <?php endif; ?>

          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="line" class="form-label">line帳號</label>
              <input class="form-control" type="text" id="line" name="line" value="<?php echo (empty($users)) ? "" : $users['line'] ?>">
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
<?php $this->load->view('templates/new_footer');?>