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

<div class="container">
  <div class="d-grid gap-2 col-2 mx-auto">
    <td scope="col"><a type="button" class="btn btn-info" href="<?php echo site_url('beacon/beacon/' );?>">新增</a></td>
  </div>
  <br>
  <table class="table text-center border-secondary table-hover align-middle">
    <thead class="header" style="background-color:#C8C6A7">
      <tr>
        <th scope="col">Beacon編號</th>
        <th scope="col">Beacon型號</th>
        <th scope="col">是否可使用</th>
        <th scope="col">要項</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($beacons as $i) { ?>
        <tr>
          <th scope="col"><?php echo $i['beacon_ID']; ?></th>
          <td scope="col"><?php echo $i['type']; ?></td>
          <td scope="col">
            <?php if ($i['is_available'] == '0') {
              echo '否';
            } else {
              echo '是';
            }
            ?>
          </td>
          <td scope="col"><a type="button" class="btn btn-warning" href="<?php echo site_url('beacon/beacon/'.$i['beacon_ID'] );?>">編輯/查看</a></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<?php $this->load->view('templates/new_footer');?>