<?php $this->load->view('templates/new_header');?>
<div class="container">
  <div class="row">
    <div class="col-md-12">

      <div class="col-10 m-2"> 
        <a class="btn btn-success" style="margin:10px;" href="<?php echo site_url('/youth/get_all_youth_table'); ?>">←需關懷追蹤青少年清單</a>
      </div>

      <div class="row">
        <h4 class="text-dark text-center"><?php echo $title ?></h4>
      </div>

      <div class="card-content">

        <?php if($type == 'report_one_seasonal_review') :?>
          <h4 class="text-dark"><?php echo '欄位: ' . $trendName; ?></h4>
          <h4 class="text-dark"><?php echo '包含: ' . $trendInclude; ?></h4>
          <h4 class="text-dark"><?php echo '數量: ' . count($value); ?></h4>
          <table class="table table-hover text-center">
            <thead class="thead-dark">
              <tr>
                <th scope="col">流水號</th>
                <th scope="col">日期</th>
                <th scope="col">姓名</th>
                <th scope="col">是否開案</th>
                <th scope="col">動向</th>
                <th scope="col">備註</th>
                <th scope="col">要項</th>
              </tr>
            </thead>
            <tbody>
              <?php $count = 1;
                    foreach($value as $i) { ?>
                <tr>
                  <td><?php echo $count; $count++;?></td>
                  <td><?php echo date('Y-m-d',strtotime($i['date']));?></td>
                  <td><?php echo $i['youthName'];?></td>
                  <td><?php echo $i['is_counseling'] ? '是' : '否';?></td>
                  <td><?php foreach($trends as $j) {
                    if($i['trend'] == $j['no']) echo $j['content'];
                  } ?></td>
                   <td><?php echo $i['trend_description'];?></td>
                  <td>
                    <a class="btn btn-info mx-2" href="<?php echo site_url('youth/seasonal_review/'.$i['youth'].'/'.$i['no']);?>">查看/修改</a>                         
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>

        <?php elseif($type == 'report_one_member_month_temp') :?>
          <h4 class="text-dark"><?php echo '欄位: ' . $trendName; ?></h4>
          <h4 class="text-dark"><?php echo '包含: ' . $trendInclude; ?></h4>
          <h4 class="text-dark"><?php echo '數量: ' . count($value); ?></h4>
          <table class="table table-hover text-center">
            <thead class="thead-dark">
              <tr>
                <th scope="col">流水號</th>
                <th scope="col">姓名</th>
                <th scope="col">動向</th>
                <th scope="col">備註</th>
                <th scope="col">要項</th>
              </tr>
            </thead>
            <tbody>
              <?php $count = 1;
                    foreach($value as $i) { ?>
                      <tr>
                        <td><?php echo $count; $count++;?></td>
                        <td><?php echo $i['youthName'];?></td>
                        <td><?php foreach($endCaseTrends as $j) {
                          if($i['trend'] == $j['no']) echo $j['content'];
                        }?></td>
                        <td><?php echo $i['trend_description'];?></td>
                        <td>
                          <a class="btn btn-info mx-2" href="<?php echo site_url('report/month_member_temp_counseling/' . $yearType . '/' . $monthType);?>">查看/修改</a>                         
                        </td>
                      </tr>
              <?php } ?>
            </tbody>
          </table>

        <?php elseif($type == 'report_one_member_source') :?>
          <h4 class="text-dark"><?php echo '欄位: ' . $trendName; ?></h4>
          <h4 class="text-dark"><?php echo '數量: ' . count($value); ?></h4>
          <table class="table table-hover text-center">
            <thead class="thead-dark">
              <tr>
                <th scope="col">流水號</th>
                <th scope="col">姓名</th>
                <th scope="col">來源</th>
                <th scope="col">開案時間</th>
                <th scope="col">結案時間</th>
              </tr>
            </thead>
            <tbody>
              <?php $count = 1;
                    foreach($value as $i) { ?>
                      <tr>
                        <td><?php echo $count; $count++;?></td>
                        <td><?php echo $i['name'];?></td>
                        <td><?php if($i['source'] == '194') : echo '動向調查';
                                  elseif($i['source'] == '229') : echo '高中已錄取未註冊';
                                  elseif($i['source'] == '195') : echo '轉介或自行開發';
                                  elseif($i['source'] == '229,194') : echo '動向調查';
                                  endif;?></td>
                        <td><?php echo $i['create_date'];?></td>
                        <td><?php echo $i['end_date'];?></td>
                      </tr>
              <?php } ?>
            </tbody>
          </table>

        <?php elseif($type == 'report_one_member_counseling') :?>
          <?php if($trend == 'one'):?>
            <h4 class="text-dark"><?php echo '欄位: ' . $trendName; ?></h4>
            <h4 class="text-dark"><?php echo '包含: ' . $trendInclude; ?></h4>
            <h4 class="text-dark"><?php echo '總計: ' . ($sumOne + $sumTwo) . '(' . $sumOne . '+' . $sumTwo . ')小時'; ?></h4>

            <h5 class="text-dark text-center">個別輔導時數</h5>
            <h5 class="text-dark text-center"><?php echo '共: ' . $sumOne . '小時'; ?></h5>
            <table class="table table-hover text-center">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">流水號</th>
                  <th scope="col">學員編號</th>
                  <th scope="col">姓名</th>
                  <th scope="col">時數</th>
                  <th scope="col">要項</th>
                </tr>
              </thead>
              <tbody>
                <?php $count = 1;
                      foreach($valueOne as $i) { ?>
                        <tr>
                          <td><?php echo $count; $count++;?></td>
                          <td><?php echo $i['system_no'];?></td>
                          <td><?php echo $i['name'];?></td>
                          <td><?php echo $i['sum'];?></td>
                          <td>
                            <a class="btn btn-success" href="<?php echo site_url('member/get_individual_counseling_table_by_member/' . $i['member']);?>">個別諮詢紀錄清單</a>  
                          </td>
                        </tr>
                  <?php } ?>
              </tbody>
            </table>

          
            <h5 class="text-dark text-center">團體輔導時數</h5>
            <h5 class="text-dark text-center"><?php echo '共: ' . $sumTwo . '小時'; ?></h5>
            <table class="table table-hover text-center">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">流水號</th>
                  <th scope="col">學員編號</th>
                  <th scope="col">姓名</th>
                  <th scope="col">時數</th>
                  <th scope="col">要項</th>
                </tr>
              </thead>
              <tbody>
                <?php $count = 1;
                      foreach($valueTwo as $i) { ?>
                        <tr>
                          <td><?php echo $count; $count++;?></td>
                          <td><?php echo $i['system_no'];?></td>
                          <td><?php echo $i['name'];?></td>
                          <td><?php echo $i['sum'];?></td>
                          <td>
                            <a class="btn btn-info mx-2" href="<?php echo site_url('member/get_group_counseling_table_by_member/' . $i['member']); ?>">團體輔導紀錄</a>
                          </td>
                        </tr>
                  <?php } ?>
              </tbody>
            </table>

          <?php elseif($trend == "two"):?>
            <h4 class="text-dark"><?php echo '欄位: ' . $trendName; ?></h4>
        
            <h4 class="text-dark"><?php echo '總計: ' . ($sumOne) . '小時'; ?></h4>

          
            <table class="table table-hover text-center">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">流水號</th>
                  <th scope="col">課程名稱</th>
                  <th scope="col">時間</th>
                  <th scope="col">參與學員</th>
                  <th scope="col">時數</th>
                  <th scope="col">要項</th>
                </tr>
              </thead>
              <tbody>
                <?php $count = 1;
                      foreach($valueOne as $i) { ?>
                        <tr>
                          <td><?php echo $count; $count++;?></td>
                          <td><?php echo $i['name'];?></td>
                          <td><?php echo $i['start_time'];?></td>
                          <td><?php $temp = 0;
                          foreach($valueTwo as $value){
                            if($value['start_time'] == $i['start_time']){
                              echo ($temp == 0) ? $value['youthName'] : "、".$value['youthName'];
                              $temp++;
                            }
                          }?></td>

                          <td><?php echo $i['duration'];?></td>
                          <td>
                            <a class="btn btn-info mx-2" href="<?php echo site_url('/course/course_attendance/' . $i['course'] . '/' . $i['start_time']);?>">查看/修改</a>                         
                          </td>
                        </tr>
                <?php } ?>
              
              </tbody>
            </table>

          <?php elseif($trend == "three"):?>
            <h4 class="text-dark"><?php echo '欄位: ' . $trendName; ?></h4>
        
            <h4 class="text-dark"><?php echo '總計: ' . ($sumOne) . '小時'; ?></h4>

          
            <table class="table table-hover text-center">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">流水號</th>
                  <th scope="col">參與學員</th>
                  <th scope="col">總時數</th>
                  <th scope="col">要項</th>
                </tr>
              </thead>
              <tbody>
                <?php $count = 1;foreach($valueOne as $i) { ?>
                  <tr>
                    <td><?php echo $count; $count++;?></td>
                    <td><?php echo $i['youthName'];?></td>
                    <td><?php echo $i['sum'];?></td>
                    <td>
                      <a class="btn btn-info mx-2" href="<?php echo site_url('work/get_work_attendance_table_by_member/' . $i['memberNo']. '/' . $yearType);?>">查看</a>   
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>


          <?php endif;?>
        <?php elseif($type == 'report_five' || $type == 'report_six' || $type == 'report_seven' || $type == 'report_eight' || $type == 'report_nine') :?>
          <h4 class="text-dark"><?php echo '欄位: ' . $trendName; ?></h4>
          <h4 class="text-dark"><?php echo '包含: ' . $trendInclude; ?></h4>
          <h4 class="text-dark"><?php echo '數量: ' . count($value); ?></h4>
          <table class="table table-hover text-center">
            <thead class="thead-dark">
              <tr>
                <th scope="col">流水號</th>
                <th scope="col">日期</th>
                <th scope="col">姓名</th>
                <th scope="col">是否開案</th>
                <th scope="col">動向</th>
                <th scope="col">備註</th>
                <th scope="col">要項</th>
              </tr>
            </thead>
            <tbody>
              <?php $count = 1;
                    foreach($value as $i) { ?>
                <tr>
                  <td><?php echo $count; $count++;?></td>
                  <td><?php echo date('Y-m-d',strtotime($i['date']));?></td>
                  <td><?php echo $i['youthName'];?></td>
                  <td><?php echo $i['is_counseling'] ? '是' : '否';?></td>
                  <td><?php foreach($trends as $j) {
                    if($i['trend'] == $j['no']) echo $j['content'];
                  }?></td>
                   <td><?php echo $i['trend_description'];?></td>
                  <td>
                    <a class="btn btn-info mx-2" href="<?php echo site_url('youth/seasonal_review/'.$i['youth'].'/'.$i['no']);?>">查看/修改</a>                         
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        
        <?php endif; ?>
         
      </div>
      
    </div>
  </div>
</div>
<?php $this->load->view('templates/new_footer');?>
