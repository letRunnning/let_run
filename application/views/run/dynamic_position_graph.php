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
    <div class="d-grid gap-2 col-2 mx-auto fs-5">
      <span>尚無資料</span>
    </div>
  <?php } ?>
</div>

<script type="text/javascript" src="<?php echo site_url(); ?>assets/js/jquery-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>assets/js/jquery-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript">
  // var url = 'http://running.im.ncnu.edu.tw/run_api/getLocation.php';

  // fetch(url, {
  //   method: 'POST', // or 'PUT'
  //   // body: JSON.stringify(data), // data can be `string` or {object}!
  //   body: encodeURI(JSON.stringify({
//       running_ID:'A1'
//     })),
//     headers: {
//       'Content-Type': 'application/json',
//       'Access-Control-Allow-Origin' : '*',
//       'Access-Control-Allow-Credentials' : true
//     }
//   }).then(function(res) {
//       if (!res.ok) {
//         res.json().then(function(err){ throw err})
//       }
//       var a = res;
//       console.log(a);
//     })
//   .catch(err => console.error('Error:', err))
// //   .then(function(myJson) {
// //       console.log(myJson);
// // //    var res = myJson;
// //    })
//    ;

  // var datas = [];

  // function an() {
  //   var result = res;
  //   return result;
  // }

  // // 產生資料
  // function genetateData() {
  //   // Array.from() 方法會從類陣列（array-like）或是可迭代（iterable）物件建立一個新的 Array 實體
  //   return Array.from(
  //     {length: 10},
  //     // (d,i) => ({value: parseInt(Math.random()*10+5)})
  //     (d, i) => ({value: an()})
  //   );
  // }
  // datas = genetateData();
  // console.log(datas);

  // // 產生長條圖物件
  // var elements = [];
  // datas.forEach((d, i) => {
  //   var bar = "<div class='bar'><div class='text'></div></div>";
  //   var element = $(bar);
  //   elements.push( element );
  //   element.css("height", d.value*20+"px");
  //   $(".graph").append(element);
  // });

  // setInterval(function() {
  //   // 定時更新長條圖
  //   datas = genetateData();
  //   elements.forEach((bar, i) => {
  //     var now_data = datas[i].value;
  //     bar.children(".text").text(now_data);
  //     bar.css(
  //       {"height": now_data * 20 + "px",
  //       "backgroundColor": "rgb("+now_data*10+", "+now_data*10+", "+now_data*10+")"}
  //       );
  //   });
  // }, 1000);

  <?php $running_ID = urldecode(json_encode($runID, JSON_PRETTY_PRINT)); ?>
  var running_ID = <?php $running_ID ? print_r($running_ID) : print_r('[]'); ?>;

  console.clear();
  window.onload = function() {
    active(running_ID);
  }

  function active(running_ID) {
    fetch(`http://running.im.ncnu.edu.tw/run_api/getLocation.php?running_ID=${running_ID}`)
    .then(function(response) {
        return  response.json() //解析成一個json 物件
        console.log(response)
    })
    .then(function(data) {
      console.log(data);
      render(data)
    })
  }

  function render(data) {
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
</script>

<?php $this->load->view('templates/new_footer'); ?>