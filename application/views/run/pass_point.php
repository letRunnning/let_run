<?php $this->load->view('templates/new_header');?>
<!DOCTYPE html>
<html>
  <head>
    <script type="text/javascript">
      let map;
      function load() {
        console.log("load event detected!");
        const la=parseFloat(document.getElementById("latitude").value);
        const lo=parseFloat(document.getElementById("longitude").value);
        initMap(la,lo);
      }
      window.onload = load;
      function initMap(lat,long) {
        const myLatlng = { lat: 23.950559, lng: 120.927503 };
        map = new google.maps.Map(document.getElementById("map"), {
          center: { lat: 23.950559, lng: 120.927503 },
          zoom: 10,
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
      
      let infoWindow = new google.maps.InfoWindow({
        content: "點擊地圖即可取得經緯度",
        // content: "Click the map to get Lat/Lng!",
        position: myLatlng,
      });
      infoWindow.open(map);
      // Configure the click listener.
      map.addListener("click", (mapsMouseEvent) => {
        // Close the current InfoWindow.
        infoWindow.close();
        // Create a new InfoWindow.
        infoWindow = new google.maps.InfoWindow({
          position: mapsMouseEvent.latLng,
        });
        infoWindow.setContent(
          JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
        );
        infoWindow.open(map);
        $('#latitude').val(mapsMouseEvent.latLng.lat);
        $('#longitude').val(mapsMouseEvent.latLng.lng);
        infoWindow.open(map);
      });
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
<div class="container">
    <div class="row">
    <!-- <h4 class="text-dark text-center"><?php echo $title ?></h4> -->
    <div class="row mx-auto">
      <div id="map" class="col-10 mx-auto" style =" height: 400px;">
      </div>
    </div>
      <form action="<?php echo site_url($url); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
        <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />
        <div class="col-10 m-2 mx-auto">
          <label>路跑活動</label>
          
          <select class="form-select mb-3" name="runActive" id="G-runActive" >
                    <?php if(empty($point)){?>
            <option selected value="">請選擇路跑活動</option>
            <?php foreach($activities as $i) {?>
            <option  value="<?php echo $i['running_ID']; ?>" ><?php echo $i['name']?></option>
            <?php }  ?>
                    <?php  }else{ ?>
                    <option  value="<?php echo $point->running_ID?>"><?php echo $point->name?></option>
                    <?php } ?>
          </select>
        </div>
        <div class="col-10 m-2 mx-auto">
            <label for="supply_name" class="form-label">補給站名稱</label>
            <input class="form-control" type="text" id="supply_name" name="supply_name" value="<?php echo (empty($point))?"": $point->supply_name?>" required placeholder="請輸入補給站名稱">
        </div>
        <div class="col-10 m-2 mx-auto">
            <label for="supplies" class="form-label">補給物資</label>
            <input class="form-control" type="text" id="supplies" name="supplies" value="<?php echo (empty($point))?"": $point->supplies?>" required placeholder="請輸入補給物資">
        </div>
        <div class="col-10 m-2 mx-auto">
            <label for="longitude" class="form-label">經度</label>
            <input class="form-control" type="text" id="longitude" name="longitude" value="<?php echo (empty($point))?"": $point->longitude?>" required placeholder="請輸入經度">
        </div> 
        <div class="col-10 m-2 mx-auto">
            <label for="latitude" class="form-label">緯度</label>
            <input class="form-control" type="text" id="latitude" name="latitude" value="<?php echo (empty($point))?"": $point->latitude?>" required placeholder="請輸入緯度">
        </div> 
              
        <div class="row">
          <div class="d-grid gap-2 col-2 mx-auto">
            <button class="btn btn-primary m-3" type="submit">送出</button>
          </div>
        </div>
      </form>
    </div>
  </div>
    <br><br><br><br><br><br><br>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBS9mpx2jpUOiHtgpaRUu1zAUIjk_npqRg&callback=initMap&libraries=places/output?parameters"
      async
    ></script>
  </body>
</html>
<?php $this->load->view('templates/new_footer');?>