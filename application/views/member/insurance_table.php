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
      
      <!-- <div class="col-10 m-2"> 
        <a class="btn btn-success" href="<?php echo site_url('/member/get_member_table_by_counselor'); ?>">←學員列表</a>
      </div> -->

      <div class="row">
        <h4 class="text-dark text-center"><?php echo $title ?></h4>
      </div>
      
      <h6 class="text-center">編號: <?php echo $members->system_no; ?></h6>
      <h6 class="text-center">學員: <?php echo $members->name; ?></h6>
      <h6 class="text-dark">「針對參加生涯探索課程或活動（措施B）、工作體驗（措施C）之輔導對象應全程投保，每人保額至少為新台幣300萬元意外險和5醫療險，另參加工作體驗（措施C）之學員，應全程投保訓字保。」</h6>
      
      <?php if ($hasDelegation != '0'): ?>
        <div class="d-grid gap-2 col-2 mx-auto">
          <a class="btn btn-info m-3" href="<?php echo site_url($url);?>">新增</a>
        </div>
      <?php endif;?>
      <div class="card-content">
        <table class="table table-hover text-center">
          <thead class="thead-dark">
            <tr>
              <th scope="col">開始日期</th>
              <th scope="col">結束日期</th>
              <th scope="col">要項</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($insurances as $i) {?>
              <tr>
                <td><?php echo $i['start_date']; ?></td>
                <td><?php echo $i['end_date']; ?></td>
                <td>
                  <a class="btn btn-info" href="<?php echo site_url('member/insurance/' . $i['member'] . '/' . $i['no']); ?>">查看/修改</a>
                  <a class="btn btn-warning" href="<?php echo site_url('member/delete_insurance_table?no=' . $i['no']); ?>">刪除</a>
                </td>
              </tr>
            <?php }?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('templates/new_footer');?>
