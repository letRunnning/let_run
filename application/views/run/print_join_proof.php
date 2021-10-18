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

<div class="container">
  <div class="row justify-content-center ">
    <div class="col-md-3">
      <label for="runActive" style="text-align:right;" class="col-form-label">搜尋</label>
      <input id="myInput" class="form-control" type="search" onkeyup="myFunction('all_counselor')" placeholder="搜尋路跑活動">
    </div>

    <div class="col-md-3">
      <label for="memberName" style="text-align:right;" class="col-form-label">搜尋</label>
      <input id="myInput" class="form-control" type="search" onkeyup="myFunction('all_counselor')" placeholder="搜尋參賽者姓名">
    </div>
  </div>
  <div class="row mt-5 justify-content-center" style="height: 100px;">
    <div class="col-md-8 " style="background-color:white;border:2px black solid;">
      <input class="form-control"value="證明">
      <span class="justify-content-center">參賽證明</span><br>
      
    </div>
  </div>
</div>
<?php $this->load->view('templates/new_footer');?>