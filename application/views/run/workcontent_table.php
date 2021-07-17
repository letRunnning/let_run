<?php $this->load->view('templates/new_header');?>
<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="#">路跑活動</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
    </ol>
  </nav>
</div>

<div class="container" style="width:95%">
  <div class="row justify-content-center">
    <div class="col-4 text-right">
        <!-- <label for="runActive" style="text-align:right;" class="col-form-label">搜尋</label> -->
        <!-- <input id="myInput" class="form-control" type="search" onkeyup="myFunction('all_counselor')" placeholder="搜尋路跑活動"> -->
        <!-- <label>路跑活動</label> -->
        <select onchange="location = this.value;" class="form-select mb-3" name="runActive" id="G-runActive" >
        <?php if(empty($workgroupInfo->name)){?>
          <option selected value="<?php echo site_url('run/workcontent_table/'); ?>">請選擇路跑活動</option>
          <?php foreach($activities as $i) {?>
          <!-- <option  value="<?php echo $i['running_ID'] ?>"><?php echo $i['name'];?></option> -->
          <option  <?php echo ($runID == $i['running_ID']) ? 'selected' : '' ?> value="<?php echo site_url('run/workcontent_table/'.$i['running_ID']); ?>" ><?php echo $i['name']?></option>
          <?php } }else{ ?>
            <option  value="<?php echo $workgroupInfo->running_ID?>"><?php echo $workgroupInfo->name?></option>
            <?php } ?>
        </select>
    </div>
        <div class="col-2 text-left">
            <a type="button" class="btn btn-info" href="<?php echo site_url('run/workcontent/' );?>">新增</a>
    </div>
  </div>

  <br>
  
  <?php if(!empty($workcontents)){?>
  <table class="table text-center border-secondary table-hover align-middle">
    <thead class="header" style="background-color:#C8C6A7">
      <tr>
        <th scope="col">工作地點</th>
        <th scope="col">工作內容</th>
        <th scope="col">要項</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($workcontents as $i) { ?>
      <tr>
        <th scope="col"><?php echo $i['place']?></th>
        <th scope="col"><?php echo $i['content']?></th>
        <td scope="col"><a type="button" class="btn btn-warning" href="<?php echo site_url('run/workcontent/'.$runID.'/'.$i['work_ID']  );?>">編輯/查看</a></td>
      </tr>
      <?php } ?>
    </tbody>
</table>
<?php }else{ ?>
    <div class="d-grid gap-2 col-2 mx-auto fs-5">
        <span>尚無資料</span>
  </div>
    <?php } ?>
</div>



<?php $this->load->view('templates/new_footer');?>