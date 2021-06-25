<?php $this->load->view('templates/new_header');?>

<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">輔導會談(措施A)</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/member/get_member_table_by_counselor'); ?>" <?php echo $url == '/member/get_member_table_by_counselor' ? 'active' : ''; ?>>開案學員清單</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h4 class="text-dark text-center"><?php echo $title ?></h4>
      <?php if($hasDelegation != '0'): ?>
        <div class="d-grid gap-2 col-2 mx-auto">
          <a class="btn btn-info m-3" href="<?php echo site_url($url);?>">新增</a>
        </div>
      <?php endif;?>
      <div class="card-content">
        <table class="table table-hover text-center">
          <thead class="thead-dark">
            <tr>
              <th scope="col">日期</th>
              <th scope="col">完整度</th>
              <th scope="col">要項</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($monthReviews as $i) { ?>
              <tr>
                <td><?php echo $i['date'];?></td>
                <td><?php foreach($monthReviewCompletions as $value) {
                  if($i['no'] == $value['form_no']) {
                    echo $value['rate'] . '%';
                  }
                }?></td>
                <td>
                  <a class="btn btn-info m-2" href="<?php echo site_url('member/month_review/'.$i['member'].'/'.$i['no']);?>">查看/修改</a>
                  <a class="btn btn-warning" href="<?php echo site_url('member/delete_review_table?no=' . $i['no']); ?>">刪除</a>
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
