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
					<a class="btn btn-success" href="<?php echo site_url('/report/counseling_member_count_report_table/' . $yearType . '/' . $monthType); ?>">←每月執行進度表清單</a>
				</div>
			</div> -->
			<h4 class="card-title text-center"><?php echo $title ?></h4>
			<div class="card-content">
				<form action="<?php echo site_url($url); ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
					<?php echo isset($error) ? '<p class="text-danger text-center">' . $error . '</p>' : ''; ?>
					<?php echo isset($success) ? '<p class="text-success text-center">' . $success . '</p>' : ''; ?>
					<input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />
					<!-- years -->
					<div class="row justify-content-center">
						<div class=" col-sm-10 col-md-8 mb-3">
							<label>年度</label>
							<select class="form-select form-select-lg" name="years" id="years" onchange="location = this.value;">

								<?php foreach ($years as $i) { ?>

									<option <?php echo ($yearType == ($i['year'])) ? 'selected' : '' ?> value="<?php echo site_url('/report/counseling_member_count_report_organization_table/' . $i['year'] . '/' . $monthType); ?>"><?php echo $i['year'] ?></option>
								<?php } ?>

							</select>

						</div>
					</div>

					<!-- months -->
					<div class="row justify-content-center">
						<div class=" col-sm-10 col-md-8">
							<label>月份</label>
							<select class="form-select form-select-lg mb-3" name="months" id="months" onchange="location = this.value;">

								<?php foreach ($months as $i) { ?>

									<option <?php echo ($monthType == $i) ? 'selected' : '' ?> value="<?php echo site_url('/report/counseling_member_count_report_organization_table/' . $yearType . '/' . $i); ?>"><?php echo $i ?></option>
								<?php } ?>

							</select>
						</div>
					</div>

					<a class="btn btn-success" href="<?php echo site_url('export/organization_month_report_export/' . 'counselingExecuteReport' . '/' . $yearType . '/' . $monthType); ?>">執行進度列印(下載EXCEL檔)</a>
					<br /><br />
					<a class="btn btn-success" href="<?php echo site_url('export/organization_month_report_export/' . 'counselingMemberCountReport' . '/' . $yearType . '/' . $monthType); ?>">輔導人數統計表列印(下載EXCEL檔)</a>
					<br /><br />

					<?php if ($reportProcessesCounselorStatus == $reviewStatus['review_process_pass']) : ?>

						<table class="table table-hover table-bordered align-middle" style="border:2px grey solid;">
							<thead>
								<tr>
									<th scope="col" rowspan="2">縣市</th>
									<th scope="col" rowspan="2">提案內容</th>
									<th scope="col" rowspan="2">預計輔導</th>
									<th scope="col" rowspan="2">累積輔導</th>
									<th scope="col" colspan="5">具輔導成效</th>
									<th scope="col" rowspan="2">尚無規劃</th>
									<th scope="col" rowspan="2">不可抗力</th>
									<th scope="col" rowspan="2">辦理情形</th>
								</tr>

								<tr>
									<th scope="col">已就學</th>
									<th scope="col">已就業</th>
									<th scope="col">參加職訓</th>
									<th scope="col">其他</th>
									<th scope="col">小計</th>
								</tr>
							</thead>
							<tbody>

								<tr>
									<td><?php echo $countyName; ?></td>
									<td><?php echo str_replace("\n", "<br/>", $projectDetail); ?></td>
									<td class="text-center" style="vertical-align:text-top; "><?php echo $projects->counseling_member ?></td>
									<td class="text-center" style="vertical-align:text-top;"><?php echo $accumCounselingMemberCount ?></td>
									<td class="text-center" style="vertical-align:text-top;"><?php echo (empty($counselingMemberCountReport)) ? "" : $counselingMemberCountReport->school_member; ?></td>
									<td class="text-center" style="vertical-align:text-top;"><?php echo (empty($counselingMemberCountReport)) ? "" : $counselingMemberCountReport->work_member; ?></td>
									<td class="text-center" style="vertical-align:text-top;"><?php echo (empty($counselingMemberCountReport)) ? "" : $counselingMemberCountReport->vocational_training_member; ?></td>
									<td class="text-center" style="vertical-align:text-top;"><?php echo (empty($counselingMemberCountReport)) ? "" : $counselingMemberCountReport->other_member; ?></td>
									<td class="text-center" style="vertical-align:text-top;"><?php echo (empty($counselingMemberCountReport)) ? "" : $counselingMemberCountReport->school_member + $counselingMemberCountReport->work_member + $counselingMemberCountReport->vocational_training_member + $counselingMemberCountReport->other_member; ?></td>
									<td class="text-center" style="vertical-align:text-top;"><?php echo (empty($counselingMemberCountReport)) ? "" : $counselingMemberCountReport->no_plan_member; ?></td>
									<td class="text-center" style="vertical-align:text-top;"><?php echo (empty($counselingMemberCountReport)) ? "" : $counselingMemberCountReport->force_majeure_member; ?></td>
									<td><?php echo str_replace("\n", "<br/>", $executeDetail); ?></td>
								</tr>

							</tbody>
						</table>

					<?php else : ?>
						<h5 class="text-center"><?php echo '輔導員尚未送出報表' ?></h5>
					<?php endif; ?>

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

					<?php if ($reportProcessesCountyStatus == $reviewStatus['review_process_wait'] && $role == 3) : ?>

						<div class="row justify-content-center">
							<div class="col-sm-10 col-md-8">
							<label>審核</label>
								<select class="form-select mb-3" name="reviewStatus" required>
									<?php if ($reportProcessesCountyStatus == $reviewStatus['review_process_wait']) { ?>
										<option disabled selected value>請選擇</option>
										<?php }
									foreach ($processReviewStatuses as $i) {
										if ($reportProcessesCountyStatus != $reviewStatus['review_process_wait']) {
											if ($i['no'] == $reportProcessesCountyStatus) { ?>
												<option selected value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>
												<?php } else {
												if ($i['content'] != '等待送出') { ?>
													<option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>

												<?php }
											}
										} else {
											if ($i['content'] != '等待送出') { ?>
												<option value="<?php echo $i['no']; ?>"><?php echo $i['content']; ?></option>

										<?php }
										} ?>
									<?php } ?>
								</select>
							</div>
						</div>



						<div class="row justify-content-center">
							<div class="col-sm-10 col-md-8 mb-3">
								<label for="formComment" class="form-label">備註*:</label>
								<textarea required id="formComment" class="form-control" placeholder="" name="comment" style="height: 100px"></textarea>
							</div>
						</div>

						<div class="row justify-content-center">
							<div class="col-sm-10 col-md-8 mb-3">
								<?php if ('1 ' != '0') : ?>
									<label for="reportFile" class="form-label">報表電子檔</label>
									<input class="form-control" type="file" name="reportFile">
								<?php endif; ?>
							</div>
						</div>
						
							<?php if (!empty($counselingMemberCountReport->report_file_name)) : ?>
								<?php if (strpos($counselingMemberCountReport->report_file_name, 'pdf') !== false) : ?>
									<a class="col-sm-10 offset-md-2 col-md-8 link-primary" href="<?php echo site_url() . '/files/' . $counselingMemberCountReport->report_file_name; ?>" download="<?php echo $yearType . '年' . $monthType . '月' . $title ?>"><?php echo $yearType . '年' . $monthType . '月' . $title ?></a>
								<?php else : ?>
									<div class="col-sm-10 offset-md-2 col-md-8">
										<img class="figure-img img-fluid" src="<?php echo site_url() . '/files/' . $counselingMemberCountReport->report_file_name; ?>" />
									</div>
								<?php endif; ?>
							<?php endif; ?>

						<div class="row justify-content-center">
							<div class="d-grid gap-2 col-sm-6 col-md-4">
								<button class="btn btn-primary" type="submit">送出</button>
							</div>
						</div>

					<?php elseif ($reportProcessesCountyStatus == $reviewStatus['review_process_pass'] && $role == 3) : ?>


						<div class="row justify-content-center">
							<div class="col-sm-10 col-md-8 mb-2">
								<?php if ('1 ' != '0') : ?>
									<label for="reportFile" class="form-label">報表電子檔</label>
									<input class="form-control" type="file" name="reportFile">
								<?php endif; ?>
							</div>
						</div>

						<?php if (!empty($counselingMemberCountReport->report_file_name)) : ?>
							<?php if (strpos($counselingMemberCountReport->report_file_name, 'pdf') !== false) : ?>
								<a class="col-sm-10 offset-md-2 col-md-8 link-primary" href="<?php echo site_url() . '/files/' . $counselingMemberCountReport->report_file_name; ?>" download="<?php echo $yearType . '年' . $monthType . '月' . $title ?>"><?php echo $yearType . '年' . $monthType . '月' . $title ?></a>
							<?php else : ?>
								<div class="col-sm-10 offset-md-2 col-md-8">
									<img class="figure-img img-fluid" src="<?php echo site_url() . '/files/' . $counselingMemberCountReport->report_file_name; ?>" />
								</div>
							<?php endif; ?>
						<?php endif; ?>

						<div class="row justify-content-center">
							<div class="d-grid gap-2 col-sm-6 col-md-4">
								<button class="btn btn-primary" name="resubmit" value="Resubmit" type="submit">補上傳</button>
							</div>
						</div>
				</form>

			<?php endif; ?>

			</div>
		</div>
	</div>
</div>
<?php $this->load->view('templates/new_footer'); ?>
