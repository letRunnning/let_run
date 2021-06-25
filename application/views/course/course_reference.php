<?php $this->load->view('templates/new_header');?>

<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">生涯探索課程或活動(措施B)</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/course/get_course_reference_table_by_organization'); ?>" <?php echo $url == '/course/get_course_reference_table_by_organization' ? 'active' : ''; ?>>課程參考清單</a>
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
        <form action="<?php echo site_url($url);?>" 
          method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />
          <?php echo isset($error) ? '<p class="text-danger text-center">'.$error.'</p>' : '';?>
          <?php echo isset($success) ? '<p class="text-success text-center">'.$success.'</p>' : '';?>

          <!-- name -->
          <div class="col-10 m-2 mx-auto">
            <label for="formCourseName" class="form-label">課程名稱*</label>
            <input class="form-control" type="text" id="formCourseName" name="formCourseName" placeholder="範例-職涯探索" value="<?php echo (empty($courseReferences)) ? "" : $courseReferences->name ?>">
          </div>

          <!-- duration -->
          <div class="col-10 m-2 mx-auto">
            <label for="formDuration" class="form-label">上課時數</label>
            <input class="form-control" type="number" id="formDuration" min="0" name="duration" placeholder="1" step="0.25" value="<?php echo (empty($courseReferences)) ? "" : $courseReferences->duration ?>">
          </div>
          
          <!-- expert -->
          <div class="col-10 m-2 mx-auto">
            <label>課程講師*</label>
            <div class="input-group">
              <select class="form-select" name="expert" id="expert">
              <?php if (empty($courseReferences->expert)) { ?>
                <option disabled selected value>請選擇</option>
              <?php } ?>
              <?php foreach ($experts as $i) {
                      if (!empty($courseReferences->expert)) {
                        if ($i['no'] == $courseReferences->expert) { ?>
                          <option selected value="<?php echo $i['no'];?>"><?php echo $i['name'];?></option>
                  <?php } else { ?>
                          <option value="<?php echo $i['no'];?>"><?php echo $i['name'];?></option>
                  <?php }
                      } else {?>
                          <option value="<?php echo $i['no'];?>"><?php echo $i['name'];?></option>
                <?php } ?>
              <?php } ?>
              </select>
              <a href="<?php echo site_url('course/expert_list/');?>" class="btn btn-primary m-1">+</a>
            </div>
          </div>
          
          <!-- category -->
          <div class="col-10 m-2 mx-auto">
            <label>課程分類*</label>
            <div class="input-group">
              <select class="form-select" name="category" id="category">
              <?php if (empty($courseReferences->category)) { ?>
                <option disabled selected value>請選擇</option>
              <?php } ?>
              <?php foreach ($categorys as $i) {
                      if (!empty($courseReferences->category)) {
                        if ($i['no'] == $courseReferences->category) { ?>
                          <option selected value="<?php echo $i['no'];?>"><?php echo $i['content'];?></option>
                  <?php } else { ?>
                          <option value="<?php echo $i['no'];?>"><?php echo $i['content'];?></option>
                  <?php }
                      } else {?>
                          <option value="<?php echo $i['no'];?>"><?php echo $i['content'];?></option>
                <?php } ?>
              <?php } ?>
              </select>
            </div>
          </div>

          <!-- content -->
          <div class="col-10 m-2 mx-auto">
            <label for="formContent" class="form-label">課程內容*</label>
            <textarea class="form-control" type="text" id="formContent" name="content" placeholder="藉由戶外體驗，帶領學員探索興趣，並培養團體適應力"><?php echo (empty($courseReferences)) ? "" : $courseReferences->content ?></textarea>
          </div>
         
          <div class="row">
            <div class="d-grid gap-2 col-2 mx-auto">
              <button class="btn btn-primary m-3" type="submit">送出</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo site_url();?>assets/js/ElementBinder.js"></script>
<script type="text/javascript">
  const elementRelation = new ElementBinder();
  
</script>

<?php $this->load->view('templates/new_footer');?>
