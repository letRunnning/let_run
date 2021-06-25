<div class="card">
  <div class="card-body">
    <div class="dashboard_card">
      <h3 class="card-title">最新消息</h3>
      <table class="table table-hover">
        <thead class="thead-dark">
          <tr>
            <th scope="col">日期</th>
            <th scope="col">分類</th>
            <th scope="col">內容</th>
            <th scope="col">發布者</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($messagers as $i) { ?>
              <tr>
                <td><?php echo $i['create_date'];?></td>
                <td><?php foreach($types as $value){
                    if($value['no'] == $i['type']){
                        echo $value['content'];
                    }
                }?></td>
                <td><?php echo $i['content'];?></td>
               
                <td><?php echo '青年發展署'?>
                </td>
              </tr>
            <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
