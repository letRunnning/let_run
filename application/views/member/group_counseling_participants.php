<?php $this->load->view('templates/new_header');?>

<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">輔導會談(措施A)</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/member/get_group_counseling_table_by_organization'); ?>" <?php echo $url == '/member/get_group_counseling_table_by_organization' ? 'active' : ''; ?>>團體輔導紀錄清單</a>
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
            
            <!-- participants -->
            <div class="row">
              <div class="col-10 m-2 mx-auto">
                <h6 class="fw-bold">參與學員(複選)</h6>
                  <?php 
                    foreach($members as $i) { ?>
                    <div class="form-check form-check-inline">
                      <p><label>
                        <input class="form-check-input" type="checkbox" name="participants[]" 
                        <?php if(in_array($i['no'], $participantArray) == 1){
                          echo "checked";
                        } else { "";} ?>
                        value="<?php echo $i['no'];?>">
                        <span><?php echo $i['system_no'] . $i['name'];?></span>
                      </label></p>
                    </div>
                  <?php } ?>
              </div>
            </div>

            <div class="row">
              <div class="d-grid gap-2 col-2 mx-auto">
                <button class="btn btn-primary" type="submit">建立</button>
              </div>
            </div>

          </form>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('templates/new_footer');?>
