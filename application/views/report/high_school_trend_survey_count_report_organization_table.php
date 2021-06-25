<?php $this->load->view('templates/new_header');?>

<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">報表管理</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/report/counseling_member_count_report_table'); ?>" <?php echo $url == '/report/counseling_member_count_report_table' ? 'active' : ''; ?>>每月執行進度表清單</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>

<div class="container" style="width:100%;">
	<div class="row">
		<div class="card-body col-sm-12">
      <!-- <div class="row"> 
        <a class="btn col s2 offset-s0 waves-effect teal darken-2" style="margin:10px;" href="<?php echo site_url('/report/counseling_member_count_report_table/' . $yearType . '/' . $monthType); ?>">←每月執行進度表清單</a>
      </div> -->
      <h4 class="card-title text-center"><?php echo $title ?></h4>
      <h6 class="card-title text-center"><?php echo '民國'  . $yearType . '年' . $monthType . '月'; ?></h6>
      <div class="card-content">

      <form action="<?php echo site_url($url); ?>"
          method="post" accept-charset="utf-8" enctype="multipart/form-data">
        <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>"
            value="<?php echo $security->get_csrf_hash() ?>" />
        <!-- years -->
        <div class="row justify-content-center">
          <div class="col-sm-10 col-md-8">
            <label>年度</label>
            <select class="form-select form-select-lg mb-3" name="years" id="years" onchange="location = this.value;">
            
              <?php foreach ($years as $i) { ?>
                <option <?php echo ($yearType == ($i['year'])) ? 'selected' : ''?>
                  value="<?php echo site_url('/report/high_school_trend_survey_count_report_organization_table/' . $i['year'] . '/' . $monthType);?>"><?php echo $i['year'] ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        
        <!-- months -->
        <div class="row justify-content-center">
          <div class="col-sm-10 col-md-8">
            <label>月份</label>
            <select class="form-select form-select-lg mb-3" name="months" id="months" onchange="location = this.value;">
              
              <?php foreach ($months as $i) { ?>
              
                <option <?php echo ($monthType == $i) ? 'selected' : '' ?> 
                value="<?php echo site_url('/report/high_school_trend_survey_count_report_organization_table/' . $yearType . '/' . $i);?>"><?php echo $i ?></option>
              <?php } ?>

            </select>
          </div>
        </div>

        <a class="btn btn-success" href="<?php echo site_url('export/organization_month_report_export/' . 'HighSchoolTrendSurveyCountReport' . '/' . $yearType . '/' . $monthType); ?>">列印(下載EXCEL檔)</a><br/><br/>

        <br/><br/>

          <?php if ($reportProcessesCounselorStatus == $reviewStatus['review_process_pass']): ?>

        <h5 class="text-center"><?php echo $yearType . '第' . $monthType/3 . '季追蹤' ?></h5>

        <?php $this->load->view('report/templates/month_report_track_table');?>

        <?php else: ?>
          <h5 class="text-center"><?php echo '輔導員尚未送出報表' ?></h5>
        <?php endif;?>

        <br/>

        <?php if ($reportLogs): ?>
                <h5 class="text-center"><?php echo '審核流程' ?></h5>

                <table class="table table-hover text-center" style="border:2px grey solid;">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col">使用者姓名</th>
                      <th scope="col">時間</th>
                      <th scope="col">狀態</th>
                      <th scope="col">評論</th>
                    </tr>
                  </thead>

                    <?php foreach ($reportLogs as $value) {?>
                      <tbody>
                        <tr>
                          <td><?php echo $value['userName'] ?></php></td>
                          <td><?php echo $value['time'] ?></php></td>
                          <td><?php foreach ($processReviewStatuses as $i) {
          if ($i['no'] == $value['review_status']) {
          echo $i['content'];
          }
          }?></php></td>
                            <td><?php echo $value['comment'] ?></php></td>

                        </tr>

                      </tbody>
                    <?php }?>

                </table>
              <?php endif;?>

          <br/><br/>

        <?php if ($reportProcessesCountyStatus == $reviewStatus['review_process_wait'] && $role == 3): ?>

          <div class="row">
            <div class="input-field col-10 m-2 mx-auto">
              <label>審核</label>
                <select class="form-select" name="reviewStatus" required>
                  <?php if ($reportProcessesCountyStatus == $reviewStatus['review_process_wait']) {?>
                  <option disabled selected value>請選擇</option>
                  <?php }
          foreach ($processReviewStatuses as $i) {
          if ($reportProcessesCountyStatus != $reviewStatus['review_process_wait']) {
          if ($i['no'] == $reportProcessesCountyStatus) {?>
                  <option selected value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                  <?php } else {
                    if($i['content'] != '等待送出') {?>
                  <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>

                  <?php } }
          } else {if($i['content'] != '等待送出') {?>
            <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>

            <?php } }?>
                  <?php }?>
                </select>
              </div>
            </div>



                   <div class="row">
            <div class="input-field col-10 m-2 mx-auto">
              <label for="formComment" class="form-label">備註*:</label>
              <textarea class="form-control" required id="formComment" name="comment" placeholder=""></textarea>
            </div>
          </div>

          <!-- <div class="row">
            <div class="file-field input-field col s10 offset-m2 m8">
              <?php if ('1 ' != '0'): ?>
              <button class="btn waves-effect blue darken-4">
                <span>上傳檔案</span>
                <input type="file" name="reportFile">
              </button>
              <?php endif;?>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text" placeholder="報表電子檔">
              </div>
            </div>
            <?php if (!empty($twoYearsTrendSurveyCountReports->report_file_name)): ?>
            <?php if (strpos($twoYearsTrendSurveyCountReports->report_file_name, 'pdf') !== false): ?>
            <a class="col s10 offset-m2 m8"
              href="<?php echo site_url() . '/files/' . $twoYearsTrendSurveyCountReports->report_file_name; ?>" download="<?php echo $yearType . '年' . $monthType . '月' . $title?>"><?php echo $yearType . '年' . $monthType . '月' . $title?></a>
            <?php else: ?>
            <div class="col s10 offset-m2 m8">
              <img class="materialboxed responsive-img"
                src="<?php echo site_url() . '/files/' . $twoYearsTrendSurveyCountReports->report_file_name; ?>" />
            </div>
            <?php endif;?>
            <?php endif;?>
          </div> -->

          <div class="row">
              <div class="d-grid gap-2 col-2 mx-auto">
                <button class="btn btn-primary my-5" type="submit">送出</button>
              </div>
            </div>
        </form>

        <?php endif;?>

      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    $('#download').click(function () {
        var data = $("#form").html();
        if (data == '') {
            alert('請先搜尋您想要下載的數據');
        } else {
            var html = "<html><head><meta   charset= 'utf-8'></head><body>" + data + "</body></html>";
            window.open('data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,' + encodeURIComponent(html));
        }
    });

    function downloadCSV(csv, filename) {
        var csvFile;
        var downloadLink;

        // CSV file
        csvFile = new Blob(["\uFEFF"+csv], {type: 'text/csv;charset=utf-8;'});

        // Download link
        downloadLink = document.createElement("a");

        // File name
        downloadLink.download = filename;

        // Create a link to the file
        downloadLink.href = window.URL.createObjectURL(csvFile);

        // Hide download link
        downloadLink.style.display = "none";

        // Add the link to DOM
        document.body.appendChild(downloadLink);

        // Click download link
        downloadLink.click();
    } 

    function exportTableToCSV(report,filename) {
      var csv = [];
      var rows = document.querySelectorAll(report + "table tr");
      
      for (var i = 0; i < rows.length; i++) {
          var row = [], cols = rows[i].querySelectorAll("td, th");
          if(i%2 != 0 || i == 0){
            for (var j = 0; j < cols.length; j++) 
                
                row.push(cols[j].innerText);
            csv.push(row.join(","));        
          }
                
    }
    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
    }

</script>
<?php $this->load->view('templates/new_footer');?>
