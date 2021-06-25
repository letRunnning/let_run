<?php $this->load->view('templates/new_header');?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h4 class="text-dark text-center"><?php echo $title ?></h4>
      <div class="d-grid gap-2 col-2 mx-auto">
        <a class="btn btn-info m-3" href="<?php echo site_url($url); ?>">新增</a>
      </div>
      <div class="card-content">
        <table class="table table-hover">
          <thead class="thead-dark">
            <tr>
              <th scope="col">日期</th>
              <th scope="col">分類</th>
              <th scope="col">內容</th>
              <th scope="col">是否顯示</th>
              <th scope="col">要項</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($messagers as $i) { ?>
              <tr>
                <td><?php echo $i['create_date']; ?></td>
                <td><?php foreach ($types as $value) {
                    if ($value['no'] == $i['type']) {
                      echo $value['content'];
                    }
                  } ?>
                </td>
                <td><?php echo $i['content']; ?></td>
                <td><?php if ($i['is_view']) {
                    echo '是';
                  } else {
                    echo '否';
                  } ?>
                </td>
                <td>
                  <a class="btn btn-info mx-2" href="<?php echo site_url($url . '/' . $i['no']); ?>">查看/修改</a>
	                <a class="btn btn-warning" href="<?php echo site_url('messager/delete?no=' . $i['no']); ?>">刪除</a>
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
