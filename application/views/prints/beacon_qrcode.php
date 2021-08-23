<?php $this->load->view('templates/new_header');?>
<!DOCTYPE html>
<html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script type="text/javascript">
    function load() {
        console.log("load event detected!");
        function print() {
           print();
        }
      }
      window.onload = load;
     
    </script>

  </head>
<body>
<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">路跑活動</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
    </ol>
  </nav>
</div>

<div class="container" style="width:95%">
  <div class="row justify-content-center">
    <div class="col-4 text-right">
      <select onchange="location = this.value;" class="form-select mb-3" name="runActive" id="G-runActive" >
        <?php if($runID == null){?>
          <option selected value="<?php echo site_url('prints/beacon_qrcode/'); ?>">請選擇路跑活動</option>
          <?php foreach($activities as $i) {?>
          <option  <?php echo ($runID == $i['running_ID']) ? 'selected' : '' ?> value="<?php echo site_url('prints/beacon_qrcode/'.$i['running_ID']); ?>" ><?php echo $i['name']?></option>
          <?php } }else{ ?>
          <?php foreach($activities as $i) {?>
            <option  <?php echo ($runID == $i['running_ID']) ? 'selected' : '' ?> value="<?php echo site_url('prints/beacon_qrcode/'.$i['running_ID']); ?>" ><?php echo $i['name']?></option>
            <?php }} ?>
        </select>
    </div>
    <div class="col-2 text-left">
            <a type="button" class="btn btn-info" onclick="print()" );?>列印</a>
    </div>
  </div>

  <br>
    <?php if(!empty($qrcodes)){?>
    <table class="table text-center border-secondary table-hover align-middle">
        <thead class="header" style="background-color:#C8C6A7">
        <tr>
            <th scope="col">名稱</th>
            <th scope="col">Qrcode</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($qrcodes as $i) { ?>
        <tr>
            <th scope="col"><?php echo $i['beacon_ID']?></th>
            
            <th scope="col"><img class="rounded" style="width:80px" src="<?php echo site_url() . '/files/qrcode/'. (string)base64_encode($i['beacon_ID']).'.png'; ?>" /></th>
        </tr>
        <!-- <th scope="col"> <img class="img-fluid" style="width:250px" -->
                <!-- src="<?php echo site_url() . '/files/qrcode/'. (string)base64_encode($i['beacon_ID']).'.png'; ?>" /></th> -->
        <?php } ?>
        </tbody>
    </table>
    <?php }else{ ?>
        <div class="d-grid gap-2 col-2 mx-auto fs-5">
            <span>尚無資料</span>
    </div>
    <?php } ?>
  
  
</div>



<?php $this->load->view('templates/new_footer');?>