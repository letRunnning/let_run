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
        <a href="<?php echo site_url('/work/get_company_table_by_organization'); ?>" <?php echo $url == '/work/get_company_table_by_organization' ? 'active' : ''; ?>>店家參考清單</a>
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
          <div class="col-8 m-2 mx-auto">
            <label for="name" class="form-label">店家名稱*</label>
            <input class="form-control" type="text" id="name" name="name" placeholder="範例-汽車維修廠" required value="<?php echo (empty($companys)) ? "" : $companys->name ?>">
          </div>

          <!-- boss_name -->
          <div class="col-8 m-2 mx-auto">
            <label for="boss_name" class="form-label">老闆名稱*</label>
            <input class="form-control" type="text" id="boss_name" name="boss_name" placeholder="OOO" required value="<?php echo (empty($companys)) ? "" : $companys->boss_name ?>">
          </div>

          <!-- phone -->
          <div class="col-8 m-2 mx-auto">
            <label for="phone" class="form-label">連絡電話</label>
            <input class="form-control" type="text" id="phone" name="phone" placeholder="OOOO-OOO-OOO" value="<?php echo (empty($companys)) ? "" : $companys->phone ?>">
          </div>

          <!-- category -->
          <div class="col-8 m-2 mx-auto">
            <label class="form-label" for="category">工作類別*</label>
            <select class="form-select" name="category" id="category">
            <?php if (empty($companys->category)) {?>
              <option disabled selected value>請選擇</option>
            <?php } ?>
            <?php foreach ($categorys as $i) {
                    if (!empty($companys->category)) {
                      if ($i['no'] == $companys->category) { ?>
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

          <!-- content -->
          <div class="col-8 m-2 mx-auto">
            <label for="work_content" class="form-label">工作內容:</label>
            <textarea class="form-control" type="text" id="work_content" name="work_content" placeholder="協助汽修廠業務" value="<?php echo (empty($companys)) ? "" : $companys->content ?>"></textarea>
          </div>

          <!-- requirement -->
          <div class="col-8 m-2 mx-auto">
            <label for="requirement" class="form-label">工作條件:</label>
            <textarea class="form-control" type="text" id="requirement" name="requirement" placeholder="可配合到晚班( 約到21點)、不會遲到早退" value="<?php echo (empty($companys)) ? "" : $companys->requirement ?>"></textarea>
          </div>

          <!-- address -->
          <div class="col-8 m-2 mx-auto">
            <label for="address" class="form-label">工作地址:</label>
            <textarea class="form-control" type="text" id="address" name="address" placeholder="OOOOOOOOOO" value="<?php echo (empty($companys)) ? "" : $companys->address ?>"></textarea>
          </div>

          <!-- is_open -->
          <div class="col-8 m-2 mx-auto">
            <label class="form-label" for="is_open">是否願意開放資料給全國夥伴</label>
            <select class="form-select" name="is_open" id="is_open">
              <?php if(isset($companys->is_open)) {
                if($companys->is_open == "1") { ?>
                  <option value="1" selected>是</option>
                  <option value="0">否</option>
                <?php } else { ?>
                  <option value="1">是</option>
                  <option value="0" selected>否</option>
                <?php }
                } else { ?>
                  <option disabled selected value>請選擇</option>
                  <option value="1">是</option>
                  <option value="0">否</option>
                <?php } ?>
            </select>
          </div>
         
          <div class="d-grid gap-2 col-2 mx-auto">
            <button class="btn btn-primary my-5" type="submit">送出</button>
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
