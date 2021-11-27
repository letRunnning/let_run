<?php $this->load->view('templates/new_header'); ?>
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
      <select onchange="location = this.value;" class="form-select mb-3" name="runActive">
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
    <div class="wrapper">
      <canvas id="myChart" ></canvas>
    </div>
  <?php } else { ?>
    <div class="d-grid gap-2 col-2 mx-auto fs-5" id="demo">
      <span>尚無資料</span>
    </div>
  <?php } ?>
</div>

<script type="text/javascript" src="<?php echo site_url(); ?>assets/js/jquery-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>assets/js/jquery-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript">
  <?php $running_ID = urldecode(json_encode($runID, JSON_PRETTY_PRINT)); ?>
  var running_ID = <?php $running_ID ? print_r($running_ID) : print_r('[]'); ?>;

  console.clear();
  window.onload = function() {
    active(running_ID);
  }

  function active(running_ID) {
    fetch(`http://running.im.ncnu.edu.tw/run_api/getLocation.php?running_ID=${running_ID}`)
    .then(function(response) {
        return  response.json() // 解析成一個json 物件
        console.log(response)
    })
    .then(function(data) {
      console.log(data);
      render(data)
    })
  }

  function render(data) {
    if (data == 0) {
      window.alert("無符合條件之Beacon");
      // console.log('無符合條件之Beacon');
    }
    let beacon_ID = data.number.map(num => num.beacon_ID);
    let datas = data.number.map(el => el.num);

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
      // 參數設定
      type: 'bar',
      data: {
        labels: beacon_ID, // 標題
        datasets: [{
          label: data.running_ID, // 標籤
          data: datas, // 資料
          backgroundColor: // 背景色
            'rgba(255, 99, 132, 0.2)',
          borderColor: // 外框
            'rgba(255, 99, 132, 1)',
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });
  }

  $(function() {
    // 每隔一秒
    setInterval("active()", 1000);
  })
</script>

<?php $this->load->view('templates/new_footer'); ?>