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
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>
<div class="container">

<div class="" id="">
  <div class="card">
    <div class="card-header" id="headingOne">
      <div class="row">
        <div class="col-8 text-left"><span class="fs-5">會員依</span></div>
        <div class="col text-right"><span class="fs-5">5場</span></div>
        <div class="col text-right"><span class="fs-5">中區</span></div>
        <div class="col text-right"><span class="fs-5 text-primary collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">查看</span></div>
      </div>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        <span class=''>姓名：</span><span>會員依</span><br>
        <span class=''>電話：</span><span>0978456123</span><br>
        <span class=''>信箱：</span><span>member1@gmail.com</span><br>
        <span class=''>地區：</span><span>北區</span><br>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <div class="row">
        <div class="col-8 text-left"><span class="fs-5">會員貳</span></div>
        <div class="col text-right"><span class="fs-5">15場</span></div>
        <div class="col text-right"><span class="fs-5">南區</span></div>
        <div class="col text-right"><span class="fs-5 text-primary collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">查看</span></div>
      </div>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
        <span class=''>姓名：</span><span>會員貳</span><br>
        <span class=''>電話：</span><span>0987654321</span><br>
        <span class=''>信箱：</span><span>member2@gmail.com</span><br>
        <span class=''>地區：</span><span>南區</span><br>  
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <div class="row">
        <div class="col-8 text-left"><span class="fs-5">會員參</span></div>
        <div class="col text-right"><span class="fs-5">4場</span></div>
        <div class="col text-right"><span class="fs-5">南區</span></div>
        <div class="col text-right"><span class="fs-5 text-primary collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">查看</span></div>
      </div>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">
        <span class=''>姓名：</span><span>會員參</span><br>
        <span class=''>電話：</span><span>0956874321</span><br>
        <span class=''>信箱：</span><span>member3@gmail.com</span><br>
        <span class=''>地區：</span><span>南區</span><br>  
      </div>
    </div>
  </div>
</div>

</div>
<?php $this->load->view('templates/new_footer');?>