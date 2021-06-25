<?php if($title == '建立輔導員帳號') :?>

  <div class="col-12">
    <label for="id" class="form-label">前一組帳號</label>
    <input class="form-control" readonly value="<?php echo $latestId; ?>">
  </div>
 
<?php endif;?>

<div class="col-12">
  <label for="id" class="form-label">帳號*</label>
  <input class="form-control" type="text" id="id" name="id" required <?php echo (empty($users)) ? "" : "disabled" ?> value="<?php echo (empty($users)) ? $accountPrefix : $users['id'] ?>">
</div>

<div class="col-6">
  <label for="password" class="form-label">密碼(密碼需包含英文字母小寫與數字並長度大於8)*</label>
  <input class="form-control" type="password" id="password" name="password" readonly <?php echo (empty($users)) ? "" : "disabled" ?> value="<?php echo (empty($users)) ? "000000" : "********" ?>">
</div>

<div class="col-6">
  <label for="passwordVerify" class="form-label">再次輸入密碼(密碼需包含英文字母小寫與數字並長度大於8)*</label>
  <input class="form-control" type="password" id="passwordVerify" name="passwordVerify" readonly <?php echo (empty($users)) ? "" : "disabled" ?> value="<?php echo (empty($users)) ? "000000" : "********" ?>">
</div>

<div class="col-12">
  <label for="name" class="form-label">使用者姓名*</label>
  <input class="form-control" type="text" id="name" name="name" required value="<?php echo (empty($users)) ? "" : $users['name'] ?>">
</div>
     
<div class="col-12">
  <label class="form-label" for="gender">性別* </label>
  <select class="form-select" name="gender" id="gender">
  <?php if (empty($roleInfo->gender)) {?>
    <option disabled selected value>請選擇</option>
  <?php } ?>
  <?php foreach ($genders as $i) {
          if (!empty($roleInfo->gender)) {
            if ($i['no'] == $roleInfo->gender) {?>
              <option selected value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
      <?php } else {?>
              <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
      <?php }
          } else {?>
              <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
    <?php }?>
  <?php }?>
  </select>  
</div>
 
<div class="col-4">
  <label class="form-label" for="department">聯絡電話-單位*</label>
  <input class="form-control" type="text" id="department" name="department" required value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->department ?>">
</div>

<div class="col-4">
  <label class="form-label" for="fax">聯絡電話-傳真</label>
  <input class="form-control" type="text" id="fax" name="fax" value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->fax ?>">
</div>

<div class="col-4">
  <label class="form-label" for="phone">聯絡電話-手機</label>  
  <input class="form-control" type="text" id="phone" name="phone" value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->phone ?>">
</div>

<div class="col-12">
  <label class="form-label" for="email">電子郵件*</label>
  <input class="form-control" type="text" id="email" name="email" required value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->email ?>">
</div>

<div class="col-12">
  <label class="form-label" for="highest_education">最高學歷*</label>
  <select class="form-select" name="highest_education" id="highest_education">
    <?php if (empty($roleInfo->highest_education)) {?>
      <option disabled selected value>請選擇</option>
    <?php } ?>
    <?php foreach ($highestEducations as $i) {
            if (!empty($roleInfo->highest_education)) {
              if ($i['no'] == $roleInfo->highest_education) {?>
                <option selected value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
        <?php } else {?>
                <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
        <?php }
            } else {?>
                <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
      <?php }?>
    <?php }?>
  </select>
</div>

<p></p>

<h2 class="text-center">就學經歷</h2>

<?php if (empty($roleInfo)): ?>
  <div class="row group">
  <p></p>

    <div class="col-3">
      <label class="form-label" for="education_start_date">就學經歷-起*</label>
      <input class="form-control" type="text" id="education_start_date" name="education_start_date[]" class="datepicker" required value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->education_start_date ?>">
    </div>
 
    <div class="col-3">
      <label class="form-label" for="education_complete_date">就學經歷-迄*</label>
      <input class="form-control" type="text" id="education_complete_date" name="education_complete_date[]" class="datepicker" required value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->education_complete_date ?>">
    </div>
         
    <div class="col-3">
      <label class="form-label" for="education_school">學校名稱*</label>
      <input class="form-control" type="text" id="education_school" name="education_school[]" required value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->education_school ?>">  
    </div>

    <div class="col-3">
      <label class="form-label" for="education_department">科系*</label>
      <input class="form-control" type="text" id="education_department" name="education_department[]" required value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->education_department ?>"> 
    </div>

  </div>

<?php else:
  foreach ($schoolHistory as $value) {?>

    <div class="col-3">
      <label class="form-label" for="education_start_date">就學經歷-起*</label>
      <input class="form-control" type="text" id="education_start_date" name="education_start_date[]" class="datepicker" required value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->education_start_date ?>">
    </div>
 
    <div class="col-3">
      <label class="form-label" for="education_complete_date">就學經歷-迄*</label>
      <input class="form-control" type="text" id="education_complete_date" name="education_complete_date[]" class="datepicker" required value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->education_complete_date ?>">
    </div>
         
    <div class="col-3">
      <label class="form-label" for="education_school">學校名稱*</label>
      <input class="form-control" type="text" id="education_school" name="education_school[]" required value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->education_school ?>">  
    </div>

    <div class="col-3">
      <label class="form-label" for="education_department">科系*</label>
      <input class="form-control" type="text" id="education_department" name="education_department[]" required value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->education_department ?>"> 
    </div>
  <?php } ?>
<?php endif;?>

<p></p>

<h2 class="text-center">服務經歷</h2>

<?php if (empty($roleInfo)): ?>

  <div class="row group">
    <p></p>

    <div class="col-3">
      <label class="form-label" for="work_start_date">服務經歷-起*</label>
      <input class="form-control" type="text" id="work_start_date" name="work_start_date[]" class="datepicker" required value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->work_start_date ?>">
    </div>
          
    <div class="col-3">
      <label class="form-label" for="work_complete_date">服務經歷-迄*</label>
      <input class="form-control" type="text" id="work_complete_date" name="work_complete_date[]" class="datepicker" required value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->work_complete_date ?>">
    </div>

    <div class="col-3">
      <label class="form-label" for="work_department">服務單位*</label>
      <input class="form-control" type="text" id="work_department" name="work_department[]" required value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->work_department ?>">
    </div>

    <div class="col-3">
      <label class="form-label" for="work_position">擔任職務*</label>
      <input class="form-control" type="text" id="work_position" name="work_position[]" required value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->work_position ?>">
    </div>
  </div>

<?php else:
  foreach ($workHistory as $value) {?>

    <div class="col-3">
      <label class="form-label" for="work_start_date">服務經歷-起*</label>
      <input class="form-control" type="text" id="work_start_date" name="work_start_date[]" class="datepicker" required value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->work_start_date ?>">
    </div>
         
    <div class="col-3">
      <label class="form-label" for="work_complete_date">服務經歷-迄*</label>
      <input class="form-control" type="text" id="work_complete_date" name="work_complete_date[]" class="datepicker" required value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->work_complete_date ?>">
    </div>

    <div class="col-3">
      <label class="form-label" for="work_department">服務單位*</label>
      <input class="form-control" type="text" id="work_department" name="work_department[]" required value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->work_department ?>">
    </div>

    <div class="col-3">
      <label class="form-label" for="work_position">擔任職務*</label>
      <input class="form-control" type="text" id="work_position" name="work_position[]" required value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->work_position ?>">
    </div>
	<?php } ?>

<?php endif;?>

<p></p>
     
<div class="col-6">
  <label class="form-label" for="duty_date">到職日*</label>
  <input class="form-control" type="text" id="duty_date" name="duty_date" class="datepicker" required value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->duty_date ?>">
</div>
              
<div class="col-6">
  <label for="affiliated_department" class="form-label">人員隸屬*</label>
  <select class="form-select" name="affiliated_department" id="affiliated_department">
  <?php if (empty($roleInfo->affiliated_department)) {?>
    <option disabled selected value>請選擇</option>
  <?php }
    foreach ($affiliatedDepartments as $i) {
      if (!empty($roleInfo->affiliated_department)) {
        if ($i['no'] == $roleInfo->affiliated_department) {?>
          <option selected value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
          <?php } else {?>
            <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
          <?php }
        } else {?>
            <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
  <?php }?>
<?php }?>
  </select>
</div>

</p>
<div class="row">
  <?php $qualification = (empty($roleInfo)) ? null : $roleInfo->qualification;
        $qualification = explode(",", $qualification);
        foreach ($qualifications as $i) {?>

          <div class="col-12 form-check">
            <input class="form-check-input" type="checkbox" name="qualification[]" value="<?php echo $i['no']; ?>" id="qualification" 
              <?php if (in_array($i['no'], $qualification) == 1) {
                      echo "checked";
                    } else {
                      "";
                    }?>>
            <label class="form-check-label" for="qualification">
              <?php echo $i['content']; ?>
            </label>

          </div>
        <?php }?>
</div>
            
<div class="col-4">
  <label for="line" class="form-label">line帳號*</label>
  <input class="form-control" type="text" id="line" name="line" value="<?php echo (empty($users)) ? "" : $users['line'] ?>">
</div>

</p>

<div class="d-grid gap-2 col-2 mx-auto">
  <button type="submit" class="btn btn-primary">送出</button>
</div>
