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
    <!-- <div class="row">
        <a class="btn col s2 offset-s0 waves-effect teal darken-2" href="<?php echo site_url('/project/manage_county_and_project_table'); ?>">← 縣市計畫案管理</a>
      </div> -->
      
      <table class="countyDelegateOrganization table table-hover table-bordered align-middle text-center" style="border:2px grey solid;">
          <thead>
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

              <th scope="col">縣<br/>市<br/>可<br/>修<br/>改<br/>狀<br/>態</th>
              <th scope="col" style = "width:10%";>要<br/>項</th>
            </tr>
          </thead>
          <tbody>
        	<?php foreach ($countyDelegateOrganizations as $i) {?>
						<tr>
						<td><?php echo $i['countyName']; ?></td>
							<td><?php echo $i['projectName']; ?></td>
							<td><?php echo $i['organizationName']; ?></td>
							<td><?php echo $i['organizationPhone']; ?></td>
							<td><?php echo $i['organizationAddress']; ?></td>
							<td><?php foreach ($executeModes as $value) {
    if ($value['no'] == $i['executeMode']) {
        echo $value['content'];
    }
}?></td>
              <td><?php foreach ($executeWays as $value) {
    if ($value['no'] == $i['executeWay']) {
        echo $value['content'];
    }
}?></td>
              <td><?php echo $i['counselorCount']; ?></td>
              <td><?php echo $i['meetingCount']; ?></td>
							<td><?php echo $i['counselingMember']; ?></td>
              <td><?php echo $i['counselingYouth']; ?></td>
							<td><?php echo $i['counselingHour']; ?></td>
              <td><?php echo $i['groupCounselingHour']; ?></td>
							<td><?php echo $i['courseHour']; ?></td>
							<td><?php echo $i['workingMember']; ?></td>
              <td><?php echo $i['workingHour']; ?></td>
              <td><?php echo number_format($i['funding']); ?></td>
              <td><?php echo $i['update_project'] ? '開啟' : '關閉'; ?></td>
              <?php $isUpdate = $i['update_project'] ? 0 : 1;?>
              <td> <a class="btn waves-effect blue lighten-1" href="<?php echo site_url('project/update_county_project/' . $i['no'] . '/' . $isUpdate); ?>"><?php echo $i['update_project'] ? '關閉' : '開啟'; ?></a></td>
						</tr>
					<?php }?>
          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>
<?php $this->load->view('templates/new_footer');?>