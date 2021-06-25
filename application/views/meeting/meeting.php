<?php $this->load->view('templates/new_header');?>
<div class="container" style="width:100%;">
	<div class="row">
		<div class="card-body col-sm-12">
      <h4 class="card-title text-center"><?php echo $title ?></h4>
      <div class="card-content">
        <form action="<?php echo site_url($url); ?>"
          method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />
          <?php echo isset($error) ? '<p class="text-danger text-center">' . $error . '</p>' : ''; ?>
          <?php echo isset($success) ? '<p class="text-success text-center">' . $success . '</p>' : ''; ?>

          <!-- title -->
          <div class="col-10 m-2 mx-auto">
              <label for="formTitle">會議/講座名稱*</label>
              <input class="form-control" type="text" id="formTitle" name="title" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> required value="<?php echo (empty($meetings)) ? "" : $meetings->title ?>">
          </div>

          <!-- meeting_type -->
          <div class="row">
          <div class="col-10 m-2 mx-auto">
              <label>類型*</label>
                <select class="form-select" name="meetingType" <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?>>
                  <?php if (empty($meetings->meeting_type)) { ?>
                    <option disabled selected value>請選擇</option>
                    <?php }
                  foreach ($meetingTypes as $i) {
                    if (!empty($meetings->meeting_type)) {
                      if ($i['no'] == $meetings->meeting_type) {?>
                        <option selected value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                      <?php 
                      } else {?>
                        <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                      <?php }
                    } else {?>
                      <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                    <?php }?>
                  <?php }?>
                </select>
            </div>
          </div>

          <!-- startTime -->
          <div class="col-10 m-2 mx-auto">
            <label for="formStartTime">會議時間*</label>
            <input class="form-control" type="text" id="formStartTime" name="startTime" class="datepicker" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($meetings)) ? "" : $meetings->start_time ?>">
          </div>

            <!-- participants -->
          <div class="col-10 m-2 mx-auto">
              <label for="formParticipants">參與人次*</label>
              <input class="form-control" type="number" min="0" id="formParticipants" name="participants" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($meetings)) ? "" : $meetings->participants ?>">
          </div>


          <!-- chairman -->
          <div class="col-10 m-2 mx-auto">
              <label for="formChairman">主席*</label>
              <input class="form-control" type="text" id="formChairman" name="chairman" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($meetings)) ? "" : $meetings->chairman ?>">
          </div>

          <!-- chairman_background -->
          <div class="col-10 m-2 mx-auto">
              <label for="formChairmanBackground">主席背景*</label>
              <input class="form-control" type="text" id="formChairmanBackground" name="chairmanBackground" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($meetings)) ? "" : $meetings->chairman_background ?>">
          </div>

          <!-- note -->
          <div class="col-10 m-2 mx-auto">
              <label for="formNote">備註*</label>
              <textarea class="form-control" id="formNote" class="materialize-textarea" placeholder="" name="note" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?>><?php echo (empty($meetings)) ? "" : $meetings->note ?></textarea>
          </div>

          <?php if ($hasDelegation != '0'): ?>
          <div class="row">
            <div class="d-grid gap-2 col-2 mx-auto">
              <button class="btn btn-primary m-3" type="submit">建立</button>
            </div>
          </div>
          <?php endif;?>
        </form>
      <!-- </div> -->
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo site_url(); ?>assets/js/ElementBinder.js"></script>
<script type="text/javascript">
  // const elementRelation = new ElementBinder();
  // elementRelation.selectInput('meetingType', 'chairman', '跨局處會議');
  // elementRelation.selectInput('meetingType', 'chairmanBackground', '跨局處會議');
  // elementRelation.selectInput('meetingType', 'participants', '預防性講座');

</script>

<?php $this->load->view('templates/new_footer');?>