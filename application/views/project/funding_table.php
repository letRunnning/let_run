<?php $this->load->view('templates/new_header');?>

<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">縣市與計畫案管理</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/project/manage_county_and_project_table'); ?>">縣市計畫案管理</a>
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

      <h6 class="text-center">縣市 : <?php echo $counties->name; ?></h6>

      <br/>
      <div class="col-md-12" style="text-align:center;">
        <a class="btn btn-info mx-2" href="<?php echo site_url($url); ?>">新增</a>
      </div>
      <br/><br/>

      <table class="countyDelegateOrganization table table-hover table-bordered align-middle text-center" style="border:2px grey solid;">
          <thead>
						<tr>
						  <th scope="col">撥付日期</th>
							<th scope="col">撥付金額</th>
              <th scope="col">備註</th>
              <th scope="col">要項</th>
							<!-- <th scope="col">計畫案管理</th> -->

            </tr>
          </thead>
          <tbody>
          <?php foreach ($fundingApproves as $value) {?>

						<tr>
							<td><?php echo empty($value) ? '' : $value['date']; ?></td>
              <td><?php echo empty($value) ? '' : number_format($value['funding']); ?></td>
              <td><?php echo empty($value) ? '' : $value['note']; ?></td>
              <td>
                <a class="btn btn-info mx-2" href="<?php echo site_url('project/funding/' . $counties->no . '/' . $value['no']); ?>">管理</a>
                <!-- <a class="btn btn-warning" href="<?php echo site_url('project/delete_funding_table?no=' . $value['no']); ?>">刪除</a> -->
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
