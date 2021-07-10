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
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
    </ol>
  </nav>
</div>

<div class="container" style="width:95%">
  <div class="d-grid gap-2 col-2 m-4 mx-auto">
    <td scope="col"><a type="button" class="btn btn-info" href="<?php echo site_url('run/workgroup/' );?>">新增</a></td>
  </div>
  <br>
  <table class="table text-center border-secondary table-hover align-middle">
    <thead class="header" style="background-color:#C8C6A7">
      <tr>
        <th scope="col">路跑活動</th>
        <th scope="col">組別名稱</th>
        <th scope="col">集合地點</th>
        <th scope="col">集合時間</th>
        <th scope="col">負責人</th>
        <th scope="col">要項</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($workgroups as $i) { ?>
      <tr>
        <th scope="col"><?php echo $i['runName']?></th>
        <th scope="col"><?php echo $i['workName']?></th>
        <th scope="col"><?php echo $i['assembleplace']?></th>
        <th scope="col"><?php echo $i['assembletime']?></th>
        <th scope="col"><?php echo $i['leader']?></th>
        <td scope="col"><a type="button" class="btn btn-warning" href="<?php echo site_url('run/workgroup/'.$i['workgroup_ID']  );?>">編輯/查看</a></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<?php $this->load->view('templates/new_footer');?>