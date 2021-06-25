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
        <a href="<?php echo site_url('/course/get_course_reference_table_by_organization'); ?>" <?php echo $url == '/course/get_course_reference_table_by_organization' ? 'active' : ''; ?>>課程參考清單(歷年資料)</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-12">
       <div class="col-10 m-2"> 
        <a class="btn btn-success" href="<?php echo site_url('/course/get_expert_table_by_organization'); ?>">←講師清單</a>
      </div>
      <h4 class="text-dark text-center"><?php echo $title ?></h4>
      <div class="card-content">
        <form action="<?php echo site_url($url);?>" 
          method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />
          <?php echo isset($error) ? '<p class="text-danger text-center">'.$error.'</p>' : '';?>
          <?php echo isset($success) ? '<p class="text-success text-center">'.$success.'</p>' : '';?>
     
          <div class="row">
            <!-- name -->
            <div class="col-5 mx-auto">
              <label for="formExpertName" class="form-label">講師姓名*</label>
              <input class="form-control" type="text" id="formExpertName" name="expertName" placeholder="範例-OOO" value="<?php echo (empty($expertLists)) ? "" : $expertLists->name ?>">
            </div>

            <!-- gender -->
            <div class="col-5 my-1">
              <label>性別</label>
              <div class="input-group">
                <select class="form-select" name="gender" id="gender">
                <?php if (empty($expertLists->gender)) { ?>
                  <option disabled selected value>請選擇</option>
                <?php } ?>
                <?php foreach ($genders as $i) {
                        if (!empty($expertLists->gender)) {
                          if ($i['no'] == $expertLists->gender) { ?>
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
          </div>

          <!-- phone -->
          <div class="col-10 m-2 mx-auto">
            <label for="formPhone" class="form-label">講師電話</label>
            <input class="form-control" type="text" id="formPhone" name="phone" placeholder="OOO-OOO-OOO" value="<?php echo (empty($expertLists)) ? "" : $expertLists->phone ?>">
          </div>

          <!-- email -->
          <div class="col-10 m-2 mx-auto">
            <label for="formEmail" class="form-label">講師信箱</label>
            <input class="form-control" type="text" id="formEmail" name="email" placeholder="OOO@OOO.com" value="<?php echo (empty($expertLists)) ? "" : $expertLists->email ?>">
          </div>

           <!-- education -->
          <div class="col-10 m-2 mx-auto">
            <label for="formEducation" class="form-label">講師學經歷:</label>
            <textarea class="form-control" type="text" id="formEducation" name="education" placeholder="OOO大學OOO所"><?php echo (empty($expertLists)) ? "" : $expertLists->education ?></textarea>
          </div>
        
          <!-- profession -->
          <div class="col-10 m-2 mx-auto">
            <label for="formProfession" class="form-label">講師專長:</label>
            <textarea class="form-control" type="text" id="formProfession" name="profession" placeholder="冒險體驗、遊戲治療"><?php echo (empty($expertLists)) ? "" : $expertLists->profession ?></textarea>
          </div>

          <!-- resideCounty -->
          <div class="col-10 m-2 mx-auto">
            <label for="formResideCounty" class="form-label">講師所在縣市</label>
            <input class="form-control" type="text" id="formResideCounty" name="resideCounty" placeholder="OO縣" value="<?php echo (empty($expertLists)) ? "" : $expertLists->reside_county ?>">
          </div>

          <!-- isOpen -->
          <div class="col-10 m-2 mx-auto">
            <label>是否願意開放資料給全國夥伴</label>
            <div class="input-group">
              <select class="form-select" name="isOpen" id="isOpen">
              <?php if (!empty($expertLists->is_open)) {
                  if ($expertLists->is_open == "1") { ?>
                  <option value="1" selected>是</option>
                  <option value="0" disabled>否</option>
                <?php } else { ?>
                  <option value="1" disabled>是</option>
                  <option value="0" selected>否</option>
                <?php }
                } else { ?>
                  <option disabled selected value>請選擇</option>
                  <option value="1">是</option>
                  <option value="0">否</option>
                <?php } ?>
              </select>
            </div>
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
