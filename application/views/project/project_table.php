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

      <table class="countyDelegateOrganization table table-hover table-bordered align-middle text-center" style="border:2px grey solid;">
          <thead class="thead-dark">
						<tr>
              <th scope="col">縣市</th>
							<th scope="col">計<br/>畫<br/>名<br/>稱</th>
							<th scope="col">機<br/>構<br/>名<br/>稱</th>
							<th scope="col">機<br/>構<br/>電<br/>話</th>
							<th scope="col">機<br/>構<br/>地<br/>址</th>
							<th scope="col">辦<br/>理<br/>模<br/>式</th>
							<th scope="col">辦<br/>理<br/>方<br/>式</th>
              <th scope="col">輔<br/>導<br/>員<br/>數<br/>量</th>
              <th scope="col">跨<br/>局<br/>處<br/>會<br/>議<br/>次<br/>數</th>
              <th scope="col">預<br/>計<br/>關<br/>懷<br/>追<br/>蹤<br/>人<br/>數</th>
							<th scope="col">預<br/>計<br/>輔<br/>導<br/>人<br/>數</th>
							<th scope="col">個<br/>別<br/>輔<br/>導<br/>時<br/>數</th>
              <th scope="col">團<br/>體<br/>輔<br/>導<br/>時<br/>數</th>
							<th scope="col">生<br/>涯<br/>探<br/>索<br/>課<br/>程<br/>-<br/>小<br/>時</th>
							<th scope="col">工<br/>作<br/>體<br/>驗<br/>-<br/>人<br/>數</th>
              <th scope="col">工<br/>作<br/>體<br/>驗<br/>-<br/>小<br/>時</th>
              <th scope="col">計<br/>畫<br/>經<br/>費</th>
            </tr>
          </thead>
          <tbody>
				
						<tr>
							<td><?php echo empty($projects) ? '' : $projects->countyName; ?></td>
							<td><?php echo empty($projects) ? '' : $projects->name; ?></td>
							<td><?php echo empty($projects) ? '' : $projects->organizationName; ?></td>
              <td><?php echo empty($projects) ? '' : $projects->phone; ?></td>
              <td><?php echo empty($projects) ? '' : $projects->address; ?></td>
							<td><?php foreach ($executeModes as $value) {
    if ($value['no'] == (empty($projects) ? '' :$projects->execute_mode)) {
        echo $value['content'];
    }
}?></td>
              <td><?php foreach ($executeWays as $value) {
    if ($value['no'] == (empty($projects) ? '' :$projects->execute_way)) {
        echo $value['content'];
    }
}?></td>
              <td><?php echo empty($projects) ? '' : $projects->counselor_count; ?></td>
              <td><?php echo empty($projects) ? '' : $projects->meeting_count; ?></td>
              <td><?php echo empty($projects) ? '' : $projects->counseling_youth; ?></td>
              <td><?php echo empty($projects) ? '' : $projects->counseling_member; ?></td>
              <td><?php echo empty($projects) ? '' : $projects->counseling_hour; ?></td>
              <td><?php echo empty($projects) ? '' : $projects->group_counseling_hour; ?></td>
              <td><?php echo empty($projects) ? '' : $projects->course_hour; ?></td>
              <td><?php echo empty($projects) ? '' : $projects->working_member; ?></td>
              <td><?php echo empty($projects) ? '' : $projects->working_hour; ?></td>
              <td><?php echo number_format((empty($projects) ? '' : $projects->funding)); ?></td>
						</tr>

          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>
<?php $this->load->view('templates/new_footer');?>