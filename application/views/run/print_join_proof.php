<?php $this->load->view('templates/new_header');
// print_R($memberInfo->member_ID);
?>

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
      <label>路跑活動</label>
        <select onchange="location = this.value;" class="form-select mb-3" name="runActive" id="G-runActive" >
        <?php if(empty($activity->name)){?>
          <option selected value="<?php echo site_url('run/print_join_proof/'); ?>">請選擇路跑活動</option>
          <?php foreach($activities as $i) {?>
            <option  <?php echo ($runID == $i['running_ID']) ? 'selected' : '' ?> value="<?php echo site_url('run/print_join_proof/'.$i['running_ID'].'/'); ?>" ><?php echo $i['name']?></option>
            <?php } ?>
            <?php }else{ ?>
              <option selected value="<?php echo site_url('run/print_join_proof/'); ?>">請選擇路跑活動</option>
              <?php foreach($activities as $i) {?>
                <option  <?php echo ($runID == $i['running_ID']) ? 'selected' : '' ?> value="<?php echo site_url('run/print_join_proof/'.$i['running_ID'].'/'); ?>" ><?php echo $i['name']?></option>
              <?php } ?>
        <?php } ?>
        </select>
    </div>
    <div class="col-md-3">
      <label>會員</label>
        <select onchange="location = this.value;" class="form-select mb-3" name="runActive" id="G-runActive" >
        <?php if(empty($memberInfo->name)){?>
          <option selected value="<?php echo site_url('run/print_join_proof/'.$runID.'/'); ?>">請選擇會員</option>
          <?php foreach($members as $i) {?>
            <option  <?php echo ($member_ID == $i['member_ID']) ? 'selected' : '' ?> value="<?php echo site_url('run/print_join_proof/'.$runID.'/'.$i['member_ID']); ?>" ><?php echo $i['mName']." ".$i['member_ID']?></option>
            <?php } ?>
            <?php }else{ ?>
              <option selected value="<?php echo site_url('run/print_join_proof/'.$runID.'/'); ?>">請選擇會員</option>
              <?php foreach($members as $i) {?>
                <option  <?php echo ($runID == $i['running_ID']) ? 'selected' : '' ?> value="<?php echo site_url('run/print_join_proof/'.$runID.'/'.$i['member_ID']); ?>" ><?php echo $i['mName']." ".$i['member_ID']?></option>
              <?php } ?>
        <?php } ?>
        </select>
    </div>

    <!-- <div class="col-md-3">
      <label for="memberName" style="text-align:right;" class="col-form-label">搜尋</label>
      <input id="myInput" class="form-control" type="search" onkeyup="myFunction('all_counselor')" placeholder="搜尋參賽者姓名">
    </div> -->
  </div>
  <div class="row mt-5 justify-content-center" style="height: 100px;">
    <div class="col-md-8 " style="background-color:white;border:2px black solid;">
      <input class="form-control"value="證明">
      <span class="justify-content-center">參賽證明</span><br>
      
    </div>
  </div>
  
  <!-- <div class="row mt-5 justify-content-center"> -->
    <!-- <div class="col-md-8 pimg " style="background-color:white;border:2px black solid;background-image:url( '<?php echo site_url(); ?>/files/photo/A1.jpg' );height: 150px;"> -->
    <!-- <div class="col-md-8 pimg " style="background-color:white;border:2px black solid;' );height: 150px;"> -->
      <!-- <img id="p1" src="<?php echo site_url(); ?>/files/photo/A1.jpg" class="img-fluid" alt="Responsive image"> -->
      <!-- <input class="form-control"value="證明"> -->
    <!-- </div> -->
  <!-- </div> -->
</div>

<script type="text/javascript">

  window.onload = function() {
    <?php $running_ID = urldecode(json_encode($runID, JSON_PRETTY_PRINT)); ?>
    var running_ID = <?php $running_ID ? print_r($running_ID) : print_r('[]'); ?>;
    var running_ID="A8";
    var member_ID="M000015";
    active(running_ID,member_ID);
  }

  function active(running_ID,member_ID) {
    // fetch(`http://running.im.ncnu.edu.tw/run_api/get_print_join_proof.php?running_ID=${running_ID}&member_ID=${member_ID}`)
    var member_total = null;
    fetch(`http://running.im.ncnu.edu.tw/run_api/get_print_join_proof.php?running_ID=${running_ID}&member_ID=${member_ID}`)
    .then(function(response) {
      return response.json();
    })
    .then(function(myJson) {
      member_total = myJson;
      console.log(myJson);
      console.log(member_total.total_time);
    });


    // fetch(`http://running.im.ncnu.edu.tw/run_api/getLocation.php?running_ID=${running_ID}`)
    // .then(function(response) {
    //     return  response.json() // 解析成一個json 物件
    //     console.log(response)
    // })
    // .then(function(data) {
    //   console.log(data);
    //   render(data)
    // })
  }
</script>
<?php $this->load->view('templates/new_footer');?>