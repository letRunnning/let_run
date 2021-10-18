<?php $this->load->view('templates/new_header');?>
<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">個人資訊</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
    </ol>
  </nav>
</div>
<div class="container" style="width:95%">

<!-- <div class="" id=""> -->
<?php foreach ($members as $a => $value) {?>
  <div class="card">
    <div class="card-header" id="<?php echo 'heading'.$a?>">
      <div class="row">
        <div class="col-11 text-left"><span class="fs-5"><?php echo $value['name']?></span></div>
        <div class="col text-right"><span class="fs-5 text-primary collapsed" type="button" data-toggle="collapse" data-target="<?php echo '#collapse'.$a?>" aria-expanded="false" aria-controls="<?php echo 'collapse'.$a ?>">查看</span></div>
      </div>
    </div>

  <div id="<?php echo 'collapse'.$a?>" class="collapse" aria-labelledby="<?php echo 'heading'.$a?>" data-parent="#accordionExample">
    <div class="card-body">
      <span class=''>姓名：</span><span><?php echo $value['name']?></span><br>
      <span class=''>電話：</span><span><?php echo $value['phone']?></span><br>
      <span class=''>信箱：</span><span><?php echo $value['email']?></span><br>
      <span class=''>地區：</span><span>北區</span><br>
    </div>
  </div>
</div>

<?php }?>


</div>
<?php $this->load->view('templates/new_footer');?>