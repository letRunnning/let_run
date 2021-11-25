<?php $this->load->view('templates/new_header'); ?>
<!DOCTYPE html>
<html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script type="text/javascript">
      // let map;
      function load() {
        var url = 'http://running.im.ncnu.edu.tw/run_api/getLocation.php';
        var data = {running_ID: 'A1'};

        fetch(url, {
          method: 'POST', // or 'PUT'
          body: JSON.stringify(data), // data can be string or {object}!
          headers: new Headers({
            'Content-Type': 'application/json'
          })
        }).then(res => res.json())
        // .catch(error => console.error('Error:', error))
        .then(response => console.log('Success:', response));
      }
      window.onload = load;
    </script>

  </head>
<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-4 text-right">
      <select onchange="location = this.value;" class="form-select mb-3" name="runActive" id="G-runActive" >
        <?php if (empty($beaconPlacement->name)) { ?>
          <option selected value="<?php echo site_url('run/dynamic_position_graph/'); ?>">請選擇路跑活動</option>
          <?php foreach ($activities as $i) { ?>
            <option <?php echo ($runID == $i['running_ID']) ? 'selected' : '' ?> value="<?php echo site_url('run/dynamic_position_graph/'.$i['running_ID']); ?>" ><?php echo $i['name']?></option>
          <?php } } else { ?>
            <option  value="<?php echo $beaconPlacement->running_ID?>"><?php echo $beaconPlacement->name?></option>
            <?php } ?>
        </select>
    </div>

    <div class="col-2 text-left">
      <a type="button" class="btn btn-info" href="<?php echo site_url('beacon/beacon_placement/' );?>">新增</a>
    </div>
  </div>
  <br>

  <?php if (!empty($beaconPlacements)) { ?>
    <div class="graph"></div>
  <?php } else { ?>
    <div class="d-grid gap-2 col-2 mx-auto fs-5">
      <span>尚無資料</span>
    </div>
  <?php } ?>
</div>

<script type="text/javascript" src="<?php echo site_url(); ?>assets/js/jquery-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript">
  var datas = [];
  //產生資料
  function genetateData(){
    return Array.from(
      {length: 10},
      (d,i)=>({value: parseInt(Math.random()*10+5)})
    );
  }
  datas = genetateData();
  console.log(datas);

  //產生長條圖物件
  var elements = [];
  datas.forEach((d,i)=>{
    var bar = "<div class='bar'><div class='text'></div></div>";
    var element = $(bar);
    elements.push( element );
    element.css("height",d.value*20+"px");
    $(".graph").append(element);
  });

  setInterval(function(){
    //定時更新長條圖
    datas = genetateData();
    elements.forEach((bar,i)=>{
      var now_data=datas[i].value;
      bar.children(".text").text(now_data);
      bar.css(
        {"height": now_data*20+"px",
        "backgroundColor": "rgb("+now_data*10+","+now_data*10+","+now_data*10+")"}
        );
      
    });
  },1000);
</script>

<?php $this->load->view('templates/new_footer'); ?>