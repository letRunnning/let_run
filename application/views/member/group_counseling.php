<?php $this->load->view('templates/new_header');?>

<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">輔導會談(措施A)</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/member/get_group_counseling_table_by_organization'); ?>" <?php echo $url == '/member/get_group_counseling_table_by_organization' ? 'active' : ''; ?>>團體輔導紀錄清單</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>

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
        
          <!-- title -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formTitle" class="form-label">單元名稱*</label>
              <input class="form-control" type="text" id="formTitle" name="title" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($groupCounselings)) ? "" : $groupCounselings->title ?>">
            </div>
          </div>

          <!-- startTime -->
          <div class="row">
            <div class="input-field col s10 offset-m2 m8">
              <input type="text" id="formStartTime" name="startTime" required class="datetimepicker"  value="<?php echo (empty($groupCounselings)) ? "" : $groupCounselings->start_time ?>">
              <label for="formStartTime">開始時間*</label>
            </div>
          </div>

          <!-- endTime -->
          <div class="row">
            <div class="input-field col s10 offset-m2 m8">
              <input type="text" id="formEndTime" name="endTime" required class="datetimepicker" value="<?php echo (empty($groupCounselings)) ? "" : $groupCounselings->end_time ?>">
              <label for="formEndTime">結束時間*</label>
            </div>
          </div>

          <!-- durationHour -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formDurationHour" class="form-label">諮詢歷時(小時)*</label>
              <input readonly placeholder="1" class="form-control" type="number" id="formDurationHour" name="durationHour" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($groupCounselings)) ? "" : $groupCounselings->duration_hour ?>">
            </div>
          </div>

          <!-- serviceTarget -->
          <div class="col-10 m-2 mx-auto">
            <label>團體目標與內容</label>
            <div class="input-group">
              <select class="form-select" name="serviceTarget" <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?>>
              <?php if (empty($groupCounselings->service_target)) { ?>
                <option disabled selected value>請選擇</option>
                <?php } foreach ($serviceTargets as $i) {
                  if (!empty($groupCounselings->service_target)) {
                    if ($i['no'] == $groupCounselings->service_target) { ?>
                      <option selected value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                    <?php } else { ?>
                      <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                    <?php }
                  } else { ?>
                    <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>

          <!-- serviceTargetOther -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formServiceTargetOther" class="form-label">團體目標-其他</label>
              <input class="form-control" type="text" id="formServiceTargetOther" name="serviceTargetOther" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($groupCounselings)) ? "" : $groupCounselings->service_target_other ?>">
            </div>
          </div>

          <div class="col-2 mx-auto">
            <a class="btn btn-info my-3" href="<?php echo site_url("/member/group_counseling_participants/" . $groupCounselings->no); ?>">新增</a>
          </div>


          <?php foreach($participants as $i) { ?>
              <h5 class="text-center"><?php echo $i['system_no'] . '  ' . $i['name'];?></h5>
              <?php if(count($participants) > 1):?>
              <a class='btn btn-warning' href='<?php echo site_url("/member/group_counseling_participants_delete/" . $i['no'] . "/" . $groupCounselings->no); ?> '>刪除</a>
              <?php endif;?>
             <!-- isPunctual -->
              <div class="col-10 m-2 mx-auto">
                <label>準時出席</label>
                <div class="input-group">
                  <select class="form-select" name="isPunctual[]" <?php echo ($hasDelegation == '0') ? 'disabled' : '' ?>>
                  <?php if (isset($i['is_punctual'])) {
                      if ($i['is_punctual'] == "1") { ?>
                      <option value="1" selected>是</option>
                      <option value="0">否</option>
                    <?php } else { ?>
                      <option value="1">是</option>
                      <option value="0" selected>否</option>
                    <?php }
                    } else { ?>
                      <option disabled selected value>請選擇</option>
                      <option value="1">是</option>
                      <option value="0">否</option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <!-- participationLevel -->
              <div class="row">
                <div class="col-10 m-2 mx-auto">
                  <label for="formParticipationLevel" class="form-label">參與程度(1-5)</label>
                  <input class="form-control" type="number" min="0" id="formParticipationLevel" min="0" name="participationLevel[]" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?> value="<?php echo (empty($i['participation_level'])) ? "0" : $i['participation_level'] ?>">
                </div>
              </div>

              <!-- descriptionOther -->
              <div class="row">
                <div class="col-10 m-2 mx-auto">
                  <label for="formDescriptionOther" class="form-label">其他敘述</label>
                  <textarea class="form-control" id="formDescriptionOther" name="descriptionOther[]" placeholder="對於汽修專業很感興趣，但其他人分享時就會分心" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?>><?php echo (empty($i['description_other'])) ? "" : $i['description_other'] ?></textarea>
                </div>
              </div>

            <?php
            }
          ?>

          <!-- importantEvent -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formImportantEvent" class="form-label">重要事件</label>
              <textarea class="form-control" id="formImportantEvent" name="importantEvent" placeholder="與團體成員互動熱絡,但因語言表達較弱，偶爾會因他人的回饋有受挫的經驗" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?>><?php echo (empty($groupCounselings)) ? "" : $groupCounselings->important_event ?></textarea>
            </div>
          </div>

          <!-- evaluation -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formEvaluation" class="form-label">整體評估</label>
              <textarea class="form-control" id="formEvaluation" name="evaluation" placeholder="對汽修的熱情堅定，將於第一梯生涯探索課程結束後協助個案進行工作體驗" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?>><?php echo (empty($groupCounselings)) ? "" : $groupCounselings->evaluation ?></textarea>
            </div>
          </div>

          <!-- review -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formReview" class="form-label">檢討/建議</label>
              <textarea class="form-control" id="formReview" name="review" placeholder="對約定的時間將更嚴格實行，並訂定獎懲機制" <?php echo ($hasDelegation == '0') ? 'readonly' : '' ?>><?php echo (empty($groupCounselings)) ? "" : $groupCounselings->review ?></textarea>
            </div>
          </div>
          
          <?php if($hasDelegation != '0'): ?>
          <div class="row">
            <div class="d-grid gap-2 col-2 mx-auto">
              <button class="btn btn-primary my-5" type="submit">建立</button>
            </div>
          </div>
          <?php endif;?>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo site_url();?>assets/js/ElementBinder.js"></script>
<script type="text/javascript">
  const elementRelation = new ElementBinder();
  elementRelation.selectInput('serviceTarget', 'serviceTargetOther', '其他');

  document.addEventListener('DOMContentLoaded', function() {
    const selects = document.querySelectorAll('select');
    M.FormSelect.init(selects, {});
    const endTimeSelects = document.querySelectorAll('select[target="formEndTime"]');
    for ( i=0, n=endTimeSelects.length; i < n; i++) {
      endTimeSelects[i].addEventListener("change", myFunction);
    }
  });

  document.addEventListener('DOMContentLoaded', function() {
    const selects = document.querySelectorAll('select');
    M.FormSelect.init(selects, {});
    const startTimeSelects = document.querySelectorAll('select[target="formStartTime"]');
    for ( i=0, n=startTimeSelects.length; i < n; i++) {
      startTimeSelects[i].addEventListener("change", myFunction);
    }
  });
  function myFunction() {
    //value start
    const startTimeSelects = document.querySelectorAll('select[target="formStartTime"]');
    
    var startYear = startTimeSelects[0].value;
    var startMonth = startTimeSelects[1].value;
    var startDay = startTimeSelects[2].value;
    var startHour = startTimeSelects[3].value;
    var startMin = startTimeSelects[4].value;
    var startTime = startYear + '-' + startMonth + '-' + startDay + ' ' + startHour + ':' + startMin + ':00'; 

    const endTimeSelects = document.querySelectorAll('select[target="formEndTime"]');
    
    var endYear = endTimeSelects[0].value;
    var endMonth = endTimeSelects[1].value;
    var endDay = endTimeSelects[2].value;
    var endHour = endTimeSelects[3].value;
    var endMin = endTimeSelects[4].value;
    var endTime = endYear + '-' + endMonth + '-' + endDay + ' ' + endHour + ':' + endMin + ':00'; 

    // var start = Date.parse($('input[name="startTime"]').val()); //get timestamp

    // //value end
    // var end = Date.parse($('input[name="endTime"]').val()); //get timestamp

    var start = Date.parse(startTime); //get timestamp

    //value end
    var end = Date.parse(endTime); //get timestamp

    totalHours = NaN;
  
    if (start < end) {
      totalHours = (end - start) / 1000 / 60 /60 ; //milliseconds: /1000 / 60 / 60
    }
    $("#formDurationHour").val(totalHours);
  }

</script>

<?php $this->load->view('templates/new_footer');?>
