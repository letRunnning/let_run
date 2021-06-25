<?php $this->load->view('templates/new_header');?>
<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">縣市與計畫案管理</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/project/manage_county_and_project_table'); ?>">縣市計畫案管理</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title;?></li>
    </ol>
  </nav>
</div>

<div class="container" style="width:100%;">
	<div class="row">
		<div class="card-body col-sm-12">
      <h4 class="card-title text-center"><?php echo $title ?></h4>
      <div class="card-content">  
        <form action="<?php echo site_url($url);?>" 
          method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />
          <?php echo isset($error) ? '<p class="red-text text-darken-1 text-center">'.$error.'</p>' : '';?>
          <?php echo isset($success) ? '<p class="green-text text-accent-4 text-center">'.$success.'</p>' : '';?>
       
          <h6 class="text-center">縣市: <?php echo $counties->name; ?></h6>

          <!-- date -->
          <div class="col-10 m-2 mx-auto">
            <label for="formDate">撥付日期*:</label>
              <input class="form-control datepickerTW" value="<?php echo (empty($fundingApproves)) ? "" : $fundingApproves->date ?>">
          </div>

          <div class="col-10 m-2 mx-auto">
            <label for="funding">撥付金額</label>
            <input class="form-control" required type="number" min ="0" id="funding" name="funding" value="<?php echo (empty($fundingApproves)) ? "" : $fundingApproves->funding ?>" <?php echo (empty($counselingMemberCountReport->funding_execute)) ? "" : "" ?>>
          </div>

      
          <!-- trendDescription -->
          <div class="col-10 m-2 mx-auto">
            <div class="input-group">
              <label class="input-group-text" for="formNote">備註</label>
              <textarea class="form-control" id="formNote" name="note" class="materialize-textarea" ><?php echo (empty($fundingApproves)) ? "" : $fundingApproves->note ?></textarea>
            </div>
          </div>
          <div class="row">
            <div class="d-grid gap-2 col-2 mx-auto">
              <button class="btn btn-primary m-3" type="submit">建立</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo site_url();?>assets/js/ElementBinder.js"></script>
<script type="text/javascript">
  $('.datepickerTW').datepickerTW();
  const elementRelation = new ElementBinder();
  elementRelation.selectInput('isCounseling', 'trend', '否');
  elementRelation.selectInput('isCounseling', 'trendDescription', '否');

</script>
<?php $this->load->view('templates/new_footer');?>