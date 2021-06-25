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
<div class="container" style="width:100%;">
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
					<input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />

					<!-- years -->
					<div class="row justify-content-center">
						<div class="col-sm-10 col-md-8 mb-3">
							<label>年度</label>
							<select class="form-select form-select-lg" name="years" id="years" onchange="location = this.value;">

								<?php foreach ($years as $i) { ?>

									<option <?php echo ($yearType == ($i['year'])) ? 'selected' : '' ?> value="<?php echo site_url('/report/one_years_trend_survey_count_report_organization_table/' . $i['year'] . '/' . $monthType); ?>"><?php echo $i['year'] ?></option>
								<?php } ?>

							</select>
						</div>
					</div>

					<!-- months -->
					<div class="row justify-content-center">
						<div class="col-sm-10 col-md-8 mb-3">
							<label>月份</label>
							<select class="form-select form-select-lg" name="months" id="months" onchange="location = this.value;">

								<?php foreach ($months as $i) { ?>

									<option <?php echo ($monthType == $i) ? 'selected' : '' ?> value="<?php echo site_url('/report/one_years_trend_survey_count_report_organization_table/' . $yearType . '/' . $i); ?>"><?php echo $i ?></option>
								<?php } ?>

							</select>
						</div>
					</div>

					<a class="btn btn-success" href="<?php echo site_url('export/organization_month_report_export/' . 'OneYearsTrendSurveyCountReport' . '/' . $yearType . '/' . $monthType); ?>">列印(下載EXCEL檔)</a><br /><br />

					<?php if ($reportProcessesCounselorStatus == $reviewStatus['review_process_pass']) : ?>

						<h5 class="text-center"><?php echo $yearType . '第' . $monthType / 3 . '季追蹤' ?></h5>

						<table class="table table-hover table-bordered align-middle text-center" style="border:2px grey solid;">
							<thead>
								<tr>
									<th scope="col">1.已就業</th>
									<th scope="col">2.已就學</th>
									<th scope="col">3.特教生</th>
									<th scope="col">4.準備升學</th>
									<th scope="col">5.準備或正在找工作</th>
									<th scope="col">6.參加職訓</th>
									<th scope="col">7.家務勞動</th>
									<th scope="col">8.健康因素</th>
									<th scope="col">9.尚未規劃</th>
									<th scope="col">10.失聯</th>
									<th scope="col">11.其他(非不可抗力)</th>
									<th scope="col">12.其他(不可抗力)</th>
									<th scope="col">進入本計畫輔導</th>
									<th scope="col">A.動向調查學生數</th>
									<th scope="col">B.未升學未就業人數(4-12)</th>
									<th scope="col">C.需政府關懷追蹤後，適時介入輔導人數(4-11)</th>
									<th scope="col" style="width:30%;">備註</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->already_working : null ?></td>
									<td><?php echo $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->already_attending_school : null ?></td>
									<td><?php echo $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->special_education_student : null ?></td>
									<td><?php echo $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->prepare_to_school : null ?></td>
									<td><?php echo $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->prepare_to_work : null ?></td>
									<td><?php echo $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->training : null ?></td>
									<td><?php echo $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->family_labor : null ?></td>
									<td><?php echo $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->health : null ?></td>
									<td><?php echo $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->no_plan : null ?></td>
									<td><?php echo $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->lost_contact : null ?></td>

									<td><?php echo $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->transfer_labor + $oneYearsTrendSurveyCountReports->transfer_other + $oneYearsTrendSurveyCountReports->pregnancy
												+ $oneYearsTrendSurveyCountReports->other : null ?></td>
									<td><?php echo $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->immigration + $oneYearsTrendSurveyCountReports->death + $oneYearsTrendSurveyCountReports->military : null ?></td>
									<td><?php echo $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->in_case : null ?></td>
									<td><?php echo $youthCount ? $youthCount : null ?></td>
									<td><?php echo $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->prepare_to_school + $oneYearsTrendSurveyCountReports->prepare_to_work + $oneYearsTrendSurveyCountReports->training + $oneYearsTrendSurveyCountReports->family_labor
												+ $oneYearsTrendSurveyCountReports->health + $oneYearsTrendSurveyCountReports->no_plan + $oneYearsTrendSurveyCountReports->lost_contact + $oneYearsTrendSurveyCountReports->transfer_labor + $oneYearsTrendSurveyCountReports->transfer_other + $oneYearsTrendSurveyCountReports->pregnancy
												+ $oneYearsTrendSurveyCountReports->other + $oneYearsTrendSurveyCountReports->immigration + $oneYearsTrendSurveyCountReports->death + $oneYearsTrendSurveyCountReports->military : null ?></td>
									<td><?php echo $oneYearsTrendSurveyCountReports ? $oneYearsTrendSurveyCountReports->prepare_to_school + $oneYearsTrendSurveyCountReports->prepare_to_work + $oneYearsTrendSurveyCountReports->training + $oneYearsTrendSurveyCountReports->family_labor
												+ $oneYearsTrendSurveyCountReports->health + $oneYearsTrendSurveyCountReports->no_plan + $oneYearsTrendSurveyCountReports->lost_contact + $oneYearsTrendSurveyCountReports->transfer_labor + $oneYearsTrendSurveyCountReports->transfer_other + $oneYearsTrendSurveyCountReports->pregnancy
												+ $oneYearsTrendSurveyCountReports->other : null ?></td>
									<td style="text-align:left"><?php echo $oneYearsTrendSurveyCountReports ? str_replace("\n", "<br/>", $oneYearsTrendSurveyCountReports->note) : null ?></td>

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
							<div class="col-sm-10 offset-m2 col-md-8">
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
							<div class="col-sm-10 col-md-8 mb-2">
								<?php if ('1 ' != '0') : ?>
									<label for="reportFile" class="form-label">報表電子檔</label>
									<input class="form-control" type="file" name="reportFile">
								<?php endif; ?>
							</div>
						</div>

						<?php if (!empty($oneYearsTrendSurveyCountReports->report_file_name)) : ?>
							<?php if (strpos($oneYearsTrendSurveyCountReports->report_file_name, 'pdf') !== false) : ?>
								<a class="col-sm-10 offset-m2 col-md-8 link-primary" href="<?php echo site_url() . '/files/' . $oneYearsTrendSurveyCountReports->report_file_name; ?>" download="<?php echo $yearType . '年' . $monthType . '月' . $title ?>"><?php echo $yearType . '年' . $monthType . '月' . $title ?></a>
							<?php else : ?>
								<div class="col-sm-10 offset-m2 col-md-8">
									<img class="figure-img img-fluid" src="<?php echo site_url() . '/files/' . $oneYearsTrendSurveyCountReports->report_file_name; ?>" />
								</div>
							<?php endif; ?>
						<?php endif; ?>

						<div class="row justify-content-center">
						<div class="d-grid gap-2 col-sm-6 col-md-4">
							<button class="btn btn-primary" type="submit">送出</button>
						</div>
						</div>
				</form>

			<?php endif; ?>

			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('#download').click(function() {
		var data = $("#form").html();
		if (data == '') {
			alert('請先搜尋您想要下載的數據');
		} else {
			var html = "<html><head><meta   charset= 'utf-8'></head><body>" + data + "</body></html>";
			window.open('data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,' + encodeURIComponent(html));
		}
	});

	function downloadCSV(csv, filename) {
		var csvFile;
		var downloadLink;

		// CSV file
		csvFile = new Blob(["\uFEFF" + csv], {
			type: 'text/csv;charset=utf-8;'
		});

		// Download link
		downloadLink = document.createElement("a");

		// File name
		downloadLink.download = filename;

		// Create a link to the file
		downloadLink.href = window.URL.createObjectURL(csvFile);

		// Hide download link
		downloadLink.style.display = "none";

		// Add the link to DOM
		document.body.appendChild(downloadLink);

		// Click download link
		downloadLink.click();
	}

	function exportTableToCSV(report, filename) {
		var csv = [];
		var rows = document.querySelectorAll(report + "table tr");

		for (var i = 0; i < rows.length; i++) {
			var row = [],
				cols = rows[i].querySelectorAll("td, th");
			if (i % 2 != 0 || i == 0) {
				for (var j = 0; j < cols.length; j++)

					row.push(cols[j].innerText);
				csv.push(row.join(","));
			}

		}
		// Download CSV file
		downloadCSV(csv.join("\n"), filename);
	}
</script>
<?php $this->load->view('templates/new_footer'); ?>
