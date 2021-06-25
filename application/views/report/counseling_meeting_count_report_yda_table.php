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
					<?php echo isset($error) ? '<p class="red-text text-darken-1 text-center">' . $error . '</p>' : ''; ?>
					<?php echo isset($success) ? '<p class="green-text text-accent-4 text-center">' . $success . '</p>' : ''; ?>
					<input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />
					<!-- years -->
					<div class="row justify-content-center">
						<div class="col-sm-10 col-md-8 mb-3">
							<label>年度</label>
							<select class="form-select form-select-lg" name="years" id="years" onchange="location = this.value;">
								<?php
								foreach ($years as $i) { ?>
									<option <?php echo ($yearType == ($i['year'])) ? 'selected' : '' ?> value="<?php echo site_url('/report/counseling_meeting_count_report_yda_table/' . $i['year'] . '/' . $monthType); ?>"><?php echo $i['year'] ?></option>
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

									<option <?php echo ($monthType == $i) ? 'selected' : '' ?> value="<?php echo site_url('/report/counseling_meeting_count_report_yda_table/' . $yearType . '/' . $i); ?>"><?php echo $i ?></option>
								<?php } ?>

							</select>
						</div>
					</div>

					<div class="row justify-content-center">
						<div class="col-sm-10 col-md-8 mb-3">
							<label>縣市</label>
							<select class="form-select form-select-lg" name="counties" id="counties" onchange="location = this.value;">
								<option <?php echo ($countyType == 'all') ? 'selected' : '' ?> value="<?php echo site_url('/report/counseling_meeting_count_report_yda_table/' . $yearType . '/' . $monthType . '/all'); ?>">全部</option>
								<?php foreach ($countiesName as $i) { ?>
									<option <?php echo ($countyType == $i['no']) ? 'selected' : '' ?> value="<?php echo site_url('/report/counseling_meeting_count_report_yda_table/' . $yearType . '/' . $monthType . '/' . $i['no']); ?>"><?php echo $i['name'] ?></option>
									<?php ?>
								<?php } ?>
							</select>
						</div>
					</div>
					<?php
					$county_table = [];
					$get_organ = []; //當前縣市對應的所有organization num
					$cnt = 0;
					if ($county != 'all') { //單筆資料
						for ($i = 0; $i < count($counties); $i++) {
							foreach ($counties[$i] as $cKey => $cValue) {
								if ($cKey == 'no' && $cValue == $county) {
									$county_table[0] = $counties[$i];
								}
							}
						}
						for ($o = 0; $o < count($organ_num); $o++) {
							foreach ($organ_num[$o] as $oKey => $oValue) {
								if ($oKey == 'county' && $oValue == $county) {
									//二維
									$get_organ[$cnt] = $organ_num[$o];
									$cnt++;
								}
							}
						}
					} else {
						$county_table = $counties;
						$get_organ = $organ_num;
					} ?>

					<a class="btn btn-success" href="<?php echo site_url('export/yda_month_report_export/' . 'CounselingMeetingCountReport' . '/' . $yearType . '/' . $monthType); ?>">辦理會議或講座統計表列印(下載EXCEL檔)</a>
					<br /><br />


					<div class="row justify-content-center">
						<table class="table table-hover table-bordered align-middle text-center" style="border:2px grey solid;">
							<thead class="header">
								<tr>
									<th scope="col">縣市</th>
									<th scope="col">預計辦理跨局處會議場次</th>
									<th scope="col">目前辦理跨局處會議時間</th>
									<th scope="col">預計辦理活動或講座場次</th>
									<th scope="col" style="width: 10%;">目前辦理活動或講座場次</th>
									<th scope="col" style="width: 10%;">預計活動或講座參與人次</th>
									<th scope="col">目前活動或講座參與人次</th>
									<th scope="col" style="width: 30%;">備註</th>
									<?php if ($countyType == 'all') : ?>
										<th scope="col" style="width: 10%;">審核</th>
										<th scope="col">繳交</th>
									<?php endif; ?>
								</tr>

							</thead>
							<tbody>
								<?php for ($j = 0; $j < count($counties); $j++) { ?>
									<tr>
										<?php if ($reportProcessesCountyStatusArray[$j] != $reviewStatus['review_process_pass']) { ?>
											<td colspan="10"><?php echo $counties[$j]['name'] . '尚未送出報表' ?></td>
										<?php } else { ?>
											<td><?php echo $counties[$j]['name']; ?></td>
											<td><?php $cnt = 0;
												foreach ($projectArray as $i) {
													if ($counties[$j]['name'] == $i->countyName) {
														$count_boy = $i->meeting_count;
														$cnt += 1;
													}
												}
												if ($cnt == 0) {
													$count_boy = 0;
												}
												print($count_boy);
												?></td>
											<td><?php $cnt = 0;
												foreach ($get_all_inserted_meeting_count_data as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														$count_girl = str_replace("\n", "<br/>", $i['time_note']);
														$cnt += 1;
													}
												}
												if ($cnt == 0) {
													$count_girl = "無資料";
												}
												print($count_girl);
												?></td>


											<td><?php $cnt = 0;
												foreach ($get_all_inserted_meeting_count_data as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														$count_boy = $i['planning_holding_meeting_count'];
														$cnt += 1;
													}
												}
												if ($cnt == 0) {
													$count_boy = 0;
												}
												print($count_boy);
												?></td>

											<td><?php $cnt = 0;
												foreach ($get_all_inserted_meeting_count_data as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														$count_boy = $i['actual_holding_meeting_count'];
														$cnt += 1;
													}
												}
												if ($cnt == 0) {
													$count_boy = 0;
												}
												print($count_boy);
												?></td>

											<td><?php $cnt = 0;
												foreach ($get_all_inserted_meeting_count_data as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														$count_boy = $i['planning_involved_people'];
														$cnt += 1;
													}
												}
												if ($cnt == 0) {
													$count_boy = 0;
												}
												print($count_boy);
												?></td>

											<td><?php $cnt = 0;
												foreach ($get_all_inserted_meeting_count_data as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														$count_boy = $i['actual_involved_people'];
														$cnt += 1;
													}
												}
												if ($cnt == 0) {
													$count_boy = 0;
												}
												print($count_boy);
												?></td>

											<td style="text-align:left"><?php $cnt = 0;
																		foreach ($get_all_inserted_meeting_count_data as $i) {
																			if ($counties[$j]['name'] == $i['name']) {
																				$count_boy = str_replace("\r\n", "<br/>", $i['meeting_count_note']);
																				$cnt += 1;
																			}
																		}
																		if ($cnt == 0) {
																			$count_boy = "無資料";
																		}
																		print($count_boy);
																		?></td>


											<?php if ($countyType == 'all') : ?>
												<td><a class="btn btn-info" href="<?php echo site_url('report/counseling_meeting_count_report_yda_table/' . $yearType . '/' . $monthType . '/' . $counties[$j]['no']); ?>">審核</a></td>
												<td> <?php echo ($isOverTimeArray[$j] == 1) ? '遲交' : '準時'; ?></td>
										<?php endif;
										} ?>
									</tr>
								<?php } ?>
								<tr>
									<td>總計</td>
									<td><?php echo $sumDetail['meetingCountSum'] ?></td>
									<td></td>
									<td><?php echo $sumDetail['planningHoldingSum'] ?></td>
									<td><?php echo $sumDetail['actualHoldingSum'] ?></td>
									<td><?php echo $sumDetail['planningInvolvedSum'] ?></td>
									<td><?php echo $sumDetail['actualInvolvedSum'] ?></td>
									<td></td>
									<?php if ($countyType == 'all') : ?>
										<td></td>
										<td></td>

									<?php endif; ?>
								</tr>

								<tr>
									<td>委辦</td>
									<td><?php echo $sumDetail['commission_meeting_count'] ?></td>
									<td></td>
									<td><?php echo $sumDetail['commission_planning_holding_meeting_count'] ?></td>
									<td><?php echo $sumDetail['commission_actual_holding_meeting_count'] ?></td>
									<td><?php echo $sumDetail['commission_planning_involved_people'] ?></td>
									<td><?php echo $sumDetail['commission_actual_involved_people'] ?></td>
									<td></td>
									<?php if ($countyType == 'all') : ?>
										<td></td>
										<td></td>

									<?php endif; ?>
								</tr>

								<tr>
									<td>自辦</td>
									<td><?php echo $sumDetail['self_meeting_count'] ?></td>
									<td></td>
									<td><?php echo $sumDetail['self_planning_holding_meeting_count'] ?></td>
									<td><?php echo $sumDetail['self_actual_holding_meeting_count'] ?></td>
									<td><?php echo $sumDetail['self_planning_involved_people'] ?></td>
									<td><?php echo $sumDetail['self_actual_involved_people'] ?></td>
									<td></td>
									<?php if ($countyType == 'all') : ?>
										<td></td>
										<td></td>

									<?php endif; ?>
								</tr>

							</tbody>
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
								<?php if (!empty($get_all_inserted_meeting_count_data_array[$i]->report_file_name)) : ?>
									<?php if (strpos($get_all_inserted_meeting_count_data_array[$i]->report_file_name, 'pdf') !== false) : ?>
										<a class="col-sm-10 col-md-8 link-primary" href="<?php echo site_url() . '/files/' . $get_all_inserted_meeting_count_data_array[$i]->report_file_name; ?>" download="<?php echo $yearType . '年' . $monthType . '月' . $counties[0]['name'] ?>"><?php echo $yearType . '年' . $monthType . '月' . $counties[0]['name'] . '-' . $title ?></a>
									<?php else : ?>
										<div class="col-sm-10 col-md-8">
											<img class="figure-img img-fluid" src="<?php echo site_url() . '/files/' . $get_all_inserted_meeting_count_data_array[$i]->report_file_name; ?>" />
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

			if ((i - 2) % 3 == 0 || i == 0 || i == 1) {
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
