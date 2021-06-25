<table class="surveyTypeHighSchoolTrack highlight centered" style="border:2px grey solid;">
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
		<?php foreach ($value as $i) {?>
			<tr>
        <td><?php echo $i ? $i['name'] : 0 ?></td>
        <td><?php echo $i ? $i['one'] : 0 ?></td>
        <td><?php echo $i ? $i['two'] : 0 ?></td>
        <td><?php echo $i ? $i['three'] : 0 ?></td>
        <td><?php echo $i ? $i['four'] : 0 ?></td>
        <td><?php echo $i ? $i['five'] : 0 ?></td>
        <td><?php echo $i ? $i['six'] : 0 ?></td>
        <td><?php echo $i ? $i['seven'] : 0 ?></td>
        <td><?php echo $i ? $i['eight'] : 0 ?></td>
        <td><?php echo $i ? $i['nine'] : 0 ?></td>
        <td><?php echo $i ? $i['ten'] : 0 ?></td>
        <td><?php echo $i ? $i['eleven'] : 0 ?></td>
        <td><?php echo $i ? $i['twelve'] : 0 ?></td>
        <td><?php echo $i ? $i['thirteen'] : 0 ?></td>
        <td><?php echo $i ? $i['fourteen'] : 0 ?></td>
        <td><?php echo $i ? $i['fifteen'] : 0 ?></td>
        <td><?php echo $i ? $i['sixteen'] : 0 ?></td>
        <td><?php echo $i ? $i['seventeen'] : 0 ?></td>
        <td><?php echo $i ? $i['eighteen'] : 0 ?></td>
        <td><?php echo $i ? $i['nineteen'] : 0 ?></td>   
        <td style="text-align:left"><?php echo str_replace("\n", "<br/>", $noteDetail[$count]); ?></td>
        <?php $count += 1;?>
			</tr>
		<?php }?>
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