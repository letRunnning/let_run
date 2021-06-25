<?php $this->load->view('templates/new_header'); ?>
<div class="breadcrumb-div">
	<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item active" style="color:blue;" aria-current="page">
				<a href="<?php echo site_url('/user/index'); ?>" <?php echo $url == '/user/index' ? 'active' : ''; ?>>首頁</a>
			</li>
			<li class="breadcrumb-item active" style="color:blue;" aria-current="page">
				<a href="#"><?php echo '報表管理';?></a>
			</li>
			<li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
		</ol>
	</nav>
</div>
<div class="container" style="width:100%;">
	<div class="row">
		<div class="card-body col-sm-12">
			<h4 class="card-title text-center"><?php echo $title ?></h4>
			<div class="card-content">

				<!-- years -->
				<div class="row justify-content-center">
					<div class="col-sm-10 col-md-8">
						<label>年度</label>
						<select class="form-select form-select-lg mb-3" name="years" id="years" onchange="location = this.value;">
							<?php foreach ($years as $i) { ?>
								<option <?php echo ($yearType == ($i['year'])) ? 'selected' : '' ?> value="<?php echo site_url($url . $i['year'] . '/' . $monthType . '/' . $countyType); ?>"><?php echo $i['year'] ?></option>
							<?php } ?>
						</select>

					</div>
				</div>

				<!-- months -->
				<div class="row justify-content-center">
					<div class="col-sm-10 col-md-8">
						<label>月份</label>
						<select class="form-select form-select-lg mb-3" name="months" id="months" onchange="location = this.value;">

							<?php foreach ($months as $i) { ?>

								<option <?php echo ($monthType == $i) ? 'selected' : '' ?> value="<?php echo site_url($url . $yearType . '/' . $i . '/' . $countyType); ?>"><?php echo $i ?></option>
							<?php } ?>

						</select>

					</div>
				</div>

				<?php if ($role == 1) : ?>

					<!-- county -->
					<div class="row justify-content-center">
						<div class="col-sm-10 col-md-8">
							<label>縣市</label>
							<select class="form-select form-select-lg mb-3" name="counties" id="counties" onchange="location = this.value;">

								<?php foreach ($counties as $i) { ?>

									<option <?php echo ($countyType == $i['no']) ? 'selected' : '' ?> value="<?php echo site_url($url . $yearType . '/' . $monthType . '/' . $i['no']); ?>"><?php echo $i['name'] ?></option>
								<?php } ?>

							</select>
						</div>
					</div>
				<?php endif; ?>

				<?php if ($role == 2 || $role == 3 || $role == 4 || $role == 5) : ?>
					<a class="btn btn-success" href="<?php echo site_url('export/organization_month_report_export/' . 'all' . '/' . $yearType . '/' . $monthType); ?>">列印(下載EXCEL檔)</a><br /><br />
				<?php elseif ($role == 1 || $role == 8 || $role == 9) : ?>
					<a class="btn btn-success" href="<?php echo site_url('export/yda_month_report_export/' . 'all' . '/' . $yearType . '/' . $monthType); ?>">列印(下載EXCEL檔)</a>
					<br /><br />
				<?php endif; ?>

				<table class="table table-hover align-middle text-center">
					<thead>
						<tr>
							<th scope="col">表單</th>
							<?php if ($role == 6) : ?>
								<th scope="col">完成度</th>


							<?php endif; ?>
							<th scope="col">要項</th>

							<?php if ($role == 1 || $role == 8 || $role == 9) { ?>
								<th scope="col">即時數據</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>表一.輔導人數統計表/執行進度表</td>
							<?php if ($role == 6) : ?>
								<td><?php echo $counselingMemberCountReportCompletionRate ?>%</td>
							<?php endif; ?>
							<td>
								<?php if ($role == 6) : ?>
									<a class="btn btn-info" href="<?php echo site_url('/report/counseling_member_count_report/' . $yearType . '/' . $monthType); ?>">新增/修改</a>

								<?php elseif ($role == 4 || $role == 5 || $role == 3 || $role == 2) : ?>
									<a class="btn btn-info" href="<?php echo site_url('/report/counseling_member_count_report_organization_table/' . $yearType . '/' . $monthType); ?>">查看</a>

								<?php elseif ($role == 1 || $role == 8 || $role == 9) : ?>
									<a class="btn btn-info" href="<?php echo site_url('/report/counseling_member_count_report_yda_table/' . $yearType . '/' . $monthType); ?>">查看</a>

								<?php endif; ?>
							</td>
							<?php if ($role == 1 || $role == 8 || $role == 9) : ?>
								<td>

									<a class="btn btn-info" href="<?php echo site_url('/report/yda_month_report_table/counselingMemberCountReport/' . $yearType . '/' . $monthType); ?>">查看</a>

								</td>
							<?php endif; ?>
						</tr>

						<tr>
							<td>表二.輔導對象身分別統計</td>
							<?php if ($role == 6) : ?>
								<td><?php echo $counselingIdentityCountReportCompletionRate ?>%</td>

							<?php endif ?>
							<td>
								<?php if ($role == 6) : ?>
									<a class="btn btn-info" href="<?php echo site_url('/report/counseling_identity_count_report/' . $yearType . '/' . $monthType); ?>">新增/修改</a>

								<?php elseif ($role == 2 || $role == 3 || $role == 4 || $role == 5) : ?>
									<a class="btn btn-info" href="<?php echo site_url('/report/counseling_identity_count_report_table/' . $yearType . '/' . $monthType); ?>">查看</a>
								<?php elseif ($role == 1 || $role == 8 || $role == 9) : ?>
									<a class="btn btn-info" href="<?php echo site_url('/report/counseling_identity_count_report_yda_table/' . $yearType . '/' . $monthType); ?>">查看</a>
								<?php endif; ?>
							</td>
							<?php if ($role == 1 || $role == 8 || $role == 9) : ?>
								<td>

									<a class="btn btn-info" href="<?php echo site_url('/report/yda_month_report_table/counselingIdentityCountReport/' . $yearType . '/' . $monthType); ?>">查看</a>

								</td>
							<?php endif; ?>
						</tr>

						<tr>
							<td>表三.跨局處會議/預防性講座場次/人次統計</td>
							<?php if ($role == 6) : ?>
								<td><?php echo $meetingCountReportCompletionRate ?>%</td>

							<?php endif; ?>
							<td>
								<?php if ($role == 6) : ?>
									<a class="btn btn-info" href="<?php echo site_url('/report/counseling_meeting_count_report/' . $yearType . '/' . $monthType); ?>">新增/修改</a>

								<?php elseif ($role == 4 || $role == 5 || $role == 3 || $role == 2) : ?>
									<a class="btn btn-info" href="<?php echo site_url('/report/counseling_meeting_count_report_table/' . $yearType . '/' . $monthType); ?>">查看</a>
								<?php elseif ($role == 1 || $role == 8 || $role == 9) : ?>
									<a class="btn btn-info" href="<?php echo site_url('/report/counseling_meeting_count_report_yda_table/' . $yearType . '/' . $monthType); ?>">查看</a>
								<?php endif; ?>
							</td>
							<?php if ($role == 1 || $role == 8 || $role == 9) : ?>
								<td>

									<a class="btn btn-info" href="<?php echo site_url('/report/yda_month_report_table/counselingMeetingCountReport/' . $yearType . '/' . $monthType); ?>">查看</a>

								</td>
							<?php endif; ?>
						</tr>


						<tr>
							<td>表四.輔導人力概況表</td>
							<?php if ($role == 6) : ?>
								<td><?php echo $counselorManpowerReportCompletionRate ?>%</td>

							<?php endif; ?>
							<td>
								<?php if ($role == 6) : ?>
									<a class="btn btn-info" href="<?php echo site_url('/report/counselor_manpower_report/' . $yearType . '/' . $monthType); ?>">新增/修改</a>

								<?php elseif ($role == 4 || $role == 5 || $role == 3 || $role == 2) : ?>
									<a class="btn btn-info" href="<?php echo site_url('/report/counselor_manpower_report_organization_table/' . $yearType . '/' . $monthType); ?>">查看</a>

								<?php elseif ($role == 1 || $role == 8 || $role == 9) : ?>
									<a class="btn btn-info" href="<?php echo site_url('/report/counselor_manpower_report_yda_table/' . $yearType . '/' . $monthType); ?>">查看</a>

								<?php endif; ?>
							</td>
							<?php if ($role == 1 || $role == 8 || $role == 9) : ?>
								<td>

									<a class="btn btn-info" href="<?php echo site_url('/report/yda_month_report_table/counselorManpowerCountReport/' . $yearType . '/' . $monthType); ?>">查看</a>

								</td>
							<?php endif; ?>
						</tr>

						<?php if ($role == 1 || $role == 8) : ?>


							<tr>
								<td>經費執行情形表</td>
								<td>
									<a class="btn btn-info" href="<?php echo site_url('/report/funding_execute_report_yda_table/' . $yearType . '/' . $monthType); ?>">查看</a>

								</td>
							</tr>

							<tr>
								<td>回傳情形紀錄表</td>
								<td>
									<a class="btn btn-info" href="<?php echo site_url('/report/timing_report_yda_table/' . $yearType . '/' . $monthType); ?>">查看</a>

								</td>
							</tr>

						<?php endif; ?>

						<?php if ($monthType % 3 == 0) : ?>
							<tr>
								<td>表五.<?php echo $yearType - 4 ?>年動向調查追蹤</td>
								<?php if ($role == 6) : ?>
									<td><?php echo $twoYearsTrendSurveyCountReportCompletionRate ?>%</td>

								<?php endif; ?>
								<td>
									<?php if ($role == 6) : ?>
										<a class="btn btn-info" href="<?php echo site_url('/report/two_years_trend_survey_count_report/' . $yearType . '/' . $monthType); ?>">新增/修改</a>

									<?php elseif ($role == 4 || $role == 5 || $role == 3 || $role == 2) : ?>
										<a class="btn btn-info" href="<?php echo site_url('/report/two_years_trend_survey_count_report_organization_table/' . $yearType . '/' . $monthType); ?>">查看</a>

									<?php elseif ($role == 1 || $role == 8 || $role == 9) : ?>
										<a class="btn btn-info" href="<?php echo site_url('/report/two_years_trend_survey_count_report_yda_table/' . $yearType . '/' . $monthType); ?>">查看</a>

									<?php endif; ?>
								</td>
								<?php if ($role == 1 || $role == 8 || $role == 9) : ?>
									<td>

										<a class="btn btn-info" href="<?php echo site_url('/report/yda_month_report_table/twoYearsTrendSurveyCountReport/' . $yearType . '/' . $monthType); ?>">查看</a>

									</td>
								<?php endif; ?>
							</tr>

							<tr>
								<td>表六.<?php echo $yearType - 3 ?>年動向調查追蹤</td>
								<?php if ($role == 6) : ?>
									<td><?php echo $oneYearsTrendSurveyCountReportCompletionRate ?>%</td>

								<?php endif; ?>
								<td>
									<?php if ($role == 6) : ?>
										<a class="btn btn-info" href="<?php echo site_url('/report/one_years_trend_survey_count_report/' . $yearType . '/' . $monthType); ?>">新增/修改</a>

									<?php elseif ($role == 4 || $role == 5 || $role == 3 || $role == 2) : ?>
										<a class="btn btn-info" href="<?php echo site_url('/report/one_years_trend_survey_count_report_organization_table/' . $yearType . '/' . $monthType); ?>">查看</a>

									<?php elseif ($role == 1 || $role == 8 || $role == 9) : ?>
										<a class="btn btn-info" href="<?php echo site_url('/report/one_years_trend_survey_count_report_yda_table/' . $yearType . '/' . $monthType); ?>">查看</a>

									<?php endif; ?>
								</td>
								<?php if ($role == 1 || $role == 8 || $role == 9) : ?>
									<td>

										<a class="btn btn-info" href="<?php echo site_url('/report/yda_month_report_table/oneYearsTrendSurveyCountReport/' . $yearType . '/' . $monthType); ?>">查看</a>

									</td>
								<?php endif; ?>
							</tr>

							<tr>
								<td>表七.<?php echo $yearType - 2 ?>年動向調查追蹤</td>
								<?php if ($role == 6) : ?>
									<td><?php echo $nowYearsTrendSurveyCountReportCompletionRate ?>%</td>

								<?php endif; ?>
								<td>
									<?php if ($role == 6) : ?>
										<a class="btn btn-info" href="<?php echo site_url('/report/now_years_trend_survey_count_report/' . $yearType . '/' . $monthType); ?>">新增/修改</a>

									<?php elseif ($role == 4 || $role == 5 || $role == 3 || $role == 2) : ?>
										<a class="btn btn-info" href="<?php echo site_url('/report/now_years_trend_survey_count_report_organization_table/' . $yearType . '/' . $monthType); ?>">查看</a>

									<?php elseif ($role == 1 || $role == 8 || $role == 9) : ?>
										<a class="btn btn-info" href="<?php echo site_url('/report/now_years_trend_survey_count_report_yda_table/' . $yearType . '/' . $monthType); ?>">查看</a>
									<?php endif; ?>
								</td>
								<?php if ($role == 1 || $role == 8 || $role == 9) : ?>
									<td>

										<a class="btn btn-info" href="<?php echo site_url('/report/yda_month_report_table/nowYearsTrendSurveyCountReport/' . $yearType . '/' . $monthType); ?>">查看</a>

									</td>
								<?php endif; ?>
							</tr>

							<tr>
								<td>表八.前一年結案後動向調查追蹤</td>
								<?php if ($role == 6) : ?>
									<td><?php echo $oldCaseTrendSurveyCountReportCompletionRate ?>%</td>

								<?php endif; ?>
								<td>
									<?php if ($role == 6) : ?>
										<a class="btn btn-info" href="<?php echo site_url('/report/old_case_trend_survey_count_report/' . $yearType . '/' . $monthType); ?>">新增/修改</a>

									<?php elseif ($role == 4 || $role == 5 || $role == 3 || $role == 2) : ?>
										<a class="btn btn-info" href="<?php echo site_url('/report/old_case_trend_survey_count_report_organization_table/' . $yearType . '/' . $monthType); ?>">查看</a>
									<?php elseif ($role == 1 || $role == 8 || $role == 9) : ?>
										<a class="btn btn-info" href="<?php echo site_url('/report/old_case_trend_survey_count_report_yda_table/' . $yearType . '/' . $monthType); ?>">查看</a>
									<?php endif; ?>
								</td>
								<?php if ($role == 1 || $role == 8 || $role == 9) : ?>
									<td>

										<a class="btn btn-info" href="<?php echo site_url('/report/yda_month_report_table/oldCaseTrendSurveyCountReport/' . $yearType . '/' . $monthType); ?>">查看</a>

									</td>
								<?php endif; ?>
							</tr>
							<tr>
								<td>表九.高中已錄取未註冊動向調查追蹤</td>
								<?php if ($role == 6): ?>
									<td><?php echo $highSchoolTrendSurveyCountReportCompletionRate ?>%</td>
									
									<?php endif;?>
									<td>
									<?php if ($role == 6): ?>
										<a class="btn btn-info"
										href="<?php echo site_url('/report/high_school_trend_survey_count_report/' . $yearType . '/' . $monthType); ?>">新增/修改</a>

										<?php elseif ($role == 4 || $role == 5 || $role == 3 || $role == 2): ?>
										<a class="btn btn-info"
										href="<?php echo site_url('/report/high_school_trend_survey_count_report_organization_table/' . $yearType . '/' . $monthType); ?>">查看</a>
										<?php elseif ($role == 1 || $role == 8 || $role == 9): ?>
										<a class="btn btn-info"
										href="<?php echo site_url('/report/high_school_trend_survey_count_report_yda_table/' . $yearType . '/' . $monthType); ?>">查看</a>
									<?php endif;?>
									</td>
								<?php if ($role == 1 || $role == 8 || $role == 9): ?>
								<td>
							
								<a class="btn btn-info"
								href="<?php echo site_url('/report/yda_month_report_table/highSchoolTrendSurveyCountReport/' . $yearType . '/' . $monthType); ?>">查看</a>
							
							</td>
						<?php endif;?>
						</tr>

						<?php endif; ?>


					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('templates/new_footer'); ?>
