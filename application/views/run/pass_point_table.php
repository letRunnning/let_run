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
    <table class="table text-center border-secondary table-hover align-middle">
      <thead class="header" style="background-color:#C8C6A7">
        <tr>
          <th scope="col">經過點ID</th>
          <th scope="col">經過點名稱</th>
          <th scope="col">經度</th>
          <th scope="col">緯度</th>
          <th scope="col">要項</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="col">L1</th>
          <td scope="col">暨大大草原</td>
          <td scope="col">153.35</td>
          <td scope="col">152.35</td>
          <td scope="col"><a type="button" class="btn btn-warning" href="<?php echo site_url('run/pass_point/1' );?>">編輯/查看</a></td>
        </tr>
        <tr>
          <th scope="col">L1</th>
          <td scope="col">暨大體育館</td>
          <td scope="col">166.22</td>
          <td scope="col">165.22</td>
          <td scope="col"><a type="button" class="btn btn-warning" href="<?php echo site_url('run/pass_point/2' );?>">編輯/查看</a></td>
        </tr>
        <tr>
          <th scope="col">L1</th>
          <td scope="col">暨大管院</td>
          <td scope="col">188.21</td>
          <td scope="col">186.21</td>
          <td scope="col"><a type="button" class="btn btn-warning" href="<?php echo site_url('run/pass_point/3' );?>">編輯/查看</a></td>
        </tr>
      </tbody>
    </table>
  </div> 
</div>
<?php $this->load->view('templates/new_footer');?>