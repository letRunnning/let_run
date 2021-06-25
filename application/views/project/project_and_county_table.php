<?php $this->load->view('templates/new_header');?>

<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">計劃案管理</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>

<div class="container" style="width:100%;">
	<div class="row">
    <div class="card-body col-sm-12">
      <h4 class="card-title text-center"><?php echo $title ?></h4>
      <div class="card-content">

      <!-- years -->
      <div class="row justify-content-center">
        <div class="col-sm-10 col-md-8">
          <label>年度</label>
          <select class="form-select form-select-lg mb-3" name="years" id="years" onchange="location = this.value;">
          <option <?php echo ($year == null) ? 'selected' : ''?> value="<?php echo site_url('project/project_and_county/');?>">全部</option>
            <?php foreach ($distinctYears as $y) { ?>
              <option <?php echo ($year == $y['year']) ? 'selected' : ''?> value="<?php echo site_url('project/project_and_county/'. $y['year']);?>"><?php echo $y['year']?></option>
            <?php } ?>
          </select>
        </div>
      </div>
              
      <table class="table table-hover align-middle text-center">
          <thead class="thead-dark">
            <tr>
              <th scope="col">年度</th>
              <th scope="col">縣市</th>
              <th scope="col">計畫</th>
              <th scope="col">機構</th>
              <?php if($current_role != 4) : ?>
                <th scope="col">要項</th>
              <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach($countyDelegateOrganizations as $i) { ?>
              <tr>
                <td><?php echo $i['year'];?></td>
                <td><?php echo $i['countyName'];?></td>
                <td><?php echo $i['projectName'];?></td>
                <td><?php echo $i['organizationName'];?></td>
                <?php if($current_role == 3) : ?>
                  <td><a class="btn btn-info" href="<?php echo site_url('project/create_project/'.$i['no']);?>">查看/修改</a>
								  <!-- <a class="btn btn-warning" href="<?php echo site_url('project/delete?no=' . $i['no']); ?>">刪除</a></td> -->
                <?php elseif ($current_role == 2) :?>
                  <td><a class="btn btn-info" href="<?php echo site_url('project/project_table/'.$i['no']);?>">查看</a></td>
                <?php endif; ?>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('templates/new_footer');?>
