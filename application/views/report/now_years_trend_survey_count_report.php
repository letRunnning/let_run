<?php $this->load->view('templates/new_header'); ?>
<div class="breadcrumb-div">
	<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item active" style="color:blue;" aria-current="page">
				<a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
			</li>
			<li class="breadcrumb-item active" style="color:blue;" aria-current="page">
				<a href="#"><?php echo '報表管理'; ?></a>
			</li>
			<li class="breadcrumb-item active" style="color:blue;" aria-current="page">
				<a href="<?php echo site_url('/report/counseling_member_count_report_table/' . $yearType . '/' . $monthType); ?>"><?php echo '每月執行進度表清單'; ?></a>
			</li>
			<li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
		</ol>
	</nav>
</div>
<div class="container" style="width: 100%;">
	<div class="row">
		<div class="card-body col-sm-12">
			<!-- <div class="row">
				<div class="col-sm-6">
					<a class="btn btn-success" style="margin:10px;" href="<?php echo site_url('/report/counseling_member_count_report_table/' . $yearType . '/' . $monthType); ?>">←每月執行進度表清單</a>
				</div>
			</div> -->
			<h4 class="card-title text-center"><?php echo $title ?></h4>

			<div class="card-content">
				<form action="<?php echo site_url($url); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
					<input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />

					<?php echo isset($error) ? '<p class="text-danger text-center">' . $error . '</p>' : ''; ?>
					<?php echo isset($success) ? '<p class="text-success text-center">' . $success . '</p>' : ''; ?>


					<!-- <div class="row">
            <div class="input-field col s10 offset-m2 m8">
              <select name="county" <?php echo (empty($projects)) ? "" : "disabled" ?>>
                <?php if (empty($projects->county)) { ?>
                  <option disabled selected value>請選擇</option>
                  <?php }
								foreach ($counties as $i) {
									if (!empty($projects->county)) {
										if ($i['no'] == $projects->county) { ?>
                      <option selected value="<?php echo $i['no']; ?>"><?php echo $i['name']; ?></option>
                    <?php } else { ?>
                      <option value="<?php echo $i['no']; ?>"><?php echo $i['name']; ?></option>
                    <?php }
									} else { ?>
                    <option value="<?php echo $i['no']; ?>"><?php echo $i['name']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
              <label>縣市</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s10 offset-m2 m8">
              <input type="text" id="orgnizer" name="orgnizer" value="<?php echo (empty($countyAndOrg)) ? "" : $countyAndOrg->orgnizer ?>" <?php echo (empty($countyAndOrg)) ? "" : "readOnly=readOnly" ?>>
              <label for="orgnizer">承辦單位</label>
            </div>
          </div>

					<div class="row">
            <div class="input-field col s10 offset-m2 m8">
              <input type="text" id="name" name="name" value="<?php echo (empty($countyAndOrg)) ? "" : $countyAndOrg->organizationName ?>" <?php echo (empty($countyAndOrg)) ? "" : "readOnly=readOnly" ?>>
              <label for="name">執行單位</label>
            </div>
          </div> -->
          <?php $this->load->view('report/templates/month_report_track_table');?>


          <br/><br />

					<div class="row justify-content-center">
						<div class="col-sm-10 col-md-8">
							<label for="note" class="form-label">備註*</label>
							<textarea required id="note" class="form-control" name="note" style="height: 100px"<?php echo ($nowYearsTrendSurveyCountReports) ? '' : '' ?>><?php echo (empty($nowYearsTrendSurveyCountReports)) ? $noteDetail : $nowYearsTrendSurveyCountReports->note ?></textarea>
						</div>
					</div>


					<br />

					<?php if ($reportLogs) : ?>
						<h5 class="text-center"><?php echo '審核流程' ?></h5>

						<div class="table-responsive">
							<table class="table table-hover table-bordered align-middle text-center">
								<thead class="header">
								<tr>
									<th scope="col">使用者姓名</th>
									<th scope="col">時間</th>
									<th scope="col">狀態</th>
									<th scope="col">評論</th>
								</tr>
							</thead>

							<?php foreach ($reportLogs as $value) { ?>
								<tbody>
									<tr>
										<td><?php echo $value['userName'] ?></php>
										</td>
										<td><?php echo $value['time'] ?></php>
										</td>
										<td><?php foreach ($processReviewStatuses as $i) {
													if ($i['no'] == $value['review_status']) {
														echo $i['content'];
													}
												} ?></php>
										</td>
										<td><?php echo $value['comment'] ?></php>
										</td>

									</tr>

								</tbody>
							<?php } ?>

						</table>
						</div>
					<?php endif; ?>

					<br />
					<br />

					<?php if ($reportProcessesCounselorStatus != $reviewStatus['review_process_pass']) : ?>

						<div class="row justify-content-center">
							<div class="d-grid gap-2 col-sm-6 col-md-4 mb-3">
							<button class="btn btn-primary" type="submit">暫存</button>
						</div>
						</div>

						<div class="row justify-content-center">
							<div class="d-grid gap-2 col-sm-6 col-md-4 mb-3">
							<button class="btn btn-primary" name="save" value="Save" type="submit">送出</button>
						</div>
						</div>

					<?php else: ?>

					<div class="row justify-content-center">
						<div class="d-grid gap-2 col-sm-6 col-md-4 mb-3">
							<a class="btn btn-primary" href="<?php echo site_url('report/now_years_trend_survey_count_report_organization_table/' . $yearType . '/' . $monthType); ?>">預覽縣市承辦人端</a>
						</div>
					</div>
					
<br/>  <br/>

          <?php endif;?>

				</form>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('templates/new_footer'); ?>
