<table class="highlight centered" style="border:2px grey solid;">
  <thead class="thead-dark">
		<tr>
			<th scope="col" rowspan="4">縣市</th>
			<th scope="col" rowspan="4">關懷追蹤人數(108國中+109高中)A</th>
			<th scope="col" colspan="5">關懷青少年</th>
			<th scope="col" colspan="9">開案學員</th>
    </tr>
    <tr>
			<th scope="col" rowspan="3">轉出人數B</th>
			<th scope="col" rowspan="3">108+109開案人數C</th>
			<th scope="col" rowspan="3">轉入人數D</th>
			<th scope="col" colspan="2">表一關懷人數</th>
      <th scope="col" rowspan="3">開案總人數</th>
      <th scope="col" colspan="3">開案情形</th>
      <th scope="col" colspan="2">續案情形</th>
      <th scope="col" rowspan="3">已結案</th>
      <th scope="col" rowspan="3"><?php echo $yearType -4;?>國中</th>
      <th scope="col" rowspan="3"><?php echo $yearType -3;?>國中</th>
    </tr>
    <tr>
			<th scope="col" rowspan="2">總計(含結案)A-B-C+D</th>
			<th scope="col" rowspan="2">結案人數(不含轉出)</th>
			<th scope="col" rowspan="2">自行開案人數</th>
			<th scope="col" colspan="2">關懷名單開案人數</th>
      <th scope="col" rowspan="2">今年度新開案</th>
      <th scope="col" rowspan="2">前一年度續案</th>
    </tr>
    <tr>
      <th scope="col"><?php echo $yearType -2;?>國中</th>
      <th scope="col"><?php echo $yearType -1;?>高中</th>
    </tr>

  </thead>
  <tbody>
    <?php 
      foreach ($value as $i) {?>
        <tr>
          <td><?php echo $i['name']; ?></td>
          <td><?php echo $i['one']; ?></td>
          <td><?php echo $i['two']; ?></td>
          <td><?php echo $i['three']; ?></td>
          <td><?php echo $i['four']; ?></td>
          <td><?php echo $i['five']; ?></td>
          <td><?php echo $i['six']; ?></td>
          <td><?php echo $i['seven']; ?></td>
          <td><?php echo $i['eight']; ?></td>
          <td><?php echo $i['nine']; ?></td>
          <td><?php echo $i['ten']; ?></td>
          <td><?php echo $i['eleven']; ?></td>
          <td><?php echo $i['twelve']; ?></td>
          <td><?php echo $i['thirteen']; ?></td>
          <td><?php echo $i['fourteen']; ?></td>
          <td><?php echo $i['fifteen']; ?></td>
        </tr>
    <?php }?>
    <?php if($countyType == 'all') {?>
      <tr>
        <td>總計</td>
        <td><?php echo $sum['one']; ?></td>
        <td><?php echo $sum['two']; ?></td>
        <td><?php echo $sum['three']; ?></td>
        <td><?php echo $sum['four']; ?></td>
        <td><?php echo $sum['five']; ?></td>
        <td><?php echo $sum['six']; ?></td>
        <td><?php echo $sum['seven']; ?></td>
        <td><?php echo $sum['eight']; ?></td>
        <td><?php echo $sum['nine']; ?></td>
        <td><?php echo $sum['ten']; ?></td>
        <td><?php echo $sum['eleven']; ?></td>
        <td><?php echo $sum['twelve']; ?></td>
        <td><?php echo $sum['thirteen']; ?></td>
        <td><?php echo $sum['fourteen']; ?></td>
        <td><?php echo $sum['fifteen']; ?></td>
      </tr>
    <?php }?>
  </tbody>
</table>