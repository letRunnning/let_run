<?php $this->load->view('templates/new_header');?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h4 class="text-dark text-center"><?php echo $title ?></h4>
      <div class="card-content">
        <table class="table table-hover">
          <thead class="thead-dark">
            <tr>
              <th scope="col">編號</th>
              <th scope="col">身分證</th>
              <th scope="col">姓名</th>      
              <th scope="col">輔導會談</th>
              <th scope="col">個別諮詢</th>
              <th scope="col">團體輔導</th>
              <th scope="col">生涯探索課程</th>
              <th scope="col">工作體驗</th>
              <th scope="col">教育資源</th>
              <th scope="col">勞政資源</th>
              <th scope="col">社政資源</th>
              <th scope="col">衛政資源</th>
              <th scope="col">警政資源</th>
              <th scope="col">司法資源</th>
              <th scope="col">其他資源</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($members as $i) { ?>
              <tr>
                <td><?php echo $i['system_no'];?></td>
                <td><?php echo $i['identification'];?></td>
                <td><?php echo $i['name'];?></td>
                <td><?php echo $i['individualCounselingHour'] + $i['groupCounselingHour']?></td>
                <td><?php echo $i['individualCounselingHour']?></td>
                <td><?php echo $i['groupCounselingHour']?></td>
                <td><?php echo $i['courseAttendanceHour']?></td>
                <td><?php echo $i['workAttendanceHour']?></td>
                <td><?php echo $i['educationSourceHour']?></td>
                <td><?php echo $i['laborSourceHour']?></td>
                <td><?php echo $i['socialSourceHour']?></td>
                <td><?php echo $i['healthSourceHour']?></td>
                <td><?php echo $i['officeSourceHour']?></td>
                <td><?php echo $i['judicialSourceHour']?></td>
                <td><?php echo $i['otherSourceHour']?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('templates/new_footer');?>
