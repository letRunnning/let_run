<?php $this->load->view('templates/new_header');?>
<div class="container" style="width:90%;">
  <div class="row">
    <div class="col-md-12">
      <h4 class="text-dark text-center"><?php echo $title ?></h4>
      <div class="card-content">
        <!-- years -->
				

        <table id="memberTable" class="table table-hover">
          <thead class="thead-dark">
            <tr>
              <th scope="col">姓名</th>
              <th scope="col">身分證</th>
              <th scope="col">查看</th>
          
            </tr>
          </thead> 
          <tbody>
            <?php foreach($youths as $i) { ?>
              <tr>
                <td><?php echo $i['name'];?></td>
               
                <td><?php echo $i['identifications'];?></td>
                <td><a class="btn btn-primary" href="<?php echo site_url('youth/repeat_youth_in/'.$i['county'] . '/' . $i['no']);?>">GO</a></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('templates/new_footer');?>
