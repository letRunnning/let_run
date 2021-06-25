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

									<option <?php echo ($yearType == ($i['year'])) ? 'selected' : '' ?> value="<?php echo site_url('/report/counselor_manpower_report_yda_table/' . $i['year'] . '/' . $monthType); ?>"><?php echo $i['year'] ?></option>
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

									<option <?php echo ($monthType == $i) ? 'selected' : '' ?> value="<?php echo site_url('/report/counselor_manpower_report_yda_table/' . $yearType . '/' . $i); ?>"><?php echo $i ?></option>
								<?php } ?>

							</select>
						</div>
					</div>

					<!-- counties -->
					<div class="row justify-content-center">
						<div class="col-sm-10 col-md-8 mb-3">
							<label>縣市</label>
							<select class="form-select form-select-lg" name="counties" id="counties" onchange="location = this.value;">
								<option <?php echo ($countyType == 'all') ? 'selected' : '' ?> value="<?php echo site_url('/report/counselor_manpower_report_yda_table/' . $yearType . '/' . $monthType . '/all'); ?>">全部</option>
								<?php foreach ($countiesName as $i) { ?>
									<option <?php echo ($countyType == $i['no']) ? 'selected' : '' ?> value="<?php echo site_url('/report/counselor_manpower_report_yda_table/' . $yearType . '/' . $monthType . '/' . $i['no']); ?>"><?php echo $i['name'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<?php $total = 0;
					$county_table = [];
					if ($countyType != 'all') {
						for ($i = 0; $i < count($counties); $i++) {
							foreach ($counties[$i] as $cValue) {
								if ($cValue == $countyType) {
									$county_table[$i] = $counties[$i];
								}
							}
						}
						// print_r($county_table);
					} else {
						$county_table = $counties;
						// print_r($county_table);
					} ?>
					<a class="btn btn-success" href="<?php echo site_url('export/yda_month_report_export/' . 'counselorManpowerCountReport' . '/' . $yearType . '/' . $monthType); ?>">輔導對象身分統計表列印(下載EXCEL檔)</a>
					<br /><br />

					<div class="row justify-content-center">
						<table class="table table-hover table-bordered align-middle text-center" style="border:2px grey solid;">
							<thead class="header">
								`<tr>
									<th scope="col" rowspan="2">縣市</th>
									<th scope="col" colspan="2">雙青專任輔導人員</th>
									<th scope="col" colspan="4">輔導人員隸屬</th>
									<th scope="col" colspan="2">學歷</th>
									<th scope="col" colspan="3">證照</th>
									<th scope="col" rowspan="2" style="width:30%;">備註</th>
									<?php if ($countyType == 'all') : ?>
										<th scope="col" rowspan="2" style="width: 10%;">審核</th>
										<th scope="col" rowspan="2">繳交</th>
									<?php endif; ?>

								</tr>
								<tr>
									<th scope="col">預估輔導人員</th>
									<th scope="col">實際輔導人員</th>
									<th scope="col">教育局(處)</th>
									<th scope="col">輔諮中心</th>
									<th scope="col">學校</th>
									</th>
									<th scope="col">委外單位</th>
									<th scope="col">學士</th>
									<th scope="col">碩士</th>
									<th scope="col">具社會工作師證照</th>
									<th scope="col">具心理師證照</th>
									<th scope="col">無證照相關系所</th>
								</tr>
							</thead>
							<?php
							for ($j = 0; $j < count($counties); $j++) {
							?>
								<tbody>

									<tr>
										<?php if ($reportProcessesCountyStatusArray[$j] != $reviewStatus['review_process_pass']) { ?>
											<td colspan="15"><?php echo $counties[$j]['name'] . '尚未送出報表' ?></td>
										<?php } else { ?>
											<td><?php
												echo $counties[$j]['name']; ?></td>
											<td><?php $cnt = 50;
												foreach ($counselorManpowerReports as $i) {

													if ($counties[$j]['name'] == $i['name']) {
														echo $i['project_counselor'];
														$cnt = $i['project_counselor'];
													}
												}
												if ($cnt == 50) {
													echo "0";
												}
												$total += $cnt; ?></td>
											<td><?php $cnt = 50;
												foreach ($counselorManpowerReports as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														echo $i['really_counselor'];
														$cnt = $i['really_counselor'];
													}
												}
												if ($cnt == 50) {
													echo "0";
												}
												$total += $cnt; ?></td>
											<td><?php $cnt = 50;
												foreach ($counselorManpowerReports as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														echo $i['education_counselor'];
														$cnt = $i['education_counselor'];
													}
												}
												if ($cnt == 50) {
													echo "0";
												}
												$total += $cnt; ?></td>
											<td><?php $cnt = 0;
												foreach ($counselorManpowerReports as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														echo $i['counseling_center_counselor'];
														$cnt = $i['counseling_center_counselor'];
													}
												}
												if ($cnt == 50) {
													echo "0";
												}
												$total += $cnt; ?></td>
											<td><?php $cnt = 50;
												foreach ($counselorManpowerReports as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														echo $i['school_counselor'];
														$cnt = $i['school_counselor'];
													}
												}
												if ($cnt == 50) {
													echo "0";
												}
												$total += $cnt; ?></td>
											<td><?php $cnt = 50;
												foreach ($counselorManpowerReports as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														echo $i['outsourcing_counselor'];
														$cnt = $i['outsourcing_counselor'];
													}
												}
												if ($cnt == 50) {
													echo "0";
												}
												$total += $cnt; ?></td>
											<td><?php $cnt = 50;
												foreach ($counselorManpowerReports as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														echo $i['bachelor_degree'];
														$cnt = $i['bachelor_degree'];
													}
												}
												if ($cnt == 50) {
													echo "0";
												}
												$total += $cnt; ?></td>
											<td><?php $cnt = 50;
												foreach ($counselorManpowerReports as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														echo $i['master_degree'];
														$cnt = $i['master_degree'];
													}
												}
												if ($cnt == 50) {
													echo "0";
												}
												$total += $cnt;  ?></td>
											<td><?php $cnt = 50;
												foreach ($counselorManpowerReports as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														echo $i['qualification_three'];
														$cnt = $i['qualification_three'];
													}
												}
												if ($cnt == 50) {
													echo "0";
												}
												$total += $cnt;  ?></td>
											<td><?php $cnt = 50;
												foreach ($counselorManpowerReports as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														echo $i['qualification_four'];
														$cnt = $i['qualification_four'];
													}
												}
												if ($cnt == 50) {
													echo "0";
												}
												$total += $cnt;  ?></td>
											<td><?php $cnt = 50;
												foreach ($counselorManpowerReports as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														echo $i['qualification_one'] + $i['qualification_two'] + $i['qualification_five'] + $i['qualification_six'];
														$cnt = $i['qualification_one'] + $i['qualification_two'] + $i['qualification_five'] + $i['qualification_six'];
													}
												}
												if ($cnt == 50) {
													echo "0";
												}
												$total += $cnt;  ?></td>
											<td style="text-align:left"><?php $cnt = 50;
																		foreach ($counselorManpowerReports as $i) {
																			if ($counties[$j]['name'] == $i['name']) {
																				echo str_replace("\n", "<br/>", $i['note']);

																				$cnt++;
																			}
																		}
																		if ($cnt == 50) {
																			echo "無資料";
																		}
																		?></td>
											<?php if ($countyType == 'all') : ?>
												<td><a class="btn btn-info" href="<?php echo site_url('report/counselor_manpower_report_yda_table/' . $yearType . '/' . $monthType . '/' . $counties[$j]['no']); ?>">審核</a></td>
												<td> <?php echo ($isOverTimeArray[$j] == 1) ? '遲交' : '準時'; ?></td>
										<?php endif;
										} ?>
									</tr>
								</tbody>
							<?php } ?>
							<tr>
								<td>總計</td>
								<td><?php echo $sumDetail['projectCounselorSum'] ?></td>
								<td><?php echo $sumDetail['reallyCounselorSum'] ?></td>
								<td><?php echo $sumDetail['educationCounselorSum'] ?></td>
								<td><?php echo $sumDetail['counselingCenterCounselorSum'] ?></td>
								<td><?php echo $sumDetail['schoolCounselorSum'] ?></td>
								<td><?php echo $sumDetail['outsourcingCounselorSum'] ?></td>
								<td><?php echo $sumDetail['bachelorDegreeSum'] ?></td>
								<td><?php echo $sumDetail['masterDegreeSum'] ?></td>
								<td><?php echo $sumDetail['qualificationOneSum'] ?></td>
								<td><?php echo $sumDetail['qualificationTwoSum'] ?></td>
								<td><?php echo $sumDetail['qualificationThreeSum'] ?></td>
								<td></td>
								<?php if ($countyType == 'all') : ?>
									<td></td>
									<td></td>

								<?php endif; ?>
							</tr>

						</table>
					</div>
					<br />
					<br />

					<?php for ($i = 0; $i < count($counties); $i++) {
						if ($countyType != 'all' && $reportLogsArray[$i]) : ?>
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

									<?php foreach ($reportLogsArray[$i] as $value) { ?>
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
					<?php endif;
					} ?>

					<br />

					<?php for ($i = 0; $i < count($counties); $i++) { ?>

						<?php if ($countyType != 'all' && $reportProcessesYdaStatusArray[$i] == $reviewStatus['review_process_wait']) : ?>

							<div class="row justify-content-center">
								<?php if (!empty($counselorManpowerReportArray[$i]->report_file_name)) : ?>
									<?php if (strpos($counselorManpowerReportArray[$i]->report_file_name, 'pdf') !== false) : ?>
										<a class="col-sm-10 col-md-8 link-primary" href="<?php echo site_url() . '/files/' . $counselorManpowerReportArray[$i]->report_file_name; ?>" download="<?php echo $yearType . '年' . $monthType . '月' . $counties[0]['name'] ?>"><?php echo $yearType . '年' . $monthType . '月' . $counties[0]['name'] . '-' . $title ?></a>
									<?php else : ?>
										<div class="col-sm-10 col-md-8">
											<img class="figure-img img-fluid" src="<?php echo site_url() . '/files/' . $counselorManpowerReportArray[$i]->report_file_name; ?>" />
										</div>
									<?php endif; ?>
								<?php endif; ?>
							</div>

							<div class="row justify-content-center">
								<div class="col-sm-10 col-md-8">
									<label>審核</label>
									<select class="form-select mb-3" name="reviewStatus" required>
										<?php if ($reportProcessesYdaStatusArray[$i] == $reviewStatus['review_process_wait']) { ?>
											<option disabled selected value>請選擇</option>
											<?php }
										foreach ($processReviewStatuses as $i) {
											if ($reportProcessesYdaStatusArray[$i] != $reviewStatus['review_process_wait']) {
												if ($i['no'] == $reportProcessesYdaStatusArray[$i]) { ?>
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
								<div class="d-grid gap-2 col-sm-6 col-md-4">
									<button class="btn btn-primary" type="submit">送出</button>
								</div>
							</div>
				</form>

			<?php endif; ?>

		<?php } ?>

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
