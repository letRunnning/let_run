<?php $this->load->view('templates/new_header');?>
<div class="container">
  <div class="row all_center">
    <div class="col-md-12">
      <h4 class="text-dark text-center"><?php echo $title ?></h4>
      <div class="card-content">
        <form action="<?php echo site_url('user/forget_password'); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />
         
          <?php echo isset($error) ? '<p class="text-danger text-center">' . $error . '</p>' : ''; ?>
          <?php echo isset($success) ? '<p class="text-success text-center">' . $success . '</p>' : ''; ?>

          <div class="row">
            <div class="col-3 m-2 mx-auto">
              <label for="formId" class="form-label">帳號</label>
              <input class="form-control" type="text" id="formId" name="id">
            </div>
          </div>

          <div class="row">
            <div class="col-3 m-2 mx-auto">
              <img class="rounded img-fluid" src="<?php echo base_url(); ?>/files/captcha/<?php echo $captcha['filename']; ?>">
            </div>
          <div>
          <div class="row">
            <div class="col-3 m-2 mx-auto">
              <label for="captcha" class="form-label">*驗證碼</label>
              <input class="form-control" type="text" id="captcha" name="captcha">
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

<script type="text/javascript">
    function user_forget_password() {
      var contentUser = '忘記密碼\n'
        + '一、系統將會寄一封重設密碼信件至您帳號的信箱。\n\n'
        + '二、點擊信件中的連結已重設密碼。\n\n'
        + '三、登入後請再重新設定屬於自己的密碼。\n\n';
      var bool = confirm(contentUser);

      if (bool) {
          window.location.href = "<?php echo site_url('export/youth_data_export/' . 'youthTrack' . '/109'); ?>";
      } else {
          
      }
    }

</script>
<?php $this->load->view('templates/new_footer');?>
