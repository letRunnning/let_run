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

<div class="container">
  <div class="col-md-12" style="text-align:center;">
    <h4 class="text-dark text-center"><?php echo $title ?></h4>
  </div>
  <?php if ($current_role == '6') {?>
    <div class="col-md-12" style="text-align:center;">
      <a class="btn btn-info" href="<?php echo site_url('youth/intake'); ?>">新增青少年初評表</a>
    </div>
  <?php }?>
  <br>

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
        <div class="col-5 m-2 mx-auto" >
          <label>狀態</label>
          <select class="form-select" name="youthSource" id="youthSource" onchange="location = this.value;">
            <option <?php echo ($youthType == 'track') ? 'selected' : '' ?> value="<?php echo site_url('youth/get_all_youth_table/' . $county . '/all/trend'); ?>">全部</option>
            <option <?php echo ($youthType == 'track') ? 'selected' : '' ?> value="<?php echo site_url('youth/get_all_youth_table/' . $county . '/track/trend'); ?>">追蹤中</option>
            <option <?php echo ($youthType == 'end') ? 'selected' : '' ?> value="<?php echo site_url('youth/get_all_youth_table/' . $county . '/end/end_trend'); ?>">已結案</option>
          </select>
        </div>
      </div>
  <?php if($youthType == 'track') :?>
  <!-- youthSource -->
  <div class="row">
    <div class="col-5 m-2 mx-auto" >
      <label for="counties" style="text-align:center;">青少年來源</label>
      <select class="form-select" name="youthSource" id="youthSource" onchange="location = this.value;">
        <option <?php echo ($youthSource == 'all') ? 'selected' : '' ?> value="<?php echo site_url('youth/get_all_youth_table/all'); ?>">全部</option>
        <option <?php echo ($youthSource == 'trend') ? 'selected' : '' ?> value="<?php echo site_url('youth/get_all_youth_table/trend'); ?>">國中動向調查名單</option>
        <option <?php echo ($youthSource == 'high') ? 'selected' : '' ?> value="<?php echo site_url('youth/get_all_youth_table/high'); ?>">高中已錄取未註冊名單</option>
        <option <?php echo ($youthSource == 'case_trend') ? 'selected' : '' ?> value="<?php echo site_url('youth/get_all_youth_table/' . $county . '/track/case_trend/trend'); ?>">歷年度開案學員名單</option>
        <!-- <option <?php echo ($youthSource == 'case') ? 'selected' : '' ?> value="<?php echo site_url('youth/get_all_youth_table/case'); ?>"><?php echo date("Y")-1911-1?>年度開案名單</option> -->
      </select>
    </div>
  </div>

  <?php else :?>
  
  <div class="row">
    <div class="col-5 m-2 mx-auto" >
      <label for="counties" style="text-align:center;">青少年來源</label>
      <select class="form-select" name="youthSource" id="youthSource" onchange="location = this.value;">
        <!-- <option <?php echo ($youthSource == 'all') ? 'selected' : '' ?> value="<?php echo site_url('youth/get_all_youth_table/'. $county .'/end/all'); ?>">全部</option> -->
        <option <?php echo ($youthSource == 'end_trend') ? 'selected' : '' ?> value="<?php echo site_url('youth/get_all_youth_table/'. $county . '/end/end_trend'); ?>">國中動向調查結案</option>
        <option <?php echo ($youthSource == 'end_high') ? 'selected' : '' ?> value="<?php echo site_url('youth/get_all_youth_table/'. $county .'/end/end_high'); ?>">高中已錄取未註冊結案名單</option>
        <option <?php echo ($youthSource == 'end_case') ? 'selected' : '' ?> value="<?php echo site_url('youth/get_all_youth_table/'. $county . '/end/end_case'); ?>">歷年度開案結案名單</option>
      </select>
    </div>
  </div>

  <?php endif;?>

  <?php if($youthSource == 'case_trend'){?>
          <div class="row">
            <div class="col-5 m-2 mx-auto" >
              <label>類別</label>
              <select class="form-select" name="caseTrendType" id="caseTrendType" onchange="location = this.value;">
                <option <?php echo ($caseTrendType == 'trend') ? 'selected' : '' ?> value="<?php echo site_url('youth/get_all_youth_table/'. $county .'/track/case_trend/trend'); ?>">追蹤中</option>
                <option <?php echo ($caseTrendType == 'end') ? 'selected' : '' ?> value="<?php echo site_url('youth/get_all_youth_table/'. $county . '/track/case_trend/end'); ?>">結案</option>
                <option <?php echo ($caseTrendType == 'keep') ? 'selected' : '' ?> value="<?php echo site_url('youth/get_all_youth_table/'. $county .'/track/case_trend/keep'); ?>">續案</option>
              </select>
            </div>
          </div>
        <?php } ?>

        <?php if($youthSource == 'trend'){?>
          <div class="row">
            <div class="col-5 m-2 mx-auto" >
              <label>學年度</label>
              <select class="form-select" name="caseTrendType" id="caseTrendType" onchange="location = this.value;">
                <option <?php echo ($caseTrendType) ? '' : 'selected' ?> value="<?php echo site_url('youth/get_all_youth_table/'. $county .'/trend/'); ?>">全部</option>
                <option <?php echo ($caseTrendType == '108') ? 'selected' : '' ?> value="<?php echo site_url('youth/get_all_youth_table/'. $county .'/track/trend/108'); ?>">108學年度</option>
                <option <?php echo ($caseTrendType == '107') ? 'selected' : '' ?> value="<?php echo site_url('youth/get_all_youth_table/'. $county .'/track/trend/107'); ?>">107學年度</option>
                <option <?php echo ($caseTrendType == '106') ? 'selected' : '' ?> value="<?php echo site_url('youth/get_all_youth_table/'. $county .'/track/trend/106'); ?>">106學年度</option>
              </select>
            </div>
          </div>
        <?php } ?>


    <?php if (($youthSource == 'all' || $youthSource == 'high' || $youthSource == 'case'  || $youthSource == '') && $current_role == '6'): ?>

    <div class="row">
      <div class="col-5 m-2 mx-auto">
        <i class="material-icons col s1" >search</i>
        <input class="form-control" id="myInput" class="col s11" type="search" onkeyup="myFunction('all_counselor')" placeholder="搜尋身分證或姓名">
      </div>
    </div>

    <?php elseif ($youthSource == 'case_trend' && $current_role == '6'): ?>

    <div class="row">
      <div class="col-5 m-2 mx-auto">
        <i class="material-icons col s1" >search</i>
        <input class="form-control" id="myInput" class="col s11" type="search" onkeyup="myFunction('case_trend_counselor')" placeholder="搜尋學年度、動向調查類別、身分證或姓名">
      </div>
    </div>

    <?php elseif ($youthSource == 'case_trend' && $current_role != '6'): ?>

    <div class="row">
      <div class="col-5 m-2 mx-auto">
        <i class="material-icons col s1" >search</i>
        <input class="form-control" id="myInput" class="col s11" type="search" onkeyup="myFunction('case_trend_counselor')" placeholder="搜尋編號或姓名">
      </div>
    </div>

    <?php elseif ($youthSource == 'trend' && $current_role == '6'): ?>

    <div class="row">
      <div class="col-5 m-2 mx-auto">
        <i class="material-icons col s1" >search</i>
        <input class="form-control" id="myInput" class="col s11" type="search" onkeyup="myFunction('trend_counselor')" placeholder="搜尋學年度、動向調查類別、身分證或姓名">
      </div>
    </div>

    <?php elseif (($youthSource == 'all' || $youthSource == '' || $youthSource == 'high' || $youthSource == 'case' || $youthSource == 'referral') && $current_role != '6'): ?>

    <div class="row">
      <div class="col-5 m-2 mx-auto">
        <i class="material-icons col s1" >search</i>
        <input class="form-control" id="myInput" class="col s11" type="search" onkeyup="myFunction('all_counselor')" placeholder="搜尋編號或姓名">
      </div>
    </div>

    <?php elseif ($youthSource == 'trend' && $current_role != '6'): ?>

      <div class="row">
        <div class="col-5 m-2 mx-auto">
          <i class="material-icons col s1" >search</i>
          <input class="form-control" id="myInput" class="col s11" type="search" onkeyup="myFunction('trend_counselor')" placeholder="搜尋編號、學年度、動向調查類別或姓名">
        </div>
      </div>

    <?php endif;?>

    <a class="btn btn-success" onclick="youth_data_confirm()">青少年資料列印(下載EXCEL檔)</a>
    <a class="btn btn-success" onclick="youth_data_confirm_ods()">青少年資料列印(下載ODS檔)</a>
    <br/><br/>

  <div class="table-responsive">
    <table id="youthTable" class="table table-hover">
      <thead class="thead-dark">
        <tr>
          <th scope="col">編號</th>  
          <?php if ($youthSource == 'trend' || $youthSource == 'end_trend') { ?>
            <th scope="col">學年度</th>
            <th scope="col" style="width:10%;">類別</th>
            <?php } ?>

          <?php if ($current_role == '6') {?>
            <th scope="col">姓名</th>
            <th scope="col">身分證</th>
            <th scope="col">要項</th>
          <?php } elseif($current_role == '3' && $countyInfo->update_youth) { ?>
            <th scope="col">姓名</th>
            <th scope="col">身分證</th>
            <th scope="col">要項</th>
          <?php } else {?>
            <th scope="col" colspan="3">姓名</th>
          <?php }?>
        </tr>
      </thead>
      <tbody>
        <?php $j = 1;
          foreach ($youths as $i) { ?>
          <tr>
            <td><?php echo $j ?> </td>
      
            <?php $j++;
              if ($youthSource == 'trend') { ?>
                <td><?php echo $i['source_school_year']; ?></td>
                <td><?php foreach ($surveyTypes as $value) {
                            if ($value['no'] == $i['survey_type']) {
                              echo $value['content'];
                            }
                          } ?></td>
              <?php } ?>

            <?php if ($current_role == '3' && $countyInfo->update_youth) {?>
              <td><?php echo $i['name']; ?></td>
              <td><?php echo $i['identifications']; ?></td>
              <td>
                <a class="btn btn-warning" href="<?php echo site_url('youth/personal_data/allYouth/' . $i['no']); ?>">基本資料</a>
                <a class="btn btn-primary" href="<?php echo site_url('youth/get_seasonal_review_table_by_youth/' . $i['no']); ?>">季追蹤清單</a>
              </td>
            
            <?php }  elseif($current_role != '6') { ?>
              <td colspan="3"><?php echo $i['youthName']; ?></td>
      
              <?php }else { ?>
              <td><?php echo $i['name']; ?></td>
              <td><?php echo $i['identifications']; ?></td>
              <td>
                <a class="btn btn-warning" href="<?php echo site_url('youth/personal_data/allYouth/' . $i['no']); ?>">基本資料</a>
                <a class="btn btn-info" href="<?php echo site_url('youth/intake/allYouth/' . $i['no']); ?>">青少年初評表</a>
                <a class="btn btn-primary" href="<?php echo site_url('youth/get_seasonal_review_table_by_youth/' . $i['no']); ?>">季追蹤清單</a>
                <a class="btn btn-danger" href="<?php echo site_url('youth/end_youth_table/' . $i['no']); ?>">結案/復案申請單</a>
                <a class="btn btn-danger" href="<?php echo site_url('youth/transfer_youth_table/' . $i['no']); ?>">縣市轉移申請單</a>
              </td>
            <?php }?>
          </tr>
          <tr>
            <td>
            <td>上一次追蹤</td>
            <td>
              <?php foreach ($seasonalReviewArray as $sea) {
                      if ($sea['youth'] == $i['no']) {
                        echo $sea['date'];
                        break;
                      }
                    }?>
            </td>
            <?php if(!$i['is_end']) { ?>
              <td colspan= <?php echo ($youthSource == 'trend' || $youthSource == 'end_trend') ? "3" : "1"?>><?php foreach ($seasonalReviewArray as $sea) {
                if ($sea['youth'] == $i['no']) {
                  foreach ($trends as $trend) {
                    if ($sea['trend'] == $trend['no']) {
                      echo $trend['content'];
                    }
                  }
                  if ($sea['is_member'] == 1) {
                    echo('(已開案)');
                  }
                  break;
                }
                  }?></td> 
            <?php } else { ?>
              <td colspan="3">(已結案)</td>
            <?php }?>

            <td></td>
            <td></td>
          </tr>
          <?php if($youthSource == 'case_trend') {?>
            <tr>
              <td></td>
              <td><?php if($caseTrendType == 'end') echo '結案';
                        elseif($caseTrendType == 'trend') echo '追蹤中';
                        else echo '續案';?></td>
              <td><?php echo '月追蹤次數 : ' . $i['alreadyMonthReview'] . '/' . $i['originMonthReview'];?></td>
              <td><?php echo '季追蹤次數 : ' . $i['alreadySeasonalReview'] . '/' . $i['originSeasonalReview'];?></td>
            </tr>
          <?php }?>
        <?php }?>
      </tbody>
    </table>
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
        for (i = 1; i < tr.length; i+=2) {
          td_id = tr[i].getElementsByTagName("td")[2];
          td = tr[i].getElementsByTagName("td")[1];

          if (td || td_id) {
            txtValue = td.textContent || td.innerText;
            tValue = td_id.textContent || td_id.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1 || tValue.toUpperCase().indexOf(filter) > -1 ) {
              tr[i].style.display = "";
              if(i % 2 == 1){
                tr[i+1].style.display = "";
              }
            
            } else {
              tr[i].style.display = "none";
              if(i % 2 == 1){
                tr[i+1].style.display = "none";
              }
             
            }
          }

        }
      }
      else if(type == "trend_counselor"){
        for (i = 1; i < tr.length; i+=2) {
          td_year = tr[i].getElementsByTagName("td")[2];
          td_trend = tr[i].getElementsByTagName("td")[1];
          td_id = tr[i].getElementsByTagName("td")[3];
          td = tr[i].getElementsByTagName("td")[4];

          if (td || td_id || td_year || td_trend) {
            txtValue = td.textContent || td.innerText;
            tValue = td_id.textContent || td_id.innerText;
            yearValue = td_year.textContent || td_year.innerText;
            trendValue = td_trend.textContent || td_trend.innerText;

            if (txtValue.toUpperCase().indexOf(filter) > -1 || tValue.toUpperCase().indexOf(filter) > -1 || yearValue.toUpperCase().indexOf(filter) > -1 || trendValue.toUpperCase().indexOf(filter) > -1 ) {
              tr[i].style.display = "";
              if(i % 2 == 1){
                tr[i+1].style.display = "";
              }
            
            } else {
              tr[i].style.display = "none";
              if(i % 2 == 1){
                tr[i+1].style.display = "none";
              }
            
            }
          }

        }
      }
      else if(type == "case_trend_counselor"){
        for (i = 1; i < tr.length; i+=3) {
          td_id = tr[i].getElementsByTagName("td")[2];
          td = tr[i].getElementsByTagName("td")[1];

          if (td || td_id) {
            txtValue = td.textContent || td.innerText;
            tValue = td_id.textContent || td_id.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1 || tValue.toUpperCase().indexOf(filter) > -1 ) {
              tr[i].style.display = "";
              if(i % 3 == 1){
                tr[i+1].style.display = "";
                tr[i+2].style.display = "";
              }
            
            } else {
              tr[i].style.display = "none";
              if(i % 3 == 1){
                tr[i+1].style.display = "none";
                tr[i+2].style.display = "none";
              }
             
            }
          }

        }
      }
    }

    function youth_data_confirm() {
      var contentUser = '提醒您\n'
        + '一、您所下載之內容涉及個人資料部分，請遵守個人資料保護法(下稱個資法)相關規定，其蒐集、處理或利用，不得逾越特定目的之必要範圍。\n\n'
        + '二、違反個資法規定，致個人資料遭不法蒐集、處理、利用或其他侵害當事人權利者，負損害賠償責任。\n\n'
        + '三、請妥善保存與使用下載之資料。\n\n'
        + '四、您所下載的檔案無法編輯。';
      var bool = confirm(contentUser);

      if (bool) {
          window.location.href = "<?php echo site_url('export/youth_data_export/' . 'youthTrack' . '/109'); ?>";
      } else {
          
      }
    }

    function youth_data_confirm_ods() {
      var contentUser = '提醒您\n'
        + '一、您所下載之內容涉及個人資料部分，請遵守個人資料保護法(下稱個資法)相關規定，其蒐集、處理或利用，不得逾越特定目的之必要範圍。\n\n'
        + '二、違反個資法規定，致個人資料遭不法蒐集、處理、利用或其他侵害當事人權利者，負損害賠償責任。\n\n'
        + '三、請妥善保存與使用下載之資料。\n\n'
        + '四、您所下載的檔案無法編輯。';
      var bool = confirm(contentUser);

      if (bool) {
          window.location.href = "<?php echo site_url('export/youth_data_export/' . 'youthTrack' . '/109/ods'); ?>";
      } else {
          
      }
    }

</script>
<?php $this->load->view('templates/new_footer');?>