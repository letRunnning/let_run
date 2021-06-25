<?php $this->load->view('templates/new_header');?>

<main class="form-signin login-card">
  <form action="<?php echo site_url('user/login'); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
    <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />
    
    <?php echo isset($error) ? '<p class="text-danger text-center">' . $error . '</p>' : ''; ?>
    <?php echo isset($success) ? '<p class="text-success text-center">' . $success . '</p>' : ''; ?>

    <h1 class="h3 mb-3 fw-normal">登入</h1>
    
    <div class="input-group mb-3">
      <label for="formId" class="visually-hidden">帳號</label>
      <input type="text" name="id" id="formId" class="form-control" placeholder="帳號" required autofocus>
    </div>

    <div class="input-group mb-3">
      <label for="formPassword" class="visually-hidden">Password</label>
      <input type="password" name="password" id="formPassword" class="form-control" placeholder="密碼" required>
    </div>

    <!-- <div class="input-group mb-3">
      <img style="width:300px;" src="<?php echo base_url(); ?>/files/captcha/<?php echo $captcha['filename']; ?>">
    </div> -->

    <!-- <div class="input-group mb-3">
      <input type="text" id="captcha" name="captcha" class="form-control" placeholder="驗證碼" required>
      <label class="visually-hidden" for="captcha">驗證碼</label>
    </div> -->

    <button class="w-100 btn btn-lg btn-primary" type="submit">送出</button>
    <p class="mt-1 mb-5 blue-text"><a href="#" onclick="user_forget_password()">忘記密碼</a></p>
  </form>
</main>


<script type="text/javascript">
    function user_forget_password() {
      var contentUser = '忘記密碼\n'
        + '一、系統將會寄一封重設密碼信件至您帳號的信箱。\n\n'
        + '二、點擊信件中的連結已重設密碼。\n\n'
        + '三、登入後請再重新設定屬於自己的密碼。\n\n';
      var bool = confirm(contentUser);

      if (bool) {
          window.location.href = "<?php echo site_url('user/forget_password'); ?>";
      } else {
          
      }
    }

</script>
<?php $this->load->view('templates/new_footer');?>