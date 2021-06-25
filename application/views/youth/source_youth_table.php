<?php $this->load->view('templates/new_header');?>

<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">評估開案</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>

<div class="container" style="width:100%;">
	<div class="row">
		<div class="card-body col-sm-12">
  <div class="col-md-12">
    <h4 class="text-dark text-center"><?php echo $title ?></h4>
  </div>

  <?php if($role == 1 || $role == 9) :?>
        	<!-- counties -->
			<div class="row">
        <div class="col-5 m-2 mx-auto" >
            <label>縣市</label>
            <select class="form-select" name="counties" id="counties" onchange="location = this.value;">
						<?php foreach ($counties as $i) {?>
							<option <?php echo ($county == $i['no']) ? 'selected' : '' ?> value="<?php echo site_url('/youth/get_all_source_youth_table/' . $i['no'] . '/' . $youthSource); ?>"><?php echo $i['name'] ?></option>
            <?php }?>
            </select>
          </div>
        </div>
      <?php endif;?>

  <div class="row">
    <div class="col-5 m-2 mx-auto">
    <label for="counties" style="text-align:right;"class=" col-form-label">青少年來源</label>
      <select class="form-select" name="youthSource" id="youthSource" onchange="location = this.value;">
        <option <?php echo ($youthSource == 'all') ? 'selected' : '' ?> value="<?php echo site_url('youth/get_all_source_youth_table/all'); ?>">全部</option>
        <option <?php echo ($youthSource == 'trend') ? 'selected' : '' ?> value="<?php echo site_url('youth/get_all_source_youth_table/trend'); ?>">國中動向調查名單</option>
        <option <?php echo ($youthSource == 'high') ? 'selected' : '' ?> value="<?php echo site_url('youth/get_all_source_youth_table/high'); ?>">高中已錄取未註冊名單</option>
        <option <?php echo ($youthSource == 'case') ? 'selected' : '' ?> value="<?php echo site_url('youth/get_all_source_youth_table/case'); ?>"><?php echo date("Y")-1911-1?>年度開案名單</option>
        <option <?php echo ($youthSource == 'referral') ? 'selected' : '' ?> value="<?php echo site_url('youth/get_all_source_youth_table/referral'); ?>">轉介或自行開發</option>
      </select>
    </div>
  </div>

  <?php if (($youthSource == 'all' || $youthSource == '' || $youthSource == 'high' || $youthSource == 'case' || $youthSource == 'referral') && $current_role == '6'): ?>

  <div class="row">
    <div class="col-5 m-2 mx-auto">
    <label for="counties" style="text-align:right;"class="col-form-label">search</label>
    <input id="myInput" class="form-control" type="search" onkeyup="myFunction('all_counselor')" placeholder="搜尋身分證或姓名">
    </div>
  </div>

  <?php elseif ($youthSource == 'trend' && $current_role == '6'): ?>

  <div class="row">
    <div class="col-5 m-2 mx-auto">
    <label for="counties" style="text-align:right;"class="col-form-label">search</label>
    <input id="myInput" class="form-control" type="search" onkeyup="myFunction('trend_counselor')" placeholder="搜尋學年度、動向調查類別、身分證或姓名">
    </div>
  </div>

  <?php  elseif (($youthSource == 'all' || $youthSource == '' || $youthSource == 'high' || $youthSource == 'case' || $youthSource == 'referral') && $current_role != '6'): ?>
  
  <div class="row">
    <div class="col-5 m-2 mx-auto">
    <label for="counties" style="text-align:right;"class="col-form-label">search</label>
    <input id="myInput" class="form-control" type="search" onkeyup="myFunction('all_counselor')" placeholder="搜尋編號或姓名">
    </div>
  </div>

  <?php elseif ($youthSource == 'trend' && $current_role != '6'): ?>
  
  <div class="row">
    <div class="col-5 m-2 mx-auto">
    <label for="counties" style="text-align:right;"class="col-form-label">search</label>
    <input id="myInput" class="form-control" type="search" onkeyup="myFunction('trend_counselor')" placeholder="搜尋編號學年度、動向調查類別或姓名">
    </div>
  </div>

  <?php endif;?>
  <div class="table-responsive">
    <table id="youthTable" class="table table-hover text-center">
      <thead class="thead-dark">
        <tr>
          <?php if ($current_role != '6') {?>
            <th scope="col">編號</th> <?php }?>
          <?php if ($youthSource == 'trend') {?>
            <th scope="col">學年度</th>
            <th scope="col">類別</th> <?php }?>
            <th scope="col">姓名</th>
          <?php if ($current_role == '6') {?>
            <th scope="col">身分證</th>
            <th scope="col">要項</th> <?php }?>
        </tr>
      </thead>
      <tbody>
      <?php $j = 1;foreach ($youths as $i) {?>
        <tr>
        <?php if ($current_role != '6') {?>
          <td><?php echo $j ?> </td> <?php }?>
        <?php $j++; if ($youthSource == 'trend') {?>
          <td><?php echo $i['source_school_year']; ?></td>
          <td>
            <?php
              foreach ($surveyTypes as $value) {
                if ($value['no'] == $i['survey_type']) {
                    echo $value['content'];
                }
              }?>
          </td> 
        <?php } ?>
        <?php if ($current_role != '6') {?>
          <td><?php echo $i['youthName']; ?></td> 
        <?php } ?>
        <?php if ($current_role == '6') {?>
          <td><?php echo $i['name']; ?></td>
          <td><?php echo $i['identifications']; ?></td>
          <td>
            <a class="btn btn-warning" href="<?php echo site_url('youth/personal_data/allSource/' . $i['no']); ?>">基本資料</a>
            <!-- <a class="btn btn-primary" href="<?php echo site_url('youth/intake/allSource/' . $i['no']); ?>">青少年初評表</a>
            <a class="btn btn-success" href="<?php echo site_url('youth/get_seasonal_review_table_by_youth/' . $i['no']); ?>">季追蹤清單</a> -->
          </td>
        <?php }?>
        </tr>
      <?php }?>
      </tbody>
    </table>
    </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    function myFunction(type) {
  // Declare variables
      var input, filter, table, tr, td, i, txtValue, td_id, td_year, td_trend, tValue, yearValue, trendValue;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("youthTable");
      tr = table.getElementsByTagName("tr");

      // Loop through all table rows, and hide those who don't match the search query
      if(type == "all_counselor"){
        for (i = 0; i < tr.length; i++) {
          td_id = tr[i].getElementsByTagName("td")[1];
          td = tr[i].getElementsByTagName("td")[0];

          if (td || td_id) {
            txtValue = td.textContent || td.innerText;
            tValue = td_id.textContent || td_id.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1 || tValue.toUpperCase().indexOf(filter) > -1 ) {
              tr[i].style.display = "";
            } else {
              tr[i].style.display = "none";
            }
          }

        }
      }
      else if(type == "trend_counselor"){
        for (i = 0; i < tr.length; i++) {
          td_year = tr[i].getElementsByTagName("td")[0];
          td_trend = tr[i].getElementsByTagName("td")[1];
          td_id = tr[i].getElementsByTagName("td")[2];
          td = tr[i].getElementsByTagName("td")[3];

          if (td || td_id || td_year || td_trend) {
            txtValue = td.textContent || td.innerText;
            tValue = td_id.textContent || td_id.innerText;
            yearValue = td_year.textContent || td_year.innerText;
            trendValue = td_trend.textContent || td_trend.innerText;

            if (txtValue.toUpperCase().indexOf(filter) > -1 || tValue.toUpperCase().indexOf(filter) > -1 || yearValue.toUpperCase().indexOf(filter) > -1 || trendValue.toUpperCase().indexOf(filter) > -1 ) {
              tr[i].style.display = "";
            } else {
              tr[i].style.display = "none";
            }
          }

        }
      }
    }

</script>
<?php $this->load->view('templates/new_footer');?>