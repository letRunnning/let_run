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
    <?php foreach($groups as $i => $value){ ?>
    <div class="card">
        <div class="card-header" id="<?php echo "heading".$i?>">
            <div class="row">
                <div class="col-6 text-left"><span class="fs-5"><?php echo "路線".($i+1)?></span></div>
                <div class="col-2 text-right"><span class="fs-5"><?php echo $value['name']?></span></div>
                <div class="col text-right"><span class="fs-5"><?php echo $value['group_name']?></span></div>
                <div class="col text-right"><a class="fs-5 text-primary " type="button" href="<?php echo site_url('run/route/'.$value['running_ID'].'/'.base64_encode($value['group_name']) );?>">查看/新增</a></div>
                <div class="col text-right"><a class="fs-5 text-primary " type="button" href="<?php echo site_url('run/routeEdit/'.$value['running_ID'].'/'.base64_encode($value['group_name']) );?>">編輯</a></div>
            </div>
        </div>
    </div>
    <?php }?>
    </div>
  </div> 
  </div> 
</div>
<?php $this->load->view('templates/new_footer');?>