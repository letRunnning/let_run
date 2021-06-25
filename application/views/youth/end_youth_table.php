<?php $this->load->view('templates/new_header');?>
<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">評估開案</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/youth/get_all_youth_table'); ?>">需關懷追蹤青少年清單</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>
<div class="container">
  <!-- <div class="row"> 
    <a class="btn col s2 offset-s0 waves-effect teal darken-2" style="margin:10px;" href="<?php echo site_url('/youth/get_all_youth_table'); ?>">←需關懷追蹤青少年清單</a>
  </div> -->
  
  <div class="col-md-12" style="text-align:center;">
    <h4 class="text-dark text-center"><?php echo $title ?></h4>
  </div>

  <h6 class="text-center">青少年: <?php echo $youths->name; ?></h6>
  <div class="col-md-12" style="text-align:center;">
    <a class="btn btn-info" href="<?php echo site_url($url);?>">新增</a>
  </div>
  <br>
      

      

      <!-- <a class="btn col s2 offset-s5 waves-effect blue lighten-1" href="<?php echo site_url($url);?>">新增</a> -->
      <div class="table-responsive">
        <table class="table table-hover">
          <!-- <thead class="header"> -->
          <thead class="thead-dark">
            <tr>
              <th scope="col">日期</th>
              <th scope="col">狀態</th>
              <th scope="col">要項</th>
            </tr>
          </thead>
          <!-- <tbody class="scrollable-body"> -->
          <tbody>
            <?php if($reviews){
            foreach($reviews as $i) { ?>
              <tr>
                <td><?php echo date('Y-m-d',strtotime($i['create_time']));?></td>
                <td><?php foreach($statuses as $value) {
                  if($i['status'] == $value['no']) {
                    echo $value['content'];
                  }
                }?></td>
                <td>
                  <a class="btn btn-info" href="<?php echo site_url('youth/end_youth/'.$youth.'/'.$i['no']);?>">查看</a>
									<a class="btn btn-warning" href="<?php echo site_url('youth/delete_end_youth_table?no=' . $i['no']); ?>">刪除</a>
                </td>
              </tr>
            <?php }} ?>
          </tbody>
        </table>
  </div>
</div>
<?php $this->load->view('templates/new_footer');?>
