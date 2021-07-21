<?php $this->load->view('templates/new_header');?>
<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">報到</a>
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

  <table class="table text-center border-secondary table-hover align-middle">
    <thead class="header" style="background-color:#C8C6A7">
      <tr>
        <th scope="col">工作人員編號</th>
        <th scope="col">姓名</th>
        <th scope="col">申請之路跑編號</th>
        <th scope="col">申請組別</th>
        <th scope="col">狀態</th>
        <th scope="col">連絡電話</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($checkin as $i) { ?>
        <tr>
            <th scope="col"><?php echo $i['staff_ID']; ?></th>
            <td scope="col"><?php echo $i['sName']; ?></td>
            <td scope="col"><?php echo $i['running_ID']; ?></td>
            <td scope="col"><?php echo $i['name']; ?></td>
            <td scope="col">
              <?php 
                if ($i['checkin_time'] != '') {
                  if (strtotime($i['checkin_time']) < strtotime($i['assembletime'])) {
                    echo '已報到';
                  } else {
                    echo '<font style="color:#FF0000;">遲到</font>';
                  }
                } else {
                  echo '尚未報到';
                }
              ?>
            </td>
            <td scope="col"><?php echo $i['phone']; ?></td>
          </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<?php $this->load->view('templates/new_footer');?>