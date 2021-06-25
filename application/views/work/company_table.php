<?php $this->load->view('templates/new_header');?>

<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">工作體驗(措施C)</a>
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
        <a class="btn btn-info m-3" href="<?php echo site_url($url);?>">新增</a>
      </div>
      <div class="card-content">
        <table class="table table-hover text-center">
          <thead class="thead-dark">
            <tr>
              <th scope="col">店家名稱</th>
              <th scope="col">老闆名稱</th>
              <th scope="col">工作類別</th>
              <th scope="col">要項</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($companys as $i) { ?>
              <tr>
                <td><?php echo $i['name'];?></td>
                <td><?php echo $i['boss_name'];?></td>
                <td><?php foreach($categorys as $j) {
                  if($j['no'] == $i['category']) {
                    echo $j['content'];
                  }
                };?></td>
                <td>
                  <a class="btn btn-info mx-2" href="<?php echo site_url($url . $i['no']);?>">查看/修改</a>
                  <a class="btn btn-warning" href="<?php echo site_url('work/delete_company_table?no=' . $i['no']); ?>">刪除</a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('templates/new_footer');?>
