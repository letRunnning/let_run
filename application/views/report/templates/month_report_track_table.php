<!-- <table class="surveyTypeHighSchoolTrack highlight centered" style="border:2px grey solid;"> -->
<table class="table table-hover table-bordered align-middle text-center" style="border:2px grey solid;">
  <thead class="thead-dark">
    <tr>
      <th scope="col" rowspan="2">縣市</th>
      <th scope="col" colspan="4">具輔導成效</th>
      <th scope="col" colspan="7">尚無輔導成效</th>
      <th scope="col" colspan="6">不可抗力</th>
      <th scope="col" rowspan="2">總計</th>
      <th scope="col" rowspan="2">青少年人數</th>
      <th scope="col" rowspan="2" style="width:30%;">備註</th>
    </tr>
    <tr>
      <th scope="col">1.已就業</th>
      <th scope="col">2.已就學</th>
      <th scope="col">3.職業訓練或勞政單位協助中</th>
      <th scope="col">4.其他</th>
      <th scope="col">5.準備升學</th>
      <th scope="col">6.準備或正在找工作</th>
      <th scope="col">7.家務勞動</th>
      <th scope="col">8.健康因素</th>
      <th scope="col">9.尚未規劃</th>
      <th scope="col">10.失聯</th>
      <th scope="col">11.其他</th>
      <th scope="col">12.特教生</th>
      <th scope="col">13.移民</th>
      <th scope="col">14.警政或司法單位協助中</th>
      <th scope="col">15.服兵役</th>
      <th scope="col">16.死亡</th>
      <th scope="col">17.成年</th>
    </tr>
  </thead>
  <tbody>
    <?php $count = 0;?>

    <?php if($value) :?>
      <?php foreach ($value as $i) {?>
        <tr>
          <td><?php echo $i ? $i['name'] : 0 ?></td>
          <td><a href="<?php echo site_url('/report/verify_table/' . $yearType . '/' . $monthType . '/' . $type . '/one'); ?>"><?php echo ($reportProcessesCounselorStatus != $reviewStatus['review_process_pass']) ? $i['one'] : $report->one ?></td>
          <td><a href="<?php echo site_url('/report/verify_table/' . $yearType . '/' . $monthType . '/' . $type . '/two'); ?>"><?php echo ($reportProcessesCounselorStatus != $reviewStatus['review_process_pass']) ? $i['two'] : $report->two ?></td>
          <td><a href="<?php echo site_url('/report/verify_table/' . $yearType . '/' . $monthType . '/' . $type . '/three'); ?>"><?php echo ($reportProcessesCounselorStatus != $reviewStatus['review_process_pass']) ? $i['three'] : $report->three ?></td>
          <td><a href="<?php echo site_url('/report/verify_table/' . $yearType . '/' . $monthType . '/' . $type . '/four'); ?>"><?php echo ($reportProcessesCounselorStatus != $reviewStatus['review_process_pass']) ? $i['four'] : $report->four ?></td>
          <td><a href="<?php echo site_url('/report/verify_table/' . $yearType . '/' . $monthType . '/' . $type . '/five'); ?>"><?php echo ($reportProcessesCounselorStatus != $reviewStatus['review_process_pass']) ? $i['five'] : $report->five ?></td>
          <td><a href="<?php echo site_url('/report/verify_table/' . $yearType . '/' . $monthType . '/' . $type . '/six'); ?>"><?php echo ($reportProcessesCounselorStatus != $reviewStatus['review_process_pass']) ? $i['six'] : $report->six ?></td>
          <td><a href="<?php echo site_url('/report/verify_table/' . $yearType . '/' . $monthType . '/' . $type . '/seven'); ?>"><?php echo ($reportProcessesCounselorStatus != $reviewStatus['review_process_pass']) ? $i['seven'] : $report->seven ?></td>
          <td><a href="<?php echo site_url('/report/verify_table/' . $yearType . '/' . $monthType . '/' . $type . '/eight'); ?>"><?php echo ($reportProcessesCounselorStatus != $reviewStatus['review_process_pass']) ? $i['eight'] : $report->eight ?></td>
          <td><a href="<?php echo site_url('/report/verify_table/' . $yearType . '/' . $monthType . '/' . $type . '/nine'); ?>"><?php echo ($reportProcessesCounselorStatus != $reviewStatus['review_process_pass']) ? $i['nine'] : $report->nine ?></td>
          <td><a href="<?php echo site_url('/report/verify_table/' . $yearType . '/' . $monthType . '/' . $type . '/ten'); ?>"><?php echo ($reportProcessesCounselorStatus != $reviewStatus['review_process_pass']) ? $i['ten'] : $report->ten ?></td>
          <td><a href="<?php echo site_url('/report/verify_table/' . $yearType . '/' . $monthType . '/' . $type . '/eleven'); ?>"><?php echo ($reportProcessesCounselorStatus != $reviewStatus['review_process_pass']) ? $i['eleven'] : $report->eleven ?></td>
          <td><a href="<?php echo site_url('/report/verify_table/' . $yearType . '/' . $monthType . '/' . $type . '/twelve'); ?>"><?php echo ($reportProcessesCounselorStatus != $reviewStatus['review_process_pass']) ? $i['twelve'] : $report->twelve ?></td>
          <td><a href="<?php echo site_url('/report/verify_table/' . $yearType . '/' . $monthType . '/' . $type . '/thirteen'); ?>"><?php echo ($reportProcessesCounselorStatus != $reviewStatus['review_process_pass']) ? $i['thirteen'] : $report->thirteen ?></td>
          <td><a href="<?php echo site_url('/report/verify_table/' . $yearType . '/' . $monthType . '/' . $type . '/fourteen'); ?>"><?php echo ($reportProcessesCounselorStatus != $reviewStatus['review_process_pass']) ? $i['fourteen'] : $report->fourteen ?></td>
          <td><a href="<?php echo site_url('/report/verify_table/' . $yearType . '/' . $monthType . '/' . $type . '/fifteen'); ?>"><?php echo ($reportProcessesCounselorStatus != $reviewStatus['review_process_pass']) ? $i['fifteen'] : $report->fifteen ?></td>
          <td><a href="<?php echo site_url('/report/verify_table/' . $yearType . '/' . $monthType . '/' . $type . '/sixteen'); ?>"><?php echo ($reportProcessesCounselorStatus != $reviewStatus['review_process_pass']) ? $i['sixteen'] : $report->sixteen ?></td>
          <td><a href="<?php echo site_url('/report/verify_table/' . $yearType . '/' . $monthType . '/' . $type . '/seventeen'); ?>"><?php echo ($reportProcessesCounselorStatus != $reviewStatus['review_process_pass']) ? $i['seventeen'] : $report->seventeen ?></td>
          <td><a href="<?php echo site_url('/report/verify_table/' . $yearType . '/' . $monthType . '/' . $type . '/eighteen'); ?>"><?php echo ($reportProcessesCounselorStatus != $reviewStatus['review_process_pass']) ? $i['eighteen'] : $report->eighteen ?></td>
          <td><a href="<?php echo site_url('/report/verify_table/' . $yearType . '/' . $monthType . '/' . $type . '/nineteen'); ?>"><?php echo ($reportProcessesCounselorStatus != $reviewStatus['review_process_pass']) ? $i['nineteen'] : $report->nineteen ?></td>
          <td style="text-align:left"><?php echo str_replace("\n", "<br/>", ($reportProcessesCounselorStatus != $reviewStatus['review_process_pass']) ? $noteDetail[$count] : $report->note); ?></td>
          <?php $count += 1;?>
        </tr>
      <?php }?>
    <?php else :?>
      <tr>
          <td><?php echo $countyName ?></td>
          <td><?php echo $report->one ?></td>
          <td><?php echo $report->two ?></td>
          <td><?php echo $report->three ?></td>
          <td><?php echo $report->four ?></td>
          <td><?php echo $report->five ?></td>
          <td><?php echo $report->six ?></td>
          <td><?php echo $report->seven ?></td>
          <td><?php echo $report->eight ?></td>
          <td><?php echo $report->nine ?></td>
          <td><?php echo $report->ten ?></td>
          <td><?php echo $report->eleven ?></td>
          <td><?php echo $report->twelve ?></td>
          <td><?php echo $report->thirteen ?></td>
          <td><?php echo $report->fourteen ?></td>
          <td><?php echo $report->fifteen ?></td>
          <td><?php echo $report->sixteen ?></td>
          <td><?php echo $report->seventeen ?></td>
          <td><?php echo $report->eighteen ?></td>
          <td><?php echo $report->nineteen ?></td>
          <td style="text-align:left"><?php echo str_replace("\n", "<br/>", $report->note); ?></td>
          <?php $count += 1;?>
        </tr>
    <?php endif;?>
    <?php if($countyType == 'all') :?>
      <tr>
        <td>總計</td>
        <td><?php echo $valueSum ? $valueSum['one'] : 0 ?></td>
        <td><?php echo $valueSum ? $valueSum['two'] : 0 ?></td>
        <td><?php echo $valueSum ? $valueSum['three'] : 0 ?></td>
        <td><?php echo $valueSum ? $valueSum['four'] : 0 ?></td>
        <td><?php echo $valueSum ? $valueSum['five'] : 0 ?></td>
        <td><?php echo $valueSum ? $valueSum['six'] : 0 ?></td>
        <td><?php echo $valueSum ? $valueSum['seven'] : 0 ?></td>
        <td><?php echo $valueSum ? $valueSum['eight'] : 0 ?></td>
        <td><?php echo $valueSum ? $valueSum['nine'] : 0 ?></td>
        <td><?php echo $valueSum ? $valueSum['ten'] : 0 ?></td>
        <td><?php echo $valueSum ? $valueSum['eleven'] : 0 ?></td>
        <td><?php echo $valueSum ? $valueSum['twelve'] : 0 ?></td>
        <td><?php echo $valueSum ? $valueSum['thirteen'] : 0 ?></td>
        <td><?php echo $valueSum ? $valueSum['fourteen'] : 0 ?></td>
        <td><?php echo $valueSum ? $valueSum['fifteen'] : 0 ?></td>
        <td><?php echo $valueSum ? $valueSum['sixteen'] : 0 ?></td>
        <td><?php echo $valueSum ? $valueSum['seventeen'] : 0 ?></td>
        <td><?php echo $valueSum ? $valueSum['eighteen'] : 0 ?></td>
        <td><?php echo $valueSum ? $valueSum['nineteen'] : 0 ?></td>   
        <td></td>
        <?php $count += 1;?>
			</tr>
    <?php endif;?>
  </tbody>
</table>