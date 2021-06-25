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

									<option <?php echo ($yearType == ($i['year'])) ? 'selected' : '' ?> value="<?php echo site_url('/report/one_years_trend_survey_count_report_yda_table/' . $i['year'] . '/' . $monthType . '/' . $countyType); ?>"><?php echo $i['year'] ?></option>
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

									<option <?php echo ($monthType == $i) ? 'selected' : '' ?> value="<?php echo site_url('/report/one_years_trend_survey_count_report_yda_table/' . $yearType . '/' . $i . '/' . $countyType); ?>"><?php echo $i ?></option>
								<?php } ?>

							</select>
						</div>
					</div>

					<!-- counties -->
					<div class="row justify-content-center">
						<div class="col-sm-10 col-md-8 mb-3">
							<label>縣市</label>
							<select class="form-select form-select-lg" name="counties" id="counties" onchange="location = this.value;">
								<option <?php echo ($countyType == 'all') ? 'selected' : '' ?> value="<?php echo site_url('/report/one_years_trend_survey_count_report_yda_table/' . $yearType . '/' . $monthType . '/all'); ?>">全部</option>
								<?php foreach ($countiesName as $i) { ?>
									<option <?php echo ($countyType == $i['no']) ? 'selected' : '' ?> value="<?php echo site_url('/report/one_years_trend_survey_count_report_yda_table/' . $yearType . '/' . $monthType . '/' . $i['no']); ?>"><?php echo $i['name'] ?></option>
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



					<a class="btn btn-success" href="<?php echo site_url('export/yda_month_report_export/' . 'surveyTypeOneYearsTrack' . '/' . $yearType . '/' . $monthType); ?>"><?php echo $title ?>表列印(下載EXCEL檔)</a>
					<br /><br />

					<h5 class="text-center"><?php echo $yearType . '第' . $monthType / 3 . '季追蹤' ?></h5>

					<div class="row justify-content-center">
						<table class="table table-hover table-bordered align-middle text-center" style="border:2px grey solid;">
							<thead class="header">
								<tr>
									<th scope="col">縣市</th>
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
									<?php if ($countyType == 'all') : ?>
										<th scope="col" style="width: 10%;">審核</th>
										<th scope="col">繳交</th>
									<?php endif; ?>


								</tr>
							</thead>
							<?php
							for ($j = 0; $j < count($counties); $j++) {
							?>
								<tbody>

									<tr>
										<?php if ($reportProcessesCountyStatusArray[$j] != $reviewStatus['review_process_pass']) { ?>
											<td colspan="20"><?php echo $counties[$j]['name'] . '尚未送出報表' ?></td>
										<?php } else { ?>
											<td><?php echo $counties[$j]['name']; ?></td>
											<td><?php $cnt = 5000;
												foreach ($oneYearsTrendSurveyCountReports as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														echo $i ? $i['already_working'] : null;
														$cnt = $i['already_working'];
													}
												}
												if ($cnt == 5000) {
													echo "0";
												}
												$total += $cnt; ?></td>
											<td><?php $cnt = 5000;
												foreach ($oneYearsTrendSurveyCountReports as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														echo $i ? $i['already_attending_school'] : null;
														$cnt = $i['already_attending_school'];
													}
												}
												if ($cnt == 5000) {
													echo "0";
												}
												$total += $cnt; ?></td>
											<td><?php $cnt = 5000;
												foreach ($oneYearsTrendSurveyCountReports as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														echo $i ? $i['special_education_student'] : null;
														$cnt = $i['special_education_student'];
													}
												}
												if ($cnt == 5000) {
													echo "0";
												}
												$total += $cnt; ?></td>
											<td><?php $cnt = 5000;
												foreach ($oneYearsTrendSurveyCountReports as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														echo $i ? $i['prepare_to_school'] : null;
														$cnt = $i['prepare_to_school'];
													}
												}
												if ($cnt == 5000) {
													echo "0";
												}
												$total += $cnt; ?></td>
											<td><?php $cnt = 5000;
												foreach ($oneYearsTrendSurveyCountReports as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														echo $i ? $i['prepare_to_work'] : null;
														$cnt = $i['prepare_to_work'];
													}
												}
												if ($cnt == 5000) {
													echo "0";
												}
												$total += $cnt; ?></td>
											<td><?php $cnt = 5000;
												foreach ($oneYearsTrendSurveyCountReports as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														echo $i ? $i['training'] : null;
														$cnt = $i['training'];
													}
												}
												if ($cnt == 5000) {
													echo "0";
												}
												$total += $cnt; ?></td>
											<td><?php $cnt = 5000;
												foreach ($oneYearsTrendSurveyCountReports as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														echo $i ? $i['family_labor'] : null;
														$cnt = $i['family_labor'];
													}
												}
												if ($cnt == 5000) {
													echo "0";
												}
												$total += $cnt; ?></td>
											<td><?php $cnt = 5000;
												foreach ($oneYearsTrendSurveyCountReports as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														echo $i ? $i['health'] : null;
														$cnt = $i['health'];
													}
												}
												if ($cnt == 5000) {
													echo "0";
												}
												$total += $cnt; ?></td>
											<td><?php $cnt = 5000;
												foreach ($oneYearsTrendSurveyCountReports as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														echo $i ? $i['no_plan'] : null;
														$cnt = $i['no_plan'];
													}
												}
												if ($cnt == 5000) {
													echo "0";
												}
												$total += $cnt; ?></td>
											<td><?php $cnt = 5000;
												foreach ($oneYearsTrendSurveyCountReports as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														echo $i ? $i['lost_contact'] : null;
														$cnt = $i['lost_contact'];
													}
												}
												if ($cnt == 5000) {
													echo "0";
												}
												$total += $cnt; ?></td>

											<td><?php $cnt = 5000;
												foreach ($oneYearsTrendSurveyCountReports as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														echo $i ? $i['transfer_labor'] + $i['transfer_other'] + $i['pregnancy']
															+ $i['other'] : null;
														$cnt = $i['transfer_labor'] + $i['transfer_other'] + $i['pregnancy']
															+ $i['other'];
													}
												}
												if ($cnt == 5000) {
													echo "0";
												}
												$total += $cnt; ?></td>
											<td><?php $cnt = 5000;
												foreach ($oneYearsTrendSurveyCountReports as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														echo $i ? $i['immigration'] + $i['death'] + $i['military'] : null;
														$cnt = $i['immigration'] + $i['death'] + $i['military'];
													}
												}
												if ($cnt == 5000) {
													echo "0";
												}
												$total += $cnt; ?></td>
											<td><?php $cnt = 5000;
												foreach ($oneYearsTrendSurveyCountReports as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														echo $i ? $i['in_case'] : null;
														$cnt = $i['in_case'];
													}
												}
												if ($cnt == 5000) {
													echo "0";
												}
												$total += $cnt; ?></td>
											<td><?php $cnt = 5000;
												foreach ($oneYearsTrendSurveyCountReports as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														echo $i ? $i['youthCount'] : null;
														$cnt = $i['youthCount'];
													}
												}
												if ($cnt == 5000) {
													echo "0";
												}
												$total += $cnt; ?></td>
											<td><?php $cnt = 5000;
												foreach ($oneYearsTrendSurveyCountReports as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														echo $i ? $i['prepare_to_school'] + $i['prepare_to_work'] + $i['training'] + $i['family_labor']
															+ $i['health'] + $i['no_plan'] + $i['lost_contact'] + $i['transfer_labor'] + $i['transfer_other'] + $i['pregnancy']
															+ $i['other'] : null;
														$cnt = $i['prepare_to_school'] + $i['prepare_to_work'] + $i['training'] + $i['family_labor']
															+ $i['health'] + $i['no_plan'] + $i['lost_contact'] + $i['transfer_labor'] + $i['transfer_other'] + $i['pregnancy']
															+ $i['other'] + $i['immigration'] + $i['death'] + $i['military'];
													}
												}
												if ($cnt == 5000) {
													echo "0";
												}
												$total += $cnt; ?></td>
											<td><?php $cnt = 5000;
												foreach ($oneYearsTrendSurveyCountReports as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														echo $i ? $i['prepare_to_school'] + $i['prepare_to_work'] + $i['training'] + $i['family_labor']
															+ $i['health'] + $i['no_plan'] + $i['lost_contact'] + $i['transfer_labor'] + $i['transfer_other'] + $i['pregnancy']
															+ $i['other'] : null;
														$cnt = $i['prepare_to_school'] + $i['prepare_to_work'] + $i['training'] + $i['family_labor']
															+ $i['health'] + $i['no_plan'] + $i['lost_contact'] + $i['transfer_labor'] + $i['transfer_other'] + $i['pregnancy']
															+ $i['other'];
													}
												}
												if ($cnt == 5000) {
													echo "0";
												}
												$total += $cnt; ?></td>

											<td style="text-align:left"><?php $cnt = "";
																		foreach ($oneYearsTrendSurveyCountReports as $i) {
																			if ($counties[$j]['name'] == $i['name']) {
																				echo $i ? str_replace("\n", "<br/>", $i['note']) : null;
																				$cnt = $i['note'];
																			}
																		}
																		if ($cnt == "") {
																			echo "無資料";
																		}
																		?></td>
											<?php if ($countyType == 'all') : ?>
												<td><a class="btn btn-info" href="<?php echo site_url('report/one_years_trend_survey_count_report_yda_table/' . $yearType . '/' . $monthType . '/' . $counties[$j]['no']); ?>">審核</a></td>
												<td> <?php echo ($isOverTimeArray[$j] == 1) ? '遲交' : '準時'; ?></td>
										<?php endif;
										} ?>
									</tr>
								</tbody>
							<?php } ?>
							<tr>
								<td>總計</td>
								<td><?php echo $sumDetail['alreadyWorkingSum']; ?></td>
								<td><?php echo $sumDetail['alreadyAttendingSchoolSum']; ?></td>
								<td><?php echo $sumDetail['specialEducationStudentSum']; ?></td>
								<td><?php echo $sumDetail['prepareToSchoolSum']; ?></td>
								<td><?php echo $sumDetail['prepareToWorkSum']; ?></td>
								<td><?php echo $sumDetail['trainingSum']; ?></td>
								<td><?php echo $sumDetail['familyLaborSum']; ?></td>
								<td><?php echo $sumDetail['healthSum']; ?></td>
								<td><?php echo $sumDetail['noPlanSum']; ?></td>
								<td><?php echo $sumDetail['lostContactSum']; ?></td>
								<td><?php echo $sumDetail['transferLaborSum'] + $sumDetail['transferOtherSum'] + $sumDetail['pregnancySum'] + $sumDetail['otherSum']; ?></td>
								<td><?php echo $sumDetail['immigrationSum'] + $sumDetail['deathSum'] + $sumDetail['militarySum']; ?></td>
								<td><?php echo $sumDetail['inCaseSum']; ?></td>
								<td><?php echo $sumDetail['youthCountSum']; ?></td>
								<td><?php echo $sumDetail['alreadyWorkingSum'] + $sumDetail['alreadyAttendingSchoolSum'] + $sumDetail['specialEducationStudentSum'] + $sumDetail['prepareToSchoolSum'] + $sumDetail['prepareToWorkSum']
										+ $sumDetail['trainingSum'] + $sumDetail['familyLaborSum'] + $sumDetail['healthSum'] + $sumDetail['noPlanSum'] + $sumDetail['lostContactSum'] + $sumDetail['transferLaborSum']
										+ $sumDetail['transferOtherSum'] + $sumDetail['pregnancySum'] + $sumDetail['otherSum'] + $sumDetail['immigrationSum'] + $sumDetail['deathSum'] + $sumDetail['militarySum']; ?></td>
								<td><?php echo $sumDetail['alreadyWorkingSum'] + $sumDetail['alreadyAttendingSchoolSum'] + $sumDetail['specialEducationStudentSum'] + $sumDetail['prepareToSchoolSum'] + $sumDetail['prepareToWorkSum']
										+ $sumDetail['trainingSum'] + $sumDetail['familyLaborSum'] + $sumDetail['healthSum'] + $sumDetail['noPlanSum'] + $sumDetail['lostContactSum'] + $sumDetail['transferLaborSum']
										+ $sumDetail['transferOtherSum'] + $sumDetail['pregnancySum'] + $sumDetail['otherSum']; ?></td>
								<td></td>
								<?php if ($countyType == 'all') : ?>
									<td></td>
									<td></td>

								<?php endif; ?>
							</tr>
						</table>
					</div>
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
								<?php if (!empty($oneYearsTrendSurveyCountReportArray[$i]->report_file_name)) : ?>
									<?php if (strpos($oneYearsTrendSurveyCountReportArray[$i]->report_file_name, 'pdf') !== false) : ?>
										<a class="col-sm-10 col-md-8 link-primary" href="<?php echo site_url() . '/files/' . $oneYearsTrendSurveyCountReportArray[$i]->report_file_name; ?>" download="<?php echo $yearType . '年' . $monthType . '月' . $counties[0]['name'] ?>"><?php echo $yearType . '年' . $monthType . '月' . $counties[0]['name'] . '-' . $title ?></a>
									<?php else : ?>
										<div class="col-sm-10 col-md-8">
											<img class="figure-img img-fluid" src="<?php echo site_url() . '/files/' . $oneYearsTrendSurveyCountReportArray[$i]->report_file_name; ?>" />
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
