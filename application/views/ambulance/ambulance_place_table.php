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
    <td scope="col"><a type="button" class="btn btn-info" href="<?php echo site_url('ambulance/ambulance_place/' );?>">新增</a></td>
  </div>
  <br>
  <table class="table text-center border-secondary table-hover align-middle">
    <thead class="header" style="background-color:#C8C6A7">
      <tr>
        <th scope="col">路跑活動編號</th>
        <th scope="col">車牌</th>
        <th scope="col">時間</th>
        <th scope="col">經過點</th>
        <th scope="col">要項</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($ambulancePlacement as $i) { ?>
        <tr>
          <th scope="col"><?php echo $i['running_ID']; ?></th>
          <th scope="col"><?php echo $i['liciense_plate']; ?></th>
          <td scope="col"><?php echo $i['arrivetime']; ?></td>
          <td scope="col"><?php echo $i['pass_ID']; ?></td>
          <td scope="col"><a type="button" class="btn btn-warning" href="<?php echo site_url('ambulance/ambulance_place/'.$i['liciense_plate'] );?>">編輯/查看</a></td>
        </tr>
      <?php } ?>
    </tbody>
    <!-- <tbody>
      <tr>
        <th scope="col">A1</th>
        <th scope="col">林氏醫院</th>
        <td scope="col">0900000000</td>
        <td scope="col">MVP-8877</td>
        <td scope="col">2021-06-10 10:00</td>
        <td scope="col">暨大大草原</td>
        <td scope="col"><a type="button" class="btn btn-warning" href="<?php echo site_url('ambulance/ambulance_place/1' );?>">編輯/查看</a></td>
      </tr>
      <tr>
        <th scope="col">A1</th>
        <th scope="col">李氏醫院</th>
        <td scope="col">0900000001</td>
        <td scope="col">MVP-7788</td>
        <td scope="col">2021-06-10 13:00</td>
        <td scope="col">暨大體育館</td>
        <td scope="col"><a type="button" class="btn btn-warning" href="<?php echo site_url('ambulance/ambulance_place/2' );?>">編輯/查看</a></td>
      </tr>
      <tr>
        <th scope="col">A1</th>
        <th scope="col">陳氏醫院</th>
        <td scope="col">0900000002</td>
        <td scope="col">MVP-7799</td>
        <td scope="col">2021-06-10 15:00</td>
        <td scope="col">暨大管院</td>
        <td scope="col"><a type="button" class="btn btn-warning" href="<?php echo site_url('ambulance/ambulance_place/3' );?>">編輯/查看</a></td>
      </tr>
    </tbody> -->
  </table>
</div>
<?php $this->load->view('templates/new_footer'); ?>