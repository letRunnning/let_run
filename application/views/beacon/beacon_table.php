<?php $this->load->view('templates/new_header');?>
<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">Beacon</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
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
          <th scope="col">Beacon編號</th>
          <th scope="col">Beacon型號</th>
          <th scope="col">是否可使用</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="col">asd123</th>
          <td scope="col">Ci - BLE MESH</td>
          <td scope="col"><a type="button" class="btn btn-warning" href="<?php echo site_url('run/pass_point/1' );?>">是</a></td>
        </tr>
        <tr>
          <th scope="col">qwe123</th>
          <td scope="col">Ci - AYU MESH</td>
          <td scope="col"><a type="button" class="btn btn-warning" href="<?php echo site_url('run/pass_point/2' );?>">是</a></td>
        </tr>
        <tr>
          <th scope="col">qwe126</th>
          <td scope="col">Ci - IOP MESH</td>
          <td scope="col"><a type="button" class="btn btn-warning" href="<?php echo site_url('run/pass_point/3' );?>">是</a></td>
        </tr>
      </tbody>
    </table>
  </div> 
</div>
<?php $this->load->view('templates/new_footer');?>