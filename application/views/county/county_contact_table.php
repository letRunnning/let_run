<?php $this->load->view('templates/new_header'); ?>

<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <!-- <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">縣市聯繫窗口管理</a>
      </li> -->
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>

<div class="container" style="width:100%;">
	<div class="row">
  <div class="card-body col-sm-12">
      <h4 class="card-title text-center"><?php echo $title ?></h4>
      <!-- <a class="btn waves-effect blue darken-4" href="<?php echo site_url($url);?>">新增</a> -->
      <div class="col-md-12" style="text-align:center;">
        <a class="btn btn-info" href="<?php echo site_url($url);?>">新增</a>
      </div>
      <div class="card-content">
        <table class="table table-hover align-middle text-center">
          <thead>
            <tr>
              <th scope="col">縣市</th>
              <th scope="col">承辦單位</th>
              <th scope="col">聯絡人</th>
              <th scope="col">職稱</th>
              <th scope="col">電話</th>
              <th scope="col">信箱</th>
              <th scope="col">要項</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($countyContacts as $i) { ?>
              <tr>
                <td><?php foreach($counties as $value){
                    if($value['no'] == $i['county']){
                        echo $value['name'];
                    }
                }?></td>
                <td><?php echo $i['orgnizer'];?></td>
                <td><?php echo $i['name'];?></td>
                <td><?php echo $i['title'];?></td>
                <td><?php echo $i['phone'];?></td>
                <td><?php echo $i['email'];?></td>
                <td>
                  <a class="btn btn-info" href="<?php echo site_url($url . '/' . $i['no']);?>">查看/修改</a>
									<!-- <a class="btn btn-warning" href="<?php echo site_url('county/delete?no=' . $i['no']); ?>">刪除</a> -->
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
