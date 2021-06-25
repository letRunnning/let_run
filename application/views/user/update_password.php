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
        <form action="<?php echo site_url($url); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>"
            value="<?php echo $security->get_csrf_hash() ?>" />

          <?php echo isset($error) ? '<p class="text-danger text-center">' . $error . '</p>' : ''; ?>
          <?php echo isset($success) ? '<p class="text-success text-center">' . $success . '</p>' : ''; ?>

          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="id" class="form-label">帳號*</label>
              <input class="form-control" type="text" id="id" name="id" <?php echo (empty($users)) ? "" : "disabled" ?> value="<?php echo (empty($users)) ? "" : $users['id'] ?>">
            </div>
          </div>

          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="password" class="form-label">請輸入舊密碼*</label>
              <input class="form-control" type="password" id="password" name="password" value="<?php echo ($password == '000000') ?'000000' : '';?>">
            </div>
          </div>

          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="passwordNew" class="form-label">請輸入新密碼(密碼需包含英文字母大寫、英文字母小寫與數字並長度大於8)*</label>
              <input class="form-control" type="password" id="passwordNew" name="passwordNew">
            </div>
          </div>

          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="passwordVerify" class="form-label">請再次輸入新密碼(密碼需包含英文字母大寫、英文字母小寫與數字並長度大於8)*</label>
              <input class="form-control" type="password" id="passwordVerify" name="passwordVerify">
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
  elementRelation.selectInput('passwordNew', 'passwordVerify', '面訪');

</script>

<?php $this->load->view('templates/new_footer');?>
