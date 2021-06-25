<?php $this->load->view('templates/new_header'); ?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h4 class="text-dark text-center"><?php echo $title ?></h4>
      <div class="card-content">
        <form action="<?php echo site_url($url);?>" 
          method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />
          <?php echo isset($error) ? '<p class="text-danger text-center">'.$error.'</p>' : '';?>
          <?php echo isset($success) ? '<p class="text-success text-center">'.$success.'</p>' : '';?>
        
           <!-- counselor -->
          <div class="col-10 m-2 mx-auto">
            <label>現任輔導員</label>
            <div class="input-group">
              <select class="form-select" name="counselor">
                <?php if (empty($caseAssessments->counselor)) { ?>
                  <option disabled selected value>請選擇</option>
                <?php } ?>
                <?php foreach ($counselors as $i) {
                        if (!empty($caseAssessments->counselor)) {
                          if ($i['no'] == $caseAssessments->counselor) { ?>
                            <option selected value="<?php echo $i['no']; ?>"><?php echo $i['userName']; ?></option>
                    <?php } else { ?>
                      <option disabled value="<?php echo $i['no']; ?>"><?php echo $i['userName']; ?></option>
                    <?php }
                }} ?>
              </select>
            </div>
          </div>

         <?php if ($role != 6) :?>

         <!-- counselor -->
          <div class="col-10 m-2 mx-auto">
            <label>欲更換輔導員*</label>
            <div class="input-group">
              <select class="form-select" name="newCounselor">
                <option disabled selected value>請選擇</option>
                <?php foreach ($counselors as $i) { ?>
                        <option value="<?php echo $i['no']; ?>"><?php echo $i['userName']; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

          <?php endif; ?>

           <!-- reason -->
          <div class="col-10 m-2 mx-auto">
            <label for="formReason" class="form-label">更換原因*</label>
            <input class="form-control" type="text" id="formReason" name="reason">
          </div>

          <div class="row">
            <div class="d-grid gap-2 col-2 mx-auto">
              <button class="btn btn-primary my-5" type="submit">建立</button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo site_url();?>assets/js/ElementBinder.js"></script>
<script type="text/javascript">
  const elementRelation = new ElementBinder();

</script>

<?php $this->load->view('templates/new_footer'); ?>
