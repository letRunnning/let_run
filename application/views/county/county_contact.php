<?php $this->load->view('templates/new_header'); ?>

<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <!-- <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">縣市聯繫窗口管理</a>
      </li> -->
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/county/county_contact_table'); ?>"
          <?php echo $url == '/county/county_contact_table' ? 'active' : ''; ?>>聯繫窗口管理</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>

<div class="container">
  <div class="col-md-12">
      <h4 class="card-title text-center"><?php echo $title ?></h4>
      <div class="card-content">
        <form class="row g-3" action="<?php echo site_url($url); ?>"
          method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />
          <?php echo isset($error) ? '<p class="text-danger text-center">' . $error . '</p>' : ''; ?>
          <?php echo isset($success) ? '<p class="text-success text-center">' . $success . '</p>' : ''; ?>

          <div class="col-10 m-2 mx-auto">
              <label for="name">姓名*</label>
              <input class="form-control" type="text" id="name" name="name" required
                value="<?php echo (empty($countyContacts)) ? "" : $countyContacts->name ?>">
          </div>

          <div class="col-10 m-2 mx-auto">
            <label for="title">職稱*</label>
            <input class="form-control" type="text" id="title" name="title" required
                value="<?php echo (empty($countyContacts)) ? "" : $countyContacts->title ?>">
          </div>

          <div class="col-10 m-2 mx-auto">
            <label for="orgnizer">承辦單位*</label>
            <input  class="form-control"type="text" id="orgnizer" name="orgnizer" required
                value="<?php echo (empty($countyContacts)) ? "" : $countyContacts->orgnizer ?>">
          </div>

          <div class="col-10 m-2 mx-auto">
            <label for="phone">聯絡電話*</label>
            <input class="form-control" type="text" id="phone" name="phone" required
              value="<?php echo (empty($countyContacts)) ? "" : $countyContacts->phone ?>">
          </div>

          <div class="col-10 m-2 mx-auto">
            <label for="email">電子郵件*</label>
            <input class="form-control" type="text" id="email" name="email" required
                value="<?php echo (empty($countyContacts)) ? "" : $countyContacts->email ?>">
          </div>

          <div class="row text-center">
            <div class="my-5">
              <button class="btn btn-primary" type="submit" style="width:150px">送出</button>
            </div>
          </div>
        </form>
      </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo site_url(); ?>assets/js/ElementBinder.js"></script>
<script type="text/javascript">
  const elementRelation = new ElementBinder();

</script>

<?php $this->load->view('templates/new_footer');?>