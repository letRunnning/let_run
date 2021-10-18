<?php $this->load->view('templates/new_header'); ?>
<div class="breadcrumb-div">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" style="color:blue;" aria-current="page">
        <a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
    </ol>
  </nav>
</div>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-4 text-right">
      <select onchange="location = this.value;" class="form-select mb-3" name="runActive" id="G-runActive" >
        <?php if (empty($application->name)) { ?>
          <option selected value="<?php echo site_url('check/staff_apply_table/'); ?>">請選擇路跑活動</option>
          <?php foreach ($activities as $i) { ?>
            <option <?php echo ($runID == $i['running_ID']) ? 'selected' : '' ?> value="<?php echo site_url('check/staff_apply_table/'.$i['running_ID']); ?>" ><?php echo $i['name'] ?></option>
          <?php } } else { ?>
            <option  value="<?php echo $application->running_ID?>"><?php echo $application->name?></option>
            <?php } ?>
        </select>
    </div>
  </div>
  <br>

  <?php if (!empty($applications)) { ?>
    <table class="table text-center border-secondary table-hover align-middle">
      <thead class="header" style="background-color:#C8C6A7">
        <tr>
          <th scope="col">工作人員編號</th>
          <th scope="col">姓名</th>
          <th scope="col">申請之路跑編號</th>
          <th scope="col">申請組別</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($applications as $i) { ?>
          <tr>
            <th scope="col"><?php echo $i['staff_ID']; ?></th>
            <td scope="col"><?php echo $i['name']; ?></td>
            <td scope="col"><?php echo $i['running_ID']; ?></td>
            <td scope="col"><?php echo $i['workgroupName']; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  <?php } else { ?>
    <div class="d-grid gap-2 col-2 mx-auto fs-5">
      <span>尚無資料</span>
    </div>
  <?php } ?>
</div>
<?php $this->load->view('templates/new_footer'); ?>