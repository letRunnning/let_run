<?php $this->load->view('templates/new_header');?>
<div class="container">
  <div class="row">
    <div class="card col s12">
      <h4 class="card-title text-center"><?php echo $title ?></h4>
      <div class="card-content">
        <form action="<?php echo site_url($url);?>" 
          method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />
          <?php echo isset($error) ? '<p class="text-danger">'.$error.'</p>' : '';?>
          <?php echo isset($success) ? '<p class="text-success">'.$success.'</p>' : '';?>
          <div class="col-10 m-2 mx-auto">
            <label>計畫</label>
            <div class="input-group">
              <select class="form-select" name="project">
                <?php foreach($projects as $i) { ?>
                  <option value="<?php echo $i['no'];?>"><?php echo $i['name'];?></option>
                <?php } ?>
              </select>
              <a href="<?php echo site_url('project/create_project');?>" class="btn btn-primary m-1">+</a>
            </div>
          </div>

          <div class="col-10 m-2 mx-auto">
            <label>機構</label>
            <div class="input-group">
              <select class="form-select" name="organization">
                <?php foreach($organizations as $i) { ?>
                  <option value="<?php echo $i['no'];?>"><?php echo $i['name'];?></option>
                <?php } ?>
              </select>
              <a href="<?php echo site_url('organization/create_organization');?>" class="btn btn-primary m-1">+</a>
            </div>
          </div>

          <div class="row">
            <button class="btn btn-info btn-block rounded-0 py-2" type="submit">委託</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('templates/new_footer');?>