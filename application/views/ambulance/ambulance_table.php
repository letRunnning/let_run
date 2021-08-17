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
  <div class="col-md-3 mx-auto">
    <label for="runActive" style="text-align:right;" class="col-form-label">搜尋</label>
    <input id="myInput" class="form-control" type="search" onkeyup="myFunction('all_counselor')" placeholder="搜尋路跑活動">
  </div>
  <br>

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
        <th scope="col">時間</th>
        <th scope="col">活動編號</th>
        <th scope="col">經過點編號</th>
        <th scope="col">要項</th>
      </tr>
    </thead>
    
    <tbody>
      <?php foreach ($ambulance as $i) { ?>
        <tr>
          <th scope="col"><?php echo $i['hospital_name']; ?></th>
          <td scope="col"><?php echo $i['hospital_phone']; ?></td>
          <td scope="col"><?php echo $i['liciense_plate']; ?></td>
          <td scope="col"><?php echo $i['arrivetime']; ?></td>
          <td scope="col"><?php echo $i['running_ID']; ?></td>
          <td scope="col"><?php echo $i['supply_ID']; ?></td>
          <td scope="col"><a type="button" class="btn btn-warning" href="<?php echo site_url('ambulance/ambulance/'.$i['liciense_plate'] );?>">編輯/查看</a></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<?php $this->load->view('templates/new_footer'); ?>