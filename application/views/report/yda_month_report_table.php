<?php $this->load->view('templates/header');?>
<div class="container" style="width:90%;">
  <div class="row">
    <div class="card col s12">
      <div class="row"> 
        <a class="btn col s2 offset-s0 waves-effect teal darken-2" style="margin:10px;" href="<?php echo site_url('/report/counseling_member_count_report_table/' . $yearType . '/' . $monthType); ?>">←每月執行進度表清單</a>
      </div>
      <h4 class="card-title text-center"><?php echo $title ?></h4>
      <div class="card-content">

        <?php if ($reportType == 'counselingMemberCountReport' || $reportType == 'all') {?>
        <h4>輔導人數統計表/執行進度表</h4>
        <table class="countyDelegateOrganization highlight" style="border:2px grey solid;">
          <thead class="thead-dark">
            <tr>
              <th scope="col" rowspan="2">縣市</th>
              <th scope="col" rowspan="2">提案內容</th>
              <th scope="col" rowspan="2">預計輔導</th>
              <th scope="col" rowspan="2">累積輔導</th>
              <th scope="col" colspan="5">具輔導成效</th>
              <th scope="col" rowspan="2">尚無規劃</th>
              <th scope="col" rowspan="2">不可抗力</th>
              <th scope="col" rowspan="2">辦理情形</th>
            </tr>
            <tr>
              <th scope="col">已就學</th>
              <th scope="col">已就業</th>
              <th scope="col">參加職訓</th>
              <th scope="col">其他</th>
              <th scope="col">小計</th>
            </tr>
          </thead>
          <tbody>
            <?php for ($i = 0; $i < count($counties); $i++) {?>
						<tr>
							<td><?php echo $counties[$i]['name']; ?></td>
							<td style="width: 20%;"><?php echo str_replace("\n", "<br/>", $projectDetailArray[$i]); ?></td>
              <td style="vertical-align:text-top;"><?php echo $projectArray[$i]->counseling_member; ?></td>
              <td style="vertical-align:text-top;"><?php echo $accumCounselingMemberCountArray[$i] ?></td>
              <td style="vertical-align:text-top;"><?php echo (empty($counselingMemberCountReportArray[$i])) ? "0" : $counselingMemberCountReportArray[$i]->school_member; ?></td>
              <td style="vertical-align:text-top;"><?php echo (empty($counselingMemberCountReportArray[$i])) ? "0" : $counselingMemberCountReportArray[$i]->work_member; ?></td>
							<td style="vertical-align:text-top;"><?php echo (empty($counselingMemberCountReportArray[$i])) ? "0" : $counselingMemberCountReportArray[$i]->vocational_training_member; ?></td>
							<td style="vertical-align:text-top;"><?php echo (empty($counselingMemberCountReportArray[$i])) ? "0" : $counselingMemberCountReportArray[$i]->other_member; ?></td>
							<td style="vertical-align:text-top;"><?php echo (empty($counselingMemberCountReportArray[$i])) ? "0" : $counselingMemberCountReportArray[$i]->school_member + $counselingMemberCountReportArray[$i]->work_member + $counselingMemberCountReportArray[$i]->vocational_training_member + $counselingMemberCountReportArray[$i]->other_member; ?></td>
							<td style="vertical-align:text-top;"><?php echo (empty($counselingMemberCountReportArray[$i])) ? "0" : $counselingMemberCountReportArray[$i]->no_plan_member; ?></td>
              <td style="vertical-align:text-top;"><?php echo (empty($counselingMemberCountReportArray[$i])) ? "0" : $counselingMemberCountReportArray[$i]->force_majeure_member; ?></td>
              <td><?php echo empty($executeDetailArray[$i]) ? "無資料" : str_replace("\n", "<br/>", $executeDetailArray[$i]); ?></td>
            </tr>
            <?php }?>
          </tbody>
        </table>
				<?php }?>

        <?php if ($reportType == 'counselingIdentityCountReport' || $reportType == 'all') {?>
        <h4>輔導對象身分別統計</h4>
        <table class="highlight centered" style="border:2px grey solid;">
          <thead class="thead-dark">
						<tr>
              <th scope="col" rowspan="2">類別</th>
							<th scope="col" rowspan="2" colspan="3">國中未畢業中輟<br/>A</th>
							<th scope="col" rowspan="2" colspan="3">中輟滿16歲未升學未就業<br/>B</th>
              <th scope="col" colspan="5">國中畢(結)業為就學未就業C</th>
							<th scope="col" rowspan="2" colspan="3">高中中離<br/>D</th>
							<th scope="col" rowspan="3">合計</th>
							<th scope="col" rowspan="3">A輔導人數占比</th>
            
            </tr>
            <tr>
              <th scope="col" colspan="2">應屆</th>
							<th scope="col" colspan="2">非應屆</th>
							<th scope="col" rowspan="2">小計</th>
            </tr>
            <tr>
              <th scope="col">縣市別</th>
							<th scope="col">男</th>
              <th scope="col">女</th>
              <th scope="col">小計</th>
              <th scope="col">男</th>
              <th scope="col">女</th>
              <th scope="col">小計</th>
              <th scope="col">男</th>
              <th scope="col">女</th>
              <th scope="col">男</th>
              <th scope="col">女</th>
              <th scope="col">男</th>
              <th scope="col">女</th>
              <th scope="col">小計</th>
            </tr>
          </thead>
          <tbody>	
            <?php 
              $countyArray = array("嘉義市", "澎湖縣", "連江縣", "金門縣");
              
              $commission_A_boy = $commission_A_girl = $commission_A_total = $commission_B_boy = $commission_B_girl = $commission_B_total = $commission_C1_boy = $commission_C1_girl = $commission_C2_boy = $commission_C2_girl = $commission_C_total = $commission_D_boy = $commission_D_girl = $commission_D_total = $commission_total =  0 ;
              $self_A_boy = $self_A_girl = $self_A_total = $self_B_boy = $self_B_girl = $self_B_total = $self_C1_boy = $self_C1_girl = $self_C2_boy = $self_C2_girl = $self_C_total = $self_D_boy = $self_D_girl = $self_D_total = $self_total = 0 ;
              for ($j = 0; $j < count($counties); $j++) {
              $total = 0;
              $aTotal = 0;
              
              ?>
						<tr>
              <td><?php echo $counties[$j]['name'];?></td>
              <td><?php $cnt = 0;
                    $count_boy = 0;
                    foreach ($get_all_inserted_identity_count_data as $i) {
                      if ($counties[$j]['name'] == $i['name']) {
                        $count_boy = $i['junior_under_graduate_boy'];
                        $cnt += 1;
                        if(in_array($counties[$j]['name'], $countyArray)){
                          $self_A_boy += $count_boy;
                        }else{
                          $commission_A_boy += $count_boy;
                        }
                      }
                    }
                    if ($cnt == 0) {
                      $count_boy = 0;
                      if(in_array($counties[$j]['name'], $countyArray)){
                        $self_A_boy += $count_boy;
                      }else{
                        $commission_A_boy += $count_boy;
                      }
                    }
                    print($count_boy);
                    ?></td>
              <td><?php $cnt = 0;
                    $count_girl = 0;
                    foreach ($get_all_inserted_identity_count_data as $i) {
                      if ($counties[$j]['name'] == $i['name']) {
                        $count_girl = $i['junior_under_graduate_girl'];
                        $cnt += 1;
                        if(in_array($counties[$j]['name'], $countyArray)){
                          $self_A_girl += $count_girl;
                        }else{
                          $commission_A_girl += $count_girl;
                        }
                      }
                    }
                    if ($cnt == 0) {
                      $count_girl = 0;
                      if(in_array($counties[$j]['name'], $countyArray)){
                        $self_A_girl += $count_girl;
                      }else{
                        $commission_A_girl += $count_girl;
                      }
                    }
                    print($count_girl);
                    ?></td>

               <td><?php echo $count_boy + $count_girl;
                    $total += $count_boy + $count_girl;
                    $aTotal = $count_boy + $count_girl;  
                    if(in_array($counties[$j]['name'], $countyArray)){
                      $self_A_total += $count_boy + $count_girl;
                      $self_total += $count_boy + $count_girl;
                    }else{
                      $commission_A_total += $count_boy + $count_girl;
                      $commission_total += $count_boy + $count_girl;
                    }?></td>

                <td><?php $cnt = 0;
                    $count_boy = 0;
                    foreach ($get_all_inserted_identity_count_data as $i) {
                      if ($counties[$j]['name'] == $i['name']) {
                        $count_boy = $i['sixteen_years_old_not_employed_not_studying_boy'];
                        $cnt += 1;

                        if(in_array($counties[$j]['name'], $countyArray)){
                          $self_B_boy += $count_boy;
                        }else{
                          $commission_B_boy += $count_boy;
                        }
                      }
                    }
                    if ($cnt == 0) {
                      $count_boy = 0;
                      if(in_array($counties[$j]['name'], $countyArray)){
                        $self_B_boy += $count_boy;
                      }else{
                        $commission_B_boy += $count_boy;
                      }
                    }
                    print($count_boy);
                    ?></td>
                <td><?php $cnt = 0;
                $count_girl = 0;
                    foreach ($get_all_inserted_identity_count_data as $i) {
                      if ($counties[$j]['name'] == $i['name']) {
                        $count_girl = $i['sixteen_years_old_not_employed_not_studying_girl'];
                        $cnt += 1;

                        if(in_array($counties[$j]['name'], $countyArray)){
                          $self_B_girl += $count_girl;
                        }else{
                          $commission_B_girl += $count_girl;
                        }
                      }
                    }
                    if ($cnt == 0) {
                      $count_girl = 0;
                      if(in_array($counties[$j]['name'], $countyArray)){
                        $self_B_girl += $count_girl;
                      }else{
                        $commission_B_girl += $count_girl;
                      }
                    }
                    print($count_girl);
                    ?></td>
                <td><?php echo $count_boy + $count_girl;
                    $total += $count_boy + $count_girl;
                    if(in_array($counties[$j]['name'], $countyArray)){
                      $self_B_total += $count_boy + $count_girl;
                      $self_total += $count_boy + $count_girl;
                    }else{
                      $commission_B_total += $count_boy + $count_girl;
                      $commission_total += $count_boy + $count_girl;
                    } ?></td>
                <td><?php $cnt = 0;
                $count_boy = 0;
                    foreach ($get_all_inserted_identity_count_data as $i) {
                      if ($counties[$j]['name'] == $i['name']) {
                        $count_boy = $i['junior_graduated_this_year_unemployed_not_studying_boy'];
                        $cnt += 1;

                        if(in_array($counties[$j]['name'], $countyArray)){
                          $self_C1_boy += $count_boy;
                        }else{
                          $commission_C1_boy += $count_boy;
                        }
                      }
                    }
                    if ($cnt == 0) {
                      $count_boy = 0;
                      if(in_array($counties[$j]['name'], $countyArray)){
                        $self_C1_boy += $count_boy;
                      }else{
                        $commission_C1_boy += $count_boy;
                      }
                    }
                    print($count_boy);
                    ?></td>
                <td><?php $cnt = 0;
                $count_girl = 0;
                    foreach ($get_all_inserted_identity_count_data as $i) {
                      if ($counties[$j]['name'] == $i['name']) {
                        $count_girl = $i['junior_graduated_this_year_unemployed_not_studying_girl'];
                        $cnt += 1;

                        if(in_array($counties[$j]['name'], $countyArray)){
                          $self_C1_girl += $count_girl;
                        }else{
                          $commission_C1_girl += $count_girl;
                        }
                      }
                    }
                    if ($cnt == 0) {
                      $count_girl = 0;
                      if(in_array($counties[$j]['name'], $countyArray)){
                        $self_C1_girl += $count_girl;
                      }else{
                        $commission_C1_girl += $count_girl;
                      }
                    }
                    print($count_girl);
                    $this_year = $count_boy + $count_girl; ?></td>

                <td><?php $cnt = 0;
                $count_boy = 0;
                    foreach ($get_all_inserted_identity_count_data as $i) {
                      if ($counties[$j]['name'] == $i['name']) {
                        $count_boy = $i['junior_graduated_not_this_year_unemployed_not_studying_boy'];
                        $cnt += 1;

                        if(in_array($counties[$j]['name'], $countyArray)){
                          $self_C2_boy += $count_boy;
                        }else{
                          $commission_C2_boy += $count_boy;
                        }
                      }
                    }
                    if ($cnt == 0) {
                      $count_boy = 0;
                      if(in_array($counties[$j]['name'], $countyArray)){
                        $self_C2_boy += $count_boy;
                      }else{
                        $commission_C2_boy += $count_boy;
                      }
                    }
                    print($count_boy);
                    ?></td>
                <td><?php $cnt = 0;
                $count_girl = 0;
                    foreach ($get_all_inserted_identity_count_data as $i) {
                      if ($counties[$j]['name'] == $i['name']) {
                        $count_girl = $i['junior_graduated_not_this_year_unemployed_not_studying_girl'];
                        $cnt += 1;
                        if(in_array($counties[$j]['name'], $countyArray)){
                          $self_C2_girl += $count_girl;
                        }else{
                          $commission_C2_girl += $count_girl;
                        }
                      }
                    }
                    if ($cnt == 0) {
                      $count_girl = 0;
                      if(in_array($counties[$j]['name'], $countyArray)){
                        $self_C2_girl += $count_girl;
                      }else{
                        $commission_C2_girl += $count_girl;
                      }
                    }
                    print($count_girl);

                    $not_this_year = $count_boy + $count_girl; ?></td>
                <td><?php echo $this_year + $not_this_year;
                    $total += $this_year + $not_this_year;
                    if(in_array($counties[$j]['name'], $countyArray)){
                      $self_C_total += $this_year + $not_this_year;
                      $self_total += $this_year + $not_this_year;
                    }else{
                      $commission_C_total += $this_year + $not_this_year;
                      $commission_total += $this_year + $not_this_year;
                    } ?></td>
                <td><?php $cnt = 0;
                $count_boy = 0;
                    foreach ($get_all_inserted_identity_count_data as $i) {
                      if ($counties[$j]['name'] == $i['name']) {
                        $count_boy = $i['drop_out_from_senior_boy'];
                        $cnt += 1;
                        if(in_array($counties[$j]['name'], $countyArray)){
                          $self_D_boy += $count_boy;
                        }else{
                          $commission_D_boy += $count_boy;
                        }
                      }
                    }
                    if ($cnt == 0) {
                      $count_boy = 0;
                      if(in_array($counties[$j]['name'], $countyArray)){
                        $self_D_boy += $count_boy;
                      }else{
                        $commission_D_boy += $count_boy;
                      }
                    }
                    print($count_boy);
                    ?></td>
                <td><?php $cnt = 0;
                $count_girl = 0;
                    foreach ($get_all_inserted_identity_count_data as $i) {
                      if ($counties[$j]['name'] == $i['name']) {
                        $count_girl = $i['drop_out_from_senior_girl'];
                        $cnt += 1;
                        if(in_array($counties[$j]['name'], $countyArray)){
                          $self_D_girl += $count_girl;
                        }else{
                          $commission_D_girl += $count_girl;
                        }
                      }
                    }
                    if ($cnt == 0) {
                      $count_girl = 0;
                      if(in_array($counties[$j]['name'], $countyArray)){
                        $self_D_girl += $count_girl;
                      }else{
                        $commission_D_girl += $count_girl;
                      }
                    }
                    print($count_girl);
                    ?></td>
                <td><?php echo $count_boy + $count_girl;
                    $total += $count_boy + $count_girl;
                    if(in_array($counties[$j]['name'], $countyArray)){
                      $self_D_total += $count_boy + $count_girl;
                      $self_total += $count_boy + $count_girl;
                    }else{
                      $commission_D_total += $count_boy + $count_girl;
                      $commission_total += $count_boy + $count_girl;
                    } ?></td>

                <td><?php echo $total ; ?></td>

                <td><?php $total = ($total == 0) ? 1 : $total;
                    print( (round($aTotal/$total,2) * 100) . "%" );
                    ?></td>
            </tr>
            <?php }?>
            <tr>
              <td>合計</td>
              <td><?php echo $commission_A_boy + $self_A_boy?></td>
              <td><?php echo $commission_A_girl + $self_A_girl?></td>
              <td><?php echo $commission_A_boy + $self_A_boy + $commission_A_girl + $self_A_girl?></td>
              <td><?php echo $commission_B_boy + $self_B_boy?></td>
              <td><?php echo $commission_B_girl + $self_B_girl?></td>
              <td><?php echo $commission_B_boy + $self_B_boy + $commission_B_girl + $self_B_girl?></td>
              <td><?php echo $commission_C1_boy + $self_C1_boy?></td>
              <td><?php echo $commission_C1_girl + $self_C1_girl?></td>
              <td><?php echo $commission_C2_boy + $self_C2_boy?></td>
              <td><?php echo $commission_C2_girl + $self_C2_girl?></td>
              <td><?php echo $commission_C1_boy + $self_C1_boy + $commission_C1_girl + $self_C1_girl + $commission_C2_boy + $self_C2_boy + $commission_C2_girl + $self_C2_girl?></td>
              <td><?php echo $commission_D_boy + $self_D_boy?></td>
              <td><?php echo $commission_D_girl + $self_D_girl?></td>
              <td><?php echo $commission_D_boy + $self_D_boy + $commission_D_girl + $self_D_girl?></td>
              <td><?php echo $commission_A_boy + $self_A_boy + $commission_A_girl + $self_A_girl + $commission_B_boy + $self_B_boy + $commission_B_girl + $self_B_girl + $commission_C1_boy + $self_C1_boy + $commission_C1_girl + $self_C1_girl + $commission_C2_boy + $self_C2_boy + $commission_C2_girl + $self_C2_girl + $commission_D_boy + $self_D_boy + $commission_D_girl + $self_D_girl?></td>
              <?php 
                $tempTotal = $commission_A_boy + $self_A_boy + $commission_A_girl + $self_A_girl + $commission_B_boy + $self_B_boy + $commission_B_girl + $self_B_girl + $commission_C1_boy + $self_C1_boy + $commission_C1_girl + $self_C1_girl + $commission_C2_boy + $self_C2_boy + $commission_C2_girl + $self_C2_girl + $commission_D_boy + $self_D_boy + $commission_D_girl + $self_D_girl;
                $tempTotal = ($tempTotal == 0) ? 1 : $tempTotal;
              ?>
              <td><?php echo round( ($commission_A_boy + $self_A_boy + $commission_A_girl + $self_A_girl) / $tempTotal, 2) *100 ?>%</td>
             
            </tr>
            <tr>
              <td>委辦</td>
              <td><?php echo $commission_A_boy?></td>
              <td><?php echo $commission_A_girl?></td>
              <td><?php echo $commission_A_boy + $commission_A_girl?></td>
              <td><?php echo $commission_B_boy?></td>
              <td><?php echo $commission_B_girl?></td>
              <td><?php echo $commission_B_boy + $commission_B_girl?></td>
              <td><?php echo $commission_C1_boy?></td>
              <td><?php echo $commission_C1_girl?></td>
              <td><?php echo $commission_C2_boy?></td>
              <td><?php echo $commission_C2_girl?></td>
              <td><?php echo $commission_C1_boy + $commission_C1_girl + $commission_C2_boy + $commission_C2_girl?></td>
              <td><?php echo $commission_D_boy?></td>
              <td><?php echo $commission_D_girl?></td>
              <td><?php echo $commission_D_boy + $commission_D_girl?></td>
              <td><?php echo $commission_A_boy + $commission_A_girl + $commission_B_boy + $commission_B_girl + $commission_C1_boy + $commission_C1_girl + $commission_C2_boy + $commission_C2_girl + $commission_D_boy + $commission_D_girl?></td>
              <?php 
                $tempTotal = $commission_A_boy + $commission_A_girl + $commission_B_boy + $commission_B_girl + $commission_C1_boy + $commission_C1_girl + $commission_C2_boy + $commission_C2_girl + $commission_D_boy + $commission_D_girl;
                $tempTotal = ($tempTotal == 0) ? 1 : $tempTotal;
              ?>
              <td><?php echo round( ($commission_A_boy + $commission_A_girl) / $tempTotal, 2) *100 ?>%</td>
            </tr>
            <tr>
              <td>自辦</td>
              <td><?php echo $self_A_boy?></td>
              <td><?php echo $self_A_girl?></td>
              <td><?php echo $self_A_boy + $self_A_girl?></td>
              <td><?php echo $self_B_boy?></td>
              <td><?php echo $self_B_girl?></td>
              <td><?php echo $self_B_boy + $self_B_girl?></td>
              <td><?php echo $self_C1_boy?></td>
              <td><?php echo $self_C1_girl?></td>
              <td><?php echo $self_C2_boy?></td>
              <td><?php echo $self_C2_girl?></td>
              <td><?php echo $self_C1_boy + $self_C1_girl + $self_C2_boy + $self_C2_girl?></td>
              <td><?php echo $self_D_boy?></td>
              <td><?php echo $self_D_girl?></td>
              <td><?php echo $self_D_boy + $self_D_girl?></td>
              <td><?php echo $self_A_boy + $self_A_girl + $self_B_boy + $self_B_girl + $self_C1_boy + $self_C1_girl + $self_C2_boy + $self_C2_girl + $self_D_boy + $self_D_girl?></td>
              <?php 
                $tempTotal = $self_A_boy + $self_A_girl + $self_B_boy + $self_B_girl + $self_C1_boy + $self_C1_girl + $self_C2_boy + $self_C2_girl + $self_D_boy + $self_D_girl;
                $tempTotal = ($tempTotal == 0) ? 1 : $tempTotal;
              ?>
              <td><?php echo round( ($self_A_boy + $self_A_girl) / $tempTotal, 2) *100 ?>%</td>
            </tr>
            <tr>
              <?php $commission_total = ($commission_total == 0) ? 1 : $commission_total;?>
              <td>百分比</td>
              <td><?php echo round(($commission_A_boy + $self_A_boy)/($commission_total + $self_total), 2) * 100 ?>%</td>
              <td><?php echo round(($commission_A_girl + $self_A_girl)/($commission_total + $self_total), 2) * 100 ?>%</td>
              <td><?php echo round(($commission_A_boy + $self_A_boy + $commission_A_girl + $self_A_girl)/($commission_total + $self_total), 2) * 100 ?>%</td>
              <td><?php echo round(($commission_B_boy + $self_B_boy)/($commission_total + $self_total), 2) * 100 ?>%</td>
              <td><?php echo round(($commission_B_girl + $self_B_girl)/($commission_total + $self_total), 2) * 100 ?>%</td>
              <td><?php echo round(($commission_B_boy + $self_B_boy + $commission_B_girl + $self_B_girl)/($commission_total + $self_total), 2) * 100 ?>%</td>
              <td><?php echo round(($commission_C1_boy + $self_C1_boy)/($commission_total + $self_total), 2) * 100 ?>%</td>
              <td><?php echo round(($commission_C1_girl + $self_C1_girl)/($commission_total + $self_total), 2) * 100 ?>%</td>
              <td><?php echo round(($commission_C2_boy + $self_C2_boy)/($commission_total + $self_total), 2) * 100 ?>%</td>
              <td><?php echo round(($commission_C2_girl + $self_C2_girl)/($commission_total + $self_total), 2) * 100 ?>%</td>
              <td><?php echo round(($commission_C1_boy + $self_C1_boy + $commission_C1_girl + $self_C1_girl + $commission_C2_boy + $self_C2_boy + $commission_C2_girl + $self_C2_girl)/($commission_total + $self_total), 2) * 100 ?>%</td>
              <td><?php echo round(($commission_D_boy + $self_D_boy)/($commission_total + $self_total), 2) * 100 ?>%</td>
              <td><?php echo round(($commission_D_girl + $self_D_girl)/($commission_total + $self_total), 2) * 100 ?>%</td>
              <td><?php echo round(($commission_D_boy + $self_D_boy + $commission_D_girl + $self_D_girl)/($commission_total + $self_total), 2) * 100 ?>%</td>
              <td>100%</td>
              <td></td>
            </tr>
          </tbody>
        </table>
				<?php }?>

        <?php if ($reportType == 'counselingMeetingCountReport' || $reportType == 'all') {?>
        <h4>跨局處會議/預防性講座場次/人次統計</h4>
        <table class="highlight centered" style="border:2px grey solid;">
          <thead class="thead-dark">
            <tr>
              <th scope="col">縣市</th>
              <th scope="col">預計辦理跨局處會議場次</th>
              <th scope="col">目前辦理跨局處會議時間</th>
              <th scope="col">預計辦理活動或講座場次</th>
              <th scope="col" style="width: 10%;">目前辦理活動或講座場次</th>
              <th scope="col" style="width: 10%;">預計活動或講座參與人次</th>
              <th scope="col">目前活動或講座參與人次</th>
              <th scope="col" style="width: 30%;">備註</th>
            
            </tr>
            
          </thead>
          <tbody>	
          <?php for ($j = 0; $j < count($counties); $j++) { ?>
            <tr>    
              <td><?php echo $counties[$j]['name'];?></td>
							<td><?php $cnt = 0;
                    foreach ($projectArray as $i) {
                      if ($counties[$j]['name'] == $i->countyName) {
                        $count_boy = $i->meeting_count;
                        $cnt += 1;
                      }
                    }
                    if ($cnt == 0) {
                      $count_boy = 0;
                    }
                    print($count_boy);?></td>
              <td><?php $cnt = 0;
                    foreach ($get_all_inserted_meeting_count_data as $i) {
                      if ($counties[$j]['name'] == $i['name']) {
                        $count_girl = str_replace("\n", "<br/>", $i['time_note']);
                        $cnt += 1;
                      }
                    }
                    if ($cnt == 0) {
                      $count_girl = "無資料";
                    }
                    print($count_girl); ?></td>
              <td><?php $cnt = 0;
                    foreach ($get_all_inserted_meeting_count_data as $i) {
                      if ($counties[$j]['name'] == $i['name']) {
                        $count_boy = $i['planning_holding_meeting_count'];
                        $cnt += 1;
                      }
                    }
                    if ($cnt == 0) {
                      $count_boy = 0;
                    }
                    print($count_boy);
                    ?></td>

                <td><?php $cnt = 0;
                    foreach ($get_all_inserted_meeting_count_data as $i) {
                        if ($counties[$j]['name'] == $i['name']) {
                            $count_boy = $i['actual_holding_meeting_count'];
                            $cnt += 1;
                        }
                    }
                    if ($cnt == 0) {
                        $count_boy = 0;
                    }
                    print($count_boy);?></td>

                <td><?php $cnt = 0;
                    foreach ($get_all_inserted_meeting_count_data as $i) {
                        if ($counties[$j]['name'] == $i['name']) {
                            $count_boy = $i['planning_involved_people'];
                            $cnt += 1;
                        }
                    }
                    if ($cnt == 0) {
                        $count_boy = 0;
                    }
                    print($count_boy);?></td>

                  <td><?php $cnt = 0;
                    foreach ($get_all_inserted_meeting_count_data as $i) {
                        if ($counties[$j]['name'] == $i['name']) {
                            $count_boy = $i['actual_involved_people'];
                            $cnt += 1;
                        }
                    }
                    if ($cnt == 0) {
                        $count_boy = 0;
                    }
                    print($count_boy);?></td>

                <td style="text-align:left"><?php $cnt = 0;
                    foreach ($get_all_inserted_meeting_count_data as $i) {
                        if ($counties[$j]['name'] == $i['name']) {
                            $count_boy = str_replace("\r\n", "<br/>", $i['meeting_count_note']);
                            $cnt += 1;
                        }
                    }
                    if ($cnt == 0) {
                        $count_boy = "無資料";
                    }
                    print($count_boy);?></td>
            </tr>
            <?php } ?>
            <tr>
              <td>總計</td>
              <td><?php echo $sumDetail['meetingCountSum']?></td>
              <td></td>
              <td><?php echo $sumDetail['planningHoldingSum']?></td>
              <td><?php echo $sumDetail['actualHoldingSum']?></td>
              <td><?php echo $sumDetail['planningInvolvedSum']?></td>
              <td><?php echo $sumDetail['actualInvolvedSum']?></td>
              <td></td>
           
            </tr>

            <tr>
              <td>委辦</td>
              <td><?php echo $sumDetail['commission_meeting_count']?></td>
              <td></td>
              <td><?php echo $sumDetail['commission_planning_holding_meeting_count']?></td>
              <td><?php echo $sumDetail['commission_actual_holding_meeting_count']?></td>
              <td><?php echo $sumDetail['commission_planning_involved_people']?></td>
              <td><?php echo $sumDetail['commission_actual_involved_people']?></td>
              <td></td>
            </tr>

            <tr>
              <td>自辦</td>
              <td><?php echo $sumDetail['self_meeting_count']?></td>
              <td></td>
              <td><?php echo $sumDetail['self_planning_holding_meeting_count']?></td>
              <td><?php echo $sumDetail['self_actual_holding_meeting_count']?></td>
              <td><?php echo $sumDetail['self_planning_involved_people']?></td>
              <td><?php echo $sumDetail['self_actual_involved_people']?></td>
              <td></td>
           
            </tr>
            
            </tbody>
          </table>
				<?php }?>

        <?php if ($reportType == 'counselingManpowerReport' || $reportType == 'all') {?>
        <h4>輔導人力概況表</h4>
        <table class="highlight centered" style="border:2px grey solid;">
          <thead class="thead-dark">
          `<tr>
              <th scope="col" rowspan="2">縣市</th>
              <th scope="col" colspan="2">雙青專任輔導人員</th>
              <th scope="col" colspan="4">輔導人員隸屬</th>
              <th scope="col" colspan="2">學歷</th>
              <th scope="col" colspan="6">證照</th>
              <th scope="col" rowspan="2" style="width:30%;">備註</th>
            </tr>
            <tr>
              <th scope="col">預估輔導人員</th>
              <th scope="col">實際輔導人員</th>
              <th scope="col">教育局(處)</th>
              <th scope="col">輔諮中心</th>
              <th scope="col">學校</th></th>
              <th scope="col">委外單位</th>
              <th scope="col">學士</th>
              <th scope="col">碩士</th>
              <th scope="col">相關科系畢業者</th>
              <th scope="col" >具備考選部公告社會工作師或心理師應考資格者</th>
              <th scope="col">具社會工作師證照</th>
              <th scope="col">具心理師證照</th>
              <th scope="col">具就業服務乙級技術士證照</th>
              <th scope="col">具政府機關核發之就業服務專業人員證書</th>
            </tr>
          </thead>
            <?php
            $total = 0;
         for ($j = 0; $j < count($counties); $j++) {?>
            <tbody>

              <tr>
            
              <td><?php
                    echo $counties[$j]['name']; ?></td>
                <td><?php $cnt = 50;
                    foreach ($counselorManpowerReports as $i) {

                      if ($counties[$j]['name'] == $i['name']) {
                        echo $i['project_counselor'];
                        $cnt = $i['project_counselor'];
                      }
                    }
                    if ($cnt == 50) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 50;
                    foreach ($counselorManpowerReports as $i) {
                      if ($counties[$j]['name'] == $i['name']) {
                        echo $i['really_counselor'];
                        $cnt = $i['really_counselor'];
                      }
                    }
                    if ($cnt == 50) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 50;
                    foreach ($counselorManpowerReports as $i) {
                      if ($counties[$j]['name'] == $i['name']) {
                        echo $i['education_counselor'];
                        $cnt = $i['education_counselor'];
                      }
                    }
                    if ($cnt == 50) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 0;
                    foreach ($counselorManpowerReports as $i) {
                      if ($counties[$j]['name'] == $i['name']) {
                        echo $i['counseling_center_counselor'];
                        $cnt = $i['counseling_center_counselor'];
                      }
                    }
                    if ($cnt == 50) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 50;
                    foreach ($counselorManpowerReports as $i) {
                      if ($counties[$j]['name'] == $i['name']) {
                        echo $i['school_counselor'];
                        $cnt = $i['school_counselor'];
                      }
                    }
                    if ($cnt == 50) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 50;
                    foreach ($counselorManpowerReports as $i) {
                      if ($counties[$j]['name'] == $i['name']) {
                        echo $i['outsourcing_counselor'];
                        $cnt = $i['outsourcing_counselor'];
                      }
                    }
                    if ($cnt == 50) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 50;
                    foreach ($counselorManpowerReports as $i) {
                      if ($counties[$j]['name'] == $i['name']) {
                        echo $i['bachelor_degree'];
                        $cnt = $i['bachelor_degree'];
                      }
                    }
                    if ($cnt == 50) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 50;
                    foreach ($counselorManpowerReports as $i) {
                      if ($counties[$j]['name'] == $i['name']) {
                        echo $i['master_degree'];
                        $cnt = $i['master_degree'];
                      }
                    }
                    if ($cnt == 50) {
                      echo "0";
                    }
                    $total += $cnt;  ?></td>
                <td><?php $cnt = 50;
                    foreach ($counselorManpowerReports as $i) {
                      if ($counties[$j]['name'] == $i['name']) {
                        echo $i['qualification_one'];
                        $cnt = $i['qualification_one'];
                      }
                    }
                    if ($cnt == 50) {
                      echo "0";
                    }
                    $total += $cnt;  ?></td>
                <td><?php $cnt = 50;
                    foreach ($counselorManpowerReports as $i) {
                      if ($counties[$j]['name'] == $i['name']) {
                        echo $i['qualification_two'];
                        $cnt = $i['qualification_two'];
                      }
                    }
                    if ($cnt == 50) {
                      echo "0";
                    }
                    $total += $cnt;  ?></td>
                <td><?php $cnt = 50;
                    foreach ($counselorManpowerReports as $i) {
                      if ($counties[$j]['name'] == $i['name']) {
                        echo $i['qualification_three'];
                        $cnt = $i['qualification_three'];
                      }
                    }
                    if ($cnt == 50) {
                      echo "0";
                    }
                    $total += $cnt;  ?></td>
                <td><?php $cnt = 50;
                    foreach ($counselorManpowerReports as $i) {
                      if ($counties[$j]['name'] == $i['name']) {
                        echo $i['qualification_four'];
                        $cnt = $i['qualification_four'];
                      }
                    }
                    if ($cnt == 50) {
                      echo "0";
                    }
                    $total += $cnt;  ?></td>
                <td><?php $cnt = 50;
                    foreach ($counselorManpowerReports as $i) {
                      if ($counties[$j]['name'] == $i['name']) {
                        echo $i['qualification_five'];
                        $cnt = $i['qualification_five'];
                      }
                    }
                    if ($cnt == 50) {
                      echo "0";
                    }
                    $total += $cnt;  ?></td>
                <td><?php $cnt = 50;
                    foreach ($counselorManpowerReports as $i) {
                      if ($counties[$j]['name'] == $i['name']) {
                        echo $i['qualification_six'];
                        $cnt = $i['qualification_six'];
                      }
                    }
                    if ($cnt == 50) {
                      echo "0";
                    }
                    $total += $cnt;  ?></td>
                <td style="text-align:left"><?php $cnt = 50;
                    foreach ($counselorManpowerReports as $i) {
                      if ($counties[$j]['name'] == $i['name']) {
                        echo str_replace("\n", "<br/>", $i['note']);

                        $cnt++;
                      }
                    }
                    if ($cnt == 50) {
                      echo "無資料";
                    }
                    ?></td>
                    
              </tr>
            </tbody>
            <?php } ?>
            <tr>
              <td>總計</td>
              <td><?php echo $sumDetail['projectCounselorSum']?></td>
              <td><?php echo $sumDetail['reallyCounselorSum']?></td>
              <td><?php echo $sumDetail['educationCounselorSum']?></td>
              <td><?php echo $sumDetail['counselingCenterCounselorSum']?></td>
              <td><?php echo $sumDetail['schoolCounselorSum']?></td>
              <td><?php echo $sumDetail['outsourcingCounselorSum']?></td>
              <td><?php echo $sumDetail['bachelorDegreeSum']?></td>
              <td><?php echo $sumDetail['masterDegreeSum']?></td>
              <td><?php echo $sumDetail['qualificationOneSum']?></td>
              <td><?php echo $sumDetail['qualificationTwoSum']?></td>
              <td><?php echo $sumDetail['qualificationThreeSum']?></td>
              <td><?php echo $sumDetail['qualificationFourSum']?></td>
              <td><?php echo $sumDetail['qualificationFiveSum']?></td>
              <td><?php echo $sumDetail['qualificationSixSum']?></td>
              <td></td>
            </tr>      
          </table>
				<?php }?>

        <?php if ($reportType == 'twoYearsTrendSurveyCountReport' || $reportType == 'all') {?>
        <h4><?php echo $yearType -4?>學年度動向調查追蹤</h4>
        <table class="highlight centered" style="border:2px grey solid;">
            <thead class="thead-dark">
              <tr>
                <th scope="col">縣市</th>
                <th scope="col">1.已就業</th>
                <th scope="col">2.已就學</th>
                <th scope="col">3.特教生</th>
                <th scope="col">4.準備升學</th>
                <th scope="col">5.準備或正在找工作</th>
                <th scope="col">6.參加職訓</th>
                <th scope="col">7.家務勞動</th>
                <th scope="col">8.健康因素</th>
                <th scope="col">9.尚未規劃</th>
                <th scope="col">10.失聯</th>
                <th scope="col">11.其他(非不可抗力)</th>
                <th scope="col">12.其他(不可抗力)</th>
                <th scope="col">進入本計畫輔導</th>
                <th scope="col">A.動向調查學生數</th>
                <th scope="col">B.未升學未就業人數(4-12)</th>
                <th scope="col">C.需政府關懷追蹤後，適時介入輔導人數(4-11)</th>
                <th scope="col" style="width:30%;">備註</th>
              
              </tr>
            </thead>
            <tbody>
            <?php
            $total = 0;
            for ($j = 0; $j < count($counties); $j++) { ?>
              <tr>
             
                <td><?php echo $counties[$j]['name'];?></td>
                <td><?php $cnt = 5000;
                    foreach ($twoYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['already_working'] : null;
                        $cnt = $i['already_working'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($twoYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['already_attending_school'] : null;
                        $cnt = $i['already_attending_school'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($twoYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['special_education_student'] : null;
                        $cnt = $i['special_education_student'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($twoYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['prepare_to_school'] : null;
                        $cnt = $i['prepare_to_school'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($twoYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['prepare_to_work'] : null;
                        $cnt = $i['prepare_to_work'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($twoYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['training'] : null;
                        $cnt = $i['training'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($twoYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['family_labor'] : null;
                        $cnt = $i['family_labor'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($twoYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['health'] : null;
                        $cnt = $i['health'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($twoYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['no_plan'] : null;
                        $cnt = $i['no_plan'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($twoYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['lost_contact'] : null;
                        $cnt = $i['lost_contact'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>

                <td><?php $cnt = 5000;
                    foreach ($twoYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['transfer_labor'] + $i['transfer_other'] + $i['pregnancy'] + $i['other'] : null;
                        $cnt = $i['transfer_labor'] + $i['transfer_other'] + $i['pregnancy'] + $i['other'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($twoYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['immigration'] + $i['death'] + $i['military'] : null;
                        $cnt = $i['immigration'] + $i['death'] + $i['military'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($twoYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['in_case'] : null;
                        $cnt = $i['in_case'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($twoYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['youthCount'] : null;
                        $cnt = $i['youthCount'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($twoYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['prepare_to_school'] + $i['prepare_to_work'] + $i['training'] + $i['family_labor']
                          + $i['health'] + $i['no_plan'] + $i['lost_contact'] + $i['transfer_labor'] + $i['transfer_other'] + $i['pregnancy']
                          + $i['other'] + $i['immigration'] + $i['death'] + $i['military'] : null;
                        $cnt = $i['prepare_to_school'] + $i['prepare_to_work'] + $i['training'] + $i['family_labor']
                          + $i['health'] + $i['no_plan'] + $i['lost_contact'] + $i['transfer_labor'] + $i['transfer_other'] + $i['pregnancy']
                          + $i['other'] + $i['immigration'] + $i['death'] + $i['military'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($twoYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['prepare_to_school'] + $i['prepare_to_work'] + $i['training'] + $i['family_labor']
                          + $i['health'] + $i['no_plan'] + $i['lost_contact'] + $i['transfer_labor'] + $i['transfer_other'] + $i['pregnancy']
                          + $i['other'] + $i['immigration'] + $i['death'] + $i['military'] : null;
                        $cnt = $i['prepare_to_school'] + $i['prepare_to_work'] + $i['training'] + $i['family_labor']
                          + $i['health'] + $i['no_plan'] + $i['lost_contact'] + $i['transfer_labor'] + $i['transfer_other'] + $i['pregnancy']
                          + $i['other'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                  <td style="text-align:left"><?php $cnt = "";
                    foreach ($twoYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? str_replace("\n", "<br/>", $i['note']) : null;
                        $cnt = $i['note'];
                      }
                    }
                    if ($cnt == "") {
                      echo "無資料";
                    }
                     ?></td>
                     
              </tr>
              <?php } ?>
              <tr>
                <td>總計</td>
                <td><?php echo $sumDetail['alreadyWorkingSum'];?></td>
                <td><?php echo $sumDetail['alreadyAttendingSchoolSum'];?></td>
                <td><?php echo $sumDetail['specialEducationStudentSum'];?></td>
                <td><?php echo $sumDetail['prepareToSchoolSum'];?></td>
                <td><?php echo $sumDetail['prepareToWorkSum'];?></td>
                <td><?php echo $sumDetail['trainingSum'];?></td>
                <td><?php echo $sumDetail['familyLaborSum'];?></td>
                <td><?php echo $sumDetail['healthSum'];?></td>
                <td><?php echo $sumDetail['noPlanSum'];?></td>
                <td><?php echo $sumDetail['lostContactSum'];?></td>
                <td><?php echo $sumDetail['transferLaborSum'] + $sumDetail['transferOtherSum'] + $sumDetail['pregnancySum'] + $sumDetail['otherSum'];?></td>
                <td><?php echo $sumDetail['immigrationSum'] + $sumDetail['deathSum'] + $sumDetail['militarySum'];?></td>
                <td><?php echo $sumDetail['inCaseSum']; ?></td>
                <td><?php echo $sumDetail['youthCountSum']; ?></td>
                <td><?php echo $sumDetail['alreadyWorkingSum'] + $sumDetail['alreadyAttendingSchoolSum'] + $sumDetail['specialEducationStudentSum'] + $sumDetail['prepareToSchoolSum'] + $sumDetail['prepareToWorkSum'] 
                     + $sumDetail['trainingSum'] + $sumDetail['familyLaborSum'] + $sumDetail['healthSum'] + $sumDetail['noPlanSum'] + $sumDetail['lostContactSum'] + $sumDetail['transferLaborSum'] 
                     + $sumDetail['transferOtherSum'] + $sumDetail['pregnancySum'] + $sumDetail['otherSum'] + $sumDetail['immigrationSum'] + $sumDetail['deathSum'] + $sumDetail['militarySum'];?></td>
                <td><?php echo $sumDetail['alreadyWorkingSum'] + $sumDetail['alreadyAttendingSchoolSum'] + $sumDetail['specialEducationStudentSum'] + $sumDetail['prepareToSchoolSum'] + $sumDetail['prepareToWorkSum'] 
                     + $sumDetail['trainingSum'] + $sumDetail['familyLaborSum'] + $sumDetail['healthSum'] + $sumDetail['noPlanSum'] + $sumDetail['lostContactSum'] + $sumDetail['transferLaborSum'] 
                     + $sumDetail['transferOtherSum'] + $sumDetail['pregnancySum'] + $sumDetail['otherSum'];?></td>
                <td></td>
              
            </tr>
            </tbody>
          </table>
				<?php }?>

        <?php if ($reportType == 'oneYearsTrendSurveyCountReport' || $reportType == 'all') {?>
        <h4><?php echo $yearType -3?>學年度動向調查追蹤</h4>
        <table class="highlight centered" style="border:2px grey solid;">
            <thead class="thead-dark">
              <tr>
                <th scope="col">縣市</th>
                <th scope="col">1.已就業</th>
                <th scope="col">2.已就學</th>
                <th scope="col">3.特教生</th>
                <th scope="col">4.準備升學</th>
                <th scope="col">5.準備或正在找工作</th>
                <th scope="col">6.參加職訓</th>
                <th scope="col">7.家務勞動</th>
                <th scope="col">8.健康因素</th>
                <th scope="col">9.尚未規劃</th>
                <th scope="col">10.失聯</th>
                <th scope="col">11.其他(非不可抗力)</th>
                <th scope="col">12.其他(不可抗力)</th>
                <th scope="col">進入本計畫輔導</th>
                <th scope="col">A.動向調查學生數</th>
                <th scope="col">B.未升學未就業人數(4-12)</th>
                <th scope="col">C.需政府關懷追蹤後，適時介入輔導人數(4-11)</th>
                <th scope="col" style="width:30%;">備註</th>
              
              </tr>
            </thead>
            <tbody>
            <?php
            $total = 0;
            for ($j = 0; $j < count($counties); $j++) { ?>
              <tr>
             
                <td><?php echo $counties[$j]['name'];?></td>
                <td><?php $cnt = 5000;
                    foreach ($oneYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['already_working'] : null;
                        $cnt = $i['already_working'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($oneYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['already_attending_school'] : null;
                        $cnt = $i['already_attending_school'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($oneYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['special_education_student'] : null;
                        $cnt = $i['special_education_student'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($oneYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['prepare_to_school'] : null;
                        $cnt = $i['prepare_to_school'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($oneYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['prepare_to_work'] : null;
                        $cnt = $i['prepare_to_work'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($oneYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['training'] : null;
                        $cnt = $i['training'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($oneYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['family_labor'] : null;
                        $cnt = $i['family_labor'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($oneYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['health'] : null;
                        $cnt = $i['health'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($oneYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['no_plan'] : null;
                        $cnt = $i['no_plan'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($oneYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['lost_contact'] : null;
                        $cnt = $i['lost_contact'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>

                <td><?php $cnt = 5000;
                    foreach ($oneYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['transfer_labor'] + $i['transfer_other'] + $i['pregnancy'] + $i['other'] : null;
                        $cnt = $i['transfer_labor'] + $i['transfer_other'] + $i['pregnancy'] + $i['other'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($oneYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['immigration'] + $i['death'] + $i['military'] : null;
                        $cnt = $i['immigration'] + $i['death'] + $i['military'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($oneYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['in_case'] : null;
                        $cnt = $i['in_case'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($oneYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['youthCount'] : null;
                        $cnt = $i['youthCount'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($oneYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['prepare_to_school'] + $i['prepare_to_work'] + $i['training'] + $i['family_labor']
                          + $i['health'] + $i['no_plan'] + $i['lost_contact'] + $i['transfer_labor'] + $i['transfer_other'] + $i['pregnancy']
                          + $i['other'] + $i['immigration'] + $i['death'] + $i['military'] : null;
                        $cnt = $i['prepare_to_school'] + $i['prepare_to_work'] + $i['training'] + $i['family_labor']
                          + $i['health'] + $i['no_plan'] + $i['lost_contact'] + $i['transfer_labor'] + $i['transfer_other'] + $i['pregnancy']
                          + $i['other'] + $i['immigration'] + $i['death'] + $i['military'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($oneYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['prepare_to_school'] + $i['prepare_to_work'] + $i['training'] + $i['family_labor']
                          + $i['health'] + $i['no_plan'] + $i['lost_contact'] + $i['transfer_labor'] + $i['transfer_other'] + $i['pregnancy']
                          + $i['other'] + $i['immigration'] + $i['death'] + $i['military'] : null;
                        $cnt = $i['prepare_to_school'] + $i['prepare_to_work'] + $i['training'] + $i['family_labor']
                          + $i['health'] + $i['no_plan'] + $i['lost_contact'] + $i['transfer_labor'] + $i['transfer_other'] + $i['pregnancy']
                          + $i['other'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                  <td style="text-align:left"><?php $cnt = "";
                    foreach ($oneYearsTrendSurveyCountReports as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? str_replace("\n", "<br/>", $i['note']) : null;
                        $cnt = $i['note'];
                      }
                    }
                    if ($cnt == "") {
                      echo "無資料";
                    }
                     ?></td>
                     
              </tr>
              <?php } ?>
              <tr>
                <td>總計</td>
                <td><?php echo $sumDetail['alreadyWorkingSum'];?></td>
                <td><?php echo $sumDetail['alreadyAttendingSchoolSum'];?></td>
                <td><?php echo $sumDetail['specialEducationStudentSum'];?></td>
                <td><?php echo $sumDetail['prepareToSchoolSum'];?></td>
                <td><?php echo $sumDetail['prepareToWorkSum'];?></td>
                <td><?php echo $sumDetail['trainingSum'];?></td>
                <td><?php echo $sumDetail['familyLaborSum'];?></td>
                <td><?php echo $sumDetail['healthSum'];?></td>
                <td><?php echo $sumDetail['noPlanSum'];?></td>
                <td><?php echo $sumDetail['lostContactSum'];?></td>
                <td><?php echo $sumDetail['transferLaborSum'] + $sumDetail['transferOtherSum'] + $sumDetail['pregnancySum'] + $sumDetail['otherSum'];?></td>
                <td><?php echo $sumDetail['immigrationSum'] + $sumDetail['deathSum'] + $sumDetail['militarySum'];?></td>
                <td><?php echo $sumDetail['inCaseSum']; ?></td>
                <td><?php echo $sumDetail['youthCountSum']; ?></td>
                <td><?php echo $sumDetail['alreadyWorkingSum'] + $sumDetail['alreadyAttendingSchoolSum'] + $sumDetail['specialEducationStudentSum'] + $sumDetail['prepareToSchoolSum'] + $sumDetail['prepareToWorkSum'] 
                     + $sumDetail['trainingSum'] + $sumDetail['familyLaborSum'] + $sumDetail['healthSum'] + $sumDetail['noPlanSum'] + $sumDetail['lostContactSum'] + $sumDetail['transferLaborSum'] 
                     + $sumDetail['transferOtherSum'] + $sumDetail['pregnancySum'] + $sumDetail['otherSum'] + $sumDetail['immigrationSum'] + $sumDetail['deathSum'] + $sumDetail['militarySum'];?></td>
                <td><?php echo $sumDetail['alreadyWorkingSum'] + $sumDetail['alreadyAttendingSchoolSum'] + $sumDetail['specialEducationStudentSum'] + $sumDetail['prepareToSchoolSum'] + $sumDetail['prepareToWorkSum'] 
                     + $sumDetail['trainingSum'] + $sumDetail['familyLaborSum'] + $sumDetail['healthSum'] + $sumDetail['noPlanSum'] + $sumDetail['lostContactSum'] + $sumDetail['transferLaborSum'] 
                     + $sumDetail['transferOtherSum'] + $sumDetail['pregnancySum'] + $sumDetail['otherSum'];?></td>
                <td></td>
              
            </tr>
            </tbody>
          </table>
				<?php }?>

        <?php if ($reportType == 'nowYearsTrendSurveyCountReport' || $reportType == 'all') {?>
        <h4><?php echo $yearType -2?>學年度動向調查追蹤</h4>
        <table class="highlight centered" style="border:2px grey solid;">
            <thead class="thead-dark">
              <tr>
                <th scope="col">縣市</th>
                <th scope="col">1.已就業</th>
                <th scope="col">2.已就學</th>
                <th scope="col">3.特教生</th>
                <th scope="col">4.準備升學</th>
                <th scope="col">5.準備或正在找工作</th>
                <th scope="col">6.參加職訓</th>
                <th scope="col">7.家務勞動</th>
                <th scope="col">8.健康因素</th>
                <th scope="col">9.尚未規劃</th>
                <th scope="col">10.失聯</th>
                <th scope="col">11.其他(非不可抗力)</th>
                <th scope="col">12.其他(不可抗力)</th>
                <th scope="col">進入本計畫輔導</th>
                <th scope="col">A.動向調查學生數</th>
                <th scope="col">B.未升學未就業人數(4-12)</th>
                <th scope="col">C.需政府關懷追蹤後，適時介入輔導人數(4-11)</th>
                <th scope="col" style="width:30%;">備註</th>
              
              </tr>
            </thead>
            <tbody>
            <?php
            $total = 0;
            for ($j = 0; $j < count($counties); $j++) { ?>
              <tr>
             
                <td><?php echo $counties[$j]['name'];?></td>
                <td><?php $cnt = 5000;
                    foreach ($nowYearsTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['already_working'] : null;
                        $cnt = $i['already_working'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($nowYearsTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['already_attending_school'] : null;
                        $cnt = $i['already_attending_school'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($nowYearsTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['special_education_student'] : null;
                        $cnt = $i['special_education_student'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($nowYearsTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['prepare_to_school'] : null;
                        $cnt = $i['prepare_to_school'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($nowYearsTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['prepare_to_work'] : null;
                        $cnt = $i['prepare_to_work'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($nowYearsTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['training'] : null;
                        $cnt = $i['training'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($nowYearsTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['family_labor'] : null;
                        $cnt = $i['family_labor'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($nowYearsTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['health'] : null;
                        $cnt = $i['health'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($nowYearsTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['no_plan'] : null;
                        $cnt = $i['no_plan'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($nowYearsTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['lost_contact'] : null;
                        $cnt = $i['lost_contact'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>

                <td><?php $cnt = 5000;
                    foreach ($nowYearsTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['transfer_labor'] + $i['transfer_other'] + $i['pregnancy'] + $i['other'] : null;
                        $cnt = $i['transfer_labor'] + $i['transfer_other'] + $i['pregnancy'] + $i['other'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($nowYearsTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['immigration'] + $i['death'] + $i['military'] : null;
                        $cnt = $i['immigration'] + $i['death'] + $i['military'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($nowYearsTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['in_case'] : null;
                        $cnt = $i['in_case'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($nowYearsTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['youthCount'] : null;
                        $cnt = $i['youthCount'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($nowYearsTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['prepare_to_school'] + $i['prepare_to_work'] + $i['training'] + $i['family_labor']
                          + $i['health'] + $i['no_plan'] + $i['lost_contact'] + $i['transfer_labor'] + $i['transfer_other'] + $i['pregnancy']
                          + $i['other'] + $i['immigration'] + $i['death'] + $i['military'] : null;
                        $cnt = $i['prepare_to_school'] + $i['prepare_to_work'] + $i['training'] + $i['family_labor']
                          + $i['health'] + $i['no_plan'] + $i['lost_contact'] + $i['transfer_labor'] + $i['transfer_other'] + $i['pregnancy']
                          + $i['other'] + $i['immigration'] + $i['death'] + $i['military'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($nowYearsTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['prepare_to_school'] + $i['prepare_to_work'] + $i['training'] + $i['family_labor']
                          + $i['health'] + $i['no_plan'] + $i['lost_contact'] + $i['transfer_labor'] + $i['transfer_other'] + $i['pregnancy']
                          + $i['other'] + $i['immigration'] + $i['death'] + $i['military'] : null;
                        $cnt = $i['prepare_to_school'] + $i['prepare_to_work'] + $i['training'] + $i['family_labor']
                          + $i['health'] + $i['no_plan'] + $i['lost_contact'] + $i['transfer_labor'] + $i['transfer_other'] + $i['pregnancy']
                          + $i['other'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                  <td style="text-align:left"><?php $cnt = "";
                    foreach ($nowYearsTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? str_replace("\n", "<br/>", $i['note']) : null;
                        $cnt = $i['note'];
                      }
                    }
                    if ($cnt == "") {
                      echo "無資料";
                    }
                     ?></td>
                     
              </tr>
              <?php } ?>
              <tr>
                <td>總計</td>
                <td><?php echo $sumDetail['alreadyWorkingSum'];?></td>
                <td><?php echo $sumDetail['alreadyAttendingSchoolSum'];?></td>
                <td><?php echo $sumDetail['specialEducationStudentSum'];?></td>
                <td><?php echo $sumDetail['prepareToSchoolSum'];?></td>
                <td><?php echo $sumDetail['prepareToWorkSum'];?></td>
                <td><?php echo $sumDetail['trainingSum'];?></td>
                <td><?php echo $sumDetail['familyLaborSum'];?></td>
                <td><?php echo $sumDetail['healthSum'];?></td>
                <td><?php echo $sumDetail['noPlanSum'];?></td>
                <td><?php echo $sumDetail['lostContactSum'];?></td>
                <td><?php echo $sumDetail['transferLaborSum'] + $sumDetail['transferOtherSum'] + $sumDetail['pregnancySum'] + $sumDetail['otherSum'];?></td>
                <td><?php echo $sumDetail['immigrationSum'] + $sumDetail['deathSum'] + $sumDetail['militarySum'];?></td>
                <td><?php echo $sumDetail['inCaseSum']; ?></td>
                <td><?php echo $sumDetail['youthCountSum']; ?></td>
                <td><?php echo $sumDetail['alreadyWorkingSum'] + $sumDetail['alreadyAttendingSchoolSum'] + $sumDetail['specialEducationStudentSum'] + $sumDetail['prepareToSchoolSum'] + $sumDetail['prepareToWorkSum'] 
                     + $sumDetail['trainingSum'] + $sumDetail['familyLaborSum'] + $sumDetail['healthSum'] + $sumDetail['noPlanSum'] + $sumDetail['lostContactSum'] + $sumDetail['transferLaborSum'] 
                     + $sumDetail['transferOtherSum'] + $sumDetail['pregnancySum'] + $sumDetail['otherSum'] + $sumDetail['immigrationSum'] + $sumDetail['deathSum'] + $sumDetail['militarySum'];?></td>
                <td><?php echo $sumDetail['alreadyWorkingSum'] + $sumDetail['alreadyAttendingSchoolSum'] + $sumDetail['specialEducationStudentSum'] + $sumDetail['prepareToSchoolSum'] + $sumDetail['prepareToWorkSum'] 
                     + $sumDetail['trainingSum'] + $sumDetail['familyLaborSum'] + $sumDetail['healthSum'] + $sumDetail['noPlanSum'] + $sumDetail['lostContactSum'] + $sumDetail['transferLaborSum'] 
                     + $sumDetail['transferOtherSum'] + $sumDetail['pregnancySum'] + $sumDetail['otherSum'];?></td>
                <td></td>
              
            </tr>
            </tbody>
          </table>
				<?php }?>

        <?php if ($reportType == 'oldCaseTrendSurveyCountReport' || $reportType == 'all') {?>
        <h4>前一年結案後動向調查追蹤</h4>
        <table class="highlight centered" style="border:2px grey solid;">
            <thead class="thead-dark">
              <tr>
                <th scope="col">縣市</th>
                <th scope="col">1.已就業</th>
                <th scope="col">2.已就學</th>
                <th scope="col">3.特教生</th>
                <th scope="col">4.準備升學</th>
                <th scope="col">5.準備或正在找工作</th>
                <th scope="col">6.參加職訓</th>
                <th scope="col">7.家務勞動</th>
                <th scope="col">8.健康因素</th>
                <th scope="col">9.尚未規劃</th>
                <th scope="col">10.失聯</th>
                <th scope="col">11.其他(非不可抗力)</th>
                <th scope="col">12.其他(不可抗力)</th>
                <th scope="col">進入本計畫輔導</th>
                <th scope="col">A.動向調查學生數</th>
                <th scope="col">B.未升學未就業人數(4-12)</th>
                <th scope="col">C.需政府關懷追蹤後，適時介入輔導人數(4-11)</th>
                <th scope="col" style="width:30%;">備註</th>
              
              </tr>
            </thead>
            <tbody>
            <?php
            $total = 0;
            for ($j = 0; $j < count($counties); $j++) { ?>
              <tr>
             
                <td><?php echo $counties[$j]['name'];?></td>
                <td><?php $cnt = 5000;
                    foreach ($oldCaseTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['already_working'] : null;
                        $cnt = $i['already_working'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($oldCaseTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['already_attending_school'] : null;
                        $cnt = $i['already_attending_school'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($oldCaseTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['special_education_student'] : null;
                        $cnt = $i['special_education_student'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($oldCaseTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['prepare_to_school'] : null;
                        $cnt = $i['prepare_to_school'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($oldCaseTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['prepare_to_work'] : null;
                        $cnt = $i['prepare_to_work'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($oldCaseTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['training'] : null;
                        $cnt = $i['training'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($oldCaseTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['family_labor'] : null;
                        $cnt = $i['family_labor'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($oldCaseTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['health'] : null;
                        $cnt = $i['health'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($oldCaseTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['no_plan'] : null;
                        $cnt = $i['no_plan'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($oldCaseTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['lost_contact'] : null;
                        $cnt = $i['lost_contact'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>

                <td><?php $cnt = 5000;
                    foreach ($oldCaseTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['transfer_labor'] + $i['transfer_other'] + $i['pregnancy'] + $i['other'] : null;
                        $cnt = $i['transfer_labor'] + $i['transfer_other'] + $i['pregnancy'] + $i['other'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($oldCaseTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['immigration'] + $i['death'] + $i['military'] : null;
                        $cnt = $i['immigration'] + $i['death'] + $i['military'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($oldCaseTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['in_case'] : null;
                        $cnt = $i['in_case'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($oldCaseTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['youthCount'] : null;
                        $cnt = $i['youthCount'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($oldCaseTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['prepare_to_school'] + $i['prepare_to_work'] + $i['training'] + $i['family_labor']
                          + $i['health'] + $i['no_plan'] + $i['lost_contact'] + $i['transfer_labor'] + $i['transfer_other'] + $i['pregnancy']
                          + $i['other'] + $i['immigration'] + $i['death'] + $i['military'] : null;
                        $cnt = $i['prepare_to_school'] + $i['prepare_to_work'] + $i['training'] + $i['family_labor']
                          + $i['health'] + $i['no_plan'] + $i['lost_contact'] + $i['transfer_labor'] + $i['transfer_other'] + $i['pregnancy']
                          + $i['other'] + $i['immigration'] + $i['death'] + $i['military'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                <td><?php $cnt = 5000;
                    foreach ($oldCaseTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? $i['prepare_to_school'] + $i['prepare_to_work'] + $i['training'] + $i['family_labor']
                          + $i['health'] + $i['no_plan'] + $i['lost_contact'] + $i['transfer_labor'] + $i['transfer_other'] + $i['pregnancy']
                          + $i['other'] + $i['immigration'] + $i['death'] + $i['military'] : null;
                        $cnt = $i['prepare_to_school'] + $i['prepare_to_work'] + $i['training'] + $i['family_labor']
                          + $i['health'] + $i['no_plan'] + $i['lost_contact'] + $i['transfer_labor'] + $i['transfer_other'] + $i['pregnancy']
                          + $i['other'];
                      }
                    }
                    if ($cnt == 5000) {
                      echo "0";
                    }
                    $total += $cnt; ?></td>
                  <td style="text-align:left"><?php $cnt = "";
                    foreach ($oldCaseTrendSurveyCountReport as $i) {
                      if ( $counties[$j]['name'] == $i['name']) {
                        echo $i ? str_replace("\n", "<br/>", $i['note']) : null;
                        $cnt = $i['note'];
                      }
                    }
                    if ($cnt == "") {
                      echo "無資料";
                    }
                     ?></td>
                     
              </tr>
              <?php } ?>
              <tr>
                <td>總計</td>
                <td><?php echo $sumDetail['alreadyWorkingSum'];?></td>
                <td><?php echo $sumDetail['alreadyAttendingSchoolSum'];?></td>
                <td><?php echo $sumDetail['specialEducationStudentSum'];?></td>
                <td><?php echo $sumDetail['prepareToSchoolSum'];?></td>
                <td><?php echo $sumDetail['prepareToWorkSum'];?></td>
                <td><?php echo $sumDetail['trainingSum'];?></td>
                <td><?php echo $sumDetail['familyLaborSum'];?></td>
                <td><?php echo $sumDetail['healthSum'];?></td>
                <td><?php echo $sumDetail['noPlanSum'];?></td>
                <td><?php echo $sumDetail['lostContactSum'];?></td>
                <td><?php echo $sumDetail['transferLaborSum'] + $sumDetail['transferOtherSum'] + $sumDetail['pregnancySum'] + $sumDetail['otherSum'];?></td>
                <td><?php echo $sumDetail['immigrationSum'] + $sumDetail['deathSum'] + $sumDetail['militarySum'];?></td>
                <td><?php echo $sumDetail['inCaseSum']; ?></td>
                <td><?php echo $sumDetail['youthCountSum']; ?></td>
                <td><?php echo $sumDetail['alreadyWorkingSum'] + $sumDetail['alreadyAttendingSchoolSum'] + $sumDetail['specialEducationStudentSum'] + $sumDetail['prepareToSchoolSum'] + $sumDetail['prepareToWorkSum'] 
                     + $sumDetail['trainingSum'] + $sumDetail['familyLaborSum'] + $sumDetail['healthSum'] + $sumDetail['noPlanSum'] + $sumDetail['lostContactSum'] + $sumDetail['transferLaborSum'] 
                     + $sumDetail['transferOtherSum'] + $sumDetail['pregnancySum'] + $sumDetail['otherSum'] + $sumDetail['immigrationSum'] + $sumDetail['deathSum'] + $sumDetail['militarySum'];?></td>
                <td><?php echo $sumDetail['alreadyWorkingSum'] + $sumDetail['alreadyAttendingSchoolSum'] + $sumDetail['specialEducationStudentSum'] + $sumDetail['prepareToSchoolSum'] + $sumDetail['prepareToWorkSum'] 
                     + $sumDetail['trainingSum'] + $sumDetail['familyLaborSum'] + $sumDetail['healthSum'] + $sumDetail['noPlanSum'] + $sumDetail['lostContactSum'] + $sumDetail['transferLaborSum'] 
                     + $sumDetail['transferOtherSum'] + $sumDetail['pregnancySum'] + $sumDetail['otherSum'];?></td>
                <td></td>
              
            </tr>
            </tbody>
          </table>
				<?php }?>


      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    $('#download').click(function () {
        var data = $("#form").html();
        if (data == '') {
            alert('請先搜尋您想要下載的數據');
        } else {
            var html = "<html><head><meta   charset= 'utf-8'></head><body>" + data + "</body></html>";
            window.open('data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,' + encodeURIComponent(html));
        }
    });

    function downloadCSV(csv, filename) {
        var csvFile;
        var downloadLink;

        // CSV file
        csvFile = new Blob(["\uFEFF"+csv], {type: 'text/csv;charset=utf-8;'});

        // Download link
        downloadLink = document.createElement("a");

        // File name
        downloadLink.download = filename;

        // Create a link to the file
        downloadLink.href = window.URL.createObjectURL(csvFile);

        // Hide download link
        downloadLink.style.display = "none";

        // Add the link to DOM
        document.body.appendChild(downloadLink);

        // Click download link
        downloadLink.click();
    }

    function exportTableToCSV(report,filename) {
      var csv = [];
      var rows = document.querySelectorAll(report + " tr");

      for (var i = 0; i < rows.length; i++) {
          var row = [], cols = rows[i].querySelectorAll("td, th");

          for (var j = 0; j < cols.length; j++)
              row.push(cols[j].innerText);

          csv.push(row.join(","));
    }

    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
    }

</script>
<?php $this->load->view('templates/footer');?>