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
  <div class="row justify-content-center">
    <div class="col-md-3">
      <label for="runActive" style="text-align:right;" class="col-form-label">搜尋</label>
      <input id="myInput" class="form-control" type="search" onkeyup="myFunction('all_counselor')" placeholder="搜尋路跑活動">
    </div>

    <div class="col-md-3">
      <label for="runActive" style="text-align:right;" class="col-form-label">搜尋</label>
      <input id="myInput" class="form-control" type="search" onkeyup="myFunction('all_counselor')" placeholder="搜尋路跑活動">
    </div>
  </div>
  <br>

  <div class="d-grid gap-2 col-2 mx-auto">
    <td scope="col"><a type="button" class="btn btn-info" href="<?php echo site_url('beacon/beacon_place/' );?>">新增</a></td>
  </div>
  <br>
  <table class="table text-center border-secondary table-hover align-middle">
    <thead class="header" style="background-color:#C8C6A7">
      <tr>
        <th scope="col">Beacon編號</th>
        <th scope="col">路跑編號</th>
        <th scope="col">組別名稱</th>
        <th scope="col">排序</th>
        <th scope="col">經度</th>
        <th scope="col">緯度</th>
        <th scope="col">種類</th>
        <th scope="col">使用中</th>
        <th scope="col">要項</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="col">Ada Lovelace</th>
        <td scope="col">A1</td>
        <td scope="col">10K休閒組</td>
        <td scope="col">1</td>
        <td scope="col">232.12</td>
        <td scope="col">232.12</td>
        <td scope="col">起點</td>
        <td scope="col">是</td>
        <td scope="col"><a type="button" class="btn btn-warning" href="<?php echo site_url('beacon/beacon_place/1' );?>">編輯/查看</a></td>
      </tr>
      <tr>
        <th scope="col">Grace Hopper</th>
        <td scope="col">A1</td>
        <td scope="col">10K休閒組</td>
        <td scope="col">2</td>
        <td scope="col">432.12</td>
        <td scope="col">432.12</td>
        <td scope="col">補給站</td>
        <td scope="col">是</td>
        <td scope="col"><a type="button" class="btn btn-warning" href="<?php echo site_url('beacon/beacon_place/2' );?>">編輯/查看</a></td>
      </tr>
      <tr>
        <th scope="col">Joan Clarke</th>
        <td scope="col">A1</td>
        <td scope="col">10K休閒組</td>
        <td scope="col">3</td>
        <td scope="col">251.58</td>
        <td scope="col">152.12</td>
        <td scope="col">終點</td>
        <td scope="col">是</td>
        <td scope="col"><a type="button" class="btn btn-warning" href="<?php echo site_url('beacon/beacon_place/3' );?>">編輯/查看</a></td>
      </tr>
    </tbody>
  </table>
</div>
<?php $this->load->view('templates/new_footer');?>