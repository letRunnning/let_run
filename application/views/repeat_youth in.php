<?php $this->load->view('templates/new_header');?>
<div class="container" style="width:90%;">
  <div class="row">
    <div class="col-md-12">
      <h4 class="text-dark text-center"><?php echo $title ?></h4>
      <div class="card-content">
        <form action="<?php echo site_url($url); ?>"
          method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>"
            value="<?php echo $security->get_csrf_hash() ?>" />
        <!-- years -->
				

        <table id="memberTable" class="table table-hover">
          <thead class="thead-dark">
            <tr>
              <th scope="col">no</th>
              <th scope="col">姓名</th>
              <th scope="col">身分證</th>
              <th scope="col">生日</th>
              <th scope="col">性別</th>
              <th scope="col">phone</th>
              <th scope="col">監護人</th>
              <th scope="col">source</th>
              <th scope="col">source_school_year</th>
              <th scope="col">survey_type</th>
              <th scope="col">year</th>
          
            </tr>
          </thead> 
          <tbody>
            <?php foreach($youths as $i) { ?>
              <tr>
                <td><?php echo $i['no'];?></td>
                <td><?php echo $i['name'];?></td>
                <td><?php echo $i['identifications'];?></td>
                <td><?php echo $i['birth'];?></td>
                <td><?php echo $i['gender'];?></td>
                <td><?php echo $i['phone'];?></td>
                <td><?php echo $i['guardian_name'];?></td>
                <td><?php echo $i['source'];?></td>
                <td><?php echo $i['source_school_year'];?></td>
                <td><?php echo $i['survey_type'];?></td>
                <td><?php echo $i['year'];?></td>
            
              </tr>
            <?php } ?>
          </tbody>
        </table>

          <div class="row">
            <div class="d-grid gap-2 col-2 mx-auto">
              <button class="btn btn-primary my-5" name="save" value="Save" type="submit">送出</button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('templates/new_footer');?>
