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
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/youth/get_all_youth_table'); ?>">需關懷追蹤青少年清單</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <!-- <a class="btn btn-warning" style="margin:10px;text-align:left;" href="<?php echo site_url('/youth/get_all_youth_table'); ?>">←需關懷追蹤青少年清單</a> -->
    </div>

      <div class="row">
        <h4 class="card-title text-center"><?php echo $title ?></h4>
      </div>
      
      <h6 class="text-center">青少年: <?php echo $youths->name; ?></h6>
      <div class="col-md-12" style="text-align:center;">
        <a class="btn btn-info" href="<?php echo site_url($url);?>">新增</a><br>
      <!-- <a class="btn col s2 offset-s5 waves-effect blue lighten-1" href="<?php echo site_url($url);?>">新增</a> -->
      <!-- <div class="card-content"> -->
        <br>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead class="thead-dark">
            <tr>
              <th scope="col">日期</th>
              <th scope="col">完整度</th>
              <th scope="col">要項</th>
            </tr>
          </thead>
          <!-- <tbody class="scrollable-body"> -->
          <tbody>
            <?php foreach($seasonalReviews as $i) { ?>
              <tr>
                <td><?php echo date('Y-m-d',strtotime($i['date']));?></td>
                <td><?php foreach($seasonalReviewCompletions as $value) {
                  if($i['no'] == $value['form_no']) {
                    echo $value['rate'] . '%';
                  }
                }?></td>
                <td>
                  <a class="btn btn-info" href="<?php echo site_url('youth/seasonal_review/'.$i['youth'].'/'.$i['no']);?>">查看/修改</a>
									<!-- <a class="btn btn-warning" href="<?php echo site_url('youth/delete_seasonal_review_table?no=' . $i['no']); ?>">刪除</a> -->
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      <!-- </div> -->
      </div> 
    </div>
  </div>
</div>
<?php $this->load->view('templates/new_footer');?>
