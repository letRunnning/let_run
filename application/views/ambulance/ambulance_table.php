<?php $this->load->view('templates/new_header'); ?>
<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
    </ol>
  </nav>
</div>

<div class="container">
  <div class="d-grid gap-2 col-2 mx-auto">
    <td scope="col"><a type="button" class="btn btn-info" href="<?php echo site_url('ambulance/ambulance/' );?>">新增</a></td>
  </div>
  <br>
  <table class="table text-center border-secondary table-hover align-middle">
    <thead class="header" style="background-color:#C8C6A7">
      <tr>
        <th scope="col">醫院</th>
        <th scope="col">電話</th>
        <th scope="col">車牌</th>
        <th scope="col">要項</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="col">林氏醫院</th>
        <td scope="col">0900000000</td>
        <td scope="col">MVP-8877</td>
        <td scope="col"><a type="button" class="btn btn-warning" href="<?php echo site_url('ambulance/ambulance/1' );?>">編輯/查看</a></td>
      </tr>
      <tr>
      <th scope="col">李氏醫院</th>
        <td scope="col">0900000001</td>
        <td scope="col">MVP-7788</td>
        <td scope="col"><a type="button" class="btn btn-warning" href="<?php echo site_url('ambulance/ambulance/2' );?>">編輯/查看</a></td>
      </tr>
      <tr>
      <th scope="col">陳氏醫院</th>
        <td scope="col">0900000002</td>
        <td scope="col">MVP-7799</td>
        <td scope="col"><a type="button" class="btn btn-warning" href="<?php echo site_url('ambulance/ambulance/3' );?>">編輯/查看</a></td>
      </tr>
    </tbody>
  </table>
</div>
<?php $this->load->view('templates/new_footer'); ?>