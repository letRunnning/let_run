<?php $this->load->view('templates/new_header');?>

<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">生涯探索課程或活動(措施B)</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h4 class="text-dark text-center"><?php echo $title ?></h4>
      <?php if($hasDelegation != '0'): ?>
        <div class="d-grid gap-2 col-2 mx-auto">
          <a class="btn btn-info m-3" href="<?php echo site_url($url);?>">新增</a>
        </div>
      <?php endif;?>

      <div class="card-content">
        <!-- years -->
        <div class="row">
          <div class="col-12 my-3">
            <label>年度</label>
            <select class="form-select" name="years" id="years" onchange="location = this.value;">
              <?php foreach ($years as $i) { ?>
                <option <?php echo ($yearType == $i['year']) ? 'selected' : ''?> value="<?php echo site_url('/course/get_course_table_by_organization/' . $i['year']);?>"><?php echo $i['year']?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <table class="table table-hover text-center">
          <thead class="thead-dark">
            <tr>
              <th scope="col">課程名稱</th>
              <th scope="col">開課老師</th>
              <th scope="col">課程類別</th>
              <th scope="col">開始時間</th>
              <th scope="col">結束時間</th>
              <th scope="col">要項</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($courses as $i) { ?>
              <tr>
                <td><?php echo $i['course_name'];?></td>
                <td><?php echo $i['expert_name'];?></td>
                <td><?php foreach($categorys as $j) {
                  if($j['no'] == $i['category']) {
                    echo $j['content'];
                  }
                };?></td>
                <td><?php echo $i['start_time'];?></td>
                <td><?php echo $i['end_time'];?></td>
                <td>
                  <a class="btn btn-info mx-2" href="<?php echo site_url($url . $i['no']);?>">查看/修改</a>
                  <a class="btn btn-warning" href="<?php echo site_url('course/delete_course_table?no=' . $i['no']); ?>">刪除</a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('templates/new_footer');?>
