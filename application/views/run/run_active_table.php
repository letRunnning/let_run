<?php $this->load->view('templates/new_header');?>
<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">路跑活動</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>
<div class="container" style="width:95%">
<div class="row">
    <div class="d-grid gap-2 col-2 mx-auto">
      <a class="btn btn-info m-3" href="<?php echo site_url($url); ?>">新增</a><br>
    </div>
</div>
<table class="table text-center border-secondary table-hover align-middle">
  <thead class="header" style="background-color:#C8C6A7">
    <tr>
      <th scope="col">路跑ID</th>
      <th scope="col">路跑名稱</th>
      <th scope="col">活動日期</th>
      <th scope="col">報名開始時間</th>
      <th scope="col">報名結束時間</th>
      <th scope="col">要項</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($activities as $i) { ?>
    <tr>
      <th scope="col"><?php echo $i['running_ID']?></th>
      <td scope="col"><?php echo $i['name']?></td>
      <td scope="col"><?php echo $i['date']?></td>
      <td scope="col"><?php echo $i['start_time']?></td>
      <td scope="col"><?php echo $i['end_time']?></td>
      <td scope="col"><a type="button" class="btn btn-warning" href="<?php echo site_url('run/run_active/'.$i['running_ID'] );?>">編輯/查看</a></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
</div>
<?php $this->load->view('templates/new_footer');?>