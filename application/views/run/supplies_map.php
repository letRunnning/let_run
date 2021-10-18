<?php $this->load->view('templates/new_header');?>
<!DOCTYPE html>
<html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script type="text/javascript">
      // let map;
      function load() {
        console.log("load event detected!");
        const la=parseFloat(document.getElementById("latitude").value);
        const lo=parseFloat(document.getElementById("longitude").value);
        initMap(la,lo);
      }
      window.onload = load;
      var data = <?php echo $data?>;
      
      function initMap(lat,long) {
      var pathPoints=[];
      for(i = 0; i < data.length; i++) {
        let text = '補給物資:'+data[i].supplies;
        pathPoints.push(['<span style="font-weight:bolder">補給物資 :</span><br>'+'<span style="font-weight:bolder">'+data[i].supplies+'</span>',
        parseFloat(data[i].latitude),
        parseFloat(data[i].longitude)
        ]);
      }
        // const myLatlng = { lat: 23.950559, lng: 120.927503 };
        const myLatlng = { lat: parseFloat(data[0].latitude), lng: parseFloat(data[0].longitude) };
        console.log(data[0].latitude,data[0].longitude)
        map = new google.maps.Map(document.getElementById("map"), {
          // center: { lat: 23.950559, lng: 120.927503 },
          center: { lat: parseFloat(data[0].latitude), lng: parseFloat(data[0].longitude) },
          zoom: 15,
        });
      // }
      var marker = new google.maps.Marker({
        position: {
          lat: lat,
          lng: long
        },
        map: map
      });
      marker.addListener('click',function(){
        if(marker.getAnimation()==null){
          marker.setAnimation(google.maps.Animation.BOUNCE);
        }else{
          marker.setAnimation(null);
        }
      });

      var infowindow = new google.maps.InfoWindow();

      var marker, i;

      for (i = 0; i < pathPoints.length; i++) {  
        marker = new google.maps.Marker({
          position: new google.maps.LatLng(pathPoints[i][1], pathPoints[i][2]),
          map: map
        });


        google.maps.event.addListener(marker, 'click', (function(marker, i) {
          return function() {
            infowindow.setContent(pathPoints[i][0]);
            infowindow.open(map, marker);
          }
        })(marker, i));
      }
    }
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
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/run/pass_point_table'); ?>">路跑補給站</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>
<div class="container" style="width:95%">
<div class="row">
    <form action="<?php echo site_url($url); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
    <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />  
    <div class="col-10 m-2 mx-auto">
          <label>路跑活動</label>
          
          <select class="form-select mb-3" name="runActive" id="G-runActive" >
                    <?php if(empty($activity)){?>
            <option selected value="">請選擇路跑活動</option>
            <?php foreach($activities as $i) {?>
            <option  value="<?php echo $i['running_ID']; ?>" ><?php echo $i['name']?></option>
            <?php }  ?>
                    <?php  }else{ ?>
                    <option  value="<?php echo $activity->running_ID?>"><?php echo $activity->name?></option>
                    <?php } ?>
          </select>
        </div>
      <?php if(!empty($data)){?>
        <div id="map" class="col-10 mx-auto" style =" height: 400px;"></div>
      <?php }else{ ?>
        <div class="d-grid gap-2 col-2 mx-auto fs-5">
            <span>尚無新增補給站資料</span>
        </div>
      <?php } ?>

      <!-- <div class="col-10 m-2 mx-auto">
        <label for="groupName" class="form-label">路跑組別</label>
          <select class="form-select mb-3" name="groupName" id="groupName">
          <?php if(empty($group_name)){?>
          <option selected value="">請選擇路跑組別</option>
            <?php foreach($groups as $i){?>
              <option value="<?php echo $i['group_name']; ?>" ><?php echo $i['group_name']; ?></option>
              <?php }?>
              <?php  }else{ ?>
                  <option  value="<?php echo $group_name?>"><?php echo $group_name?></option>
                  <?php } ?>
          </select>
      </div> -->
      <!-- <div class="col-10 m-2 mx-auto">
        <label for="detail" class="form-label">路線說明</label>
        <input class="form-control" type="text" id="detail" name="detail" value="" required placeholder="請輸入路線說明">
      </div>
      <div class="col-10 m-2 mx-auto">
          <label for="longitude" class="form-label">經度</label>
          <input class="form-control" type="text" id="longitude" name="longitude" value="" required placeholder="請輸入經度">
      </div>
      <div class="col-10 m-2 mx-auto">
          <label for="latitude" class="form-label">緯度</label>
          <input class="form-control" type="text" id="latitude" name="latitude" value="" required placeholder="請輸入緯度">
      </div> -->


</div> 
      <div class="row">
        <div class="d-grid gap-2 col-2 mx-auto">
          <!-- <button class="btn btn-primary m-3" type="submit">送出</button> -->
        </div>
      </div>
    </form>
  </div>
</div>
<script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBS9mpx2jpUOiHtgpaRUu1zAUIjk_npqRg&callback=initMap&libraries=places/output?parameters"
      async
    ></script>
  </body>
</html>
<?php $this->load->view('templates/new_footer');?>