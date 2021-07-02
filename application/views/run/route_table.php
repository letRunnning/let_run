<?php $this->load->view('templates/new_header');?>
<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">路跑活動</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>
<div class="container" style="width:95%">
    <div class="row">
        <div class="d-grid gap-2 col-2 mx-auto">
        <a class="btn btn-info m-3" href="<?php echo site_url($url); ?>">新增</a>
        </div>
    <div>
    <div class="card">
        <div class="card-header" id="headingOne">
        <div class="row">
            <div class="col-6 text-left"><span class="fs-5">路線1</span></div>
            <div class="col-2 text-right"><span class="fs-5">暨大春健</span></div>
            <div class="col text-right"><span class="fs-5">休閒組</span></div>
            <div class="col text-right"><span class="fs-5 text-primary collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">查看</span></div>
            <div class="col text-right"><a class="fs-5 text-primary " type="button" href="<?php echo site_url('run/route/1' );?>">編輯</a></div>
        </div>
        </div>

        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
        <div class="card-body">
            <span class=''>大草原 -> </span><span>暨大體育館 -> </span>
            <span class=''>活動中心 -> </span><span>科院 -> </span>
            <span class=''>教院 -> </span><span>大草原</span><br>
        </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingTwo">
        <div class="row">
            <div class="col-6 text-left"><span class="fs-5">路線2</span></div>
            <div class="col-2 text-right"><span class="fs-5">暨大春健</span></div>
            <div class="col text-right"><span class="fs-5">挑戰組</span></div>
            <div class="col text-right"><span class="fs-5 text-primary collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">查看</span></div>
            <div class="col text-right"><a class="fs-5 text-primary " type="button" href="<?php echo site_url('run/route/2' );?>">編輯</a></div>
        </div>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
        <div class="card-body">
            <span class=''>活動中心 -> </span><span>暨大體育館 -> </span>
            <span class=''>大草原 -> </span><span>管院 -> </span>
            <span class=''>科院 -> </span><span>行政大樓 -> </span>
            <span class=''>人院 -> </span><span>活動中心</span><br>  
        </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingThree">
        <div class="row">
            <div class="col-6 text-left"><span class="fs-5">路線3</span></div>
            <div class="col-2 text-right"><span class="fs-5">台中花博馬拉松</span></div>
            <div class="col text-right"><span class="fs-5">菁英組</span></div>
            <div class="col text-right"><span class="fs-5 text-primary collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">查看</span></div>
            <div class="col text-right"><a class="fs-5 text-primary " type="button" href="<?php echo site_url('run/route/3' );?>">編輯</a></div>
        </div>
        </div>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
        <div class="card-body">
            <span class=''>台中市政府廣場 -> </span><span>台中花博廣場</span><br>
        </div>
    </div>
    </div>
  </div> 
  </div> 
</div>
<?php $this->load->view('templates/new_footer');?>