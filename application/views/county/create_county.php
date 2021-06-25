<?php $this->load->view('templates/new_header');?>
  <form action="create_county" method="post" accept-charset="utf-8" enctype="multipart/form-data">
  <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />
    <div class="row justify-content-center">
      <div class="col-12 col-md-8 col-lg-6 pb-5">
        <!--Form with header-->
        <div class="card border-info rounded-0">
          <div class="card-header p-0">
            <div class="bg-login-page text-white bg-info text-center py-2">
              <h3><i class="fa fa-book"></i></h3>
            </div>
          </div>
          <div class="card-body">
            <?php echo isset($error) ? '<p class="text-danger">'.$error.'</p>' : '';?>
            <?php echo isset($success) ? '<p class="text-success">'.$success.'</p>' : '';?>
            <div class="form-group">
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text"><i class="fa fa-user text-info"></i></div>
                </div>
                <input type="text" class="form-control" name="name" placeholder="縣市名稱*" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text"><i class="fa fa-user text-info"></i></div>
                </div>
                <input type="text" class="form-control" name="phone" placeholder="縣市電話*" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text"><i class="fa fa-user text-info"></i></div>
                </div>
                <input type="text" class="form-control" name="orgnizer" placeholder="承辦單位*" required>
              </div>
            </div>

            <div class="text-center">
              <button type="submit" class="btn btn-info btn-block rounded-0 py-2">建立</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
  <div style="height:120px;"></div>
  <?php $this->load->view('templates/new_footer');?>