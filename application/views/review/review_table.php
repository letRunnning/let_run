<?php $this->load->view('templates/new_header');?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h4 class="text-dark text-center"><?php echo $title ?></h4>

      <h6 class="text-dark text-center">等待批准清單</h6>
      <div class="card-content">
        <table class="table table-hover">
          <thead class="thead-dark"></thead>
            <tr>
              <th scope="col">日期</th>
              <th scope="col">原由</th>
              <th scope="col">狀態</th>
              <th scope="col">審核時間</th>
              <th scope="col">要項</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($reviewsWaiting as $value) {?>
            <tr>
              <td><?php echo $value['create_time']; ?></td>
              <td><?php if ($value['form_name'] == 'case_assessment'): echo '更換輔導員申請';elseif ($value['form_name'] == 'counselor_users'): echo '輔導員帳號申請';elseif ($value['form_name'] == 'update_usable'): echo '輔導員帳號停用申請';elseif ($value['form_name'] == 'end_youth'):echo '青少年結案申請';elseif($value['form_name'] == 'reopen_youth'): echo '青少年復案申請';elseif($value['form_name'] == 'transfer_youth') : echo '青少年轉介申請'; endif;?></td>
              <td><?php foreach ($statuses as $i) {
    if ($i['no'] == $value['status']) {
        echo $i['content'];
    }
}?></td>
              <td><?php echo $value['end_time']; ?></td>
              <td>
                <a class="btn btn-primary my-5" href="<?php echo site_url($url . '/' . $value['no']); ?>">審核</a>
              </td>
            </tr>
            <?php }?>
          </tbody>
        </table>
      </div>

      <h6 class="text-dark text-center">已批准清單</h6>
      <div class="card-content">
        <table class="table table-hover">
          <thead class="thead-dark">
            <tr>
              <th scope="col">日期</th>
              <th scope="col">原由</th>
              <th scope="col">狀態</th>
              <th scope="col">審核時間</th>
              <th scope="col">要項</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($reviewsAgree as $value) {?>
            <tr>
              <td><?php echo $value['create_time']; ?></td>
              <td><?php if ($value['form_name'] == 'case_assessment'): echo '更換輔導員申請';elseif ($value['form_name'] == 'counselor_users'): echo '輔導員帳號申請';elseif ($value['form_name'] == 'update_usable'): echo '輔導員帳號停用申請';elseif ($value['form_name'] == 'end_youth'):echo '青少年結案申請';elseif($value['form_name'] == 'reopen_youth'): echo '青少年復案申請';elseif($value['form_name'] == 'transfer_youth') : echo '青少年轉介申請'; endif;?></td>
              <td><?php foreach ($statuses as $i) {
                  if ($i['no'] == $value['status']) {
                    echo $i['content'];
                  }
                } ?>
              </td>
              <td><?php echo $value['end_time']; ?></td>
              <td>
                <a class="btn btn-primary my-5" href="<?php echo site_url($url . '/' . $value['no']); ?>">審核</a>
              </td>
            </tr>
            <?php }?>
          </tbody>
        </table>
      </div>

      <h6 class="text-dark text-center">未批准清單</h6>
      <div class="card-content">
        <table class="table table-hover">
          <thead class="thead-dark">
            <tr>
              <th scope="col">日期</th>
              <th scope="col">原由</th>
              <th scope="col">狀態</th>
              <th scope="col">審核時間</th>
              <th scope="col">要項</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($reviewsDisagree as $value) {?>
            <tr>
              <td><?php echo $value['create_time']; ?></td>
              <td><?php if ($value['form_name'] == 'case_assessment'): echo '更換輔導員申請';elseif ($value['form_name'] == 'counselor_users'): echo '輔導員帳號申請';elseif ($value['form_name'] == 'update_usable'): echo '輔導員帳號停用申請';elseif ($value['form_name'] == 'end_youth'):echo '青少年結案申請';elseif($value['form_name'] == 'reopen_youth'): echo '青少年復案申請';elseif($value['form_name'] == 'transfer_youth') : echo '青少年轉介申請'; endif;?></td>
              <td><?php foreach ($statuses as $i) {
                  if ($i['no'] == $value['status']) {
                    echo $i['content'];
                  }
                } ?>
              </td>
              <td><?php echo $value['end_time']; ?></td>
              <td>
                <a class="btn btn-primary my-5" href="<?php echo site_url($url . '/' . $value['no']); ?>">審核</a>
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
