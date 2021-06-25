<?php $this->load->view('templates/new_header');?>

<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">系統帳號管理</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h4 class="text-dark text-center"><?php echo $title ?></h4>
      <div class="d-grid gap-2 col-2 mx-auto">
        <a class="btn btn-info m-3" href="<?php echo site_url($url); ?>">新增</a>
      </div>
      <div class="card-content">
        <table class="table table-hover text-center">
          <thead class="thead-dark">
            <tr>
              <th scope="col">編號</th>
              <th scope="col">帳號</th>
              <th scope="col">稽查者</th>
              <th scope="col">日期</th>
              <th scope="col">開始日期</th>
              <th scope="col">結束日期</th>
              <th scope="col">狀態</th>
              <th scope="col">備註</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($audits as $i) {?>
              <tr>
                <td><?php echo $i['no']; ?></td>
                <td><?php echo $i['id']; ?></td>
                <td><?php echo $i['audit_id']; ?></td>
                <td><?php echo $i['date']; ?></td>
                <td><?php echo $i['start_date']; ?></td>
                <td><?php echo $i['end_date']; ?></td>
                <td><?php foreach ($statuses as $value) {
                    if ($value['no'] == $i['status']) {
                      echo $value['content'];
                    }
                  } ?></td>
                <td><?php echo $i['note']; ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('templates/new_footer');?>
