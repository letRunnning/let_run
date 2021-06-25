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

<div class="col-4">
  <label for="phone" class="form-label">電話*</label>
  <input class="form-control" type="text" id="phone" name="phone" required value="<?php echo (empty($roleInfo)) ? "" : $roleInfo->phone ?>">
</div>

<div class="col-4">
  <label for="email" class="form-label">聯繫email*</label>
  <input class="form-control" type="text" id="email" name="email" required value="<?php echo (empty($users)) ? "" : $users['email'] ?>">
</div>

<div class="col-4">
  <label for="line" class="form-label">line帳號*</label>
  <input class="form-control" type="text" id="line" name="line" value="<?php echo (empty($users)) ? "" : $users['line'] ?>">
</div>

</p>

<div class="d-grid gap-2 col-2 mx-auto">
  <button type="submit" class="btn btn-primary">送出</button>
</div>