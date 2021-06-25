<?php $this->load->view('templates/new_header');?>

<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">工作體驗(措施C)</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/work/get_work_experience_table_by_organization'); ?>" <?php echo $url == '/work/get_work_experience_table_by_organization' ? 'active' : ''; ?>>工作體驗清單</a>
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

          <!-- company -->
          <div class="col-10 m-2 mx-auto">
            <label class="form-label" for="company">店家名稱*</label>
            <div class="input-group">
              <select class="form-select" name="company" id="company">
              <?php if (empty($workExperiences->company)) { ?>
                <option disabled selected value>請選擇</option>
              <?php } ?>
              <?php foreach ($companys as $i) {
                      if (!empty($workExperiences->company)) {
                        if ($i['no'] == $workExperiences->company) { ?>
                          <option selected value="<?php echo $i['no']; ?>"><?php echo $i['name']; ?></option>
                  <?php } else {?>
                          <option value="<?php echo $i['no']; ?>"><?php echo $i['name']; ?></option>
                  <?php }
                      } else {?>
                          <option value="<?php echo $i['no']; ?>"><?php echo $i['name']; ?></option>
                <?php }?>
              <?php }?>
              </select>
              <a href="<?php echo site_url('work/company/');?>" class="btn btn-primary m-1 input-group-text">+</a>
            </div>
          </div>
          
          <!-- startTime -->
          <div class="row">
            <div class="input-field col s10 offset-m2 m8">
              <input required type="text" id="formStartTime" name="startTime" class="datetimepicker" value="<?php echo (empty($workExperiences)) ? "" : $workExperiences->start_time ?>">
              <label for="formStartTime">開始時間*</label>
            </div>
          </div>
          
          <!-- endTime -->
          <div class="row">
            <div class="input-field col s10 offset-m2 m8">
              <input required type="text" id="formEndTime" name="endTime" class="datetimepicker" value="<?php echo (empty($workExperiences)) ? "" : $workExperiences->end_time ?>">
              <label for="formEndTime">結束時間*</label>
            </div>
          </div>
         
          <div class="d-grid gap-2 col-2 mx-auto">
            <button class="btn btn-primary m-3" type="submit">送出</button>
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
