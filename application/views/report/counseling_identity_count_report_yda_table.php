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
					<?php echo isset($success) ? '<p class="green-text text-accent-4 text-center">' . $success . '</p>' : '';
					$total = 0; ?>
					<input type="hidden" name="<?php echo $security->get_csrf_token_name() ?>" value="<?php echo $security->get_csrf_hash() ?>" />
					<!-- years -->
					<div class="row justify-content-center">
						<div class="col-sm-10 col-md-8 mb-3">
							<label>年度</label>
							<select class="form-select form-select-lg" name="years" id="years" onchange="location = this.value;">

								<?php foreach ($years as $i) { ?>
									<option <?php echo ($yearType == ($i['year'])) ? 'selected' : '' ?> value="<?php echo site_url('/report/counseling_identity_count_report_yda_table/' . $i['year'] . '/' . $monthType); ?>"><?php echo $i['year'] ?></option>
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

									<option <?php echo ($monthType == $i) ? 'selected' : '' ?> value="<?php echo site_url('/report/counseling_identity_count_report_yda_table/' . $yearType . '/' . $i); ?>"><?php echo $i ?></option>
								<?php } ?>

							</select>
						</div>
					</div>

					<div class="row justify-content-center">
						<div class="col-sm-10 col-md-8 mb-3">
							<label>縣市</label>
							<select class="form-select form-select-lg" name="counties" id="counties" onchange="location = this.value;">
								<option <?php echo ($countyType == 'all') ? 'selected' : '' ?> value="<?php echo site_url('/report/counseling_identity_count_report_yda_table/' . $yearType . '/' . $monthType . '/all'); ?>">全部</option>
								<?php foreach ($countiesName as $i) { ?>
									<option <?php echo ($countyType == $i['no']) ? 'selected' : '' ?> value="<?php echo site_url('/report/counseling_identity_count_report_yda_table/' . $yearType . '/' . $monthType . '/' . $i['no']); ?>"><?php echo $i['name'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>

					<?php
					$county_table = [];
					if ($countyType != 'all') {
						for ($i = 0; $i < count($counties); $i++) {
							foreach ($counties[$i] as $cValue) {
								if ($cValue == $county) {
									$county_table[$i] = $counties[$i];
								}
							}
						}
					} else {
						$county_table = $counties;
					}
					?>

					<a class="btn btn-success" href="<?php echo site_url('export/yda_month_report_export/' . 'CounselingIdentityCountReport' . '/' . $yearType . '/' . $monthType); ?>">輔導對象身分統計表列印(下載EXCEL檔)</a>
					<br /><br />

					<div class="table-responsive" style="max-height: 500px;">
						<table class="table table-hover table-bordered align-middle text-center" style="border:2px grey solid;">
							<thead class="header">
								<tr>
									<th scope="col" rowspan="2">類別</th>

									<th scope="col" rowspan="2" colspan="3">中輟滿16歲未升學未就業<br />A</th>
									<th scope="col" colspan="5">國中畢(結)業未就學未就業B</th>
									<th scope="col" rowspan="2" colspan="3">高中中離<br />C</th>
									<th scope="col" rowspan="3">合計</th>

									<?php if ($countyType == 'all') : ?>
										<th scope="col" rowspan="3">審核</th>
										<th scope="col" rowspan="3">繳交</th>
									<?php endif; ?>
								</tr>
								<tr>
									<th scope="col" colspan="2">應屆</th>
									<th scope="col" colspan="2">非應屆</th>
									<th scope="col" rowspan="2">小計</th>
								</tr>
								<tr>
									<th scope="col">縣市別</th>

									<th scope="col">男</th>
									<th scope="col">女</th>
									<th scope="col">小計</th>
									<th scope="col">男</th>
									<th scope="col">女</th>
									<th scope="col">男</th>
									<th scope="col">女</th>
									<th scope="col">男</th>
									<th scope="col">女</th>
									<th scope="col">小計</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$countyArray = array("嘉義市", "澎湖縣", "連江縣", "金門縣");

								$commission_A_boy = $commission_A_girl = $commission_A_total = $commission_B_boy = $commission_B_girl = $commission_B_total = $commission_C1_boy = $commission_C1_girl = $commission_C2_boy = $commission_C2_girl = $commission_C_total = $commission_D_boy = $commission_D_girl = $commission_D_total = $commission_total =  0;
								$self_A_boy = $self_A_girl = $self_A_total = $self_B_boy = $self_B_girl = $self_B_total = $self_C1_boy = $self_C1_girl = $self_C2_boy = $self_C2_girl = $self_C_total = $self_D_boy = $self_D_girl = $self_D_total = $self_total = 0;
								for ($j = 0; $j < count($counties); $j++) {
									$total = 0;
									$aTotal = 0;

								?>
									<tr>
										<?php if ($reportProcessesCountyStatusArray[$j] != $reviewStatus['review_process_pass']) { ?>
											<td colspan="15"><?php echo $counties[$j]['name'] . '尚未送出報表' ?></td>
										<?php } else { ?>
											<td><?php echo $counties[$j]['name']; ?></td>

											<td><?php $cnt = 0;
												$count_boy = 0;
												foreach ($get_all_inserted_identity_count_data as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														$count_boy = $i['sixteen_years_old_not_employed_not_studying_boy'];
														$cnt += 1;

														if (in_array($counties[$j]['name'], $countyArray)) {
															$self_B_boy += $count_boy;
														} else {
															$commission_B_boy += $count_boy;
														}
													}
												}
												if ($cnt == 0) {
													$count_boy = 0;
													if (in_array($counties[$j]['name'], $countyArray)) {
														$self_B_boy += $count_boy;
													} else {
														$commission_B_boy += $count_boy;
													}
												}
												print($count_boy);
												?></td>
											<td><?php $cnt = 0;
												$count_girl = 0;
												foreach ($get_all_inserted_identity_count_data as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														$count_girl = $i['sixteen_years_old_not_employed_not_studying_girl'];
														$cnt += 1;

														if (in_array($counties[$j]['name'], $countyArray)) {
															$self_B_girl += $count_girl;
														} else {
															$commission_B_girl += $count_girl;
														}
													}
												}
												if ($cnt == 0) {
													$count_girl = 0;
													if (in_array($counties[$j]['name'], $countyArray)) {
														$self_B_girl += $count_girl;
													} else {
														$commission_B_girl += $count_girl;
													}
												}
												print($count_girl);
												?></td>
											<td><?php echo $count_boy + $count_girl;
												$total += $count_boy + $count_girl;
												if (in_array($counties[$j]['name'], $countyArray)) {
													$self_B_total += $count_boy + $count_girl;
													$self_total += $count_boy + $count_girl;
												} else {
													$commission_B_total += $count_boy + $count_girl;
													$commission_total += $count_boy + $count_girl;
												} ?></td>
											<td><?php $cnt = 0;
												$count_boy = 0;
												foreach ($get_all_inserted_identity_count_data as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														$count_boy = $i['junior_graduated_this_year_unemployed_not_studying_boy'];
														$cnt += 1;

														if (in_array($counties[$j]['name'], $countyArray)) {
															$self_C1_boy += $count_boy;
														} else {
															$commission_C1_boy += $count_boy;
														}
													}
												}
												if ($cnt == 0) {
													$count_boy = 0;
													if (in_array($counties[$j]['name'], $countyArray)) {
														$self_C1_boy += $count_boy;
													} else {
														$commission_C1_boy += $count_boy;
													}
												}
												print($count_boy);
												?></td>
											<td><?php $cnt = 0;
												$count_girl = 0;
												foreach ($get_all_inserted_identity_count_data as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														$count_girl = $i['junior_graduated_this_year_unemployed_not_studying_girl'];
														$cnt += 1;

														if (in_array($counties[$j]['name'], $countyArray)) {
															$self_C1_girl += $count_girl;
														} else {
															$commission_C1_girl += $count_girl;
														}
													}
												}
												if ($cnt == 0) {
													$count_girl = 0;
													if (in_array($counties[$j]['name'], $countyArray)) {
														$self_C1_girl += $count_girl;
													} else {
														$commission_C1_girl += $count_girl;
													}
												}
												print($count_girl);
												$this_year = $count_boy + $count_girl; ?></td>

											<td><?php $cnt = 0;
												$count_boy = 0;
												foreach ($get_all_inserted_identity_count_data as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														$count_boy = $i['junior_graduated_not_this_year_unemployed_not_studying_boy'];
														$cnt += 1;

														if (in_array($counties[$j]['name'], $countyArray)) {
															$self_C2_boy += $count_boy;
														} else {
															$commission_C2_boy += $count_boy;
														}
													}
												}
												if ($cnt == 0) {
													$count_boy = 0;
													if (in_array($counties[$j]['name'], $countyArray)) {
														$self_C2_boy += $count_boy;
													} else {
														$commission_C2_boy += $count_boy;
													}
												}
												print($count_boy);
												?></td>
											<td><?php $cnt = 0;
												$count_girl = 0;
												foreach ($get_all_inserted_identity_count_data as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														$count_girl = $i['junior_graduated_not_this_year_unemployed_not_studying_girl'];
														$cnt += 1;
														if (in_array($counties[$j]['name'], $countyArray)) {
															$self_C2_girl += $count_girl;
														} else {
															$commission_C2_girl += $count_girl;
														}
													}
												}
												if ($cnt == 0) {
													$count_girl = 0;
													if (in_array($counties[$j]['name'], $countyArray)) {
														$self_C2_girl += $count_girl;
													} else {
														$commission_C2_girl += $count_girl;
													}
												}
												print($count_girl);

												$not_this_year = $count_boy + $count_girl; ?></td>
											<td><?php echo $this_year + $not_this_year;
												$total += $this_year + $not_this_year;
												if (in_array($counties[$j]['name'], $countyArray)) {
													$self_C_total += $this_year + $not_this_year;
													$self_total += $this_year + $not_this_year;
												} else {
													$commission_C_total += $this_year + $not_this_year;
													$commission_total += $this_year + $not_this_year;
												} ?></td>
											<td><?php $cnt = 0;
												$count_boy = 0;
												foreach ($get_all_inserted_identity_count_data as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														$count_boy = $i['drop_out_from_senior_boy'];
														$cnt += 1;
														if (in_array($counties[$j]['name'], $countyArray)) {
															$self_D_boy += $count_boy;
														} else {
															$commission_D_boy += $count_boy;
														}
													}
												}
												if ($cnt == 0) {
													$count_boy = 0;
													if (in_array($counties[$j]['name'], $countyArray)) {
														$self_D_boy += $count_boy;
													} else {
														$commission_D_boy += $count_boy;
													}
												}
												print($count_boy);
												?></td>
											<td><?php $cnt = 0;
												$count_girl = 0;
												foreach ($get_all_inserted_identity_count_data as $i) {
													if ($counties[$j]['name'] == $i['name']) {
														$count_girl = $i['drop_out_from_senior_girl'];
														$cnt += 1;
														if (in_array($counties[$j]['name'], $countyArray)) {
															$self_D_girl += $count_girl;
														} else {
															$commission_D_girl += $count_girl;
														}
													}
												}
												if ($cnt == 0) {
													$count_girl = 0;
													if (in_array($counties[$j]['name'], $countyArray)) {
														$self_D_girl += $count_girl;
													} else {
														$commission_D_girl += $count_girl;
													}
												}
												print($count_girl);
												?></td>
											<td><?php echo $count_boy + $count_girl;
												$total += $count_boy + $count_girl;
												if (in_array($counties[$j]['name'], $countyArray)) {
													$self_D_total += $count_boy + $count_girl;
													$self_total += $count_boy + $count_girl;
												} else {
													$commission_D_total += $count_boy + $count_girl;
													$commission_total += $count_boy + $count_girl;
												} ?></td>

											<td><?php echo $total; ?></td>

											<!-- <td><?php $total = ($total == 0) ? 1 : $total;
														print((round($aTotal / $total, 2) * 100) . "%");
														?></td> -->
											<?php if ($countyType == 'all') : ?>
												<td><a class="btn btn-info" href="<?php echo site_url('report/counseling_identity_count_report_yda_table/' . $yearType . '/' . $monthType . '/' . $counties[$j]['no']); ?>">審核</a></td>
												<td> <?php echo ($isOverTimeArray[$j] == 1) ? '遲交' : '準時'; ?></td>
										<?php endif;
										} ?>
									</tr>
								<?php } ?>
								<tr>
									<td>合計</td>

									<td><?php echo $commission_B_boy + $self_B_boy ?></td>
									<td><?php echo $commission_B_girl + $self_B_girl ?></td>
									<td><?php echo $commission_B_boy + $self_B_boy + $commission_B_girl + $self_B_girl ?></td>
									<td><?php echo $commission_C1_boy + $self_C1_boy ?></td>
									<td><?php echo $commission_C1_girl + $self_C1_girl ?></td>
									<td><?php echo $commission_C2_boy + $self_C2_boy ?></td>
									<td><?php echo $commission_C2_girl + $self_C2_girl ?></td>
									<td><?php echo $commission_C1_boy + $self_C1_boy + $commission_C1_girl + $self_C1_girl + $commission_C2_boy + $self_C2_boy + $commission_C2_girl + $self_C2_girl ?></td>
									<td><?php echo $commission_D_boy + $self_D_boy ?></td>
									<td><?php echo $commission_D_girl + $self_D_girl ?></td>
									<td><?php echo $commission_D_boy + $self_D_boy + $commission_D_girl + $self_D_girl ?></td>
									<td><?php echo $commission_B_boy + $self_B_boy + $commission_B_girl + $self_B_girl + $commission_C1_boy + $self_C1_boy + $commission_C1_girl + $self_C1_girl + $commission_C2_boy + $self_C2_boy + $commission_C2_girl + $self_C2_girl + $commission_D_boy + $self_D_boy + $commission_D_girl + $self_D_girl ?></td>
									<?php
									$tempTotal = $commission_B_boy + $self_B_boy + $commission_B_girl + $self_B_girl + $commission_C1_boy + $self_C1_boy + $commission_C1_girl + $self_C1_girl + $commission_C2_boy + $self_C2_boy + $commission_C2_girl + $self_C2_girl + $commission_D_boy + $self_D_boy + $commission_D_girl + $self_D_girl;
									$tempTotal = ($tempTotal == 0) ? 1 : $tempTotal;
									?>
									<!-- <td><?php echo round(($commission_A_boy + $self_A_boy + $commission_A_girl + $self_A_girl) / $tempTotal, 2) * 100 ?>%</td> -->
									<?php if ($countyType == 'all') : ?>
										<td></td>
										<td></td>

									<?php endif; ?>
								</tr>
								<tr>
									<td>委辦</td>

									<td><?php echo $commission_B_boy ?></td>
									<td><?php echo $commission_B_girl ?></td>
									<td><?php echo $commission_B_boy + $commission_B_girl ?></td>
									<td><?php echo $commission_C1_boy ?></td>
									<td><?php echo $commission_C1_girl ?></td>
									<td><?php echo $commission_C2_boy ?></td>
									<td><?php echo $commission_C2_girl ?></td>
									<td><?php echo $commission_C1_boy + $commission_C1_girl + $commission_C2_boy + $commission_C2_girl ?></td>
									<td><?php echo $commission_D_boy ?></td>
									<td><?php echo $commission_D_girl ?></td>
									<td><?php echo $commission_D_boy + $commission_D_girl ?></td>
									<td><?php echo $commission_B_boy + $commission_B_girl + $commission_C1_boy + $commission_C1_girl + $commission_C2_boy + $commission_C2_girl + $commission_D_boy + $commission_D_girl ?></td>
									<?php
									$tempTotal = $commission_B_boy + $commission_B_girl + $commission_C1_boy + $commission_C1_girl + $commission_C2_boy + $commission_C2_girl + $commission_D_boy + $commission_D_girl;
									$tempTotal = ($tempTotal == 0) ? 1 : $tempTotal;
									?>
									<!-- <td><?php echo round(($commission_A_boy + $commission_A_girl) / $tempTotal, 2) * 100 ?>%</td> -->
									<?php if ($countyType == 'all') : ?>
										<td></td>
										<td></td>

									<?php endif; ?>
								</tr>
								<tr>
									<td>自辦</td>

									<td><?php echo $self_B_boy ?></td>
									<td><?php echo $self_B_girl ?></td>
									<td><?php echo $self_B_boy + $self_B_girl ?></td>
									<td><?php echo $self_C1_boy ?></td>
									<td><?php echo $self_C1_girl ?></td>
									<td><?php echo $self_C2_boy ?></td>
									<td><?php echo $self_C2_girl ?></td>
									<td><?php echo $self_C1_boy + $self_C1_girl + $self_C2_boy + $self_C2_girl ?></td>
									<td><?php echo $self_D_boy ?></td>
									<td><?php echo $self_D_girl ?></td>
									<td><?php echo $self_D_boy + $self_D_girl ?></td>
									<td><?php echo $self_B_boy + $self_B_girl + $self_C1_boy + $self_C1_girl + $self_C2_boy + $self_C2_girl + $self_D_boy + $self_D_girl ?></td>
									<?php
									$tempTotal = $self_B_boy + $self_B_girl + $self_C1_boy + $self_C1_girl + $self_C2_boy + $self_C2_girl + $self_D_boy + $self_D_girl;
									$tempTotal = ($tempTotal == 0) ? 1 : $tempTotal;
									?>
									<!-- <td><?php echo round(($self_A_boy + $self_A_girl) / $tempTotal, 2) * 100 ?>%</td> -->
									<?php if ($countyType == 'all') : ?>
										<td></td>
										<td></td>

									<?php endif; ?>
								</tr>
								<tr>
									<?php $commission_total = ($commission_total == 0) ? 1 : $commission_total; ?>
									<td>百分比</td>

									<td><?php echo round(($commission_B_boy + $self_B_boy) / ($commission_total + $self_total), 2) * 100 ?>%</td>
									<td><?php echo round(($commission_B_girl + $self_B_girl) / ($commission_total + $self_total), 2) * 100 ?>%</td>
									<td><?php echo round(($commission_B_boy + $self_B_boy + $commission_B_girl + $self_B_girl) / ($commission_total + $self_total), 2) * 100 ?>%</td>
									<td><?php echo round(($commission_C1_boy + $self_C1_boy) / ($commission_total + $self_total), 2) * 100 ?>%</td>
									<td><?php echo round(($commission_C1_girl + $self_C1_girl) / ($commission_total + $self_total), 2) * 100 ?>%</td>
									<td><?php echo round(($commission_C2_boy + $self_C2_boy) / ($commission_total + $self_total), 2) * 100 ?>%</td>
									<td><?php echo round(($commission_C2_girl + $self_C2_girl) / ($commission_total + $self_total), 2) * 100 ?>%</td>
									<td><?php echo round(($commission_C1_boy + $self_C1_boy + $commission_C1_girl + $self_C1_girl + $commission_C2_boy + $self_C2_boy + $commission_C2_girl + $self_C2_girl) / ($commission_total + $self_total), 2) * 100 ?>%</td>
									<td><?php echo round(($commission_D_boy + $self_D_boy) / ($commission_total + $self_total), 2) * 100 ?>%</td>
									<td><?php echo round(($commission_D_girl + $self_D_girl) / ($commission_total + $self_total), 2) * 100 ?>%</td>
									<td><?php echo round(($commission_D_boy + $self_D_boy + $commission_D_girl + $self_D_girl) / ($commission_total + $self_total), 2) * 100 ?>%</td>
									<td>100%</td>

									<?php if ($countyType == 'all') : ?>
										<td></td>
										<td></td>

									<?php endif; ?>
								</tr>
							</tbody>
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
								<?php if (!empty($get_all_inserted_identity_count_data_array[$i]->report_file_name)) : ?>
									<?php if (strpos($get_all_inserted_identity_count_data_array[$i]->report_file_name, 'pdf') !== false) : ?>
										<a class="col-sm-10 col-md-8 link-primary" href="<?php echo site_url() . '/files/' . $get_all_inserted_identity_count_data_array[$i]->report_file_name; ?>" download="<?php echo $yearType . '年' . $monthType . '月' . $counties[0]['name'] ?>"><?php echo $yearType . '年' . $monthType . '月' . $counties[0]['name'] . '-' . $title ?></a>
									<?php else : ?>
										<div class="col-sm-10 col-md-8">
											<img class="figure-img img-fluid" src="<?php echo site_url() . '/files/' . $get_all_inserted_identity_count_data_array[$i]->report_file_name; ?>" />
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
			if ((i - 3) % 4 == 0 || i == 0 || i == 1) {
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
