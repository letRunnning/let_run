<?php $this->load->view('templates/new_header'); ?>
<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">跨局處會議及預防性講座</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>
<div class="container" style="width:100%;">
	<div class="row">
  <div class="card-body col-sm-12">
      <h4 class="card-title text-center"><?php echo $title ?></h4>
      <?php if ($hasDelegation != '0'): ?>
      <div class="col-md-12" style="text-align:center;">
        <a class="btn btn-info" href="<?php echo site_url($url); ?>">新增</a>
        </div>
      <?php endif;?>
      <div class="card-content">
      
        <!-- years -->
        <div class="row justify-content-center">
					<div class="col-sm-10 col-md-8">
						<label>年度</label>
						<select class="form-select form-select-lg mb-3" name="years" id="years" onchange="location = this.value;">
							<?php foreach ($years as $i) { ?>
								<<option <?php echo ($yearType == $i['year']) ? 'selected' : '' ?> value="<?php echo site_url('/meeting/meeting_table/' . $i['year']); ?>"><?php echo $i['year'] ?></option>
							<?php } ?>
						</select>

					</div>
				</div>

        <table class="table table-hover align-middle text-center">
          <thead class="thead-dark">
            <tr>
              <th scope="col">會議名稱</th>
              <th scope="col">時間</th>
              <th scope="col">要項</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($meetings as $i) {?>
              <tr>
                <td><?php echo $i['title']; ?></td>
                <td><?php echo $i['start_time']; ?></td>
                <td>
                  <a class="btn btn-info" href="<?php echo site_url($url . $i['no'] . '/' . $i['year']); ?>">查看/修改</a>
                  <a class="btn btn-warning" href="<?php echo site_url('meeting/delete?no=' . $i['no']); ?>">刪除</a>
                </td>
              </tr>
            <?php }?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('templates/new_footer');?>
