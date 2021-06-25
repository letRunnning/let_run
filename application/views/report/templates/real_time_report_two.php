<table class="highlight highlight centered" style="border:2px grey solid;">
  <thead class="thead-dark">
		<tr>
			<th scope="col" rowspan="3">縣市</th>
			<th scope="col" colspan="9">具輔導成效</th>
			<th scope="col" colspan="9">持續關懷輔導</th>
			<th scope="col" colspan="8">不可抗力</th>
      <th scope="col" rowspan="3">總計</th>
      <th scope="col" rowspan="3">青少年人數</th>
    </tr>
    <tr>
			<th scope="col" rowspan="2">已就業</th>
      <th scope="col" rowspan="2">已就學</th>
		  <th scope="col" colspan="2">職訓或勞政單位協助中</th>
			<th scope="col" colspan="4">其他</th>
      <th scope="col" rowspan="2">小計</th>

      <th scope="col" rowspan="2">準備升學</th>
      <th scope="col" rowspan="2">準備就業</th>
      <th scope="col" rowspan="2">家務勞動</th>
      <th scope="col" rowspan="2">健康因素休養中</th>
      <th scope="col" rowspan="2">尚未規劃</th>
      <th scope="col" rowspan="2">未取得聯繫</th>
      <th scope="col" colspan="2">其他</th>
      <th scope="col" rowspan="2">小計</th>

      <th scope="col" rowspan="2">特教生</th>
      <th scope="col" rowspan="2">移民(出國)</th>
      <th scope="col" rowspan="2">服兵役</th>
      <th scope="col" colspan="2">警政或司法單位協助中</th>
      <th scope="col" rowspan="2">成年</th>
      <th scope="col" rowspan="2">死亡</th>
      <th scope="col" rowspan="2">小計</th>
    </tr>

    <tr>
      <th scope="col" rowspan="2">參加職訓</th>
      <th scope="col" rowspan="2">勞政單位協助中</th>

			<th scope="col" >社政單位協助中</th>
      <th scope="col" >衛政單位協助中</th>
      <th scope="col" >其他單位協助中</th>
      <th scope="col" >自學</th>

      <th scope="col" >待產/育兒</th>
      <th scope="col" >其他</th>

      <th scope="col" >警政單位協助中</th>
      <th scope="col" >司法單位協助中</th>
     
    </tr>
  </thead>
  <tbody>
    <?php 
      foreach ($value as $i) {?>
        <tr>
          <td><?php echo $i['name']; ?></td>

          <td><?php echo $i['1']; ?></td>
          <td><?php echo $i['2']; ?></td>
          <td><?php echo $i['3']; ?></td>
          <td><?php echo $i['4']; ?></td>
          <td><?php echo $i['5']; ?></td>
          <td><?php echo $i['6']; ?></td>
          <td><?php echo $i['7']; ?></td>
          <td><?php echo $i['8']; ?></td>

          <td><?php echo $i['26']; ?></td>

          <td><?php echo $i['9']; ?></td>
          <td><?php echo $i['10']; ?></td>
          <td><?php echo $i['11']; ?></td>
          <td><?php echo $i['12']; ?></td>
          <td><?php echo $i['13']; ?></td>
          <td><?php echo $i['14']; ?></td>
          <td><?php echo $i['15']; ?></td>
          <td><?php echo $i['16']; ?></td>

          <td><?php echo $i['27']; ?></td>

          <td><?php echo $i['17']; ?></td>
          <td><?php echo $i['18']; ?></td>
          <td><?php echo $i['19']; ?></td>
          <td><?php echo $i['20']; ?></td>
          <td><?php echo $i['21']; ?></td>
          <td><?php echo $i['22']; ?></td>
          <td><?php echo $i['23']; ?></td>

          <td><?php echo $i['28']; ?></td>

          <td><?php echo $i['24']; ?></td>
          <td><?php echo $i['25']; ?></td>

        </tr>
    <?php }?>
    <?php if($countyType == 'all') {?>
      <tr>
        <td>總計</td>
          <td><?php echo $sum['1']; ?></td>
          <td><?php echo $sum['2']; ?></td>
          <td><?php echo $sum['3']; ?></td>
          <td><?php echo $sum['4']; ?></td>
          <td><?php echo $sum['5']; ?></td>
          <td><?php echo $sum['6']; ?></td>
          <td><?php echo $sum['7']; ?></td>
          <td><?php echo $sum['8']; ?></td>

          <td><?php echo $sum['26']; ?></td>

          <td><?php echo $sum['9']; ?></td>
          <td><?php echo $sum['10']; ?></td>
          <td><?php echo $sum['11']; ?></td>
          <td><?php echo $sum['12']; ?></td>
          <td><?php echo $sum['13']; ?></td>
          <td><?php echo $sum['14']; ?></td>
          <td><?php echo $sum['15']; ?></td>
          <td><?php echo $sum['16']; ?></td>

          <td><?php echo $sum['27']; ?></td>

          <td><?php echo $sum['17']; ?></td>
          <td><?php echo $sum['18']; ?></td>
          <td><?php echo $sum['19']; ?></td>
          <td><?php echo $sum['20']; ?></td>
          <td><?php echo $sum['21']; ?></td>
          <td><?php echo $sum['22']; ?></td>
          <td><?php echo $sum['23']; ?></td>

          <td><?php echo $sum['28']; ?></td>

          <td><?php echo $sum['24']; ?></td>
          <td><?php echo $sum['25']; ?></td>
        </tr>
    <?php }?>
  
  </tbody>
</table>