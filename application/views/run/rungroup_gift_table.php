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
<br>
  <div class="row">
    <table class="table text-center border-secondary table-hover align-middle">
      <thead class="header" style="background-color:#C8C6A7">
        <tr>
          <th scope="col">路跑ID</th>
          <th scope="col">組別名稱</th>
          <th scope="col">報到地點</th>
          <th scope="col">起跑時間</th>
          <th scope="col">報到時間</th>
          <th scope="col">要項</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="col">A1</th>
          <td scope="col">休閒組</td>
          <td scope="col">暨大大草原</td>
          <td scope="col">2021/06/01 07:00</td>
          <td scope="col">2021/06/01 06:30</td>
          <!-- <td scope="col"><button type="button" class="btn btn-warning" href="<?php echo site_url('run/rungroup_gift/' .$i['no']);?>">編輯/查看</button></td> -->
          <td scope="col"><a type="button" class="btn btn-warning" href="<?php echo site_url('run/rungroup_gift/1' );?>">編輯/查看</a></td>
        </tr>
        <tr>
          <th scope="col">A1</th>
          <td scope="col">挑戰組</td>
          <td scope="col">暨大大草原</td>
          <td scope="col">2021/06/01 06:30</td>
          <td scope="col">2021/06/01 06:00</td>
          <td scope="col"><a type="button" class="btn btn-warning" href="<?php echo site_url('run/rungroup_gift/2' );?>">編輯/查看</a></td>
        </tr>
        <tr>
          <th scope="col">A3</th>
          <td scope="col">菁英組</td>
          <td scope="col">埔里鎮鎮公所</td>
          <td scope="col">2021/06/15 07:00</td>
          <td scope="col">2021/05/15 06:30</td>
          <td scope="col"><a type="button" class="btn btn-warning" href="<?php echo site_url('run/rungroup_gift/3' );?>">編輯/查看</a></td>
        </tr>
      </tbody>
    </table>
  </div> 
</div>
<?php $this->load->view('templates/new_footer');?>