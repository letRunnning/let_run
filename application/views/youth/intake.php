<?php $this->load->view('templates/new_header');?>

<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">評估開案</a>
      </li>
      <?php if ($comePage == "allSource"): ?>
        <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
          <a href="<?php echo site_url('/youth/get_all_source_youth_table'); ?>">原始來源清單</a>
        </li>
      <?php elseif ($comePage == "allYouth"): ?>
        <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
          <a href="<?php echo site_url('/youth/get_all_youth_table'); ?>">需關懷追蹤青少年清單</a>
        </li>
      <?php elseif ($comePage == "member"): ?>
        <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
          <a href="<?php echo site_url('/member/get_member_table_by_counselor'); ?>">學員清單</a>
        </li>  
      <?php endif;?>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    
    </ol>
  </nav>
</div>

<div class="container" style="width:100%;">
	<div class="row">
		<div class="card-body col-sm-12">

  <!-- <div class="row">
    <?php if ($comePage == "allSource"): ?>
      <div class="col-md-12" style="text-align:left;">
        <a class="btn btn-warning" style="margin:10px;" href="<?php echo site_url('/youth/get_all_source_youth_table'); ?>">←原始來源清單</a>
      </div>
    <?php elseif ($comePage == "allYouth"): ?>
      <div class="col-md-12" style="text-align:left;">
        <a class="btn btn-warning" style="margin:10px;" href="<?php echo site_url('/youth/get_all_youth_table'); ?>">←需關懷追蹤青少年清單</a>
      </div>
    <?php elseif ($comePage == "member"): ?>
      <div class="col-md-12" style="text-align:left;">
        <a class="btn btn-warning" style="margin:10px;" href="<?php echo site_url('/member/get_member_table_by_counselor'); ?>">←學員清單</a>
      </div>
      <?php endif;?>
  </div> -->
  <div class="col-md-12">
    <h4 class="text-dark text-center"><?php echo $title ?></h4>
  </div>

  <div class="col-md-12">
    <form action="<?php echo site_url($url); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
      <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>"
        value="<?php echo $security->get_csrf_hash() ?>" />

      <?php echo isset($error) ? '<p class="red-text text-darken-3 text-center">' . $error . '</p>' : ''; ?>
      <?php echo isset($success) ? '<p class="green-text text-darken-3 text-center">' . $success . '</p>' : ''; ?>

    <h5 class="card-title text-center text-center">轉介單位基本資料</h5>
      <div class="row g-4">
        <!-- referralInstitution -->
        <div class="col-10 m-2 mx-auto">
          <!-- <div class="form-floating"> -->
            <label for="floatingInputGrid">名稱</label>
            <input type="text" class="form-control" id="formReferralInstitution" name="referralInstitution" placeholder="轉介單位"
            value="<?php echo (empty($intakes)) ? "無" : $intakes->referral_institution ?>">
          <!-- </div> -->
        </div>
        <!-- referralName -->
        <div class="col-10 m-2 mx-auto">
          <!-- <div class="form-floating"> -->
            <label for="floatingInputGrid">聯絡人</label>
            <input type="text" class="form-control" id="formReferralName" name="referralName" placeholder="轉介人"
            value="<?php echo (empty($intakes)) ? "無" : $intakes->referral_name ?>">
          <!-- </div> -->
        </div>
        <!-- referralPhone -->
        <div class="col-10 m-2 mx-auto">
          <!-- <div class="form-floating"> -->
            <label for="floatingInputGrid">電話</label>
            <input type="text" class="form-control" id="formReferralPhone" name="referralPhone" placeholder="00-0000000"
            value="<?php echo (empty($intakes)) ? "無" : $intakes->referral_phone ?>">
          <!-- </div> -->
        </div>
      </div>

    <h5 class="card-title text-center text-center">轉介單位的處遇概況</h5>
      
    <!-- referralTarget -->
      <div class="col-10 m-2 mx-auto">
        <div class="form-group">
          <label for="exampleFormControlTextarea1">服務目標與處遇:</label>
          <textarea class="form-control" id="formReferralTarget" name="referralTarget"
          placeholder="因校園霸凌轉介至本校輔導室，服務目標為協助個案穩定身心並持續就學"><?php echo (empty($intakes)) ? "無" : $intakes->referral_target ?></textarea>
        </div>
      </div>
    </div>

    <div class="row">
      <!-- referralAttitude -->
      <div class="col-10 m-2 mx-auto">
        <label for="formReferralAttitudeOther">處遇態度</label>
          <select name="referralAttitude" class="form-select">
          <?php if (empty($intakes->referral_attitude)) {?>
          <option disabled selected value>請選擇</option>
          <?php }
            foreach ($referralAttitudes as $i) {
              if (!empty($intakes->referral_attitude)) {
                  if ($i['no'] == $intakes->referral_attitude) {?>
                          <option selected value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                          <?php } else {?>
                          <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                          <?php }
                  } else {?>
                      <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                      <?php }?>
                <?php }?>
          </select>
      </div>
      

    <!-- referralAttitudeOther -->
    <div class="row">
      <div class="col-10 m-2 mx-auto">
        <label for="formReferralAttitudeOther">處遇態度-其他</label>
        <textarea class="form-control" id="formReferralAttitudeOther"
          name="referralAttitudeOther"><?php echo (empty($intakes)) ? "" : $intakes->referral_attitude_other ?></textarea>
      </div>
    </div>

    <h5 class="card-title text-center">青少年基本資料</h5>

    <!-- identification -->
    <!-- <div class="row"> -->
    <div class="col-10 m-2 mx-auto">
        <label for="formIdentification">身分證</label>
        <input class="form-control" type="text" id="formIdentification" name="identification" placeholder="A000000000"
          value="<?php echo (empty($youths)) ? "" : $youths->identifications ?>"
          <?php echo (empty($youths)) ? "" : "" ?>>
      </div>
    
    <!-- name -->
    <div class="col-10 m-2 mx-auto">
        <label for="formName">姓名*</label>
        <input class="form-control" type="text" id="formName" name="name" placeholder="范立人" required
          value="<?php echo (empty($youths)) ? "" : $youths->name ?>"
          <?php echo (empty($youths)) ? "" : "" ?>>
      </div>

    <!-- birth -->
    <div class="row">
      <div class="col-10 m-2 mx-auto">
        <label for="formBirth">出生年月日</label>
        <input class="form-control datepickerTW" type="text" id="formBirth" name="birth"
          value="<?php echo (empty($youths)) ? "" : $youths->birth ?>"
          <?php echo (empty($youths)) ? "" : "" ?>>
      </div>
    </div>

    <!-- gender -->
      <div class="col-10 m-2 mx-auto">
        <label>性別</label>
        <select class="form-select" name="gender" <?php echo (empty($youths->gender)) ? "" : "" ?>>
          <?php if (empty($youths->gender)) {?>
          <option disabled selected value>請選擇</option>
          <?php }
            foreach ($genders as $i) {
                if (!empty($youths->gender)) {
                  if ($i['no'] == $youths->gender) {?>
                    <option selected value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>  <?php } else {?>
                    <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                    <?php }
                    } else {?>
                          <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>  <?php }?>
              <?php }?>
        </select>
      </div>

    <!-- phone -->
      <div class="col-10 m-2 mx-auto">
        <label for="formPhone">電話</label>
        <input class="form-control" type="text" id="formPhone" name="phone" placeholder="0900-000-000"
          value="<?php echo (empty($youths)) ? "" : $youths->phone ?>"
          <?php echo (empty($youths)) ? "" : "" ?>>
      </div>
    </div>

    <!-- householdAddress -->
    <div class="row">
      <div class="col-10 m-2 mx-auto">
        <label for="formHouseholdAddress">戶籍地址</label>
        <input class="form-control" type="text" id="formHouseholdAddress" name="householdAddress" placeholder="個案地址"
          value="<?php echo (empty($youths)) ? "" : $youths->household_address_aes ?>"
          <?php echo (empty($youths)) ? "" : "" ?>>
      </div>
    </div>

    <!-- resideAddress -->
    <div class="row">
      <div class="col-10 m-2 mx-auto">
        <label for="formResideAddress">居住地址</label>
        <input class="form-control" type="text" id="formResideAddress" name="resideAddress" placeholder="個案地址"
          value="<?php echo (empty($youths)) ? "" : $youths->reside_address_aes ?>"
          <?php echo (empty($youths)) ? "" : "" ?>>
      </div>
    </div>
    

    <!-- juniorSchool -->
    <div class="row">
      <div class="col-10 m-2 mx-auto">
        <label for="formJuniorSchoolOne">國中學校</label> 
        <input class="form-control" type="text" id="formJuniorSchoolOne" name="juniorSchoolOne"
          value="<?php echo (empty($youths)) ? "" : ($youths->junior_school ? explode("/", $youths->junior_school)[0] : "");?>">
      </div>
    </div>

      <div class="row">
        <div class="col-10 m-2 mx-auto">
          <label for="formJuniorSchoolTwo">年級</label>
          <input class="form-control" type="text" id="formJuniorSchoolTwo" name="juniorSchoolTwo"
            value="<?php echo (empty($youths)) ? "" : ($youths->junior_school ? explode("/", $youths->junior_school)[1] : ""); ?>">
        </div>
      </div>

      <div class="row">
        <div class="col-10 m-2 mx-auto">
          <label for="formJuniorSchoolThree">科系</label>
          <input class="form-control" type="text" id="formJuniorSchoolThree" name="juniorSchoolThree"
            value="<?php echo (empty($youths)) ? "" : ($youths->junior_school ? explode("/", $youths->junior_school)[2] : ""); ?>">
        </div>
      </div>

      <!-- juniorGraduateYear -->
      <div class="row">
        <div class="col-10 m-2 mx-auto">
          <label for="formJuniorGraduateYear">國中畢業年度(填寫「年度」非「學年度，並請填列民國年」)</label>
          <input class="form-control" type="number" min="0" id="formJuniorGraduateYear" name="juniorGraduateYear"
            value="<?php echo (empty($youths)) ? "" : $youths->junior_graduate_year ?>"
            <?php echo (empty($youths)) ? "" : "" ?>>
        </div>
      </div>

      <!-- juniorDropoutRecord -->
      <div class="row">
        <div class="col-10 m-2 mx-auto">
          <label>國中是否曾有中輟通報紀錄</label>
          <select class="form-select" name="juniorDropoutRecord" <?php echo (empty($youths)) ? "" : "" ?>>
            <?php if (isset($youths->junior_dropout_record)) {
if ($youths->junior_dropout_record == "1") {?>
            <option value="1" selected>是</option>
            <option value="0">否</option>
            <?php } else {?>
            <option value="1">是</option>
            <option value="0" selected>否</option>
            <?php }
} else {?>
            <option disabled selected value>請選擇</option>
            <option value="1">是</option>
            <option value="0">否</option>
            <?php }?>
          </select>
        </div>
      </div>

    <!-- guardianName --> 
    <div class="row">
      <div class="col-10 m-2 mx-auto">
        <label for="formGuardianName">監護人姓名</label>
        <input class="form-control" type="text" id="formGuardianName" name="guardianName" placeholder="OOO"
          value="<?php echo (empty($youths)) ? "" : $youths->guardian_name ?>"
          <?php echo (empty($youths)) ? "" : "" ?>>
      </div>
    </div>

    <!-- guardianShip -->
    <div class="row">
      <div class="col-10 m-2 mx-auto">
        <label for="formGuardianship">監護人關係</label>
        <input class="form-control" type="text" id="formGuardianship" name="guardianShip" placeholder="父子"
                value="<?php echo (empty($youths)) ? "" : $youths->guardianship ?>"
                <?php echo (empty($youths)) ? "" : "" ?>>
      </div>
    </div>

    <!-- guardianPhone -->
    <div class="row">
      <div class="col-10 m-2 mx-auto">
        <label for="formGuardianPhone">監護人電話</label>
        <input class="form-control" type="text" id="formGuardianPhone" name="guardianPhone" placeholder="0000-000-000"
                value="<?php echo (empty($youths)) ? "" : $youths->guardian_phone ?>"
                <?php echo (empty($youths)) ? "" : "" ?>>
      </div>
    </div>

    <!-- guardianHouseholdAddress -->
    <div class="row">
      <div class="col-10 m-2 mx-auto">
        <p><label>
            <input type="checkbox" class="form-check-input" name="guardianHouseholdAddressSame" value="1"
              <?php echo (empty($youths)) ? "" : "" ?> <?php if (!empty($youths)) {if ($youths->household_address_aes == $youths->guardian_household_address_aes) {
                echo "checked";} else {  "";  }} else {
                      "";  }?>>
                  <span>同個案</span>
                </label></p>
              <label for="formGuardianHouseholdAddress">監護人戶籍地址</label>
              <input class="form-control" type="text" id="formGuardianHouseholdAddress" name="guardianHouseholdAddress" placeholder="個案地址"
                value="<?php echo (empty($youths)) ? "" : $youths->guardian_household_address_aes ?>"
                <?php echo (empty($youths)) ? "" : "" ?>>
            </div>
          </div>

          <!-- guardianResideAddress -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <p><label>
                  <input type="checkbox" class="form-check-input" name="guardianResideAddressSame" value="1"
                    <?php echo (empty($youths)) ? "" : "" ?> <?php if (!empty($youths)) {if ($youths->reside_address_aes == $youths->guardian_reside_address_aes) {
                          echo "checked";
                      } else {
                          "";
                      }}?>>
                  <span>同個案</span>
                </label></p>
              <label for="formGuardianResideAddress">監護人居住地址</label>
              <input class="form-control" type="text" id="formGuardianResideAddress" name="guardianResideAddress" placeholder="個案地址"
                value="<?php echo (empty($youths)) ? "" : $youths->guardian_reside_address_aes ?>"
                <?php echo (empty($youths)) ? "" : "" ?>>
            </div>
          </div>

          <?php if (!empty($youths)) {?>
          <!-- source -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label>青少年來源</label>
              <select class="form-select" name="source" <?php echo (empty($youths)) ? "" : "" ?>>
                <?php if (empty($youths->source)) {?>
                <option disabled selected value>請選擇</option>
                <?php }
    foreach ($sources as $i) {
        if (!empty($youths->source)) {
            if ($i['no'] == $youths->source) {?>
                <option selected value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                <?php } else {?>
                <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                <?php }
        } else {?>
                <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                <?php }?>
                <?php }?>
              </select>
            </div>
          </div>

          <!-- sourceSchoolYear -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formSourceSchoolYear">動向調查學年度</label>
              <input class="form-control" type="number" min="0" id="formSourceSchoolYear" name="sourceSchoolYear"
                value="<?php echo (empty($youths)) ? "" : $youths->source_school_year ?>"
                <?php echo (empty($youths)) ? "" : "" ?>>
            </div>
          </div>

          <!-- surveyType -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label>動向調查類別</label>
              <select class="form-select" name="surveyType" <?php echo (empty($youths)) ? "" : "" ?>>
                <?php if (empty($youths->survey_type)) {?>
                <option disabled selected value>請選擇</option>
                <?php }
    foreach ($surveyTypes as $i) {
        if (!empty($youths->survey_type)) {
            if ($i['no'] == $youths->survey_type) {?>
                <option selected value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                <?php } else {?>
                <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                <?php }
        } else {?>
                <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                <?php }?>
                <?php }?>
              </select>
            </div>
          </div>

  <?php }?>

          <h5 class="card-title text-center">青少年主要需求</h5>

          <!-- majorDemand -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label>主要需求</label>
              <select class="form-select" name="majorDemand">
                <?php if (empty($intakes->major_demand)) {?>
                <option disabled selected value>請選擇</option>
                <?php }
foreach ($majorDemands as $i) {
    if (!empty($intakes->major_demand)) {
        if ($i['no'] == $intakes->major_demand) {?>
                <option selected value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                <?php } else {?>
                <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                <?php }
    } else {?>
                <option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
                <?php }?>
                <?php }?>
              </select>
              
            </div>
          </div>

          <!-- majorDemandOther -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label for="formMajorDemandOther">主要需求-其他</label>
              <textarea class="form-control" id="formMajorDemandOther" class="materialize-textarea"
                name="majorDemandOther"><?php echo (empty($intakes)) ? "" : $intakes->major_demand_other ?></textarea>
            </div>
          </div>

             <!-- isWant -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label>是否願意加入本計畫</label>
              <select class="form-select" name="isWant">
                <?php if (isset($intakes->is_want)) {
    if ($intakes->is_want == "1") {?>
                    <option disabled value>請選擇</option>
                    <option value="1" selected>是</option>

                <?php } else {?>
                  <option disabled value>請選擇</option>
                  <option value="1">是</option>
                  <option value="0" selected>否</option>
                <?php }
} else {?>
                  <option disabled selected value>請選擇</option>
                  <option value="1">是</option>
                  <option value="0">否</option>
                <?php }?>
              </select>
              
            </div>
          </div>

          <!-- openCase -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label>經評估是否開案</label>
              <select class="form-select" name="openCase">
                <?php if (isset($intakes->open_case)) {
    if ($intakes->open_case == "1") {?>
                    <option disabled value>請選擇</option>
                    <option value="1" selected>是</option>

                  <?php } else {?>
                    <option disabled value>請選擇</option>
                    <option value="1">是</option>
                    <option value="0" selected>否</option>
                  <?php }
} else {?>
                  <option disabled selected value>請選擇</option>
                  <option value="1">是</option>
                  <option value="0">否</option>
                <?php }?>
              </select>
              
            </div>
          </div>

          <!-- counselor -->
          <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label>輔導員</label>
              <select class="form-select" name="counselor">
                <?php if (empty($counselorCase)) {?>
                <option disabled selected value>請選擇</option>
                <?php }
foreach ($counselors as $i) {
    if (!empty($counselorCase)) {
        if ($i['no'] == $counselorCase->counselor) {?>
                                  <option selected value="<?php echo $i['no']; ?>"><?php echo $i['userName']; ?></option>
                                  <?php }
    } else {?>
                <option value="<?php echo $i['no']; ?>"><?php echo $i['userName']; ?></option>
                <?php }?>
                <?php }?>
              </select>
            </div>
          </div>

           <!-- conditionOne -->
           <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label>學員已完成投保</label>
              <select class="form-select" name="conditionOne">
                <?php if (isset($intakes->open_case)) {
    if ($intakes->open_case == "1") {?>
                    <option disabled value>請選擇</option>
                    <option value="1" selected>是</option>

                  <?php } else {?>
                    <option disabled value>請選擇</option>
                    <option value="1">是</option>
                    <option value="0" selected>否</option>
                  <?php }
} else {?>
                  <option disabled selected value>請選擇</option>
                  <option value="1">是</option>
                  <option value="0">否</option>
                <?php }?>
              </select>
            </div>
          </div>

             <!-- conditionTwo -->
             <div class="row">
            <div class="col-10 m-2 mx-auto">
              <label>已清楚學員投保期間須涵蓋自開案至結案全程</label>
              <select class="form-select" name="conditionTwo">
                <?php if (isset($intakes->open_case)) {
    if ($intakes->open_case == "1") {?>
                    <option disabled value>請選擇</option>
                    <option value="1" selected>是</option>

                  <?php } else {?>
                    <option disabled value>請選擇</option>
                    <option value="1">是</option>
                    <option value="0" selected>否</option>
                  <?php }
} else {?>
                  <option disabled selected value>請選擇</option>
                  <option value="1">是</option>
                  <option value="0">否</option>
                <?php }?>
              </select>
            </div>
          </div>


          <div class="row text-center">
            <div class="my-5">
              <button class="btn btn-primary" type="submit" style="width:150px">送出</button>
            </div>
          </div>

        </form>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo site_url(); ?>assets/js/ElementBinder.js"></script>
<script type="text/javascript">
  $('.datepickerTW').datepickerTW();
  const elementRelation = new ElementBinder();
  if(document.querySelector(`input[name="referralAttitude"]`)) {
    elementRelation.selectInput('referralAttitude', 'referralAttitudeOther', '其他');
  }
  elementRelation.selectInput('majorDemand', 'majorDemandOther', '其他');
  document.querySelector(`select[name="source"]`) && elementRelation.selectInput('source', 'sourceSchoolYear', '動向調查');
  document.querySelector(`select[name="source"]`) && elementRelation.selectInput('source', 'surveyType', '動向調查');
  elementRelation.selectInput('isWant', 'openCase', '是');
  elementRelation.selectInput('openCase', 'counselor', '是');
  elementRelation.selectInput('openCase', 'conditionOne', '是');
  elementRelation.selectInput('openCase', 'conditionTwo', '是');


</script>

<?php $this->load->view('templates/new_footer');?>