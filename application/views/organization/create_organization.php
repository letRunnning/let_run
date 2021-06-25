<?php $this->load->view('templates/new_header');?>

<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">計劃案管理</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>

<div class="container">
  <div class="col-md-12">
      <h4 class="card-title text-center"><?php echo $title ?></h4>
      <div class="card-content">
        <form action="<?php echo site_url($url);?>" 
          method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />
          <?php echo isset($error) ? '<p class="red-text text-darken-1 text-center">'.$error.'</p>' : '';?>
          <?php echo isset($success) ? '<p class="green-text text-accent-4 text-center">'.$success.'</p>' : '';?>
          <div class="col-10 m-2 mx-auto">
            <label for="formName">機構名稱*</label>
            <input class="form-control" type="text" id="formName" name="name" required>
          </div>
          <div class="col-10 m-2 mx-auto">
            <label for="formPhone">機構電話*</label>
            <input class="form-control" type="text" id="formPhone" name="phone" required>
          </div>
          <div class="col-10 m-2 mx-auto">
            <label for="formAddress">機構地址*</label>
            <input class="form-control" type="text" id="formAddress" name="address" required>
          </div>
          <div class="col-12 m-2 mx-auto">
            <div class="d-grid gap-2 col-2 mx-auto">
              <button class="btn btn-primary m-3" type="submit">送出</button>
            </div>
          </div>
        </form>
      <!-- </div> -->
    </div>
  </div>
</div>
<?php $this->load->view('templates/new_footer');?>